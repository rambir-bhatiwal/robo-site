<?php
/**
 * Robo Theme - Quick Access Customizer
 *
 * This file contains ONLY Quick Access Customizer settings:
 * - Section Title setting & control
 * - Section Description setting & control
 * - Three Button settings & controls (Text & URL for Button 1, Button 2, Button 3)
 *
 * All settings are scoped under the Quick Access Customizer section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Quick Access Section settings and controls in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function robo_customize_register_quick_access( $wp_customize ) {

	// ----------------------------------------------------
	// Quick Access Customizer Section Registration
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_quick_access_section',
		array(
			'title'       => esc_html__( 'Quick Access Settings', 'robo' ),
			'description' => esc_html__( 'Configure the Quick Access section content and action buttons.', 'robo' ),
			'panel'       => 'robo_options_panel',
			'priority'    => 32,
		)
	);

	// ----------------------------------------------------
	// Section Title
	// ----------------------------------------------------
	$wp_customize->add_setting(
		'robo_quick_access_title',
		array(
			'default'           => esc_html__( 'Start Your Robotics Journey', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_quick_access_title',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Quick Access Title', 'robo' ),
			'description' => esc_html__( 'Main heading for the Quick Access section.', 'robo' ),
			'section'     => 'robo_quick_access_section',
		)
	);

	// ----------------------------------------------------
	// Section Description
	// ----------------------------------------------------
	$wp_customize->add_setting(
		'robo_quick_access_desc',
		array(
			'default'           => esc_html__( 'Explore our robotics kits or watch product demonstrations before getting started.', 'robo' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_quick_access_desc',
		array(
			'type'        => 'textarea',
			'label'       => esc_html__( 'Quick Access Description', 'robo' ),
			'description' => esc_html__( 'Short descriptive text below the title.', 'robo' ),
			'section'     => 'robo_quick_access_section',
		)
	);

	// ----------------------------------------------------
	// Button 1 (Text & URL)
	// ----------------------------------------------------
	$wp_customize->add_setting(
		'robo_quick_access_btn1_text',
		array(
			'default'           => esc_html__( 'Explore Robots', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_quick_access_btn1_text',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Button 1 Text', 'robo' ),
			'description' => esc_html__( 'Label for the first action button.', 'robo' ),
			'section'     => 'robo_quick_access_section',
		)
	);

	$wp_customize->add_setting(
		'robo_quick_access_btn1_url',
		array(
			'default'           => '#popular-products',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'robo_quick_access_btn1_url',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Button 1 URL', 'robo' ),
			'description' => esc_html__( 'Destination link for the first action button.', 'robo' ),
			'section'     => 'robo_quick_access_section',
		)
	);

	// ----------------------------------------------------
	// Button 2 (Text & URL)
	// ----------------------------------------------------
	$wp_customize->add_setting(
		'robo_quick_access_btn2_text',
		array(
			'default'           => esc_html__( 'Watch Videos', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_quick_access_btn2_text',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Button 2 Text', 'robo' ),
			'description' => esc_html__( 'Label for the second action button.', 'robo' ),
			'section'     => 'robo_quick_access_section',
		)
	);

	$wp_customize->add_setting(
		'robo_quick_access_btn2_url',
		array(
			'default'           => '#videos',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'robo_quick_access_btn2_url',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Button 2 URL', 'robo' ),
			'description' => esc_html__( 'Destination link for the second action button.', 'robo' ),
			'section'     => 'robo_quick_access_section',
		)
	);

	// ----------------------------------------------------
	// Button 3 (Text & URL)
	// ----------------------------------------------------
	$wp_customize->add_setting(
		'robo_quick_access_btn3_text',
		array(
			'default'           => esc_html__( 'Expert Support', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_quick_access_btn3_text',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Button 3 Text', 'robo' ),
			'description' => esc_html__( 'Label for the third action button.', 'robo' ),
			'section'     => 'robo_quick_access_section',
		)
	);

	$wp_customize->add_setting(
		'robo_quick_access_btn3_url',
		array(
			'default'           => '#support',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'robo_quick_access_btn3_url',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Button 3 URL', 'robo' ),
			'description' => esc_html__( 'Destination link for the third action button.', 'robo' ),
			'section'     => 'robo_quick_access_section',
		)
	);
}
