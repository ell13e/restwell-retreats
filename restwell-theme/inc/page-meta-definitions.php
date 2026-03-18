<?php
/**
 * Page content field definitions by template.
 * Used by meta-fields.php to show the right fields when editing a page.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get field definitions for a page. Returns sections => [ meta_key => label ].
 *
 * @param WP_Post|null $post Page post or null.
 * @return array<string, array<string, string>>
 */
function restwell_get_page_content_field_definitions( $post = null ) {
	$front_page_id = (int) get_option( 'page_on_front', 0 );
	if ( $post && (int) $post->ID === $front_page_id ) {
		return restwell_get_front_page_field_definitions();
	}
	$template = $post ? get_page_template_slug( $post ) : '';
	$map = array(
		'template-property.php'    => 'restwell_get_property_field_definitions',
		'template-how-it-works.php'=> 'restwell_get_how_it_works_field_definitions',
		'template-accessibility.php' => 'restwell_get_accessibility_field_definitions',
		'template-faq.php'        => 'restwell_get_faq_field_definitions',
		'template-enquire.php'    => 'restwell_get_enquire_field_definitions',
		'template-resources.php'  => 'restwell_get_resources_field_definitions',
	);
	if ( isset( $map[ $template ] ) && is_callable( $map[ $template ] ) ) {
		return call_user_func( $map[ $template ] );
	}
	return array(
		'SEO' => array(
			'meta_title'       => __( 'SEO title (overrides page title in search results)', 'restwell-retreats' ),
			'meta_description' => __( 'Meta description (for search engines)', 'restwell-retreats' ),
			'og_image_id'      => __( 'Social share image', 'restwell-retreats' ),
		),
	);
}

/**
 * Front page (existing) definitions.
 */
function restwell_get_front_page_field_definitions() {
	return array(
		'SEO' => array(
			'meta_title'       => __( 'SEO title (overrides page title in search results)', 'restwell-retreats' ),
			'meta_description' => __( 'Meta description (for search engines)', 'restwell-retreats' ),
			'og_image_id'      => __( 'Social share image', 'restwell-retreats' ),
		),
		'Hero' => array(
			'hero_eyebrow'            => __( 'Hero eyebrow label', 'restwell-retreats' ),
			'hero_heading'            => __( 'Hero heading (h1)', 'restwell-retreats' ),
			'hero_subheading'         => __( 'Hero subheading', 'restwell-retreats' ),
			'hero_media_id'           => __( 'Hero background (image or video)', 'restwell-retreats' ),
			'hero_cta_primary_label'  => __( 'Hero primary button label', 'restwell-retreats' ),
			'hero_cta_primary_url'    => __( 'Hero primary button URL', 'restwell-retreats' ),
			'hero_cta_secondary_label'=> __( 'Hero secondary button label', 'restwell-retreats' ),
			'hero_cta_secondary_url'  => __( 'Hero secondary button URL', 'restwell-retreats' ),
			'hero_cta_promise'        => __( 'Hero promise line (optional)', 'restwell-retreats' ),
		),
		'What is Restwell?' => array(
			'what_restwell_label'   => __( 'Section label', 'restwell-retreats' ),
			'what_restwell_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'intro_body'            => __( 'Intro body (paragraph)', 'restwell-retreats' ),
		),
		'Who it\'s for' => array(
			'who_label'        => __( 'Section label', 'restwell-retreats' ),
			'who_heading'      => __( 'Section heading (h2)', 'restwell-retreats' ),
			'who_guest_title'  => __( 'Guest card title', 'restwell-retreats' ),
			'who_guest_body'   => __( 'Guest card body', 'restwell-retreats' ),
			'who_carer_title'  => __( 'Carer card title', 'restwell-retreats' ),
			'who_carer_body'   => __( 'Carer card body', 'restwell-retreats' ),
		),
		'Property snapshot' => array(
			'property_label'      => __( 'Section label', 'restwell-retreats' ),
			'property_heading'   => __( 'Section heading (e.g. 101 Russell Drive)', 'restwell-retreats' ),
			'property_body'      => __( 'Property body copy', 'restwell-retreats' ),
			'property_cta_label' => __( 'CTA link label', 'restwell-retreats' ),
			'property_cta_url'   => __( 'CTA link URL', 'restwell-retreats' ),
			'property_image_id'  => __( 'Property image (attachment ID)', 'restwell-retreats' ),
		),
		'Why Restwell?' => array(
			'why_label'       => __( 'Section label', 'restwell-retreats' ),
			'why_heading'     => __( 'Section heading (h2)', 'restwell-retreats' ),
			'why_item1_title' => __( 'Item 1 title', 'restwell-retreats' ),
			'why_item1_desc'  => __( 'Item 1 description', 'restwell-retreats' ),
			'why_item2_title' => __( 'Item 2 title', 'restwell-retreats' ),
			'why_item2_desc'  => __( 'Item 2 description', 'restwell-retreats' ),
			'why_item3_title' => __( 'Item 3 title', 'restwell-retreats' ),
			'why_item3_desc'  => __( 'Item 3 description', 'restwell-retreats' ),
			'why_item4_title' => __( 'Item 4 title', 'restwell-retreats' ),
			'why_item4_desc'  => __( 'Item 4 description', 'restwell-retreats' ),
		),
		'Trust / accreditations' => array(
			'trust_label'          => __( 'Section label (optional)', 'restwell-retreats' ),
			'trust_heading'        => __( 'Section heading (optional)', 'restwell-retreats' ),
			'trust_badge_image_id' => __( 'Badge image (attachment ID, e.g. CQC)', 'restwell-retreats' ),
			'trust_line'           => __( 'Trust line (e.g. Care by Continuity of Care Services – CQC regulated)', 'restwell-retreats' ),
		),
		'Testimonials' => array(
			'testimonial_label'   => __( 'Section label (optional)', 'restwell-retreats' ),
			'testimonial_heading'  => __( 'Section heading (e.g. What guests say)', 'restwell-retreats' ),
			'testimonial_1_quote' => __( 'Testimonial 1 quote', 'restwell-retreats' ),
			'testimonial_1_name'  => __( 'Testimonial 1 name', 'restwell-retreats' ),
			'testimonial_1_role'  => __( 'Testimonial 1 role/location (optional)', 'restwell-retreats' ),
			'testimonial_2_quote' => __( 'Testimonial 2 quote', 'restwell-retreats' ),
			'testimonial_2_name'  => __( 'Testimonial 2 name', 'restwell-retreats' ),
			'testimonial_2_role'  => __( 'Testimonial 2 role (optional)', 'restwell-retreats' ),
			'testimonial_3_quote' => __( 'Testimonial 3 quote', 'restwell-retreats' ),
			'testimonial_3_name'  => __( 'Testimonial 3 name', 'restwell-retreats' ),
			'testimonial_3_role'  => __( 'Testimonial 3 role (optional)', 'restwell-retreats' ),
			'testimonial_4_quote' => __( 'Testimonial 4 quote', 'restwell-retreats' ),
			'testimonial_4_name'  => __( 'Testimonial 4 name', 'restwell-retreats' ),
			'testimonial_4_role'  => __( 'Testimonial 4 role (optional)', 'restwell-retreats' ),
			'testimonial_5_quote' => __( 'Testimonial 5 quote', 'restwell-retreats' ),
			'testimonial_5_name'  => __( 'Testimonial 5 name', 'restwell-retreats' ),
			'testimonial_5_role'  => __( 'Testimonial 5 role (optional)', 'restwell-retreats' ),
		),
		'CTA section' => array(
			'cta_heading'         => __( 'CTA heading (h2)', 'restwell-retreats' ),
			'cta_body'            => __( 'CTA body copy', 'restwell-retreats' ),
			'cta_primary_label'   => __( 'CTA primary button label', 'restwell-retreats' ),
			'cta_primary_url'     => __( 'CTA primary button URL', 'restwell-retreats' ),
			'cta_secondary_label' => __( 'CTA secondary button label', 'restwell-retreats' ),
			'cta_secondary_url'   => __( 'CTA secondary button URL', 'restwell-retreats' ),
			'cta_promise'         => __( 'CTA promise line (optional)', 'restwell-retreats' ),
			'cta_image_id'        => __( 'CTA background image (attachment ID)', 'restwell-retreats' ),
		),
	);
}

/**
 * The Property page.
 */
function restwell_get_property_field_definitions() {
	return array(
		'SEO' => array(
			'meta_title'            => __( 'SEO title (overrides page title in search results)', 'restwell-retreats' ),
			'meta_description'      => __( 'Meta description', 'restwell-retreats' ),
			'og_image_id'           => __( 'Social share image', 'restwell-retreats' ),
			'prop_address_street'   => __( 'Street address (structured data)', 'restwell-retreats' ),
			'prop_address_locality' => __( 'Town / city (structured data)', 'restwell-retreats' ),
			'prop_address_region'   => __( 'County / region (structured data)', 'restwell-retreats' ),
			'prop_address_postcode' => __( 'Postcode (structured data)', 'restwell-retreats' ),
		),
		'Hero' => array(
			'prop_hero_label'   => __( 'Hero label (e.g. The Property)', 'restwell-retreats' ),
			'prop_hero_heading' => __( 'Hero heading (h1)', 'restwell-retreats' ),
			'prop_hero_subtitle'=> __( 'Hero subtitle (under heading)', 'restwell-retreats' ),
			'prop_hero_image_id'=> __( 'Hero image (attachment ID)', 'restwell-retreats' ),
			'prop_hero_cta_text'           => __( 'Hero primary CTA label (e.g. Enquire about dates)', 'restwell-retreats' ),
			'prop_hero_cta_url'            => __( 'Hero primary CTA URL', 'restwell-retreats' ),
			'prop_hero_cta_secondary_text' => __( 'Hero secondary CTA label (optional)', 'restwell-retreats' ),
			'prop_hero_cta_secondary_url'  => __( 'Hero secondary CTA URL (optional)', 'restwell-retreats' ),
			'prop_hero_cta_promise'        => __( 'Hero promise line (optional)', 'restwell-retreats' ),
		),
		'Your home for the week' => array(
			'prop_home_label'     => __( 'Section label (eyebrow)', 'restwell-retreats' ),
			'prop_home_heading'   => __( 'Section heading (h2)', 'restwell-retreats' ),
			'prop_home_1_title'   => __( 'Card 1 title', 'restwell-retreats' ),
			'prop_home_1_body'    => __( 'Card 1 body', 'restwell-retreats' ),
			'prop_home_2_title'   => __( 'Card 2 title', 'restwell-retreats' ),
			'prop_home_2_body'    => __( 'Card 2 body', 'restwell-retreats' ),
			'prop_home_3_title'   => __( 'Card 3 title', 'restwell-retreats' ),
			'prop_home_3_body'    => __( 'Card 3 body', 'restwell-retreats' ),
		),
		'Designed for dignity' => array(
			'prop_dignity_label'   => __( 'Section label (eyebrow)', 'restwell-retreats' ),
			'prop_dignity_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'prop_dignity_body'    => __( 'Body (paragraphs)', 'restwell-retreats' ),
			'prop_dignity_image_id'=> __( 'Image (attachment ID)', 'restwell-retreats' ),
		),
		'Feature grid (8 items)' => array(
			'prop_features_label'   => __( 'Section label (eyebrow)', 'restwell-retreats' ),
			'prop_features_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'prop_feature_1' => __( 'Feature 1 label', 'restwell-retreats' ),
			'prop_feature_1_desc' => __( 'Feature 1 description', 'restwell-retreats' ),
			'prop_feature_2' => __( 'Feature 2 label', 'restwell-retreats' ),
			'prop_feature_2_desc' => __( 'Feature 2 description', 'restwell-retreats' ),
			'prop_feature_3' => __( 'Feature 3 label', 'restwell-retreats' ),
			'prop_feature_3_desc' => __( 'Feature 3 description', 'restwell-retreats' ),
			'prop_feature_4' => __( 'Feature 4 label', 'restwell-retreats' ),
			'prop_feature_4_desc' => __( 'Feature 4 description', 'restwell-retreats' ),
			'prop_feature_5' => __( 'Feature 5 label', 'restwell-retreats' ),
			'prop_feature_5_desc' => __( 'Feature 5 description', 'restwell-retreats' ),
			'prop_feature_6' => __( 'Feature 6 label', 'restwell-retreats' ),
			'prop_feature_6_desc' => __( 'Feature 6 description', 'restwell-retreats' ),
			'prop_feature_7' => __( 'Feature 7 label', 'restwell-retreats' ),
			'prop_feature_7_desc' => __( 'Feature 7 description', 'restwell-retreats' ),
			'prop_feature_8' => __( 'Feature 8 label', 'restwell-retreats' ),
			'prop_feature_8_desc' => __( 'Feature 8 description', 'restwell-retreats' ),
		),
		'Overview' => array(
			'prop_overview_heading' => __( 'Overview heading (h2) – fallback for dignity', 'restwell-retreats' ),
			'prop_overview_body'   => __( 'Overview body (paragraphs)', 'restwell-retreats' ),
		),
		'Accessibility' => array(
			'prop_acc_label'   => __( 'Section label', 'restwell-retreats' ),
			'prop_acc_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'prop_acc_intro'   => __( 'Intro paragraph', 'restwell-retreats' ),
			'prop_acc_confirmed' => __( 'Confirmed features (one per line)', 'restwell-retreats' ),
			'prop_acc_tbc'     => __( 'To be confirmed (one per line)', 'restwell-retreats' ),
		),
		'Comparison (why not a hotel?)' => array(
			'prop_comparison_label'         => __( 'Section label (eyebrow)', 'restwell-retreats' ),
			'prop_comparison_heading'       => __( 'Section heading (h2)', 'restwell-retreats' ),
			'prop_comparison_intro'         => __( 'Intro paragraph', 'restwell-retreats' ),
			'prop_comparison_left_heading'  => __( 'Left column heading', 'restwell-retreats' ),
			'prop_comparison_right_heading' => __( 'Right column heading', 'restwell-retreats' ),
			'prop_comparison_left_1'         => __( 'Left bullet 1', 'restwell-retreats' ),
			'prop_comparison_left_2'         => __( 'Left bullet 2', 'restwell-retreats' ),
			'prop_comparison_left_3'         => __( 'Left bullet 3', 'restwell-retreats' ),
			'prop_comparison_left_4'         => __( 'Left bullet 4', 'restwell-retreats' ),
			'prop_comparison_right_1'        => __( 'Right bullet 1', 'restwell-retreats' ),
			'prop_comparison_right_2'        => __( 'Right bullet 2', 'restwell-retreats' ),
			'prop_comparison_right_3'        => __( 'Right bullet 3', 'restwell-retreats' ),
			'prop_comparison_right_4'        => __( 'Right bullet 4', 'restwell-retreats' ),
		),
		'Gallery / See the space' => array(
			'prop_gallery_label'  => __( 'Section label', 'restwell-retreats' ),
			'prop_gallery_heading'=> __( 'Section heading (h2)', 'restwell-retreats' ),
			'prop_gallery_1_image_id' => __( 'Gallery image 1 (attachment ID)', 'restwell-retreats' ),
			'prop_gallery_2_image_id' => __( 'Gallery image 2 (attachment ID)', 'restwell-retreats' ),
			'prop_gallery_3_image_id' => __( 'Gallery image 3 (attachment ID)', 'restwell-retreats' ),
			'prop_gallery_btn_1_label' => __( 'Button 1 label (e.g. See all photos)', 'restwell-retreats' ),
			'prop_gallery_btn_1_url'  => __( 'Button 1 URL', 'restwell-retreats' ),
			'prop_gallery_btn_2_label' => __( 'Button 2 label (e.g. Explore video)', 'restwell-retreats' ),
			'prop_gallery_btn_2_url'  => __( 'Button 2 URL', 'restwell-retreats' ),
			'prop_gallery_btn_3_label' => __( 'Button 3 label (e.g. Take 3D Tour)', 'restwell-retreats' ),
			'prop_gallery_btn_3_url'  => __( 'Button 3 URL', 'restwell-retreats' ),
		),
		'Practical details' => array(
			'prop_practical_label'  => __( 'Section label', 'restwell-retreats' ),
			'prop_practical_heading'=> __( 'Section heading (h2)', 'restwell-retreats' ),
			'prop_bedrooms_count'   => __( 'Bedrooms number (e.g. 5)', 'restwell-retreats' ),
			'prop_bedrooms'   => __( 'Bedrooms text (fallback)', 'restwell-retreats' ),
			'prop_bathrooms_count'  => __( 'Bathrooms number (e.g. 3)', 'restwell-retreats' ),
			'prop_bathroom'   => __( 'Bathroom text (fallback)', 'restwell-retreats' ),
			'prop_parking_label'    => __( 'Parking label (e.g. Parking)', 'restwell-retreats' ),
			'prop_parking'    => __( 'Parking text (fallback)', 'restwell-retreats' ),
			'prop_sleeps_value'     => __( 'Sleeps value (e.g. 9+)', 'restwell-retreats' ),
			'prop_sleeps_label'     => __( 'Sleeps label (e.g. Sleeps)', 'restwell-retreats' ),
			'prop_distances'  => __( 'Distances text (fallback)', 'restwell-retreats' ),
			'prop_confirm_details_url' => __( 'Confirm details / gallery button fallback URL', 'restwell-retreats' ),
		),
		'What\'s nearby' => array(
			'prop_nearby_label'    => __( 'Section label', 'restwell-retreats' ),
			'prop_nearby_heading'  => __( 'Section heading (h2)', 'restwell-retreats' ),
			'prop_nearby_1_title'    => __( 'Place 1 title', 'restwell-retreats' ),
			'prop_nearby_1_body'     => __( 'Place 1 body', 'restwell-retreats' ),
			'prop_nearby_1_acc'      => __( 'Place 1 accessibility note', 'restwell-retreats' ),
			'prop_nearby_1_distance' => __( 'Place 1 distance (e.g. Approx. 5 min walk)', 'restwell-retreats' ),
			'prop_nearby_1_filter'   => __( 'Place 1 filter: wheelchair-friendly, quieter, or practical', 'restwell-retreats' ),
			'prop_nearby_1_map_url'  => __( 'Place 1 Google Maps URL', 'restwell-retreats' ),
			'prop_nearby_2_title'    => __( 'Place 2 title', 'restwell-retreats' ),
			'prop_nearby_2_body'     => __( 'Place 2 body', 'restwell-retreats' ),
			'prop_nearby_2_acc'      => __( 'Place 2 accessibility note', 'restwell-retreats' ),
			'prop_nearby_2_distance' => __( 'Place 2 distance', 'restwell-retreats' ),
			'prop_nearby_2_filter'   => __( 'Place 2 filter', 'restwell-retreats' ),
			'prop_nearby_2_map_url'  => __( 'Place 2 Google Maps URL', 'restwell-retreats' ),
			'prop_nearby_3_title'    => __( 'Place 3 title', 'restwell-retreats' ),
			'prop_nearby_3_body'     => __( 'Place 3 body', 'restwell-retreats' ),
			'prop_nearby_3_acc'      => __( 'Place 3 accessibility note', 'restwell-retreats' ),
			'prop_nearby_3_distance' => __( 'Place 3 distance', 'restwell-retreats' ),
			'prop_nearby_3_filter'   => __( 'Place 3 filter', 'restwell-retreats' ),
			'prop_nearby_3_map_url'  => __( 'Place 3 Google Maps URL', 'restwell-retreats' ),
			'prop_nearby_4_title'    => __( 'Place 4 title', 'restwell-retreats' ),
			'prop_nearby_4_body'     => __( 'Place 4 body', 'restwell-retreats' ),
			'prop_nearby_4_acc'      => __( 'Place 4 accessibility note', 'restwell-retreats' ),
			'prop_nearby_4_distance' => __( 'Place 4 distance', 'restwell-retreats' ),
			'prop_nearby_4_filter'   => __( 'Place 4 filter', 'restwell-retreats' ),
			'prop_nearby_4_map_url'  => __( 'Place 4 Google Maps URL', 'restwell-retreats' ),
			'prop_nearby_5_title'    => __( 'Place 5 title (e.g. Medical)', 'restwell-retreats' ),
			'prop_nearby_5_body'     => __( 'Place 5 body', 'restwell-retreats' ),
			'prop_nearby_5_acc'      => __( 'Place 5 accessibility note', 'restwell-retreats' ),
			'prop_nearby_5_distance' => __( 'Place 5 distance', 'restwell-retreats' ),
			'prop_nearby_5_filter'   => __( 'Place 5 filter', 'restwell-retreats' ),
			'prop_nearby_5_map_url'  => __( 'Place 5 Google Maps URL', 'restwell-retreats' ),
			'prop_nearby_cta_label' => __( 'Sixth card CTA label (e.g. Questions about access?)', 'restwell-retreats' ),
			'prop_nearby_cta_url'   => __( 'Sixth card CTA URL', 'restwell-retreats' ),
		),
		'CTA' => array(
			'prop_cta_heading' => __( 'CTA heading (h2)', 'restwell-retreats' ),
			'prop_cta_body'    => __( 'CTA body', 'restwell-retreats' ),
			'prop_cta_btn'     => __( 'Button label', 'restwell-retreats' ),
			'prop_cta_url'     => __( 'Button URL', 'restwell-retreats' ),
			'prop_cta_promise' => __( 'CTA promise line (optional)', 'restwell-retreats' ),
		),
	);
}

/**
 * How It Works page.
 */
function restwell_get_how_it_works_field_definitions() {
	$included = array(
		'hiw_included_label'   => __( 'Section label', 'restwell-retreats' ),
		'hiw_included_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
		'hiw_included_intro'   => __( 'Section intro paragraph', 'restwell-retreats' ),
	);
	for ( $i = 1; $i <= 6; $i++ ) {
		$included[ "hiw_included_{$i}_title" ] = __( "Item $i title", 'restwell-retreats' );
		$included[ "hiw_included_{$i}_desc" ]  = __( "Item $i description (optional)", 'restwell-retreats' );
	}
	$faq = array(
		'hiw_faq_label'   => __( 'Section eyebrow label', 'restwell-retreats' ),
		'hiw_faq_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
		'hiw_faq_intro'   => __( 'Section intro paragraph', 'restwell-retreats' ),
	);
	for ( $i = 1; $i <= 3; $i++ ) {
		$faq[ "hiw_faq_{$i}_q" ] = __( "Question $i", 'restwell-retreats' );
		$faq[ "hiw_faq_{$i}_a" ] = __( "Answer $i", 'restwell-retreats' );
	}
	return array(
		'SEO' => array(
			'meta_title'       => __( 'SEO title (overrides page title in search results)', 'restwell-retreats' ),
			'meta_description' => __( 'Meta description', 'restwell-retreats' ),
			'og_image_id'      => __( 'Social share image', 'restwell-retreats' ),
		),
		'Header' => array(
			'hiw_hero_image_id' => __( 'Hero background image ID (optional)', 'restwell-retreats' ),
			'hiw_label'         => __( 'Hero eyebrow label (e.g. WHITSTABLE, KENT)', 'restwell-retreats' ),
			'hiw_heading'       => __( 'Page heading (h1)', 'restwell-retreats' ),
			'hiw_intro'         => __( 'Intro paragraph', 'restwell-retreats' ),
			'hiw_hero_cta_text'           => __( 'Hero primary CTA label (optional)', 'restwell-retreats' ),
			'hiw_hero_cta_url'            => __( 'Hero primary CTA URL (optional)', 'restwell-retreats' ),
			'hiw_hero_cta_secondary_text' => __( 'Hero secondary CTA label (optional)', 'restwell-retreats' ),
			'hiw_hero_cta_secondary_url'  => __( 'Hero secondary CTA URL (optional)', 'restwell-retreats' ),
			'hiw_hero_cta_promise'        => __( 'Hero promise line (optional)', 'restwell-retreats' ),
		),
		'Steps' => array(
			'hiw_steps_label'   => __( 'Steps section label (e.g. FOUR-STEP PROCESS)', 'restwell-retreats' ),
			'hiw_steps_heading' => __( 'Steps section heading (h2)', 'restwell-retreats' ),
			'hiw_steps_intro'   => __( 'Steps section intro paragraph', 'restwell-retreats' ),
			'hiw_step1_title' => __( 'Step 1 title', 'restwell-retreats' ),
			'hiw_step1_body'  => __( 'Step 1 body', 'restwell-retreats' ),
			'hiw_step2_title' => __( 'Step 2 title', 'restwell-retreats' ),
			'hiw_step2_body'  => __( 'Step 2 body', 'restwell-retreats' ),
			'hiw_step3_title' => __( 'Step 3 title', 'restwell-retreats' ),
			'hiw_step3_body'  => __( 'Step 3 body', 'restwell-retreats' ),
			'hiw_step4_title' => __( 'Step 4 title', 'restwell-retreats' ),
			'hiw_step4_body'  => __( 'Step 4 body', 'restwell-retreats' ),
		),
		'Your journey' => array(
			'hiw_journey_label'   => __( 'Section label (optional)', 'restwell-retreats' ),
			'hiw_journey_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'hiw_journey_1_title' => __( 'Journey step 1 title', 'restwell-retreats' ),
			'hiw_journey_1_body'  => __( 'Journey step 1 body (optional)', 'restwell-retreats' ),
			'hiw_journey_2_title' => __( 'Journey step 2 title', 'restwell-retreats' ),
			'hiw_journey_2_body'  => __( 'Journey step 2 body (optional)', 'restwell-retreats' ),
			'hiw_journey_3_title' => __( 'Journey step 3 title', 'restwell-retreats' ),
			'hiw_journey_3_body'  => __( 'Journey step 3 body (optional)', 'restwell-retreats' ),
			'hiw_journey_4_title' => __( 'Journey step 4 title', 'restwell-retreats' ),
			'hiw_journey_4_body'  => __( 'Journey step 4 body (optional)', 'restwell-retreats' ),
			'hiw_journey_5_title' => __( 'Journey step 5 title', 'restwell-retreats' ),
			'hiw_journey_5_body'  => __( 'Journey step 5 body (optional)', 'restwell-retreats' ),
			'hiw_journey_6_title' => __( 'Journey step 6 title', 'restwell-retreats' ),
			'hiw_journey_6_body'  => __( 'Journey step 6 body (optional)', 'restwell-retreats' ),
		),
		'Care support CTA band' => array(
			'hiw_care_cta_label'   => __( 'Band eyebrow label', 'restwell-retreats' ),
			'hiw_care_cta_heading' => __( 'Band heading', 'restwell-retreats' ),
			'hiw_care_cta_body'    => __( 'Band body (short)', 'restwell-retreats' ),
			'hiw_care_cta_btn'     => __( 'Button label', 'restwell-retreats' ),
			'hiw_care_cta_url'     => __( 'Button URL', 'restwell-retreats' ),
		),
		'What\'s included' => $included,
		'Bottom CTA' => array(
			'hiw_cta_label'          => __( 'CTA section eyebrow (optional)', 'restwell-retreats' ),
			'hiw_cta_heading'        => __( 'CTA heading (e.g. Ready to plan your break?)', 'restwell-retreats' ),
			'hiw_cta_body'           => __( 'CTA body paragraph', 'restwell-retreats' ),
			'hiw_cta_primary_label'  => __( 'Primary button label', 'restwell-retreats' ),
			'hiw_cta_primary_url'    => __( 'Primary button URL', 'restwell-retreats' ),
			'hiw_cta_secondary_label'=> __( 'Secondary button label', 'restwell-retreats' ),
			'hiw_cta_secondary_url'  => __( 'Secondary button URL', 'restwell-retreats' ),
			'hiw_cta_promise'        => __( 'CTA promise line (optional)', 'restwell-retreats' ),
		),
		'Common questions' => $faq,
	);
}

/**
 * Accessibility page.
 */
function restwell_get_accessibility_field_definitions() {
	return array(
		'SEO' => array(
			'meta_title'       => __( 'SEO title (overrides page title in search results)', 'restwell-retreats' ),
			'meta_description' => __( 'Meta description', 'restwell-retreats' ),
			'og_image_id'      => __( 'Social share image', 'restwell-retreats' ),
		),
		'Header' => array(
			'acc_hero_image_id' => __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ),
			'acc_label'         => __( 'Hero eyebrow label', 'restwell-retreats' ),
			'acc_heading'       => __( 'Page heading (h1)', 'restwell-retreats' ),
			'acc_intro'         => __( 'Intro paragraph', 'restwell-retreats' ),
		),
		'Property: room by room' => array(
			'acc_room_label'     => __( 'Room-by-room section label (optional)', 'restwell-retreats' ),
			'acc_room_heading'   => __( 'Section heading (h2)', 'restwell-retreats' ),
			'acc_arrival_heading'=> __( 'Arrival & entrance (h3)', 'restwell-retreats' ),
			'acc_arrival_body'   => __( 'Arrival body (bullets or paragraph)', 'restwell-retreats' ),
			'acc_inside_heading' => __( 'Inside the property (h3)', 'restwell-retreats' ),
			'acc_inside_body'    => __( 'Inside body', 'restwell-retreats' ),
			'acc_bedroom_heading'=> __( 'Bedrooms (h3)', 'restwell-retreats' ),
			'acc_bedroom_body'   => __( 'Bedrooms body', 'restwell-retreats' ),
			'acc_bathroom_heading'=> __( 'Bathroom (h3)', 'restwell-retreats' ),
			'acc_bathroom_body'  => __( 'Bathroom body', 'restwell-retreats' ),
			'acc_kitchen_heading'=> __( 'Kitchen (h3)', 'restwell-retreats' ),
			'acc_kitchen_body'   => __( 'Kitchen body', 'restwell-retreats' ),
			'acc_outdoor_heading'=> __( 'Outdoor spaces (h3)', 'restwell-retreats' ),
			'acc_outdoor_body'   => __( 'Outdoor body', 'restwell-retreats' ),
		),
		'The destination' => array(
			'acc_dest_label'   => __( 'Section label', 'restwell-retreats' ),
			'acc_dest_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'acc_dest_intro'   => __( 'Intro paragraph', 'restwell-retreats' ),
			'acc_dest_good_heading' => __( 'The good (h3)', 'restwell-retreats' ),
			'acc_dest_good_body'   => __( 'The good body', 'restwell-retreats' ),
			'acc_dest_challenge_heading' => __( 'The challenge (h3)', 'restwell-retreats' ),
			'acc_dest_challenge_body'   => __( 'The challenge body', 'restwell-retreats' ),
			'acc_dest_reality_heading' => __( 'The reality (h3)', 'restwell-retreats' ),
			'acc_dest_reality_body'   => __( 'The reality body', 'restwell-retreats' ),
		),
		'Contact CTA' => array(
			'acc_cta_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'acc_cta_body'   => __( 'Body paragraph', 'restwell-retreats' ),
			'acc_cta_btn'    => __( 'Button label', 'restwell-retreats' ),
			'acc_cta_url'    => __( 'Button URL', 'restwell-retreats' ),
		),
	);
}

/**
 * FAQ page. Pairs faq_1_q, faq_1_a ... faq_12_q, faq_12_a.
 */
function restwell_get_faq_field_definitions() {
	$faq_section = array();
	for ( $i = 1; $i <= 12; $i++ ) {
		$faq_section[ "faq_{$i}_q" ]   = __( "Question $i", 'restwell-retreats' );
		$faq_section[ "faq_{$i}_a" ]   = __( "Answer $i", 'restwell-retreats' );
		$faq_section[ "faq_{$i}_cat" ] = __( "Question $i category (about | booking | care | local)", 'restwell-retreats' );
	}
	return array(
		'SEO' => array(
			'meta_title'       => __( 'SEO title (overrides page title in search results)', 'restwell-retreats' ),
			'meta_description' => __( 'Meta description', 'restwell-retreats' ),
			'og_image_id'      => __( 'Social share image', 'restwell-retreats' ),
		),
		'Header' => array(
			'faq_hero_image_id' => __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ),
			'faq_label'         => __( 'Hero eyebrow label', 'restwell-retreats' ),
			'faq_heading'       => __( 'Page heading (h1)', 'restwell-retreats' ),
			'faq_intro'         => __( 'Intro paragraph', 'restwell-retreats' ),
			'faq_list_label'    => __( 'FAQ list section label (optional)', 'restwell-retreats' ),
			'faq_list_heading'  => __( 'FAQ list heading (h2)', 'restwell-retreats' ),
		),
		'FAQ items' => $faq_section,
		'CTA' => array(
			'faq_cta_label'  => __( 'CTA section label (optional)', 'restwell-retreats' ),
			'faq_cta_heading' => __( 'CTA heading (h2)', 'restwell-retreats' ),
			'faq_cta_body'   => __( 'CTA body', 'restwell-retreats' ),
			'faq_cta_btn'    => __( 'Button label', 'restwell-retreats' ),
			'faq_cta_url'    => __( 'Button URL', 'restwell-retreats' ),
		),
	);
}

/**
 * Resources / Funding & support page.
 */
function restwell_get_resources_field_definitions() {
	return array(
		'SEO' => array(
			'meta_title'       => __( 'SEO title (overrides page title in search results)', 'restwell-retreats' ),
			'meta_description' => __( 'Meta description', 'restwell-retreats' ),
			'og_image_id'      => __( 'Social share image', 'restwell-retreats' ),
		),
		'Header' => array(
			'res_hero_image_id' => __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ),
			'res_label'         => __( 'Hero eyebrow label', 'restwell-retreats' ),
			'res_heading'       => __( 'Page heading (h1)', 'restwell-retreats' ),
			'res_intro'         => __( 'Intro paragraph', 'restwell-retreats' ),
		),
		'How to fund' => array(
			'res_fund_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'res_fund_body'    => __( 'Body (HTML allowed: links, lists)', 'restwell-retreats' ),
		),
		'Grants and charities' => array(
			'res_grants_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'res_grants_body'    => __( 'Body (HTML allowed)', 'restwell-retreats' ),
		),
		'NHS CHC' => array(
			'res_chc_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'res_chc_body'    => __( 'Body (HTML allowed)', 'restwell-retreats' ),
		),
		'Complaints & appeals' => array(
			'res_complaints_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'res_complaints_body'    => __( 'Body (HTML allowed)', 'restwell-retreats' ),
		),
		'Key contacts' => array(
			'res_contacts_heading' => __( 'Section heading (h2)', 'restwell-retreats' ),
			'res_contacts_body'    => __( 'Table or list (HTML allowed)', 'restwell-retreats' ),
		),
		'CTA' => array(
			'res_cta_heading' => __( 'CTA heading (h2)', 'restwell-retreats' ),
			'res_cta_body'    => __( 'CTA body', 'restwell-retreats' ),
			'res_cta_btn'     => __( 'Button label', 'restwell-retreats' ),
			'res_cta_url'     => __( 'Button URL', 'restwell-retreats' ),
		),
	);
}

/**
 * Enquire / Contact page.
 */
function restwell_get_enquire_field_definitions() {
	return array(
		'SEO' => array(
			'meta_title'       => __( 'SEO title (overrides page title in search results)', 'restwell-retreats' ),
			'meta_description' => __( 'Meta description', 'restwell-retreats' ),
			'og_image_id'      => __( 'Social share image', 'restwell-retreats' ),
		),
		'Header' => array(
			'enq_hero_image_id' => __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ),
			'enq_label'         => __( 'Hero eyebrow label', 'restwell-retreats' ),
			'enq_heading'       => __( 'Page heading (h1)', 'restwell-retreats' ),
			'enq_intro'         => __( 'Intro paragraph', 'restwell-retreats' ),
		),
		'Form' => array(
			'enq_form_heading'       => __( 'Form heading (h2)', 'restwell-retreats' ),
			'enq_success_heading'    => __( 'Success message heading', 'restwell-retreats' ),
			'enq_success_body'       => __( 'Success message body (24hr callback)', 'restwell-retreats' ),
			'enq_success_urgent_body'=> __( 'Success message body when urgent', 'restwell-retreats' ),
		),
		'Sidebar' => array(
			'enq_contact_heading' => __( 'Direct contact heading', 'restwell-retreats' ),
			'enq_email'  => __( 'Email address', 'restwell-retreats' ),
			'enq_phone'  => __( 'Phone number', 'restwell-retreats' ),
			'enq_response_heading' => __( 'Response time heading', 'restwell-retreats' ),
			'enq_response_body'   => __( 'Response time body', 'restwell-retreats' ),
			'enq_no_pressure_heading' => __( 'No pressure box heading', 'restwell-retreats' ),
			'enq_no_pressure_body'   => __( 'No pressure box body', 'restwell-retreats' ),
		),
	);
}
