<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container">
        <?php
            $author_has_custom_gravatar = validate_gravatar(get_the_author_meta('email'));
            if ( $author_has_custom_gravatar ) {
                echo '<div class="row"><div class="category-image col-xs-12 col-sm-2">';
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
