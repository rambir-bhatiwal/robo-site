<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<div class="alert alert-danger mb-4 shadow-sm" role="alert">
				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed mb-0"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>
			</div>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions d-flex gap-2 flex-wrap">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="btn btn-primary pay w-100 w-sm-auto"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="btn btn-outline-secondary pay w-100 w-sm-auto"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<div class="mb-4">
				<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>
			</div>

			<div class="card border-0 shadow-sm mb-4">
				<div class="card-header bg-dark py-3 border-bottom border-light-subtle">
					<h5 class="mb-0 fw-bold text-white text-uppercase tracking-wider d-flex align-items-center gap-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
						<i class="bi bi-info-circle-fill text-white"></i>
						<span><?php esc_html_e( 'Order Overview', 'robo' ); ?></span>
					</h5>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table align-middle mb-0 woocommerce-table woocommerce-table--order-overview shop_table order_details">
							<tbody>
								<tr>
									<th class="text-muted fw-semibold py-3 ps-4" style="width: 35%;"><?php esc_html_e( 'Order number:', 'woocommerce' ); ?></th>
									<td class="text-dark fw-bold py-3 pe-4"><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
								</tr>
								<tr>
									<th class="text-muted fw-semibold py-3 ps-4"><?php esc_html_e( 'Date:', 'woocommerce' ); ?></th>
									<td class="text-dark py-3 pe-4"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
								</tr>
								<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
									<tr>
										<th class="text-muted fw-semibold py-3 ps-4"><?php esc_html_e( 'Email:', 'woocommerce' ); ?></th>
										<td class="text-dark py-3 pe-4 text-break"><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
									</tr>
								<?php endif; ?>
								<tr>
									<th class="text-muted fw-semibold py-3 ps-4"><?php esc_html_e( 'Total:', 'woocommerce' ); ?></th>
									<td class="text-primary fw-bold py-3 pe-4"><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
								</tr>
								<?php if ( $order->get_payment_method_title() ) : ?>
									<tr>
										<th class="text-muted fw-semibold py-3 ps-4"><?php esc_html_e( 'Payment method:', 'woocommerce' ); ?></th>
										<td class="text-dark py-3 pe-4"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<!-- Backwards compatibility for plugins targetting default UL structure -->
			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details d-none">
				<li class="order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); ?></strong>
				</li>
				<li class="date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
				</li>
				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); ?></strong>
					</li>
				<?php endif; ?>
				<li class="total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); ?></strong>
				</li>
				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>
			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
