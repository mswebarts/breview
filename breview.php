<?php
/**
 * Plugin Name: Breview - Better Review System for WooCommerce
 * Description: Breview is a review plugin for WooCommerce. It changes the way customers review your products and services. Customers can only add reviews from the order page once the order gets completed
 * Version: 1.0.1
 * Plugin URI: https://www.mswebarts.com/plugins/breview/
 * Author: MS Web Arts
 * Author URI: https://www.mswebarts.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.6
 * Requires PHP: 7.0
 * Text Domain: breview
 * Domain Path: /languages
 * 
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $msbr_dir, $msbr_url, $msbr_options;
$msbr_dir = plugin_dir_path( __FILE__ );
$msbr_url = plugins_url( '/', __FILE__ );
$msbr_options = array();

// Check if woocommerce is installed

add_action('plugins_loaded', 'msbr_on_plugin_load');
function msbr_on_plugin_load() {
    global $msbr_dir;

    if ( !defined('WC_VERSION') ) {
        add_action( 'admin_notices', 'msbr_woocommerce_dependency_error' );
        return;
    }

    // include plugin files
    include_once $msbr_dir . 'inc/classes/class-msbr-lic.php';
}

function msbr_woocommerce_dependency_error() {
    $class = 'notice notice-error';
    $message = __( 'You must need to install and activate woocommerce for Breview to work', 'breview' );

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
    $msbr_options = get_option( 'msbr_general_options' );
    $max_char     = isset( $msbr_options['msbr_review_form_max_char'] ) ? $msbr_options['msbr_review_form_max_char'] : 300;

    $translation_array = array(
        'review_empty_msg' => esc_html__( 'Review can\'t be empty', 'breview' ),
        'max_char_msg'     => wp_sprintf( __( 'Review can\'t be more than %s characters', 'breview' ), $max_char ),
        'max_char'         => esc_html( $max_char ),
    );
    wp_localize_script( 'msbr-script', 'msbr_review', $translation_array );

    // register and enqueue css
    wp_register_style( 'msbr-star-rating', plugins_url( 'assets/css/star-rating.min.css', __FILE__ ) );
    wp_register_style( 'msbr-magnific-popup', plugins_url( 'assets/css/magnific-popup.css', __FILE__ ) );
    wp_register_style( "msbr-style", plugins_url( "style.css", __FILE__ ) );
    wp_register_style( "msbr-inline", plugins_url( "assets/css/inline.css", __FILE__ ) );

    wp_enqueue_style( 'msbr-star-rating' );
    wp_enqueue_style( 'msbr-magnific-popup' );
    wp_enqueue_style( "msbr-style" );
    wp_enqueue_style( "msbr-inline" );

    $avatar_size = $msbr_options['msbr_reviewer_avatar_size'];
    $custom_css = "
        .woocommerce .woocommerce-Tabs-panel--msbr_reviews #reviews #comments ol.commentlist li img.avatar,
        .msbr-show-review-modal ol.commentlist li .comment_container > img {
                width: {$avatar_size}px;
        }
        .woocommerce .woocommerce-Tabs-panel--msbr_reviews ol.commentlist li .comment_container .comment-text,
        .msbr-show-review-modal ol.commentlist li .comment_container .comment-text {
            width: calc(100% - {$avatar_size}px - 10px);
        }
    ";
    wp_add_inline_style( 'msbr-inline', $custom_css );
}

// add_menu_page
add_action( 'admin_menu', 'msbr_add_menu_page' );
function msbr_add_menu_page() {
    global $msbr_url;
    // add parent settings page only if not added by other plugin from us
    if( empty( $GLOBALS['admin_page_hooks']['mswebarts-overview'] ) ) {
        add_menu_page(
            'MS Web Arts Overview',
            'MS Web Arts',
            'manage_options',
            'mswebarts-overview',
            'msbr_overview_page',
            $msbr_url . 'inc/admin/assets/images/icon.png',
            100
        );
    }
}
function msbr_overview_page() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/overview.php';
}
add_action( 'mswa_overview_sidebar', 'msbr_overview_sidebar', 10 );
function msbr_overview_sidebar() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/overview-sidebar.php';
}

// add admin styles and js
add_action( 'admin_enqueue_scripts', 'msbr_admin_styles' );
function msbr_admin_styles() {
    wp_register_style( "msbr-admin-style", plugins_url( "inc/admin/assets/css/style.css", __FILE__ ) );
    wp_enqueue_style( "msbr-admin-style" );
}
add_action( 'admin_enqueue_scripts', 'msbr_admin_js' );
function msbr_admin_js() {
    global $msbr_url;
    wp_register_script( 'msbr-jquery-repeater', $msbr_url . 'inc/admin/assets/js/jquery.repeater.min.js', array( 'jquery' ), '1.0.0', true );
    wp_register_script( 'msbr-admin-script', $msbr_url . 'inc/admin/assets/js/main.js', array( 'jquery', 'msbr-jquery-repeater' ), '1.0.0', true );
}

// load translations
add_action( 'init', 'msbr_load_textdomain' );
function msbr_load_textdomain() {
	load_plugin_textdomain( 'breview', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}