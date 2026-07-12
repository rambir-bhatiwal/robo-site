<?php
/**
 * Register widget areas.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'robo_widgets_init' ) ) {
	/**
	 * Register widget areas.
	 */
	function robo_widgets_init() {
		// Main Sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Main Sidebar', 'robo' ),
				'id'            => 'main-sidebar',
				'description'   => esc_html__( 'Appears on pages and custom templates.', 'robo' ),
				'before_widget' => '<section id="%1$s" class="widget card border-0 shadow-sm p-4 mb-4 %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold">',
				'after_title'   => '</h4>',
			)
		);

		// Blog Sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Blog Sidebar', 'robo' ),
				'id'            => 'blog-sidebar',
				'description'   => esc_html__( 'Appears on blog posts, category archives, tags, etc.', 'robo' ),
				'before_widget' => '<section id="%1$s" class="widget card border-0 shadow-sm p-4 mb-4 %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold">',
				'after_title'   => '</h4>',
			)
		);

		// Shop Sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop Sidebar', 'robo' ),
				'id'            => 'shop-sidebar',
				'description'   => esc_html__( 'Appears on shop pages if WooCommerce is active.', 'robo' ),
				'before_widget' => '<section id="%1$s" class="widget card border-0 shadow-sm p-4 mb-4 %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title h5 border-bottom pb-2 mb-3 text-dark fw-bold">',
				'after_title'   => '</h4>',
			)
		);

		// Footer Widgets 1 - 4.
		for ( $i = 1; $i <= 4; $i++ ) {
			register_sidebar(
				array(
					'name'          => sprintf( esc_html__( 'Footer Widget %d', 'robo' ), $i ),
					'id'            => 'footer-widget-' . $i,
					'description'   => sprintf( esc_html__( 'Footer widget column %d.', 'robo' ), $i ),
					'before_widget' => '<div id="%1$s" class="widget mb-4 %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h5 class="widget-title h6 text-white text-uppercase fw-bold mb-3">',
					'after_title'   => '</h5>',
				)
			);
		}
	}
}
add_action( 'widgets_init', 'robo_widgets_init' );
