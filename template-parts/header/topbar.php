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
	<div class="container <?php //echo // esc_attr( $container_class ); ?>">
		<div class="row align-items-center">
			<!-- Left Side: Contact Info -->
			<div class="col col-md-8 d-flex align-items-center flex-wrap justify-content-center justify-content-md-start gap-3 mb-2 mb-md-0">
				<!-- Phone -->
				<span class="text-muted small d-flex align-items-center gap-1">
					<span class="text-primary"><?php echo robo_get_svg( 'phone' ); ?></span>
					<a href="<?php echo esc_url( 'tel:' . str_replace( ' ', '', robo_get_company_info( 'phone_number' ) ) ); ?>" class="text-decoration-none text-muted hover-primary">
						<?php echo esc_html( robo_get_company_info( 'phone_number' ) ); ?>
					</a>
				</span>
				<!-- Email -->
				<span class="text-muted small d-flex align-items-center gap-1  d-none d-md-inline">
					<span class="text-primary"><?php echo robo_get_svg( 'email' ); ?></span>
					<a href="<?php echo esc_url( 'https://mail.google.com/mail/?view=cm&fs=1&to=' . robo_get_company_info( 'support_email' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted hover-primary">
						<?php echo esc_html( robo_get_company_info( 'support_email' ) ); ?>
					</a>
				</span>
				<!-- Location -->
				<span class="text-muted small d-flex align-items-center gap-1 d-none d-md-inline">
					<a href="<?php echo esc_url( robo_get_company_info( 'maps_url' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted hover-primary d-flex align-items-center gap-1">
						<span class="text-primary"><?php echo robo_get_svg( 'location' ); ?></span>
						<span class="topbar-address-text d-none d-md-inline"><?php echo esc_html( robo_get_company_info( 'address' ) ); ?></span>
					</a>
				</span>
				
			</div>
			<!-- Right Side: Social Media -->
			<div class="col col-md-4 text-center text-md-end d-flex align-items-center justify-content-center justify-content-md-end">
				<?php if ( $has_social ) : ?>
					<div class="topbar-socials d-inline-flex gap-3 align-items-center">

						<!-- start >> Location and email icon for mobile only -->
						<!-- Email -->
						<span class="text-muted small d-flex align-items-center gap-1 d-inline d-md-none">
							<span class="topbar-icon-email"><?php echo robo_get_svg( 'email' ); ?></span>
							<a href="<?php echo esc_url( 'https://mail.google.com/mail/?view=cm&fs=1&to=' . robo_get_company_info( 'support_email' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted hover-primary">
								<?php //echo esc_html( robo_get_company_info( 'support_email' ) ); ?>
							</a>
						</span>
						<span class="text-muted small d-flex align-items-center gap-1 d-inline d-md-none">
							<a href="<?php echo esc_url( robo_get_company_info( 'maps_url' ) ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted hover-primary d-flex align-items-center gap-1">
								<?php echo robo_get_svg( 'location' ); ?>
							</a>
						</span>
						<!-- End >> Location icon for mobile only -->

						<?php
						foreach ( $social_links as $key => $url ) {
							if ( $url ) {
								printf(
									'<a href="%1$s" class="text-muted hover-primary d-inline-flex align-items-center" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s</a>',
									esc_url( $url ),
									esc_attr( ucfirst( $key ) ),
									robo_get_svg( $key ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
