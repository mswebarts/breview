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

            // display add review form
            if( isset( $_POST['msbr_display_add_review_product'] ) ) {
                $display_add_review_on_product = intval( $_POST['msbr_display_add_review_product'] );
            } else {
                $display_add_review_on_product = intval( 0 );
            }

            // review form max char
            if( isset( $_POST['msbr_review_form_max_char'] ) ) {
                $review_max_char = sanitize_text_field( $_POST['msbr_review_form_max_char'] );
            } else {
                $review_max_char = intval( 300 );
            }

            // reviewer avatar size
            if( isset( $_POST['msbr_reviewer_avatar_size'] ) ) {
                $reviewer_avatar_size = sanitize_text_field( $_POST['msbr_reviewer_avatar_size'] );
            } else {
                $reviewer_avatar_size = intval( 60 );
            }

            // assign value to array
            $msbr_options['msbr_display_add_review_product'] = $display_add_review_on_product;
            $msbr_options['msbr_review_form_max_char']       = $review_max_char;
            $msbr_options['msbr_reviewer_avatar_size']       = $reviewer_avatar_size;

            // save options
            update_option( 'msbr_general_options', $msbr_options );
        }
    }

    // retrive the options to use in general.php
    $msbr_options = get_option( 'msbr_general_options' );
    
    if( !empty( $msbr_options['msbr_display_add_review_product'] ) ) {
        $display_add_review_on_product = intval( $msbr_options['msbr_display_add_review_product'] );
    } else {
        $display_add_review_on_product = intval( 0 );
    }

    if( !empty( $msbr_options['msbr_review_form_max_char'] ) ) {
        $review_max_char = intval( $msbr_options['msbr_review_form_max_char'] );
    } else {
        $review_max_char = intval( 300 );
    }

    if( !empty( $msbr_options['msbr_reviewer_avatar_size'] ) ) {
        $reviewer_avatar_size = intval( $msbr_options['msbr_reviewer_avatar_size'] );
    } else {
        $reviewer_avatar_size = intval( 60 );
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