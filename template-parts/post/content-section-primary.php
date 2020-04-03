<section class="section section-primary">
    <div class="section-inner container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/post/content', 'excerpt' );
            endwhile;

            get_template_part( 'template-parts/utils/content', 'pagination' );

        else : ?>
            <h2><?php _e( 'We are sorry, but requested page was not found', 'shoptet' ); ?></h2>
            <p><?php _e( 'Try to use search, please', 'shoptet' ); ?></p>

            <?php get_template_part( 'template-parts/search/content', 'search' ); ?>
        <?php
        endif;
        ?>
    </div>
</section>