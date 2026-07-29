<?php
/**
 * Custom Post Type and Taxonomies Setup for Learning Resources.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Robo_Learning_Resources_CPT' ) ) {

	/**
	 * Class Robo_Learning_Resources_CPT
	 */
	class Robo_Learning_Resources_CPT {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'register_post_type' ), 5 );
			add_action( 'init', array( $this, 'register_taxonomies' ), 5 );
			add_action( 'init', array( $this, 'maybe_flush_rewrite_rules' ), 99 );
			add_action( 'after_switch_theme', array( $this, 'flush_rewrite_rules' ) );
			add_action( 'init', array( $this, 'seed_default_terms' ), 20 );
		}


		/**
		 * Register Custom Post Type: Learning Resources
		 */
		public function register_post_type() {
			$labels = array(
				'name'                  => _x( 'Learning Resources', 'Post Type General Name', 'robo' ),
				'singular_name'         => _x( 'Learning Resource', 'Post Type Singular Name', 'robo' ),
				'menu_name'             => __( 'Learning Resources', 'robo' ),
				'name_admin_bar'        => __( 'Learning Resource', 'robo' ),
				'archives'              => __( 'Learning Resource Archives', 'robo' ),
				'attributes'            => __( 'Resource Attributes', 'robo' ),
				'parent_item_colon'     => __( 'Parent Resource:', 'robo' ),
				'all_items'             => __( 'All Learning Resources', 'robo' ),
				'add_new_item'          => __( 'Add New Learning Resource', 'robo' ),
				'add_new'               => __( 'Add New', 'robo' ),
				'new_item'              => __( 'New Resource', 'robo' ),
				'edit_item'             => __( 'Edit Resource', 'robo' ),
				'update_item'           => __( 'Update Resource', 'robo' ),
				'view_item'             => __( 'View Resource', 'robo' ),
				'view_items'            => __( 'View Resources', 'robo' ),
				'search_items'          => __( 'Search Learning Resources', 'robo' ),
				'not_found'             => __( 'No learning resources found', 'robo' ),
				'not_found_in_trash'    => __( 'No learning resources found in Trash', 'robo' ),
				'featured_image'        => __( 'Featured Image', 'robo' ),
				'set_featured_image'    => __( 'Set featured image', 'robo' ),
				'remove_featured_image' => __( 'Remove featured image', 'robo' ),
				'use_featured_image'    => __( 'Use as featured image', 'robo' ),
				'insert_into_item'      => __( 'Insert into resource', 'robo' ),
				'uploaded_to_this_item' => __( 'Uploaded to this resource', 'robo' ),
				'items_list'            => __( 'Learning Resources list', 'robo' ),
				'items_list_navigation' => __( 'Learning Resources list navigation', 'robo' ),
				'filter_items_list'     => __( 'Filter learning resources list', 'robo' ),
			);

			$args = array(
				'label'               => __( 'Learning Resource', 'robo' ),
				'description'         => __( 'Robo Learning Resources Post Type', 'robo' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
				'taxonomies'          => array( 'learning_category', 'learning_tag' ),
				'hierarchical'        => false,
				'public'              => true,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'show_in_rest'        => true, // Gutenberg & REST API support
				'has_archive'         => true, // /learning-resources/
				'exclude_from_search' => false,
				'query_var'           => true,
				'can_export'          => true,
				'capability_type'     => 'post',
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-welcome-learn-more',
				'rewrite'             => array(
					'slug'       => 'learning-resources',
					'with_front' => false,
				),
			);

			register_post_type( 'learning-resource', $args );
		}


		/**
		 * Register Custom Taxonomies for Learning Resources
		 */
		public function register_taxonomies() {
			// 1. Learning Category (Hierarchical)
			$cat_labels = array(
				'name'                       => _x( 'Learning Categories', 'Taxonomy General Name', 'robo' ),
				'singular_name'              => _x( 'Learning Category', 'Taxonomy Singular Name', 'robo' ),
				'menu_name'                  => __( 'Categories', 'robo' ),
				'all_items'                  => __( 'All Categories', 'robo' ),
				'parent_item'                => __( 'Parent Category', 'robo' ),
				'parent_item_colon'          => __( 'Parent Category:', 'robo' ),
				'new_item_name'              => __( 'New Category Name', 'robo' ),
				'add_new_item'               => __( 'Add New Category', 'robo' ),
				'edit_item'                  => __( 'Edit Category', 'robo' ),
				'update_item'                => __( 'Update Category', 'robo' ),
				'view_item'                  => __( 'View Category', 'robo' ),
				'separate_items_with_commas' => __( 'Separate categories with commas', 'robo' ),
				'add_or_remove_items'        => __( 'Add or remove categories', 'robo' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'robo' ),
				'popular_items'              => __( 'Popular Categories', 'robo' ),
				'search_items'               => __( 'Search Categories', 'robo' ),
				'not_found'                  => __( 'Not Found', 'robo' ),
				'no_terms'                   => __( 'No categories', 'robo' ),
				'items_list'                 => __( 'Categories list', 'robo' ),
				'items_list_navigation'      => __( 'Categories list navigation', 'robo' ),
			);

			$cat_args = array(
				'labels'            => $cat_labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => true,
				'show_in_rest'      => true,
				'rewrite'           => array(
					'slug'         => 'learning-category',
					'with_front'   => false,
					'hierarchical' => true,
				),
			);

			register_taxonomy( 'learning_category', array( 'learning-resource' ), $cat_args );

			// 2. Learning Tags (Non-hierarchical)
			$tag_labels = array(
				'name'                       => _x( 'Learning Tags', 'Taxonomy General Name', 'robo' ),
				'singular_name'              => _x( 'Learning Tag', 'Taxonomy Singular Name', 'robo' ),
				'menu_name'                  => __( 'Learning Tags', 'robo' ),
				'all_items'                  => __( 'All Tags', 'robo' ),
				'new_item_name'              => __( 'New Tag Name', 'robo' ),
				'add_new_item'               => __( 'Add New Tag', 'robo' ),
				'edit_item'                  => __( 'Edit Tag', 'robo' ),
				'update_item'                => __( 'Update Tag', 'robo' ),
				'view_item'                  => __( 'View Tag', 'robo' ),
				'separate_items_with_commas' => __( 'Separate tags with commas', 'robo' ),
				'add_or_remove_items'        => __( 'Add or remove categories', 'robo' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'robo' ),
				'popular_items'              => __( 'Popular Tags', 'robo' ),
				'search_items'               => __( 'Search Tags', 'robo' ),
				'not_found'                  => __( 'Not Found', 'robo' ),
				'no_terms'                   => __( 'No tags', 'robo' ),
				'items_list'                 => __( 'Tags list', 'robo' ),
				'items_list_navigation'      => __( 'Tags list navigation', 'robo' ),
			);

			$tag_args = array(
				'labels'            => $tag_labels,
				'hierarchical'      => false,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => true,
				'show_in_rest'      => true,
				'rewrite'           => array(
					'slug'       => 'learning-tag',
					'with_front' => false,
				),
			);

			register_taxonomy( 'learning_tag', array( 'learning-resource' ), $tag_args );
		}

		/**
		 * Seed default terms if none exist yet.
		 */
		public function seed_default_terms() {
			if ( get_option( 'robo_lr_default_terms_seeded' ) ) {
				return;
			}

			// Default Categories
			$categories = array(
				'Arduino',
				'Robotics',
				'Electronics',
				'Programming',
				'STEM',
				'AI',
				'PCB Design',
				'IoT',
				'Drones',
				'Combat Robotics',
			);

			foreach ( $categories as $cat ) {
				if ( ! term_exists( $cat, 'learning_category' ) ) {
					wp_insert_term( $cat, 'learning_category' );
				}
			}

			// Default Tags
			$tags = array(
				'Beginner',
				'Intermediate',
				'Advanced',
				'Workshop',
				'Competition',
				'Project',
			);

			foreach ( $tags as $tag ) {
				if ( ! term_exists( $tag, 'learning_tag' ) ) {
					wp_insert_term( $tag, 'learning_tag' );
				}
			}

			update_option( 'robo_lr_default_terms_seeded', 1 );
		}

		/**
		 * Flush rewrite rules once programmatically after CPT registration updates
		 */
		public function maybe_flush_rewrite_rules() {
			if ( ! get_option( 'robo_lr_rewrite_flushed_v4' ) ) {
				$this->register_post_type();
				$this->register_taxonomies();
				flush_rewrite_rules( false );
				update_option( 'robo_lr_rewrite_flushed_v4', 1 );
			}
		}

		/**
		 * Flush rewrite rules on theme activation
		 */
		public function flush_rewrite_rules() {
			$this->register_post_type();
			$this->register_taxonomies();
			flush_rewrite_rules();
		}
	}


	new Robo_Learning_Resources_CPT();
}
