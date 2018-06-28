<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <h1>Tag: <?php single_tag_title(); ?></h1>
    </div>
</section>

<section class="section section-primary">
    <div class="section-inner container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/post/content', 'excerpt' );
            endwhile;

            get_template_part( 'template-parts/post/content', 'pagination' );

        else : ?>
            Žádné výsledky nenalezeny.
        <?php
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
