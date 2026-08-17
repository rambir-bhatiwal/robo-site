<?php
/**
 * Backwards-compatibility wrapper for Quick Actions Bar template.
 * Loads the dedicated Quick Access section template part.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'template-parts/sections/quick-access' );
