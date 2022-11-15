<?php
// remove the reviews tab from the product page
add_filter( 'woocommerce_product_tabs', 'msbr_remove_product_review_tab', 98 );
function msbr_remove_product_review_tab( $tabs ) {
  unset( $tabs['reviews'] );       // Remove the reviews tabinformation tab
  return $tabs;
}

// create a new review tab

add_filter( 'woocommerce_product_tabs', 'msbr_product_new_review_tab' );
function msbr_product_new_review_tab( $tabs ) {
    // Adds the new tab
    $tabs['msbr_reviews'] = array(
        'title'     => __( 'Reviews', 'breview' ),
        'priority'  => 50,
        'callback'  => 'msbr_product_new_review_tab_content'
    );

    return $tabs;
}

// add the new review tab content
function msbr_product_new_review_tab_content() {
    
    global $product, $msbr_dir;

    $msbr_options = get_option( 'msbr_general_options' );
    $display_add_review_on_product = $msbr_options['msbr_display_add_review_product'];
    $msbr_header_design = $msbr_options['msbr_review_list_header_design'];
    $templates = new MSBR_Template_Loader;

    if ( ! comments_open() ) {
        return;
    }

    ?>
    <div id="reviews" class="woocommerce-Reviews">
        <div id="comments">
            <?php if( $msbr_header_design == "default" ) { ?>
            <h2 class="woocommerce-Reviews-title">
                <?php
                $count = $product->get_review_count();
                if ( $count && wc_review_ratings_enabled() ) {
                    /* translators: 1: reviews count 2: product name */
                    $reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'breview' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
                    echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
                } else {
                    esc_html_e( 'Reviews', 'breview' );
                }
                ?>
            </h2>
            <?php } else {
                // load the template for the header design
                $data = array(
                    'product' => $product,
                );
                $templates->set_template_data($data)->get_template_part( 'header/header', $msbr_header_design );
            }
            ?>
            
            <?php
                $comments = get_comments(
                    array(
                        'post_id' => $product->get_id(),
                        'status' => 'approve'
                    )
                );

                // load the review list template
                $data = array(
                    'comments' => $comments,
                    'product' => $product,
                );
                $templates->set_template_data($data)->get_template_part( 'product/review-list', 'default' );
            ?>
        </div>

        <?php
            if( $display_add_review_on_product && ( $msbr_header_design == 'default' ) ) {
                $data = array(
                    'item_id' => $product->get_id(),
                    'product_id' => $product->get_id(),
                    'order_identifier' => 'product_page',
                );
                $templates->set_template_data($data)->get_template_part('product/add-review-popup-product');
            }
        ?>

        <div class="clear"></div>
    </div>
    <?php
}

// Add multi rating to product page

add_action( 'woocommerce_review_before_comment_meta', 'msbr_display_multi_ratings', 5 );
function msbr_display_multi_ratings( $comment ) {
    // display multi ratings
    $msbr_options = get_option('msbr_multi_rating_options');

    // get if multi rating is enabled
    if (!empty($msbr_options['msbr_enable_multi_rating'])) {
        $enable_multi_rating = intval($msbr_options['msbr_enable_multi_rating']);
    } else {
        $enable_multi_rating = intval(0);
    }

    // get if display multi rating is enabled
    if (!empty($msbr_options['msbr_display_multi_rating_product'])) {
        $display_multi_rating_product = intval($msbr_options['msbr_display_multi_rating_product']);
    } else {
        $display_multi_rating_product = intval(0);
    }

    // check if multi rating is enabled
    if( $enable_multi_rating && $display_multi_rating_product ) {
        if(!empty($msbr_options['msbr_multi_rating'])) {
            $multi_ratings = $msbr_options['msbr_multi_rating'];
        } else {
            $multi_ratings = [];
        }
    
        $total_ratings = count($multi_ratings);
    
        if($total_ratings > 0) {
            ?>
            <table class="msbr-display-multi-ratings">
                <?php
                foreach ($multi_ratings as $rating) {
                    $rating_id = $rating['msbr_multi_rating_id'];
                    $rating_name = $rating['msbr_multi_rating_name'];
                    $rating = intval( get_comment_meta( $comment->comment_ID, 'msbr_multi_rating_item_'. $rating_id .'', true ) );

                    if ( $rating && wc_review_ratings_enabled() ) {
                        ?>
                        <tr class="msbr-display-multi-ratings-item">
                            <td class="msbr-display-multi-ratings-item-name">
                                <?php echo esc_html( $rating_name ); ?>
                            </td>
                            <td class="msbr-display-multi-ratings-item-rating">
                                <?php echo wc_get_rating_html( $rating ); // WPCS: XSS ok. ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
            <?php
        }
    }
}