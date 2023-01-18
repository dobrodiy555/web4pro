<!-- start of sidebar -->
<div class="column column25">

    <!--Search form widget (only on posts archive page) -->
  
  <?php
  if ( is_page('Posts archive')  && is_active_sidebar( 'new-widget-area' ) ) { ?> 
    <div id="secondary-sidebar" class="new-widget-area">
	  <?php dynamic_sidebar( 'new-widget-area' ); ?>
    </div>
  <?php } ?>

  <!--Recent Posts shortcode-->
 
 <div class="padd16bot">
    <h1>Recent Posts</h1>
      <ul class="recent_posts">
        <?php echo do_shortcode('[show_recent_posts]'); ?>
      </ul>
  </div>

  <!--excerpt of "About us" page-->

  <div class="padd16bot">
    <?php query_posts("page_id=323");
    while(have_posts()) : the_post(); ?>
    <h1>About Us</h1>
    <?php the_excerpt(); ?>
    <?php endwhile;
    wp_reset_query(); ?>
  </div>


  <!--list of our categories (shortcode)-->
  
  <div class="padd16bot">
		<h1>Categories</h1>
	  <?php echo do_shortcode('[show_list_of_categories]'); ?>
	</div>
</div> <!-- column column 25 -->

</div> <!-- columns (CONTENT) -->
</div> <!-- wrapper page_text (CONTENT) -->
</section> <!-- content (CONTENT) -->

<!-- END CONTENT sidebar-->

