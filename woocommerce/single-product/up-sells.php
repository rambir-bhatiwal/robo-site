<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

	<section class="up-sells upsells products my-4">

		<?php
		$heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'You may also like...', 'robo' ) );

		if ( $heading ) :
			?>
			<h2 class="h4 mb-4 fw-bold text-dark d-flex align-items-center gap-2 border-bottom border-light-subtle pb-3">
				<i class="bi bi-heart-fill text-danger"></i> <?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
				$post_object = get_post( $upsell->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

				wc_get_template_part( 'content', 'product' );
				?>

			<?php endforeach; ?>

		</div>

	</section>
	<?php
endif;

wp_reset_postdata();
