<?php
$general_tab = menu_page_url( 'breview-settings', false );
$style_tab   = menu_page_url( 'breview-style-settings', false );
$email_tab   = menu_page_url( 'breview-email-settings', false );
var_dump( $display_add_review_on_product );
$add_review_check = $display_add_review_on_product == '1' ? 'checked' : '';

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

						<h2><span><?php esc_html_e( 'General Settings', 'breview' ); ?></span></h2>
						<div class="inside">
							<p>
                                <?php echo esc_html_e(
									'Configure the general settings for Breview.',
									'breview'
								); ?>
                            </p>

							<form method="post" action="">
								<input type="hidden" name="msbr_general_form_submitted" value="Y">
								<table class="form-table">
									<tr>
										<th><?php esc_html_e( 'Display Add Review Form', 'breview' ); ?></th>
										<td>
											<fieldset>
												<legend class="screen-reader-text"><span><?php esc_html_e( 'Display Add Review Form', 'breview' ); ?></span></legend>
												<label for="users_can_register">
													<input name="msbr_display_add_review_product" type="checkbox" id="msbr_display_add_review_product" value="<?php echo esc_attr( '1' ); ?>" <?php echo esc_attr( $add_review_check ); ?> />
													<span><?php esc_html_e( 'Check to display the Add Review form in product pages.', 'breview' ); ?></span>
												</label>
											</fieldset>
										</td>
									</tr>
								</table>

								<input class="button-primary" type="submit" value="<?php esc_html_e( 'Save Settings', 'breview' ); ?>" />

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