<?php
/**
 * Shared layout for Privacy, Terms, and Website Accessibility Policy templates.
 *
 * Expected query vars (set via set_query_var before get_template_part):
 * - restwell_legal_fallback: 'privacy' | 'terms' | 'accessibility' (selects default body HTML).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pid = (int) get_the_ID();
if ( $pid < 1 ) {
	return;
}

$fallback = (string) get_query_var( 'restwell_legal_fallback', '' );

$legal_label       = get_post_meta( $pid, 'legal_label', true );
$legal_heading     = get_post_meta( $pid, 'legal_heading', true );
$legal_intro       = get_post_meta( $pid, 'legal_intro', true );
$legal_hero_id     = (int) get_post_meta( $pid, 'legal_hero_image_id', true );
$legal_body_stored = get_post_meta( $pid, 'legal_body_html', true );

$defaults = array();
if ( function_exists( 'restwell_get_privacy_policy_page_defaults' ) ) {
	if ( 'terms' === $fallback && function_exists( 'restwell_get_terms_conditions_page_defaults' ) ) {
		$defaults = restwell_get_terms_conditions_page_defaults();
	} elseif ( 'accessibility' === $fallback && function_exists( 'restwell_get_accessibility_policy_page_defaults' ) ) {
		$defaults = restwell_get_accessibility_policy_page_defaults();
	} else {
		$defaults = restwell_get_privacy_policy_page_defaults();
	}
}

$legal_label   = is_string( $legal_label ) && $legal_label !== '' ? $legal_label : ( $defaults['legal_label'] ?? '' );
$legal_heading = is_string( $legal_heading ) && $legal_heading !== '' ? $legal_heading : ( $defaults['legal_heading'] ?? '' );
$legal_intro   = is_string( $legal_intro ) && $legal_intro !== '' ? $legal_intro : ( $defaults['legal_intro'] ?? '' );

$body_html = is_string( $legal_body_stored ) && trim( $legal_body_stored ) !== '' ? $legal_body_stored : '';

if ( $body_html === '' ) {
	if ( 'terms' === $fallback && function_exists( 'restwell_get_terms_conditions_content' ) ) {
		$body_html = restwell_get_terms_conditions_content();
	} elseif ( 'accessibility' === $fallback && function_exists( 'restwell_get_accessibility_policy_content' ) ) {
		$body_html = restwell_get_accessibility_policy_content();
	} elseif ( function_exists( 'restwell_get_privacy_policy_content' ) ) {
		$body_html = restwell_get_privacy_policy_content();
	}
}
?>
<main class="flex-1" id="main-content">
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>
	<?php
	set_query_var(
		'args',
		array(
			'heading_id' => 'page-hero-heading',
			'label'      => $legal_label,
			'heading'    => $legal_heading,
			'intro'      => $legal_intro,
			'media_id'   => $legal_hero_id,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<section class="legal-policy-section rw-section-y">
		<div class="container max-w-3xl">
			<article class="legal-policy-document">
				<div class="legal-policy-document__content prose prose-lg max-w-none text-[#3a5a63] prose-headings:font-serif prose-headings:text-[var(--deep-teal)] prose-a:text-[var(--deep-teal)] prose-a:font-medium prose-li:marker:text-[var(--deep-teal)]">
					<?php echo wp_kses_post( $body_html ); ?>
				</div>
				<p class="legal-policy-document__disclaimer">
					<?php esc_html_e( 'This page is provided for general information and is not legal advice. If you need advice for your situation, speak to a qualified solicitor or adviser.', 'restwell-retreats' ); ?>
				</p>
			</article>
		</div>
	</section>
</main>
