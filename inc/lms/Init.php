<?php
/**
 * Main Initialization class for Robo LMS.
 *
 * @package Robo\LMS
 */

namespace Robo\LMS;

use Robo\LMS\CPT\LearningPdf;
use Robo\LMS\CPT\LearningCode;
use Robo\LMS\CPT\LearningVideo;
use Robo\LMS\Taxonomies\LearningTaxonomies;
use Robo\LMS\Admin\MetaBox;
use Robo\LMS\Admin\SaveHandler;
use Robo\LMS\Admin\Ajax;
use Robo\LMS\Frontend\Query;
use Robo\LMS\Frontend\TemplateLoader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Init
 */
final class Init {

	/**
	 * Single instance of Init.
	 *
	 * @var Init|null
	 */
	private static ?Init $instance = null;

	/**
	 * Get singleton instance.
	 *
	 * @return Init
	 */
	public static function get_instance(): Init {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Private Constructor.
	 */
	private function __construct() {
		$this->register_autoloader();
		add_action( 'after_setup_theme', array( $this, 'init_components' ) );
	}

	/**
	 * Register PSR-4 Autoloader for Robo\LMS namespace.
	 */
	private function register_autoloader(): void {
		spl_autoload_register(
			static function ( string $class ) {
				$prefix = 'Robo\\LMS\\';
				$len    = strlen( $prefix );

				if ( 0 !== strncmp( $prefix, $class, $len ) ) {
					return;
				}

				$relative_class = substr( $class, $len );
				$file           = ROBO_THEME_DIR . '/inc/lms/' . str_replace( '\\', '/', $relative_class ) . '.php';

				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}
		);
	}

	/**
	 * Initialize all LMS components.
	 */
	public function init_components(): void {
		// 1. Custom Post Types
		( new LearningPdf() )->register();
		( new LearningCode() )->register();
		( new LearningVideo() )->register();

		// 2. Taxonomies
		( new LearningTaxonomies() )->register();

		// 3. Admin Meta Box & Save & AJAX
		( new MetaBox() )->register();
		( new SaveHandler() )->register();
		( new Ajax() )->register();

		// 4. Frontend Query & Template Loader
		( new Query() )->register();
		( new TemplateLoader() )->register();

		// 5. Allow PDF, ZIP, RAR, MP4 uploads
		add_filter( 'upload_mimes', array( Helper::class, 'add_mime_types' ) );
	}
}
