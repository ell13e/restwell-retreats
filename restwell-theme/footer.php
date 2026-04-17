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

$social_profiles = function_exists( 'restwell_get_social_profile_urls' ) ? restwell_get_social_profile_urls() : array();

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
	$footer_cta_secondary_label = __( 'Ask about your dates', 'restwell-retreats' );
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
				<a href="<?php echo esc_url( $footer_cta_primary_url ); ?>" class="footer-cta__btn footer-cta__btn--primary" data-cta="footer-cta-property"><?php echo esc_html( $footer_cta_primary_label ); ?> <i class="ph-bold ph-arrow-right" aria-hidden="true"></i></a>
				<a href="<?php echo esc_url( $enquire_url ); ?>" class="footer-cta__btn footer-cta__btn--ghost" data-cta="footer-cta-enquire"><?php echo esc_html( $footer_cta_secondary_label ); ?> <i class="ph-bold ph-arrow-right" aria-hidden="true"></i></a>
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
				<?php if ( ! empty( $social_profiles ) ) : ?>
					<nav class="footer-social" aria-label="<?php esc_attr_e( 'Social media', 'restwell-retreats' ); ?>">
						<ul class="footer-social__list">
							<?php if ( ! empty( $social_profiles['facebook'] ) ) : ?>
								<li>
									<a class="footer-social__link" href="<?php echo esc_url( $social_profiles['facebook'] ); ?>" rel="noopener noreferrer" target="_blank" data-cta="footer-social-facebook">
										<i class="ph-bold ph-facebook-logo footer-social__icon" aria-hidden="true"></i>
										<span class="footer-social__label"><?php esc_html_e( 'Facebook', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></span>
									</a>
								</li>
							<?php endif; ?>
							<?php if ( ! empty( $social_profiles['instagram'] ) ) : ?>
								<li>
									<a class="footer-social__link" href="<?php echo esc_url( $social_profiles['instagram'] ); ?>" rel="noopener noreferrer" target="_blank" data-cta="footer-social-instagram">
										<i class="ph-bold ph-instagram-logo footer-social__icon" aria-hidden="true"></i>
										<span class="footer-social__label"><?php esc_html_e( 'Instagram', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></span>
									</a>
								</li>
							<?php endif; ?>
							<?php if ( ! empty( $social_profiles['linkedin'] ) ) : ?>
								<li>
									<a class="footer-social__link" href="<?php echo esc_url( $social_profiles['linkedin'] ); ?>" rel="noopener noreferrer" target="_blank" data-cta="footer-social-linkedin">
										<i class="ph-bold ph-linkedin-logo footer-social__icon" aria-hidden="true"></i>
										<span class="footer-social__label"><?php esc_html_e( 'LinkedIn', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></span>
									</a>
								</li>
							<?php endif; ?>
						</ul>
					</nav>
				<?php endif; ?>
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

			<?php
			// Contact panel: primary CTA to the enquiry page (phone and email are on that page).
			$footer_contact_url = function_exists( 'restwell_nav_resolve_page_url' )
				? restwell_nav_resolve_page_url( 'enquire' )
				: $enquire_url;
			$footer_contact_cta = __( 'Send an enquiry', 'restwell-retreats' );

			global $restwell_hide_footer_contact;
			$restwell_show_footer_contact = empty( $restwell_hide_footer_contact );
			/* Same URL is already on-page; skip redundant mini-CTA. */
			if ( $restwell_show_footer_contact && function_exists( 'is_page_template' ) ) {
				if ( is_page_template( 'template-enquire.php' ) || is_page_template( 'template-contact.php' ) ) {
					$restwell_show_footer_contact = false;
				}
			}
			?>
			<?php if ( $restwell_show_footer_contact ) : ?>
			<div class="footer-contact" role="region" aria-labelledby="footer-contact-heading">
				<h3 id="footer-contact-heading" class="footer-heading"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></h3>
				<a href="<?php echo esc_url( $footer_contact_url ); ?>" class="footer-cta__btn footer-cta__btn--ghost" data-cta="footer-contact-primary">
					<?php echo esc_html( $footer_contact_cta ); ?> <i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
			<?php endif; ?>
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
				<span class="site-footer__legal-sep" aria-hidden="true">/</span>
				<a href="<?php echo esc_url( home_url( '/accessibility-policy/' ) ); ?>"><?php esc_html_e( 'Website accessibility', 'restwell-retreats' ); ?></a>
			</nav>
			<p class="site-footer__copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $legal_entity_name ); ?>. <?php esc_html_e( 'All rights reserved.', 'restwell-retreats' ); ?></p>
		</div>
	</div>
	<?php wp_footer(); ?>
</footer>
</body>
</html>
