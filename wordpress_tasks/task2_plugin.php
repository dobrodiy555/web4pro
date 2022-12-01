<?php
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
function create_posttype() {
	register_post_type( 'events',
		array(
			'labels' => array(
				'name' => __( 'Events' ), // ф-ция перевода
				'singular_name' => __( 'Event' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'events'),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'create_posttype');  // hook

/*
* creating custom fields for post type 'events'
*/
add_action( 'admin_menu', 'andrei_add_metabox' );
//add_action( 'add_meta_boxes_events', 'andrei_add_metabox');
//add_action( 'add_meta_boxes', 'andrei_add_metabox' ); also possible fun-s

function andrei_add_metabox() {
	add_meta_box(
		'andrei_metabox',
		'Meta Box',
		'andrei_metabox_callback',
		'events',
		'normal',
		'default'
	);
}

function andrei_metabox_callback( $post ) {
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

add_action( 'save_post', 'andrei_save_meta', 10, 2 );
function andrei_save_meta( $post_id, $post ) {
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
	if( 'page' !== $post->post_type ) {
		return $post_id;
	}
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

/*
 * register metadata in wp_postmeta but still doesn't help
 */
register_meta( 'post', 'event_status', [
	'object_subtype' => 'events',
	'type' => 'string',
	'description' => 'статус события',
	'single' => false, // может быть много полей с таким названием
	'show_in_rest' => true, // показывать данные в REST запросах
] );

register_meta( 'post', 'event_date', [
	'object_subtype' => 'events',
	'type' => 'string',
	'description' => 'статус события',
	'single' => false, // может быть много полей с таким названием
	'show_in_rest' => true, // показывать данные в REST запросах
] );

/*
*  creating taxonomy 'birthdays'
*/
add_action( 'init', 'true_register_taxonomy' );
function true_register_taxonomy() {
	$args = array(
		'labels' => array(
			'name' => 'birthdays',
			'singular_name' => 'birthday',
			'menu_name' => 'Birthdays' // название что будет отображаться в меню
		),
		'public' => true, // будет видимая даже с минимумом параметров
		'show_in_quick_edit' => true,
//		'show_admin_column' => true,
//		'hierarchical' => true, // будет как рубрика
	);
	register_taxonomy( 'birthdays', 'events', $args );
}

/*
* creating widget 'Upcoming events'
*/
class trueUpcomingEventsWidget extends WP_Widget {
	 // создание виджета
	function __construct() {
		parent::__construct(
			'true_upcoming_events_widget',
			'Upcoming events', // заголовок виджета
			array( 'description' => 'Позволяет вывести название предстоящих событий и их дату.' ) // описание
		);
	}
	//	  фронтэнд виджета (то что должно появиться на странице в сайдбаре)
	public function widget( $args, $instance ) {
//		$title = apply_filters('widget_title', $instance['title']);
		$number_of_events = $instance['number_of_events'];
        $status_of_events = $instance['status_of_events'];
//        $date = '12.01.2022'; how to get value of event_date from metabox event_date ?
        if ( ! empty ($status_of_events) )
	        echo $args['before_title'] . $status_of_events . $args['after_title'];
        $args = array(
                'post_type' => 'events',
                'posts_per_page' => $number_of_events,
                'event_status' => $status_of_events,
//                'event_date' => $date
        );
		$q = new WP_Query( $args );
		if( $q->have_posts() ):
			?>
        <ul>
			<?php
			while( $q->have_posts() ):
				$q->the_post();
				?>
                <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a> </li>
			<?php endwhile; ?>
        </ul>
		<?php
		endif;
		wp_reset_postdata();
	}
	 // бэкэнд виджета (то что видно в appearance->widgets)
	public function form( $instance ) {
//        if ( isset( $title[ 'title' ] ) ) {
//            $title = $instance[ 'title' ];
//        }
		if ( isset( $instance[ 'number_of_events' ] ) ) {
			$number_of_events = $instance[ 'number_of_events' ];
		}
		if ( isset( $instance[ 'status_of_events' ] ) ) {
			$status_of_events = $instance[ 'status_of_events' ];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'number_of_events' ); ?>">Number of upcoming events</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number_of_events' ); ?>" name="<?php echo $this->get_field_name( 'number_of_events' ); ?>" type="text" value="<?php echo esc_attr( $number_of_events ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'status_of_events' ); ?>">Status of upcoming events</label>
            <select id="<?php echo $this->get_field_id('status_of_events'); ?>" name="<?php echo $this->get_field_name('status_of_events' ); ?>" >
                <option value="Open">Open</option>
                <option value="Invitation only">Invitation only</option>
            </select>
		</p>
		<?php
	}
	 // сохранение настроек виджета
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['number_of_events'] = ( ! empty( $new_instance['number_of_events'] ) ) ? strip_tags( $new_instance['number_of_events'] ) : '';
		$instance['status_of_events'] = ( ! empty($new_instance['status_of_events'] ) ) ? strip_tags( $new_instance['status_of_events'] ) : 'empty';
		return $instance;
	}
}
 // регистрация виджета
function true_upcoming_events_widget_load() {
	register_widget( 'trueUpcomingEventsWidget' );
}
add_action( 'widgets_init', 'true_upcoming_events_widget_load' );

/*
* creating shortcode for upcoming events
*/
function show_upcoming_events( $atts ) {
    $a = shortcode_atts( array(
            'post_type' => 'events',
            'number_of_events' => 3,
    ), $atts );
	$q = new WP_Query( $a );
	if( $q->have_posts() ):
		ob_start();
		?>
            <ul>
    			<?php
                $i = 0; // счетчик
			while( $q->have_posts() && ($i < $a['number_of_events']) ):
				$q->the_post();
				?>
                    <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a> </li>
    			<?php $i++;
                endwhile; ?>
            </ul>
    	<?php
	endif;
    return ob_get_clean();
}
add_shortcode( 'upcoming_events', 'show_upcoming_events' );





