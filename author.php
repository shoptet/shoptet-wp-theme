<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <?php get_template_part( 'template-parts/utils/content', 'breadcrumb' ); ?>

        <?php
            $author_has_custom_gravatar = validate_gravatar(get_the_author_meta('email'));
            if ( $author_has_custom_gravatar ) {
                echo '<div class="row category-header"><div class="category-image col-xs-12 col-sm-2">';
                echo get_avatar( get_the_author_meta( 'ID' ));
                echo '</div><div class="col-xs-12 col-sm-10">';
            }
        ?>

        <h1><?php the_author(); ?></h1>

        <?php if ( get_the_author_meta( 'description' ) ) : ?>
            <div class="author-description"><?php the_author_meta( 'description' ); ?></div>
        <?php endif; ?>

        <?php
            if ( $author_has_custom_gravatar ) {
                echo '</div><!-- !.col --></div><!-- !.row -->';
            }
        ?>
    </div>
</section>

<?php get_template_part( 'template-parts/post/content', 'section-primary' ); ?>

<?php get_footer(); ?>
