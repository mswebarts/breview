<?php
/**
 * Template for sending out an email to the customer
 * requesting them to give a reviewwhen an order is completed.
 *
 * 
 * This template can be overridden by copying it to yourtheme/breview/emails/completed.php
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
global $woocommerce;
$order = $data->order;
$order_id = $data->order_id;

// Create a mailer
$mailer = $woocommerce->mailer();

// message header text
$message_head = sprintf( __( 'Give a review to your order #%s', 'breview' ), $order_id );

// message subject
$subject = sprintf( __( 'Give a review to your order #%s', 'breview' ), $order_id );

// message body text
$message_body = wp_sprintf( __( 'Congratulations! The order has just been completed. We hope you have got the product without any issue. Please provide review for the products in order #%s. It will motivate us to provide better service and grow our business.', 'breview' ), $order_id );
$message_body .= '<br/>';
$message_body .= '<a style="background-color: inherit; bgcolor:inherit;" href=' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . 'view-order' . '/' . $order_id . ' target="_blank">'. __("Add a Review", "breview") .'</a>';

$message = $mailer->wrap_message(
    // Message head and message body.
    $message_head, $message_body
);
    
// Client email, email subject and message.
$mailer->send( $order->get_billing_email(), $subject, $message );