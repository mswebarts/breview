<?php global $msbr_url; ?>
<div class="msbr-box">
    <h3><?php echo esc_html_e( 'Enjoying Breview?', 'breview' ); ?></h3>
    <p>
        <?php echo esc_html_e( 'Leave us a review on Trustpilot and help spread the word!', 'breview' ); ?>
        <a href="<?php echo esc_url( 'https://www.trustpilot.com/evaluate/mswebarts.com?utm_medium=trustbox&utm_source=MSWebArtsBreviewOverview' ); ?>" class="msbr-add-trustpilot-review" target="_blank">
            <?php echo esc_html_e( "Review Us on", "breview" ) . " "; ?>
            <img src="<?php echo esc_url( $msbr_url . 'inc/admin/assets/images/trustpilot-logo.png' ); ?>" alt="<?php echo esc_attr_e( "Trustpilot Logo", "breview" ); ?>">
        </a>
    </p>
</div>