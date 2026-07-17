<?php
/**
 * Template part for displaying the Contact section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>
<section id="contact" class="contact-section py-5 my-5">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		
		<!-- Section Header -->
		<div class="row mb-5 justify-content-center text-center">
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Get In Touch', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-3"><?php esc_html_e( 'Contact Us Today', 'robo' ); ?></h2>
				<p class="text-muted"><?php esc_html_e( 'Have a question about our custom robot kits, batteries, drone parts, or need bulk order discounts? Drop us a line below.', 'robo' ); ?></p>
			</div>
		</div>

		<div class="row g-5 align-items-stretch">
			
			<!-- Left Contact Info Column -->
			<div class="col-lg-5">
				<div class="card h-100 border-0 bg-dark text-white p-5 rounded-4 d-flex flex-column justify-content-between position-relative overflow-hidden">
					<!-- Animated Background Blur -->
					<div class="position-absolute top-0 end-0 bg-primary opacity-10 rounded-circle" style="width: 200px; height: 200px; transform: translate(30%, -30%); filter: blur(50px);"></div>
					
					<div>
						<h3 class="h4 fw-bold text-white mb-4"><?php esc_html_e( 'Contact Information', 'robo' ); ?></h3>
						<p class="text-white-50 small mb-5"><?php esc_html_e( 'Reach out to our engineering support or sales team. We reply within one business day.', 'robo' ); ?></p>
						
						<!-- Info Lists -->
						<div class="d-flex flex-column gap-4">
							<div class="d-flex align-items-center gap-3">
								<div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/><path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4"/></svg>
								</div>
								<div>
									<h4 class="h6 text-white-50 fw-bold mb-1"><?php esc_html_e( 'Engineering Lab', 'robo' ); ?></h4>
									<p class="mb-0 small text-white"><?php echo esc_html( robo_get_company_info( 'address' ) ); ?></p>
								</div>
							</div>

							<div class="d-flex align-items-center gap-3">
								<div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16"><path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.601 17.6 17.6 0 0 0 6.61 4.169c.596.211 1.284.03 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .06.47l.504.99a1.75 1.75 0 0 0 1.63 1.05h.412a.68.68 0 0 0 .47-.06l2.19-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/></svg>
								</div>
								<div>
									<h4 class="h6 text-white-50 fw-bold mb-1"><?php esc_html_e( 'Call Us Directly', 'robo' ); ?></h4>
									<p class="mb-0 small text-white"><?php echo esc_html( robo_get_company_info( 'phone_number' ) ); ?></p>
								</div>
							</div>

							<div class="d-flex align-items-center gap-3">
								<div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/></svg>
								</div>
								<div>
									<h4 class="h6 text-white-50 fw-bold mb-1"><?php esc_html_e( 'Email Support', 'robo' ); ?></h4>
									<p class="mb-0 small text-white"><?php echo esc_html( robo_get_company_info( 'support_email' ) ); ?></p>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Social Links inside contact -->
					<div class="mt-5 border-top border-secondary border-opacity-25 pt-4">
						<h5 class="h6 fw-bold text-white mb-3"><?php esc_html_e( 'Follow Us', 'robo' ); ?></h5>
						<div class="d-flex gap-3">
							<a href="<?php echo esc_url( robo_get_company_info( 'instagram_url' ) ); ?>" class="btn btn-outline-light btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
								<?php echo robo_get_svg( 'instagram' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
							<a href="<?php echo esc_url( robo_get_company_info( 'youtube_url' ) ); ?>" class="btn btn-outline-light btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
								<?php echo robo_get_svg( 'youtube' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						</div>
					</div>

				</div>
			</div>

			<!-- Right Form Column -->
			<div class="col-lg-7">
				<div class="card h-100 border-0 shadow-sm p-5 bg-light rounded-4">
					<h3 class="h4 fw-bold text-dark mb-4"><?php esc_html_e( '2Send Us a Message', 'robo' ); ?></h3>
					
					
					<?php
						echo do_shortcode('[contact-form-7 id="0c39c88" title="Contact"]');
					?>
				</div>
			</div>

		</div>
	</div>
</section>