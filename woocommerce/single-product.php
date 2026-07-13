<?php
/**
 * The Template for displaying all single products
 *
 * @package Robo
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Manually open the WooCommerce layout wrapper with container
echo '<div class="robo-woocommerce-wrapper py-4 bg-light-subtle">';
echo '<div class="container">';
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

get_footer( 'shop' );
