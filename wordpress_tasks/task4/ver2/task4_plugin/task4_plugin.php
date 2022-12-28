<?php
/*
Plugin Name:  task4_plugin
Description:  This plugin creates widget that displays links to posts, number of posts is regulated in backend, Title and From date fields are regulated on frontend, widget uses AJAX jQuery method.
Version:      1.0
Author:       Andrei Miheev
License:      GPL2
Text Domain: tp4
Domain Path: /languages
*/

include 'inc/class-post-links-widget.php';

register_activation_hook( __FILE__, 'tp4_plugin_activate' );
register_deactivation_hook( __FILE__, 'tp4_plugin_deactivate' );

function tp4_plugin_activate() {
	flush_rewrite_rules();
}
function tp4_plugin_deactivate() {
	flush_rewrite_rules();
}

// adding translation
add_action( 'init', 'tp4_load_textdomain' );
function tp4_load_textdomain() {
	load_plugin_textdomain( 'tp4', false, basename ( dirname (__FILE__ ) ) . '/languages/' );
}

// adding js script
add_action( 'wp_enqueue_scripts', 'tp4_wp_enqueue_script' );
function tp4_wp_enqueue_script() {
	wp_enqueue_script('script', plugins_url('/js/script.js', __FILE__), array('jquery'), null, true);
	wp_localize_script('script', 'tp4ajax',
		array(
			'ajaxurl' => admin_url('admin-ajax.php')
		)
	);
}

// f-n that shows post links after ajax query is done
add_action( 'wp_ajax_show', 'show_post_links_callback' );
add_action( 'wp_ajax_nopriv_show', 'show_post_links_callback' ); // for non authorised users
function show_post_links_callback() {
	global $wpdb;
	$number_of_posts = $_GET['number_of_posts'] ?? '';
	$title = $_GET['title'] ?? '';
	$from_date = $_GET['from_date'] ?? '';
	$my_post_ids = $wpdb->get_col("SELECT id FROM $wpdb->posts WHERE post_title LIKE '%$title%' ");
	$args = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => $number_of_posts, 
		'post__in'       => $my_post_ids, 
		'date_query'     => array( 'after' => $from_date ),
	);
	$q = new WP_Query( $args );
	if( $q->have_posts() ):
        ?>
		<ul>
			<?php
			while( $q->have_posts() ):
				$q->the_post();
				?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
			<?php endwhile; ?>
		</ul>
	<?php
	endif;
	wp_reset_postdata();
    wp_die(); 
}


