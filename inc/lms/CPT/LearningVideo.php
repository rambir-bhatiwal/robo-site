<?php
/**
 * Learning Video CPT class.
 *
 * @package Robo\LMS\CPT
 */

namespace Robo\LMS\CPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class LearningVideo
 */
class LearningVideo extends AbstractCPT {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->slug = 'learning-video';
		$this->icon = 'dashicons-video-alt3';
	}

	/**
	 * Initialize translatable labels.
	 */
	protected function init_labels(): void {
		$this->singular  = __( 'Learning Video', 'robo' );
		$this->plural    = __( 'Learning Videos', 'robo' );
		$this->menu_name = __( 'Learning Videos', 'robo' );
	}
}
