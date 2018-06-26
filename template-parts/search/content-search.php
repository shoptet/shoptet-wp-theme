<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
    <fieldset>
        <div class="input-group">
            <input type="search" name="s" class="form-control" value="<?php the_search_query(); ?>" placeholder="Zadejte hledaný text" />
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Hledat</button>
            </div>
        </div>
    </fieldset>
</form>
