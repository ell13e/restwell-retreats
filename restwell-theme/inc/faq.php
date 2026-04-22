<?php
/**
 * FAQ helpers – single source of truth for all FAQ data on the site.
 *
 * All FAQ content is stored on the FAQ template page under the keys
 * `faq_{N}_q`, `faq_{N}_a`, and `faq_{N}_cat` (up to 14 items).
 * Templates and JSON-LD helpers call `restwell_get_faq_items()` so
 * editing one page updates FAQs everywhere.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the post ID of the page using template-faq.php, or 0 if not found.
 *
 * Result is cached in a static variable to avoid repeated DB queries per
 * request.
 *
 * @return int
 */
function restwell_get_faq_page_id(): int {
	static $faq_page_id = null;
	if ( null !== $faq_page_id ) {
		return $faq_page_id;
	}

	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'template-faq.php',
			'number'     => 1,
		)
	);

	$faq_page_id = ( ! empty( $pages ) ) ? (int) $pages[0]->ID : 0;
	return $faq_page_id;
}

/**
 * Retrieve FAQ items from the canonical FAQ page.
 *
 * @param string $scope  One of 'faq-page', 'homepage', 'how-it-works'.
 *                       All scopes read from the same source; 'homepage'
 *                       limits the result to the first 7 items.
 * @return array<int, array{q: string, a: string, cat: string}>
 *         Each item has 'q' (question), 'a' (answer), 'cat' (category slug).
 */
function restwell_get_faq_items( string $scope = 'faq-page' ): array {
	$pid = restwell_get_faq_page_id();

	$items = array();

	if ( $pid > 0 ) {
		for ( $i = 1; $i <= 14; $i++ ) {
			$q   = (string) get_post_meta( $pid, "faq_{$i}_q", true );
			$a   = (string) get_post_meta( $pid, "faq_{$i}_a", true );
			$cat = (string) get_post_meta( $pid, "faq_{$i}_cat", true );
			if ( $q !== '' && $a !== '' ) {
				$items[] = array(
					'q'   => $q,
					'a'   => $a,
					'cat' => $cat !== '' ? $cat : 'about',
				);
			}
		}
	}

	// Fall back to static defaults if the FAQ page has no saved content yet.
	if ( empty( $items ) && function_exists( 'restwell_get_faq_page_default_pairs' ) ) {
		foreach ( restwell_get_faq_page_default_pairs() as $row ) {
			$items[] = array(
				'q'   => $row['q'],
				'a'   => $row['a'],
				'cat' => isset( $row['cat'] ) ? $row['cat'] : 'about',
			);
		}
	}

	if ( 'homepage' === $scope ) {
		// Homepage shows the first 7 items maximum.
		$items = array_slice( $items, 0, 7 );
	}

	/**
	 * Filter FAQ items returned for a given scope.
	 *
	 * @param array<int, array{q:string,a:string,cat:string}> $items  Items.
	 * @param string                                          $scope  Scope key.
	 * @param int                                             $pid    FAQ page ID.
	 */
	return apply_filters( 'restwell_faq_items', $items, $scope, $pid );
}
