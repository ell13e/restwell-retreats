<?php
/**
 * Template Name: FAQ
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

// Hero
$faq_hero_image_id  = (int) get_post_meta( $pid, 'faq_hero_image_id', true );
$faq_hero_image_src = $faq_hero_image_id ? wp_get_attachment_image_url( $faq_hero_image_id, 'full' ) : '';
$faq_label          = get_post_meta( $pid, 'faq_label', true ) ?: 'Frequently asked questions';
$faq_heading        = get_post_meta( $pid, 'faq_heading', true ) ?: 'Questions we get asked';
$faq_intro          = get_post_meta( $pid, 'faq_intro', true ) ?: 'We have tried to cover the most common questions below. If yours isn\'t here, get in touch — we are always happy to talk things through.';

// FAQ list section — heading only shown if explicitly set and different from hero heading.
$faq_list_label   = get_post_meta( $pid, 'faq_list_label', true ) ?: 'Browse by topic';
$faq_list_heading = get_post_meta( $pid, 'faq_list_heading', true ) ?: '';

// CTA section
$faq_cta_label   = get_post_meta( $pid, 'faq_cta_label', true ) ?: '';
$faq_cta_heading = get_post_meta( $pid, 'faq_cta_heading', true ) ?: 'Still have a question?';
$faq_cta_body    = get_post_meta( $pid, 'faq_cta_body', true ) ?: 'We are here to help. No question is too small or too specific.';
$faq_cta_btn     = get_post_meta( $pid, 'faq_cta_btn', true ) ?: 'Ask us';
$faq_cta_url     = esc_url( get_post_meta( $pid, 'faq_cta_url', true ) ?: home_url( '/enquire/' ) );

$faq_question_sent   = isset( $_GET['question_sent'] ) && '1' === sanitize_text_field( wp_unslash( $_GET['question_sent'] ) );
$faq_question_errors = array();
$faq_q_name          = '';
$faq_q_email         = '';
$faq_q_message       = '';

$faq_form_input_class = 'w-full rounded-xl border border-[#CFC2AD] bg-[#FFFEFC] px-4 py-3 text-sm text-[#1B4D5C] shadow-sm focus:outline-none focus:ring-2 focus:ring-[#A8D5D0] focus:ring-offset-2';
$faq_form_label_class = 'block text-sm font-semibold text-[#1B4D5C] mb-1.5';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['restwell_faq_question'] ) ) {
	$nonce = isset( $_POST['restwell_faq_question_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['restwell_faq_question_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'restwell_faq_question' ) ) {
		$faq_question_errors[] = __( 'Security check failed. Please try again.', 'restwell-retreats' );
	} else {
		$faq_q_name    = isset( $_POST['faq_q_name'] ) ? sanitize_text_field( wp_unslash( $_POST['faq_q_name'] ) ) : '';
		$faq_q_email   = isset( $_POST['faq_q_email'] ) ? sanitize_email( wp_unslash( $_POST['faq_q_email'] ) ) : '';
		$faq_q_message = isset( $_POST['faq_q_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['faq_q_message'] ) ) : '';

		if ( '' === $faq_q_name ) {
			$faq_question_errors[] = __( 'Please add your name.', 'restwell-retreats' );
		}

		if ( '' === $faq_q_email || ! is_email( $faq_q_email ) ) {
			$faq_question_errors[] = __( 'Please add a valid email address.', 'restwell-retreats' );
		}

		if ( '' === $faq_q_message ) {
			$faq_question_errors[] = __( 'Please type your question.', 'restwell-retreats' );
		}

		if ( empty( $faq_question_errors ) ) {
			$to      = get_option( 'admin_email' );
			$subject = sprintf( __( 'FAQ question from %s', 'restwell-retreats' ), $faq_q_name );
			$lines   = array(
				sprintf( __( 'Name: %s', 'restwell-retreats' ), $faq_q_name ),
				sprintf( __( 'Email: %s', 'restwell-retreats' ), $faq_q_email ),
				'',
				__( 'Question:', 'restwell-retreats' ),
				$faq_q_message,
			);
			$headers = array( 'Reply-To: ' . $faq_q_name . ' <' . $faq_q_email . '>' );

			$sent = wp_mail( $to, $subject, implode( "\n", $lines ), $headers );

			if ( $sent ) {
				$redirect = add_query_arg(
					array( 'question_sent' => '1' ),
					get_permalink( $pid )
				);
				wp_safe_redirect( $redirect . '#faq-question-form' );
				exit;
			}

			$faq_question_errors[] = __( 'Sorry, your question could not be sent right now. Please try again.', 'restwell-retreats' );
		}
	}
}

// Build FAQ pairs with optional category (faq_N_cat).
// Category values: about | booking | care | local | funding
$faq_pairs = array();
for ( $i = 1; $i <= 14; $i++ ) {
	$q   = get_post_meta( $pid, "faq_{$i}_q", true );
	$a   = get_post_meta( $pid, "faq_{$i}_a", true );
	$cat = get_post_meta( $pid, "faq_{$i}_cat", true ) ?: 'about';
	if ( $q || $a ) {
		$faq_pairs[] = array( 'q' => $q ?: '', 'a' => $a ?: '', 'cat' => $cat );
	}
}
if ( empty( $faq_pairs ) ) {
	$faq_pairs = array(
		array(
			'q'   => 'Is this a care home?',
			'a'   => 'No. Restwell is a private holiday let — a real house that you have entirely to yourself. It is not a care home, a residential facility, or a clinical environment. Care is an optional extra that you can choose to add through our partner, Continuity of Care Services.',
			'cat' => 'about',
		),
		array(
			'q'   => 'What accessibility features does the property have?',
			'a'   => 'The property has level access throughout the ground floor and wide doorways suitable for wheelchair access. It is located on a quiet, flat residential street. For full details please visit our Accessibility page.',
			'cat' => 'about',
		),
		array(
			'q'   => 'How do I book?',
			'a'   => 'Start by using our enquiry form or getting in touch by phone or email. We will talk through your dates, your needs, and any questions you have. Once we have confirmed availability and you are happy with everything, we will confirm your booking.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'How far in advance can I book?',
			'a'   => 'We accept bookings as early as you need — some guests plan months ahead, particularly for summer. Get in touch with your preferred dates and we will confirm availability.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'Can I bring my own carer or PA?',
			'a'   => 'Absolutely. Many of our guests bring their own Personal Assistant or carer. The property is designed to accommodate everyone comfortably. You can also use CCS for \'top-up\' support alongside your own carer.',
			'cat' => 'care',
		),
		array(
			'q'   => 'What care can you provide?',
			'a'   => 'Care is provided by Continuity of Care Services (CCS), a CQC-regulated Kent-based provider. Support can range from a brief morning check-in to more comprehensive daily assistance. We will discuss your needs before your stay.',
			'cat' => 'care',
		),
		array(
			'q'   => 'Is the beach accessible?',
			'a'   => 'Whitstable\'s beach is shingle, which is generally not wheelchair-friendly. However, the Tankerton Slopes promenade — a long, flat concrete walkway above the beach — is excellent for wheelchair users and offers stunning sea views.',
			'cat' => 'local',
		),
		array(
			'q'   => 'What is Whitstable like to get around?',
			'a'   => 'Much of central Whitstable and the seafront area is relatively flat and accessible. The town has accessible parking, and the high street has a good mix of level and stepped access venues. We are happy to suggest specific places to eat, visit, and explore.',
			'cat' => 'local',
		),
		array(
			'q'   => 'Can I use my direct payment to stay at Restwell?',
			'a'   => 'In many cases, yes. Direct payments can often be used for short breaks and respite accommodation, depending on your care plan and local authority. We can provide the documentation your social worker or broker needs to approve the spend. Start with our Funding & Support page or get in touch to discuss your situation.',
			'cat' => 'funding',
		),
		array(
			'q'   => 'Is the property suitable for hoists and profiling beds?',
			'a'   => 'The property has space for portable hoists and equipment. For specific requirements — ceiling track hoists, particular bed configurations, or specialist equipment — please get in touch before booking so we can confirm whether we can accommodate your needs.',
			'cat' => 'about',
		),
		array(
			'q'   => 'What is the minimum stay?',
			'a'   => 'We are flexible. Most guests stay for a week, but shorter breaks are sometimes available depending on the time of year. Get in touch with your preferred dates and we will let you know.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'What does CQC-regulated mean?',
			'a'   => 'CQC stands for Care Quality Commission — the independent regulator of health and social care in England. Continuity of Care Services, our partner provider, is inspected and rated by the CQC. This means the care you receive meets nationally recognised standards for safety and quality.',
			'cat' => 'care',
		),
	);
}

// Category definitions for tabs.
$categories = array(
	'all'     => 'All questions',
	'about'   => 'About the property',
	'booking' => 'Booking & dates',
	'care'    => 'Care & support',
	'local'   => 'The local area',
	'funding' => 'Funding & payments',
);
?>
<main class="flex-1" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<!-- Hero -->
	<section class="hero relative flex items-end overflow-hidden min-h-[32rem] <?php echo $faq_hero_image_src ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="page-hero-heading">
		<?php if ( $faq_hero_image_src ) : ?>
			<img src="<?php echo esc_url( $faq_hero_image_src ); ?>" alt="" class="absolute inset-0 w-full h-full object-cover -z-10" loading="eager" />
		<?php endif; ?>
		<div class="absolute inset-0 bg-black/30 -z-[5]" aria-hidden="true"></div>
		<div class="absolute inset-0 bg-gradient-to-t from-[var(--deep-teal)]/85 via-[var(--deep-teal)]/45 to-transparent -z-[5]" aria-hidden="true"></div>
		<div class="relative z-10 container pb-16 md:pb-24 pt-32">
			<div class="max-w-2xl">
				<?php if ( $faq_label !== '' ) : ?>
					<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-4 font-sans"><?php echo esc_html( $faq_label ); ?></p>
				<?php endif; ?>
				<h1 id="page-hero-heading" class="text-white text-4xl md:text-5xl lg:text-6xl mb-6 leading-tight font-serif"><?php echo esc_html( $faq_heading ); ?></h1>
				<?php if ( $faq_intro !== '' ) : ?>
					<p class="text-[#F5EDE0] text-lg md:text-xl leading-relaxed max-w-prose drop-shadow-[0_1px_2px_rgba(0,0,0,0.3)]"><?php echo esc_html( $faq_intro ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- FAQ list with category filters -->
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-labelledby="faq-list-heading">
		<div class="container max-w-3xl">
		<?php if ( $faq_list_label !== '' ) : ?>
			<p class="section-label mb-3"><?php echo esc_html( $faq_list_label ); ?></p>
		<?php endif; ?>
		<?php
		// Show a visible heading: use a custom one if set, otherwise a sensible default for this section.
		$list_heading_text    = ( $faq_list_heading !== '' && $faq_list_heading !== $faq_heading ) ? $faq_list_heading : 'Common questions';
		$list_heading_classes = 'text-3xl font-serif text-[var(--deep-teal)] mb-8';
		?>
		<h2 id="faq-list-heading" class="<?php echo esc_attr( $list_heading_classes ); ?>"><?php echo esc_html( $list_heading_text ); ?></h2>

			<!-- Category filter pills -->
			<div class="faq-filter mb-8" role="group" aria-label="Filter questions by category">
				<div class="flex flex-wrap gap-2">
					<?php foreach ( $categories as $cat_key => $cat_label ) : ?>
						<button type="button"
						        class="faq-filter-pill inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border border-[var(--deep-teal)]/20 text-[var(--deep-teal)] bg-white hover:bg-[var(--deep-teal)]/5 hover:border-[var(--deep-teal)]/40 transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2"
						        data-filter="<?php echo esc_attr( $cat_key ); ?>"
						        aria-pressed="<?php echo $cat_key === 'all' ? 'true' : 'false'; ?>">
							<?php echo esc_html( $cat_label ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Status message for screen readers -->
			<p id="faq-filter-status" class="sr-only" role="status" aria-live="polite"></p>

			<!-- FAQ accordion list -->
			<div class="space-y-3 faq-list" id="faq-list">
				<?php foreach ( $faq_pairs as $faq ) : ?>
					<details class="faq-item bg-white rounded-2xl px-8 py-1 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 group hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] transition-all duration-300 ease-out motion-reduce:transition-none"
					         data-category="<?php echo esc_attr( $faq['cat'] ); ?>">
						<summary class="text-[var(--deep-teal)] font-medium text-lg py-4 min-h-[2.75rem] cursor-pointer list-none flex items-center justify-between gap-4 [&::-webkit-details-marker]:hidden rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2">
							<span><?php echo esc_html( $faq['q'] ); ?></span>
							<span class="flex-shrink-0 text-[var(--warm-gold-text)] transition-transform group-open:rotate-180" aria-hidden="true">
								<i class="fa-solid fa-chevron-down"></i>
							</span>
						</summary>
						<div class="text-gray-600 text-base leading-relaxed pb-6">
							<?php echo wp_kses_post( wpautop( $faq['a'] ) ); ?>
						</div>
					</details>
				<?php endforeach; ?>
			</div>

			<!-- Empty state (shown by JS when no results) -->
			<p id="faq-empty-state" class="hidden text-gray-600 text-center py-8">
				No questions in this category yet. <a href="#faq-question-form" class="text-[var(--deep-teal)] hover:underline font-medium">Ask us directly</a>.
			</p>

		</div>
	</section>

	<!-- CTA -->
	<section class="py-16 md:py-20 bg-[var(--deep-teal)]" aria-labelledby="faq-cta-heading">
		<div class="container max-w-4xl">
			<div id="faq-question-form" class="rounded-3xl bg-white border border-[#E9E1D5] overflow-hidden shadow-[0_18px_44px_rgba(0,0,0,0.2)]">
				<div class="grid gap-0 lg:grid-cols-5 divide-y lg:divide-y-0 lg:divide-x divide-[#E8DFD0]">
					<div class="lg:col-span-2 bg-[#FBF8F3] px-6 py-7 md:px-8 md:py-8">
						<p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-[var(--warm-gold-text)] mb-2"><?php esc_html_e( 'Quick question form', 'restwell-retreats' ); ?></p>
						<h2 id="faq-cta-heading" class="text-[2rem] font-serif text-[var(--deep-teal)] leading-tight mb-3"><?php echo esc_html( $faq_cta_heading ); ?></h2>
						<p class="text-[#395962] text-[15px] leading-relaxed mb-3"><?php echo esc_html( $faq_cta_body ); ?></p>
						<p class="text-[#5f747b] text-sm leading-relaxed"><?php esc_html_e( 'Ask anything here and we will reply directly by email.', 'restwell-retreats' ); ?></p>
					</div>

					<div class="lg:col-span-3 px-6 py-7 md:px-8 md:py-8">
						<h3 class="text-xl md:text-2xl font-serif text-[var(--deep-teal)] mb-5"><?php esc_html_e( 'Ask a simple question', 'restwell-retreats' ); ?></h3>

						<?php if ( $faq_question_sent ) : ?>
							<p class="text-sm font-medium text-[var(--deep-teal)] bg-[var(--sea-glass)]/35 border border-[var(--sea-glass)] rounded-xl px-4 py-3 mb-4">
								<?php esc_html_e( 'Thanks — your question has been sent. We usually reply within 24 hours.', 'restwell-retreats' ); ?>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $faq_question_errors ) ) : ?>
							<div class="text-sm text-[#7a1c1c] bg-[#fef2f2] border border-[#fecaca] rounded-xl px-4 py-3 mb-4" role="alert">
								<?php foreach ( $faq_question_errors as $error ) : ?>
									<p><?php echo esc_html( $error ); ?></p>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<form method="post" action="<?php echo esc_url( get_permalink( $pid ) ); ?>#faq-question-form" class="space-y-4 text-left">
							<?php wp_nonce_field( 'restwell_faq_question', 'restwell_faq_question_nonce' ); ?>
							<input type="hidden" name="restwell_faq_question" value="1" />

							<div class="grid gap-4 md:grid-cols-2">
								<div>
									<label for="faq_q_name" class="<?php echo esc_attr( $faq_form_label_class ); ?>"><?php esc_html_e( 'Your name', 'restwell-retreats' ); ?></label>
									<input type="text" id="faq_q_name" name="faq_q_name" required value="<?php echo esc_attr( $faq_q_name ); ?>" class="<?php echo esc_attr( $faq_form_input_class ); ?>" />
								</div>

								<div>
									<label for="faq_q_email" class="<?php echo esc_attr( $faq_form_label_class ); ?>"><?php esc_html_e( 'Email address', 'restwell-retreats' ); ?></label>
									<input type="email" id="faq_q_email" name="faq_q_email" required value="<?php echo esc_attr( $faq_q_email ); ?>" class="<?php echo esc_attr( $faq_form_input_class ); ?>" />
								</div>
							</div>

							<div>
								<label for="faq_q_message" class="<?php echo esc_attr( $faq_form_label_class ); ?>"><?php esc_html_e( 'Your question', 'restwell-retreats' ); ?></label>
								<textarea id="faq_q_message" name="faq_q_message" required rows="5" class="<?php echo esc_attr( $faq_form_input_class ); ?>"><?php echo esc_textarea( $faq_q_message ); ?></textarea>
							</div>

							<button type="submit" class="btn btn-gold min-h-[46px] px-7 w-full md:w-auto">
								<?php esc_html_e( 'Send question', 'restwell-retreats' ); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
							</button>
						</form>
					</div>
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
