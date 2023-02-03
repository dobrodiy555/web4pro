<!--archive of portfolios (http://localhost/wordpress/portfolios), the same as all categories of porfolios -->
<?php get_header(); ?>

<!-- BEGIN CONTENT -->
<section id="content">
  <div class="wrapper page_text">
    <h1 id="category_page_title" class="page_title">All categories</h1>
    <div class="breadcrumbs">
      <div class="inside">
        <a href="http://localhost/wordpress/" class="first"><span>The Same</span></a>
        <a href="#"><span>Portfolio</span></a>
      </div>
    </div>

    <!--breadcrumbs of portfolio categories-->
    <ul id="portfolio_categories" class="portfolio_categories">
      <li class="active segment-0"><a href="#" class="all">All categories</a></li>

		<?php $args = array(
			'type' => 'portfolio',
		);
		$counter = 1;
		$cats = get_categories($args);
		foreach ($cats as $cat) {
			if ($cat->cat_ID != 32) {  // to exclude 'others' category
				?>
        <li class="segment-<?php echo $counter; ?>">
        <a href="<?php echo get_category_link($cat->term_id); ?>">
				<?php echo $cat->name; ?>
        </a>
        </li>
				<?php $counter++; } } ?>
    </ul>

    <!-- start of dynamic content (portfolio excerpts) -->
    <div class="portfolio_items_container">
      <ul class="portfolio_items columns">

		  <?php

      if (have_posts()) : while (have_posts()) : the_post();?>

        <li data-type="webdesign" data-id="id-1" class="column column33">

			    <?php if (has_post_thumbnail()) : ?>
          <a href="<?php the_post_thumbnail_url('big_gallery_image'); ?>" data-rel="prettyPhoto[gallery]" rel="prettyPhoto[gallery]" title="<?php the_title(); ?>" class="portfolio_image lightbox">
            <div class="inside">
              <img alt="" src="<?php the_post_thumbnail_url('archive_portfolio_thumbnail');?>">
			        <?php endif; ?>
              <div class="mask"></div>
            </div>
          </a>

          <h1><?php the_title();?></h1>
          <span style="color:#7f7f7f; font-size:11px;"><?php the_excerpt(); ?></span>
          <br><br>
          <a href="<?php the_permalink();?>" class="button button_small button_orange"><span class="inside">read more</span></a>

			<?php endwhile; endif; ?>

        </li>
      </ul>
    </div>
  </div> <!-- wrapper page_text -->
</section> <!-- content -->
<!-- END CONTENT -->
</div>
</div>

<?php get_footer();






