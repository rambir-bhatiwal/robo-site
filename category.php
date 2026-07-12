<?php
/**
 * The template for displaying Category pages.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<!-- Category Header -->
<div class="category-header py-5 bg-light mb-4 border-bottom border-light-subtle">
	<div class="<?php echo esc_attr( $container_class ); ?> text-center">
		<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Category Archive', 'robo' ); ?></span>
		<h1 class="display-4 fw-bold text-dark mb-2"><?php echo esc_html( single_cat_title( '', false ) ); ?></h1>
		<?php
		$cat_desc = category_description();
		if ( ! empty( $cat_desc ) ) {
			echo '<div class="category-description lead text-muted mb-0">' . wp_kses_post( $cat_desc ) . '</div>';
		} else {
			echo '<p class="lead text-muted mb-0">' . sprintf( esc_html__( 'All posts filed under the "%s" category.', 'robo' ), esc_html( single_cat_title( '', false ) ) ) . '</p>';
		}
		?>
	</div>
</div>

<div class="container-wrapper py-4">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		
		<!-- Breadcrumbs -->
		<?php robo_breadcrumbs(); ?>

		<div class="row">
			
			<!-- Main Column -->
			<main id="primary" class="site-main col-lg-8">
				<?php
				if ( have_posts() ) :

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content/content', get_post_format() );

					endwhile;

					robo_pagination();

				else :

					get_template_part( 'template-parts/content/content', 'none' );

				endif;
				?>
			</main><!-- #primary -->

			<!-- Sidebar Column -->
			<div class="col-lg-4">
				<?php get_sidebar( 'blog' ); ?>
			</div>

		</div>
	</div>
</div>

<?php
get_footer();
