<?php
/**
 * Template Name: Resources
 * Funding & support page: Kent funding, grants, CHC, complaints, key contacts.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

// Hero
$res_hero_image_id  = (int) get_post_meta( $pid, 'res_hero_image_id', true );
$res_hero_image_src = $res_hero_image_id ? wp_get_attachment_image_url( $res_hero_image_id, 'full' ) : '';
$res_label          = get_post_meta( $pid, 'res_label', true ) ?: 'Funding & support';
$res_heading        = get_post_meta( $pid, 'res_heading', true ) ?: 'We\'ll help you find a way';
$res_intro          = get_post_meta( $pid, 'res_intro', true ) ?: 'A straightforward guide to funding your stay and finding the right support in Kent.';

// Content sections
$res_fund_heading       = get_post_meta( $pid, 'res_fund_heading', true ) ?: 'How to fund your stay';
$res_fund_body          = get_post_meta( $pid, 'res_fund_body', true ) ?: '';
$res_grants_heading     = get_post_meta( $pid, 'res_grants_heading', true ) ?: 'Grants and charities';
$res_grants_body        = get_post_meta( $pid, 'res_grants_body', true ) ?: '';
$res_chc_heading        = get_post_meta( $pid, 'res_chc_heading', true ) ?: 'NHS Continuing Healthcare (CHC)';
$res_chc_body           = get_post_meta( $pid, 'res_chc_body', true ) ?: '';
$res_complaints_heading = get_post_meta( $pid, 'res_complaints_heading', true ) ?: 'Complaints & appeals';
$res_complaints_body    = get_post_meta( $pid, 'res_complaints_body', true ) ?: '';
$res_contacts_heading   = get_post_meta( $pid, 'res_contacts_heading', true ) ?: 'Key Kent contacts';
$res_contacts_body      = get_post_meta( $pid, 'res_contacts_body', true ) ?: '';

// CTA
$res_cta_heading = get_post_meta( $pid, 'res_cta_heading', true ) ?: 'Still have questions?';
$res_cta_body    = get_post_meta( $pid, 'res_cta_body', true ) ?: 'We can point you in the right direction or talk through your options.';
$res_cta_btn     = get_post_meta( $pid, 'res_cta_btn', true ) ?: 'Get in touch';
$res_cta_url     = esc_url( get_post_meta( $pid, 'res_cta_url', true ) ?: home_url( '/enquire/' ) );

// Default content when meta is empty.
if ( $res_fund_body === '' ) {
	$res_fund_body = '<ul class="space-y-3">'
		. '<li><strong>Carers Assessment</strong> — Kent County Council: <a href="tel:03000416161">03000 41 61 61</a> or <a href="https://kent.connecttosupport.org" target="_blank" rel="noopener noreferrer">Kent Connect to Support<span class="sr-only"> (opens in new tab)</span></a> (self-referral, reviewed in 2 working days).</li>'
		. '<li><strong>Care Needs Assessment</strong> — KCC Adult Social Care: <a href="tel:03000418181">03000 41 81 81</a> or online form (free, means-tested).</li>'
		. '<li><strong>Paying for Care</strong> — <a href="https://www.kent.gov.uk/social-care-and-health/adult-social-care/paying-for-care" target="_blank" rel="noopener noreferrer">kent.gov.uk — Paying for care<span class="sr-only"> (opens in new tab)</span></a>.</li>'
		. '<li><strong>Direct Payments</strong> — <a href="https://www.kent.gov.uk/social-care-and-health/adult-social-care/arranging-your-own-care/direct-payments-self-directed-support" target="_blank" rel="noopener noreferrer">kent.gov.uk — Direct payments<span class="sr-only"> (opens in new tab)</span></a> (use funding for PAs or respite).</li>'
		. '</ul>';
}
if ( $res_grants_body === '' ) {
	$res_grants_body = '<p class="mb-4">Local and national organisations that may help with grants or low-cost respite:</p>'
		. '<ul class="space-y-3">'
		. '<li><strong>Carers Trust</strong> — National <a href="tel:03007729600">0300 772 9600</a>, <a href="https://carers.org" target="_blank" rel="noopener noreferrer">carers.org<span class="sr-only"> (opens in new tab)</span></a>. Local hubs: Care for the Carers (East Kent) <a href="tel:01323738390">01323 738390</a>; Carers\' Support East Kent <a href="tel:01304619919">01304 619919</a>; Crossroads Care East Kent <a href="tel:01227781150">01227 781150</a>; Crossroads Care West Kent <a href="tel:01622814400">01622 814400</a>.</li>'
		. '<li><strong>Turn2us</strong> — Grant finder by postcode: <a href="https://www.turn2us.org.uk" target="_blank" rel="noopener noreferrer">turn2us.org.uk<span class="sr-only"> (opens in new tab)</span></a>.</li>'
		. '<li><strong>Respite Association</strong> — Grants and volunteer host links.</li>'
		. '<li><strong>Age UK Kent</strong> — Volunteer befriending and short breaks.</li>'
		. '</ul>';
}
if ( $res_chc_body === '' ) {
	$res_chc_body = '<p>Fully funded (non-means-tested) NHS package for adults with a primary health need. Arranged by Kent &amp; Medway ICB. Fast-track available for unstable/terminal cases. Contact: <a href="mailto:chc@kmicb.nhs.uk">chc@kmicb.nhs.uk</a>. For appeal support: <a href="https://www.scope.org.uk/advice-and-support/appeal-an-nhs-continuing-healthcare-chc-decision/" target="_blank" rel="noopener noreferrer">Scope<span class="sr-only"> (opens in new tab)</span></a>, <a href="https://www.beaconchc.co.uk" target="_blank" rel="noopener noreferrer">Beacon CHC<span class="sr-only"> (opens in new tab)</span></a>.</p>';
}
if ( $res_complaints_body === '' ) {
	$res_complaints_body = '<p><strong>KCC</strong> — Complain to Kent County Council; response within 20 working days. Escalate to <a href="https://www.ombudsman.org.uk" target="_blank" rel="noopener noreferrer">Local Government Ombudsman<span class="sr-only"> (opens in new tab)</span></a> (free).</p>'
		. '<p class="mt-3"><strong>NHS CHC</strong> — Contact Kent &amp; Medway ICB (<a href="mailto:chc@kmicb.nhs.uk">chc@kmicb.nhs.uk</a>). Then <a href="https://www.ombudsman.org.uk" target="_blank" rel="noopener noreferrer">Parliamentary &amp; Health Service Ombudsman (PHSO)<span class="sr-only"> (opens in new tab)</span></a>.</p>';
}
if ( $res_contacts_body === '' ) {
	$res_contacts_body = '<div class="overflow-x-auto -mx-1">'
		. '<table class="w-full text-left text-sm">'
		. '<thead><tr class="border-b border-gray-200"><th class="pb-3 pr-6 font-semibold text-[var(--deep-teal)]">Organisation</th><th class="pb-3 font-semibold text-[var(--deep-teal)]">Contact</th></tr></thead>'
		. '<tbody class="divide-y divide-gray-100">'
		. '<tr><td class="py-3 pr-6 text-gray-700">KCC Adult Social Care</td><td class="py-3"><a href="tel:03000416161" class="text-[var(--deep-teal)] hover:underline">03000 41 61 61</a></td></tr>'
		. '<tr><td class="py-3 pr-6 text-gray-700">KCC Care Needs Assessment</td><td class="py-3"><a href="tel:03000418181" class="text-[var(--deep-teal)] hover:underline">03000 41 81 81</a></td></tr>'
		. '<tr><td class="py-3 pr-6 text-gray-700">Kent &amp; Medway ICB (CHC)</td><td class="py-3"><a href="mailto:chc@kmicb.nhs.uk" class="text-[var(--deep-teal)] hover:underline">chc@kmicb.nhs.uk</a></td></tr>'
		. '<tr><td class="py-3 pr-6 text-gray-700">Care for the Carers (CFTC)</td><td class="py-3"><a href="tel:01323738390" class="text-[var(--deep-teal)] hover:underline">01323 738390</a></td></tr>'
		. '<tr><td class="py-3 pr-6 text-gray-700">Carers\' Support East Kent</td><td class="py-3"><a href="tel:01304619919" class="text-[var(--deep-teal)] hover:underline">01304 619919</a></td></tr>'
		. '<tr><td class="py-3 pr-6 text-gray-700">Crossroads Care East / West Kent</td><td class="py-3"><a href="tel:01227781150" class="text-[var(--deep-teal)] hover:underline">01227 781150</a> / <a href="tel:01622814400" class="text-[var(--deep-teal)] hover:underline">01622 814400</a></td></tr>'
		. '<tr><td class="py-3 pr-6 text-gray-700">Carers Trust Central</td><td class="py-3"><a href="tel:03007729600" class="text-[var(--deep-teal)] hover:underline">0300 772 9600</a></td></tr>'
		. '<tr><td class="py-3 pr-6 text-gray-700">Turn2us (grant finder)</td><td class="py-3"><a href="https://www.turn2us.org.uk" target="_blank" rel="noopener noreferrer" class="text-[var(--deep-teal)] hover:underline">turn2us.org.uk<span class="sr-only"> (opens in new tab)</span></a></td></tr>'
		. '</tbody></table></div>';
}

// Build nav sections list for sidebar and content loop.
$sections = array(
	array( 'id' => 'res-funding',    'label' => 'How to fund your stay',       'heading' => $res_fund_heading,       'body' => $res_fund_body,       'eyebrow' => 'Self-funding & council support' ),
	array( 'id' => 'res-grants',     'label' => 'Grants and charities',        'heading' => $res_grants_heading,     'body' => $res_grants_body,     'eyebrow' => 'Additional support' ),
	array( 'id' => 'res-chc',        'label' => 'NHS Continuing Healthcare',   'heading' => $res_chc_heading,        'body' => $res_chc_body,        'eyebrow' => 'NHS funded care' ),
	array( 'id' => 'res-complaints', 'label' => 'Complaints & appeals',        'heading' => $res_complaints_heading, 'body' => $res_complaints_body, 'eyebrow' => 'If things go wrong' ),
	array( 'id' => 'res-contacts',   'label' => 'Key contacts',                'heading' => $res_contacts_heading,   'body' => $res_contacts_body,   'eyebrow' => 'Quick reference',  'is_contacts' => true ),
);
?>
<main class="flex-1" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<!-- Hero -->
	<section class="hero relative flex items-end overflow-hidden min-h-[32rem] <?php echo $res_hero_image_src ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="page-hero-heading">
		<?php if ( $res_hero_image_src ) : ?>
			<img src="<?php echo esc_url( $res_hero_image_src ); ?>" alt="" class="absolute inset-0 w-full h-full object-cover -z-10" loading="eager" />
		<?php endif; ?>
		<div class="absolute inset-0 bg-black/30 -z-[5]" aria-hidden="true"></div>
		<div class="absolute inset-0 bg-gradient-to-t from-[var(--deep-teal)]/85 via-[var(--deep-teal)]/45 to-transparent -z-[5]" aria-hidden="true"></div>
		<div class="relative z-10 container pb-16 md:pb-24 pt-32">
			<div class="max-w-2xl">
				<?php if ( $res_label !== '' ) : ?>
					<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-4 font-sans"><?php echo esc_html( $res_label ); ?></p>
				<?php endif; ?>
				<h1 id="page-hero-heading" class="text-white text-4xl md:text-5xl lg:text-6xl mb-6 leading-tight font-serif"><?php echo esc_html( $res_heading ); ?></h1>
				<?php if ( $res_intro !== '' ) : ?>
					<p class="text-[#F5EDE0] text-lg md:text-xl leading-relaxed max-w-prose drop-shadow-[0_1px_2px_rgba(0,0,0,0.3)]"><?php echo esc_html( $res_intro ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Mobile jump navigation (hidden on desktop — sidebar handles that) -->
	<div class="md:hidden bg-white border-b border-gray-100 py-4 overflow-x-auto" aria-label="Jump to section">
		<div class="container">
			<p class="text-xs font-semibold uppercase tracking-[0.15em] text-[var(--muted-grey)] mb-2">On this page</p>
			<div class="flex gap-2 min-w-max">
				<?php foreach ( $sections as $section ) : ?>
					<a href="#<?php echo esc_attr( $section['id'] ); ?>"
					   class="inline-flex items-center text-sm font-medium text-[var(--deep-teal)] bg-[var(--bg-subtle)] border border-[var(--deep-teal)]/15 px-4 py-2 rounded-full whitespace-nowrap no-underline hover:bg-[var(--deep-teal)]/10 transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)]">
						<?php echo esc_html( $section['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- Content with sidebar -->
	<section class="py-16 md:py-24 bg-white" aria-label="Funding and support information">
		<div class="container max-w-6xl">
			<div class="grid md:grid-cols-[220px_1fr] gap-12 lg:gap-16 items-start">

				<!-- Sticky sidebar navigation -->
				<nav class="hidden md:block sticky top-24 self-start" aria-label="Page sections">
					<p class="text-xs font-semibold uppercase tracking-[0.15em] text-[var(--muted-grey)] mb-4">On this page</p>
					<ul class="space-y-1">
						<?php foreach ( $sections as $section ) : ?>
							<li>
								<a href="#<?php echo esc_attr( $section['id'] ); ?>"
								   class="block text-sm text-[var(--deep-teal)] py-1.5 px-3 rounded-lg hover:bg-[var(--bg-subtle)] transition-colors duration-150 no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)]">
									<?php echo esc_html( $section['label'] ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>

				<!-- Main content -->
				<div class="space-y-16 md:space-y-20 min-w-0">
					<?php foreach ( $sections as $i => $section ) : ?>
						<div id="<?php echo esc_attr( $section['id'] ); ?>" class="scroll-mt-24">
							<p class="section-label mb-3"><?php echo esc_html( $section['eyebrow'] ); ?></p>
							<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] mb-6"><?php echo esc_html( $section['heading'] ); ?></h2>
							<?php if ( ! empty( $section['is_contacts'] ) ) : ?>
								<div class="bg-[var(--bg-subtle)] rounded-2xl p-6 md:p-8 border border-gray-100">
									<div class="text-gray-600 leading-relaxed prose prose-sm max-w-none prose-a:text-[var(--deep-teal)] prose-a:underline hover:prose-a:no-underline prose-strong:text-[var(--deep-teal)]">
										<?php echo wp_kses_post( $section['body'] ); ?>
									</div>
								</div>
							<?php else : ?>
								<div class="text-gray-600 leading-relaxed prose prose-sm max-w-none prose-a:text-[var(--deep-teal)] prose-a:underline hover:prose-a:no-underline prose-strong:text-[var(--deep-teal)] prose-li:my-1.5">
									<?php echo wp_kses_post( $section['body'] ); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="py-16 md:py-20 bg-[var(--deep-teal)] text-center" aria-labelledby="res-cta-heading">
		<div class="container max-w-2xl">
			<h2 id="res-cta-heading" class="text-3xl font-serif text-white mb-4"><?php echo esc_html( $res_cta_heading ); ?></h2>
			<?php if ( $res_cta_body !== '' ) : ?>
				<p class="text-white/90 text-lg mb-8 max-w-md mx-auto leading-relaxed"><?php echo esc_html( $res_cta_body ); ?></p>
			<?php endif; ?>
			<a href="<?php echo esc_url( $res_cta_url ); ?>" class="btn btn-gold">
				<?php echo esc_html( $res_cta_btn ); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
	</section>

</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
