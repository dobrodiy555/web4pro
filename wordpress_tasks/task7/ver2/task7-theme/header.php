<!DOCTYPE HTML>
<html>
<head>

<title></title>

  <!--подключим здесь иначе не работает переключатель тем со светлой на темную-->
  <link rel="stylesheet" href="<?php echo get_theme_file_uri( '/css/light.css' ); ?>" title="light"
          type="text/css"/>
  <link rel="alternate stylesheet" href="<?php echo get_theme_file_uri( '/css/dark.css' ); ?>" title="dark" type="text/css"/>

  <meta charset="UTF-8">

  <!--    add jquery 1.9 here otherwise doesn't work correctly-->
  <script src="https://code.jquery.com/jquery-1.9.0.js" integrity="sha256-TXsBwvYEO87oOjPQ9ifcb7wn3IrrW91dhj6EMEtRLvM=" crossorigin="anonymous"></script>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >

<header>

  <!-- BEGIN STYLESHEET SWITCHER -->
  <div id="stylesheet_switcher">
    <a href="#" id="switcher"></a>
    <ul id="stylesheets">
      <li>
        <a href="#" class="sheet" id="light">
          <span class="image"><img src="<?php echo get_template_directory_uri(); ?>/gfx/stylesheet_light.jpg" alt="" /></span>
          <span class="mask"></span>
          <span class="name"><?php _e('Light version', 'tt7'); ?></span>
        </a>
      </li>
      <li>
        <a href="#" class="sheet" id="dark">
          <span class="image"><img src="<?php echo get_template_directory_uri(); ?>/gfx/stylesheet_dark.jpg" alt="" /></span>
          <span class="mask"></span>
          <span class="name"><?php _e('Dark version', 'tt7'); ?></span>
        </a>
      </li>
    </ul>
  </div>
  <!-- END STYLESHEET SWITCHER -->

  <!-- BEGIN PAGE -->
  <div id="page">
    <div id="page_top">
      <div id="page_top_in">
        <!-- BEGIN TITLEBAR -->
        <header id="titlebar">
          <div class="wrapper">
            <a id="logo" href="<?php echo get_home_url(); ?>"><span></span></a>
            <div id="titlebar_right">
              <ul id="social_icons">
                <li><a href="<?php echo get_option('linkedin'); ?>" class="linkedin"></a></li>
                <li><a href="<?php echo get_option('facebook'); ?>" class="facebook"></a></li>
                <li><a href="<?php echo get_option('twitter'); ?>" class="twitter"></a></li>
                <li><a href="<?php echo get_option('rss'); ?>" class="rss"></a></li>
              </ul>
              <div class="clear"></div>

              <nav>
                <ul id="top_menu">
                  <li id="home_nav_menu_item"><a href="<?php echo get_home_url(); ?>"><?php _e('Home', 'tt7'); ?></a></li>
                  <li id="about_nav_menu_item"><a href="<?php echo get_site_url(); ?>/about-us"><?php _e("About us", 'tt7'); ?></a></li>
                  <li id="blog_nav_menu_item"><a href="<?php echo get_site_url(); ?>/posts-archive"><?php _e('Blog', 'tt7'); ?></a></li>

                  <li>
                    <a href="#"><?php _e('Other','tt7'); ?></a>
                    <div class="submenu">
                      <ul class="awp">

                      <?php // walker submenu
                      wp_nav_menu( array(
                              'theme_location' => 'primary',
                              'depth' => 1
                      ) );
                      wp_nav_menu( array(
                              'theme_location' => 'primary',
                              'walker' => new AWP_Menu_Walker(),
                              'depth' => 0
                      ) );
                      ?>
                    </div>
                  </li>

                  <li id="portfolio_nav_menu_item">
                    <a href="<?php echo get_site_url(); ?>/portfolios"><?php _e('Portfolio', 'tt7'); ?></a>
                    <div class="submenu">
                      <ul>
                        <li><a href="<?php echo get_site_url(); ?>/portfolios"><span>All categories</span></a></li>
                        <li><a href="<?php echo get_site_url(); ?>/category/photography/"><span><?php _e('Photography', 'tt7'); ?></span></a></li>
                        <li><a href="<?php echo get_site_url(); ?>/category/webdesign/"><span><?php _e('Webdesign', 'tt7'); ?></span></a></li>
                        <li><a href="<?php echo get_site_url(); ?>/category/branding/"><span><?php _e('Branding', 'tt7'); ?>
                        </span></a></li>
                      </ul>
                    </div>
                  </li>
                  <li id="gallery_nav_menu_item"><a href="<?php echo get_site_url(); ?>/gallery/"><?php _e('Gallery', 'tt7'); ?></a></li>
                  <li id="contact_nav_menu_item"><a href="<?php echo get_site_url(); ?>/contact-us"><?php _e('Contact', 'tt7'); ?></a></li>
                </ul>
              </nav>
            </div>
            <div class="clear"></div>
          </div>
        </header>
        <!-- END TITLEBAR -->

