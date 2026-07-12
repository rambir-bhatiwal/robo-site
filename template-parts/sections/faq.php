<?php
/**
 * Template part for displaying the FAQ section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

$faqs = array(
	array(
		'q' => esc_html__( 'Do your robotics kits require soldering?', 'robo' ),
		'a' => esc_html__( 'Most of our educational and starter kits feature solderless connections with pre-crimped JST connectors. However, our pro combat kits and FPV drone kits may require basic soldering for power distribution boards and motors.', 'robo' ),
	),
	array(
		'q' => esc_html__( 'Are the batteries included with the kits?', 'robo' ),
		'a' => esc_html__( 'To comply with shipping regulations, lithium-polymer (LiPo) batteries are sold separately. You can purchase compatible battery packs directly in our batteries category.', 'robo' ),
	),
	array(
		'q' => esc_html__( 'Do you ship replacement parts for sumo bots and drones?', 'robo' ),
		'a' => esc_html__( 'Absolutely! We maintain a complete inventory of gears, spare silicon tires, micro motors, chassis plates, and remote controllers so you can repair your robot quickly after competition damage.', 'robo' ),
	),
	array(
		'q' => esc_html__( 'What programming languages do your controllers support?', 'robo' ),
		'a' => esc_html__( 'Our controller boards are fully compatible with Arduino (C/C++), ESP-IDF, and MicroPython. We provide sample firmware loops and sensor libraries on our blog to help you get started.', 'robo' ),
	),
);
?>
<section id="faq" class="faq-section py-5 bg-light border-top border-bottom border-light-subtle">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		
		<!-- Section Header -->
		<div class="row mb-5 justify-content-center text-center">
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Questions?', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-3"><?php esc_html_e( 'Frequently Asked Questions', 'robo' ); ?></h2>
				<p class="text-muted"><?php esc_html_e( 'Got questions about setup, configuration, customization, or performance? Check out our quick answers below.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Accordion FAQ -->
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="accordion accordion-flush shadow-sm rounded-3 overflow-hidden" id="faqAccordion">
					<?php foreach ( $faqs as $index => $faq ) : ?>
						<div class="accordion-item border-bottom border-light-subtle">
							<h3 class="accordion-header" id="faq-heading-<?php echo esc_attr( $index ); ?>">
								<button class="accordion-button collapsed fw-bold text-dark py-4 px-4 shadow-none bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-<?php echo esc_attr( $index ); ?>" aria-expanded="false" aria-controls="faq-collapse-<?php echo esc_attr( $index ); ?>">
									<?php echo esc_html( $faq['q'] ); ?>
								</button>
							</h3>
							<div id="faq-collapse-<?php echo esc_attr( $index ); ?>" class="accordion-collapse collapse" aria-labelledby="faq-heading-<?php echo esc_attr( $index ); ?>" data-bs-parent="#faqAccordion">
								<div class="accordion-body text-muted py-4 px-4 bg-white fs-6">
									<?php echo esc_html( $faq['a'] ); ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

	</div>
</section>
