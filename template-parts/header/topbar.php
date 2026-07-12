<?php
/**
 * Template part for displaying the topbar.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

// Retrieve social links.
$social_keys = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube' );
$has_social  = false;
foreach ( $social_keys as $key ) {
	if ( get_theme_mod( "robo_social_{$key}" ) ) {
		$has_social = true;
		break;
	}
}
?>
<div class="topbar bg-light py-2 border-bottom d-none d-lg-block">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row align-items-center">
			<div class="col-md-6 d-flex align-items-center">
				<span class="text-muted small me-4 d-flex align-items-center gap-1">
					<?php echo robo_get_svg( 'phone', 'text-primary' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php esc_html_e( 'Call Us: +1 (555) 867-5309', 'robo' ); ?>
				</span>
				<?php if ( has_nav_menu( 'topbar' ) ) : ?>
					<nav class="topbar-nav" aria-label="<?php esc_attr_e( 'Topbar Navigation', 'robo' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'topbar',
								'menu_class'     => 'list-inline mb-0 small',
								'container'      => false,
								'fallback_cb'    => false,
								'depth'          => 1,
								'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
								'link_before'    => '<span class="list-inline-item me-3 text-decoration-none text-muted">',
								'link_after'     => '</span>',
							)
						);
						?>
					</nav>
				<?php endif; ?>
			</div>
			<div class="col-md-6 text-end">
				<?php if ( $has_social ) : ?>
					<div class="topbar-socials d-inline-flex gap-3 align-items-center">
						<?php
						foreach ( $social_keys as $key ) {
							$url = get_theme_mod( "robo_social_{$key}" );
							if ( $url ) {
								printf(
									'<a href="%1$s" class="text-muted hover-primary" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s</a>',
									esc_url( $url ),
									esc_attr( ucfirst( $key ) ),
									robo_get_svg( $key, 'bi' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								);
							}
						}
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
