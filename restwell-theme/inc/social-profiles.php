<?php
/**
 * Official social profile URLs (single source of truth for footer, contact, JSON-LD).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Social network profile URLs keyed by service id.
 *
 * @return array<string, string>
 */
function restwell_get_social_profile_urls() {
	$defaults = array(
		'facebook'  => 'https://www.facebook.com/restwellretreats/',
		'instagram' => 'https://www.instagram.com/restwellretreats',
		'linkedin'  => 'https://www.linkedin.com/company/restwell-retreats',
	);

	/**
	 * Filter official social profile URLs (empty string omits a network).
	 *
	 * @param array<string, string> $defaults Keyed URLs.
	 */
	$urls = apply_filters( 'restwell_social_profile_urls', $defaults );

	$clean = array();
	foreach ( $urls as $key => $url ) {
		if ( ! is_string( $key ) || ! is_string( $url ) ) {
			continue;
		}
		$key = sanitize_key( $key );
		$url = esc_url_raw( trim( $url ) );
		if ( $key === '' || $url === '' ) {
			continue;
		}
		if ( function_exists( 'wp_http_validate_url' ) && ! wp_http_validate_url( $url ) ) {
			continue;
		}
		$clean[ $key ] = $url;
	}

	return $clean;
}

/**
 * Flat, unique profile URLs for JSON-LD `sameAs`.
 *
 * @return string[]
 */
function restwell_get_social_same_as_list() {
	$order   = array( 'facebook', 'instagram', 'linkedin' );
	$urls    = restwell_get_social_profile_urls();
	$ordered = array();
	foreach ( $order as $key ) {
		if ( isset( $urls[ $key ] ) ) {
			$ordered[] = $urls[ $key ];
		}
	}
	foreach ( $urls as $key => $url ) {
		if ( ! in_array( $key, $order, true ) ) {
			$ordered[] = $url;
		}
	}
	return array_values( array_unique( $ordered ) );
}
