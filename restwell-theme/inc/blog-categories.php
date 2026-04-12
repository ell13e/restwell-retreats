<?php
/**
 * Blog (post) categories: Restwell-specific labels and editor-facing descriptions.
 *
 * Used when seeding posts and when ensuring default terms exist. Keeps copy aligned
 * with accessible travel, Kent, funding, and the property — not generic “blog” buckets.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Canonical category definitions (slug => data).
 *
 * Slugs are stable for URLs and imports; names are shown in the theme and admin.
 *
 * @return array<string, array{name: string, description: string}>
 */
function restwell_get_blog_category_definitions() {
	/*
	 * Editorial split (avoid two “planning” buckets):
	 * - Care funding & respite = money, LA/CHC routes, DP/PHB, carer assessments (statutory / budgets).
	 * - Property & suitability = access specs, checklists, choosing a place (place quality, not funding).
	 * Legacy terms such as “Planning” or “Funding & planning” in the database can be merged or
	 * retitled in Posts → Categories; new installs only get these four.
	 */
	return array(
		'kent-coast' => array(
			'name'        => __( 'Kent & coast', 'restwell-retreats' ),
			'description' => __( 'Local area: Whitstable, Thanet, beaches, day trips, and getting around.', 'restwell-retreats' ),
		),
		'funding-care' => array(
			'name'        => __( 'Care funding & respite', 'restwell-retreats' ),
			'description' => __( 'Direct payments, personal health budgets, CHC, LA routes, respite and carer assessments — what funding can cover.', 'restwell-retreats' ),
		),
		'accessible-holidays' => array(
			'name'        => __( 'Property & suitability', 'restwell-retreats' ),
			'description' => __( 'Choosing a property: access specs, wet room and hoist detail, self-catering checklists, and questions to ask before you book.', 'restwell-retreats' ),
		),
		'news-updates' => array(
			'name'        => __( 'News & sector updates', 'restwell-retreats' ),
			'description' => __( 'Charity and sector news, policy shifts, and announcements relevant to travellers with disabilities and carers.', 'restwell-retreats' ),
		),
	);
}

/**
 * Resolve a category slug to its display name, or pass through unknown strings (legacy).
 *
 * @param string $slug_or_name Category slug from definitions, or legacy full name.
 * @return string
 */
function restwell_get_blog_category_name( $slug_or_name ) {
	$slug_or_name = (string) $slug_or_name;
	$defs         = restwell_get_blog_category_definitions();
	if ( isset( $defs[ $slug_or_name ]['name'] ) ) {
		return $defs[ $slug_or_name ]['name'];
	}
	return $slug_or_name;
}

/**
 * Ensure all contextual categories exist (idempotent; safe to run on init).
 *
 * @return void
 */
function restwell_ensure_default_blog_categories() {
	if ( ! is_blog_installed() ) {
		return;
	}
	if ( ! function_exists( 'term_exists' ) || ! function_exists( 'wp_insert_term' ) ) {
		return;
	}
	foreach ( restwell_get_blog_category_definitions() as $slug => $data ) {
		$existing = get_term_by( 'slug', $slug, 'category' );
		if ( $existing && ! is_wp_error( $existing ) ) {
			if ( $existing->name !== $data['name'] || $existing->description !== $data['description'] ) {
				wp_update_term(
					(int) $existing->term_id,
					'category',
					array(
						'name'        => $data['name'],
						'description' => $data['description'],
					)
				);
			}
			continue;
		}
		$insert = wp_insert_term(
			$data['name'],
			'category',
			array(
				'slug'        => $slug,
				'description' => $data['description'],
			)
		);
		if ( is_wp_error( $insert ) && 'term_exists' === $insert->get_error_code() ) {
			continue;
		}
	}
}

add_action( 'init', 'restwell_ensure_default_blog_categories', 20 );
