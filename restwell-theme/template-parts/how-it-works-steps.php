<?php
/**
 * Template part: How it works - four-step process.
 *
 * @package Restwell_Retreats
 * @param array $args {
 *   @type string $steps_label   Eyebrow label (e.g. 'FOUR-STEP PROCESS').
 *   @type string $steps_heading Section h2 heading.
 *   @type string $steps_intro   Optional intro paragraph.
 *   @type array  $steps         Array of ['title' => string, 'body' => string].
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args          = (array) get_query_var( 'args', array() );
$steps_label   = isset( $args['steps_label'] ) ? $args['steps_label'] : '';
$steps_heading = isset( $args['steps_heading'] ) ? $args['steps_heading'] : 'Straightforward from start to finish';
$steps_intro   = isset( $args['steps_intro'] ) ? $args['steps_intro'] : '';
$steps         = isset( $args['steps'] ) && is_array( $args['steps'] ) ? $args['steps'] : array();

if ( empty( $steps ) ) {
	return;
}
?>
<section class="rw-section-y bg-white" aria-labelledby="hiw-steps-heading">
	<div class="container max-w-5xl">
		<?php if ( $steps_label !== '' ) : ?>
		<p class="section-label text-center mb-3"><?php echo esc_html( $steps_label ); ?></p>
		<?php endif; ?>
		<h2 id="hiw-steps-heading" class="text-3xl font-serif text-[var(--deep-teal)] text-center mb-4">
			<?php echo esc_html( $steps_heading ); ?>
		</h2>
		<?php if ( $steps_intro !== '' ) : ?>
		<p class="text-gray-600 text-lg leading-relaxed text-center max-w-prose mx-auto mb-10 md:mb-12"><?php echo esc_html( $steps_intro ); ?></p>
		<?php endif; ?>

		<!-- Step cards - 4-column from md so the sequential flow reads left-to-right -->
		<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
			<?php foreach ( $steps as $idx => $step ) :
				if ( empty( $step['title'] ) ) {
					continue;
				}
				$num = $idx + 1;
			?>
			<div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100
			            flex flex-col items-center text-center
			            hover:shadow-[0_12px_40px_rgb(0,0,0,0.08)] hover:-translate-y-0.5
			            transition-all duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:translate-y-0">
				<div class="w-10 h-10 rounded-full bg-[var(--deep-teal)] text-white font-semibold flex items-center justify-center text-sm mb-5 flex-shrink-0" aria-hidden="true"><?php echo absint( $num ); ?></div>
				<h3 class="text-lg font-serif text-[var(--deep-teal)] mb-2 leading-tight"><?php echo esc_html( $step['title'] ); ?></h3>
				<p class="text-gray-600 leading-relaxed text-sm"><?php echo esc_html( $step['body'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
