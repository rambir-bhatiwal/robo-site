<?php
/**
 * Homepage V2 - Section 2: Trust Bar
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$trust_items = array(
	array(
		'icon'  => 'bi-truck',
		'title' => 'Fast Shipping',
		'desc'  => 'Dispatch within 24 Hours',
	),
	array(
		'icon'  => 'bi-shield-check',
		'title' => '100% Secure Payment',
		'desc'  => 'Razorpay & SSL Encryption',
	),
	array(
		'icon'  => 'bi-headset',
		'title' => '24/7 Tech Support',
		'desc'  => 'Dedicated Engineer Help',
	),
	array(
		'icon'  => 'bi-award',
		'title' => 'STEM Certified',
		'desc'  => 'Tested for Quality & Safety',
	),
	array(
		'icon'  => 'bi-arrow-counterclockwise',
		'title' => '1-Year Warranty',
		'desc'  => 'Hassle-Free Replacement',
	),
);
?>
<section class="py-4 bg-white border-bottom shadow-sm position-relative z-3">
	<div class="container">
		<div class="row g-4 align-items-center justify-content-between">
			<?php foreach ( $trust_items as $item ) : ?>
				<div class="col-6 col-md-4 col-lg-2-4 fade-in-up">
					<div class="d-flex align-items-center gap-3 p-2">
						<div class="robo-v2-icon-box mb-0 flex-shrink-0" style="width: 48px; height: 48px; font-size: 1.25rem;">
							<i class="bi <?php echo esc_attr( $item['icon'] ); ?>"></i>
						</div>
						<div>
							<h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9375rem;"><?php echo esc_html( $item['title'] ); ?></h6>
							<span class="text-muted small" style="font-size: 0.8125rem;"><?php echo esc_html( $item['desc'] ); ?></span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
