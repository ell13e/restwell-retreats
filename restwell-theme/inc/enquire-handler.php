<?php
/**
 * Enquiry form submission handler. Sends email to admin and redirects with ?sent=1.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RESTWELL_ENQUIRE_NONCE_ACTION = 'restwell_enquire_submit';
const RESTWELL_ENQUIRE_NONCE_NAME   = 'restwell_enquire_nonce';

/**
 * Process enquiry form POST: validate, send email, redirect.
 */
function restwell_handle_enquire_submit() {
	if ( ! isset( $_POST['restwell_enquire'] ) || ! isset( $_POST[ RESTWELL_ENQUIRE_NONCE_NAME ] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ RESTWELL_ENQUIRE_NONCE_NAME ] ) ), RESTWELL_ENQUIRE_NONCE_ACTION ) ) {
		return;
	}

	$name    = isset( $_POST['enq_name'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_name'] ) ) : '';
	$email   = isset( $_POST['enq_email'] ) ? sanitize_email( wp_unslash( $_POST['enq_email'] ) ) : '';
	$message = isset( $_POST['enq_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['enq_message'] ) ) : '';
	if ( ! $name || ! $email || ! $message ) {
		return;
	}

	$phone    = isset( $_POST['enq_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_phone'] ) ) : '';
	$dates    = isset( $_POST['enq_dates'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_dates'] ) ) : '';
	$guests   = isset( $_POST['enq_guests'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_guests'] ) ) : '';
	$care     = isset( $_POST['enq_care'] ) ? sanitize_textarea_field( wp_unslash( $_POST['enq_care'] ) ) : '';
	$access   = isset( $_POST['enq_accessibility'] ) ? sanitize_textarea_field( wp_unslash( $_POST['enq_accessibility'] ) ) : '';
	$funding  = isset( $_POST['enq_funding'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_funding'] ) ) : '';
	$urgent   = ! empty( $_POST['enq_urgent'] );
	$contact_pref = isset( $_POST['enq_contact_preference'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_contact_preference'] ) ) : '';
	$pref_time = isset( $_POST['enq_preferred_time'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_preferred_time'] ) ) : '';

	$body = "Name: $name\nEmail: $email\n";
	if ( $phone ) {
		$body .= "Phone: $phone\n";
	}
	if ( $contact_pref ) {
		$body .= "Preferred contact: $contact_pref\n";
	}
	if ( $pref_time ) {
		$body .= "Best time to call: $pref_time\n";
	}
	if ( $dates ) {
		$body .= "Preferred dates: $dates\n";
	}
	if ( $guests ) {
		$body .= "Number of guests: $guests\n";
	}
	if ( $funding ) {
		$body .= "Funding type: $funding\n";
	}
	if ( $urgent ) {
		$body .= "\n*** URGENT — prioritised callback requested ***\n";
	}
	if ( $care ) {
		$body .= "\nCare requirements:\n$care\n";
	}
	if ( $access ) {
		$body .= "\nAccessibility needs:\n$access\n";
	}
	$body .= "\nMessage:\n$message";

	$to      = get_option( 'admin_email' );
	$subject = sprintf( '[Restwell Retreats] %sEnquiry from %s', $urgent ? 'URGENT — ' : '', $name );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );
	wp_mail( $to, $subject, $body, $headers );

	$redirect = isset( $_POST['enq_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['enq_redirect'] ) ) : '';
	if ( ! $redirect ) {
		$redirect = wp_get_referer() ?: home_url( '/enquire/' );
	}
	$args = array( 'sent' => '1' );
	if ( $urgent ) {
		$args['urgent'] = '1';
	}
	wp_safe_redirect( add_query_arg( $args, $redirect ) );
	exit;
}
add_action( 'template_redirect', 'restwell_handle_enquire_submit', 5 );
