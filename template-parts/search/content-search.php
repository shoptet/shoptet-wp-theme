<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
    <fieldset>
        <div class="input-group">
            <input type="search" name="s" class="form-control" value="<?php the_search_query(); ?>" placeholder="<?php _e( 'Zadejte hledaný výraz...', 'shp' ); ?>" />
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary"><?php _e( 'Hledat', 'shp' ); ?></button>
            </div>
        </div>
    </fieldset>
</form>
