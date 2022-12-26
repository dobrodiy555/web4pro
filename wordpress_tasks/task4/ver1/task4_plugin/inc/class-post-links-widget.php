<?php
/*
* creating widget 'Post Links'
*/
class PostLinksWidget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'tp4_post_links_widget',
			__( 'Post Links', 'tp4' ), // widget name
			array( 'description' => __( 'Allows display links to posts.', 'tp4' ) )  
		);
		add_action( 'wp_ajax_show', 'widget' );
	}

	// frontend of widget (in sidebar)
	public function widget( $args, $instance ) {
		$title = $instance['title'];
		$from_date = $instance['from_date'];
		wp_localize_script('script', 'script_vars', array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'title' => $title,
				'from_date' => $from_date
			)
		);
		wp_enqueue_script('script');
		global $wpdb;
		$my_post_ids = $wpdb->get_col( "SELECT id FROM $wpdb->posts WHERE post_title LIKE '%$title%' " );
		$args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => - 1, // to show all posts
			'post__in'       => $my_post_ids, // include posts with necessary ids
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
                    <div id="response"> </div>
				<?php endwhile; ?>
            </ul>
		<?php
		endif;
		wp_reset_postdata();
	}

	// backend of widget (visible in appearance->widgets)
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		if ( isset( $instance[ 'from_date' ] ) ) {
			$from_date = $instance[ 'from_date' ];
		}
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e("Title:", "tp4"); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'from_date' ); ?>"> <?php _e("From date:", "tp4"); ?></label>
            <input type="date" id="from_date" name="<?php echo $this->get_field_name('from_date' ); ?>" value="<?php echo esc_attr( $from_date ); ?>" />
        </p>
        <input id="submit" type="submit" />
		<?php
	}

	// to save widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['from_date'] = ( ! empty($new_instance['from_date'] ) ) ? strip_tags( $new_instance['from_date'] ) : 'empty';
		return $instance;
	}
}

// registration of widget
function tp4_post_links_widget_load() {
	register_widget( 'PostLinksWidget' );
}
add_action( 'widgets_init', 'tp4_post_links_widget_load' );


