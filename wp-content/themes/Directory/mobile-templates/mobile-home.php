<?php
/**
 * Home page template for app like mobile view.

 */
get_header(); // Loads the header.php template. ?>

<section id="loop_listing_taxonomy" class="widget_loop_taxonomy_wrap list">
		
		<?php 
		
		if ( have_posts() ) :

			while ( have_posts() ) : the_post();	
				global $post;
				  $addons_posttype = tmpl_addon_name();
				  if (function_exists('tmpl_wp_is_mobile') && tmpl_wp_is_mobile()) {
							/* this content will load in mobile only */
							if (file_exists(WP_PLUGIN_DIR . '/Tevolution-' . $addons_posttype[get_post_type()] . '/templates' . '/entry-mobile-' . $post->post_type . '.php')) {
									  include(WP_PLUGIN_DIR . '/Tevolution-' . $addons_posttype[get_post_type()] . '/templates' . '/entry-mobile-' . $post->post_type . '.php');
							} else {
									  include(WP_PLUGIN_DIR . '/Tevolution-' . $addons_posttype['listing'] . '/templates/entry-mobile-listing.php');
							}
				  }		
							
			endwhile;

		endif;
		

  	do_action( 'close_content' );
	apply_filters('supreme_custom_front_loop_navigation',supreme_loop_navigation($post)); // Loads the loop-navigation .
	?>
</section>
<!-- #content -->
<?php 
do_action( 'after_content' );
get_footer(); // Loads the footer.php template. ?>