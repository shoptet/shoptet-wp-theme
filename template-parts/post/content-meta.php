<div class="entry-meta">
    <?php
        $post_date = get_the_date('d. m. Y');
        if ( $post_date ) {
            echo '<div class="entry-date"><i class="fas fa-calendar-alt"></i>' . $post_date . '</div>';
        }

        $post_author = get_the_author();
        if ( $post_author ) {
            echo '<div class="entry-author"><i class="fas fa-user"></i>' . get_the_author_link() . '</div>';
        }

        $post_tags = get_the_tags();
        if ( $post_tags ) {
            echo '<div class="entry-tags"><i class="fas fa-tag"></i>';
            foreach( $post_tags as $tag ) {
                echo '<a href="' . $tag->link . '">' . $tag->name . '</a>';
                if ($tag != end($post_tags)) { echo ' | '; }
            }
            echo '</div>';
        }

        $post_comments = get_comments_number();
        if ( $post_comments ) {
            echo '<div class="entry-comments"><i class="fas fa-comments"></i><a href="' . get_comments_link() . '">' . $post_comments . '</a></div>';
        }
    ?>
</div>