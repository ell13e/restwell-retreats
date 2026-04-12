<?php
/**
 * Dashboard widget: monthly SEO review reminder and quick checklist.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the SEO review dashboard widget (administrators only).
 */
function restwell_seo_register_dashboard_widget() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	wp_add_dashboard_widget(
		'restwell_seo_review',
		__( 'Restwell - SEO review (monthly)', 'restwell-retreats' ),
		'restwell_seo_dashboard_widget_render'
	);
}
add_action( 'wp_dashboard_setup', 'restwell_seo_register_dashboard_widget' );

/**
 * Render dashboard widget content.
 */
function restwell_seo_dashboard_widget_render() {
	$sitemap = esc_url( home_url( '/wp-sitemap.xml' ) );
	?>
	<p class="description"><?php esc_html_e( 'Use this list as a recurring check. Pair with Google Search Console performance and coverage reports.', 'restwell-retreats' ); ?></p>
	<ul style="list-style:disc;padding-left:1.25em;">
		<li><?php esc_html_e( 'Search Console: coverage issues, Core Web Vitals, top queries and CTR.', 'restwell-retreats' ); ?></li>
		<li><?php esc_html_e( 'Analytics: landing pages, enquiry conversions, and campaign UTMs.', 'restwell-retreats' ); ?></li>
		<li>
			<?php
			echo wp_kses_post(
				sprintf(
					/* translators: %s sitemap URL */
					__( 'Confirm the XML sitemap index is reachable: %s', 'restwell-retreats' ),
					'<a href="' . $sitemap . '">' . esc_html( $sitemap ) . '</a>'
				)
			);
			?>
		</li>
		<li><?php esc_html_e( 'Update titles/meta on pages with low CTR for their main queries.', 'restwell-retreats' ); ?></li>
		<li><?php esc_html_e( 'Refresh one older blog post with new internal links to core pages.', 'restwell-retreats' ); ?></li>
		<li><?php esc_html_e( 'Local SEO (manual): Google Business Profile, Tourism for All, DisabledHolidays, AccessAble, Euan’s Guide, Visit Kent; ask Continuity Group sites for a footer link.', 'restwell-retreats' ); ?></li>
	</ul>
	<?php
}

/**
 * Admin notice: off-site SEO tasks (directories, GBP) - shown on CRM settings screen once.
 */
function restwell_seo_local_tasks_notice() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->id !== 'toplevel_page_restwell-crm' ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="notice notice-info rw-notice--crm">
		<p><strong><?php esc_html_e( 'Off-site SEO (manual)', 'restwell-retreats' ); ?></strong></p>
		<p><?php esc_html_e( 'Complete your Google Business Profile (categories, services, photos, Q&A). Submit the site to high-relevance directories when ready: Tourism for All, DisabledHolidays, AccessAble, Euan’s Guide, Visit Kent. Request a footer link from Continuity Group sites.', 'restwell-retreats' ); ?></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'restwell_seo_local_tasks_notice' );
