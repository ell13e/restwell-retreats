# Restwell Theme - Design System Notes

Short reference for typography, spacing, and contrast. See also `VISUAL-FRONTEND-AUDIT.md` for audit details.

## Typography and line length

- **Body / intro text:** Use `max-w-prose` (or `max-w-2xl`) on paragraph or wrapper so line length stays ~50-75ch. Applied on intro and long-form body blocks across templates.
- **Minimum body size on mobile:** 16px (theme base `font-size: 18px` in `input.css`).
- **Section labels:** Use the `section-label` template part: `get_template_part( 'template-parts/section-label', null, array( 'label' => $var ) );`. Styling and contrast are handled in CSS via `--warm-gold-text`.

## Spacing system

All spacing is **token-first** in `input.css` (`:root`), exposed through **named utilities** below. **Breakpoints match Tailwind:** default (&lt;640px), `sm` 640px, `md` 768px, `lg` 1024px. Use the same four steps anywhere section-level padding or major gaps ramp with viewport.

### Base scale (`--space-*`)

Aligned with the Tailwind spacing scale (0.25rem = 4px step). Use for component padding, small gaps, and token definitions.

| Token | rem | Tailwind analogue |
|-------|-----|-------------------|
| `--space-1` | 0.25 | `1` |
| `--space-2` | 0.5 | `2` |
| `--space-3` | 0.75 | `3` |
| `--space-4` | 1 | `4` |
| `--space-5` | 1.25 | `5` |
| `--space-6` | 1.5 | `6` |
| `--space-7` | 1.75 | `7` |
| `--space-8` | 2 | `8` |
| `--space-10` | 2.5 | `10` |
| `--space-12` | 3 | `12` |
| `--space-14` | 3.5 | `14` |
| `--space-16` | 4 | `16` |
| `--space-20` | 5 | `20` |

**Inline Tailwind** (`gap-3`, `p-6`, `mb-4`, etc.) is fine for **micro-layout** inside cards, buttons, and one-off UI. For **section shells**, **title-to-content distance**, **multi-column editorial grids**, and **vertical stacks of blocks**, prefer the tokens/utilities in this section so changes propagate sitewide.

### Section vertical padding (main rhythm)

| Tier | Viewport | Standard | Hero | Compact strip | CTA band |
|------|----------|----------|------|-----------------|----------|
| Base | &lt; 640px | `--section-padding-y` (3.5rem) | `--section-padding-y-hero` (4.5rem) | `--section-padding-y-compact` (3rem) | `--section-padding-y-cta` (4rem) |
| `sm` | 640px+ | `--section-padding-y-sm` (4rem) | `--section-padding-y-hero-sm` (5rem) | `--section-padding-y-compact-sm` (3.25rem) | `--section-padding-y-cta-sm` (4rem) |
| `md` | 768px+ | `--section-padding-y-tablet` (5rem) | `--section-padding-y-hero-tablet` (6rem) | `--section-padding-y-compact-tablet` (4rem) | `--section-padding-y-cta-tablet` (5rem) |
| `lg` | 1024px+ | `--section-padding-y-desktop` (6rem) | `--section-padding-y-hero-desktop` (7rem) | `--section-padding-y-compact-desktop` (4rem) | `--section-padding-y-cta-desktop` (5rem) |

**Utilities (add one per section; combine with bg / seams as needed):**

| Utility | Role |
|---------|------|
| `rw-section-y` | Default main content sections — **do not** use raw `py-16 md:py-24` on shells. |
| `rw-section-y--hero` | Above-the-fold / large heroes (homepage, interior hero). |
| `rw-section-y--compact` | Shorter bands: related links, “more reading”, FAQ/resources footers, compact `page-hero` (teal/sand). |
| `rw-section-y--cta` | Conversion strips (often white or `--deep-teal`) where legacy rhythm was slightly tighter than full `rw-section-y`. |
| `rw-section-y--eyebrow-split` | **With** `rw-section-y`: balances flex `gap` between eyebrow and cards (e.g. Area & funding). |
| `rw-section-y--head-grid-split` | **With** `rw-section-y`: balances `.rw-mb-section` / `.rw-section-head` before a card grid (e.g. Why Restwell). |

Sections inside `#main-content` with **no** `py-*` and **no** class containing `rw-section-y` still receive **`rw-section-y`-equivalent padding** via `#main-content > section` in `input.css`. If you add any `rw-section-y*` class, padding comes **only** from that utility (no double stack from the ID rule — the selector matches `[class*="rw-section-y"]`).

**Section hairlines:** Prefer `rw-seam-t`, `rw-seam-y-soft`, or `rw-seam-y-muted` instead of heavy `border-t` / `border-y` on full-width bands.

### After headings and stacks

| Token / utility | Use |
|-----------------|-----|
| `--rw-section-after-head` (+ `-md` / `-lg`) | Space **below** eyebrow + heading cluster before body/grid. |
| `.rw-section-head` | Wrapper for label + `h2`/`h3` (+ optional dek); applies gap + margin-bottom from tokens. |
| `.rw-mb-section` / `.rw-mb-section-tight` | When you cannot use `.rw-section-head` but need the same margin below a title line. |
| `.rw-stack`, `.rw-stack--tight`, `.rw-stack--loose`, `.rw-stack--dense`, `.rw-stack--regions` | Vertical stacks; gaps from `--rw-stack-gap*` / `--rw-card-region-gap`. Prefer over mixing `space-y-*` with `gap-*` on the same axis. |
| `.rw-prose-stack` | Prose blocks; same gap as `.rw-stack`. |

### Grids and gutters

| Token / utility | Use |
|-----------------|-----|
| `--rw-gutter-x`, `--rw-gutter-x-sm`, `--rw-gutter-x-lg` | Horizontal inset for full-bleed bands that must line up with `.container`. |
| `--rw-grid-gap`, `--rw-grid-gap-md`, `--rw-grid-gap-lg` | Default editorial grids — use **class** `rw-gap-grid` (and `rw-gap-grid-lg` where a larger jump at `lg` is intended). |
| `--rw-split-grid-gap-mobile` → tablet → desktop | `grid md:grid-cols-2` — applied globally in `input.css` for `#main-content .grid.md:grid-cols-2`. |

**Card grids (equal row height):** Use grid with `items-stretch`; inside each cell use column flex / `rw-stack`, `h-full min-h-0` on the cell, and `flex: 1 1 auto` on the trailing text block so row heights align (see homepage `features-section`).

## Interactive states

- **Focus:** Global `:focus-visible` uses `var(--deep-teal)` outline (≥3:1 on white). Do not use `outline: none` without a visible replacement.
- **Active nav:** Non-colour indicator (e.g. `border-bottom`) in addition to background so state is clear without colour alone.
- **Touch targets:** Interactive elements (buttons, links, hamburger, FAQ summary, footer links) have at least 44×44px tap area; `touch-action: manipulation` used where appropriate.
- **Motion:** Respect `prefers-reduced-motion` for any non-essential animation (see `input.css`).

## Design tokens (`:root` in `input.css`)

- **Colour:** `--deep-teal`, `--warm-gold`, `--warm-gold-text` (section labels), `--body-secondary`, `--muted-grey`, `--sea-glass`, `--soft-sand`, `--driftwood`.
- **Spacing — base:** `--space-1` … `--space-20` (see **Base scale** above).
- **Spacing — sections:** `--section-padding-y*`, `--section-padding-y-hero*`, `--section-padding-y-compact*`, `--section-padding-y-cta*`.
- **Spacing — layout:** `--rw-gutter-x*`, `--rw-split-grid-gap-*`, `--rw-grid-gap*`, `--rw-stack-gap*`, `--rw-card-region-gap`, `--rw-section-after-head*`, `--rw-balance-eyebrow-split*`, `--rw-panel-pad-*`.

## Minimum text size

Never render text below `0.75rem` (12px). Footer micro-copy, legal names, and labels must be at minimum `0.75rem`. The current `.footer-legal-name` uses `0.6875rem` intentionally for the legal entity line — do not go smaller than this.

## Copy standards

All default fallback strings in PHP templates must follow the Beautiful Prose rules:

- No em dashes (`—` or `--`); use colons, commas, or line breaks instead.
- No "not X, it's Y" constructions; state what the thing is, not what it is not.
- No filler phrases ("in order to", "it's important to note", "whether you … or …").
- Headings must carry the section's keyword or audience signal — never clever at the expense of clarity.
- No redundant sentences that restate the preceding one.

These rules apply to `$hero_heading`, `$hero_subheading`, all `$what_*`, `$who_*`, `$why_*`, `$cta_*`, and any other fallback strings seeded in template files.

## Customer journey (content alignment)

Content and placement should align with the respite-care customer journey. Reference: project root `respite_care_guide.md` (personas, stages, touchpoints).

- **Stages:** Awareness → Consideration → Enquiry → Assessment/Decision → Booking/Stay → Post-Stay.
- **Placement:** Empathy/headline on homepage (Awareness); benefits, CQC, testimonials on service/property (Consideration); enquiry form (Enquiry); prep pack / what-to-bring in confirmation (post-Decision).
- **Emotion:** Hero, Why Restwell, and Enquire copy should speak to “overwhelmed” and “reassurance” (guide’s emotion map).
- **“Your journey” block:** Optional 4-6 step section on How it works (template part `template-parts/your-journey.php`), editable via How it works meta (journey label, heading, step 1-6 title/body). Default steps: Enquire → We confirm availability → Chat through dates & needs → Confirm & prepare → Your stay → Feedback.
