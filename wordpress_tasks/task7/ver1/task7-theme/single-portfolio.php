<?php

get_header(); ?>

  <!-- BEGIN CONTENT -->
  <section id="content">
    <div class="wrapper page_text">
      <h1 class="page_title"><?php the_title();?></h1>
      <div class="breadcrumbs">
        <div class="inside">
          <a href="http://localhost/wordpress/" class="first"><span>The Same</span></a>
          <a href="http://localhost/wordpress/portfolios/"><span>Portfolio</span></a>
          <a href="#" class="last"><span><?php the_title();?></span></a>
        </div>
      </div>

      <div class="columns">
        <div class="column column33">

			<?php
			if (have_posts()) :
			while ( have_posts() ) :
			the_post();
			the_content(); ?>

       </div>

        <div class="column column66">
          <div id="content_slide">
            <div class="flexslider">
              <ul class="slides">
              <?php if (has_post_thumbnail()) : ?>
                <li><a href="<?php the_post_thumbnail_url('gallery_thumbnail'); ?>" class="lightbox" data-rel="prettyPhoto[gallery]"><img src="<?php the_post_thumbnail_url('single_portfolio_thumbnail'); ?>"></a>
                </li>
                <li><a href="<?php echo get_template_directory_uri();?>/gfx/examples/img_big2.jpg" class="lightbox" data-rel="prettyPhoto[gallery]"><img src="<?php echo get_template_directory_uri();?>/gfx/examples/content_slide606x480_2.jpg" alt="2" /></a></li>
                <li><a href="<?php echo get_template_directory_uri();?>/gfx/examples/img_big5.jpg" class="lightbox" data-rel="prettyPhoto[gallery]"><img src="<?php echo get_template_directory_uri(); ?> /gfx/examples/content_slide606x480_3.jpg" alt="3" /></a></li>
                <li><a href="<?php echo get_template_directory_uri();?>/gfx/examples/img_big6.jpg" class="lightbox" data-rel="prettyPhoto[gallery]"><img src="<?php echo get_template_directory_uri(); ?>/gfx/examples/content_slide606x480_4.jpg" alt="4" /></a></li>
                <li><a href="<?php echo get_template_directory_uri();?>/gfx/examples/img_big8.jpg" class="lightbox" data-rel="prettyPhoto[gallery]"><img src="<?php echo get_template_directory_uri(); ?>/gfx/examples/content_slide606x480_5.jpg" alt="5" /></a></li>
				 <?php endif; ?>
              </ul>
            </div>
          </div>
        </div> <!-- column column66 -->

		  <?php endwhile; endif; ?>

      </div> <!-- column column33 -->
    </div> <!-- wrapper page_text -->
  </section> <!-- content -->

<?php get_footer();

