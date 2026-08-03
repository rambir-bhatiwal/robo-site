<?php
/**
 * Homepage V2 - Section 12: Success Stories & Impact Metrics
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = array(
	array(
		'target' => 50000,
		'suffix' => '+',
		'label'  => 'Students Empowered',
		'icon'   => 'bi-mortarboard-fill',
	),
	array(
		'target' => 500,
		'suffix' => '+',
		'label'  => 'Partner Schools & STEM Labs',
		'icon'   => 'bi-building-fill',
	),
	array(
		'target' => 150000,
		'suffix' => '+',
		'label'  => 'Robotics Kits Delivered',
		'icon'   => 'bi-box-seam-fill',
	),
	array(
		'target' => 99,
		'suffix' => '%',
		'label'  => 'Positive Learning Satisfaction',
		'icon'   => 'bi-emoji-smile-fill',
	),
);
?>
<section class="robo-v2-section robo-v2-bg-gradient text-white position-relative py-5">
	<div class="container py-lg-3 position-relative z-2">
		<div class="text-center mb-5 fade-in-up">
			<span class="robo-v2-badge robo-v2-badge-cyan mb-2">Quantifiable Impact</span>
			<h2 class="robo-v2-section-title text-white">
				Our Learning <span class="robo-v2-gradient-text-blue">Impact Numbers</span>
			</h2>
		</div>

		<div class="row g-4 text-center">
			<?php foreach ( $stats as $s ) : ?>
				<div class="col-6 col-md-3 fade-in-up">
					<div class="robo-v2-card-dark rounded-4 p-4 border border-secondary border-opacity-25 h-100">
						<div class="robo-v2-icon-box robo-v2-icon-box-cyan mx-auto mb-3" style="width: 52px; height: 52px;">
							<i class="bi <?php echo esc_attr( $s['icon'] ); ?>"></i>
						</div>
						<div class="robo-v2-stat-num text-info" data-target="<?php echo esc_attr( $s['target'] ); ?>" data-suffix="<?php echo esc_attr( $s['suffix'] ); ?>">0</div>
						<span class="text-light opacity-75 small fw-bold text-uppercase d-block mt-2" style="letter-spacing: 0.05em;"><?php echo esc_html( $s['label'] ); ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
