<?php
/**
 * Robo Theme Customizer.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function robo_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'robo_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'robo_customize_partial_blogdescription',
			)
		);
	}

	// ----------------------------------------------------
	// Panel: Robo Theme Options
	// ----------------------------------------------------
	$wp_customize->add_panel(
		'robo_options_panel',
		array(
			'title'       => esc_html__( 'Robo Theme Options', 'robo' ),
			'description' => esc_html__( 'Configure Robo Custom Theme settings here.', 'robo' ),
			'priority'    => 30,
		)
	);

	// ----------------------------------------------------
	// Section: General Settings & Layout
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_general_section',
		array(
			'title'    => esc_html__( 'General & Layout', 'robo' ),
			'panel'    => 'robo_options_panel',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'robo_container_width',
		array(
			'default'           => 'container',
			'sanitize_callback' => 'robo_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'robo_container_width',
		array(
			'type'     => 'select',
			'label'    => esc_html__( 'Container Width', 'robo' ),
			'section'  => 'robo_general_section',
			'choices'  => array(
				'container'       => esc_html__( 'Standard Grid (1200px max)', 'robo' ),
				'container-fluid' => esc_html__( 'Full Width (Fluid)', 'robo' ),
			),
		)
	);

	$wp_customize->add_setting(
		'robo_copyright_text',
		array(
			'default'           => '© ' . date( 'Y' ) . ' Robo Theme. All rights reserved.',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_copyright_text',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Copyright Text', 'robo' ),
			'description' => esc_html__( 'Visible in the footer copyright area.', 'robo' ),
			'section'     => 'robo_general_section',
		)
	);

	// ----------------------------------------------------
	// Section: Colors & Styling
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_colors_section',
		array(
			'title'    => esc_html__( 'Theme Colors', 'robo' ),
			'panel'    => 'robo_options_panel',
			'priority' => 20,
		)
	);

	$wp_customize->add_setting(
		'robo_primary_color',
		array(
			'default'           => '#0052FF',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'robo_primary_color',
			array(
				'label'   => esc_html__( 'Primary Color', 'robo' ),
				'section' => 'robo_colors_section',
			)
		)
	);

	$wp_customize->add_setting(
		'robo_header_bg',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'robo_header_bg',
			array(
				'label'   => esc_html__( 'Header Background', 'robo' ),
				'section' => 'robo_colors_section',
			)
		)
	);

	$wp_customize->add_setting(
		'robo_footer_bg',
		array(
			'default'           => '#090F1d',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'robo_footer_bg',
			array(
				'label'   => esc_html__( 'Footer Background', 'robo' ),
				'section' => 'robo_colors_section',
			)
		)
	);

	// ----------------------------------------------------
	// Section: Hero settings
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_hero_section',
		array(
			'title'    => esc_html__( 'Hero Section Settings', 'robo' ),
			'panel'    => 'robo_options_panel',
			'priority' => 30,
		)
	);

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

	// Hero Background Image (Desktop)
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

	// Hero Background Image (Tablet)
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

	// Hero Background Image (Mobile)
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


	// Hero Background Overlay Enable Toggle
	$wp_customize->add_setting(
		'robo_hero_overlay_enable',
		array(
			'default'           => false,
			'sanitize_callback' => 'robo_sanitize_checkbox',
		)
	);

	// Add a checkbox control for enabling/disabling the hero background overlay
	$wp_customize->add_control(
		'robo_hero_overlay_enable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Enable Background Overlay', 'robo' ),
			'description' => esc_html__( 'Show a color overlay over the hero background image for better text readability.', 'robo' ),
			'section'     => 'robo_hero_section',
		)
	);

	// Hero Background Overlay Color
	$wp_customize->add_setting(
		'robo_hero_overlay_color',
		array(
			'default'           => '#000000',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Add a color picker control for the hero background overlay color
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

	// Hero Background Overlay Opacity
	$wp_customize->add_setting(
		'robo_hero_overlay_opacity',
		array(
			'default'           => '0.3',
			'sanitize_callback' => 'robo_sanitize_float',
		)
	);

	// Add a number input control for the hero background overlay opacity
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

	$wp_customize->add_setting(
		'robo_hero_image',
		array(
			// 'default'           => 'https://app.roboscaler.com/wp-content/uploads/2026/07/513ac378-2fee-4500-8756-c9fb74781012.png',
			'default'           => 'https://roboscaler.com/wp-content/uploads/2026/07/ChatGPT-Image-Mar-13-2026-02_28_53-PM-3-1024x683.png',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'robo_hero_image',
			array(
				'label'       => esc_html__( 'Hero Main/Featured Image', 'robo' ),
				'description' => esc_html__( 'The main featured image shown on the right side of the hero section.', 'robo' ),
				'section'     => 'robo_hero_section',
			)
		)
	);

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

	// Hero Button 1
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

	// Hero Button 2
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

	// Statistics
	for ( $i = 1; $i <= 4; $i++ ) {
		$wp_customize->add_setting(
			"robo_hero_stat{$i}_value",
			array(
				'default'           => $i === 1 ? '99%' : ( $i === 2 ? '150+' : ( $i === 3 ? '15M+' : '24/7' ) ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_hero_stat{$i}_value",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Stat %d Value', 'robo' ), $i ),
				'section' => 'robo_hero_section',
			)
		);

		$wp_customize->add_setting(
			"robo_hero_stat{$i}_label",
			array(
				'default'           => $i === 1 ? 'Customer Satisfaction' : ( $i === 2 ? 'Successful Projects' : ( $i === 3 ? 'Lines of Code' : 'Dedicated Support' ) ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_hero_stat{$i}_label",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Stat %d Label', 'robo' ), $i ),
				'section' => 'robo_hero_section',
			)
		);
	}

	// ----------------------------------------------------
	// Section: Company Information
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_company_section',
		array(
			'title'    => esc_html__( 'Company Information', 'robo' ),
			'panel'    => 'robo_options_panel',
			'priority' => 35,
		)
	);

	$company_fields = array(
		'company_name'      => array( 'label' => esc_html__( 'Company Name', 'robo' ), 'default' => 'RoboScaler', 'type' => 'text' ),
		'company_address'   => array( 'label' => esc_html__( 'Address', 'robo' ), 'default' => '100 Robotics Way, Austin, TX 78701', 'type' => 'text' ),
		'company_maps_url'  => array( 'label' => esc_html__( 'Google Maps URL', 'robo' ), 'default' => 'https://maps.google.com/?q=100+Robotics+Way,+Austin,+TX+78701', 'type' => 'text' ),
		'company_email'     => array( 'label' => esc_html__( 'Support Email', 'robo' ), 'default' => 'roboscaler@gmail.com', 'type' => 'text' ),
		'company_email_gen' => array( 'label' => esc_html__( 'General Contact Email', 'robo' ), 'default' => 'roboscaler@gmail.com', 'type' => 'text' ),
		'company_phone'     => array( 'label' => esc_html__( 'Phone Number', 'robo' ), 'default' => '+91 80768 87675', 'type' => 'text' ),
	);

	foreach ( $company_fields as $key => $field ) {
		$wp_customize->add_setting(
			"robo_{$key}",
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_{$key}",
			array(
				'type'    => $field['type'],
				'label'   => $field['label'],
				'section' => 'robo_company_section',
			)
		);
	}

	// ----------------------------------------------------
	// Section: Social Links
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_social_section',
		array(
			'title'    => esc_html__( 'Social Media Links', 'robo' ),
			'panel'    => 'robo_options_panel',
			'priority' => 40,
		)
	);

	$socials = array(
		'facebook'  => esc_html__( 'Facebook URL', 'robo' ),
		'twitter'   => esc_html__( 'Twitter/X URL', 'robo' ),
		'whatsapp'  => esc_html__( 'WhatsApp URL', 'robo' ),
		'instagram' => esc_html__( 'Instagram URL', 'robo' ),
		'linkedin'  => esc_html__( 'LinkedIn URL', 'robo' ),
		'youtube'   => esc_html__( 'YouTube URL', 'robo' ),
	);

	foreach ( $socials as $key => $label ) {
		$default_val = '';
		if ( 'whatsapp' === $key ) {
			$default_val = 'https://wa.me/918076887675';
		} elseif ( 'instagram' === $key ) {
			$default_val = 'https://www.instagram.com/roboscaler?igsh=MXRvdTV5aHdqamFvMQ==';
		} elseif ( 'youtube' === $key ) {
			$default_val = 'https://youtube.com/@roboscaler?si=xkVvD4g4WzZ4YSpD';
		}

		$wp_customize->add_setting(
			"robo_social_{$key}",
			array(
				'default'           => $default_val,
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"robo_social_{$key}",
			array(
				'type'    => 'text',
				'label'   => $label,
				'section' => 'robo_social_section',
			)
		);
	}

	// ----------------------------------------------------
	// Section: About Us Page Settings
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_about_page_section',
		array(
			'title'       => esc_html__( 'About Us Page Settings', 'robo' ),
			'description' => esc_html__( 'Upload images for the About Us page sections.', 'robo' ),
			'panel'       => 'robo_options_panel',
			'priority'    => 32,
		)
	);

	$std_desc = esc_html__( 'Replace with a REAL stock photograph of 8th–12th grade school students wearing proper school uniforms, working on robotics, STEM, electronics, coding, or science projects. Do NOT use adults, university students, business people, or AI-generated images.', 'robo' );

	$about_images = array(
		'hero'       => array(
			'label'   => esc_html__( 'Hero Section Image', 'robo' ),
			'default' => 'https://app.roboscaler.com/wp-content/uploads/2026/07/539e0c5e-5c07-49a5-aa03-de3d6bb5cfdd-1.jpeg',
		),
		'intro'      => array(
			'label'   => esc_html__( 'Welcome Introduction Image', 'robo' ),
			'default' => 'https://app.roboscaler.com/wp-content/uploads/2026/07/e24e5cbc-6dfd-4bf6-bba0-d90c71644b1a-e1784633711885.jpeg',
		),
		'what_we_do' => array(
			'label'   => esc_html__( 'What We Do Image', 'robo' ),
			'default' => 'https://app.roboscaler.com/wp-content/uploads/2026/07/2eb16044-dd3d-44cc-978e-234df8077e6c.jpeg',
		),
		'our_goal'   => array(
			'label'   => esc_html__( 'Our Goal Image', 'robo' ),
			'default' => 'https://app.roboscaler.com/wp-content/uploads/2026/07/a3c7cae9-f159-4cae-940d-bc40ef1fea6c.jpeg',
		),
		'why_choose' => array(
			'label'   => esc_html__( 'Why Choose Us Image', 'robo' ),
			'default' => 'https://app.roboscaler.com/wp-content/uploads/2026/07/9c6f88b5-a841-4a75-8890-596857c33304.jpeg',
		),
		'customers'  => array(
			'label'   => esc_html__( 'Our Customers Image', 'robo' ),
			'default' => 'https://app.roboscaler.com/wp-content/uploads/2026/07/31ac61f5-c79d-4f80-a904-7fcfee04a94d.jpeg',
		),
		'cta'        => array(
			'label'   => esc_html__( 'Call To Action Image', 'robo' ),
			'default' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=1200&q=80',
		),
	);

	foreach ( $about_images as $key => $img_info ) {
		$wp_customize->add_setting(
			"robo_about_{$key}_image",
			array(
				'default'           => $img_info['default'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"robo_about_{$key}_image",
				array(
					'label'       => $img_info['label'],
					'description' => $std_desc,
					'section'     => 'robo_about_page_section',
				)
			)
		);
	}

	// Auth Illustration Setting.
	$wp_customize->add_setting(
		'robo_auth_illustration_image',
		array(
			'default'           => get_template_directory_uri() . '/assets/images/robo_auth_illustration.jpg',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'robo_auth_illustration_image',
			array(
				'label'       => esc_html__( 'Auth / Login Page Illustration Image', 'robo' ),
				'description' => $std_desc,
				'section'     => 'robo_about_page_section',
			)
		)
	);

	// ----------------------------------------------------
	// Section: Engineering Specifications Settings
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_features_section',
		array(
			'title'       => esc_html__( 'Engineering Specifications Settings', 'robo' ),
			'description' => esc_html__( 'Configure dynamic heading, description, specifications list, icons, buttons, and right card details.', 'robo' ),
			'panel'       => 'robo_options_panel',
			'priority'    => 31,
		)
	);

	// Section Badge
	$wp_customize->add_setting(
		'robo_features_badge',
		array(
			'default'           => esc_html__( 'Engineering Specifications', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_features_badge',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Section Badge Text', 'robo' ),
			'section' => 'robo_features_section',
		)
	);

	// Section Title
	$wp_customize->add_setting(
		'robo_features_title',
		array(
			'default'           => esc_html__( 'Competition-Grade Robotics & Parts Shop', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_features_title',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Section Title', 'robo' ),
			'section' => 'robo_features_section',
		)
	);

	// Section Description
	$wp_customize->add_setting(
		'robo_features_desc',
		array(
			'default'           => esc_html__( 'Our gear is designed to withstand intense conditions in combat arenas and drone flights. We provide pre-tested, high-reliability boards and parts that integrate flawlessly.', 'robo' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_features_desc',
		array(
			'type'    => 'textarea',
			'label'   => esc_html__( 'Section Subtitle / Description', 'robo' ),
			'section' => 'robo_features_section',
		)
	);

	// Right Graphic Card - Title
	$wp_customize->add_setting(
		'robo_features_card_title',
		array(
			'default'           => esc_html__( 'Robotics Hardware Standards', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_features_card_title',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Right Card Title', 'robo' ),
			'section' => 'robo_features_section',
		)
	);

	// Right Graphic Card - Description
	$wp_customize->add_setting(
		'robo_features_card_desc',
		array(
			'default'           => esc_html__( 'We carry parts built to standard specifications. Our custom sumobot kits, motors, and batteries undergo strict quality control to guarantee performance in critical situations.', 'robo' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'robo_features_card_desc',
		array(
			'type'    => 'textarea',
			'label'   => esc_html__( 'Right Card Description', 'robo' ),
			'section' => 'robo_features_section',
		)
	);

	// Right Graphic Card - Stat 1 Value & Label
	$wp_customize->add_setting(
		'robo_features_card_stat1_val',
		array(
			'default'           => '100%',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_features_card_stat1_val',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Stat 1 Value', 'robo' ),
			'section' => 'robo_features_section',
		)
	);

	$wp_customize->add_setting(
		'robo_features_card_stat1_lbl',
		array(
			'default'           => esc_html__( 'Combat Tested', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_features_card_stat1_lbl',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Stat 1 Label', 'robo' ),
			'section' => 'robo_features_section',
		)
	);

	// Right Graphic Card - Stat 2 Value & Label
	$wp_customize->add_setting(
		'robo_features_card_stat2_val',
		array(
			'default'           => 'A+ Grade',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_features_card_stat2_val',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Stat 2 Value', 'robo' ),
			'section' => 'robo_features_section',
		)
	);

	$wp_customize->add_setting(
		'robo_features_card_stat2_lbl',
		array(
			'default'           => esc_html__( 'Battery Cells', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'robo_features_card_stat2_lbl',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Stat 2 Label', 'robo' ),
			'section' => 'robo_features_section',
		)
	);

	// Specification Items Customizer Settings (Loop 1 to 6)
	$spec_defaults = array(
		1 => array(
			'title' => esc_html__( 'High-Torque Motors', 'robo' ),
			'desc'  => esc_html__( 'Micro-metal gearmotors and high-performance brushless motor solutions.', 'robo' ),
			'icon'  => 'bi-gear-fill',
		),
		2 => array(
			'title' => esc_html__( 'Robust Controller Boards', 'robo' ),
			'desc'  => esc_html__( 'ESP32 development boards, dual motor drivers, and telemetry circuits.', 'robo' ),
			'icon'  => 'bi-cpu',
		),
		3 => array(
			'title' => esc_html__( 'LiPo Battery Power', 'robo' ),
			'desc'  => esc_html__( 'High discharge C-rating lithium-polymer batteries for robot combat.', 'robo' ),
			'icon'  => 'bi-lightning-charge-fill',
		),
		4 => array(
			'title' => esc_html__( 'Precision Sensors', 'robo' ),
			'desc'  => esc_html__( 'Infrared distance sensors, ultrasonic modules, and line trackers.', 'robo' ),
			'icon'  => 'bi-radar',
		),
	);

	for ( $i = 1; $i <= 6; $i++ ) {
		$def_title = isset( $spec_defaults[ $i ]['title'] ) ? $spec_defaults[ $i ]['title'] : '';
		$def_desc  = isset( $spec_defaults[ $i ]['desc'] ) ? $spec_defaults[ $i ]['desc'] : '';
		$def_icon  = isset( $spec_defaults[ $i ]['icon'] ) ? $spec_defaults[ $i ]['icon'] : '';

		// Item Icon
		$wp_customize->add_setting(
			"robo_spec_item_{$i}_icon",
			array(
				'default'           => $def_icon,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_spec_item_{$i}_icon",
			array(
				'type'        => 'text',
				'label'       => sprintf( esc_html__( 'Specification %d - Icon (Class/SVG/URL)', 'robo' ), $i ),
				'description' => esc_html__( 'Enter a Font Awesome class (fa-solid fa-gear), Bootstrap Icon class (bi-gear-fill), SVG code, or Image URL.', 'robo' ),
				'section'     => 'robo_features_section',
			)
		);

		// Item Title
		$wp_customize->add_setting(
			"robo_spec_item_{$i}_title",
			array(
				'default'           => $def_title,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_spec_item_{$i}_title",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Specification %d - Title', 'robo' ), $i ),
				'section' => 'robo_features_section',
			)
		);

		// Item Description
		$wp_customize->add_setting(
			"robo_spec_item_{$i}_desc",
			array(
				'default'           => $def_desc,
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);
		$wp_customize->add_control(
			"robo_spec_item_{$i}_desc",
			array(
				'type'    => 'textarea',
				'label'   => sprintf( esc_html__( 'Specification %d - Description', 'robo' ), $i ),
				'section' => 'robo_features_section',
			)
		);

		// Item Optional Value/Number
		$wp_customize->add_setting(
			"robo_spec_item_{$i}_value",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_spec_item_{$i}_value",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Specification %d - Optional Number / Value', 'robo' ), $i ),
				'section' => 'robo_features_section',
			)
		);

		// Item Button Text
		$wp_customize->add_setting(
			"robo_spec_item_{$i}_btn_text",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_spec_item_{$i}_btn_text",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Specification %d - Button Text (Optional)', 'robo' ), $i ),
				'section' => 'robo_features_section',
			)
		);

		// Item Button URL
		$wp_customize->add_setting(
			"robo_spec_item_{$i}_btn_url",
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"robo_spec_item_{$i}_btn_url",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Specification %d - Button URL (Optional)', 'robo' ), $i ),
				'section' => 'robo_features_section',
			)
		);
	}

	// ----------------------------------------------------
	// Section: Team Section Settings
	// ----------------------------------------------------
	$wp_customize->add_section(
		'robo_team_section',
		array(
			'title'       => esc_html__( 'Team Section Settings', 'robo' ),
			'description' => esc_html__( 'Configure dynamic team section header, member details, images, contact info, and social links.', 'robo' ),
			'panel'       => 'robo_options_panel',
			'priority'    => 33,
		)
	);

	// Team Section Header settings
	$wp_customize->add_setting(
		'robo_team_section_badge',
		array(
			'default'           => esc_html__( 'Our Experts', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_team_section_badge',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Section Badge Text', 'robo' ),
			'section' => 'robo_team_section',
		)
	);

	$wp_customize->add_setting(
		'robo_team_section_title',
		array(
			'default'           => esc_html__( 'Meet the Team', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_team_section_title',
		array(
			'type'    => 'text',
			'label'   => esc_html__( 'Section Title', 'robo' ),
			'section' => 'robo_team_section',
		)
	);

	$wp_customize->add_setting(
		'robo_team_section_desc',
		array(
			'default'           => esc_html__( 'A collaborative group of creative thinkers, combat robotics engineers, and hardware specialists.', 'robo' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'robo_team_section_desc',
		array(
			'type'    => 'textarea',
			'label'   => esc_html__( 'Section Description', 'robo' ),
			'section' => 'robo_team_section',
		)
	);

	// Team Members Settings
	for ( $i = 1; $i <= 3; $i++ ) {
		$member_def = function_exists( 'robo_get_team_member_data' ) ? robo_get_team_member_data( $i ) : array();

		// Profile Image
		$wp_customize->add_setting(
			"robo_team_member_{$i}_image",
			array(
				'default'           => isset( $member_def['image'] ) ? $member_def['image'] : '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"robo_team_member_{$i}_image",
				array(
					'label'   => sprintf( esc_html__( 'Member %d - Profile Image', 'robo' ), $i ),
					'section' => 'robo_team_section',
				)
			)
		);

		// Full Name
		$wp_customize->add_setting(
			"robo_team_member_{$i}_name",
			array(
				'default'           => isset( $member_def['name'] ) ? $member_def['name'] : '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_team_member_{$i}_name",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Member %d - Full Name', 'robo' ), $i ),
				'section' => 'robo_team_section',
			)
		);

		// Designation
		$wp_customize->add_setting(
			"robo_team_member_{$i}_designation",
			array(
				'default'           => isset( $member_def['designation'] ) ? $member_def['designation'] : '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_team_member_{$i}_designation",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Member %d - Designation', 'robo' ), $i ),
				'section' => 'robo_team_section',
			)
		);

		// Short Description/Bio
		$wp_customize->add_setting(
			"robo_team_member_{$i}_desc",
			array(
				'default'           => isset( $member_def['desc'] ) ? $member_def['desc'] : '',
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);
		$wp_customize->add_control(
			"robo_team_member_{$i}_desc",
			array(
				'type'    => 'textarea',
				'label'   => sprintf( esc_html__( 'Member %d - Short Description/Bio', 'robo' ), $i ),
				'section' => 'robo_team_section',
			)
		);

		// Email
		$wp_customize->add_setting(
			"robo_team_member_{$i}_email",
			array(
				'default'           => isset( $member_def['email'] ) ? $member_def['email'] : '',
				'sanitize_callback' => 'sanitize_email',
			)
		);
		$wp_customize->add_control(
			"robo_team_member_{$i}_email",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Member %d - Email (Optional)', 'robo' ), $i ),
				'section' => 'robo_team_section',
			)
		);

		// Phone
		$wp_customize->add_setting(
			"robo_team_member_{$i}_phone",
			array(
				'default'           => isset( $member_def['phone'] ) ? $member_def['phone'] : '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"robo_team_member_{$i}_phone",
			array(
				'type'    => 'text',
				'label'   => sprintf( esc_html__( 'Member %d - Phone (Optional)', 'robo' ), $i ),
				'section' => 'robo_team_section',
			)
		);

		// Social URLs
		$social_fields = array(
			'facebook'  => esc_html__( 'Facebook URL', 'robo' ),
			'instagram' => esc_html__( 'Instagram URL', 'robo' ),
			'linkedin'  => esc_html__( 'LinkedIn URL', 'robo' ),
			'twitter'   => esc_html__( 'Twitter (X) URL', 'robo' ),
			'youtube'   => esc_html__( 'YouTube URL', 'robo' ),
			'github'    => esc_html__( 'GitHub URL', 'robo' ),
			'website'   => esc_html__( 'Website URL', 'robo' ),
		);

		foreach ( $social_fields as $s_key => $s_label ) {
			$wp_customize->add_setting(
				"robo_team_member_{$i}_{$s_key}",
				array(
					'default'           => isset( $member_def[ $s_key ] ) ? $member_def[ $s_key ] : '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				"robo_team_member_{$i}_{$s_key}",
				array(
					'type'    => 'text',
					'label'   => sprintf( esc_html__( 'Member %d - %s', 'robo' ), $i, $s_label ),
					'section' => 'robo_team_section',
				)
			);
		}
	}

	// Testimonial User Images.
	for ( $i = 1; $i <= 3; $i++ ) {
		$wp_customize->add_setting(
			"robo_testimonial_{$i}_image",
			array(
				'default'           => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=200&q=80',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"robo_testimonial_{$i}_image",
				array(
					'label'       => sprintf( esc_html__( 'Testimonial %d User Photo Avatar', 'robo' ), $i ),
					'description' => $std_desc,
					'section'     => 'robo_about_page_section',
				)
			)
		);
	}
}
add_action( 'customize_register', 'robo_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function robo_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site description for the selective refresh partial.
 *
 * @return void
 */
function robo_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Sanitize select inputs.
 *
 * @param string $input Input.
 * @param WP_Customize_Setting $setting Setting.
 * @return string
 */
function robo_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return array_key_exists( $input, $choices ) ? $input : $setting->default;
}

/**
 * Sanitize checkbox inputs.
 *
 * @param bool $checked Input.
 * @return bool
 */
function robo_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === (bool) $checked );
}

/**
 * Sanitize float / range inputs between 0 and 1.
 *
 * @param float|string $input Input.
 * @return float
 */
function robo_sanitize_float( $input ) {
	$val = floatval( $input );
	return ( $val >= 0 && $val <= 1 ) ? $val : 0.3;
}

/**
 * Add customizer dynamic CSS to head.
 */
function robo_customizer_css() {
	$primary_color = get_theme_mod( 'robo_primary_color', '#0052FF' );
	$header_bg     = get_theme_mod( 'robo_header_bg', '#ffffff' );
	$footer_bg     = get_theme_mod( 'robo_footer_bg', '#090F1d' );
	?>
	<style type="text/css">
		:root {
			--robo-primary-color: <?php echo esc_html( $primary_color ); ?>;
			--robo-primary-color-rgb: <?php echo esc_html( implode( ',', sscanf( $primary_color, "#%02x%02x%02x" ) ) ); ?>;
			--robo-header-bg: <?php echo esc_html( $header_bg ); ?>;
			--robo-footer-bg: <?php echo esc_html( $footer_bg ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'robo_customizer_css' );
