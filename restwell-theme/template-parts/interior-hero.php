<?php
/**
 * Interior page hero — matches front-page photo treatment (gold label, white title, cream intro).
 * Optional background image or video (attachment ID). Does not use class `hero` so legacy `.hero`
 * min-height / mobile rules do not apply.
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type string $heading_id     Required. id attribute for h1 (aria-labelledby target).
 *     @type string $heading        Required. Main heading text.
 *     @type string $label          Optional eyebrow / section label.
 *     @type string $intro          Optional intro paragraph.
 *     @type int    $media_id       Optional attachment ID (image or video).
 *     @type string $image_alt      Optional alt text for background image (defaults to heading).
 *     @type string $content_max    Inner column width class. Default `max-w-3xl`.
 *     @type string $min_height_class Optional min-height Tailwind classes.
 *     @type array  $cta_primary    Optional `array( 'label' => '', 'url' => '' )`.
 *     @type array  $cta_secondary  Optional `array( 'label' => '', 'url' => '' )`.
 *     @type string $cta_promise    Optional small line below CTAs.
 *     @type string $prepend_inner_html Optional HTML inside the content column before the eyebrow (e.g. article meta row). KSES-sanitized in the partial.
 *     @type string $append_after_h1_html Optional HTML after the h1, before intro (e.g. date). KSES-sanitized.
 *     @type string $section_decor_html Optional HTML after opening &lt;section&gt; (e.g. faint “404” numeral). KSES-sanitized.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = (array) get_query_var( 'args', array() );

$defaults = array(
	'heading_id'        => 'page-hero-heading',
	'heading'           => '',
	'label'             => '',
	'intro'             => '',
	'media_id'          => 0,
	'image_alt'         => '',
	'content_max'       => 'max-w-3xl',
	'container_class'   => 'container w-full',
	'min_height_class'  => 'min-h-[32rem] md:min-h-[42rem]',
	'cta_primary'           => array(),
	'cta_secondary'         => array(),
	'cta_promise'           => '',
	'prepend_inner_html'    => '',
	'append_after_h1_html'  => '',
	'section_decor_html'    => '',
);

$args = wp_parse_args( $args, $defaults );

$heading = isset( $args['heading'] ) ? (string) $args['heading'] : '';
$heading_id = isset( $args['heading_id'] ) ? (string) $args['heading_id'] : 'page-hero-heading';
$heading_id = preg_replace( '/[^a-zA-Z0-9_-]/', '-', $heading_id );
$heading_id = trim( $heading_id, '-' );
if ( $heading_id === '' ) {
	$heading_id = 'page-hero-heading';
}

if ( $heading === '' ) {
	return;
}

$label         = isset( $args['label'] ) ? (string) $args['label'] : '';
$intro         = isset( $args['intro'] ) ? (string) $args['intro'] : '';
$media_id      = isset( $args['media_id'] ) ? absint( $args['media_id'] ) : 0;
$image_alt     = isset( $args['image_alt'] ) ? (string) $args['image_alt'] : '';
$content_max       = isset( $args['content_max'] ) ? trim( (string) $args['content_max'] ) : 'max-w-3xl';
$container_class   = isset( $args['container_class'] ) ? trim( (string) $args['container_class'] ) : 'container w-full';
$min_h             = isset( $args['min_height_class'] ) ? (string) $args['min_height_class'] : 'min-h-[32rem] md:min-h-[42rem]';
$cta_primary   = isset( $args['cta_primary'] ) && is_array( $args['cta_primary'] ) ? $args['cta_primary'] : array();
$cta_secondary = isset( $args['cta_secondary'] ) && is_array( $args['cta_secondary'] ) ? $args['cta_secondary'] : array();
$cta_promise   = isset( $args['cta_promise'] ) ? (string) $args['cta_promise'] : '';
$prepend_inner = isset( $args['prepend_inner_html'] ) ? (string) $args['prepend_inner_html'] : '';
$append_h1     = isset( $args['append_after_h1_html'] ) ? (string) $args['append_after_h1_html'] : '';
$section_decor = isset( $args['section_decor_html'] ) ? (string) $args['section_decor_html'] : '';

// Safe class tokens for inner column (single or multiple utilities).
if ( ! preg_match( '/^[\w\[\]:.\/\s-]+$/u', $content_max ) || strlen( $content_max ) > 220 ) {
	$content_max = 'max-w-3xl';
}
if ( ! preg_match( '/^[\w\[\]:.\/\s-]+$/u', $container_class ) || strlen( $container_class ) > 220 ) {
	$container_class = 'container w-full';
}
if ( ! preg_match( '/^[\w\[\]:\s.-]+$/', $min_h ) ) {
	$min_h = 'min-h-[32rem] md:min-h-[42rem]';
}

$mime         = $media_id ? get_post_mime_type( $media_id ) : '';
$is_video     = $mime && strpos( $mime, 'video/' ) === 0;
$media_url    = '';
if ( $media_id ) {
	$media_url = $is_video ? wp_get_attachment_url( $media_id ) : wp_get_attachment_image_url( $media_id, 'full' );
}
$has_media = $media_id && $media_url;

$img_alt = $image_alt !== '' ? $image_alt : $heading;

$has_cta_primary   = ! empty( $cta_primary['label'] ) && ! empty( $cta_primary['url'] );
$has_cta_secondary = ! empty( $cta_secondary['label'] ) && ! empty( $cta_secondary['url'] );
$has_cta_row       = $has_cta_primary || $has_cta_secondary;

$intro_class = 'text-[#F5EDE0] text-lg md:text-xl leading-relaxed max-w-prose';
if ( $has_cta_row && $intro !== '' ) {
	$intro_class .= ' mb-8';
}
if ( $append_h1 !== '' && $intro !== '' ) {
	$intro_class .= ' mt-4';
}
?>
<section class="restwell-interior-hero relative flex items-end overflow-hidden <?php echo esc_attr( $min_h ); ?> <?php echo $has_media ? 'restwell-interior-hero--has-media' : ''; ?> <?php echo $has_media ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<?php if ( $section_decor !== '' ) : ?>
		<?php echo wp_kses_post( $section_decor ); ?>
	<?php endif; ?>
	<?php if ( $has_media && $is_video ) : ?>
		<video
			class="absolute inset-0 h-full w-full object-cover -z-10"
			autoplay
			muted
			loop
			playsinline
			preload="metadata"
			aria-hidden="true"
		>
			<source src="<?php echo esc_url( $media_url ); ?>" type="<?php echo esc_attr( $mime ); ?>">
		</video>
	<?php elseif ( $has_media ) : ?>
		<?php
		echo wp_get_attachment_image(
			$media_id,
			'full',
			false,
			array(
				'class'         => 'absolute inset-0 h-full w-full object-cover -z-10',
				'alt'           => $img_alt,
				'loading'       => 'eager',
				'fetchpriority' => 'high',
				'decoding'      => 'async',
			)
		);
		?>
	<?php endif; ?>
	<div class="<?php echo esc_attr( $container_class ); ?> relative z-10 pb-14 md:pb-20">
		<div class="<?php echo esc_attr( $content_max ); ?>">
			<?php if ( $prepend_inner !== '' ) : ?>
				<?php echo wp_kses_post( $prepend_inner ); ?>
			<?php endif; ?>
			<?php if ( $label !== '' ) : ?>
				<p class="mb-4 font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[var(--warm-gold-hero)]"><?php echo esc_html( $label ); ?></p>
			<?php endif; ?>
			<h1 id="<?php echo esc_attr( $heading_id ); ?>" class="mb-5 font-serif text-4xl leading-tight text-white md:text-5xl"><?php echo esc_html( $heading ); ?></h1>
			<?php if ( $append_h1 !== '' ) : ?>
				<?php echo wp_kses_post( $append_h1 ); ?>
			<?php endif; ?>
			<?php if ( $intro !== '' ) : ?>
				<p class="<?php echo esc_attr( $intro_class ); ?>"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
			<?php if ( $has_cta_row ) : ?>
				<div class="flex flex-wrap gap-4<?php echo $intro === '' ? ' mt-4' : ''; ?>">
					<?php if ( $has_cta_primary ) : ?>
						<a href="<?php echo esc_url( $cta_primary['url'] ); ?>" class="btn btn-gold">
							<?php echo esc_html( $cta_primary['label'] ); ?>
							<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
						</a>
					<?php endif; ?>
					<?php if ( $has_cta_secondary ) : ?>
						<a href="<?php echo esc_url( $cta_secondary['url'] ); ?>" class="btn btn-ghost-light">
							<?php echo esc_html( $cta_secondary['label'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if ( $cta_promise !== '' ) : ?>
				<p class="mt-4 text-sm text-white/90"><?php echo esc_html( $cta_promise ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
