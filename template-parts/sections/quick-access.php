<?php
/**
 * Template part for displaying the Quick Access section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Retrieve Quick Access settings from Customizer with default fallbacks.
$quick_access_title = get_theme_mod( 'robo_quick_access_title', esc_html__( 'Start Your Robotics Journey', 'robo' ) );
$quick_access_desc  = get_theme_mod( 'robo_quick_access_desc', esc_html__( 'Explore our robotics kits or watch product demonstrations before getting started.', 'robo' ) );

$btn1_text = get_theme_mod( 'robo_quick_access_btn1_text', esc_html__( 'Explore Robots', 'robo' ) );
$btn1_url  = get_theme_mod( 'robo_quick_access_btn1_url', '#popular-products' );

$btn2_text = get_theme_mod( 'robo_quick_access_btn2_text', esc_html__( 'Watch Videos', 'robo' ) );
$btn2_url  = get_theme_mod( 'robo_quick_access_btn2_url', '#videos' );

$btn3_text = get_theme_mod( 'robo_quick_access_btn3_text', esc_html__( 'Expert Support', 'robo' ) );
$btn3_url  = get_theme_mod( 'robo_quick_access_btn3_url', '#support' );
?>

<section id="quick-access" class="robo-quick-access mb-0">
	<div class="container robo-quick-access__container">
		<div class="robo-quick-access__card">
			<div class="robo-quick-access__content">
				
				<!-- Badge -->
				<div class="robo-quick-access__badge-wrapper">
					<span class="robo-quick-access__badge">
						🚀 Quick Access
					</span>
				</div>

				<!-- Main Heading -->
				<?php if ( ! empty( $quick_access_title ) ) : ?>
					<h2 class="robo-quick-access__heading quick-access-title">
						<?php echo esc_html( $quick_access_title ); ?>
					</h2>
				<?php endif; ?>

				<!-- Description -->
				<?php if ( ! empty( $quick_access_desc ) ) : ?>
					<p class="robo-quick-access__desc quick-access-description">
						<?php echo esc_html( $quick_access_desc ); ?>
					</p>
				<?php endif; ?>

				<!-- Buttons -->
				<?php if ( ( ! empty( $btn1_text ) && ! empty( $btn1_url ) ) || ( ! empty( $btn2_text ) && ! empty( $btn2_url ) ) || ( ! empty( $btn3_text ) && ! empty( $btn3_url ) ) ) : ?>
					<div class="robo-quick-access__buttons quick-access-buttons">
						<?php if ( ! empty( $btn1_text ) && ! empty( $btn1_url ) ) : ?>
							<a href="<?php echo esc_url( $btn1_url ); ?>" class="robo-quick-access__btn robo-quick-access__btn--primary quick-access-button">
								<span class="robo-quick-access__btn-icon">🤖</span>
								<span class="robo-quick-access__btn-text"><?php echo esc_html( $btn1_text ); ?></span>
							</a>
						<?php endif; ?>

						<?php if ( ! empty( $btn2_text ) && ! empty( $btn2_url ) ) : ?>
							<a href="<?php echo esc_url( $btn2_url ); ?>" class="robo-quick-access__btn robo-quick-access__btn--secondary quick-access-button">
								<span class="robo-quick-access__btn-icon">▶</span>
								<span class="robo-quick-access__btn-text"><?php echo esc_html( $btn2_text ); ?></span>
							</a>
						<?php endif; ?>

						<?php if ( ! empty( $btn3_text ) && ! empty( $btn3_url ) ) : ?>
							<a href="<?php echo esc_url( $btn3_url ); ?>" class="robo-quick-access__btn robo-quick-access__btn--primary quick-access-button">
								<span class="robo-quick-access__btn-icon">🛠️</span>
								<span class="robo-quick-access__btn-text"><?php echo esc_html( $btn3_text ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
