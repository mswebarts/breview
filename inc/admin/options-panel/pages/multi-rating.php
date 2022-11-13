<?php
$general_tab = menu_page_url('breview-settings', false);
$style_tab   = menu_page_url('breview-style-settings', false);
$email_tab   = menu_page_url('breview-email-settings', false);
$rating_tab  = menu_page_url('breview-multi-rating-settings', false);

$enable_multi_rating = $enable_multi_rating == 1 ? 'checked' : '';
?>

<div id="icon-options-general" class="icon32"></div>
<h1><?php echo esc_html_e('Breview - Better Review for WooCommerce', 'breview'); ?></h1>
<p><?php echo esc_html_e('Breview adds a completely new workflow for reviews in WooCommerce. You can configure all the settings from here.', 'breview'); ?></p>
<div class="wrap mswa-settings-page">

    <div id="poststuff">

        <div id="post-body" class="metabox-holder">

            <!-- main content -->
            <div id="post-body-content">

                <h2 class="nav-tab-wrapper">
                    <a href="<?php echo esc_attr(esc_url($general_tab)); ?>" class="nav-tab">
                        <?php echo esc_html_e('General', 'breview'); ?>
                    </a>
                    <a href="<?php echo esc_attr(esc_url($rating_tab)); ?>" class="nav-tab nav-tab-active">
                        <?php echo esc_html_e('Multi Rating', 'breview'); ?>
                    </a>
                    <a href="<?php echo esc_attr(esc_url($email_tab)); ?>" class="nav-tab">
                        <?php echo esc_html_e('Emails', 'breview'); ?>
                    </a>
                </h2>

                <div class="meta-box-sortables ui-sortable">

                    <div class="postbox">

                        <h2><span><?php esc_html_e('Multi Rating Settings', 'breview'); ?></span></h2>

                        <div class="inside">
                            <p>
                                <?php echo esc_html_e(
                                    'Configure multiple types of ratings for your products. You can add as many ratings as you want. But maximum 5 is recommended.',
                                    'breview'
                                ); ?>
                            </p>

                            <form method="post" action="" class="">
                                <input type="hidden" name="msbr_multi_rating_form_submitted" value="Y">
                                <table class="form-table">
                                    <tr>
                                        <th>
                                            <label for="msbr_enable_multi_rating">
                                                <?php esc_html_e('Enable Multi Rating', 'breview'); ?>
                                        </th>
                                        </label>
                                        <td>
                                            <fieldset>
                                                <legend class="screen-reader-text">
                                                    <span><?php esc_html_e('Enable Multi Rating', 'breview'); ?></span>
                                                </legend>
                                                <input name="msbr_enable_multi_rating" type="checkbox" id="msbr_enable_multi_rating" value="<?php echo esc_attr('1'); ?>" <?php echo esc_attr($enable_multi_rating); ?> />
                                                <span><?php esc_html_e('Checkmark to enable the configured multiple ratings in WooCommerce. Customers will be able to submit these ratings when enabled.', 'breview'); ?></span>
                                            </fieldset>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            <label for="msbr_multi_rating">
                                                <?php esc_html_e('Multi Rating', 'breview'); ?>
                                            </label>
                                        </th>
                                        <td>
                                            <fieldset class="msbr-repeater">
                                                <legend class="screen-reader-text">
                                                    <span><?php esc_html_e('Multi Rating', 'breview'); ?></span>
                                                </legend>
                                                <div data-repeater-list="msbr_multi_rating">
                                                    <?php
                                                    $total_ratings = count($multi_ratings);

                                                    if ($total_ratings > 0) {
                                                        foreach ($multi_ratings as $rating) {
                                                            //var_dump($rating);
                                                    ?>
                                                            <div data-repeater-item>
                                                                <div class="msbr-repeater-field-item-container">
                                                                    <label for="msbr_multi_rating_label">
                                                                        <h4 class="msbr-label-heading">
                                                                            <?php esc_html_e('Unique ID', 'breview'); ?>
                                                                        </h4>
                                                                    </label>
                                                                    <input type="text" class="msbr-multi-rating-id-input" name="msbr_multi_rating_id" placeholder="Add an unique ID for the rating" value="<?php echo esc_attr($rating['msbr_multi_rating_id']); ?>" required />
                                                                    <div class="msbr-field-description">
                                                                        <?php esc_html_e('This is a unique ID for this rating.', 'breview'); ?>
                                                                    </div>
                                                                </div>

                                                                <div class="msbr-repeater-field-item-container">
                                                                    <label for="msbr_multi_rating_name">
                                                                        <h4 class="msbr-label-heading">
                                                                            <?php esc_html_e('Rating Label', 'breview'); ?>
                                                                        </h4>
                                                                    </label>
                                                                    <input type="text" class="msbr-multi-rating-name-input" name="msbr_multi_rating_name" placeholder="Add a name for the rating" value="<?php echo esc_attr( $rating['msbr_multi_rating_name'] ); ?>" required />
                                                                    <div class="msbr-field-description">
                                                                        <?php esc_html_e('Add a label/name to the rating.', 'breview'); ?>
                                                                    </div>
                                                                </div>

                                                                <input data-repeater-delete type="button" value="Delete" />
                                                            </div>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <div data-repeater-item>
                                                            <input type="text" name="msbr_multi_rating_id" placeholder="Add an unique ID for the rating" value="" />
                                                            <input type="text" name="msbr_multi_rating_name" placeholder="Add a name for the rating" value="" />
                                                            <input data-repeater-delete type="button" value="Delete" />
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <input data-repeater-create type="button" value="Add a Rating Criteria" />

                                            </fieldset>
                                        </td>
                                    </tr>
                                </table>

                                <input class="button-primary" type="submit" value="<?php esc_html_e('Save Settings', 'breview'); ?>" />

                                <br class="clear" />
                            </form>
                        </div>
                        <!-- .inside -->

                    </div>
                    <!-- .postbox -->

                </div>
                <!-- .meta-box-sortables .ui-sortable -->

            </div>
            <!-- post-body-content -->

        </div>
        <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div>
    <!-- #poststuff -->

</div> <!-- .wrap -->

<?php wp_enqueue_script("msbr-admin-script"); ?>