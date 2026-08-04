<?php
/**
 * Template part for displaying the Hero section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_image   = get_header_image();
if ( empty( $hero_image ) ) {
	$hero_image = 'https://app.roboscaler.com/wp-content/uploads/2026/07/513ac378-2fee-4500-8756-c9fb74781012.png';
}

$btn1_url      = get_theme_mod( 'robo_hero_btn1_url', '#popular-products' );

$hero_style = '';
$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<section id="hero" class="hero-section" <?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="<?php echo esc_attr($container_class); ?>">
		<div class="row align-items-center hero-main-row">
			
			<!-- LEFT -->
			<div class="col-6 col-lg-5 hero-left-content">
				<span class="hero-badge">
					🤖 Robotics Kit
				</span>

				<h1 class="hero-title">
					Mini Sumo
					<span>Robot</span>
				</h1>

				<p class="hero-text">
					Build, Code & Compete with India's most advanced Mini Sumo Robot kit.
				</p>

				<a href="<?php echo esc_url($btn1_url); ?>" class="btn hero-btn robo-btn">
					Explore Robots →
				</a>
			</div>

			<!-- RIGHT -->
			<div class="col-6 col-lg-7 hero-right-content">
				<div class="robot-wrapper">
					<div class="glow"></div>
					<div class="ring ring1"></div>
					<div class="ring ring2"></div>
					<div class="grid"></div>
					<div class="particle p1"></div>
					<div class="particle p2"></div>
					<div class="particle p3"></div>
					<div class="particle p4"></div>
					<div class="particle p5"></div>

					<img src="<?php echo esc_url( $hero_image ); ?>" class="robot-img" alt="Mini Sumo Robot">
				</div>
			</div>

		</div>
	</div>
</section>