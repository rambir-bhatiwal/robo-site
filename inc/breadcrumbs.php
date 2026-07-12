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
		// Do not show breadcrumbs on front-page/homepage.
		if ( is_front_page() || is_home() ) {
			return;
		}

		echo '<nav aria-label="' . esc_attr__( 'breadcrumb', 'robo' ) . '" class="bg-light p-3 rounded mb-4 shadow-sm">';
		echo '<ol class="breadcrumb mb-0">';

		// Homepage Link.
		echo '<li class="breadcrumb-item"><a href="' . esc_url( home_url( '/' ) ) . '" class="text-decoration-none">' . esc_html__( 'Home', 'robo' ) . '</a></li>';

		if ( is_singular( 'post' ) ) {
			// Categories.
			$categories = get_the_category();
			if ( ! empty( $categories ) ) {
				$primary_cat = $categories[0];
				echo '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $primary_cat->term_id ) ) . '" class="text-decoration-none">' . esc_html( $primary_cat->name ) . '</a></li>';
			}
			// Title.
			echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( get_the_title() ) . '</li>';

		} elseif ( is_page() ) {
			// Check for Parent Pages.
			global $post;
			if ( $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page          = get_post( $parent_id );
					$breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $page->ID ) ) . '" class="text-decoration-none">' . esc_html( get_the_title( $page->ID ) ) . '</a></li>';
					$parent_id     = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) {
					echo wp_kses_post( $crumb );
				}
			}
			echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( get_the_title() ) . '</li>';

		} elseif ( is_category() ) {
			echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( single_cat_title( '', false ) ) . '</li>';

		} elseif ( is_tag() ) {
			echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( single_tag_title( '', false ) ) . '</li>';

		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );
			echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( $userdata->display_name ) . '</li>';

		} elseif ( is_search() ) {
			echo '<li class="breadcrumb-item active" aria-current="page">' . sprintf( esc_html__( 'Search: "%s"', 'robo' ), esc_html( get_search_query() ) ) . '</li>';

		} elseif ( is_archive() ) {
			if ( is_day() ) {
				echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( get_the_date() ) . '</li>';
			} elseif ( is_month() ) {
				echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( get_the_date( _x( 'F Y', 'monthly archives date format', 'robo' ) ) ) . '</li>';
			} elseif ( is_year() ) {
				echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( get_the_date( _x( 'Y', 'yearly archives date format', 'robo' ) ) ) . '</li>';
			} else {
				echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( 'Archives', 'robo' ) . '</li>';
			}

		} elseif ( is_404() ) {
			echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( 'Error 404', 'robo' ) . '</li>';
		}

		echo '</ol>';
		echo '</nav>';
	}
}
