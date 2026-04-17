<?php
/**
 * Theme setup: WP Admin page to create pages and seed front page meta.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/seo-content-seed.php';

const RESTWELL_SETUP_NONCE_ACTION = 'restwell_theme_setup_run';
const RESTWELL_SETUP_NONCE_NAME   = 'restwell_theme_setup_nonce';

/**
 * Pages to create: title => slug.
 */
function restwell_get_theme_setup_pages() {
	return array(
		'Home'               => 'home',
		'The Property'       => 'the-property',
		'How It Works'       => 'how-it-works',
		'Accessibility'      => 'accessibility',
		'Who It\'s For'      => 'who-its-for',
		'FAQ'                => 'faq',
		'Enquire'            => 'enquire',
		'Resources'          => 'resources',
		'Whitstable Guide'   => 'whitstable-area-guide',
		'Blog'               => 'blog',
		'Guest Guide'        => 'guest-guide',
		'Privacy Policy'       => 'privacy-policy',
		'Terms & Conditions' => 'terms-and-conditions',
		'Accessibility Policy' => 'accessibility-policy',
	);
}

/**
 * Default meta values for the front page (Home).
 */
function restwell_get_theme_setup_defaults() {
	$defaults = array(
		'hero_eyebrow'             => 'Restwell Retreats',
		'hero_heading'             => 'Accessible Holidays in Whitstable, Kent',
		'hero_subheading'          => 'Adapted bungalow for guests, families, and carers with whole-property booking.',
		'hero_spec_heading'        => '',
		'hero_cta_primary_label'   => 'View the property',
		'hero_cta_primary_url'     => '/the-property/',
		'hero_cta_secondary_label' => 'Send an enquiry',
		'hero_cta_secondary_url'   => '/enquire/',
		'hero_cta_promise'         => '',

		'home_teaser_label'         => 'Area & funding',
		'home_teaser_area_title'    => 'Whitstable & the Kent coast',
		'home_teaser_area_body'     => 'Single-storey bungalow on the Kent coast: harbour, promenade, and day trips with realistic access notes. We focus on step-free routes, parking, and places that match your needs, not a vague list labelled "wheelchair friendly".',
		'home_teaser_funding_title' => 'Funding your stay',
		'home_teaser_funding_body'  => 'Many guests use personal budgets, direct payments, NHS Continuing Healthcare, or local authority funding. Our guides explain common routes in plain English: what to ask your social worker, and what paperwork helps.',

		'what_restwell_label'   => 'What is Restwell?',
		'what_restwell_heading' => 'A proper accessible coastal holiday.',
		'highlights_heading'    => '',
		'highlight_1_title'     => 'Ceiling track hoist',
		'highlight_1_desc'      => 'Full-room coverage for safer, more predictable transfers.',
		'highlight_2_title'   => 'Profiling bed',
		'highlight_2_desc'      => 'Adjustable, with a pressure-relieving mattress. Ready for your stay.',
		'highlight_3_title'     => 'Full wet room',
		'highlight_3_desc'      => 'Roll-in shower, grab rails, and space to turn and assist.',
		'intro_body'            => 'Restwell is a wheelchair-accessible, single-storey self-catering bungalow in Whitstable, Kent, for guests with disabilities, their families, and carers. You book the whole property for a private coastal break. Optional professional care is available through Continuity of Care Services (CQC-regulated), on your terms.',

		'who_label'        => "Who it's for",
		'who_heading'      => 'Two people. One break.',
		'who_guest_title'  => 'For the guest',
		'who_guest_body'   => 'A private home with the space and access features you need: wide doorways, level thresholds, room for equipment, and space to settle. Self-catering in Whitstable at your pace: the house is yours, the timetable is yours. Rest by the sea, then explore the town or stay close as you prefer.',
		'who_carer_title'  => 'For the carer',
		'who_carer_body'   => 'The layout supports care routines: separate sleeping, practical bathroom access, and space to assist. Optional CQC-regulated support is available through Continuity of Care Services, or bring your own carer. Either way, the environment is set up for real routines, day and night, so you are not improvising.',

		'property_label'      => 'The property',
		'property_heading'   => 'Our Whitstable home',
		'property_body'      => 'An adapted single-storey property in Whitstable: level approach from the street, off-street parking for adapted vehicles, and a flat route toward the Tankerton promenade. Whitstable town centre (harbour, seafood restaurants, and the waterfront) is close enough for day trips without stressful route planning.',
		'property_cta_label' => 'Explore the property',
		'property_cta_url'   => '/the-property/',
		'property_image_id'  => 0,

		'why_label'       => 'Why Restwell?',
		'why_heading'     => 'Why choose Restwell for your accessible break?',
		'why_item1_title' => 'Private & personal',
		'why_item1_desc'  => 'The whole bungalow is yours: living space, kitchen, and bedrooms, with the privacy of a self-catering stay.',
		'why_item2_title' => 'Professional support on your terms',
		'why_item2_desc'  => 'Continuity of Care Services (CQC-regulated): support arranged on your terms, as much or as little as you need, or bring your own carer.',
		'why_item3_title' => 'Local knowledge',
		'why_item3_desc'  => 'We can tell you which cafes have step-free access, where to park near the harbour, and which routes work for wheelchairs, so you spend more time relaxing and less time planning.',
		'why_item4_title' => 'Honest & open',
		'why_item4_desc'  => 'We publish the access specification: exact dimensions, thresholds, and equipment, so you can plan with confidence before you travel.',

		'home_comparison_label'          => 'Compare options',
		'home_comparison_heading'        => 'Restwell vs. a typical hotel stay',
		'home_comparison_intro'          => 'A side-by-side on privacy, equipment, care, and the kitchen.',
		'home_comparison_row1_feature'   => 'Privacy',
		'home_comparison_row1_restwell'  => 'Whole property',
		'home_comparison_row1_other'     => 'Shared spaces',
		'home_comparison_row2_feature'   => 'Equipment',
		'home_comparison_row2_restwell'  => 'Hoist, profiling bed',
		'home_comparison_row2_other'     => 'Limited',
		'home_comparison_row3_feature'   => 'Care',
		'home_comparison_row3_restwell'  => 'Optional, your choice',
		'home_comparison_row3_other'     => 'Fixed or none',
		'home_comparison_row4_feature'   => 'Kitchen',
		'home_comparison_row4_restwell'  => 'Full self-catering',
		'home_comparison_row4_other'     => 'None or limited',

		'cta_heading'          => 'Ready to plan your accessible stay?',
		'cta_body'            => 'Ask about hoist limits, door widths, or funding. No pressure: we reply with specifics you can use.',
		'cta_primary_label'   => 'Send an enquiry',
		'cta_primary_url'     => '/enquire/',
		'cta_secondary_label' => 'See the property',
		'cta_secondary_url'   => '/the-property/',
		'cta_promise'         => 'No booking commitment. Replies usually within one working day.',
		'cta_image_id'        => 0,
	);

	if ( function_exists( 'restwell_get_homepage_faq_meta_seed_map' ) ) {
		$defaults = array_merge( $defaults, restwell_get_homepage_faq_meta_seed_map() );
	}

	return $defaults;
}

/**
 * Merge theme default post meta into a page: overwrite all keys when $force; otherwise only set keys that are not stored yet.
 *
 * Preserves intentional edits and empty values; fills gaps when new defaults are added to the theme.
 *
 * @param int   $post_id  Post ID.
 * @param array $defaults Key => value from a restwell_get_*_defaults() map.
 * @param bool  $force    When true, replace every listed key from defaults.
 * @return int Number of meta keys written.
 */
function restwell_merge_theme_defaults_into_post_meta( $post_id, array $defaults, $force ) {
	$post_id = (int) $post_id;
	if ( $post_id < 1 || empty( $defaults ) ) {
		return 0;
	}

	$written = 0;
	foreach ( $defaults as $key => $value ) {
		if ( $force || ! metadata_exists( 'post', $post_id, $key ) ) {
			update_post_meta( $post_id, $key, $value );
			++$written;
		}
	}

	return $written;
}

/**
 * Post meta value, or the default from a theme defaults map when the key has never been saved.
 *
 * Uses metadata_exists so intentionally saved empty strings are preserved. Unseeded pages get
 * the same copy as Theme Setup / restwell_get_*_page_defaults().
 *
 * @param int    $post_id  Post ID.
 * @param string $key      Meta key.
 * @param array  $defaults Key => default from restwell_get_*_page_defaults().
 * @return mixed Stored value or default.
 */
function restwell_post_meta_or_default( $post_id, $key, array $defaults ) {
	$post_id = (int) $post_id;
	if ( $post_id < 1 ) {
		return $defaults[ $key ] ?? '';
	}
	if ( metadata_exists( 'post', $post_id, $key ) ) {
		return get_post_meta( $post_id, $key, true );
	}
	return $defaults[ $key ] ?? '';
}

/**
 * Resolve a stored URL or path; empty stored values fall back to the theme default (same as old `?:` for URLs).
 *
 * @param int    $post_id  Post ID.
 * @param string $key      Meta key.
 * @param array  $defaults Map from restwell_get_*_page_defaults().
 * @return string Absolute URL (not escaped).
 */
function restwell_post_meta_url( $post_id, $key, array $defaults ) {
	$post_id = (int) $post_id;
	$def     = trim( (string) ( $defaults[ $key ] ?? '' ) );
	if ( $post_id < 1 ) {
		$raw = $def;
	} elseif ( metadata_exists( 'post', $post_id, $key ) ) {
		$raw = trim( (string) get_post_meta( $post_id, $key, true ) );
	} else {
		$raw = $def;
	}
	if ( $raw === '' ) {
		$raw = $def;
	}
	if ( $raw === '' ) {
		return home_url( '/' );
	}
	if ( preg_match( '#^https?://#i', $raw ) ) {
		return $raw;
	}
	return home_url( $raw );
}

/**
 * Default meta for The Property page.
 */
function restwell_get_property_page_defaults() {
	return array(
		'prop_address_street'   => '101 Russell Drive',
		'prop_address_locality' => 'Whitstable',
		'prop_address_region'   => 'Kent',
		'prop_address_postcode' => 'CT5 2RQ',

		'prop_hero_label'               => 'The Property',
		'prop_hero_heading'             => 'Our accessible home in Whitstable',
		'prop_hero_subtitle'            => 'An adapted home on the Kent coast: ceiling track hoist, profiling bed, and wet room already in place.',
		'prop_hero_cta_text'            => 'Ask about your dates',
		'prop_hero_cta_url'             => '/enquire/',
		'prop_hero_cta_secondary_text'  => 'How it works',
		'prop_hero_cta_secondary_url'   => '/how-it-works/',
		'prop_hero_cta_promise'         => 'We reply within one working day.',
		'prop_hero_image_id'            => 0,

		'prop_home_label'   => 'Your home for the week',
		'prop_home_heading' => 'Everything you need. Nothing you don\'t.',
		'prop_home_1_title' => 'Step-free throughout',
		'prop_home_1_body'  => 'Wide doorways, level thresholds, and a layout designed around wheelchair users and anyone who finds steps difficult.',
		'prop_home_2_title' => 'Flexible sleeping setup',
		'prop_home_2_body'  => 'Sleeping arrangements can be planned around your group and support needs. Share your requirements and we will confirm suitability before booking.',
		'prop_home_3_title' => 'Quiet location',
		'prop_home_3_body'  => 'Set on a residential street away from traffic. Close enough to walk to the seafront, quiet enough to rest properly.',

		'prop_overview_heading' => 'Your coastal home-from-home',
		'prop_overview_body'    => "This is a private holiday home, not a hotel room or a care facility. The whole property is yours for the duration of your stay: no shared corridors, no other guests, no institutional feel. The layout has been designed around the access needs of wheelchair users and guests with complex physical disabilities, with practical details like transfer space, equipment compatibility, and carer accommodation considered from the start.\n\nThe property sits in a quiet, flat residential area of Whitstable. The town itself is compact, independent, and manageable, known for its harbour, seafood, and coastal walks. It is about 60 miles from London, with direct train services and straightforward road access via the M2.",

		'prop_dignity_label'   => 'Designed for dignity',
		'prop_dignity_heading' => 'Thoughtful at every turn.',
		'prop_dignity_body'    => "We have thought carefully about what 'accessible' actually means in practice, not just ticked a box.\n\nThat means a wet room with a ceiling hoist, an adjustable bed, wide hallways, and no awkward lips or steps. It means a kitchen where everyone can cook together. A garden you can actually enjoy.\n\nWe want every guest to feel at home, completely, not just mostly.",
		'prop_dignity_image_id' => 0,

		'prop_features_label'   => 'At a glance',
		'prop_features_heading' => 'What\'s in the house',
		'prop_feature_1'        => 'Ceiling track hoist',
		'prop_feature_1_desc'   => 'Full-room coverage in the accessible bedroom',
		'prop_feature_2'        => 'Wet room',
		'prop_feature_2_desc'   => 'Roll-in shower, grab rails, fold-down seat',
		'prop_feature_3'        => 'Adjustable profiling bed',
		'prop_feature_3_desc'   => 'With pressure-relieving mattress',
		'prop_feature_4'        => 'Wide doorways',
		'prop_feature_4_desc'   => 'Internal doors 926 mm clear; front door 965 mm',
		'prop_feature_5'        => 'Step-free access',
		'prop_feature_5_desc'   => 'Level entry from parking to all rooms',
		'prop_feature_6'        => 'Accessible outdoor space',
		'prop_feature_6_desc'   => 'Hard-standing patio and level garden',
		'prop_feature_7'        => 'Fully equipped kitchen',
		'prop_feature_7_desc'   => 'Height-adjustable worktop section',
		'prop_feature_8'        => 'High-speed broadband',
		'prop_feature_8_desc'   => 'Reliable Wi-Fi throughout the property',

		'prop_acc_label'      => 'Accessibility in detail',
		'prop_acc_heading'    => 'Honest accessibility information',
		'prop_acc_intro'      => 'We provide detailed accessibility information so you can make an informed decision about whether this property meets your needs. If anything below is unclear, please get in touch and we will happily answer your questions.',
		'prop_acc_confirmed'  => "Step-free access from parking to all rooms\nCeiling track hoist with full-room coverage\nWet room with roll-in shower, fold-down seat, and grab rails\nAdjustable profiling bed with pressure-relieving mattress\nFront door: 965 mm clear opening width; internal doors: 926 mm clear\nLevel garden with hard-standing patio\nWi-Fi throughout the property",
		'prop_acc_tbc'        => "Precise turning circle dimensions in each room\nHoist weight limit (confirming with installer)\nLocal hydrotherapy or pool access",

		'prop_comparison_label'         => 'Why not a hotel?',
		'prop_comparison_heading'       => 'A house, not a hotel room.',
		'prop_comparison_intro'         => 'Accessible hotel rooms tend to offer a bed and a wet room. We offer a home.',
		'prop_comparison_left_heading'  => 'A standard \'accessible\' room',
		'prop_comparison_right_heading' => 'Your Restwell stay',
		'prop_comparison_left_1'        => 'One accessible room among many',
		'prop_comparison_left_2'        => 'Restaurant only, no kitchen',
		'prop_comparison_left_3'        => 'No care coordination',
		'prop_comparison_left_4'        => 'Basic grab rails if you\'re lucky',
		'prop_comparison_right_1'       => 'The whole house is yours',
		'prop_comparison_right_2'       => 'Cook your own meals together',
		'prop_comparison_right_3'       => 'Optional CQC-regulated care on site',
		'prop_comparison_right_4'       => 'Ceiling hoist, profiling bed included',

		'prop_gallery_label'       => 'See the space',
		'prop_gallery_heading'     => 'Take a look around.',
		'prop_gallery_1_image_id'  => 0,
		'prop_gallery_2_image_id'  => 0,
		'prop_gallery_3_image_id'  => 0,
		'prop_gallery_btn_1_label' => 'Ask about your dates',
		'prop_gallery_btn_1_url'   => '/enquire/',
		'prop_gallery_btn_2_label' => '',
		'prop_gallery_btn_2_url'   => '',
		'prop_gallery_btn_3_label' => '',
		'prop_gallery_btn_3_url'   => '',

		'prop_practical_label'   => 'Practical details',
		'prop_practical_heading' => 'The basics, clearly.',
		'prop_bedrooms_count'    => '3',
		'prop_bedrooms'          => 'Three bedrooms: flexible layout for guests, family, and carers',
		'prop_bathrooms_count'   => '1',
		'prop_bathroom'          => 'One wet room with roll-in shower (full spec on our Accessibility page)',
		'prop_parking_label'     => 'Parking',
		'prop_parking'           => '2 cars',
		'prop_sleeps_value'      => '5',
		'prop_sleeps_label'      => 'Sleeps',
		'prop_distances'         => "Tankerton Slopes promenade: 15 min flat walk\nWhitstable town centre: 15 min walk\nWhitstable station: 20-30 min walk",
		'prop_confirm_details_url' => '/enquire/',

	'prop_nearby_label'       => 'What\'s nearby',
	'prop_nearby_heading'     => 'Explore Whitstable.',
	'prop_nearby_1_title'     => 'The Plough Pub',
	'prop_nearby_1_body'      => "A friendly local pub on St John's Road, just a short walk from the property. Relaxed atmosphere, good food, live music nights, and welcoming to families and groups.",
	'prop_nearby_1_acc'       => 'Wheelchair-accessible entrance and accessible restroom. Confirm current details with the pub.',
	'prop_nearby_1_distance'  => 'Approx. 5 min walk',
	'prop_nearby_1_filter'    => 'wheelchair-friendly quieter',
	'prop_nearby_1_map_url'   => 'https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable',
	'prop_nearby_2_title'     => 'Tankerton Slopes & Promenade',
		'prop_nearby_2_body'      => 'A long, flat, surfaced promenade with views across the Thames Estuary. The promenade path itself is wide and level, suitable for wheelchairs and powerchairs. The grassy slopes between the road and the promenade are steep, so use the paved access paths. Free parking along Marine Parade at the top.',
	'prop_nearby_2_acc'       => 'Flat tarmac path, no steps, suitable for wheelchairs. Accessible WC at harbour end.',
	'prop_nearby_2_distance'  => 'Approx. 15 min flat walk',
	'prop_nearby_2_filter'    => 'wheelchair-friendly',
	'prop_nearby_2_map_url'   => 'https://maps.google.com/?q=Tankerton+Slopes+Whitstable',
	'prop_nearby_3_title'     => 'Whitstable Harbour & Harbour Street',
	'prop_nearby_3_body'      => 'Fresh oysters, fish and chips, independent restaurants, boutiques, galleries, and cafes. A lively working harbour with a relaxed, artistic character that draws visitors year-round.',
	'prop_nearby_3_acc'       => 'Mostly flat approach. Some cobblestone sections near the harbour. Harbour Street pavements can be narrow during peak times; quieter on weekday mornings.',
	'prop_nearby_3_distance'  => 'Approx. 20 min walk or 7 min drive',
	'prop_nearby_3_filter'    => 'quieter',
	'prop_nearby_3_map_url'   => 'https://maps.google.com/?q=Harbour+Street+Whitstable+Kent',
	'prop_nearby_4_title'     => 'Whitstable Beach',
	'prop_nearby_4_body'      => "Whitstable's iconic shingle beach is beautiful, but we want to be honest: shingle is generally not suitable for wheelchairs. The promenade above provides excellent sea views and is accessible for most wheelchair users.",
	'prop_nearby_4_acc'       => 'Shingle beach is not recommended for wheelchairs. The level promenade path above the beach is the accessible alternative.',
	'prop_nearby_4_distance'  => 'Approx. 15 min walk',
	'prop_nearby_4_filter'    => 'wheelchair-friendly',
	'prop_nearby_4_map_url'   => 'https://maps.google.com/?q=Whitstable+Beach+Kent',
	'prop_nearby_5_title'     => 'Supermarkets',
	'prop_nearby_5_body'      => "Sainsbury's is the closest at 4 minutes (Reeves Way, Chestfield CT5 3QS). Tesco Extra is 7 minutes (Millstrood Rd CT5 3EE). Co-op is 9 minutes (14-16 Canterbury Rd CT5 4EX). Aldi is 10 minutes (Prospect Retail Park CT5 3SD). All have accessible parking.",
	'prop_nearby_5_acc'       => 'All four stores have step-free access and accessible parking bays.',
	'prop_nearby_5_distance'  => 'From 4 min drive',
	'prop_nearby_5_filter'    => 'practical',
	'prop_nearby_5_map_url'   => 'https://maps.google.com/?q=Sainsbury%27s+Whitstable+Chestfield',
	'prop_nearby_6_title'     => 'Local Pharmacies',
	'prop_nearby_6_body'      => 'Boots Pharmacy and Superdrug Pharmacy are both in Whitstable town centre and open 7 days a week. Hours may vary slightly on Sundays; check locally if urgent.',
	'prop_nearby_6_acc'       => 'Accessible entrances. Confirm current details with each pharmacy.',
	'prop_nearby_6_distance'  => 'Short drive or bus to town',
	'prop_nearby_6_filter'    => 'practical',
	'prop_nearby_6_map_url'   => 'https://maps.google.com/?q=Boots+Pharmacy+Whitstable',
	'prop_nearby_7_title'     => 'Getting Around',
	'prop_nearby_7_body'      => 'Accessible taxis: Abacus Cars LTD (01227 277745). Pre-book wheelchair-accessible vehicles, especially during school run times. Stagecoach South East: the 400 bus from The Plough runs to the beach, harbour, and Canterbury bus station. Whitstable Railway Station has direct trains to London St Pancras and Victoria; Chestfield & Swalecliffe is a quieter alternative nearby.',
	'prop_nearby_7_acc'       => 'Pre-book accessible vehicles with Abacus Cars. Bus stops within walking distance. Confirm station accessibility with National Rail.',
	'prop_nearby_7_distance'  => 'Various',
	'prop_nearby_7_filter'    => 'practical',
	'prop_nearby_7_map_url'   => 'https://maps.google.com/?q=Whitstable+Railway+Station',
	'prop_nearby_8_title'     => 'Medical & Emergency',
	'prop_nearby_8_body'      => 'Nearest A&E: Kent and Canterbury Hospital, Ethelbert Rd, Canterbury CT1 3NG, approximately 7 miles, 15-20 minutes by car. Non-emergency NHS: call 111. Local GP: Whitstable Medical Practice (approx. 5 min drive). Emergencies: 999.',
	'prop_nearby_8_acc'       => 'Kent and Canterbury Hospital has accessible parking and entrances. Call ahead for GP appointments.',
	'prop_nearby_8_distance'  => 'A&E approx. 7 miles / 15-20 min',
	'prop_nearby_8_filter'    => 'practical',
	'prop_nearby_8_map_url'   => 'https://maps.google.com/?q=Kent+and+Canterbury+Hospital+CT1+3NG',
	'prop_nearby_cta_label'   => 'Questions about access?',
	'prop_nearby_cta_url'     => '/enquire/',

		'prop_cta_heading' => 'Ready to see it for yourself?',
		'prop_cta_body'    => 'Get in touch and we\'ll answer any questions you have, honestly, without pressure.',
		'prop_cta_btn'     => 'Enquire now',
		'prop_cta_url'     => '/enquire/',
		'prop_cta_promise' => '',
	);
}

/**
 * Default meta for the How It Works page.
 */
function restwell_get_how_it_works_page_defaults() {
	$defaults = array(
		'hiw_label'   => 'How it works',
		'hiw_heading' => 'Simple from first enquiry to final day.',
		'hiw_intro'   => 'We have made the process as straightforward as possible. No lengthy forms, no complicated assessments upfront: just a conversation to make sure we can meet your needs.',

		'hiw_steps_label'   => 'The process',
		'hiw_steps_heading' => 'Four steps to your stay.',
		'hiw_steps_intro'   => '',
		'hiw_step1_title'   => 'Get in touch',
		'hiw_step1_body'    => 'Fill in our short enquiry form or drop us an email. Tell us a little about who you are, when you\'re thinking of visiting, and any care or accessibility requirements.',
		'hiw_step2_title'   => 'We\'ll call you back',
		'hiw_step2_body'    => 'We want to understand what you need, confirm the property is right for you, and answer every question honestly. We aim to reply within one working day.',
		'hiw_step3_title'   => 'Confirm your booking',
		'hiw_step3_body'    => 'Once you\'re happy, we\'ll send a simple booking confirmation and take a deposit. Care arrangements, if required, are agreed at this stage with Continuity of Care Services.',
		'hiw_step4_title'   => 'Arrive and rest easy',
		'hiw_step4_body'    => 'We\'ll be on hand for your arrival to show you around and make sure you\'re settled. Then the house is yours.',


		'hiw_care_cta_label'   => 'Optional care support',
		'hiw_care_cta_heading' => 'Care support works around you, not shift patterns.',
		'hiw_care_cta_body'    => 'Care is entirely optional. If you want it, Continuity of Care Services (CQC-regulated and experienced) will work to your schedule, not theirs. Morning check-ins, personal care, or more comprehensive support: you decide.',
		'hiw_care_cta_btn'     => 'Ask about care options',
		'hiw_care_cta_url'     => '/enquire/',

		'hiw_included_label'   => 'What\'s included',
		'hiw_included_heading' => 'Everything in the house is yours.',
		'hiw_included_intro'   => 'Your booking covers exclusive use of the whole property for the duration of your stay.',
		'hiw_included_1_title' => 'Exclusive use of the whole house',
		'hiw_included_1_desc'  => 'No shared spaces, no other guests.',
		'hiw_included_2_title' => 'Ceiling hoist & profiling bed',
		'hiw_included_2_desc'  => 'Ceiling track hoist, profiling bed, and wet room with grab rails, in place and ready for your arrival.',
		'hiw_included_3_title' => 'High-speed broadband',
		'hiw_included_3_desc'  => 'Reliable Wi-Fi throughout.',
		'hiw_included_4_title' => 'Linen and towels',
		'hiw_included_4_desc'  => 'Freshly laundered for your arrival.',
		'hiw_included_5_title' => 'Parking for two cars',
		'hiw_included_5_desc'  => 'Private driveway.',
		'hiw_included_6_title' => 'Welcome information pack',
		'hiw_included_6_desc'  => 'Local tips, emergency contacts, house guide, plus tea, coffee, and a few basics so you are not shopping the moment you arrive.',

		'hiw_cta_label'           => 'Ready?',
		'hiw_cta_heading'         => 'Start with a conversation.',
		'hiw_cta_body'            => 'No commitment, no lengthy forms. Just get in touch and we\'ll take it from there.',
		'hiw_cta_primary_label'   => 'Enquire now',
		'hiw_cta_primary_url'     => '/enquire/',
		'hiw_cta_secondary_label' => 'See the property',
		'hiw_cta_secondary_url'   => '/the-property/',
		'hiw_cta_promise'         => 'No obligation. Ask us anything.',

		'hiw_faq_label'   => 'Common questions',
		'hiw_faq_heading' => 'Things people often ask.',
		'hiw_faq_intro'   => '',
		'hiw_faq_1_q'     => 'Do I have to book care?',
		'hiw_faq_1_a'     => 'No. Care support through Continuity of Care Services is entirely optional. Many guests book the house as a self-catering holiday and need no additional support.',
		'hiw_faq_2_q'     => 'How far in advance should I book?',
		'hiw_faq_2_a'     => 'We recommend enquiring as early as possible; peak summer weeks fill quickly. That said, we will always try to accommodate shorter-notice bookings where we can.',
		'hiw_faq_3_q'     => 'How far is the property from the beach?',
		'hiw_faq_3_a'     => 'The Tankerton promenade is about 15 minutes\' flat walk from the property. The town centre and harbour are about a 7-minute drive or 20-minute walk. We can provide exact routes and accessibility notes for any destination before your stay.',
	);
	return $defaults;
}

/**
 * Default meta for the Accessibility page.
 */
function restwell_get_accessibility_page_defaults() {
	return array(
		'acc_label'   => 'Accessibility',
		'acc_heading' => 'Built for access, not bolted on.',
		'acc_intro'   => 'We know how important it is to have accurate, detailed accessibility information before you book. Here is everything we can tell you about the property and the destination.',

		'acc_room_label'      => 'The property',
		'acc_room_heading'    => 'Room by room.',
		'acc_arrival_heading' => 'Arrival & entrance',
		'acc_arrival_body'    => "Level driveway with space for two cars\nStep-free path from car to front door\nWide front door (965 mm clear)\nLevel threshold, no step",
		'acc_inside_heading'  => 'Inside the property',
		'acc_inside_body'     => "All internal doors 926 mm clear\nOpen-plan ground floor, no internal steps\nLevel flooring throughout (no carpet lips)\nCeiling track hoist covers accessible bedroom and wet room",
		'acc_bedroom_heading' => 'Accessible bedroom',
		'acc_bedroom_body'    => "Profiling bed with pressure-relieving mattress\nCeiling hoist with full-room track\nHeight-adjustable features\nSpace for carer on both sides of bed",
		'acc_bathroom_heading'=> 'Wet room',
		'acc_bathroom_body'   => "Full wet room: roll-in shower, no lip\nFold-down shower seat\nGrab rails: shower, toilet, and washbasin\nFloor-level drain\nExtractor fan",
		'acc_kitchen_heading' => 'Kitchen',
		'acc_kitchen_body'    => "Open-plan kitchen, easy wheelchair access\nHeight-adjustable worktop section\nInduction hob (safer for some users)\nAccessible storage at lower levels",
		'acc_outdoor_heading' => 'Outdoor spaces',
		'acc_outdoor_body'    => "Level patio immediately outside rear doors\nHard-standing surface suitable for wheelchairs\nSmall garden area, mostly flat",

		'acc_dest_label'              => 'Whitstable',
		'acc_dest_heading'            => 'The destination, honestly.',
		'acc_dest_intro'              => 'Whitstable is a genuinely lovely town, but like most historic coastal places, it has its challenges. Here is the honest picture.',
		'acc_dest_good_heading'       => 'The good',
		'acc_dest_good_body'          => 'The Tankerton promenade is a long, flat, surfaced path along the seafront, one of the most wheelchair-friendly coastal routes in Kent. Free parking at Marine Parade. Accessible toilets at the harbour end. The streets around the property are flat and paved with dropped kerbs.',
		'acc_dest_challenge_heading'  => 'The challenges',
		'acc_dest_challenge_body'     => 'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have stepped entrances with no ramp. The harbour itself has some uneven surfaces near the fish market. Weekday mornings are the easiest time to visit.',
		'acc_dest_reality_heading'    => 'The reality',
		'acc_dest_reality_body'       => "Whitstable is more accessible than most UK coastal towns. With a little planning and our local knowledge, we can point you to the best accessible routes, cafes, and experiences. We will share everything we know in your welcome pack.",

		'acc_cta_heading' => 'Still have questions about access?',
		'acc_cta_body'    => 'Get in touch and we will answer honestly. If the property isn\'t right for your needs, we will tell you.',
		'acc_cta_btn'     => 'Ask an accessibility question',
		'acc_cta_url'     => '/enquire/',
	);
}

/**
 * Default meta for the FAQ page.
 */
function restwell_get_faq_page_defaults() {
	return array(
		'faq_label'        => 'FAQ',
		'faq_heading'      => 'Your questions, answered honestly.',
		'faq_intro'        => 'If you can\'t find the answer here, get in touch; we respond within 24 hours.',
		'faq_list_label'   => '',
		'faq_list_heading' => 'Frequently asked questions',

		'faq_1_q'   => 'What is Restwell?',
		'faq_1_a'   => 'Restwell is a high-quality accessible holiday let in Whitstable, Kent. It is a proper coastal holiday home, not a care home, not a clinical facility. We offer the option of professional, CQC-regulated care support through our partner, Continuity of Care Services, but it is entirely optional.',
		'faq_1_cat' => 'about',

		'faq_2_q'   => 'Who is the property suitable for?',
		'faq_2_a'   => 'The property is designed for guests with disabilities, wheelchair users, and people with complex care needs, and the family and carers who travel with them. It is for anyone who finds standard holiday accommodation doesn\'t quite work.',
		'faq_2_cat' => 'about',

		'faq_3_q'   => 'Do I need to book care?',
		'faq_3_a'   => 'No. Care support is entirely optional. Many guests book as a self-catering holiday and need no additional support. If you do want professional care, we will connect you with Continuity of Care Services to arrange it.',
		'faq_3_cat' => 'care',

		'faq_4_q'   => 'What care services are available?',
		'faq_4_a'   => 'Through Continuity of Care Services (CQC-regulated), we can arrange personal care, medication management, moving and handling support, and more. The level of support is entirely up to you, from a daily check-in to comprehensive care.',
		'faq_4_cat' => 'care',

		'faq_5_q'   => 'How do I book?',
		'faq_5_a'   => 'Use our enquiry form, email us, or call. We will get back to you within 24 hours, have a conversation about your needs, and confirm availability. Once you\'re happy, we take a deposit and send a booking confirmation.',
		'faq_5_cat' => 'booking',

		'faq_6_q'   => 'What is the minimum stay?',
		'faq_6_a'   => 'We are flexible. Most guests stay for a week, but shorter breaks are sometimes available depending on the time of year. Get in touch with your preferred dates and we will let you know.',
		'faq_6_cat' => 'booking',

		'faq_7_q'   => 'What is included in the price?',
		'faq_7_a'   => 'Exclusive use of the whole house, all accessibility equipment (ceiling hoist, profiling bed, wet room), linen and towels, private parking for two cars, and high-speed broadband. Care is priced separately if required.',
		'faq_7_cat' => 'booking',

		'faq_8_q'   => 'Is the property suitable for hoists and profiling beds?',
		'faq_8_a'   => 'The property already has a ceiling track hoist fitted, along with a profiling bed and a full wet room. If you have additional or specialist equipment needs, please get in touch before booking so we can confirm we can accommodate them.',
		'faq_8_cat' => 'about',

		'faq_9_q'   => 'What is Whitstable like for accessibility?',
		'faq_9_a'   => 'Mostly good: the Tankerton Slopes promenade is excellent for wheelchairs, the town centre is largely flat, and several restaurants and cafes are accessible. The harbour area has some cobblestones and the beach is shingle. Our welcome pack gives detailed local accessibility guidance.',
		'faq_9_cat' => 'local',

		'faq_10_q'   => 'How far is the property from the sea?',
		'faq_10_a'   => 'About a five-minute walk along a flat, tarmac path to the Tankerton Slopes promenade.',
		'faq_10_cat' => 'local',

		'faq_11_q'   => 'What is your cancellation policy?',
		'faq_11_a'   => "More than 30 days before arrival: full refund. 14-30 days before: 50% refund. Less than 14 days before: no refund.\n\nWe recognise that guests booking accessible accommodation may face unexpected medical or care-related changes. If cancellation is due to serious illness or a care emergency, we will consider a partial refund or a free date change subject to availability.\n\nDate changes requested more than 14 days before arrival are free of charge. Changes within 14 days may incur a fee. No refunds for early departure or no-shows.",
		'faq_11_cat' => 'booking',

		'faq_12_q'   => 'Can I visit the property before booking?',
		'faq_12_a'   => 'Pre-booking visits are welcome. Get in touch and we will arrange a convenient time.',
		'faq_12_cat' => 'booking',

		'faq_13_q'   => 'Can I use my direct payment to stay at Restwell?',
		'faq_13_a'   => 'In many cases, yes. Direct payments can often be used for short breaks and respite accommodation, depending on your care plan and local authority. We can provide the documentation your social worker or broker needs to approve the spend. Start with our Funding & Support page or get in touch to discuss your situation.',
		'faq_13_cat' => 'funding',

		'faq_14_q'   => 'What does CQC-regulated mean?',
		'faq_14_a'   => 'CQC stands for Care Quality Commission, the independent regulator of health and social care in England. Continuity of Care Services, our partner provider, is inspected and rated by the CQC. This means the care you receive meets nationally recognised standards for safety and quality.',
		'faq_14_cat' => 'funding',

		'faq_cta_label'   => '',
		'faq_cta_heading' => 'Still have a question?',
		'faq_cta_body'    => 'Get in touch and we will answer honestly. We respond within 24 hours.',
		'faq_cta_btn'     => 'Enquire now',
		'faq_cta_url'     => '/enquire/',
	);
}

/**
 * Default meta for the Enquire page.
 */
function restwell_get_enquire_page_defaults() {
	return array(
		'enq_label'   => 'Get in touch',
		'enq_heading' => 'Let\'s talk about your stay.',
		'enq_intro'   => 'Fill in the form and we\'ll call you back within 24 hours. No commitment, no hard sell: just a conversation.',

		'enq_form_heading'        => 'Tell us about your stay',
		'enq_success_heading'     => 'Thank you. We\'ll be in touch.',
		'enq_success_body'        => 'We will call you back within 24 hours to discuss your enquiry. If you would prefer an email response, just let us know.',
		'enq_success_urgent_body' => 'As you\'ve indicated this is time-sensitive, we will aim to respond as quickly as possible.',

		'enq_contact_heading' => 'Other ways to reach us',
		'enq_email'            => 'hello@restwellretreats.co.uk',
		'enq_phone'            => '01622 809881',
	);
}

/**
 * Default meta for the Resources / Funding & Support page.
 */
function restwell_get_resources_page_defaults() {
	return array(
		'res_label'   => 'Funding & support',
		'res_heading' => 'Help paying for your break.',
		'res_intro'   => 'A Restwell Retreats holiday may be more affordable than you think. There are several funding routes worth exploring; we have gathered the most useful information here.',

		'res_fund_heading' => 'How to fund your stay',
		'res_fund_body'    => "Many guests use a combination of personal savings, direct payments, and charitable grants to fund their stay.\n\nIf you receive a personal budget or direct payment from your local authority or NHS, you may be able to use this towards your stay, particularly if care support is included. We recommend speaking to your care coordinator or social worker in the first instance.\n\nWe are happy to provide documentation to support a funding application.",

		'res_grants_heading' => 'Grants and charities',
		'res_grants_body'    => "A number of charities offer grants specifically for people with disabilities and their carers to take a holiday. These include:\n\n- <a href=\"https://www.tourismforall.co.uk\" target=\"_blank\" rel=\"noopener\">Tourism for All</a>\n- <a href=\"https://familyfund.org.uk\" target=\"_blank\" rel=\"noopener\">Family Fund</a> (families with children who have disabilities or serious illnesses)\n- <a href=\"https://www.carers.org\" target=\"_blank\" rel=\"noopener\">Carers UK</a> (signposting to local grants)\n- Local authority short breaks / respite funding\n\nEligibility varies. We recommend checking each organisation\'s current criteria.",

		'res_chc_heading' => 'NHS Continuing Healthcare (CHC)',
		'res_chc_body'    => "If you or the person you care for receives NHS Continuing Healthcare, it may be possible to use some of that funding towards care support during your stay.\n\nThis is not straightforward and depends on your individual package. We recommend raising it with your NHS case manager or care coordinator.\n\nContinuity of Care Services, our care partner, can provide documentation to support a CHC application for care during your stay.",

		'res_complaints_heading' => 'Complaints and appeals',
		'res_complaints_body'    => "If a funding application is refused, you have the right to request a review. Local authorities are required to follow a formal review process.\n\nUseful resources:\n\n- <a href=\"https://www.disabilityrightsuk.org\" target=\"_blank\" rel=\"noopener\">Disability Rights UK</a>\n- <a href=\"https://www.lgo.org.uk\" target=\"_blank\" rel=\"noopener\">Local Government & Social Care Ombudsman</a>",

		'res_contacts_heading' => 'Key contacts',
		'res_contacts_body'    => "We have compiled a short list of organisations that may be helpful:\n\n- <strong>Continuity of Care Services</strong>, our care partner: <a href=\"https://www.continuitycareservices.co.uk\" target=\"_blank\" rel=\"noopener\">continuitycareservices.co.uk</a>\n- <strong>Care Quality Commission</strong>, CQC register: <a href=\"https://www.cqc.org.uk\" target=\"_blank\" rel=\"noopener\">cqc.org.uk</a>\n- <strong>Disability Rights UK</strong>: <a href=\"https://www.disabilityrightsuk.org\" target=\"_blank\" rel=\"noopener\">disabilityrightsuk.org</a>",

		'res_cta_heading' => 'Not sure where to start?',
		'res_cta_body'    => 'Get in touch and we will help you think through the options. We have helped guests navigate funding before and will point you in the right direction.',
		'res_cta_btn'     => 'Get in touch',
		'res_cta_url'     => '/enquire/',
	);
}

/**
 * Default meta for the Guest Guide page.
 */
function restwell_get_guest_guide_page_defaults() {
	return array(
		'gg_checkin_time'    => '2:00 pm',
		'gg_checkout_time'   => '11:00 am',
		'gg_house_rules'     => "Please treat the property with care; it is someone's home.\nNo smoking anywhere inside the property.\nPets are welcome, including assistance dogs. Please keep pets off the furniture.\nPlease lock all doors and close all windows when you go out.\nReport any damages as soon as possible.",
		'gg_departure_notes' => "Strip the beds and leave used linen in the laundry room.\nPlace all rubbish in the bins provided.\nReturn all keys and fobs to the key safe (location shared on arrival).\nClose all windows and lock all doors.\nLeave the property in a tidy condition. Thank you!",
		'gg_local_info'      => "Whitstable town centre is approximately 15 minutes on foot via a flat, paved route.\nTankerton promenade is about 15 minutes away on foot. The promenade itself is wide, level, and fully surfaced, suitable for wheelchairs and powerchairs. The grassy slopes above it are steep, so stick to the paved path along the seafront. Free parking is available along Marine Parade at the top.\nTesco Extra (Whitstable) is a 7-minute drive and has accessible parking, automatic doors, and a wheelchair-friendly layout.\nWheelchair and equipment hire is available locally; we can share details of trusted suppliers before your stay. Just ask.",
	);
}

/**
 * Default meta for the Who It's For page.
 */
function restwell_get_who_its_for_page_defaults() {
	return array(
		'wif_label'           => 'Who it is for',
		'wif_heading'         => 'Who Restwell is for',
		'wif_intro'           => 'Whether you are booking for yourself, someone you support, or a client, Restwell is designed to make planning straightforward and your stay comfortable. Here is how it works for different people.',
		'wif_hero_image_id'   => 0,
		'wif_family_title'    => 'For guests and families',
		'wif_family_body'     => '"Accessible" and "wheelchair friendly" are used loosely by a lot of accommodation. People book in good faith and arrive to find a step at the entrance, a bathroom that is too small to turn, or a hoist that is not actually there. Restwell works the other way: the ceiling track hoist is already fitted, the wet room has a roll-in shower with turning space, and every doorway and corridor is sized for a powerchair. The full measurements are published on our accessibility page. Check them before you enquire, not after. This is a private home, not a converted hotel room. No shared spaces, no clinical layout, and no surprises on arrival.',
		'wif_carers_title'    => 'For carers and support workers',
		'wif_carers_body'     => 'The ceiling hoist is already fitted, the wet room is designed for assisted personal care, and there is a separate sleeping area for the support worker. The layout is practical, not just manageable. If your client has complex needs, check the suitability details with us before you commit. We will give you specifics, not a brochure. One thing many carers do not know: you have a legal right to a Carer\'s Assessment under the Care Act 2014. Your local council must carry one out if you ask. It can open up direct payment routes to fund a holiday or short break, so it is worth requesting if you have not had one.',
		'wif_ot_title'        => 'For occupational therapists and case managers',
		'wif_ot_body'         => 'Our accessibility page publishes doorway widths, turning circle dimensions, ceiling track hoist specifications, profiling bed measurements, and wet room dimensions: the specifics that matter for a clinical recommendation. If you need something we have not published (transfer clearances, approach gradients, equipment positioning), ask and we will measure it. We understand a poor recommendation reflects on you. We would rather give you a straight answer than lose your trust, and we welcome referral conversations before any booking commitment.',
		'wif_commissioners_title' => 'For commissioners and social care teams',
		'wif_commissioners_body'  => 'Under the Care Act 2014, short breaks at a private adapted setting can be included in a care and support plan where the property meets the person\'s assessed needs. Restwell supports direct payment stays, personal health budgets, and CHC-funded packages. We can provide the documentation a referral process typically requires: property specification, access measurements, equipment inventory, and written confirmation of our connection to Continuity of Care Services, a CQC-registered provider. Most local authority funding decisions require evidence. We provide it.',
		'wif_visual_intro'    => 'Real photos help you judge fit before you book: layout, circulation space, and how equipment sits in the room. Pair these with our accessibility specification for verified measurements and features.',
		'wif_funding_heading' => 'How funding can work',
		'wif_funding_body'    => 'Many guests use direct payments, personal budgets, or CHC pathways. Most funded stays begin with a Care and Support Assessment, which is a right under the Care Act 2014. In Kent, that means contacting Kent County Council Adult Social Care. The three routes below explain how each pathway works.',
		'wif_cta_heading'     => 'Need to check suitability first?',
		'wif_cta_body'        => 'Tell us what you need and we will answer honestly, with no pressure.',
		'wif_cta_primary_label' => 'Read accessibility features',
		'wif_cta_primary_url'   => '/accessibility/',
		'wif_cta_secondary_label'=> 'Enquire about your dates',
		'wif_cta_secondary_url'  => '/enquire/',
	);
}

/**
 * Default meta for the Whitstable Guide page.
 */
function restwell_get_whitstable_guide_page_defaults() {
	return array(
		'wg_label'         => 'Whitstable & Kent coast',
		'wg_heading'       => 'A practical local guide for your stay.',
		'wg_intro'         => 'From seafront walks to nearby towns, here is where guests usually go, and what to think about if accessibility matters to your plans.',
		'wg_hero_image_id' => 0,
		'wg_about_heading' => 'About Whitstable',
		'wg_about_body'    => "Whitstable is a small coastal town known for its harbour, independent high street, and oysters. The town centre is compact and mostly flat, with a mix of cafes, pubs, galleries, and independent shops along Harbour Street and the high street.\nFor wheelchair users: most of the town centre is paved, but some older streets have uneven surfaces and narrow pavements. The harbour area is generally accessible, though parts near the fish market can be uneven or crowded at weekends. There is accessible public parking at Gorrell Tank car park (Canterbury City Council, pay and display) close to the high street.\nTankerton, just east of the town centre, has a wide, surfaced promenade that runs along the seafront: flat, smooth, and suitable for wheelchairs and powerchairs. Free parking is available along Marine Parade at the top. The grassy slopes between the road and the promenade are steep, so use the paved paths to reach the seafront. At low tide, a natural shingle spit called \"The Street\" appears and extends about 750 metres out to sea. It is interesting to see, but not accessible for wheelchair users as it is loose shingle.",
		'wg_towns_heading' => 'Nearby towns worth visiting',
		'wg_towns_body'    => "Canterbury (about 8 miles): the cathedral city. Good for a day out with shops, restaurants, and the cathedral itself. The city centre is mostly pedestrianised and largely flat, though some older streets are cobbled. There are several accessible car parks including the Whitefriars shopping centre. The cathedral has wheelchair access to most areas.\nFaversham (about 7 miles): a quieter market town with independent shops and pubs. The town centre is compact and mostly flat. Market days are Tuesday, Friday, and Saturday. A good option if you want a change of scene without a long drive.\nHerne Bay (about 4 miles): traditional seafront with a long, flat promenade that is fully paved and accessible. There is also a pier (partially rebuilt), amusement arcades, and fish and chips. An easy option for a couple of hours by the sea.",
		'wg_getting_here_heading' => 'Getting here',
		'wg_getting_here_body'    => "By car: Whitstable is reached via the M2 and A299 from London (about 60 miles, usually around 90 minutes depending on traffic). The property has off-street parking with enough space for adapted vehicles, including those with rear or side ramps.\nBy train: Whitstable station has direct services to London Victoria and London St Pancras (via Canterbury West or Faversham). Journey time is roughly 75-90 minutes. We do not verify station layout or platform access here; details change, so check National Rail Enquiries or your operator before you travel. From the station to the property is about a 10-minute drive; we can advise on taxi options if needed.",
		'wg_getting_around_heading' => 'Getting around during your stay',
		'wg_getting_around_body'    => "Most guests find a car is the easiest way to get around, especially if you need to transport equipment. The property parking is level and spacious.\nThe Stagecoach 400 bus runs between Whitstable and Canterbury and stops nearby. This route uses low-floor buses, but availability of the ramp and wheelchair space can vary; it is worth checking with Stagecoach before relying on it for a specific journey.\nIf you use a mobility scooter or powerchair, the Tankerton promenade and Whitstable seafront are both suitable surfaces. The town centre is mixed: some pavements are narrow or uneven in older parts.\nWheelchair hire is available locally. Ask us before your stay and we can share contact details for trusted suppliers in the area.",
		'wg_spotlight_image_1_id' => 0,
		'wg_spotlight_image_1_caption' => 'Tankerton promenade and sea-wall route',
		'wg_spotlight_image_2_id' => 0,
		'wg_spotlight_image_2_caption' => 'Whitstable harbour boardwalk and food huts',
		'wg_spotlight_image_3_id' => 0,
		'wg_spotlight_image_3_caption' => 'Town-centre route planning and practical stops',
		'wg_access_label'            => 'Accessibility notes',
		'wg_access_heading'          => 'Local routes with practical access context',
		'wg_access_intro'            => 'We focus on surfaces, slopes, and typical crowding so you can plan with confidence: not generic "accessible" labels.',
		'wg_spotlight_label'         => 'Visual guide',
		'wg_spotlight_heading'       => 'Key local areas at a glance',
		'wg_spotlight_intro'         => 'Photos help you picture routes and surfaces before you arrive.',
		'wg_related_label'           => 'Related reading',
		'wg_related_heading'         => 'Plan your stay with connected guides',
		'wg_related_intro'           => 'If you are comparing locations and practical suitability, these pages answer the next common questions.',
		'wg_planning_label'          => 'Planning notes',
		'wg_planning_heading'        => 'Useful details before you head out',
		'wg_planning_intro'          => 'A little planning helps avoid friction on the day, especially for accessibility and transport.',
		'wg_planning_before_heading' => 'Before you travel',
		'wg_planning_day_heading'    => 'On the day',
		'wg_planning_before_bullets' => "Check opening times and access details for specific venues: not all cafes and pubs in Whitstable have step-free access.\nBook accessible taxis in advance, especially for weekends and bank holidays.\nIf you have questions about routes, parking, or whether a specific place is accessible, ask us before you travel; we will find out if we do not already know.",
		'wg_planning_day_bullets'    => "Stick to promenade routes for level, predictable surfaces: the Tankerton promenade and Whitstable seafront are the most reliable.\nAllow extra time for parking near the harbour, especially on weekends and sunny days. Gorrell Tank car park usually has more availability than the harbour itself.\nKeep plans flexible around weather and tide conditions. The seafront is exposed and can be windy; bring layers.",
		'wg_eating_label'            => 'Eating out',
		'wg_eating_heading'          => 'Places to eat near the property',
		'wg_eating_intro'            => '',
		'wg_eating_body'             => "<strong>The Plough, Whitstable</strong>: a short walk from the property. Relaxed pub with a good food menu. Speak to us about accessibility on arrival as we have a direct contact there.\n<strong>Whitstable harbour</strong> has several fish and chip shops and seafood restaurants. Most are accessible at ground level, though space inside can be tight at peak times. Eating outside on the harbour wall is a good option in warmer weather.\n<strong>Tankerton Parade</strong> (along Marine Parade near the slopes) has a small cluster of independent cafes and a bakery. Generally quieter than the town centre.\nWe are happy to recommend other places based on your specific access needs; just ask before or during your stay.",
		'wg_cta_heading'         => 'Planning your coastal break?',
		'wg_cta_body'            => 'If you have dates in mind, get in touch and we will help you plan a stay that works for your access needs.',
		'wg_cta_primary_label'   => 'See the property',
		'wg_cta_primary_url'       => '/the-property/',
		'wg_cta_secondary_label'   => 'Ask about your dates',
		'wg_cta_secondary_url'     => '/enquire/',
		'wg_cta_blog_label'        => 'Read local articles',
		'wg_cta_blog_url'          => '/blog/',
	);
}

/**
 * Add Theme Setup under Appearance.
 */
function restwell_theme_setup_admin_menu() {
	add_theme_page(
		__( 'Theme Setup', 'restwell-retreats' ),
		__( 'Theme Setup', 'restwell-retreats' ),
		'manage_options',
		'restwell-theme-setup',
		'restwell_theme_setup_page'
	);
}
add_action( 'admin_menu', 'restwell_theme_setup_admin_menu' );

/**
 * Print long-cache guidance for theme static assets (server/CDN; not set by PHP).
 */
function restwell_theme_setup_performance_docs_section() {
	$slug = basename( get_template() );
	$path = '/wp-content/themes/' . $slug . '/assets/';
	$nginx_block = "location ~* ^{$path} {\n    expires 1y;\n    add_header Cache-Control \"public, max-age=31536000, immutable\";\n}";
	$apache_block = '<FilesMatch "\\.(css|js|woff2?|ttf|eot)$">' . "\n" . '    Header set Cache-Control "public, max-age=31536000, immutable"' . "\n" . '</FilesMatch>';
	?>
	<div class="card" style="max-width: 52rem; margin-top: 1.5rem;">
		<h2><?php esc_html_e( 'Performance: static assets & caching', 'restwell-retreats' ); ?></h2>
		<p><?php esc_html_e( 'After Theme Setup, WordPress regenerates responsive image sizes (unless you skip that step). For CSS/JS/fonts under the theme, set long cache lifetimes at the web server or CDN. Theme enqueue URLs include a version query string so updates bust caches.', 'restwell-retreats' ); ?></p>
		<p><strong><?php esc_html_e( 'Theme assets path (adjust for your install):', 'restwell-retreats' ); ?></strong> <code><?php echo esc_html( $path ); ?></code></p>
		<h3><?php esc_html_e( 'nginx (example location)', 'restwell-retreats' ); ?></h3>
		<pre style="overflow:auto; padding:12px; background:#f6f7f7; border:1px solid #c3c4c7;"><?php echo esc_html( $nginx_block ); ?></pre>
		<h3><?php esc_html_e( 'Apache (prefer server or vhost config; .htaccess in the theme is not loaded for asset requests)', 'restwell-retreats' ); ?></h3>
		<pre style="overflow:auto; padding:12px; background:#f6f7f7; border:1px solid #c3c4c7;"><?php echo esc_html( $apache_block ); ?></pre>
		<p class="description"><?php esc_html_e( 'Requires mod_headers (and related modules) as appropriate. Page caching remains a separate plugin or host feature.', 'restwell-retreats' ); ?></p>
	</div>
	<?php
}

/**
 * Render the Theme Setup admin page and handle POST.
 */
function restwell_theme_setup_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'restwell-retreats' ) );
	}

	$message = '';
	$already_seeded = restwell_theme_setup_is_seeded();

	// Handle form submission.
	if ( isset( $_POST[ RESTWELL_SETUP_NONCE_NAME ] ) && isset( $_POST['restwell_run_setup'] ) ) {
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ RESTWELL_SETUP_NONCE_NAME ] ) ), RESTWELL_SETUP_NONCE_ACTION ) ) {
			$message = '<div class="notice notice-error"><p>' . esc_html__( 'Security check failed. Please try again.', 'restwell-retreats' ) . '</p></div>';
		} else {
			$force            = ! empty( $_POST['restwell_rerun'] );
			$skip_image_regen = ! empty( $_POST['restwell_skip_image_regen'] );
			$result           = restwell_run_theme_setup( $force, $skip_image_regen );
			$message          = restwell_theme_setup_format_message( $result );
		}
	}

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Restwell Theme Setup', 'restwell-retreats' ); ?></h1>

		<?php echo $message; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped - built from escaped fragments ?>

		<div class="notice notice-warning">
			<p><?php esc_html_e( 'Creates missing pages and fills default content. Re-running merges any new theme default fields into pages where those keys are not stored yet; use “Re-run setup anyway” to overwrite Home and template page fields from current theme defaults.', 'restwell-retreats' ); ?></p>
		</div>

		<?php if ( $already_seeded ) : ?>
			<div class="notice notice-info">
				<p><?php esc_html_e( 'Setup already completed.', 'restwell-retreats' ); ?></p>
			</div>
		<?php endif; ?>

		<form method="post" action="">
			<?php wp_nonce_field( RESTWELL_SETUP_NONCE_ACTION, RESTWELL_SETUP_NONCE_NAME ); ?>
			<?php if ( $already_seeded ) : ?>
				<p>
					<label>
						<input type="checkbox" name="restwell_rerun" value="1" />
						<?php esc_html_e( 'Re-run setup anyway (re-seeds content and overwrites SEO title, meta description, and focus keyphrase from theme defaults). Responsive image regeneration still runs unless you skip it below.', 'restwell-retreats' ); ?>
					</label>
				</p>
			<?php endif; ?>
			<p>
				<label>
					<input type="checkbox" name="restwell_skip_image_regen" value="1" />
					<?php esc_html_e( 'Skip regenerating responsive image sizes (restwell-hero, restwell-cta-bg) for all uploads. Use if this request might time out on a very large Media Library; you can run wp media regenerate later.', 'restwell-retreats' ); ?>
				</label>
			</p>
			<p>
				<button type="submit" name="restwell_run_setup" value="1" class="button button-primary">
					<?php esc_html_e( 'Run Theme Setup', 'restwell-retreats' ); ?>
				</button>
			</p>
		</form>

		<?php restwell_theme_setup_performance_docs_section(); ?>
	</div>
	<?php
}

/**
 * Check if front page has been seeded (setup already run).
 */
function restwell_theme_setup_is_seeded() {
	$page_id = (int) get_option( 'page_on_front', 0 );
	if ( $page_id < 1 ) {
		return false;
	}
	return get_post_meta( $page_id, 'restwell_fields_seeded', true ) === '1';
}

/**
 * Return the URL for a theme logo, preferring the Media Library attachment.
 *
 * Falls back to the bundled file in /assets/images/ when the attachment ID has
 * not yet been stored (i.e. setup hasn't been run) or the attachment is missing.
 *
 * @param string $mod_key          Theme mod key, e.g. 'restwell_logo_long_id'.
 * @param string $fallback_filename Filename inside /assets/images/.
 * @return string Fully-qualified URL.
 */
function restwell_get_logo_url( $mod_key, $fallback_filename ) {
	$att_id = (int) get_theme_mod( $mod_key, 0 );
	if ( $att_id > 0 ) {
		$url = wp_get_attachment_url( $att_id );
		if ( $url ) {
			return $url;
		}
	}
	return get_template_directory_uri() . '/assets/images/' . $fallback_filename;
}

/**
 * Canonical brand lockup for the horizontal logo (matches “Restwell by …” in long_logo artwork).
 *
 * @return string Translatable site brand line.
 */
function restwell_site_brand_lockup() {
	return __( 'Restwell by Continuity of Care Services', 'restwell-retreats' );
}

/**
 * Sideload the three theme logos into the Media Library and store attachment IDs
 * as theme mods. Idempotent; skips files already uploaded.
 *
 * Theme mods set:
 *   restwell_logo_long_id     → long_logo.png  (horizontal, used in header/footer)
 *   restwell_logo_stacked_id  → logo.png        (stacked, available for custom use)
 *   restwell_logo_infinity_id → restwellinfinity.png  (icon only, available for custom use)
 *
 * @param array $result Result array passed by reference; keys logos_uploaded,
 *                      logos_skipped, logos_missing, logos_failed are appended.
 */
function restwell_upload_theme_logos( array &$result ) {
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$logos = array(
		'restwell_logo_long_id'     => 'long_logo.png',
		'restwell_logo_stacked_id'  => 'logo.png',
		'restwell_logo_infinity_id' => 'restwellinfinity.png',
	);

	foreach ( $logos as $mod_key => $filename ) {
		// Already uploaded: verify the attachment still exists in the DB.
		$existing_id = (int) get_theme_mod( $mod_key, 0 );
		if ( $existing_id > 0 && get_post( $existing_id ) ) {
			$result['logos_skipped'][] = $filename;
			continue;
		}

		$file_path = get_template_directory() . '/assets/images/' . $filename;
		if ( ! file_exists( $file_path ) ) {
			$result['logos_missing'][] = $filename;
			continue;
		}

		// Copy to a temp path; media_handle_sideload moves/deletes the tmp file.
		$tmp = wp_tempnam( $filename );
		// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		if ( ! @copy( $file_path, $tmp ) ) {
			$result['logos_failed'][] = $filename;
			continue;
		}

		$att_id = media_handle_sideload(
			array(
				'name'     => $filename,
				'tmp_name' => $tmp,
			),
			0,
			''
		);

		if ( is_wp_error( $att_id ) ) {
			// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			@unlink( $tmp );
			$result['logos_failed'][] = $filename;
		} else {
			set_theme_mod( $mod_key, $att_id );
			$result['logos_uploaded'][] = $filename;
		}
	}
}

/**
 * Run theme setup: create pages, set front page, seed Home meta.
 *
 * @param bool $force               If true, re-seed Home and page content where supported, refresh seeded blog posts, and overwrite SEO meta from theme defaults.
 * @param bool $skip_image_regen    If true, skip regenerating image subsizes (restwell-hero, restwell-cta-bg) for all attachments.
 * @return array<string, mixed> Setup result (created, skipped, seo_meta_applied, seo_meta_forced, etc.).
 */
function restwell_run_theme_setup( $force = false, $skip_image_regen = false ) {
	$result = array(
		'created'            => array(),
		'skipped'            => array(),
		'front_page_set'     => false,
		'posts_page_set'     => false,
		'home_seeded'           => false,
		'home_meta_keys_written'  => 0,
		'home_additive_only'      => false,
		'pages_seeded'       => array(),
		'pages_seed_skipped' => array(),
		'hub_seeded'         => array(),
		'seo_meta_applied'   => false,
		'seo_meta_forced'    => false,
		'blog_posts_seeded'  => array(),
		'blog_posts_failed'  => array(),
		'logos_uploaded'     => array(),
		'logos_skipped'      => array(),
		'logos_missing'      => array(),
		'logos_failed'         => array(),
		'image_regen_skipped'  => false,
		'image_regen'          => null,
	);

	$pages = restwell_get_theme_setup_pages();
	$created_ids = array();

	$page_templates = array(
		'The Property'       => 'template-property.php',
		'How It Works'       => 'template-how-it-works.php',
		'Accessibility'      => 'template-accessibility.php',
		'Who It\'s For'      => 'template-who-its-for.php',
		'Whitstable Guide'   => 'template-whitstable-guide.php',
		'FAQ'                => 'template-faq.php',
		'Enquire'            => 'template-enquire.php',
		'Resources'          => 'template-resources.php',
		'Guest Guide'          => 'page-guest-guide.php',
		'Privacy Policy'       => 'template-privacy-policy.php',
		'Terms & Conditions'   => 'template-terms-and-conditions.php',
		'Accessibility Policy' => 'template-accessibility-policy.php',
	);

	foreach ( $pages as $title => $slug ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $existing ) {
			$result['skipped'][] = $title;
			$created_ids[ $title ] = $existing->ID;
		} else {
			$id = wp_insert_post(
				array(
					'post_title'   => $title,
					'post_name'    => $slug,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_author'  => get_current_user_id(),
				),
				true
			);
			if ( ! is_wp_error( $id ) ) {
				$result['created'][] = $title;
				$created_ids[ $title ] = $id;
			}
		}
		// Assign page template so custom templates and meta fields are used.
		if ( isset( $created_ids[ $title ] ) && isset( $page_templates[ $title ] ) ) {
			update_post_meta( $created_ids[ $title ], '_wp_page_template', $page_templates[ $title ] );
		}
	}

	$home_id = isset( $created_ids['Home'] ) ? (int) $created_ids['Home'] : 0;
	if ( $home_id < 1 ) {
		$home_page = get_page_by_path( 'home', OBJECT, 'page' );
		$home_id   = $home_page ? (int) $home_page->ID : 0;
	}

	if ( $home_id > 0 ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
		$result['front_page_set'] = true;

		$home_was_seeded = get_post_meta( $home_id, 'restwell_fields_seeded', true ) === '1';

		$home_defaults           = restwell_get_theme_setup_defaults();
		$home_meta_keys_written  = restwell_merge_theme_defaults_into_post_meta( $home_id, $home_defaults, $force );
		$result['home_meta_keys_written'] = $home_meta_keys_written;
		$result['home_additive_only']     = $home_was_seeded && ! $force && $home_meta_keys_written > 0;
		if ( $home_meta_keys_written > 0 ) {
			update_post_meta( $home_id, 'restwell_fields_seeded', '1' );
			$result['home_seeded'] = true;
		}

	}

	// Seed meta defaults for all non-Home template pages.
	restwell_seed_all_pages_meta( $created_ids, $force, $result );

	// Hub pages (Who it's for, Whitstable guide) + blog archive excerpt.
	restwell_seed_hub_pages_content( $created_ids, $force, $result );

	// Posts page: blog archive at /blog/.
	$blog_id = isset( $created_ids['Blog'] ) ? (int) $created_ids['Blog'] : 0;
	if ( $blog_id < 1 ) {
		$blog_page = get_page_by_path( 'blog', OBJECT, 'page' );
		$blog_id   = $blog_page ? (int) $blog_page->ID : 0;
	}
	if ( $blog_id > 0 ) {
		update_option( 'page_for_posts', $blog_id );
		$result['posts_page_set'] = true;
	}

	// SEO defaults: fill empty fields always; overwrite when $force (re-run setup) is true.
	restwell_apply_seo_meta_to_pages( $force );
	$result['seo_meta_applied'] = true;
	$result['seo_meta_forced']  = $force;

	// Priority blog posts (idempotent; pass $force so re-run updates content).
	restwell_seed_priority_blog_posts( $result, $force );

	// Upload logos to Media Library so templates can use stable attachment URLs.
	restwell_upload_theme_logos( $result );

	// Build restwell-hero / restwell-cta-bg (and other registered sizes) for every image; runs on Theme Setup unless skipped.
	$run_regen = ! $skip_image_regen && apply_filters( 'restwell_theme_setup_run_image_subsize_regen', true, $force );
	$result['image_regen_skipped'] = ! $run_regen;
	if ( $run_regen && function_exists( 'restwell_regenerate_all_image_subsizes' ) ) {
		$result['image_regen'] = restwell_regenerate_all_image_subsizes();
	}

	return $result;
}

/**
 * Public contact email for policies and footers (matches enquiry notify default).
 *
 * @return string Valid email address.
 */
function restwell_get_public_enquiry_email(): string {
	$e = (string) get_option( 'restwell_enquiry_notify_email', '' );
	if ( $e && function_exists( 'is_email' ) && is_email( $e ) ) {
		return $e;
	}
	return 'hello@restwellretreats.co.uk';
}

/**
 * Registered / trading name for legal copy (same option as footer copyright).
 *
 * @return string Plain text (escape when outputting in HTML).
 */
function restwell_get_legal_entity_display_name(): string {
	return (string) get_option(
		'restwell_footer_legal_name',
		__( 'Homely Housing Investments Ltd t/a Restwell Retreats', 'restwell-retreats' )
	);
}

/**
 * Site hostname for policy text (avoids hardcoding the production domain).
 *
 * @return string Hostname only, no scheme.
 */
function restwell_get_public_site_host(): string {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	return is_string( $host ) && $host !== '' ? $host : 'restwellretreats.co.uk';
}

/**
 * Returns minimal Privacy Policy body HTML (used by template-privacy-policy when legal_body_html is empty).
 *
 * @return string HTML string.
 */
function restwell_get_privacy_policy_content(): string {
	$site        = esc_html( get_bloginfo( 'name' ) );
	$entity      = esc_html( restwell_get_legal_entity_display_name() );
	$email       = restwell_get_public_enquiry_email();
	$mailto_href = esc_url( 'mailto:' . $email );

	return '<h2>Who we are</h2>
<p>' . $site . ' ("we", "us", "our") offers accessible holiday accommodation in Whitstable, Kent. This website is published at ' . esc_url( home_url( '/' ) ) . '.</p>
<p>The data controller for personal information collected through this site is ' . $entity . '.</p>

<h2>What information we collect and why</h2>
<p>When you use our enquiry form we collect: your name, email address, phone number, and any care or accessibility information you choose to share. We use this on the basis of our legitimate interests to respond to your enquiry and, if you go on to book, to perform the contract for your stay.</p>
<p>We do not sell your personal information. We share it only with our care partner, Continuity of Care Services (CQC-regulated), when care support is part of your booking and you have agreed to that arrangement.</p>

<h2>Cookies and analytics</h2>
<p>We use cookies for essential site functionality and, where you consent, for analytics (Google Analytics 4). You can change preferences using the cookie controls shown on your first visit.</p>

<h2>How long we keep your data</h2>
<p>We keep enquiry and booking-related records for up to three years so we can answer follow-up questions and meet regulatory and insurance expectations. You can ask us to delete your data sooner where the law allows.</p>

<h2>Your rights</h2>
<p>Under UK GDPR you may: ask what data we hold about you; ask us to correct mistakes; ask us to delete or restrict use of your data in certain cases; object to some processing; and complain to the <a href="https://www.ico.org.uk/" target="_blank" rel="noopener noreferrer">Information Commissioner\'s Office (ICO)<span class="sr-only"> (opens in new tab)</span></a>.</p>
<p>To exercise these rights, email <a href="' . $mailto_href . '">' . esc_html( $email ) . '</a>.</p>

<h2>Changes to this policy</h2>
<p>We may update this policy from time to time. The current version is always on this page. Last updated: ' . esc_html( gmdate( 'F Y' ) ) . '.</p>';
}

/**
 * Returns minimal Terms & Conditions body HTML (used by template-terms-and-conditions when legal_body_html is empty).
 *
 * @return string HTML string.
 */
function restwell_get_terms_conditions_content(): string {
	$site    = esc_html( get_bloginfo( 'name' ) );
	$entity  = esc_html( restwell_get_legal_entity_display_name() );
	$enquire = esc_url( home_url( '/enquire/' ) );
	$email   = restwell_get_public_enquiry_email();
	$mailto  = esc_url( 'mailto:' . $email );

	return '<h2>Booking</h2>
<p>These terms apply when you book accessible self-catering accommodation with ' . $entity . ' (trading as "' . $site . '") in Whitstable, Kent. A booking is confirmed only when we have received a signed booking form and any deposit we ask for, and we have sent you written confirmation. All stays are subject to availability.</p>

<h2>Payment</h2>
<p>A non-refundable deposit (the amount is confirmed when you book) secures your dates. The balance is due six weeks before arrival unless we agree otherwise in writing. We accept BACS bank transfer and debit or credit card.</p>

<h2>Cancellation</h2>
<p>If you cancel more than six weeks before arrival you forfeit the deposit. If you cancel within six weeks of arrival the full balance remains payable unless we re-let the property. We strongly recommend travel and cancellation insurance.</p>

<h2>Care support</h2>
<p>Optional care may be arranged with Continuity of Care Services (CQC-regulated). Their terms and privacy notices apply to the care they deliver. We introduce the service only and are not responsible for how care is provided.</p>

<h2>Liability</h2>
<p>Except where the law does not allow us to limit liability, ' . $entity . ' is not liable for loss, damage, or injury to guests or their belongings during the stay except where caused by our negligence. Guests should hold appropriate travel and medical insurance.</p>

<h2>Contact</h2>
<p>Questions about these terms? Use <a href="' . $enquire . '">our enquiry page</a> or email <a href="' . $mailto . '">' . esc_html( $email ) . '</a>.</p>

<p><em>Last updated: ' . esc_html( gmdate( 'F Y' ) ) . '.</em></p>';
}

/**
 * Website accessibility statement body HTML (template-accessibility-policy).
 *
 * @return string HTML string.
 */
function restwell_get_accessibility_policy_content(): string {
	$site   = esc_html( get_bloginfo( 'name' ) );
	$host   = esc_html( restwell_get_public_site_host() );
	$acc    = esc_url( home_url( '/accessibility/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );
	$email  = restwell_get_public_enquiry_email();
	$mailto = esc_url( 'mailto:' . $email );

	return '<h2>Our aim</h2>
<p>' . $site . ' aims to make ' . $host . ' as easy to use and understand as we can for guests, families, carers, and professionals. We aim to meet Web Content Accessibility Guidelines (WCAG) 2.2 Level AA where it is reasonably practicable for our pages, forms, and theme.</p>

<h2>How we test</h2>
<p>We combine automated checks with manual testing: keyboard-only navigation, text zoom to at least 200%, and common browser and screen reader pairings. We fix issues we can control when we update the site.</p>

<h2>Property access information</h2>
<p>Door widths, equipment, and room layout for the bungalow are on our <a href="' . $acc . '">accessibility specification</a> page. This statement is about the website, not the bricks-and-mortar property.</p>

<h2>Third-party content</h2>
<p>Some pages include embedded maps, video, or links to other organisations. We cannot guarantee how accessible those services are. If something blocks you, tell us and we will try to provide an alternative where we can.</p>

<h2>Feedback and help</h2>
<p>If any part of this site does not work for you, or you need information in another format, email <a href="' . $mailto . '">' . esc_html( $email ) . '</a> or use our <a href="' . $enq . '">enquiry form</a>. We aim to reply within one working day.</p>

<h2>Formal complaints</h2>
<p>If you are not satisfied with our response, the <a href="https://www.equalityhumanrights.com/en" target="_blank" rel="noopener noreferrer">Equality and Human Rights Commission (EHRC)<span class="sr-only"> (opens in new tab)</span></a> publishes guidance on accessibility rights in England, Scotland, and Wales.</p>

<p><em>Last updated: ' . esc_html( gmdate( 'F Y' ) ) . '.</em></p>';
}

/**
 * Default Page Content Fields for Privacy Policy template.
 *
 * @return array<string, mixed>
 */
function restwell_get_privacy_policy_page_defaults() {
	return array(
		'legal_label'         => 'Your information',
		'legal_heading'       => 'Privacy Policy',
		'legal_intro'         => 'Who is responsible for your data, what we collect when you enquire or book, cookies, retention, and your UK GDPR rights (including contacting the ICO).',
		'legal_hero_image_id' => 0,
		'legal_body_html'     => '',
	);
}

/**
 * Default Page Content Fields for Terms & Conditions template.
 *
 * @return array<string, mixed>
 */
function restwell_get_terms_conditions_page_defaults() {
	return array(
		'legal_label'         => 'Bookings',
		'legal_heading'       => 'Terms & Conditions',
		'legal_intro'         => 'Deposit, balance, cancellation, optional care via Continuity of Care Services, and liability for stays at our Whitstable accessible bungalow.',
		'legal_hero_image_id' => 0,
		'legal_body_html'     => '',
	);
}

/**
 * Default Page Content Fields for Accessibility Policy (website statement) template.
 *
 * @return array<string, mixed>
 */
function restwell_get_accessibility_policy_page_defaults() {
	return array(
		'legal_label'         => 'Digital access',
		'legal_heading'       => 'Website accessibility statement',
		'legal_intro'         => 'WCAG-oriented testing, known limits of third-party embeds, and how to request alternative formats or report a barrier.',
		'legal_hero_image_id' => 0,
		'legal_body_html'     => '',
	);
}

/**
 * Seed default meta for every template page except Home (which is handled above).
 *
 * Adds keys to $result: 'pages_seeded' and 'pages_seed_skipped'.
 *
 * @param array $created_ids Map of page title => post ID from the setup run.
 * @param bool  $force       Re-seed even if already seeded.
 * @param array $result      Result array passed by reference.
 */
function restwell_seed_all_pages_meta( array $created_ids, $force, array &$result ) {
	$page_defaults_map = array(
		'The Property'  => 'restwell_get_property_page_defaults',
		'How It Works'  => 'restwell_get_how_it_works_page_defaults',
		'Accessibility' => 'restwell_get_accessibility_page_defaults',
		'Who It\'s For' => 'restwell_get_who_its_for_page_defaults',
		'Whitstable Guide' => 'restwell_get_whitstable_guide_page_defaults',
		'FAQ'           => 'restwell_get_faq_page_defaults',
		'Enquire'       => 'restwell_get_enquire_page_defaults',
		'Resources'     => 'restwell_get_resources_page_defaults',
		'Guest Guide'          => 'restwell_get_guest_guide_page_defaults',
		'Privacy Policy'       => 'restwell_get_privacy_policy_page_defaults',
		'Terms & Conditions'   => 'restwell_get_terms_conditions_page_defaults',
		'Accessibility Policy' => 'restwell_get_accessibility_policy_page_defaults',
	);

	foreach ( $page_defaults_map as $title => $defaults_fn ) {
		// Resolve the page ID: prefer the ID from this run, then look it up.
		$page_id = isset( $created_ids[ $title ] ) ? (int) $created_ids[ $title ] : 0;
		if ( $page_id < 1 ) {
			$slug = sanitize_title( $title );
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			$page_id = $page ? (int) $page->ID : 0;
		}
		if ( $page_id < 1 ) {
			continue;
		}

		if ( ! is_callable( $defaults_fn ) ) {
			continue;
		}

		$defaults = call_user_func( $defaults_fn );
		$n        = restwell_merge_theme_defaults_into_post_meta( $page_id, $defaults, $force );
		if ( $n > 0 ) {
			update_post_meta( $page_id, 'restwell_fields_seeded', '1' );
			$result['pages_seeded'][] = $title;
		} elseif ( ! $force ) {
			$result['pages_seed_skipped'][] = $title;
		}
	}
}

/**
 * Format setup result as an admin notice.
 *
 * @param array $result Result from restwell_run_theme_setup().
 * @return string HTML for the notice.
 */
function restwell_theme_setup_format_message( $result ) {
	$lines = array();

	if ( ! empty( $result['created'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Created pages:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['created'] ) );
	}
	if ( ! empty( $result['skipped'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Skipped (already exist):', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['skipped'] ) );
	}
	if ( $result['front_page_set'] ) {
		$lines[] = esc_html__( 'Home set as static front page.', 'restwell-retreats' );
	}
	if ( $result['home_seeded'] ) {
		$n          = isset( $result['home_meta_keys_written'] ) ? (int) $result['home_meta_keys_written'] : 0;
		$additive   = ! empty( $result['home_additive_only'] );
		if ( $additive && $n > 0 ) {
			/* translators: %d: number of meta keys written from theme defaults */
			$lines[] = sprintf( esc_html__( 'Home page: %d new default field(s) merged from theme (existing values unchanged).', 'restwell-retreats' ), $n );
		} else {
			$lines[] = esc_html__( 'Default content seeded on Home page.', 'restwell-retreats' );
		}
	}
	if ( ! empty( $result['pages_seeded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Page content seeded:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['pages_seeded'] ) );
	}
	if ( ! empty( $result['pages_seed_skipped'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Template pages: no missing default fields (unchanged):', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['pages_seed_skipped'] ) );
	}
	if ( ! empty( $result['logos_uploaded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Logos uploaded to Media Library:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['logos_uploaded'] ) );
	}
	if ( ! empty( $result['logos_skipped'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Logos already in Media Library:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['logos_skipped'] ) );
	}
	if ( ! empty( $result['logos_missing'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Logo files not found in theme:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['logos_missing'] ) );
	}
	if ( ! empty( $result['logos_failed'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Logo upload failed:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['logos_failed'] ) );
	}
	if ( ! empty( $result['posts_page_set'] ) ) {
		$lines[] = esc_html__( 'Blog page set as the posts archive (Posts page).', 'restwell-retreats' );
	}
	if ( ! empty( $result['hub_seeded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Hub / blog content updated:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['hub_seeded'] ) );
	}
	if ( ! empty( $result['seo_meta_applied'] ) ) {
		if ( ! empty( $result['seo_meta_forced'] ) ) {
			$lines[] = esc_html__( 'SEO title, meta description, and focus keyphrases were refreshed from theme defaults (re-run).', 'restwell-retreats' );
		} else {
			$lines[] = esc_html__( 'SEO title and description defaults applied where fields were empty.', 'restwell-retreats' );
		}
	}
	if ( ! empty( $result['blog_posts_seeded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Blog posts created:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['blog_posts_seeded'] ) );
	}
	if ( ! empty( $result['blog_posts_failed'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Blog post seed failed (slug):', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['blog_posts_failed'] ) );
	}

	if ( ! empty( $result['image_regen_skipped'] ) ) {
		$lines[] = esc_html__( 'Responsive image regeneration was skipped (checkbox). Use Theme Setup again or run wp media regenerate on the server.', 'restwell-retreats' );
	} elseif ( ! empty( $result['image_regen'] ) && is_array( $result['image_regen'] ) ) {
		$ir = $result['image_regen'];
		/* translators: %d: number of attachments processed */
		$lines[] = sprintf( esc_html__( 'Responsive image sizes updated for %d image(s) (restwell-hero, restwell-cta-bg, etc.).', 'restwell-retreats' ), (int) ( $ir['processed'] ?? 0 ) );
		if ( ! empty( $ir['errors'] ) ) {
			/* translators: %d: error count */
			$lines[] = sprintf( esc_html__( 'Image regeneration reported %d error(s). Check file permissions and disk space.', 'restwell-retreats' ), (int) $ir['errors'] );
			if ( ! empty( $ir['error_samples'] ) ) {
				$lines[] = esc_html( implode( ' ', $ir['error_samples'] ) );
			}
		}
	}

	if ( empty( $lines ) ) {
		return '<div class="notice notice-warning"><p>' . esc_html__( 'No changes made. Home page may be missing.', 'restwell-retreats' ) . '</p></div>';
	}

	return '<div class="notice notice-success"><p>' . implode( '<br />', $lines ) . '</p></div>';
}

/**
 * One-time seed for homepage FAQ post meta (sites that already had restwell_fields_seeded before FAQ keys existed).
 *
 * Fills only keys that do not exist yet so editor changes are preserved.
 */
function restwell_migrate_homepage_faq_meta_v1() {
	if ( get_option( 'restwell_home_faq_meta_migrated_v1', '' ) === '1' ) {
		return;
	}
	if ( ! function_exists( 'restwell_get_homepage_faq_meta_seed_map' ) ) {
		return;
	}
	$home_id = (int) get_option( 'page_on_front', 0 );
	if ( $home_id < 1 ) {
		return;
	}

	$map = restwell_get_homepage_faq_meta_seed_map();
	foreach ( $map as $key => $value ) {
		if ( metadata_exists( 'post', $home_id, $key ) ) {
			continue;
		}
		update_post_meta( $home_id, $key, $value );
	}

	update_option( 'restwell_home_faq_meta_migrated_v1', '1' );
}
add_action( 'admin_init', 'restwell_migrate_homepage_faq_meta_v1', 5 );
add_action( 'after_switch_theme', 'restwell_migrate_homepage_faq_meta_v1', 10 );

/**
 * One-time refresh of Property page practical-stats meta for sites seeded with TBC / long parking copy.
 *
 * Only overwrites values that still match the old placeholders so manual edits stay intact.
 */
function restwell_migrate_property_practical_meta_v1() {
	if ( get_option( 'restwell_property_practical_meta_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}
	$page_id  = (int) $page->ID;
	$defaults = restwell_get_property_page_defaults();

	$is_tbc = static function ( $val ) {
		return is_string( $val ) && strcasecmp( trim( $val ), 'TBC' ) === 0;
	};

	foreach ( array( 'prop_bedrooms_count', 'prop_bathrooms_count', 'prop_sleeps_value' ) as $key ) {
		$cur = get_post_meta( $page_id, $key, true );
		if ( $is_tbc( $cur ) && isset( $defaults[ $key ] ) ) {
			update_post_meta( $page_id, $key, $defaults[ $key ] );
		}
	}

	$park_cur = (string) get_post_meta( $page_id, 'prop_parking', true );
	$park_old = 'Private driveway, two cars';
	if ( $is_tbc( $park_cur ) || trim( $park_cur ) === $park_old ) {
		update_post_meta( $page_id, 'prop_parking', $defaults['prop_parking'] ?? '2 cars' );
	}

	foreach ( array( 'prop_bedrooms', 'prop_bathroom' ) as $key ) {
		$cur = get_post_meta( $page_id, $key, true );
		$old_bed = 'Bedroom configuration confirmed before booking';
		$old_bath = 'Bathroom configuration confirmed before booking';
		if ( $key === 'prop_bedrooms' && is_string( $cur ) && trim( $cur ) === $old_bed && isset( $defaults[ $key ] ) ) {
			update_post_meta( $page_id, $key, $defaults[ $key ] );
		}
		if ( $key === 'prop_bathroom' && is_string( $cur ) && trim( $cur ) === $old_bath && isset( $defaults[ $key ] ) ) {
			update_post_meta( $page_id, $key, $defaults[ $key ] );
		}
	}

	update_option( 'restwell_property_practical_meta_v1', '1' );
}
add_action( 'init', 'restwell_migrate_property_practical_meta_v1', 20 );
add_action( 'after_switch_theme', 'restwell_migrate_property_practical_meta_v1', 10 );

/**
 * One-time: set sleeps to 5 for sites that received the earlier default of 6.
 */
function restwell_migrate_property_sleeps_five_v1() {
	if ( get_option( 'restwell_property_sleeps_five_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}
	$page_id = (int) $page->ID;
	$cur     = get_post_meta( $page_id, 'prop_sleeps_value', true );
	if ( is_string( $cur ) && trim( $cur ) === '6' ) {
		update_post_meta( $page_id, 'prop_sleeps_value', '5' );
	}
	update_option( 'restwell_property_sleeps_five_v1', '1' );
}
add_action( 'init', 'restwell_migrate_property_sleeps_five_v1', 21 );
add_action( 'after_switch_theme', 'restwell_migrate_property_sleeps_five_v1', 11 );

/**
 * One-time: shorten parking strip text (private drive wording was too long for the grid on small screens).
 */
function restwell_migrate_property_parking_short_v1() {
	if ( get_option( 'restwell_property_parking_short_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}
	$page_id = (int) $page->ID;
	$cur     = trim( (string) get_post_meta( $page_id, 'prop_parking', true ) );
	$short   = '2 cars';
	$legacy  = array(
		'Private drive · 2 cars',
		'Private drive • 2 cars',
		'Private driveway, two cars',
		'Private driveway, 2 cars',
		'Private drive, 2 cars',
		'Private drive, two cars',
	);
	if ( in_array( $cur, $legacy, true ) ) {
		update_post_meta( $page_id, 'prop_parking', $short );
	}
	update_option( 'restwell_property_parking_short_v1', '1' );
}
add_action( 'init', 'restwell_migrate_property_parking_short_v1', 22 );
add_action( 'after_switch_theme', 'restwell_migrate_property_parking_short_v1', 12 );

/**
 * One-time: assign dedicated legal / policy templates and ensure Accessibility Policy page exists.
 *
 * Existing installs keep their Privacy and Terms pages at the same URLs; post_content is no longer
 * used for the default copy (templates + Page Content Fields / theme defaults instead).
 */
function restwell_migrate_legal_policy_templates_v1() {
	if ( get_option( 'restwell_legal_policy_templates_v1', '' ) === '1' ) {
		return;
	}

	$assign = static function ( $slug, $template_file ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page && (int) $page->ID > 0 ) {
			update_post_meta( (int) $page->ID, '_wp_page_template', $template_file );
		}
	};

	$assign( 'privacy-policy', 'template-privacy-policy.php' );
	$assign( 'terms-and-conditions', 'template-terms-and-conditions.php' );

	$ap = get_page_by_path( 'accessibility-policy', OBJECT, 'page' );
	if ( ! $ap ) {
		$admins = get_users(
			array(
				'role'   => 'administrator',
				'number' => 1,
				'fields' => 'ID',
			)
		);
		$author_id = ! empty( $admins[0] ) ? (int) $admins[0] : 1;

		$new_id = wp_insert_post(
			array(
				'post_title'   => 'Accessibility Policy',
				'post_name'    => 'accessibility-policy',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => $author_id,
				'post_content' => '',
			),
			true
		);
		if ( ! is_wp_error( $new_id ) && $new_id > 0 ) {
			update_post_meta( (int) $new_id, '_wp_page_template', 'template-accessibility-policy.php' );
			if ( function_exists( 'restwell_merge_theme_defaults_into_post_meta' ) && function_exists( 'restwell_get_accessibility_policy_page_defaults' ) ) {
				restwell_merge_theme_defaults_into_post_meta( (int) $new_id, restwell_get_accessibility_policy_page_defaults(), false );
				update_post_meta( (int) $new_id, 'restwell_fields_seeded', '1' );
			}
		}
	} else {
		update_post_meta( (int) $ap->ID, '_wp_page_template', 'template-accessibility-policy.php' );
	}

	update_option( 'restwell_legal_policy_templates_v1', '1' );
}
add_action( 'init', 'restwell_migrate_legal_policy_templates_v1', 12 );
add_action( 'after_switch_theme', 'restwell_migrate_legal_policy_templates_v1', 12 );
