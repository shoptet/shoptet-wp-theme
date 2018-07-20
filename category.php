<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <?php get_template_part( 'template-parts/utils/content', 'breadcrumb' ); ?>

        <?php
            $current_category = get_queried_object();
            $category_image = get_term_meta( $current_category->term_id, 'category_image', true );
            if ( $category_image ) {
                echo '<div class="row category-header"><div class="category-image col-xs-12 col-sm-2">';
                echo '<img src="' . $category_image . '" />';
                echo '</div><div class="col-xs-12 col-sm-10">';
            }
        ?>

        <h1><?php single_cat_title(); ?></h1>

        <?php echo category_description(); ?>

        <?php
            if ( $category_image ) {
                echo '</div><!-- !.col --></div><!-- !.row -->';
            }
        ?>

    </div>
</section>

<?php get_template_part( 'template-parts/post/content', 'section-primary' ); ?>

<?php get_footer(); ?>
