<?php
/**
 * Front Page template.
 * Uses Page Content Fields meta (get_post_meta) and featured/attachment images.
 * WordPress core only.
 *
 * Default fallback copy follows DESIGN-SYSTEM.md (Beautiful Prose). Factual claims (Whitstable,
 * Kent, equipment, Continuity of Care Services) align with inc/theme-setup.php and the
 * Accessibility specification content, not ad hoc invention. Hero lede is a short line;
 * optional hero_spec_heading (Page Content Fields) renders in the strip under the hero when set.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();
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
$hero_cta_primary_label  = get_post_meta( $pid, 'hero_cta_primary_label', true ) ?: 'Check availability';
$hero_cta_primary_url    = get_post_meta( $pid, 'hero_cta_primary_url', true ) ?: '/enquire/';
$hero_cta_secondary_label= get_post_meta( $pid, 'hero_cta_secondary_label', true ) ?: 'View the property';
$hero_cta_secondary_url  = get_post_meta( $pid, 'hero_cta_secondary_url', true ) ?: '/the-property/';
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

$what_label   = get_post_meta( $pid, 'what_restwell_label', true ) ?: 'What is Restwell?';
$what_heading = get_post_meta( $pid, 'what_restwell_heading', true ) ?: 'A proper accessible coastal holiday.';
$highlights_heading_meta   = get_post_meta( $pid, 'highlights_heading', true );
$show_highlights_heading   = ! ( metadata_exists( 'post', $pid, 'highlights_heading' ) && $highlights_heading_meta === '' );
$highlights_heading        = $highlights_heading_meta !== '' ? $highlights_heading_meta : 'Property highlights';
$highlight_1_title  = get_post_meta( $pid, 'highlight_1_title', true ) ?: 'Ceiling track hoist';
$highlight_1_desc   = get_post_meta( $pid, 'highlight_1_desc', true ) ?: 'Full-room coverage for safer, more predictable transfers.';
$highlight_2_title  = get_post_meta( $pid, 'highlight_2_title', true ) ?: 'Profiling bed';
$highlight_2_desc   = get_post_meta( $pid, 'highlight_2_desc', true ) ?: 'Adjustable, with a pressure-relieving mattress. Ready for your stay.';
$highlight_3_title  = get_post_meta( $pid, 'highlight_3_title', true ) ?: 'Full wet room';
$highlight_3_desc   = get_post_meta( $pid, 'highlight_3_desc', true ) ?: 'Roll-in shower, grab rails, and space to turn and assist.';
$intro_body = get_post_meta( $pid, 'intro_body', true );

$home_teaser_label_meta = get_post_meta( $pid, 'home_teaser_label', true );
$show_home_teaser       = ! ( metadata_exists( 'post', $pid, 'home_teaser_label' ) && $home_teaser_label_meta === '' );
$home_teaser_label      = $home_teaser_label_meta !== '' ? $home_teaser_label_meta : 'Area & funding';
$home_teaser_area_title    = get_post_meta( $pid, 'home_teaser_area_title', true ) ?: 'Whitstable & the Kent coast';
$home_teaser_area_body     = get_post_meta( $pid, 'home_teaser_area_body', true ) ?: 'Single-storey bungalow on the Kent coast: harbour, promenade, and day trips with realistic access notes. We focus on step-free routes, parking, and places that match your needs—not a vague list labelled "wheelchair friendly".';
$home_teaser_funding_title = get_post_meta( $pid, 'home_teaser_funding_title', true ) ?: 'Funding your stay';
$home_teaser_funding_body  = get_post_meta( $pid, 'home_teaser_funding_body', true ) ?: 'Many guests use personal budgets, direct payments, NHS Continuing Healthcare, or local authority funding. Our guides explain common routes in plain English: what to ask your social worker, and what paperwork helps.';

$who_label   = get_post_meta( $pid, 'who_label', true ) ?: 'Who it\'s for';
$who_heading = get_post_meta( $pid, 'who_heading', true ) ?: 'Two people. One break.';
$who_guest_title = get_post_meta( $pid, 'who_guest_title', true ) ?: 'For the guest';
$who_guest_body  = get_post_meta( $pid, 'who_guest_body', true ) ?: 'A private home with the space and access features you need: wide doorways, level thresholds, room for equipment, and space to settle. Self-catering in Whitstable at your pace—the house is yours, the timetable is yours. Rest by the sea, then explore the town or stay close as you prefer.';
$who_carer_title = get_post_meta( $pid, 'who_carer_title', true ) ?: 'For the carer';
$who_carer_body  = get_post_meta( $pid, 'who_carer_body', true ) ?: 'The layout supports care routines: separate sleeping, practical bathroom access, and space to assist. Optional CQC-regulated support is available through Continuity of Care Services, or bring your own carer. Either way, the environment is set up for real routines, day and night, so you are not improvising.';

$property_label    = get_post_meta( $pid, 'property_label', true ) ?: 'The property';
$property_heading  = get_post_meta( $pid, 'property_heading', true ) ?: 'Our Whitstable home';
$property_body     = get_post_meta( $pid, 'property_body', true ) ?: 'An adapted single-storey property in Whitstable: level approach from the street, off-street parking for adapted vehicles, and a flat route toward the Tankerton promenade. Whitstable town centre—harbour, seafood restaurants, and the waterfront—is close enough for day trips without stressful route planning.';
$property_cta_label = get_post_meta( $pid, 'property_cta_label', true ) ?: 'Explore the property';
$property_cta_url  = get_post_meta( $pid, 'property_cta_url', true ) ?: '/the-property/';
$property_image_id = (int) get_post_meta( $pid, 'property_image_id', true );

$why_label   = get_post_meta( $pid, 'why_label', true ) ?: 'Why Restwell?';
$why_heading = get_post_meta( $pid, 'why_heading', true ) ?: 'Why choose Restwell for your accessible break?';
$why1_title  = get_post_meta( $pid, 'why_item1_title', true ) ?: 'Private & personal';
$why1_desc   = get_post_meta( $pid, 'why_item1_desc', true ) ?: 'The whole bungalow is yours: living space, kitchen, and bedrooms, with the privacy of a self-catering stay.';
$why2_title  = get_post_meta( $pid, 'why_item2_title', true ) ?: 'Professional support on your terms';
$why2_desc   = get_post_meta( $pid, 'why_item2_desc', true ) ?: 'Continuity of Care Services (CQC-regulated): support arranged on your terms, as much or as little as you need, or bring your own carer.';
$why3_title  = get_post_meta( $pid, 'why_item3_title', true ) ?: 'Local knowledge';
$why3_desc   = get_post_meta( $pid, 'why_item3_desc', true ) ?: 'We can tell you which cafes have step-free access, where to park near the harbour, and which routes work for wheelchairs, so you spend more time relaxing and less time planning.';
$why4_title  = get_post_meta( $pid, 'why_item4_title', true ) ?: 'Honest & open';
$why4_desc   = get_post_meta( $pid, 'why_item4_desc', true ) ?: 'We publish the access specification: exact dimensions, thresholds, and equipment, so you can plan with confidence before you travel.';

$cta_heading   = get_post_meta( $pid, 'cta_heading', true ) ?: 'Ready to plan your accessible stay?';
$cta_body      = get_post_meta( $pid, 'cta_body', true ) ?: 'Ask about hoist limits, door widths, or funding. No pressure: we reply with specifics you can use.';
$cta_primary_label   = get_post_meta( $pid, 'cta_primary_label', true ) ?: 'Send an enquiry';
$cta_primary_url     = get_post_meta( $pid, 'cta_primary_url', true ) ?: '/enquire/';
$cta_secondary_label = get_post_meta( $pid, 'cta_secondary_label', true ) ?: 'See the property';
$cta_secondary_url   = get_post_meta( $pid, 'cta_secondary_url', true ) ?: '/the-property/';
$cta_promise         = get_post_meta( $pid, 'cta_promise', true ) ?: 'No booking commitment. Just a conversation.';
$cta_image_id = (int) get_post_meta( $pid, 'cta_image_id', true );

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
$hero_media_url = $hero_media_id ? ( $hero_is_video ? wp_get_attachment_url( $hero_media_id ) : wp_get_attachment_image_url( $hero_media_id, 'full' ) ) : '';

$post_obj          = get_post( $pid );
$use_editor_main   = $post_obj instanceof WP_Post && trim( (string) $post_obj->post_content ) !== '';
?>
<main class="flex-1" id="main-content">
	<!-- Hero Section -->
	<section class="hero home-hero relative flex overflow-hidden <?php echo ( $hero_media_id && $hero_media_url ) ? 'hero--has-media' : ''; ?> <?php echo $hero_media_id ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="home-hero-heading"<?php echo ! empty( $home_hero_describedby ) ? ' aria-describedby="' . esc_attr( implode( ' ', $home_hero_describedby ) ) . '"' : ''; ?>>
		<?php if ( $hero_media_id && $hero_media_url ) : ?>
			<?php if ( $hero_is_video ) : ?>
				<video
					class="absolute inset-0 w-full h-full object-cover -z-10"
					autoplay
					muted
					loop
					playsinline
					preload="metadata"
					aria-hidden="true"
				>
					<source src="<?php echo esc_url( $hero_media_url ); ?>" type="<?php echo esc_attr( $hero_media_mime ); ?>">
				</video>
			<?php else : ?>
				<?php
				echo wp_get_attachment_image(
					$hero_media_id,
					'full',
					false,
					array(
						'class'         => 'absolute inset-0 w-full h-full object-cover -z-10',
						'alt'           => $hero_media_alt,
						'loading'       => 'eager',
						'fetchpriority' => 'high',
						'decoding'      => 'async',
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
						<h1 id="home-hero-heading" class="m-0 text-white">
							<span class="home-hero__title-lines block space-y-2 font-serif">
								<?php foreach ( $hero_heading_lines as $hero_heading_line ) : ?>
								<span class="block"><?php echo esc_html( $hero_heading_line ); ?></span>
								<?php endforeach; ?>
							</span>
						</h1>
						<?php if ( trim( (string) $hero_lede_paragraph ) !== '' ) : ?>
						<p id="home-hero-lede" class="home-hero__lede text-white [text-shadow:0_2px_4px_rgba(0,0,0,0.3)] font-sans text-base sm:text-lg md:text-xl font-normal leading-relaxed tracking-normal sm:tracking-tight text-balance m-0">
							<?php echo esc_html( $hero_lede_paragraph ); ?>
						</p>
						<?php endif; ?>
					</div>
					<div class="home-hero__cta-stack">
						<a
							id="hero-cta-primary"
							href="<?php echo esc_url( $hero_cta_primary_url ); ?>"
							class="btn btn-gold cursor-pointer"
							data-cta="hero-primary"
						>
							<?php echo esc_html( $hero_cta_primary_label ); ?>
							<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
						</a>
						<a
							id="hero-cta-secondary"
							href="<?php echo esc_url( $hero_cta_secondary_url ); ?>"
							class="home-hero__cta-secondary btn cursor-pointer"
							data-cta="hero-secondary"
						>
							<?php echo esc_html( $hero_cta_secondary_label ); ?>
						</a>
					</div>
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
		class="home-hero-equipment-strip bg-[var(--soft-sand)] border-b border-[var(--deep-teal)]/10"
		aria-labelledby="home-hero-spec-strip-heading"
	>
		<div class="container py-4 md:py-5">
			<h2 id="home-hero-spec-strip-heading" class="sr-only">
				<?php esc_html_e( 'On-site equipment and booking detail', 'restwell-retreats' ); ?>
			</h2>
			<p class="home-hero-equipment-strip__text m-0 text-center text-[var(--deep-teal)] font-sans text-sm sm:text-base leading-relaxed max-w-4xl mx-auto">
				<?php echo esc_html( $hero_spec_heading ); ?>
			</p>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $show_home_teaser ) : ?>
	<section
		class="home-teaser-area-funding bg-[var(--soft-sand)] border-y border-[var(--deep-teal)]/10"
		aria-label="<?php echo esc_attr( $home_teaser_label ); ?>"
	>
		<div class="container">
			<div class="max-w-5xl mx-auto">
				<header class="text-center mb-6 md:mb-12">
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $home_teaser_label ) ); ?>
				</header>
				<div class="home-teaser__grid grid md:grid-cols-2 items-stretch">
					<div class="flex flex-col rounded-2xl border border-[var(--deep-teal)]/10 bg-white/70 p-6 sm:p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] space-y-4 md:space-y-4">
						<h2 id="home-teaser-area-heading" class="text-xl md:text-2xl font-serif text-[var(--deep-teal)] leading-tight m-0"><?php echo esc_html( $home_teaser_area_title ); ?></h2>
						<p class="text-[#3a5a63] leading-relaxed m-0 max-w-prose text-base"><?php echo esc_html( $home_teaser_area_body ); ?></p>
						<?php
						$fp_teaser_guide = get_page_by_path( 'whitstable-area-guide', OBJECT, 'page' );
						if ( $fp_teaser_guide ) :
							?>
						<p class="m-0 pt-1">
							<a
								href="<?php echo esc_url( get_permalink( $fp_teaser_guide ) ); ?>"
								class="restwell-tap-link inline-flex items-center gap-2 text-[var(--deep-teal)] font-semibold underline-offset-2 hover:underline hover:text-[var(--warm-gold-text)] transition-colors duration-300 no-underline cursor-pointer"
							>
								<?php esc_html_e( 'Whitstable & Kent guide', 'restwell-retreats' ); ?>
								<i class="fa-solid fa-chevron-right text-sm" aria-hidden="true"></i>
							</a>
						</p>
						<?php endif; ?>
					</div>
					<div class="flex flex-col rounded-2xl border border-[var(--deep-teal)]/10 bg-white/70 p-6 sm:p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] space-y-4 md:space-y-4">
						<h2 id="home-teaser-funding-heading" class="text-xl md:text-2xl font-serif text-[var(--deep-teal)] leading-tight m-0"><?php echo esc_html( $home_teaser_funding_title ); ?></h2>
						<p class="text-[#3a5a63] leading-relaxed m-0 max-w-prose text-base"><?php echo esc_html( $home_teaser_funding_body ); ?></p>
						<?php
						$fp_teaser_res = get_page_by_path( 'resources', OBJECT, 'page' );
						if ( $fp_teaser_res ) :
							?>
						<p class="m-0 pt-1">
							<a
								href="<?php echo esc_url( get_permalink( $fp_teaser_res ) ); ?>"
								class="restwell-tap-link inline-flex items-center gap-2 text-[var(--deep-teal)] font-semibold underline-offset-2 hover:underline hover:text-[var(--warm-gold-text)] transition-colors duration-300 no-underline cursor-pointer"
							>
								<?php esc_html_e( 'Funding & support', 'restwell-retreats' ); ?>
								<i class="fa-solid fa-chevron-right text-sm" aria-hidden="true"></i>
							</a>
						</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $use_editor_main ) : ?>
	<div class="front-page__editor-content">
		<?php echo apply_filters( 'restwell_front_page_body_html', $post_obj->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<?php else : ?>

	<!-- What is Restwell Retreats? -->
	<section class="intro-section py-20 md:py-28 bg-white">
		<div class="container">
			<div class="max-w-4xl mx-auto text-left">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $what_label ) ); ?>
				<h2 class="text-3xl md:text-4xl mb-6 md:mb-8 section-heading"><?php echo esc_html( $what_heading ); ?></h2>
				<?php if ( $show_highlights_heading ) : ?>
				<p class="text-lg font-semibold text-[var(--deep-teal)] mb-4 font-sans"><?php echo esc_html( $highlights_heading ); ?></p>
				<?php endif; ?>
				<ul class="grid sm:grid-cols-3 gap-5 md:gap-6 mb-10 md:mb-12 list-none p-0 m-0" role="list">
					<li class="rounded-2xl border border-[var(--deep-teal)]/10 bg-[var(--soft-sand)]/40 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
						<div class="w-12 h-12 rounded-full bg-sea-glass/40 flex items-center justify-center text-deep-teal text-lg mb-4" aria-hidden="true">
							<i class="fa-solid fa-arrows-up-down"></i>
						</div>
						<h3 class="text-lg font-serif text-deep-teal mb-2"><?php echo esc_html( $highlight_1_title ); ?></h3>
						<p class="text-sm text-[#3a5a63] leading-relaxed m-0"><?php echo esc_html( $highlight_1_desc ); ?></p>
					</li>
					<li class="rounded-2xl border border-[var(--deep-teal)]/10 bg-[var(--soft-sand)]/40 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
						<div class="w-12 h-12 rounded-full bg-sea-glass/40 flex items-center justify-center text-deep-teal text-lg mb-4" aria-hidden="true">
							<i class="fa-solid fa-bed"></i>
						</div>
						<h3 class="text-lg font-serif text-deep-teal mb-2"><?php echo esc_html( $highlight_2_title ); ?></h3>
						<p class="text-sm text-[#3a5a63] leading-relaxed m-0"><?php echo esc_html( $highlight_2_desc ); ?></p>
					</li>
					<li class="rounded-2xl border border-[var(--deep-teal)]/10 bg-[var(--soft-sand)]/40 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
						<div class="w-12 h-12 rounded-full bg-sea-glass/40 flex items-center justify-center text-deep-teal text-lg mb-4" aria-hidden="true">
							<i class="fa-solid fa-shower"></i>
						</div>
						<h3 class="text-lg font-serif text-deep-teal mb-2"><?php echo esc_html( $highlight_3_title ); ?></h3>
						<p class="text-sm text-[#3a5a63] leading-relaxed m-0"><?php echo esc_html( $highlight_3_desc ); ?></p>
					</li>
				</ul>
				<div class="max-w-prose space-y-4">
				<?php
				$legacy_intro = function_exists( 'restwell_get_front_page_legacy_intro_body' ) ? restwell_get_front_page_legacy_intro_body() : '';
				$intro_trim   = trim( (string) $intro_body );
				$use_geo_stack = ( $intro_trim === '' || $intro_trim === $legacy_intro );
				if ( ! $use_geo_stack ) {
					echo '<div class="intro-section__body text-lg text-[#3a5a63] leading-relaxed space-y-4">' . wp_kses_post( $intro_body ) . '</div>';
				} else {
					$intro_definition = __( 'Restwell Retreats is a wheelchair-accessible, single-storey holiday bungalow in Whitstable, Kent, designed for guests with disabilities, their families, and carers. The property features a ceiling track hoist, profiling bed, and roll-in wet room, with whole-property booking for privacy and optional CQC-regulated care support.', 'restwell-retreats' );
					$intro_p2         = __( 'You book the whole property for a private coastal break. Care is optional: Continuity of Care Services (CQC-regulated) can support your stay on your terms, or bring your own carer.', 'restwell-retreats' );
					$intro_p3         = __( 'We publish door widths, thresholds, and equipment in our accessibility specification so you can judge fit before you travel. Whitstable town, the coast, and day trips stay within reach without last-minute route stress.', 'restwell-retreats' );
					echo '<p class="text-lg text-[#3a5a63] leading-relaxed m-0">' . esc_html( $intro_definition ) . '</p>';
					echo '<p class="text-lg text-[#3a5a63] leading-relaxed m-0">' . esc_html( $intro_p2 ) . '</p>';
					echo '<p class="text-lg text-[#3a5a63] leading-relaxed m-0">' . esc_html( $intro_p3 ) . '</p>';
				}
				if ( $post_obj instanceof WP_Post ) {
					$mod_ts = get_post_modified_time( 'U', true, $post_obj );
					if ( $mod_ts ) {
						echo '<p class="text-sm text-[#3a5a63]/80 m-0 pt-1"><time datetime="' . esc_attr( gmdate( 'c', (int) $mod_ts ) ) . '">' . esc_html(
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

	<!-- Who It's For: dual audience cards (centered stack per card; grid gap overrides #main-content .grid.md:grid-cols-2) -->
	<section class="who-section py-16 md:py-24 bg-[var(--soft-sand)]" aria-labelledby="who-section-heading">
		<div class="container max-w-6xl">
			<div class="text-center mb-6 md:mb-10 max-w-2xl mx-auto space-y-3 pt-1">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $who_label ) ); ?>
				<h2 id="who-section-heading" class="text-3xl md:text-[2.125rem] section-heading m-0 text-balance leading-tight"><?php echo esc_html( $who_heading ); ?></h2>
			</div>
			<div class="who-section__grid grid md:grid-cols-2 max-w-5xl mx-auto items-stretch">
				<div class="who-card flex flex-col items-center justify-center text-center h-full border border-[var(--deep-teal)]/12 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] p-6 sm:p-6 md:p-8 transition-shadow duration-300 hover:shadow-[0_12px_36px_rgb(0,0,0,0.08)]">
					<div class="who-card__stack flex w-full max-w-sm flex-col items-center justify-center gap-3 sm:gap-4">
						<div class="who-card__icon shrink-0" aria-hidden="true">
							<i class="fa-solid fa-house"></i>
						</div>
						<h3 class="text-lg md:text-xl font-serif text-[var(--deep-teal)] m-0 leading-snug tracking-tight text-balance"><?php echo esc_html( $who_guest_title ); ?></h3>
						<p class="who-card__body text-center leading-relaxed m-0 text-base w-full"><?php echo esc_html( $who_guest_body ); ?></p>
					</div>
				</div>
				<div class="who-card flex flex-col items-center justify-center text-center h-full border border-[var(--deep-teal)]/12 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] p-6 sm:p-6 md:p-8 transition-shadow duration-300 hover:shadow-[0_12px_36px_rgb(0,0,0,0.08)]">
					<div class="who-card__stack flex w-full max-w-sm flex-col items-center justify-center gap-3 sm:gap-4">
						<div class="who-card__icon who-card__icon--warm shrink-0" aria-hidden="true">
							<i class="fa-solid fa-heart"></i>
						</div>
						<h3 class="text-lg md:text-xl font-serif text-[var(--deep-teal)] m-0 leading-snug tracking-tight text-balance"><?php echo esc_html( $who_carer_title ); ?></h3>
						<p class="who-card__body text-center leading-relaxed m-0 text-base w-full"><?php echo esc_html( $who_carer_body ); ?></p>
					</div>
				</div>
			</div>
			<?php
			$fp_who_link = get_page_by_path( 'who-its-for', OBJECT, 'page' );
			if ( $fp_who_link ) :
				?>
			<p class="text-center mt-10 md:mt-12">
				<a
					href="<?php echo esc_url( get_permalink( $fp_who_link ) ); ?>"
					class="restwell-tap-link who-section__cta inline-flex items-center justify-center gap-2 text-lg font-semibold font-sans text-[var(--deep-teal)] no-underline border-b-2 border-[var(--deep-teal)]/25 pb-0.5 hover:border-[var(--warm-gold-text)] hover:text-[var(--warm-gold-text)] cursor-pointer transition-colors duration-300"
				>
					<?php esc_html_e( 'Find out if Restwell is right for you', 'restwell-retreats' ); ?>
					<span aria-hidden="true" class="inline-block">→</span>
				</a>
			</p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Property Snapshot -->
	<section class="property-section py-16 md:py-24 bg-white">
		<div class="container">
			<div class="property-grid grid gap-8 items-center">
				<div class="property-grid__image rounded-2xl overflow-hidden shadow-lg h-[350px] md:h-[450px]">
					<?php if ( $property_image_id ) : ?>
						<?php
						echo wp_get_attachment_image(
							$property_image_id,
							'large',
							false,
							array(
								'class'    => 'w-full h-full object-cover',
								'alt'      => $property_heading,
								'loading'  => 'lazy',
								'decoding' => 'async',
								'sizes'    => '(min-width: 768px) 50vw, 100vw',
							)
						);
						?>
					<?php else : ?>
						<!-- PROPERTY IMAGE NEEDED -->
						<div class="property-placeholder w-full h-[350px] bg-[var(--driftwood)] flex items-center justify-center text-[#8B8B7A] rounded-2xl">
							<span><?php esc_html_e( 'Add property image', 'restwell-retreats' ); ?></span>
						</div>
					<?php endif; ?>
				</div>
				<div class="property-grid__text space-y-6">
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $property_label ) ); ?>
					<h2 class="text-3xl section-heading"><?php echo esc_html( $property_heading ); ?></h2>
					<p class="text-[#3a5a63] leading-relaxed"><?php echo esc_html( $property_body ); ?></p>
					<?php
					$fp_acc       = get_page_by_path( 'accessibility', OBJECT, 'page' );
					$fp_who       = get_page_by_path( 'who-its-for', OBJECT, 'page' );
					$fp_guide     = get_page_by_path( 'whitstable-area-guide', OBJECT, 'page' );
					$fp_hiw       = get_page_by_path( 'how-it-works', OBJECT, 'page' );
					$fp_resources = get_page_by_path( 'resources', OBJECT, 'page' );
					$fp_faq       = get_page_by_path( 'faq', OBJECT, 'page' );
					$fp_quick     = array();
					if ( $fp_acc ) {
						$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_acc ) ) . '" class="text-deep-teal font-medium underline underline-offset-2 hover:no-underline cursor-pointer">' . esc_html__( 'Accessibility specification', 'restwell-retreats' ) . '</a>';
					}
					if ( $fp_who ) {
						$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_who ) ) . '" class="text-deep-teal font-medium underline underline-offset-2 hover:no-underline cursor-pointer">' . esc_html__( 'Who it\'s for', 'restwell-retreats' ) . '</a>';
					}
					if ( $fp_guide ) {
						$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_guide ) ) . '" class="text-deep-teal font-medium underline underline-offset-2 hover:no-underline cursor-pointer">' . esc_html__( 'Whitstable & Kent guide', 'restwell-retreats' ) . '</a>';
					}
					if ( $fp_hiw ) {
						$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_hiw ) ) . '" class="text-deep-teal font-medium underline underline-offset-2 hover:no-underline cursor-pointer">' . esc_html__( 'How booking works', 'restwell-retreats' ) . '</a>';
					}
					if ( $fp_resources ) {
						$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_resources ) ) . '" class="text-deep-teal font-medium underline underline-offset-2 hover:no-underline cursor-pointer">' . esc_html__( 'Funding & support', 'restwell-retreats' ) . '</a>';
					}
					if ( $fp_faq ) {
						$fp_quick[] = '<a href="' . esc_url( get_permalink( $fp_faq ) ) . '" class="text-deep-teal font-medium underline underline-offset-2 hover:no-underline cursor-pointer">' . esc_html__( 'FAQ', 'restwell-retreats' ) . '</a>';
					}
					if ( ! empty( $fp_quick ) ) :
						?>
					<p class="text-sm text-[#3a5a63]/90 leading-relaxed pt-2">
						<?php echo wp_kses_post( implode( '<span class="text-[var(--muted-grey)]" aria-hidden="true"> · </span>', $fp_quick ) ); ?>
					</p>
					<?php endif; ?>
					<a
						href="<?php echo esc_url( $property_cta_url ); ?>"
						class="inline-flex items-center gap-2 text-deep-teal font-semibold hover:text-[var(--warm-gold-text)] hover:underline transition-colors duration-300 no-underline cursor-pointer"
						data-cta="property-explore"
					>
						<?php echo esc_html( $property_cta_label ); ?>
						<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Why Restwell? Mini -->
	<section class="features-section py-16 md:py-24 bg-[var(--bg-subtle)]">
		<div class="container">
			<div class="text-center mb-12">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $why_label ) ); ?>
				<h2 class="text-3xl md:text-4xl section-heading"><?php echo esc_html( $why_heading ); ?></h2>
			</div>
			<div class="features-grid grid sm:grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto mt-8">
				<div class="feature-item group text-center space-y-4 p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] bg-white/70">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-house feature-icon-svg text-deep-teal text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-deep-teal"><?php echo esc_html( $why1_title ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $why1_desc ); ?></p>
				</div>

				<div class="feature-item group text-center space-y-4 p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] bg-white/70">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-shield-halved feature-icon-svg text-deep-teal text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-deep-teal"><?php echo esc_html( $why2_title ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $why2_desc ); ?></p>
				</div>

				<div class="feature-item group text-center space-y-4 p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] bg-white/70">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-location-dot feature-icon-svg text-deep-teal text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-deep-teal"><?php echo esc_html( $why3_title ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $why3_desc ); ?></p>
				</div>

				<div class="feature-item group text-center space-y-4 p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] bg-white/70">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-heart feature-icon-svg text-deep-teal text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-deep-teal"><?php echo esc_html( $why4_title ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $why4_desc ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<?php endif; ?>

	<?php if ( $show_home_faq && ! empty( $home_faq_pairs ) ) : ?>
	<!-- Homepage FAQ (matches FAQPage JSON-LD in inc/seo.php); outside editor/static branch so it shows when main body is from the editor too -->
	<section class="home-faq-section py-16 md:py-24 bg-white border-t border-[var(--deep-teal)]/10" aria-labelledby="home-faq-heading">
		<div class="container max-w-3xl">
			<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $home_faq_label ) ); ?>
			<h2 id="home-faq-heading" class="text-3xl md:text-4xl section-heading mb-8 md:mb-10"><?php echo esc_html( $home_faq_heading ); ?></h2>
			<dl class="home-faq-list space-y-6 m-0">
				<?php foreach ( $home_faq_pairs as $faq ) : ?>
					<?php
					if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
						continue;
					}
					?>
				<div class="home-faq__item border-b border-[var(--deep-teal)]/10 pb-6 last:border-0 last:pb-0">
					<dt class="text-lg font-serif text-[var(--deep-teal)] m-0 mb-2"><?php echo esc_html( $faq['q'] ); ?></dt>
					<dd class="text-[#3a5a63] leading-relaxed m-0"><?php echo esc_html( $faq['a'] ); ?></dd>
				</div>
				<?php endforeach; ?>
			</dl>
			<?php
			$home_faq_more = get_page_by_path( 'faq', OBJECT, 'page' );
			if ( $home_faq_more ) :
				?>
			<p class="mt-10 text-center m-0">
				<a
					href="<?php echo esc_url( get_permalink( $home_faq_more ) ); ?>"
					class="restwell-tap-link inline-flex items-center justify-center gap-2 text-[var(--deep-teal)] font-semibold underline-offset-2 hover:underline hover:text-[var(--warm-gold-text)] transition-colors duration-300 no-underline cursor-pointer"
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
	<section class="trust-strip border-t border-b border-[var(--deep-teal)]/8 py-12 md:py-16" aria-label="<?php echo esc_attr( __( 'Trust and accreditation', 'restwell-retreats' ) ); ?>">
		<div class="container text-center px-4 sm:px-6">
			<?php if ( $trust_label !== '' ) : ?>
				<p class="section-label mb-3"><?php echo esc_html( $trust_label ); ?></p>
			<?php endif; ?>
			<?php if ( $trust_heading !== '' ) : ?>
				<h2 class="text-2xl font-serif text-[var(--deep-teal)] mb-6"><?php echo esc_html( $trust_heading ); ?></h2>
			<?php endif; ?>
			<div class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-10 flex-wrap max-w-3xl mx-auto">
				<?php if ( $trust_badge_src ) : ?>
					<img src="<?php echo esc_url( $trust_badge_src ); ?>" alt="<?php echo esc_attr__( 'CQC regulated care provider accreditation', 'restwell-retreats' ); ?>" class="h-16 w-auto object-contain" loading="lazy" decoding="async" />
				<?php endif; ?>
				<?php if ( $trust_line !== '' ) : ?>
					<p class="trust-strip__line text-[var(--deep-teal)] font-medium leading-relaxed tracking-tight max-w-[52ch] mx-auto"><?php echo esc_html( $trust_line ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $show_testimonials ) : ?>
	<!-- Testimonials -->
	<section class="py-16 md:py-24 bg-[var(--soft-sand)]">
		<div class="container">
			<?php if ( $testimonial_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $testimonial_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl md:text-4xl section-heading text-center mb-12"><?php echo esc_html( $testimonial_heading ); ?></h2>
			<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
				<?php foreach ( $testimonials as $t ) : ?>
					<blockquote class="bg-[var(--bg-subtle)] rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 md:p-8 flex flex-col">
						<p class="text-[#3a5a63] leading-relaxed flex-1 mb-4"><?php echo esc_html( $t['quote'] ); ?></p>
						<footer class="text-[var(--deep-teal)] font-medium">
							<?php echo esc_html( $t['name'] ); ?>
							<?php if ( $t['role'] !== '' ) : ?>
								<span class="block text-sm font-normal text-[#3a5a63]/85"><?php echo esc_html( $t['role'] ); ?></span>
							<?php endif; ?>
						</footer>
					</blockquote>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( ! $use_editor_main ) : ?>
	<!-- CTA Section (omitted when main body comes from the page editor: CTA is in post_content) -->
	<section class="relative py-20 md:py-28 overflow-hidden">
		<?php if ( $cta_image_id ) : ?>
			<?php
			echo wp_get_attachment_image(
				$cta_image_id,
				'full',
				false,
				array(
					'class'    => 'absolute inset-0 w-full h-full object-cover',
					'alt'      => '',
					'loading'  => 'lazy',
					'decoding' => 'async',
					'role'     => 'presentation',
				)
			);
			?>
		<?php else : ?>
			<!-- IMAGE NEEDED: CTA background (set cta_image_id in Page Content Fields) -->
		<?php endif; ?>
		<div class="absolute inset-0 bg-deep-teal/75" aria-hidden="true"></div>
		<div class="relative container text-center">
			<h2 class="text-white text-3xl md:text-4xl mb-4 font-serif section-heading"><?php echo esc_html( $cta_heading ); ?></h2>
			<p class="text-soft-sand text-lg mb-8 max-w-lg mx-auto opacity-90 leading-relaxed">
				<?php echo esc_html( $cta_body ); ?>
			</p>
			<?php get_template_part( 'template-parts/cta-accessibility-prompt', null, array( 'variant' => 'dark' ) ); ?>
			<div class="flex flex-col sm:flex-row justify-center gap-4 max-w-sm mx-auto mt-8 mb-6 sm:mt-0 sm:mb-0 sm:max-w-none sm:mx-0">
				<a
					id="bottom-cta-enquire"
					href="<?php echo esc_url( $cta_primary_url ); ?>"
					class="btn btn-gold w-full sm:w-auto cursor-pointer"
					data-cta="cta-enquire"
				>
					<?php echo esc_html( $cta_primary_label ); ?>
				</a>
				<a
					href="<?php echo esc_url( $cta_secondary_url ); ?>"
					class="btn btn-ghost-light w-full sm:w-auto cursor-pointer"
					data-cta="cta-property"
				>
					<?php echo esc_html( $cta_secondary_label ); ?>
				</a>
			</div>
			<?php if ( $cta_promise !== '' ) : ?>
				<p class="text-white/90 text-sm mt-4"><?php echo esc_html( $cta_promise ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>
</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
