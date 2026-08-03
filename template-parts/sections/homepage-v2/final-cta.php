<?php
/**
 * Homepage V2 - Section 19: Final Call To Action
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#shop';
?>
<section class="robo-v2-section robo-v2-bg-gradient text-white text-center py-5 border-top border-secondary border-opacity-25 position-relative overflow-hidden">
	<div class="robo-v2-glow-orb top-50 start-50 translate-middle"></div>

	<div class="container position-relative z-2 py-lg-4">
		<span class="robo-v2-badge robo-v2-badge-cyan mb-3">Start Building Today</span>
		<h2 class="display-5 fw-black text-white mb-3" style="max-width: 800px; margin-left: auto; margin-right: auto;">
			Ready To Build Your Very First <span class="robo-v2-gradient-text-blue">AI Robotics Project?</span>
		</h2>
		<p class="lead text-light opacity-90 mb-4 me-auto ms-auto fs-5" style="max-width: 650px;">
			Join 50,000+ students, educators, and makers. Get high-quality STEM hardware, 100% open-source code, and 24/7 engineer support.
		</p>

		<div class="d-flex flex-wrap gap-3 justify-content-center align-items-center mb-4">
			<a href="<?php echo esc_url( $shop_url ); ?>" class="robo-v2-btn robo-v2-btn-primary fs-6">
				<i class="bi bi-rocket-takeoff-fill"></i> Shop Robotics Kits Now
			</a>
			<a href="#contact" class="robo-v2-btn robo-v2-btn-outline-white fs-6">
				<i class="bi bi-headset"></i> Talk To A STEM Specialist
			</a>
		</div>

		<div class="d-flex flex-wrap justify-content-center align-items-center gap-4 text-light opacity-75 small">
			<span><i class="bi bi-check-circle-fill text-info me-1"></i> Free Shipping Over ₹499</span>
			<span><i class="bi bi-check-circle-fill text-info me-1"></i> 1-Year Warranty</span>
			<span><i class="bi bi-check-circle-fill text-info me-1"></i> 24/7 Tech Support</span>
		</div>
	</div>
</section>
