<?php
/**
 * Learning PDF CPT class.
 *
 * @package Robo\LMS\CPT
 */

namespace Robo\LMS\CPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class LearningPdf
 */
class LearningPdf extends AbstractCPT {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->slug = 'learning-pdf';
		$this->icon = 'dashicons-media-document';
	}

	/**
	 * Initialize translatable labels.
	 */
	protected function init_labels(): void {
		$this->singular  = __( 'Learning PDF', 'robo' );
		$this->plural    = __( 'Learning PDFs', 'robo' );
		$this->menu_name = __( 'Learning PDFs', 'robo' );
	}
}
