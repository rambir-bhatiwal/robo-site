<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

	<div class="table-responsive rounded-3 border border-light-subtle overflow-hidden shadow-sm">
		<table class="table align-middle mb-0 woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
			<thead class="table-light">
				<tr>
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<th scope="col" class="py-3 px-4 woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr fw-bold text-dark small text-uppercase"><?php echo esc_html( $column_name ); ?></span></th>
					<?php endforeach; ?>
				</tr>
			</thead>

			<tbody>
				<?php
				foreach ( $customer_orders->orders as $customer_order ) {
					$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					$item_count = $order->get_item_count() - $order->get_item_count_refunded();
					?>
					<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order border-bottom">
						<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) :
							$is_order_number = 'order-number' === $column_id;
						?>
							<?php if ( $is_order_number ) : ?>
								<th class="py-3 px-4 woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>" scope="row">
							<?php else : ?>
								<td class="py-3 px-4 woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php endif; ?>

								<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
									<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

								<?php elseif ( $is_order_number ) : ?>
									<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="text-decoration-none fw-bold text-primary">
										<?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?>
									</a>

								<?php elseif ( 'order-date' === $column_id ) : ?>
									<time class="text-muted small" datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

								<?php elseif ( 'order-status' === $column_id ) : 
									$status = $order->get_status();
									$badge_class = 'bg-secondary-subtle text-secondary';
									if ( 'completed' === $status ) {
										$badge_class = 'bg-success-subtle text-success';
									} elseif ( 'pending' === $status || 'processing' === $status ) {
										$badge_class = 'bg-warning-subtle text-warning';
									} elseif ( 'failed' === $status || 'cancelled' === $status || 'refunded' === $status ) {
										$badge_class = 'bg-danger-subtle text-danger';
									}
									?>
									<span class="badge <?php echo esc_attr( $badge_class ); ?> text-capitalize px-3 py-2 border border-opacity-10 border-dark rounded-pill" style="font-size: 0.75rem;">
										<?php echo esc_html( wc_get_order_status_name( $status ) ); ?>
									</span>

								<?php elseif ( 'order-total' === $column_id ) : ?>
									<span class="fw-semibold text-dark">
										<?php
										/* translators: 1: formatted order total 2: total order items */
										echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
										?>
									</span>

								<?php elseif ( 'order-actions' === $column_id ) : ?>
									<div class="d-flex gap-2">
										<?php
										$actions = wc_get_account_orders_actions( $order );

										if ( ! empty( $actions ) ) {
											foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
												$btn_class = 'btn btn-sm ';
												if ( 'view' === $key ) {
													$btn_class .= 'btn-primary';
												} else {
													$btn_class .= 'btn-outline-secondary';
												}
												echo '<a href="' . esc_url( $action['url'] ) . '" class="' . esc_attr( $btn_class ) . ' px-3 fw-bold" aria-label="' . esc_attr( isset( $action['aria-label'] ) ? $action['aria-label'] : '' ) . '">' . esc_html( $action['name'] ) . '</a>';
											}
										}
										?>
									</div>
								<?php endif; ?>

							<?php if ( $is_order_number ) : ?>
								</th>
							<?php else : ?>
								</td>
							<?php endif; ?>
						<?php endforeach; ?>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination mt-4 d-flex justify-content-between">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="btn btn-outline-primary btn-sm fw-bold px-3" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<?php else : ?>
				<div></div>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="btn btn-outline-primary btn-sm fw-bold px-3" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php else : ?>
				<div></div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>

	<div class="card border-0 p-5 text-center bg-light-subtle rounded-3">
		<div class="mb-3">
			<div class="rounded-circle bg-white p-3 shadow-sm d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
				<i class="bi bi-bag-x text-muted fs-2"></i>
			</div>
		</div>
		<h5 class="fw-bold text-dark mb-2"><?php esc_html_e( 'No orders found', 'robo' ); ?></h5>
		<p class="text-muted small mb-4 mx-auto" style="max-width: 320px;"><?php esc_html_e( 'You have not made any purchases yet. Explore our store to find your favorite products.', 'robo' ); ?></p>
		<a class="btn btn-primary btn-sm px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<i class="bi bi-cart"></i>
			<span><?php esc_html_e( 'Browse products', 'woocommerce' ); ?></span>
		</a>
	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
