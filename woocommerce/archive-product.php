<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * @package Robo
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<?php get_template_part( 'template-parts/woocommerce-banner' ); ?>

<?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked robo_woocommerce_wrapper_start - 10
 */
do_action( 'woocommerce_before_main_content' );
?>

<!-- Breadcrumbs (inside container) -->
<div class="row mb-3">
	<div class="col-12">
		<?php robo_woocommerce_breadcrumbs(); ?>
	</div>
</div>

<!-- Main Shop Row -->
<div class="row g-4">
	
	<!-- Left Sidebar Column -->
	<div class="col-lg-3 col-md-4">
		<!-- Responsive Offcanvas: behaves as Drawer on Mobile (<768px), static block on Tablet/Desktop (>=768px) -->
		<div class="offcanvas-md offcanvas-start border-end-md h-100 bg-white" tabindex="-1" id="shopSidebarOffcanvas" aria-labelledby="shopSidebarOffcanvasLabel">
			<div class="offcanvas-header border-bottom bg-light d-md-none">
				<h5 class="offcanvas-title fw-bold text-dark d-flex align-items-center gap-2" id="shopSidebarOffcanvasLabel">
					<i class="bi bi-funnel fs-4 text-primary"></i> <?php esc_html_e( 'Filter & Search', 'robo' ); ?>
				</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" data-bs-target="#shopSidebarOffcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body p-4 p-md-0">
				<aside id="secondary" class="widget-area w-100" aria-label="<?php esc_attr_e( 'Shop Sidebar', 'robo' ); ?>">
					<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
						<?php dynamic_sidebar( 'shop-sidebar' ); ?>
					<?php else : ?>
						<!-- Fallback Widget: Search -->
						<section class="widget card border-0 shadow-sm p-4 mb-4 bg-white">
							<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold d-flex align-items-center gap-2">
								<i class="bi bi-search text-primary"></i> <?php esc_html_e( 'Search Products', 'robo' ); ?>
							</h4>
							<?php echo get_product_search_form(); ?>
						</section>

						<!-- Fallback Widget: Categories -->
						<section class="widget card border-0 shadow-sm p-4 mb-4 bg-white">
							<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold d-flex align-items-center gap-2">
								<i class="bi bi-tag text-primary"></i> <?php esc_html_e( 'Categories', 'robo' ); ?>
							</h4>
							<?php
							the_widget(
								'WC_Widget_Product_Categories',
								array(
									'title'        => '',
									'count'        => 1,
									'hierarchical' => 1,
									'dropdown'     => 0,
								)
							);
							?>
						</section>

						<!-- Fallback Widget: Active/Attributes Info -->
						<section class="widget card border-0 shadow-sm p-4 mb-4 bg-white">
							<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold d-flex align-items-center gap-2">
								<i class="bi bi-sliders text-primary"></i> <?php esc_html_e( 'Filter By Price', 'robo' ); ?>
							</h4>
							<p class="small text-muted mb-0">
								<?php esc_html_e( 'Assign WooCommerce widgets like "Filter by Price" or "Filter by Attribute" to the "Shop Sidebar" widget area.', 'robo' ); ?>
							</p>
						</section>
					<?php endif; ?>
				</aside>

				<!-- Custom Apply Filters Button -->
				<!-- <div class="apply-filters-wrapper mt-3 mb-4 d-none" id="robo-apply-filters-container">
					<button type="button" class="btn btn-primary w-100 robo-btn py-3 fw-bold d-flex align-items-center justify-content-center gap-2" id="robo-apply-filters-btn">
						<i class="bi bi-check-circle-fill"></i> <?php esc_html_e( 'Apply Filters', 'robo' ); ?>
					</button>
				</div> -->
			</div>
		</div>
	</div>

	<!-- Right Content Column -->
	<main id="primary" class="site-main col-lg-9 col-md-8">
		<?php if ( woocommerce_product_loop() ) : ?>
			
			<!-- Shop Toolbar Option -->
			<div class="shop-toolbar bg-white p-3 rounded shadow-sm border border-light-subtle mb-4">
				<div class="row align-items-center g-3">
					
					<!-- Left Side: Result Count & Mobile Filter Trigger -->
					<div class="col d-flex align-items-center gap-3">
						<!-- Mobile Filter Button (Visible only on <768px) -->
						<button class="btn btn-outline-primary robo-btn d-md-none d-inline-flex align-items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#shopSidebarOffcanvas" aria-controls="shopSidebarOffcanvas">
							<i class="bi bi-funnel fs-6"></i> <?php esc_html_e( 'Filters', 'robo' ); ?>
						</button>
						
						<!-- Result count text -->
						<div class="text-muted small">
							<?php woocommerce_result_count(); ?>
						</div>
					</div>

					<!-- Right Side: Order Dropdown & Layout Switcher -->
					<div class="col-auto d-flex align-items-center gap-3 flex-wrap justify-content-end">
						
						<!-- Sorting Dropdown -->
						<div class="toolbar-sort">
							<?php woocommerce_catalog_ordering(); ?>
						</div>

						<!-- Grid / List Switcher Button -->
						<div class="btn-group border border-light-subtle rounded p-1 bg-light" role="group" aria-label="<?php esc_attr_e( 'Grid or List Toggle', 'robo' ); ?>">
							<button type="button" class="btn btn-sm btn-light border-0 active text-primary" id="grid-view-btn" title="<?php esc_attr_e( 'Grid view', 'robo' ); ?>">
								<i class="bi bi-grid-3x3-gap-fill fs-5"></i>
							</button>
							<button type="button" class="btn btn-sm btn-light border-0 text-muted" id="list-view-btn" title="<?php esc_attr_e( 'List view', 'robo' ); ?>">
								<i class="bi bi-list-ul fs-5"></i>
							</button>
						</div>

					</div>
				</div>
			</div>

			<!-- Notices Banner (Coupon codes, cart updates, etc.) -->
			<div class="shop-notices-container mb-4">
				<?php
				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 */
				do_action( 'woocommerce_before_shop_loop' );
				?>
			</div>

			<!-- Dynamic WooCommerce Product Loop Grid -->
			<div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-lg-3 products transition-all products-container" id="robo-products-container">
				<?php
				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();

						/**
						 * Hook: woocommerce_shop_loop.
						 */
						do_action( 'woocommerce_shop_loop' );

						wc_get_template_part( 'content-product' );
					}
				}
				?>
			</div>

			<!-- Bootstrap Pagination -->
			<div class="row mt-4">
				<div class="col-12">
					<?php
					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
					?>
				</div>
			</div>

		<?php else : ?>
			
			<!-- Empty Products Page -->
			<?php
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
			?>

		<?php endif; ?>
	</main>

</div>

<!-- Quick View Modal Container -->
<div class="modal fade" id="roboQuickViewModal" tabindex="-1" aria-labelledby="roboQuickViewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content border-0 shadow-lg position-relative">
			<!-- Absolute positioned Close Button for guaranteed clickability and premium styling -->
			<button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3 rounded-circle bg-white p-2.5 shadow-sm border" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-4 pt-4" id="robo-quick-view-body">
				<!-- Loaded dynamically via AJAX -->
				<div class="text-center py-5">
					<div class="spinner-border text-primary" role="status">
						<span class="visually-hidden"><?php esc_html_e( 'Loading...', 'robo' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked robo_woocommerce_wrapper_end - 10
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
