/**
 * Restwell Retreats — header and nav behaviour (vanilla JS, no dependencies).
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

	function initMobileMenu() {
		var btn = document.querySelector('.mobile-menu-btn');
		var mobileNav = document.getElementById('mobile-nav');
		var siteHeader = document.querySelector('.site-header');

		if (!btn || !mobileNav) return;

		function isOpen() {
			return mobileNav.classList.contains('is-open');
		}

		function openMenu() {
			mobileNav.classList.add('is-open');
			mobileNav.removeAttribute('aria-hidden');
			btn.setAttribute('aria-expanded', 'true');
			btn.setAttribute('aria-label', 'Close menu');
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
		}

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
				// Pending — #6B6355 on white = 5.9:1 (WCAG AA pass)
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

	// Initialise at step 1 — skip scroll so the page loads at the top.
	showStep(1, true);
	}

	ready(function () {
		setActiveNavLinks();
		initStickyHeaderShadow();
		initMobileMenu();
		initExploreFilter();
		initFaqTabs();
		initMultiStepForm();
	});
})();
