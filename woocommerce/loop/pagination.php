<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Robo
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$format  = isset( $format ) ? $format : '';
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );

if ( $total <= 1 ) {
	return;
}

$links = paginate_links(
	apply_filters(
		'woocommerce_pagination_args',
		array( // phpcs:ignore WordPress.WP.DeprecatedParameters.Passed
			'base'         => $base,
			'format'       => $format,
			'add_args'     => false,
			'current'      => max( 1, $current ),
			'total'        => $total,
			'prev_text'    => '<span aria-hidden="true">&laquo;</span> <span class="d-none d-sm-inline">' . esc_html__( 'Prev', 'robo' ) . '</span>',
			'next_text'    => '<span class="d-none d-sm-inline">' . esc_html__( 'Next', 'robo' ) . '</span> <span aria-hidden="true">&raquo;</span>',
			'type'         => 'array',
			'end_size'     => 1,
			'mid_size'     => 2,
		)
	)
);

if ( is_array( $links ) ) {
	?>
	<nav class="woocommerce-pagination mb-4" aria-label="<?php esc_attr_e( 'Product Pagination', 'woocommerce' ); ?>">
		<ul class="pagination justify-content-center">
			<?php
			foreach ( $links as $link ) {
				$active = strpos( $link, 'current' ) !== false;
				$class  = 'page-item';
				if ( $active ) {
					$class .= ' active';
				}

				// Standardize page-numbers class to Bootstrap's page-link.
				$link = str_replace( 'page-numbers', 'page-link page-numbers', $link );
				
				// Handle span structures (ellipses).
				if ( strpos( $link, '<span' ) !== false ) {
					if ( strpos( $link, 'dots' ) !== false ) {
						$class .= ' disabled';
					}
				}
				
				echo '<li class="' . esc_attr( $class ) . '">' . wp_kses_post( $link ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</ul>
	</nav>
	<?php
}
