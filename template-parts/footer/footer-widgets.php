<?php
/**
 * Template part for displaying footer widgets.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

// Count how many footer sidebars are active.
$active_sidebars = 0;
for ( $i = 1; $i <= 4; $i++ ) {
	if ( is_active_sidebar( 'footer-widget-' . $i ) ) {
		$active_sidebars++;
	}
}



// Calculate Bootstrap columns based on active widget areas.
$col_class = 'col-lg-3 col-md-6 col-12';
if ( 1 === $active_sidebars ) {
	$col_class = 'col-12';
} elseif ( 2 === $active_sidebars ) {
	$col_class = 'col-md-6';
} elseif ( 3 === $active_sidebars ) {
	$col_class = 'col-lg-4 col-md-6';
}
?>
<div class="footer-widgets mb-4">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row g-4">
			<?php if ( $active_sidebars > 0 ) : ?>
				<?php
				$col_class = 'col-lg-3 col-md-6 col-12';
				if ( 1 === $active_sidebars ) {
					$col_class = 'col-12';
				} elseif ( 2 === $active_sidebars ) {
					$col_class = 'col-md-6';
				} elseif ( 3 === $active_sidebars ) {
					$col_class = 'col-lg-4 col-md-6';
				}
				for ( $i = 1; $i <= 4; $i++ ) {
					if ( is_active_sidebar( 'footer-widget-' . $i ) ) :
						?>
						<div class="<?php echo esc_attr( $col_class ); ?>">
							<?php dynamic_sidebar( 'footer-widget-' . $i ); ?>
						</div>
						<?php
					endif;
				}
				?>
			<?php else : ?>
				<!-- Premium Fallback Robotics Footer Columns -->
				
				<!-- Column 1: About Brand -->
				<div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
					<h5 class="fw-bold mb-3 text-uppercase tracking-wider" style="font-size: 0.85rem; letter-spacing: 0.5px; color: #9001fb !important;">
						<span class="text-primary">Robo </span>Scaler
					</h5>
					<p class="text-muted small mb-4 lh-lg" style="max-width: 320px;">
						Engineered for competition, designed for innovators. We supply high-performance mini sumo bots, drone kits, and high-discharge battery cells to STEM classrooms and professional arenas.
					</p>
					<span class="small text-muted d-block">
						<i class="bi bi-shield-fill-check text-primary me-2"></i><?php esc_html_e( '100% Secure Checkout', 'robo' ); ?>
					</span>
				</div>

				<!-- Column 2: Quick Shop Links -->
				<div class="col-lg-2 col-md-6 col-6 mb-4 mb-lg-0">
					<h5 class="fw-bold text-white mb-3 text-uppercase tracking-wider" style="font-size: 0.85rem; letter-spacing: 0.5px;">
						<?php esc_html_e( 'Shop Pages', 'robo' ); ?>
					</h5>
					<ul class="list-unstyled d-flex flex-column gap-2 small">
						<li><a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>" class="text-muted text-decoration-none hover-primary"><?php esc_html_e( 'All Products', 'robo' ); ?></a></li>
						<li><a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'cart' ) : home_url( '/' ) ); ?>" class="text-muted text-decoration-none hover-primary"><?php esc_html_e( 'View Cart', 'robo' ); ?></a></li>
						<li><a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'checkout' ) : home_url( '/' ) ); ?>" class="text-muted text-decoration-none hover-primary"><?php esc_html_e( 'Checkout', 'robo' ); ?></a></li>
						<li><a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' ) ); ?>" class="text-muted text-decoration-none hover-primary"><?php esc_html_e( 'My Account', 'robo' ); ?></a></li>
					</ul>
				</div>

				<!-- Column 3: Custom Kits Categories -->
				<div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-0">
					<h5 class="fw-bold text-white mb-3 text-uppercase tracking-wider" style="font-size: 0.85rem; letter-spacing: 0.5px;">
						<?php esc_html_e( 'Categories', 'robo' ); ?>
					</h5>
					<ul class="list-unstyled d-flex flex-column gap-2 small">
						<li><a href="<?php echo esc_url( ( class_exists( 'WooCommerce' ) && get_post_type_archive_link( 'product' ) ) ? get_post_type_archive_link( 'product' ) : home_url( '/' ) ); ?>" class="text-muted text-decoration-none hover-primary"><?php esc_html_e( 'Mini Sumo Bots', 'robo' ); ?></a></li>
						<li><a href="<?php echo esc_url( ( class_exists( 'WooCommerce' ) && get_post_type_archive_link( 'product' ) ) ? get_post_type_archive_link( 'product' ) : home_url( '/' ) ); ?>" class="text-muted text-decoration-none hover-primary"><?php esc_html_e( 'Racing Drones', 'robo' ); ?></a></li>
						<li><a href="<?php echo esc_url( ( class_exists( 'WooCommerce' ) && get_post_type_archive_link( 'product' ) ) ? get_post_type_archive_link( 'product' ) : home_url( '/' ) ); ?>" class="text-muted text-decoration-none hover-primary"><?php esc_html_e( 'LiPo Batteries', 'robo' ); ?></a></li>
						<li><a href="<?php echo esc_url( ( class_exists( 'WooCommerce' ) && get_post_type_archive_link( 'product' ) ) ? get_post_type_archive_link( 'product' ) : home_url( '/' ) ); ?>" class="text-muted text-decoration-none hover-primary"><?php esc_html_e( 'Controller Boards', 'robo' ); ?></a></li>
					</ul>
				</div>

				<!-- Column 4: Contact Details -->
				<div class="col-lg-3 col-md-6 col-12">
					<h5 class="fw-bold text-white mb-3 text-uppercase tracking-wider" style="font-size: 0.85rem; letter-spacing: 0.5px;">
						<?php esc_html_e( 'Engineering Lab', 'robo' ); ?>
					</h5>
					<p class="text-muted small mb-2 lh-lg">
						<i class="bi bi-geo-alt-fill text-primary me-2"></i><a href="<?php echo esc_url( robo_get_company_info( 'maps_url' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none hover-primary"><?php echo esc_html( robo_get_company_info( 'address' ) ); ?></a>
					</p>
					<p class="text-muted small mb-2">
						<i class="bi bi-envelope-fill text-primary me-2"></i><a href="<?php echo esc_url( 'https://mail.google.com/mail/?view=cm&fs=1&to=' . robo_get_company_info( 'support_email' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none hover-primary"><?php echo esc_html( robo_get_company_info( 'support_email' ) ); ?></a>
					</p>
					<p class="text-muted small mb-2">
						<i class="bi bi-telephone-fill text-primary me-2"></i><a href="<?php echo esc_url( 'tel:' . str_replace( ' ', '', robo_get_company_info( 'phone_number' ) ) ); ?>" class="text-decoration-none hover-primary"><?php echo esc_html( robo_get_company_info( 'phone_number' ) ); ?></a>
					</p>
					<p class="text-muted small mb-2">
						<i class="bi bi-whatsapp text-primary me-2"></i><a href="<?php echo esc_url( robo_get_company_info( 'whatsapp_url' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none hover-primary"><?php esc_html_e( 'WhatsApp', 'robo' ); ?></a>
					</p>
					<p class="text-muted small mb-2">
						<i class="bi bi-instagram text-primary me-2"></i><a href="<?php echo esc_url( robo_get_company_info( 'instagram_url' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none hover-primary"><?php esc_html_e( 'Instagram', 'robo' ); ?></a>
					</p>
					<p class="text-muted small mb-0">
						<i class="bi bi-youtube text-primary me-2"></i><a href="<?php echo esc_url( robo_get_company_info( 'youtube_url' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none hover-primary"><?php echo esc_html( robo_get_company_info( 'youtube_name' ) ); ?></a>
					</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
