<!DOCTYPE HTML>
<html>
<head>

  <title>The Same</title>

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
          <span class="name">Light version</span>
        </a>
      </li>
      <li>
        <a href="#" class="sheet" id="dark">
          <span class="image"><img src="<?php echo get_template_directory_uri(); ?>/gfx/stylesheet_dark.jpg" alt="" /></span>
          <span class="mask"></span>
          <span class="name">Dark version</span>
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
            <a id="logo" href="http://localhost/wordpress/"><span></span></a>
            <div id="titlebar_right">
              <ul id="social_icons">
                <li><a href="#" class="linkedin"></a></li>
                <li><a href="#" class="facebook"></a></li>
                <li><a href="#" class="twitter"></a></li>
                <li><a href="#" class="rss"></a></li>
              </ul>
              <div class="clear"></div>

              <nav>
                <ul id="top_menu">
                  <li id="home_nav_menu_item"><a href="http://localhost/wordpress/">Home</a></li>
                  <li><a href="http://localhost/wordpress/about-us/">About Us</a></li>
                  <li><a href="http://localhost/wordpress/posts-archive/">Blog</a></li>
                  <li>
                    <a href="#">Other</a>
                    <div class="submenu">
                      <ul>
                        <li><a href="./blog-article.htm.html"><span>Single Blog</span></a></li>
                        <li><a href="./shortcodes-columns.htm.html"><span>Columns</span></a></li>
                        <li><a href="./shortcodes-elements.htm.html"><span>Elemantary</span></a></li>
                        <li><a href="./shortcodes-boxes.htm.html"><span>Boxes</span></a></li>
                        <li><a href="./shortcodes-typography.htm.html"><span>Typography</span></a></li>
                      </ul>
                    </div>
                  </li>
                  <li>
                    <a href="http://localhost/wordpress/portfolios">Portfolio</a>
                    <div class="submenu">
                      <ul>
                        <li><a href="http://localhost/wordpress/portfolios"><span>All categories</span></a></li>
                        <li><a href="http://localhost/wordpress/category/photography/"><span>Photography</span></a></li>
                        <li><a href="http://localhost/wordpress/category/webdesign/"><span>Webdesign</span></a></li>
                        <li><a href="http://localhost/wordpress/category/branding/"><span>Branding</span></a></li>
                      </ul>
                    </div>
                  </li>
                  <li><a href="http://localhost/wordpress/gallery/">Gallery</a></li>
                  <li><a href="http://localhost/wordpress/contact-us">Contact</a></li>
                </ul>
              </nav>
            </div>
            <div class="clear"></div>
          </div>
        </header>
        <!-- END TITLEBAR -->

