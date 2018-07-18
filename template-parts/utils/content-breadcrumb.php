<?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb('
            <div class="breadcrumb">','</div>
        ');
    } else {
        shp_breadcrumb();
    }
?>
