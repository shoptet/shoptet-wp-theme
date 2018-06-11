<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <?php if ( have_posts() ) : ?>
            <h1>Výsledky vyhledávání pro <strong><?php echo get_search_query(); ?></strong></h1>
        <?php else : ?>
            <h1>Žádné výsledky pro <strong><?php echo get_search_query(); ?></strong></h1>
        <?php endif; ?>
    </div>
</section>

<section class="section section-primary">
    <div class="section-inner container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/post/content', 'excerpt' );
            endwhile;
        else : ?>
            Žádné výsleky nenalezeny.
        <?php
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
