<?php
/**
 * Restwell CRM — enquiry leads store and admin centre.
 *
 * Registers custom DB tables for enquiry storage, notes, and guests.
 * Provides a top-level "Restwell" admin menu with Dashboard, Enquiries
 * list/detail view, and exposes helpers used by the enquiry form handler.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RESTWELL_CRM_DB_VERSION', '3.1' );
define( 'RESTWELL_CRM_TABLE',    'rw_enquiries' );
define( 'RESTWELL_NOTES_TABLE',  'rw_enquiry_notes' );
define( 'RESTWELL_GUESTS_TABLE', 'rw_guests' );

// ─────────────────────────────────────────────────────────────────────────────
// 1. DATABASE SETUP
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Create or upgrade all CRM tables when the DB version changes.
 * Also runs a one-time migration of Guest Guide data from wp_options → rw_guests.
 */
function restwell_crm_maybe_create_table() {
	if ( get_option( 'restwell_crm_db_version' ) === RESTWELL_CRM_DB_VERSION ) {
		return;
	}

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	// ── rw_enquiries ─────────────────────────────────────────────────────────
	$enq_table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	dbDelta( "CREATE TABLE {$enq_table} (
		id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		submitted_at datetime NOT NULL,
		name varchar(200) NOT NULL DEFAULT '',
		email varchar(200) NOT NULL DEFAULT '',
		phone varchar(100) NOT NULL DEFAULT '',
		preferred_dates varchar(200) NOT NULL DEFAULT '',
		date_from date DEFAULT NULL,
		date_to date DEFAULT NULL,
		num_guests varchar(100) NOT NULL DEFAULT '',
		care_requirements text NOT NULL,
		accessibility text NOT NULL,
		funding_type varchar(100) NOT NULL DEFAULT '',
		contact_preference varchar(100) NOT NULL DEFAULT '',
		preferred_time varchar(100) NOT NULL DEFAULT '',
		message text NOT NULL,
		is_urgent tinyint(1) NOT NULL DEFAULT 0,
		status varchar(50) NOT NULL DEFAULT 'new',
		staff_notes text NOT NULL,
		follow_up_at datetime DEFAULT NULL,
		contacted_at datetime DEFAULT NULL,
		qualified_at datetime DEFAULT NULL,
		booked_at datetime DEFAULT NULL,
		closed_at datetime DEFAULT NULL,
		PRIMARY KEY  (id)
	) {$charset_collate};" );

	// ── rw_enquiry_notes ─────────────────────────────────────────────────────
	$notes_table = $wpdb->prefix . RESTWELL_NOTES_TABLE;
	dbDelta( "CREATE TABLE {$notes_table} (
		id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		enquiry_id bigint(20) UNSIGNED NOT NULL,
		note text NOT NULL,
		created_at datetime NOT NULL,
		created_by bigint(20) UNSIGNED NOT NULL DEFAULT 0,
		PRIMARY KEY  (id),
		KEY enquiry_id (enquiry_id)
	) {$charset_collate};" );

	// ── rw_guests ────────────────────────────────────────────────────────────
	$guests_table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	dbDelta( "CREATE TABLE {$guests_table} (
		id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		enquiry_id bigint(20) UNSIGNED DEFAULT NULL,
		name varchar(200) NOT NULL DEFAULT '',
		email varchar(200) NOT NULL DEFAULT '',
		send_date datetime DEFAULT NULL,
		sent_at datetime DEFAULT NULL,
		confirmed_at datetime DEFAULT NULL,
		created_at datetime NOT NULL,
		PRIMARY KEY  (id),
		KEY email (email)
	) {$charset_collate};" );

	// ── One-time migration: restwell_guests option → rw_guests ───────────────
	$legacy_guests = get_option( 'restwell_guests', array() );
	if ( is_array( $legacy_guests ) && ! empty( $legacy_guests ) ) {
		foreach ( $legacy_guests as $g ) {
			$email = isset( $g['email'] ) ? sanitize_email( (string) $g['email'] ) : '';
			if ( ! $email ) {
				continue;
			}
			$send_date = null;
			if ( ! empty( $g['send_date'] ) ) {
				$ts = strtotime( (string) $g['send_date'] );
				if ( $ts ) {
					$send_date = gmdate( 'Y-m-d H:i:s', $ts );
				}
			}
			$sent_at = null;
			if ( ! empty( $g['sent'] ) ) {
				$sent_at = gmdate( 'Y-m-d H:i:s', (int) $g['sent'] );
			}
			$wpdb->insert(
				$guests_table,
				array(
					'name'       => isset( $g['name'] ) ? sanitize_text_field( (string) $g['name'] ) : '',
					'email'      => $email,
					'send_date'  => $send_date,
					'sent_at'    => $sent_at,
					'created_at' => current_time( 'mysql' ),
				),
				array( '%s', '%s', '%s', '%s', '%s' )
			);
		}
		delete_option( 'restwell_guests' );
	}

	update_option( 'restwell_crm_db_version', RESTWELL_CRM_DB_VERSION );
}
add_action( 'admin_init', 'restwell_crm_maybe_create_table' );

// ─────────────────────────────────────────────────────────────────────────────
// 2. SAVE ENQUIRY (called from enquire-handler.php)
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Persist an enquiry submission to the database.
 *
 * Runs a lightweight duplicate check first: if the same email submitted
 * within the last 30 minutes we skip the insert and return the existing
 * row ID, preventing accidental double-submissions.
 *
 * @param array $data Sanitised form values keyed by short name.
 * @return int|false Inserted (or existing) row ID, or false on failure.
 */
function restwell_crm_save_enquiry( array $data ) {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$email = $data['email'] ?? '';

	// Duplicate guard: same email, submitted in the last 30 minutes.
	if ( $email ) {
		$cutoff  = gmdate( 'Y-m-d H:i:s', time() - 30 * MINUTE_IN_SECONDS );
		$dup_id  = (int) $wpdb->get_var(
			$wpdb->prepare(
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"SELECT id FROM {$table} WHERE email = %s AND submitted_at >= %s ORDER BY id DESC LIMIT 1",
				$email,
				$cutoff
			)
		);
		if ( $dup_id ) {
			return $dup_id;
		}
	}

	// Normalise optional date columns — store NULL when blank.
	$date_from = ! empty( $data['date_from'] ) ? $data['date_from'] : null;
	$date_to   = ! empty( $data['date_to'] )   ? $data['date_to']   : null;

	$result = $wpdb->insert(
		$table,
		array(
			'submitted_at'       => current_time( 'mysql' ),
			'name'               => $data['name'] ?? '',
			'email'              => $email,
			'phone'              => $data['phone'] ?? '',
			'preferred_dates'    => $data['dates'] ?? '',
			'date_from'          => $date_from,
			'date_to'            => $date_to,
			'num_guests'         => $data['guests'] ?? '',
			'care_requirements'  => $data['care'] ?? '',
			'accessibility'      => $data['access'] ?? '',
			'funding_type'       => $data['funding'] ?? '',
			'contact_preference' => $data['contact_pref'] ?? '',
			'preferred_time'     => $data['pref_time'] ?? '',
			'message'            => $data['message'] ?? '',
			'is_urgent'          => ! empty( $data['urgent'] ) ? 1 : 0,
			'status'             => 'new',
			'staff_notes'        => '',
		),
		array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s' )
	);

	return $result ? (int) $wpdb->insert_id : false;
}

// ─────────────────────────────────────────────────────────────────────────────
// 3. ADMIN MENU  (priority 5 so Guest Guide submenu can safely attach later)
// ─────────────────────────────────────────────────────────────────────────────

add_action( 'admin_menu', 'restwell_crm_register_menu', 5 );

function restwell_crm_register_menu() {
	// Top-level Restwell menu — points to Dashboard.
	add_menu_page(
		__( 'Restwell', 'restwell-retreats' ),
		__( 'Restwell', 'restwell-retreats' ),
		'manage_options',
		'restwell-crm',
		'restwell_crm_dashboard_page',
		'dashicons-groups',
		25
	);

	// Dashboard submenu (same slug replaces the auto-generated parent label).
	add_submenu_page(
		'restwell-crm',
		__( 'Dashboard', 'restwell-retreats' ),
		__( 'Dashboard', 'restwell-retreats' ),
		'manage_options',
		'restwell-crm',
		'restwell_crm_dashboard_page'
	);

	// Enquiries submenu — new slug.
	add_submenu_page(
		'restwell-crm',
		__( 'Enquiries', 'restwell-retreats' ),
		__( 'Enquiries', 'restwell-retreats' ),
		'manage_options',
		'restwell-enquiries',
		'restwell_crm_enquiries_page'
	);

	// Guest Guide submenu — callback defined in inc/guest-guide.php.
	add_submenu_page(
		'restwell-crm',
		__( 'Guest Guide', 'restwell-retreats' ),
		__( 'Guest Guide', 'restwell-retreats' ),
		'manage_options',
		'restwell-guest-guide',
		'restwell_guest_guide_settings_page'
	);
}

// ─────────────────────────────────────────────────────────────────────────────
// 4. STATUS HELPERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Return the defined lead statuses with label and badge colour.
 *
 * @return array<string, array{label: string, color: string}>
 */
function restwell_crm_statuses(): array {
	return array(
		'new'       => array( 'label' => 'New',        'color' => '#2271b1' ),
		'contacted' => array( 'label' => 'Contacted',  'color' => '#996800' ),
		'qualified' => array( 'label' => 'Qualified',  'color' => '#6f41c1' ),
		'booked'    => array( 'label' => 'Booked',     'color' => '#007a3d' ),
		'closed'    => array( 'label' => 'Closed',     'color' => '#787c82' ),
	);
}

/**
 * Render a coloured status badge.
 *
 * @param string $status Status slug.
 * @return string HTML span.
 */
function restwell_crm_status_badge( string $status ): string {
	$statuses = restwell_crm_statuses();
	$label    = $statuses[ $status ]['label'] ?? ucfirst( $status );
	$color    = $statuses[ $status ]['color'] ?? '#787c82';

	return sprintf(
		'<span style="display:inline-block;padding:2px 9px;border-radius:3px;font-size:11px;font-weight:600;letter-spacing:.03em;background:%s;color:#fff;">%s</span>',
		esc_attr( $color ),
		esc_html( $label )
	);
}

// ─────────────────────────────────────────────────────────────────────────────
// 5. NOTES HELPERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Add an entry to the activity log for an enquiry.
 *
 * @param int    $enquiry_id Enquiry row ID.
 * @param string $note       Note text (already sanitised by caller).
 */
function restwell_crm_add_note( int $enquiry_id, string $note ): void {
	global $wpdb;
	$wpdb->insert(
		$wpdb->prefix . RESTWELL_NOTES_TABLE,
		array(
			'enquiry_id' => $enquiry_id,
			'note'       => $note,
			'created_at' => current_time( 'mysql' ),
			'created_by' => get_current_user_id(),
		),
		array( '%d', '%s', '%s', '%d' )
	);
}

/**
 * Return all notes for an enquiry, oldest first.
 *
 * @param int $enquiry_id Enquiry row ID.
 * @return array
 */
function restwell_crm_get_notes( int $enquiry_id ): array {
	global $wpdb;
	$notes_table = $wpdb->prefix . RESTWELL_NOTES_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	return (array) $wpdb->get_results(
		$wpdb->prepare( "SELECT * FROM {$notes_table} WHERE enquiry_id = %d ORDER BY created_at ASC", $enquiry_id )
	);
}

// ─────────────────────────────────────────────────────────────────────────────
// 6. ADMIN POST HANDLERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Stream all enquiries as a UTF-8 CSV download.
 */
function restwell_crm_handle_export_csv() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_export_csv' );

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$rows = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY submitted_at DESC", ARRAY_A );

	$filename = 'restwell-enquiries-' . gmdate( 'Y-m-d' ) . '.csv';

	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );

	$out = fopen( 'php://output', 'w' );
	// BOM for Excel UTF-8 compatibility.
	fprintf( $out, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );

	if ( ! empty( $rows ) ) {
		fputcsv( $out, array_keys( $rows[0] ) );
		foreach ( $rows as $row ) {
			fputcsv( $out, $row );
		}
	}

	fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
	exit;
}
add_action( 'admin_post_restwell_crm_export_csv', 'restwell_crm_handle_export_csv' );

/**
 * Send the post-stay follow-up email for a closed enquiry.
 */
function restwell_crm_handle_send_post_stay() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}

	$id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	check_admin_referer( 'restwell_crm_send_post_stay_' . $id );

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );

	if ( $row && function_exists( 'restwell_email_post_stay' ) ) {
		$email_data = restwell_email_post_stay( $row->email, $row->name );
		wp_mail( $row->email, $email_data['subject'], $email_data['body'], $email_data['headers'] );
		restwell_crm_add_note( $id, __( 'Post-stay email sent.', 'restwell-retreats' ) );
	}

	wp_safe_redirect(
		add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $id, 'updated' => '1' ), admin_url( 'admin.php' ) )
	);
	exit;
}
add_action( 'admin_post_restwell_crm_send_post_stay', 'restwell_crm_handle_send_post_stay' );

/**
 * Save the notification email setting.
 */
function restwell_crm_handle_save_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_settings' );

	$email = isset( $_POST['restwell_enquiry_notify_email'] )
		? sanitize_email( wp_unslash( $_POST['restwell_enquiry_notify_email'] ) )
		: '';
	if ( $email ) {
		update_option( 'restwell_enquiry_notify_email', $email );
	}

	$phone = isset( $_POST['restwell_phone_number'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_phone_number'] ) )
		: '';
	if ( $phone ) {
		update_option( 'restwell_phone_number', $phone );
	}

	$address = isset( $_POST['restwell_property_address'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_property_address'] ) )
		: '';
	if ( $address ) {
		update_option( 'restwell_property_address', $address );
	}

	$postcode = isset( $_POST['restwell_property_postcode'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_property_postcode'] ) )
		: '';
	if ( $postcode ) {
		update_option( 'restwell_property_postcode', $postcode );
	}

	$footer_heading = isset( $_POST['restwell_footer_cta_heading'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_heading'] ) )
		: '';
	update_option( 'restwell_footer_cta_heading', $footer_heading );

	$footer_btn = isset( $_POST['restwell_footer_cta_btn'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_btn'] ) )
		: '';
	update_option( 'restwell_footer_cta_btn', $footer_btn );

	$gsc = isset( $_POST['restwell_gsc_verification'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_gsc_verification'] ) )
		: '';
	update_option( 'restwell_gsc_verification', $gsc );

	wp_safe_redirect(
		add_query_arg( array( 'page' => 'restwell-crm', 'settings_saved' => '1' ), admin_url( 'admin.php' ) )
	);
	exit;
}
add_action( 'admin_post_restwell_save_settings', 'restwell_crm_handle_save_settings' );

/**
 * Add a note to the enquiry activity log.
 */
function restwell_crm_handle_add_note() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_add_note' );

	$enquiry_id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	$note       = sanitize_textarea_field( wp_unslash( $_POST['rw_note_text'] ?? '' ) );

	if ( $enquiry_id && $note ) {
		restwell_crm_add_note( $enquiry_id, $note );
	}

	wp_safe_redirect(
		add_query_arg(
			array( 'page' => 'restwell-enquiries', 'view' => $enquiry_id, 'note_added' => '1' ),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_crm_add_note', 'restwell_crm_handle_add_note' );

// ─────────────────────────────────────────────────────────────────────────────
// 7. DASHBOARD PAGE
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Render the Restwell CRM dashboard.
 */
function restwell_crm_dashboard_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	global $wpdb;
	$enq_table    = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$guests_table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$now_mysql    = current_time( 'mysql' );
	$week_ago     = gmdate( 'Y-m-d H:i:s', strtotime( '-7 days' ) );

	// ── Stats ────────────────────────────────────────────────────────────────
	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$stat_new_week   = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$enq_table} WHERE submitted_at >= %s", $week_ago ) );
	$stat_total      = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$enq_table}" );
	$stat_urgent     = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$enq_table} WHERE is_urgent = 1 AND status = 'new'" );
	$stat_follow_ups = (int) $wpdb->get_var(
		$wpdb->prepare( "SELECT COUNT(*) FROM {$enq_table} WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'", $now_mysql )
	);

	// Follow-ups due today or overdue.
	$follow_up_rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT id, name, email, status, follow_up_at FROM {$enq_table}
			 WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'
			 ORDER BY follow_up_at ASC LIMIT 20",
			$now_mysql
		)
	);

	// Booked enquiries not yet added to the Guest Guide.
	$booked_without_guide = $wpdb->get_results(
		"SELECT e.id, e.name, e.email, e.preferred_dates, e.booked_at
		 FROM {$enq_table} e
		 LEFT JOIN {$guests_table} g ON LOWER(g.email) = LOWER(e.email)
		 WHERE e.status = 'booked' AND g.id IS NULL
		 ORDER BY e.booked_at ASC"
	);
	// phpcs:enable

	$enquiries_url = admin_url( 'admin.php?page=restwell-enquiries' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Restwell Dashboard', 'restwell-retreats' ); ?></h1>

		<?php if ( isset( $_GET['settings_saved'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Settings saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<!-- Stat tiles -->
		<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin:20px 0;max-width:960px;">
			<?php
			$tiles = array(
				array(
					'label' => __( 'New this week', 'restwell-retreats' ),
					'value' => $stat_new_week,
					'color' => '#2271b1',
					'url'   => add_query_arg( 'status_filter', 'new', $enquiries_url ),
				),
				array(
					'label' => __( 'Total enquiries', 'restwell-retreats' ),
					'value' => $stat_total,
					'color' => '#3c434a',
					'url'   => $enquiries_url,
				),
				array(
					'label' => __( 'Urgent & uncontacted', 'restwell-retreats' ),
					'value' => $stat_urgent,
					'color' => '#d63638',
					'url'   => add_query_arg( 'status_filter', 'new', $enquiries_url ),
				),
				array(
					'label' => __( 'Follow-ups overdue', 'restwell-retreats' ),
					'value' => $stat_follow_ups,
					'color' => '#996800',
					'url'   => $enquiries_url,
				),
			);
			foreach ( $tiles as $tile ) :
			?>
			<a href="<?php echo esc_url( $tile['url'] ); ?>"
			   style="display:block;background:#fff;border:1px solid #dcdcde;border-radius:4px;padding:16px 20px;text-decoration:none;border-top:3px solid <?php echo esc_attr( $tile['color'] ); ?>;">
				<div style="font-size:30px;font-weight:700;color:<?php echo esc_attr( $tile['color'] ); ?>;"><?php echo esc_html( $tile['value'] ); ?></div>
				<div style="font-size:12px;color:#50575e;margin-top:4px;"><?php echo esc_html( $tile['label'] ); ?></div>
			</a>
			<?php endforeach; ?>
		</div>

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:1100px;align-items:start;">

			<!-- Follow-ups due -->
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle"><span>&#9201; <?php esc_html_e( 'Follow-ups due', 'restwell-retreats' ); ?></span></h2>
				</div>
				<div class="inside" style="padding:0;">
					<?php if ( empty( $follow_up_rows ) ) : ?>
						<p style="padding:12px 16px;color:#787c82;margin:0;"><?php esc_html_e( 'No overdue follow-ups. Nice work.', 'restwell-retreats' ); ?></p>
					<?php else : ?>
						<table class="widefat striped" style="border:none;">
							<thead>
								<tr>
									<th><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Due', 'restwell-retreats' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $follow_up_rows as $r ) : ?>
									<tr>
										<td>
											<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $r->id ), admin_url( 'admin.php' ) ) ); ?>">
												<?php echo esc_html( $r->name ); ?>
											</a>
										</td>
										<td><?php echo restwell_crm_status_badge( $r->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
										<td style="font-size:12px;color:#50575e;">
											<?php echo esc_html( date_i18n( 'j M Y', strtotime( $r->follow_up_at ) ) ); ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>

			<!-- Booked without guide -->
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle"><span>&#128203; <?php esc_html_e( 'Booked — guide not sent', 'restwell-retreats' ); ?></span></h2>
				</div>
				<div class="inside" style="padding:0;">
					<?php if ( empty( $booked_without_guide ) ) : ?>
						<p style="padding:12px 16px;color:#787c82;margin:0;"><?php esc_html_e( 'All booked guests have a guide invitation.', 'restwell-retreats' ); ?></p>
					<?php else : ?>
						<table class="widefat striped" style="border:none;">
							<thead>
								<tr>
									<th><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Dates', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Action', 'restwell-retreats' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $booked_without_guide as $r ) : ?>
									<?php
									$promote_url = add_query_arg(
										array(
											'page'               => 'restwell-guest-guide',
											'prefill_name'       => rawurlencode( $r->name ),
											'prefill_email'      => rawurlencode( $r->email ),
											'prefill_enquiry_id' => $r->id,
										),
										admin_url( 'admin.php' )
									);
									?>
									<tr>
										<td>
											<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $r->id ), admin_url( 'admin.php' ) ) ); ?>">
												<?php echo esc_html( $r->name ); ?>
											</a>
										</td>
										<td style="font-size:12px;color:#50575e;"><?php echo esc_html( $r->preferred_dates ?: '—' ); ?></td>
										<td>
											<a href="<?php echo esc_url( $promote_url ); ?>" class="button button-small">
												<?php esc_html_e( 'Add to Guide', 'restwell-retreats' ); ?>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>

		</div><!-- grid -->

		<!-- Notification settings -->
		<div style="max-width:600px;margin-top:24px;">
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle"><span><?php esc_html_e( 'Notification Settings', 'restwell-retreats' ); ?></span></h2>
				</div>
				<div class="inside">
					<p class="description" style="margin-top:0;">
						<?php esc_html_e( 'New enquiry notification emails are sent to this address.', 'restwell-retreats' ); ?>
					</p>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<?php wp_nonce_field( 'restwell_crm_settings' ); ?>
						<input type="hidden" name="action" value="restwell_save_settings" />
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row">
									<label for="restwell_enquiry_notify_email">
										<?php esc_html_e( 'Notify email', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="email"
										id="restwell_enquiry_notify_email"
										name="restwell_enquiry_notify_email"
										value="<?php echo esc_attr( (string) get_option( 'restwell_enquiry_notify_email', 'hello@restwellretreats.co.uk' ) ); ?>"
										class="regular-text"
									/>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_phone_number">
										<?php esc_html_e( 'Phone number', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="tel"
										id="restwell_phone_number"
										name="restwell_phone_number"
										value="<?php echo esc_attr( (string) get_option( 'restwell_phone_number', '01622 809881' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Used in email templates and the site footer.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_property_address">
										<?php esc_html_e( 'Property street address', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_property_address"
										name="restwell_property_address"
										value="<?php echo esc_attr( (string) get_option( 'restwell_property_address', '101 Russell Drive' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Used in schema.org markup, 404 page, and other copy.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_property_postcode">
										<?php esc_html_e( 'Property postcode', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_property_postcode"
										name="restwell_property_postcode"
										value="<?php echo esc_attr( (string) get_option( 'restwell_property_postcode', 'CT5 2RQ' ) ); ?>"
										class="regular-text"
									/>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_heading">
										<?php esc_html_e( 'Footer CTA heading', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_heading"
										name="restwell_footer_cta_heading"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_heading', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'Ready to plan your break?', 'restwell-retreats' ); ?>"
									/>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_btn">
										<?php esc_html_e( 'Footer CTA button label', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_btn"
										name="restwell_footer_cta_btn"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_btn', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'Enquire about dates', 'restwell-retreats' ); ?>"
									/>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_gsc_verification">
										<?php esc_html_e( 'Google Search Console verification', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_gsc_verification"
										name="restwell_gsc_verification"
										value="<?php echo esc_attr( (string) get_option( 'restwell_gsc_verification', '' ) ); ?>"
										class="regular-text"
										placeholder="ABC123..."
									/>
									<p class="description">
										<?php esc_html_e( 'Paste the content value from the Google Search Console HTML meta tag verification method.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
						</table>
						<?php submit_button( __( 'Save', 'restwell-retreats' ), 'secondary', 'submit', false ); ?>
					</form>
				</div>
			</div>
		</div>

	</div><!-- .wrap -->
	<?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 8. ENQUIRIES LIST PAGE
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Render the Enquiries admin page (list and detail views).
 */
function restwell_crm_enquiries_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;

	// ── Handle status + notes update from detail view ────────────────────────
	if (
		isset( $_POST['rw_crm_nonce'], $_POST['rw_enquiry_id'], $_POST['rw_status'] )
		&& wp_verify_nonce( sanitize_key( $_POST['rw_crm_nonce'] ), 'restwell_crm_action' )
	) {
		$id         = absint( $_POST['rw_enquiry_id'] );
		$new_status = sanitize_key( $_POST['rw_status'] );
		$notes      = isset( $_POST['rw_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['rw_notes'] ) ) : '';

		// Parse follow-up date from datetime-local format (YYYY-MM-DDTHH:MM).
		$follow_up_raw = isset( $_POST['rw_follow_up'] ) ? sanitize_text_field( wp_unslash( $_POST['rw_follow_up'] ) ) : '';
		$follow_up_at  = $follow_up_raw ? str_replace( 'T', ' ', $follow_up_raw ) . ':00' : null;

		if ( array_key_exists( $new_status, restwell_crm_statuses() ) ) {
			// Fetch current row to determine first-time status timestamps.
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$current = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );

			$update_data    = array(
				'status'       => $new_status,
				'staff_notes'  => $notes,
				'follow_up_at' => $follow_up_at,
			);
			$update_formats = array( '%s', '%s', '%s' );

			if ( $current ) {
				// Set first-time status timestamps only when the column is still NULL.
				if ( 'contacted' === $new_status && empty( $current->contacted_at ) ) {
					$update_data['contacted_at'] = current_time( 'mysql' );
					$update_formats[]            = '%s';
				}
				if ( 'qualified' === $new_status && empty( $current->qualified_at ) ) {
					$update_data['qualified_at'] = current_time( 'mysql' );
					$update_formats[]            = '%s';
				}
				if ( 'booked' === $new_status && empty( $current->booked_at ) ) {
					$update_data['booked_at'] = current_time( 'mysql' );
					$update_formats[]         = '%s';
				}
				if ( 'closed' === $new_status && empty( $current->closed_at ) ) {
					$update_data['closed_at'] = current_time( 'mysql' );
					$update_formats[]         = '%s';
				}
			}

			$wpdb->update( $table, $update_data, array( 'id' => $id ), $update_formats, array( '%d' ) );

			// Auto-log status change to the activity log when it actually changed.
			if ( $current && $current->status !== $new_status ) {
				$statuses_map = restwell_crm_statuses();
				$old_label    = $statuses_map[ $current->status ]['label'] ?? ucfirst( $current->status );
				$new_label    = $statuses_map[ $new_status ]['label'] ?? ucfirst( $new_status );
				restwell_crm_add_note(
					$id,
					sprintf(
						/* translators: 1: old status label, 2: new status label */
						__( 'Status changed from "%1$s" to "%2$s".', 'restwell-retreats' ),
						$old_label,
						$new_label
					)
				);

				// Send booking confirmation email on first 'booked' transition.
				if ( 'booked' === $new_status && empty( $current->booked_at ) && function_exists( 'restwell_email_booking_confirmed' ) ) {
					$email_data = restwell_email_booking_confirmed( $current->name, $current->email );
					wp_mail( $current->email, $email_data['subject'], $email_data['body'], $email_data['headers'] );
				}
			}
		}

		wp_safe_redirect(
			add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $id, 'updated' => '1' ), admin_url( 'admin.php' ) )
		);
		exit;
	}

	// ── Handle bulk status update ────────────────────────────────────────────
	if (
		isset( $_POST['rw_bulk_nonce'], $_POST['rw_bulk_action'], $_POST['rw_bulk_ids'] )
		&& wp_verify_nonce( sanitize_key( $_POST['rw_bulk_nonce'] ), 'restwell_crm_bulk' )
	) {
		$bulk_action = sanitize_key( $_POST['rw_bulk_action'] );
		$ids         = array_filter( array_map( 'absint', (array) $_POST['rw_bulk_ids'] ) );

		if ( array_key_exists( $bulk_action, restwell_crm_statuses() ) && $ids ) {
			foreach ( $ids as $id ) {
				$wpdb->update( $table, array( 'status' => $bulk_action ), array( 'id' => $id ), array( '%s' ), array( '%d' ) );
			}
		}

		wp_safe_redirect( add_query_arg( array( 'page' => 'restwell-enquiries', 'updated' => '1' ), admin_url( 'admin.php' ) ) );
		exit;
	}

	// ── Single enquiry detail view ───────────────────────────────────────────
	if ( isset( $_GET['view'] ) ) {
		restwell_crm_enquiry_detail( absint( $_GET['view'] ) );
		return;
	}

	// ── Build WHERE clause safely ────────────────────────────────────────────
	$status_filter = isset( $_GET['status_filter'] ) ? sanitize_key( $_GET['status_filter'] ) : '';
	$search        = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
	$per_page      = 25;
	$current_page  = max( 1, isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1 );
	$offset        = ( $current_page - 1 ) * $per_page;

	$where_parts = array( '1=1' );

	if ( $status_filter && array_key_exists( $status_filter, restwell_crm_statuses() ) ) {
		$where_parts[] = $wpdb->prepare( 'status = %s', $status_filter );
	}
	if ( $search ) {
		$like          = '%' . $wpdb->esc_like( $search ) . '%';
		$where_parts[] = $wpdb->prepare( '(name LIKE %s OR email LIKE %s OR phone LIKE %s)', $like, $like, $like );
	}

	$where = implode( ' AND ', $where_parts );

	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE {$where}" );
	$rows  = $wpdb->get_results(
		$wpdb->prepare( "SELECT * FROM {$table} WHERE {$where} ORDER BY submitted_at DESC LIMIT %d OFFSET %d", $per_page, $offset )
	);
	// phpcs:enable

	$total_pages = (int) ceil( $total / $per_page );
	$statuses    = restwell_crm_statuses();
	$base_url    = admin_url( 'admin.php?page=restwell-enquiries' );
	$now_mysql   = current_time( 'mysql' );

	// Status counts for tabs.
	$counts = array();
	foreach ( array_keys( $statuses ) as $s ) {
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$counts[ $s ] = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE status = %s", $s ) );
	}
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$counts['all'] = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );

	?>
	<div class="wrap">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Enquiries', 'restwell-retreats' ); ?></h1>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline-block;margin-left:10px;vertical-align:middle;">
			<?php wp_nonce_field( 'restwell_crm_export_csv' ); ?>
			<input type="hidden" name="action" value="restwell_crm_export_csv" />
			<button type="submit" class="page-title-action">
				&#8659; <?php esc_html_e( 'Export CSV', 'restwell-retreats' ); ?>
			</button>
		</form>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Changes saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<!-- Status filter tabs -->
		<ul class="subsubsub">
			<li>
				<a href="<?php echo esc_url( $base_url ); ?>" <?php if ( ! $status_filter ) echo 'class="current"'; ?>>
					<?php esc_html_e( 'All', 'restwell-retreats' ); ?> <span class="count">(<?php echo esc_html( $counts['all'] ); ?>)</span>
				</a> |
			</li>
			<?php $status_keys = array_keys( $statuses ); ?>
			<?php foreach ( $statuses as $slug => $info ) : ?>
				<li>
					<a href="<?php echo esc_url( add_query_arg( 'status_filter', $slug, $base_url ) ); ?>"
					   <?php if ( $status_filter === $slug ) echo 'class="current"'; ?>>
						<?php echo esc_html( $info['label'] ); ?> <span class="count">(<?php echo esc_html( $counts[ $slug ] ); ?>)</span>
					</a>
					<?php echo end( $status_keys ) !== $slug ? ' |' : ''; ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<!-- Search -->
		<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">
			<input type="hidden" name="page" value="restwell-enquiries">
			<?php if ( $status_filter ) : ?>
				<input type="hidden" name="status_filter" value="<?php echo esc_attr( $status_filter ); ?>">
			<?php endif; ?>
			<p class="search-box">
				<label class="screen-reader-text" for="rw-crm-search"><?php esc_html_e( 'Search enquiries', 'restwell-retreats' ); ?></label>
				<input type="search" id="rw-crm-search" name="s"
				       value="<?php echo esc_attr( $search ); ?>"
				       placeholder="<?php esc_attr_e( 'Name, email or phone…', 'restwell-retreats' ); ?>">
				<input type="submit" class="button" value="<?php esc_attr_e( 'Search', 'restwell-retreats' ); ?>">
				<?php if ( $search ) : ?>
					<a class="button" href="<?php echo esc_url( $base_url ); ?>"><?php esc_html_e( 'Clear', 'restwell-retreats' ); ?></a>
				<?php endif; ?>
			</p>
		</form>

		<?php if ( empty( $rows ) ) : ?>
			<p><?php esc_html_e( 'No enquiries found.', 'restwell-retreats' ); ?></p>
		<?php else : ?>

		<!-- Bulk action + list -->
		<form method="post" action="">
			<?php wp_nonce_field( 'restwell_crm_bulk', 'rw_bulk_nonce' ); ?>

			<div class="tablenav top">
				<div class="alignleft actions bulkactions">
					<label for="rw-bulk-action" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'restwell-retreats' ); ?></label>
					<select name="rw_bulk_action" id="rw-bulk-action">
						<option value=""><?php esc_html_e( '— Bulk action —', 'restwell-retreats' ); ?></option>
						<?php foreach ( $statuses as $slug => $info ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>">
								<?php
								/* translators: %s: status label */
								printf( esc_html__( 'Mark as %s', 'restwell-retreats' ), esc_html( $info['label'] ) );
								?>
							</option>
						<?php endforeach; ?>
					</select>
					<input type="submit" class="button action" value="<?php esc_attr_e( 'Apply', 'restwell-retreats' ); ?>">
				</div>

				<?php if ( $total_pages > 1 ) : ?>
					<div class="tablenav-pages">
						<span class="displaying-num">
							<?php
							/* translators: %d: number of items */
							printf( esc_html__( '%d items', 'restwell-retreats' ), esc_html( $total ) );
							?>
						</span>
						<?php for ( $p = 1; $p <= $total_pages; $p++ ) : ?>
							<a class="button<?php echo $p === $current_page ? ' button-primary' : ''; ?>"
							   href="<?php echo esc_url( add_query_arg( array( 'paged' => $p, 'status_filter' => $status_filter, 's' => $search ), $base_url ) ); ?>">
								<?php echo esc_html( $p ); ?>
							</a>
						<?php endfor; ?>
					</div>
				<?php endif; ?>
			</div>

			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
						<td class="manage-column check-column">
							<input id="cb-select-all" type="checkbox">
						</td>
						<th scope="col" style="width:24px;padding:8px 4px;"></th>
						<th scope="col"><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Dates / Guests', 'restwell-retreats' ); ?></th>
						<th scope="col" style="width:110px;"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></th>
						<th scope="col" style="width:130px;"><?php esc_html_e( 'Received', 'restwell-retreats' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<?php
						$detail_url  = add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $row->id ), admin_url( 'admin.php' ) );
						$is_overdue  = ! empty( $row->follow_up_at ) && $row->follow_up_at <= $now_mysql && 'closed' !== $row->status;
						?>
						<tr<?php echo $row->is_urgent ? ' style="background:#fff8f8;"' : ''; ?>>
							<th scope="row" class="check-column">
								<input type="checkbox" name="rw_bulk_ids[]" value="<?php echo esc_attr( $row->id ); ?>">
							</th>
							<td style="padding:8px 4px;text-align:center;">
								<?php if ( $row->is_urgent ) : ?>
									<span style="color:#d63638;font-size:15px;" title="<?php esc_attr_e( 'Urgent', 'restwell-retreats' ); ?>">⚑</span>
								<?php elseif ( $is_overdue ) : ?>
									<span style="font-size:13px;" title="<?php esc_attr_e( 'Follow-up overdue', 'restwell-retreats' ); ?>">⏰</span>
								<?php endif; ?>
							</td>
							<td>
								<strong><a href="<?php echo esc_url( $detail_url ); ?>"><?php echo esc_html( $row->name ); ?></a></strong>
								<?php if ( $row->staff_notes ) : ?>
									<br><span style="color:#787c82;font-size:12px;">
										&#128221; <?php echo esc_html( wp_trim_words( $row->staff_notes, 10 ) ); ?>
									</span>
								<?php endif; ?>
							</td>
							<td>
								<a href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a>
								<?php if ( $row->phone ) : ?>
									<br>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ); ?>">
										<?php echo esc_html( $row->phone ); ?>
									</a>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $row->preferred_dates ) : ?>
									<span style="font-size:12px;"><?php echo esc_html( $row->preferred_dates ); ?></span>
								<?php endif; ?>
								<?php if ( $row->num_guests ) : ?>
									<br><span style="color:#787c82;font-size:12px;"><?php echo esc_html( $row->num_guests ); ?> guests</span>
								<?php endif; ?>
								<?php if ( ! $row->preferred_dates && ! $row->num_guests ) : ?>
									<span style="color:#c3c4c7;">—</span>
								<?php endif; ?>
							</td>
							<td><?php echo restwell_crm_status_badge( $row->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
							<td style="font-size:12px;color:#50575e;">
								<?php echo esc_html( date_i18n( 'j M Y', strtotime( $row->submitted_at ) ) ); ?>
								<br><?php echo esc_html( date_i18n( 'H:i', strtotime( $row->submitted_at ) ) ); ?>
								<?php if ( $is_overdue ) : ?>
									<br><span style="color:#996800;">
										&#9201; <?php echo esc_html( date_i18n( 'j M', strtotime( $row->follow_up_at ) ) ); ?>
									</span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</form>

		<?php endif; ?>
	</div>

	<script>
	( function() {
		var selectAll = document.getElementById( 'cb-select-all' );
		if ( selectAll ) {
			selectAll.addEventListener( 'change', function() {
				document.querySelectorAll( '[name="rw_bulk_ids[]"]' ).forEach( function( cb ) {
					cb.checked = selectAll.checked;
				} );
			} );
		}
	} )();
	</script>
	<?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 9. ENQUIRY DETAIL / EDIT VIEW
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Render the single-enquiry detail page.
 *
 * @param int $id Enquiry row ID.
 */
function restwell_crm_enquiry_detail( int $id ) {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );

	if ( ! $row ) {
		echo '<div class="wrap"><div class="notice notice-error"><p>' . esc_html__( 'Enquiry not found.', 'restwell-retreats' ) . '</p></div></div>';
		return;
	}

	$statuses = restwell_crm_statuses();
	$back_url = admin_url( 'admin.php?page=restwell-enquiries' );
	$notes    = restwell_crm_get_notes( $id );

	// Build mailto with subject pre-filled.
	$mailto = 'mailto:' . rawurlencode( $row->email ) . '?subject=' . rawurlencode( 'Re: Your Restwell Retreats Enquiry' );

	// Format follow-up datetime for the datetime-local input (YYYY-MM-DDTHH:MM).
	$follow_up_value = '';
	if ( ! empty( $row->follow_up_at ) ) {
		$follow_up_value = date( 'Y-m-d\TH:i', strtotime( $row->follow_up_at ) );
	}

	// Promote-to-guest URL.
	$promote_url = add_query_arg(
		array(
			'page'               => 'restwell-guest-guide',
			'prefill_name'       => rawurlencode( $row->name ),
			'prefill_email'      => rawurlencode( $row->email ),
			'prefill_enquiry_id' => $row->id,
		),
		admin_url( 'admin.php' )
	);
	?>
	<div class="wrap">
		<h1 style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
			<a href="<?php echo esc_url( $back_url ); ?>"
			   style="font-size:13px;font-weight:400;text-decoration:none;color:#2271b1;">
				&larr; <?php esc_html_e( 'All Enquiries', 'restwell-retreats' ); ?>
			</a>
			<span style="color:#ccc;font-weight:300;">|</span>
			<?php if ( $row->is_urgent ) : ?>
				<span style="color:#d63638;" title="<?php esc_attr_e( 'Urgent', 'restwell-retreats' ); ?>">&#9873; URGENT —</span>
			<?php endif; ?>
			<?php echo esc_html( $row->name ); ?>
			<?php echo restwell_crm_status_badge( $row->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</h1>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Changes saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['note_added'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Note added.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;margin-top:20px;max-width:1100px;align-items:start;">

			<!-- ── Left: enquiry details ─────────────────────────────────── -->
			<div>
				<div class="postbox">
					<div class="postbox-header">
						<h2 class="hndle"><span><?php esc_html_e( 'Enquiry Details', 'restwell-retreats' ); ?></span></h2>
					</div>
					<div class="inside">

						<?php
						$contact_fields = array(
							__( 'Name', 'restwell-retreats' )              => esc_html( $row->name ),
							__( 'Email', 'restwell-retreats' )             => '<a href="mailto:' . esc_attr( $row->email ) . '">' . esc_html( $row->email ) . '</a>',
							__( 'Phone', 'restwell-retreats' )             => $row->phone
								? '<a href="tel:' . esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ) . '">' . esc_html( $row->phone ) . '</a>'
								: '',
							__( 'Preferred contact', 'restwell-retreats' ) => esc_html( $row->contact_preference ),
							__( 'Best time to call', 'restwell-retreats' ) => esc_html( $row->preferred_time ),
						);
						$booking_fields = array(
							__( 'Preferred dates', 'restwell-retreats' ) => esc_html( $row->preferred_dates ),
							__( 'Number of guests', 'restwell-retreats' ) => esc_html( $row->num_guests ),
							__( 'Funding type', 'restwell-retreats' )    => esc_html( $row->funding_type ),
						);
						?>

						<h3 style="margin-top:0;"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></h3>
						<table class="form-table" role="presentation" style="margin-top:0;">
							<?php foreach ( $contact_fields as $label => $value ) : ?>
								<?php if ( $value ) : ?>
									<tr>
										<th style="width:160px;padding:5px 10px;font-weight:600;"><?php echo esc_html( $label ); ?></th>
										<td style="padding:5px 10px;"><?php echo wp_kses_post( $value ); ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</table>

						<h3><?php esc_html_e( 'Booking', 'restwell-retreats' ); ?></h3>
						<table class="form-table" role="presentation" style="margin-top:0;">
							<?php foreach ( $booking_fields as $label => $value ) : ?>
								<?php if ( $value ) : ?>
									<tr>
										<th style="width:160px;padding:5px 10px;font-weight:600;"><?php echo esc_html( $label ); ?></th>
										<td style="padding:5px 10px;"><?php echo wp_kses_post( $value ); ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</table>

						<?php if ( $row->care_requirements ) : ?>
							<h3><?php esc_html_e( 'Care Requirements', 'restwell-retreats' ); ?></h3>
							<p style="white-space:pre-line;background:#f6f7f7;padding:12px 14px;border-radius:4px;margin:0 0 16px;">
								<?php echo esc_html( $row->care_requirements ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $row->accessibility ) : ?>
							<h3><?php esc_html_e( 'Accessibility Needs', 'restwell-retreats' ); ?></h3>
							<p style="white-space:pre-line;background:#f6f7f7;padding:12px 14px;border-radius:4px;margin:0 0 16px;">
								<?php echo esc_html( $row->accessibility ); ?>
							</p>
						<?php endif; ?>

						<h3><?php esc_html_e( 'Message', 'restwell-retreats' ); ?></h3>
						<p style="white-space:pre-line;background:#f6f7f7;padding:12px 14px;border-radius:4px;margin:0;">
							<?php echo esc_html( $row->message ); ?>
						</p>

						<p style="color:#787c82;font-size:12px;margin-top:16px;margin-bottom:0;">
							<?php
							/* translators: %s: formatted date */
							printf(
								esc_html__( 'Submitted %s', 'restwell-retreats' ),
								esc_html( date_i18n( 'j F Y \a\t H:i', strtotime( $row->submitted_at ) ) )
							);
							?>
						</p>

					</div><!-- .inside -->
				</div><!-- .postbox -->
			</div>

			<!-- ── Right: status, notes, actions ────────────────────────── -->
			<div>
				<!-- Status + follow-up form -->
				<form method="post" action="">
					<?php wp_nonce_field( 'restwell_crm_action', 'rw_crm_nonce' ); ?>
					<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( $row->id ); ?>">

					<div class="postbox">
						<div class="postbox-header">
							<h2 class="hndle"><span><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></span></h2>
						</div>
						<div class="inside">
							<label class="screen-reader-text" for="rw-status-select"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></label>
							<select name="rw_status" id="rw-status-select" style="width:100%;margin-bottom:10px;">
								<?php foreach ( $statuses as $slug => $info ) : ?>
									<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $row->status, $slug ); ?>>
										<?php echo esc_html( $info['label'] ); ?>
									</option>
								<?php endforeach; ?>
							</select>

							<!-- Status timestamps -->
							<?php
						$ts_fields = array(
							'contacted_at'  => __( 'Contacted', 'restwell-retreats' ),
							'qualified_at'  => __( 'Qualified', 'restwell-retreats' ),
							'booked_at'     => __( 'Booked', 'restwell-retreats' ),
							'closed_at'     => __( 'Closed', 'restwell-retreats' ),
						);
							foreach ( $ts_fields as $col => $label ) :
								if ( ! empty( $row->$col ) ) :
							?>
							<p style="margin:0 0 4px;font-size:11px;color:#787c82;">
								<?php
								printf(
									/* translators: 1: status label, 2: formatted date */
									esc_html__( '%1$s: %2$s', 'restwell-retreats' ),
									esc_html( $label ),
									esc_html( date_i18n( 'j M Y, H:i', strtotime( $row->$col ) ) )
								);
								?>
							</p>
							<?php
								endif;
							endforeach;
							?>

							<hr style="margin:12px 0;" />

							<label for="rw-follow-up" style="display:block;font-weight:600;font-size:12px;margin-bottom:4px;">
								<?php esc_html_e( 'Follow-up date', 'restwell-retreats' ); ?>
							</label>
							<input
								type="datetime-local"
								id="rw-follow-up"
								name="rw_follow_up"
								value="<?php echo esc_attr( $follow_up_value ); ?>"
								style="width:100%;"
							/>
							<p class="description" style="margin-top:4px;font-size:11px;">
								<?php esc_html_e( 'Appears on the dashboard when due.', 'restwell-retreats' ); ?>
							</p>
						</div>
					</div>

					<div class="postbox">
						<div class="postbox-header">
							<h2 class="hndle"><span><?php esc_html_e( 'Staff Notes', 'restwell-retreats' ); ?></span></h2>
						</div>
						<div class="inside">
							<label class="screen-reader-text" for="rw-staff-notes"><?php esc_html_e( 'Staff notes', 'restwell-retreats' ); ?></label>
							<textarea name="rw_notes" id="rw-staff-notes" rows="5"
							          style="width:100%;box-sizing:border-box;"
							          placeholder="<?php esc_attr_e( 'Pinned summary — not visible to the enquirer.', 'restwell-retreats' ); ?>"
							><?php echo esc_textarea( $row->staff_notes ); ?></textarea>
						</div>
					</div>

					<input type="submit" class="button button-primary button-large" style="width:100%;margin-bottom:8px;"
					       value="<?php esc_attr_e( 'Save Changes', 'restwell-retreats' ); ?>">

				</form>

				<!-- Activity log (append-only notes) -->
				<div class="postbox">
					<div class="postbox-header">
						<h2 class="hndle"><span><?php esc_html_e( 'Activity Log', 'restwell-retreats' ); ?></span></h2>
					</div>
					<div class="inside" style="padding-bottom:0;">

						<?php if ( ! empty( $notes ) ) : ?>
							<div style="margin-bottom:12px;">
								<?php foreach ( $notes as $note ) :
									$author = get_userdata( (int) $note->created_by );
									$author_name = $author ? $author->display_name : __( 'Staff', 'restwell-retreats' );
									$initial     = mb_strtoupper( mb_substr( $author_name, 0, 1 ) );
								?>
								<div style="display:flex;gap:10px;margin-bottom:12px;align-items:flex-start;">
									<div style="flex-shrink:0;width:28px;height:28px;border-radius:50%;background:#3c434a;color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;">
										<?php echo esc_html( $initial ); ?>
									</div>
									<div style="flex:1;min-width:0;">
										<div style="font-size:11px;color:#787c82;margin-bottom:3px;">
											<strong style="color:#3c434a;"><?php echo esc_html( $author_name ); ?></strong>
											&middot; <?php echo esc_html( date_i18n( 'j M Y, H:i', strtotime( $note->created_at ) ) ); ?>
										</div>
										<div style="background:#f6f7f7;border-radius:4px;padding:8px 10px;font-size:13px;white-space:pre-line;word-break:break-word;">
											<?php echo esc_html( $note->note ); ?>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<!-- Add note form -->
						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
						      style="border-top:1px solid #dcdcde;padding-top:12px;margin:0 -12px;padding:12px;">
							<?php wp_nonce_field( 'restwell_crm_add_note' ); ?>
							<input type="hidden" name="action" value="restwell_crm_add_note" />
							<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( $row->id ); ?>" />
							<label class="screen-reader-text" for="rw-new-note-<?php echo esc_attr( $row->id ); ?>">
								<?php esc_html_e( 'Add a note', 'restwell-retreats' ); ?>
							</label>
							<textarea
								id="rw-new-note-<?php echo esc_attr( $row->id ); ?>"
								name="rw_note_text"
								rows="3"
								style="width:100%;box-sizing:border-box;margin-bottom:6px;"
								placeholder="<?php esc_attr_e( 'Add a note…', 'restwell-retreats' ); ?>"
							></textarea>
							<input type="submit" class="button button-secondary" value="<?php esc_attr_e( 'Add note', 'restwell-retreats' ); ?>" />
						</form>

					</div>
				</div><!-- .postbox activity log -->

				<!-- Quick-contact buttons (outside form so they don't submit) -->
				<a href="<?php echo esc_url( $mailto ); ?>" class="button button-large" style="width:100%;text-align:center;margin-bottom:8px;box-sizing:border-box;display:block;">
					&#9993; <?php esc_html_e( 'Reply by Email', 'restwell-retreats' ); ?>
				</a>
				<?php if ( $row->phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ); ?>"
					   class="button button-large"
					   style="width:100%;text-align:center;margin-bottom:8px;box-sizing:border-box;display:block;">
						&#128222; <?php echo esc_html( $row->phone ); ?>
					</a>
				<?php endif; ?>

			<?php if ( 'booked' === $row->status ) : ?>
				<a href="<?php echo esc_url( $promote_url ); ?>"
				   class="button button-primary button-large"
				   style="width:100%;text-align:center;box-sizing:border-box;display:block;">
					&#10133; <?php esc_html_e( 'Add to Guest Guide', 'restwell-retreats' ); ?>
				</a>
			<?php endif; ?>

			<?php if ( 'closed' === $row->status && function_exists( 'restwell_email_post_stay' ) ) : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:8px;">
					<?php wp_nonce_field( 'restwell_crm_send_post_stay_' . $row->id ); ?>
					<input type="hidden" name="action" value="restwell_crm_send_post_stay" />
					<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( $row->id ); ?>" />
					<button type="submit" class="button button-large"
					        style="width:100%;box-sizing:border-box;"
					        onclick="return confirm('<?php esc_attr_e( 'Send post-stay email to this guest?', 'restwell-retreats' ); ?>');">
						&#9993; <?php esc_html_e( 'Send Post-Stay Email', 'restwell-retreats' ); ?>
					</button>
				</form>
			<?php endif; ?>

			</div><!-- right column -->

		</div><!-- grid -->
	</div><!-- .wrap -->
	<?php
}
