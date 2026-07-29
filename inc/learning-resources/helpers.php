<?php
/**
 * Helper Functions for Learning Resources.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get Meta value helper
 */
function robo_lr_get_meta( $post_id, $key, $default = '' ) {
	$val = get_post_meta( $post_id, $key, true );
	return ( '' !== $val && false !== $val ) ? $val : $default;
}

/**
 * Calculate Reading Time in minutes based on content word count.
 *
 * @param int $post_id Post ID.
 * @return int Minutes.
 */
function robo_lr_get_reading_time( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$post = get_post( $post_id );
	if ( ! $post ) {
		return 1;
	}

	$short_desc = get_post_meta( $post_id, '_robo_lr_short_desc', true );
	$content    = strip_tags( $post->post_content . ' ' . $short_desc );
	$word_count = str_word_count( $content );

	$words_per_minute = 200;
	$reading_time     = ceil( $word_count / $words_per_minute );

	return max( 1, (int) $reading_time );
}

/**
 * Increment and Get View Count
 *
 * @param int $post_id Post ID.
 * @return int View count.
 */
function robo_lr_get_views( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$views = (int) get_post_meta( $post_id, '_robo_lr_views_count', true );
	return max( 0, $views );
}

function robo_lr_increment_views( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	// Simple session/cookie check to avoid artificial spamming per page reload
	$cookie_name = 'robo_lr_viewed_' . $post_id;
	if ( ! isset( $_COOKIE[ $cookie_name ] ) ) {
		$views = robo_lr_get_views( $post_id );
		$views++;
		update_post_meta( $post_id, '_robo_lr_views_count', $views );
		setcookie( $cookie_name, '1', time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
	}
}

/**
 * Get Likes Count
 */
function robo_lr_get_likes( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	return (int) get_post_meta( $post_id, '_robo_lr_likes_count', true );
}

/**
 * Get Download Count
 */
function robo_lr_get_downloads( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	return (int) get_post_meta( $post_id, '_robo_lr_download_count', true );
}

/**
 * Render Status Badges HTML
 *
 * @param int $post_id Post ID.
 * @return string HTML output.
 */
function robo_lr_render_badges( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$badges = array(
		'featured'    => array(
			'meta'  => '_robo_lr_badge_featured',
			'label' => __( 'Featured', 'robo' ),
			'class' => 'bg-warning text-dark',
		),
		'popular'     => array(
			'meta'  => '_robo_lr_badge_popular',
			'label' => __( 'Popular', 'robo' ),
			'class' => 'bg-danger text-white',
		),
		'recommended' => array(
			'meta'  => '_robo_lr_badge_recommended',
			'label' => __( 'Recommended', 'robo' ),
			'class' => 'bg-success text-white',
		),
		'new'         => array(
			'meta'  => '_robo_lr_badge_new',
			'label' => __( 'New', 'robo' ),
			'class' => 'bg-info text-dark',
		),
		'trending'    => array(
			'meta'  => '_robo_lr_badge_trending',
			'label' => __( 'Trending', 'robo' ),
			'class' => 'bg-primary text-white',
		),
	);

	$html = '';
	foreach ( $badges as $b_key => $b_data ) {
		if ( '1' === get_post_meta( $post_id, $b_data['meta'], true ) ) {
			$html .= sprintf( '<span class="badge %1$s me-1">%2$s</span>', esc_attr( $b_data['class'] ), esc_html( $b_data['label'] ) );
		}
	}

	return $html;
}

/**
 * Render Video Embed (YouTube, Vimeo, or HTML5 MP4)
 *
 * @param string $url Video URL.
 * @return string HTML iframe or video tag.
 */
function robo_lr_render_video_embed( $url ) {
	if ( empty( $url ) ) {
		return '';
	}

	// YouTube
	if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches ) ) {
		$video_id = $matches[1];
		return sprintf(
			'<div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm my-3">
				<iframe src="https://www.youtube.com/embed/%1$s" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>',
			esc_attr( $video_id )
		);
	}

	// Vimeo
	if ( preg_match( '/vimeo\.com\/(?:.*#|.*\/)?([0-9]+)/i', $url, $matches ) ) {
		$video_id = $matches[1];
		return sprintf(
			'<div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm my-3">
				<iframe src="https://player.vimeo.com/video/%1$s" title="Vimeo video player" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
			</div>',
			esc_attr( $video_id )
		);
	}

	// Self hosted MP4
	if ( preg_match( '/\.(mp4|webm|ogg)$/i', $url ) ) {
		return sprintf(
			'<div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm my-3">
				<video controls class="w-100 h-100">
					<source src="%1$s" type="video/mp4">
					Your browser does not support the video tag.
				</video>
			</div>',
			esc_url( $url )
		);
	}

	// Fallback to WordPress oEmbed
	$embed = wp_oembed_get( $url );
	if ( $embed ) {
		return '<div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm my-3">' . $embed . '</div>';
	}

	return sprintf( '<a href="%1$s" target="_blank" rel="noopener" class="btn btn-outline-primary"><i class="bi bi-play-circle me-1"></i> Watch Video</a>', esc_url( $url ) );
}

/**
 * Render Social Share Buttons HTML
 *
 * @param int $post_id Post ID.
 * @return string HTML.
 */
function robo_lr_render_social_share( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$permalink = get_permalink( $post_id );
	$title     = get_the_title( $post_id );

	$facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $permalink );
	$twitter_url  = 'https://twitter.com/intent/tweet?text=' . rawurlencode( $title ) . '&url=' . rawurlencode( $permalink );
	$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . rawurlencode( $permalink ) . '&title=' . rawurlencode( $title );
	$whatsapp_url = 'https://api.whatsapp.com/send?text=' . rawurlencode( $title . ' ' . $permalink );

	ob_start();
	?>
	<div class="robo-lr-share-buttons d-flex gap-2 align-items-center flex-wrap">
		<span class="fw-semibold small text-uppercase text-muted me-1"><i class="bi bi-share me-1"></i> Share:</span>
		<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-1" title="Share on Facebook"><i class="bi bi-facebook"></i></a>
		<a href="<?php echo esc_url( $twitter_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-1" title="Share on X / Twitter"><i class="bi bi-twitter-x"></i></a>
		<a href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-1" title="Share on LinkedIn"><i class="bi bi-linkedin"></i></a>
		<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-1" title="Share on WhatsApp"><i class="bi bi-whatsapp"></i></a>
		<button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 copy-link-btn" data-link="<?php echo esc_url( $permalink ); ?>"><i class="bi bi-link-45deg me-1"></i> Copy Link</button>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Output SEO Meta Tags in head for single learning resources
 */
function robo_lr_output_seo_meta_tags() {
	if ( ! is_singular( 'learning-resource' ) ) {
		return;
	}

	$post_id       = get_the_ID();
	$meta_title    = get_post_meta( $post_id, '_robo_lr_meta_title', true );
	$meta_desc     = get_post_meta( $post_id, '_robo_lr_meta_description', true );
	$og_image_id   = get_post_meta( $post_id, '_robo_lr_og_image_id', true );
	$canonical_url = get_post_meta( $post_id, '_robo_lr_canonical_url', true );

	if ( empty( $meta_title ) ) {
		$meta_title = get_the_title( $post_id ) . ' - ' . get_bloginfo( 'name' );
	}
	if ( empty( $meta_desc ) ) {
		$short_desc = get_post_meta( $post_id, '_robo_lr_short_desc', true );
		$meta_desc  = ! empty( $short_desc ) ? $short_desc : wp_trim_words( get_the_excerpt( $post_id ), 25 );
	}

	$og_image_url = '';
	if ( $og_image_id ) {
		$og_image_url = wp_get_attachment_image_url( $og_image_id, 'full' );
	} elseif ( has_post_thumbnail( $post_id ) ) {
		$og_image_url = get_the_post_thumbnail_url( $post_id, 'full' );
	}

	echo '<!-- Robo Learning Resources SEO Meta -->' . "\n";
	if ( $meta_desc ) {
		echo '<meta name="description" content="' . esc_attr( $meta_desc ) . '">' . "\n";
	}
	echo '<meta property="og:title" content="' . esc_attr( $meta_title ) . '">' . "\n";
	if ( $meta_desc ) {
		echo '<meta property="og:description" content="' . esc_attr( $meta_desc ) . '">' . "\n";
	}
	echo '<meta property="og:type" content="article">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( get_permalink( $post_id ) ) . '">' . "\n";
	if ( $og_image_url ) {
		echo '<meta property="og:image" content="' . esc_url( $og_image_url ) . '">' . "\n";
	}
	if ( $canonical_url ) {
		echo '<link rel="canonical" href="' . esc_url( $canonical_url ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'robo_lr_output_seo_meta_tags', 1 );

/**
 * Filter document title if custom meta title is set
 */
function robo_lr_filter_wp_title( $title_parts ) {
	if ( is_singular( 'learning-resource' ) ) {
		$custom_title = get_post_meta( get_the_ID(), '_robo_lr_meta_title', true );
		if ( ! empty( $custom_title ) ) {
			$title_parts['title'] = $custom_title;
		}
	}
	return $title_parts;
}
add_filter( 'document_title_parts', 'robo_lr_filter_wp_title' );
