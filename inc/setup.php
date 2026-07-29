<?php
/**
 * Theme basic setup.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'robo_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function robo_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'robo', ROBO_THEME_DIR . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register Navigation Menus.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'robo' ),
				'footer'  => esc_html__( 'Footer Menu', 'robo' ),
				'topbar'  => esc_html__( 'Top Menu', 'robo' ),
				'mobile'  => esc_html__( 'Mobile Menu', 'robo' ),
				'social'  => esc_html__( 'Social Menu', 'robo' ),
			)
		);

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Enable support for Custom Background.
		add_theme_support(
			'custom-background',
			apply_filters(
				'robo_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Enable support for Custom Logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Enable support for Custom Header.
		add_theme_support(
			'custom-header',
			apply_filters(
				'robo_custom_header_args',
				array(
					'default-image'      => '',
					'width'              => 1920,
					'height'             => 1080,
					'flex-height'        => true,
					'flex-width'         => true,
					'wp-head-callback'   => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'assets/css/style.css' );
	}
}
add_action( 'after_setup_theme', 'robo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function robo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'robo_content_width', 1140 );
}
add_action( 'after_setup_theme', 'robo_content_width', 0 );

/**
 * Prevent external HTTP requests to api.wordpress.org to eliminate connection warning messages.
 */
function robo_block_wordpress_org_http_requests( $pre, $parsed_args, $url ) {
	if ( false !== strpos( $url, 'api.wordpress.org' ) ) {
		return array(
			'headers'  => array(),
			'body'     => json_encode( array( 'themes' => array(), 'plugins' => array(), 'translations' => array() ) ),
			'response' => array(
				'code'    => 200,
				'message' => 'OK',
			),
			'cookies'  => array(),
			'filename' => null,
		);
	}
	return $pre;
}
add_filter( 'pre_http_request', 'robo_block_wordpress_org_http_requests', 10, 3 );

/**
 * Remove WordPress core update check hooks and clear scheduled transients.
 */
function robo_disable_update_cron_actions() {
	remove_action( 'wp_version_check', 'wp_version_check' );
	remove_action( 'wp_update_plugins', 'wp_update_plugins' );
	remove_action( 'wp_update_themes', 'wp_update_themes' );
	remove_action( 'admin_init', '_maybe_update_themes' );
	remove_action( 'admin_init', '_maybe_update_plugins' );
	remove_action( 'admin_init', '_maybe_update_core' );

	add_filter( 'pre_site_transient_update_themes', '__return_null' );
	add_filter( 'pre_site_transient_update_plugins', '__return_null' );
	add_filter( 'pre_site_transient_update_core', '__return_null' );
}
add_action( 'init', 'robo_disable_update_cron_actions' );
add_action( 'admin_init', 'robo_disable_update_cron_actions' );


