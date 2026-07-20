<?php
/**
 * Template part for displaying the About Us Hero & Welcome Introduction section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
$hero_img        = robo_get_about_image( 'hero' );
$intro_img       = robo_get_about_image( 'intro' );
?>
<!-- Hero Banner -->
<section class="about-hero-section hero-section text-white py-4 position-relative overflow-hidden mb-3" style="background: radial-gradient(circle at top right, rgba(123,47,247,.30) 0%, transparent 35%), radial-gradient(circle at bottom left, rgba(255,77,48,.22) 0%, transparent 35%), linear-gradient(135deg,#12052E 0%,#22114B 45%,#341A73 100%);">
	<div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 bg-grid" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 20px 20px;"></div>
	<div class="<?php echo esc_attr( $container_class ); ?> position-relative z-1 py-3">
		<div class="row align-items-center g-4">
			<div class="col-lg-7">
				<span class="hero-badge badge bg-white bg-opacity-10 text-white fw-semibold px-3 py-2 rounded-pill mb-2 uppercase-tracking-wider">🤖 <?php esc_html_e( 'Who We Are', 'robo' ); ?></span>
				<h1 class="display-4 fw-extrabold text-white mb-2"><?php esc_html_e( 'About Us', 'robo' ); ?></h1>
				<p class="lead text-white-50 max-width-600 mb-0"><?php esc_html_e( 'Practical, affordable, and enjoyable robotics & STEM learning for everyone.', 'robo' ); ?></p>
			</div>
			<?php if ( ! empty( $hero_img ) ) : ?>
				<div class="col-lg-5 d-none d-lg-block text-center text-lg-end">
					<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php esc_attr_e( 'About RoboScaler', 'robo' ); ?>" class="img-fluid rounded-4 shadow-lg border border-white border-opacity-25 object-fit-cover" style="max-height: 240px; width: 100%;" />
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Breadcrumbs Below Hero Section -->
<?php if ( function_exists( 'robo_breadcrumbs' ) ) : ?>
	<div class="<?php echo esc_attr( $container_class ); ?> mb-3">
		<?php robo_breadcrumbs(); ?>
	</div>
<?php endif; ?>

<!-- Welcome Section -->
<section class="about-welcome-section my-4 overflow-hidden">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row g-4 align-items-center">
			<div class="col-lg-6">
				<div class="pe-lg-3">
					<p class="lead fw-semibold text-primary mb-2 fs-4">
						<?php esc_html_e( 'Welcome to', 'robo' ); ?> <strong><?php esc_html_e( 'RoboScaler', 'robo' ); ?></strong>.
					</p>
					<p class="text-secondary fs-5 lh-base mb-3">
						<?php esc_html_e( "RoboScaler was started with a simple goal—to make robotics and STEM learning practical, affordable, and enjoyable for everyone. We believe that the best way to learn is by building things with your own hands. That's why we create robotics kits that help students understand concepts through real projects instead of only reading about them.", 'robo' ); ?>
					</p>
					<p class="text-secondary fs-5 lh-base mb-0">
						<?php esc_html_e( "Whether you're a school student, college student, teacher, or someone who enjoys building electronics projects, RoboScaler offers products and learning resources to help you get started and continue growing.", 'robo' ); ?>
					</p>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="position-relative p-2">
					<div class="position-absolute top-0 start-0 w-100 h-100 bg-primary-subtle rounded-4 z-0" style="transform: translate(-8px, -8px);"></div>
					<?php if ( ! empty( $intro_img ) ) : ?>
						<img src="<?php echo esc_url( $intro_img ); ?>" alt="<?php esc_attr_e( 'Welcome to RoboScaler', 'robo' ); ?>" class="img-fluid rounded-4 shadow-lg position-relative z-1 w-100 object-fit-cover" style="min-height: 300px; max-height: 380px;" />
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
