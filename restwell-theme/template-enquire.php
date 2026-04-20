<?php
/**
 * Template Name: Enquire
 * Enquiry page with multi-step form and a compact sidebar (phone and email).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

// Hero
$enq_hero_image_id = (int) get_post_meta( $pid, 'enq_hero_image_id', true );
$enq_label          = get_post_meta( $pid, 'enq_label', true ) ?: 'Get in touch';
$enq_heading        = get_post_meta( $pid, 'enq_heading', true ) ?: 'Start a conversation.';
$enq_intro          = get_post_meta( $pid, 'enq_intro', true ) ?: 'Whether you want to book an accessible holiday cottage in Kent or simply ask about a bathroom measurement, we are here to help. This is not a booking commitment: it is the start of a conversation. No pressure, no hard sell.';

// Form copy
$enq_form_heading        = get_post_meta( $pid, 'enq_form_heading', true ) ?: 'Request a call about your stay';
$enq_success_heading     = get_post_meta( $pid, 'enq_success_heading', true ) ?: 'Thank you for your enquiry';
$enq_success_body        = get_post_meta( $pid, 'enq_success_body', true ) ?: "We've received your enquiry. We'll be in touch to confirm availability and next steps.";
$enq_success_urgent_body = get_post_meta( $pid, 'enq_success_urgent_body', true ) ?: "We've received your urgent enquiry. We'll prioritise your request and be in touch as soon as we can.";

// Sidebar
$enq_contact_heading = get_post_meta( $pid, 'enq_contact_heading', true ) ?: __( 'Other ways to reach us', 'restwell-retreats' );
$enq_email           = get_post_meta( $pid, 'enq_email', true ) ?: 'hello@restwellretreats.co.uk';
$enq_phone           = get_post_meta( $pid, 'enq_phone', true ) ?: (string) get_option( 'restwell_phone_number', '01622 809881' );

$sent_raw    = isset( $_GET['sent'] ) ? sanitize_text_field( wp_unslash( $_GET['sent'] ) ) : '';
$sent        = '1' === $sent_raw;
$urgent_raw  = isset( $_GET['urgent'] ) ? sanitize_text_field( wp_unslash( $_GET['urgent'] ) ) : '';
$urgent      = $sent && '1' === $urgent_raw;
$mail_warn   = $sent && isset( $_GET['mail_warn'] ) && '1' === sanitize_text_field( wp_unslash( $_GET['mail_warn'] ) );
$current_url = get_permalink( $pid );
$resources_url = home_url( '/resources/' );

$enq_errors = array();
$enq_f     = array(
	'enq_name'               => '',
	'enq_email'              => '',
	'enq_phone'              => '',
	'enq_message'            => '',
	'enq_date_from'          => '',
	'enq_date_to'            => '',
	'enq_guests'             => '',
	'enq_care'               => '',
	'enq_accessibility'      => '',
	'enq_funding'            => '',
	'enq_urgent'             => '',
	'enq_contact_preference' => '',
	'enq_preferred_time'     => '',
);
$enq_flash_key = isset( $_GET['enq_flash'] ) ? sanitize_text_field( wp_unslash( $_GET['enq_flash'] ) ) : '';
if ( $enq_flash_key ) {
	$flash = get_transient( 'restwell_enq_flash_' . $enq_flash_key );
	if ( is_array( $flash ) ) {
		$enq_errors = isset( $flash['errors'] ) && is_array( $flash['errors'] ) ? $flash['errors'] : array();
		if ( ! empty( $flash['fields'] ) && is_array( $flash['fields'] ) ) {
			$enq_f = array_merge( $enq_f, $flash['fields'] );
		}
		delete_transient( 'restwell_enq_flash_' . $enq_flash_key );
	}
}

$date_min = current_time( 'Y-m-d' );

$sidebar_card_base    = 'rw-surface-card p-7';
$sidebar_card_heading = 'text-lg font-serif text-[var(--deep-teal)] mb-3';

// Common input classes
// focus:outline-none is intentionally removed - the global :focus-visible rule
// provides a 3px deep-teal outline for keyboard users (2.4.7 Focus Visible, WCAG AA).
// focus-visible:outline-none would suppress it for mouse clicks only, but Tailwind
// v3 generates a :focus selector here, so we let the CSS layer handle focus-visible.
$input_class = 'w-full px-4 py-3 rounded-xl border border-[#B9C7CB] bg-white text-[#1B4D5C] text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--deep-teal)] focus:ring-offset-2';
$label_class = 'block text-sm font-semibold text-[#1B4D5C] mb-1.5';
?>
<main class="flex-1" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<?php
	set_query_var(
		'args',
		array(
			'heading_id'  => 'page-hero-heading',
			'label'       => $enq_label,
			'heading'     => $enq_heading,
			'intro'       => $enq_intro,
			'media_id'    => $enq_hero_image_id,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<!-- Form + sidebar -->
	<section class="rw-section-y bg-[var(--bg-subtle)]" aria-labelledby="enq-form-heading">
		<div class="container max-w-5xl">
			<div class="grid md:grid-cols-5 gap-12">

				<!-- Form column -->
				<div class="md:col-span-3">
				<?php if ( $sent ) : ?>
					<!-- Success state -->
					<div id="enquiry-result" class="enquiry-result rw-surface-card overflow-hidden scroll-mt-[clamp(5rem,14vh,8rem)]" role="status" aria-live="polite" tabindex="-1">
						<div class="p-8 md:p-10">
							<!-- Icon + heading -->
							<div class="flex items-start gap-5 mb-6">
								<div class="shrink-0 w-14 h-14 bg-[#A8D5D0]/25 rounded-full flex items-center justify-center text-[var(--deep-teal)]" aria-hidden="true">
									<i class="ph-bold ph-check text-xl"></i>
								</div>
								<div>
									<h2 id="enq-form-heading" class="text-2xl font-serif text-[var(--deep-teal)] leading-snug mb-1"><?php echo esc_html( $enq_success_heading ); ?></h2>
									<p class="rw-copy-body leading-relaxed"><?php echo esc_html( $urgent ? $enq_success_urgent_body : $enq_success_body ); ?></p>
									<?php if ( $mail_warn ) : ?>
										<p class="mt-4 text-sm text-[#92400e] bg-[#fef3c7] border border-[#fcd34d] rounded-xl px-4 py-3 leading-relaxed">
											<?php esc_html_e( 'We saved your enquiry, but our automatic email to the team may not have gone through. If you do not hear from us within 48 hours, please call or email us so we can pick it up.', 'restwell-retreats' ); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>
							<!-- What happens next -->
							<div class="border-t border-[#E8DFD0] pt-6">
								<p class="text-xs font-semibold text-[var(--warm-gold-text)] uppercase tracking-wider mb-4">What happens next</p>
								<ol class="enquiry-next-steps space-y-4 text-sm rw-copy-body list-none p-0 m-0">
									<li class="flex gap-3 items-center">
										<span class="enquiry-step-num shrink-0 w-8 h-8 rounded-full bg-[var(--deep-teal)]/10 text-[var(--deep-teal)] text-sm font-serif font-semibold inline-flex items-center justify-center leading-none" aria-hidden="true">1</span>
										<span class="min-w-0 leading-relaxed">We&rsquo;ll review your enquiry and check availability for your dates.</span>
									</li>
									<li class="flex gap-3 items-center">
										<span class="enquiry-step-num shrink-0 w-8 h-8 rounded-full bg-[var(--deep-teal)]/10 text-[var(--deep-teal)] text-sm font-serif font-semibold inline-flex items-center justify-center leading-none" aria-hidden="true">2</span>
										<span class="min-w-0 leading-relaxed">We&rsquo;ll contact you by your preferred method to confirm details and answer any questions.</span>
									</li>
									<li class="flex gap-3 items-center">
										<span class="enquiry-step-num shrink-0 w-8 h-8 rounded-full bg-[var(--deep-teal)]/10 text-[var(--deep-teal)] text-sm font-serif font-semibold inline-flex items-center justify-center leading-none" aria-hidden="true">3</span>
										<span class="min-w-0 leading-relaxed">No commitment at this stage &mdash; just a conversation at your own pace.</span>
									</li>
								</ol>
							</div>
							<!-- CTA back to site -->
							<div class="mt-8">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline">
									<i class="ph-bold ph-arrow-left" aria-hidden="true"></i> Back to home
								</a>
							</div>
						</div>
					</div>
					<?php else : ?>
						<!-- Multi-step form -->
						<form method="post" action="<?php echo esc_url( $current_url ); ?>"
						      class="restwell-enq-form rw-surface-card p-8 md:p-10"
						      data-multistep
						      novalidate>
							<?php wp_nonce_field( RESTWELL_ENQUIRE_NONCE_ACTION, RESTWELL_ENQUIRE_NONCE_NAME ); ?>
							<input type="hidden" name="restwell_enquire" value="1" />
							<input type="hidden" name="enq_redirect" value="<?php echo esc_url( $current_url ); ?>" />
							<input type="hidden" name="restwell_form_opened_at" value="" data-restwell-form-opened />
							<!-- Honeypot: must stay empty; bots fill it, humans don't see it -->
							<div style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
								<label for="enq_website">Website</label>
								<input type="text" id="enq_website" name="enq_website" tabindex="-1" autocomplete="off" />
							</div>

							<!-- Screen-reader live region: announces step name when the user moves between steps. -->
						<p id="enq-step-announcement" class="sr-only" aria-live="assertive" aria-atomic="true"></p>

						<h2 id="enq-form-heading" class="text-2xl font-serif text-[var(--deep-teal)] mb-2"><?php echo esc_html( $enq_form_heading ); ?></h2>
						<p class="text-xs text-[var(--muted-grey)] mb-6">Fields marked <span class="text-[#D4A853]" aria-hidden="true">*</span><span class="sr-only">with an asterisk</span> are required.</p>

						<?php if ( ! empty( $enq_errors ) ) : ?>
							<div class="text-sm text-[#7a1c1c] bg-[#fef2f2] border border-[#fecaca] rounded-xl px-4 py-3 mb-6" role="alert">
								<?php foreach ( $enq_errors as $err ) : ?>
									<p class="m-0 mb-1 last:mb-0"><?php echo esc_html( $err ); ?></p>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

							<!-- Step progress indicator -->
							<div class="enq-steps-progress flex items-start gap-0 mb-8"
							     role="progressbar"
							     aria-label="Enquiry form progress"
							     aria-valuenow="1"
							     aria-valuemin="1"
							     aria-valuemax="3">
								<div class="step-node flex flex-col items-center flex-1 min-w-0" data-step="1">
									<div class="step-circle w-9 h-9 rounded-full border-2 flex items-center justify-center text-sm font-semibold leading-none transition-colors duration-200">1</div>
									<p class="step-label text-xs text-center mt-1.5 leading-tight px-1">About you</p>
								</div>
								<div class="step-line flex-1 h-0.5 mt-4 transition-colors duration-200"></div>
								<div class="step-node flex flex-col items-center flex-1 min-w-0" data-step="2">
									<div class="step-circle w-9 h-9 rounded-full border-2 flex items-center justify-center text-sm font-semibold leading-none transition-colors duration-200">2</div>
									<p class="step-label text-xs text-center mt-1.5 leading-tight px-1">Your stay</p>
								</div>
								<div class="step-line flex-1 h-0.5 mt-4 transition-colors duration-200"></div>
								<div class="step-node flex flex-col items-center flex-1 min-w-0" data-step="3">
									<div class="step-circle w-9 h-9 rounded-full border-2 flex items-center justify-center text-sm font-semibold leading-none transition-colors duration-200">3</div>
									<p class="step-label text-xs text-center mt-1.5 leading-tight px-1">Your needs</p>
								</div>
							</div>

							<!-- Step 1: About you -->
							<div class="enquire-step space-y-5" data-step="1">
						<div>
								<label for="enq_name" class="<?php echo esc_attr( $label_class ); ?>">Your name <span class="text-[#D4A853]" aria-hidden="true">*</span></label>
								<input type="text" id="enq_name" name="enq_name" required aria-required="true" autocomplete="name"
								       class="<?php echo esc_attr( $input_class ); ?>" placeholder="Jane Smith" value="<?php echo esc_attr( $enq_f['enq_name'] ); ?>" />
							</div>
							<div>
								<label for="enq_email" class="<?php echo esc_attr( $label_class ); ?>">Email address <span class="text-[#D4A853]" aria-hidden="true">*</span></label>
								<input type="email" id="enq_email" name="enq_email" required aria-required="true" autocomplete="email"
								       class="<?php echo esc_attr( $input_class ); ?>" placeholder="jane@example.com" value="<?php echo esc_attr( $enq_f['enq_email'] ); ?>" />
								</div>
								<div>
									<label for="enq_phone" class="<?php echo esc_attr( $label_class ); ?>">Phone number <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<input type="tel" id="enq_phone" name="enq_phone" autocomplete="tel"
									       class="<?php echo esc_attr( $input_class ); ?>" placeholder="07700 900000" value="<?php echo esc_attr( $enq_f['enq_phone'] ); ?>" />
								</div>
								<div>
									<label for="enq_contact_preference" class="<?php echo esc_attr( $label_class ); ?>">Preferred contact method</label>
									<select id="enq_contact_preference" name="enq_contact_preference" class="<?php echo esc_attr( $input_class ); ?>">
										<option value="" <?php selected( $enq_f['enq_contact_preference'], '' ); ?>><?php esc_html_e( 'Either', 'restwell-retreats' ); ?></option>
										<option value="phone" <?php selected( $enq_f['enq_contact_preference'], 'phone' ); ?>><?php esc_html_e( 'Phone', 'restwell-retreats' ); ?></option>
										<option value="email" <?php selected( $enq_f['enq_contact_preference'], 'email' ); ?>><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></option>
									</select>
								</div>
								<div>
									<label for="enq_preferred_time" class="<?php echo esc_attr( $label_class ); ?>">Best time to call <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<select id="enq_preferred_time" name="enq_preferred_time" class="<?php echo esc_attr( $input_class ); ?>">
										<option value="" <?php selected( $enq_f['enq_preferred_time'], '' ); ?>><?php esc_html_e( 'Any time', 'restwell-retreats' ); ?></option>
										<option value="morning" <?php selected( $enq_f['enq_preferred_time'], 'morning' ); ?>><?php esc_html_e( 'Morning', 'restwell-retreats' ); ?></option>
										<option value="afternoon" <?php selected( $enq_f['enq_preferred_time'], 'afternoon' ); ?>><?php esc_html_e( 'Afternoon', 'restwell-retreats' ); ?></option>
										<option value="evening" <?php selected( $enq_f['enq_preferred_time'], 'evening' ); ?>><?php esc_html_e( 'Evening', 'restwell-retreats' ); ?></option>
									</select>
								</div>
								<div class="pt-2">
									<button type="button" class="step-next btn btn-primary w-full" data-next="2">
										Continue <i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
									</button>
								</div>
							</div>

							<!-- Step 2: Your stay -->
							<div class="enquire-step space-y-5 hidden" data-step="2">
								<fieldset class="border-0 p-0 m-0">
									<legend class="<?php echo esc_attr( $label_class ); ?>">Preferred dates <span class="text-[var(--muted-grey)] font-normal">(optional)</span></legend>
									<div class="grid grid-cols-2 gap-3 mt-1.5">
										<div>
											<label for="enq_date_from" class="block text-xs text-[var(--muted-grey)] mb-1">From</label>
											<input type="date" id="enq_date_from" name="enq_date_from" min="<?php echo esc_attr( $date_min ); ?>"
											       class="<?php echo esc_attr( $input_class ); ?> restwell-enq-date" value="<?php echo esc_attr( $enq_f['enq_date_from'] ); ?>" />
										</div>
										<div>
											<label for="enq_date_to" class="block text-xs text-[var(--muted-grey)] mb-1">To</label>
											<input type="date" id="enq_date_to" name="enq_date_to" min="<?php echo esc_attr( $date_min ); ?>"
											       class="<?php echo esc_attr( $input_class ); ?> restwell-enq-date" value="<?php echo esc_attr( $enq_f['enq_date_to'] ); ?>" />
										</div>
									</div>
								</fieldset>
								<div>
									<label for="enq_guests" class="<?php echo esc_attr( $label_class ); ?>">Number of guests <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<input type="number" id="enq_guests" name="enq_guests" min="1" max="20"
									       class="<?php echo esc_attr( $input_class ); ?>" placeholder="2" value="<?php echo esc_attr( $enq_f['enq_guests'] ); ?>" />
								</div>
								<div>
									<label for="enq_funding" class="<?php echo esc_attr( $label_class ); ?>">Funding type <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<select id="enq_funding" name="enq_funding" class="<?php echo esc_attr( $input_class ); ?>">
										<option value="" <?php selected( $enq_f['enq_funding'], '' ); ?>><?php esc_html_e( 'Not sure', 'restwell-retreats' ); ?></option>
										<option value="self" <?php selected( $enq_f['enq_funding'], 'self' ); ?>><?php esc_html_e( 'Self-funding', 'restwell-retreats' ); ?></option>
										<option value="kcc" <?php selected( $enq_f['enq_funding'], 'kcc' ); ?>><?php esc_html_e( 'Kent County Council (KCC)', 'restwell-retreats' ); ?></option>
										<option value="chc" <?php selected( $enq_f['enq_funding'], 'chc' ); ?>><?php esc_html_e( 'NHS Continuing Healthcare (CHC)', 'restwell-retreats' ); ?></option>
										<option value="direct" <?php selected( $enq_f['enq_funding'], 'direct' ); ?>><?php esc_html_e( 'Direct payments', 'restwell-retreats' ); ?></option>
									</select>
									<p class="text-xs rw-copy-muted mt-1.5">
										<a href="<?php echo esc_url( $resources_url ); ?>" class="text-[var(--deep-teal)] hover:underline">Not sure? See our Funding &amp; support page</a>
									</p>
								</div>
								<div class="flex items-center gap-3 py-2">
									<input type="checkbox" id="enq_urgent" name="enq_urgent" value="1"
									       class="enquire-checkbox-urgent h-[1.125rem] w-[1.125rem] shrink-0 rounded border-2 border-[#C4B8A8] bg-white focus:outline-none focus:ring-2 focus:ring-[#A8D5D0] focus:ring-offset-2" <?php checked( $enq_f['enq_urgent'], '1' ); ?> />
									<label for="enq_urgent" class="text-sm font-medium leading-snug text-[#1B4D5C] cursor-pointer select-none">
										This is urgent - please prioritise my enquiry
									</label>
								</div>
								<div class="flex gap-3 pt-2">
									<button type="button" class="step-back btn btn-outline flex-1" data-back="1">
										<i class="ph-bold ph-arrow-left" aria-hidden="true"></i> Back
									</button>
									<button type="button" class="step-next btn btn-primary flex-[2]" data-next="3">
										Continue <i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
									</button>
								</div>
							</div>

							<!-- Step 3: Your needs -->
							<div class="enquire-step space-y-5 hidden" data-step="3">
								<div>
									<label for="enq_care" class="<?php echo esc_attr( $label_class ); ?>">Care requirements <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<textarea id="enq_care" name="enq_care" rows="3"
									          class="<?php echo esc_attr( $input_class ); ?> resize-y"
									          placeholder="Tell us about any care support you might need, or leave blank if not applicable."><?php echo esc_textarea( $enq_f['enq_care'] ); ?></textarea>
								</div>
								<div>
									<label for="enq_accessibility" class="<?php echo esc_attr( $label_class ); ?>">Accessibility needs <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<textarea id="enq_accessibility" name="enq_accessibility" rows="3"
									          class="<?php echo esc_attr( $input_class ); ?> resize-y"
									          placeholder="Any specific accessibility requirements we should know about?"><?php echo esc_textarea( $enq_f['enq_accessibility'] ); ?></textarea>
								</div>
							<div>
								<label for="enq_message" class="<?php echo esc_attr( $label_class ); ?>">Your message <span class="text-[#D4A853]" aria-hidden="true">*</span></label>
								<textarea id="enq_message" name="enq_message" required aria-required="true" rows="4"
									          class="<?php echo esc_attr( $input_class ); ?> resize-y"
									          placeholder="Tell us a bit about what you're looking for, or ask any questions."><?php echo esc_textarea( $enq_f['enq_message'] ); ?></textarea>
								</div>
								<div class="flex gap-3 pt-2">
									<button type="button" class="step-back btn btn-outline flex-1" data-back="2">
										<i class="ph-bold ph-arrow-left" aria-hidden="true"></i> Back
									</button>
									<button type="submit" class="btn btn-primary flex-[2] min-h-[48px]">
										<?php esc_html_e( 'Send my enquiry', 'restwell-retreats' ); ?>
									</button>
								</div>
								<p class="text-xs text-[var(--muted-grey)] text-center">We will never share your details with third parties.</p>
							</div>

						</form>
					<?php endif; ?>
				</div>

				<!-- Sidebar: single contact card (hero + success state already cover timing and no-obligation). -->
				<div class="md:col-span-2 space-y-6">
					<?php if ( $enq_email || $enq_phone ) : ?>
					<div class="<?php echo esc_attr( $sidebar_card_base ); ?>">
						<h3 class="<?php echo esc_attr( $sidebar_card_heading ); ?>"><?php echo esc_html( $enq_contact_heading ); ?></h3>
						<p class="text-sm text-[var(--muted-grey)] leading-relaxed mb-5"><?php esc_html_e( 'Same team as the form—use whatever suits you.', 'restwell-retreats' ); ?></p>
						<div class="space-y-5 rw-copy-body">
							<?php if ( $enq_phone ) : ?>
							<div>
								<p class="text-sm font-medium text-[var(--deep-teal)] mb-1"><?php esc_html_e( 'Phone', 'restwell-retreats' ); ?></p>
								<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $enq_phone ) ); ?>"
								   class="inline-flex items-center gap-2 text-lg font-serif text-[var(--deep-teal)] font-medium hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2 rounded no-underline">
									<i class="ph-bold ph-phone text-xs opacity-70" aria-hidden="true"></i>
									<?php echo esc_html( $enq_phone ); ?>
								</a>
							</div>
							<?php endif; ?>
							<?php if ( $enq_email ) : ?>
							<div>
								<p class="text-sm font-medium text-[var(--deep-teal)] mb-1"><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></p>
								<a href="mailto:<?php echo esc_attr( $enq_email ); ?>" class="text-[var(--deep-teal)] hover:underline text-sm break-all"><?php echo esc_html( $enq_email ); ?></a>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>

					<?php
					$enq_who_page = get_page_by_path( 'who-its-for', OBJECT, 'page' );
					$enq_who_url  = $enq_who_page ? get_permalink( $enq_who_page ) : home_url( '/who-its-for/' );
					?>
					<div class="<?php echo esc_attr( $sidebar_card_base ); ?>">
						<h3 class="<?php echo esc_attr( $sidebar_card_heading ); ?>"><?php esc_html_e( 'Funding your stay', 'restwell-retreats' ); ?></h3>
						<p class="rw-copy-body text-sm leading-relaxed mb-5"><?php esc_html_e( 'Direct payments, personal budgets, and NHS CHC may apply depending on your package and local authority. We can provide documentation to support applications.', 'restwell-retreats' ); ?></p>
						<div class="flex flex-wrap gap-2">
							<a href="<?php echo esc_url( $resources_url ); ?>" class="inline-flex items-center gap-2 rounded-full border border-[var(--deep-teal)]/25 px-3 py-1.5 text-[var(--deep-teal)] font-medium text-sm hover:border-[var(--deep-teal)]/45 hover:bg-[var(--sea-glass)]/20 transition-colors">
								<?php esc_html_e( 'Funding &amp; support', 'restwell-retreats' ); ?>
							</a>
							<a href="<?php echo esc_url( $enq_who_url ); ?>" class="inline-flex items-center gap-2 rounded-full border border-[var(--deep-teal)]/25 px-3 py-1.5 text-[var(--deep-teal)] font-medium text-sm hover:border-[var(--deep-teal)]/45 hover:bg-[var(--sea-glass)]/20 transition-colors">
								<?php esc_html_e( 'Who it\'s for', 'restwell-retreats' ); ?>
							</a>
						</div>
					</div>

				</div>

			</div>
		</div>
	</section>

</main>
<?php get_footer(); ?>
