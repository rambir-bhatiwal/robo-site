<?php
/**
 * Template part for displaying the Latest Blog section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

// Query latest 3 posts.
$latest_posts_query = new WP_Query(
	array(
		'posts_per_page'      => 3,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
	)
);
?>
<section id="latest-blog" class="latest-blog-section py-5 my-5">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		
		<!-- Section Header -->
		<div class="row mb-5 justify-content-center text-center">
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Our Journal', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-3"><?php esc_html_e( 'Latest News & Articles', 'robo' ); ?></h2>
				<p class="text-muted"><?php esc_html_e( 'Stay up to date with our thoughts, tutorials, case studies, and engineering updates.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Blog Cards Grid -->
		<div class="row g-4">
			<?php
			if ( $latest_posts_query->have_posts() ) :
				while ( $latest_posts_query->have_posts() ) :
					$latest_posts_query->the_post();
					?>
					<div class="col-lg-4 col-md-6">
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'card h-100 border-0 shadow-sm overflow-hidden' ); ?>>
							<!-- Card Thumbnail -->
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'card-img-top object-fit-cover', 'style' => 'height: 220px;' ) ); ?>
								</a>
							<?php else : ?>
								<div class="bg-secondary text-white text-center d-flex align-items-center justify-content-center" style="height: 220px;">
									<span class="small"><?php esc_html_e( 'No Image Available', 'robo' ); ?></span>
								</div>
							<?php endif; ?>

							<!-- Card Body -->
							<div class="card-body p-4 d-flex flex-column">
								<div class="d-flex align-items-center justify-content-between mb-3 text-muted small">
									<span class="d-flex align-items-center gap-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/></svg>
										<?php echo esc_html( get_the_date() ); ?>
									</span>
									<span class="d-flex align-items-center gap-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/></svg>
										<?php echo esc_html( robo_get_reading_time() ); ?>
									</span>
								</div>

								<h3 class="h5 fw-bold mb-3">
									<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none hover-primary"><?php the_title(); ?></a>
								</h3>
								
								<p class="text-muted small flex-grow-1 mb-4"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
								
								<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm align-self-start fw-bold py-2 px-3"><?php esc_html_e( 'Read Full Article', 'robo' ); ?></a>
							</div>
						</article>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<div class="col-12 text-center py-4">
					<p class="text-muted"><?php esc_html_e( 'No posts found. Create articles to display them here.', 'robo' ); ?></p>
				</div>
			<?php
			endif;
			?>
		</div>

	</div>
</section>
