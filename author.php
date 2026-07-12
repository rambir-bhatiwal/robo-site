<?php
/**
 * The template for displaying Author archive pages.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$container_class = get_theme_mod( 'robo_container_width', 'container' );

// Retrieve the author object.
$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
if ( ! $author ) {
	$author = get_userdata( get_query_var( 'author' ) );
}
?>

<!-- Author Profile Header -->
<div class="author-archive-header py-5 bg-light mb-4 border-bottom border-light-subtle">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row align-items-center justify-content-center text-center text-md-start">
			<div class="col-md-2 text-center mb-3 mb-md-0">
				<?php echo get_avatar( $author->ID, 120, '', $author->display_name, array( 'class' => 'rounded-circle shadow-sm border border-white border-4' ) ); ?>
			</div>
			<div class="col-md-8">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-1 d-block"><?php esc_html_e( 'Author Archive', 'robo' ); ?></span>
				<h1 class="display-5 fw-bold text-dark mb-2"><?php echo esc_html( $author->display_name ); ?></h1>
				<?php if ( ! empty( $author->description ) ) : ?>
					<p class="lead text-muted mb-0"><?php echo esc_html( $author->description ); ?></p>
				<?php else : ?>
					<p class="lead text-muted mb-0"><?php printf( esc_html__( 'All articles written by %s.', 'robo' ), esc_html( $author->display_name ) ); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-md-2 text-center text-md-end mt-3 mt-md-0">
				<div class="badge bg-primary fs-6 py-2 px-3 rounded shadow-sm">
					<?php echo esc_html( count_user_posts( $author->ID ) ) . ' ' . esc_html__( 'Posts', 'robo' ); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-wrapper py-4">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		
		<!-- Breadcrumbs -->
		<?php robo_breadcrumbs(); ?>

		<div class="row">
			
			<!-- Main Column -->
			<main id="primary" class="site-main col-lg-8">
				<?php
				if ( have_posts() ) :

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content/content', get_post_format() );

					endwhile;

					robo_pagination();

				else :

					get_template_part( 'template-parts/content/content', 'none' );

				endif;
				?>
			</main><!-- #primary -->

			<!-- Sidebar Column -->
			<div class="col-lg-4">
				<?php get_sidebar( 'blog' ); ?>
			</div>

		</div>
	</div>
</div>

<?php
get_footer();
