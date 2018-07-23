<?php /* Template Name: SHP Simple Content (for one-page) */ ?>

<?php if( !isset($singleView) || $singleView ) { get_header();  ?>

<section class="section section-primary">
    <div class="section-inner container">
        <?php get_template_part( 'template-parts/utils/content', 'breadcrumb' ); ?>
        <h1><?php the_title(); ?></h1>

        <?php the_content(); ?>

        <?php get_template_part( 'template-parts/page/content', 'widget' ); ?>
    </div>
</section>

<?php get_footer(); } else { ?>

<section class="section section-primary">
    <div class="section-inner container">
        <h2><?php echo apply_filters( 'get_the_title', $page->post_title ); ?></h2>

        <?php echo apply_filters( 'the_content', $page->post_content ); ?>
    </div>
</section>

<?php } ?>
