<?php
/**
 * Template part: section label (eyebrow text above section headings).
 * Contrast-safe label using --warm-gold-text token.
 *
 * @package Restwell_Retreats
 * @param array $args ['label' => string]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = (array) get_query_var( 'args', array() );
$label = isset( $args['label'] ) ? $args['label'] : '';
if ( $label === '' ) {
	return;
}
?>
<span class="section-label block mb-4"><?php echo esc_html( $label ); ?></span>
