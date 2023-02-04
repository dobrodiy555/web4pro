<?php
// turn on styles of child theme
add_action( 'wp_enqueue_scripts', 'true_child_styles' );
function true_child_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array(), null  );
}

// adding styles and scripts
add_action( 'wp_enqueue_scripts', 't8_wp_enqueue_assets' );
function t8_wp_enqueue_assets() {
  wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js', array('jquery'), '1.13.2');
  wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js', array('jquery'), '3.6.1');
  wp_register_style( 'jquery-ui-styles','http://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.css' );
  wp_enqueue_style( 'jquery-ui-styles' );
  wp_enqueue_script('t8_script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), null, true);
  wp_localize_script('t8_script', 't8ajax',
          array(
                  'ajaxurl' => admin_url('admin-ajax.php')
          )
  );
  wp_register_script('autocomplete', get_stylesheet_directory_uri() . '/js/autocomplete.js', array('jquery'), null, true);
  wp_localize_script('autocomplete', 't8ac', array('url'=>admin_url('admin-ajax.php')));
  wp_enqueue_script('autocomplete');
}

// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){
  $args = array(
          'posts_per_page' => -1,
          's' => esc_attr($_POST['keyword']),
          'post_type' => 'events',
  );
  $qur = new WP_Query();
  $qur->parse_query($args);
  relevanssi_do_query($qur);
  if( $qur->have_posts() ) :
    echo '<ul>';
    while( $qur->have_posts() ): $qur->the_post(); ?>
      <li><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title();?></a></li>
    <?php
    endwhile;
    echo '</ul>';
    wp_reset_postdata();
    endif;
    wp_die();
}

// add autocomplete (searches only titles)
add_action('wp_ajax_add_autocomplete', 'add_autocomplete');
add_action('wp_ajax_nopriv_add_autocomplete', 'add_autocomplete');
function add_autocomplete() {
  $term = strtolower($_GET['term']);
  $arr_for_autocompl= array();
  $args = array(
          'posts_per_page' => -1,
          'search_title' => $term,
          'post_type' => 'events'
  );
  add_filter('posts_where', 'title_filter', 10, 2);
  $qur = new WP_Query( $args );
  remove_filter('posts_where', 'title_filter', 10, 2);
  if( $qur->have_posts() ) :
    while( $qur->have_posts() ): $qur->the_post();
       $arr_for_autocompl[] = get_the_title();
    endwhile; endif;
  echo json_encode($arr_for_autocompl);
  exit();
}

// f-n that allows use search form to search only in post titles (not in content)
function title_filter($where, $wp_query) {
  global $wpdb;
  if ($search_term = $wp_query->get('search_title')) {
    $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
  }
  return $where;
}



