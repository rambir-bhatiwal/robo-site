<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals card border-0 shadow-sm overflow-hidden mb-4 <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
	
	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<div class="card-header bg-white border-bottom py-3">
		<h5 class="mb-0 fw-bold text-dark text-uppercase tracking-wider" style="font-size: 0.85rem; letter-spacing: 0.5px;"><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></h5>
	</div>

	<div class="card-body p-4">
		<table cellspacing="0" class="table table-borderless align-middle mb-0 text-muted shop_table shop_table_responsive" style="font-size: 0.92rem;">
			<tbody>
				<!-- Subtotal -->
				<tr class="cart-subtotal border-bottom">
					<td class="ps-0 py-3 text-dark"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></td>
					<td class="pe-0 text-end fw-semibold text-dark py-3" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
				</tr>

				<!-- Coupons -->
				<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
					<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> border-bottom">
						<td class="ps-0 py-3 text-success d-flex align-items-center">
							<i class="bi bi-tag-fill me-2"></i>
							<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
						</td>
						<td class="pe-0 text-end fw-bold text-success py-3" data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
					</tr>
				<?php endforeach; ?>

				<!-- Shipping -->
				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

					<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

					<?php wc_cart_totals_shipping_html(); ?>

					<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

				<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

					<tr class="shipping border-bottom">
						<td class="ps-0 py-3 text-dark"><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></td>
						<td class="pe-0 text-end py-3" data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></td>
					</tr>

				<?php endif; ?>

				<!-- Fees -->
				<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
					<tr class="fee border-bottom">
						<td class="ps-0 py-3 text-dark"><?php echo esc_html( $fee->name ); ?></td>
						<td class="pe-0 text-end fw-semibold text-dark py-3" data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
					</tr>
				<?php endforeach; ?>

				<!-- Tax -->
				<?php
				if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
					$taxable_address = WC()->customer->get_taxable_address();
					$estimated_text  = '';

					if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
						/* translators: %s location. */
						$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
					}

					if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
						foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
							?>
							<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?> border-bottom">
								<td class="ps-0 py-3 text-dark"><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
								<td class="pe-0 text-end fw-semibold text-dark py-3" data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="tax-total border-bottom">
							<td class="ps-0 py-3 text-dark"><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
							<td class="pe-0 text-end fw-semibold text-dark py-3" data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
						</tr>
						<?php
					}
				}
				?>

				<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

				<!-- Order Total -->
				<tr class="order-total border-top border-2">
					<td class="ps-0 py-3 fw-bold text-dark" style="font-size: 1.05rem;"><?php esc_html_e( 'Total', 'woocommerce' ); ?></td>
					<td class="pe-0 text-end fw-bold text-primary py-3" style="font-size: 1.25rem;" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
				</tr>

				<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

			</tbody>
		</table>

		<!-- Proceed to Checkout Button -->
		<div class="wc-proceed-to-checkout mt-4">
			<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
