<?php
/**
 * The template for displaying archive pages.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<!-- Archive Header -->
<div class="archive-header py-5 bg-light mb-4 border-bottom border-light-subtle">
	<div class="<?php echo esc_attr( $container_class ); ?> text-center">
		<?php
		the_archive_title( '<h1 class="display-4 fw-bold text-dark mb-2">', '</h1>' );
		the_archive_description( '<div class="archive-description lead text-muted mb-0">', '</div>' );
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
