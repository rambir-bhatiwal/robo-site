<?php
/**
 * Template part for displaying the About Us CTA / Closing section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
$cta_bg_img      = robo_get_about_image( 'cta' );
$shop_url        = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
?>
<section class="about-cta-section my-4 overflow-hidden">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="card border-0 shadow-lg text-white p-4 p-md-5 text-center position-relative overflow-hidden rounded-4" style="background: linear-gradient(135deg, #0052FF 0%, #090F1d 100%) !important;">
			<?php if ( ! empty( $cta_bg_img ) ) : ?>
				<div class="position-absolute top-0 start-0 w-100 h-100 opacity-25 object-fit-cover" style="background-image: url('<?php echo esc_url( $cta_bg_img ); ?>'); background-size: cover; background-position: center;"></div>
			<?php endif; ?>
			<div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 bg-grid" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 15px 15px;"></div>
			<div class="position-relative z-1 py-2 max-width-800 mx-auto">
				<p class="lead text-white fs-4 lh-base mb-3 fw-medium">
					<?php esc_html_e( 'Thank you for visiting RoboScaler. We look forward to being a part of your robotics journey and helping you turn your ideas into working projects.', 'robo' ); ?>
				</p>
				<a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-warning btn-lg px-4 py-2 fw-bold rounded-pill shadow-sm transition-all text-dark" style="background: #FFC84A !important; border: none !important; color: #16244B !important;">
					<?php esc_html_e( 'Explore Our Products', 'robo' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>
