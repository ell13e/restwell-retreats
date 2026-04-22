<?php
/**
 * Template Name: Whitstable Guide
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

$hero_image_id = (int) get_post_meta( $pid, 'wg_hero_image_id', true );
$label            = (string) get_post_meta( $pid, 'wg_label', true ) ?: 'Whitstable & Kent coast';
$heading          = (string) get_post_meta( $pid, 'wg_heading', true ) ?: 'A practical local guide for your stay.';
$intro            = (string) get_post_meta( $pid, 'wg_intro', true ) ?: 'From seafront walks to nearby towns, here is where guests usually go, and what to think about if accessibility matters to your plans.';
$hero_heading_id = 'wg-hero-heading';

$sections = array(
	array(
		'key'     => 'about',
		'eyebrow' => 'Local context',
		'heading' => (string) get_post_meta( $pid, 'wg_about_heading', true ) ?: 'About Whitstable',
		'body'    => (string) get_post_meta( $pid, 'wg_about_body', true ) ?: "Whitstable is a small coastal town known for its harbour, independent high street, and oysters. The town centre is compact and mostly flat, with a mix of cafes, pubs, galleries, and independent shops along Harbour Street and the high street.\nFor wheelchair users: most of the town centre is paved, but some older streets have uneven surfaces and narrow pavements. The harbour area is generally accessible, though parts near the fish market can be uneven or crowded at weekends. There is accessible public parking at Gorrell Tank car park (Canterbury City Council, pay and display) close to the high street.\nTankerton, just east of the town centre, has a wide, surfaced promenade that runs along the seafront: flat, smooth, and suitable for wheelchairs and powerchairs. Free parking is available along Marine Parade at the top. The grassy slopes between the road and the promenade are steep, so use the paved paths to reach the seafront. At low tide, a natural shingle spit called \"The Street\" appears and extends about 750 metres out to sea. It is interesting to see, but not accessible for wheelchair users as it is loose shingle.",
		'bg'      => 'bg-white',
	),
	array(
		'key'     => 'towns',
		'eyebrow' => 'Nearby',
		'heading' => (string) get_post_meta( $pid, 'wg_towns_heading', true ) ?: 'Nearby towns worth visiting',
		'body'    => (string) get_post_meta( $pid, 'wg_towns_body', true ) ?: "Canterbury (about 8 miles): the cathedral city. Good for a day out with shops, restaurants, and the cathedral itself. The city centre is mostly pedestrianised and largely flat, though some older streets are cobbled. There are several accessible car parks including the Whitefriars shopping centre. The cathedral has wheelchair access to most areas.\nFaversham (about 7 miles): a quieter market town with independent shops and pubs. The town centre is compact and mostly flat. Market days are Tuesday, Friday, and Saturday. A good option if you want a change of scene without a long drive.\nHerne Bay (about 4 miles): traditional seafront with a long, flat promenade that is fully paved and accessible. There is also a pier (partially rebuilt), amusement arcades, and fish and chips. An easy option for a couple of hours by the sea.",
		'bg'      => 'bg-[var(--bg-subtle)]',
	),
	array(
		'key'     => 'getting_here',
		'eyebrow' => 'Travel',
		'heading' => (string) get_post_meta( $pid, 'wg_getting_here_heading', true ) ?: 'Getting here',
		'body'    => (string) get_post_meta( $pid, 'wg_getting_here_body', true ) ?: "By car: Whitstable is reached via the M2 and A299 from London (about 60 miles, usually around 90 minutes depending on traffic). The property has off-street parking with enough space for adapted vehicles, including those with rear or side ramps.\nBy train: Whitstable station has direct services to London Victoria and London St Pancras (via Canterbury West or Faversham). Journey time is roughly 75-90 minutes. We do not verify station layout or platform access here; details change, so check National Rail Enquiries or your operator before you travel. From the station to the property is about a 10-minute drive; we can advise on taxi options if needed.",
		'bg'      => 'bg-[var(--soft-sand)]',
	),
	array(
		'key'     => 'getting_around',
		'eyebrow' => 'During your stay',
		'heading' => (string) get_post_meta( $pid, 'wg_getting_around_heading', true ) ?: 'Getting around during your stay',
		'body'    => (string) get_post_meta( $pid, 'wg_getting_around_body', true ) ?: "Most guests find a car is the easiest way to get around, especially if you need to transport equipment. The property parking is level and spacious.\nStagecoach South East routes connect Whitstable, Canterbury, and Herne Bay. From near The Plough, the 400 bus runs into Canterbury bus station and also serves the seafront and harbour area. Buses are usually low-floor, but ramp use and wheelchair space can vary on the day, so check before travel if you need a guaranteed accessible space.\nFor live times and route changes, use Google Maps or the Stagecoach app.\nIf you use a mobility scooter or powerchair, the Tankerton promenade and Whitstable seafront are both suitable surfaces. The town centre is mixed: some pavements are narrow or uneven in older parts.\nWheelchair hire is available locally. Ask us before your stay and we can share contact details for trusted suppliers in the area.",
		'bg'      => 'bg-white',
	),
);

$access_cards = array(
	array(
		'title' => 'Tankerton promenade',
		'body'  => 'The promenade route is wide, level, and surfaced, which makes it the most practical seafront option for many wheelchair users.',
		'note'  => 'The slopes down are steeper; many guests stay on the top route for easier access.',
		'icon'  => 'waves',
	),
	array(
		'title' => 'Whitstable harbour area',
		'body'  => 'Harbour-side routes are lively and mostly level, with some uneven sections and busier pedestrian flow at peak times.',
		'note'  => 'Weekday mornings are usually easier for quieter movement.',
		'icon'  => 'anchor',
	),
	array(
		'title' => 'Town centre and Harbour Street',
		'body'  => 'Shops and cafes are close together, but some pavements are narrower around older parts of town.',
		'note'  => 'Plan extra time if you need wider turning space or quieter access.',
		'icon'  => 'storefront',
	),
	array(
		'title' => 'Practical services',
		'body'  => 'Tesco Extra and other larger stores are typically easier to navigate with mobility equipment than smaller convenience stores.',
		'note'  => 'If you need pharmacy access, it is usually simplest to combine with a town-centre trip.',
		'icon'  => 'shopping-cart',
	),
);

$access_label   = (string) get_post_meta( $pid, 'wg_access_label', true ) ?: 'Accessibility notes';
$access_heading = (string) get_post_meta( $pid, 'wg_access_heading', true ) ?: 'Local routes with practical access context';
$access_intro   = (string) get_post_meta( $pid, 'wg_access_intro', true ) ?: 'We focus on surfaces, slopes, and typical crowding so you can plan with confidence: not generic "accessible" labels.';

$spotlight_label   = (string) get_post_meta( $pid, 'wg_spotlight_label', true ) ?: 'Visual guide';
$spotlight_heading = (string) get_post_meta( $pid, 'wg_spotlight_heading', true ) ?: 'Key local areas at a glance';
$spotlight_intro   = (string) get_post_meta( $pid, 'wg_spotlight_intro', true ) ?: 'Photos help you picture routes and surfaces before you arrive.';

$related_label   = (string) get_post_meta( $pid, 'wg_related_label', true ) ?: 'Related reading';
$related_heading = (string) get_post_meta( $pid, 'wg_related_heading', true ) ?: 'Plan your stay with connected guides';
$related_intro   = (string) get_post_meta( $pid, 'wg_related_intro', true ) ?: 'If you are comparing locations and practical suitability, these pages answer the next common questions.';

$planning_label          = (string) get_post_meta( $pid, 'wg_planning_label', true ) ?: 'Planning notes';
$planning_heading        = (string) get_post_meta( $pid, 'wg_planning_heading', true ) ?: 'Useful details before you head out';
$planning_intro          = (string) get_post_meta( $pid, 'wg_planning_intro', true ) ?: 'A little planning helps avoid friction on the day, especially for accessibility and transport.';
$planning_before_heading = (string) get_post_meta( $pid, 'wg_planning_before_heading', true ) ?: 'Before you travel';
$planning_day_heading    = (string) get_post_meta( $pid, 'wg_planning_day_heading', true ) ?: 'On the day';
$planning_before_bullets = (string) get_post_meta( $pid, 'wg_planning_before_bullets', true ) ?: "Check opening times and access details for specific venues: not all cafes and pubs in Whitstable have step-free access.\nBook accessible taxis in advance, especially for weekends and bank holidays.\nIf you have questions about routes, parking, or whether a specific place is accessible, ask us before you travel; we will find out if we do not already know.";
$planning_day_bullets    = (string) get_post_meta( $pid, 'wg_planning_day_bullets', true ) ?: "Stick to promenade routes for level, predictable surfaces: the Tankerton promenade and Whitstable seafront are the most reliable.\nAllow extra time for parking near the harbour, especially on weekends and sunny days. Gorrell Tank car park usually has more availability than the harbour itself.\nKeep plans flexible around weather and tide conditions. The seafront is exposed and can be windy; bring layers.";

$eating_label   = (string) get_post_meta( $pid, 'wg_eating_label', true ) ?: 'Eating out';
$eating_heading = (string) get_post_meta( $pid, 'wg_eating_heading', true ) ?: 'Places to eat near the property';
$eating_intro   = (string) get_post_meta( $pid, 'wg_eating_intro', true ) ?: '';
$eating_body    = (string) get_post_meta( $pid, 'wg_eating_body', true ) ?: "<strong>The Plough, Whitstable</strong>: a short walk from the property. Relaxed pub with a good food menu. Speak to us about accessibility on arrival as we have a direct contact there.\n<strong>Whitstable harbour</strong> has several fish and chip shops and seafood restaurants. Most are accessible at ground level, though space inside can be tight at peak times. Eating outside on the harbour wall is a good option in warmer weather.\n<strong>Tankerton Parade</strong> (along Marine Parade near the slopes) has a small cluster of independent cafes and a bakery. Generally quieter than the town centre.\nWe are happy to recommend other places based on your specific access needs; just ask before or during your stay.";

$spotlight_images = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$image_id = (int) get_post_meta( $pid, "wg_spotlight_image_{$i}_id", true );
	if ( ! $image_id ) {
		continue;
	}
	$image_src = wp_get_attachment_image_url( $image_id, 'large' );
	if ( ! $image_src ) {
		continue;
	}
	$image_alt = trim( wp_strip_all_tags( (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) );
	$caption   = (string) get_post_meta( $pid, "wg_spotlight_image_{$i}_caption", true );
	$spotlight_images[] = array(
		'src'     => $image_src,
		'alt'     => $image_alt,
		'caption' => $caption,
	);
}

$card_hover = 'rw-surface-card rw-card-hover-lift motion-reduce:transition-none motion-reduce:hover:translate-y-0';
$body_class = 'rw-copy-body font-sans text-base leading-relaxed';
$link_class = 'text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:bg-[var(--deep-teal)]/5 rounded-sm cursor-pointer transition-colors duration-200 focus:outline-none focus-visible:ring-[3px] focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-[3px]';

$wg_glance = array(
	array(
		'stat'  => __( '~90 min', 'restwell-retreats' ),
		'label' => __( 'Typical drive from London (M2 / A299)', 'restwell-retreats' ),
		'icon'  => 'car',
	),
	array(
		'stat'  => __( '75–90 min', 'restwell-retreats' ),
		'label' => __( 'Direct trains from Victoria or St Pancras', 'restwell-retreats' ),
		'icon'  => 'train',
	),
	array(
		'stat'  => __( '20–30 min', 'restwell-retreats' ),
		'label' => __( 'Approx. walk from the property to Whitstable station (paved routes; exact time varies). Check station access with National Rail before you travel.', 'restwell-retreats' ),
		'icon'  => 'map-pin',
	),
);

?>
<main class="flex-1 page-whitstable-guide" id="main-content">
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<?php
	set_query_var(
		'args',
		array(
			'heading_id'      => $hero_heading_id,
			'label'           => $label,
			'heading'         => $heading,
			'intro'           => $intro,
			'media_id'        => $hero_image_id,
			'image_alt' => $heading,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<section class="wg-glance py-0 border-b border-[var(--deep-teal)]/10 bg-[var(--bg-subtle)]" aria-label="<?php esc_attr_e( 'Whitstable and travel at a glance', 'restwell-retreats' ); ?>">
		<div class="container max-w-5xl mx-auto py-10 md:py-12">
			<div class="grid w-full grid-cols-1 gap-0 divide-y divide-[var(--deep-teal)]/10 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
				<?php foreach ( $wg_glance as $glance ) : ?>
					<?php $g_icon = isset( $glance['icon'] ) ? $glance['icon'] : 'dot'; ?>
					<div class="wg-glance-item flex flex-col sm:flex-row sm:items-start gap-4 py-8 text-center sm:px-6 sm:py-6 sm:first:pl-0 sm:last:pr-0 sm:text-left">
						<span class="wg-glance-item__icon flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[color-mix(in_srgb,var(--sea-glass)_30%,transparent)] text-[var(--deep-teal)] mx-auto sm:mx-0" aria-hidden="true">
							<i class="ph-bold ph-<?php echo esc_attr( $g_icon ); ?> text-lg text-[var(--deep-teal)]"></i>
						</span>
						<dl class="min-w-0 flex-1 m-0">
							<dt class="font-serif text-2xl md:text-[1.65rem] text-[var(--deep-teal)] tracking-tight leading-tight"><?php echo esc_html( $glance['stat'] ); ?></dt>
							<dd class="mt-2 text-sm font-sans leading-snug text-[var(--muted-grey)] m-0"><?php echo esc_html( $glance['label'] ); ?></dd>
						</dl>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php foreach ( $sections as $section ) : ?>
		<section class="wg-content-section rw-section-y <?php echo esc_attr( $section['bg'] ); ?>">
			<div class="container max-w-5xl mx-auto">
				<div class="wg-section-rail w-full">
					<div class="wg-section-head mb-6 md:mb-8">
						<p class="section-label mb-2"><?php echo esc_html( $section['eyebrow'] ); ?></p>
						<h2 class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight"><?php echo esc_html( $section['heading'] ); ?></h2>
					</div>
					<div class="wg-content-body <?php echo esc_attr( $body_class ); ?> space-y-5">
						<?php foreach ( preg_split( "/\\r\\n|\\r|\\n/", (string) $section['body'] ) as $line ) : ?>
							<?php if ( trim( $line ) !== '' ) : ?>
								<p class="m-0"><?php echo esc_html( $line ); ?></p>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<?php if ( 'about' === $section['key'] ) : ?>
						<p class="<?php echo esc_attr( $body_class ); ?> mt-8 pt-6 border-t border-[var(--deep-teal)]/10 m-0"><?php esc_html_e( 'Read more:', 'restwell-retreats' ); ?>
							<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) ); ?>"><?php esc_html_e( 'A guide to accessible beaches and coastal walks in Kent', 'restwell-retreats' ); ?></a>
						</p>
						<p class="<?php echo esc_attr( $body_class ); ?> mt-6 m-0 max-w-[65ch]">
							<?php esc_html_e( 'Staying at Restwell puts Whitstable on your doorstep. For kit, access, and layout,', 'restwell-retreats' ); ?>
							<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/the-property/' ) ); ?>"><?php esc_html_e( 'see the adapted bungalow', 'restwell-retreats' ); ?></a><?php esc_html_e( '. The', 'restwell-retreats' ); ?>
							<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'homepage', 'restwell-retreats' ); ?></a>
							<?php esc_html_e( 'summarises how we work; when you are ready,', 'restwell-retreats' ); ?>
							<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>"><?php esc_html_e( 'get in touch about your stay', 'restwell-retreats' ); ?></a>.
						</p>
					<?php endif; ?>
				<?php if ( 'getting_here' === $section['key'] ) : ?>
					<p class="<?php echo esc_attr( $body_class ); ?> mt-8 pt-6 border-t border-[var(--deep-teal)]/10 m-0"><?php esc_html_e( 'For train times and platform access, check', 'restwell-retreats' ); ?>
						<a class="<?php echo esc_attr( $link_class ); ?>" href="https://www.nationalrail.co.uk/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'National Rail Enquiries', 'restwell-retreats' ); ?><span class="sr-only"><?php esc_html_e( ' (opens in new tab)', 'restwell-retreats' ); ?></span></a>
						<?php esc_html_e( 'before you travel. For how a stay is confirmed and what to expect on arrival,', 'restwell-retreats' ); ?>
						<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/how-it-works/' ) ); ?>"><?php esc_html_e( 'see how it works', 'restwell-retreats' ); ?></a>.
					</p>
				<?php endif; ?>
				<?php if ( 'getting_around' === $section['key'] ) : ?>
					<p class="<?php echo esc_attr( $body_class ); ?> mt-8 pt-6 border-t border-[var(--deep-teal)]/10 m-0"><?php esc_html_e( 'For current Stagecoach 400 timetables and wheelchair space availability, check the', 'restwell-retreats' ); ?>
						<a class="<?php echo esc_attr( $link_class ); ?>" href="https://www.stagecoachbus.com/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Stagecoach website', 'restwell-retreats' ); ?><span class="sr-only"><?php esc_html_e( ' (opens in new tab)', 'restwell-retreats' ); ?></span></a>
						<?php esc_html_e( 'before you travel.', 'restwell-retreats' ); ?>
					</p>
					<p class="<?php echo esc_attr( $body_class ); ?> mt-4 m-0"><?php esc_html_e( 'If you want to understand whether our property suits your access needs specifically, start with', 'restwell-retreats' ); ?>
						<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/who-its-for/' ) ); ?>"><?php esc_html_e( 'who Restwell is for', 'restwell-retreats' ); ?></a>
						<?php esc_html_e( 'and', 'restwell-retreats' ); ?>
						<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/accessibility/' ) ); ?>"><?php esc_html_e( 'our accessibility specification', 'restwell-retreats' ); ?></a>.
					</p>
				<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endforeach; ?>

	<section class="wg-content-section rw-section-y bg-[var(--bg-subtle)] wg-band--texture" aria-labelledby="wg-access-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head mb-10 md:mb-12">
					<p class="section-label mb-2"><?php echo esc_html( $access_label ); ?></p>
					<h2 id="wg-access-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight mb-5 md:mb-6"><?php echo esc_html( $access_heading ); ?></h2>
					<p class="<?php echo esc_attr( $body_class ); ?> max-w-[65ch]"><?php echo esc_html( $access_intro ); ?></p>
				</div>
				<div class="grid grid-cols-1 gap-7 md:gap-8 sm:grid-cols-2 sm:items-stretch">
				<?php
				$wg_card_i = 0;
				foreach ( $access_cards as $card ) :
					++$wg_card_i;
					$icon = isset( $card['icon'] ) ? $card['icon'] : 'dot';
					?>
					<div class="wg-access-card min-w-0 bg-white rounded-2xl p-8 md:p-9 h-full flex flex-col <?php echo esc_attr( $card_hover ); ?>">
						<div class="flex gap-4">
							<span class="wg-access-card__icon flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[color-mix(in_srgb,var(--sea-glass)_35%,transparent)] text-[var(--deep-teal)] shadow-[inset_0_1px_0_rgba(255,255,255,0.65)]" aria-hidden="true">
								<i class="ph-bold ph-<?php echo esc_attr( $icon ); ?> text-lg text-[var(--deep-teal)]"></i>
							</span>
							<div class="min-w-0 flex-1">
								<p class="text-xs font-semibold uppercase tracking-[0.18em] text-[var(--warm-gold-text)] font-sans mb-2"><?php echo esc_html( sprintf( '%02d', $wg_card_i ) ); ?></p>
								<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $card['title'] ); ?></h3>
								<p class="<?php echo esc_attr( $body_class ); ?> mb-4"><?php echo esc_html( $card['body'] ); ?></p>
							</div>
						</div>
						<p class="text-sm text-[var(--muted-grey)] leading-relaxed border-t border-[var(--deep-teal)]/10 pt-4 mt-auto pl-0 sm:pl-16"><?php echo esc_html( $card['note'] ); ?></p>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $spotlight_images ) ) : ?>
	<section class="wg-content-section rw-section-y bg-[var(--soft-sand)]" aria-labelledby="wg-visual-guide-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head mb-10 md:mb-12">
					<p class="section-label mb-2"><?php echo esc_html( $spotlight_label ); ?></p>
					<h2 id="wg-visual-guide-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight mb-5 md:mb-6"><?php echo esc_html( $spotlight_heading ); ?></h2>
					<p class="<?php echo esc_attr( $body_class ); ?> max-w-[65ch]"><?php echo esc_html( $spotlight_intro ); ?></p>
				</div>
				<div class="grid grid-cols-1 gap-6 md:grid-cols-3">
				<?php foreach ( $spotlight_images as $image ) : ?>
					<?php
					$img_alt = $image['alt'];
					if ( $img_alt === '' ) {
						$img_alt = $image['caption'] !== '' ? $image['caption'] : __( 'Local area photo', 'restwell-retreats' );
					}
					?>
					<figure class="bg-white rounded-2xl overflow-hidden <?php echo esc_attr( $card_hover ); ?>">
						<img src="<?php echo esc_url( $image['src'] ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" class="w-full aspect-[4/3] object-cover" loading="lazy" decoding="async" />
						<?php if ( $image['caption'] !== '' ) : ?>
							<figcaption class="px-5 py-4 text-sm text-[var(--body-secondary)] leading-relaxed"><?php echo esc_html( $image['caption'] ); ?></figcaption>
						<?php endif; ?>
					</figure>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="wg-content-section rw-section-y bg-white" aria-labelledby="wg-related-reading-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head mb-8 md:mb-10">
					<p class="section-label mb-2"><?php echo esc_html( $related_label ); ?></p>
					<h2 id="wg-related-reading-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight mb-5 md:mb-6"><?php echo esc_html( $related_heading ); ?></h2>
					<p class="<?php echo esc_attr( $body_class ); ?> max-w-[65ch]"><?php echo esc_html( $related_intro ); ?></p>
				</div>
				<div class="flex flex-col flex-wrap items-stretch gap-4 sm:flex-row sm:items-center md:gap-5">
				<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) ); ?>"><?php esc_html_e( 'Accessible beaches on the Kent coast', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/who-its-for/' ) ); ?>"><?php esc_html_e( 'Who Restwell is for', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/direct-payment-holiday-accommodation/' ) ); ?>"><?php esc_html_e( 'Using direct payments for holidays', 'restwell-retreats' ); ?></a>
			<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/carers-respite-holiday-guide/' ) ); ?>"><?php esc_html_e( "Carers' respite: rights and funding", 'restwell-retreats' ); ?></a>
			<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'Booking and planning FAQs', 'restwell-retreats' ); ?></a>
			</div>
			</div>
		</div>
	</section>

	<section class="wg-content-section rw-section-y bg-[var(--bg-subtle)] wg-band--texture" aria-labelledby="wg-planning-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head mb-8 md:mb-10">
					<p class="section-label mb-2"><?php echo esc_html( $planning_label ); ?></p>
					<h2 id="wg-planning-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight mb-5 md:mb-6"><?php echo esc_html( $planning_heading ); ?></h2>
					<p class="<?php echo esc_attr( $body_class ); ?> max-w-[65ch]"><?php echo esc_html( $planning_intro ); ?></p>
				</div>
				<div class="grid grid-cols-1 gap-7 md:gap-8 sm:grid-cols-2 sm:items-stretch">
					<div class="wg-planning-card min-w-0 bg-white rounded-2xl p-8 md:p-9 h-full flex flex-col <?php echo esc_attr( $card_hover ); ?>">
						<h3 class="flex items-start gap-4 text-xl font-serif text-[var(--deep-teal)] mb-4">
							<span class="wg-planning-card__icon flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[color-mix(in_srgb,var(--sea-glass)_35%,transparent)] text-[var(--deep-teal)] shadow-[inset_0_1px_0_rgba(255,255,255,0.65)]" aria-hidden="true">
								<i class="ph-bold ph-clipboard-text text-lg text-[var(--deep-teal)]"></i>
							</span>
							<span class="min-w-0 pt-1"><?php echo esc_html( $planning_before_heading ); ?></span>
						</h3>
						<ul class="wg-planning-card__list space-y-3 font-sans text-[var(--body-secondary)] text-base leading-relaxed list-disc pl-5 marker:text-[var(--deep-teal)] flex-1">
							<?php foreach ( preg_split( "/\\r\\n|\\r|\\n/", $planning_before_bullets ) as $bullet ) : ?>
								<?php if ( trim( $bullet ) !== '' ) : ?>
									<li><?php echo esc_html( $bullet ); ?></li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="wg-planning-card min-w-0 bg-white rounded-2xl p-8 md:p-9 h-full flex flex-col <?php echo esc_attr( $card_hover ); ?>">
						<h3 class="flex items-start gap-4 text-xl font-serif text-[var(--deep-teal)] mb-4">
							<span class="wg-planning-card__icon flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[color-mix(in_srgb,var(--sea-glass)_35%,transparent)] text-[var(--deep-teal)] shadow-[inset_0_1px_0_rgba(255,255,255,0.65)]" aria-hidden="true">
								<i class="ph-bold ph-sun text-lg text-[var(--deep-teal)]"></i>
							</span>
							<span class="min-w-0 pt-1"><?php echo esc_html( $planning_day_heading ); ?></span>
						</h3>
						<ul class="wg-planning-card__list space-y-3 font-sans text-[var(--body-secondary)] text-base leading-relaxed list-disc pl-5 marker:text-[var(--deep-teal)] flex-1">
							<?php foreach ( preg_split( "/\\r\\n|\\r|\\n/", $planning_day_bullets ) as $bullet ) : ?>
								<?php if ( trim( $bullet ) !== '' ) : ?>
									<li><?php echo esc_html( $bullet ); ?></li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="wg-content-section rw-section-y bg-white" aria-labelledby="wg-eating-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head <?php echo $eating_intro !== '' ? 'mb-8 md:mb-10' : 'mb-6 md:mb-8'; ?>">
					<p class="section-label mb-2"><?php echo esc_html( $eating_label ); ?></p>
					<h2 id="wg-eating-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight <?php echo $eating_intro !== '' ? 'mb-5 md:mb-6' : 'mb-0'; ?>"><?php echo esc_html( $eating_heading ); ?></h2>
					<?php if ( $eating_intro !== '' ) : ?>
						<p class="<?php echo esc_attr( $body_class ); ?> mb-0 max-w-[65ch]"><?php echo esc_html( $eating_intro ); ?></p>
					<?php endif; ?>
				</div>
			<div class="wg-content-body wg-eating-body space-y-5 <?php echo esc_attr( $body_class ); ?> border-t border-[var(--deep-teal)]/10 pt-8 md:pt-10">
				<?php foreach ( preg_split( "/\\r\\n|\\r|\\n/", $eating_body ) as $para ) : ?>
					<?php if ( trim( $para ) !== '' ) : ?>
						<p class="m-0"><?php echo wp_kses_post( $para ); ?></p>
					<?php endif; ?>
				<?php endforeach; ?>
				<p class="m-0 pt-6 border-t border-[var(--deep-teal)]/10 <?php echo esc_attr( $body_class ); ?>"><?php esc_html_e( 'For full details on the property and equipment,', 'restwell-retreats' ); ?>
					<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/the-property/' ) ); ?>"><?php esc_html_e( 'see the adapted bungalow', 'restwell-retreats' ); ?></a>.
					<?php esc_html_e( 'When you are ready,', 'restwell-retreats' ); ?>
					<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>"><?php esc_html_e( 'get in touch about your stay', 'restwell-retreats' ); ?></a>.
				</p>
			</div>
			</div>
		</div>
	</section>

</main>
<?php get_footer(); ?>
