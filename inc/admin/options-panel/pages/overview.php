<?php
global $msbr_url;
?>
<h1 class="msbr-admin-options-page-title">
    <img src="<?php echo esc_url( $msbr_url . 'inc/admin/assets/images/logo.png' ); ?>" alt="">
    <span><?php echo esc_html_e( 'MS Web Arts Overview', 'breview' ); ?></span>
</h1>
<p><?php echo esc_html_e( 'This page contains the license activations for plugins provided by MS Web Arts and latest news/updates from us', 'breview' ); ?></p>

<div class="wrap mswa-settings-page">

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">
                
                <div class="inside">
                    <div class="mswa-row">
                        <div class="mswa-col-4">
                            <div class="mswa-box">
                                <h3 class="msbr-column-title"><i class="dashicons-before dashicons-admin-links"></i> <?php _e("Important Links", 'breview');?> </h3>
                                <hr>
                                <div class="msbr-column-content">
                                    <ul>
                                        <li><a href="https://www.mswebarts.com/products/breview/" target="_blank"><?php _e("Plugin Homepage", 'breview');?></a></li>
                                        <li><a href="https://www.mswebarts.com/documentation/" target="_blank"><?php _e("Documentation", 'breview');?></a></li>
                                        <li><a href="https://www.mswebarts.com/support/" target="_blank"><?php _e("Support", 'breview');?></a></li>
                                        <li><a href="https://www.mswebarts.com/documentation/breview/faqs/" target="_blank"><?php _e("FAQ", 'breview');?></a></li>
                                        <li><a href="https://www.mswebarts.com/documentation/breview/changelog/" target="_blank"><?php _e("Changelog", 'breview');?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php do_action( 'mswa_overview_columns' ); ?>
                    </div>
                </div>
                <!-- .inside -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

                <div class="postbox">

                    <div class="inside">
                        <?php do_action( 'mswa_overview_sidebar' ); ?>
                    </div>
                    <!-- .inside -->

                </div>
                <!-- .postbox -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->