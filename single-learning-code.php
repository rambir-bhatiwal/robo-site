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

	// Related items
	$rel_videos = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_videos', true ) );
	$rel_pdfs   = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_pdfs', true ) );
	$rel_prods  = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_products', true ) );

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

			<!-- Action Buttons Bar -->
			<div class="row mb-4">
				<div class="col-12">
					<div class="card border-0 shadow-sm rounded-4 p-3 bg-white border robo-lms-action-bar">
						<div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
							<div class="cpt-action-grid-wrapper flex-grow-1">
								<div class="row g-2 cpt-action-grid align-items-center">
									<!-- 1. Watch Video Button -->
									<div class="col-6 col-md-auto cpt-action-col">
										<?php
										$first_video_url = ! empty( $rel_videos ) ? get_permalink( $rel_videos[0] ) : '#';
										?>
										<a href="<?php echo esc_url( $first_video_url ); ?>" class="cpt-action-btn cpt-action-btn--video<?php echo empty( $rel_videos ) ? ' opacity-75' : ''; ?>">
											<span class="cpt-action-btn__icon" aria-hidden="true">
												<svg class="cpt-action-icon" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="display: block;">
													<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-2.5 5.5v9l7-4.5-7-4.5z"/>
												</svg>
											</span>
											<span class="cpt-action-btn__text"><?php esc_html_e( 'Watch Video', 'robo' ); ?></span>
											<span class="cpt-action-btn__arrow" aria-hidden="true">
												<svg class="cpt-action-arrow" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
													<polyline points="9 18 15 12 9 6"></polyline>
												</svg>
											</span>
										</a>
									</div>

									<!-- 2. Code Button -->
									<div class="col-6 col-md-auto cpt-action-col">
										<a href="#robo-lms-ide-iframe" class="cpt-action-btn cpt-action-btn--code">
											<span class="cpt-action-btn__icon" aria-hidden="true">
												<svg class="cpt-action-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
													<polyline points="16 18 22 12 16 6"></polyline>
													<polyline points="8 6 2 12 8 18"></polyline>
													<line x1="14" y1="4" x2="10" y2="20"></line>
												</svg>
											</span>
											<span class="cpt-action-btn__text"><?php esc_html_e( 'Code', 'robo' ); ?></span>
											<span class="cpt-action-btn__arrow" aria-hidden="true">
												<svg class="cpt-action-arrow" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
													<polyline points="9 18 15 12 9 6"></polyline>
												</svg>
											</span>
										</a>
									</div>

									<!-- 3. PDF Button -->
									<div class="col-6 col-md-auto cpt-action-col">
										<?php
										$first_pdf_url = ! empty( $rel_pdfs ) ? get_permalink( $rel_pdfs[0] ) : '#';
										?>
										<a href="<?php echo esc_url( $first_pdf_url ); ?>" class="cpt-action-btn cpt-action-btn--pdf<?php echo empty( $rel_pdfs ) ? ' opacity-75' : ''; ?>">
											<span class="cpt-action-btn__icon" aria-hidden="true">
												<svg class="cpt-action-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" style="display: block;">
													<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<polyline points="14 2 14 8 20 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M9.8 17.2c-.8.6-1.6.8-2 .5-.4-.3-.3-.9.2-1.6.6-.8 1.4-1.7 2.1-2.5-.1 1.4-.2 2.5-.3 3.6zm2.5-3.8c1-.8 2.2-1.2 2.8-1 .6.2.6.7.2 1.2-.4.6-1.3 1-2.4 1.1-.2-.5-.4-.9-.6-1.3zm-1.8-2.8c.3.7.1 1.5-.2 2.1-.5-1.1-.9-2.2-.6-2.6.2-.3.5-.3.8.5zm5.3 4.2c-.9-.2-2.1.2-3.3 1.1-1.2-.7-2.4-1.9-3-3.3.3-.8.5-1.9.2-2.4-.4-.7-1.3-.4-1.5.3-.3 1.1.2 2.5 1.2 4.1-.7 1.6-1.6 3.2-2.4 4-.7.7-.8 1.4-.3 1.7.5.4 1.5 0 2.4-1.2 1.3-.6 2.9-1.1 4.6-1.4 1.1.9 2 1.2 2.5 1 .6-.3.6-1 .2-1.7-.4-.6-1.1-.8-2.1-.8z" fill="currentColor" stroke="none"/>
												</svg>
											</span>
											<span class="cpt-action-btn__text"><?php esc_html_e( 'PDF', 'robo' ); ?></span>
											<span class="cpt-action-btn__arrow" aria-hidden="true">
												<svg class="cpt-action-arrow" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
													<polyline points="9 18 15 12 9 6"></polyline>
												</svg>
											</span>
										</a>
									</div>

									<!-- 4. Buy This Kit Button -->
									<div class="col-6 col-md-auto cpt-action-col">
										<?php
										$first_prod_url = ! empty( $rel_prods ) ? get_permalink( $rel_prods[0] ) : ( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#' );
										?>
										<a href="<?php echo esc_url( $first_prod_url ); ?>" class="cpt-action-btn cpt-action-btn--kit<?php echo empty( $rel_prods ) ? ' opacity-75' : ''; ?>">
											<span class="cpt-action-btn__icon" aria-hidden="true">
												<svg class="cpt-action-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
													<circle cx="9" cy="21" r="1.5" fill="currentColor" stroke="none"></circle>
													<circle cx="19" cy="21" r="1.5" fill="currentColor" stroke="none"></circle>
													<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
												</svg>
											</span>
											<span class="cpt-action-btn__text"><?php esc_html_e( 'Buy This Kit', 'robo' ); ?></span>
											<span class="cpt-action-btn__arrow" aria-hidden="true">
												<svg class="cpt-action-arrow" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
													<polyline points="9 18 15 12 9 6"></polyline>
												</svg>
											</span>
										</a>
									</div>
								</div>
							</div>

							<!-- ← Back to Code Library -->
							<a href="<?php echo esc_url( get_post_type_archive_link( 'learning-code' ) ); ?>" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center justify-content-center gap-1 ms-md-auto robo-lms-back-btn">
								<span class="dashicons dashicons-arrow-left-alt flex-shrink-0"></span> <span class="text-truncate"><?php esc_html_e( 'Back to Code', 'robo' ); ?></span>
							</a>
						</div>
					</div>
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
