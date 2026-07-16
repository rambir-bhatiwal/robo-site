<?php
/**
 * The Template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * @package Robo
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$index = isset( $index ) ? absint( $index ) : 0;
?>
<form role="search" method="get" class="woocommerce-product-search mb-0" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="form-label fw-bold" for="woocommerce-product-search-field-<?php echo $index; ?>"><?php esc_html_e( 'Search Products', 'robo' ); ?></label>
	<div class="search-field-wrapper mb-3">
		<input type="search" id="woocommerce-product-search-field-<?php echo $index; ?>" class="search-field form-control" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'robo' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</div>
	<button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2" value="<?php echo esc_attr__( 'Search', 'robo' ); ?>">
		<i class="bi bi-search"></i> <?php esc_html_e( 'Search', 'robo' ); ?>
	</button>
	<input type="hidden" name="post_type" value="product" />
</form>
