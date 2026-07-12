<?php
/**
 * Template part for displaying the Hero section.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bg_image      = get_theme_mod( 'robo_hero_bg_image' );
$title         = get_theme_mod( 'robo_hero_title', esc_html__( 'Build Smarter Digital Experiences with Robo', 'robo' ) );
$subtitle      = get_theme_mod( 'robo_hero_subtitle', esc_html__( 'Robo is a 100% custom-designed WordPress theme using Bootstrap 5 to launch elegant, clean websites fast.', 'robo' ) );
$btn1_text     = get_theme_mod( 'robo_hero_btn1_text', esc_html__( 'Get Started', 'robo' ) );
$btn1_url      = get_theme_mod( 'robo_hero_btn1_url', '#contact' );
$btn2_text     = get_theme_mod( 'robo_hero_btn2_text', esc_html__( 'Learn More', 'robo' ) );
$btn2_url      = get_theme_mod( 'robo_hero_btn2_url', '#about' );

$hero_style = '';
if ( ! empty( $bg_image ) ) {
	$hero_style = 'style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 27, 75, 0.95) 100%), url(\'' . esc_url( $bg_image ) . '\') no-repeat center center/cover;"';
} else {
	$hero_style = 'style="background: linear-gradient(135deg, #090F1d 0%, #002266 100%);"';
}

$container_class = get_theme_mod( 'robo_container_width', 'container' );
?>



<section id="hero" class="py-5  my-5 bg-white bg-opacity-10 border-bottom border-white border-opacity-10">
    <div class="<?php echo esc_attr( $container_class ); ?>">
        <div class="row align-items-center min-vh-75">

            <!-- Left Content -->
            <div class="col-lg-6">

                <h1 class="display-2 fw-bold text-primary mb-4">
                    Mini Sumo <br> Robot
                </h1>

                <p class="lead text-dark mb-5">
                    <!-- Build • Code • Compete —
                    Your journey into robotics starts here. -->

                    Design, Build, Code & Compete with high-performance Mini Sumo robots. Everything you need to start your robotics journey.
                </p>

                <a href="<?php echo esc_url( $btn1_url ); ?>" class="btn btn-warning btn-lg rounded-pill px-5 py-3 fw-bold">
                    <!-- Make a Website -->
                     Explore Robots
                </a>

            </div>

            <!-- Right Image -->
            <div class="col-lg-6 text-center">

                <img
                    src="https://roboscaler.com/wp-content/uploads/2026/07/ChatGPT-Image-Mar-13-2026-02_28_53-PM-3.png"
                    class="img-fluid"
                    alt="Mini Sumo Robot">

            </div>

        </div>
    </div>
</section>




<section id="hero" class="py-5  my-5 bg-white bg-opacity-10 border-bottom border-white border-opacity-10">
    <div class="<?php echo esc_attr( $container_class ); ?>">
        <div class="row align-items-center min-vh-75">

            <!-- Left Content -->
            <div class="col-lg-6">

                <h1 class="display-2 fw-bold text-primary mb-4">
                    Build Your First Mini Sumo Robot
                </h1>

                <p class="lead text-dark mb-5">
                    <!-- Build • Code • Compete —
                    Your journey into robotics starts here. -->

                   Learn robotics through hands-on experience. Build, program, and compete using our Mini Sumo robot kits designed for students, hobbyists, and innovators.
                </p>

                <a href="<?php echo esc_url( $btn1_url ); ?>" class="btn btn-warning btn-lg rounded-pill px-5 py-3 fw-bold">
                    <!-- Make a Website -->
                     Get Started
                </a>

            </div>

            <!-- Right Image -->
            <div class="col-lg-6 text-center">

                <img
                    src="https://roboscaler.com/wp-content/uploads/2026/07/ChatGPT-Image-Mar-13-2026-02_28_53-PM-3.png"
                    class="img-fluid"
                    alt="Mini Sumo Robot">

            </div>

        </div>
    </div>
</section>