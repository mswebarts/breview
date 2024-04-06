<?php
/**
 * Template for sending out an email to the customer
 * requesting them to give a reviewwhen an order is completed.
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
$order_data = $data->order;
$order_id   = $data->order_id;

// Create a mailer.
$mailer = $woocommerce->mailer();

// Message header text.
/* translators: %s is $order_id. */
$message_head = sprintf( __( 'Give a review to your order #%s', 'breview' ), $order_id );

// Message subject.
/* translators: %s is $order_id. */
$subject = sprintf( __( 'Give a review to your order #%s', 'breview' ), $order_id );

/* translators: %1$s is $order_id, %2$s is get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) and %3$s is Add a Review button text */
$message_body = sprintf( __( 'Congratulations! The order has just been completed. We hope you have got the product without any issue. Please provide review for the products in order #%1$s. It will motivate us to provide better service and grow our business.<br/><a style="background-color: inherit; bgcolor:inherit;" href="%2$sview-order/%1$s" target="_blank">%3$s</a>', 'breview' ), $order_id, get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ), __( 'Add a Review', 'breview' ) );

$message = $mailer->wrap_message(
	// Message head and message body.
	$message_head,
	$message_body
);

// Client email, email subject and message.
$mailer->send( $order_data->get_billing_email(), $subject, $message );
