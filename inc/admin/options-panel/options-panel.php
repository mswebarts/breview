<?php
// overview page

function msbr_breview_general_settings_page() {
    global $msbr_dir, $msbr_options;

    // check if form submitted
    if (isset($_POST['msbr_general_form_submitted'])) {
        $submitted = sanitize_text_field( $_POST['msbr_general_form_submitted'] );

        // if submitted is set to Y
        if ($submitted == 'Y') {

            // display add review form
            if (isset($_POST['msbr_display_add_review_product'])) {
                $display_add_review_on_product = intval($_POST['msbr_display_add_review_product']);
            } else {
                $display_add_review_on_product = intval(0);
            }

            // review form title min char
            if (isset($_POST['msbr_review_form_title_min_char'])) {
                $review_title_min_char = intval($_POST['msbr_review_form_title_min_char']);
            } else {
                $review_title_min_char = intval(10);
            }

            // review form title max char
            if (isset($_POST['msbr_review_form_title_max_char'])) {
                $review_title_max_char = intval($_POST['msbr_review_form_title_max_char']);
            } else {
                $review_title_max_char = intval(10);
            }

            // review form desc min char
            if (isset($_POST['msbr_review_form_desc_min_char'])) {
                $review_min_char = intval($_POST['msbr_review_form_desc_min_char']);
            } else {
                $review_min_char = intval(10);
            }

            // review form desc max char
            if (isset($_POST['msbr_review_form_desc_max_char'])) {
                $review_max_char = intval($_POST['msbr_review_form_desc_max_char']);
            } else {
                $review_max_char = intval(300);
            }

            // reviewer avatar size
            if (isset($_POST['msbr_reviewer_avatar_size'])) {
                $reviewer_avatar_size = intval($_POST['msbr_reviewer_avatar_size']);
            } else {
                $reviewer_avatar_size = intval(60);
            }

            // review list header design
            if (isset($_POST['msbr_review_list_header_design'])) {
                $review_list_header = sanitize_text_field($_POST['msbr_review_list_header_design']);
            } else {
                $review_list_header = sanitize_text_field('default');
            }

            // review list design
            if (isset($_POST['msbr_review_list_design'])) {
                $review_list_design = sanitize_text_field($_POST['msbr_review_list_design']);
            } else {
                $review_list_design = sanitize_text_field('default');
            }

            // auto approve reviews
            if (isset($_POST['msbr_auto_approve_reviews'])) {
                $auto_approve = intval($_POST['msbr_auto_approve_reviews']);
            } else {
                $auto_approve = intval(0);
            }

            // assign value to array
            $msbr_options['msbr_display_add_review_product'] = $display_add_review_on_product;
            $msbr_options['msbr_review_form_title_min_char'] = $review_title_min_char;
            $msbr_options['msbr_review_form_title_max_char'] = $review_title_max_char;
            $msbr_options['msbr_review_form_desc_min_char']  = $review_min_char;
            $msbr_options['msbr_review_form_desc_max_char']  = $review_max_char;
            $msbr_options['msbr_reviewer_avatar_size']       = $reviewer_avatar_size;
            $msbr_options['msbr_review_list_header_design']  = $review_list_header;
            $msbr_options['msbr_review_list_design']         = $review_list_design;

            // save options
            update_option('msbr_general_options', $msbr_options);
            update_option('msbr_auto_approve_reviews', $auto_approve);
        }
    }

    // retrive the options to use in general.php
    $msbr_options = get_option('msbr_general_options');

    if (!empty($msbr_options['msbr_display_add_review_product'])) {
        $display_add_review_on_product = intval($msbr_options['msbr_display_add_review_product']);
    } else {
        $display_add_review_on_product = intval(0);
    }

    if (!empty($msbr_options['msbr_review_form_title_min_char'])) {
        $review_title_min_char = intval($msbr_options['msbr_review_form_title_min_char']);
    } else {
        $review_title_min_char = intval(10);
    }

    if (!empty($msbr_options['msbr_review_form_title_max_char'])) {
        $review_title_max_char = intval($msbr_options['msbr_review_form_title_max_char']);
    } else {
        $review_title_max_char = intval(100);
    }

    if (!empty($msbr_options['msbr_review_form_desc_min_char'])) {
        $review_min_char = intval($msbr_options['msbr_review_form_desc_min_char']);
    } else {
        $review_min_char = intval(10);
    }

    if (!empty($msbr_options['msbr_review_form_desc_max_char'])) {
        $review_max_char = intval($msbr_options['msbr_review_form_desc_max_char']);
    } else {
        $review_max_char = intval(300);
    }

    if (!empty($msbr_options['msbr_reviewer_avatar_size'])) {
        $reviewer_avatar_size = intval($msbr_options['msbr_reviewer_avatar_size']);
    } else {
        $reviewer_avatar_size = intval(60);
    }

    if (!empty($msbr_options['msbr_review_list_header_design'])) {
        $review_list_header = sanitize_text_field($msbr_options['msbr_review_list_header_design']);
    } else {
        $review_list_header = sanitize_text_field('default');
    }

    if (!empty($msbr_options['msbr_review_list_design'])) {
        $review_list_design = sanitize_text_field($msbr_options['msbr_review_list_design']);
    } else {
        $review_list_design = sanitize_text_field('default');
    }

    $auto_approve = get_option('msbr_auto_approve_reviews');

    include_once $msbr_dir . 'inc/admin/options-panel/pages/general.php';
}

function msbr_breview_style_settings_page() {
    global $msbr_dir;
    include_once $msbr_dir . 'inc/admin/options-panel/pages/style.php';
}

function msbr_breview_email_settings_page() {
    global $msbr_dir;

    if (isset($_POST['msbr_email_form_submitted'])) {
        $submitted = sanitize_text_field( $_POST['msbr_email_form_submitted'] );

        // if submitted is set to Y
        if ($submitted == 'Y') {
            if (isset($_POST['msbr_enable_completed_email'])) {
                $enable_completed_email = intval($_POST['msbr_enable_completed_email']);
            } else {
                $enable_completed_email = intval(0);
            }

            // assign value to array
            $msbr_options['msbr_enable_completed_email']     = $enable_completed_email;

            // save options
            update_option('msbr_email_options', $msbr_options);
        }
    }

    // retrieve the options to use in email.php
    $msbr_options            = get_option('msbr_email_options');

    if (!empty($msbr_options['msbr_enable_completed_email'])) {
        $enable_completed_email = intval($msbr_options['msbr_enable_completed_email']);
    } else {
        $enable_completed_email = intval(0);
    }

    include_once $msbr_dir . 'inc/admin/options-panel/pages/email.php';
}

function msbr_breview_multi_rating_settings_page() {
    global $msbr_dir;

    // retrieve the options to use in multi-rating.php
    $msbr_options            = get_option('msbr_multi_rating_options');

    $enable_multi_rating = intval(0);

    $multi_ratings = [];

    include_once $msbr_dir . 'inc/admin/options-panel/pages/multi-rating.php';
}