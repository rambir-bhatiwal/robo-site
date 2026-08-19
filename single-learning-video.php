<?php
/**
 * Single template for Learning Videos.
 *
 * @package Robo
 */

use Robo\LMS\Frontend\Render;
use Robo\LMS\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$post_id     = get_the_ID();
	$short_desc  = get_post_meta( $post_id, '_robo_lms_short_description', true );
	$difficulty  = get_post_meta( $post_id, '_robo_lms_difficulty', true );
	$duration    = get_post_meta( $post_id, '_robo_lms_estimated_duration', true );
	$diff_opts   = Helper::get_difficulty_options();
	$diff_label  = $diff_opts[ $difficulty ] ?? '';

	// Video repeater items
	$video_items = get_post_meta( $post_id, '_robo_lms_video_resources', true );
	if ( ! is_array( $video_items ) ) {
		$video_items = array();
	}

	// Related items
	$rel_code  = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_code', true ) );
	$rel_pdfs  = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_pdfs', true ) );
	$rel_prods = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_products', true ) );

	$archive_link = get_post_type_archive_link( 'learning-video' );
	if ( ! $archive_link ) {
		$archive_link = home_url( '/learning-video/' );
	}
	?>

	<!-- 1. Hero Section -->
	<?php Render::single_hero( $post_id ); ?>

	<!-- 2. Breadcrumb -->
	<?php get_template_part( 'template-parts/sections/breadcrumb' ); ?>

	<!-- Main Content Area -->
	<main id="primary" class="site-main py-3 py-md-4 bg-light-subtle">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xl-12">

					<!-- 3. Video Title & Meta Bar -->
					<div class="mb-3">
						<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
							<div class="d-flex flex-wrap align-items-center gap-2">
								<?php
								$cats = get_the_terms( $post_id, 'learning-category' );
								if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) :
									?>
									<span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1.5 rounded-pill fw-bold text-uppercase fs-7 d-inline-flex align-items-center gap-1">
										<span class="dashicons dashicons-category"></span><?php echo esc_html( $cats[0]->name ); ?>
									</span>
								<?php endif; ?>

								<?php if ( $diff_label ) : ?>
									<span class="badge bg-primary px-3 py-1.5 rounded-pill fw-semibold fs-7 d-inline-flex align-items-center gap-1">
										<span class="dashicons dashicons-chart-bar"></span><?php echo esc_html( $diff_label ); ?>
									</span>
								<?php endif; ?>

								<?php if ( $duration ) : ?>
									<span class="badge bg-dark bg-opacity-75 text-white px-3 py-1.5 rounded-pill fs-7 d-inline-flex align-items-center gap-1">
										<span class="dashicons dashicons-clock"></span><?php echo esc_html( $duration ); ?>
									</span>
								<?php endif; ?>
							</div>

							<a href="<?php echo esc_url( $archive_link ); ?>" class="btn btn-outline-danger rounded-pill px-3.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
								<span class="dashicons dashicons-arrow-left-alt"></span> <?php esc_html_e( 'Back to Video Library', 'robo' ); ?>
							</a>
						</div>

						<?php
						$video_item_title = '';
						if ( ! empty( $video_items ) && ! empty( $video_items[0]['title'] ) ) {
							$video_item_title = $video_items[0]['title'];
						}
						if ( empty( $video_item_title ) ) {
							$video_item_title = get_the_title( $post_id );
						}
						?>
						<h1 class="h2 fw-bold text-dark mb-2"><?php echo esc_html( $video_item_title ); ?></h1>
					</div>

					<!-- 4. Video Player Section (Compact & Responsive 16:9) -->
					<div class="video-player-container mb-3">
						<?php
						$main_video_url   = '';
						$main_video_title = get_the_title();

						if ( ! empty( $video_items ) && ! empty( $video_items[0]['video_url'] ) ) {
							$main_video_url   = $video_items[0]['video_url'];
							$main_video_title = ! empty( $video_items[0]['title'] ) ? $video_items[0]['title'] : get_the_title();
						} else {
							// Fallback to postmeta direct URL if stored
							$direct_url = get_post_meta( $post_id, '_robo_lms_video_url', true );
							if ( $direct_url ) {
								$main_video_url = $direct_url;
							}
						}

						if ( ! empty( $main_video_url ) ) {
							echo Helper::render_video_embed( $main_video_url, $main_video_title ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						} else {
							// Placeholder when no video URL is specified
							?>
							<div class="ratio ratio-16x9 rounded-4 shadow-sm overflow-hidden mb-3 bg-dark d-flex align-items-center justify-content-center text-white text-center">
								<div class="p-4">
									<span class="dashicons dashicons-video-alt3 display-1 text-danger mb-3"></span>
									<h4 class="fw-bold mb-2"><?php esc_html_e( 'No Video Player URL Specified', 'robo' ); ?></h4>
									<p class="text-white-50 mb-0"><?php esc_html_e( 'Please add a video URL in the Learning Resource Settings metabox.', 'robo' ); ?></p>
								</div>
							</div>
							<?php
						}
						?>

						<!-- Playlist Selector if multiple videos exist -->
						<?php if ( count( $video_items ) > 1 ) : ?>
							<div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-3" id="video-playlist-selector">
								<h6 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
									<span class="dashicons dashicons-playlist text-danger fs-5"></span>
									<?php esc_html_e( 'Course Playlist / Video Lessons', 'robo' ); ?>
									<span class="badge bg-danger text-white rounded-pill ms-auto fs-7"><?php echo count( $video_items ); ?> <?php esc_html_e( 'Lessons', 'robo' ); ?></span>
								</h6>
								<div class="list-group list-group-flush rounded-3 border overflow-hidden">
									<?php foreach ( $video_items as $v_idx => $v_item ) : ?>
										<?php
										$v_title = ! empty( $v_item['title'] ) ? $v_item['title'] : sprintf( __( 'Lesson %d', 'robo' ), $v_idx + 1 );
										$v_dur   = $v_item['duration'] ?? '';
										$v_url   = $v_item['video_url'] ?? '';
										?>
										<a href="<?php echo esc_url( $v_url ); ?>" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-2.5 <?php echo 0 === $v_idx ? 'active bg-danger text-white border-danger' : 'bg-white text-dark'; ?>" target="_blank" rel="noopener noreferrer">
											<div class="d-flex align-items-center gap-2">
												<span class="badge rounded-circle <?php echo 0 === $v_idx ? 'bg-white text-danger' : 'bg-light text-dark border'; ?> px-2 py-1 fw-bold fs-7"><?php echo $v_idx + 1; ?></span>
												<span class="fw-semibold fs-6"><?php echo esc_html( $v_title ); ?></span>
											</div>
											<?php if ( $v_dur ) : ?>
												<small class="<?php echo 0 === $v_idx ? 'text-white-50' : 'text-muted'; ?> d-inline-flex align-items-center gap-1 fs-7">
													<span class="dashicons dashicons-clock"></span> <?php echo esc_html( $v_dur ); ?>
												</small>
											<?php endif; ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<!-- 5. Action Buttons Bar -->
					<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white border robo-lms-action-bar">
						<div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
							<div class="d-flex flex-wrap align-items-center gap-2 robo-lms-action-buttons">
								<!-- ▶ Watch Video Button (Playlist trigger or main action) -->
								<?php if ( count( $video_items ) > 1 ) : ?>
									<a href="#video-playlist-selector" class="btn btn-danger rounded-pill px-3.5 py-1.5 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
										<span class="dashicons dashicons-controls-play flex-shrink-0"></span> <span class="text-truncate"><?php esc_html_e( 'Watch Video Lessons', 'robo' ); ?></span>
									</a>
								<?php endif; ?>

								<!-- </> Related Code Buttons -->
								<?php if ( ! empty( $rel_code ) ) : ?>
									<?php foreach ( $rel_code as $code_id ) : 
										$code_title = get_the_title( $code_id );
										$code_url   = get_permalink( $code_id );
										if ( $code_title && $code_url ) : ?>
											<a href="<?php echo esc_url( $code_url ); ?>" class="btn btn-success text-white rounded-pill px-3 py-1.5 fw-semibold shadow-sm d-inline-flex align-items-center gap-1">
												<span class="dashicons dashicons-editor-code flex-shrink-0"></span> <span class="text-truncate"><?php echo sprintf( esc_html__( 'Code: %s', 'robo' ), esc_html( $code_title ) ); ?></span>
											</a>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>

								<!-- 📄 Related PDF Buttons -->
								<?php if ( ! empty( $rel_pdfs ) ) : ?>
									<?php foreach ( $rel_pdfs as $pdf_id ) : 
										$pdf_title = get_the_title( $pdf_id );
										$pdf_url   = get_permalink( $pdf_id );
										if ( $pdf_title && $pdf_url ) : ?>
											<a href="<?php echo esc_url( $pdf_url ); ?>" class="btn btn-primary text-white rounded-pill px-3 py-1.5 fw-semibold shadow-sm d-inline-flex align-items-center gap-1">
												<span class="dashicons dashicons-media-document flex-shrink-0"></span> <span class="text-truncate"><?php echo sprintf( esc_html__( 'PDF: %s', 'robo' ), esc_html( $pdf_title ) ); ?></span>
											</a>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>

								<!-- 🛒 Related Product (Buy Kit) Buttons -->
								<?php if ( ! empty( $rel_prods ) && class_exists( 'WooCommerce' ) ) : ?>
									<?php foreach ( $rel_prods as $prod_id ) : 
										if ( 'product' !== get_post_type( $prod_id ) ) {
											continue;
										}
										$prod_title = get_the_title( $prod_id );
										$prod_url   = get_permalink( $prod_id );
										if ( $prod_title && $prod_url ) : ?>
											<a href="<?php echo esc_url( $prod_url ); ?>" class="btn btn-warning text-dark rounded-pill px-3 py-1.5 fw-semibold shadow-sm d-inline-flex align-items-center gap-1">
												<span class="dashicons dashicons-cart flex-shrink-0"></span> <span class="text-truncate"><?php echo sprintf( esc_html__( 'Buy Kit: %s', 'robo' ), esc_html( $prod_title ) ); ?></span>
											</a>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>

							<!-- ← Back to Learning Videos -->
							<a href="<?php echo esc_url( $archive_link ); ?>" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center justify-content-center gap-1 ms-md-auto robo-lms-back-btn">
								<span class="dashicons dashicons-arrow-left-alt flex-shrink-0"></span> <span class="text-truncate"><?php esc_html_e( 'Back to Videos', 'robo' ); ?></span>
							</a>
						</div>
					</div>

					<!-- 6. Video Description -->
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white' ); ?>>
						<h3 class="h5 fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
							<span class="dashicons dashicons-text-page text-primary fs-4"></span>
							<?php esc_html_e( 'Course Overview & Description', 'robo' ); ?>
						</h3>

						<div class="entry-content text-secondary fs-6 lh-lg mb-3">
							<?php
							$content = get_the_content();
							if ( ! empty( trim( $content ) ) ) {
								the_content();
							} elseif ( ! empty( $short_desc ) ) {
								echo '<p>' . esc_html( $short_desc ) . '</p>';
							} else {
								echo '<p>' . esc_html( get_the_excerpt( $post_id ) ) . '</p>';
							}
							?>
						</div>

						<!-- Tags -->
						<?php
						$tags = get_the_terms( $post_id, 'learning-tag' );
						if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
							?>
							<div class="pt-2.5 border-top d-flex flex-wrap align-items-center gap-2">
								<small class="text-muted fw-bold me-2"><?php esc_html_e( 'Tags:', 'robo' ); ?></small>
								<?php foreach ( $tags as $t ) : ?>
									<a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill text-decoration-none hover-primary fs-7">
										#<?php echo esc_html( $t->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</article>

					<!-- 7. Related Source Code Section -->
					<?php Render::related_code_section( $post_id ); ?>

					<!-- 8. Related PDF Resources Section -->
					<?php Render::pdf_resources_section( $post_id ); ?>

					<!-- 9. Related Products Section -->
					<?php Render::related_products_section( $post_id ); ?>

					<!-- 10. Optional Related Videos Section -->
					<?php
					$related_video_query = new \WP_Query(
						array(
							'post_type'      => 'learning-video',
							'posts_per_page' => 3,
							'post__not_in'   => array( $post_id ),
							'orderby'        => 'rand',
						)
					);

					if ( $related_video_query->have_posts() ) :
						?>
						<section class="robo-lms-section my-4">
							<h3 class="h5 fw-bold mb-3 pb-2 border-bottom d-flex align-items-center gap-2 text-dark">
								<span class="dashicons dashicons-video-alt3 text-danger fs-4"></span>
								<?php esc_html_e( 'More Learning Videos', 'robo' ); ?>
							</h3>

							<div class="row g-3">
								<?php
								while ( $related_video_query->have_posts() ) :
									$related_video_query->the_post();
									?>
									<div class="col-12 mb-3">
										<?php Render::archive_card( get_the_ID() ); ?>
									</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							</div>
						</section>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</main>

<?php
endwhile;

get_footer();
