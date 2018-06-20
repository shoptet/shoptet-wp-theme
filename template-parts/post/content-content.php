<?php

    echo '<h1>' . get_the_title() . '</h1>';

    get_template_part( 'template-parts/post/content', 'meta' );

    the_content();

    the_post_navigation (
    array (
        'prev_text' => '<span class="nav-previous">&laquo; %title</span>',
        'next_text' => '<span class="nav-next">%title &raquo;</span>',
        )
    );

?>
