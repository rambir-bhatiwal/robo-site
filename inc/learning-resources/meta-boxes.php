<?php
/**
 * Custom Meta Boxes and Admin Interface for Learning Resources.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Robo_Learning_Resources_Meta_Boxes' ) ) {

	/**
	 * Class Robo_Learning_Resources_Meta_Boxes
	 */
	class Robo_Learning_Resources_Meta_Boxes {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
			add_action( 'save_post_learning-resource', array( $this, 'save_meta_boxes' ), 10, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		}

		/**
		 * Enqueue Scripts and Styles for Admin Meta Box
		 *
		 * @param string $hook_suffix Current admin page hook.
		 */
		public function enqueue_admin_assets( $hook_suffix ) {
			if ( 'post.php' !== $hook_suffix && 'post-new.php' !== $hook_suffix ) {
				return;
			}

			$screen = get_current_screen();
			if ( ! $screen || 'learning-resource' !== $screen->post_type ) {
				return;
			}

			// Enqueue WP Media Uploader scripts & styles
			wp_enqueue_media();
			wp_enqueue_script( 'jquery-ui-sortable' );

			// Custom Admin Stylesheet
			wp_enqueue_style(
				'robo-lr-admin-style',
				ROBO_THEME_URI . '/assets/css/learning-resources-admin.css',
				array(),
				ROBO_THEME_VERSION
			);

			// Custom Admin Script
			wp_enqueue_script(
				'robo-lr-admin-script',
				ROBO_THEME_URI . '/assets/js/learning-resources-admin.js',
				array( 'jquery', 'jquery-ui-sortable' ),
				ROBO_THEME_VERSION,
				true
			);

			wp_localize_script(
				'robo-lr-admin-script',
				'roboLrAdminParams',
				array(
					'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
					'nonce'     => wp_create_nonce( 'robo_lr_admin_nonce' ),
					'wcActive'  => class_exists( 'WooCommerce' ) ? 1 : 0,
					'i18n'      => array(
						'selectFile'  => __( 'Select File', 'robo' ),
						'selectImage' => __( 'Select Image', 'robo' ),
						'useFile'     => __( 'Use File', 'robo' ),
						'useImage'    => __( 'Use Image', 'robo' ),
						'remove'      => __( 'Remove', 'robo' ),
					),
				)
			);
		}

		/**
		 * Add Custom Meta Box
		 */
		public function add_meta_boxes() {
			add_meta_box(
				'robo_lr_main_meta_box',
				__( 'Learning Resource Details & Settings', 'robo' ),
				array( $this, 'render_main_meta_box' ),
				'learning-resource',
				'normal',
				'high'
			);
		}

		/**
		 * Render Main Meta Box Container with Tabbed Sidebar Navigation
		 *
		 * @param WP_Post $post Current post object.
		 */
		public function render_main_meta_box( $post ) {
			// Nonce field for security
			wp_nonce_field( 'robo_lr_save_meta_box_data', 'robo_lr_meta_box_nonce' );

			// Fetch saved meta values
			$short_desc        = get_post_meta( $post->ID, '_robo_lr_short_desc', true );
			$difficulty        = get_post_meta( $post->ID, '_robo_lr_difficulty', true );
			$duration          = get_post_meta( $post->ID, '_robo_lr_duration', true );
			$instructor        = get_post_meta( $post->ID, '_robo_lr_instructor', true );
			$has_certificate   = get_post_meta( $post->ID, '_robo_lr_has_certificate', true );

			$cover_image_id    = get_post_meta( $post->ID, '_robo_lr_cover_image_id', true );
			$list_image_id     = get_post_meta( $post->ID, '_robo_lr_list_image_id', true );
			$gallery_ids       = get_post_meta( $post->ID, '_robo_lr_gallery_image_ids', true );

			$pdf_resources     = get_post_meta( $post->ID, '_robo_lr_pdf_resources', true );
			$video_resources   = get_post_meta( $post->ID, '_robo_lr_video_resources', true );
			$github_resources  = get_post_meta( $post->ID, '_robo_lr_github_resources', true );
			$downloads         = get_post_meta( $post->ID, '_robo_lr_downloads', true );
			$related_wc_ids    = get_post_meta( $post->ID, '_robo_lr_related_product_ids', true );
			$external_res      = get_post_meta( $post->ID, '_robo_lr_external_resources', true );
			$outcomes          = get_post_meta( $post->ID, '_robo_lr_outcomes', true );
			$requirements      = get_post_meta( $post->ID, '_robo_lr_requirements', true );
			$faqs              = get_post_meta( $post->ID, '_robo_lr_faqs', true );

			$meta_title        = get_post_meta( $post->ID, '_robo_lr_meta_title', true );
			$meta_desc         = get_post_meta( $post->ID, '_robo_lr_meta_description', true );
			$og_image_id       = get_post_meta( $post->ID, '_robo_lr_og_image_id', true );
			$canonical_url     = get_post_meta( $post->ID, '_robo_lr_canonical_url', true );

			$attachment_ids    = get_post_meta( $post->ID, '_robo_lr_attachment_ids', true );

			$badge_featured    = get_post_meta( $post->ID, '_robo_lr_badge_featured', true );
			$badge_popular     = get_post_meta( $post->ID, '_robo_lr_badge_popular', true );
			$badge_recommended = get_post_meta( $post->ID, '_robo_lr_badge_recommended', true );
			$badge_new         = get_post_meta( $post->ID, '_robo_lr_badge_new', true );
			$badge_trending    = get_post_meta( $post->ID, '_robo_lr_badge_trending', true );

			// Defaults for repeaters
			$pdf_resources    = is_array( $pdf_resources ) ? $pdf_resources : array();
			$video_resources  = is_array( $video_resources ) ? $video_resources : array();
			$github_resources = is_array( $github_resources ) ? $github_resources : array();
			$downloads        = is_array( $downloads ) ? $downloads : array();
			$related_wc_ids   = is_array( $related_wc_ids ) ? $related_wc_ids : array();
			$external_res     = is_array( $external_res ) ? $external_res : array();
			$outcomes         = is_array( $outcomes ) ? $outcomes : array();
			$requirements     = is_array( $requirements ) ? $requirements : array();
			$faqs             = is_array( $faqs ) ? $faqs : array();
			$attachment_ids   = is_array( $attachment_ids ) ? $attachment_ids : array();
			$gallery_ids      = is_array( $gallery_ids ) ? $gallery_ids : ( $gallery_ids ? explode( ',', $gallery_ids ) : array() );

			?>
			<div class="robo-lr-admin-wrapper">
				<div class="robo-lr-tabs-nav">
					<ul>
						<li class="active"><a href="#tab-basic" data-tab="tab-basic"><span class="dashicons dashicons-info"></span> 1. Basic Info</a></li>
						<li><a href="#tab-media" data-tab="tab-media"><span class="dashicons dashicons-format-gallery"></span> 2. Learning Media</a></li>
						<li><a href="#tab-pdfs" data-tab="tab-pdfs"><span class="dashicons dashicons-pdf"></span> 3. PDF Resources</a></li>
						<li><a href="#tab-videos" data-tab="tab-videos"><span class="dashicons dashicons-video-alt3"></span> 4. Video Resources</a></li>
						<li><a href="#tab-github" data-tab="tab-github"><span class="dashicons dashicons-code-standards"></span> 5. GitHub Resources</a></li>
						<li><a href="#tab-downloads" data-tab="tab-downloads"><span class="dashicons dashicons-download"></span> 6. Downloads</a></li>
						<li><a href="#tab-products" data-tab="tab-products"><span class="dashicons dashicons-cart"></span> 7. Related Products</a></li>
						<li><a href="#tab-external" data-tab="tab-external"><span class="dashicons dashicons-external"></span> 8. External Resources</a></li>
						<li><a href="#tab-outcomes" data-tab="tab-outcomes"><span class="dashicons dashicons-awards"></span> 9. Learning Outcomes</a></li>
						<li><a href="#tab-requirements" data-tab="tab-requirements"><span class="dashicons dashicons-clipboard"></span> 10. Requirements</a></li>
						<li><a href="#tab-faqs" data-tab="tab-faqs"><span class="dashicons dashicons-editor-help"></span> 11. FAQs</a></li>
						<li><a href="#tab-seo" data-tab="tab-seo"><span class="dashicons dashicons-search"></span> 12. SEO</a></li>
						<li><a href="#tab-attachments" data-tab="tab-attachments"><span class="dashicons dashicons-paperclip"></span> 13. Attachments</a></li>
						<li><a href="#tab-badges" data-tab="tab-badges"><span class="dashicons dashicons-tag"></span> 14. Status Badges</a></li>
					</ul>
				</div>

				<div class="robo-lr-tabs-content">

					<!-- SECTION 1: Basic Information -->
					<div id="tab-basic" class="robo-lr-tab-pane active">
						<h3>Section 1: Basic Information</h3>
						
						<div class="robo-lr-field-group">
							<label for="robo_lr_short_desc">Short Description</label>
							<textarea id="robo_lr_short_desc" name="robo_lr_short_desc" rows="3" class="widefat"><?php echo esc_textarea( $short_desc ); ?></textarea>
							<p class="description">Provide a concise overview of this learning resource (used on cards and hero section).</p>
						</div>

						<div class="robo-lr-field-row">
							<div class="robo-lr-field">
								<label for="robo_lr_difficulty">Difficulty Level</label>
								<select id="robo_lr_difficulty" name="robo_lr_difficulty">
									<option value="beginner" <?php selected( $difficulty, 'beginner' ); ?>>Beginner</option>
									<option value="intermediate" <?php selected( $difficulty, 'intermediate' ); ?>>Intermediate</option>
									<option value="advanced" <?php selected( $difficulty, 'advanced' ); ?>>Advanced</option>
								</select>
							</div>

							<div class="robo-lr-field">
								<label for="robo_lr_duration">Estimated Duration</label>
								<input type="text" id="robo_lr_duration" name="robo_lr_duration" value="<?php echo esc_attr( $duration ); ?>" placeholder="e.g. 30 Minutes, 2 Hours, 5 Days" class="widefat">
							</div>

							<div class="robo-lr-field">
								<label for="robo_lr_instructor">Instructor / Author</label>
								<input type="text" id="robo_lr_instructor" name="robo_lr_instructor" value="<?php echo esc_attr( $instructor ); ?>" placeholder="e.g. Dr. Alex Vance" class="widefat">
							</div>
						</div>

						<div class="robo-lr-field-group">
							<label>
								<input type="checkbox" name="robo_lr_has_certificate" value="1" <?php checked( $has_certificate, '1' ); ?>>
								<strong>Certificate Available</strong> (Check if completing this resource awards a certificate)
							</label>
						</div>
					</div>

					<!-- SECTION 2: Learning Media -->
					<div id="tab-media" class="robo-lr-tab-pane">
						<h3>Section 2: Learning Media</h3>

						<!-- Cover Image -->
						<div class="robo-lr-field-group">
							<label>Cover Image (Single)</label>
							<div class="robo-lr-media-picker" data-field="robo_lr_cover_image_id">
								<input type="hidden" name="robo_lr_cover_image_id" class="robo-lr-media-id" value="<?php echo esc_attr( $cover_image_id ); ?>">
								<div class="robo-lr-media-preview">
									<?php if ( $cover_image_id ) : ?>
										<?php echo wp_get_attachment_image( $cover_image_id, 'medium' ); ?>
									<?php else : ?>
										<span class="placeholder">No Cover Image Selected</span>
									<?php endif; ?>
								</div>
								<button type="button" class="button robo-lr-upload-btn">Upload / Choose Image</button>
								<button type="button" class="button robo-lr-remove-btn" <?php echo ! $cover_image_id ? 'style="display:none;"' : ''; ?>>Remove</button>
							</div>
						</div>

						<!-- List Image -->
						<div class="robo-lr-field-group">
							<label>List Image (Single - Used for Archive / Cards)</label>
							<div class="robo-lr-media-picker" data-field="robo_lr_list_image_id">
								<input type="hidden" name="robo_lr_list_image_id" class="robo-lr-media-id" value="<?php echo esc_attr( $list_image_id ); ?>">
								<div class="robo-lr-media-preview">
									<?php if ( $list_image_id ) : ?>
										<?php echo wp_get_attachment_image( $list_image_id, 'medium' ); ?>
									<?php else : ?>
										<span class="placeholder">No List Image Selected</span>
									<?php endif; ?>
								</div>
								<button type="button" class="button robo-lr-upload-btn">Upload / Choose Image</button>
								<button type="button" class="button robo-lr-remove-btn" <?php echo ! $list_image_id ? 'style="display:none;"' : ''; ?>>Remove</button>
							</div>
						</div>

						<!-- Gallery Images -->
						<div class="robo-lr-field-group">
							<label>Gallery Images (Multiple - Drag & Drop Sortable)</label>
							<div class="robo-lr-gallery-picker">
								<input type="hidden" name="robo_lr_gallery_image_ids" class="robo-lr-gallery-ids" value="<?php echo esc_attr( implode( ',', array_filter( $gallery_ids ) ) ); ?>">
								<div class="robo-lr-gallery-preview-grid">
									<?php
									foreach ( array_filter( $gallery_ids ) as $g_id ) {
										$img_src = wp_get_attachment_image_url( $g_id, 'thumbnail' );
										if ( $img_src ) {
											printf(
												'<div class="gallery-item" data-id="%1$d"><img src="%2$s" /><span class="remove-item" title="Remove">&times;</span></div>',
												esc_attr( $g_id ),
												esc_url( $img_src )
											);
										}
									}
									?>
								</div>
								<button type="button" class="button robo-lr-add-gallery-btn">Add Gallery Images</button>
							</div>
						</div>
					</div>

					<!-- SECTION 3: PDF Resources -->
					<div id="tab-pdfs" class="robo-lr-tab-pane">
						<h3>Section 3: PDF Resources</h3>
						<p class="description">Add unlimited PDF documents for users to read or download.</p>

						<div class="robo-lr-repeater" data-repeater="pdf">
							<div class="robo-lr-repeater-list">
								<?php foreach ( $pdf_resources as $index => $pdf ) : ?>
									<div class="robo-lr-repeater-item">
										<span class="handle dashicons dashicons-move"></span>
										<div class="repeater-content">
											<div class="robo-lr-field-row">
												<div class="robo-lr-field" style="flex:2;">
													<label>PDF Title</label>
													<input type="text" name="robo_lr_pdf_resources[<?php echo $index; ?>][title]" value="<?php echo esc_attr( isset( $pdf['title'] ) ? $pdf['title'] : '' ); ?>" class="widefat" required>
												</div>
												<div class="robo-lr-field" style="flex:2;">
													<label>PDF File</label>
													<div class="robo-lr-file-picker">
														<input type="hidden" name="robo_lr_pdf_resources[<?php echo $index; ?>][file_id]" class="file-id" value="<?php echo esc_attr( isset( $pdf['file_id'] ) ? $pdf['file_id'] : '' ); ?>">
														<input type="text" name="robo_lr_pdf_resources[<?php echo $index; ?>][file_url]" class="file-url widefat" value="<?php echo esc_url( isset( $pdf['file_url'] ) ? $pdf['file_url'] : '' ); ?>" placeholder="File URL">
														<button type="button" class="button robo-lr-file-upload-btn">Upload PDF</button>
													</div>
												</div>
											</div>
											<div class="robo-lr-field-group">
												<label>Optional Description</label>
												<input type="text" name="robo_lr_pdf_resources[<?php echo $index; ?>][description]" value="<?php echo esc_attr( isset( $pdf['description'] ) ? $pdf['description'] : '' ); ?>" class="widefat">
											</div>
										</div>
										<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-primary robo-lr-add-repeater-item" data-type="pdf">+ Add PDF Resource</button>
						</div>
					</div>

					<!-- SECTION 4: Video Resources -->
					<div id="tab-videos" class="robo-lr-tab-pane">
						<h3>Section 4: Video Resources</h3>
						<p class="description">Add unlimited video tutorials (YouTube, Vimeo, or Self Hosted MP4).</p>

						<div class="robo-lr-repeater" data-repeater="video">
							<div class="robo-lr-repeater-list">
								<?php foreach ( $video_resources as $index => $vid ) : ?>
									<div class="robo-lr-repeater-item">
										<span class="handle dashicons dashicons-move"></span>
										<div class="repeater-content">
											<div class="robo-lr-field-row">
												<div class="robo-lr-field" style="flex:1;">
													<label>Video Title</label>
													<input type="text" name="robo_lr_video_resources[<?php echo $index; ?>][title]" value="<?php echo esc_attr( isset( $vid['title'] ) ? $vid['title'] : '' ); ?>" class="widefat" required>
												</div>
												<div class="robo-lr-field" style="flex:2;">
													<label>Video URL (YouTube, Vimeo, MP4)</label>
													<input type="url" name="robo_lr_video_resources[<?php echo $index; ?>][url]" value="<?php echo esc_url( isset( $vid['url'] ) ? $vid['url'] : '' ); ?>" class="widefat" placeholder="https://www.youtube.com/watch?v=... or .mp4 URL" required>
												</div>
											</div>
										</div>
										<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-primary robo-lr-add-repeater-item" data-type="video">+ Add Video Resource</button>
						</div>
					</div>

					<!-- SECTION 5: GitHub Resources -->
					<div id="tab-github" class="robo-lr-tab-pane">
						<h3>Section 5: GitHub Resources</h3>
						<p class="description">Add code repositories associated with this learning resource.</p>

						<div class="robo-lr-repeater" data-repeater="github">
							<div class="robo-lr-repeater-list">
								<?php foreach ( $github_resources as $index => $gh ) : ?>
									<div class="robo-lr-repeater-item">
										<span class="handle dashicons dashicons-move"></span>
										<div class="repeater-content">
											<div class="robo-lr-field-row">
												<div class="robo-lr-field" style="flex:1;">
													<label>Repository Title</label>
													<input type="text" name="robo_lr_github_resources[<?php echo $index; ?>][title]" value="<?php echo esc_attr( isset( $gh['title'] ) ? $gh['title'] : '' ); ?>" class="widefat" required>
												</div>
												<div class="robo-lr-field" style="flex:2;">
													<label>Repository URL</label>
													<input type="url" name="robo_lr_github_resources[<?php echo $index; ?>][url]" value="<?php echo esc_url( isset( $gh['url'] ) ? $gh['url'] : '' ); ?>" class="widefat" placeholder="https://github.com/user/repo" required>
												</div>
											</div>
											<div class="robo-lr-field-group">
												<label>Short Description</label>
												<input type="text" name="robo_lr_github_resources[<?php echo $index; ?>][description]" value="<?php echo esc_attr( isset( $gh['description'] ) ? $gh['description'] : '' ); ?>" class="widefat">
											</div>
										</div>
										<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-primary robo-lr-add-repeater-item" data-type="github">+ Add Repository</button>
						</div>
					</div>

					<!-- SECTION 6: Downloads -->
					<div id="tab-downloads" class="robo-lr-tab-pane">
						<h3>Section 6: Downloads</h3>
						<p class="description">Add ZIP, RAR, Source Code, Firmware, Libraries, or Documents.</p>

						<div class="robo-lr-repeater" data-repeater="download">
							<div class="robo-lr-repeater-list">
								<?php foreach ( $downloads as $index => $dl ) : ?>
									<div class="robo-lr-repeater-item">
										<span class="handle dashicons dashicons-move"></span>
										<div class="repeater-content">
											<div class="robo-lr-field-row">
												<div class="robo-lr-field" style="flex:1;">
													<label>Title</label>
													<input type="text" name="robo_lr_downloads[<?php echo $index; ?>][title]" value="<?php echo esc_attr( isset( $dl['title'] ) ? $dl['title'] : '' ); ?>" class="widefat" required>
												</div>
												<div class="robo-lr-field" style="flex:2;">
													<label>Upload File</label>
													<div class="robo-lr-file-picker">
														<input type="hidden" name="robo_lr_downloads[<?php echo $index; ?>][file_id]" class="file-id" value="<?php echo esc_attr( isset( $dl['file_id'] ) ? $dl['file_id'] : '' ); ?>">
														<input type="text" name="robo_lr_downloads[<?php echo $index; ?>][file_url]" class="file-url widefat" value="<?php echo esc_url( isset( $dl['file_url'] ) ? $dl['file_url'] : '' ); ?>" placeholder="File URL">
														<button type="button" class="button robo-lr-file-upload-btn">Upload File</button>
													</div>
												</div>
											</div>
											<div class="robo-lr-field-group">
												<label>Description</label>
												<input type="text" name="robo_lr_downloads[<?php echo $index; ?>][description]" value="<?php echo esc_attr( isset( $dl['description'] ) ? $dl['description'] : '' ); ?>" class="widefat">
											</div>
										</div>
										<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-primary robo-lr-add-repeater-item" data-type="download">+ Add Download File</button>
						</div>
					</div>

					<!-- SECTION 7: Related Products (WooCommerce) -->
					<div id="tab-products" class="robo-lr-tab-pane">
						<h3>Section 7: Related Products (WooCommerce Integration)</h3>

						<?php if ( class_exists( 'WooCommerce' ) ) : ?>
							<p class="description">Search and select one or multiple WooCommerce products related to this resource.</p>

							<div class="robo-lr-wc-search-box">
								<div class="robo-lr-field-group">
									<label for="robo_lr_wc_search_input">Search WooCommerce Products</label>
									<input type="text" id="robo_lr_wc_search_input" placeholder="Type product name or SKU..." class="widefat">
									<ul id="robo_lr_wc_search_results" class="robo-lr-search-results-list"></ul>
								</div>

								<div class="robo-lr-selected-products">
									<h4>Selected Products</h4>
									<ul id="robo_lr_wc_selected_list" class="robo-lr-selected-list">
										<?php
										foreach ( array_filter( $related_wc_ids ) as $p_id ) {
											$product = wc_get_product( $p_id );
											if ( $product ) {
												printf(
													'<li data-id="%1$d">
														<span class="dashicons dashicons-move handle"></span>
														<input type="hidden" name="robo_lr_related_product_ids[]" value="%1$d">
														<strong>%2$s</strong> (ID: %1$d | %3$s)
														<span class="remove-wc-product" title="Remove">&times;</span>
													</li>',
													esc_attr( $p_id ),
													esc_html( $product->get_name() ),
													esc_html( wc_price( $product->get_price() ) )
												);
											}
										}
										?>
									</ul>
								</div>
							</div>
						<?php else : ?>
							<div class="notice notice-warning inline" style="margin:10px 0; padding:12px;">
								<p><strong>WooCommerce is currently disabled or not installed.</strong> This section is safely hidden on the frontend.</p>
							</div>
						<?php endif; ?>
					</div>

					<!-- SECTION 8: External Resources -->
					<div id="tab-external" class="robo-lr-tab-pane">
						<h3>Section 8: External Resources</h3>
						<p class="description">Link to official documentation, research papers, external blogs, or reference websites.</p>

						<div class="robo-lr-repeater" data-repeater="external">
							<div class="robo-lr-repeater-list">
								<?php foreach ( $external_res as $index => $ext ) : ?>
									<div class="robo-lr-repeater-item">
										<span class="handle dashicons dashicons-move"></span>
										<div class="repeater-content">
											<div class="robo-lr-field-row">
												<div class="robo-lr-field" style="flex:2;">
													<label>Title</label>
													<input type="text" name="robo_lr_external_resources[<?php echo $index; ?>][title]" value="<?php echo esc_attr( isset( $ext['title'] ) ? $ext['title'] : '' ); ?>" class="widefat" required>
												</div>
												<div class="robo-lr-field" style="flex:2;">
													<label>URL</label>
													<input type="url" name="robo_lr_external_resources[<?php echo $index; ?>][url]" value="<?php echo esc_url( isset( $ext['url'] ) ? $ext['url'] : '' ); ?>" class="widefat" required>
												</div>
												<div class="robo-lr-field" style="flex:1;">
													<label>Icon / Type</label>
													<select name="robo_lr_external_resources[<?php echo $index; ?>][icon]">
														<?php
														$curr_icon = isset( $ext['icon'] ) ? $ext['icon'] : 'book';
														$icons = array(
															'book'        => 'Documentation',
															'journal'     => 'Research Paper',
															'globe'       => 'Website',
															'newspaper'   => 'Blog',
															'bookmark-star' => 'Reference',
														);
														foreach ( $icons as $icon_key => $icon_label ) {
															printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $icon_key ), selected( $curr_icon, $icon_key, false ), esc_html( $icon_label ) );
														}
														?>
													</select>
												</div>
											</div>
											<div class="robo-lr-field-group">
												<label>Optional Description</label>
												<input type="text" name="robo_lr_external_resources[<?php echo $index; ?>][description]" value="<?php echo esc_attr( isset( $ext['description'] ) ? $ext['description'] : '' ); ?>" class="widefat">
											</div>
										</div>
										<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-primary robo-lr-add-repeater-item" data-type="external">+ Add External Resource</button>
						</div>
					</div>

					<!-- SECTION 9: Learning Outcomes -->
					<div id="tab-outcomes" class="robo-lr-tab-pane">
						<h3>Section 9: Learning Outcomes</h3>
						<p class="description">Specify key skills or knowledge gained (e.g., "Build Your First Robot", "Understand Sensors").</p>

						<div class="robo-lr-repeater" data-repeater="outcome">
							<div class="robo-lr-repeater-list">
								<?php foreach ( $outcomes as $index => $item ) : ?>
									<div class="robo-lr-repeater-item">
										<span class="handle dashicons dashicons-move"></span>
										<div class="repeater-content">
											<div class="robo-lr-field-group" style="margin:0;">
												<input type="text" name="robo_lr_outcomes[<?php echo $index; ?>][text]" value="<?php echo esc_attr( is_array( $item ) ? ( isset( $item['text'] ) ? $item['text'] : '' ) : $item ); ?>" class="widefat" placeholder="e.g. Learn Arduino Programming" required>
											</div>
										</div>
										<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-primary robo-lr-add-repeater-item" data-type="outcome">+ Add Learning Outcome</button>
						</div>
					</div>

					<!-- SECTION 10: Requirements -->
					<div id="tab-requirements" class="robo-lr-tab-pane">
						<h3>Section 10: Requirements</h3>
						<p class="description">Prerequisites or hardware needed (e.g., "Laptop", "Arduino UNO", "Breadboard").</p>

						<div class="robo-lr-repeater" data-repeater="requirement">
							<div class="robo-lr-repeater-list">
								<?php foreach ( $requirements as $index => $req ) : ?>
									<div class="robo-lr-repeater-item">
										<span class="handle dashicons dashicons-move"></span>
										<div class="repeater-content">
											<div class="robo-lr-field-group" style="margin:0;">
												<input type="text" name="robo_lr_requirements[<?php echo $index; ?>][text]" value="<?php echo esc_attr( is_array( $req ) ? ( isset( $req['text'] ) ? $req['text'] : '' ) : $req ); ?>" class="widefat" placeholder="e.g. Arduino UNO Microcontroller" required>
											</div>
										</div>
										<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-primary robo-lr-add-repeater-item" data-type="requirement">+ Add Requirement</button>
						</div>
					</div>

					<!-- SECTION 11: FAQs -->
					<div id="tab-faqs" class="robo-lr-tab-pane">
						<h3>Section 11: FAQs</h3>
						<p class="description">Frequently Asked Questions and Answers.</p>

						<div class="robo-lr-repeater" data-repeater="faq">
							<div class="robo-lr-repeater-list">
								<?php foreach ( $faqs as $index => $faq ) : ?>
									<div class="robo-lr-repeater-item">
										<span class="handle dashicons dashicons-move"></span>
										<div class="repeater-content">
											<div class="robo-lr-field-group">
												<label>Question</label>
												<input type="text" name="robo_lr_faqs[<?php echo $index; ?>][question]" value="<?php echo esc_attr( isset( $faq['question'] ) ? $faq['question'] : '' ); ?>" class="widefat" required>
											</div>
											<div class="robo-lr-field-group">
												<label>Answer</label>
												<textarea name="robo_lr_faqs[<?php echo $index; ?>][answer]" rows="2" class="widefat" required><?php echo esc_textarea( isset( $faq['answer'] ) ? $faq['answer'] : '' ); ?></textarea>
											</div>
										</div>
										<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-primary robo-lr-add-repeater-item" data-type="faq">+ Add FAQ</button>
						</div>
					</div>

					<!-- SECTION 12: SEO -->
					<div id="tab-seo" class="robo-lr-tab-pane">
						<h3>Section 12: SEO Settings</h3>

						<div class="robo-lr-field-group">
							<label for="robo_lr_meta_title">Meta Title</label>
							<input type="text" id="robo_lr_meta_title" name="robo_lr_meta_title" value="<?php echo esc_attr( $meta_title ); ?>" class="widefat" placeholder="Custom SEO Title">
						</div>

						<div class="robo-lr-field-group">
							<label for="robo_lr_meta_description">Meta Description</label>
							<textarea id="robo_lr_meta_description" name="robo_lr_meta_description" rows="3" class="widefat" placeholder="Custom SEO Meta Description..."><?php echo esc_textarea( $meta_desc ); ?></textarea>
						</div>

						<div class="robo-lr-field-group">
							<label>Open Graph Image</label>
							<div class="robo-lr-media-picker" data-field="robo_lr_og_image_id">
								<input type="hidden" name="robo_lr_og_image_id" class="robo-lr-media-id" value="<?php echo esc_attr( $og_image_id ); ?>">
								<div class="robo-lr-media-preview">
									<?php if ( $og_image_id ) : ?>
										<?php echo wp_get_attachment_image( $og_image_id, 'medium' ); ?>
									<?php else : ?>
										<span class="placeholder">No OG Image Selected</span>
									<?php endif; ?>
								</div>
								<button type="button" class="button robo-lr-upload-btn">Upload / Choose OG Image</button>
								<button type="button" class="button robo-lr-remove-btn" <?php echo ! $og_image_id ? 'style="display:none;"' : ''; ?>>Remove</button>
							</div>
						</div>

						<div class="robo-lr-field-group">
							<label for="robo_lr_canonical_url">Canonical URL</label>
							<input type="url" id="robo_lr_canonical_url" name="robo_lr_canonical_url" value="<?php echo esc_url( $canonical_url ); ?>" class="widefat" placeholder="https://example.com/original-url">
						</div>
					</div>

					<!-- SECTION 13: Attachments -->
					<div id="tab-attachments" class="robo-lr-tab-pane">
						<h3>Section 13: Attachments</h3>
						<p class="description">Upload multiple resource attachments (Images, PDF, ZIP, Documents, Source Code).</p>

						<div class="robo-lr-gallery-picker" data-type="attachments">
							<input type="hidden" name="robo_lr_attachment_ids" class="robo-lr-gallery-ids" value="<?php echo esc_attr( implode( ',', array_filter( $attachment_ids ) ) ); ?>">
							<div class="robo-lr-gallery-preview-grid">
								<?php
								foreach ( array_filter( $attachment_ids ) as $att_id ) {
									$title = get_the_title( $att_id );
									$url   = wp_get_attachment_url( $att_id );
									printf(
										'<div class="gallery-item file-item" data-id="%1$d">
											<span class="dashicons dashicons-paperclip"></span>
											<span class="file-name">%2$s</span>
											<span class="remove-item" title="Remove">&times;</span>
										</div>',
										esc_attr( $att_id ),
										esc_html( $title ? $title : basename( $url ) )
									);
								}
								?>
							</div>
							<button type="button" class="button robo-lr-add-attachments-btn">Upload / Choose Attachments</button>
						</div>
					</div>

					<!-- SECTION 14: Status Badges -->
					<div id="tab-badges" class="robo-lr-tab-pane">
						<h3>Section 14: Status Badges</h3>
						<p class="description">Select badges to highlight on resource cards and single page hero.</p>

						<div class="robo-lr-badges-grid">
							<label><input type="checkbox" name="robo_lr_badge_featured" value="1" <?php checked( $badge_featured, '1' ); ?>> <span class="badge-tag featured">Featured</span></label>
							<label><input type="checkbox" name="robo_lr_badge_popular" value="1" <?php checked( $badge_popular, '1' ); ?>> <span class="badge-tag popular">Popular</span></label>
							<label><input type="checkbox" name="robo_lr_badge_recommended" value="1" <?php checked( $badge_recommended, '1' ); ?>> <span class="badge-tag recommended">Recommended</span></label>
							<label><input type="checkbox" name="robo_lr_badge_new" value="1" <?php checked( $badge_new, '1' ); ?>> <span class="badge-tag new">New</span></label>
							<label><input type="checkbox" name="robo_lr_badge_trending" value="1" <?php checked( $badge_trending, '1' ); ?>> <span class="badge-tag trending">Trending</span></label>
						</div>
					</div>

				</div>
			</div>
			<?php
		}

		/**
		 * Save Meta Box Data with Sanitization and Nonce Checks
		 *
		 * @param int     $post_id Post ID.
		 * @param WP_Post $post    Post Object.
		 */
		public function save_meta_boxes( $post_id, $post ) {
			// Check Nonce
			if ( ! isset( $_POST['robo_lr_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['robo_lr_meta_box_nonce'], 'robo_lr_save_meta_box_data' ) ) {
				return;
			}

			// Check Autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// Check Capabilities
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			// SECTION 1: Basic Information
			if ( isset( $_POST['robo_lr_short_desc'] ) ) {
				update_post_meta( $post_id, '_robo_lr_short_desc', sanitize_textarea_field( $_POST['robo_lr_short_desc'] ) );
			}
			if ( isset( $_POST['robo_lr_difficulty'] ) ) {
				update_post_meta( $post_id, '_robo_lr_difficulty', sanitize_text_field( $_POST['robo_lr_difficulty'] ) );
			}
			if ( isset( $_POST['robo_lr_duration'] ) ) {
				update_post_meta( $post_id, '_robo_lr_duration', sanitize_text_field( $_POST['robo_lr_duration'] ) );
			}
			if ( isset( $_POST['robo_lr_instructor'] ) ) {
				update_post_meta( $post_id, '_robo_lr_instructor', sanitize_text_field( $_POST['robo_lr_instructor'] ) );
			}
			update_post_meta( $post_id, '_robo_lr_has_certificate', isset( $_POST['robo_lr_has_certificate'] ) ? '1' : '0' );

			// SECTION 2: Media
			if ( isset( $_POST['robo_lr_cover_image_id'] ) ) {
				update_post_meta( $post_id, '_robo_lr_cover_image_id', absint( $_POST['robo_lr_cover_image_id'] ) );
			}
			if ( isset( $_POST['robo_lr_list_image_id'] ) ) {
				update_post_meta( $post_id, '_robo_lr_list_image_id', absint( $_POST['robo_lr_list_image_id'] ) );
			}
			if ( isset( $_POST['robo_lr_gallery_image_ids'] ) ) {
				$g_ids = array_filter( array_map( 'absint', explode( ',', $_POST['robo_lr_gallery_image_ids'] ) ) );
				update_post_meta( $post_id, '_robo_lr_gallery_image_ids', $g_ids );
			}

			// SECTION 3: PDFs
			if ( isset( $_POST['robo_lr_pdf_resources'] ) && is_array( $_POST['robo_lr_pdf_resources'] ) ) {
				$clean_pdfs = array();
				foreach ( $_POST['robo_lr_pdf_resources'] as $item ) {
					if ( ! empty( $item['title'] ) ) {
						$clean_pdfs[] = array(
							'title'       => sanitize_text_field( $item['title'] ),
							'file_id'     => isset( $item['file_id'] ) ? absint( $item['file_id'] ) : 0,
							'file_url'    => isset( $item['file_url'] ) ? esc_url_raw( $item['file_url'] ) : '',
							'description' => isset( $item['description'] ) ? sanitize_text_field( $item['description'] ) : '',
						);
					}
				}
				update_post_meta( $post_id, '_robo_lr_pdf_resources', $clean_pdfs );
			} else {
				delete_post_meta( $post_id, '_robo_lr_pdf_resources' );
			}

			// SECTION 4: Videos
			if ( isset( $_POST['robo_lr_video_resources'] ) && is_array( $_POST['robo_lr_video_resources'] ) ) {
				$clean_videos = array();
				foreach ( $_POST['robo_lr_video_resources'] as $item ) {
					if ( ! empty( $item['title'] ) && ! empty( $item['url'] ) ) {
						$clean_videos[] = array(
							'title' => sanitize_text_field( $item['title'] ),
							'url'   => esc_url_raw( $item['url'] ),
						);
					}
				}
				update_post_meta( $post_id, '_robo_lr_video_resources', $clean_videos );
			} else {
				delete_post_meta( $post_id, '_robo_lr_video_resources' );
			}

			// SECTION 5: GitHub Resources
			if ( isset( $_POST['robo_lr_github_resources'] ) && is_array( $_POST['robo_lr_github_resources'] ) ) {
				$clean_gh = array();
				foreach ( $_POST['robo_lr_github_resources'] as $item ) {
					if ( ! empty( $item['title'] ) && ! empty( $item['url'] ) ) {
						$clean_gh[] = array(
							'title'       => sanitize_text_field( $item['title'] ),
							'url'         => esc_url_raw( $item['url'] ),
							'description' => isset( $item['description'] ) ? sanitize_text_field( $item['description'] ) : '',
						);
					}
				}
				update_post_meta( $post_id, '_robo_lr_github_resources', $clean_gh );
			} else {
				delete_post_meta( $post_id, '_robo_lr_github_resources' );
			}

			// SECTION 6: Downloads
			if ( isset( $_POST['robo_lr_downloads'] ) && is_array( $_POST['robo_lr_downloads'] ) ) {
				$clean_dl = array();
				foreach ( $_POST['robo_lr_downloads'] as $item ) {
					if ( ! empty( $item['title'] ) ) {
						$clean_dl[] = array(
							'title'       => sanitize_text_field( $item['title'] ),
							'file_id'     => isset( $item['file_id'] ) ? absint( $item['file_id'] ) : 0,
							'file_url'    => isset( $item['file_url'] ) ? esc_url_raw( $item['file_url'] ) : '',
							'description' => isset( $item['description'] ) ? sanitize_text_field( $item['description'] ) : '',
						);
					}
				}
				update_post_meta( $post_id, '_robo_lr_downloads', $clean_dl );
			} else {
				delete_post_meta( $post_id, '_robo_lr_downloads' );
			}

			// SECTION 7: Related WooCommerce Products
			if ( isset( $_POST['robo_lr_related_product_ids'] ) && is_array( $_POST['robo_lr_related_product_ids'] ) ) {
				$clean_wc = array_filter( array_map( 'absint', $_POST['robo_lr_related_product_ids'] ) );
				update_post_meta( $post_id, '_robo_lr_related_product_ids', $clean_wc );
			} else {
				delete_post_meta( $post_id, '_robo_lr_related_product_ids' );
			}

			// SECTION 8: External Resources
			if ( isset( $_POST['robo_lr_external_resources'] ) && is_array( $_POST['robo_lr_external_resources'] ) ) {
				$clean_ext = array();
				foreach ( $_POST['robo_lr_external_resources'] as $item ) {
					if ( ! empty( $item['title'] ) && ! empty( $item['url'] ) ) {
						$clean_ext[] = array(
							'title'       => sanitize_text_field( $item['title'] ),
							'url'         => esc_url_raw( $item['url'] ),
							'icon'        => isset( $item['icon'] ) ? sanitize_text_field( $item['icon'] ) : 'globe',
							'description' => isset( $item['description'] ) ? sanitize_text_field( $item['description'] ) : '',
						);
					}
				}
				update_post_meta( $post_id, '_robo_lr_external_resources', $clean_ext );
			} else {
				delete_post_meta( $post_id, '_robo_lr_external_resources' );
			}

			// SECTION 9: Outcomes
			if ( isset( $_POST['robo_lr_outcomes'] ) && is_array( $_POST['robo_lr_outcomes'] ) ) {
				$clean_outcomes = array();
				foreach ( $_POST['robo_lr_outcomes'] as $item ) {
					$txt = is_array( $item ) ? ( isset( $item['text'] ) ? $item['text'] : '' ) : $item;
					if ( ! empty( trim( $txt ) ) ) {
						$clean_outcomes[] = sanitize_text_field( $txt );
					}
				}
				update_post_meta( $post_id, '_robo_lr_outcomes', $clean_outcomes );
			} else {
				delete_post_meta( $post_id, '_robo_lr_outcomes' );
			}

			// SECTION 10: Requirements
			if ( isset( $_POST['robo_lr_requirements'] ) && is_array( $_POST['robo_lr_requirements'] ) ) {
				$clean_reqs = array();
				foreach ( $_POST['robo_lr_requirements'] as $item ) {
					$txt = is_array( $item ) ? ( isset( $item['text'] ) ? $item['text'] : '' ) : $item;
					if ( ! empty( trim( $txt ) ) ) {
						$clean_reqs[] = sanitize_text_field( $txt );
					}
				}
				update_post_meta( $post_id, '_robo_lr_requirements', $clean_reqs );
			} else {
				delete_post_meta( $post_id, '_robo_lr_requirements' );
			}

			// SECTION 11: FAQs
			if ( isset( $_POST['robo_lr_faqs'] ) && is_array( $_POST['robo_lr_faqs'] ) ) {
				$clean_faqs = array();
				foreach ( $_POST['robo_lr_faqs'] as $item ) {
					if ( ! empty( $item['question'] ) && ! empty( $item['answer'] ) ) {
						$clean_faqs[] = array(
							'question' => sanitize_text_field( $item['question'] ),
							'answer'   => sanitize_textarea_field( $item['answer'] ),
						);
					}
				}
				update_post_meta( $post_id, '_robo_lr_faqs', $clean_faqs );
			} else {
				delete_post_meta( $post_id, '_robo_lr_faqs' );
			}

			// SECTION 12: SEO
			if ( isset( $_POST['robo_lr_meta_title'] ) ) {
				update_post_meta( $post_id, '_robo_lr_meta_title', sanitize_text_field( $_POST['robo_lr_meta_title'] ) );
			}
			if ( isset( $_POST['robo_lr_meta_description'] ) ) {
				update_post_meta( $post_id, '_robo_lr_meta_description', sanitize_textarea_field( $_POST['robo_lr_meta_description'] ) );
			}
			if ( isset( $_POST['robo_lr_og_image_id'] ) ) {
				update_post_meta( $post_id, '_robo_lr_og_image_id', absint( $_POST['robo_lr_og_image_id'] ) );
			}
			if ( isset( $_POST['robo_lr_canonical_url'] ) ) {
				update_post_meta( $post_id, '_robo_lr_canonical_url', esc_url_raw( $_POST['robo_lr_canonical_url'] ) );
			}

			// SECTION 13: Attachments
			if ( isset( $_POST['robo_lr_attachment_ids'] ) ) {
				$att_ids = array_filter( array_map( 'absint', explode( ',', $_POST['robo_lr_attachment_ids'] ) ) );
				update_post_meta( $post_id, '_robo_lr_attachment_ids', $att_ids );
			}

			// SECTION 14: Badges
			update_post_meta( $post_id, '_robo_lr_badge_featured', isset( $_POST['robo_lr_badge_featured'] ) ? '1' : '0' );
			update_post_meta( $post_id, '_robo_lr_badge_popular', isset( $_POST['robo_lr_badge_popular'] ) ? '1' : '0' );
			update_post_meta( $post_id, '_robo_lr_badge_recommended', isset( $_POST['robo_lr_badge_recommended'] ) ? '1' : '0' );
			update_post_meta( $post_id, '_robo_lr_badge_new', isset( $_POST['robo_lr_badge_new'] ) ? '1' : '0' );
			update_post_meta( $post_id, '_robo_lr_badge_trending', isset( $_POST['robo_lr_badge_trending'] ) ? '1' : '0' );
		}
	}

	new Robo_Learning_Resources_Meta_Boxes();
}
