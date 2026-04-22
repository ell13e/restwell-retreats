<?php
/**
 * TL;DR helper for rendering short extraction-friendly summaries below hero H1s.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return TL;DR text from post meta with optional fallback.
 *
 * @param int    $post_id  Post ID.
 * @param string $fallback Fallback text.
 * @return string
 */
function restwell_get_tldr_text( $post_id, $fallback = '' ) {
	$post_id = absint( $post_id );
	if ( $post_id <= 0 ) {
		return trim( (string) $fallback );
	}
	$text = trim( (string) get_post_meta( $post_id, 'rw_tldr_text', true ) );
	if ( $text !== '' ) {
		return $text;
	}
	return trim( (string) $fallback );
}

/**
 * Return TL;DR paragraph HTML or empty string.
 *
 * @param int    $post_id  Post ID.
 * @param string $fallback Fallback text.
 * @return string
 */
function restwell_get_tldr_markup( $post_id, $fallback = '' ) {
	$text = restwell_get_tldr_text( $post_id, $fallback );
	if ( $text === '' ) {
		return '';
	}
	return '<p class="rw-tldr home-hero__lede max-w-prose text-white [text-shadow:0_2px_4px_rgba(0,0,0,0.3)] font-sans text-base sm:text-lg md:text-xl font-normal leading-relaxed tracking-normal sm:tracking-tight text-balance m-0">' . esc_html( $text ) . '</p>';
}

