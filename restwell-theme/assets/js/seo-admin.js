/**
 * Restwell SEO Admin — meta box JavaScript
 *
 * Handles:
 *  - Character counters (title + description)  with traffic-light colouring
 *  - Live SERP preview update
 *  - Social card tab switching and live preview sync
 *  - OG image picker via wp.media
 */
/* global rwSeoAdmin, wp */
(function () {
  'use strict';

  /* ── Helpers ──────────────────────────────────────────────────────────── */
  function byId(id) {
    return document.getElementById(id);
  }

  function clamp(str, max) {
    return str.length > max ? str.substring(0, max) + '…' : str;
  }

  /* ── Counter ──────────────────────────────────────────────────────────── */
  /**
   * @param {HTMLElement} input      The text input / textarea
   * @param {HTMLElement} counterEl  The <p> counter element
   * @param {number}      max        Max ideal length
   * @param {{ min?: number, max?: number }} ideal
   */
  function initCounter(input, counterEl, max, ideal) {
    if (!input || !counterEl) return;

    var valEl = counterEl.querySelector('.rw-seo__counter-val');

    function update() {
      var len = input.value.length;
      valEl.textContent = len;

      counterEl.classList.remove('rw-seo__counter--ok', 'rw-seo__counter--warn', 'rw-seo__counter--bad');

      if (ideal && len >= ideal.min && len <= ideal.max) {
        counterEl.classList.add('rw-seo__counter--ok');
      } else if (ideal && len >= ideal.min - 10) {
        counterEl.classList.add('rw-seo__counter--warn');
      } else {
        counterEl.classList.add('rw-seo__counter--bad');
      }
    }

    input.addEventListener('input', update);
    update();
  }

  /* ── SERP + social sync ───────────────────────────────────────────────── */
  function initPreviews() {
    var titleInput = byId('rw_meta_title');
    var descInput  = byId('rw_meta_description');

    if (!titleInput || !descInput) return;

    var serpTitle = byId('rw-serp-title');
    var serpDesc  = byId('rw-serp-desc');
    var fbTitle   = byId('rw-social-fb-title');
    var fbDesc    = byId('rw-social-fb-desc');
    var twTitle   = byId('rw-social-tw-title');
    var twDesc    = byId('rw-social-tw-desc');

    // Fallback: read the placeholder (which is the raw post title).
    var postTitle = titleInput.getAttribute('placeholder') || '';

    function updatePreviews() {
      var title = titleInput.value || postTitle;
      var desc  = descInput.value;

      if (serpTitle) serpTitle.textContent = clamp(title, 60);
      if (serpDesc)  serpDesc.textContent  = clamp(desc, 160);
      if (fbTitle)   fbTitle.textContent   = clamp(title, 60);
      if (fbDesc)    fbDesc.textContent    = clamp(desc, 160);
      if (twTitle)   twTitle.textContent   = clamp(title, 60);
      if (twDesc)    twDesc.textContent    = clamp(desc, 120);
    }

    titleInput.addEventListener('input', updatePreviews);
    descInput.addEventListener('input', updatePreviews);
    updatePreviews();
  }

  /* ── Social tabs ──────────────────────────────────────────────────────── */
  function initSocialTabs() {
    var tabs = document.querySelectorAll('.rw-seo__tab');
    if (!tabs.length) return;

    var fbPanel = byId('rw-social-fb');
    var twPanel = byId('rw-social-tw');

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) { t.classList.remove('rw-seo__tab--active'); });
        tab.classList.add('rw-seo__tab--active');

        var target = tab.getAttribute('data-tab');
        if (fbPanel) fbPanel.style.display = (target === 'facebook') ? '' : 'none';
        if (twPanel) twPanel.style.display = (target === 'twitter')  ? '' : 'none';
      });
    });
  }

  /* ── OG image picker ──────────────────────────────────────────────────── */
  function initOgImage() {
    var chooseBtn = byId('rw-og-choose');
    var removeBtn = byId('rw-og-remove');
    var hiddenId  = byId('rw_og_image_id');
    var thumbEl   = byId('rw-og-thumb');
    var fbImgEl   = byId('rw-social-fb-img');
    var twImgEl   = byId('rw-social-tw-img');

    if (!chooseBtn || !hiddenId) return;

    var frame;

    function setImage(id, url) {
      if (!hiddenId) return;
      hiddenId.value = id;

      // Thumb.
      if (thumbEl) {
        thumbEl.innerHTML = '<img src="' + url + '" alt="" />';
      }

      // Social previews.
      [fbImgEl, twImgEl].forEach(function (el) {
        if (el) el.innerHTML = '<img src="' + url + '" alt="" />';
      });

      // Show / update remove button.
      if (!removeBtn) {
        var actionsEl = chooseBtn.parentElement;
        if (actionsEl) {
          var btn = document.createElement('button');
          btn.type = 'button';
          btn.id = 'rw-og-remove';
          btn.className = 'button-link rw-seo__remove-btn';
          btn.textContent = rwSeoAdmin && rwSeoAdmin.removeImage ? rwSeoAdmin.removeImage : 'Remove';
          actionsEl.appendChild(btn);
          btn.addEventListener('click', removeImage);
        }
      }
    }

    function removeImage() {
      if (!hiddenId) return;
      hiddenId.value = '0';
      if (thumbEl) thumbEl.innerHTML = '';
      [fbImgEl, twImgEl].forEach(function (el) {
        if (el) el.innerHTML = '<span class="rw-seo__social-placeholder">No image set</span>';
      });
      var rb = byId('rw-og-remove');
      if (rb) rb.remove();
    }

    chooseBtn.addEventListener('click', function () {
      if (frame) {
        frame.open();
        return;
      }

      frame = wp.media({
        title:    rwSeoAdmin ? rwSeoAdmin.chooseImage : 'Choose image',
        button:   { text: rwSeoAdmin ? rwSeoAdmin.useImage : 'Use image' },
        multiple: false,
      });

      frame.on('select', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        var url = (attachment.sizes && attachment.sizes.large)
          ? attachment.sizes.large.url
          : attachment.url;
        setImage(attachment.id, url);
      });

      frame.open();
    });

    if (removeBtn) {
      removeBtn.addEventListener('click', removeImage);
    }
  }

  /* ── Live analysis (client-side re-run as the editor types) ─────────── */
  function initLiveAnalysis() {
    var checksEl = byId('rw-seo-checks');
    if (!checksEl) return;

    var titleInput = byId('rw_meta_title');
    var descInput  = byId('rw_meta_description');
    var kpInput    = byId('rw_focus_keyphrase');

    if (!titleInput || !descInput || !kpInput) return;

    var postTitle   = titleInput.getAttribute('placeholder') || '';
    var contentText = checksEl.getAttribute('data-content') || '';

    function runChecks() {
      var kp    = kpInput.value.trim().toLowerCase();
      var title = (titleInput.value || postTitle).toLowerCase();
      var desc  = descInput.value.toLowerCase();

      var updates = {
        kp_title: kp === '' ? 'warn' : (title.indexOf(kp) >= 0 ? 'ok' : 'bad'),
        kp_desc:  kp === '' ? 'warn' : (desc.indexOf(kp)  >= 0 ? 'ok' : 'bad'),
        title_len: (function() {
          var l = (titleInput.value || postTitle).length;
          return l >= 50 && l <= 60 ? 'ok' : (l >= 40 ? 'warn' : 'bad');
        })(),
        desc_len: (function() {
          var l = descInput.value.length;
          return l >= 120 && l <= 160 ? 'ok' : (l >= 100 ? 'warn' : 'bad');
        })(),
      };

      // Apply visual state updates.
      Object.keys(updates).forEach(function (id) {
        var el = checksEl.querySelector('[data-check="' + id + '"]');
        if (!el) return;
        var iconEl = el.querySelector('.rw-seo__check-icon');
        var icons = { ok: '✓', warn: '~', bad: '✗' };
        el.classList.remove('rw-seo__check--ok', 'rw-seo__check--warn', 'rw-seo__check--bad');
        el.classList.add('rw-seo__check--' + updates[id]);
        if (iconEl) iconEl.textContent = icons[updates[id]];
      });

      // Update title-len label with live count.
      var tlEl = checksEl.querySelector('[data-check="title_len"] .rw-seo__check-label');
      if (tlEl) {
        var tl = (titleInput.value || postTitle).length;
        tlEl.textContent = 'SEO title length: ' + tl + ' characters (ideal: 50–60)';
      }

      // Update desc-len label with live count.
      var dlEl = checksEl.querySelector('[data-check="desc_len"] .rw-seo__check-label');
      if (dlEl) {
        var dl = descInput.value.length;
        dlEl.textContent = 'Meta description length: ' + dl + ' characters (ideal: 120–160)';
      }
    }

    titleInput.addEventListener('input', runChecks);
    descInput.addEventListener('input',  runChecks);
    kpInput.addEventListener('input',    runChecks);
  }

  /* ── Init ─────────────────────────────────────────────────────────────── */
  function init() {
    var titleInput   = byId('rw_meta_title');
    var descInput    = byId('rw_meta_description');
    var titleCounter = byId('rw-title-counter');
    var descCounter  = byId('rw-desc-counter');

    initCounter(titleInput, titleCounter, 60, { min: 50, max: 60 });
    initCounter(descInput,  descCounter,  160, { min: 120, max: 160 });
    initPreviews();
    initSocialTabs();
    initOgImage();
    initLiveAnalysis();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
}());
