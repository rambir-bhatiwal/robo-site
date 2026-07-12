<?php
/**
 * Template part for displaying the Pricing section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

$pricing_plans = array(
	array(
		'title'      => esc_html__( 'STEM Starter Kit', 'robo' ),
		'price'      => '49',
		'period'     => esc_html__( ' / kit', 'robo' ),
		'desc'       => esc_html__( 'Perfect entry-level kit for students and individual builders.', 'robo' ),
		'features'   => array(
			esc_html__( '1x SumoBot Steel Chassis', 'robo' ),
			esc_html__( '2x Micro Metal Gearmotors', 'robo' ),
			esc_html__( '1x Nano Control Board', 'robo' ),
			esc_html__( '2x IR Line Tracking Sensors', 'robo' ),
		),
		'btn_text'   => esc_html__( 'Get Starter Kit', 'robo' ),
		'btn_class'  => 'btn-outline-primary',
		'featured'   => false,
	),
	array(
		'title'      => esc_html__( 'Combat Pro Kit', 'robo' ),
		'price'      => '99',
		'period'     => esc_html__( ' / kit', 'robo' ),
		'desc'       => esc_html__( 'Best package for competitive robotics tournaments.', 'robo' ),
		'features'   => array(
			esc_html__( '1x Aluminum Combat Chassis', 'robo' ),
			esc_html__( '4x High-Torque 1000RPM Motors', 'robo' ),
			esc_html__( '1x ESP32 Wi-Fi Controller', 'robo' ),
			esc_html__( '4x Ultrasonic Distance Arrays', 'robo' ),
		),
		'btn_text'   => esc_html__( 'Get Combat Pro Kit', 'robo' ),
		'btn_class'  => 'btn-primary shadow',
		'featured'   => true,
	),
	array(
		'title'      => esc_html__( 'Custom Drone Kit', 'robo' ),
		'price'      => '199',
		'period'     => esc_html__( ' / kit', 'robo' ),
		'desc'       => esc_html__( 'Full high-speed brushless quadcopter parts build.', 'robo' ),
		'features'   => array(
			esc_html__( '1x Carbon Fiber Quad Frame', 'robo' ),
			esc_html__( '4x Brushless Motors + ESCs', 'robo' ),
			esc_html__( '1x FPV Telemetry Controller', 'robo' ),
			esc_html__( '1x STM32 Autopilot Board', 'robo' ),
		),
		'btn_text'   => esc_html__( 'Get Drone Kit', 'robo' ),
		'btn_class'  => 'btn-outline-primary',
		'featured'   => false,
	),
);
?>
<section id="pricing" class="pricing-section py-5 my-5">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		
		<!-- Section Header -->
		<div class="row mb-5 justify-content-center text-center">
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Parts Bundles', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-3"><?php esc_html_e( 'Robotics Build Kits', 'robo' ); ?></h2>
				<p class="text-muted"><?php esc_html_e( 'Pick a pre-configured kit with matched parts to jump-start your project. Perfect for classrooms and competitions.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Pricing Grid -->
		<div class="row g-4 align-items-center">
			<?php foreach ( $pricing_plans as $plan ) : ?>
				<div class="col-lg-4 col-md-6">
					<div class="pricing-card card h-100 border-0 p-4 rounded-4 <?php echo $plan['featured'] ? 'shadow-lg border-primary border-top border-5 position-relative z-1' : 'shadow-sm'; ?>">
						
						<?php if ( $plan['featured'] ) : ?>
							<span class="badge bg-primary text-white position-absolute top-0 end-0 m-4 text-uppercase fw-bold px-3 py-1 fs-8">
								<?php esc_html_e( 'Most Popular', 'robo' ); ?>
							</span>
						<?php endif; ?>

						<div class="card-body">
							<h3 class="h5 fw-bold text-dark mb-2"><?php echo esc_html( $plan['title'] ); ?></h3>
							<p class="text-muted small mb-4"><?php echo esc_html( $plan['desc'] ); ?></p>
							
							<!-- Price -->
							<div class="price-wrapper d-flex align-items-baseline mb-4">
								<span class="h4 text-dark fw-bold mb-0"><?php esc_html_e( '$', 'robo' ); ?></span>
								<span class="display-4 text-dark fw-extrabold mb-0 leading-none"><?php echo esc_html( $plan['price'] ); ?></span>
								<span class="text-muted small ms-1"><?php echo esc_html( $plan['period'] ); ?></span>
							</div>

							<!-- Features List -->
							<ul class="list-unstyled mb-5 border-top border-light-subtle pt-4">
								<?php foreach ( $plan['features'] as $feat ) : ?>
									<li class="d-flex align-items-center gap-2 mb-3 small text-muted">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check text-primary" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/></svg>
										<span><?php echo esc_html( $feat ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>

							<!-- Call to Action -->
							<a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>" class="btn w-100 py-3 fw-bold <?php echo esc_attr( $plan['btn_class'] ); ?>">
								<?php echo esc_html( $plan['btn_text'] ); ?>
							</a>
						</div>

					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
