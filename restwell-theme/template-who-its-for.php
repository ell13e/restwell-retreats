<?php
/**
 * Template Name: Who It's For
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

$hero_image_id = (int) get_post_meta( $pid, 'wif_hero_image_id', true );
$label          = (string) get_post_meta( $pid, 'wif_label', true ) ?: 'Who it is for';
$heading        = (string) get_post_meta( $pid, 'wif_heading', true ) ?: 'Who Restwell is for';
$intro          = (string) get_post_meta( $pid, 'wif_intro', true ) ?: 'Whether you are booking for yourself, someone you support, or a client, Restwell is designed to make planning straightforward and your stay comfortable. Here is how it works for different people.';

$audience_heading = (string) get_post_meta( $pid, 'wif_audience_heading', true ) ?: 'Which of these sounds like you?';
$audience_intro   = (string) get_post_meta( $pid, 'wif_audience_intro', true ) ?: 'Open the section that fits your situation. We have set out what usually matters, in plain language, with a clear next step when you are ready.';

$default_family_bullets = array(
	'Ceiling track hoist, profiling bed, and wet room with roll-in shower, already in place.',
	'Published access measurements before you commit to anything.',
	'A private self-catering layout: your daily routines run on your schedule.',
);
$default_carers_bullets = array(
	'Separate sleeping area for the support worker or carer.',
	'Wet room designed for assisted personal care, not adapted from a standard bathroom.',
	'You have a legal right to a Carer\'s Assessment under the Care Act 2014. Ask your council.',
);
$default_ot_bullets = array(
	'Doorway widths, turning circles, hoist specs, and wet room measurements on request.',
	'Transfer clearances and equipment positioning confirmed if not already published.',
	'Referral conversations welcomed before any booking commitment.',
);
$default_commissioners_bullets = array(
	'Short breaks at a private adapted setting can form part of a care and support plan under the Care Act 2014.',
	'Documentation provided: property spec, access measurements, and CQC-registered care provider confirmation.',
	'Direct payments, personal health budgets, and CHC pathways all supported.',
);

$personas = array(
	array(
		'id'               => 'wif-guests',
		'jump_label'       => (string) get_post_meta( $pid, 'wif_nav_family_label', true ) ?: __( "I'm a guest or family", 'restwell-retreats' ),
		'icon'             => 'users',
		'featured'         => true,
		'title'            => (string) get_post_meta( $pid, 'wif_family_title', true ) ?: 'For guests and families',
		'body'             => restwell_wif_persona_intro_body(
			$pid,
			'wif_family_body',
			'wif_family_detail_body',
			"\"Accessible\" and \"wheelchair friendly\" are used loosely by a lot of accommodation. People book in good faith and arrive to find a step at the entrance, a bathroom that is too small to turn, or a hoist that is not actually there. Restwell works the other way: the ceiling track hoist is already fitted, the wet room has a roll-in shower with turning space, and every doorway and corridor is sized for a powerchair.\n\nThe full measurements are published on our accessibility page. Check them before you enquire, not after.\n\nThis is a private home, not a converted hotel room. No shared spaces, no clinical layout, and no surprises on arrival."
		),
		'bullets'          => restwell_wif_bullet_list( $pid, 'wif_family_detail_bullets', $default_family_bullets ),
		'inline_cta_label' => (string) get_post_meta( $pid, 'wif_family_inline_cta_label', true ) ?: __( 'Read accessibility specification', 'restwell-retreats' ),
		'inline_cta_url'   => (string) get_post_meta( $pid, 'wif_family_inline_cta_url', true ) ?: '/accessibility/',
	),
	array(
		'id'               => 'wif-carers',
		'jump_label'       => (string) get_post_meta( $pid, 'wif_nav_carers_label', true ) ?: __( "I'm a carer", 'restwell-retreats' ),
		'icon'             => 'hand-heart',
		'featured'         => false,
		'title'            => (string) get_post_meta( $pid, 'wif_carers_title', true ) ?: 'For carers and support workers',
		'body'             => restwell_wif_persona_intro_body(
			$pid,
			'wif_carers_body',
			'wif_carers_detail_body',
			"The ceiling hoist is already fitted, the wet room is designed for assisted personal care, and there is a separate sleeping area for the support worker. The layout is practical, not just manageable.\n\nIf your client has complex needs, check the suitability details with us before you commit. We will give you specifics, not a brochure.\n\nOne thing many carers do not know: you have a legal right to a Carer's Assessment under the Care Act 2014. Your local council must carry one out if you ask. It can open up direct payment routes to fund a holiday or short break, so it is worth requesting if you have not had one."
		),
		'bullets'          => restwell_wif_bullet_list( $pid, 'wif_carers_detail_bullets', $default_carers_bullets ),
		'inline_cta_label' => (string) get_post_meta( $pid, 'wif_carers_inline_cta_label', true ) ?: __( 'Ask a suitability question', 'restwell-retreats' ),
		'inline_cta_url'   => (string) get_post_meta( $pid, 'wif_carers_inline_cta_url', true ) ?: '/enquire/',
	),
	array(
		'id'               => 'wif-ot',
		'jump_label'       => (string) get_post_meta( $pid, 'wif_nav_ot_label', true ) ?: __( "I'm an OT / case manager", 'restwell-retreats' ),
		'icon'             => 'clipboard-text',
		'featured'         => false,
		'title'            => (string) get_post_meta( $pid, 'wif_ot_title', true ) ?: 'For occupational therapists and case managers',
		'body'             => restwell_wif_persona_intro_body(
			$pid,
			'wif_ot_body',
			'wif_ot_detail_body',
			"Our accessibility page publishes doorway widths, turning circle dimensions, ceiling track hoist specifications, profiling bed measurements, and wet room dimensions: the specifics that matter for a clinical recommendation.\n\nIf you need something we have not published (transfer clearances, approach gradients, equipment positioning), ask and we will measure it.\n\nWe understand a poor recommendation reflects on you. We would rather give you a straight answer than lose your trust, and we welcome referral conversations before any booking commitment."
		),
		'bullets'          => restwell_wif_bullet_list( $pid, 'wif_ot_detail_bullets', $default_ot_bullets ),
		'inline_cta_label' => (string) get_post_meta( $pid, 'wif_ot_inline_cta_label', true ) ?: __( 'Review accessibility details', 'restwell-retreats' ),
		'inline_cta_url'   => (string) get_post_meta( $pid, 'wif_ot_inline_cta_url', true ) ?: '/accessibility/',
	),
	array(
		'id'               => 'wif-commissioners',
		'jump_label'       => (string) get_post_meta( $pid, 'wif_nav_commissioners_label', true ) ?: __( "I'm a commissioner", 'restwell-retreats' ),
		'icon'             => 'buildings',
		'featured'         => false,
		'title'            => (string) get_post_meta( $pid, 'wif_commissioners_title', true ) ?: 'For commissioners and social care teams',
		'body'             => restwell_wif_persona_intro_body(
			$pid,
			'wif_commissioners_body',
			'wif_commissioners_detail_body',
			"Under the Care Act 2014, short breaks at a private adapted setting can be included in a care and support plan where the property meets the person's assessed needs. Restwell supports direct payment stays, personal health budgets, and CHC-funded packages.\n\nWe can provide the documentation a referral process typically requires: property specification, access measurements, equipment inventory, and written confirmation of our connection to Continuity of Care Services, a CQC-registered provider.\n\nMost local authority funding decisions require evidence. We provide it."
		),
		'bullets'          => restwell_wif_bullet_list( $pid, 'wif_commissioners_detail_bullets', $default_commissioners_bullets ),
		'inline_cta_label' => (string) get_post_meta( $pid, 'wif_commissioners_inline_cta_label', true ) ?: __( 'Enquire about a funded stay', 'restwell-retreats' ),
		'inline_cta_url'   => (string) get_post_meta( $pid, 'wif_commissioners_inline_cta_url', true ) ?: '/enquire/',
	),
);

$funding_heading = (string) get_post_meta( $pid, 'wif_funding_heading', true ) ?: 'How funding can work';
$funding_body    = (string) get_post_meta( $pid, 'wif_funding_body', true ) ?: 'Many guests use direct payments, personal budgets, or CHC pathways. Most funded stays begin with a Care and Support Assessment, which is a right under the Care Act 2014. In Kent, that means contacting Kent County Council Adult Social Care. The three routes below explain how each pathway works.';

$default_fund_la_bullets = array(
	__( 'Begins with a Care and Support Assessment. Unpaid carers can request a Carer\'s Assessment too (Care Act 2014).', 'restwell-retreats' ),
	__( 'Direct payments: you receive the funding and choose your provider.', 'restwell-retreats' ),
	__( 'Capital limits 2024/25: above £23,250 you pay in full; below £14,250 is usually ignored.', 'restwell-retreats' ),
);
$default_fund_phb_bullets = array(
	__( 'Available for people with continuing healthcare needs, subject to eligibility assessment.', 'restwell-retreats' ),
	__( 'Your ICB or NHS continuing healthcare team manages the application.', 'restwell-retreats' ),
	__( 'A private adapted setting can be written into a care and support plan where clinically appropriate.', 'restwell-retreats' ),
);
$default_fund_private_bullets = array(
	__( 'The same clear accessibility information and direct answers as for funded guests.', 'restwell-retreats' ),
	__( 'Documentation for insurers or employers if you need it.', 'restwell-retreats' ),
	__( 'No pressure: we tell you plainly whether the property is a good fit.', 'restwell-retreats' ),
);

$funding_routes = array(
	array(
		'icon'    => 'bank',
		'title'   => (string) get_post_meta( $pid, 'wif_fund_la_title', true ) ?: __( 'Local authority & direct payments', 'restwell-retreats' ),
		'bullets' => restwell_wif_bullet_list( $pid, 'wif_fund_la_bullets', $default_fund_la_bullets ),
		'cta_label' => (string) get_post_meta( $pid, 'wif_fund_la_cta_label', true ) ?: __( 'Direct payments guide', 'restwell-retreats' ),
		'cta_url'   => (string) get_post_meta( $pid, 'wif_fund_la_cta_url', true ) ?: '/direct-payment-holiday-accommodation/',
	),
	array(
		'icon'    => 'heartbeat',
		'title'   => (string) get_post_meta( $pid, 'wif_fund_phb_title', true ) ?: __( 'Personal health budget', 'restwell-retreats' ),
		'bullets' => restwell_wif_bullet_list( $pid, 'wif_fund_phb_bullets', $default_fund_phb_bullets ),
		'cta_label' => (string) get_post_meta( $pid, 'wif_fund_phb_cta_label', true ) ?: __( 'PHB and funding overview', 'restwell-retreats' ),
		'cta_url'   => (string) get_post_meta( $pid, 'wif_fund_phb_cta_url', true ) ?: '/resources/',
	),
	array(
		'icon'    => 'wallet',
		'title'   => (string) get_post_meta( $pid, 'wif_fund_private_title', true ) ?: __( 'Private / self-funded', 'restwell-retreats' ),
		'bullets' => restwell_wif_bullet_list( $pid, 'wif_fund_private_bullets', $default_fund_private_bullets ),
		'cta_label' => (string) get_post_meta( $pid, 'wif_fund_private_cta_label', true ) ?: __( 'Ask about your dates', 'restwell-retreats' ),
		'cta_url'   => (string) get_post_meta( $pid, 'wif_fund_private_cta_url', true ) ?: '/enquire/',
	),
);

$wif_visual_intro = (string) get_post_meta( $pid, 'wif_visual_intro', true ) ?: __( 'Real photos help you judge fit before you book: layout, circulation space, and how equipment sits in the room. Pair these with our accessibility specification for verified measurements and features.', 'restwell-retreats' );

$img_1_id = (int) get_post_meta( $pid, 'wif_section_image_1_id', true );
$img_2_id = (int) get_post_meta( $pid, 'wif_section_image_2_id', true );
$img_3_id = (int) get_post_meta( $pid, 'wif_section_image_3_id', true );
$img_1_cap = (string) get_post_meta( $pid, 'wif_section_image_1_caption', true ) ?: __( 'Wet room and accessible bathroom', 'restwell-retreats' );
$img_2_cap = (string) get_post_meta( $pid, 'wif_section_image_2_caption', true ) ?: __( 'Spacious layout for equipment and transfers', 'restwell-retreats' );
$img_3_cap = (string) get_post_meta( $pid, 'wif_section_image_3_caption', true ) ?: __( 'Comfortable, private spaces', 'restwell-retreats' );

?>
<main class="flex-1 restwell-wif-page" id="main-content">
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<?php
	set_query_var(
		'args',
		array(
			'heading_id' => 'wif-hero-heading',
			'label'      => $label,
			'heading'    => $heading,
			'intro'      => $intro,
			'media_id'   => $hero_image_id,
			'image_alt'  => $heading,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<nav class="wif-persona-nav sticky z-30 border-b border-[var(--wif-subnav-border)] bg-white/95 backdrop-blur-sm shadow-[0_1px_0_rgba(0,0,0,0.04)]" aria-label="<?php esc_attr_e( 'On this page: section navigation', 'restwell-retreats' ); ?>">
		<div class="container max-w-5xl px-0 sm:px-4">
			<p class="sr-only"><?php esc_html_e( 'Jump to a section on this page', 'restwell-retreats' ); ?></p>
			<div class="wif-persona-nav__track">
				<ul class="wif-persona-nav__list">
					<?php foreach ( $personas as $p ) : ?>
						<li>
							<a class="wif-persona-nav__link" href="<?php echo esc_url( '#' . $p['id'] ); ?>" data-wif-anchor="<?php echo esc_attr( $p['id'] ); ?>">
								<?php echo esc_html( $p['jump_label'] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
					<li>
						<a class="wif-persona-nav__link" href="<?php echo esc_url( '#wif-funding' ); ?>" data-wif-anchor="wif-funding">
							<?php esc_html_e( 'Funding', 'restwell-retreats' ); ?>
						</a>
					</li>
				</ul>
			</div>
			<p class="wif-persona-nav__hint md:hidden" id="wif-persona-nav-hint">
				<?php esc_html_e( 'Swipe sideways to see every section.', 'restwell-retreats' ); ?>
			</p>
		</div>
	</nav>

	<section class="rw-section-y bg-[var(--bg-subtle)]" aria-labelledby="wif-audience-heading">
		<div class="container max-w-5xl">
			<div class="max-w-3xl rw-stack rw-mb-section">
				<p class="section-label"><?php esc_html_e( 'Your situation', 'restwell-retreats' ); ?></p>
				<h2 id="wif-audience-heading" class="wif-audience-section__title text-3xl md:text-4xl font-serif leading-tight text-[var(--deep-teal)] m-0"><?php echo esc_html( $audience_heading ); ?></h2>
				<p class="m-0 text-left text-[var(--muted-grey)] leading-relaxed max-w-prose"><?php echo esc_html( $audience_intro ); ?></p>
			</div>

			<div class="flex flex-col rw-stack rw-stack--loose">
				<?php foreach ( $personas as $card ) : ?>
					<div id="<?php echo esc_attr( $card['id'] ); ?>" class="wif-persona-card scroll-mt-28 rounded-2xl border border-gray-100/90 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-[box-shadow,border-color] duration-300 ease-out hover:border-gray-200/90 hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] motion-reduce:transition-none">
						<div class="flex flex-row gap-4 sm:gap-5 items-start wif-persona-card__inner">
							<div class="wif-icon-circle w-11 h-11 sm:w-12 sm:h-12" aria-hidden="true">
								<i class="ph-bold ph-<?php echo esc_attr( $card['icon'] ); ?> text-lg sm:text-xl"></i>
							</div>
							<div class="min-w-0 flex-1 flex flex-col">
								<h3 class="text-xl sm:text-2xl font-serif text-[var(--deep-teal)] m-0 leading-tight shrink-0" id="wif-heading-<?php echo esc_attr( $card['id'] ); ?>">
									<button
										type="button"
										class="wif-persona-expand wif-persona-expand--header flex w-full items-center justify-between gap-3 text-left font-inherit text-inherit"
										id="wif-expand-<?php echo esc_attr( $card['id'] ); ?>"
										aria-expanded="false"
										aria-controls="wif-panel-<?php echo esc_attr( $card['id'] ); ?>"
									>
										<span class="sr-only"><?php esc_html_e( 'Expand section:', 'restwell-retreats' ); ?></span>
										<span class="min-w-0 flex-1"><?php echo esc_html( $card['title'] ); ?></span>
										<span class="wif-persona-expand__icon flex-shrink-0" aria-hidden="true"><i class="ph-bold ph-caret-down"></i></span>
									</button>
								</h3>
								<div class="wif-persona-card__panel-shell">
									<div class="wif-persona-card__panel-overflow">
										<div id="wif-panel-<?php echo esc_attr( $card['id'] ); ?>" class="wif-persona-card__panel" role="region" aria-labelledby="wif-heading-<?php echo esc_attr( $card['id'] ); ?>" aria-hidden="true" inert>
											<div class="wif-persona-card__body mt-6 border-t border-gray-200/80 pt-6 md:pt-7">
										<div class="wif-persona-card__split flex flex-col gap-7 lg:flex-row lg:items-stretch lg:gap-8 xl:gap-10">
											<div class="wif-persona-card__prose min-w-0 w-full max-w-prose flex-1 space-y-4 text-[var(--muted-grey)] text-[15px] sm:text-base leading-[1.65] sm:leading-relaxed lg:pt-1">
											<?php foreach ( restwell_wif_split_body_paragraphs( $card['body'] ) as $para ) : ?>
												<p class="m-0"><?php echo esc_html( $para ); ?></p>
											<?php endforeach; ?>
											</div>
											<aside class="wif-persona-card__aside w-full shrink-0 lg:flex lg:min-h-0 lg:max-w-sm lg:flex-col xl:max-w-md">
												<div class="wif-persona-card__highlights flex flex-col rounded-2xl border border-gray-100/90 bg-[var(--bg-subtle)] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:p-6 lg:h-full lg:min-h-0">
													<ul class="wif-persona-card__bullets m-0 list-none space-y-3.5 p-0 text-sm leading-snug text-[var(--muted-grey)] sm:leading-relaxed">
														<?php foreach ( $card['bullets'] as $item ) : ?>
															<li class="grid grid-cols-[1.25rem_minmax(0,1fr)] items-start gap-x-2 text-left">
																<span class="wif-icon-circle wif-icon-circle--muted h-5 w-5 shrink-0" aria-hidden="true">
																	<i class="ph-bold ph-check text-[10px]"></i>
																</span>
																<div class="min-w-0"><?php echo esc_html( $item ); ?></div>
															</li>
														<?php endforeach; ?>
													</ul>
													<div class="wif-persona-card__cta mt-4 border-t border-gray-200/60 pt-4 lg:mt-auto">
														<a class="inline-flex min-h-[2.75rem] w-full items-center justify-center gap-2 rounded-2xl bg-[var(--deep-teal)] px-6 py-3 text-center text-sm font-semibold text-white whitespace-normal no-underline transition-[opacity,transform] duration-300 ease-in-out hover:-translate-y-0.5 hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2 motion-reduce:transition-none motion-reduce:hover:translate-y-0" href="<?php echo esc_url( home_url( $card['inline_cta_url'] ) ); ?>">
															<?php echo esc_html( $card['inline_cta_label'] ); ?>
															<i class="ph-bold ph-arrow-right text-xs" aria-hidden="true"></i>
														</a>
													</div>
												</div>
											</aside>
										</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="rw-section-y bg-white" aria-labelledby="wif-visual-trust-heading">
		<div class="container max-w-5xl">
			<div class="rw-stack rw-mb-section max-w-prose">
				<p class="section-label"><?php esc_html_e( 'The property', 'restwell-retreats' ); ?></p>
				<h2 id="wif-visual-trust-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Accessibility you can see, not just read about', 'restwell-retreats' ); ?></h2>
				<p class="text-gray-600 m-0 leading-relaxed max-w-prose"><?php echo esc_html( $wif_visual_intro ); ?></p>
			</div>
			<div class="grid md:grid-cols-3 rw-gap-grid">
				<?php
				$strip = array(
					array( 'id' => $img_1_id, 'cap' => $img_1_cap ),
					array( 'id' => $img_2_id, 'cap' => $img_2_cap ),
					array( 'id' => $img_3_id, 'cap' => $img_3_cap ),
				);
				foreach ( $strip as $slot ) :
					$src = $slot['id'] ? wp_get_attachment_image_url( $slot['id'], 'large' ) : '';
					?>
					<figure class="m-0 flex flex-col rounded-2xl overflow-hidden border border-gray-100 bg-white shadow-[0_10px_40px_rgb(0,0,0,0.08)] hover:shadow-[0_14px_48px_rgb(0,0,0,0.1)] transition-shadow duration-300">
						<?php if ( $src ) : ?>
							<div class="aspect-[4/3] overflow-hidden bg-[var(--bg-subtle)]">
								<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $slot['cap'] ); ?>" class="w-full h-full object-cover" loading="lazy" width="800" height="600" />
							</div>
						<?php else : ?>
							<div class="restwell-image-placeholder aspect-[4/3] flex flex-col items-center justify-center gap-3 text-center px-4 py-8 text-[var(--muted-grey)]" role="img" aria-label="<?php echo esc_attr( $slot['cap'] ); ?>">
								<i class="ph-bold ph-image text-2xl opacity-60" aria-hidden="true"></i>
								<span class="text-sm font-semibold text-[var(--deep-teal)]/80"><?php echo esc_html( $slot['cap'] ); ?></span>
								<span class="text-xs leading-snug max-w-[14rem]"><?php esc_html_e( 'Set image ID in page fields to show this shot.', 'restwell-retreats' ); ?></span>
							</div>
						<?php endif; ?>
						<figcaption class="px-4 py-3.5 text-sm text-gray-600 leading-relaxed border-t border-gray-100 bg-[var(--bg-subtle)]/50"><?php echo esc_html( $slot['cap'] ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="rw-section-y bg-[var(--soft-sand)] scroll-mt-28" id="wif-funding" aria-labelledby="wif-funding-heading">
		<div class="container max-w-5xl">
			<div class="rw-stack rw-mb-section max-w-prose">
				<p class="section-label"><?php esc_html_e( 'Funding', 'restwell-retreats' ); ?></p>
				<h2 id="wif-funding-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php echo esc_html( $funding_heading ); ?></h2>
				<p class="text-gray-600 m-0 leading-relaxed max-w-prose"><?php echo esc_html( $funding_body ); ?></p>
			</div>
			<div class="wif-funding-routes grid md:grid-cols-3 rw-gap-grid mb-12 md:mb-14 items-stretch">
				<?php foreach ( $funding_routes as $route ) : ?>
					<article class="flex h-full min-h-0 flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 ease-out hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 motion-reduce:transition-none motion-reduce:hover:translate-y-0">
						<header class="shrink-0 px-6 pt-7 pb-4 md:px-7 md:pt-8">
							<div class="wif-icon-circle wif-icon-circle--feature h-14 w-14" aria-hidden="true">
								<i class="ph-bold ph-<?php echo esc_attr( $route['icon'] ); ?> text-lg"></i>
							</div>
							<h3 class="mt-5 text-lg font-serif leading-snug text-[var(--deep-teal)]"><?php echo esc_html( $route['title'] ); ?></h3>
						</header>
						<div class="flex min-h-0 flex-1 flex-col border-t border-gray-100/80 bg-[var(--bg-subtle)]/80 px-6 py-5 md:px-7">
							<ul class="m-0 list-none space-y-4 p-0 text-sm leading-relaxed text-gray-600 md:space-y-5">
								<?php foreach ( $route['bullets'] as $bullet ) : ?>
									<li class="grid grid-cols-[1.5rem_minmax(0,1fr)] items-start gap-x-3 text-left">
										<span class="wif-icon-circle wif-icon-circle--muted h-6 w-6" aria-hidden="true">
											<i class="ph-bold ph-check text-[11px]"></i>
										</span>
										<div class="min-w-0 pt-0.5"><?php echo esc_html( $bullet ); ?></div>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<footer class="shrink-0 border-t border-gray-100 bg-white px-6 py-5 md:px-7">
							<a class="btn btn-outline btn-sm w-full whitespace-normal text-center leading-snug" href="<?php echo esc_url( home_url( $route['cta_url'] ) ); ?>">
								<?php echo esc_html( $route['cta_label'] ); ?>
							</a>
						</footer>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="rounded-2xl border border-[var(--deep-teal)]/15 bg-white/80 p-8 md:p-10 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] max-w-2xl mx-auto">
				<p class="text-gray-600 leading-relaxed mb-6 m-0"><?php esc_html_e( 'Step-by-step timelines, Kent-specific context, and practical guidance on using assessments and personal budgets, all in one place.', 'restwell-retreats' ); ?></p>
				<a class="inline-flex items-center justify-center gap-2 bg-[var(--deep-teal)] text-white font-semibold px-8 py-3.5 rounded-2xl text-base hover:opacity-90 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] no-underline" href="<?php echo esc_url( home_url( '/resources/' ) ); ?>">
					<?php esc_html_e( 'Open the funding & support hub', 'restwell-retreats' ); ?>
					<i class="ph-bold ph-arrow-right text-sm" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</section>

	<section class="rw-section-y bg-white" aria-labelledby="wif-process-heading">
		<div class="container max-w-5xl">
			<div class="rw-stack rw-mb-section max-w-prose">
				<p class="section-label"><?php esc_html_e( 'How we work', 'restwell-retreats' ); ?></p>
				<h2 id="wif-process-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Clear, practical steps from first question to arrival', 'restwell-retreats' ); ?></h2>
				<p class="text-gray-600 m-0 leading-relaxed max-w-prose"><?php esc_html_e( 'You do not need everything decided before you contact us. We will help you work through fit, dates, and any support details.', 'restwell-retreats' ); ?></p>
			</div>
			<div class="grid md:grid-cols-3 rw-gap-grid items-stretch">
				<div class="flex h-full min-h-0 flex-col bg-[var(--bg-subtle)] rounded-2xl p-8 md:p-10 border border-gray-100">
					<p class="mb-5 shrink-0">
						<span class="sr-only"><?php esc_html_e( 'Step 1 of 3', 'restwell-retreats' ); ?></span>
						<span class="wif-process-step-num text-4xl md:text-[2.75rem] font-bold leading-none text-[var(--deep-teal)] font-serif select-none" aria-hidden="true">&#x2776;</span>
					</p>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3 shrink-0"><?php esc_html_e( 'Share your requirements', 'restwell-retreats' ); ?></h3>
					<p class="text-gray-600 leading-relaxed m-0 flex-1"><?php esc_html_e( 'Tell us your access needs, preferred dates, and who is travelling. You do not need to have everything figured out; just give us enough to tell you whether the property is likely to be a good fit.', 'restwell-retreats' ); ?></p>
				</div>
				<div class="flex h-full min-h-0 flex-col bg-[var(--bg-subtle)] rounded-2xl p-8 md:p-10 border border-gray-100">
					<p class="mb-5 shrink-0">
						<span class="sr-only"><?php esc_html_e( 'Step 2 of 3', 'restwell-retreats' ); ?></span>
						<span class="wif-process-step-num text-4xl md:text-[2.75rem] font-bold leading-none text-[var(--deep-teal)] font-serif select-none" aria-hidden="true">&#x2777;</span>
					</p>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3 shrink-0"><?php esc_html_e( 'Confirm suitability', 'restwell-retreats' ); ?></h3>
					<p class="text-gray-600 leading-relaxed m-0 flex-1"><?php esc_html_e( 'We answer practical questions directly (door widths, shower specifications, transfer space, equipment compatibility) so you can decide with confidence. If the property is not right for your needs, we will say so.', 'restwell-retreats' ); ?></p>
				</div>
				<div class="flex h-full min-h-0 flex-col bg-[var(--bg-subtle)] rounded-2xl p-8 md:p-10 border border-gray-100">
					<p class="mb-5 shrink-0">
						<span class="sr-only"><?php esc_html_e( 'Step 3 of 3', 'restwell-retreats' ); ?></span>
						<span class="wif-process-step-num text-4xl md:text-[2.75rem] font-bold leading-none text-[var(--deep-teal)] font-serif select-none" aria-hidden="true">&#x2778;</span>
					</p>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3 shrink-0"><?php esc_html_e( 'Book and prepare', 'restwell-retreats' ); ?></h3>
					<p class="text-gray-600 leading-relaxed m-0 flex-1"><?php esc_html_e( 'Once dates are agreed, we confirm everything in writing and send you a guest arrival guide covering check-in, the property layout, local area information, and anything specific to your stay.', 'restwell-retreats' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="rw-section-y bg-[var(--bg-subtle)]" aria-labelledby="wif-related-reading-heading">
		<div class="container max-w-5xl">
			<div class="rw-stack rw-mb-section max-w-prose">
				<p class="section-label"><?php esc_html_e( 'Related reading', 'restwell-retreats' ); ?></p>
				<h2 id="wif-related-reading-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Guides for families and referrers', 'restwell-retreats' ); ?></h2>
				<p class="text-gray-600 m-0 leading-relaxed max-w-prose"><?php esc_html_e( 'Local walks, funding context, and planning support: useful context once you have your next step in mind.', 'restwell-retreats' ); ?></p>
			</div>
			<div class="flex flex-wrap gap-3">
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/whitstable-area-guide/' ) ); ?>"><?php esc_html_e( 'Whitstable area guide', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/accessible-beaches-kent-coast/' ) ); ?>"><?php esc_html_e( 'Accessible beaches and coastal walks', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/revitalise-alternatives-accessible-holidays/' ) ); ?>"><?php esc_html_e( 'Revitalise alternatives', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/direct-payment-holiday-accommodation/' ) ); ?>"><?php esc_html_e( 'Direct payments for holiday stays', 'restwell-retreats' ); ?></a>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
