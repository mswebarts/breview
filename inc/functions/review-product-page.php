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

// add the new review tab content without the form

function msbr_product_new_review_tab_content() {
    
    global $product;

    $msbr_options = get_option( 'msbr_general_options' );
    $display_add_review_on_product = $msbr_options['msbr_display_add_review_product'];
    

    if ( ! comments_open() ) {
        return;
    }

    ?>
    <div id="reviews" class="woocommerce-Reviews">
        <div id="comments">
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
            
            <?php

                $comments = get_comments(
                    array(
                        'post_id' => $product->id,
                        'status' => 'approve'
                    )
                );
            ?>
            <?php if ( $comments ) : ?>
                <ol class="commentlist">
                    <?php
                    
                    $msbr_options = get_option( 'msbr_general_options' );

                    if( !empty( $msbr_options['msbr_reviewer_avatar_size'] ) ) {
                        $reviewer_avatar_size = intval( $msbr_options['msbr_reviewer_avatar_size'] );
                    } else {
                        $reviewer_avatar_size = intval( 60 );
                    }
                    $args = array(
                        'max_depth'         => intval(1),
                        'avatar_size'       => $reviewer_avatar_size,
                        'reverse_top_level' => false,
                        'callback' => 'woocommerce_comments',
                    );
                    wp_list_comments( $args, $comments );
                    
                    ?>
                </ol>
                
                <?php
                if ( get_comment_pages_count($comments) > 1 && get_option( 'page_comments' ) ) :
                    echo '<nav class="woocommerce-pagination">';
                    paginate_comments_links(
                        apply_filters(
                            'woocommerce_comment_pagination_args',
                            array(
                                'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
                                'next_text' => is_rtl() ? '&larr;' : '&rarr;',
                                'total'     => get_comment_pages_count($comments),
                                'type'      => 'list',
                            )
                        )
                    );
                    echo '</nav>';
                endif;
                ?>

            <?php else : ?>
                <p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'breview' ); ?></p>
            <?php endif; ?>
        </div>

        <?php if( $display_add_review_on_product ) : ?>

            <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
                <div id="review_form_wrapper">
                    <div id="review_form">
                        <?php
                        $commenter    = wp_get_current_commenter();
                        $comment_form = array(
                            /* translators: %s is product title */
                            'title_reply'         => $comments ? esc_html__( 'Add a review', 'breview' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'breview' ), get_the_title() ),
                            /* translators: %s is product title */
                            'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'breview' ),
                            'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
                            'title_reply_after'   => '</span>',
                            'comment_notes_after' => '',
                            'label_submit'        => esc_html__( 'Submit', 'breview' ),
                            'logged_in_as'        => '',
                            'comment_field'       => '',
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

                        foreach ( $fields as $key => $field ) {
                            $field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
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
                            $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'breview' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
                                <option value="">' . esc_html__( 'Rate&hellip;', 'breview' ) . '</option>
                                <option value="5">' . esc_html__( 'Perfect', 'breview' ) . '</option>
                                <option value="4">' . esc_html__( 'Good', 'breview' ) . '</option>
                                <option value="3">' . esc_html__( 'Average', 'breview' ) . '</option>
                                <option value="2">' . esc_html__( 'Not that bad', 'breview' ) . '</option>
                                <option value="1">' . esc_html__( 'Very poor', 'breview' ) . '</option>
                            </select></div>';
                        }

                        $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'breview' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';
                        
                        comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
                        ?>
                    </div>
                </div>
            <?php else : ?>
                <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'breview' ); ?></p>
            <?php endif; ?>

        <?php endif; ?>

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

    // check if multi rating is enabled
    if( $enable_multi_rating ) {
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