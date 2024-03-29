<!DOCTYPE html>
<html lang="<?php echo substr(get_locale(), 0, 2); ?>">
  <head>
    <title><?php wp_title(); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <?php if (get_theme_mod( 'gtm_id' ) && get_theme_mod( 'cookiebot_id' )): ?>
        <script data-cookieconsent="ignore">
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
                'event': 'loaded_starting',
                'timestampStart': new Date().getTime(),
            });
        </script>
        <script data-cookieconsent="ignore">
            var load_gtm = (function (e) {
                var loaded = false;
                return function () {
                    if (!loaded) {
                        loaded = true;
                        (function(w,d,s,l,i){ w[l]=w[l]||[];w[l].push({ 'gtm.start': new Date().getTime(),event:'gtm.js' }); var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                        })(window,document,'script','dataLayer','<?= get_theme_mod( 'gtm_id' ) ?>');
                        dataLayer.push({
                            'event': 'loaded_gtm',
                            'timestampGtm': new Date().getTime(),
                        });
                    }
                };
            })();
            window.addEventListener('CookiebotOnDialogDisplay', load_gtm, false);
            window.addEventListener('CookiebotOnConsentReady', load_gtm, false);
            window.addEventListener('DOMContentLoaded', () => setTimeout(() => load_gtm(), 5000), false);
        </script>
        <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-consentmode="disabled" data-cbid="<?= get_theme_mod( 'cookiebot_id' ) ?>" type="text/javascript" async></script>
        <script data-cookieconsent="ignore">
            dataLayer.push({
                'event': 'loaded_cookiebot',
                'timestampCookiebot': new Date().getTime(),
            });
        </script>
    <?php endif; ?>

    <?php wp_head(); ?>
	</head>

  <body <?php body_class(isset($class) ? $class : ''); ?>>

    <?php if (get_theme_mod( 'gtm_id' ) && get_theme_mod( 'cookiebot_id' )): ?>
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=<?= get_theme_mod( 'gtm_id' ) ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
    <?php endif; ?>

    <?php if (defined('ABOVE_HEADER')) {
        get_template_part( 'src/template-parts/page/header', 'above' );
    } ?>

    <header id="header" class="header">
        <div class="header-inner container">
            <div id="shp_header">
            <?php
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                if ( has_custom_logo() ) {
                    echo '<a href="/" class="shp_logo"><img src="'. esc_url( $logo[0] ) .'"></a>';
                } else {
                    echo '<a href="/" class="shp_logo"><svg width="350" height="55" viewBox="0 0 53.98 8.48" xmlns="http://www.w3.org/2000/svg"><defs><clipPath id="a"><path d="M0 25.67h114.67V0H0z"/></clipPath></defs><g clip-path="url(#a)" transform="matrix(.35278 0 0 -.35278 0 8.66)"><path d="M28.9 6.57c0-.8-.28-1.48-.84-2.02a2.86 2.86 0 0 0-2.05-.8 3.4 3.4 0 0 0-2.83 1.36l.78.88c.62-.7 1.29-1.06 1.99-1.06.46 0 .87.15 1.23.45s.54.68.54 1.14c0 .46-.21.87-.64 1.22-.21.17-.63.42-1.25.74-.7.36-1.22.72-1.55 1.08a2.45 2.45 0 0 0-.67 1.72c0 .75.25 1.35.76 1.83.5.47 1.12.7 1.86.7.88 0 1.77-.43 2.66-1.29l-.79-.82c-.66.64-1.3.95-1.92.95-.38 0-.72-.12-1.01-.37-.3-.25-.44-.57-.44-.94 0-.63.6-1.26 1.83-1.89.74-.39 1.29-.76 1.63-1.1.47-.5.7-1.1.71-1.78M38.7 4h-1.24v4.56c0 1.1-.05 1.83-.14 2.2-.3 1.28-1.1 1.91-2.4 1.91-.74 0-1.4-.24-2-.73a3.42 3.42 0 0 1-1.15-1.83 12.4 12.4 0 0 1-.18-2.6V4h-1.24v13.26h1.24v-5.4c.99 1.3 2.18 1.95 3.58 1.95.7 0 1.33-.17 1.89-.53.56-.35.97-.84 1.24-1.46.26-.62.4-1.59.4-2.9zM50.13 8.76c0-1.41-.48-2.6-1.44-3.56a4.8 4.8 0 0 0-3.54-1.45c-1.41 0-2.6.48-3.55 1.44a4.85 4.85 0 0 0-1.44 3.57c0 1.32.44 2.47 1.32 3.45a4.73 4.73 0 0 0 3.67 1.6 5 5 0 0 0 4.98-5.06m-1.26-.02c0 1.05-.36 1.96-1.08 2.73a3.49 3.49 0 0 1-2.64 1.14 3.49 3.49 0 0 1-2.65-1.14 3.84 3.84 0 0 1-1.07-2.73c0-.68.16-1.31.48-1.9.33-.61.78-1.08 1.36-1.4.57-.34 1.2-.5 1.88-.5 1.45 0 2.52.62 3.22 1.87.33.6.5 1.24.5 1.93M61.68 8.81a4.96 4.96 0 0 0-4.9-5.06c-1.52 0-2.8.63-3.83 1.9V.5H51.7v13.07h1.23V11.8a4.5 4.5 0 0 0 3.8 2c1.38 0 2.54-.48 3.5-1.46a4.88 4.88 0 0 0 1.44-3.54m-1.25-.04a3.92 3.92 0 0 1-1.89 3.34c-.58.34-1.22.5-1.9.5-1.09 0-2-.37-2.7-1.11a3.85 3.85 0 0 1-1.08-2.77c0-1.52.63-2.63 1.88-3.33.6-.34 1.24-.51 1.92-.51.68 0 1.3.17 1.9.52.56.35 1.02.83 1.36 1.43.34.61.51 1.25.51 1.93" fill="#90d12a"/><path d="M67.54 12.5h-1.96V4h-1.24v8.5h-1.69v1.07h1.69v3.55h1.24v-3.55h1.96zM78.06 8.69h-8.6a3.97 3.97 0 0 1 1-2.68 3.35 3.35 0 0 1 2.6-1.12 3.8 3.8 0 0 1 2.6.93c.32.28.67.73 1.05 1.35l1.03-.54a5.03 5.03 0 0 0-2.68-2.55 5.2 5.2 0 0 0-1.9-.33 4.81 4.81 0 0 0-4.97 5c0 1.22.37 2.3 1.12 3.25a4.57 4.57 0 0 0 3.79 1.82c1.63 0 2.93-.62 3.9-1.86a5.21 5.21 0 0 0 1.06-3.27m-1.35 1.07a3.55 3.55 0 0 1-1.96 2.5c-.51.25-1.06.37-1.63.37-.93 0-1.74-.3-2.41-.9-.5-.44-.87-1.1-1.12-1.97zM83.91 12.5h-1.95V4H80.7v8.5h-1.68v1.07h1.68v3.55h1.25v-3.55h1.95z" fill="#5f9a3c"/><path d="M-.32 13.71H9.85V3.54H-.32z" fill="#90d12a"/><path d="M10.52 13.71h10.16V3.54H10.52z" fill="#4fb4e9"/><path d="M5.03 24.55H15.2V14.38H5.03z" fill="#f79528"/><path d="M93.43 12.53a3.5 3.5 0 0 1-3.09-1.81 3.66 3.66 0 0 1 0-3.64 3.55 3.55 0 0 1 6.2-.06c.3.54.46 1.16.46 1.84 0 1.05-.34 1.92-1.03 2.62a3.41 3.41 0 0 1-2.54 1.05m4.64.89V4.4h-1.14v1.55a4.96 4.96 0 0 0-1.64-1.33c-.6-.3-1.27-.45-1.98-.45-1.28 0-2.37.46-3.27 1.39s-1.36 2.05-1.36 3.37c0 1.3.46 2.41 1.37 3.33s2 1.39 3.29 1.39a4.25 4.25 0 0 0 3.59-1.9v1.66z" fill="#6f7375"/><path d="M93.43 12.34a3.34 3.34 0 0 1-2.93-1.71 3.49 3.49 0 0 1 1.25-4.75 3.38 3.38 0 0 1 5.06 2.98c0 1-.32 1.83-.97 2.49a3.2 3.2 0 0 1-2.4 1m-.01-7.3a3.66 3.66 0 0 0-3.24 1.93 3.86 3.86 0 0 0 1.36 5.23c.58.34 1.2.5 1.88.5a3.6 3.6 0 0 0 2.67-1.1 3.78 3.78 0 0 0 1.08-2.75c0-.7-.16-1.36-.48-1.93a3.83 3.83 0 0 0-3.28-1.87m-.08 8.4c-1.23 0-2.29-.44-3.16-1.33s-1.31-1.95-1.31-3.2c0-1.27.44-2.36 1.3-3.24a4.24 4.24 0 0 1 3.14-1.33 4.26 4.26 0 0 1 3.47 1.7c.05.07.13.1.2.07.08-.03.13-.1.13-.18V4.6h.77v8.64h-.77v-1.47a.19.19 0 0 0-.34-.1c-.43.6-.94 1.05-1.5 1.35-.58.3-1.23.45-1.93.45m-.03-9.48a4.6 4.6 0 0 0-3.4 1.45 4.85 4.85 0 0 0-1.41 3.5c0 1.35.48 2.51 1.42 3.46.94.96 2.1 1.44 3.42 1.44a4.45 4.45 0 0 0 3.4-1.54v1.13c0 .1.08.18.19.18h1.14c.1 0 .18-.08.18-.18V4.4c0-.1-.08-.18-.18-.18h-1.14c-.1 0-.19.08-.19.18v1.07a4.62 4.62 0 0 0-3.43-1.48M105.25 12.53c-1 0-1.85-.35-2.53-1.05a3.59 3.59 0 0 1-1.03-2.62c0-.68.15-1.3.46-1.84a3.64 3.64 0 0 1 3.12-1.78 3.56 3.56 0 0 1 3.07 1.84 3.67 3.67 0 0 1-1.3 4.97 3.5 3.5 0 0 1-1.79.48m-4.64.89h1.16v-1.66a4.2 4.2 0 0 0 3.58 1.89c1.28 0 2.37-.46 3.28-1.39A4.57 4.57 0 0 0 110 8.93c0-1.32-.45-2.45-1.36-3.37s-1.99-1.39-3.26-1.39a4.4 4.4 0 0 0-1.98.45c-.6.3-1.14.74-1.63 1.33V1.11h-1.16z" fill="#6f7375"/><path d="M105.25 12.34c-.95 0-1.75-.33-2.4-1a3.43 3.43 0 0 1-.98-2.48c0-.64.15-1.23.44-1.75a3.36 3.36 0 0 1 5.86.06 3.5 3.5 0 0 1-1.23 4.72c-.51.3-1.08.45-1.69.45m.02-7.29a3.84 3.84 0 0 0-3.28 1.88 3.91 3.91 0 0 0-.49 1.93c0 1.1.37 2.02 1.08 2.75s1.62 1.1 2.67 1.1a3.7 3.7 0 0 0 3.25-1.9 3.86 3.86 0 0 0-3.23-5.76M100.8 1.3h.79v4.66c0 .08.05.15.12.18.08.02.16 0 .2-.06a4.24 4.24 0 0 1 3.47-1.71c1.22 0 2.27.44 3.13 1.33a4.5 4.5 0 0 1 1.3 3.24 4.4 4.4 0 0 1-1.31 3.2 4.28 4.28 0 0 1-3.15 1.33 4.04 4.04 0 0 1-3.43-1.81.2.2 0 0 0-.2-.07.18.18 0 0 0-.13.18v1.47h-.8zm.97-.37h-1.16c-.1 0-.18.08-.18.19v12.3c0 .1.08.2.18.2h1.16c.1 0 .19-.1.19-.2V12.3a4.4 4.4 0 0 0 3.39 1.54c1.32 0 2.47-.48 3.41-1.43s1.42-2.12 1.42-3.47c0-1.36-.47-2.54-1.4-3.5a4.6 4.6 0 0 0-3.4-1.44 4.6 4.6 0 0 0-3.42 1.48V1.1c0-.1-.09-.19-.19-.19M111.91 13.42h1.16V4.4h-1.16zm.58 3.7c.26 0 .49-.09.67-.28a.93.93 0 0 0 .28-.67c0-.26-.1-.49-.28-.68a.92.92 0 0 0-.67-.28.9.9 0 0 0-.67.29.92.92 0 0 0-.28.67c0 .26.1.49.28.67.18.2.4.29.67.29" fill="#6f7375"/><path d="M112.48 16.94a.73.73 0 0 1-.54-.23.74.74 0 0 1-.22-.54c0-.21.07-.4.22-.54.31-.31.79-.3 1.09 0 .15.15.22.33.22.54 0 .21-.07.4-.23.54s-.33.23-.54.23m0-1.91c-.3 0-.58.11-.8.33-.22.23-.33.5-.33.8a1.13 1.13 0 0 0 1.94.81c.22-.22.33-.49.33-.8 0-.31-.11-.58-.33-.8a1.1 1.1 0 0 0-.81-.34m-.4-10.44h.8v8.64h-.8zm.98-.37h-1.16c-.1 0-.18.08-.18.18v9.02c0 .1.08.18.18.18h1.16c.1 0 .19-.08.19-.18V4.4c0-.1-.08-.18-.19-.18" fill="#6f7375"/></g></svg></a>';
                }
            ?>
            </div>
            <div class="search header-search">
                <?php
                    if (defined('CUSTOM_SEARCH_HEADER')) {
                        get_template_part( 'src/template-parts/search/content', 'search' );
                    } else {
                        get_template_part( 'template-parts/search/content', 'search' );
                    }
                ?>
            </div>
            <?php if (defined('CUSTOM_PART_OF_HEADER')) {
                get_template_part( 'src/template-parts/page/header', 'custom' );
            } ?>
        </div>
    </header>

    <div id="navigation">
        <div class="container">
            <div id="shp_navigation_wrapper" class="responsive-nav">
               <?php wp_nav_menu( array('menu' => 'Main', 'menu_class' => 'visible-links', 'menu_id' => 'shp_navigation', 'container'=> false, 'walker'=> new Shp_Walker_Nav_Menu)); ?>
            </div>
        </div>
    </div>
