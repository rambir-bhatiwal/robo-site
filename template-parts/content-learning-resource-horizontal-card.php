<?php
/**
 * Template Part for Displaying Horizontal Learning Resource Cards
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id          = get_the_ID();
$short_desc       = get_post_meta( $post_id, '_robo_lr_short_desc', true );
$difficulty       = get_post_meta( $post_id, '_robo_lr_difficulty', true );
$duration         = get_post_meta( $post_id, '_robo_lr_duration', true );
$list_img_id      = get_post_meta( $post_id, '_robo_lr_list_image_id', true );
$cover_img_id     = get_post_meta( $post_id, '_robo_lr_cover_image_id', true );

// Dynamic Repeaters & WooCommerce Products
$video_resources  = get_post_meta( $post_id, '_robo_lr_video_resources', true );
$video_resources  = is_array( $video_resources ) ? array_filter( $video_resources ) : array();

$pdf_resources    = get_post_meta( $post_id, '_robo_lr_pdf_resources', true );
$pdf_resources    = is_array( $pdf_resources ) ? array_filter( $pdf_resources ) : array();

$github_resources = get_post_meta( $post_id, '_robo_lr_github_resources', true );
$github_resources = is_array( $github_resources ) ? array_filter( $github_resources ) : array();

$related_wc_ids   = get_post_meta( $post_id, '_robo_lr_related_product_ids', true );
$valid_wc_ids     = ( class_exists( 'WooCommerce' ) && is_array( $related_wc_ids ) ) ? array_values( array_filter( $related_wc_ids ) ) : array();

// 1. Thumbnail Resolution Logic
$img_url = '';
if ( $list_img_id ) {
	$img_url = wp_get_attachment_image_url( $list_img_id, 'medium_large' );
} elseif ( $cover_img_id ) {
	$img_url = wp_get_attachment_image_url( $cover_img_id, 'medium_large' );
} elseif ( has_post_thumbnail( $post_id ) ) {
	$img_url = get_the_post_thumbnail_url( $post_id, 'medium_large' );
}

// 2. Short Description Fallback Logic
if ( empty( $short_desc ) ) {
	$excerpt = get_the_excerpt( $post_id );
	if ( ! empty( $excerpt ) ) {
		$short_desc = $excerpt;
	} else {
		$short_desc = wp_trim_words( strip_tags( get_the_content( null, false, $post_id ) ), 28, '...' );
	}
}

// 3. Category & Taxonomy
$categories = get_the_terms( $post_id, 'learning_category' );
$cat_name   = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? $categories[0]->name : __( 'General', 'robo' );
$cat_link   = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? get_term_link( $categories[0] ) : '#';
?>

<div class="col-12 mb-4">
	<div class="card robo-lr-horizontal-card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100 transition-all">
		<div class="row g-0 align-items-stretch">
			
			<!-- Image Column (Desktop: Left, Mobile: Top) -->
			<div class="col-lg-4 col-md-5 position-relative">
				<div class="robo-lr-hz-img-container h-100 min-height-240">
					<?php if ( $img_url ) : ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="robo-lr-hz-img w-100 h-100 object-fit-cover" loading="lazy">
					<?php else : ?>
						<div class="w-100 h-100 bg-dark text-white d-flex align-items-center justify-content-center p-4">
							<i class="bi bi-journal-code fs-1 opacity-50"></i>
						</div>
					<?php endif; ?>

					<!-- Badges Overlay -->
					<div class="position-absolute top-0 start-0 p-3 z-2 d-flex flex-wrap gap-1">
						<?php echo robo_lr_render_badges( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			</div>

			<!-- Content Column (Desktop: Right, Mobile: Bottom) -->
			<div class="col-lg-8 col-md-7 d-flex flex-column p-4 p-lg-4">
				
				<!-- Meta Row: Category, Difficulty, Duration -->
				<div class="d-flex flex-wrap align-items-center gap-2 mb-2">
					<a href="<?php echo esc_url( $cat_link ); ?>" class="badge bg-primary-subtle text-primary border border-primary-subtle text-decoration-none fw-semibold rounded-pill px-3 py-1 text-uppercase fs-11">
						<i class="bi bi-folder2-open me-1"></i><?php echo esc_html( $cat_name ); ?>
					</a>

					<?php if ( $difficulty ) : ?>
						<span class="badge bg-slate-100 text-dark border text-capitalize rounded-pill px-3 py-1 fs-11 fw-medium">
							<i class="bi bi-bar-chart-fill me-1 text-warning"></i><?php echo esc_html( ucfirst( $difficulty ) ); ?>
						</span>
					<?php endif; ?>

					<?php if ( $duration ) : ?>
						<span class="badge bg-slate-100 text-secondary border rounded-pill px-3 py-1 fs-11 fw-medium ms-auto">
							<i class="bi bi-clock me-1 text-primary"></i><?php echo esc_html( $duration ); ?>
						</span>
					<?php endif; ?>
				</div>

				<!-- Resource Title -->
				<h3 class="card-title fw-bold text-dark mb-2 fs-4 lh-sm">
					<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none hover-primary transition-all">
						<?php the_title(); ?>
					</a>
				</h3>

				<!-- Short Description (Clamped to 3-4 lines) -->
				<p class="card-text text-secondary mb-4 fs-6 leading-relaxed robo-lr-clamped-desc">
					<?php echo esc_html( $short_desc ); ?>
				</p>

				<!-- Card Footer / Dynamic Action Buttons Row -->
				<div class="mt-auto pt-3 border-top d-flex flex-wrap align-items-center gap-2 justify-content-between">
					
					<div class="d-flex flex-wrap gap-2 align-items-center w-100">
						
						<!-- 1. LEARN MORE (Always Visible) -->
						<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center shadow-sm">
							Learn More <i class="bi bi-arrow-right ms-1"></i>
						</a>

						<!-- 2. WATCH VIDEO (Dynamic) -->
						<?php if ( ! empty( $video_resources ) ) : ?>
							<?php if ( count( $video_resources ) === 1 ) : ?>
								<a href="<?php echo esc_url( get_permalink() . '#section-videos' ); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center">
									<i class="bi bi-play-circle me-1"></i> Watch Video
								</a>
							<?php else : ?>
								<div class="dropdown d-inline-block">
									<button class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-semibold dropdown-toggle d-inline-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="bi bi-play-circle me-1"></i> Watch Video (<?php echo count( $video_resources ); ?>)
									</button>
									<ul class="dropdown-menu shadow">
										<?php foreach ( $video_resources as $vid_item ) : ?>
											<li>
												<a class="dropdown-item" href="<?php echo esc_url( get_permalink() . '#section-videos' ); ?>">
													<i class="bi bi-youtube text-danger me-2"></i> <?php echo esc_html( $vid_item['title'] ); ?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<!-- 3. PDF (Dynamic) -->
						<?php if ( ! empty( $pdf_resources ) ) : ?>
							<?php if ( count( $pdf_resources ) === 1 ) : ?>
								<a href="<?php echo esc_url( ! empty( $pdf_resources[0]['file_url'] ) ? $pdf_resources[0]['file_url'] : get_permalink() . '#section-pdfs' ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center">
									<i class="bi bi-file-earmark-pdf me-1"></i> PDF
								</a>
							<?php else : ?>
								<div class="dropdown d-inline-block">
									<button class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-semibold dropdown-toggle d-inline-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="bi bi-file-earmark-pdf me-1"></i> PDF (<?php echo count( $pdf_resources ); ?>)
									</button>
									<ul class="dropdown-menu shadow">
										<?php foreach ( $pdf_resources as $pdf_item ) : ?>
											<?php $p_url = ! empty( $pdf_item['file_url'] ) ? $pdf_item['file_url'] : get_permalink() . '#section-pdfs'; ?>
											<li>
												<a class="dropdown-item" href="<?php echo esc_url( $p_url ); ?>" target="_blank" rel="noopener">
													<i class="bi bi-file-earmark-pdf text-danger me-2"></i> <?php echo esc_html( $pdf_item['title'] ); ?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<!-- 4. SOURCE CODE (Dynamic) -->
						<?php if ( ! empty( $github_resources ) ) : ?>
							<?php if ( count( $github_resources ) === 1 ) : ?>
								<a href="<?php echo esc_url( ! empty( $github_resources[0]['url'] ) ? $github_resources[0]['url'] : get_permalink() . '#section-github' ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center">
									<i class="bi bi-github me-1"></i> Source Code
								</a>
							<?php else : ?>
								<div class="dropdown d-inline-block">
									<button class="btn btn-sm btn-outline-dark rounded-pill px-3 py-2 fw-semibold dropdown-toggle d-inline-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="bi bi-github me-1"></i> Source Code (<?php echo count( $github_resources ); ?>)
									</button>
									<ul class="dropdown-menu shadow">
										<?php foreach ( $github_resources as $gh_item ) : ?>
											<?php $gh_url = ! empty( $gh_item['url'] ) ? $gh_item['url'] : get_permalink() . '#section-github'; ?>
											<li>
												<a class="dropdown-item" href="<?php echo esc_url( $gh_url ); ?>" target="_blank" rel="noopener">
													<i class="bi bi-github text-dark me-2"></i> <?php echo esc_html( $gh_item['title'] ); ?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<!-- 5. VIEW KIT (Dynamic WooCommerce Product Link) -->
						<?php if ( ! empty( $valid_wc_ids ) ) : ?>
							<?php if ( count( $valid_wc_ids ) === 1 ) : ?>
								<?php $kit_p_id = $valid_wc_ids[0]; ?>
								<a href="<?php echo esc_url( get_permalink( $kit_p_id ) ); ?>" class="btn btn-sm btn-outline-success rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center">
									<i class="bi bi-box-seam me-1"></i> View Kit
								</a>
							<?php else : ?>
								<div class="dropdown d-inline-block">
									<button class="btn btn-sm btn-outline-success rounded-pill px-3 py-2 fw-semibold dropdown-toggle d-inline-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="bi bi-box-seam me-1"></i> View Kit (<?php echo count( $valid_wc_ids ); ?>)
									</button>
									<ul class="dropdown-menu shadow">
										<?php foreach ( $valid_wc_ids as $p_id ) : ?>
											<?php $prod = wc_get_product( $p_id ); ?>
											<?php if ( $prod ) : ?>
												<li>
													<a class="dropdown-item" href="<?php echo esc_url( get_permalink( $p_id ) ); ?>">
														<i class="bi bi-cart-check text-success me-2"></i> <?php echo esc_html( $prod->get_name() ); ?>
													</a>
												</li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						<?php endif; ?>

					</div>

				</div>

			</div>
		</div>
	</div>
</div>
