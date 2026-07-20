<?php
/**
 * Reusable Breadcrumb Section Component.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_front_page() ) {
	return;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>
<div class="breadcrumb-section">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<?php robo_breadcrumbs(); ?>
	</div>
</div>
