<?php
/**
 * Review List Header Design One Alt Template
 * since 1.0.3
 * 
 * This template is responsible for showing the review list header design in the product details page and
 * it can be overridden by copying it to yourtheme/breview/header/header-one-alt.php
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

$product      = $data->product;
$total_rating = $product->get_review_count();
$avg_rating   = $product->get_average_rating();
$avg_rating   = !empty( $avg_rating ) ? $avg_rating : intval(5.0);
$rating1      = $product->get_rating_count(1);
$rating2      = $product->get_rating_count(2);
$rating3      = $product->get_rating_count(3);
$rating4      = $product->get_rating_count(4);
$rating5      = $product->get_rating_count(5);
$templates    = new MSBR_Template_Loader();

$rating1_fill = !empty( $rating1 ) || !empty( $total_rating ) ? ($rating1 / $total_rating) * 100 : 0;
$rating2_fill = !empty( $rating2 ) || !empty( $total_rating ) ? ($rating2 / $total_rating) * 100 : 0;
$rating3_fill = !empty( $rating3 ) || !empty( $total_rating ) ? ($rating3 / $total_rating) * 100 : 0;
$rating4_fill = !empty( $rating4 ) || !empty( $total_rating ) ? ($rating4 / $total_rating) * 100 : 0;
$rating5_fill = !empty( $rating5 ) || !empty( $total_rating ) ? ($rating5 / $total_rating) * 100 : 0;

$msbr_options                  = get_option( 'msbr_general_options' );
$display_add_review_on_product = $msbr_options['msbr_display_add_review_product'];
$add_review_enabled            = $display_add_review_on_product ? 'msbr-add-review-enabled' : '';
?>

<div class="msbr-review-list-header-design-one msbr-alt <?php echo esc_attr( $add_review_enabled ); ?>">
    <?php if( $display_add_review_on_product ) : ?>
        <div class="msbr-review-list-header-right">
            <?php
                $data = array(
                    'item_id' => get_the_ID(),
                    'product_id' => get_the_ID(),
                    'order_identifier' => 'product_page',
                );
                $templates->set_template_data($data)->get_template_part('product/add-review-popup-product');
            ?>
        </div>
    <?php endif; ?>

    <div class="msbr-review-list-header-middle">
        <div class="msbr-review-list-header-rating-bars">
            <div class="msbr-review-list-header-rating-bar">
                <div class="msbr-review-list-header-rating-bar-title">
                <div class="msbr-rating-svg-small" data-rating="<?php echo esc_attr( 5 ); ?>"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-bar">
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating5_fill ); ?>%"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-count">
                    <?php echo esc_html( $rating5 ); ?>
                </div>
            </div>
            <div class="msbr-review-list-header-rating-bar">
                <div class="msbr-review-list-header-rating-bar-title">
                    <div class="msbr-rating-svg-small" data-rating="<?php echo esc_attr( 4 ); ?>"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-bar">
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating4_fill ); ?>%"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-count">
                    <?php echo esc_html( $rating4 ); ?>
                </div>
            </div>
            <div class="msbr-review-list-header-rating-bar">
                <div class="msbr-review-list-header-rating-bar-title">
                    <div class="msbr-rating-svg-small" data-rating="<?php echo esc_attr( 3 ); ?>"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-bar">
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating3_fill ); ?>%"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-count">
                    <?php echo esc_html( $rating3 ); ?>
                </div>
            </div>
            <div class="msbr-review-list-header-rating-bar">
                <div class="msbr-review-list-header-rating-bar-title">
                    <div class="msbr-rating-svg-small" data-rating="<?php echo esc_attr( 2 ); ?>"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-bar">
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating2_fill ); ?>%"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-count">
                    <?php echo esc_html( $rating2 ); ?>
                </div>
            </div>
            <div class="msbr-review-list-header-rating-bar">
                <div class="msbr-review-list-header-rating-bar-title">
                    <div class="msbr-rating-svg-small" data-rating="<?php echo esc_attr( 1 ); ?>"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-bar">
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating1_fill ); ?>%"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-count">
                    <?php echo esc_html( $rating1 ); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="msbr-review-list-header-left">
        <div class="msbr-review-list-header-info-rating">
            <?php echo wp_sprintf( __( "Rated %s out of 5", "breview" ), "<span>$avg_rating</span>" ) ?><br/>
            <?php echo wp_sprintf( __( "Based on %s reviews", "breview" ), $total_rating ); ?><br/>
            <div class="msbr-rating-svg" data-rating="<?php echo esc_attr( $avg_rating ); ?>"></div>
        </div>
    </div>
</div>