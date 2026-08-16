<?php
/**
 * Robo Theme - Hero Customizer
 *
 * Contains ONLY Customizer controls and settings related to
 * the Hero section that are actively used by the theme.
 *
 * Existing setting IDs are intentionally preserved
 * so previously saved Customizer values continue working.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Hero Section settings and controls in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function robo_customize_register_hero( $wp_customize ) {

	// ----------------------------------------------------
	// Hero Customizer Section Registration
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_hero_section',
		array(
			'title'    => esc_html__( 'Hero Section Settings', 'robo' ),
			'panel'    => 'robo_options_panel',
			'priority' => 30,
		)
	);

	// ----------------------------------------------------
	// Hero Background Image (Default / Fallback)
	// ----------------------------------------------------
	$wp_customize->add_setting(
		'robo_hero_bg_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'robo_hero_bg_image',
			array(
				'label'   => esc_html__( 'Hero Background Image', 'robo' ),
				'section' => 'robo_hero_section',
			)
		)
	);

	// ----------------------------------------------------
	// Responsive Hero Background Images
	// ----------------------------------------------------
	// Desktop Background Image
	$wp_customize->add_setting(
		'robo_hero_bg_image_desktop',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'robo_hero_bg_image_desktop',
			array(
				'label'   => esc_html__( 'Hero Background Image (Desktop)', 'robo' ),
				'section' => 'robo_hero_section',
			)
		)
	);

	// Tablet Background Image
	$wp_customize->add_setting(
		'robo_hero_bg_image_tablet',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'robo_hero_bg_image_tablet',
			array(
				'label'   => esc_html__( 'Hero Background Image (Tablet)', 'robo' ),
				'section' => 'robo_hero_section',
			)
		)
	);

	// Mobile Background Image
	$wp_customize->add_setting(
		'robo_hero_bg_image_mobile',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'robo_hero_bg_image_mobile',
			array(
				'label'   => esc_html__( 'Hero Background Image (Mobile)', 'robo' ),
				'section' => 'robo_hero_section',
			)
		)
	);

	// ----------------------------------------------------
	// Hero Background Overlay Settings
	// ----------------------------------------------------
	// Enable Overlay Checkbox
	$wp_customize->add_setting(
		'robo_hero_overlay_enable',
		array(
			'default'           => false,
			'sanitize_callback' => 'robo_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'robo_hero_overlay_enable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Enable Background Overlay', 'robo' ),
			'description' => esc_html__( 'Show a color overlay over the hero background image for better text readability.', 'robo' ),
			'section'     => 'robo_hero_section',
		)
	);

	// Overlay Color
	$wp_customize->add_setting(
		'robo_hero_overlay_color',
		array(
			'default'           => '#000000',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'robo_hero_overlay_color',
			array(
				'label'   => esc_html__( 'Overlay Color', 'robo' ),
				'section' => 'robo_hero_section',
			)
		)
	);

	// Overlay Opacity
	$wp_customize->add_setting(
		'robo_hero_overlay_opacity',
		array(
			'default'           => '0.3',
			'sanitize_callback' => 'robo_sanitize_float',
		)
	);
	$wp_customize->add_control(
		'robo_hero_overlay_opacity',
		array(
			'type'        => 'number',
			'label'       => esc_html__( 'Overlay Opacity', 'robo' ),
			'description' => esc_html__( 'Value between 0 (transparent) and 1 (opaque). Default is 0.3.', 'robo' ),
			'section'     => 'robo_hero_section',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 1,
				'step' => 0.05,
			),
		)
	);

	// ----------------------------------------------------
	// Hero Headings (Title & Subtitle)
	// ----------------------------------------------------
	$wp_customize->add_setting(
		'robo_hero_title',
		array(
			'default'           => esc_html__( 'Build Smarter Digital Experiences with Robo', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_hero_title',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Hero Title', 'robo' ),
			'section' => 'robo_hero_section',
		)
	);

	$wp_customize->add_setting(
		'robo_hero_subtitle',
		array(
			'default'           => esc_html__( 'Robo is a 100% custom-designed WordPress theme using Bootstrap 5 to launch elegant, clean websites fast.', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_hero_subtitle',
		array(
			'type'    => 'textarea',
			'label'   => esc_html__( 'Hero Subtitle', 'robo' ),
			'section' => 'robo_hero_section',
		)
	);

	// ----------------------------------------------------
	// Hero Call-to-Action Buttons
	// ----------------------------------------------------
	// Button 1 (Text & URL)
	$wp_customize->add_setting(
		'robo_hero_btn1_text',
		array(
			'default'           => esc_html__( 'Get Started', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_hero_btn1_text',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button 1 Text', 'robo' ),
			'section' => 'robo_hero_section',
		)
	);

	$wp_customize->add_setting(
		'robo_hero_btn1_url',
		array(
			'default'           => '#contact',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'robo_hero_btn1_url',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button 1 URL', 'robo' ),
			'section' => 'robo_hero_section',
		)
	);

	// Button 2 (Text & URL)
	$wp_customize->add_setting(
		'robo_hero_btn2_text',
		array(
			'default'           => esc_html__( 'Learn More', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_hero_btn2_text',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button 2 Text', 'robo' ),
			'section' => 'robo_hero_section',
		)
	);

	$wp_customize->add_setting(
		'robo_hero_btn2_url',
		array(
			'default'           => '#about',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'robo_hero_btn2_url',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button 2 URL', 'robo' ),
			'section' => 'robo_hero_section',
		)
	);
}
