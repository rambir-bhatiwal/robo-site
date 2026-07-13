<?php
/**
 * Template part for displaying the About section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>
<section id="about" class="about-section">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		<div class="row align-items-center g-5">
			
			<!-- Left Graphic Column -->
			<div class="col-lg-6 position-relative">
				<div class="about-image-wrapper p-3 position-relative">
					
					<!-- Background decorative frame -->
					<div class="position-absolute top-0 start-0 w-75 h-75 bg-primary-subtle rounded-3 z-0" style="transform: translate(-15px, -15px);"></div>
					
					<!-- Main Mockup Card -->
					<div class="card border-0 shadow-lg overflow-hidden position-relative z-1 mb-4">
						<div class="card-header bg-dark text-white d-flex align-items-center gap-2 py-3 px-4">
							<span class="d-inline-block bg-danger rounded-circle" style="width: 10px; height: 10px;"></span>
							<span class="d-inline-block bg-warning rounded-circle" style="width: 10px; height: 10px;"></span>
							<span class="d-inline-block bg-success rounded-circle" style="width: 10px; height: 10px;"></span>
							<span class="text-white-50 small ms-2"><?php esc_html_e( 'mini-sumo-firmware.ino', 'robo' ); ?></span>
						</div>
						<div class="card-body bg-dark text-light p-4 font-monospace small" style="min-height: 250px;">
							<p class="text-success mb-1"><?php esc_html_e( '#include <SumoCombat.h>', 'robo' ); ?></p>
							<p class="text-muted mb-3"><?php esc_html_e( '// Initializing ultrasonic sensors & motor drivers...', 'robo' ); ?></p>
							<p class="text-info mb-1"><?php esc_html_e( '> Calibrating IR Line Trackers [OK]', 'robo' ); ?></p>
							<p class="text-info mb-1"><?php esc_html_e( '> Testing brushless ESC throttle [OK]', 'robo' ); ?></p>
							<p class="text-info mb-3"><?php esc_html_e( '> Loading autonomous search loop...', 'robo' ); ?></p>
							<p class="text-success mb-0"><?php esc_html_e( '✓ SumoBot Firmware uploaded successfully!', 'robo' ); ?></p>
						</div>
					</div>

					<!-- Secondary Mockup Card -->
					<div class="card border-0 shadow position-absolute bottom-0 end-0 bg-white p-3 z-2 d-none d-sm-block w-50" style="transform: translate(20px, 20px);">
						<div class="d-flex align-items-center gap-3">
							<div class="bg-primary text-white p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-robot" viewBox="0 0 16 16"><path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5M3 8.062C3 5.176 5.235 3 8 3s5 2.176 5 5.062c0 .937-.294 1.704-.737 2.22-.44.513-.996.883-1.576 1.134-.143.06-.29.117-.442.172v.917h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1h1v-.917c-.152-.055-.3-.112-.442-.172a6 6 0 0 1-1.576-1.134C3.294 9.766 3 9 3 8.062m5-4.062C5.765 4 4 5.765 4 8c0 .708.204 1.254.502 1.6A2.5 2.5 0 0 0 6.5 11h3a2.5 2.5 0 0 0 1.998-1.4c.298-.346.502-.892.502-1.6 0-2.235-1.765-4-4-4"/></svg>
							</div>
							<div>
								<h5 class="fw-bold mb-0 text-dark"><?php esc_html_e( 'STEM Focus', 'robo' ); ?></h5>
								<p class="mb-0 text-muted small"><?php esc_html_e( 'Robotics Engineering', 'robo' ); ?></p>
							</div>
						</div>
					</div>

				</div>
			</div>

			<!-- Right Content Column -->
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Who We Are', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-4"><?php esc_html_e( 'Pioneering STEM & Professional Combat Robotics', 'robo' ); ?></h2>
				<p class="text-muted fs-6 mb-4">
					<?php esc_html_e( 'We design and sell high-performance robotics kits, custom electronic circuit boards, and battery solutions. From mini sumo robots and high-speed drones to combat trucks and replacement parts, our hardware is engineered for durability, speed, and precision control.', 'robo' ); ?>
				</p>
				
				<!-- Checklist -->
				<ul class="list-unstyled mb-4">
					<li class="d-flex align-items-start gap-2 mb-3">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill text-primary mt-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
						<div>
							<h5 class="fw-bold text-dark mb-1"><?php esc_html_e( 'Competition-Grade Boards & Sensors', 'robo' ); ?></h5>
							<p class="text-muted small mb-0"><?php esc_html_e( 'High-reliability ESP32/STM32 control boards, infrared distance sensors, and high-frequency motor drivers.', 'robo' ); ?></p>
						</div>
					</li>
					<li class="d-flex align-items-start gap-2 mb-3">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill text-primary mt-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
						<div>
							<h5 class="fw-bold text-dark mb-1"><?php esc_html_e( 'High-Energy Density Batteries', 'robo' ); ?></h5>
							<p class="text-muted small mb-0"><?php esc_html_e( 'LiPo battery cells with high C-ratings designed specifically to handle extreme current draws during combat matches.', 'robo' ); ?></p>
						</div>
					</li>
				</ul>

				<?php
				$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
				?>
				<a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-primary px-4 py-2 fw-bold"><?php esc_html_e( 'Browse Our Shop', 'robo' ); ?></a>
			</div>
		</div>
	</div>
</section>