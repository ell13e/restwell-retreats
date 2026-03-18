# Design Brainstorm – Restwell Retreats

## Context
The spec mandates: Deep Teal (#1B4D5C), Warm Gold (#D4A853), Soft Sand (#F5EDE0), Driftwood Grey (#8B8B7A), Sea Glass (#A8D5D0), White (#FFFFFF). Typography: DM Serif Display for headings, Inter for body. Visual style: "Warm Minimalism" — spacious, coastal-inspired, non-clinical.

---

<response>
## Idea 1: "Coastal Calm" — Organic Minimalism

<text>
**Design Movement**: Organic Minimalism inspired by Japanese "Ma" (negative space) philosophy, blended with British coastal vernacular.

**Core Principles**:
1. Asymmetric balance — content blocks float with intention, never rigidly centred.
2. Breath — every section has generous vertical rhythm (80–120px between major blocks).
3. Tactile warmth — the Soft Sand background is treated like handmade paper, with subtle grain texture overlays.

**Color Philosophy**: Soft Sand (#F5EDE0) dominates as the canvas, evoking sun-bleached driftwood. Deep Teal (#1B4D5C) anchors headings and CTAs like the deep sea at the horizon. Warm Gold (#D4A853) appears sparingly — only on the tagline and key accent moments — like sunlight catching a wave.

**Layout Paradigm**: A "tidal" layout where content sections alternate between full-width immersive panels and narrower, offset text columns. Hero sections use a split layout (60/40 image-to-text ratio). Cards use a staggered masonry-like arrangement rather than uniform grids.

**Signature Elements**:
1. A soft, hand-drawn wave SVG divider between sections (not literal — more like a gentle sine curve in Sea Glass).
2. Rounded, pill-shaped CTAs with a subtle shadow that lifts on hover.

**Interaction Philosophy**: Interactions are gentle and unhurried. Hover states use slow color transitions (300ms). Scroll-triggered fade-ins are soft and staggered. Nothing snaps or bounces.

**Animation**: Elements fade in from below with a 20px translate, staggered by 100ms. The infinity logo has a subtle, slow pulse on page load. No parallax — it can cause motion sickness.

**Typography System**: DM Serif Display (400) for H1/H2 — large, confident, with generous letter-spacing. Inter (400) for body at 18px/1.75 line-height. Inter (600, uppercase, wide tracking) for labels and small caps.
</text>
<probability>0.08</probability>
</response>

---

<response>
## Idea 2: "The Harbour Wall" — Editorial Coastal

<text>
**Design Movement**: Editorial design meets British seaside postcard. Think of a beautifully typeset magazine article about a weekend in Whitstable.

**Core Principles**:
1. Strong typographic hierarchy — the page reads like a well-laid-out feature article.
2. Photographic storytelling — large, atmospheric images do the emotional heavy lifting.
3. Structured informality — the grid is precise, but the content within it feels relaxed and conversational.

**Color Philosophy**: White (#FFFFFF) is the primary canvas for card surfaces and content areas, creating maximum readability. Soft Sand (#F5EDE0) is used for full-width "break" sections that separate content chapters. Deep Teal is reserved for headlines and the navigation bar, creating a strong, trustworthy frame.

**Layout Paradigm**: A classic editorial two-column layout for text-heavy pages (Property, Accessibility), with a wider left column for prose and a narrower right column for quick-reference details, pull quotes, or small images. The Home page uses a full-bleed hero followed by alternating "feature" sections.

**Signature Elements**:
1. A thin Warm Gold horizontal rule used as a section separator — elegant and understated.
2. Pull quotes in DM Serif Display, set large and in Deep Teal, breaking up long text sections.

**Interaction Philosophy**: Interactions are crisp and confident. Buttons have a clear, defined hover state (background color swap from Teal to a slightly lighter teal). Links use a gold underline animation on hover.

**Animation**: Minimal and purposeful. A single, smooth fade-in for the hero headline on load. Section headings slide in from the left on scroll. No decorative animations.

**Typography System**: DM Serif Display (400) for H1 at 48–56px, H2 at 32–36px. Libre Baskerville (400 italic) for pull quotes. Inter (400) for body at 17px/1.7. Inter (500) for navigation links.
</text>
<probability>0.06</probability>
</response>

---

<response>
## Idea 3: "Pebble & Tide" — Textured Warmth

<text>
**Design Movement**: Wabi-sabi-influenced web design — finding beauty in imperfection and natural textures. Inspired by the tactile quality of Whitstable's pebble beaches and weathered fishing huts.

**Core Principles**:
1. Layered depth — cards and sections feel like they sit on top of each other with soft, realistic shadows.
2. Natural rhythm — section sizes and spacing vary organically, avoiding mechanical repetition.
3. Inviting enclosure — content is framed in warm, rounded containers that feel like cozy rooms.

**Color Philosophy**: Soft Sand is the "earth" layer. White cards float above it. Deep Teal is the "sky" — used for the header/footer and as a dramatic contrast for key sections (e.g., the "Why Restwell?" page gets a full Deep Teal background with white text). Sea Glass (#A8D5D0) is used generously for tags, badges, and secondary accents.

**Layout Paradigm**: A "card-forward" design where most content lives inside rounded-corner cards (border-radius: 16px) with soft shadows. The Home page is a vertical scroll of distinct card "scenes." On wider screens, cards arrange in an offset 2-column layout.

**Signature Elements**:
1. Subtle dot-grid or linen texture overlay on the Soft Sand background, barely visible but adding warmth.
2. Rounded "pebble" shaped image masks for photo galleries — not circles, but organic, slightly irregular rounded rectangles.

**Interaction Philosophy**: Interactions feel tactile. Cards lift slightly on hover (translateY -4px + deeper shadow). Buttons have a satisfying "press" effect (scale 0.98 on active). Focus states use a thick Sea Glass outline.

**Animation**: Cards fade in and scale up slightly (from 0.95 to 1.0) on scroll entry. The logo infinity symbol draws itself on first load using an SVG stroke animation. Accordion items in the FAQ expand with a smooth spring easing.

**Typography System**: DM Serif Display (400) for all headings, slightly tighter letter-spacing than default for a more intimate feel. Inter (400) for body at 18px/1.8 — extra generous line height for readability. Warm Gold Inter (600, uppercase) for category labels and eyebrow text.
</text>
<probability>0.07</probability>
</response>

---

## Selected Approach: Idea 1 — "Coastal Calm" (Organic Minimalism)

This approach best embodies the spec's "Warm Minimalism" directive. Its asymmetric layouts avoid the "AI slop" of centred grids, the tidal rhythm creates visual interest without clinical precision, and the emphasis on breath and tactile warmth directly supports the holiday-first, non-clinical brand identity. The gentle interaction philosophy also aligns with accessibility best practices (no sudden movements, no parallax).
