<?php
/**
 * Footer template.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$enquire_url = home_url( '/enquire/' );
?>
<footer class="site-footer" role="contentinfo">
	<?php global $restwell_hide_footer_cta; ?>
	<?php if ( empty( $restwell_hide_footer_cta ) ) : ?>
	<div class="footer-cta">
		<div class="container">
			<h2 class="footer-cta__heading"><?php echo esc_html( (string) get_option( 'restwell_footer_cta_heading', 'Ready to book your stay?' ) ); ?></h2>
			<a href="<?php echo esc_url( $enquire_url ); ?>" class="footer-cta__btn"><?php echo esc_html( (string) get_option( 'restwell_footer_cta_btn', 'Enquire Now' ) ); ?></a>
		</div>
	</div>
	<?php endif; ?>
	<div class="container">
		<div class="footer-grid">
			<!-- Brand -->
			<div class="footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> home">
					<img
						src="<?php echo esc_url( restwell_get_logo_url( 'restwell_logo_long_id', 'long_logo.png' ) ); ?>"
						alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
						class="site-logo__img"
						width="282"
						height="44"
					>
				</a>
				<p class="footer-description"><?php echo esc_html( sprintf( __( 'A %s property. Care provided by Continuity Care Services.', 'restwell-retreats' ), get_bloginfo( 'name' ) ) ); ?></p>
			</div>

			<!-- Explore -->
			<div class="footer-explore">
				<h3 class="footer-heading"><?php esc_html_e( 'Explore', 'restwell-retreats' ); ?></h3>
				<nav aria-label="<?php esc_attr_e( 'Footer navigation', 'restwell-retreats' ); ?>">
					<ul class="footer-nav-list">
						<?php foreach ( restwell_get_footer_nav_links() as $item ) : ?>
							<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			</div>

			<!-- Contact -->
			<div class="footer-contact">
				<h3 class="footer-heading"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></h3>
				<p class="footer-contact__copy"><?php esc_html_e( 'Questions about dates, accessibility, or anything else? We\'re happy to help.', 'restwell-retreats' ); ?></p>
				<a href="<?php echo esc_url( $enquire_url ); ?>" class="footer-contact__link"><?php esc_html_e( 'Enquire now', 'restwell-retreats' ); ?></a>
			</div>
		</div>

		<div class="site-footer__bottom">
			<nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Legal', 'restwell-retreats' ); ?>">
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a>
				<span class="site-footer__legal-sep" aria-hidden="true">·</span>
				<a href="<?php echo esc_url( home_url( '/terms-and-conditions/' ) ); ?>"><?php esc_html_e( 'Terms &amp; Conditions', 'restwell-retreats' ); ?></a>
			</nav>
			<p class="site-footer__copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'restwell-retreats' ); ?></p>
		</div>
	</div>
	<?php wp_footer(); ?>
</footer>
</body>
</html>
