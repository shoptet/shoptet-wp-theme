<?php

    echo '<h1>' . get_the_title() . '</h1>';

    if (defined('CUSTOM_POST_CONTENT_META')) {
        get_template_part( 'src/template-parts/post/content', 'meta' );
    } else {
        get_template_part( 'template-parts/post/content', 'meta' );
    }

    the_content();

    get_template_part( 'template-parts/post/content', 'widget' );

    get_template_part( 'template-parts/post/content', 'tags' );

    get_template_part( 'template-parts/utils/content', 'navigation' );

?>
