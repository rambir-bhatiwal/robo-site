<?php
/**
 * Template Name: Learning Videos
 * Description: A custom Bootstrap 5 page template to display learning videos from ACF Repeater or native custom fields.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );

// Functions for URL parsing and verification
if ( ! function_exists( 'robo_is_youtube_url' ) ) {
	/**
	 * Validate if a given URL is a YouTube URL.
	 *
	 * @param string $url The URL to validate.
	 * @return bool True if valid YouTube URL.
	 */
	function robo_is_youtube_url( $url ) {
		if ( empty( $url ) || ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return false;
		}
		$host = wp_parse_url( $url, PHP_URL_HOST );
		if ( ! $host ) {
			return false;
		}
		$host = strtolower( $host );
		return ( 'youtu.be' === $host || strpos( $host, 'youtube.com' ) !== false );
	}
}

if ( ! function_exists( 'robo_get_youtube_embed_fallback' ) ) {
	/**
	 * Extracts video ID and generates a YouTube embed iframe when oEmbed fails.
	 *
	 * @param string $url The YouTube URL.
	 * @return string Embed HTML iframe code.
	 */
	function robo_get_youtube_embed_fallback( $url ) {
		$video_id = '';
		
		// Parse youtube.com/watch?v=ID or youtube.com/embed/ID or youtu.be/ID
		if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match ) ) {
			$video_id = $match[1];
		}
		
		if ( ! empty( $video_id ) ) {
			return sprintf(
				'<iframe width="560" height="315" src="https://www.youtube.com/embed/%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>',
				esc_attr( $video_id )
			);
		}
		
		return '';
	}
}

// -------------------------------------------------------------
// Data Fetching: Retrieve Videos from ACF Repeater or Post Meta
// -------------------------------------------------------------
$videos = array();

// 1. Check ACF Repeater
if ( function_exists( 'have_rows' ) && have_rows( 'learning_videos' ) ) {
	while ( have_rows( 'learning_videos' ) ) {
		the_row();
		$title       = get_sub_field( 'video_title' );
		if ( empty( $title ) ) {
			$title = get_sub_field( 'title' );
		}
		$url         = get_sub_field( 'youtube_url' );
		if ( empty( $url ) ) {
			$url = get_sub_field( 'url' );
		}
		$description = get_sub_field( 'description' );

		if ( ! empty( $url ) ) {
			$videos[] = array(
				'title'       => $title,
				'url'         => $url,
				'description' => $description,
			);
		}
	}
}

// 2. Fallback to native post meta if empty
if ( empty( $videos ) ) {
	$post_id = get_the_ID();

	// A. Check for ACF-like stored meta keys: learning_videos (count) and learning_videos_X_...
	$acf_count = get_post_meta( $post_id, 'learning_videos', true );
	if ( is_numeric( $acf_count ) && $acf_count > 0 ) {
		for ( $i = 0; $i < $acf_count; $i++ ) {
			$title       = get_post_meta( $post_id, "learning_videos_{$i}_video_title", true );
			if ( empty( $title ) ) {
				$title = get_post_meta( $post_id, "learning_videos_{$i}_title", true );
			}
			$url         = get_post_meta( $post_id, "learning_videos_{$i}_youtube_url", true );
			if ( empty( $url ) ) {
				$url = get_post_meta( $post_id, "learning_videos_{$i}_url", true );
			}
			$description = get_post_meta( $post_id, "learning_videos_{$i}_description", true );

			if ( ! empty( $url ) ) {
				$videos[] = array(
					'title'       => $title,
					'url'         => $url,
					'description' => $description,
				);
			}
		}
	}

	// B. Check for single JSON custom field: learning_videos_json
	if ( empty( $videos ) ) {
		$json_data = get_post_meta( $post_id, 'learning_videos_json', true );
		if ( ! empty( $json_data ) ) {
			$decoded = json_decode( $json_data, true );
			if ( is_array( $decoded ) ) {
				foreach ( $decoded as $row ) {
					$title       = isset( $row['video_title'] ) ? $row['video_title'] : ( isset( $row['title'] ) ? $row['title'] : '' );
					$url         = isset( $row['youtube_url'] ) ? $row['youtube_url'] : ( isset( $row['url'] ) ? $row['url'] : '' );
					$description = isset( $row['description'] ) ? $row['description'] : '';

					if ( ! empty( $url ) ) {
						$videos[] = array(
							'title'       => $title,
							'url'         => $url,
							'description' => $description,
						);
					}
				}
			}
		}
	}

	// C. Check for simple sequential/indexed native custom fields: e.g. video_title_0, youtube_url_0
	if ( empty( $videos ) ) {
		for ( $i = 0; $i < 100; $i++ ) {
			$title       = get_post_meta( $post_id, "video_title_{$i}", true );
			if ( empty( $title ) ) {
				$title = get_post_meta( $post_id, "title_{$i}", true );
			}
			$url         = get_post_meta( $post_id, "youtube_url_{$i}", true );
			if ( empty( $url ) ) {
				$url = get_post_meta( $post_id, "url_{$i}", true );
			}
			$description = get_post_meta( $post_id, "description_{$i}", true );

			if ( ! empty( $url ) ) {
				$videos[] = array(
					'title'       => $title,
					'url'         => $url,
					'description' => $description,
				);
			} else {
				// Break early if we get past index 5 and both title & url are empty to prevent scanning 100 times needlessly
				if ( $i > 5 && empty( $title ) ) {
					break;
				}
			}
		}
	}

	// D. Check for parallel meta arrays (multiple postmeta with the same key)
	if ( empty( $videos ) ) {
		$meta_urls   = get_post_meta( $post_id, 'youtube_url', false );
		if ( empty( $meta_urls ) ) {
			$meta_urls = get_post_meta( $post_id, 'url', false );
		}
		$meta_titles = get_post_meta( $post_id, 'video_title', false );
		if ( empty( $meta_titles ) ) {
			$meta_titles = get_post_meta( $post_id, 'title', false );
		}
		$meta_descs  = get_post_meta( $post_id, 'description', false );

		if ( ! empty( $meta_urls ) && is_array( $meta_urls ) ) {
			foreach ( $meta_urls as $index => $url ) {
				if ( ! empty( $url ) ) {
					$title       = isset( $meta_titles[ $index ] ) ? $meta_titles[ $index ] : '';
					$description = isset( $meta_descs[ $index ] ) ? $meta_descs[ $index ] : '';
					$videos[] = array(
						'title'       => $title,
						'url'         => $url,
						'description' => $description,
					);
				}
			}
		}
	}
}
?>

<style>
/* Custom Styles for Learning Videos Template */
.learning-videos-template {
	background-color: #f8f9fa;
}

.video-card-hover {
	transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
	border: 1px solid rgba(0, 0, 0, 0.05) !important;
}

.video-card-hover:hover {
	transform: translateY(-5px);
	box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.075) !important;
	border-color: rgba(0, 82, 255, 0.15) !important;
}

.video-card .ratio iframe {
	border: 0;
}

.btn-outline-danger {
	border-color: #ff0000;
	color: #ff0000;
	transition: all 0.2s ease-in-out;
}

.btn-outline-danger:hover {
	background-color: #ff0000;
	border-color: #ff0000;
	color: #fff;
	transform: scale(1.02);
}

.bg-grid {
	pointer-events: none;
}
</style>

<div id="primary" class="content-area learning-videos-template pb-5">
	<main id="main" class="site-main">
		
		<!-- Hero Section -->
		<section class="videos-hero bg-dark text-white py-5 text-center position-relative overflow-hidden mb-5" style="background: linear-gradient(135deg, #090F1d 0%, #0052FF 100%) !important;">
			<div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 bg-grid" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 20px 20px;"></div>
			<div class="<?php echo esc_attr( $container_class ); ?> position-relative z-1 py-4">
				<h1 class="display-4 fw-extrabold text-white mb-2"><?php the_title(); ?></h1>
				<p class="lead text-white-50 max-width-600 mx-auto mb-0"><?php esc_html_e( 'Expand your robotics knowledge with our curated video tutorials.', 'robo' ); ?></p>
			</div>
		</section>

		<!-- Main Content Area -->
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					
					<!-- Featured Image -->
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-thumbnail mb-5 rounded-4 overflow-hidden shadow-sm border border-light-subtle">
							<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid w-100 object-fit-cover', 'style' => 'max-height: 480px;' ) ); ?>
						</div>
					<?php endif; ?>

					<!-- Page Content -->
					<?php if ( have_posts() ) : ?>
						<div class="page-content text-muted fs-5 lh-lg mb-5 pb-4 border-bottom">
							<?php
							while ( have_posts() ) :
								the_post();
								the_content();
							endwhile;
							?>
						</div>
					<?php endif; ?>

					<!-- Videos Dynamic List -->
					<div class="videos-list d-flex flex-column gap-5 mt-4">
						<?php if ( ! empty( $videos ) ) : ?>
							<?php foreach ( $videos as $video ) : 
								// Get embed code via oEmbed or fallback
								$embed_code = '';
								if ( robo_is_youtube_url( $video['url'] ) ) {
									$embed_code = wp_oembed_get( $video['url'] );
									if ( $embed_code ) {
										// Lazy load check
										if ( stripos( $embed_code, 'loading=' ) === false ) {
											$embed_code = str_ireplace( '<iframe', '<iframe loading="lazy"', $embed_code );
										}
									} else {
										$embed_code = robo_get_youtube_embed_fallback( $video['url'] );
									}
								}
								
								if ( empty( $embed_code ) ) {
									continue; // Skip invalid or empty URLs
								}
								?>
								<div class="card video-card border-0 shadow-sm rounded-4 overflow-hidden video-card-hover bg-white">
									<div class="row g-0">
										<!-- Video Column (Left on Desktop, Top on Tablet/Mobile) -->
										<div class="col-lg-5 col-12">
											<div class="ratio ratio-16x9 bg-black h-100">
												<?php echo $embed_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
											</div>
										</div>
										<!-- Content Column (Right on Desktop, Bottom on Tablet/Mobile) -->
										<div class="col-lg-7 col-12 d-flex flex-column justify-content-between p-4 p-xl-5">
											<div>
												<h3 class="h4 fw-bold text-dark mb-3">
													<?php echo esc_html( $video['title'] ); ?>
												</h3>
												<?php if ( ! empty( $video['description'] ) ) : ?>
													<p class="text-muted mb-4 fs-6 lh-relaxed">
														<?php echo esc_html( $video['description'] ); ?>
													</p>
												<?php endif; ?>
											</div>
											<div class="mt-auto">
												<a href="<?php echo esc_url( $video['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger btn-sm px-4 py-2 fw-semibold rounded-pill d-inline-flex align-items-center gap-2">
													<i class="bi bi-youtube"></i>
													<?php esc_html_e( 'Watch on YouTube', 'robo' ); ?>
												</a>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<!-- Empty State -->
							<div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white border border-light-subtle">
								<div class="my-4">
									<i class="bi bi-play-btn-fill text-muted" style="font-size: 4rem;"></i>
								</div>
								<h3 class="h4 fw-bold text-dark mb-3"><?php esc_html_e( 'No Videos Found', 'robo' ); ?></h3>
								<p class="text-muted max-width-600 mx-auto mb-4">
									<?php esc_html_e( 'To display videos on this page, please add them using either ACF Pro (Repeater field named "learning_videos") or WordPress Native Custom Fields.', 'robo' ); ?>
								</p>
								<div class="d-inline-block text-start p-4 bg-light rounded-3 mx-auto" style="max-width: 550px; font-size: 0.9rem;">
									<span class="fw-bold text-dark d-block mb-2"><i class="bi bi-info-circle-fill text-primary me-2"></i><?php esc_html_e( 'Using WordPress Native Custom Fields:', 'robo' ); ?></span>
									<ol class="text-muted mb-0 ps-3">
										<li><?php esc_html_e( 'Go to page editor and enable "Custom Fields" in the preferences panel.', 'robo' ); ?></li>
										<li><?php esc_html_e( 'Add custom fields sequentially using these keys:', 'robo' ); ?>
											<ul class="font-monospace mt-1 mb-2 text-dark">
												<li>video_title_0, youtube_url_0, description_0</li>
												<li>video_title_1, youtube_url_1, description_1</li>
											</ul>
										</li>
										<li><?php esc_html_e( 'Click "Add Custom Field" and update the page.', 'robo' ); ?></li>
									</ol>
								</div>
							</div>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</div>

	</main>
</div>

<?php
get_footer();
