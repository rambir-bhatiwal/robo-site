<?php
/**
 * Homepage V2 - Section 6: AI & Robotics Learning Section
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section id="learning-section" class="robo-v2-section robo-v2-bg-gradient text-white position-relative py-5">
	<div class="container py-lg-4">
		<div class="row align-items-center g-5">
			<!-- Left Side: Interactive Code Simulator Preview -->
			<div class="col-lg-6 fade-in-left">
				<div class="robo-v2-card-dark rounded-4 p-4 border border-secondary border-opacity-25 shadow-lg">
					<div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom border-secondary border-opacity-25">
						<div class="d-flex align-items-center gap-2">
							<span class="bg-danger rounded-circle d-inline-block" style="width: 12px; height: 12px;"></span>
							<span class="bg-warning rounded-circle d-inline-block" style="width: 12px; height: 12px;"></span>
							<span class="bg-success rounded-circle d-inline-block" style="width: 12px; height: 12px;"></span>
							<span class="text-light opacity-50 small ms-2 font-monospace">robo_ai_vision_controller.py</span>
						</div>
						<span class="badge bg-info text-dark font-monospace">Python 3.11</span>
					</div>

					<pre class="font-monospace text-info mb-0" style="font-size: 0.875rem; line-height: 1.6;"><code><span class="text-secondary"># Initialize AI Camera & Microcontroller</span>
<span class="text-warning">import</span> robo_vision <span class="text-warning">as</span> rv
<span class="text-warning">import</span> motor_driver <span class="text-warning">as</span> md

camera = rv.Camera(resolution=<span class="text-light">(640, 480)</span>)
robot = md.FourWheelDrive(pin_config=<span class="text-light">"ESP32"</span>)

<span class="text-secondary"># Object Detection Loop</span>
<span class="text-warning">while</span> camera.is_active():
    target = camera.detect_target(<span class="text-light">"Red Ball"</span>)
    <span class="text-warning">if</span> target.confidence > <span class="text-light">0.85</span>:
        robot.track_object(target.x, target.y)
        <span class="text-success">print("[AI LOG]: Target Locked & Tracking")</span></code></pre>

					<div class="mt-4 pt-3 border-top border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
						<span class="text-success small d-flex align-items-center gap-2 font-monospace">
							<i class="bi bi-circle-fill text-success small"></i> Hardware Connected (ESP32-S3)
						</span>
						<span class="btn btn-sm btn-outline-light rounded-pill px-3 font-monospace">
							<i class="bi bi-play-fill text-success me-1"></i> Run Code
						</span>
					</div>
				</div>
			</div>

			<!-- Right Side: Text & Capabilities -->
			<div class="col-lg-6 fade-in-right">
				<span class="robo-v2-badge robo-v2-badge-cyan mb-2">Hands-On STEM Curriculum</span>
				<h2 class="robo-v2-section-title text-white mb-4">
					From Scratch Block Coding To <span class="robo-v2-gradient-text-blue">Real AI Models</span>
				</h2>
				<p class="text-light opacity-90 fs-5 mb-4">
					We bridge the gap between classroom theory and real-world robotics engineering. Our curriculum covers Scratch visual blocks, C++, Python, and Computer Vision.
				</p>

				<div class="row g-4">
					<div class="col-sm-6">
						<div class="d-flex gap-3">
							<div class="robo-v2-icon-box robo-v2-icon-box-cyan flex-shrink-0 mb-0">
								<i class="bi bi-code-slash"></i>
							</div>
							<div>
								<h5 class="fw-bold text-white fs-6 mb-1">Dual Programming</h5>
								<p class="small text-light opacity-75 mb-0">Block-based visual coding for beginners and Python for advanced projects.</p>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="d-flex gap-3">
							<div class="robo-v2-icon-box robo-v2-icon-box-purple flex-shrink-0 mb-0">
								<i class="bi bi-camera-reels-fill"></i>
							</div>
							<div>
								<h5 class="fw-bold text-white fs-6 mb-1">Video Tutorials</h5>
								<p class="small text-light opacity-75 mb-0">Step-by-step video manuals for assembly, wiring, and debugging.</p>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="d-flex gap-3">
							<div class="robo-v2-icon-box flex-shrink-0 mb-0">
								<i class="bi bi-award-fill"></i>
							</div>
							<div>
								<h5 class="fw-bold text-white fs-6 mb-1">STEM Certification</h5>
								<p class="small text-light opacity-75 mb-0">Earn accredited completion certificates upon finishing project modules.</p>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="d-flex gap-3">
							<div class="robo-v2-icon-box robo-v2-icon-box-cyan flex-shrink-0 mb-0">
								<i class="bi bi-people-fill"></i>
							</div>
							<div>
								<h5 class="fw-bold text-white fs-6 mb-1">Maker Community</h5>
								<p class="small text-light opacity-75 mb-0">Get 24/7 help from robotics mentors and student innovators.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
