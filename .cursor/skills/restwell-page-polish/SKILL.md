---
name: restwell-page-polish
description: Audit and polish Restwell WordPress theme pages to match the established design standard. Use when reviewing, building, or refactoring any template in /restwell-theme/, when the user asks to audit a page, apply the site standard, or polish a template. Covers design system tokens, section patterns, copy principles, accessibility, and mobile responsiveness.
---

# Restwell Page Polish

The reference standard is `template-property.php`. Every page audit should produce output at that level of quality.

For visual design auditing, read and apply [visual-frontend-audit](/Users/elliesmith/.cursor/skills/visual-frontend-audit/SKILL.md). For accessibility, read [accessibility-compliance-accessibility-audit](/Users/elliesmith/.cursor/skills/skills/accessibility-compliance-accessibility-audit/SKILL.md).

---

## Audit Checklist

Before touching any template, run through these in order:

- [ ] **Section backgrounds** alternate correctly (see pattern below)
- [ ] **Typography hierarchy** — every section has eyebrow → h2 → intro → content
- [ ] **Spacing** — sections use `py-16 md:py-24` unless specified otherwise
- [ ] **Cards** follow the standard card pattern
- [ ] **Buttons** use the correct variant (primary or ghost)
- [ ] **Copy** — no defensive hedging, no TBC lists, nothing that creates user anxiety
- [ ] **Accessibility** — confirmed features shown positively; inquiry card instead of unknowns
- [ ] **Mobile** — all grids collapse sensibly; test every breakpoint
- [ ] **Hero** — supports optional background image with overlay
- [ ] **External links** — `target="_blank" rel="noopener noreferrer"` + `sr-only` context
- [ ] **WordPress escaping** — all output escaped appropriately (see rules below)
- [ ] **ACF fields** — every hardcoded string editors might change is a `get_post_meta()` call with a fallback

Flag issues by severity:
- 🔴 **Critical** — broken, inaccessible, or incorrect output
- 🟡 **Major** — confusing UX, wrong pattern, poor copy
- 🟢 **Minor** — spacing, alignment, cosmetic

---

## Design System Tokens

All tokens are defined in `assets/css/input.css`. Use them via `var(--token-name)`.

| Token | Use |
|---|---|
| `--deep-teal` | Primary brand colour — headings, icons, CTAs |
| `--warm-gold` | Accent — highlights, hover states |
| `--warm-gold-text` | Gold that passes AA on white |
| `--sea-glass` | Soft teal tint — light backgrounds |
| `--soft-sand` | Warm off-white — alternate section bg |
| `--bg-subtle` | Near-white grey — cards, spec strips, sidebars |
| `--driftwood` | Earthy brown — decorative accents |
| `--muted-grey` | Secondary body text |
| `--font-sans` | Body and UI text |
| `--font-serif` | Headings and display text |

---

## Section Patterns

### Standard section structure

```php
<section class="py-16 md:py-24 bg-white"> <!-- or bg-[var(--bg-subtle)] / bg-[var(--soft-sand)] -->
    <div class="container max-w-4xl"> <!-- omit max-w for full-width layouts -->
        <p class="section-label mb-3">Eyebrow label</p>
        <h2 class="text-3xl font-serif text-[var(--deep-teal)] mb-4">Section heading</h2>
        <p class="text-gray-600 mb-10 leading-relaxed max-w-prose">Intro paragraph.</p>
        <!-- content -->
    </div>
</section>
```

Alternate section backgrounds in this order: `bg-white` → `bg-[var(--bg-subtle)]` → `bg-[var(--soft-sand)]`.

### Hero section

```php
<section class="relative min-h-[36rem] md:min-h-[48rem] flex items-end ...">
    <!-- Background image (conditional) -->
    <?php if ( $hero_image_id ) : ?>
        <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('<?php echo esc_url( $img_url ); ?>');" aria-hidden="true"></div>
    <?php endif; ?>
    <!-- Overlay -->
    <div class="absolute inset-0 bg-[var(--deep-teal)]/75" aria-hidden="true"></div>
    <!-- Content -->
    <div class="relative container pb-16 ...">...</div>
</section>
```

Always provide a graceful fallback when no image is set (solid `bg-[var(--deep-teal)]`).

### Standard card

```php
<div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100
            hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5
            transition-all duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:translate-y-0">
```

### Nearby / Explore cards (4-zone structure)

Every card has exactly these zones in order:

1. **Meta row** — icon (size-6) + category chip + distance, all `items-center` flex, no `justify-between`
2. **Title** — `h3 font-serif` with optional external link
3. **Body** — `text-sm text-gray-600 leading-relaxed flex-1`
4. **Access footer** — `border-t` with `fa-universal-access` icon, only if `acc` data exists

Grid: `grid sm:grid-cols-2 gap-6 max-w-4xl`. Do not use 3-column grids for this component.

### Spec strip (facts/stats)

For property facts (bedrooms, bathrooms etc.) — use a unified container with internal dividers, never separate cards with per-item CTAs:

```php
<div class="max-w-3xl mx-auto bg-[var(--bg-subtle)] rounded-2xl overflow-hidden
            grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-200/70">
    <!-- each cell: py-8 px-5 flex flex-col items-center text-center gap-1.5 -->
    <!-- icon → bold value → xs uppercase label -->
</div>
<p class="text-center text-gray-500 text-sm mt-6">
    Question about the property?
    <a href="..." class="text-[var(--deep-teal)] font-medium hover:underline">Get in touch</a>
</p>
```

One inquiry link beneath the whole strip, never per-stat.

### Accessibility section

Never use "What we can confirm" or TBC lists. Use:
- Positive heading: "Accessibility you can rely on"
- Verified features list (checkmarks, `bg-[#A8D5D0]/40` icons)
- Inquiry card on the right: "Have a specific requirement?" + "Ask us directly" CTA

```php
<div class="grid md:grid-cols-2 gap-8 items-start">
    <ul><!-- verified items --></ul>
    <div class="bg-[var(--bg-subtle)] rounded-2xl p-7 ...">
        <h3>Have a specific requirement?</h3>
        <p><!-- reassuring copy --></p>
        <a href="/enquire/">Ask us directly →</a>
    </div>
</div>
```

### Buttons

```php
<!-- Primary -->
<a class="inline-flex items-center gap-2 bg-[var(--deep-teal)] text-white font-semibold
          px-6 py-3 rounded-2xl text-sm hover:opacity-90 hover:-translate-y-0.5
          transition-all duration-300 focus:outline-none focus-visible:ring-2
          focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] no-underline">

<!-- Ghost / secondary -->
<a class="inline-flex items-center gap-2 border-2 border-[var(--deep-teal)]/25
          text-[var(--deep-teal)] font-semibold px-6 py-3 rounded-2xl text-sm
          hover:border-[var(--deep-teal)]/50 hover:-translate-y-0.5
          transition-all duration-300 focus:outline-none focus-visible:ring-2
          focus-visible:ring-[var(--deep-teal)] no-underline">
```

---

## Copy Principles

1. **Positive framing** — "Accessibility you can rely on" not "What we can confirm"
2. **No TBC lists** — unknown information creates anxiety; use an inquiry CTA instead
3. **Specific > vague** — "Level access from the street" not "Accessible entrance"
4. **Trust, don't hedge** — omit qualifiers like "we think", "roughly", "should be"
5. **Call-to-actions are invitations** — "Ask us directly", "Get in touch", never "Click here"

---

## WordPress Rules

```php
// Output escaping (required everywhere)
echo esc_html( $string );          // plain text
echo esc_attr( $string );          // HTML attributes
echo esc_url( $url );              // href / src
echo wp_kses_post( $html );        // trusted HTML (body copy)

// ACF / post meta pattern
$value = get_post_meta( $pid, 'meta_key', true ) ?: 'Fallback default';

// External links (always)
target="_blank" rel="noopener noreferrer"
// + sr-only text: <span class="sr-only">(opens in new tab)</span>

// Function prefix
restwell_function_name()
```

Never use inline `<style>` or `<script>`. Enqueue everything via `wp_enqueue_scripts` in `inc/enqueue.php`.

---

## Mobile Responsiveness

Check these at every breakpoint before marking a page done:

| Breakpoint | What to verify |
|---|---|
| 320px (mobile S) | No horizontal overflow; text readable |
| 375px (mobile) | Buttons not cramped; hero height correct |
| 768px (tablet) | Grid columns collapse as intended |
| 1024px (desktop) | Full layout; max-width containers centred |

Gallery grids use the `.prop-gallery-grid` class defined in `input.css` — do not override with Tailwind grid unless the design calls for it.

---

## Additional Reference

- Design tokens and full component inventory: [design-system.md](design-system.md)
- Source reference pages in `/client/src/` — for translating React components to PHP only; never modify these files
