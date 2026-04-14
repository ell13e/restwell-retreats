<?php
/**
 * Front-end performance helpers: responsive image sizes, LCP preload, fallbacks.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pick a registered image size when its file exists; otherwise fall back so older uploads still render.
 *
 * @param int    $attachment_id Attachment ID.
 * @param string $preferred     Preferred size name (e.g. restwell-hero).
 * @param string ...$fallbacks  Additional size names to try before full.
 * @return string Size name for wp_get_attachment_image / src.
 */
function restwell_pick_attachment_size( $attachment_id, $preferred, ...$fallbacks ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id <= 0 ) {
		return $preferred;
	}
	$meta = wp_get_attachment_metadata( $attachment_id );
	if ( empty( $meta['sizes'] ) || ! is_array( $meta['sizes'] ) ) {
		return 'full';
	}
	$sizes = $meta['sizes'];
	if ( ! empty( $sizes[ $preferred ] ) ) {
		return $preferred;
	}
	foreach ( $fallbacks as $fb ) {
		if ( $fb && ! empty( $sizes[ $fb ] ) ) {
			return $fb;
		}
	}
	// Common theme / WP sizes.
	foreach ( array( 'large', 'medium_large', 'medium' ) as $fb ) {
		if ( ! empty( $sizes[ $fb ] ) ) {
			return $fb;
		}
	}
	return 'full';
}

/**
 * Regenerate WordPress intermediate sizes for every image attachment so new theme sizes
 * (e.g. restwell-hero, restwell-cta-bg) exist in metadata. Intended for admin Theme Setup.
 *
 * May be slow on very large media libraries; use the skip option or WP-CLI `wp media regenerate` instead.
 *
 * @return array{processed:int, errors:int, skipped:bool, error_samples:string[]}
 */
function restwell_regenerate_all_image_subsizes() {
	$result = array(
		'processed'      => 0,
		'errors'         => 0,
		'skipped'        => false,
		'error_samples'  => array(),
	);

	if ( ! function_exists( 'wp_update_image_subsizes' ) ) {
		$result['error_samples'][] = __( 'wp_update_image_subsizes() is not available.', 'restwell-retreats' );
		return $result;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';

	if ( function_exists( 'set_time_limit' ) ) {
		set_time_limit( 0 );
	}

	$ids = get_posts(
		array(
			'post_type'              => 'attachment',
			'post_status'            => 'inherit',
			'posts_per_page'         => -1,
			'post_mime_type'         => 'image',
			'fields'                 => 'ids',
			'orderby'                => 'ID',
			'order'                  => 'ASC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
		)
	);

	foreach ( $ids as $id ) {
		$file = get_attached_file( $id );
		if ( ! $file || ! file_exists( $file ) ) {
			continue;
		}

		$ok = wp_update_image_subsizes( $id );
		if ( is_wp_error( $ok ) ) {
			++$result['errors'];
			if ( count( $result['error_samples'] ) < 3 ) {
				$result['error_samples'][] = sprintf(
					/* translators: 1: attachment ID, 2: error message */
					__( 'Attachment %1$d: %2$s', 'restwell-retreats' ),
					(int) $id,
					$ok->get_error_message()
				);
			}
		} else {
			++$result['processed'];
		}
	}

	return $result;
}

/**
 * Preload the front-page hero image for LCP (image heroes only; not video).
 */
function restwell_preload_front_page_hero_image() {
	if ( ! is_front_page() ) {
		return;
	}
	$pid = (int) get_queried_object_id();
	if ( $pid <= 0 ) {
		return;
	}
	$hero_media_id = (int) get_post_meta( $pid, 'hero_media_id', true );
	if ( $hero_media_id <= 0 ) {
		return;
	}
	$mime = get_post_mime_type( $hero_media_id );
	if ( ! $mime || strpos( $mime, 'image/' ) !== 0 ) {
		return;
	}
	$size = restwell_pick_attachment_size( $hero_media_id, 'restwell-hero' );
	$src  = wp_get_attachment_image_src( $hero_media_id, $size );
	if ( ! $src || empty( $src[0] ) ) {
		return;
	}
	$srcset = wp_get_attachment_image_srcset( $hero_media_id, $size );
	$sizes  = '100vw';
	echo '<link rel="preload" as="image" href="' . esc_url( $src[0] ) . '"';
	if ( $srcset ) {
		echo ' imagesrcset="' . esc_attr( $srcset ) . '" imagesizes="' . esc_attr( $sizes ) . '"';
	}
	echo ' />' . "\n";
}
add_action( 'wp_head', 'restwell_preload_front_page_hero_image', 1 );
