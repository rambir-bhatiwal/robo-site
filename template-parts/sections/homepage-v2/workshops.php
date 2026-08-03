<?php
/**
 * Homepage V2 - Section 11: Workshop & Events
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$events = array(
	array(
		'date' => 'AUG 25, 2026',
		'title' => 'National AI Robotics Championship 2026',
		'mode' => 'Online & Hybrid',
		'seats' => '12 Seats Remaining',
		'desc' => 'Compete in autonomous line follower, obstacle avoidance, and computer vision AI challenges.',
	),
	array(
		'date' => 'SEP 10, 2026',
		'title' => 'ESP32 & IoT Smart Home Hands-On Bootcamp',
		'mode' => 'Live Interactive Webinar',
		'seats' => '5 Seats Remaining',
		'desc' => 'Build a complete smartphone app-controlled home automation system from scratch with ESP32.',
	),
	array(
		'date' => 'SEP 28, 2026',
		'title' => 'K-12 STEM Educator Training & Certification',
		'mode' => 'Institutional Workshop',
		'seats' => 'Open Registration',
		'desc' => 'Master block coding, hardware troubleshooting, and practical classroom lesson execution.',
	),
);
?>
<section class="robo-v2-section bg-white">
	<div class="container">
		<div class="text-center mb-5 fade-in-up">
			<span class="robo-v2-badge robo-v2-badge-purple mb-2">Live Training & Competitions</span>
			<h2 class="robo-v2-section-title text-dark">
				Upcoming Workshops & <span class="robo-v2-gradient-text-purple">Events</span>
			</h2>
			<p class="robo-v2-section-desc">
				Join live interactive bootcamps, hands-on webinars, and national robotics hackathons.
			</p>
		</div>

		<div class="row g-4">
			<?php foreach ( $events as $ev ) : ?>
				<div class="col-lg-4 fade-in-up">
					<div class="robo-v2-card p-4 d-flex flex-column">
						<div class="d-flex align-items-center justify-content-between mb-3">
							<span class="badge bg-danger text-white rounded-pill px-3 py-1 font-monospace">
								<i class="bi bi-calendar-event me-1"></i><?php echo esc_html( $ev['date'] ); ?>
							</span>
							<span class="badge bg-light text-dark border small"><?php echo esc_html( $ev['mode'] ); ?></span>
						</div>
						<h5 class="fw-bold fs-5 text-dark mb-2"><?php echo esc_html( $ev['title'] ); ?></h5>
						<p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;"><?php echo esc_html( $ev['desc'] ); ?></p>
						<div class="pt-3 border-top d-flex align-items-center justify-content-between">
							<span class="text-warning small fw-bold"><i class="bi bi-person-fill me-1"></i><?php echo esc_html( $ev['seats'] ); ?></span>
							<a href="#register-event" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">Register Seat</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
