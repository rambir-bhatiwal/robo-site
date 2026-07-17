<?php
/**
 * Template Name: Contact Us Page
 * The template for displaying the Contact Us page by slug or selection.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<div class="contact-page-wrapper bg-light-subtle pb-5">
	<!-- Hero Section -->
	<section class="contact-hero bg-dark text-white py-5 text-center position-relative overflow-hidden mb-5">
		<div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 bg-grid" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 20px 20px;"></div>
		<div class="<?php echo esc_attr( $container_class ); ?> position-relative z-1 py-4">
			<h1 class="display-4 fw-extrabold text-white mb-2"><?php the_title(); ?></h1>
			<p class="lead text-white-50 max-width-600 mx-auto mb-0"><?php esc_html_e( 'Have questions about kits, combat components, or custom designs? Get in touch.', 'robo' ); ?></p>
		</div>
	</section>

	<!-- Contact Information Cards -->
	<section class="contact-info-cards mb-5">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row g-4">
				<!-- Address -->
				<div class="col-lg-4 col-md-6">
					<div class="card border-0 shadow-sm p-4 h-100 bg-white text-center hover-up transition-all" style="transition: all 0.3s ease-in-out;">
						<div class="icon-box text-primary mb-3 bg-primary-subtle rounded-circle p-3 d-inline-flex align-items-center justify-content-center mx-auto" style="width: 52px; height: 52px;">
							<i class="bi bi-geo-alt-fill fs-4"></i>
						</div>
						<h6 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Our Laboratory', 'robo' ); ?></h6>
						<p class="text-muted small mb-0">
							<a href="<?php echo esc_url( robo_get_company_info( 'maps_url' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted">
								<?php echo esc_html( robo_get_company_info( 'address' ) ); ?>
							</a>
						</p>
					</div>
				</div>
				<!-- Phone -->
				<div class="col-lg-4 col-md-6">
					<div class="card border-0 shadow-sm p-4 h-100 bg-white text-center hover-up transition-all" style="transition: all 0.3s ease-in-out;">
						<div class="icon-box text-success mb-3 bg-success-subtle rounded-circle p-3 d-inline-flex align-items-center justify-content-center mx-auto" style="width: 52px; height: 52px;">
							<i class="bi bi-telephone-fill fs-4"></i>
						</div>
						<h6 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Call Us', 'robo' ); ?></h6>
						<p class="text-muted small mb-0">
							<a href="<?php echo esc_url( 'tel:' . str_replace( ' ', '', robo_get_company_info( 'phone_number' ) ) ); ?>" class="text-decoration-none text-muted">
								<?php echo esc_html( robo_get_company_info( 'phone_number' ) ); ?>
							</a>
						</p>
					</div>
				</div>
				<!-- Email -->
				<div class="col-lg-4 col-md-12">
					<div class="card border-0 shadow-sm p-4 h-100 bg-white text-center hover-up transition-all" style="transition: all 0.3s ease-in-out;">
						<div class="icon-box text-info mb-3 bg-info-subtle rounded-circle p-3 d-inline-flex align-items-center justify-content-center mx-auto" style="width: 52px; height: 52px;">
							<i class="bi bi-envelope-fill fs-4"></i>
						</div>
						<h6 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Email Support', 'robo' ); ?></h6>
						<p class="text-muted small mb-0">
							<a href="<?php echo esc_url( 'https://mail.google.com/mail/?view=cm&fs=1&to=' . robo_get_company_info( 'support_email' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted">
								<?php echo esc_html( robo_get_company_info( 'support_email' ) ); ?>
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Contact Form 7 Integration & Business Hours -->
	<section class="form-hours-section mb-5 py-3">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row g-4">
				<!-- Form Area -->
				<div class="col-lg-7">
					<div class="card border-0 shadow-sm p-4 p-md-5 h-100 bg-white">
						<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Contact Form', 'robo' ); ?></span>
						<h2 class="h2 fw-bold text-dark mb-4"><?php esc_html_e( 'Send Us a Message', 'robo' ); ?></h2>
						
						<?php
						$has_content = false;
						if ( have_posts() ) {
							while ( have_posts() ) {
								the_post();
								$content = get_the_content();
								if ( ! empty( $content ) ) {
									$has_content = true;
									the_content();
								}
							}
						}
						
						if ( ! $has_content ) {
							// Render a beautiful fallback form if no CF7 or custom form shortcode is in editor content
							?>
							<?php
								echo do_shortcode('[contact-form-7 id="6c9359c" title="Contact"]');
							?>
							<?php
						}
						?>
					</div>
				</div>

				<!-- Business Hours Column -->
				<div class="col-lg-5">
					<div class="card border-0 shadow-sm p-4 p-md-5 h-100 bg-white d-flex flex-column justify-content-between">
						<div>
							<span class="text-success text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Lab Timings', 'robo' ); ?></span>
							<h3 class="h3 fw-bold text-dark mb-4"><?php esc_html_e( 'Business Hours', 'robo' ); ?></h3>
							<p class="text-muted small mb-4 lh-lg"><?php esc_html_e( 'Our engineering technicians and support staff are available during the following hours to assist you with order processing, custom firmware debugging, and hardware troubleshooting.', 'robo' ); ?></p>
							
							<ul class="list-unstyled mb-0 d-flex flex-column gap-3">
								<li class="d-flex align-items-center justify-content-between pb-2 border-bottom border-light-subtle">
									<span class="fw-bold text-dark"><?php esc_html_e( 'Monday - Friday', 'robo' ); ?></span>
									<span class="text-primary fw-semibold"><?php esc_html_e( '9:00 AM - 6:00 PM EST', 'robo' ); ?></span>
								</li>
								<li class="d-flex align-items-center justify-content-between pb-2 border-bottom border-light-subtle">
									<span class="fw-bold text-dark"><?php esc_html_e( 'Saturday', 'robo' ); ?></span>
									<span class="text-muted"><?php esc_html_e( '10:00 AM - 4:00 PM EST', 'robo' ); ?></span>
								</li>
								<li class="d-flex align-items-center justify-content-between">
									<span class="fw-bold text-dark"><?php esc_html_e( 'Sunday', 'robo' ); ?></span>
									<span class="text-danger fw-semibold"><?php esc_html_e( 'Closed (Arena Matches)', 'robo' ); ?></span>
								</li>
							</ul>
						</div>

						<div class="mt-4 p-3 bg-light rounded-3 border border-light-subtle">
							<h6 class="fw-bold text-dark mb-2"><i class="bi bi-info-circle-fill text-primary me-2"></i><?php esc_html_e( 'Urgent Arena Inquiries', 'robo' ); ?></h6>
							<p class="text-muted small mb-0 lh-lg"><?php esc_html_e( 'For registered combat robotics arenas hosting active Sumo matches, emergency spare parts shipping runs are open on weekends.', 'robo' ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Google Map Section -->
	<section class="map-section mb-5">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="card border-0 shadow-sm overflow-hidden bg-white" style="height: 450px;">
				<iframe 
					src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3440.7107787313884!2d-97.74567228487611!3d30.2671529818021!2m3!1f0!2f0!3f0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8644b508d6b88b03%3A0xe5104fb8ad93c042!2sAustin%2C%20TX%2078701!5e0!3m2!1sen!2sus!4v1689163270000!5m2!1sen!2sus" 
					width="100%" 
					height="100%" 
					style="border:0; display: block;" 
					allowfullscreen="" 
					loading="lazy" 
					referrerpolicy="no-referrer-when-downgrade">
				</iframe>
			</div>
		</div>
	</section>

	<!-- FAQ Section (Accordion) -->
	<section class="contact-faq py-5 bg-light border-top border-bottom border-light-subtle mb-5">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row mb-5 text-center justify-content-center">
				<div class="col-lg-6">
					<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Common Questions', 'robo' ); ?></span>
					<h2 class="h1 fw-bold text-dark"><?php esc_html_e( 'Frequently Asked Questions', 'robo' ); ?></h2>
				</div>
			</div>
			
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="accordion accordion-flush bg-white rounded shadow-sm border border-light-subtle" id="contactFaqAccordion">
						
						<!-- FAQ 1 -->
						<div class="accordion-item border-bottom border-light-subtle">
							<h2 class="accordion-header" id="faq-heading-1">
								<button class="accordion-button fw-bold text-dark py-3.5 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-1" aria-expanded="true" aria-controls="faq-collapse-1">
									<?php esc_html_e( 'Are the sumo robot kits compliant with global competition specifications?', 'robo' ); ?>
								</button>
							</h2>
							<div id="faq-collapse-1" class="accordion-collapse collapse show" aria-labelledby="faq-heading-1" data-bs-parent="#contactFaqAccordion">
								<div class="accordion-body text-muted lh-lg small">
									<?php esc_html_e( 'Yes, our mini sumo robot kits are designed specifically to conform to the standard 10cm x 10cm footprint and 500g weight limits, making them competition-compliant for local and international sumo robot matches out of the box.', 'robo' ); ?>
								</div>
							</div>
						</div>

						<!-- FAQ 2 -->
						<div class="accordion-item border-bottom border-light-subtle">
							<h2 class="accordion-header" id="faq-heading-2">
								<button class="accordion-button collapsed fw-bold text-dark py-3.5 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-2" aria-expanded="false" aria-controls="faq-collapse-2">
									<?php esc_html_e( 'Do the battery cells come pre-charged or require special chargers?', 'robo' ); ?>
								</button>
							</h2>
							<div id="faq-collapse-2" class="accordion-collapse collapse" aria-labelledby="faq-heading-2" data-bs-parent="#contactFaqAccordion">
								<div class="accordion-body text-muted lh-lg small">
									<?php esc_html_e( 'For transit safety, LiPo cells are shipped at storage voltage (~3.8V per cell). You must use a dedicated LiPo balance charger to charge them before use. Charging instructions and safety manuals are included with every battery purchase.', 'robo' ); ?>
								</div>
							</div>
						</div>

						<!-- FAQ 3 -->
						<div class="accordion-item border-bottom border-light-subtle">
							<h2 class="accordion-header" id="faq-heading-3">
								<button class="accordion-button collapsed fw-bold text-dark py-3.5 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-3" aria-expanded="false" aria-controls="faq-collapse-3">
									<?php esc_html_e( 'Do you provide curriculum support or schemas for STEM teachers?', 'robo' ); ?>
								</button>
							</h2>
							<div id="faq-collapse-3" class="accordion-collapse collapse" aria-labelledby="faq-heading-3" data-bs-parent="#contactFaqAccordion">
								<div class="accordion-body text-muted lh-lg small">
									<?php esc_html_e( 'Absolutely! We specialize in STEM education support. Every workshop pack includes comprehensive wiring diagrams, step-by-step programming guides, and editable curriculum packets for classrooms.', 'robo' ); ?>
								</div>
							</div>
						</div>

						<!-- FAQ 4 -->
						<div class="accordion-item border-0">
							<h2 class="accordion-header" id="faq-heading-4">
								<button class="accordion-button collapsed fw-bold text-dark py-3.5 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-4" aria-expanded="false" aria-controls="faq-collapse-4">
									<?php esc_html_e( 'What is your refund policy on battle-damaged components?', 'robo' ); ?>
								</button>
							</h2>
							<div id="faq-collapse-4" class="accordion-collapse collapse" aria-labelledby="faq-heading-4" data-bs-parent="#contactFaqAccordion">
								<div class="accordion-body text-muted lh-lg small">
									<?php esc_html_e( 'While we stand by the high resilience of our chassis, we cannot offer warranty coverage for damage sustained during active arena matches. However, we carry a complete inventory of cheap replacement gears, sensors, and brackets to get you back in combat fast.', 'robo' ); ?>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA Section -->
	<section class="contact-cta py-5">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="card border-0 shadow-lg text-white p-5 text-center position-relative overflow-hidden rounded-4" style="background: linear-gradient(135deg, #0052FF 0%, #090F1d 100%) !important;">
				<div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 bg-grid" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 15px 15px;"></div>
				<div class="position-relative z-1 py-3">
					<h2 class="h1 fw-bold text-white mb-3"><?php esc_html_e( 'Looking for Bulk STEM School Discounts?', 'robo' ); ?></h2>
					<p class="lead text-white-50 max-width-600 mx-auto mb-4"><?php esc_html_e( 'We offer customized quotes, educational rates, and balance billing for approved school districts.', 'robo' ); ?></p>
					<a href="<?php echo esc_url( 'mailto:' . robo_get_company_info( 'support_email' ) ); ?>" class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm transition-all" style="background: #FFC84A !important; border: none !important; color: #16244B !important;"><?php esc_html_e( 'Request School Quote', 'robo' ); ?></a>
				</div>
			</div>
		</div>
	</section>
</div>

<?php
get_footer();
