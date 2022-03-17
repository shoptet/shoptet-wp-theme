<div class="entry-meta">
    <?php
        $date_format = get_option('date_format');
        $post_date = get_the_date($date_format);
        if ( $post_date ) {
            echo '<div class="entry-date"><i class="fas fa-calendar-alt"></i>' . apply_filters( 'entry_date', $post_date, get_post() ) . '</div>';
        }

        $post_author = get_the_author();
        if ( $post_author ) {
            echo '<div class="entry-author"><i class="fas fa-user"></i>' . get_the_author_posts_link() . '</div>';
        }

        $post_categories = get_the_category_list(' | ');
        if ( $post_categories ) {
            echo '<div class="entry-tags"><i class="fas fa-tag"></i>' . $post_categories . '</div>';
        }

        $post_comments = get_comments_number();
        if ( $post_comments ) {
            echo '<div class="entry-comments"><i class="fas fa-comments"></i><a href="' . get_comments_link() . '">' . $post_comments . '</a></div>';
        }
    ?>
</div>