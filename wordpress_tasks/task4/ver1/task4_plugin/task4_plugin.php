<?php
/*
Plugin Name:  task4_plugin
Description:  This plugin creates widget that displays links to posts, number of posts is regulated by Title and From date fields using AJAX method.
Version:      1.0
Author:       Andrei Miheev
License:      GPL2
Text Domain: tp4
Domain Path: /languages
*/

include 'inc/class-post-links-widget.php';

register_activation_hook(  __FILE__, 'tp4_plugin_activate'  );
register_deactivation_hook(  __FILE__, 'tp4_plugin_deactivate'  );
add_action( 'wp_enqueue_scripts', 'tp4_wp_enqueue_scripts' );
add_action( 'init', 'tp4_load_textdomain' );

// adding translation
function tp4_load_textdomain() {
	load_plugin_textdomain( 'tp4', false, basename ( dirname (__FILE__ ) ) . '/languages/' );
}

function tp4_plugin_activate() {
	flush_rewrite_rules();
}

function tp4_plugin_deactivate() {
	flush_rewrite_rules();
}

/**
 * Register js script here but activate in widget file (sensei method)
 */
function tp4_wp_enqueue_scripts() {
    wp_register_script( 'script', plugins_url( '/js/script.js', __FILE__ ), array( 'jquery' ), null, true );
}



