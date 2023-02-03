<!--this is a for single post (no analogue) -->

<?php get_header(); ?>

<!-- BEGIN CONTENT -->
<section id="content">
  <div class="wrapper page_text">
    <h1 class="page_title"><?php the_title();?></h1>
    <div class="breadcrumbs">
      <div class="inside">
        <a href="<?php echo get_home_url(); ?>" class="first"><span><?php _e('The Same', 'tt7'); ?></span></a>
        <a href="<?php echo get_site_url(); ?>/posts-archive" class="first"><span><?php _e("Blog", 'tt7'); ?></span></a>
        <a href="#" class="last"><span><?php the_title(); ?></span></a>
      </div>
    </div>

    <div class="columns">
      <div class="column column75">
        <article class="article">
          <div class="article_image nomargin">
            <div class="inside">
				      <?php if(has_post_thumbnail()): ?>
              <img src="<?php the_post_thumbnail_url('single_post_thumbnail');?>">
				      <?php endif; ?>
            </div>
          </div>

          <div class="article_details">
            <ul class="article_author_date">
            <?php if (have_posts()) : while (have_posts()) : the_post();?>
              <li><em><?php _e('Add:', 'tt7'); ?></em> <?php the_date(); ?> </li>
              <li><em><?php _e('Author:', 'tt7'); ?></em> <?php the_author();?></li>
            </ul>
            <p class="article_comments"><em><?php _e(
              'Comments:', 'tt7'); ?> </em> <?php echo get_comments_number(); ?></p>
          </div>

			    <?php the_content();
			    endwhile; endif; ?>

          <a id="comment_button" class="button button_small button_orange float_left"><span class="inside"><?php _e('Comments', 'tt7'); ?></span></a>
        </article>

        <!--comments form-->
        <div id="comment_form" style="display:none">
  		    <?php
	  	    // If comments are open or we have at least one comment, load up the comment template.
		      if ( comments_open() || get_comments_number() ) :
			    comments_template();
		      endif; ?>
        </div>

      </div> <!-- column column 75 -->
		  <?php get_sidebar(); ?>

    </div> <!-- page top_in -->
  </div> <!-- page top -->

<?php get_footer(); ?>