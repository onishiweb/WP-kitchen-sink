<?php if ( have_comments() ) : ?>

	<section id="comments">
		<h2>Comments</h2>
	
		<ul>
			<? wp_list_comments( array( 'callback' => 'oneltd_comment' ) ); ?>
		</ul>
		
	</section>		

<? endif; ?>
	
<section id="comment-form">
	<h2>Leave a comment</h2>
	<? 
	$fields =  array(
		'author' => '<p><label for="author">' . __( 'Name' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
	            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p><label for="e-mail">' . __( 'Email' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
	            '<input id="e-mail" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
	);

	$args = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<p><label for="comment">' . _x( 'Comment', 'noun' ) . ( $req ? '<span class="required">*</span>' : '' )  . '</label><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
		'label_submit'         => __( 'Post Comment' ),
		'comment_notes_after'  => '',
		'title_reply'          => __( '' ),
	);

	comment_form($args); ?>
	
</section>