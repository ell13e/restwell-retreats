<?php
/**
 * SEO Admin: "Search & Social" meta box for pages and posts.
 *
 * Provides:
 *  - Focus keyphrase field
 *  - Meta title + description with character counters and traffic-light colours
 *  - Real-time SERP preview
 *  - OG image upload, og_type select, canonical URL, noindex checkbox
 *  - Social preview panel (Facebook + Twitter/X tabs)
 *  - 8-check live SEO analysis panel
 *  - Schema status indicator
 *
 * Fields saved:
 *  focus_keyphrase, meta_title, meta_description, og_image_id,
 *  meta_og_type, meta_canonical, meta_noindex
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =============================================================================
// Registration
// =============================================================================

/**
 * Register the "Search & Social" meta box on page and post edit screens.
 */
function restwell_seo_admin_register_meta_box() {
	add_meta_box(
		'restwell_seo',
		__( 'Search &amp; Social', 'restwell-retreats' ),
		'restwell_seo_admin_meta_box_callback',
		array( 'page', 'post' ),
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'restwell_seo_admin_register_meta_box' );

// =============================================================================
// Enqueue admin assets (scoped to edit screen only)
// =============================================================================

/**
 * Enqueue the admin CSS + JS for the SEO meta box.
 *
 * @param string $hook_suffix Current admin page hook.
 */
function restwell_seo_admin_enqueue( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->post_type, array( 'page', 'post' ), true ) ) {
		return;
	}

	$uri = get_template_directory_uri();
	$ver = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'restwell-seo-admin',
		$uri . '/assets/css/seo-admin.css',
		array(),
		$ver
	);

	wp_enqueue_script(
		'restwell-seo-admin',
		$uri . '/assets/js/seo-admin.js',
		array( 'wp-util', 'jquery' ),
		$ver,
		true
	);

	wp_enqueue_media();

	wp_localize_script(
		'restwell-seo-admin',
		'rwSeoAdmin',
		array(
			'siteUrl'      => home_url( '/' ),
			'siteName'     => get_bloginfo( 'name' ),
			'chooseImage'  => __( 'Choose OG image', 'restwell-retreats' ),
			'useImage'     => __( 'Use this image', 'restwell-retreats' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'restwell_seo_admin_enqueue' );

// =============================================================================
// Meta box callback
// =============================================================================

/**
 * Render the SEO meta box HTML.
 *
 * @param WP_Post $post Current post object.
 */
function restwell_seo_admin_meta_box_callback( $post ) {
	wp_nonce_field( 'restwell_seo_save', 'restwell_seo_nonce' );

	$focus_kp    = (string) get_post_meta( $post->ID, 'focus_keyphrase', true );
	$meta_title  = (string) get_post_meta( $post->ID, 'meta_title',       true );
	$meta_desc   = (string) get_post_meta( $post->ID, 'meta_description',  true );
	$og_image_id = (int)    get_post_meta( $post->ID, 'og_image_id',       true );
	$og_type     = (string) get_post_meta( $post->ID, 'meta_og_type',      true );
	$canonical   = (string) get_post_meta( $post->ID, 'meta_canonical',    true );
	$noindex     = (bool)   get_post_meta( $post->ID, 'meta_noindex',      true );

	if ( ! in_array( $og_type, array( 'website', 'article' ), true ) ) {
		$og_type = ( get_post_type( $post ) === 'post' ) ? 'article' : 'website';
	}

	$og_image_url = $og_image_id ? wp_get_attachment_image_url( $og_image_id, 'large' ) : '';

	// Fallback title for SERP preview — use post title if meta_title is empty.
	$preview_title = $meta_title ?: $post->post_title;
	$preview_desc  = $meta_desc;
	$preview_url   = get_permalink( $post->ID );

	// Schema status.
	$template     = get_page_template_slug( $post->ID );
	$schema_items = restwell_seo_admin_schema_status( $post, $template );
	?>
	<div class="rw-seo" id="rw-seo-root">

		<!-- Focus keyphrase -->
		<div class="rw-seo__field">
			<label class="rw-seo__label" for="rw_focus_keyphrase">
				<?php esc_html_e( 'Focus keyphrase', 'restwell-retreats' ); ?>
				<span class="rw-seo__hint"><?php esc_html_e( '(optional)', 'restwell-retreats' ); ?></span>
			</label>
			<input
				type="text"
				id="rw_focus_keyphrase"
				name="focus_keyphrase"
				value="<?php echo esc_attr( $focus_kp ); ?>"
				class="rw-seo__input"
				placeholder="<?php esc_attr_e( 'e.g. accessible holiday cottage Kent', 'restwell-retreats' ); ?>"
			/>
		</div>

		<!-- ── SERP preview ─────────────────────────────────────────────── -->
		<div class="rw-seo__section rw-seo__serp-preview" aria-label="<?php esc_attr_e( 'SERP preview', 'restwell-retreats' ); ?>">
			<p class="rw-seo__section-label"><?php esc_html_e( 'Search result preview', 'restwell-retreats' ); ?></p>
			<div class="rw-seo__serp-box">
				<div class="rw-seo__serp-url" id="rw-serp-url"><?php echo esc_html( $preview_url ); ?></div>
				<div class="rw-seo__serp-title" id="rw-serp-title"><?php echo esc_html( mb_substr( $preview_title, 0, 60 ) ); ?></div>
				<div class="rw-seo__serp-desc" id="rw-serp-desc"><?php echo esc_html( mb_substr( $preview_desc, 0, 160 ) ); ?></div>
			</div>
		</div>

		<!-- Meta title -->
		<div class="rw-seo__field">
			<label class="rw-seo__label" for="rw_meta_title">
				<?php esc_html_e( 'SEO title', 'restwell-retreats' ); ?>
			</label>
			<input
				type="text"
				id="rw_meta_title"
				name="meta_title"
				value="<?php echo esc_attr( $meta_title ); ?>"
				class="rw-seo__input"
				placeholder="<?php echo esc_attr( $post->post_title ); ?>"
				data-rw-seo="title"
			/>
			<p class="rw-seo__counter" id="rw-title-counter" data-max="60">
				<span class="rw-seo__counter-val">0</span> / 60
			</p>
		</div>

		<!-- Meta description -->
		<div class="rw-seo__field">
			<label class="rw-seo__label" for="rw_meta_description">
				<?php esc_html_e( 'Meta description', 'restwell-retreats' ); ?>
			</label>
			<textarea
				id="rw_meta_description"
				name="meta_description"
				rows="3"
				class="rw-seo__input rw-seo__textarea"
				data-rw-seo="desc"
			><?php echo esc_textarea( $meta_desc ); ?></textarea>
			<p class="rw-seo__counter" id="rw-desc-counter" data-max="160">
				<span class="rw-seo__counter-val">0</span> / 160
			</p>
		</div>

		<!-- ── Social preview ───────────────────────────────────────────── -->
		<div class="rw-seo__section" aria-label="<?php esc_attr_e( 'Social preview', 'restwell-retreats' ); ?>">
			<p class="rw-seo__section-label"><?php esc_html_e( 'Social card preview', 'restwell-retreats' ); ?></p>

			<div class="rw-seo__tabs">
				<button type="button" class="rw-seo__tab rw-seo__tab--active" data-tab="facebook">Facebook</button>
				<button type="button" class="rw-seo__tab" data-tab="twitter">Twitter / X</button>
			</div>

			<div class="rw-seo__social-preview" id="rw-social-fb">
				<div class="rw-seo__social-img" id="rw-social-fb-img">
					<?php if ( $og_image_url ) : ?>
						<img src="<?php echo esc_url( $og_image_url ); ?>" alt="" />
					<?php else : ?>
						<span class="rw-seo__social-placeholder"><?php esc_html_e( 'No image set', 'restwell-retreats' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="rw-seo__social-body">
					<div class="rw-seo__social-domain"><?php echo esc_html( wp_parse_url( home_url(), PHP_URL_HOST ) ); ?></div>
					<div class="rw-seo__social-title" id="rw-social-fb-title"><?php echo esc_html( mb_substr( $preview_title, 0, 60 ) ); ?></div>
					<div class="rw-seo__social-desc" id="rw-social-fb-desc"><?php echo esc_html( mb_substr( $preview_desc, 0, 160 ) ); ?></div>
				</div>
			</div>

			<div class="rw-seo__social-preview rw-seo__social-preview--twitter" id="rw-social-tw" style="display:none;">
				<div class="rw-seo__social-img" id="rw-social-tw-img">
					<?php if ( $og_image_url ) : ?>
						<img src="<?php echo esc_url( $og_image_url ); ?>" alt="" />
					<?php else : ?>
						<span class="rw-seo__social-placeholder"><?php esc_html_e( 'No image set', 'restwell-retreats' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="rw-seo__social-body">
					<div class="rw-seo__social-title" id="rw-social-tw-title"><?php echo esc_html( mb_substr( $preview_title, 0, 60 ) ); ?></div>
					<div class="rw-seo__social-desc" id="rw-social-tw-desc"><?php echo esc_html( mb_substr( $preview_desc, 0, 120 ) ); ?></div>
					<div class="rw-seo__social-domain"><?php echo esc_html( wp_parse_url( home_url(), PHP_URL_HOST ) ); ?></div>
				</div>
			</div>
		</div>

		<!-- OG image -->
		<div class="rw-seo__field rw-seo__og-image-row">
			<label class="rw-seo__label"><?php esc_html_e( 'OG / social image', 'restwell-retreats' ); ?></label>
			<input type="hidden" id="rw_og_image_id" name="og_image_id" value="<?php echo esc_attr( (string) $og_image_id ); ?>" />
			<div class="rw-seo__og-thumb" id="rw-og-thumb">
				<?php if ( $og_image_url ) : ?>
					<img src="<?php echo esc_url( $og_image_url ); ?>" alt="" />
				<?php endif; ?>
			</div>
			<div class="rw-seo__og-actions">
				<button type="button" id="rw-og-choose" class="button button-secondary">
					<?php esc_html_e( 'Choose image', 'restwell-retreats' ); ?>
				</button>
				<?php if ( $og_image_id ) : ?>
					<button type="button" id="rw-og-remove" class="button-link rw-seo__remove-btn">
						<?php esc_html_e( 'Remove', 'restwell-retreats' ); ?>
					</button>
				<?php endif; ?>
			</div>
		</div>

		<!-- OG type -->
		<div class="rw-seo__field rw-seo__field--half">
			<label class="rw-seo__label" for="rw_meta_og_type">
				<?php esc_html_e( 'OG type', 'restwell-retreats' ); ?>
			</label>
			<select id="rw_meta_og_type" name="meta_og_type" class="rw-seo__input">
				<option value="website"  <?php selected( $og_type, 'website' ); ?>><?php esc_html_e( 'website', 'restwell-retreats' ); ?></option>
				<option value="article"  <?php selected( $og_type, 'article' ); ?>><?php esc_html_e( 'article', 'restwell-retreats' ); ?></option>
			</select>
		</div>

		<!-- Canonical -->
		<div class="rw-seo__field">
			<label class="rw-seo__label" for="rw_meta_canonical">
				<?php esc_html_e( 'Canonical URL', 'restwell-retreats' ); ?>
				<span class="rw-seo__hint"><?php esc_html_e( '(leave blank to use default)', 'restwell-retreats' ); ?></span>
			</label>
			<input
				type="url"
				id="rw_meta_canonical"
				name="meta_canonical"
				value="<?php echo esc_url( $canonical ); ?>"
				class="rw-seo__input"
				placeholder="https://..."
			/>
		</div>

		<!-- No-index -->
		<div class="rw-seo__field rw-seo__field--checkbox">
			<label for="rw_meta_noindex" class="rw-seo__checkbox-label">
				<input type="hidden" name="meta_noindex" value="0" />
				<input
					type="checkbox"
					id="rw_meta_noindex"
					name="meta_noindex"
					value="1"
					<?php checked( $noindex ); ?>
				/>
				<?php esc_html_e( 'Hide from search engines (noindex, nofollow)', 'restwell-retreats' ); ?>
			</label>
		</div>

		<!-- ── SEO analysis panel ───────────────────────────────────────── -->
		<div class="rw-seo__section" aria-label="<?php esc_attr_e( 'SEO analysis', 'restwell-retreats' ); ?>">
			<p class="rw-seo__section-label"><?php esc_html_e( 'SEO analysis', 'restwell-retreats' ); ?></p>
			<ul class="rw-seo__checks" id="rw-seo-checks"
			    data-content="<?php echo esc_attr( $post->post_content ); ?>"
			    data-post-type="<?php echo esc_attr( $post->post_type ); ?>">

				<?php
				$checks = restwell_seo_admin_run_checks( $post, $focus_kp, $meta_title, $meta_desc );
				foreach ( $checks as $check ) :
					$state = $check['state']; // 'ok', 'warn', 'bad'
					$icons = array( 'ok' => '✓', 'warn' => '~', 'bad' => '✗' );
				?>
				<li class="rw-seo__check rw-seo__check--<?php echo esc_attr( $state ); ?>" data-check="<?php echo esc_attr( $check['id'] ); ?>">
					<span class="rw-seo__check-icon" aria-hidden="true"><?php echo $icons[ $state ]; // phpcs:ignore ?></span>
					<span class="rw-seo__check-label"><?php echo esc_html( $check['label'] ); ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<!-- ── Schema status panel ──────────────────────────────────────── -->
		<div class="rw-seo__section rw-seo__schema-panel" aria-label="<?php esc_attr_e( 'Schema status', 'restwell-retreats' ); ?>">
			<p class="rw-seo__section-label"><?php esc_html_e( 'Active schema', 'restwell-retreats' ); ?></p>
			<ul class="rw-seo__schema-list">
				<?php foreach ( $schema_items as $name => $active ) : ?>
				<li class="rw-seo__schema-item rw-seo__schema-item--<?php echo $active ? 'on' : 'off'; ?>">
					<span class="rw-seo__schema-dot" aria-hidden="true"><?php echo $active ? '✓' : '✗'; // phpcs:ignore ?></span>
					<?php echo esc_html( $name ); ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

	</div><!-- /.rw-seo -->
	<?php
}

// =============================================================================
// Server-side analysis helpers
// =============================================================================

/**
 * Run 8 SEO checks on the post and return their state.
 *
 * @param WP_Post $post         Post object.
 * @param string  $focus_kp     Focus keyphrase.
 * @param string  $meta_title   SEO title.
 * @param string  $meta_desc    Meta description.
 * @return array<int, array{id:string,label:string,state:string}>
 */
function restwell_seo_admin_run_checks( WP_Post $post, string $focus_kp, string $meta_title, string $meta_desc ): array {
	$content    = $post->post_content;
	$title      = $meta_title ?: $post->post_title;
	$desc       = $meta_desc;
	$kp         = trim( strtolower( $focus_kp ) );
	$title_l    = strtolower( $title );
	$desc_l     = strtolower( $desc );
	$title_len  = mb_strlen( $title );
	$desc_len   = mb_strlen( $desc );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$has_og     = (bool) get_post_meta( $post->ID, 'og_image_id', true ) || has_post_thumbnail( $post->ID );

	$checks = array();

	// 1 – title contains focus keyphrase.
	if ( $kp === '' ) {
		$state = 'warn';
		$label = __( 'No focus keyphrase set (optional but recommended)', 'restwell-retreats' );
	} else {
		$state = ( str_contains( $title_l, $kp ) ) ? 'ok' : 'bad';
		$label = __( 'Focus keyphrase in SEO title', 'restwell-retreats' );
	}
	$checks[] = array( 'id' => 'kp_title', 'label' => $label, 'state' => $state );

	// 2 – description contains focus keyphrase.
	if ( $kp === '' ) {
		$state = 'warn';
		$label = __( 'Focus keyphrase in meta description — set a keyphrase first', 'restwell-retreats' );
	} else {
		$state = ( str_contains( $desc_l, $kp ) ) ? 'ok' : 'bad';
		$label = __( 'Focus keyphrase in meta description', 'restwell-retreats' );
	}
	$checks[] = array( 'id' => 'kp_desc', 'label' => $label, 'state' => $state );

	// 3 – title length 50–60 chars.
	if ( $title_len >= 50 && $title_len <= 60 ) {
		$state = 'ok';
	} elseif ( $title_len >= 40 ) {
		$state = 'warn';
	} else {
		$state = 'bad';
	}
	$checks[] = array(
		'id'    => 'title_len',
		'label' => sprintf(
			/* translators: %d — character count */
			__( 'SEO title length: %d characters (ideal: 50–60)', 'restwell-retreats' ),
			$title_len
		),
		'state' => $state,
	);

	// 4 – description length 120–160 chars.
	if ( $desc_len >= 120 && $desc_len <= 160 ) {
		$state = 'ok';
	} elseif ( $desc_len >= 100 ) {
		$state = 'warn';
	} else {
		$state = 'bad';
	}
	$checks[] = array(
		'id'    => 'desc_len',
		'label' => sprintf(
			/* translators: %d — character count */
			__( 'Meta description length: %d characters (ideal: 120–160)', 'restwell-retreats' ),
			$desc_len
		),
		'state' => $state,
	);

	// 5 – has featured image or OG image.
	$checks[] = array(
		'id'    => 'og_image',
		'label' => __( 'Featured or OG image is set', 'restwell-retreats' ),
		'state' => $has_og ? 'ok' : 'bad',
	);

	// 6 – content contains at least one heading.
	$has_heading = preg_match( '/<h[23]/i', $content ) === 1;
	$checks[]    = array(
		'id'    => 'headings',
		'label' => __( 'Content contains at least one subheading (h2/h3)', 'restwell-retreats' ),
		'state' => $has_heading ? 'ok' : ( $post->post_type === 'page' ? 'warn' : 'bad' ),
	);

	// 7 – word count over 300.
	if ( $word_count >= 300 ) {
		$state = 'ok';
	} elseif ( $word_count >= 150 ) {
		$state = 'warn';
	} else {
		$state = 'bad';
	}
	$checks[] = array(
		'id'    => 'word_count',
		'label' => sprintf(
			/* translators: %d — word count */
			__( 'Word count: %d words (recommended: 300+)', 'restwell-retreats' ),
			$word_count
		),
		'state' => $state,
	);

	// 8 – content contains at least one internal link.
	$has_internal = preg_match( '/href=["\']\//', $content ) === 1;
	$checks[]     = array(
		'id'    => 'internal_links',
		'label' => __( 'Content contains at least one internal link', 'restwell-retreats' ),
		'state' => $has_internal ? 'ok' : 'warn',
	);

	return $checks;
}

/**
 * Determine which JSON-LD schemas are active for this post.
 *
 * @param WP_Post $post     Post object.
 * @param string  $template Page template slug.
 * @return array<string, bool>
 */
function restwell_seo_admin_schema_status( WP_Post $post, string $template ): array {
	$front_id  = (int) get_option( 'page_on_front', 0 );
	$is_front  = ( $front_id > 0 && (int) $post->ID === $front_id );
	$breadcrumb = ! ( $post->post_type === 'page' && $front_id === (int) $post->ID );

	return array(
		'WebSite + Organization'  => ! $is_front,
		'WebSite + LodgingBusiness' => $is_front,
		'Breadcrumb'              => $breadcrumb,
		'VacationRental'          => ( 'template-property.php' === $template ),
		'FAQPage'                 => ( 'template-faq.php' === $template ),
		'BlogPosting'             => ( 'post' === $post->post_type ),
	);
}

// =============================================================================
// Save handler
// =============================================================================

/**
 * Save SEO meta box fields.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function restwell_seo_admin_save( $post_id, $post ) {
	if (
		! isset( $_POST['restwell_seo_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['restwell_seo_nonce'] ) ), 'restwell_seo_save' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( ! in_array( $post->post_type, array( 'page', 'post' ), true ) ) {
		return;
	}

	$fields = array(
		'focus_keyphrase' => 'sanitize_text_field',
		'meta_title'      => 'sanitize_text_field',
		'meta_description' => 'sanitize_textarea_field',
	);

	foreach ( $fields as $key => $sanitiser ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, call_user_func( $sanitiser, wp_unslash( $_POST[ $key ] ) ) );
		}
	}

	// OG image ID.
	if ( isset( $_POST['og_image_id'] ) ) {
		$og_image_id = absint( $_POST['og_image_id'] );
		if ( $og_image_id > 0 ) {
			update_post_meta( $post_id, 'og_image_id', $og_image_id );
		} else {
			delete_post_meta( $post_id, 'og_image_id' );
		}
	}

	// OG type — allow only known values.
	if ( isset( $_POST['meta_og_type'] ) ) {
		$og_type = sanitize_key( wp_unslash( $_POST['meta_og_type'] ) );
		if ( in_array( $og_type, array( 'website', 'article' ), true ) ) {
			update_post_meta( $post_id, 'meta_og_type', $og_type );
		}
	}

	// Canonical — store as raw URL.
	if ( isset( $_POST['meta_canonical'] ) ) {
		$canonical = esc_url_raw( wp_unslash( $_POST['meta_canonical'] ) );
		update_post_meta( $post_id, 'meta_canonical', $canonical );
	}

	// Noindex checkbox.
	$noindex = isset( $_POST['meta_noindex'] ) ? absint( $_POST['meta_noindex'] ) : 0;
	update_post_meta( $post_id, 'meta_noindex', $noindex );
}
add_action( 'save_post', 'restwell_seo_admin_save', 10, 2 );
