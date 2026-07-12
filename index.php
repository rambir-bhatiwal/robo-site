<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<div class="container-wrapper py-5">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row">
			
			<!-- Main Content Column -->
			<main id="primary" class="site-main col-lg-8">
				<?php
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
						?>
						<header class="mb-4">
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					endif;

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that
						 * will be used instead.
						 */
						get_template_part( 'template-parts/content/content', get_post_format() );

					endwhile;

					// Custom pagination.
					robo_pagination();

				else :

					get_template_part( 'template-parts/content/content', 'none' );

				endif;
				?>
			</main><!-- #primary -->

			<!-- Sidebar Column -->
			<div class="col-lg-4">
				<?php get_sidebar(); ?>
			</div>

		</div>
	</div>
</div>

<?php
get_footer();
