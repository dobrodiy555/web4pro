<div id="page_bottom">
    <!-- BEGIN ABOVE_FOOTER -->
    <section id="above_footer">
        <div class="wrapper above_footer_boxes page_text">
          <div class="box first">
            <!--excerpt of "About us" page-->
	            <?php query_posts("page_id=323");
	            while(have_posts()) : the_post(); ?>
                  <h1>About Us</h1>
		            <?php the_excerpt(); ?>
	            <?php endwhile;
	            wp_reset_query(); ?>
          </div>

          <!--recent posts (shortcode)-->

            <div class="box second">
                <h3>Recent Posts</h3>
                <ul class="recent_posts">
	                <?php echo do_shortcode('[show_recent_posts]'); ?>
                </ul>
            </div>

            <!--list of our categories (shortcode)-->

         <div class="box third">
            <h3>Categories</h3>
             <?php echo do_shortcode('[show_list_of_categories]'); ?>
            </div>

           <!--Contact us (excerpt of page)-->

            <div class="box fourth">
	            <?php query_posts("page_id=464");
	            while (have_posts()) : the_post(); ?>
                  <a href="<?php the_permalink(); ?>">
                    <h1>Contact us</h1>
                    <?php the_excerpt(); ?>
                  </a>
	            <?php endwhile;
	            wp_reset_query(); ?>
            </div>

        </div>
    </section>
    <!-- END ABOVE_FOOTER -->

<!-- BEGIN FOOTER -->
 <footer id="footer">
	<div class="wrapper">
		<p class="copyrights">Copyright &copy; 2012 by TheSame. All rights reserved.</p>
		<a href="#page" class="up">
			<span class="arrow"></span>
			<span class="text">top</span>
		</a>
	</div>
 </footer>
<!-- END FOOTER -->
</div> <!-- page bottom -->
</div> <!-- page -->

<?php wp_footer(); ?>

</body>
</html>