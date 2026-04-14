<?php
/**
 * Phosphor Icons — Light weight (MIT License, phosphor-icons/core).
 *
 * @package Restwell_Retreats
 *
 * @var array $args {
 *     @type string $name  One of: house_line, trend_up, chat_circle_text.
 *     @type string $class Optional classes on the root SVG (default w-8 h-8 shrink-0).
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();

$name = isset( $args['name'] ) ? sanitize_key( (string) $args['name'] ) : '';
$cls  = isset( $args['class'] ) ? (string) $args['class'] : 'w-8 h-8 shrink-0';

$paths = array(
	'house_line'        => 'M240,210H222V131.17l5.76,5.76a6,6,0,0,0,8.48-8.49L137.9,30.09a14,14,0,0,0-19.8,0L19.76,128.44a6,6,0,0,0,8.48,8.49L34,131.17V210H16a6,6,0,0,0,0,12H240a6,6,0,0,0,0-12ZM46,119.17l80.58-80.59a2,2,0,0,1,2.84,0L210,119.17V210H158V152a6,6,0,0,0-6-6H104a6,6,0,0,0-6,6v58H46ZM146,210H110V158h36Z',
	'trend_up'          => 'M238,56v64a6,6,0,0,1-12,0V70.48l-85.76,85.76a6,6,0,0,1-8.48,0L96,120.49,28.24,188.24a6,6,0,0,1-8.48-8.48l72-72a6,6,0,0,1,8.48,0L136,143.51,217.52,62H168a6,6,0,0,1,0-12h64A6,6,0,0,1,238,56Z',
	'chat_circle_text'  => 'M166,112a6,6,0,0,1-6,6H96a6,6,0,0,1,0-12h64A6,6,0,0,1,166,112Zm-6,26H96a6,6,0,0,0,0,12h64a6,6,0,0,0,0-12Zm70-10A102,102,0,0,1,79.31,217.65L44.44,229.27a14,14,0,0,1-17.71-17.71l11.62-34.87A102,102,0,1,1,230,128Zm-12,0A90,90,0,1,0,50.08,173.06a6,6,0,0,1,.5,4.91L38.12,215.35a2,2,0,0,0,2.53,2.53L78,205.42a6.2,6.2,0,0,1,1.9-.31,6.09,6.09,0,0,1,3,.81A90,90,0,0,0,218,128Z',
);

if ( ! isset( $paths[ $name ] ) ) {
	return;
}

printf(
	'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" width="32" height="32" class="%s" aria-hidden="true" focusable="false">',
	esc_attr( $cls )
);
echo '<path d="' . esc_attr( $paths[ $name ] ) . '" />';
echo '</svg>';
