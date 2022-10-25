<?php
/**
 * Plugin Name: WC Better Review
 * Description: This plugin enables the order approval by Customers for woocommerce. The customers can change the order status/approve the order when it has order status set as Delivered.
 * Version:     1.2.1
 * Author:      MS Web Arts
 * Author URI:  https://www.mswebarts.com/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: breview

WC Better Review is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
WC Better Review is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with WC Better Review. If not, see {License URI}.
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $msbr_dir;
$msbr_dir = plugin_dir_path( __FILE__ );
// Check if woocommerce is installed

add_action('plugins_loaded', 'msbr_check_for_woocommerce');
function msbr_check_for_woocommerce() {
    if ( !defined('WC_VERSION') ) {
        add_action( 'admin_notices', 'msbr_woocommerce_dependency_error' );
        return;
    }
}

function msbr_woocommerce_dependency_error() {
    $class = 'notice notice-error';
    $message = __( 'You must need to install and activate woocommerce for WC Better Review to work', 'breview' );

    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

add_action( "wp_enqueue_scripts", "msbr_register_styles" );
function msbr_register_styles() {
    // register and enqueue javascript
    wp_register_script( 'msbr-star-rating', plugins_url( 'assets/js/star-rating.min.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_register_script( 'msbr-magnific-popup', plugins_url( 'assets/js/jquery.magnific-popup.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
    wp_register_script( 'msbr-pagination', plugins_url( 'assets/js/pagination.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
    wp_register_script( 'msbr-script', plugins_url( 'assets/js/main.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );

    wp_enqueue_script( 'msbr-star-rating' );
    wp_enqueue_script( 'msbr-magnific-popup' );
    wp_enqueue_script( 'msbr-pagination' );
    wp_enqueue_script( 'msbr-script' );

    // pass review data to javascript
    // TODO: error message setting
    $translation_array = array(
        'review_empty_msg' => __( 'Review can\'t be empty testing', 'breview' ),
        'max_char_msg'     => __( 'Review can\'t be more than 300 characters testing', 'breview' ),
    );
    wp_localize_script( 'msbr-script', 'msbr_review', $translation_array );

    // register and enqueue css
    wp_register_style( 'msbr-star-rating', plugins_url( 'assets/css/star-rating.min.css', __FILE__ ) );
    wp_register_style( 'msbr-magnific-popup', plugins_url( 'assets/css/magnific-popup.css', __FILE__ ) );
    wp_register_style( "msbr-style", plugins_url( "style.css", __FILE__ ) );

    wp_enqueue_style( 'msbr-star-rating' );
    wp_enqueue_style( 'msbr-magnific-popup' );
    wp_enqueue_style( "msbr-style" );
}

// add admin styles
add_action( 'admin_enqueue_scripts', 'msbr_admin_styles' );
function msbr_admin_styles() {
    wp_register_style( "msbr-admin-style", plugins_url( "inc/admin/assets/css/style.css", __FILE__ ) );
    wp_enqueue_style( "msbr-admin-style" );
}

register_activation_hook( __FILE__, 'msbr_initialization' );
function msbr_initialization() {
    do_action( 'msbr_init' );
}

add_action( 'plugins_loaded', 'msbr_include_files' );
function msbr_include_files() {
    global $msbr_dir;
    // include plugin files
    include_once $msbr_dir . 'inc/init.php';
}