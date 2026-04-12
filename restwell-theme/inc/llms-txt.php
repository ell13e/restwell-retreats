<?php
/**
 * Serve /llms.txt from the theme for AI crawlers (GEO).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the request URL matches the site’s /llms.txt path (supports subdirectory installs).
 *
 * @return bool
 */
function restwell_is_llms_txt_request() {
	$llms = wp_parse_url( home_url( '/llms.txt' ), PHP_URL_PATH );
	if ( ! is_string( $llms ) || $llms === '' ) {
		return false;
	}
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path = wp_parse_url( $uri, PHP_URL_PATH );
	if ( ! is_string( $path ) ) {
		return false;
	}
	return rtrim( $path, '/' ) === rtrim( $llms, '/' );
}

/**
 * Output plain-text llms.txt and exit.
 */
function restwell_serve_llms_txt() {
	if ( ! restwell_is_llms_txt_request() ) {
		return;
	}
	$file = get_template_directory() . '/llms.txt';
	if ( ! is_readable( $file ) ) {
		status_header( 404 );
		nocache_headers();
		echo "Not found.\n";
		exit;
	}
	status_header( 200 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'Cache-Control: public, max-age=3600' );
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- plain text file on disk
	readfile( $file );
	exit;
}
add_action( 'template_redirect', 'restwell_serve_llms_txt', 0 );
