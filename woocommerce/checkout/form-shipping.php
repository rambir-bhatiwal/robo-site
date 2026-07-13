<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-shipping-fields-wrapper">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<div class="card border-0 shadow-sm p-4 mb-4 woocommerce-shipping-fields-card">
			<h4 id="ship-to-different-address" class="mb-3">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox fw-bold text-dark d-flex align-items-center gap-2 m-0" style="font-size: 1.15rem; cursor: pointer;">
					<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox form-check-input" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> 
					<span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
				</label>
			</h4>

			<div class="shipping_address mt-3 pt-3 border-top border-light-subtle">

				<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

				<div class="woocommerce-shipping-fields__field-wrapper row">
					<?php
					$fields = $checkout->get_checkout_fields( 'shipping' );

					foreach ( $fields as $key => $field ) {
						woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
					}
					?>
				</div>

				<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

			</div>
		</div>

	<?php endif; ?>
</div>

<div class="woocommerce-additional-fields-wrapper">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<div class="card border-0 shadow-sm p-4 mb-4 woocommerce-additional-fields-card">
			
			<h4 class="fw-bold text-dark mb-3" style="font-size: 1.15rem;">
				<i class="bi bi-chat-left-text-fill me-2 text-primary"></i>
				<span><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></span>
			</h4>

			<div class="woocommerce-additional-fields__field-wrapper row">
				<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
			</div>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
