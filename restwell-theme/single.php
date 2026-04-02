<?php
/**
 * Single post template.
 * Used for all standard blog posts (articles, local guides, news).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

the_post();

$post_id      = get_the_ID();
$title        = get_the_title();
$content      = get_the_content();
$excerpt      = get_the_excerpt();
$date         = get_the_date();
$date_iso     = get_the_date( 'c' );
$modified_iso = get_the_modified_date( 'c' );
$category     = restwell_get_primary_category();
$read_time    = restwell_estimate_read_time( $content );

$img_id  = get_post_thumbnail_id();
$img_src = $img_id ? wp_get_attachment_image_url( $img_id, 'full' ) : '';
$img_alt = $img_id ? trim( wp_strip_all_tags( (string) get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ) ) : '';

// Blog archive URL — respects the "page for posts" setting.
$archive_url   = get_post_type_archive_link( 'post' ) ?: home_url( '/blog/' );
$posts_page_id = (int) get_option( 'page_for_posts' );
if ( $posts_page_id ) {
	$archive_url = get_permalink( $posts_page_id );
}
$archive_label = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'News & guides', 'restwell-retreats' );

// Related posts: same category, exclude current.
$related_posts = array();
if ( $category ) {
	$cats = get_the_category( $post_id );
	$cat_id = 0;
	if ( ! empty( $cats ) ) {
		foreach ( $cats as $cat_obj ) {
			if ( 'uncategorized' !== $cat_obj->slug ) {
				$cat_id = (int) $cat_obj->term_id;
				break;
			}
		}
		if ( ! $cat_id ) {
			$cat_id = (int) $cats[0]->term_id;
		}
	}
	if ( $cat_id ) {
		$related_query = new WP_Query( array(
			'category__in'   => array( $cat_id ),
			'post__not_in'   => array( $post_id ),
			'posts_per_page' => 2,
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );
		if ( $related_query->have_posts() ) {
			while ( $related_query->have_posts() ) {
				$related_query->the_post();
				$related_posts[] = array(
					'title'     => get_the_title(),
					'permalink' => get_permalink(),
					'date'      => get_the_date(),
					'img_src'   => get_the_post_thumbnail_url( null, 'medium_large' ),
					'read_time' => restwell_estimate_read_time( (string) get_post_field( 'post_content', get_the_ID() ) ),
				);
			}
			wp_reset_postdata();
		}
	}
}
?>
<main class="flex-1" id="main-content">

	<!-- Breadcrumb -->
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<!-- Article header -->
	<header class="bg-[var(--deep-teal)] <?php echo $img_src ? 'relative overflow-hidden' : ''; ?>" aria-labelledby="article-title">
		<?php if ( $img_src ) : ?>
			<img src="<?php echo esc_url( $img_src ); ?>"
			     alt="<?php echo esc_attr( $img_alt ); ?>"
			     class="absolute inset-0 w-full h-full object-cover opacity-30"
			     loading="eager" />
			<div class="absolute inset-0 bg-gradient-to-t from-[var(--deep-teal)] via-[var(--deep-teal)]/80 to-[var(--deep-teal)]/60" aria-hidden="true"></div>
		<?php endif; ?>
		<div class="relative z-10 container max-w-3xl py-16 md:py-24">
			<!-- Category + read time -->
			<div class="flex flex-wrap items-center gap-3 mb-5">
				<?php if ( $category ) : ?>
					<span class="inline-block bg-white/15 text-white text-xs font-semibold uppercase tracking-wider px-3 py-1 rounded-full"><?php echo esc_html( $category ); ?></span>
				<?php endif; ?>
				<span class="text-white/70 text-xs font-medium"><?php echo esc_html( $read_time ); ?> min read</span>
			</div>
			<!-- Title -->
			<h1 id="article-title" class="text-white text-3xl md:text-4xl lg:text-5xl font-serif leading-tight mb-6"><?php echo esc_html( $title ); ?></h1>
			<!-- Date -->
			<time class="text-white/70 text-sm" datetime="<?php echo esc_attr( $date_iso ); ?>"><?php echo esc_html( $date ); ?></time>
		</div>
	</header>

	<!-- Article body -->
	<div class="bg-white py-12 md:py-16">
		<div class="container max-w-3xl">


			<div class="prose prose-lg prose-headings:font-serif prose-headings:text-[var(--deep-teal)] prose-headings:font-normal prose-a:text-[var(--deep-teal)] prose-a:font-medium prose-a:no-underline hover:prose-a:underline prose-strong:text-[var(--deep-teal)] prose-p:text-gray-700 prose-p:leading-relaxed max-w-none">
				<?php echo wp_kses_post( apply_filters( 'the_content', $content ) ); ?>
			</div>

			<!-- Tags -->
			<?php
			$tags = get_the_tags();
			if ( $tags ) :
			?>
				<div class="flex flex-wrap gap-2 mt-10 pt-8 border-t border-gray-100">
					<span class="text-xs text-[var(--muted-grey)] font-medium self-center mr-1"><?php esc_html_e( 'Tagged:', 'restwell-retreats' ); ?></span>
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
						   class="inline-block bg-[var(--bg-subtle)] text-[var(--deep-teal)] text-xs font-medium px-3 py-1 rounded-full hover:bg-[#A8D5D0]/30 transition-colors duration-200 no-underline">
							<?php echo esc_html( $tag->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!-- Back to articles -->
			<div class="mt-10">
				<a href="<?php echo esc_url( $archive_url ); ?>" class="inline-flex items-center gap-2 text-[var(--deep-teal)] text-sm font-semibold hover:underline no-underline">
					<i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
					<?php echo esc_html( sprintf( __( 'Back to %s', 'restwell-retreats' ), $archive_label ) ); ?>
				</a>
			</div>

		</div>
	</div>

	<!-- Related articles -->
	<?php if ( ! empty( $related_posts ) ) : ?>
		<section class="py-16 md:py-20 bg-[var(--bg-subtle)]" aria-labelledby="related-heading">
			<div class="container max-w-5xl">
				<p class="section-label mb-3"><?php esc_html_e( 'More to read', 'restwell-retreats' ); ?></p>
				<h2 id="related-heading" class="text-2xl font-serif text-[var(--deep-teal)] mb-8"><?php esc_html_e( 'You might also like', 'restwell-retreats' ); ?></h2>
				<div class="grid sm:grid-cols-2 gap-6">
					<?php foreach ( $related_posts as $rp ) : ?>
						<article class="group">
							<a href="<?php echo esc_url( $rp['permalink'] ); ?>"
							   class="flex flex-col bg-white rounded-2xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 no-underline hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 transition-all duration-300 motion-reduce:transition-none motion-reduce:hover:translate-y-0 h-full">
								<?php if ( $rp['img_src'] ) : ?>
									<div class="relative overflow-hidden aspect-[16/9] bg-[var(--deep-teal)]/10">
										<img src="<?php echo esc_url( $rp['img_src'] ); ?>"
										     alt=""
										     class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
										     loading="lazy" />
									</div>
								<?php endif; ?>
								<div class="flex flex-col flex-1 p-6">
									<h3 class="text-lg font-serif text-[var(--deep-teal)] leading-snug mb-2 group-hover:underline decoration-[var(--deep-teal)]/30 underline-offset-4"><?php echo esc_html( $rp['title'] ); ?></h3>
									<div class="mt-auto pt-4 flex items-center justify-between">
										<time class="text-xs text-[var(--muted-grey)]"><?php echo esc_html( $rp['date'] ); ?></time>
										<span class="text-[var(--deep-teal)] text-xs font-semibold inline-flex items-center gap-1">
											Read <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
										</span>
									</div>
								</div>
							</a>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- CTA -->
	<section class="py-16 md:py-20 <?php echo empty( $related_posts ) ? 'bg-[var(--bg-subtle)]' : 'bg-white'; ?>" aria-labelledby="article-cta-heading">
		<div class="container max-w-2xl text-center">
			<p class="section-label mb-3"><?php esc_html_e( 'Planning a stay?', 'restwell-retreats' ); ?></p>
			<h2 id="article-cta-heading" class="text-3xl font-serif text-[var(--deep-teal)] mb-4"><?php esc_html_e( 'Come and see Whitstable for yourself.', 'restwell-retreats' ); ?></h2>
			<p class="text-gray-600 leading-relaxed mb-8 max-w-prose mx-auto"><?php esc_html_e( 'Restwell is a fully adapted holiday home in Whitstable, Kent — designed for disabled guests, their families, and carers. Enquire to check dates and suitability.', 'restwell-retreats' ); ?></p>
			<div class="flex flex-wrap gap-4 justify-center">
				<a href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>" class="btn btn-primary">
					<?php esc_html_e( 'Enquire about dates', 'restwell-retreats' ); ?>
					<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
				<a href="<?php echo esc_url( home_url( '/the-property/' ) ); ?>" class="btn btn-outline">
					<?php esc_html_e( 'See the property', 'restwell-retreats' ); ?>
				</a>
			</div>
		</div>
	</section>

</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
