<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="woocommerce-MyAccount-dashboard">
	<!-- Welcome Banner -->
	<div class="bg-light p-4 rounded-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
		<div>
			<h4 class="mb-1 fw-bold text-dark">
				<?php
				printf(
					/* translators: 1: user display name */
					esc_html__( 'Welcome back, %s!', 'robo' ),
					esc_html( $current_user->display_name )
				);
				?>
			</h4>
			<p class="text-muted mb-0 small">
				<?php esc_html_e( 'Manage your orders, addresses, and account details from your secure dashboard.', 'robo' ); ?>
			</p>
		</div>
		<div>
			<a href="<?php echo esc_url( wc_logout_url() ); ?>" class="btn btn-outline-danger btn-sm fw-bold px-3">
				<i class="bi bi-box-arrow-right me-1"></i>
				<?php esc_html_e( 'Log out', 'woocommerce' ); ?>
			</a>
		</div>
	</div>

	<!-- Quick Actions Grid -->
	<div class="row g-3 mb-4">
		<!-- Orders Card -->
		<div class="col-12 col-sm-6 col-md-4">
			<div class="card border border-light-subtle h-100 p-3 shadow-sm hover-shadow-md transition">
				<div class="card-body d-flex flex-column align-items-center text-center p-3">
					<div class="rounded-circle bg-primary-subtle text-primary p-3 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
						<i class="bi bi-bag fs-3"></i>
					</div>
					<h5 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Orders', 'woocommerce' ); ?></h5>
					<p class="text-muted small mb-4 flex-grow-1"><?php esc_html_e( 'View your purchase history, order status, and track shipments.', 'robo' ); ?></p>
					<a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>" class="btn btn-outline-primary btn-sm w-100 fw-bold"><?php esc_html_e( 'View Orders', 'robo' ); ?></a>
				</div>
			</div>
		</div>

		<!-- Addresses Card -->
		<div class="col-12 col-sm-6 col-md-4">
			<div class="card border border-light-subtle h-100 p-3 shadow-sm hover-shadow-md transition">
				<div class="card-body d-flex flex-column align-items-center text-center p-3">
					<div class="rounded-circle bg-success-subtle text-success p-3 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
						<i class="bi bi-geo-alt fs-3"></i>
					</div>
					<h5 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Addresses', 'woocommerce' ); ?></h5>
					<p class="text-muted small mb-4 flex-grow-1"><?php esc_html_e( 'Manage your shipping and billing addresses for faster checkout.', 'robo' ); ?></p>
					<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>" class="btn btn-outline-success btn-sm w-100 fw-bold"><?php esc_html_e( 'Manage Addresses', 'robo' ); ?></a>
				</div>
			</div>
		</div>

		<!-- Account Details Card -->
		<div class="col-12 col-sm-6 col-md-4">
			<div class="card border border-light-subtle h-100 p-3 shadow-sm hover-shadow-md transition">
				<div class="card-body d-flex flex-column align-items-center text-center p-3">
					<div class="rounded-circle bg-warning-subtle text-warning p-3 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
						<i class="bi bi-person-gear fs-3"></i>
					</div>
					<h5 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Account Details', 'woocommerce' ); ?></h5>
					<p class="text-muted small mb-4 flex-grow-1"><?php esc_html_e( 'Update your password, name, and contact details.', 'robo' ); ?></p>
					<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="btn btn-outline-warning btn-sm w-100 fw-bold"><?php esc_html_e( 'Edit Profile', 'robo' ); ?></a>
				</div>
			</div>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_account_dashboard.
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 */
	do_action( 'woocommerce_after_my_account' );
	?>
</div>
