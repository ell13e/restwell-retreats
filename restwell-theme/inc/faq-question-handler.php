<?php
/**
 * FAQ page “Ask a question” form: validate, persist, notify hello@ (setting), redirect with feedback.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Process FAQ question POST before templates run.
 */
function restwell_handle_faq_question_submit(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['restwell_faq_question'] ) ) {
		return;
	}

	$nonce = isset( $_POST['restwell_faq_question_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['restwell_faq_question_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'restwell_faq_question' ) ) {
		$pid_fail = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
		$url_fail = $pid_fail ? get_permalink( $pid_fail ) : home_url( '/' );
		restwell_faq_question_redirect_flash(
			$url_fail,
			array( __( 'Security check failed. Please try again.', 'restwell-retreats' ) ),
			array()
		);
		return;
	}

	// Honeypot (label hidden off-screen; bots often fill “website”).
	if ( ! empty( $_POST['faq_q_website'] ) ) {
		$pid = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
		$url = $pid ? get_permalink( $pid ) : home_url( '/' );
		wp_safe_redirect( add_query_arg( 'question_sent', '1', $url ) . '#faq-question-form' );
		exit;
	}

	if ( restwell_form_timing_suspicious( isset( $_POST['restwell_form_opened_at'] ) ? (string) wp_unslash( $_POST['restwell_form_opened_at'] ) : '' ) ) {
		$pid = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
		$url = $pid ? get_permalink( $pid ) : home_url( '/' );
		wp_safe_redirect( add_query_arg( 'question_sent', '1', $url ) . '#faq-question-form' );
		exit;
	}

	if ( restwell_form_rate_limit_exceeded( 'faq' ) ) {
		$pid = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
		$url = $pid ? get_permalink( $pid ) : home_url( '/' );
		restwell_faq_question_redirect_flash(
			$url,
			array( __( 'Too many attempts from your connection. Please wait an hour and try again, or email us directly.', 'restwell-retreats' ) ),
			array()
		);
		return;
	}

	$name    = isset( $_POST['faq_q_name'] ) ? sanitize_text_field( wp_unslash( $_POST['faq_q_name'] ) ) : '';
	$email   = isset( $_POST['faq_q_email'] ) ? sanitize_email( wp_unslash( $_POST['faq_q_email'] ) ) : '';
	$message = isset( $_POST['faq_q_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['faq_q_message'] ) ) : '';
	$pid     = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
	$back    = $pid ? get_permalink( $pid ) : home_url( '/' );

	$errors = array();
	if ( '' === $name ) {
		$errors[] = __( 'Please add your name.', 'restwell-retreats' );
	}
	if ( '' === $email || ! is_email( $email ) ) {
		$errors[] = __( 'Please add a valid email address.', 'restwell-retreats' );
	}
	if ( '' === $message ) {
		$errors[] = __( 'Please type your question.', 'restwell-retreats' );
	}
	if ( strlen( $message ) > 12000 ) {
		$errors[] = __( 'Your question is too long. Please shorten it slightly.', 'restwell-retreats' );
	}

	if ( $errors ) {
		restwell_faq_question_redirect_flash(
			$back,
			$errors,
			array(
				'name'    => $name,
				'email'   => $email,
				'message' => $message,
			)
		);
		return;
	}

	$source = $pid ? (string) get_permalink( $pid ) : $back;
	$row_id = restwell_faq_save_submission(
		array(
			'name'        => $name,
			'email'       => $email,
			'question'    => $message,
			'source_url'  => $source,
		)
	);

	$to       = restwell_get_submission_notify_email();
	$subject  = sprintf( __( '[Restwell Retreats] FAQ question from %s', 'restwell-retreats' ), $name );
	$lines    = array(
		sprintf( __( 'Name: %s', 'restwell-retreats' ), $name ),
		sprintf( __( 'Email: %s', 'restwell-retreats' ), $email ),
		'',
		__( 'Question:', 'restwell-retreats' ),
		$message,
		'',
		sprintf( __( 'Saved as submission #%s in the site database.', 'restwell-retreats' ), $row_id ? (string) $row_id : '?' ),
	);
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );

	if ( ! $row_id ) {
		$sent = restwell_wp_mail_with_retry( $to, $subject . ' [DB SAVE FAILED]', implode( "\n", $lines ), $headers );
		if ( $sent ) {
			wp_safe_redirect( add_query_arg( 'question_sent', '1', $back ) . '#faq-question-form' );
		} else {
			restwell_faq_question_redirect_flash(
				$back,
				array(
					__( 'We could not save your question or send it by email. Please try again in a few minutes, or email hello@restwellretreats.co.uk directly.', 'restwell-retreats' ),
				),
				array()
			);
		}
		exit;
	}

	$sent = restwell_wp_mail_with_retry( $to, $subject, implode( "\n", $lines ), $headers );
	if ( $sent ) {
		restwell_faq_mark_notify_sent( $row_id );
		wp_safe_redirect( add_query_arg( 'question_sent', '1', $back ) . '#faq-question-form' );
		exit;
	}

	restwell_faq_question_redirect_flash(
		$back,
		array(
			__( 'Your question was saved. We will get back to you soon.', 'restwell-retreats' ),
		),
		array()
	);
}
add_action( 'template_redirect', 'restwell_handle_faq_question_submit', 4 );

/**
 * Store flash data and redirect back to the FAQ form.
 *
 * @param string             $url    Redirect URL.
 * @param array<int, string> $errors Error messages.
 * @param array<string,string> $fields Field repopulation.
 */
function restwell_faq_question_redirect_flash( string $url, array $errors, array $fields ): void {
	$key = wp_generate_password( 12, false, false );
	set_transient(
		'restwell_faq_flash_' . $key,
		array(
			'errors' => $errors,
			'fields' => $fields,
		),
		300
	);
	wp_safe_redirect( add_query_arg( 'faq_flash', rawurlencode( $key ), $url ) . '#faq-question-form' );
	exit;
}

/**
 * Admin: list FAQ form submissions (for follow-up when email did not send).
 */
function restwell_faq_register_inbox_menu(): void {
	add_submenu_page(
		'restwell-crm',
		__( 'FAQ questions', 'restwell-retreats' ),
		__( 'FAQ questions', 'restwell-retreats' ),
		restwell_crm_capability(),
		'restwell-faq-inbox',
		'restwell_faq_inbox_page'
	);
}
add_action( 'admin_menu', 'restwell_faq_register_inbox_menu', 7 );

/**
 * Render FAQ submissions inbox.
 */
function restwell_faq_inbox_page(): void {
	if ( ! function_exists( 'restwell_crm_can_manage' ) || ! restwell_crm_can_manage() ) {
		return;
	}
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_FAQ_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$rows = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY submitted_at DESC LIMIT 100", ARRAY_A );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'FAQ questions', 'restwell-retreats' ); ?></h1>
		<p class="description"><?php esc_html_e( 'Questions submitted from the FAQ page. Rows with “Notify: No” may need a manual reply if email delivery failed.', 'restwell-retreats' ); ?></p>
		<?php if ( empty( $rows ) ) : ?>
			<p><?php esc_html_e( 'No submissions yet.', 'restwell-retreats' ); ?></p>
		<?php else : ?>
			<table class="widefat striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Date', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Notify', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Question', 'restwell-retreats' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $r ) : ?>
						<tr>
							<td><?php echo esc_html( $r['submitted_at'] ?? '' ); ?></td>
							<td><?php echo ! empty( $r['notify_sent'] ) ? esc_html__( 'Yes', 'restwell-retreats' ) : esc_html__( 'No', 'restwell-retreats' ); ?></td>
							<td><?php echo esc_html( $r['name'] ?? '' ); ?></td>
							<td><a href="mailto:<?php echo esc_attr( $r['email'] ?? '' ); ?>"><?php echo esc_html( $r['email'] ?? '' ); ?></a></td>
							<td><?php echo esc_html( wp_trim_words( (string) ( $r['question'] ?? '' ), 40 ) ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
	<?php
}
