<?php
/**
 * Template Loader for Robo LMS.
 *
 * @package Robo\LMS\Frontend
 */

namespace Robo\LMS\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TemplateLoader
 */
class TemplateLoader {

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
		add_filter( 'template_include', array( $this, 'load_cpt_template' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
	}

	/**
	 * Enqueue Frontend CSS and JS for Learning CPT pages.
	 */
	public function enqueue_frontend_assets(): void {
		if ( ! is_singular( $this->post_types ) && ! is_post_type_archive( $this->post_types ) && ! is_tax( array( 'learning-category', 'learning-tag' ) ) ) {
			return;
		}

		// Frontend LMS CSS
		wp_enqueue_style(
			'robo-lms-frontend-style',
			ROBO_THEME_URI . '/assets/css/lms-frontend.css',
			array( 'dashicons', 'bootstrap' ),
			ROBO_THEME_VERSION
		);

		// Frontend LMS JS
		wp_enqueue_script(
			'robo-lms-frontend-js',
			ROBO_THEME_URI . '/assets/js/lms-frontend.js',
			array( 'jquery', 'bootstrap-bundle' ),
			ROBO_THEME_VERSION,
			true
		);

		wp_localize_script(
			'robo-lms-frontend-js',
			'roboLMSParams',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'robo_nonce' ),
			)
		);
	}

	/**
	 * Intercept template selection for CPTs if needed.
	 *
	 * @param string $template Selected template file path.
	 * @return string Modified template file path.
	 */
	public function load_cpt_template( string $template ): string {
		$post_type = get_post_type();

		if ( ! in_array( $post_type, $this->post_types, true ) ) {
			return $template;
		}

		if ( is_singular( $post_type ) ) {
			$file = "single-{$post_type}.php";
			$find = locate_template( array( $file ) );
			if ( $find ) {
				return $find;
			}
		}

		if ( is_post_type_archive( $post_type ) ) {
			$file = "archive-{$post_type}.php";
			$find = locate_template( array( $file ) );
			if ( $find ) {
				return $find;
			}
		}

		return $template;
	}
}
