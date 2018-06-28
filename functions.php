<?php
spl_autoload_register(function($name) {
    $file = __DIR__ . '/shoptet/' . $name . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}, TRUE, TRUE);

require_once 'src/functions.php';

add_theme_support( 'post-thumbnails' );

/**
 * Add SVG mime type to upload core
 */
function generate_svg( $svg_mime ) {
    $svg_mime['svg'] = 'image/svg+xml';
    return $svg_mime;
}
add_filter( 'upload_mimes', 'generate_svg' );

/**
 * Custom WordPress breadcrumbs
 */
function shp_breadcrumb() {
	echo '<ol class="breadcrumb">';

    if (!is_home()) {
		echo '<li class="breadcrumb-item"><a href="' . get_option('home') . '"><i class="fas fa-home"></i></a></li>';

		if (is_category() || is_single()) {
			echo '<li class="breadcrumb-item">';
			the_category(' </li><li class="breadcrumb-item"> ');

			if (is_single()) {
				echo '</li><li class="breadcrumb-item">' . get_the_title() . '</li>';
			}

		} elseif (is_page()) {
			echo '<li class="breadcrumb-item">' . get_the_title .'</li>';
		}
	}
	elseif (is_tag()) { single_tag_title(); }
	elseif (is_day()) { echo '<li class="breadcrumb-item active">Archiv ' . the_time('F jS, Y') . '</li>'; }
	elseif (is_month()) { echo '<li class="breadcrumb-item active">Archiv ' . the_time('F, Y') . '</li>'; }
	elseif (is_year()) { echo '<li class="breadcrumb-item active">Archiv ' . the_time('Y') . '</li>'; }
	elseif (is_author()) { echo '<li class="breadcrumb-item active">Archiv autora</li>'; }
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { echo '<li class="breadcrumb-item">Archiv blogu </li>'; }
	elseif (is_search()) { echo '<li class="breadcrumb-item active">Výsledky vyhledávání</li>'; }
	echo '</ol>';
}
add_filter( 'shp_breadcrumb', 'shp_breadcrumb' );

/**
 * Custom WordPress navigation
 */
if ( ! function_exists( 'main_menu_setup' ) ):

    function main_menu_setup(){
        add_action( 'init', 'register_menu' );

        function register_menu(){
            register_nav_menu( 'main_menu', 'Main Navigation' );
        }

        class Shp_Walker_Nav_Menu extends Walker_Nav_Menu {

            function start_lvl( &$output, $depth = 0, $args = array() ) {
                $indent = str_repeat( "\t", $depth );
                $output	   .= "\n$indent<ul class=\"shp_navigation-submenu dropdown-menu\" aria-labelledby=\"categoriesDropdown\">\n";
            }

            function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
                if (!is_object($args)) {
                    return; // menu has not been configured
                }

                $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

                $li_attributes = '';
                $class_names = $value = '';

                $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
                $classes[] = 'shp_menu-item';


                $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
                $class_names = ' class="' . esc_attr( $class_names ) . '"';

                $output .= $indent . '<li' . $value . $class_names . $li_attributes . '>';

                $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
                $attributes .= ($args->has_children) 	    ? ' class="shp_menu-item-link dropdown-toggle" data-target="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="shp_menu-item-link"';

                $item_output = $args->before;
                $item_output .= '<a'. $attributes .'>';
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= ($args->has_children) ? ' <span class="caret"></span></a>' : '</a>';
                $item_output .= $args->after;

                $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }

            function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

                if ( !$element )
                    return;

                $id_field = $this->db_fields['id'];

                //display this element
                if ( is_array( $args[0] ) )
                    $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
                else if ( is_object( $args[0] ) )
                    $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
                $cb_args = array_merge( array(&$output, $element, $depth), $args);
                call_user_func_array(array(&$this, 'start_el'), $cb_args);

                $id = $element->$id_field;

                // descend only when the depth is right and there are childrens for this element
                if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

                    foreach( $children_elements[ $id ] as $child ){

                        if ( !isset($newlevel) ) {
                            $newlevel = true;
                            //start the child delimiter
                            $cb_args = array_merge( array(&$output, $depth), $args);
                            call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                        }
                        $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
                    }
                    unset( $children_elements[ $id ] );
                }

                if ( isset($newlevel) && $newlevel ){
                    //end the child delimiter
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
                }

                //end this element
                $cb_args = array_merge( array(&$output, $element, $depth), $args);
                call_user_func_array(array(&$this, 'end_el'), $cb_args);
            }
        }
    }
endif;
add_action( 'after_setup_theme', 'main_menu_setup' );

/**
 * Load site scripts
 */
function shoptet_theme_enqueue_scripts() {
	$template_url = get_template_directory_uri();

    wp_enqueue_script('shp-jquery', $template_url . '/src/dist/js/build.js');

	//Main Style
	wp_enqueue_style('shoptet', get_template_directory_uri() . '/src/dist/css/shoptet.css');
	wp_enqueue_style('default', get_template_directory_uri() . '/src/dist/css/main.css');
}
add_action( 'wp_enqueue_scripts', 'shoptet_theme_enqueue_scripts', 1 );

/* Disable favicon uploader - Shoptet favicon will be the same everywhere */
function remove_custom_favicon_option($wp_customize) {
    $wp_customize->remove_control('site_icon');
}
add_action( 'customize_register', 'remove_custom_favicon_option', 20, 1 );

/* Add Shoptet favicon */
function shp_add_favicon(){ ?>
    <!-- Custom Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/scaffolding/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/scaffolding/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/scaffolding/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/scaffolding/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/scaffolding/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
<?php }
add_action('wp_head','shp_add_favicon');

/**
 * Load Shoptet footer
 */
function get_shoptet_footer() {
    // params
    $id = (get_theme_mod( 'footer_id_setting' )) ? get_theme_mod( 'footer_id_setting' ) : 'shoptetcz';
    $temp = 'wp-content/themes/shoptet-wp-theme/tmp/shoptet-footer.html';

    $url = 'https://www.shoptet.cz/action/ShoptetFooter/render/';
    $cache = 24 * 60 * 60;
    $probability = 50;
    $ignoreTemp = isset($_GET['force_footer']);

    // code
    $footer = '';
    if (!$ignoreTemp && is_readable($temp)) {
        $footer = file_get_contents($temp);
        $regenerate = rand(1, $probability) === $probability;
        if (!$regenerate) {
            return $footer;
        }
        $mtine = filemtime($temp);
        if ($mtine + $cache > time()) {
            return $footer;
        }
    }

    $address = $url . '?id=' . urlencode($id);
    $new = file_get_contents($address);
    if ($new !== FALSE) {
        $newTemp = $temp . '.new';
        $length = strlen($new);
        $result = file_put_contents($newTemp, $new);
        if ($result === $length) {
            rename($newTemp, $temp);
        }
        $footer = $new;
    }

    return $footer;
}
add_filter( 'get_shoptet_footer', 'get_shoptet_footer' );

/**
 * Register widgets
 */
function arphabet_widgets_init() {
    register_sidebar( array(
        'name'          => 'Contact form',
        'id'            => 'contact_form',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );

/* Custom Pagination for posts */
function shp_wp_custom_pagination() {
    $template = '<h2 class="sr-only">%2$s</h2>'
        . '<nav class="%1$s" role="navigation">%3$s</nav>';
    return $template;
}
add_filter('navigation_markup_template', 'shp_wp_custom_pagination');

/* Shoptet Post navigation buttons with button class */
function post_link_attributes_prev($output) {
    $code = 'class="btn btn-primary"';
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}
function post_link_attributes_next($output) {
    $code = 'class="btn btn-primary"';
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}
add_filter('previous_post_link', 'post_link_attributes_prev');
add_filter('next_post_link', 'post_link_attributes_next');

/* Shoptet Comment form inputs reformat (comment textarea will be last instead of first ) */
function move_comment_field( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'move_comment_field' );

/* Shoptet WP Theme Customizer  */
function shp_wp_theme_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'shp_wp_theme_custom_logo_setup' );

/* Shoptet WP General Settings Customizer  */
function shp_wp_customizer($wp_customize) {
    $wp_customize->add_section('shp_wp_general_settings', array(
        'title'          => 'Shoptet WP General Settings'
    ));

    $wp_customize->add_setting('footer_id_setting', array(
        'default'        => 'shoptetcz',
    ));

    $wp_customize->add_control('footer_id_setting', array(
        'label'   => 'Footer ID',
        'section' => 'shp_wp_general_settings',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'shp_wp_customizer');

/* Shoptet WP Category Image Term Meta  */
/* can be improved by setting up media uploader, now works as a text field */
function shp_register_meta() {
    $shp_register_meta = array(
        'type' => 'string',
        'description' => 'Category Image',
        'single' => true,
        'show_in_rest' => true,
    );
    register_meta( 'term', 'category_image', $shp_register_meta );
}
add_action( 'init', 'shp_register_meta' );

function shp_new_term_category_image_field() {

    wp_nonce_field( basename( __FILE__ ), 'shp_term_category_image_nonce' ); ?>

    <div class="form-field shp_term-category-image-wrap">
        <label for="shp_term-category-image"><?php _e( 'Obrázek kategorie', 'shp' ); ?></label>
        <input type="text" name="shp_term_category_image" id="shp_term-category-image" value="" class="shp_category-image-field" data-default-category-image="http://localhost/blog/wp-content/uploads/2018/06/marketing.svg" />
    </div>
<?php }
add_action( 'category_add_form_fields', 'shp_new_term_category_image_field' );

function shp_edit_term_category_image_field( $term ) {

    $default = get_template_directory_uri() . '/src/dist/img/defaultCategoryImage.svg';
    $category_image   = get_term_meta(  $term->term_id, 'category_image', true );

    if ( ! $category_image )
        $category_image = $default; ?>

    <tr class="form-field shp_term-category-image-wrap">
        <th scope="row"><label for="shp_term-category-image"><?php _e( 'Obrázek kategorie', 'shp' ); ?></label></th>
        <td>
            <?php wp_nonce_field( basename( __FILE__ ), 'shp_term_category_image_nonce' ); ?>
            <input type="text" name="shp_term_category_image" id="shp_term-category-image" value="<?php echo esc_attr( $category_image ); ?>" class="shp_category-image-field" data-default-category-image="<?php echo esc_attr( $default ); ?>" />
        </td>
    </tr>
<?php }
add_action( 'category_edit_form_fields', 'shp_edit_term_category_image_field' );

function shp_save_term_category_image( $term_id ) {

    if ( ! isset( $_POST['shp_term_category_image_nonce'] ) || ! wp_verify_nonce( $_POST['shp_term_category_image_nonce'], basename( __FILE__ ) ) )
        return;

    $old_category_image = get_term_meta( $term_id, 'category_image', true );
    $new_category_image = isset( $_POST['shp_term_category_image'] ) ? $_POST['shp_term_category_image'] : '';

    if ( $old_category_image && '' === $new_category_image )
        delete_term_meta( $term_id, 'category_image' );

    else if ( $old_category_image !== $new_category_image )
        update_term_meta( $term_id, 'category_image', $new_category_image );
}
add_action( 'edit_category',   'shp_save_term_category_image' );
add_action( 'create_category', 'shp_save_term_category_image' );

/* Check whether gravatar is real or default image */
function validate_gravatar($email) {
    // Craft a potential url and test its headers
    $hash = md5(strtolower(trim($email)));
    $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
    $headers = @get_headers($uri);
    if (!preg_match("|200|", $headers[0])) {
        $has_valid_avatar = FALSE;
    } else {
        $has_valid_avatar = TRUE;
    }
    return $has_valid_avatar;
}
?>
