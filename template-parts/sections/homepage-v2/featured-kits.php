<?php
/**
 * Homepage V2 - Section 4: Featured Robotics Kits
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#shop';

$kits = array(
	array(
		'title' => 'Robo-Bot AI Explorer 4WD Rover',
		'price' => '₹4,999',
		'old_price' => '₹6,499',
		'rating' => '4.9',
		'reviews' => '124',
		'badge' => 'BESTSELLER',
		'badge_class' => 'robo-v2-badge-hot',
		'desc' => 'OpenCV AI Camera, Wi-Fi 6, Python App Control, 4WD Aluminium Chassis.',
		'icon' => 'bi-robot',
	),
	array(
		'title' => 'Bionic Quadruped Spider Robot Kit',
		'price' => '₹7,499',
		'old_price' => '₹8,999',
		'rating' => '4.8',
		'reviews' => '89',
		'badge' => 'NEW RELEASE',
		'badge_class' => 'robo-v2-badge-new',
		'desc' => '12-DOF High Torque Servos, ESP32 Controller, Inverse Kinematics Gait.',
		'icon' => 'bi-bug-fill',
	),
	array(
		'title' => 'Smart IoT Home Automation Starter Kit',
		'price' => '₹2,999',
		'old_price' => '₹3,800',
		'rating' => '5.0',
		'reviews' => '210',
		'badge' => 'TOP RATED',
		'badge_class' => 'robo-v2-badge-best',
		'desc' => 'ESP32, OLED Display, Relay Modules, DHT22 & Smartphone Cloud Sync.',
		'icon' => 'bi-house-gear-fill',
	),
	array(
		'title' => 'Autonomous FPV Quadcopter Drone Kit',
		'price' => '₹8,999',
		'old_price' => '₹11,500',
		'rating' => '4.9',
		'reviews' => '76',
		'badge' => 'FLAGSHIP',
		'badge_class' => 'robo-v2-badge-hot',
		'desc' => 'Brushless Motors, Gyro Flight Controller, HD Camera Transmit & GPS Hold.',
		'icon' => 'bi-send-fill',
	),
);
?>
<section class="robo-v2-section bg-white">
	<div class="container">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 fade-in-up">
			<div>
				<span class="robo-v2-badge robo-v2-badge-purple mb-2">Curated Robotics</span>
				<h2 class="robo-v2-section-title text-dark mb-0">
					Featured <span class="robo-v2-gradient-text-purple">Robotics Kits</span>
				</h2>
			</div>
			<a href="<?php echo esc_url( $shop_url ); ?>" class="robo-v2-btn robo-v2-btn-secondary mt-3 mt-md-0">
				View All Kits <i class="bi bi-arrow-right ms-1"></i>
			</a>
		</div>

		<div class="row g-4">
			<?php foreach ( $kits as $kit ) : ?>
				<div class="col-md-6 col-lg-3 fade-in-up">
					<div class="robo-v2-product-card">
						<!-- Image Placeholder Graphic -->
						<div class="robo-v2-product-img-wrapper d-flex align-items-center justify-content-center bg-light">
							<span class="robo-v2-product-badge <?php echo esc_attr( $kit['badge_class'] ); ?>">
								<?php echo esc_html( $kit['badge'] ); ?>
							</span>
							<div class="text-center text-primary py-5">
								<i class="bi <?php echo esc_attr( $kit['icon'] ); ?> display-3 opacity-75"></i>
							</div>
						</div>

						<div class="p-4 d-flex flex-column flex-grow-1">
							<div class="d-flex align-items-center gap-1 text-warning small mb-2">
								<i class="bi bi-star-fill"></i>
								<span class="fw-bold text-dark"><?php echo esc_html( $kit['rating'] ); ?></span>
								<span class="text-muted">(<?php echo esc_html( $kit['reviews'] ); ?>)</span>
							</div>

							<h5 class="fw-bold fs-6 text-dark mb-2"><?php echo esc_html( $kit['title'] ); ?></h5>
							<p class="small text-muted mb-3 flex-grow-1" style="font-size: 0.84rem;"><?php echo esc_html( $kit['desc'] ); ?></p>

							<div class="d-flex align-items-center justify-content-between pt-3 border-top">
								<div>
									<span class="fs-5 fw-bold text-primary"><?php echo esc_html( $kit['price'] ); ?></span>
									<span class="text-decoration-line-through text-muted small ms-1"><?php echo esc_html( $kit['old_price'] ); ?></span>
								</div>
								<a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
									<i class="bi bi-cart-plus me-1"></i> Add
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
