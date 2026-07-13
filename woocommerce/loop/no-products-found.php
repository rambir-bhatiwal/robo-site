<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * @package Robo
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="no-products-found-wrapper text-center py-5 px-4 bg-white rounded shadow-sm border border-light-subtle my-4">
	<!-- Graphic/Icon -->
	<div class="empty-shop-icon-wrapper mb-4">
		<div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle p-4" style="width: 100px; height: 100px;">
			<i class="bi bi-cart-x fs-1"></i>
		</div>
	</div>

	<!-- Main Message -->
	<h2 class="h3 fw-bold text-dark mb-3"><?php esc_html_e( 'No Products Found', 'robo' ); ?></h2>
	
	<!-- Subtext -->
	<p class="text-muted mx-auto mb-4" style="max-width: 500px; line-height: 1.6;">
		<?php esc_html_e( 'We couldn\'t find any products matching your current selection or search terms. Try clearing some filters, adjusting your price range, or searching for a different keyword.', 'robo' ); ?>
	</p>

	<!-- Live search widget -->
	<div class="search-form-container mx-auto mb-4" style="max-width: 400px;">
		<?php
		if ( class_exists( 'WooCommerce' ) ) {
			the_widget( 'WC_Widget_Product_Search', array( 'title' => '' ) );
		}
		?>
	</div>

	<!-- Call to Action -->
	<div class="cta-actions pt-2">
		<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>" class="btn btn-primary btn-lg px-4 py-2.5 fw-bold rounded shadow-sm hover-up transition-all">
			<i class="bi bi-arrow-left me-2"></i><?php esc_html_e( 'Return to Shop', 'robo' ); ?>
		</a>
	</div>
</div>
