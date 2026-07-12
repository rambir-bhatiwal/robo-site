<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="no-results not-found card border-0 shadow-sm p-4 p-md-5 mb-4 text-center">
	
	<header class="page-header mb-4">
		<h1 class="page-title fw-bold text-dark mb-3"><?php esc_html_e( 'Nothing Found', 'robo' ); ?></h1>
	</header>

	<div class="page-content py-4">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p class="text-muted mb-4">
				<?php
				printf(
					wp_kses(
						/* translators: 1: Link to WP Admin post creation page */
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'robo' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>
		<?php elseif ( is_search() ) : ?>
			<p class="text-muted mb-4"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'robo' ); ?></p>
			<div class="row justify-content-center">
				<div class="col-md-6">
					<?php get_search_form(); ?>
				</div>
			</div>
		<?php else : ?>
			<p class="text-muted mb-4"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'robo' ); ?></p>
			<div class="row justify-content-center">
				<div class="col-md-6">
					<?php get_search_form(); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>

</section>
