<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * borrowed from TwentyThirteen Theme
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf(
				_nx(
					'One comment',
					'%1$s comments',
					get_comments_number(),
					'comments title',
					'tt7'
				),
				number_format_i18n( get_comments_number() ),

			);
			?>
		</h2>

		<ul class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ul',
        'callback'    => 'my_comments_callback',
			) );
			?>
		</ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="navigation comment-navigation" role="navigation">

				<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'tt7' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'tt7' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'tt7' ) ); ?></div>
			</nav>
		  <?php endif; // Check for comment navigation ?>

		  <?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'tt7' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>
</div> <!--#comments-->
