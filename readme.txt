=== WC Better Review ===
Contributors: mswebarts, msshohan
Tags:  better, review, order, woocommerce
Requires at least: 4.6
Tested up to: 5.9
Requires PHP: 5.6
Stable tag: 1.2.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin will help you improve the WooCommerce workflow and gain customer trust by completing the order only when they have received the products. 

== Description ==

Imagine the current workflow of WooCommerce where the admin is the only one who can change the order status to completed. The customers don’t have the option to approve order/product delivery from their end. So, the admins can’t verify if the product has been received by the customer or not. Also when a customer will see the order marked
as Completed even though he/she has not received it, it will be a disaster for the trust of your BRAND. And this is where this plugin
comes into play.

At first, you will ship the product after an order has been placed. Then you will need to select the order status as
Delivered. When the admin marks it as delivered, the customer will see a button named “Mark as Received” in the actions section
on the My Accounts -> Orders page. Once the customer has received the product, he/she will just need to click on the "Mark as Received" button and the order status will be automatically marked as Completed upon the click.

[youtube https://youtu.be/Q3qcKCD94e0]

== Update ==
* Added compatibility for WordPress 5.8
* Hidden Mark As Received button after form submit
* Fixed order status text update without manually refreshing

== Benefits ==

1. Improving the Workflow of the woocommerce shop
2. Gaining customer trust
3. Improving brand reputation by streamlining the process of product delivery


== Installation ==

This section describes how to install the plugin and get it working.

**Method One**

1. Go to your wordpress admin dashboard -> Plugins -> Add New
2. Search for "WC Better Review"
3. Click on Install button and then activate.

**Method Two**

1. Download the plugin from wordpress.org plugin repository
2. Go to your wordpress admin dashboard -> Plugins -> Add New
3. Click on the "Upload Plugin" button
4. Upload the downloaded plugin zip file
5. Then activate it and it will start working right away if WooCommerce is active.

**Method Three**

1. Download the plugin from wordpress.org plugin repository
2. Connect to your hosting with an FTP account or File Manager in your Hosting account
3. Go to the WordPress installation directory -> wp-content -> plugins
4. Upload the downloaded plugin's uncompressed folder ( if using FTP ) or zip file ( if Hosting cPanel ). You must extract the file from hosting cPanel if you upload zip file
5. Then go to WordPress admin dashboard -> Plugins -> Installed Plugins -> Then activate WC Better Review

Hope the installation process was as smooth as the plugin works!


== Frequently Asked Questions ==

= When will customers see Mark as Received button? =

The customers will see this button only if the order status is set as Delivered because
we don't want them to be able to mark the order as Completed when the order is in processing or in any other status.

= How to customize the button? =

At this initial release, we have avoided extra customizations. We have some ideas to make this a great plugin for you but first,
we need to see if this plugin will be useful to users.

= How can I contribute to the plugin? =

It's an open source plugin and you can contribute on Github at this [Repository](https://github.com/mswebarts/order-approval-by-customer-for-woocommerce)

== Screenshots ==

1. /assets/screenshots/screenshot-1.png
2. /assets/screenshots/screenshot-2.png

== Changelog ==

= 1.0.1 =
* Initial release

= 1.2 =
* Added compatibility for WordPress 5.6.2
* Hidden Mark As Received button after form submit
* Fixed order status text update without manually refreshing

= 1.2.1 =
* Added compatibility for WordPress 5.8