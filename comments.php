<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area card border-0 shadow-sm p-4 p-md-5 mb-4">

	<?php if ( have_comments() ) : ?>
		
		<!-- Comments Header -->
		<h2 class="comments-title h4 fw-bold text-dark mb-4 pb-2 border-bottom">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				printf(
					/* translators: %s: post title. */
					esc_html__( 'One thought on &ldquo;%s&rdquo;', 'robo' ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comments_number, 'comments title', 'robo' ) ),
					number_format_i18n( $comments_number ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2>

		<!-- Comments Navigation -->
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above" class="navigation comment-navigation mb-4" aria-label="<?php esc_attr_e( 'Comments Navigation', 'robo' ); ?>">
				<div class="nav-links d-flex justify-content-between">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '← Older Comments', 'robo' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments →', 'robo' ) ); ?></div>
				</div>
			</nav>
		<?php endif; ?>

		<!-- Comments List -->
		<ol class="comment-list list-unstyled mb-5">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 50,
					'class'       => 'comment-list-inner',
					// Bootstrap styled wrappers inside HTML list.
				)
			);
			?>
		</ol>

		<!-- Comments Navigation Bottom -->
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="navigation comment-navigation mt-4" aria-label="<?php esc_attr_e( 'Comments Navigation', 'robo' ); ?>">
				<div class="nav-links d-flex justify-content-between">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '← Older Comments', 'robo' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments →', 'robo' ) ); ?></div>
				</div>
			</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments text-muted small mt-4"><?php esc_html_e( 'Comments are closed.', 'robo' ); ?></p>
		<?php endif; ?>

	<?php endif; // Check for have_comments(). ?>

	<!-- Comment Form -->
	<?php
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

	// Bootstrap custom styled fields.
	$fields = array(
		'author' => '<div class="col-md-6 mb-3">' .
					'<label for="author" class="form-label small text-muted fw-semibold">' . esc_html__( 'Name', 'robo' ) . ( $req ? ' <span class="text-danger">*</span>' : '' ) . '</label>' .
					'<input id="author" name="author" type="text" class="form-control shadow-none border-light-subtle py-2 rounded-3" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder="' . esc_attr__( 'Your Name', 'robo' ) . '">' .
					'</div>',
		'email'  => '<div class="col-md-6 mb-3">' .
					'<label for="email" class="form-label small text-muted fw-semibold">' . esc_html__( 'Email', 'robo' ) . ( $req ? ' <span class="text-danger">*</span>' : '' ) . '</label>' .
					'<input id="email" name="email" type="email" class="form-control shadow-none border-light-subtle py-2 rounded-3" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="' . esc_attr__( 'Your Email', 'robo' ) . '">' .
					'</div>',
		'url'    => '<div class="col-12 mb-3">' .
					'<label for="url" class="form-label small text-muted fw-semibold">' . esc_html__( 'Website (Optional)', 'robo' ) . '</label>' .
					'<input id="url" name="url" type="url" class="form-control shadow-none border-light-subtle py-2 rounded-3" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="' . esc_attr__( 'Website URL', 'robo' ) . '">' .
					'</div>',
		'cookies' => '<div class="col-12 mb-3 form-check">' .
					 '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" class="form-check-input" value="yes"' . $consent . '>' .
					 '<label class="form-check-label small text-muted" for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'robo' ) . '</label>' .
					 '</div>',
	);

	comment_form(
		array(
			'fields'               => $fields,
			'comment_field'        => '<div class="col-12 mb-3">' .
									  '<label for="comment" class="form-label small text-muted fw-semibold">' . esc_html__( 'Comment', 'robo' ) . ' <span class="text-danger">*</span></label>' .
									  '<textarea id="comment" name="comment" cols="45" rows="5" class="form-control shadow-none border-light-subtle py-2 rounded-3" aria-required="true" placeholder="' . esc_attr__( 'Write your reply...', 'robo' ) . '"></textarea>' .
									  '</div>',
			'class_form'           => 'row g-3 needs-validation mt-3',
			'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
			'class_submit'         => 'btn btn-primary robo-btn shadow-sm',
			'submit_field'         => '<div class="col-12 mt-4">%1$s %2$s</div>',
			'title_reply'          => esc_html__( 'Leave a Reply', 'robo' ),
			'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'robo' ),
			'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'robo' ),
			'label_submit'         => esc_html__( 'Post Comment', 'robo' ),
		)
	);
	?>

</div><!-- #comments -->
