<?php
/**
 * Template Name: Custom Fields + Content
 * Description: A custom page template displaying custom metadata fields in a table first, followed by the page content.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );

if ( ! function_exists( 'robo_format_meta_value' ) ) {
	/**
	 * Formats custom field value for table rendering.
	 * Handles string, array lists, and key-value objects.
	 *
	 * @param mixed $value Field value.
	 * @return string Formatted HTML.
	 */
	function robo_format_meta_value( $value ) {
		if ( is_array( $value ) ) {
			// If it's a key-value associative array
			if ( array_keys( $value ) !== range( 0, count( $value ) - 1 ) ) {
				$output = '<ul class="list-unstyled mb-0 small">';
				foreach ( $value as $k => $v ) {
					if ( ! is_array( $v ) && ! is_object( $v ) ) {
						$output .= '<li><strong>' . esc_html( ucwords( str_replace( array( '_', '-' ), ' ', $k ) ) ) . ':</strong> ' . esc_html( $v ) . '</li>';
					}
				}
				$output .= '</ul>';
				return $output;
			}
			return implode( ', ', array_map( 'esc_html', $value ) );
		}
		
		if ( is_object( $value ) ) {
			return esc_html__( 'Metadata Object', 'robo' );
		}

		return wp_kses_post( (string) $value );
	}
}
?>

<div id="primary" class="content-area py-5 bg-light-subtle">
	<main id="main" class="site-main">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					<!-- Header Section with Title & Featured Image -->
					<header class="entry-header mb-4 text-center">
						<h1 class="entry-title display-5 fw-extrabold text-dark mb-3"><?php the_title(); ?></h1>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="post-thumbnail my-4 rounded-3 overflow-hidden shadow-sm">
								<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid w-100 object-fit-cover', 'style' => 'max-height: 450px;' ) ); ?>
							</div>
						<?php endif; ?>
					</header>

					<!-- Custom Fields Table Section (Immediately below title/image) -->
					<?php
					$custom_fields_data = array();

					// 1. Try ACF Objects
					if ( function_exists( 'get_field_objects' ) ) {
						$acf_fields = get_field_objects();
						if ( ! empty( $acf_fields ) ) {
							foreach ( $acf_fields as $field ) {
								if ( isset( $field['value'] ) && '' !== $field['value'] && false !== $field['value'] && null !== $field['value'] ) {
									$custom_fields_data[] = array(
										'label' => $field['label'],
										'value' => $field['value'],
									);
								}
							}
						}
					}

					// 2. Fallback to native post meta
					if ( empty( $custom_fields_data ) ) {
						$post_custom = get_post_custom( get_the_ID() );
						if ( ! empty( $post_custom ) ) {
							foreach ( $post_custom as $key => $values ) {
								// Ignore internal WordPress custom fields (prefixed with _)
								if ( 0 === strpos( $key, '_' ) ) {
									continue;
								}
								
								$val = trim( $values[0] );
								if ( '' !== $val ) {
									$label = ucwords( str_replace( array( '_', '-' ), ' ', $key ) );
									$custom_fields_data[] = array(
										'label' => $label,
										'value' => $val,
									);
								}
							}
						}
					}

					if ( ! empty( $custom_fields_data ) ) :
						?>
						<div class="custom-fields-table-wrapper mb-5">
							<h3 class="h4 fw-bold text-dark mb-4 border-bottom pb-2"><i class="bi bi-list-columns-reverse text-primary me-2"></i><?php esc_html_e( 'Specifications & Details', 'robo' ); ?></h3>
							<div class="table-responsive rounded-3 overflow-hidden border border-light-subtle shadow-sm bg-white">
								<table class="table table-striped table-bordered align-middle mb-0">
									<thead class="table-dark">
										<tr>
											<th scope="col" class="py-3 px-4 w-25" style="font-size: 0.85rem; letter-spacing: 0.5px;"><?php esc_html_e( 'SPECIFICATION', 'robo' ); ?></th>
											<th scope="col" class="py-3 px-4" style="font-size: 0.85rem; letter-spacing: 0.5px;"><?php esc_html_e( 'DETAILS', 'robo' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ( $custom_fields_data as $field ) : ?>
											<tr>
												<td class="fw-bold text-dark py-3 px-4 w-25" style="background-color: rgba(0, 0, 0, 0.015);"><?php echo esc_html( $field['label'] ); ?></td>
												<td class="text-muted py-3 px-4"><?php echo robo_format_meta_value( $field['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<?php
					endif;
					?>

					<!-- Entry Content Area (After the Custom Fields table) -->
					<div class="entry-content text-muted fs-6 lh-lg mb-5">
						<?php
						the_content();

						wp_link_pages(
							array(
								'before' => '<div class="page-links mt-4 pt-3 border-top border-light-subtle"><span class="fw-bold me-2">' . esc_html__( 'Pages:', 'robo' ) . '</span>',
								'after'  => '</div>',
								'link_before' => '<span class="btn btn-outline-primary btn-sm mx-1">',
								'link_after'  => '</span>',
							)
						);
						?>
					</div>

				</article>
				<?php
				// If comments are open or we have at least one comment, load the comment template.
				if ( comments_open() || get_comments_number() ) :
					?>
					<div class="comments-wrapper mt-5 p-4 bg-white rounded-3 shadow-sm border border-light-subtle">
						<?php comments_template(); ?>
					</div>
					<?php
				endif;

			endwhile; // End of the loop.
			?>
		</div>
	</main>
</div>

<?php
get_footer();
