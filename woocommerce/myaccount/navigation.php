<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$icons = array(
	'dashboard'       => 'bi-speedometer2',
	'orders'          => 'bi-bag',
	'downloads'       => 'bi-download',
	'edit-address'    => 'bi-geo-alt',
	'payment-methods' => 'bi-credit-card',
	'edit-account'    => 'bi-person-gear',
	'customer-logout' => 'bi-box-arrow-right',
);
?>

<nav class="woocommerce-MyAccount-navigation mb-4 mb-md-0" aria-label="<?php esc_html_e( 'Account pages', 'woocommerce' ); ?>">
	<div class="list-group border-0 shadow-sm rounded-3">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : 
			$is_active = wc_is_current_account_menu_item( $endpoint );
			$icon_class = isset( $icons[ $endpoint ] ) ? $icons[ $endpoint ] : 'bi-arrow-right-short';
			
			// Build active/inactive classes
			$list_item_classes = 'list-group-item list-group-item-action d-flex align-items-center gap-2 py-3 px-4 fw-medium border-0 transition';
			if ( $is_active ) {
				$list_item_classes .= ' bg-primary text-white active';
			} else {
				$list_item_classes .= ' bg-white text-muted';
			}
			?>
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" 
			   class="<?php echo esc_attr( $list_item_classes ); ?>" 
			   <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
				<i class="bi <?php echo esc_attr( $icon_class ); ?> fs-5"></i>
				<span><?php echo esc_html( $label ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
