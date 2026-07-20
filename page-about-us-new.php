<?php
/**
 * Template Name: About Us Page
 * The template for displaying the About Us page by slug or selection.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="about-page-wrapper bg-light-subtle pb-5">
	<!-- Hero & Welcome Introduction -->
	<?php get_template_part( 'template-parts/sections/about-hero' ); ?>

	<!-- What We Do -->
	<?php get_template_part( 'template-parts/sections/about-what-we-do' ); ?>

	<!-- Our Goal -->
	<?php get_template_part( 'template-parts/sections/about-our-goal' ); ?>

	<!-- Why Choose RoboScaler -->
	<?php get_template_part( 'template-parts/sections/about-why-choose-us' ); ?>

	<!-- Our Customers -->
	<?php get_template_part( 'template-parts/sections/about-our-customers' ); ?>

	<!-- Closing / Call-to-Action -->
	<?php get_template_part( 'template-parts/sections/about-cta' ); ?>
</div>

<?php
get_footer();
