<?php
/**
 * WooCommerce Custom Integration Functions.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare WooCommerce support and gallery features.
 */
function robo_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'robo_woocommerce_setup' );

/**
 * Dequeue WooCommerce default layout stylesheet to prevent layout grid conflicts.
 */
function robo_dequeue_woocommerce_layout_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-layout'] );
	return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'robo_dequeue_woocommerce_layout_styles' );

/**
 * Unhook default WooCommerce templates actions that break Bootstrap layouts.
 * Executed at root level to guarantee they are removed before templates load.
 */
// Remove default wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Remove default breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Remove default loop count and ordering (we call them explicitly in our toolbar)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Remove default loop link tags (to prevent stray <a> tags in custom cards)
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

/**
 * Enqueue WooCommerce custom CSS, JS, and Bootstrap Icons.
 */
function robo_woocommerce_enqueue_assets() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// Bootstrap Icons CDN
	wp_enqueue_style(
		'bootstrap-icons',
		'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
		array(),
		'1.11.3'
	);

	// Custom WooCommerce styles
	wp_enqueue_style(
		'robo-woocommerce-styles',
		ROBO_THEME_URI . '/assets/css/woocommerce.css',
		array( 'bootstrap', 'robo-custom-style' ),
		ROBO_THEME_VERSION
	);

	// Custom WooCommerce scripts
	wp_enqueue_script(
		'robo-woocommerce-scripts',
		ROBO_THEME_URI . '/assets/js/woocommerce.js',
		array( 'jquery', 'bootstrap-bundle' ),
		ROBO_THEME_VERSION,
		true
	);

	// Custom WooCommerce single product specific styles and scripts
	if ( is_product() ) {
		wp_enqueue_style(
			'robo-single-product-styles',
			ROBO_THEME_URI . '/assets/css/single-product.css',
			array( 'robo-woocommerce-styles' ),
			ROBO_THEME_VERSION
		);

		wp_enqueue_script(
			'robo-single-product-scripts',
			ROBO_THEME_URI . '/assets/js/single-product.js',
			array( 'robo-woocommerce-scripts', 'jquery' ),
			ROBO_THEME_VERSION,
			true
		);
		
		// Pass single product context to JS
		wp_localize_script(
			'robo-single-product-scripts',
			'roboSingleProductParams',
			array(
				'productId'          => get_the_ID(),
				'ajaxUrl'            => admin_url( 'admin-ajax.php' ),
				'nonce'              => wp_create_nonce( 'robo_single_product_nonce' ),
				'cartUrl'            => wc_get_cart_url(),
				'checkoutUrl'        => wc_get_checkout_url(),
				'addingBundleMsg'    => esc_html__( 'Adding bundle to cart...', 'robo' ),
				'addedBundleMsg'     => esc_html__( 'Bundle added to cart!', 'robo' ),
				'checkZipPromptMsg'  => esc_html__( 'Checking availability...', 'robo' ),
				'zipAvailableMsg'    => esc_html__( 'Delivery available! Estimated delivery in 2-4 days.', 'robo' ),
				'zipUnavailableMsg'  => esc_html__( 'We cannot ship to this zip code. Please try another.', 'robo' ),
				'zipEnterValidMsg'   => esc_html__( 'Please enter a valid zip code.', 'robo' )
			)
		);
	}

	// Pass wishlist/quickview parameters to JS
	wp_localize_script(
		'robo-woocommerce-scripts',
		'roboWooParams',
		array(
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'nonce'          => wp_create_nonce( 'robo_woo_nonce' ),
			'cartUrl'        => wc_get_cart_url(),
			'addedToCartMsg' => esc_html__( 'Added to cart!', 'robo' ),
			'viewCartMsg'    => esc_html__( 'View Cart', 'robo' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'robo_woocommerce_enqueue_assets', 20 );

/**
 * Bootstrap WooCommerce Page Wrapper Open.
 */
function robo_woocommerce_wrapper_start() {
	// Exit if standard WordPress page (Cart, Checkout, My Account) already wrapped in page.php's container, or single product page
	if ( is_page() || is_product() ) {
		return;
	}
	$container_class = get_theme_mod( 'robo_container_width', 'container' );
	echo '<div class="robo-woocommerce-wrapper py-1 bg-light-subtle">';
	echo '<div class="' . esc_attr( $container_class ) . '">';
}
add_action( 'woocommerce_before_main_content', 'robo_woocommerce_wrapper_start', 10 );

/**
 * Bootstrap WooCommerce Page Wrapper Close.
 */
function robo_woocommerce_wrapper_end() {
	if ( is_page() || is_product() ) {
		return;
	}
	echo '</div>';
	echo '</div>';
}
add_action( 'woocommerce_after_main_content', 'robo_woocommerce_wrapper_end', 10 );

/**
 * Filter the Add to Cart button class to style with Bootstrap 5.
 *
 * @param string     $html    Default Add to Cart HTML.
 * @param WC_Product $product Product object.
 * @param array      $args    Button arguments.
 * @return string Modified HTML.
 */
function robo_woocommerce_add_to_cart_class( $html, $product, $args = array() ) {
	if ( ! $product ) {
		return $html;
	}

	$btn_class = 'robo-btn-add-to-cart add_to_cart_button';
	
	if ( $product->is_type( 'variable' ) ) {
		$btn_class = 'robo-btn-add-to-cart btn-outline-primary';
	} elseif ( $product->is_type( 'grouped' ) || $product->is_type( 'external' ) ) {
		$btn_class = 'robo-btn-add-to-cart btn-outline-secondary';
	}

	if ( $product->is_purchasable() && $product->is_in_stock() ) {
		if ( ! $product->supports( 'ajax_add_to_cart' ) ) {
			$btn_class .= ' no-ajax';
		}
	} else {
		$btn_class = 'robo-btn-add-to-cart disabled';
	}

	$html = str_replace( 'class="button', 'class="' . esc_attr( $btn_class ), $html );
	
	return $html;
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'robo_woocommerce_add_to_cart_class', 10, 3 );

/**
 * Customize WooCommerce Product Search Form.
 */
function robo_woocommerce_product_search_form( $form ) {
	$form = '<form role="search" method="get" class="woocommerce-product-search mb-0" action="' . esc_url( home_url( '/' ) ) . '">
		<label class="form-label fw-bold" for="woocommerce-product-search-field-search">' . esc_html__( 'Search Products', 'robo' ) . '</label>
		<div class="search-field-wrapper mb-3">
			<input type="search" id="woocommerce-product-search-field-search" class="search-field form-control" placeholder="' . esc_attr__( 'Search products&hellip;', 'robo' ) . '" value="' . get_search_query() . '" name="s" />
		</div>
		<button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2" value="' . esc_attr__( 'Search', 'robo' ) . '">
			<i class="bi bi-search"></i> ' . esc_html__( 'Search', 'robo' ) . '
		</button>
		<input type="hidden" name="post_type" value="product" />
	</form>';
	return $form;
}
add_filter( 'get_product_search_form', 'robo_woocommerce_product_search_form' );

function robo_general_search_form( $form ) {
	$form = '<form role="search" method="get" class="search-form mb-0" action="' . esc_url( home_url( '/' ) ) . '">
		<label class="form-label fw-bold" for="search-field">' . esc_html__( 'Search', 'robo' ) . '</label>
		<div class="search-field-wrapper mb-3">
			<input type="search" id="search-field" class="search-field form-control" placeholder="' . esc_attr__( 'Search&hellip;', 'robo' ) . '" value="' . get_search_query() . '" name="s" />
		</div>
		<button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2" value="' . esc_attr__( 'Search', 'robo' ) . '">
			<i class="bi bi-search"></i> ' . esc_html__( 'Search', 'robo' ) . '
		</button>
	</form>';
	return $form;
}
add_filter( 'get_search_form', 'robo_general_search_form' );

/**
 * Generate product badges (Sale %, New, Hot).
 *
 * @param WC_Product $product The WooCommerce product object.
 * @return string HTML markup of the badges.
 */
function robo_woocommerce_get_badges( $product ) {
	if ( ! $product ) {
		return '';
	}

	$badges = '';

	// 1. Sale Badge
	if ( $product->is_on_sale() ) {
		$percentage = 0;
		if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
			$regular_price = floatval( $product->get_regular_price() );
			$sale_price    = floatval( $product->get_sale_price() );
			if ( $regular_price > 0 ) {
				$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
			}
		} elseif ( $product->is_type( 'variable' ) ) {
			$prices      = $product->get_variation_prices();
			$max_percent = 0;
			if ( isset( $prices['regular_price'] ) && is_array( $prices['regular_price'] ) ) {
				foreach ( $prices['regular_price'] as $key => $regular_price ) {
					$sale_price = floatval( $prices['sale_price'][ $key ] );
					$regular    = floatval( $regular_price );
					if ( $regular > 0 && $sale_price < $regular ) {
						$percent = round( ( ( $regular - $sale_price ) / $regular ) * 100 );
						if ( $percent > $max_percent ) {
							$max_percent = $percent;
						}
					}
				}
			}
			$percentage = $max_percent;
		}

		$badge_text = $percentage > 0 ? sprintf( esc_html__( '-%d%%', 'robo' ), $percentage ) : esc_html__( 'Sale', 'robo' );
		$badges    .= '<span class="badge bg-danger position-absolute top-0 start-0 m-3 z-1 badge-sale text-uppercase fw-bold shadow-sm">' . $badge_text . '</span>';
	}

	// 2. New Badge (created within last 14 days)
	$post_date = get_post_time( 'U', true, $product->get_id() );
	$days_ago  = ( time() - $post_date ) / DAY_IN_SECONDS;
	if ( $days_ago <= 14 ) {
		$classes = 'badge bg-success position-absolute top-0 start-0 m-3 z-1 badge-new text-uppercase fw-bold shadow-sm';
		if ( $product->is_on_sale() ) {
			$classes .= ' badge-offset-new';
		}
		$badges .= '<span class="' . esc_attr( $classes ) . '">' . esc_html__( 'New', 'robo' ) . '</span>';
	}

	// 3. Hot / Featured Badge
	if ( $product->is_featured() ) {
		$badges .= '<span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 z-1 badge-hot text-uppercase fw-bold shadow-sm">' . esc_html__( 'Hot', 'robo' ) . '</span>';
	}

	return $badges;
}

/**
 * Generate ratings stars using Bootstrap Icons.
 *
 * @param WC_Product $product The WooCommerce product object.
 * @return string HTML star ratings.
 */
function robo_woocommerce_get_rating_html( $product ) {
	if ( ! $product ) {
		return '';
	}

	$average = $product->get_average_rating();
	$count   = $product->get_rating_count();

	$html = '<div class="product-rating d-flex align-items-center gap-1 my-2" title="' . sprintf( esc_attr__( 'Rated %s out of 5', 'robo' ), $average ) . '">';

	for ( $i = 1; $i <= 5; $i++ ) {
		if ( $average >= $i ) {
			$html .= '<i class="bi bi-star-fill text-warning"></i>';
		} elseif ( $average > ( $i - 1 ) && $average < $i ) {
			$html .= '<i class="bi bi-star-half text-warning"></i>';
		} else {
			$html .= '<i class="bi bi-star text-muted opacity-50"></i>';
		}
	}

	if ( $count > 0 ) {
		$html .= '<span class="text-muted small ms-1">(' . esc_html( $count ) . ')</span>';
	} else {
		$html .= '<span class="text-muted small ms-1 opacity-50">(0)</span>';
	}

	$html .= '</div>';

	return $html;
}

function robo_woocommerce_breadcrumbs() {
	robo_breadcrumbs();
}

/**
 * Custom AJAX handler for Quick View.
 */
function robo_woocommerce_quick_view_callback() {
	check_ajax_referer( 'robo_woo_nonce', 'nonce' );

	$product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Invalid product ID.', 'robo' ) ) );
	}

	$product = wc_get_product( $product_id );
	if ( ! $product ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Product not found.', 'robo' ) ) );
	}

	ob_start();
	?>
	<div class="row quick-view-product g-4" id="product-<?php echo esc_attr( $product_id ); ?>">
		<div class="col-md-6">
			<div class="quick-view-gallery position-relative overflow-hidden rounded bg-light border border-light-subtle">
				<?php
				$image_id  = $product->get_image_id();
				$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : wc_placeholder_img_src( 'large' );
				echo '<img src="' . esc_url( $image_url ) . '" class="img-fluid w-100 object-fit-cover" alt="' . esc_attr( $product->get_name() ) . '" style="min-height: 350px; max-height: 450px;">';
				echo robo_woocommerce_get_badges( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>
		</div>
		<div class="col-md-6 d-flex flex-column justify-content-between">
			<div>
				<?php
				$categories = wc_get_product_category_list( $product_id, ', ', '<span class="text-uppercase text-primary small fw-bold mb-1 d-block">', '</span>' );
				if ( $categories ) {
					echo wp_kses_post( $categories );
				}
				?>
				<h3 class="product_title entry-title h3 text-dark fw-bold mb-2"><?php echo esc_html( $product->get_name() ); ?></h3>
				
				<?php echo robo_woocommerce_get_rating_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				
				<div class="price h4 text-primary fw-bold my-3">
					<?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>

				<div class="woocommerce-product-details__short-description text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">
					<?php echo wp_kses_post( $product->get_short_description() ); ?>
				</div>
			</div>

			<div class="quick-view-actions border-top border-light-subtle pt-3">
				<?php
				if ( $product->is_in_stock() ) {
					woocommerce_template_single_add_to_cart();
				} else {
					echo '<p class="stock out-of-stock text-danger fw-bold mb-0"><i class="bi bi-x-circle-fill me-1"></i> ' . esc_html__( 'Out of stock', 'robo' ) . '</p>';
				}
				?>
				
				<div class="product-meta small text-muted mt-3 pt-3 border-top border-light border-opacity-50">
					<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
						<span class="sku_wrapper d-block mb-1"><?php esc_html_e( 'SKU:', 'robo' ); ?> <span class="sku text-dark"><?php echo esc_html( $product->get_sku() ? $product->get_sku() : esc_html__( 'N/A', 'robo' ) ); ?></span></span>
					<?php endif; ?>
					<span class="posted_in d-block mb-1"><?php echo wc_get_product_category_list( $product_id, ', ', esc_html__( 'Categories: ', 'robo' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</div>
			</div>
		</div>
	</div>
	<?php
	$data = ob_get_clean();

	wp_send_json_success( array( 'html' => $data ) );
}
add_action( 'wp_ajax_robo_woocommerce_quick_view', 'robo_woocommerce_quick_view_callback' );
add_action( 'wp_ajax_nopriv_robo_woocommerce_quick_view', 'robo_woocommerce_quick_view_callback' );

/**
 * Handle custom Clear Cart action.
 */
function robo_woocommerce_clear_cart_handler() {
	if ( isset( $_POST['clear_cart'] ) && isset( $_POST['woocommerce-cart-nonce'] ) ) {
		if ( wp_verify_nonce( sanitize_key( $_POST['woocommerce-cart-nonce'] ), 'woocommerce-cart' ) ) {
			WC()->cart->empty_cart();
			wc_add_notice( esc_html__( 'Cart cleared successfully.', 'robo' ), 'success' );
			wp_safe_redirect( wc_get_cart_url() );
			exit;
		}
	}
}
add_action( 'template_redirect', 'robo_woocommerce_clear_cart_handler' );

/**
 * Redirect to checkout page after "Buy Now" button click.
 */
function robo_buy_now_add_to_cart_redirect( $url ) {
	if ( isset( $_REQUEST['robo_buy_now'] ) ) {
		return wc_get_checkout_url();
	}
	return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'robo_buy_now_add_to_cart_redirect' );

/**
 * Add Buy Now Button next to Add to Cart on single product pages.
 */
function robo_add_buy_now_button_to_form() {
	global $product;
	if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
		return;
	}
	echo '<button type="submit" name="robo_buy_now" class="btn btn-warning robo-btn buy-now-btn transition-all d-inline-flex align-items-center justify-content-center gap-2" value="1"><i class="bi bi-lightning-fill"></i> ' . esc_html__( 'Buy Now', 'robo' ) . '</button>';
}
add_action( 'woocommerce_after_add_to_cart_button', 'robo_add_buy_now_button_to_form', 10 );

/**
 * AJAX handler to add FBT bundle products to the cart.
 */
function robo_ajax_add_bundle_to_cart() {
	check_ajax_referer( 'robo_single_product_nonce', 'nonce' );

	$product_ids = isset( $_POST['product_ids'] ) ? array_map( 'intval', $_POST['product_ids'] ) : array();

	if ( empty( $product_ids ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'No products selected.', 'robo' ) ) );
	}

	$added = false;
	foreach ( $product_ids as $id ) {
		if ( $id > 0 ) {
			// Add product to cart (quantity 1)
			$cart_item_key = WC()->cart->add_to_cart( $id, 1 );
			if ( $cart_item_key ) {
				$added = true;
			}
		}
	}

	if ( $added ) {
		wp_send_json_success( array( 'message' => esc_html__( 'Bundle added to your cart!', 'robo' ) ) );
	} else {
		wp_send_json_error( array( 'message' => esc_html__( 'Failed to add bundle.', 'robo' ) ) );
	}
}
add_action( 'wp_ajax_robo_add_bundle_to_cart', 'robo_ajax_add_bundle_to_cart' );
add_action( 'wp_ajax_nopriv_robo_add_bundle_to_cart', 'robo_ajax_add_bundle_to_cart' );

