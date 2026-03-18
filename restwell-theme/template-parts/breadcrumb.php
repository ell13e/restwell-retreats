<?php
/**
 * Breadcrumb: Home > Current page.
 *
 * Included at the top of each interior page template (below <main>, above the
 * page hero section). Not shown on the front page.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_front_page() ) {
	return;
}
?>
<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'restwell-retreats' ); ?>">
	<div class="container">
		<ol class="breadcrumb__list">
			<li class="breadcrumb__item">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="breadcrumb__link">
					<?php esc_html_e( 'Home', 'restwell-retreats' ); ?>
				</a>
			</li>
			<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">
				<?php echo esc_html( get_the_title() ); ?>
			</li>
		</ol>
	</div>
</nav>
