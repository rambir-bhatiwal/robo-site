<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Unhook default payment section from order review action to prevent duplicate rendering
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, return
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout mt-4" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="row g-4">
		<!-- Left Column: Customer details (Billing, Shipping, Additional Info, Coupon) -->
		<div class="col-lg-8 checkout-left-col">
			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div id="customer_details">
					<!-- Billing details card -->
					<div class="card border-0 shadow-sm p-4 mb-4 woocommerce-billing-fields-card">
						<h4 class="fw-bold text-dark mb-4" style="font-size: 1.15rem;">
							<i class="bi bi-person-fill-gear me-2 text-primary"></i>
							<span><?php esc_html_e( 'Billing details', 'woocommerce' ); ?></span>
						</h4>
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>

					<!-- Shipping details & Additional Information card (handled inside form-shipping.php) -->
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>

			<!-- Custom Coupon Card -->
			<?php if ( wc_coupons_enabled() ) : ?>
				<div class="card border-0 shadow-sm p-4 mb-4 robo-checkout-coupon-card">
					<h4 class="fw-bold text-dark mb-2" style="font-size: 1.15rem;">
						<i class="bi bi-tag-fill me-2 text-primary"></i>
						<span><?php esc_html_e( 'Have a Coupon?', 'robo' ); ?></span>
					</h4>
					<p class="text-muted small mb-3"><?php esc_html_e( 'Enter your promo code to get a discount on your order.', 'robo' ); ?></p>
					<div class="input-group gap-2 d-flex">
						<input type="text" id="robo_coupon_code" class="form-control rounded" placeholder="<?php esc_attr_e( 'Promo code', 'robo' ); ?>" style="height: 48px;" />
						<button type="button" id="robo_apply_coupon" class="btn btn-primary robo-btn"><?php esc_html_e( 'Apply', 'robo' ); ?></button>
					</div>
					<div id="robo_coupon_message" class="mt-2 small" style="display: none;"></div>
				</div>
			<?php endif; ?>
		</div>

		<!-- Right Column: Sticky Order Summary card & Payment Methods -->
		<div class="col-lg-4 checkout-right-col">
			<div class="checkout-sidebar sticky-top" style="top: 24px; z-index: 10;">
				
				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
				
				<!-- Card 1: Order Summary -->
				<div class="card border-0 shadow-sm p-4 mb-4 woocommerce-checkout-review-order-card">
					<h4 class="fw-bold text-dark mb-4 d-flex align-items-center justify-content-between" style="font-size: 1.15rem;">
						<span class="d-flex align-items-center">
							<i class="bi bi-bag-check-fill me-2 text-primary"></i>
							<span><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></span>
						</span>
						<span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill" style="font-size: 0.75rem;">
							<?php echo sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'robo' ), WC()->cart->get_cart_contents_count() ); ?>
						</span>
					</h4>
					
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
				</div>

				<!-- Card 2: Payment Method -->
				<div class="card border-0 shadow-sm mb-4 woocommerce-checkout-payment-card">
					<h4 class="fw-bold text-dark mb-4" style="font-size: 1.15rem;">
						<i class="bi bi-credit-card-2-front-fill me-2 text-primary"></i>
						<span><?php esc_html_e( 'Payment Method', 'woocommerce' ); ?></span>
					</h4>
					<div class="woocommerce-payment-fields-wrapper">
						<?php woocommerce_checkout_payment(); ?>
					</div>
				</div>
				
			</div>
		</div>
	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
