<div class="msbr-show-review">
    <a href="#msbr-show-review-<?php echo esc_attr( $item_id ); ?>" class="btn button msbr-open-show-review-modal">
        <?php echo esc_html_e( 'Show Review', 'breview' ); ?>
    </a>
</div>
<div id="msbr-show-review-<?php echo esc_attr( $item_id ); ?>" class="msbr-show-review-modal mfp-hide">
    <div id="reviews" class="woocommerce-Reviews">
        <div id="comments">
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

            // TODO: Clean this up
            var_dump( get_comment_meta( 20, 'msbr_multi_rating_item_service', true ) );
            var_dump( get_comment_meta( 20, 'msbr_multi_rating_item_quality', true ) );
            var_dump( get_comment_meta( 20, 'msbr_multi_rating_item_buy_again', true ) );
            var_dump( get_comment_meta( 20, 'msbr_multi_rating_item_delivery', true ) );
            var_dump( get_comment_meta( 20, 'msbr_multi_rating_item_item5', true ) );
            var_dump( get_comment_meta( 20, 'msbr_multi_rating_item_item6', true ) );
            var_dump( get_comment_meta( 20, 'msbr_multi_rating_item_item7', true ) );
            var_dump( get_comment_meta( 20, 'msbr_multi_rating_item_item8', true ) );
            $comments = get_comments( $args );

            ?>
            <ol class="commentlist">
                <?php
                $msbr_options = get_option( 'msbr_general_options' );

                if( !empty( $msbr_options['msbr_reviewer_avatar_size'] ) ) {
                    $reviewer_avatar_size = intval( $msbr_options['msbr_reviewer_avatar_size'] );
                } else {
                    $reviewer_avatar_size = intval( 60 );
                }
                // display the review
                $args = array(
                    'max_depth'         => '1',
                    'avatar_size'       => $reviewer_avatar_size,
                    'reverse_top_level' => false,
                    'callback' => 'woocommerce_comments',
                );
                wp_list_comments( $args, $comments );
                
                ?>
            </ol>
        </div>
    </div>

</div>