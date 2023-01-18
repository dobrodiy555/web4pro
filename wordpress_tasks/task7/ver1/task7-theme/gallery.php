<?php
/*
 * Template Name: Gallery
 */

get_header(); ?>

<!-- BEGIN CONTENT -->
<section id="content">
	<div class="wrapper page_text">
		<h1 class="page_title">Gallery</h1>
		<div class="breadcrumbs">
			<div class="inside">
				<a href="#" class="first"><span>The Same</span></a>
				<a href="#" class="last"><span>Gallery</span></a>
			</div>
		</div>

    <div class="page_gallery">
      <div class="columns">

      <?php
      $page = $_GET['q'] ?? 1; // current page
      $counter = 0;
      $date_switcher = $page == 1 ? 'DESC' : 'ASC';
      $args = array(
              'post_type' => 'portfolio',
              'posts_per_page' => 4,
              'orderby' => array(
                      'date' => $date_switcher
              )
      );
      $qur = new WP_Query($args);

      if ($qur->have_posts()) :
          while ($qur->have_posts()) : $qur->the_post(); $counter++; ?>

        <div class="column column50">

          <?php if (has_post_thumbnail()) : ?>
          <div class="image">
            <img src="<?php the_post_thumbnail_url('gallery_thumbnail');?>" alt=""/>
            <?php endif; ?>

            <p class="caption">
              <strong> <?php the_title(); ?></strong>
              <span> <?php the_excerpt(); ?> </span>
              <a href="<?php the_post_thumbnail_url("gallery_thumbnail"); ?>" data-rel="prettyPhoto[gallery]" class="button button_small button_orange float_right lightbox"><span class="inside">zoom</span></a>
            </p>

          </div> <!--image-->
        </div> <!--column column50-->

        <!--we need to close <div> columns every second post to make it two items in a row -->
       <?php if ($counter % 2 == 0) : ?>
          </div>
          <div class="columns">
          <?php endif;?>

      <?php endwhile; endif; ?>

    </div> <!-- columns -->
  </div> <!-- page gallery -->

    <!-- pagination -->

    <ul class="pagenav">
      <li class="arrow arrow_left"><a href="http://localhost/wordpress/gallery/?q=1 "><span></span></a></li>

      <?php
      $total_pages = 2;
      $page = $_GET['q'] ?? 1;
      for ($i = 1; $i <= $total_pages; $i++) : ?>
        <li class="<?php if ($i == $page) echo 'active'; ?>"><a href="http://localhost/wordpress/gallery/?q=<?php echo $i; ?>"><span><?php echo $i; ?></span></a></li>
      <?php endfor; ?>

       <li class="arrow arrow_right"><a href="http://localhost/wordpress/gallery/?q=2 "><span></span></a></li>
    </ul>

    </div>  <!-- wrapper page_text -->
</section> <!-- content -->
<!-- END CONTENT -->
</div>
</div>

<?php get_footer();