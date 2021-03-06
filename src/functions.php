<?php

require_once( get_stylesheet_directory() . '/includes/e-wacker-child-nav-menus-class.php');
require_once( get_stylesheet_directory() . '/includes/widgets/e-wacker-child-widgets-class.php');
require_once( get_stylesheet_directory() . '/includes/acf/e-wacker-child-acf-class.php');

/**
 * Child Theme Nav Menus
 */

 if ( class_exists( 'E_Wacker_Nav_Menus' ) ) {
   new E_Wacker_Nav_Menus();
 }

/**
 * Child Theme Widgets
 */

if ( class_exists( 'E_Wacker_Widgets' ) ) {
  new E_Wacker_Widgets();
}

/**
 * Child Theme ACF
 */

 if ( class_exists( 'E_Wacker_ACF' ) ) {
   new E_Wacker_ACF();
 }

/**
 * The excerpt
 */
function wacker_excerpt_more($more) {
  global $post;
	return '...';
}
add_filter('excerpt_more', 'wacker_excerpt_more');


/**
 * Torque map
 */

 // add api key for torque map
 add_filter( 'torque_map_api_key', function($k) {
   return 'AIzaSyDPF2QsUSJKHsmGoPcjIgRySglSZgD-asA';
 });
 // add allowed pois for theme
 add_filter( 'torque_map_pois_allowed', function($n) {
   return 5;
 });
 // whether to display the POI list or not
 add_filter( 'torque_map_display_pois_list', function($n) {
   return true;
 });
 // display pois below map and above pois list
 add_filter( 'torque_map_pois_location', function($n) {
   return 'middle';
 });



/**
* Admin settings
*/

// remove menu items
function torque_remove_menus(){

  //remove_menu_page( 'index.php' );                  //Dashboard
  //remove_menu_page( 'edit.php' );                   //Posts
  //remove_menu_page( 'upload.php' );                 //Media
  //remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  //remove_menu_page( 'themes.php' );                 //Appearance
  //remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                  //Users
  //remove_menu_page( 'tools.php' );                  //Tools
  //remove_menu_page( 'options-general.php' );        //Settings

}
add_action( 'admin_menu', 'torque_remove_menus' );



// enqueue child styles after parent styles, both style.css and main.css
// so child styles always get priority
add_action( 'wp_enqueue_scripts', 'torque_enqueue_child_styles' );
function torque_enqueue_child_styles() {

    $parent_style = 'parent-styles';
    $parent_main_style = 'torque-theme-styles';

    // make sure parent styles enqueued first
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( $parent_main_style, get_template_directory_uri() . '/bundles/main.css' );

    // enqueue child style
    wp_enqueue_style( 'e-wacker-child-styles',
        get_stylesheet_directory_uri() . '/bundles/main.css',
        array( $parent_style, $parent_main_style ),
        wp_get_theme()->get('Version')
    );
}

// enqueue child scripts after parent script
add_action( 'wp_enqueue_scripts', 'torque_enqueue_child_scripts');
function torque_enqueue_child_scripts() {

    wp_enqueue_script( 'e-wacker-child-script',
        get_stylesheet_directory_uri() . '/bundles/bundle.js',
        array( 'torque-theme-scripts' ), // depends on parent script
        wp_get_theme()->get('Version'),
        true       // put it in the footer
    );
}

?>
