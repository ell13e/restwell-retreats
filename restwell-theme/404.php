<?php
/**
 * 404 — Page not found template.
 *
 * Shown whenever WordPress cannot match a URL to a page, post, or archive.
 * Sends the correct HTTP 404 status (WordPress handles this automatically
 * for 404.php). The footer "Ready to book?" CTA is suppressed — it is not
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

	<!-- ─── Hero ─────────────────────────────────────────────────────────────── -->
	<section
		class="relative overflow-hidden bg-[var(--deep-teal)] py-20 md:py-32"
		aria-labelledby="error-404-heading"
	>
		<!-- Decorative numeral: large, faint, behind content. Hidden from AT. -->
		<span
			aria-hidden="true"
			class="pointer-events-none select-none absolute inset-0 flex items-center justify-center font-serif leading-none text-[18rem] md:text-[24rem] text-white/[0.04]"
		>404</span>

		<div class="relative z-10 container">
			<div class="max-w-2xl mx-auto text-center">

				<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.15em] mb-4 font-sans">
					<?php esc_html_e( 'Page not found', 'restwell-retreats' ); ?>
				</p>

				<h1
					id="error-404-heading"
					class="text-4xl md:text-5xl font-serif text-white leading-tight mb-5"
				>
					<?php esc_html_e( "We couldn't find that page.", 'restwell-retreats' ); ?>
				</h1>

				<p class="text-lg text-white/80 leading-relaxed max-w-prose mx-auto mb-8">
					<?php esc_html_e( "It may have moved, or the address was mistyped. Here are a few places to start from.", 'restwell-retreats' ); ?>
				</p>

				<a
					href="<?php echo esc_url( home_url( '/' ) ); ?>"
					class="btn btn-gold btn-sm"
				>
					<?php esc_html_e( 'Back to home', 'restwell-retreats' ); ?>
					<i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
				</a>

			</div>
		</div>
	</section>

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
							/* translators: %s — property address */
							esc_html__( 'See %s — our accessible Whitstable home.', 'restwell-retreats' ),
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
							<?php esc_html_e( 'How booking works — from first enquiry to arrival day.', 'restwell-retreats' ); ?>
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
