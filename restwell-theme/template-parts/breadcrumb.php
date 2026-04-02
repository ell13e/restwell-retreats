<?php
/**
 * Breadcrumb navigation.
 *
 * - Interior pages: Home > Page title
 * - Single posts:   Home > Articles > Post title
 *
 * Included at the top of each interior template (below <main>, above the hero).
 * Not shown on the front page.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_front_page() ) {
	return;
}

// Build crumb list.
$crumbs = array();

// Home is always first.
$crumbs[] = array(
	'label' => __( 'Home', 'restwell-retreats' ),
	'url'   => home_url( '/' ),
);

// For single posts, add the archive as an intermediate crumb.
if ( is_singular( 'post' ) ) {
	$posts_page_id = (int) get_option( 'page_for_posts' );
	if ( $posts_page_id ) {
		$crumbs[] = array(
			'label' => get_the_title( $posts_page_id ),
			'url'   => get_permalink( $posts_page_id ),
		);
	} else {
		$crumbs[] = array(
			'label' => __( 'Blog', 'restwell-retreats' ),
			'url'   => home_url( '/blog/' ),
		);
	}
}

// Current page / post (no URL — it is the current page).
$crumbs[] = array(
	'label' => get_the_title(),
	'url'   => '',
);
?>
<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'restwell-retreats' ); ?>">
	<div class="container">
		<ol class="breadcrumb__list">
			<?php foreach ( $crumbs as $i => $crumb ) : ?>
				<?php $is_last = ( $i === count( $crumbs ) - 1 ); ?>
				<li class="breadcrumb__item <?php echo $is_last ? 'breadcrumb__item--current' : ''; ?>"
				    <?php if ( $is_last ) : ?> aria-current="page" <?php endif; ?>>
					<?php if ( ! $is_last && $crumb['url'] ) : ?>
						<a href="<?php echo esc_url( $crumb['url'] ); ?>" class="breadcrumb__link">
							<?php echo esc_html( $crumb['label'] ); ?>
						</a>
					<?php else : ?>
						<span class="breadcrumb__current-label" title="<?php echo esc_attr( $crumb['label'] ); ?>">
							<?php echo esc_html( $crumb['label'] ); ?>
						</span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</nav>
