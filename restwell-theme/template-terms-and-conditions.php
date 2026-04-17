<?php
/**
 * Template Name: Terms & Conditions
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
set_query_var( 'restwell_legal_fallback', 'terms' );
get_template_part( 'template-parts/legal-policy-layout' );
get_footer();
