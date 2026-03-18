<?php
/**
 * Restwell Retreats theme functions and definitions.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Disable Gutenberg block editor — use classic editor
add_filter( 'use_block_editor_for_post', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/meta-fields.php';
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enquire-handler.php';
require_once get_template_directory() . '/inc/seo.php';

/**
 * Declare theme support and register nav menu.
 */
function restwell_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'restwell-retreats' ),
		)
	);
}
add_action( 'after_setup_theme', 'restwell_theme_setup' );

/**
 * Curated primary nav items (when no menu is assigned).
 * Order: Home first, then service/info pages, then CTA. Last item (Enquire) is the CTA button.
 *
 * @return array<int, array{label: string, url: string, is_cta?: bool}>
 */
function restwell_get_primary_nav_links() {
	$items = array(
		array( 'label' => __( 'Home', 'restwell-retreats' ), 'slug' => '' ),
		array( 'label' => __( 'The Property', 'restwell-retreats' ), 'slug' => 'the-property' ),
		array( 'label' => __( 'How It Works', 'restwell-retreats' ), 'slug' => 'how-it-works' ),
		array( 'label' => __( 'Accessibility', 'restwell-retreats' ), 'slug' => 'accessibility' ),
		array( 'label' => __( 'Funding & Support', 'restwell-retreats' ), 'slug' => 'resources' ),
		array( 'label' => __( 'FAQ', 'restwell-retreats' ), 'slug' => 'faq' ),
		array( 'label' => __( 'Enquire Now', 'restwell-retreats' ), 'slug' => 'enquire', 'is_cta' => true ),
	);
	$links = array();
	foreach ( $items as $item ) {
		if ( $item['slug'] === '' ) {
			$url = home_url( '/' );
		} else {
			$page = get_page_by_path( $item['slug'], OBJECT, 'page' );
			$url  = $page ? get_permalink( $page ) : home_url( '/' . $item['slug'] . '/' );
		}
		$link = array(
			'label' => $item['label'],
			'url'   => $url,
		);
		if ( ! empty( $item['is_cta'] ) ) {
			$link['is_cta'] = true;
		}
		$links[] = $link;
	}
	return $links;
}

/**
 * Fallback nav links when no menu is assigned to Primary.
 * Uses restwell_get_primary_nav_links() for consistent order and labels.
 *
 * @return array<int, array{label: string, url: string}>
 */
function restwell_get_fallback_nav_links() {
	return restwell_get_primary_nav_links();
}

/**
 * Footer nav links (Explore section).
 * Same structure as primary; can be filtered or simplified for footer.
 *
 * @return array<int, array{label: string, url: string}>
 */
function restwell_get_footer_nav_links() {
	return restwell_get_primary_nav_links();
}
