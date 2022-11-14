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

<div class="msbr-review-list-header-design-one msbr-alt">
    <div class="msbr-review-list-header-right">
        <div class="msbr-review-list-header-rating-bars">
            <div class="msbr-review-list-header-rating-bar">
                <div class="msbr-review-list-header-rating-bar-title">
                <div class="msbr-rating-svg-small" data-rating="<?php echo esc_attr( 5 ); ?>"></div>
                </div>
                <div class="msbr-review-list-header-rating-bar-bar">
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating5 / $total_rating * 100 ); ?>%"></div>
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
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating4 / $total_rating * 100 ); ?>%"></div>
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
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating3 / $total_rating * 100 ); ?>%"></div>
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
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating2 / $total_rating * 100 ); ?>%"></div>
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
                    <div class="msbr-review-list-header-rating-bar-bar-fill" style="width: <?php echo esc_attr( $rating1 / $total_rating * 100 ); ?>%"></div>
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