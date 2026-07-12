<?php
/**
 * Template part for displaying the primary navigation.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
$cta_text        = get_theme_mod( 'robo_hero_btn1_text', esc_html__( 'Get Started', 'robo' ) );
$cta_url         = get_theme_mod( 'robo_hero_btn1_url', '#contact' );
?>
<nav class="navbar navbar-expand-lg py-3 navbar-light bg-white" aria-label="<?php esc_attr_e( 'Main Navigation', 'robo' ); ?>">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		
		<!-- Brand/Logo -->
		<div class="site-branding d-flex align-items-center">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				?>
				<a class="navbar-brand fw-bold fs-3 text-dark text-decoration-none d-flex align-items-center gap-2" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="text-primary">Robo</span>
				</a>
				<?php
			}
			?>
		</div>

		<!-- Toggler for Mobile Menu -->
		<button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNavbar" aria-controls="primaryNavbar" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'robo' ); ?>">
			<span class="navbar-toggler-icon"></span>
		</button>

		<!-- Collapsible Navbar Content -->
		<div class="collapse navbar-collapse" id="primaryNavbar">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'depth'          => 3,
						'container'      => false,
						'menu_class'     => 'navbar-nav mx-auto mb-2 mb-lg-0 fw-medium',
						'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
						'walker'         => new Robo_WP_Bootstrap_Navwalker(),
					)
				);
			} else {
				// Fallback to custom menu items or page list.
				wp_page_menu(
					array(
						'menu_class'  => 'navbar-nav mx-auto mb-2 mb-lg-0',
						'before'      => '',
						'after'       => '',
						'show_home'   => true,
						'link_before' => '<span class="nav-link">',
						'link_after'  => '</span>',
					)
				);
			}
			?>

			<!-- Right Actions (Search & Call & CTA) -->
			<div class="d-flex align-items-center gap-3 mt-3 mt-lg-0 flex-column flex-lg-row align-self-stretch align-self-lg-center">
				
				<!-- Search Icon/Form Toggle -->
				<!-- <div class="header-search-wrapper position-relative w-100 w-lg-auto text-center">
					<button class="btn btn-outline-secondary btn-sm rounded-circle d-none d-lg-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" type="button" data-bs-toggle="collapse" data-bs-target="#headerSearchCollapse" aria-expanded="false" aria-controls="headerSearchCollapse" aria-label="<?php // esc_attr_e( 'Search', 'robo' ); ?>">
						<?php // echo robo_get_svg( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button> -->
					
					<!-- Collapsible Search Bar (Desktop) -->
					<!-- <div class="collapse position-absolute end-0 mt-3 bg-white p-3 rounded shadow border z-3" id="headerSearchCollapse" style="width: 300px;">
						<?php // get_search_form(); ?>
					</div> -->
					
					<!-- Inline Search for Mobile -->
					<!-- <div class="d-block d-lg-none w-100">
						<?php // get_search_form(); ?>
					</div>
				</div> -->

				<!-- Call Action -->
				<!-- <a href="tel:+15558675309" class="btn btn-outline-primary w-100 w-lg-auto d-flex align-items-center justify-content-center gap-2">
					<?php // echo robo_get_svg( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php // esc_html_e( 'Call Now', 'robo' ); ?></span>
				</a> -->

				<!-- CTA Button -->
				<?php //  if ( ! empty( $cta_text ) ) : ?>
					<!-- <a href="<?php //  echo esc_url( $cta_url ); ?>" class="btn btn-primary w-100 w-lg-auto shadow-sm">
						<?php //  echo esc_html( $cta_text ); ?>
					</a> -->
				<?php //  endif; ?>
			</div>
		</div>
	</div>
</nav>
