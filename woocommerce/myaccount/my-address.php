<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}
?>

<div class="woocommerce-Addresses-wrapper">
	<p class="text-muted small mb-4">
		<i class="bi bi-info-circle text-info me-1"></i>
		<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</p>

	<div class="row g-4">
		<?php foreach ( $get_addresses as $name => $address_title ) : ?>
			<?php $address = wc_get_account_formatted_address( $name ); ?>

			<div class="col-12 col-md-6">
				<div class="card border border-light-subtle h-100 shadow-sm">
					<div class="card-header bg-light py-3 border-bottom d-flex align-items-center justify-content-between">
						<h5 class="mb-0 fw-bold text-white fs-6">
							<i class="bi <?php echo 'billing' === $name ? 'bi-file-earmark-text' : 'bi-truck'; ?> text-primary me-2"></i>
							<?php echo esc_html( $address_title ); ?>
						</h5>
						<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="btn btn-outline-primary btn-sm fw-bold">
							<i class="bi bi-pencil-square me-1"></i>
							<?php echo $address ? esc_html__( 'Edit', 'woocommerce' ) : esc_html__( 'Add', 'woocommerce' ); ?>
						</a>
					</div>
					<div class="card-body p-4 fs-6 text-muted lh-lg">
						<address class="mb-0">
							<?php
								echo $address ? wp_kses_post( $address ) : esc_html__( 'You have not set up this type of address yet.', 'woocommerce' );

								/**
								 * Used to output content after core address fields.
								 *
								 * @param string $name Address type.
								 * @since 8.7.0
								 */
								do_action( 'woocommerce_my_account_after_my_address', $name );
							?>
						</address>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
