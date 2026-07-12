<?php
/**
 * The template for displaying the blog posts page.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<!-- Blog Header -->
<div class="blog-header py-5 bg-light mb-4 border-bottom border-light-subtle">
	<div class="<?php echo esc_attr( $container_class ); ?> text-center">
		<h1 class="display-4 fw-bold text-dark mb-2"><?php esc_html_e( 'Our Blog', 'robo' ); ?></h1>
		<p class="lead text-muted mb-0"><?php esc_html_e( 'Thoughts, tutorials, news, and custom WordPress engineering insights.', 'robo' ); ?></p>
	</div>
</div>

<div class="container-wrapper py-4">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		
		<!-- Breadcrumbs -->
		<?php robo_breadcrumbs(); ?>

		<div class="row">
			
			<!-- Blog Posts Grid Column -->
			<main id="primary" class="site-main col-lg-8">
				<?php if ( have_posts() ) : ?>
					
					<div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
						<?php
						while ( have_posts() ) :
							the_post();
							?>
							<div class="col">
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'card h-100 border-0 shadow-sm overflow-hidden' ); ?>>
									
									<!-- Thumbnail -->
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'medium_large', array( 'class' => 'card-img-top object-fit-cover', 'style' => 'height: 200px;' ) ); ?>
										</a>
									<?php else : ?>
										<div class="bg-secondary text-white text-center d-flex align-items-center justify-content-center" style="height: 200px;">
											<span class="small"><?php esc_html_e( 'No Image', 'robo' ); ?></span>
										</div>
									<?php endif; ?>

									<!-- Card Body -->
									<div class="card-body p-4 d-flex flex-column">
										<div class="d-flex align-items-center gap-3 text-muted small mb-2">
											<span class="d-flex align-items-center gap-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/></svg>
												<?php echo esc_html( get_the_date() ); ?>
											</span>
											<span class="d-flex align-items-center gap-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/></svg>
												<?php echo esc_html( robo_get_reading_time() ); ?>
											</span>
										</div>

										<h3 class="card-title h5 fw-bold mb-3">
											<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none hover-primary"><?php the_title(); ?></a>
										</h3>
										
										<p class="card-text text-muted small flex-grow-1 mb-4"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
										
										<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm align-self-start fw-bold mt-auto"><?php esc_html_e( 'Read Article', 'robo' ); ?></a>
									</div>
								</article>
							</div>
							<?php
						endwhile;
						?>
					</div>

					<!-- Pagination -->
					<?php robo_pagination(); ?>

				<?php else : ?>
					<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
				<?php endif; ?>
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
