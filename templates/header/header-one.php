<?php
$product = $data->product;

$total_rating = $product->get_review_count();
$avg_rating   = $product->get_average_rating();

$rating1      = $product->get_rating_count(1);
$rating2      = $product->get_rating_count(2);
$rating3      = $product->get_rating_count(3);
$rating4      = $product->get_rating_count(4);
$rating5      = $product->get_rating_count(5);
?>

<div class="msbr-review-list-header-design-one">
    <div class="msbr-review-list-header-left">
        <div class="msbr-review-list-header-info-rating">
            <?php echo wp_sprintf( __( "Rated %s out of 5", "breview" ), "<span>$avg_rating</span>" ) ?><br/>
            <?php echo wp_sprintf( __( "Based on %s reviews", "breview" ), $total_rating ); ?><br/>
            <div class="msbr-rating-svg" data-rating="<?php echo esc_attr( $avg_rating ); ?>"></div>
        </div>
    </div>
    <div class="msbr-review-list-header-right">
        <?php
            var_dump($rating1);
            var_dump($rating2);
            var_dump($rating3);
            var_dump($rating4);
            var_dump($rating5);
        ?>
    </div>
</div>