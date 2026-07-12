<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text btn btn-primary position-absolute top-0 start-0 m-3 z-3" href="#primary">
		<?php esc_html_e( 'Skip to content', 'robo' ); ?>
	</a>

	<header id="masthead" class="site-header sticky-top bg-white border-bottom shadow-sm">
		<?php
		// Load Topbar.
		get_template_part( 'template-parts/header/topbar' );

		// Load Main Navigation.
		get_template_part( 'template-parts/header/navigation' );
		?>
	</header>

	<div id="content" class="site-content">
