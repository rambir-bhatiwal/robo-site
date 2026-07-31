<?php
/**
 * Archive template for Source Code Library.
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
				<span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 fs-7">
					<span class="dashicons dashicons-editor-code me-1"></span><?php esc_html_e( 'Code Repository', 'robo' ); ?>
				</span>
				<h1 class="display-4 fw-bold text-dark mb-3"><?php esc_html_e( 'Source Code Library', 'robo' ); ?></h1>
				<p class="lead text-muted mb-0"><?php esc_html_e( 'Explore open-source robotics code, firmware, libraries, and script repositories for Arduino, Python, C++, and more.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Filter Bar -->
		<?php Render::filter_bar( 'learning-code' ); ?>

		<!-- Archive Posts Grid -->
		<div id="robo-lms-archive-grid">
			<?php if ( have_posts() ) : ?>
				<div class="row g-4">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="col-md-6 col-lg-4 d-flex align-items-stretch">
							<?php Render::archive_card( get_the_ID() ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<div class="alert alert-info text-center py-5 shadow-sm rounded-4 position-relative overflow-hidden my-4" role="alert">
					<span class="dashicons dashicons-search display-1 text-secondary mb-3"></span>
					<h4 class="fw-bold mb-2"><?php esc_html_e( 'No Source Code Found', 'robo' ); ?></h4>
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
