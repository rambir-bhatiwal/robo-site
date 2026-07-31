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
	$short_desc  = get_post_meta( $post_id, '_robo_lms_short_description', true );
	$difficulty  = get_post_meta( $post_id, '_robo_lms_difficulty', true );
	$duration    = get_post_meta( $post_id, '_robo_lms_estimated_duration', true );
	$pdf_items   = get_post_meta( $post_id, '_robo_lms_pdf_resources', true );
	$pdf_count   = is_array( $pdf_items ) ? count( $pdf_items ) : 0;
	$diff_opts   = Helper::get_difficulty_options();
	$diff_label  = $diff_opts[ $difficulty ] ?? '';
	?>

	<!-- 1. Hero Section -->
	<?php Render::single_hero( $post_id ); ?>

	<!-- 2. Breadcrumb -->
	<?php get_template_part( 'template-parts/sections/breadcrumb' ); ?>

	<!-- Main Content Section -->
	<main id="primary" class="site-main py-3 py-md-4 bg-light-subtle">
		<div class="container">

			<!-- 1. PDF Title, Header & Overview Article (Full Width col-12) -->
			<div class="row mb-4">
				<div class="col-12">
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white' ); ?>>
						<!-- Header Bar: Title, Badges & Top Right Back Button -->
						<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4 pb-3 border-bottom">
							<div>
								<div class="d-flex flex-wrap align-items-center gap-2 mb-2">
									<?php
									$cats = get_the_terms( $post_id, 'learning-category' );
									if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) :
										?>
										<span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fw-bold text-uppercase fs-7 d-inline-flex align-items-center gap-1">
											<span class="dashicons dashicons-category"></span><?php echo esc_html( $cats[0]->name ); ?>
										</span>
									<?php endif; ?>

									<?php if ( $diff_label ) : ?>
										<span class="badge bg-primary px-3 py-1.5 rounded-pill fw-semibold fs-7 d-inline-flex align-items-center gap-1">
											<span class="dashicons dashicons-chart-bar"></span><?php echo esc_html( $diff_label ); ?>
										</span>
									<?php endif; ?>

									<?php if ( $duration ) : ?>
										<span class="badge bg-dark bg-opacity-75 text-white px-3 py-1.5 rounded-pill fs-7 d-inline-flex align-items-center gap-1">
											<span class="dashicons dashicons-clock"></span><?php echo esc_html( $duration ); ?>
										</span>
									<?php endif; ?>
								</div>
								<h1 class="h2 fw-bold text-dark mb-0"><?php the_title(); ?></h1>
							</div>

							<a href="<?php echo esc_url( get_post_type_archive_link( 'learning-pdf' ) ); ?>" class="btn btn-outline-primary rounded-pill px-3.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
								<span class="dashicons dashicons-arrow-left-alt"></span> <?php esc_html_e( 'Back to PDF Library', 'robo' ); ?>
							</a>
						</div>

						<!-- Featured Image if available -->
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="rounded-4 overflow-hidden mb-4 shadow-sm">
								<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid w-100 object-fit-cover', 'style' => 'max-height: 380px;' ) ); ?>
							</div>
						<?php endif; ?>

						<!-- Description Content -->
						<div class="entry-content text-secondary fs-6 lh-lg mb-3">
							<?php
							$content = get_the_content();
							if ( ! empty( trim( $content ) ) ) {
								the_content();
							} elseif ( ! empty( $short_desc ) ) {
								echo '<p>' . esc_html( $short_desc ) . '</p>';
							} else {
								echo '<p>' . esc_html( get_the_excerpt( $post_id ) ) . '</p>';
							}
							?>
						</div>

						<!-- Tags -->
						<?php
						$tags = get_the_terms( $post_id, 'learning-tag' );
						if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
							?>
							<div class="pt-3 border-top d-flex flex-wrap align-items-center gap-2">
								<small class="text-muted fw-bold me-2"><?php esc_html_e( 'Tags:', 'robo' ); ?></small>
								<?php foreach ( $tags as $t ) : ?>
									<a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill text-decoration-none hover-primary fs-7">
										#<?php echo esc_html( $t->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</article>
				</div>
			</div>

			<!-- 2. Resource Overview Bar Section (Full Width col-12) -->
			<div class="row mb-4">
				<div class="col-12">
					<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
						<h5 class="fw-bold mb-3 border-bottom pb-2 text-dark d-flex align-items-center gap-2">
							<span class="dashicons dashicons-info text-primary fs-5"></span>
							<?php esc_html_e( 'Resource Overview', 'robo' ); ?>
						</h5>

						<div class="row g-3 text-secondary">
							<?php if ( $diff_label ) : ?>
								<div class="col-12 col-sm-6 col-lg-3">
									<div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between gap-2 h-100">
										<span class="text-muted d-inline-flex align-items-center gap-1 fs-7"><span class="dashicons dashicons-chart-bar text-primary"></span><?php esc_html_e( 'Difficulty', 'robo' ); ?></span>
										<span class="fw-bold text-primary text-truncate"><?php echo esc_html( $diff_label ); ?></span>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( $duration ) : ?>
								<div class="col-12 col-sm-6 col-lg-3">
									<div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between gap-2 h-100">
										<span class="text-muted d-inline-flex align-items-center gap-1 fs-7"><span class="dashicons dashicons-clock text-primary"></span><?php esc_html_e( 'Est. Time', 'robo' ); ?></span>
										<span class="fw-bold text-dark text-truncate"><?php echo esc_html( $duration ); ?></span>
									</div>
								</div>
							<?php endif; ?>

							<div class="col-12 col-sm-6 col-lg-3">
								<div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between gap-2 h-100">
									<span class="text-muted d-inline-flex align-items-center gap-1 fs-7"><span class="dashicons dashicons-media-document text-primary"></span><?php esc_html_e( 'PDF Files', 'robo' ); ?></span>
									<span class="fw-bold text-dark text-truncate"><?php echo esc_html( (string) $pdf_count ); ?></span>
								</div>
							</div>

							<div class="col-12 col-sm-6 col-lg-3">
								<div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between gap-2 h-100">
									<span class="text-muted d-inline-flex align-items-center gap-1 fs-7"><span class="dashicons dashicons-calendar-alt text-primary"></span><?php esc_html_e( 'Published', 'robo' ); ?></span>
									<span class="fw-medium text-dark text-truncate"><?php echo esc_html( get_the_date() ); ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- 3. FULL WIDTH PDF Documentation & Downloads Section (col-12) -->
			<div class="row mb-4">
				<div class="col-12">
					<?php Render::resource_gallery( $post_id, 'learning-pdf' ); ?>
				</div>
			</div>

			<!-- 4. Related Resources Section (Products, Videos, Code) -->
			<div class="row">
				<div class="col-12">
					<?php Render::related_resources( $post_id ); ?>
				</div>
			</div>

		</div>
	</main>

<?php
endwhile;

get_footer();
