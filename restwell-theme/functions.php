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
require_once get_template_directory() . '/inc/emails.php';
require_once get_template_directory() . '/inc/crm.php';
require_once get_template_directory() . '/inc/enquire-handler.php';
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/seo-admin.php';
require_once get_template_directory() . '/inc/guest-guide.php';
require_once get_template_directory() . '/inc/video-optimizer.php';

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

/**
 * Ensure the Excerpt meta box is always visible on the post edit screen.
 * Without this, editors need to find it under Screen Options.
 */
function restwell_show_excerpt_meta_box() {
	add_meta_box(
		'postexcerpt',
		__( 'Excerpt (archive summary)', 'restwell-retreats' ),
		'post_excerpt_meta_box',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_post', 'restwell_show_excerpt_meta_box' );

/**
 * Return the name of the primary (first assigned) category for the current post.
 * Returns an empty string if no category is assigned.
 *
 * @return string
 */
function restwell_get_primary_category() {
	$cats = get_the_category();
	if ( empty( $cats ) ) {
		return '';
	}
	// Prefer a category that isn't the WordPress default "Uncategorized".
	foreach ( $cats as $cat ) {
		if ( $cat->slug !== 'uncategorized' ) {
			return $cat->name;
		}
	}
	return $cats[0]->name;
}

/**
 * Estimate reading time in minutes for a block of post content.
 * Based on ~200 words per minute (comfortable for accessibility).
 *
 * @param string $content Raw post content.
 * @return int Minutes, minimum 1.
 */
function restwell_estimate_read_time( $content ) {
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) ceil( $word_count / 200 ) );
}
