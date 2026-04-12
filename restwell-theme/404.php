<?php
/**
 * 404 - Page not found template.
 *
 * Shown whenever WordPress cannot match a URL to a page, post, or archive.
 * Sends the correct HTTP 404 status (WordPress handles this automatically
 * for 404.php). The footer "Ready to book?" CTA is suppressed - it is not
 * the right moment for a hard sell.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Suppress the footer CTA strip.
$GLOBALS['restwell_hide_footer_cta'] = true;

get_header();
?>

<main id="main-content">

	<?php
	$decor_404 = '<span aria-hidden="true" class="pointer-events-none select-none absolute inset-0 z-[5] flex items-center justify-center font-serif leading-none text-[18rem] md:text-[24rem] text-white/[0.04]">404</span>';
	set_query_var(
		'args',
		array(
			'heading_id'         => 'error-404-heading',
			'label'              => __( 'Page not found', 'restwell-retreats' ),
			'heading'            => __( "We couldn't find that page.", 'restwell-retreats' ),
			'intro'              => __( 'It may have moved, or the address was mistyped. Here are a few places to start from.', 'restwell-retreats' ),
			'media_id'           => 0,
			'content_max'        => 'max-w-2xl mx-auto text-center',
			'min_height_class'   => 'min-h-[24rem] md:min-h-[32rem]',
			'section_decor_html' => $decor_404,
			'cta_primary'        => array(
				'label' => __( 'Back to home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<!-- ─── Helpful links ─────────────────────────────────────────────────────── -->
	<section
		class="py-16 md:py-24 bg-[var(--soft-sand)]"
		aria-label="<?php esc_attr_e( 'Helpful pages', 'restwell-retreats' ); ?>"
	>
		<div class="container">
			<div class="grid sm:grid-cols-3 gap-6 lg:gap-8 max-w-4xl mx-auto">

				<!-- The property -->
				<div class="group bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col items-start gap-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-house feature-icon-svg text-[var(--deep-teal)]" aria-hidden="true"></i>
					</div>
					<div class="flex-1">
						<h2 class="text-xl font-serif text-[var(--deep-teal)] mb-2">
							<?php esc_html_e( 'The property', 'restwell-retreats' ); ?>
						</h2>
						<p class="text-sm text-[var(--body-secondary)] leading-relaxed">
							<?php
						printf(
							/* translators: %s - property address */
							esc_html__( 'See %s - our accessible Whitstable home.', 'restwell-retreats' ),
							esc_html( (string) get_option( 'restwell_property_address', '101 Russell Drive' ) )
						);
						?>
						</p>
					</div>
					<a
						href="<?php echo esc_url( home_url( '/the-property/' ) ); ?>"
						class="inline-flex items-center gap-2 text-[var(--deep-teal)] font-semibold text-sm hover:text-[var(--warm-gold-text)] hover:underline transition-colors duration-300 no-underline"
					>
						<?php esc_html_e( 'View the property', 'restwell-retreats' ); ?>
						<i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
					</a>
				</div>

				<!-- Enquire -->
				<div class="group bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col items-start gap-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-envelope feature-icon-svg text-[var(--deep-teal)]" aria-hidden="true"></i>
					</div>
					<div class="flex-1">
						<h2 class="text-xl font-serif text-[var(--deep-teal)] mb-2">
							<?php esc_html_e( 'Enquire', 'restwell-retreats' ); ?>
						</h2>
						<p class="text-sm text-[var(--body-secondary)] leading-relaxed">
							<?php esc_html_e( 'Ask about availability, dates, or anything at all.', 'restwell-retreats' ); ?>
						</p>
					</div>
					<a
						href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>"
						class="inline-flex items-center gap-2 text-[var(--deep-teal)] font-semibold text-sm hover:text-[var(--warm-gold-text)] hover:underline transition-colors duration-300 no-underline"
					>
						<?php esc_html_e( 'Get in touch', 'restwell-retreats' ); ?>
						<i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
					</a>
				</div>

				<!-- How it works -->
				<div class="group bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col items-start gap-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-circle-info feature-icon-svg text-[var(--deep-teal)]" aria-hidden="true"></i>
					</div>
					<div class="flex-1">
						<h2 class="text-xl font-serif text-[var(--deep-teal)] mb-2">
							<?php esc_html_e( 'How it works', 'restwell-retreats' ); ?>
						</h2>
						<p class="text-sm text-[var(--body-secondary)] leading-relaxed">
							<?php esc_html_e( 'How booking works - from first enquiry to arrival day.', 'restwell-retreats' ); ?>
						</p>
					</div>
					<a
						href="<?php echo esc_url( home_url( '/how-it-works/' ) ); ?>"
						class="inline-flex items-center gap-2 text-[var(--deep-teal)] font-semibold text-sm hover:text-[var(--warm-gold-text)] hover:underline transition-colors duration-300 no-underline"
					>
						<?php esc_html_e( 'Find out more', 'restwell-retreats' ); ?>
						<i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
					</a>
				</div>

			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
