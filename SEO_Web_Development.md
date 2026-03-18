# Best SEO Practices in Modern Web Development

## Executive summary

Search-focused web development today is about building fast, robust, semantically rich, accessible experiences that search engines can crawl, understand, and trust, then enhancing them with structured data to qualify for rich results. Core priorities include clean information architecture, semantic HTML, high-quality content, excellent Core Web Vitals, mobile-first responsive design, careful JavaScript usage, and exhaustive but accurate schema.org structured data implementation.[^1][^2][^3]

***

## 1. Technical eligibility: crawl, render, index

Google will only rank pages that it can crawl, that return a working HTTP 200 status, and that contain indexable content. These are the minimum technical requirements before any further SEO work has impact.[^4][^5]

Key practices:

- Ensure Googlebot is not blocked in `robots.txt` or via `X-Robots-Tag`/`meta robots`.[^5][^4]
- Ensure canonical URLs return HTTP 200 (avoid chains, loops, and soft 404s).[^4]
- Serve primary content as indexable HTML text, not only in images, PDFs, or behind authentication, and avoid spammy or cloaked content.[^5]


### 1.1 Robots controls and options

Robots control mechanisms and their main options:

- `robots.txt` directives (per user agent): `Allow`, `Disallow`, `Crawl-delay` (non-standard), plus sitemap hints via `Sitemap:`.[^6][^4]
- `<meta name="robots">` and equivalent `X-Robots-Tag` header values:
  - Indexing: `index`, `noindex`.[^6]
  - Following links: `follow`, `nofollow`.[^6]
  - Snippets and preview controls: `nosnippet`, `max-snippet`, `max-image-preview`, `max-video-preview`.[^1]
  - Caching: `noarchive`.[^1]
  - Transcoding: `noimageindex`, `nocache` (header) etc.[^1]
- Per-link `rel` values that affect crawling and signals: `nofollow`, `sponsored`, `ugc`, `prev`, `next`, `canonical` (link element), `alternate` (hreflang, AMP, mobile), `prerender`, and others.[^2][^1]

Use `noindex` (not `Disallow`) when you want a URL to be crawled but excluded from the index, and `Disallow` when you want to prevent crawling for privacy or resource reasons.


### 1.2 URL design and architecture

Descriptive, stable, human-readable URLs help both users and search engines. Recommended patterns:[^6]

- Use hyphen-separated, lowercase paths (for example, `/services/home-care/`), avoiding IDs and query strings for core content; keep query parameters for filters and tracking.[^6]
- Keep one canonical URL per piece of content and declare it with `>` to consolidate duplicate variants (HTTP/HTTPS, trailing slash, tracking params).[^1]
- Avoid infinite URL spaces (calendar pages, unbounded filters) by using canonicalization, parameter handling, or disallow rules.


## 2. Information architecture and navigation

A logical hierarchy and clear internal linking help search engines discover and understand relationships between pages. Good IA increases crawl efficiency and concentrates link equity on important URLs.[^1]

Best practices:

- Design a shallow hierarchy where important content is reachable within 3–4 clicks from the homepage.[^1]
- Implement HTML sitemap and XML sitemaps (index + sub-sitemaps for content types) listing canonical, 200, indexable URLs only.[^6][^1]
- Use contextual internal links with descriptive anchor text (for example, "live-in care in Kent" rather than "click here").[^6]


## 3. Semantic HTML and content structure

Semantic HTML enables search engines to infer meaning and hierarchy without over-reliance on heuristics. It also improves accessibility and aligns with how Google renders and indexes pages.[^1]

Key practices:

- Use one `<h1>` per page for the main topic, followed by logically nested `<h2>–<h6>` headings; avoid skipping levels.[^1]
- Use structural elements appropriately: `<header>`, `<nav>`, `<main>`, `<article>`, `<section>`, `<aside>`, `<footer>`.[^1]
- Mark non-decorative images with descriptive `alt` text; omit `alt` or keep it empty only for purely decorative images.[^1]
- Use proper links: `<a href="/path/">` for navigation and indexable URLs instead of `onclick` handlers or `<button>` for primary navigation.[^7][^2]


### 3.1 Metadata and social tags

HTML metadata assists search engines and social networks in displaying useful snippets.

- `<title>`: 50–60 characters is typically display-safe; front-load primary keywords and keep titles unique and descriptive per URL.[^6]
- `<meta name="description">`: 120–160 characters of human-focused summary can influence click-through, though not rankings directly.[^6]
- Open Graph tags (`og:title`, `og:description`, `og:image`, `og:type`, `og:url`) and Twitter Card tags (`twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`) control appearance on social channels, which indirectly supports SEO by improving engagement and links.[^1]


## 4. Content quality and relevance

Search Essentials emphasize creating original, helpful content that demonstrates expertise, experience, authoritativeness, and trustworthiness (E‑E‑A‑T). Google is more likely to rank content that thoroughly answers searcher intent and is well-maintained.[^8][^1]

Implementation in web development workflows:

- Build CMS models that encourage substantial body content, supporting media, FAQs, and related links per page type instead of thin stubs.[^1]
- Provide editable fields for author, last updated date, organization details, and references to support perceived trust and freshness.[^1]
- Avoid doorway pages, spun or AI‑generated content without oversight, and manipulative keyword stuffing.[^8]


## 5. Performance and Core Web Vitals

Core Web Vitals measure real-user loading performance (LCP), interaction responsiveness (INP), and visual stability (CLS); pages with good scores at the 75th percentile provide better UX and are used as a ranking signal. Google recommends LCP under 2.5 s, INP under 200 ms, and CLS below 0.1 for "good" status.[^9][^3]

### 5.1 Metrics and options

Core Web Vitals metrics and their thresholds:

- Largest Contentful Paint (LCP): measures the render time of the largest content element in the viewport; good ≤ 2.5 s, needs improvement ≤ 4 s, poor > 4 s.[^3][^9]
- Interaction to Next Paint (INP): captures worst interaction latency across taps, clicks, and keypresses; good ≤ 200 ms, needs improvement ≤ 500 ms, poor > 500 ms.[^9][^3]
- Cumulative Layout Shift (CLS): quantifies unexpected layout shifts; good ≤ 0.1, needs improvement ≤ 0.25, poor > 0.25.[^3][^9]

Complementary metrics (not strictly CWV but important) include First Contentful Paint (FCP), Time To First Byte (TTFB), and Time To Interactive (TTI), which can be monitored via Lighthouse, PageSpeed Insights, and RUM tooling.[^10]


### 5.2 Implementation techniques

Code-level tactics to improve each metric:

- LCP
  - Serve hero images and above-the-fold content via optimized formats (AVIF/WebP), responsive `srcset`, and `preload` for the main resource.[^10]
  - Minimize render-blocking CSS/JS by inlining critical CSS and deferring or splitting non-critical bundles.[^10]
- INP
  - Reduce main-thread JavaScript by code-splitting, tree-shaking, and removing unused libraries; avoid long tasks over 50 ms.[^11][^10]
  - Debounce expensive event handlers and offload heavy computations to Web Workers where appropriate.[^11]
- CLS
  - Always reserve space for images, ads, and embeds using explicit width/height or aspect-ratio boxes; avoid inserting content above existing content except in response to user interaction.[^3][^10]


## 6. Mobile-first and UX considerations

Google predominantly uses the mobile version of content for indexing and ranking, so mobile usability is critical. Poor mobile UX (zooming, horizontal scrolling, tiny tap targets) can hurt engagement and rankings.[^1]

Key implementation points:

- Use responsive design with fluid grids, flexible images, and viewport meta tags instead of separate m-dot sites where possible.[^1]
- Avoid intrusive interstitials and popups that cover the primary content, particularly on mobile, as they can be treated as a negative signal.[^1]
- Ensure tap targets have adequate size and spacing, text is legible without zooming, and critical interactions are reachable with one hand.


## 7. JavaScript SEO best practices

Google can process JavaScript by rendering pages in a second wave, but rendering is resource-intensive and can be delayed, so essential content and links should not depend solely on client-side rendering. Poorly implemented JS (hash-based routing, blocked JS files, or onclick-only navigation) can lead to indexing gaps.[^12][^13][^2]

Best practices:

- Prefer server-side rendering (SSR), static site generation (SSG), or hybrid rendering so that key content and links appear in the initial HTML.[^7][^12]
- Always use clean, unique URLs (avoid `#!` fragments) and standard `<a href>` links for navigable pages; do not rely exclusively on client-side routers.[^2][^12]
- Do not block JS or CSS files in `robots.txt`, as Google needs them for proper rendering.[^2]
- Keep meta directives, canonical tags, hreflang, and critical structured data in the initial HTML response; avoid modifying `meta robots` or canonical via JS where possible.[^7][^2]


## 8. Structured data (schema.org) in depth

Structured data expresses page meaning in a machine-readable way using vocabularies such as schema.org and formats such as JSON‑LD, microdata, or RDFa; Google recommends JSON‑LD. Properly implemented structured data can make pages eligible for rich results such as carousels, FAQ snippets, product rich cards, and more.[^14][^15]

### 8.1 Formats and placement options

Supported structured data serialization formats:

- JSON‑LD (JavaScript object inside `<script type="application/ld+json">`): Google’s preferred format because it is decoupled from HTML layout.[^15]
- Microdata (attribute-based annotations such as `itemscope`, `itemtype`, `itemprop` added to HTML elements).[^15]
- RDFa (Resource Description Framework in Attributes, using `typeof`, `property`, etc.).[^15]

Placement options:

- Embed per-page JSON‑LD in `<head>` or `<body>`; both are supported as long as data matches visible content.[^15]
- Generate JSON‑LD via server-side templates or JavaScript, but ensure final rendered HTML includes complete, valid markup; test with Rich Results Test and Search Console.[^14][^2]


### 8.2 Rich-result eligible structured data types supported by Google

Google’s Search gallery defines the specific structured data types it supports for rich results. Below is the current list of major features and primary schema types they depend on.[^14]

| Google feature | Primary schema.org type(s) | Typical use case |
|----------------|----------------------------|------------------|
| Article | `Article`, `NewsArticle`, `BlogPosting` | News, blog, and sports articles with enhanced title, image, and carousel appearances.[^14] |
| Breadcrumb | `BreadcrumbList` | Show hierarchical trail under the result snippet.[^14] |
| Carousel (host) | `ItemList` + `Course`, `Movie`, `Recipe`, `Restaurant` | Swipeable list of items from one site.[^14][^16] |
| Course list | `Course` (often inside `ItemList`) | Lists of courses from a provider.[^14] |
| Dataset | `Dataset` | Datasets eligible for Google Dataset Search.[^14] |
| Discussion forum | `DiscussionForumPosting` | Threaded or non-threaded discussion pages.[^14] |
| Education Q&A | `Quiz`, `Question`, `Answer` / flashcards | Education-oriented questions and answers.[^14] |
| Employer aggregate rating | `EmployerAggregateRating` | Aggregate ratings of employers in job search.[^14] |
| Event | `Event` and subtypes | Lists and details of events (concerts, festivals, etc.).[^14] |
| FAQ | `FAQPage` | Lists of questions with authored answers.[^14] |
| Image metadata | `ImageObject` | Additional licensing and creator metadata in Google Images.[^14] |
| Job posting | `JobPosting` | Individual job listings in job search experience.[^14] |
| Local business | `LocalBusiness` and subtypes (for example, `Restaurant`, `MedicalClinic`, `Store`) | Knowledge panel and local enhancements.[^14] |
| Math solver | `MathSolver`, `MathProblem` | Assist with math problem solving.[^14] |
| Movie | `Movie` (often in carousels) | Movie lists and details in carousels.[^14] |
| Organization | `Organization` | Brand knowledge panels and attributions.[^14] |
| Product | `Product`, `Offer`, `AggregateRating`, `Review` | Product rich results with price, availability, and ratings.[^14] |
| Profile page | `ProfilePage` (a `WebPage` subtype) + `Person`/`Organization` | Profile snippets for people or organizations.[^14] |
| Q&A | `QAPage`, `Question`, `Answer` | Multi-answer community Q&A pages.[^14] |
| Recipe | `Recipe` | Recipe cards and host carousels.[^14] |
| Review snippet | `Review`, `AggregateRating` for `Book`, `Product`, `Recipe`, `Movie`, `SoftwareApplication`, `LocalBusiness` | Star ratings in snippets.[^14] |
| Software app | `SoftwareApplication` | App details, ratings, and pricing.[^14] |
| Speakable | `SpeakableSpecification` on `Article` | Content suitable for text-to-speech on Assistant devices.[^14] |
| Subscription / paywalled content | `Article` + `isAccessibleForFree`, `hasPart` | Identification of paywalled vs free content.[^14] |
| Vacation rental | `LodgingBusiness`, `VacationRental`, `Apartment`, `House` | Vacation rental rich results.[^14] |
| Video | `VideoObject` | Video thumbnails, key moments, and live badges.[^14] |

These are not all schema.org types, only those for which Google currently documents rich result eligibility.


### 8.3 Schema.org type system: all available options at the vocabulary level

Schema.org itself defines a far larger ontology than Google’s rich results catalogue, with hundreds of types and related enumerations and datatypes. As of the current documentation, the vocabulary includes around 827 types, 1,528 properties, 14 datatypes, 94 enumerations, and 522 enumeration members.[^17][^18]

Because the full type hierarchy is very large and actively evolving, it is not practical to list every single type in this report; instead, below is the core structure and the main high-level branches that organize "all available options" conceptually.[^18][^17]

- Root type:
  - `Thing`: the most generic type; many types inherit its properties (`name`, `description`, `url`, `image`, etc.).[^19]
- First-level major subtypes of `Thing`:
  - `CreativeWork`: books, articles, music, movies, recipes, software, and other creative outputs.[^19]
  - `Event`: events occurring at a time and place (concerts, festivals, webinars, etc.).[^19]
  - `Intangible`: non-physical concepts, including `Offer`, `Rating`, `Service`, `Brand`, `Language`, and many more.[^19]
  - `Organization`: companies, NGOs, schools, clubs.[^19]
  - `Person`: individuals.[^19]
  - `Place`: physical locations, including `LocalBusiness`, `Accommodation`, `Landform`, etc.[^19]
  - `Product`: tangible and intangible products.[^19]

Within these branches exist hundreds of more specific types; examples of important subtrees for SEO and web development:

- CreativeWork subtree: `Article`, `BlogPosting`, `NewsArticle`, `Book`, `Movie`, `MusicRecording`, `Recipe`, `HowTo`, `FAQPage`, `QAPage`, `SoftwareApplication`, `WebPage`, `WebSite`, `Course`, `VideoObject`, `ImageObject`, and many others.[^17][^18]
- Organization subtree: `LocalBusiness` and its specializations (`Restaurant`, `Dentist`, `Store`, `MedicalOrganization`, `NGO`, etc.), `Corporation`, `EducationalOrganization`.[^18][^17]
- Place subtree: `AdministrativeArea`, `CivicStructure`, `LandmarksOrHistoricalBuildings`, `Accommodation` and its subtypes (`Hotel`, `Apartment`, `House`, etc.).[^17][^18]
- Product/Offer subtree: `Product`, `SomeProducts`, `IndividualProduct`, `ProductModel`, `Offer`, `AggregateOffer`, `Demand`.[^18][^17]
- Event subtree: `BusinessEvent`, `EducationEvent`, `MusicEvent`, `SportsEvent`, `Festival`, etc.[^20][^18]
- Intangible subtree includes:
  - `Brand`, `Service`, `Rating`, `AggregateRating`, `Demand`, `Enumeration`, `Language`, `Audience`, many financial/specification types, and more.[^17][^18]

Schema.org also defines separate hierarchies for:

- Datatypes: `Text`, `Number`, `Boolean`, `Date`, `DateTime`, `URL`, etc.[^19]
- Enumerations: for example `DayOfWeek`, `OfferItemCondition`, `PaymentMethod`, `ReturnFeesEnumeration`, `GamePlayMode`, `MedicalSpecialty`, `WearableSizeGroupEnumeration`, and many more, each with many enumeration members.[^18]

For a genuinely exhaustive list of "all available" schema.org types and enumeration members, use the official "Full hierarchy" browser (`/docs/full.html`) or "Full list of types" index on schema.org, which enumerates every current type, enumeration, and member in the vocabulary.[^17][^18]


### 8.4 Practical selection strategy

To choose the right structured data type in web projects:

- Start from the content model: map each page template (article, service, product, location, FAQ, job, recipe, event, etc.) to the most specific schema.org type available.[^19]
- Ensure that required and recommended properties for Google’s rich result feature (per Search gallery) are present and consistent with visible content.[^14]
- When multiple schema types might apply (for example, a local business that is also a medical clinic), use multiple relevant types or a more specific subtype rather than generic `Thing`.


## 9. Internationalization and hreflang

Multilingual or multi-regional sites should explicitly specify relationships between language variants using `hreflang` link annotations to help Google serve the right version per locale. Incorrect or missing hreflang can cause wrong-language results or content duplication.[^8]

Implementation details:

- Provide `rel="alternate" hreflang="…"` tags either in `<head>` or sitemaps for each alternate, including a self-referencing and x‑default entry.[^8]
- Keep URL structures and page content aligned (for example, `/en-gb/`, `/fr-fr/` paths with matching content language).


## 10. Images, video, and media SEO

Media assets can be major traffic drivers via Google Images and video search; optimized markup and delivery are crucial.[^14]

Best practices:

- Provide high-resolution, descriptive images with `ImageObject` metadata where appropriate, and ensure they are discoverable (not blocked by robots).[^14]
- For videos, expose a dedicated landing page per video, implement `VideoObject` structured data (including `thumbnailUrl`, `description`, `uploadDate`, `duration`), and use video sitemaps for large catalogs.[^14]
- Use lazy loading thoughtfully (for example, `loading="lazy"` for below-the-fold images) while ensuring LCP images are not deferred.[^3][^10]


## 11. Pagination, faceted navigation, and internal signals

Large catalogs often rely on pagination and filtering, which can easily create crawl traps or duplicate content.

Recommendations:

- For pagination, use logical URL patterns (for example, `/category/?page=2`) and strong internal links to important deeper pages; Google no longer uses `rel="prev"/"next"` as a signal but consistent linking still matters.[^8]
- Limit crawlable filter combinations; consider blocklisting non-meaningful facets in `robots.txt`, using canonical tags to consolidate to unfiltered or key variants, and surfacing key filtered views via static links.[^4]
- Avoid infinite scroll without paginated URLs; pair infinite scroll with paginated URLs that expose equivalent content to bots.


## 12. Security, HTTPS, and canonical protocol

HTTPS is a lightweight ranking signal and a requirement for modern browser features, and also helps build user trust. Mixed content or inconsistent protocol usage can lead to duplicate content and security warnings.[^8]

Best practices:

- Serve all pages over HTTPS with valid certificates and redirect HTTP to HTTPS with 301 redirects; declare the HTTPS URL as canonical.[^8]
- Avoid mixed-content issues by ensuring all resources (scripts, images, fonts) are loaded over HTTPS.


## 13. Monitoring, validation, and automation in development

SEO should be integrated into development workflows with automated checks and monitoring.

Key practices:

- Use Google Search Console (coverage, Core Web Vitals, enhancements reports) and log analysis to spot crawl, indexing, and structured data issues.[^9][^3]
- Include Lighthouse/PageSpeed audits, structured data validation, and accessibility checks in CI where possible so regressions are caught before release.[^10][^3]
- Maintain migration playbooks (for example, when changing domain, CMS, or URL structure) that preserve redirects, canonicals, and structured data, and verify via Search Console.


## 14. Putting it together: SEO-first development checklists

For new builds or major refactors, an SEO-first development checklist should cover:

- Technical foundation: crawlability, indexability, status codes, HTTPS, canonicalization, robots controls.[^5][^4]
- Frontend implementation: semantic HTML, headings, metadata, Core Web Vitals budgets, responsive UX, graceful JS behavior.[^3][^1]
- Content and schema: robust content models, E‑E‑A‑T signals, per-template JSON‑LD mapped to schema.org types and Google rich-result requirements.[^17][^14]
- Operations: automated testing, ongoing monitoring, and feedback loops between marketing, content, and engineering teams.[^8]

Following these practices ensures that web development not only ships features but also consistently creates pages that search engines can crawl, understand, and reward with strong visibility and rich search features.[^14][^1]

---

## References

1. [SEO Starter Guide: The Basics | Google Search Central](https://developers.google.com/search/docs/fundamentals/seo-starter-guide) - This guide will walk you through some of the most common and effective improvements you can do on yo...

2. [Understand JavaScript SEO Basics | Google Search Central](https://developers.google.com/search/docs/crawling-indexing/javascript/javascript-seo-basics) - This guide describes how Google Search processes JavaScript and best practices for improving JavaScr...

3. [Understanding Core Web Vitals and Google search results](https://developers.google.com/search/docs/appearance/core-web-vitals) - Core Web Vitals is a set of metrics that measure real-world user experience. Learn more about Google...

4. [3 Essential Technical Requirements to Rank in Google Search - SUSO](https://susodigital.com/thoughts/three-technical-requirements-to-rank-in-google/) - 1. Is the page accessible by Googlebot? · 2. Does the page return a HTTP 200 status code? · 3. Is th...

5. [Google Search Technical Requirements | Documentation](https://developers.google.com/search/docs/essentials/technical) - The technical requirements cover the bare minimum that Google Search needs from a web page in order ...

6. [[PDF] Search Engine Optimization Starter Guide | Outpace SEO](https://outpaceseo.com/wp-content/uploads/2024/06/Google-Search-Engine-Optimization-Starter-Guide.pdf)

7. [JavaScript SEO Best Practices Guide for Beginners - Conductor](https://www.conductor.com/academy/javascript-seo/) - JavaScript SEO best practices explained in layman's terms.

8. [Documentation to Improve SEO | Google Search Central](https://developers.google.com/search/docs) - Explore SEO documentation to learn how to improve your site's visibility on Google Search.

9. [Core Web Vitals report - Search Console Help](https://support.google.com/webmasters/answer/9205520?hl=en) - The Core Web Vitals report shows URL performance grouped by status (Poor, Need improvement, Good), m...

10. [Measure And Optimize Google Core Web Vitals: A Guide | DebugBear](https://www.debugbear.com/docs/metrics/core-web-vitals) - The three Core Web Vitals measure how website visitors experience your website. Google started using...

11. [What Are the Core Web Vitals? LCP, INP & CLS Explained (2026)](https://www.corewebvitals.io/core-web-vitals) - The 3 metrics that make up the Core Web Vitals are: Largest Contentful Paint (LCP), Interaction to N...

12. [The Complete JavaScript SEO Guide - Impression Digital](https://www.impressiondigital.com/blog/javascript-seo-guide/) - In our complete JavaScript SEO Guide, we will uncover the important elements of JavaScript (also kno...

13. [JavaScript SEO: Learn How To Audit & Optimize JS Websites](https://sitebulb.com/javascript-seo/) - Everything you need to do JavaScript SEO. Learn how to identify, audit and optimize JavaScript for s...

14. [Structured Data Markup that Google Search Supports](https://developers.google.com/search/docs/appearance/structured-data/search-gallery) - Explore the structured data-powered features that can appear in Google Search, including examples of...

15. [Intro to How Structured Data Markup Works | Google Search Central](https://developers.google.com/search/docs/appearance/structured-data/intro-structured-data) - Google uses structured data markup to understand content. Explore this guide to discover how structu...

16. [Carousel (ItemList) Structured Data | Google Search Central](https://developers.google.com/search/docs/appearance/structured-data/carousel) - A Google carousel is a row of interactive visual search results. Explore this guide to learn about c...

17. [Schema.org](https://schema.org/docs/schemas.html) - The vocabulary currently consists of 827 Types, 1528 Properties 14 Datatypes, 94 Enumerations and 52...

18. [Full schema hierarchy - Schema.org](https://schema.org/docs/full.html) - Types: · CDCPMDRecord · ContactPoint · PostalAddress · DatedMoneySpecification · DefinedRegion · Eng...

19. [Schema.org Types and properties tutorial](https://www.w3resource.com/schema.org/types-and-properties.php) - Schema.org Tutorial from w3resource. Schema.org is a Open Source porject announced on June 2, 2011 b...

20. [Supported Schema.org Types](https://schema.press/types/) - A list of supported schema.org types which ships in Schema Premium plugin for WordPress for a valid ...

