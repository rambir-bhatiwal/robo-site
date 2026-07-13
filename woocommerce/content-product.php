<?php
/**
 * The template for displaying product content within loops
 *
 * @package Robo
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product object exists and is visible.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="col product-grid-item">
	<div <?php wc_product_class( 'card h-100 border-0 shadow-sm overflow-hidden product-card position-relative transition-all bg-white', $product ); ?>>
		<div class="row g-0 h-100 product-card-row">
			
			<!-- Image Section -->
			<div class="col-12 product-card-img-col position-relative overflow-hidden bg-light border-bottom d-flex align-items-center justify-content-center">
				<!-- Badges Overlay -->
				<?php echo robo_woocommerce_get_badges( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				
				<!-- Quick Action Buttons overlay (Wishlist / Quick View) -->
				<div class="product-actions-overlay position-absolute bottom-0 start-0 w-100 p-3 d-flex justify-content-center gap-2 z-2 transition-all opacity-0">
					<button class="btn btn-white btn-sm rounded-circle shadow-sm hover-primary add-to-wishlist-btn" 
							data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" 
							title="<?php esc_attr_e( 'Add to Wishlist', 'robo' ); ?>">
						<i class="bi bi-heart"></i>
					</button>
					<button class="btn btn-white btn-sm rounded-circle shadow-sm hover-primary quick-view-btn" 
							data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" 
							data-bs-toggle="modal" 
							data-bs-target="#roboQuickViewModal" 
							title="<?php esc_attr_e( 'Quick View', 'robo' ); ?>">
						<i class="bi bi-eye"></i>
					</button>
				</div>
				
				<!-- Product Link & Thumbnail -->
				<a href="<?php the_permalink(); ?>" class="d-block w-100 h-100 product-image-link">
					<?php
					$image_id  = $product->get_image_id();
					$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium_large' ) : wc_placeholder_img_src( 'medium_large' );
					?>
					<img src="<?php echo esc_url( $image_url ); ?>" 
						 class="card-img-top object-fit-cover w-100 h-100 transition-all product-card-img" 
						 alt="<?php echo esc_attr( $product->get_name() ); ?>"
						 style="aspect-ratio: 1/1;">
				</a>
			</div>
			
			<!-- Content Details Section -->
			<div class="col-12 product-card-body-col card-body d-flex flex-column justify-content-between p-3">
				<div class="product-info-wrapper">
					<!-- Product Categories -->
					<?php
					$categories = wc_get_product_category_list( $product->get_id(), ', ', '<span class="product-categories small text-muted text-uppercase fw-bold d-block mb-1">', '</span>' );
					if ( $categories ) {
						echo wp_kses_post( $categories );
					} else {
						// Space holder to prevent layout shifting
						echo '<span class="product-categories small text-muted text-uppercase fw-bold d-block mb-1 opacity-25">&nbsp;</span>';
					}
					?>
					
					<!-- Product Title -->
					<h5 class="card-title product-title mb-1 fw-bold h6 text-dark" style="font-size: 0.95rem; line-height: 1.4;">
						<a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark hover-primary line-clamp-2">
							<?php echo esc_html( $product->get_name() ); ?>
						</a>
					</h5>
					
					<!-- Rating Stars -->
					<?php echo robo_woocommerce_get_rating_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				
				<div class="product-price-action-wrapper mt-3">
					<!-- Pricing -->
					<div class="price mb-3 text-primary fw-bold fs-5">
						<?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					
					<!-- Add To Cart -->
					<div class="add-to-cart-wrapper w-100">
						<?php
						/**
						 * Hook: woocommerce_after_shop_loop_item.
						 *
						 * @hooked woocommerce_template_loop_add_to_cart - 10
						 */
						do_action( 'woocommerce_after_shop_loop_item' );
						?>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
