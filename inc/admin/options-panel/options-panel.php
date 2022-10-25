<?php
// add_menu_page
add_action( 'admin_menu', 'msbr_add_menu_page' );
function msbr_add_menu_page() {
    // add parent settings page only if not added by other plugin from us
    if( empty( $GLOBALS['admin_page_hooks']['mswebarts-overview'] ) ) {
        add_menu_page(
            'MS Web Arts Overview',
            'MS Web Arts',
            'manage_options',
            'mswebarts-overview',
            'msbr_overview_page',
            'dashicons-book-alt',
            100
        );
    }
    // add sub menu page
    add_submenu_page(
        'mswebarts-overview',
        'Breview General Settings',
        'Breview',
        'manage_options',
        'breview-settings',
        'msbr_breview_general_settings_page'
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
function msbr_overview_page() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/overview.php';
}

function msbr_breview_general_settings_page() {
    global $msbr_dir, $msbr_options;

    // check if form submitted
    if( isset( $_POST['msbr_general_form_submitted'] ) ) {
        $submitted = $_POST['msbr_general_form_submitted'];

        // if submitted is set to Y
        if( $submitted == 'Y' ) {

            // check if checkbox is set
            if( isset( $_POST['msbr_display_add_review_product'] ) ) {
                $display_add_review_on_product = $_POST['msbr_display_add_review_product'];
            } else {
                $display_add_review_on_product = 0;
            }

            // assign value to array
            $msbr_options['msbr_display_add_review_product'] = $display_add_review_on_product;

            // save options
            update_option( 'msbr_general_options', $msbr_options );
        }
    }

    // retrive the options to use in general.php
    $msbr_options = get_option( 'msbr_general_options' );
    
    if( $msbr_options != '' ) {
        $display_add_review_on_product = $msbr_options['msbr_display_add_review_product'];
    }

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