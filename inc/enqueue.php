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
 * Remove jQuery Migrate on frontend to eliminate unnecessary console logs and save HTTP requests.
 */
function robo_remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		if ( ! empty( $script->deps ) ) {
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}
add_action( 'wp_default_scripts', 'robo_remove_jquery_migrate' );

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

		// Enqueue Quick Access Section Style.
		wp_enqueue_style(
			'robo-quick-access',
			ROBO_THEME_URI . '/assets/css/sections/quick-access.css',
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

		// Enqueue Popular Products Section Style.
		wp_enqueue_style(
			'robo-popular-products',
			ROBO_THEME_URI . '/assets/css/sections/popular-products.css',
			array( 'bootstrap', 'robo-style' ),
			ROBO_THEME_VERSION,
			'all'
		);

		// Enqueue Why Choose Us Section Style.
		wp_enqueue_style(
			'robo-why-choose-us',
			ROBO_THEME_URI . '/assets/css/sections/why-choose-us.css',
			array( 'bootstrap', 'robo-style' ),
			ROBO_THEME_VERSION,
			'all'
		);

		// Enqueue Customer Reviews Section Style.
		wp_enqueue_style(
			'robo-customer-reviews',
			ROBO_THEME_URI . '/assets/css/sections/customer-reviews.css',
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
			array( 'bootstrap-bundle' ),
			ROBO_THEME_VERSION,
			true
		);

		// Enqueue Customer Reviews Section JS.
		wp_enqueue_script(
			'robo-customer-reviews',
			ROBO_THEME_URI . '/assets/js/customer-reviews.js',
			array( 'bootstrap-bundle' ),
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

