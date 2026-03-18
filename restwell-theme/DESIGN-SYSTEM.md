# Restwell Theme — Design System Notes

Short reference for typography, spacing, and contrast. See also `VISUAL-FRONTEND-AUDIT.md` for audit details.

## Typography and line length

- **Body / intro text:** Use `max-w-prose` (or `max-w-2xl`) on paragraph or wrapper so line length stays ~50–75ch. Applied on intro and long-form body blocks across templates.
- **Minimum body size on mobile:** 16px (theme base `font-size: 18px` in `input.css`).
- **Section labels:** Use the `section-label` template part: `get_template_part( 'template-parts/section-label', null, array( 'label' => $var ) );`. Styling and contrast are handled in CSS via `--warm-gold-text`.

## Vertical spacing (section padding)

Single scale for consistency:

- **Main sections:** `py-16 md:py-24` (tokens: `--section-padding-y`, `--section-padding-y-md`).
- **Hero / intro / CTA sections:** `py-20 md:py-28` (tokens: `--section-padding-y-hero`, `--section-padding-y-hero-md`).

Use the same scale on mobile and desktop; avoid one-off values unless documented.

## Interactive states

- **Focus:** Global `:focus-visible` uses `var(--deep-teal)` outline (≥3:1 on white). Do not use `outline: none` without a visible replacement.
- **Active nav:** Non-colour indicator (e.g. `border-bottom`) in addition to background so state is clear without colour alone.
- **Touch targets:** Interactive elements (buttons, links, hamburger, FAQ summary, footer links) have at least 44×44px tap area; `touch-action: manipulation` used where appropriate.
- **Motion:** Respect `prefers-reduced-motion` for any non-essential animation (see `input.css`).

## Design tokens (`:root` in `input.css`)

- **Colour:** `--deep-teal`, `--warm-gold`, `--warm-gold-text` (section labels), `--body-secondary`, `--muted-grey`, `--sea-glass`, `--soft-sand`, `--driftwood`.
- **Spacing:** `--space-*`, `--section-padding-y`, `--section-padding-y-md`, `--section-padding-y-hero`, `--section-padding-y-hero-md`.

## Customer journey (content alignment)

Content and placement should align with the respite-care customer journey. Reference: project root `respite_care_guide.md` (personas, stages, touchpoints).

- **Stages:** Awareness → Consideration → Enquiry → Assessment/Decision → Booking/Stay → Post-Stay.
- **Placement:** Empathy/headline on homepage (Awareness); benefits, CQC, testimonials on service/property (Consideration); enquiry form (Enquiry); prep pack / what-to-bring in confirmation (post-Decision).
- **Emotion:** Hero, Why Restwell, and Enquire copy should speak to “overwhelmed” and “reassurance” (guide’s emotion map).
- **“Your journey” block:** Optional 4–6 step section on How it works (template part `template-parts/your-journey.php`), editable via How it works meta (journey label, heading, step 1–6 title/body). Default steps: Enquire → We confirm availability → Chat through dates & needs → Confirm & prepare → Your stay → Feedback.
