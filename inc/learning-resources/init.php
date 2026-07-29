<?php
/**
 * Learning Resources Module Initialization.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define Constants for Module
define( 'ROBO_LR_PATH', ROBO_THEME_DIR . '/inc/learning-resources' );

// Require Sub-files
require_once ROBO_LR_PATH . '/cpt-setup.php';
require_once ROBO_LR_PATH . '/helpers.php';
require_once ROBO_LR_PATH . '/meta-boxes.php';
require_once ROBO_LR_PATH . '/ajax-handlers.php';

/**
 * Enqueue Frontend Assets for Learning Resources
 */
function robo_lr_enqueue_frontend_assets() {
	if ( is_post_type_archive( 'learning-resource' ) || is_singular( 'learning-resource' ) || is_tax( 'learning_category' ) || is_tax( 'learning_tag' ) || is_page_template( 'template-learning-resources.php' ) ) {

		// Enqueue Bootstrap Icons if not already loaded
		wp_enqueue_style(
			'bootstrap-icons',
			'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
			array(),
			'1.11.3'
		);

		// Learning Resources CSS
		wp_enqueue_style(
			'robo-lr-frontend-css',
			ROBO_THEME_URI . '/assets/css/learning-resources.css',
			array( 'bootstrap' ),
			ROBO_THEME_VERSION
		);

		// Learning Resources JS
		wp_enqueue_script(
			'robo-lr-frontend-js',
			ROBO_THEME_URI . '/assets/js/learning-resources.js',
			array( 'jquery', 'bootstrap-bundle' ),
			ROBO_THEME_VERSION,
			true
		);

		wp_localize_script(
			'robo-lr-frontend-js',
			'roboLrParams',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'robo_lr_nonce' ),
				'postId'  => get_the_ID(),
				'i18n'    => array(
					'copied'       => __( 'Copied to clipboard!', 'robo' ),
					'error'        => __( 'Something went wrong. Please try again.', 'robo' ),
					'downloading'  => __( 'Preparing download...', 'robo' ),
				),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'robo_lr_enqueue_frontend_assets' );

/**
 * Template Loader for Learning Resources
 */
function robo_lr_template_loader( $template ) {
	if ( is_singular( 'learning-resource' ) ) {
		$theme_single = ROBO_THEME_DIR . '/single-learning-resource.php';
		if ( file_exists( $theme_single ) ) {
			return $theme_single;
		}
	} elseif ( is_post_type_archive( 'learning-resource' ) ) {
		$theme_archive = ROBO_THEME_DIR . '/archive-learning-resource.php';
		if ( file_exists( $theme_archive ) ) {
			return $theme_archive;
		}
	}
	return $template;
}
add_filter( 'template_include', 'robo_lr_template_loader', 99 );

