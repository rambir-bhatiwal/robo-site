<?php
/**
 * Template part for displaying the Newsletter section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>
<section id="newsletter" class="newsletter-section py-5 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #0052FF 100%);">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4 text-center">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				
				<!-- Icon Wrapper -->
				<div class="newsletter-icon mb-4 text-primary bg-white bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px;">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-envelope-paper" viewBox="0 0 16 16"><path d="M4 0a2 2 0 0 0-2 2v1.133l-.941.502A2 2 0 0 0 0 5.4V14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5.4a2 2 0 0 0-1.059-1.765L14 3.133V2a2 2 0 0 0-2-2zm10 4.267.47.25A1 1 0 0 1 15 5.4V14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V5.4a1 1 0 0 1 .53-.883L2 4.267V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v1.382l-5.382 2.87a1 1 0 0 1-.908 0L3 3.382zm0 2.236 3.618 2.01a2 2 0 0 0 1.832 0L12 4.236V14H3z"/></svg>
				</div>

				<h2 class="h1 fw-extrabold text-white mb-3"><?php esc_html_e( 'Stay Updated on Robotics Gear', 'robo' ); ?></h2>
				<p class="text-white-50 fs-6 mb-5"><?php esc_html_e( 'Subscribe to receive notifications about new parts arrivals, sumobot tournament tips, custom battery firmware updates, and stock availability alerts.', 'robo' ); ?></p>
				
				<!-- Inline Subscribe Form -->
				<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="row g-2 justify-content-center">
					<div class="col-sm-8">
						<input type="email" class="form-control form-control-lg bg-white bg-opacity-10 border-white border-opacity-20 text-white placeholder-light shadow-none py-3 px-4 rounded-3" placeholder="<?php esc_attr_e( 'Enter your email address...', 'robo' ); ?>" required>
					</div>
					<div class="col-sm-4">
						<button type="submit" class="btn btn-white btn-lg w-100 py-3 fw-bold bg-white text-dark rounded-3 shadow border-0 hover-opacity-90">
							<?php esc_html_e( 'Subscribe Now', 'robo' ); ?>
						</button>
					</div>
				</form>
				
				<p class="text-white-50 small mt-4 mb-0"><?php esc_html_e( 'We respect your privacy. Unsubscribe at any time.', 'robo' ); ?></p>
			</div>
		</div>
	</div>
</section>
