<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Preload Bootstrap Icons Webfont to eliminate icon render delays across the site.
 */
function robo_preload_icon_fonts() {
	echo '<link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/bootstrap-icons.woff2" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
}
add_action( 'wp_head', 'robo_preload_icon_fonts', 1 );

if ( ! function_exists( 'robo_scripts' ) ) {
	/**
	 * Enqueue styles and scripts.
	 */
	function robo_scripts() {
		// Enqueue WordPress Dashicons for icon display (logged in and logged out users).
		wp_enqueue_style( 'dashicons' );

		// Enqueue Bootstrap Icons globally (eliminates icon load delay on navigation bar and components).
		wp_enqueue_style(
			'bootstrap-icons',
			'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
			array(),
			'1.11.3',
			'all'
		);

		// Enqueue Bootstrap CSS.
		wp_enqueue_style(
			'bootstrap',
			ROBO_THEME_URI . '/assets/css/bootstrap.min.css',
			array(),
			'5.3.3',
			'all'
		);

		// Enqueue Theme's Custom Style.
		wp_enqueue_style(
			'robo-custom-style',
			ROBO_THEME_URI . '/assets/css/style.css',
			array( 'bootstrap' ),
			ROBO_THEME_VERSION,
			'all'
		);

		// Enqueue WordPress Main Style (style.css in root).
		wp_enqueue_style(
			'robo-style',
			get_stylesheet_uri(),
			array( 'robo-custom-style' ),
			ROBO_THEME_VERSION,
			'all'
		);

		// Enqueue Trust Statistics Section Style.
		wp_enqueue_style(
			'robo-trust-statistics',
			ROBO_THEME_URI . '/assets/css/sections/trust-statistics.css',
			array( 'bootstrap', 'robo-style' ),
			ROBO_THEME_VERSION,
			'all'
		);

		// Enqueue Quick Actions Section Style.
		wp_enqueue_style(
			'robo-quick-actions',
			ROBO_THEME_URI . '/assets/css/sections/quick-actions.css',
			array( 'bootstrap', 'robo-style', 'robo-trust-statistics' ),
			ROBO_THEME_VERSION,
			'all'
		);

		// Enqueue Quick Actions Bar CTA Style.
		wp_enqueue_style(
			'robo-quick-actions-bar',
			ROBO_THEME_URI . '/assets/css/sections/quick-actions-bar.css',
			array( 'bootstrap', 'robo-style' ),
			ROBO_THEME_VERSION,
			'all'
		);

		// Enqueue Product Categories Slider Style.
		wp_enqueue_style(
			'robo-category-slider',
			ROBO_THEME_URI . '/assets/css/sections/category-slider.css',
			array( 'bootstrap', 'robo-style' ),
			ROBO_THEME_VERSION,
			'all'
		);

		// Enqueue Bootstrap JS.
		wp_enqueue_script(
			'bootstrap-bundle',
			ROBO_THEME_URI . '/assets/js/bootstrap.bundle.min.js',
			array(),
			'5.3.3',
			true
		);

		// Enqueue Theme's Main JS.
		wp_enqueue_script(
			'robo-main',
			ROBO_THEME_URI . '/assets/js/main.js',
			array( 'bootstrap-bundle' ),
			ROBO_THEME_VERSION,
			true
		);

		// Enqueue Product Categories Slider JS.
		wp_enqueue_script(
			'robo-category-slider',
			ROBO_THEME_URI . '/assets/js/category-slider.js',
			array(),
			ROBO_THEME_VERSION,
			true
		);

		// Enqueue Comment Reply script if threaded comments are active.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Pass data to main JS (such as admin-ajax URL if needed).
		wp_localize_script(
			'robo-main',
			'roboParams',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'robo_nonce' ),
				'postId'  => get_the_ID(),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'robo_scripts' );

/**
 * Add resource hints for CDN icon font preconnecting.
 */
function robo_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type || 'dns-prefetch' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://cdn.jsdelivr.net',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'robo_resource_hints', 10, 2 );

