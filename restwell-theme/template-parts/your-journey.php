<?php
/**
 * Template part: Your journey – 4–6 steps from enquiry to feedback.
 *
 * @package Restwell_Retreats
 * @param array $args {
 *   @type string $journey_label   Eyebrow label (optional).
 *   @type string $journey_heading  Section h2 heading.
 *   @type array  $journey_steps   Array of ['title' => string, 'body' => string].
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args          = (array) get_query_var( 'args', array() );
$journey_label = isset( $args['journey_label'] ) ? $args['journey_label'] : '';
$journey_heading = isset( $args['journey_heading'] ) ? $args['journey_heading'] : 'Your journey';
$journey_steps = isset( $args['journey_steps'] ) && is_array( $args['journey_steps'] ) ? $args['journey_steps'] : array();

if ( empty( $journey_steps ) ) {
	return;
}
?>
<section class="py-16 md:py-24 bg-[var(--bg-subtle)]" aria-labelledby="your-journey-heading">
	<div class="container max-w-4xl">
		<?php if ( $journey_label !== '' ) : ?>
			<p class="section-label text-center mb-3"><?php echo esc_html( $journey_label ); ?></p>
		<?php endif; ?>
		<h2 id="your-journey-heading" class="text-3xl font-serif text-[var(--deep-teal)] text-center mb-4">
			<?php echo esc_html( $journey_heading ); ?>
		</h2>

		<div class="relative">
			<?php foreach ( $journey_steps as $idx => $step ) :
				if ( empty( $step['title'] ) ) {
					continue;
				}
				$num = $idx + 1;
			?>
			<div class="flex gap-6 mb-8 last:mb-0">
				<div class="flex-shrink-0 w-10 h-10 rounded-full bg-[var(--deep-teal)] text-white font-semibold flex items-center justify-center text-sm" aria-hidden="true"><?php echo absint( $num ); ?></div>
				<div>
					<h3 class="text-lg font-serif text-[var(--deep-teal)] mb-1 leading-tight"><?php echo esc_html( $step['title'] ); ?></h3>
					<?php if ( ! empty( $step['body'] ) ) : ?>
						<p class="text-gray-600 leading-relaxed text-sm"><?php echo esc_html( $step['body'] ); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
