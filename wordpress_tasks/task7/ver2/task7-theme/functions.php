<?php
/*
// add css and js
*/
add_action( 'wp_enqueue_scripts', 'tt7_enqueue_assets' );
function tt7_enqueue_assets() {
	wp_enqueue_style( 'reset_style', get_template_directory_uri() . '/css/reset.css' );

	wp_enqueue_style( 'main_style', get_template_directory_uri() . '/css/style.css' );

	wp_enqueue_style( 'flexslider_style', get_template_directory_uri() . '/css/flexslider.css' );

	wp_enqueue_style( 'pretty_photo_style', get_template_directory_uri() . '/css/prettyPhoto.css' );

  	wp_enqueue_script( 'add_scripts', get_template_directory_uri() . '/js/additional_scripts.js', array('jquery'), null, true);

	wp_enqueue_script( 'flexslider_script', get_template_directory_uri() . '/js/jquery.flexslider.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'prettyphoto_script', get_template_directory_uri() . '/js/jquery.prettyphoto.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'stylesheettoggle_script', get_template_directory_uri() . '/js/jquery.stylesheettoggle.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'quicksand_script', get_template_directory_uri() . '/js/jquery.quicksand.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'onload_script', get_template_directory_uri() . '/js/onload.js', array( 'jquery' ), null, true );
}

// downgrade jquery to old version (with the version of wp doesn't work)
add_action('wp_enqueue_scripts', 'include_jquery');
function include_jquery() {
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-1.8.18.min.js', '', null, true);
	add_action('wp_enqueue_scripts', 'jquery');
}

/*
// add 'menus' into "Appearance" in admin console
*/
add_theme_support('menus');
// add theme menu locations
  register_nav_menus(
	array(
		"top-menu" => __("Top menu", "tt7"),
		"footer-menu" => __("Footer menu", "tt7"),
	)
);

/*
 * Modifying post thumbnails
 */

// enable post thumbnails
add_theme_support('post-thumbnails');

// formatting images size for different pages
add_image_size('single_post_thumbnail', 689, 214, true);
add_image_size('archive_portfolio_thumbnail', 276, 230, true);
add_image_size('single_portfolio_thumbnail', 606, 480, true);
add_image_size('gallery_thumbnail', 446, 294, true);
add_image_size('recent_posts_thumbnail', 50, 50, true);
add_image_size('big_gallery_image', 687, 1024, true);
add_image_size('small_frontpage_portfolio_image', 197, 140, true);

/*
 * Modifying excerpt
 */
function custom_wp_trim_excerpt($text) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		//Retrieve the post content.
		$text = get_the_content('');

		//Delete all shortcode tags from the content.
		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);

		$allowed_tags = '<p>,<q>,<strong>,<span>';
		$text = strip_tags($text, $allowed_tags);

		global $post;
		if ($post->post_type == 'post') {
			$excerpt_word_count = 22; // was 153
		} else if ($post->post_type == 'portfolio') {
			$excerpt_word_count = 8;
	  } else if ($post->post_type == 'page') {
      $excerpt_word_count = 34;
		} else {
			$excerpt_word_count = 55; // default
		}

		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);

		$excerpt_end = '';
		$excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');

// allow display page excerpts
function add_page_excerpts() {
	add_post_type_support('page', 'excerpt');
}
add_action('init', 'add_page_excerpts');

/*
// f-n that will add custom post type posts (in our case 'portfolio') to category archive
*/
add_filter('pre_get_posts', 'include_custom_post_type_into_category_archive');
function include_custom_post_type_into_category_archive($query) {
	if ($query->is_category() && $query->is_main_query()) {
		$query->set('post_type',
			array(
				'post',
				'portfolio'
			)
		);
	}
	return $query;
}

/*
// add widgets menu to appearance->widgets in admin
*/
function register_widgets_sidebar() {
    register_sidebar( array(
        'name' => 'tt7 sidebar',
        'id' => 'tt7_sidebar',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'register_widgets_sidebar');


/*
 * remove automatic adding of <p> tags
 */
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');

/*
// shortcode for recent posts (only portfolios bcs they have thumbnails)
*/
function tt7_show_recent_posts($atts) {
  $default = array(
          'posts_per_page' => 3,
          'post_type' => 'portfolio'
  );

  $atts = shortcode_atts($default, $atts);
  ob_start(); ?>

  <?php
    $q = new WP_Query($atts);
    while ($q->have_posts()) :
        $q->the_post(); ?>

        <li class="item">
          <?php if (has_post_thumbnail()) : ?>
          <a class="thumbnail" href="<?php the_permalink(); ?>"> <img alt="" src="<?php the_post_thumbnail_url('recent_posts_thumbnail');?>">
          </a>
          <?php endif; ?>
          <div class="text">
            <h4 class="title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
            <p class="data">
              <span class="date"><?php the_date(); ?></span>
            </p>
          </div>
        </li>

  <?php endwhile;
  wp_reset_postdata(); ?>
  <?php
  return ob_get_clean();
}
add_shortcode('show_recent_posts', 'tt7_show_recent_posts');

/*
* shortcode to display list of categories
*/
function tt7_show_list_of_categories() {
  ob_start(); ?>
	<ul class="menu categories page_text">
    <?php
    $cats = wp_list_categories('echo=0&exclude=32&style=none&show_count=1&title_li=');
    $cats = str_replace('</a>', '', $cats); ?>
    <!--in order to show number of each category's posts in one line with title of category -->
    <li>
      <?php echo $cats; ?>
    </li>
    </a> 
  </ul>
  <?php
  return ob_get_clean();
}
add_shortcode('show_list_of_categories', 'tt7_show_list_of_categories' );

/**
 * Widget Search form
 */
require get_template_directory() . '/inc/widget-search-form.php';

/*
 * creating custom widget area in our theme in order to be able to insert widgets there
 */
function register_custom_widget_area() {
	register_sidebar(
		array(
			'id' => 'new-widget-area',
			'name' => esc_html__( 'My new widget area', 'tt7' ),
			'description' => esc_html__( 'A new widget area made for testing purposes', 'tt7' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
			'after_title' => '</h3></div>'
		)
	);
}
add_action( 'widgets_init', 'register_custom_widget_area' );

// f-n that allows use search form to search only in post titles (not in content)
function title_filter($where, $wp_query) {
  global $wpdb;
  if ($search_term = $wp_query->get('search_title')) {
	  $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
  }
  return $where;
}

// wordpress auto title for each page
add_theme_support('title-tag');

/*
// add 'Custom settings' into admin menu for social media link
*/
function custom_settings_add_menu() {
  add_menu_page( 'Custom Settings', 'Custom Settings', 'manage_options', 'custom-settings', 'custom_settings_page', null, 99 );
}
add_action( 'admin_menu', 'custom_settings_add_menu' );
// Create Custom Global Settings
function custom_settings_page() { ?>
  <div class="wrap">
    <h1>Custom Settings</h1>
    <form method="post" action="options.php">
      <?php
      settings_fields( 'section' );
      do_settings_sections( 'theme-options' );
      submit_button();
      ?>
    </form>
  </div>
<?php }
// Facebook
function setting_facebook() { ?>
  <input type="text" name="facebook" id="facebook" value="<?php echo get_option('facebook'); ?>" />
<?php }
// Instagram
function setting_linkedin() { ?>
  <input type="text" name="linkedin" id="linkedin" value="<?php echo get_option('linkedin'); ?>" />
<?php }
// Twitter
function setting_twitter() { ?>
  <input type="text" name="twitter" id="twitter" value="<?php echo get_option( 'twitter' ); ?>" />
<?php }
// RSS
function setting_rss() { ?>
  <input type="text" name="rss" id="rss" value="<?php echo get_option('rss'); ?>" />
<?php }
function custom_settings_page_setup() {
  add_settings_section( 'section', 'Social media settings', null, 'theme-options' );
  add_settings_field( 'twitter', 'Twitter URL', 'setting_twitter', 'theme-options', 'section' );
  add_settings_field( 'facebook', 'Facebook URL', 'setting_facebook', 'theme-options', 'section' );
  add_settings_field( 'linkedin', 'Linkedin URL', 'setting_linkedin', 'theme-options', 'section' );
  add_settings_field( 'rss', 'Rss URL', 'setting_rss', 'theme-options', 'section' );
  register_setting('section', 'twitter');
  register_setting('section', 'facebook');
  register_setting('section', 'linkedin');
  register_setting('section', 'rss');
}
add_action( 'admin_init', 'custom_settings_page_setup' );

register_nav_menu('primary', 'Primary Menu');
/*
 * creating submenu for 'other' with Walker class
 */
class AWP_Menu_Walker extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
    if ($depth == 0)
      return;
    parent::start_el($output, $item, $depth, $args);
    }

    function end_el(&$output, $item, $depth=0, $args=array()) {
      if ( 0 == $depth ) {
        return;
      }
      parent::end_el( $output, $item, $depth, $args );
    }

  // Only follow down one branch
  function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
    // Check if element as a 'current element' class
    $current_element_markers = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' );
    $current_class = array_intersect( $current_element_markers, $element->classes );
    // If element has a 'current' class, it is an ancestor of the current element
    $ancestor_of_current = !empty($current_class);
    // If this is a top-level link and not the current, or ancestor of the current menu item - stop here.
    if ( 0 == $depth && !$ancestor_of_current)
      return;
    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }

  // Don't wrap the top level
  function start_lvl(&$output, $depth=0, $args=array()) {
    if( 0 == $depth )
      return;
    parent::start_lvl($output, $depth, $args);
  }
  function end_lvl(&$output, $depth=0, $args=array()) {
    if( 0 == $depth )
      return;
    parent::end_lvl($output, $depth, $args);
  }
}

// f-n to find post/page id by its name
function get_post_by_slug($slug) {
  $posts = get_posts(array(
          'name' => $slug,
          'posts_per_page' => 1,
          'post_type' => 'page',
          'post_status' => 'publish'
  ));
  if (!$posts) {
    throw new Exception('NoSuchPostBySpecifiedId');
  }
  return $posts[0]->ID;
}

// comments f-n for posts
function my_comments_callback($comment, $args, $depth){
  //checks if were using a div or ol|ul for our output
  $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
  ?>
  <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>
  <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <div class="comment-content">
      <?php comment_text(); ?>
    </div><!-- .comment-content -->
  </article><!-- .comment-body -->
  <?php
}