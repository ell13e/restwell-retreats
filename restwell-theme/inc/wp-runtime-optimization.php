<?php
/**
 * WordPress runtime tweaks: minor front-end performance and security hygiene (theme-level).
 *
 * Object cache, page cache, CDN, browser cache for HTML, and security headers are hosting or plugin scope;
 * this file only applies safe defaults that do not change editorial behaviour.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove emoji detection script and related hooks — fewer requests and less JS on first paint.
 * Content remains UTF-8; WordPress emoji fallbacks are not required for this theme’s templates.
 */
function restwell_disable_emoji_scripts() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'restwell_disable_emoji_scripts', 1 );

/**
 * Omit the WordPress generator meta tag (minor version disclosure reduction).
 */
function restwell_remove_version_generator() {
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'restwell_remove_version_generator', 1 );
