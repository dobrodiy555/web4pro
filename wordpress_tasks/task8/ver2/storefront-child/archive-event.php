<?php
/*
  * Template Name: Event Archive
  */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

    <!--search form-->
    <div class="search_bar">
     <input type="text" name="s" placeholder="<?php _e('Search Code...', 't8'); ?>" id="keyword" class="input_search" >
        <button id="t8_but">
          <?php _e('Search', 't8'); ?>
        </button>
     </div>

    <br>

   <!--loop for this page -->
    <?php
    $current_page = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
    $qur = new WP_Query( array(
            'post_type' => 'events',
            'posts_per_page' => 5,
            'paged' => $current_page
    ) ); ?>
    <div id="loop_part">
      <ul id="posts_list">
      <?php
      if ($qur->have_posts()) :
        while ($qur->have_posts()) : $qur->the_post(); ?>
        <li>
          <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
            <?php endwhile;  endif; ?>
        </li>
      </ul>

      <!--pagination part-->
      <div class="t8-pagination"> <!-- my styles in task8.css -->
        <?php
        $big = 999999999; // need an unlikely integer
        echo paginate_links( array(
                'prev_text' => __('&laquo;'),
                'next_text' => __('&raquo;'),
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => $current_page,
                'total'   => $qur->max_num_pages,
        ) );
        wp_reset_postdata(); ?>
      </div>

    </div> <!-- #loop_part -->
	</main><!-- #main -->
</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();