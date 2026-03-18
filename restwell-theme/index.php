<?php
/**
 * Main template file. Fallback for blog and when no other template matches.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$index_heading = is_home() && get_option( 'page_for_posts' ) ? get_the_title( (int) get_option( 'page_for_posts' ) ) : __( 'Latest updates', 'restwell-retreats' );
$index_subheading = is_home() && get_option( 'page_for_posts' ) ? get_the_excerpt( (int) get_option( 'page_for_posts' ) ) : '';
?>
<main class="flex-1" id="main-content">
	<section class="page-hero relative overflow-hidden py-12 md:py-16 bg-[var(--deep-teal)]" aria-labelledby="page-hero-heading">
		<div class="relative z-10 container">
			<div class="max-w-3xl text-center">
				<h1 id="page-hero-heading" class="text-3xl md:text-4xl font-serif leading-tight mb-3 text-white"><?php echo esc_html( $index_heading ); ?></h1>
				<?php if ( $index_subheading !== '' ) : ?>
					<p class="text-lg leading-relaxed max-w-prose mx-auto text-white/90"><?php echo esc_html( $index_subheading ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<div class="container py-16 md:py-24">
		<?php if ( have_posts() ) : ?>
			<div class="max-w-3xl space-y-12">
				<?php
				while ( have_posts() ) {
					the_post();
					?>
					<article>
						<h2 class="text-2xl font-serif text-[#1B4D5C] mb-2"><a href="<?php the_permalink(); ?>" class="no-underline hover:underline"><?php the_title(); ?></a></h2>
						<p class="text-sm text-[#3a5a63] mb-4"><?php echo esc_html( get_the_date() ); ?></p>
						<div class="prose prose-lg max-w-none text-[#3a5a63]">
							<?php the_excerpt(); ?>
						</div>
					</article>
					<?php
				}
				?>
			</div>
			<?php
			the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => __( 'Previous', 'restwell-retreats' ),
				'next_text' => __( 'Next', 'restwell-retreats' ),
			) );
			?>
		<?php else : ?>
			<p class="text-[#3a5a63]"><?php esc_html_e( 'No posts found.', 'restwell-retreats' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
