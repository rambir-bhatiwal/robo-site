<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );

// Check if this is a WooCommerce page that should be clean and full-width (no sidebar)
$is_woo_page = false;
if ( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
	$is_woo_page = true;
}

$main_col_class = $is_woo_page ? 'col-12' : 'col-lg-8';
$wrapper_padding_class = $is_woo_page ? 'pt-4 pb-5' : 'py-5';
?>

<?php
if ( $is_woo_page ) {
	get_template_part( 'template-parts/woocommerce-banner' );
}
?>

<div class="container-wrapper <?php echo esc_attr( $wrapper_padding_class ); ?>">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		
		<!-- Breadcrumbs -->
		<?php
		if ( $is_woo_page ) {
			if ( function_exists( 'robo_woocommerce_breadcrumbs' ) ) {
				robo_woocommerce_breadcrumbs();
			}
		} else {
			robo_breadcrumbs();
		}
		?>

		<div class="row">
			
			<!-- Page Main Column -->
			<main id="primary" class="site-main <?php echo esc_attr( $main_col_class ); ?>">
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( ! $is_woo_page && ( comments_open() || get_comments_number() ) ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
			</main><!-- #primary -->

			<?php if ( ! $is_woo_page ) : ?>
				<!-- Page Sidebar Column -->
				<div class="col-lg-4">
					<?php get_sidebar(); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php
get_footer();
