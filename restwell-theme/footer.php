<?php
/**
 * Footer template.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$enquire_url          = home_url( '/enquire/' );
$property_url         = home_url( '/the-property/' );
$access_statement_url = function_exists( 'restwell_get_access_statement_url' ) ? restwell_get_access_statement_url() : '';
$legal_entity_name    = (string) get_option( 'restwell_footer_legal_name', __( 'Homely Housing Investments Ltd t/a Restwell Retreats', 'restwell-retreats' ) );

$footer_cta_heading = trim( (string) get_option( 'restwell_footer_cta_heading', '' ) );
if ( $footer_cta_heading === '' ) {
	$footer_cta_heading = __( 'Ready to plan your break?', 'restwell-retreats' );
}

$footer_cta_intro = trim( (string) get_option( 'restwell_footer_cta_intro', '' ) );
if ( $footer_cta_intro === '' ) {
	$footer_cta_intro = __( 'Tell us what you need - dates, accessibility, or a look around the property - and we will help you plan with confidence.', 'restwell-retreats' );
}

$footer_cta_primary_label = trim( (string) get_option( 'restwell_footer_cta_primary_label', '' ) );
if ( $footer_cta_primary_label === '' ) {
	$footer_cta_primary_label = __( 'See the property', 'restwell-retreats' );
}
$footer_cta_primary_raw = trim( (string) get_option( 'restwell_footer_cta_primary_url', '' ) );
if ( $footer_cta_primary_raw === '' ) {
	$footer_cta_primary_url = $property_url;
} elseif ( preg_match( '#^https?://#i', $footer_cta_primary_raw ) ) {
	$footer_cta_primary_url = esc_url( $footer_cta_primary_raw );
} else {
	$footer_cta_primary_url = esc_url( home_url( '/' . ltrim( $footer_cta_primary_raw, '/' ) ) );
}
$footer_cta_secondary_label = trim( (string) get_option( 'restwell_footer_cta_btn', '' ) );
if ( $footer_cta_secondary_label === '' ) {
	$footer_cta_secondary_label = __( 'Check your dates', 'restwell-retreats' );
}

$footer_cta_note = trim( (string) get_option( 'restwell_footer_cta_note', '' ) );
if ( $footer_cta_note === '' ) {
	$footer_cta_note = __( 'No booking commitment. Just a conversation.', 'restwell-retreats' );
}
?>
<footer class="site-footer" role="contentinfo">
	<?php global $restwell_hide_footer_cta; ?>
	<?php if ( empty( $restwell_hide_footer_cta ) ) : ?>
	<div class="footer-cta">
		<div class="container">
			<h2 class="footer-cta__heading"><?php echo esc_html( $footer_cta_heading ); ?></h2>
			<p class="footer-cta__intro"><?php echo esc_html( $footer_cta_intro ); ?></p>
			<div class="footer-cta__actions">
				<a href="<?php echo esc_url( $footer_cta_primary_url ); ?>" class="footer-cta__btn footer-cta__btn--primary" data-cta="footer-cta-property"><?php echo esc_html( $footer_cta_primary_label ); ?></a>
				<a href="<?php echo esc_url( $enquire_url ); ?>" class="footer-cta__btn footer-cta__btn--ghost" data-cta="footer-cta-enquire"><?php echo esc_html( $footer_cta_secondary_label ); ?></a>
			</div>
			<p class="footer-cta__note"><?php echo esc_html( $footer_cta_note ); ?></p>
		</div>
	</div>
	<?php endif; ?>
	<div class="container">
		<div class="footer-grid">
			<!-- Brand -->
			<div class="footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php echo esc_attr( sprintf( __( '%s home', 'restwell-retreats' ), restwell_site_brand_lockup() ) ); ?>">
					<img
						src="<?php echo esc_url( restwell_get_logo_url( 'restwell_logo_long_id', 'long_logo.png' ) ); ?>"
						alt="<?php echo esc_attr( restwell_site_brand_lockup() ); ?>"
						class="site-logo__img"
						width="282"
						height="44"
					>
				</a>
				<p class="footer-description"><?php echo esc_html__( 'Care provided by Continuity of Care Services.', 'restwell-retreats' ); ?></p>
				<p class="footer-legal-name"><?php echo esc_html( $legal_entity_name ); ?></p>
			</div>

			<!-- Explore -->
			<div class="footer-explore">
				<h3 class="footer-heading"><?php esc_html_e( 'Explore', 'restwell-retreats' ); ?></h3>
				<nav aria-label="<?php esc_attr_e( 'Footer navigation', 'restwell-retreats' ); ?>">
					<ul class="footer-nav-list">
						<?php foreach ( restwell_get_primary_nav_links() as $item ) : ?>
							<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			</div>

			<!-- Contact -->
			<div class="footer-contact">
				<h3 class="footer-heading"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></h3>
				<p class="footer-contact__copy"><?php esc_html_e( 'Questions about dates, accessibility, or anything else? We\'re happy to help.', 'restwell-retreats' ); ?></p>
				<p class="footer-contact__actions m-0 flex flex-col gap-2">
					<a href="<?php echo esc_url( $enquire_url ); ?>" class="footer-contact__link" data-cta="footer-contact-enquire"><?php esc_html_e( 'Enquire now', 'restwell-retreats' ); ?></a>
					<?php
					$restwell_contact_page = get_page_by_path( 'contact', OBJECT, 'page' );
					if ( $restwell_contact_page instanceof WP_Post ) :
						?>
					<a href="<?php echo esc_url( get_permalink( $restwell_contact_page ) ); ?>" class="footer-contact__link footer-contact__link--secondary text-sm font-normal opacity-90 hover:opacity-100" data-cta="footer-contact-details"><?php esc_html_e( 'Phone, email & address', 'restwell-retreats' ); ?></a>
					<?php endif; ?>
				</p>
			</div>
		</div>

		<div class="site-footer__bottom">
			<nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Legal', 'restwell-retreats' ); ?>">
				<?php if ( $access_statement_url !== '' ) : ?>
					<a href="<?php echo esc_url( $access_statement_url ); ?>" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'Access statement (PDF)', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a>
					<span class="site-footer__legal-sep" aria-hidden="true">/</span>
				<?php endif; ?>
				<a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'FAQ', 'restwell-retreats' ); ?></a>
				<span class="site-footer__legal-sep" aria-hidden="true">/</span>
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a>
				<span class="site-footer__legal-sep" aria-hidden="true">/</span>
				<a href="<?php echo esc_url( home_url( '/terms-and-conditions/' ) ); ?>"><?php esc_html_e( 'Terms &amp; Conditions', 'restwell-retreats' ); ?></a>
			</nav>
			<p class="site-footer__copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $legal_entity_name ); ?>. <?php esc_html_e( 'All rights reserved.', 'restwell-retreats' ); ?></p>
		</div>
	</div>
	<?php wp_footer(); ?>
</footer>
</body>
</html>
