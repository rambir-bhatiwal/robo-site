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

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, return
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout mt-2" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="row g-4">
		<!-- Left Column: Customer details (Billing & Shipping) -->
		<div class="col-lg-7 col-xl-8">
			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div id="customer_details">
					<!-- Billing details card -->
					<div class="card border-0 shadow-sm p-4 mb-4">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>

					<!-- Shipping details card -->
					<div class="card border-0 shadow-sm p-4 mb-4">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>
		</div>

		<!-- Right Column: Order Review & Payments -->
		<div class="col-lg-5 col-xl-4">
			<div class="checkout-sidebar sticky-top" style="top: 100px; z-index: 9;">
				
				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
				
				<h5 class="fw-bold text-dark text-uppercase mb-3 px-1 tracking-wider d-flex align-items-center" style="font-size: 0.85rem; letter-spacing: 0.5px;">
					<i class="bi bi-cart-check-fill me-2 text-primary fs-5"></i>
					<span><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></span>
				</h5>
				
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				<div id="order_review" class="woocommerce-checkout-review-order card border-0 shadow-sm p-4 mb-4">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
				
			</div>
		</div>
	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
