<?php
/**
 * Template part for displaying the Hero section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_image   = get_header_image();
if ( empty( $hero_image ) ) {
	$hero_image = content_url( '/uploads/2026/07/513ac378-2fee-4500-8756-c9fb74781012.png' );
}

$btn1_text       = get_theme_mod( 'robo_hero_btn1_text', esc_html__( 'Get Started', 'robo' ) );
$btn1_url        = get_theme_mod( 'robo_hero_btn1_url', '#popular-products' );
$container_class = get_theme_mod( 'robo_container_width', 'container' );



// Retrieve hero background image options from Customizer.
$bg_image_raw         = get_theme_mod( 'robo_hero_bg_image', '' );
$bg_image_desktop_raw = get_theme_mod( 'robo_hero_bg_image_desktop', '' );
$bg_image_tablet_raw  = get_theme_mod( 'robo_hero_bg_image_tablet', '' );
$bg_image_mobile_raw  = get_theme_mod( 'robo_hero_bg_image_mobile', '' );

$bg_image_fallback_url = robo_get_hero_bg_image_url( $bg_image_raw );

// Display Logic: Use device-specific image if available; fallback to existing Hero Background Image.
$bg_desktop_url = ! empty( $bg_image_desktop_raw ) ? robo_get_hero_bg_image_url( $bg_image_desktop_raw ) : $bg_image_fallback_url;
$bg_tablet_url  = ! empty( $bg_image_tablet_raw ) ? robo_get_hero_bg_image_url( $bg_image_tablet_raw ) : $bg_image_fallback_url;
$bg_mobile_url  = ! empty( $bg_image_mobile_raw ) ? robo_get_hero_bg_image_url( $bg_image_mobile_raw ) : $bg_image_fallback_url;

$has_hero_bg_image = ! empty( $bg_desktop_url ) || ! empty( $bg_tablet_url ) || ! empty( $bg_mobile_url );

// Retrieve hero background overlay settings.
$overlay_enable  = get_theme_mod( 'robo_hero_overlay_enable', false );
$overlay_color   = get_theme_mod( 'robo_hero_overlay_color', '#000000' );
$overlay_opacity = get_theme_mod( 'robo_hero_overlay_opacity', '0.3' );

$hero_style     = '';
$hero_classes   = array( 'hero-section' );
$responsive_css = '';

if ( $has_hero_bg_image ) {
	$hero_classes[] = 'has-hero-bg-image';

	if ( $bg_desktop_url === $bg_tablet_url && $bg_tablet_url === $bg_mobile_url ) {
		$hero_style = sprintf(
			'style="background-image: url(\'%s\'); background-size: cover; background-position: center center; background-repeat: no-repeat;"',
			esc_url( $bg_desktop_url )
		);
	} else {
		if ( ! empty( $bg_desktop_url ) ) {
			$responsive_css .= sprintf(
				'@media (min-width: 1025px) { #hero.has-hero-bg-image { background-image: url(\'%s\'); background-size: cover; background-position: center center; background-repeat: no-repeat; } } ',
				esc_url( $bg_desktop_url )
			);
		}
		if ( ! empty( $bg_tablet_url ) ) {
			$responsive_css .= sprintf(
				'@media (min-width: 768px) and (max-width: 1024px) { #hero.has-hero-bg-image { background-image: url(\'%s\'); background-size: cover; background-position: center center; background-repeat: no-repeat; } } ',
				esc_url( $bg_tablet_url )
			);
		}
		if ( ! empty( $bg_mobile_url ) ) {
			$responsive_css .= sprintf(
				'@media (max-width: 767px) { #hero.has-hero-bg-image { background-image: url(\'%s\'); background-size: cover; background-position: center center; background-repeat: no-repeat; } } ',
				esc_url( $bg_mobile_url )
			);
		}
	}
}
?>

<?php if ( ! empty( $responsive_css ) ) : ?>
	<style><?php echo wp_strip_all_tags( $responsive_css ); ?></style>
<?php endif; ?>

<section id="hero" class="<?php echo esc_attr( implode( ' ', $hero_classes ) ); ?>" <?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $has_hero_bg_image && $overlay_enable ) : ?>
		<?php
		$rgb = sscanf( $overlay_color, '#%02x%02x%02x' );
		if ( $rgb && 3 === count( $rgb ) ) {
			$rgba = sprintf( 'rgba(%d, %d, %d, %s)', $rgb[0], $rgb[1], $rgb[2], esc_attr( $overlay_opacity ) );
		} else {
			$rgba = 'rgba(0, 0, 0, ' . esc_attr( $overlay_opacity ) . ')';
		}
		?>
		<div class="hero-bg-overlay" style="background-color: <?php echo esc_attr( $rgba ); ?>;"></div>
	<?php endif; ?>
	<div class="d-none <?php echo esc_attr( $container_class ); ?>">
		<div class="d-none row align-items-center hero-main-row">
			
			<!-- LEFT -->
			<div class="d-none col-6 col-lg-5 hero-left-content">

				<?php if ( ! empty( $btn1_text ) ) : ?>
					<a href="<?php echo esc_url( ! empty( $btn1_url ) ? $btn1_url : '#' ); ?>" class="">
						<span class="d-none hero-badge">
						    <?php echo esc_html( $btn1_text ); ?>
						</span>
					</a>
				<?php else: ?>
				<span class="d-none hero-badge">
					🤖 Robotics Kit
				</span>
				<?php endif; ?>

				<h1 class=" d-none hero-title">
					Mini Sumo
					<span>Robot</span>
				</h1>

				<p class="d-none hero-text">
					Build, Code & Compete with India's most advanced Mini Sumo Robot kit.
				</p>

			</div>

			<!-- RIGHT -->
			<div class="d-none col-6 col-lg-7 hero-right-content">
				<div class="robot-wrapper">
					<div class="glow"></div>
					<div class="ring ring1 d-none"></div>
					<div class="ring ring2 d-none"></div>
					<div class="grid"></div>
					<div class="particle p1"></div>
					<div class="particle p2"></div>
					<div class="particle p3"></div>
					<div class="particle p4"></div>
					<div class="particle p5"></div>

					<img src="<?php echo esc_url( $hero_image ); ?>" class="robot-img" alt="Mini Sumo Robot">
				</div>
			</div>

		</div>
	</div>
</section>