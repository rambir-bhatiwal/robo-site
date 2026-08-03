<?php
/**
 * Homepage V2 - Section 18: Newsletter & Community Signup
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="robo-v2-section robo-v2-bg-light position-relative py-5">
	<div class="container">
		<div class="robo-v2-card-dark rounded-4 p-4 p-md-5 border border-secondary border-opacity-25 shadow-lg position-relative overflow-hidden">
			<!-- Background Orb -->
			<div class="robo-v2-glow-orb robo-v2-glow-orb-cyan top-0 start-50 translate-middle-x"></div>

			<div class="row align-items-center justify-content-between position-relative z-2">
				<div class="col-lg-6 mb-4 mb-lg-0 text-center text-lg-start">
					<span class="badge bg-primary text-white rounded-pill px-3 py-1 font-monospace mb-2">
						<i class="bi bi-gift-fill me-1"></i> GET 10% OFF YOUR FIRST ORDER
					</span>
					<h3 class="fw-bold text-white display-6 mb-2">Join The Robo Maker Club</h3>
					<p class="text-light opacity-75 mb-0" style="max-width: 500px;">
						Subscribe for exclusive STEM tutorials, new kit launches, DIY open-source code drops, and VIP discount coupons.
					</p>
				</div>

				<div class="col-lg-5">
					<form action="#" method="post" class="d-flex flex-column flex-sm-row gap-2">
						<input type="email" name="email" class="form-control form-control-lg rounded-pill px-4 bg-dark text-white border-secondary border-opacity-50" placeholder="Enter your email address..." required style="font-size: 0.95rem;">
						<button type="submit" class="robo-v2-btn robo-v2-btn-primary rounded-pill px-4 flex-shrink-0">
							Subscribe <i class="bi bi-send-fill ms-1"></i>
						</button>
					</form>
					<span class="text-light opacity-50 small d-block mt-2 text-center text-lg-start">We respect your privacy. Unsubscribe anytime in 1-click.</span>
				</div>
			</div>
		</div>
	</div>
</section>
