<?php

// turn on styles of child theme
add_action( 'wp_enqueue_scripts', 'true_child_styles' );
function true_child_styles() {

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array(), null  );
}

