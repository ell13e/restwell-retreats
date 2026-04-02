<?php
/**
 * Blog archive / posts index template.
 * Used when WordPress is configured with a static front page and a separate
 * "page for posts". Falls back gracefully when no posts exist.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Pull the "page for posts" if set, to allow editors to set a title/excerpt
// in the WordPress admin for the archive hero.
$posts_page_id = (int) get_option( 'page_for_posts' );
$archive_title  = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Guides & articles', 'restwell-retreats' );
$archive_intro  = $posts_page_id ? get_the_excerpt( $posts_page_id ) : __( 'Practical guides to accessible travel on the Kent coast, local area information, and updates from Restwell.', 'restwell-retreats' );
$archive_label  = __( 'From the blog', 'restwell-retreats' );

// Separate the first post (featured) from the rest.
$first_post      = null;
$remaining_posts = array();

if ( have_posts() ) {
	$post_index = 0;
	while ( have_posts() ) {
		the_post();
		if ( $post_index === 0 ) {
			$first_post = array(
				'id'        => get_the_ID(),
				'title'     => get_the_title(),
				'permalink' => get_permalink(),
				'excerpt'   => get_the_excerpt(),
				'date'      => get_the_date(),
				'date_iso'  => get_the_date( 'c' ),
				'img_id'    => get_post_thumbnail_id(),
				'img_src'   => get_the_post_thumbnail_url( null, 'large' ),
				'category'  => restwell_get_primary_category(),
				'read_time' => restwell_estimate_read_time( (string) get_post_field( 'post_content', get_the_ID() ) ),
			);
		} else {
			$remaining_posts[] = array(
				'id'        => get_the_ID(),
				'title'     => get_the_title(),
				'permalink' => get_permalink(),
				'excerpt'   => get_the_excerpt(),
				'date'      => get_the_date(),
				'date_iso'  => get_the_date( 'c' ),
				'img_id'    => get_post_thumbnail_id(),
				'img_src'   => get_the_post_thumbnail_url( null, 'medium_large' ),
				'category'  => restwell_get_primary_category(),
				'read_time' => restwell_estimate_read_time( (string) get_post_field( 'post_content', get_the_ID() ) ),
			);
		}
		$post_index++;
	}
}
?>
<main class="flex-1" id="main-content">

	<!-- Hero -->
	<section class="bg-[var(--deep-teal)] py-16 md:py-24" aria-labelledby="archive-hero-heading">
		<div class="container max-w-3xl text-center">
			<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-4 font-sans"><?php echo esc_html( $archive_label ); ?></p>
			<h1 id="archive-hero-heading" class="text-white text-4xl md:text-5xl font-serif leading-tight mb-5"><?php echo esc_html( $archive_title ); ?></h1>
			<?php if ( $archive_intro !== '' ) : ?>
				<p class="text-white/85 text-lg leading-relaxed max-w-prose mx-auto"><?php echo esc_html( $archive_intro ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Articles -->
	<div class="bg-[var(--bg-subtle)] py-16 md:py-24">
		<div class="container max-w-5xl">

			<?php if ( $first_post ) : ?>

				<!-- Featured article -->
				<article class="group mb-14 md:mb-20" aria-label="<?php echo esc_attr( $first_post['title'] ); ?>">
					<a href="<?php echo esc_url( $first_post['permalink'] ); ?>"
					   class="grid md:grid-cols-2 gap-0 bg-white rounded-2xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.05)] border border-gray-100 no-underline hover:shadow-[0_12px_40px_rgb(0,0,0,0.09)] transition-shadow duration-300"
					   aria-label="<?php echo esc_attr( sprintf( /* translators: %s post title */ __( 'Continue reading: %s', 'restwell-retreats' ), $first_post['title'] ) ); ?>"
					   tabindex="0">
						<!-- Image -->
						<div class="relative overflow-hidden min-h-[16rem] md:min-h-[22rem] bg-[var(--deep-teal)]/10">
							<?php if ( $first_post['img_src'] ) : ?>
								<img src="<?php echo esc_url( $first_post['img_src'] ); ?>"
								     alt=""
								     class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
								     loading="eager" />
							<?php else : ?>
								<div class="absolute inset-0 flex items-center justify-center">
									<i class="fa-solid fa-newspaper text-[var(--deep-teal)]/20 text-6xl" aria-hidden="true"></i>
								</div>
							<?php endif; ?>
						</div>
						<!-- Content -->
						<div class="flex flex-col justify-between p-8 md:p-10">
							<div>
								<div class="flex flex-wrap items-center gap-3 mb-4">
									<?php if ( $first_post['category'] ) : ?>
										<span class="inline-block bg-[#A8D5D0]/30 text-[var(--deep-teal)] text-xs font-semibold uppercase tracking-wider px-3 py-1 rounded-full"><?php echo esc_html( $first_post['category'] ); ?></span>
									<?php endif; ?>
									<span class="text-[var(--muted-grey)] text-xs"><?php echo esc_html( $first_post['date'] ); ?></span>
									<span class="text-[var(--muted-grey)] text-xs" aria-hidden="true">&bull;</span>
									<span class="text-[var(--muted-grey)] text-xs"><?php echo esc_html( $first_post['read_time'] ); ?> min read</span>
								</div>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] leading-snug mb-4 group-hover:underline decoration-[var(--deep-teal)]/30 underline-offset-4"><?php echo esc_html( $first_post['title'] ); ?></h2>
								<p class="text-gray-600 leading-relaxed text-base line-clamp-4"><?php echo esc_html( $first_post['excerpt'] ); ?></p>
							</div>
							<div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-100">
								<span class="inline-flex items-center gap-1.5 text-[var(--deep-teal)] text-sm font-semibold">
									<?php esc_html_e( 'Continue reading', 'restwell-retreats' ); ?> <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
								</span>
							</div>
						</div>
					</a>
				</article>

				<!-- Remaining articles grid -->
				<?php if ( ! empty( $remaining_posts ) ) : ?>
					<div class="grid sm:grid-cols-2 gap-6 lg:gap-8">
						<?php foreach ( $remaining_posts as $post ) : ?>
							<article class="group" aria-label="<?php echo esc_attr( $post['title'] ); ?>">
								<a href="<?php echo esc_url( $post['permalink'] ); ?>"
								   class="flex flex-col bg-white rounded-2xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 no-underline hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 transition-all duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:translate-y-0 h-full"
								   aria-label="<?php echo esc_attr( sprintf( /* translators: %s post title */ __( 'Continue reading: %s', 'restwell-retreats' ), $post['title'] ) ); ?>">
									<!-- Image -->
									<div class="relative overflow-hidden aspect-[16/9] bg-[var(--deep-teal)]/10">
										<?php if ( $post['img_src'] ) : ?>
											<img src="<?php echo esc_url( $post['img_src'] ); ?>"
											     alt=""
											     class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
											     loading="lazy" />
										<?php else : ?>
											<div class="absolute inset-0 flex items-center justify-center">
												<i class="fa-solid fa-newspaper text-[var(--deep-teal)]/20 text-4xl" aria-hidden="true"></i>
											</div>
										<?php endif; ?>
									</div>
									<!-- Content -->
									<div class="flex flex-col flex-1 p-6">
										<div class="flex items-center gap-2 mb-3">
											<?php if ( $post['category'] ) : ?>
												<span class="inline-block bg-[#A8D5D0]/30 text-[var(--deep-teal)] text-xs font-semibold uppercase tracking-wider px-2.5 py-0.5 rounded-full"><?php echo esc_html( $post['category'] ); ?></span>
											<?php endif; ?>
											<span class="text-[var(--muted-grey)] text-xs"><?php echo esc_html( $post['read_time'] ); ?> min read</span>
										</div>
										<h2 class="text-lg font-serif text-[var(--deep-teal)] leading-snug mb-3 group-hover:underline decoration-[var(--deep-teal)]/30 underline-offset-4"><?php echo esc_html( $post['title'] ); ?></h2>
										<p class="text-gray-600 text-sm leading-relaxed flex-1 line-clamp-3"><?php echo esc_html( $post['excerpt'] ); ?></p>
										<div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
											<time class="text-xs text-[var(--muted-grey)]" datetime="<?php echo esc_attr( $post['date_iso'] ); ?>"><?php echo esc_html( $post['date'] ); ?></time>
											<span class="inline-flex items-center gap-1 text-[var(--deep-teal)] text-xs font-semibold">
												<?php esc_html_e( 'Continue', 'restwell-retreats' ); ?> <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
											</span>
										</div>
									</div>
								</a>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- Pagination -->
				<?php
				the_posts_pagination( array(
					'mid_size'           => 2,
					'prev_text'          => '<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> ' . __( 'Newer', 'restwell-retreats' ),
					'next_text'          => __( 'Older', 'restwell-retreats' ) . ' <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>',
					'screen_reader_text' => __( 'Articles navigation', 'restwell-retreats' ),
					'class'              => 'mt-14 md:mt-20',
				) );
				?>

			<?php else : ?>

				<!-- Empty state -->
				<div class="text-center py-16 max-w-md mx-auto">
					<div class="w-16 h-16 bg-[#A8D5D0]/30 rounded-full flex items-center justify-center mx-auto mb-6" aria-hidden="true">
						<i class="fa-solid fa-pen-nib text-[var(--deep-teal)] text-2xl"></i>
					</div>
					<h2 class="text-2xl font-serif text-[var(--deep-teal)] mb-3"><?php esc_html_e( 'Guides coming soon', 'restwell-retreats' ); ?></h2>
					<p class="text-gray-600 leading-relaxed"><?php esc_html_e( 'We are working on practical guides to accessible holidays, the Whitstable area, and funding your stay. Check back soon, or enquire now and we will send you updates.', 'restwell-retreats' ); ?></p>
				</div>

			<?php endif; ?>

		</div>
	</div>

	<!-- CTA strip -->
	<section class="py-16 md:py-20 bg-white" aria-labelledby="archive-cta-heading">
		<div class="container max-w-2xl text-center">
			<p class="section-label mb-3"><?php esc_html_e( 'Planning a stay?', 'restwell-retreats' ); ?></p>
			<h2 id="archive-cta-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php esc_html_e( 'Come and see Whitstable for yourself.', 'restwell-retreats' ); ?></h2>
			<p class="text-gray-600 leading-relaxed mb-8 max-w-prose mx-auto"><?php esc_html_e( 'Restwell is a fully adapted holiday home in Whitstable, Kent — designed for disabled guests, their families, and carers.', 'restwell-retreats' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>" class="btn btn-primary">
				<?php esc_html_e( 'Enquire about dates', 'restwell-retreats' ); ?>
				<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
	</section>

</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
