<?php
/**
 * Social meta output (Open Graph + Twitter Card).
 *
 * Kept in a dedicated include to reduce `inc/seo.php` file size and separate
 * social graph tags from JSON-LD and canonical logic.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output Open Graph and Twitter Card <meta> tags in <head>.
 */
function restwell_output_social_meta() {
	$pid = is_singular() ? get_queried_object_id() : 0;

	// Title
	if ( $pid ) {
		$title = (string) get_post_meta( $pid, 'meta_title', true );
		if ( $title === '' ) {
			$defaults = restwell_get_seo_default_meta_for_post_id( $pid );
			$title    = $defaults['meta_title'] !== '' ? $defaults['meta_title'] : get_the_title( $pid );
		}
	} else {
		$title = get_bloginfo( 'name' );
	}

	// Description
	$desc = '';
	if ( $pid ) {
		$desc = (string) get_post_meta( $pid, 'meta_description', true );
		if ( $desc === '' ) {
			$defaults = restwell_get_seo_default_meta_for_post_id( $pid );
			$desc     = $defaults['meta_description'];
		}
		if ( $desc === '' && is_singular( 'post' ) ) {
			$desc = wp_strip_all_tags( get_the_excerpt( $pid ) );
		}
	}
	if ( $desc === '' ) {
		$desc = (string) get_bloginfo( 'description' );
	}

	// URL
	$url = $pid ? get_permalink( $pid ) : home_url( '/' );
	if ( is_front_page() ) {
		$url = home_url( '/' );
	}

	// Image - og_image_id → featured image (posts) → template hero image → blank.
	$image_url           = '';
	$image_attachment_id = 0;
	if ( $pid ) {
		$og_img_id = absint( get_post_meta( $pid, 'og_image_id', true ) );
		if ( $og_img_id ) {
			$image_url           = wp_get_attachment_image_url( $og_img_id, 'full' );
			$image_attachment_id = $image_url ? $og_img_id : 0;
		}
		// For posts, use the featured image as the OG image.
		if ( ! $image_url && is_singular( 'post' ) ) {
			$thumb_id = get_post_thumbnail_id( $pid );
			if ( $thumb_id ) {
				$image_url           = wp_get_attachment_image_url( $thumb_id, 'full' );
				$image_attachment_id = $image_url ? $thumb_id : 0;
			}
		}
		if ( ! $image_url ) {
			// Fallback: try common hero image meta keys across templates
			$hero_keys = array( 'hero_media_id', 'prop_hero_image_id' );
			foreach ( $hero_keys as $key ) {
				$hero_id = absint( get_post_meta( $pid, $key, true ) );
				if ( $hero_id ) {
					$candidate = wp_get_attachment_image_url( $hero_id, 'full' );
					if ( $candidate ) {
						$image_url           = $candidate;
						$image_attachment_id = $hero_id;
						break;
					}
				}
			}
		}
	}

	$image_width  = 0;
	$image_height = 0;
	$image_alt    = '';
	if ( $image_attachment_id > 0 ) {
		$img_meta = wp_get_attachment_metadata( $image_attachment_id );
		if ( is_array( $img_meta ) ) {
			$image_width  = ! empty( $img_meta['width'] ) ? absint( $img_meta['width'] ) : 0;
			$image_height = ! empty( $img_meta['height'] ) ? absint( $img_meta['height'] ) : 0;
		}
		$image_alt = trim( (string) get_post_meta( $image_attachment_id, '_wp_attachment_image_alt', true ) );
	}
	if ( $image_alt === '' ) {
		$image_alt = $title !== '' ? $title : (string) get_bloginfo( 'name' );
	}

	// og:type - use saved value if set, otherwise derive from post type.
	$og_type = $pid ? (string) get_post_meta( $pid, 'meta_og_type', true ) : '';
	if ( ! in_array( $og_type, array( 'website', 'article' ), true ) ) {
		$og_type = is_singular( 'post' ) ? 'article' : 'website';
	}

	echo "\n<!-- Open Graph -->\n";
	echo '<meta property="og:locale" content="en_GB">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc !== '' ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	if ( $image_url ) {
		echo '<meta property="og:image" content="' . esc_url( $image_url ) . '">' . "\n";
		if ( $image_width > 0 ) {
			echo '<meta property="og:image:width" content="' . esc_attr( (string) $image_width ) . '">' . "\n";
		}
		if ( $image_height > 0 ) {
			echo '<meta property="og:image:height" content="' . esc_attr( (string) $image_height ) . '">' . "\n";
		}
	}
	if ( $pid && is_front_page() ) {
		echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c', $pid ) ) . '">' . "\n";
		echo '<meta property="article:modified_time" content="' . esc_attr( get_the_modified_date( 'c', $pid ) ) . '">' . "\n";
	}
	if ( is_singular( 'post' ) ) {
		$post_obj = get_post();
		if ( $post_obj ) {
			echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c', $post_obj ) ) . '">' . "\n";
			echo '<meta property="article:author" content="' . esc_attr( get_the_author_meta( 'display_name', (int) $post_obj->post_author ) ) . '">' . "\n";
		}
	}

	echo "\n<!-- Twitter Card -->\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc !== '' ) {
		echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	if ( $image_url ) {
		echo '<meta name="twitter:image" content="' . esc_url( $image_url ) . '">' . "\n";
		echo '<meta name="twitter:image:alt" content="' . esc_attr( wp_strip_all_tags( $image_alt ) ) . '">' . "\n";
	}
	echo "\n";
}
add_action( 'wp_head', 'restwell_output_social_meta', 5 );

