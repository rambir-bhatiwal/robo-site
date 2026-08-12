<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Robo
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

// Product Category Name
$terms    = get_the_terms( $product->get_id(), 'product_cat' );
$cat_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'Robotics', 'robo' );

// Sale percentage calculation if on sale
$is_on_sale = $product->is_on_sale();
$sale_label = __( 'Sale', 'robo' );
if ( $is_on_sale ) {
	$percentage = 0;
	if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
		$regular_price = floatval( $product->get_regular_price() );
		$sale_price    = floatval( $product->get_sale_price() );
		if ( $regular_price > 0 ) {
			$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
		}
	} elseif ( $product->is_type( 'variable' ) ) {
		$prices      = $product->get_variation_prices();
		$max_percent = 0;
		if ( isset( $prices['regular_price'] ) && is_array( $prices['regular_price'] ) ) {
			foreach ( $prices['regular_price'] as $key => $regular_price ) {
				$sale_price = floatval( $prices['sale_price'][ $key ] );
				$regular    = floatval( $regular_price );
				if ( $regular > 0 && $sale_price < $regular ) {
					$percent = round( ( ( $regular - $sale_price ) / $regular ) * 100 );
					if ( $percent > $max_percent ) {
						$max_percent = $percent;
					}
				}
			}
		}
		$percentage = $max_percent;
	}
	if ( $percentage > 0 ) {
		$sale_label = sprintf( __( '-%d%%', 'robo' ), $percentage );
	}
}
?>
<div class="col product-grid-item">
	<div <?php wc_product_class( 'robo-popular-products__card product-card position-relative', $product ); ?>>
		<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 */
		do_action( 'woocommerce_before_shop_loop_item' );
		?>
		
		<!-- Image & Overlay Container (Identical structure to Home Popular Products) -->
		<div class="robo-product-image-wrap">
			<?php if ( $is_on_sale ) : ?>
				<span class="robo-product-badge-sale">
					<?php echo esc_html( $sale_label ); ?>
				</span>
			<?php endif; ?>

			<!-- Top Quick Action Buttons overlay (Wishlist / Quick View) -->
			<div class="robo-product-top-actions">
				<button type="button" 
						class="robo-product-action-btn robo-product-action-btn--wishlist add-to-wishlist-btn" 
						data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" 
						aria-label="<?php esc_attr_e( 'Add to Wishlist', 'robo' ); ?>" 
						title="<?php esc_attr_e( 'Add to Wishlist', 'robo' ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
				</button>

				<button type="button" 
						class="robo-product-action-btn robo-product-action-btn--quickview quick-view-btn" 
						data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" 
						data-bs-toggle="modal" 
						data-bs-target="#roboQuickViewModal" 
						aria-label="<?php esc_attr_e( 'Quick View', 'robo' ); ?>" 
						title="<?php esc_attr_e( 'Quick View', 'robo' ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
				</button>
			</div>

			<!-- Product Image Link -->
			<a href="<?php the_permalink(); ?>" class="d-flex align-items-center justify-content-center w-100 h-100 product-image-link">
				<?php
				$image_id  = $product->get_image_id();
				$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium_large' ) : wc_placeholder_img_src( 'medium_large' );
				?>
				<img src="<?php echo esc_url( $image_url ); ?>" 
					 class="product-card-img" 
					 alt="<?php echo esc_attr( $product->get_name() ); ?>"
					 loading="lazy">
			</a>
		</div>

		<!-- Card Body (Identical structure to Home Popular Products) -->
		<div class="robo-product-card__body py-2">
			<!-- Category -->
			<div class="robo-product-category">
				<span class="robo-product-category-badge">
					<?php echo esc_html( $cat_name ); ?>
				</span>
			</div>

			<!-- Title -->
			<h3 class="robo-product-title">
				<a href="<?php the_permalink(); ?>">
					<?php echo esc_html( $product->get_name() ); ?>
				</a>
			</h3>

			<!-- Price -->
			<div class="robo-product-price">
				<?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<!-- Add To Cart -->
			<div class="robo-product-actions">
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

