<?php
/**
 * SEO-oriented default meta and optional blog seeding for Theme Setup.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default meta_title, meta_description, and focus_keyphrase by page/post slug (path without slashes).
 * Each meta_description is written so it contains the focus keyphrase (checked in SEO admin analysis).
 *
 * @return array<string, array{meta_title:string, meta_description:string, focus_keyphrase:string}>
 */
function restwell_get_seo_meta_defaults_by_slug() {
	$name = get_bloginfo( 'name' );
	// Defaults tuned for 50–60 char titles, 120–160 char descriptions, unique focus keyphrases (cannibalization), and theme SEO admin keyphrase checks.
	return array(
		'how-it-works'          => array(
			'meta_title'       => 'How It Works | Plan Your Accessible Stay | ' . $name,
			'meta_description' => 'Plan your accessible stay from first enquiry to keys: what we include, typical rates, arrival, and optional CQC-regulated care. No pressure: ask us anything.',
			'focus_keyphrase'  => 'accessible stay',
		),
		'home'                  => array(
			'meta_title'       => 'Accessible holidays Whitstable 2026 | ' . $name,
			
			// Variant A: Specificity-led (151 chars) - ACTIVE
			'meta_description' => 'Ceiling track hoist, profiling bed, wet room. Private self-catering bungalow in Whitstable. Optional CQC-regulated care. No booking commitment.',
			
			// Variant B: Outcome-led (148 chars)
			// 'meta_description' => 'Accessible coastal break in Whitstable: adapted bungalow, ceiling hoist, wet room. Private self-catering. Optional care partner. Enquire today.',
			
			// Variant C: Differentiator-led (153 chars)
			// 'meta_description' => 'Private adapted holiday home Whitstable: ceiling hoist, profiling bed, roll-in wet room. Whole-property booking. Optional CQC care. No pressure.',
			
			'focus_keyphrase'  => 'accessible holidays whitstable',
		),
		'the-property'          => array(
			'meta_title'       => 'Adapted Bungalow Whitstable | Property | ' . $name,
			'meta_description' => 'Adapted bungalow Whitstable: ceiling track hoist, profiling bed, roll-in shower, wide doorways. Private self-catering accessible stay. Book direct.',
			'focus_keyphrase'  => 'adapted bungalow whitstable',
		),
		'accessibility'         => array(
			'meta_title'       => 'Wheelchair Accessible Holiday Cottage | ' . $name,
			'meta_description' => 'Wheelchair accessible holiday cottage: hoist, profiling bed, wide doors, roll-in shower, step-free. Download our access statement and book with confidence.',
			'focus_keyphrase'  => 'wheelchair accessible holiday cottage',
		),
		'who-its-for'           => array(
			'meta_title'       => 'Respite Breaks in Kent | Who It Is For | ' . $name,
			'meta_description' => 'Respite breaks in Kent for families, carers, OTs, and commissioners: how Restwell supports guests, case managers, referrals, and funded routes.',
			'focus_keyphrase'  => 'respite breaks in kent',
		),
		'whitstable-area-guide' => array(
			'meta_title'       => 'Whitstable Kent Coast Guide | Days Out | ' . $name,
			'meta_description' => 'The Whitstable Kent coast: accessible days out in Canterbury, Faversham, Herne Bay, Tankerton. Where to eat, promenade walks, parking, and travel tips.',
			'focus_keyphrase'  => 'whitstable kent coast',
		),
		'enquire'               => array(
			'meta_title'       => 'Enquire at Restwell | Availability | ' . $name,
			'meta_description' => 'Enquire at Restwell for rates and availability. Tell us your access needs: we offer flexible check-in, direct payments, and funded stays where eligible.',
			'focus_keyphrase'  => 'enquire at restwell',
		),
		'faq'                   => array(
			'meta_title'       => 'Restwell Booking Questions | FAQ | ' . $name,
			'meta_description' => 'Restwell booking questions answered: equipment, carers, dogs, funding, cancellations, and what to pack. Straight answers before you commit.',
			'focus_keyphrase'  => 'restwell booking questions',
		),
		'resources'             => array(
			'meta_title'       => 'Accessible Break in Kent | Funding Hub | ' . $name,
			'meta_description' => 'Plan an accessible break in Kent: direct payments, CHC, local authority routes, grants, and what to ask your social worker before you book.',
			'focus_keyphrase'  => 'accessible break in kent',
		),
		'blog'                  => array(
			'meta_title'       => 'Accessible Travel Blog | Kent Stories | ' . $name,
			'meta_description' => 'Accessible travel and Kent coast guides: days out, planning tips, funding news, and stories from guests with disabilities and carers.',
			'focus_keyphrase'  => 'accessible travel',
		),
		'guest-guide'                              => array(
			'meta_title'       => 'Restwell Guest Guide | Check-In Tips | ' . $name,
			'meta_description' => 'Restwell guest guide: check-in, Wi-Fi, house rules, parking, and local tips for Whitstable. Everything confirmed guests need in one place.',
			'focus_keyphrase'  => 'restwell guest guide',
		),
		'accessible-beaches-coastal-walks-kent'    => array(
			'meta_title'       => 'Accessible Beaches Kent | Coast Walks | ' . $name,
			'meta_description' => 'Accessible beaches Kent: level promenades, Beach Within Reach, Herne Bay, Viking Bay, Margate. Plan a seaside day with realistic access notes.',
			'focus_keyphrase'  => 'accessible beaches kent',
		),
		'direct-payment-holiday-accommodation'     => array(
			'meta_title'       => 'Direct Payment for Holiday | Funding | ' . $name,
			'meta_description' => 'Direct payment for holiday stays: what counts as care vs accommodation, personal budgets, short breaks, and questions for your social worker.',
			'focus_keyphrase'  => 'direct payment for holiday',
		),
		'revitalise-alternatives-accessible-holidays' => array(
			'meta_title'       => 'Revitalise Centres Closed | What Next | ' . $name,
			'meta_description' => 'Revitalise closed its holiday centres in 2024: why, what the charity funds now, and where to find accessible UK holidays and respite alternatives.',
			'focus_keyphrase'  => 'revitalise',
		),
		'how-to-choose-accessible-self-catering-holiday' => array(
			'meta_title'       => 'Accessible Self-Catering Holiday Guide | ' . $name,
			'meta_description' => 'Choose an accessible self-catering holiday: verify hoist specs, door widths, wet rooms, and red flags in listings before you pay a deposit.',
			'focus_keyphrase'  => 'accessible self-catering holiday',
		),
		'carers-respite-holiday-guide'             => array(
			'meta_title'       => 'Respite Holidays for Carers | Rights | ' . $name,
			'meta_description' => 'Respite holidays for unpaid carers: carer\'s assessment, Kent routes, direct payments, grants, and how to plan a break that actually restores you.',
			'focus_keyphrase'  => 'respite holidays',
		),
		'contact'               => array(
			'meta_title'       => 'Contact Restwell | Whitstable Team | ' . $name,
			'meta_description' => 'Contact Restwell by phone or email: bookings, access questions, or a pre-stay chat. We reply with honest, practical answers.',
			'focus_keyphrase'  => 'contact restwell',
		),
		'privacy-policy'        => array(
			'meta_title'       => 'Restwell Privacy | Policy & Data | ' . $name,
			'meta_description' => 'Restwell privacy policy: what we collect on forms and bookings, cookies, retention, your rights, and how to request changes or deletion.',
			'focus_keyphrase'  => 'restwell privacy',
		),
		'terms-and-conditions'  => array(
			'meta_title'       => 'Restwell Terms | Bookings & Payments | ' . $name,
			'meta_description' => 'Restwell terms for bookings: deposits, cancellations, guest responsibilities, accessibility reliance, and how disputes are handled.',
			'focus_keyphrase'  => 'restwell terms',
		),
	);
}

/**
 * SEO defaults for a page ID (by slug, with front page / posts page fallbacks).
 *
 * @param int $post_id Post ID.
 * @return array{meta_title: string, meta_description: string, focus_keyphrase: string}
 */
function restwell_get_seo_default_meta_for_post_id( $post_id ) {
	$post_id = absint( $post_id );
	$empty   = array(
		'meta_title'        => '',
		'meta_description'  => '',
		'focus_keyphrase'   => '',
	);
	if ( $post_id < 1 ) {
		return $empty;
	}

	$post = get_post( $post_id );
	if ( ! $post instanceof WP_Post ) {
		return $empty;
	}

	$map  = restwell_get_seo_meta_defaults_by_slug();
	$slug = $post->post_name;
	if ( isset( $map[ $slug ] ) ) {
		return $map[ $slug ];
	}

	$front = (int) get_option( 'page_on_front', 0 );
	if ( $front === $post_id && isset( $map['home'] ) ) {
		return $map['home'];
	}

	$posts_page = (int) get_option( 'page_for_posts', 0 );
	if ( $posts_page === $post_id && isset( $map['blog'] ) ) {
		return $map['blog'];
	}

	return $empty;
}

/**
 * Apply SEO meta to pages and seeded blog posts when keys are empty (idempotent).
 *
 * @param bool $force Overwrite existing meta_title, meta_description, and focus_keyphrase.
 */
function restwell_apply_seo_meta_to_pages( $force = false ) {
	$map = restwell_get_seo_meta_defaults_by_slug();

	$apply = static function ( $post_id, $seo ) use ( $force ) {
		if ( $force || get_post_meta( $post_id, 'meta_title', true ) === '' ) {
			update_post_meta( $post_id, 'meta_title', $seo['meta_title'] );
		}
		if ( $force || get_post_meta( $post_id, 'meta_description', true ) === '' ) {
			update_post_meta( $post_id, 'meta_description', $seo['meta_description'] );
		}
		if ( ! empty( $seo['focus_keyphrase'] ) && ( $force || get_post_meta( $post_id, 'focus_keyphrase', true ) === '' ) ) {
			update_post_meta( $post_id, 'focus_keyphrase', $seo['focus_keyphrase'] );
		}
	};

	$pages = get_pages( array( 'post_status' => 'publish', 'number' => 500 ) );
	foreach ( $pages as $page ) {
		$slug = $page->post_name;
		if ( ! isset( $map[ $slug ] ) ) {
			continue;
		}
		$apply( (int) $page->ID, $map[ $slug ] );
	}

	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 500,
			'fields'         => 'ids',
		)
	);
	foreach ( $posts as $post_id ) {
		$post = get_post( $post_id );
		if ( ! $post ) {
			continue;
		}
		$slug = $post->post_name;
		if ( ! isset( $map[ $slug ] ) ) {
			continue;
		}
		$apply( (int) $post_id, $map[ $slug ] );
	}
}

/**
 * HTML post_content for Who It's For page.
 *
 * @return string
 */
function restwell_get_who_its_for_page_html() {
	$enquire = esc_url( home_url( '/enquire/' ) );
	$acc     = esc_url( home_url( '/accessibility/' ) );
	$prop    = esc_url( home_url( '/the-property/' ) );
	$faq     = esc_url( home_url( '/faq/' ) );
	$res     = esc_url( home_url( '/resources/' ) );
	return '<h2>For guests and families</h2>
<p>This is a real holiday - a comfortable self-catering bungalow on the Kent coast, not a clinical placement. We have designed the space so you can focus on the break: the sea air, Whitstable, and time together.</p>
<p><a href="' . $prop . '">View the property</a> or <a href="' . $enquire . '">check availability and enquire</a>.</p>
<h2>For carers and support workers</h2>
<p>Bring your client or family member knowing the property has level access, a ceiling track hoist, profiling bed, and a full wet room. There is room for you to stay - tell us your party size when you book so we can confirm sleeping arrangements.</p>
<p>Read our <a href="' . $acc . '">accessibility specification</a> and <a href="' . $faq . '">funding and booking FAQs</a>.</p>
<h2>For occupational therapists and case managers</h2>
<p>We provide detailed accessibility information so you can assess suitability. If you need room dimensions, equipment specifications, or a site visit, <a href="' . $enquire . '">contact us</a> - we are used to working with professionals.</p>
<p><a href="' . $acc . '">See our equipment and access specification</a>.</p>
<h2>For commissioners and social care teams</h2>
<p>We welcome guests whose stays are funded through direct payments, personal budgets, or continuing healthcare (CHC) arrangements, subject to your local authority’s rules. We can provide documentation to support referrals.</p>
<p><a href="' . $res . '">Read about funding routes</a> and <a href="' . $faq . '">how funding works in our FAQ</a>.</p>
<h2>How funding works</h2>
<p>Eligibility depends on your package and local authority. Start with our <a href="' . $res . '">Funding &amp; support</a> page, then <a href="' . $enquire . '">get in touch</a> to discuss your situation.</p>';
}

/**
 * HTML post_content for Whitstable area guide page.
 *
 * @return string
 */
function restwell_get_whitstable_guide_page_html() {
	$prop = esc_url( home_url( '/the-property/' ) );
	$enq  = esc_url( home_url( '/enquire/' ) );
	return '<p>Restwell sits in a quiet residential street in Whitstable, about five minutes’ drive from the town centre and seafront. Below is a practical guide to the area - with accessibility notes where we can help.</p>
<h2>About Whitstable</h2>
<p>The harbour, independent shops, and seafood are the heart of the town. The beach is shingle; the Tankerton Slopes promenade offers a long, level walk with sea views - one of the more accessible coastal routes in Kent.</p>
<h2>Nearby towns</h2>
<p><strong>Canterbury</strong> (about eight miles) - cathedral, museums, and flat pedestrianised areas in the centre. <strong>Faversham</strong> and <strong>Herne Bay</strong> are short drives for market-town days out and traditional seafront.</p>
<h2>Getting here</h2>
<p>Whitstable station has trains to London St Pancras and Victoria. By car, use the M2 / Thanet Way. The property has off-street parking suitable for adapted vehicles.</p>
<p><a href="' . $prop . '">Back to the property</a> · <a href="' . $enq . '">Book your stay</a></p>';
}

/**
 * Seed priority blog posts. Pass $force = true to overwrite existing content.
 *
 * @param array $result Result array with optional key blog_posts_seeded.
 * @param bool  $force  Overwrite existing post content and meta.
 */
function restwell_seed_priority_blog_posts( array &$result, bool $force = false ) {
	if ( ! isset( $result['blog_posts_seeded'] ) ) {
		$result['blog_posts_seeded'] = array();
	}
	if ( ! isset( $result['blog_posts_failed'] ) ) {
		$result['blog_posts_failed'] = array();
	}

	$posts_page = (int) get_option( 'page_for_posts', 0 );
	if ( $posts_page < 1 ) {
		return;
	}

	$site_name = get_bloginfo( 'name' );
	$seo_map   = restwell_get_seo_meta_defaults_by_slug();

	$articles = array(
		array(
			'slug'             => 'accessible-beaches-coastal-walks-kent',
			'title'            => 'A guide to accessible beaches and coastal walks in Kent',
			'excerpt'          => 'Level promenades, shingle realities, and where to plan a seaside day if you use a wheelchair or mobility equipment - covering Whitstable, Herne Bay, Broadstairs, and Margate.',
			'meta_title'       => 'Accessible Beaches Kent | Coast Walks | ' . $site_name,
			'meta_description' => 'Accessible beaches Kent: level promenades, Beach Within Reach, Herne Bay, Viking Bay, Margate. Plan a seaside day with realistic access notes.',
			'content'          => restwell_get_blog_post_beaches_kent_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'direct-payment-holiday-accommodation',
			'title'            => 'How to use your direct payment for a holiday',
			'excerpt'          => 'Direct payments fund care, not accommodation - but that distinction matters. A plain-English guide to what direct payments can cover, how personal health budgets work, and what to discuss with your social worker before booking.',
			'meta_title'       => 'Direct Payment for Holiday | Funding | ' . $site_name,
			'meta_description' => 'Direct payment for holiday stays: what counts as care vs accommodation, personal budgets, short breaks, and questions for your social worker.',
			'content'          => restwell_get_blog_post_direct_payments_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'revitalise-alternatives-accessible-holidays',
			'title'            => 'What happened to Revitalise - and where to find accessible holidays now',
			'excerpt'          => "Revitalise closed its holiday centres in November 2024 after 60 years. Here's what happened, what Revitalise now offers, and where to find accessible holidays in the UK.",
			'meta_title'       => 'Revitalise Centres Closed | What Next | ' . $site_name,
			'meta_description' => 'Revitalise closed its holiday centres in 2024: why, what the charity funds now, and where to find accessible UK holidays and respite alternatives.',
			'content'          => restwell_get_blog_post_revitalise_html(),
			'category_slug'    => 'news-updates',
		),
		array(
			'slug'             => 'how-to-choose-accessible-self-catering-holiday',
			'title'            => 'How to choose an accessible self-catering holiday property',
			'excerpt'          => 'The word "accessible" on a property listing can mean almost anything. A practical checklist covering what to ask before booking - from door widths and hoist specifications to what red flags look like in listings.',
			'meta_title'       => 'Accessible Self-Catering Holiday Guide | ' . $site_name,
			'meta_description' => 'Choose an accessible self-catering holiday: verify hoist specs, door widths, wet rooms, and red flags in listings before you pay a deposit.',
			'content'          => restwell_get_blog_post_self_catering_checklist_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'carers-respite-holiday-guide',
			'title'            => "Carers taking holidays: respite rights, funding, and how to plan a break that works",
			'excerpt'          => "A practical guide for unpaid carers: what you're entitled to under the Care Act, how to get a carer's assessment in Kent, the funding routes available, and what makes a supported break actually restful.",
			'meta_title'       => 'Respite Holidays for Carers | Rights | ' . $site_name,
			'meta_description' => 'Respite holidays for unpaid carers: carer\'s assessment, Kent routes, direct payments, grants, and how to plan a break that actually restores you.',
			'content'          => restwell_get_blog_post_carers_respite_html(),
			'category_slug'    => 'funding-care',
		),
	);

	foreach ( $articles as $article ) {
		$existing_posts = get_posts(
			array(
				'name'           => $article['slug'],
				'post_type'      => 'post',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( ! empty( $existing_posts ) ) {
			if ( ! $force ) {
				continue;
			}
			// Force-update existing post content and meta.
			$post_id = (int) $existing_posts[0];
			$updated = wp_update_post(
				array(
					'ID'           => $post_id,
					'post_content' => wp_kses_post( $article['content'] ),
					'post_excerpt' => $article['excerpt'],
				),
				true
			);
			if ( is_wp_error( $updated ) ) {
				$result['blog_posts_failed'][] = $article['slug'];
				continue;
			}
			update_post_meta( $post_id, 'meta_title', $article['meta_title'] );
			update_post_meta( $post_id, 'meta_description', $article['meta_description'] );
			if ( ! empty( $seo_map[ $article['slug'] ]['focus_keyphrase'] ) ) {
				update_post_meta( $post_id, 'focus_keyphrase', $seo_map[ $article['slug'] ]['focus_keyphrase'] );
			}
			$result['blog_posts_seeded'][] = $article['title'] . ' (updated)';
			continue;
		}

		// Resolve or create the category term (slugs match inc/blog-categories.php).
		$cat_id = 0;
		$defs   = function_exists( 'restwell_get_blog_category_definitions' ) ? restwell_get_blog_category_definitions() : array();
		$slug   = isset( $article['category_slug'] ) ? sanitize_title( $article['category_slug'] ) : '';

		if ( $slug && isset( $defs[ $slug ] ) ) {
			$name = $defs[ $slug ]['name'];
			$term = term_exists( $slug, 'category' );
			if ( ! $term ) {
				$term = term_exists( $name, 'category' );
			}
			if ( ! $term ) {
				$term = wp_insert_term(
					$name,
					'category',
					array(
						'slug'        => $slug,
						'description' => $defs[ $slug ]['description'],
					)
				);
			}
		} elseif ( ! empty( $article['category'] ) ) {
			$name = (string) $article['category'];
			$term = term_exists( $name, 'category' );
			if ( ! $term ) {
				$term = wp_insert_term( $name, 'category' );
			}
		} else {
			$term = null;
		}

		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			$cat_id = is_array( $term ) ? (int) $term['term_id'] : (int) $term;
		}

		$insert_args = array(
			'post_title'    => $article['title'],
			'post_name'     => $article['slug'],
			'post_status'   => 'publish',
			'post_type'     => 'post',
			'post_content'  => wp_kses_post( $article['content'] ),
			'post_excerpt'  => $article['excerpt'],
			'post_author'   => get_current_user_id() ?: 1,
		);
		if ( $cat_id ) {
			$insert_args['post_category'] = array( $cat_id );
		}

		$post_id = wp_insert_post( $insert_args, true );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			$result['blog_posts_failed'][] = $article['slug'];
			continue;
		}
		update_post_meta( $post_id, 'meta_title', $article['meta_title'] );
		update_post_meta( $post_id, 'meta_description', $article['meta_description'] );
		if ( ! empty( $seo_map[ $article['slug'] ]['focus_keyphrase'] ) ) {
			update_post_meta( $post_id, 'focus_keyphrase', $seo_map[ $article['slug'] ]['focus_keyphrase'] );
		}
		$result['blog_posts_seeded'][] = $article['title'];
	}
}

/**
 * Seed HTML content for hub pages and blog archive excerpt (idempotent unless $force).
 *
 * @param array<string, int> $created_ids Page title => post ID.
 * @param bool               $force       Overwrite existing post_content / excerpt.
 * @param array              $result      Result array (hub_seeded key).
 */
function restwell_seed_hub_pages_content( array $created_ids, $force, array &$result ) {
	if ( ! isset( $result['hub_seeded'] ) ) {
		$result['hub_seeded'] = array();
	}

	$pages_cfg = array(
		'Who It\'s For'    => 'restwell_get_who_its_for_page_html',
		'Whitstable Guide' => 'restwell_get_whitstable_guide_page_html',
	);

	foreach ( $pages_cfg as $title => $callback ) {
		$page_id = isset( $created_ids[ $title ] ) ? (int) $created_ids[ $title ] : 0;
		if ( $page_id < 1 ) {
			$slug = ( 'Who It\'s For' === $title ) ? 'who-its-for' : 'whitstable-area-guide';
			$pg   = get_page_by_path( $slug, OBJECT, 'page' );
			$page_id = $pg ? (int) $pg->ID : 0;
		}
		if ( $page_id < 1 || ! is_callable( $callback ) ) {
			continue;
		}

		$existing = get_post_field( 'post_content', $page_id );
		if ( ! $force && ! empty( trim( (string) $existing ) ) ) {
			continue;
		}

		$html = call_user_func( $callback );
		wp_update_post(
			array(
				'ID'           => $page_id,
				'post_content' => wp_kses_post( $html ),
			)
		);
		$result['hub_seeded'][] = $title;
	}

	$blog_id = isset( $created_ids['Blog'] ) ? (int) $created_ids['Blog'] : 0;
	if ( $blog_id < 1 ) {
		$bp = get_page_by_path( 'blog', OBJECT, 'page' );
		$blog_id = $bp ? (int) $bp->ID : 0;
	}
	if ( $blog_id > 0 ) {
		$excerpt = (string) get_post_field( 'post_excerpt', $blog_id );
		if ( $force || $excerpt === '' ) {
			wp_update_post(
				array(
					'ID'           => $blog_id,
					'post_excerpt' => __( 'Guides and stories: accessible travel, the Kent coast, funding routes, and updates from Restwell Retreats.', 'restwell-retreats' ),
				)
			);
			$result['hub_seeded'][] = 'Blog';
		}
	}
}

/**
 * @return string
 */
function restwell_get_blog_post_beaches_kent_html() {
	$loc       = esc_url( home_url( '/whitstable-area-guide/' ) );
	$pr        = esc_url( home_url( '/the-property/' ) );
	$enq       = esc_url( home_url( '/enquire/' ) );
	$who       = esc_url( home_url( '/who-its-for/' ) );
	$checklist = esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) );
	$dp        = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );

	return "<p>Kent's coastline stretches for over 350 miles. Most of it is shingle. That matters if you use a wheelchair, powerchair, or walking frame, because shingle is difficult to navigate and varies from manageable to impassable depending on depth and compaction.</p>
<p>This guide focuses on surfaces and practical access - not just where the Blue Flags are.</p>

<h2>The promenade option</h2>
<p>The most accessible way to be by the sea on most of the Kent coast is to use the promenades rather than the beaches themselves. These are paved or tarmac paths that run at the top of the beach, level and generally in good repair. You can still see and hear the sea and, on many stretches, get to within a few metres of the waterline without touching shingle.</p>
<p>Dedicated beach wheelchairs - all-terrain chairs designed for shingle and sand - are available at a small number of locations and can open up the beach surface itself. More on that below.</p>

<h2>Whitstable and Tankerton</h2>
<p>Tankerton is the area immediately east of Whitstable town centre, and its promenade is one of the most consistently accessible seafront routes on the north Kent coast. The surface is smooth and level, suitable for powered and manual wheelchairs alike. It runs for several miles and connects back to Whitstable seafront.</p>
<p>Access from the road is off Marine Parade, where there is a mix of free and pay-and-display parking along the seafront. The transition from parking to promenade level involves a slope - some sections are steeper than others. The paved paths are easier than the grassy slopes between the road and the sea wall, so look for those rather than cutting across the grass.</p>
<p>At very low tide a shingle spit called The Street extends out from Tankerton beach. It attracts attention, but it is loose shingle and not accessible for wheelchair users.</p>
<p>Whitstable town centre and harbour are mostly level, though some older streets near the harbour have uneven or narrow sections. The harbour itself can be congested at weekends - weekday mornings are generally easier. Areas near the fish market can have rougher surfaces at the edges.</p>

<h2>Herne Bay</h2>
<p>About four miles east of Whitstable, Herne Bay is a traditional seaside town with one of the more practical seafronts for accessibility on this stretch of coast. The central promenade is wide, flat, and well-surfaced, running in both directions from the town centre.</p>
<p>Accessible parking and toilets are available on Central Parade. Seafront cafes are generally at promenade level. Herne Bay holds Blue Flag status for water quality. The beach is a mix of shingle and sand at lower tide - more navigable than pure shingle but still not easily crossed in a standard wheelchair without beach-specific equipment.</p>
<p>Herne Bay Pier has been partially rebuilt following earlier storm damage. Check current access conditions before planning a visit there specifically.</p>

<h2>Viking Bay, Broadstairs</h2>
<p>Viking Bay has one of the best beach accessibility setups on the Kent coast. A boardwalk more than two metres wide was installed to provide direct route to the beach surface, and a seasonal lift from the clifftop car park to beach level operates from April to September.</p>
<p>Accessible toilets are at Broadstairs Harbour and the Clock Tower. The bay is well-sheltered and has a sandy beach - a significant practical advantage over the shingle-heavy beaches further west along the coast.</p>
<p>Viking Bay is one of the Beach Within Reach locations (see below). The sandy surface combined with wheelchair lending makes it one of the most genuinely accessible beach experiences in Kent.</p>

<h2>Joss Bay and Botany Bay</h2>
<p>Both are near Broadstairs and hold Blue Flag and Seaside Award status. Joss Bay has accessible routes to the beach, accessible toilets, seasonal lifeguards (May to September), and a café. An access statement is available - worth requesting before your visit to confirm what is currently in place.</p>
<p>Botany Bay is more remote, with limited parking and no coach access. It is best reached on foot or by bike from Broadstairs, which limits its practicality for most wheelchair users. If distance from parking is a problem, focus on Viking Bay or Joss Bay instead.</p>

<h2>Margate Main Sands</h2>
<p>Margate's main beach is sandy rather than shingle - a difference that immediately makes it more manageable on wheels. Blue Badge parking is available at Dreamland car park, with level seafront access via dropped kerbs and tactile paving.</p>
<p>Beach Within Reach wheelchairs are available at Margate from the Bay Inspectors office - contact 07432 648279 to confirm availability before your visit. A boardwalk improvement funded by Thanet District Council is planned for 2026-27, which should extend accessible beach-level access further.</p>

<h2>Beach Within Reach</h2>
<p>Beach Within Reach is a scheme operating at several locations on the Thanet coast that provides free all-terrain beach wheelchairs. These are purpose-designed to be pushed across sand and shingle by a companion, allowing wheelchair users access to the beach surface rather than being limited to promenades.</p>
<p>Current locations include Viking Bay, Broadstairs, and Margate Main Sands. No prior booking is usually required, but availability can vary on busy days. If you are planning a specific visit, contact ahead to confirm.</p>

<h2>Coastal walking between towns</h2>
<p>The Viking Coastal Trail covers about 32 miles around Thanet. Sections near Margate and Broadstairs run on good, level surfaces and are suitable for many wheelchair users. Some inland stretches are less consistent - check specific sections before planning a longer route.</p>
<p>Tankerton to Herne Bay is roughly four miles along mostly level promenade. The surface changes character at various points, so checking conditions in advance is sensible if you plan to do the full stretch. This route is popular with Restwell guests staying in Whitstable.</p>

<h2>Practical notes</h2>
<h3>Accessible toilets</h3>
<p>Accessible public toilets are not consistently available at every beach. Check visitkent.co.uk or contact each location in advance. The situation changes seasonally and some facilities close outside peak months.</p>
<h3>Seasonal access services</h3>
<p>Beach wheelchairs, lifeguards, and certain access facilities generally run from May to September. Visiting outside that window means reduced support at most locations.</p>
<h3>Parking</h3>
<p>Seafront car parks fill quickly on warm weekends and bank holidays. Blue Badge holders can use on-street bays free of charge with no time limit under current rules, but bay availability varies. Arriving early or planning a mid-week visit makes parking more predictable.</p>

<h2>If you are staying in Whitstable</h2>
<p>Whitstable puts you within easy reach of the Tankerton promenade, and about fifteen minutes' drive from Herne Bay's seafront. Broadstairs and Margate are roughly 30 to 40 minutes by car - practical for day trips but worth planning rather than treating as spontaneous.</p>
<p>Our <a href=\"{$loc}\">Whitstable and Kent coast area guide</a> has more detail on what is accessible locally. If you are considering a stay, <a href=\"{$who}\">read who Restwell is for</a> or <a href=\"{$enq}\">enquire directly about dates and suitability</a>.</p>
<p>If you are planning where to stay, our <a href=\"{$checklist}\">guide to choosing an accessible self-catering property</a> covers what to check before you book. If you are funding a PA to support you during the trip, see our <a href=\"{$dp}\">direct payments guide</a> for how care costs work on holiday.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_direct_payments_html() {
	$res     = esc_url( home_url( '/resources/' ) );
	$faq     = esc_url( home_url( '/faq/' ) );
	$enq     = esc_url( home_url( '/enquire/' ) );
	$carers  = esc_url( home_url( '/carers-respite-holiday-guide/' ) );
	$who = esc_url( home_url( '/who-its-for/' ) );
	$acc = esc_url( home_url( '/accessibility/' ) );

	return "<p>Direct payments are one of the most useful tools available to people with disabilities managing their own care - but they are also one of the most misunderstood when it comes to holidays. The question of whether you can use a direct payment to fund a holiday stay comes up constantly. The honest answer is: it depends, and the details matter.</p>
<p>This article explains how direct payments work in practice, what they can and cannot cover, and what to discuss with your social worker or care coordinator if you are thinking about using care funding towards a break.</p>

<h2>What direct payments are</h2>
<p>A direct payment is money from your local authority paid directly to you so that you can arrange your own care and support, instead of the council arranging services on your behalf. In Kent, this typically comes via the Kent Card - a dedicated account used only for care spending.</p>
<p>To receive direct payments, you need a formal care and support needs assessment. The council calculates your eligible needs, works out a personal budget, and assesses what you need to contribute. The direct payment covers the remaining care cost.</p>
<p>Crucially, direct payments must be spent on what is agreed in your care and support plan. You need to keep records and account for how the money is used. Spending it on something outside your plan is not permitted.</p>

<h2>What direct payments can fund - and what they cannot</h2>
<p>Direct payments can be used to employ a personal assistant, pay a care agency, cover support during activities, and in some cases fund short break placements. What they generally <strong>cannot</strong> be used for is the cost of accommodation itself - the holiday cottage, hotel room, or residential placement fee as a property cost.</p>
<p>This is the distinction that catches people out. The direct payment funds the <em>care</em>, not the venue where care is delivered.</p>
<p>What this means in practice:</p>
<ul>
<li><strong>You can use direct payments to pay your personal assistant to accompany you on holiday.</strong> If your care plan includes PA support, that support travels with you. Your PA's wages, travel costs, and any agreed expenses during the holiday can come from your direct payment.</li>
<li><strong>You can use direct payments to pay a care agency to provide support during your stay</strong>, if that agency is approved under your plan.</li>
<li><strong>The accommodation itself</strong> - the self-catering property, cottage, or adapted room - is usually a separate cost that you fund privately or through a different funding route.</li>
</ul>
<p>Some local authorities do fund short break placements that include accommodation as part of the arrangement. This is a separate provision from the standard direct payment, and whether it applies to your situation depends on your individual assessment and local authority policy. It is worth asking specifically about short break provisions, not just direct payments.</p>

<h2>Short breaks: a separate pathway</h2>
<p>Under the Care Act 2014, local authorities have a duty to support carers and people with disabilities, including through short breaks. In Kent, this sits within adult social care and is arranged through your care manager or community support team.</p>
<p>Short break support is different from your ongoing direct payment. Some people receive a dedicated short breaks budget annually; others negotiate care support during an independently booked stay as part of their existing care plan. What is available depends on your assessed needs and local provision - it is not automatic.</p>
<p>If you are interested in using care funding towards a break, the specific question to raise with your social worker is: <em>&ldquo;Can short breaks or respite-style stays be included in my support plan, and what would the council need to approve that?&rdquo;</em></p>
<p>The answer will depend on your situation, but asking the right question gets you much further than asking the wrong one.</p>

<h2>NHS Continuing Healthcare and personal health budgets</h2>
<p>If you receive NHS Continuing Healthcare (CHC), you have a legal right to a personal health budget. This is an amount of NHS money allocated to support your health needs, and it can be used to cover the care element of a stay away from home - including a holiday.</p>
<p>The accommodation cost still needs to be covered separately, but your personal health budget can fund the nursing or personal care support you need during a trip. People with CHC who take their personal health budget as a direct payment have the most flexibility over where and how that care is delivered.</p>
<p>If you are on a CHC package and have not explored personal health budgets, your CHC coordinator or ICB is the right starting point. Our <a href=\"{$res}\">funding and support page</a> covers this in more detail alongside other pathways.</p>

<h2>What to bring to the conversation</h2>
<p>If you want to use any form of care funding towards a holiday stay, preparation helps. Before approaching your social worker or commissioner:</p>
<ul>
<li>Know what you need: access requirements, dates, who is travelling, whether you need support in the property or just during activities.</li>
<li>Have details of the property you are considering - access statement, equipment list, room dimensions. Commissioners and social workers often need this to approve a funded placement or support plan inclusion.</li>
<li>Be clear about what you are asking them to fund - the care support during the stay, not the accommodation itself.</li>
<li>Ask about short break provisions in your area specifically, not just your standard direct payment.</li>
</ul>
<p>Restwell can provide a full property specification, access statement, and supporting documentation to help with funding conversations. If you are at this stage, <a href=\"{$enq}\">get in touch</a> and we will provide what you need.</p>

<h2>How to find out what applies to your situation</h2>
<p>In practice, the majority of Restwell guests who use care funding self-fund the accommodation and use direct payments or their personal health budget to cover their personal assistant or carer's time during the stay. The property cost and the care cost are treated separately, which keeps both simpler.</p>
<p>If cost is a barrier to the accommodation itself, it is worth checking whether you might be eligible for a Revitalise Support Fund grant - the Revitalise charity now operates as a grants provider for people with disabilities and carers who cannot afford a break. Applications are open year-round at revitalise.org.uk.</p>
<p>For more on funding routes, see our <a href=\"{$res}\">funding and support hub</a> and the <a href=\"{$faq}\">FAQ section on funded stays</a>. When you have a clearer picture, <a href=\"{$who}\">check who Restwell is for</a> and <a href=\"{$enq}\">get in touch to discuss your situation</a>.</p>
<p>If you are an unpaid carer looking at taking a break, our <a href=\"{$carers}\">carers' respite holiday guide</a> covers your legal rights to a carer's assessment and what support KCC may provide.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_revitalise_html() {
	$who       = esc_url( home_url( '/who-its-for/' ) );
	$enq       = esc_url( home_url( '/enquire/' ) );
	$acc       = esc_url( home_url( '/accessibility/' ) );
	$res       = esc_url( home_url( '/resources/' ) );
	$dp        = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$checklist = esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) );

	return "<p>For over sixty years, Revitalise ran the only holiday centres in the UK specifically designed for people with severe disabilities who needed 24-hour care support during their break. These were not just adapted hotels - they were fully staffed residential facilities with nursing care, on-site entertainment, and everything included, so guests could have a proper holiday without needing to organise or bring their own care.</p>
<p>In October 2024, Revitalise announced it could no longer afford to keep the centres open. The doors closed in November that year. This article explains what happened, what Revitalise now offers, and where people are finding accessible holidays in the UK in 2025.</p>

<h2>What Revitalise was</h2>
<p>The charity started in the 1960s as the Winged Fellowship Trust, founded specifically to provide holidays for people with disabilities at a time when that was almost entirely unavailable. Over sixty years it became the primary provider of care-inclusive residential holidays in the UK, operating purpose-built accessible centres - the most recent being Jubilee Lodge in Southport, Merseyside, and a second centre in Essex.</p>
<p>At its peak it served around 4,000 people a year. The model was comprehensive: adapted rooms, ceiling hoists, profiling beds, specialist care staff available around the clock, meals, activities, and transport assistance. Guests paid for their stay; many had all or part of the cost funded through local authority direct payments or NHS Continuing Healthcare routes.</p>
<p>It filled a gap that almost nothing else did. Many of the people who used it could not use standard self-catering accommodation because they needed continuous medical and personal care support that they could not organise independently.</p>

<h2>Why it closed</h2>
<p>Revitalise cited a combination of factors as financially insurmountable:</p>
<ul>
<li>Local authority funding cuts reduced the number of publicly funded placements, leaving the centres dependent on private-paying guests who could not fully cover the cost of operations.</li>
<li>Agency staff costs rose sharply. At the point of closure, a weekly stay was costing as much as £3,000 per person to deliver - driven largely by agency staffing rates in the post-pandemic care sector.</li>
<li>Falling charitable donations and the cost-of-living crisis reduced income across the board.</li>
<li>Chronic staffing shortages in the care sector made recruiting and retaining qualified permanent staff increasingly difficult.</li>
</ul>
<p>Those who work in social care described the closure as a bellwether moment - a visible symptom of pressures that have been building across the sector for years.</p>

<h2>What Revitalise does now</h2>
<p>Revitalise did not disappear. The charity transformed its model rather than closing entirely. It now operates as a grants provider through the Revitalise Support Fund, offering financial support to adults with disabilities and family carers who cannot afford a break independently.</p>
<p>Grants can be used to fund holidays and life experiences - including adapted self-catering accommodation, supported group holidays, or other forms of break. Applications are open year-round, and since launching the Support Fund, Revitalise has distributed over £125,000 to support people who could not otherwise access a break.</p>
<p>If cost is the barrier to a holiday, this is worth applying for. Visit <a href=\"https://revitalise.org.uk\" target=\"_blank\" rel=\"noopener noreferrer\">revitalise.org.uk</a> to check eligibility and apply.</p>

<h3>A note on Netley Waterside House</h3>
<p>Netley Waterside House in Hampshire was originally a Revitalise-operated centre. It continues to operate and appears in NHS directories under the name Vitalise. Revitalise and Vitalise are two distinct organisations with overlapping histories - the naming is genuinely confusing. If Netley Waterside House is relevant to your situation, contact them directly to confirm current services, availability, and how referrals work. Do not assume the details below apply equally to both organisations.</p>

<h2>What to look for instead: the self-catering option</h2>
<p>Revitalise was a staffed residential model: care, meals, and activities all on site. The alternative most people are navigating now is self-catering - adapted properties where you bring your own support and manage your own stay.</p>
<p>This is a very different proposition. It offers more independence and flexibility, but it requires you to have care in place before you arrive. For people who relied on Revitalise precisely because they did not have that independently, self-catering is not a direct substitute.</p>
<p>If you do have care in place - a personal assistant, a family member who supports you, or a care agency that can travel with you - self-catering can work well. But the quality of \"accessible\" self-catering varies enormously. A property that describes itself as accessible might mean a grab rail by the toilet. Or it might mean a full wet room, ceiling track hoist, profiling bed, and wide doorways throughout. You need to know which one you are looking at before you book.</p>
<p><strong>What to check before booking any adapted self-catering property:</strong> (see our full <a href=\"{$checklist}\">guide to choosing an accessible self-catering holiday</a> for detailed questions to ask)</p>
<ul>
<li>Does the listing name specific equipment, or just use the word \"accessible\" without detail?</li>
<li>Can you speak to the owner directly about your specific access needs?</li>
<li>Is there a detailed access statement with measurements - not just a photo of a ramp?</li>
<li>Is there space for a carer or support worker to stay alongside the main guest?</li>
<li>Is the property experienced with funded stays (direct payments, CHC, personal budgets)?</li>
</ul>

<h2>If you need a care-supported group holiday</h2>
<p>For people who need structured care support during a holiday rather than self-catering, options are limited but they do exist.</p>
<p><a href=\"https://www.limitlesstravel.org\" target=\"_blank\" rel=\"noopener noreferrer\">Limitless Travel</a> runs escorted coach holidays with on-trip care staff included - probably the closest remaining equivalent to the Revitalise model for people who want professional care support on a group holiday. They cater for a range of access and care needs, and the trips are fully organised.</p>
<p><a href=\"https://calvertlakes.org.uk\" target=\"_blank\" rel=\"noopener noreferrer\">Calvert Lakes</a> in the Lake District offers activity breaks for people with disabilities, with bursary funding available (up to 25% of booking costs, allocated case by case). More suited to people who want an outdoor activity focus than a seaside or cultural break.</p>
<p>For broader directories of accessible holidays and accommodation in the UK:</p>
<ul>
<li><a href=\"https://www.disabledholidays.com\" target=\"_blank\" rel=\"noopener noreferrer\">DisabledHolidays.com</a> - UK-wide listings filtered by specific access features</li>
<li><a href=\"https://www.tourismforall.org.uk\" target=\"_blank\" rel=\"noopener noreferrer\">Tourism for All</a> - national charity with an accessible tourism information service</li>
<li><a href=\"https://www.accessable.co.uk\" target=\"_blank\" rel=\"noopener noreferrer\">AccessAble</a> - detailed access guides for venues, accommodation, and attractions</li>
</ul>

<h2>Restwell as one option</h2>
<p>We run an adapted holiday home in Whitstable on the Kent coast. It is not a replacement for Revitalise - we do not provide on-site care, nursing, or staffing. Guests bring their own support. What we offer is a private, accessible property where the physical environment has been built around the needs that actually matter: ceiling track hoist, profiling bed, roll-in wet room, wide doorways throughout, and level access from the car park.</p>
<p>We publish a detailed access specification so you can assess suitability before you contact us. We welcome funded stays through direct payments, personal health budgets, and CHC pathways. Our <a href=\"{$res}\">funding and support page</a> has detail on how each route works, and our <a href=\"{$dp}\">direct payments guide</a> explains what care funding can and cannot cover.</p>
<p>If you want to know whether the property could work for your situation, the straightforward route is to <a href=\"{$who}\">read who Restwell is for</a>, review <a href=\"{$acc}\">the accessibility specification</a>, and <a href=\"{$enq}\">enquire when you are ready</a>.</p>
<p>We would rather you found the right place for your needs - even if that is not us - than booked somewhere that does not work when you arrive.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_self_catering_checklist_html() {
	$acc    = esc_url( home_url( '/accessibility/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );
	$who    = esc_url( home_url( '/who-its-for/' ) );
	$dp     = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$rev    = esc_url( home_url( '/revitalise-alternatives-accessible-holidays/' ) );

	return "<p>The word \"accessible\" on a holiday property listing can mean almost anything. A grab rail by the bath. A ground-floor bedroom. A ramp at the front door. Or it can mean ceiling track hoist, profiling bed, roll-in wet room, and step-free access throughout. All of those listings use the same word.</p>
<p>This guide is for anyone who needs genuine access information before booking a self-catering holiday - not reassuring descriptions, but specific details you can actually use to make a decision.</p>

<h2>Why listings are unreliable</h2>
<p>Most self-catering platforms rely on owners to self-describe their properties. There is no universal standard for what \"accessible\" or \"wheelchair friendly\" means, and there is no verification. Owners generally describe their properties accurately as they understand them - but understanding access needs requires knowledge that most general lettings owners do not have.</p>
<p>The result is that the word \"accessible\" in a listing is not useful information on its own. You need the underlying details.</p>

<h2>What to ask before you book</h2>
<p>Before committing to any adapted property, get answers to these specific questions:</p>

<h3>Arrival and outdoor access</h3>
<ul>
<li>Is there step-free access from the car to the front door? (Not \"ramped access\" - is the route completely level, or does it include slopes that would be difficult for a powerchair?)</li>
<li>What is the parking arrangement? Is there space for a vehicle with a rear or side ramp?</li>
<li>Is the parking surface level and firm?</li>
<li>What is the width of the front door - the actual measurement, not an estimate?</li>
</ul>

<h3>Internal layout</h3>
<ul>
<li>What are the door widths throughout the property? 750mm is often stated as a minimum for manual wheelchairs; 850mm or more is better for powerchairs and lateral transfers.</li>
<li>Is there step-free access between all rooms on a single level, including the bedroom, bathroom, and kitchen?</li>
<li>Is there a turning circle in the main bedroom - ideally 1500mm clear of obstructions?</li>
<li>Are there any internal thresholds or lips between rooms?</li>
</ul>

<h3>Bathroom</h3>
<p>The bathroom is the most important room in an adapted property. Generic descriptions are rarely sufficient. Ask:</p>
<ul>
<li>Is it a roll-in (wheel-in) shower, or does it have a step or ridge? What is the shower entry width?</li>
<li>Are there grab rails at the toilet and in the shower - on both sides, or only one?</li>
<li>Is there a fold-down shower seat, or a fixed seat?</li>
<li>Is there a ceiling or floor-based hoist, and if so, what is the safe working load?</li>
<li>Can the hoist reach from the shower to the toilet and the bed?</li>
<li>What is the floor surface - wet room drainage, or a wet room with a slight camber?</li>
</ul>

<h3>Bedroom</h3>
<ul>
<li>What is the bed height? Transfer height is typically 45-55cm from the floor.</li>
<li>Is the bed a standard fixed frame, or an adjustable profiling bed?</li>
<li>Is there a hoist available, and does its track or range cover the bed?</li>
<li>Is there space on both sides of the bed for transfers and for a carer to work?</li>
<li>Is there storage for medical equipment, mobility aids, or a ventilator if needed?</li>
</ul>

<h3>Kitchen and living spaces</h3>
<ul>
<li>Are kitchen worktops at a usable height from a seated position, or is the kitchen designed only for standing use?</li>
<li>Is the main living area on the same level as the bedroom and bathroom?</li>
<li>Are light switches, sockets, and thermostats at a reachable height from a wheelchair?</li>
</ul>

<h3>Sleeping for carers</h3>
<ul>
<li>Is there a separate bedroom for a carer or support worker?</li>
<li>If not, what are the sleeping arrangements for support staff?</li>
</ul>

<h2>Red flags in listings</h2>
<p>These phrases should prompt follow-up questions rather than reassurance:</p>
<ul>
<li><strong>\"Accessible bathroom\"</strong> - what specifically does this mean?</li>
<li><strong>\"Ramped access\"</strong> - what is the gradient, and where does it lead?</li>
<li><strong>\"Ground-floor bedroom\"</strong> - is the bathroom also accessible from that level?</li>
<li><strong>\"Suitable for wheelchair users\"</strong> - based on whose assessment?</li>
<li><strong>\"Please ask for details\"</strong> without any detail already visible - if they cannot describe access features upfront, they may not know what to describe.</li>
</ul>

<h2>What good looks like</h2>
<p>A property that takes accessibility seriously will typically publish a detailed access statement - a document that lists dimensions, equipment specifications, and describes the property layout from an access perspective. This is not the same as a sentence in the listing saying \"we're fully accessible\" with no detail behind it.</p>
<p>Good access information includes door widths (in millimetres), shower entry dimensions, toilet transfer space, bed height, hoist specification and safe working load, and notes on surface types and any thresholds. If you are looking at properties and one provides this and others do not, that difference tells you something useful before you have even visited.</p>

<h2>Documentation to request</h2>
<p>Before booking, ask the owner for:</p>
<ul>
<li>A written access statement or access guide</li>
<li>Floor plan or room layout showing circulation space</li>
<li>Photos of the shower, toilet, and bedroom - taken honestly, not for marketing</li>
<li>Equipment specifications (hoist model and SWL if applicable, profiling bed model)</li>
</ul>
<p>If the property is being considered for a funded stay, your social worker, OT, or commissioner may also need this documentation. A property that cannot provide it is unlikely to support the funding paperwork process.</p>

<h2>Restwell's approach</h2>
<p>We publish a detailed access specification for Restwell - door widths, hoist specification, shower dimensions, and equipment details - so that guests, carers, occupational therapists, and commissioners can assess suitability without relying on descriptions. You can <a href=\"{$acc}\">read the accessibility features page</a> and <a href=\"{$enq}\">ask us any specific questions</a> before you commit to anything.</p>
<p>If the property does not suit your needs, we will tell you. We would rather give you a straight answer than have you arrive somewhere that does not work. <a href=\"{$who}\">Read who Restwell is for</a> to understand whether we are likely to be a fit before you get in touch.</p>
<p>If you are planning to use a direct payment or personal health budget to cover care support during your stay, see our <a href=\"{$dp}\">guide to using a direct payment for a holiday</a>. If you are researching alternatives following the closure of Revitalise, our <a href=\"{$rev}\">guide to accessible holiday alternatives</a> covers the current options.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_carers_respite_html() {
	$res       = esc_url( home_url( '/resources/' ) );
	$enq       = esc_url( home_url( '/enquire/' ) );
	$who       = esc_url( home_url( '/who-its-for/' ) );
	$dp        = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$checklist = esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) );

	return "<p>Caring for someone full-time is relentless. Respite - time away from caring responsibilities - is not a luxury. Research is clear that carers who do not get regular breaks are at higher risk of burnout, physical ill-health, and being unable to continue in their caring role.</p>
<p>Despite this, many carers do not know what they are entitled to, how to access it, or how to fund it. This guide covers the practical side: what respite is, what the law says, how to access a carer's assessment in Kent, and how to fund a break - including breaks where you travel with the person you support.</p>

<h2>What respite means in practice</h2>
<p>\"Respite\" covers a range of different things depending on who you ask. Broadly, it means any arrangement that gives a carer a break from their caring role. That can include:</p>
<ul>
<li>Day care or sitting services where someone else provides support at home while you have time off</li>
<li>A residential placement for the person you support while you take a holiday independently</li>
<li>A supported holiday where you go away together but a care worker provides the hands-on support during the trip</li>
<li>A short break where both of you travel and you manage the care yourself, using a direct payment to cover the cost of support</li>
</ul>
<p>The right type of respite depends on the needs of the person you care for, your own circumstances, and what you actually need from a break.</p>

<h2>Your legal rights as a carer</h2>
<p>The Care Act 2014 gives unpaid carers the right to a carer's assessment from their local authority. This assessment looks at your needs as a carer - your wellbeing, your ability to continue caring, and what support would help. You do not need to wait until you are at crisis point to request one.</p>
<p>Following an assessment, the council may offer a carer's personal budget - money allocated to support your wellbeing as a carer. This can be used towards breaks, activities, or other support identified in your assessment. What is available and how it is allocated varies between local authorities. In Kent, carer support sits within KCC Adult Social Care.</p>
<p>The Children and Families Act 2014 extended similar rights to parent carers of children with disabilities. If you care for a child with a disability, you have the right to a parent carer's needs assessment.</p>

<h2>How to get a carer's assessment in Kent</h2>
<p>Contact Kent County Council's adult social care team and request a carer's needs assessment. You can do this online via the KCC website or by calling their social care referral line. You do not need a referral from a GP or other professional.</p>
<p>The assessment will look at your situation, what support you currently provide, how caring is affecting your life, and what help would make a difference. Be honest about the impact - the assessment is supposed to reflect reality, not a best-case picture.</p>
<p>If the person you care for already has a care plan, it is worth also asking whether their plan includes provisions for short breaks - separate to your own carer's assessment. The two assessments are distinct but complementary.</p>

<h2>Taking a break together</h2>
<p>Many carers find that the most practical form of respite is a break where they travel with the person they support - but where the environment makes caring easier, or where a PA covers the hands-on care so the carer can have downtime.</p>
<p>For this to work well, you need an adapted property that is genuinely equipped for the access needs of the person you care for. \"Accessible\" is not sufficient - you need to know about transfer space, hoist availability, shower layout, and sleeping arrangements for you as the carer. See our guide to <a href=\"{$checklist}\">choosing an accessible self-catering property</a> for what to check before booking.</p>
<p>Using a direct payment to fund the PA element during a holiday is possible in many cases - your direct payment can cover your PA's wages and costs while you are away. The accommodation is a separate cost. Our <a href=\"{$dp}\">direct payments guide</a> explains how this works in detail.</p>

<h2>Funding a carers' break</h2>
<p>There are several routes to funding, and in many cases more than one applies:</p>
<h3>Carer's personal budget</h3>
<p>Following a carer's assessment, KCC may allocate a budget for your wellbeing. This can in some cases be used towards a short break. Ask your assessor specifically what it can fund.</p>
<h3>Direct payments for the person you care for</h3>
<p>If the person you support receives direct payments, those payments can cover PA or care agency support during a holiday. This does not cover accommodation, but it can make a trip financially feasible.</p>
<h3>Revitalise Support Fund grants</h3>
<p>Revitalise now operates as a grants programme for people with disabilities and carers who cannot afford a break. Applications are open year-round at revitalise.org.uk. If cost is the primary barrier, this is worth applying for.</p>
<h3>Carer charities</h3>
<p>Organisations including Carers UK, the Carers Trust, and local carer support services sometimes have small grants or emergency funds. Contact your local carer support service - in Kent this is run through KCC and several local organisations.</p>
<h3>Private funding</h3>
<p>Many families self-fund the accommodation and use care budgets only for the support element. This is often the simplest route if the finances allow it.</p>

<h2>What makes a break actually restful</h2>
<p>A few things that carers consistently mention when reflecting on what made a break work or not work:</p>
<ul>
<li><strong>The environment has to be right.</strong> If the property is not genuinely accessible, you spend the holiday problem-solving rather than relaxing. Do the suitability check before you book, not after you arrive.</li>
<li><strong>Having consistent support in place matters.</strong> If you are relying on a PA to provide care during the trip, they need to be familiar with the person they are supporting before you travel. Taking a break with someone new is often more stressful than staying home.</li>
<li><strong>Keep the routine where it helps.</strong> Some people travel best when meals, sleep, and personal care are at roughly the same times as at home. A self-catering property that gives you control over timing is often better than a hotel for this reason.</li>
<li><strong>Plan for the return.</strong> The hardest part of many carers' breaks is the days immediately after - exhaustion from travel, catching up on care, the emotional let-down. Build in a buffer if you can.</li>
</ul>

<h2>If you are thinking about Restwell</h2>
<p>Restwell is an adapted self-catering property in Whitstable, Kent. It is designed for guests with disabilities, their families, and carers - with a layout and equipment specification built around what actually matters for a supported stay rather than what looks good in a listing.</p>
<p>The property has a separate sleeping area for carers, ceiling track hoist, profiling bed, and wet room. We welcome funded stays and can provide documentation to support care plan discussions. We have worked with guests whose stays have been funded through direct payments, CHC routes, and personal budgets alongside self-funded bookings.</p>
<p>For more on how funded stays work, visit our <a href=\"{$res}\">funding and support hub</a>. To understand whether the property suits your specific situation, <a href=\"{$who}\">read who Restwell is for</a> or <a href=\"{$enq}\">send us a question before you commit to anything</a>.</p>";
}
