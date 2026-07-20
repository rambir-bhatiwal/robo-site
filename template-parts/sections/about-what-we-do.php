<?php
/**
 * Template part for displaying the What We Do section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
$section_img     = robo_get_about_image( 'what_we_do' );
?>
<section class="about-what-we-do py-4 my-4 bg-light-subtle border-top border-bottom border-light-subtle overflow-hidden">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row g-4 align-items-center flex-lg-row-reverse">
			<div class="col-lg-6">
				<div class="ps-lg-4">
					<span class="badge bg-secondary-subtle text-secondary fw-semibold px-3 py-2 rounded-pill mb-2 uppercase-tracking-wider"><?php esc_html_e( 'Our Offerings', 'robo' ); ?></span>
					<h2 class="display-6 fw-bold text-dark mb-3"><?php esc_html_e( 'What We Do', 'robo' ); ?></h2>
					<p class="text-secondary fs-5 lh-base mb-3">
						<?php esc_html_e( 'We design and supply STEM robotics kits, electronic components, sensors, development boards, and accessories for learning and building robotics projects. Our kits are suitable for classrooms, STEM labs, workshops, competitions, and personal learning.', 'robo' ); ?>
					</p>
					<p class="text-secondary fs-5 lh-base mb-0">
						<?php esc_html_e( 'Along with our products, we provide step-by-step guides, programming examples, and project resources so that anyone can build and understand how their robot works.', 'robo' ); ?>
					</p>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="position-relative p-2">
					<div class="position-absolute top-0 start-0 w-100 h-100 bg-primary-subtle rounded-4 z-0" style="transform: translate(8px, 8px);"></div>
					<?php if ( ! empty( $section_img ) ) : ?>
						<img src="<?php echo esc_url( $section_img ); ?>" alt="<?php esc_attr_e( 'What We Do', 'robo' ); ?>" class="img-fluid rounded-4 shadow-lg position-relative z-1 w-100 object-fit-cover" style="min-height: 300px; max-height: 380px;" />
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
