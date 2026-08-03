<?php
/**
 * Homepage V2 - 100% Dynamic Reference Mini Sumo Hero Section
 * Fully managed from Theme Customizer (Robo Theme -> Hero Section Settings)
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. General & Enable Toggle
$hero_enable = get_theme_mod( 'robo_hero_enable', true );
if ( ! $hero_enable ) {
	return;
}

// 2. Background Settings
$bg_color        = get_theme_mod( 'robo_hero_bg_color', '#FFFFFF' );
$bg_image        = get_theme_mod( 'robo_hero_bg_image', '' );
$overlay_color   = get_theme_mod( 'robo_hero_overlay_color', '#000000' );
$overlay_opacity = get_theme_mod( 'robo_hero_overlay_opacity', '0' );

// 3. Top Badge
$badge_enable     = get_theme_mod( 'robo_hero_badge_enable', true );
$badge_icon       = get_theme_mod( 'robo_hero_badge_icon', 'bi-robot' );
$badge_text       = get_theme_mod( 'robo_hero_badge_text', 'ROBOTICS KIT' );
$badge_bg_color   = get_theme_mod( 'robo_hero_badge_bg_color', '#F3F4F6' );
$badge_text_color = get_theme_mod( 'robo_hero_badge_text_color', '#000000' );

// 4. Main Heading
$heading_line1           = get_theme_mod( 'robo_hero_heading_line1', 'BUILD YOUR OWN' );
$heading_line2           = get_theme_mod( 'robo_hero_heading_line2', 'MINI SUMO' );
$heading_line3           = get_theme_mod( 'robo_hero_heading_line3', 'ROBOT' );
$heading_color           = get_theme_mod( 'robo_hero_heading_color', '#000000' );
$heading_highlight_color = get_theme_mod( 'robo_hero_heading_highlight_color', '#FF0000' );

// 5. Sub Heading
$subheading                 = get_theme_mod( 'robo_hero_subheading', "India's Most Advanced Mini Sumo Robot Kit" );
$subheading_highlight       = get_theme_mod( 'robo_hero_subheading_highlight', 'Advanced' );
$subheading_highlight_color = get_theme_mod( 'robo_hero_subheading_highlight_color', '#FF0000' );
$subheading_color           = get_theme_mod( 'robo_hero_subheading_color', '#000000' );

// Subheading highlight parsing
$subheading_escaped = esc_html( $subheading );
if ( ! empty( $subheading_highlight ) && false !== strpos( $subheading_escaped, esc_html( $subheading_highlight ) ) ) {
	$span_replacement     = '<span style="color: ' . esc_attr( $subheading_highlight_color ) . ';">' . esc_html( $subheading_highlight ) . '</span>';
	$formatted_subheading = str_replace( esc_html( $subheading_highlight ), $span_replacement, $subheading_escaped );
} else {
	$formatted_subheading = $subheading_escaped;
}

// 6. Description
$description = get_theme_mod( 'robo_hero_description', 'Assemble, program, and battle with high-torque motors, custom sensors, and robust chassis engineering. Designed for STEM learning and competitions.' );

// 7. Feature Cards
$cards = array();
for ( $i = 1; $i <= 3; $i++ ) {
	if ( get_theme_mod( "robo_hero_card{$i}_enable", true ) ) {
		$def_icon  = ( 1 === $i ) ? 'bi-cpu-fill' : ( ( 2 === $i ) ? 'bi-gear-wide-connected' : 'bi-lightning-charge-fill' );
		$def_title = ( 1 === $i ) ? 'ESP32' : ( ( 2 === $i ) ? 'Dual' : 'LiPo' );
		$def_desc  = ( 1 === $i ) ? 'Processor' : ( ( 2 === $i ) ? 'Motors' : 'Battery' );

		$cards[] = array(
			'icon'  => get_theme_mod( "robo_hero_card{$i}_icon", $def_icon ),
			'title' => get_theme_mod( "robo_hero_card{$i}_title", $def_title ),
			'desc'  => get_theme_mod( "robo_hero_card{$i}_desc", $def_desc ),
		);
	}
}

// 8. Buttons
$btn_enable  = get_theme_mod( 'robo_hero_btn_enable', true );
$btn_text    = get_theme_mod( 'robo_hero_btn_text', 'Explore Robots' );
$btn_url     = get_theme_mod( 'robo_hero_btn_url', function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#shop' );
$btn_icon    = get_theme_mod( 'robo_hero_btn_icon', 'bi-robot' );

$btn2_enable = get_theme_mod( 'robo_hero_btn2_enable', false );
$btn2_text   = get_theme_mod( 'robo_hero_btn2_text', 'Watch Video' );
$btn2_url    = get_theme_mod( 'robo_hero_btn2_url', '#video' );
$btn2_icon   = get_theme_mod( 'robo_hero_btn2_icon', 'bi-play-circle-fill' );

// 9. Bottom Information Row
$info_star_icon  = get_theme_mod( 'robo_hero_info_star_icon', 'bi-star-fill' );
$info_star_color = get_theme_mod( 'robo_hero_info_star_color', '#FF0000' );
$info_items      = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$def_text = ( 1 === $i ) ? '100% STEM Kit' : ( ( 2 === $i ) ? 'Made in India' : 'Free Shipping' );
	$val      = get_theme_mod( "robo_hero_info_item{$i}", $def_text );
	if ( ! empty( $val ) ) {
		$info_items[] = $val;
	}
}

// 10. Floating Card
$floating_enable      = get_theme_mod( 'robo_hero_floating_card_enable', true );
$floating_title_part1 = get_theme_mod( 'robo_hero_floating_card_title_part1', '3-in-1' );
$floating_title_part2 = get_theme_mod( 'robo_hero_floating_card_title_part2', 'Robot' );
$floating_items       = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$def_icon  = ( 1 === $i ) ? 'bi-robot' : ( ( 2 === $i ) ? 'bi-car-front-fill' : 'bi-dribbble' );
	$def_label = ( 1 === $i ) ? 'Sumo Bot' : ( ( 2 === $i ) ? 'Racer Bot' : 'Soccer Bot' );
	$floating_items[] = array(
		'icon'  => get_theme_mod( "robo_hero_floating_item{$i}_icon", $def_icon ),
		'label' => get_theme_mod( "robo_hero_floating_item{$i}_label", $def_label ),
	);
}

// 11. Product Image
$default_img_src = ROBO_THEME_URI . '/assets/images/mini_sumo_robot.jpg';
$product_img_src = get_theme_mod( 'robo_hero_product_image', $default_img_src );
$product_img_src = ! empty( $product_img_src ) ? $product_img_src : $default_img_src;
$product_img_alt = get_theme_mod( 'robo_hero_product_image_alt', 'Mini Sumo Robot Kit' );

// Background inline style logic
$hero_inline_style = 'background-color: ' . esc_attr( $bg_color ) . ';';
if ( ! empty( $bg_image ) ) {
	$hero_inline_style .= ' background-image: url(' . esc_url( $bg_image ) . '); background-size: cover; background-position: center;';
}
?>
<section class="mini-sumo-hero-section position-relative overflow-hidden" style="<?php echo esc_attr( $hero_inline_style ); ?>">
	<?php if ( floatval( $overlay_opacity ) > 0 ) : ?>
		<div class="hero-background-overlay position-absolute top-0 start-0 w-100 h-100" style="background-color: <?php echo esc_attr( $overlay_color ); ?>; opacity: <?php echo esc_attr( $overlay_opacity ); ?>; z-index: 1;"></div>
	<?php endif; ?>

	<!-- Subtle Background Circular Technical Rings -->
	<div class="tech-rings-bg position-absolute pointer-events-none">
		<svg width="850" height="850" viewBox="0 0 850 850" fill="none" xmlns="http://www.w3.org/2000/svg">
			<circle cx="425" cy="425" r="420" stroke="#000000" stroke-width="1.5" stroke-opacity="0.05" stroke-dasharray="8 8"/>
			<circle cx="425" cy="425" r="320" stroke="#000000" stroke-width="1.5" stroke-opacity="0.06"/>
			<circle cx="425" cy="425" r="220" stroke="#000000" stroke-width="1.5" stroke-opacity="0.05" stroke-dasharray="4 4"/>
			<circle cx="425" cy="425" r="120" stroke="#000000" stroke-width="1" stroke-opacity="0.04"/>
		</svg>
	</div>

	<div class="container position-relative z-2">
		<div class="row align-items-center hero-grid-row">
			
			<!-- Left Column (42%) -->
			<div class="col-lg-5 col-xl-5 left-hero-col">
				<div class="left-content-wrapper">
					
					<!-- 1. Top Badge -->
					<?php if ( $badge_enable && ! empty( $badge_text ) ) : ?>
						<div class="hero-top-badge d-inline-flex align-items-center justify-content-center gap-2" style="background-color: <?php echo esc_attr( $badge_bg_color ); ?>; color: <?php echo esc_attr( $badge_text_color ); ?>;">
							<?php if ( ! empty( $badge_icon ) ) : ?>
								<i class="bi <?php echo esc_attr( $badge_icon ); ?>"></i>
							<?php endif; ?>
							<span><?php echo esc_html( $badge_text ); ?></span>
						</div>
					<?php endif; ?>

					<!-- 2. Main Heading -->
					<h1 class="hero-main-heading" style="color: <?php echo esc_attr( $heading_color ); ?>;">
						<?php if ( ! empty( $heading_line1 ) ) : ?>
							<?php echo esc_html( $heading_line1 ); ?><br>
						<?php endif; ?>
						<?php if ( ! empty( $heading_line2 ) ) : ?>
							<span class="text-red" style="color: <?php echo esc_attr( $heading_highlight_color ); ?> !important;"><?php echo esc_html( $heading_line2 ); ?></span><br>
						<?php endif; ?>
						<?php if ( ! empty( $heading_line3 ) ) : ?>
							<?php echo esc_html( $heading_line3 ); ?>
						<?php endif; ?>
					</h1>

					<!-- 3. Sub Heading -->
					<?php if ( ! empty( $subheading ) ) : ?>
						<h2 class="hero-sub-heading" style="color: <?php echo esc_attr( $subheading_color ); ?>;">
							<?php echo wp_kses_post( $formatted_subheading ); ?>
						</h2>
					<?php endif; ?>

					<!-- 4. Description -->
					<?php if ( ! empty( $description ) ) : ?>
						<p class="hero-description">
							<?php echo esc_html( $description ); ?>
						</p>
					<?php endif; ?>

					<!-- 5. Feature Cards -->
					<?php if ( ! empty( $cards ) ) : ?>
						<div class="hero-feature-cards-row d-flex flex-wrap">
							<?php foreach ( $cards as $card ) : ?>
								<div class="hero-feature-card text-center">
									<div class="card-icon"><i class="bi <?php echo esc_attr( $card['icon'] ); ?>"></i></div>
									<div class="card-title"><?php echo esc_html( $card['title'] ); ?></div>
									<div class="card-subtitle"><?php echo esc_html( $card['desc'] ); ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- 6. Buttons -->
					<div class="d-flex flex-wrap align-items-center gap-3">
						<?php if ( $btn_enable && ! empty( $btn_text ) ) : ?>
							<a href="<?php echo esc_url( $btn_url ); ?>" class="hero-primary-btn d-inline-flex align-items-center justify-content-center gap-3">
								<?php if ( ! empty( $btn_icon ) ) : ?>
									<i class="bi <?php echo esc_attr( $btn_icon ); ?>"></i>
								<?php endif; ?>
								<span><?php echo esc_html( $btn_text ); ?></span>
								<i class="bi bi-arrow-right"></i>
							</a>
						<?php endif; ?>

						<?php if ( $btn2_enable && ! empty( $btn2_text ) ) : ?>
							<a href="<?php echo esc_url( $btn2_url ); ?>" class="btn btn-outline-dark rounded-pill px-4 py-3 fw-bold mt-3 d-inline-flex align-items-center gap-2">
								<?php if ( ! empty( $btn2_icon ) ) : ?>
									<i class="bi <?php echo esc_attr( $btn2_icon ); ?>"></i>
								<?php endif; ?>
								<span><?php echo esc_html( $btn2_text ); ?></span>
							</a>
						<?php endif; ?>
					</div>

					<!-- 7. Bottom Information Row -->
					<?php if ( ! empty( $info_items ) ) : ?>
						<div class="hero-info-row d-flex align-items-center gap-2">
							<i class="bi <?php echo esc_attr( $info_star_icon ); ?>" style="color: <?php echo esc_attr( $info_star_color ); ?>;"></i>
							<?php
							foreach ( $info_items as $index => $item ) {
								if ( $index > 0 ) {
									echo '<span class="divider">|</span>';
								}
								echo '<span>' . esc_html( $item ) . '</span>';
							}
							?>
						</div>
					<?php endif; ?>

				</div>
			</div>

			<!-- Right Column (58%) -->
			<div class="col-lg-7 col-xl-7 right-hero-col position-relative">
				
				<!-- Floating Information Card (Top Right) -->
				<?php if ( $floating_enable ) : ?>
					<div class="floating-info-card shadow-sm">
						<div class="floating-card-heading text-center">
							<?php if ( ! empty( $floating_title_part1 ) ) : ?>
								<span class="text-red"><?php echo esc_html( $floating_title_part1 ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $floating_title_part2 ) ) : ?>
								<span class="text-black"><?php echo esc_html( $floating_title_part2 ); ?></span>
							<?php endif; ?>
						</div>
						<?php if ( ! empty( $floating_items ) ) : ?>
							<div class="floating-card-items d-flex align-items-center justify-content-around text-center mt-2">
								<?php foreach ( $floating_items as $fitem ) : ?>
									<div class="floating-item">
										<i class="bi <?php echo esc_attr( $fitem['icon'] ); ?> item-icon"></i>
										<div class="item-label"><?php echo esc_html( $fitem['label'] ); ?></div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<!-- Product Image -->
				<div class="product-image-container text-center">
					<img src="<?php echo esc_url( $product_img_src ); ?>" alt="<?php echo esc_attr( $product_img_alt ); ?>" class="product-robot-img img-fluid">
					<div class="product-shadow-ellipse"></div>
				</div>

			</div>

		</div>
	</div>
</section>

<style>
/* ==========================================================================
   Exact Reference Mini Sumo Hero Section Styles
   ========================================================================== */

.mini-sumo-hero-section {
	min-height: 720px;
	padding-top: 65px;
	padding-bottom: 65px;
}

.tech-rings-bg {
	top: 50%;
	right: 15%;
	transform: translate(50%, -50%);
	pointer-events: none;
	z-index: 1;
}

/* Grid Layout */
.mini-sumo-hero-section .container {
	max-width: 1320px;
	padding-left: 25px;
	padding-right: 25px;
}

.hero-grid-row {
	gap: 0;
}

.left-hero-col {
	flex: 0 0 42%;
	max-width: 42%;
}

.right-hero-col {
	flex: 0 0 58%;
	max-width: 58%;
	padding-left: 50px;
}

.left-content-wrapper {
	max-width: 540px;
}

/* 1. Top Badge */
.hero-top-badge {
	width: 180px;
	height: 44px;
	border-radius: 999px;
	font-size: 0.875rem;
	font-weight: 800;
	letter-spacing: 0.05em;
	margin-bottom: 30px;
}

.hero-top-badge i {
	font-size: 1.1rem;
}

/* 2. Main Heading */
.hero-main-heading {
	font-size: 76px;
	font-weight: 900;
	line-height: 0.95;
	margin-bottom: 0;
	letter-spacing: -0.02em;
	font-family: inherit;
}

.text-red {
	color: #FF0000 !important;
}

.text-black {
	color: #000000 !important;
}

/* 3. Sub Heading */
.hero-sub-heading {
	font-size: 26px;
	font-weight: 700;
	margin-top: 25px;
	margin-bottom: 0;
	max-width: 520px;
	line-height: 1.3;
}

/* 4. Description */
.hero-description {
	font-size: 21px;
	line-height: 1.5;
	color: #000000;
	margin-top: 22px;
	margin-bottom: 0;
	max-width: 490px;
}

/* 5. Feature Cards */
.hero-feature-cards-row {
	gap: 20px;
	margin-top: 35px;
}

.hero-feature-card {
	width: 150px;
	height: 150px;
	padding: 20px 15px;
	background-color: #FFFFFF;
	border: 1px solid #E5E7EB;
	border-radius: 16px;
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}

.hero-feature-card .card-icon {
	font-size: 36px;
	color: #000000;
	line-height: 1;
	margin-bottom: 8px;
}

.hero-feature-card .card-title {
	font-size: 22px;
	font-weight: 800;
	color: #000000;
	line-height: 1.1;
}

.hero-feature-card .card-subtitle {
	font-size: 16px;
	font-weight: 500;
	color: #6B7280;
	margin-top: 2px;
}

/* 6. Primary Button */
.hero-primary-btn {
	width: 450px;
	height: 65px;
	background-color: #000000;
	color: #FFFFFF !important;
	border-radius: 12px;
	font-size: 28px;
	font-weight: 700;
	text-decoration: none !important;
	margin-top: 25px;
	transition: background-color 0.2s ease-in-out;
}

.hero-primary-btn:hover {
	background-color: #1A1A1A;
	color: #FFFFFF !important;
}

.hero-primary-btn i {
	font-size: 28px;
}

/* 7. Bottom Information Row */
.hero-info-row {
	font-size: 18px;
	font-weight: 600;
	color: #000000;
	margin-top: 22px;
	max-width: 500px;
}

.hero-info-row .divider {
	color: #D1D5DB;
	margin: 0 4px;
}

/* Right Column Elements */
.floating-info-card {
	position: absolute;
	top: 0;
	right: 20px;
	width: 320px;
	height: 130px;
	padding: 16px 20px;
	background: #FFFFFF;
	border: 1px solid #E5E5E5;
	border-radius: 18px;
	box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
	z-index: 5;
}

.floating-card-heading {
	font-size: 38px;
	font-weight: 900;
	line-height: 1;
	margin-bottom: 8px;
}

.floating-item .item-icon {
	font-size: 36px;
	color: #000000;
	line-height: 1;
}

.floating-item .item-label {
	font-size: 16px;
	font-weight: 700;
	color: #000000;
	margin-top: 4px;
}

.product-image-container {
	margin-top: 50px;
	position: relative;
	z-index: 2;
}

.product-robot-img {
	max-width: 660px;
	max-height: 540px;
	width: 100%;
	object-fit: contain;
	filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.12));
}

/* Mobile & Responsive Adjustments */
@media (max-width: 991.98px) {
	.left-hero-col,
	.right-hero-col {
		flex: 0 0 100%;
		max-width: 100%;
		padding-left: 15px;
	}

	.hero-main-heading {
		font-size: 52px;
	}

	.hero-sub-heading {
		font-size: 22px;
	}

	.hero-description {
		font-size: 18px;
	}

	.hero-primary-btn {
		width: 100%;
		font-size: 22px;
		height: 58px;
	}

	.floating-info-card {
		position: relative;
		top: auto;
		right: auto;
		margin: 30px auto 0;
	}
}
</style>
