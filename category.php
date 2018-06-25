<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <?php shp_breadcrumb(); ?>

        <?php
            $current_category = get_queried_object();
            $category_image = get_term_meta( $current_category->term_id, 'category_image', true );
            if ( $category_image ) {
                echo '<div class="row"><div class="category-image col-sm-2 col-md-2 col-lg-1"><img src="' . $category_image . '"/></div><div class="col-sm-10 col-md-10 col-lg-11">';
            }
        ?>

        <h1><?php single_cat_title(); ?></h1>

        <?php echo category_description(); ?>

        <?php
            if ( $category_image ) {
                echo '</div></div><!-- !.row -->';
            }
        ?>

    </div>
</section>

<section class="section section-primary">
    <div class="section-inner container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/post/content', 'excerpt' );
            endwhile;

            the_posts_pagination( array(
				'prev_text' => '<span>Předchozí</span>',
				'next_text' => '<span>Další</span>',
				'before_page_number' => '<span class="meta-nav sr-only">Strana</span>',
			) );

        else : ?>
            Žádné výsledky nenalezeny.
        <?php
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
