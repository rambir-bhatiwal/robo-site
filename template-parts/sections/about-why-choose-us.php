<?php
/**
 * Template part for displaying the Why Choose RoboScaler? section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
$section_img     = robo_get_about_image( 'why_choose' );
$why_bg_raw      = get_theme_mod( 'robo_why_choose_us_bg_image', '' );
$why_bg_url      = robo_get_hero_bg_image_url( $why_bg_raw );
$why_bg_style    = ! empty( $why_bg_url ) ? ' style="background-image: url(\'' . esc_url( $why_bg_url ) . '\'); background-repeat: no-repeat; background-position: center center; background-size: cover; background-attachment: scroll;"' : '';
?>
<section class="about-why-choose py-4 my-4 bg-light-subtle border-top border-bottom border-light-subtle overflow-hidden"<?php echo $why_bg_style; ?>>
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row mb-4 text-center justify-content-center">
			<div class="col-lg-8">
				<span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill mb-2 uppercase-tracking-wider"><?php esc_html_e( 'Our Advantage', 'robo' ); ?></span>
				<h2 class="display-6 fw-bold text-dark mb-0"><?php esc_html_e( 'Why Choose RoboScaler?', 'robo' ); ?></h2>
			</div>
		</div>

		<div class="row g-4 mb-4">
			<div class="col-md-6">
				<div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white service-card transition-all">
					<div class="bg-primary-subtle text-primary p-3 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
						<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-award-fill" viewBox="0 0 16 16"><path d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68 1.858-.282z"/><path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1z"/></svg>
					</div>
					<p class="text-secondary fs-5 lh-base mb-0">
						<?php esc_html_e( 'At RoboScaler, we focus on quality, simplicity, and learning. Every product is selected or designed with education in mind, making it easier for students and educators to build projects without unnecessary complexity.', 'robo' ); ?>
					</p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white service-card transition-all">
					<div class="bg-success-subtle text-success p-3 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
						<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-rocket-takeoff-fill" viewBox="0 0 16 16"><path d="M12.17 9.53c2.307-2.592 3.278-4.684 3.641-6.218.21-.887.214-1.58.16-2.065a3.6 3.6 0 0 0-.108-.563 2 2 0 0 0-.078-.23V.453l-.004-.007.002.003h-.002l-.005-.008a2 2 0 0 0-.129-.209A3.6 3.6 0 0 0 14.809.12c-.484-.055-1.177-.05-2.065.16-1.534.363-3.626 1.334-6.218 3.641l-.22.2-.201.22c-2.307 2.592-3.278 4.684-3.641 6.218-.21.887-.214 1.58-.16 2.065a3.6 3.6 0 0 0 .108.563 2 2 0 0 0 .078.23v.003l.004.007-.002-.003h.002l.005.008a2 2 0 0 0 .129.209A3.6 3.6 0 0 0 3.731 15.8c.484.055 1.177.05 2.065-.16 1.534-.363 3.626-1.334 6.218-3.641l.22-.2zM4.5 13a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/></svg>
					</div>
					<p class="text-secondary fs-5 lh-base mb-0">
						<?php esc_html_e( 'We are continuously working to expand our range of robotics kits and educational resources so that learners can keep exploring new technologies and improving their skills.', 'robo' ); ?>
					</p>
				</div>
			</div>
		</div>

		<?php if ( ! empty( $section_img ) ) : ?>
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div class="position-relative p-2">
						<div class="position-absolute top-0 start-0 w-100 h-100 bg-primary-subtle rounded-4 z-0"></div>
						<img src="<?php echo esc_url( $section_img ); ?>" alt="<?php esc_attr_e( 'Why Choose RoboScaler?', 'robo' ); ?>" class="img-fluid rounded-4 shadow-lg position-relative z-1 w-100 object-fit-cover" style="max-height: 320px;" />
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
