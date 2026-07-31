<?php
/**
 * Save Handler for Robo LMS Meta Boxes.
 *
 * @package Robo\LMS\Admin
 */

namespace Robo\LMS\Admin;

use Robo\LMS\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class SaveHandler
 */
class SaveHandler {

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
	 * Register save_post hook.
	 */
	public function register(): void {
		add_action( 'save_post', array( $this, 'save_post_meta' ), 10, 2 );
	}

	/**
	 * Save Post Meta fields.
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post Post object.
	 */
	public function save_post_meta( int $post_id, \WP_Post $post ): void {
		// 1. Verify Nonce
		if ( ! isset( $_POST['robo_lms_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['robo_lms_meta_nonce'] ), 'robo_lms_save_meta' ) ) {
			return;
		}

		// 2. Autosave check
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// 3. Post type check
		if ( ! in_array( $post->post_type, $this->post_types, true ) ) {
			return;
		}

		// 4. Capability check
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// --- SAVE COMMON META FIELDS ---
		$short_desc = isset( $_POST['_robo_lms_short_description'] )
			? sanitize_textarea_field( wp_unslash( $_POST['_robo_lms_short_description'] ) )
			: '';
		update_post_meta( $post_id, '_robo_lms_short_description', $short_desc );

		$difficulty = isset( $_POST['_robo_lms_difficulty'] )
			? sanitize_key( wp_unslash( $_POST['_robo_lms_difficulty'] ) )
			: '';
		update_post_meta( $post_id, '_robo_lms_difficulty', $difficulty );

		$duration = isset( $_POST['_robo_lms_estimated_duration'] )
			? sanitize_text_field( wp_unslash( $_POST['_robo_lms_estimated_duration'] ) )
			: '';
		update_post_meta( $post_id, '_robo_lms_estimated_duration', $duration );

		$thumb_id = isset( $_POST['_robo_lms_thumbnail_id'] )
			? absint( $_POST['_robo_lms_thumbnail_id'] )
			: 0;
		update_post_meta( $post_id, '_robo_lms_thumbnail_id', $thumb_id );

		$banner_id = isset( $_POST['_robo_lms_banner_id'] )
			? absint( $_POST['_robo_lms_banner_id'] )
			: 0;
		update_post_meta( $post_id, '_robo_lms_banner_id', $banner_id );

		$is_featured = isset( $_POST['_robo_lms_is_featured'] ) ? '1' : '0';
		update_post_meta( $post_id, '_robo_lms_is_featured', $is_featured );

		$is_recommended = isset( $_POST['_robo_lms_is_recommended'] ) ? '1' : '0';
		update_post_meta( $post_id, '_robo_lms_is_recommended', $is_recommended );

		// --- SAVE REPEATERS ---
		if ( 'learning-pdf' === $post->post_type ) {
			$raw_pdf = isset( $_POST['_robo_lms_pdf_resources'] ) && is_array( $_POST['_robo_lms_pdf_resources'] )
				? wp_unslash( $_POST['_robo_lms_pdf_resources'] )
				: array();
			$clean_pdf = Helper::sanitize_repeater_data( $raw_pdf, 'learning-pdf' );
			update_post_meta( $post_id, '_robo_lms_pdf_resources', $clean_pdf );
		}

		if ( 'learning-code' === $post->post_type ) {
			$raw_code = isset( $_POST['_robo_lms_code_resources'] ) && is_array( $_POST['_robo_lms_code_resources'] )
				? wp_unslash( $_POST['_robo_lms_code_resources'] )
				: array();
			$clean_code = Helper::sanitize_repeater_data( $raw_code, 'learning-code' );
			update_post_meta( $post_id, '_robo_lms_code_resources', $clean_code );
		}

		if ( 'learning-video' === $post->post_type ) {
			$raw_video = isset( $_POST['_robo_lms_video_resources'] ) && is_array( $_POST['_robo_lms_video_resources'] )
				? wp_unslash( $_POST['_robo_lms_video_resources'] )
				: array();
			$clean_video = Helper::sanitize_repeater_data( $raw_video, 'learning-video' );
			update_post_meta( $post_id, '_robo_lms_video_resources', $clean_video );
		}

		// --- SAVE RELATIONSHIPS ---
		$rel_pdfs = isset( $_POST['_robo_lms_related_pdfs'] )
			? Helper::sanitize_post_ids( $_POST['_robo_lms_related_pdfs'] )
			: array();
		update_post_meta( $post_id, '_robo_lms_related_pdfs', $rel_pdfs );

		$rel_code = isset( $_POST['_robo_lms_related_code'] )
			? Helper::sanitize_post_ids( $_POST['_robo_lms_related_code'] )
			: array();
		update_post_meta( $post_id, '_robo_lms_related_code', $rel_code );

		$rel_videos = isset( $_POST['_robo_lms_related_videos'] )
			? Helper::sanitize_post_ids( $_POST['_robo_lms_related_videos'] )
			: array();
		update_post_meta( $post_id, '_robo_lms_related_videos', $rel_videos );

		if ( class_exists( 'WooCommerce' ) ) {
			$rel_prods = isset( $_POST['_robo_lms_related_products'] )
				? Helper::sanitize_post_ids( $_POST['_robo_lms_related_products'] )
				: array();
			update_post_meta( $post_id, '_robo_lms_related_products', $rel_prods );
		}
	}
}
