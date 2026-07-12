<?php
/**
 * Custom template tags for this theme.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'robo_post_meta' ) ) {
	/**
	 * Print HTML with meta information for the current post.
	 */
	function robo_post_meta() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			// Date.
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			}

			$time_string = sprintf(
				$time_string,
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() )
			);

			// Author.
			$author_string = sprintf(
				'<span class="author vcard"><a class="url fn n text-decoration-none" href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			);

			// Categories.
			$categories_list = get_the_category_list( ', ' );

			echo '<div class="post-meta text-muted small mb-3 d-flex flex-wrap align-items-center gap-3">';
			
			// Date Meta.
			echo '<span class="posted-on d-flex align-items-center gap-1">';
			echo '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/></svg>';
			echo $time_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</span>';

			// Author Meta.
			echo '<span class="byline d-flex align-items-center gap-1">';
			echo '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>';
			echo $author_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</span>';

			// Category Meta.
			if ( $categories_list ) {
				echo '<span class="cat-links d-flex align-items-center gap-1">';
				echo '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16"><path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 5H9.83a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 3H2.5a1 1 0 0 0-.31.05z"/></svg>';
				echo $categories_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '</span>';
			}

			// Reading Time Meta.
			echo '<span class="reading-time d-flex align-items-center gap-1">';
			echo '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/></svg>';
			echo esc_html( robo_get_reading_time() );
			echo '</span>';

			// Post Views Meta.
			echo '<span class="post-views d-flex align-items-center gap-1">';
			echo '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 4 8 4s3.88.668 5.168 1.957A13 13 0 0 1 14.828 8a13 13 0 0 1-1.66 2.043C11.879 11.332 10.119 12 8 12s-3.88-.668-5.168-1.957A13 13 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/></svg>';
			echo esc_html( robo_get_post_views() );
			echo '</span>';

			echo '</div>';
		}
	}
}

if ( ! function_exists( 'robo_author_box' ) ) {
	/**
	 * Display Author Box in single posts.
	 */
	function robo_author_box() {
		if ( ! is_single() || 'post' !== get_post_type() ) {
			return;
		}
		
		$author_id          = get_the_author_meta( 'ID' );
		$author_name        = get_the_author();
		$author_description = get_the_author_meta( 'description' );
		$author_url         = get_author_posts_url( $author_id );
		
		if ( empty( $author_description ) ) {
			return; // Show only if bio is set.
		}
		?>
		<div class="author-box card border-0 shadow-sm p-4 mb-4 bg-light">
			<div class="row align-items-center">
				<div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
					<?php echo get_avatar( $author_id, 100, '', $author_name, array( 'class' => 'rounded-circle shadow-sm border border-white border-3' ) ); ?>
				</div>
				<div class="col-md-10">
					<h4 class="h5 mb-2 text-dark fw-bold">
						<?php esc_html_e( 'About the Author:', 'robo' ); ?> 
						<a href="<?php echo esc_url( $author_url ); ?>" class="text-decoration-none text-primary"><?php echo esc_html( $author_name ); ?></a>
					</h4>
					<p class="mb-0 text-muted fs-6"><?php echo esc_html( $author_description ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'robo_related_posts' ) ) {
	/**
	 * Display Related Posts.
	 */
	function robo_related_posts() {
		if ( ! is_single() || 'post' !== get_post_type() ) {
			return;
		}

		$categories = get_the_category();
		if ( empty( $categories ) ) {
			return;
		}

		$cat_ids = array();
		foreach ( $categories as $cat ) {
			$cat_ids[] = $cat->term_id;
		}

		$related_query = new WP_Query(
			array(
				'category__in'        => $cat_ids,
				'post__not_in'        => array( get_the_ID() ),
				'posts_per_page'      => 3,
				'ignore_sticky_posts' => 1,
			)
		);

		if ( $related_query->have_posts() ) {
			?>
			<div class="related-posts my-5">
				<h3 class="h4 fw-bold mb-4 text-dark position-relative pb-2 border-bottom"><?php esc_html_e( 'Related Posts', 'robo' ); ?></h3>
				<div class="row g-4">
					<?php
					while ( $related_query->have_posts() ) {
						$related_query->the_post();
						?>
						<div class="col-md-4">
							<div class="card h-100 border-0 shadow-sm overflow-hidden">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top object-fit-cover', 'style' => 'height: 180px;' ) ); ?>
									</a>
								<?php else : ?>
									<div class="bg-secondary text-white text-center d-flex align-items-center justify-content-center" style="height: 180px;">
										<span class="small"><?php esc_html_e( 'No Image', 'robo' ); ?></span>
									</div>
								<?php endif; ?>
								<div class="card-body">
									<span class="badge bg-primary-subtle text-primary mb-2"><?php echo esc_html( get_the_category()[0]->name ); ?></span>
									<h5 class="card-title h6 fw-bold mb-2">
										<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none hover-primary"><?php the_title(); ?></a>
									</h5>
									<p class="card-text text-muted small mb-0"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 12 ) ); ?></p>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}
		wp_reset_postdata();
	}
}
