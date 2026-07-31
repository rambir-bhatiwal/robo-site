<?php
/**
 * Single template for Learning PDFs.
 *
 * @package Robo
 */

use Robo\LMS\Frontend\Render;
use Robo\LMS\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$post_id     = get_the_ID();
	$difficulty  = get_post_meta( $post_id, '_robo_lms_difficulty', true );
	$duration    = get_post_meta( $post_id, '_robo_lms_estimated_duration', true );
	$diff_opts   = Helper::get_difficulty_options();
	$diff_label  = $diff_opts[ $difficulty ] ?? '';
	?>

	<!-- Hero Section -->
	<?php Render::single_hero( $post_id ); ?>

	<!-- Main Content Section -->
	<main id="primary" class="site-main py-4 bg-light-subtle">
		<div class="container">
			<div class="row g-4">
				<!-- Left / Main Column -->
				<div class="col-lg-8">
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white' ); ?>>
						<!-- Featured Image if available -->
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="rounded-4 overflow-hidden mb-4 shadow-sm">
								<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid w-100 object-fit-cover', 'style' => 'max-height: 420px;' ) ); ?>
							</div>
						<?php endif; ?>

						<!-- Post Content -->
						<div class="entry-content text-secondary fs-5 lh-lg mb-5">
							<?php the_content(); ?>
						</div>

						<!-- PDF Repeater Gallery -->
						<?php Render::resource_gallery( $post_id, 'learning-pdf' ); ?>
					</article>

					<!-- Related Resources Sections -->
					<?php Render::related_resources( $post_id ); ?>
				</div>

				<!-- Right / Sidebar Column -->
				<div class="col-lg-4">
					<div class="sticky-top" style="top: 100px; z-index: 10;">
						<!-- Quick Info Card -->
						<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
							<h5 class="fw-bold mb-4 border-bottom pb-2 text-dark">
								<span class="dashicons dashicons-info me-2 text-primary"></span><?php esc_html_e( 'Resource Overview', 'robo' ); ?>
							</h5>

							<ul class="list-unstyled mb-0">
								<?php if ( $diff_label ) : ?>
									<li class="d-flex align-items-center justify-content-between py-2 border-bottom">
										<span class="text-muted"><i class="dashicons dashicons-chart-bar me-1"></i><?php esc_html_e( 'Difficulty:', 'robo' ); ?></span>
										<span class="fw-bold text-primary"><?php echo esc_html( $diff_label ); ?></span>
									</li>
								<?php endif; ?>

								<?php if ( $duration ) : ?>
									<li class="d-flex align-items-center justify-content-between py-2 border-bottom">
										<span class="text-muted"><i class="dashicons dashicons-clock me-1"></i><?php esc_html_e( 'Duration:', 'robo' ); ?></span>
										<span class="fw-bold text-dark"><?php echo esc_html( $duration ); ?></span>
									</li>
								<?php endif; ?>

								<li class="d-flex align-items-center justify-content-between py-2 border-bottom">
									<span class="text-muted"><i class="dashicons dashicons-calendar-alt me-1"></i><?php esc_html_e( 'Published:', 'robo' ); ?></span>
									<span class="fw-medium text-dark"><?php echo esc_html( get_the_date() ); ?></span>
								</li>

								<li class="d-flex align-items-center justify-content-between py-2">
									<span class="text-muted"><i class="dashicons dashicons-admin-users me-1"></i><?php esc_html_e( 'Author:', 'robo' ); ?></span>
									<span class="fw-medium text-dark"><?php the_author(); ?></span>
								</li>
							</ul>
						</div>

						<!-- Sidebar Widgets Area -->
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</div>
	</main>

<?php
endwhile;

get_footer();
