<?php if ( is_active_sidebar( 'page_bottom_widget' )) { ?>

    <div class="row">
        <div class="col-12">
        <?php dynamic_sidebar( 'page_bottom_widget' ); ?>
        </div>
    </div>

<?php } ?>