<?php /* Template Name: SHP Homepage - Blog */ ?>
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

            get_template_part( 'template-parts/utils/content', 'pagination' );

        else:
            e_('No results found', 'shoptet');
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
