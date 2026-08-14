<?php
/**
 * Template part for displaying the new Quick Actions Bar section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$background_image = content_url( '/uploads/2026/08/403d6e76-c61e-42ac-928c-aa806afc7563.png' );
$customizer_bg    = function_exists( 'robo_get_hero_bg_image_url' ) ? robo_get_hero_bg_image_url( get_theme_mod( 'robo_popular_products_bg_image', '' ) ) : '';
$effective_bg     = ! empty( $customizer_bg ) ? $customizer_bg : $background_image;

$section_style = '';
if ( ! empty( $effective_bg ) ) {
	$section_style = 'background-image: url(' . esc_url( $effective_bg ) . '); background-repeat: no-repeat; background-position: center center; background-size: cover; background-attachment: scroll;';
}
?>

<section id="quick-actions-bar" class="robo-quick-actions-bar mb-0 mt-0 pt-0">
	<div class="container robo-quick-actions-bar__container p-0 m-0 " <?php if ( ! empty( $section_style ) ) : ?> style="<?php echo esc_attr( $section_style ); ?>"<?php endif; ?> >
		<div class="robo-quick-actions-bar__card" <?php if ( ! empty( $section_style ) ) : ?> style="<?php echo esc_attr( $section_style ); ?>"<?php endif; ?>>
			<div class="robo-quick-actions-bar__content">
				
				<!-- Badge -->
				<div class="robo-quick-actions-bar__badge-wrapper">
					<span class="robo-quick-actions-bar__badge">
						🚀 Quick Access
					</span>
				</div>

				<!-- Main Heading -->
				<h2 class="text-white robo-quick-actions-bar__heading">
					Start Your Robotics Journey
				</h2>

				<!-- Description -->
				<p class=" text-light robo-quick-actions-bar__desc">
					Explore our robotics kits or watch product demonstrations before getting started.
				</p>

				<!-- Buttons -->
				<div class="robo-quick-actions-bar__buttons">
					<a href="#popular-products" class="robo-quick-actions-bar__btn robo-quick-actions-bar__btn--primary">
						<span class="robo-quick-actions-bar__btn-icon">🤖</span>
						<span class="robo-quick-actions-bar__btn-text">Explore Robots</span>
					</a>
					<a href="#videos" class="robo-quick-actions-bar__btn robo-quick-actions-bar__btn--secondary">
						<span class="robo-quick-actions-bar__btn-icon">▶</span>
						<span class="robo-quick-actions-bar__btn-text">Watch Videos</span>
					</a>
					<a href="#support" class="robo-quick-actions-bar__btn robo-quick-actions-bar__btn--primary">
						<span class="robo-quick-actions-bar__btn-icon">🛠️</span>
						<span class="robo-quick-actions-bar__btn-text">Expert Support</span>
					</a>
				</div>

			</div>
		</div>
	</div>
</section>
