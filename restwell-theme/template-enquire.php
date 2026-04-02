<?php
/**
 * Template Name: Enquire
 * Contact/enquiry page with multi-step form and editable sidebar.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

// Hero
$enq_hero_image_id  = (int) get_post_meta( $pid, 'enq_hero_image_id', true );
$enq_hero_image_src = $enq_hero_image_id ? wp_get_attachment_image_url( $enq_hero_image_id, 'full' ) : '';
$enq_label          = get_post_meta( $pid, 'enq_label', true ) ?: 'Get in touch';
$enq_heading        = get_post_meta( $pid, 'enq_heading', true ) ?: 'Start a conversation.';
$enq_intro          = get_post_meta( $pid, 'enq_intro', true ) ?: 'Whether you have specific dates in mind or just want to ask about a bathroom measurement, we are here to help. This isn\'t a booking commitment — it is just the start of a conversation. No pressure, no hard sell.';

// Form copy
$enq_form_heading        = get_post_meta( $pid, 'enq_form_heading', true ) ?: 'Request a call about your stay';
$enq_success_heading     = get_post_meta( $pid, 'enq_success_heading', true ) ?: 'Thank you for your enquiry';
$enq_success_body        = get_post_meta( $pid, 'enq_success_body', true ) ?: "We've received your enquiry. We'll be in touch to confirm availability and next steps.";
$enq_success_urgent_body = get_post_meta( $pid, 'enq_success_urgent_body', true ) ?: "We've received your urgent enquiry. We'll prioritise your request and be in touch as soon as we can.";

// Sidebar
$enq_contact_heading      = get_post_meta( $pid, 'enq_contact_heading', true ) ?: 'Direct contact';
$enq_email                = get_post_meta( $pid, 'enq_email', true ) ?: 'hello@restwellretreats.co.uk';
$enq_phone                = get_post_meta( $pid, 'enq_phone', true ) ?: (string) get_option( 'restwell_phone_number', '01622 809881' );
$enq_response_heading     = get_post_meta( $pid, 'enq_response_heading', true ) ?: 'Response time';
$enq_response_body        = get_post_meta( $pid, 'enq_response_body', true ) ?: 'We aim to respond to all enquiries as soon as we can. If your enquiry is urgent, please call us directly.';
$enq_no_pressure_heading  = get_post_meta( $pid, 'enq_no_pressure_heading', true ) ?: 'No pressure';
$enq_no_pressure_body     = get_post_meta( $pid, 'enq_no_pressure_body', true ) ?: 'Sending an enquiry is not a booking commitment. It is simply the start of a conversation. We are happy to answer questions, talk through specific needs, or just have a chat about whether Restwell is right for you.';

$sent        = isset( $_GET['sent'] ) && $_GET['sent'] === '1';
$urgent      = $sent && isset( $_GET['urgent'] ) && $_GET['urgent'] === '1';
$current_url = get_permalink( $pid );
$resources_url = home_url( '/resources/' );

$sidebar_card_base    = 'bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100';
$sidebar_card_heading = 'text-lg font-serif text-[var(--deep-teal)] mb-3';

// Common input classes
// focus:outline-none is intentionally removed — the global :focus-visible rule
// provides a 3px deep-teal outline for keyboard users (2.4.7 Focus Visible, WCAG AA).
// focus-visible:outline-none would suppress it for mouse clicks only, but Tailwind
// v3 generates a :focus selector here, so we let the CSS layer handle focus-visible.
$input_class = 'w-full px-4 py-3 rounded-xl border border-[#CFC2AD] bg-[#FFFEFC] text-[#1B4D5C] text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#A8D5D0] focus:ring-offset-2';
$label_class = 'block text-sm font-semibold text-[#1B4D5C] mb-1.5';
?>
<main class="flex-1" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<!-- Hero -->
	<section class="hero relative flex items-end overflow-hidden min-h-[32rem] <?php echo $enq_hero_image_src ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="page-hero-heading">
		<?php if ( $enq_hero_image_src ) : ?>
			<img src="<?php echo esc_url( $enq_hero_image_src ); ?>" alt="" class="absolute inset-0 w-full h-full object-cover -z-10" loading="eager" />
		<?php endif; ?>
		<div class="absolute inset-0 bg-black/30 -z-[5]" aria-hidden="true"></div>
		<div class="absolute inset-0 bg-gradient-to-t from-[var(--deep-teal)]/85 via-[var(--deep-teal)]/45 to-transparent -z-[5]" aria-hidden="true"></div>
		<div class="relative z-10 container pb-16 md:pb-24 pt-32">
			<div class="max-w-2xl">
				<?php if ( $enq_label !== '' ) : ?>
					<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-4 font-sans"><?php echo esc_html( $enq_label ); ?></p>
				<?php endif; ?>
				<h1 id="page-hero-heading" class="text-white text-4xl md:text-5xl lg:text-6xl mb-6 leading-tight font-serif"><?php echo esc_html( $enq_heading ); ?></h1>
				<?php if ( $enq_intro !== '' ) : ?>
					<p class="text-[#F5EDE0] text-lg md:text-xl leading-relaxed max-w-prose drop-shadow-[0_1px_2px_rgba(0,0,0,0.3)]"><?php echo esc_html( $enq_intro ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Form + sidebar -->
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-labelledby="enq-form-heading">
		<div class="container max-w-5xl">
			<div class="grid md:grid-cols-5 gap-12">

				<!-- Form column -->
				<div class="md:col-span-3">
				<?php if ( $sent ) : ?>
					<!-- Success state -->
					<div id="enquiry-result" class="enquiry-result bg-white rounded-2xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-[#E8DFD0] scroll-mt-[clamp(5rem,14vh,8rem)]" role="status" aria-live="polite" tabindex="-1">
						<!-- Coloured top bar -->
						<div class="h-1.5 bg-gradient-to-r from-[var(--deep-teal)] to-[#A8D5D0]"></div>
						<div class="p-8 md:p-10">
							<!-- Icon + heading -->
							<div class="flex items-start gap-5 mb-6">
								<div class="shrink-0 w-14 h-14 bg-[#A8D5D0]/25 rounded-full flex items-center justify-center text-[var(--deep-teal)]" aria-hidden="true">
									<i class="fa-solid fa-check text-xl"></i>
								</div>
								<div>
									<h2 id="enq-form-heading" class="text-2xl font-serif text-[var(--deep-teal)] leading-snug mb-1"><?php echo esc_html( $enq_success_heading ); ?></h2>
									<p class="text-gray-600 leading-relaxed"><?php echo esc_html( $urgent ? $enq_success_urgent_body : $enq_success_body ); ?></p>
								</div>
							</div>
							<!-- What happens next -->
							<div class="border-t border-[#E8DFD0] pt-6">
								<p class="text-xs font-semibold text-[var(--warm-gold-text)] uppercase tracking-wider mb-4">What happens next</p>
								<ol class="enquiry-next-steps space-y-4 text-sm text-gray-600 list-none p-0 m-0">
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
									<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to home
								</a>
							</div>
						</div>
					</div>
					<?php else : ?>
						<!-- Multi-step form -->
						<form method="post" action="<?php echo esc_url( $current_url ); ?>"
						      class="restwell-enq-form bg-white rounded-2xl p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100"
						      data-multistep
						      novalidate>
							<?php wp_nonce_field( RESTWELL_ENQUIRE_NONCE_ACTION, RESTWELL_ENQUIRE_NONCE_NAME ); ?>
							<input type="hidden" name="restwell_enquire" value="1" />
							<input type="hidden" name="enq_redirect" value="<?php echo esc_url( $current_url ); ?>" />
							<!-- Honeypot: must stay empty; bots fill it, humans don't see it -->
							<div style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
								<label for="enq_website">Website</label>
								<input type="text" id="enq_website" name="enq_website" tabindex="-1" autocomplete="off" />
							</div>

							<!-- Screen-reader live region: announces step name when the user moves between steps. -->
						<p id="enq-step-announcement" class="sr-only" aria-live="assertive" aria-atomic="true"></p>

						<h2 id="enq-form-heading" class="text-2xl font-serif text-[var(--deep-teal)] mb-2"><?php echo esc_html( $enq_form_heading ); ?></h2>
						<p class="text-xs text-[var(--muted-grey)] mb-6">Fields marked <span class="text-[#D4A853]" aria-hidden="true">*</span><span class="sr-only">with an asterisk</span> are required.</p>

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
								       class="<?php echo esc_attr( $input_class ); ?>" placeholder="Jane Smith" />
							</div>
							<div>
								<label for="enq_email" class="<?php echo esc_attr( $label_class ); ?>">Email address <span class="text-[#D4A853]" aria-hidden="true">*</span></label>
								<input type="email" id="enq_email" name="enq_email" required aria-required="true" autocomplete="email"
								       class="<?php echo esc_attr( $input_class ); ?>" placeholder="jane@example.com" />
								</div>
								<div>
									<label for="enq_phone" class="<?php echo esc_attr( $label_class ); ?>">Phone number <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<input type="tel" id="enq_phone" name="enq_phone" autocomplete="tel"
									       class="<?php echo esc_attr( $input_class ); ?>" placeholder="07700 900000" />
								</div>
								<div>
									<label for="enq_contact_preference" class="<?php echo esc_attr( $label_class ); ?>">Preferred contact method</label>
									<select id="enq_contact_preference" name="enq_contact_preference" class="<?php echo esc_attr( $input_class ); ?>">
										<option value="">Either</option>
										<option value="phone">Phone</option>
										<option value="email">Email</option>
									</select>
								</div>
								<div>
									<label for="enq_preferred_time" class="<?php echo esc_attr( $label_class ); ?>">Best time to call <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<select id="enq_preferred_time" name="enq_preferred_time" class="<?php echo esc_attr( $input_class ); ?>">
										<option value="">Any time</option>
										<option value="morning">Morning</option>
										<option value="afternoon">Afternoon</option>
										<option value="evening">Evening</option>
									</select>
								</div>
								<div class="pt-2">
									<button type="button" class="step-next btn btn-primary w-full" data-next="2">
										Continue <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
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
											<input type="date" id="enq_date_from" name="enq_date_from"
											       class="<?php echo esc_attr( $input_class ); ?>" />
										</div>
										<div>
											<label for="enq_date_to" class="block text-xs text-[var(--muted-grey)] mb-1">To</label>
											<input type="date" id="enq_date_to" name="enq_date_to"
											       class="<?php echo esc_attr( $input_class ); ?>" />
										</div>
									</div>
								</fieldset>
								<div>
									<label for="enq_guests" class="<?php echo esc_attr( $label_class ); ?>">Number of guests <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<input type="number" id="enq_guests" name="enq_guests" min="1" max="20"
									       class="<?php echo esc_attr( $input_class ); ?>" placeholder="2" />
								</div>
								<div>
									<label for="enq_funding" class="<?php echo esc_attr( $label_class ); ?>">Funding type <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<select id="enq_funding" name="enq_funding" class="<?php echo esc_attr( $input_class ); ?>">
										<option value="">Not sure</option>
										<option value="self">Self-funding</option>
										<option value="kcc">Kent County Council (KCC)</option>
										<option value="chc">NHS Continuing Healthcare (CHC)</option>
										<option value="direct">Direct payments</option>
									</select>
									<p class="text-xs text-[var(--muted-grey)] mt-1.5">
										<a href="<?php echo esc_url( $resources_url ); ?>" class="text-[var(--deep-teal)] hover:underline">Not sure? See our Funding &amp; support page</a>
									</p>
								</div>
								<div class="flex items-center gap-3 py-2">
									<input type="checkbox" id="enq_urgent" name="enq_urgent" value="1"
									       class="enquire-checkbox-urgent h-[1.125rem] w-[1.125rem] shrink-0 rounded border-2 border-[#C4B8A8] bg-white focus:outline-none focus:ring-2 focus:ring-[#A8D5D0] focus:ring-offset-2" />
									<label for="enq_urgent" class="text-sm font-medium leading-snug text-[#1B4D5C] cursor-pointer select-none">
										This is urgent — please prioritise my enquiry
									</label>
								</div>
								<div class="flex gap-3 pt-2">
									<button type="button" class="step-back btn btn-outline flex-1" data-back="1">
										<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back
									</button>
									<button type="button" class="step-next btn btn-primary flex-[2]" data-next="3">
										Continue <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
									</button>
								</div>
							</div>

							<!-- Step 3: Your needs -->
							<div class="enquire-step space-y-5 hidden" data-step="3">
								<div>
									<label for="enq_care" class="<?php echo esc_attr( $label_class ); ?>">Care requirements <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<textarea id="enq_care" name="enq_care" rows="3"
									          class="<?php echo esc_attr( $input_class ); ?> resize-y"
									          placeholder="Tell us about any care support you might need, or leave blank if not applicable."></textarea>
								</div>
								<div>
									<label for="enq_accessibility" class="<?php echo esc_attr( $label_class ); ?>">Accessibility needs <span class="text-[var(--muted-grey)] font-normal">(optional)</span></label>
									<textarea id="enq_accessibility" name="enq_accessibility" rows="3"
									          class="<?php echo esc_attr( $input_class ); ?> resize-y"
									          placeholder="Any specific accessibility requirements we should know about?"></textarea>
								</div>
							<div>
								<label for="enq_message" class="<?php echo esc_attr( $label_class ); ?>">Your message <span class="text-[#D4A853]" aria-hidden="true">*</span></label>
								<textarea id="enq_message" name="enq_message" required aria-required="true" rows="4"
									          class="<?php echo esc_attr( $input_class ); ?> resize-y"
									          placeholder="Tell us a bit about what you're looking for, or ask any questions."></textarea>
								</div>
								<div class="flex gap-3 pt-2">
									<button type="button" class="step-back btn btn-outline flex-1" data-back="2">
										<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back
									</button>
									<button type="submit" class="btn btn-primary flex-[2]">
										Send enquiry
									</button>
								</div>
								<p class="text-xs text-[var(--muted-grey)] text-center">We will never share your details with third parties.</p>
							</div>

						</form>
					<?php endif; ?>
				</div>

				<!-- Sidebar -->
				<div class="md:col-span-2 space-y-6">
					<?php if ( $enq_phone ) : ?>
						<div class="<?php echo esc_attr( $sidebar_card_base ); ?>">
							<h3 class="<?php echo esc_attr( $sidebar_card_heading ); ?>"><?php esc_html_e( 'Prefer to call?', 'restwell-retreats' ); ?></h3>
							<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $enq_phone ) ); ?>"
							   class="inline-flex items-center gap-2 text-lg font-serif text-[var(--deep-teal)] font-medium hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2 rounded no-underline">
								<i class="fa-solid fa-phone text-xs opacity-70" aria-hidden="true"></i>
								<?php echo esc_html( $enq_phone ); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="<?php echo esc_attr( $sidebar_card_base ); ?>">
						<h3 class="<?php echo esc_attr( $sidebar_card_heading ); ?>"><?php echo esc_html( $enq_contact_heading ); ?></h3>
						<div class="space-y-4 text-gray-600">
							<div>
								<p class="text-sm font-medium text-[var(--deep-teal)] mb-0.5">Email</p>
								<?php if ( $enq_email ) : ?>
									<a href="mailto:<?php echo esc_attr( $enq_email ); ?>" class="text-[var(--deep-teal)] hover:underline text-sm"><?php echo esc_html( $enq_email ); ?></a>
								<?php else : ?>
									<p class="text-[var(--muted-grey)] italic text-sm">Add email in Page Content Fields</p>
								<?php endif; ?>
							</div>
							<div>
								<p class="text-sm font-medium text-[var(--deep-teal)] mb-0.5">Phone</p>
								<?php if ( $enq_phone ) : ?>
									<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $enq_phone ) ); ?>" class="text-[var(--deep-teal)] hover:underline text-sm"><?php echo esc_html( $enq_phone ); ?></a>
								<?php else : ?>
									<p class="text-[var(--muted-grey)] italic text-sm">Add phone in Page Content Fields</p>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<?php
					$enq_who_page = get_page_by_path( 'who-its-for', OBJECT, 'page' );
					$enq_who_url  = $enq_who_page ? get_permalink( $enq_who_page ) : home_url( '/who-its-for/' );
					?>
					<div class="<?php echo esc_attr( $sidebar_card_base ); ?>">
						<h3 class="<?php echo esc_attr( $sidebar_card_heading ); ?>"><?php esc_html_e( 'Funding your stay', 'restwell-retreats' ); ?></h3>
						<p class="text-gray-600 text-sm leading-relaxed mb-5"><?php esc_html_e( 'Direct payments, personal budgets, and NHS CHC may apply depending on your package and local authority. We can provide documentation to support applications.', 'restwell-retreats' ); ?></p>
						<div class="flex flex-wrap gap-2">
							<a href="<?php echo esc_url( $resources_url ); ?>" class="inline-flex items-center gap-2 rounded-full border border-[var(--deep-teal)]/25 px-3 py-1.5 text-[var(--deep-teal)] font-medium text-sm hover:border-[var(--deep-teal)]/45 hover:bg-[var(--sea-glass)]/20 transition-colors">
								<?php esc_html_e( 'Funding &amp; support', 'restwell-retreats' ); ?>
							</a>
							<a href="<?php echo esc_url( $enq_who_url ); ?>" class="inline-flex items-center gap-2 rounded-full border border-[var(--deep-teal)]/25 px-3 py-1.5 text-[var(--deep-teal)] font-medium text-sm hover:border-[var(--deep-teal)]/45 hover:bg-[var(--sea-glass)]/20 transition-colors">
								<?php esc_html_e( 'Who it\'s for', 'restwell-retreats' ); ?>
							</a>
						</div>
					</div>

				<?php if ( $enq_response_heading || $enq_response_body ) : ?>
				<div class="<?php echo esc_attr( $sidebar_card_base ); ?>">
					<?php if ( $enq_response_heading ) : ?>
					<h3 class="<?php echo esc_attr( $sidebar_card_heading ); ?>"><?php echo esc_html( $enq_response_heading ); ?></h3>
					<?php endif; ?>
					<?php if ( $enq_response_body ) : ?>
					<p class="text-gray-600 leading-relaxed text-sm"><?php echo esc_html( $enq_response_body ); ?></p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php if ( $enq_no_pressure_heading || $enq_no_pressure_body ) : ?>
				<div class="bg-[var(--deep-teal)] rounded-2xl p-7 text-[#F5EDE0]">
					<?php if ( $enq_no_pressure_heading ) : ?>
					<h3 class="text-lg font-serif text-white mb-3"><?php echo esc_html( $enq_no_pressure_heading ); ?></h3>
					<?php endif; ?>
					<?php if ( $enq_no_pressure_body ) : ?>
					<p class="text-[#F5EDE0] leading-relaxed text-sm opacity-90"><?php echo esc_html( $enq_no_pressure_body ); ?></p>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				</div>

			</div>
		</div>
	</section>

</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
