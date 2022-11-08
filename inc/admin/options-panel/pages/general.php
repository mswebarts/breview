<?php
$general_tab = menu_page_url( 'breview-settings', false );
$style_tab   = menu_page_url( 'breview-style-settings', false );
$email_tab   = menu_page_url( 'breview-email-settings', false );
$rating_tab  = menu_page_url( 'breview-multi-rating-settings', false );

$add_review_check = $display_add_review_on_product == '1' ? 'checked' : '';
?>

<div id="icon-options-general" class="icon32"></div>
<h1><?php echo esc_html_e( 'Breview - Better Review for WooCommerce', 'breview' ); ?></h1>
<p><?php echo esc_html_e( 'Breview adds a completely new workflow for reviews in WooCommerce. You can configure all the settings from here.', 'breview' ); ?></p>
<div class="wrap mswa-settings-page">

	<div id="poststuff">

		<div id="post-body" class="metabox-holder">

			<!-- main content -->
			<div id="post-body-content">
            
                <h2 class="nav-tab-wrapper">
                    <a href="<?php echo esc_attr( esc_url( $general_tab ) ); ?>" class="nav-tab nav-tab-active">
						<?php echo esc_html_e( 'General', 'breview' ); ?>
					</a>
                    <a href="<?php echo esc_attr( esc_url( $rating_tab ) ); ?>" class="nav-tab">
                        <?php echo esc_html_e( 'Multi Rating', 'breview' ); ?>
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
										<th>
											<label for="msbr_display_add_review_product">
												<?php esc_html_e( 'Display Add Review Form', 'breview' ); ?></th>
											</label>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Display Add Review Form', 'breview' ); ?></span>
												</legend>
												<input name="msbr_display_add_review_product" type="checkbox" id="msbr_display_add_review_product" value="<?php echo esc_attr( '1' ); ?>" <?php echo esc_attr( $add_review_check ); ?> />
												<span><?php esc_html_e( 'Check to display the Add Review form in product pages.', 'breview' ); ?></span>
											</fieldset>
										</td>
									</tr>
									<tr>
										<th>
											<label for="msbr_review_form_max_char">
												<?php esc_html_e( 'Max Characters Allowed', 'breview' ); ?>
											</label>
										</th>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Max Characters Allowed', 'breview' ); ?></span>
												</legend>
												<label for="msbr_review_form_max_char">
													<input type="number" name="msbr_review_form_max_char" value="<?php echo esc_attr( $review_max_char ); ?>" class="regular-text" /><br/>
													<span><?php esc_html_e( 'Input the maximum characters allowed for the Add Review Form\'s Review field in the order page', 'breview' ); ?></span>
												</label>
											</fieldset>
										</td>
									</tr>
									<tr>
										<th>
											<label for="msbr_reviewer_avatar_size">
												<?php esc_html_e( 'Reviewer Avatar Size(px)', 'breview' ); ?>
											</label>
										</th>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Reviewer Avatar Size(px)', 'breview' ); ?></span>
												</legend>
												<label for="msbr_reviewer_avatar_size">
													<input type="number" name="msbr_reviewer_avatar_size" value="<?php echo esc_attr( $reviewer_avatar_size ); ?>" class="regular-text" /><br/>
													<span><?php esc_html_e( 'Set the reviewer/customer avatar size in Review list', 'breview' ); ?></span>
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