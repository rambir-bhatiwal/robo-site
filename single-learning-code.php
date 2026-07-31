<?php
/**
 * Single template for Source Code Library.
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
	$code_items  = get_post_meta( $post_id, '_robo_lms_code_resources', true );
	$code_count  = is_array( $code_items ) ? count( $code_items ) : 0;
	$diff_opts   = Helper::get_difficulty_options();
	$diff_label  = $diff_opts[ $difficulty ] ?? '';

	// Determine repository URL and web IDE embed URL
	$repo_url = '';
	if ( ! empty( $code_items ) && is_array( $code_items ) ) {
		foreach ( $code_items as $c_item ) {
			if ( ! empty( $c_item['repo_url'] ) ) {
				$repo_url = trim( $c_item['repo_url'] );
				break;
			}
		}
	}

	if ( empty( $repo_url ) ) {
		$repo_url = 'https://github.com/rambir-bhatiwal/TTB';
	}

	// Convert github.com to github1s.com for web IDE embed
	$ide_url = str_replace( 'github.com', 'github1s.com', $repo_url );
	if ( ! str_contains( $ide_url, 'github1s.com' ) ) {
		$ide_url = 'https://github1s.com/rambir-bhatiwal/TTB';
	}
	?>

	<!-- 1. Hero Section -->
	<?php Render::single_hero( $post_id ); ?>

	<!-- 2. Breadcrumb -->
	<?php get_template_part( 'template-parts/sections/breadcrumb' ); ?>

	<!-- Main Content Section -->
	<main id="primary" class="site-main py-3 py-md-4 bg-light-subtle">
		<div class="container">

			<!-- 1. Code Title, Header & Overview Article (Full Width col-12) -->
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
										<span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fw-bold text-uppercase fs-7 d-inline-flex align-items-center gap-1">
											<span class="dashicons dashicons-category"></span><?php echo esc_html( $cats[0]->name ); ?>
										</span>
									<?php endif; ?>

									<?php if ( $diff_label ) : ?>
										<span class="badge bg-success px-3 py-1.5 rounded-pill fw-semibold fs-7 d-inline-flex align-items-center gap-1">
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

							<a href="<?php echo esc_url( get_post_type_archive_link( 'learning-code' ) ); ?>" class="btn btn-outline-success rounded-pill px-3.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
								<span class="dashicons dashicons-arrow-left-alt"></span> <?php esc_html_e( 'Back to Code Library', 'robo' ); ?>
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
							<span class="dashicons dashicons-info text-success fs-5"></span>
							<?php esc_html_e( 'Code Details & Overview', 'robo' ); ?>
						</h5>

						<div class="row g-3 text-secondary">
							<?php if ( $diff_label ) : ?>
								<div class="col-12 col-sm-6 col-lg-3">
									<div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between gap-2 h-100">
										<span class="text-muted d-inline-flex align-items-center gap-1 fs-7"><span class="dashicons dashicons-chart-bar text-success"></span><?php esc_html_e( 'Difficulty', 'robo' ); ?></span>
										<span class="fw-bold text-success text-truncate"><?php echo esc_html( $diff_label ); ?></span>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( $duration ) : ?>
								<div class="col-12 col-sm-6 col-lg-3">
									<div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between gap-2 h-100">
										<span class="text-muted d-inline-flex align-items-center gap-1 fs-7"><span class="dashicons dashicons-clock text-success"></span><?php esc_html_e( 'Est. Time', 'robo' ); ?></span>
										<span class="fw-bold text-dark text-truncate"><?php echo esc_html( $duration ); ?></span>
									</div>
								</div>
							<?php endif; ?>

							<div class="col-12 col-sm-6 col-lg-3">
								<div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between gap-2 h-100">
									<span class="text-muted d-inline-flex align-items-center gap-1 fs-7"><span class="dashicons dashicons-editor-code text-success"></span><?php esc_html_e( 'Repositories', 'robo' ); ?></span>
									<span class="fw-bold text-dark text-truncate"><?php echo esc_html( (string) $code_count ); ?></span>
								</div>
							</div>

							<div class="col-12 col-sm-6 col-lg-3">
								<div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between gap-2 h-100">
									<span class="text-muted d-inline-flex align-items-center gap-1 fs-7"><span class="dashicons dashicons-calendar-alt text-success"></span><?php esc_html_e( 'Published', 'robo' ); ?></span>
									<span class="fw-medium text-dark text-truncate"><?php echo esc_html( get_the_date() ); ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- 3. FULL WIDTH Source Code & Repositories Section (col-12) -->
			<div class="row mb-4">
				<div class="col-12">
					<?php Render::resource_gallery( $post_id, 'learning-code' ); ?>
				</div>
			</div>

			<!-- 4. Interactive Source Code Editor / IDE Section (Full Width col-12) -->
			<div class="row mb-4">
				<div class="col-12">
					<div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
						<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 border-bottom pb-3 mb-4">
							<div>
								<h4 class="h5 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
									<span class="dashicons dashicons-editor-code text-success fs-4"></span>
									<?php esc_html_e( 'Interactive Code Editor & Repository IDE', 'robo' ); ?>
								</h4>
								<p class="text-muted small mb-0">
									<?php esc_html_e( 'Browse, inspect, and explore source code directly in the embedded web IDE interface.', 'robo' ); ?>
								</p>
							</div>

							<div class="d-flex flex-wrap align-items-center gap-2">
								<?php if ( $repo_url ) : ?>
									<a href="<?php echo esc_url( $repo_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-success rounded-pill px-3.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
										<span class="dashicons dashicons-external"></span> <?php esc_html_e( 'View on GitHub', 'robo' ); ?>
									</a>
								<?php endif; ?>

								<button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1" onclick="var el = document.getElementById('robo-lms-ide-iframe'); if (el.requestFullscreen) { el.requestFullscreen(); } else if (el.webkitRequestFullscreen) { el.webkitRequestFullscreen(); }">
									<span class="dashicons dashicons-fullscreen-alt"></span> <?php esc_html_e( 'Full Screen', 'robo' ); ?>
								</button>
							</div>
						</div>

						<!-- IDE Iframe Container -->
						<div class="ide-iframe-container rounded-4 overflow-hidden border border-light-subtle shadow-sm bg-dark" style="min-height: 650px;">
							<iframe 
								id="robo-lms-ide-iframe"
								src="<?php echo esc_url( $ide_url ); ?>" 
								title="<?php esc_attr_e( 'Robo LMS Source Code IDE', 'robo' ); ?>" 
								style="width: 100%; height: 650px; border: 0; display: block; background-color: #1e1e1e;"
								loading="lazy">
							</iframe>
						</div>
					</div>
				</div>
			</div>

			<!-- 5. Related Resources Section (Products, Videos, Code, PDFs) -->
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
