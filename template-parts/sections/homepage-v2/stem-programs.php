<?php
/**
 * Homepage V2 - Section 10: STEM Programs
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$programs = array(
	array(
		'title' => 'K-12 School STEM Lab Setup',
		'target' => 'Primary & Secondary Schools',
		'price' => 'Turn-Key Lab Solution',
		'icon' => 'bi-building-check',
		'features' => array(
			'30+ Modular Robotics Kits & Storage Units',
			'Printed Curriculum Books & Teacher Manuals',
			'Teacher Certification Workshop (3 Days)',
			'Annual Hardware Replacement & Support',
		),
		'btn' => 'Request School Proposal',
		'popular' => false,
	),
	array(
		'title' => 'University AI & Innovation Lab',
		'target' => 'Colleges & Engineering Labs',
		'price' => 'Advanced AI & IoT Ecosystem',
		'icon' => 'bi-cpu-fill',
		'features' => array(
			'NVIDIA Jetson & ESP32 AI Edge Boards',
			'LiDAR Sensors, Drones & Bionic Hardware',
			'Research Project Mentorship & GitHub Repos',
			'Dedicated Industrial Support Hotline',
		),
		'btn' => 'Request University Pack',
		'popular' => true,
	),
	array(
		'title' => 'Weekend STEM Bootcamps',
		'target' => 'Hobbyists & Young Makers',
		'price' => 'Interactive Workshop Series',
		'icon' => 'bi-stars',
		'features' => array(
			'Hands-on 2-Day Live Training Sessions',
			'Take Home Your Built AI Robotics Kit',
			'Certificate of Excellence & Badge',
			'Lifetime Access to Online Forums',
		),
		'btn' => 'Explore Bootcamps',
		'popular' => false,
	),
);
?>
<section class="robo-v2-section robo-v2-bg-light">
	<div class="container">
		<div class="text-center mb-5 fade-in-up">
			<span class="robo-v2-badge mb-2">Institutional Partnerships</span>
			<h2 class="robo-v2-section-title text-dark">
				STEM & Robotics <span class="robo-v2-gradient-text">Programs</span>
			</h2>
			<p class="robo-v2-section-desc">
				Customized hardware bundles, accredited curricula, and teacher training for institutions worldwide.
			</p>
		</div>

		<div class="row g-4 align-items-stretch">
			<?php foreach ( $programs as $prog ) : ?>
				<div class="col-lg-4 fade-in-up">
					<div class="robo-v2-card p-4 d-flex flex-column position-relative <?php echo $prog['popular'] ? 'border-primary border-2 shadow-lg' : ''; ?>">
						<?php if ( $prog['popular'] ) : ?>
							<div class="position-absolute top-0 end-0 m-3">
								<span class="badge bg-primary text-white rounded-pill px-3 py-1 font-monospace">MOST POPULAR</span>
							</div>
						<?php endif; ?>

						<div class="robo-v2-icon-box mb-3">
							<i class="bi <?php echo esc_attr( $prog['icon'] ); ?>"></i>
						</div>

						<h4 class="fw-bold text-dark fs-5 mb-1"><?php echo esc_html( $prog['title'] ); ?></h4>
						<span class="text-primary small font-monospace d-block mb-3"><?php echo esc_html( $prog['target'] ); ?></span>

						<div class="p-3 bg-light rounded-3 mb-4">
							<span class="fw-bold text-dark fs-6 d-block"><?php echo esc_html( $prog['price'] ); ?></span>
						</div>

						<ul class="list-unstyled flex-grow-1 mb-4 text-muted small me-2" style="line-height: 2;">
							<?php foreach ( $prog['features'] as $feat ) : ?>
								<li class="d-flex align-items-center gap-2 mb-2">
									<i class="bi bi-check-circle-fill text-success flex-shrink-0"></i>
									<span><?php echo esc_html( $feat ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>

						<a href="#contact" class="robo-v2-btn <?php echo $prog['popular'] ? 'robo-v2-btn-primary' : 'robo-v2-btn-secondary'; ?> w-100">
							<?php echo esc_html( $prog['btn'] ); ?>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
