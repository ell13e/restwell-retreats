<?php
/**
 * Template Name: Contact
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

$hero_image_id  = (int) get_post_meta( $pid, 'contact_hero_image_id', true );
$hero_image_src = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'full' ) : '';
$label          = (string) get_post_meta( $pid, 'contact_label', true ) ?: 'Contact';
$heading        = (string) get_post_meta( $pid, 'contact_heading', true ) ?: 'Get in touch.';
$intro          = (string) get_post_meta( $pid, 'contact_intro', true ) ?: 'Ask a question, check dates, or talk through accessibility requirements before you book.';

$phone = (string) get_post_meta( $pid, 'contact_phone', true ) ?: (string) get_option( 'restwell_phone_number', '01622 809881' );
$email = (string) get_post_meta( $pid, 'contact_email', true ) ?: 'hello@restwellretreats.co.uk';
$address = (string) get_post_meta( $pid, 'contact_address', true ) ?: "Restwell Retreats\n101 Russell Drive\nWhitstable\nKent\nCT5 2RQ";

$hours_heading = (string) get_post_meta( $pid, 'contact_hours_heading', true ) ?: 'Response times';
$hours_body    = (string) get_post_meta( $pid, 'contact_hours_body', true ) ?: "We aim to reply to all enquiries within 24 hours.\nIf your enquiry is urgent, please call.";

$prof_heading = (string) get_post_meta( $pid, 'contact_prof_heading', true ) ?: 'For professionals';
$prof_body    = (string) get_post_meta( $pid, 'contact_prof_body', true ) ?: 'If you are an occupational therapist, case manager, or commissioner, we are happy to provide property specifications, access measurements, and supporting information for referrals or funding applications. We prefer to give you specifics rather than marketing material.';

$cta_heading = (string) get_post_meta( $pid, 'contact_cta_heading', true ) ?: 'Prefer the full enquiry form?';
$cta_body    = (string) get_post_meta( $pid, 'contact_cta_body', true ) ?: 'Use our enquiry form to share dates and requirements in one place.';
$cta_label   = (string) get_post_meta( $pid, 'contact_cta_label', true ) ?: 'Go to enquiry form';
$cta_url     = (string) get_post_meta( $pid, 'contact_cta_url', true ) ?: '/enquire/';
?>
<main class="flex-1" id="main-content">
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<section class="relative min-h-[30rem] md:min-h-[38rem] flex items-end overflow-hidden <?php echo $hero_image_src ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="contact-hero-heading">
		<?php if ( $hero_image_src ) : ?>
			<div class="absolute inset-0 bg-cover bg-center" style="background-image:url('<?php echo esc_url( $hero_image_src ); ?>');" aria-hidden="true"></div>
		<?php endif; ?>
		<div class="absolute inset-0 bg-[var(--deep-teal)]/75" aria-hidden="true"></div>
		<div class="relative container pb-14 md:pb-20">
			<div class="max-w-3xl">
				<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-4"><?php echo esc_html( $label ); ?></p>
				<h1 id="contact-hero-heading" class="text-white text-4xl md:text-5xl font-serif leading-tight mb-5"><?php echo esc_html( $heading ); ?></h1>
				<p class="text-[#F5EDE0] text-lg leading-relaxed max-w-prose"><?php echo esc_html( $intro ); ?></p>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-white">
		<div class="container max-w-5xl">
			<div class="grid md:grid-cols-2 gap-6">
				<div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
					<h2 class="text-2xl font-serif text-[var(--deep-teal)] mb-4">Direct contact</h2>
					<div class="space-y-4 text-gray-600">
						<p><strong class="text-[var(--deep-teal)]">Phone:</strong> <a class="text-[var(--deep-teal)] hover:underline" href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
						<p><strong class="text-[var(--deep-teal)]">Email:</strong> <a class="text-[var(--deep-teal)] hover:underline" href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
						<div>
							<strong class="text-[var(--deep-teal)]">Address:</strong>
							<div class="mt-1 leading-relaxed whitespace-pre-line"><?php echo esc_html( $address ); ?></div>
						</div>
					</div>
				</div>

				<div class="bg-[var(--bg-subtle)] rounded-2xl p-6 border border-gray-100">
					<h2 class="text-2xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $hours_heading ); ?></h2>
					<div class="space-y-3 text-gray-600 leading-relaxed">
						<?php foreach ( preg_split( "/\\r\\n|\\r|\\n/", (string) $hours_body ) as $line ) : ?>
							<?php if ( trim( $line ) !== '' ) : ?>
								<p><?php echo esc_html( $line ); ?></p>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<hr class="my-6 border-gray-200">
					<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-3"><?php echo esc_html( $prof_heading ); ?></h3>
					<p class="text-gray-600 leading-relaxed"><?php echo esc_html( $prof_body ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="py-16 md:py-24 bg-[var(--soft-sand)]" aria-labelledby="contact-cta-heading">
		<div class="container max-w-3xl text-center">
			<p class="section-label mb-3">Enquiry</p>
			<h2 id="contact-cta-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $cta_heading ); ?></h2>
			<p class="text-gray-600 leading-relaxed max-w-prose mx-auto mb-8"><?php echo esc_html( $cta_body ); ?></p>
			<a class="inline-flex items-center gap-2 bg-[var(--deep-teal)] text-white font-semibold px-6 py-3 rounded-2xl text-sm hover:opacity-90 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] no-underline" href="<?php echo esc_url( home_url( $cta_url ) ); ?>">
				<?php echo esc_html( $cta_label ); ?>
				<i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
			</a>
		</div>
	</section>
</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
