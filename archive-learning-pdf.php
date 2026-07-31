<?php
/**
 * Archive template for Learning PDFs.
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
				<span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 fs-7">
					<span class="dashicons dashicons-media-document me-1"></span><?php esc_html_e( 'PDF Library', 'robo' ); ?>
				</span>
				<h1 class="display-4 fw-bold text-dark mb-3"><?php esc_html_e( 'Learning PDF Resources', 'robo' ); ?></h1>
				<p class="lead text-muted mb-0"><?php esc_html_e( 'Browse and download comprehensive technical guides, datasheets, schematics, and learning materials.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Filter Bar -->
		<?php Render::filter_bar( 'learning-pdf' ); ?>

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
				<div class="card border-0 shadow-sm rounded-4 text-center py-5 px-4 my-4 bg-white robo-lms-no-results-card">
					<div class="robo-lms-no-results-icon"><span class="dashicons dashicons-search"></span></div>
					<h4 class="fw-bold mb-2 text-dark"><?php esc_html_e( 'No Resources Found', 'robo' ); ?></h4>
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
