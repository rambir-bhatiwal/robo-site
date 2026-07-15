<?php
/**
 * Template part for displaying the Portfolio section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

$portfolio_items = array(
	array(
		'title'    => esc_html__( 'Autonomous Mini Sumo V2', 'robo' ),
		'category' => esc_html__( 'Sumo Bot', 'robo' ),
		'bg_color' => 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)',
	),
	array(
		'title'    => esc_html__( 'Brushless FPV Racing Quad', 'robo' ),
		'category' => esc_html__( 'FPV Drone', 'robo' ),
		'bg_color' => 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%)',
	),
	array(
		'title'    => esc_html__( 'RC Heavy Cargo Truck', 'robo' ),
		'category' => esc_html__( 'Robo Truck', 'robo' ),
		'bg_color' => 'linear-gradient(135deg, #090d16 0%, #1e293b 100%)',
	),
	array(
		'title'    => esc_html__( 'STM32 Bluetooth Controller', 'robo' ),
		'category' => esc_html__( 'PCB Design', 'robo' ),
		'bg_color' => 'linear-gradient(135deg, #13547a 0%, #80d0c7 100%)',
	),
	array(
		'title'    => esc_html__( 'High-Discharge LiPo Charger', 'robo' ),
		'category' => esc_html__( 'Power Systems', 'robo' ),
		'bg_color' => 'linear-gradient(135deg, #b45309 0%, #78350f 100%)',
	),
	array(
		'title'    => esc_html__( 'IR Distance Array Shield', 'robo' ),
		'category' => esc_html__( 'Sensor Shield', 'robo' ),
		'bg_color' => 'linear-gradient(135deg, #065f46 0%, #064e3b 100%)',
	),
);
?>
<section id="portfolio" class="portfolio-section py-5 my-5">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		
		<!-- Section Header -->
		<div class="row mb-5 justify-content-center text-center">
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Our Showcase', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-3"><?php esc_html_e( 'Robotics Prototypes', 'robo' ); ?></h2>
				<p class="text-muted"><?php esc_html_e( 'Explore a hand-picked selection of our combat robots, racing drone builds, custom controller boards, and mechanical setups.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Portfolio Grid -->
		<div class="row g-4">
			<?php foreach ( $portfolio_items as $item ) : ?>
				<div class="col-lg-4 col-md-6">
					<div class="portfolio-item-card card border-0 rounded-4 overflow-hidden shadow-sm position-relative text-white" style="height: 300px; background: <?php echo esc_attr( $item['bg_color'] ); ?>;">
						<!-- Hover Overlay -->
						<div class="portfolio-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex flex-column justify-content-end p-4 transition-all opacity-0 hover-opacity-100" style="transition: all 0.3s ease-in-out; cursor: pointer;">
							<span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 rounded-pill align-self-start mb-2 px-3 py-1 text-uppercase fw-semibold small" style="font-size: 0.75rem;">
								<?php echo esc_html( $item['category'] ); ?>
							</span>
							<h3 class="h5 fw-bold text-white mb-2"><?php echo esc_html( $item['title'] ); ?></h3>
							<p class="text-white-50 small mb-3"><?php esc_html_e( 'Click to view case study details and technologies used.', 'robo' ); ?></p>
							<a href="<?php echo esc_url( home_url( '/portfolio/' ) ); ?>" class="btn btn-outline-light btn-sm align-self-start fw-medium"><?php esc_html_e( 'View Details', 'robo' ); ?></a>
						</div>
						<!-- Non-hover fallback content -->
						<div class="portfolio-fallback position-absolute bottom-0 start-0 p-4 w-100 bg-gradient-dark-transparent z-1">
							<span class="text-white-50 small text-uppercase tracking-wider fw-bold mb-1 d-block"><?php echo esc_html( $item['category'] ); ?></span>
							<h3 class="h5 fw-bold text-white mb-0"><?php echo esc_html( $item['title'] ); ?></h3>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
