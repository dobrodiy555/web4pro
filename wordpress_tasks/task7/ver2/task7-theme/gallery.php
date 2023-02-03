<?php
/*
 * Template Name: Gallery
 */

// when creating a page, we can choose this template in "page attributes" on the right side

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
      $paged = get_query_var('paged') ? get_query_var('paged') : 1; // current page
      $counter = 0;
      $args = array(
              'post_type' => 'portfolio',
              'posts_per_page' => 4,
              'paged' => $paged
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
              <a href="<?php the_post_thumbnail_url("big_gallery_image"); ?>" data-rel="prettyPhoto[gallery]" class="button button_small button_orange float_right lightbox" rel="prettyPhoto[gallery]"><span class="inside">zoom</span></a>
            </p>

          </div> <!--image-->
        </div> <!--column column50-->

        <!--we need to close <div> columns every second post-->
       <?php if ($counter % 2 == 0) : ?>
          </div>
          <div class="columns">
          <?php endif;?>
        <?php endwhile; endif; ?>

        <!--pagination part-->
        <div style="text-align: center">
          <?php
          echo paginate_links([
          'prev_text' => __('&laquo;'),
          'next_text' => __('&raquo;'),
          'base' =>  str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
          'format' => '?paged=%#%',
          'current' => $paged,
          'total'   => $qur->max_num_pages,
          ]); ?>
        </div>

      </div> <!-- columns -->

    </div> <!-- page gallery -->
  </div>  <!-- wrapper page_text -->
</section> <!-- content -->
<!-- END CONTENT -->
</div>
</div>

<?php get_footer();