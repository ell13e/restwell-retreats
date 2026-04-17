<?php
/**
 * Template Name: Accessibility Policy
 *
 * Website accessibility statement (WCAG, feedback). Distinct from the property
 * "Accessibility" specification page (template-accessibility.php).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
set_query_var( 'restwell_legal_fallback', 'accessibility' );
get_template_part( 'template-parts/legal-policy-layout' );
get_footer();
