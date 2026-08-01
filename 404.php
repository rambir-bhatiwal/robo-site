<?php
/**
 * The template for displaying 404 pages (not found).
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
		
		<!-- Breadcrumbs -->
		<?php robo_breadcrumbs(); ?>

		<div class="row justify-content-center text-center">
			<div class="col-lg-8">
				
				<!-- Large 404 visual -->
				<div class="display-1 fw-extrabold text-primary mb-3" style="font-size: 8rem; line-height: 1; letter-spacing: -3px;">
					<?php esc_html_e( '404', 'robo' ); ?>
				</div>
				
				<h1 class="h2 fw-bold text-dark mb-4"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'robo' ); ?></h1>
				
				<p class="text-muted fs-6 mb-5">
					<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try searching for what you need or return back to the homepage.', 'robo' ); ?>
				</p>

				<!-- Actions -->
				<div class="row justify-content-center align-items-center g-3 mb-5 max-width-700 mx-auto error-404-actions">
					<div class="col-12 col-sm-auto">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2 hover-lift transition-all" style="height: 48px;">
							<i class="bi bi-house-door-fill"></i> <?php esc_html_e( 'Return to Homepage', 'robo' ); ?>
						</a>
					</div>
					<div class="col-12 col-sm-auto flex-grow-1 text-start" style="max-width: 380px;">
						<form role="search" method="get" class="search-form mb-0" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<div class="input-group shadow-sm rounded-pill overflow-hidden border border-light-subtle bg-white" style="height: 48px;">
								<input type="search" class="form-control border-0 px-3 py-2 shadow-none" placeholder="<?php esc_attr_e( 'Search website&hellip;', 'robo' ); ?>" value="<?php echo get_search_query(); ?>" name="s" aria-label="<?php esc_attr_e( 'Search', 'robo' ); ?>" />
								<button type="submit" class="btn btn-primary px-3.5 border-0 d-flex align-items-center justify-content-center" aria-label="<?php esc_attr_e( 'Search', 'robo' ); ?>">
									<i class="bi bi-search"></i>
								</button>
							</div>
						</form>
					</div>
				</div>

				<hr class="border-light-subtle my-5">

				<!-- Popular Posts section -->
				<div class="popular-posts text-start">
					<h2 class="h4 fw-bold text-dark mb-4 text-center text-sm-start"><?php esc_html_e( 'Popular Articles', 'robo' ); ?></h2>
					<div class="row g-4">
						<?php
						// Query 3 popular posts by views count, fallback to latest.
						$popular_query = new WP_Query(
							array(
								'posts_per_page' => 3,
								'meta_key'       => 'robo_post_views_count',
								'orderby'        => 'meta_value_num',
								'order'          => 'DESC',
							)
						);
						
						// If no views recorded yet, fallback to latest 3.
						if ( ! $popular_query->have_posts() ) {
							$popular_query = new WP_Query(
								array(
									'posts_per_page'      => 3,
									'ignore_sticky_posts' => 1,
								)
							);
						}

						if ( $popular_query->have_posts() ) :
							while ( $popular_query->have_posts() ) :
								$popular_query->the_post();
								?>
								<div class="col-md-4">
									<div class="card h-100 border-0 shadow-sm overflow-hidden">
										<?php if ( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top object-fit-cover', 'style' => 'height: 150px;' ) ); ?>
											</a>
										<?php else : ?>
											<div class="bg-secondary text-white text-center d-flex align-items-center justify-content-center" style="height: 150px;">
												<span class="small"><?php esc_html_e( 'No Image', 'robo' ); ?></span>
											</div>
										<?php endif; ?>
										
										<div class="card-body p-3">
											<h3 class="h6 fw-bold mb-2">
												<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none hover-primary"><?php the_title(); ?></a>
											</h3>
											<span class="text-muted small"><?php echo esc_html( robo_get_post_views() ); ?></span>
										</div>
									</div>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
						else :
							?>
							<div class="col-12 text-center text-muted small">
								<?php esc_html_e( 'No articles found.', 'robo' ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php
get_footer();
