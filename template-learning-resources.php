<?php
/**
 * Template Name: Learning Resources
 * Template Post Type: page
 * Description: Custom landing page template for Learning Resources with horizontal cards layout.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Fetch taxonomies for filter dropdowns
$categories = get_terms( array(
	'taxonomy'   => 'learning_category',
	'hide_empty' => false,
) );

// Filter & Query Parameters
$paged       = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
$search_term = isset( $_GET['search'] ) ? sanitize_text_field( wp_unslash( $_GET['search'] ) ) : '';
$cat_filter  = isset( $_GET['category'] ) ? sanitize_text_field( wp_unslash( $_GET['category'] ) ) : '';
$diff_filter = isset( $_GET['difficulty'] ) ? sanitize_text_field( wp_unslash( $_GET['difficulty'] ) ) : '';
$sort_filter = isset( $_GET['sort'] ) ? sanitize_text_field( wp_unslash( $_GET['sort'] ) ) : 'newest';

// Build WP_Query
$query_args = array(
	'post_type'      => 'learning-resource',
	'post_status'    => 'publish',
	'posts_per_page' => 8,
	'paged'          => $paged,
);

// Search Query
if ( ! empty( $search_term ) ) {
	$query_args['s'] = $search_term;
}

// Taxonomy Filter
if ( ! empty( $cat_filter ) ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'learning_category',
			'field'    => 'slug',
			'terms'    => $cat_filter,
		),
	);
}

// Meta Query for Difficulty
if ( ! empty( $diff_filter ) ) {
	$query_args['meta_query'] = array(
		array(
			'key'     => '_robo_lr_difficulty',
			'value'   => $diff_filter,
			'compare' => '=',
		),
	);
}

// Sorting Query
switch ( $sort_filter ) {
	case 'oldest':
		$query_args['orderby'] = 'date';
		$query_args['order']   = 'ASC';
		break;
	case 'title_asc':
		$query_args['orderby'] = 'title';
		$query_args['order']   = 'ASC';
		break;
	case 'title_desc':
		$query_args['orderby'] = 'title';
		$query_args['order']   = 'DESC';
		break;
	case 'newest':
	default:
		$query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';
		break;
}

$resources_query = new WP_Query( $query_args );
$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<div class="robo-lr-template-wrapper bg-light pb-5">

	<!-- 1. HERO SECTION -->
	<section class="robo-lr-single-hero py-5 text-white" style="background: linear-gradient(135deg, #090F1d 0%, #002266 100%);">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row align-items-center justify-content-center text-center">
				<div class="col-lg-9 col-xl-8">
					<span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 text-uppercase shadow-sm">
						🤖 Learning Hub & Engineering Guides
					</span>
					<h1 class="display-4 fw-bold mb-3 text-white">
						<?php echo esc_html( get_the_title() ); ?>
					</h1>
					<p class="lead text-light opacity-90 mb-0">
						Explore comprehensive robotics tutorials, Arduino guides, PCB design schematics, firmware code, and component datasheets.
					</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 2. BREADCRUMB SECTION -->
	<div class="breadcrumb-section my-3">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<?php robo_breadcrumbs(); ?>
		</div>
	</div>

	<!-- 3. WORDPRESS PAGE CONTENT (the_content) -->
	<?php
	while ( have_posts() ) :
		the_post();
		$page_content = get_the_content();
		if ( ! empty( trim( $page_content ) ) ) :
			?>
			<div class="<?php echo esc_attr( $container_class ); ?> mb-4">
				<div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 bg-white entry-content">
					<?php the_content(); ?>
				</div>
			</div>
			<?php
		endif;
	endwhile;
	?>

	<!-- 4. LEARNING RESOURCES LISTING & FILTERS -->
	<div class="<?php echo esc_attr( $container_class ); ?> my-4">
		
		<!-- Filters Form -->
		<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
			<form method="GET" id="robo-lr-filter-form" action="<?php echo esc_url( get_permalink() ); ?>">
				<div class="row g-3 align-items-center">
					
					<!-- Search Input -->
					<div class="col-lg-3 col-md-6">
						<label for="robo_lr_tpl_search" class="form-label small fw-semibold text-muted mb-1">Search Keywords</label>
						<div class="input-group">
							<span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
							<input type="text" id="robo_lr_tpl_search" name="search" class="form-control border-start-0 bg-light" placeholder="Search resources..." value="<?php echo esc_attr( $search_term ); ?>">
						</div>
					</div>

					<!-- Category Filter -->
					<div class="col-lg-3 col-md-6">
						<label for="robo_lr_tpl_cat" class="form-label small fw-semibold text-muted mb-1">Category</label>
						<select id="robo_lr_tpl_cat" name="category" class="form-select bg-light">
							<option value="">All Categories</option>
							<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
								<?php foreach ( $categories as $cat ) : ?>
									<option value="<?php echo esc_attr( $cat->slug ); ?>" <?php selected( $cat_filter, $cat->slug ); ?>>
										<?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?>)
									</option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>

					<!-- Difficulty Filter -->
					<div class="col-lg-2 col-md-4">
						<label for="robo_lr_tpl_diff" class="form-label small fw-semibold text-muted mb-1">Difficulty</label>
						<select id="robo_lr_tpl_diff" name="difficulty" class="form-select bg-light">
							<option value="">All Levels</option>
							<option value="beginner" <?php selected( $diff_filter, 'beginner' ); ?>>Beginner</option>
							<option value="intermediate" <?php selected( $diff_filter, 'intermediate' ); ?>>Intermediate</option>
							<option value="advanced" <?php selected( $diff_filter, 'advanced' ); ?>>Advanced</option>
						</select>
					</div>

					<!-- Sort By -->
					<div class="col-lg-2 col-md-4">
						<label for="robo_lr_tpl_sort" class="form-label small fw-semibold text-muted mb-1">Sort By</label>
						<select id="robo_lr_tpl_sort" name="sort" class="form-select bg-light">
							<option value="newest" <?php selected( $sort_filter, 'newest' ); ?>>Newest First</option>
							<option value="oldest" <?php selected( $sort_filter, 'oldest' ); ?>>Oldest First</option>
							<option value="title_asc" <?php selected( $sort_filter, 'title_asc' ); ?>>Title (A-Z)</option>
							<option value="title_desc" <?php selected( $sort_filter, 'title_desc' ); ?>>Title (Z-A)</option>
						</select>
					</div>

					<!-- Filter Actions -->
					<div class="col-lg-2 col-md-4 text-md-end pt-md-3">
						<div class="d-flex gap-2">
							<button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold">
								<i class="bi bi-funnel me-1"></i> Filter
							</button>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-outline-secondary rounded-circle" title="Reset Filters">
								<i class="bi bi-arrow-counterclockwise"></i>
							</a>
						</div>
					</div>

				</div>
			</form>
		</div>

		<!-- Results Count Header -->
		<div class="d-flex justify-content-between align-items-center mb-4 px-1">
			<h4 class="fw-bold text-dark mb-0">Learning Resource Guides</h4>
			<span class="badge bg-white text-muted border px-3 py-2 rounded-pill shadow-xs fs-13">
				<?php printf( esc_html__( '%d Resources Found', 'robo' ), esc_html( $resources_query->found_posts ) ); ?>
			</span>
		</div>

		<!-- Horizontal Cards Listing Container -->
		<div id="robo-lr-horizontal-cards-container" class="row">
			<?php if ( $resources_query->have_posts() ) : ?>
				<?php
				while ( $resources_query->have_posts() ) :
					$resources_query->the_post();
					get_template_part( 'template-parts/content-learning-resource-horizontal-card' );
				endwhile;
				wp_reset_postdata();
				?>
			<?php else : ?>
				<div class="col-12 py-5 text-center">
					<div class="card border-0 shadow-sm p-5 rounded-4 bg-white">
						<i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
						<h3 class="fw-bold text-dark">No Learning Resources Found</h3>
						<p class="text-muted mb-4">We couldn't find any resources matching your search criteria.</p>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-primary rounded-pill px-4">Reset All Filters</a>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- 5. PAGINATION -->
		<?php if ( $resources_query->max_num_pages > 1 ) : ?>
			<div class="d-flex justify-content-center mt-5">
				<?php
				$big = 999999999;
				$pagination_links = paginate_links( array(
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => max( 1, $paged ),
					'total'     => $resources_query->max_num_pages,
					'type'      => 'array',
					'prev_text' => '<i class="bi bi-chevron-left me-1"></i> Previous',
					'next_text' => 'Next <i class="bi bi-chevron-right ms-1"></i>',
				) );

				if ( ! empty( $pagination_links ) ) :
					echo '<ul class="pagination pagination-md flex-wrap justify-content-center gap-1 mb-0">';
					foreach ( $pagination_links as $link ) {
						$active_class = ( strpos( $link, 'current' ) !== false ) ? 'active' : '';
						echo '<li class="page-item ' . esc_attr( $active_class ) . '">' . str_replace( 'page-numbers', 'page-link rounded-pill px-3 py-2 fw-semibold', $link ) . '</li>';
					}
					echo '</ul>';
				endif;
				?>
			</div>
		<?php endif; ?>

	</div>

	<!-- 6. CTA SECTION (Reusing existing theme section) -->
	<?php get_template_part( 'template-parts/sections/about-cta' ); ?>

</div>

<?php
// 7. FOOTER
get_footer();
