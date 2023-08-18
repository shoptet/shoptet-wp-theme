<form action="<?php if (defined('CUSTOM_SEARCH_ACTION')) {echo get_post_type_archive_link( 'custom' );} else {echo esc_url( home_url( '/' ));} ?>" method="get" role="search" data-search>
    <fieldset>
        <div class="input-group">
            <input type="search" name="s" class="form-control" value="<?php the_search_query(); ?>" placeholder="<?php _e( 'Enter search term...', 'shoptet' ); ?>" />
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary"><?php _e( 'Search', 'shoptet' ); ?></button>
            </div>
        </div>
    </fieldset>
</form>
