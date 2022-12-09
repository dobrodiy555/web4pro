<?php
/*
 * Template Name: Shop with map
 * Template Post Type: post, page, shops
 */

get_header(); ?>

<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

			while ( have_posts() ) :
			the_post();

			do_action( 'storefront_single_post_before' );

			get_template_part( 'content', 'single' );

            echo do_shortcode('[show_map_with_address]'); // our shortcode from task3_plugin.php

            do_action( 'storefront_single_post_after' );

			endwhile; // end of the loop

		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();


