<?php
/**
 * Homepage V2 - Section 3: Featured Categories
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories_data = array(
	array(
		'title' => 'DIY Robotics Kits',
		'desc'  => 'Quadrupeds, Rovers & Robotic Arms',
		'icon'  => 'bi-robot',
		'count' => '45+ Products',
	),
	array(
		'title' => 'Microcontrollers & IoT',
		'desc'  => 'Arduino, ESP32 & Raspberry Pi',
		'icon'  => 'bi-cpu',
		'count' => '120+ Products',
	),
	array(
		'title' => 'AI & Vision Modules',
		'desc'  => 'Smart Cameras, LiDAR & Sensors',
		'icon'  => 'bi-eye-fill',
		'count' => '35+ Products',
	),
	array(
		'title' => 'Motors & Actuators',
		'desc'  => 'Servos, Stepper Motors & Drivers',
		'icon'  => 'bi-gear-wide-connected',
		'count' => '80+ Products',
	),
	array(
		'title' => 'Drones & Aviation',
		'desc'  => 'Quadcopter Frames & Flight Controllers',
		'icon'  => 'bi-send-fill',
		'count' => '25+ Products',
	),
	array(
		'title' => '3D Printing & Supplies',
		'desc'  => 'PLA Filaments, Nozzles & Parts',
		'icon'  => 'bi-printer-fill',
		'count' => '60+ Products',
	),
);

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#shop';
?>
<section class="robo-v2-section robo-v2-bg-light">
	<div class="container">
		<div class="text-center mb-5 fade-in-up">
			<span class="robo-v2-badge mb-2">Explore Hardware</span>
			<h2 class="robo-v2-section-title text-dark">
				Popular STEM & <span class="robo-v2-gradient-text">Robotics Categories</span>
			</h2>
			<p class="robo-v2-section-desc">
				From beginner DIY kits to advanced industrial sensors and AI hardware modules.
			</p>
		</div>

		<div class="row g-4">
			<?php foreach ( $categories_data as $cat ) : ?>
				<div class="col-6 col-md-4 col-lg-2 fade-in-up">
					<a href="<?php echo esc_url( $shop_url ); ?>" class="text-decoration-none d-block h-100">
						<div class="robo-v2-cat-card">
							<div class="robo-v2-cat-icon">
								<i class="bi <?php echo esc_attr( $cat['icon'] ); ?>"></i>
							</div>
							<h5 class="fw-bold fs-6 text-dark mb-1"><?php echo esc_html( $cat['title'] ); ?></h5>
							<span class="badge bg-light text-muted border rounded-pill small mt-2"><?php echo esc_html( $cat['count'] ); ?></span>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
