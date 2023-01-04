<?php
if( !function_exists('msbr_get_rating_html') ) {
    /**
     * Get the review rating for a product.
     */
    function msbr_get_rating_html( $rating, $count = 0 ) {
        $html = '';
    
        if ( 0 < $rating ) {
            /* translators: %s: rating */
            $label = sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating );
            $html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
        }
    
        return apply_filters( 'woocommerce_product_get_rating_html', $html, $rating, $count );
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

if ( ! function_exists( 'msbr_review_display_comment_title' ) ) {

	/**
	 * Display the review content.
	 */
    add_action( 'msbr_review_content', 'msbr_review_display_comment_title', 5 );
	function msbr_review_display_comment_title( $comment ) {
        echo '<h4 class="msbr-review-title">' . get_comment_meta( $comment->comment_ID, 'msbr_review_title', true ) . '</h4>';
	}
}

if ( ! function_exists( 'msbr_review_display_comment_description' ) ) {

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
    /**
     * Change the avatar size in the review template
     */
    add_filter( 'woocommerce_review_gravatar_size', 'msbr_review_avatar_size' );
    function msbr_review_avatar_size( $size ) {
        $msbr_options = get_option('msbr_general_options');
        $avatar_size  = $msbr_options['msbr_reviewer_avatar_size'];
        return $avatar_size;
    }
}

if( !function_exists('msbr_review_design_single_star_rating') ) {
    /**
     * Display the single review rating when multi-rating is disabled
     */
    add_action( "msbr_review_rating", 'msbr_review_design_single_star_rating', 10 );
    function msbr_review_design_single_star_rating( $comment ) {
        $msbr_options = get_option( 'msbr_multi_rating_options' );
        $enable_multi_rating = $msbr_options['msbr_enable_multi_rating'];
        $display_multi_rating_product = $msbr_options['msbr_display_multi_rating_product'];

        if( ( $enable_multi_rating == false ) || ( $display_multi_rating_product == false ) ) {
            $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
            ?>
            <div class="msbr-rating-svg-mini" data-rating="<?php echo esc_attr( $rating ); ?>" role="img"></div>
            <?php
        }
    }
}

if( !function_exists('msbr_review_design_two_rating_header' ) ) {
    /**
     * Display the two rating header
     */
    add_action( "msbr_review_rating", 'msbr_review_design_two_rating_header', 5 );
    function msbr_review_design_two_rating_header( $comment ) {
        $msbr_options = get_option( 'msbr_multi_rating_options' );
        $enable_multi_rating = $msbr_options['msbr_enable_multi_rating'];
        $display_multi_rating_product = $msbr_options['msbr_display_multi_rating_product'];

        $msbr_gen_options = get_option( 'msbr_general_options' );
        $review_list_design = $msbr_gen_options['msbr_review_list_design'];

        if( $review_list_design == 'two' ) {
            if( ( $enable_multi_rating == true ) && ( $display_multi_rating_product == true ) ) {
                $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
                ?>
                <div class="msbr-review-design-two-rating-header">
                    <span class="msbr-review-design-two-rating-header-rating">
                        <?php echo esc_html( $rating ); ?>
                    </span>
                    <?php echo msbr_get_rating_html( $rating ); // WPCS: XSS ok. ?>
                </div>
                <?php
            }
        }
    }
}