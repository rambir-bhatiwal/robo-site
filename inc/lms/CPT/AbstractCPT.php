<?php
/**
 * Abstract CPT registration base class.
 *
 * @package Robo\LMS\CPT
 */

namespace Robo\LMS\CPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract Class AbstractCPT
 */
abstract class AbstractCPT {

	/**
	 * Post type slug.
	 *
	 * @var string
	 */
	protected string $slug = '';

	/**
	 * Singular label.
	 *
	 * @var string
	 */
	protected string $singular = '';

	/**
	 * Plural label.
	 *
	 * @var string
	 */
	protected string $plural = '';

	/**
	 * Menu name.
	 *
	 * @var string
	 */
	protected string $menu_name = '';

	/**
	 * Dashicon.
	 *
	 * @var string
	 */
	protected string $icon = 'dashicons-media-document';

	/**
	 * Abstract method to initialize translatable labels on init action.
	 */
	abstract protected function init_labels(): void;

	/**
	 * Register the Custom Post Type hooks.
	 */
	public function register(): void {
		if ( did_action( 'init' ) ) {
			$this->register_post_type();
		} else {
			add_action( 'init', array( $this, 'register_post_type' ) );
		}
	}

	/**
	 * Get Post Type Slug.
	 *
	 * @return string
	 */
	public function get_slug(): string {
		return $this->slug;
	}

	/**
	 * Register custom post type.
	 */
	public function register_post_type(): void {
		$this->init_labels();

		$labels = array(
			'name'                  => $this->plural,
			'singular_name'         => $this->singular,
			'menu_name'             => $this->menu_name ? $this->menu_name : $this->plural,
			'name_admin_bar'        => $this->singular,
			'archives'              => sprintf( __( '%s Archives', 'robo' ), $this->singular ),
			'attributes'            => sprintf( __( '%s Attributes', 'robo' ), $this->singular ),
			'parent_item_colon'     => sprintf( __( 'Parent %s:', 'robo' ), $this->singular ),
			'all_items'             => sprintf( __( 'All %s', 'robo' ), $this->plural ),
			'add_new_item'          => sprintf( __( 'Add New %s', 'robo' ), $this->singular ),
			'add_new'               => __( 'Add New', 'robo' ),
			'new_item'              => sprintf( __( 'New %s', 'robo' ), $this->singular ),
			'edit_item'             => sprintf( __( 'Edit %s', 'robo' ), $this->singular ),
			'update_item'           => sprintf( __( 'Update %s', 'robo' ), $this->singular ),
			'view_item'             => sprintf( __( 'View %s', 'robo' ), $this->singular ),
			'view_items'            => sprintf( __( 'View %s', 'robo' ), $this->plural ),
			'search_items'          => sprintf( __( 'Search %s', 'robo' ), $this->plural ),
			'not_found'             => sprintf( __( 'No %s found', 'robo' ), strtolower( $this->plural ) ),
			'not_found_in_trash'    => sprintf( __( 'No %s found in Trash', 'robo' ), strtolower( $this->plural ) ),
			'featured_image'        => __( 'Featured Image', 'robo' ),
			'set_featured_image'    => __( 'Set featured image', 'robo' ),
			'remove_featured_image' => __( 'Remove featured image', 'robo' ),
			'use_featured_image'    => __( 'Use as featured image', 'robo' ),
			'insert_into_item'      => sprintf( __( 'Insert into %s', 'robo' ), strtolower( $this->singular ) ),
			'uploaded_to_this_item' => sprintf( __( 'Uploaded to this %s', 'robo' ), strtolower( $this->singular ) ),
			'items_list'            => sprintf( __( '%s list', 'robo' ), $this->plural ),
			'items_list_navigation' => sprintf( __( '%s list navigation', 'robo' ), $this->plural ),
			'filter_items_list'     => sprintf( __( 'Filter %s list', 'robo' ), strtolower( $this->plural ) ),
		);

		$args = array(
			'label'                 => $this->singular,
			'description'           => sprintf( __( 'Resource management for %s', 'robo' ), $this->plural ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'author' ),
			'taxonomies'            => array( 'learning-category', 'learning-tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'menu_icon'             => $this->icon,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'query_var'             => true,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
			'rewrite'               => array(
				'slug'       => $this->slug,
				'with_front' => false,
			),
		);

		register_post_type( $this->slug, $args );
	}
}
