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
$hero_eyebrow            = get_post_meta( $pid, 'hero_eyebrow', true ) ?: 'Accessible holiday cottage · Whitstable, Kent';
$hero_heading            = 'A proper holiday. Adapted and practical.';
$hero_subheading         = get_post_meta( $pid, 'hero_subheading', true ) ?: 'A private, fully adapted holiday home on the Kent coast. Designed for disabled guests and their families — with optional care support from a CQC-registered provider.';
$hero_cta_primary_label  = get_post_meta( $pid, 'hero_cta_primary_label', true ) ?: 'See the property';
$hero_cta_primary_url    = get_post_meta( $pid, 'hero_cta_primary_url', true ) ?: '/the-property/';
$hero_cta_secondary_label= get_post_meta( $pid, 'hero_cta_secondary_label', true ) ?: 'Enquire about dates';
$hero_cta_secondary_url  = get_post_meta( $pid, 'hero_cta_secondary_url', true ) ?: '/enquire/';
$hero_cta_promise        = get_post_meta( $pid, 'hero_cta_promise', true ) ?: 'No booking commitment. Just a conversation.';

$what_label   = get_post_meta( $pid, 'what_restwell_label', true ) ?: 'What is Restwell?';
$what_heading = get_post_meta( $pid, 'what_restwell_heading', true ) ?: 'A holiday, not a care home.';
$intro_body   = get_post_meta( $pid, 'intro_body', true ) ?: 'Restwell is a high-quality, wheelchair-accessible single-storey holiday bungalow in Whitstable, Kent — with ceiling track hoist, profiling bed, and a full wet room. This is not a care home or a clinical facility; it is a proper coastal self-catering holiday. Optional professional, CQC-regulated care is available through our partner, Continuity of Care Services, if you want it.';

$who_label   = get_post_meta( $pid, 'who_label', true ) ?: 'Who it\'s for';
$who_heading = get_post_meta( $pid, 'who_heading', true ) ?: 'Two people. One break.';
$who_guest_title = get_post_meta( $pid, 'who_guest_title', true ) ?: 'For the guest';
$who_guest_body  = get_post_meta( $pid, 'who_guest_body', true ) ?: 'A private home with the access features you actually need — wet room, wide doorways, level thresholds, space for your equipment. Explore Whitstable at your own pace. No shared spaces, no schedules, no clinical atmosphere.';
$who_carer_title = get_post_meta( $pid, 'who_carer_title', true ) ?: 'For the carer';
$who_carer_body  = get_post_meta( $pid, 'who_carer_body', true ) ?: 'The property layout supports care routines — separate sleeping, practical bathroom access, space to assist. Optional CQC-regulated support is available through Continuity of Care Services, or bring your own carer. Either way, the environment is set up so you are not improvising.';

$property_label    = get_post_meta( $pid, 'property_label', true ) ?: 'Our Whitstable home';
$property_heading  = get_post_meta( $pid, 'property_heading', true ) ?: 'Our Whitstable home';
$property_body     = get_post_meta( $pid, 'property_body', true ) ?: 'A fully adapted property in a quiet residential street in Whitstable. Level approach, off-street parking for adapted vehicles, and a flat route to the Tankerton promenade. The town centre — with its harbour, independent shops, and seafood restaurants — is a short drive or bus ride away.';
$property_cta_label = get_post_meta( $pid, 'property_cta_label', true ) ?: 'Explore the property';
$property_cta_url  = get_post_meta( $pid, 'property_cta_url', true ) ?: '/the-property/';
$property_image_id = (int) get_post_meta( $pid, 'property_image_id', true );

$why_label   = get_post_meta( $pid, 'why_label', true ) ?: 'Why Restwell?';
$why_heading = get_post_meta( $pid, 'why_heading', true ) ?: 'What makes us different';
$why1_title  = get_post_meta( $pid, 'why_item1_title', true ) ?: 'Private & personal';
$why1_desc   = get_post_meta( $pid, 'why_item1_desc', true ) ?: 'A real home, not a ward or a hotel room. The whole house is yours.';
$why2_title  = get_post_meta( $pid, 'why_item2_title', true ) ?: 'Care if you need it';
$why2_desc   = get_post_meta( $pid, 'why_item2_desc', true ) ?: 'Optional support from Continuity of Care Services, a CQC-regulated provider. Arrange as much or as little as you need — or bring your own carer.';
$why3_title  = get_post_meta( $pid, 'why_item3_title', true ) ?: 'Local knowledge';
$why3_desc   = get_post_meta( $pid, 'why_item3_desc', true ) ?: 'We can tell you which cafes have step-free access, where to park near the harbour, and which routes work for wheelchairs.';
$why4_title  = get_post_meta( $pid, 'why_item4_title', true ) ?: 'Honest & open';
$why4_desc   = get_post_meta( $pid, 'why_item4_desc', true ) ?: 'We tell you exactly what to expect — no surprises, no overselling.';

$cta_heading   = get_post_meta( $pid, 'cta_heading', true ) ?: 'Ready to plan your break?';
$cta_body      = get_post_meta( $pid, 'cta_body', true ) ?: 'Whether you have dates in mind or just want to ask a question, we are here to help. No pressure, just a conversation.';
$cta_primary_label   = get_post_meta( $pid, 'cta_primary_label', true ) ?: 'See the property';
$cta_primary_url     = get_post_meta( $pid, 'cta_primary_url', true ) ?: '/the-property/';
$cta_secondary_label = get_post_meta( $pid, 'cta_secondary_label', true ) ?: 'Enquire about dates';
$cta_secondary_url   = get_post_meta( $pid, 'cta_secondary_url', true ) ?: '/enquire/';
$cta_promise         = get_post_meta( $pid, 'cta_promise', true ) ?: 'No booking commitment. Just a conversation.';
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
					preload="metadata"
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
							loading="lazy"
							decoding="async"
							width="800"
							height="450"
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
					<?php
					$fp_acc  = get_page_by_path( 'accessibility', OBJECT, 'page' );
					$fp_who  = get_page_by_path( 'who-its-for', OBJECT, 'page' );
					$fp_guide = get_page_by_path( 'whitstable-area-guide', OBJECT, 'page' );
					if ( $fp_acc || $fp_who || $fp_guide ) :
						?>
					<p class="text-sm text-[#3a5a63]/90 leading-relaxed pt-2">
						<?php if ( $fp_acc ) : ?>
							<a href="<?php echo esc_url( get_permalink( $fp_acc ) ); ?>" class="text-[#1B4D5C] font-medium underline underline-offset-2 hover:no-underline"><?php esc_html_e( 'Full accessibility specification', 'restwell-retreats' ); ?></a>
						<?php endif; ?>
						<?php if ( $fp_acc && ( $fp_who || $fp_guide ) ) : ?>
							<span class="text-[var(--muted-grey)]" aria-hidden="true"> · </span>
						<?php endif; ?>
						<?php if ( $fp_who ) : ?>
							<a href="<?php echo esc_url( get_permalink( $fp_who ) ); ?>" class="text-[#1B4D5C] font-medium underline underline-offset-2 hover:no-underline"><?php esc_html_e( 'Who it\'s for', 'restwell-retreats' ); ?></a>
						<?php endif; ?>
						<?php if ( $fp_who && $fp_guide ) : ?>
							<span class="text-[var(--muted-grey)]" aria-hidden="true"> · </span>
						<?php endif; ?>
						<?php if ( $fp_guide ) : ?>
							<a href="<?php echo esc_url( get_permalink( $fp_guide ) ); ?>" class="text-[#1B4D5C] font-medium underline underline-offset-2 hover:no-underline"><?php esc_html_e( 'Whitstable &amp; Kent guide', 'restwell-retreats' ); ?></a>
						<?php endif; ?>
					</p>
					<?php endif; ?>
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
