<?php
/**
 * Page Content Fields - meta box for page structured content (front page + template pages).
 * WordPress core only; no plugins.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/page-meta-definitions.php';

const RESTWELL_META_NONCE_ACTION = 'restwell_page_content_fields_save';
const RESTWELL_META_NONCE_NAME   = 'restwell_page_content_fields_nonce';

/**
 * Register meta box "Page Content Fields" for pages.
 */
function restwell_register_page_content_meta_box() {
	add_meta_box(
		'restwell_page_content_fields',
		__( 'Page Content Fields', 'restwell-retreats' ),
		'restwell_page_content_meta_box_callback',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'restwell_register_page_content_meta_box' );

/**
 * Enqueue WordPress media modal on page edit screens only.
 */
function restwell_enqueue_media_for_page_edit() {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type || ! in_array( $screen->base, array( 'post', 'post-new' ), true ) ) {
		return;
	}
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'restwell_enqueue_media_for_page_edit' );

/**
 * Meta box callback: output all input fields in a tabbed interface.
 */
function restwell_page_content_meta_box_callback( $post ) {
	wp_nonce_field( RESTWELL_META_NONCE_ACTION, RESTWELL_META_NONCE_NAME );

	$fields  = restwell_get_page_content_field_definitions( $post );
	$current = get_post_meta( $post->ID, '', true );
	$index   = 0;

	?>
	<style>
		.restwell-meta-fields .nav-tab-wrapper { margin-bottom: 0; border-bottom: 1px solid #c3c4c7; }
		.restwell-meta-fields .restwell-tab-panel { display: none; padding: 1.25rem 0 0; border-top: none; }
		.restwell-meta-fields .restwell-tab-panel.active { display: block; }
		.restwell-meta-fields .restwell-field { margin-bottom: 1.25rem; }
		.restwell-meta-fields .restwell-field:last-child { margin-bottom: 0; }
		.restwell-meta-fields .restwell-field label { display: block; font-weight: 600; margin-bottom: 0.35rem; color: #1d2327; }
		.restwell-meta-fields .restwell-field input[type="text"],
		.restwell-meta-fields .restwell-field input[type="number"] { width: 100%; max-width: 32rem; padding: 0.5rem 0.75rem; font-size: 14px; }
		.restwell-meta-fields .restwell-field input[type="number"] { max-width: 8rem; }
		.restwell-meta-fields .restwell-field textarea { width: 100%; min-height: 100px; padding: 0.5rem 0.75rem; font-size: 14px; line-height: 1.5; resize: vertical; }
		.restwell-meta-fields .restwell-image-preview { margin-bottom: 10px; }
		.restwell-meta-fields .restwell-image-preview img { max-width: 100%; height: auto; max-height: 200px; border-radius: 4px; border: 1px solid #c3c4c7; display: block; }
		.restwell-meta-fields .restwell-image-preview .restwell-media-preview-text { display: inline-block; padding: 0.5rem 0; color: #1d2327; }
		.restwell-meta-fields .restwell-image-upload .button { margin-right: 8px; margin-top: 4px; }
		.restwell-meta-fields .restwell-remove-image { color: #b32d2e !important; }
	</style>

	<div class="restwell-meta-fields" data-post-id="<?php echo esc_attr( (string) $post->ID ); ?>">
		<h2 class="nav-tab-wrapper">
			<?php
			foreach ( array_keys( $fields ) as $section ) {
				$panel_id = 'restwell-panel-' . $index;
				$active   = ( 0 === $index ) ? ' nav-tab-active' : '';
				echo '<a href="#' . esc_attr( $panel_id ) . '" class="nav-tab restwell-nav-tab' . esc_attr( $active ) . '" data-panel="' . esc_attr( $panel_id ) . '" role="tab">' . esc_html( $section ) . '</a>';
				$index++;
			}
			$index = 0;
			?>
		</h2>

		<?php
		foreach ( $fields as $section => $items ) {
			$panel_id = 'restwell-panel-' . $index;
			$active   = ( 0 === $index ) ? ' active' : '';
			echo '<div id="' . esc_attr( $panel_id ) . '" class="restwell-tab-panel' . esc_attr( $active ) . '" role="tabpanel" aria-label="' . esc_attr( $section ) . '">';

			foreach ( $items as $key => $label ) {
				$value = isset( $current[ $key ][0] ) ? $current[ $key ][0] : '';
				$id    = 'restwell_' . $key;
				$name  = $key;
				echo '<div class="restwell-field">';

				if ( $key === 'meta_description' || $key === 'hero_spec_heading' || $key === 'hero_cta_reassurance' || strpos( $key, '_body' ) !== false || strpos( $key, '_desc' ) !== false || strpos( $key, '_intro' ) !== false || strpos( $key, '_confirmed' ) !== false || strpos( $key, '_tbc' ) !== false ) {
					echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
					echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" rows="5">' . esc_textarea( $value ) . '</textarea>';
				} elseif ( strpos( $key, '_image_id' ) !== false || $key === 'hero_media_id' ) {
					$img_value   = absint( $value );
					$img_url     = $img_value ? wp_get_attachment_image_url( $img_value, 'medium' ) : '';
					$mime_type   = $img_value ? get_post_mime_type( $img_value ) : '';
					$is_video    = $mime_type && strpos( $mime_type, 'video/' ) === 0;
					$preview_show = $img_value ? '' : ' style="display:none;"';
					$remove_show  = $img_value ? '' : ' style="display:none;"';
					// Interior page heroes: same as front-page hero — image or background video.
					$allows_video = ( $key === 'hero_media_id' || strpos( $key, 'hero_image_id' ) !== false );
					$allowed      = $allows_video ? ' data-allowed-types="image,video"' : ' data-allowed-types="image"';
					$preview_src  = $img_url ? esc_url( $img_url ) : '';
					$preview_text = $is_video ? esc_html__( 'Video selected', 'restwell-retreats' ) : '';
					$input_id = $id . '_value';
					echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
					echo '<div class="restwell-image-upload restwell-media-upload"' . $allowed . '>';
					echo '<input type="hidden" id="' . esc_attr( $input_id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
					echo '<div class="restwell-image-preview"' . $preview_show . '>';
					if ( $allows_video ) {
						echo '<img src="' . $preview_src . '" alt="" style="' . ( $is_video ? 'display:none;' : '' ) . '" />';
						echo '<span class="restwell-media-preview-text" style="' . ( $is_video ? '' : 'display:none;' ) . '">' . $preview_text . '</span>';
					} else {
						echo '<img src="' . $preview_src . '" alt="" />';
					}
					echo '</div>';
					$select_btn_text = $allows_video ? __( 'Select image or video', 'restwell-retreats' ) : __( 'Select Image', 'restwell-retreats' );
					echo '<button type="button" id="' . esc_attr( $id ) . '" class="button button-secondary restwell-select-image">' . esc_html( $select_btn_text ) . '</button>';
					echo '<button type="button" class="button button-link restwell-remove-image"' . $remove_show . '>' . esc_html__( 'Remove', 'restwell-retreats' ) . '</button>';
					echo '</div>';
				} else {
					echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
					echo '<input type="text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
				}
				echo '</div>';
			}
			echo '</div>';
			$index++;
		}
		?>

		<script>
		(function() {
			var wrapper = document.querySelector('.restwell-meta-fields');
			if (!wrapper) return;
			var tabs = wrapper.querySelectorAll('.restwell-nav-tab');
			var panels = wrapper.querySelectorAll('.restwell-tab-panel');
			tabs.forEach(function(tab) {
				tab.addEventListener('click', function(e) {
					e.preventDefault();
					var panelId = tab.getAttribute('data-panel');
					tabs.forEach(function(t) { t.classList.remove('nav-tab-active'); });
					panels.forEach(function(p) { p.classList.remove('active'); });
					tab.classList.add('nav-tab-active');
					var target = wrapper.querySelector('#' + panelId);
					if (target) target.classList.add('active');
				});
			});

			function initMediaButtons() {
				if (typeof wp === 'undefined' || !wp.media) return;
				var postId = wrapper.getAttribute('data-post-id') ? parseInt(wrapper.getAttribute('data-post-id'), 10) : null;
				wrapper.querySelectorAll('.restwell-select-image').forEach(function(btn) {
					btn.addEventListener('click', function() {
						var upload = this.closest('.restwell-image-upload');
						if (!upload) return;
						var allowed = upload.getAttribute('data-allowed-types') || 'image';
						var frameOpts = { multiple: false };
						if (postId) frameOpts.post = postId;
						if (allowed !== 'image,video') {
							frameOpts.library = { type: 'image' };
						}
						var mediaFrame = wp.media(frameOpts);
						mediaFrame.on('select', function() {
							var selection = mediaFrame.state().get('selection');
							if (!selection.length) return;
							var attachment = selection.first().toJSON();
							var input = upload.querySelector('input[type="hidden"]');
							var preview = upload.querySelector('.restwell-image-preview');
							var img = preview ? preview.querySelector('img') : null;
							var previewText = preview ? preview.querySelector('.restwell-media-preview-text') : null;
							var removeBtn = upload.querySelector('.restwell-remove-image');
							if (input) input.value = attachment.id;
							if (preview) preview.style.display = 'block';
							if (removeBtn) removeBtn.style.display = 'inline-block';
							var isVideo = attachment.type === 'video' || (attachment.mimeType && attachment.mimeType.indexOf('video/') === 0);
							if (isVideo && previewText) {
								previewText.textContent = 'Video selected';
								previewText.style.display = '';
								if (img) img.style.display = 'none';
							} else if (img) {
								img.src = (attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url) ? attachment.sizes.medium.url : (attachment.url || '');
								img.style.display = '';
								if (previewText) previewText.style.display = 'none';
							}
						});
						mediaFrame.open();
					});
				});
				wrapper.querySelectorAll('.restwell-remove-image').forEach(function(btn) {
					btn.addEventListener('click', function() {
						var upload = this.closest('.restwell-image-upload');
						if (!upload) return;
						var input = upload.querySelector('input[type="hidden"]');
						var preview = upload.querySelector('.restwell-image-preview');
						var img = preview ? preview.querySelector('img') : null;
						var previewText = preview ? preview.querySelector('.restwell-media-preview-text') : null;
						if (input) input.value = '';
						if (img) { img.removeAttribute('src'); img.style.display = ''; }
						if (previewText) previewText.style.display = 'none';
						if (preview) preview.style.display = 'none';
						this.style.display = 'none';
					});
				});
			}
			if (typeof wp !== 'undefined' && wp.media) {
				initMediaButtons();
			} else {
				var attempts = 0;
				function tryInit() {
					if (typeof wp !== 'undefined' && wp.media) {
						initMediaButtons();
					} else if (attempts < 40) {
						attempts++;
						setTimeout(tryInit, 50);
					}
				}
				window.addEventListener('load', tryInit);
			}
		})();
		</script>
	</div>
	<?php
}

/**
 * Save meta box: verify nonce and sanitize all fields for this page's template.
 */
function restwell_save_page_content_meta_box( $post_id ) {
	if ( ! isset( $_POST[ RESTWELL_META_NONCE_NAME ] ) ||
	     ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ RESTWELL_META_NONCE_NAME ] ) ), RESTWELL_META_NONCE_ACTION ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post   = get_post( $post_id );
	$fields = restwell_get_page_content_field_definitions( $post );
	foreach ( $fields as $items ) {
		foreach ( array_keys( $items ) as $key ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				continue;
			}
			$raw = wp_unslash( $_POST[ $key ] );
			if ( strpos( $key, '_image_id' ) !== false || $key === 'hero_media_id' ) {
				$value = absint( $raw );
			} elseif ( $key === 'meta_description' || $key === 'hero_spec_heading' || $key === 'hero_cta_reassurance' || strpos( $key, '_body' ) !== false || strpos( $key, '_desc' ) !== false || strpos( $key, '_intro' ) !== false || strpos( $key, '_confirmed' ) !== false || strpos( $key, '_tbc' ) !== false ) {
				$value = sanitize_textarea_field( $raw );
			} else {
				$value = sanitize_text_field( $raw );
			}
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_page', 'restwell_save_page_content_meta_box' );
