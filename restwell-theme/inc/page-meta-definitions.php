<?php
/**
 * Page content field definitions by template.
 * Used by meta-fields.php to show the right fields when editing a page.
 *
 * Each field is an array: [ 'label' => string, 'type' => string ]
 * Valid types: text | textarea | image | media | number
 *   image  – media library picker (images only)
 *   media  – media library picker (images and video, e.g. hero backgrounds)
 *   number – numeric text input
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a field definition array.
 *
 * @param string $label Human-readable label shown in the metabox.
 * @param string $type  Field type: text | textarea | image | media | number.
 * @return array{label:string,type:string}
 */
function restwell_field( string $label, string $type = 'text' ): array {
	return array(
		'label' => $label,
		'type'  => $type,
	);
}

/**
 * Get field definitions for a page.
 *
 * @param WP_Post|null $post Page post or null.
 * @return array<string, array<string, array{label:string,type:string}>>
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
		'template-who-its-for.php' => 'restwell_get_who_its_for_field_definitions',
		'template-whitstable-guide.php' => 'restwell_get_whitstable_guide_field_definitions',
		'template-faq.php'        => 'restwell_get_faq_field_definitions',
		'template-enquire.php'    => 'restwell_get_enquire_field_definitions',
		'template-resources.php'           => 'restwell_get_resources_field_definitions',
		'template-privacy-policy.php'      => 'restwell_get_legal_policy_field_definitions',
		'template-terms-and-conditions.php' => 'restwell_get_legal_policy_field_definitions',
		'template-accessibility-policy.php' => 'restwell_get_legal_policy_field_definitions',
	);
	if ( isset( $map[ $template ] ) && is_callable( $map[ $template ] ) ) {
		return call_user_func( $map[ $template ] );
	}
	// Default template: optional hero background (used by page.php and index.php).
	return array(
		'Hero' => array(
			'page_hero_image_id' => restwell_field( __( 'Hero background (image or video, optional)', 'restwell-retreats' ), 'media' ),
		),
	);
}

/**
 * Front page definitions.
 */
function restwell_get_front_page_field_definitions() {
	return array(
		'Hero' => array(
			'hero_eyebrow'            => restwell_field( __( 'Hero eyebrow (short context above the headline, e.g. offer + place; avoid repeating the site name)', 'restwell-retreats' ) ),
			'hero_heading'            => restwell_field( __( 'Hero heading (h1). Aim for five words or fewer; use Enter only if a second line is essential', 'restwell-retreats' ) ),
			'hero_subheading'         => restwell_field( __( 'Hero intro: one short sentence (shown in the hero under the headline)', 'restwell-retreats' ) ),
			'hero_spec_heading'       => restwell_field( __( 'Optional. Equipment or promise line in the strip under the hero only when filled (hidden when empty)', 'restwell-retreats' ), 'textarea' ),
			'hero_media_id'           => restwell_field( __( 'Hero background (image or video)', 'restwell-retreats' ), 'media' ),
			'hero_cta_primary_label'  => restwell_field( __( 'Hero primary button label', 'restwell-retreats' ) ),
			'hero_cta_primary_url'    => restwell_field( __( 'Hero primary button URL', 'restwell-retreats' ) ),
			'hero_cta_secondary_label'=> restwell_field( __( 'Hero secondary button label', 'restwell-retreats' ) ),
			'hero_cta_secondary_url'  => restwell_field( __( 'Hero secondary button URL', 'restwell-retreats' ) ),
			'hero_cta_reassurance'    => restwell_field( __( 'Optional line under hero buttons (response time & no obligation). Empty = use theme default; clear the field and save to hide.', 'restwell-retreats' ), 'textarea' ),
			'hero_cta_promise'        => restwell_field( __( 'Optional. Not shown in the hero (trust line lives on the bottom CTA). You can leave this empty.', 'restwell-retreats' ) ),
		),
		'Partners strip (under hero)' => array(
			'home_partners_label'    => restwell_field( __( 'Section label (optional)', 'restwell-retreats' ) ),
			'home_partners_heading'  => restwell_field( __( 'Section heading (h2). Clear and save empty to hide this strip.', 'restwell-retreats' ) ),
			'home_partners_intro'    => restwell_field( __( 'Short intro paragraph shown on the left of this strip', 'restwell-retreats' ), 'textarea' ),
			'home_partners_cta_text' => restwell_field( __( 'Journey button label', 'restwell-retreats' ) ),
			'home_partners_cta_url'  => restwell_field( __( 'Journey button URL (e.g. /how-it-works/)', 'restwell-retreats' ) ),
			'home_partner_1_name'    => restwell_field( __( 'Partner 1 name', 'restwell-retreats' ) ),
			'home_partner_1_url'     => restwell_field( __( 'Partner 1 URL', 'restwell-retreats' ) ),
			'home_partner_1_logo_id' => restwell_field( __( 'Partner 1 logo image (attachment ID)', 'restwell-retreats' ), 'image' ),
			'home_partner_1_blurb'   => restwell_field( __( 'Partner 1 hover blurb (short)', 'restwell-retreats' ) ),
			'home_partner_1_logo_scale' => restwell_field( __( 'Partner 1 logo scale (optional, default 1.75)', 'restwell-retreats' ), 'number' ),
			'home_partner_2_name'    => restwell_field( __( 'Partner 2 name', 'restwell-retreats' ) ),
			'home_partner_2_url'     => restwell_field( __( 'Partner 2 URL', 'restwell-retreats' ) ),
			'home_partner_2_logo_id' => restwell_field( __( 'Partner 2 logo image (attachment ID)', 'restwell-retreats' ), 'image' ),
			'home_partner_2_blurb'   => restwell_field( __( 'Partner 2 hover blurb (short)', 'restwell-retreats' ) ),
			'home_partner_2_logo_scale' => restwell_field( __( 'Partner 2 logo scale (optional, default 1.85)', 'restwell-retreats' ), 'number' ),
			'home_partner_3_name'    => restwell_field( __( 'Partner 3 name', 'restwell-retreats' ) ),
			'home_partner_3_url'     => restwell_field( __( 'Partner 3 URL', 'restwell-retreats' ) ),
			'home_partner_3_logo_id' => restwell_field( __( 'Partner 3 logo image (attachment ID)', 'restwell-retreats' ), 'image' ),
			'home_partner_3_blurb'   => restwell_field( __( 'Partner 3 hover blurb (short)', 'restwell-retreats' ) ),
			'home_partner_3_logo_scale' => restwell_field( __( 'Partner 3 logo scale (optional, default 1.7)', 'restwell-retreats' ), 'number' ),
			'home_partner_4_name'    => restwell_field( __( 'Partner 4 name', 'restwell-retreats' ) ),
			'home_partner_4_url'     => restwell_field( __( 'Partner 4 URL', 'restwell-retreats' ) ),
			'home_partner_4_logo_id' => restwell_field( __( 'Partner 4 logo image (attachment ID)', 'restwell-retreats' ), 'image' ),
			'home_partner_4_blurb'   => restwell_field( __( 'Partner 4 hover blurb (short)', 'restwell-retreats' ) ),
			'home_partner_4_logo_scale' => restwell_field( __( 'Partner 4 logo scale (optional, default 1.65)', 'restwell-retreats' ), 'number' ),
			'home_partner_5_name'    => restwell_field( __( 'Partner 5 name', 'restwell-retreats' ) ),
			'home_partner_5_url'     => restwell_field( __( 'Partner 5 URL', 'restwell-retreats' ) ),
			'home_partner_5_logo_id' => restwell_field( __( 'Partner 5 logo image (attachment ID)', 'restwell-retreats' ), 'image' ),
			'home_partner_5_blurb'   => restwell_field( __( 'Partner 5 hover blurb (short)', 'restwell-retreats' ) ),
			'home_partner_5_logo_scale' => restwell_field( __( 'Partner 5 logo scale (optional, default 1.6)', 'restwell-retreats' ), 'number' ),
		),
		'Area & funding (home teaser)' => array(
			'home_teaser_label'         => restwell_field( __( 'Section label (empty = hide band)', 'restwell-retreats' ) ),
			'home_teaser_area_title'    => restwell_field( __( 'Area column title', 'restwell-retreats' ) ),
			'home_teaser_area_body'     => restwell_field( __( 'Area column body', 'restwell-retreats' ), 'textarea' ),
			'home_teaser_funding_title' => restwell_field( __( 'Funding column title', 'restwell-retreats' ) ),
			'home_teaser_funding_body'  => restwell_field( __( 'Funding column body', 'restwell-retreats' ), 'textarea' ),
		),
		'What is Restwell?' => array(
			'what_restwell_label'   => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'what_restwell_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'highlights_heading'    => restwell_field( __( 'Property highlights heading (empty = hide row title)', 'restwell-retreats' ) ),
			'highlight_1_title'     => restwell_field( __( 'Highlight 1 title', 'restwell-retreats' ) ),
			'highlight_1_desc'      => restwell_field( __( 'Highlight 1 description', 'restwell-retreats' ), 'textarea' ),
			'highlight_2_title'     => restwell_field( __( 'Highlight 2 title', 'restwell-retreats' ) ),
			'highlight_2_desc'      => restwell_field( __( 'Highlight 2 description', 'restwell-retreats' ), 'textarea' ),
			'highlight_3_title'     => restwell_field( __( 'Highlight 3 title', 'restwell-retreats' ) ),
			'highlight_3_desc'      => restwell_field( __( 'Highlight 3 description', 'restwell-retreats' ), 'textarea' ),
			'intro_body'            => restwell_field( __( 'Intro body (paragraph)', 'restwell-retreats' ), 'textarea' ),
		),
		'Who it\'s for' => array(
			'who_label'        => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'who_heading'      => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'who_guest_title'  => restwell_field( __( 'Guest card title', 'restwell-retreats' ) ),
			'who_guest_body'   => restwell_field( __( 'Guest card body', 'restwell-retreats' ), 'textarea' ),
			'who_carer_title'  => restwell_field( __( 'Carer card title', 'restwell-retreats' ) ),
			'who_carer_body'   => restwell_field( __( 'Carer card body', 'restwell-retreats' ), 'textarea' ),
		),
		'Property snapshot' => array(
			'property_label'      => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'property_heading'    => restwell_field( __( 'Section heading (e.g. Our Whitstable home)', 'restwell-retreats' ) ),
			'property_body'       => restwell_field( __( 'Property body copy', 'restwell-retreats' ), 'textarea' ),
			'property_cta_label'  => restwell_field( __( 'CTA link label', 'restwell-retreats' ) ),
			'property_cta_url'    => restwell_field( __( 'CTA link URL', 'restwell-retreats' ) ),
			'property_image_id'   => restwell_field( __( 'Property image (attachment ID)', 'restwell-retreats' ), 'image' ),
		),
		'Why Restwell?' => array(
			'why_label'       => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'why_heading'     => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'why_item1_title' => restwell_field( __( 'Item 1 title', 'restwell-retreats' ) ),
			'why_item1_desc'  => restwell_field( __( 'Item 1 description', 'restwell-retreats' ), 'textarea' ),
			'why_item2_title' => restwell_field( __( 'Item 2 title', 'restwell-retreats' ) ),
			'why_item2_desc'  => restwell_field( __( 'Item 2 description', 'restwell-retreats' ), 'textarea' ),
			'why_item3_title' => restwell_field( __( 'Item 3 title', 'restwell-retreats' ) ),
			'why_item3_desc'  => restwell_field( __( 'Item 3 description', 'restwell-retreats' ), 'textarea' ),
			'why_item4_title' => restwell_field( __( 'Item 4 title', 'restwell-retreats' ) ),
			'why_item4_desc'  => restwell_field( __( 'Item 4 description', 'restwell-retreats' ), 'textarea' ),
		),
		'Homepage comparison (optional)' => array(
			'home_comparison_label'   => restwell_field( __( 'Section label (eyebrow)', 'restwell-retreats' ) ),
			'home_comparison_heading' => restwell_field( __( 'Section heading (h2). Clear and save empty to hide this block', 'restwell-retreats' ) ),
			'home_comparison_intro'   => restwell_field( __( 'Short intro under the heading', 'restwell-retreats' ), 'textarea' ),
			'home_comparison_row1_feature'   => restwell_field( __( 'Row 1: feature label', 'restwell-retreats' ) ),
			'home_comparison_row1_restwell'  => restwell_field( __( 'Row 1: Restwell', 'restwell-retreats' ) ),
			'home_comparison_row1_other'     => restwell_field( __( 'Row 1: hotel / care setting', 'restwell-retreats' ) ),
			'home_comparison_row2_feature'   => restwell_field( __( 'Row 2: feature label', 'restwell-retreats' ) ),
			'home_comparison_row2_restwell'  => restwell_field( __( 'Row 2: Restwell', 'restwell-retreats' ) ),
			'home_comparison_row2_other'     => restwell_field( __( 'Row 2: hotel / care setting', 'restwell-retreats' ) ),
			'home_comparison_row3_feature'   => restwell_field( __( 'Row 3: feature label', 'restwell-retreats' ) ),
			'home_comparison_row3_restwell'  => restwell_field( __( 'Row 3: Restwell', 'restwell-retreats' ) ),
			'home_comparison_row3_other'     => restwell_field( __( 'Row 3: hotel / care setting', 'restwell-retreats' ) ),
			'home_comparison_row4_feature'   => restwell_field( __( 'Row 4: feature label', 'restwell-retreats' ) ),
			'home_comparison_row4_restwell'  => restwell_field( __( 'Row 4: Restwell', 'restwell-retreats' ) ),
			'home_comparison_row4_other'     => restwell_field( __( 'Row 4: hotel / care setting', 'restwell-retreats' ) ),
		),
		'Homepage FAQ' => array(
			'home_faq_label'   => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'home_faq_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'home_faq_1_q'     => restwell_field( __( 'FAQ 1 question (optional override; pair with answer 1)', 'restwell-retreats' ) ),
			'home_faq_1_a'     => restwell_field( __( 'FAQ 1 answer', 'restwell-retreats' ), 'textarea' ),
			'home_faq_2_q'     => restwell_field( __( 'FAQ 2 question', 'restwell-retreats' ) ),
			'home_faq_2_a'     => restwell_field( __( 'FAQ 2 answer', 'restwell-retreats' ), 'textarea' ),
			'home_faq_3_q'     => restwell_field( __( 'FAQ 3 question', 'restwell-retreats' ) ),
			'home_faq_3_a'     => restwell_field( __( 'FAQ 3 answer', 'restwell-retreats' ), 'textarea' ),
			'home_faq_4_q'     => restwell_field( __( 'FAQ 4 question', 'restwell-retreats' ) ),
			'home_faq_4_a'     => restwell_field( __( 'FAQ 4 answer', 'restwell-retreats' ), 'textarea' ),
			'home_faq_5_q'     => restwell_field( __( 'FAQ 5 question', 'restwell-retreats' ) ),
			'home_faq_5_a'     => restwell_field( __( 'FAQ 5 answer', 'restwell-retreats' ), 'textarea' ),
			'home_faq_6_q'     => restwell_field( __( 'FAQ 6 question', 'restwell-retreats' ) ),
			'home_faq_6_a'     => restwell_field( __( 'FAQ 6 answer', 'restwell-retreats' ), 'textarea' ),
			'home_faq_7_q'     => restwell_field( __( 'FAQ 7 question', 'restwell-retreats' ) ),
			'home_faq_7_a'     => restwell_field( __( 'FAQ 7 answer', 'restwell-retreats' ), 'textarea' ),
		),
		'Trust / accreditations' => array(
			'trust_label'           => restwell_field( __( 'Section label (optional)', 'restwell-retreats' ) ),
			'trust_heading'         => restwell_field( __( 'Section heading (optional)', 'restwell-retreats' ) ),
			'trust_badge_image_id'  => restwell_field( __( 'Badge image (attachment ID, e.g. CQC)', 'restwell-retreats' ), 'image' ),
			'trust_line'            => restwell_field( __( 'Trust line: title · badge, split by middle dot (e.g. Care with Continuity of Care Services · CQC regulated)', 'restwell-retreats' ) ),
			'trust_partner_url'     => restwell_field( __( 'Care partner website URL (Continuity of Care Services)', 'restwell-retreats' ) ),
			'trust_cqc_profile_url' => restwell_field( __( 'CQC location profile URL (Continuity\'s inspection page)', 'restwell-retreats' ) ),
		),
		'Testimonials' => array(
			'testimonial_label'   => restwell_field( __( 'Section label (optional)', 'restwell-retreats' ) ),
			'testimonial_heading' => restwell_field( __( 'Section heading (e.g. What guests say)', 'restwell-retreats' ) ),
			'testimonial_1_quote' => restwell_field( __( 'Testimonial 1 quote', 'restwell-retreats' ), 'textarea' ),
			'testimonial_1_name'  => restwell_field( __( 'Testimonial 1 name', 'restwell-retreats' ) ),
			'testimonial_1_role'  => restwell_field( __( 'Testimonial 1 role/location (optional)', 'restwell-retreats' ) ),
			'testimonial_2_quote' => restwell_field( __( 'Testimonial 2 quote', 'restwell-retreats' ), 'textarea' ),
			'testimonial_2_name'  => restwell_field( __( 'Testimonial 2 name', 'restwell-retreats' ) ),
			'testimonial_2_role'  => restwell_field( __( 'Testimonial 2 role (optional)', 'restwell-retreats' ) ),
			'testimonial_3_quote' => restwell_field( __( 'Testimonial 3 quote', 'restwell-retreats' ), 'textarea' ),
			'testimonial_3_name'  => restwell_field( __( 'Testimonial 3 name', 'restwell-retreats' ) ),
			'testimonial_3_role'  => restwell_field( __( 'Testimonial 3 role (optional)', 'restwell-retreats' ) ),
			'testimonial_4_quote' => restwell_field( __( 'Testimonial 4 quote', 'restwell-retreats' ), 'textarea' ),
			'testimonial_4_name'  => restwell_field( __( 'Testimonial 4 name', 'restwell-retreats' ) ),
			'testimonial_4_role'  => restwell_field( __( 'Testimonial 4 role (optional)', 'restwell-retreats' ) ),
			'testimonial_5_quote' => restwell_field( __( 'Testimonial 5 quote', 'restwell-retreats' ), 'textarea' ),
			'testimonial_5_name'  => restwell_field( __( 'Testimonial 5 name', 'restwell-retreats' ) ),
			'testimonial_5_role'  => restwell_field( __( 'Testimonial 5 role (optional)', 'restwell-retreats' ) ),
		),
		'CTA section' => array(
			'cta_heading'         => restwell_field( __( 'CTA heading (h2)', 'restwell-retreats' ) ),
			'cta_body'            => restwell_field( __( 'CTA body copy', 'restwell-retreats' ), 'textarea' ),
			'cta_primary_label'   => restwell_field( __( 'CTA primary button label', 'restwell-retreats' ) ),
			'cta_primary_url'     => restwell_field( __( 'CTA primary button URL', 'restwell-retreats' ) ),
			'cta_secondary_label' => restwell_field( __( 'CTA secondary button label', 'restwell-retreats' ) ),
			'cta_secondary_url'   => restwell_field( __( 'CTA secondary button URL', 'restwell-retreats' ) ),
			'cta_promise'         => restwell_field( __( 'CTA promise line (optional)', 'restwell-retreats' ) ),
			'cta_image_id'        => restwell_field( __( 'CTA background image (attachment ID)', 'restwell-retreats' ), 'image' ),
		),
	);
}

/**
 * The Property page.
 */
function restwell_get_property_field_definitions() {
	return array(
		'Structured Data (Address)' => array(
			'prop_address_street'   => restwell_field( __( 'Street address (for VacationRental schema)', 'restwell-retreats' ) ),
			'prop_address_locality' => restwell_field( __( 'Town / city (for VacationRental schema)', 'restwell-retreats' ) ),
			'prop_address_region'   => restwell_field( __( 'County / region (for VacationRental schema)', 'restwell-retreats' ) ),
			'prop_address_postcode' => restwell_field( __( 'Postcode (for VacationRental schema)', 'restwell-retreats' ) ),
		),
		'Hero' => array(
			'prop_hero_label'              => restwell_field( __( 'Hero label (e.g. The Property)', 'restwell-retreats' ) ),
			'prop_hero_heading'            => restwell_field( __( 'Hero heading (h1)', 'restwell-retreats' ) ),
			'prop_hero_subtitle'           => restwell_field( __( 'Hero subtitle (under heading)', 'restwell-retreats' ) ),
			'prop_hero_image_id'           => restwell_field( __( 'Hero image (attachment ID)', 'restwell-retreats' ), 'media' ),
			'prop_hero_cta_text'           => restwell_field( __( 'Hero primary CTA label (e.g. Ask about your dates)', 'restwell-retreats' ) ),
			'prop_hero_cta_url'            => restwell_field( __( 'Hero primary CTA URL', 'restwell-retreats' ) ),
			'prop_hero_cta_secondary_text' => restwell_field( __( 'Hero secondary CTA label (optional)', 'restwell-retreats' ) ),
			'prop_hero_cta_secondary_url'  => restwell_field( __( 'Hero secondary CTA URL (optional)', 'restwell-retreats' ) ),
			'prop_hero_cta_promise'        => restwell_field( __( 'Hero promise line (optional)', 'restwell-retreats' ) ),
		),
		'Your home for the week' => array(
			'prop_home_label'   => restwell_field( __( 'Section label (eyebrow)', 'restwell-retreats' ) ),
			'prop_home_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'prop_home_1_title' => restwell_field( __( 'Card 1 title', 'restwell-retreats' ) ),
			'prop_home_1_body'  => restwell_field( __( 'Card 1 body', 'restwell-retreats' ), 'textarea' ),
			'prop_home_2_title' => restwell_field( __( 'Card 2 title', 'restwell-retreats' ) ),
			'prop_home_2_body'  => restwell_field( __( 'Card 2 body', 'restwell-retreats' ), 'textarea' ),
			'prop_home_3_title' => restwell_field( __( 'Card 3 title', 'restwell-retreats' ) ),
			'prop_home_3_body'  => restwell_field( __( 'Card 3 body', 'restwell-retreats' ), 'textarea' ),
		),
		'Designed for dignity' => array(
			'prop_dignity_label'    => restwell_field( __( 'Section label (eyebrow)', 'restwell-retreats' ) ),
			'prop_dignity_heading'  => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'prop_dignity_body'     => restwell_field( __( 'Body (paragraphs)', 'restwell-retreats' ), 'textarea' ),
			'prop_dignity_image_id' => restwell_field( __( 'Image (attachment ID)', 'restwell-retreats' ), 'image' ),
		),
		'Feature grid (8 items)' => array(
			'prop_features_label'   => restwell_field( __( 'Section label (eyebrow)', 'restwell-retreats' ) ),
			'prop_features_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'prop_feature_1'        => restwell_field( __( 'Feature 1 label', 'restwell-retreats' ) ),
			'prop_feature_1_desc'   => restwell_field( __( 'Feature 1 description', 'restwell-retreats' ), 'textarea' ),
			'prop_feature_2'        => restwell_field( __( 'Feature 2 label', 'restwell-retreats' ) ),
			'prop_feature_2_desc'   => restwell_field( __( 'Feature 2 description', 'restwell-retreats' ), 'textarea' ),
			'prop_feature_3'        => restwell_field( __( 'Feature 3 label', 'restwell-retreats' ) ),
			'prop_feature_3_desc'   => restwell_field( __( 'Feature 3 description', 'restwell-retreats' ), 'textarea' ),
			'prop_feature_4'        => restwell_field( __( 'Feature 4 label', 'restwell-retreats' ) ),
			'prop_feature_4_desc'   => restwell_field( __( 'Feature 4 description', 'restwell-retreats' ), 'textarea' ),
			'prop_feature_5'        => restwell_field( __( 'Feature 5 label', 'restwell-retreats' ) ),
			'prop_feature_5_desc'   => restwell_field( __( 'Feature 5 description', 'restwell-retreats' ), 'textarea' ),
			'prop_feature_6'        => restwell_field( __( 'Feature 6 label', 'restwell-retreats' ) ),
			'prop_feature_6_desc'   => restwell_field( __( 'Feature 6 description', 'restwell-retreats' ), 'textarea' ),
			'prop_feature_7'        => restwell_field( __( 'Feature 7 label', 'restwell-retreats' ) ),
			'prop_feature_7_desc'   => restwell_field( __( 'Feature 7 description', 'restwell-retreats' ), 'textarea' ),
			'prop_feature_8'        => restwell_field( __( 'Feature 8 label', 'restwell-retreats' ) ),
			'prop_feature_8_desc'   => restwell_field( __( 'Feature 8 description', 'restwell-retreats' ), 'textarea' ),
		),
		'Overview' => array(
			'prop_overview_heading' => restwell_field( __( 'Overview heading (h2) - fallback for dignity', 'restwell-retreats' ) ),
			'prop_overview_body'    => restwell_field( __( 'Overview body (paragraphs)', 'restwell-retreats' ), 'textarea' ),
		),
		'Accessibility' => array(
			'prop_acc_label'     => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'prop_acc_heading'   => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'prop_acc_intro'     => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'prop_acc_confirmed' => restwell_field( __( 'Confirmed features (one per line)', 'restwell-retreats' ), 'textarea' ),
			'prop_acc_tbc'       => restwell_field( __( 'To be confirmed (one per line)', 'restwell-retreats' ), 'textarea' ),
		),
		'Comparison (why not a hotel?)' => array(
			'prop_comparison_label'         => restwell_field( __( 'Section label (eyebrow)', 'restwell-retreats' ) ),
			'prop_comparison_heading'       => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'prop_comparison_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'prop_comparison_left_heading'  => restwell_field( __( 'Left column heading', 'restwell-retreats' ) ),
			'prop_comparison_right_heading' => restwell_field( __( 'Right column heading', 'restwell-retreats' ) ),
			'prop_comparison_left_1'        => restwell_field( __( 'Left bullet 1', 'restwell-retreats' ) ),
			'prop_comparison_left_2'        => restwell_field( __( 'Left bullet 2', 'restwell-retreats' ) ),
			'prop_comparison_left_3'        => restwell_field( __( 'Left bullet 3', 'restwell-retreats' ) ),
			'prop_comparison_left_4'        => restwell_field( __( 'Left bullet 4', 'restwell-retreats' ) ),
			'prop_comparison_right_1'       => restwell_field( __( 'Right bullet 1', 'restwell-retreats' ) ),
			'prop_comparison_right_2'       => restwell_field( __( 'Right bullet 2', 'restwell-retreats' ) ),
			'prop_comparison_right_3'       => restwell_field( __( 'Right bullet 3', 'restwell-retreats' ) ),
			'prop_comparison_right_4'       => restwell_field( __( 'Right bullet 4', 'restwell-retreats' ) ),
		),
		'Gallery / See the space' => array(
			'prop_gallery_label'       => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'prop_gallery_heading'     => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'prop_gallery_1_image_id'  => restwell_field( __( 'Gallery image 1 (attachment ID)', 'restwell-retreats' ), 'image' ),
			'prop_gallery_2_image_id'  => restwell_field( __( 'Gallery image 2 (attachment ID)', 'restwell-retreats' ), 'image' ),
			'prop_gallery_3_image_id'  => restwell_field( __( 'Gallery image 3 (attachment ID)', 'restwell-retreats' ), 'image' ),
			'prop_gallery_btn_1_label' => restwell_field( __( 'Button 1 label (e.g. Ask about your dates, or See all photos)', 'restwell-retreats' ) ),
			'prop_gallery_btn_1_url'   => restwell_field( __( 'Button 1 URL', 'restwell-retreats' ) ),
			'prop_gallery_btn_2_label' => restwell_field( __( 'Button 2 label (e.g. Explore video)', 'restwell-retreats' ) ),
			'prop_gallery_btn_2_url'   => restwell_field( __( 'Button 2 URL', 'restwell-retreats' ) ),
			'prop_gallery_btn_3_label' => restwell_field( __( 'Button 3 label (e.g. Take 3D Tour)', 'restwell-retreats' ) ),
			'prop_gallery_btn_3_url'   => restwell_field( __( 'Button 3 URL', 'restwell-retreats' ) ),
		),
		'Practical details' => array(
			'prop_practical_label'     => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'prop_practical_heading'   => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'prop_bedrooms_count'      => restwell_field( __( 'Bedrooms number (set only if verified)', 'restwell-retreats' ), 'number' ),
			'prop_bedrooms'            => restwell_field( __( 'Bedrooms text (fallback)', 'restwell-retreats' ) ),
			'prop_bathrooms_count'     => restwell_field( __( 'Bathrooms number (set only if verified)', 'restwell-retreats' ), 'number' ),
			'prop_bathroom'            => restwell_field( __( 'Bathroom text (fallback)', 'restwell-retreats' ) ),
			'prop_parking_label'       => restwell_field( __( 'Parking label (e.g. Parking)', 'restwell-retreats' ) ),
			'prop_parking'             => restwell_field( __( 'Parking text (fallback)', 'restwell-retreats' ) ),
			'prop_sleeps_value'        => restwell_field( __( 'Sleeps value (set only if verified)', 'restwell-retreats' ), 'number' ),
			'prop_sleeps_label'        => restwell_field( __( 'Sleeps label (e.g. Sleeps)', 'restwell-retreats' ) ),
			'prop_distances'           => restwell_field( __( 'Distances text (fallback)', 'restwell-retreats' ) ),
			'prop_confirm_details_url' => restwell_field( __( 'Confirm details / gallery button fallback URL', 'restwell-retreats' ) ),
		),
		'What\'s nearby' => array(
			'prop_nearby_label'      => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'prop_nearby_heading'    => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'prop_nearby_1_title'    => restwell_field( __( 'Place 1 title', 'restwell-retreats' ) ),
			'prop_nearby_1_body'     => restwell_field( __( 'Place 1 body', 'restwell-retreats' ), 'textarea' ),
			'prop_nearby_1_acc'      => restwell_field( __( 'Place 1 accessibility note', 'restwell-retreats' ) ),
			'prop_nearby_1_distance' => restwell_field( __( 'Place 1 distance (e.g. Approx. 5 min walk)', 'restwell-retreats' ) ),
			'prop_nearby_1_filter'   => restwell_field( __( 'Place 1 filter: wheelchair-friendly, quieter, or practical', 'restwell-retreats' ) ),
			'prop_nearby_1_map_url'  => restwell_field( __( 'Place 1 Google Maps URL', 'restwell-retreats' ) ),
			'prop_nearby_2_title'    => restwell_field( __( 'Place 2 title', 'restwell-retreats' ) ),
			'prop_nearby_2_body'     => restwell_field( __( 'Place 2 body', 'restwell-retreats' ), 'textarea' ),
			'prop_nearby_2_acc'      => restwell_field( __( 'Place 2 accessibility note', 'restwell-retreats' ) ),
			'prop_nearby_2_distance' => restwell_field( __( 'Place 2 distance', 'restwell-retreats' ) ),
			'prop_nearby_2_filter'   => restwell_field( __( 'Place 2 filter', 'restwell-retreats' ) ),
			'prop_nearby_2_map_url'  => restwell_field( __( 'Place 2 Google Maps URL', 'restwell-retreats' ) ),
			'prop_nearby_3_title'    => restwell_field( __( 'Place 3 title', 'restwell-retreats' ) ),
			'prop_nearby_3_body'     => restwell_field( __( 'Place 3 body', 'restwell-retreats' ), 'textarea' ),
			'prop_nearby_3_acc'      => restwell_field( __( 'Place 3 accessibility note', 'restwell-retreats' ) ),
			'prop_nearby_3_distance' => restwell_field( __( 'Place 3 distance', 'restwell-retreats' ) ),
			'prop_nearby_3_filter'   => restwell_field( __( 'Place 3 filter', 'restwell-retreats' ) ),
			'prop_nearby_3_map_url'  => restwell_field( __( 'Place 3 Google Maps URL', 'restwell-retreats' ) ),
			'prop_nearby_4_title'    => restwell_field( __( 'Place 4 title', 'restwell-retreats' ) ),
			'prop_nearby_4_body'     => restwell_field( __( 'Place 4 body', 'restwell-retreats' ), 'textarea' ),
			'prop_nearby_4_acc'      => restwell_field( __( 'Place 4 accessibility note', 'restwell-retreats' ) ),
			'prop_nearby_4_distance' => restwell_field( __( 'Place 4 distance', 'restwell-retreats' ) ),
			'prop_nearby_4_filter'   => restwell_field( __( 'Place 4 filter', 'restwell-retreats' ) ),
			'prop_nearby_4_map_url'  => restwell_field( __( 'Place 4 Google Maps URL', 'restwell-retreats' ) ),
			'prop_nearby_5_title'    => restwell_field( __( 'Place 5 title (e.g. Supermarkets)', 'restwell-retreats' ) ),
			'prop_nearby_5_body'     => restwell_field( __( 'Place 5 body', 'restwell-retreats' ), 'textarea' ),
			'prop_nearby_5_acc'      => restwell_field( __( 'Place 5 accessibility note', 'restwell-retreats' ) ),
			'prop_nearby_5_distance' => restwell_field( __( 'Place 5 distance', 'restwell-retreats' ) ),
			'prop_nearby_5_filter'   => restwell_field( __( 'Place 5 filter', 'restwell-retreats' ) ),
			'prop_nearby_5_map_url'  => restwell_field( __( 'Place 5 Google Maps URL', 'restwell-retreats' ) ),
			'prop_nearby_6_title'    => restwell_field( __( 'Place 6 title (e.g. Local Pharmacies)', 'restwell-retreats' ) ),
			'prop_nearby_6_body'     => restwell_field( __( 'Place 6 body', 'restwell-retreats' ), 'textarea' ),
			'prop_nearby_6_acc'      => restwell_field( __( 'Place 6 accessibility note', 'restwell-retreats' ) ),
			'prop_nearby_6_distance' => restwell_field( __( 'Place 6 distance', 'restwell-retreats' ) ),
			'prop_nearby_6_filter'   => restwell_field( __( 'Place 6 filter', 'restwell-retreats' ) ),
			'prop_nearby_6_map_url'  => restwell_field( __( 'Place 6 Google Maps URL', 'restwell-retreats' ) ),
			'prop_nearby_7_title'    => restwell_field( __( 'Place 7 title (e.g. Getting Around)', 'restwell-retreats' ) ),
			'prop_nearby_7_body'     => restwell_field( __( 'Place 7 body', 'restwell-retreats' ), 'textarea' ),
			'prop_nearby_7_acc'      => restwell_field( __( 'Place 7 accessibility note', 'restwell-retreats' ) ),
			'prop_nearby_7_distance' => restwell_field( __( 'Place 7 distance', 'restwell-retreats' ) ),
			'prop_nearby_7_filter'   => restwell_field( __( 'Place 7 filter', 'restwell-retreats' ) ),
			'prop_nearby_7_map_url'  => restwell_field( __( 'Place 7 Google Maps URL', 'restwell-retreats' ) ),
			'prop_nearby_8_title'    => restwell_field( __( 'Place 8 title (e.g. Medical & Emergency)', 'restwell-retreats' ) ),
			'prop_nearby_8_body'     => restwell_field( __( 'Place 8 body', 'restwell-retreats' ), 'textarea' ),
			'prop_nearby_8_acc'      => restwell_field( __( 'Place 8 accessibility note', 'restwell-retreats' ) ),
			'prop_nearby_8_distance' => restwell_field( __( 'Place 8 distance', 'restwell-retreats' ) ),
			'prop_nearby_8_filter'   => restwell_field( __( 'Place 8 filter', 'restwell-retreats' ) ),
			'prop_nearby_8_map_url'  => restwell_field( __( 'Place 8 Google Maps URL', 'restwell-retreats' ) ),
			'prop_nearby_cta_label'  => restwell_field( __( 'Ninth card CTA label (e.g. Questions about access?)', 'restwell-retreats' ) ),
			'prop_nearby_cta_url'    => restwell_field( __( 'Ninth card CTA URL', 'restwell-retreats' ) ),
		),
		'CTA' => array(
			'prop_cta_heading' => restwell_field( __( 'CTA heading (h2)', 'restwell-retreats' ) ),
			'prop_cta_body'    => restwell_field( __( 'CTA body', 'restwell-retreats' ), 'textarea' ),
			'prop_cta_btn'     => restwell_field( __( 'Button label', 'restwell-retreats' ) ),
			'prop_cta_url'     => restwell_field( __( 'Button URL', 'restwell-retreats' ) ),
			'prop_cta_promise' => restwell_field( __( 'CTA promise line (optional)', 'restwell-retreats' ) ),
		),
	);
}

/**
 * How It Works page.
 */
function restwell_get_how_it_works_field_definitions() {
	$included = array(
		'hiw_included_label'   => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
		'hiw_included_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
		'hiw_included_intro'   => restwell_field( __( 'Section intro paragraph', 'restwell-retreats' ), 'textarea' ),
	);
	for ( $i = 1; $i <= 6; $i++ ) {
		$included[ "hiw_included_{$i}_title" ] = restwell_field( __( "Item $i title", 'restwell-retreats' ) );
		$included[ "hiw_included_{$i}_desc" ]  = restwell_field( __( "Item $i description (optional)", 'restwell-retreats' ), 'textarea' );
	}
	$faq = array(
		'hiw_faq_label'   => restwell_field( __( 'Section eyebrow label', 'restwell-retreats' ) ),
		'hiw_faq_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
		'hiw_faq_intro'   => restwell_field( __( 'Section intro paragraph', 'restwell-retreats' ), 'textarea' ),
	);
	for ( $i = 1; $i <= 3; $i++ ) {
		$faq[ "hiw_faq_{$i}_q" ] = restwell_field( __( "Question $i", 'restwell-retreats' ) );
		$faq[ "hiw_faq_{$i}_a" ] = restwell_field( __( "Answer $i", 'restwell-retreats' ), 'textarea' );
	}
	return array(
		'Header' => array(
			'hiw_hero_image_id'           => restwell_field( __( 'Hero background image ID (optional)', 'restwell-retreats' ), 'media' ),
			'hiw_label'                   => restwell_field( __( 'Hero eyebrow label (e.g. WHITSTABLE, KENT)', 'restwell-retreats' ) ),
			'hiw_heading'                 => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'hiw_intro'                   => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'hiw_hero_cta_text'           => restwell_field( __( 'Hero primary CTA label (optional)', 'restwell-retreats' ) ),
			'hiw_hero_cta_url'            => restwell_field( __( 'Hero primary CTA URL (optional)', 'restwell-retreats' ) ),
			'hiw_hero_cta_secondary_text' => restwell_field( __( 'Hero secondary CTA label (optional)', 'restwell-retreats' ) ),
			'hiw_hero_cta_secondary_url'  => restwell_field( __( 'Hero secondary CTA URL (optional)', 'restwell-retreats' ) ),
			'hiw_hero_cta_promise'        => restwell_field( __( 'Hero promise line (optional)', 'restwell-retreats' ) ),
		),
		'Steps' => array(
			'hiw_steps_label'   => restwell_field( __( 'Steps section label (e.g. FOUR-STEP PROCESS)', 'restwell-retreats' ) ),
			'hiw_steps_heading' => restwell_field( __( 'Steps section heading (h2)', 'restwell-retreats' ) ),
			'hiw_steps_intro'   => restwell_field( __( 'Steps section intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'hiw_step1_title'   => restwell_field( __( 'Step 1 title', 'restwell-retreats' ) ),
			'hiw_step1_body'    => restwell_field( __( 'Step 1 body', 'restwell-retreats' ), 'textarea' ),
			'hiw_step2_title'   => restwell_field( __( 'Step 2 title', 'restwell-retreats' ) ),
			'hiw_step2_body'    => restwell_field( __( 'Step 2 body', 'restwell-retreats' ), 'textarea' ),
			'hiw_step3_title'   => restwell_field( __( 'Step 3 title', 'restwell-retreats' ) ),
			'hiw_step3_body'    => restwell_field( __( 'Step 3 body', 'restwell-retreats' ), 'textarea' ),
			'hiw_step4_title'   => restwell_field( __( 'Step 4 title', 'restwell-retreats' ) ),
			'hiw_step4_body'    => restwell_field( __( 'Step 4 body', 'restwell-retreats' ), 'textarea' ),
		),
		'Care support CTA band' => array(
			'hiw_care_cta_label'   => restwell_field( __( 'Band eyebrow label', 'restwell-retreats' ) ),
			'hiw_care_cta_heading' => restwell_field( __( 'Band heading', 'restwell-retreats' ) ),
			'hiw_care_cta_body'    => restwell_field( __( 'Band body (short)', 'restwell-retreats' ), 'textarea' ),
			'hiw_care_cta_btn'     => restwell_field( __( 'Button label', 'restwell-retreats' ) ),
			'hiw_care_cta_url'     => restwell_field( __( 'Button URL', 'restwell-retreats' ) ),
		),
		'What\'s included' => $included,
		'Bottom CTA' => array(
			'hiw_cta_label'           => restwell_field( __( 'CTA section eyebrow (optional)', 'restwell-retreats' ) ),
			'hiw_cta_heading'         => restwell_field( __( 'CTA heading (e.g. Ready to plan your break?)', 'restwell-retreats' ) ),
			'hiw_cta_body'            => restwell_field( __( 'CTA body paragraph', 'restwell-retreats' ), 'textarea' ),
			'hiw_cta_primary_label'   => restwell_field( __( 'Primary button label', 'restwell-retreats' ) ),
			'hiw_cta_primary_url'     => restwell_field( __( 'Primary button URL', 'restwell-retreats' ) ),
			'hiw_cta_secondary_label' => restwell_field( __( 'Secondary button label', 'restwell-retreats' ) ),
			'hiw_cta_secondary_url'   => restwell_field( __( 'Secondary button URL', 'restwell-retreats' ) ),
			'hiw_cta_promise'         => restwell_field( __( 'CTA promise line (optional)', 'restwell-retreats' ) ),
		),
		'Common questions' => $faq,
	);
}

/**
 * Accessibility page.
 */
function restwell_get_accessibility_field_definitions() {
	return array(
		'Header' => array(
			'acc_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'acc_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'acc_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'acc_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'Property: room by room' => array(
			'acc_room_label'      => restwell_field( __( 'Room-by-room section label (optional)', 'restwell-retreats' ) ),
			'acc_room_heading'    => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'acc_arrival_heading' => restwell_field( __( 'Arrival & entrance (h3)', 'restwell-retreats' ) ),
			'acc_arrival_body'    => restwell_field( __( 'Arrival body (bullets or paragraph)', 'restwell-retreats' ), 'textarea' ),
			'acc_inside_heading'  => restwell_field( __( 'Inside the property (h3)', 'restwell-retreats' ) ),
			'acc_inside_body'     => restwell_field( __( 'Inside body', 'restwell-retreats' ), 'textarea' ),
			'acc_bedroom_heading' => restwell_field( __( 'Bedrooms (h3)', 'restwell-retreats' ) ),
			'acc_bedroom_body'    => restwell_field( __( 'Bedrooms body', 'restwell-retreats' ), 'textarea' ),
			'acc_bathroom_heading'=> restwell_field( __( 'Bathroom (h3)', 'restwell-retreats' ) ),
			'acc_bathroom_body'   => restwell_field( __( 'Bathroom body', 'restwell-retreats' ), 'textarea' ),
			'acc_kitchen_heading' => restwell_field( __( 'Kitchen (h3)', 'restwell-retreats' ) ),
			'acc_kitchen_body'    => restwell_field( __( 'Kitchen body', 'restwell-retreats' ), 'textarea' ),
			'acc_outdoor_heading' => restwell_field( __( 'Outdoor spaces (h3)', 'restwell-retreats' ) ),
			'acc_outdoor_body'    => restwell_field( __( 'Outdoor body', 'restwell-retreats' ), 'textarea' ),
		),
		'The destination' => array(
			'acc_dest_label'             => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'acc_dest_heading'           => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'acc_dest_intro'             => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'acc_dest_good_heading'      => restwell_field( __( 'The good (h3)', 'restwell-retreats' ) ),
			'acc_dest_good_body'         => restwell_field( __( 'The good body', 'restwell-retreats' ), 'textarea' ),
			'acc_dest_challenge_heading' => restwell_field( __( 'The challenge (h3)', 'restwell-retreats' ) ),
			'acc_dest_challenge_body'    => restwell_field( __( 'The challenge body', 'restwell-retreats' ), 'textarea' ),
			'acc_dest_reality_heading'   => restwell_field( __( 'The reality (h3)', 'restwell-retreats' ) ),
			'acc_dest_reality_body'      => restwell_field( __( 'The reality body', 'restwell-retreats' ), 'textarea' ),
		),
		'Contact CTA' => array(
			'acc_cta_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'acc_cta_body'    => restwell_field( __( 'Body paragraph', 'restwell-retreats' ), 'textarea' ),
			'acc_cta_btn'     => restwell_field( __( 'Button label', 'restwell-retreats' ) ),
			'acc_cta_url'     => restwell_field( __( 'Button URL', 'restwell-retreats' ) ),
		),
	);
}

/**
 * FAQ page. Pairs faq_1_q, faq_1_a ... faq_14_q, faq_14_a.
 * Categories: about | booking | care | local | funding
 */
function restwell_get_faq_field_definitions() {
	$faq_section = array();
	for ( $i = 1; $i <= 14; $i++ ) {
		$faq_section[ "faq_{$i}_q" ]   = restwell_field( __( "Question $i", 'restwell-retreats' ) );
		$faq_section[ "faq_{$i}_a" ]   = restwell_field( __( "Answer $i", 'restwell-retreats' ), 'textarea' );
		$faq_section[ "faq_{$i}_cat" ] = restwell_field( __( "Question $i category (about | booking | care | local | funding)", 'restwell-retreats' ) );
	}
	return array(
		'Header' => array(
			'faq_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'faq_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'faq_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'faq_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'faq_list_label'    => restwell_field( __( 'FAQ list section label (optional)', 'restwell-retreats' ) ),
			'faq_list_heading'  => restwell_field( __( 'FAQ list heading (h2)', 'restwell-retreats' ) ),
		),
		'FAQ items' => $faq_section,
		'CTA' => array(
			'faq_cta_label'   => restwell_field( __( 'CTA section label (optional)', 'restwell-retreats' ) ),
			'faq_cta_heading' => restwell_field( __( 'CTA heading (h2)', 'restwell-retreats' ) ),
			'faq_cta_body'    => restwell_field( __( 'CTA body', 'restwell-retreats' ), 'textarea' ),
			'faq_cta_btn'     => restwell_field( __( 'Button label', 'restwell-retreats' ) ),
			'faq_cta_url'     => restwell_field( __( 'Button URL', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Resources / Funding & support page.
 */
function restwell_get_resources_field_definitions() {
	return array(
		'Header' => array(
			'res_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'res_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'res_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'res_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'How to fund' => array(
			'res_fund_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_fund_body'    => restwell_field( __( 'Body (HTML allowed: links, lists)', 'restwell-retreats' ), 'textarea' ),
		),
		'Grants and charities' => array(
			'res_grants_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_grants_body'    => restwell_field( __( 'Body (HTML allowed)', 'restwell-retreats' ), 'textarea' ),
		),
		'NHS CHC' => array(
			'res_chc_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_chc_body'    => restwell_field( __( 'Body (HTML allowed)', 'restwell-retreats' ), 'textarea' ),
		),
		'Complaints & appeals' => array(
			'res_complaints_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_complaints_body'    => restwell_field( __( 'Body (HTML allowed)', 'restwell-retreats' ), 'textarea' ),
		),
		'Key contacts' => array(
			'res_contacts_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_contacts_body'    => restwell_field( __( 'Table or list (HTML allowed)', 'restwell-retreats' ), 'textarea' ),
		),
		'CTA' => array(
			'res_cta_heading' => restwell_field( __( 'CTA heading (h2)', 'restwell-retreats' ) ),
			'res_cta_body'    => restwell_field( __( 'CTA body', 'restwell-retreats' ), 'textarea' ),
			'res_cta_btn'     => restwell_field( __( 'Button label', 'restwell-retreats' ) ),
			'res_cta_url'     => restwell_field( __( 'Button URL', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Enquire page.
 */
function restwell_get_enquire_field_definitions() {
	return array(
		'Header' => array(
			'enq_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'enq_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'enq_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'enq_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'Form' => array(
			'enq_form_heading'        => restwell_field( __( 'Form heading (h2)', 'restwell-retreats' ) ),
			'enq_success_heading'     => restwell_field( __( 'Success message heading', 'restwell-retreats' ) ),
			'enq_success_body'        => restwell_field( __( 'Success message body (24hr callback)', 'restwell-retreats' ), 'textarea' ),
			'enq_success_urgent_body' => restwell_field( __( 'Success message body when urgent', 'restwell-retreats' ), 'textarea' ),
		),
		'Sidebar' => array(
			'enq_contact_heading' => restwell_field( __( 'Sidebar contact card heading', 'restwell-retreats' ) ),
			'enq_email'           => restwell_field( __( 'Email address', 'restwell-retreats' ) ),
			'enq_phone'           => restwell_field( __( 'Phone number', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Who It's For page.
 */
function restwell_get_who_its_for_field_definitions() {
	return array(
		'Header' => array(
			'wif_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'wif_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'wif_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'wif_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'Persona cards section' => array(
			'wif_audience_heading' => restwell_field( __( 'Section heading (h2), under the eyebrow', 'restwell-retreats' ) ),
			'wif_audience_intro'   => restwell_field( __( 'Short intro under the heading', 'restwell-retreats' ), 'textarea' ),
		),
		'Jump link labels (optional)' => array(
			'wif_nav_family_label'       => restwell_field( __( 'Jump link: families / guests', 'restwell-retreats' ) ),
			'wif_nav_carers_label'       => restwell_field( __( 'Jump link: carers', 'restwell-retreats' ) ),
			'wif_nav_ot_label'           => restwell_field( __( 'Jump link: OT / case manager', 'restwell-retreats' ) ),
			'wif_nav_commissioners_label'=> restwell_field( __( 'Jump link: commissioners', 'restwell-retreats' ) ),
		),
		'Persona cards (summary)' => array(
			'wif_family_title'        => restwell_field( __( 'Guests and families card title', 'restwell-retreats' ) ),
			'wif_family_body'         => restwell_field( __( 'Families intro (expanded: one paragraph, then bullets, then CTA)', 'restwell-retreats' ), 'textarea' ),
			'wif_carers_title'        => restwell_field( __( 'Carers card title', 'restwell-retreats' ) ),
			'wif_carers_body'         => restwell_field( __( 'Carers intro (expanded: paragraph, bullets, CTA)', 'restwell-retreats' ), 'textarea' ),
			'wif_ot_title'            => restwell_field( __( 'OT/case manager card title', 'restwell-retreats' ) ),
			'wif_ot_body'             => restwell_field( __( 'OT intro (expanded: paragraph, bullets, CTA)', 'restwell-retreats' ), 'textarea' ),
			'wif_commissioners_title' => restwell_field( __( 'Commissioners card title', 'restwell-retreats' ) ),
			'wif_commissioners_body'  => restwell_field( __( 'Commissioners intro (expanded: paragraph, bullets, CTA)', 'restwell-retreats' ), 'textarea' ),
		),
		'Persona detail - families (expandable)' => array(
			'wif_family_detail_eyebrow'   => restwell_field( __( 'Families detail eyebrow (legacy - not shown; use main intro + bullets)', 'restwell-retreats' ) ),
			'wif_family_detail_heading'   => restwell_field( __( 'Families detail heading (legacy - not shown)', 'restwell-retreats' ) ),
			'wif_family_detail_body'      => restwell_field( __( 'Families detail body (legacy - used only if main intro is empty)', 'restwell-retreats' ), 'textarea' ),
			'wif_family_detail_bullets'   => restwell_field( __( 'Families detail bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_family_inline_cta_label' => restwell_field( __( 'Families inline CTA label', 'restwell-retreats' ) ),
			'wif_family_inline_cta_url'   => restwell_field( __( 'Families inline CTA URL (path)', 'restwell-retreats' ) ),
		),
		'Persona detail - carers' => array(
			'wif_carers_detail_eyebrow'   => restwell_field( __( 'Carers detail eyebrow (legacy - not shown)', 'restwell-retreats' ) ),
			'wif_carers_detail_heading'   => restwell_field( __( 'Carers detail heading (legacy - not shown)', 'restwell-retreats' ) ),
			'wif_carers_detail_body'      => restwell_field( __( 'Carers detail body (legacy - used only if main intro is empty)', 'restwell-retreats' ), 'textarea' ),
			'wif_carers_detail_bullets'   => restwell_field( __( 'Carers detail bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_carers_inline_cta_label' => restwell_field( __( 'Carers inline CTA label', 'restwell-retreats' ) ),
			'wif_carers_inline_cta_url'   => restwell_field( __( 'Carers inline CTA URL (path)', 'restwell-retreats' ) ),
		),
		'Persona detail - OT / case managers' => array(
			'wif_ot_detail_eyebrow'   => restwell_field( __( 'OT detail eyebrow (legacy - not shown)', 'restwell-retreats' ) ),
			'wif_ot_detail_heading'   => restwell_field( __( 'OT detail heading (legacy - not shown)', 'restwell-retreats' ) ),
			'wif_ot_detail_body'      => restwell_field( __( 'OT detail body (legacy - used only if main intro is empty)', 'restwell-retreats' ), 'textarea' ),
			'wif_ot_detail_bullets'   => restwell_field( __( 'OT detail bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_ot_inline_cta_label' => restwell_field( __( 'OT inline CTA label', 'restwell-retreats' ) ),
			'wif_ot_inline_cta_url'   => restwell_field( __( 'OT inline CTA URL (path)', 'restwell-retreats' ) ),
		),
		'Persona detail - commissioners' => array(
			'wif_commissioners_detail_eyebrow'   => restwell_field( __( 'Commissioners detail eyebrow (legacy - not shown)', 'restwell-retreats' ) ),
			'wif_commissioners_detail_heading'   => restwell_field( __( 'Commissioners detail heading (legacy - not shown)', 'restwell-retreats' ) ),
			'wif_commissioners_detail_body'      => restwell_field( __( 'Commissioners detail body (legacy - used only if main intro is empty)', 'restwell-retreats' ), 'textarea' ),
			'wif_commissioners_detail_bullets'   => restwell_field( __( 'Commissioners detail bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_commissioners_inline_cta_label' => restwell_field( __( 'Commissioners inline CTA label', 'restwell-retreats' ) ),
			'wif_commissioners_inline_cta_url'   => restwell_field( __( 'Commissioners inline CTA URL (path)', 'restwell-retreats' ) ),
		),
		'Visual section (photos)' => array(
			'wif_visual_intro' => restwell_field( __( 'Intro under "Accessibility you can see" (visitor-facing)', 'restwell-retreats' ), 'textarea' ),
		),
		'Body images (optional)' => array(
			'wif_section_image_1_id'      => restwell_field( __( 'Image 1 attachment ID', 'restwell-retreats' ), 'image' ),
			'wif_section_image_1_caption' => restwell_field( __( 'Image 1 caption', 'restwell-retreats' ) ),
			'wif_section_image_2_id'      => restwell_field( __( 'Image 2 attachment ID', 'restwell-retreats' ), 'image' ),
			'wif_section_image_2_caption' => restwell_field( __( 'Image 2 caption', 'restwell-retreats' ) ),
			'wif_section_image_3_id'      => restwell_field( __( 'Image 3 attachment ID', 'restwell-retreats' ), 'image' ),
			'wif_section_image_3_caption' => restwell_field( __( 'Image 3 caption', 'restwell-retreats' ) ),
		),
		'Funding - intro + three routes' => array(
			'wif_funding_heading'        => restwell_field( __( 'Funding heading (h2)', 'restwell-retreats' ) ),
			'wif_funding_body'           => restwell_field( __( 'Funding intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_la_title'          => restwell_field( __( 'Route 1 title (local authority / DP)', 'restwell-retreats' ) ),
			'wif_fund_la_body'           => restwell_field( __( 'Route 1 body (legacy; use bullets below)', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_la_bullets'        => restwell_field( __( 'Route 1 bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_la_cta_label'      => restwell_field( __( 'Route 1 link label', 'restwell-retreats' ) ),
			'wif_fund_la_cta_url'        => restwell_field( __( 'Route 1 link URL (path)', 'restwell-retreats' ) ),
			'wif_fund_phb_title'         => restwell_field( __( 'Route 2 title (PHB)', 'restwell-retreats' ) ),
			'wif_fund_phb_body'          => restwell_field( __( 'Route 2 body (legacy; use bullets below)', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_phb_bullets'       => restwell_field( __( 'Route 2 bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_phb_cta_label'     => restwell_field( __( 'Route 2 link label', 'restwell-retreats' ) ),
			'wif_fund_phb_cta_url'       => restwell_field( __( 'Route 2 link URL (path)', 'restwell-retreats' ) ),
			'wif_fund_private_title'     => restwell_field( __( 'Route 3 title (private)', 'restwell-retreats' ) ),
			'wif_fund_private_body'      => restwell_field( __( 'Route 3 body (legacy; use bullets below)', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_private_bullets'   => restwell_field( __( 'Route 3 bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_private_cta_label' => restwell_field( __( 'Route 3 link label', 'restwell-retreats' ) ),
			'wif_fund_private_cta_url'   => restwell_field( __( 'Route 3 link URL (path)', 'restwell-retreats' ) ),
		),
		'CTA' => array(
			'wif_cta_heading'         => restwell_field( __( 'CTA heading', 'restwell-retreats' ) ),
			'wif_cta_body'            => restwell_field( __( 'CTA body', 'restwell-retreats' ), 'textarea' ),
			'wif_cta_primary_label'   => restwell_field( __( 'Primary CTA label', 'restwell-retreats' ) ),
			'wif_cta_primary_url'     => restwell_field( __( 'Primary CTA URL', 'restwell-retreats' ) ),
			'wif_cta_secondary_label' => restwell_field( __( 'Secondary CTA label', 'restwell-retreats' ) ),
			'wif_cta_secondary_url'   => restwell_field( __( 'Secondary CTA URL', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Whitstable guide page.
 */
function restwell_get_whitstable_guide_field_definitions() {
	return array(
		'Header' => array(
			'wg_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'wg_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'wg_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'wg_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'Sections' => array(
			'wg_about_heading'          => restwell_field( __( 'About section heading', 'restwell-retreats' ) ),
			'wg_about_body'             => restwell_field( __( 'About section body', 'restwell-retreats' ), 'textarea' ),
			'wg_towns_heading'          => restwell_field( __( 'Nearby towns heading', 'restwell-retreats' ) ),
			'wg_towns_body'             => restwell_field( __( 'Nearby towns body', 'restwell-retreats' ), 'textarea' ),
			'wg_getting_here_heading'   => restwell_field( __( 'Getting here heading', 'restwell-retreats' ) ),
			'wg_getting_here_body'      => restwell_field( __( 'Getting here body', 'restwell-retreats' ), 'textarea' ),
			'wg_getting_around_heading' => restwell_field( __( 'Getting around heading', 'restwell-retreats' ) ),
			'wg_getting_around_body'    => restwell_field( __( 'Getting around body', 'restwell-retreats' ), 'textarea' ),
		),
		'Image slots' => array(
			'wg_spotlight_image_1_id'      => restwell_field( __( 'Spotlight image 1 attachment ID (optional)', 'restwell-retreats' ), 'image' ),
			'wg_spotlight_image_1_caption' => restwell_field( __( 'Spotlight image 1 caption', 'restwell-retreats' ) ),
			'wg_spotlight_image_2_id'      => restwell_field( __( 'Spotlight image 2 attachment ID (optional)', 'restwell-retreats' ), 'image' ),
			'wg_spotlight_image_2_caption' => restwell_field( __( 'Spotlight image 2 caption', 'restwell-retreats' ) ),
			'wg_spotlight_image_3_id'      => restwell_field( __( 'Spotlight image 3 attachment ID (optional)', 'restwell-retreats' ), 'image' ),
			'wg_spotlight_image_3_caption' => restwell_field( __( 'Spotlight image 3 caption', 'restwell-retreats' ) ),
		),
		'Guide sections' => array(
			'wg_access_label'            => restwell_field( __( 'Accessibility block eyebrow', 'restwell-retreats' ) ),
			'wg_access_heading'          => restwell_field( __( 'Accessibility block heading', 'restwell-retreats' ) ),
			'wg_access_intro'            => restwell_field( __( 'Accessibility block intro', 'restwell-retreats' ), 'textarea' ),
			'wg_spotlight_label'         => restwell_field( __( 'Visual guide eyebrow', 'restwell-retreats' ) ),
			'wg_spotlight_heading'       => restwell_field( __( 'Visual guide heading', 'restwell-retreats' ) ),
			'wg_spotlight_intro'         => restwell_field( __( 'Visual guide intro', 'restwell-retreats' ), 'textarea' ),
			'wg_related_label'           => restwell_field( __( 'Related reading eyebrow', 'restwell-retreats' ) ),
			'wg_related_heading'         => restwell_field( __( 'Related reading heading', 'restwell-retreats' ) ),
			'wg_related_intro'           => restwell_field( __( 'Related reading intro', 'restwell-retreats' ), 'textarea' ),
			'wg_planning_label'          => restwell_field( __( 'Planning notes eyebrow', 'restwell-retreats' ) ),
			'wg_planning_heading'        => restwell_field( __( 'Planning notes heading', 'restwell-retreats' ) ),
			'wg_planning_intro'          => restwell_field( __( 'Planning notes intro', 'restwell-retreats' ), 'textarea' ),
			'wg_planning_before_heading' => restwell_field( __( 'Planning: before you travel heading', 'restwell-retreats' ) ),
			'wg_planning_before_bullets' => restwell_field( __( 'Planning: before you travel bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wg_planning_day_heading'    => restwell_field( __( 'Planning: on the day heading', 'restwell-retreats' ) ),
			'wg_planning_day_bullets'    => restwell_field( __( 'Planning: on the day bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wg_eating_label'            => restwell_field( __( 'Eating out eyebrow', 'restwell-retreats' ) ),
			'wg_eating_heading'          => restwell_field( __( 'Eating out heading', 'restwell-retreats' ) ),
			'wg_eating_intro'            => restwell_field( __( 'Eating out intro (optional)', 'restwell-retreats' ), 'textarea' ),
			'wg_eating_body'             => restwell_field( __( 'Eating out body (HTML allowed: strong, em, br; one paragraph per line)', 'restwell-retreats' ), 'textarea' ),
		),
		'CTA' => array(
			'wg_cta_heading'         => restwell_field( __( 'CTA heading', 'restwell-retreats' ) ),
			'wg_cta_body'            => restwell_field( __( 'CTA body', 'restwell-retreats' ), 'textarea' ),
			'wg_cta_primary_label'   => restwell_field( __( 'Primary CTA label', 'restwell-retreats' ) ),
			'wg_cta_primary_url'     => restwell_field( __( 'Primary CTA URL', 'restwell-retreats' ) ),
			'wg_cta_secondary_label' => restwell_field( __( 'Secondary CTA label', 'restwell-retreats' ) ),
			'wg_cta_secondary_url'   => restwell_field( __( 'Secondary CTA URL', 'restwell-retreats' ) ),
			'wg_cta_blog_label'      => restwell_field( __( 'Tertiary CTA label (blog)', 'restwell-retreats' ) ),
			'wg_cta_blog_url'        => restwell_field( __( 'Tertiary CTA URL (blog)', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Page Content Fields shared by Privacy Policy, Terms & Conditions, and Website Accessibility Policy.
 *
 * @return array<string, array<string, array{label:string,type:string}>>
 */
function restwell_get_legal_policy_field_definitions() {
	return array(
		'Hero & summary' => array(
			'legal_label'         => restwell_field( __( 'Eyebrow label (short, above the headline)', 'restwell-retreats' ) ),
			'legal_heading'       => restwell_field( __( 'Page headline (h1)', 'restwell-retreats' ) ),
			'legal_intro'         => restwell_field( __( 'Short intro under the headline (plain text)', 'restwell-retreats' ), 'textarea' ),
			'legal_hero_image_id' => restwell_field( __( 'Hero background (image or video, optional)', 'restwell-retreats' ), 'media' ),
		),
		'Document body' => array(
			'legal_body_html' => restwell_field( __( 'Main policy text (HTML). Leave empty to use the theme default for this page type.', 'restwell-retreats' ), 'textarea' ),
		),
	);
}
