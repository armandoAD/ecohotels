<?php
/**
 * Tevolution single custom post type Preview Page template
 *
**/
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-tabs');
$cur_post_type = $_REQUEST['submit_post_type'];
$tmpdata = get_option('templatic_settings');	
$address=$_REQUEST['address'];
$geo_latitude =$_REQUEST['geo_latitude'];
$geo_longitude = $_REQUEST['geo_longitude'];
$map_type =$_REQUEST['map_view'];
$website=$_REQUEST['website'];
$phone=$_REQUEST['phone'];
$listing_logo=$_REQUEST['listing_logo'];
$listing_timing=$_REQUEST['listing_timing'];
$email=$_REQUEST['email'];
$special_offer=$_REQUEST['proprty_feature'];
$video=$_REQUEST['video'];
$facebook=$_REQUEST['facebook'];
$google_plus=$_REQUEST['google_plus'];
$twitter=$_REQUEST['twitter'];
$zooming_factor=$_POST['zooming_factor'];
$_REQUEST['imgarr'] = explode(",",$_REQUEST['imgarr']);

/* Set curent language in cookie */
if(is_plugin_active('wpml-translation-management/plugin.php')){
	global $sitepress;
	$_COOKIE['_icl_current_language'] = $sitepress->get_current_language();
}
global $htmlvar_name,$heading_type,$tmpl_flds_varname;
/* Get heading type to display the custom fields as per selected section.  */
if(function_exists('tmpl_fetch_heading_post_type')){

	$heading_type = tmpl_fetch_heading_post_type($cur_post_type);
}


/* get all the custom fields which select as " Show field on detail page" from back end */

if(function_exists('tmpl_single_page_custom_field')){
	$htmlvar_name = tmpl_single_page_custom_field($cur_post_type);
}else{
	global $htmlvar_name;
}


/* to get the common/context custom fields display by default with current post type */
if(function_exists('tmpl_single_page_default_custom_field')){	
	$tmpl_flds_varname = tmpl_single_page_default_custom_field($cur_post_type);
}

/* get banner for heading */
$listing_banner = $_REQUEST['listing_banner'];
?>
<script id="tmpl-foudation" src="<?php echo TEMPL_PLUGIN_URL; ?>js/foundation.min.js"> </script> 
<!-- full width detail start -->
<div id="content" role="main" class="full_width_detail">
    <?php
	$listing_logo = $_REQUEST['listing_logo']; 
	
    do_action('tmpl_after_logo');
	 
	do_action('directory_before_post_loop'); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 
		<!--start post type title -->
		<?php do_action('directory_before_post_title');         /* do action for before the post title. */ ?>
		<header class="entry-header">
			<?php if($listing_logo!=""):?>
				<div class="entry-header-logo"> <img src="<?php echo $listing_logo?>" alt="<?php _e('Logo','templatic');?>" /> </div>
			<?php endif;?>
			<section class="entry-header-title">
				<h1 itemprop="name" class="entry-title"><?php echo stripslashes($_REQUEST['post_title']); ?></h1>
				<div class="rate_visit">
					<div class="listing_rating">
						<div class="directory_rating_row">
							<span class="single_rating">
								<i class="rating-on"></i>
								<i class="rating-on"></i>
								<i class="rating-on"></i>
								<i class="rating-on"></i>
								<i class="rating-off"></i>
								<span>
									<a href="#comments">7 <?php _e('Reviews','templatic');?></a>
								</span>
							</span>
						</div>
					</div>
					<div class="view_counter">
						<p><?php echo __('Visited ','templatic').'444 '.__('times','templatic').', 1 '.__('Visit today','templatic');?></p>
					</div>
				</div>
			</section>
		</header>
	
    </div>
    
    <!-- End Image Upload --> 
</div>
<!-- full width detail end -->

<div class="wrap row">
	<?php 
		do_action('tmpl_open_wrap'); 
		do_action('directory_before_container_breadcrumb'); /* do action for display the breadcrumb in between header and container. */
	?>
	<?php
	/* do action for after the post title. */
	do_action('tmpl_splendor_after_title_section');
	?>
	<!-- start content part-->
	<div id="content" class="large-9 small-12 columns" role="main">
	
		<?php
		/* do action for display the breadcrumb  inside the container. */
		do_action('directory_inside_container_breadcrumb');
		if (function_exists('supreme_sidebar_before_content')) {
			/* Loads the sidebar-before-content. */
			apply_filters('tmpl_before-content', supreme_sidebar_before_content());
		}
		?>
		<!--Code end for single captcha --> 
		<!-- listing content-->
		<section class="entry-content">
			<!-- Image Gallery Div --> 
			<div id="directory_detail_img" class="entry-header-image">

			 <?php if($_REQUEST['imgarr'][0]!='' ):?>
					<div id="directory_detail_img" class="entry-header-image">
						<?php do_action('directory_preview_before_post_image');
							$thumb_img_counter = 0;
							$thumb_img_counter = $thumb_img_counter+count($_REQUEST['imgarr']);
							$image_path = get_image_phy_destination_path_plugin();
							$tmppath = "/".$upload_folder_path."tmp/";
							
							foreach($_REQUEST['imgarr'] as $image_id=>$val):
								 $thumb_image = get_template_directory_uri().'/images/tmp/'.trim($val);
								break;
							endforeach;
						if(isset($_REQUEST['pid']) && $_REQUEST['pid']!="")
						{	/* execute when comes for edit the post */
							$large_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'directory-single-image');
							$thumb_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'tevolution_thumbnail');
							$largest_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'large');		
						}
					 ?>
						<div class="listing-image">
							 <?php $f=0; foreach($_REQUEST['imgarr'] as $image_id=>$val):
									$curry = date("Y");
									$currm = date("m");
									$src = get_template_directory().'/images/tmp/'.$val;
									$img_title = pathinfo($val);
									
							  ?>
								<?php if($largest_img_arr): ?>
										<?php  foreach($largest_img_arr as $value):
											$tmp_v = explode("/",$value['file']);
											 $name = end($tmp_v);
											  if($val == $name):	
										?>
											<img src="<?php echo  $value['file'];?>" alt="" width="765" height="510" class="Thumbnail thumbnail large post_imgimglistimg"/>
										<?php endif;
											endforeach;
									else: ?>								
									<img src="<?php echo $thumb_image;?>" alt="" width="765" height="510" class="Thumbnail thumbnail large post_imgimglistimg"/>
								<?php endif;
								if($f==0) break; endforeach;?>								 
						 </div>	
						 <?php  if(count(array_filter($_REQUEST['imgarr']))>1):?>					
						 <div id="gallery" class="image_title_space">
							<ul class="more_photos">
							 <?php foreach($_REQUEST['imgarr'] as $image_id=>$val)
								{
									$curry = date("Y");
									$currm = date("m");
									$src = get_template_directory().'/images/tmp/'.$val;
									$img_title = pathinfo($val);						
									if($val):
									if(file_exists($src)):
											 $thumb_image = get_template_directory_uri().'/images/tmp/'.$val; ?>
											 <li><img src="<?php echo $thumb_image;?>" alt="" height="85" width="125" title="<?php echo $img_title['filename'] ?>" /></li>
									<?php else: ?>
										<?php
											if($largest_img_arr):
											foreach($largest_img_arr as $value):	
												$tmpl = explode("/",$value['file']);
												$name = end($tmpl);									
												if($val == $name):?>
												<li><img src="<?php echo $value['file'];?>" alt="" height="85" width="125" title="<?php echo $img_title['filename'] ?>" /></li>
										<?php
												endif;
											endforeach;
											endif;
										?>
									<?php endif;
									
									else: 
										if($thumb_img_arr): ?>
										<?php 
										$thumb_img_counter = $thumb_img_counter+count($thumb_img_arr);
										for($i=0;$i<count($thumb_img_arr);$i++):
											$thumb_image = $large_img_arr[$i];
											
											if(!is_array($thumb_image)):
										?>
										  <li><img src="<?php echo $thumb_image;?>" alt="" height="60" width="60" title="<?php echo $img_title['filename'] ?>" /></li>
										  <?php endif;?>
									<?php endfor; ?>
									<?php endif; ?>	
									<?php endif; ?>
								<?php
								$thumb_img_counter++;
								} ?>
								
								</ul>
						 </div>                 
					   <?php endif;?>
					   <!-- -->                                   
					   <?php do_action('directory_preview_after_post_image');?>                              
					</div>                      
				  <?php endif;?>
			</div><!-- .entry-header-image -->
			
		  <?php
			$is_edit = '';
				if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
						  $is_edit = 1;
				}
				$tmpdata = get_option('templatic_settings');
				$googlemap_setting = get_option('city_googlemap_setting');
				$special_offer = $_REQUEST['proprty_feature'];
				$video = $_REQUEST['video'];
				$facebook = $_REQUEST['facebook'];
				$google_plus = $_REQUEST['google_plus'];
				$twitter = $_REQUEST['twitter'];
				$listing_address = $_REQUEST['address'];

				if (isset($post)){
						  $post_img = bdw_get_images_plugin($post->ID, 'directory-single-image');
						  $post_images = @$post_img[0]['file'];
						  $title = urlencode($post->post_title);
						  $url = urlencode(get_permalink($post->ID));
						  $summary = urlencode(htmlspecialchars($post->post_content));
						  $image = $post_images;
				}

				global $htmlvar_name, $tmpl_flds_varname;
				do_action('dir_before_tabs');

				if($_REQUEST['post_content'] != '' && $tmpdata['direction_map'] == 'No' && empty($special_offer) && empty($video)){
					echo '<div><h3 class="widget-title">'.__('Overview', 'templatic').'</h3></div>';
				}
				else{ ?>
				
					<ul class="tabs" data-tab role="tablist">
					<?php
						do_action('dir_start_tabs');

						if ($_REQUEST['post_content'] != ''): ?>
							<li class="tab-title active" role="presentational">
								<a href="#listing_description" role="tab" tabindex="0" aria-selected="false" controls="listing_description"><?php _e('Overview', 'templatic'); ?></a>
							</li>
							<?php
						endif;

						if($special_offer!=""):?>
							<li class="tab-title"><a href="#special_offer"><?php _e('Special Offer','templatic');?></a></li>
						<?php endif;?>
						
						<?php if($video!=""):?>
							<li class="tab-title"><a href="#listing_video"><?php _e('Video','templatic');?></a></li>
						<?php endif;

							 /* To display the events "Tab" available on that place */
						do_action('tmpl_show_events_tab');

						global $post, $events_list;

							$event_for_listing = get_post_meta($post->ID, 'event_for_listing', true);
							if (!empty($event_for_listing)) {
								$event_for_list = explode(',', $event_for_listing);
								if (function_exists('tmpl_get_events_list')) {
									$events_list = tmpl_get_events_list($event_for_list);
									if (!empty($events_list)) { ?>
											<li class="tab-title" role="presentational">
												<a href="#listing_event" role="tab" tabindex="4" aria-selected="false" controls="listing_event"><?php _e('Events', 'templatic'); ?></a>
											</li><?php
										}
								}
							}
							do_action('dir_end_tabs');  ?>
					</ul>
			  <?php 
				}
				do_action('dir_after_tabs'); ?>
			
				<div class="tabs-content"> 
			
				<!--Overview Section Start -->
				<section role="tabpanel" aria-hidden="false" class="content active" id="listing_description">
					<div class="entry-content frontend-entry-content <?php if ($is_edit == 1): ?>editblock listing_content <?php
						endif;
						if (!$thumb_img): ?>content_listing<?php else: ?>listing_content <?php endif; ?>">
								<?php
								do_action('directory_before_post_content');
								echo $_REQUEST['post_content'];
								do_action('directory_after_post_content');
							   ?>
					</div>
				</section>
				
				<!--Overview Section End -->
				
				<?php if ($tmpdata['direction_map'] == 'yes' && $listing_address): ?>
				<!--Map Section Start -->
				<section role="tabpanel" aria-hidden="false" class="content" id="listing_map">
				  <?php do_action('directory_single_page_map') ?>
				</section>
				
				<!--Map Section End -->
				<?php
				endif;

				if (($special_offer != "" && $tmpl_flds_varname['proprty_feature'] ) || ($is_edit == 1 && $tmpl_flds_varname['proprty_feature'])): ?>
				<!--Special Offer Start -->
				<section role="tabpanel" aria-hidden="false" class="content" id="special_offer">
					<div class="entry-proprty_feature frontend_proprty_feature <?php if ($is_edit == 1): ?>editblock <?php endif; ?>">
					<?php
						$special_offer = apply_filters('the_content', $special_offer);
						$special_offer = str_replace(']]>', ']]&gt;', $special_offer);
						echo $special_offer;
						?>
					</div>
				</section>
				<!--Special Offer End -->
				<?php
				endif;

				if ($video != "" ): ?>
				<!--Video Code Start -->
				<section role="tabpanel" aria-hidden="false" class="content" id="listing_video">
				    <div class="frontend_edit_video">
						<?php
							 $embed_video = wp_oembed_get($video);
							 if ($embed_video != "") {
									   echo $embed_video;
							 } else {
									   echo $video;
							 }
						?>
					</div>
				</section>
				<!--Video code End -->
				<?php
				endif;

				do_action('listing_extra_details');

				/* Display the events list on listing detail page */
				echo tmpl_events_on_place_list_details($events_list, $post);
				?>
		  </div>
		
		<?php do_action('directory_preview_page_fields_collection'); /*Add Action for after preview post content. */?> 
		
		<!--Custom field collection do action -->
		<?php
		do_action('directory_custom_fields_collection');

		do_action('directory_extra_single_content');
		
		/* Display categories on detail page */ ?>
		<div class="post-meta">
		  <?php 
			  /* Display selected category and listing tags */
			  if(function_exists('directory_post_preview_categories_tags') ){				  
					echo directory_post_preview_categories_tags($_REQUEST['category'],$_REQUEST['post_tags']);
			  } 
			  ?>
		</div>
		<?php if (function_exists('tevolution_socialmedia_sharelink'))
			  tevolution_socialmedia_sharelink($post);
	   
		do_action('directory_after_post_loop');

		do_action('directory_edit_link');

		wp_reset_query(); /* reset the wp query */

		/* add action for display before the post comments. */
		
		do_action('tmpl_related_listings'); /* add action for display the related post list. */
		
		/* add action for display the next previous pagination */
		do_action('tmpl_single_post_pagination');
		
		do_action('tmpl_before_comments');

		do_action('after_entry');

		do_action('for_comments');

		/* Add action for display after the post comments. */
		do_action('tmpl_after_comments');

		global $post;

		if (function_exists('supreme_sidebar_after_content'))
			apply_filters('tmpl_after-content', supreme_sidebar_after_content()); /* after-content-sidebar use remove filter to don't display it */
		?>
	  </div>
	  <!-- #content --> 
</div>
<!--end single post type sidebar --> 
<!-- end  content part-->