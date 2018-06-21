<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
    <fieldset>
        <div class="input-group">
            <input type="search" name="s" class="form-control" value="<?php the_search_query(); ?>" placeholder="Zadejte hledaný text" />
            <div class="input-group-append">
                <button type="submit" class="btn btn-secondary has-icon has-icon-after">
                    <span class="sr-only">Vyhledat</span>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </fieldset>
</form>
