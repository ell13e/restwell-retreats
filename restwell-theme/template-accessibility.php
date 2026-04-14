<?php
/**
 * Template Name: Accessibility
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

// Hero
$acc_hero_image_id = (int) get_post_meta( $pid, 'acc_hero_image_id', true );
$acc_label          = get_post_meta( $pid, 'acc_label', true ) ?: 'Accessibility';
$acc_heading        = get_post_meta( $pid, 'acc_heading', true ) ?: 'Honest detail, so you can decide';
$acc_intro          = get_post_meta( $pid, 'acc_intro', true ) ?: 'If you are comparing wheelchair accessible holiday cottages in Kent, this page lists the practical detail you need: equipment, dimensions, and what we have verified. For anything specific, we are happy to talk it through.';

// Room by room: only confirmed content in defaults; unknowns handled by inquiry card.
$acc_room_label       = get_post_meta( $pid, 'acc_room_label', true ) ?: 'The property';
$acc_room_heading     = get_post_meta( $pid, 'acc_room_heading', true ) ?: 'Room by room';
$acc_room_intro       = get_post_meta( $pid, 'acc_room_intro', true ) ?: 'Here is what we have verified about each part of the property. Anything not listed has not been confirmed; ask us and we will find out.';
$acc_arrival_heading  = get_post_meta( $pid, 'acc_arrival_heading', true ) ?: 'Arrival & entrance';
$acc_arrival_body     = get_post_meta( $pid, 'acc_arrival_body', true ) ?: "Level threshold with a wide front door\nQuiet, flat residential street with no steep approach";
$acc_inside_heading   = get_post_meta( $pid, 'acc_inside_heading', true ) ?: 'Inside the property';
$acc_inside_body      = get_post_meta( $pid, 'acc_inside_body', true ) ?: "Level access throughout the ground floor\nWide doorways suitable for standard and power wheelchairs";
$acc_bedroom_heading  = get_post_meta( $pid, 'acc_bedroom_heading', true ) ?: 'Bedrooms';
$acc_bedroom_body     = get_post_meta( $pid, 'acc_bedroom_body', true ) ?: '';
$acc_bathroom_heading = get_post_meta( $pid, 'acc_bathroom_heading', true ) ?: 'Bathroom';
$acc_bathroom_body    = get_post_meta( $pid, 'acc_bathroom_body', true ) ?: '';
$acc_kitchen_heading  = get_post_meta( $pid, 'acc_kitchen_heading', true ) ?: 'Kitchen';
$acc_kitchen_body     = get_post_meta( $pid, 'acc_kitchen_body', true ) ?: '';
$acc_outdoor_heading  = get_post_meta( $pid, 'acc_outdoor_heading', true ) ?: 'Outdoor spaces';
$acc_outdoor_body     = get_post_meta( $pid, 'acc_outdoor_body', true ) ?: '';

// Destination
$acc_dest_label             = get_post_meta( $pid, 'acc_dest_label', true ) ?: 'The destination';
$acc_dest_heading           = get_post_meta( $pid, 'acc_dest_heading', true ) ?: 'Whitstable: what to expect';
$acc_dest_intro             = get_post_meta( $pid, 'acc_dest_intro', true ) ?: 'An honest picture of the area: what is accessible, where there are challenges, and what matters most for your visit.';
$acc_dest_good_heading      = get_post_meta( $pid, 'acc_dest_good_heading', true ) ?: 'The good';
$acc_dest_good_body         = get_post_meta( $pid, 'acc_dest_good_body', true ) ?: 'The Tankerton promenade is a long, flat, surfaced path along the seafront, one of the most wheelchair-friendly coastal routes in Kent. Free parking at Marine Parade. Accessible toilets at the harbour end. The streets around the property are flat and paved with dropped kerbs.';
$acc_dest_challenge_heading = get_post_meta( $pid, 'acc_dest_challenge_heading', true ) ?: 'The challenge';
$acc_dest_challenge_body    = get_post_meta( $pid, 'acc_dest_challenge_body', true ) ?: 'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have stepped entrances with no ramp. The harbour itself has some uneven surfaces near the fish market. Weekday mornings are the easiest time to visit.';
$acc_dest_reality_heading   = get_post_meta( $pid, 'acc_dest_reality_heading', true ) ?: 'The reality';
$acc_dest_reality_body      = get_post_meta( $pid, 'acc_dest_reality_body', true ) ?: "Whitstable's beach is shingle. We want to be honest: shingle beaches are generally not wheelchair-friendly. The promenade above the beach provides excellent views and is accessible for most wheelchair users. There are also accessible cafes and restaurants along the seafront at street level.";

// CTA
$acc_cta_heading = get_post_meta( $pid, 'acc_cta_heading', true ) ?: 'Still have questions?';
$acc_cta_body    = get_post_meta( $pid, 'acc_cta_body', true ) ?: 'We understand that accessibility details matter, and that everyone\'s needs are different. If you have specific questions about the property, the local area, or anything else, please get in touch.';
$acc_cta_btn     = get_post_meta( $pid, 'acc_cta_btn', true ) ?: 'Ask us anything';
$acc_cta_url     = esc_url( get_post_meta( $pid, 'acc_cta_url', true ) ?: home_url( '/enquire/' ) );

$access_statement_url = restwell_get_access_statement_url();
$access_statement_url = $access_statement_url !== '' ? esc_url( $access_statement_url ) : '';

$rooms = array(
	array( 'heading' => $acc_arrival_heading,  'body' => $acc_arrival_body ),
	array( 'heading' => $acc_inside_heading,   'body' => $acc_inside_body ),
	array( 'heading' => $acc_bedroom_heading,  'body' => $acc_bedroom_body ),
	array( 'heading' => $acc_bathroom_heading, 'body' => $acc_bathroom_body ),
	array( 'heading' => $acc_kitchen_heading,  'body' => $acc_kitchen_body ),
	array( 'heading' => $acc_outdoor_heading,  'body' => $acc_outdoor_body ),
);
?>
<main class="flex-1" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<?php
	set_query_var(
		'args',
		array(
			'heading_id'  => 'page-hero-heading',
			'label'       => $acc_label,
			'heading'     => $acc_heading,
			'intro'       => $acc_intro,
			'media_id'    => $acc_hero_image_id,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<!-- Room by room -->
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-labelledby="acc-room-heading">
		<div class="container max-w-4xl">
			<?php if ( $acc_room_label !== '' ) : ?>
				<p class="section-label mb-3"><?php echo esc_html( $acc_room_label ); ?></p>
			<?php endif; ?>
			<h2 id="acc-room-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $acc_room_heading ); ?></h2>
			<?php if ( $acc_room_intro !== '' ) : ?>
				<p class="text-gray-600 leading-relaxed mb-10 max-w-prose"><?php echo esc_html( $acc_room_intro ); ?></p>
			<?php endif; ?>
			<div class="space-y-6">
				<?php foreach ( $rooms as $room ) :
					$lines = array_filter( array_map( 'trim', explode( "\n", $room['body'] ) ), function ( $line ) {
						$lower = strtolower( $line );
						return strpos( $lower, 'to be confirmed' ) === false
							&& strpos( $lower, 'to be established' ) === false
							&& strpos( $lower, 'tbc' ) === false
							&& $line !== '';
					} );
					if ( empty( $lines ) ) continue;
				?>
					<div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100
					            hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5
					            transition-all duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:translate-y-0">
						<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $room['heading'] ); ?></h3>
						<ul class="space-y-3 text-gray-700">
							<?php foreach ( $lines as $line ) : ?>
								<li class="flex items-start gap-3">
									<span class="w-6 h-6 rounded-full bg-[#A8D5D0]/40 flex items-center justify-center flex-shrink-0 mt-0.5 text-[#1B4D5C] text-xs" aria-hidden="true">
										<i class="fa-solid fa-check"></i>
									</span>
									<span><?php echo esc_html( $line ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Inquiry cards for specific requirements -->
			<div class="mt-12 grid md:grid-cols-2 gap-6">
				<div class="bg-[var(--bg-subtle)] rounded-2xl p-7 border border-gray-100 flex flex-col gap-5">
					<div>
						<h3 class="text-lg font-serif text-[var(--deep-teal)] mb-2">Have a specific requirement?</h3>
						<p class="text-gray-600 leading-relaxed text-sm">We are happy to discuss access needs, measurements, or equipment availability. Get in touch and we will answer honestly.</p>
					</div>
					<a href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>" class="btn btn-primary self-start">
						Ask us directly <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="bg-[var(--bg-subtle)] rounded-2xl p-7 border border-gray-100 flex flex-col gap-5">
					<div>
						<h3 class="text-lg font-serif text-[var(--deep-teal)] mb-2">Need precise measurements?</h3>
						<p class="text-gray-600 leading-relaxed text-sm">Door widths, turning circles, bed heights, grab rail positions: we can provide exact figures for any room in the property.</p>
					</div>
					<a href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>" class="btn btn-primary self-start">
						Request measurements <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Destination: what to expect -->
	<section class="py-16 md:py-24 bg-[var(--soft-sand)]" aria-labelledby="acc-dest-heading">
		<div class="container max-w-4xl">
			<?php if ( $acc_dest_label !== '' ) : ?>
				<p class="section-label mb-3"><?php echo esc_html( $acc_dest_label ); ?></p>
			<?php endif; ?>
			<h2 id="acc-dest-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $acc_dest_heading ); ?></h2>
			<p class="text-gray-600 leading-relaxed mb-10 max-w-prose"><?php echo esc_html( $acc_dest_intro ); ?></p>
			<div class="grid md:grid-cols-3 gap-6">

				<!-- The good -->
				<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col gap-4
				            hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5
				            transition-all duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:translate-y-0">
					<div class="w-10 h-10 rounded-full bg-[#A8D5D0]/40 flex items-center justify-center text-[var(--deep-teal)]" aria-hidden="true">
						<i class="fa-solid fa-check text-sm"></i>
					</div>
					<div>
						<h3 class="text-lg font-semibold font-serif text-[var(--deep-teal)] mb-2"><?php echo esc_html( $acc_dest_good_heading ); ?></h3>
						<p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html( $acc_dest_good_body ); ?></p>
					</div>
				</div>

				<!-- The challenge -->
				<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col gap-4
				            hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5
				            transition-all duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:translate-y-0">
					<div class="w-10 h-10 rounded-full bg-[#A8D5D0]/40 flex items-center justify-center text-[var(--deep-teal)]" aria-hidden="true">
						<i class="fa-solid fa-route text-sm"></i>
					</div>
					<div>
						<h3 class="text-lg font-semibold font-serif text-[var(--deep-teal)] mb-2"><?php echo esc_html( $acc_dest_challenge_heading ); ?></h3>
						<p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html( $acc_dest_challenge_body ); ?></p>
					</div>
				</div>

				<!-- The reality -->
				<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col gap-4
				            hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5
				            transition-all duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:translate-y-0">
					<div class="w-10 h-10 rounded-full bg-[#A8D5D0]/40 flex items-center justify-center text-[var(--deep-teal)]" aria-hidden="true">
						<i class="fa-solid fa-circle-info text-sm"></i>
					</div>
					<div>
						<h3 class="text-lg font-semibold font-serif text-[var(--deep-teal)] mb-2"><?php echo esc_html( $acc_dest_reality_heading ); ?></h3>
						<p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html( $acc_dest_reality_body ); ?></p>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php if ( $access_statement_url !== '' ) : ?>
	<!-- Access statement download -->
	<section class="py-16 md:py-24 bg-white border-t border-[#E8DFD0]/80" aria-labelledby="acc-statement-heading">
		<div class="container max-w-3xl text-center">
			<h3 id="acc-statement-heading" class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php esc_html_e( 'Download our access statement', 'restwell-retreats' ); ?></h3>
			<p class="text-gray-600 leading-relaxed mb-8 max-w-prose mx-auto"><?php esc_html_e( 'A PDF summary of access routes, door widths, equipment, and the local area, useful for OTs, commissioners, and planning your stay.', 'restwell-retreats' ); ?></p>
			<a href="<?php echo esc_url( $access_statement_url ); ?>" class="btn btn-primary inline-flex items-center gap-2" rel="noopener" target="_blank">
				<i class="fa-solid fa-file-pdf" aria-hidden="true"></i>
				<?php esc_html_e( 'Open access statement (PDF)', 'restwell-retreats' ); ?>
			</a>
			<p class="text-sm text-[var(--muted-grey)] mt-6">
				<a href="<?php echo esc_url( home_url( '/the-property/' ) ); ?>" class="text-[var(--deep-teal)] underline underline-offset-2 hover:no-underline"><?php esc_html_e( 'The Property', 'restwell-retreats' ); ?></a>
				<span aria-hidden="true"> · </span>
				<a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>" class="text-[var(--deep-teal)] underline underline-offset-2 hover:no-underline"><?php esc_html_e( 'FAQ', 'restwell-retreats' ); ?></a>
			</p>
		</div>
	</section>
	<?php endif; ?>

	<!-- CTA -->
	<section class="py-16 md:py-20 bg-[var(--deep-teal)] text-center" aria-labelledby="acc-cta-heading">
		<div class="container max-w-2xl">
			<h2 id="acc-cta-heading" class="text-3xl font-serif text-white mb-4"><?php echo esc_html( $acc_cta_heading ); ?></h2>
			<p class="text-white/90 text-lg leading-relaxed max-w-md mx-auto mb-8"><?php echo esc_html( $acc_cta_body ); ?></p>
			<a href="<?php echo esc_url( $acc_cta_url ); ?>" class="btn btn-gold">
				<?php echo esc_html( $acc_cta_btn ); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
	</section>

</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
