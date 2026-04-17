<?php
/**
 * Shared helpers for public form submissions: notify address, rate limits, mail reliability.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Email address for new enquiry and FAQ question notifications (Restwell dashboard setting).
 *
 * @return string
 */
function restwell_get_submission_notify_email(): string {
	$email = (string) get_option( 'restwell_enquiry_notify_email', 'hello@restwellretreats.co.uk' );
	$email = sanitize_email( $email );
	return $email && is_email( $email ) ? $email : 'hello@restwellretreats.co.uk';
}

/**
 * Soft rate limit by IP to reduce abuse (transient-backed).
 *
 * @param string $bucket Form identifier (e.g. 'enquire', 'faq').
 * @param int    $max    Max submissions per window.
 * @param int    $window Seconds.
 * @return bool True if limit exceeded (block).
 */
function restwell_form_rate_limit_exceeded( string $bucket, int $max = 12, int $window = 3600 ): bool {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key  = 'rw_rl_' . sanitize_key( $bucket ) . '_' . md5( $ip );
	$count = (int) get_transient( $key );
	if ( $count >= $max ) {
		return true;
	}
	set_transient( $key, $count + 1, $window );
	return false;
}

/**
 * Send wp_mail with one immediate retry (covers transient SMTP glitches).
 *
 * @param string|string[] $to      Recipient(s).
 * @param string          $subject Subject line.
 * @param string          $body    Message body.
 * @param string|string[] $headers Headers.
 * @return bool True if WordPress reported success at least once.
 */
function restwell_wp_mail_with_retry( $to, string $subject, string $body, $headers ): bool {
	$ok = wp_mail( $to, $subject, $body, $headers );
	if ( ! $ok ) {
		$ok = wp_mail( $to, $subject, $body, $headers );
	}
	return $ok;
}

/**
 * Log wp_mail failures for hosting diagnostics (no PII in message body).
 */
function restwell_log_wp_mail_failed( WP_Error $error ): void {
	if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
		return;
	}
	$data = $error->get_error_data( 'wp_mail_failed' );
	$msg  = isset( $data['phpmailer_exception_code'] ) ? (string) $data['phpmailer_exception_code'] : $error->get_error_message();
	// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	error_log( '[Restwell] wp_mail_failed: ' . $msg );
}
add_action( 'wp_mail_failed', 'restwell_log_wp_mail_failed' );

/**
 * If the browser sent a "form opened at" Unix timestamp, reject instant bot posts.
 *
 * @param string $raw Unix timestamp string from hidden field (may be empty for no-JS users).
 * @return bool True if submission should be rejected as automated.
 */
function restwell_form_timing_suspicious( string $raw ): bool {
	$raw = trim( $raw );
	if ( '' === $raw ) {
		return false;
	}
	if ( ! ctype_digit( $raw ) ) {
		return true;
	}
	$opened = (int) $raw;
	$now    = time();
	if ( $opened > $now || ( $now - $opened ) > DAY_IN_SECONDS ) {
		return true;
	}
	// Faster than ~2 seconds from first paint to submit is treated as non-human.
	return ( $now - $opened ) < 2;
}
