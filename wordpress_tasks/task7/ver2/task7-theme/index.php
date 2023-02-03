<!--this is a homepage (analogue of index.htm), you can change homepage settings in setting -> reading-->

<?php get_header(); ?>

<!--<h1>Welcome to my homepage</h1>-->

<!-- BEGIN TOP -->
<section id="top">
  <div class="wrapper">
    <div id="top_slide" class="flexslider">
      <ul class="slides">
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/gfx/examples/top_slide1.jpg" alt="" />
          <p class="flex-caption">
            <strong><?php _e('Lorem ipsum dolor sit amet', 'tt7'); ?></strong>
            <span><?php _e('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Velit. Pellentesque molestie quis, venenatis consequat. Morbi egestas, justo neque, fringilla fringilla orci. Suspendisse placerat scelerisque...', 'tt7'); ?></span>
          </p>
        </li>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/gfx/examples/top_slide2.jpg" alt="" />
          <p class="flex-caption">
            <strong><?php _e('Sit amet', 'tt7'); ?></strong>
            <span><?php _e('Pellentesque molestie quis, venenatis consequat. Morbi egestas, justo neque.', 'tt7'); ?></span>
          </p>
        </li>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/gfx/examples/top_slide3.jpg" alt="" />
          <p class="flex-caption">
            <strong><?php _e('Dolor amet sit', 'tt7'); ?></strong>
            <span><?php _e('Velit, pellentesque molestie quis, venenatis consequat.', 'tt7'); ?></span>
          </p>
        </li>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/gfx/examples/top_slide4.jpg" alt="" />
          <p class="flex-caption">
            <strong>Sit amet</strong>
            <span>Pellentesque molestie quis, venenatis consequat. Morbi egestas, justo neque.</span>
          </p>
        </li>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/gfx/examples/top_slide5.jpg" alt="" />
          <p class="flex-caption">
            <strong><?php _e('Lorem ipsum dolor sit amet', 'tt7'); ?></strong>
            <span><?php _e('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Velit. Pellentesque molestie quis, venenatis consequat. Morbi egestas, justo neque, fringilla fringilla orci. Suspendisse placerat scelerisque...', 'tt7'); ?></span>
          </p>
        </li>
      </ul>
    </div>
  </div>
</section>
<!-- END TOP -->

<!-- BEGIN CONTENT -->
<section id="content">
  <div class="wrapper page_text page_home">
    <div class="introduction">
      <h1><?php _e('Lorem ipsum amet ', 'tt7'); ?><a href="#"><?php _e('libero et', 'tt7'); ?></a> <?php _e('est fermentum suscipit sed id nulla. Donec elementum placerat tortort.', 'tt7'); ?></h1>
      <p><?php _e('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vehicula. Vivamus urna vitae arcu elit, consequat lorem velit sit amet metus. Phasellus purus. Aenean quis ante. Vestibulum aliquam iaculis leo, pretium wisi. Vivamus posuere vehicula dolor nonummy porttitor auctor, sapien vitae wisi vel odio.', 'tt7'); ?></p>
      <a href="<?php echo get_site_url(); ?>/posts-archive" class="button button_big button_orange float_left"><span class="inside"><?php _e('read more', 'tt7'); ?></span></a>
    </div>

    <ul class="columns dropcap">
      <?php $args = array('type' => 'post', 'posts_per_page' => 3);
      $counter = 0;
      $qur = new WP_Query($args);
      if ($qur->have_posts()) :
      while ($qur->have_posts()) : $qur->the_post(); $counter++;
      ?>
      <li class="column column33
      <?php switch ($counter) {
        case 1:
          echo "first";
          break;
        case 2:
          echo "second";
          break;
        default:
          echo "third";
      } ?>">
        <div class="inside">
          <h1><?php the_title(); ?></h1>
          <p><?php the_excerpt(); ?></p>
          <p class="read_more"><a href="<?php the_permalink(); ?>"><?php _e('Read more', 'tt7'); ?></a></p>
          <?php endwhile; endif; ?>
        </div>
      </li>
    </ul>

    <ul class="columns iconcap">
      <?php $args1 = array('type' => 'post', 'posts_per_page' => 3);
      $counter1 = 0;
      $qur1 = new WP_Query($args);
      if ($qur1->have_posts()) :
      while ($qur1->have_posts()) : $qur1->the_post(); $counter1++;
      ?>
      <li class="column column33
      <?php switch ($counter1) {
        case 1:
          echo "inews";
          break;
        case 2:
          echo "italk";
          break;
        default:
          echo "icon";
      } ?>">
        <div class="inside">
          <h1><?php the_title(); ?></h1>
          <p><?php the_excerpt(); ?></p>
          <p class="read_more"><a href="<?php the_permalink(); ?>"><?php _e('Read more', 'tt7'); ?></a></p>
          <?php endwhile; endif; ?>
        </div>
      </li>
    </ul>

    <div class="underline"></div>
    <div class="portfolio">
      <p class="all_projects"><a href="<?php echo get_site_url(); ?>/portfolios/"><?php _e('View all projects', 'tt7'); ?></a></p>
      <h1><?php _e('Portfolio', 'tt7'); ?></h1>
      <div class="columns">

      <?php
      $args2 = array('post_type' => 'portfolio', 'posts_per_page' => 4);
      $qur2 = new WP_Query($args2);
      if ($qur2->have_posts()) :
      while ($qur2->have_posts()) : $qur2->the_post();
      $expt = get_the_excerpt(); // чтобы потом обрезать
      ?>

        <div class="column column25">
          <?php if (has_post_thumbnail()) : ?>
          <a href="<?php the_post_thumbnail_url('big_gallery_image'); ?>" class="image lightbox" data-rel="prettyPhoto[gallery]" rel="prettyPhoto[gallery]" title="<?php the_title(); ?>">
           <?php endif; ?>
								<span class="inside">
									<img src="<?php the_post_thumbnail_url('small_frontpage_portfolio_image'); ?>" alt="" />
									<span class="caption"><?php echo substr($expt, 0, 26); ?></span>
								</span>
            <span class="image_shadow"></span>
          </a>
        </div>

        <?php endwhile; endif ?>

        <div class="clear"></div>
      </div>
    </div>
  </div>
</section>
<!-- END CONTENT -->
</div>
</div>

<?php get_footer(); ?>