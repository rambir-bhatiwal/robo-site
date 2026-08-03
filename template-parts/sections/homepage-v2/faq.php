<?php
/**
 * Homepage V2 - Section 17: FAQ (Frequently Asked Questions)
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faqs = array(
	array(
		'q' => 'What age group are your STEM & Robotics kits suitable for?',
		'a' => 'Our kits are designed for learners aged 8 and above. Beginner kits utilize color-coded plug-and-play modules and visual Scratch block programming, while advanced AI & IoT kits support C++ and Python for high school, college, and maker projects.',
	),
	array(
		'q' => 'Do I need prior coding or soldering experience to get started?',
		'a' => 'No prior experience is required! All our starter kits come with pre-soldered shields, color-coded wires, and step-by-step HD video tutorials that guide you from unboxing to running your first program.',
	),
	array(
		'q' => 'What warranty and technical support do you provide?',
		'a' => 'All hardware items include a 1-Year Warranty against manufacturing defects. If you face any issues during assembly or coding, our dedicated engineering team is available 24/7 via WhatsApp and Email support.',
	),
	array(
		'q' => 'Do you offer bulk discounts and custom lab packages for schools?',
		'a' => 'Yes! We provide complete turn-key STEM lab setups, custom component bundles, teacher training certifications, and institutional invoice discounts for schools, colleges, and robotics clubs.',
	),
	array(
		'q' => 'How long does shipping take?',
		'a' => 'Orders are dispatched within 24 hours. Delivery typically takes 2–4 business days across India, with real-time SMS and WhatsApp tracking.',
	),
);
?>
<section class="robo-v2-section bg-white">
	<div class="container">
		<div class="text-center mb-5 fade-in-up">
			<span class="robo-v2-badge mb-2">Got Questions?</span>
			<h2 class="robo-v2-section-title text-dark">
				Frequently Asked <span class="robo-v2-gradient-text">Questions</span>
			</h2>
			<p class="robo-v2-section-desc">
				Find quick answers to common questions about our robotics kits, STEM curriculum, and institutional support.
			</p>
		</div>

		<div class="row justify-content-center">
			<div class="col-lg-8 fade-in-up">
				<div class="robo-v2-faq-wrapper">
					<?php foreach ( $faqs as $index => $faq ) : ?>
						<div class="robo-v2-faq-item robo-v2-card p-4 mb-3 <?php echo $index === 0 ? 'active' : ''; ?>">
							<div class="robo-v2-faq-question d-flex align-items-center justify-content-between cursor-pointer">
								<h5 class="fw-bold fs-6 text-dark mb-0 me-3"><?php echo esc_html( $faq['q'] ); ?></h5>
								<i class="bi bi-chevron-down text-primary transition-all"></i>
							</div>
							<div class="robo-v2-faq-answer pt-3 text-muted small" style="<?php echo $index === 0 ? 'display: block;' : 'display: none;'; ?> line-height: 1.7;">
								<?php echo esc_html( $faq['a'] ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
