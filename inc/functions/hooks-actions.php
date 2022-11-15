<?php

if( !function_exists('msbr_review_display_rating') ) {
    
    // Add multi rating to product page
    add_action( 'woocommerce_review_before_comment_meta', 'msbr_review_display_rating', 5 );
    add_action( "msbr_review_rating", 'msbr_review_display_rating', 10 );
    function msbr_review_display_rating( $comment ) {
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
}

if ( ! function_exists( 'msbr_review_design_one_item' ) ) {

	/**
	 * Output the Review comments template.
	 *
	 * @param WP_Comment $comment Comment object.
	 * @param array      $args Arguments.
	 * @param int        $depth Depth.
	 */
	function msbr_review_design_one_item( $comment, $args, $depth ) {
		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
        $templates = new MSBR_Template_Loader;

		$GLOBALS['comment'] = $comment;
        $data = array(
            'comment' => $comment,
            'args'    => $args,
            'depth'   => $depth,
        );
        $templates->set_template_data($data)->get_template_part( 'product/review-design-one/review-design', 'one-item' );
	}
}

if ( ! function_exists( 'msbr_review_display_gravatar' ) ) {
	/**
	 * Display the review authors gravatar
	 *
	 * @param array $comment WP_Comment.
	 * @return void
	 */
    add_action( 'msbr_review_user', 'msbr_review_display_gravatar', 10 );
	function msbr_review_display_gravatar( $comment ) {
		echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' );
	}
}

if ( ! function_exists( 'msbr_review_display_meta' ) ) {
	/**
	 * Display the review authors meta (name, verified owner, review date)
	 *
	 * @return void
	 */
    add_action( 'msbr_review_user', 'msbr_review_display_meta', 20 );
	function msbr_review_display_meta() {
        $templates = new MSBR_Template_Loader;
        $templates->get_template_part( 'product/review-design', 'item-meta' );
	}
}

if ( ! function_exists( 'msbr_review_display_comment_text' ) ) {

	/**
	 * Display the review content.
	 */
    add_action( 'msbr_review_content', 'msbr_review_display_comment_description', 10 );
	function msbr_review_display_comment_description() {
		echo '<div class="msbr-review-description">';
		comment_text();
		echo '</div>';
	}
}

if( !function_exists( 'msbr_review_avatar_size' ) ) {
    add_filter( 'woocommerce_review_gravatar_size', 'msbr_review_avatar_size' );
    function msbr_review_avatar_size( $size ) {
        $msbr_options = get_option('msbr_general_options');
        $avatar_size  = $msbr_options['msbr_reviewer_avatar_size'];
        return $avatar_size;
    }
}