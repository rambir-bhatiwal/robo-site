<?php
/**
 * Dynamic Breadcrumbs Helper.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'robo_breadcrumbs' ) ) {
	/**
	 * Output dynamic breadcrumbs.
	 */
	function robo_breadcrumbs() {
		// Do not show breadcrumbs on front page (homepage).
		if ( is_front_page() || is_home() ) {
			return;
		}

		echo '<nav aria-label="' . esc_attr__( 'breadcrumb', 'robo' ) . '" class="bg-white p-3 rounded shadow-sm border border-light-subtle mb-4">';
		echo '<ol class="breadcrumb mb-0 align-items-center">';

		// 1. Homepage Link.
		echo '<li class="breadcrumb-item"><a href="' . esc_url( home_url( '/' ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html__( 'Home', 'robo' ) . '</a></li>';

		// 2. WooCommerce Pages
		if ( class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			$shop_page_id = wc_get_page_id( 'shop' );
			$shop_title   = ( $shop_page_id && $shop_page_id > 0 ) ? get_the_title( $shop_page_id ) : __( 'Shop', 'robo' );
			$shop_link    = ( $shop_page_id && $shop_page_id > 0 ) ? get_permalink( $shop_page_id ) : '';

			if ( is_shop() ) {
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( $shop_title ) . '</li>';

			} elseif ( is_product_category() || is_product_tag() || is_tax() ) {
				if ( $shop_link ) {
					echo '<li class="breadcrumb-item"><a href="' . esc_url( $shop_link ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( $shop_title ) . '</a></li>';
				}
				$current_term = get_queried_object();
				if ( $current_term && ! is_wp_error( $current_term ) && isset( $current_term->term_id ) ) {
					if ( is_taxonomy_hierarchical( $current_term->taxonomy ) && ! empty( $current_term->parent ) ) {
						$ancestors = array_reverse( get_ancestors( $current_term->term_id, $current_term->taxonomy, 'taxonomy' ) );
						foreach ( $ancestors as $ancestor_id ) {
							$ancestor = get_term( $ancestor_id, $current_term->taxonomy );
							if ( $ancestor && ! is_wp_error( $ancestor ) ) {
								echo '<li class="breadcrumb-item"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( $ancestor->name ) . '</a></li>';
							}
						}
					}
					echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( $current_term->name ) . '</li>';
				}

			} elseif ( is_product() ) {
				if ( $shop_link ) {
					echo '<li class="breadcrumb-item"><a href="' . esc_url( $shop_link ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( $shop_title ) . '</a></li>';
				}
				$terms = wc_get_product_terms( get_the_ID(), 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					$main_term = $terms[0];
					$ancestors = array_reverse( get_ancestors( $main_term->term_id, 'product_cat', 'taxonomy' ) );
					foreach ( $ancestors as $ancestor_id ) {
						$ancestor = get_term( $ancestor_id, 'product_cat' );
						if ( $ancestor && ! is_wp_error( $ancestor ) ) {
							echo '<li class="breadcrumb-item"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( $ancestor->name ) . '</a></li>';
						}
					}
					echo '<li class="breadcrumb-item"><a href="' . esc_url( get_term_link( $main_term ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( $main_term->name ) . '</a></li>';
				}
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( get_the_title() ) . '</li>';

			} elseif ( is_cart() ) {
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html__( 'Cart', 'robo' ) . '</li>';

			} elseif ( is_checkout() ) {
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html__( 'Checkout', 'robo' ) . '</li>';

			} elseif ( is_account_page() ) {
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html__( 'My Account', 'robo' ) . '</li>';

			} else {
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( get_the_title() ) . '</li>';
			}

		} elseif ( is_home() ) {
			// Blog Archive (Posts Page)
			$posts_page_id = get_option( 'page_for_posts' );
			$blog_title    = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog', 'robo' );
			echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( $blog_title ) . '</li>';

		} elseif ( is_singular( 'post' ) ) {
			$posts_page_id = get_option( 'page_for_posts' );
			if ( $posts_page_id ) {
				echo '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $posts_page_id ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( get_the_title( $posts_page_id ) ) . '</a></li>';
			}
			$categories = get_the_category();
			if ( ! empty( $categories ) ) {
				$primary_cat = $categories[0];
				if ( $primary_cat->parent ) {
					$ancestors = array_reverse( get_ancestors( $primary_cat->term_id, 'category', 'taxonomy' ) );
					foreach ( $ancestors as $ancestor_id ) {
						$ancestor = get_category( $ancestor_id );
						if ( $ancestor ) {
							echo '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $ancestor->term_id ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( $ancestor->name ) . '</a></li>';
						}
					}
				}
				echo '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $primary_cat->term_id ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( $primary_cat->name ) . '</a></li>';
			}
			echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( get_the_title() ) . '</li>';

		} elseif ( is_page() ) {
			// Check for Parent Pages.
			global $post;
			if ( $post && $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page          = get_post( $parent_id );
					if ( $page ) {
						$breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $page->ID ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( get_the_title( $page->ID ) ) . '</a></li>';
						$parent_id     = $page->post_parent;
					} else {
						break;
					}
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) {
					echo wp_kses_post( $crumb );
				}
			}
			echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( get_the_title() ) . '</li>';

		} elseif ( is_category() ) {
			$posts_page_id = get_option( 'page_for_posts' );
			if ( $posts_page_id ) {
				echo '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $posts_page_id ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( get_the_title( $posts_page_id ) ) . '</a></li>';
			}
			$current_cat = get_queried_object();
			if ( $current_cat && isset( $current_cat->term_id ) && $current_cat->parent ) {
				$ancestors = array_reverse( get_ancestors( $current_cat->term_id, 'category', 'taxonomy' ) );
				foreach ( $ancestors as $ancestor_id ) {
					$ancestor = get_category( $ancestor_id );
					if ( $ancestor ) {
						echo '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $ancestor->term_id ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( $ancestor->name ) . '</a></li>';
					}
				}
			}
			echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( single_cat_title( '', false ) ) . '</li>';

		} elseif ( is_tag() ) {
			$posts_page_id = get_option( 'page_for_posts' );
			if ( $posts_page_id ) {
				echo '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $posts_page_id ) ) . '" class="text-decoration-none text-primary fw-medium">' . esc_html( get_the_title( $posts_page_id ) ) . '</a></li>';
			}
			echo '<li class="breadcrumb-item active text-muted" aria-current="page">#' . esc_html( single_tag_title( '', false ) ) . '</li>';

		} elseif ( is_author() ) {
			global $author;
			$userdata    = get_userdata( $author );
			$author_name = $userdata ? $userdata->display_name : __( 'Author', 'robo' );
			echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( $author_name ) . '</li>';

		} elseif ( is_search() ) {
			echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . sprintf( esc_html__( 'Search: "%s"', 'robo' ), esc_html( get_search_query() ) ) . '</li>';

		} elseif ( is_archive() ) {
			if ( is_day() ) {
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( get_the_date() ) . '</li>';
			} elseif ( is_month() ) {
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( get_the_date( _x( 'F Y', 'monthly archives date format', 'robo' ) ) ) . '</li>';
			} elseif ( is_year() ) {
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( get_the_date( _x( 'Y', 'yearly archives date format', 'robo' ) ) ) . '</li>';
			} else {
				echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html__( 'Archives', 'robo' ) . '</li>';
			}

		} elseif ( is_404() ) {
			echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html__( 'Error 404', 'robo' ) . '</li>';

		} else {
			echo '<li class="breadcrumb-item active text-muted" aria-current="page">' . esc_html( get_the_title() ) . '</li>';
		}

		echo '</ol>';
		echo '</nav>';
	}
}
