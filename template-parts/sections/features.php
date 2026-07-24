<?php
/**
 * Template part for displaying the Engineering Specifications section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

$section_badge = get_theme_mod( 'robo_features_badge', __( 'Engineering Specifications', 'robo' ) );
$section_title = get_theme_mod( 'robo_features_title', __( 'Competition-Grade Robotics & Parts Shop', 'robo' ) );
$section_desc  = get_theme_mod( 'robo_features_desc', __( 'Our gear is designed to withstand intense conditions in combat arenas and drone flights. We provide pre-tested, high-reliability boards and parts that integrate flawlessly.', 'robo' ) );

$card_title = get_theme_mod( 'robo_features_card_title', __( 'Robotics Hardware Standards', 'robo' ) );
$card_desc  = get_theme_mod( 'robo_features_card_desc', __( 'We carry parts built to standard specifications. Our custom sumobot kits, motors, and batteries undergo strict quality control to guarantee performance in critical situations.', 'robo' ) );
$stat1_val  = get_theme_mod( 'robo_features_card_stat1_val', __( '100%', 'robo' ) );
$stat1_lbl  = get_theme_mod( 'robo_features_card_stat1_lbl', __( 'Combat Tested', 'robo' ) );
$stat2_val  = get_theme_mod( 'robo_features_card_stat2_val', __( 'A+ Grade', 'robo' ) );
$stat2_lbl  = get_theme_mod( 'robo_features_card_stat2_lbl', __( 'Battery Cells', 'robo' ) );

$features = function_exists( 'robo_get_specifications' ) ? robo_get_specifications() : array();
?>
<section id="features" class="features-section py-5">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		<div class="row align-items-center g-5">
			
			<!-- Left features checklist -->
			<div class="col-lg-6">
				<?php if ( ! empty( $section_badge ) ) : ?>
					<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php echo esc_html( $section_badge ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $section_title ) ) : ?>
					<h2 class="h1 fw-bold text-dark mb-4"><?php echo esc_html( $section_title ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $section_desc ) ) : ?>
					<p class="text-muted mb-5"><?php echo esc_html( $section_desc ); ?></p>
				<?php endif; ?>
				
				<div class="row g-4">
					<?php foreach ( $features as $feat ) : ?>
						<div class="col-sm-6">
							<div class="d-flex align-items-start gap-3">
								<div class="text-primary mt-1">
									<?php 
									if ( function_exists( 'robo_render_spec_icon' ) ) {
										echo robo_render_spec_icon( isset( $feat['icon'] ) ? $feat['icon'] : '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									} else {
										?>
										<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/></svg>
										<?php
									}
									?>
								</div>
								<div>
									<h4 class="h6 fw-bold text-dark mb-1"><?php echo esc_html( $feat['title'] ); ?></h4>
									<p class="text-muted small mb-0"><?php echo esc_html( $feat['description'] ); ?></p>
									<?php if ( ! empty( $feat['value'] ) ) : ?>
										<span class="badge bg-primary-subtle text-primary mt-1 d-inline-block"><?php echo esc_html( $feat['value'] ); ?></span>
									<?php endif; ?>
									<?php if ( ! empty( $feat['button_text'] ) ) : 
										$btn_url = ! empty( $feat['button_url'] ) ? $feat['button_url'] : '#';
									?>
										<div class="mt-2">
											<a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-sm btn-outline-primary py-1 px-2 text-decoration-none">
												<?php echo esc_html( $feat['button_text'] ); ?>
											</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Right Graphic Card Column -->
			<div class="col-lg-6">
				<div class="Right-Graphic-Card-Column card border-0 shadow-lg p-5 bg-primary text-white position-relative overflow-hidden rounded-4">
					<div class="position-absolute top-0 end-0 opacity-10" style="transform: translate(30%, -30%);">
						<svg xmlns="http://www.w3.org/2000/svg" width="350" height="350" fill="currentColor" class="bi bi-cpu" viewBox="0 0 16 16"><path d="M5 0a.5.5 0 0 1 .5.5V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 .5-.5h.5a.5.5 0 0 1 .5.5v.5h1.5a.5.5 0 0 1 .5.5V3h1.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h.5a.5.5 0 0 1 .5.5v.5a.5.5 0 0 1-.5.5H13v1.5a.5.5 0 0 1-.5.5V13h-1v1.5a.5.5 0 0 1-1 0V13h-1v1.5a.5.5 0 0 1-1 0V13h-1v1.5a.5.5 0 0 1-1 0V13H5v1.5a.5.5 0 0 1-.5.5h-.5a.5.5 0 0 1-.5-.5v-.5H2v-1.5a.5.5 0 0 1-.5-.5V13h-1.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1 0-1H2v-1h-1.5a.5.5 0 0 1 0-1H2v-1h-1.5a.5.5 0 0 1 0-1H2v-1h-1.5a.5.5 0 0 1 0-1H2V5H.5a.5.5 0 0 1-.5-.5v-.5A.5.5 0 0 1 .5 3H2v-1.5A.5.5 0 0 1 2.5 1H3v-.5A.5.5 0 0 1 3.5 0h.5a.5.5 0 0 1 .5.5V2h1V.5a.5.5 0 0 1 5 0m-.5 3 .5.5v9l-.5.5h-9l-.5-.5v-9l.5-.5zM3 4v8h10V4zm1 1h8v6H4z"/></svg>
					</div>
					<div class="card-body position-relative z-1 p-2">
						<?php if ( ! empty( $card_title ) ) : ?>
							<h3 class="h3 fw-bold text-white mb-3"><?php echo esc_html( $card_title ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $card_desc ) ) : ?>
							<p class="text-white-50 fs-6 mb-4"><?php echo esc_html( $card_desc ); ?></p>
						<?php endif; ?>
						<div class="d-flex align-items-center gap-3">
							<?php if ( ! empty( $stat1_val ) || ! empty( $stat1_lbl ) ) : ?>
								<div class="border-end border-white border-opacity-25 pe-4">
									<?php if ( ! empty( $stat1_val ) ) : ?>
										<h4 class="fw-bold mb-0 text-white"><?php echo esc_html( $stat1_val ); ?></h4>
									<?php endif; ?>
									<?php if ( ! empty( $stat1_lbl ) ) : ?>
										<span class="small text-white-50"><?php echo esc_html( $stat1_lbl ); ?></span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<?php if ( ! empty( $stat2_val ) || ! empty( $stat2_lbl ) ) : ?>
								<div class="pe-4">
									<?php if ( ! empty( $stat2_val ) ) : ?>
										<h4 class="fw-bold mb-0 text-white"><?php echo esc_html( $stat2_val ); ?></h4>
									<?php endif; ?>
									<?php if ( ! empty( $stat2_lbl ) ) : ?>
										<span class="small text-white-50"><?php echo esc_html( $stat2_lbl ); ?></span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>