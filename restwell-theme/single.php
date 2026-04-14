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
$read_time    = restwell_estimate_read_time( $content );

$primary_cat_term = null;
$cats_all       = get_the_category( $post_id );
if ( ! empty( $cats_all ) ) {
	foreach ( $cats_all as $cat_obj ) {
		if ( 'uncategorized' !== $cat_obj->slug ) {
			$primary_cat_term = $cat_obj;
			break;
		}
	}
}
$cat_id = $primary_cat_term ? (int) $primary_cat_term->term_id : 0;

$img_id  = get_post_thumbnail_id();
$img_alt = $img_id ? trim( wp_strip_all_tags( (string) get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ) ) : '';

// Blog archive URL - respects the "page for posts" setting.
$archive_url   = get_post_type_archive_link( 'post' ) ?: home_url( '/blog/' );
$posts_page_id = (int) get_option( 'page_for_posts' );
if ( $posts_page_id ) {
	$archive_url = get_permalink( $posts_page_id );
}
$archive_label = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'News & guides', 'restwell-retreats' );

// Related posts: same category, exclude current.
$related_posts = array();
if ( $cat_id ) {
	$related_query = new WP_Query( array(
		'category__in'             => array( $cat_id ),
		'post__not_in'             => array( $post_id ),
		'posts_per_page'           => 2,
		'orderby'                  => 'date',
		'order'                    => 'DESC',
		'no_found_rows'            => true,
		'update_post_meta_cache'   => true,
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

$published_ts = (int) get_post_time( 'U', true, $post_id );
$modified_ts  = (int) get_post_modified_time( 'U', true, $post_id );
$show_updated = $modified_ts > $published_ts + DAY_IN_SECONDS;
?>
<main class="flex-1" id="main-content">

	<!-- Breadcrumb -->
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<?php
	// Hero meta row: section index link, optional category, read time (same hero shell as pages; blog-specific rhythm).
	$prepend_inner_html  = '<div class="home-hero__article-meta flex flex-wrap items-center gap-x-3 gap-y-2 justify-center sm:justify-start" role="group" aria-label="' . esc_attr__( 'Article context', 'restwell-retreats' ) . '">';
	$prepend_inner_html .= '<a href="' . esc_url( $archive_url ) . '" class="home-hero__article-back text-white/85 text-xs font-semibold uppercase tracking-[0.12em] no-underline hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70 rounded">' . esc_html( $archive_label ) . '</a>';
	if ( $primary_cat_term ) {
		$prepend_inner_html .= '<span class="text-white/35 select-none" aria-hidden="true">·</span>';
		$prepend_inner_html .= '<a href="' . esc_url( get_category_link( $primary_cat_term ) ) . '" class="home-hero__article-category inline-block bg-white/15 text-white text-xs font-semibold uppercase tracking-wider px-3 py-1 rounded-full no-underline hover:bg-white/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60">' . esc_html( $primary_cat_term->name ) . '</a>';
	}
	if ( $read_time ) {
		$prepend_inner_html .= '<span class="text-white/35 select-none" aria-hidden="true">·</span>';
		$prepend_inner_html .= '<span class="text-white/70 text-xs font-medium"><span class="sr-only">' . esc_html__( 'Reading time', 'restwell-retreats' ) . ' </span>' . esc_html( sprintf( __( '%d min read', 'restwell-retreats' ), $read_time ) ) . '</span>';
	}
	$prepend_inner_html .= '</div>';

	$append_after_h1_html  = '<p class="home-hero__byline m-0 font-sans text-sm sm:text-[0.9375rem] leading-snug text-white/80 [text-shadow:0_1px_3px_rgba(0,0,0,0.35)]">';
	if ( $show_updated ) {
		$append_after_h1_html .= '<span class="text-white/65">' . esc_html__( 'Published', 'restwell-retreats' ) . ' </span>';
	}
	$append_after_h1_html .= '<time datetime="' . esc_attr( $date_iso ) . '">' . esc_html( $date ) . '</time>';
	if ( $show_updated ) {
		$append_after_h1_html .= ' <span class="text-white/40" aria-hidden="true">·</span> ';
		$append_after_h1_html .= '<span class="text-white/75">' . esc_html__( 'Updated', 'restwell-retreats' ) . ' <time datetime="' . esc_attr( $modified_iso ) . '">' . esc_html( get_the_modified_date() ) . '</time></span>';
	}
	$append_after_h1_html .= '</p>';
	set_query_var(
		'args',
		array(
			'heading_id'           => 'article-title',
			'label'                => '',
			'heading'              => $title,
			'intro'                => $excerpt,
			'media_id'             => $img_id,
			'image_alt'            => $img_alt !== '' ? $img_alt : $title,
			'prepend_inner_html'   => $prepend_inner_html,
			'append_after_h1_html' => $append_after_h1_html,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

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
			<p class="text-gray-600 leading-relaxed mb-8 max-w-prose mx-auto"><?php esc_html_e( 'Restwell is an adapted holiday home in Whitstable, Kent, designed for guests with disabilities, their families, and carers. Enquire to check dates and suitability.', 'restwell-retreats' ); ?></p>
			<div class="flex flex-wrap gap-4 justify-center">
				<a href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>" class="btn btn-primary">
					<?php esc_html_e( 'Check your dates', 'restwell-retreats' ); ?>
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
