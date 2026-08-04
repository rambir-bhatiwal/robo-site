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
$container_class = get_theme_mod( 'robo_container_width', 'container' );

// Retrieve hero background image using WordPress native functions.
$bg_image_raw = get_theme_mod( 'robo_hero_bg_image', '' );
$bg_image_url = '';

if ( ! empty( $bg_image_raw ) ) {
	if ( is_numeric( $bg_image_raw ) ) {
		$bg_image_url = wp_get_attachment_image_url( (int) $bg_image_raw, 'full' );
	} else {
		$attachment_id = attachment_url_to_postid( $bg_image_raw );
		if ( $attachment_id ) {
			$bg_image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
		} else {
			$bg_image_url = esc_url( $bg_image_raw );
		}
	}
}

// Retrieve hero background overlay settings.
$overlay_enable  = get_theme_mod( 'robo_hero_overlay_enable', false );
$overlay_color   = get_theme_mod( 'robo_hero_overlay_color', '#000000' );
$overlay_opacity = get_theme_mod( 'robo_hero_overlay_opacity', '0.3' );

$hero_style   = '';
$hero_classes = array( 'hero-section' );

if ( ! empty( $bg_image_url ) ) {
	$hero_classes[] = 'has-hero-bg-image';
	$hero_style     = sprintf(
		'style="background-image: url(\'%s\'); background-size: cover; background-position: center center; background-repeat: no-repeat;"',
		esc_url( $bg_image_url )
	);
}
?>

<section id="hero" class="<?php echo esc_attr( implode( ' ', $hero_classes ) ); ?>" <?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( ! empty( $bg_image_url ) && $overlay_enable ) : ?>
		<?php
		$rgb = sscanf( $overlay_color, '#%02x%02x%02x' );
		if ( $rgb && 3 === count( $rgb ) ) {
			$rgba = sprintf( 'rgba(%d, %d, %d, %s)', $rgb[0], $rgb[1], $rgb[2], esc_attr( $overlay_opacity ) );
		} else {
			$rgba = 'rgba(0, 0, 0, ' . esc_attr( $overlay_opacity ) . ')';
		}
		?>
		<div class="hero-bg-overlay" style="background-color: <?php echo esc_attr( $rgba ); ?>;"></div>
	<?php endif; ?>
	<div class="<?php echo esc_attr( $container_class ); ?>">
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