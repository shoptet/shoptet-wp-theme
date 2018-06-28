<div class="entry-meta">
    <?php
        $post_tags = get_the_tags();
        if ( $post_tags ) {
            echo '<div class="entry-tags"><i class="fas fa-tag"></i>';
            foreach( $post_tags as $tag ) {
                echo '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>';
                if ($tag != end($post_tags)) { echo ' | '; }
            }
            echo '</div>';
        }
    ?>
</div>
