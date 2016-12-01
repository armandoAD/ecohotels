<?php
/**
 * Tevolution single custom post type template
 *
 * */
get_header();
$tmpdata = get_option('templatic_settings');
$is_edit = '';
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
          $is_edit = 1;
}

global $tmpl_flds_varname;
/* to get the common/context custom fields display by default with current post type */
if (function_exists('tmpl_single_page_default_custom_field')) {
          $tmpl_flds_varname = tmpl_single_page_default_custom_field(get_post_type());
}

do_action('tmpl_before_frontend_edit_container'); /* for front editor submit button section */

/* do action for display the breadcrumb  inside the container. */
do_action('directory_inside_container_breadcrumb');

while (have_posts()) : the_post(); ?>

<!-- title-section -->
<div class="title-section">
	<header class="entry-header">
		<?php
			$listing_logo = get_post_meta(get_the_ID(), 'listing_logo', true); 
			
			if (($listing_logo != "" && $tmpl_flds_varname['listing_logo']) && ($is_edit == "")): ?>
				<div class="entry-header-logo">
					<img src="<?php echo $listing_logo ?>" alt="<?php echo $tmpl_flds_varname['listing_logo']['label']; ?>" />
				</div>
		<?php 
			elseif ($is_edit == 1 && $tmpl_flds_varname['listing_logo']): ?>
				<div class="entry-header-logo" >
					<div style="display:none;" class="frontend_listing_logo"><?php echo $listing_logo ?></div>
					<!--input id="fronted_files_listing_logo" class="fronted_files" type="file" multiple="true" accept="image/*" /-->
					<div id="fronted_upload_listing_logo" class="frontend_uploader button" data-src="<?php echo $listing_logo ?>">	                 	
						<span><?php _e('Upload ', 'templatic') . $tmpl_flds_varname['listing_logo']['label']; ?></span>						
					</div>
				</div>
		<?php endif; do_action('tmpl_after_logo');
		
		?>
		
		<section class="entry-header-title">
			<h1 itemprop="name" class="entry-title <?php if ($is_edit == 1): ?>frontend-entry-title <?php endif; ?>" <?php if ($is_edit == 1): ?> contenteditable="true"<?php endif; ?> >
				<?php do_action('before_title_h1'); the_title(); do_action('after_title_h1'); ?>
			</h1>
			<div class="rate_visit">
				<?php
					/* show rattings star */
					if ($tmpdata['templatin_rating'] == 'yes'){
						$total = get_post_total_rating(get_the_ID());
						$total = ($total == '') ? 0 : $total;
						$review_text = ($total >0 ) ?  '<a href="#comments-template"> ('.$total .') </a>' : '';
						if($total > 0){ ?>
							<div class="listing_rating">
								 <div class="directory_rating_row">
									<span class="single_rating"><?php if(function_exists('draw_rating_star_plugin')){ echo draw_rating_star_plugin(get_post_average_rating(get_the_ID())); } ?>
										<span><?php echo $review_text ?></span>
									</span>
								</div>
							</div>
							<?php
						}
					}
					do_action('directory_display_rating', get_the_ID());
					
					/* show visits counter */
					if (isset($tmpdata['templatic_view_counter']) && $tmpdata['templatic_view_counter'] == 'Yes') {
						if (function_exists('view_counter_single_post')) {
								view_counter_single_post(get_the_ID());
						}
						$post_visit_count = (get_post_meta(get_the_ID(), 'viewed_count', true)) ? get_post_meta(get_the_ID(), 'viewed_count', true) : '0';
						$post_visit_daily_count = (get_post_meta(get_the_ID(), 'viewed_count_daily', true)) ? get_post_meta(get_the_ID(), 'viewed_count_daily', true) : '0';
						$custom_content = '';
						echo "<div class='view_counter'>";
							echo "<p>";
								_e('Visited', 'templatic');
							echo " <span class='counter'>" . $post_visit_count . "</span> ";
							($post_visit_count == 1) ? _e('time', 'templatic') : _e('times', 'templatic');
								echo ', <span class="counter">' . $post_visit_daily_count . "</span> ";
							($post_visit_daily_count == 1) ? _e("Visit today", 'templatic') : _e("Visits today", 'templatic');
								echo "</p>";
						echo '</div>';
					}?>
			</div>
		</section>
	</header>
	

		<?php
			/* for hotel info in responsive view. add_action is in functions/tmpl-functions.php  */
			if ( wp_is_mobile() ): ?>
			<div class="mobile-hotel-info">
				<?php do_action('tmpl_splendor_after_title_section'); ?>
			</div>	

		<?php endif; ?>
</div>

<!-- title-section end -->

	<?php
	
	do_action('directory_before_post_loop'); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
        <!--start post type title -->
			<?php do_action('directory_before_post_title');         /* do action for before the post title. */ 
                    /* do action for after the post title. */
                    do_action('directory_after_post_title');
                    ?>
                    <!--end post type title -->               


                    <!--Code start for single captcha -->   
                    <?php
                  
                    $captcha_dis = '';
                  
                    $recaptcha = get_option("recaptcha_options");
                    global $current_user;
                    ?>

                <div id="myrecap" style="display:none;">
				<?php
					if ($recaptcha['show_in_comments'] != 1 || $current_user->ID != '') {
                         templ_captcha_integrate($captcha_dis);
					}
				?>
				</div> 
                <input type="hidden" id="owner_frm" name="owner_frm" value=""  />
                <div id="claim_ship"></div>
                <script type="text/javascript" async >
                         var RECAPTCHA_COMMENT = '';
				<?php if ($recaptcha['show_in_comments'] != 1 || $current_user->ID != '') { ?>
						jQuery('#owner_frm').val(jQuery('#myrecap').html());
				<?php } else { ?>
						RECAPTCHA_COMMENT = <?php echo $recaptcha['show_in_comments']; ?>;
				<?php } ?>
				</script>

            </div> 



<!-- start content part-->
<div id="content" class="large-9 small-12 columns" role="main">	
    <?php

    if (function_exists('supreme_sidebar_before_content')) {
        /* Loads the sidebar-before-content. */
        apply_filters('tmpl_before-content', supreme_sidebar_before_content());
    }
	?>
	<!--Code end for single captcha -->
	<!-- listing content-->
	<section class="entry-content">
	  <?php
		get_template_part('directory-listing',  'single-content');
	  ?>
	</section>
	<!--Finish the listing Content -->

	<!--Custom field collection do action -->
	<?php
	do_action('directory_custom_fields_collection');

	do_action('directory_extra_single_content');

	/* Display categories on detail page */
	do_action('directory_the_taxonomies');
	
	if (function_exists('tevolution_socialmedia_sharelink'))
          tevolution_socialmedia_sharelink($post);
   
    do_action('directory_after_post_loop');

    do_action('directory_edit_link');
    
	endwhile; /* end of the loop. */

    wp_reset_query(); /* reset the wp query */

    /* add action for display before the post comments. */
	
	/* add action for display the next previous pagination */
    do_action('tmpl_single_post_pagination');
	
	/* add action for display the related post list. */
	do_action('tmpl_related_listings'); 
	
    do_action('tmpl_before_comments');

    do_action('after_entry');

    do_action('for_comments');

    /* Add action for display after the post comments. */
    do_action('tmpl_after_comments');

    global $post;

    if (function_exists('supreme_sidebar_after_content'))
        apply_filters('tmpl_after-content', supreme_sidebar_after_content()); /* after-content-sidebar use remove filter to don't display it */
    ?>
</div><!-- #content -->

<!--single post type sidebar -->
<?php /* call the sidebar. If there are widget put on post type's detail page widget area then show relared post type's detail page sidebar, Otherwise show primary sidebar */ ?>
	<aside id="sidebar-primary" class="sidebar large-3 small-12 columns">
	<?php 
	
	/* show hotel info for desktop view only */
	if ( !wp_is_mobile() ) {
		do_action('tmpl_inside_sidebar');
	}
	
	do_action('above_' . get_post_type() . '_detail_sidebar');
	
	if (is_active_sidebar(get_post_type() . '_detail_sidebar')) : 
		dynamic_sidebar(get_post_type() . '_detail_sidebar');
	
	elseif (is_active_sidebar('primary-sidebar')) :
		dynamic_sidebar('primary-sidebar'); 
	
	endif; 
	
	do_action('below_' . get_post_type() . '_detail_sidebar');
	?>
	</aside>
<!--end single post type sidebar -->
<!-- end  content part-->
<?php get_footer(); ?>