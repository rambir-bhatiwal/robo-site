<?php
/**
 * The template for displaying all single posts.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Track/increment post views before outputting anything.
if ( have_posts() ) {
	the_post();
	robo_track_post_views( get_the_ID() );
	rewind_posts();
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<div class="container-wrapper py-5">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		
		<!-- Breadcrumbs -->
		<?php robo_breadcrumbs(); ?>

		<div class="row">
			
			<!-- Single Post Column -->
			<main id="primary" class="site-main col-lg-8">
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content/content', 'single' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
			</main><!-- #primary -->

			<!-- Blog Sidebar Column -->
			<div class="col-lg-4">
				<?php get_sidebar( 'blog' ); ?>
			</div>

		</div>
	</div>
</div>

<?php
get_footer();
