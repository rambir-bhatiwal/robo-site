<?php
/**
 * Template part for displaying posts.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card border-0 shadow-sm overflow-hidden mb-4' ); ?>>
	
	<!-- Post Thumbnail -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid w-100 object-fit-cover', 'style' => 'max-height: 400px;' ) ); ?>
			</a>
		</div>
	<?php endif; ?>

	<!-- Post Content -->
	<div class="card-body p-4 p-md-5">
		
		<!-- Meta Tags -->
		<?php robo_post_meta(); ?>

		<!-- Title -->
		<h2 class="entry-title h2 fw-bold mb-3">
			<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none hover-primary"><?php the_title(); ?></a>
		</h2>

		<!-- Excerpt -->
		<div class="entry-content text-muted mb-4 fs-6">
			<?php the_excerpt(); ?>
		</div>

		<!-- Read More button -->
		<a href="<?php the_permalink(); ?>" class="btn btn-primary px-4 py-2 fw-semibold">
			<?php esc_html_e( 'Read More', 'robo' ); ?>
		</a>

	</div>
</article>
