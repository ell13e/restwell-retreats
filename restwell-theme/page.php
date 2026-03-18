<?php
/**
 * Default page template. Used when no custom template is assigned.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$page_id = get_queried_object_id();
$page_heading   = $page_id ? get_the_title( $page_id ) : '';
$page_subheading = $page_id ? get_the_excerpt( $page_id ) : '';
?>
<main class="flex-1" id="main-content">
	<section class="page-hero relative overflow-hidden py-12 md:py-16 bg-[var(--deep-teal)]" aria-labelledby="page-hero-heading">
		<div class="relative z-10 container">
			<div class="max-w-3xl text-center">
				<h1 id="page-hero-heading" class="text-3xl md:text-4xl font-serif leading-tight mb-3 text-white"><?php echo esc_html( $page_heading ); ?></h1>
				<?php if ( $page_subheading !== '' ) : ?>
					<p class="text-lg leading-relaxed max-w-prose mx-auto text-white/90"><?php echo esc_html( $page_subheading ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<div class="container py-16 md:py-24">
		<?php
		while ( have_posts() ) {
			the_post();
			?>
			<article>
				<div class="prose prose-lg max-w-none text-[#3a5a63]">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		}
		?>
	</div>
</main>
<?php get_footer(); ?>
