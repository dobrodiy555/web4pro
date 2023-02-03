<?php
/*
* creating widget 'Search form' that will search posts by its title
*/

// register widget
function tt7_register_search_form_widget() {
	register_widget('Search_Form_Widget');
}
add_action('widgets_init', 'tt7_register_search_form_widget');

class Search_Form_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'tt7_search_form_widget',
			__( 'Search form', 'tt7' ), // widget name
			array( 'description' => __( 'Allows display results of searching', 'tt7' ) )
		);
	}

	// frontend
	public function widget($args, $instance) {
		?>
		<div class="padd16bot">
			<h1><?php _e('Search', 'tt7'); ?></h1>
			<form class="searchbar" action="" method="get">
				<fieldset>
				<div>
					<span class="input_text"><input type="text" name="input" class="clearinput" value="<?php _e('Search...', 'tt7'); ?>"/></span>
					<button type="submit" name="submit_button" class="input_submit" value="send"></button>
				</div>
				</fieldset>
			</form>
		</div>
		<?php
      if (isset($_GET['submit_button'])) {
        if (!empty($_GET['input'])) {
          $input = $_GET['input'];
          $args = array(
	          'post_type' => array('post', 'portfolio'),
	          'search_title' => $input,
	          'post_status' => 'publish',
	          'posts_per_page' => -1
          );
          // to search only in title, not in content
          add_filter('posts_where', 'title_filter', 10, 2);
          $qur = new WP_Query( $args );
          remove_filter('posts_where', 'title_filter', 10, 2);
        if ($qur->have_posts()) : ?>
          <ol> <?php
          while ($qur->have_posts()) : $qur->the_post(); ?>
          <li><a href="<?php the_permalink(); ?>">
          <?php the_title(); ?></a></li>
          <?php endwhile; ?>
          </ol> <?php
        else :
          echo "<span style='color:red'>no posts found</span><br><br>";

          endif; wp_reset_postdata();
        }
      }
  }

	// backend
	public function form($instance) {
		?>
    <h1><?php _e('This is empty backend of search-form widget', 'tt7'); ?></h1>
    <?php
	}

  // update
  public function update($new_instance, $old_instance) {
    return $new_instance;
  }
}