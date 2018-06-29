<?php /* Template Name: Blog Home Page Articles template */ ?>
<?php get_header(); ?>
<section class="section section-hidden">
    <div class="section-inner container">
        <?php the_title( '<h1>', '</h1>' ); ?>
    </div>
</section>
<section class="section section-primary">
    <div class="section-inner container">
        <?php
        query_posts('post_type=post&post_status=publish&posts_per_page=10&paged='. get_query_var('page'));

        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/post/content', 'excerpt' );
            endwhile;

            the_posts_pagination( array(
                'prev_text' => '<span>Předchozí</span>',
                'next_text' => '<span>Další</span>',
                'before_page_number' => '<span class="meta-nav sr-only">Strana</span>',
            ) );

        else : ?>
            Žádné výsledky nenalezeny.
        <?php
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
