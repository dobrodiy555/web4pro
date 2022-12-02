<?php
include 'inc/class-events-widget.php';
/*
Plugin Name:  task2_plugin
Description:  This plugin will create 'events' post type, create fields, taxonomy, widget for displaying upcoming events and shortcode.
Version:      1.0
Author:       Andrei Miheev
License:      GPL2
*/

/*
* creating post type 'events'
*/
function tp_create_posttype() {
	register_post_type( 'events',
		array(
			'labels' => array(
				'name' => __( 'Events' ), //  __ translation f-n
				'singular_name' => __( 'Event' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'events'),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'tp_create_posttype');  // hook

/*
* creating custom fields for post type 'events'
*/
add_action( 'admin_menu', 'tp_add_metabox' );
//add_action( 'add_meta_boxes_events', 'andrei_add_metabox');
//add_action( 'add_meta_boxes', 'andrei_add_metabox' ); also possible fun-s

function tp_add_metabox() {
	add_meta_box(
		'tp_metabox',
		'Meta Box',
		'tp_metabox_callback',
		'events',
		'normal',
		'default'
	);
}

function tp_metabox_callback( $post ) {
	$event_status = get_post_meta( $post->ID, 'event_status', true );
	$event_date = get_post_meta( $post->ID, 'event_date', true );
	wp_nonce_field( 'somerandomstr', '_andreinonce'); // for security
	echo '<table class="form-table">
	<tbody>
		<tr>
				<th><label for="event_status">Event status</label></th>
				<td>
					<select id="event_status" name="event_status">
						<option value="Open"' . selected( 'Open',  $event_status, false ) . '>Open</option>
						<option value="Invitation only"' . selected('Invitation only', $event_status, false ) . '>Invitation only</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="event_date">Event date</label></th>
				<td><input type="date" id="event_date" name="event_date" value="' . esc_attr( $event_date ) . '" class="regular-text"></td>
			</tr>
		</tbody>
	</table>';
}

function tp_save_meta( $post_id, $post ) {
	if ( ! isset( $_POST[ '_andreinonce' ] ) || ! wp_verify_nonce( $_POST[ '_andreinonce'], 'somerandomstr' ) ) {
		return $post_id;
	}
	// check current user permissions
	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}
	// Do not save the data if autosave
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}
	// define your own post type here
//	if( 'page' !== $post->post_type ) {  because of that didn't save metadata in db
//		return $post_id;
//	}
	if( isset( $_POST[ 'event_status' ] ) ) {
		update_post_meta( $post_id, 'event_status', sanitize_text_field( $_POST[ 'event_status' ] ) );
	} else {
		delete_post_meta( $post_id, 'event_status' );
	}
	if( isset( $_POST[ 'event_date' ] ) ) {
		update_post_meta( $post_id, 'event_date', sanitize_text_field( $_POST[ 'event_date' ] ) );
	} else {
		delete_post_meta( $post_id, 'event_date' );
	}
	return $post_id;
}
add_action( 'save_post', 'tp_save_meta', 10, 2 );

/*
 * register metadata in wp_postmeta but still doesn't help
 */
register_meta( 'post', 'event_status', [
	'object_subtype' => 'events',
	'type' => 'string',
	'description' => 'статус события',
	'single' => false, // can be many fields with such name
	'show_in_rest' => true, // show data in REST requests
] );

register_meta( 'post', 'event_date', [
	'object_subtype' => 'events',
	'type' => 'string',
	'description' => 'статус события',
	'single' => false,
	'show_in_rest' => true,
] );

/*
*  creating taxonomy 'birthdays'
*/
add_action( 'init', 'tp_register_taxonomy' );
function tp_register_taxonomy() {
	$args = array(
		'labels' => array(
			'name' => 'birthdays',
			'singular_name' => 'birthday',
			'menu_name' => 'Birthdays' // name in admin menu
		),
		'public' => true, // will be visible with minimum parameters
		'show_in_quick_edit' => true,
//		'show_admin_column' => true,
//		'hierarchical' => true, // will be as rubric
	);
	register_taxonomy( 'birthdays', 'events', $args );
}

/*
* creating shortcode for upcoming events
*/
function tp_show_upcoming_events( $atts ) {
    // first let's prepare attributes for shortcode
    $default = array(
            'count' => 3,
            'status' => 'Open',
    );
    $atts = shortcode_atts($default, $atts); // this f-n lets use default atts ($default) or user atts if he gives them in brackets like [upcoming_events count=5 status="Invitation only"]
     $args = array( // and now let's prepare arguments for query
            'post_type' => 'events',
            'posts_per_page' => $atts['count'],
            'post_status' => 'publish',
            'meta_query' => array(
                    array(
                            'key' => 'event_status',
                            'value' => $atts['status'],
                            'compare' => "="
                    )
            )
    );
	$q = new WP_Query( $args );
	if( $q->have_posts() ):
		ob_start(); // turn on buffering for correct display of html
		?>
            <ul>
                <?php
			while( $q->have_posts() ):
				$q->the_post();
                $event_date = get_post_meta( get_the_ID(), 'event_date', true );
				$date_now = date("Y-m-d");
				if ( $event_date > $date_now  ) : // events should be only upcoming
				?>
                    <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a> <span><?php echo $event_date;?></span> </li>
    			<?php
                endif;
                endwhile;
                ?>
            </ul>
    	<?php
	endif;
    return ob_get_clean(); // get from buffer
}
add_shortcode( 'upcoming_events', 'tp_show_upcoming_events' );





