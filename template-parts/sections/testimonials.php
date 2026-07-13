<?php
/**
 * Template part for displaying the Testimonials section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

$testimonials = array(
	array(
		'name'    => esc_html__( 'Sarah Jenkins', 'robo' ),
		'role'    => esc_html__( 'Lead Coach, RoboClub STEM High', 'robo' ),
		'quote'   => esc_html__( 'The STEM Starter SumoBot kits are incredible. Our students built and coded their first autonomous robots in less than two weeks. The solderless connectors saved us so much setup time!', 'robo' ),
		'stars'   => 5,
		'initial' => 'S',
	),
	array(
		'name'    => esc_html__( 'Marcus Aurelius', 'robo' ),
		'role'    => esc_html__( 'Professional Drone Pilot', 'robo' ),
		'quote'   => esc_html__( 'The high-discharge LiPo battery packs and brushless ESC controllers from Robo are top-notch. I get zero voltage sag during extreme aerial maneuvers, giving me complete confidence during races.', 'robo' ),
		'stars'   => 5,
		'initial' => 'M',
	),
	array(
		'name'    => esc_html__( 'Evelyn Martinez', 'robo' ),
		'role'    => esc_html__( 'Coordinator, BattleBots Local League', 'robo' ),
		'quote'   => esc_html__( 'Finding replacement steel gears, tires, and motor brackets is usually a nightmare. Robo has everything in stock and ready to ship, which kept our arena competitors running all weekend.', 'robo' ),
		'stars'   => 5,
		'initial' => 'E',
	),
);
?>
<section id="testimonials" class="testimonials-section py-5 my-5">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		
		<!-- Section Header -->
		<div class="row mb-5 justify-content-center text-center">
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'User Reviews', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-3"><?php esc_html_e( 'What Builders Say', 'robo' ); ?></h2>
				<p class="text-muted"><?php esc_html_e( 'Check out verified reviews from students, educators, and drone pilots who build with Robo parts.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Testimonials Grid -->
		<div class="row g-4">
			<?php foreach ( $testimonials as $test ) : ?>
				<div class="col-lg-4 col-md-6">
					<div class="testimonial-card card h-100 border-0 shadow-sm p-4 bg-light text-start transition-all position-relative">
						<!-- Quote Icon -->
						<div class="position-absolute top-0 end-0 m-4 text-primary text-opacity-10">
							<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-quote" viewBox="0 0 16 16"><path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.753.31-1.142.173-.473.41-.93.713-1.372a1 1 0 1 0-1.664-1.117C9.672 4.489 9.278 5.26 9 6.13c-.26.84-.4 1.72-.4 2.6v2a1 1 0 0 0 1 1zM5 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H3.612c0-.351.021-.703.062-1.054.062-.372.166-.753.31-1.142.173-.473.41-.93.713-1.372a1 1 0 1 0-1.664-1.117C2.672 4.489 2.278 5.26 2 6.13c-.26.84-.4 1.72-.4 2.6v2a1 1 0 0 0 1 1z"/></svg>
						</div>

						<!-- Star Ratings -->
						<div class="stars mb-3 text-warning">
							<?php for ( $i = 0; $i < $test['stars']; $i++ ) : ?>
								<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-star-fill me-1" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
							<?php endfor; ?>
						</div>

						<p class="text-muted small flex-grow-1 mb-4 position-relative z-1"><?php echo esc_html( $test['quote'] ); ?></p>
						
						<!-- Client Profile -->
						<div class="d-flex align-items-center gap-3">
							<div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px;">
								<?php echo esc_html( $test['initial'] ); ?>
							</div>
							<div>
								<h5 class="h6 fw-bold text-dark mb-0"><?php echo esc_html( $test['name'] ); ?></h5>
								<span class="text-muted small" style="font-size: 0.8rem;"><?php echo esc_html( $test['role'] ); ?></span>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
