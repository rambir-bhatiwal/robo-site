<?php
/**
 * Template part for displaying the Services section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

$services = array(
	array(
		'title'       => esc_html__( 'Custom Combat Robots', 'robo' ),
		'description' => esc_html__( 'Custom Mini Sumo bots, combat trucks, and autonomous chassis built for high-impact performance.', 'robo' ),
		'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-robot text-primary" viewBox="0 0 16 16"><path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5M3 8.062C3 5.176 5.235 3 8 3s5 2.176 5 5.062c0 .937-.294 1.704-.737 2.22-.44.513-.996.883-1.576 1.134-.143.06-.29.117-.442.172v.917h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1h1v-.917c-.152-.055-.3-.112-.442-.172a6 6 0 0 1-1.576-1.134C3.294 9.766 3 9 3 8.062m5-4.062C5.765 4 4 5.765 4 8c0 .708.204 1.254.502 1.6A2.5 2.5 0 0 0 6.5 11h3a2.5 2.5 0 0 0 1.998-1.4c.298-.346.502-.892.502-1.6 0-2.235-1.765-4-4-4"/></svg>',
	),
	array(
		'title'       => esc_html__( 'FPV Drones & Copters', 'robo' ),
		'description' => esc_html__( 'Aerodynamic racing drone frames, propellers, flight controllers, and telemetry system configurations.', 'robo' ),
		'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-airplane text-primary" viewBox="0 0 16 16"><path d="M6.428 1.151C6.708.591 7.303 0 8 0s1.293.591 1.572 1.151l2.69 5.38 5.6 1.12c.783.157 1.096 1.12.528 1.688l-4.05 4.05 1.026 5.637c.143.784-.683 1.385-1.382.996l-5.006-2.63-5.006 2.63c-.7.39-1.525-.211-1.382-.996l1.026-5.637-4.05-4.05c-.568-.568-.255-1.63.528-1.688l5.6-1.12 2.69-5.38z"/></svg>',
	),
	array(
		'title'       => esc_html__( 'PCB Design & Firmware', 'robo' ),
		'description' => esc_html__( 'Custom micro-controllers, ESP32 layouts, and Arduino/C++ custom navigation coding.', 'robo' ),
		'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cpu text-primary" viewBox="0 0 16 16"><path d="M5 0a.5.5 0 0 1 .5.5V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 .5-.5h.5a.5.5 0 0 1 .5.5v.5h1.5a.5.5 0 0 1 .5.5V3h1.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h.5a.5.5 0 0 1 .5.5v.5a.5.5 0 0 1-.5.5H13v1.5a.5.5 0 0 1-.5.5V13h-1v1.5a.5.5 0 0 1-1 0V13h-1v1.5a.5.5 0 0 1-1 0V13h-1v1.5a.5.5 0 0 1-1 0V13H5v1.5a.5.5 0 0 1-.5.5h-.5a.5.5 0 0 1-.5-.5v-.5H2v-1.5a.5.5 0 0 1-.5-.5V13h-1.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1 0-1H2v-1h-1.5a.5.5 0 0 1 0-1H2v-1h-1.5a.5.5 0 0 1 0-1H2v-1h-1.5a.5.5 0 0 1 0-1H2V5H.5a.5.5 0 0 1-.5-.5v-.5A.5.5 0 0 1 .5 3H2v-1.5A.5.5 0 0 1 2.5 1H3v-.5A.5.5 0 0 1 3.5 0h.5a.5.5 0 0 1 .5.5V2h1V.5A.5.5 0 0 1 5 0m-.5 3 .5.5v9l-.5.5h-9l-.5-.5v-9l.5-.5zM3 4v8h10V4zm1 1h8v6H4z"/></svg>',
	),
	array(
		'title'       => esc_html__( 'High C-Rating Batteries', 'robo' ),
		'description' => esc_html__( 'LiPo cells configured to prevent under-voltage drops during massive burst motor accelerations.', 'robo' ),
		'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-battery-charging text-primary" viewBox="0 0 16 16"><path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7M2 6h10v4H2z"/><path d="M2 4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm10 1a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zm2 3a.5.5 0 0 1 .5-.5h.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-.5a.5.5 0 0 1-.5-.5z"/></svg>',
	),
	array(
		'title'       => esc_html__( 'Spare Parts Supply', 'robo' ),
		'description' => esc_html__( 'Full inventory of micro gearmotors, silicone tires, wheels, chargers, and steel structural brackets.', 'robo' ),
		'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-gear text-primary" viewBox="0 0 16 16"><path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/><path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.893 1.64.902 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.185 1.185l-.16.291a1.873 1.873 0 0 0 1.115 2.693l.319.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.185l-.291-.16a1.873 1.873 0 0 0-2.693 1.115l-.094.319c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.693-1.115l-.291.16c-.764.415-1.6-.42-1.185-1.185l.16-.291a1.873 1.873 0 0 0-1.115-2.693l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094a1.873 1.873 0 0 0 1.115-2.693l-.16-.291c-.415-.764.42-1.6 1.185-1.185l.291.16a1.873 1.873 0 0 0 2.693-1.115z"/></svg>',
	),
	array(
		'title'       => esc_html__( 'STEM Education Kits', 'robo' ),
		'description' => esc_html__( 'Hands-on educational kits for schools and workshops to learn robotics programming and building.', 'robo' ),
		'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-mortarboard text-primary" viewBox="0 0 16 16"><path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.73l1.5-.6a.5.5 0 0 0-.025-.917zM8 8.46 1.758 5.965 8 3.052l6.242 2.913z"/></svg>',
	),
);
?>
<section id="services" class="services-section py-5 bg-light border-top border-bottom border-light-subtle">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		
		<!-- Section Header -->
		<div class="row mb-5 justify-content-center text-center">
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Our Specialization', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-3"><?php esc_html_e( 'Robotics Products & Parts', 'robo' ); ?></h2>
				<p class="text-muted"><?php esc_html_e( 'We provide high-durability components and STEM learning tools engineered to meet competitive robotics standards.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Services Grid -->
		<div class="row g-4">
			<?php foreach ( $services as $service ) : ?>
				<div class="col-lg-4 col-md-6">
					<div class="service-card card h-100 border-0 shadow-sm p-4 text-start transition-all" style="transition: all 0.3s ease-in-out;">
						<div class="service-icon mb-4 d-inline-flex align-items-center justify-content-center bg-primary-subtle p-3 rounded-3" style="width: 60px; height: 60px;">
							<?php echo $service['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<h3 class="h5 fw-bold text-dark mb-3"><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="text-muted small mb-0"><?php echo esc_html( $service['description'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
