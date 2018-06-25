<?php get_header(); ?>

<section class="section section-primary">
    <div class="section-inner container">

    <?php
        /* Start the Loop */
        while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/post/content', 'content' );

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
        	comments_template();
        endif;

        endwhile; // End of the loop.
    ?>

    </div>
</section>

<?php get_footer(); ?>
