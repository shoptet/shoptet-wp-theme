<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <h1>Tag: <?php single_tag_title(); ?></h1>
    </div>
</section>

<?php get_template_part( 'template-parts/post/content', 'section-primary' ); ?>

<?php get_footer(); ?>
