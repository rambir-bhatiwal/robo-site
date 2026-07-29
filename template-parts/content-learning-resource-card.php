<?php
/**
 * Template part for displaying Learning Resource cards in grid
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

// Repeaters & Related Products
$video_resources  = get_post_meta( $post_id, '_robo_lr_video_resources', true );
$video_resources  = is_array( $video_resources ) ? array_filter( $video_resources ) : array();

$pdf_resources    = get_post_meta( $post_id, '_robo_lr_pdf_resources', true );
$pdf_resources    = is_array( $pdf_resources ) ? array_filter( $pdf_resources ) : array();

$github_resources = get_post_meta( $post_id, '_robo_lr_github_resources', true );
$github_resources = is_array( $github_resources ) ? array_filter( $github_resources ) : array();

$related_wc_ids   = get_post_meta( $post_id, '_robo_lr_related_product_ids', true );
$valid_wc_ids     = ( class_exists( 'WooCommerce' ) && is_array( $related_wc_ids ) ) ? array_values( array_filter( $related_wc_ids ) ) : array();

// Fallbacks for thumbnail
$img_url = '';
if ( $list_img_id ) {
	$img_url = wp_get_attachment_image_url( $list_img_id, 'medium_large' );
} elseif ( has_post_thumbnail() ) {
	$img_url = get_the_post_thumbnail_url( $post_id, 'medium_large' );
}

$categories = get_the_terms( $post_id, 'learning_category' );
$cat_name   = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? $categories[0]->name : __( 'General', 'robo' );
?>

<div class="col">
	<div class="robo-lr-card h-100 shadow-sm border-0">
		<div class="robo-lr-card-thumb-wrapper">
			<?php if ( $img_url ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="robo-lr-card-thumb" loading="lazy">
			<?php else : ?>
				<div class="robo-lr-card-thumb d-flex align-items-center justify-content-center bg-dark text-white opacity-75">
					<i class="bi bi-journal-code fs-1"></i>
				</div>
			<?php endif; ?>

			<div class="robo-lr-card-badges">
				<?php echo robo_lr_render_badges( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<?php if ( $difficulty ) : ?>
				<span class="robo-lr-card-difficulty text-capitalize">
					<i class="bi bi-bar-chart-fill me-1"></i><?php echo esc_html( ucfirst( $difficulty ) ); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="robo-lr-card-body">
			<div class="robo-lr-card-category">
				<i class="bi bi-folder2-open me-1"></i><?php echo esc_html( $cat_name ); ?>
			</div>

			<h3 class="robo-lr-card-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>

			<?php if ( $short_desc ) : ?>
				<p class="robo-lr-card-desc"><?php echo esc_html( $short_desc ); ?></p>
			<?php else : ?>
				<p class="robo-lr-card-desc"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
			<?php endif; ?>

			<!-- Dynamic Action Buttons Row -->
			<div class="robo-lr-card-actions mt-auto pt-3 border-top d-flex flex-wrap gap-2">
				
				<!-- 1. Learn More -->
				<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center">
					Learn More <i class="bi bi-arrow-right ms-1"></i>
				</a>

				<!-- 2. Watch Video -->
				<?php if ( ! empty( $video_resources ) ) : ?>
					<a href="<?php echo esc_url( get_permalink() . '#section-videos' ); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center">
						<i class="bi bi-play-circle me-1"></i> Watch Video
					</a>
				<?php endif; ?>

				<!-- 3. PDF -->
				<?php if ( ! empty( $pdf_resources ) ) : ?>
					<a href="<?php echo esc_url( ! empty( $pdf_resources[0]['file_url'] ) ? $pdf_resources[0]['file_url'] : get_permalink() . '#section-pdfs' ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center">
						<i class="bi bi-file-earmark-pdf me-1"></i> PDF
					</a>
				<?php endif; ?>

				<!-- 4. Source Code -->
				<?php if ( ! empty( $github_resources ) ) : ?>
					<a href="<?php echo esc_url( ! empty( $github_resources[0]['url'] ) ? $github_resources[0]['url'] : get_permalink() . '#section-github' ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center">
						<i class="bi bi-github me-1"></i> Source Code
					</a>
				<?php endif; ?>

				<!-- 5. View Kit -->
				<?php if ( ! empty( $valid_wc_ids ) ) : ?>
					<?php $kit_p_id = $valid_wc_ids[0]; ?>
					<a href="<?php echo esc_url( get_permalink( $kit_p_id ) ); ?>" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center">
						<i class="bi bi-box-seam me-1"></i> View Kit
					</a>
				<?php endif; ?>

			</div>
		</div>
	</div>
</div>
