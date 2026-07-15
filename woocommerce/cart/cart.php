<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="row g-4 mt-2">
	<!-- Left Column: Cart items table & coupon form -->
	<div class="col-lg-8">
		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<div class="card border-0 shadow-sm overflow-hidden mb-4">
				<div class="card-header bg-white border-bottom py-3 px-4">
					<h5 class="mb-0 fw-bold text-white text-uppercase tracking-wider" style="font-size: 0.85rem; letter-spacing: 0.5px;"><?php esc_html_e( 'Shopping Cart Items', 'woocommerce' ); ?></h5>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-hover align-middle mb-0 shop_table shop_table_responsive cart woocommerce-cart-form__contents">
							<thead class="table-light text-uppercase d-none d-md-table-header-group" style="font-size: 0.75rem; letter-spacing: 0.5px;">
								<tr>
									<th class="product-remove border-0 py-3 ps-4" style="width: 50px;"><span class="screen-reader-text"><?php esc_html_e( 'Remove item', 'woocommerce' ); ?></span></th>
									<th class="product-thumbnail border-0 py-3" style="width: 100px;"><span class="screen-reader-text"><?php esc_html_e( 'Thumbnail image', 'woocommerce' ); ?></span></th>
									<th scope="col" class="product-name border-0 py-3"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
									<th scope="col" class="product-price border-0 py-3" style="width: 120px;"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
									<th scope="col" class="product-quantity border-0 py-3" style="width: 130px;"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
									<th scope="col" class="product-subtotal border-0 py-3 pe-4 text-end" style="width: 140px;"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php do_action( 'woocommerce_before_cart_contents' ); ?>

								<?php
								foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
									$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
									$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

									$visible = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key );

									if ( $_product instanceof WC_Product && $_product->exists() && $cart_item['quantity'] > 0 && $visible ) {
										$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
										$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
										?>
										<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

											<!-- Product Remove -->
											<td class="product-remove ps-4">
												<?php
													echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
														'woocommerce_cart_item_remove_link',
														sprintf(
															'<a href="%s" class="remove btn btn-light text-danger border rounded-circle shadow-sm p-0 d-inline-flex align-items-center justify-content-center hover-scale" aria-label="%s" data-product_id="%s" data-product_sku="%s" style="width:34px; height:34px;"><i class="bi bi-trash3" style="font-size:13px;"></i></a>',
															esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
															/* translators: %s is the product name */
															esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
															esc_attr( $product_id ),
															esc_attr( $_product->get_sku() )
														),
														$cart_item_key
													);
												?>
											</td>

											<!-- Product Thumbnail -->
											<td class="product-thumbnail py-3">
												<?php
												$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'thumbnail', array( 'class' => 'rounded shadow-sm img-fluid border', 'style' => 'width:80px; height:auto; object-fit:cover;' ) ), $cart_item, $cart_item_key );

												if ( ! $product_permalink ) {
													echo $thumbnail; // PHPCS: XSS ok.
												} else {
													printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
												}
												?>
											</td>

											<!-- Product Name & Variations -->
											<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
												<?php
												if ( ! $product_permalink ) {
													echo wp_kses_post( $product_name . '&nbsp;' );
												} else {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="text-decoration-none text-dark fw-bold hover-primary transition-all d-block mb-1">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
												}

												do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

												// Meta data.
												echo '<div class="cart-item-meta text-muted small mt-1">' . wc_get_formatted_cart_item_data( $cart_item, true ) . '</div>'; // PHPCS: XSS ok.

												// Backorder notification.
												if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<div class="alert alert-warning p-2 small mt-2 mb-0 d-inline-block"><i class="bi bi-info-circle-fill me-1"></i>' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</div>', $product_id ) );
												}
												?>
											</td>

											<!-- Product Price -->
											<td class="product-price fw-semibold text-muted" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
												<?php
													echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
												?>
											</td>

											<!-- Product Quantity -->
											<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
												<?php
												if ( $_product->is_sold_individually() ) {
													$min_quantity = 1;
													$max_quantity = 1;
												} else {
													$min_quantity = 0;
													$max_quantity = $_product->get_max_purchase_quantity();
												}

												$product_quantity = woocommerce_quantity_input(
													array(
														'input_name'   => "cart[{$cart_item_key}][qty]",
														'input_value'  => $cart_item['quantity'],
														'max_value'    => $max_quantity,
														'min_value'    => $min_quantity,
														'product_name' => $product_name,
													),
													$_product,
													false
												);

												echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
												?>
											</td>

											<!-- Product Subtotal -->
											<td class="product-subtotal text-end fw-bold text-dark pe-4" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
												<?php
													echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
												?>
											</td>
										</tr>
										<?php
									}
								}
								?>

								<?php do_action( 'woocommerce_cart_contents' ); ?>

								<?php do_action( 'woocommerce_after_cart_contents' ); ?>
							</tbody>
						</table>
					</div>
				</div>
				
				<!-- Action Buttons Footer -->
				<div class="card-footer bg-white border-top p-4">
					<div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
						<div class="d-flex gap-2">
							<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-outline-secondary robo-btn hover-scale">
								<i class="bi bi-arrow-left me-2"></i><?php esc_html_e( 'Continue Shopping', 'robo' ); ?>
							</a>
							<button type="submit" class="btn btn-outline-danger robo-btn hover-scale" name="clear_cart" value="1">
								<i class="bi bi-trash3 me-2"></i><?php esc_html_e( 'Clear Cart', 'robo' ); ?>
							</button>
						</div>
						<div class="text-end">
							<?php do_action( 'woocommerce_cart_actions' ); ?>
							<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
							<button type="submit" class="btn btn-secondary robo-btn hover-scale" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" disabled aria-disabled="true">
								<i class="bi bi-arrow-clockwise me-2"></i><?php esc_html_e( 'Update Cart', 'woocommerce' ); ?>
							</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Coupon Card inside the main cart form to preserve WooCommerce AJAX logic -->
			<?php if ( wc_coupons_enabled() ) { ?>
				<div class="card border-0 shadow-sm p-4 mb-4">
					<h6 class="fw-bold mb-3 text-dark d-flex align-items-center">
						<i class="bi bi-tag-fill me-2 text-primary"></i>
						<span><?php esc_html_e( 'Promo Code / Coupon', 'robo' ); ?></span>
					</h6>
					<div class="row g-2 align-items-center">
						<div class="col-sm-6 col-md-5">
							<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
							<input type="text" name="coupon_code" class="form-control py-2.5 px-3" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Enter coupon code', 'woocommerce' ); ?>" />
						</div>
						<div class="col-sm-6 col-md-4">
							<button type="submit" class="btn btn-outline-primary robo-btn w-100 hover-scale" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply Coupon', 'woocommerce' ); ?></button>
						</div>
					</div>
					<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			<?php } ?>

			<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</form>
	</div>

	<!-- Right Column: Cart Totals & Summary -->
	<div class="col-lg-4">
		<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

		<div class="cart-collaterals">
			<?php
				/**
				 * Cart collaterals hook.
				 *
				 * @hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 */
				do_action( 'woocommerce_cart_collaterals' );
			?>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
