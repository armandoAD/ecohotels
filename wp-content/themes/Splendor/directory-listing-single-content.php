<?php
/* Page content. for example tabs, aditional custom fileds, sgare buttons etc */

global $post, $custom_fields_as_tabs,$htmlvar_name, $tmpl_flds_varname;

$is_edit = '';
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
          $is_edit = 1;
}
$tmpdata = get_option('templatic_settings');
$googlemap_setting = get_option('city_googlemap_setting');
$special_offer = get_post_meta(get_the_ID(), 'proprty_feature', true);
$video = get_post_meta(get_the_ID(), 'video', true);
$facebook = get_post_meta(get_the_ID(), 'facebook', true);
$google_plus = get_post_meta(get_the_ID(), 'google_plus', true);
$twitter = get_post_meta(get_the_ID(), 'twitter', true);
$listing_address = get_post_meta(get_the_ID(), 'address', true);

if (isset($post)){
          $post_img = bdw_get_images_plugin($post->ID, 'directory-single-image');
          $post_images = @$post_img[0]['file'];
          $title = urlencode($post->post_title);
          $url = urlencode(get_permalink($post->ID));
          $summary = urlencode(htmlspecialchars($post->post_content));
          $image = $post_images;
}

if (function_exists('bdw_get_images_plugin')) {
		global $thumb_img;	
          $post_img = bdw_get_images_plugin(get_the_ID(), 'directory-single-image');
          $postimg_thumbnail = bdw_get_images_plugin(get_the_ID(), 'thumbnail');
          $more_listing_img = bdw_get_images_plugin(get_the_ID(), 'tevolution_thumbnail');
		  $thumb_img = apply_filters('tmpl_thumb_image',$post_img[0]['file']);
          $attachment_id = @$post_img[0]['id'];
          $image_attributes = wp_get_attachment_image_src($attachment_id, 'large');
          $attach_data = get_post($attachment_id);
          $img_title = $attach_data->post_title;
          $img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
}

?>
<div class="splendor_slider">	
		<!-- Image Gallery Div --> 
	<?php 
	
	if ($thumb_img && $is_edit == ''): ?>		
		<div id="directory_detail_img" class="entry-header-image">

			 <?php
			 do_action('directory_before_post_image');
			 if ($is_edit == ""):
					   ?>
					   <div id="slider" class="listing-image flexslider frontend_edit_image">    

							<ul class="slides">
								 <?php
								 if (!empty($post_img)):
								 			/* get all images on gellery */
										   foreach ($post_img as $key => $value):
													 $attachment_id = $value['id'];
													 $attach_data = get_post($attachment_id);
													 $image_attributes = wp_get_attachment_image_src($attachment_id, 'large'); /* returns an array							 */
													 $img_title = $attach_data->post_title;
													 $img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
													 $thumb_img = apply_filters('tmpl_thumb_image',$value['file']);
													 $img_src = apply_filters('tmpl_thumb_image',$image_attributes['0']);
													 ?>
													 <li>
														  <a href="<?php echo $img_src; ?>" title="<?php echo $img_title; ?>" class="listing_img" >		
															   <img src="<?php echo $thumb_img; ?>" alt="<?php echo $img_title; ?>"/>
														  </a>
													 </li>
													 <?php
										   endforeach;
								 endif;
								 ?>
							</ul>

					   </div>


					   <!-- More Image gallery -->
					   <div id="silde_gallery" class="flexslider<?php
					   if (!empty($more_listing_img) && count($more_listing_img) > 4) {
								 echo ' slider_padding_class';
					   }
					   ?>">
							<ul class="more_photos slides">
								 <?php
								 if (!empty($more_listing_img) && count($more_listing_img) > 1):

										   foreach ($more_listing_img as $key => $value):
													 $attachment_id = $value['id'];
													 $attach_data = get_post($attachment_id);
													 $image_attributes = wp_get_attachment_image_src($attachment_id, 'large'); /* returns an array							 */
													 $img_title = $attach_data->post_title;
													 $img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
													 $thumb_img = apply_filters('tmpl_thumb_image',$value['file']);
													 ?>
													 <li>				          	
														  <img src="<?php echo $thumb_img; ?>"alt="<?php echo $img_title; ?>"  />				            
													 </li>

													 <?php
										   endforeach;
								 endif;
								 ?>
							</ul>
					   </div>
					   <!-- Finish More Image gallery -->
					   <?php
			 endif;

			 do_action('directory_after_post_image');
			 ?>
		</div><!-- .entry-header-image -->
		<?php
	endif;

	if ($is_edit == "1"):
		?>
		<!-- Front end edit upload image-->
		<div id="directory_detail_img" class="entry-header-image">
			 <!--editing post images -->
			 <div id="slider" class="listing-image flexslider frontend_edit_image flex-viewport">
				  <ul class="frontend_edit_images_ul">
					   <?php
					   $post_img = bdw_get_images_plugin($post->ID, 'large');
					   if (!empty($post_img)):
								 foreach ($post_img as $key => $value):
										   echo "<li class='image' data-attachment_id='" . basename($value['file']) . "' data-attachment_src='" . $value['file'] . "'><img src='" . $value['file'] . "' alt='" . $img_title . "' /></li>";
										   break;
								 endforeach;
					   endif;
					   ?>
				  </ul>
				  <div id="uploadimage" class="upload button secondary_btn clearfix">
					   <span><?php _e("Upload Images", 'templatic'); ?></span>					
				  </div>
			 </div>

			 <div id="frontend_images_gallery_container" class="clearfix flex-viewport">
				  <ul class="frontend_images_gallery more_photos slides">
					   <?php
					   if (!empty($post_img)):
								 foreach ($post_img as $key => $value):
										   echo "<li class='image' data-attachment_id='" . basename($value['file']) . "' data-attachment_src='" . $value['file'] . "'><img src='" . $value['file'] . "' alt='" . $img_title . "' /><span>
				<a class='delete' title='Delete image' href='#' id='" . $value['id'] . "' ><i class='fa fa-times-circle redcross'></i>";
										   echo "</a></span></li>";
								 endforeach;
					   endif;
					   ?>
				  </ul>
				  <input type="hidden" id="fontend_image_gallery" name="fontend_image_gallery" value="<?php echo esc_attr(substr(@$image_gallery, 0, -1)); ?>" />		
			 </div>
			 <span id="forntend_status" class="message_error2 clearfix"></span>
			 <!--finish editing post images -->
		</div>
	<?php endif; ?>

	<!-- Finish Image Gallery Div -->
</div>
<?php

do_action('dir_before_tabs');
$descclass = '';
/* show only title if only one tab detail is available */
if($post->post_content != '' && $tmpdata['direction_map'] == 'No' && ( empty($special_offer) || ( !empty($special_offer) && !$tmpl_flds_varname['proprty_feature'] ) ) && empty($video) && count($custom_fields_as_tabs) == 0 && !$tmpl_flds_varname['post_coupons']){
	echo '<div><h3 class="widget-title">'.__('Overview', 'templatic').'</h3></div>';
	$descclass = 'onlydesc';
}
else{ ?>

<!-- tabs start -->
<ul class="tabs" data-tab role="tablist">
  <?php
			
		 do_action('dir_start_tabs');
		
		/* show overview tab */
		 if ($post->post_content != '' || count($post_img) > 0 || count($custom_fields_as_tabs) > 0 || (isset($_REQUEST['action']) && $_GET['action'] == 'edit')): ?>
			<li class="tab-title active" role="presentational">
				<a href="#listing_description" role="tab" tabindex="0" aria-selected="false" controls="listing_description">
					<?php _e('Overview', 'templatic'); ?>
				</a>
			</li>
		<?php 
		
		endif;

		/* show map tab */	
		 if (@$tmpdata['direction_map'] == 'yes' && $listing_address):
				   ?>
  <li class="tab-title" role="presentational"><a href="#listing_map" role="tab" tabindex="1" aria-selected="false" controls="listing_map">
    <?php _e('Map', 'templatic'); ?>
    </a></li>
  <?php endif;

		/* show Special offers tab */	
		 if (($special_offer != "" && $tmpl_flds_varname['proprty_feature']) || ($is_edit == 1 && $tmpl_flds_varname['proprty_feature'])):  ?>
  <li class="tab-title" role="presentational"><a href="#special_offer" role="tab" tabindex="2" aria-selected="false" controls="special_offer"><?php echo $tmpl_flds_varname['proprty_feature']['label']; ?></a></li>
  <?php  endif;

		/* show video tab */
		 if ($video != "" && $tmpl_flds_varname['video'] || ($is_edit == 1 && $tmpl_flds_varname['video'])):  ?>
  <li class="tab-title" role="presentational"><a href="#listing_video" role="tab" tabindex="3" aria-selected="false" controls="listing_video"><?php echo $tmpl_flds_varname['video']['label']; ?></a></li>
  <?php endif;

		 /* To display the events "Tab" available on that place */
		 do_action('tmpl_show_events_tab');

		 global $post, $events_list;

		 $event_for_listing = get_post_meta($post->ID, 'event_for_listing', true);
		 if (!empty($event_for_listing)) {
				   $event_for_list = explode(',', $event_for_listing);

				   if (function_exists('tmpl_get_events_list')) {
							 $events_list = tmpl_get_events_list($event_for_list);

							 if (!empty($events_list)) {
									   ?>
  <li class="tab-title" role="presentational"><a href="#listing_event" role="tab" tabindex="4" aria-selected="false" controls="listing_event">
    <?php _e('Events', 'templatic'); ?>
    </a></li>
  <?php
								  }
						}
			  }
			  do_action('dir_end_tabs');  ?>
</ul>
<?php 
}
do_action('dir_after_tabs'); ?>
<div class="tabs-content <?php echo $descclass;?>"> 
  
  <!--Overview Section Start -->
  <section role="tabpanel" aria-hidden="false" class="content active" id="listing_description">
  	<h2 class="print-heading"><?php _e('Overview', 'templatic'); ?></h2>
    <div class="entry-content frontend-entry-content <?php if ($is_edit == 1): ?>editblock listing_content <?php
          endif;
          if (!$thumb_img):
                    ?>content_listing<?php else: ?>listing_content <?php endif; ?>">
      <?php
               do_action('directory_before_post_content');
               the_content();
               do_action('directory_after_post_content');
               ?>
    </div>
  </section>
  <!--Overview Section End -->
  
  <?php if ($tmpdata['direction_map'] == 'yes' && $listing_address): ?>
  <!--Map Section Start -->
  <section role="tabpanel" aria-hidden="false" class="content" id="listing_map">
  	<h2 class="print-heading"><?php _e('Map','templatic');?></h2>
    <?php do_action('directory_single_page_map') ?>
  </section>
  <!--Map Section End -->
  
  <?php
     endif;

     if (($special_offer != "" && $tmpl_flds_varname['proprty_feature'] ) || ($is_edit == 1 && $tmpl_flds_varname['proprty_feature'])):
               ?>
  <!--Special Offer Start -->
  <section role="tabpanel" aria-hidden="false" class="content" id="special_offer">
  	<h2 class="print-heading"><?php _e('Special Offer','templatic');?></h2>
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

     if (($video != "" && $tmpl_flds_varname['video'] ) || ($is_edit == 1 && $tmpl_flds_varname['video'])):
               ?>
  <!--Video Code Start -->
  <section role="tabpanel" aria-hidden="false" class="content" id="listing_video">
  	<h2 class="print-heading"><?php _e('Video','templatic');?></h2>
    <?php
                    if ($is_edit == 1):
                              do_action('oembed_video_description');
                              ?>
    <span id="frontend_edit_video" class="frontend_oembed_video button" >
    <?php _e('Edit Video', 'templatic'); ?>
    </span>
    <input type="hidden" class="frontend_video" name="frontend_edit_video" value='<?php echo $video; ?>' />
    <?php endif; ?>
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
<?php

do_action('tmpl_splendor_after_content');

/* Display heading type with custom fields */
global $htmlvar_name, $heading_title;
$j = 0;
/* array of fields which we are not going to show on detail page */
$not_include = apply_filters('tmpl_exclude_custom_fields', array('category', 'post_title', 'post_content', 'post_excerpt', 'post_images', 'post_city_id', 'listing_timing', 'address', 'listing_logo', 'post_coupons', 'video', 'post_tags', 'map_view', 'proprty_feature', 'phone', 'email', 'website', 'twitter', 'facebook', 'google_plus', 'contact_info','listing_banner'));
/* get detail page custom fields selected as show on detail page yes */
do_action('tmpl_display_before_listing_custom_fields');
tmpl_fields_detail_informations($not_include, __('Other Details', 'templatic'));
do_action('tmpl_display_after_listing_custom_fields');
?>
<!--Directory Social Media Coding Start -->
<?php

/* click on map tab if overview tab was not there */
if ($post->post_content == '' || count($post_img) <= 0 || count($custom_fields_as_tabs) <= 0 || !isset($_REQUEST['action'])) { ?>
	<script>
			jQuery(document).ready(function () {
				 jQuery('.tabs li').first().find("a").trigger('click');
			});
	</script>
<?php }
/* EOF */
?>
