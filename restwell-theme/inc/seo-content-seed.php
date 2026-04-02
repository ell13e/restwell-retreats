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
 * Default meta_title / meta_description by page slug (path without slashes).
 *
 * @return array<string, array{meta_title:string, meta_description:string}>
 */
function restwell_get_seo_meta_defaults_by_slug() {
	$name = get_bloginfo( 'name' );
	// Wording aligned with restwell-seo-sections2-4.md (on-page SEO) and section 1 (keyword clusters).
	return array(
		'how-it-works'          => array(
			'meta_title'       => 'How It Works — Book Your Accessible Stay | ' . $name,
			'meta_description' => 'From first enquiry to arrival: how to book, what\'s included, rates and availability, and optional care through Continuity of Care Services.',
		),
		'home'                  => array(
			'meta_title'       => 'Accessible Holiday Cottage in Whitstable, Kent | ' . $name,
			'meta_description' => 'A fully adapted holiday bungalow on the Kent coast. Wheelchair accessible, with ceiling hoist and profiling bed. A real seaside holiday — book direct.',
		),
		'the-property'          => array(
			'meta_title'       => 'The Property — Adapted Bungalow in Whitstable | ' . $name,
			'meta_description' => 'Adapted holiday bungalow at 101 Russell Drive, Whitstable. Ceiling track hoist, profiling bed, roll-in shower, wide doorways. Book direct.',
		),
		'accessibility'         => array(
			'meta_title'       => 'Accessibility Features — Hoist, Profiling Bed & More | ' . $name,
			'meta_description' => 'Wheelchair accessible holiday cottage in Kent: ceiling track hoist, profiling bed, 926mm doorways, roll-in shower, step-free throughout. Download our access statement.',
		),
		'who-its-for'           => array(
			'meta_title'       => 'Who It\'s For — Families, Carers, OTs & Commissioners | ' . $name,
			'meta_description' => 'Respite breaks, family holidays, and professional referrals in Kent. How Restwell works for guests, carers, OTs, case managers, and commissioners.',
		),
		'whitstable-area-guide' => array(
			'meta_title'       => 'Whitstable & Kent Coast Area Guide | ' . $name,
			'meta_description' => 'Accessible things to do near Whitstable: Canterbury, Faversham, Herne Bay, Tankerton. Where to eat, days out, and how to get here — with accessibility notes.',
		),
		'enquire'               => array(
			'meta_title'       => 'Book Your Stay — Rates & Availability | ' . $name,
			'meta_description' => 'Book direct for the best rate. Flexible check-in/out for accessibility needs. Direct payments and funded stays welcome. Enquire today.',
		),
		'faq'                   => array(
			'meta_title'       => 'Frequently Asked Questions | ' . $name,
			'meta_description' => 'Common questions about staying at Restwell Retreats — accessibility equipment, bringing carers, dogs, funding your stay, and what to expect.',
		),
		'resources'             => array(
			'meta_title'       => 'Funding & Support — Direct Payments, CHC & Grants | ' . $name,
			'meta_description' => 'How to fund an accessible break in Kent: direct payments, personal budgets, NHS CHC, local authority routes, and grants — plus what to ask your social worker.',
		),
		'blog'                  => array(
			'meta_title'       => 'Blog — Accessible Travel, Kent Coast & More | ' . $name,
			'meta_description' => 'Guides, tips, and stories about accessible holidays on the Kent coast. From travel planning to local recommendations.',
		),
		'guest-guide'           => array(
			'meta_title'       => 'Guest Guide — Arrival, House Rules & Local Tips | ' . $name,
			'meta_description' => 'Practical information for your stay: check-in and check-out, house rules, and local tips for Whitstable and the Kent coast.',
		),
		'contact'               => array(
			'meta_title'       => 'Contact Us | ' . $name . ' — Whitstable, Kent',
			'meta_description' => 'Get in touch to book, ask a question, or arrange a visit. We are happy to talk through your accessibility needs before you book.',
		),
		'privacy-policy'        => array(
			'meta_title'       => 'Privacy Policy | ' . $name,
			'meta_description' => 'How Restwell Retreats collects, uses, and protects your personal information when you use our website or book a stay.',
		),
		'terms-and-conditions'  => array(
			'meta_title'       => 'Terms & Conditions | ' . $name,
			'meta_description' => 'Terms of use for Restwell Retreats: bookings, payments, cancellations, and your responsibilities as a guest.',
		),
	);
}

/**
 * SEO defaults for a page ID (by slug, with front page / posts page fallbacks).
 *
 * @param int $post_id Post ID.
 * @return array{meta_title: string, meta_description: string}
 */
function restwell_get_seo_default_meta_for_post_id( $post_id ) {
	$post_id = absint( $post_id );
	$empty   = array(
		'meta_title'       => '',
		'meta_description' => '',
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
 * Apply SEO meta to pages when keys are empty (idempotent).
 *
 * @param bool $force Overwrite existing meta_title / meta_description.
 */
function restwell_apply_seo_meta_to_pages( $force = false ) {
	$map   = restwell_get_seo_meta_defaults_by_slug();
	$pages = get_pages( array( 'post_status' => 'publish', 'number' => 500 ) );
	foreach ( $pages as $page ) {
		$slug = $page->post_name;
		if ( ! isset( $map[ $slug ] ) ) {
			continue;
		}
		$seo = $map[ $slug ];
		if ( $force || get_post_meta( $page->ID, 'meta_title', true ) === '' ) {
			update_post_meta( $page->ID, 'meta_title', $seo['meta_title'] );
		}
		if ( $force || get_post_meta( $page->ID, 'meta_description', true ) === '' ) {
			update_post_meta( $page->ID, 'meta_description', $seo['meta_description'] );
		}
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
	return '<h2>For disabled individuals and families</h2>
<p>This is a real holiday — a comfortable self-catering bungalow on the Kent coast, not a clinical placement. We have designed the space so you can focus on the break: the sea air, Whitstable, and time together.</p>
<p><a href="' . $prop . '">View the property</a> or <a href="' . $enquire . '">check availability and enquire</a>.</p>
<h2>For carers and support workers</h2>
<p>Bring your client or family member knowing the property has level access, a ceiling track hoist, profiling bed, and a full wet room. There is room for you to stay — tell us your party size when you book so we can confirm sleeping arrangements.</p>
<p>Read our <a href="' . $acc . '">full accessibility specification</a> and <a href="' . $faq . '">funding and booking FAQs</a>.</p>
<h2>For occupational therapists and case managers</h2>
<p>We provide detailed accessibility information so you can assess suitability. If you need room dimensions, equipment specifications, or a site visit, <a href="' . $enquire . '">contact us</a> — we are used to working with professionals.</p>
<p><a href="' . $acc . '">See our full equipment and access specification</a>.</p>
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
	return '<p>Restwell sits in a quiet residential street in Whitstable, about five minutes’ drive from the town centre and seafront. Below is a practical guide to the area — with accessibility notes where we can help.</p>
<h2>About Whitstable</h2>
<p>The harbour, independent shops, and seafood are the heart of the town. The beach is shingle; the Tankerton Slopes promenade offers a long, level walk with sea views — one of the more accessible coastal routes in Kent.</p>
<h2>Nearby towns</h2>
<p><strong>Canterbury</strong> (about eight miles) — cathedral, museums, and flat pedestrianised areas in the centre. <strong>Faversham</strong> and <strong>Herne Bay</strong> are short drives for market-town days out and traditional seafront.</p>
<h2>Getting here</h2>
<p>Whitstable station has trains to London St Pancras and Victoria. By car, use the M2 / Thanet Way. The property has off-street parking suitable for adapted vehicles.</p>
<p><a href="' . $prop . '">Back to the property</a> · <a href="' . $enq . '">Book your stay</a></p>';
}

/**
 * Seed three priority blog posts if missing (by slug).
 *
 * @param array $result Result array with optional key blog_posts_seeded.
 */
function restwell_seed_priority_blog_posts( array &$result ) {
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

	$articles = array(
		array(
			'slug'    => 'revitalise-alternatives-accessible-holidays',
			'title'   => 'What happened to Revitalise — and where to find accessible holidays now',
			'excerpt' => "Revitalise closed its holiday centres in late 2024. Here's what happened, what alternatives exist for accessible holidays in the UK, and how Restwell offers a different kind of break on the Kent coast.",
			'content' => restwell_get_blog_post_revitalise_html(),
		),
		array(
			'slug'    => 'direct-payment-holiday-accommodation',
			'title'   => 'How to use your direct payment for a holiday',
			'excerpt' => 'A practical overview of direct payments and personal budgets — and how to discuss holiday accommodation with your local authority.',
			'content' => restwell_get_blog_post_direct_payments_html(),
		),
		array(
			'slug'    => 'accessible-beaches-coastal-walks-kent',
			'title'   => 'A guide to accessible beaches and coastal walks in Kent',
			'excerpt' => 'Level promenades, shingle realities, and where to plan a seaside day if you use a wheelchair or mobility equipment.',
			'content' => restwell_get_blog_post_beaches_kent_html(),
		),
	);

	foreach ( $articles as $article ) {
		$existing = get_posts(
			array(
				'name'           => $article['slug'],
				'post_type'      => 'post',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		if ( ! empty( $existing ) ) {
			continue;
		}
		$post_id = wp_insert_post(
			array(
				'post_title'   => $article['title'],
				'post_name'    => $article['slug'],
				'post_status'  => 'publish',
				'post_type'    => 'post',
				'post_content' => $article['content'],
				'post_excerpt' => $article['excerpt'],
				'post_author'  => get_current_user_id() ?: 1,
			),
			true
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			$result['blog_posts_failed'][] = $article['slug'];
			continue;
		}
		update_post_meta( $post_id, 'meta_title', $article['title'] . ' | ' . get_bloginfo( 'name' ) );
		update_post_meta( $post_id, 'meta_description', $article['excerpt'] );
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
function restwell_get_blog_post_revitalise_html() {
	$who = esc_url( home_url( '/who-its-for/' ) );
	$enq = esc_url( home_url( '/enquire/' ) );
	$acc = esc_url( home_url( '/accessibility/' ) );
	return '<p>For over 60 years, Revitalise ran fully staffed holiday centres across the UK — purpose-built spaces where disabled people and their carers could take a proper break with 24-hour care on site. In late 2024, the charity announced it could no longer afford to keep the centres open. They closed in November that year.</p>
<p>Since then, the question we hear most often is simple: where do we go now?</p>
<p>It is worth knowing that Revitalise still exists. It no longer runs holiday centres, but it does offer respite grants to help disabled people and carers fund breaks elsewhere. Applications are open year-round — visit <a href="https://revitalise.org.uk" target="_blank" rel="noopener noreferrer">revitalise.org.uk</a> to check eligibility.</p>
<h2>What to look for instead</h2>
<p>Revitalise was a staffed residential model: meals, entertainment, nursing, all included. Most of what remains in the UK is self-catering. That is a different kind of holiday — more independence, less structured support — and it will not suit everyone. Be honest with yourself about what you need before you book.</p>
<p>When you are looking at self-catering options, the details matter more than the marketing. A property that says "accessible" might mean a grab rail by the toilet. Or it might mean a full wet room, ceiling track hoist, profiling bed, and wide doorways throughout. You need to know which one it is before you arrive.</p>
<p><strong>What to check before booking:</strong></p>
<ul>
<li>Does the listing name specific equipment, or just say "accessible"?</li>
<li>Can you speak to the owner directly about your access needs?</li>
<li>Is there a detailed access statement, not just a photo of a ramp?</li>
<li>Will the property accommodate a carer or support worker alongside the guest?</li>
<li>Is it clear how funded stays (direct payments, CHC, personal budgets) are handled?</li>
</ul>
<p><strong>Directories worth searching:</strong></p>
<ul>
<li><a href="https://www.disabledholidays.com" target="_blank" rel="noopener noreferrer">DisabledHolidays.com</a> — UK-wide listings filtered by access features, including properties in Kent</li>
<li><a href="https://www.tourismforall.org.uk" target="_blank" rel="noopener noreferrer">Tourism for All</a> — national charity focused on accessible tourism information</li>
<li><a href="https://www.accessable.co.uk" target="_blank" rel="noopener noreferrer">AccessAble</a> — detailed access guides for venues and accommodation</li>
<li><a href="https://kateandtoms.com/features/accessible-holiday-cottages/" target="_blank" rel="noopener noreferrer">kate &amp; tom\'s</a> — curated collection of high-spec accessible holiday homes</li>
</ul>
<p>If you need a fully supported, escorted holiday rather than self-catering, <a href="https://www.limitlesstravel.org" target="_blank" rel="noopener noreferrer">Limitless Travel</a> runs accessible group coach tours with on-trip care staff — a closer match to the Revitalise model.</p>
<h2>Restwell as one option</h2>
<p>We run a fully adapted holiday home in Whitstable on the Kent coast. It is not a replacement for Revitalise — we do not provide on-site nursing or 24-hour staffing. What we offer is a private, accessible property where you can bring your own support and take a proper break by the sea.</p>
<p>The property has level access throughout, a wet room, and is designed around the access needs that actually matter to guests — not just the ones that look good in a listing. We publish our full accessibility specification so you can check suitability before you get in touch. We also welcome funded stays, including through direct payments and CHC pathways.</p>
<p>If you want to know whether it could work for your situation, the simplest thing is to <a href="' . $who . '">read who we are for</a>, check <a href="' . $acc . '">our accessibility features</a>, and <a href="' . $enq . '">enquire when you are ready</a>.</p>
<p>We would rather you found the right place — even if it is not us — than booked somewhere that does not meet your needs.</p>';
}

/**
 * @return string
 */
function restwell_get_blog_post_direct_payments_html() {
	$res = esc_url( home_url( '/resources/' ) );
	$faq = esc_url( home_url( '/faq/' ) );
	$enq = esc_url( home_url( '/enquire/' ) );
	$rev = esc_url( home_url( '/revitalise-alternatives-accessible-holidays/' ) );
	$who = esc_url( home_url( '/who-its-for/' ) );
	return '<p>Direct payments and personal budgets are designed to give you choice and control. Whether you can use them for holiday accommodation depends on your care plan and local authority rules — always confirm with your social worker or care coordinator.</p>
<h2>What to ask</h2>
<p>Ask whether short breaks or respite-style stays can be included in your plan, and what evidence your council needs (quotes, risk assessments, access statements). We can provide clear information about the property to support those conversations.</p>
<p>Start with our <a href="' . $res . '">Funding &amp; support</a> page, then see <a href="' . $faq . '">funding questions in the FAQ</a>. If you are switching from older respite models, read our <a href="' . $rev . '">Revitalise alternatives guide</a> and <a href="' . $who . '">who Restwell is for</a>. When you are ready, <a href="' . $enq . '">contact us about your dates</a>.</p>';
}

/**
 * @return string
 */
function restwell_get_blog_post_beaches_kent_html() {
	$loc = esc_url( home_url( '/whitstable-area-guide/' ) );
	$pr  = esc_url( home_url( '/the-property/' ) );
	$enq = esc_url( home_url( '/enquire/' ) );
	$who = esc_url( home_url( '/who-its-for/' ) );
	return '<p>Kent\'s coastline mixes shingle beaches with long, level promenades. That matters if you use a wheelchair or need firm, predictable surfaces.</p>
<h2>Practical tips</h2>
<p>Promenades and concrete sea walls are often the most accessible way to enjoy the sea view. Shingle beaches can be difficult or impossible for many wheelchair users — plan for promenade routes and check accessible toilets in advance.</p>
<h2>Whitstable and the north Kent coast</h2>
<p>Tankerton Slopes offers a long flat walk above the beach. Whitstable town centre is mostly level, though some older streets have narrow pavements.</p>
<p>Read our <a href="' . $loc . '">Whitstable &amp; Kent coast area guide</a>, check <a href="' . $who . '">who Restwell is for</a>, see <a href="' . $pr . '">the property</a>, and <a href="' . $enq . '">enquire about a stay</a> when you have dates in mind.</p>';
}
