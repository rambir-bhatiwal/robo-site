<?php
/**
 * Homepage V2 - Section 14: Partner Schools & Institutions
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$schools = array(
	'Delhi Public School', 'IIT Bombay Maker Lab', 'Modern School Delhi', 
	'Apex International Academy', 'St. Xavier STEM Lab', 'National Tech Institute'
);
?>
<section class="py-4 robo-v2-bg-light border-top border-bottom">
	<div class="container">
		<div class="text-center mb-3">
			<span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.1em;">Trusted By Leading Schools & Robotics Labs</span>
		</div>
		<div class="row align-items-center justify-content-center g-4 text-center">
			<?php foreach ( $schools as $sch ) : ?>
				<div class="col-6 col-md-4 col-lg-2">
					<div class="p-2 text-muted fw-bold font-monospace opacity-75 hover-primary" style="font-size: 0.875rem;">
						<i class="bi bi-building me-1 text-primary"></i> <?php echo esc_html( $sch ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
