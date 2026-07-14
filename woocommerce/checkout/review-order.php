<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-checkout-review-order-table">
	<!-- Header -->
	<div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3 fw-bold text-dark text-uppercase tracking-wider" style="font-size: 0.85rem; letter-spacing: 0.5px;">
		<div><?php esc_html_e( 'Product', 'woocommerce' ); ?></div>
		<div><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
	</div>

	<!-- Products List -->
	<div class="review-order-items">
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<div class="review-order-item d-flex align-items-center justify-content-between border-bottom border-light-subtle" style="padding: 20px 0; gap: 20px;">
					<!-- Left: Image + Info -->
					<div class="d-flex align-items-center" style="gap: 20px; flex: 1 1 auto; min-width: 0;">
						<div class="product-thumbnail flex-shrink-0 position-relative" style="width: 70px; height: 70px;">
							<?php
							$thumbnail = $_product->get_image( array( 70, 70 ), array( 'class' => 'rounded border border-light-subtle object-fit-cover shadow-sm bg-white w-100 h-100' ) );
							echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<span class="position-absolute badge rounded-pill bg-secondary border border-light" style="font-size: 0.72rem; padding: 0.35em 0.6em; top: -6px; right: -6px; z-index: 2;">
								<?php echo esc_html( $cart_item['quantity'] ); ?>
							</span>
						</div>
						<div class="product-info min-w-0 flex-grow-1">
							<h6 class="product-title mb-1 fw-semibold text-dark text-truncate" title="<?php echo esc_attr( $_product->get_name() ); ?>">
								<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
							</h6>
							<div class="product-price text-muted small">
								<?php echo WC()->cart->get_product_price( $_product ); ?>
							</div>
							<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>
					<!-- Right: Subtotal -->
					<div class="product-total fw-semibold text-dark text-end flex-shrink-0 ms-3">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</div>

	<!-- Totals -->
	<div class="review-order-totals pt-4 mt-2">
		<!-- Subtotal -->
		<div class="d-flex align-items-center justify-content-between py-2.5">
			<div class="text-muted"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
			<div class="text-dark fw-semibold"><?php wc_cart_totals_subtotal_html(); ?></div>
		</div>

		<!-- Coupons -->
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="d-flex align-items-center justify-content-between py-2.5 text-success">
				<div class="d-flex align-items-center gap-1">
					<i class="bi bi-tag-fill"></i>
					<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				</div>
				<div class="fw-bold"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
			</div>
		<?php endforeach; ?>

		<!-- Shipping -->
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
			<div class="shipping-section py-2.5">
				<div class="shipping-wrapper">
					<table class="table table-borderless p-0 m-0">
						<tbody>
							<?php wc_cart_totals_shipping_html(); ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
		<?php endif; ?>

		<!-- Fees -->
		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="d-flex align-items-center justify-content-between py-2.5">
				<div class="text-muted"><?php echo esc_html( $fee->name ); ?></div>
				<div class="text-dark fw-semibold"><?php wc_cart_totals_fee_html( $fee ); ?></div>
			</div>
		<?php endforeach; ?>

		<!-- Taxes -->
		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<div class="d-flex align-items-center justify-content-between py-2.5">
						<div class="text-muted"><?php echo esc_html( $tax->label ); ?></div>
						<div class="text-dark fw-semibold"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="d-flex align-items-center justify-content-between py-2.5">
					<div class="text-muted"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></div>
					<div class="text-dark fw-semibold"><?php wc_cart_totals_taxes_total_html(); ?></div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<!-- Total -->
		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
		<div class="d-flex align-items-center justify-content-between pt-4 mt-3 border-top border-light-subtle">
			<div class="text-dark fw-bold h5 mb-0"><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
			<div class="text-primary fw-bold h4 mb-0"><?php wc_cart_totals_order_total_html(); ?></div>
		</div>
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
	</div>
</div>
