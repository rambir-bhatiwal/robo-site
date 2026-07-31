<?php
/**
 * Taxonomy registration for Robo LMS.
 *
 * @package Robo\LMS\Taxonomies
 */

namespace Robo\LMS\Taxonomies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class LearningTaxonomies
 */
class LearningTaxonomies {

	/**
	 * Post types sharing these taxonomies.
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
		if ( did_action( 'init' ) ) {
			$this->register_taxonomies();
			$this->insert_default_terms();
		} else {
			add_action( 'init', array( $this, 'register_taxonomies' ) );
			add_action( 'init', array( $this, 'insert_default_terms' ), 20 );
		}
	}

	/**
	 * Register custom taxonomies.
	 */
	public function register_taxonomies(): void {
		// 1. Learning Categories
		$cat_labels = array(
			'name'              => _x( 'Learning Categories', 'taxonomy general name', 'robo' ),
			'singular_name'     => _x( 'Learning Category', 'taxonomy singular name', 'robo' ),
			'search_items'      => __( 'Search Categories', 'robo' ),
			'all_items'         => __( 'All Categories', 'robo' ),
			'parent_item'       => __( 'Parent Category', 'robo' ),
			'parent_item_colon' => __( 'Parent Category:', 'robo' ),
			'edit_item'         => __( 'Edit Category', 'robo' ),
			'update_item'       => __( 'Update Category', 'robo' ),
			'add_new_item'      => __( 'Add New Category', 'robo' ),
			'new_item_name'     => __( 'New Category Name', 'robo' ),
			'menu_name'         => __( 'Categories', 'robo' ),
		);

		register_taxonomy(
			'learning-category',
			$this->post_types,
			array(
				'hierarchical'      => true,
				'labels'            => $cat_labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'show_in_rest'      => true,
				'rewrite'           => array(
					'slug'         => 'learning-category',
					'with_front'   => true,
					'hierarchical' => true,
				),
			)
		);

		// 2. Learning Tags
		$tag_labels = array(
			'name'              => _x( 'Learning Tags', 'taxonomy general name', 'robo' ),
			'singular_name'     => _x( 'Learning Tag', 'taxonomy singular name', 'robo' ),
			'search_items'      => __( 'Search Tags', 'robo' ),
			'all_items'         => __( 'All Tags', 'robo' ),
			'edit_item'         => __( 'Edit Tag', 'robo' ),
			'update_item'       => __( 'Update Tag', 'robo' ),
			'add_new_item'      => __( 'Add New Tag', 'robo' ),
			'new_item_name'     => __( 'New Tag Name', 'robo' ),
			'menu_name'         => __( 'Tags', 'robo' ),
		);

		register_taxonomy(
			'learning-tag',
			$this->post_types,
			array(
				'hierarchical'      => false,
				'labels'            => $tag_labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'show_in_rest'      => true,
				'rewrite'           => array(
					'slug'       => 'learning-tag',
					'with_front' => true,
				),
			)
		);
	}

	/**
	 * Pre-populate default categories and tags if none exist.
	 */
	public function insert_default_terms(): void {
		if ( get_option( 'robo_lms_terms_created' ) ) {
			return;
		}

		$default_cats = array(
			'Arduino',
			'Robotics',
			'Electronics',
			'Programming',
			'AI',
			'STEM',
			'IoT',
			'PCB',
			'Drone',
			'Combat Robot',
		);

		foreach ( $default_cats as $cat ) {
			if ( ! term_exists( $cat, 'learning-category' ) ) {
				wp_insert_term( $cat, 'learning-category' );
			}
		}

		$default_tags = array(
			'Beginner',
			'Workshop',
			'Competition',
			'DIY',
			'School',
			'College',
			'Professional',
		);

		foreach ( $default_tags as $tag ) {
			if ( ! term_exists( $tag, 'learning-tag' ) ) {
				wp_insert_term( $tag, 'learning-tag' );
			}
		}

		update_option( 'robo_lms_terms_created', 1 );
	}
}
