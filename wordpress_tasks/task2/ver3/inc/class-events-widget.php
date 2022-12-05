<?php
/*
* creating widget 'Upcoming events'
*/
class EventsWidget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'tp_upcoming_events_widget',
			'Upcoming events', // widget name
			array( 'description' => 'Allows display names of upcoming events and their date.' )
		);
	}
	//	  frontend of widget (in sidebar)
	public function widget( $args, $instance ) {
		$number_of_events = $instance['number_of_events'];
		$status_of_events = $instance['status_of_events'];
		if ( ! empty ( $status_of_events ) )
			echo $args['before_title'] . $status_of_events . $args['after_title'];
		$today = date("Y-m-d");
        $args = array(
			'post_type' => 'events',
			'posts_per_page' => $number_of_events,
			'meta_query' => array(
                    array(
				        'key' => 'event_status',
				        'value' => $status_of_events,
                        'compare' => '='
			        ),
                    array (
	                    'key' => 'event_date',
	                    'value' => $today,
                        'type' => 'DATE',
	                    'compare' => '>'
                    )
			)
		);
		$q = new WP_Query( $args );
		if( $q->have_posts() ):
			?>
			<ul>
				<?php
				while( $q->have_posts() ):
					$q->the_post();
					$event_date = get_post_meta( get_the_ID(), 'event_date', true ); // date from metadata to display
                ?>
					<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                        <span><?php echo $event_date;?></span></li>
                    <?php endwhile; ?>
			</ul>
		<?php
		endif;
		wp_reset_postdata();
	}
	// backend of widget (visible in appearance->widgets)
	public function form( $instance ) {
		if ( isset( $instance[ 'number_of_events' ] ) ) {
			$number_of_events = $instance[ 'number_of_events' ];
		}
		if ( isset( $instance[ 'status_of_events' ] ) ) {
			$status_of_events = $instance[ 'status_of_events' ];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'number_of_events' ); ?>"><?php _e("Number of upcoming events"); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number_of_events' ); ?>" name="<?php echo $this->get_field_name( 'number_of_events' ); ?>" type="text" value="<?php echo esc_attr( $number_of_events ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'status_of_events' ); ?>"> <?php _e("Status of upcoming events"); ?></label>
			<select id="<?php echo $this->get_field_id('status_of_events'); ?>" name="<?php echo $this->get_field_name('status_of_events' ); ?>" >
				<option value="Open"><?php _e("Open"); ?></option>
				<option value="Invitation only"><?php _e("Invitation only"); ?></option>
			</select>
		</p>
		<?php
	}
	// to save widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['number_of_events'] = ( ! empty( $new_instance['number_of_events'] ) ) ? strip_tags( $new_instance['number_of_events'] ) : '';
		$instance['status_of_events'] = ( ! empty($new_instance['status_of_events'] ) ) ? strip_tags( $new_instance['status_of_events'] ) : 'empty';
		return $instance;
	}
}
// registration of widget
function tp_upcoming_events_widget_load() {
	register_widget( 'EventsWidget' );
}
add_action( 'widgets_init', 'tp_upcoming_events_widget_load' );
