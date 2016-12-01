<?php
/**
 * Template Name: Front Page
 *
 * This is the home template.  Technically, it is the "posts page" template.  It is used when a visitor is on the 
 * page assigned to show a site's latest blog posts.
 *
 * @package supreme
 * @subpackage Template
 */
get_header();

if(!is_active_sidebar('homepage-content-one')){
	$class_div = 'without-content-one';
}else{
	$class_div = '';
}

if(is_active_sidebar('homepage-content-one')){
	echo '<div class="homepage_content_one fullwidth">
			<div class="fullwidth-wrap">'; 
				dynamic_sidebar('homepage-content-one');
		echo '</div>
		</div>';
}

/* called widget area homepage - above footer */
if(is_active_sidebar('homepage-content-two')){
	echo '<div class="homepage_content_two fullwidth '.$class_div.'"><div class="fullwidth-wrap">'; 
	dynamic_sidebar('homepage-content-two');echo '</div></div>';
}

/* called widget area homepage - above footer. Shows thwo widget area as left right */
if(is_active_sidebar('homepage-above-main-left') || is_active_sidebar('homepage-above-main-right')){
	echo '<div class="homepage_above_content fullwidth">';
		echo '<div class="fullwidth-wrap">';
			if(is_active_sidebar('homepage-above-main-left'))
				echo '<div class="above_main_left">';dynamic_sidebar('homepage-above-main-left');echo '</div>';
			if(is_active_sidebar('homepage-above-main-right'))	
				echo '<div class="above_main_right">';dynamic_sidebar('homepage-above-main-right');echo '</div>';
		echo '</div>';
	echo '</div>';
}
	
?>
<div class="homepage_above_content2 wrap row">
<?php do_action('tmpl_open_wrap');?>
	<section id="content" class="large-9 small-12 columns">
	  <?php do_action( 'open_front_content' );
		if ( have_posts() ) : 
			while ( have_posts() ) : the_post(); 
				do_action( 'before_entry' ); ?>
					 
				   <div id="post-<?php the_ID(); ?>" class="<?php supreme_entry_class(); ?>">
					<?php do_action( 'open_entry' ); ?>
						<section class="entry-content">
						<?php 
						the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'templatic' ) );
						wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'templatic' ), 'after' => '</p>' ) );
						?>
						</section>
						<!-- .entry-content -->
						<?php do_action( 'close_entry' ); ?>
				   </div>
				<!-- .hentry -->
		<?php
			endwhile;
		endif; ?>

		 <div class="hfeed">
			<?php 
				get_template_part( 'loop-meta' );
			
				dynamic_sidebar( 'before-content' );?>
				  <div class="home_page_content">
					<?php dynamic_sidebar('home-page-content'); ?>
				  </div>
				<?php 
				dynamic_sidebar( 'after-content' ); ?>
		 </div>
		 
		<!-- .hfeed -->
		<?php 
		do_action( 'close_content' );
		apply_filters('supreme_custom_front_loop_navigation',supreme_loop_navigation($post)); // Loads the loop-navigation .
		?>
	</section>
	<!-- #content -->

<?php 
	apply_filters( 'tmpl-front_page_sidebar',supreme_front_page_sidebar() ); // Loads the front page sidebar.
	do_action( 'after_content' );
	do_action( 'close_main' ); // supreme_close_main 
?>
</div>
<!-- .wrap -->
<?php 

/* called widget area homepage - above footer */
if(is_active_sidebar('homepage-below-main')){
	echo '<div class="homepage_content_five fullwidth"><div class="fullwidth-wrap">';dynamic_sidebar('homepage-below-main');echo '</div></div>';
}

/* called widget area homepage - above footer */
if(is_active_sidebar('above-homepage-footer')){
	echo '<div class="above_homepage_footer fullwidth"><div class="fullwidth-wrap">';dynamic_sidebar('above-homepage-footer');echo '</div></div>';
}

	
get_footer(); ?>