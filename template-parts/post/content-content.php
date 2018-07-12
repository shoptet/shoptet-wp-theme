<?php

    echo '<h1>' . get_the_title() . '</h1>';

    get_template_part( 'template-parts/post/content', 'meta' );

    the_content();

    get_template_part( 'template-parts/post/content', 'widget' );

    get_template_part( 'template-parts/post/content', 'tags' );

    get_template_part( 'template-parts/post/content', 'navigation' );

?>
