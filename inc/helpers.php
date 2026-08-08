<?php
/**
 * Theme helper functions.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fix for WordPress.org secure connection warning (wp_version_check / http_request_failed).
 * Resolves SSL certificate verification issues and cURL IPv6 timeouts when contacting WordPress.org APIs.
 */
if ( ! function_exists( 'robo_fix_wp_org_http_connection' ) ) {
	function robo_fix_wp_org_http_connection( $args, $url ) {
		if ( false !== strpos( $url, 'wordpress.org' ) ) {
			$args['sslverify'] = false;
		}
		return $args;
	}
	add_filter( 'http_request_args', 'robo_fix_wp_org_http_connection', 10, 2 );
}

// Force IPv4 for cURL requests to prevent IPv6 connection timeouts in Docker/servers
add_action( 'http_api_curl', function( $handle ) {
	curl_setopt( $handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
} );

if ( ! function_exists( 'robo_get_hero_bg_image_url' ) ) {
	/**
	 * Resolves raw background image Customizer input (URL string or attachment ID)
	 * to a sanitized, dynamic image URL matching the current site's scheme & domain host.
	 *
	 * @param string|int $raw_value Raw setting value (URL or attachment ID).
	 * @return string Resolved dynamic image URL or empty string.
	 */
	function robo_get_hero_bg_image_url( $raw_value ) {
		if ( empty( $raw_value ) ) {
			return '';
		}

		if ( is_numeric( $raw_value ) ) {
			$url = wp_get_attachment_image_url( (int) $raw_value, 'full' );
			return $url ? esc_url( $url ) : '';
		}

		$raw_str = (string) $raw_value;

		// Extract relative subpath if URL contains /wp-content/
		$content_pos = strpos( $raw_str, '/wp-content/' );
		if ( false !== $content_pos ) {
			$relative_path = substr( $raw_str, $content_pos + 11 );
			return esc_url( content_url( '/' . ltrim( $relative_path, '/' ) ) );
		}

		// Fallback if URL contains /uploads/ directly
		$uploads_pos = strpos( $raw_str, '/uploads/' );
		if ( false !== $uploads_pos ) {
			$relative_path = substr( $raw_str, $uploads_pos );
			$upload_dir    = wp_get_upload_dir();
			return esc_url( $upload_dir['baseurl'] . $relative_path );
		}

		return esc_url( $raw_str );
	}
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
			'github'    => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.28.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/></svg>',
			'website'   => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7.023 7.023 0 0 0-.656 2.5h2.49zM4.847 7.5c-.03.839-.047 1.679.006 2.5H1.018a7.03 7.03 0 0 0 .656 2.5h2.174c-.174-.782-.282-1.623-.312-2.5zm.352 3.5c.16.54.36 1.056.597 1.539.22.443.468.847.741 1.206A7.026 7.026 0 0 0 2.255 12h1.835c.243-.728.487-1.485.709-2.5zm2.301 3.923V12H5.145c.174.782.38 1.512.618 2.164.24.656.51 1.206.737 1.759zM8.5 1.077V4h2.355c-.237-.782-.443-1.512-.68-2.164C9.937 1.18 9.667.63 9.44.077A7.97 7.97 0 0 0 8.5 1.077zm3.41 2.923h1.835a7.025 7.025 0 0 0-3.072-2.472c.273.359.52.763.741 1.206.237.483.437.999.596 1.539zm.582 3.5h2.49a7.023 7.023 0 0 0-.656-2.5h-2.146c.174.782.282 1.623.312 2.5zm-.352 3.5c.03-.877.047-1.679-.006-2.5h3.829a7.03 7.03 0 0 0-.656-2.5h-2.174c.174.782.282 1.623.312 2.5zm-.352 3.5c-.16-.54-.36-1.056-.597-1.539a9.27 9.27 0 0 0-.741-1.206A7.026 7.026 0 0 0 13.745 12h-1.835c-.243.728-.487 1.485-.709 2.5zm-2.301 3.923V12h2.355c-.174.782-.38 1.512-.618 2.164-.24.656-.51 1.206-.737 1.759z"/></svg>',
			'globe'     => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7.023 7.023 0 0 0-.656 2.5h2.49zM4.847 7.5c-.03.839-.047 1.679.006 2.5H1.018a7.03 7.03 0 0 0 .656 2.5h2.174c-.174-.782-.282-1.623-.312-2.5zm.352 3.5c.16.54.36 1.056.597 1.539.22.443.468.847.741 1.206A7.026 7.026 0 0 0 2.255 12h1.835c.243-.728.487-1.485.709-2.5zm2.301 3.923V12H5.145c.174.782.38 1.512.618 2.164.24.656.51 1.206.737 1.759zM8.5 1.077V4h2.355c-.237-.782-.443-1.512-.68-2.164C9.937 1.18 9.667.63 9.44.077A7.97 7.97 0 0 0 8.5 1.077zm3.41 2.923h1.835a7.025 7.025 0 0 0-3.072-2.472c.273.359.52.763.741 1.206.237.483.437.999.596 1.539zm.582 3.5h2.49a7.023 7.023 0 0 0-.656-2.5h-2.146c.174.782.282 1.623.312 2.5zm-.352 3.5c.03-.877.047-1.679-.006-2.5h3.829a7.03 7.03 0 0 0-.656-2.5h-2.174c.174.782.282 1.623.312 2.5zm-.352 3.5c-.16-.54-.36-1.056-.597-1.539a9.27 9.27 0 0 0-.741-1.206A7.026 7.026 0 0 0 13.745 12h-1.835c-.243.728-.487 1.485-.709 2.5zm-2.301 3.923V12h2.355c-.174.782-.38 1.512-.618 2.164-.24.656-.51 1.206-.737 1.759z"/></svg>',
			'email'        => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-5.64L8 9.583l-1.326-.795-5.64 5.64A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/></svg>',
			'envelope'     => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-5.64L8 9.583l-1.326-.795-5.64 5.64A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/></svg>',
			'location'     => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>',
			'geo'          => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>',
			'shield-check' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.293l2.646-2.647a.5.5 0 0 1 .708 0z"/></svg>',
			'arrow-up'     => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/></svg>',
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

if ( ! function_exists( 'robo_get_about_image' ) ) {
	/**
	 * Get About Page image from customizer dynamically.
	 * Replace with a REAL stock photograph of 8th–12th grade school students wearing proper school uniforms, working on robotics, STEM, electronics, coding, or science projects. Do NOT use adults, university students, business people, or AI-generated images.
	 *
	 * @param string $key Image key.
	 * @return string Image URL.
	 */
	function robo_get_about_image( $key ) {
		$defaults = array(
			'hero'       => content_url( '/uploads/2026/07/539e0c5e-5c07-49a5-aa03-de3d6bb5cfdd-1.jpeg' ),
			'intro'      => content_url( '/uploads/2026/07/e24e5cbc-6dfd-4bf6-bba0-d90c71644b1a-e1784633711885.jpeg' ),
			'what_we_do' => content_url( '/uploads/2026/07/2eb16044-dd3d-44cc-978e-234df8077e6c.jpeg' ),
			'our_goal'   => content_url( '/uploads/2026/07/a3c7cae9-f159-4cae-940d-bc40ef1fea6c.jpeg' ),
			'why_choose' => content_url( '/uploads/2026/07/9c6f88b5-a841-4a75-8890-596857c33304.jpeg' ),
			'customers'  => content_url( '/uploads/2026/07/31ac61f5-c79d-4f80-a904-7fcfee04a94d.jpeg' ),
			'cta'        => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=1200&q=80',
		);

		$setting_name = "robo_about_{$key}_image";
		$default_url  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

		return robo_get_hero_bg_image_url( get_theme_mod( $setting_name, $default_url ) );
	}
}

if ( ! function_exists( 'robo_get_team_member_data' ) ) {
	/**
	 * Get Team member details from Customizer dynamically.
	 *
	 * @param int $index Team member index (1-based).
	 * @return array Team member details.
	 */
	function robo_get_team_member_data( $index ) {
		$defaults = array(
			1 => array(
				'name'        => __( 'Alexander Vance', 'robo' ),
				'designation' => __( 'Chief Robotics Engineer', 'robo' ),
				'desc'        => __( 'Alexander focuses on mechanical design and sumo bot chassis optimization, ensuring all steel frames meet tournament requirements.', 'robo' ),
				'image'       => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=300&q=80',
				'email'       => 'alexander@roboscaler.com',
				'phone'       => '+1 (555) 019-2834',
				'facebook'    => '',
				'twitter'     => '',
				'linkedin'    => '',
				'instagram'   => '',
				'youtube'     => '',
				'github'      => '',
				'website'     => '',
			),
			2 => array(
				'name'        => __( 'Cassandra Sterling', 'robo' ),
				'designation' => __( 'Lead Hardware Architect', 'robo' ),
				'desc'        => __( 'Cassandra leads the PCB board design and electrical safety systems, specializing in lithium battery charge regulators.', 'robo' ),
				'image'       => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=300&q=80',
				'email'       => 'cassandra@roboscaler.com',
				'phone'       => '+1 (555) 019-2835',
				'facebook'    => '',
				'twitter'     => '',
				'linkedin'    => '',
				'instagram'   => '',
				'youtube'     => '',
				'github'      => '',
				'website'     => '',
			),
			3 => array(
				'name'        => __( 'Dominic Hawke', 'robo' ),
				'designation' => __( 'Head of Embedded Systems', 'robo' ),
				'desc'        => __( 'Dominic designs firmware architectures, specializing in IR sensor tracking arrays and brushless ESC motor drivers.', 'robo' ),
				'image'       => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=300&q=80',
				'email'       => 'dominic@roboscaler.com',
				'phone'       => '+1 (555) 019-2836',
				'facebook'    => '',
				'twitter'     => '',
				'linkedin'    => '',
				'instagram'   => '',
				'youtube'     => '',
				'github'      => '',
				'website'     => '',
			),
		);

		$fallback_default = array(
			'name'        => sprintf( __( 'Team Member %d', 'robo' ), $index ),
			'designation' => __( 'Team Specialist', 'robo' ),
			'desc'        => __( 'Experienced team member passionate about robotics and innovative technology.', 'robo' ),
			'image'       => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=300&q=80',
			'email'       => '',
			'phone'       => '',
			'facebook'    => '',
			'instagram'   => '',
			'linkedin'    => '',
			'twitter'     => '',
			'youtube'     => '',
			'github'      => '',
			'website'     => '',
		);

		$default_member = isset( $defaults[ $index ] ) ? $defaults[ $index ] : $fallback_default;

		$fields = array( 'name', 'designation', 'desc', 'image', 'email', 'phone', 'facebook', 'instagram', 'linkedin', 'twitter', 'youtube', 'github', 'website' );

		$member = array();
		foreach ( $fields as $field ) {
			// Backward compatibility check for role/designation setting keys
			$setting_key = "robo_team_member_{$index}_{$field}";
			$default_val = isset( $default_member[ $field ] ) ? $default_member[ $field ] : '';
			
			$val = get_theme_mod( $setting_key, $default_val );
			if ( 'designation' === $field && empty( $val ) ) {
				$val = get_theme_mod( "robo_team_member_{$index}_role", $default_val );
			}

			if ( 'image' === $field && empty( $val ) ) {
				$val = ! empty( $default_member['image'] ) ? $default_member['image'] : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=300&q=80';
			}

			$member[ $field ] = $val;
		}

		$name_parts = explode( ' ', trim( $member['name'] ) );
		$initials   = '';
		if ( ! empty( $name_parts[0] ) ) {
			$initials .= strtoupper( substr( $name_parts[0], 0, 1 ) );
		}
		if ( count( $name_parts ) > 1 && ! empty( end( $name_parts ) ) ) {
			$initials .= strtoupper( substr( end( $name_parts ), 0, 1 ) );
		}
		$member['initials'] = $initials ? $initials : 'TM';

		return $member;
	}
}

if ( ! function_exists( 'robo_get_team_members' ) ) {
	/**
	 * Get list of all team members data.
	 *
	 * @param int $count Number of members.
	 * @return array Array of team member data arrays.
	 */
	function robo_get_team_members( $count = 3 ) {
		$members = array();
		for ( $i = 1; $i <= $count; $i++ ) {
			$members[] = robo_get_team_member_data( $i );
		}
		return $members;
	}
}

if ( ! function_exists( 'robo_get_team_image' ) ) {
	/**
	 * Get Team member photo avatar URL from customizer dynamically.
	 *
	 * @param int $index Team member index (1-based).
	 * @return string Image URL.
	 */
	function robo_get_team_image( $index ) {
		$member_data = robo_get_team_member_data( $index );
		return ! empty( $member_data['image'] ) ? $member_data['image'] : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=300&q=80';
	}
}

if ( ! function_exists( 'robo_get_testimonial_image' ) ) {
	/**
	 * Get Testimonial user photo avatar URL from customizer dynamically.
	 * Replace with a REAL stock photo avatar of an 8th–12th grade school student wearing a proper school uniform. Do NOT use adults, university students, business people, or AI-generated images.
	 *
	 * @param int $index Testimonial index (1-based).
	 * @return string Image URL.
	 */
	function robo_get_testimonial_image( $index ) {
		$defaults = array(
			1 => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=200&q=80',
			2 => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=200&q=80',
			3 => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=200&q=80',
		);

		$setting_name = "robo_testimonial_{$index}_image";
		$default_url  = isset( $defaults[ $index ] ) ? $defaults[ $index ] : '';

		return get_theme_mod( $setting_name, $default_url );
	}
}

if ( ! function_exists( 'robo_render_spec_icon' ) ) {
	/**
	 * Render dynamic specification icon (Font Awesome class, Bootstrap Icon class, SVG markup, Image URL, or default SVG).
	 *
	 * @param string $icon Icon class, SVG string, or Image URL.
	 * @param string $classes Additional CSS classes.
	 * @return string Icon HTML markup.
	 */
	function robo_render_spec_icon( $icon = '', $classes = '' ) {
		$icon = trim( (string) $icon );

		// Default SVG icon markup.
		$default_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-patch-check-fill ' . esc_attr( $classes ) . '" viewBox="0 0 16 16"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/></svg>';

		if ( empty( $icon ) ) {
			return $default_svg;
		}

		// 1. Custom SVG Markup
		if ( false !== strpos( $icon, '<svg' ) ) {
			$allowed_tags = array(
				'svg'    => array(
					'xmlns'       => array(),
					'width'       => array(),
					'height'      => array(),
					'fill'        => array(),
					'class'       => array(),
					'viewbox'     => array(),
					'style'       => array(),
					'aria-hidden' => array(),
					'role'        => array(),
				),
				'path'   => array(
					'd'         => array(),
					'fill'      => array(),
					'fill-rule' => array(),
				),
				'g'      => array(
					'fill' => array(),
				),
				'rect'   => array(
					'x'      => array(),
					'y'      => array(),
					'width'  => array(),
					'height' => array(),
					'rx'     => array(),
					'ry'     => array(),
					'fill'   => array(),
				),
				'circle' => array(
					'cx'   => array(),
					'cy'   => array(),
					'r'    => array(),
					'fill' => array(),
				),
			);
			return wp_kses( $icon, $allowed_tags );
		}

		// 2. Uploaded Image / URL
		if ( filter_var( $icon, FILTER_VALIDATE_URL ) || preg_match( '/\.(png|jpg|jpeg|gif|svg|webp)($|\?)/i', $icon ) ) {
			return sprintf(
				'<img src="%s" alt="" class="%s" style="width:20px; height:20px; object-fit:contain;" />',
				esc_url( $icon ),
				esc_attr( $classes )
			);
		}

		// 3. Icon class (Font Awesome or Bootstrap Icons)
		$icon_class = $icon;
		if ( 0 === strpos( $icon, 'bi-' ) && false === strpos( $icon, 'bi ' ) ) {
			$icon_class = 'bi ' . $icon;
		}

		$combined_classes = trim( $icon_class . ' ' . $classes );

		return sprintf( '<i class="%s"></i>', esc_attr( $combined_classes ) );
	}
}

if ( ! function_exists( 'robo_get_specifications' ) ) {
	/**
	 * Get Engineering Specifications items from Customizer dynamically.
	 *
	 * @param int $max_items Maximum items allowed.
	 * @return array Array of specification items.
	 */
	function robo_get_specifications( $max_items = 6 ) {
		$defaults = array(
			1 => array(
				'title'       => __( 'High-Torque Motors', 'robo' ),
				'description' => __( 'Micro-metal gearmotors and high-performance brushless motor solutions.', 'robo' ),
				'icon'        => 'bi-gear-fill',
				'value'       => '',
				'button_text' => '',
				'button_url'  => '',
			),
			2 => array(
				'title'       => __( 'Robust Controller Boards', 'robo' ),
				'description' => __( 'ESP32 development boards, dual motor drivers, and telemetry circuits.', 'robo' ),
				'icon'        => 'bi-cpu',
				'value'       => '',
				'button_text' => '',
				'button_url'  => '',
			),
			3 => array(
				'title'       => __( 'LiPo Battery Power', 'robo' ),
				'description' => __( 'High discharge C-rating lithium-polymer batteries for robot combat.', 'robo' ),
				'icon'        => 'bi-lightning-charge-fill',
				'value'       => '',
				'button_text' => '',
				'button_url'  => '',
			),
			4 => array(
				'title'       => __( 'Precision Sensors', 'robo' ),
				'description' => __( 'Infrared distance sensors, ultrasonic modules, and line trackers.', 'robo' ),
				'icon'        => 'bi-radar',
				'value'       => '',
				'button_text' => '',
				'button_url'  => '',
			),
		);

		$items = array();

		for ( $i = 1; $i <= $max_items; $i++ ) {
			$default_item = isset( $defaults[ $i ] ) ? $defaults[ $i ] : array();

			$title       = get_theme_mod( "robo_spec_item_{$i}_title", isset( $default_item['title'] ) ? $default_item['title'] : '' );
			$description = get_theme_mod( "robo_spec_item_{$i}_desc", isset( $default_item['description'] ) ? $default_item['description'] : '' );
			$icon        = get_theme_mod( "robo_spec_item_{$i}_icon", isset( $default_item['icon'] ) ? $default_item['icon'] : '' );
			$value       = get_theme_mod( "robo_spec_item_{$i}_value", isset( $default_item['value'] ) ? $default_item['value'] : '' );
			$button_text = get_theme_mod( "robo_spec_item_{$i}_btn_text", isset( $default_item['button_text'] ) ? $default_item['button_text'] : '' );
			$button_url  = get_theme_mod( "robo_spec_item_{$i}_btn_url", isset( $default_item['button_url'] ) ? $default_item['button_url'] : '' );

			if ( ! empty( $title ) || ! empty( $description ) ) {
				$items[] = array(
					'title'       => $title,
					'description' => $description,
					'icon'        => $icon,
					'value'       => $value,
					'button_text' => $button_text,
					'button_url'  => $button_url,
				);
			}
		}

		return $items;
	}
}

/**
 * AJAX Live Search Callback for products, posts, pages, and LMS resources.
 */
if ( ! function_exists( 'robo_product_live_search_callback' ) ) {
	function robo_product_live_search_callback() {
		$query = isset( $_GET['query'] ) ? sanitize_text_field( wp_unslash( $_GET['query'] ) ) : '';

		if ( strlen( $query ) < 2 ) {
			wp_send_json_success( array( 'products' => array(), 'view_all_url' => home_url( '/?s=' . urlencode( $query ) ) ) );
		}

		$results = array();

		// 1. If WooCommerce exists, query products first
		if ( class_exists( 'WooCommerce' ) ) {
			$args = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => 5,
				's'              => $query,
			);

			$search_query = new WP_Query( $args );

			if ( $search_query->have_posts() ) {
				while ( $search_query->have_posts() ) {
					$search_query->the_post();
					$product = wc_get_product( get_the_ID() );

					if ( ! $product ) {
						continue;
					}

					$image_id  = $product->get_image_id();
					$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : wc_placeholder_img_src( 'thumbnail' );

					$stock_label = esc_html__( 'In Stock', 'robo' );
					$stock_class = 'bg-success-subtle text-success';
					if ( ! $product->is_in_stock() ) {
						$stock_label = esc_html__( 'Out of Stock', 'robo' );
						$stock_class = 'bg-danger-subtle text-danger';
					}

					$terms    = get_the_terms( get_the_ID(), 'product_cat' );
					$category = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : esc_html__( 'Product', 'robo' );

					$results[] = array(
						'id'          => get_the_ID(),
						'title'       => get_the_title(),
						'url'         => get_permalink(),
						'image'       => $image_url,
						'price'       => $product->get_price_html(),
						'category'    => $category,
						'stock_label' => $stock_label,
						'stock_class' => $stock_class,
					);
				}
				wp_reset_postdata();
			}
		}

		// 2. If no products found or WooCommerce not active, search posts, pages & CPTs
		if ( empty( $results ) ) {
			$post_types = array( 'post', 'page' );
			if ( post_type_exists( 'learning_code' ) ) {
				$post_types[] = 'learning_code';
			}
			if ( post_type_exists( 'learning_pdf' ) ) {
				$post_types[] = 'learning_pdf';
			}
			if ( post_type_exists( 'learning_video' ) ) {
				$post_types[] = 'learning_video';
			}

			$args = array(
				'post_type'      => $post_types,
				'post_status'    => 'publish',
				'posts_per_page' => 5,
				's'              => $query,
			);

			$search_query = new WP_Query( $args );

			if ( $search_query->have_posts() ) {
				while ( $search_query->have_posts() ) {
					$search_query->the_post();
					$image_url = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
					if ( ! $image_url ) {
						$image_url = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="%236c757d" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg>';
					}

					$post_type_obj = get_post_type_object( get_post_type() );
					$category      = $post_type_obj ? $post_type_obj->labels->singular_name : esc_html__( 'Article', 'robo' );

					$results[] = array(
						'id'          => get_the_ID(),
						'title'       => get_the_title(),
						'url'         => get_permalink(),
						'image'       => $image_url,
						'price'       => '',
						'category'    => $category,
						'stock_label' => '',
						'stock_class' => '',
					);
				}
				wp_reset_postdata();
			}
		}

		$view_all_args = array( 's' => $query );
		if ( class_exists( 'WooCommerce' ) ) {
			$view_all_args['post_type'] = 'product';
		}
		$view_all_url = add_query_arg( $view_all_args, home_url( '/' ) );

		wp_send_json_success(
			array(
				'products'     => $results,
				'view_all_url' => $view_all_url,
			)
		);
	}
}
add_action( 'wp_ajax_robo_product_live_search', 'robo_product_live_search_callback' );
add_action( 'wp_ajax_nopriv_robo_product_live_search', 'robo_product_live_search_callback' );

