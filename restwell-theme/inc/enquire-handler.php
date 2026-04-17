<?php
/**
 * Enquiry form submission handler: validate, persist to CRM, email notify address, acknowledgement, redirect.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RESTWELL_ENQUIRE_NONCE_ACTION = 'restwell_enquire_submit';
const RESTWELL_ENQUIRE_NONCE_NAME   = 'restwell_enquire_nonce';

/**
 * Validate optional preferred date fields (site timezone “today”).
 *
 * @param string $date_from Y-m-d or empty.
 * @param string $date_to   Y-m-d or empty.
 * @return string[] Error messages (empty if OK).
 */
function restwell_validate_enquiry_dates( string $date_from, string $date_to ): array {
	$errors = array();
	$today  = current_time( 'Y-m-d' );

	$valid_ymd = static function ( string $d ): bool {
		return (bool) preg_match( '/^\d{4}-\d{2}-\d{2}$/', $d );
	};

	if ( '' !== $date_from ) {
		if ( ! $valid_ymd( $date_from ) ) {
			$errors[] = __( 'Please use a valid start date.', 'restwell-retreats' );
		} elseif ( $date_from < $today ) {
			$errors[] = __( 'Preferred start date cannot be in the past.', 'restwell-retreats' );
		}
	}
	if ( '' !== $date_to ) {
		if ( ! $valid_ymd( $date_to ) ) {
			$errors[] = __( 'Please use a valid end date.', 'restwell-retreats' );
		} elseif ( '' === $date_from && $date_to < $today ) {
			$errors[] = __( 'Preferred end date cannot be in the past.', 'restwell-retreats' );
		} elseif ( '' !== $date_from && $valid_ymd( $date_from ) && $date_to < $date_from ) {
			$errors[] = __( 'End date must be on or after the start date.', 'restwell-retreats' );
		}
	}
	return $errors;
}

/**
 * Redirect back to the enquiry form with validation messages and field values.
 *
 * @param string               $redirect Base URL.
 * @param array<int, string>   $errors   Error strings.
 * @param array<string, mixed> $fields   Raw-ish field values for repopulation.
 */
function restwell_enquire_redirect_flash( string $redirect, array $errors, array $fields ): void {
	$key = wp_generate_password( 12, false, false );
	set_transient(
		'restwell_enq_flash_' . $key,
		array(
			'errors' => $errors,
			'fields' => $fields,
		),
		300
	);
	wp_safe_redirect( add_query_arg( 'enq_flash', rawurlencode( $key ), $redirect ) . '#enq-form-heading' );
	exit;
}

/**
 * Map funding slug to readable label for email body.
 *
 * @param string $slug Form value.
 * @return string
 */
function restwell_enquiry_funding_label( string $slug ): string {
	$labels = array(
		'self'   => __( 'Self-funding', 'restwell-retreats' ),
		'kcc'    => __( 'Kent County Council (KCC)', 'restwell-retreats' ),
		'chc'    => __( 'NHS Continuing Healthcare (CHC)', 'restwell-retreats' ),
		'direct' => __( 'Direct payments', 'restwell-retreats' ),
	);
	return $labels[ $slug ] ?? $slug;
}

/**
 * Process enquiry form POST: validate, save CRM, send emails, redirect.
 */
function restwell_handle_enquire_submit(): void {
	if ( ! isset( $_POST['restwell_enquire'] ) || ! isset( $_POST[ RESTWELL_ENQUIRE_NONCE_NAME ] ) ) {
		return;
	}

	$redirect = isset( $_POST['enq_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['enq_redirect'] ) ) : '';
	if ( ! $redirect ) {
		$redirect = wp_get_referer() ?: home_url( '/enquire/' );
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ RESTWELL_ENQUIRE_NONCE_NAME ] ) ), RESTWELL_ENQUIRE_NONCE_ACTION ) ) {
		restwell_enquire_redirect_flash(
			$redirect,
			array( __( 'Security check failed. Please try again.', 'restwell-retreats' ) ),
			array()
		);
	}

	// Honeypot: silent “success” for bots (no CRM row, no email).
	if ( ! empty( $_POST['enq_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $redirect ) . '#enquiry-result' );
		exit;
	}

	if ( restwell_form_timing_suspicious( isset( $_POST['restwell_form_opened_at'] ) ? (string) wp_unslash( $_POST['restwell_form_opened_at'] ) : '' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $redirect ) . '#enquiry-result' );
		exit;
	}

	if ( restwell_form_rate_limit_exceeded( 'enquire' ) ) {
		restwell_enquire_redirect_flash(
			$redirect,
			array( __( 'Too many enquiries from your connection. Please wait before trying again, or phone us if your request is urgent.', 'restwell-retreats' ) ),
			array()
		);
	}

	$name    = isset( $_POST['enq_name'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_name'] ) ) : '';
	$email   = isset( $_POST['enq_email'] ) ? sanitize_email( wp_unslash( $_POST['enq_email'] ) ) : '';
	$message = isset( $_POST['enq_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['enq_message'] ) ) : '';

	$phone        = isset( $_POST['enq_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_phone'] ) ) : '';
	$date_from    = isset( $_POST['enq_date_from'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_date_from'] ) ) : '';
	$date_to      = isset( $_POST['enq_date_to'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_date_to'] ) ) : '';
	$guests       = isset( $_POST['enq_guests'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_guests'] ) ) : '';
	$care         = isset( $_POST['enq_care'] ) ? sanitize_textarea_field( wp_unslash( $_POST['enq_care'] ) ) : '';
	$access       = isset( $_POST['enq_accessibility'] ) ? sanitize_textarea_field( wp_unslash( $_POST['enq_accessibility'] ) ) : '';
	$funding      = isset( $_POST['enq_funding'] ) ? sanitize_key( wp_unslash( $_POST['enq_funding'] ) ) : '';
	$urgent       = ! empty( $_POST['enq_urgent'] );
	$contact_pref = isset( $_POST['enq_contact_preference'] ) ? sanitize_key( wp_unslash( $_POST['enq_contact_preference'] ) ) : '';
	$pref_time    = isset( $_POST['enq_preferred_time'] ) ? sanitize_key( wp_unslash( $_POST['enq_preferred_time'] ) ) : '';

	$fields_flash = array(
		'enq_name'               => $name,
		'enq_email'              => $email,
		'enq_phone'              => $phone,
		'enq_message'            => $message,
		'enq_date_from'          => $date_from,
		'enq_date_to'            => $date_to,
		'enq_guests'             => $guests,
		'enq_care'               => $care,
		'enq_accessibility'      => $access,
		'enq_funding'            => $funding,
		'enq_urgent'             => $urgent ? '1' : '',
		'enq_contact_preference' => $contact_pref,
		'enq_preferred_time'     => $pref_time,
	);

	$errors = array();
	if ( '' === $name ) {
		$errors[] = __( 'Please add your name.', 'restwell-retreats' );
	}
	if ( '' === $email || ! is_email( $email ) ) {
		$errors[] = __( 'Please add a valid email address.', 'restwell-retreats' );
	}
	if ( '' === $message ) {
		$errors[] = __( 'Please add a message so we know how to help.', 'restwell-retreats' );
	}
	if ( strlen( $message ) > 15000 ) {
		$errors[] = __( 'Your message is too long. Please shorten it slightly.', 'restwell-retreats' );
	}

	$allowed_funding = array( '', 'self', 'kcc', 'chc', 'direct' );
	if ( ! in_array( $funding, $allowed_funding, true ) ) {
		$funding = '';
	}

	$date_errors = restwell_validate_enquiry_dates( $date_from, $date_to );
	$errors      = array_merge( $errors, $date_errors );

	if ( $errors ) {
		restwell_enquire_redirect_flash( $redirect, $errors, $fields_flash );
	}

	// Normalise dates for storage: blank invalid pairs already rejected.
	$dates = $date_from && $date_to
		? gmdate( 'j M Y', strtotime( $date_from ) ) . ' - ' . gmdate( 'j M Y', strtotime( $date_to ) )
		: ( $date_from ? gmdate( 'j M Y', strtotime( $date_from ) ) : '' );

	$body = "Name: $name\nEmail: $email\n";
	if ( $phone ) {
		$body .= "Phone: $phone\n";
	}
	if ( $contact_pref ) {
		$body .= 'Preferred contact: ' . $contact_pref . "\n";
	}
	if ( $pref_time ) {
		$body .= 'Best time to call: ' . $pref_time . "\n";
	}
	if ( $dates ) {
		$body .= "Preferred dates: $dates\n";
	}
	if ( $guests ) {
		$body .= "Number of guests: $guests\n";
	}
	if ( $funding ) {
		$body .= 'Funding type: ' . restwell_enquiry_funding_label( $funding ) . "\n";
	}
	if ( $urgent ) {
		$body .= "\n*** URGENT - prioritised callback requested ***\n";
	}
	if ( $care ) {
		$body .= "\nCare requirements:\n$care\n";
	}
	if ( $access ) {
		$body .= "\nAccessibility needs:\n$access\n";
	}
	$body .= "\nMessage:\n$message";

	$crm_data = array(
		'name'         => $name,
		'email'        => $email,
		'phone'        => $phone,
		'dates'        => $dates,
		'date_from'    => $date_from,
		'date_to'      => $date_to,
		'guests'       => $guests,
		'care'         => $care,
		'access'       => $access,
		'funding'      => $funding,
		'contact_pref' => $contact_pref,
		'pref_time'    => $pref_time,
		'message'      => $message,
		'urgent'       => $urgent,
	);

	$enquiry_id = restwell_crm_save_enquiry( $crm_data );
	if ( ! $enquiry_id ) {
		// Rare DB failure: still email staff the payload so nothing is lost.
		$to      = restwell_get_submission_notify_email();
		$subject = '[Restwell Retreats] Enquiry (CRM SAVE FAILED) from ' . $name;
		$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );
		restwell_wp_mail_with_retry( $to, $subject, $body . "\n\n[CRM insert returned false]", $headers );
		restwell_enquire_redirect_flash(
			$redirect,
			array(
				__( 'We could not save your enquiry just now. Our team has been emailed with your details—please try again later or call us.', 'restwell-retreats' ),
			),
			$fields_flash
		);
	}

	$to      = restwell_get_submission_notify_email();
	$subject = sprintf( '[Restwell Retreats] %sEnquiry from %s', $urgent ? 'URGENT - ' : '', $name );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );
	$body   .= "\n\nCRM enquiry ID: #" . (string) $enquiry_id;

	$staff_sent = restwell_wp_mail_with_retry( $to, $subject, $body, $headers );
	if ( ! $staff_sent && function_exists( 'restwell_crm_add_note' ) ) {
		restwell_crm_add_note(
			$enquiry_id,
			__( 'Automated note: staff notification email did not send (SMTP/mail transport). Please follow up from CRM or resend manually.', 'restwell-retreats' )
		);
	}

	$ack = restwell_email_enquiry_ack( $name, $email, $urgent );
	$ack_ok = restwell_wp_mail_with_retry( $email, $ack['subject'], $ack['body'], $ack['headers'] );
	if ( ! $ack_ok && function_exists( 'restwell_crm_add_note' ) ) {
		restwell_crm_add_note(
			$enquiry_id,
			__( 'Automated note: acknowledgement email to the guest may not have sent. Consider replying manually.', 'restwell-retreats' )
		);
	}

	$args = array( 'sent' => '1' );
	if ( $urgent ) {
		$args['urgent'] = '1';
	}
	if ( ! $staff_sent ) {
		$args['mail_warn'] = '1';
	}
	wp_safe_redirect( add_query_arg( $args, $redirect ) . '#enquiry-result' );
	exit;
}
add_action( 'template_redirect', 'restwell_handle_enquire_submit', 5 );
