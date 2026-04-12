<?php
/**
 * Short trust line linking to the Accessibility specification (final CTA band).
 *
 * @package Restwell_Retreats
 * @param array $args {
 *     Optional. Passed via get_template_part( ..., null, array( 'variant' => 'dark' ) ).
 *
 *     @type string $variant `dark` (white text on teal) or `light` (body text on pale).
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// get_template_part( ..., null, array( 'variant' => 'dark' ) ) passes $variant via load_template extract().
if ( ! isset( $variant ) || '' === $variant ) {
	$passed = (array) get_query_var( 'args', array() );
	$variant = isset( $passed['variant'] ) ? sanitize_key( $passed['variant'] ) : 'dark';
} else {
	$variant = sanitize_key( $variant );
}

$acc_page = get_page_by_path( 'accessibility', OBJECT, 'page' );
if ( ! $acc_page ) {
	return;
}

$wrap_class = 'dark' === $variant
	? 'text-white/85 text-sm max-w-lg mx-auto mb-6 leading-relaxed'
	: 'text-[#3a5a63] text-sm max-w-lg mx-auto mb-6 leading-relaxed';

$link_class = 'dark' === $variant
	? 'text-white font-medium underline underline-offset-2 hover:text-[var(--warm-gold-hero)] focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70 rounded'
	: 'text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:text-[var(--warm-gold-text)] focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded';
?>
<p class="<?php echo esc_attr( $wrap_class ); ?>">
	<a href="<?php echo esc_url( get_permalink( $acc_page ) ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
		<?php esc_html_e( 'Full access specification', 'restwell-retreats' ); ?>
	</a><?php echo esc_html__( ': hoist coverage, door widths, wet room.', 'restwell-retreats' ); ?>
</p>
