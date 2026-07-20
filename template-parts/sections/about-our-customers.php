<?php
/**
 * Template part for displaying the Our Customers section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
$section_img     = robo_get_about_image( 'customers' );
?>
<section class="about-our-customers my-4 overflow-hidden">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row g-4 align-items-center">
			<div class="col-lg-6">
				<div class="pe-lg-4">
					<span class="badge bg-success-subtle text-success fw-semibold px-3 py-2 rounded-pill mb-2 uppercase-tracking-wider"><?php esc_html_e( 'Who We Serve', 'robo' ); ?></span>
					<h2 class="display-6 fw-bold text-dark mb-3"><?php esc_html_e( 'Our Customers', 'robo' ); ?></h2>
					<div class="card border-0 shadow-sm p-4 bg-white rounded-4 border-start border-success border-4">
						<div class="bg-success-subtle text-success p-3 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
							<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 5"/></svg>
						</div>
						<p class="text-secondary fs-5 lh-lg mb-0">
							<?php esc_html_e( 'We proudly work with schools, colleges, STEM labs, educators, hobbyists, and anyone interested in robotics and electronics. Whether you are building your first robot or working on an advanced project, we are here to support your learning journey.', 'robo' ); ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="position-relative p-2">
					<div class="position-absolute top-0 start-0 w-100 h-100 bg-success-subtle rounded-4 z-0" style="transform: translate(-8px, -8px);"></div>
					<?php if ( ! empty( $section_img ) ) : ?>
						<img src="<?php echo esc_url( $section_img ); ?>" alt="<?php esc_attr_e( 'Our Customers', 'robo' ); ?>" class="img-fluid rounded-4 shadow-lg position-relative z-1 w-100 object-fit-cover" style="min-height: 280px; max-height: 360px;" />
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
