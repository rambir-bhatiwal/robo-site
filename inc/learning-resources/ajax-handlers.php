<?php
/**
 * AJAX Handlers for Learning Resources.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Robo_Learning_Resources_AJAX' ) ) {

	/**
	 * Class Robo_Learning_Resources_AJAX
	 */
	class Robo_Learning_Resources_AJAX {

		/**
		 * Constructor.
		 */
		public function __construct() {
			// WooCommerce Product Search in Admin
			add_action( 'wp_ajax_robo_lr_search_wc_products', array( $this, 'search_wc_products' ) );

			// Frontend AJAX Archive Filter
			add_action( 'wp_ajax_robo_lr_filter_archive', array( $this, 'filter_archive' ) );
			add_action( 'wp_ajax_nopriv_robo_lr_filter_archive', array( $this, 'filter_archive' ) );

			// Toggle Like
			add_action( 'wp_ajax_robo_lr_toggle_like', array( $this, 'toggle_like' ) );
			add_action( 'wp_ajax_nopriv_robo_lr_toggle_like', array( $this, 'toggle_like' ) );

			// Toggle Favorite / Bookmark
			add_action( 'wp_ajax_robo_lr_toggle_favorite', array( $this, 'toggle_favorite' ) );
			add_action( 'wp_ajax_nopriv_robo_lr_toggle_favorite', array( $this, 'toggle_favorite' ) );

			// Single File Download Tracker
			add_action( 'wp_ajax_robo_lr_download_file', array( $this, 'download_file' ) );
			add_action( 'wp_ajax_nopriv_robo_lr_download_file', array( $this, 'download_file' ) );

			// Download All Resources ZIP
			add_action( 'wp_ajax_robo_lr_download_all_zip', array( $this, 'download_all_zip' ) );
			add_action( 'wp_ajax_nopriv_robo_lr_download_all_zip', array( $this, 'download_all_zip' ) );
		}

		/**
		 * WooCommerce Product Search Endpoint for Admin Meta Box
		 */
		public function search_wc_products() {
			check_ajax_referer( 'robo_lr_admin_nonce', 'nonce' );

			if ( ! current_user_can( 'edit_posts' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'robo' ) ) );
			}

			if ( ! class_exists( 'WooCommerce' ) ) {
				wp_send_json_error( array( 'message' => __( 'WooCommerce is not active.', 'robo' ) ) );
			}

			$term = isset( $_GET['term'] ) ? sanitize_text_field( wp_unslash( $_GET['term'] ) ) : '';
			if ( empty( $term ) ) {
				wp_send_json_success( array() );
			}

			$args = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => 20,
				's'              => $term,
			);

			$query    = new WP_Query( $args );
			$products = array();

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$p_id    = get_the_ID();
					$product = wc_get_product( $p_id );
					if ( $product ) {
						$products[] = array(
							'id'    => $p_id,
							'title' => get_the_title(),
							'price' => wc_price( $product->get_price() ),
							'sku'   => $product->get_sku(),
						);
					}
				}
				wp_reset_postdata();
			}

			wp_send_json_success( $products );
		}

		/**
		 * Frontend Archive AJAX Filter Handler
		 */
		public function filter_archive() {
			check_ajax_referer( 'robo_lr_nonce', 'nonce' );

			$category   = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';
			$difficulty = isset( $_POST['difficulty'] ) ? sanitize_text_field( $_POST['difficulty'] ) : '';
			$tag        = isset( $_POST['tag'] ) ? sanitize_text_field( $_POST['tag'] ) : '';
			$search     = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';
			$paged      = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;

			$args = array(
				'post_type'      => 'learning-resource',
				'post_status'    => 'publish',
				'posts_per_page' => 9,
				'paged'          => $paged,
			);

			if ( ! empty( $search ) ) {
				$args['s'] = $search;
			}

			// Tax Query
			$tax_query = array( 'relation' => 'AND' );
			if ( ! empty( $category ) ) {
				$tax_query[] = array(
					'taxonomy' => 'learning_category',
					'field'    => 'slug',
					'terms'    => $category,
				);
			}
			if ( ! empty( $tag ) ) {
				$tax_query[] = array(
					'taxonomy' => 'learning_tag',
					'field'    => 'slug',
					'terms'    => $tag,
				);
			}
			if ( count( $tax_query ) > 1 ) {
				$args['tax_query'] = $tax_query;
			}

			// Meta Query for Difficulty
			if ( ! empty( $difficulty ) ) {
				$args['meta_query'] = array(
					array(
						'key'     => '_robo_lr_difficulty',
						'value'   => $difficulty,
						'compare' => '=',
					),
				);
			}

			$query = new WP_Query( $args );

			ob_start();
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();
					get_template_part( 'template-parts/content-learning-resource-card' );
				endwhile;
			else :
				?>
				<div class="col-12 text-center py-5">
					<div class="card border-0 shadow-sm p-4 bg-light">
						<i class="bi bi-search fs-1 text-muted mb-2"></i>
						<h4>No Learning Resources Found</h4>
						<p class="text-muted mb-0">Try adjusting your filters or search keyword.</p>
					</div>
				</div>
				<?php
			endif;
			$html = ob_get_clean();

			// Pagination
			$total_pages = $query->max_num_pages;
			ob_start();
			if ( $total_pages > 1 ) :
				echo '<ul class="pagination justify-content-center mt-4">';
				for ( $i = 1; $i <= $total_pages; $i++ ) {
					$active = ( $i === $paged ) ? 'active' : '';
					printf(
						'<li class="page-item %1$s"><a class="page-link lr-page-btn" href="#" data-page="%2$d">%2$d</a></li>',
						esc_attr( $active ),
						esc_attr( $i )
					);
				}
				echo '</ul>';
			endif;
			$pagination = ob_get_clean();

			wp_reset_postdata();

			wp_send_json_success(
				array(
					'html'       => $html,
					'pagination' => $pagination,
					'count'      => $query->found_posts,
				)
			);
		}

		/**
		 * Toggle Like AJAX Handler
		 */
		public function toggle_like() {
			check_ajax_referer( 'robo_lr_nonce', 'nonce' );

			$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
			if ( ! $post_id || 'learning-resource' !== get_post_type( $post_id ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid resource.', 'robo' ) ) );
			}

			$cookie_name = 'robo_lr_liked_' . $post_id;
			$likes       = (int) get_post_meta( $post_id, '_robo_lr_likes_count', true );
			$is_liked    = isset( $_COOKIE[ $cookie_name ] );

			if ( $is_liked ) {
				$likes = max( 0, $likes - 1 );
				setcookie( $cookie_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
				$status = 'unliked';
			} else {
				$likes++;
				setcookie( $cookie_name, '1', time() + ( 86400 * 365 ), COOKIEPATH, COOKIE_DOMAIN );
				$status = 'liked';
			}

			update_post_meta( $post_id, '_robo_lr_likes_count', $likes );

			wp_send_json_success(
				array(
					'status' => $status,
					'likes'  => $likes,
				)
			);
		}

		/**
		 * Toggle Favorite AJAX Handler
		 */
		public function toggle_favorite() {
			check_ajax_referer( 'robo_lr_nonce', 'nonce' );

			$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
			if ( ! $post_id || 'learning-resource' !== get_post_type( $post_id ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid resource.', 'robo' ) ) );
			}

			if ( is_user_logged_in() ) {
				$user_id   = get_current_user_id();
				$favorites = get_user_meta( $user_id, '_robo_lr_favorites', true );
				$favorites = is_array( $favorites ) ? $favorites : array();

				if ( in_array( $post_id, $favorites, true ) ) {
					$favorites = array_diff( $favorites, array( $post_id ) );
					$status    = 'removed';
				} else {
					$favorites[] = $post_id;
					$status      = 'added';
				}
				update_user_meta( $user_id, '_robo_lr_favorites', array_unique( $favorites ) );
			} else {
				// Cookie for guests
				$cookie_name = 'robo_lr_fav_' . $post_id;
				if ( isset( $_COOKIE[ $cookie_name ] ) ) {
					setcookie( $cookie_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
					$status = 'removed';
				} else {
					setcookie( $cookie_name, '1', time() + ( 86400 * 365 ), COOKIEPATH, COOKIE_DOMAIN );
					$status = 'added';
				}
			}

			wp_send_json_success( array( 'status' => $status ) );
		}

		/**
		 * Download Single File Tracker Handler
		 */
		public function download_file() {
			$post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;
			$file_url = isset( $_GET['file_url'] ) ? esc_url_raw( wp_unslash( $_GET['file_url'] ) ) : '';

			if ( $post_id ) {
				$dl_count = (int) get_post_meta( $post_id, '_robo_lr_download_count', true );
				update_post_meta( $post_id, '_robo_lr_download_count', $dl_count + 1 );
			}

			if ( ! empty( $file_url ) ) {
				wp_redirect( $file_url );
				exit;
			}

			wp_die( esc_html__( 'File link missing.', 'robo' ) );
		}

		/**
		 * Download All Resources as a ZIP File
		 */
		public function download_all_zip() {
			$post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;
			if ( ! $post_id || 'learning-resource' !== get_post_type( $post_id ) ) {
				wp_die( esc_html__( 'Invalid Resource.', 'robo' ) );
			}

			// Gather files
			$pdfs        = get_post_meta( $post_id, '_robo_lr_pdf_resources', true );
			$downloads   = get_post_meta( $post_id, '_robo_lr_downloads', true );
			$attachments = get_post_meta( $post_id, '_robo_lr_attachment_ids', true );

			$files_to_zip = array();

			if ( is_array( $pdfs ) ) {
				foreach ( $pdfs as $p ) {
					if ( ! empty( $p['file_id'] ) ) {
						$files_to_zip[] = get_attached_file( $p['file_id'] );
					}
				}
			}

			if ( is_array( $downloads ) ) {
				foreach ( $downloads as $d ) {
					if ( ! empty( $d['file_id'] ) ) {
						$files_to_zip[] = get_attached_file( $d['file_id'] );
					}
				}
			}

			if ( is_array( $attachments ) ) {
				foreach ( $attachments as $att_id ) {
					$files_to_zip[] = get_attached_file( $att_id );
				}
			}

			$files_to_zip = array_filter( array_unique( $files_to_zip ) );

			if ( empty( $files_to_zip ) ) {
				wp_die( esc_html__( 'No downloadable files found for this resource.', 'robo' ) );
			}

			// Increment Download Counter
			$dl_count = (int) get_post_meta( $post_id, '_robo_lr_download_count', true );
			update_post_meta( $post_id, '_robo_lr_download_count', $dl_count + 1 );

			if ( class_exists( 'ZipArchive' ) ) {
				$zip      = new ZipArchive();
				$zip_name = 'resource-' . sanitize_title( get_the_title( $post_id ) ) . '-files.zip';
				$tmp_dir  = get_temp_dir();
				$zip_file = $tmp_dir . '/' . $zip_name;

				if ( $zip->open( $zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE ) === true ) {
					foreach ( $files_to_zip as $file_path ) {
						if ( file_exists( $file_path ) ) {
							$zip->addFile( $file_path, basename( $file_path ) );
						}
					}
					$zip->close();

					if ( file_exists( $zip_file ) ) {
						header( 'Content-Type: application/zip' );
						header( 'Content-Disposition: attachment; filename="' . esc_attr( $zip_name ) . '"' );
						header( 'Content-Length: ' . filesize( $zip_file ) );
						header( 'Pragma: no-cache' );
						header( 'Expires: 0' );
						readfile( $zip_file );
						unlink( $zip_file );
						exit;
					}
				}
			}

			// Fallback: Redirect to first available file
			$first_file = reset( $files_to_zip );
			$url        = wp_get_attachment_url( attachment_url_to_postid( $first_file ) );
			if ( $url ) {
				wp_redirect( $url );
				exit;
			}

			wp_die( esc_html__( 'Unable to generate ZIP file.', 'robo' ) );
		}
	}

	new Robo_Learning_Resources_AJAX();
}
