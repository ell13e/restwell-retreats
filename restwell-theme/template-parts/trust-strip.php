<?php
/**
 * Homepage trust strip: Continuity intro + partner & CQC links in one panel.
 *
 * Styling aligns with {@see front-page.php} property spotlight panel + testimonial headings.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$a = (array) get_query_var( 'args', array() );

$section_class    = isset( $a['section_class'] ) ? (string) $a['section_class'] : '';
$container_class  = isset( $a['container_class'] ) ? (string) $a['container_class'] : 'max-w-5xl mx-auto';
$trust_label      = isset( $a['trust_label'] ) ? (string) $a['trust_label'] : '';
$trust_heading    = isset( $a['trust_heading'] ) ? (string) $a['trust_heading'] : '';
$trust_badge_id   = isset( $a['trust_badge_image_id'] ) ? absint( $a['trust_badge_image_id'] ) : 0;
$show_partner     = ! empty( $a['show_trust_partner'] );
$show_cqc         = ! empty( $a['show_trust_cqc_card'] );
$line_primary     = isset( $a['trust_line_primary'] ) ? (string) $a['trust_line_primary'] : '';
$trust_line_full  = isset( $a['trust_line'] ) ? (string) $a['trust_line'] : '';
$line_secondary   = isset( $a['trust_line_secondary'] ) ? (string) $a['trust_line_secondary'] : '';
$partner_url      = isset( $a['trust_partner_url'] ) ? (string) $a['trust_partner_url'] : '';
$cqc_url          = isset( $a['trust_cqc_profile_url'] ) ? (string) $a['trust_cqc_profile_url'] : '';

$trust_intro = apply_filters(
	'restwell_trust_strip_intro',
	__(
		"You book the whole bungalow as a self-catering stay. Your space, your pace. Professional care is not bundled into the booking unless you choose it.\n\nIf you want regulated support while you are here, we introduce Continuity of Care Services: Kent-based and registered with the CQC. You agree what that looks like directly with them, from a short daily check-in to more hands-on help.",
		'restwell-retreats'
	)
);

$has_trust_links = ( $show_partner && $partner_url !== '' ) || ( $show_cqc && $cqc_url !== '' );
$show_trust_panel = ( is_string( $trust_intro ) && $trust_intro !== '' ) || $has_trust_links;

/*
 * Visible eyebrow + heading. Post meta often leaves these empty; defaults keep the section scannable.
 * Override per page via trust_label / trust_heading meta, or filters below.
 */
if ( $show_trust_panel ) {
	if ( $trust_heading === '' ) {
		$trust_heading = apply_filters(
			'restwell_trust_strip_heading_default',
			__( 'Care on your terms', 'restwell-retreats' )
		);
		if ( ! is_string( $trust_heading ) || $trust_heading === '' ) {
			$trust_heading = __( 'Care on your terms', 'restwell-retreats' );
		}
	}
	if ( $trust_label === '' ) {
		$trust_label = apply_filters(
			'restwell_trust_strip_label_default',
			__( 'Care if you need it', 'restwell-retreats' )
		);
		if ( ! is_string( $trust_label ) || $trust_label === '' ) {
			$trust_label = __( 'Care if you need it', 'restwell-retreats' );
		}
	}
}

$trust_strip_heading_id = 'trust-strip-heading';

/* Same shell as property spotlight + subtle ring (see property-section__figure) */
$trust_panel_shell = 'overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-black/[0.04] transition-shadow duration-300 ease-out hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] motion-reduce:transition-none motion-reduce:hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)]';

/*
 * Padding matches homepage surfaces ({@see front-page.php} $rw_fp_card_pad on testimonials / who cards).
 * Divided layouts elsewhere use the same numeric scale (e.g. template-property.php essentials strip, py-8 px-5).
 */
$trust_cell_class = 'group flex min-h-0 flex-1 flex-col gap-4 px-6 py-7 text-left no-underline transition-colors duration-200 md:min-w-0 md:p-8 focus-visible:outline focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-[var(--deep-teal)] hover:bg-[var(--bg-subtle)]/70 motion-reduce:transition-none motion-reduce:hover:bg-transparent';
?>
<section
	class="<?php echo esc_attr( trim( $section_class ) ); ?>"
	<?php if ( $trust_heading !== '' ) : ?>
	aria-labelledby="<?php echo esc_attr( $trust_strip_heading_id ); ?>"
	<?php else : ?>
	aria-label="<?php echo esc_attr__( 'Care partner and CQC verification', 'restwell-retreats' ); ?>"
	<?php endif; ?>
>
	<div class="container <?php echo esc_attr( $container_class ); ?>">
		<?php if ( $trust_label !== '' || $trust_heading !== '' || $trust_badge_id ) : ?>
		<div class="rw-section-head rw-section-head--center rw-section-head--tight rw-section-head--trust-strip">
			<?php if ( $trust_badge_id ) : ?>
				<div class="flex justify-center">
					<?php
					echo wp_get_attachment_image(
						$trust_badge_id,
						'medium',
						false,
						array(
							'class'    => 'h-14 w-auto object-contain md:h-16',
							'alt'      => __( 'CQC regulated care provider accreditation', 'restwell-retreats' ),
							'loading'  => 'lazy',
							'decoding' => 'async',
							'sizes'    => '200px',
						)
					);
					?>
				</div>
			<?php endif; ?>
			<?php if ( $trust_label !== '' ) : ?>
				<p class="section-label"><?php echo esc_html( $trust_label ); ?></p>
			<?php endif; ?>
			<?php if ( $trust_heading !== '' ) : ?>
				<h2 id="<?php echo esc_attr( $trust_strip_heading_id ); ?>" class="text-3xl md:text-4xl section-heading m-0 text-balance text-[var(--deep-teal)]"><?php echo esc_html( $trust_heading ); ?></h2>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php if ( $show_trust_panel ) : ?>
		<div class="<?php echo esc_attr( $trust_panel_shell ); ?>">
			<?php if ( is_string( $trust_intro ) && $trust_intro !== '' ) : ?>
			<div class="border-b border-gray-200/90 bg-[var(--bg-subtle)] px-7 pb-8 pt-6 sm:px-8 sm:pb-9 md:p-8">
				<div class="mx-auto max-w-prose text-pretty text-base leading-relaxed text-[var(--body-secondary)] text-left sm:text-center sm:text-[1.05rem] [&_p]:mb-3 [&_p:last-child]:mb-0">
					<?php echo wp_kses_post( wpautop( $trust_intro ) ); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( $has_trust_links ) : ?>
			<div class="flex flex-col divide-y divide-gray-200/85 bg-white md:flex-row md:divide-x md:divide-y-0 md:divide-gray-200/85">
				<?php if ( $show_partner && $partner_url !== '' ) : ?>
					<a
						class="<?php echo esc_attr( $trust_cell_class ); ?>"
						href="<?php echo esc_url( $partner_url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<span class="flex w-full min-h-5 items-center justify-between gap-3">
							<span class="text-[0.68rem] font-semibold uppercase tracking-[0.14em] text-[var(--warm-gold-text)] font-sans leading-none"><?php esc_html_e( 'Provider site', 'restwell-retreats' ); ?></span>
							<i class="ph-bold ph-arrow-square-out inline-flex shrink-0 text-base leading-none text-[var(--deep-teal)]/45 transition-colors duration-200 group-hover:text-[var(--deep-teal)] motion-reduce:transition-none" aria-hidden="true"></i>
						</span>
						<span class="flex flex-col items-start gap-3">
							<?php if ( $line_primary !== '' ) : ?>
								<span class="font-serif text-lg leading-snug text-[var(--deep-teal)] sm:text-xl"><?php echo esc_html( $line_primary ); ?></span>
							<?php else : ?>
								<span class="font-serif text-lg leading-snug text-[var(--deep-teal)] sm:text-xl"><?php echo esc_html( $trust_line_full ); ?></span>
							<?php endif; ?>
							<?php if ( $line_secondary !== '' ) : ?>
								<span class="inline-flex w-fit items-center rounded-full border border-[var(--deep-teal)]/12 bg-[color-mix(in_srgb,var(--sea-glass)_38%,white)] px-2.5 py-0.5 text-[0.625rem] font-semibold uppercase tracking-[0.12em] text-[var(--deep-teal)]"><?php echo esc_html( $line_secondary ); ?></span>
							<?php endif; ?>
						</span>
						<span class="sr-only"><?php esc_html_e( 'Opens the care provider website in a new tab', 'restwell-retreats' ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( $show_cqc && $cqc_url !== '' ) : ?>
					<a
						class="<?php echo esc_attr( $trust_cell_class ); ?>"
						href="<?php echo esc_url( $cqc_url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<span class="flex w-full min-h-5 items-center justify-between gap-3">
							<span class="text-[0.68rem] font-semibold uppercase tracking-[0.14em] text-[var(--warm-gold-text)] font-sans leading-none"><?php esc_html_e( 'CQC inspection', 'restwell-retreats' ); ?></span>
							<i class="ph-bold ph-arrow-square-out inline-flex shrink-0 text-base leading-none text-[var(--deep-teal)]/45 transition-colors duration-200 group-hover:text-[var(--deep-teal)] motion-reduce:transition-none" aria-hidden="true"></i>
						</span>
						<span class="flex flex-col items-start gap-3">
							<span class="font-serif text-lg leading-snug text-[var(--deep-teal)] sm:text-xl"><?php esc_html_e( 'Continuity on the official CQC register', 'restwell-retreats' ); ?></span>
							<span class="text-sm leading-relaxed text-[var(--muted-grey)]"><?php esc_html_e( 'Independent inspection reports and latest rating', 'restwell-retreats' ); ?></span>
						</span>
						<span class="sr-only"><?php esc_html_e( 'Opens the Care Quality Commission website in a new tab', 'restwell-retreats' ); ?></span>
					</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
</section>
