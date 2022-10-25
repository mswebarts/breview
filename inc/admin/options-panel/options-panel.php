<?php
// add_menu_page
add_action( 'admin_menu', 'msbr_add_menu_page' );
function msbr_add_menu_page() {
    // add parent settings page only if not added by other plugin from us
    if( empty( $GLOBALS['admin_page_hooks']['mswebarts-settings'] ) ) {
        add_menu_page(
            'MS Web Arts Overview',
            'MS Web Arts',
            'manage_options',
            'mswebarts-settings',
            'msbr_general_settings_page',
            'dashicons-book-alt',
            100
        );
    }
    // add sub menu page
    add_submenu_page(
        'mswebarts-settings',
        'Breview General Settings',
        'Breview',
        'manage_options',
        'breview-settings',
        'msbr_breview_settings_page'
    );
    // add sub menu page
    add_submenu_page(
        'breview-settings',
        'Breview Style Settings',
        'Style',
        'manage_options',
        'breview-style-settings',
        'msbr_breview_style_settings_page'
    );
    // add sub menu page
    add_submenu_page(
        'breview-settings',
        'Breview Email Settings',
        'Emails',
        'manage_options',
        'breview-email-settings',
        'msbr_breview_email_settings_page'
    );
}
function msbr_general_settings_page() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/settings.php';
}

function msbr_breview_settings_page() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/general.php';
}

function msbr_breview_style_settings_page() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/style.php';
}

function msbr_breview_email_settings_page() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/email.php';
}