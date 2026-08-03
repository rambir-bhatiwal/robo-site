<?php
/**
 * The front page template file.
 *
 * If the user has selected "a static page" for their homepage, this file
 * will be used to render the front page, loading all sections.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// List of homepage sections to render.
$homepage_sections = array(
	'hero',
	// 'about',
	// 'services',
	'popular-products',
	'features',
	'portfolio',
	// 'counter',
	// 'testimonials',
	'team',
	'pricing',
	// 'faq',
	// 'latest-blog',
	'newsletter',
	// 'contact',
);

foreach ( $homepage_sections as $section ) {
	get_template_part( 'template-parts/sections/' . $section );
}

get_footer();