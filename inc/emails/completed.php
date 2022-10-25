<?php
add_action("woocommerce_order_status_changed", "my_awesome_publication_notification");
function my_awesome_publication_notification($order_id, $checkout=null) {
   global $woocommerce;

   $order = new WC_Order( $order_id );
   if($order->status === 'completed' ) {
        // Create a mailer
        $mailer = $woocommerce->mailer();

        // message header text
        $message_head = sprintf( __( 'Give a review to your order #%s', 'breview' ), $order_id );
        
        // message subject
        $subject = sprintf( __( 'Give a review to your order #%s', 'breview' ), $order_id );

        // message body text
        $message_body = wp_sprintf( __( 'Congratulations! The order has just been completed. We hope you have got the product without any issue. Please provide review for the products in order #%s. It will motivate us to provide better service and grow our business.', 'breview' ), $order_id );
        $message_body .= '<br/>';
        $message_body .= '<a style="background-color: inherit; bgcolor:inherit;" href=' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . 'view-order' . '/' . $order_id . ' target="_blank">Add Review</a>';

        $message = $mailer->wrap_message(
            // Message head and message body.
            $message_head, $message_body
        );
            
        // Client email, email subject and message.
        $mailer->send( $order->billing_email, $subject, $message );
    }
}