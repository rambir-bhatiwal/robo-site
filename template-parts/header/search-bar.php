<?php
/**
 * Template part for displaying WooCommerce Product Search Bar.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$unique_id   = isset( $args['id_suffix'] ) ? '-' . esc_attr( $args['id_suffix'] ) : '';
$input_id    = 'robo-product-search-input' . $unique_id;
$dropdown_id = 'robo-search-dropdown' . $unique_id;
$btn_class   = isset( $args['btn_class'] ) ? $args['btn_class'] : 'btn-primary';
$is_mobile   = isset( $args['is_mobile'] ) && $args['is_mobile'];
?>
<div class="robo-search-wrapper position-relative w-100">
	<form role="search" method="get" class="robo-search-form position-relative m-0" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="<?php echo esc_attr( $input_id ); ?>" class="visually-hidden"><?php esc_html_e( 'Search products', 'robo' ); ?></label>
		
		<div class="input-group <?php echo $is_mobile ? 'input-group-md' : 'input-group-sm'; ?> rounded-pill overflow-hidden border bg-white shadow-sm robo-search-input-group transition-all">
			<!-- Search Icon -->
			<span class="input-group-text bg-transparent border-0 pe-1 ps-3 text-muted">
				<i class="bi bi-search search-icon" aria-hidden="true"></i>
			</span>
			
			<!-- Input Field -->
			<input type="search" 
				   id="<?php echo esc_attr( $input_id ); ?>" 
				   class="form-control bg-transparent border-0 shadow-none ps-2 pe-2 robo-search-input py-2" 
				   placeholder="<?php esc_attr_e( 'Search products&hellip;', 'robo' ); ?>" 
				   value="<?php echo get_search_query(); ?>" 
				   name="s" 
				   autocomplete="off"
				   role="combobox"
				   aria-expanded="false"
				   aria-autocomplete="list"
				   aria-controls="<?php echo esc_attr( $dropdown_id ); ?>"
				   aria-haspopup="listbox"
				   aria-label="<?php esc_attr_e( 'Search products', 'robo' ); ?>">

			<!-- Clear Input Button -->
			<button type="button" class="btn border-0 p-0 text-muted robo-search-clear-btn d-none me-2" aria-label="<?php esc_attr_e( 'Clear search input', 'robo' ); ?>">
				<i class="bi bi-x-circle-fill fs-6"></i>
			</button>

			<!-- Loading Spinner -->
			<span class="robo-search-spinner position-absolute end-0 top-50 translate-middle-y me-5 d-none">
				<div class="spinner-border spinner-border-sm text-primary" role="status" style="width: 0.85rem; height: 0.85rem; border-width: 0.15em;">
					<span class="visually-hidden"><?php esc_html_e( 'Loading...', 'robo' ); ?></span>
				</div>
			</span>

			<!-- Search Submit Button -->
			<button type="submit" class="btn <?php echo esc_attr( $btn_class ); ?> rounded-pill px-3 py-1 fw-semibold d-flex align-items-center justify-content-center gap-1 robo-search-submit-btn" aria-label="<?php esc_attr_e( 'Search', 'robo' ); ?>">
				<span><?php esc_html_e( 'Search', 'robo' ); ?></span>
			</button>
		</div>

		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<input type="hidden" name="post_type" value="product" />
		<?php endif; ?>
	</form>

	<!-- Live Search Dropdown -->
	<div id="<?php echo esc_attr( $dropdown_id ); ?>" 
		 class="dropdown-menu shadow-lg border-0 rounded-3 w-100 mt-2 p-0 overflow-hidden position-absolute start-0 end-0 z-3 robo-search-dropdown" 
		 role="listbox" 
		 aria-label="<?php esc_attr_e( 'Search results', 'robo' ); ?>">
	</div>
</div>
