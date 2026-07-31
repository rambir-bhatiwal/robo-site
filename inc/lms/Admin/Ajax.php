<?php
/**
 * AJAX Handlers for Robo LMS.
 *
 * @package Robo\LMS\Admin
 */

namespace Robo\LMS\Admin;

use Robo\LMS\Frontend\Render;
use Robo\LMS\Frontend\Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Ajax
 */
class Ajax {

	/**
	 * Register AJAX actions.
	 */
	public function register(): void {
		// Admin search posts endpoint
		add_action( 'wp_ajax_robo_lms_search_posts', array( $this, 'search_posts' ) );

		// Frontend filter endpoint
		add_action( 'wp_ajax_robo_lms_filter_archive', array( $this, 'filter_archive' ) );
		add_action( 'wp_ajax_nopriv_robo_lms_filter_archive', array( $this, 'filter_archive' ) );
	}

	/**
	 * Search posts for relationship fields.
	 */
	public function search_posts(): void {
		check_ajax_referer( 'robo_lms_admin_nonce', 'security' );

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'robo' ) ) );
		}

		$post_type = isset( $_GET['post_type'] ) ? sanitize_key( $_GET['post_type'] ) : 'post';
		$search    = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';

		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => 30,
			'post_status'    => 'publish',
			's'              => $search,
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		$query  = new \WP_Query( $args );
		$results = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$results[] = array(
					'id'   => get_the_ID(),
					'text' => get_the_title() . ' (ID: ' . get_the_ID() . ')',
				);
			}
			wp_reset_postdata();
		}

		wp_send_json_success( $results );
	}

	/**
	 * AJAX Archive filter handler.
	 */
	public function filter_archive(): void {
		check_ajax_referer( 'robo_nonce', 'nonce' );

		$cpt        = isset( $_POST['cpt'] ) ? sanitize_key( $_POST['cpt'] ) : 'learning-pdf';
		$search     = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
		$category   = isset( $_POST['category'] ) ? sanitize_key( $_POST['category'] ) : '';
		$tag        = isset( $_POST['tag'] ) ? sanitize_key( $_POST['tag'] ) : '';
		$difficulty = isset( $_POST['difficulty'] ) ? sanitize_key( $_POST['difficulty'] ) : '';
		$sort       = isset( $_POST['sort'] ) ? sanitize_key( $_POST['sort'] ) : 'newest';
		$paged      = isset( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;

		$allowed_cpts = array( 'learning-pdf', 'learning-code', 'learning-video' );
		if ( ! in_array( $cpt, $allowed_cpts, true ) ) {
			$cpt = 'learning-pdf';
		}

		$query_args = Query::build_archive_query_args(
			$cpt,
			array(
				'search'     => $search,
				'category'   => $category,
				'tag'        => $tag,
				'difficulty' => $difficulty,
				'sort'       => $sort,
				'paged'      => $paged,
			)
		);

		$custom_query = new \WP_Query( $query_args );

		ob_start();
		if ( $custom_query->have_posts() ) {
			echo '<div class="row g-4">';
			while ( $custom_query->have_posts() ) {
				$custom_query->the_post();
				echo '<div class="col-md-6 col-lg-4 d-flex align-items-stretch">';
				Render::archive_card( get_the_ID() );
				echo '</div>';
			}
			echo '</div>';
		} else {
			echo '<div class="card border-0 shadow-sm rounded-4 text-center py-5 px-4 my-4 bg-white robo-lms-no-results-card">';
			echo '<div class="robo-lms-no-results-icon"><span class="dashicons dashicons-search"></span></div>';
			echo '<h4 class="fw-bold mb-2 text-dark">' . esc_html__( 'No Resources Found', 'robo' ) . '</h4>';
			echo '<p class="mb-0 text-muted">' . esc_html__( 'Try adjusting your search terms or filter criteria.', 'robo' ) . '</p>';
			echo '</div>';
		}
		$html = ob_get_clean();

		// Render pagination
		ob_start();
		if ( function_exists( 'robo_pagination' ) ) {
			robo_pagination( $custom_query );
		}
		$pagination = ob_get_clean();

		wp_reset_postdata();

		wp_send_json_success(
			array(
				'html'       => $html,
				'pagination' => $pagination,
				'total'      => $custom_query->found_posts,
			)
		);
	}
}
