<?php
/*
  * Template Name: Post Archive
  */
get_header(); ?>

	<!-- BEGIN CONTENT -->
	<section id="content">
	<div class="wrapper page_text">
		<h1 class="page_title">Posts archive (blog)</h1>
		<div class="breadcrumbs">
			<div class="inside">
				<a href="http://localhost/wordpress/" class="first"><span>The Same</span></a>
				<a href="http://localhost/wordpress/posts-archive/" class="last"><span>Blog</span></a>
			</div>
		</div>

		<!-- start of dynamic contents (post excerpts)-->
		<div class="columns">
			<div class="column column75">

			<?php
			$current_page = !empty( $_GET['q'] ) ? $_GET['q'] : 1;
			$qur = new WP_Query( array('post_type' => 'post', 'posts_per_page' => 5, 'paged' => $current_page) );
			if ($qur->have_posts()) :
				while ($qur->have_posts()) : $qur->the_post(); ?>
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

					<?php endwhile;  endif;


          // pagination part
		  
          $url = $_SERVER['REQUEST_URI']; // url of current page
          $url = strtok($url, '?'); // to remove part after ? for next queries
			    echo paginate_links([
            'prev_text' => __('&laquo; Prev'),
            'next_text' => __('Next &raquo;'),
            'base' => $url . '%_%',
            'format' => '?q=%#%',
            'current' => $current_page,
             'total'   => $qur->max_num_pages,
          ]);

          wp_reset_postdata(); ?>

        </article>
			</div> <!-- column column 75 -->


			<?php get_sidebar(); ?>

		</div> <!-- page top_in -->
	</div> <!-- page top -->

<?php get_footer(); ?>