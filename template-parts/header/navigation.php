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

$login_url = '';
$login_text = '';

if ( is_user_logged_in() ) {
	$login_text = esc_html__( 'My Account', 'robo' );
	if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_page_permalink' ) ) {
		$login_url = wc_get_page_permalink( 'myaccount' );
	} else {
		$login_url = admin_url( 'profile.php' );
	}
} else {
	$login_text = esc_html__( 'Login', 'robo' );
	if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_page_permalink' ) ) {
		$login_url = wc_get_page_permalink( 'myaccount' );
	} else {
		$login_url = wp_login_url();
	}
}

// Generate the HTML for the login menu item
$login_menu_item = sprintf(
	'<li class="menu-item nav-item"><a href="%s" class="nav-link">%s</a></li>',
	esc_url( $login_url ),
	esc_html( $login_text )
);

// Buffer the desktop expandable search template part
ob_start();
get_template_part( 'template-parts/header/search-bar', null, array( 'id_suffix' => 'desktop' ) );
$desktop_search_html = ob_get_clean();

// Generate the Search Toggle menu item for Desktop navigation
$search_menu_item = sprintf(
	'<li class="menu-item nav-item position-relative robo-search-nav-item d-none d-lg-flex align-items-center ms-lg-2">
		<button type="button" class="nav-link border-0 bg-transparent p-1 d-inline-flex align-items-center justify-content-center robo-search-toggle-btn text-dark hover-primary" aria-label="%s" aria-expanded="false">
			<i class="bi bi-search fs-5 search-open-icon"></i>
			<i class="bi bi-x-lg fs-5 search-close-icon d-none"></i>
		</button>
		<div class="robo-desktop-expandable-search position-absolute top-50 translate-middle-y">
			%s
		</div>
	</li>',
	esc_attr__( 'Toggle product search', 'robo' ),
	$desktop_search_html
);
?>
<nav class="navbar navbar-expand-lg py-3 navbar-light bg-white" aria-label="<?php esc_attr_e( 'Main Navigation', 'robo' ); ?>">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		
		<!-- Brand/Logo -->
		<div class="site-branding d-flex align-items-center me-lg-3">
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
			
			<!-- Mobile Menu Search Input (Visible at top of mobile menu when opened) -->
			<div class="d-lg-none w-100 mb-3 pt-2 robo-mobile-menu-search">
				<?php get_template_part( 'template-parts/header/search-bar', null, array( 'id_suffix' => 'mobile', 'is_mobile' => true ) ); ?>
			</div>

			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'depth'          => 3,
						'container'      => false,
						'menu_class'     => 'navbar-nav mx-auto mb-2 mb-lg-0 fw-medium align-items-lg-center',
						'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
						'walker'         => new Robo_WP_Bootstrap_Navwalker(),
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s' . $login_menu_item . $search_menu_item . '</ul>',
					)
				);
			} else {
				// Fallback to custom menu items or page list.
				$page_menu_filter = function( $menu ) use ( $login_menu_item, $search_menu_item ) {
					return str_replace( '</ul>', $login_menu_item . $search_menu_item . '</ul>', $menu );
				};
				add_filter( 'wp_page_menu', $page_menu_filter );
				wp_page_menu(
					array(
						'menu_class'  => 'navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center',
						'before'      => '',
						'after'       => '',
						'show_home'   => true,
						'link_before' => '<span class="nav-link">',
						'link_after'  => '</span>',
					)
				);
				remove_filter( 'wp_page_menu', $page_menu_filter );
			}
			?>

			<!-- Right Actions (Call / CTA) -->
			<div class="d-flex align-items-center gap-3 mt-3 mt-lg-0 flex-column flex-lg-row align-self-stretch align-self-lg-center">
				<?php if ( ! empty( $cta_text ) ) : ?>
					<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary w-100 w-lg-auto shadow-sm rounded-pill px-4">
						<?php echo esc_html( $cta_text ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</nav>
