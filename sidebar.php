<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Select sidebar ID based on context.
$sidebar_id = 'main-sidebar';
if ( is_home() || is_archive() || is_single() || is_search() ) {
	$sidebar_id = 'blog-sidebar';
}

// Fallback logic if sidebar is not active with widgets.
if ( ! is_active_sidebar( $sidebar_id ) ) :
	?>
	<aside id="secondary" class="widget-area" aria-label="<?php esc_attr_e( 'Sidebar', 'robo' ); ?>">
		
		<!-- Search Widget -->
		<section class="widget card border-0 shadow-sm p-4 mb-4">
			<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold"><?php esc_html_e( 'Search', 'robo' ); ?></h4>
			<?php get_search_form(); ?>
		</section>

		<!-- Recent Posts Widget -->
		<section class="widget card border-0 shadow-sm p-4 mb-4">
			<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold"><?php esc_html_e( 'Recent Posts', 'robo' ); ?></h4>
			<ul class="list-unstyled mb-0 d-flex flex-column gap-3">
				<?php
				$recent_posts = new WP_Query(
					array(
						'posts_per_page'      => 5,
						'post_status'         => 'publish',
						'ignore_sticky_posts' => 1,
					)
				);
				if ( $recent_posts->have_posts() ) :
					while ( $recent_posts->have_posts() ) :
						$recent_posts->the_post();
						?>
						<li class="d-flex align-items-center gap-2">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="flex-shrink-0">
									<?php the_post_thumbnail( array( 50, 50 ), array( 'class' => 'rounded object-fit-cover' ) ); ?>
								</a>
							<?php endif; ?>
							<div>
								<h5 class="h6 mb-1 fw-semibold" style="font-size: 0.9rem; line-height: 1.3;">
									<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none hover-primary"><?php the_title(); ?></a>
								</h5>
								<span class="text-muted small" style="font-size: 0.75rem;"><?php echo esc_html( get_the_date() ); ?></span>
							</div>
						</li>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<li class="text-muted small"><?php esc_html_e( 'No posts available.', 'robo' ); ?></li>
				<?php endif; ?>
			</ul>
		</section>

		<!-- Categories Widget -->
		<section class="widget card border-0 shadow-sm p-4 mb-4">
			<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold"><?php esc_html_e( 'Categories', 'robo' ); ?></h4>
			<ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
				<?php
				$categories = get_categories();
				if ( ! empty( $categories ) ) :
					foreach ( $categories as $cat ) :
						?>
						<li class="d-flex justify-content-between align-items-center border-bottom border-light-subtle pb-1">
							<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="text-decoration-none text-muted hover-primary fw-medium"><?php echo esc_html( $cat->name ); ?></a>
							<span class="badge bg-secondary-subtle text-secondary rounded-pill"><?php echo esc_html( $cat->count ); ?></span>
						</li>
						<?php
					endforeach;
				else :
					?>
					<li class="text-muted"><?php esc_html_e( 'No categories available.', 'robo' ); ?></li>
				<?php endif; ?>
			</ul>
		</section>

		<!-- Archives Widget -->
		<section class="widget card border-0 shadow-sm p-4 mb-4">
			<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold"><?php esc_html_e( 'Archives', 'robo' ); ?></h4>
			<ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
				<?php
				$archives = wp_get_archives(
					array(
						'type'            => 'monthly',
						'limit'           => 6,
						'format'          => 'custom',
						'before'          => '<li class="border-bottom border-light-subtle pb-1">',
						'after'           => '</li>',
						'show_post_count' => true,
						'echo'            => 0,
					)
				);
				if ( ! empty( $archives ) ) {
					// Add Bootstrap classes to counts wrapper.
					$archives = str_replace( '(', '<span class="badge bg-secondary-subtle text-secondary rounded-pill float-end">', $archives );
					$archives = str_replace( ')', '</span>', $archives );
					$archives = str_replace( '<a href=', '<a class="text-decoration-none text-muted hover-primary fw-medium" href=', $archives );
					echo wp_kses_post( $archives );
				} else {
					echo '<li class="text-muted">' . esc_html__( 'No archives available.', 'robo' ) . '</li>';
				}
				?>
			</ul>
		</section>

		<!-- Recent Comments Widget -->
		<section class="widget card border-0 shadow-sm p-4 mb-4">
			<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold"><?php esc_html_e( 'Recent Comments', 'robo' ); ?></h4>
			<ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
				<?php
				$comments = get_comments( array( 'number' => 4, 'status' => 'approve' ) );
				if ( ! empty( $comments ) ) :
					foreach ( $comments as $comment ) :
						?>
						<li class="border-bottom border-light-subtle pb-2 mb-1">
							<span class="text-dark fw-semibold"><?php echo esc_html( $comment->comment_author ); ?></span> 
							<span class="text-muted"><?php esc_html_e( 'on', 'robo' ); ?></span> 
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="text-decoration-none text-primary fw-medium"><?php echo esc_html( get_the_title( $comment->comment_post_ID ) ); ?></a>
						</li>
						<?php
					endforeach;
				else :
					?>
					<li class="text-muted"><?php esc_html_e( 'No comments available.', 'robo' ); ?></li>
				<?php endif; ?>
			</ul>
		</section>

	</aside>
	<?php
else :
	// Load the dynamic sidebar widgets configured in WordPress admin.
	?>
	<aside id="secondary" class="widget-area" aria-label="<?php esc_attr_e( 'Sidebar', 'robo' ); ?>">
		<?php dynamic_sidebar( $sidebar_id ); ?>
	</aside>
<?php
endif;
