<?php
/**
 * The template for displaying search results pages.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<!-- Search Header -->
<div class="search-header py-5 bg-light mb-4 border-bottom border-light-subtle">
	<div class="<?php echo esc_attr( $container_class ); ?> text-center">
		<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Search Results', 'robo' ); ?></span>
		<h1 class="display-4 fw-bold text-dark mb-2">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search: "%s"', 'robo' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
			?>
		</h1>
		<p class="lead text-muted mb-0">
			<?php
			global $wp_query;
			printf(
				/* translators: %d: number of results found. */
				esc_html( _n( 'We found %d result matching your criteria.', 'We found %d results matching your criteria.', $wp_query->found_posts, 'robo' ) ),
				absint( $wp_query->found_posts )
			);
			?>
		</p>
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

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content/content' );

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
