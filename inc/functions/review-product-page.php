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
    if ( ! comments_open() ) {
        return;
    }

    global $product, $msbr_dir;

    $msbr_options                    = get_option( 'msbr_general_options' );
    $display_add_review_on_product   = $msbr_options['msbr_display_add_review_product'];
    $msbr_header_design              = $msbr_options['msbr_review_list_header_design'];
    $msbr_review_list_design         = $msbr_options['msbr_review_list_design'];
    $templates                       = new MSBR_Template_Loader;
  
    $msbr_review_list_id             = $msbr_review_list_design == 'default' ? 'reviews' : 'msbr-reviews-wrapper';
    $msbr_review_list_class          = $msbr_review_list_design == 'default' ? 'woocommerce-Reviews' : 'msbr-reviews-wrapper';
    $msbr_review_list_class         .= ' msbr-reviews-list-' . $msbr_review_list_design;
    $msbr_review_list_comment_class  = $msbr_review_list_design == 'default' ? 'comments' : 'msbr-reviews';

    ?>
    <div id="<?php echo esc_attr($msbr_review_list_id); ?>" class="<?php echo esc_attr($msbr_review_list_class); ?>">
        <div id="<?php echo esc_attr($msbr_review_list_comment_class); ?>">
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
                $templates->set_template_data($data)->get_template_part( 'product/review-design', $msbr_review_list_design );
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