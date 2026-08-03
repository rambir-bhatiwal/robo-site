<?php
/**
 * Homepage V2 - Section 9: Student Project Showcase
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$projects = array(
	array(
		'title' => 'AI Autonomous Solar Farm Rover',
		'student' => 'Priya & Rahul (Grade 11)',
		'school' => 'Delhi Public School',
		'tag' => 'Advanced AI',
		'badge_bg' => 'bg-danger',
		'desc' => 'Built using Robo-AI 4WD Kit + ESP32-CAM. Automatically inspects solar panels and detects dust using OpenCV.',
		'icon' => 'bi-sun-fill',
	),
	array(
		'title' => 'Gesture Controlled Robotic Bionic Hand',
		'student' => 'Ananya Sharma (B.Tech Robotics)',
		'school' => 'IIT Maker Lab',
		'tag' => 'Robotic Arms',
		'badge_bg' => 'bg-purple',
		'desc' => 'Uses flex sensors and 5 high-torque micro servos to mirror human hand movements with 98% accuracy.',
		'icon' => 'bi-hand-index-thumb-fill',
	),
	array(
		'title' => 'Smart IoT Agriculture Irrigation System',
		'student' => 'Vikram Sethi (Grade 9)',
		'school' => 'Modern STEM School',
		'tag' => 'IoT & Cloud',
		'badge_bg' => 'bg-success',
		'desc' => 'Soil moisture sensors + ESP32 cloud telemetry to automate farm watering and send WhatsApp alert notifications.',
		'icon' => 'bi-droplet-fill',
	),
);
?>
<section class="robo-v2-section bg-white">
	<div class="container">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 fade-in-up">
			<div>
				<span class="robo-v2-badge robo-v2-badge-cyan mb-2">Maker Spotlight</span>
				<h2 class="robo-v2-section-title text-dark mb-0">
					Student <span class="robo-v2-gradient-text-blue">Project Showcase</span>
				</h2>
			</div>
			<a href="#submit-project" class="robo-v2-btn robo-v2-btn-primary mt-3 mt-md-0">
				<i class="bi bi-upload"></i> Submit Your Project
			</a>
		</div>

		<div class="row g-4">
			<?php foreach ( $projects as $proj ) : ?>
				<div class="col-md-4 fade-in-up">
					<div class="robo-v2-card p-4">
						<div class="d-flex align-items-center justify-content-between mb-3">
							<span class="badge <?php echo esc_attr( $proj['badge_bg'] ); ?> text-white rounded-pill px-3 py-2">
								<?php echo esc_html( $proj['tag'] ); ?>
							</span>
							<i class="bi <?php echo esc_attr( $proj['icon'] ); ?> fs-3 text-primary"></i>
						</div>
						<h5 class="fw-bold fs-5 text-dark mb-2"><?php echo esc_html( $proj['title'] ); ?></h5>
						<p class="text-muted small mb-3" style="line-height: 1.6;"><?php echo esc_html( $proj['desc'] ); ?></p>
						<div class="pt-3 border-top d-flex align-items-center justify-content-between small">
							<span class="fw-bold text-dark"><i class="bi bi-person-fill text-primary me-1"></i><?php echo esc_html( $proj['student'] ); ?></span>
							<span class="text-muted"><?php echo esc_html( $proj['school'] ); ?></span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
