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
	}

	// frontend of widget (in sidebar)
	public function widget( $args, $instance ) {
        $number_of_posts = $instance['number_of_posts'];
        ?>
         <h3><?php echo _e("Number of posts is", "tp4"); ?> <span id="number"> <?php echo $number_of_posts; ?> </span><h3>
	    <form>
	    <p>
        <label for="title"><?php _e("Title:", "tp4"); ?></label>
		<input id="title" type="text" />
	    </p>
		<p>
		<label for="from_date"> <?php _e("From date:", "tp4"); ?></label>
		<input type="date" id="from_date" />
		</p>
		<input id="submit" type="submit" />
		</form>
		<div id="response"></div>
		<?php
}

// backend of widget (visible in appearance->widgets)
	public function form( $instance ) {
		if ( isset( $instance['number_of_posts'] ) ) {
			$number_of_posts = $instance['number_of_posts'];
		}
		?>
            <label for="<?php echo $this->get_field_id( 'number_of_posts' ); ?>"><?php _e("Number of posts:", "tp4"); ?></label>
            <input id="<?php echo $this->get_field_id( 'number_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_of_posts' ); ?>" type="text" value="<?php echo esc_attr( $number_of_posts ); ?>" />
		<?php
	}

	// to save widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['number_of_posts'] = (!empty($new_instance['number_of_posts'])) ? strip_tags($new_instance['number_of_posts']) : '';
		return $instance;
	}
}

// registration of widget
add_action( 'widgets_init', 'tp4_post_links_widget_load' );
function tp4_post_links_widget_load() {
	register_widget( 'PostLinksWidget' );
}
