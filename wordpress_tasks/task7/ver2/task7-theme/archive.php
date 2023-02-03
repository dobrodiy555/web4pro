<?php // archive for categories, author, date etc.

get_header(); ?>

<!-- BEGIN CONTENT -->
<section id="content">
  <div class="wrapper page_text">
    <h1 class="page_title"> <?php if (is_category()) :
      single_cat_title();
    elseif (is_tag()) :
      single_tag_title();
    elseif (is_author()) :
      the_post();
      echo "Author Archive: " . get_the_author();
      rewind_posts();
    elseif (is_day()) :
      echo "Daily Archive: " . get_the_date();
    elseif (is_month()) :
      echo 'Monthly Archive: ' . get_the_date('F Y');
    elseif (is_year()) :
	    echo 'Yearly Archive: ' . get_the_date('Y');
    else :
      echo 'Archive';
        endif; ?> </h1>
    <div class="breadcrumbs">
      <div class="inside">
        <a href="http://localhost/wordpress/" class="first"><span>The Same</span></a>
        <a href="#" class="last"><span>Blog</span></a>
      </div>
    </div>

  <!-- start of dynamic contents (post excerpts)-->
  <div class="columns">
    <div class="column column75">

    <!-- Нужно поместить луп после дивов columns иначе некорректно отображало сайдбар (не ставило сбоку)-->

    <?php if (have_posts()) :
        while (have_posts()) :
        the_post();?>

      <article class="article">
        <div class="article_image nomargin">
          <div class="inside">
            <?php if (has_post_thumbnail()): ?>
              <img src="<?php the_post_thumbnail_url('single_post_thumbnail')?>">
              <?php endif; ?>
          </div>
        </div>
        <div class="article_details">
          <ul class="article_author_date">
            <li><em>Add: </em> <?php the_date(); ?> </li>
            <li><em>Author: </em> <a href="#"><?php the_author();?></a></li>
          </ul>
          <p class="article_comments"><em>Comment: </em> <span> <?php echo get_comments_number(); ?> </span></p>
        </div>

        <h1><?php the_title();?></h1>
        <?php the_excerpt(); ?>

        <a href="<?php the_permalink();?>" class="button button_small button_orange"><span class="inside">read more</span></a>

       <?php endwhile; ?>

        <nav>
          <ul class="pager">
            <li><?php next_posts_link( 'Older posts' ); ?></li>
            <li><?php previous_posts_link( 'Newer posts' ); ?></li>
          </ul>
        </nav>

       <?php endif; ?>
      </article>
    </div> <!-- column column 75 -->

      <?php get_sidebar(); ?>

  </div> <!-- page top_in -->
  </div> <!-- page top -->

<?php get_footer(); ?>