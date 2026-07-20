<?php
/**
 * Template Name: About Us
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="about-template-wrapper bg-light-subtle pb-0 overflow-hidden">
	<!-- Hero & Welcome Introduction -->
	<?php get_template_part( 'template-parts/sections/about-hero' ); ?>

	<!-- About RoboScaler -->
	<?php get_template_part( 'template-parts/sections/about' ); ?>

	<!-- What We Do -->
	<?php get_template_part( 'template-parts/sections/about-what-we-do' ); ?>

	<!-- Our Specialization / Services -->
	<?php get_template_part( 'template-parts/sections/services' ); ?>

	<!-- Our Goal -->
	<?php get_template_part( 'template-parts/sections/about-our-goal' ); ?>

	<!-- Why Choose RoboScaler -->
	<?php get_template_part( 'template-parts/sections/about-why-choose-us' ); ?>

	<!-- Our Customers -->
	<?php get_template_part( 'template-parts/sections/about-our-customers' ); ?>

	<!-- Closing / Call-to-Action -->
	<?php get_template_part( 'template-parts/sections/about-cta' ); ?>

	<!-- Subscribe / Newsletter Section -->
	<?php get_template_part( 'template-parts/sections/newsletter' ); ?>
</div>

<?php
get_footer();
