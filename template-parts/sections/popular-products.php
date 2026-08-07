<?php
/**
 * Popular Products Section
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
| Popular Products Background Image
|--------------------------------------------------------------------------
| Leave empty ('') to disable the background image.
| Add any valid image URL to enable it.
|--------------------------------------------------------------------------
*/
// $background_image = '';
$background_image = 'http://0.0.0.0:8080/wp-content/uploads/2026/08/403d6e76-c61e-42ac-928c-aa806afc7563.png';

/* ===========================================================
| Popular Products Section Configuration
|============================================================
|
| totalProducts
| Total number of WooCommerce products to load.
|
| desktopColumns
| Number of columns on Desktop.
|
| tabletColumns
| Number of columns on Tablet.
|
| mobileColumns
| Number of columns on Mobile.
|
| mobileRows
| Number of visible rows on Mobile.
|
| tabletRows
| Number of visible rows on Tablet.
|
| desktopRows
| Number of visible rows on Desktop.
|
=========================================================== */

$config = [

    // Total products fetched from WooCommerce
    'totalProducts' => 12,

    // Columns
    'desktopColumns' => 4,
    'tabletColumns'  => 3,
    'mobileColumns'  => 2,

    // Rows
    'desktopRows' => 2,
    'tabletRows'  => 2,
    'mobileRows'  => 3

];

$desktop_limit = (int) ( $config['desktopColumns'] * $config['desktopRows'] );
$tablet_limit  = (int) ( $config['tabletColumns'] * $config['tabletRows'] );
$mobile_limit  = (int) ( $config['mobileColumns'] * $config['mobileRows'] );

$products_to_display = array();

if ( class_exists( 'WooCommerce' ) ) {
	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => (int) $config['totalProducts'],
		'meta_key'       => 'total_sales',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
	);

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		$args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => (int) $config['totalProducts'],
			'orderby'        => 'date',
			'order'          => 'DESC',
		);
		$query = new WP_Query( $args );
	}

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			global $product;
			if ( $product ) {
				$terms    = get_the_terms( get_the_ID(), 'product_cat' );
				$cat_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'Robotics', 'robo' );
				$img_url  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'woocommerce_thumbnail' ) : '';
				
				$products_to_display[] = array(
					'id'           => get_the_ID(),
					'name'         => get_the_title(),
					'category'     => $cat_name,
					'price_html'   => $product->get_price_html(),
					'on_sale'      => $product->is_on_sale(),
					'rating'       => (float) $product->get_average_rating(),
					'rating_count' => (int) $product->get_rating_count(),
					'image'        => $img_url,
					'icon'         => '🤖',
					'link'         => get_permalink(),
					'is_wc'        => true,
					'product_obj'  => $product,
				);
			}
		}
		wp_reset_postdata();
	}
}

// Fallback products if WooCommerce has no products or WooCommerce is inactive
if ( empty( $products_to_display ) ) {
	$demo_pool = array(
		array(
			'id'           => 1,
			'name'         => __( 'Autonomous Mobile Robot (AMR) Kit v2', 'robo' ),
			'category'     => __( 'Robotics Kits', 'robo' ),
			'price_html'   => '<del>$349.00</del> <ins>$299.00</ins>',
			'on_sale'      => true,
			'rating'       => 5,
			'rating_count' => 28,
			'image'        => '',
			'icon'         => '🤖',
			'link'         => '#product-amr-v2',
			'is_wc'        => false,
		),
		array(
			'id'           => 2,
			'name'         => __( 'AI Vision Camera Module 4K HDR', 'robo' ),
			'category'     => __( 'IoT & AI', 'robo' ),
			'price_html'   => '$129.00',
			'on_sale'      => false,
			'rating'       => 4.5,
			'rating_count' => 19,
			'image'        => '',
			'icon'         => '📷',
			'link'         => '#product-ai-vision',
			'is_wc'        => false,
		),
		array(
			'id'           => 3,
			'name'         => __( 'STEM Educational Microcontroller Kit', 'robo' ),
			'category'     => __( 'STEM Learning Kits', 'robo' ),
			'price_html'   => '<del>$89.00</del> <ins>$69.00</ins>',
			'on_sale'      => true,
			'rating'       => 5,
			'rating_count' => 45,
			'image'        => '',
			'icon'         => '⚡',
			'link'         => '#product-stem-micro',
			'is_wc'        => false,
		),
		array(
			'id'           => 4,
			'name'         => __( 'High-Torque Servo Motor Pack (4x)', 'robo' ),
			'category'     => __( 'Electronics Components', 'robo' ),
			'price_html'   => '$49.99',
			'on_sale'      => false,
			'rating'       => 4,
			'rating_count' => 14,
			'image'        => '',
			'icon'         => '⚙️',
			'link'         => '#product-servo-pack',
			'is_wc'        => false,
		),
		array(
			'id'           => 5,
			'name'         => __( 'LiDAR Obstacle Avoidance Sensor 360°', 'robo' ),
			'category'     => __( 'Development Boards', 'robo' ),
			'price_html'   => '<del>$199.00</del> <ins>$159.00</ins>',
			'on_sale'      => true,
			'rating'       => 5,
			'rating_count' => 32,
			'image'        => '',
			'icon'         => '📡',
			'link'         => '#product-lidar-sensor',
			'is_wc'        => false,
		),
		array(
			'id'           => 6,
			'name'         => __( '6-DoF Robotic Arm Controller Board', 'robo' ),
			'category'     => __( 'Robotics Kits', 'robo' ),
			'price_html'   => '$219.00',
			'on_sale'      => false,
			'rating'       => 4.5,
			'rating_count' => 22,
			'image'        => '',
			'icon'         => '🦾',
			'link'         => '#product-robotic-arm',
			'is_wc'        => false,
		),
		array(
			'id'           => 7,
			'name'         => __( 'Dual Motor Driver Shield 30A', 'robo' ),
			'category'     => __( 'Electronics Components', 'robo' ),
			'price_html'   => '<del>$39.00</del> <ins>$29.00</ins>',
			'on_sale'      => true,
			'rating'       => 4.5,
			'rating_count' => 16,
			'image'        => '',
			'icon'         => '🔌',
			'link'         => '#product-motor-driver',
			'is_wc'        => false,
		),
		array(
			'id'           => 8,
			'name'         => __( 'Wireless Robotics Controller 2.4GHz', 'robo' ),
			'category'     => __( 'Development Boards', 'robo' ),
			'price_html'   => '$59.00',
			'on_sale'      => false,
			'rating'       => 5,
			'rating_count' => 38,
			'image'        => '',
			'icon'         => '🎮',
			'link'         => '#product-wireless-controller',
			'is_wc'        => false,
		),
		array(
			'id'           => 9,
			'name'         => __( 'Smart Battery Management BMS 4S', 'robo' ),
			'category'     => __( 'Electronics Components', 'robo' ),
			'price_html'   => '$24.50',
			'on_sale'      => false,
			'rating'       => 4,
			'rating_count' => 11,
			'image'        => '',
			'icon'         => '🔋',
			'link'         => '#product-bms-4s',
			'is_wc'        => false,
		),
		array(
			'id'           => 10,
			'name'         => __( 'Ultrasonic Distance Sensor Module Pack', 'robo' ),
			'category'     => __( 'IoT & AI', 'robo' ),
			'price_html'   => '<del>$19.00</del> <ins>$14.99</ins>',
			'on_sale'      => true,
			'rating'       => 4.5,
			'rating_count' => 29,
			'image'        => '',
			'icon'         => '🦇',
			'link'         => '#product-ultrasonic',
			'is_wc'        => false,
		),
		array(
			'id'           => 11,
			'name'         => __( 'Heavy Duty Metal Chassis 4WD', 'robo' ),
			'category'     => __( 'Robotics Kits', 'robo' ),
			'price_html'   => '$119.00',
			'on_sale'      => false,
			'rating'       => 5,
			'rating_count' => 41,
			'image'        => '',
			'icon'         => '🏎️',
			'link'         => '#product-metal-chassis',
			'is_wc'        => false,
		),
		array(
			'id'           => 12,
			'name'         => __( 'Python AI Robotics Starter Book + Kit', 'robo' ),
			'category'     => __( 'Educational Resources', 'robo' ),
			'price_html'   => '<del>$99.00</del> <ins>$79.00</ins>',
			'on_sale'      => true,
			'rating'       => 5,
			'rating_count' => 53,
			'image'        => '',
			'icon'         => '📘',
			'link'         => '#product-python-book',
			'is_wc'        => false,
		),
	);

	$target_count = (int) $config['totalProducts'];
	while ( count( $products_to_display ) < $target_count ) {
		$products_to_display = array_merge( $products_to_display, $demo_pool );
	}
	$products_to_display = array_slice( $products_to_display, 0, $target_count );
}
?>

<style id="popular-products-dynamic-limits">
	.robo-popular-products__grid {
		--pp-desktop-cols: <?php echo (int) $config['desktopColumns']; ?>;
		--pp-tablet-cols: <?php echo (int) $config['tabletColumns']; ?>;
		--pp-mobile-cols: <?php echo (int) $config['mobileColumns']; ?>;
	}

	@media (min-width: 1025px) {
		.robo-popular-products__card:nth-child(n + <?php echo $desktop_limit + 1; ?>) {
			display: none !important;
		}
	}

	@media (min-width: 768px) and (max-width: 1024px) {
		.robo-popular-products__card:nth-child(n + <?php echo $tablet_limit + 1; ?>) {
			display: none !important;
		}
	}

	@media (max-width: 767.98px) {
		.robo-popular-products__card:nth-child(n + <?php echo $mobile_limit + 1; ?>) {
			display: none !important;
		}
	}
</style>

<?php
$section_style = '';
$title_color = get_theme_mod( 'robo_popular_products_title_color', '#000000' );
if ( ! empty( $background_image ) ) {
	$section_style = 'background-image: url(' . esc_url( $background_image ) . '); background-repeat: no-repeat; background-position: center center; background-size: cover; background-attachment: scroll;';

	$title_color = get_theme_mod( 'robo_popular_products_title_color', '#ffffff' );
}
?>

<section id="popular-products" class="robo-popular-products"<?php if ( ! empty( $section_style ) ) : ?> style="<?php echo esc_attr( $section_style ); ?>"<?php endif; ?> aria-label="<?php esc_attr_e( 'Popular Products', 'robo' ); ?>">
	<div class="container robo-popular-products__container">
		
		<!-- Section Header -->
		<div class="robo-popular-products__header">
			<div class="robo-popular-products__badge-wrapper">
				<span class="robo-popular-products__badge">
					<?php esc_html_e( 'Our Best Sellers', 'robo' ); ?>
				</span>
			</div>
			<h2 class="robo-popular-products__heading " style="color: <?php echo esc_attr( $title_color ); ?>;">
				<?php esc_html_e( 'Popular Products', 'robo' ); ?>
			</h2>
			<p class="robo-popular-products__desc">
				<?php esc_html_e( 'Discover top-rated robotics kits, components, AI modules, and educational products designed for builders and makers.', 'robo' ); ?>
			</p>
		</div>

		<!-- Product Grid -->
		<div class="robo-popular-products__grid">
			<?php foreach ( $products_to_display as $item ) : ?>
				<div class="robo-popular-products__card">
					
					<!-- Image & Overlay Container -->
					<div class="robo-product-image-wrap">
						<?php if ( ! empty( $item['on_sale'] ) ) : ?>
							<span class="robo-product-badge-sale">
								<?php esc_html_e( 'Sale', 'robo' ); ?>
							</span>
						<?php endif; ?>

						<div class="robo-product-top-actions">
							<button type="button" class="robo-product-action-btn robo-product-action-btn--wishlist" aria-label="<?php esc_attr_e( 'Add to Wishlist', 'robo' ); ?>" title="<?php esc_attr_e( 'Add to Wishlist', 'robo' ); ?>">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
							</button>

							<a href="<?php echo esc_url( $item['link'] ); ?>" class="robo-product-action-btn robo-product-action-btn--quickview" aria-label="<?php esc_attr_e( 'Quick View', 'robo' ); ?>" title="<?php esc_attr_e( 'Quick View', 'robo' ); ?>">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
							</a>
						</div>

						<a href="<?php echo esc_url( $item['link'] ); ?>">
							<?php if ( ! empty( $item['image'] ) ) : ?>
								<img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" loading="lazy" />
							<?php else : ?>
								<span class="robo-product-image__emoji"><?php echo esc_html( $item['icon'] ); ?></span>
							<?php endif; ?>
						</a>
					</div>

					<!-- Card Body -->
					<div class="robo-product-card__body">
						
						<!-- Category -->
						<div class="robo-product-category">
							<span class="robo-product-category-badge">
								<?php echo esc_html( $item['category'] ); ?>
							</span>
						</div>

						<!-- Title -->
						<h3 class="robo-product-title">
							<a href="<?php echo esc_url( $item['link'] ); ?>">
								<?php echo esc_html( $item['name'] ); ?>
							</a>
						</h3>

						<!-- Rating -->
						<div class="robo-product-rating">
							<?php
							$rating     = ! empty( $item['rating'] ) ? (float) $item['rating'] : 5;
							$full_stars = floor( $rating );
							$half_star  = ( $rating - $full_stars ) >= 0.5;
							for ( $s = 1; $s <= 5; $s++ ) {
								if ( $s <= $full_stars ) {
									echo '★';
								} elseif ( $s == $full_stars + 1 && $half_star ) {
									echo '½';
								} else {
									echo '☆';
								}
							}
							?>
							<span class="robo-product-rating__count">(<?php echo (int) ( ! empty( $item['rating_count'] ) ? $item['rating_count'] : 24 ); ?>)</span>
						</div>

						<!-- Price -->
						<div class="robo-product-price">
							<?php echo wp_kses_post( $item['price_html'] ); ?>
						</div>

						<!-- Actions -->
						<div class="robo-product-actions">
							<?php if ( ! empty( $item['is_wc'] ) && ! empty( $item['product_obj'] ) ) : ?>
								<?php
								woocommerce_template_loop_add_to_cart(
									array(
										'class' => 'robo-btn-add-to-cart',
									)
								);
								?>
							<?php else : ?>
								<a href="<?php echo esc_url( $item['link'] ); ?>" class="robo-btn-add-to-cart">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
									<?php esc_html_e( 'Add to Cart', 'robo' ); ?>
								</a>
							<?php endif; ?>

							<a href="<?php echo esc_url( $item['link'] ); ?>" class="robo-btn-view" aria-label="<?php esc_attr_e( 'View Product', 'robo' ); ?>" title="<?php esc_attr_e( 'View Product', 'robo' ); ?>">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
							</a>
						</div>

					</div>

				</div>
			<?php endforeach; ?>
		</div>

		<!-- Footer CTA -->
		<div class="robo-popular-products__footer">
			<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#shop' ); ?>" class="robo-popular-products__view-all">
				<?php esc_html_e( 'View All Products', 'robo' ); ?>
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
			</a>
		</div>

	</div>
</section>