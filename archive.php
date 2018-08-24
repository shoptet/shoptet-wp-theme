<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <?php get_template_part( 'template-parts/utils/content', 'breadcrumb' ); ?>

        <h1><?php the_archive_title(); ?></h1>

        <?php echo the_archive_description(); ?>
    </div>
</section>

<?php get_template_part( 'template-parts/post/content', 'section-primary' ); ?>

<?php get_footer(); ?>
