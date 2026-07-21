<?php
/**
 * Template part for displaying the Team section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );

$team_members = array(
	array(
		'name'    => esc_html__( 'Alexander Vance', 'robo' ),
		'role'    => esc_html__( 'Chief Robotics Engineer', 'robo' ),
		'initial' => 'AV',
		'desc'    => esc_html__( 'Alexander focuses on mechanical design and sumo bot chassis optimization, ensuring all steel frames meet tournament requirements.', 'robo' ),
	),
	array(
		'name'    => esc_html__( 'Cassandra Sterling', 'robo' ),
		'role'    => esc_html__( 'Lead Hardware Architect', 'robo' ),
		'initial' => 'CS',
		'desc'    => esc_html__( 'Cassandra leads the PCB board design and electrical safety systems, specializing in lithium battery charge regulators.', 'robo' ),
	),
	array(
		'name'    => esc_html__( 'Dominic Hawke', 'robo' ),
		'role'    => esc_html__( 'Head of Embedded Systems', 'robo' ),
		'initial' => 'DH',
		'desc'    => esc_html__( 'Dominic designs firmware architectures, specializing in IR sensor tracking arrays and brushless ESC motor drivers.', 'robo' ),
	),
);
?>
<section id="team" class="team-section py-5 bg-light border-top border-bottom border-light-subtle">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		
		<!-- Section Header -->
		<div class="row mb-5 justify-content-center text-center">
			<div class="col-lg-6">
				<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php esc_html_e( 'Our Experts', 'robo' ); ?></span>
				<h2 class="h1 fw-bold text-dark mb-3"><?php esc_html_e( 'Meet the Team', 'robo' ); ?></h2>
				<p class="text-muted"><?php esc_html_e( 'A collaborative group of creative thinkers, combat robotics engineers, and hardware specialists.', 'robo' ); ?></p>
			</div>
		</div>

		<!-- Team Grid -->
		<div class="row g-4">
			<?php foreach ( $team_members as $idx => $member ) : 
				$team_img = function_exists( 'robo_get_team_image' ) ? robo_get_team_image( $idx + 1 ) : '';
			?>
				<div class="col-lg-4 col-md-6">
					<div class="team-card card h-100 border-0 shadow-sm overflow-hidden text-center p-4">
						
						<!-- Avatar Block -->
						<div class="mx-auto mb-4 overflow-hidden rounded-circle shadow-sm" style="width: 120px; height: 120px;">
							<?php if ( ! empty( $team_img ) ) : ?>
								<img src="<?php echo esc_url( $team_img ); ?>" alt="<?php echo esc_attr( $member['name'] ); ?>" class="w-100 h-100 object-fit-cover">
							<?php else : ?>
								<div class="w-100 h-100 bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="font-size: 2.2rem;">
									<?php echo esc_html( $member['initial'] ); ?>
								</div>
							<?php endif; ?>
						</div>

						<h4 class="h5 fw-bold text-dark mb-1"><?php echo esc_html( $member['name'] ); ?></h4>
						<p class="text-primary small mb-3"><?php echo esc_html( $member['role'] ); ?></p>
						<p class="text-muted small mb-4"><?php echo esc_html( $member['desc'] ); ?></p>
						
						<!-- Social Profiles -->
						<div class="team-socials d-flex justify-content-center gap-3">
							<a href="#" class="text-muted hover-primary" aria-label="Facebook">
								<?php echo robo_get_svg( 'facebook', 'bi fs-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
							<a href="#" class="text-muted hover-primary" aria-label="Twitter">
								<?php echo robo_get_svg( 'twitter', 'bi fs-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
							<a href="#" class="text-muted hover-primary" aria-label="LinkedIn">
								<?php echo robo_get_svg( 'linkedin', 'bi fs-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						</div>

					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
