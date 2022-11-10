<?php
add_action('woocommerce_order_item_meta_end', 'msbr_add_review_form', 10, 3);
function msbr_add_review_form($item_id, $item, $order)
{
    global $product, $msbr_dir;
    $product_id = $item->get_product_id();

    // create an identifier to pass to the form
    $order_identifier = 'item-' . $item_id . '|' . 'order-' . $order->get_id();

    // check if the review form has been submitted
    $comments_count = get_comments(
        array(
            'post_id' => $product_id,
            'count'   => true,
            'meta_query' => array(
                array(
                    'key' => 'order_identifier',
                    'value' => $order_identifier,
                ),
            ),
        )
    );

    // check dokan plugin compatibility
    $marketplace_compat = array();

    if (class_exists('WeDevs_Dokan')) {
        $marketplace_compat['dokan'] = true;
    } else {
        $marketplace_compat['dokan'] = false;
    }

    // dokan compatibility
    if (!empty($marketplace_compat) && $marketplace_compat['dokan']) {
        // check if order has suborders
        $suborders = $order->get_meta('has_sub_order');
        if ($suborders) {
            return;
        } else {
            // if the review is not submitted, show the form
            if (!$comments_count) {
                // check if order status is completed or wc-completed
                if ((($order->get_status() == 'completed') || ($order->get_status() == 'wc-completed')) && (is_wc_endpoint_url('view-order') || is_wc_endpoint_url('order-received'))) {
                    require($msbr_dir . 'templates/review-form-add-popup.php');
                }
            } else if (is_wc_endpoint_url('view-order') || is_wc_endpoint_url('order-received')) {
                // if the review is submitted, show the review
                require($msbr_dir . 'templates/review-form-show-popup.php');
            } else {
                // leave empty so, the review form is not shown anywhere else
            }
        }
    } else {
        // default woocommerce compatibility
        // if the review is not submitted, show the form
        if (!$comments_count) {
            // check if order status is completed or wc-completed
            if ((($order->get_status() == 'completed') || ($order->get_status() == 'wc-completed')) && (is_wc_endpoint_url('view-order') || is_wc_endpoint_url('order-received'))) {
                require($msbr_dir . 'templates/review-form-add-popup.php');
            }
        } else if (is_wc_endpoint_url('view-order') || is_wc_endpoint_url('order-received')) {
            // if the review is submitted, show the review
            require($msbr_dir . 'templates/review-form-show-popup.php');
        } else {
            // leave empty so, the review form is not shown anywhere else
        }
    }
}

// Save the comment meta data along with comment

add_action('comment_post', 'msbr_save_comment_meta_data');
function msbr_save_comment_meta_data($comment_id) {
    if ((isset($_POST['order_identifier'])) && ($_POST['order_identifier'] != '')) {
        $order_identifier = wp_filter_nohtml_kses($_POST['order_identifier']);
        add_comment_meta($comment_id, 'order_identifier', $order_identifier);
    }

    // save multi ratings
    $msbr_options = get_option('msbr_multi_rating_options');

    // check if multi rating is enabled
    if (!empty($msbr_options['msbr_enable_multi_rating'])) {
        $enable_multi_rating = intval($msbr_options['msbr_enable_multi_rating']);
    } else {
        $enable_multi_rating = intval(0);
    }

    if( $enable_multi_rating ) {
        if(!empty($msbr_options['msbr_multi_rating'])) {
            $multi_ratings = $msbr_options['msbr_multi_rating'];
        } else {
            $multi_ratings = [];
        }
        $rating_sum = 0;
        $total_ratings = count($multi_ratings);
    
        if($total_ratings > 0) {
            foreach ($multi_ratings as $rating) {
                $rating_id = $rating['msbr_multi_rating_id'];
                
                if ((isset($_POST['msbr_multi_rating_item_'. $rating_id .''])) && ($_POST['msbr_multi_rating_item_'. $rating_id .''] != '')) {
                    $msbr_multi_rating_item = wp_filter_nohtml_kses($_POST['msbr_multi_rating_item_'. $rating_id .'']);
                    $rating_sum += $msbr_multi_rating_item;
                    add_comment_meta($comment_id, 'msbr_multi_rating_item_'. $rating_id .'', $msbr_multi_rating_item);
                }
            }

            $rating_average = $rating_sum / $total_ratings;
            if( $rating_average >= 1) {
                $rating_average = intval($rating_average);
            } else if( $rating_average > 0 && $rating_average < 1) {
                $rating_average = intval(1);
            } else {
                $rating_average = intval(0);
            }

            if( !empty($rating_average) ) {
                add_comment_meta($comment_id, 'rating', $rating_average);
            }
        }
    }
}

if (class_exists('WeDevs_Dokan') && !function_exists('msbr_dokan_has_suborder_msg')) {

    add_action('woocommerce_order_details_before_order_table_items', 'msbr_dokan_has_suborder_msg', 10, 1);
    function msbr_dokan_has_suborder_msg($order)
    {
        // check if order has suborders
        $suborders = $order->get_meta('has_sub_order');

        if ($suborders) {
?>
            <div class="woocommerce-message">
                <?php echo esc_html_e("This order has suborders. Please review the products from the suborders page if they got completed.", "breview"); ?>
            </div>
<?php
        }
    }
}
