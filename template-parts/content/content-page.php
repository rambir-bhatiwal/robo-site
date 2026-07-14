<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
$is_woo_page = false;
if ( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
	$is_woo_page = true;
}
$article_classes = $is_woo_page ? 'entry-content-wrap mb-4' : 'card border-0 shadow-sm p-4 p-md-5 mb-4';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $article_classes ); ?>>
	
	<?php if ( ! $is_woo_page ) : ?>
		<header class="entry-header mb-4">
			<?php the_title( '<h1 class="entry-title fw-bold text-dark mb-0">', '</h1>' ); ?>
			<hr class="border-light-subtle my-3">
		</header>
	<?php endif; ?>

	<!-- Page Featured Image -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail mb-4 rounded overflow-hidden">
			<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid w-100' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content text-muted fs-6 lh-lg">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links mt-4"><span class="fw-bold me-2">' . esc_html__( 'Pages:', 'robo' ) . '</span>',
				'after'  => '</div>',
				'link_before' => '<span class="badge bg-secondary p-2 me-1">',
				'link_after'  => '</span>',
			)
		);
		?>
	</div>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer border-top border-light-subtle pt-3 mt-4">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'robo' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link btn btn-outline-secondary btn-sm">',
				'</span>'
			);
			?>
		</footer>
	<?php endif; ?>

</article>
