<?php
/**
 * Header template.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a href="#main-content" class="skip-link">Skip to main content</a>
<header class="site-header">
	<div class="container">
		<!-- Logo -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php echo esc_attr( sprintf( __( '%s home', 'restwell-retreats' ), restwell_site_brand_lockup() ) ); ?>">
			<img
				src="<?php echo esc_url( restwell_get_logo_url( 'restwell_logo_long_id', 'long_logo.png' ) ); ?>"
				alt="<?php echo esc_attr( restwell_site_brand_lockup() ); ?>"
				class="site-logo__img"
				width="282"
				height="44"
			>
		</a>

		<!-- Desktop Nav -->
		<nav class="site-nav" aria-label="Main navigation">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => '',
					'menu_class'     => 'site-nav-list',
					'items_wrap'     => '<ul class="site-nav-list">%3$s</ul>',
					'depth'          => 2,
				)
			);
		} else {
			restwell_render_primary_nav_fallback();
		}
		?>
		</nav>

		<!-- Mobile Menu Button (toggle will be wired up in main.js) -->
		<button
			type="button"
			class="mobile-menu-btn"
			aria-expanded="false"
			aria-controls="mobile-nav"
			aria-label="Open menu"
		>
			<i class="fa-solid fa-bars js-menu-icon-open" aria-hidden="true"></i>
			<i class="fa-solid fa-xmark js-menu-icon-close" aria-hidden="true"></i>
		</button>
	</div>

	<!-- Mobile Nav -->
	<nav id="mobile-nav" class="mobile-nav" aria-hidden="true" aria-label="Mobile navigation">
		<div class="container">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => '',
					'menu_class'     => 'mobile-nav-list',
					'items_wrap'     => '<ul class="mobile-nav-list">%3$s</ul>',
					'depth'          => 2,
				)
			);
		} else {
			echo '<ul class="mobile-nav-list">';
			foreach ( restwell_get_fallback_nav_links() as $item ) {
				$class = ! empty( $item['is_cta'] ) ? ' mobile-nav-cta' : '';
				echo '<li><a href="' . esc_url( $item['url'] ) . '" class="' . esc_attr( trim( $class ) ) . '">' . esc_html( $item['label'] ) . '</a></li>';
			}
			echo '</ul>';
		}
		?>
		</div>
	</nav>
</header>
