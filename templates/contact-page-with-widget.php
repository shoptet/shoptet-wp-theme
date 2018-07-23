<?php /* Template Name: SHP Contact Page with Widget */ ?>

<?php if( !isset($singleView) || $singleView ) { get_header();  ?>

<section class="section section-secondary">
    <div class="section-inner container">
        <?php get_template_part( 'template-parts/utils/content', 'breadcrumb' ); ?>
        <div class="row category-header">
            <div class="col-sm-6">
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
            <div class="col-sm-6">
                <?php if ( is_active_sidebar( 'contact_form' )) { dynamic_sidebar( 'contact_form' ); } ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); } else { ?>

<section class="section section-secondary">
    <div class="section-inner container">
        <div class="row">
            <div class="col-sm-6">
                <h2><?php echo apply_filters( 'get_the_title', $page->post_title ); ?></h2>
                <?php echo apply_filters( 'the_content', $page->post_content ); ?>
            </div>
            <div class="col-sm-6">
                <?php if ( is_active_sidebar( 'contact_form' )) { dynamic_sidebar( 'contact_form' ); } ?>
            </div>
        </div>
    </div>
</section>

<?php } ?>



