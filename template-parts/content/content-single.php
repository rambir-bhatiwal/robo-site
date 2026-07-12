<?php
/**
 * Template part for displaying single posts.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card border-0 shadow-sm p-4 p-md-5 mb-4' ); ?>>
	
	<!-- Header -->
	<header class="entry-header mb-4">
		<?php the_title( '<h1 class="entry-title fw-bold text-dark mb-3">', '</h1>' ); ?>
		
		<!-- Meta Tags -->
		<?php robo_post_meta(); ?>
		
		<hr class="border-light-subtle my-3">
	</header>

	<!-- Featured Image -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail mb-4 rounded overflow-hidden shadow-sm">
			<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid w-100 object-fit-cover', 'style' => 'max-height: 450px;' ) ); ?>
		</div>
	<?php endif; ?>

	<!-- Entry Content -->
	<div class="entry-content text-muted fs-6 lh-lg mb-5">
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

	<!-- Tags & Categories footer -->
	<footer class="entry-footer border-top border-light-subtle pt-4">
		<?php
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) {
			// Customize tags with badges using standard filters or direct replacement.
			// Let's output tags wrapper.
			echo '<div class="tags-wrapper d-flex flex-wrap gap-2 align-items-center mb-3">';
			echo '<span class="fw-bold text-dark me-2">' . esc_html__( 'Tags:', 'robo' ) . '</span>';
			// Replace default links to look like Bootstrap badges.
			$tags_list = str_replace( '<a href=', '<a class="badge bg-primary-subtle text-primary text-decoration-none px-3 py-2 rounded-pill" href=', $tags_list );
			echo wp_kses_post( $tags_list );
			echo '</div>';
		}
		?>
	</footer>

</article>

<!-- Post Navigation -->
<?php
$prev_post = get_previous_post();
$next_post = get_next_post();
if ( $prev_post || $next_post ) :
	?>
	<nav class="post-navigation card border-0 shadow-sm p-4 mb-4" aria-label="<?php esc_attr_e( 'Posts', 'robo' ); ?>">
		<div class="row align-items-center justify-content-between">
			<div class="col-md-6 mb-3 mb-md-0">
				<?php if ( $prev_post ) : ?>
					<div class="text-muted small mb-1"><?php esc_html_e( '← Previous Article', 'robo' ); ?></div>
					<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="fw-bold text-dark text-decoration-none hover-primary"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></a>
				<?php endif; ?>
			</div>
			<div class="col-md-6 text-md-end">
				<?php if ( $next_post ) : ?>
					<div class="text-muted small mb-1"><?php esc_html_e( 'Next Article →', 'robo' ); ?></div>
					<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="fw-bold text-dark text-decoration-none hover-primary"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</nav>
<?php endif; ?>

<!-- Author Box -->
<?php robo_author_box(); ?>

<!-- Related Posts -->
<?php robo_related_posts(); ?>
