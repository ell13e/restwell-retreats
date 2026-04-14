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
 * Homepage layout tokens (aligned with template-how-it-works.php: py-16 md:py-24, container + max-width).
 */
$rw_fp_section_y           = 'py-16 md:py-24';
/** Hero-scale blocks: matches DESIGN-SYSTEM.md (intro + primary CTA band). */
$rw_fp_section_y_emphasis = 'py-20 md:py-28';
$rw_fp_inner          = 'max-w-5xl mx-auto';
$rw_fp_inner_narrow   = 'max-w-3xl mx-auto';
$rw_fp_head_block     = 'mb-8 md:mb-10';
$rw_fp_head_tight     = 'mb-6 md:mb-8';
$rw_fp_stack_gap      = 'gap-6 md:gap-8';
$rw_fp_stack_gap_lg   = 'gap-6 md:gap-10';
$rw_fp_cta_mt         = 'mt-8 md:mt-10';
$rw_fp_card_pad       = 'p-6 md:p-8';
/** Solid white cards on soft-sand (wireframe “two property cards” band). */
$rw_fp_card_surface_solid = 'rounded-2xl border border-[var(--deep-teal)]/10 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)]';
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

$highlights_heading_meta   = get_post_meta( $pid, 'highlights_heading', true );
$show_highlights_heading   = ! ( metadata_exists( 'post', $pid, 'highlights_heading' ) && $highlights_heading_meta === '' );
$highlights_heading        = $highlights_heading_meta !== '' ? $highlights_heading_meta : 'Property highlights';
$intro_raw                   = isset( $m['intro_body'] ) ? (string) $m['intro_body'] : '';
$intro_trim                  = trim( $intro_raw );
$legacy_intro                = function_exists( 'restwell_get_front_page_legacy_intro_body' ) ? restwell_get_front_page_legacy_intro_body() : '';
$use_geo_stack               = ( $intro_trim === '' || $intro_trim === $legacy_intro );
$what_label                  = isset( $m['what_restwell_label'] ) ? (string) $m['what_restwell_label'] : '';
$what_heading                  = isset( $m['what_restwell_heading'] ) ? (string) $m['what_restwell_heading'] : '';
$h1t                         = isset( $m['highlight_1_title'] ) ? (string) $m['highlight_1_title'] : '';
$h1d                         = isset( $m['highlight_1_desc'] ) ? (string) $m['highlight_1_desc'] : '';
$h2t                         = isset( $m['highlight_2_title'] ) ? (string) $m['highlight_2_title'] : '';
$h2d                         = isset( $m['highlight_2_desc'] ) ? (string) $m['highlight_2_desc'] : '';
$h3t                         = isset( $m['highlight_3_title'] ) ? (string) $m['highlight_3_title'] : '';
$h3d                         = isset( $m['highlight_3_desc'] ) ? (string) $m['highlight_3_desc'] : '';
$post_obj                    = get_post( $pid );

$property_image_id         = (int) ( $m['property_image_id'] ?? 0 );
$property_heading          = isset( $m['property_heading'] ) ? (string) $m['property_heading'] : '';
$property_body             = isset( $m['property_body'] ) ? (string) $m['property_body'] : '';
$property_body_canonical   = isset( $restwell_fp_seed['property_body'] ) ? trim( (string) $restwell_fp_seed['property_body'] ) : '';
$property_body_trimmed     = trim( $property_body );

$fp_acc       = get_page_by_path( 'accessibility', OBJECT, 'page' );
$fp_who       = get_page_by_path( 'who-its-for', OBJECT, 'page' );
$fp_guide     = get_page_by_path( 'whitstable-area-guide', OBJECT, 'page' );
$fp_hiw       = get_page_by_path( 'how-it-works', OBJECT, 'page' );
$fp_resources = get_page_by_path( 'resources', OBJECT, 'page' );
$fp_faq       = get_page_by_path( 'faq', OBJECT, 'page' );
$link_class   = 'text-[#1B4D5C] font-medium underline underline-offset-2 hover:no-underline';
$fp_quick     = array();
if ( $fp_acc ) {
	$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_acc ) ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html__( 'Specification & measurements', 'restwell-retreats' ) . '</a>';
}
if ( $fp_who ) {
	$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_who ) ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html__( 'Who it\'s for', 'restwell-retreats' ) . '</a>';
}
if ( $fp_guide ) {
	$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_guide ) ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html__( 'Town, harbour & coast', 'restwell-retreats' ) . '</a>';
}
if ( $fp_hiw ) {
	$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_hiw ) ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html__( 'How booking works', 'restwell-retreats' ) . '</a>';
}
if ( $fp_resources ) {
	$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_resources ) ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html__( 'Funding routes & guides', 'restwell-retreats' ) . '</a>';
}
if ( $fp_faq ) {
	$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_faq ) ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html__( 'FAQ', 'restwell-retreats' ) . '</a>';
}

$cta_image_id = (int) ( $m['cta_image_id'] ?? 0 );

$hero_cta_primary_href   = $rw_fp_resolve_href( $hero_cta_primary_url );
$hero_cta_secondary_href = $rw_fp_resolve_href( $hero_cta_secondary_url );

$rw_fp_cta_promise_display = isset( $m['cta_promise'] ) ? trim( (string) $m['cta_promise'] ) : '';
if ( $rw_fp_cta_promise_display === '' ) {
	$rw_fp_cta_promise_display = __( 'No booking commitment. Replies usually within one working day.', 'restwell-retreats' );
}
?>
<main class="flex-1" id="main-content">
	<!--
		Homepage order (wireframe): hero → spec strip → discovery cards (area & funding)
		→ story + property highlights + prose → who (guest/carer) → property spotlight
		→ testimonials → why Restwell → bottom CTA → comparison → FAQ → trust.
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
							<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
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
					<p id="home-hero-reassurance" class="home-hero__reassurance m-0 mt-3 text-center text-white/90 text-sm font-sans max-w-md mx-auto leading-snug [text-shadow:0_1px_2px_rgba(0,0,0,0.35)]">
						<?php echo esc_html( $hero_cta_reassurance_display ); ?>
					</p>
					<?php endif; ?>
					<p class="home-hero__scroll-hint m-0 text-center">
						<a href="#restwell-main-after-hero" class="home-hero__scroll-link">
							<span class="home-hero__scroll-link-text"><?php esc_html_e( 'Scroll to explore', 'restwell-retreats' ); ?></span>
							<i class="fa-solid fa-chevron-down home-hero__scroll-icon" aria-hidden="true"></i>
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
		class="home-teaser-area-funding <?php echo esc_attr( $rw_fp_section_y ); ?> bg-[var(--soft-sand)] border-y border-[var(--deep-teal)]/10"
		aria-label="<?php echo esc_attr( $home_teaser_label ); ?>"
	>
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
				<header class="text-left <?php echo esc_attr( $rw_fp_head_block ); ?>">
					<h2 class="sr-only"><?php echo esc_html( $home_teaser_label ); ?></h2>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $home_teaser_label ) ); ?>
				</header>
				<div class="home-teaser__grid who-section__grid grid md:grid-cols-2 items-stretch <?php echo esc_attr( $rw_fp_stack_gap ); ?>">
					<div class="flex flex-col space-y-4 <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
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
								<i class="fa-solid fa-chevron-right text-sm" aria-hidden="true"></i>
							</a>
						</p>
						<?php endif; ?>
					</div>
					<div class="flex flex-col space-y-4 <?php echo esc_attr( $rw_fp_card_surface_solid . ' ' . $rw_fp_card_pad ); ?>">
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
								<i class="fa-solid fa-chevron-right text-sm" aria-hidden="true"></i>
							</a>
						</p>
						<?php endif; ?>
					</div>
				</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- Intro: band title centred (wireframe); highlight cards + prose stay a comfortable reading column -->
	<section class="intro-section intro-section--home <?php echo esc_attr( $rw_fp_section_y_emphasis ); ?> bg-white">
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
			<div class="intro-section__column text-left">
				<header class="intro-section__hero-copy text-center space-y-3 <?php echo esc_attr( $rw_fp_head_tight ); ?> max-w-4xl mx-auto">
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $what_label ) ); ?>
					<h2 class="text-3xl md:text-4xl section-heading m-0 text-balance"><?php echo esc_html( $what_heading ); ?></h2>
				</header>
				<div class="intro-section__highlights-wrap text-center w-full mt-6 md:mt-8 pt-6 md:pt-8 border-t border-[var(--deep-teal)]/10">
				<?php if ( $show_highlights_heading ) : ?>
				<h3 id="intro-highlights-heading" class="intro-section__highlights-heading w-full text-2xl md:text-3xl font-serif font-semibold text-[var(--deep-teal)] tracking-tight m-0 mb-4 md:mb-5 leading-tight text-center mx-auto max-w-4xl"><span class="intro-section__highlights-kicker" aria-hidden="true"></span><?php echo esc_html( $highlights_heading ); ?></h3>
				<?php endif; ?>
				<ul class="intro-section__highlights grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch list-none p-0 m-0 w-full" role="list"<?php echo $show_highlights_heading ? ' aria-labelledby="intro-highlights-heading"' : ''; ?>>
					<li class="intro-section__highlight-card flex flex-col items-center text-center bg-white rounded-xl shadow-md p-6 md:p-8 border border-[var(--deep-teal)]/10 transition-shadow duration-300 hover:shadow-lg">
						<div class="flex h-16 w-16 items-center justify-center rounded-full bg-[var(--sea-glass)]/35 text-[var(--deep-teal)] mb-5 shrink-0" aria-hidden="true">
							<i class="fa-solid fa-arrows-up-down text-3xl md:text-4xl" aria-hidden="true"></i>
						</div>
						<h4 class="text-lg md:text-xl font-serif font-semibold text-[var(--deep-teal)] mb-3 text-balance m-0 leading-snug"><?php echo esc_html( $h1t ); ?></h4>
						<p class="intro-section__highlight-desc text-base text-[#3a5a63] leading-relaxed m-0 max-w-prose"><?php echo esc_html( $h1d ); ?></p>
					</li>
					<li class="intro-section__highlight-card flex flex-col items-center text-center bg-white rounded-xl shadow-md p-6 md:p-8 border border-[var(--deep-teal)]/10 transition-shadow duration-300 hover:shadow-lg">
						<div class="flex h-16 w-16 items-center justify-center rounded-full bg-[var(--sea-glass)]/35 text-[var(--deep-teal)] mb-5 shrink-0" aria-hidden="true">
							<i class="fa-solid fa-bed text-3xl md:text-4xl" aria-hidden="true"></i>
						</div>
						<h4 class="text-lg md:text-xl font-serif font-semibold text-[var(--deep-teal)] mb-3 text-balance m-0 leading-snug"><?php echo esc_html( $h2t ); ?></h4>
						<p class="intro-section__highlight-desc text-base text-[#3a5a63] leading-relaxed m-0 max-w-prose"><?php echo esc_html( $h2d ); ?></p>
					</li>
					<li class="intro-section__highlight-card flex flex-col items-center text-center bg-white rounded-xl shadow-md p-6 md:p-8 border border-[var(--deep-teal)]/10 transition-shadow duration-300 hover:shadow-lg">
						<div class="flex h-16 w-16 items-center justify-center rounded-full bg-[var(--sea-glass)]/35 text-[var(--deep-teal)] mb-5 shrink-0" aria-hidden="true">
							<i class="fa-solid fa-shower text-3xl md:text-4xl" aria-hidden="true"></i>
						</div>
						<h4 class="text-lg md:text-xl font-serif font-semibold text-[var(--deep-teal)] mb-3 text-balance m-0 leading-snug"><?php echo esc_html( $h3t ); ?></h4>
						<p class="intro-section__highlight-desc text-base text-[#3a5a63] leading-relaxed m-0 max-w-prose"><?php echo esc_html( $h3d ); ?></p>
					</li>
				</ul>
				</div>
				<div class="intro-section__prose intro-section__prose--home w-full max-w-5xl ml-0 mr-auto mt-6 md:mt-8 pt-5 md:pt-6 border-t border-[var(--deep-teal)]/10">
					<?php
					if ( ! $use_geo_stack ) {
						echo '<div class="intro-section__body max-w-prose text-lg text-[#3a5a63] leading-[1.7] space-y-5 text-pretty">' . wp_kses_post( $intro_raw ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					} else {
						$rw_intro_link_class = 'text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline cursor-pointer';
						$rw_intro_kses       = array(
							'a' => array(
								'href'  => true,
								'class' => true,
							),
						);
						$rw_area_url = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'whitstable-area-guide' ) : home_url( '/whitstable-area-guide/' );
						$rw_prop_url = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'the-property' ) : home_url( '/the-property/' );
						$rw_hiw_url  = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'how-it-works' ) : home_url( '/how-it-works/' );
						$rw_acc_url  = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'accessibility' ) : home_url( '/accessibility/' );

						echo '<div class="intro-section__prose-columns flex flex-col gap-5 md:grid md:grid-cols-2 md:gap-x-10 md:gap-y-0">';
						echo '<div class="space-y-5 md:space-y-6">';
						echo '<p class="text-lg text-[#3a5a63] leading-[1.7] m-0 text-pretty">';
						printf(
							wp_kses(
								/* translators: %1$s: area guide URL, %2$s: link class */
								__( 'Restwell Retreats is a wheelchair-accessible, single-storey holiday bungalow in <a href="%1$s" class="%2$s">Whitstable, Kent</a>, designed for guests with disabilities, their families, and carers. The property features a ceiling track hoist, profiling bed, and roll-in wet room, with whole-property booking for privacy and optional CQC-regulated care support.', 'restwell-retreats' ),
								$rw_intro_kses
							),
							esc_url( $rw_area_url ),
							esc_attr( $rw_intro_link_class )
						);
						echo '</p>';

						echo '<p class="text-lg text-[#3a5a63] leading-[1.7] m-0 text-pretty">';
						printf(
							wp_kses(
								/* translators: %1$s: property URL, %2$s: how-it-works URL, %3$s: link class */
								__( 'You book the <a href="%1$s" class="%3$s">whole property</a> for a private coastal break. Care is optional: see <a href="%2$s" class="%3$s">how booking and support work</a> for Continuity of Care Services (CQC-regulated) options, or bring your own carer.', 'restwell-retreats' ),
								$rw_intro_kses
							),
							esc_url( $rw_prop_url ),
							esc_url( $rw_hiw_url ),
							esc_attr( $rw_intro_link_class )
						);
						echo '</p>';
						echo '</div>';

						echo '<div class="space-y-5 md:space-y-6">';
						echo '<p class="text-lg text-[#3a5a63] leading-[1.7] m-0 text-pretty">';
						printf(
							wp_kses(
								/* translators: %1$s: accessibility URL, %2$s: area guide URL, %3$s: link class */
								__( 'We publish door widths, thresholds, and equipment in our <a href="%1$s" class="%3$s">accessibility specification</a> so you can judge fit before you travel. <a href="%2$s" class="%3$s">Whitstable town, the coast, and day trips</a> stay within reach without last-minute route stress.', 'restwell-retreats' ),
								$rw_intro_kses
							),
							esc_url( $rw_acc_url ),
							esc_url( $rw_area_url ),
							esc_attr( $rw_intro_link_class )
						);
						echo '</p>';
						if ( $post_obj instanceof WP_Post ) {
							$mod_ts = get_post_modified_time( 'U', true, $post_obj );
							if ( $mod_ts ) {
								echo '<p class="text-sm text-[#3a5a63] m-0 pt-1 md:pt-0"><time datetime="' . esc_attr( gmdate( 'c', (int) $mod_ts ) ) . '">' . esc_html(
									sprintf(
										/* translators: %s: formatted local date */
										__( 'Last updated: %s', 'restwell-retreats' ),
										wp_date( get_option( 'date_format' ), (int) $mod_ts )
									)
								) . '</time></p>';
							}
						}
						echo '</div>';
						echo '</div>';
					}
					if ( ! $use_geo_stack && $post_obj instanceof WP_Post ) {
						$mod_ts = get_post_modified_time( 'U', true, $post_obj );
						if ( $mod_ts ) {
							echo '<p class="text-sm text-[#3a5a63] m-0 pt-3"><time datetime="' . esc_attr( gmdate( 'c', (int) $mod_ts ) ) . '">' . esc_html(
								sprintf(
									/* translators: %s: formatted local date */
									__( 'Last updated: %s', 'restwell-retreats' ),
									wp_date( get_option( 'date_format' ), (int) $mod_ts )
								)
							) . '</time></p>';
						}
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- Who it's for -->
	<section class="who-section <?php echo esc_attr( $rw_fp_section_y ); ?> bg-[var(--soft-sand)]">
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
			<div class="text-center max-w-3xl mx-auto <?php echo esc_attr( $rw_fp_head_block ); ?>">
				<?php
				$who_label_out = isset( $m['who_label'] ) ? trim( (string) $m['who_label'] ) : '';
				if ( $who_label_out !== '' ) {
					get_template_part( 'template-parts/section-label', null, array( 'label' => $who_label_out ) );
				}
				?>
				<h2 class="text-3xl md:text-4xl section-heading m-0 text-balance"><?php echo esc_html( $m['who_heading'] ?? '' ); ?></h2>
			</div>
			<div class="who-section__grid grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 items-stretch">
				<article class="who-card flex flex-col items-center text-center md:items-start md:text-left bg-white/90 border border-[var(--deep-teal)]/10 rounded-2xl shadow-md <?php echo esc_attr( $rw_fp_card_pad ); ?> md:min-h-[18rem] ring-1 ring-[var(--sea-glass)]/25">
					<div class="who-card__stack flex w-full flex-col items-center md:items-start gap-4">
						<p class="m-0 text-xs font-semibold uppercase tracking-[0.18em] text-[var(--deep-teal)]/85"><?php esc_html_e( 'Independence', 'restwell-retreats' ); ?></p>
						<div class="flex h-14 w-14 items-center justify-center rounded-full bg-[var(--sea-glass)]/30 text-[var(--deep-teal)]" aria-hidden="true">
							<i class="fa-solid fa-house text-2xl" aria-hidden="true"></i>
						</div>
						<h3 class="text-xl md:text-2xl font-serif text-[var(--deep-teal)] m-0 text-balance"><?php echo esc_html( $m['who_guest_title'] ?? '' ); ?></h3>
						<p class="who-card__body text-[#3a5a63] leading-relaxed m-0 w-full text-pretty"><?php echo esc_html( $m['who_guest_body'] ?? '' ); ?></p>
					</div>
				</article>
				<article class="who-card flex flex-col items-center text-center md:items-start md:text-left bg-[var(--warm-gold)]/10 border border-[var(--deep-teal)]/10 rounded-2xl shadow-md <?php echo esc_attr( $rw_fp_card_pad ); ?> md:min-h-[18rem]">
					<div class="who-card__stack flex w-full flex-col items-center md:items-start gap-4">
						<p class="m-0 text-xs font-semibold uppercase tracking-[0.18em] text-[var(--deep-teal)]/85"><?php esc_html_e( 'Peace of mind', 'restwell-retreats' ); ?></p>
						<div class="flex h-14 w-14 items-center justify-center rounded-full bg-[var(--soft-sand)] text-[var(--deep-teal)]" aria-hidden="true">
							<i class="fa-solid fa-heart text-2xl" aria-hidden="true"></i>
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

	<!-- Property snapshot -->
	<section class="property-section <?php echo esc_attr( $rw_fp_section_y ); ?> bg-white">
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
			<div class="property-grid grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr( $rw_fp_stack_gap_lg ); ?> items-start md:items-center">
				<div class="property-grid__image rounded-2xl overflow-hidden shadow-lg order-2 md:order-1">
					<?php if ( $property_image_id ) : ?>
						<?php
						$property_img_size = function_exists( 'restwell_pick_attachment_size' ) ? restwell_pick_attachment_size( $property_image_id, 'restwell-hero', 'large' ) : 'large';
						echo wp_get_attachment_image(
							$property_image_id,
							$property_img_size,
							false,
							array(
								'class'    => 'w-full h-[350px] md:h-[450px] object-cover',
								'alt'      => $property_heading,
								'loading'  => 'lazy',
								'decoding' => 'async',
								'sizes'    => '(min-width: 768px) 50vw, 100vw',
							)
						);
						?>
					<?php else : ?>
						<div class="property-placeholder w-full h-[350px] bg-[#E8DFD0] flex items-center justify-center text-[#8B8B7A] rounded-2xl">
							<span><?php esc_html_e( 'Add property image', 'restwell-retreats' ); ?></span>
						</div>
					<?php endif; ?>
				</div>
				<div class="property-grid__text space-y-6 order-1 md:order-2">
					<span class="section-label block mb-4"><?php echo esc_html( $m['property_label'] ?? '' ); ?></span>
					<h2 class="text-3xl"><?php echo esc_html( $property_heading ); ?></h2>
					<?php if ( $property_body_canonical !== '' && $property_body_trimmed === $property_body_canonical ) : ?>
						<p class="text-[#3a5a63] leading-relaxed m-0"><?php esc_html_e( 'An adapted single-storey property in Whitstable: level approach from the street, off-street parking for adapted vehicles, and a flat route toward the Tankerton promenade.', 'restwell-retreats' ); ?></p>
						<ul class="mt-4 list-none p-0 m-0 space-y-3 text-[#3a5a63] leading-relaxed" role="list">
							<li class="flex gap-3">
								<span class="mt-1 shrink-0 text-green-600" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
								<span><?php esc_html_e( 'Flat route toward the Tankerton promenade and practical access from parking to the door.', 'restwell-retreats' ); ?></span>
							</li>
							<li class="flex gap-3">
								<span class="mt-1 shrink-0 text-green-600" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
								<span><?php esc_html_e( 'Whitstable town centre (harbour, seafood restaurants, and the waterfront) is close enough for day trips without stressful route planning.', 'restwell-retreats' ); ?></span>
							</li>
						</ul>
					<?php else : ?>
						<p class="text-[#3a5a63] leading-relaxed"><?php echo esc_html( $property_body ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $fp_quick ) ) : ?>
					<p class="property-section__quick-links text-sm text-[#3a5a63] leading-relaxed pt-3 flex flex-wrap gap-x-2 gap-y-2 [&_a]:inline-flex [&_a]:min-h-[44px] [&_a]:items-center [&_a]:py-2 [&_a]:px-1">
						<?php echo wp_kses_post( implode( '<span class="text-[var(--muted-grey)] select-none" aria-hidden="true"> · </span>', $fp_quick ) ); ?>
					</p>
					<?php endif; ?>

					<a
						href="<?php echo esc_url( $rw_fp_resolve_href( isset( $m['property_cta_url'] ) ? (string) $m['property_cta_url'] : '' ) ); ?>"
						class="inline-flex items-center gap-2 min-h-[44px] text-[#1B4D5C] font-semibold hover:text-[#815F10] hover:underline transition-colors duration-300 no-underline cursor-pointer"
						data-cta="property-explore"
					>
						<?php echo esc_html( $m['property_cta_label'] ?? '' ); ?>
						<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $show_testimonials ) : ?>
	<!-- Testimonials: after property spotlight, before “why Restwell” (wireframe flow). -->
	<section class="testimonials-section <?php echo esc_attr( $rw_fp_section_y ); ?> bg-[var(--soft-sand)] border-t border-[var(--deep-teal)]/10" aria-labelledby="home-testimonials-heading">
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
			<div class="text-center max-w-3xl mx-auto <?php echo esc_attr( $rw_fp_head_block ); ?>">
				<?php if ( $testimonial_label !== '' ) : ?>
					<p class="section-label mb-3"><?php echo esc_html( $testimonial_label ); ?></p>
				<?php endif; ?>
				<h2 id="home-testimonials-heading" class="text-3xl md:text-4xl section-heading m-0 text-balance"><?php echo esc_html( $testimonial_heading ); ?></h2>
			</div>
			<ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 <?php echo esc_attr( $rw_fp_stack_gap_lg ); ?> list-none p-0 m-0" role="list">
				<?php foreach ( $testimonials as $t ) : ?>
				<li>
					<article class="h-full bg-white rounded-2xl border border-[var(--deep-teal)]/10 shadow-md flex flex-col <?php echo esc_attr( $rw_fp_card_pad ); ?> transition-shadow duration-300 hover:shadow-lg">
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

	<!-- Why Restwell -->
	<section class="features-section <?php echo esc_attr( $rw_fp_section_y ); ?> bg-white border-t border-[var(--deep-teal)]/10" aria-labelledby="home-why-restwell-heading">
		<div class="container <?php echo esc_attr( $rw_fp_inner ); ?>">
			<div class="text-center <?php echo esc_attr( $rw_fp_head_block ); ?>">
				<span class="section-label block mb-3"><?php echo esc_html( $m['why_label'] ?? '' ); ?></span>
				<h2 id="home-why-restwell-heading" class="text-3xl md:text-4xl section-heading"><?php echo esc_html( $m['why_heading'] ?? '' ); ?></h2>
			</div>
			<ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 list-none p-0 m-0" role="list">
				<li class="feature-item group text-center space-y-4 bg-[var(--soft-sand)]/50 rounded-2xl border border-[var(--deep-teal)]/10 p-6 md:p-8 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
					<div class="feature-icon-wrapper mx-auto">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-house feature-icon-svg text-[var(--deep-teal)] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] text-center m-0"><?php echo esc_html( $m['why_item1_title'] ?? '' ); ?></h3>
					<p class="feature-item__body text-[15px] text-[#3a5a63] leading-relaxed text-center m-0"><?php echo esc_html( $m['why_item1_desc'] ?? '' ); ?></p>
				</li>
				<li class="feature-item group text-center space-y-4 bg-[var(--soft-sand)]/50 rounded-2xl border border-[var(--deep-teal)]/10 p-6 md:p-8 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
					<div class="feature-icon-wrapper mx-auto">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-shield-halved feature-icon-svg text-[var(--deep-teal)] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] text-center m-0"><?php echo esc_html( $m['why_item2_title'] ?? '' ); ?></h3>
					<p class="feature-item__body text-[15px] text-[#3a5a63] leading-relaxed text-center m-0"><?php echo esc_html( $m['why_item2_desc'] ?? '' ); ?></p>
				</li>
				<li class="feature-item group text-center space-y-4 bg-[var(--soft-sand)]/50 rounded-2xl border border-[var(--deep-teal)]/10 p-6 md:p-8 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
					<div class="feature-icon-wrapper mx-auto">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-location-dot feature-icon-svg text-[var(--deep-teal)] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] text-center m-0"><?php echo esc_html( $m['why_item3_title'] ?? '' ); ?></h3>
					<p class="feature-item__body text-[15px] text-[#3a5a63] leading-relaxed text-center m-0"><?php echo esc_html( $m['why_item3_desc'] ?? '' ); ?></p>
				</li>
				<li class="feature-item group text-center space-y-4 bg-[var(--soft-sand)]/50 rounded-2xl border border-[var(--deep-teal)]/10 p-6 md:p-8 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
					<div class="feature-icon-wrapper mx-auto">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-heart feature-icon-svg text-[var(--deep-teal)] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] text-center m-0"><?php echo esc_html( $m['why_item4_title'] ?? '' ); ?></h3>
					<p class="feature-item__body text-[15px] text-[#3a5a63] leading-relaxed text-center m-0"><?php echo esc_html( $m['why_item4_desc'] ?? '' ); ?></p>
				</li>
			</ul>
		</div>
	</section>

	<!-- Bottom CTA -->
	<section class="relative <?php echo esc_attr( $rw_fp_section_y_emphasis ); ?> overflow-hidden">
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
		<div class="relative container text-center <?php echo esc_attr( $rw_fp_inner_narrow ); ?>">
			<h2 class="text-white text-3xl md:text-4xl <?php echo esc_attr( $rw_fp_head_tight ); ?>"><?php echo esc_html( $m['cta_heading'] ?? '' ); ?></h2>
			<p class="text-[#F5EDE0] text-lg <?php echo esc_attr( $rw_fp_head_block ); ?> max-w-lg mx-auto m-0">
				<?php echo esc_html( $m['cta_body'] ?? '' ); ?>
			</p>
			<?php get_template_part( 'template-parts/cta-accessibility-prompt', null, array( 'variant' => 'dark' ) ); ?>
			<div class="flex flex-col sm:flex-row justify-center <?php echo esc_attr( $rw_fp_stack_gap ); ?>">
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
			<p class="text-white/90 text-sm <?php echo esc_attr( $rw_fp_cta_mt ); ?> m-0"><?php echo esc_html( $rw_fp_cta_promise_display ); ?></p>
		</div>
	</section>

	<?php if ( $show_home_comparison ) : ?>
	<section class="home-comparison-section <?php echo esc_attr( $rw_fp_section_y ); ?> bg-[var(--soft-sand)] border-t border-[var(--deep-teal)]/10" aria-labelledby="home-comparison-heading" aria-describedby="home-comparison-summary">
		<div class="container <?php echo esc_attr( $rw_fp_inner_comparison ); ?>">
			<header class="text-center <?php echo esc_attr( $rw_fp_head_block ); ?> max-w-3xl mx-auto">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $home_comparison_label ) ); ?>
				<h2 id="home-comparison-heading" class="text-3xl md:text-4xl section-heading m-0 text-balance"><?php echo esc_html( $home_comparison_heading_resolved ); ?></h2>
				<?php if ( $home_comparison_intro !== '' ) : ?>
				<p class="text-[#3a5a63] leading-relaxed mt-4 max-w-2xl m-0 mx-auto text-left"><?php echo esc_html( $home_comparison_intro ); ?></p>
				<?php endif; ?>
			</header>
			<p id="home-comparison-summary" class="sr-only"><?php echo esc_html( $home_comparison_heading_resolved ); ?> — <?php esc_html_e( 'three-column feature checklist comparing Restwell with a typical hotel or care setting.', 'restwell-retreats' ); ?></p>
			<div class="overflow-x-auto rounded-2xl border border-[var(--deep-teal)]/10 shadow-md bg-white">
				<div class="min-w-[min(100%,680px)] md:min-w-0">
					<div class="hidden md:grid md:grid-cols-3 bg-[var(--soft-sand)]/75 text-left text-sm md:text-base font-semibold text-[var(--deep-teal)] border-b border-[var(--deep-teal)]/10">
						<div class="p-4 md:border-r border-[var(--deep-teal)]/10"><?php esc_html_e( 'Feature', 'restwell-retreats' ); ?></div>
						<div class="p-4 md:border-r border-[var(--deep-teal)]/10 bg-[var(--warm-gold)]/15"><?php esc_html_e( 'Restwell', 'restwell-retreats' ); ?></div>
						<div class="p-4"><?php esc_html_e( 'Hotel / care setting', 'restwell-retreats' ); ?></div>
					</div>
					<ul class="m-0 list-none p-0" role="list">
						<?php foreach ( $home_comparison_rows as $hcr_idx => $hcr_row ) : ?>
						<li class="border-t border-[var(--deep-teal)]/10 <?php echo 0 === ( $hcr_idx % 2 ) ? 'bg-white' : 'bg-[var(--soft-sand)]/30'; ?>">
							<div class="grid grid-cols-1 md:grid-cols-3 gap-0">
								<div class="p-4 md:border-r border-[var(--deep-teal)]/10 font-medium text-[var(--deep-teal)] text-base leading-snug">
									<span class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[var(--deep-teal)]/70 md:sr-only"><?php esc_html_e( 'Feature', 'restwell-retreats' ); ?></span>
									<?php echo esc_html( $hcr_row['feature'] ); ?>
								</div>
								<div class="flex gap-3 p-4 md:border-r border-[var(--deep-teal)]/10 bg-[var(--warm-gold)]/12 text-[#3a5a63]">
									<span class="mt-0.5 shrink-0 text-green-600" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
									<span class="leading-relaxed">
										<span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[var(--deep-teal)] md:sr-only"><?php esc_html_e( 'Restwell', 'restwell-retreats' ); ?></span>
										<?php echo esc_html( $hcr_row['restwell'] ); ?>
									</span>
								</div>
								<div class="flex gap-3 border-t border-[var(--deep-teal)]/10 p-4 text-[#3a5a63] md:border-t-0">
									<span class="mt-0.5 shrink-0 text-slate-400" aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
									<span class="leading-relaxed">
										<span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[var(--deep-teal)] md:sr-only"><?php esc_html_e( 'Hotel / care setting', 'restwell-retreats' ); ?></span>
										<?php echo esc_html( $hcr_row['other'] ); ?>
									</span>
								</div>
							</div>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $show_home_faq && ! empty( $home_faq_pairs ) ) : ?>
	<!-- Homepage FAQ (matches FAQPage JSON-LD in inc/seo.php) -->
	<section class="home-faq-section <?php echo esc_attr( $rw_fp_section_y ); ?> bg-white border-t border-[var(--deep-teal)]/10" aria-labelledby="home-faq-heading">
		<div class="container <?php echo esc_attr( $rw_fp_inner_narrow ); ?> text-left">
			<div class="text-center max-w-3xl mx-auto">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $home_faq_label ) ); ?>
				<h2 id="home-faq-heading" class="text-3xl md:text-4xl section-heading <?php echo esc_attr( $rw_fp_head_tight ); ?> text-balance"><?php echo esc_html( $home_faq_heading ); ?></h2>
			</div>
			<div class="home-faq-list m-0 mt-8 md:mt-10 space-y-3">
				<?php foreach ( $home_faq_pairs as $faq ) : ?>
					<?php
					if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
						continue;
					}
					?>
				<details class="home-faq__item rounded-xl border border-[var(--deep-teal)]/10 bg-white shadow-sm transition-shadow duration-300 open:shadow-md open:border-[var(--deep-teal)]/20">
					<summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-4 py-4 pr-3 text-left text-lg font-serif font-semibold text-[var(--deep-teal)] marker:content-none [&::-webkit-details-marker]:hidden focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--deep-teal)]">
						<span class="min-w-0 flex-1"><?php echo esc_html( $faq['q'] ); ?></span>
						<span class="home-faq__toggle-icon inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[var(--soft-sand)] text-[var(--deep-teal)]" aria-hidden="true">
							<i class="fa-solid fa-plus text-sm home-faq__icon home-faq__icon--plus"></i>
							<i class="fa-solid fa-minus text-sm home-faq__icon home-faq__icon--minus"></i>
						</span>
					</summary>
					<div class="home-faq__answer border-t border-[var(--deep-teal)]/10 px-4 pb-4 pt-3 text-[#3a5a63] leading-[1.65]"><?php echo esc_html( $faq['a'] ); ?></div>
				</details>
				<?php endforeach; ?>
			</div>
			<?php
			$home_faq_more = get_page_by_path( 'faq', OBJECT, 'page' );
			if ( $home_faq_more ) :
				?>
			<p class="<?php echo esc_attr( $rw_fp_cta_mt ); ?> m-0">
				<a
					href="<?php echo esc_url( get_permalink( $home_faq_more ) ); ?>"
					class="restwell-tap-link inline-flex items-center gap-2 text-[var(--deep-teal)] font-semibold underline-offset-4 hover:underline hover:text-[var(--warm-gold-text)] transition-colors duration-300 no-underline cursor-pointer"
				>
					<?php esc_html_e( 'More on the full FAQ page', 'restwell-retreats' ); ?>
					<i class="fa-solid fa-chevron-right text-sm" aria-hidden="true"></i>
				</a>
			</p>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $show_trust ) : ?>
	<!-- Trust / accreditations -->
	<section class="trust-strip bg-[var(--bg-subtle)] border-t border-b border-[var(--deep-teal)]/8 <?php echo esc_attr( $rw_fp_section_y ); ?>" aria-label="<?php echo esc_attr( __( 'Trust and accreditation', 'restwell-retreats' ) ); ?>">
		<div class="container <?php echo esc_attr( $rw_fp_inner_narrow ); ?> text-left">
			<?php if ( $trust_label !== '' ) : ?>
				<p class="section-label mb-3"><?php echo esc_html( $trust_label ); ?></p>
			<?php endif; ?>
			<?php if ( $trust_heading !== '' ) : ?>
				<h2 class="text-2xl font-serif text-[var(--deep-teal)] <?php echo esc_attr( $rw_fp_head_tight ); ?>"><?php echo esc_html( $trust_heading ); ?></h2>
			<?php endif; ?>
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
					<p class="trust-strip__line text-[var(--deep-teal)] font-medium leading-relaxed tracking-tight max-w-[52ch]"><?php echo esc_html( $trust_line ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
