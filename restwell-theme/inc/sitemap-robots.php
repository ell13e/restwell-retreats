<?php
/**
 * Robots.txt and XML sitemap discovery helpers.
 *
 * WordPress 5.5+ exposes HTML sitemaps at /wp-sitemap.xml (index). This file
 * ensures the sitemap URL is declared in robots.txt and avoids blocking assets.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Append sitemap index URL to virtual robots.txt output.
 *
 * @param string $output robots.txt content.
 * @param bool   $public Whether the site is public.
 * @return string
 */
function restwell_robots_txt_sitemap_line( $output, $public ) {
	if ( '0' === (string) get_option( 'blog_public' ) ) {
		return $output;
	}
	$sitemap = home_url( '/wp-sitemap.xml' );
	if ( strpos( $output, 'wp-sitemap.xml' ) !== false ) {
		return $output;
	}
	$output .= "\nSitemap: " . esc_url( $sitemap ) . "\n";
	return $output;
}
add_filter( 'robots_txt', 'restwell_robots_txt_sitemap_line', 10, 2 );
