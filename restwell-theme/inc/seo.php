<?php
/**
 * SEO: title override, OG/Twitter Card meta tags, and JSON-LD structured data.
 *
 * All structured data is injected via wp_head hooks so no template files
 * need modifying for JSON-LD. Output order:
 *   priority 5  — OG + Twitter Card meta tags
 *   priority 10 — JSON-LD blocks
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---------------------------------------------------------------------------
// 1. Title tag override
// ---------------------------------------------------------------------------

/**
 * Allow editors to override the page <title> via the meta_title field.
 *
 * @param array $parts Associative array of title parts.
 * @return array
 */
function restwell_document_title_parts( $parts ) {
	if ( is_singular() ) {
		$custom = get_post_meta( get_queried_object_id(), 'meta_title', true );
		if ( $custom !== '' ) {
			$parts['title'] = $custom;
		}
	}
	return $parts;
}
add_filter( 'document_title_parts', 'restwell_document_title_parts' );

// ---------------------------------------------------------------------------
// 1b. Google Search Console verification
// ---------------------------------------------------------------------------

/**
 * Output the Google Search Console verification meta tag when the option is set.
 */
function restwell_output_gsc_verification() {
	$token = (string) get_option( 'restwell_gsc_verification', '' );
	if ( $token === '' ) {
		return;
	}
	echo '<meta name="google-site-verification" content="' . esc_attr( $token ) . '">' . "\n";
}
add_action( 'wp_head', 'restwell_output_gsc_verification', 1 );

// ---------------------------------------------------------------------------
// 1c. Robots meta (noindex) + canonical URL
// ---------------------------------------------------------------------------

/**
 * Output <meta name="robots"> noindex tag when the field is set.
 * Also outputs <link rel="canonical"> when a custom canonical is stored,
 * or the default permalink otherwise (on singular pages).
 */
function restwell_output_canonical_and_robots() {
	if ( ! is_singular() ) {
		return;
	}

	$pid = get_queried_object_id();

	// Noindex.
	$noindex = (bool) get_post_meta( $pid, 'meta_noindex', true );
	if ( $noindex ) {
		echo '<meta name="robots" content="noindex, nofollow">' . "\n";
	}

	// Canonical.
	$canonical = (string) get_post_meta( $pid, 'meta_canonical', true );
	if ( $canonical === '' ) {
		$canonical = get_permalink( $pid );
	}
	echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
}
add_action( 'wp_head', 'restwell_output_canonical_and_robots', 2 );

// ---------------------------------------------------------------------------
// 2. OG + Twitter Card meta tags
// ---------------------------------------------------------------------------

/**
 * Output Open Graph and Twitter Card <meta> tags in <head>.
 */
function restwell_output_social_meta() {
	$pid = is_singular() ? get_queried_object_id() : 0;

	// Title
	if ( $pid ) {
		$title = get_post_meta( $pid, 'meta_title', true );
		if ( $title === '' ) {
			$title = get_the_title( $pid );
		}
	} else {
		$title = get_bloginfo( 'name' );
	}

	// Description
	$desc = $pid ? get_post_meta( $pid, 'meta_description', true ) : '';
	if ( $desc === '' ) {
		$desc = get_bloginfo( 'description' );
	}

	// URL
	$url = $pid ? get_permalink( $pid ) : home_url( '/' );
	if ( is_front_page() ) {
		$url = home_url( '/' );
	}

	// Image — og_image_id → featured image (posts) → template hero image → blank
	$image_url = '';
	if ( $pid ) {
		$og_img_id = absint( get_post_meta( $pid, 'og_image_id', true ) );
		if ( $og_img_id ) {
			$image_url = wp_get_attachment_image_url( $og_img_id, 'full' );
		}
		// For posts, use the featured image as the OG image.
		if ( ! $image_url && is_singular( 'post' ) ) {
			$thumb_id = get_post_thumbnail_id( $pid );
			if ( $thumb_id ) {
				$image_url = wp_get_attachment_image_url( $thumb_id, 'full' );
			}
		}
		if ( ! $image_url ) {
			// Fallback: try common hero image meta keys across templates
			$hero_keys = array( 'hero_media_id', 'prop_hero_image_id' );
			foreach ( $hero_keys as $key ) {
				$hero_id = absint( get_post_meta( $pid, $key, true ) );
				if ( $hero_id ) {
					$candidate = wp_get_attachment_image_url( $hero_id, 'full' );
					if ( $candidate ) {
						$image_url = $candidate;
						break;
					}
				}
			}
		}
	}

	// og:type — use saved value if set, otherwise derive from post type.
	$og_type = $pid ? (string) get_post_meta( $pid, 'meta_og_type', true ) : '';
	if ( ! in_array( $og_type, array( 'website', 'article' ), true ) ) {
		$og_type = is_singular( 'post' ) ? 'article' : 'website';
	}

	echo "\n<!-- Open Graph -->\n";
	echo '<meta property="og:locale" content="en_GB">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc !== '' ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	if ( $image_url ) {
		echo '<meta property="og:image" content="' . esc_url( $image_url ) . '">' . "\n";
	}
	if ( is_singular( 'post' ) ) {
		$post_obj = get_post();
		if ( $post_obj ) {
			echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c', $post_obj ) ) . '">' . "\n";
			echo '<meta property="article:author" content="' . esc_attr( get_the_author_meta( 'display_name', (int) $post_obj->post_author ) ) . '">' . "\n";
		}
	}

	echo "\n<!-- Twitter Card -->\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc !== '' ) {
		echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	if ( $image_url ) {
		echo '<meta name="twitter:image" content="' . esc_url( $image_url ) . '">' . "\n";
	}
	echo "\n";
}
add_action( 'wp_head', 'restwell_output_social_meta', 5 );

// ---------------------------------------------------------------------------
// 3. JSON-LD structured data
// ---------------------------------------------------------------------------

/**
 * Output all applicable JSON-LD <script> blocks.
 */
function restwell_output_structured_data() {
	restwell_output_jsonld_website_organization();

	if ( is_singular() && ! is_front_page() ) {
		restwell_output_jsonld_breadcrumb();
	}

	if ( is_singular( 'post' ) ) {
		restwell_output_jsonld_article();
	}

	if ( is_page_template( 'template-property.php' ) ) {
		restwell_output_jsonld_vacation_rental();
	}

	if ( is_page_template( 'template-faq.php' ) ) {
		restwell_output_jsonld_faq_page();
	}
}
add_action( 'wp_head', 'restwell_output_structured_data', 10 );

/**
 * Helper: encode schema array to a JSON-LD <script> block.
 *
 * @param array $schema Schema.org data array.
 */
function restwell_print_jsonld( $schema ) {
	// Remove null values to keep output clean
	$schema = array_filter(
		$schema,
		function( $v ) {
			return $v !== null && $v !== '' && $v !== array();
		}
	);
	echo '<script type="application/ld+json">' . "\n";
	echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	echo "\n" . '</script>' . "\n";
}

/**
 * WebSite + Organization — output sitewide.
 */
function restwell_output_jsonld_website_organization() {
	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url( '/' );

	$website = array(
		'@context' => 'https://schema.org',
		'@type'    => 'WebSite',
		'name'     => $site_name,
		'url'      => $site_url,
	);

	$organization = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'name'     => $site_name,
		'url'      => $site_url,
		'description' => get_bloginfo( 'description' ),
		'address' => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => (string) get_option( 'restwell_property_address', '101 Russell Drive' ),
			'addressLocality' => 'Whitstable',
			'addressRegion'   => 'Kent',
			'postalCode'      => (string) get_option( 'restwell_property_postcode', 'CT5 2RQ' ),
			'addressCountry'  => 'GB',
		),
	);

	restwell_print_jsonld( $website );
	restwell_print_jsonld( $organization );
}

/**
 * BreadcrumbList — output on interior singular pages.
 * For single posts, outputs a 3-level crumb: Home > Articles > Post title.
 */
function restwell_output_jsonld_breadcrumb() {
	$items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => 'Home',
			'item'     => home_url( '/' ),
		),
	);

	if ( is_singular( 'post' ) ) {
		// Middle crumb: the "page for posts" or a fallback label.
		$posts_page_id  = (int) get_option( 'page_for_posts' );
		$archive_name   = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Articles', 'restwell-retreats' );
		$archive_url    = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/articles/' );

		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => $archive_name,
			'item'     => $archive_url,
		);
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 3,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	} else {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	}

	restwell_print_jsonld( array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	) );
}

/**
 * Article (BlogPosting) — output on single post pages.
 */
function restwell_output_jsonld_article() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	$title       = get_the_title( $pid );
	$excerpt     = wp_strip_all_tags( get_the_excerpt( $pid ) );
	$date_pub    = get_the_date( 'c', $pid );
	$date_mod    = get_the_modified_date( 'c', $pid );
	$author_name = get_bloginfo( 'name' ); // site name as author for brand articles

	$image_url = '';
	$thumb_id  = get_post_thumbnail_id( $pid );
	if ( $thumb_id ) {
		$image_url = wp_get_attachment_image_url( $thumb_id, 'full' );
	}

	$schema = array(
		'@context'         => 'https://schema.org',
		'@type'            => 'BlogPosting',
		'headline'         => $title,
		'url'              => get_permalink( $pid ),
		'datePublished'    => $date_pub,
		'dateModified'     => $date_mod,
		'description'      => $excerpt,
		'author'           => array(
			'@type' => 'Organization',
			'name'  => $author_name,
			'url'   => home_url( '/' ),
		),
		'publisher'        => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
			'url'   => home_url( '/' ),
		),
		'inLanguage'       => 'en-GB',
		'isPartOf'         => array(
			'@type' => 'WebSite',
			'url'   => home_url( '/' ),
			'name'  => get_bloginfo( 'name' ),
		),
	);

	if ( $image_url ) {
		$schema['image'] = $image_url;
	}

	restwell_print_jsonld( $schema );
}

/**
 * VacationRental — output on the property template.
 */
function restwell_output_jsonld_vacation_rental() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	// Name: meta_title → hero heading → site name
	$name = get_post_meta( $pid, 'meta_title', true );
	if ( $name === '' ) {
		$name = get_post_meta( $pid, 'prop_hero_heading', true );
	}
	if ( $name === '' ) {
		$name = get_bloginfo( 'name' ) . ' – ' . (string) get_option( 'restwell_property_address', '101 Russell Drive' ) . ', Whitstable';
	}

	// Description
	$desc = get_post_meta( $pid, 'meta_description', true );
	if ( $desc === '' ) {
		$desc = get_post_meta( $pid, 'prop_hero_subtitle', true );
	}

	// Address
	$street   = get_post_meta( $pid, 'prop_address_street', true )   ?: '101 Russell Drive';
	$locality = get_post_meta( $pid, 'prop_address_locality', true ) ?: 'Whitstable';
	$region   = get_post_meta( $pid, 'prop_address_region', true )   ?: 'Kent';
	$postcode = get_post_meta( $pid, 'prop_address_postcode', true ) ?: 'CT5 2RQ';

	// Practical details
	$bedrooms = get_post_meta( $pid, 'prop_bedrooms_count', true );
	$sleeps   = get_post_meta( $pid, 'prop_sleeps_value', true );

	// Amenities from feature grid (prop_feature_1 … prop_feature_8)
	$amenities = array();
	for ( $i = 1; $i <= 8; $i++ ) {
		$feat = get_post_meta( $pid, 'prop_feature_' . $i, true );
		$feat_desc = get_post_meta( $pid, 'prop_feature_' . $i . '_desc', true );
		if ( $feat !== '' ) {
			$amenity = array(
				'@type' => 'LocationFeatureSpecification',
				'name'  => $feat,
				'value' => true,
			);
			if ( $feat_desc !== '' ) {
				$amenity['description'] = $feat_desc;
			}
			$amenities[] = $amenity;
		}
	}

	// Primary image
	$image_url = '';
	$og_img_id = absint( get_post_meta( $pid, 'og_image_id', true ) );
	if ( $og_img_id ) {
		$image_url = wp_get_attachment_image_url( $og_img_id, 'full' );
	}
	if ( ! $image_url ) {
		$hero_img_id = absint( get_post_meta( $pid, 'prop_hero_image_id', true ) );
		if ( $hero_img_id ) {
			$image_url = wp_get_attachment_image_url( $hero_img_id, 'full' );
		}
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'VacationRental',
		'name'        => $name,
		'url'         => get_permalink( $pid ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $street,
			'addressLocality' => $locality,
			'addressRegion'   => $region,
			'postalCode'      => $postcode,
			'addressCountry'  => 'GB',
		),
	);

	if ( $desc !== '' ) {
		$schema['description'] = $desc;
	}
	if ( $image_url ) {
		$schema['photo'] = $image_url;
	}
	if ( $bedrooms !== '' && is_numeric( $bedrooms ) ) {
		$schema['numberOfRooms'] = (int) $bedrooms;
	}
	if ( $sleeps !== '' ) {
		// sleeps value may be "9+" or a plain integer
		$max_sleeps = (int) filter_var( $sleeps, FILTER_SANITIZE_NUMBER_INT );
		if ( $max_sleeps > 0 ) {
			$schema['occupancy'] = array(
				'@type'    => 'QuantitativeValue',
				'maxValue' => $max_sleeps,
			);
		}
	}
	if ( ! empty( $amenities ) ) {
		$schema['amenityFeature'] = $amenities;
	}

	restwell_print_jsonld( $schema );
}

/**
 * FAQPage — output on the FAQ template.
 */
function restwell_output_jsonld_faq_page() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	$faq_pairs = array();
	for ( $i = 1; $i <= 12; $i++ ) {
		$q = get_post_meta( $pid, "faq_{$i}_q", true );
		$a = get_post_meta( $pid, "faq_{$i}_a", true );
		if ( $q !== '' && $a !== '' ) {
			$faq_pairs[] = array( 'q' => $q, 'a' => $a );
		}
	}

	// If no custom pairs saved, mirror the template's built-in fallbacks
	if ( empty( $faq_pairs ) ) {
		$faq_pairs = array(
			array( 'q' => 'Is this a care home?', 'a' => 'No. Restwell Retreats is a private holiday let — a real house that you have entirely to yourself. It is not a care home, a residential facility, or a clinical environment. Care is an optional extra that you can choose to add through our partner, Continuity of Care Services.' ),
			array( 'q' => 'Can I bring my own carer or PA?', 'a' => 'Absolutely. Many of our guests bring their own Personal Assistant or carer. The property is designed to accommodate everyone comfortably. You can also use CCS for \'top-up\' support alongside your own carer.' ),
			array( 'q' => 'What care can you provide?', 'a' => 'Care is provided by Continuity of Care Services (CCS), a CQC-regulated Kent-based provider. Support can range from a brief morning check-in to more comprehensive daily assistance. We will discuss your needs before your stay.' ),
			array( 'q' => 'What accessibility features does the property have?', 'a' => 'The property has level access throughout the ground floor and wide doorways suitable for wheelchair access. It is located on a quiet, flat residential street. For full details please visit our Accessibility page.' ),
			array( 'q' => 'How do I book?', 'a' => 'Start by using our enquiry form or getting in touch by phone or email. We will talk through your dates, your needs, and any questions you have. Once we have confirmed availability and you are happy with everything, we will confirm your booking.' ),
			array( 'q' => "Is the beach accessible?", 'a' => "Whitstable's beach is shingle, which is generally not wheelchair-friendly. However, the Tankerton Slopes promenade — a long, flat concrete walkway above the beach — is excellent for wheelchair users and offers stunning sea views." ),
		);
	}

	$main_entity = array();
	foreach ( $faq_pairs as $pair ) {
		$main_entity[] = array(
			'@type'          => 'Question',
			'name'           => $pair['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $pair['a'],
			),
		);
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $main_entity,
	);

	restwell_print_jsonld( $schema );
}
