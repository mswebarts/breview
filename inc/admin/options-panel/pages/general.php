<?php
$general_tab = menu_page_url( 'breview-settings', false );
$style_tab   = menu_page_url( 'breview-style-settings', false );
$email_tab   = menu_page_url( 'breview-email-settings', false );
?>

<div id="icon-options-general" class="icon32"></div>
<h1><?php echo esc_html_e( 'Breview - Better Review for WooCommerce', 'breview' ); ?></h1>
<p><?php echo esc_html_e( 'Breview adds a completely new workflow for reviews in WooCommerce. You can configure all the settings from here.', 'breview' ); ?></p>
<div class="wrap msbr-settings-page">

	<div id="poststuff">

		<div id="post-body" class="metabox-holder">

			<!-- main content -->
			<div id="post-body-content">
            
                <h2 class="nav-tab-wrapper">
                    <a href="<?php echo esc_attr( esc_url( $general_tab ) ); ?>" class="nav-tab nav-tab-active">
						<?php echo esc_html_e( 'General', 'breview' ); ?>
					</a>
                    <a href="<?php echo esc_attr( esc_url( $style_tab ) ); ?>" class="nav-tab">
						<?php echo esc_html_e( 'Style', 'breview' ); ?>
					</a>
                    <a href="<?php echo esc_attr( esc_url( $email_tab ) ); ?>" class="nav-tab">
						<?php echo esc_html_e( 'Emails', 'breview' ); ?>
					</a>
                </h2>

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><span><?php esc_html_e( 'Main Content Header', 'breview' ); ?></span></h2>

						<div class="inside">
							<p>
                                <?php esc_html_e(
									'WordPress started in 2003 with a single bit of code to enhance the typography of everyday writing and with fewer users than you can count on your fingers and toes. Since then it has grown to be the largest self-hosted blogging tool in the world, used on millions of sites and seen by tens of millions of people every day.',
									'breview'
								); ?>
                            </p>
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