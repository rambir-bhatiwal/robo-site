<?php
/**
 * Robo functions and definitions
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define Theme Constants.
define( 'ROBO_THEME_VERSION', '1.0.1' );
define( 'ROBO_THEME_DIR', get_template_directory() );
define( 'ROBO_THEME_URI', get_template_directory_uri() );

/**
 * Required files.
 */
// Custom Bootstrap 5 NavWalker.
require_once ROBO_THEME_DIR . '/inc/navwalker.php';

// Custom helpers (Post views, Reading time, etc.).
require_once ROBO_THEME_DIR . '/inc/helpers.php';

// Theme setup and text domain.
require_once ROBO_THEME_DIR . '/inc/setup.php';

// Enqueue styles and scripts.
require_once ROBO_THEME_DIR . '/inc/enqueue.php';

// Customizer additions.
require_once ROBO_THEME_DIR . '/inc/customizer.php';

// Register Widget areas.
require_once ROBO_THEME_DIR . '/inc/widgets.php';

// Breadcrumbs class/functions.
require_once ROBO_THEME_DIR . '/inc/breadcrumbs.php';

// Pagination functions.
require_once ROBO_THEME_DIR . '/inc/pagination.php';

// Custom template tags.
require_once ROBO_THEME_DIR . '/inc/template-functions.php';

// WooCommerce integration.
if ( class_exists( 'WooCommerce' ) ) {
	require_once ROBO_THEME_DIR . '/inc/woocommerce.php';
}
