<?php
/**
 * Video Optimizer - admin tool for compressing hero video files.
 *
 * Adds a panel to the Media Library attachment edit screen for any video file.
 * Requires FFmpeg to be available on the server (checks automatically).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_init', 'restwell_video_optimizer_init' );

/**
 * Register hooks when in admin.
 */
function restwell_video_optimizer_init() {
	add_filter( 'attachment_fields_to_edit', 'restwell_video_optimizer_fields', 10, 2 );
	add_action( 'admin_footer', 'restwell_video_optimizer_admin_js' );
	add_action( 'wp_ajax_restwell_optimize_video', 'restwell_ajax_optimize_video' );
}

/**
 * Detect the absolute path to the ffmpeg binary.
 *
 * @return string|false Binary path, or false if not found.
 */
function restwell_ffmpeg_path() {
	if ( ! function_exists( 'exec' ) ) {
		return false;
	}

	// Common locations - check these first so we don't rely on PATH alone.
	$candidates = array(
		'/usr/bin/ffmpeg',
		'/usr/local/bin/ffmpeg',
		'/opt/homebrew/bin/ffmpeg',
		'/opt/local/bin/ffmpeg',
	);

	foreach ( $candidates as $path ) {
		if ( is_executable( $path ) ) {
			return $path;
		}
	}

	// Fall back to whatever is on PATH.
	$output    = array();
	$exit_code = 0;
	exec( 'which ffmpeg 2>/dev/null', $output, $exit_code );

	if ( 0 === $exit_code && ! empty( $output[0] ) ) {
		return trim( $output[0] );
	}

	return false;
}

/**
 * Human-readable file size.
 *
 * @param int $bytes File size in bytes.
 * @return string Formatted string.
 */
function restwell_format_bytes( $bytes ) {
	if ( $bytes >= 1048576 ) {
		return round( $bytes / 1048576, 1 ) . ' MB';
	}
	if ( $bytes >= 1024 ) {
		return round( $bytes / 1024, 1 ) . ' KB';
	}
	return $bytes . ' B';
}

/**
 * Inject the optimizer panel into the attachment edit fields.
 *
 * @param array   $fields Existing fields.
 * @param WP_Post $post   Attachment post object.
 * @return array Modified fields.
 */
function restwell_video_optimizer_fields( $fields, $post ) {
	if ( ! current_user_can( 'upload_files' ) ) {
		return $fields;
	}

	$mime = get_post_mime_type( $post->ID );
	if ( ! $mime || strpos( $mime, 'video/' ) !== 0 ) {
		return $fields;
	}

	$file_path = get_attached_file( $post->ID );
	$file_size = $file_path && file_exists( $file_path ) ? filesize( $file_path ) : 0;
	$ffmpeg    = restwell_ffmpeg_path();

	ob_start();
	?>
	<div id="rw-video-optimizer" style="
		background: #f9f9f9;
		border: 1px solid #ddd;
		border-radius: 4px;
		padding: 16px 18px;
		margin-top: 4px;
		font-size: 13px;
		line-height: 1.6;
	">
		<strong style="display:block; margin-bottom:8px; font-size:14px;">
			⚡ Video Optimiser
		</strong>

		<p style="margin:0 0 8px;">
			<strong>Current size:</strong>
			<?php echo $file_size ? esc_html( restwell_format_bytes( $file_size ) ) : '<em>unknown</em>'; ?>
		</p>

		<?php if ( $ffmpeg ) : ?>
			<p style="margin:0 0 12px; color:#555;">
				Strips audio, scales to max 1280 px wide, and re-encodes at web quality.
				<strong>This replaces the original file</strong> - ensure you have a local backup before proceeding.
			</p>

			<p style="margin: 0 0 10px;">
				<label for="rw-video-crf" style="display:block; font-weight:600; margin-bottom:4px;">
					Quality
				</label>
				<select id="rw-video-crf" style="width:100%; max-width:240px;">
					<option value="24">High - larger file, best quality (CRF 24)</option>
					<option value="28" selected>Balanced - recommended for web (CRF 28)</option>
					<option value="32">Small - smaller file, slightly softer (CRF 32)</option>
				</select>
			</p>

			<p style="margin:0 0 10px;">
				<label for="rw-video-scale" style="display:block; font-weight:600; margin-bottom:4px;">
					Max width
				</label>
				<select id="rw-video-scale" style="width:100%; max-width:240px;">
					<option value="1920">1920 px - full HD (keep if source is 4K)</option>
					<option value="1280" selected>1280 px - recommended for backgrounds</option>
					<option value="960">960 px - smallest, fine for short clips</option>
				</select>
			</p>

			<button
				type="button"
				id="rw-optimize-btn"
				class="button button-primary"
				data-attachment-id="<?php echo absint( $post->ID ); ?>"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'rw_optimize_video_' . $post->ID ) ); ?>"
			>
				Optimise Video
			</button>

			<span id="rw-optimize-status" style="display:none; margin-left:10px; color:#555;"></span>

			<div id="rw-optimize-result" style="
				display:none;
				margin-top:14px;
				padding:10px 12px;
				border-radius:3px;
				background:#edfaed;
				border:1px solid #7ec87e;
				color:#1e4620;
			"></div>

			<div id="rw-optimize-error" style="
				display:none;
				margin-top:14px;
				padding:10px 12px;
				border-radius:3px;
				background:#fef0f0;
				border:1px solid #e07070;
				color:#6e1515;
			"></div>

		<?php else : ?>
			<p style="margin:0; padding:10px 12px; background:#fff8e1; border:1px solid #e6c200; border-radius:3px; color:#5c4a00;">
				<strong>FFmpeg not found on this server.</strong><br>
				Compress the video locally before uploading:
				<a href="https://handbrake.fr/" target="_blank" rel="noopener">HandBrake</a> (free, easy GUI)
				or run <code>ffmpeg -i input.mp4 -c:v libx264 -crf 28 -an -vf scale=1280:-2 -movflags faststart output.mp4</code>
				in your terminal.
			</p>
		<?php endif; ?>
	</div>
	<?php

	$html = ob_get_clean();

	$fields['rw_video_optimizer'] = array(
		'label' => '',
		'input' => 'html',
		'html'  => $html,
	);

	return $fields;
}

/**
 * Inline JS for the optimizer button - only output on attachment edit screens.
 */
function restwell_video_optimizer_admin_js() {
	$screen = get_current_screen();
	if ( ! $screen || 'attachment' !== $screen->id ) {
		return;
	}
	?>
	<script>
	(function () {
		var btn = document.getElementById('rw-optimize-btn');
		if (!btn) return;

		btn.addEventListener('click', function () {
			var attachmentId = btn.dataset.attachmentId;
			var nonce        = btn.dataset.nonce;
			var crf          = document.getElementById('rw-video-crf').value;
			var scale        = document.getElementById('rw-video-scale').value;
			var status       = document.getElementById('rw-optimize-status');
			var result       = document.getElementById('rw-optimize-result');
			var error        = document.getElementById('rw-optimize-error');

			if (!confirm('This will replace the video file on disk. Continue?')) return;

			btn.disabled    = true;
			btn.textContent = 'Optimising…';
			status.style.display = 'inline';
			status.textContent   = 'This may take a minute or two depending on file size.';
			result.style.display = 'none';
			error.style.display  = 'none';

			var data = new FormData();
			data.append('action',        'restwell_optimize_video');
			data.append('attachment_id', attachmentId);
			data.append('nonce',         nonce);
			data.append('crf',           crf);
			data.append('scale',         scale);

			fetch(ajaxurl, { method: 'POST', body: data })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					btn.disabled    = false;
					btn.textContent = 'Optimise Video';
					status.style.display = 'none';

					if (res.success) {
						result.style.display  = 'block';
						result.innerHTML = res.data.message;
					} else {
						error.style.display  = 'block';
						error.textContent = res.data || 'Optimisation failed. Check server logs.';
					}
				})
				.catch(function (err) {
					btn.disabled    = false;
					btn.textContent = 'Optimise Video';
					status.style.display = 'none';
					error.style.display  = 'block';
					error.textContent = 'Request failed: ' + err.message;
				});
		});
	})();
	</script>
	<?php
}

/**
 * AJAX handler - runs FFmpeg and replaces the attachment file.
 */
function restwell_ajax_optimize_video() {
	$attachment_id = isset( $_POST['attachment_id'] ) ? absint( $_POST['attachment_id'] ) : 0;

	if ( ! $attachment_id || ! current_user_can( 'upload_files' ) ) {
		wp_send_json_error( 'Permission denied.' );
	}

	check_ajax_referer( 'rw_optimize_video_' . $attachment_id, 'nonce' );

	$crf   = isset( $_POST['crf'] ) ? absint( $_POST['crf'] ) : 28;
	$scale = isset( $_POST['scale'] ) ? absint( $_POST['scale'] ) : 1280;

	// Clamp to safe ranges.
	$crf   = max( 18, min( 51, $crf ) );
	$scale = in_array( $scale, array( 960, 1280, 1920 ), true ) ? $scale : 1280;

	$ffmpeg = restwell_ffmpeg_path();
	if ( ! $ffmpeg ) {
		wp_send_json_error( 'FFmpeg is not available on this server.' );
	}

	$source = get_attached_file( $attachment_id );
	if ( ! $source || ! file_exists( $source ) ) {
		wp_send_json_error( 'Source file not found.' );
	}

	$mime = get_post_mime_type( $attachment_id );
	if ( ! $mime || strpos( $mime, 'video/' ) !== 0 ) {
		wp_send_json_error( 'Attachment is not a video.' );
	}

	$size_before = filesize( $source );
	$dir         = dirname( $source );
	$basename    = pathinfo( $source, PATHINFO_FILENAME );
	$tmp_file    = $dir . '/' . $basename . '_rw_tmp.mp4';

	// Build a safe FFmpeg command. Scale: keep aspect ratio, ensure even dimensions for codec.
	$vf_scale = 'scale=\'min(' . $scale . ',iw)\':-2';

	$cmd = sprintf(
		'%s -y -i %s -c:v libx264 -crf %d -preset medium -an -vf %s -movflags +faststart %s 2>&1',
		escapeshellcmd( $ffmpeg ),
		escapeshellarg( $source ),
		$crf,
		escapeshellarg( $vf_scale ),
		escapeshellarg( $tmp_file )
	);

	// Allow long-running request.
	set_time_limit( 300 );

	$output    = array();
	$exit_code = 0;
	exec( $cmd, $output, $exit_code );

	if ( 0 !== $exit_code || ! file_exists( $tmp_file ) ) {
		if ( file_exists( $tmp_file ) ) {
			unlink( $tmp_file );
		}
		$log = implode( "\n", array_slice( $output, -10 ) );
		wp_send_json_error( 'FFmpeg failed (exit ' . $exit_code . '). Last output: ' . $log );
	}

	$size_after = filesize( $tmp_file );

	// Sanity check - if the result is larger, bail.
	if ( $size_after >= $size_before ) {
		unlink( $tmp_file );
		wp_send_json_error( 'Optimised file would be larger than the original (' . restwell_format_bytes( $size_after ) . ' vs ' . restwell_format_bytes( $size_before ) . '). No changes made.' );
	}

	// Replace the original.
	rename( $tmp_file, $source );

	// Update attachment metadata so WordPress knows about the new file.
	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $source ) );

	$saved   = $size_before - $size_after;
	$percent = $size_before > 0 ? round( ( $saved / $size_before ) * 100 ) : 0;

	wp_send_json_success(
		array(
			'message' => sprintf(
				'<strong>Done!</strong> %s → %s &nbsp;·&nbsp; saved %s (%d%%)',
				esc_html( restwell_format_bytes( $size_before ) ),
				esc_html( restwell_format_bytes( $size_after ) ),
				esc_html( restwell_format_bytes( $saved ) ),
				$percent
			),
		)
	);
}
