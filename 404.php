<?php get_header(); ?>

<section class="section section-perex">
    <div class="section-inner container text-center">
        <h1><strong>404</strong></h1>
        <p>Je nám líto, ale zadaná stránka nebyla nalezena. Zkontrolujte adresu nebo použijte vyhledávací formulář</p>
    </div>
</section>

<section class="section section-primary">
    <div class="section-inner container">
        <div class="row search">
            <div class="col-sm-12 col-md-8 col-lg-6 align-self-center">
                <?php get_template_part( 'template-parts/search/content', 'search' ); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
