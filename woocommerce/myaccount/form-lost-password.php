<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="row justify-content-center">
	<div class="col-md-6 col-lg-5">
		<div class="card border-0 shadow-sm p-4 p-md-5 bg-white rounded-3">
			
			<h3 class="fw-bold text-dark mb-3 text-center">
				<i class="bi bi-key text-primary me-2"></i>
				<?php esc_html_e( 'Reset Password', 'robo' ); ?>
			</h3>

			<form method="post" class="woocommerce-ResetPassword lost_reset_password" novalidate>

				<p class="text-muted small mb-4 text-center"><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p>

				<div class="mb-4">
					<label for="user_login" class="form-label fw-semibold text-muted small"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?> <span class="text-danger">*</span></label>
					<div class="input-group">
						<span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
						<input class="form-control border-start-0 py-2 fs-6" type="text" name="user_login" id="user_login" autocomplete="username" required aria-required="true" />
					</div>
				</div>

				<?php do_action( 'woocommerce_lostpassword_form' ); ?>

				<div class="mb-2">
					<input type="hidden" name="wc_reset_password" value="true" />
					<button type="submit" class="btn btn-primary robo-btn w-100 shadow-sm" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
				</div>

				<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

			</form>
			
		</div>
	</div>
</div>

<?php
do_action( 'woocommerce_after_lost_password_form' );
