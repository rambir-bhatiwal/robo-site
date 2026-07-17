<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
$copyright_text  = get_theme_mod( 'robo_copyright_text', '© ' . date( 'Y' ) . ' RoboScaler. All rights reserved.' );

$social_links = array(
	'whatsapp'  => robo_get_company_info( 'whatsapp_url' ),
	'instagram' => robo_get_company_info( 'instagram_url' ),
	'youtube'   => robo_get_company_info( 'youtube_url' ),
);
$has_social  = false;
foreach ( $social_links as $key => $url ) {
	if ( ! empty( $url ) ) {
		$has_social = true;
		break;
	}
}
?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer bg-dark text-light pt-5 pb-4 border-top border-secondary border-opacity-25">
		
		<!-- Footer Widgets -->
		<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

		<!-- Footer Bottom Bar -->
		<div class="footer-bottom border-top border-secondary border-opacity-10 pt-4 mt-4">
			<div class="container">
				<div class="row align-items-center">
					
					<!-- Copyright -->
					<div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
						<span class="small text-muted">
							<?php echo wp_kses_post( $copyright_text ); ?>
						</span>
					</div>

					<!-- Footer Navigation Menu -->
					<div class="col-md-4 text-center mb-3 mb-md-0">
						<?php if ( has_nav_menu( 'footer' ) ) : ?>
							<nav aria-label="<?php esc_attr_e( 'Footer Navigation', 'robo' ); ?>">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'footer',
										'menu_class'     => 'list-inline mb-0 justify-content-center d-flex gap-3 flex-wrap',
										'container'      => false,
										'depth'          => 1,
										'fallback_cb'    => false,
										'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
										'link_before'    => '<span class="text-decoration-none text-muted small hover-primary">',
										'link_after'     => '</span>',
									)
								);
								?>
							</nav>
						<?php endif; ?>
					</div>

					<!-- Social Icons -->
					<div class="col-md-4 text-center text-md-end">
						<?php if ( $has_social ) : ?>
							<div class="footer-socials d-inline-flex gap-3">
								<?php
								foreach ( $social_links as $key => $url ) {
									if ( $url ) {
										printf(
											'<a href="%1$s" class="text-muted hover-primary" target="_blank" rel="noopener noreferrer" aria-label="%2$s"><i class="bi bi-%3$s fs-5"></i></a>',
											esc_url( $url ),
											esc_attr( ucfirst( $key ) ),
											esc_attr( $key )
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
	</footer><!-- #colophon -->
</div><!-- #page -->

<!-- Back To Top Button -->
<button id="back-to-top" class="btn btn-primary rounded-circle shadow-lg position-fixed bottom-0 end-0 m-4 z-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; display: none !important; transition: all 0.3s ease-in-out;" aria-label="<?php esc_attr_e( 'Back to top', 'robo' ); ?>">
	<?php echo robo_get_svg( 'arrow-up' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</button>

<?php wp_footer(); ?>
</body>
</html>
