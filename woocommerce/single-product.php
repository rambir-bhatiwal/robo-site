<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     Robo
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );

// Manually open the WooCommerce layout wrapper with container
echo '<div class="robo-woocommerce-wrapper pb-4 bg-light-subtle">';
echo '<div class="container-fluid">';
?>

<!-- Breadcrumbs (Outside the product card wrapper) -->
<div class="row mb-3">
	<div class="col-12">
		<?php
		if ( function_exists( 'robo_woocommerce_breadcrumbs' ) ) {
			robo_woocommerce_breadcrumbs();
		} else {
			woocommerce_breadcrumb();
		}
		?>
	</div>
</div>

<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>

	<?php wc_get_template_part( 'content', 'single-product' ); ?>

<?php endwhile; // end of the loop. ?>

<?php
echo '</div>'; // .container
echo '</div>'; // .robo-woocommerce-wrapper

/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );

