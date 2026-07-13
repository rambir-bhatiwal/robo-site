<?php
/**
 * Template Name: Full Width Page
 * Description: A reusable, responsive full-width page template without sidebars.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );
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

					<!-- Entry Content Area -->
					<div class="entry-content text-muted fs-6 lh-lg">
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
