<?php

require __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function($name) {
    $file = __DIR__ . '/shoptet/' . $name . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}, TRUE, TRUE);

require_once 'src/functions.php';

add_theme_support( 'post-thumbnails' );

Shoptet\ShoptetUserRoles::init();
Shoptet\ShoptetSecurity::init();
Shoptet\ShoptetExternal::init();
Shoptet\ShoptetStats::init();
Shoptet\ShoptetPostCount::init();

/**
 * Load translations
 */
add_action( 'after_setup_theme', function () {
    load_theme_textdomain( 'shoptet', get_template_directory() . '/languages' );
} );

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
			echo '<li class="breadcrumb-item">' . get_the_title() .'</li>';
		}
	}
	elseif (is_tag()) { single_tag_title(); }
	elseif (is_day()) { echo '<li class="breadcrumb-item active">' . _e('Archive', 'shoptet') . ' ' . the_time('F jS, Y') . '</li>'; }
	elseif (is_month()) { echo '<li class="breadcrumb-item active">' . _e('Archive', 'shoptet') . ' ' . the_time('F, Y') . '</li>'; }
	elseif (is_year()) { echo '<li class="breadcrumb-item active">' . _e('Archive', 'shoptet') . ' ' . the_time('Y') . '</li>'; }
	elseif (is_author()) { echo '<li class="breadcrumb-item active">' . _e('Authors archive', 'shoptet') . '</li>'; }
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { echo '<li class="breadcrumb-item">' . _e('Blog archive', 'shoptet') . '</li>'; }
	elseif (is_search()) { echo '<li class="breadcrumb-item active">' . _e('Search results', 'shoptet') . '</li>'; }
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
                $output	   .= "\n$indent<ul class=\"shp_navigation-submenu dropdown-menu dropdown-menu-right\" aria-labelledby=\"categoriesDropdown\">\n";
            }

            function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
                if (!is_object($args)) {
                    return; // menu has not been configured
                }

                $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

                $li_attributes = '';
                $class_names = $value = '';

                if (!empty($item->classes)) {
                    foreach ($item->classes as $class) {
                        $classes[] = $class;
                    }
                }
                $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
                $classes[] = ($args->has_children) ? 'has-dropdown' : '';
                $classes[] = 'shp_menu-item';


                $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
                $class_names = ' class="' . esc_attr( $class_names ) . '"';

                $output .= $indent . '<li' . $value . $class_names . $li_attributes . '>';

                $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
                $attributes .= ' class="shp_menu-item-link"';

                $item_output = $args->before;
                $item_output .= '<a'. $attributes .'>';
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>';
                $item_output .= ($args->has_children) ? '<span class="caret dropdown-toggle" data-target="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>' : '';
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
	wp_enqueue_style('shoptet', get_template_directory_uri() . '/scaffolding/shoptet.css');
	wp_enqueue_style('default', get_template_directory_uri() . '/src/dist/css/main.css');
}
add_action( 'wp_enqueue_scripts', 'shoptet_theme_enqueue_scripts', 1 );

/**
 * Register widgets
 */
function shp_widgets_init() {
    register_widget( 'ShoptetSocialWidget' );
    register_sidebar( array(
        'name'          => 'Contact form',
        'id'            => 'contact_form',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => 'Page Bottom Widget',
        'id'            => 'page_bottom_widget',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
    ) );
    register_sidebar( array(
        'name'          => 'Post Bottom Widget',
        'id'            => 'post_bottom_widget',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
    ) );
}
add_action( 'widgets_init', 'shp_widgets_init' );

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
        <label for="shp_term-category-image"><?php _e( 'Image of category', 'shoptet' ); ?></label>
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
        <th scope="row"><label for="shp_term-category-image"><?php _e( 'Image of category', 'shoptet' ); ?></label></th>
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

/*
Shortcode for bootstrap alerts
[shp_bootstrap_alert type="info" icon="true" heading="Ea possunt paria non esse" dismissible="true"]Atqui iste locus est, Piso, tibi etiam atque etiam confirmandus, inquam[/shp_bootstrap_alert]
*/
function shp_bootstrap_alert( $atts, $shortcode_content ) {
    $content = '';

    if($shortcode_content) {
        $types = array(
            'warning' => 'fas fa-exclamation-circle',
            'danger' => 'fas fa-times-circle',
            'success' => 'fas fa-check-circle',
            'info' => 'fas fa-lightbulb'
        );
        $dismissible = ($atts['dismissible']) ? 'alert-dismissible fade show' : '';
        $content .= '<div class="alert alert-' . $atts['type'] . ' ' . $dismissible . '" role="alert">';

        if($atts['dismissible'] && $atts['dismissible'] == 'true') {
            $content .= '<button type="button" class="close" data-dismiss="alert" aria-label="' . __('Close', 'shoptet') . '"><span aria-hidden="true">&times;</span></button>';
        }

        if($atts['icon'] && $atts['icon'] == 'true') {
            $content .= '<div class="row"><div class="col-2 col-lg-1 text-center"><i class="alert-icon ' . $types[$atts['type']] . '"></i></div><div class="col-10 col-lg-11">';
        } else {
            $content .= '<div class="row"><div class="col-12">';
        }

        if($atts['heading']) {
            $content .= '<h4 class="alert-heading">' . $atts['heading'] . '</h4>';
        }

        $content .= $shortcode_content . '</div></div><!-- !.row --></div>';
    }
    return $content;
}
add_shortcode( 'shp_bootstrap_alert', 'shp_bootstrap_alert' );
