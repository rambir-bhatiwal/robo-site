<?php
/**
 * Homepage V2 - Section 16: Latest Blogs & Articles
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blogs = array(
	array(
		'title' => 'Getting Started With ESP32-CAM: AI Vision & Object Tracking',
		'date'  => 'AUG 01, 2026',
		'read'  => '5 Min Read',
		'desc'  => 'Learn how to set up OpenCV computer vision on ESP32 microcontrollers for under ₹600.',
		'icon'  => 'bi-camera-video-fill',
	),
	array(
		'title' => 'Why Inverse Kinematics Is Crucial For Bionic Quadruped Robots',
		'date'  => 'JUL 26, 2026',
		'read'  => '8 Min Read',
		'desc'  => 'A deep dive into 12-DOF servo gait mathematics and smooth terrain adaptation algorithms.',
		'icon'  => 'bi-calculator-fill',
	),
	array(
		'title' => 'How To Build A School STEM Lab On A Budget',
		'date'  => 'JUL 18, 2026',
		'read'  => '6 Min Read',
		'desc'  => 'A step-by-step roadmap for educators planning K-12 robotics curriculum and component procurement.',
		'icon'  => 'bi-lightbulb-fill',
	),
);
?>
<section class="robo-v2-section robo-v2-bg-light">
	<div class="container">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 fade-in-up">
			<div>
				<span class="robo-v2-badge robo-v2-badge-purple mb-2">Robotics Insights</span>
				<h2 class="robo-v2-section-title text-dark mb-0">
					Latest <span class="robo-v2-gradient-text-purple">Blogs & Tutorials</span>
				</h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="robo-v2-btn robo-v2-btn-secondary mt-3 mt-md-0">
				View All Posts <i class="bi bi-arrow-right ms-1"></i>
			</a>
		</div>

		<div class="row g-4">
			<?php foreach ( $blogs as $b ) : ?>
				<div class="col-md-4 fade-in-up">
					<div class="robo-v2-card p-4 d-flex flex-column h-100">
						<div class="p-4 bg-primary bg-opacity-10 text-primary rounded-3 text-center mb-3">
							<i class="bi <?php echo esc_attr( $b['icon'] ); ?> display-4"></i>
						</div>
						<div class="d-flex align-items-center justify-content-between text-muted small mb-2">
							<span><i class="bi bi-calendar3 me-1"></i><?php echo esc_html( $b['date'] ); ?></span>
							<span><i class="bi bi-clock me-1"></i><?php echo esc_html( $b['read'] ); ?></span>
						</div>
						<h5 class="fw-bold fs-6 text-dark mb-2"><?php echo esc_html( $b['title'] ); ?></h5>
						<p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;"><?php echo esc_html( $b['desc'] ); ?></p>
						<a href="#read" class="fw-bold text-primary text-decoration-none small">
							Read Article <i class="bi bi-arrow-right ms-1"></i>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
