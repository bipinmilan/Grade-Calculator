<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grade_Calculator
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<i class="fa-solid fa-comments"></i>
			<?php
			$comment_count = get_comments_number();
			if ( '1' === $comment_count ) {
				esc_html_e( '1 Comment', 'grade-calculator' );
			} else {
				printf(
					/* translators: %s: comment count number */
					esc_html( _nx( '%s Comment', '%s Comments', $comment_count, 'comments title', 'grade-calculator' ) ),
					number_format_i18n( $comment_count )
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 52,
			) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_pagination( array(
			'prev_text' => '<i class="fa-solid fa-arrow-left"></i> ' . esc_html__( 'Older', 'grade-calculator' ),
			'next_text' => esc_html__( 'Newer', 'grade-calculator' ) . ' <i class="fa-solid fa-arrow-right"></i>',
			'class'     => 'scorebook-pagination comment-pagination',
		) );
		?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'grade-calculator' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'        => __( 'Leave a Comment', 'grade-calculator' ),
		'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</h3>',
		'class_submit'       => 'btn btn-primary comment-submit-btn',
		'comment_field'      => '<div class="comment-form-field comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'grade-calculator' ) . '</label><textarea id="comment" name="comment" rows="6" required placeholder="' . esc_attr__( 'Share your thoughts…', 'grade-calculator' ) . '"></textarea></div>',
	) );
	?>

</div><!-- #comments -->