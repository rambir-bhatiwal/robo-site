<?php
/**
 * Homepage V2 - Section 8: Learning Resources
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$resources = array(
	array(
		'title' => 'Open-Source Code Repositories',
		'desc' => 'Access 50+ GitHub repositories containing Python scripts, Arduino libraries, and OpenCV models.',
		'icon' => 'bi-file-code-fill',
		'tag'  => 'FREE CODE',
		'btn'  => 'Browse GitHub',
	),
	array(
		'title' => 'HD Video Assembly Manuals',
		'desc' => 'Step-by-step video playlists guiding students from unboxing to running their first robot algorithm.',
		'icon' => 'bi-youtube',
		'tag'  => 'VIDEO GUIDES',
		'btn'  => 'Watch Playlist',
	),
	array(
		'title' => 'Printable Teacher Lab Workbooks',
		'desc' => 'Complete lesson plans, student worksheets, and evaluation rubrics designed for K-12 classrooms.',
		'icon' => 'bi-file-earmark-pdf-fill',
		'tag'  => 'PDF CURRICULUM',
		'btn'  => 'Download PDFs',
	),
	array(
		'title' => 'Maker Knowledge Base & Forum',
		'desc' => 'Troubleshooting articles, pinout diagrams, and a vibrant community of maker mentors.',
		'icon' => 'bi-journal-bookmark-fill',
		'tag'  => 'DOCUMENTATION',
		'btn'  => 'Explore Docs',
	),
);
?>
<section class="robo-v2-section robo-v2-bg-light">
	<div class="container">
		<div class="text-center mb-5 fade-in-up">
			<span class="robo-v2-badge robo-v2-badge-purple mb-2">Empowering Knowledge</span>
			<h2 class="robo-v2-section-title text-dark">
				Free STEM & <span class="robo-v2-gradient-text-purple">Learning Resources</span>
			</h2>
			<p class="robo-v2-section-desc">
				Everything you need to master robotics, IoT, and AI programming. Free for students and educators.
			</p>
		</div>

		<div class="row g-4">
			<?php foreach ( $resources as $res ) : ?>
				<div class="col-md-6 col-lg-3 fade-in-up">
					<div class="robo-v2-card p-4 d-flex flex-column">
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div class="robo-v2-icon-box robo-v2-icon-box-purple mb-0">
								<i class="bi <?php echo esc_attr( $res['icon'] ); ?>"></i>
							</div>
							<span class="badge bg-light text-primary border rounded-pill small"><?php echo esc_html( $res['tag'] ); ?></span>
						</div>
						<h5 class="fw-bold fs-6 text-dark mb-2"><?php echo esc_html( $res['title'] ); ?></h5>
						<p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;"><?php echo esc_html( $res['desc'] ); ?></p>
						<a href="#resources" class="robo-v2-btn robo-v2-btn-secondary fs-6 py-2 w-100">
							<?php echo esc_html( $res['btn'] ); ?> <i class="bi bi-arrow-right ms-1"></i>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
