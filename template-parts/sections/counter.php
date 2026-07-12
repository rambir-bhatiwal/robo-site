<?php
/**
 * Template part for displaying the Counter section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

$counters = array(
	array(
		'count' => '2500+',
		'label' => esc_html__( 'Active Builders', 'robo' ),
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16"><path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.88-1.055l-.158-.045c.078-.444.115-.89.115-1.343a4 4 0 1 0-8 0c0 .452.037.898.115 1.343l-.158.045a6 6 0 0 0-1.88 1.055A1 1 0 0 0 0 10v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V10a5 5 0 0 1 1.048-3.064c.025-.03.051-.057.078-.08C4.7 7.74 5.7 8 7 8c.135 0 .267-.002.396-.006a5 5 0 0 1 1.037 3.07v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V10a1 1 0 0 0-.496-.868zM2.5 3a2 2 0 1 0 0 4 2 2 0 0 0 0-4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/></svg>',
	),
	array(
		'count' => '4500+',
		'label' => esc_html__( 'Robots Built', 'robo' ),
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-robot" viewBox="0 0 16 16"><path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5M3 8.062C3 5.176 5.235 3 8 3s5 2.176 5 5.062c0 .937-.294 1.704-.737 2.22-.44.513-.996.883-1.576 1.134-.143.06-.29.117-.442.172v.917h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1h1v-.917c-.152-.055-.3-.112-.442-.172a6 6 0 0 1-1.576-1.134C3.294 9.766 3 9 3 8.062m5-4.062C5.765 4 4 5.765 4 8c0 .708.204 1.254.502 1.6A2.5 2.5 0 0 0 6.5 11h3a2.5 2.5 0 0 0 1.998-1.4c.298-.346.502-.892.502-1.6 0-2.235-1.765-4-4-4"/></svg>',
	),
	array(
		'count' => '1200+',
		'label' => esc_html__( 'Battles Won', 'robo' ),
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-award" viewBox="0 0 16 16"><path d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 16l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 14l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.248-1.506 1.086-1.072.684-1.365 1.51-.229L8 2l1.355.702z"/><path d="M4 6a4 4 0 1 1 8 0 4 4 0 0 1-8 0m4.5-3a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7"/></svg>',
	),
	array(
		'count' => '99.8%',
		'label' => esc_html__( 'Shipping Rating', 'robo' ),
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16"><path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.848 1.2a7 7 0 0 0-.29-.415l.75-.66a8 8 0 0 1 .648.924zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/></svg>',
	),
);
?>
<section id="counter" class="counter-section py-5 text-white bg-dark">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		<div class="row g-4 text-center">
			<?php foreach ( $counters as $item ) : ?>
				<div class="col-lg-3 col-sm-6">
					<div class="counter-card p-4 border border-secondary border-opacity-10 bg-black bg-opacity-20 rounded-3">
						<div class="counter-icon text-primary mb-3 d-inline-block">
							<?php echo $item['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<h3 class="display-4 fw-extrabold text-white mb-1"><?php echo esc_html( $item['count'] ); ?></h3>
						<p class="text-white-50 small text-uppercase tracking-wider mb-0 fw-semibold"><?php echo esc_html( $item['label'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
