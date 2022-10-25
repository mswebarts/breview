<?php
add_action("woocommerce_order_status_changed", "my_awesome_publication_notification");
function my_awesome_publication_notification($order_id, $checkout=null) {
   global $woocommerce;
   $order = new WC_Order( $order_id );
   if($order->status === 'completed' ) {
        // Create a mailer
        $mailer = $woocommerce->mailer();

        $message_body = __( 'Hello world!!!', 'breview' );

        $message = $mailer->wrap_message(
            // Message head and message body.
            sprintf( __( 'Order %s received', 'breview' ), $order->get_order_number() ), $message_body
        );
            
        // Client email, email subject and message.
        $mailer->send( $order->billing_email, sprintf( __( 'Order %s received' ), $order->get_order_number() ), $message );
    }
}