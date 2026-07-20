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

	$about_images = array(
		'hero'       => array(
			'label'   => esc_html__( 'Hero Section Image', 'robo' ),
			'default' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=1200&q=80',
		),
		'intro'      => array(
			'label'   => esc_html__( 'Welcome Introduction Image', 'robo' ),
			'default' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
		),
		'what_we_do' => array(
			'label'   => esc_html__( 'What We Do Image', 'robo' ),
			'default' => 'https://images.unsplash.com/photo-1563770660941-20978e870e26?auto=format&fit=crop&w=800&q=80',
		),
		'our_goal'   => array(
			'label'   => esc_html__( 'Our Goal Image', 'robo' ),
			'default' => 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?auto=format&fit=crop&w=800&q=80',
		),
		'why_choose' => array(
			'label'   => esc_html__( 'Why Choose Us Image', 'robo' ),
			'default' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
		),
		'customers'  => array(
			'label'   => esc_html__( 'Our Customers Image', 'robo' ),
			'default' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80',
		),
		'cta'        => array(
			'label'   => esc_html__( 'Call To Action Image', 'robo' ),
			'default' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
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
					'label'   => $img_info['label'],
					'section' => 'robo_about_page_section',
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
