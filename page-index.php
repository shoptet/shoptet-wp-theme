<?php /* Template Name: Homepage template */ ?>
<?php get_header(); ?>

<section class="section section-claim">
    <div class="section-inner container">
        <div class="claim">
            <div class="claim-inner">
                <?php bloginfo('description'); ?>
            </div>
        </div>
    </div>
</section>

<?php get_template_part( 'src/template-parts/page/content', 'index' ); ?>

<?php get_footer(); ?>
