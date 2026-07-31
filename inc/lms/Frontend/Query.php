<?php
/**
 * Frontend Query modifier and builder for Robo LMS.
 *
 * @package Robo\LMS\Frontend
 */

namespace Robo\LMS\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Query
 */
class Query {

	/**
	 * Supported CPTs.
	 *
	 * @var array<string>
	 */
	private array $post_types = array(
		'learning-pdf',
		'learning-code',
		'learning-video',
	);

	/**
	 * Register hooks.
	 */
	public function register(): void {
		add_action( 'pre_get_posts', array( $this, 'modify_archive_query' ) );
	}

	/**
	 * Modify main archive query for Learning CPTs and Taxonomies.
	 *
	 * @param \WP_Query $query WP_Query instance.
	 */
	public function modify_archive_query( \WP_Query $query ): void {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		if ( $query->is_post_type_archive( $this->post_types ) || $query->is_tax( array( 'learning-category', 'learning-tag' ) ) ) {
			$query->set( 'posts_per_page', 9 );

			// Handle URL query parameters if present
			if ( ! empty( $_GET['lms_sort'] ) ) {
				$sort = sanitize_key( $_GET['lms_sort'] );
				if ( 'oldest' === $sort ) {
					$query->set( 'orderby', 'date' );
					$query->set( 'order', 'ASC' );
				} elseif ( 'alphabetical' === $sort || 'a-z' === $sort ) {
					$query->set( 'orderby', 'title' );
					$query->set( 'order', 'ASC' );
				} else {
					$query->set( 'orderby', 'date' );
					$query->set( 'order', 'DESC' );
				}
			}

			// Handle Difficulty Meta Filter
			if ( ! empty( $_GET['lms_difficulty'] ) ) {
				$diff = sanitize_key( $_GET['lms_difficulty'] );
				$meta_query = (array) $query->get( 'meta_query' );
				$meta_query[] = array(
					'key'     => '_robo_lms_difficulty',
					'value'   => $diff,
					'compare' => '=',
				);
				$query->set( 'meta_query', $meta_query );
			}
		}
	}

	/**
	 * Build WP_Query args array for custom or AJAX queries.
	 *
	 * @param string               $cpt Post type slug.
	 * @param array<string, mixed> $params Filter parameters.
	 * @return array<string, mixed>
	 */
	public static function build_archive_query_args( string $cpt, array $params = array() ): array {
		$args = array(
			'post_type'      => $cpt,
			'post_status'    => 'publish',
			'posts_per_page' => 9,
			'paged'          => $params['paged'] ?? 1,
		);

		// Keyword Search
		if ( ! empty( $params['search'] ) ) {
			$args['s'] = sanitize_text_field( $params['search'] );
		}

		// Tax Query
		$tax_query = array();
		if ( ! empty( $params['category'] ) ) {
			$tax_query[] = array(
				'taxonomy' => 'learning-category',
				'field'    => 'slug',
				'terms'    => sanitize_key( $params['category'] ),
			);
		}
		if ( ! empty( $params['tag'] ) ) {
			$tax_query[] = array(
				'taxonomy' => 'learning-tag',
				'field'    => 'slug',
				'terms'    => sanitize_key( $params['tag'] ),
			);
		}
		if ( count( $tax_query ) > 1 ) {
			$tax_query['relation'] = 'AND';
		}
		if ( ! empty( $tax_query ) ) {
			$args['tax_query'] = $tax_query;
		}

		// Meta Query (Difficulty)
		if ( ! empty( $params['difficulty'] ) ) {
			$args['meta_query'] = array(
				array(
					'key'     => '_robo_lms_difficulty',
					'value'   => sanitize_key( $params['difficulty'] ),
					'compare' => '=',
				),
			);
		}

		// Sorting
		$sort = $params['sort'] ?? 'newest';
		switch ( $sort ) {
			case 'oldest':
				$args['orderby'] = 'date';
				$args['order']   = 'ASC';
				break;
			case 'alphabetical':
			case 'a-z':
				$args['orderby'] = 'title';
				$args['order']   = 'ASC';
				break;
			case 'newest':
			default:
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
				break;
		}

		return $args;
	}
}
