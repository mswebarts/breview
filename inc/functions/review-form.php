<?php
add_action( 'woocommerce_order_item_meta_end', 'msbr_add_review_form', 10, 3 );
function msbr_add_review_form( $item_id, $item, $order ) {
    global $product;
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

    // if the review is not submitted, show the form
    if( !$comments_count ) {
        // check if order status is completed or wc-completed
        if( ( ( $order->get_status() == 'completed' ) || ( $order->get_status() == 'wc-completed' ) ) && is_wc_endpoint_url('view-order') ) :
        ?>
        <div class="msbr-add-review">
            <a href="#msbr-add-review-<?php echo esc_attr( $item_id ); ?>" class="btn button msbr-open-add-review-modal">
                <?php echo esc_html_e( 'Add Review', 'breview' ); ?>
            </a>
        </div>
        <div id="msbr-add-review-<?php echo esc_attr( $item_id ); ?>" class="msbr-add-review-modal mfp-hide">
            <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product_id ) ) : ?>
                <div class="msbr-review-form-wrapper">
                    <div class="msbr-review-form">
                        <?php
                        $commenter    = array(
                            'comment_author'       => '',
                            'comment_author_email' => '',
                            'comment_author_url'   => '',
                        );
                        $comment_form = array(
                            /* translators: %s is product title */
                            'title_reply'         => esc_html__( 'Add a review', 'breview' ),
                            /* translators: %s is product title */
                            'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'breview' ),
                            'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
                            'title_reply_after'   => '</span>',
                            'comment_notes_after' => '',
                            'label_submit'        => esc_html__( 'Submit', 'breview' ),
                            'logged_in_as'        => '',
                            'comment_field'       => '',
                            //'action'              => '',
                        );

                        $name_email_required = (bool) get_option( 'require_name_email', 1 );
                        $fields              = array(
                            'author' => array(
                                'label'    => __( 'Name', 'breview' ),
                                'type'     => 'text',
                                'value'    => $commenter['comment_author'],
                                'required' => $name_email_required,
                            ),
                            'email'  => array(
                                'label'    => __( 'Email', 'breview' ),
                                'type'     => 'email',
                                'value'    => $commenter['comment_author_email'],
                                'required' => $name_email_required,
                            ),
                        );

                        $comment_form['fields'] = array();

                        /*echo '<pre>';
                        var_dump($fields);
                        echo '</pre>';*/

                        foreach ( $fields as $key => $field ) {
                            $field_html  = '<p class="msbr-comment-form-' . esc_attr( $key ) . '">';
                            $field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

                            if ( $field['required'] ) {
                                $field_html .= '&nbsp;<span class="required">*</span>';
                            }

                            $field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

                            $comment_form['fields'][ $key ] = $field_html;
                        }

                        $account_page_url = wc_get_page_permalink( 'myaccount' );
                        if ( $account_page_url ) {
                            /* translators: %s opening and closing link tags respectively */
                            $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'breview' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
                        }

                        if ( wc_review_ratings_enabled() ) {
                            $comment_form['comment_field'] = '<div class="msbr-comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'breview' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" class="msbr-star-rating" required>
                                <option value="">' . esc_html__( 'Rate&hellip;', 'breview' ) . '</option>
                                <option value="5">' . esc_html__( 'Perfect', 'breview' ) . '</option>
                                <option value="4">' . esc_html__( 'Good', 'breview' ) . '</option>
                                <option value="3">' . esc_html__( 'Average', 'breview' ) . '</option>
                                <option value="2">' . esc_html__( 'Not that bad', 'breview' ) . '</option>
                                <option value="1">' . esc_html__( 'Very poor', 'breview' ) . '</option>
                            </select><span class="msbr-error-message">'  . esc_html__( 'Rating must be selected', 'breview' ) . '</span></div>';
                            // TODO: add translation error message for rating setting
                        }

                        $comment_form['comment_field'] .= '<p class="msbr-comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'breview' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea><span class="msbr-error-message">'  . esc_html__( 'This is a required field', 'breview' ) . '</span></p>';

                        $comment_form['comment_field'] .= '<input type="hidden" name="order_identifier" value="' . esc_attr( $order_identifier ) . '" />';
                        
                        comment_form( $comment_form, $product_id );
                        ?>
                    </div>
                    <!--TODO: Add translation for success review text setting -->
                    <div class="msbr-review-success">
                        <p><?php esc_html_e( 'Thank you for your review. It has been submitted to the webmaster for approval.', 'breview' ); ?></p>
                    </div>
                </div>
            <?php else : ?>
                <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'breview' ); ?></p>
            <?php endif; ?>

        </div>
        <?php
        endif;
    } else if( is_wc_endpoint_url('view-order') ) {
        // if the review is submitted, show the review
        ?>
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
                        'status'  => 'approve',
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
        <?php
    } else {

    }
}

// Save the comment meta data along with comment

add_action( 'comment_post', 'msbr_save_comment_meta_data' );
function msbr_save_comment_meta_data( $comment_id ) {
  if ( ( isset( $_POST['order_identifier'] ) ) && ( $_POST['order_identifier'] != '' ) ) {
    $order_identifier = wp_filter_nohtml_kses($_POST['order_identifier']);
    add_comment_meta( $comment_id, 'order_identifier', $order_identifier );
  }
}