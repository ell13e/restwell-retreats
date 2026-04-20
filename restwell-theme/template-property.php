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
$d   = restwell_get_property_page_defaults();
$m   = function ( $key ) use ( $pid, $d ) {
	return restwell_post_meta_or_default( $pid, $key, $d );
};
$m_url = function ( $key ) use ( $pid, $d ) {
	return restwell_post_meta_url( $pid, $key, $d );
};

$prop_hero_label               = $m( 'prop_hero_label' );
$prop_hero_heading             = $m( 'prop_hero_heading' );
$prop_hero_subtitle            = $m( 'prop_hero_subtitle' );
$prop_hero_image_id            = (int) $m( 'prop_hero_image_id' );
$prop_hero_cta_text            = $m( 'prop_hero_cta_text' );
$prop_hero_cta_url             = esc_url( $m_url( 'prop_hero_cta_url' ) );
$prop_hero_cta_promise         = $m( 'prop_hero_cta_promise' );
$prop_hero_cta_secondary_text  = $m( 'prop_hero_cta_secondary_text' );
$prop_hero_cta_secondary_url   = esc_url( $m_url( 'prop_hero_cta_secondary_url' ) );

$prop_home_heading = $m( 'prop_home_heading' );
$prop_home_label   = $m( 'prop_home_label' );
$prop_home_cards   = array(
	array(
		'title' => $m( 'prop_home_1_title' ),
		'body'  => $m( 'prop_home_1_body' ),
	),
	array(
		'title' => $m( 'prop_home_2_title' ),
		'body'  => $m( 'prop_home_2_body' ),
	),
	array(
		'title' => $m( 'prop_home_3_title' ),
		'body'  => $m( 'prop_home_3_body' ),
	),
);

$prop_dignity_heading  = $m( 'prop_dignity_heading' );
$prop_dignity_label    = $m( 'prop_dignity_label' );
$prop_dignity_image_id = (int) $m( 'prop_dignity_image_id' );
$prop_dignity_src      = $prop_dignity_image_id ? wp_get_attachment_image_url( $prop_dignity_image_id, 'large' ) : '';

$prop_features = array();
for ( $fi = 1; $fi <= 8; $fi++ ) {
	$prop_features[] = array(
		'title' => $m( "prop_feature_{$fi}" ),
		'desc'  => $m( "prop_feature_{$fi}_desc" ),
	);
}

$prop_overview_heading = $m( 'prop_overview_heading' );
$prop_overview_body    = $m( 'prop_overview_body' );
if ( metadata_exists( 'post', $pid, 'prop_dignity_body' ) ) {
	$prop_dignity_body_raw = (string) get_post_meta( $pid, 'prop_dignity_body', true );
	$prop_dignity_body     = trim( $prop_dignity_body_raw ) !== '' ? $prop_dignity_body_raw : $prop_overview_body;
} else {
	$prop_dignity_body = (string) $m( 'prop_dignity_body' );
}

$prop_features_label   = $m( 'prop_features_label' );
$prop_features_heading = $m( 'prop_features_heading' );

$prop_acc_label     = $m( 'prop_acc_label' );
$prop_acc_heading   = $m( 'prop_acc_heading' );
$prop_acc_intro     = $m( 'prop_acc_intro' );
$prop_acc_confirmed = $m( 'prop_acc_confirmed' );

// Comparison: why not just an accessible hotel?
$prop_comparison_label           = $m( 'prop_comparison_label' );
$prop_comparison_heading         = $m( 'prop_comparison_heading' );
$prop_comparison_intro           = $m( 'prop_comparison_intro' );
$prop_comparison_left_heading   = $m( 'prop_comparison_left_heading' );
$prop_comparison_right_heading   = $m( 'prop_comparison_right_heading' );
$prop_comparison_left            = array();
$prop_comparison_right           = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$prop_comparison_left[]  = $m( "prop_comparison_left_{$i}" );
	$prop_comparison_right[] = $m( "prop_comparison_right_{$i}" );
}

$prop_gallery_label   = $m( 'prop_gallery_label' );
$prop_gallery_heading = $m( 'prop_gallery_heading' );
$prop_gallery_1       = (int) $m( 'prop_gallery_1_image_id' );
$prop_gallery_2       = (int) $m( 'prop_gallery_2_image_id' );
$prop_gallery_3       = (int) $m( 'prop_gallery_3_image_id' );

$prop_practical_label   = $m( 'prop_practical_label' );
$prop_practical_heading = $m( 'prop_practical_heading' );
$prop_bedrooms          = $m( 'prop_bedrooms' );
$prop_bathroom          = $m( 'prop_bathroom' );
$prop_parking           = $m( 'prop_parking' );
$prop_distances         = $m( 'prop_distances' );
// Display values for essentials cards (number or short label).
$prop_essentials = array(
	'bedrooms'  => array(
		'value' => $m( 'prop_bedrooms_count' ),
		'label' => __( 'Bedrooms', 'restwell-retreats' ),
	),
	'bathrooms' => array(
		'value' => $m( 'prop_bathrooms_count' ),
		'label' => __( 'Bathrooms', 'restwell-retreats' ),
	),
	'parking'   => array(
		'value' => $m( 'prop_parking' ),
		'label' => $m( 'prop_parking_label' ),
	),
	'sleeps'    => array(
		'value' => $m( 'prop_sleeps_value' ),
		'label' => $m( 'prop_sleeps_label' ),
	),
);
$prop_confirm_details_url = esc_url( $m_url( 'prop_confirm_details_url' ) );

// "See the space" CTAs: show Photos-style and 3D (and video) actions only when matching media / links exist.
$prop_gallery_has_images = false;
foreach ( array( 'prop_gallery_1_image_id', 'prop_gallery_2_image_id', 'prop_gallery_3_image_id' ) as $_rw_gallery_key ) {
	$_rw_gid = (int) $m( $_rw_gallery_key );
	if ( $_rw_gid && wp_attachment_is_image( $_rw_gid ) ) {
		$prop_gallery_has_images = true;
		break;
	}
}

$prop_gallery_btn_2_url_raw = trim( (string) $m( 'prop_gallery_btn_2_url' ) );
$prop_gallery_btn_3_url_raw = trim( (string) $m( 'prop_gallery_btn_3_url' ) );

$prop_gallery_external_link_set = function ( $raw_url ) {
	$t = trim( (string) $raw_url );
	if ( $t === '' ) {
		return false;
	}
	$e = esc_url( $t );
	return $e !== '' && $e !== '#';
};

if ( metadata_exists( 'post', $pid, 'prop_gallery_btn_1_label' ) ) {
	$prop_gallery_btn_1_label_meta = trim( (string) get_post_meta( $pid, 'prop_gallery_btn_1_label', true ) );
	$prop_gallery_btn_1_label      = $prop_gallery_btn_1_label_meta !== '' ? $prop_gallery_btn_1_label_meta : __( 'See all photos', 'restwell-retreats' );
	$prop_gallery_btn_1_needs_images = ( $prop_gallery_btn_1_label_meta === '' || (bool) preg_match( '/photo|gallery|pictures?|images?/i', $prop_gallery_btn_1_label ) );
} else {
	$prop_gallery_btn_1_label        = (string) $m( 'prop_gallery_btn_1_label' );
	$prop_gallery_btn_1_needs_images = (bool) preg_match( '/photo|gallery|pictures?|images?/i', $prop_gallery_btn_1_label );
}
// Enquiry-style CTAs always show; photo/gallery wording waits for uploaded gallery images.

$prop_gallery_buttons = array();
if ( ! $prop_gallery_btn_1_needs_images || $prop_gallery_has_images ) {
	$prop_gallery_buttons[] = array(
		'label' => $prop_gallery_btn_1_label,
		'url'   => esc_url( $m_url( 'prop_gallery_btn_1_url' ) ),
		'icon'  => $prop_gallery_btn_1_needs_images ? 'images' : 'calendar-plus',
	);
}
if ( $prop_gallery_external_link_set( $prop_gallery_btn_2_url_raw ) ) {
	$lbl2 = trim( (string) $m( 'prop_gallery_btn_2_label' ) );
	if ( $lbl2 === '' ) {
		$lbl2 = __( 'Explore video', 'restwell-retreats' );
	}
	$prop_gallery_buttons[] = array(
		'label' => $lbl2,
		'url'   => esc_url( $prop_gallery_btn_2_url_raw ),
		'icon'  => 'play-circle',
	);
}
if ( $prop_gallery_external_link_set( $prop_gallery_btn_3_url_raw ) ) {
	$lbl3 = trim( (string) $m( 'prop_gallery_btn_3_label' ) );
	if ( $lbl3 === '' ) {
		$lbl3 = __( 'Take 3D Tour', 'restwell-retreats' );
	}
	$prop_gallery_buttons[] = array(
		'label' => $lbl3,
		'url'   => esc_url( $prop_gallery_btn_3_url_raw ),
		'icon'  => 'cube',
	);
}

$prop_nearby_label   = $m( 'prop_nearby_label' );
$prop_nearby_heading = $m( 'prop_nearby_heading' );
$rw_nearby_icons = array( 'fork-knife', 'drop', 'shopping-bag', 'umbrella', 'shopping-cart', 'pill', 'bus', 'first-aid' );
$rw_nearby_types = array( 'Food &amp; Drink', 'The Coast', 'Town &amp; Shops', 'The Coast', 'Practical', 'Wellbeing', 'Transport', 'Wellbeing' );
$nearby          = array();
for ( $ni = 1; $ni <= 8; $ni++ ) {
	$nearby[] = array(
		'title'    => $m( "prop_nearby_{$ni}_title" ),
		'body'     => $m( "prop_nearby_{$ni}_body" ),
		'acc'      => $m( "prop_nearby_{$ni}_acc" ),
		'distance' => $m( "prop_nearby_{$ni}_distance" ),
		'filter'   => $m( "prop_nearby_{$ni}_filter" ),
		'map_url'  => $m( "prop_nearby_{$ni}_map_url" ),
		'icon'     => $rw_nearby_icons[ $ni - 1 ],
		'type'     => $rw_nearby_types[ $ni - 1 ],
	);
}
$prop_nearby_cta_label = $m( 'prop_nearby_cta_label' );
$prop_nearby_cta_url   = esc_url( $m_url( 'prop_nearby_cta_url' ) );
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
	<section class="rw-section-y bg-[var(--bg-subtle)]">
		<div class="container">
			<?php if ( $prop_home_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $prop_home_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl font-serif text-[var(--deep-teal)] text-center mb-12 md:mb-16"><?php echo esc_html( $prop_home_heading ); ?></h2>
			<div class="grid md:grid-cols-3 gap-8 lg:gap-10 max-w-5xl mx-auto">
				<?php
				$home_icons = array( 'house', 'heart', 'map-pin' );
				foreach ( $prop_home_cards as $i => $card ) :
				?>
				<div class="rw-surface-card rw-card-hover-lift p-8 flex flex-col items-center text-center">
					<div class="text-[var(--deep-teal)] mb-5" aria-hidden="true">
						<i class="ph-bold ph-<?php echo esc_attr( $home_icons[ $i ] ); ?> text-3xl"></i>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3 leading-tight"><?php echo esc_html( $card['title'] ); ?></h3>
					<p class="rw-copy-body leading-relaxed text-sm md:text-base"><?php echo esc_html( $card['body'] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Designed for dignity and comfort -->
	<section class="rw-section-y bg-[var(--soft-sand)] overflow-hidden">
		<div class="container">
			<div class="grid md:grid-cols-2 gap-0 items-stretch max-w-6xl mx-auto">
				<?php if ( $prop_dignity_src ) : ?>
					<div class="relative order-2 md:order-1">
						<img src="<?php echo esc_url( $prop_dignity_src ); ?>" alt="<?php echo esc_attr( $prop_dignity_heading ); ?>" class="rounded-2xl w-full h-full min-h-[280px] object-cover aspect-[4/3]" />
					</div>
				<?php endif; ?>
			<div class="order-1 md:order-2 <?php echo $prop_dignity_src ? 'md:-ml-12 lg:-ml-16 md:pl-8 lg:pl-12 flex flex-col justify-center' : 'md:col-span-2'; ?>">
			<div class="rw-surface-card p-8 md:p-10 lg:p-12 <?php echo $prop_dignity_src ? '' : 'max-w-2xl mx-auto'; ?>">
					<div class="rw-section-head rw-section-head--left">
					<?php if ( $prop_dignity_label !== '' ) : ?>
						<p class="section-label"><?php echo esc_html( $prop_dignity_label ); ?></p>
					<?php endif; ?>
					<h2 class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php echo esc_html( $prop_dignity_heading ); ?></h2>
					</div>
						<div class="rw-copy-body text-lg leading-relaxed rw-prose-stack max-w-prose">
							<?php echo wp_kses_post( wpautop( $prop_dignity_body ) ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Adapted property highlights: icons align to prop_feature_1…8 defaults in theme-setup (order matters if CMS copy changes). -->
	<section class="rw-section-y bg-[var(--bg-subtle)]">
		<div class="container">
			<div class="rw-section-head rw-section-head--center">
			<?php if ( $prop_features_label !== '' ) : ?>
				<p class="section-label"><?php echo esc_html( $prop_features_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php echo esc_html( $prop_features_heading ); ?></h2>
			</div>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 rw-gap-grid max-w-5xl mx-auto">
				<?php
				// Slots 1–8 (pair with prop_feature_{n} defaults): hoist, wet room, bed, doors, step-free, garden, kitchen, Wi‑Fi.
				// Kitchen uses cooking-pot (facility), not fork-knife (reads as dining — awkward beside disability/access messaging).
				$feature_icons = array( 'wheelchair', 'shower', 'bed', 'door-open', 'path', 'plant', 'cooking-pot', 'wifi-high' );
				foreach ( $prop_features as $j => $feature ) :
				?>
				<div class="rw-surface-card rw-card-hover-lift p-6 flex flex-col items-center text-center gap-3 motion-reduce:hover:translate-y-0 motion-reduce:transition-none">
					<div class="text-[var(--deep-teal)]" aria-hidden="true">
						<i class="ph-bold ph-<?php echo esc_attr( $feature_icons[ $j ] ); ?> text-2xl"></i>
					</div>
					<h3 class="text-[var(--deep-teal)] font-semibold text-base"><?php echo esc_html( $feature['title'] ); ?></h3>
					<p class="rw-copy-body text-sm leading-relaxed"><?php echo esc_html( $feature['desc'] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Accessibility you can rely on -->
	<section class="rw-section-y bg-white">
		<div class="container max-w-4xl">
			<div class="rw-stack rw-mb-section max-w-prose">
			<?php if ( $prop_acc_label !== '' ) : ?>
				<p class="section-label"><?php echo esc_html( $prop_acc_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php echo esc_html( $prop_acc_heading ); ?></h2>
			<p class="rw-copy-body m-0 leading-relaxed max-w-prose"><?php echo esc_html( $prop_acc_intro ); ?></p>
			</div>
			<div class="grid md:grid-cols-2 rw-gap-grid-lg items-start">
				<!-- Verified features list -->
				<ul class="space-y-3" aria-label="<?php echo esc_attr__( 'Verified accessibility features', 'restwell-retreats' ); ?>">
					<?php foreach ( array_filter( array_map( 'trim', explode( "\n", $prop_acc_confirmed ) ) ) as $item ) : ?>
						<li class="flex items-start gap-3">
							<span class="w-6 h-6 rounded-full bg-[#A8D5D0]/40 flex items-center justify-center flex-shrink-0 mt-0.5 text-[var(--deep-teal)]" aria-hidden="true">
								<i class="ph-bold ph-check text-xs"></i>
							</span>
								<span class="rw-copy-body leading-snug"><?php echo esc_html( $item ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
				<!-- Specific requirements card -->
				<div class="rw-surface-card p-7 flex flex-col gap-5">
					<div>
						<h3 class="text-lg font-semibold font-serif text-[var(--deep-teal)] mb-2"><?php echo esc_html__( 'Have a specific requirement?', 'restwell-retreats' ); ?></h3>
						<p class="rw-copy-body text-sm leading-relaxed"><?php echo esc_html__( 'Every guest is different. Whether you need to know about the bedroom hoist layout, particular bathroom equipment, bed configuration, or sensory environment, we are happy to talk it through before you commit to anything.', 'restwell-retreats' ); ?></p>
					</div>
					<a href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>" class="btn btn-primary self-start">
						<?php echo esc_html__( 'Ask us directly', 'restwell-retreats' ); ?>
						<i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Why not just an accessible hotel? -->
	<section class="rw-section-y bg-[var(--soft-sand)]">
		<div class="container">
			<div class="rw-section-head rw-section-head--center rw-section-head--wide text-center">
				<p class="section-label"><?php echo esc_html( $prop_comparison_label ); ?></p>
				<h2 class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 section-heading">
					<?php echo esc_html( $prop_comparison_heading ); ?>
				</h2>
				<p class="rw-copy-body leading-relaxed max-w-prose mx-auto m-0">
					<?php echo esc_html( $prop_comparison_intro ); ?>
				</p>
			</div>
			<div class="grid md:grid-cols-2 rw-gap-grid max-w-4xl mx-auto">
				<div class="rounded-2xl p-7 bg-[var(--bg-subtle)] border border-gray-200/60">
					<p class="text-base font-semibold text-gray-500 uppercase tracking-wide mb-6" aria-hidden="true">
						<?php echo esc_html( $prop_comparison_left_heading ); ?>
					</p>
				<ul class="space-y-4" role="list" aria-label="<?php echo esc_attr( $prop_comparison_left_heading ); ?>">
					<?php foreach ( $prop_comparison_left as $item ) : ?>
							<li class="flex items-start gap-3">
								<span class="mt-0.5 flex-shrink-0 w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center" aria-hidden="true">
									<i class="ph-bold ph-x text-gray-400 text-xs"></i>
								</span>
								<span class="rw-copy-body text-sm leading-relaxed"><?php echo esc_html( $item ); ?></span>
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
									<i class="ph-bold ph-check text-[var(--warm-gold-hero)] text-xs"></i>
								</span>
								<span class="text-white text-sm leading-relaxed"><?php echo esc_html( $item ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- See the space -->
	<section class="rw-section-y bg-[var(--bg-subtle)]">
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
					<i class="ph-bold ph-image text-3xl" aria-hidden="true"></i>
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
					<i class="ph-bold ph-image text-2xl" aria-hidden="true"></i>
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
						<i class="ph-bold ph-image text-2xl" aria-hidden="true"></i>
							<span class="font-semibold text-sm">Add image</span>
						</span>
					</div>
				<?php endif; ?>
			</figure>
			</div>
			<?php if ( ! empty( $prop_gallery_buttons ) ) : ?>
			<div class="mt-8 flex flex-wrap justify-center gap-3 max-w-6xl mx-auto">
				<?php
				$prop_gallery_icon_allow = array( 'images', 'calendar-plus', 'play-circle', 'cube' );
				foreach ( $prop_gallery_buttons as $bi => $btn ) :
					$_gicon = isset( $btn['icon'] ) && in_array( $btn['icon'], $prop_gallery_icon_allow, true ) ? $btn['icon'] : 'calendar-plus';
					?>
					<?php if ( $bi === 0 ) : ?>
						<a href="<?php echo esc_url( $btn['url'] ); ?>" class="btn btn-primary">
							<i class="ph-bold ph-<?php echo esc_attr( $_gicon ); ?>" aria-hidden="true"></i>
							<?php echo esc_html( $btn['label'] ); ?>
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( $btn['url'] ); ?>" class="btn btn-outline">
							<i class="ph-bold ph-<?php echo esc_attr( $_gicon ); ?>" aria-hidden="true"></i>
							<?php echo esc_html( $btn['label'] ); ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</section>

	<!-- The essentials -->
	<section class="rw-section-y bg-white">
		<div class="container">
			<?php if ( $prop_practical_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $prop_practical_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl font-serif text-[var(--deep-teal)] text-center mb-10"><?php echo esc_html( $prop_practical_heading ); ?></h2>
			<!-- Spec strip: single container, items divided by lines -->
			<div class="max-w-3xl mx-auto bg-[var(--bg-subtle)] rounded-2xl overflow-hidden grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-200/70">
				<?php
				$essentials_icons = array( 'bed', 'bathtub', 'garage', 'users-three' );
				$essentials_keys  = array( 'bedrooms', 'bathrooms', 'parking', 'sleeps' );
				foreach ( $essentials_keys as $k => $key ) :
					$item = $prop_essentials[ $key ];
					// Parking and sleeps often need more horizontal space than counts; span full width on small screens.
					$span_class = ( $k >= 2 ) ? ' col-span-2 md:col-span-1' : '';
					?>
				<div class="py-8 px-5 flex flex-col items-center text-center gap-1.5<?php echo esc_attr( $span_class ); ?>">
					<div class="w-10 h-10 rounded-full bg-[var(--deep-teal)]/10 flex items-center justify-center text-[var(--deep-teal)] mb-1" aria-hidden="true">
						<i class="ph-bold ph-<?php echo esc_attr( $essentials_icons[ $k ] ); ?> text-base"></i>
					</div>
					<span class="text-2xl sm:text-3xl font-bold text-[var(--deep-teal)] leading-tight text-pretty max-w-xs mx-auto"><?php echo esc_html( $item['value'] ); ?></span>
					<span class="text-gray-500 text-xs tracking-wide uppercase"><?php echo esc_html( $item['label'] ); ?></span>
				</div>
				<?php endforeach; ?>
			</div>
			<p class="text-center rw-copy-muted text-sm mt-6">
				<?php echo esc_html__( 'Have a question about the property?', 'restwell-retreats' ); ?>
				<a href="<?php echo esc_url( $prop_confirm_details_url ); ?>" class="text-[var(--deep-teal)] font-medium hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded ml-0.5"><?php echo esc_html__( 'Get in touch', 'restwell-retreats' ); ?></a>
			</p>
		</div>
	</section>

	<!-- Explore Whitstable: filter by access, distance on each card, 6th CTA, a11y label + icon -->
	<section class="rw-section-y bg-[var(--bg-subtle)]" aria-labelledby="explore-whitstable-heading">
		<div class="container">
			<?php if ( $prop_nearby_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $prop_nearby_label ); ?></p>
			<?php endif; ?>
			<h2 id="explore-whitstable-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] text-center mb-6 md:mb-8 tracking-tight"><?php echo esc_html( $prop_nearby_heading ); ?></h2>
			<p class="rw-copy-body text-center max-w-lg mx-auto mb-10 md:mb-12 leading-relaxed"><?php echo esc_html__( 'Places and services near the property. Filter by what matters to you.', 'restwell-retreats' ); ?></p>

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
				$card_icon = ! empty( $place['icon'] ) ? $place['icon'] : 'map-pin';
				$card_type = ! empty( $place['type'] ) ? $place['type'] : '';
			?>
				<article class="explore-card bg-white rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgb(0,0,0,0.05)] flex flex-col border border-gray-100 transition-[box-shadow,transform] duration-200 ease-out hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 motion-reduce:transition-none motion-reduce:hover:translate-y-0" role="listitem" data-filter="<?php echo esc_attr( $place['filter'] ); ?>">

					<!-- 1. Meta row: icon + category type + distance, all left-aligned -->
					<div class="flex items-center gap-2 mb-2.5">
						<span class="shrink-0 size-6 rounded-full bg-[var(--deep-teal)]/10 flex items-center justify-center text-[var(--deep-teal)]" aria-hidden="true">
							<i class="ph-bold ph-<?php echo esc_attr( $card_icon ); ?> text-[9px]"></i>
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
								<i class="ph-bold ph-arrow-square-out text-[10px] opacity-40 group-hover:opacity-70 transition-opacity shrink-0" aria-hidden="true"></i>
								<span class="sr-only"><?php echo esc_html__( '(opens in Google Maps)', 'restwell-retreats' ); ?></span>
							</a>
						<?php else : ?>
							<?php echo esc_html( $place['title'] ); ?>
						<?php endif; ?>
					</h3>

					<!-- 3. Body text -->
					<div class="rw-copy-body leading-relaxed text-sm flex-1 space-y-2">
						<?php echo wp_kses_post( wpautop( $place['body'] ) ); ?>
					</div>

					<!-- 4. Access footer -->
					<?php if ( ! empty( $place['acc'] ) ) : ?>
						<div class="mt-3 pt-3 border-t border-gray-100" aria-label="<?php echo esc_attr__( 'Accessibility information', 'restwell-retreats' ); ?>">
							<p class="rw-copy-muted text-xs leading-relaxed flex items-start gap-1.5">
								<i class="ph-bold ph-wheelchair shrink-0 mt-[3px]" aria-hidden="true"></i>
								<span><?php echo esc_html( $place['acc'] ); ?></span>
							</p>
						</div>
					<?php endif; ?>

				</article>
			<?php endforeach; ?>

				<?php if ( $prop_nearby_cta_label !== '' && $prop_nearby_cta_url !== '' ) : ?>
				<article class="explore-card explore-card-cta bg-[var(--deep-teal)]/5 rounded-2xl p-5 sm:p-6 flex flex-col border border-dashed border-[var(--deep-teal)]/20 items-center justify-center text-center min-h-[160px]" role="listitem" data-filter="all">
					<i class="ph-bold ph-envelope-simple text-2xl text-[var(--deep-teal)] mb-3" aria-hidden="true"></i>
					<p class="text-[var(--deep-teal)] font-medium text-sm mb-3"><?php echo esc_html( $prop_nearby_cta_label ); ?></p>
					<a href="<?php echo esc_url( $prop_nearby_cta_url ); ?>" class="btn btn-primary btn-sm"><?php echo esc_html__( 'Get in touch', 'restwell-retreats' ); ?></a>
				</article>
			<?php else : ?>
				<?php
				$enquire_url = home_url( '/enquire/' );
				$acc_url     = home_url( '/accessibility/' );
				?>
				<article class="explore-card explore-card-cta bg-[var(--deep-teal)]/5 rounded-2xl p-5 sm:p-6 flex flex-col border border-dashed border-[var(--deep-teal)]/20 items-center justify-center text-center min-h-[160px]" role="listitem" data-filter="all">
					<i class="ph-bold ph-wheelchair text-2xl text-[var(--deep-teal)] mb-3" aria-hidden="true"></i>
					<p class="text-[var(--deep-teal)] font-medium text-sm mb-3"><?php echo esc_html__( 'Questions about access?', 'restwell-retreats' ); ?></p>
					<a href="<?php echo esc_url( $enquire_url ); ?>" class="btn btn-primary btn-sm"><?php echo esc_html__( 'Get in touch', 'restwell-retreats' ); ?></a>
					</article>
				<?php endif; ?>
			</div>
		</div>
	</section>

</main>
<?php get_footer(); ?>
