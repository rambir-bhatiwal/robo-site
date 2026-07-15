<?php
/**
 * Template Name: Contact Us
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<div class="contact-template-wrapper bg-light-subtle pb-5">
	<!-- Hero Section -->
	<section class="contact-hero bg-dark text-white py-5 text-center position-relative overflow-hidden mb-5">
		<div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 bg-grid" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 20px 20px;"></div>
		<div class="<?php echo esc_attr( $container_class ); ?> position-relative z-1 py-4">
			<h1 class="display-4 fw-extrabold text-white mb-2"><?php the_title(); ?></h1>
			<p class="lead text-white-50 max-width-600 mx-auto mb-0"><?php esc_html_e( 'Have questions about kits, combat components, or custom designs? Get in touch.', 'robo' ); ?></p>
		</div>
	</section>

	<!-- Contact Info Cards -->
	<section class="contact-info-cards mb-5">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row g-4">
				<!-- Address -->
				<div class="col-lg-3 col-sm-6">
					<div class="card border-0 shadow-sm p-4 h-100 bg-white text-center hover-up transition-all" style="transition: all 0.3s ease-in-out;">
						<div class="icon-box text-primary mb-3 bg-primary-subtle rounded-circle p-3 d-inline-flex align-items-center justify-content-center mx-auto" style="width: 52px; height: 52px;">
							<i class="bi bi-geo-alt-fill fs-4"></i>
						</div>
						<h6 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Our Laboratory', 'robo' ); ?></h6>
						<p class="text-muted small mb-0">
							<a href="https://maps.google.com/?q=100+Robotics+Way,+Austin,+TX+78701" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted">
								<?php esc_html_e( '100 Robotics Way, Austin, TX 78701', 'robo' ); ?>
							</a>
						</p>
					</div>
				</div>
				<!-- Phone -->
				<div class="col-lg-3 col-sm-6">
					<div class="card border-0 shadow-sm p-4 h-100 bg-white text-center hover-up transition-all" style="transition: all 0.3s ease-in-out;">
						<div class="icon-box text-success mb-3 bg-success-subtle rounded-circle p-3 d-inline-flex align-items-center justify-content-center mx-auto" style="width: 52px; height: 52px;">
							<i class="bi bi-telephone-fill fs-4"></i>
						</div>
						<h6 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Call Us', 'robo' ); ?></h6>
						<p class="text-muted small mb-0">
							<a href="tel:+15558675309" class="text-decoration-none text-muted">
								<?php esc_html_e( '+1 (555) 867-5309', 'robo' ); ?>
							</a>
						</p>
					</div>
				</div>
				<!-- Email -->
				<div class="col-lg-3 col-sm-6">
					<div class="card border-0 shadow-sm p-4 h-100 bg-white text-center hover-up transition-all" style="transition: all 0.3s ease-in-out;">
						<div class="icon-box text-info mb-3 bg-info-subtle rounded-circle p-3 d-inline-flex align-items-center justify-content-center mx-auto" style="width: 52px; height: 52px;">
							<i class="bi bi-envelope-fill fs-4"></i>
						</div>
						<h6 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Email Support', 'robo' ); ?></h6>
						<p class="text-muted small mb-0">
							<a href="https://mail.google.com/mail/?view=cm&fs=1&to=support@example.com" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted">
								<?php esc_html_e( 'support@example.com', 'robo' ); ?>
							</a>
						</p>
					</div>
				</div>
				<!-- Business Hours -->
				<div class="col-lg-3 col-sm-6">
					<div class="card border-0 shadow-sm p-4 h-100 bg-white text-center hover-up transition-all" style="transition: all 0.3s ease-in-out;">
						<div class="icon-box text-warning mb-3 bg-warning-subtle rounded-circle p-3 d-inline-flex align-items-center justify-content-center mx-auto" style="width: 52px; height: 52px;">
							<i class="bi bi-clock-fill fs-4"></i>
						</div>
						<h6 class="fw-bold text-dark mb-2"><?php esc_html_e( 'Support Hours', 'robo' ); ?></h6>
						<p class="text-muted small mb-0"><?php esc_html_e( 'Mon - Fri: 9am - 6pm EST', 'robo' ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Map & Form Grid -->
	<section class="map-form-section mb-5 py-3">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row g-4">
				<!-- Form Area -->
				<div class="col-lg-7">
					<div class="card border-0 shadow-sm p-4 p-md-5 h-100 bg-white">
						<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Contact Form', 'robo' ); ?></span>
						<h2 class="h2 fw-bold text-dark mb-4"><?php esc_html_e( '1Send Us a Message', 'robo' ); ?></h2>
						
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
							<form action="#" method="post" class="needs-validation" novalidate>
								<div class="row g-3">
									<div class="col-md-6">
										<label for="contact_name" class="form-label small fw-bold text-muted"><?php esc_html_e( 'Your Name', 'robo' ); ?></label>
										<input type="text" class="form-control" id="contact_name" name="contact_name" required placeholder="<?php esc_attr_e( 'e.g. John Doe', 'robo' ); ?>">
									</div>
									<div class="col-md-6">
										<label for="contact_email" class="form-label small fw-bold text-muted"><?php esc_html_e( 'Your Email', 'robo' ); ?></label>
										<input type="email" class="form-control" id="contact_email" name="contact_email" required placeholder="<?php esc_attr_e( 'e.g. john@example.com', 'robo' ); ?>">
									</div>
									<div class="col-12">
										<label for="contact_subject" class="form-label small fw-bold text-muted"><?php esc_html_e( 'Subject', 'robo' ); ?></label>
										<input type="text" class="form-control" id="contact_subject" name="contact_subject" required placeholder="<?php esc_attr_e( 'e.g. Kit Inquiry', 'robo' ); ?>">
									</div>
									<div class="col-12">
										<label for="contact_message" class="form-label small fw-bold text-muted"><?php esc_html_e( 'Message', 'robo' ); ?></label>
										<textarea class="form-control" id="contact_message" name="contact_message" rows="5" required placeholder="<?php esc_attr_e( 'Describe your requirements...', 'robo' ); ?>"></textarea>
									</div>
									<div class="col-12 mt-4">
										<button type="submit" class="btn btn-primary robo-btn w-100 shadow-sm transition-all"><?php esc_html_e( 'Send Message', 'robo' ); ?></button>
									</div>
								</div>
							</form>

							
							<?php
						}
						?>
					</div>
				</div>

				<!-- Google Map Placeholder -->
				<div class="col-lg-5">
					<div class="card border-0 shadow-sm overflow-hidden h-100 bg-white" style="min-height: 400px;">
						<iframe 
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3440.7107787313884!2d-97.74567228487611!3d30.2671529818021!2m3!1f0!2f0!3f0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8644b508d6b88b03%3A0xe5104fb8ad93c042!2sAustin%2C%20TX%2078701!5e0!3m2!1sen!2sus!4v1689163270000!5m2!1sen!2sus" 
							width="100%" 
							height="100%" 
							style="border:0; min-height: 400px; display: block;" 
							allowfullscreen="" 
							loading="lazy" 
							referrerpolicy="no-referrer-when-downgrade">
						</iframe>
					</div>
				</div>
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
					<a href="mailto:education@example.com" class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm transition-all" style="background: #FFC84A !important; border: none !important; color: #16244B !important;"><?php esc_html_e( 'Request School Quote', 'robo' ); ?></a>
				</div>
			</div>
		</div>
	</section>
</div>

<?php
get_footer();
