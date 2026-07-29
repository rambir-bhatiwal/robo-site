<?php
/**
 * Archive Template for Learning Resources
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Fetch categories and tags for filter dropdowns
$categories = get_terms( array(
	'taxonomy'   => 'learning_category',
	'hide_empty' => false,
) );

$tags = get_terms( array(
	'taxonomy'   => 'learning_tag',
	'hide_empty' => false,
) );
?>

<div class="robo-lr-archive-page bg-light py-5">
	<div class="container">

		<!-- Page Header Hero Banner -->
		<div class="row justify-content-center text-center mb-5">
			<div class="col-lg-8">
				<span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold mb-2 text-uppercase">Knowledge Base & Tutorials</span>
				<h1 class="display-4 fw-bold text-dark mb-3">Learning Resources</h1>
				<p class="lead text-muted">Explore our curated collection of robotics, electronics, PCB design, and programming tutorials, documentation, and source code.</p>
			</div>
		</div>

		<!-- Interactive Filter & Search Bar -->
		<div class="robo-lr-filter-bar mb-4">
			<div class="row g-3 align-items-center">
				<!-- Search -->
				<div class="col-lg-3 col-md-6">
					<div class="input-group">
						<span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
						<input type="text" id="robo_lr_filter_search" class="form-control border-start-0 ps-0" placeholder="Search resources...">
					</div>
				</div>

				<!-- Category Filter -->
				<div class="col-lg-3 col-md-6">
					<select id="robo_lr_filter_cat" class="form-select">
						<option value="">All Categories</option>
						<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
							<?php foreach ( $categories as $cat ) : ?>
								<option value="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?>)</option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>

				<!-- Difficulty Filter -->
				<div class="col-lg-2 col-md-4">
					<select id="robo_lr_filter_difficulty" class="form-select">
						<option value="">All Levels</option>
						<option value="beginner">Beginner</option>
						<option value="intermediate">Intermediate</option>
						<option value="advanced">Advanced</option>
					</select>
				</div>

				<!-- Tags Filter -->
				<div class="col-lg-2 col-md-4">
					<select id="robo_lr_filter_tag" class="form-select">
						<option value="">All Tags</option>
						<?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
							<?php foreach ( $tags as $tag_item ) : ?>
								<option value="<?php echo esc_attr( $tag_item->slug ); ?>"><?php echo esc_html( $tag_item->name ); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>

				<!-- Reset Filters -->
				<div class="col-lg-2 col-md-4 text-md-end">
					<button type="button" id="robo_lr_filter_reset" class="btn btn-outline-secondary w-100">
						<i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
					</button>
				</div>
			</div>
		</div>

		<!-- Results Count Header -->
		<div class="d-flex justify-content-between align-items-center mb-4">
			<span id="robo-lr-results-count" class="fw-semibold text-muted">
				<?php
				global $wp_query;
				printf( esc_html__( '%d Resources Available', 'robo' ), esc_html( $wp_query->found_posts ) );
				?>
			</span>
		</div>

		<!-- Grid Container -->
		<div id="robo-lr-archive-grid" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content-learning-resource-card' ); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<div class="col-12 text-center py-5">
					<div class="card border-0 shadow-sm p-5 bg-white">
						<i class="bi bi-journal-x fs-1 text-muted mb-3"></i>
						<h3>No Learning Resources Found</h3>
						<p class="text-muted">No learning resources match your current query.</p>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- Pagination -->
		<div id="robo-lr-archive-pagination" class="mt-4">
			<?php
			the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => __( '&laquo; Previous', 'robo' ),
				'next_text' => __( 'Next &raquo;', 'robo' ),
				'class'     => 'pagination justify-content-center mt-5',
			) );
			?>
		</div>

	</div>
</div>

<?php
get_footer();
