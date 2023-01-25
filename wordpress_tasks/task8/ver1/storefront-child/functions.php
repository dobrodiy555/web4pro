<?php
// turn on styles of child theme
add_action( 'wp_enqueue_scripts', 'true_child_styles' );
function true_child_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array(), null  );
}

// add correct jquery for autocomplete
wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js', array('jquery'), '1.13.2');
wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js', array('jquery'), '3.6.1');

// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
  ?>
  <script type="text/javascript">
    function fetch(){
      var input = jQuery('#keyword').val();
      if (input.length > 2) {
        jQuery.ajax({
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          type: 'post',
          data: { action: 'data_fetch', keyword: jQuery('#keyword').val() },
          success: function (data) {
            jQuery('#loop_part').html(data);
          }
        });
      }
    }
  </script>
	<?php
}

// add call of ajax when pressing enter
add_action('wp_footer', 'add_enter');
function add_enter() {
  ?>
  <script type="text/javascript">
    jQuery('#keyword').keypress(function (e) {
      if (e.which == 13) {
        fetch();
        return false;
      }
    });
  </script>
  <?php
}

// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){
  $args = array(
          'posts_per_page' => -1,
          's' => esc_attr($_POST['keyword']),
          'post_type' => 'events'
  );
  $qur = new WP_Query();
  $qur->parse_query($args);
  relevanssi_do_query($qur);
  if( $qur->have_posts() ) :
    echo '<ul>';
    while( $qur->have_posts() ): $qur->the_post(); ?>
      <li><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title();?></a></li>
    <?php endwhile;
    echo '</ul>';
    wp_reset_postdata();
  endif;
  wp_die();
}

// add autocomplete
add_action('wp_footer', 'add_autocomplete');
function add_autocomplete() {
  $arr_for_autocompl = array();
  $args = array(
          'posts_per_page' => -1,
          's' => esc_attr($_POST['keyword']),
          'post_type' => 'events'
  );
  $qur = new WP_Query();
  $qur->parse_query($args);
  relevanssi_do_query($qur);
  if( $qur->have_posts() ) :
    while( $qur->have_posts() ): $qur->the_post();
      $arr_for_autocompl[] = get_the_title(get_the_ID());
      endwhile; endif;
  ?>
  <script type="text/javascript">
    jQuery('#keyword').autocomplete({
      source: <?php echo json_encode($arr_for_autocompl); ?>,
      minLength: 3
    });
  </script>
  <?php
}