<?php
/**
 * Source Code CPT class.
 *
 * @package Robo\LMS\CPT
 */

namespace Robo\LMS\CPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class LearningCode
 */
class LearningCode extends AbstractCPT {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->slug = 'learning-code';
		$this->icon = 'dashicons-editor-code';
	}

	/**
	 * Initialize translatable labels.
	 */
	protected function init_labels(): void {
		$this->singular  = __( 'Source Code', 'robo' );
		$this->plural    = __( 'Source Code Library', 'robo' );
		$this->menu_name = __( 'Source Code', 'robo' );
	}
}
