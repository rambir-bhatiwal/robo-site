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

$team_members = function_exists( 'robo_get_team_members' ) ? robo_get_team_members( 3 ) : array();

$section_badge = get_theme_mod( 'robo_team_section_badge', __( 'Our Experts', 'robo' ) );
$section_title = get_theme_mod( 'robo_team_section_title', __( 'Meet the Team', 'robo' ) );
$section_desc  = get_theme_mod( 'robo_team_section_desc', __( 'A collaborative group of creative thinkers, combat robotics engineers, and hardware specialists.', 'robo' ) );
?>
<section id="team" class="team-section py-5 bg-light border-top border-bottom border-light-subtle">
	<div class="<?php echo esc_attr( $container_class ); ?> py-4">
		
		<!-- Section Header -->
		<div class="row mb-3 justify-content-center text-center">
			<div class="col-lg-6">
				<?php if ( ! empty( $section_badge ) ) : ?>
					<span class="text-primary text-uppercase fw-bold small tracking-wider mb-2 d-block"><?php echo esc_html( $section_badge ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $section_title ) ) : ?>
					<h2 class="h1 fw-bold text-dark mb-3"><?php echo esc_html( $section_title ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $section_desc ) ) : ?>
					<p class="text-muted"><?php echo esc_html( $section_desc ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<!-- Team Grid -->
		<div class="row g-4">
			<?php foreach ( $team_members as $idx => $member ) : 
				$team_img = ! empty( $member['image'] ) ? $member['image'] : ( function_exists( 'robo_get_team_image' ) ? robo_get_team_image( $idx + 1 ) : '' );
				
				// Map of all supported social and contact links for each member
				$social_services = array(
					'facebook'  => array( 'url' => $member['facebook'],  'label' => __( 'Facebook', 'robo' ),  'icon' => 'facebook' ),
					'twitter'   => array( 'url' => $member['twitter'],   'label' => __( 'Twitter', 'robo' ),   'icon' => 'twitter' ),
					'linkedin'  => array( 'url' => $member['linkedin'],  'label' => __( 'LinkedIn', 'robo' ),  'icon' => 'linkedin' ),
					'instagram' => array( 'url' => $member['instagram'], 'label' => __( 'Instagram', 'robo' ), 'icon' => 'instagram' ),
					'youtube'   => array( 'url' => $member['youtube'],   'label' => __( 'YouTube', 'robo' ),   'icon' => 'youtube' ),
					'github'    => array( 'url' => $member['github'],    'label' => __( 'GitHub', 'robo' ),    'icon' => 'github' ),
					'website'   => array( 'url' => $member['website'],   'label' => __( 'Website', 'robo' ),   'icon' => 'website' ),
					'email'     => array( 'url' => ! empty( $member['email'] ) ? 'mailto:' . sanitize_email( $member['email'] ) : '', 'label' => __( 'Email', 'robo' ), 'icon' => 'email' ),
					'phone'     => array( 'url' => ! empty( $member['phone'] ) ? 'tel:' . preg_replace( '/[^\d+]/', '', $member['phone'] ) : '', 'label' => __( 'Phone', 'robo' ), 'icon' => 'phone' ),
				);
			?>
				<div class="col-lg-4 col-md-6">
					<div class="team-card card h-100 border-0 shadow-sm overflow-hidden text-center p-4">
						
						<!-- Avatar Block -->
						<div class="mx-auto mb-4 overflow-hidden rounded-circle shadow-sm" style="width: 120px; height: 120px;">
							<?php if ( ! empty( $team_img ) ) : ?>
								<img src="<?php echo esc_url( $team_img ); ?>" alt="<?php echo esc_attr( $member['name'] ); ?>" class="w-100 h-100 object-fit-cover">
							<?php else : ?>
								<div class="w-100 h-100 bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="font-size: 2.2rem;">
									<?php echo esc_html( ! empty( $member['initials'] ) ? $member['initials'] : 'TM' ); ?>
								</div>
							<?php endif; ?>
						</div>
  
						<h4 class="h5 fw-bold text-dark mb-1"><?php echo esc_html( $member['name'] ); ?></h4>
						<p class="text-primary small mb-3"><?php echo esc_html( $member['designation'] ); ?></p>
						<?php if ( ! empty( $member['desc'] ) ) : ?>
							<p class="text-muted small mb-4"><?php echo esc_html( wp_trim_words( $member['desc'], 25, '...' ) ); ?></p>
						<?php endif; ?>
						
						<!-- Social Profiles -->
						<div class="team-socials d-flex justify-content-center gap-3">
							<?php foreach ( $social_services as $key => $service ) : ?>
								<?php if ( ! empty( $service['url'] ) && '#' !== trim( $service['url'] ) ) : ?>
									<a href="<?php echo esc_url( $service['url'] ); ?>" class="text-muted hover-primary" aria-label="<?php echo esc_attr( $service['label'] ); ?>"<?php echo ( 'email' !== $key && 'phone' !== $key ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
										<?php echo robo_get_svg( $service['icon'], 'bi fs-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</a>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>

					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
