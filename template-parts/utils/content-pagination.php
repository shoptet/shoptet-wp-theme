<?php
    the_posts_pagination(
    array(
        'prev_text' => '<span>' . __( 'Previous', 'shoptet' ) . '</span>',
        'next_text' => '<span>' . __( 'Next', 'shoptet' ) . '</span>',
        'before_page_number' => '<span class="meta-nav sr-only">' . __( 'Page', 'shoptet' ) . '</span>',
        )
    );
?>



