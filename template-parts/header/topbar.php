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
<div class="topbar bg-light py-2 border-bottom">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row align-items-center">
			<!-- Left Side: Contact Info -->
			<div class="col-md-8 d-flex align-items-center flex-wrap justify-content-center justify-content-md-start gap-3 mb-2 mb-md-0">
				<!-- Phone -->
				<span class="text-muted small d-flex align-items-center gap-1">
					<i class="bi bi-telephone-fill text-primary"></i>
					<a href="<?php echo esc_url( 'tel:' . str_replace( ' ', '', robo_get_company_info( 'phone_number' ) ) ); ?>" class="text-decoration-none text-muted hover-primary">
						<?php echo esc_html( robo_get_company_info( 'phone_number' ) ); ?>
					</a>
				</span>
				<!-- Location -->
				<span class="text-muted small d-flex align-items-center gap-1">
					<i class="bi bi-geo-alt-fill text-primary"></i>
					<a href="<?php echo esc_url( robo_get_company_info( 'maps_url' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted hover-primary">
						<?php echo esc_html( robo_get_company_info( 'address' ) ); ?>
					</a>
				</span>
				<!-- Email -->
				<span class="text-muted small d-flex align-items-center gap-1">
					<i class="bi bi-envelope-fill text-primary"></i>
					<a href="<?php echo esc_url( 'https://mail.google.com/mail/?view=cm&fs=1&to=' . robo_get_company_info( 'support_email' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted hover-primary">
						<?php echo esc_html( robo_get_company_info( 'support_email' ) ); ?>
					</a>
				</span>
			</div>
			<!-- Right Side: Social Media -->
			<div class="col-md-4 text-center text-md-end d-flex align-items-center justify-content-center justify-content-md-end">
				<?php if ( $has_social ) : ?>
					<div class="topbar-socials d-inline-flex gap-3 align-items-center">
						<?php
						foreach ( $social_links as $key => $url ) {
							if ( $url ) {
								printf(
									'<a href="%1$s" class="text-muted hover-primary" target="_blank" rel="noopener noreferrer" aria-label="%2$s"><i class="bi bi-%3$s"></i></a>',
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
