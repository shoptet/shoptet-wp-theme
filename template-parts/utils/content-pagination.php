<?php
    the_posts_pagination(
    array(
        'prev_text' => '<span>' . _e( 'Previous', 'shoptet' ) . '</span>',
        'next_text' => '<span>' . _e( 'Next', 'shoptet' ) . '</span>',
        'before_page_number' => '<span class="meta-nav sr-only">' . _e( 'Page', 'shoptet' ) . '</span>',
        )
    );
?>



