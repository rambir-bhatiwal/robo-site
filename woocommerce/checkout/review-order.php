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
<table class="shop_table woocommerce-checkout-review-order-table table table-borderless align-middle mb-0">
	<thead>
		<tr class="border-bottom border-light-subtle">
			<th class="product-name px-0 pb-3 text-dark fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total px-0 pb-3 text-end text-dark fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> border-bottom border-light-subtle">
					<td class="product-name px-0 py-3">
						<div class="d-flex align-items-center gap-3">
							<div class="product-thumbnail flex-shrink-0 position-relative">
								<?php
								$thumbnail = $_product->get_image( array( 64, 64 ), array( 'class' => 'rounded border border-light-subtle object-fit-cover shadow-sm bg-white' ) );
								echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary border border-light" style="font-size: 0.75rem; padding: 0.35em 0.55em;">
									<?php echo esc_html( $cart_item['quantity'] ); ?>
								</span>
							</div>
							<div class="product-info min-w-0 flex-grow-1">
								<h6 class="product-title mb-0 fw-semibold text-dark text-truncate" title="<?php echo esc_attr( $_product->get_name() ); ?>">
									<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
								</h6>
								<div class="text-muted small mt-1 d-flex flex-wrap align-items-center gap-2">
									<span class="each-price fw-medium"><?php echo WC()->cart->get_product_price( $_product ); ?> <?php esc_html_e( 'each', 'robo' ); ?></span>
									<?php if ( $cart_item['quantity'] > 1 ) : ?>
										<span class="qty text-muted-subtle">&bull; Qty: <?php echo esc_html( $cart_item['quantity'] ); ?></span>
									<?php endif; ?>
								</div>
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>
					</td>
					<td class="product-total px-0 py-3 text-end fw-semibold text-dark">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot class="border-top border-light-subtle">

		<tr class="cart-subtotal border-bottom border-light-subtle">
			<th class="px-0 py-2.5 text-muted fw-normal" style="font-size: 0.9rem;"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td class="px-0 py-2.5 text-end text-dark fw-semibold" style="font-size: 0.9rem;"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> border-bottom border-light-subtle">
				<th class="px-0 py-2.5 text-success fw-normal d-flex align-items-center gap-1" style="font-size: 0.9rem;">
					<i class="bi bi-tag-fill"></i>
					<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				</th>
				<td class="px-0 py-2.5 text-end text-success fw-semibold" style="font-size: 0.9rem;"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee border-bottom border-light-subtle">
				<th class="px-0 py-2.5 text-muted fw-normal" style="font-size: 0.9rem;"><?php echo esc_html( $fee->name ); ?></th>
				<td class="px-0 py-2.5 text-end text-dark fw-semibold" style="font-size: 0.9rem;"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?> border-bottom border-light-subtle">
						<th class="px-0 py-2.5 text-muted fw-normal" style="font-size: 0.9rem;"><?php echo esc_html( $tax->label ); ?></th>
						<td class="px-0 py-2.5 text-end text-dark fw-semibold" style="font-size: 0.9rem;"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total border-bottom border-light-subtle">
					<th class="px-0 py-2.5 text-muted fw-normal" style="font-size: 0.9rem;"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td class="px-0 py-2.5 text-end text-dark fw-semibold" style="font-size: 0.9rem;"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<th class="px-0 pt-3 pb-0 text-dark fw-bold" style="font-size: 1.15rem;"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td class="px-0 pt-3 pb-0 text-end text-primary fw-bold" style="font-size: 1.25rem;"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>
