<?php

/**
 * Plugin Name: Breview - Better Review System for WooCommerce
 * Description: The way reviews should be handled in every WooCommerce websites just like the traditional marketplaces.
 * Version: 1.1.0
 * Plugin URI: https://www.mswebarts.com/plugins/breview/
 * Author: MS Web Arts
 * Author URI: https://www.mswebarts.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Tested up to: 6.1.1
 * Requires at least: 5.5
 * Requires PHP: 7.4
 * Text Domain: breview
 * Domain Path: /languages
 * 
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MSBR_DIR', plugin_dir_path(__FILE__));
define('BREVIEW_PACKAGE', 'FREE');

global $msbr_dir, $msbr_url, $msbr_options;
$msbr_dir = plugin_dir_path(__FILE__);
$msbr_url = plugins_url('/', __FILE__);
$msbr_options = array();

// Check if woocommerce is installed

add_action('plugins_loaded', 'msbr_on_plugin_load');
function msbr_on_plugin_load() {
    global $msbr_dir;

    if (!defined('WC_VERSION')) {
        add_action('admin_notices', 'msbr_woocommerce_dependency_error');
        return;
    }

    if (BREVIEW_PACKAGE == 'PRO') {
        add_action('admin_notices', 'msbr_pro_package_already_installed');
        return;
    }

    // include plugin files
    require_once $msbr_dir . 'inc/init.php';
}

function msbr_woocommerce_dependency_error() {
    $class = 'notice notice-error';
    $message = __('You must need to install and activate woocommerce for Breview to work', 'breview');

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}

function msbr_pro_package_already_installed() {
    $class = 'notice notice-error';
    $message = __('You have the Breview Pro version already installed. You don\'t need the free version. You can safely deactivate and remove it.', 'breview');

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}

add_action("wp_enqueue_scripts", "msbr_register_styles");
function msbr_register_styles() {
    // register and enqueue javascript
    wp_register_script('msbr-star-rating', plugins_url('assets/js/star-rating.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_register_script('msbr-star-rating-svg', plugins_url('assets/js/jquery.star-rating-svg.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_register_script('msbr-iziModal', plugins_url('assets/js/iziModal.min.js', __FILE__), array('jquery'), '1.0.0', true);
    wp_register_script('msbr-pagination', plugins_url('assets/js/pagination.min.js', __FILE__), array('jquery'), '1.0.0', true);
    wp_register_script('msbr-jquery-validate', plugins_url('assets/js/jquery.validate.min.js', __FILE__), array('jquery'), '1.0.0', true);
    wp_register_script('msbr-script', plugins_url('assets/js/main.js', __FILE__), array('jquery'), '1.0.0', true);

    wp_enqueue_script('msbr-star-rating');
    wp_enqueue_script('msbr-star-rating-svg');
    wp_enqueue_script('msbr-iziModal');
    wp_enqueue_script('msbr-pagination');
    wp_enqueue_script('msbr-jquery-validate');
    wp_enqueue_script('msbr-script');

    // pass review data to javascript
    $msbr_options    = get_option('msbr_general_options');
    $title_min_char  = isset($msbr_options['msbr_review_form_title_min_char']) ? $msbr_options['msbr_review_form_title_min_char'] : 10;
    $title_max_char  = isset($msbr_options['msbr_review_form_title_max_char']) ? $msbr_options['msbr_review_form_title_max_char'] : 100;
    $desc_min_char   = isset($msbr_options['msbr_review_form_desc_min_char']) ? $msbr_options['msbr_review_form_desc_min_char'] : 30;
    $desc_max_char   = isset($msbr_options['msbr_review_form_desc_max_char']) ? $msbr_options['msbr_review_form_desc_max_char'] : 300;

    $translation_array = array(
        'title_min_char'             => esc_html($title_min_char),
        'title_max_char'             => esc_html($title_max_char),
        'min_char'                   => esc_html($desc_min_char),
        'max_char'                   => esc_html($desc_max_char),
        'review_list_design'         => esc_html($msbr_options['msbr_review_list_design']),
        'min_char_msg'               => wp_sprintf(__('Your review must be minimum %s characters long', 'breview'), $desc_min_char),
        'max_char_msg'               => wp_sprintf(__('Your review must be maximum %s characters long', 'breview'), $desc_max_char),
        'review_empty_msg'           => esc_html__('Review description is required', 'breview'),
        'rating_tooltip'             => esc_html__('Select a rating', 'breview'),
        'rating_empty_msg'           => esc_html__('Rating is required', 'breview'),
        'review_sub_msg'             => esc_html__('Submitting...', 'breview'),
        'review_sub_err_msg'         => _x(' occured. Please refresh the page and try again.', 'name of error at the start', 'breview'),
        'review_list_loading_msg'    => esc_html__('Loading...', 'breview'),
        'review_sub_success_btn_msg' => esc_html__('Submitted!', 'breview'),
    );
    wp_localize_script('msbr-script', 'msbr_review', $translation_array);

    // register and enqueue css
    wp_register_style('msbr-star-rating', plugins_url('assets/css/star-rating.min.css', __FILE__));
    wp_register_style('msbr-star-rating-svg', plugins_url('assets/css/star-rating-svg.css', __FILE__));
    wp_register_style("msbr-iziModal", plugins_url("assets/css/iziModal.min.css", __FILE__));
    wp_register_style("msbr-style", plugins_url("style.css", __FILE__));
    wp_register_style("msbr-responsive", plugins_url("assets/css/responsive.css", __FILE__));
    wp_register_style("msbr-inline", plugins_url("assets/css/inline.css", __FILE__));

    wp_enqueue_style('msbr-star-rating');
    wp_enqueue_style('msbr-star-rating-svg');
    wp_enqueue_style("msbr-iziModal");
    wp_enqueue_style("msbr-style");
    wp_enqueue_style("msbr-responsive");
    wp_enqueue_style("msbr-inline");

    $avatar_size = $msbr_options['msbr_reviewer_avatar_size'];
    $custom_css = "
        .woocommerce .woocommerce-Tabs-panel--msbr_reviews ol.commentlist li .comment_container .comment-text,
        .msbr-show-review-modal ol.commentlist li .comment_container .comment-text {
            width: calc(100% - {$avatar_size}px - 10px);
        }
    ";
    wp_add_inline_style('msbr-inline', $custom_css);
}

// add_menu_page
add_action('admin_menu', 'msbr_add_menu_page');
function msbr_add_menu_page() {
    global $msbr_url;
    // add parent settings page only if not added by other plugin from us
    if (empty($GLOBALS['admin_page_hooks']['mswebarts-overview'])) {
        add_menu_page(
            'MS Web Arts Overview',
            'MS Web Arts',
            'manage_options',
            'mswebarts-overview',
            'msbr_overview_page',
            $msbr_url . 'inc/admin/assets/images/icon.png',
            100
        );

        // add sub menu pages
        add_submenu_page(
            'mswebarts-overview',
            'Breview General Settings',
            'Breview',
            'manage_options',
            'breview-settings',
            'msbr_breview_general_settings_page'
        );

        add_submenu_page(
            'breview-settings',
            'Breview Multi Star-rating Settings',
            'Multi Star-rating',
            'manage_options',
            'breview-multi-rating-settings',
            'msbr_breview_multi_rating_settings_page'
        );

        add_submenu_page(
            'breview-settings',
            'Breview Style Settings',
            'Style',
            'manage_options',
            'breview-style-settings',
            'msbr_breview_style_settings_page'
        );

        add_submenu_page(
            'breview-settings',
            'Breview Email Settings',
            'Emails',
            'manage_options',
            'breview-email-settings',
            'msbr_breview_email_settings_page'
        );
    }
}

function msbr_overview_page() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/overview.php';
}
add_action('mswa_overview_sidebar', 'msbr_overview_sidebar', 10);
function msbr_overview_sidebar() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/overview-sidebar.php';
}

// add admin styles and js
add_action('admin_enqueue_scripts', 'msbr_admin_styles');
function msbr_admin_styles() {
    global $msbr_url;
    wp_register_style('msbr-sweetalert2', $msbr_url . 'inc/admin/assets/css/sweetalert2.min.css');
    wp_register_style("msbr-admin-style", $msbr_url . 'inc/admin/assets/css/style.css');
    wp_enqueue_style("msbr-sweetalert2");
    wp_enqueue_style("msbr-admin-style");
}
add_action('admin_enqueue_scripts', 'msbr_admin_js');
function msbr_admin_js() {
    global $msbr_url;
    wp_register_script('msbr-jquery-repeater', $msbr_url . 'inc/admin/assets/js/jquery.repeater.min.js', array('jquery'), '1.0.0', true);
    wp_register_script('msbr-sweetalert2', $msbr_url . 'inc/admin/assets/js/sweetalert2.all.min.js', array('jquery'), '1.0.0', true);
    wp_register_script('msbr-admin-script', $msbr_url . 'inc/admin/assets/js/script.js', array('jquery', 'msbr-jquery-repeater', 'msbr-sweetalert2'), '1.0.0', true);
}

// load translations
add_action('init', 'msbr_load_textdomain');
function msbr_load_textdomain() {
    load_plugin_textdomain('breview', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
