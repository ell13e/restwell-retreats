<?php
/**
 * Template Name: Privacy Policy
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
set_query_var( 'restwell_legal_fallback', 'privacy' );
get_template_part( 'template-parts/legal-policy-layout' );
get_footer();
