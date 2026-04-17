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

$hero_image_id = (int) get_post_meta( $pid, 'contact_hero_image_id', true );
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
$cta_body    = (string) get_post_meta( $pid, 'contact_cta_body', true ) ?: "Use our enquiry form; it's the quickest way to share your dates, requirements, and any questions.";
$cta_label   = (string) get_post_meta( $pid, 'contact_cta_label', true ) ?: 'Go to enquiry form';
$cta_url     = (string) get_post_meta( $pid, 'contact_cta_url', true ) ?: '/enquire/';

$social_profiles = function_exists( 'restwell_get_social_profile_urls' ) ? restwell_get_social_profile_urls() : array();
?>
<main class="flex-1" id="main-content">
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<?php
	set_query_var(
		'args',
		array(
			'heading_id'       => 'contact-hero-heading',
			'label'              => $label,
			'heading'            => $heading,
			'intro'              => $intro,
			'media_id'           => $hero_image_id,
			'image_alt'          => $heading,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<section class="rw-section-y bg-white">
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
						<?php if ( ! empty( $social_profiles ) ) : ?>
							<div class="pt-2 border-t border-gray-100">
								<p class="m-0 mb-2"><strong class="text-[var(--deep-teal)]"><?php esc_html_e( 'Social', 'restwell-retreats' ); ?></strong></p>
								<ul class="m-0 flex flex-wrap gap-x-4 gap-y-2 list-none p-0 text-sm">
									<?php if ( ! empty( $social_profiles['facebook'] ) ) : ?>
										<li class="m-0">
											<a class="text-[var(--deep-teal)] hover:underline" href="<?php echo esc_url( $social_profiles['facebook'] ); ?>" rel="noopener noreferrer" target="_blank" data-cta="contact-social-facebook"><?php esc_html_e( 'Facebook', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a>
										</li>
									<?php endif; ?>
									<?php if ( ! empty( $social_profiles['instagram'] ) ) : ?>
										<li class="m-0">
											<a class="text-[var(--deep-teal)] hover:underline" href="<?php echo esc_url( $social_profiles['instagram'] ); ?>" rel="noopener noreferrer" target="_blank" data-cta="contact-social-instagram"><?php esc_html_e( 'Instagram', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a>
										</li>
									<?php endif; ?>
									<?php if ( ! empty( $social_profiles['linkedin'] ) ) : ?>
										<li class="m-0">
											<a class="text-[var(--deep-teal)] hover:underline" href="<?php echo esc_url( $social_profiles['linkedin'] ); ?>" rel="noopener noreferrer" target="_blank" data-cta="contact-social-linkedin"><?php esc_html_e( 'LinkedIn', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a>
										</li>
									<?php endif; ?>
								</ul>
							</div>
						<?php endif; ?>
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

	<section class="rw-section-y bg-[var(--soft-sand)]" aria-labelledby="contact-cta-heading">
		<div class="container max-w-3xl text-center">
			<div class="rw-section-head rw-section-head--center rw-section-head--tight mx-auto">
			<p class="section-label">Enquiry</p>
			<h2 id="contact-cta-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php echo esc_html( $cta_heading ); ?></h2>
			</div>
			<p class="text-gray-600 leading-relaxed max-w-prose mx-auto mb-8 mt-0"><?php echo esc_html( $cta_body ); ?></p>
			<a class="inline-flex items-center gap-2 bg-[var(--deep-teal)] text-white font-semibold px-6 py-3 rounded-2xl text-sm hover:opacity-90 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] no-underline" href="<?php echo esc_url( home_url( $cta_url ) ); ?>">
				<?php echo esc_html( $cta_label ); ?>
				<i class="ph-bold ph-arrow-right text-xs" aria-hidden="true"></i>
			</a>
		</div>
	</section>
</main>
<?php get_footer(); ?>
