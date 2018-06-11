<article>
    <?php if ( is_front_page() && ! is_home() ) {

        // The excerpt is being displayed within a front page section, so it's a lower hierarchy than h2.
        the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
    } else {
        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    } ?>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
</article>
