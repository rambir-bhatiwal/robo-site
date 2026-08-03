<?php
/**
 * Homepage V2 - Section 15: Brands We Work With
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$brands = array(
	array( 'name' => 'Arduino', 'icon' => 'bi-cpu-fill' ),
	array( 'name' => 'Raspberry Pi', 'icon' => 'bi-pie-chart-fill' ),
	array( 'name' => 'ESPRESSIF', 'icon' => 'bi-wifi' ),
	array( 'name' => 'NVIDIA Jetson', 'icon' => 'bi-gpu-card' ),
	array( 'name' => 'STMicroelectronics', 'icon' => 'bi-microchip' ),
	array( 'name' => 'Texas Instruments', 'icon' => 'bi-lightning-charge-fill' ),
);
?>
<section class="py-5 bg-white border-bottom">
	<div class="container">
		<div class="text-center mb-4">
			<span class="robo-v2-badge robo-v2-badge-cyan">Official Ecosystem Partners</span>
		</div>
		<div class="row align-items-center justify-content-center g-4 text-center">
			<?php foreach ( $brands as $b ) : ?>
				<div class="col-6 col-md-4 col-lg-2">
					<div class="p-3 rounded-3 border bg-light d-flex align-items-center justify-content-center gap-2 text-dark font-monospace fw-bold" style="font-size: 0.9rem;">
						<i class="bi <?php echo esc_attr( $b['icon'] ); ?> text-primary fs-5"></i>
						<span><?php echo esc_html( $b['name'] ); ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
