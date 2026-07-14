<?php
/**
 * WooCommerce page banner component.
 *
 * @package Robo
 */

defined( 'ABSPATH' ) || exit;

// Determine page title dynamically
$banner_title = '';
if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
	$banner_title = woocommerce_page_title( false );
} elseif ( is_cart() ) {
	$banner_title = __( 'Cart', 'robo' );
} elseif ( is_checkout() ) {
	if ( is_wc_endpoint_url( 'order-received' ) ) {
		$banner_title = __( 'Order Received', 'robo' );
	} else {
		$banner_title = __( 'Checkout', 'robo' );
	}
} elseif ( is_account_page() ) {
	$banner_title = __( 'My Account', 'robo' );
} else {
	$banner_title = get_the_title();
}
?>

<!-- Shop Header Banner (Full Width, outside the main container wrapper) -->
<div class="shop-header-banner py-5 bg-dark text-white text-center position-relative overflow-hidden mb-3">
	<div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50 z-0"></div>
	<div class="container position-relative z-1 py-3 px-4">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<h1 class="woocommerce-products-header__title page-title display-5 fw-extrabold text-uppercase tracking-wider text-white mb-2">
				<?php echo esc_html( $banner_title ); ?>
			</h1>
		<?php endif; ?>
		
		<?php
		// Only show description on shop and product taxonomy archive pages
		if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
			/**
			 * Hook: woocommerce_archive_description.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		}
		?>
	</div>
</div>
