<?php
/**
 * Template part for displaying the Product Categories Slider section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
|--------------------------------------------------------------------------
| Hide Empty Categories
|--------------------------------------------------------------------------
|
| Default:
| 'hide_empty' => false
|
| If you want to show ONLY categories having at least one product,
| simply uncomment the line below and comment the default one.
|
| 'hide_empty' => true,
|
*/
$cat_args = array(
	'taxonomy'   => 'product_cat',
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => false,
	// 'hide_empty' => true,
);

$terms = array();
if ( taxonomy_exists( 'product_cat' ) ) {
	$terms = get_terms( $cat_args );
	if ( is_wp_error( $terms ) ) {
		$terms = array();
	}
}

// Fallback categories if WooCommerce categories are empty or taxonomy is inactive.
$fallback_categories = array(
	array(
		'name'  => __( 'Robotics Kits', 'robo' ),
		'count' => 24,
		'icon'  => '🤖',
		'link'  => '#robotics-kits',
		'image' => '',
	),
	array(
		'name'  => __( 'Electronics Components', 'robo' ),
		'count' => 42,
		'icon'  => '⚙️',
		'link'  => '#electronics-components',
		'image' => '',
	),
	array(
		'name'  => __( 'Development Boards', 'robo' ),
		'count' => 18,
		'icon'  => '💻',
		'link'  => '#development-boards',
		'image' => '',
	),
	array(
		'name'  => __( 'IoT & AI', 'robo' ),
		'count' => 15,
		'icon'  => '📡',
		'link'  => '#iot-ai',
		'image' => '',
	),
	array(
		'name'  => __( 'STEM Learning Kits', 'robo' ),
		'count' => 30,
		'icon'  => '🎓',
		'link'  => '#stem-kits',
		'image' => '',
	),
	array(
		'name'  => __( 'Educational Resources', 'robo' ),
		'count' => 12,
		'icon'  => '📚',
		'link'  => '#educational-resources',
		'image' => '',
	),
);

$category_items = array();

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	foreach ( $terms as $term ) {
		$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
		$image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'medium' ) : '';
		$term_link    = get_term_link( $term );

		$category_items[] = array(
			'name'  => $term->name,
			'count' => $term->count,
			'icon'  => '📦',
			'link'  => is_wp_error( $term_link ) ? '#product-cat' : $term_link,
			'image' => $image_url,
		);
	}
} else {
	$category_items = $fallback_categories;
}
?>

<section id="product-categories" class="mb-4 robo-category-slider" aria-label="<?php esc_attr_e( 'Product Categories', 'robo' ); ?>">
	<div class="container robo-category-slider__container">
		
		<!-- Section Header -->
		<div class="robo-category-slider__header">
			<div class="robo-category-slider__badge-wrapper">
				<span class="robo-category-slider__badge">
					Explore
				</span>
			</div>
			<h2 class="robo-category-slider__heading">
				<?php esc_html_e( 'Our Robotics Collections ⭐', 'robo' ); ?>
			</h2>
			<p class="robo-category-slider__desc">
				<?php esc_html_e( 'Discover robotics kits, electronics, AI modules, STEM products, and educational resources designed for students, makers, schools, and professionals.', 'robo' ); ?>
			</p>
		</div>

		<!-- Slider Wrapper -->
		<div class="robo-category-slider__wrapper position-relative">
			
			<!-- Nav Controls -->
			<button type="button" class="robo-category-slider__nav robo-category-slider__nav--prev" aria-label="<?php esc_attr_e( 'Previous Category', 'robo' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
			</button>

			<button type="button" class="robo-category-slider__nav robo-category-slider__nav--next" aria-label="<?php esc_attr_e( 'Next Category', 'robo' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
			</button>

			<!-- Track Container -->
			<div class="robo-category-slider__track-container">
				<div class="robo-category-slider__track">
					<?php foreach ( $category_items as $item ) : ?>
						<div class="robo-category-slider__slide">
							<a href="<?php echo esc_url( $item['link'] ); ?>" class="robo-category-card">
								
								<!-- Image Container -->
								<div class="robo-category-image">
									<?php if ( ! empty( $item['image'] ) ) : ?>
										<img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" loading="lazy" />
									<?php else : ?>
										<div class="robo-category-image__placeholder">
											<span class="robo-category-image__emoji"><?php echo esc_html( $item['icon'] ); ?></span>
										</div>
									<?php endif; ?>
								</div>

								<!-- Content -->
								<div class="robo-category-card__body">
									<h3 class="robo-category-title">
										<?php echo esc_html( $item['name'] ); ?>
									</h3>
									<div class="robo-category-card__footer">
										<span class="robo-category-count">
											<?php echo sprintf( esc_html( _n( '%d Product', '%d Products', $item['count'], 'robo' ) ), (int) $item['count'] ); ?>
										</span>
										<span class="robo-category-arrow" aria-hidden="true">
											<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
										</span>
									</div>
								</div>

							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Pagination Dots -->
			<div class="robo-category-slider__dots" role="tablist" aria-label="<?php esc_attr_e( 'Category Slider Dots', 'robo' ); ?>"></div>

		</div>

	</div>
</section>
