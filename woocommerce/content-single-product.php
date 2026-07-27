<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check for WooCommerce to avoid fatal errors.
if ( ! class_exists( 'WooCommerce' ) || ! is_a( $product, 'WC_Product' ) ) {
	return;
}

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

// Brand extraction helper
$brands = get_the_terms( $product->get_id(), 'product_brand' );
if ( is_wp_error( $brands ) || empty( $brands ) ) {
	$brands = get_the_terms( $product->get_id(), 'brand' );
}
if ( is_wp_error( $brands ) || empty( $brands ) ) {
	$brands = get_the_terms( $product->get_id(), 'product_tag' ); // Fallback to tags if no brand taxonomy exists
}
$brand_name = '';
if ( ! is_wp_error( $brands ) && ! empty( $brands ) ) {
	$brand_name = $brands[0]->name;
}

// Categories list
$categories = wc_get_product_category_list( $product->get_id(), ', ' );

// Stock Status Badge
$stock_status = $product->get_stock_status();
$stock_html   = '';
if ( 'instock' === $stock_status ) {
	$stock_qty = $product->get_stock_quantity();
	if ( $stock_qty && $stock_qty <= 5 ) {
		$stock_html = '<span class="badge bg-warning text-dark px-2.5 py-1.5"><i class="bi bi-exclamation-triangle-fill me-1"></i>' . sprintf( esc_html__( 'Only %d left in stock!', 'robo' ), $stock_qty ) . '</span>';
	} else {
		$stock_html = '<span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5"><i class="bi bi-check-circle-fill me-1"></i>' . esc_html__( 'In Stock', 'robo' ) . '</span>';
	}
} else {
	$stock_html = '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5"><i class="bi bi-x-circle-fill me-1"></i>' . esc_html__( 'Out of Stock', 'robo' ) . '</span>';
}

// Discount Calculation
$discount_percentage_html = '';
if ( $product->is_on_sale() ) {
	if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
		$regular_price = floatval( $product->get_regular_price() );
		$sale_price    = floatval( $product->get_sale_price() );
		if ( $regular_price > 0 ) {
			$percentage               = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
			$discount_percentage_html = '<span class="badge bg-danger text-uppercase fw-bold ms-2 px-2.5 py-1.5 align-middle">' . sprintf( esc_html__( '%d%% OFF', 'robo' ), $percentage ) . '</span>';
		}
	}
}

// Gallery items collection for lightbox modal
$post_thumbnail_id = $product->get_image_id();
$attachment_ids    = $product->get_gallery_image_ids();
$gallery_items     = array();
if ( $post_thumbnail_id ) {
	$gallery_items[] = $post_thumbnail_id;
}
if ( ! empty( $attachment_ids ) ) {
	$gallery_items = array_merge( $gallery_items, $attachment_ids );
}
if ( empty( $gallery_items ) ) {
	$gallery_items[] = 0; // Fallback to placeholder
}

// Review Count
$review_count   = $product->get_review_count();
$average_rating = $product->get_average_rating();
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product-container', $product ); ?>>
	<!-- One primary Bootstrap 5 Row -->
	<div class="row g-4 align-items-stretch">
		
		<!-- Left Column: Media Gallery & Share Card -->
		<div class="col-lg-6 col-md-12 product-gallery-col">
			<div class="card border-light-subtle shadow-sm p-4 bg-white">
				
				<div class="gallery-inner-wrapper w-100">
					<?php
					/**
					 * Hook: woocommerce_before_single_product_summary.
					 *
					 * @hooked woocommerce_show_product_images - 20
					 */
					do_action( 'woocommerce_before_single_product_summary' );
					?>
				</div>
				
				<!-- Share Buttons -->
				<div class="product-share-container bg-light-subtle border border-light-subtle rounded p-3 mt-4 d-flex align-items-center justify-content-between">
					<span class="small text-muted fw-bold text-uppercase"><i class="bi bi-share-fill me-2 text-primary"></i><?php esc_html_e( 'Share Product', 'robo' ); ?></span>
					<div class="d-inline-flex gap-2">
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center share-btn" style="width: 36px; height: 36px;" target="_blank" rel="noopener" title="<?php esc_attr_e( 'Share on Facebook', 'robo' ); ?>">
							<i class="bi bi-facebook"></i>
						</a>
						<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center share-btn" style="width: 36px; height: 36px;" target="_blank" rel="noopener" title="<?php esc_attr_e( 'Share on Twitter/X', 'robo' ); ?>">
							<i class="bi bi-twitter-x"></i>
						</a>
						<a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink() ); ?>&media=<?php echo urlencode( wp_get_attachment_url( $product->get_image_id() ) ); ?>&description=<?php echo urlencode( get_the_title() ); ?>" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center share-btn" style="width: 36px; height: 36px;" target="_blank" rel="noopener" title="<?php esc_attr_e( 'Pin on Pinterest', 'robo' ); ?>">
							<i class="bi bi-pinterest"></i>
						</a>
						<a href="https://api.whatsapp.com/send?text=<?php echo urlencode( get_the_title() . ' - ' . get_permalink() ); ?>" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center share-btn" style="width: 36px; height: 36px;" target="_blank" rel="noopener" title="<?php esc_attr_e( 'Share on WhatsApp', 'robo' ); ?>">
							<i class="bi bi-whatsapp"></i>
						</a>
					</div>
				</div>
				
			</div>
		</div>
		
		<!-- Right Column: Product Info & Buy/Cart card -->
		<div class="col-lg-6 col-md-12 product-info-col d-flex flex-column">
			<div class="card border-light-subtle shadow-sm p-4 p-md-5 bg-white robo-product-details d-flex flex-column justify-content-between h-100">
				
				<div>
					<!-- Top Meta Row -->
					<div class="d-flex align-items-center justify-content-between mb-2">
						<?php if ( ! empty( $brand_name ) ) : ?>
							<span class="product-brand text-uppercase text-primary fw-extrabold tracking-wider small">
								<?php echo esc_html( $brand_name ); ?>
							</span>
						<?php else : ?>
							<span></span>
						<?php endif; ?>
						
						<?php echo $stock_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					
					<!-- Title -->
					<h1 class="product_title entry-title display-6 fw-extrabold text-dark mb-2"><?php the_title(); ?></h1>
					
					<!-- Rating & Reviews -->
					<?php if ( wc_review_ratings_enabled() ) : ?>
						<div class="product-rating-row d-flex align-items-center gap-2 mb-3">
							<?php
							if ( function_exists( 'robo_woocommerce_get_rating_html' ) ) {
								echo robo_woocommerce_get_rating_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							} else {
								woocommerce_template_single_rating();
							}
							?>
							<?php if ( $review_count > 0 ) : ?>
								<a href="#reviews" class="text-decoration-none small text-primary fw-semibold scroll-to-reviews-tab">
									<?php printf( _n( '%d Customer Review', '%d Customer Reviews', $review_count, 'robo' ), $review_count ); ?>
								</a>
							<?php else : ?>
								<span class="small text-muted opacity-75"><?php esc_html_e( 'No reviews yet', 'robo' ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					
					<!-- Meta: Categories & SKU -->
					<div class="product-meta-row d-flex flex-wrap gap-3 small text-muted border-bottom border-light-subtle pb-3 mb-3">
						<?php if ( ! empty( $categories ) ) : ?>
							<span class="meta-item">
								<strong><?php esc_html_e( 'Category:', 'robo' ); ?></strong> <?php echo wp_kses_post( $categories ); ?>
							</span>
						<?php endif; ?>
						<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
							<span class="meta-item">
								<strong><?php esc_html_e( 'SKU:', 'robo' ); ?></strong> <span class="sku"><?php echo esc_html( $product->get_sku() ? $product->get_sku() : esc_html__( 'N/A', 'robo' ) ); ?></span>
							</span>
						<?php endif; ?>
					</div>
					
					<!-- Pricing -->
					<div class="price-box-wrapper mb-4 bg-light-subtle p-3 rounded border border-light-subtle d-flex align-items-center justify-content-between flex-wrap gap-2">
						<div class="price-container">
							<span class="small text-muted d-block mb-1 text-uppercase fw-semibold"><?php esc_html_e( 'Special Price', 'robo' ); ?></span>
							<div class="price h3 text-primary fw-extrabold mb-0 d-flex align-items-center gap-2 flex-wrap">
								<?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php echo $discount_percentage_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>
						
						<!-- Points / Promo placeholder (Flipkart / Amazon style) -->
						<div class="promo-points text-end small">
							<span class="text-success fw-bold"><i class="bi bi-wallet2 me-1"></i><?php esc_html_e( 'Extra Discount', 'robo' ); ?></span>
							<span class="text-muted d-block"><?php esc_html_e( 'With bank offers', 'robo' ); ?></span>
						</div>
					</div>
					
					<!-- Short Description -->
					<?php if ( $product->get_short_description() ) : ?>
						<div class="product-short-description text-muted mb-4 fs-6 border-bottom border-light-subtle pb-4">
							<?php echo wp_kses_post( $product->get_short_description() ); ?>
						</div>
					<?php endif; ?>
				</div>
				
				<div>
					<!-- Main Variations & Add to Cart form -->
					<div class="robo-cart-form-wrapper mb-4">
						<?php
						/**
						 * Hook: woocommerce_single_product_summary.
						 *
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 */
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
						
						do_action( 'woocommerce_single_product_summary' );
						?>
					</div>
					
					<!-- Secondary Actions (Wishlist & Compare) -->
					<div class="product-actions-secondary d-flex flex-wrap gap-2 mb-4 pb-4 border-bottom border-light-subtle">
						<!-- Wishlist Button -->
						<?php if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) : ?>
							<div class="wishlist-wrapper flex-grow-1">
								<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
							</div>
						<?php else : ?>
							<button type="button" class="btn btn-outline-secondary robo-btn flex-grow-1 d-inline-flex align-items-center justify-content-center gap-2 single-add-to-wishlist-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
								<i class="bi bi-heart"></i> <?php esc_html_e( 'Add to Wishlist', 'robo' ); ?>
							</button>
						<?php endif; ?>

						<!-- Compare Button -->
						<?php if ( shortcode_exists( 'yith_woocompare_button' ) ) : ?>
							<div class="compare-wrapper flex-grow-1">
								<?php echo do_shortcode( '[yith_woocompare_button]' ); ?>
							</div>
						<?php else : ?>
							<button type="button" class="btn btn-outline-secondary robo-btn flex-grow-1 d-inline-flex align-items-center justify-content-center gap-2 single-add-to-compare-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
								<i class="bi bi-shuffle"></i> <?php esc_html_e( 'Add to Compare', 'robo' ); ?>
							</button>
						<?php endif; ?>
					</div>
					
					<!-- Delivery Check Simulator -->
					<div class="card border-light-subtle bg-light-subtle shadow-sm mb-4">
						<div class="card-body p-3">
							<h6 class="card-title fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-primary me-2"></i><?php esc_html_e( 'Delivery Options', 'robo' ); ?></h6>
							<div class="input-group mb-2 check-delivery-zip">
								<input type="text" class="form-control form-control-sm border-light-subtle" placeholder="<?php esc_attr_e( 'Enter Zip Code', 'robo' ); ?>" id="deliveryZipInput" maxlength="6">
								<button class="btn btn-primary robo-btn" type="button" id="deliveryZipCheckBtn"><?php esc_html_e( 'Check', 'robo' ); ?></button>
							</div>
							<div id="deliveryZipFeedback" class="small fw-semibold mb-2 d-none"></div>
							<ul class="list-unstyled mb-0 d-flex flex-column gap-2 text-muted small mt-2 pt-2 border-top border-light">
								<li><i class="bi bi-truck me-2 text-success"></i><?php esc_html_e( 'Free shipping on orders above $50.', 'robo' ); ?></li>
								<li><i class="bi bi-cash-stack me-2 text-success"></i><?php esc_html_e( 'Cash on Delivery available.', 'robo' ); ?></li>
								<li><i class="bi bi-clock-history me-2 text-success"></i><?php esc_html_e( 'Standard delivery: 2 - 4 business days.', 'robo' ); ?></li>
							</ul>
						</div>
					</div>
					
					<!-- Trust Badges & Return Policies -->
					<div class="row g-3 text-center mb-4 pb-4 border-bottom border-light-subtle">
						<div class="col-4">
							<div class="p-2 border border-light-subtle rounded bg-light-subtle h-100 d-flex flex-column align-items-center justify-content-center">
								<i class="bi bi-arrow-left-right text-primary fs-3 mb-1"></i>
								<span class="small fw-bold text-dark d-block" style="font-size: 0.78rem; line-height: 1.2;"><?php esc_html_e( '7-Day Return', 'robo' ); ?></span>
							</div>
						</div>
						<div class="col-4">
							<div class="p-2 border border-light-subtle rounded bg-light-subtle h-100 d-flex flex-column align-items-center justify-content-center">
								<i class="bi bi-shield-check text-success fs-3 mb-1"></i>
								<span class="small fw-bold text-dark d-block" style="font-size: 0.78rem; line-height: 1.2;"><?php esc_html_e( 'Brand Warranty', 'robo' ); ?></span>
							</div>
						</div>
						<div class="col-4">
							<div class="p-2 border border-light-subtle rounded bg-light-subtle h-100 d-flex flex-column align-items-center justify-content-center">
								<i class="bi bi-patch-check text-info fs-3 mb-1"></i>
								<span class="small fw-bold text-dark d-block" style="font-size: 0.78rem; line-height: 1.2;"><?php esc_html_e( '100% Genuine', 'robo' ); ?></span>
							</div>
						</div>
					</div>
					
					<!-- Secure checkout info -->
					<div class="secure-checkout-trust text-center">
						<span class="small text-muted d-block mb-2"><i class="bi bi-lock-fill text-success me-1"></i><?php esc_html_e( '100% Safe & Secure Payments', 'robo' ); ?></span>
						<div class="d-flex justify-content-center align-items-center gap-3 flex-wrap opacity-75">
							<i class="bi bi-credit-card-2-back text-secondary fs-4" title="Visa/MasterCard"></i>
							<i class="bi bi-paypal text-secondary fs-4" title="PayPal"></i>
							<i class="bi bi-wallet2 text-secondary fs-4" title="NetBanking/COD"></i>
							<i class="bi bi-apple text-secondary fs-4" title="Apple Pay"></i>
						</div>
					</div>
				</div>
				
			</div>
		</div>

	</div> <!-- Close primary row for gallery & info -->

	<!-- Row for full width section lists (FBT, Tabs, Upsells, Related) -->
	<div class="row g-4 mt-2">

		<!-- Below Product: Frequently Bought Together placeholder (Amazon style) -->
		<?php
		$fbt_ids = wc_get_related_products( $product->get_id(), 2 );
		$fbt_products = array();
		if ( ! empty( $fbt_ids ) ) {
			foreach ( $fbt_ids as $fbt_id ) {
				$fbt_products[] = wc_get_product( $fbt_id );
			}
		}
		$show_fbt = ! empty( $fbt_products );
		?>
		<?php if ( $show_fbt ) : ?>
			<div class="col-12 mt-4 frequently-bought-together-col">
				<div class="frequently-bought-together card border-light-subtle shadow-sm bg-white">
					<div class="card-header bg-dark py-3 border-bottom border-secondary">
						<h4 class="h5 mb-0 fw-bold text-white"><i class="bi bi-diagram-3-fill text-primary me-2"></i><?php esc_html_e( 'Frequently Bought Together', 'robo' ); ?></h4>
					</div>
					<div class="card-body p-4">
						<div class="row align-items-center g-4">
							
							<!-- Left Side: Horizontal Product Images chain -->
							<div class="col-lg-8 col-12">
								<div class="d-flex align-items-center gap-3 flex-wrap justify-content-start fbt-chain-wrapper">
									<!-- Main Current Product -->
									<div class="fbt-product-item text-center" style="max-width: 120px;">
										<div class="ratio ratio-1x1 border border-light-subtle rounded p-1 bg-white mb-2 overflow-hidden position-relative">
											<?php echo $product->get_image( 'thumbnail', array( 'class' => 'object-fit-contain' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</div>
										<span class="small fw-semibold text-dark line-clamp-1"><?php echo esc_html( $product->get_name() ); ?></span>
										<span class="small text-muted d-block"><?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									
									<?php foreach ( $fbt_products as $fbt_prod ) : ?>
										<div class="fbt-plus-sign h3 text-muted mb-4 font-weight-light">+</div>
										
										<div class="fbt-product-item text-center" style="max-width: 120px;">
											<div class="ratio ratio-1x1 border border-light-subtle rounded p-1 bg-white mb-2 overflow-hidden position-relative">
												<?php echo $fbt_prod->get_image( 'thumbnail', array( 'class' => 'object-fit-contain' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
											</div>
											<a href="<?php echo esc_url( $fbt_prod->get_permalink() ); ?>" class="text-decoration-none text-dark small fw-semibold line-clamp-1 hover-primary"><?php echo esc_html( $fbt_prod->get_name() ); ?></a>
											<span class="small text-muted d-block"><?php echo $fbt_prod->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
									<?php endforeach; ?>
									
								</div>
							</div>
							
							<!-- Right Side: Checkbox selections & Bulk add-to-cart button -->
							<div class="col-lg-4 col-12 border-start-lg border-light-subtle ps-lg-4">
								<div class="fbt-checkout-box">
									<div class="fbt-total-price-row mb-3">
										<span class="text-muted small d-block"><?php esc_html_e( 'Total Price:', 'robo' ); ?></span>
										<span class="h4 text-primary fw-extrabold mb-0 fbt-total-price-display" data-current-price="<?php echo esc_attr( $product->get_price() ); ?>">
											<?php
											$total_price = floatval( $product->get_price() );
											foreach ( $fbt_products as $fbt_prod ) {
												$total_price += floatval( $fbt_prod->get_price() );
											}
											echo wc_price( $total_price ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											?>
										</span>
									</div>
									
									<!-- Checkboxes -->
									<div class="fbt-checkbox-list d-flex flex-column gap-2 mb-3">
										<div class="form-check small">
											<input class="form-check-input fbt-checkbox" type="checkbox" value="<?php echo esc_attr( $product->get_id() ); ?>" id="fbt-check-main" checked disabled data-price="<?php echo esc_attr( $product->get_price() ); ?>">
											<label class="form-check-label text-dark fw-bold" for="fbt-check-main">
												<?php esc_html_e( 'This item:', 'robo' ); ?> <span class="fw-normal text-muted"><?php echo esc_html( $product->get_name() ); ?></span>
											</label>
										</div>
										
										<?php foreach ( $fbt_products as $idx => $fbt_prod ) : ?>
											<div class="form-check small">
												<input class="form-check-input fbt-checkbox" type="checkbox" value="<?php echo esc_attr( $fbt_prod->get_id() ); ?>" id="fbt-check-<?php echo esc_attr( $idx ); ?>" checked data-price="<?php echo esc_attr( $fbt_prod->get_price() ); ?>">
												<label class="form-check-label text-dark fw-semibold" for="fbt-check-<?php echo esc_attr( $idx ); ?>">
													<span class="fw-normal text-muted"><?php echo esc_html( $fbt_prod->get_name() ); ?></span>
												</label>
											</div>
										<?php endforeach; ?>
									</div>
									
									<!-- Add Bundle button -->
									<button type="button" class="btn btn-warning robo-btn w-100 shadow-sm fbt-add-to-cart-btn">
										<i class="bi bi-cart-plus-fill me-2"></i><?php esc_html_e( 'Add Bundle to Cart', 'robo' ); ?>
									</button>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<!-- Below Product: Tabs (Description, Additional Info, Reviews) -->
		<div class="col-12 mt-4 woocommerce-tabs-col">
			<div class="card border-light-subtle shadow-sm woocommerce-tabs-card overflow-hidden bg-white">
				<div class="card-body p-3 p-md-4">
					<?php
					/**
					 * Hook: woocommerce_after_single_product_summary.
					 *
					 * @hooked woocommerce_output_product_data_tabs - 10
					 * @hooked woocommerce_upsell_display - 15
					 * @hooked woocommerce_output_related_products - 20
					 */
					remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
					remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
					
					do_action( 'woocommerce_after_single_product_summary' );
					?>
				</div>
			</div>
		</div>

		<!-- Below Product: Upsells Grid -->
		<div class="col-12 mt-4 product-upsells-col">
			<?php
			// Render Upsells manually to control bootstrap classes and wrappers
			woocommerce_upsell_display( 4, 4 );
			?>
		</div>

		<!-- Below Product: Related Products Grid -->
		<div class="col-12 mt-4 product-related-col">
			<?php
			// Render Related Products manually to control bootstrap classes and wrappers
			woocommerce_output_related_products( array(
				'posts_per_page' => 4,
				'columns'        => 4,
			) );
			?>
		</div>

		<!-- Below Product: Recently Viewed Products (Cookie-based track) -->
		<?php
		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
		$viewed_products = array_filter( array_map( 'intval', $viewed_products ) );
		
		if ( ( $key = array_search( $product->get_id(), $viewed_products ) ) !== false ) {
			unset( $viewed_products[ $key ] );
		}
		
		if ( ! empty( $viewed_products ) ) :
			$rv_query = new WP_Query( array(
				'post_type'      => 'product',
				'post__in'       => $viewed_products,
				'posts_per_page' => 4,
				'orderby'        => 'post__in',
			) );
			
			if ( $rv_query->have_posts() ) :
				?>
				<div class="col-12 mt-4 product-recent-col">
					<section class="recently-viewed-products my-4">
						<h2 class="h4 mb-4 fw-bold text-dark d-flex align-items-center gap-2 border-bottom border-light-subtle pb-3">
							<i class="bi bi-clock-history text-primary"></i> <?php esc_html_e( 'Recently Viewed Products', 'robo' ); ?>
						</h2>
						<div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
							<?php
							while ( $rv_query->have_posts() ) {
								$rv_query->the_post();
								
								// Setup WC global product loop post details
								wc_get_template_part( 'content-product' );
							}
							wp_reset_postdata();
							?>
						</div>
					</section>
				</div>
				<?php
			endif;
		endif;
		?>
		
	</div> <!-- .row -->
</div>

<?php
/**
 * Hook: woocommerce_after_single_product.
 */
do_action( 'woocommerce_after_single_product' );
?>

<!-- Fullscreen PhotoSwipe-like Lightbox Modal using Bootstrap 5 -->
<div class="modal fade" id="roboGalleryLightboxModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-md-down">
		<div class="modal-content border-0 bg-dark text-white position-relative">
			<button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3 rounded-circle bg-black bg-opacity-50 p-2.5 shadow-sm border border-light border-opacity-10" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-0 d-flex flex-column align-items-center justify-content-center bg-black" style="min-height: 80vh;">
				
				<!-- Lightbox main content -->
				<div id="roboLightboxCarousel" class="carousel slide w-100 h-100 d-flex flex-column justify-content-between" data-bs-ride="false" data-bs-touch="true">
					<div class="carousel-inner flex-grow-1 d-flex align-items-center">
						<?php foreach ( $gallery_items as $index => $attachment_id ) : ?>
							<?php
							$active_class = ( 0 === $index ) ? 'active' : '';
							$full_url     = ( 0 === $attachment_id ) ? wc_placeholder_img_src( 'full' ) : wp_get_attachment_image_url( $attachment_id, 'full' );
							?>
							<div class="carousel-item <?php echo esc_attr( $active_class ); ?> text-center" data-lightbox-index="<?php echo esc_attr( $index ); ?>">
								<img src="<?php echo esc_url( $full_url ); ?>" class="img-fluid object-fit-contain mx-auto" alt="Lightbox Image <?php echo esc_attr( $index + 1 ); ?>" style="max-height: 80vh; max-width: 90%;">
							</div>
						<?php endforeach; ?>
					</div>
					
					<!-- Lightbox Controls -->
					<?php if ( count( $gallery_items ) > 1 ) : ?>
						<button class="carousel-control-prev" type="button" data-bs-target="#roboLightboxCarousel" data-bs-slide="prev">
							<span class="carousel-control-prev-icon bg-black bg-opacity-50 rounded-circle p-3 d-flex align-items-center justify-content-center" aria-hidden="true" style="background-size: 50%;"></span>
							<span class="visually-hidden"><?php esc_html_e( 'Previous', 'robo' ); ?></span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#roboLightboxCarousel" data-bs-slide="next">
							<span class="carousel-control-next-icon bg-black bg-opacity-50 rounded-circle p-3 d-flex align-items-center justify-content-center" aria-hidden="true" style="background-size: 50%;"></span>
							<span class="visually-hidden"><?php esc_html_e( 'Next', 'robo' ); ?></span>
						</button>
						
						<!-- Thumbnails navigation at bottom of lightbox -->
						<div class="lightbox-thumbs-container py-3 bg-dark bg-opacity-75 border-top border-secondary border-opacity-10 d-flex justify-content-center gap-2 overflow-x-auto w-100 flex-nowrap px-3">
							<?php foreach ( $gallery_items as $index => $attachment_id ) : ?>
								<?php
								$thumb_url    = ( 0 === $attachment_id ) ? wc_placeholder_img_src( 'thumbnail' ) : wp_get_attachment_image_url( $attachment_id, 'thumbnail' );
								$active_class = ( 0 === $index ) ? 'active border-primary shadow-sm' : 'border-secondary';
								?>
								<button type="button" 
										data-bs-target="#roboLightboxCarousel" 
										data-bs-slide-to="<?php echo esc_attr( $index ); ?>" 
										class="lightbox-thumb-btn btn p-0 border border-2 rounded overflow-hidden <?php echo esc_attr( $active_class ); ?>" 
										style="width: 48px; height: 48px; flex-shrink: 0;"
										aria-label="<?php echo esc_attr( sprintf( __( 'Lightbox slide %d', 'robo' ), $index + 1 ) ); ?>">
									<img src="<?php echo esc_url( $thumb_url ); ?>" class="w-100 h-100 object-fit-cover" alt="Lightbox Thumb <?php echo esc_attr( $index + 1 ); ?>" />
								</button>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
				
			</div>
		</div>
	</div>
</div>
