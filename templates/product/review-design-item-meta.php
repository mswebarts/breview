<?php
/**
 * The template is used to display the reviewers meta data (name, verified owner, review date). This template is not applied to Default Design.
 * If you want to update the default design, please update the review-meta.php file in the woocommerce plugin folder.
 *
 * This template can be overridden by copying it to yourtheme/breview/product/review-design-meta.php.
 *
 * HOWEVER, on occasion Breview will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package Breview\Templates
 * @version 1.0.3
 */

defined( 'ABSPATH' ) || exit;

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) { ?>

	<p class="meta">
		<em class="woocommerce-review__awaiting-approval">
			<?php esc_html_e( 'Your review is awaiting approval', 'woocommerce' ); ?>
		</em>
	</p>

<?php } else { ?>

	<div class="meta">
		<strong class="msbr-review-author"><?php comment_author(); ?> </strong>
		<?php
		if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
			echo '<span class="msbr-review-verified verified dashicons-before dashicons-yes-alt"></span> ';
		}
		?>
		<div class="msbr-review-time">
			<time class="msbr-review-published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></time>
		</div>
	</div>

	<?php
}
