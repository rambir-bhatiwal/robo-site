<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Robo
 * @version 10.5.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! class_exists( 'WooCommerce' ) || ! is_a( $product, 'WC_Product' ) ) {
	return;
}

$post_thumbnail_id = $product->get_image_id();
$attachment_ids    = $product->get_gallery_image_ids();
$gallery_items     = array();

// Build image collection
if ( $post_thumbnail_id ) {
	$gallery_items[] = $post_thumbnail_id;
}
if ( ! empty( $attachment_ids ) ) {
	$gallery_items = array_merge( $gallery_items, $attachment_ids );
}
if ( empty( $gallery_items ) ) {
	$gallery_items[] = 0; // Fallback to placeholder
}
?>

<div class="robo-product-gallery position-relative">
	<!-- Main Carousel -->
	<div id="roboProductGalleryCarousel" class="carousel slide" data-bs-ride="false" data-bs-touch="true">
		<div class="carousel-inner bg-light border border-light-subtle rounded overflow-hidden shadow-sm">
			
			<!-- WooCommerce Badges Overlay -->
			<?php
			if ( function_exists( 'robo_woocommerce_get_badges' ) ) {
				echo robo_woocommerce_get_badges( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
			
			<?php foreach ( $gallery_items as $index => $attachment_id ) : ?>
				<?php
				$active_class = ( 0 === $index ) ? 'active' : '';
				
				if ( 0 === $attachment_id ) {
					$image_url  = wc_placeholder_img_src( 'woocommerce_single' );
					$full_url   = wc_placeholder_img_src( 'full' );
					$alt_text   = esc_html__( 'Placeholder', 'robo' );
					$slide_html = '<img src="' . esc_url( $image_url ) . '" class="d-block w-100 object-fit-contain main-img" alt="' . esc_attr( $alt_text ) . '" />';
				} else {
					$image_url  = wp_get_attachment_image_url( $attachment_id, 'woocommerce_single' );
					$full_url   = wp_get_attachment_image_url( $attachment_id, 'full' );
					$alt_text   = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
					if ( empty( $alt_text ) ) {
						$alt_text = get_the_title( $attachment_id );
					}
					
					$html = wp_get_attachment_image(
						$attachment_id,
						'woocommerce_single',
						false,
						array(
							'class' => 'd-block w-100 object-fit-contain main-img',
							'alt'   => $alt_text,
						)
					);
					
					// Apply standard WooCommerce filters to ensure video/plugin compatibility
					$slide_html = apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
				}
				?>
				<div class="carousel-item <?php echo esc_attr( $active_class ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
					<div class="gallery-image-zoom-wrapper position-relative overflow-hidden w-100 h-100" data-zoom-image="<?php echo esc_url( $full_url ); ?>">
						<a href="<?php echo esc_url( $full_url ); ?>" class="d-block text-center gallery-lightbox-trigger w-100 h-100" data-gallery-index="<?php echo esc_attr( $index ); ?>">
							<?php echo $slide_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		
		<!-- Controls (Previous/Next Arrows) -->
		<?php if ( count( $gallery_items ) > 1 ) : ?>
			<button class="carousel-control-prev" type="button" data-bs-target="#roboProductGalleryCarousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon bg-dark bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" aria-hidden="true" style="background-size: 50%;"></span>
				<span class="visually-hidden"><?php esc_html_e( 'Previous', 'robo' ); ?></span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#roboProductGalleryCarousel" data-bs-slide="next">
				<span class="carousel-control-next-icon bg-dark bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" aria-hidden="true" style="background-size: 50%;"></span>
				<span class="visually-hidden"><?php esc_html_e( 'Next', 'robo' ); ?></span>
			</button>
		<?php endif; ?>
	</div>
	
	<!-- Thumbnails Navigation Row -->
	<?php if ( count( $gallery_items ) > 1 ) : ?>
		<div class="robo-gallery-thumbnails row g-2 mt-3 justify-content-start overflow-x-auto flex-nowrap pb-2 px-1">
			<?php foreach ( $gallery_items as $index => $attachment_id ) : ?>
				<?php
				if ( 0 === $attachment_id ) {
					$thumb_url = wc_placeholder_img_src( 'thumbnail' );
				} else {
					$thumb_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' );
				}
				$active_class = ( 0 === $index ) ? 'active border-primary shadow-sm' : 'border-light-subtle';
				?>
				<div class="col-auto">
					<button type="button" 
							data-bs-target="#roboProductGalleryCarousel" 
							data-bs-slide-to="<?php echo esc_attr( $index ); ?>" 
							class="thumb-btn btn p-0 border border-2 rounded overflow-hidden <?php echo esc_attr( $active_class ); ?>" 
							style="width: 64px; height: 64px;"
							aria-current="<?php echo ( 0 === $index ) ? 'true' : 'false'; ?>"
							aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'robo' ), $index + 1 ) ); ?>">
						<img src="<?php echo esc_url( $thumb_url ); ?>" class="w-100 h-100 object-fit-cover" alt="Thumbnail <?php echo esc_attr( $index + 1 ); ?>" />
					</button>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_product_thumbnails.
	 *
	 * @hooked woocommerce_show_product_thumbnails - 20
	 */
	do_action( 'woocommerce_product_thumbnails' );
	?>
</div>
