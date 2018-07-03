<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <?php get_template_part( 'template-parts/post/content', 'breadcrumb' ); ?>
        <div class="category-header">
            <?php
            $current_category = get_queried_object();
            $category_image = get_term_meta( $current_category->term_id, 'category_image', true );
            if ( $category_image ) {
                echo '<img src="' . $category_image . '" />';
            }
            ?>
            <h1><?php single_cat_title(); ?></h1>
        </div>
        <?php echo category_description(); ?>
    </div>
</section>

<section class="section section-primary">
    <div class="section-inner container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/post/content', 'excerpt' );
            endwhile;

            get_template_part( 'template-parts/post/content', 'pagination' );

        else : ?>
            Žádné výsledky nenalezeny.
        <?php
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
