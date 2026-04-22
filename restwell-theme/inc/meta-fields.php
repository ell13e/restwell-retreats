<?php
/**
 * Page Content Fields - meta box for page structured content (front page + template pages).
 * WordPress core only; no plugins.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/page-meta-definitions.php';

const RESTWELL_META_NONCE_ACTION = 'restwell_page_content_fields_save';
const RESTWELL_META_NONCE_NAME   = 'restwell_page_content_fields_nonce';

/**
 * Register meta box "Page Content Fields" for pages.
 */
function restwell_register_page_content_meta_box() {
	add_meta_box(
		'restwell_page_content_fields',
		__( 'Page Content Fields', 'restwell-retreats' ),
		'restwell_page_content_meta_box_callback',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'restwell_register_page_content_meta_box' );

/**
 * Enqueue WordPress media modal on page edit screens only.
 */
function restwell_enqueue_media_for_page_edit() {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type || ! in_array( $screen->base, array( 'post', 'post-new' ), true ) ) {
		return;
	}
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'restwell_enqueue_media_for_page_edit' );

/**
 * Meta box callback: output all input fields in a tabbed interface.
 */
function restwell_page_content_meta_box_callback( $post ) {
	wp_nonce_field( RESTWELL_META_NONCE_ACTION, RESTWELL_META_NONCE_NAME );

	$fields  = restwell_get_page_content_field_definitions( $post );
	$current = get_post_meta( $post->ID, '', true );
	$index   = 0;

	?>

	<div class="restwell-meta-fields" data-post-id="<?php echo esc_attr( (string) $post->ID ); ?>">
		<h2 class="nav-tab-wrapper">
			<?php
			foreach ( array_keys( $fields ) as $section ) {
				$panel_id = 'restwell-panel-' . $index;
				$active   = ( 0 === $index ) ? ' nav-tab-active' : '';
				echo '<a href="#' . esc_attr( $panel_id ) . '" class="nav-tab restwell-nav-tab' . esc_attr( $active ) . '" data-panel="' . esc_attr( $panel_id ) . '" role="tab">' . esc_html( $section ) . '</a>';
				$index++;
			}
			$index = 0;
			?>
		</h2>

		<?php
		foreach ( $fields as $section => $items ) {
			$panel_id = 'restwell-panel-' . $index;
			$active   = ( 0 === $index ) ? ' active' : '';
			echo '<div id="' . esc_attr( $panel_id ) . '" class="restwell-tab-panel' . esc_attr( $active ) . '" role="tabpanel" aria-label="' . esc_attr( $section ) . '">';

		foreach ( $items as $key => $field ) {
			$label = $field['label'];
			$type  = $field['type'];
			$value = isset( $current[ $key ][0] ) ? $current[ $key ][0] : '';
			$id    = 'restwell_' . $key;
			$name  = $key;
			echo '<div class="restwell-field">';

			if ( 'textarea' === $type ) {
				echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
				echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" rows="5">' . esc_textarea( $value ) . '</textarea>';
			} elseif ( 'image' === $type || 'media' === $type ) {
				$img_value    = absint( $value );
				$img_url      = $img_value ? wp_get_attachment_image_url( $img_value, 'medium' ) : '';
				$mime_type    = $img_value ? get_post_mime_type( $img_value ) : '';
				$is_video     = $mime_type && strpos( $mime_type, 'video/' ) === 0;
				$preview_show = $img_value ? '' : ' style="display:none;"';
				$remove_show  = $img_value ? '' : ' style="display:none;"';
				$allows_video = ( 'media' === $type );
				$allowed      = $allows_video ? ' data-allowed-types="image,video"' : ' data-allowed-types="image"';
				$preview_src  = $img_url ? esc_url( $img_url ) : '';
				$preview_text = $is_video ? esc_html__( 'Video selected', 'restwell-retreats' ) : '';
				$input_id     = $id . '_value';
				echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
				echo '<div class="restwell-image-upload restwell-media-upload"' . $allowed . '>';
				echo '<input type="hidden" id="' . esc_attr( $input_id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
				echo '<div class="restwell-image-preview"' . $preview_show . '>';
				if ( $allows_video ) {
					echo '<img src="' . $preview_src . '" alt="" style="' . ( $is_video ? 'display:none;' : '' ) . '" />';
					echo '<span class="restwell-media-preview-text" style="' . ( $is_video ? '' : 'display:none;' ) . '">' . $preview_text . '</span>';
				} else {
					echo '<img src="' . $preview_src . '" alt="" />';
				}
				echo '</div>';
				$select_btn_text = $allows_video ? __( 'Select image or video', 'restwell-retreats' ) : __( 'Select Image', 'restwell-retreats' );
				echo '<button type="button" id="' . esc_attr( $id ) . '" class="button button-secondary restwell-select-image">' . esc_html( $select_btn_text ) . '</button>';
				echo '<button type="button" class="button button-link restwell-remove-image"' . $remove_show . '>' . esc_html__( 'Remove', 'restwell-retreats' ) . '</button>';
				echo '</div>';
			} elseif ( 'number' === $type ) {
				echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
				echo '<input type="number" step="any" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
			} else {
				echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
				echo '<input type="text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
			}
			echo '</div>';
		}
			echo '</div>';
			$index++;
		}
		?>

	</div>
	<?php
}

/**
 * Save meta box: verify nonce and sanitize all fields for this page's template.
 */
function restwell_save_page_content_meta_box( $post_id ) {
	if ( ! isset( $_POST[ RESTWELL_META_NONCE_NAME ] ) ||
	     ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ RESTWELL_META_NONCE_NAME ] ) ), RESTWELL_META_NONCE_ACTION ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post   = get_post( $post_id );
	$fields = restwell_get_page_content_field_definitions( $post );
	foreach ( $fields as $items ) {
		foreach ( $items as $key => $field ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				continue;
			}
			$raw  = wp_unslash( $_POST[ $key ] );
			$type = $field['type'];
			if ( 'image' === $type || 'media' === $type ) {
				$value = absint( $raw );
			} elseif ( 'textarea' === $type && 'legal_body_html' === $key ) {
				$value = wp_kses_post( $raw );
			} elseif ( 'textarea' === $type ) {
				$value = sanitize_textarea_field( $raw );
			} elseif ( 'number' === $type ) {
				$value = sanitize_text_field( $raw );
			} else {
				$value = sanitize_text_field( $raw );
			}
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_page', 'restwell_save_page_content_meta_box' );
