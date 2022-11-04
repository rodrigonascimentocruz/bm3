<?php global $royalConfig; ?>
<?php if ( post_password_required( ) ) return; ?>

<?php if ( have_comments( ) ) : ?>
	<hr>
	<div class="comments" id="comments">
		<div class="row offsetTopS offsetBottomS">
			<div class="col-md-12">
				<header class="offsetTopS offsetBottomS">
					<h3><?php comments_number( ); ?></h3>
				</header>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 clearfix">
				<?php wp_list_comments( array( 'callback' => array( 'RoyalTheme', 'comment' ), 'style' => 'div' ) ); ?>
			</div>
		</div>
		<?php if ( get_comment_pages_count( ) > 1 && get_option( 'page_comments' ) ) : ?>
		<div class="row offsetTopS">
			<div class="col-md-12 pages-navigation offsetTopS">
				<?php previous_comments_link( esc_html__( '&lsaquo;&nbsp; Older comments', 'royal' ) ); ?>
				<?php next_comments_link( esc_html__( 'Newer comments &rsaquo;&nbsp;', 'royal' ) ); ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<div class="offsetTop"></div>
<?php endif; ?>

<?php if ( comments_open( ) or ( ! comments_open( ) && get_comments_number( ) ) ) : ?>
	<hr>
<?php endif; ?>

<div class="offsetTopS"></div>

<?php if ( ! comments_open( ) && get_comments_number( ) ) : ?>
	<div class="offsetTopS">
		<p><?php esc_html_e( 'Comments are closed.', 'royal' ); ?></p>
	</div>
<?php endif; ?>

<?php
$commenter = wp_get_current_commenter( );
$required = ( get_option( 'require_name_email' ) ? " aria-required='true'" : '' );

comment_form( array(
	'fields' => array(
		'author' => '
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="field">
						<input type="text" id="author" name="author" class="field-name" placeholder="' . esc_html__( 'Name', 'royal' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $required . '>
					</div>
				</div>',
		'email' => '
				<div class="col-md-6 col-sm-6">
					<div class="field">
						<input type="email" id="email" name="email" class="field-email" placeholder="' . esc_html__( 'Email', 'royal' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $required . '>
					</div>
				</div>
			</div>',
		'url' => '
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="field">
						<input type="text" id="url" name="url" class="field-url" placeholder="' . esc_html__( 'Website', 'royal' ) . '" value="' . esc_attr(  $commenter['comment_author_url'] ) . '">
					</div>
				</div>
			</div>'
	),
	'comment_field' => '
		<div class="row">
			<div class="col-md-12">
				<div class="field">
					<textarea id="comment" name="comment" class="field-comment" placeholder="' . esc_html__( 'Comment', 'royal' ) . '" aria-required="true"></textarea>
				</div>
			</div>
		</div>',
	'comment_notes_before' => '
		<div class="offsetTopS offsetBottomS">
			<p class="comment-notes">' . esc_html__( 'Your email address will not be published.', 'royal' ) . '</p>
		</div>',
	'comment_notes_after' => '',
	'logged_in_as' => '
		<div class="offsetTopS offsetBottomS">
			<p class="logged-in-as">' . sprintf( wp_specialchars_decode(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'royal' )), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>
		</div>',
	'must_log_in' => '
		<div class="offsetTopS offsetBottomS">
			<p class="must-log-in">' .  sprintf( wp_specialchars_decode(__( 'You must be <a href="%s">logged in</a> to post a comment.', 'royal' )), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>
		</div>'
) );
?>