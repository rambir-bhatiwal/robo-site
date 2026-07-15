<?php
/**
 * Template Name: Source Code
 * Description: A custom page template to browse the public GitHub repository directly on the website in an IDE-style interface.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/woocommerce-banner' );

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>

<div id="primary" class="content-area py-5 bg-light-subtle">
	<main id="main" class="site-main">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			
			<div class="row g-4 justify-content-center">
				<div class="col-12">
					<div class="card border-0 shadow-sm p-4 p-md-5 bg-white rounded-3 mb-4">
						<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 border-bottom pb-4 mb-4">
							<div>
								<h2 class="fw-extrabold text-dark mb-2">
									<i class="bi bi-code-slash text-primary me-2"></i>
									<?php the_title(); ?>
								</h2>
								<p class="text-muted mb-0 max-width-600">
									<?php esc_html_e( 'Browse and explore the public GitHub repository source code directly on this page using an interactive IDE interface.', 'robo' ); ?>
								</p>
							</div>
							<div class="d-flex gap-2">
								<a href="https://github.com/rambir-bhatiwal/TTB" target="_blank" rel="noopener noreferrer" class="btn btn-primary d-inline-flex align-items-center gap-2 hover-grow">
									<i class="bi bi-github fs-5"></i>
									<span><?php esc_html_e( 'View on GitHub', 'robo' ); ?></span>
								</a>
								<a href="https://github.com/rambir-bhatiwal/TTB/archive/refs/heads/main.zip" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 hover-grow rounded-pill px-4">
									<i class="bi bi-download fs-5"></i>
									<span><?php esc_html_e( 'Download ZIP', 'robo' ); ?></span>
								</a>
							</div>
						</div>

						<!-- IDE Iframe Viewer -->
						<div class="ide-iframe-container rounded-3 overflow-hidden border border-light-subtle shadow-sm">
							<iframe 
								src="https://github1s.com/rambir-bhatiwal/TTB" 
								title="<?php esc_attr_e( 'Robo Theme Source Code IDE', 'robo' ); ?>" 
								style="width: 100%; height: 900px; border: 0; display: block; background-color: #1e1e1e;"
								loading="lazy">
							</iframe>
						</div>
					</div>
				</div>
			</div>

		</div>
	</main>
</div>

<style type="text/css">
.hover-grow {
	transition: transform 0.25s ease-in-out, box-shadow 0.25s ease-in-out !important;
}
.hover-grow:hover {
	transform: translateY(-2px) !important;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
}
.ide-iframe-container {
	background-color: #1e1e1e;
	transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}
.ide-iframe-container:hover {
	border-color: var(--bs-primary) !important;
	box-shadow: 0 8px 30px rgba(13, 110, 253, 0.15) !important;
}
</style>

<?php
get_footer();
