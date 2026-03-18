<?php
/**
 * Theme setup: WP Admin page to create pages and seed front page meta.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RESTWELL_SETUP_NONCE_ACTION = 'restwell_theme_setup_run';
const RESTWELL_SETUP_NONCE_NAME   = 'restwell_theme_setup_nonce';

/**
 * Pages to create: title => slug.
 */
function restwell_get_theme_setup_pages() {
	return array(
		'Home'           => 'home',
		'The Property'   => 'the-property',
		'How It Works'   => 'how-it-works',
		'Accessibility'  => 'accessibility',
		'FAQ'            => 'faq',
		'Enquire'        => 'enquire',
		'Resources'      => 'resources',
	);
}

/**
 * Default meta values for the front page (Home).
 */
function restwell_get_theme_setup_defaults() {
	return array(
		'hero_eyebrow'             => 'Accessible holidays in Whitstable',
		'hero_heading'             => 'Rest easy. A real holiday for both of you.',
		'hero_subheading'          => 'A beautiful, accessible home on the Kent coast — where guests find adventure and carers find a true break.',
		'hero_cta_primary_label'   => 'See the property',
		'hero_cta_primary_url'     => '/property',
		'hero_cta_secondary_label' => 'Enquire about dates',
		'hero_cta_secondary_url'   => '/enquire',
		'hero_cta_promise'         => '',

		'what_restwell_label'   => 'What is Restwell Retreats?',
		'what_restwell_heading' => 'A holiday, not a care home.',
		'intro_body'            => 'Restwell Retreats is a high-quality, accessible holiday let in Whitstable, Kent. This is not a care home or a clinical facility. It is a proper coastal holiday — with the option of professional, CQC-regulated care support on hand through our partner, Continuity of Care Services. Whether you need a morning check-in or more comprehensive support, it is there if you want it. And if you don\'t, you simply enjoy the house, the coast, and the freedom.',

		'who_label'        => "Who it's for",
		'who_heading'      => 'Two people. One break.',
		'who_guest_title'  => 'For the guest',
		'who_guest_body'   => "A space designed around you. Wide doorways, level access, and the freedom to explore Whitstable's vibrant coast at your own pace. This is your holiday — not an appointment, not a schedule. Just the sea air, good food, and a comfortable home to come back to.",
		'who_carer_title'  => 'For the carer',
		'who_carer_body'   => 'Peace of mind is the ultimate luxury. With optional professional support available from CCS, you can step back, relax, and enjoy being a partner, a parent, or a friend again — rather than a full-time carer. Rest easy knowing they are safe, happy, and having a proper break too.',

		'property_label'      => 'Our Whitstable home',
		'property_heading'   => '101 Russell Drive',
		'property_body'      => "Our flagship property sits in a quiet residential corner of Whitstable, just a short, flat walk from the famous Tankerton Slopes promenade. It is the perfect base for exploring everything this charming coastal town has to offer — from Harbour Street's independent shops to fresh oysters by the water.",
		'property_cta_label' => 'Explore the property',
		'property_cta_url'   => '/property',
		'property_image_id'  => 0,

		'why_label'       => 'Why Restwell?',
		'why_heading'     => 'What makes us different',
		'why_item1_title' => 'Private & personal',
		'why_item1_desc'  => 'A real home, not a ward or a hotel room. The whole house is yours.',
		'why_item2_title' => 'Expertly supported',
		'why_item2_desc'  => 'Optional CQC-regulated care from Continuity of Care Services.',
		'why_item3_title' => 'Whitstable local',
		'why_item3_desc'  => 'We know the best accessible spots, the quietest cafes, and the flattest routes.',
		'why_item4_title' => 'Honest & open',
		'why_item4_desc'  => 'We tell you exactly what to expect — no surprises, no overselling.',

		'cta_heading'          => 'Ready to plan your break?',
		'cta_body'            => 'Whether you have dates in mind or just want to ask a question, we are here to help. No pressure, just a conversation.',
		'cta_primary_label'   => 'See the property',
		'cta_primary_url'     => '/property',
		'cta_secondary_label' => 'Enquire about dates',
		'cta_secondary_url'   => '/enquire',
		'cta_promise'         => '',
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
		'prop_address_postcode' => 'CT5 4HH',

		'prop_hero_label'               => 'The Property',
		'prop_hero_heading'             => '101 Russell Drive, Whitstable',
		'prop_hero_subtitle'            => 'A beautiful, fully accessible home on the Kent coast — designed so everyone can rest easy.',
		'prop_hero_cta_text'            => 'Enquire about dates',
		'prop_hero_cta_url'             => '/enquire/',
		'prop_hero_cta_secondary_text'  => 'How it works',
		'prop_hero_cta_secondary_url'   => '/how-it-works/',
		'prop_hero_cta_promise'         => '',

		'prop_home_label'   => 'Your home for the week',
		'prop_home_heading' => 'Everything you need. Nothing you don\'t.',
		'prop_home_1_title' => 'Step-free throughout',
		'prop_home_1_body'  => 'Wide doorways, level thresholds, and a layout designed around wheelchair users and anyone who finds steps difficult.',
		'prop_home_2_title' => 'Sleeping for up to 9',
		'prop_home_2_body'  => 'Five bedrooms accommodate the whole party — guests, carers, and family — so everyone stays together.',
		'prop_home_3_title' => 'Proper coastal living',
		'prop_home_3_body'  => 'A fully equipped kitchen, spacious living areas, and a garden that opens onto a flat, accessible path to the beach.',

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
		'prop_feature_4_desc'   => 'All internal doors ≥ 900 mm clear',
		'prop_feature_5'        => 'Step-free access',
		'prop_feature_5_desc'   => 'Level entry from parking to all rooms',
		'prop_feature_6'        => 'Accessible outdoor space',
		'prop_feature_6_desc'   => 'Hard-standing patio and level garden',
		'prop_feature_7'        => 'Fully equipped kitchen',
		'prop_feature_7_desc'   => 'Height-adjustable worktop section',
		'prop_feature_8'        => 'High-speed broadband',
		'prop_feature_8_desc'   => 'Reliable Wi-Fi throughout the property',

		'prop_acc_label'      => 'Accessibility in detail',
		'prop_acc_heading'    => 'What we can confirm',
		'prop_acc_intro'      => 'We believe in honest accessibility information. Here is exactly what we can confirm — and what is still being finalised.',
		'prop_acc_confirmed'  => "Step-free access from parking\nCeiling track hoist (full room)\nWet room with roll-in shower\nProfiling bed with pressure mattress\nAll doorways ≥ 900 mm clear\nLevel garden with hard-standing patio\nWi-Fi throughout",
		'prop_acc_tbc'        => "Turning circle dimensions in each room\nHoist weight limit (confirming with installer)\nPool/hydrotherapy availability nearby",

		'prop_comparison_label'         => 'Why not a hotel?',
		'prop_comparison_heading'       => 'A house, not a hotel room.',
		'prop_comparison_intro'         => 'Accessible hotel rooms tend to offer a bed and a wet room. We offer a home.',
		'prop_comparison_left_heading'  => 'Restwell Retreats',
		'prop_comparison_right_heading' => 'Typical accessible hotel',
		'prop_comparison_left_1'        => 'The whole house is yours',
		'prop_comparison_left_2'        => 'Cook your own meals together',
		'prop_comparison_left_3'        => 'Optional CQC-regulated care on site',
		'prop_comparison_left_4'        => 'Ceiling hoist, profiling bed included',
		'prop_comparison_right_1'       => 'One accessible room among many',
		'prop_comparison_right_2'       => 'Restaurant only — no kitchen',
		'prop_comparison_right_3'       => 'No care coordination',
		'prop_comparison_right_4'       => 'Basic grab rails if you\'re lucky',

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
		'prop_bedrooms_count'    => '5',
		'prop_bedrooms'          => '5 bedrooms',
		'prop_bathrooms_count'   => '3',
		'prop_bathroom'          => '3 bathrooms',
		'prop_parking_label'     => 'Parking',
		'prop_parking'           => 'Private driveway — two cars',
		'prop_sleeps_value'      => '9+',
		'prop_sleeps_label'      => 'Sleeps',
		'prop_distances'         => "Tankerton Slopes promenade — 5 min walk\nWhitstable town centre — 15 min walk\nWhitstable station — 20 min walk",
		'prop_confirm_details_url' => '/enquire/',

		'prop_nearby_label'       => 'What\'s nearby',
		'prop_nearby_heading'     => 'Explore Whitstable.',
		'prop_nearby_1_title'     => 'Tankerton Slopes',
		'prop_nearby_1_body'      => 'A wide, flat promenade along the seafront with stunning views across the Thames Estuary.',
		'prop_nearby_1_acc'       => 'Tarmac path, no steps, suitable for wheelchairs',
		'prop_nearby_1_distance'  => 'Approx. 5 min walk',
		'prop_nearby_1_filter'    => 'wheelchair-friendly',
		'prop_nearby_1_map_url'   => 'https://maps.google.com/?q=Tankerton+Slopes+Whitstable',
		'prop_nearby_2_title'     => 'Whitstable Harbour',
		'prop_nearby_2_body'      => 'Fresh oysters, fish and chips, independent restaurants, and a lively working harbour.',
		'prop_nearby_2_acc'       => 'Mostly flat; cobblestone sections near the harbour itself',
		'prop_nearby_2_distance'  => 'Approx. 15 min walk or short drive',
		'prop_nearby_2_filter'    => 'wheelchair-friendly',
		'prop_nearby_2_map_url'   => 'https://maps.google.com/?q=Whitstable+Harbour',
		'prop_nearby_3_title'     => 'Harbour Street',
		'prop_nearby_3_body'      => 'Whitstable\'s famous independent high street — boutiques, galleries, cafes, and delis.',
		'prop_nearby_3_acc'       => 'Largely flat; some narrow pavements',
		'prop_nearby_3_distance'  => 'Approx. 15 min walk',
		'prop_nearby_3_filter'    => 'quieter',
		'prop_nearby_3_map_url'   => 'https://maps.google.com/?q=Harbour+Street+Whitstable',
		'prop_nearby_4_title'     => 'Tesco Extra',
		'prop_nearby_4_body'      => 'Large supermarket for your weekly shop. Disabled parking bays and accessible entrance.',
		'prop_nearby_4_acc'       => 'Fully accessible; disabled parking',
		'prop_nearby_4_distance'  => 'Approx. 10 min drive',
		'prop_nearby_4_filter'    => 'practical',
		'prop_nearby_4_map_url'   => 'https://maps.google.com/?q=Tesco+Whitstable',
		'prop_nearby_5_title'     => 'Whitstable Medical Practice',
		'prop_nearby_5_body'      => 'Local GP practice. For emergencies, the nearest A&E is QEQM Hospital in Margate.',
		'prop_nearby_5_acc'       => 'Accessible entrance; please call ahead',
		'prop_nearby_5_distance'  => 'Approx. 5 min drive',
		'prop_nearby_5_filter'    => 'practical',
		'prop_nearby_5_map_url'   => 'https://maps.google.com/?q=Whitstable+Medical+Practice',
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

		'hiw_journey_label'   => 'Your journey',
		'hiw_journey_heading' => 'What to expect, day by day.',
		'hiw_journey_1_title' => 'Before you book',
		'hiw_journey_1_body'  => 'We answer your questions, confirm the property suits your needs, and agree dates.',
		'hiw_journey_2_title' => 'Booking confirmed',
		'hiw_journey_2_body'  => 'Deposit taken. Care plan agreed (if applicable). Welcome pack sent.',
		'hiw_journey_3_title' => 'Pre-arrival call',
		'hiw_journey_3_body'  => 'We check in a few days before to confirm arrival time and any last-minute details.',
		'hiw_journey_4_title' => 'Arrival day',
		'hiw_journey_4_body'  => 'We welcome you, show you around, and make sure everything is set up as agreed.',
		'hiw_journey_5_title' => 'During your stay',
		'hiw_journey_5_body'  => 'The house is yours. Care support (if booked) operates to your agreed schedule.',
		'hiw_journey_6_title' => 'After your stay',
		'hiw_journey_6_body'  => 'We follow up to hear how it went. Feedback helps us keep improving.',

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
		'hiw_included_2_desc'  => 'Ceiling hoist, profiling bed, wet room — all included.',
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
		'hiw_cta_promise'         => '',

		'hiw_faq_label'   => 'Common questions',
		'hiw_faq_heading' => 'Things people often ask.',
		'hiw_faq_intro'   => '',
		'hiw_faq_1_q'     => 'Do I have to book care?',
		'hiw_faq_1_a'     => 'No. Care support through Continuity of Care Services is entirely optional. Many guests book the house as a self-catering holiday and need no additional support.',
		'hiw_faq_2_q'     => 'How far in advance should I book?',
		'hiw_faq_2_a'     => 'We recommend enquiring as early as possible — peak summer weeks fill quickly. That said, we will always try to accommodate shorter-notice bookings where we can.',
		'hiw_faq_3_q'     => 'Is there a minimum stay?',
		'hiw_faq_3_a'     => 'Our standard minimum booking is three nights. For peak weeks we typically ask for a full week, but please get in touch and we\'ll work with you.',
	);
	return $defaults;
}

/**
 * Default meta for the Accessibility page.
 */
function restwell_get_accessibility_page_defaults() {
	return array(
		'acc_label'   => 'Accessibility',
		'acc_heading' => 'Honest accessibility information.',
		'acc_intro'   => 'We know how important it is to have accurate, detailed accessibility information before you book. Here is everything we can tell you about the property and the destination.',

		'acc_room_label'      => 'The property',
		'acc_room_heading'    => 'Room by room.',
		'acc_arrival_heading' => 'Arrival & entrance',
		'acc_arrival_body'    => "Level driveway with space for two cars\nStep-free path from car to front door\nWide front door (≥ 900 mm clear)\nLevel threshold — no step",
		'acc_inside_heading'  => 'Inside the property',
		'acc_inside_body'     => "All internal doors ≥ 900 mm clear\nOpen-plan ground floor — no internal steps\nLevel flooring throughout (no carpet lips)\nCeiling track hoist covers accessible bedroom and wet room",
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
		'acc_dest_good_body'          => "Tankerton Slopes: wide, flat tarmac promenade — excellent for wheelchairs\nMost of the town centre is on level ground\nSeveral accessible cafes and restaurants on Harbour Street\nBeach huts along a flat coastal path",
		'acc_dest_challenge_heading'  => 'The challenges',
		'acc_dest_challenge_body'     => "The harbour itself has cobblestone areas and uneven surfaces\nSome pavement sections are narrow\nThe beach is predominantly shingle — difficult for wheelchairs",
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

		'faq_1_q'   => 'What is Restwell Retreats?',
		'faq_1_a'   => 'Restwell Retreats is a high-quality accessible holiday let in Whitstable, Kent. It is a proper coastal holiday home — not a care home, not a clinical facility. We offer the option of professional, CQC-regulated care support through our partner, Continuity of Care Services, but it is entirely optional.',
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
		'faq_6_a'   => 'Our standard minimum booking is three nights. For peak summer weeks we typically ask for a full week. Please get in touch and we will work with you.',
		'faq_6_cat' => 'booking',

		'faq_7_q'   => 'What is included in the price?',
		'faq_7_a'   => 'Exclusive use of the whole house, all accessibility equipment (ceiling hoist, profiling bed, wet room), linen and towels, private parking for two cars, and high-speed broadband. Care is priced separately if required.',
		'faq_7_cat' => 'booking',

		'faq_8_q'   => 'Is the property genuinely accessible?',
		'faq_8_a'   => 'Yes. Step-free throughout, ceiling track hoist, full wet room, profiling bed, wide doorways (≥ 900 mm), and level access from parking. See our Accessibility page for full details.',
		'faq_8_cat' => 'about',

		'faq_9_q'   => 'What is Whitstable like for accessibility?',
		'faq_9_a'   => 'Mostly good — the Tankerton Slopes promenade is excellent for wheelchairs, the town centre is largely flat, and several restaurants and cafes are accessible. The harbour area has some cobblestones and the beach is shingle. Our welcome pack gives detailed local accessibility guidance.',
		'faq_9_cat' => 'local',

		'faq_10_q'   => 'How far is the property from the sea?',
		'faq_10_a'   => 'About a five-minute walk along a flat, tarmac path to the Tankerton Slopes promenade.',
		'faq_10_cat' => 'local',

		'faq_11_q'   => 'What is your cancellation policy?',
		'faq_11_a'   => 'Please ask when you enquire — we will explain our current policy clearly and without jargon.',
		'faq_11_cat' => 'booking',

		'faq_12_q'   => 'Can I visit the property before booking?',
		'faq_12_a'   => 'We are happy to arrange a pre-booking visit where possible. Get in touch to discuss.',
		'faq_12_cat' => 'booking',

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
		'enq_phone'                => '',
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
		'res_grants_body'    => "A number of charities offer grants specifically for disabled people and their carers to take a holiday. These include:\n\n- <a href=\"https://www.holidaysforall.org\" target=\"_blank\" rel=\"noopener\">Tourism for All</a>\n- <a href=\"https://www.family-fund.org.uk\" target=\"_blank\" rel=\"noopener\">Family Fund</a> (families with disabled or seriously ill children)\n- <a href=\"https://www.carers.org\" target=\"_blank\" rel=\"noopener\">Carers UK</a> — signposting to local grants\n- Local authority short breaks / respite funding\n\nEligibility varies. We recommend checking each organisation\'s current criteria.",

		'res_chc_heading' => 'NHS Continuing Healthcare (CHC)',
		'res_chc_body'    => "If you or the person you care for receives NHS Continuing Healthcare, it may be possible to use some of that funding towards care support during your stay.\n\nThis is not straightforward and depends on your individual package. We recommend raising it with your NHS case manager or care coordinator.\n\nContinuity of Care Services — our care partner — can provide documentation to support a CHC application for care during your stay.",

		'res_complaints_heading' => 'Complaints and appeals',
		'res_complaints_body'    => "If a funding application is refused, you have the right to request a review. Local authorities are required to follow a formal review process.\n\nUseful resources:\n\n- <a href=\"https://www.disabilityrightsuk.org\" target=\"_blank\" rel=\"noopener\">Disability Rights UK</a>\n- <a href=\"https://www.lgo.org.uk\" target=\"_blank\" rel=\"noopener\">Local Government & Social Care Ombudsman</a>",

		'res_contacts_heading' => 'Key contacts',
		'res_contacts_body'    => "We have compiled a short list of organisations that may be helpful:\n\n- <strong>Continuity of Care Services</strong> — our care partner: <a href=\"https://www.continuityofcareservices.co.uk\" target=\"_blank\" rel=\"noopener\">continuityofcareservices.co.uk</a>\n- <strong>Care Quality Commission</strong> — CQC register: <a href=\"https://www.cqc.org.uk\" target=\"_blank\" rel=\"noopener\">cqc.org.uk</a>\n- <strong>Disability Rights UK</strong>: <a href=\"https://www.disabilityrightsuk.org\" target=\"_blank\" rel=\"noopener\">disabilityrightsuk.org</a>",

		'res_cta_heading' => 'Not sure where to start?',
		'res_cta_body'    => 'Get in touch and we will help you think through your options. We have helped guests navigate funding before and we are happy to point you in the right direction.',
		'res_cta_btn'     => 'Get in touch',
		'res_cta_url'     => '/enquire/',
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
 *   restwell_logo_infinity_id → infinity.png    (icon only, available for custom use)
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
		'restwell_logo_infinity_id' => 'infinity.png',
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
		'home_seeded'        => false,
		'pages_seeded'       => array(),
		'pages_seed_skipped' => array(),
		'logos_uploaded'     => array(),
		'logos_skipped'      => array(),
		'logos_missing'      => array(),
		'logos_failed'       => array(),
	);

	$pages = restwell_get_theme_setup_pages();
	$created_ids = array();

	$page_templates = array(
		'The Property'   => 'template-property.php',
		'How It Works'   => 'template-how-it-works.php',
		'Accessibility'  => 'template-accessibility.php',
		'FAQ'            => 'template-faq.php',
		'Enquire'        => 'template-enquire.php',
		'Resources'      => 'template-resources.php',
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

	// Upload logos to Media Library so templates can use stable attachment URLs.
	restwell_upload_theme_logos( $result );

	return $result;
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
		'FAQ'           => 'restwell_get_faq_page_defaults',
		'Enquire'       => 'restwell_get_enquire_page_defaults',
		'Resources'     => 'restwell_get_resources_page_defaults',
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

	if ( empty( $lines ) ) {
		return '<div class="notice notice-warning"><p>' . esc_html__( 'No changes made. Home page may be missing.', 'restwell-retreats' ) . '</p></div>';
	}

	return '<div class="notice notice-success"><p>' . implode( '<br />', $lines ) . '</p></div>';
}
