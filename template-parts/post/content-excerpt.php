<article>
    <?php if ( get_the_post_thumbnail() !== '' && ! is_single() ) : ?>
		<div class="row">
    		<div class="entry-thumbnail col-sm-12 col-md-4 col-lg-4">
    			<a href="<?php the_permalink(); ?>">
    				<?php the_post_thumbnail(); ?>
    			</a>
    		</div>
        <div class="col-sm-12 col-md-8 col-lg-8">
	<?php endif; ?>

    <?php if ( is_front_page() && ! is_home() ) {

        // The excerpt is being displayed within a front page section, so it's a lower hierarchy than h2.
        the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
    } else {
        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    } ?>

    <?php
    if (defined('CUSTOM_POST_CONTENT_META')) {
        get_template_part( 'src/template-parts/post/content', 'meta' );
    } else {
        get_template_part( 'template-parts/post/content', 'meta' );
    }
    ?>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>

    <div class="entry-more">
        <a href="<?php the_permalink(); ?>" class="btn btn-secondary" id="article~<?php get_the_ID() ?>"><?php _e('Read all', 'shoptet') ?></a>
    </div>

    <?php if ( get_the_post_thumbnail() !== '' && ! is_single() ) : ?>
            </div> <!-- !.col -->
        </div> <!-- !.row -->
    <?php endif; ?>
</article>
