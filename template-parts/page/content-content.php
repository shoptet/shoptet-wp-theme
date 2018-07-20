<?php

    echo '<h1>' . get_the_title() . '</h1>';

    the_content();

    get_template_part( 'template-parts/post/content', 'widget' );       

?>
