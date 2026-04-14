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
$page_heading    = $page_id ? get_the_title( $page_id ) : '';
$page_subheading = $page_id ? get_the_excerpt( $page_id ) : '';
$page_hero_media = $page_id ? absint( get_post_meta( $page_id, 'page_hero_image_id', true ) ) : 0;
if ( ! $page_hero_media && $page_id ) {
	$page_hero_media = (int) get_post_thumbnail_id( $page_id );
}
?>
<main class="flex-1" id="main-content">
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>
	<?php
	set_query_var(
		'args',
		array(
			'heading_id' => 'page-hero-heading',
			'label'      => '',
			'heading'    => $page_heading,
			'intro'      => $page_subheading,
			'media_id'   => $page_hero_media,
			'image_alt'  => $page_heading,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>
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
