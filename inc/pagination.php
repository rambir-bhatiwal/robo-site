<?php
/**
 * Bootstrap 5 Pagination.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'robo_pagination' ) ) {
	/**
	 * Output Bootstrap 5 pagination markup.
	 *
	 * @param WP_Query|null $query Custom query to paginate, defaults to global $wp_query.
	 */
	function robo_pagination( $query = null ) {
		if ( null === $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		$pages = $query->max_num_pages;
		if ( $pages <= 1 ) {
			return;
		}

		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		if ( empty( $paged ) ) {
			$paged = 1;
		}

		$links = paginate_links(
			array(
				'total'        => $pages,
				'current'      => $paged,
				'type'         => 'array',
				'prev_text'    => '<span aria-hidden="true">&laquo;</span> <span class="d-none d-sm-inline">' . esc_html__( 'Prev', 'robo' ) . '</span>',
				'next_text'    => '<span class="d-none d-sm-inline">' . esc_html__( 'Next', 'robo' ) . '</span> <span aria-hidden="true">&raquo;</span>',
				'mid_size'     => 2,
				'end_size'     => 1,
			)
		);

		if ( ! is_array( $links ) ) {
			return;
		}
		?>
		<nav aria-label="<?php esc_attr_e( 'Page navigation', 'robo' ); ?>" class="my-5">
			<ul class="pagination justify-content-center">
				<?php
				foreach ( $links as $link ) {
					$active = strpos( $link, 'current' ) !== false;
					$class  = 'page-item';
					if ( $active ) {
						$class .= ' active';
					}

					// Standardize tag strings to use Bootstrap classes.
					$link = str_replace( 'page-numbers', 'page-link page-numbers', $link );
					
					// If it is span (active or ellipsis).
					if ( strpos( $link, '<span' ) !== false ) {
						// Add disabled class if it is dotdotdot.
						if ( strpos( $link, 'dots' ) !== false ) {
							$class .= ' disabled';
						}
					}
					
					echo '<li class="' . esc_attr( $class ) . '">' . wp_kses_post( $link ) . '</li>';
				}
				?>
			</ul>
		</nav>
		<?php
	}
}
