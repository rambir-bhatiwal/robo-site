<?php
/**
 * Single Template for Learning Resources
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Increment View Count on Single Page View
robo_lr_increment_views( get_the_ID() );

while ( have_posts() ) :
	the_post();

	$post_id          = get_the_ID();
	$short_desc       = get_post_meta( $post_id, '_robo_lr_short_desc', true );
	$difficulty       = get_post_meta( $post_id, '_robo_lr_difficulty', true );
	$duration         = get_post_meta( $post_id, '_robo_lr_duration', true );
	$instructor       = get_post_meta( $post_id, '_robo_lr_instructor', true );
	$has_certificate  = get_post_meta( $post_id, '_robo_lr_has_certificate', true );

	$cover_img_id     = get_post_meta( $post_id, '_robo_lr_cover_image_id', true );
	$gallery_ids      = get_post_meta( $post_id, '_robo_lr_gallery_image_ids', true );

	$pdf_resources    = get_post_meta( $post_id, '_robo_lr_pdf_resources', true );
	$video_resources  = get_post_meta( $post_id, '_robo_lr_video_resources', true );
	$github_resources = get_post_meta( $post_id, '_robo_lr_github_resources', true );
	$downloads        = get_post_meta( $post_id, '_robo_lr_downloads', true );
	$related_wc_ids   = get_post_meta( $post_id, '_robo_lr_related_product_ids', true );
	$external_res     = get_post_meta( $post_id, '_robo_lr_external_resources', true );
	$outcomes         = get_post_meta( $post_id, '_robo_lr_outcomes', true );
	$requirements     = get_post_meta( $post_id, '_robo_lr_requirements', true );
	$faqs             = get_post_meta( $post_id, '_robo_lr_faqs', true );

	$attachment_ids   = get_post_meta( $post_id, '_robo_lr_attachment_ids', true );

	$views_count      = robo_lr_get_views( $post_id );
	$likes_count      = robo_lr_get_likes( $post_id );
	$downloads_count  = robo_lr_get_downloads( $post_id );
	$reading_time     = robo_lr_get_reading_time( $post_id );

	$categories       = get_the_terms( $post_id, 'learning_category' );
	$tags             = get_the_terms( $post_id, 'learning_tag' );

	$featured_img_url = '';
	if ( $cover_img_id ) {
		$featured_img_url = wp_get_attachment_image_url( $cover_img_id, 'full' );
	} elseif ( has_post_thumbnail() ) {
		$featured_img_url = get_the_post_thumbnail_url( $post_id, 'full' );
	}

	$cookie_liked = isset( $_COOKIE[ 'robo_lr_liked_' . $post_id ] );
	$cookie_fav   = isset( $_COOKIE[ 'robo_lr_fav_' . $post_id ] );
	if ( is_user_logged_in() ) {
		$fav_meta   = get_user_meta( get_current_user_id(), '_robo_lr_favorites', true );
		$cookie_fav = is_array( $fav_meta ) && in_array( $post_id, $fav_meta, true );
	}
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'robo-lr-single-article' ); ?>>

		<!-- SECTION 1: HERO & SECTION 2: BREADCRUMB -->
		<section class="robo-lr-single-hero">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-10 col-xl-9">
						<!-- Breadcrumb -->
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="bi bi-house-door me-1"></i> Home</a></li>
								<li class="breadcrumb-item"><a href="<?php echo esc_url( get_post_type_archive_link( 'learning-resource' ) ); ?>">Learning Resources</a></li>
								<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
									<li class="breadcrumb-item"><a href="<?php echo esc_url( get_term_link( $categories[0] ) ); ?>"><?php echo esc_html( $categories[0]->name ); ?></a></li>
								<?php endif; ?>
								<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
							</ol>
						</nav>

						<!-- Badges -->
						<div class="mb-3">
							<?php echo robo_lr_render_badges( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
								<?php foreach ( $categories as $cat_t ) : ?>
									<a href="<?php echo esc_url( get_term_link( $cat_t ) ); ?>" class="badge bg-primary text-decoration-none me-1"><?php echo esc_html( $cat_t->name ); ?></a>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>

						<!-- SECTION 4: TITLE -->
						<h1 class="display-4 fw-bold mb-3 text-white"><?php the_title(); ?></h1>

						<!-- SECTION 5: SHORT DESCRIPTION -->
						<?php if ( $short_desc ) : ?>
							<p class="lead text-light opacity-90 mb-4"><?php echo esc_html( $short_desc ); ?></p>
						<?php endif; ?>

						<!-- Hero Meta Bar -->
						<div class="robo-lr-hero-meta">
							<?php if ( $instructor ) : ?>
								<div class="robo-lr-hero-meta-item">
									<i class="bi bi-person-badge fs-5 text-info"></i>
									<span>Instructor: <strong><?php echo esc_html( $instructor ); ?></strong></span>
								</div>
							<?php endif; ?>

							<div class="robo-lr-hero-meta-item">
								<i class="bi bi-clock-history fs-5 text-warning"></i>
								<span>Reading Time: <strong><?php echo esc_html( $reading_time ); ?> mins</strong></span>
							</div>

							<div class="robo-lr-hero-meta-item">
								<i class="bi bi-eye fs-5 text-primary"></i>
								<span>Views: <strong><?php echo esc_html( number_format( $views_count ) ); ?></strong></span>
							</div>

							<div class="robo-lr-hero-meta-item ms-auto">
								<button type="button" class="btn btn-sm btn-outline-light rounded-pill btn-action-like <?php echo $cookie_liked ? 'liked' : ''; ?>" data-post-id="<?php echo esc_attr( $post_id ); ?>">
									<i class="bi bi-heart-fill me-1"></i> <span class="like-count"><?php echo esc_html( $likes_count ); ?></span> Likes
								</button>

								<button type="button" class="btn btn-sm btn-outline-warning rounded-pill ms-2 btn-action-fav <?php echo $cookie_fav ? 'bookmarked' : ''; ?>" data-post-id="<?php echo esc_attr( $post_id ); ?>">
									<i class="bi bi-bookmark-star-fill me-1"></i> Favorite
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- MAIN BODY SECTION -->
		<div class="container py-5">
			<div class="row justify-content-center">
				<div class="col-lg-8">

					<!-- SECTION 3: FEATURED IMAGE -->
					<?php if ( $featured_img_url ) : ?>
						<div class="mb-5 rounded-4 overflow-hidden shadow-sm">
							<img src="<?php echo esc_url( $featured_img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="img-fluid w-100" loading="eager">
						</div>
					<?php endif; ?>

					<!-- SECTION 7: LEARNING INFORMATION GRID -->
					<div class="robo-lr-section-block bg-light border-0 shadow-sm mb-5">
						<h3 class="robo-lr-section-title"><i class="bi bi-info-circle-fill"></i> Resource Snapshot</h3>
						<div class="row g-3 text-dark">
							<div class="col-sm-6 col-md-3">
								<div class="p-3 bg-white rounded-3 border text-center">
									<i class="bi bi-bar-chart-steps fs-3 text-primary d-block mb-1"></i>
									<span class="text-muted small d-block">Difficulty</span>
									<strong class="text-capitalize"><?php echo esc_html( $difficulty ? $difficulty : 'Beginner' ); ?></strong>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="p-3 bg-white rounded-3 border text-center">
									<i class="bi bi-hourglass-split fs-3 text-warning d-block mb-1"></i>
									<span class="text-muted small d-block">Est. Duration</span>
									<strong><?php echo esc_html( $duration ? $duration : 'Self-paced' ); ?></strong>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="p-3 bg-white rounded-3 border text-center">
									<i class="bi bi-award fs-3 text-success d-block mb-1"></i>
									<span class="text-muted small d-block">Certificate</span>
									<strong><?php echo $has_certificate ? 'Included' : 'None'; ?></strong>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="p-3 bg-white rounded-3 border text-center">
									<i class="bi bi-download fs-3 text-info d-block mb-1"></i>
									<span class="text-muted small d-block">Downloads</span>
									<strong><?php echo esc_html( number_format( $downloads_count ) ); ?></strong>
								</div>
							</div>
						</div>

						<!-- Social Share Buttons -->
						<div class="mt-4 pt-3 border-top">
							<?php echo robo_lr_render_social_share( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>

					<!-- SECTION 6: MAIN CONTENT -->
					<div class="robo-lr-main-content mb-5 fs-5 leading-relaxed">
						<?php the_content(); ?>
					</div>

					<!-- SECTION 8: LEARNING OUTCOMES -->
					<?php if ( ! empty( $outcomes ) ) : ?>
						<div class="robo-lr-section-block">
							<h3 class="robo-lr-section-title"><i class="bi bi-check-circle"></i> What You Will Learn</h3>
							<ul class="robo-lr-check-list">
								<?php foreach ( $outcomes as $out_item ) : ?>
									<?php $txt = is_array( $out_item ) ? ( isset( $out_item['text'] ) ? $out_item['text'] : '' ) : $out_item; ?>
									<?php if ( ! empty( trim( $txt ) ) ) : ?>
										<li><i class="bi bi-check2-circle"></i> <span><?php echo esc_html( $txt ); ?></span></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<!-- SECTION 9: REQUIREMENTS -->
					<?php if ( ! empty( $requirements ) ) : ?>
						<div class="robo-lr-section-block">
							<h3 class="robo-lr-section-title"><i class="bi bi-tools"></i> Prerequisites & Hardware Required</h3>
							<ul class="robo-lr-req-list">
								<?php foreach ( $requirements as $req_item ) : ?>
									<?php $txt = is_array( $req_item ) ? ( isset( $req_item['text'] ) ? $req_item['text'] : '' ) : $req_item; ?>
									<?php if ( ! empty( trim( $txt ) ) ) : ?>
										<li><i class="bi bi-gear-fill"></i> <span><?php echo esc_html( $txt ); ?></span></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<!-- SECTION 10: EMBEDDED VIDEOS -->
					<?php if ( ! empty( $video_resources ) ) : ?>
						<div id="section-videos" class="robo-lr-section-block">
							<h3 class="robo-lr-section-title"><i class="bi bi-play-btn-fill"></i> Video Lessons & Demonstrations</h3>
							<?php foreach ( $video_resources as $vid ) : ?>
								<div class="mb-4">
									<div class="d-flex justify-content-between align-items-center mb-2">
										<h5 class="fw-bold mb-0 text-dark"><?php echo esc_html( $vid['title'] ); ?></h5>
										<button type="button" class="btn btn-sm btn-outline-danger rounded-pill copy-link-btn" data-link="<?php echo esc_url( $vid['url'] ); ?>">
											<i class="bi bi-youtube me-1"></i> Copy Video Link
										</button>
									</div>
									<?php echo robo_lr_render_video_embed( $vid['url'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- SECTION 11: PDF RESOURCES -->
					<?php if ( ! empty( $pdf_resources ) ) : ?>
						<div id="section-pdfs" class="robo-lr-section-block">
							<h3 class="robo-lr-section-title"><i class="bi bi-file-earmark-pdf-fill"></i> PDF Documentation & Datasheets</h3>
							<?php foreach ( $pdf_resources as $pdf ) : ?>
								<div class="robo-lr-resource-card">
									<div class="robo-lr-resource-icon bg-danger-subtle text-danger">
										<i class="bi bi-file-earmark-pdf"></i>
									</div>
									<div class="robo-lr-resource-info">
										<div class="robo-lr-resource-title"><?php echo esc_html( $pdf['title'] ); ?></div>
										<?php if ( ! empty( $pdf['description'] ) ) : ?>
											<div class="robo-lr-resource-desc"><?php echo esc_html( $pdf['description'] ); ?></div>
										<?php endif; ?>
									</div>
									<a href="<?php echo esc_url( $pdf['file_url'] ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-danger rounded-pill px-3">
										<i class="bi bi-box-arrow-up-right me-1"></i> Open PDF
									</a>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- SECTION 12: GITHUB RESOURCES -->
					<?php if ( ! empty( $github_resources ) ) : ?>
						<div id="section-github" class="robo-lr-section-block">
							<h3 class="robo-lr-section-title"><i class="bi bi-github"></i> Code Repositories</h3>
							<?php foreach ( $github_resources as $gh ) : ?>
								<div class="robo-lr-resource-card">
									<div class="robo-lr-resource-icon bg-dark text-white">
										<i class="bi bi-github"></i>
									</div>
									<div class="robo-lr-resource-info">
										<div class="robo-lr-resource-title"><?php echo esc_html( $gh['title'] ); ?></div>
										<?php if ( ! empty( $gh['description'] ) ) : ?>
											<div class="robo-lr-resource-desc"><?php echo esc_html( $gh['description'] ); ?></div>
										<?php endif; ?>
									</div>
									<div class="d-flex gap-2">
										<button type="button" class="btn btn-sm btn-outline-secondary rounded-pill copy-link-btn" data-link="<?php echo esc_url( $gh['url'] ); ?>">
											<i class="bi bi-clipboard me-1"></i> Copy Repo Link
										</button>
										<a href="<?php echo esc_url( $gh['url'] ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-dark rounded-pill px-3">
											<i class="bi bi-box-arrow-up-right me-1"></i> GitHub
										</a>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- SECTION 13: DOWNLOADS -->
					<?php if ( ! empty( $downloads ) || ! empty( $attachment_ids ) ) : ?>
						<div id="section-downloads" class="robo-lr-section-block">
							<div class="d-flex justify-content-between align-items-center mb-3">
								<h3 class="robo-lr-section-title mb-0 border-0 pb-0"><i class="bi bi-cloud-arrow-down-fill"></i> Downloadable Files</h3>
								
								<?php
								$zip_url = add_query_arg(
									array(
										'action'  => 'robo_lr_download_all_zip',
										'post_id' => $post_id,
									),
									admin_url( 'admin-ajax.php' )
								);
								?>
								<a href="<?php echo esc_url( $zip_url ); ?>" class="btn btn-sm btn-success rounded-pill px-3">
									<i class="bi bi-file-earmark-zip me-1"></i> Download All (ZIP)
								</a>
							</div>

							<?php if ( ! empty( $downloads ) ) : ?>
								<?php foreach ( $downloads as $dl ) : ?>
									<?php
									$dl_link = add_query_arg(
										array(
											'action'   => 'robo_lr_download_file',
											'post_id'  => $post_id,
											'file_url' => $dl['file_url'],
										),
										admin_url( 'admin-ajax.php' )
									);
									?>
									<div class="robo-lr-resource-card">
										<div class="robo-lr-resource-icon bg-primary-subtle text-primary">
											<i class="bi bi-download"></i>
										</div>
										<div class="robo-lr-resource-info">
											<div class="robo-lr-resource-title"><?php echo esc_html( $dl['title'] ); ?></div>
											<?php if ( ! empty( $dl['description'] ) ) : ?>
												<div class="robo-lr-resource-desc"><?php echo esc_html( $dl['description'] ); ?></div>
											<?php endif; ?>
										</div>
										<a href="<?php echo esc_url( $dl_link ); ?>" class="btn btn-sm btn-primary rounded-pill px-3">
											<i class="bi bi-download me-1"></i> Download
										</a>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>

							<?php if ( ! empty( $attachment_ids ) ) : ?>
								<h5 class="fw-bold mt-4 mb-3 text-muted">Attached Documents</h5>
								<?php foreach ( $attachment_ids as $att_id ) : ?>
									<?php
									$att_title = get_the_title( $att_id );
									$att_url   = wp_get_attachment_url( $att_id );
									$dl_link   = add_query_arg(
										array(
											'action'   => 'robo_lr_download_file',
											'post_id'  => $post_id,
											'file_url' => $att_url,
										),
										admin_url( 'admin-ajax.php' )
									);
									?>
									<div class="robo-lr-resource-card">
										<div class="robo-lr-resource-icon bg-info-subtle text-info">
											<i class="bi bi-paperclip"></i>
										</div>
										<div class="robo-lr-resource-info">
											<div class="robo-lr-resource-title"><?php echo esc_html( $att_title ? $att_title : basename( $att_url ) ); ?></div>
										</div>
										<a href="<?php echo esc_url( $dl_link ); ?>" class="btn btn-sm btn-outline-info rounded-pill px-3">
											<i class="bi bi-download me-1"></i> Download
										</a>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<!-- SECTION 14: EXTERNAL RESOURCES -->
					<?php if ( ! empty( $external_res ) ) : ?>
						<div id="section-external" class="robo-lr-section-block">
							<h3 class="robo-lr-section-title"><i class="bi bi-box-arrow-up-right"></i> External Links & References</h3>
							<?php foreach ( $external_res as $ext ) : ?>
								<div class="robo-lr-resource-card">
									<div class="robo-lr-resource-icon bg-secondary-subtle text-secondary">
										<i class="bi bi-globe"></i>
									</div>
									<div class="robo-lr-resource-info">
										<div class="robo-lr-resource-title"><?php echo esc_html( $ext['title'] ); ?></div>
										<?php if ( ! empty( $ext['description'] ) ) : ?>
											<div class="robo-lr-resource-desc"><?php echo esc_html( $ext['description'] ); ?></div>
										<?php endif; ?>
									</div>
									<a href="<?php echo esc_url( $ext['url'] ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-dark rounded-pill px-3">
										Visit Website <i class="bi bi-arrow-up-right ms-1"></i>
									</a>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- SECTION 15: RELATED PRODUCTS (WooCommerce) -->
					<?php if ( class_exists( 'WooCommerce' ) && ! empty( $related_wc_ids ) ) : ?>
						<div id="section-products" class="robo-lr-section-block">
							<h3 class="robo-lr-section-title"><i class="bi bi-cart-check-fill"></i> Related Hardware & Components</h3>
							<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
								<?php
								$wc_query = new WP_Query( array(
									'post_type'      => 'product',
									'post__in'       => $related_wc_ids,
									'posts_per_page' => -1,
								) );

								if ( $wc_query->have_posts() ) :
									while ( $wc_query->have_posts() ) :
										$wc_query->the_post();
										wc_get_template_part( 'content', 'product' );
									endwhile;
									wp_reset_postdata();
								endif;
								?>
							</div>
						</div>
					<?php endif; ?>


					<!-- SECTION 16: FAQS -->
					<?php if ( ! empty( $faqs ) ) : ?>
						<div class="robo-lr-section-block">
							<h3 class="robo-lr-section-title"><i class="bi bi-question-circle-fill"></i> Frequently Asked Questions</h3>
							<div class="accordion" id="roboLrFaqAccordion">
								<?php foreach ( $faqs as $f_idx => $faq ) : ?>
									<div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
										<h2 class="accordion-header" id="heading-<?php echo esc_attr( $f_idx ); ?>">
											<button class="accordion-button <?php echo 0 !== $f_idx ? 'collapsed' : ''; ?> fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo esc_attr( $f_idx ); ?>" aria-expanded="<?php echo 0 === $f_idx ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo esc_attr( $f_idx ); ?>">
												<?php echo esc_html( $faq['question'] ); ?>
											</button>
										</h2>
										<div id="collapse-<?php echo esc_attr( $f_idx ); ?>" class="accordion-collapse collapse <?php echo 0 === $f_idx ? 'show' : ''; ?>" aria-labelledby="heading-<?php echo esc_attr( $f_idx ); ?>" data-bs-parent="#roboLrFaqAccordion">
											<div class="accordion-body text-secondary">
												<?php echo nl2br( esc_html( $faq['answer'] ) ); ?>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>

					<!-- SECTION 17: CTA SECTION -->
					<div class="card bg-primary text-white border-0 shadow-lg rounded-4 p-4 p-md-5 text-center mb-5">
						<div class="card-body">
							<h2 class="fw-bold mb-3">Ready to Build Your Project?</h2>
							<p class="lead opacity-90 mb-4">Explore more learning resources or check out our complete hardware store for kits and components.</p>
							<div class="d-flex justify-content-center gap-3 flex-wrap">
								<a href="<?php echo esc_url( get_post_type_archive_link( 'learning-resource' ) ); ?>" class="btn btn-light btn-lg rounded-pill px-4 fw-semibold text-primary">Browse All Resources</a>
								<?php if ( class_exists( 'WooCommerce' ) ) : ?>
									<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-semibold">Visit Shop</a>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<!-- Tags Bar -->
					<?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
						<div class="mb-4">
							<span class="fw-semibold me-2 text-muted"><i class="bi bi-tags-fill me-1"></i> Tags:</span>
							<?php foreach ( $tags as $t_item ) : ?>
								<a href="<?php echo esc_url( get_term_link( $t_item ) ); ?>" class="badge bg-secondary-subtle text-secondary border text-decoration-none me-1 px-3 py-2 rounded-pill"><?php echo esc_html( $t_item->name ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- Previous / Next Post Navigation -->
					<div class="row g-3 py-4 border-top">
						<div class="col-6">
							<?php
							$prev_post = get_previous_post();
							if ( $prev_post ) :
								?>
								<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="card h-100 p-3 border-0 shadow-sm text-decoration-none hover-primary">
									<span class="text-muted small mb-1"><i class="bi bi-arrow-left me-1"></i> Previous Resource</span>
									<strong class="text-dark line-clamp-1"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></strong>
								</a>
							<?php endif; ?>
						</div>
						<div class="col-6 text-end">
							<?php
							$next_post = get_next_post();
							if ( $next_post ) :
								?>
								<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="card h-100 p-3 border-0 shadow-sm text-decoration-none text-end hover-primary">
									<span class="text-muted small mb-1">Next Resource <i class="bi bi-arrow-right ms-1"></i></span>
									<strong class="text-dark line-clamp-1"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></strong>
								</a>
							<?php endif; ?>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- RELATED LEARNING RESOURCES SECTION -->
		<div class="bg-light py-5 border-top">
			<div class="container">
				<h3 class="fw-bold mb-4"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i> Related Learning Resources</h3>
				<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
					<?php
					$related_args = array(
						'post_type'      => 'learning-resource',
						'post_status'    => 'publish',
						'posts_per_page' => 3,
						'post__not_in'   => array( $post_id ),
					);

					if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
						$related_args['tax_query'] = array(
							array(
								'taxonomy' => 'learning_category',
								'field'    => 'term_id',
								'terms'    => $categories[0]->term_id,
							),
						);
					}

					$related_query = new WP_Query( $related_args );

					if ( $related_query->have_posts() ) :
						while ( $related_query->have_posts() ) :
							$related_query->the_post();
							get_template_part( 'template-parts/content-learning-resource-card' );
						endwhile;
						wp_reset_postdata();
					else :
						echo '<div class="col-12"><p class="text-muted">No related resources found.</p></div>';
					endif;
					?>
				</div>
			</div>
		</div>

	</article>

<?php
endwhile;

get_footer();
