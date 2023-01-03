<?php
/*
Plugin Name:  task5_plugin
Description:  This plugin adds custom field "Additional info" into checkout page WooCommerse. It will also be in emails and in admin panel of order
Version:      1.0
Author:       Andrei Miheev
License:      GPL2
Text domain: tp5
Domain Path: /lang
*/

register_activation_hook( __FILE__, 'tp5_plugin_activate' );
register_deactivation_hook( __FILE__, 'tp5_plugin_deactivate' );

function tp5_plugin_activate() {
	flush_rewrite_rules();
}
function tp5_plugin_deactivate() {
	flush_rewrite_rules();
}

/*
// adding translation
*/
add_action( 'plugins_loaded', 'tp5_load_textdomain' );
function tp5_load_textdomain() {
	load_plugin_textdomain( 'tp5', false, basename ( dirname (__FILE__ ) ) . '/lang' );
}

/*
 * Adding custom field to checkout page
 */
add_action( 'woocommerce_after_order_notes', 'custom_checkout_field' );
function custom_checkout_field($checkout) {
	echo '<div id="my_custom_checkout_field"><h2>' . __('Additional info', 'tp5') . '</h2>';
	woocommerce_form_field('add_info_field', array(
		'type' => 'text',
		'class' => array('my-field-class form-row-wide'),
		'label' => __('Fill in this field', 'tp5'),
		'required' => true, // will remove 'optional' text near field and add red asterisk
		'placeholder' => __('Write your text here', 'tp5'),
		), $checkout->get_value('add_info_field'));
	echo '</div>';
}

/*
 * make this custom field required to fill in
 */
add_action( 'woocommerce_checkout_process', 'custom_checkout_field_process' );
function custom_checkout_field_process() {
	if (!$_POST['add_info_field']) {
		wc_add_notice(__("Please fill in our custom checkout field", "tp5"), 'error');
	}
}

/*
 * update order's metadata
 */
add_action( 'woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta' );
function custom_checkout_field_update_order_meta($order_id) {
	if (!empty($_POST['add_info_field'])) {
		update_post_meta($order_id, 'add_info_field', sanitize_text_field($_POST['add_info_field']));
	}
}

/*
 * add field to the admin page of order
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'custom_checkout_field_display_admin_order_meta', 10, 1 );
function custom_checkout_field_display_admin_order_meta($order) {
	echo '<p><strong>'.__('Additional info', 'tp5').':</strong> ' . get_post_meta($order->id, 'add_info_field', true) . '</p>';
}

/*
 * add custom field to the email after making order
 */
add_filter( 'woocommerce_email_order_meta_keys', 'custom_checkout_field_order_meta_keys' );
function custom_checkout_field_order_meta_keys($keys) {
	$keys[] = 'add_info_field';
	return $keys;
}

/*
 * add custom field to user order info after order is done
 */
add_action( 'woocommerce_order_details_after_order_table', 'custom_checkout_field_display_order_meta', 10, 1 );
function custom_checkout_field_display_order_meta($order){
	echo '<p><strong>'.__('Additional info', 'tp5').':</strong> ' . get_post_meta( $order->id, 'add_info_field', true ) . '</p>';
}

