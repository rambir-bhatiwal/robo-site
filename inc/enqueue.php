<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'robo_scripts' ) ) {
	/**
	 * Enqueue styles and scripts.
	 */
	function robo_scripts() {
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
