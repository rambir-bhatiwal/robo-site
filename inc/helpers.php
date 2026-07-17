<?php
/**
 * Theme helper functions.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'robo_get_reading_time' ) ) {
	/**
	 * Calculate estimated reading time for a post.
	 *
	 * @param int|null $post_id Post ID.
	 * @return string Estimated reading time.
	 */
	function robo_get_reading_time( $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		
		$content = get_post_field( 'post_content', $post_id );
		$word_count = str_word_count( strip_tags( $content ) );
		
		// Average reading speed: 200 words per minute.
		$reading_time = ceil( $word_count / 200 );
		
		if ( $reading_time <= 1 ) {
			return esc_html__( '1 min read', 'robo' );
		}
		
		return sprintf( esc_html__( '%d mins read', 'robo' ), $reading_time );
	}
}

if ( ! function_exists( 'robo_track_post_views' ) ) {
	/**
	 * Track and increment post views.
	 *
	 * @param int $post_id Post ID.
	 */
	function robo_track_post_views( $post_id ) {
		if ( ! is_single() || empty( $post_id ) ) {
			return;
		}

		$count_key = 'robo_post_views_count';
		$count     = get_post_meta( $post_id, $count_key, true );
		if ( '' === $count ) {
			$count = 0;
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '1' );
		} else {
			$count++;
			update_post_meta( $post_id, $count_key, $count );
		}
	}
}

if ( ! function_exists( 'robo_get_post_views' ) ) {
	/**
	 * Get the total number of views for a post.
	 *
	 * @param int|null $post_id Post ID.
	 * @return string Post views count.
	 */
	function robo_get_post_views( $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		
		$count_key = 'robo_post_views_count';
		$count     = get_post_meta( $post_id, $count_key, true );
		if ( '' === $count ) {
			return esc_html__( '0 Views', 'robo' );
		}
		
		if ( 1 === (int) $count ) {
			return esc_html__( '1 View', 'robo' );
		}
		
		return sprintf( esc_html__( '%s Views', 'robo' ), number_format_i18n( $count ) );
	}
}

if ( ! function_exists( 'robo_custom_excerpt_length' ) ) {
	/**
	 * Filter post excerpt length.
	 *
	 * @param int $length Excerpt length.
	 * @return int
	 */
	function robo_custom_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}
		return 25; // Custom default length.
	}
	add_filter( 'excerpt_length', 'robo_custom_excerpt_length', 999 );
}

if ( ! function_exists( 'robo_excerpt_more' ) ) {
	/**
	 * Replace the excerpt more [...] with a read more link.
	 *
	 * @param string $more Current more string.
	 * @return string
	 */
	function robo_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}
		return '...';
	}
	add_filter( 'excerpt_more', 'robo_excerpt_more' );
}

if ( ! function_exists( 'robo_get_svg' ) ) {
	/**
	 * Get SVG icon markup helper.
	 *
	 * @param string $icon Name of the icon.
	 * @param string $classes Custom classes to append.
	 * @return string SVG raw markup.
	 */
	function robo_get_svg( $icon, $classes = '' ) {
		$icons = array(
			'search'    => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg>',
			'phone'     => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.601 17.6 17.6 0 0 0 6.61 4.169c.596.211 1.284.03 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58z"/></svg>',
			'whatsapp'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/></svg>',
			'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/></svg>',
			'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.6.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/></svg>',
			'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04 1.169.222 1.757.42 2.268a3.9 3.9 0 0 0 .923 1.417 3.9 3.9 0 0 0 1.417.923c.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.417-.923 3.9 3.9 0 0 0 .923-1.417c.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/></svg>',
			'linkedin'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/></svg>',
			'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.104 1.981-.011.103-.021.2-.032.298a1.4 1.4 0 0 1-.031.104 2.01 2.01 0 0 1-1.415 1.419c-1.12.301-5.282.332-6.11.335h-.09c-.822-.003-4.987-.033-6.11-.335a2.01 2.01 0 0 1-1.415-1.42A7.7 7.7 0 0 1 .05 8.847l-.008-.104-.022-.26-.008-.104A35 35 0 0 1 0 6.586v-.075c.001-.194.01-1.108.104-1.981.011-.103.021-.2.032-.298a1.4 1.4 0 0 1 .031-.104A2.01 2.01 0 0 1 1.583 2.3c1.12-.302 5.282-.335 6.11-.335M6.5 5.5v5l4.25-2.5z"/></svg>',
			'arrow-up'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/></svg>',
		);

		return isset( $icons[ $icon ] ) ? $icons[ $icon ] : '';
	}
}

if ( ! function_exists( 'robo_date_format' ) ) {
	/**
	 * Get formatted date.
	 *
	 * @return string Formatted date string.
	 */
	function robo_date_format() {
		return get_the_date();
	}
}

if ( ! function_exists( 'robo_get_product_search_form' ) ) {
	/**
	 * Safely retrieve or display the product search form.
	 * Falls back to standard search form if WooCommerce is not active.
	 *
	 * @param bool $echo Whether to echo the form or return it.
	 * @return string Search form HTML.
	 */
	function robo_get_product_search_form( $echo = false ) {
		if ( class_exists( 'WooCommerce' ) && function_exists( 'get_product_search_form' ) ) {
			return get_product_search_form( $echo );
		}

		if ( $echo ) {
			get_search_form();
		} else {
			return get_search_form( false );
		}
	}
}

if ( ! function_exists( 'robo_get_company_info' ) ) {
	/**
	 * Get centralized company information.
	 *
	 * @param string $key Field key to retrieve.
	 * @return string|array Company details.
	 */
	function robo_get_company_info( $key = '' ) {
		$info = array(
			'name'            => get_theme_mod( 'robo_company_name', 'RoboScaler' ),
			'address'         => get_theme_mod( 'robo_company_address', '100 Robotics Way, Austin, TX 78701' ),
			'maps_url'        => get_theme_mod( 'robo_company_maps_url', 'https://maps.google.com/?q=100+Robotics+Way,+Austin,+TX+78701' ),
			'support_email'   => get_theme_mod( 'robo_company_email', 'roboscaler@gmail.com' ),
			'contact_email'   => get_theme_mod( 'robo_company_email_gen', 'roboscaler@gmail.com' ),
			'phone_number'    => get_theme_mod( 'robo_company_phone', '+91 80768 87675' ),
			'whatsapp_number' => get_theme_mod( 'robo_company_phone', '+91 80768 87675' ),
			'whatsapp_url'    => get_theme_mod( 'robo_social_whatsapp', 'https://wa.me/918076887675' ),
			'instagram_name'  => '@roboscaler',
			'instagram_url'   => get_theme_mod( 'robo_social_instagram', 'https://www.instagram.com/roboscaler?igsh=MXRvdTV5aHdqamFvMQ==' ),
			'youtube_name'    => 'RoboScaler',
			'youtube_url'     => get_theme_mod( 'robo_social_youtube', 'https://youtube.com/@roboscaler?si=xkVvD4g4WzZ4YSpD' ),
		);

		if ( ! empty( $key ) ) {
			return isset( $info[ $key ] ) ? $info[ $key ] : '';
		}

		return $info;
	}
}

