<?php
/**
 * Template Name: How It Works
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

// Hero
$hiw_hero_image_id = (int) get_post_meta( $pid, 'hiw_hero_image_id', true );
$hiw_label          = get_post_meta( $pid, 'hiw_label', true ) ?: '';
$hiw_heading        = get_post_meta( $pid, 'hiw_heading', true ) ?: 'How it works';
$hiw_intro          = get_post_meta( $pid, 'hiw_intro', true ) ?: 'From first enquiry to arrival: how your accessible stay in Kent works at Restwell — tell us what you need and we will take it from there.';
$hiw_hero_cta_text           = get_post_meta( $pid, 'hiw_hero_cta_text', true ) ?: 'Check your dates';
$hiw_hero_cta_url            = esc_url( get_post_meta( $pid, 'hiw_hero_cta_url', true ) ?: home_url( '/enquire/' ) );
$hiw_hero_cta_promise        = get_post_meta( $pid, 'hiw_hero_cta_promise', true ) ?: '';
$hiw_hero_cta_secondary_text = get_post_meta( $pid, 'hiw_hero_cta_secondary_text', true ) ?: '';
$hiw_hero_cta_secondary_url  = esc_url( get_post_meta( $pid, 'hiw_hero_cta_secondary_url', true ) ?: home_url( '/enquire/' ) );

// Steps (4) - section label, heading + step copy
$hiw_steps_label   = get_post_meta( $pid, 'hiw_steps_label', true ) ?: 'FOUR-STEP PROCESS';
$hiw_steps_heading = get_post_meta( $pid, 'hiw_steps_heading', true ) ?: 'Straightforward from start to finish';
$hiw_steps_intro   = get_post_meta( $pid, 'hiw_steps_intro', true ) ?: 'Share your dates and what you need; we\'ll handle the rest.';
$steps = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$title = get_post_meta( $pid, "hiw_step{$i}_title", true );
	$body  = get_post_meta( $pid, "hiw_step{$i}_body", true );
	if ( $i === 1 && ! $title ) {
		$title = 'Get in touch';
		$body  = $body ?: 'Share your dates and what you need. We\'ll get back to you and take it from there.';
	}
	if ( $i === 2 && ! $title ) {
		$title = 'Plan your stay';
		$body  = $body ?: "We'll confirm the property, walk you through what's included, and answer any questions.";
	}
	if ( $i === 3 && ! $title ) {
		$title = 'Arrange support (if needed)';
		$body  = $body ?: "If you want care support during your stay, we can connect you with Continuity of Care Services, a CQC-regulated provider based in Kent. You can also bring your own carer or PA. This step is entirely optional.";
	}
	if ( $i === 4 && ! $title ) {
		$title = 'Arrive and enjoy';
		$body  = $body ?: 'The house is yours. Settle in, explore Whitstable, and take a proper break.';
	}
	$steps[] = array(
		'title' => $title ?: '',
		'body'  => $body ?: '',
	);
}

// Care CTA band
$hiw_care_cta_label   = get_post_meta( $pid, 'hiw_care_cta_label', true ) ?: 'CARE SUPPORT';
$hiw_care_cta_heading = get_post_meta( $pid, 'hiw_care_cta_heading', true ) ?: 'Care support works around you, not shift patterns.';
$hiw_care_cta_body    = get_post_meta( $pid, 'hiw_care_cta_body', true ) ?: 'Care is entirely optional. If you want it, Continuity of Care Services (CQC-regulated and experienced) will work to your schedule, not theirs. Morning check-ins, personal care, or more comprehensive support: you decide.';
$hiw_care_cta_btn     = get_post_meta( $pid, 'hiw_care_cta_btn', true ) ?: 'Learn about care support';
$hiw_care_cta_url     = esc_url( get_post_meta( $pid, 'hiw_care_cta_url', true ) ?: home_url( '/accessibility/' ) );

// What's included (card grid - inspiration: Bed linen & towels, Welcome pack, Full kitchen, Private garden, Fast Wi-Fi, Accessible parking)
$hiw_included_label   = get_post_meta( $pid, 'hiw_included_label', true ) ?: 'WHAT\'S INCLUDED';
$hiw_included_heading = get_post_meta( $pid, 'hiw_included_heading', true ) ?: "What's included in every stay";
$hiw_included_intro   = get_post_meta( $pid, 'hiw_included_intro', true ) ?: 'No hidden extras. These come with every booking as standard.';
$included_items = array(
	array( 'title' => 'Bed linen & towels', 'desc' => 'Fresh linen and towels so you can relax from the moment you arrive.', 'icon' => 'linen' ),
	array( 'title' => 'Welcome pack', 'desc' => 'Tea, coffee, milk, and a few basics so you are not shopping the moment you arrive.', 'icon' => 'gift' ),
	array( 'title' => 'Full kitchen', 'desc' => 'Fully equipped kitchen for cooking at your own pace.', 'icon' => 'kitchen' ),
	array( 'title' => 'Private garden', 'desc' => 'Your own outdoor space to enjoy.', 'icon' => 'garden' ),
	array( 'title' => 'Fast Wi-Fi', 'desc' => 'Stay connected when you need to.', 'icon' => 'wifi' ),
	array( 'title' => 'Accessible parking', 'desc' => 'Designated parking close to the property.', 'icon' => 'parking' ),
);
for ( $i = 1; $i <= 6; $i++ ) {
	$t = get_post_meta( $pid, "hiw_included_{$i}_title", true );
	$d = get_post_meta( $pid, "hiw_included_{$i}_desc", true );
	if ( $t ) {
		$included_items[ $i - 1 ]['title'] = $t;
		$included_items[ $i - 1 ]['desc']  = $d ?: '';
	}
}

// Bottom CTA
$hiw_cta_label            = get_post_meta( $pid, 'hiw_cta_label', true ) ?: '';
$hiw_cta_heading          = get_post_meta( $pid, 'hiw_cta_heading', true ) ?: 'Ready to plan your break?';
$hiw_cta_body             = get_post_meta( $pid, 'hiw_cta_body', true ) ?: 'Get in touch and we\'ll answer any questions, check availability, and take it from there.';
$hiw_cta_primary_label     = get_post_meta( $pid, 'hiw_cta_primary_label', true ) ?: 'Enquire now';
$hiw_cta_primary_url      = esc_url( get_post_meta( $pid, 'hiw_cta_primary_url', true ) ?: home_url( '/enquire/' ) );
$hiw_cta_promise          = get_post_meta( $pid, 'hiw_cta_promise', true ) ?: 'No obligation. Ask us anything.';
$hiw_cta_secondary_label  = get_post_meta( $pid, 'hiw_cta_secondary_label', true ) ?: 'See the property';
$hiw_cta_secondary_url    = esc_url( get_post_meta( $pid, 'hiw_cta_secondary_url', true ) ?: home_url( '/the-property/' ) );

// Common questions (FAQ)
$hiw_faq_label   = get_post_meta( $pid, 'hiw_faq_label', true ) ?: 'HAVE QUESTIONS?';
$hiw_faq_heading = get_post_meta( $pid, 'hiw_faq_heading', true ) ?: 'Common questions';
$hiw_faq_intro   = get_post_meta( $pid, 'hiw_faq_intro', true ) ?: 'Answers to the things people ask us most. Anything else: just get in touch.';
$faq_pairs = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$q = get_post_meta( $pid, "hiw_faq_{$i}_q", true );
	$a = get_post_meta( $pid, "hiw_faq_{$i}_a", true );
	if ( $i === 1 && ! $q ) {
		$q = 'Do I have to use the care support?';
		$a = $a ?: 'Absolutely not. Care support is an optional extra we can arrange if you need it, but you are also welcome to arrange your own care or manage without.';
	}
	if ( $i === 2 && ! $q ) {
		$q = 'Can I bring my own carer?';
		$a = $a ?: 'Yes. You are always welcome to bring your own Personal Assistant or carer. The property is designed to accommodate everyone comfortably.';
	}
	if ( $i === 3 && ! $q ) {
		$q = 'How far is the property from the beach?';
		$a = $a ?: 'The Tankerton promenade is about 15 minutes\' flat walk from the property. The town centre and harbour are about a 7-minute drive or 20-minute walk. We can provide exact routes and accessibility notes for any destination before your stay.';
	}
	if ( $q || $a ) {
		$faq_pairs[] = array( 'q' => $q ?: '', 'a' => $a ?: '' );
	}
}
?>
<main class="flex-1" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>
	<?php
	set_query_var(
		'args',
		array(
			'heading_id'    => 'page-hero-heading',
			'label'         => $hiw_label,
			'heading'       => $hiw_heading,
			'intro'         => $hiw_intro,
			'media_id'      => $hiw_hero_image_id,
			'content_max'   => 'max-w-2xl',
			'cta_primary'   => $hiw_hero_cta_text !== '' ? array(
				'label' => $hiw_hero_cta_text,
				'url'   => $hiw_hero_cta_url,
			) : array(),
			'cta_secondary' => $hiw_hero_cta_secondary_text !== '' ? array(
				'label' => $hiw_hero_cta_secondary_text,
				'url'   => $hiw_hero_cta_secondary_url,
			) : array(),
			'cta_promise'   => $hiw_hero_cta_promise,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<!-- Four-step process -->
	<?php
	set_query_var( 'args', array(
		'steps_label'   => $hiw_steps_label,
		'steps_heading' => $hiw_steps_heading,
		'steps_intro'   => $hiw_steps_intro,
		'steps'         => $steps,
	) );
	get_template_part( 'template-parts/how-it-works-steps' );
	?>

	<!-- Care support CTA band -->
	<section class="py-16 md:py-24 bg-[var(--deep-teal)]" aria-labelledby="care-cta-heading">
		<div class="container max-w-3xl text-center">
			<?php if ( $hiw_care_cta_label !== '' ) : ?>
				<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-3 font-sans"><?php echo esc_html( $hiw_care_cta_label ); ?></p>
			<?php endif; ?>
			<h2 id="care-cta-heading" class="text-3xl md:text-4xl font-serif text-white mb-4"><?php echo esc_html( $hiw_care_cta_heading ); ?></h2>
			<p class="text-white/85 text-lg leading-relaxed mb-8 max-w-2xl mx-auto"><?php echo esc_html( $hiw_care_cta_body ); ?></p>
		<a href="<?php echo esc_url( $hiw_care_cta_url ); ?>" class="btn btn-gold">
				<?php echo esc_html( $hiw_care_cta_btn ); ?>
				<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
	</section>

	<!-- What's included (cards) -->
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-labelledby="hiw-included-heading">
		<div class="container">
			<p class="section-label text-center mb-3"><?php echo esc_html( $hiw_included_label ); ?></p>
			<h2 id="hiw-included-heading" class="text-3xl font-serif text-[var(--deep-teal)] text-center mb-4"><?php echo esc_html( $hiw_included_heading ); ?></h2>
			<?php if ( $hiw_included_intro !== '' ) : ?>
			<p class="text-gray-600 text-lg leading-relaxed text-center max-w-prose mx-auto mb-10"><?php echo esc_html( $hiw_included_intro ); ?></p>
			<?php endif; ?>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10 max-w-5xl mx-auto">
				<?php foreach ( $included_items as $item ) : ?>
				<div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100
				            flex flex-col items-center text-center
				            hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5
				            transition-all duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:translate-y-0">
					<div class="text-[var(--deep-teal)] mb-5" aria-hidden="true">
						<?php
						switch ( $item['icon'] ) {
							case 'house':
								echo '<i class="fa-solid fa-house text-3xl"></i>';
								break;
							case 'linen':
								echo '<i class="fa-solid fa-bed text-3xl"></i>';
								break;
							case 'gift':
								echo '<i class="fa-solid fa-gift text-3xl"></i>';
								break;
							case 'kitchen':
								echo '<i class="fa-solid fa-utensils text-3xl"></i>';
								break;
							case 'accessibility':
								echo '<i class="fa-solid fa-universal-access text-3xl"></i>';
								break;
							case 'garden':
								echo '<i class="fa-solid fa-seedling text-3xl"></i>';
								break;
							case 'wifi':
								echo '<i class="fa-solid fa-wifi text-3xl"></i>';
								break;
							case 'parking':
								echo '<i class="fa-solid fa-square-parking text-3xl"></i>';
								break;
							case 'clock':
							default:
								echo '<i class="fa-solid fa-clock text-3xl"></i>';
								break;
						}
						?>
					</div>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3 leading-tight"><?php echo esc_html( $item['title'] ); ?></h3>
					<?php if ( ! empty( $item['desc'] ) ) : ?>
					<p class="text-gray-600 leading-relaxed text-sm md:text-base"><?php echo esc_html( $item['desc'] ); ?></p>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Bottom CTA -->
	<section class="py-16 md:py-24 bg-[var(--soft-sand)]" aria-labelledby="hiw-cta-heading">
		<div class="container max-w-3xl text-center">
			<?php if ( $hiw_cta_label !== '' ) : ?>
				<p class="section-label mb-3"><?php echo esc_html( $hiw_cta_label ); ?></p>
			<?php endif; ?>
			<h2 id="hiw-cta-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $hiw_cta_heading ); ?></h2>
			<?php if ( $hiw_cta_body !== '' ) : ?>
				<p class="text-gray-600 text-lg leading-relaxed mb-8 max-w-prose mx-auto"><?php echo esc_html( $hiw_cta_body ); ?></p>
			<?php endif; ?>
		<div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
			<a href="<?php echo esc_url( $hiw_cta_primary_url ); ?>" class="btn btn-primary">
				<?php echo esc_html( $hiw_cta_primary_label ); ?>
				<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
			</a>
			<a href="<?php echo esc_url( $hiw_cta_secondary_url ); ?>" class="btn btn-outline">
				<?php echo esc_html( $hiw_cta_secondary_label ); ?>
			</a>
		</div>
			<?php if ( $hiw_cta_promise !== '' ) : ?>
				<p class="text-gray-600 text-sm mt-4"><?php echo esc_html( $hiw_cta_promise ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Common questions (FAQ): same accordion pattern as template-faq.php -->
	<?php if ( ! empty( $faq_pairs ) ) : ?>
	<section class="py-16 md:py-24 bg-white" aria-labelledby="hiw-faq-heading">
		<div class="container max-w-3xl">
			<p class="section-label mb-3"><?php echo esc_html( $hiw_faq_label ); ?></p>
			<h2 id="hiw-faq-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $hiw_faq_heading ); ?></h2>
			<?php if ( $hiw_faq_intro !== '' ) : ?>
				<p class="text-gray-600 text-lg leading-relaxed mb-10 max-w-prose"><?php echo esc_html( $hiw_faq_intro ); ?></p>
			<?php endif; ?>
			<div class="space-y-3">
				<?php foreach ( $faq_pairs as $faq ) : ?>
					<details class="bg-white rounded-2xl px-8 shadow-[0_4px_20px_rgb(0,0,0,0.05)] border border-gray-100 group">
						<summary class="text-[var(--deep-teal)] font-medium text-base py-5 min-h-[2.75rem] cursor-pointer list-none flex items-center justify-between gap-4 [&::-webkit-details-marker]:hidden rounded-xl">
							<span><?php echo esc_html( $faq['q'] ); ?></span>
							<span class="flex-shrink-0 text-[var(--warm-gold)] transition-transform duration-200 group-open:rotate-180" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
						</summary>
						<div class="text-gray-600 text-sm leading-relaxed pb-6"><?php echo wp_kses_post( wpautop( $faq['a'] ) ); ?></div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- Related guides -->
	<section class="py-12 md:py-16 bg-[var(--bg-subtle)] border-t border-gray-100" aria-labelledby="hiw-related-heading">
		<div class="container max-w-3xl">
			<h2 id="hiw-related-heading" class="text-2xl font-serif text-[var(--deep-teal)] mb-4"><?php esc_html_e( 'Useful guides for planning your stay', 'restwell-retreats' ); ?></h2>
			<ul class="space-y-3 text-gray-700">
				<li>
					<a href="<?php echo esc_url( home_url( '/direct-payment-holiday-accommodation/' ) ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline">
						<?php esc_html_e( 'How to use your direct payment for a holiday', 'restwell-retreats' ); ?>
					</a>
					<span class="text-gray-500">: <?php esc_html_e( 'whether your care funding can cover support during a holiday stay.', 'restwell-retreats' ); ?></span>
				</li>
				<li>
					<a href="<?php echo esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline">
						<?php esc_html_e( 'How to choose an accessible self-catering holiday property', 'restwell-retreats' ); ?>
					</a>
					<span class="text-gray-500">: <?php esc_html_e( 'a checklist of questions to ask before you commit to any property.', 'restwell-retreats' ); ?></span>
				</li>
				<li>
					<a href="<?php echo esc_url( home_url( '/who-its-for/' ) ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline">
						<?php esc_html_e( 'Who Restwell is for', 'restwell-retreats' ); ?>
					</a>
					<span class="text-gray-500">: <?php esc_html_e( 'guests, carers, families, and professional referrers.', 'restwell-retreats' ); ?></span>
				</li>
			</ul>
		</div>
	</section>
</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
