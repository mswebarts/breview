<?php
$general_tab = menu_page_url( 'breview-settings', false );
$style_tab   = menu_page_url( 'breview-style-settings', false );
$email_tab   = menu_page_url( 'breview-email-settings', false );

$completed_email_check = $enable_completed_email == 1 ? 'checked' : '';
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
                    <a href="<?php echo esc_attr( esc_url( $general_tab ) ); ?>" class="nav-tab">
                        <?php echo esc_html_e( 'General', 'breview' ); ?>
                    </a>
                    <a href="<?php echo esc_attr( esc_url( $style_tab ) ); ?>" class="nav-tab">
                        <?php echo esc_html_e( 'Style', 'breview' ); ?>
                    </a>
                    <a href="<?php echo esc_attr( esc_url( $email_tab ) ); ?>" class="nav-tab nav-tab-active">
                        <?php echo esc_html_e( 'Emails', 'breview' ); ?>
                    </a>
                </h2>

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><span><?php esc_html_e( 'Email Settings', 'breview' ); ?></span></h2>

						<div class="inside">
							<p>
                                <?php echo esc_html_e(
									'Configure the email settings for Breview.',
									'breview'
								); ?>
                            </p>

							<form method="post" action="">
								<input type="hidden" name="msbr_email_form_submitted" value="Y">
								<table class="form-table">
									<tr>
										<th>
											<label for="msbr_enable_completed_email">
												<?php esc_html_e( 'Review Request on Order Completion', 'breview' ); ?></th>
											</label>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Review Request on Order Completion', 'breview' ); ?></span>
												</legend>
												<input name="msbr_enable_completed_email" type="checkbox" id="msbr_enable_completed_email" value="<?php echo esc_attr( '1' ); ?>" <?php echo esc_attr( $completed_email_check ); ?> />
												<span><?php esc_html_e( 'Check mark to send an email to the customer to review the products when the order gets completed', 'breview' ); ?></span>
											</fieldset>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<?php echo esc_html_e( "To change the texts of the email, override the template or translate the strings using a translation plugin. Copy the file from wc-better-review/templates/emails/completed.php to yourtheme/breview/emails/completed.php", "breview" ); ?>
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