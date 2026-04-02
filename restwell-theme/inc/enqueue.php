<?php
/**
 * Enqueue all theme styles and scripts.
 * Loaded on every page via wp_enqueue_scripts; header/footer output wp_head() and wp_footer().
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end styles and scripts for the theme.
 */
function restwell_enqueue_scripts() {
	$theme_uri = get_template_directory_uri();
	$version   = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'font-awesome',
		$theme_uri . '/assets/css/fontawesome/all.min.css',
		array(),
		'6.5.1'
	);

	wp_enqueue_style(
		'restwell-tailwind',
		$theme_uri . '/assets/css/tailwind.css',
		array(),
		$version
	);

	wp_enqueue_script(
		'restwell-main',
		$theme_uri . '/assets/js/main.js',
		array(),
		$version,
		true
	);

}
add_action( 'wp_enqueue_scripts', 'restwell_enqueue_scripts' );

/**
 * Load main.js with defer (non-blocking) for better LCP / main-thread work.
 *
 * @param string $tag    The script HTML.
 * @param string $handle Script handle.
 * @param string $src    Source URL (unused).
 * @return string
 */
function restwell_defer_main_script( $tag, $handle, $src ) {
	unset( $src );
	if ( 'restwell-main' !== $handle ) {
		return $tag;
	}
	if ( false !== strpos( $tag, ' defer' ) ) {
		return $tag;
	}
	return str_replace( '<script ', '<script defer ', $tag );
}
add_filter( 'script_loader_tag', 'restwell_defer_main_script', 10, 3 );

/**
 * Enqueue polished admin styles for Restwell CRM screens.
 *
 * @param string $hook_suffix Current admin page hook suffix.
 */
function restwell_enqueue_admin_styles( $hook_suffix ) {
	$target_hooks = array(
		'toplevel_page_restwell-crm',
		'restwell_page_restwell-enquiries',
		'restwell_page_restwell-guest-guide',
	);

	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

	$load_crm_screen = in_array( $hook_suffix, $target_hooks, true )
		|| in_array( $page, array( 'restwell-crm', 'restwell-enquiries', 'restwell-guest-guide' ), true );

	// Guest Guide meta box on page edit: shared form/section classes in admin-crm.css.
	$page_editor_gg = false;
	if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( $screen && isset( $screen->post_type ) && 'page' === $screen->post_type ) {
			$page_editor_gg = true;
		} elseif ( 'post.php' === $hook_suffix && isset( $_GET['post'] ) ) {
			$page_editor_gg = ( 'page' === get_post_type( absint( wp_unslash( $_GET['post'] ) ) ) );
		} elseif ( 'post-new.php' === $hook_suffix && isset( $_GET['post_type'] ) ) {
			$page_editor_gg = ( 'page' === sanitize_key( wp_unslash( $_GET['post_type'] ) ) );
		}
	}

	if ( ! $load_crm_screen && ! $page_editor_gg ) {
		return;
	}

	wp_enqueue_style(
		'restwell-admin-crm',
		get_template_directory_uri() . '/assets/css/admin-crm.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'admin_enqueue_scripts', 'restwell_enqueue_admin_styles' );
