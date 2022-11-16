<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/breview/product/review-design-two/review-design-two-item.php
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<li <?php comment_class(); ?> id="msbr-li-review-<?php comment_ID(); ?>">

	<div id="msbr-review-<?php comment_ID(); ?>" class="msbr-review-container">
		<div class="msbr-review-left">
            
			<?php do_action( 'msbr_review_before_rating') ?>
			<div class="msbr-review-rating">
				<?php
				/**
				 * The msbr_review_rating hook.
				 *
				 * @hooked msbr_review_design_two_rating_header - 5
				 * @hooked msbr_review_display_rating - 10
				 * @hooked msbr_review_design_single_star_rating - 10
				 */
				do_action( 'msbr_review_rating', $comment );
				?>
			</div>
			<?php do_action( 'msbr_review_after_rating') ?>
			
		</div>

		<div class="msbr-review-right">
            
			<?php do_action( 'msbr_review_before_user' ); ?>
			<div class="msbr-review-user">
				<?php
				/**
				 * The msbr_review_user hook.
				 *
				 * @hooked msbr_review_display_gravatar - 10
				 * @hooked msbr_review_display_meta - 20
				 */
				do_action( 'msbr_review_user', $comment );
				?>
			</div>
			<?php do_action( 'msbr_review_after_user' ); ?>

			<?php do_action( 'msbr_review_before_content') ?>
			<div class="msbr-review-content">
				<?php
				/**
				 * The msbr_review_content hook.
				 *
				 * @hooked msbr_review_display_comment_title - 5
				 * @hooked msbr_review_display_comment_description - 10
				 */
				do_action( 'msbr_review_content', $comment );
				?>
			</div>
			<?php do_action( 'msbr_review_after_content') ?>
		</div>
	</div>
