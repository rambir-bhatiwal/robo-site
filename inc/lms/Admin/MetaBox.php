<?php
/**
 * Admin Meta Box interface for Robo LMS.
 *
 * @package Robo\LMS\Admin
 */

namespace Robo\LMS\Admin;

use Robo\LMS\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MetaBox
 */
class MetaBox {

	/**
	 * Supported CPT slugs.
	 *
	 * @var array<string>
	 */
	private array $post_types = array(
		'learning-pdf',
		'learning-code',
		'learning-video',
	);

	/**
	 * Register hooks.
	 */
	public function register(): void {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Enqueue Admin CSS and JS assets on CPT edit screens.
	 *
	 * @param string $hook_suffix Current admin page hook.
	 */
	public function enqueue_admin_assets( string $hook_suffix ): void {
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen || ! in_array( $screen->post_type, $this->post_types, true ) ) {
			return;
		}

		// WP Media Uploader scripts
		wp_enqueue_media();

		// jQuery UI Sortable for repeaters
		wp_enqueue_script( 'jquery-ui-sortable' );

		// Admin CSS
		wp_enqueue_style(
			'robo-lms-admin-style',
			ROBO_THEME_URI . '/assets/css/lms-admin.css',
			array(),
			ROBO_THEME_VERSION
		);

		// Admin JS
		wp_enqueue_script(
			'robo-lms-admin-js',
			ROBO_THEME_URI . '/assets/js/lms-admin.js',
			array( 'jquery', 'jquery-ui-sortable' ),
			ROBO_THEME_VERSION,
			true
		);

		wp_localize_script(
			'robo-lms-admin-js',
			'roboLMSAdmin',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'robo_lms_admin_nonce' ),
				'i18n'    => array(
					'selectFile'   => __( 'Select File', 'robo' ),
					'selectImage'  => __( 'Select Image', 'robo' ),
					'useFile'      => __( 'Use This File', 'robo' ),
					'useImage'     => __( 'Use This Image', 'robo' ),
					'confirmDelete'=> __( 'Are you sure you want to remove this item?', 'robo' ),
				),
			)
		);
	}

	/**
	 * Add Meta Box to Learning CPTs.
	 */
	public function add_meta_boxes(): void {
		foreach ( $this->post_types as $post_type ) {
			add_meta_box(
				'robo_lms_meta_box',
				__( 'Learning Resource Settings', 'robo' ),
				array( $this, 'render_meta_box' ),
				$post_type,
				'normal',
				'high'
			);
		}
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param \WP_Post $post Current post object.
	 */
	public function render_meta_box( \WP_Post $post ): void {
		wp_nonce_field( 'robo_lms_save_meta', 'robo_lms_meta_nonce' );

		$post_type = $post->post_type;

		// Fetch stored values
		$short_desc  = get_post_meta( $post->ID, '_robo_lms_short_description', true );
		$difficulty  = get_post_meta( $post->ID, '_robo_lms_difficulty', true );
		$duration    = get_post_meta( $post->ID, '_robo_lms_estimated_duration', true );
		$thumbnail_id= get_post_meta( $post->ID, '_robo_lms_thumbnail_id', true );
		$banner_id   = get_post_meta( $post->ID, '_robo_lms_banner_id', true );
		$is_featured = get_post_meta( $post->ID, '_robo_lms_is_featured', true );
		$is_recom    = get_post_meta( $post->ID, '_robo_lms_is_recommended', true );

		$rel_pdfs    = Helper::sanitize_post_ids( get_post_meta( $post->ID, '_robo_lms_related_pdfs', true ) );
		$rel_code    = Helper::sanitize_post_ids( get_post_meta( $post->ID, '_robo_lms_related_code', true ) );
		$rel_videos  = Helper::sanitize_post_ids( get_post_meta( $post->ID, '_robo_lms_related_videos', true ) );
		$rel_prods   = Helper::sanitize_post_ids( get_post_meta( $post->ID, '_robo_lms_related_products', true ) );

		$thumb_url   = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' ) : '';
		$banner_url  = $banner_id ? wp_get_attachment_image_url( $banner_id, 'medium' ) : '';

		?>
		<div class="robo-lms-metabox-wrapper">
			<!-- Meta Box Header / Tabs Navigation -->
			<ul class="robo-lms-tabs">
				<li class="robo-lms-tab-item active" data-tab="tab-general">
					<span class="dashicons dashicons-admin-generic"></span> <?php esc_html_e( 'General Details', 'robo' ); ?>
				</li>
				<li class="robo-lms-tab-item" data-tab="tab-resources">
					<span class="dashicons dashicons-list-view"></span>
					<?php
					if ( 'learning-pdf' === $post_type ) {
						esc_html_e( 'PDF Resources Repeater', 'robo' );
					} elseif ( 'learning-code' === $post_type ) {
						esc_html_e( 'Code Resources Repeater', 'robo' );
					} else {
						esc_html_e( 'Video Resources Repeater', 'robo' );
					}
					?>
				</li>
				<li class="robo-lms-tab-item" data-tab="tab-relationships">
					<span class="dashicons dashicons-share"></span> <?php esc_html_e( 'Related Resources', 'robo' ); ?>
				</li>
			</ul>

			<div class="robo-lms-tab-contents">
				<!-- TAB 1: GENERAL DETAILS -->
				<div class="robo-lms-tab-content active" id="tab-general">
					<div class="robo-lms-field-group">
						<label for="robo_lms_short_description" class="robo-lms-label"><?php esc_html_e( 'Short Description', 'robo' ); ?></label>
						<textarea id="robo_lms_short_description" name="_robo_lms_short_description" rows="3" class="widefat"><?php echo esc_textarea( $short_desc ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Brief summary displayed on cards and hero headers.', 'robo' ); ?></p>
					</div>

					<div class="robo-lms-field-row">
						<div class="robo-lms-field-col">
							<label for="robo_lms_difficulty" class="robo-lms-label"><?php esc_html_e( 'Difficulty Level', 'robo' ); ?></label>
							<select id="robo_lms_difficulty" name="_robo_lms_difficulty" class="widefat">
								<option value=""><?php esc_html_e( '-- Select Difficulty --', 'robo' ); ?></option>
								<?php foreach ( Helper::get_difficulty_options() as $val => $label ) : ?>
									<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $difficulty, $val ); ?>><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="robo-lms-field-col">
							<label for="robo_lms_estimated_duration" class="robo-lms-label"><?php esc_html_e( 'Estimated Duration', 'robo' ); ?></label>
							<input type="text" id="robo_lms_estimated_duration" name="_robo_lms_estimated_duration" value="<?php echo esc_attr( $duration ); ?>" placeholder="<?php esc_attr_e( 'e.g. 2 Hours, 45 Mins', 'robo' ); ?>" class="widefat" />
						</div>
					</div>

					<div class="robo-lms-field-row robo-lms-checkboxes">
						<label class="robo-lms-checkbox-label">
							<input type="checkbox" name="_robo_lms_is_featured" value="1" <?php checked( $is_featured, '1' ); ?> />
							<strong><?php esc_html_e( 'Featured Badge', 'robo' ); ?></strong>
						</label>
						<label class="robo-lms-checkbox-label">
							<input type="checkbox" name="_robo_lms_is_recommended" value="1" <?php checked( $is_recom, '1' ); ?> />
							<strong><?php esc_html_e( 'Recommended Badge', 'robo' ); ?></strong>
						</label>
					</div>

					<div class="robo-lms-field-row">
						<!-- Thumbnail Image Upload -->
						<div class="robo-lms-field-col">
							<label class="robo-lms-label"><?php esc_html_e( 'Custom Thumbnail Image', 'robo' ); ?></label>
							<div class="robo-lms-media-uploader" data-type="image">
								<input type="hidden" name="_robo_lms_thumbnail_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" class="robo-lms-media-id" />
								<div class="robo-lms-media-preview">
									<?php if ( $thumb_url ) : ?>
										<img src="<?php echo esc_url( $thumb_url ); ?>" alt="Thumbnail Preview" />
									<?php endif; ?>
								</div>
								<button type="button" class="button robo-lms-upload-btn"><?php esc_html_e( 'Upload Thumbnail', 'robo' ); ?></button>
								<button type="button" class="button button-link-delete robo-lms-remove-media-btn" style="<?php echo $thumb_url ? 'display:inline-block;' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'robo' ); ?></button>
							</div>
						</div>

						<!-- Banner Image Upload -->
						<div class="robo-lms-field-col">
							<label class="robo-lms-label"><?php esc_html_e( 'Custom Banner Image', 'robo' ); ?></label>
							<div class="robo-lms-media-uploader" data-type="image">
								<input type="hidden" name="_robo_lms_banner_id" value="<?php echo esc_attr( $banner_id ); ?>" class="robo-lms-media-id" />
								<div class="robo-lms-media-preview">
									<?php if ( $banner_url ) : ?>
										<img src="<?php echo esc_url( $banner_url ); ?>" alt="Banner Preview" />
									<?php endif; ?>
								</div>
								<button type="button" class="button robo-lms-upload-btn"><?php esc_html_e( 'Upload Banner', 'robo' ); ?></button>
								<button type="button" class="button button-link-delete robo-lms-remove-media-btn" style="<?php echo $banner_url ? 'display:inline-block;' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'robo' ); ?></button>
							</div>
						</div>
					</div>
				</div>

				<!-- TAB 2: REPEATERS -->
				<div class="robo-lms-tab-content" id="tab-resources">
					<?php
					if ( 'learning-pdf' === $post_type ) {
						$this->render_pdf_repeater( $post->ID );
					} elseif ( 'learning-code' === $post_type ) {
						$this->render_code_repeater( $post->ID );
					} elseif ( 'learning-video' === $post_type ) {
						$this->render_video_repeater( $post->ID );
					}
					?>
				</div>

				<!-- TAB 3: RELATIONSHIPS -->
				<div class="robo-lms-tab-content" id="tab-relationships">
					<?php $this->render_relationships( $post_type, $rel_pdfs, $rel_code, $rel_videos, $rel_prods ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render PDF Resources Repeater.
	 *
	 * @param int $post_id Post ID.
	 */
	private function render_pdf_repeater( int $post_id ): void {
		$items = get_post_meta( $post_id, '_robo_lms_pdf_resources', true );
		if ( ! is_array( $items ) ) {
			$items = array();
		}
		?>
		<div class="robo-lms-repeater" data-cpt="learning-pdf">
			<div class="robo-lms-repeater-rows">
				<?php
				if ( ! empty( $items ) ) {
					foreach ( $items as $index => $item ) {
						$this->render_pdf_row( $index, $item );
					}
				}
				?>
			</div>

			<template class="robo-lms-row-template">
				<?php $this->render_pdf_row( '{{INDEX}}', array() ); ?>
			</template>

			<button type="button" class="button button-primary robo-lms-add-row-btn">
				<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add PDF Resource', 'robo' ); ?>
			</button>
		</div>
		<?php
	}

	/**
	 * Render Single PDF Row.
	 *
	 * @param int|string $index Row index.
	 * @param array      $item Item data.
	 */
	private function render_pdf_row( $index, array $item ): void {
		$title       = $item['title'] ?? '';
		$desc        = $item['description'] ?? '';
		$file_id     = $item['file_id'] ?? 0;
		$file_url    = $item['file_url'] ?? '';
		$preview_id  = $item['preview_id'] ?? 0;
		$preview_url = $item['preview_url'] ?? '';
		$button_text = $item['button_text'] ?? __( 'Download PDF', 'robo' );
		$order       = $item['order'] ?? $index;
		?>
		<div class="robo-lms-repeater-row" data-index="<?php echo esc_attr( $index ); ?>">
			<div class="robo-lms-row-header">
				<span class="dashicons dashicons-menu robo-lms-drag-handle" title="<?php esc_attr_e( 'Drag to reorder', 'robo' ); ?>"></span>
				<strong class="robo-lms-row-title"><?php echo $title ? esc_html( $title ) : esc_html__( 'PDF Resource Item', 'robo' ); ?></strong>
				<div class="robo-lms-row-actions">
					<button type="button" class="button button-small robo-lms-duplicate-row" title="<?php esc_attr_e( 'Duplicate', 'robo' ); ?>"><span class="dashicons dashicons-admin-page"></span></button>
					<button type="button" class="button button-small button-link-delete robo-lms-remove-row" title="<?php esc_attr_e( 'Remove', 'robo' ); ?>"><span class="dashicons dashicons-trash"></span></button>
				</div>
			</div>

			<div class="robo-lms-row-body">
				<input type="hidden" class="robo-lms-order-input" name="_robo_lms_pdf_resources[<?php echo esc_attr( $index ); ?>][order]" value="<?php echo esc_attr( $order ); ?>" />

				<div class="robo-lms-field-row">
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'PDF Title', 'robo' ); ?></label>
						<input type="text" name="_robo_lms_pdf_resources[<?php echo esc_attr( $index ); ?>][title]" value="<?php echo esc_attr( $title ); ?>" class="widefat robo-lms-title-input" />
					</div>
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'Download Button Text', 'robo' ); ?></label>
						<input type="text" name="_robo_lms_pdf_resources[<?php echo esc_attr( $index ); ?>][button_text]" value="<?php echo esc_attr( $button_text ); ?>" class="widefat" />
					</div>
				</div>

				<div class="robo-lms-field-group">
					<label class="robo-lms-label"><?php esc_html_e( 'PDF Description', 'robo' ); ?></label>
					<textarea name="_robo_lms_pdf_resources[<?php echo esc_attr( $index ); ?>][description]" rows="2" class="widefat"><?php echo esc_textarea( $desc ); ?></textarea>
				</div>

				<div class="robo-lms-field-row">
					<!-- PDF Upload -->
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'PDF File Upload', 'robo' ); ?></label>
						<div class="robo-lms-media-uploader" data-type="pdf">
							<input type="hidden" name="_robo_lms_pdf_resources[<?php echo esc_attr( $index ); ?>][file_id]" value="<?php echo esc_attr( $file_id ); ?>" class="robo-lms-media-id" />
							<input type="text" name="_robo_lms_pdf_resources[<?php echo esc_attr( $index ); ?>][file_url]" value="<?php echo esc_url( $file_url ); ?>" class="widefat robo-lms-media-url" placeholder="<?php esc_attr_e( 'PDF File URL', 'robo' ); ?>" />
							<button type="button" class="button robo-lms-upload-btn mt-1"><?php esc_html_e( 'Upload PDF', 'robo' ); ?></button>
						</div>
					</div>

					<!-- Preview Image -->
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'Preview Image', 'robo' ); ?></label>
						<div class="robo-lms-media-uploader" data-type="image">
							<input type="hidden" name="_robo_lms_pdf_resources[<?php echo esc_attr( $index ); ?>][preview_id]" value="<?php echo esc_attr( $preview_id ); ?>" class="robo-lms-media-id" />
							<input type="hidden" name="_robo_lms_pdf_resources[<?php echo esc_attr( $index ); ?>][preview_url]" value="<?php echo esc_url( $preview_url ); ?>" class="robo-lms-media-url" />
							<div class="robo-lms-media-preview">
								<?php if ( $preview_url ) : ?>
									<img src="<?php echo esc_url( $preview_url ); ?>" alt="Preview" />
								<?php endif; ?>
							</div>
							<button type="button" class="button robo-lms-upload-btn"><?php esc_html_e( 'Upload Preview Image', 'robo' ); ?></button>
							<button type="button" class="button button-link-delete robo-lms-remove-media-btn" style="<?php echo $preview_url ? 'display:inline-block;' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'robo' ); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Source Code Resources Repeater.
	 *
	 * @param int $post_id Post ID.
	 */
	private function render_code_repeater( int $post_id ): void {
		$items = get_post_meta( $post_id, '_robo_lms_code_resources', true );
		if ( ! is_array( $items ) ) {
			$items = array();
		}
		?>
		<div class="robo-lms-repeater" data-cpt="learning-code">
			<div class="robo-lms-repeater-rows">
				<?php
				if ( ! empty( $items ) ) {
					foreach ( $items as $index => $item ) {
						$this->render_code_row( $index, $item );
					}
				}
				?>
			</div>

			<template class="robo-lms-row-template">
				<?php $this->render_code_row( '{{INDEX}}', array() ); ?>
			</template>

			<button type="button" class="button button-primary robo-lms-add-row-btn">
				<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Code Resource', 'robo' ); ?>
			</button>
		</div>
		<?php
	}

	/**
	 * Render Single Code Row.
	 *
	 * @param int|string $index Row index.
	 * @param array      $item Item data.
	 */
	private function render_code_row( $index, array $item ): void {
		$title       = $item['title'] ?? '';
		$desc        = $item['description'] ?? '';
		$repo_url    = $item['repo_url'] ?? '';
		$file_id     = $item['file_id'] ?? 0;
		$file_url    = $item['file_url'] ?? '';
		$preview_id  = $item['preview_id'] ?? 0;
		$preview_url = $item['preview_url'] ?? '';
		$language    = $item['language'] ?? 'other';
		$order       = $item['order'] ?? $index;
		?>
		<div class="robo-lms-repeater-row" data-index="<?php echo esc_attr( $index ); ?>">
			<div class="robo-lms-row-header">
				<span class="dashicons dashicons-menu robo-lms-drag-handle" title="<?php esc_attr_e( 'Drag to reorder', 'robo' ); ?>"></span>
				<strong class="robo-lms-row-title"><?php echo $title ? esc_html( $title ) : esc_html__( 'Code Resource Item', 'robo' ); ?></strong>
				<div class="robo-lms-row-actions">
					<button type="button" class="button button-small robo-lms-duplicate-row" title="<?php esc_attr_e( 'Duplicate', 'robo' ); ?>"><span class="dashicons dashicons-admin-page"></span></button>
					<button type="button" class="button button-small button-link-delete robo-lms-remove-row" title="<?php esc_attr_e( 'Remove', 'robo' ); ?>"><span class="dashicons dashicons-trash"></span></button>
				</div>
			</div>

			<div class="robo-lms-row-body">
				<input type="hidden" class="robo-lms-order-input" name="_robo_lms_code_resources[<?php echo esc_attr( $index ); ?>][order]" value="<?php echo esc_attr( $order ); ?>" />

				<div class="robo-lms-field-row">
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'Code Title', 'robo' ); ?></label>
						<input type="text" name="_robo_lms_code_resources[<?php echo esc_attr( $index ); ?>][title]" value="<?php echo esc_attr( $title ); ?>" class="widefat robo-lms-title-input" />
					</div>
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'Programming Language', 'robo' ); ?></label>
						<select name="_robo_lms_code_resources[<?php echo esc_attr( $index ); ?>][language]" class="widefat">
							<?php foreach ( Helper::get_language_options() as $lang_key => $lang_name ) : ?>
								<option value="<?php echo esc_attr( $lang_key ); ?>" <?php selected( $language, $lang_key ); ?>><?php echo esc_html( $lang_name ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="robo-lms-field-group">
					<label class="robo-lms-label"><?php esc_html_e( 'Code Description', 'robo' ); ?></label>
					<textarea name="_robo_lms_code_resources[<?php echo esc_attr( $index ); ?>][description]" rows="2" class="widefat"><?php echo esc_textarea( $desc ); ?></textarea>
				</div>

				<div class="robo-lms-field-row">
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'Repository URL (GitHub / GitLab / Bitbucket)', 'robo' ); ?></label>
						<input type="url" name="_robo_lms_code_resources[<?php echo esc_attr( $index ); ?>][repo_url]" value="<?php echo esc_url( $repo_url ); ?>" placeholder="https://github.com/user/repository" class="widefat" />
					</div>
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'ZIP/RAR Archive Upload (Optional)', 'robo' ); ?></label>
						<div class="robo-lms-media-uploader" data-type="archive">
							<input type="hidden" name="_robo_lms_code_resources[<?php echo esc_attr( $index ); ?>][file_id]" value="<?php echo esc_attr( $file_id ); ?>" class="robo-lms-media-id" />
							<input type="text" name="_robo_lms_code_resources[<?php echo esc_attr( $index ); ?>][file_url]" value="<?php echo esc_url( $file_url ); ?>" class="widefat robo-lms-media-url" placeholder="<?php esc_attr_e( 'ZIP File URL', 'robo' ); ?>" />
							<button type="button" class="button robo-lms-upload-btn mt-1"><?php esc_html_e( 'Upload Archive', 'robo' ); ?></button>
						</div>
					</div>
				</div>

				<div class="robo-lms-field-group">
					<label class="robo-lms-label"><?php esc_html_e( 'Preview Image', 'robo' ); ?></label>
					<div class="robo-lms-media-uploader" data-type="image">
						<input type="hidden" name="_robo_lms_code_resources[<?php echo esc_attr( $index ); ?>][preview_id]" value="<?php echo esc_attr( $preview_id ); ?>" class="robo-lms-media-id" />
						<input type="hidden" name="_robo_lms_code_resources[<?php echo esc_attr( $index ); ?>][preview_url]" value="<?php echo esc_url( $preview_url ); ?>" class="robo-lms-media-url" />
						<div class="robo-lms-media-preview">
							<?php if ( $preview_url ) : ?>
								<img src="<?php echo esc_url( $preview_url ); ?>" alt="Preview" />
							<?php endif; ?>
						</div>
						<button type="button" class="button robo-lms-upload-btn"><?php esc_html_e( 'Upload Preview Image', 'robo' ); ?></button>
						<button type="button" class="button button-link-delete robo-lms-remove-media-btn" style="<?php echo $preview_url ? 'display:inline-block;' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'robo' ); ?></button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Video Resources Repeater.
	 *
	 * @param int $post_id Post ID.
	 */
	private function render_video_repeater( int $post_id ): void {
		$items = get_post_meta( $post_id, '_robo_lms_video_resources', true );
		if ( ! is_array( $items ) ) {
			$items = array();
		}
		?>
		<div class="robo-lms-repeater" data-cpt="learning-video">
			<div class="robo-lms-repeater-rows">
				<?php
				if ( ! empty( $items ) ) {
					foreach ( $items as $index => $item ) {
						$this->render_video_row( $index, $item );
					}
				}
				?>
			</div>

			<template class="robo-lms-row-template">
				<?php $this->render_video_row( '{{INDEX}}', array() ); ?>
			</template>

			<button type="button" class="button button-primary robo-lms-add-row-btn">
				<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Video Resource', 'robo' ); ?>
			</button>
		</div>
		<?php
	}

	/**
	 * Render Single Video Row.
	 *
	 * @param int|string $index Row index.
	 * @param array      $item Item data.
	 */
	private function render_video_row( $index, array $item ): void {
		$title        = $item['title'] ?? '';
		$desc         = $item['description'] ?? '';
		$video_url    = $item['video_url'] ?? '';
		$thumb_id     = $item['thumbnail_id'] ?? 0;
		$thumb_url    = $item['thumbnail_url'] ?? '';
		$duration     = $item['duration'] ?? '';
		$order        = $item['order'] ?? $index;
		?>
		<div class="robo-lms-repeater-row" data-index="<?php echo esc_attr( $index ); ?>">
			<div class="robo-lms-row-header">
				<span class="dashicons dashicons-menu robo-lms-drag-handle" title="<?php esc_attr_e( 'Drag to reorder', 'robo' ); ?>"></span>
				<strong class="robo-lms-row-title"><?php echo $title ? esc_html( $title ) : esc_html__( 'Video Resource Item', 'robo' ); ?></strong>
				<div class="robo-lms-row-actions">
					<button type="button" class="button button-small robo-lms-duplicate-row" title="<?php esc_attr_e( 'Duplicate', 'robo' ); ?>"><span class="dashicons dashicons-admin-page"></span></button>
					<button type="button" class="button button-small button-link-delete robo-lms-remove-row" title="<?php esc_attr_e( 'Remove', 'robo' ); ?>"><span class="dashicons dashicons-trash"></span></button>
				</div>
			</div>

			<div class="robo-lms-row-body">
				<input type="hidden" class="robo-lms-order-input" name="_robo_lms_video_resources[<?php echo esc_attr( $index ); ?>][order]" value="<?php echo esc_attr( $order ); ?>" />

				<div class="robo-lms-field-row">
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'Video Title', 'robo' ); ?></label>
						<input type="text" name="_robo_lms_video_resources[<?php echo esc_attr( $index ); ?>][title]" value="<?php echo esc_attr( $title ); ?>" class="widefat robo-lms-title-input" />
					</div>
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'Duration', 'robo' ); ?></label>
						<input type="text" name="_robo_lms_video_resources[<?php echo esc_attr( $index ); ?>][duration]" value="<?php echo esc_attr( $duration ); ?>" placeholder="<?php esc_attr_e( 'e.g. 15:30 or 20 Mins', 'robo' ); ?>" class="widefat" />
					</div>
				</div>

				<div class="robo-lms-field-group">
					<label class="robo-lms-label"><?php esc_html_e( 'Video Description', 'robo' ); ?></label>
					<textarea name="_robo_lms_video_resources[<?php echo esc_attr( $index ); ?>][description]" rows="2" class="widefat"><?php echo esc_textarea( $desc ); ?></textarea>
				</div>

				<div class="robo-lms-field-row">
					<!-- Video URL -->
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'Video URL (YouTube / Vimeo / MP4)', 'robo' ); ?></label>
						<input type="url" name="_robo_lms_video_resources[<?php echo esc_attr( $index ); ?>][video_url]" value="<?php echo esc_url( $video_url ); ?>" placeholder="https://www.youtube.com/watch?v=..." class="widefat" />
					</div>

					<!-- Thumbnail Image -->
					<div class="robo-lms-field-col">
						<label class="robo-lms-label"><?php esc_html_e( 'Video Thumbnail Image', 'robo' ); ?></label>
						<div class="robo-lms-media-uploader" data-type="image">
							<input type="hidden" name="_robo_lms_video_resources[<?php echo esc_attr( $index ); ?>][thumbnail_id]" value="<?php echo esc_attr( $thumb_id ); ?>" class="robo-lms-media-id" />
							<input type="hidden" name="_robo_lms_video_resources[<?php echo esc_attr( $index ); ?>][thumbnail_url]" value="<?php echo esc_url( $thumb_url ); ?>" class="robo-lms-media-url" />
							<div class="robo-lms-media-preview">
								<?php if ( $thumb_url ) : ?>
									<img src="<?php echo esc_url( $thumb_url ); ?>" alt="Thumbnail" />
								<?php endif; ?>
							</div>
							<button type="button" class="button robo-lms-upload-btn"><?php esc_html_e( 'Upload Thumbnail', 'robo' ); ?></button>
							<button type="button" class="button button-link-delete robo-lms-remove-media-btn" style="<?php echo $thumb_url ? 'display:inline-block;' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'robo' ); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Relationship multi-select fields.
	 *
	 * @param string      $current_cpt Current CPT slug.
	 * @param array<int>  $rel_pdfs Selected PDF IDs.
	 * @param array<int>  $rel_code Selected Code IDs.
	 * @param array<int>  $rel_videos Selected Video IDs.
	 * @param array<int>  $rel_prods Selected WooCommerce Product IDs.
	 */
	private function render_relationships( string $current_cpt, array $rel_pdfs, array $rel_code, array $rel_videos, array $rel_prods ): void {
		?>
		<div class="robo-lms-relationships-container">
			<?php if ( 'learning-pdf' !== $current_cpt ) : ?>
				<div class="robo-lms-field-group">
					<label class="robo-lms-label"><?php esc_html_e( 'Related PDF Resources', 'robo' ); ?></label>
					<?php $this->render_post_select_field( '_robo_lms_related_pdfs', 'learning-pdf', $rel_pdfs, __( 'Search & Select PDFs...', 'robo' ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( 'learning-code' !== $current_cpt ) : ?>
				<div class="robo-lms-field-group">
					<label class="robo-lms-label"><?php esc_html_e( 'Related Source Code', 'robo' ); ?></label>
					<?php $this->render_post_select_field( '_robo_lms_related_code', 'learning-code', $rel_code, __( 'Search & Select Source Code...', 'robo' ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( 'learning-video' !== $current_cpt ) : ?>
				<div class="robo-lms-field-group">
					<label class="robo-lms-label"><?php esc_html_e( 'Related Learning Videos', 'robo' ); ?></label>
					<?php $this->render_post_select_field( '_robo_lms_related_videos', 'learning-video', $rel_videos, __( 'Search & Select Videos...', 'robo' ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<div class="robo-lms-field-group">
					<label class="robo-lms-label"><?php esc_html_e( 'Related WooCommerce Products', 'robo' ); ?></label>
					<?php $this->render_post_select_field( '_robo_lms_related_products', 'product', $rel_prods, __( 'Search & Select Products...', 'robo' ) ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Helper to render multi-select list field for relationships.
	 *
	 * @param string     $meta_name Hidden input name.
	 * @param string     $post_type Post type slug to load posts from.
	 * @param array<int> $selected Selected post IDs.
	 * @param string     $placeholder Placeholder string.
	 */
	private function render_post_select_field( string $meta_name, string $post_type, array $selected, string $placeholder ): void {
		// Fetch posts for options
		$posts = get_posts(
			array(
				'post_type'      => $post_type,
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
		?>
		<div class="robo-lms-multi-select-box" data-post-type="<?php echo esc_attr( $post_type ); ?>">
			<select name="<?php echo esc_attr( $meta_name ); ?>[]" multiple="multiple" class="robo-lms-select2 widefat" data-placeholder="<?php echo esc_attr( $placeholder ); ?>">
				<?php foreach ( $posts as $p ) : ?>
					<option value="<?php echo esc_attr( $p->ID ); ?>" <?php echo in_array( (int) $p->ID, $selected, true ) ? 'selected="selected"' : ''; ?>>
						<?php echo esc_html( $p->post_title ); ?> (ID: <?php echo esc_html( $p->ID ); ?>)
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php
	}
}
