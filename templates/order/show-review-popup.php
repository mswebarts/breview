<?php
/**
 * Show review popup template for Order page
 * since 1.0.3
 * 
 * This template is responsible for showing the submitted Review popup in the Order details page and
 * it can be overridden by copying it to yourtheme/breview/order/show-review-popup.php
 */
$item_id = $data->item_id;
$product_id = $data->product_id;
$order_identifier = $data->order_identifier;

$msbr_options                    = get_option( 'msbr_general_options' );
$msbr_review_list_design         = $msbr_options['msbr_review_list_design'];

$templates                       = new MSBR_Template_Loader;
  
$msbr_review_list_id             = $msbr_review_list_design == 'default' ? 'reviews' : 'msbr-reviews-wrapper';
$msbr_review_list_class          = $msbr_review_list_design == 'default' ? 'woocommerce-Reviews' : 'msbr-reviews-wrapper';
$msbr_review_list_class         .= ' msbr-reviews-list-' . $msbr_review_list_design;
$msbr_review_list_comment_class  = $msbr_review_list_design == 'default' ? 'comments' : 'msbr-reviews';
?>
<div class="msbr-show-review">
    <a href="#msbr-show-review-<?php echo esc_attr( $item_id ); ?>" class="btn button msbr-open-show-review-modal">
        <?php echo esc_html_e( 'Show Review', 'breview' ); ?>
    </a>
</div>
<div id="msbr-show-review-<?php echo esc_attr( $item_id ); ?>" class="msbr-show-review-modal mfp-hide">
    <div id="<?php echo esc_attr($msbr_review_list_id); ?>" class="<?php echo esc_attr($msbr_review_list_class); ?>">
        <div id="<?php echo esc_attr($msbr_review_list_comment_class); ?>">
            <?php
            // get the review
            $args = array(
                'post_id' => $product_id,
                'type'    => 'review',
                'meta_query' => array(
                    array(
                        'key'     => 'order_identifier',
                        'value'   => $order_identifier,
                        'compare' => '=',
                    ),
                ),
            );
            
            $comments = get_comments( $args );

            ?>
            <?php
                // load the review list template
                $product = wc_get_product( $product_id );
                $data = array(
                    'comments' => $comments,
                    'product' => $product,
                );
                $templates->set_template_data($data)->get_template_part( 'product/review-design', $msbr_review_list_design );
            ?>
        </div>
    </div>

</div>