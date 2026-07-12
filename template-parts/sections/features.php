<?php
/**
 * Template part for displaying the Features section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

$features = array(
	array(
		'title'       => esc_html__( 'High-Torque Motors', 'robo' ),
		'description' => esc_html__( 'Micro-metal gearmotors and high-performance brushless motor solutions.', 'robo' ),
		'icon_class'  => 'bi-gear-fill',
	),
	array(
		'title'       => esc_html__( 'Robust Controller Boards', 'robo' ),
		'description' => esc_html__( 'ESP32 development boards, dual motor drivers, and telemetry circuits.', 'robo' ),
		'icon_class'  => 'bi-cpu',
	),
	array(
		'title'       => esc_html__( 'LiPo Battery Power', 'robo' ),
		'description' => esc_html__( 'High discharge C-rating lithium-polymer batteries for robot combat.', 'robo' ),
		'icon_class'  => 'bi-lightning-charge-fill',
	),
	array(
		'title'       => esc_html__( 'Precision Sensors', 'robo' ),
		'description' => esc_html__( 'Infrared distance sensors, ultrasonic modules, and line trackers.', 'robo' ),
		'icon_class'  => 'bi-radar',
	),
);
?>
<section id="features" class="features-section py-5 my-5">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		<div class="row align-items-center g-5">
			
			<!-- Left features checklist -->
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Engineering Specifications', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-4"><?php esc_html_e( 'Competition-Grade Robotics & Parts Shop', 'robo' ); ?></h2>
				<p class="text-muted mb-5"><?php esc_html_e( 'Our gear is designed to withstand intense conditions in combat arenas and drone flights. We provide pre-tested, high-reliability boards and parts that integrate flawlessly.', 'robo' ); ?></p>
				
				<div class="row g-4">
					<?php foreach ( $features as $feat ) : ?>
						<div class="col-sm-6">
							<div class="d-flex align-items-start gap-3">
								<div class="text-primary mt-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/></svg>
								</div>
								<div>
									<h4 class="h6 fw-bold text-dark mb-1"><?php echo esc_html( $feat['title'] ); ?></h4>
									<p class="text-muted small mb-0"><?php echo esc_html( $feat['description'] ); ?></p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Right Graphic Card Column -->
			<div class="col-lg-6">
				<div class="card border-0 shadow-lg p-5 bg-primary text-white position-relative overflow-hidden rounded-4">
					<div class="position-absolute top-0 end-0 opacity-10" style="transform: translate(30%, -30%);">
						<svg xmlns="http://www.w3.org/2000/svg" width="350" height="350" fill="currentColor" class="bi bi-cpu" viewBox="0 0 16 16"><path d="M5 0a.5.5 0 0 1 .5.5V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 .5-.5h.5a.5.5 0 0 1 .5.5v.5h1.5a.5.5 0 0 1 .5.5V3h1.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h.5a.5.5 0 0 1 .5.5v.5a.5.5 0 0 1-.5.5H13v1.5a.5.5 0 0 1-.5.5V13h-1v1.5a.5.5 0 0 1-1 0V13h-1v1.5a.5.5 0 0 1-1 0V13h-1v1.5a.5.5 0 0 1-1 0V13H5v1.5a.5.5 0 0 1-.5.5h-.5a.5.5 0 0 1-.5-.5v-.5H2v-1.5a.5.5 0 0 1-.5-.5V13h-1.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1 0-1H2v-1h-1.5a.5.5 0 0 1 0-1H2v-1h-1.5a.5.5 0 0 1 0-1H2v-1h-1.5a.5.5 0 0 1 0-1H2V5H.5a.5.5 0 0 1-.5-.5v-.5A.5.5 0 0 1 .5 3H2v-1.5A.5.5 0 0 1 2.5 1H3v-.5A.5.5 0 0 1 3.5 0h.5a.5.5 0 0 1 .5.5V2h1V.5a.5.5 0 0 1 5 0m-.5 3 .5.5v9l-.5.5h-9l-.5-.5v-9l.5-.5zM3 4v8h10V4zm1 1h8v6H4z"/></svg>
					</div>
					<div class="card-body position-relative z-1 p-2">
						<h3 class="h3 fw-bold text-white mb-3"><?php esc_html_e( 'Robotics Hardware Standards', 'robo' ); ?></h3>
						<p class="text-white-50 fs-6 mb-4"><?php esc_html_e( 'We carry parts built to standard specifications. Our custom sumobot kits, motors, and batteries undergo strict quality control to guarantee performance in critical situations.', 'robo' ); ?></p>
						<div class="d-flex align-items-center gap-3">
							<div class="border-end border-white border-opacity-25 pe-4">
								<h4 class="fw-bold mb-0 text-white"><?php esc_html_e( '100%', 'robo' ); ?></h4>
								<span class="small text-white-50"><?php esc_html_e( 'Combat Tested', 'robo' ); ?></span>
							</div>
							<div class="pe-4">
								<h4 class="fw-bold mb-0 text-white"><?php esc_html_e( 'A+ Grade', 'robo' ); ?></h4>
								<span class="small text-white-50"><?php esc_html_e( 'Battery Cells', 'robo' ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>
