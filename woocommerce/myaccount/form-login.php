<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="row g-4 align-items-stretch" id="customer_login">
	
	<!-- Left Side: Authentication Card -->
	<div class="col-12 col-lg-6 order-2 order-lg-1">
		<div class="card border-0 shadow-sm p-4 p-md-5 bg-white rounded-3 h-100">
			
			<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
				<!-- Tabbed Navigation between Login and Register -->
				<ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-4" id="authTabs" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active rounded-pill fw-bold py-2" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-pane" type="button" role="tab" aria-controls="login-pane" aria-selected="true">
							<i class="bi bi-box-arrow-in-right me-1"></i><?php esc_html_e( 'Login', 'woocommerce' ); ?>
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link rounded-pill fw-bold py-2" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-pane" type="button" role="tab" aria-controls="register-pane" aria-selected="false">
							<i class="bi bi-person-plus me-1"></i><?php esc_html_e( 'Register', 'woocommerce' ); ?>
						</button>
					</li>
				</ul>
				
				<div class="tab-content" id="authTabsContent">
					<!-- Login Pane -->
					<div class="tab-pane fade show active" id="login-pane" role="tabpanel" aria-labelledby="login-tab">
			<?php endif; ?>

						<!-- Login Form -->
						<h3 class="fw-bold text-dark mb-4 d-lg-none">
							<i class="bi bi-box-arrow-in-right text-primary me-2"></i><?php esc_html_e( 'Login', 'woocommerce' ); ?>
						</h3>

						<form class="woocommerce-form woocommerce-form-login login" method="post" novalidate>

							<?php do_action( 'woocommerce_login_form_start' ); ?>

							<div class="mb-3">
								<label for="username" class="form-label fw-semibold text-muted small"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?> <span class="text-danger">*</span></label>
								<div class="input-group">
									<span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
									<input type="text" class="form-control border-start-0 py-2 fs-6" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required aria-required="true" />
								</div>
							</div>

							<div class="mb-3">
								<label for="password" class="form-label fw-semibold text-muted small"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="text-danger">*</span></label>
								<div class="input-group">
									<span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock"></i></span>
									<input class="form-control border-start-0 py-2 fs-6" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
								</div>
							</div>

							<?php do_action( 'woocommerce_login_form' ); ?>

							<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
								<div class="form-check">
									<input class="form-check-input" name="rememberme" type="checkbox" id="rememberme" value="forever" />
									<label class="form-check-label text-muted small" for="rememberme">
										<?php esc_html_e( 'Remember me', 'woocommerce' ); ?>
									</label>
								</div>
								<div class="woocommerce-LostPassword lost_password small">
									<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-decoration-none fw-semibold text-primary"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
								</div>
							</div>

							<div class="mb-2">
								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
								<button type="submit" class="btn btn-primary robo-btn w-100 shadow-sm" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
							</div>

							<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
								<p class="text-center text-muted small mt-3 mb-0">
									<?php esc_html_e( "Don't have an account?", 'robo' ); ?>
									<a href="#" id="link-to-register" class="text-decoration-none fw-bold text-primary ms-1"><?php esc_html_e( 'Register', 'woocommerce' ); ?></a>
								</p>
							<?php endif; ?>

							<?php do_action( 'woocommerce_login_form_end' ); ?>

						</form>

			<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
					</div>
					
					<!-- Register Pane -->
					<div class="tab-pane fade" id="register-pane" role="tabpanel" aria-labelledby="register-tab">
						
						<!-- Register Form -->
						<h3 class="fw-bold text-dark mb-4 d-lg-none">
							<i class="bi bi-person-plus text-success me-2"></i><?php esc_html_e( 'Register', 'woocommerce' ); ?>
						</h3>

						<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

							<?php do_action( 'woocommerce_register_form_start' ); ?>

							<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

								<div class="mb-3">
									<label for="reg_username" class="form-label fw-semibold text-muted small"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="text-danger">*</span></label>
									<div class="input-group">
										<span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
										<input type="text" class="form-control border-start-0 py-2 fs-6" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required aria-required="true" />
									</div>
								</div>

							<?php endif; ?>

							<div class="mb-3">
								<label for="reg_email" class="form-label fw-semibold text-muted small"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="text-danger">*</span></label>
								<div class="input-group">
									<span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
									<input type="email" class="form-control border-start-0 py-2 fs-6" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required aria-required="true" />
								</div>
							</div>

							<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

								<div class="mb-3">
									<label for="reg_password" class="form-label fw-semibold text-muted small"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="text-danger">*</span></label>
									<div class="input-group">
										<span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock"></i></span>
										<input type="password" class="form-control border-start-0 py-2 fs-6" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
									</div>
								</div>

							<?php else : ?>

								<div class="mb-4">
									<p class="text-muted small mb-0"><i class="bi bi-info-circle me-1 text-info"></i><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'woocommerce' ); ?></p>
								</div>

							<?php endif; ?>

							<?php do_action( 'woocommerce_register_form' ); ?>

							<div class="mb-2">
								<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
								<button type="submit" class="btn btn-primary robo-btn w-100 shadow-sm" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
							</div>

							<p class="text-center text-muted small mt-3 mb-0">
								<?php esc_html_e( 'Already have an account?', 'robo' ); ?>
								<a href="#" id="link-to-login" class="text-decoration-none fw-bold text-primary ms-1"><?php esc_html_e( 'Login', 'woocommerce' ); ?></a>
							</p>

							<?php do_action( 'woocommerce_register_form_end' ); ?>

						</form>

					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>

	<!-- Right Side: Branded Promotional Section -->
	<div class="col-12 col-lg-6 order-1 order-lg-2">
		<div class="card border-0 shadow-sm p-4 p-md-5 text-white h-100 robo-auth-brand-card position-relative overflow-hidden rounded-3">
			<div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-10 z-0"></div>
			
			<div class="position-relative z-1 d-flex flex-column h-100">
				<!-- Brand Logo -->
				<div class="site-branding mb-4">
					<h3 class="fw-bold text-white mb-0">
						<span class="text-info">Robo</span>Scaler
					</h3>
				</div>

				<!-- Short Heading -->
				<h4 class="fw-extrabold text-white mb-2"><?php esc_html_e( 'Welcome to RoboScaler', 'robo' ); ?></h4>

				<!-- Description -->
				<p class="text-white-50 small mb-4">
					<?php esc_html_e( 'Join thousands of students, makers, and robotics enthusiasts. Access your orders, learning resources, project files, and exclusive content from one place.', 'robo' ); ?>
				</p>

				<!-- Robotics Illustration -->
				<div class="auth-illustration-wrapper text-center my-auto rounded-3 overflow-hidden shadow-lg bg-black bg-opacity-20 border border-white border-opacity-10">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/robo_auth_illustration.jpg' ); ?>" class="img-fluid object-fit-cover w-100" style="max-height: 280px;" alt="<?php esc_attr_e( 'RoboScaler illustration', 'robo' ); ?>">
				</div>

				<!-- Feature Highlights -->
				<div class="mt-4 pt-3 border-top border-white border-opacity-10">
					<div class="row g-3">
						<div class="col-6">
							<div class="d-flex align-items-center gap-2">
								<div class="bg-white bg-opacity-10 rounded p-1.5 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
									<i class="bi bi-shield-check text-info fs-5"></i>
								</div>
								<span class="small fw-semibold text-white"><?php esc_html_e( 'Secure Account', 'robo' ); ?></span>
							</div>
						</div>
						<div class="col-6">
							<div class="d-flex align-items-center gap-2">
								<div class="bg-white bg-opacity-10 rounded p-1.5 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
									<i class="bi bi-truck text-info fs-5"></i>
								</div>
								<span class="small fw-semibold text-white"><?php esc_html_e( 'Track Orders', 'robo' ); ?></span>
							</div>
						</div>
						<div class="col-6">
							<div class="d-flex align-items-center gap-2">
								<div class="bg-white bg-opacity-10 rounded p-1.5 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
									<i class="bi bi-book text-info fs-5"></i>
								</div>
								<span class="small fw-semibold text-white"><?php esc_html_e( 'Learning Resources', 'robo' ); ?></span>
							</div>
						</div>
						<div class="col-6">
							<div class="d-flex align-items-center gap-2">
								<div class="bg-white bg-opacity-10 rounded p-1.5 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
									<i class="bi bi-headset text-info fs-5"></i>
								</div>
								<span class="small fw-semibold text-white"><?php esc_html_e( 'Premium Support', 'robo' ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
	var linkToRegister = document.getElementById('link-to-register');
	var linkToLogin = document.getElementById('link-to-login');
	var registerTab = document.getElementById('register-tab');
	var loginTab = document.getElementById('login-tab');

	if (linkToRegister && registerTab) {
		linkToRegister.addEventListener('click', function(e) {
			e.preventDefault();
			registerTab.click();
		});
	}

	if (linkToLogin && loginTab) {
		linkToLogin.addEventListener('click', function(e) {
			e.preventDefault();
			loginTab.click();
		});
	}
});
</script>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
