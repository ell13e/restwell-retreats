<?php
/**
 * Template Name: Guest Arrival Guide
 *
 * Email-gated arrival information delivered via a 6-digit OTP.
 *
 * Flow:
 *  1. Email form       — guest enters their email address.
 *  2. OTP form         — if approved, a one-time code is emailed and entered here.
 *  3. Guide content    — session-gated, full arrival information.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Prevent the browser and any proxy from caching this page.
nocache_headers();

// Session is started in inc/guest-guide.php on `template_redirect` (priority 1),
// scoped to this template only. Session is live before any output is sent.

// -------------------------------------------------------------------------
// Form processing
// -------------------------------------------------------------------------

$error   = '';
$notice  = '';

// ---------- Step 1: email submitted ----------------------------------------
if (
	isset( $_POST['restwell_gg_step'], $_POST['restwell_gg_nonce'] ) &&
	'email' === $_POST['restwell_gg_step'] &&
	wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['restwell_gg_nonce'] ) ),
		'restwell_gg_email_step'
	)
) {
	$submitted_email = isset( $_POST['gg_email'] ) ? sanitize_email( wp_unslash( $_POST['gg_email'] ) ) : '';

	if ( '' === $submitted_email || ! is_email( $submitted_email ) ) {
		$error = __( 'Please enter a valid email address.', 'restwell-retreats' );
	} elseif ( ! restwell_is_approved_email( $submitted_email ) ) {
		$error = __( 'Sorry, we do not recognise that email address. Please use the address your booking confirmation was sent to.', 'restwell-retreats' );
	} else {
		restwell_send_guide_otp( $submitted_email );
		$_SESSION['gg_pending_email'] = $submitted_email;
		$_SESSION['gg_otp_sent']      = time();
		unset( $_SESSION['gg_verified'] );
	}
}

// ---------- Step 2: OTP submitted ------------------------------------------
if (
	isset( $_POST['restwell_gg_step'], $_POST['restwell_gg_nonce'] ) &&
	'otp' === $_POST['restwell_gg_step'] &&
	wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['restwell_gg_nonce'] ) ),
		'restwell_gg_otp_step'
	)
) {
	$submitted_code  = isset( $_POST['gg_code'] ) ? sanitize_text_field( wp_unslash( $_POST['gg_code'] ) ) : '';
	$pending_email   = isset( $_SESSION['gg_pending_email'] ) ? (string) $_SESSION['gg_pending_email'] : '';

	if ( '' === $submitted_code || '' === $pending_email ) {
		$error = __( 'Your session has expired. Please start again.', 'restwell-retreats' );
		unset( $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
	} elseif ( restwell_verify_guide_otp( $pending_email, $submitted_code ) ) {
		$_SESSION['gg_verified']       = true;
		$_SESSION['gg_verified_email'] = $pending_email;
		unset( $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
	} else {
		$error = __( 'That code is not correct, or it has expired. Please try again or request a new code.', 'restwell-retreats' );
	}
}

// ---------- "I've read the guide" confirmation ------------------------------
if (
	! empty( $_POST['restwell_gg_step'] ) && 'confirm_read' === $_POST['restwell_gg_step']
	&& isset( $_POST['restwell_gg_nonce'] )
	&& wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['restwell_gg_nonce'] ) ),
		'restwell_gg_confirm_read'
	)
	&& ! empty( $_SESSION['gg_verified'] )
	&& ! empty( $_SESSION['gg_verified_email'] )
) {
	if ( function_exists( 'restwell_guest_guide_confirm_read' ) ) {
		restwell_guest_guide_confirm_read( (string) $_SESSION['gg_verified_email'] );
	}
	wp_safe_redirect( add_query_arg( 'gg_confirmed', '1', get_permalink() ) . '#gg-read-confirmation' );
	exit;
}

// ---------- Reset -----------------------------------------------------------
if ( isset( $_GET['gg_reset'] ) && '1' === $_GET['gg_reset'] ) {
	unset( $_SESSION['gg_verified'], $_SESSION['gg_verified_email'], $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
	wp_safe_redirect( get_permalink() );
	exit;
}

// ---------- Determine current UI state -------------------------------------
$is_verified   = ! empty( $_SESSION['gg_verified'] );
$pending_email = isset( $_SESSION['gg_pending_email'] ) ? (string) $_SESSION['gg_pending_email'] : '';
$otp_sent      = ! empty( $pending_email );
$show_otp_form = $otp_sent && ! $is_verified;
$show_email_form = ! $is_verified && ! $otp_sent;

// -------------------------------------------------------------------------
// Meta field retrieval
// -------------------------------------------------------------------------

$pid = get_the_ID();

$gg_welcome   = (string) get_post_meta( $pid, 'gg_welcome_message',  true );
$gg_address   = (string) get_post_meta( $pid, 'gg_address',          true );
$gg_checkin   = (string) get_post_meta( $pid, 'gg_checkin_time',     true );
$gg_checkout  = (string) get_post_meta( $pid, 'gg_checkout_time',    true );
$gg_keysafe          = (string) get_post_meta( $pid, 'gg_keysafe_code',      true );
$gg_departure_notes  = (string) get_post_meta( $pid, 'gg_departure_notes',  true );
$gg_nearest_ae_url   = (string) get_post_meta( $pid, 'gg_nearest_ae_map_url', true );
$gg_door      = (string) get_post_meta( $pid, 'gg_door_instructions', true );
$gg_wifi_name = (string) get_post_meta( $pid, 'gg_wifi_name',        true );
$gg_wifi_pass = (string) get_post_meta( $pid, 'gg_wifi_password',    true );
$gg_parking   = (string) get_post_meta( $pid, 'gg_parking_info',     true );
$gg_host        = (string) get_post_meta( $pid, 'gg_host_contact',     true );
$gg_house_rules = (string) get_post_meta( $pid, 'gg_house_rules',      true );
$gg_local_info  = (string) get_post_meta( $pid, 'gg_local_info',       true );
$gg_emergency   = array(
	__( 'Emergency services', 'restwell-retreats' )      => (string) get_post_meta( $pid, 'gg_emergency_services',  true ),
	__( 'NHS (non-emergency)', 'restwell-retreats' )      => (string) get_post_meta( $pid, 'gg_nhs_number',          true ),
	__( 'Police (non-emergency)', 'restwell-retreats' )   => (string) get_post_meta( $pid, 'gg_police_number',       true ),
	__( 'Nearest A&E', 'restwell-retreats' )          => (string) get_post_meta( $pid, 'gg_nearest_ae',          true ),
	__( 'Property maintenance', 'restwell-retreats' )     => (string) get_post_meta( $pid, 'gg_maintenance_contact', true ),
	__( 'Out-of-hours maintenance', 'restwell-retreats' ) => (string) get_post_meta( $pid, 'gg_maintenance_oos',     true ),
	__( 'Gas emergency', 'restwell-retreats' )            => (string) get_post_meta( $pid, 'gg_gas_oos',             true ),
);

// Common input / label classes (mirroring template-enquire.php).
$input_class = 'w-full px-4 py-3 rounded-xl border border-[#E8DFD0] bg-[#F5EDE0]/50 text-[#1B4D5C] text-base focus:border-[#A8D5D0] focus:ring-2 focus:ring-[#A8D5D0]/30';
$label_class = 'block text-sm font-medium text-[#1B4D5C] mb-1.5';

// -------------------------------------------------------------------------
// Template output
// -------------------------------------------------------------------------

get_header();
?>
<main class="flex-1" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<!-- Hero -->
	<section
		class="hero relative flex items-end overflow-hidden min-h-[28rem] bg-[var(--deep-teal)]"
		aria-labelledby="gg-hero-heading"
	>
		<div
			class="absolute inset-0 bg-gradient-to-t from-[var(--deep-teal)]/90 via-[var(--deep-teal)]/50 to-transparent -z-[5]"
			aria-hidden="true"
		></div>
		<div class="relative z-10 container pb-16 md:pb-20 pt-28">
			<div class="max-w-2xl">
				<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-4 font-sans">
					<?php esc_html_e( 'Guest information', 'restwell-retreats' ); ?>
				</p>
				<h1 id="gg-hero-heading" class="text-white text-4xl md:text-5xl mb-6 leading-tight font-serif">
					<?php esc_html_e( 'Your arrival guide', 'restwell-retreats' ); ?>
				</h1>
				<p class="text-[#F5EDE0] text-lg leading-relaxed max-w-prose drop-shadow-[0_1px_2px_rgba(0,0,0,0.3)]">
					<?php esc_html_e( 'Everything you need for a comfortable stay, available to verified guests only.', 'restwell-retreats' ); ?>
				</p>
			</div>
		</div>
	</section>

	<!-- Gate / guide section -->
	<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-label="<?php esc_attr_e( 'Guest guide', 'restwell-retreats' ); ?>">
		<div class="container max-w-3xl">

			<?php if ( $show_email_form ) : ?>
			<!-- ===== State 1: Email entry ===== -->
			<div class="bg-white rounded-2xl p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
				<h2 class="text-2xl font-serif text-[var(--deep-teal)] mb-2">
					<?php esc_html_e( 'Verify your identity', 'restwell-retreats' ); ?>
				</h2>
				<p class="text-sm text-[var(--muted-grey)] mb-8 leading-relaxed">
					<?php esc_html_e( 'Enter the email address we have on file for your booking. We will send you a one-time code to confirm it is you.', 'restwell-retreats' ); ?>
				</p>

				<?php if ( '' !== $error ) : ?>
					<div class="rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 mb-6" role="alert">
						<?php echo esc_html( $error ); ?>
					</div>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url( get_permalink() ); ?>" novalidate>
					<?php wp_nonce_field( 'restwell_gg_email_step', 'restwell_gg_nonce' ); ?>
					<input type="hidden" name="restwell_gg_step" value="email" />

					<div class="space-y-5">
						<div>
							<label for="gg_email" class="<?php echo esc_attr( $label_class ); ?>">
								<?php esc_html_e( 'Email address', 'restwell-retreats' ); ?>
								<span class="text-[#D4A853]" aria-hidden="true">*</span>
							</label>
							<input
								type="email"
								id="gg_email"
								name="gg_email"
								required
								aria-required="true"
								autocomplete="email"
								class="<?php echo esc_attr( $input_class ); ?>"
								placeholder="jane@example.com"
							/>
						</div>
						<div class="pt-2">
							<button type="submit" class="btn btn-primary w-full">
								<?php esc_html_e( 'Send my access code', 'restwell-retreats' ); ?>
								<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
							</button>
						</div>
					</div>
				</form>
			</div>

			<?php elseif ( $show_otp_form ) : ?>
			<!-- ===== State 2: OTP entry ===== -->
			<div class="bg-white rounded-2xl p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
				<h2 class="text-2xl font-serif text-[var(--deep-teal)] mb-2">
					<?php esc_html_e( 'Enter your access code', 'restwell-retreats' ); ?>
				</h2>
				<p class="text-sm text-[var(--muted-grey)] mb-8 leading-relaxed">
					<?php
					printf(
						/* translators: %s — partially masked email address */
						esc_html__( 'We have sent a 6-digit code to %s. It will expire in 30 minutes.', 'restwell-retreats' ),
						'<strong>' . esc_html( restwell_mask_guide_email( $pending_email ) ) . '</strong>'
					);
					?>
				</p>

				<?php if ( '' !== $error ) : ?>
					<div class="rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 mb-6" role="alert">
						<?php echo esc_html( $error ); ?>
					</div>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url( get_permalink() ); ?>" novalidate>
					<?php wp_nonce_field( 'restwell_gg_otp_step', 'restwell_gg_nonce' ); ?>
					<input type="hidden" name="restwell_gg_step" value="otp" />

					<div class="space-y-5">
						<div>
							<label for="gg_code" class="<?php echo esc_attr( $label_class ); ?>">
								<?php esc_html_e( '6-digit code', 'restwell-retreats' ); ?>
								<span class="text-[#D4A853]" aria-hidden="true">*</span>
							</label>
							<input
								type="text"
								id="gg_code"
								name="gg_code"
								required
								aria-required="true"
								maxlength="6"
								inputmode="numeric"
								autocomplete="one-time-code"
								pattern="[0-9]{6}"
								class="<?php echo esc_attr( $input_class ); ?> tracking-widest text-center text-xl font-mono"
								placeholder="123456"
							/>
						</div>
						<div class="pt-2">
							<button type="submit" class="btn btn-primary w-full">
								<?php esc_html_e( 'Access my guide', 'restwell-retreats' ); ?>
								<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
							</button>
						</div>
					</div>
				</form>

				<p class="text-xs text-[var(--muted-grey)] text-center mt-6">
					<?php esc_html_e( 'Wrong address or no code arrived?', 'restwell-retreats' ); ?>
					<a
						href="<?php echo esc_url( add_query_arg( 'gg_reset', '1', get_permalink() ) ); ?>"
						class="text-[var(--deep-teal)] hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2 rounded"
					><?php esc_html_e( 'Start again', 'restwell-retreats' ); ?></a>
				</p>
			</div>

			<?php elseif ( $is_verified ) : ?>
			<!-- ===== State 3: Guest guide content ===== -->

				<!-- Welcome card — full width -->
				<?php if ( '' !== $gg_welcome ) : ?>
				<div class="bg-[var(--deep-teal)] rounded-2xl p-8 md:p-10 text-[#F5EDE0] mb-8">
					<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-3 font-sans">
						<?php esc_html_e( 'Welcome', 'restwell-retreats' ); ?>
					</p>
					<div class="prose prose-invert max-w-none text-[#F5EDE0] leading-relaxed">
						<?php echo wp_kses_post( nl2br( esc_html( $gg_welcome ) ) ); ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- 2-column info grid -->
				<div class="grid md:grid-cols-2 gap-6 mb-6">

					<!-- Arrival card -->
					<?php if ( $gg_address || $gg_checkin || $gg_checkout ) : ?>
					<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
						<h2 class="text-lg font-serif text-[var(--deep-teal)] mb-5 pb-3 border-b border-gray-100">
							<i class="fa-regular fa-calendar-check mr-2 text-[var(--warm-gold-text)] text-base" aria-hidden="true"></i>
							<?php esc_html_e( 'Arrival details', 'restwell-retreats' ); ?>
						</h2>
						<dl class="space-y-4 text-sm">
							<?php if ( $gg_address ) : ?>
							<div>
								<dt class="font-medium text-[var(--deep-teal)] mb-0.5"><?php esc_html_e( 'Address', 'restwell-retreats' ); ?></dt>
								<dd class="text-gray-600 leading-relaxed"><?php echo wp_kses_post( nl2br( esc_html( $gg_address ) ) ); ?></dd>
							</div>
							<?php endif; ?>
							<?php if ( $gg_checkin ) : ?>
							<div>
								<dt class="font-medium text-[var(--deep-teal)] mb-0.5"><?php esc_html_e( 'Check-in', 'restwell-retreats' ); ?></dt>
								<dd class="text-gray-600"><?php echo esc_html( $gg_checkin ); ?></dd>
							</div>
							<?php endif; ?>
							<?php if ( $gg_checkout ) : ?>
							<div>
								<dt class="font-medium text-[var(--deep-teal)] mb-0.5"><?php esc_html_e( 'Check-out', 'restwell-retreats' ); ?></dt>
								<dd class="text-gray-600"><?php echo esc_html( $gg_checkout ); ?></dd>
							</div>
							<?php endif; ?>
						</dl>
					</div>
					<?php endif; ?>

					<!-- Getting in card -->
					<?php if ( $gg_keysafe || $gg_door ) : ?>
					<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
						<h2 class="text-lg font-serif text-[var(--deep-teal)] mb-5 pb-3 border-b border-gray-100">
							<i class="fa-solid fa-key mr-2 text-[var(--warm-gold-text)] text-base" aria-hidden="true"></i>
							<?php esc_html_e( 'Getting in', 'restwell-retreats' ); ?>
						</h2>
						<dl class="space-y-4 text-sm">
						<?php if ( $gg_keysafe ) : ?>
							<div>
								<dt class="font-medium text-[var(--deep-teal)] mb-0.5"><?php esc_html_e( 'Key safe code', 'restwell-retreats' ); ?></dt>
								<dd class="text-gray-600 font-mono text-base tracking-widest relative">
									<span id="gg-keysafe-value"
									      style="filter:blur(6px);transition:filter .25s;"
									      class="select-none"
									      aria-label="<?php esc_attr_e( 'Hidden key safe code — tap to reveal', 'restwell-retreats' ); ?>">
										<?php echo esc_html( $gg_keysafe ); ?>
									</span>
									<button type="button"
									        id="gg-keysafe-reveal"
									        class="ml-3 text-xs font-sans font-medium text-[var(--deep-teal)] underline hover:no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded"
									        aria-controls="gg-keysafe-value"
									        aria-expanded="false">
										<?php esc_html_e( 'Tap to reveal', 'restwell-retreats' ); ?>
									</button>
								</dd>
							</div>
						<?php endif; ?>
							<?php if ( $gg_door ) : ?>
							<div>
								<dt class="font-medium text-[var(--deep-teal)] mb-0.5"><?php esc_html_e( 'Instructions', 'restwell-retreats' ); ?></dt>
								<dd class="text-gray-600 leading-relaxed"><?php echo wp_kses_post( nl2br( esc_html( $gg_door ) ) ); ?></dd>
							</div>
							<?php endif; ?>
						</dl>
					</div>
					<?php endif; ?>

					<!-- WiFi card -->
					<?php if ( $gg_wifi_name || $gg_wifi_pass ) : ?>
					<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
						<h2 class="text-lg font-serif text-[var(--deep-teal)] mb-5 pb-3 border-b border-gray-100">
							<i class="fa-solid fa-wifi mr-2 text-[var(--warm-gold-text)] text-base" aria-hidden="true"></i>
							<?php esc_html_e( 'WiFi', 'restwell-retreats' ); ?>
						</h2>
						<dl class="space-y-4 text-sm">
							<?php if ( $gg_wifi_name ) : ?>
							<div>
								<dt class="font-medium text-[var(--deep-teal)] mb-0.5"><?php esc_html_e( 'Network', 'restwell-retreats' ); ?></dt>
								<dd class="text-gray-600 font-mono"><?php echo esc_html( $gg_wifi_name ); ?></dd>
							</div>
							<?php endif; ?>
							<?php if ( $gg_wifi_pass ) : ?>
							<div>
								<dt class="font-medium text-[var(--deep-teal)] mb-0.5"><?php esc_html_e( 'Password', 'restwell-retreats' ); ?></dt>
								<dd class="text-gray-600 font-mono break-all"><?php echo esc_html( $gg_wifi_pass ); ?></dd>
							</div>
							<?php endif; ?>
						</dl>
					</div>
					<?php endif; ?>

					<!-- Parking card -->
					<?php if ( $gg_parking ) : ?>
					<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
						<h2 class="text-lg font-serif text-[var(--deep-teal)] mb-5 pb-3 border-b border-gray-100">
							<i class="fa-solid fa-car mr-2 text-[var(--warm-gold-text)] text-base" aria-hidden="true"></i>
							<?php esc_html_e( 'Parking', 'restwell-retreats' ); ?>
						</h2>
						<div class="text-sm text-gray-600 leading-relaxed">
							<?php echo wp_kses_post( nl2br( esc_html( $gg_parking ) ) ); ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- House rules card -->
				<?php if ( $gg_house_rules !== '' ) : ?>
				<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
					<h2 class="text-lg font-serif text-[var(--deep-teal)] mb-5 pb-3 border-b border-gray-100">
						<i class="fa-solid fa-list-check mr-2 text-[var(--warm-gold-text)] text-base" aria-hidden="true"></i>
						<?php esc_html_e( 'House rules', 'restwell-retreats' ); ?>
					</h2>
					<div class="text-sm text-gray-600 leading-relaxed">
						<?php echo wp_kses_post( nl2br( esc_html( $gg_house_rules ) ) ); ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- Departure checklist card -->
				<?php if ( $gg_departure_notes !== '' ) : ?>
				<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
					<h2 class="text-lg font-serif text-[var(--deep-teal)] mb-5 pb-3 border-b border-gray-100">
						<i class="fa-regular fa-circle-check mr-2 text-[var(--warm-gold-text)] text-base" aria-hidden="true"></i>
						<?php esc_html_e( 'Before you leave', 'restwell-retreats' ); ?>
					</h2>
					<div class="text-sm text-gray-600 leading-relaxed">
						<?php echo wp_kses_post( nl2br( esc_html( $gg_departure_notes ) ) ); ?>
					</div>
				</div>
				<?php endif; ?>

			<!-- Local area card -->
				<?php if ( $gg_local_info !== '' ) : ?>
				<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
					<h2 class="text-lg font-serif text-[var(--deep-teal)] mb-5 pb-3 border-b border-gray-100">
						<i class="fa-solid fa-map-location-dot mr-2 text-[var(--warm-gold-text)] text-base" aria-hidden="true"></i>
						<?php esc_html_e( 'Local area', 'restwell-retreats' ); ?>
					</h2>
					<div class="text-sm text-gray-600 leading-relaxed">
						<?php echo wp_kses_post( nl2br( esc_html( $gg_local_info ) ) ); ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- Emergency information card -->
				<?php if ( array_filter( $gg_emergency ) ) : ?>
				<div class="bg-white rounded-2xl p-7 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
					<h2 class="text-lg font-serif text-[var(--deep-teal)] mb-5 pb-3 border-b border-gray-100">
						<i class="fa-solid fa-triangle-exclamation mr-2 text-[var(--warm-gold-text)] text-base" aria-hidden="true"></i>
						<?php esc_html_e( 'Emergency information', 'restwell-retreats' ); ?>
					</h2>
				<ul class="space-y-2 text-sm">
					<?php
					$ae_label = __( 'Nearest A&E', 'restwell-retreats' );
					foreach ( $gg_emergency as $label => $value ) :
						if ( '' === $value ) {
							continue;
						}
						// Auto-link values that look like phone numbers.
						$is_phone = (bool) preg_match( '/^[\d\s\+\(\)\-\.]+$/', trim( $value ) );
						if ( $is_phone ) {
							$tel     = preg_replace( '/[^\d\+]/', '', $value );
							$display = '<a href="tel:' . esc_attr( $tel ) . '" class="text-[var(--deep-teal)] underline hover:no-underline">' . esc_html( $value ) . '</a>';
						} else {
							$display = esc_html( $value );
						}
						// For A&E, append a Maps link if the option is set.
						if ( $label === $ae_label && $gg_nearest_ae_url ) {
							$display .= ' <a href="' . esc_url( $gg_nearest_ae_url ) . '" target="_blank" rel="noopener noreferrer" class="text-xs text-[var(--muted-grey)] hover:text-[var(--deep-teal)] underline ml-1" aria-label="' . esc_attr__( 'Open A&E on Google Maps (opens in new tab)', 'restwell-retreats' ) . '">' . esc_html__( 'View on Maps', 'restwell-retreats' ) . '<span class="sr-only"> ' . esc_html__( '(opens in new tab)', 'restwell-retreats' ) . '</span></a>';
						}
					?>
						<li>
							<span class="font-medium text-[var(--deep-teal)]"><?php echo esc_html( $label ); ?>:</span>
							<?php echo wp_kses_post( $display ); ?>
						</li>
					<?php endforeach; ?>
				</ul>
				</div>
				<?php endif; ?>

			</div><!-- /grid -->

			<!-- Host contact card — full width -->
				<?php if ( $gg_host ) : ?>
				<div class="bg-white rounded-2xl p-7 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
					<h2 class="text-lg font-serif text-[var(--deep-teal)] mb-3">
						<i class="fa-regular fa-circle-user mr-2 text-[var(--warm-gold-text)] text-base" aria-hidden="true"></i>
						<?php esc_html_e( 'Your host', 'restwell-retreats' ); ?>
					</h2>
					<p class="text-gray-600 text-sm leading-relaxed"><?php echo wp_kses_post( nl2br( esc_html( $gg_host ) ) ); ?></p>
				</div>
				<?php endif; ?>

				<!-- Print guide button -->
				<div class="text-center mt-10 no-print">
					<button type="button" onclick="window.print()"
					        class="inline-flex items-center gap-2 text-xs font-medium text-[var(--muted-grey)] hover:text-[var(--deep-teal)] transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded px-3 py-1">
						<i class="fa-solid fa-print text-sm" aria-hidden="true"></i>
						<?php esc_html_e( 'Print this guide', 'restwell-retreats' ); ?>
					</button>
				</div>

			<!-- I've read the guide confirmation -->
				<?php
				$gg_guest_row = isset( $_SESSION['gg_verified_email'] )
					? restwell_get_guest_by_email( $_SESSION['gg_verified_email'] )
					: null;
				$already_confirmed = $gg_guest_row && ! empty( $gg_guest_row->confirmed_at );
				?>
				<?php if ( ! $already_confirmed ) : ?>
				<div class="mt-8 bg-[var(--bg-subtle)] rounded-2xl p-6 border border-gray-100 text-center no-print">
					<p class="text-sm text-[var(--muted-grey)] mb-4">
						<?php esc_html_e( "Once you've read through your guide, let us know.", 'restwell-retreats' ); ?>
					</p>
					<?php if ( isset( $_GET['gg_confirmed'] ) ) : ?>
						<p class="text-sm font-medium text-green-700">
							<?php esc_html_e( "Thank you — we've recorded that you've read the guide.", 'restwell-retreats' ); ?>
						</p>
					<?php else : ?>
					<form method="post" action="<?php echo esc_url( get_permalink() ); ?>">
						<?php wp_nonce_field( 'restwell_gg_confirm_read', 'restwell_gg_nonce' ); ?>
						<input type="hidden" name="restwell_gg_step" value="confirm_read" />
						<button type="submit" class="btn btn-primary">
							<i class="fa-solid fa-check mr-1" aria-hidden="true"></i>
							<?php esc_html_e( "I've read the guide", 'restwell-retreats' ); ?>
						</button>
					</form>
					<?php endif; ?>
				</div>
				<?php else : ?>
				<p class="text-center mt-8 text-xs text-green-700 no-print">
					<i class="fa-solid fa-circle-check mr-1" aria-hidden="true"></i>
					<?php esc_html_e( 'You confirmed reading this guide.', 'restwell-retreats' ); ?>
				</p>
				<?php endif; ?>

			<!-- Sign out link -->
				<p class="text-center mt-6 text-xs text-[var(--muted-grey)] no-print">
					<?php esc_html_e( 'Finished reading?', 'restwell-retreats' ); ?>
					<a
						href="<?php echo esc_url( add_query_arg( 'gg_reset', '1', get_permalink() ) ); ?>"
						class="text-[var(--deep-teal)] hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2 rounded"
					><?php esc_html_e( 'Sign out of the guide', 'restwell-retreats' ); ?></a>
				</p>

			<?php endif; ?>

		</div>
	</section>

</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
<style>
@media print {
	header, footer, nav, .no-print,
	#gg-hero-heading, section.hero,
	.breadcrumb, #wpadminbar {
		display: none !important;
	}
	body { font-size: 12pt; }
	.container { max-width: 100% !important; padding: 0 !important; }
	a[href]::after { content: none !important; }
}
</style>
<script>
(function () {
	'use strict';
	var btn   = document.getElementById( 'gg-keysafe-reveal' );
	var value = document.getElementById( 'gg-keysafe-value' );
	if ( ! btn || ! value ) return;
	btn.addEventListener( 'click', function () {
		var revealed = btn.getAttribute( 'aria-expanded' ) === 'true';
		if ( revealed ) {
			value.style.filter = 'blur(6px)';
			btn.setAttribute( 'aria-expanded', 'false' );
			btn.textContent = '<?php echo esc_js( __( 'Tap to reveal', 'restwell-retreats' ) ); ?>';
		} else {
			value.style.filter = 'none';
			btn.setAttribute( 'aria-expanded', 'true' );
			btn.textContent = '<?php echo esc_js( __( 'Hide', 'restwell-retreats' ) ); ?>';
		}
	} );
} )();
</script>
