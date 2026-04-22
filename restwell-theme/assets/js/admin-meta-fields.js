/**
 * Admin meta fields – tab switching, localStorage persistence, and media upload.
 *
 * @package Restwell_Retreats
 */
( function () {
	var wrapper = document.querySelector( '.restwell-meta-fields' );
	if ( ! wrapper ) return;

	var tabs    = wrapper.querySelectorAll( '.restwell-nav-tab' );
	var panels  = wrapper.querySelectorAll( '.restwell-tab-panel' );
	var postId  = wrapper.getAttribute( 'data-post-id' ) || '0';
	var storeKey = 'restwell_tab_' + postId;

	/**
	 * Activate a specific tab by its panel ID.
	 *
	 * @param {string} panelId
	 */
	function activateTab( panelId ) {
		tabs.forEach( function ( t ) { t.classList.remove( 'nav-tab-active' ); } );
		panels.forEach( function ( p ) { p.classList.remove( 'active' ); } );

		var matchTab = wrapper.querySelector( '.restwell-nav-tab[data-panel="' + panelId + '"]' );
		var matchPanel = wrapper.querySelector( '#' + panelId );

		if ( matchTab ) matchTab.classList.add( 'nav-tab-active' );
		if ( matchPanel ) matchPanel.classList.add( 'active' );
	}

	// Restore persisted tab on load.
	var saved = '';
	try {
		saved = localStorage.getItem( storeKey ) || '';
	} catch ( e ) { /* private browsing */ }
	if ( saved ) {
		activateTab( saved );
	}

	// Handle tab clicks.
	tabs.forEach( function ( tab ) {
		tab.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			var panelId = tab.getAttribute( 'data-panel' );
			activateTab( panelId );
			try {
				localStorage.setItem( storeKey, panelId );
			} catch ( e ) { /* private browsing */ }
		} );
	} );

	// Media upload buttons.
	function initMediaButtons() {
		if ( typeof wp === 'undefined' || ! wp.media ) return;
		var parsedPostId = postId ? parseInt( postId, 10 ) : null;

		wrapper.querySelectorAll( '.restwell-select-image' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var upload = this.closest( '.restwell-image-upload' );
				if ( ! upload ) return;

				var allowed    = upload.getAttribute( 'data-allowed-types' ) || 'image';
				var frameOpts  = { multiple: false };
				if ( parsedPostId ) frameOpts.post = parsedPostId;
				if ( allowed !== 'image,video' ) {
					frameOpts.library = { type: 'image' };
				}

				var mediaFrame = wp.media( frameOpts );
				mediaFrame.on( 'select', function () {
					var selection = mediaFrame.state().get( 'selection' );
					if ( ! selection.length ) return;

					var attachment  = selection.first().toJSON();
					var input       = upload.querySelector( 'input[type="hidden"]' );
					var preview     = upload.querySelector( '.restwell-image-preview' );
					var img         = preview ? preview.querySelector( 'img' ) : null;
					var previewText = preview ? preview.querySelector( '.restwell-media-preview-text' ) : null;
					var removeBtn   = upload.querySelector( '.restwell-remove-image' );

					if ( input ) input.value = attachment.id;
					if ( preview ) preview.style.display = 'block';
					if ( removeBtn ) removeBtn.style.display = 'inline-block';

					var isVideo = attachment.type === 'video' ||
						( attachment.mimeType && attachment.mimeType.indexOf( 'video/' ) === 0 );

					if ( isVideo && previewText ) {
						previewText.textContent = 'Video selected';
						previewText.style.display = '';
						if ( img ) img.style.display = 'none';
					} else if ( img ) {
						img.src = ( attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url )
							? attachment.sizes.medium.url
							: ( attachment.url || '' );
						img.style.display = '';
						if ( previewText ) previewText.style.display = 'none';
					}
				} );
				mediaFrame.open();
			} );
		} );

		wrapper.querySelectorAll( '.restwell-remove-image' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var upload = this.closest( '.restwell-image-upload' );
				if ( ! upload ) return;

				var input       = upload.querySelector( 'input[type="hidden"]' );
				var preview     = upload.querySelector( '.restwell-image-preview' );
				var img         = preview ? preview.querySelector( 'img' ) : null;
				var previewText = preview ? preview.querySelector( '.restwell-media-preview-text' ) : null;

				if ( input ) input.value = '';
				if ( img ) { img.removeAttribute( 'src' ); img.style.display = ''; }
				if ( previewText ) previewText.style.display = 'none';
				if ( preview ) preview.style.display = 'none';
				this.style.display = 'none';
			} );
		} );
	}

	if ( typeof wp !== 'undefined' && wp.media ) {
		initMediaButtons();
	} else {
		var attempts = 0;
		function tryInit() {
			if ( typeof wp !== 'undefined' && wp.media ) {
				initMediaButtons();
			} else if ( attempts < 40 ) {
				attempts++;
				setTimeout( tryInit, 50 );
			}
		}
		window.addEventListener( 'load', tryInit );
	}
} )();
