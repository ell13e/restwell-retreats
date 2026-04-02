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

$hero_image_id  = (int) get_post_meta( $pid, 'wif_hero_image_id', true );
$hero_image_src = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'full' ) : '';
$label          = (string) get_post_meta( $pid, 'wif_label', true ) ?: 'Who it is for';
$heading        = (string) get_post_meta( $pid, 'wif_heading', true ) ?: 'Who Restwell is for';
$intro          = (string) get_post_meta( $pid, 'wif_intro', true ) ?: 'Whether you are booking for yourself, someone you support, or a client, Restwell is designed to make planning straightforward and stays comfortable. Here is how it works for different people.';

$cards = array(
	array(
		'icon'  => 'fa-users',
		'title' => (string) get_post_meta( $pid, 'wif_family_title', true ) ?: 'For disabled individuals and families',
		'body'  => (string) get_post_meta( $pid, 'wif_family_body', true ) ?: 'A private holiday home on the Kent coast, built around the access features that actually matter. Wet room with wheel-in shower, level access throughout, wide doorways, and space for the equipment you use at home. You bring your own support — we provide the property. No clinical atmosphere, no shared spaces, no compromises on comfort. You can check our full accessibility specification before you enquire.',
	),
	array(
		'icon'  => 'fa-hand-holding-heart',
		'title' => (string) get_post_meta( $pid, 'wif_carers_title', true ) ?: 'For carers and support workers',
		'body'  => (string) get_post_meta( $pid, 'wif_carers_body', true ) ?: 'Bring your client or family member with confidence. The property has the core access features already in place — wet room, level thresholds, space for hoists — so you are not improvising when you arrive. There is a separate sleeping area for carers and the layout is practical for assisting with personal care. If you need to check whether the property suits a specific guest, get in touch and we will answer plainly.',
	),
	array(
		'icon'  => 'fa-clipboard-check',
		'title' => (string) get_post_meta( $pid, 'wif_ot_title', true ) ?: 'For occupational therapists and case managers',
		'body'  => (string) get_post_meta( $pid, 'wif_ot_body', true ) ?: 'We publish detailed accessibility information — dimensions, equipment, layout — so you can assess suitability against your client\'s needs before recommending a stay. If you need specifics we have not covered on the site, we will get them for you. We understand that recommending somewhere unsuitable reflects on you, so we would rather give you a straight answer than a sales pitch.',
	),
	array(
		'icon'  => 'fa-building-user',
		'title' => (string) get_post_meta( $pid, 'wif_commissioners_title', true ) ?: 'For commissioners and social care teams',
		'body'  => (string) get_post_meta( $pid, 'wif_commissioners_body', true ) ?: 'Restwell welcomes funded stays through direct payments, personal health budgets, and CHC pathways. We can provide the supporting documentation you need for referrals and funding approvals — including property specifications, risk assessment information, and confirmation of our connection to Continuity of Care Services, a CQC-registered domiciliary and complex care provider. If you need to justify the spend, our Funding & Support page outlines common funding routes.',
	),
);

$audience_details = array(
	array(
		'eyebrow'  => 'Guests and families',
		'heading'  => 'For disabled guests and family decision-makers',
		'body'     => 'Most families start with practical questions: whether daily routines will work, whether transfer space is realistic, and whether the location is genuinely manageable. Restwell is designed around those details, not just a marketing label.',
		'bullets'  => array(
			'Step-free circulation through the main living spaces.',
			'Accessible equipment information shared clearly before booking.',
			'A private self-catering layout so your stay runs on your schedule.',
		),
	),
	array(
		'eyebrow'  => 'Carers and support workers',
		'heading'  => 'For carers planning safe, lower-friction breaks',
		'body'     => 'Carers usually need confidence that the environment will not create extra workload on arrival. We focus on practical clarity early so there are fewer surprises when you get here.',
		'bullets'  => array(
			'Arrival and access details provided before check-in.',
			'Space configured for support-led stays, not just leisure stays.',
			'Clear pre-arrival communication to reduce day-one stress.',
		),
	),
	array(
		'eyebrow'  => 'OTs and case managers',
		'heading'  => 'For occupational therapists and case managers',
		'body'     => 'Professional referrals usually depend on evidence, not broad statements. We can share practical suitability details so clinical and care decisions are based on specifics.',
		'bullets'  => array(
			'Accessibility information suitable for pre-booking suitability checks.',
			'Clear communication with families, coordinators, and referrers.',
			'Referral conversations welcomed before any booking commitment.',
		),
	),
	array(
		'eyebrow'  => 'Commissioners',
		'heading'  => 'For commissioners and social care teams',
		'body'     => 'Commissioning decisions often need a balance of outcomes, budget, and confidence in delivery. Restwell can be considered as part of a short-break plan where a private adapted setting is appropriate.',
		'bullets'  => array(
			'Funded stay conversations supported with practical property details.',
			'Clear pathway for direct payments, personal budgets, or CHC-aligned plans.',
			'Transparent communication on suitability boundaries and next steps.',
		),
	),
);

$funding_heading = (string) get_post_meta( $pid, 'wif_funding_heading', true ) ?: 'How funding can work';
$funding_body    = (string) get_post_meta( $pid, 'wif_funding_body', true ) ?: 'Many guests use direct payments, personal budgets, or CHC pathways (subject to local rules and care plans). In Kent, families often begin with a carers or care-needs assessment through Kent County Council, then confirm what can be funded. Start on our Funding & Support page, then contact us to discuss your case.';

$cta_heading         = (string) get_post_meta( $pid, 'wif_cta_heading', true ) ?: 'Need to check suitability first?';
$cta_body            = (string) get_post_meta( $pid, 'wif_cta_body', true ) ?: 'Tell us what you need and we will answer honestly, with no pressure.';
$cta_primary_label   = (string) get_post_meta( $pid, 'wif_cta_primary_label', true ) ?: 'Read accessibility features';
$cta_primary_url     = (string) get_post_meta( $pid, 'wif_cta_primary_url', true ) ?: '/accessibility/';
$cta_secondary_label = (string) get_post_meta( $pid, 'wif_cta_secondary_label', true ) ?: 'Enquire about your dates';
$cta_secondary_url   = (string) get_post_meta( $pid, 'wif_cta_secondary_url', true ) ?: '/enquire/';
?>
<main class="flex-1" id="main-content">
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<section class="relative min-h-[32rem] md:min-h-[42rem] flex items-end overflow-hidden <?php echo $hero_image_src ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="wif-hero-heading">
		<?php if ( $hero_image_src ) : ?>
			<div class="absolute inset-0 bg-cover bg-center" style="background-image:url('<?php echo esc_url( $hero_image_src ); ?>');" aria-hidden="true"></div>
		<?php endif; ?>
		<div class="absolute inset-0 bg-[var(--deep-teal)]/75" aria-hidden="true"></div>
		<div class="relative container pb-14 md:pb-20">
			<div class="max-w-3xl">
				<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-4"><?php echo esc_html( $label ); ?></p>
				<h1 id="wif-hero-heading" class="text-white text-4xl md:text-5xl font-serif leading-tight mb-5"><?php echo esc_html( $heading ); ?></h1>
				<p class="text-[#F5EDE0] text-lg leading-relaxed max-w-prose"><?php echo esc_html( $intro ); ?></p>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-white" aria-labelledby="wif-audience-heading">
		<div class="container max-w-5xl">
			<p class="section-label mb-3">Audience</p>
			<h2 id="wif-audience-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4">Choose the path that matches your role.</h2>
			<p class="text-gray-600 mb-10 leading-relaxed max-w-prose">Each section below is written for how people actually plan these stays: guests and families, carers, and professionals.</p>
			<div class="grid sm:grid-cols-2 gap-6">
				<?php foreach ( $cards as $card ) : ?>
					<div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 transition-all duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:translate-y-0">
						<div class="w-10 h-10 rounded-full bg-[#A8D5D0]/40 text-[var(--deep-teal)] flex items-center justify-center mb-4" aria-hidden="true">
							<i class="fa-solid <?php echo esc_attr( $card['icon'] ); ?>"></i>
						</div>
						<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3"><?php echo esc_html( $card['title'] ); ?></h3>
						<p class="text-gray-600 leading-relaxed"><?php echo esc_html( $card['body'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-labelledby="wif-funding-heading">
		<div class="container max-w-4xl">
			<p class="section-label mb-3">Funding</p>
			<h2 id="wif-funding-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $funding_heading ); ?></h2>
			<p class="text-gray-600 leading-relaxed max-w-prose"><?php echo esc_html( $funding_body ); ?></p>
			<p class="text-gray-600 leading-relaxed max-w-prose mt-4">Most guests fund their stay through one of three routes: direct payments from their local authority, a personal health budget, or private funding. We are not a care provider ourselves — Restwell is a holiday let — but our parent organisation, Continuity of Care Services, is CQC-registered, and we can help you navigate the process if you are unsure where to start.</p>
			<p class="text-gray-600 leading-relaxed max-w-prose mt-4">See the property and local area: <a class="text-[var(--deep-teal)] underline hover:no-underline" href="<?php echo esc_url( home_url( '/whitstable-guide/' ) ); ?>">Whitstable Guide</a>.</p>
			<p class="text-gray-600 leading-relaxed max-w-prose mt-4">
				<?php esc_html_e( 'For practical examples, read our guides on', 'restwell-retreats' ); ?>
				<a class="underline decoration-[var(--deep-teal)]/30 underline-offset-4 hover:decoration-[var(--deep-teal)] text-[var(--deep-teal)]" href="<?php echo esc_url( home_url( '/direct-payment-holiday-accommodation/' ) ); ?>">
					<?php esc_html_e( 'using direct payments for holiday stays', 'restwell-retreats' ); ?>
				</a>
				<?php esc_html_e( 'and', 'restwell-retreats' ); ?>
				<a class="underline decoration-[var(--deep-teal)]/30 underline-offset-4 hover:decoration-[var(--deep-teal)] text-[var(--deep-teal)]" href="<?php echo esc_url( home_url( '/revitalise-alternatives-accessible-holidays/' ) ); ?>">
					<?php esc_html_e( 'alternatives after Revitalise', 'restwell-retreats' ); ?>
				</a>.
			</p>
			<div class="mt-8">
				<a class="inline-flex items-center gap-2 border-2 border-[var(--deep-teal)]/25 text-[var(--deep-teal)] font-semibold px-6 py-3 rounded-2xl text-sm hover:border-[var(--deep-teal)]/50 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] no-underline" href="<?php echo esc_url( home_url( '/resources/' ) ); ?>">
					Funding & support
					<i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-[var(--soft-sand)]" aria-labelledby="wif-detail-heading">
		<div class="container max-w-5xl">
			<p class="section-label mb-3">In more detail</p>
			<h2 id="wif-detail-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4">Different audiences, different decisions.</h2>
			<p class="text-gray-600 mb-10 leading-relaxed max-w-prose">If you are comparing options, these are the concerns we hear most often and how we support that decision process.</p>
			<div class="grid lg:grid-cols-2 gap-6">
				<?php foreach ( $audience_details as $detail ) : ?>
					<div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
						<p class="text-xs uppercase tracking-[0.15em] font-semibold text-[var(--warm-gold-text)] mb-2"><?php echo esc_html( $detail['eyebrow'] ); ?></p>
						<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3"><?php echo esc_html( $detail['heading'] ); ?></h3>
						<p class="text-gray-600 leading-relaxed mb-4"><?php echo esc_html( $detail['body'] ); ?></p>
						<ul class="space-y-2 text-sm text-gray-600 leading-relaxed">
							<?php foreach ( $detail['bullets'] as $item ) : ?>
								<li class="flex items-start gap-2">
									<span class="w-5 h-5 rounded-full bg-[#A8D5D0]/40 text-[var(--deep-teal)] flex items-center justify-center mt-0.5" aria-hidden="true">
										<i class="fa-solid fa-check text-[10px]"></i>
									</span>
									<span><?php echo esc_html( $item ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-white" aria-labelledby="wif-process-heading">
		<div class="container max-w-5xl">
			<p class="section-label mb-3">How we work</p>
			<h2 id="wif-process-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4">Clear, practical steps from first question to arrival.</h2>
			<p class="text-gray-600 mb-10 leading-relaxed max-w-prose">You do not need everything decided before you contact us. We will help you work through fit, dates, and any support details.</p>
			<div class="grid md:grid-cols-3 gap-6">
				<div class="bg-[var(--bg-subtle)] rounded-2xl p-6 border border-gray-100">
					<p class="text-xs font-semibold uppercase tracking-[0.15em] text-[var(--warm-gold-text)] mb-2">Step 1</p>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-2">Share your requirements</h3>
					<p class="text-gray-600 leading-relaxed">Tell us your access needs, preferred dates, and who is travelling. You do not need to have everything figured out — just give us enough to tell you whether the property is likely to be a good fit.</p>
				</div>
				<div class="bg-[var(--bg-subtle)] rounded-2xl p-6 border border-gray-100">
					<p class="text-xs font-semibold uppercase tracking-[0.15em] text-[var(--warm-gold-text)] mb-2">Step 2</p>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-2">Confirm suitability</h3>
					<p class="text-gray-600 leading-relaxed">We answer practical questions directly — door widths, shower specifications, transfer space, equipment compatibility — so you can decide with confidence. If the property is not right for your needs, we will say so.</p>
				</div>
				<div class="bg-[var(--bg-subtle)] rounded-2xl p-6 border border-gray-100">
					<p class="text-xs font-semibold uppercase tracking-[0.15em] text-[var(--warm-gold-text)] mb-2">Step 3</p>
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-2">Book and prepare</h3>
					<p class="text-gray-600 leading-relaxed">Once dates are agreed, we confirm everything in writing and send you a guest arrival guide covering check-in, the property layout, local area information, and anything specific to your stay.</p>
				</div>
			</div>
		</div>
	</section>

	<section class="py-14 md:py-16 bg-[var(--bg-subtle)]" aria-labelledby="wif-related-reading-heading">
		<div class="container max-w-5xl">
			<p class="section-label mb-3">Related reading</p>
			<h2 id="wif-related-reading-heading" class="text-2xl font-serif text-[var(--deep-teal)] mb-4">Useful guides for families and referrers.</h2>
			<div class="flex flex-wrap gap-3">
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/whitstable-area-guide/' ) ); ?>"><?php esc_html_e( 'Whitstable area guide', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/accessible-beaches-kent-coast/' ) ); ?>"><?php esc_html_e( 'Accessible beaches and coastal walks', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/revitalise-alternatives-accessible-holidays/' ) ); ?>"><?php esc_html_e( 'Revitalise alternatives', 'restwell-retreats' ); ?></a>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-[var(--soft-sand)]" aria-labelledby="wif-cta-heading">
		<div class="container max-w-3xl text-center">
			<p class="section-label mb-3">Next step</p>
			<h2 id="wif-cta-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $cta_heading ); ?></h2>
			<p class="text-gray-600 leading-relaxed max-w-prose mx-auto mb-8"><?php echo esc_html( $cta_body ); ?></p>
			<div class="flex flex-wrap justify-center gap-4">
				<a class="inline-flex items-center gap-2 bg-[var(--deep-teal)] text-white font-semibold px-6 py-3 rounded-2xl text-sm hover:opacity-90 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] no-underline" href="<?php echo esc_url( home_url( $cta_primary_url ) ); ?>">
					<?php echo esc_html( $cta_primary_label ); ?>
				</a>
				<a class="inline-flex items-center gap-2 border-2 border-[var(--deep-teal)]/25 text-[var(--deep-teal)] font-semibold px-6 py-3 rounded-2xl text-sm hover:border-[var(--deep-teal)]/50 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] no-underline" href="<?php echo esc_url( home_url( $cta_secondary_url ) ); ?>">
					<?php echo esc_html( $cta_secondary_label ); ?>
				</a>
				<a class="inline-flex items-center gap-2 border-2 border-[var(--deep-teal)]/25 text-[var(--deep-teal)] font-semibold px-6 py-3 rounded-2xl text-sm hover:border-[var(--deep-teal)]/50 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] no-underline" href="<?php echo esc_url( home_url( '/whitstable-area-guide/' ) ); ?>">
					<?php esc_html_e( 'See local guide', 'restwell-retreats' ); ?>
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
