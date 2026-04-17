<?php
/**
 * Homepage template (static front page).
 *
 * Meta-driven layout: get_post_meta() with defaults from restwell_get_theme_setup_defaults() where needed,
 * same pattern as template-how-it-works.php / template-who-its-for.php.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();
$restwell_fp_seed        = function_exists( 'restwell_get_theme_setup_defaults' ) ? restwell_get_theme_setup_defaults() : array();
$hero_eyebrow            = get_post_meta( $pid, 'hero_eyebrow', true ) ?: 'Restwell Retreats';
$hero_heading            = get_post_meta( $pid, 'hero_heading', true ) ?: 'Accessible Holidays in Whitstable, Kent';
$hero_heading_lines      = preg_split( '/\r\n|\r|\n/', $hero_heading );
$hero_heading_lines      = array_values( array_filter( array_map( 'trim', $hero_heading_lines ), 'strlen' ) );
if ( empty( $hero_heading_lines ) ) {
	$hero_heading_lines = array( 'Accessible Holidays in Whitstable, Kent' );
}
$hero_heading_flat       = trim( preg_replace( '/\s+/', ' ', str_replace( array( "\r\n", "\r", "\n" ), ' ', $hero_heading ) ) );
$hero_subheading         = get_post_meta( $pid, 'hero_subheading', true ) ?: 'Adapted bungalow for guests, families, and carers with whole-property booking.';
$hero_spec_heading       = (string) get_post_meta( $pid, 'hero_spec_heading', true );
// Optional strip under hero only when this meta is non-empty (no default).
$hero_lede               = trim( $hero_subheading . ( $hero_spec_heading !== '' ? ' ' . $hero_spec_heading : '' ) );
$hero_lede_paragraph     = $hero_subheading;
$show_hero_spec_strip    = trim( (string) $hero_spec_heading ) !== '';
$hero_cta_primary_label  = get_post_meta( $pid, 'hero_cta_primary_label', true ) ?: 'View the property';
$hero_cta_primary_url    = get_post_meta( $pid, 'hero_cta_primary_url', true ) ?: '/the-property/';
$hero_cta_secondary_label= get_post_meta( $pid, 'hero_cta_secondary_label', true ) ?: 'Send an enquiry';
$hero_cta_secondary_url  = get_post_meta( $pid, 'hero_cta_secondary_url', true ) ?: '/enquire/';
// Optional line under hero CTAs: unset meta → default; saved empty string → hidden; non-empty → override.
$hero_cta_reassurance_default = __( 'Usually reply within one working day · No obligation', 'restwell-retreats' );
$hero_cta_reassurance_display  = $hero_cta_reassurance_default;
if ( metadata_exists( 'post', $pid, 'hero_cta_reassurance' ) ) {
	$hero_cta_reassurance_raw = get_post_meta( $pid, 'hero_cta_reassurance', true );
	if ( trim( (string) $hero_cta_reassurance_raw ) === '' ) {
		$hero_cta_reassurance_display = '';
	} else {
		$hero_cta_reassurance_display = trim( (string) $hero_cta_reassurance_raw );
	}
}
$hero_media_alt          = $hero_heading_flat;
if ( $hero_lede !== '' ) {
	$combined_alt = $hero_heading_flat . ': ' . $hero_lede;
	if ( strlen( $combined_alt ) <= 200 ) {
		$hero_media_alt = $combined_alt;
	}
}

$home_hero_describedby = array();
if ( trim( (string) $hero_lede_paragraph ) !== '' ) {
	$home_hero_describedby[] = 'home-hero-lede';
}

$home_teaser_label_meta = get_post_meta( $pid, 'home_teaser_label', true );
$show_home_teaser       = ! ( metadata_exists( 'post', $pid, 'home_teaser_label' ) && $home_teaser_label_meta === '' );
$home_teaser_label      = $home_teaser_label_meta !== '' ? $home_teaser_label_meta : 'Area & funding';
$home_teaser_area_title    = get_post_meta( $pid, 'home_teaser_area_title', true ) ?: 'Whitstable & the Kent coast';
$home_teaser_area_body     = get_post_meta( $pid, 'home_teaser_area_body', true ) ?: 'Single-storey bungalow on the Kent coast: harbour, promenade, and day trips with realistic access notes. We focus on step-free routes, parking, and venues where access is described clearly, so you can match the route to a wheelchair, scooter, or walking frame.';
$home_teaser_funding_title = get_post_meta( $pid, 'home_teaser_funding_title', true ) ?: 'Funding your stay';
$home_teaser_funding_body  = get_post_meta( $pid, 'home_teaser_funding_body', true ) ?: 'Many guests use personal budgets, direct payments, NHS Continuing Healthcare, or local authority funding. Our guides explain common routes in plain English: what to ask your social worker, and what paperwork helps.';

// Homepage comparison (Phase 10): clear "heading" in Page Content Fields and save to hide.
$home_comparison_heading_meta = get_post_meta( $pid, 'home_comparison_heading', true );
if ( ! metadata_exists( 'post', $pid, 'home_comparison_heading' ) ) {
	$home_comparison_heading_resolved = isset( $restwell_fp_seed['home_comparison_heading'] )
		? (string) $restwell_fp_seed['home_comparison_heading']
		: __( 'Restwell vs. a typical hotel stay', 'restwell-retreats' );
} else {
	$home_comparison_heading_resolved = trim( (string) $home_comparison_heading_meta );
}
$show_home_comparison = $home_comparison_heading_resolved !== '';
$home_comparison_label = trim( (string) get_post_meta( $pid, 'home_comparison_label', true ) );
if ( $home_comparison_label === '' ) {
	$home_comparison_label = isset( $restwell_fp_seed['home_comparison_label'] )
		? (string) $restwell_fp_seed['home_comparison_label']
		: __( 'Compare options', 'restwell-retreats' );
}
$home_comparison_intro = get_post_meta( $pid, 'home_comparison_intro', true );
if ( ! metadata_exists( 'post', $pid, 'home_comparison_intro' ) ) {
	$home_comparison_intro = isset( $restwell_fp_seed['home_comparison_intro'] ) ? (string) $restwell_fp_seed['home_comparison_intro'] : '';
} else {
	$home_comparison_intro = trim( (string) $home_comparison_intro );
}
$home_comparison_rows = array();
for ( $rw_i = 1; $rw_i <= 4; $rw_i++ ) {
	$fk = 'home_comparison_row' . $rw_i . '_feature';
	$rk = 'home_comparison_row' . $rw_i . '_restwell';
	$ok = 'home_comparison_row' . $rw_i . '_other';
	$df = isset( $restwell_fp_seed[ $fk ] ) ? (string) $restwell_fp_seed[ $fk ] : '';
	$dr = isset( $restwell_fp_seed[ $rk ] ) ? (string) $restwell_fp_seed[ $rk ] : '';
	$do = isset( $restwell_fp_seed[ $ok ] ) ? (string) $restwell_fp_seed[ $ok ] : '';
	$fv = trim( (string) get_post_meta( $pid, $fk, true ) );
	$rv = trim( (string) get_post_meta( $pid, $rk, true ) );
	$ov = trim( (string) get_post_meta( $pid, $ok, true ) );
	$home_comparison_rows[] = array(
		'feature'  => $fv !== '' ? $fv : $df,
		'restwell' => $rv !== '' ? $rv : $dr,
		'other'    => $ov !== '' ? $ov : $do,
	);
}

$home_faq_label_meta   = get_post_meta( $pid, 'home_faq_label', true );
$home_faq_heading_meta = get_post_meta( $pid, 'home_faq_heading', true );
$show_home_faq         = ! ( metadata_exists( 'post', $pid, 'home_faq_heading' ) && $home_faq_heading_meta === '' );
$home_faq_label        = $home_faq_label_meta !== '' ? $home_faq_label_meta : __( 'Quick answers', 'restwell-retreats' );
$home_faq_heading      = $home_faq_heading_meta !== '' ? $home_faq_heading_meta : __( 'Common questions', 'restwell-retreats' );
$home_faq_pairs        = function_exists( 'restwell_get_homepage_faq_pairs' ) ? restwell_get_homepage_faq_pairs( $pid ) : array();

$trust_label          = get_post_meta( $pid, 'trust_label', true ) ?: '';
$trust_heading        = get_post_meta( $pid, 'trust_heading', true ) ?: '';
$trust_badge_image_id = (int) get_post_meta( $pid, 'trust_badge_image_id', true );
$trust_line           = get_post_meta( $pid, 'trust_line', true ) ?: 'Care support by Continuity of Care Services · CQC regulated';
$trust_partner_url    = get_post_meta( $pid, 'trust_partner_url', true ) ?: 'https://www.continuitycareservices.co.uk/';
$trust_line_parts     = array_map( 'trim', explode( '·', $trust_line, 2 ) );
$trust_line_primary   = isset( $trust_line_parts[0] ) ? $trust_line_parts[0] : '';
$trust_line_secondary = isset( $trust_line_parts[1] ) ? $trust_line_parts[1] : '';
$trust_badge_src      = $trust_badge_image_id ? wp_get_attachment_image_url( $trust_badge_image_id, 'medium' ) : '';
$show_trust           = $trust_line !== '' || $trust_badge_src !== '';

$testimonial_label  = get_post_meta( $pid, 'testimonial_label', true ) ?: '';
$testimonial_heading = get_post_meta( $pid, 'testimonial_heading', true ) ?: 'What guests say';
$testimonials = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$q = get_post_meta( $pid, "testimonial_{$i}_quote", true );
	if ( $q !== '' ) {
		$testimonials[] = array(
			'quote' => $q,
			'name'  => get_post_meta( $pid, "testimonial_{$i}_name", true ) ?: '',
			'role'  => get_post_meta( $pid, "testimonial_{$i}_role", true ) ?: '',
		);
	}
}
$show_testimonials = ! empty( $testimonials );

$hero_media_id = absint( get_post_meta( $pid, 'hero_media_id', true ) );
$hero_media_mime = $hero_media_id ? get_post_mime_type( $hero_media_id ) : '';
$hero_is_video  = $hero_media_mime && strpos( $hero_media_mime, 'video/' ) === 0;
$hero_img_size   = function_exists( 'restwell_pick_attachment_size' ) ? restwell_pick_attachment_size( $hero_media_id, 'restwell-hero' ) : 'full';
$hero_media_url  = $hero_media_id ? ( $hero_is_video ? wp_get_attachment_url( $hero_media_id ) : wp_get_attachment_image_url( $hero_media_id, $hero_img_size ) ) : '';

/*
 * Homepage layout tokens: vertical padding from CSS (.rw-section-y / .rw-section-y--cta); see DESIGN-SYSTEM.md.
 * Area & funding teaser adds .rw-section-y--eyebrow-split (label + flex gap above cards for optical balance).
 */
$rw_fp_section_y           = 'rw-section-y';
/** Conversion CTA spacing tier (4-tier CTA tokens). */
$rw_fp_section_y_emphasis = 'rw-section-y--cta';
$rw_fp_inner          = 'max-w-5xl mx-auto';
$rw_fp_inner_narrow   = 'max-w-3xl mx-auto';
$rw_fp_head_block     = 'rw-mb-section';
$rw_fp_head_tight     = 'rw-mb-section-tight';
$rw_fp_stack_gap      = 'rw-gap-grid';
$rw_fp_stack_gap_lg   = 'rw-gap-grid-lg';
$rw_fp_cta_mt         = 'mt-8 md:mt-10';
$rw_fp_card_pad       = 'p-6 md:p-8';
/** Solid white cards: persistent boundaries + hover lift (teaser, highlights, who, property copy, shared pattern). */
$rw_fp_card_surface_solid = 'rounded-2xl border border-gray-100 bg-white shadow-sm transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-md';
/** Comparison feature checklist (wider for 3-column grid) */
$rw_fp_inner_comparison = 'max-w-5xl mx-auto';

$rw_fp_resolve_href = static function ( $url ) {
	$url = trim( (string) $url );
	if ( $url === '' ) {
		return home_url( '/' );
	}
	if ( preg_match( '#^https?://#i', $url ) ) {
		return $url;
	}
	return home_url( $url );
};

// Merged front-page meta (theme defaults when a key is empty).
$m = array();
foreach ( $restwell_fp_seed as $key => $default ) {
	$v = get_post_meta( $pid, $key, true );
	if ( 'property_image_id' === $key || 'cta_image_id' === $key ) {
		$vid         = (int) $v;
		$m[ $key ] = $vid > 0 ? $vid : (int) $default;
		continue;
	}
	if ( $v === '' || null === $v ) {
		$m[ $key ] = $default;
	} else {
		$m[ $key ] = $v;
	}
}

$property_image_id         = (int) ( $m['property_image_id'] ?? 0 );
$property_heading          = isset( $m['property_heading'] ) ? (string) $m['property_heading'] : '';
$property_body             = isset( $m['property_body'] ) ? (string) $m['property_body'] : '';
$property_body_canonical   = isset( $restwell_fp_seed['property_body'] ) ? trim( (string) $restwell_fp_seed['property_body'] ) : '';
$property_body_trimmed     = trim( $property_body );

$fp_acc   = get_page_by_path( 'accessibility', OBJECT, 'page' );
$fp_who   = get_page_by_path( 'who-its-for', OBJECT, 'page' );
$fp_guide = get_page_by_path( 'whitstable-area-guide', OBJECT, 'page' );
$fp_faq   = get_page_by_path( 'faq', OBJECT, 'page' );
/** Homepage property card only: keep the list short (full site nav still covers other pages). */
$fp_quick_items = array();
if ( $fp_acc ) {
	$fp_quick_items[] = array(
		'href'  => get_permalink( $fp_acc ),
		'label' => __( 'Specification & measurements', 'restwell-retreats' ),
	);
}
if ( $fp_who ) {
	$fp_quick_items[] = array(
		'href'  => get_permalink( $fp_who ),
		'label' => __( 'Who it\'s for', 'restwell-retreats' ),
	);
}
if ( $fp_guide ) {
	$fp_quick_items[] = array(
		'href'  => get_permalink( $fp_guide ),
		'label' => __( 'Town, harbour & coast', 'restwell-retreats' ),
	);
}
if ( $fp_faq ) {
	$fp_quick_items[] = array(
		'href'  => get_permalink( $fp_faq ),
		'label' => __( 'FAQ', 'restwell-retreats' ),
	);
}

$cta_image_id = (int) ( $m['cta_image_id'] ?? 0 );

$hero_cta_primary_href   = $rw_fp_resolve_href( $hero_cta_primary_url );
$hero_cta_secondary_href = $rw_fp_resolve_href( $hero_cta_secondary_url );

$rw_fp_cta_promise_display = isset( $m['cta_promise'] ) ? trim( (string) $m['cta_promise'] ) : '';
if ( $rw_fp_cta_promise_display === '' ) {
	$rw_fp_cta_promise_display = __( 'No booking commitment. Replies usually within one working day.', 'restwell-retreats' );
}

/*
 * Zebra section backgrounds: alternate white and theme soft-sand for each *rendered* major band (skips hidden sections).
 */
$rw_fp_bg_white = 'bg-white';
$rw_fp_bg_sand  = 'bg-[var(--soft-sand)]';
$rw_fp_major_bands = array();
if ( $show_home_teaser ) {
	$rw_fp_major_bands[] = 'teaser';
}
$rw_fp_major_bands[] = 'who';
$rw_fp_major_bands[] = 'property';
if ( $show_testimonials ) {
	$rw_fp_major_bands[] = 'testimonials';
}
$rw_fp_major_bands[] = 'features';
if ( $show_home_comparison ) {
	$rw_fp_major_bands[] = 'comparison';
}
if ( $show_home_faq && ! empty( $home_faq_pairs ) ) {
	$rw_fp_major_bands[] = 'faq';
}
if ( $show_trust ) {
	$rw_fp_major_bands[] = 'trust';
}
$rw_fp_band_bg = array();
foreach ( $rw_fp_major_bands as $rw_fp_bi => $rw_fp_band_id ) {
	$rw_fp_band_bg[ $rw_fp_band_id ] = ( 0 === ( $rw_fp_bi % 2 ) ) ? $rw_fp_bg_white : $rw_fp_bg_sand;
}
$rw_fp_teaser_bg       = isset( $rw_fp_band_bg['teaser'] ) ? $rw_fp_band_bg['teaser'] : '';
$rw_fp_who_bg          = $rw_fp_band_bg['who'] ?? $rw_fp_bg_sand;
$rw_fp_property_bg     = $rw_fp_band_bg['property'] ?? $rw_fp_bg_white;
$rw_fp_testimonials_bg = isset( $rw_fp_band_bg['testimonials'] ) ? $rw_fp_band_bg['testimonials'] : '';
$rw_fp_features_bg     = $rw_fp_band_bg['features'] ?? $rw_fp_bg_sand;
$rw_fp_comparison_bg   = isset( $rw_fp_band_bg['comparison'] ) ? $rw_fp_band_bg['comparison'] : '';
$rw_fp_faq_bg          = isset( $rw_fp_band_bg['faq'] ) ? $rw_fp_band_bg['faq'] : '';
$rw_fp_trust_bg        = isset( $rw_fp_band_bg['trust'] ) ? $rw_fp_band_bg['trust'] : '';
?>
<main class="flex-1" id="main-content">
	<!--
		Homepage order (wireframe): hero → spec strip → discovery cards (area & funding)
		→ who (guest/carer) → property spotlight → testimonials → why Restwell → bottom CTA → comparison → FAQ → trust.
	-->
	<!-- Hero Section -->
	<section class="hero home-hero relative flex overflow-hidden <?php echo ( $hero_media_id && $hero_media_url ) ? 'hero--has-media' : ''; ?> <?php echo ( $hero_media_id && $hero_is_video ) ? 'hero--has-video' : ''; ?> <?php echo $hero_media_id ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="home-hero-heading"<?php echo ! empty( $home_hero_describedby ) ? ' aria-describedby="' . esc_attr( implode( ' ', $home_hero_describedby ) ) . '"' : ''; ?>>
		<?php if ( $hero_media_id && $hero_media_url ) : ?>
			<?php if ( $hero_is_video ) : ?>
				<div class="home-hero__media home-hero__media--video absolute inset-0 z-0 overflow-hidden pointer-events-none" aria-hidden="true">
				<video
					class="home-hero__video absolute inset-0 h-full w-full min-h-full min-w-full object-cover"
					autoplay
					muted
					loop
					playsinline
					preload="metadata"
					disablepictureinpicture
					disableremoteplayback
					aria-hidden="true"
				>
					<source src="<?php echo esc_url( $hero_media_url ); ?>" type="<?php echo esc_attr( $hero_media_mime ); ?>">
				</video>
				</div>
			<?php else : ?>
				<?php
				echo wp_get_attachment_image(
					$hero_media_id,
					$hero_img_size,
					false,
					array(
						'class'         => 'absolute inset-0 w-full h-full object-cover -z-10',
						'alt'           => $hero_media_alt,
						'loading'       => 'eager',
						'fetchpriority' => 'high',
						'decoding'      => 'async',
						'sizes'         => '100vw',
					)
				);
				?>
			<?php endif; ?>
		<?php endif; ?>
		<div class="relative z-10 container w-full">
			<div class="home-hero__copy w-full">
				<div class="home-hero__main-cluster">
					<div class="home-hero__text-stack">
						<?php if ( $hero_eyebrow !== '' ) : ?>
						<span class="home-hero__eyebrow block text-xs uppercase tracking-[0.2em] font-sans">
							<?php echo esc_html( $hero_eyebrow ); ?>
						</span>
						<?php endif; ?>
						<h1 id="home-hero-heading" class="home-hero__heading m-0 text-white">
							<span class="home-hero__title-lines block space-y-2 font-serif">
								<?php foreach ( $hero_heading_lines as $hero_heading_line ) : ?>
								<span class="block"><?php echo esc_html( $hero_heading_line ); ?></span>
								<?php endforeach; ?>
							</span>
						</h1>
						<?php if ( trim( (string) $hero_lede_paragraph ) !== '' ) : ?>
						<p id="home-hero-lede" class="home-hero__lede max-w-prose text-white [text-shadow:0_2px_4px_rgba(0,0,0,0.3)] font-sans text-base sm:text-lg md:text-xl font-normal leading-relaxed tracking-normal sm:tracking-tight text-balance m-0">
							<?php echo esc_html( $hero_lede_paragraph ); ?>
						</p>
						<?php endif; ?>
					</div>
					<div class="home-hero__cta-stack">
						<a
							id="hero-cta-primary"
							href="<?php echo esc_url( $hero_cta_primary_href ); ?>"
							class="btn btn-gold cursor-pointer"
							data-cta="hero-primary"
						>
							<?php echo esc_html( $hero_cta_primary_label ); ?>
							<i class="ph-bold ph-caret-right" aria-hidden="true"></i>
						</a>
						<a
							id="hero-cta-secondary"
							href="<?php echo esc_url( $hero_cta_secondary_href ); ?>"
							class="home-hero__cta-secondary btn cursor-pointer"
							data-cta="hero-secondary"
						>
							<?php echo esc_html( $hero_cta_secondary_label ); ?>
						</a>
					</div>
					<?php if ( $hero_cta_reassurance_display !== '' ) : ?>
					<p id="home-hero-reassurance" class="home-hero__reassurance m-0 mt-3 text-white/90 text-sm font-sans leading-snug [text-shadow:0_1px_2px_rgba(0,0,0,0.35)]">
						<?php echo esc_html( $hero_cta_reassurance_display ); ?>
					</p>
					<?php endif; ?>
					<p class="home-hero__scroll-hint m-0 text-center">
						<a href="#restwell-main-after-hero" class="home-hero__scroll-link">
							<span class="home-hero__scroll-link-text"><?php esc_html_e( 'Scroll to explore', 'restwell-retreats' ); ?></span>
							<i class="ph-bold ph-caret-down home-hero__scroll-icon" aria-hidden="true"></i>
						</a>
					</p>
				</div>
			</div>
		</div>
	</section>
	<div id="restwell-main-after-hero" class="home-hero__scroll-anchor" tabindex="-1"></div>

	<?php if ( $show_hero_spec_strip ) : ?>
	<section
		class="home-hero-equipment-strip py-0 bg-[var(--soft-sand)] border-b border-[var(--deep-teal)]/10"
		aria-labelledby="home-hero-spec-strip-heading"
	>
		<div class="container py-4 md:py-5">
			<h2 id="home-hero-spec-strip-heading" class="sr-only">
				<?php esc_html_e( 'On-site equipment and booking detail', 'restwell-retreats' ); ?>
			</h2>
			<p class="home-hero-equipment-strip__text m-0 text-[var(--deep-teal)] font-sans text-sm sm:text-base leading-relaxed max-w-4xl mx-auto">
				<?php echo esc_html( $hero_spec_heading ); ?>
			</p>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $show_home_teaser ) : ?>
	<section
		class="home-teaser-area-funding <?php echo esc_attr( $rw_fp_section_y . ' rw-section-y--eyebrow-split ' . $rw_fp_teaser_bg ); ?> rw-seam-y-soft"
		aria-label="<?php echo esc_attr( $home_teaser_label ); ?>"
	>
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?> flex flex-col gap-5 md:gap-6 lg:gap-7">
				<header class="text-left m-0">
					<h2 class="sr-only"><?php echo esc_html( $home_teaser_label ); ?></h2>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $home_teaser_label ) ); ?>
				</header>
				<div class="home-teaser__grid who-section__grid grid grid-cols-1 md:grid-cols-2 items-start <?php echo esc_attr( $rw_fp_stack_gap ); ?>">
					<div class="flex flex-col rw-stack <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
						<h3 id="home-teaser-area-heading" class="text-xl md:text-2xl font-serif text-[var(--deep-teal)] leading-tight m-0 text-balance"><?php echo esc_html( $home_teaser_area_title ); ?></h3>
						<p class="text-[#3a5a63] leading-relaxed m-0 max-w-prose text-base"><?php echo esc_html( $home_teaser_area_body ); ?></p>
						<?php
						$fp_teaser_guide = get_page_by_path( 'whitstable-area-guide', OBJECT, 'page' );
						if ( $fp_teaser_guide ) :
							?>
						<p class="m-0 pt-3">
							<a
								href="<?php echo esc_url( get_permalink( $fp_teaser_guide ) ); ?>"
								class="restwell-tap-link inline-flex items-center gap-2 text-[var(--deep-teal)] font-semibold underline-offset-2 hover:underline hover:text-[var(--warm-gold-text)] transition-colors duration-300 no-underline cursor-pointer min-h-[44px]"
							>
								<?php esc_html_e( 'Whitstable & Kent guide', 'restwell-retreats' ); ?>
								<i class="ph-bold ph-caret-right text-sm" aria-hidden="true"></i>
							</a>
						</p>
						<?php endif; ?>
					</div>
					<div class="flex flex-col rw-stack <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
						<h3 id="home-teaser-funding-heading" class="text-xl md:text-2xl font-serif text-[var(--deep-teal)] leading-tight m-0 text-balance"><?php echo esc_html( $home_teaser_funding_title ); ?></h3>
						<p class="text-[#3a5a63] leading-relaxed m-0 max-w-prose text-base"><?php echo esc_html( $home_teaser_funding_body ); ?></p>
						<?php
						$fp_teaser_res = get_page_by_path( 'resources', OBJECT, 'page' );
						if ( $fp_teaser_res ) :
							?>
						<p class="m-0 pt-3">
							<a
								href="<?php echo esc_url( get_permalink( $fp_teaser_res ) ); ?>"
								class="restwell-tap-link inline-flex items-center gap-2 text-[var(--deep-teal)] font-semibold underline-offset-2 hover:underline hover:text-[var(--warm-gold-text)] transition-colors duration-300 no-underline cursor-pointer min-h-[44px]"
							>
								<?php esc_html_e( 'Funding & support', 'restwell-retreats' ); ?>
								<i class="ph-bold ph-caret-right text-sm" aria-hidden="true"></i>
							</a>
						</p>
						<?php endif; ?>
					</div>
				</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- Who it's for -->
	<section class="who-section <?php echo esc_attr( $rw_fp_section_y . ' ' . $rw_fp_who_bg ); ?>">
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
			<div class="text-center max-w-3xl mx-auto rw-stack <?php echo esc_attr( $rw_fp_head_block ); ?>">
				<?php
				$who_label_out = isset( $m['who_label'] ) ? trim( (string) $m['who_label'] ) : '';
				if ( $who_label_out !== '' ) {
					get_template_part( 'template-parts/section-label', null, array( 'label' => $who_label_out ) );
				}
				?>
				<h2 class="text-3xl md:text-4xl section-heading m-0 text-balance"><?php echo esc_html( $m['who_heading'] ?? '' ); ?></h2>
			</div>
			<div class="who-section__grid grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr( $rw_fp_stack_gap_lg ); ?> items-stretch">
				<article class="who-card flex flex-col items-center text-center md:items-start md:text-left md:min-h-[18rem] <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
					<div class="who-card__stack flex w-full flex-col items-center md:items-start rw-stack">
						<p class="m-0 text-xs font-semibold uppercase tracking-[0.18em] text-[var(--deep-teal)]/85"><?php esc_html_e( 'Independence', 'restwell-retreats' ); ?></p>
						<div class="flex h-14 w-14 items-center justify-center rounded-full bg-[var(--sea-glass)]/30 text-[var(--deep-teal)]" aria-hidden="true">
							<i class="ph-bold ph-house text-2xl" aria-hidden="true"></i>
						</div>
						<h3 class="text-xl md:text-2xl font-serif text-[var(--deep-teal)] m-0 text-balance"><?php echo esc_html( $m['who_guest_title'] ?? '' ); ?></h3>
						<p class="who-card__body text-[#3a5a63] leading-relaxed m-0 w-full text-pretty"><?php echo esc_html( $m['who_guest_body'] ?? '' ); ?></p>
					</div>
				</article>
				<article class="who-card flex flex-col items-center text-center md:items-start md:text-left md:min-h-[18rem] <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
					<div class="who-card__stack flex w-full flex-col items-center md:items-start rw-stack">
						<p class="m-0 text-xs font-semibold uppercase tracking-[0.18em] text-[var(--deep-teal)]/85"><?php esc_html_e( 'Peace of mind', 'restwell-retreats' ); ?></p>
						<div class="flex h-14 w-14 items-center justify-center rounded-full bg-[var(--soft-sand)] text-[var(--deep-teal)]" aria-hidden="true">
							<i class="ph-bold ph-heart text-2xl" aria-hidden="true"></i>
						</div>
						<h3 class="text-xl md:text-2xl font-serif text-[var(--deep-teal)] m-0 text-balance"><?php echo esc_html( $m['who_carer_title'] ?? '' ); ?></h3>
						<p class="who-card__body text-[#3a5a63] leading-relaxed m-0 w-full text-pretty"><?php echo esc_html( $m['who_carer_body'] ?? '' ); ?></p>
					</div>
				</article>
			</div>
			<?php if ( $fp_who ) : ?>
			<p class="text-center text-sm text-[#3a5a63] <?php echo esc_attr( $rw_fp_cta_mt ); ?> m-0">
				<a href="<?php echo esc_url( get_permalink( $fp_who ) ); ?>"
					class="who-section__cta restwell-tap-link text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline cursor-pointer min-h-[44px] inline-flex items-center justify-center py-2 px-3">
					<?php esc_html_e( 'Find out if Restwell is right for you →', 'restwell-retreats' ); ?>
				</a>
			</p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Property snapshot: photo-first, editorial copy, minimal link list -->
	<section class="property-section <?php echo esc_attr( $rw_fp_section_y . ' ' . $rw_fp_property_bg ); ?>" aria-labelledby="home-property-heading">
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
			<div class="property-grid property-grid--home grid grid-cols-1 gap-x-0 gap-y-9 md:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] md:items-start md:gap-x-10 md:gap-y-0">
				<div class="property-grid__media w-full md:min-h-0">
					<figure class="property-section__figure relative m-0 flex min-h-[min(65vw,18rem)] flex-col overflow-hidden rounded-2xl bg-[#E8DFD0] shadow-[0_8px_30px_rgb(0,0,0,0.06)] ring-1 ring-black/[0.04] md:min-h-[24rem]">
					<?php if ( $property_image_id ) : ?>
						<?php
						$property_img_size = function_exists( 'restwell_pick_attachment_size' ) ? restwell_pick_attachment_size( $property_image_id, 'restwell-hero', 'large' ) : 'large';
						echo wp_get_attachment_image(
							$property_image_id,
							$property_img_size,
							false,
							array(
								'class'    => 'property-section__photo aspect-[4/3] w-full object-cover md:absolute md:inset-0 md:aspect-auto md:h-full md:min-h-full md:w-full',
								'alt'      => $property_heading,
								'loading'  => 'lazy',
								'decoding' => 'async',
								'sizes'    => '(min-width: 768px) 48vw, 100vw',
							)
						);
						?>
					<?php else : ?>
						<div class="property-section__placeholder relative z-[1] flex min-h-[min(65vw,18rem)] flex-col items-center justify-center gap-2.5 px-5 py-10 text-center md:min-h-[24rem]">
							<i class="ph-bold ph-image text-3xl text-[var(--deep-teal)]/45" aria-hidden="true"></i>
							<span class="max-w-[20rem] text-base leading-relaxed text-[#3a5a63]"><?php esc_html_e( 'Add a property image in the homepage editor to show the bungalow here.', 'restwell-retreats' ); ?></span>
						</div>
					<?php endif; ?>
					</figure>
				</div>
				<div class="property-grid__text w-full min-w-0">
					<div class="property-section__panel rounded-2xl border border-gray-100 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
						<div class="property-section__panel-inner rw-stack--regions">
					<div class="property-section__intro rw-stack max-w-prose">
					<?php
					$property_label_out = isset( $m['property_label'] ) ? trim( (string) $m['property_label'] ) : '';
					if ( $property_label_out !== '' ) {
						get_template_part( 'template-parts/section-label', null, array( 'label' => $property_label_out ) );
					}
					?>
					<h2 id="home-property-heading" class="text-3xl md:text-4xl section-heading m-0 text-balance leading-tight"><?php echo esc_html( $property_heading ); ?></h2>
					<div class="property-section__body rw-stack">
					<?php if ( $property_body_canonical !== '' && $property_body_trimmed === $property_body_canonical ) : ?>
						<p class="m-0 text-pretty text-base leading-relaxed text-[#3a5a63] sm:text-[1.05rem]"><?php esc_html_e( 'An adapted single-storey property in Whitstable: level approach from the street, off-street parking for adapted vehicles, and a flat route toward the Tankerton promenade.', 'restwell-retreats' ); ?></p>
						<ul class="property-section__highlights rw-stack m-0 list-none p-0 text-[0.98rem] leading-relaxed text-[#3a5a63] sm:text-[1rem]" role="list">
							<li class="flex gap-2.5">
								<span class="property-section__check mt-0.5 shrink-0 text-[var(--deep-teal)]" aria-hidden="true"><i class="ph-bold ph-check text-[1.05rem]" aria-hidden="true"></i></span>
								<span class="text-pretty"><?php esc_html_e( 'Flat route toward the Tankerton promenade and practical access from parking to the door.', 'restwell-retreats' ); ?></span>
							</li>
							<li class="flex gap-2.5">
								<span class="property-section__check mt-0.5 shrink-0 text-[var(--deep-teal)]" aria-hidden="true"><i class="ph-bold ph-check text-[1.05rem]" aria-hidden="true"></i></span>
								<span class="text-pretty"><?php esc_html_e( 'Whitstable town centre (harbour, seafood restaurants, and the waterfront) is close enough for day trips without stressful route planning.', 'restwell-retreats' ); ?></span>
							</li>
						</ul>
					<?php else : ?>
						<p class="text-[#3a5a63] leading-relaxed m-0 text-pretty"><?php echo esc_html( $property_body ); ?></p>
					<?php endif; ?>
					</div>
					</div>

					<?php if ( ! empty( $fp_quick_items ) ) : ?>
					<div class="property-section__explore border-t border-stone-200/70">
						<p id="property-explore-label" class="property-section__explore-label text-sm font-semibold leading-snug text-[var(--deep-teal)]"><?php esc_html_e( 'Explore further', 'restwell-retreats' ); ?></p>
						<nav class="property-section__quick-nav" aria-labelledby="property-explore-label">
							<ul class="property-section__linklist m-0 list-none divide-y divide-stone-200/80 border-y border-stone-200/70 p-0" role="list">
								<?php foreach ( $fp_quick_items as $fp_quick_item ) : ?>
								<li class="m-0">
									<a
										href="<?php echo esc_url( $fp_quick_item['href'] ); ?>"
										class="property-section__quick-link group flex min-h-[48px] items-center justify-between gap-3 py-3 text-left text-[0.9375rem] font-medium leading-snug text-[#3a5a63] transition-colors duration-200 hover:text-[var(--deep-teal)] focus-visible:outline focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-[var(--deep-teal)] cursor-pointer"
									>
										<span class="min-w-0 flex-1"><?php echo esc_html( $fp_quick_item['label'] ); ?></span>
										<i class="ph-bold ph-caret-right shrink-0 text-[var(--deep-teal)]/40 transition-transform duration-200 group-hover:translate-x-0.5 group-hover:text-[var(--deep-teal)]/70 motion-reduce:transition-none motion-reduce:group-hover:translate-x-0" aria-hidden="true"></i>
									</a>
								</li>
								<?php endforeach; ?>
							</ul>
						</nav>
					</div>
					<?php endif; ?>

					<a
						href="<?php echo esc_url( $rw_fp_resolve_href( isset( $m['property_cta_url'] ) ? (string) $m['property_cta_url'] : '' ) ); ?>"
						class="property-section__cta inline-flex w-full min-h-[48px] items-center justify-center gap-2 rounded-xl bg-[var(--deep-teal)] px-5 py-3 text-center text-[0.98rem] font-semibold text-white shadow-sm transition-colors duration-200 hover:bg-[#163f4d] focus-visible:outline focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-[var(--deep-teal)] cursor-pointer sm:w-auto sm:min-w-[14rem]"
						data-cta="property-explore"
					>
						<?php echo esc_html( $m['property_cta_label'] ?? '' ); ?>
						<i class="ph-bold ph-arrow-right text-lg" aria-hidden="true"></i>
					</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $show_testimonials ) : ?>
	<!-- Testimonials: after property spotlight, before “why Restwell” (wireframe flow). -->
	<section class="testimonials-section <?php echo esc_attr( $rw_fp_section_y . ' ' . $rw_fp_testimonials_bg ); ?> rw-seam-t" aria-labelledby="home-testimonials-heading">
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
			<div class="text-center max-w-3xl mx-auto rw-stack <?php echo esc_attr( $rw_fp_head_block ); ?>">
				<?php if ( $testimonial_label !== '' ) : ?>
					<p class="section-label"><?php echo esc_html( $testimonial_label ); ?></p>
				<?php endif; ?>
				<h2 id="home-testimonials-heading" class="text-3xl md:text-4xl section-heading m-0 text-balance"><?php echo esc_html( $testimonial_heading ); ?></h2>
			</div>
			<ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 <?php echo esc_attr( $rw_fp_stack_gap_lg ); ?> list-none p-0 m-0" role="list">
				<?php foreach ( $testimonials as $t ) : ?>
				<li>
					<article class="h-full flex flex-col <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
						<blockquote class="m-0 flex flex-col flex-1">
							<p class="restwell-prose-readable text-[#3a5a63] leading-relaxed flex-1 mb-4 text-pretty"><?php echo esc_html( $t['quote'] ); ?></p>
							<footer class="text-[var(--deep-teal)] font-medium">
								<?php echo esc_html( $t['name'] ); ?>
								<?php if ( $t['role'] !== '' ) : ?>
									<span class="block text-sm font-normal text-[#3a5a63]"><?php echo esc_html( $t['role'] ); ?></span>
								<?php endif; ?>
							</footer>
						</blockquote>
					</article>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php endif; ?>

	<!-- Why Restwell: rw-section-y--head-grid-split balances .rw-mb-section before the grid; see DESIGN-SYSTEM.md -->
	<section class="features-section <?php echo esc_attr( $rw_fp_section_y . ' rw-section-y--head-grid-split ' . $rw_fp_features_bg ); ?> rw-seam-t" aria-labelledby="home-why-restwell-heading">
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
			<div class="text-center rw-stack <?php echo esc_attr( $rw_fp_head_block ); ?>">
				<span class="section-label block"><?php echo esc_html( $m['why_label'] ?? '' ); ?></span>
				<h2 id="home-why-restwell-heading" class="text-3xl md:text-4xl section-heading m-0"><?php echo esc_html( $m['why_heading'] ?? '' ); ?></h2>
			</div>
			<ul class="grid grid-cols-1 items-stretch md:grid-cols-2 lg:grid-cols-4 <?php echo esc_attr( $rw_fp_stack_gap ); ?> list-none p-0 m-0" role="list">
				<li class="feature-item group h-full min-h-0 text-center rw-stack <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
					<div class="feature-icon-wrapper mx-auto">
						<div class="feature-icon-blob"></div>
						<i class="ph-bold ph-house feature-icon-svg text-[var(--deep-teal)] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] text-center m-0"><?php echo esc_html( $m['why_item1_title'] ?? '' ); ?></h3>
					<p class="feature-item__body text-base text-[#3a5a63] leading-relaxed text-center m-0"><?php echo esc_html( $m['why_item1_desc'] ?? '' ); ?></p>
				</li>
				<li class="feature-item group h-full min-h-0 text-center rw-stack <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
					<div class="feature-icon-wrapper mx-auto">
						<div class="feature-icon-blob"></div>
						<i class="ph-bold ph-shield-check feature-icon-svg text-[var(--deep-teal)] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] text-center m-0"><?php echo esc_html( $m['why_item2_title'] ?? '' ); ?></h3>
					<p class="feature-item__body text-base text-[#3a5a63] leading-relaxed text-center m-0"><?php echo esc_html( $m['why_item2_desc'] ?? '' ); ?></p>
				</li>
				<li class="feature-item group h-full min-h-0 text-center rw-stack <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
					<div class="feature-icon-wrapper mx-auto">
						<div class="feature-icon-blob"></div>
						<i class="ph-bold ph-map-pin feature-icon-svg text-[var(--deep-teal)] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] text-center m-0"><?php echo esc_html( $m['why_item3_title'] ?? '' ); ?></h3>
					<p class="feature-item__body text-base text-[#3a5a63] leading-relaxed text-center m-0"><?php echo esc_html( $m['why_item3_desc'] ?? '' ); ?></p>
				</li>
				<li class="feature-item group h-full min-h-0 text-center rw-stack <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
					<div class="feature-icon-wrapper mx-auto">
						<div class="feature-icon-blob"></div>
						<i class="ph-bold ph-heart feature-icon-svg text-[var(--deep-teal)] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] text-center m-0"><?php echo esc_html( $m['why_item4_title'] ?? '' ); ?></h3>
					<p class="feature-item__body text-base text-[#3a5a63] leading-relaxed text-center m-0"><?php echo esc_html( $m['why_item4_desc'] ?? '' ); ?></p>
				</li>
			</ul>
		</div>
	</section>

	<!-- Bottom CTA -->
	<section class="cta-section relative <?php echo esc_attr( $rw_fp_section_y_emphasis ); ?> rw-seam-t overflow-hidden">
		<?php if ( $cta_image_id ) : ?>
			<?php
			echo wp_get_attachment_image(
				$cta_image_id,
				'full',
				false,
				array(
					'class'       => 'absolute inset-0 w-full h-full object-cover -z-10',
					'alt'         => '',
					'loading'     => 'lazy',
					'decoding'    => 'async',
					'sizes'       => '100vw',
					'aria-hidden' => 'true',
				)
			);
			?>
		<?php endif; ?>
		<div class="absolute inset-0 bg-[#1B4D5C]/75" aria-hidden="true"></div>
		<div class="relative container text-center rw-stack <?php echo esc_attr( $rw_fp_inner_narrow ); ?>">
			<h2 class="text-white text-3xl md:text-4xl m-0"><?php echo esc_html( $m['cta_heading'] ?? '' ); ?></h2>
			<p class="text-white/95 text-lg max-w-prose mx-auto m-0 text-pretty">
				<?php echo esc_html( $m['cta_body'] ?? '' ); ?>
			</p>
			<div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-5">
				<a
					id="bottom-cta-enquire"
					href="<?php echo esc_url( $rw_fp_resolve_href( isset( $m['cta_primary_url'] ) ? (string) $m['cta_primary_url'] : '' ) ); ?>"
					class="btn btn-gold w-full sm:w-auto"
					data-cta="cta-enquire"
				>
					<?php echo esc_html( $m['cta_primary_label'] ?? '' ); ?>
				</a>
				<a
					href="<?php echo esc_url( $rw_fp_resolve_href( isset( $m['cta_secondary_url'] ) ? (string) $m['cta_secondary_url'] : '' ) ); ?>"
					class="btn btn-ghost-light w-full sm:w-auto"
					data-cta="cta-property"
				>
					<?php echo esc_html( $m['cta_secondary_label'] ?? '' ); ?>
				</a>
			</div>
			<p class="text-white/90 text-sm m-0"><?php echo esc_html( $rw_fp_cta_promise_display ); ?></p>
		</div>
	</section>

	<?php if ( $show_home_comparison ) : ?>
	<section class="home-comparison-section <?php echo esc_attr( $rw_fp_section_y . ' ' . $rw_fp_comparison_bg ); ?> rw-seam-t" aria-labelledby="home-comparison-heading" aria-describedby="home-comparison-summary">
		<div class="container <?php echo esc_attr( $rw_fp_inner_comparison ); ?>">
			<header class="text-center rw-stack <?php echo esc_attr( $rw_fp_head_tight ); ?> max-w-2xl mx-auto">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $home_comparison_label ) ); ?>
				<h2 id="home-comparison-heading" class="text-3xl md:text-4xl section-heading m-0 text-balance text-[var(--deep-teal)]"><?php echo esc_html( $home_comparison_heading_resolved ); ?></h2>
				<?php if ( $home_comparison_intro !== '' ) : ?>
				<p class="text-[var(--body-secondary)] leading-relaxed max-w-prose m-0 mx-auto text-center text-pretty md:text-lg md:leading-relaxed"><?php echo esc_html( $home_comparison_intro ); ?></p>
				<?php endif; ?>
			</header>
			<p id="home-comparison-summary" class="sr-only"><?php echo esc_html( $home_comparison_heading_resolved ); ?>: <?php esc_html_e( 'four-row comparison of Restwell and hotel or care setting.', 'restwell-retreats' ); ?></p>
			<p id="home-comparison-scroll-hint" class="m-0 mt-3 flex justify-center md:hidden">
				<span class="inline-flex max-w-[min(100%,20rem)] items-center gap-2 rounded-full border border-[var(--deep-teal)]/10 bg-white/70 px-3.5 py-1.5 text-center text-[0.6875rem] font-medium leading-tight tracking-wide text-[var(--deep-teal)]/75 shadow-[0_1px_0_rgba(255,255,255,0.9)_inset]">
					<i class="ph-bold ph-arrows-out-line-horizontal shrink-0 text-[0.875rem] text-[var(--deep-teal)]/65" aria-hidden="true"></i>
					<span class="text-balance"><?php esc_html_e( 'Scroll sideways for the full comparison', 'restwell-retreats' ); ?></span>
				</span>
			</p>
			<div class="relative mt-2 md:mt-4">
				<div
					class="overflow-x-auto rounded-2xl border border-[var(--deep-teal)]/12 bg-white shadow-sm [-webkit-overflow-scrolling:touch] focus-visible:outline focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-[var(--deep-teal)]"
					data-home-comparison-scroll
					tabindex="0"
					aria-label="<?php esc_attr_e( 'Comparison table: use arrow keys to scroll sideways on narrow screens', 'restwell-retreats' ); ?>"
				>
				<table class="m-0 w-full min-w-[560px] text-left text-sm text-[var(--body-secondary)]">
					<caption class="sr-only">
						<?php
						echo esc_html(
							sprintf(
								/* translators: %s: section heading text. */
								__( 'Table: %s. Three columns: area, Restwell, hotel or care setting.', 'restwell-retreats' ),
								$home_comparison_heading_resolved
							)
						);
						?>
					</caption>
					<thead>
						<tr>
							<th scope="col" class="w-[26%] min-w-[6.75rem] border-b border-[var(--deep-teal)]/12 bg-[var(--bg-subtle)] px-4 py-3 text-left text-[0.8125rem] font-semibold uppercase tracking-[0.08em] text-[var(--deep-teal)] md:w-[22%] md:px-5 md:py-4">
								<?php esc_html_e( 'Area', 'restwell-retreats' ); ?>
							</th>
							<th scope="col" class="w-[37%] border-b border-[var(--deep-teal)]/12 bg-[var(--sea-glass)] px-4 py-3 text-left text-[0.9375rem] font-semibold leading-snug text-[var(--deep-teal)] md:px-5 md:py-4">
								<?php esc_html_e( 'Restwell', 'restwell-retreats' ); ?>
							</th>
							<th scope="col" class="w-[37%] border-b border-[var(--deep-teal)]/12 bg-[var(--bg-subtle)] px-4 py-3 text-left text-[0.9375rem] font-semibold leading-snug text-[var(--deep-teal)] md:px-5 md:py-4">
								<?php esc_html_e( 'Hotel / Care Setting', 'restwell-retreats' ); ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $home_comparison_rows as $hcr_row ) : ?>
						<tr class="border-b border-[var(--deep-teal)]/10">
							<th scope="row" class="bg-white px-4 py-3 text-left text-sm font-semibold leading-snug text-[var(--deep-teal)] align-top md:px-5 md:py-4 md:text-[0.9375rem]">
								<?php echo esc_html( $hcr_row['feature'] ); ?>
							</th>
							<td class="min-h-[52px] bg-[var(--sea-glass)]/35 px-4 py-3 align-top text-base leading-relaxed text-[var(--body-secondary)] md:px-5 md:py-4">
								<div class="flex min-h-[2.5rem] items-start gap-2.5">
									<span class="inline-flex shrink-0 pt-0.5" aria-hidden="true">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false" class="h-6 w-6 shrink-0">
											<circle cx="12" cy="12" r="11" fill="var(--sea-glass)" fill-opacity="0.95" />
											<path fill="none" stroke="var(--deep-teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m7 12 3.5 3.5L17 8.5" />
										</svg>
									</span>
									<span class="min-w-0 flex-1 text-[1rem] leading-relaxed text-[var(--body-secondary)]"><?php echo esc_html( $hcr_row['restwell'] ); ?></span>
								</div>
							</td>
							<td class="min-h-[52px] bg-white px-4 py-3 align-top text-base leading-relaxed text-[var(--body-secondary)] md:px-5 md:py-4">
								<div class="flex min-h-[2.5rem] items-start gap-2.5">
									<span class="inline-flex shrink-0 pt-0.5" aria-hidden="true">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false" class="h-6 w-6 shrink-0">
											<circle cx="12" cy="12" r="10.25" fill="#fff" stroke="var(--muted-grey)" stroke-opacity="0.35" stroke-width="1" />
											<path fill="none" stroke="var(--deep-teal)" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round" d="M8.5 8.5 15.5 15.5M15.5 8.5 8.5 15.5" />
										</svg>
									</span>
									<span class="min-w-0 flex-1 leading-relaxed text-[var(--body-secondary)]"><?php echo esc_html( $hcr_row['other'] ); ?></span>
								</div>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</div>
				<div class="pointer-events-none absolute inset-y-0 left-0 z-[1] w-6 bg-[linear-gradient(to_right,hsla(0,0%,100%,0.72)_0%,hsla(0,0%,100%,0.22)_52%,transparent_100%)] opacity-0 transition-opacity duration-300 motion-reduce:transition-none md:hidden" data-home-comparison-fade="left" aria-hidden="true"></div>
				<div class="pointer-events-none absolute inset-y-0 right-0 z-[1] w-6 bg-[linear-gradient(to_left,hsla(0,0%,100%,0.72)_0%,hsla(0,0%,100%,0.22)_52%,transparent_100%)] opacity-100 transition-opacity duration-300 motion-reduce:transition-none md:hidden" data-home-comparison-fade="right" aria-hidden="true"></div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $show_home_faq && ! empty( $home_faq_pairs ) ) : ?>
	<!-- Homepage FAQ: same accordion markup/classes as template-faq.php (FAQPage JSON-LD in inc/seo.php) -->
	<section class="<?php echo esc_attr( $rw_fp_section_y . ' ' . $rw_fp_faq_bg ); ?> rw-seam-t" aria-labelledby="home-faq-heading">
		<div class="container <?php echo esc_attr( $rw_fp_inner_narrow ); ?> text-left">
			<header class="max-w-3xl mx-auto text-center rw-stack <?php echo esc_attr( $rw_fp_head_block ); ?>">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $home_faq_label ) ); ?>
				<h2 id="home-faq-heading" class="text-3xl md:text-4xl section-heading m-0 text-balance text-center text-[var(--deep-teal)]"><?php echo esc_html( $home_faq_heading ); ?></h2>
			</header>
			<div id="home-faq-accordion" class="space-y-4 faq-list m-0 max-w-3xl mx-auto">
				<?php foreach ( $home_faq_pairs as $faq ) : ?>
					<?php
					if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
						continue;
					}
					?>
				<details class="faq-item bg-white rounded-2xl px-8 py-1 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 group hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] transition-all duration-300 ease-out motion-reduce:transition-none" data-category="all">
					<summary class="text-[var(--deep-teal)] font-medium text-lg py-4 min-h-[2.75rem] cursor-pointer list-none flex items-center justify-between gap-4 [&::-webkit-details-marker]:hidden rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2">
						<span><?php echo esc_html( $faq['q'] ); ?></span>
						<span class="flex-shrink-0 text-[var(--warm-gold-text)] transition-transform duration-200 group-open:rotate-180" aria-hidden="true">
							<i class="ph-bold ph-caret-down"></i>
						</span>
					</summary>
					<div class="text-gray-600 text-base leading-relaxed pb-6">
						<?php echo wp_kses_post( wpautop( $faq['a'] ) ); ?>
					</div>
				</details>
				<?php endforeach; ?>
			</div>
			<?php
			$home_faq_more = get_page_by_path( 'faq', OBJECT, 'page' );
			if ( $home_faq_more ) :
				?>
			<p class="m-0 mt-6 md:mt-8 max-w-3xl mx-auto text-center">
				<a
					href="<?php echo esc_url( get_permalink( $home_faq_more ) ); ?>"
					class="restwell-tap-link group/faqmore inline-flex items-center justify-center gap-2 rounded-lg text-[var(--deep-teal)] font-semibold underline-offset-4 hover:underline hover:text-[var(--warm-gold-text)] transition-colors duration-300 no-underline cursor-pointer px-1 py-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--deep-teal)]"
				>
					<?php esc_html_e( 'More on the full FAQ page', 'restwell-retreats' ); ?>
					<i class="ph-bold ph-caret-right text-sm motion-safe:transition-transform motion-safe:duration-300 motion-safe:group-hover/faqmore:translate-x-0.5" aria-hidden="true"></i>
				</a>
			</p>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $show_trust ) : ?>
	<!-- Trust / accreditations -->
	<section class="<?php echo esc_attr( $rw_fp_trust_bg ); ?> rw-seam-y-muted <?php echo esc_attr( $rw_fp_section_y ); ?>" aria-label="<?php echo esc_attr( __( 'Trust and accreditation', 'restwell-retreats' ) ); ?>">
		<div class="container <?php echo esc_attr( $rw_fp_inner_narrow ); ?> text-left">
			<div class="rw-section-head rw-section-head--left rw-section-head--tight max-w-prose">
			<?php if ( $trust_label !== '' ) : ?>
				<p class="section-label"><?php echo esc_html( $trust_label ); ?></p>
			<?php endif; ?>
			<?php if ( $trust_heading !== '' ) : ?>
				<h2 class="text-2xl font-serif text-[var(--deep-teal)] m-0"><?php echo esc_html( $trust_heading ); ?></h2>
			<?php endif; ?>
			</div>
			<div class="flex flex-col sm:flex-row items-start justify-start gap-6 sm:gap-10 flex-wrap">
				<?php if ( $trust_badge_image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$trust_badge_image_id,
						'medium',
						false,
						array(
							'class'    => 'h-16 w-auto object-contain',
							'alt'      => __( 'CQC regulated care provider accreditation', 'restwell-retreats' ),
							'loading'  => 'lazy',
							'decoding' => 'async',
							'sizes'    => '200px',
						)
					);
					?>
				<?php endif; ?>
				<?php if ( $trust_line !== '' ) : ?>
					<a
						class="<?php echo esc_attr( $rw_fp_card_surface_solid . ' group/trust inline-flex max-w-prose flex-wrap items-start gap-x-3 gap-y-2 px-4 py-3 min-h-[44px] text-left text-[var(--deep-teal)] hover:border-[var(--deep-teal)]/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--deep-teal)] cursor-pointer' ); ?>"
						href="<?php echo esc_url( $trust_partner_url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<span class="min-w-0 flex-1 space-y-1">
							<span class="block text-[0.68rem] font-bold uppercase tracking-[0.14em] text-[var(--warm-gold-text)]"><?php esc_html_e( 'Care partner', 'restwell-retreats' ); ?></span>
							<?php if ( $trust_line_primary !== '' ) : ?>
								<span class="block text-[1rem] leading-snug font-semibold md:text-[1.0625rem]"><?php echo esc_html( $trust_line_primary ); ?></span>
							<?php else : ?>
								<span class="block text-[1rem] leading-snug font-semibold md:text-[1.0625rem]"><?php echo esc_html( $trust_line ); ?></span>
							<?php endif; ?>
						</span>
						<?php if ( $trust_line_secondary !== '' ) : ?>
							<span class="inline-flex items-center whitespace-nowrap rounded-full border border-[var(--deep-teal)]/20 bg-[var(--sea-glass)]/30 px-2 py-1 text-[0.68rem] font-bold uppercase tracking-[0.11em] text-[var(--deep-teal)]"><?php echo esc_html( $trust_line_secondary ); ?></span>
						<?php endif; ?>
						<i class="ph ph-arrow-square-out text-[0.92rem] opacity-60 transition-all duration-300 group-hover/trust:translate-x-0.5 group-hover/trust:opacity-100" aria-hidden="true"></i>
						<span class="sr-only"><?php esc_html_e( 'Opens the care provider website in a new tab', 'restwell-retreats' ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>
<?php get_footer(); ?>
