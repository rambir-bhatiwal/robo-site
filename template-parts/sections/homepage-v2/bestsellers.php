<?php
/**
 * Homepage V2 - Section 5: Best Selling Products
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#shop';

$bestseller_items = array(
	array(
		'title' => 'M3 X 10mm Phillips CSK SS 304 Screw',
		'cat' => 'hardware',
		'price' => '₹49',
		'rating' => '4.8',
		'icon' => 'bi-nut-fill',
	),
	array(
		'title' => 'M3 Hex Nut SS304 (Dia. 3mm)',
		'cat' => 'hardware',
		'price' => '₹39',
		'rating' => '4.9',
		'icon' => 'bi-gear-wide-connected',
	),
	array(
		'title' => 'M3 X 15mm Brass Standoff Spacer',
		'cat' => 'hardware',
		'price' => '₹79',
		'rating' => '5.0',
		'icon' => 'bi-bounding-box-circles',
	),
	array(
		'title' => 'Soccer Wedge Chassis Frame',
		'cat' => 'kits',
		'price' => '₹899',
		'rating' => '4.7',
		'icon' => 'bi-shield-shaded',
	),
	array(
		'title' => 'Sumo Wedge Competition Chassis',
		'cat' => 'kits',
		'price' => '₹1,299',
		'rating' => '4.9',
		'icon' => 'bi-shield-fill-check',
	),
	array(
		'title' => 'ESP32-CAM AI Vision Development Board',
		'cat' => 'ai',
		'price' => '₹599',
		'rating' => '4.9',
		'icon' => 'bi-camera-video-fill',
	),
);
?>
<section class="robo-v2-section robo-v2-bg-light">
	<div class="container">
		<div class="text-center mb-4 fade-in-up">
			<span class="robo-v2-badge robo-v2-badge-cyan mb-2">High Demand Gear</span>
			<h2 class="robo-v2-section-title text-dark">
				Best Selling <span class="robo-v2-gradient-text-blue">STEM Products</span>
			</h2>
		</div>

		<!-- Category Filter Pills -->
		<div class="d-flex flex-wrap justify-content-center gap-2 mb-5 fade-in-up">
			<button type="button" class="btn robo-v2-tab-btn btn-primary rounded-pill px-4 active" data-filter="all">All Products</button>
			<button type="button" class="btn robo-v2-tab-btn btn-secondary rounded-pill px-4" data-filter="kits">Robotics Kits</button>
			<button type="button" class="btn robo-v2-tab-btn btn-secondary rounded-pill px-4" data-filter="hardware">Fasteners & Standoffs</button>
			<button type="button" class="btn robo-v2-tab-btn btn-secondary rounded-pill px-4" data-filter="ai">AI & Microcontrollers</button>
		</div>

		<div class="row g-4">
			<?php foreach ( $bestseller_items as $item ) : ?>
				<div class="col-6 col-md-4 col-lg-2 robo-v2-filter-item fade-in-up" data-category="<?php echo esc_attr( $item['cat'] ); ?>">
					<div class="robo-v2-product-card">
						<div class="robo-v2-product-img-wrapper d-flex align-items-center justify-content-center bg-white">
							<i class="bi <?php echo esc_attr( $item['icon'] ); ?> display-5 text-primary opacity-75"></i>
						</div>
						<div class="p-3 d-flex flex-column flex-grow-1">
							<div class="text-warning small mb-1">
								<i class="bi bi-star-fill"></i> <span class="fw-bold text-dark"><?php echo esc_html( $item['rating'] ); ?></span>
							</div>
							<h6 class="fw-bold text-dark mb-2 text-truncate-2" style="font-size: 0.875rem; height: 2.6rem;"><?php echo esc_html( $item['title'] ); ?></h6>
							<div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
								<span class="fw-bold text-dark"><?php echo esc_html( $item['price'] ); ?></span>
								<a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-xs btn-outline-primary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
									<i class="bi bi-cart-plus"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
