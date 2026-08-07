<?php
/**
 * Customer Reviews Section
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ===========================================================
| Customer Reviews Section Configuration
|============================================================
|
| enableSlider
| true  = Display cards in a responsive interactive slider.
| false = Display cards in a responsive static grid.
|
| desktopColumns, tabletColumns, mobileColumns
| Number of cards visible per device.
|
| autoplay, autoplaySpeed (in seconds), showDots, showArrows
|
=========================================================== */

$config = array(
	'enableSlider'   => true,
	'desktopColumns' => 3,
	'tabletColumns'  => 2,
	'mobileColumns'  => 1,
	'autoplay'       => true,
	'autoplaySpeed'  => 4,
	'showDots'       => true,
	'showArrows'     => true,
);

/* ==========================================================
| Customer Avatar Images (Optional Array)
|--------------------------------------------------------------------------
| Leave empty string ('') to automatically display user avatar icon.
| Add valid image URL to display customer profile picture.
|--------------------------------------------------------------------------
*/
$customer_images = array(
	'',
	'',
	'',
	'',
	'',
	'',
);

$testimonials = array(
	array(
		'name'        => __( 'Rahul Sharma', 'robo' ),
		'role'        => __( 'STEM Student', 'robo' ),
		'review'      => __( 'Excellent robotics kits with amazing quality. The tutorials made learning robotics much easier.', 'robo' ),
		'location'    => __( 'New Delhi, India', 'robo' ),
		'rating'      => 5,
		'is_verified' => true,
	),
	array(
		'name'        => __( 'Ananya Gupta', 'robo' ),
		'role'        => __( 'School Teacher', 'robo' ),
		'review'      => __( 'The products are classroom-friendly and helped our students build real robotics projects.', 'robo' ),
		'location'    => __( 'Bengaluru, India', 'robo' ),
		'rating'      => 5,
		'is_verified' => true,
	),
	array(
		'name'        => __( 'Rohit Mehta', 'robo' ),
		'role'        => __( 'Engineering Student', 'robo' ),
		'review'      => __( 'Highly recommended for anyone interested in Arduino and Robotics.', 'robo' ),
		'location'    => __( 'Mumbai, India', 'robo' ),
		'rating'      => 5,
		'is_verified' => true,
	),
	array(
		'name'        => __( 'Sneha Verma', 'robo' ),
		'role'        => __( 'Parent', 'robo' ),
		'review'      => __( 'Very satisfied with both product quality and customer support.', 'robo' ),
		'location'    => __( 'Pune, India', 'robo' ),
		'rating'      => 5,
		'is_verified' => true,
	),
	array(
		'name'        => __( 'Vikas Kumar', 'robo' ),
		'role'        => __( 'Robotics Trainer', 'robo' ),
		'review'      => __( 'One of the best online robotics stores in India.', 'robo' ),
		'location'    => __( 'Hyderabad, India', 'robo' ),
		'rating'      => 5,
		'is_verified' => true,
	),
	array(
		'name'        => __( 'Priya Singh', 'robo' ),
		'role'        => __( 'School Coordinator', 'robo' ),
		'review'      => __( 'Professional service and premium educational products.', 'robo' ),
		'location'    => __( 'Chandigarh, India', 'robo' ),
		'rating'      => 5,
		'is_verified' => true,
	),
);

$is_slider = ! empty( $config['enableSlider'] );
$config_json = wp_json_encode( $config );
?>

<section id="customer-reviews" class="robo-reviews-section" data-reviews-config="<?php echo esc_attr( $config_json ); ?>" aria-label="<?php esc_attr_e( 'Customer Reviews', 'robo' ); ?>">
	<div class="container robo-reviews-container">
		
		<!-- Section Header -->
		<div class="robo-reviews-header">
			<div class="robo-reviews-badge-wrapper">
				<span class="robo-reviews-badge">
					⭐ <?php esc_html_e( 'CUSTOMER REVIEWS', 'robo' ); ?>
				</span>
			</div>
			<h2 class="robo-reviews-heading">
				<?php esc_html_e( 'What Our Customers Say', 'robo' ); ?>
			</h2>
			<p class="robo-reviews-desc">
				<?php esc_html_e( 'Hear what students, parents, teachers, schools, and robotics enthusiasts have to say about RoboScaler products and services.', 'robo' ); ?>
			</p>
		</div>

		<!-- Content Wrapper -->
		<div class="robo-reviews-wrapper">
			
			<?php if ( $is_slider ) : ?>
				<!-- Slider Mode -->
				<?php if ( ! empty( $config['showArrows'] ) ) : ?>
					<button type="button" class="robo-reviews-nav robo-reviews-nav--prev" aria-label="<?php esc_attr_e( 'Previous Review', 'robo' ); ?>">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
					</button>

					<button type="button" class="robo-reviews-nav robo-reviews-nav--next" aria-label="<?php esc_attr_e( 'Next Review', 'robo' ); ?>">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
					</button>
				<?php endif; ?>

				<div class="robo-reviews-track-container">
					<div class="robo-reviews-track">
						<?php foreach ( $testimonials as $index => $item ) : ?>
							<?php $avatar_url = isset( $customer_images[ $index ] ) ? $customer_images[ $index ] : ''; ?>
							<div class="robo-reviews-slide">
								<div class="robo-reviews-card">
									<span class="robo-reviews-quote-icon" aria-hidden="true">“</span>
									
									<div class="robo-reviews-top">
										<div class="robo-reviews-stars" aria-label="<?php esc_attr_e( '5 out of 5 stars', 'robo' ); ?>">
											★★★★★
										</div>
										<?php if ( ! empty( $item['is_verified'] ) ) : ?>
											<span class="robo-reviews-verified">
												✓ <?php esc_html_e( 'Verified Customer', 'robo' ); ?>
											</span>
										<?php endif; ?>
									</div>

									<p class="robo-reviews-text">
										"<?php echo esc_html( $item['review'] ); ?>"
									</p>

									<div class="robo-reviews-footer">
										<div class="robo-reviews-avatar">
											<?php if ( ! empty( $avatar_url ) ) : ?>
												<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" loading="lazy" />
											<?php else : ?>
												<i class="bi bi-person-fill robo-reviews-avatar-icon" aria-hidden="true"></i>
											<?php endif; ?>
										</div>
										<div class="robo-reviews-author-meta">
											<span class="robo-reviews-name">
												<?php echo esc_html( $item['name'] ); ?>
											</span>
											<span class="robo-reviews-role">
												<?php echo esc_html( $item['role'] ); ?>
											</span>
											<?php if ( ! empty( $item['location'] ) ) : ?>
												<span class="robo-reviews-location">
													<?php echo esc_html( $item['location'] ); ?>
												</span>
											<?php endif; ?>
										</div>
									</div>

								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<?php if ( ! empty( $config['showDots'] ) ) : ?>
					<div class="robo-reviews-dots" role="tablist" aria-label="<?php esc_attr_e( 'Testimonial Dots', 'robo' ); ?>"></div>
				<?php endif; ?>

			<?php else : ?>
				<!-- Grid Mode -->
				<div class="robo-reviews-grid">
					<?php foreach ( $testimonials as $index => $item ) : ?>
						<?php $avatar_url = isset( $customer_images[ $index ] ) ? $customer_images[ $index ] : ''; ?>
						<div class="robo-reviews-card">
							<span class="robo-reviews-quote-icon" aria-hidden="true">“</span>
							
							<div class="robo-reviews-top">
								<div class="robo-reviews-stars" aria-label="<?php esc_attr_e( '5 out of 5 stars', 'robo' ); ?>">
									★★★★★
								</div>
								<?php if ( ! empty( $item['is_verified'] ) ) : ?>
									<span class="robo-reviews-verified">
										✓ <?php esc_html_e( 'Verified Customer', 'robo' ); ?>
									</span>
								<?php endif; ?>
							</div>

							<p class="robo-reviews-text">
								"<?php echo esc_html( $item['review'] ); ?>"
							</p>

							<div class="robo-reviews-footer">
								<div class="robo-reviews-avatar">
									<?php if ( ! empty( $avatar_url ) ) : ?>
										<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" loading="lazy" />
									<?php else : ?>
										<i class="bi bi-person-fill robo-reviews-avatar-icon" aria-hidden="true"></i>
									<?php endif; ?>
								</div>
								<div class="robo-reviews-author-meta">
									<span class="robo-reviews-name">
										<?php echo esc_html( $item['name'] ); ?>
									</span>
									<span class="robo-reviews-role">
										<?php echo esc_html( $item['role'] ); ?>
									</span>
									<?php if ( ! empty( $item['location'] ) ) : ?>
										<span class="robo-reviews-location">
											<?php echo esc_html( $item['location'] ); ?>
										</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>

	</div>
</section>
