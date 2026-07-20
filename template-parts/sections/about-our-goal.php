<?php
/**
 * Template part for displaying the Our Goal section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
$section_img     = robo_get_about_image( 'our_goal' );
?>
<section class="about-our-goal my-4 overflow-hidden">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row g-4 align-items-center">
			<div class="col-lg-6">
				<div class="pe-lg-4">
					<span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill mb-2 uppercase-tracking-wider"><?php esc_html_e( 'Our Purpose', 'robo' ); ?></span>
					<h2 class="display-6 fw-bold text-dark mb-3"><?php esc_html_e( 'Our Goal', 'robo' ); ?></h2>
					<div class="card border-0 shadow-sm p-4 bg-white rounded-4 border-start border-primary border-4">
						<div class="bg-primary-subtle text-primary p-3 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
							<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-bullseye" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10m0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12"/><path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8"/><path d="M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/></svg>
						</div>
						<p class="text-secondary fs-5 lh-lg mb-0">
							<?php esc_html_e( 'Our goal is to encourage students to explore science, technology, engineering, and mathematics through practical learning. We want learners to develop problem-solving skills, creativity, and confidence by building real projects instead of simply following theory.', 'robo' ); ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="position-relative p-2">
					<div class="position-absolute top-0 start-0 w-100 h-100 bg-primary-subtle rounded-4 z-0" style="transform: translate(-8px, -8px);"></div>
					<?php if ( ! empty( $section_img ) ) : ?>
						<img src="<?php echo esc_url( $section_img ); ?>" alt="<?php esc_attr_e( 'Our Goal', 'robo' ); ?>" class="img-fluid rounded-4 shadow-lg position-relative z-1 w-100 object-fit-cover" style="min-height: 280px; max-height: 360px;" />
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
