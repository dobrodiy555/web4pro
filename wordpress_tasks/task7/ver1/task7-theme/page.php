<?php get_header(); ?>

  <!-- BEGIN CONTENT -->
  <section id="content">
    <div class="wrapper page_text">
      <h1 class="page_title"><?php the_title();?></h1>
      <div class="breadcrumbs">
        <div class="inside">
          <a href="http://localhost/wordpress/" class="first"><span>The Same</span></a>
          <a href="#" class="last"><span>Single page</span></a>
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


			  <?php if (have_posts()) :
				  while (have_posts()) :
					  the_post();?>
					  <?php the_content(); ?>
				  <?php endwhile; endif; ?>


          </article>
        </div>
		  <?php get_sidebar(); ?>
      </div>
  </section>

<?php get_footer(); ?>