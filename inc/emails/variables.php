<?php
add_action( 'fue_before_variable_replacements', 'msbr_register_variable_replacements', 10, 4 );
function msbr_register_variable_replacements( $var, $email_data, $fue_email, $queue_item ) { 
    $variables = array(
    	'view_order'	=> ''
	);

    if ( isset( $email_data['test'] ) && $email_data['test'] ) {
        $variables['view_order'] = '13221';

        if ( !empty( $email_data['order_id'] ) ) {
            $order = wc_get_order( $email_data['order_id'] );
            $view_order = wc_get_endpoint_url( 'view-order' ) . $queue_item->order_id;

            if ( !empty( $view_order ) ) {
                $variables['view_order'] = $view_order;
            }
        }
    } else {
        if ( !empty( $queue_item->order_id ) ) {
            $order      = wc_get_order( $queue_item->order_id );
            $view_order = wc_get_endpoint_url( 'view-order' ) . $queue_item->order_id;

            if ( !empty( $view_order ) ) {
                $variables['view_order'] = $view_order;
            }
        }
    }

    $var->register( $variables );
}