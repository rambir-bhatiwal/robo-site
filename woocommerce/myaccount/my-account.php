<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="row g-4 justify-content-center">
	<!-- Left: Sidebar Navigation -->
	<div class="col-12 col-md-4 col-lg-3 woocommerce-MyAccount-navigation-col">
		<?php
		/**
		 * My Account navigation.
		 */
		do_action( 'woocommerce_account_navigation' );
		?>
	</div>

	<!-- Right: Content Display Area -->
	<div class="col-12 col-md-8 col-lg-9 woocommerce-MyAccount-content-col">
		<div class="woocommerce-MyAccount-content card border-0 shadow-sm p-4 p-md-5 bg-white rounded-3">
			<?php
			/**
			 * My Account content.
			 */
			do_action( 'woocommerce_account_content' );
			?>
		</div>
	</div>
</div>
