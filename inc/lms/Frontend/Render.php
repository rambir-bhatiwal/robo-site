<?php
/**
 * Frontend Renderer for Robo LMS.
 *
 * @package Robo\LMS\Frontend
 */

namespace Robo\LMS\Frontend;

use Robo\LMS\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Render
 */
class Render {

	/**
	 * Render Single Page Hero Section.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function single_hero( int $post_id ): void {
		$short_desc  = get_post_meta( $post_id, '_robo_lms_short_description', true );
		$difficulty  = get_post_meta( $post_id, '_robo_lms_difficulty', true );
		$duration    = get_post_meta( $post_id, '_robo_lms_estimated_duration', true );
		$is_featured = get_post_meta( $post_id, '_robo_lms_is_featured', true );
		$is_recom    = get_post_meta( $post_id, '_robo_lms_is_recommended', true );
		$banner_id   = get_post_meta( $post_id, '_robo_lms_banner_id', true );

		$banner_url  = $banner_id ? wp_get_attachment_image_url( $banner_id, 'full' ) : '';
		if ( ! $banner_url && has_post_thumbnail( $post_id ) ) {
			$banner_url = get_the_post_thumbnail_url( $post_id, 'full' );
		}

		$diff_options = Helper::get_difficulty_options();
		$diff_label   = $diff_options[ $difficulty ] ?? '';

		$style_attr = $banner_url
			? 'background: linear-gradient(135deg, rgba(15, 23, 42, 0.88), rgba(30, 41, 59, 0.92)), url(' . esc_url( $banner_url ) . ') center/cover no-repeat;'
			: 'background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);';
		?>
		<section class="robo-lms-hero text-white py-5 position-relative shadow" style="<?php echo esc_attr( $style_attr ); ?>">
			<div class="container py-3">
				<div class="row align-items-center g-4">
					<div class="col-lg-8">
						<!-- Badges -->
						<div class="d-flex flex-wrap align-items-center gap-2 mb-3">
							<?php if ( '1' === $is_featured ) : ?>
								<span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase fs-7 shadow-sm">
									<i class="dashicons dashicons-star-filled me-1"></i><?php esc_html_e( 'Featured', 'robo' ); ?>
								</span>
							<?php endif; ?>

							<?php if ( '1' === $is_recom ) : ?>
								<span class="badge bg-info text-dark px-3 py-2 rounded-pill fw-bold text-uppercase fs-7 shadow-sm">
									<i class="dashicons dashicons-thumbs-up me-1"></i><?php esc_html_e( 'Recommended', 'robo' ); ?>
								</span>
							<?php endif; ?>

							<?php if ( $diff_label ) : ?>
								<span class="badge bg-primary px-3 py-2 rounded-pill fw-medium fs-7 shadow-sm">
									<i class="dashicons dashicons-chart-bar me-1"></i><?php echo esc_html( $diff_label ); ?>
								</span>
							<?php endif; ?>

							<?php if ( $duration ) : ?>
								<span class="badge bg-secondary px-3 py-2 rounded-pill fw-medium fs-7 shadow-sm">
									<i class="dashicons dashicons-clock me-1"></i><?php echo esc_html( $duration ); ?>
								</span>
							<?php endif; ?>
						</div>

						<!-- Title -->
						<h1 class="display-4 fw-bold mb-3 text-white"><?php echo esc_html( get_the_title( $post_id ) ); ?></h1>

						<!-- Short Description -->
						<?php if ( $short_desc ) : ?>
							<p class="lead text-light opacity-90 mb-4 me-lg-4"><?php echo esc_html( $short_desc ); ?></p>
						<?php endif; ?>

						<!-- Categories & Tags -->
						<div class="d-flex flex-wrap align-items-center gap-3 fs-6 text-light opacity-75">
							<?php
							$cats = get_the_terms( $post_id, 'learning-category' );
							if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) :
								?>
								<div>
									<i class="dashicons dashicons-category me-1"></i>
									<?php
									$cat_links = array();
									foreach ( $cats as $c ) {
										$cat_links[] = sprintf( '<a href="%s" class="text-white text-decoration-none border-bottom border-light border-opacity-50">%s</a>', esc_url( get_term_link( $c ) ), esc_html( $c->name ) );
									}
									echo implode( ', ', $cat_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									?>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<?php if ( has_post_thumbnail( $post_id ) ) : ?>
						<div class="col-lg-4 text-center">
							<div class="rounded-4 overflow-hidden shadow-lg border border-light border-opacity-25 bg-dark">
								<?php echo get_the_post_thumbnail( $post_id, 'medium_large', array( 'class' => 'img-fluid w-100 object-fit-cover', 'style' => 'max-height: 260px;', 'loading' => 'lazy' ) ); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}

	/**
	 * Render Resource Overview Card.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function resource_overview( int $post_id ): void {
		$short_desc  = get_post_meta( $post_id, '_robo_lms_short_description', true );
		$difficulty  = get_post_meta( $post_id, '_robo_lms_difficulty', true );
		$pdf_items   = get_post_meta( $post_id, '_robo_lms_pdf_resources', true );
		$pdf_count   = is_array( $pdf_items ) ? count( $pdf_items ) : 0;
		$last_update = get_the_modified_date( '', $post_id );

		$diff_opts  = Helper::get_difficulty_options();
		$diff_label = $diff_opts[ $difficulty ] ?? __( 'All Levels', 'robo' );
		?>
		<section class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white robo-lms-overview-card" aria-label="<?php esc_attr_e( 'Resource Overview', 'robo' ); ?>">
			<div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom">
				<span class="dashicons dashicons-text-page text-primary fs-3"></span>
				<h2 class="h3 fw-bold mb-0 text-dark"><?php esc_html_e( 'Resource Overview & Objectives', 'robo' ); ?></h2>
			</div>

			<!-- Main Description Content -->
			<div class="entry-content text-secondary fs-5 lh-lg mb-4">
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

			<!-- Overview Info Badges & Metadata Grid -->
			<div class="row g-3 p-3 bg-light rounded-4 border border-light-subtle">
				<div class="col-6 col-md-3">
					<div class="p-2">
						<small class="text-muted text-uppercase fw-bold fs-7 d-block mb-1"><?php esc_html_e( 'Difficulty', 'robo' ); ?></small>
						<span class="badge bg-primary px-3 py-2 rounded-pill fw-semibold"><?php echo esc_html( $diff_label ); ?></span>
					</div>
				</div>

				<div class="col-6 col-md-3">
					<div class="p-2">
						<small class="text-muted text-uppercase fw-bold fs-7 d-block mb-1"><?php esc_html_e( 'Total PDFs', 'robo' ); ?></small>
						<span class="fw-bold text-dark fs-6 d-inline-flex align-items-center gap-1">
							<span class="dashicons dashicons-pdf text-danger"></span> <?php echo esc_html( sprintf( _n( '%d Document', '%d Documents', $pdf_count, 'robo' ), $pdf_count ) ); ?>
						</span>
					</div>
				</div>

				<div class="col-6 col-md-3">
					<div class="p-2">
						<small class="text-muted text-uppercase fw-bold fs-7 d-block mb-1"><?php esc_html_e( 'Category', 'robo' ); ?></small>
						<?php
						$cats = get_the_terms( $post_id, 'learning-category' );
						if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) :
							?>
							<a href="<?php echo esc_url( get_term_link( $cats[0] ) ); ?>" class="fw-semibold text-decoration-none text-primary fs-6">
								<?php echo esc_html( $cats[0]->name ); ?>
							</a>
						<?php else : ?>
							<span class="text-muted"><?php esc_html_e( 'General', 'robo' ); ?></span>
						<?php endif; ?>
					</div>
				</div>

				<div class="col-6 col-md-3">
					<div class="p-2">
						<small class="text-muted text-uppercase fw-bold fs-7 d-block mb-1"><?php esc_html_e( 'Last Updated', 'robo' ); ?></small>
						<span class="fw-medium text-dark fs-6 d-inline-flex align-items-center gap-1">
							<span class="dashicons dashicons-calendar-alt text-secondary"></span> <?php echo esc_html( $last_update ); ?>
						</span>
					</div>
				</div>
			</div>

			<!-- Tags -->
			<?php
			$tags = get_the_terms( $post_id, 'learning-tag' );
			if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
				?>
				<div class="mt-4 pt-3 d-flex flex-wrap align-items-center gap-2">
					<small class="text-muted fw-bold me-2"><?php esc_html_e( 'Tags:', 'robo' ); ?></small>
					<?php foreach ( $tags as $t ) : ?>
						<a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="badge bg-white text-secondary border px-3 py-2 rounded-pill text-decoration-none hover-primary">
							#<?php echo esc_html( $t->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</section>
		<?php
	}

	/**
	 * Render PDF Resource Cards Section.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function pdf_resources_section( int $post_id ): void {
		$items = get_post_meta( $post_id, '_robo_lms_pdf_resources', true );
		if ( empty( $items ) || ! is_array( $items ) ) {
			return;
		}

		$last_update = get_the_modified_date( '', $post_id );
		?>
		<section class="robo-lms-section mb-5" aria-label="<?php esc_attr_e( 'PDF Resources', 'robo' ); ?>">
			<div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
				<h2 class="h3 fw-bold mb-0 text-dark d-flex align-items-center gap-2">
					<span class="dashicons dashicons-media-document text-primary fs-3"></span>
					<?php esc_html_e( 'PDF Documentation & Downloads', 'robo' ); ?>
				</h2>
				<span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold fs-7">
					<?php echo esc_html( sprintf( _n( '%d PDF Available', '%d PDFs Available', count( $items ), 'robo' ), count( $items ) ) ); ?>
				</span>
			</div>

			<div class="row g-4">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$title       = ! empty( $item['title'] ) ? $item['title'] : __( 'PDF Resource', 'robo' );
					$desc        = $item['description'] ?? '';
					
					// Strictly determine uploaded PDF file URL
					$file_id     = isset( $item['file_id'] ) ? absint( $item['file_id'] ) : 0;
					$file_url    = isset( $item['file_url'] ) ? trim( $item['file_url'] ) : '';

					if ( empty( $file_url ) && $file_id ) {
						$mime = get_post_mime_type( $file_id );
						$url  = wp_get_attachment_url( $file_id );
						if ( 'application/pdf' === $mime || ( $url && str_contains( strtolower( $url ), '.pdf' ) ) ) {
							$file_url = $url;
						}
					}

					// Verify file_url is strictly a PDF / document URL, NEVER an image URL!
					if ( ! empty( $file_url ) ) {
						$path_lower = strtolower( strtok( $file_url, '?' ) );
						$img_exts   = array( '.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg' );
						foreach ( $img_exts as $ext ) {
							if ( str_ends_with( $path_lower, $ext ) ) {
								$file_url = '';
								break;
							}
						}
					}

					// Preview image for DISPLAY ONLY
					$preview_id  = isset( $item['preview_id'] ) ? absint( $item['preview_id'] ) : 0;
					$preview_url = isset( $item['preview_url'] ) ? trim( $item['preview_url'] ) : '';
					if ( empty( $preview_url ) && $preview_id ) {
						$preview_url = wp_get_attachment_image_url( $preview_id, 'medium' );
					}

					$download_btn = ! empty( $item['button_text'] ) ? $item['button_text'] : __( 'Download PDF', 'robo' );

					// Format File Size
					$file_size = __( 'PDF Document', 'robo' );
					if ( $file_id && function_exists( 'get_attached_file' ) ) {
						$file_path = get_attached_file( $file_id );
						if ( $file_path && file_exists( $file_path ) ) {
							$bytes     = filesize( $file_path );
							$file_size = size_format( $bytes );
						}
					}
					?>
					<div class="col-12">
						<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-lift transition-all p-4">
							<div class="row align-items-center g-4">
								<!-- Preview Image (DISPLAY ONLY - NEVER A CLICKABLE HYPERLINK) -->
								<div class="col-md-3 text-center">
									<?php if ( $preview_url ) : ?>
										<div class="rounded-3 overflow-hidden shadow-sm border border-light-subtle mx-auto" style="max-width: 180px; max-height: 220px;">
											<img src="<?php echo esc_url( $preview_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="w-100 h-100 object-fit-cover" loading="lazy" />
										</div>
									<?php else : ?>
										<div class="bg-primary bg-opacity-10 text-primary rounded-4 p-4 d-flex flex-column align-items-center justify-content-center mx-auto" style="max-width: 180px; min-height: 160px;">
											<span class="dashicons dashicons-pdf display-3 mb-2"></span>
											<span class="badge bg-primary text-white fs-7"><?php esc_html_e( 'PDF Guide', 'robo' ); ?></span>
										</div>
									<?php endif; ?>
								</div>

								<!-- Content & Details -->
								<div class="col-md-9">
									<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
										<h3 class="h4 fw-bold text-dark mb-0"><?php echo esc_html( $title ); ?></h3>
										<span class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill fs-7">
											<i class="dashicons dashicons-category me-1"></i><?php echo esc_html( $file_size ); ?>
										</span>
									</div>

									<?php if ( $desc ) : ?>
										<p class="text-secondary fs-6 mb-3 lh-base"><?php echo esc_html( $desc ); ?></p>
									<?php endif; ?>

									<!-- Metadata list -->
									<div class="d-flex flex-wrap align-items-center gap-4 text-muted small mb-4">
										<span><i class="dashicons dashicons-media-document me-1"></i><strong><?php esc_html_e( 'Format:', 'robo' ); ?></strong> PDF</span>
										<span><i class="dashicons dashicons-calendar-alt me-1"></i><strong><?php esc_html_e( 'Updated:', 'robo' ); ?></strong> <?php echo esc_html( $last_update ); ?></span>
									</div>

									<!-- Action Buttons: STRICTLY USE UPLOADED PDF FILE URL ($file_url) -->
									<?php if ( ! empty( $file_url ) ) : ?>
										<div class="d-flex flex-wrap align-items-center gap-3">
											<!-- 1. View PDF (Opens PDF in new tab, never downloads) -->
											<a href="<?php echo esc_url( $file_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
												<span class="dashicons dashicons-visibility"></span> <?php esc_html_e( 'View PDF', 'robo' ); ?>
											</a>

											<!-- 2. Download PDF (Downloads uploaded PDF file) -->
											<a href="<?php echo esc_url( $file_url ); ?>" download class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
												<span class="dashicons dashicons-download"></span> <?php echo esc_html( $download_btn ); ?>
											</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}

	/**
	 * Render Related Products Section.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function related_products_section( int $post_id ): void {
		$rel_prods = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_products', true ) );
		if ( empty( $rel_prods ) || ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		self::render_related_products_grid( $rel_prods );
	}

	/**
	 * Render Related Videos Section.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function related_videos_section( int $post_id ): void {
		$rel_videos = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_videos', true ) );
		if ( empty( $rel_videos ) ) {
			return;
		}

		self::render_related_cpt_grid( __( 'Related Videos', 'robo' ), 'dashicons-video-alt3', 'text-danger', $rel_videos );
	}

	/**
	 * Render Related Source Code Section.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function related_code_section( int $post_id ): void {
		$rel_code = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_code', true ) );
		if ( empty( $rel_code ) ) {
			return;
		}

		self::render_related_cpt_grid( __( 'Related Source Code', 'robo' ), 'dashicons-editor-code', 'text-success', $rel_code );
	}

	/**
	 * Render Call to Action Section.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function cta_section( int $post_id ): void {
		?>
		<section class="robo-lms-cta my-5 p-5 text-white rounded-4 shadow position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
			<div class="row align-items-center g-4">
				<div class="col-lg-8">
					<h3 class="display-6 fw-bold mb-2 text-white"><?php esc_html_e( 'Expand Your Robotics Knowledge', 'robo' ); ?></h3>
					<p class="lead text-light opacity-90 mb-0"><?php esc_html_e( 'Explore our full library of technical schematics, firmware code, and step-by-step video courses.', 'robo' ); ?></p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'learning-pdf' ) ); ?>" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow">
						<?php esc_html_e( 'Browse All PDF Resources', 'robo' ); ?> <span class="dashicons dashicons-arrow-right-alt ms-1"></span>
					</a>
				</div>
			</div>
		</section>
		<?php
	}

	/**
	 * Render Sticky Desktop Sidebar for Learning PDF Single Page.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function pdf_sidebar( int $post_id ): void {
		$difficulty  = get_post_meta( $post_id, '_robo_lms_difficulty', true );
		$pdf_items   = get_post_meta( $post_id, '_robo_lms_pdf_resources', true );
		$pdf_count   = is_array( $pdf_items ) ? count( $pdf_items ) : 0;
		$rel_prods   = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_products', true ) );
		$rel_videos  = Helper::sanitize_post_ids( get_post_meta( $post_id, '_robo_lms_related_videos', true ) );

		$diff_opts  = Helper::get_difficulty_options();
		$diff_label = $diff_opts[ $difficulty ] ?? __( 'All Levels', 'robo' );
		$cats       = get_the_terms( $post_id, 'learning-category' );
		$page_url   = get_permalink( $post_id );
		$page_title = get_the_title( $post_id );
		?>
		<aside class="sticky-top d-none d-lg-block" style="top: 100px; z-index: 10;" aria-label="<?php esc_attr_e( 'Resource Details Sidebar', 'robo' ); ?>">
			<!-- Quick Information Card -->
			<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
				<h4 class="h5 fw-bold mb-4 border-bottom pb-2 text-dark d-flex align-items-center gap-2">
					<span class="dashicons dashicons-info text-primary fs-4"></span>
					<?php esc_html_e( 'Quick Information', 'robo' ); ?>
				</h4>

				<ul class="list-unstyled mb-4">
					<li class="d-flex align-items-center justify-content-between py-2 border-bottom">
						<span class="text-muted"><i class="dashicons dashicons-chart-bar me-1"></i><?php esc_html_e( 'Difficulty:', 'robo' ); ?></span>
						<span class="badge bg-primary px-2.5 py-1.5 rounded-pill"><?php echo esc_html( $diff_label ); ?></span>
					</li>

					<li class="d-flex align-items-center justify-content-between py-2 border-bottom">
						<span class="text-muted"><i class="dashicons dashicons-category me-1"></i><?php esc_html_e( 'Category:', 'robo' ); ?></span>
						<span class="fw-semibold text-dark">
							<?php echo ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? esc_html( $cats[0]->name ) : esc_html__( 'General', 'robo' ); ?>
						</span>
					</li>

					<li class="d-flex align-items-center justify-content-between py-2 border-bottom">
						<span class="text-muted"><i class="dashicons dashicons-pdf me-1 text-danger"></i><?php esc_html_e( 'PDF Files:', 'robo' ); ?></span>
						<span class="fw-bold text-dark"><?php echo esc_html( (string) $pdf_count ); ?></span>
					</li>

					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<li class="d-flex align-items-center justify-content-between py-2 border-bottom">
							<span class="text-muted"><i class="dashicons dashicons-cart me-1 text-warning"></i><?php esc_html_e( 'Products:', 'robo' ); ?></span>
							<span class="fw-bold text-dark"><?php echo esc_html( (string) count( $rel_prods ) ); ?></span>
						</li>
					<?php endif; ?>

					<li class="d-flex align-items-center justify-content-between py-2">
						<span class="text-muted"><i class="dashicons dashicons-video-alt3 me-1 text-danger"></i><?php esc_html_e( 'Videos:', 'robo' ); ?></span>
						<span class="fw-bold text-dark"><?php echo esc_html( (string) count( $rel_videos ) ); ?></span>
					</li>
				</ul>

				<!-- Social Share Buttons -->
				<div class="mb-4 pt-3 border-top">
					<small class="text-muted text-uppercase fw-bold fs-7 d-block mb-2"><?php esc_html_e( 'Share Resource', 'robo' ); ?></small>
					<div class="d-flex flex-wrap gap-2">
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( $page_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle" title="<?php esc_attr_e( 'Share on Facebook', 'robo' ); ?>">
							<span class="dashicons dashicons-facebook"></span>
						</a>
						<a href="https://twitter.com/intent/tweet?text=<?php echo rawurlencode( $page_title ); ?>&url=<?php echo rawurlencode( $page_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle" title="<?php esc_attr_e( 'Share on X/Twitter', 'robo' ); ?>">
							<span class="dashicons dashicons-twitter"></span>
						</a>
						<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo rawurlencode( $page_url ); ?>&title=<?php echo rawurlencode( $page_title ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle" title="<?php esc_attr_e( 'Share on LinkedIn', 'robo' ); ?>">
							<span class="dashicons dashicons-linkedin"></span>
						</a>
					</div>
				</div>

				<!-- Back to Resources Button -->
				<a href="<?php echo esc_url( get_post_type_archive_link( 'learning-pdf' ) ); ?>" class="btn btn-outline-primary w-100 rounded-pill fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
					<span class="dashicons dashicons-arrow-left-alt"></span> <?php esc_html_e( 'Back to Resources', 'robo' ); ?>
				</a>
			</div>
		</aside>
		<?php
	}

	/**
	 * Render Archive Card for Grid layout.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function archive_card( int $post_id ): void {
		$post_obj = get_post( $post_id );
		if ( ! $post_obj || 'attachment' === $post_obj->post_type ) {
			return;
		}

		$post_type  = $post_obj->post_type;
		$post_url   = get_permalink( $post_id );

		// Extra safety check: if $post_url is empty, invalid, or contains /wp-content/uploads/
		if ( empty( $post_url ) || str_contains( $post_url, '/wp-content/uploads/' ) ) {
			$post_url = get_post_type_archive_link( $post_type ?: 'learning-pdf' );
		}

		$short_desc  = get_post_meta( $post_id, '_robo_lms_short_description', true );
		$difficulty  = get_post_meta( $post_id, '_robo_lms_difficulty', true );
		$duration    = get_post_meta( $post_id, '_robo_lms_estimated_duration', true );
		$is_featured = get_post_meta( $post_id, '_robo_lms_is_featured', true );
		$thumb_id    = get_post_meta( $post_id, '_robo_lms_thumbnail_id', true );

		$img_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium_large' ) : get_the_post_thumbnail_url( $post_id, 'medium_large' );

		$diff_options = Helper::get_difficulty_options();
		$diff_label   = $diff_options[ $difficulty ] ?? '';

		$cpt_badge_class = 'bg-primary';
		$cpt_icon        = 'dashicons-media-document';
		$cpt_name        = __( 'PDF', 'robo' );

		if ( 'learning-code' === $post_type ) {
			$cpt_badge_class = 'bg-success';
			$cpt_icon        = 'dashicons-editor-code';
			$cpt_name        = __( 'Code', 'robo' );
		} elseif ( 'learning-video' === $post_type ) {
			$cpt_badge_class = 'bg-danger';
			$cpt_icon        = 'dashicons-video-alt3';
			$cpt_name        = __( 'Video', 'robo' );
		}
		?>
		<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden robo-lms-card hover-lift transition-all">
			<div class="position-relative bg-dark bg-gradient text-white overflow-hidden" style="min-height: 200px;">
				<?php if ( $img_url ) : ?>
					<a href="<?php echo esc_url( $post_url ); ?>">
						<img src="<?php echo esc_url( $img_url ); ?>" class="card-img-top w-100 h-100 object-fit-cover opacity-90 transition-zoom" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" style="min-height: 200px; max-height: 220px;" loading="lazy" />
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url( $post_url ); ?>" class="d-flex align-items-center justify-content-center h-100 p-5 text-secondary text-decoration-none">
						<span class="dashicons <?php echo esc_attr( $cpt_icon ); ?> display-3"></span>
					</a>
				<?php endif; ?>

				<div class="position-absolute top-0 start-0 m-3 d-flex flex-column gap-1">
					<span class="badge <?php echo esc_attr( $cpt_badge_class ); ?> text-white px-2.5 py-1.5 rounded-pill shadow-sm fs-7 fw-semibold">
						<i class="dashicons <?php echo esc_attr( $cpt_icon ); ?> me-1"></i><?php echo esc_html( $cpt_name ); ?>
					</span>
					<?php if ( '1' === $is_featured ) : ?>
						<span class="badge bg-warning text-dark px-2.5 py-1.5 rounded-pill shadow-sm fs-7 fw-bold">
							★ <?php esc_html_e( 'Featured', 'robo' ); ?>
						</span>
					<?php endif; ?>
				</div>

				<?php if ( $diff_label ) : ?>
					<div class="position-absolute bottom-0 end-0 m-3">
						<span class="badge bg-dark bg-opacity-75 text-white backdrop-blur px-2.5 py-1.5 rounded-pill border border-light border-opacity-25 fs-7">
							<?php echo esc_html( $diff_label ); ?>
						</span>
					</div>
				<?php endif; ?>
			</div>

			<div class="card-body d-flex flex-column p-4">
				<?php
				$cats = get_the_terms( $post_id, 'learning-category' );
				if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) :
					?>
					<div class="mb-2">
						<span class="text-uppercase tracking-wider fw-bold text-primary fs-7">
							<?php echo esc_html( $cats[0]->name ); ?>
						</span>
					</div>
				<?php endif; ?>

				<h5 class="card-title fw-bold mb-2">
					<a href="<?php echo esc_url( $post_url ); ?>" class="text-decoration-none text-dark hover-primary line-clamp-2">
						<?php echo esc_html( get_the_title( $post_id ) ); ?>
					</a>
				</h5>

				<p class="card-text text-muted fs-6 mb-4 line-clamp-3">
					<?php
					if ( $short_desc ) {
						echo esc_html( $short_desc );
					} else {
						echo esc_html( wp_trim_words( get_the_excerpt( $post_id ), 20 ) );
					}
					?>
				</p>

				<div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
					<?php if ( $duration ) : ?>
						<small class="text-muted d-inline-flex align-items-center gap-1">
							<span class="dashicons dashicons-clock"></span> <?php echo esc_html( $duration ); ?>
						</small>
					<?php else : ?>
						<small class="text-muted d-inline-flex align-items-center gap-1">
							<span class="dashicons dashicons-calendar-alt"></span> <?php echo esc_html( get_the_date( '', $post_id ) ); ?>
						</small>
					<?php endif; ?>

					<a href="<?php echo esc_url( $post_url ); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1">
						<?php esc_html_e( 'View Details', 'robo' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
					</a>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Filter Bar for Archive Page.
	 *
	 * @param string $cpt Post type slug.
	 */
	public static function filter_bar( string $cpt ): void {
		$search     = isset( $_GET['lms_search'] ) ? sanitize_text_field( wp_unslash( $_GET['lms_search'] ) ) : '';
		$cat        = isset( $_GET['lms_cat'] ) ? sanitize_key( $_GET['lms_cat'] ) : '';
		$tag        = isset( $_GET['lms_tag'] ) ? sanitize_key( $_GET['lms_tag'] ) : '';
		$difficulty = isset( $_GET['lms_difficulty'] ) ? sanitize_key( $_GET['lms_difficulty'] ) : '';
		$sort       = isset( $_GET['lms_sort'] ) ? sanitize_key( $_GET['lms_sort'] ) : 'newest';

		$categories = get_terms( array( 'taxonomy' => 'learning-category', 'hide_empty' => false ) );
		$tags       = get_terms( array( 'taxonomy' => 'learning-tag', 'hide_empty' => false ) );
		?>
		<div class="card border-0 shadow-sm rounded-4 mb-5 bg-white p-4 robo-lms-filter-bar" data-cpt="<?php echo esc_attr( $cpt ); ?>">
			<form id="robo-lms-filter-form" method="get" action="<?php echo esc_url( get_post_type_archive_link( $cpt ) ); ?>">
				<div class="row g-3 align-items-end">
					<div class="col-md-6 col-lg-3">
						<label class="form-label fw-bold text-secondary small text-uppercase mb-1"><?php esc_html_e( 'Search', 'robo' ); ?></label>
						<div class="input-group">
							<span class="input-group-text bg-light border-end-0"><span class="dashicons dashicons-search"></span></span>
							<input type="text" name="lms_search" value="<?php echo esc_attr( $search ); ?>" class="form-control bg-light border-start-0" placeholder="<?php esc_attr_e( 'Search title or keyword...', 'robo' ); ?>" />
						</div>
					</div>

					<div class="col-md-6 col-lg-2">
						<label class="form-label fw-bold text-secondary small text-uppercase mb-1"><?php esc_html_e( 'Category', 'robo' ); ?></label>
						<select name="lms_cat" class="form-select bg-light">
							<option value=""><?php esc_html_e( 'All Categories', 'robo' ); ?></option>
							<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
								<?php foreach ( $categories as $c ) : ?>
									<option value="<?php echo esc_attr( $c->slug ); ?>" <?php selected( $cat, $c->slug ); ?>><?php echo esc_html( $c->name ); ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>

					<div class="col-md-6 col-lg-2">
						<label class="form-label fw-bold text-secondary small text-uppercase mb-1"><?php esc_html_e( 'Tag', 'robo' ); ?></label>
						<select name="lms_tag" class="form-select bg-light">
							<option value=""><?php esc_html_e( 'All Tags', 'robo' ); ?></option>
							<?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
								<?php foreach ( $tags as $t ) : ?>
									<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( $tag, $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>

					<div class="col-md-6 col-lg-2">
						<label class="form-label fw-bold text-secondary small text-uppercase mb-1"><?php esc_html_e( 'Difficulty', 'robo' ); ?></label>
						<select name="lms_difficulty" class="form-select bg-light">
							<option value=""><?php esc_html_e( 'All Levels', 'robo' ); ?></option>
							<?php foreach ( Helper::get_difficulty_options() as $val => $lbl ) : ?>
								<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $difficulty, $val ); ?>><?php echo esc_html( $lbl ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="col-md-6 col-lg-2">
						<label class="form-label fw-bold text-secondary small text-uppercase mb-1"><?php esc_html_e( 'Sort By', 'robo' ); ?></label>
						<select name="lms_sort" class="form-select bg-light">
							<option value="newest" <?php selected( $sort, 'newest' ); ?>><?php esc_html_e( 'Newest First', 'robo' ); ?></option>
							<option value="oldest" <?php selected( $sort, 'oldest' ); ?>><?php esc_html_e( 'Oldest First', 'robo' ); ?></option>
							<option value="alphabetical" <?php selected( $sort, 'alphabetical' ); ?>><?php esc_html_e( 'A-Z Alphabetical', 'robo' ); ?></option>
						</select>
					</div>

					<div class="col-md-6 col-lg-1 d-flex gap-2">
						<button type="submit" class="btn btn-primary w-100" title="<?php esc_attr_e( 'Apply Filter', 'robo' ); ?>">
							<span class="dashicons dashicons-filter"></span>
						</button>
						<a href="<?php echo esc_url( get_post_type_archive_link( $cpt ) ); ?>" class="btn btn-outline-secondary" title="<?php esc_attr_e( 'Reset Filters', 'robo' ); ?>">
							<span class="dashicons dashicons-undo"></span>
						</a>
					</div>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Render Resource Gallery / Repeater Content for Single Page.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $cpt Post type slug.
	 */
	public static function resource_gallery( int $post_id, string $cpt ): void {
		if ( 'learning-pdf' === $cpt ) {
			self::pdf_resources_section( $post_id );
		} elseif ( 'learning-code' === $cpt ) {
			self::render_code_gallery( $post_id );
		} elseif ( 'learning-video' === $cpt ) {
			self::render_video_gallery( $post_id );
		}
	}

	/**
	 * Render Code Resource Gallery.
	 *
	 * @param int $post_id Post ID.
	 */
	private static function render_code_gallery( int $post_id ): void {
		$items = get_post_meta( $post_id, '_robo_lms_code_resources', true );
		if ( empty( $items ) || ! is_array( $items ) ) {
			return;
		}

		$lang_options = Helper::get_language_options();
		?>
		<div class="robo-lms-section my-5">
			<h3 class="fw-bold mb-4 pb-2 border-bottom d-flex align-items-center gap-2 text-dark">
				<span class="dashicons dashicons-editor-code text-success fs-3"></span>
				<?php esc_html_e( 'Source Code & Repositories', 'robo' ); ?>
			</h3>

			<div class="row g-4">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$title       = $item['title'] ?? __( 'Source Code Resource', 'robo' );
					$desc        = $item['description'] ?? '';
					$repo_url    = $item['repo_url'] ?? '';
					$file_id     = isset( $item['file_id'] ) ? absint( $item['file_id'] ) : 0;
					$file_url    = isset( $item['file_url'] ) ? trim( $item['file_url'] ) : '';
					if ( empty( $file_url ) && $file_id ) {
						$file_url = wp_get_attachment_url( $file_id );
					}
					$preview_url = $item['preview_url'] ?? '';
					$lang        = $item['language'] ?? 'other';
					$lang_label  = $lang_options[ $lang ] ?? strtoupper( $lang );
					?>
					<div class="col-md-6">
						<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4">
							<div class="d-flex align-items-center justify-content-between mb-2">
								<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded-pill fs-7 fw-bold">
									<?php echo esc_html( $lang_label ); ?>
								</span>
								<?php if ( $preview_url ) : ?>
									<img src="<?php echo esc_url( $preview_url ); ?>" alt="Preview" class="rounded-circle object-fit-cover" style="width: 40px; height: 40px;" loading="lazy" />
								<?php endif; ?>
							</div>

							<h5 class="fw-bold mb-2 text-dark"><?php echo esc_html( $title ); ?></h5>
							<?php if ( $desc ) : ?>
								<p class="text-muted small mb-3"><?php echo esc_html( $desc ); ?></p>
							<?php endif; ?>

							<div class="d-flex flex-wrap align-items-center gap-2 mt-auto pt-3 border-top">
								<?php if ( $repo_url ) : ?>
									<?php echo Helper::render_repo_button( $repo_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php endif; ?>

								<?php if ( ! empty( $file_url ) ) : ?>
									<a href="<?php echo esc_url( $file_url ); ?>" download class="btn btn-outline-success btn-sm rounded-pill d-inline-flex align-items-center gap-1">
										<span class="dashicons dashicons-archive"></span> <?php esc_html_e( 'Download ZIP', 'robo' ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Video Resource Gallery.
	 *
	 * @param int $post_id Post ID.
	 */
	private static function render_video_gallery( int $post_id ): void {
		$items = get_post_meta( $post_id, '_robo_lms_video_resources', true );
		if ( empty( $items ) || ! is_array( $items ) ) {
			return;
		}

		?>
		<div class="robo-lms-section my-5">
			<h3 class="fw-bold mb-4 pb-2 border-bottom d-flex align-items-center gap-2 text-dark">
				<span class="dashicons dashicons-video-alt3 text-danger fs-3"></span>
				<?php esc_html_e( 'Video Lessons & Tutorials', 'robo' ); ?>
			</h3>

			<div class="row g-4">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$title     = $item['title'] ?? __( 'Video Resource', 'robo' );
					$desc      = $item['description'] ?? '';
					$video_url = $item['video_url'] ?? '';
					$duration  = $item['duration'] ?? '';
					?>
					<div class="col-lg-6">
						<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white p-3">
							<?php echo Helper::render_video_embed( $video_url, $title ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

							<div class="p-2">
								<div class="d-flex align-items-center justify-content-between mb-1">
									<h5 class="fw-bold mb-0 text-dark"><?php echo esc_html( $title ); ?></h5>
									<?php if ( $duration ) : ?>
										<span class="badge bg-light text-dark border fs-7">
											<span class="dashicons dashicons-clock"></span> <?php echo esc_html( $duration ); ?>
										</span>
									<?php endif; ?>
								</div>

								<?php if ( $desc ) : ?>
									<p class="text-muted small mb-0 mt-2"><?php echo esc_html( $desc ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Related Resources sections on single post page.
	 *
	 * @param int $post_id Current Post ID.
	 */
	public static function related_resources( int $post_id ): void {
		self::related_products_section( $post_id );
		self::related_videos_section( $post_id );
		self::related_code_section( $post_id );
	}

	/**
	 * Render Related CPT Grid section.
	 *
	 * @param string     $title Section title.
	 * @param string     $icon Dashicon class.
	 * @param string     $color_class Text color class.
	 * @param array<int> $post_ids Post IDs array.
	 */
	private static function render_related_cpt_grid( string $title, string $icon, string $color_class, array $post_ids ): void {
		$query = new \WP_Query(
			array(
				'post_type'      => array( 'learning-pdf', 'learning-code', 'learning-video' ),
				'post__in'       => $post_ids,
				'posts_per_page' => count( $post_ids ),
				'orderby'        => 'post__in',
			)
		);

		if ( ! $query->have_posts() ) {
			return;
		}

		?>
		<div class="robo-lms-section my-5">
			<h3 class="fw-bold mb-4 pb-2 border-bottom d-flex align-items-center gap-2 text-dark">
				<span class="dashicons <?php echo esc_attr( $icon ); ?> <?php echo esc_attr( $color_class ); ?> fs-3"></span>
				<?php echo esc_html( $title ); ?>
			</h3>

			<div class="row g-4">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					echo '<div class="col-md-6 col-lg-4 d-flex align-items-stretch">';
					self::archive_card( get_the_ID() );
					echo '</div>';
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Related WooCommerce Products Grid.
	 *
	 * @param array<int> $product_ids Product IDs.
	 */
	private static function render_related_products_grid( array $product_ids ): void {
		$products = array();

		foreach ( $product_ids as $p_id ) {
			$p_id = absint( $p_id );
			if ( ! $p_id || ! function_exists( 'wc_get_product' ) ) {
				continue;
			}

			// Ensure $p_id is a valid product post type
			if ( 'product' !== get_post_type( $p_id ) ) {
				continue;
			}

			$prod = wc_get_product( $p_id );
			if ( $prod && $prod->is_visible() ) {
				$products[] = $prod;
			}
		}

		if ( empty( $products ) ) {
			return;
		}

		?>
		<div class="robo-lms-section my-5">
			<h3 class="fw-bold mb-4 pb-2 border-bottom d-flex align-items-center gap-2 text-dark">
				<span class="dashicons dashicons-cart text-warning fs-3"></span>
				<?php esc_html_e( 'Related Products', 'robo' ); ?>
			</h3>

			<div class="row g-4">
				<?php foreach ( $products as $product ) : ?>
					<?php
					if ( ! $product instanceof \WC_Product ) {
						continue;
					}
					$product_id  = $product->get_id();
					$p_title     = $product->get_name();
					// STRICTLY USE WOOCOMMERCE PRODUCT PERMALINK (get_permalink($product_id))
					$product_url = get_permalink( $product_id );
					$p_price     = $product->get_price_html();
					// IMAGE IS FOR DISPLAY ONLY - Never use image URL as destination href!
					$p_img       = $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'card-img-top object-fit-cover w-100', 'style' => 'height: 180px;', 'loading' => 'lazy' ) );
					?>
					<div class="col-md-6 col-lg-4">
						<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift bg-white">
							<!-- Product Card Image Link -> Goes to product permalink -->
							<a href="<?php echo esc_url( $product_url ); ?>">
								<?php echo $p_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
							<div class="card-body d-flex flex-column p-3">
								<h6 class="card-title fw-bold mb-2">
									<!-- Product Title Link -> Goes to product permalink -->
									<a href="<?php echo esc_url( $product_url ); ?>" class="text-dark text-decoration-none hover-primary">
										<?php echo esc_html( $p_title ); ?>
									</a>
								</h6>
								<div class="mt-auto pt-2 d-flex align-items-center justify-content-between">
									<span class="fw-bold text-primary fs-6"><?php echo $p_price; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									<!-- View Kit Button -> Goes to product permalink ($product_url) -->
									<a href="<?php echo esc_url( $product_url ); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1" title="<?php esc_attr_e( 'View Kit', 'robo' ); ?>">
										<?php esc_html_e( 'View Kit', 'robo' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
