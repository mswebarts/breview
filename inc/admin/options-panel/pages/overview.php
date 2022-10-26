<div id="icon-options-general" class="icon32"></div>
<h1><?php echo esc_html_e( 'Breview - Better Review for WooCommerce', 'breview' ); ?></h1>
<p><?php echo esc_html_e( 'Breview adds a completely new workflow for reviews in WooCommerce. You can configure all the settings from here.', 'breview' ); ?></p>

<div class="wrap msbr-settings-page">

	<div id="icon-options-general" class="icon32"></div>
	<h1><?php esc_html_e( 'Heading', 'breview' ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

                <div class="postbox">

                    <div class="inside">
                        <?php do_action( 'msbr_license_box' ); ?>
                    </div>
                    <!-- .inside -->

                </div>
                <!-- .postbox -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

                <div class="postbox">

                    <button type="button" class="handlediv" aria-expanded="true" >
                        <span class="screen-reader-text">Toggle panel</span>
                        <span class="toggle-indicator" aria-hidden="true"></span>
                    </button>
                    <!-- Toggle -->

                    <h2 class="hndle"><span><?php esc_html_e(
                                'Sidebar Content Header', 'breview'
                            ); ?></span></h2>

                    <div class="inside">
                        <p><?php esc_html_e( 'Everything you see here, from the documentation to the code itself, was created by and for the community. WordPress is an Open Source project, which means there are hundreds of people all over the world working on it. (More than most commercial platforms.) It also means you are free to use it for anything from your cat’s home page to a Fortune 500 web site without paying anyone a license fee and a number of other important freedoms.',
                                            'breview' ); ?></p>
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