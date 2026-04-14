<?php
/**
 * Interior page hero — same markup, classes, and responsive behaviour as the front-page hero
 * (see front-page.php). Copy, CTAs, and media are passed via args.
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type string $heading_id     Required. id attribute for h1 (aria-labelledby target).
 *     @type string $heading        Required. Main heading; use line breaks for a multi-line display title.
 *     @type string $label          Optional eyebrow / section label.
 *     @type string $intro          Optional intro paragraph (hero lede).
 *     @type int    $media_id       Optional attachment ID (image or video).
 *     @type string $image_alt      Optional alt text for background image.
 *     @type array  $cta_primary    Optional `array( 'label' => '', 'url' => '' )`.
 *     @type array  $cta_secondary  Optional `array( 'label' => '', 'url' => '' )`.
 *     @type string $cta_promise    Optional reassurance line under CTAs.
 *     @type bool   $show_scroll_hint Optional. Default true. Scroll link to main content below hero.
 *     @type string $prepend_inner_html Optional HTML inside the text stack before the eyebrow (e.g. blog meta row). KSES-sanitized.
 *     @type string $append_after_h1_html Optional HTML after h1, before lede. KSES-sanitized.
 *     @type string $section_decor_html Optional HTML after opening section (e.g. faint “404”). KSES-sanitized.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = (array) get_query_var( 'args', array() );

$defaults = array(
	'heading_id'           => 'page-hero-heading',
	'heading'              => '',
	'label'                => '',
	'intro'                => '',
	'media_id'             => 0,
	'image_alt'            => '',
	'cta_primary'          => array(),
	'cta_secondary'        => array(),
	'cta_promise'          => '',
	'show_scroll_hint'     => true,
	'prepend_inner_html'     => '',
	'append_after_h1_html'   => '',
	'section_decor_html'     => '',
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
$cta_primary   = isset( $args['cta_primary'] ) && is_array( $args['cta_primary'] ) ? $args['cta_primary'] : array();
$cta_secondary = isset( $args['cta_secondary'] ) && is_array( $args['cta_secondary'] ) ? $args['cta_secondary'] : array();
$cta_promise   = isset( $args['cta_promise'] ) ? trim( (string) $args['cta_promise'] ) : '';
$show_scroll   = isset( $args['show_scroll_hint'] ) ? (bool) $args['show_scroll_hint'] : true;
$prepend_inner = isset( $args['prepend_inner_html'] ) ? (string) $args['prepend_inner_html'] : '';
$append_h1     = isset( $args['append_after_h1_html'] ) ? (string) $args['append_after_h1_html'] : '';
$section_decor = isset( $args['section_decor_html'] ) ? (string) $args['section_decor_html'] : '';

$heading_lines = preg_split( '/\r\n|\r|\n/', $heading );
$heading_lines = array_values( array_filter( array_map( 'trim', $heading_lines ), 'strlen' ) );
if ( empty( $heading_lines ) ) {
	$heading_lines = array( $heading );
}

$heading_flat = trim( preg_replace( '/\s+/', ' ', str_replace( array( "\r\n", "\r", "\n" ), ' ', $heading ) ) );
$hero_media_alt = $image_alt !== '' ? $image_alt : $heading_flat;
if ( trim( (string) $intro ) !== '' ) {
	$combined_alt = $heading_flat . ': ' . $intro;
	if ( strlen( $combined_alt ) <= 200 ) {
		$hero_media_alt = $combined_alt;
	}
}

$mime     = $media_id ? get_post_mime_type( $media_id ) : '';
$is_video = $mime && strpos( $mime, 'video/' ) === 0;
$img_size = $media_id && function_exists( 'restwell_pick_attachment_size' )
	? restwell_pick_attachment_size( $media_id, 'restwell-hero' )
	: 'full';
$media_url = '';
if ( $media_id ) {
	$media_url = $is_video ? wp_get_attachment_url( $media_id ) : wp_get_attachment_image_url( $media_id, $img_size );
}
$has_media = $media_id && $media_url;

$has_cta_primary   = ! empty( $cta_primary['label'] ) && ! empty( $cta_primary['url'] );
$has_cta_secondary = ! empty( $cta_secondary['label'] ) && ! empty( $cta_secondary['url'] );
$has_cta_row       = $has_cta_primary || $has_cta_secondary;

$lede_id = $heading_id . '-lede';
$hero_describedby = array();
if ( trim( (string) $intro ) !== '' ) {
	$hero_describedby[] = $lede_id;
}

$section_class = 'hero home-hero relative flex overflow-hidden';
$section_class .= ( $has_media && $media_url ) ? ' hero--has-media' : '';
$section_class .= $has_media ? '' : ' bg-[var(--deep-teal)]';
?>
<section
	class="<?php echo esc_attr( trim( $section_class ) ); ?>"
	aria-labelledby="<?php echo esc_attr( $heading_id ); ?>"
	<?php echo ! empty( $hero_describedby ) ? ' aria-describedby="' . esc_attr( implode( ' ', $hero_describedby ) ) . '"' : ''; ?>
>
	<?php if ( $section_decor !== '' ) : ?>
		<?php echo wp_kses_post( $section_decor ); ?>
	<?php endif; ?>
	<?php if ( $has_media && $is_video ) : ?>
		<video
			class="absolute inset-0 w-full h-full object-cover -z-10"
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
			$img_size,
			false,
			array(
				'class'         => 'absolute inset-0 w-full h-full object-cover -z-10',
				'alt'           => $hero_media_alt,
				'loading'       => 'eager',
				'fetchpriority' => 'high',
				'decoding'      => 'async',
				'sizes'         => '100vw',
			)
		);
		?>
	<?php endif; ?>
	<div class="relative z-10 container w-full">
		<div class="home-hero__copy w-full">
			<div class="home-hero__main-cluster">
				<div class="home-hero__text-stack">
					<?php if ( $prepend_inner !== '' ) : ?>
						<?php echo wp_kses_post( $prepend_inner ); ?>
					<?php endif; ?>
					<?php if ( $label !== '' ) : ?>
						<span class="home-hero__eyebrow block text-xs uppercase tracking-[0.2em] font-sans">
							<?php echo esc_html( $label ); ?>
						</span>
					<?php endif; ?>
					<h1 id="<?php echo esc_attr( $heading_id ); ?>" class="home-hero__heading m-0 text-white">
						<span class="home-hero__title-lines block space-y-2 font-serif">
							<?php foreach ( $heading_lines as $line ) : ?>
								<span class="block"><?php echo esc_html( $line ); ?></span>
							<?php endforeach; ?>
						</span>
					</h1>
					<?php if ( $append_h1 !== '' ) : ?>
						<?php echo wp_kses_post( $append_h1 ); ?>
					<?php endif; ?>
					<?php if ( trim( (string) $intro ) !== '' ) : ?>
						<p
							id="<?php echo esc_attr( $lede_id ); ?>"
							class="home-hero__lede text-white [text-shadow:0_2px_4px_rgba(0,0,0,0.3)] font-sans text-base sm:text-lg md:text-xl font-normal leading-relaxed tracking-normal sm:tracking-tight text-balance m-0"
						>
							<?php echo esc_html( $intro ); ?>
						</p>
					<?php endif; ?>
				</div>
				<?php if ( $has_cta_row ) : ?>
					<div class="home-hero__cta-stack">
						<?php if ( $has_cta_primary ) : ?>
							<a
								id="hero-cta-primary"
								href="<?php echo esc_url( $cta_primary['url'] ); ?>"
								class="btn btn-gold cursor-pointer"
								data-cta="hero-primary"
							>
								<?php echo esc_html( $cta_primary['label'] ); ?>
								<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
							</a>
						<?php endif; ?>
						<?php if ( $has_cta_secondary ) : ?>
							<a
								id="hero-cta-secondary"
								href="<?php echo esc_url( $cta_secondary['url'] ); ?>"
								class="home-hero__cta-secondary btn cursor-pointer"
								data-cta="hero-secondary"
							>
								<?php echo esc_html( $cta_secondary['label'] ); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( $cta_promise !== '' ) : ?>
					<p id="<?php echo esc_attr( $heading_id ); ?>-reassurance" class="home-hero__reassurance m-0 mt-3 text-center text-white/90 text-sm font-sans max-w-md mx-auto leading-snug [text-shadow:0_1px_2px_rgba(0,0,0,0.35)]">
						<?php echo esc_html( $cta_promise ); ?>
					</p>
				<?php endif; ?>
				<?php if ( $show_scroll ) : ?>
					<p class="home-hero__scroll-hint m-0 text-center">
						<a href="#restwell-main-after-hero" class="home-hero__scroll-link">
							<span class="home-hero__scroll-link-text"><?php esc_html_e( 'Scroll to explore', 'restwell-retreats' ); ?></span>
							<i class="fa-solid fa-chevron-down home-hero__scroll-icon" aria-hidden="true"></i>
						</a>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<div id="restwell-main-after-hero" class="home-hero__scroll-anchor" tabindex="-1"></div>
