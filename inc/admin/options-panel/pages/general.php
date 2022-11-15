<?php
$general_tab = menu_page_url( 'breview-settings', false );
$style_tab   = menu_page_url( 'breview-style-settings', false );
$email_tab   = menu_page_url( 'breview-email-settings', false );
$rating_tab  = menu_page_url( 'breview-multi-rating-settings', false );

$add_review_check                  = $display_add_review_on_product == '1' ? 'checked' : '';
$auto_approve_check                = $auto_approve == '1' ? 'checked' : '';
// header designs
$review_header_default_checked     = $review_list_header == 'default' ? 'checked' : '';
$review_header_one_checked         = $review_list_header == 'one' ? 'checked' : '';
$review_header_one_alt_checked     = $review_list_header == 'one-alt' ? 'checked' : '';
// review list designs
$review_list_default_checked       = $review_list_design == 'default' ? 'checked' : '';
$review_list_one_checked           = $review_list_design == 'one' ? 'checked' : '';
$review_list_two_checked		   = $review_list_design == 'two' ? 'checked' : '';
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

				<div class="mswa-form-wrapper">
					<form method="post" action="">
						<input type="hidden" name="msbr_general_form_submitted" value="Y">
						<div class="mswa-section-wrapper">
							<div class="mswa-section">
								<div class="mswa-section-heading">
									<h2><?php echo esc_html_e( 'Review Submission Settings', 'breview' ); ?></h2>
									<p>
										<?php echo esc_html_e( 'Configure the general settings for review submissions.', 'breview' ); ?>
									</p>
								</div>

								<table class="form-table">
									<tr>
										<th>
											<label for="msbr_review_form_desc_min_char">
												<?php esc_html_e( 'Review Description Min Chars', 'breview' ); ?>
											</label>
										</th>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Review Description Min Chars', 'breview' ); ?></span>
												</legend>
												<label for="msbr_review_form_desc_min_char">
													<input type="number" name="msbr_review_form_desc_min_char" value="<?php echo esc_attr( $review_min_char ); ?>" class="regular-text" /><br/>
													<span><?php esc_html_e( 'Input the minimum characters allowed for the Add Review Form\'s Review description field in the order page', 'breview' ); ?></span>
												</label>
											</fieldset>
										</td>
									</tr>
									<tr>
										<th>
											<label for="msbr_review_form_desc_max_char">
												<?php esc_html_e( 'Review Description Max Chars', 'breview' ); ?>
											</label>
										</th>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Review Description Max Chars', 'breview' ); ?></span>
												</legend>
												<label for="msbr_review_form_desc_max_char">
													<input type="number" name="msbr_review_form_desc_max_char" value="<?php echo esc_attr( $review_max_char ); ?>" class="regular-text" /><br/>
													<span><?php esc_html_e( 'Input the maximum characters allowed for the Add Review Form\'s Review Description field in the order page', 'breview' ); ?></span>
												</label>
											</fieldset>
										</td>
									</tr>
									<tr>
										<th>
											<label for="msbr_auto_approve_reviews">
												<?php esc_html_e( 'Auto Approve Reviews', 'breview' ); ?></th>
											</label>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Auto Approve Reviews', 'breview' ); ?></span>
												</legend>
												<input name="msbr_auto_approve_reviews" type="checkbox" id="msbr_auto_approve_reviews" value="<?php echo esc_attr( '1' ); ?>" <?php echo esc_attr( $auto_approve_check ); ?> />
												<span><?php esc_html_e( 'Approve the customer submitted reviews automatically', 'breview' ); ?></span>
											</fieldset>
										</td>
									</tr>
								</table>
							</div>
							<div class="mswa-section">
								<div class="mswa-section-heading">
									<h2><?php echo esc_html_e( 'Review Display Settings', 'breview' ); ?></h2>
									<p>
										<?php echo esc_html_e( 'Configure the general settings for displaying the reviews.', 'breview' ); ?>
									</p>
								</div>

								<table class="form-table">
									<tr>
										<th>
											<label for="msbr_review_list_header_design">
												<?php esc_html_e( 'Review List Header Design', 'breview' ); ?></th>
											</label>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Review List Header Design', 'breview' ); ?></span>
												</legend>
												<div class="mswa-radio-groups">
													<span class="mswa-radio-group">
														<input name="msbr_review_list_header_design" type="radio" value="<?php echo esc_attr('default') ?>" <?php echo esc_attr( $review_header_default_checked ); ?>/>
														<label for="default">
															<?php echo esc_html_e( 'Theme Specific', 'breview' ); ?>
														</label>
													</span>
													<span class="mswa-radio-group">
														<input name="msbr_review_list_header_design" type="radio" value="<?php echo esc_attr('one'); ?>" <?php echo esc_attr( $review_header_one_checked ); ?>/>
														<label for="one">
															<?php echo esc_html_e( 'Design One', 'breview' ); ?>
														</label>
													</span>
													<span class="mswa-radio-group">
														<input name="msbr_review_list_header_design" type="radio" value="<?php echo esc_attr('one-alt'); ?>" <?php echo esc_attr( $review_header_one_alt_checked ); ?>/>
														<label for="one-alt">
															<?php echo esc_html_e( 'Design One Alt', 'breview' ); ?>
														</label>
													</span>
												</div>

												<span><?php esc_html_e( 'Select the design that you want to show as the header of the Reviews list in the single product pages. Design and layout will be controlled by the theme if Theme Specific selected.', 'breview' ); ?></span>
											</fieldset>
										</td>
									</tr>
									<tr>
										<th>
											<label for="msbr_review_list_design">
												<?php esc_html_e( 'Review List Design', 'breview' ); ?></th>
											</label>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Review List Design', 'breview' ); ?></span>
												</legend>
												<div class="mswa-radio-groups">
													<span class="mswa-radio-group">
														<input name="msbr_review_list_design" type="radio" value="<?php echo esc_attr('default') ?>" <?php echo esc_attr( $review_list_default_checked ); ?>/>
														<label for="default">
															<?php echo esc_html_e( 'Theme Specific', 'breview' ); ?>
														</label>
													</span>
													<span class="mswa-radio-group">
														<input name="msbr_review_list_design" type="radio" value="<?php echo esc_attr('one'); ?>" <?php echo esc_attr( $review_list_one_checked ); ?>/>
														<label for="one">
															<?php echo esc_html_e( 'Design One', 'breview' ); ?>
														</label>
													</span>
													<span class="mswa-radio-group">
														<input name="msbr_review_list_design" type="radio" value="<?php echo esc_attr('two'); ?>" <?php echo esc_attr( $review_list_two_checked ); ?>/>
														<label for="two">
															<?php echo esc_html_e( 'Design Two', 'breview' ); ?>
														</label>
													</span>
												</div>

												<span><?php esc_html_e( 'Select the design that you want to show as the header of the Reviews list in the single product pages. Design and layout will be controlled by the theme if Theme Specific selected.', 'breview' ); ?></span>
											</fieldset>
										</td>
									</tr>
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
												<span><?php esc_html_e( 'Check to display the Add Review form in product pages. Not compatible with multi-rating yet.', 'breview' ); ?></span>
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
							</div>
						</div>

						<input class="button-primary" type="submit" value="<?php esc_html_e( 'Save Settings', 'breview' ); ?>" />

						<br class="clear" />
					</form>
				</div>

			</div>
			<!-- post-body-content -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->