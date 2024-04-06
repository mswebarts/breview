<?php
/**
 * Review form add popup template
 *
 * This template can be overridden by copying it to yourtheme/breview/product/add-review-popup-product.php
 *
 * HOWEVER, on occasion Breview will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package Breview\Templates
 * @version 1.1.0
 */

$item_id          = $data->item_id;
$product_id       = $data->product_id;
$order_identifier = $data->order_identifier;
?>

<div class="msbr-add-review">
	<a href="#msbr-add-review-<?php echo esc_attr( $item_id ); ?>" class="btn button msbr-open-add-review-modal" data-izimodal-open="#msbr-add-review-<?php echo esc_attr( $item_id ); ?>" data-izimodal-transitionin="fadeInDown">
		<?php echo esc_html_e( 'Add Review', 'breview' ); ?>
	</a>
</div>
<div id="msbr-add-review-<?php echo esc_attr( $item_id ); ?>" class="msbr-add-review-modal msbr-modal">
	<!-- modal close -->
	<span class="msbr-modal-close" data-izimodal-close>
		<span class="dashicons dashicons-no-alt"></span>
	</span>
	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product_id ) ) : ?>
		<div class="msbr-review-form-wrapper">
			<div class="msbr-review-form">
				<div class="msbr-review-form-heading">
					<h3 class="msbr-review-form-title"><?php echo esc_html_e( 'Give a Review', 'breview' ); ?></h3>
					<div class="msbr-review-form-description">
						<?php echo esc_html_e( 'Provide a review and help us improve our service.', 'breview' ); ?>
					</div>
				</div>
				<?php
				$commenter    = array(
					'comment_author'       => '',
					'comment_author_email' => '',
					'comment_author_url'   => '',
				);
				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => esc_html( '' ),
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'breview' ),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__( 'Submit', 'breview' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);

				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'label'    => __( 'Name', 'breview' ),
						'type'     => 'text',
						'value'    => $commenter['comment_author'],
						'required' => $name_email_required,
					),
					'email'  => array(
						'label'    => __( 'Email', 'breview' ),
						'type'     => 'email',
						'value'    => $commenter['comment_author_email'],
						'required' => $name_email_required,
					),
				);

				$comment_form['fields'] = array();

				foreach ( $fields as $key => $field ) {
					$field_html  = '<p class="msbr-comment-form-' . esc_attr( $key ) . '">';
					$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

					if ( $field['required'] ) {
						$field_html .= '&nbsp;<span class="required">*</span>';
					}

					$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

					$comment_form['fields'][ $key ] = $field_html;
				}

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'breview' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

				if ( wc_review_ratings_enabled() ) {
					$comment_form['comment_field'] = '<div class="msbr-comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'breview' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" class="msbr-star-rating"' . ( wc_review_ratings_required() ? 'required' : '' ) . '>
							<option value="">' . esc_html__( 'Rate&hellip;', 'breview' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'breview' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'breview' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'breview' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'breview' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'breview' ) . '</option>
						</select></div>';
				}

				$comment_form['comment_field'] .= '<p class="msbr-comment-form-title"><label for="msbr_review_title">' . esc_html__( 'Review Title', 'breview' ) . '&nbsp;<span class="required">*</span></label><input type="text" id="msbr_review_title" name="msbr_review_title" value="" placeholder="' . esc_attr__( 'Add a review title', 'breview' ) . '" required></p>';

				$comment_form['comment_field'] .= '<p class="msbr-comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'breview' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . esc_attr__( 'Write your review in detail', 'breview' ) . '" required></textarea></p>';

				$comment_form['comment_field'] .= '<input type="hidden" name="order_identifier" value="' . esc_attr( $order_identifier ) . '" />';

				$comment_form['comment_field'] .= '<input type="hidden" name="rating" value="' . esc_attr( '' ) . '" />';

				$comment_form['comment_field'] .= wp_nonce_field( 'msbr_review_form_submission_action', 'msbr_review_form_submission_nonce', true, false );

				comment_form( $comment_form, $product_id );
				?>
			</div>
			<div class="msbr-review-success">
				<div class="msbr-review-success-icon-container">
					<span class="msbr-review-success-icon">
						<i class="dashicons-before dashicons-saved"></i>
					</span>
				</div>
				<h3><?php echo esc_html_e( 'Review Submitted Successfully!', 'breview' ); ?></h3>
				<div class="msbr-review-success-description">
					<?php
					$auto_approve = get_option( 'msbr_auto_approve_reviews' );
					echo wp_sprintf(
						wp_kses(
							/* translators: %s is product title */
							__( 'Thank you for giving a review to <b>%s</b>. ', 'breview' ),
							array(
								'b' => array(),
							)
						),
						esc_html( get_the_title( $product_id ) )
					);
					if ( ! $auto_approve ) {
						echo wp_sprintf(
							esc_html__( 'Your review will be published after approval by the admin.', 'breview' )
						);
					}
					?>
				</div>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'breview' ); ?></p>
	<?php endif; ?>

</div>