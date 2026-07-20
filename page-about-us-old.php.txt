<?php
/**
 * Template Name: About Us Page
 * The template for displaying the About Us page by slug or selection.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// die('sadf');
get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>


<div class="about-page-wrapper bg-light-subtle pb-5">
	<!-- Hero Section -->
	<section class="about-hero bg-dark text-white py-5 text-center position-relative overflow-hidden mb-5">
		<div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 bg-grid" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 20px 20px;"></div>
		<div class="<?php echo esc_attr( $container_class ); ?> position-relative z-1 py-4">
			<h1 class="display-4 fw-extrabold text-white mb-2"><?php the_title(); ?></h1>
			<p class="lead text-white-50 max-width-600 mx-auto mb-0"><?php esc_html_e( 'Pioneering STEM & Professional Combat Robotics solutions.', 'robo' ); ?></p>
		</div>
	</section>

	<!-- About RoboScaler / Our Story -->
	<section class="about-story mb-5">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row g-5 align-items-center">
				<div class="col-lg-6">
					<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'About RoboScaler', 'robo' ); ?></span>
					<h2 class="h1 fw-bold text-dark mb-4"><?php esc_html_e( 'The Leader in Combat Robotics Engineering', 'robo' ); ?></h2>
					<div class="about-story-text text-muted mb-4 fs-6 lh-lg">
						<?php
						if ( have_posts() ) {
							while ( have_posts() ) {
								the_post();
								$content = get_the_content();
								if ( ! empty( $content ) ) {
									the_content();
								} else {
									?>
									<p><?php esc_html_e( 'Founded by robotics engineers and STEM educators, RoboScaler was created with a single goal: to make competitive, high-performance combat robotics and drone technology accessible to everyone.', 'robo' ); ?></p>
									<p><?php esc_html_e( 'We design and build competition-grade hardware, including mini sumo chassis, high-discharge LiPo battery cells, and high-frequency motor ESC controllers. Our team is dedicated to supporting robotics hubs, classrooms, and arena combatants with durable components that survive the toughest battle criteria.', 'robo' ); ?></p>
									<?php
								}
							}
						}
						?>
					</div>
					<ul class="list-unstyled mb-0 d-flex flex-column gap-3">
						<li class="d-flex align-items-start gap-2">
							<i class="bi bi-shield-check-fill text-primary fs-5 mt-1"></i>
							<div>
								<h6 class="fw-bold text-dark mb-1"><?php esc_html_e( 'Competition Tested', 'robo' ); ?></h6>
								<p class="text-muted small mb-0"><?php esc_html_e( 'Our products are tested in arenas around the world to ensure maximum impact resistance and electrical reliability.', 'robo' ); ?></p>
							</div>
						</li>
						<li class="d-flex align-items-start gap-2">
							<i class="bi bi-cpu-fill text-primary fs-5 mt-1"></i>
							<div>
								<h6 class="fw-bold text-dark mb-1"><?php esc_html_e( 'Tailored Firmware & Integrations', 'robo' ); ?></h6>
								<p class="text-muted small mb-0"><?php esc_html_e( 'Full board kits enqueued with baseline controller codes to streamline code uploading.', 'robo' ); ?></p>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-lg-6">
					<div class="about-image-wrapper p-3 position-relative">
						<!-- Background decorative frame -->
						<div class="position-absolute top-0 start-0 w-75 h-75 bg-primary-subtle rounded-3 z-0" style="transform: translate(-15px, -15px);"></div>
						
						<!-- Mockup Card -->
						<div class="card border-0 shadow-lg overflow-hidden position-relative z-1 mb-4">
							<div class="card-header bg-dark text-white d-flex align-items-center gap-2 py-3 px-4">
								<span class="d-inline-block bg-danger rounded-circle" style="width: 10px; height: 10px;"></span>
								<span class="d-inline-block bg-warning rounded-circle" style="width: 10px; height: 10px;"></span>
								<span class="d-inline-block bg-success rounded-circle" style="width: 10px; height: 10px;"></span>
								<span class="text-white-50 small ms-2"><?php esc_html_e( 'sumo-search-algorithm.cpp', 'robo' ); ?></span>
							</div>
							<div class="card-body bg-dark text-light p-4 font-monospace small" style="min-height: 220px;">
								<p class="text-success mb-1"><?php esc_html_e( '#include <RoboScalerSumo.h>', 'robo' ); ?></p>
								<p class="text-muted mb-2"><?php esc_html_e( '// Scanning for target using LiDAR sensors...', 'robo' ); ?></p>
								<p class="text-info mb-1"><?php esc_html_e( 'void loop() {', 'robo' ); ?></p>
								<p class="text-info mb-1">&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_html_e( 'if (detectEnemy()) { engageTurboMotors(); }', 'robo' ); ?></p>
								<p class="text-info mb-1">&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_html_e( 'else { scanArenaQuarterTracks(); }', 'robo' ); ?></p>
								<p class="text-info mb-2"><?php esc_html_e( '}', 'robo' ); ?></p>
								<p class="text-success mb-0"><?php esc_html_e( '✓ Target Engaged - High Current ESC active.', 'robo' ); ?></p>
							</div>
						</div>

						<!-- Mini Badge Overlay -->
						<div class="card border-0 shadow position-absolute bottom-0 end-0 bg-white p-3 z-2 d-none d-sm-block w-50" style="transform: translate(15px, 15px);">
							<div class="d-flex align-items-center gap-3">
								<div class="bg-primary text-white p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
									<i class="bi bi-robot fs-5"></i>
								</div>
								<div>
									<h6 class="fw-bold mb-0 text-dark"><?php esc_html_e( 'SumoBot Elite', 'robo' ); ?></h6>
									<p class="mb-0 text-muted small" style="font-size: 0.75rem;"><?php esc_html_e( 'Ready to Fight', 'robo' ); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Mission & Vision -->
	<section class="mission-vision py-5 bg-light border-top border-bottom border-light-subtle mb-5">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row g-4">
				<div class="col-md-6">
					<div class="card border-0 shadow-sm p-4 h-100 bg-white">
						<div class="icon-box text-primary mb-3 bg-primary-subtle rounded-3 p-3 d-inline-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
							<i class="bi bi-rocket-takeoff-fill fs-4"></i>
						</div>
						<h3 class="h4 fw-bold text-dark mb-3"><?php esc_html_e( 'Our Mission', 'robo' ); ?></h3>
						<p class="text-muted mb-0 lh-lg"><?php esc_html_e( 'To accelerate robotics innovation by manufacturing resilient hardware and comprehensive building kits, allowing students, educators, and combatants to learn coding, design, and competitive combat kinematics without hardware bottlenecks.', 'robo' ); ?></p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card border-0 shadow-sm p-4 h-100 bg-white">
						<div class="icon-box text-success mb-3 bg-success-subtle rounded-3 p-3 d-inline-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
							<i class="bi bi-eye-fill fs-4"></i>
						</div>
						<h3 class="h4 fw-bold text-dark mb-3"><?php esc_html_e( 'Our Vision', 'robo' ); ?></h3>
						<p class="text-muted mb-0 lh-lg"><?php esc_html_e( 'To build a global STEM network where hands-on engineering, autonomous coding, and competitive combat robotics cultivate critical thinking and problem-solving skills for the next generation of industrial automation innovators.', 'robo' ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Why Choose Us & Core Values -->
	<section class="why-choose-us mb-5 py-3">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row mb-5 text-center justify-content-center">
				<div class="col-lg-6">
					<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Why Choose Us', 'robo' ); ?></span>
					<h2 class="h1 fw-bold text-dark"><?php esc_html_e( 'Resilience and Precision Engineered', 'robo' ); ?></h2>
				</div>
			</div>
			<div class="row g-4 mb-5">
				<div class="col-md-4">
					<div class="card border-light-subtle h-100 p-4 text-center shadow-sm hover-up">
						<div class="bg-primary-subtle text-primary rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 56px; height: 56px;">
							<i class="bi bi-shield-fill-check fs-4"></i>
						</div>
						<h5 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Industrial Quality', 'robo' ); ?></h5>
						<p class="text-muted small mb-0"><?php esc_html_e( 'SumoBot steel frames, CNC carbon fibers, and high-frequency controllers are made to handle extreme impacts.', 'robo' ); ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card border-light-subtle h-100 p-4 text-center shadow-sm hover-up">
						<div class="bg-success-subtle text-success rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 56px; height: 56px;">
							<i class="bi bi-lightning-charge-fill fs-4"></i>
						</div>
						<h5 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Extreme Performance', 'robo' ); ?></h5>
						<p class="text-muted small mb-0"><?php esc_html_e( 'LiPo batteries with 80C+ burst ratings ensure under-voltage drops never disconnect your microcontrollers.', 'robo' ); ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card border-light-subtle h-100 p-4 text-center shadow-sm hover-up">
						<div class="bg-info-subtle text-info rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 56px; height: 56px;">
							<i class="bi bi-patch-check-fill fs-4"></i>
						</div>
						<h5 class="fw-bold text-dark mb-2"><?php esc_html_e( 'STEM Learning Centered', 'robo' ); ?></h5>
						<p class="text-muted small mb-0"><?php esc_html_e( 'Comprehensive kits complete with schemas, component checklists, and firmware libraries ready to upload.', 'robo' ); ?></p>
					</div>
				</div>
			</div>

			<!-- Core Values -->
			<div class="row g-4 mt-2">
				<div class="col-md-3 col-sm-6">
					<div class="p-3 border-start border-primary border-3 bg-white shadow-sm rounded">
						<h6 class="fw-bold text-dark mb-1"><?php esc_html_e( 'Innovation', 'robo' ); ?></h6>
						<p class="text-muted small mb-0"><?php esc_html_e( 'Pushing boundaries in FPV and robotics controls.', 'robo' ); ?></p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="p-3 border-start border-success border-3 bg-white shadow-sm rounded">
						<h6 class="fw-bold text-dark mb-1"><?php esc_html_e( 'Durability', 'robo' ); ?></h6>
						<p class="text-muted small mb-0"><?php esc_html_e( 'High grade steel and premium LiPo safety cells.', 'robo' ); ?></p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="p-3 border-start border-warning border-3 bg-white shadow-sm rounded">
						<h6 class="fw-bold text-dark mb-1"><?php esc_html_e( 'Education', 'robo' ); ?></h6>
						<p class="text-muted small mb-0"><?php esc_html_e( 'Supplying schools with STEM-aligned projects.', 'robo' ); ?></p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="p-3 border-start border-info border-3 bg-white shadow-sm rounded">
						<h6 class="fw-bold text-dark mb-1"><?php esc_html_e( 'Community', 'robo' ); ?></h6>
						<p class="text-muted small mb-0"><?php esc_html_e( 'Supporting sumo robot and drone race teams.', 'robo' ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Statistics Counter (Load section dynamically) -->
	<?php get_template_part( 'template-parts/sections/counter' ); ?>

	<!-- Services (Load section dynamically) -->
	<?php get_template_part( 'template-parts/sections/services' ); ?>

	<!-- CTA Section -->
	<section class="about-cta py-5 mt-5">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="card border-0 shadow-lg text-white p-5 text-center position-relative overflow-hidden rounded-4" style="background: linear-gradient(135deg, #0052FF 0%, #090F1d 100%) !important;">
				<div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 bg-grid" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 15px 15px;"></div>
				<div class="position-relative z-1 py-3">
					<h2 class="h1 fw-bold text-white mb-3"><?php esc_html_e( 'Ready to Build Your Custom Combat Sumo?', 'robo' ); ?></h2>
					<p class="lead text-white-50 max-width-600 mx-auto mb-4"><?php esc_html_e( 'Explore our range of controller boards, high C-rating battery cells, distance sensors, and chassis frames.', 'robo' ); ?></p>
					<?php
					$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
					?>
					<a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm transition-all" style="background: #FFC84A !important; border: none !important; color: #16244B !important;"><?php esc_html_e( 'Shop All Hardware', 'robo' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<!-- Newsletter Section (Load section dynamically) -->
	<?php get_template_part( 'template-parts/sections/newsletter' ); ?>
</div>

<?php
get_footer();
