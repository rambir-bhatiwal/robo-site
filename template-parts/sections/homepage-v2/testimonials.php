<?php
/**
 * Homepage V2 - Section 13: Testimonials
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$testimonials = array(
	array(
		'quote' => 'Robo kits transformed our STEM curriculum. The color-coded shields and Python manuals allowed our Grade 8 students to build working AI rovers in just 2 weeks!',
		'name'  => 'Dr. Rajesh Vardhan',
		'role'  => 'Head of STEM Education, Apex Academy',
		'stars' => 5,
	),
	array(
		'quote' => 'The build quality of the brass standoffs, servos, and custom PCB boards is top-notch. And when we had a coding question, their engineer support solved it on WhatsApp in 10 mins!',
		'name'  => 'Sunita Deshmukh',
		'role'  => 'Robotics Club Coordinator',
		'stars' => 5,
	),
	array(
		'quote' => 'My 13-year-old son went from playing video games all day to coding obstacle avoidance algorithms in Python. This is by far the best educational investment we made.',
		'name'  => 'Alok Banerjee',
		'role'  => 'Parent & Maker Enthusiast',
		'stars' => 5,
	),
);
?>
<section class="robo-v2-section bg-white">
	<div class="container">
		<div class="text-center mb-5 fade-in-up">
			<span class="robo-v2-badge mb-2">Verified Reviews</span>
			<h2 class="robo-v2-section-title text-dark">
				What Our Community <span class="robo-v2-gradient-text">Says About Us</span>
			</h2>
			<p class="robo-v2-section-desc">
				Trusted by teachers, students, robotics engineers, and parents across the country.
			</p>
		</div>

		<div class="row g-4">
			<?php foreach ( $testimonials as $t ) : ?>
				<div class="col-md-4 fade-in-up">
					<div class="robo-v2-card p-4 d-flex flex-column h-100">
						<div class="text-warning mb-3">
							<?php for ( $i = 0; $i < $t['stars']; $i++ ) : ?>
								<i class="bi bi-star-fill"></i>
							<?php endfor; ?>
						</div>
						<p class="text-muted fst-italic mb-4 flex-grow-1" style="font-size: 0.9375rem; line-height: 1.7;">
							"<?php echo esc_html( $t['quote'] ); ?>"
						</p>
						<div class="pt-3 border-top d-flex align-items-center gap-3">
							<div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px; font-size: 1.1rem;">
								<?php echo esc_html( substr( $t['name'], 0, 1 ) ); ?>
							</div>
							<div>
								<h6 class="fw-bold text-dark mb-0" style="font-size: 0.9375rem;"><?php echo esc_html( $t['name'] ); ?></h6>
								<span class="text-muted small"><?php echo esc_html( $t['role'] ); ?></span>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
