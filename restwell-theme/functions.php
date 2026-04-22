<?php
/**
 * Restwell Retreats theme functions and definitions.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/blog-categories.php';

// Disable Gutenberg block editor - use classic editor
add_filter( 'use_block_editor_for_post', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );
add_filter( 'xmlrpc_enabled', '__return_false' );

require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/performance.php';
require_once get_template_directory() . '/inc/wp-runtime-optimization.php';
require_once get_template_directory() . '/inc/meta-fields.php';
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/social-profiles.php';
require_once get_template_directory() . '/inc/emails.php';
require_once get_template_directory() . '/inc/form-notify.php';
require_once get_template_directory() . '/inc/crm.php';
require_once get_template_directory() . '/inc/faq.php';
require_once get_template_directory() . '/inc/faq-question-handler.php';
require_once get_template_directory() . '/inc/enquire-handler.php';
require_once get_template_directory() . '/inc/tldr.php';
require_once get_template_directory() . '/inc/seo-social-meta.php';
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/seo-admin.php';
require_once get_template_directory() . '/inc/guest-guide.php';
require_once get_template_directory() . '/inc/video-optimizer.php';
require_once get_template_directory() . '/inc/sitemap-robots.php';
require_once get_template_directory() . '/inc/llms-txt.php';
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

	// Responsive theme images: cap hero/CTA width for smaller files + richer srcset (regenerate after deploy: wp media regenerate).
	add_image_size( 'restwell-hero', 1920, 0 );
	add_image_size( 'restwell-cta-bg', 1920, 0 );
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
 * Add CTA classes to the Enquire menu item so styles match fallback nav (desktop + mobile sheet).
 *
 * @param array    $atts  HTML attributes for the anchor.
 * @param WP_Post  $item  Menu item.
 * @param stdClass $args  Menu arguments.
 * @return array
 */
function restwell_primary_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $atts;
	}
	$enquire_url = restwell_nav_resolve_page_url( 'enquire' );
	$item_url    = isset( $item->url ) ? $item->url : '';
	if ( $item_url === '' || $enquire_url === '' ) {
		return $atts;
	}
	if ( untrailingslashit( $item_url ) !== untrailingslashit( $enquire_url ) ) {
		return $atts;
	}
	$existing       = isset( $atts['class'] ) ? $atts['class'] : '';
	$atts['class'] = trim( $existing . ' site-nav-cta mobile-nav-cta' );
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'restwell_primary_nav_menu_link_attributes', 10, 3 );

/**
 * Resolve a page slug to its permalink (home when slug is empty).
 *
 * @param string $slug Page path slug or empty for front page.
 * @return string
 */
function restwell_nav_resolve_page_url( $slug ) {
	static $cache = array();
	$slug = (string) $slug;
	if ( $slug === '' ) {
		return home_url( '/' );
	}
	if ( isset( $cache[ $slug ] ) ) {
		return $cache[ $slug ];
	}
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	$cache[ $slug ] = $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
	return $cache[ $slug ];
}

/**
 * 301 redirect legacy /contact/ to the enquire page (single contact surface).
 */
function restwell_redirect_contact_to_enquire() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	$target = restwell_nav_resolve_page_url( 'enquire' );

	if ( is_page( 'contact' ) ) {
		wp_safe_redirect( $target, 301 );
		exit;
	}

	// When no WP page exists, /contact/ may 404 — still consolidate to enquire.
	global $wp;
	if ( is_404() && isset( $wp->request ) && is_string( $wp->request ) && preg_match( '#^contact/?$#', $wp->request ) ) {
		wp_safe_redirect( $target, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'restwell_redirect_contact_to_enquire', 20 );

/**
 * 301 redirect legacy carers guide slug to canonical post URL (theme + seed use carers-respite-holiday-guide).
 */
function restwell_redirect_legacy_carers_guide_slug() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	global $wp;
	if ( ! isset( $wp->request ) || ! is_string( $wp->request ) ) {
		return;
	}
	if ( preg_match( '#^carers-holiday-respite-funding/?$#', $wp->request ) ) {
		wp_safe_redirect( home_url( '/carers-respite-holiday-guide/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'restwell_redirect_legacy_carers_guide_slug', 21 );

/**
 * Redirect public author archives to home to reduce user-enumeration surface.
 */
function restwell_redirect_author_archives() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'restwell_redirect_author_archives', 22 );

/**
 * Primary navigation tree for desktop: top-level links plus dropdown groups.
 * Used by the fallback menu; mobile/footer use a flattened list from the same data.
 *
 * @return array<int, array<string, mixed>>
 */
function restwell_get_primary_nav_structure() {
	static $built = null;
	if ( null !== $built ) {
		return $built;
	}

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

	$built = $out;
	return $built;
}

/**
 * Flat list of nav links for footer, mobile fallback, and SEO: same destinations as the desktop structure.
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
		echo '<span class="site-nav__dropdown-chevron" aria-hidden="true"><i class="ph-bold ph-caret-down"></i></span>';
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
 * Keep Categories and Tags high in the post sidebar so editors see them above the fold.
 * Classic editor + a large SEO meta box in "normal" often pushes the sidebar below the scroll.
 *
 * @return void
 */
function restwell_promote_post_taxonomy_meta_boxes() {
	remove_meta_box( 'categorydiv', 'post', 'side' );
	remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );

	add_meta_box(
		'categorydiv',
		__( 'Categories' ),
		'post_categories_meta_box',
		'post',
		'side',
		'high'
	);
	add_meta_box(
		'tagsdiv-post_tag',
		__( 'Tags' ),
		'post_tags_meta_box',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes_post', 'restwell_promote_post_taxonomy_meta_boxes', 20 );

/**
 * Return the name of the primary category for display (archive, single hero, schema).
 * Returns an empty string if none is set or only the default "Uncategorized" is assigned.
 *
 * @param int|null $post_id Optional post ID; defaults to current post in the loop.
 * @return string
 */
function restwell_get_primary_category( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : 0;
	$cats    = $post_id ? get_the_category( $post_id ) : get_the_category();
	if ( empty( $cats ) ) {
		return '';
	}
	foreach ( $cats as $cat ) {
		if ( $cat->slug !== 'uncategorized' ) {
			return $cat->name;
		}
	}
	return '';
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

/**
 * Parse newline-separated bullet list from post meta with fallback defaults.
 *
 * @param int    $post_id Post ID.
 * @param string $meta_key Meta key.
 * @param array  $default_bullets Default bullets.
 * @return array<int, string>
 */
function restwell_wif_bullet_list( $post_id, $meta_key, array $default_bullets ) {
	$raw = get_post_meta( $post_id, $meta_key, true );
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return $default_bullets;
	}
	$lines = array_filter( array_map( 'trim', explode( "\n", str_replace( "\r\n", "\n", $raw ) ) ) );
	return ! empty( $lines ) ? array_values( $lines ) : $default_bullets;
}

/**
 * Who It's For: main intro paragraph, with optional fallback to legacy detail_body meta.
 *
 * @param int    $post_id     Post ID.
 * @param string $primary_key Main body field.
 * @param string $legacy_key  Former detail_body field (used only when primary is empty).
 * @param string $default     Default copy when both are empty.
 */
function restwell_wif_persona_intro_body( $post_id, $primary_key, $legacy_key, $default ) {
	$primary = get_post_meta( $post_id, $primary_key, true );
	if ( is_string( $primary ) && '' !== trim( $primary ) ) {
		return $primary;
	}
	$legacy = get_post_meta( $post_id, $legacy_key, true );
	if ( is_string( $legacy ) && '' !== trim( $legacy ) ) {
		return $legacy;
	}
	return $default;
}

/**
 * Split English prose into sentences (period / ? / ! followed by space and new sentence).
 *
 * @param string $text Paragraph text.
 * @return array<int, string>
 */
function restwell_wif_split_sentences( $text ) {
	$text = trim( $text );
	if ( '' === $text ) {
		return array();
	}
	// Split after . ? ! when followed by whitespace and a typical sentence start.
	$parts = preg_split( '/(?<=[.!?])\s+(?=[A-Z"\'])/u', $text, -1, PREG_SPLIT_NO_EMPTY );
	if ( ! is_array( $parts ) || count( $parts ) <= 1 ) {
		return array( $text );
	}
	return array_values( array_map( 'trim', $parts ) );
}

/**
 * Group sentences into short paragraphs for mobile readability (2 sentences each).
 *
 * @param array<int, string> $sentences Sentence strings.
 * @param int                $per_block Max sentences per block.
 * @return array<int, string>
 */
function restwell_wif_group_sentences_into_blocks( array $sentences, $per_block = 2 ) {
	if ( empty( $sentences ) ) {
		return array();
	}
	$per_block = max( 1, (int) $per_block );
	$out       = array();
	$buffer    = array();
	foreach ( $sentences as $s ) {
		$buffer[] = $s;
		if ( count( $buffer ) >= $per_block ) {
			$out[]  = implode( ' ', $buffer );
			$buffer = array();
		}
	}
	if ( ! empty( $buffer ) ) {
		$out[] = implode( ' ', $buffer );
	}
	return $out;
}

/**
 * If a block is still one long string, break it into smaller paragraphs for scanning.
 *
 * @param string $block Single paragraph.
 * @param int    $max_chars Reflow when longer than this (UTF-8 safe via mbstring if available).
 * @return array<int, string>
 */
function restwell_wif_reflow_dense_paragraph( $block, $max_chars = 280 ) {
	$block = trim( $block );
	if ( '' === $block ) {
		return array();
	}
	$len = function_exists( 'mb_strlen' ) ? mb_strlen( $block ) : strlen( $block );
	if ( $len <= $max_chars ) {
		return array( $block );
	}
	$sentences = restwell_wif_split_sentences( $block );
	if ( count( $sentences ) <= 1 ) {
		return array( $block );
	}
	return restwell_wif_group_sentences_into_blocks( $sentences, 2 );
}

/**
 * Split persona body copy into paragraphs (blank line in editor / meta), then reflow very long blocks.
 *
 * @param string $text Raw body text.
 * @return array<int, string>
 */
function restwell_wif_split_body_paragraphs( $text ) {
	if ( ! is_string( $text ) || '' === trim( $text ) ) {
		return array();
	}
	$normalized = str_replace( array( "\r\n", "\r" ), "\n", $text );
	$parts      = preg_split( '/\n\s*\n/', $normalized );
	if ( ! is_array( $parts ) ) {
		$parts = array( $text );
	}
	$parts = array_map( 'trim', $parts );
	$parts = array_filter( $parts );
	$parts = array_values( $parts );

	$out = array();
	foreach ( $parts as $part ) {
		$chunked = restwell_wif_reflow_dense_paragraph( $part );
		foreach ( $chunked as $c ) {
			$out[] = $c;
		}
	}
	return $out;
}
