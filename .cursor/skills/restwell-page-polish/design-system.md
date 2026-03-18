# Restwell Design System Reference

## Colour Tokens

Defined in `assets/css/input.css` as CSS custom properties on `:root`.

| Token | Approximate value | Role |
|---|---|---|
| `--deep-teal` | `#1E5F5F` area | Primary — headings, CTAs, icons |
| `--warm-gold` | `#C9963A` area | Accent — highlights |
| `--warm-gold-text` | Darker gold | AA-passing body gold |
| `--sea-glass` | Soft teal tint | Light teal surfaces |
| `--soft-sand` | Warm off-white | Alternate section background |
| `--bg-subtle` | Near-white grey | Cards, sidebars, spec strips |
| `--driftwood` | Earthy brown | Decorative, secondary accent |
| `--muted-grey` | Mid grey | Secondary body text |
| `--body-secondary` | Light grey | Tertiary text, labels |

Inline tints use Tailwind's opacity modifier: `bg-[var(--deep-teal)]/10`, `text-[var(--deep-teal)]/55`.

---

## Typography Scale

All heading text uses `font-serif` (maps to `--font-serif`). Body copy uses `font-sans`.

| Use | Classes |
|---|---|
| Section eyebrow | `section-label` (defined in `input.css`) |
| Section h2 | `text-3xl font-serif text-[var(--deep-teal)]` |
| Card h3 | `text-xl font-semibold font-serif text-[var(--deep-teal)]` |
| Body intro | `text-gray-600 leading-relaxed max-w-prose` |
| Body copy | `text-gray-700 leading-relaxed text-sm` (or `text-base` for longer prose) |
| Meta / label | `text-[10px] font-semibold uppercase tracking-widest text-[var(--deep-teal)]/55` |
| Secondary label | `text-xs text-gray-400` |

---

## Spacing

Site uses an 8pt spacing grid via Tailwind defaults. Key conventions:

- Section padding: `py-16 md:py-24`
- Container inner padding: `px-4 sm:px-6 lg:px-8` (handled by `.container` class)
- Card inner padding: `p-6` (standard) or `p-7` (inquiry/highlight cards)
- Stack spacing within a card: `space-y-2` or `gap-3`
- Gap between grid cards: `gap-6` or `gap-8`

---

## Icon Usage (Font Awesome)

Loaded via CDN in `functions.php`. Use `fa-solid` for UI icons, `fa-regular` for editorial.

Common icons in use:

| Icon class | Context |
|---|---|
| `fa-check` | Verified / confirmed features |
| `fa-arrow-right` | CTA button |
| `fa-arrow-up-right-from-square` | External link indicator |
| `fa-universal-access` | Accessibility information |
| `fa-bed` | Bedrooms |
| `fa-bath` | Bathrooms |
| `fa-square-parking` | Parking |
| `fa-user-group` | Sleeps / guests |
| `fa-utensils` | Food & drink nearby |
| `fa-water` | Coast / waterfront nearby |
| `fa-umbrella-beach` | Beach nearby |
| `fa-bag-shopping` | Shopping nearby |
| `fa-kit-medical` | Healthcare nearby |

Always add `aria-hidden="true"` to decorative icons.

---

## Shadow Scale

| Class | Use |
|---|---|
| `shadow-[0_4px_20px_rgb(0,0,0,0.05)]` | Default card |
| `shadow-[0_8px_30px_rgb(0,0,0,0.08)]` | Card hover state |
| `shadow-[0_8px_30px_rgb(0,0,0,0.04)]` | Explore cards (lighter) |
| `shadow-[0_12px_40px_rgb(0,0,0,0.08)]` | Explore cards hover |

---

## Focus States (Accessibility)

All interactive elements use `focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)]`. Never remove focus outlines without replacing them.

---

## Responsive Grid Patterns

| Pattern | Classes |
|---|---|
| Standard 2-col grid | `grid sm:grid-cols-2 gap-6` |
| 3-col feature grid | `grid sm:grid-cols-2 lg:grid-cols-3 gap-6` |
| 4-col spec strip | `grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x` |
| Asymmetric 2-col | `grid md:grid-cols-[1fr,2fr] gap-8` (adjust fractions to content) |
| Full-bleed image + text | `grid lg:grid-cols-2 gap-0` with image `aspect-[4/3]` |

Property gallery: use `.prop-gallery-grid` class from `input.css`. Do not recreate with Tailwind.

---

## Page Template Structure

Each template follows this skeleton:

```php
<?php
/*
 * Template Name: [Page Name]
 */
get_header();
$pid = get_the_ID();

// — Meta fields ——————————————————————————————
$field = get_post_meta( $pid, 'meta_key', true ) ?: 'Fallback';

// — Page sections —————————————————————————————
?>

<main id="main-content" tabindex="-1">
    <!-- sections here -->
</main>

<?php get_footer(); ?>
```

All meta field definitions live in `inc/page-meta-definitions.php`. Register new fields there.
