<?php
add_action("woocommerce_order_status_changed", "my_awesome_publication_notification");
function my_awesome_publication_notification($order_id, $checkout=null) {
   global $woocommerce;
   $templates = new MSBR_Template_Loader();
   
   $order = new WC_Order( $order_id );
   if($order->get_status() === 'completed' ) {
        $data = array(
            'order_id' => $order_id,
            'order'    => $order,
        );
        $templates->set_template_data($data)->get_template_part('emails/completed');
    }
}