<?php
/**
 * Completed email template.
 *
 * @package breview
 * @since 1.1.0
 */

if ( ! function_exists( 'msbr_completed_email_notification' ) ) {
	add_action( 'woocommerce_order_status_changed', 'msbr_completed_email_notification' );
	/**
	 * Send completed email notification.
	 *
	 * @param int $order_id Order ID.
	 */
	function msbr_completed_email_notification( $order_id ) {
		global $woocommerce;
		$templates    = new MSBR_Template_Loader();
		$msbr_options = get_option( 'msbr_email_options' );

		if ( $msbr_options['msbr_enable_completed_email'] ) {
			$order = new WC_Order( $order_id );
			if ( $order->get_status() === 'completed' ) {
				$data = array(
					'order_id' => $order_id,
					'order'    => $order,
				);
				$templates->set_template_data( $data )->get_template_part( 'emails/completed' );
			}
		}
	}
}
