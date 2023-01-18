<?php get_header(); ?>

<!-- BEGIN CONTENT -->
<section id="content">
  <div class="wrapper page_text">
    <h1 class="page_title"><?php the_title();?></h1>
    <div class="breadcrumbs">
      <div class="inside">
        <a href="http://localhost/wordpress/" class="first"><span>The Same</span></a>
        <a href="#" class="last"><span>Single post</span></a>
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

				<?php if (have_posts()) :
				while (have_posts()) :
				the_post();?>

              <li><em>Add: </em> <?php the_date(); ?> </li>
              <li><em>Author: </em> <a href="#"><?php the_author();?></a></li>
            </ul>
            <p class="article_comments"><em>Comment: </em> <?php echo get_comments_number(); ?></p>
          </div>

			<?php the_content(); ?>
			<?php endwhile; endif; ?>

            <a id="comment_button" class="button button_small button_orange float_left"><span class="inside">comment</span></a>
        </article>
      </div>

      <div id="comment_form" style="display:none"> 
		  <?php
		  // If comments are open or we have at least one comment, load up the comment template.
		  if ( comments_open() || get_comments_number() ) :
			  comments_template();
		  endif; ?>
      </div>

     <?php get_sidebar(); ?>

    </div> <!-- page top_in -->
  </div> <!-- page top -->

<?php get_footer(); ?>