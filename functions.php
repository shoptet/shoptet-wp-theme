<?php
spl_autoload_register(function($name) {
    $file = __DIR__ . '/shoptet/' . $name . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}, TRUE, TRUE);

require_once 'src/functions.php';

/**
 * Custom WordPress navigation
 */
add_action( 'after_setup_theme', 'main_menu_setup' );
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

/**
 * Load site scripts
 */
function shoptet_theme_enqueue_scripts() {
	$template_url = get_template_directory_uri();

    wp_enqueue_script('shp-jquery', $template_url . '/src/dist/js/build.js');

	//Main Style
	wp_enqueue_style('default', get_template_directory_uri() . '/src/dist/css/main.css');
}
add_action( 'wp_enqueue_scripts', 'shoptet_theme_enqueue_scripts', 1 );

/**
 * Load Shoptet footer
 */
function get_shoptet_footer() {
    // params
    $id = 'shoptetcz';
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
        'name'          => 'Test widget',
        'id'            => 'test_1',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
}

add_filter('widget_title', 'test_1');
function my_widget_title()
{
    return null;
}
add_action( 'widgets_init', 'arphabet_widgets_init' );

add_filter('show_admin_bar', '__return_false');
add_theme_support( 'post-thumbnails' );

?>