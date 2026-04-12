<?php
/**
 * Template Name: The Property
 * Page template for the property page with editable meta fields.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();
$prop_hero_label    = get_post_meta( $pid, 'prop_hero_label', true ) ?: 'The Property';
$prop_hero_heading  = get_post_meta( $pid, 'prop_hero_heading', true ) ?: 'Our accessible home in Whitstable';
$prop_hero_subtitle = get_post_meta( $pid, 'prop_hero_subtitle', true ) ?: 'An adapted home on the Kent coast: ceiling track hoist, profiling bed, and wet room already in place.';
$prop_hero_image_id = (int) get_post_meta( $pid, 'prop_hero_image_id', true );
$prop_hero_cta_text           = get_post_meta( $pid, 'prop_hero_cta_text', true ) ?: 'Check your dates';
$prop_hero_cta_url            = esc_url( get_post_meta( $pid, 'prop_hero_cta_url', true ) ?: home_url( '/enquire/' ) );
$prop_hero_cta_promise        = get_post_meta( $pid, 'prop_hero_cta_promise', true ) ?: 'We reply within one working day.';
$prop_hero_cta_secondary_text = get_post_meta( $pid, 'prop_hero_cta_secondary_text', true ) ?: 'Accessibility detail';
$prop_hero_cta_secondary_url  = esc_url( get_post_meta( $pid, 'prop_hero_cta_secondary_url', true ) ?: home_url( '/accessibility/' ) );

$prop_home_heading = get_post_meta( $pid, 'prop_home_heading', true ) ?: 'Your home for the week';
$prop_home_label   = get_post_meta( $pid, 'prop_home_label', true ) ?: '';
$prop_home_cards   = array(
	array(
		'title' => get_post_meta( $pid, 'prop_home_1_title', true ) ?: 'Accessible throughout',
		'body'  => get_post_meta( $pid, 'prop_home_1_body', true ) ?: 'Enjoy total freedom with step-free access throughout the whole single story building. Wide doorways and a mobile wet room ensure complete ease of use.',
	),
	array(
		'title' => get_post_meta( $pid, 'prop_home_2_title', true ) ?: 'Private Garden',
		'body'  => get_post_meta( $pid, 'prop_home_2_body', true ) ?: 'Relax and unwind in the private, level access garden. Enjoy comfortable outdoor seating, a paved terrace, and space for all to enjoy.',
	),
	array(
		'title' => get_post_meta( $pid, 'prop_home_3_title', true ) ?: 'Quiet location',
		'body'  => get_post_meta( $pid, 'prop_home_3_body', true ) ?: 'Set on a residential street away from traffic. Close enough to walk to the seafront, quiet enough to rest properly.',
	),
);

$prop_dignity_heading  = get_post_meta( $pid, 'prop_dignity_heading', true ) ?: 'Designed for dignity and comfort';
$prop_dignity_label    = get_post_meta( $pid, 'prop_dignity_label', true ) ?: '';
$prop_dignity_body_raw = get_post_meta( $pid, 'prop_dignity_body', true );
$prop_dignity_image_id = (int) get_post_meta( $pid, 'prop_dignity_image_id', true );
$prop_dignity_src      = $prop_dignity_image_id ? wp_get_attachment_image_url( $prop_dignity_image_id, 'large' ) : '';

$prop_features = array(
	array( 'title' => get_post_meta( $pid, 'prop_feature_1', true ) ?: 'Wet Room', 'desc' => get_post_meta( $pid, 'prop_feature_1_desc', true ) ?: 'Level-access shower with rails.' ),
	array( 'title' => get_post_meta( $pid, 'prop_feature_2', true ) ?: 'Wide Doorways', 'desc' => get_post_meta( $pid, 'prop_feature_2_desc', true ) ?: 'Accessible to all mobility aids.' ),
	array( 'title' => get_post_meta( $pid, 'prop_feature_3', true ) ?: 'Step-free Access', 'desc' => get_post_meta( $pid, 'prop_feature_3_desc', true ) ?: 'No steps or tight corners.' ),
	array( 'title' => get_post_meta( $pid, 'prop_feature_4', true ) ?: 'Parking', 'desc' => get_post_meta( $pid, 'prop_feature_4_desc', true ) ?: 'Dedicated accessible bay.' ),
	array( 'title' => get_post_meta( $pid, 'prop_feature_5', true ) ?: 'Fully Equipped Kitchen', 'desc' => get_post_meta( $pid, 'prop_feature_5_desc', true ) ?: 'Accessible counters and appliances.' ),
	array( 'title' => get_post_meta( $pid, 'prop_feature_6', true ) ?: 'Garden with Seating', 'desc' => get_post_meta( $pid, 'prop_feature_6_desc', true ) ?: 'Level paving and comfy seating.' ),
	array( 'title' => get_post_meta( $pid, 'prop_feature_7', true ) ?: 'Walk to the Beach', 'desc' => get_post_meta( $pid, 'prop_feature_7_desc', true ) ?: 'Easy access to promenade paths.' ),
	array( 'title' => get_post_meta( $pid, 'prop_feature_8', true ) ?: 'Accessible WC', 'desc' => get_post_meta( $pid, 'prop_feature_8_desc', true ) ?: 'Ground-floor accessible toilet.' ),
);

$prop_overview_heading = get_post_meta( $pid, 'prop_overview_heading', true ) ?: 'Your coastal home-from-home';
$prop_overview_body   = get_post_meta( $pid, 'prop_overview_body', true ) ?: "This is a private holiday home, not a hotel room or a care facility. The whole property is yours for the duration of your stay: no shared corridors, no other guests, no institutional feel. The layout has been designed around the access needs of wheelchair users and guests with complex physical disabilities, with practical details like transfer space, equipment compatibility, and carer accommodation considered from the start.\n\nThe property sits in a quiet, flat residential area of Whitstable. The town itself is compact, independent, and manageable, known for its harbour, seafood, and coastal walks. It is about 60 miles from London, with direct train services and straightforward road access via the M2.";
$prop_dignity_body    = $prop_dignity_body_raw !== '' ? $prop_dignity_body_raw : $prop_overview_body;

$prop_features_label   = get_post_meta( $pid, 'prop_features_label', true ) ?: 'Accessibility';
$prop_features_heading = get_post_meta( $pid, 'prop_features_heading', true ) ?: 'Accessibility features';

$prop_acc_label   = get_post_meta( $pid, 'prop_acc_label', true ) ?: 'Accessibility';
$prop_acc_heading = get_post_meta( $pid, 'prop_acc_heading', true ) ?: 'Accessibility you can rely on';
$prop_acc_intro   = get_post_meta( $pid, 'prop_acc_intro', true ) ?: 'We have assessed every aspect of the property for access. Here is what we have verified, and if you have a requirement not listed, we are always happy to talk it through.';
$prop_acc_confirmed = get_post_meta( $pid, 'prop_acc_confirmed', true ) ?: "Level access throughout the ground floor\nWide doorways suitable for wheelchair access\nQuiet, flat residential street\nClose to level promenade walks";

// Comparison: why not just an accessible hotel?
$prop_comparison_label         = get_post_meta( $pid, 'prop_comparison_label', true ) ?: 'The difference';
$prop_comparison_heading       = get_post_meta( $pid, 'prop_comparison_heading', true ) ?: 'Why not just book an accessible hotel?';
$prop_comparison_intro         = get_post_meta( $pid, 'prop_comparison_intro', true ) ?: 'Most \'accessible\' accommodation means a wider door and a grab rail. Restwell means something else entirely.';
$prop_comparison_left_heading  = get_post_meta( $pid, 'prop_comparison_left_heading', true ) ?: 'A standard \'accessible\' room';
$prop_comparison_right_heading = get_post_meta( $pid, 'prop_comparison_right_heading', true ) ?: 'Your Restwell stay';
$comparison_left_defaults  = array(
	'An adapted room in a shared building, with other guests and communal spaces',
	'No care support on site: you arrange everything yourself in advance',
	'Retrofitted accessibility: a grab rail by the toilet, maybe a wider door. No hoist, no profiling bed, no guarantee it works for your needs.',
	'You find out what doesn\'t work once you\'ve already arrived',
);
$comparison_right_defaults = array(
	'The entire property: private garden, no shared spaces, no other guests',
	'Optional CQC-regulated care arranged around your stay, or bring your own',
	'Designed from the ground up for complex needs: nothing retrofitted, nothing assumed',
	'Ask us anything before you book; we\'ll tell you exactly what works for you',
);
$prop_comparison_left  = array();
$prop_comparison_right = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$prop_comparison_left[]  = get_post_meta( $pid, "prop_comparison_left_{$i}", true ) ?: $comparison_left_defaults[ $i - 1 ];
	$prop_comparison_right[] = get_post_meta( $pid, "prop_comparison_right_{$i}", true ) ?: $comparison_right_defaults[ $i - 1 ];
}

$prop_gallery_label   = get_post_meta( $pid, 'prop_gallery_label', true ) ?: 'Gallery';
$prop_gallery_heading = get_post_meta( $pid, 'prop_gallery_heading', true ) ?: 'See the space';
$prop_gallery_1 = (int) get_post_meta( $pid, 'prop_gallery_1_image_id', true );
$prop_gallery_2 = (int) get_post_meta( $pid, 'prop_gallery_2_image_id', true );
$prop_gallery_3 = (int) get_post_meta( $pid, 'prop_gallery_3_image_id', true );

$prop_practical_label   = get_post_meta( $pid, 'prop_practical_label', true ) ?: 'Practical details';
$prop_practical_heading = get_post_meta( $pid, 'prop_practical_heading', true ) ?: 'The essentials';
$prop_bedrooms  = get_post_meta( $pid, 'prop_bedrooms', true ) ?: 'Number of bedrooms and bed types to be confirmed by client.';
$prop_bathroom  = get_post_meta( $pid, 'prop_bathroom', true ) ?: 'Bathroom type and accessibility features to be confirmed by client.';
$prop_parking   = get_post_meta( $pid, 'prop_parking', true ) ?: 'Driveway or street parking details to be confirmed by client.';
$prop_distances = get_post_meta( $pid, 'prop_distances', true ) ?: "Approximately 15 minutes' flat walk to the Tankerton promenade. Around 7 minutes' drive to Whitstable town centre and harbour.";
// Display values for essentials cards (number or short label).
$prop_essentials = array(
	'bedrooms'  => array( 'value' => get_post_meta( $pid, 'prop_bedrooms_count', true ) ?: 'TBC', 'label' => 'Bedrooms' ),
	'bathrooms' => array( 'value' => get_post_meta( $pid, 'prop_bathrooms_count', true ) ?: 'TBC', 'label' => 'Bathrooms' ),
	'parking'   => array( 'value' => get_post_meta( $pid, 'prop_parking_label', true ) ?: 'Free', 'label' => 'Parking' ),
	'sleeps'    => array( 'value' => get_post_meta( $pid, 'prop_sleeps_value', true ) ?: 'TBC', 'label' => get_post_meta( $pid, 'prop_sleeps_label', true ) ?: 'Sleeps' ),
);
$prop_confirm_details_url = esc_url( get_post_meta( $pid, 'prop_confirm_details_url', true ) ?: home_url( '/enquire/' ) );
// See the space: three buttons (design).
$prop_gallery_buttons = array(
	array( 'label' => get_post_meta( $pid, 'prop_gallery_btn_1_label', true ) ?: 'See all photos', 'url' => esc_url( get_post_meta( $pid, 'prop_gallery_btn_1_url', true ) ?: $prop_confirm_details_url ) ),
	array( 'label' => get_post_meta( $pid, 'prop_gallery_btn_2_label', true ) ?: 'Explore video', 'url' => esc_url( get_post_meta( $pid, 'prop_gallery_btn_2_url', true ) ?: '#' ) ),
	array( 'label' => get_post_meta( $pid, 'prop_gallery_btn_3_label', true ) ?: 'Take 3D Tour', 'url' => esc_url( get_post_meta( $pid, 'prop_gallery_btn_3_url', true ) ?: '#' ) ),
);

$prop_nearby_label   = get_post_meta( $pid, 'prop_nearby_label', true ) ?: "What's nearby";
$prop_nearby_heading = get_post_meta( $pid, 'prop_nearby_heading', true ) ?: 'Explore Whitstable';
$nearby = array(
	array(
		'title'    => get_post_meta( $pid, 'prop_nearby_1_title', true ) ?: 'The Plough Pub',
		'body'     => get_post_meta( $pid, 'prop_nearby_1_body', true ) ?: "A friendly local pub on St John's Road, just a short walk from the property. Relaxed atmosphere, good food, live music nights, and welcoming to families and groups.",
		'acc'      => get_post_meta( $pid, 'prop_nearby_1_acc', true ) ?: 'Wheelchair-accessible entrance and accessible restroom. Confirm current details with the pub.',
		'distance' => get_post_meta( $pid, 'prop_nearby_1_distance', true ) ?: 'Approx. 5 min walk',
		'filter'   => get_post_meta( $pid, 'prop_nearby_1_filter', true ) ?: 'wheelchair-friendly quieter',
		'map_url'  => get_post_meta( $pid, 'prop_nearby_1_map_url', true ) ?: 'https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable',
		'icon'     => 'fa-utensils',
		'type'     => 'Food &amp; Drink',
	),
	array(
		'title'    => get_post_meta( $pid, 'prop_nearby_2_title', true ) ?: 'Tankerton Slopes & Promenade',
		'body'     => get_post_meta( $pid, 'prop_nearby_2_body', true ) ?: 'A long, flat, surfaced promenade with views across the Thames Estuary. The promenade path itself is wide and level, suitable for wheelchairs and powerchairs. The grassy slopes between the road and the promenade are steep, so use the paved access paths. Free parking along Marine Parade at the top.',
		'acc'      => get_post_meta( $pid, 'prop_nearby_2_acc', true ) ?: 'Flat tarmac path, no steps, suitable for wheelchairs. Accessible WC at harbour end.',
		'distance' => get_post_meta( $pid, 'prop_nearby_2_distance', true ) ?: 'Approx. 15 min flat walk',
		'filter'   => get_post_meta( $pid, 'prop_nearby_2_filter', true ) ?: 'wheelchair-friendly',
		'map_url'  => get_post_meta( $pid, 'prop_nearby_2_map_url', true ) ?: 'https://maps.google.com/?q=Tankerton+Slopes+Whitstable',
		'icon'     => 'fa-water',
		'type'     => 'The Coast',
	),
	array(
		'title'    => get_post_meta( $pid, 'prop_nearby_3_title', true ) ?: 'Whitstable Harbour & Harbour Street',
		'body'     => get_post_meta( $pid, 'prop_nearby_3_body', true ) ?: "Fresh oysters, fish and chips, independent restaurants, boutiques, galleries, and cafes. The harbour is a lively working port with a relaxed, artistic character that draws visitors year-round.",
		'acc'      => get_post_meta( $pid, 'prop_nearby_3_acc', true ) ?: 'Mostly flat approach. Some cobblestone sections near the harbour itself. Harbour Street pavements can be narrow during peak times; quieter on weekday mornings.',
		'distance' => get_post_meta( $pid, 'prop_nearby_3_distance', true ) ?: 'Approx. 20 min walk or 7 min drive',
		'filter'   => get_post_meta( $pid, 'prop_nearby_3_filter', true ) ?: 'quieter',
		'map_url'  => get_post_meta( $pid, 'prop_nearby_3_map_url', true ) ?: 'https://maps.google.com/?q=Harbour+Street+Whitstable+Kent',
		'icon'     => 'fa-bag-shopping',
		'type'     => 'Town &amp; Shops',
	),
	array(
		'title'    => get_post_meta( $pid, 'prop_nearby_4_title', true ) ?: 'Whitstable Beach',
		'body'     => get_post_meta( $pid, 'prop_nearby_4_body', true ) ?: "Whitstable's iconic shingle beach is beautiful, but we want to be honest: shingle is generally not suitable for wheelchairs. The promenade above provides excellent sea views and is accessible for most wheelchair users.",
		'acc'      => get_post_meta( $pid, 'prop_nearby_4_acc', true ) ?: 'Shingle beach is not recommended for wheelchairs. The level promenade path above the beach is the accessible alternative.',
		'distance' => get_post_meta( $pid, 'prop_nearby_4_distance', true ) ?: 'Approx. 15 min walk',
		'filter'   => get_post_meta( $pid, 'prop_nearby_4_filter', true ) ?: 'wheelchair-friendly',
		'map_url'  => get_post_meta( $pid, 'prop_nearby_4_map_url', true ) ?: 'https://maps.google.com/?q=Whitstable+Beach+Kent',
		'icon'     => 'fa-umbrella-beach',
		'type'     => 'The Coast',
	),
	array(
		'title'    => get_post_meta( $pid, 'prop_nearby_5_title', true ) ?: 'Supermarkets',
		'body'     => get_post_meta( $pid, 'prop_nearby_5_body', true ) ?: "Sainsbury's is the closest at 4 minutes (Reeves Way, Chestfield CT5 3QS). Tesco Extra is 7 minutes (Millstrood Rd CT5 3EE). Co-op is 9 minutes (14-16 Canterbury Rd CT5 4EX). Aldi is 10 minutes (Prospect Retail Park CT5 3SD). All have accessible parking.",
		'acc'      => get_post_meta( $pid, 'prop_nearby_5_acc', true ) ?: 'All four stores have step-free access and accessible parking bays.',
		'distance' => get_post_meta( $pid, 'prop_nearby_5_distance', true ) ?: 'From 4 min drive',
		'filter'   => get_post_meta( $pid, 'prop_nearby_5_filter', true ) ?: 'practical',
		'map_url'  => get_post_meta( $pid, 'prop_nearby_5_map_url', true ) ?: 'https://maps.google.com/?q=Sainsbury%27s+Whitstable+Chestfield',
		'icon'     => 'fa-cart-shopping',
		'type'     => 'Practical',
	),
	array(
		'title'    => get_post_meta( $pid, 'prop_nearby_6_title', true ) ?: 'Local Pharmacies',
		'body'     => get_post_meta( $pid, 'prop_nearby_6_body', true ) ?: 'Boots Pharmacy and Superdrug Pharmacy are both in Whitstable town centre and open 7 days a week. Hours may vary slightly on Sundays; check locally if urgent.',
		'acc'      => get_post_meta( $pid, 'prop_nearby_6_acc', true ) ?: 'Accessible entrances. Confirm current details with each pharmacy.',
		'distance' => get_post_meta( $pid, 'prop_nearby_6_distance', true ) ?: 'Short drive or bus to town',
		'filter'   => get_post_meta( $pid, 'prop_nearby_6_filter', true ) ?: 'practical',
		'map_url'  => get_post_meta( $pid, 'prop_nearby_6_map_url', true ) ?: 'https://maps.google.com/?q=Boots+Pharmacy+Whitstable',
		'icon'     => 'fa-prescription-bottle-medical',
		'type'     => 'Wellbeing',
	),
	array(
		'title'    => get_post_meta( $pid, 'prop_nearby_7_title', true ) ?: 'Getting Around',
		'body'     => get_post_meta( $pid, 'prop_nearby_7_body', true ) ?: 'Accessible taxis: Abacus Cars LTD (01227 277745). Pre-book wheelchair-accessible vehicles, especially during school run times. Stagecoach South East: the 400 bus from The Plough runs to the beach, harbour, and Canterbury bus station. Whitstable Railway Station has direct trains to London St Pancras and Victoria; Chestfield & Swalecliffe is a quieter alternative nearby.',
		'acc'      => get_post_meta( $pid, 'prop_nearby_7_acc', true ) ?: 'Pre-book accessible vehicles with Abacus Cars. Bus stops within walking distance. Confirm station accessibility with National Rail.',
		'distance' => get_post_meta( $pid, 'prop_nearby_7_distance', true ) ?: 'Various',
		'filter'   => get_post_meta( $pid, 'prop_nearby_7_filter', true ) ?: 'practical',
		'map_url'  => get_post_meta( $pid, 'prop_nearby_7_map_url', true ) ?: 'https://maps.google.com/?q=Whitstable+Railway+Station',
		'icon'     => 'fa-bus',
		'type'     => 'Transport',
	),
	array(
		'title'    => get_post_meta( $pid, 'prop_nearby_8_title', true ) ?: 'Medical & Emergency',
		'body'     => get_post_meta( $pid, 'prop_nearby_8_body', true ) ?: 'Nearest A&E: Kent and Canterbury Hospital, Ethelbert Rd, Canterbury CT1 3NG, approximately 7 miles, 15-20 minutes by car. Non-emergency NHS: call 111. Local GP: Whitstable Medical Practice (approx. 5 min drive). Emergencies: 999.',
		'acc'      => get_post_meta( $pid, 'prop_nearby_8_acc', true ) ?: 'Kent and Canterbury Hospital has accessible parking and entrances. Call ahead for GP appointments.',
		'distance' => get_post_meta( $pid, 'prop_nearby_8_distance', true ) ?: 'A&E approx. 7 miles / 15-20 min',
		'filter'   => get_post_meta( $pid, 'prop_nearby_8_filter', true ) ?: 'practical',
		'map_url'  => get_post_meta( $pid, 'prop_nearby_8_map_url', true ) ?: 'https://maps.google.com/?q=Kent+and+Canterbury+Hospital+CT1+3NG',
		'icon'     => 'fa-kit-medical',
		'type'     => 'Wellbeing',
	),
);
$prop_nearby_cta_label = get_post_meta( $pid, 'prop_nearby_cta_label', true ) ?: '';
$prop_nearby_cta_url   = get_post_meta( $pid, 'prop_nearby_cta_url', true ) ?: '';

$prop_cta_heading = get_post_meta( $pid, 'prop_cta_heading', true ) ?: 'Like what you see?';
$prop_cta_body    = get_post_meta( $pid, 'prop_cta_body', true ) ?: 'Get in touch to check availability or any other questions.';
$prop_cta_btn     = get_post_meta( $pid, 'prop_cta_btn', true ) ?: 'Check your dates';
$prop_cta_url     = get_post_meta( $pid, 'prop_cta_url', true ) ?: home_url( '/enquire/' );
$prop_cta_url     = esc_url( $prop_cta_url );
$prop_cta_promise = get_post_meta( $pid, 'prop_cta_promise', true ) ?: '';
?>
<main class="flex-1" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>
	<?php
	set_query_var(
		'args',
		array(
			'heading_id'    => 'page-hero-heading',
			'label'         => $prop_hero_label,
			'heading'       => $prop_hero_heading,
			'intro'         => $prop_hero_subtitle,
			'media_id'      => $prop_hero_image_id,
			'image_alt'     => $prop_hero_heading,
			'content_max'   => 'max-w-2xl',
			'cta_primary'   => $prop_hero_cta_text !== '' ? array(
				'label' => $prop_hero_cta_text,
				'url'   => $prop_hero_cta_url,
			) : array(),
			'cta_secondary' => $prop_hero_cta_secondary_text !== '' ? array(
				'label' => $prop_hero_cta_secondary_text,
				'url'   => $prop_hero_cta_secondary_url,
			) : array(),
			'cta_promise'   => $prop_hero_cta_promise,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<!-- Your home for the week (3 feature cards) -->
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]">
		<div class="container">
			<?php if ( $prop_home_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $prop_home_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl font-serif text-[var(--deep-teal)] text-center mb-12 md:mb-16"><?php echo esc_html( $prop_home_heading ); ?></h2>
			<div class="grid md:grid-cols-3 gap-8 lg:gap-10 max-w-5xl mx-auto">
				<?php
				$home_icons = array( 'fa-house', 'fa-heart', 'fa-location-dot' );
				foreach ( $prop_home_cards as $i => $card ) :
				?>
				<div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100/80 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1">
					<div class="text-[var(--deep-teal)] mb-5" aria-hidden="true">
						<i class="fa-solid <?php echo esc_attr( $home_icons[ $i ] ); ?> text-3xl"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3 leading-tight"><?php echo esc_html( $card['title'] ); ?></h3>
					<p class="text-gray-600 leading-relaxed text-sm md:text-base"><?php echo esc_html( $card['body'] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Designed for dignity and comfort -->
	<section class="py-16 md:py-24 bg-[var(--soft-sand)] overflow-hidden">
		<div class="container">
			<div class="grid md:grid-cols-2 gap-0 items-stretch max-w-6xl mx-auto">
				<?php if ( $prop_dignity_src ) : ?>
					<div class="relative order-2 md:order-1">
						<img src="<?php echo esc_url( $prop_dignity_src ); ?>" alt="<?php echo esc_attr( $prop_dignity_heading ); ?>" class="rounded-2xl w-full h-full min-h-[280px] object-cover aspect-[4/3]" />
					</div>
				<?php endif; ?>
			<div class="order-1 md:order-2 <?php echo $prop_dignity_src ? 'md:-ml-12 lg:-ml-16 md:pl-8 lg:pl-12 flex flex-col justify-center' : 'md:col-span-2'; ?>">
			<div class="bg-white rounded-2xl p-8 md:p-10 lg:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-[var(--driftwood)]/30 <?php echo $prop_dignity_src ? '' : 'max-w-2xl mx-auto'; ?>">
					<?php if ( $prop_dignity_label !== '' ) : ?>
						<p class="section-label mb-3"><?php echo esc_html( $prop_dignity_label ); ?></p>
					<?php endif; ?>
					<h2 class="text-3xl font-serif text-[var(--deep-teal)] mb-6"><?php echo esc_html( $prop_dignity_heading ); ?></h2>
						<div class="text-gray-600 text-lg leading-relaxed space-y-4 max-w-prose">
							<?php echo wp_kses_post( wpautop( $prop_dignity_body ) ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Accessibility features grid (8 items, 2 rows of 4) -->
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]">
		<div class="container">
			<?php if ( $prop_features_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $prop_features_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl font-serif text-[var(--deep-teal)] text-center mb-12"><?php echo esc_html( $prop_features_heading ); ?></h2>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
				<?php
				$feature_icons = array( 'fa-shower', 'fa-door-open', 'fa-person-walking', 'fa-square-parking', 'fa-utensils', 'fa-chair', 'fa-route', 'fa-toilet' );
				foreach ( $prop_features as $j => $feature ) :
				?>
				<div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col items-center text-center gap-3 transition-all duration-300 ease-in-out hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1 motion-reduce:hover:translate-y-0 motion-reduce:transition-none">
					<div class="text-[var(--deep-teal)]" aria-hidden="true">
						<i class="fa-solid <?php echo esc_attr( $feature_icons[ $j ] ); ?> text-2xl"></i>
					</div>
					<h3 class="text-[var(--deep-teal)] font-semibold text-base"><?php echo esc_html( $feature['title'] ); ?></h3>
					<p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html( $feature['desc'] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Accessibility you can rely on -->
	<section class="py-16 md:py-24 bg-white">
		<div class="container max-w-4xl">
			<?php if ( $prop_acc_label !== '' ) : ?>
				<p class="section-label mb-3"><?php echo esc_html( $prop_acc_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $prop_acc_heading ); ?></h2>
			<p class="text-gray-600 mb-10 leading-relaxed max-w-prose"><?php echo esc_html( $prop_acc_intro ); ?></p>
			<div class="grid md:grid-cols-2 gap-8 items-start">
				<!-- Verified features list -->
				<ul class="space-y-3" aria-label="<?php echo esc_attr__( 'Verified accessibility features', 'restwell-retreats' ); ?>">
					<?php foreach ( array_filter( array_map( 'trim', explode( "\n", $prop_acc_confirmed ) ) ) as $item ) : ?>
						<li class="flex items-start gap-3">
							<span class="w-6 h-6 rounded-full bg-[#A8D5D0]/40 flex items-center justify-center flex-shrink-0 mt-0.5 text-[var(--deep-teal)]" aria-hidden="true">
								<i class="fa-solid fa-check text-xs"></i>
							</span>
							<span class="text-gray-700 leading-snug"><?php echo esc_html( $item ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
				<!-- Specific requirements card -->
				<div class="bg-[var(--bg-subtle)] rounded-2xl p-7 flex flex-col gap-5 border border-gray-100">
					<div>
						<h3 class="text-lg font-semibold font-serif text-[var(--deep-teal)] mb-2"><?php echo esc_html__( 'Have a specific requirement?', 'restwell-retreats' ); ?></h3>
						<p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html__( 'Every guest is different. Whether you need to know about hoist access, particular bathroom equipment, bed configuration, or sensory environment, we are happy to talk it through before you commit to anything.', 'restwell-retreats' ); ?></p>
					</div>
					<a href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>" class="btn btn-primary self-start">
						<?php echo esc_html__( 'Ask us directly', 'restwell-retreats' ); ?>
						<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Why not just an accessible hotel? -->
	<section class="py-16 md:py-24 bg-[var(--soft-sand)]">
		<div class="container">
			<div class="text-center mb-12 md:mb-14">
				<p class="section-label mb-3"><?php echo esc_html( $prop_comparison_label ); ?></p>
				<h2 class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] mb-4 section-heading">
					<?php echo esc_html( $prop_comparison_heading ); ?>
				</h2>
				<p class="text-gray-600 leading-relaxed max-w-prose mx-auto">
					<?php echo esc_html( $prop_comparison_intro ); ?>
				</p>
			</div>
			<div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
				<div class="rounded-2xl p-7 bg-[var(--bg-subtle)] border border-gray-200/60">
					<p class="text-base font-semibold text-gray-500 uppercase tracking-wide mb-6" aria-hidden="true">
						<?php echo esc_html( $prop_comparison_left_heading ); ?>
					</p>
				<ul class="space-y-4" role="list" aria-label="<?php echo esc_attr( $prop_comparison_left_heading ); ?>">
					<?php foreach ( $prop_comparison_left as $item ) : ?>
							<li class="flex items-start gap-3">
								<span class="mt-0.5 flex-shrink-0 w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center" aria-hidden="true">
									<i class="fa-solid fa-xmark text-gray-400 text-xs"></i>
								</span>
								<span class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html( $item ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="rounded-2xl p-7 bg-[var(--deep-teal)]">
					<p class="text-base font-semibold text-[var(--warm-gold-hero)] uppercase tracking-wide mb-6" aria-hidden="true">
						<?php echo esc_html( $prop_comparison_right_heading ); ?>
					</p>
				<ul class="space-y-4" role="list" aria-label="<?php echo esc_attr( $prop_comparison_right_heading ); ?>">
					<?php foreach ( $prop_comparison_right as $item ) : ?>
							<li class="flex items-start gap-3">
								<span class="mt-0.5 flex-shrink-0 w-5 h-5 rounded-full bg-white/15 flex items-center justify-center" aria-hidden="true">
									<i class="fa-solid fa-check text-[var(--warm-gold-hero)] text-xs"></i>
								</span>
								<span class="text-white/90 text-sm leading-relaxed"><?php echo esc_html( $item ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- See the space -->
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]">
		<div class="container">
			<?php if ( $prop_gallery_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $prop_gallery_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl font-serif text-[var(--deep-teal)] text-center mb-10"><?php echo esc_html( $prop_gallery_heading ); ?></h2>
			<?php
			$alts = array(
				'Spacious open-plan living area with wide doorways and coastal decor',
				'Private garden with level patio and coastal plants',
				'Tankerton promenade at golden hour',
			);
			$src1 = $prop_gallery_1 ? wp_get_attachment_image_url( $prop_gallery_1, 'large' ) : '';
			$src2 = $prop_gallery_2 ? wp_get_attachment_image_url( $prop_gallery_2, 'large' ) : '';
			$src3 = $prop_gallery_3 ? wp_get_attachment_image_url( $prop_gallery_3, 'large' ) : '';
			?>
			<div class="prop-gallery-grid max-w-6xl mx-auto">
			<figure class="gallery-item gallery-main m-0">
				<?php if ( $src1 ) : ?>
					<img src="<?php echo esc_url( $src1 ); ?>" alt="<?php echo esc_attr( $alts[0] ); ?>" />
				<?php else : ?>
					<div class="gallery-placeholder">
						<span class="flex flex-col items-center gap-2 text-[var(--muted-grey)]">
					<i class="fa-solid fa-image text-3xl" aria-hidden="true"></i>
						<span class="font-semibold text-sm">Add image</span>
						</span>
					</div>
				<?php endif; ?>
			</figure>
			<figure class="gallery-item m-0">
				<?php if ( $src2 ) : ?>
					<img src="<?php echo esc_url( $src2 ); ?>" alt="<?php echo esc_attr( $alts[1] ); ?>" />
				<?php else : ?>
					<div class="gallery-placeholder">
						<span class="flex flex-col items-center gap-2 text-[var(--muted-grey)]">
					<i class="fa-solid fa-image text-2xl" aria-hidden="true"></i>
						<span class="font-semibold text-sm">Add image</span>
					</span>
				</div>
			<?php endif; ?>
		</figure>
		<figure class="gallery-item m-0">
			<?php if ( $src3 ) : ?>
				<img src="<?php echo esc_url( $src3 ); ?>" alt="<?php echo esc_attr( $alts[2] ); ?>" />
			<?php else : ?>
				<div class="gallery-placeholder">
					<span class="flex flex-col items-center gap-2 text-[var(--muted-grey)]">
						<i class="fa-solid fa-image text-2xl" aria-hidden="true"></i>
							<span class="font-semibold text-sm">Add image</span>
						</span>
					</div>
				<?php endif; ?>
			</figure>
			</div>
			<div class="mt-8 flex flex-wrap justify-center gap-3 max-w-6xl mx-auto">
				<?php foreach ( $prop_gallery_buttons as $bi => $btn ) : ?>
					<?php if ( $bi === 0 ) : ?>
						<a href="<?php echo esc_url( $btn['url'] ); ?>" class="btn btn-primary">
							<i class="fa-solid fa-images" aria-hidden="true"></i>
							<?php echo esc_html( $btn['label'] ); ?>
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( $btn['url'] ); ?>" class="btn btn-outline">
							<?php echo esc_html( $btn['label'] ); ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- The essentials -->
	<section class="py-16 md:py-24 bg-white">
		<div class="container">
			<?php if ( $prop_practical_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $prop_practical_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl font-serif text-[var(--deep-teal)] text-center mb-10"><?php echo esc_html( $prop_practical_heading ); ?></h2>
			<!-- Spec strip: single container, items divided by lines -->
			<div class="max-w-3xl mx-auto bg-[var(--bg-subtle)] rounded-2xl overflow-hidden grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-200/70">
				<?php
				$essentials_icons = array( 'fa-bed', 'fa-bath', 'fa-square-parking', 'fa-user-group' );
				$essentials_keys  = array( 'bedrooms', 'bathrooms', 'parking', 'sleeps' );
				foreach ( $essentials_keys as $k => $key ) :
					$item = $prop_essentials[ $key ];
				?>
				<div class="py-8 px-5 flex flex-col items-center text-center gap-1.5">
					<div class="w-10 h-10 rounded-full bg-[var(--deep-teal)]/10 flex items-center justify-center text-[var(--deep-teal)] mb-1" aria-hidden="true">
						<i class="fa-solid <?php echo esc_attr( $essentials_icons[ $k ] ); ?> text-base"></i>
					</div>
					<span class="text-3xl font-bold text-[var(--deep-teal)] leading-none"><?php echo esc_html( $item['value'] ); ?></span>
					<span class="text-gray-500 text-xs tracking-wide uppercase"><?php echo esc_html( $item['label'] ); ?></span>
				</div>
				<?php endforeach; ?>
			</div>
			<p class="text-center text-gray-500 text-sm mt-6">
				<?php echo esc_html__( 'Have a question about the property?', 'restwell-retreats' ); ?>
				<a href="<?php echo esc_url( $prop_confirm_details_url ); ?>" class="text-[var(--deep-teal)] font-medium hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded ml-0.5"><?php echo esc_html__( 'Get in touch', 'restwell-retreats' ); ?></a>
			</p>
		</div>
	</section>

	<!-- Explore Whitstable: filter by access, distance on each card, 6th CTA, a11y label + icon -->
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-labelledby="explore-whitstable-heading">
		<div class="container">
			<?php if ( $prop_nearby_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $prop_nearby_label ); ?></p>
			<?php endif; ?>
			<h2 id="explore-whitstable-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] text-center mb-6 md:mb-8 tracking-tight"><?php echo esc_html( $prop_nearby_heading ); ?></h2>
			<p class="text-gray-600 text-center max-w-lg mx-auto mb-10 md:mb-12 leading-relaxed"><?php echo esc_html__( 'Places and services near the property. Filter by what matters to you.', 'restwell-retreats' ); ?></p>

			<div class="explore-whitstable-filter flex flex-wrap justify-center gap-2 mb-6 md:mb-8" role="group" aria-label="<?php echo esc_attr__( 'Filter nearby places', 'restwell-retreats' ); ?>">
				<button type="button" class="explore-filter-pill rounded-full px-3 py-2 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-medium transition-all duration-200 ease-out motion-reduce:transition-none bg-white text-[var(--deep-teal)] border-2 border-gray-200 hover:border-[var(--deep-teal)]/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)]" data-filter="all" aria-pressed="true"><?php echo esc_html__( 'All', 'restwell-retreats' ); ?></button>
				<button type="button" class="explore-filter-pill rounded-full px-3 py-2 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-medium transition-all duration-200 ease-out motion-reduce:transition-none bg-white text-[var(--deep-teal)] border-2 border-gray-200 hover:border-[var(--deep-teal)]/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)]" data-filter="wheelchair-friendly" aria-pressed="false"><?php echo esc_html__( 'Wheelchair-friendly', 'restwell-retreats' ); ?></button>
				<button type="button" class="explore-filter-pill rounded-full px-3 py-2 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-medium transition-all duration-200 ease-out motion-reduce:transition-none bg-white text-[var(--deep-teal)] border-2 border-gray-200 hover:border-[var(--deep-teal)]/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)]" data-filter="quieter" aria-pressed="false"><?php echo esc_html__( 'Quieter', 'restwell-retreats' ); ?></button>
				<button type="button" class="explore-filter-pill rounded-full px-3 py-2 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-medium transition-all duration-200 ease-out motion-reduce:transition-none bg-white text-[var(--deep-teal)] border-2 border-gray-200 hover:border-[var(--deep-teal)]/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)]" data-filter="practical" aria-pressed="false"><?php echo esc_html__( 'Practical', 'restwell-retreats' ); ?></button>
			</div>
			<p id="explore-filter-status" class="explore-filter-status text-center text-gray-500 text-xs min-h-0 mb-6" aria-live="polite" aria-atomic="true"></p>

			<div id="explore-empty-state" class="hidden text-center py-12 px-4 max-w-md mx-auto" aria-live="polite" aria-atomic="true">
				<p class="text-gray-600 leading-relaxed mb-4"><?php echo esc_html__( 'No places match this filter. Try another or show all.', 'restwell-retreats' ); ?></p>
				<button type="button" class="explore-filter-show-all inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium bg-[var(--deep-teal)] text-white border-2 border-[var(--deep-teal)] focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)]" aria-label="<?php echo esc_attr__( 'Show all places', 'restwell-retreats' ); ?>"><?php echo esc_html__( 'Show all', 'restwell-retreats' ); ?></button>
			</div>

		<div class="grid sm:grid-cols-2 gap-5 max-w-4xl mx-auto" role="list" id="explore-whitstable-list">
			<?php foreach ( $nearby as $place ) :
				$card_icon = ! empty( $place['icon'] ) ? $place['icon'] : 'fa-location-dot';
				$card_type = ! empty( $place['type'] ) ? $place['type'] : '';
			?>
				<article class="explore-card bg-white rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgb(0,0,0,0.05)] flex flex-col border border-gray-100 transition-[box-shadow,transform] duration-200 ease-out hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 motion-reduce:transition-none motion-reduce:hover:translate-y-0" role="listitem" data-filter="<?php echo esc_attr( $place['filter'] ); ?>">

					<!-- 1. Meta row: icon + category type + distance, all left-aligned -->
					<div class="flex items-center gap-2 mb-2.5">
						<span class="shrink-0 size-6 rounded-full bg-[var(--deep-teal)]/10 flex items-center justify-center text-[var(--deep-teal)]" aria-hidden="true">
							<i class="fa-solid <?php echo esc_attr( $card_icon ); ?> text-[9px]"></i>
						</span>
						<?php if ( $card_type !== '' ) : ?>
							<span class="text-[10px] font-semibold uppercase tracking-widest text-[var(--deep-teal)]/55 whitespace-nowrap"><?php echo wp_kses_post( $card_type ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $place['distance'] ) ) : ?>
							<span class="text-[10px] text-gray-400 whitespace-nowrap before:content-['·'] before:mr-2" aria-label="<?php echo esc_attr__( 'Distance from property', 'restwell-retreats' ); ?>"><?php echo esc_html( $place['distance'] ); ?></span>
						<?php endif; ?>
					</div>

					<!-- 2. Title: now left-aligned with body text below -->
					<h3 class="text-base font-semibold font-serif text-[var(--deep-teal)] leading-snug mb-3">
						<?php if ( ! empty( $place['map_url'] ) ) : ?>
							<a href="<?php echo esc_url( $place['map_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="group inline-flex items-baseline gap-1.5 text-[var(--deep-teal)] no-underline hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded-sm">
								<?php echo esc_html( $place['title'] ); ?>
								<i class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-40 group-hover:opacity-70 transition-opacity shrink-0" aria-hidden="true"></i>
								<span class="sr-only"><?php echo esc_html__( '(opens in Google Maps)', 'restwell-retreats' ); ?></span>
							</a>
						<?php else : ?>
							<?php echo esc_html( $place['title'] ); ?>
						<?php endif; ?>
					</h3>

					<!-- 3. Body text -->
					<div class="text-gray-600 leading-relaxed text-sm flex-1 space-y-2">
						<?php echo wp_kses_post( wpautop( $place['body'] ) ); ?>
					</div>

					<!-- 4. Access footer -->
					<?php if ( ! empty( $place['acc'] ) ) : ?>
						<div class="mt-3 pt-3 border-t border-gray-100" aria-label="<?php echo esc_attr__( 'Accessibility information', 'restwell-retreats' ); ?>">
							<p class="text-gray-500 text-xs leading-relaxed flex items-start gap-1.5">
								<i class="fa-solid fa-universal-access shrink-0 mt-[3px]" aria-hidden="true"></i>
								<span><?php echo esc_html( $place['acc'] ); ?></span>
							</p>
						</div>
					<?php endif; ?>

				</article>
			<?php endforeach; ?>

				<?php if ( $prop_nearby_cta_label !== '' && $prop_nearby_cta_url !== '' ) : ?>
				<article class="explore-card explore-card-cta bg-[var(--deep-teal)]/5 rounded-2xl p-5 sm:p-6 flex flex-col border border-dashed border-[var(--deep-teal)]/20 items-center justify-center text-center min-h-[160px]" role="listitem" data-filter="all">
					<i class="fa-solid fa-envelope text-2xl text-[var(--deep-teal)] mb-3" aria-hidden="true"></i>
					<p class="text-[var(--deep-teal)] font-medium text-sm mb-3"><?php echo esc_html( $prop_nearby_cta_label ); ?></p>
					<a href="<?php echo esc_url( $prop_nearby_cta_url ); ?>" class="btn btn-primary btn-sm"><?php echo esc_html__( 'Get in touch', 'restwell-retreats' ); ?></a>
				</article>
			<?php else : ?>
				<?php
				$enquire_url = home_url( '/enquire/' );
				$acc_url     = home_url( '/accessibility/' );
				?>
				<article class="explore-card explore-card-cta bg-[var(--deep-teal)]/5 rounded-2xl p-5 sm:p-6 flex flex-col border border-dashed border-[var(--deep-teal)]/20 items-center justify-center text-center min-h-[160px]" role="listitem" data-filter="all">
					<i class="fa-solid fa-universal-access text-2xl text-[var(--deep-teal)] mb-3" aria-hidden="true"></i>
					<p class="text-[var(--deep-teal)] font-medium text-sm mb-3"><?php echo esc_html__( 'Questions about access?', 'restwell-retreats' ); ?></p>
					<a href="<?php echo esc_url( $enquire_url ); ?>" class="btn btn-primary btn-sm"><?php echo esc_html__( 'Get in touch', 'restwell-retreats' ); ?></a>
					</article>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="py-16 md:py-20 bg-[var(--deep-teal)] text-center">
		<div class="container">
			<h2 class="text-white text-3xl font-serif mb-4"><?php echo esc_html( $prop_cta_heading ); ?></h2>
			<p class="text-white/90 text-lg mb-8 max-w-md mx-auto leading-relaxed"><?php echo esc_html( $prop_cta_body ); ?></p>
		<a href="<?php echo esc_url( $prop_cta_url ); ?>" class="btn btn-gold">
			<?php echo esc_html( $prop_cta_btn ); ?>
			<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
		</a>
			<?php if ( $prop_cta_promise !== '' ) : ?>
				<p class="text-white/90 text-sm mt-4"><?php echo esc_html( $prop_cta_promise ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
