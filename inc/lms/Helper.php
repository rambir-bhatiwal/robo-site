<?php
/**
 * Helper utilities for Robo LMS.
 *
 * @package Robo\LMS
 */

namespace Robo\LMS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Helper
 */
class Helper {

	/**
	 * Get difficulty options array.
	 *
	 * @return array<string, string>
	 */
	public static function get_difficulty_options(): array {
		return array(
			'beginner'     => __( 'Beginner', 'robo' ),
			'intermediate' => __( 'Intermediate', 'robo' ),
			'advanced'     => __( 'Advanced', 'robo' ),
		);
	}

	/**
	 * Get programming language options array.
	 *
	 * @return array<string, string>
	 */
	public static function get_language_options(): array {
		return array(
			'arduino'    => __( 'Arduino', 'robo' ),
			'c'          => __( 'C', 'robo' ),
			'cpp'        => __( 'C++', 'robo' ),
			'python'     => __( 'Python', 'robo' ),
			'java'       => __( 'Java', 'robo' ),
			'javascript' => __( 'JavaScript', 'robo' ),
			'php'        => __( 'PHP', 'robo' ),
			'other'      => __( 'Other', 'robo' ),
		);
	}

	/**
	 * Detect video provider and extract embed URL.
	 *
	 * @param string $url Video URL.
	 * @return array{provider: string, embed_url: string, video_id: string}
	 */
	public static function parse_video_url( string $url ): array {
		$url = trim( $url );
		$result = array(
			'provider'  => 'self_hosted',
			'embed_url' => $url,
			'video_id'  => '',
		);

		if ( empty( $url ) ) {
			return $result;
		}

		// YouTube match
		if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $matches ) ) {
			$result['provider']  = 'youtube';
			$result['video_id']  = $matches[1];
			$result['embed_url'] = 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0';
			return $result;
		}

		// Vimeo match
		if ( preg_match( '/vimeo\.com\/(?:.*#|.*\/)?([0-9]+)/i', $url, $matches ) ) {
			$result['provider']  = 'vimeo';
			$result['video_id']  = $matches[1];
			$result['embed_url'] = 'https://player.vimeo.com/video/' . $matches[1];
			return $result;
		}

		return $result;
	}

	/**
	 * Render responsive video embed HTML.
	 *
	 * @param string $url Video URL.
	 * @param string $title Video Title.
	 * @return string HTML output.
	 */
	public static function render_video_embed( string $url, string $title = '' ): string {
		if ( empty( $url ) ) {
			return '';
		}

		$parsed = self::parse_video_url( $url );

		if ( 'youtube' === $parsed['provider'] || 'vimeo' === $parsed['provider'] ) {
			return sprintf(
				'<div class="ratio ratio-16x9 rounded shadow-sm overflow-hidden mb-3">
					<iframe src="%s" title="%s" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>',
				esc_url( $parsed['embed_url'] ),
				esc_attr( $title )
			);
		}

		// Self hosted MP4 or HTML5 video
		return sprintf(
			'<div class="ratio ratio-16x9 rounded shadow-sm overflow-hidden mb-3">
				<video controls preload="metadata">
					<source src="%s" type="video/mp4">
					%s
				</video>
			</div>',
			esc_url( $url ),
			esc_html__( 'Your browser does not support the video tag.', 'robo' )
		);
	}

	/**
	 * Detect code repository provider.
	 *
	 * @param string $url Repository URL.
	 * @return array{provider: string, label: string, icon: string, badge_class: string}
	 */
	public static function parse_repo_url( string $url ): array {
		$url_lower = strtolower( trim( $url ) );

		if ( str_contains( $url_lower, 'github.com' ) ) {
			return array(
				'provider'    => 'github',
				'label'       => 'GitHub',
				'icon'        => 'dashicons-code-standards',
				'badge_class' => 'bg-dark text-white',
			);
		}

		if ( str_contains( $url_lower, 'gitlab.com' ) ) {
			return array(
				'provider'    => 'gitlab',
				'label'       => 'GitLab',
				'icon'        => 'dashicons-editor-code',
				'badge_class' => 'bg-warning text-dark',
			);
		}

		if ( str_contains( $url_lower, 'bitbucket.org' ) ) {
			return array(
				'provider'    => 'bitbucket',
				'label'       => 'Bitbucket',
				'icon'        => 'dashicons-cloud',
				'badge_class' => 'bg-primary text-white',
			);
		}

		return array(
			'provider'    => 'repository',
			'label'       => __( 'Repository', 'robo' ),
			'icon'        => 'dashicons-admin-links',
			'badge_class' => 'bg-secondary text-white',
		);
	}

	/**
	 * Render Repository Badge / Button.
	 *
	 * @param string $url Repository URL.
	 * @return string HTML button/link.
	 */
	public static function render_repo_button( string $url ): string {
		if ( empty( $url ) ) {
			return '';
		}

		$repo = self::parse_repo_url( $url );

		return sprintf(
			'<a href="%s" target="_blank" rel="noopener noreferrer" class="btn btn-sm %s d-inline-flex align-items-center gap-1 shadow-sm">
				<span class="dashicons %s"></span> %s
			</a>',
			esc_url( $url ),
			esc_attr( $repo['badge_class'] ),
			esc_attr( $repo['icon'] ),
			sprintf( esc_html__( 'View on %s', 'robo' ), esc_html( $repo['label'] ) )
		);
	}

	/**
	 * Sanitize repeater rows array.
	 *
	 * @param array  $input Raw POST data.
	 * @param string $cpt_slug Post type slug.
	 * @return array Sanitized array of items.
	 */
	public static function sanitize_repeater_data( array $input, string $cpt_slug ): array {
		$sanitized = array();

		if ( empty( $input ) || ! is_array( $input ) ) {
			return $sanitized;
		}

		foreach ( $input as $index => $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}

			$item = array();
			$item['order'] = isset( $row['order'] ) ? absint( $row['order'] ) : (int) $index;

			switch ( $cpt_slug ) {
				case 'learning-pdf':
					$item['title']       = isset( $row['title'] ) ? sanitize_text_field( $row['title'] ) : '';
					$item['description'] = isset( $row['description'] ) ? sanitize_textarea_field( $row['description'] ) : '';
					$item['file_id']     = isset( $row['file_id'] ) ? absint( $row['file_id'] ) : 0;
					$item['file_url']    = isset( $row['file_url'] ) ? esc_url_raw( $row['file_url'] ) : '';
					$item['preview_id']  = isset( $row['preview_id'] ) ? absint( $row['preview_id'] ) : 0;
					$item['preview_url'] = isset( $row['preview_url'] ) ? esc_url_raw( $row['preview_url'] ) : '';
					$item['button_text'] = isset( $row['button_text'] ) && '' !== trim( $row['button_text'] )
						? sanitize_text_field( $row['button_text'] )
						: __( 'Download PDF', 'robo' );
					break;

				case 'learning-code':
					$item['title']       = isset( $row['title'] ) ? sanitize_text_field( $row['title'] ) : '';
					$item['description'] = isset( $row['description'] ) ? sanitize_textarea_field( $row['description'] ) : '';
					$item['repo_url']    = isset( $row['repo_url'] ) ? esc_url_raw( $row['repo_url'] ) : '';
					$item['file_id']     = isset( $row['file_id'] ) ? absint( $row['file_id'] ) : 0;
					$item['file_url']    = isset( $row['file_url'] ) ? esc_url_raw( $row['file_url'] ) : '';
					$item['preview_id']  = isset( $row['preview_id'] ) ? absint( $row['preview_id'] ) : 0;
					$item['preview_url'] = isset( $row['preview_url'] ) ? esc_url_raw( $row['preview_url'] ) : '';
					$item['language']    = isset( $row['language'] ) ? sanitize_key( $row['language'] ) : 'other';
					break;

				case 'learning-video':
					$item['title']        = isset( $row['title'] ) ? sanitize_text_field( $row['title'] ) : '';
					$item['description']  = isset( $row['description'] ) ? sanitize_textarea_field( $row['description'] ) : '';
					$item['video_url']    = isset( $row['video_url'] ) ? esc_url_raw( $row['video_url'] ) : '';
					$item['thumbnail_id'] = isset( $row['thumbnail_id'] ) ? absint( $row['thumbnail_id'] ) : 0;
					$item['thumbnail_url']= isset( $row['thumbnail_url'] ) ? esc_url_raw( $row['thumbnail_url'] ) : '';
					$item['duration']     = isset( $row['duration'] ) ? sanitize_text_field( $row['duration'] ) : '';
					break;
			}

			$sanitized[] = $item;
		}

		// Sort by order
		usort(
			$sanitized,
			static function( $a, $b ) {
				return ( $a['order'] ?? 0 ) <=> ( $b['order'] ?? 0 );
			}
		);

		return $sanitized;
	}

	/**
	 * Sanitize array of post IDs for relationship fields.
	 *
	 * @param mixed $input Raw input.
	 * @return array<int> Clean array of post IDs.
	 */
	public static function sanitize_post_ids( $input ): array {
		if ( empty( $input ) ) {
			return array();
		}

		if ( ! is_array( $input ) ) {
			$input = explode( ',', (string) $input );
		}

		$clean = array_map( 'absint', $input );
		return array_values( array_filter( array_unique( $clean ) ) );
	}

	/**
	 * Allow additional media upload MIME types for zip, rar, pdf, mp4.
	 *
	 * @param array<string, string> $mimes Existing mime types.
	 * @return array<string, string>
	 */
	public static function add_mime_types( array $mimes ): array {
		$mimes['zip'] = 'application/zip';
		$mimes['rar'] = 'application/x-rar-compressed';
		$mimes['pdf'] = 'application/pdf';
		$mimes['mp4'] = 'video/mp4';
		return $mimes;
	}
}
