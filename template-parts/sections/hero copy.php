<?php
/**
 * Template part for displaying the Hero section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bg_image      = get_theme_mod( 'robo_hero_bg_image' );
$title         = get_theme_mod( 'robo_hero_title', esc_html__( 'Build Smarter Digital Experiences with Robo', 'robo' ) );
$subtitle      = get_theme_mod( 'robo_hero_subtitle', esc_html__( 'Robo is a 100% custom-designed WordPress theme using Bootstrap 5 to launch elegant, clean websites fast.', 'robo' ) );
$btn1_text     = get_theme_mod( 'robo_hero_btn1_text', esc_html__( 'Get Started', 'robo' ) );
$btn1_url      = get_theme_mod( 'robo_hero_btn1_url', '#contact' );
$btn2_text     = get_theme_mod( 'robo_hero_btn2_text', esc_html__( 'Learn More', 'robo' ) );
$btn2_url      = get_theme_mod( 'robo_hero_btn2_url', '#about' );

$hero_style = '';
if ( ! empty( $bg_image ) ) {
	$hero_style = 'style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 27, 75, 0.95) 100%), url(\'' . esc_url( $bg_image ) . '\') no-repeat center center/cover;"';
} else {
	$hero_style = 'style="background: linear-gradient(135deg, #090F1d 0%, #002266 100%);"';
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>
<section id="hero" class="hero-section text-white d-flex align-items-center position-relative py-5 overflow-hidden" <?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<!-- Animated Background Elements -->
	<div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden z-0 opacity-10">
		<div class="spinner-border text-primary position-absolute" style="width: 300px; height: 300px; top: -50px; left: -50px; filter: blur(40px);" role="status"></div>
		<div class="spinner-grow text-info position-absolute" style="width: 250px; height: 250px; bottom: -50px; right: -50px; filter: blur(50px);" role="status"></div>
	</div>

	<div class="<?php echo esc_attr( $container_class ); ?> position-relative z-1 py-5">
		<div class="row align-items-center g-5 py-5">
			
			<!-- Hero Text -->
			<div class="col-lg-7 text-center text-lg-start">
				<span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill text-uppercase fw-semibold mb-3 fs-7 tracking-wider">
					<?php esc_html_e( 'Welcome to Robo Custom Theme', 'robo' ); ?>
				</span>
				
				<h1 class="display-3 fw-bold mb-4 text-white leading-tight">
					<?php echo esc_html( $title ); ?>
				</h1>
				
				<p class="lead text-light text-opacity-75 mb-5 fs-5">
					<?php echo esc_html( $subtitle ); ?>
				</p>
				
				<div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
					<?php if ( ! empty( $btn1_text ) ) : ?>
						<a href="<?php echo esc_url( $btn1_url ); ?>" class="btn btn-primary btn-lg px-4 py-3 fw-semibold shadow-lg">
							<?php echo esc_html( $btn1_text ); ?>
						</a>
					<?php endif; ?>
					<?php if ( ! empty( $btn2_text ) ) : ?>
						<a href="<?php echo esc_url( $btn2_url ); ?>" class="btn btn-outline-light btn-lg px-4 py-3 fw-semibold border-white border-opacity-25">
							<?php echo esc_html( $btn2_text ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<!-- Hero Form or Graphic Mockup -->
			<div class="col-lg-5">
				<div class="hero-graphic-card card bg-white bg-opacity-10 border border-white border-opacity-10 shadow-lg p-4 rounded-4 backdrop-blur">
					<div class="card-body p-2">
						<h3 class="h4 text-white fw-bold mb-3"><?php esc_html_e( 'Request a Free Quote', 'robo' ); ?></h3>
						<p class="text-white-50 small mb-4"><?php esc_html_e( 'Submit your contact information and we\'ll get back to you within 24 hours.', 'robo' ); ?></p>
						
						<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
							<div class="mb-3">
								<input type="text" class="form-control bg-dark bg-opacity-20 border-white border-opacity-10 text-white shadow-none py-2 px-3" placeholder="<?php esc_attr_e( 'Your Name', 'robo' ); ?>" required>
							</div>
							<div class="mb-3">
								<input type="email" class="form-control bg-dark bg-opacity-20 border-white border-opacity-10 text-white shadow-none py-2 px-3" placeholder="<?php esc_attr_e( 'Your Email Address', 'robo' ); ?>" required>
							</div>
							<div class="mb-3">
								<textarea class="form-control bg-dark bg-opacity-20 border-white border-opacity-10 text-white shadow-none py-2 px-3" rows="3" placeholder="<?php esc_attr_e( 'Tell us about your project...', 'robo' ); ?>" required></textarea>
							</div>
							<button type="submit" class="btn btn-primary w-100 py-3 fw-bold"><?php esc_html_e( 'Submit Request', 'robo' ); ?></button>
						</form>
					</div>
				</div>
			</div>

		</div>

		<!-- Statistics Bar -->
		<div class="row pt-5 mt-5 border-top border-white border-opacity-10 g-4 text-center">
			<?php
			for ( $i = 1; $i <= 4; $i++ ) {
				$val = get_theme_mod( "robo_hero_stat{$i}_value" );
				$lbl = get_theme_mod( "robo_hero_stat{$i}_label" );
				if ( ! empty( $val ) || ! empty( $lbl ) ) :
					?>
					<div class="col-6 col-md-3">
						<div class="p-3">
							<h3 class="display-5 fw-extrabold text-primary mb-1"><?php echo esc_html( $val ); ?></h3>
							<p class="text-white-50 small mb-0 uppercase-tracking-wider"><?php echo esc_html( $lbl ); ?></p>
						</div>
					</div>
					<?php
				endif;
			}
			?>
		</div>
	</div>
</section>
