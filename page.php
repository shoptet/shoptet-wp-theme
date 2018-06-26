<?php get_header(); ?>

<?php
while ( have_posts() ) : the_post(); ?>
    <?php get_template_part( 'template-parts/page/content', 'title' ); ?>
    <?php get_template_part( 'template-parts/page/content', 'content' ); ?>
<?php
endwhile;
?>

<?php get_footer();
