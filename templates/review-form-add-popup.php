<div class="msbr-add-review">
    <a href="#msbr-add-review-<?php echo esc_attr($item_id); ?>" class="btn button msbr-open-add-review-modal">
        <?php echo esc_html_e('Add Review', 'breview'); ?>
    </a>
</div>
<div id="msbr-add-review-<?php echo esc_attr($item_id); ?>" class="msbr-add-review-modal mfp-hide">
    <?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product_id)) : ?>
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
                    'title_reply'         => esc_html__('Add a review', 'breview'),
                    /* translators: %s is product title */
                    'title_reply_to'      => esc_html__('Leave a Reply to %s', 'breview'),
                    'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
                    'title_reply_after'   => '</span>',
                    'comment_notes_after' => '',
                    'label_submit'        => esc_html__('Submit', 'breview'),
                    'logged_in_as'        => '',
                    'comment_field'       => '',
                    //'action'              => '',
                );

                $name_email_required = (bool) get_option('require_name_email', 1);
                $fields              = array(
                    'author' => array(
                        'label'    => __('Name', 'breview'),
                        'type'     => 'text',
                        'value'    => $commenter['comment_author'],
                        'required' => $name_email_required,
                    ),
                    'email'  => array(
                        'label'    => __('Email', 'breview'),
                        'type'     => 'email',
                        'value'    => $commenter['comment_author_email'],
                        'required' => $name_email_required,
                    ),
                );

                $comment_form['fields'] = array();

                foreach ($fields as $key => $field) {
                    $field_html  = '<p class="msbr-comment-form-' . esc_attr($key) . '">';
                    $field_html .= '<label for="' . esc_attr($key) . '">' . esc_html($field['label']);

                    if ($field['required']) {
                        $field_html .= '&nbsp;<span class="required">*</span>';
                    }

                    $field_html .= '</label><input id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="' . esc_attr($field['type']) . '" value="' . esc_attr($field['value']) . '" size="30" ' . ($field['required'] ? 'required' : '') . ' /></p>';

                    $comment_form['fields'][$key] = $field_html;
                }

                $account_page_url = wc_get_page_permalink('myaccount');
                if ($account_page_url) {
                    /* translators: %s opening and closing link tags respectively */
                    $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(esc_html__('You must be %1$slogged in%2$s to post a review.', 'breview'), '<a href="' . esc_url($account_page_url) . '">', '</a>') . '</p>';
                }

                if (wc_review_ratings_enabled()) {
                    $msbr_options = get_option('msbr_multi_rating_options');
                    if (!empty($msbr_options['msbr_enable_multi_rating'])) {
                        $enable_multi_rating = intval($msbr_options['msbr_enable_multi_rating']);
                    } else {
                        $enable_multi_rating = intval(0);
                    }

                    // check if multi rating is enabled

                    if ($enable_multi_rating) {
                        $multi_ratings = get_option('msbr_multi_rating_options');

                        // get the configured multi rating options
                        if (!empty($msbr_options['msbr_multi_rating'])) {
                            $multi_ratings = $msbr_options['msbr_multi_rating'];
                        } else {
                            $multi_ratings = [];
                        }

                        $total_ratings = count($multi_ratings);

                        if ($total_ratings > 0) {
                            foreach ($multi_ratings as $rating) {
                                $rating_id = $rating['msbr_multi_rating_id'];
                                $rating_title = $rating['msbr_multi_rating_name'];

                                // check if rating id and name is not empty

                                if(!empty($rating_id) || !empty($rating_title)) {
                                    // TODO: Need to make sure rating title is translateable
                                    $comment_form['comment_field'] .= '<div class="msbr-comment-form-rating"><label for="rating">' . esc_html($rating_title) . (wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '') . '</label><select name="msbr_multi_rating_item_' . $rating_id . '" id="msbr_multi_rating_item_' . $rating_id . '" class="msbr-star-rating" required>
                                        <option value="">' . esc_html__('Rate&hellip;', 'breview') . '</option>
                                        <option value="5">' . esc_html__('Perfect', 'breview') . '</option>
                                        <option value="4">' . esc_html__('Good', 'breview') . '</option>
                                        <option value="3">' . esc_html__('Average', 'breview') . '</option>
                                        <option value="2">' . esc_html__('Not that bad', 'breview') . '</option>
                                        <option value="1">' . esc_html__('Very poor', 'breview') . '</option>
                                    </select><span class="msbr-error-message">'  . esc_html__('Rating must be selected', 'breview') . '</span></div>';
                                }
                            }
                        }
                    } else {
                        $comment_form['comment_field'] = '<div class="msbr-comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'breview') . (wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '') . '</label><select name="rating" id="rating" class="msbr-star-rating" required>
                            <option value="">' . esc_html__('Rate&hellip;', 'breview') . '</option>
                            <option value="5">' . esc_html__('Perfect', 'breview') . '</option>
                            <option value="4">' . esc_html__('Good', 'breview') . '</option>
                            <option value="3">' . esc_html__('Average', 'breview') . '</option>
                            <option value="2">' . esc_html__('Not that bad', 'breview') . '</option>
                            <option value="1">' . esc_html__('Very poor', 'breview') . '</option>
                        </select><span class="msbr-error-message">'  . esc_html__('Rating must be selected', 'breview') . '</span></div>';
                    }
                }

                $comment_form['comment_field'] .= '<p class="msbr-comment-form-comment"><label for="comment">' . esc_html__('Your review', 'breview') . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea><span class="msbr-error-message">'  . esc_html__('This is a required field', 'breview') . '</span></p>';

                $comment_form['comment_field'] .= '<input type="hidden" name="order_identifier" value="' . esc_attr($order_identifier) . '" />';

                comment_form($comment_form, $product_id);
                ?>
            </div>
            <div class="msbr-review-success">
                <div class="msbr-review-success-icon-container">
                    <span class="msbr-review-success-icon">
                        <i class="dashicons-before dashicons-saved"></i>
                    </span>
                </div>
                <h3><?php echo esc_html_e("Review Submitted Successfully!", "breview"); ?></h3>
                <div class="msbr-review-success-description">
                    <?php
                    // line items
                    $order_items_count = count($order->get_items());
                    echo wp_sprintf(_n(
                        'Thank you for giving a review to <b>%s</b>',
                        'Thank you for giving a review to <b>%s</b>. Please give review to the other products in your order if not done already.',
                        $order_items_count,
                        'breview'
                    ), get_the_title($product_id));
                    ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <p class="woocommerce-verification-required"><?php esc_html_e('Only logged in customers who have purchased this product may leave a review.', 'breview'); ?></p>
    <?php endif; ?>

</div>