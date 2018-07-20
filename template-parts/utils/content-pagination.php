<?php
    the_posts_pagination(
    array(
        'prev_text' => '<span>' . __( 'Předchozí', 'shp' ) . '</span>',
        'next_text' => '<span>' . __( 'Další', 'shp' ) . '</span>',
        'before_page_number' => '<span class="meta-nav sr-only">' . __( 'Strana', 'shp' ) . '</span>',
        )
    );
?>



