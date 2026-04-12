/**
 * Restwell Retreats - header and nav behaviour (vanilla JS, no dependencies).
 */
(function () {
	'use strict';

	function ready(fn) {
		if (document.readyState !== 'loading') {
			fn();
		} else {
			document.addEventListener('DOMContentLoaded', fn);
		}
	}

	function setActiveNavLinks() {
		var path = window.location.pathname.replace(/\/$/, '') || '/';
		var navLinks = document.querySelectorAll('.site-nav a, .mobile-nav a');
		navLinks.forEach(function (link) {
			var href = link.getAttribute('href');
			if (!href || href.indexOf('#') === 0) return;
			var linkPath = href.replace(/^https?:\/\/[^/]+/, '').replace(/\/$/, '') || '/';
			if (linkPath === path) {
				link.classList.add('active');
				link.setAttribute('aria-current', 'page');
			} else {
				link.classList.remove('active');
				link.removeAttribute('aria-current');
			}
		});
	}

	function initStickyHeaderShadow() {
		var header = document.querySelector('.site-header');
		if (!header) return;

		function updateScrolled() {
			if (window.scrollY > 10) {
				header.classList.add('scrolled');
			} else {
				header.classList.remove('scrolled');
			}
		}

		updateScrolled();
		window.addEventListener('scroll', updateScrolled, { passive: true });
	}

	function closeAllNavDropdowns() {
		document.querySelectorAll('.site-nav .site-nav-list li.site-nav__item--has-dropdown.is-open').forEach(function (li) {
			li.classList.remove('is-open');
			var btn = li.querySelector('.site-nav__dropdown-toggle');
			if (btn) {
				btn.setAttribute('aria-expanded', 'false');
			}
			var parentLink = li.querySelector(':scope > a');
			if (parentLink && parentLink.getAttribute('aria-expanded') !== null) {
				parentLink.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/** Parent menu items that only toggle the panel (no navigation). */
	function restwellIsPlaceholderNavHref(href) {
		if (!href) {
			return true;
		}
		var h = String(href).trim();
		if (h === '#' || h === '#0') {
			return true;
		}
		if (/^javascript:/i.test(h)) {
			return true;
		}
		return false;
	}

	/**
	 * Desktop: disclosure-style dropdowns (fallback buttons + WP Primary nested items).
	 */
	function initNavDropdowns() {
		var nav = document.querySelector('.site-nav');
		if (!nav) {
			return;
		}

		var hasFallback = nav.querySelector('[data-nav-dropdown]');
		var hasWpDropdown = nav.querySelector('li.menu-item-has-children > .sub-menu');
		if (!hasFallback && !hasWpDropdown) {
			return;
		}

		var dropdowns = nav.querySelectorAll('[data-nav-dropdown]');
		dropdowns.forEach(function (li) {
			var btn = li.querySelector('.site-nav__dropdown-toggle');
			var menu = li.querySelector('.site-nav__submenu');
			if (!btn || !menu) {
				return;
			}

			btn.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				dropdowns.forEach(function (other) {
					if (other !== li && other.classList.contains('is-open')) {
						other.classList.remove('is-open');
						var ob = other.querySelector('.site-nav__dropdown-toggle');
						if (ob) {
							ob.setAttribute('aria-expanded', 'false');
						}
					}
				});
				nav.querySelectorAll('li.menu-item-has-children.is-open').forEach(function (other) {
					if (!other.hasAttribute('data-nav-dropdown')) {
						other.classList.remove('is-open');
						var oa = other.querySelector(':scope > a');
						if (oa) {
							oa.setAttribute('aria-expanded', 'false');
						}
					}
				});
				var willOpen = !li.classList.contains('is-open');
				li.classList.toggle('is-open', willOpen);
				btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
			});
		});

		nav.querySelectorAll('li.menu-item-has-children').forEach(function (li) {
			if (li.hasAttribute('data-nav-dropdown')) {
				return;
			}
			var sub = li.querySelector(':scope > .sub-menu');
			var parentLink = li.querySelector(':scope > a');
			if (!sub || !parentLink) {
				return;
			}
			parentLink.setAttribute('aria-haspopup', 'true');
			if (parentLink.getAttribute('aria-expanded') === null) {
				parentLink.setAttribute('aria-expanded', 'false');
			}
			parentLink.addEventListener('click', function (e) {
				if (window.matchMedia('(max-width: 1023px)').matches) {
					return;
				}
				if (!restwellIsPlaceholderNavHref(parentLink.getAttribute('href'))) {
					return;
				}
				e.preventDefault();
				e.stopPropagation();
				dropdowns.forEach(function (other) {
					if (other.classList.contains('is-open')) {
						other.classList.remove('is-open');
						var ob = other.querySelector('.site-nav__dropdown-toggle');
						if (ob) {
							ob.setAttribute('aria-expanded', 'false');
						}
					}
				});
				nav.querySelectorAll('li.menu-item-has-children.is-open').forEach(function (other) {
					if (other !== li) {
						other.classList.remove('is-open');
						var oa = other.querySelector(':scope > a');
						if (oa && !other.hasAttribute('data-nav-dropdown')) {
							oa.setAttribute('aria-expanded', 'false');
						}
					}
				});
				var willOpen = !li.classList.contains('is-open');
				li.classList.toggle('is-open', willOpen);
				parentLink.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
			});
		});

		nav.addEventListener('click', function (e) {
			var a = e.target.closest('a');
			if (!a || !a.closest('.site-nav__submenu, .sub-menu')) {
				return;
			}
			closeAllNavDropdowns();
		});

		document.addEventListener('click', function (e) {
			if (!nav.contains(e.target)) {
				closeAllNavDropdowns();
				return;
			}
			if (e.target.closest('.site-nav__dropdown-toggle')) {
				return;
			}
			if (e.target.closest('.site-nav__submenu, .site-nav .sub-menu')) {
				return;
			}
			closeAllNavDropdowns();
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				closeAllNavDropdowns();
			}
		});
	}

	function initMobileMenu() {
		var btn = document.querySelector('.mobile-menu-btn');
		var mobileNav = document.getElementById('mobile-nav');
		var siteHeader = document.querySelector('.site-header');

		if (!btn || !mobileNav) return;

		function isOpen() {
			return mobileNav.classList.contains('is-open');
		}

		function syncMobileNavTop() {
			if (!siteHeader) return;
			var h = Math.round(siteHeader.getBoundingClientRect().height);
			if (h > 0) {
				mobileNav.style.setProperty('--restwell-mobile-nav-top', h + 'px');
			}
		}

		function setMenuOpenState(open) {
			var root = document.documentElement;
			if (open) {
				root.classList.add('restwell-menu-open');
				document.body.classList.add('restwell-menu-open');
			} else {
				root.classList.remove('restwell-menu-open');
				document.body.classList.remove('restwell-menu-open');
			}
		}

		function openMenu() {
			syncMobileNavTop();
			mobileNav.classList.add('is-open');
			mobileNav.removeAttribute('aria-hidden');
			btn.setAttribute('aria-expanded', 'true');
			btn.setAttribute('aria-label', 'Close menu');
			setMenuOpenState(true);
			var firstLink = mobileNav.querySelector('a');
			if (firstLink) {
				firstLink.focus();
			}
		}

		function closeMenu() {
			mobileNav.classList.remove('is-open');
			mobileNav.setAttribute('aria-hidden', 'true');
			btn.setAttribute('aria-expanded', 'false');
			btn.setAttribute('aria-label', 'Open menu');
			setMenuOpenState(false);
		}

		window.addEventListener(
			'resize',
			function () {
				if (isOpen()) {
					syncMobileNavTop();
				}
			},
			{ passive: true }
		);

		function toggleMenu() {
			if (isOpen()) {
				closeMenu();
			} else {
				openMenu();
			}
		}

		btn.addEventListener('click', function (e) {
			e.preventDefault();
			toggleMenu();
		});

		// Close when clicking a mobile nav link
		mobileNav.addEventListener('click', function (e) {
			var anchor = e.target.closest('a');
			if (anchor && isOpen()) {
				closeMenu();
			}
		});

		// Close when clicking outside .site-header
		document.addEventListener('click', function (e) {
			if (!isOpen()) return;
			if (siteHeader && siteHeader.contains(e.target)) return;
			closeMenu();
		});

		// Close on Escape
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && isOpen()) {
				closeMenu();
				btn.focus();
			}
		});
	}

	function initExploreFilter() {
		var container = document.querySelector('.explore-whitstable-filter');
		var list = document.getElementById('explore-whitstable-list');
		var status = document.getElementById('explore-filter-status');
		var emptyState = document.getElementById('explore-empty-state');
		if (!container || !list) return;

		var pills = container.querySelectorAll('.explore-filter-pill');
		var cards = list.querySelectorAll('.explore-card');

		function setActivePill(activePill) {
			pills.forEach(function (p) {
				p.setAttribute('aria-pressed', p === activePill ? 'true' : 'false');
			});
		}

		function filterCards(value) {
			var visible = 0;
			cards.forEach(function (card) {
				var filterAttr = card.getAttribute('data-filter') || '';
				var filters = filterAttr.trim().split(/\s+/);
				var show = value === 'all' || filters.indexOf(value) !== -1;
				card.style.display = show ? '' : 'none';
				if (show) visible++;
			});
			if (status) {
				status.textContent = value === 'all' ? '' : visible === 0
					? 'No places match this filter. Try another or show all.'
					: 'Showing ' + visible + ' ' + (visible === 1 ? 'place' : 'places') + '.';
			}
			if (emptyState) {
				emptyState.style.display = visible === 0 ? 'block' : 'none';
				emptyState.setAttribute('aria-hidden', visible === 0 ? 'false' : 'true');
			}
			list.style.display = visible === 0 ? 'none' : '';
		}

		pills.forEach(function (pill) {
			pill.addEventListener('click', function () {
				var value = pill.getAttribute('data-filter') || 'all';
				setActivePill(pill);
				filterCards(value);
			});
		});

		var showAllBtn = document.querySelector('.explore-filter-show-all');
		if (showAllBtn && pills.length) {
			showAllBtn.addEventListener('click', function () {
				setActivePill(pills[0]);
				filterCards('all');
				pills[0].focus();
			});
		}
	}

	/**
	 * FAQ category filter tabs.
	 * Reads data-category on .faq-item <details> elements and toggles visibility
	 * based on the active .faq-filter-pill[data-filter] button.
	 */
	function initFaqTabs() {
		var filterGroup = document.querySelector('.faq-filter');
		if (!filterGroup) return;

		var pills  = filterGroup.querySelectorAll('.faq-filter-pill');
		var items  = document.querySelectorAll('.faq-list .faq-item[data-category]');
		var status = document.getElementById('faq-filter-status');
		var empty  = document.getElementById('faq-empty-state');

		if (!pills.length || !items.length) return;

		function setActivePill(activePill) {
			pills.forEach(function (p) {
				p.setAttribute('aria-pressed', p === activePill ? 'true' : 'false');
			});
		}

		function filterItems(category) {
			var visible = 0;
			items.forEach(function (item) {
				var cat = item.getAttribute('data-category') || 'about';
				var show = category === 'all' || cat === category;
				item.hidden = !show;
				if (show) visible++;
			});
			if (empty) {
				empty.hidden = visible > 0;
				empty.setAttribute('aria-hidden', visible > 0 ? 'true' : 'false');
			}
			if (status) {
				status.textContent = visible + ' question' + (visible === 1 ? '' : 's') + ' shown';
			}
		}

		pills.forEach(function (pill) {
			pill.addEventListener('click', function () {
				var value = pill.getAttribute('data-filter') || 'all';
				setActivePill(pill);
				filterItems(value);
			});
		});

		// Initialise: "all" active.
		setActivePill(pills[0]);
		filterItems('all');
	}

	/**
	 * Multi-step enquiry form.
	 * Manages step visibility, progress indicator state, and per-step validation.
	 */
	function initMultiStepForm() {
		var form = document.querySelector('.restwell-enq-form[data-multistep]');
		if (!form) return;

		var steps       = form.querySelectorAll('.enquire-step');
		var nodes       = form.querySelectorAll('.step-node');
		var lines       = form.querySelectorAll('.step-line');
		var progressBar = form.querySelector('.enq-steps-progress');
		var currentStep = 1;

		function getNodeCircle(node) { return node.querySelector('.step-circle'); }
		function getNodeLabel(node)  { return node.querySelector('.step-label'); }

		function updateProgress(newStep) {
			nodes.forEach(function (node) {
				var n      = parseInt(node.getAttribute('data-step'), 10);
				var circle = getNodeCircle(node);
				var label  = getNodeLabel(node);
				if (!circle || !label) return;

				if (n < newStep) {
					// Complete
					circle.style.backgroundColor = 'var(--deep-teal)';
					circle.style.borderColor     = 'var(--deep-teal)';
					circle.style.color           = '#fff';
					circle.innerHTML             = '<i class="fa-solid fa-check text-xs" aria-hidden="true"></i>';
					label.style.color            = 'var(--deep-teal)';
					label.style.fontWeight       = '500';
				} else if (n === newStep) {
					// Active
					circle.style.backgroundColor = 'var(--deep-teal)';
					circle.style.borderColor     = 'var(--deep-teal)';
					circle.style.color           = '#fff';
					circle.innerHTML             = String(n);
					label.style.color            = 'var(--deep-teal)';
					label.style.fontWeight       = '500';
			} else {
				// Pending - #6B6355 on white = 5.9:1 (WCAG AA pass)
				circle.style.backgroundColor = '#fff';
				circle.style.borderColor     = '#E8DFD0';
				circle.style.color           = '#6B6355';
				circle.innerHTML             = String(n);
				label.style.color            = '#6B6355';
				label.style.fontWeight       = 'normal';
			}
			});

			lines.forEach(function (line, idx) {
				// Line idx connects step (idx+1) to step (idx+2).
				line.style.backgroundColor = (idx + 1 < newStep) ? 'var(--deep-teal)' : '#E8DFD0';
			});

			if (progressBar) {
				progressBar.setAttribute('aria-valuenow', newStep);
			}
		}

	function showStep(n, skipScroll) {
		steps.forEach(function (step) {
			var stepNum = parseInt(step.getAttribute('data-step'), 10);
			step.classList.toggle('hidden', stepNum !== n);
		});
		updateProgress(n);
		currentStep = n;
		// Smooth scroll to top of form when navigating between steps,
		// but not on initial load (skipScroll = true) so the page starts at the top.
		if (!skipScroll) {
			form.scrollIntoView({ behavior: 'smooth', block: 'start' });
		}

		// Announce the new step to screen readers and move focus to the form
		// heading so keyboard users know where they are after the transition.
		// Without this, focus is destroyed when the active step receives display:none.
		var announcement = document.getElementById('enq-step-announcement');
		var stepLabels = { 1: 'Step 1: About you', 2: 'Step 2: Your stay', 3: 'Step 3: Your needs' };
		if (announcement) {
			announcement.textContent = stepLabels[n] || '';
		}
		var formHeading = form.querySelector('h2');
		if (formHeading) {
			if (!formHeading.getAttribute('tabindex')) {
				formHeading.setAttribute('tabindex', '-1');
			}
			formHeading.focus({ preventScroll: true });
		}
	}

		function clearErrors(step) {
			step.querySelectorAll('.enq-field-error').forEach(function (el) {
				el.remove();
			});
			step.querySelectorAll('[data-invalid]').forEach(function (el) {
				el.removeAttribute('data-invalid');
				el.removeAttribute('aria-invalid');
				el.removeAttribute('aria-describedby');
				el.style.borderColor = '';
			});
		}

		function addFieldError(field, message) {
			var errorId = field.id + '-error';
			var errorEl = document.createElement('p');
			errorEl.id        = errorId;
			errorEl.className = 'enq-field-error';
			errorEl.setAttribute('role', 'alert');
			errorEl.textContent = message;
			field.parentNode.insertBefore(errorEl, field.nextSibling);

			field.setAttribute('data-invalid', 'true');
			field.setAttribute('aria-invalid', 'true');
			field.setAttribute('aria-describedby', errorId);
			field.style.borderColor = '#b91c1c';
		}

		function getFieldLabel(field) {
			var label = form.querySelector('label[for="' + field.id + '"]');
			if (label) {
				// Strip the (optional) span text to get the plain label name
				return (label.firstChild && label.firstChild.nodeValue)
					? label.firstChild.nodeValue.trim()
					: label.textContent.replace(/\s*\*\s*|\(optional\)/gi, '').trim();
			}
			return 'This field';
		}

		function validateStep(n) {
			var step = form.querySelector('.enquire-step[data-step="' + n + '"]');
			if (!step) return true;
			clearErrors(step);

			var required = step.querySelectorAll('[required]');
			var valid    = true;
			var firstInvalid = null;

			required.forEach(function (field) {
				if (!field.value.trim()) {
					addFieldError(field, getFieldLabel(field) + ' is required.');
					valid = false;
					if (!firstInvalid) firstInvalid = field;
				}
			});

			if (!valid && firstInvalid) {
				firstInvalid.focus();
			}
			return valid;
		}

		// Delegation: next and back button clicks.
		form.addEventListener('click', function (e) {
			var nextBtn = e.target.closest('.step-next');
			if (nextBtn) {
				var next = parseInt(nextBtn.getAttribute('data-next'), 10);
				if (validateStep(currentStep)) {
					showStep(next);
				}
				return;
			}
			var backBtn = e.target.closest('.step-back');
			if (backBtn) {
				var back = parseInt(backBtn.getAttribute('data-back'), 10);
				showStep(back);
			}
		});

		// Validate step 3 fields on final submit (novalidate suppresses browser checks).
		form.addEventListener('submit', function (e) {
			if (!validateStep(currentStep)) {
				e.preventDefault();
			}
		});

		// Clear error on input once user starts correcting the field.
		form.addEventListener('input', function (e) {
			var field = e.target;
			if (field.required && field.value.trim() && field.getAttribute('aria-invalid') === 'true') {
				var errorEl = field.id ? document.getElementById(field.id + '-error') : null;
				if (errorEl) errorEl.remove();
				field.removeAttribute('data-invalid');
				field.removeAttribute('aria-invalid');
				field.removeAttribute('aria-describedby');
				field.style.borderColor = '';
			}
		});

	// Initialise at step 1 - skip scroll so the page loads at the top.
	showStep(1, true);
	}

	/**
	 * After enquiry form redirect (?sent=1), scroll to the thank-you card.
	 * Fragments on redirect URLs are unreliable across browsers; this runs client-side.
	 */
	function initEnquirySuccessScroll() {
		var params = new URLSearchParams(window.location.search);
		if (params.get('sent') !== '1') {
			return;
		}
		var el = document.getElementById('enquiry-result');
		if (!el) {
			return;
		}
		function scrollToResult() {
			el.scrollIntoView({ behavior: 'smooth', block: 'start' });
			try {
				el.focus({ preventScroll: true });
			} catch (err) {
				/* IE / older */
			}
		}
		/* Double rAF: layout + fonts settled before scroll */
		if (window.requestAnimationFrame) {
			requestAnimationFrame(function () {
				requestAnimationFrame(scrollToResult);
			});
		} else {
			window.setTimeout(scrollToResult, 0);
		}
	}

	/**
	 * Who It's For: highlight jump-nav link for the section nearest the upper viewport.
	 */
	function initWifPersonaNav() {
		var root = document.querySelector('.restwell-wif-page');
		if (!root) {
			return;
		}
		var nav = root.querySelector('.wif-persona-nav');
		if (!nav) {
			return;
		}
		var personaLinks = nav.querySelectorAll('a[data-wif-anchor]');
		var sections = [];
		personaLinks.forEach(function (link) {
			var id = link.getAttribute('data-wif-anchor');
			var el = id ? document.getElementById(id) : null;
			if (el) {
				sections.push({ el: el, link: link });
			}
		});
		if (!sections.length) {
			return;
		}
		function clearActive() {
			nav.querySelectorAll('.wif-persona-nav__link--active').forEach(function (a) {
				a.classList.remove('wif-persona-nav__link--active');
				a.removeAttribute('aria-current');
			});
		}
		function updateActive() {
			var vh = window.innerHeight || document.documentElement.clientHeight;
			var target = 0.32 * vh;
			var best = null;
			var bestDist = Infinity;
			sections.forEach(function (s) {
				var r = s.el.getBoundingClientRect();
				if (r.bottom <= 0 || r.top >= vh) {
					return;
				}
				var mid = (r.top + r.bottom) / 2;
				var dist = Math.abs(mid - target);
				if (dist < bestDist) {
					bestDist = dist;
					best = s;
				}
			});
			if (best && best.link) {
				clearActive();
				best.link.classList.add('wif-persona-nav__link--active');
				best.link.setAttribute('aria-current', 'true');
			} else {
				clearActive();
			}
		}
		var ticking = false;
		function onScrollOrResize() {
			if (ticking) {
				return;
			}
			ticking = true;
			window.requestAnimationFrame(function () {
				updateActive();
				ticking = false;
			});
		}

		var track = nav.querySelector('.wif-persona-nav__track');
		var list = nav.querySelector('.wif-persona-nav__list');
		var hint = document.getElementById('wif-persona-nav-hint');
		function updateScrollAffordance() {
			if (!list || !track) {
				return;
			}
			var mq = window.matchMedia('(min-width: 768px)');
			if (mq.matches) {
				track.classList.remove(
					'wif-persona-nav__track--scrollable',
					'wif-persona-nav__track--at-start',
					'wif-persona-nav__track--at-end'
				);
				if (hint) {
					hint.classList.remove('wif-persona-nav__hint--collapsed');
				}
				return;
			}
			var overflow = list.scrollWidth > list.clientWidth + 2;
			if (hint) {
				if (overflow) {
					hint.classList.remove('wif-persona-nav__hint--collapsed');
				} else {
					hint.classList.add('wif-persona-nav__hint--collapsed');
				}
			}
			if (!overflow) {
				track.classList.remove(
					'wif-persona-nav__track--scrollable',
					'wif-persona-nav__track--at-start',
					'wif-persona-nav__track--at-end'
				);
				return;
			}
			track.classList.add('wif-persona-nav__track--scrollable');
			var maxScroll = list.scrollWidth - list.clientWidth;
			var sl = list.scrollLeft;
			track.classList.toggle('wif-persona-nav__track--at-start', sl <= 3);
			track.classList.toggle('wif-persona-nav__track--at-end', sl >= maxScroll - 3);
		}
		if (list) {
			list.addEventListener(
				'scroll',
				function () {
					updateScrollAffordance();
				},
				{ passive: true }
			);
		}
		window.addEventListener('resize', function () {
			updateScrollAffordance();
		});
		updateScrollAffordance();
		window.requestAnimationFrame(function () {
			updateScrollAffordance();
		});
		setTimeout(updateScrollAffordance, 400);

	// Intercept clicks on the persona nav links so we can open the accordion
	// and scroll to the card top ourselves, rather than letting the browser
	// jump to the element before the panel has expanded.
	personaLinks.forEach(function (link) {
		link.addEventListener('click', function (e) {
			var id = link.getAttribute('data-wif-anchor') || (link.hash && link.hash.slice(1));
			if (!id) {
				return;
			}
			var card = document.getElementById(id);
			if (!card) {
				return;
			}
			// Only intercept clicks for persona accordion cards.
			// Non-accordion sections (e.g. #wif-funding) scroll natively via the browser.
			if (!card.classList.contains('wif-persona-card')) {
				return;
			}
			e.preventDefault();
			// Push the hash without triggering a native jump.
			history.pushState(null, '', '#' + id);
			// openFromHash reads window.location.hash, so dispatch it.
			window.dispatchEvent(new Event('hashchange'));
		});
	});
	window.addEventListener('scroll', onScrollOrResize, { passive: true });
	window.addEventListener('resize', onScrollOrResize, { passive: true });
	updateActive();
}

	/**
	 * GA4: log CTA clicks when gtag is present (measurement ID from theme SEO settings).
	 * Event name: restwell_cta_click. Parameter: cta_id (from data-cta).
	 */
	function initRestwellCtaAnalytics() {
		document.addEventListener(
			'click',
			function (e) {
				var el = e.target && e.target.closest ? e.target.closest('[data-cta]') : null;
				if (!el) {
					return;
				}
				var id = el.getAttribute('data-cta');
				if (!id || typeof window.gtag !== 'function') {
					return;
				}
				window.gtag('event', 'restwell_cta_click', {
					cta_id: id,
				});
			},
			true
		);
	}

	/**
	 * Who It's For: persona accordions - one panel open; CSS grid 0fr/1fr height (no hidden flash).
	 * Deep link: hash opens panel; scroll runs after expand transition (or immediately if reduced motion).
	 */
	function initWifPersonaAccordions() {
		var root = document.querySelector('.restwell-wif-page');
		if (!root) {
			return;
		}
		var groups = [];
		root.querySelectorAll('.wif-persona-card .wif-persona-expand').forEach(function (btn) {
			var panelId = btn.getAttribute('aria-controls');
			if (!panelId) {
				return;
			}
			var panel = document.getElementById(panelId);
			var card = btn.closest('.wif-persona-card');
			if (!panel || !card) {
				return;
			}
			groups.push({ btn: btn, panel: panel, card: card });
		});
		if (!groups.length) {
			return;
		}
		function setInert(el, on) {
			if (!el) {
				return;
			}
			if (on) {
				el.setAttribute('inert', '');
			} else {
				el.removeAttribute('inert');
			}
		}
		function setGroupState(g, open) {
			g.btn.setAttribute('aria-expanded', open ? 'true' : 'false');
			g.panel.setAttribute('aria-hidden', open ? 'false' : 'true');
			setInert(g.panel, !open);
			g.card.classList.toggle('wif-persona-card--expanded', open);
		}
		function closeAll() {
			groups.forEach(function (g) {
				setGroupState(g, false);
			});
		}
		function getStickyOffset() {
			var offset = 0;
			['.site-header', '.wif-persona-nav'].forEach(function (sel) {
				var el = document.querySelector(sel);
				if (el) {
					offset += el.getBoundingClientRect().height;
				}
			});
			return offset + 8;
		}
		function scrollCardIntoView(card) {
			var reduced =
				window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
			function doScroll() {
				var y = card.getBoundingClientRect().top + window.pageYOffset - getStickyOffset();
				window.scrollTo({ top: Math.max(0, y), behavior: reduced ? 'auto' : 'smooth' });
			}
			if (reduced) {
				requestAnimationFrame(function () {
					requestAnimationFrame(doScroll);
				});
				return;
			}
			var shell = card.querySelector('.wif-persona-card__panel-shell');
			var ran = false;
			function runOnce() {
				if (ran) {
					return;
				}
				ran = true;
				doScroll();
			}
			var fallback = window.setTimeout(runOnce, 440);
			if (shell) {
				shell.addEventListener(
					'transitionend',
					function onEnd(e) {
						if (e.propertyName !== 'grid-template-rows') {
							return;
						}
						window.clearTimeout(fallback);
						shell.removeEventListener('transitionend', onEnd);
						runOnce();
					},
					false
				);
			} else {
				window.clearTimeout(fallback);
				requestAnimationFrame(function () {
					requestAnimationFrame(runOnce);
				});
			}
		}
		function openFromHash() {
			var hash = window.location.hash ? window.location.hash.slice(1) : '';
			if (!hash) {
				return;
			}
			var card = document.getElementById(hash);
			if (!card || !card.classList.contains('wif-persona-card')) {
				return;
			}
			var i;
			for (i = 0; i < groups.length; i++) {
				if (card.contains(groups[i].btn)) {
					groups.forEach(function (g, j) {
						setGroupState(g, j === i);
					});
					scrollCardIntoView(card);
					return;
				}
			}
		}
		closeAll();
		groups.forEach(function (g) {
			g.btn.addEventListener('click', function () {
				var isOpen = g.btn.getAttribute('aria-expanded') === 'true';
				if (isOpen) {
					setGroupState(g, false);
				} else {
					groups.forEach(function (o) {
						setGroupState(o, o === g);
					});
				}
			});
		});
		openFromHash();
		window.addEventListener('hashchange', openFromHash);
	}

	ready(function () {
		setActiveNavLinks();
		initStickyHeaderShadow();
		initNavDropdowns();
		initMobileMenu();
		initExploreFilter();
		initFaqTabs();
		initMultiStepForm();
		initEnquirySuccessScroll();
		initRestwellCtaAnalytics();
		initWifPersonaNav();
		initWifPersonaAccordions();
	});
})();
