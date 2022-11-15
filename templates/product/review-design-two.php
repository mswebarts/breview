<?php
/**
 * Review list design 2 template
 *
 * This template can be overridden by copying it to yourtheme/breview/product/review-design-two.php
 *
 * HOWEVER, on occasion Breview will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package Breview\Templates
 * @version 1.1.0
 */

$comments = $data->comments;
$product = $data->product;
?>

<?php if ( $comments ) : ?>
    <ol class="msbr-review-list">
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
            'callback'          => 'msbr_review_design_item',
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