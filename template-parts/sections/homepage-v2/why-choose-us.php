<?php
/**
 * Homepage V2 - Section 7: Why Choose Us
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$features = array(
	array(
		'title' => 'Plug & Play Hardware',
		'desc'  => 'No messy soldering required. Our custom PCB shields and color-coded connectors make assembly effortless.',
		'icon'  => 'bi-plug-fill',
		'box'   => 'robo-v2-icon-box',
	),
	array(
		'title' => 'Comprehensive Curriculum',
		'desc'  => 'Mapped to global STEM standards with step-by-step PDF workbooks and video guides for all ages.',
		'icon'  => 'bi-book-fill',
		'box'   => 'robo-v2-icon-box-cyan',
	),
	array(
		'title' => 'Industrial Components',
		'desc'  => 'Built with SS304 stainless steel, brass standoffs, high-torque servos, and genuine microcontrollers.',
		'icon'  => 'bi-shield-fill-check',
		'box'   => 'robo-v2-icon-box-purple',
	),
	array(
		'title' => 'Dedicated Engineer Support',
		'desc'  => 'Stuck on a bug or wiring issue? Get direct 1-on-1 assistance from our robotics engineers.',
		'icon'  => 'bi-headset',
		'box'   => 'robo-v2-icon-box-cyan',
	),
	array(
		'title' => 'Institutional Lab Setup',
		'desc'  => 'Complete turn-key solutions for school robotics labs, university research, and maker spaces.',
		'icon'  => 'bi-building-fill-gear',
		'box'   => 'robo-v2-icon-box',
	),
	array(
		'title' => '100% Open Source',
		'desc'  => 'Free code repositories, CAD files, and schematics to encourage unlimited customization.',
		'icon'  => 'bi-github',
		'box'   => 'robo-v2-icon-box-purple',
	),
);
?>
<section class="robo-v2-section bg-white">
	<div class="container">
		<div class="text-center mb-5 fade-in-up">
			<span class="robo-v2-badge mb-2">The Robo Difference</span>
			<h2 class="robo-v2-section-title text-dark">
				Why Educators & Makers <span class="robo-v2-gradient-text">Trust Robo</span>
			</h2>
			<p class="robo-v2-section-desc">
				Engineered for durability, designed for seamless learning, and backed by expert engineering support.
			</p>
		</div>

		<div class="row g-4">
			<?php foreach ( $features as $feat ) : ?>
				<div class="col-md-6 col-lg-4 fade-in-up">
					<div class="robo-v2-card p-4">
						<div class="<?php echo esc_attr( $feat['box'] ); ?>">
							<i class="bi <?php echo esc_attr( $feat['icon'] ); ?>"></i>
						</div>
						<h5 class="fw-bold fs-5 text-dark mb-2"><?php echo esc_html( $feat['title'] ); ?></h5>
						<p class="text-muted mb-0" style="font-size: 0.9375rem; line-height: 1.6;"><?php echo esc_html( $feat['desc'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
