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
		'Contact'            => 'contact',
		'Resources'          => 'resources',
		'Whitstable Guide'   => 'whitstable-area-guide',
		'Blog'               => 'blog',
		'Guest Guide'        => 'guest-guide',
		'Privacy Policy'     => 'privacy-policy',
		'Terms & Conditions' => 'terms-and-conditions',
	);
}

/**
 * Default meta values for the front page (Home).
 */
function restwell_get_theme_setup_defaults() {
	return array(
		'hero_eyebrow'             => 'Accessible holiday cottage · Whitstable, Kent',
		'hero_heading'             => 'A proper holiday. Adapted and practical.',
		'hero_subheading'          => 'A private, fully adapted holiday home on the Kent coast. Designed for disabled guests and their families — with optional care support from a CQC-registered provider.',
		'hero_cta_primary_label'   => 'See the property',
		'hero_cta_primary_url'     => '/the-property/',
		'hero_cta_secondary_label' => 'Enquire about dates',
		'hero_cta_secondary_url'   => '/enquire/',
		'hero_cta_promise'         => 'No booking commitment. Just a conversation.',

		'what_restwell_label'   => 'What is Restwell?',
		'what_restwell_heading' => 'A holiday, not a care home.',
		'intro_body'            => 'Restwell is a high-quality, wheelchair-accessible single-storey holiday bungalow in Whitstable, Kent — with ceiling track hoist, profiling bed, and a full wet room. This is not a care home or a clinical facility; it is a proper coastal self-catering holiday. Optional professional, CQC-regulated care is available through our partner, Continuity of Care Services, if you want it.',

		'who_label'        => "Who it's for",
		'who_heading'      => 'Two people. One break.',
		'who_guest_title'  => 'For the guest',
		'who_guest_body'   => 'A private home with the access features you actually need — wet room, wide doorways, level thresholds, space for your equipment. Explore Whitstable at your own pace. No shared spaces, no schedules, no clinical atmosphere.',
		'who_carer_title'  => 'For the carer',
		'who_carer_body'   => 'The property layout supports care routines — separate sleeping, practical bathroom access, space to assist. Optional CQC-regulated support is available through Continuity of Care Services, or bring your own carer. Either way, the environment is set up so you are not improvising.',

		'property_label'      => 'Our Whitstable home',
		'property_heading'   => 'Our Whitstable home',
		'property_body'      => 'A fully adapted property in a quiet residential street in Whitstable. Level approach, off-street parking for adapted vehicles, and a flat route to the Tankerton promenade. The town centre — with its harbour, independent shops, and seafood restaurants — is a short drive or bus ride away.',
		'property_cta_label' => 'Explore the property',
		'property_cta_url'   => '/the-property/',
		'property_image_id'  => 0,

		'why_label'       => 'Why Restwell?',
		'why_heading'     => 'What makes us different',
		'why_item1_title' => 'Private & personal',
		'why_item1_desc'  => 'A real home, not a ward or a hotel room. The whole house is yours.',
		'why_item2_title' => 'Care if you need it',
		'why_item2_desc'  => 'Optional support from Continuity of Care Services, a CQC-regulated provider. Arrange as much or as little as you need — or bring your own carer.',
		'why_item3_title' => 'Local knowledge',
		'why_item3_desc'  => 'We can tell you which cafes have step-free access, where to park near the harbour, and which routes work for wheelchairs.',
		'why_item4_title' => 'Honest & open',
		'why_item4_desc'  => 'We tell you exactly what to expect — no surprises, no overselling.',

		'cta_heading'          => 'Ready to plan your break?',
		'cta_body'            => 'Whether you have dates in mind or just want to ask a question, we are here to help. No pressure, just a conversation.',
		'cta_primary_label'   => 'See the property',
		'cta_primary_url'     => '/the-property/',
		'cta_secondary_label' => 'Enquire about dates',
		'cta_secondary_url'   => '/enquire/',
		'cta_promise'         => 'No booking commitment. Just a conversation.',
		'cta_image_id'        => 0,
	);
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
		'prop_hero_subtitle'            => 'A beautiful, accessible home on the Kent coast — designed with accessibility in mind so everyone can rest easy.',
		'prop_hero_cta_text'            => 'Enquire about dates',
		'prop_hero_cta_url'             => '/enquire/',
		'prop_hero_cta_secondary_text'  => 'How it works',
		'prop_hero_cta_secondary_url'   => '/how-it-works/',
		'prop_hero_cta_promise'         => 'We reply within one working day.',

		'prop_home_label'   => 'Your home for the week',
		'prop_home_heading' => 'Everything you need. Nothing you don\'t.',
		'prop_home_1_title' => 'Step-free throughout',
		'prop_home_1_body'  => 'Wide doorways, level thresholds, and a layout designed around wheelchair users and anyone who finds steps difficult.',
		'prop_home_2_title' => 'Flexible sleeping setup',
		'prop_home_2_body'  => 'Sleeping arrangements can be planned around your group and support needs. Share your requirements and we will confirm suitability before booking.',
		'prop_home_3_title' => 'Quiet location',
		'prop_home_3_body'  => 'Set on a residential street away from traffic. Close enough to walk to the seafront, quiet enough to rest properly.',

		'prop_dignity_label'   => 'Designed for dignity',
		'prop_dignity_heading' => 'Thoughtful at every turn.',
		'prop_dignity_body'    => "We have thought carefully about what 'accessible' actually means in practice — not just ticked a box.\n\nThat means a wet room with a ceiling hoist, an adjustable bed, wide hallways, and no awkward lips or steps. It means a kitchen where everyone can cook together. A garden you can actually enjoy.\n\nWe want every guest to feel at home — completely, not just mostly.",

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
		'prop_acc_tbc'        => "Precise turning circle dimensions in each room\nHoist weight limit — confirming with installer\nLocal hydrotherapy or pool access",

		'prop_comparison_label'         => 'Why not a hotel?',
		'prop_comparison_heading'       => 'A house, not a hotel room.',
		'prop_comparison_intro'         => 'Accessible hotel rooms tend to offer a bed and a wet room. We offer a home.',
		'prop_comparison_left_heading'  => 'A standard \'accessible\' room',
		'prop_comparison_right_heading' => 'Your Restwell stay',
		'prop_comparison_left_1'        => 'One accessible room among many',
		'prop_comparison_left_2'        => 'Restaurant only — no kitchen',
		'prop_comparison_left_3'        => 'No care coordination',
		'prop_comparison_left_4'        => 'Basic grab rails if you\'re lucky',
		'prop_comparison_right_1'       => 'The whole house is yours',
		'prop_comparison_right_2'       => 'Cook your own meals together',
		'prop_comparison_right_3'       => 'Optional CQC-regulated care on site',
		'prop_comparison_right_4'       => 'Ceiling hoist, profiling bed included',

		'prop_gallery_label'       => 'See the space',
		'prop_gallery_heading'     => 'Take a look around.',
		'prop_gallery_btn_1_label' => 'Enquire about dates',
		'prop_gallery_btn_1_url'   => '/enquire/',
		'prop_gallery_btn_2_label' => '',
		'prop_gallery_btn_2_url'   => '',
		'prop_gallery_btn_3_label' => '',
		'prop_gallery_btn_3_url'   => '',

		'prop_practical_label'   => 'Practical details',
		'prop_practical_heading' => 'The basics, clearly.',
		'prop_bedrooms_count'    => 'TBC',
		'prop_bedrooms'          => 'Bedroom configuration confirmed before booking',
		'prop_bathrooms_count'   => 'TBC',
		'prop_bathroom'          => 'Bathroom configuration confirmed before booking',
		'prop_parking_label'     => 'Parking',
		'prop_parking'           => 'Private driveway — two cars',
		'prop_sleeps_value'      => 'TBC',
		'prop_sleeps_label'      => 'Sleeps',
		'prop_distances'         => "Tankerton Slopes promenade — 15 min flat walk\nWhitstable town centre — 15 min walk\nWhitstable station — 20-30 min walk",
		'prop_confirm_details_url' => '/enquire/',

	'prop_nearby_label'       => 'What\'s nearby',
	'prop_nearby_heading'     => 'Explore Whitstable.',
	'prop_nearby_1_title'     => 'The Plough Pub',
	'prop_nearby_1_body'      => "A friendly local pub on St John's Road, just a short walk from the property. Relaxed atmosphere, good food, live music nights, and welcoming to families and groups.",
	'prop_nearby_1_acc'       => 'Wheelchair-accessible entrance and accessible restroom — confirm current details with the pub.',
	'prop_nearby_1_distance'  => 'Approx. 5 min walk',
	'prop_nearby_1_filter'    => 'wheelchair-friendly quieter',
	'prop_nearby_1_map_url'   => 'https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable',
	'prop_nearby_2_title'     => 'Tankerton Slopes & Promenade',
		'prop_nearby_2_body'      => 'A long, flat, surfaced promenade with views across the Thames Estuary. The promenade path itself is wide and level — suitable for wheelchairs and powerchairs. The grassy slopes between the road and the promenade are steep, so use the paved access paths. Free parking along Marine Parade at the top.',
	'prop_nearby_2_acc'       => 'Flat tarmac path, no steps, suitable for wheelchairs. Accessible WC at harbour end.',
	'prop_nearby_2_distance'  => 'Approx. 15 min flat walk',
	'prop_nearby_2_filter'    => 'wheelchair-friendly',
	'prop_nearby_2_map_url'   => 'https://maps.google.com/?q=Tankerton+Slopes+Whitstable',
	'prop_nearby_3_title'     => 'Whitstable Harbour & Harbour Street',
	'prop_nearby_3_body'      => 'Fresh oysters, fish and chips, independent restaurants, boutiques, galleries, and cafes. A lively working harbour with a relaxed, artistic character that draws visitors year-round.',
	'prop_nearby_3_acc'       => 'Mostly flat approach. Some cobblestone sections near the harbour. Harbour Street pavements can be narrow during peak times — quieter on weekday mornings.',
	'prop_nearby_3_distance'  => 'Approx. 20 min walk or 7 min drive',
	'prop_nearby_3_filter'    => 'quieter',
	'prop_nearby_3_map_url'   => 'https://maps.google.com/?q=Harbour+Street+Whitstable+Kent',
	'prop_nearby_4_title'     => 'Whitstable Beach',
	'prop_nearby_4_body'      => "Whitstable's iconic shingle beach is beautiful, but we want to be honest — shingle is generally not suitable for wheelchairs. The promenade above provides excellent sea views and is accessible for most wheelchair users.",
	'prop_nearby_4_acc'       => 'Shingle beach is not recommended for wheelchairs. The level promenade path above the beach is the accessible alternative.',
	'prop_nearby_4_distance'  => 'Approx. 15 min walk',
	'prop_nearby_4_filter'    => 'wheelchair-friendly',
	'prop_nearby_4_map_url'   => 'https://maps.google.com/?q=Whitstable+Beach+Kent',
	'prop_nearby_5_title'     => 'Supermarkets',
	'prop_nearby_5_body'      => "Sainsbury's is the closest at 4 minutes (Reeves Way, Chestfield CT5 3QS). Tesco Extra is 7 minutes (Millstrood Rd CT5 3EE). Co-op is 9 minutes (14–16 Canterbury Rd CT5 4EX). Aldi is 10 minutes (Prospect Retail Park CT5 3SD). All have disabled parking.",
	'prop_nearby_5_acc'       => 'All four stores have step-free access and disabled parking bays.',
	'prop_nearby_5_distance'  => 'From 4 min drive',
	'prop_nearby_5_filter'    => 'practical',
	'prop_nearby_5_map_url'   => 'https://maps.google.com/?q=Sainsbury%27s+Whitstable+Chestfield',
	'prop_nearby_6_title'     => 'Local Pharmacies',
	'prop_nearby_6_body'      => 'Boots Pharmacy and Superdrug Pharmacy are both in Whitstable town centre and open 7 days a week. Hours may vary slightly on Sundays — check locally if urgent.',
	'prop_nearby_6_acc'       => 'Accessible entrances — confirm current details with each pharmacy.',
	'prop_nearby_6_distance'  => 'Short drive or bus to town',
	'prop_nearby_6_filter'    => 'practical',
	'prop_nearby_6_map_url'   => 'https://maps.google.com/?q=Boots+Pharmacy+Whitstable',
	'prop_nearby_7_title'     => 'Getting Around',
	'prop_nearby_7_body'      => 'Accessible taxis: Abacus Cars LTD (01227 277745) — pre-book wheelchair-accessible vehicles, especially during school run times. Stagecoach South East: the 400 bus from The Plough runs to the beach, harbour, and Canterbury bus station. Whitstable Railway Station has direct trains to London St Pancras and Victoria; Chestfield & Swalecliffe is a quieter alternative nearby.',
	'prop_nearby_7_acc'       => 'Pre-book accessible vehicles with Abacus Cars. Bus stops within walking distance. Confirm station accessibility with National Rail.',
	'prop_nearby_7_distance'  => 'Various',
	'prop_nearby_7_filter'    => 'practical',
	'prop_nearby_7_map_url'   => 'https://maps.google.com/?q=Whitstable+Railway+Station',
	'prop_nearby_8_title'     => 'Medical & Emergency',
	'prop_nearby_8_body'      => 'Nearest A&E: Kent and Canterbury Hospital, Ethelbert Rd, Canterbury CT1 3NG — approximately 7 miles, 15–20 minutes by car. Non-emergency NHS: call 111. Local GP: Whitstable Medical Practice (approx. 5 min drive). Emergencies: 999.',
	'prop_nearby_8_acc'       => 'Kent and Canterbury Hospital has accessible parking and entrances. Call ahead for GP appointments.',
	'prop_nearby_8_distance'  => 'A&E approx. 7 miles / 15–20 min',
	'prop_nearby_8_filter'    => 'practical',
	'prop_nearby_8_map_url'   => 'https://maps.google.com/?q=Kent+and+Canterbury+Hospital+CT1+3NG',
	'prop_nearby_cta_label'   => 'Questions about access?',
	'prop_nearby_cta_url'     => '/enquire/',

		'prop_cta_heading' => 'Ready to see it for yourself?',
		'prop_cta_body'    => 'Get in touch and we\'ll answer any questions you have — honestly, without pressure.',
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
		'hiw_intro'   => 'We have made the process as straightforward as possible. No lengthy forms, no complicated assessments upfront — just a conversation to make sure we can meet your needs.',

		'hiw_steps_label'   => 'The process',
		'hiw_steps_heading' => 'Four steps to your stay.',
		'hiw_steps_intro'   => '',
		'hiw_step1_title'   => 'Get in touch',
		'hiw_step1_body'    => 'Fill in our short enquiry form or drop us an email. Tell us a little about who you are, when you\'re thinking of visiting, and any care or accessibility requirements.',
		'hiw_step2_title'   => 'We\'ll call you back',
		'hiw_step2_body'    => 'One of our team will call you within 24 hours. We want to understand what you need so we can confirm the property is right for you — and answer every question honestly.',
		'hiw_step3_title'   => 'Confirm your booking',
		'hiw_step3_body'    => 'Once you\'re happy, we\'ll send a simple booking confirmation and take a deposit. Care arrangements, if required, are agreed at this stage with Continuity of Care Services.',
		'hiw_step4_title'   => 'Arrive and rest easy',
		'hiw_step4_body'    => 'We\'ll be on hand for your arrival to show you around and make sure you\'re settled. Then the house is yours.',


		'hiw_care_cta_label'   => 'Optional care support',
		'hiw_care_cta_heading' => 'You choose how much support you want.',
		'hiw_care_cta_body'    => 'Care is entirely optional. If you want it, Continuity of Care Services — CQC-regulated and experienced — will work to your schedule. A morning check-in, personal care, or more comprehensive support.',
		'hiw_care_cta_btn'     => 'Ask about care options',
		'hiw_care_cta_url'     => '/enquire/',

		'hiw_included_label'   => 'What\'s included',
		'hiw_included_heading' => 'Everything in the house is yours.',
		'hiw_included_intro'   => 'Your booking covers exclusive use of the whole property for the duration of your stay.',
		'hiw_included_1_title' => 'Exclusive use of the whole house',
		'hiw_included_1_desc'  => 'No shared spaces, no other guests.',
		'hiw_included_2_title' => 'All accessibility equipment',
		'hiw_included_2_desc'  => 'Tea, coffee, milk, and a few basics so you are not shopping the moment you arrive.',
		'hiw_included_3_title' => 'High-speed broadband',
		'hiw_included_3_desc'  => 'Reliable Wi-Fi throughout.',
		'hiw_included_4_title' => 'Linen and towels',
		'hiw_included_4_desc'  => 'Freshly laundered for your arrival.',
		'hiw_included_5_title' => 'Parking for two cars',
		'hiw_included_5_desc'  => 'Private driveway.',
		'hiw_included_6_title' => 'Welcome information pack',
		'hiw_included_6_desc'  => 'Local tips, emergency contacts, and house guide.',

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
		'hiw_faq_2_a'     => 'We recommend enquiring as early as possible — peak summer weeks fill quickly. That said, we will always try to accommodate shorter-notice bookings where we can.',
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
		'acc_arrival_body'    => "Level driveway with space for two cars\nStep-free path from car to front door\nWide front door (965 mm clear)\nLevel threshold — no step",
		'acc_inside_heading'  => 'Inside the property',
		'acc_inside_body'     => "All internal doors 926 mm clear\nOpen-plan ground floor — no internal steps\nLevel flooring throughout (no carpet lips)\nCeiling track hoist covers accessible bedroom and wet room",
		'acc_bedroom_heading' => 'Accessible bedroom',
		'acc_bedroom_body'    => "Profiling bed with pressure-relieving mattress\nCeiling hoist with full-room track\nHeight-adjustable features\nSpace for carer on both sides of bed",
		'acc_bathroom_heading'=> 'Wet room',
		'acc_bathroom_body'   => "Full wet room — roll-in shower, no lip\nFold-down shower seat\nGrab rails: shower, toilet, and washbasin\nFloor-level drain\nExtractor fan",
		'acc_kitchen_heading' => 'Kitchen',
		'acc_kitchen_body'    => "Open-plan kitchen — easy wheelchair access\nHeight-adjustable worktop section\nInduction hob (safer for some users)\nAccessible storage at lower levels",
		'acc_outdoor_heading' => 'Outdoor spaces',
		'acc_outdoor_body'    => "Level patio immediately outside rear doors\nHard-standing surface suitable for wheelchairs\nSmall garden area — mostly flat",

		'acc_dest_label'              => 'Whitstable',
		'acc_dest_heading'            => 'The destination, honestly.',
		'acc_dest_intro'              => 'Whitstable is a genuinely lovely town — but like most historic coastal places, it has its challenges. Here is the honest picture.',
		'acc_dest_good_heading'       => 'The good',
		'acc_dest_good_body'          => 'The Tankerton promenade is a long, flat, surfaced path along the seafront — one of the most wheelchair-friendly coastal routes in Kent. Free parking at Marine Parade. Accessible toilets at the harbour end. The streets around the property are flat and paved with dropped kerbs.',
		'acc_dest_challenge_heading'  => 'The challenges',
		'acc_dest_challenge_body'     => 'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have stepped entrances with no ramp. The harbour itself has some uneven surfaces near the fish market. Weekday mornings are the easiest time to visit.',
		'acc_dest_reality_heading'    => 'The reality',
		'acc_dest_reality_body'       => "Whitstable is more accessible than most UK coastal towns. With a little planning — and our local knowledge — we can point you to the best accessible routes, cafes, and experiences. We will share everything we know in your welcome pack.",

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
		'faq_intro'        => 'If you can\'t find the answer here, get in touch — we respond within 24 hours.',
		'faq_list_label'   => '',
		'faq_list_heading' => 'Frequently asked questions',

		'faq_1_q'   => 'What is Restwell?',
		'faq_1_a'   => 'Restwell is a high-quality accessible holiday let in Whitstable, Kent. It is a proper coastal holiday home — not a care home, not a clinical facility. We offer the option of professional, CQC-regulated care support through our partner, Continuity of Care Services, but it is entirely optional.',
		'faq_1_cat' => 'about',

		'faq_2_q'   => 'Who is the property suitable for?',
		'faq_2_a'   => 'The property is designed for disabled guests, wheelchair users, and people with complex care needs — and the family and carers who travel with them. It is for anyone who finds standard holiday accommodation doesn\'t quite work.',
		'faq_2_cat' => 'about',

		'faq_3_q'   => 'Do I need to book care?',
		'faq_3_a'   => 'No. Care support is entirely optional. Many guests book as a self-catering holiday and need no additional support. If you do want professional care, we will connect you with Continuity of Care Services to arrange it.',
		'faq_3_cat' => 'care',

		'faq_4_q'   => 'What care services are available?',
		'faq_4_a'   => 'Through Continuity of Care Services (CQC-regulated), we can arrange personal care, medication management, moving and handling support, and more. The level of support is entirely up to you — from a daily check-in to comprehensive care.',
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
		'faq_8_a'   => 'The property has space for portable hoists and equipment. For specific requirements — ceiling track hoists, particular bed configurations, or specialist equipment — please get in touch before booking so we can confirm whether we can accommodate your needs.',
		'faq_8_cat' => 'about',

		'faq_9_q'   => 'What is Whitstable like for accessibility?',
		'faq_9_a'   => 'Mostly good — the Tankerton Slopes promenade is excellent for wheelchairs, the town centre is largely flat, and several restaurants and cafes are accessible. The harbour area has some cobblestones and the beach is shingle. Our welcome pack gives detailed local accessibility guidance.',
		'faq_9_cat' => 'local',

		'faq_10_q'   => 'How far is the property from the sea?',
		'faq_10_a'   => 'About a five-minute walk along a flat, tarmac path to the Tankerton Slopes promenade.',
		'faq_10_cat' => 'local',

		'faq_11_q'   => 'What is your cancellation policy?',
		'faq_11_a'   => "More than 30 days before arrival: full refund. 14–30 days before: 50% refund. Less than 14 days before: no refund.\n\nWe recognise that guests booking accessible accommodation may face unexpected medical or care-related changes. If cancellation is due to serious illness or a care emergency, we will consider a partial refund or a free date change subject to availability.\n\nDate changes requested more than 14 days before arrival are free of charge. Changes within 14 days may incur a fee. No refunds for early departure or no-shows.",
		'faq_11_cat' => 'booking',

		'faq_12_q'   => 'Can I visit the property before booking?',
		'faq_12_a'   => 'We are happy to arrange a pre-booking visit where possible. Get in touch to discuss.',
		'faq_12_cat' => 'booking',

		'faq_13_q'   => 'Can I use my direct payment to stay at Restwell?',
		'faq_13_a'   => 'In many cases, yes. Direct payments can often be used for short breaks and respite accommodation, depending on your care plan and local authority. We can provide the documentation your social worker or broker needs to approve the spend. Start with our Funding & Support page or get in touch to discuss your situation.',
		'faq_13_cat' => 'funding',

		'faq_14_q'   => 'What does CQC-regulated mean?',
		'faq_14_a'   => 'CQC stands for Care Quality Commission — the independent regulator of health and social care in England. Continuity of Care Services, our partner provider, is inspected and rated by the CQC. This means the care you receive meets nationally recognised standards for safety and quality.',
		'faq_14_cat' => 'funding',

		'faq_cta_label'   => '',
		'faq_cta_heading' => 'Still have a question?',
		'faq_cta_body'    => 'Get in touch and we will answer honestly, usually within 24 hours.',
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
		'enq_intro'   => 'Fill in the form and we\'ll call you back within 24 hours. No commitment, no hard sell — just a conversation.',

		'enq_form_heading'        => 'Tell us about your stay',
		'enq_success_heading'     => 'Thank you — we\'ll be in touch.',
		'enq_success_body'        => 'We will call you back within 24 hours to discuss your enquiry. If you would prefer an email response, just let us know.',
		'enq_success_urgent_body' => 'As you\'ve indicated this is time-sensitive, we will aim to respond as quickly as possible.',

		'enq_contact_heading'      => 'Prefer to contact us directly?',
		'enq_email'                => 'hello@restwellretreats.co.uk',
		'enq_phone'                => '01622 809881',
		'enq_response_heading'     => 'We respond within 24 hours',
		'enq_response_body'        => 'Every enquiry is handled personally. We will take the time to understand your needs and answer every question honestly.',
		'enq_no_pressure_heading'  => 'No pressure',
		'enq_no_pressure_body'     => 'There is absolutely no obligation. If the property isn\'t the right fit for you, we will tell you.',
	);
}

/**
 * Default meta for the Resources / Funding & Support page.
 */
function restwell_get_resources_page_defaults() {
	return array(
		'res_label'   => 'Funding & support',
		'res_heading' => 'Help paying for your break.',
		'res_intro'   => 'A Restwell Retreats holiday may be more affordable than you think. There are several funding routes worth exploring — we have gathered the most useful information here.',

		'res_fund_heading' => 'How to fund your stay',
		'res_fund_body'    => "Many guests use a combination of personal savings, direct payments, and charitable grants to fund their stay.\n\nIf you receive a personal budget or direct payment from your local authority or NHS, you may be able to use this towards your stay — particularly if care support is included. We recommend speaking to your care coordinator or social worker in the first instance.\n\nWe are happy to provide documentation to support a funding application.",

		'res_grants_heading' => 'Grants and charities',
		'res_grants_body'    => "A number of charities offer grants specifically for disabled people and their carers to take a holiday. These include:\n\n- <a href=\"https://www.tourismforall.co.uk\" target=\"_blank\" rel=\"noopener\">Tourism for All</a>\n- <a href=\"https://familyfund.org.uk\" target=\"_blank\" rel=\"noopener\">Family Fund</a> (families with disabled or seriously ill children)\n- <a href=\"https://www.carers.org\" target=\"_blank\" rel=\"noopener\">Carers UK</a> — signposting to local grants\n- Local authority short breaks / respite funding\n\nEligibility varies. We recommend checking each organisation\'s current criteria.",

		'res_chc_heading' => 'NHS Continuing Healthcare (CHC)',
		'res_chc_body'    => "If you or the person you care for receives NHS Continuing Healthcare, it may be possible to use some of that funding towards care support during your stay.\n\nThis is not straightforward and depends on your individual package. We recommend raising it with your NHS case manager or care coordinator.\n\nContinuity of Care Services — our care partner — can provide documentation to support a CHC application for care during your stay.",

		'res_complaints_heading' => 'Complaints and appeals',
		'res_complaints_body'    => "If a funding application is refused, you have the right to request a review. Local authorities are required to follow a formal review process.\n\nUseful resources:\n\n- <a href=\"https://www.disabilityrightsuk.org\" target=\"_blank\" rel=\"noopener\">Disability Rights UK</a>\n- <a href=\"https://www.lgo.org.uk\" target=\"_blank\" rel=\"noopener\">Local Government & Social Care Ombudsman</a>",

		'res_contacts_heading' => 'Key contacts',
		'res_contacts_body'    => "We have compiled a short list of organisations that may be helpful:\n\n- <strong>Continuity of Care Services</strong> — our care partner: <a href=\"https://www.continuitycareservices.co.uk\" target=\"_blank\" rel=\"noopener\">continuitycareservices.co.uk</a>\n- <strong>Care Quality Commission</strong> — CQC register: <a href=\"https://www.cqc.org.uk\" target=\"_blank\" rel=\"noopener\">cqc.org.uk</a>\n- <strong>Disability Rights UK</strong>: <a href=\"https://www.disabilityrightsuk.org\" target=\"_blank\" rel=\"noopener\">disabilityrightsuk.org</a>",

		'res_cta_heading' => 'Not sure where to start?',
		'res_cta_body'    => 'Get in touch and we will help you think through your options. We have helped guests navigate funding before and we are happy to point you in the right direction.',
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
		'gg_house_rules'     => "Please treat the property with care — it is someone's home.\nNo smoking anywhere inside the property.\nPets are welcome, including assistance dogs. Please keep pets off the furniture.\nPlease lock all doors and close all windows when you go out.\nReport any damages as soon as possible.",
		'gg_departure_notes' => "Strip the beds and leave used linen in the laundry room.\nPlace all rubbish in the bins provided.\nReturn all keys and fobs to the key safe (location shared on arrival).\nClose all windows and lock all doors.\nLeave the property in a tidy condition — thank you!",
		'gg_local_info'      => "Whitstable town centre is approximately 15 minutes on foot via a flat, paved route.\nTankerton promenade is about 15 minutes away on foot. The promenade itself is wide, level, and fully surfaced — suitable for wheelchairs and powerchairs. The grassy slopes above it are steep, so stick to the paved path along the seafront. Free parking is available along Marine Parade at the top.\nTesco Extra (Whitstable) is a 7-minute drive and has accessible parking, automatic doors, and a wheelchair-friendly layout.\nWheelchair and equipment hire is available locally — we can share details of trusted suppliers before your stay. Just ask.",
	);
}

/**
 * Default meta for the Who It's For page.
 */
function restwell_get_who_its_for_page_defaults() {
	return array(
		'wif_label'           => 'Who it is for',
		'wif_heading'         => 'Who Restwell is for',
		'wif_intro'           => 'Whether you are booking for yourself, someone you support, or a client, Restwell is designed to make planning straightforward and stays comfortable. Here is how it works for different people.',
		'wif_hero_image_id'   => 0,
		'wif_family_title'    => 'For disabled individuals and families',
		'wif_family_body'     => 'A private holiday home on the Kent coast, built around the access features that actually matter. Wet room with wheel-in shower, level access throughout, wide doorways, and space for the equipment you use at home. You bring your own support — we provide the property. No clinical atmosphere, no shared spaces, no compromises on comfort. You can check our full accessibility specification before you enquire.',
		'wif_carers_title'    => 'For carers and support workers',
		'wif_carers_body'     => 'Bring your client or family member with confidence. The property has the core access features already in place — wet room, level thresholds, space for hoists — so you are not improvising when you arrive. There is a separate sleeping area for carers and the layout is practical for assisting with personal care. If you need to check whether the property suits a specific guest, get in touch and we will answer plainly.',
		'wif_ot_title'        => 'For occupational therapists and case managers',
		'wif_ot_body'         => 'We publish detailed accessibility information — dimensions, equipment, layout — so you can assess suitability against your client\'s needs before recommending a stay. If you need specifics we have not covered on the site, we will get them for you. We understand that recommending somewhere unsuitable reflects on you, so we would rather give you a straight answer than a sales pitch.',
		'wif_commissioners_title' => 'For commissioners and social care teams',
		'wif_commissioners_body'  => 'Restwell welcomes funded stays through direct payments, personal health budgets, and CHC pathways. We can provide the supporting documentation you need for referrals and funding approvals — including property specifications, risk assessment information, and confirmation of our connection to Continuity of Care Services, a CQC-registered domiciliary and complex care provider. If you need to justify the spend, our Funding & Support page outlines common funding routes.',
		'wif_funding_heading' => 'How funding can work',
		'wif_funding_body'    => 'Many guests use direct payments, personal budgets, or CHC pathways (subject to local rules and care plans). In Kent, families often begin with a carers or care-needs assessment through Kent County Council, then confirm what can be funded. Start on our Funding & Support page, then contact us to discuss your case.',
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
		'wg_intro'         => 'From seafront walks to nearby towns, here is where guests usually go — and what to think about if accessibility matters to your plans.',
		'wg_hero_image_id' => 0,
		'wg_about_heading' => 'About Whitstable',
		'wg_about_body'    => "Whitstable is a small coastal town known for its harbour, independent high street, and oysters. The town centre is compact and mostly flat, with a mix of cafes, pubs, galleries, and independent shops along Harbour Street and the high street.\nFor wheelchair users: most of the town centre is paved, but some older streets have uneven surfaces and narrow pavements. The harbour area is generally accessible, though parts near the fish market can be uneven or crowded at weekends. There is accessible public parking at Gorrell Tank car park (Canterbury City Council, pay and display) close to the high street.\nTankerton, just east of the town centre, has a wide, surfaced promenade that runs along the seafront — flat, smooth, and suitable for wheelchairs and powerchairs. Free parking is available along Marine Parade at the top. The grassy slopes between the road and the promenade are steep, so use the paved paths to reach the seafront. At low tide, a natural shingle spit called \"The Street\" appears and extends about 750 metres out to sea — interesting to see, but not accessible for wheelchair users as it is loose shingle.",
		'wg_towns_heading' => 'Nearby towns worth visiting',
		'wg_towns_body'    => "Canterbury (about 8 miles) — the cathedral city. Good for a day out with shops, restaurants, and the cathedral itself. The city centre is mostly pedestrianised and largely flat, though some older streets are cobbled. There are several accessible car parks including the Whitefriars shopping centre. The cathedral has wheelchair access to most areas.\nFaversham (about 7 miles) — a quieter market town with independent shops and pubs. The town centre is compact and mostly flat. Market days are Tuesday, Friday, and Saturday. A good option if you want a change of scene without a long drive.\nHerne Bay (about 4 miles) — traditional seafront with a long, flat promenade that is fully paved and accessible. There is also a pier (partially rebuilt), amusement arcades, and fish and chips. An easy option for a couple of hours by the sea.",
		'wg_getting_here_heading' => 'Getting here',
		'wg_getting_here_body'    => "By car: Whitstable is reached via the M2 and A299 from London (about 60 miles, usually around 90 minutes depending on traffic). The property has off-street parking with enough space for adapted vehicles, including those with rear or side ramps.\nBy train: Whitstable station has direct services to London Victoria and London St Pancras (via Canterbury West or Faversham). Journey time is roughly 75–90 minutes. The station has step-free access to both platforms. From the station to the property is about a 10-minute drive — we can advise on accessible taxi options if needed.",
		'wg_getting_around_heading' => 'Getting around during your stay',
		'wg_getting_around_body'    => "Most guests find a car is the easiest way to get around, especially if you need to transport equipment. The property parking is level and spacious.\nThe Stagecoach 400 bus runs between Whitstable and Canterbury and stops nearby. This route uses low-floor buses, but availability of the ramp and wheelchair space can vary — it is worth checking with Stagecoach before relying on it for a specific journey.\nIf you use a mobility scooter or powerchair, the Tankerton promenade and Whitstable seafront are both suitable surfaces. The town centre is mixed — some pavements are narrow or uneven in older parts.\nWheelchair hire is available locally. Ask us before your stay and we can share contact details for trusted suppliers in the area.",
		'wg_spotlight_image_1_id' => 0,
		'wg_spotlight_image_1_caption' => 'Tankerton promenade and sea-wall route',
		'wg_spotlight_image_2_id' => 0,
		'wg_spotlight_image_2_caption' => 'Whitstable harbour boardwalk and food huts',
		'wg_spotlight_image_3_id' => 0,
		'wg_spotlight_image_3_caption' => 'Town-centre route planning and practical stops',
		'wg_cta_heading'     => 'Planning your coastal break?',
		'wg_cta_body'        => 'If you have dates in mind, enquire and we will help you plan a stay that works.',
		'wg_cta_primary_label' => 'See the property',
		'wg_cta_primary_url'   => '/the-property/',
		'wg_cta_secondary_label'=> 'Enquire about dates',
		'wg_cta_secondary_url'  => '/enquire/',
	);
}

/**
 * Default meta for the Contact page.
 */
function restwell_get_contact_page_defaults() {
	return array(
		'contact_label'         => 'Contact',
		'contact_heading'       => 'Get in touch.',
		'contact_intro'         => 'Ask a question, check dates, or talk through accessibility requirements before you book.',
		'contact_hero_image_id' => 0,
		'contact_phone'         => '01622 809881',
		'contact_email'         => 'hello@restwellretreats.co.uk',
		'contact_address'       => "Restwell Retreats\n101 Russell Drive\nWhitstable\nKent\nCT5 2RQ",
		'contact_hours_heading' => 'Response times',
		'contact_hours_body'    => "We aim to reply to all enquiries within 24 hours.\nIf your enquiry is urgent, please call.",
		'contact_prof_heading'  => 'For professionals',
		'contact_prof_body'     => 'If you are an occupational therapist, case manager, or commissioner, we are happy to provide property specifications, access measurements, and supporting information for referrals or funding applications. We prefer to give you specifics rather than marketing material.',
		'contact_cta_heading'   => 'Prefer the full enquiry form?',
		'contact_cta_body'      => 'Use our enquiry form to share dates and requirements in one place.',
		'contact_cta_label'     => 'Go to enquiry form',
		'contact_cta_url'       => '/enquire/',
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
			$force = ! empty( $_POST['restwell_rerun'] );
			$result = restwell_run_theme_setup( $force );
			$message = restwell_theme_setup_format_message( $result );
		}
	}

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Restwell Theme Setup', 'restwell-retreats' ); ?></h1>

		<?php echo $message; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — built from escaped fragments ?>

		<div class="notice notice-warning">
			<p><?php esc_html_e( 'This will create all pages and populate default content. Only run this once on a fresh install.', 'restwell-retreats' ); ?></p>
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
						<?php esc_html_e( 'Re-run setup anyway', 'restwell-retreats' ); ?>
					</label>
				</p>
			<?php endif; ?>
			<p>
				<button type="submit" name="restwell_run_setup" value="1" class="button button-primary">
					<?php esc_html_e( 'Run Theme Setup', 'restwell-retreats' ); ?>
				</button>
			</p>
		</form>
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
 * Sideload the three theme logos into the Media Library and store attachment IDs
 * as theme mods. Idempotent — skips files already uploaded.
 *
 * Theme mods set:
 *   restwell_logo_long_id     → long_logo.png  (horizontal, used in header/footer)
 *   restwell_logo_stacked_id  → logo.png        (stacked, available for custom use)
 *   restwell_logo_infinity_id → restwellinfinity.png  (icon only, available for custom use)
 *
 * @param array $result Result array passed by reference — keys logos_uploaded,
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
		// Already uploaded — verify the attachment still exists in the DB.
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

		// Copy to a temp path — media_handle_sideload moves/deletes the tmp file.
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
 * @param bool $force If true, re-seed Home meta even if already seeded.
 * @return array{ 'created': string[], 'skipped': string[], 'front_page_set': bool, 'home_seeded': bool, 'logos_uploaded': string[], 'logos_skipped': string[], 'logos_missing': string[], 'logos_failed': string[] }
 */
function restwell_run_theme_setup( $force = false ) {
	$result = array(
		'created'            => array(),
		'skipped'            => array(),
		'front_page_set'     => false,
		'posts_page_set'     => false,
		'home_seeded'        => false,
		'pages_seeded'       => array(),
		'pages_seed_skipped' => array(),
		'hub_seeded'         => array(),
		'seo_meta_applied'   => false,
		'blog_posts_seeded'  => array(),
		'blog_posts_failed'  => array(),
		'logos_uploaded'     => array(),
		'logos_skipped'      => array(),
		'logos_missing'      => array(),
		'logos_failed'       => array(),
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
		'Contact'            => 'template-contact.php',
		'Resources'          => 'template-resources.php',
		'Guest Guide'        => 'page-guest-guide.php',
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

		$should_seed = $force || get_post_meta( $home_id, 'restwell_fields_seeded', true ) !== '1';
		if ( $should_seed ) {
			$defaults = restwell_get_theme_setup_defaults();
			foreach ( $defaults as $key => $value ) {
				update_post_meta( $home_id, $key, $value );
			}
			update_post_meta( $home_id, 'restwell_fields_seeded', '1' );
			$result['home_seeded'] = true;
		}
	}

	// Seed meta defaults for all non-Home template pages.
	restwell_seed_all_pages_meta( $created_ids, $force, $result );

	// Seed post_content for legal pages.
	restwell_seed_legal_pages_content( $created_ids, $force, $result );

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

	// Empty SEO meta_title / meta_description on core pages.
	restwell_apply_seo_meta_to_pages( false );
	$result['seo_meta_applied'] = true;

	// Priority blog posts (idempotent).
	restwell_seed_priority_blog_posts( $result );

	// Upload logos to Media Library so templates can use stable attachment URLs.
	restwell_upload_theme_logos( $result );

	return $result;
}

/**
 * Seed post_content for Privacy Policy and Terms & Conditions pages.
 *
 * Only seeds if the page has no existing content, or if $force is true.
 *
 * @param array $created_ids Map of page title => post ID.
 * @param bool  $force       Re-seed even if content exists.
 * @param array $result      Result array passed by reference.
 */
function restwell_seed_legal_pages_content( array $created_ids, $force, array &$result ) {
	$legal_content = array(
		'Privacy Policy'     => restwell_get_privacy_policy_content(),
		'Terms & Conditions' => restwell_get_terms_conditions_content(),
	);

	foreach ( $legal_content as $title => $content ) {
		$page_id = isset( $created_ids[ $title ] ) ? (int) $created_ids[ $title ] : 0;
		if ( $page_id < 1 ) {
			$slug = sanitize_title( $title );
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			$page_id = $page ? (int) $page->ID : 0;
		}
		if ( $page_id < 1 ) {
			continue;
		}

		$existing = get_post_field( 'post_content', $page_id );
		if ( ! $force && ! empty( trim( $existing ) ) ) {
			continue;
		}

		wp_update_post(
			array(
				'ID'           => $page_id,
				'post_content' => wp_kses_post( $content ),
			)
		);
		$result['legal_seeded'][] = $title;
	}
}

/**
 * Returns minimal Privacy Policy post_content.
 *
 * @return string HTML string (no outer wrapper, ready for classic editor).
 */
function restwell_get_privacy_policy_content(): string {
	$site = esc_html( get_bloginfo( 'name' ) );
	return '<h2>Who we are</h2>
<p>' . $site . ' ("we", "us", "our") provides accessible holiday accommodation in Whitstable, Kent. Our website address is: ' . esc_url( home_url( '/' ) ) . '</p>

<h2>What information we collect and why</h2>
<p>When you use our enquiry form we collect: your name, email address, phone number, and any care or accessibility information you choose to share. We use this information solely to respond to your enquiry and, where relevant, to arrange your stay.</p>
<p>We do not sell, trade, or otherwise transfer your personally identifiable information to outside parties, except to our care partner (Continuity of Care Services) where care support is part of your booking, and only with your explicit knowledge.</p>

<h2>Cookies and analytics</h2>
<p>We use cookies for essential site functionality and, with your consent, for analytics purposes (Google Analytics 4). You can manage your cookie preferences using the banner displayed on your first visit.</p>

<h2>How long we keep your data</h2>
<p>Enquiry records are retained for up to 3 years to allow us to respond to follow-up questions and to fulfil any care-related obligations. You may request deletion at any time.</p>

<h2>Your rights</h2>
<p>Under UK GDPR you have the right to: access the personal data we hold about you; request correction of inaccurate data; request erasure of your data; object to or restrict processing; and lodge a complaint with the Information Commissioner\'s Office (ico.org.uk).</p>
<p>To exercise any of these rights, please contact us at <a href="mailto:hello@restwellretreats.co.uk">hello@restwellretreats.co.uk</a>.</p>

<h2>Changes to this policy</h2>
<p>We may update this policy from time to time. The current version will always be available on this page. Last updated: ' . gmdate( 'F Y' ) . '.</p>';
}

/**
 * Returns minimal Terms & Conditions post_content.
 *
 * @return string HTML string.
 */
function restwell_get_terms_conditions_content(): string {
	$site    = esc_html( get_bloginfo( 'name' ) );
	$enquire = esc_url( home_url( '/enquire/' ) );
	return '<h2>Booking</h2>
<p>Reservations at ' . $site . ' are confirmed only when we have received a signed booking form and deposit. All bookings are subject to availability and our written confirmation.</p>

<h2>Payment</h2>
<p>A non-refundable deposit (amount confirmed at time of booking) is required to secure your dates. The remaining balance is due six weeks before arrival. We accept BACS bank transfer and debit/credit card.</p>

<h2>Cancellation</h2>
<p>Cancellations made more than 6 weeks before arrival: deposit forfeited. Cancellations within 6 weeks of arrival: full balance due unless we are able to re-let the property. We strongly recommend travel and cancellation insurance.</p>

<h2>Care support</h2>
<p>Where care support is arranged through our partner Continuity of Care Services, separate terms issued by that provider will also apply. We act as an introducer only and are not responsible for the delivery of care services.</p>

<h2>Liability</h2>
<p>' . $site . ' is not liable for any loss, damage, or injury to guests or their property during the stay, except where caused by our own negligence. Guests are responsible for taking out appropriate travel and medical insurance.</p>

<h2>Contact</h2>
<p>Questions about these terms? Contact us at <a href="' . $enquire . '">our enquiry page</a> or email <a href="mailto:hello@restwellretreats.co.uk">hello@restwellretreats.co.uk</a>.</p>

<p><em>Last updated: ' . gmdate( 'F Y' ) . '.</em></p>';
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
		'Contact'       => 'restwell_get_contact_page_defaults',
		'Resources'     => 'restwell_get_resources_page_defaults',
		'Guest Guide'   => 'restwell_get_guest_guide_page_defaults',
	);

	foreach ( $page_defaults_map as $title => $defaults_fn ) {
		// Resolve the page ID — prefer the ID from this run, then look it up.
		$page_id = isset( $created_ids[ $title ] ) ? (int) $created_ids[ $title ] : 0;
		if ( $page_id < 1 ) {
			$slug = sanitize_title( $title );
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			$page_id = $page ? (int) $page->ID : 0;
		}
		if ( $page_id < 1 ) {
			continue;
		}

		$already_seeded = get_post_meta( $page_id, 'restwell_fields_seeded', true ) === '1';
		if ( $already_seeded && ! $force ) {
			$result['pages_seed_skipped'][] = $title;
			continue;
		}

		if ( is_callable( $defaults_fn ) ) {
			$defaults = call_user_func( $defaults_fn );
			foreach ( $defaults as $key => $value ) {
				update_post_meta( $page_id, $key, $value );
			}
			update_post_meta( $page_id, 'restwell_fields_seeded', '1' );
			$result['pages_seeded'][] = $title;
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
		$lines[] = esc_html__( 'Default content seeded on Home page.', 'restwell-retreats' );
	}
	if ( ! empty( $result['pages_seeded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Page content seeded:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['pages_seeded'] ) );
	}
	if ( ! empty( $result['pages_seed_skipped'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Page content already seeded (skipped):', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['pages_seed_skipped'] ) );
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
		$lines[] = esc_html__( 'SEO title and description defaults applied where fields were empty.', 'restwell-retreats' );
	}
	if ( ! empty( $result['blog_posts_seeded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Blog posts created:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['blog_posts_seeded'] ) );
	}
	if ( ! empty( $result['blog_posts_failed'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Blog post seed failed (slug):', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['blog_posts_failed'] ) );
	}

	if ( empty( $lines ) ) {
		return '<div class="notice notice-warning"><p>' . esc_html__( 'No changes made. Home page may be missing.', 'restwell-retreats' ) . '</p></div>';
	}

	return '<div class="notice notice-success"><p>' . implode( '<br />', $lines ) . '</p></div>';
}
