<?php
/**
 * Front page: seed and render post_content alongside Page Content Fields meta.
 *
 * When the Home page has non-empty post_content, front-page.php outputs it (hero + media stay PHP-driven).
 * Theme setup seeds post_content from merged meta + theme defaults so the classic editor and SEO tools see real copy.
 *
 * Bidirectional sync on save (static front page only, priority 20 after meta box save):
 * - Editor body changed → HTML is parsed into Page Content Fields (intro → CTA). Hero remains meta-only.
 * - Editor body unchanged, meta changed → post_content is rebuilt from merged meta so the editor matches fields.
 * - Clearing the editor does not delete meta; the template falls back to meta-driven sections.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Merge theme setup defaults with stored post meta for the front page.
 *
 * @param int $post_id Front page ID.
 * @return array<string, string|int>
 */
function restwell_get_front_page_merged_meta( $post_id ) {
	$defaults = restwell_get_theme_setup_defaults();
	$out      = array();
	foreach ( $defaults as $key => $default ) {
		$v = get_post_meta( $post_id, $key, true );
		if ( 'property_image_id' === $key || 'cta_image_id' === $key ) {
			$vid = (int) $v;
			$out[ $key ] = $vid > 0 ? $vid : (int) $default;
			continue;
		}
		if ( $v === '' || null === $v ) {
			$out[ $key ] = $default;
		} else {
			$out[ $key ] = $v;
		}
	}
	return $out;
}

/**
 * Build editor HTML matching front-page.php body sections (intro through CTA).
 *
 * @param int $post_id Front page ID.
 * @return string HTML (no hero — hero stays in template).
 */
function restwell_build_front_page_editor_html( $post_id ) {
	$m = restwell_get_front_page_merged_meta( $post_id );

	$property_image_id = (int) ( $m['property_image_id'] ?? 0 );
	$property_src      = $property_image_id ? wp_get_attachment_image_url( $property_image_id, 'full' ) : '';
	$cta_image_id      = (int) ( $m['cta_image_id'] ?? 0 );
	$cta_src           = $cta_image_id ? wp_get_attachment_image_url( $cta_image_id, 'full' ) : '';

	$fp_acc   = get_page_by_path( 'accessibility', OBJECT, 'page' );
	$fp_who   = get_page_by_path( 'who-its-for', OBJECT, 'page' );
	$fp_guide = get_page_by_path( 'whitstable-area-guide', OBJECT, 'page' );
	$fp_hiw   = get_page_by_path( 'how-it-works', OBJECT, 'page' );

	$intro_raw = isset( $m['intro_body'] ) ? $m['intro_body'] : '';
	$intro_html = $intro_raw !== '' ? wp_kses_post( $intro_raw ) : '';

	ob_start();
	?>
	<!-- restwell: front page body (editable; hero remains in template) -->
	<section class="intro-section py-20 md:py-28 bg-white">
		<div class="container">
			<div class="max-w-3xl mx-auto text-center">
				<span class="section-label block mb-4"><?php echo esc_html( $m['what_restwell_label'] ); ?></span>
				<h2 class="text-3xl md:text-4xl mb-8 section-heading"><?php echo esc_html( $m['what_restwell_heading'] ); ?></h2>
				<?php if ( $intro_html !== '' ) : ?>
				<p class="text-lg"><?php echo $intro_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="who-section py-16 md:py-24 bg-[var(--soft-sand)]">
		<div class="container">
			<div class="text-center mb-12">
				<span class="section-label block mb-4"><?php echo esc_html( $m['who_label'] ); ?></span>
				<h2 class="text-3xl md:text-4xl section-heading"><?php echo esc_html( $m['who_heading'] ); ?></h2>
			</div>
			<div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
				<div class="who-card flex flex-col items-center justify-center text-center bg-[#F5EDE0] rounded-2xl p-8 md:p-10 min-h-[16rem] md:min-h-[18rem]">
					<div class="who-card__stack flex w-full max-w-sm flex-col items-center justify-center gap-4">
						<div class="w-14 h-14 bg-[#A8D5D0]/30 rounded-full flex items-center justify-center text-[#1B4D5C] text-xl shrink-0">
							<i class="fa-solid fa-house" aria-hidden="true"></i>
						</div>
						<h3 class="text-xl m-0"><?php echo esc_html( $m['who_guest_title'] ); ?></h3>
						<p class="who-card__body text-center leading-relaxed m-0 w-full"><?php echo esc_html( $m['who_guest_body'] ); ?></p>
					</div>
				</div>
				<div class="who-card flex flex-col items-center justify-center text-center bg-[#F5EDE0] rounded-2xl p-8 md:p-10 min-h-[16rem] md:min-h-[18rem]">
					<div class="who-card__stack flex w-full max-w-sm flex-col items-center justify-center gap-4">
						<div class="w-14 h-14 bg-[#D4A853]/20 rounded-full flex items-center justify-center text-[#815F10] text-xl shrink-0">
							<i class="fa-solid fa-heart" aria-hidden="true"></i>
						</div>
						<h3 class="text-xl m-0"><?php echo esc_html( $m['who_carer_title'] ); ?></h3>
						<p class="who-card__body text-center leading-relaxed m-0 w-full"><?php echo esc_html( $m['who_carer_body'] ); ?></p>
					</div>
				</div>
			</div>
			<?php if ( $fp_who ) : ?>
			<p class="text-center text-sm text-gray-500 mt-10">
				<a href="<?php echo esc_url( get_permalink( $fp_who ) ); ?>"
					class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline">
					<?php esc_html_e( 'Find out if Restwell is right for you →', 'restwell-retreats' ); ?>
				</a>
			</p>
			<?php endif; ?>
		</div>
	</section>

	<section class="property-section py-16 md:py-24 bg-white">
		<div class="container">
			<div class="property-grid grid gap-8 items-center">
				<div class="property-grid__image rounded-2xl overflow-hidden shadow-lg">
					<?php if ( $property_src ) : ?>
						<img
							src="<?php echo esc_url( $property_src ); ?>"
							alt="<?php echo esc_attr( $m['property_heading'] ); ?>"
							class="w-full h-[350px] md:h-[450px] object-cover"
							loading="lazy"
							decoding="async"
							width="800"
							height="450"
						/>
					<?php else : ?>
						<div class="property-placeholder w-full h-[350px] bg-[#E8DFD0] flex items-center justify-center text-[#8B8B7A] rounded-2xl">
							<span><?php esc_html_e( 'Add property image', 'restwell-retreats' ); ?></span>
						</div>
					<?php endif; ?>
				</div>
				<div class="property-grid__text space-y-6">
					<span class="section-label block mb-4"><?php echo esc_html( $m['property_label'] ); ?></span>
					<h2 class="text-3xl"><?php echo esc_html( $m['property_heading'] ); ?></h2>
					<p class="text-[#3a5a63] leading-relaxed"><?php echo esc_html( $m['property_body'] ); ?></p>
					<?php if ( $fp_acc || $fp_who || $fp_guide || $fp_hiw ) : ?>
					<p class="text-sm text-[#3a5a63]/90 leading-relaxed pt-2">
						<?php if ( $fp_acc ) : ?>
							<a href="<?php echo esc_url( get_permalink( $fp_acc ) ); ?>" class="text-[#1B4D5C] font-medium underline underline-offset-2 hover:no-underline"><?php esc_html_e( 'Accessibility specification', 'restwell-retreats' ); ?></a>
						<?php endif; ?>
						<?php if ( $fp_acc && ( $fp_who || $fp_guide || $fp_hiw ) ) : ?>
							<span class="text-[var(--muted-grey)]" aria-hidden="true"> · </span>
						<?php endif; ?>
						<?php if ( $fp_who ) : ?>
							<a href="<?php echo esc_url( get_permalink( $fp_who ) ); ?>" class="text-[#1B4D5C] font-medium underline underline-offset-2 hover:no-underline"><?php esc_html_e( 'Who it\'s for', 'restwell-retreats' ); ?></a>
						<?php endif; ?>
						<?php if ( $fp_who && ( $fp_guide || $fp_hiw ) ) : ?>
							<span class="text-[var(--muted-grey)]" aria-hidden="true"> · </span>
						<?php endif; ?>
						<?php if ( $fp_guide ) : ?>
							<a href="<?php echo esc_url( get_permalink( $fp_guide ) ); ?>" class="text-[#1B4D5C] font-medium underline underline-offset-2 hover:no-underline"><?php esc_html_e( 'Whitstable &amp; Kent guide', 'restwell-retreats' ); ?></a>
						<?php endif; ?>
						<?php if ( $fp_guide && $fp_hiw ) : ?>
							<span class="text-[var(--muted-grey)]" aria-hidden="true"> · </span>
						<?php endif; ?>
						<?php if ( $fp_hiw ) : ?>
							<a href="<?php echo esc_url( get_permalink( $fp_hiw ) ); ?>" class="text-[#1B4D5C] font-medium underline underline-offset-2 hover:no-underline"><?php esc_html_e( 'How booking works', 'restwell-retreats' ); ?></a>
						<?php endif; ?>
					</p>
					<?php endif; ?>
					<a
						href="<?php echo esc_url( restwell_front_page_editor_normalize_url( $m['property_cta_url'] ) ); ?>"
						class="inline-flex items-center gap-2 text-[#1B4D5C] font-semibold hover:text-[#815F10] hover:underline transition-colors duration-300 no-underline"
					>
						<?php echo esc_html( $m['property_cta_label'] ); ?>
						<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	<section class="features-section py-16 md:py-24 bg-[var(--bg-subtle)]">
		<div class="container">
			<div class="text-center mb-12">
				<span class="section-label block mb-4"><?php echo esc_html( $m['why_label'] ); ?></span>
				<h2 class="text-3xl md:text-4xl section-heading"><?php echo esc_html( $m['why_heading'] ); ?></h2>
			</div>
			<div class="features-grid grid sm:grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto mt-8">
				<div class="feature-item group text-center space-y-4 p-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-house feature-icon-svg text-[#1B4D5C] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[#1B4D5C]"><?php echo esc_html( $m['why_item1_title'] ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $m['why_item1_desc'] ); ?></p>
				</div>
				<div class="feature-item group text-center space-y-4 p-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-shield-halved feature-icon-svg text-[#1B4D5C] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[#1B4D5C]"><?php echo esc_html( $m['why_item2_title'] ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $m['why_item2_desc'] ); ?></p>
				</div>
				<div class="feature-item group text-center space-y-4 p-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-location-dot feature-icon-svg text-[#1B4D5C] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[#1B4D5C]"><?php echo esc_html( $m['why_item3_title'] ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $m['why_item3_desc'] ); ?></p>
				</div>
				<div class="feature-item group text-center space-y-4 p-4">
					<div class="feature-icon-wrapper">
						<div class="feature-icon-blob"></div>
						<i class="fa-solid fa-heart feature-icon-svg text-[#1B4D5C] text-2xl" aria-hidden="true"></i>
					</div>
					<h3 class="text-xl font-serif text-[#1B4D5C]"><?php echo esc_html( $m['why_item4_title'] ); ?></h3>
					<p class="text-[15px] text-[#3a5a63] leading-relaxed"><?php echo esc_html( $m['why_item4_desc'] ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="relative py-20 md:py-28 overflow-hidden">
		<?php if ( $cta_src ) : ?>
			<img
				src="<?php echo esc_url( $cta_src ); ?>"
				alt=""
				class="absolute inset-0 w-full h-full object-cover"
				role="presentation"
				loading="lazy"
				decoding="async"
			/>
		<?php endif; ?>
		<div class="absolute inset-0 bg-[#1B4D5C]/75" aria-hidden="true"></div>
		<div class="relative container text-center">
			<h2 class="text-white text-3xl md:text-4xl mb-4"><?php echo esc_html( $m['cta_heading'] ); ?></h2>
			<p class="text-[#F5EDE0] text-lg mb-8 max-w-lg mx-auto opacity-90">
				<?php echo esc_html( $m['cta_body'] ); ?>
			</p>
			<?php get_template_part( 'template-parts/cta-accessibility-prompt', null, array( 'variant' => 'dark' ) ); ?>
			<div class="flex flex-col sm:flex-row justify-center gap-4">
				<a
					href="<?php echo esc_url( restwell_front_page_editor_normalize_url( $m['cta_primary_url'] ) ); ?>"
					class="btn btn-gold w-full sm:w-auto"
				>
					<?php echo esc_html( $m['cta_primary_label'] ); ?>
				</a>
				<a
					href="<?php echo esc_url( restwell_front_page_editor_normalize_url( $m['cta_secondary_url'] ) ); ?>"
					class="btn btn-ghost-light w-full sm:w-auto"
				>
					<?php echo esc_html( $m['cta_secondary_label'] ); ?>
				</a>
			</div>
			<?php if ( ! empty( $m['cta_promise'] ) ) : ?>
				<p class="text-white/90 text-sm mt-4"><?php echo esc_html( $m['cta_promise'] ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
	return (string) ob_get_clean();
}

/**
 * Turn stored path or URL into a full URL for href attributes in seeded editor HTML.
 *
 * @param string $url Path like /enquire/ or full URL.
 * @return string
 */
function restwell_front_page_editor_normalize_url( $url ) {
	$url = trim( (string) $url );
	if ( $url === '' ) {
		return home_url( '/' );
	}
	if ( preg_match( '#^https?://#i', $url ) ) {
		return $url;
	}
	return home_url( $url );
}

/**
 * Replace &lt;label&gt; elements that no longer associate with a control after wp_kses_post().
 * KSES often strips &lt;input&gt;/&lt;select&gt;/&lt;textarea&gt; while leaving labels (or leaves
 * label[for] pointing at a removed id), which fails "label must be associated with a control".
 *
 * @param string $html Sanitized HTML fragment.
 * @return string
 */
function restwell_front_page_fix_unassociated_labels( $html ) {
	$html = (string) $html;
	if ( $html === '' || stripos( $html, '<label' ) === false ) {
		return $html;
	}

	$labelable = array( 'INPUT', 'TEXTAREA', 'SELECT', 'BUTTON', 'METER', 'OUTPUT' );

	libxml_use_internal_errors( true );
	$doc = new DOMDocument();
	$wrapped = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body><div id="restwell-label-root">' . $html . '</div></body></html>';
	$loaded = $doc->loadHTML( $wrapped );
	libxml_clear_errors();
	if ( ! $loaded ) {
		return $html;
	}

	$root = $doc->getElementById( 'restwell-label-root' );
	if ( ! $root ) {
		return $html;
	}

	$xpath = new DOMXPath( $doc );
	$ids   = array();
	foreach ( $xpath->query( './/*[@id]', $root ) as $node ) {
		if ( $node instanceof DOMElement ) {
			$ids[ $node->getAttribute( 'id' ) ] = $node;
		}
	}

	$labels = array();
	foreach ( $xpath->query( './/label', $root ) as $node ) {
		if ( $node instanceof DOMElement ) {
			$labels[] = $node;
		}
	}

	foreach ( $labels as $lab ) {
		$for = $lab->getAttribute( 'for' );
		if ( $for !== '' ) {
			$target_ok = isset( $ids[ $for ] ) && in_array( $ids[ $for ]->nodeName, $labelable, true );
			if ( ! $target_ok ) {
				$lab->removeAttribute( 'for' );
			} else {
				continue;
			}
		}

		$has_labelable_child = false;
		foreach ( $labelable as $tag ) {
			if ( $lab->getElementsByTagName( strtolower( $tag ) )->length > 0 ) {
				$has_labelable_child = true;
				break;
			}
		}

		if ( $has_labelable_child ) {
			continue;
		}

		$span = $doc->createElement( 'span' );
		if ( $lab->hasAttributes() ) {
			foreach ( iterator_to_array( $lab->attributes ) as $attr ) {
				if ( ! ( $attr instanceof DOMAttr ) ) {
					continue;
				}
				if ( 'for' === $attr->name ) {
					continue;
				}
				$span->setAttribute( $attr->name, $attr->value );
			}
		}
		while ( $lab->firstChild ) {
			$span->appendChild( $lab->firstChild );
		}
		if ( $lab->parentNode ) {
			$lab->parentNode->replaceChild( $span, $lab );
		}
	}

	$out = '';
	foreach ( $root->childNodes as $child ) {
		$out .= $doc->saveHTML( $child );
	}
	return $out;
}

/**
 * Filters front page post_content for output (no wpautop — markup is block-level HTML).
 *
 * @param string $html HTML from the editor.
 * @return string
 */
function restwell_front_page_body_html_filter( $html ) {
	$html = wptexturize( $html );
	$html = shortcode_unautop( $html );
	$html = do_shortcode( $html );
	$html = wp_kses_post( $html );
	return restwell_front_page_fix_unassociated_labels( $html );
}
add_filter( 'restwell_front_page_body_html', 'restwell_front_page_body_html_filter' );

/**
 * Convert an href from saved HTML to the path-style value stored in meta (e.g. /enquire/).
 *
 * @param string $href Raw href.
 * @return string
 */
function restwell_front_page_href_to_meta_value( $href ) {
	$href = trim( (string) $href );
	if ( $href === '' ) {
		return '';
	}
	if ( preg_match( '#^mailto:|^tel:#i', $href ) ) {
		return $href;
	}
	$parts = wp_parse_url( $href );
	if ( ! empty( $parts['path'] ) && empty( $parts['host'] ) ) {
		return $parts['path'] . ( ! empty( $parts['query'] ) ? '?' . $parts['query'] : '' );
	}
	$home = untrailingslashit( home_url() );
	if ( strpos( $href, $home ) === 0 ) {
		$path = substr( $href, strlen( $home ) );
		return ( $path !== '' ? '/' : '' ) . ltrim( $path, '/' );
	}
	if ( strpos( $href, '/' ) === 0 ) {
		return $href;
	}
	return $href;
}

/**
 * Inner HTML of a DOM node.
 *
 * @param DOMNode|null $node Node.
 * @return string
 */
function restwell_front_page_dom_inner_html( $node ) {
	if ( ! $node || ! $node->ownerDocument ) {
		return '';
	}
	$html = '';
	foreach ( $node->childNodes as $child ) {
		$html .= $node->ownerDocument->saveHTML( $child );
	}
	return trim( $html );
}

/**
 * Parse Restwell front-page editor HTML and write values into Page Content Fields meta.
 * Expects markup produced by restwell_build_front_page_editor_html() (same section classes).
 *
 * @param int    $post_id Post ID.
 * @param string $html    post_content HTML.
 */
function restwell_parse_front_page_html_to_meta( $post_id, $html ) {
	if ( ! class_exists( 'DOMDocument' ) || trim( wp_strip_all_tags( $html ) ) === '' ) {
		return;
	}

	libxml_use_internal_errors( true );
	$dom = new DOMDocument();
	$wrapped = '<?xml encoding="UTF-8"?><div id="restwell-sync-root">' . $html . '</div>';
	// Flags are not defined if libxml is unavailable or compiled without these constants.
	$load_flags = 0;
	if ( defined( 'LIBXML_HTML_NOERROR' ) ) {
		$load_flags |= LIBXML_HTML_NOERROR;
	}
	if ( defined( 'LIBXML_HTML_NOWARNING' ) ) {
		$load_flags |= LIBXML_HTML_NOWARNING;
	}
	$dom->loadHTML( $wrapped, $load_flags );
	libxml_clear_errors();

	$xpath = new DOMXPath( $dom );

	// Intro.
	$intro_sec = $xpath->query( "//*[local-name()='section' and contains(concat(' ', normalize-space(@class), ' '), ' intro-section ')]" )->item( 0 );
	if ( $intro_sec ) {
		$label = $xpath->query( ".//*[contains(@class,'section-label')]", $intro_sec )->item( 0 );
		$h2    = $xpath->query( ".//h2[contains(@class,'section-heading')]", $intro_sec )->item( 0 );
		$p     = $xpath->query( ".//p[contains(@class,'text-lg')]", $intro_sec )->item( 0 );
		if ( $label ) {
			update_post_meta( $post_id, 'what_restwell_label', sanitize_text_field( $label->textContent ) );
		}
		if ( $h2 ) {
			update_post_meta( $post_id, 'what_restwell_heading', sanitize_text_field( $h2->textContent ) );
		}
		if ( $p ) {
			$inner = restwell_front_page_dom_inner_html( $p );
			update_post_meta( $post_id, 'intro_body', wp_kses_post( $inner ) );
		}
	}

	// Who it's for.
	$who_sec = $xpath->query( "//*[local-name()='section' and contains(concat(' ', normalize-space(@class), ' '), ' who-section ')]" )->item( 0 );
	if ( $who_sec ) {
		$wlabel = $xpath->query( ".//*[contains(@class,'section-label')]", $who_sec )->item( 0 );
		$wh2    = $xpath->query( ".//h2[contains(@class,'section-heading')]", $who_sec )->item( 0 );
		if ( $wlabel ) {
			update_post_meta( $post_id, 'who_label', sanitize_text_field( $wlabel->textContent ) );
		}
		if ( $wh2 ) {
			update_post_meta( $post_id, 'who_heading', sanitize_text_field( $wh2->textContent ) );
		}
		$cards = $xpath->query( ".//*[contains(@class,'who-card')]", $who_sec );
		if ( $cards->length >= 1 ) {
			$h3 = $xpath->query( ".//h3", $cards->item( 0 ) )->item( 0 );
			$pb = $xpath->query( ".//p[contains(@class,'leading-relaxed')]", $cards->item( 0 ) )->item( 0 );
			if ( $h3 ) {
				update_post_meta( $post_id, 'who_guest_title', sanitize_text_field( $h3->textContent ) );
			}
			if ( $pb ) {
				update_post_meta( $post_id, 'who_guest_body', sanitize_textarea_field( $pb->textContent ) );
			}
		}
		if ( $cards->length >= 2 ) {
			$h3b = $xpath->query( ".//h3", $cards->item( 1 ) )->item( 0 );
			$pbb = $xpath->query( ".//p[contains(@class,'leading-relaxed')]", $cards->item( 1 ) )->item( 0 );
			if ( $h3b ) {
				update_post_meta( $post_id, 'who_carer_title', sanitize_text_field( $h3b->textContent ) );
			}
			if ( $pbb ) {
				update_post_meta( $post_id, 'who_carer_body', sanitize_textarea_field( $pbb->textContent ) );
			}
		}
	}

	// Property.
	$prop_sec = $xpath->query( "//*[local-name()='section' and contains(concat(' ', normalize-space(@class), ' '), ' property-section ')]" )->item( 0 );
	if ( $prop_sec ) {
		$pimg = $xpath->query( ".//div[contains(@class,'property-grid__image')]//img", $prop_sec )->item( 0 );
		if ( $pimg instanceof DOMElement ) {
			$src = $pimg->getAttribute( 'src' );
			if ( $src !== '' ) {
				$aid = attachment_url_to_postid( $src );
				if ( $aid > 0 ) {
					update_post_meta( $post_id, 'property_image_id', $aid );
				}
			}
		}
		$ptext = $xpath->query( ".//*[contains(@class,'property-grid__text')]", $prop_sec )->item( 0 );
		if ( $ptext ) {
			$plab = $xpath->query( ".//*[contains(@class,'section-label')]", $ptext )->item( 0 );
			$ph2  = $xpath->query( ".//h2", $ptext )->item( 0 );
			$pp   = $xpath->query( ".//p[contains(@class,'leading-relaxed') and not(contains(@class,'text-sm'))]", $ptext )->item( 0 );
			if ( $plab ) {
				update_post_meta( $post_id, 'property_label', sanitize_text_field( $plab->textContent ) );
			}
			if ( $ph2 ) {
				update_post_meta( $post_id, 'property_heading', sanitize_text_field( $ph2->textContent ) );
			}
			if ( $pp ) {
				update_post_meta( $post_id, 'property_body', sanitize_textarea_field( $pp->textContent ) );
			}
			$pcta = $xpath->query( ".//a[.//i[contains(@class,'fa-chevron-right')]] | .//a[contains(@class,'inline-flex')][contains(@class,'font-semibold')]", $ptext )->item( 0 );
			if ( $pcta instanceof DOMElement ) {
				update_post_meta( $post_id, 'property_cta_label', sanitize_text_field( $pcta->textContent ) );
				update_post_meta( $post_id, 'property_cta_url', sanitize_text_field( restwell_front_page_href_to_meta_value( $pcta->getAttribute( 'href' ) ) ) );
			}
		}
	}

	// Features (four columns).
	$feat_sec = $xpath->query( "//*[local-name()='section' and contains(concat(' ', normalize-space(@class), ' '), ' features-section ')]" )->item( 0 );
	if ( $feat_sec ) {
		$flab = $xpath->query( ".//*[contains(@class,'section-label')]", $feat_sec )->item( 0 );
		$fh2  = $xpath->query( ".//h2[contains(@class,'section-heading')]", $feat_sec )->item( 0 );
		if ( $flab ) {
			update_post_meta( $post_id, 'why_label', sanitize_text_field( $flab->textContent ) );
		}
		if ( $fh2 ) {
			update_post_meta( $post_id, 'why_heading', sanitize_text_field( $fh2->textContent ) );
		}
		$items = $xpath->query( ".//*[contains(@class,'feature-item')]", $feat_sec );
		$keys  = array(
			array( 'why_item1_title', 'why_item1_desc' ),
			array( 'why_item2_title', 'why_item2_desc' ),
			array( 'why_item3_title', 'why_item3_desc' ),
			array( 'why_item4_title', 'why_item4_desc' ),
		);
		for ( $i = 0; $i < 4 && $i < $items->length; $i++ ) {
			$it = $items->item( $i );
			$h3 = $xpath->query( ".//h3", $it )->item( 0 );
			$pd = $xpath->query( ".//p", $it )->item( 0 );
			if ( $h3 ) {
				update_post_meta( $post_id, $keys[ $i ][0], sanitize_text_field( $h3->textContent ) );
			}
			if ( $pd ) {
				update_post_meta( $post_id, $keys[ $i ][1], sanitize_textarea_field( $pd->textContent ) );
			}
		}
	}

	// CTA block (section with overlay + buttons).
	$cta_sec = $xpath->query( "//*[local-name()='section' and .//a[contains(@class,'btn-gold')] and .//a[contains(@class,'btn-ghost-light')]]" )->item( 0 );
	if ( $cta_sec ) {
		$cimg = $xpath->query( ".//img[contains(@class,'object-cover')]", $cta_sec )->item( 0 );
		if ( $cimg instanceof DOMElement ) {
			$csrc = $cimg->getAttribute( 'src' );
			if ( $csrc !== '' ) {
				$cid = attachment_url_to_postid( $csrc );
				if ( $cid > 0 ) {
					update_post_meta( $post_id, 'cta_image_id', $cid );
				}
			}
		}
		$ch2 = $xpath->query( ".//div[contains(@class,'container')]//h2", $cta_sec )->item( 0 );
		$cp  = $xpath->query( ".//div[contains(@class,'container')]//p[contains(@class,'text-[#F5EDE0]') or contains(@class,'opacity-90')]", $cta_sec )->item( 0 );
		if ( ! $cp ) {
			$cp = $xpath->query( ".//div[contains(@class,'container')]//p[position()<=2]", $cta_sec )->item( 0 );
		}
		if ( $ch2 ) {
			update_post_meta( $post_id, 'cta_heading', sanitize_text_field( $ch2->textContent ) );
		}
		if ( $cp ) {
			update_post_meta( $post_id, 'cta_body', sanitize_textarea_field( $cp->textContent ) );
		}
		$gold = $xpath->query( ".//a[contains(@class,'btn-gold')]", $cta_sec )->item( 0 );
		$gho  = $xpath->query( ".//a[contains(@class,'btn-ghost-light')]", $cta_sec )->item( 0 );
		if ( $gold instanceof DOMElement ) {
			update_post_meta( $post_id, 'cta_primary_label', sanitize_text_field( $gold->textContent ) );
			update_post_meta( $post_id, 'cta_primary_url', sanitize_text_field( restwell_front_page_href_to_meta_value( $gold->getAttribute( 'href' ) ) ) );
		}
		if ( $gho instanceof DOMElement ) {
			update_post_meta( $post_id, 'cta_secondary_label', sanitize_text_field( $gho->textContent ) );
			update_post_meta( $post_id, 'cta_secondary_url', sanitize_text_field( restwell_front_page_href_to_meta_value( $gho->getAttribute( 'href' ) ) ) );
		}
		$prom = $xpath->query( ".//p[contains(@class,'text-white/90')]", $cta_sec )->item( 0 );
		if ( $prom ) {
			update_post_meta( $post_id, 'cta_promise', sanitize_text_field( $prom->textContent ) );
		}
	}
}

/**
 * Replace editor HTML from current meta (used when meta changed but visual body did not).
 *
 * @param int $post_id Front page ID.
 * @return bool True if post_content was updated.
 */
function restwell_rebuild_front_page_editor_from_meta( $post_id ) {
	$built = restwell_build_front_page_editor_html( $post_id );
	$post  = get_post( $post_id );
	if ( ! $post ) {
		return false;
	}
	if ( $built === $post->post_content ) {
		update_post_meta( $post_id, '_restwell_last_saved_post_content', $built );
		return false;
	}

	remove_action( 'save_post_page', 'restwell_front_page_sync_on_save', 20 );

	$updated = wp_update_post(
		array(
			'ID'           => $post_id,
			'post_content' => $built,
		),
		true
	);

	add_action( 'save_post_page', 'restwell_front_page_sync_on_save', 20, 3 );

	if ( is_wp_error( $updated ) ) {
		return false;
	}

	update_post_meta( $post_id, '_restwell_last_saved_post_content', $built );
	return true;
}

/**
 * Keep Page Content Fields and classic editor body in sync for the static front page.
 *
 * - Visual/HTML editor changed → parse into meta (after meta box save, so we overwrite stale POST meta).
 * - Editor unchanged, meta changed → rebuild editor HTML from meta.
 *
 * Hero fields remain meta-only (not in post_content).
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @param bool    $update  Whether this is an update.
 */
function restwell_front_page_sync_on_save( $post_id, $post, $update ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( ! empty( $GLOBALS['restwell_front_page_syncing'] ) ) {
		return;
	}

	$front_id = (int) get_option( 'page_on_front' );
	if ( $front_id < 1 || (int) $post_id !== $front_id || 'page' !== $post->post_type ) {
		return;
	}

	$new_content = isset( $post->post_content ) ? $post->post_content : '';
	$prev        = get_post_meta( $post_id, '_restwell_last_saved_post_content', true );
	$prev        = is_string( $prev ) ? $prev : '';

	$has_body = trim( wp_strip_all_tags( $new_content ) ) !== '';

	$pre = isset( $GLOBALS['restwell_front_page_pre_save_content'] ) ? (string) $GLOBALS['restwell_front_page_pre_save_content'] : null;
	unset( $GLOBALS['restwell_front_page_pre_save_content'] );

	// No snapshot yet: parse only if the editor body actually changed vs the previous revision
	// (avoids parsing stale HTML over meta saved at priority 10 on a meta-only save).
	if ( $prev === '' ) {
		if ( $has_body && null !== $pre && $pre !== $new_content ) {
			$GLOBALS['restwell_front_page_syncing'] = true;
			restwell_parse_front_page_html_to_meta( $post_id, $new_content );
			$GLOBALS['restwell_front_page_syncing'] = false;
		}
		update_post_meta( $post_id, '_restwell_last_saved_post_content', $new_content );
		return;
	}

	if ( ! $has_body ) {
		update_post_meta( $post_id, '_restwell_last_saved_post_content', '' );
		return;
	}

	$content_changed = ( $prev !== $new_content );

	$GLOBALS['restwell_front_page_syncing'] = true;

	if ( $content_changed ) {
		restwell_parse_front_page_html_to_meta( $post_id, $new_content );
		update_post_meta( $post_id, '_restwell_last_saved_post_content', $new_content );
		$GLOBALS['restwell_front_page_syncing'] = false;
		return;
	}

	restwell_rebuild_front_page_editor_from_meta( $post_id );

	$GLOBALS['restwell_front_page_syncing'] = false;
}
add_action( 'save_post_page', 'restwell_front_page_sync_on_save', 20, 3 );

/**
 * Store pre-update post_content for the static front page so sync can tell meta-only vs editor edits
 * when the sync snapshot meta is still empty.
 *
 * @param array $data    Slashed post data.
 * @param array $postarr Incoming post array.
 * @return array Unmodified $data.
 */
function restwell_front_page_capture_pre_save_content( $data, $postarr ) {
	if ( empty( $postarr['ID'] ) ) {
		return $data;
	}
	$front_id = (int) get_option( 'page_on_front' );
	if ( $front_id < 1 || (int) $postarr['ID'] !== $front_id ) {
		return $data;
	}
	$old = get_post( (int) $postarr['ID'] );
	$GLOBALS['restwell_front_page_pre_save_content'] = $old ? (string) $old->post_content : '';
	return $data;
}
add_filter( 'wp_insert_post_data', 'restwell_front_page_capture_pre_save_content', 5, 2 );

/**
 * Seed Home post_content from merged meta so the classic editor shows the same copy as defaults.
 *
 * Does not overwrite non-empty content unless $force is true.
 *
 * @param int  $post_id Front page ID.
 * @param bool $force   When true, replace post_content from current meta (e.g. Theme Setup force re-seed).
 * @return bool True if post was updated.
 */
function restwell_seed_front_page_editor_content( $post_id, $force = false ) {
	$post_id = (int) $post_id;
	if ( $post_id < 1 ) {
		return false;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return false;
	}

	$existing = trim( (string) $post->post_content );
	$flag     = get_post_meta( $post_id, 'restwell_editor_content_seeded', true );

	if ( ! $force && $existing !== '' ) {
		if ( $flag !== '1' ) {
			update_post_meta( $post_id, 'restwell_editor_content_seeded', '1' );
		}
		return false;
	}

	if ( ! $force && $flag === '1' && $existing === '' ) {
		// Initial seed ran but an editor cleared content; leave empty and use template meta fallback.
		return false;
	}

	$html = restwell_build_front_page_editor_html( $post_id );

	$updated = wp_update_post(
		array(
			'ID'           => $post_id,
			'post_content' => $html,
		),
		true
	);

	if ( is_wp_error( $updated ) ) {
		return false;
	}

	update_post_meta( $post_id, 'restwell_editor_content_seeded', '1' );
	update_post_meta( $post_id, '_restwell_last_saved_post_content', $html );
	return true;
}
