<?php
/*
Plugin Name: Best Cookies
Description: Plugin to show cookie popup with user custom settings.
Version: 1.1.0
Author: <a href="https://github.com/Brudj" target="_blank">Brudj</a>
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!defined('BESTCOOKIES_VERSION')){
    define('BESTCOOKIES_VERSION', '1.1.0');
}

//add our keys const
const best_cookie_settings = 'best_cookie_settings';

//hook for display on front end
function best_cookies_display() {
    include 'front_form.php';
}
//check if cookie is active
$best_cookie_settings = get_option(best_cookie_settings);
if( $best_cookie_settings['active'] ){
    add_action( 'wp_footer', 'best_cookies_display' );  
}

//include css and js for front end
function best_cookies_front_scripts() {
    wp_enqueue_style('front-style', plugin_dir_url( __FILE__ ) . 'css/front-style.css' );
    wp_register_script('cookie-js', plugin_dir_url(__FILE__) . '/js/best-cookies.js', array('jquery'), '1.0', true);
    wp_enqueue_script( 'cookie-js' );
}

//include css for back end
function best_cookies_admin_scripts() {
    wp_register_style('admin-cookie-css', plugins_url('/css/admin-style.css',__FILE__ ));
    wp_enqueue_style('admin-cookie-css');
}

//include wp color picker
function best_cookies_dashboard_scripts( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'best-cookies-color-picker', plugins_url('/js/cookie_color_picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    wp_enqueue_script( 'best-cookies-dashboard', plugins_url('/js/best-cookies-dashboard.js', __FILE__ ), false, false, true );
}

//register admin plugin page in settings
function best_cookies_register_page(){
    add_submenu_page( 'options-general.php', 'Best Cookies Page', 'Best Cookies', 'manage_options', 'best_cookies', 'best_cookies_page' );
}

//admin plugin page settings form
function best_cookies_page() {
    //check for submit and two most important values
    if ( intval($_POST['update_cookie']) && user_can(get_current_user_id(), 'manage_options') ){
        //allow only safe tags in $allowed tags
        $best_cookies_text = wp_kses( $_POST['text'], 'default' );
        $best_cookies_button = sanitize_text_field($_POST['button_text']);
        if( !empty($best_cookies_text) && !empty($best_cookies_button) ){
            update_option(best_cookie_settings, array(
                'active' => intval($_POST['active']),
                'title' => sanitize_text_field($_POST['title']),
                'text' => $best_cookies_text,
                'button_size' => sanitize_text_field($_POST['button_size']),
                'button_text' => $best_cookies_button,
                'color' => sanitize_text_field($_POST['color']),
                'position' => sanitize_text_field($_POST['position'])
            ));
        }
    }
    //show plugin page
    include 'admin_form.php';
}

//add Settings button to WordPress plugin page
function best_cookies_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=best_cookies.php">' . __( 'Settings' ) . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'best_cookies_settings_link' );

//add default values if plugin is activated
function best_cookies_install() {
    update_option('best_cookies_version', BESTCOOKIES_VERSION);
    //check for existing options
    $best_cookie_settings = get_option(best_cookie_settings);
    if( !$best_cookie_settings ){
        update_option(best_cookie_settings, array(
            'active' => $best_cookie_settings['active'] ?: 1,
            'title' => $best_cookie_settings['title'] ?: 'We use cookies to give you the best online experience',
            'text' => $best_cookie_settings['text'] ?: 'By using our website, you agree to our <a href="#">privacy policy</a>',
            'button_size' => $best_cookie_settings['button_size'] ?: 1,
            'button_text' => $best_cookie_settings['button_text'] ?: 'I Accept',
            'color' => $best_cookie_settings['color'] ?: '#333333',
            'position' => $best_cookie_settings['position'] ?: 1
        ));
    }
}

//delete values in plugin deactivates
function best_cookies_uninstall(){
    echo 'We hope you come back...';
    delete_option('best_cookies_version');
}

// Checks the version number
function best_cookies_check_activation() {
    if (BESTCOOKIES_VERSION !== get_option('best_cookies_version') ){
        best_cookies_install();
    }
}
add_action('plugins_loaded', 'best_cookies_check_activation');

add_action( 'wp_enqueue_scripts', 'best_cookies_front_scripts' );
add_action( 'admin_init','best_cookies_admin_scripts');
add_action( 'admin_enqueue_scripts', 'best_cookies_dashboard_scripts' );
add_action( 'admin_menu', 'best_cookies_register_page' );
add_action( 'init', 'best_cookies_install' );

register_activation_hook( __FILE__, 'best_cookies_install' );
register_deactivation_hook( __FILE__, 'best_cookies_uninstall' );