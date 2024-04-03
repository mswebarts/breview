<?php

/**
 * Plugin Name: Breview - Order Reviews for WooCommerce
 * Description: Collect and display customer reviews on your WooCommerce store. Breview allows customers to leave reviews on the order received page and display them on the product page.
 * Version: 1.2.3
 * Plugin URI: https://www.mswebarts.com/products/breview/
 * Author: MS Web Arts
 * Author URI: https://www.mswebarts.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Tested up to: 6.5
 * Requires at least: 5.5
 * Requires PHP: 7.4
 * Text Domain: breview
 * Domain Path: /languages
 * 
 */

if (!defined('ABSPATH')) {
    exit;
}

if(!defined('MSBR_DIR')) {
    define('MSBR_DIR', plugin_dir_path(__FILE__));
}

require MSBR_DIR . '/vendor/autoload.php';

global $msbr_dir, $msbr_url, $msbr_options;
$msbr_dir = plugin_dir_path(__FILE__);
$msbr_url = plugins_url('/', __FILE__);
$msbr_options = array();

// setup appsero
function appsero_init_tracker_breview() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
      require_once __DIR__ . '/appsero/src/Client.php';
    }

    $client = new Appsero\Client( 'd56c64db-6495-4fdd-a72b-7ac221d8aaf5', 'Breview - Order reviews for WooCommerce', __FILE__ );

    // Active insights
    $client->insights()->init();

}
appsero_init_tracker_breview();

class MSBR_Lite {
    public function __construct() {
        register_activation_hook(__FILE__, array($this, 'breview_free_activation'));
        add_action('plugins_loaded', array($this, 'msbr_on_plugin_load'));
        add_action("wp_enqueue_scripts", array($this, 'msbr_register_styles'));
        add_action('admin_menu', array($this, 'msbr_add_menu_page'));
        add_action('mswa_overview_content', array($this, 'msbr_overview_content'), 10);
        add_action('mswa_overview_sidebar', array($this, 'msbr_overview_sidebar'), 10);
        add_action('admin_enqueue_scripts', array($this, 'msbr_admin_styles'));
        add_action('admin_enqueue_scripts', array($this, 'msbr_admin_js'));
        add_action('init', array($this, 'msbr_load_textdomain'));
    }

    public function breview_free_activation() {
        // Check if the Pro version of the plugin is active
        if (class_exists('MSBR_Pro')) {
            // Deactivate the free version
            deactivate_plugins(plugin_basename(__FILE__));

            // Throw an error and prevent the free version from activating
            wp_die(__('The Pro version of Breview is active. Please deactivate it before activating the free version.', 'breview'));
        }
    }

    public static function msbr_pro_activation() {
        // Check if the free version of the plugin is active
        if (is_plugin_active(plugin_basename(__FILE__))) {
            // Deactivate the free version
            deactivate_plugins(plugin_basename(__FILE__));
        }
    }

    public function msbr_on_plugin_load() {
        global $msbr_dir;

        // Check if woocommerce is installed
        if (!defined('WC_VERSION')) {
            add_action('admin_notices', array($this, 'msbr_woocommerce_dependency_error'));
            return;
        }

        // include plugin files
        require_once $msbr_dir . 'inc/init.php';
    }

    public function msbr_woocommerce_dependency_error() {
        $class = 'notice notice-error';
        $message = __('You must need to install and activate woocommerce for Breview to work', 'breview');

        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    }

    public function msbr_pro_dependency_error() {
        $class = 'notice notice-error';
        $message = __('Breview Pro is already installed and activated. You don\'t need the free version.', 'breview');

        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    }

    public function msbr_register_styles() {
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
    public function msbr_add_menu_page() {
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
    
    public function msbr_overview_content() {
        global $msbr_dir;
        include_once $msbr_dir . 'inc/admin/options-panel/pages/overview-content.php';
    }
    
    public function msbr_overview_sidebar() {
        global $msbr_dir;
        include_once $msbr_dir . 'inc/admin/options-panel/pages/overview-sidebar.php';
    }

    // add admin styles and js
    public function msbr_admin_styles() {
        global $msbr_url;
		wp_register_style( 'mswa-global-style', 'https://mswebarts.b-cdn.net/plugins-global/global.css' );
		wp_enqueue_style( 'mswa-global-style' );

        wp_register_style('msbr-sweetalert2', $msbr_url . 'inc/admin/assets/css/sweetalert2.min.css');
        wp_register_style("msbr-admin-style", $msbr_url . 'inc/admin/assets/css/style.css');
        wp_enqueue_style("msbr-sweetalert2");
        wp_enqueue_style("msbr-admin-style");
    }
    public function msbr_admin_js() {
        global $msbr_url;
        wp_register_script( 'mswa-jquery-repeater', 'https://mswebarts.b-cdn.net/plugins-global/jquery.repeater.min.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'mswa-global-script', 'https://mswebarts.b-cdn.net/plugins-global/global.js', array( 'jquery', 'mswa-jquery-repeater' ), '1.0.0', true );

        wp_register_script('msbr-sweetalert2', $msbr_url . 'inc/admin/assets/js/sweetalert2.all.min.js', array('jquery'), '1.0.0', true);
        wp_register_script('msbr-admin-script', $msbr_url . 'inc/admin/assets/js/script.js', array('jquery', 'mswa-jquery-repeater', 'mswa-global-script', 'msbr-sweetalert2'), '1.0.0', true);
    }

    // load translations
    public function msbr_load_textdomain() {
        load_plugin_textdomain('breview', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
}

new MSBR_Lite();