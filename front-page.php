<?php
/**
 * The front page template file for the modern STEM & Robotics Homepage.
 *
 * Loads all 19 new homepage v2 sections sequentially without altering
 * the theme header, topbar, or footer.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Sequential array of all 19 Homepage V2 sections.
$homepage_v2_sections = array(
	'hero',
	'trust-bar',
	'categories',
	'featured-kits',
	'bestsellers',
	'ai-learning',
	'why-choose-us',
	'learning-resources',
	'project-showcase',
	'stem-programs',
	'workshops',
	'success-stories',
	'testimonials',
	'partner-schools',
	'brand-logos',
	'latest-blogs',
	'faq',
	'newsletter',
	'final-cta',
);

foreach ( $homepage_v2_sections as $section ) {
	get_template_part( 'template-parts/sections/homepage-v2/' . $section );
}

get_footer();