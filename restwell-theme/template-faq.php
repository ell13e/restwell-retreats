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
$faq_hero_image_id = (int) get_post_meta( $pid, 'faq_hero_image_id', true );
$faq_label          = get_post_meta( $pid, 'faq_label', true ) ?: 'Frequently asked questions';
$faq_heading        = get_post_meta( $pid, 'faq_heading', true ) ?: 'Questions we get asked';
$faq_intro          = get_post_meta( $pid, 'faq_intro', true ) ?: 'We have tried to cover the most common questions below. If yours isn\'t here, get in touch; we are always happy to talk things through.';

// FAQ list section: heading only shown if explicitly set and different from hero heading.
$faq_list_label   = get_post_meta( $pid, 'faq_list_label', true ) ?: 'Browse by topic';
$faq_list_heading = get_post_meta( $pid, 'faq_list_heading', true ) ?: '';

// CTA section
$faq_cta_label   = get_post_meta( $pid, 'faq_cta_label', true ) ?: '';
$faq_cta_heading = get_post_meta( $pid, 'faq_cta_heading', true ) ?: 'Still have a question?';
$faq_cta_body    = get_post_meta( $pid, 'faq_cta_body', true ) ?: 'Get in touch and we will answer honestly. We respond within 24 hours.';
$faq_cta_btn     = get_post_meta( $pid, 'faq_cta_btn', true ) ?: 'Ask us';
$faq_cta_url     = esc_url( get_post_meta( $pid, 'faq_cta_url', true ) ?: home_url( '/enquire/' ) );

$faq_question_sent   = isset( $_GET['question_sent'] ) && '1' === sanitize_text_field( wp_unslash( $_GET['question_sent'] ) );
$faq_question_errors = array();
$faq_q_name          = '';
$faq_q_email         = '';
$faq_q_message       = '';

$faq_flash_key = isset( $_GET['faq_flash'] ) ? sanitize_text_field( wp_unslash( $_GET['faq_flash'] ) ) : '';
if ( $faq_flash_key ) {
	$faq_flash = get_transient( 'restwell_faq_flash_' . $faq_flash_key );
	if ( is_array( $faq_flash ) ) {
		$faq_question_errors = isset( $faq_flash['errors'] ) && is_array( $faq_flash['errors'] ) ? $faq_flash['errors'] : array();
		$fields                = isset( $faq_flash['fields'] ) && is_array( $faq_flash['fields'] ) ? $faq_flash['fields'] : array();
		$faq_q_name            = isset( $fields['name'] ) ? sanitize_text_field( (string) $fields['name'] ) : '';
		$faq_q_email           = isset( $fields['email'] ) ? sanitize_email( (string) $fields['email'] ) : '';
		$faq_q_message         = isset( $fields['message'] ) ? sanitize_textarea_field( (string) $fields['message'] ) : '';
		delete_transient( 'restwell_faq_flash_' . $faq_flash_key );
	}
}

$faq_form_input_class = 'w-full rounded-xl border border-[#CFC2AD] bg-[#FFFEFC] px-4 py-3 text-sm text-[#1B4D5C] shadow-sm focus:outline-none focus:ring-2 focus:ring-[#A8D5D0] focus:ring-offset-2';
$faq_form_label_class = 'block text-sm font-semibold text-[#1B4D5C] mb-1.5';

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
if ( empty( $faq_pairs ) && function_exists( 'restwell_get_faq_page_default_pairs' ) ) {
	$faq_pairs = restwell_get_faq_page_default_pairs();
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

	<?php
	set_query_var(
		'args',
		array(
			'heading_id'  => 'page-hero-heading',
			'label'       => $faq_label,
			'heading'     => $faq_heading,
			'intro'       => $faq_intro,
			'media_id'    => $faq_hero_image_id,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<!-- FAQ list with category filters -->
	<section class="rw-section-y bg-[var(--bg-subtle)]" aria-labelledby="faq-list-heading">
		<div class="container max-w-3xl">
		<?php
		// Show a visible heading: use a custom one if set, otherwise a sensible default for this section.
		$list_heading_text    = ( $faq_list_heading !== '' && $faq_list_heading !== $faq_heading ) ? $faq_list_heading : 'Common questions';
		$list_heading_classes = 'text-3xl font-serif text-[var(--deep-teal)] m-0';
		?>
		<div class="rw-stack rw-mb-section">
		<?php if ( $faq_list_label !== '' ) : ?>
			<p class="section-label"><?php echo esc_html( $faq_list_label ); ?></p>
		<?php endif; ?>
		<h2 id="faq-list-heading" class="<?php echo esc_attr( $list_heading_classes ); ?>"><?php echo esc_html( $list_heading_text ); ?></h2>
		</div>

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
			<div class="space-y-4 faq-list" id="faq-list">
				<?php foreach ( $faq_pairs as $faq ) : ?>
					<details class="faq-item bg-white rounded-2xl px-8 py-1 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 group hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] transition-all duration-300 ease-out motion-reduce:transition-none"
					         data-category="<?php echo esc_attr( $faq['cat'] ); ?>">
						<summary class="text-[var(--deep-teal)] font-medium text-lg py-4 min-h-[2.75rem] cursor-pointer list-none flex items-center justify-between gap-4 [&::-webkit-details-marker]:hidden rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2">
							<span><?php echo esc_html( $faq['q'] ); ?></span>
							<span class="flex-shrink-0 text-[var(--warm-gold-text)] transition-transform duration-200 group-open:rotate-180" aria-hidden="true">
								<i class="ph-bold ph-caret-down"></i>
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

	<!-- Related guides -->
	<section class="rw-section-y--compact bg-white border-t border-gray-100" aria-labelledby="faq-related-heading">
		<div class="container max-w-3xl">
			<h2 id="faq-related-heading" class="text-2xl font-serif text-[var(--deep-teal)] mb-4"><?php esc_html_e( 'Further reading', 'restwell-retreats' ); ?></h2>
			<ul class="space-y-3 text-gray-700">
				<li>
					<a href="<?php echo esc_url( home_url( '/direct-payment-holiday-accommodation/' ) ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline">
						<?php esc_html_e( 'How to use your direct payment for a holiday', 'restwell-retreats' ); ?>
					</a>
					<span class="text-gray-500">: <?php esc_html_e( 'funding your care support during a stay.', 'restwell-retreats' ); ?></span>
				</li>
				<li>
					<a href="<?php echo esc_url( home_url( '/accessible-beaches-kent-coast/' ) ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline">
						<?php esc_html_e( 'Accessible beaches and coastal walks in Kent', 'restwell-retreats' ); ?>
					</a>
					<span class="text-gray-500">: <?php esc_html_e( 'what to expect at the beaches closest to the property.', 'restwell-retreats' ); ?></span>
				</li>
				<li>
					<a href="<?php echo esc_url( home_url( '/carers-respite-holiday-guide/' ) ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline">
						<?php esc_html_e( 'Carers taking holidays: respite rights and funding', 'restwell-retreats' ); ?>
					</a>
					<span class="text-gray-500">: <?php esc_html_e( 'how to arrange and fund a break for a carer.', 'restwell-retreats' ); ?></span>
				</li>
			</ul>
		</div>
	</section>

	<!-- CTA -->
	<section class="rw-section-y--cta bg-[var(--deep-teal)]" aria-labelledby="faq-cta-heading">
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
								<?php esc_html_e( 'Thanks. Your question has been sent to our team. We usually reply within 24 hours.', 'restwell-retreats' ); ?>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $faq_question_errors ) ) : ?>
							<div class="text-sm text-[#7a1c1c] bg-[#fef2f2] border border-[#fecaca] rounded-xl px-4 py-3 mb-4" role="alert">
								<?php foreach ( $faq_question_errors as $error ) : ?>
									<p><?php echo esc_html( $error ); ?></p>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<form method="post" action="<?php echo esc_url( get_permalink( $pid ) ); ?>#faq-question-form" class="space-y-4 text-left relative" novalidate>
							<?php wp_nonce_field( 'restwell_faq_question', 'restwell_faq_question_nonce' ); ?>
							<input type="hidden" name="restwell_faq_question" value="1" />
							<input type="hidden" name="restwell_faq_page_id" value="<?php echo esc_attr( (string) $pid ); ?>" />
							<input type="hidden" name="restwell_form_opened_at" value="" data-restwell-form-opened />
							<div class="absolute overflow-hidden w-px h-px -m-px p-0 border-0 [clip:rect(0,0,0,0)]" aria-hidden="true">
								<label for="faq_q_website"><?php esc_html_e( 'Leave this field empty', 'restwell-retreats' ); ?></label>
								<input type="text" name="faq_q_website" id="faq_q_website" value="" tabindex="-1" autocomplete="off" />
							</div>

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

							<p class="text-xs text-[#5f747b] leading-relaxed"><?php esc_html_e( 'We use your details only to answer you. We never sell contact information.', 'restwell-retreats' ); ?></p>
							<button type="submit" class="btn btn-gold min-h-[48px] px-7 w-full md:w-auto">
								<?php esc_html_e( 'Send my question', 'restwell-retreats' ); ?> <i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>
<?php get_footer(); ?>
