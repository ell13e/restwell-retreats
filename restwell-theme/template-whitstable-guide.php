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

$hero_image_id  = (int) get_post_meta( $pid, 'wg_hero_image_id', true );
$hero_image_src = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'full' ) : '';
$label          = (string) get_post_meta( $pid, 'wg_label', true ) ?: 'Whitstable & Kent coast';
$heading        = (string) get_post_meta( $pid, 'wg_heading', true ) ?: 'A practical local guide for your stay.';
$intro          = (string) get_post_meta( $pid, 'wg_intro', true ) ?: 'From seafront walks to nearby towns, here is where guests usually go — and what to think about if accessibility matters to your plans.';

$sections = array(
	array(
		'eyebrow' => 'Local context',
		'heading' => (string) get_post_meta( $pid, 'wg_about_heading', true ) ?: 'About Whitstable',
		'body'    => (string) get_post_meta( $pid, 'wg_about_body', true ) ?: "Whitstable is a small coastal town known for its harbour, independent high street, and oysters. The town centre is compact and mostly flat, with a mix of cafes, pubs, galleries, and independent shops along Harbour Street and the high street.\nFor wheelchair users: most of the town centre is paved, but some older streets have uneven surfaces and narrow pavements. The harbour area is generally accessible, though parts near the fish market can be uneven or crowded at weekends. There is accessible public parking at Gorrell Tank car park (Canterbury City Council, pay and display) close to the high street.\nTankerton, just east of the town centre, has a wide, surfaced promenade that runs along the seafront — flat, smooth, and suitable for wheelchairs and powerchairs. Free parking is available along Marine Parade at the top. The grassy slopes between the road and the promenade are steep, so use the paved paths to reach the seafront. At low tide, a natural shingle spit called \"The Street\" appears and extends about 750 metres out to sea — interesting to see, but not accessible for wheelchair users as it is loose shingle.",
		'bg'      => 'bg-white',
	),
	array(
		'eyebrow' => 'Nearby',
		'heading' => (string) get_post_meta( $pid, 'wg_towns_heading', true ) ?: 'Nearby towns worth visiting',
		'body'    => (string) get_post_meta( $pid, 'wg_towns_body', true ) ?: "Canterbury (about 8 miles) — the cathedral city. Good for a day out with shops, restaurants, and the cathedral itself. The city centre is mostly pedestrianised and largely flat, though some older streets are cobbled. There are several accessible car parks including the Whitefriars shopping centre. The cathedral has wheelchair access to most areas.\nFaversham (about 7 miles) — a quieter market town with independent shops and pubs. The town centre is compact and mostly flat. Market days are Tuesday, Friday, and Saturday. A good option if you want a change of scene without a long drive.\nHerne Bay (about 4 miles) — traditional seafront with a long, flat promenade that is fully paved and accessible. There is also a pier (partially rebuilt), amusement arcades, and fish and chips. An easy option for a couple of hours by the sea.",
		'bg'      => 'bg-[var(--bg-subtle)]',
	),
	array(
		'eyebrow' => 'Travel',
		'heading' => (string) get_post_meta( $pid, 'wg_getting_here_heading', true ) ?: 'Getting here',
		'body'    => (string) get_post_meta( $pid, 'wg_getting_here_body', true ) ?: "By car: Whitstable is reached via the M2 and A299 from London (about 60 miles, usually around 90 minutes depending on traffic). The property has off-street parking with enough space for adapted vehicles, including those with rear or side ramps.\nBy train: Whitstable station has direct services to London Victoria and London St Pancras (via Canterbury West or Faversham). Journey time is roughly 75–90 minutes. The station has step-free access to both platforms. From the station to the property is about a 10-minute drive — we can advise on accessible taxi options if needed.",
		'bg'      => 'bg-[var(--soft-sand)]',
	),
	array(
		'eyebrow' => 'During your stay',
		'heading' => (string) get_post_meta( $pid, 'wg_getting_around_heading', true ) ?: 'Getting around during your stay',
		'body'    => (string) get_post_meta( $pid, 'wg_getting_around_body', true ) ?: "Most guests find a car is the easiest way to get around, especially if you need to transport equipment. The property parking is level and spacious.\nThe Stagecoach 400 bus runs between Whitstable and Canterbury and stops nearby. This route uses low-floor buses, but availability of the ramp and wheelchair space can vary — it is worth checking with Stagecoach before relying on it for a specific journey.\nIf you use a mobility scooter or powerchair, the Tankerton promenade and Whitstable seafront are both suitable surfaces. The town centre is mixed — some pavements are narrow or uneven in older parts.\nWheelchair hire is available locally. Ask us before your stay and we can share contact details for trusted suppliers in the area.",
		'bg'      => 'bg-white',
	),
);

$access_cards = array(
	array(
		'title' => 'Tankerton promenade',
		'body'  => 'The promenade route is wide, level, and surfaced, which makes it the most practical seafront option for many wheelchair users.',
		'note'  => 'The slopes down are steeper; many guests stay on the top route for easier access.',
	),
	array(
		'title' => 'Whitstable harbour area',
		'body'  => 'Harbour-side routes are lively and mostly level, with some uneven sections and busier pedestrian flow at peak times.',
		'note'  => 'Weekday mornings are usually easier for quieter movement.',
	),
	array(
		'title' => 'Town centre and Harbour Street',
		'body'  => 'Shops and cafes are close together, but some pavements are narrower around older parts of town.',
		'note'  => 'Plan extra time if you need wider turning space or quieter access.',
	),
	array(
		'title' => 'Practical services',
		'body'  => 'Tesco Extra and other larger stores are typically easier to navigate with mobility equipment than smaller convenience stores.',
		'note'  => 'If you need pharmacy access, it is usually simplest to combine with a town-centre trip.',
	),
);

$cta_heading         = (string) get_post_meta( $pid, 'wg_cta_heading', true ) ?: 'Planning your coastal break?';
$cta_body            = (string) get_post_meta( $pid, 'wg_cta_body', true ) ?: 'If you have dates in mind, enquire and we will help you plan a stay that works.';
$cta_primary_label   = (string) get_post_meta( $pid, 'wg_cta_primary_label', true ) ?: 'See the property';
$cta_primary_url     = (string) get_post_meta( $pid, 'wg_cta_primary_url', true ) ?: '/the-property/';
$cta_secondary_label = (string) get_post_meta( $pid, 'wg_cta_secondary_label', true ) ?: 'Enquire about dates';
$cta_secondary_url   = (string) get_post_meta( $pid, 'wg_cta_secondary_url', true ) ?: '/enquire/';

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
?>
<main class="flex-1" id="main-content">
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<section class="relative min-h-[32rem] md:min-h-[42rem] flex items-end overflow-hidden <?php echo $hero_image_src ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="wg-hero-heading">
		<?php if ( $hero_image_src ) : ?>
			<div class="absolute inset-0 bg-cover bg-center" style="background-image:url('<?php echo esc_url( $hero_image_src ); ?>');" aria-hidden="true"></div>
		<?php endif; ?>
		<div class="absolute inset-0 bg-[var(--deep-teal)]/75" aria-hidden="true"></div>
		<div class="relative container pb-14 md:pb-20">
			<div class="max-w-3xl">
				<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-4"><?php echo esc_html( $label ); ?></p>
				<h1 id="wg-hero-heading" class="text-white text-4xl md:text-5xl font-serif leading-tight mb-5"><?php echo esc_html( $heading ); ?></h1>
				<p class="text-[#F5EDE0] text-lg leading-relaxed max-w-prose"><?php echo esc_html( $intro ); ?></p>
			</div>
		</div>
	</section>

	<?php foreach ( $sections as $section ) : ?>
		<section class="py-16 md:py-24 <?php echo esc_attr( $section['bg'] ); ?>">
			<div class="container max-w-4xl">
				<p class="section-label mb-3"><?php echo esc_html( $section['eyebrow'] ); ?></p>
				<h2 class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $section['heading'] ); ?></h2>
				<div class="text-gray-600 text-base leading-relaxed space-y-4 max-w-prose">
					<?php foreach ( preg_split( "/\\r\\n|\\r|\\n/", (string) $section['body'] ) as $line ) : ?>
						<?php if ( trim( $line ) !== '' ) : ?>
							<p><?php echo esc_html( $line ); ?></p>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<?php if ( 'Local context' === $section['eyebrow'] ) : ?>
					<p class="text-gray-600 text-base leading-relaxed mt-6">Read more: <a class="text-[var(--deep-teal)] underline hover:no-underline" href="<?php echo esc_url( home_url( '/blog/accessible-beaches-coastal-walks-kent' ) ); ?>">A guide to accessible beaches and coastal walks in Kent</a></p>
				<?php endif; ?>
				<?php if ( 'During your stay' === $section['eyebrow'] ) : ?>
					<p class="text-gray-600 text-base leading-relaxed mt-6">If you want to understand whether our property suits your access needs specifically, start with <a class="text-[var(--deep-teal)] underline hover:no-underline" href="<?php echo esc_url( home_url( '/who-its-for' ) ); ?>">who Restwell is for</a> and <a class="text-[var(--deep-teal)] underline hover:no-underline" href="<?php echo esc_url( home_url( '/accessibility' ) ); ?>">our accessibility specification</a>.</p>
				<?php endif; ?>
			</div>
		</section>
	<?php endforeach; ?>

	<section class="py-16 md:py-24 bg-white" aria-labelledby="wg-access-heading">
		<div class="container max-w-5xl">
			<p class="section-label mb-3">Accessibility notes</p>
			<h2 id="wg-access-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4">Local places with practical access context.</h2>
			<p class="text-gray-600 text-base leading-relaxed mb-10 max-w-prose">This guide focuses on route conditions and planning details, not generic “accessible” labels.</p>
			<div class="grid sm:grid-cols-2 gap-6">
				<?php foreach ( $access_cards as $card ) : ?>
					<div class="bg-[var(--bg-subtle)] rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
						<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3"><?php echo esc_html( $card['title'] ); ?></h3>
						<p class="text-gray-600 text-sm leading-relaxed mb-3"><?php echo esc_html( $card['body'] ); ?></p>
						<p class="text-xs text-[var(--muted-grey)] leading-relaxed"><?php echo esc_html( $card['note'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $spotlight_images ) ) : ?>
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-labelledby="wg-visual-guide-heading">
		<div class="container max-w-6xl">
			<p class="section-label mb-3">Visual guide</p>
			<h2 id="wg-visual-guide-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4">Key local areas at a glance.</h2>
			<p class="text-gray-600 text-base leading-relaxed mb-10 max-w-prose">Use these image slots for practical route context. Add or replace photos in page meta when you have updated local shots.</p>
			<div class="grid md:grid-cols-3 gap-6">
				<?php foreach ( $spotlight_images as $image ) : ?>
					<figure class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
						<img src="<?php echo esc_url( $image['src'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="w-full aspect-[4/3] object-cover" loading="lazy" />
						<?php if ( $image['caption'] !== '' ) : ?>
							<figcaption class="px-4 py-3 text-sm text-gray-600 leading-relaxed"><?php echo esc_html( $image['caption'] ); ?></figcaption>
						<?php endif; ?>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="py-16 md:py-20 bg-white" aria-labelledby="wg-related-reading-heading">
		<div class="container max-w-5xl">
			<p class="section-label mb-3">Related reading</p>
			<h2 id="wg-related-reading-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4">Plan your stay with connected guides.</h2>
			<p class="text-gray-600 leading-relaxed max-w-prose mb-8">If you are comparing locations and practical suitability, these pages answer the next common questions.</p>
			<div class="flex flex-wrap gap-3">
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/accessible-beaches-kent-coast/' ) ); ?>"><?php esc_html_e( 'Accessible beaches on the Kent coast', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/who-its-for/' ) ); ?>"><?php esc_html_e( 'Who Restwell is for', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/direct-payment-holiday-accommodation/' ) ); ?>"><?php esc_html_e( 'Using direct payments for holidays', 'restwell-retreats' ); ?></a>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-[var(--soft-sand)]" aria-labelledby="wg-planning-heading">
		<div class="container max-w-5xl">
			<p class="section-label mb-3">Planning notes</p>
			<h2 id="wg-planning-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4">Useful details before you head out.</h2>
			<p class="text-gray-600 text-base leading-relaxed mb-10 max-w-prose">A little planning helps avoid friction on the day, especially for accessibility and transport.</p>
			<div class="grid sm:grid-cols-2 gap-6">
				<div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3">Before you travel</h3>
					<ul class="space-y-2 text-gray-600 text-sm leading-relaxed">
						<li>Check opening times and access details for specific venues — not all cafes and pubs in Whitstable have step-free access.</li>
						<li>Book accessible taxis in advance, especially for weekends and bank holidays.</li>
						<li>If you have questions about routes, parking, or whether a specific place is accessible, ask us before you travel — we will find out if we do not already know.</li>
					</ul>
				</div>
				<div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3">On the day</h3>
					<ul class="space-y-2 text-gray-600 text-sm leading-relaxed">
						<li>Stick to promenade routes for level, predictable surfaces — the Tankerton promenade and Whitstable seafront are the most reliable.</li>
						<li>Allow extra time for parking near the harbour, especially on weekends and sunny days. Gorrell Tank car park usually has more availability than the harbour itself.</li>
						<li>Keep plans flexible around weather and tide conditions. The seafront is exposed and can be windy — bring layers.</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-white" aria-labelledby="wg-eating-heading">
		<div class="container max-w-5xl">
			<p class="section-label mb-3">Eating out</p>
			<h2 id="wg-eating-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4">Places to eat near the property</h2>
			<div class="space-y-4 text-gray-600 text-base leading-relaxed max-w-3xl">
				<p><strong>The Plough, Whitstable</strong> — a short walk from the property. Relaxed pub with a good food menu. Speak to us about accessibility on arrival as we have a direct contact there.</p>
				<p><strong>Whitstable harbour</strong> has several fish and chip shops and seafood restaurants. Most are accessible at ground level, though space inside can be tight at peak times. Eating outside on the harbour wall is a good option in warmer weather.</p>
				<p><strong>Tankerton Parade</strong> (along Marine Parade near the slopes) has a small cluster of independent cafes and a bakery. Generally quieter than the town centre.</p>
				<p>We are happy to recommend other places based on your specific access needs — just ask before or during your stay.</p>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-labelledby="wg-cta-heading">
		<div class="container max-w-3xl text-center">
			<p class="section-label mb-3">Next step</p>
			<h2 id="wg-cta-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $cta_heading ); ?></h2>
			<p class="text-gray-600 leading-relaxed max-w-prose mx-auto mb-8"><?php echo esc_html( $cta_body ); ?></p>
			<div class="flex flex-wrap justify-center gap-4">
				<a class="btn btn-primary" href="<?php echo esc_url( home_url( $cta_primary_url ) ); ?>">
					<?php echo esc_html( $cta_primary_label ); ?>
					<i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
				</a>
				<a class="btn btn-outline" href="<?php echo esc_url( home_url( $cta_secondary_url ) ); ?>">
					<?php echo esc_html( $cta_secondary_label ); ?>
					<i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
				</a>
				<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
					<?php esc_html_e( 'Read local articles', 'restwell-retreats' ); ?>
					<i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</section>
</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
