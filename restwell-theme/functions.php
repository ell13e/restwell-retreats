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
require_once get_template_directory() . '/inc/sitemap-robots.php';
require_once get_template_directory() . '/inc/seo-dashboard.php';

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
 * Align Primary menu markup with fallback nav classes for shared dropdown CSS/JS.
 *
 * @param string[] $classes Nav item classes.
 * @param WP_Post  $item    Menu item.
 * @param stdClass $args    wp_nav_menu() arguments.
 * @param int      $depth   Depth.
 * @return string[]
 */
function restwell_primary_nav_menu_css_class( $classes, $item, $args, $depth ) {
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $classes;
	}
	if ( 0 === (int) $depth ) {
		$classes[] = 'site-nav__item';
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$classes[] = 'site-nav__item--has-dropdown';
		}
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'restwell_primary_nav_menu_css_class', 10, 4 );

/**
 * Add submenu class so Primary dropdowns share styles with the fallback nav.
 *
 * @param string[] $classes Submenu ul classes.
 * @param stdClass $args    wp_nav_menu() arguments.
 * @param int      $depth   Depth.
 * @return string[]
 */
function restwell_primary_nav_submenu_css_class( $classes, $args, $depth ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$classes[] = 'site-nav__submenu';
	}
	return $classes;
}
add_filter( 'nav_menu_submenu_css_class', 'restwell_primary_nav_submenu_css_class', 10, 3 );

/**
 * Resolve a page slug to its permalink (home when slug is empty).
 *
 * @param string $slug Page path slug or empty for front page.
 * @return string
 */
function restwell_nav_resolve_page_url( $slug ) {
	$slug = (string) $slug;
	if ( $slug === '' ) {
		return home_url( '/' );
	}
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/**
 * Primary navigation tree for desktop: top-level links plus dropdown groups.
 * Used by the fallback menu; mobile/footer use a flattened list from the same data.
 *
 * @return array<int, array<string, mixed>>
 */
function restwell_get_primary_nav_structure() {
	$raw = array(
		array(
			'type'   => 'link',
			'label'  => __( 'Home', 'restwell-retreats' ),
			'slug'   => '',
			'is_cta' => false,
		),
		array(
			'type'     => 'dropdown',
			'label'    => __( 'Your stay', 'restwell-retreats' ),
			'nav_id'   => 'restwell-nav-stay',
			'children' => array(
				array( 'label' => __( 'The Property', 'restwell-retreats' ), 'slug' => 'the-property' ),
				array( 'label' => __( 'How It Works', 'restwell-retreats' ), 'slug' => 'how-it-works' ),
				array( 'label' => __( 'Accessibility', 'restwell-retreats' ), 'slug' => 'accessibility' ),
				array( 'label' => __( 'Who It\'s For', 'restwell-retreats' ), 'slug' => 'who-its-for' ),
			),
		),
		array(
			'type'     => 'dropdown',
			'label'    => __( 'Area & funding', 'restwell-retreats' ),
			'nav_id'   => 'restwell-nav-area',
			'children' => array(
				array( 'label' => __( 'Whitstable Guide', 'restwell-retreats' ), 'slug' => 'whitstable-area-guide' ),
				array( 'label' => __( 'Blog', 'restwell-retreats' ), 'slug' => 'blog' ),
				array( 'label' => __( 'Funding & Support', 'restwell-retreats' ), 'slug' => 'resources' ),
			),
		),
		array(
			'type'   => 'link',
			'label'  => __( 'FAQ', 'restwell-retreats' ),
			'slug'   => 'faq',
			'is_cta' => false,
		),
		array(
			'type'   => 'link',
			'label'  => __( 'Enquire Now', 'restwell-retreats' ),
			'slug'   => 'enquire',
			'is_cta' => true,
		),
	);

	$out = array();
	foreach ( $raw as $item ) {
		if ( 'link' === $item['type'] ) {
			$out[] = array(
				'type'   => 'link',
				'label'  => $item['label'],
				'slug'   => $item['slug'],
				'url'    => restwell_nav_resolve_page_url( $item['slug'] ),
				'is_cta' => ! empty( $item['is_cta'] ),
			);
		} else {
			$children = array();
			foreach ( $item['children'] as $ch ) {
				$children[] = array(
					'label' => $ch['label'],
					'slug'  => $ch['slug'],
					'url'   => restwell_nav_resolve_page_url( $ch['slug'] ),
				);
			}
			$out[] = array(
				'type'     => 'dropdown',
				'label'    => $item['label'],
				'nav_id'   => $item['nav_id'],
				'children' => $children,
			);
		}
	}

	return $out;
}

/**
 * Flat list of nav links (footer, mobile, SEO): same destinations as the desktop structure.
 *
 * @return array<int, array{label: string, url: string, is_cta?: bool}>
 */
function restwell_get_primary_nav_links() {
	$flat = array();
	foreach ( restwell_get_primary_nav_structure() as $item ) {
		if ( 'link' === $item['type'] ) {
			$row = array(
				'label' => $item['label'],
				'url'   => $item['url'],
			);
			if ( ! empty( $item['is_cta'] ) ) {
				$row['is_cta'] = true;
			}
			$flat[] = $row;
		} else {
			foreach ( $item['children'] as $ch ) {
				$flat[] = array(
					'label' => $ch['label'],
					'url'   => $ch['url'],
				);
			}
		}
	}
	return $flat;
}

/**
 * Markup for the desktop fallback nav (dropdowns + links). Used when no Primary menu is assigned.
 */
function restwell_render_primary_nav_fallback() {
	$structure = restwell_get_primary_nav_structure();
	echo '<ul class="site-nav-list">';
	foreach ( $structure as $item ) {
		if ( 'link' === $item['type'] ) {
			$class = ! empty( $item['is_cta'] ) ? 'site-nav-cta' : '';
			echo '<li class="site-nav__item">';
			echo '<a href="' . esc_url( $item['url'] ) . '" class="' . esc_attr( trim( $class ) ) . '">' . esc_html( $item['label'] ) . '</a>';
			echo '</li>';
			continue;
		}

		$mid = $item['nav_id'];
		echo '<li class="site-nav__item site-nav__item--has-dropdown" data-nav-dropdown>';
		echo '<button type="button" class="site-nav__dropdown-toggle" id="' . esc_attr( $mid ) . '-btn" aria-expanded="false" aria-haspopup="true" aria-controls="' . esc_attr( $mid ) . '-menu">';
		echo esc_html( $item['label'] );
		echo '<span class="site-nav__dropdown-chevron" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>';
		echo '</button>';
		echo '<ul class="site-nav__submenu" id="' . esc_attr( $mid ) . '-menu" role="list">';
		foreach ( $item['children'] as $ch ) {
			echo '<li class="site-nav__submenu-item" role="none">';
			echo '<a href="' . esc_url( $ch['url'] ) . '" class="site-nav__submenu-link">' . esc_html( $ch['label'] ) . '</a>';
			echo '</li>';
		}
		echo '</ul>';
		echo '</li>';
	}
	echo '</ul>';
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
