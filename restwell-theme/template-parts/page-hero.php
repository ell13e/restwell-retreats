<?php
/**
 * Template part: page hero (compact variant of the homepage hero).
 * Same visual language as the front-page hero but less impactful: smaller type,
 * less padding, no full-bleed video. Optional background image for key pages (e.g. Property).
 *
 * @package Restwell_Retreats
 * @param array $args [
 *   'label'         => string (eyebrow, optional),
 *   'heading'       => string (h1, required),
 *   'subheading'    => string (optional),
 *   'cta_primary'   => array( 'label' => '', 'url' => '' ) (optional),
 *   'cta_secondary' => array( 'label' => '', 'url' => '' ) (optional),
 *   'variant'       => 'compact' | 'with-image' (default compact),
 *   'image_id'     => int (attachment ID for with-image variant),
 *   'background'   => 'teal' | 'sand' (compact only, default teal),
 * ]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = (array) get_query_var( 'args', array() );
$label        = isset( $args['label'] ) ? $args['label'] : '';
$heading      = isset( $args['heading'] ) ? $args['heading'] : '';
$subheading   = isset( $args['subheading'] ) ? $args['subheading'] : '';
$cta_primary  = isset( $args['cta_primary'] ) && is_array( $args['cta_primary'] ) ? $args['cta_primary'] : array();
$cta_secondary = isset( $args['cta_secondary'] ) && is_array( $args['cta_secondary'] ) ? $args['cta_secondary'] : array();
$variant      = isset( $args['variant'] ) && $args['variant'] === 'with-image' ? 'with-image' : 'compact';
$image_id     = isset( $args['image_id'] ) ? absint( $args['image_id'] ) : 0;
$background   = isset( $args['background'] ) && $args['background'] === 'sand' ? 'sand' : 'teal';

if ( $heading === '' ) {
	return;
}

$has_cta_primary   = ! empty( $cta_primary['label'] ) && ! empty( $cta_primary['url'] );
$has_cta_secondary = ! empty( $cta_secondary['label'] ) && ! empty( $cta_secondary['url'] );
$image_src         = ( $variant === 'with-image' && $image_id ) ? wp_get_attachment_image_url( $image_id, 'large' ) : '';

$section_class = 'page-hero relative overflow-hidden';
if ( $variant === 'compact' ) {
	$section_class .= ' py-12 md:py-16';
	$section_class .= $background === 'sand' ? ' bg-[var(--soft-sand)]' : ' bg-[var(--deep-teal)]';
} else {
	$section_class .= ' min-h-[20rem] md:min-h-[24rem] flex flex-col justify-end';
	$section_class .= $image_src ? '' : ' bg-[var(--deep-teal)]';
}
?>
<section class="<?php echo esc_attr( $section_class ); ?>" aria-labelledby="page-hero-heading">
	<?php if ( $variant === 'with-image' && $image_src ) : ?>
		<img src="<?php echo esc_url( $image_src ); ?>" alt="" class="absolute inset-0 w-full h-full object-cover -z-10" />
		<div class="absolute inset-0 bg-gradient-to-t from-[var(--deep-teal)]/80 via-[var(--deep-teal)]/40 to-transparent -z-[5]" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="relative z-10 container <?php echo $variant === 'with-image' ? 'pb-10 pt-8' : ''; ?>">
<?php
$is_light_text = ( $variant === 'compact' && $background === 'teal' ) || $variant === 'with-image';
$is_centered  = ( $variant === 'compact' && $background === 'teal' );
?>
		<div class="max-w-3xl <?php echo $is_centered ? 'text-center' : ''; ?>">
			<?php if ( $label !== '' ) : ?>
				<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.15em] mb-3 font-sans">
					<?php echo esc_html( $label ); ?>
				</p>
			<?php endif; ?>
			<h1 id="page-hero-heading" class="text-3xl md:text-4xl font-serif leading-tight mb-3 <?php echo $is_light_text ? 'text-white' : 'text-[var(--deep-teal)]'; ?>">
				<?php echo esc_html( $heading ); ?>
			</h1>
			<?php if ( $subheading !== '' ) : ?>
				<p class="text-lg leading-relaxed max-w-prose <?php echo $is_light_text ? 'text-white/90' : 'text-[var(--body-secondary)]'; ?> <?php echo $is_centered ? 'mx-auto' : ''; ?>">
					<?php echo esc_html( $subheading ); ?>
				</p>
			<?php endif; ?>
			<?php if ( $has_cta_primary || $has_cta_secondary ) : ?>
				<div class="flex flex-wrap gap-3 mt-6 <?php echo $is_centered ? 'justify-center' : ''; ?>">
					<?php if ( $has_cta_primary ) : ?>
						<a href="<?php echo esc_url( $cta_primary['url'] ); ?>" class="btn btn-gold btn-sm">
							<?php echo esc_html( $cta_primary['label'] ); ?>
							<i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
						</a>
					<?php endif; ?>
					<?php if ( $has_cta_secondary ) : ?>
						<a href="<?php echo esc_url( $cta_secondary['url'] ); ?>" class="btn btn-sm <?php echo $is_light_text ? 'btn-ghost-light' : 'btn-outline'; ?>">
							<?php echo esc_html( $cta_secondary['label'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
