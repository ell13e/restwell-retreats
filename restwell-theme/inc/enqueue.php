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
