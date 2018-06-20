<?php

    if ( post_password_required() ) {
    	return;
    }

	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
        <div class="comments">
            <h3>

    			<?php
        			$comments_number = get_comments_number();
        			if ( '1' === $comments_number ) {
        				echo '1 komentář';
        			} elseif ( 5 > $comments_number ) {
        				echo number_format_i18n( $comments_number ) . ' komentáře';
        			} else {
        			    echo number_format_i18n( $comments_number ) . ' komentářů';
        			}
    			?>

    		</h3>

    		<ol class="comment-list">
    			<?php
    				wp_list_comments( array(
    					'avatar_size' => 100,
    					'style'       => 'ol',
    					'short_ping'  => true,
    					'reply_text'  => 'Odpovědět',
    				) );
    			?>
    		</ol>

        </div>

		<?php

        the_comments_pagination(
            array (
            'prev_text' => '<span class="nav-previous">&laquo; %title</span>',
            'next_text' => '<span class="nav-next">%title &raquo;</span>',
            )
        );

	endif; // Check for have_comments().

	// If comments are closed and there are comments
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments">Není možné přidávat další komentáře</p>

	<?php

	endif;

    /* https://codex.wordpress.org/Function_Reference/comment_form */
    $sgp_commentform_args = array(
        'fields' => array(
            'author' =>
                '<div class="row"><div class="col-md-4"><p class="comment-form-author"><label for="author">' . __( 'Jméno', 'domainreference' ) .
                ( $req ? ' <span class="required">*</span>' : '' ) . '</label>' .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                '" size="30"' . $aria_req . ' class="form-control"/></p></div>',

            'email' =>
                '<div class="col-md-4"><p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) .
                ( $req ? ' <span class="required">*</span>' : '' ) . '</label>' .
                '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                '" size="30"' . $aria_req . ' class="form-control"/></p></div>',

            'url' =>
                '<div class="col-md-4"><p class="comment-form-url"><label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
                '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
                '" size="30" class="form-control"/></p></div></div>',
            ),
            'comment_field' =>
                '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
                ( $req ? ' <span class="required">*</span>' : '' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="form-control">' .
                '</textarea></p>',

        'comment_notes_after' => '<p>Vložením zprávy souhlasíte s <a href="https://www.shoptet.cz/podminky-ochrany-osobnich-udaju/" target="_blank">podmínkami ochrany osobních údajů</a></p>',
        'title_reply' => 'Napište komentář',
        'class_submit'      => 'btn btn-secondary',
    );

	comment_form($sgp_commentform_args);

	?>


