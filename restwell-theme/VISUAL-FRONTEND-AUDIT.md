# Visual Frontend Audit Report

**Site/Page:** Restwell Retreats (multi-page, desktop + mobile)  
**Date:** Monday 2 March 2026  
**Input Type:** Screenshots (desktop: Homepage, Property, How It Works, Why Restwell?, Accessibility, FAQ, Enquire; mobile: Homepage, FAQ, Article/How It Works, Why Restwell?, Accessibility)  
**Aesthetic Style Identified:** Modern minimalism with organic/natural undertones — **Confident**  
**Design System Maturity:** **Emerging**

---

## Executive Summary

The site delivers a calm, clear aesthetic that fits an accessible retreat brand. Strengths are the restrained palette (teal, beige, gold), generous spacing, and consistent section patterns across breakpoints. On desktop, the main gaps are typography (line length and hierarchy), contrast on accent/label text, and ensuring focus states meet WCAG. On mobile, the single-column layout and touch-friendly stacking work well; the primary concerns are consistent vertical rhythm, body line length in wide containers, CTA and nav touch targets, and the same contrast issues (gold labels, secondary grey text, beige callout boxes). Addressing typography, contrast, focus, and a single spacing scale will move the design from “emerging” to “mature” on both desktop and mobile.

---

## Overall Score: 7.5/10

| Category | Score (/10) | Key Observation |
|----------|-------------|------------------|
| Aesthetic Coherence | 8 | Calm, minimal, on-brand; small inconsistencies in serif usage and section labels. |
| Colour System | 7 | Clear palette; gold labels, hero overlay, and beige callout contrast need verification/fix. |
| Typography System | 7 | Good pairing; line length and section-label hierarchy need tightening (desktop + mobile). |
| Layout & Spatial Rhythm | 7 | Strong whitespace; section vertical padding varies; mobile vertical rhythm inconsistent. |
| Visual Hierarchy & Gestalt | 8 | Clear entry points and CTAs; section labels could read more as “section” cues; footer grouping on mobile. |
| Responsiveness | 7 | Single-column mobile works; touch targets, CTA width, and hamburger prominence need refinement. |
| Accessibility | 6 | Focus styles exist in code; contrast of focus ring, gold labels, and secondary text needs checking. |
| Motion & Interaction | N/A | Not verifiable from static screenshots — recommend code review. |

---

## Issues Found

### Desktop

**Typography System — Hero sub-tagline line length**
- **Severity:** 🟡 Minor
- **Principle Violated:** Typography: line length (50–75ch)
- **Location:** Homepage → Hero → sub-tagline (`front-page.php`, line 102)
- **Issue:** Sub-tagline uses `max-w-lg` (32rem). On large viewports it can still exceed a comfortable reading width (~65ch).
- **Why it matters:** Long lines increase eye travel and reduce readability.
- **Fix:** Use `max-w-prose` or `max-w-xl` on the hero sub-tagline paragraph.

**Typography System — Body and intro line length on wide containers**
- **Severity:** 🟡 Minor
- **Principle Violated:** Typography: line length (50–75ch)
- **Location:** Multiple templates: intro/body paragraphs inside `max-w-3xl` / `max-w-4xl` / `max-w-5xl` (e.g. `template-accessibility.php`, `template-why-restwell.php`, `template-how-it-works.php`, `template-property.php`)
- **Issue:** 48–64rem containers allow body copy to exceed ~75ch on large screens.
- **Fix:** For main body/intro paragraphs, add `max-w-prose` or `max-w-2xl` on the paragraph or wrapper so body text stays within 50–75ch.

**Typography System — Section label hierarchy**
- **Severity:** 🟡 Minor
- **Principle Violated:** Typography: heading hierarchy; Gestalt: similarity
- **Location:** All pages — small uppercase labels (e.g. “WHAT TO EXPECT”, “FREQUENTLY ASKED QUESTIONS”) using `text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em]`
- **Issue:** Labels are visually light and similar in weight/size across sections.
- **Fix:** Slightly increase prominence (e.g. `text-base`) or add a small visual separator; keep as non-heading elements for outline.

**Colour System — Section label contrast (gold on white)**
- **Severity:** 🟠 Major
- **Principle Violated:** WCAG 2.2 Success Criterion 1.4.3 Contrast (Minimum) Level AA
- **Location:** All templates — section labels with `text-[#D4A853]` on white (e.g. `template-faq.php` line 45, `template-enquire.php` line 36, `front-page.php` section labels)
- **Issue:** #D4A853 on #FFFFFF is likely below 4.5:1 for normal text.
- **Fix:** Darken the gold (e.g. `--warm-gold-text`) for these labels or use a darker teal; verify with a contrast checker.

**Colour System — Hero sub-tagline contrast over overlay**
- **Severity:** 🟡 Minor
- **Principle Violated:** WCAG 1.4.3 Contrast (Minimum)
- **Location:** Homepage hero → sub-tagline `text-[#F5EDE0]` over gradient overlay (`front-page.php`)
- **Fix:** Increase overlay opacity where the sub-tagline sits or add a subtle text shadow so contrast stays ≥4.5:1.

**Layout & Spatial Rhythm — Section vertical padding inconsistency**
- **Severity:** 🔵 Cosmetic
- **Principle Violated:** Spacing system / vertical rhythm
- **Location:** `front-page.php`: intro-section uses `py-20 md:py-28`; most sections use `py-16 md:py-24`; CTA sections use `py-16 md:py-20`
- **Fix:** Standardise to one scale (e.g. main sections `py-16 md:py-24`, hero/intro `py-20 md:py-28`) and document it.

**Accessibility — Focus indicator visibility and contrast**
- **Severity:** 🟠 Major
- **Principle Violated:** WCAG 2.4.7 Focus Visible (Level AA); 3:1 for UI components
- **Location:** Global `:focus-visible` in `assets/css/input.css` (lines 114–116): `outline: 3px solid var(--sea-glass); outline-offset: 2px`
- **Issue:** `--sea-glass` (#A8D5D0) on white is likely &lt;3:1.
- **Fix:** Use a colour that meets ≥3:1 against white (e.g. `var(--deep-teal)`); ensure no focusable element overrides with `outline: none` without a visible alternative.

**Accessibility — Accordion / &lt;details&gt; focus**
- **Severity:** 🟡 Minor
- **Principle Violated:** WCAG 2.4.7 Focus Visible
- **Location:** FAQ page — `<details>` / `<summary>` in `template-faq.php`
- **Fix:** Confirm `<summary>` receives a visible focus outline; add padding or adjust `outline-offset` if the ring is clipped.

**Visual Hierarchy — Primary CTA vs scroll-to-top (FAQ)**
- **Severity:** 🟡 Minor
- **Principle Violated:** Gestalt: figure/ground
- **Location:** FAQ page — “Ask us” CTA vs scroll-to-top button
- **Fix:** Differentiate scroll-to-top (e.g. ghost/outline, smaller) so “Ask us” remains the dominant action.

**Aesthetic Coherence — Feature card icon and element consistency**
- **Severity:** 🟡 Minor
- **Principle Violated:** Gestalt: similarity; design system consistency
- **Location:** Homepage — “Two people. One break.” / features section → feature cards (icons, arrows)
- **Issue:** Icons (e.g. house, heart) can differ in visual size/weight; placement of arrows or repeated UI elements may be inconsistent between cards.
- **Why it matters:** Subtle inconsistencies reduce perceived polish and break the design system.
- **Fix:** Define a single icon size and weight (e.g. 24×24 viewBox, consistent stroke); align repeating elements (arrows, padding) via a shared component or utility classes.

**Colour System — Feature card background differentiation**
- **Severity:** 🟡 Minor
- **Principle Violated:** WCAG (possible); visual hierarchy
- **Location:** Homepage — feature cards background vs section background
- **Issue:** Light beige card background may be too close in luminosity to the section background, reducing layering and potentially making borders the only differentiator.
- **Fix:** Increase luminosity difference (e.g. card `--color-neutral-050` vs section `--color-neutral-100`) or add a soft shadow; verify contrast if card text sits on this surface.

**Layout — Footer navigation vertical spacing**
- **Severity:** 🔵 Cosmetic
- **Principle Violated:** Spacing system consistency (8pt grid)
- **Location:** Footer → Sitemap / Get in touch link columns
- **Issue:** Vertical spacing between individual links within footer columns can appear uneven.
- **Fix:** Apply a consistent spacing unit to all list items (e.g. `py-1` or `mb-2` / `space-y-2`) so vertical rhythm is predictable.

**Visual Hierarchy — Property highlight section (image + text)**
- **Severity:** 🟡 Minor
- **Principle Violated:** Gestalt: figure/ground; visual hierarchy
- **Location:** Homepage / property section — property image placeholder and “3B Russell Drive” (or similar) text block
- **Issue:** Image and text block can carry equal visual weight, creating ambiguity about primary focus.
- **Fix:** Give one element stronger weight (e.g. larger property name, more prominent image container, or distinct background/border for the primary element) to guide the eye.

**Layout — Floating navbar spacing (desktop)**
- **Severity:** 🔵 Cosmetic
- **Principle Violated:** Layout: content padding; ui-ux-pro-max: floating navbar
- **Location:** Desktop → `.site-header` (sticky nav)
- **Issue:** Navbar may sit flush with viewport edges; “floating” pattern usually uses margin from edges (e.g. `top-4 left-4 right-4`) for an airy feel.
- **Fix:** If a floating effect is desired, add margin from viewport (e.g. `top-4 left-4 right-4` with appropriate container); otherwise ensure content below accounts for fixed header height so nothing is hidden.

**Aesthetic Coherence — Inconsistent iconography style**
- **Severity:** 🟡 Minor
- **Principle Violated:** Gestalt: similarity; aesthetic coherence
- **Location:** Property / “What we can offer” (or similar) → circular icons (e.g. “Included features” vs “In the local area”)
- **Issue:** One set of icons may use outline style, another solid fill (e.g. teal outline vs gold fill), creating slight visual dissonance.
- **Fix:** Standardize on one style (all outline or all solid) for these informational circles and apply consistently.

**Responsiveness — Two-column card sections on mobile**
- **Severity:** 🟠 Major
- **Principle Violated:** Layout: responsive design; touch target size
- **Location:** How it Works — “Two steps. That’s it.” and “Two names, one team” (two side-by-side cards)
- **Issue:** If these don’t stack on small viewports, content becomes cramped or forces horizontal scroll; numbered circles may be too small for touch if interactive.
- **Why it matters:** Horizontal scroll is a critical usability and accessibility failure on mobile.
- **Fix:** Use `flex-col` or equivalent at mobile breakpoints so cards stack vertically; ensure any interactive circle has ≥44×44px touch target (padding or invisible hit area).

**Typography — Sub-heading emphasis (Why Restwell?, list items)**
- **Severity:** 🟡 Minor
- **Principle Violated:** Visual hierarchy; Gestalt: figure/ground
- **Location:** Why Restwell? — sub-headings like “Holiday first, always” within “Our core differences”
- **Issue:** Sub-headings can be styled very like body text, reducing scannability.
- **Fix:** Increase font weight (e.g. `font-semibold`) or slightly increase size/colour (e.g. `text-[#1B4D5C]`) so they sit clearly between H2 and body.

**Colour System — Accent underutilization (60-30-10)**
- **Severity:** 🟡 Minor
- **Principle Violated:** Colour: 60-30-10 rule; visual guidance
- **Location:** Site-wide — gold/teal accent used mainly for CTAs and nav active state
- **Issue:** The “10%” accent may be underused for guiding the eye (e.g. hover states, key phrases, secondary CTAs).
- **Fix:** Use accent deliberately for hover states on links, small icons, or thin borders on key callouts while keeping overall minimalism; ensure any new use meets WCAG.

**Accessibility — Active state not indicated by colour alone**
- **Severity:** 🟡 Minor
- **Principle Violated:** WCAG 1.4.1 Use of Color (A)
- **Location:** Any filter or tab UI (e.g. “All” vs “Account”, “Bookings”) or nav active state
- **Issue:** If the active state is shown only by background colour, users who can’t distinguish colour may miss it.
- **Fix:** Add a non-colour indicator (e.g. underline `border-b-2`, icon, or aria-current) in addition to colour so state is clear without colour.

**Forms — Placeholder text contrast**
- **Severity:** 🟡 Minor
- **Principle Violated:** WCAG 1.4.3 Contrast (Minimum)
- **Location:** Enquire page — all input placeholders (e.g. “Jane Smith”, “jane@example.com”) on light cream
- **Issue:** Placeholder grey on light background may be below 4.5:1.
- **Fix:** Use a darker grey for placeholders (e.g. `placeholder-[#6B7280]` or similar) so they meet AA; keep slightly lighter than filled text to preserve hierarchy.

**Forms — Form field border visibility**
- **Severity:** 🟡 Minor
- **Principle Violated:** WCAG: non-text contrast (3:1 for UI components)
- **Location:** Enquire page — input borders (`border-[#E8DFD0]`) on white/cream
- **Issue:** Very subtle borders may fall below 3:1 against background, making fields hard to discern for some users.
- **Fix:** Verify border colour contrast; if below 3:1, darken slightly (e.g. `border-gray-300` or `border-[#D4CFC4]`) while keeping the soft look.

**Visual Hierarchy — Footer contact line spacing**
- **Severity:** 🔵 Cosmetic
- **Principle Violated:** Spacing system; Gestalt: proximity
- **Location:** Footer — contact placeholders (Email, Phone, Social links)
- **Issue:** Vertical spacing between contact lines can feel tight, especially on mobile.
- **Fix:** Add consistent spacing between each line (e.g. `py-2` or `mb-2` per item) for readability.

**Responsiveness — Expanded mobile navigation**
- **Severity:** 🟡 Minor
- **Principle Violated:** Responsiveness: navigation patterns; accessibility
- **Location:** Mobile → hamburger open state (overlay/drawer)
- **Issue:** From static screenshots the expanded state can’t be verified for aesthetic consistency, touch targets, focus order, or close behaviour.
- **Fix:** Ensure expanded nav uses the same typography and spacing; touch targets ≥44×44px; visible focus states; clear close control (e.g. X or tap outside); and logical tab order.

---

### Mobile & responsiveness

**Responsiveness — Body line length on mobile**
- **Severity:** 🟡 Minor
- **Principle Violated:** Typography: line length (50–75ch)
- **Location:** Mobile viewports — body paragraphs in hero, “What’s unique”, “Our core differences”, “Why we built this”, article content
- **Issue:** Paragraphs can span nearly full viewport width, exceeding optimal line length and increasing cognitive load on small screens.
- **Why it matters:** Long lines on mobile make it harder to track from line to line and can feel dense.
- **Fix:** Apply `max-w-prose` or constrain text containers; ensure generous horizontal padding (e.g. `px-4`/`px-6`) so the effective line length stays within 50–75ch.

**Layout & Spatial Rhythm — Inconsistent vertical spacing on mobile**
- **Severity:** 🟠 Major
- **Principle Violated:** Spacing system: consistent section spacing; Gestalt: proximity
- **Location:** Mobile — between “What’s unique” and “Our core differences”, “Our core differences” and “Backed by Continuity of Care Services”, and before “Why we built this”; general section-to-section gaps
- **Issue:** Vertical spacing between major sections feels inconsistent; some areas feel compressed, others loose, disrupting rhythm.
- **Why it matters:** Consistent vertical rhythm improves scannability and makes the layout feel intentional.
- **Fix:** Apply a single modular scale (e.g. `py-12` / `py-16` / `py-20` at mobile) between all major sections; use the same scale for section inner spacing (e.g. heading-to-body, block-to-block).

**Responsiveness — CTA button width and proximity**
- **Severity:** 🟡 Minor
- **Principle Violated:** Touch targets; spacing system: section spacing
- **Location:** Mobile — full-width primary CTA (e.g. “FIND YOUR RETREAT”, “Ask us”, “Get In Touch”) at bottom of content
- **Issue:** Button spans almost full content width with minimal horizontal padding; vertical gap above/below can be tight, reducing its perceived separation from surrounding content.
- **Why it matters:** A CTA that “breathes” reads as the main action; sufficient padding improves tap accuracy and clarity.
- **Fix:** Add horizontal margin/padding (e.g. `max-w-sm mx-auto` or `px-6`) and increase vertical margin (e.g. `mt-10 mb-6` or section-level `py-*`) so the CTA is clearly distinct.

**Responsiveness — Hamburger menu icon size and contrast**
- **Severity:** 🔵 Cosmetic
- **Principle Violated:** UI components: visual hierarchy; WCAG: AA (implicit)
- **Location:** Mobile header → hamburger (`.mobile-menu-btn` in `header.php`)
- **Issue:** Icon can appear small and thin on white, reducing discoverability and potentially under 44×44px touch target.
- **Why it matters:** Primary nav on mobile should be easy to see and tap.
- **Fix:** Ensure tap target is ≥44×44px (padding on button); slightly increase icon size and stroke weight so it reads clearly on the header background.

**Colour System — Low contrast for beige callout box text**
- **Severity:** 🟠 Major
- **Principle Violated:** WCAG 1.4.3 Contrast (Minimum)
- **Location:** Mobile (and desktop) — “Backed by Continuity of Care Services” / trust signals and other light beige (`#FDF5EB` / `#F5EDE0`) callout boxes
- **Issue:** Body text on light beige may fall below 4.5:1 against the background.
- **Why it matters:** Fails WCAG AA and reduces readability for low-vision users.
- **Fix:** Darken text in callout boxes (e.g. use `text-[#1B4D5C]` or a darker grey) or slightly darken the callout background; verify with a contrast checker.

**Colour System — Secondary body text contrast**
- **Severity:** 🔴 Critical (when present)
- **Principle Violated:** WCAG 1.4.3 Contrast (Minimum)
- **Location:** Paragraphs under subheadings, list descriptions, footer descriptive text (e.g. “Honest detail, so you can decide”, “The property: room by room” subtext)
- **Issue:** Lighter grey body text on white can be below 4.5:1, especially on mobile in bright light.
- **Why it matters:** Critical accessibility barrier; excludes many users and harms readability for everyone.
- **Fix:** Use a darker grey for all body text (e.g. `#3a5a63` or `#2d4a52`); avoid any grey lighter than ~#595959 on white for normal text. Verify with WebAIM or similar.

**Visual Hierarchy & Gestalt — Section headings feel flat on mobile**
- **Severity:** 🟡 Minor
- **Principle Violated:** Visual hierarchy; Gestalt: figure/ground
- **Location:** Mobile — section headings (e.g. “What’s unique”, “Our core differences”, “Why we built this”)
- **Issue:** Headings are larger and bolder but don’t create strong enough separation from body, so scanning is less clear.
- **Why it matters:** Clear hierarchy helps users jump to sections of interest.
- **Fix:** Slightly increase size or weight of section headings (e.g. `text-2xl` → `text-3xl` on mobile, or `font-semibold`); consider a thin rule or small icon above key sections.

**Visual Hierarchy & Gestalt — Footer link grouping**
- **Severity:** 🟡 Minor
- **Principle Violated:** Gestalt: proximity
- **Location:** Mobile footer — “Restwell” / “Quick Links” / “Contact” and individual links
- **Issue:** Vertical spacing between links within a group is similar to spacing between groups, so logical grouping is unclear.
- **Why it matters:** Clear grouping reduces parsing effort and improves wayfinding.
- **Fix:** Increase spacing between logical blocks (e.g. between “Quick Links” and “Contact”) and keep tighter spacing between links within each block (e.g. `space-y-2` within group, `mt-8` between groups).

**Accessibility — Accent colour contrast on mobile**
- **Severity:** 🟠 Major
- **Principle Violated:** WCAG 1.4.3 Contrast (Minimum)
- **Location:** Mobile — “FREQUENTLY ASKED QUESTIONS” label, FAQ chevron icons, “Ask us” button text (light teal / gold on white or on dark teal)
- **Issue:** Light teal/gold accent on white may be below 4.5:1 for text and 3:1 for UI components.
- **Why it matters:** Same as other contrast issues; affects readability and compliance.
- **Fix:** Use the same darker gold/teal as for desktop section labels; ensure button text and icons meet 4.5:1 or 3:1 as appropriate.

**Accessibility — Focus indicators (mobile)**
- **Severity:** 🟡 Minor
- **Principle Violated:** WCAG 2.4.7 Focus Visible
- **Location:** All interactive elements on mobile (hamburger, FAQ accordion, CTAs, links)
- **Issue:** Cannot confirm from screenshots whether focus states are visible and high-contrast when using keyboard or switch access.
- **Fix:** Same as desktop: ensure `:focus-visible` uses a ≥3:1 outline colour and is not removed; test with keyboard on a real device.

**Responsiveness — Touch targets**
- **Severity:** 🟡 Minor
- **Principle Violated:** WCAG 2.5.5 Target Size (Level AAA); best practice 44×44px
- **Location:** Hamburger, FAQ accordion summary, “Ask us” / “Get In Touch” buttons, footer links
- **Issue:** Some controls may be smaller than 44×44px or have tight hit areas.
- **Fix:** Ensure all interactive elements have a minimum 44×44px tap target (padding or min-height/min-width); add `touch-action: manipulation` if needed to avoid delay.

---

## Aesthetic Verdict

The site succeeds as a calm, minimal, accessible retreat brand on both desktop and mobile. The strongest choices are the limited palette (teal, beige, gold), generous spacing, and consistent section structure. Single-column mobile layout and clear typography support readability. To raise the bar without a redesign: (1) lock in typography (line length and section-label hierarchy) across breakpoints, (2) fix all contrast (gold labels, secondary text, beige callouts, focus ring) to WCAG AA, and (3) unify section padding and vertical rhythm with one scale on desktop and mobile. That will make the system feel intentional and trustworthy everywhere.

---

## Quick Wins (0–2 days)

- **Hero sub-tagline width:** In `front-page.php`, add `max-w-prose` or `max-w-xl` to the hero sub-tagline paragraph.
- **Section label contrast:** Replace `text-[#D4A853]` with a darker gold or teal for section labels on white; verify ≥4.5:1 (or 3:1 for large text).
- **Focus ring contrast:** In `assets/css/input.css`, change `:focus-visible` outline from `var(--sea-glass)` to `var(--deep-teal)` (or another colour ≥3:1 on white).
- **Section padding:** Standardise section classes (e.g. `py-16 md:py-24` for main, `py-20 md:py-28` for hero/intro only) across `front-page.php` and other templates.
- **Body text contrast:** Ensure all body/secondary text meets 4.5:1 on white (e.g. use `#3a5a63` or darker); audit beige callout text and darken if needed.
- **Mobile CTA spacing:** Add more vertical margin above/below primary CTAs and optional horizontal constraint (e.g. `max-w-sm mx-auto`) on mobile.
- **Hamburger touch target:** Ensure `.mobile-menu-btn` has min 44×44px tap area and that the icon is legible.
- **Footer nav and contact spacing:** Apply consistent vertical spacing (e.g. `space-y-2` or `py-2`) to footer link columns and contact lines so rhythm is clear.
- **Placeholder and form border contrast:** On Enquire page, darken placeholder colour and input borders so they meet WCAG AA (placeholders) and 3:1 for UI (borders).

---

## Strategic Improvements (1–4 weeks)

- **Typography system:** Document a modular scale and apply it to H1–H6 and body; set one rule for body line length (e.g. `max-w-prose` on prose containers) across templates and breakpoints. (ui-ux-pro-max: line-length 65–75ch, readable-font-size min 16px mobile.)
- **Section labels:** Define one component (class or template part) for “section label” with fixed size, weight, colour, and optional separator; use everywhere for consistency and easier contrast maintenance.
- **Modular vertical spacing:** Define and apply a single vertical spacing scale (e.g. 8pt grid) for section padding and in-section gaps on both desktop and mobile so rhythm is consistent. (ui-ux-designer: design tokens, spacing system.)
- **Interactive states:** Audit all links, buttons, form controls, and `<summary>`; ensure hover, focus, and active states are visible and consistent; add `prefers-reduced-motion` where motion is used. Use transitions 150–300ms; cursor-pointer on all clickable elements. (ui-ux-pro-max: focus-states, duration-timing.)
- **Responsive and touch:** Confirm breakpoints, touch targets (≥44×44px), and type scale on small viewports; ensure spacing and line length hold on mobile; no horizontal scroll. (ui-ux-pro-max: touch-target-size, horizontal-scroll.)
- **Design tokens:** Move repeated values (section padding, label colour, focus colour, body colour) into CSS custom properties and reference them in Tailwind/components for easier maintenance and consistency. (ui-ux-designer: design system, accessibility-first components.)

---

## Reference: UI/UX rules applied

This audit was updated using **visual-frontend-audit**, **ui-ux-pro-max**, and **ui-ux-designer**. Findings are aligned with the following expectations:

| Area | Rule / principle |
|------|-------------------|
| **Accessibility** | 4.5:1 text contrast, 3:1 UI/focus; visible focus on all interactive elements; no colour-only state; keyboard order and labels (ui-ux-pro-max, ui-ux-designer). |
| **Touch & interaction** | ≥44×44px touch targets; cursor-pointer on clickable elements; clear hover/focus feedback; transitions 150–300ms; loading/error feedback (ui-ux-pro-max). |
| **Layout & responsive** | No horizontal scroll on mobile; min 16px body on mobile; floating navbar spacing (e.g. top-4 left-4 right-4) where applicable; content not hidden under fixed header (ui-ux-pro-max). |
| **Design system** | Consistent icon style (SVG, fixed viewBox; no emoji icons); design tokens for colour and spacing; documented interactive states (ui-ux-pro-max, ui-ux-designer). |
| **Forms** | Labels with `for`; placeholder and border contrast; clear error placement (ui-ux-pro-max). |
