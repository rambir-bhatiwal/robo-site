<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     10.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) :
	/**
	 * Ensure all images of related products are lazy loaded by increasing the
	 * current media count to WordPress's lazy loading threshold if needed.
	 * Because wp_increase_content_media_count() is a private function, we
	 * check for its existence before use.
	 */
	if ( function_exists( 'wp_increase_content_media_count' ) ) {
		$content_media_count = wp_increase_content_media_count( 0 );
		if ( $content_media_count < wp_omit_loading_attr_threshold() ) {
			wp_increase_content_media_count( wp_omit_loading_attr_threshold() - $content_media_count );
		}
	}
	?>

	<section class="related products my-4">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related Products', 'robo' ) );

		if ( $heading ) :
			?>
			<h2 class="h4 mb-4 fw-bold text-dark d-flex align-items-center gap-2 border-bottom border-light-subtle pb-3">
				<i class="bi bi-grid-fill text-primary"></i> <?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">

			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
				$post_object = get_post( $related_product->get_id() );

				setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

				wc_get_template_part( 'content', 'product' );
				?>

			<?php endforeach; ?>

		</div>

	</section>
	<?php
endif;

wp_reset_postdata();
