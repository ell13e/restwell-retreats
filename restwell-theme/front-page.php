<?php
/**
 * Front Page template.
 * Uses Page Content Fields meta (get_post_meta) and featured/attachment images.
 * WordPress core only.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();
$hero_eyebrow            = get_post_meta( $pid, 'hero_eyebrow', true ) ?: 'Accessible holidays in Whitstable';
$hero_heading            = get_post_meta( $pid, 'hero_heading', true ) ?: 'Rest easy. A real holiday for both of you.';
$hero_subheading         = get_post_meta( $pid, 'hero_subheading', true ) ?: 'A beautiful, accessible home on the Kent coast — where guests find adventure and carers find a true break.';
$hero_cta_primary_label  = get_post_meta( $pid, 'hero_cta_primary_label', true ) ?: 'See the property';
$hero_cta_primary_url    = get_post_meta( $pid, 'hero_cta_primary_url', true ) ?: '/property';
$hero_cta_secondary_label= get_post_meta( $pid, 'hero_cta_secondary_label', true ) ?: 'Enquire about dates';
$hero_cta_secondary_url  = get_post_meta( $pid, 'hero_cta_secondary_url', true ) ?: '/enquire';
$hero_cta_promise        = get_post_meta( $pid, 'hero_cta_promise', true ) ?: '';

$what_label   = get_post_meta( $pid, 'what_restwell_label', true ) ?: 'What is Restwell Retreats?';
$what_heading = get_post_meta( $pid, 'what_restwell_heading', true ) ?: 'A holiday, not a care home.';

$who_label   = get_post_meta( $pid, 'who_label', true ) ?: 'Who it\'s for';
$who_heading = get_post_meta( $pid, 'who_heading', true ) ?: 'Two people. One break.';
$who_guest_title = get_post_meta( $pid, 'who_guest_title', true ) ?: 'For the guest';
$who_guest_body  = get_post_meta( $pid, 'who_guest_body', true ) ?: 'A space designed around you. Wide doorways, level access, and the freedom to explore Whitstable\'s vibrant coast at your own pace. This is your holiday — not an appointment, not a schedule. Just the sea air, good food, and a comfortable home to come back to.';
$who_carer_title = get_post_meta( $pid, 'who_carer_title', true ) ?: 'For the carer';
$who_carer_body  = get_post_meta( $pid, 'who_carer_body', true ) ?: 'Peace of mind is the ultimate luxury. With optional professional support available from CCS, you can step back, relax, and enjoy being a partner, a parent, or a friend again — rather than a full-time carer. Rest easy knowing they are safe, happy, and having a proper break too.';

$property_label    = get_post_meta( $pid, 'property_label', true ) ?: 'Our Whitstable home';
$property_heading  = get_post_meta( $pid, 'property_heading', true ) ?: '101 Russell Drive';
$property_body     = get_post_meta( $pid, 'property_body', true ) ?: 'Our flagship property sits in a quiet residential corner of Whitstable, just a short, flat walk from the famous Tankerton Slopes promenade. It is the perfect base for exploring everything this charming coastal town has to offer — from Harbour Street\'s independent shops to fresh oysters by the water.';
$property_cta_label = get_post_meta( $pid, 'property_cta_label', true ) ?: 'Explore the property';
$property_cta_url  = get_post_meta( $pid, 'property_cta_url', true ) ?: '/property';
$property_image_id = (int) get_post_meta( $pid, 'property_image_id', true );

$why_label   = get_post_meta( $pid, 'why_label', true ) ?: 'Why Restwell?';
$why_heading = get_post_meta( $pid, 'why_heading', true ) ?: 'What makes us different';
$why1_title  = get_post_meta( $pid, 'why_item1_title', true ) ?: 'Private & personal';
$why1_desc   = get_post_meta( $pid, 'why_item1_desc', true ) ?: 'A real home, not a ward or a hotel room. The whole house is yours.';
$why2_title  = get_post_meta( $pid, 'why_item2_title', true ) ?: 'Expertly supported';
$why2_desc   = get_post_meta( $pid, 'why_item2_desc', true ) ?: 'Optional CQC-regulated care from Continuity of Care Services.';
$why3_title  = get_post_meta( $pid, 'why_item3_title', true ) ?: 'Whitstable local';
$why3_desc   = get_post_meta( $pid, 'why_item3_desc', true ) ?: 'We know the best accessible spots, the quietest cafes, and the flattest routes.';
$why4_title  = get_post_meta( $pid, 'why_item4_title', true ) ?: 'Honest & open';
$why4_desc   = get_post_meta( $pid, 'why_item4_desc', true ) ?: 'We tell you exactly what to expect — no surprises, no overselling.';

$cta_heading   = get_post_meta( $pid, 'cta_heading', true ) ?: 'Ready to plan your break?';
$cta_body      = get_post_meta( $pid, 'cta_body', true ) ?: 'Whether you have dates in mind or just want to ask a question, we are here to help. No pressure, just a conversation.';
$cta_primary_label   = get_post_meta( $pid, 'cta_primary_label', true ) ?: 'See the property';
$cta_primary_url     = get_post_meta( $pid, 'cta_primary_url', true ) ?: '/property';
$cta_secondary_label = get_post_meta( $pid, 'cta_secondary_label', true ) ?: 'Enquire about dates';
$cta_secondary_url   = get_post_meta( $pid, 'cta_secondary_url', true ) ?: '/enquire';
$cta_promise         = get_post_meta( $pid, 'cta_promise', true ) ?: '';
$cta_image_id = (int) get_post_meta( $pid, 'cta_image_id', true );

$trust_label          = get_post_meta( $pid, 'trust_label', true ) ?: '';
$trust_heading        = get_post_meta( $pid, 'trust_heading', true ) ?: '';
$trust_badge_image_id = (int) get_post_meta( $pid, 'trust_badge_image_id', true );
$trust_line           = get_post_meta( $pid, 'trust_line', true ) ?: '';
$trust_badge_src      = $trust_badge_image_id ? wp_get_attachment_image_url( $trust_badge_image_id, 'medium' ) : '';
$show_trust           = $trust_line !== '' || $trust_badge_src !== '';

$testimonial_label  = get_post_meta( $pid, 'testimonial_label', true ) ?: '';
$testimonial_heading = get_post_meta( $pid, 'testimonial_heading', true ) ?: 'What guests say';
$testimonials = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$q = get_post_meta( $pid, "testimonial_{$i}_quote", true );
	if ( $q !== '' ) {
		$testimonials[] = array(
			'quote' => $q,
			'name'  => get_post_meta( $pid, "testimonial_{$i}_name", true ) ?: '',
			'role'  => get_post_meta( $pid, "testimonial_{$i}_role", true ) ?: '',
		);
	}
}
$show_testimonials = ! empty( $testimonials );

$hero_media_id = absint( get_post_meta( $pid, 'hero_media_id', true ) );
$hero_media_mime = $hero_media_id ? get_post_mime_type( $hero_media_id ) : '';
$hero_is_video  = $hero_media_mime && strpos( $hero_media_mime, 'video/' ) === 0;
$hero_media_url = $hero_media_id ? ( $hero_is_video ? wp_get_attachment_url( $hero_media_id ) : wp_get_attachment_image_url( $hero_media_id, 'full' ) ) : '';

$property_src = $property_image_id ? wp_get_attachment_image_url( $property_image_id, 'full' ) : '';
$cta_src      = $cta_image_id ? wp_get_attachment_image_url( $cta_image_id, 'full' ) : '';
?>
<main class="flex-1" id="main-content">
	<!-- Hero Section -->
	<section class="hero relative flex items-end overflow-hidden min-h-[32rem] <?php echo $hero_media_id ? '' : 'bg-[var(--deep-teal)]'; ?>" aria-labelledby="home-hero-heading">
		<?php if ( $hero_media_id && $hero_media_url ) : ?>
			<?php if ( $hero_is_video ) : ?>
				<video
					class="absolute inset-0 w-full h-full object-cover -z-10"
					autoplay
					muted
					loop
					playsinline
					aria-hidden="true"
				>
					<source src="<?php echo esc_url( $hero_media_url ); ?>" type="<?php echo esc_attr( $hero_media_mime ); ?>">
				</video>
			<?php else : ?>
				<img
					src="<?php echo esc_url( $hero_media_url ); ?>"
					alt="<?php echo esc_attr( $hero_heading ); ?>"
					class="absolute inset-0 w-full h-full object-cover -z-10"
				/>
			<?php endif; ?>
		<?php endif; ?>
		<div class="absolute inset-0 bg-black/30 -z-[5]" aria-hidden="true"></div>
		<div class="absolute inset-0 bg-gradient-to-t from-[var(--deep-teal)]/85 via-[var(--deep-teal)]/45 to-transparent -z-[5]" aria-hidden="true"></div>
		<div class="relative z-10 container pb-16 md:pb-24 pt-32">
			<div class="max-w-2xl">
				<?php if ( $hero_eyebrow !== '' ) : ?>
				<p class="text-[var(--warm-gold-hero)] text-xs font-semibold uppercase tracking-[0.2em] mb-4 font-sans">
					<?php echo esc_html( $hero_eyebrow ); ?>
				</p>
				<?php endif; ?>
				<h1 id="home-hero-heading" class="text-white text-4xl md:text-5xl lg:text-6xl mb-6 leading-tight">
					<?php echo esc_html( $hero_heading ); ?>
				</h1>
				<p class="text-[#F5EDE0] text-lg md:text-xl mb-8 leading-relaxed max-w-prose drop-shadow-[0_1px_2px_rgba(0,0,0,0.3)]">
					<?php echo esc_html( $hero_subheading ); ?>
				</p>
				<div class="flex flex-wrap gap-4">
					<a
						href="<?php echo esc_url( $hero_cta_primary_url ); ?>"
						class="btn btn-gold"
					>
						<?php echo esc_html( $hero_cta_primary_label ); ?>
						<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
					</a>
					<a
						href="<?php echo esc_url( $hero_cta_secondary_url ); ?>"
						class="btn btn-ghost-light"
					>
						<?php echo esc_html( $hero_cta_secondary_label ); ?>
					</a>
				</div>
				<?php if ( $hero_cta_promise !== '' ) : ?>
					<p class="text-white/90 text-sm mt-4"><?php echo esc_html( $hero_cta_promise ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- What is Restwell Retreats? -->
	<section class="intro-section py-20 md:py-28">
		<div class="container">
			<div class="max-w-3xl mx-auto text-center">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $what_label ) ); ?>
				<h2 class="text-3xl md:text-4xl mb-8 section-heading"><?php echo esc_html( $what_heading ); ?></h2>
				<?php
				$intro_body = get_post_meta( get_the_ID(), 'intro_body', true );
				if ( $intro_body ) {
					echo '<p class="text-lg">' . wp_kses_post( $intro_body ) . '</p>';
				}
				?>
			</div>
		</div>
	</section>

	<!-- Who It's For — Dual Audience Cards -->
	<section class="who-section py-16 md:py-24 bg-white">
		<div class="container">
			<div class="text-center mb-12">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $who_label ) ); ?>
				<h2 class="text-3xl md:text-4xl section-heading"><?php echo esc_html( $who_heading ); ?></h2>
			</div>
			<div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
				<div class="who-card bg-[#F5EDE0] rounded-2xl p-8 md:p-10 space-y-4">
					<div class="w-14 h-14 bg-[#A8D5D0]/30 rounded-full flex items-center justify-center text-[#1B4D5C] text-xl">
						<i class="fa-solid fa-house" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl"><?php echo esc_html( $who_guest_title ); ?></h3>
					<p class="text-[#3a5a63] leading-relaxed"><?php echo esc_html( $who_guest_body ); ?></p>
				</div>
				<div class="who-card bg-[#F5EDE0] rounded-2xl p-8 md:p-10 space-y-4">
					<div class="w-14 h-14 bg-[#D4A853]/20 rounded-full flex items-center justify-center text-[#D4A853] text-xl">
						<i class="fa-solid fa-heart" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl"><?php echo esc_html( $who_carer_title ); ?></h3>
					<p class="text-[#3a5a63] leading-relaxed"><?php echo esc_html( $who_carer_body ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- Property Snapshot -->
	<section class="property-section py-16 md:py-24">
		<div class="container">
			<div class="property-grid grid gap-8 items-center">
				<div class="property-grid__image rounded-2xl overflow-hidden shadow-lg">
					<?php if ( $property_src ) : ?>
						<img
							src="<?php echo esc_url( $property_src ); ?>"
							alt="<?php echo esc_attr( $property_heading ); ?>"
							class="w-full h-[350px] md:h-[450px] object-cover"
						/>
					<?php else : ?>
						<!-- PROPERTY IMAGE NEEDED -->
						<div class="property-placeholder" style="width:100%; height:350px; background:#E8DFD0; display:flex; align-items:center; justify-content:center; color:#8B8B7A;">Add property image</div>
					<?php endif; ?>
				</div>
				<div class="property-grid__text space-y-6">
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $property_label ) ); ?>
					<h2 class="text-3xl"><?php echo esc_html( $property_heading ); ?></h2>
					<p class="text-[#3a5a63] leading-relaxed"><?php echo esc_html( $property_body ); ?></p>
					<a
						href="<?php echo esc_url( $property_cta_url ); ?>"
						class="inline-flex items-center gap-2 text-[#1B4D5C] font-semibold hover:text-[#815F10] hover:underline transition-colors duration-300 no-underline"
					>
						<?php echo esc_html( $property_cta_label ); ?>
						<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Why Restwell? Mini -->
	<section class="features-section py-16 md:py-24 bg-white">
		<div class="container">
			<div class="text-center mb-12">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $why_label ) ); ?>
				<h2 class="text-3xl md:text-4xl section-heading"><?php echo esc_html( $why_heading ); ?></h2>
			</div>
			<div class="features-grid grid sm:grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto mt-8">
				<div class="feature-item group text-center space-y-4 p-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-house feature-icon-svg text-[#1B4D5C] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[#1B4D5C]"><?php echo esc_html( $why1_title ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $why1_desc ); ?></p>
				</div>

				<div class="feature-item group text-center space-y-4 p-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-shield-halved feature-icon-svg text-[#1B4D5C] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[#1B4D5C]"><?php echo esc_html( $why2_title ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $why2_desc ); ?></p>
				</div>

				<div class="feature-item group text-center space-y-4 p-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-location-dot feature-icon-svg text-[#1B4D5C] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[#1B4D5C]"><?php echo esc_html( $why3_title ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $why3_desc ); ?></p>
				</div>

				<div class="feature-item group text-center space-y-4 p-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-heart feature-icon-svg text-[#1B4D5C] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[#1B4D5C]"><?php echo esc_html( $why4_title ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $why4_desc ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $show_trust ) : ?>
	<!-- Trust / accreditations -->
	<section class="py-12 md:py-16 bg-[var(--bg-subtle)]">
		<div class="container text-center">
			<?php if ( $trust_label !== '' ) : ?>
				<p class="section-label mb-3"><?php echo esc_html( $trust_label ); ?></p>
			<?php endif; ?>
			<?php if ( $trust_heading !== '' ) : ?>
				<h2 class="text-2xl font-serif text-[var(--deep-teal)] mb-6"><?php echo esc_html( $trust_heading ); ?></h2>
			<?php endif; ?>
			<div class="flex flex-col sm:flex-row items-center justify-center gap-6 flex-wrap">
				<?php if ( $trust_badge_src ) : ?>
					<img src="<?php echo esc_url( $trust_badge_src ); ?>" alt="" class="h-16 w-auto object-contain" loading="lazy" />
				<?php endif; ?>
				<?php if ( $trust_line !== '' ) : ?>
					<p class="text-[#3a5a63] text-base font-medium"><?php echo esc_html( $trust_line ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $show_testimonials ) : ?>
	<!-- Testimonials -->
	<section class="py-16 md:py-24 bg-white">
		<div class="container">
			<?php if ( $testimonial_label !== '' ) : ?>
				<p class="section-label text-center mb-3"><?php echo esc_html( $testimonial_label ); ?></p>
			<?php endif; ?>
			<h2 class="text-3xl md:text-4xl section-heading text-center mb-12"><?php echo esc_html( $testimonial_heading ); ?></h2>
			<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
				<?php foreach ( $testimonials as $t ) : ?>
					<blockquote class="bg-[var(--bg-subtle)] rounded-2xl p-6 md:p-8 flex flex-col">
						<p class="text-[#3a5a63] leading-relaxed flex-1 mb-4"><?php echo esc_html( $t['quote'] ); ?></p>
						<footer class="text-[var(--deep-teal)] font-medium">
							<?php echo esc_html( $t['name'] ); ?>
							<?php if ( $t['role'] !== '' ) : ?>
								<span class="block text-sm font-normal text-gray-500"><?php echo esc_html( $t['role'] ); ?></span>
							<?php endif; ?>
						</footer>
					</blockquote>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- CTA Section -->
	<section class="relative py-20 md:py-28 overflow-hidden">
		<?php if ( $cta_src ) : ?>
			<img
				src="<?php echo esc_url( $cta_src ); ?>"
				alt=""
				class="absolute inset-0 w-full h-full object-cover"
				role="presentation"
			/>
		<?php else : ?>
			<!-- IMAGE NEEDED: CTA background (set cta_image_id in Page Content Fields) -->
		<?php endif; ?>
		<div class="absolute inset-0 bg-[#1B4D5C]/75"></div>
		<div class="relative container text-center">
			<h2 class="text-white text-3xl md:text-4xl mb-4"><?php echo esc_html( $cta_heading ); ?></h2>
			<p class="text-[#F5EDE0] text-lg mb-8 max-w-lg mx-auto opacity-90">
				<?php echo esc_html( $cta_body ); ?>
			</p>
			<div class="flex flex-col sm:flex-row justify-center gap-4">
				<a
					href="<?php echo esc_url( $cta_primary_url ); ?>"
					class="btn btn-gold w-full sm:w-auto"
				>
					<?php echo esc_html( $cta_primary_label ); ?>
				</a>
				<a
					href="<?php echo esc_url( $cta_secondary_url ); ?>"
					class="btn btn-ghost-light w-full sm:w-auto"
				>
					<?php echo esc_html( $cta_secondary_label ); ?>
				</a>
			</div>
			<?php if ( $cta_promise !== '' ) : ?>
				<p class="text-white/90 text-sm mt-4"><?php echo esc_html( $cta_promise ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
global $restwell_hide_footer_cta;
$restwell_hide_footer_cta = true;
get_footer();
?>
