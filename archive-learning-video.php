<?php
/**
 * Archive template for Learning Videos.
 *
 * @package Robo
 */

use Robo\LMS\Frontend\Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main py-5 bg-light-subtle">
	<div class="container">
		<!-- Archive Page Header -->
		<div class="row justify-content-center text-center mb-5">
			<div class="col-lg-8">
				<span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 fs-7 d-inline-flex align-items-center gap-1">
					<span class="dashicons dashicons-video-alt3"></span><?php esc_html_e( 'Video Library', 'robo' ); ?>
				</span>
				<h1 class="display-4 fw-bold text-dark mb-3"><?php esc_html_e( 'Learning Videos', 'robo' ); ?></h1>
				<p class="lead text-muted mb-0"><?php esc_html_e( 'Watch high-quality step-by-step video courses, video tutorials, workshop demonstrations, and robotics walk-throughs.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Filter Bar -->
		<?php Render::filter_bar( 'learning-video' ); ?>

		<!-- Archive Posts Grid -->
		<div id="robo-lms-archive-grid">
			<?php if ( have_posts() ) : ?>
				<div class="row g-4">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="col-12">
							<?php Render::archive_card( get_the_ID() ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<div class="card border-0 shadow-sm rounded-4 text-center py-5 px-4 my-4 bg-white robo-lms-no-results-card">
					<div class="robo-lms-no-results-icon"><span class="dashicons dashicons-search"></span></div>
					<h4 class="fw-bold mb-2 text-dark"><?php esc_html_e( 'No Learning Videos Found', 'robo' ); ?></h4>
					<p class="mb-0 text-muted"><?php esc_html_e( 'Try adjusting your search terms or filter criteria.', 'robo' ); ?></p>
				</div>
			<?php endif; ?>
		</div>

		<!-- Pagination -->
		<div id="robo-lms-archive-pagination">
			<?php
			if ( function_exists( 'robo_pagination' ) ) {
				robo_pagination();
			}
			?>
		</div>
	</div>
</main>

<?php
get_footer();
