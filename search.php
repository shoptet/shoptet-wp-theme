<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <?php get_template_part( 'template-parts/utils/content', 'breadcrumb' ); ?>
        <?php if ( have_posts() ) : ?>
            <h1><?php _e( 'Výsledky vyhledávání pro', 'shp' ); ?> <strong><?php echo get_search_query(); ?></strong></h1>
        <?php else : ?>
            <h1><?php _e( 'Žádné výsledky pro', 'shp' ); ?> <strong><?php echo get_search_query(); ?></strong></h1>
        <?php endif; ?>
    </div>
</section>

<?php get_template_part( 'template-parts/post/content', 'section-primary' ); ?>

<?php get_footer(); ?>
