<?php
/**
 * Branded HTML email templates for Restwell Retreats.
 *
 * Every public function returns a two-element array:
 *   [ 'subject' => string, 'body' => string, 'headers' => array ]
 * ready to be passed directly to wp_mail().
 *
 * Design tokens (matching input.css):
 *   Deep teal  #1B4D5C
 *   Warm gold  #D4A853
 *   Sea glass  #A8D5D0
 *   Soft sand  #F5EDE0
 *   Muted grey #6B6355
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---------------------------------------------------------------------------
// Internal helpers
// ---------------------------------------------------------------------------

/**
 * Wrap arbitrary HTML body content in the shared Restwell email shell.
 *
 * @param string $content  Inner HTML to drop into the body section.
 * @param string $preview  Short preview-text string (hidden pre-header).
 * @return string          Full HTML email document.
 */
function restwell_email_wrap( string $content, string $preview = '' ): string {
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$home       = esc_url( home_url( '/' ) );
	$year       = gmdate( 'Y' );
	$phone      = esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) );
	$pre_header = $preview
		? '<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;color:#F5EDE0;line-height:1px;">' . esc_html( $preview ) . '&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;</div>'
		: '';

	return '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="x-apple-disable-message-reformatting">
<title>' . esc_html( $site ) . '</title>
<!--[if !mso]><!-->
<style type="text/css">
  /* Self-hosted fonts - work in Apple Mail, Yahoo, Samsung. Gmail strips <style>; fallbacks handle it. */
  @font-face {
    font-family: "Inter";
    src: url("' . esc_url( get_template_directory_uri() ) . '/assets/fonts/inter/Inter-VariableFont_opsz,wght.ttf") format("truetype");
    font-weight: 100 900;
    font-style: normal;
  }
  @font-face {
    font-family: "Inter";
    src: url("' . esc_url( get_template_directory_uri() ) . '/assets/fonts/inter/Inter-Italic-VariableFont_opsz,wght.ttf") format("truetype");
    font-weight: 100 900;
    font-style: italic;
  }
  @font-face {
    font-family: "Lora";
    src: url("' . esc_url( get_template_directory_uri() ) . '/assets/fonts/lora/Lora-VariableFont_wght.ttf") format("truetype");
    font-weight: 400 700;
    font-style: normal;
  }
  @font-face {
    font-family: "Lora";
    src: url("' . esc_url( get_template_directory_uri() ) . '/assets/fonts/lora/Lora-Italic-VariableFont_wght.ttf") format("truetype");
    font-weight: 400 700;
    font-style: italic;
  }
</style>
<!--<![endif]-->
<!--[if mso]>
<noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
<![endif]-->
</head>
<body style="margin:0;padding:0;background-color:#EFEFEF;font-family:\'Inter\',system-ui,Arial,sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
' . $pre_header . '

<!-- Email wrapper -->
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#EFEFEF;">
<tr><td style="padding:24px 12px;">

  <!-- 600px card -->
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" align="center" style="max-width:600px;width:100%;background-color:#FFFFFF;border-radius:4px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">

    <!-- ─── HEADER ────────────────────────────────────────────── -->
    <tr>
      <td bgcolor="#1B4D5C" style="background-color:#1B4D5C;padding:36px 40px 0 40px;text-align:center;">
        <a href="' . $home . '" style="text-decoration:none;">
          <p style="margin:0;font-family:\'Lora\',Georgia,serif;font-size:26px;font-weight:normal;letter-spacing:0.04em;color:#FFFFFF;line-height:1.2;">' . esc_html( $site ) . '</p>
          <p style="margin:6px 0 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;letter-spacing:0.2em;text-transform:uppercase;color:#A8D5D0;">Accessible holidays &middot; Whitstable, Kent</p>
        </a>
        <!-- gold rule -->
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:28px;">
          <tr><td height="3" style="background-color:#D4A853;font-size:0;line-height:0;">&nbsp;</td></tr>
        </table>
      </td>
    </tr>

    <!-- ─── BODY ──────────────────────────────────────────────── -->
    <tr>
      <td style="padding:40px 40px 36px 40px;background-color:#FFFFFF;">
' . $content . '
      </td>
    </tr>

    <!-- ─── FOOTER ────────────────────────────────────────────── -->
    <tr>
      <td bgcolor="#F5EDE0" style="background-color:#F5EDE0;padding:24px 40px;text-align:center;border-top:1px solid #E8DFD0;">
        <p style="margin:0 0 6px 0;font-family:\'Lora\',Georgia,serif;font-size:14px;color:#1B4D5C;font-weight:normal;">' . esc_html( $site ) . '</p>
        <p style="margin:0 0 10px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:12px;color:#6B6355;line-height:1.6;">
          hello@restwellretreats.co.uk &nbsp;&bull;&nbsp; ' . $phone . '
        </p>
        <p style="margin:0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;color:#9E9589;line-height:1.6;">
          &copy; ' . $year . ' ' . esc_html( $site ) . '. All rights reserved.
        </p>
      </td>
    </tr>

  </table>
  <!-- /600px card -->

</td></tr>
</table>
<!-- /Email wrapper -->

</body>
</html>';
}

/**
 * Render a full-width teal banner (used as the first element inside the body cell).
 *
 * @param string $label   Small uppercase eyebrow label.
 * @param string $heading Main heading text.
 * @return string HTML snippet.
 */
function restwell_email_banner( string $label, string $heading ): string {
	return '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:-40px -40px 32px -40px;width:calc(100% + 80px);">
  <tr>
    <td bgcolor="#1B4D5C" style="background-color:#1B4D5C;padding:32px 40px;text-align:center;">
        <p style="margin:0 0 8px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;letter-spacing:0.2em;text-transform:uppercase;color:#F0C97A;">' . esc_html( $label ) . '</p>
      <h1 style="margin:0;font-family:\'Lora\',Georgia,serif;font-size:24px;font-weight:normal;color:#FFFFFF;line-height:1.3;">' . esc_html( $heading ) . '</h1>
    </td>
  </tr>
</table>';
}

/**
 * Render a CTA button (centred).
 *
 * @param string $url   Destination URL.
 * @param string $label Button text.
 * @param string $color Background colour (hex). Defaults to deep teal.
 * @return string HTML snippet.
 */
function restwell_email_button( string $url, string $label, string $color = '#1B4D5C' ): string {
	return '<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin:28px auto 0 auto;">
  <tr>
    <td style="border-radius:3px;background-color:' . esc_attr( $color ) . ';">
      <a href="' . esc_url( $url ) . '" target="_blank" style="display:inline-block;padding:14px 32px;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:14px;font-weight:600;letter-spacing:0.04em;color:#FFFFFF;text-decoration:none;border-radius:3px;">' . esc_html( $label ) . '</a>
    </td>
  </tr>
</table>
<p style="text-align:center;margin:12px 0 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;color:#9E9589;">
  Or copy this link: <a href="' . esc_url( $url ) . '" style="color:#1B4D5C;word-break:break-all;">' . esc_url( $url ) . '</a>
</p>';
}

/**
 * Render a key-value info row (light sand background).
 *
 * @param array<string,string> $rows Associative array of label => value.
 * @return string HTML snippet.
 */
function restwell_email_info_table( array $rows ): string {
	$html = '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:20px 0;border-radius:3px;overflow:hidden;">';
	$i    = 0;
	foreach ( $rows as $label => $value ) {
		$bg    = ( $i % 2 === 0 ) ? '#F5EDE0' : '#FAF5EE';
		$html .= '<tr>
      <td width="36%" style="background-color:' . $bg . ';padding:10px 14px;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:12px;font-weight:600;color:#1B4D5C;vertical-align:top;">' . esc_html( $label ) . '</td>
      <td width="64%" style="background-color:' . $bg . ';padding:10px 14px;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#2d4a52;vertical-align:top;">' . wp_kses_post( $value ) . '</td>
    </tr>';
		++$i;
	}
	$html .= '</table>';
	return $html;
}

/**
 * Shared sign-off block.
 *
 * @return string HTML snippet.
 */
function restwell_email_signoff(): string {
	$site = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	return '<p style="margin:28px 0 0 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
  Warm regards,<br>
  <strong>The Restwell team</strong>
</p>';
}

// ---------------------------------------------------------------------------
// 1. Enquiry acknowledgement
// ---------------------------------------------------------------------------

/**
 * Build the HTML enquiry acknowledgement email sent to the person who enquired.
 *
 * @param string $name    Enquirer's name.
 * @param string $email   Enquirer's email address.
 * @param bool   $urgent  Whether the enquiry was marked urgent.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_enquiry_ack( string $name, string $email, bool $urgent = false ): array {
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$first_name = explode( ' ', trim( $name ) )[0];

	$subject = $site . ' | ' . __( "We've received your enquiry", 'restwell-retreats' );
	$preview = __( "Thank you for getting in touch. We'll be with you shortly.", 'restwell-retreats' );

	$urgent_note = $urgent
		? '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:20px 0;">
        <tr>
          <td style="background-color:#FEF3C7;border-left:4px solid #D4A853;border-radius:3px;padding:14px 16px;">
            <p style="margin:0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#92400E;line-height:1.6;">
			<strong>Your enquiry has been flagged as urgent.</strong> A member of our team will aim to contact you as a priority. If you need to speak with us sooner, please call <strong>' . esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) ) . '</strong> and quote your name.
            </p>
          </td>
        </tr>
      </table>'
		: '';

	$steps = array(
		'1.' => "We've logged your enquiry and our team has been notified.",
		'2.' => 'A member of staff will review your details and contact you - usually within one working day.',
		'3.' => 'If your plans change in the meantime, simply reply to this email.',
	);

	$steps_html = '';
	foreach ( $steps as $num => $text ) {
		$steps_html .= '<tr>
      <td width="32" valign="top" style="padding:0 12px 14px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;font-weight:600;color:#D4A853;">' . esc_html( $num ) . '</td>
      <td valign="top" style="padding:0 0 14px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:14px;color:#2d4a52;line-height:1.6;">' . esc_html( $text ) . '</td>
    </tr>';
	}

	$content = restwell_email_banner( 'Enquiry received', 'Thank you, ' . $first_name . '.' )
		. '<p style="margin:0 0 20px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    Thank you for getting in touch. Your enquiry is with our team and someone will be back to you - usually within one working day.
  </p>'
		. $urgent_note
		. '<p style="margin:0 0 12px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;color:#6B6355;">What happens next</p>
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">'
		. $steps_html
		. '</table>
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:20px 0;">
    <tr>
      <td style="background-color:#F5EDE0;border-radius:3px;padding:18px 20px;text-align:center;">
        <p style="margin:0 0 4px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:#6B6355;">Questions? Reach us directly</p>
        <p style="margin:0;font-family:\'Lora\',Georgia,serif;font-size:20px;color:#1B4D5C;">' . esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) ) . '</p>
      </td>
    </tr>
  </table>'
		. restwell_email_signoff();

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'Reply-To: ' . $site . ' <hello@restwellretreats.co.uk>',
	);

	return array(
		'subject' => $subject,
		'body'    => restwell_email_wrap( $content, $preview ),
		'headers' => $headers,
	);
}

// ---------------------------------------------------------------------------
// 2. Guest Guide invitation
// ---------------------------------------------------------------------------

/**
 * Build the guest guide invitation email sent when a guest is added.
 *
 * @param string $email     Guest's email address.
 * @param string $name      Guest's display name (optional).
 * @param string $guide_url URL of the guest guide page.
 * @param array  $cc_list   Array of CC email addresses.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_guest_guide_invite( string $email, string $name, string $guide_url, array $cc_list = array() ): array {
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$first_name = $name ? explode( ' ', trim( $name ) )[0] : 'there';
	$greeting   = $name ? 'Dear ' . $first_name : 'Dear guest';

	$subject = sprintf(
		/* translators: %s - site name */
		__( 'Your arrival guide is ready - %s', 'restwell-retreats' ),
		$site
	);
	$preview = __( "Everything you need for your upcoming stay is now available online.", 'restwell-retreats' );

	$how_to_rows = array(
		__( 'Step 1', 'restwell-retreats' ) => __( 'Click the button below (or visit the link at the bottom of this email).', 'restwell-retreats' ),
		__( 'Step 2', 'restwell-retreats' ) => sprintf(
			/* translators: %s - guest email */
			__( 'Enter your email address: <strong>%s</strong>', 'restwell-retreats' ),
			esc_html( $email )
		),
		__( 'Step 3', 'restwell-retreats' ) => __( 'We\'ll send a one-time access code to this address - just enter it to unlock your guide.', 'restwell-retreats' ),
	);

	$content = restwell_email_banner( 'Your arrival guide', 'Everything ready for your stay.' )
		. '<p style="margin:0 0 20px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    ' . esc_html( $greeting ) . ',<br><br>
    Your arrival guide for ' . esc_html( $site ) . ' is now ready. It covers check-in details, the property layout, local area information, and emergency contacts - everything you need before you arrive.
  </p>'
		. restwell_email_info_table( $how_to_rows )
		. restwell_email_button( $guide_url, 'Open My Arrival Guide →' )
		. '<p style="margin:28px 0 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#6B6355;line-height:1.7;border-top:1px solid #E8DFD0;padding-top:20px;">
    If you have any questions before your stay, please don\'t hesitate to reach out.<br>
    Call us on <strong style="color:#1B4D5C;">' . esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) ) . '</strong> or reply to this email - we\'re happy to help.
  </p>'
		. restwell_email_signoff();

	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	if ( ! empty( $cc_list ) ) {
		$headers[] = 'Cc: ' . implode( ', ', $cc_list );
	}

	return array(
		'subject' => $subject,
		'body'    => restwell_email_wrap( $content, $preview ),
		'headers' => $headers,
	);
}

// ---------------------------------------------------------------------------
// 3. One-time access code (OTP)
// ---------------------------------------------------------------------------

/**
 * Build the guest guide OTP email.
 *
 * @param string $email Guest's email address.
 * @param string $code  6-digit OTP code.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_otp( string $email, string $code ): array {
	$site    = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$subject = $site . ' | ' . __( 'Your guest guide access code', 'restwell-retreats' );
	$preview = sprintf(
		/* translators: %s - 6-digit OTP code */
		__( 'Your one-time code is: %s - valid for 30 minutes.', 'restwell-retreats' ),
		$code
	);

	// Split code into individual digits for large display.
	$digits      = str_split( $code );
	$digits_html = '';
	foreach ( $digits as $digit ) {
		$digits_html .= '<td style="padding:0 4px;">
      <span style="display:inline-block;width:42px;height:52px;line-height:52px;text-align:center;font-family:\'Courier New\',Courier,monospace;font-size:28px;font-weight:bold;color:#1B4D5C;background-color:#F5EDE0;border:2px solid #D4A853;border-radius:4px;">' . esc_html( $digit ) . '</span>
    </td>';
	}

	$content = restwell_email_banner( 'Access code', 'Your one-time login code.' )
		. '<p style="margin:0 0 24px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    Here is your one-time access code for the ' . esc_html( $site ) . ' Guest Arrival Guide:
  </p>
  <!-- Code digits -->
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin:0 auto 24px auto;">
    <tr>' . $digits_html . '</tr>
  </table>
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom:24px;">
    <tr>
      <td style="background-color:#FEF3C7;border-radius:3px;padding:12px 16px;text-align:center;">
        <p style="margin:0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#92400E;">
          ⏱ This code is valid for <strong>30 minutes</strong>. Do not share it with anyone.
        </p>
      </td>
    </tr>
  </table>
  <p style="margin:0 0 8px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#6B6355;line-height:1.7;">
    If you didn\'t request this code, please disregard this email - your account has not been accessed.
  </p>
  <p style="margin:0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#6B6355;line-height:1.7;">
    Need help? Call us on <strong style="color:#1B4D5C;">' . esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) ) . '</strong>.
  </p>'
		. restwell_email_signoff();

	return array(
		'subject' => $subject,
		'body'    => restwell_email_wrap( $content, $preview ),
		'headers' => array( 'Content-Type: text/html; charset=UTF-8' ),
	);
}

// ---------------------------------------------------------------------------
// 4. Booking confirmation
// ---------------------------------------------------------------------------

/**
 * Build the booking confirmation email sent to a guest when their status
 * first transitions to "Booked" in the CRM.
 *
 * @param string $name  Guest's display name.
 * @param string $email Guest's email address.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_booking_confirmed( string $name, string $email ): array {
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$first_name = $name ? explode( ' ', trim( $name ) )[0] : 'there';
	$enquire    = esc_url( home_url( '/enquire/' ) );
	$subject    = $site . ' | ' . __( 'Your booking is confirmed', 'restwell-retreats' );
	$preview    = __( 'Great news - your stay at Restwell Retreats is confirmed. We look forward to welcoming you.', 'restwell-retreats' );

	$next_steps = array(
		__( 'What to bring', 'restwell-retreats' )       => __( 'Any medications, mobility equipment you use regularly, and anything personal that helps you feel settled. Linen, towels, and kitchen basics are provided.', 'restwell-retreats' ),
		__( 'Arrival', 'restwell-retreats' )             => __( 'Check-in is from 2 pm. If you need an earlier or later time - for example, to allow time for equipment setup - let us know and we will do our best to accommodate.', 'restwell-retreats' ),
		__( 'Your arrival guide', 'restwell-retreats' )  => __( 'We\'ll send your personalised arrival guide by email closer to your stay date. It contains everything you need - directions, house notes, and local information.', 'restwell-retreats' ),
	);

	$content = restwell_email_banner( 'Booking confirmed', 'We\'re looking forward to welcoming you.' )
		. '<p style="margin:0 0 20px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    Dear ' . esc_html( $first_name ) . ',<br><br>
    Your booking at ' . esc_html( $site ) . ' is confirmed. We are looking forward to welcoming you.
  </p>'
		. restwell_email_info_table( $next_steps )
		. '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:24px 0 0 0;">
    <tr>
      <td style="background-color:#F5EDE0;border-radius:3px;padding:18px 20px;text-align:center;">
        <p style="margin:0 0 4px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:#6B6355;">Questions before your stay?</p>
        <p style="margin:0;font-family:\'Lora\',Georgia,serif;font-size:20px;color:#1B4D5C;">' . esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) ) . '</p>
        <p style="margin:4px 0 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:12px;color:#6B6355;">Or reply to this email - we\'re always happy to help.</p>
      </td>
    </tr>
  </table>'
		. restwell_email_signoff();

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'Reply-To: ' . $site . ' <hello@restwellretreats.co.uk>',
	);

	return array(
		'subject' => $subject,
		'body'    => restwell_email_wrap( $content, $preview ),
		'headers' => $headers,
	);
}

// ---------------------------------------------------------------------------
// 5. Post-stay thank you
// ---------------------------------------------------------------------------

/**
 * Build the post-stay "thank you for staying" email.
 *
 * This function returns the compiled email array. Call it after a guest's
 * departure date - you can hook it to a cron job or trigger it manually
 * from the Guest Guide admin once departure tracking is in place.
 *
 * @param string $email      Guest's email address.
 * @param string $name       Guest's display name.
 * @param string $stay_dates Optional human-readable stay dates (e.g. "14-17 April 2025").
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_post_stay( string $email, string $name, string $stay_dates = '' ): array {
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$enquire    = esc_url( home_url( '/enquire/' ) );
	$first_name = $name ? explode( ' ', trim( $name ) )[0] : 'there';
	$subject    = $site . ' | ' . __( 'Thank you for staying with us', 'restwell-retreats' );
	$preview    = __( "It was a pleasure having you. We hope you felt truly at home.", 'restwell-retreats' );

	$dates_row = $stay_dates
		? restwell_email_info_table( array( __( 'Stay', 'restwell-retreats' ) => esc_html( $stay_dates ) ) )
		: '';

	$content = restwell_email_banner( 'Until next time', 'It was a pleasure having you.' )
		. '<p style="margin:0 0 20px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    Dear ' . esc_html( $first_name ) . ',<br><br>
    We hope you are settling back in. It was our pleasure to have you, and we hope the stay gave you and your family the break you needed.
  </p>'
		. $dates_row
		. '
  <p style="margin:0 0 16px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:14px;color:#2d4a52;line-height:1.7;">
    Should you wish to visit us again - for yourself or someone close to you - we\'d love to welcome you back. You\'re always welcome here.
  </p>
  <p style="margin:0 0 8px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#6B6355;line-height:1.7;">
    If you are happy to share your experience - even a sentence or two - it helps other families decide whether Restwell is right for them. You can reply to this email with your thoughts, or let us know if you would prefer us to send a short form.
  </p>'
		. restwell_email_button( $enquire, 'Enquire About a Return Stay', '#D4A853' )
		. '<p style="margin:28px 0 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#6B6355;line-height:1.7;border-top:1px solid #E8DFD0;padding-top:20px;">
    If there is anything we could do better, please reply to this email. Honest feedback helps us improve for every guest who follows.
  </p>'
		. restwell_email_signoff();

	return array(
		'subject' => $subject,
		'body'    => restwell_email_wrap( $content, $preview ),
		'headers' => array( 'Content-Type: text/html; charset=UTF-8' ),
	);
}

/**
 * Convenience wrapper - send the post-stay thank you directly via wp_mail().
 *
 * @param string $email      Guest's email address.
 * @param string $name       Guest's display name.
 * @param string $stay_dates Optional human-readable stay dates.
 * @return bool Whether wp_mail() reported success.
 */
function restwell_send_post_stay_email( string $email, string $name, string $stay_dates = '' ): bool {
	$mail = restwell_email_post_stay( $email, $name, $stay_dates );
	return (bool) wp_mail( $email, $mail['subject'], $mail['body'], $mail['headers'] );
}
