<?php
/* Custom function for the theme */


/* placeholder in instant search widget */
add_filter('tmpl_search_location_text','tmpl_splendor_location_text');
if(!function_exists('tmpl_splendor_location_text')){
	function tmpl_splendor_location_text(){
		return __('Search by locality or landmark','templatic');
	}
}

add_action('wp_footer','tmpl_splendor_add_scripts');
function tmpl_splendor_add_scripts(){
	?>
	<script type="application/javascript">
		jQuery(document).ready(function(){
			if(jQuery('.top-header-nav #menu-primary').length > 0){
				jQuery('.header-wrap #branding').addClass('center-logo');
			}

			/* submit for instant search */	
			jQuery('.header-search-icon').click(function(){
				jQuery(this).parent().submit();
			});
			
			
			/* suggestion width for search by miles range */
			jQuery('.sidebar #searchform .range_address').focus(function(){
				var result_width = jQuery(this).outerWidth();
				console.log(result_width);
				jQuery('.ui-autocomplete').attr('style','width:'+result_width+'px !important; max-width:'+result_width+'px !important');
			});
			jQuery('.sidebar #searchform .range_address').bind('keyup',function(e){
				var result_width = jQuery(this).outerWidth();
				console.log(result_width);
				jQuery('.ui-autocomplete').attr('style','width:'+result_width+'px !important; max-width:'+result_width+'px !important');
			});

			
			/* for auto complete result width in instant search */	
			jQuery('.home_page_banner #searchform .searchpost').focus(function(){
				var result_width = jQuery(this).outerWidth();
				console.log(result_width);
				jQuery('.ui-autocomplete').attr('style','width:'+result_width+'px !important; max-width:'+result_width+'px !important');
			});
			jQuery('.home_page_banner #searchform .searchpost').bind('keyup',function(){
				var result_width = jQuery(this).outerWidth();
				console.log(result_width);
				jQuery('.ui-autocomplete').attr('style','width:'+result_width+'px !important; max-width:'+result_width+'px !important');
			});

			jQuery('.header_container #searchform .searchpost').focus(function(){
				var result_width = jQuery(this).outerWidth();
				console.log(result_width);
				jQuery('.ui-autocomplete').attr('style','width:'+result_width+'px !important; max-width:'+result_width+'px !important');
			});
			jQuery('.header_container #searchform .searchpost').parent().bind('keyup',function(){
				var result_width = jQuery(this).outerWidth();
				console.log(result_width);
				jQuery('.ui-autocomplete').attr('style','width:'+result_width+'px !important; max-width:'+result_width+'px !important'); 
			});
			
			jQuery('.header_container #searchform .searchpost').focusout(function(e){ 
				var result_width = jQuery(this).outerWidth();
				console.log(result_width);
				jQuery('.ui-autocomplete').hide();
				
			});
			
			jQuery('.home_page_banner #searchform .searchpost').focusout(function(e){
				var result_width = jQuery(this).outerWidth();
				console.log(result_width);
				jQuery('.ui-autocomplete').hide();
				
			});

			jQuery('#searchform .sgo').hover(function(){
				jQuery(this).parent().find('#search_instant').addClass('sub-hover');
			});

			jQuery('#searchform .sgo').mouseout(function(){
				jQuery(this).parent().find('.sub-hover').removeClass('sub-hover');
			});
			
		});
	</script>
	<?php 
}

/* add more element for testomonials widget */
add_action('admin_head','tmpl_splendor_add_script_addnew_');
if(!function_exists('tmpl_splendor_add_script_addnew_')){
	function tmpl_splendor_add_script_addnew_(){
		global $author,$quotetext;
		?>
		<script type="application/javascript">
			var counter1 = 2;
			function add_tfields(name,ilname,auth_email)
			{
				var newTextBoxDiv = jQuery(document.createElement('div')).attr("class", 'TextDiv' + counter1);
				newTextBoxDiv.html('<p><label>Quote text '+ counter1+': </label>'+'<textarea  class="widefat" name="'+ilname+'[]" id="textbox' + counter1 + '" value="" ></textarea></p>');
				newTextBoxDiv.append('<p><label>Author name '+ counter1+': </label>'+'<input type="text" class="widefat" name="'+name+'[]" id="textbox' + counter1 + '" value="" ></p>');
				newTextBoxDiv.append('<p><label>Author name '+ counter1+': </label>'+'<input type="text" class="widefat" name="'+auth_email+'[]" id="textbox' + counter1 + '" value="" ></p>');
				newTextBoxDiv.appendTo(".tGroup");
				counter1++;
			}
			function remove_tfields()
			{
				if(counter1-1==1)
				{
					alert("<?php echo __('One textbox is required.','templatic'); ?>");
					return false;
				}
				counter1--;
				jQuery(".TextDiv" + counter1).remove();
			}
		</script>
<?php
	}
}

/* add more link for testimonials widget 
* there are 4 parameters 
* 1. Widget instence, All the value goes in this as an array
* 2. $text_quotetext: variable for Quote text in widget form
* 3. $text_author: Author name varable
* 4. $auth_email: Author email for gravtar
*/
add_action('add_testimonial_submit','tmpl_splendor_add_more_testimonial',10,4);
if(!function_exists('tmpl_splendor_add_more_testimonial')){
	function tmpl_splendor_add_more_testimonial($instance,$text_quotetext,$text_author,$auth_email){
		?>
		<a	href="javascript:void(0);" id="addtButton" class="addButton" type="button" onclick="add_tfields('<?php echo $text_author; ?>','<?php echo $text_quotetext; ?>','<?php echo $auth_email; ?>');">+ <?php _e('Add More','templatic-admin');?></a>
	<?php
	}
}

/* show testimonials content */
add_action('tmpl_testimonial_quote_text','tmpl_splendor_testimonial_quote_text',11,2);
if(!function_exists('tmpl_splendor_testimonial_quote_text')){
	function tmpl_splendor_testimonial_quote_text($c,$instance){
		$quote_text = empty($instance['quotetext']) ? '' : apply_filters('widget_quotetext', $instance['quotetext']);
		$author_text = empty($instance['author']) ? '' : apply_filters('widget_author', $instance['author']);
		$auth_email = empty($instance['auth_email']) ? '' : apply_filters('widget_auth_email', $instance['auth_email']);
		
		/* tranlate the values when wpml is activated */
		if(function_exists('icl_register_string'))
		{
			/* translation for quote text */
			icl_register_string('templatic','quote_text'.$c,$quote_text[$c]);
			$quote_text[$c] = icl_t('templatic','quote_text'.$c,$quote_text[$c]);
			
			/* translation for author text */
			icl_register_string('templatic','author_text'.$c,$author_text[$c]);
			$author_text[$c] = icl_t('templatic','author_text'.$c,$author_text[$c]);
			
			/* translation for autho email */
			icl_register_string('templatic','author_email'.$c,$author_email[$c]);
			$author_email[$c] = icl_t('templatic','author_email'.$c,$author_email[$c]);
		}?>
		<!-- Quote text --> 
		<div class="testi_content">
			<p><?php echo  $quote_text[$c];?></p>
		</div>
		
		<!-- Author gravatar and name -->
		<div class="testi_info">
			<?php echo get_avatar( $auth_email[$c],70 );
			if($author_text[$c]){?>
				<cite> - <?php echo $author_text[$c]; ?> </cite>
			<?php } ?>
		</div>
		<?php
		
	}
}

/* add city default image field when location manager is active */
add_action('tmpl_extra_city_info_option','tmpl_splendor_city_image');
function tmpl_splendor_city_image($cityinfo){
	if(is_plugin_active('Tevolution-LocationManager/location-manager.php')){
	?>
		<tr>
			<th><?php echo __('City Image','templatic-admin');?></th>
			<td>                          	
				<input id="city_default_image" type="text" size="60"  name="city_default_image" value="<?php echo ( @$cityinfo->city_default_image)?$cityinfo->city_default_image:'';?>" />	<a data-id="city_default_image" id="City Default Image" type="submit" class="upload_file_button button"><?php  echo __('Browse','templatic-admin');?></a>   
				<p class="description"><?php echo __('Upload image to display it as a Default image for this city. It will show in Top City widget.','templatic-admin');?></p>                              
			</td>
		</tr>
		<?php
	}
}

/* add column for default city information */
add_action('admin_init','tmpl_splendor_admin_action');
function tmpl_splendor_admin_action(){
	global $wpdb;
	if(is_plugin_active('Tevolution-LocationManager/location-manager.php')){
		/* get column name if exists or not */
		$city_default_image = $wpdb->get_var("SHOW COLUMNS FROM {$wpdb->prefix}multicity LIKE 'city_default_image'");
		if('city_default_image' != $city_default_image){
			$wpdb->query("ALTER TABLE {$wpdb->prefix}multicity ADD `city_default_image` TEXT NOT NULL AFTER `is_zoom_cat`");
		}
	}
}

/* save default city image */
add_filter('tmpl_extra_city_data','tmpl_splendor_save_default_cityimage');
function tmpl_splendor_save_default_cityimage($citydata){
	if(isset($_POST['save_city']) || isset($_POST['edit_city'])){
		$citydata['city_default_image'] = sanitize_text_field($_POST['city_default_image']);
		return $citydata;
	}
}

/* change close button for info windoe on map */
add_filter('tmpl_infobubble_close_btn','tmpl_splendor_infobubble_close_btn');
function tmpl_splendor_infobubble_close_btn($closebtn){
	$closebtn = get_stylesheet_directory_uri()."/images/close.png";
	return $closebtn;
}

/* show add to favourite button */
add_action('directory_display_custom_fields','tmpl_splendor_add_to_fav_button',12);
if(!function_exists('tmpl_splendor_add_to_fav_button')){
	function tmpl_splendor_add_to_fav_button(){
		
		global $current_user,$post;
		/* don't show this in classified's detail page */
		$current_posttype = get_post_type();
		$no_send_btnarr = array('classified','jobs');
		if(!in_array($current_posttype,$no_send_btnarr)){
			$add_to_favorite = __('Add to favorites','templatic');
			$added = __('Added','templatic');
			if(function_exists('icl_register_string')){
				icl_register_string('templatic','directory'.$add_to_favorite,$add_to_favorite);
				$add_to_favorite = icl_t('templatic','directory'.$add_to_favorite,$add_to_favorite);
				icl_register_string('templatic','directory'.$added,$added);
				$added = icl_t('templatic','directory'.$added,$added);
			}
			$post_id = $post->ID;
			
			$user_meta_data = get_user_meta($current_user->ID,'user_favourite_post',true);
			if($post->post_type !='post' && $_REQUEST['ptype'] != 'preview'){
				if($user_meta_data && in_array($post_id,$user_meta_data)){?>
					<p id="tmplfavorite_<?php echo $post_id;?>" class="fav_<?php echo $post_id;?> fav">
						<?php do_action('tmpl_before_rfav'); ?>
						<a href="javascript:void(0);" class="removefromfav" data-id='<?php echo $post_id; ?>'  onclick="javascript:addToFavourite('<?php echo $post_id;?>','remove');">
							<i class="fa fa-heart"></i><?php echo $added;?>
						</a>
						<?php do_action('tmpl_after_rfav'); ?>
					</p>    
					<?php
				}else{
					if($current_user->ID ==''){
						$data_reveal_id ='data-reveal-id="tmpl_reg_login_container"';
					}else{
						$data_reveal_id ='';
					}
				?>
				<p id="tmplfavorite_<?php echo $post_id;?>" class="fav_<?php echo $post_id;?> fav">
					<?php do_action('tmpl_before_addfav'); ?>
					<a href="javascript:void(0);" <?php echo $data_reveal_id; ?> class="addtofav" data-id='<?php echo $post_id; ?>'   onclick="javascript:addToFavourite('<?php echo $post_id;?>','add');"><i class="fa fa-heart-o"></i><?php echo $add_to_favorite;?></a>
					<?php do_action('tmpl_before_addfav'); ?>
				</p>
				<?php } 
			}
		}
	}
}

/* show add to favourite button */
add_action('directory_display_custom_fields','tmpl_splendor_send_friend_enquiry_button',13);
if(!function_exists('tmpl_splendor_send_friend_enquiry_button')){
	function tmpl_splendor_send_friend_enquiry_button(){
		/* don't show this in classified's detail page */
		$current_posttype = get_post_type();
		$no_send_btnarr = array('classified','jobs');
		if(!in_array($current_posttype,$no_send_btnarr)){	
			$tmpdata = get_option('templatic_settings');
			
			if(isset($tmpdata['send_to_frnd']) || isset($tmpdata['send_inquiry'])){
				echo '<ul class="send_btns">';
			}
			if(isset($tmpdata['send_to_frnd'])&& $tmpdata['send_to_frnd']=='send_to_frnd' && function_exists('send_email_to_friend')){
				/*
					We add filter here so if you are creating a child theme and don't want to show here, then just remove from child theme.
					e.g. add_filter('tmpl_sent_to_frd_link','');
				*/
				do_action('tmpl_before_send_tofrd');
				$send_to_frnd=	apply_filters('tmpl_sent_to_frd_link','<a class="small_btn tmpl_mail_friend" data-reveal-id="tmpl_send_to_frd" href="javascript:void(0);" id="send_friend_id"  title="'.__('Mail to a friend','templatic').'" ><i class="fa fa-envelope-o"></i>'. __('Mail to friend','templatic').'</a>');				
				
				add_action('wp_footer','send_email_to_friend',10);
				echo '<li class="send_frnd">'.$send_to_frnd.'</li>';
			}
					
			/* sent inquiry link*/
			
			if(isset($tmpdata['send_inquiry'])&& $tmpdata['send_inquiry']=='send_inquiry' && function_exists('send_inquiry')){		
				/*
					We add filter here so if you are creating a child theme and don't want to show here, then just remove from child theme.
					e.g. add_filter('tmpl_send_inquiry_link','');
				*/
				do_action('tmpl_before_send_inquiry');
				$send_inquiry=	apply_filters('tmpl_send_inquiry_link','<a class="small_btn tmpl_mail_friend" data-reveal-id="tmpl_send_inquiry"  href="javascript:void(0)" title="'.__('Send Inquiry','templatic').'" id="send_inquiry_id" ><i class="fa fa-paper-plane-o"></i>'.__('Send inquiry','templatic').'</a>');
				add_action('wp_footer','send_inquiry');		
				echo '<li class="send_inquiry">'.$send_inquiry.'</li>';
			}
			
			if(isset($tmpdata['send_to_frnd']) || isset($tmpdata['send_inquiry'])){
				echo '</ul>';
			}
		}
	}
}

/* show add to favourite button */
add_action('directory_before_custom_fields','tmpl_splendor_claiming_button');
if(!function_exists('tmpl_splendor_claiming_button')){
	function tmpl_splendor_claiming_button(){
		global $current_user,$post;
		$tmpdata = get_option('templatic_settings');	
		$link='';
		
		if(!empty($tmpdata['claim_post_type_value'])&& @in_array($post->post_type,$tmpdata['claim_post_type_value']) && function_exists('tmpl_claim_ownership') && @$post->post_author!=@$current_user->ID){
			/*
				We add filter here so if you are creating a child theme and don't want to show here, then just remove from theme.
				e.g. add_filter('tmpl_allow_claimlink_inlist',0);
			*/
			$allow_claim = apply_filters('tmpl_allow_claimlink_inlist',1);
			do_action('tmpl_before_claim');
			if($allow_claim && get_post_meta($post->ID,'is_verified',true) !=1){
				echo '<p class="claim_ownership">';
				echo do_shortcode('[claim_ownership]');
				echo '</p>';
			}
		}
	}
}	

/* changed text for "Already claimed" */
add_filter('tmpl_already_claimed_text','tmpl_splendor_claimed_text');
if(!function_exists('tmpl_splendor_claimed_text')){
	function tmpl_splendor_claimed_text($alreadyclaimed){
		$alreadyclaimed = _e('Already Owned.','templatic');
		return $alreadyclaimed;
	}
}

/* chnaged text for "Claim listingg" */
add_filter('tmpl_claiming_text','tmpl_splendor_claiming_text');
if(!function_exists('tmpl_splendor_claiming_text')){
	function tmpl_splendor_claiming_text($claimingtext){
		$claimingtext = '<span class="fa-stack has-tip tip-right" data-options="disable_for_touch:true" aria-haspopup="true" data-tooltip="" data-selector="tooltip-idk084f90" title=""><i class="fa fa-certificate fa-stack-2x"></i><i class="fa fa-check fa-stack-1x"></i></span>'.__('Own this business?','templatic');
		return $claimingtext;
	}
}

/* chnaged text for "Listings Owner" */
add_filter('tmpl_owner_text','tmpl_splendor_tmpl_owner_text');
if(!function_exists('tmpl_splendor_tmpl_owner_text')){
	function tmpl_splendor_tmpl_owner_text($tmpl_owner_text){
		$tmpl_owner_text = _e('Hotel Owner','templatic');
		return $tmpl_owner_text;
	}
}

/* changed gravtar size for authors widget */
add_filter('tev_widget_photo_size','tmpl_splendor_authors_widget_photo');
if(!function_exists('tmpl_splendor_authors_widget_photo')){
	function tmpl_splendor_authors_widget_photo(){
		return 90;
	}
}
/* auto extract plugins  */
if(!function_exists('tmpl_splendor_zip_copy')){	 
	function tmpl_splendor_zip_copy( $source, $target, $plug_path, $add_msg=0){
		if(!@copy($source,$target))
		{	add_action('admin_notices','dir_one_click_install');
			$errors= error_get_last();
			echo "<span style='color:red;'>".__('COPY ERROR:','templatic-admin')."</span> ".$errors['type'];
			echo "<br />\n".$errors['message'];
		} else {
			$file = explode('.',$target);
	
			if(file_exists($target)){ 
				$message ="<span style='color:green;'>".__('File copied from remote!','templatic-admin')."</span><br/>";
				
				$zip = new ZipArchive();
				$x = $zip->open($target);
				
				if ($x === true && file_exists($target)) { 
					$zip->extractTo( tmpl_splendor_plugin_directory()); // change this to the correct site path
					$zip->close();
	
					
					unlink($target);
					$message = __("Your .zip file was uploaded and unpacked.",'templatic-admin')."<br/>";
				}else{
					
				}
			}
			if($add_msg == 1 && strstr($_SERVER['REQUEST_URI'],'themes.php')){ 
				update_option('tmpl_homequest_on_go',1);
				
				$plug_path2 = "Tevolution-Directory/directory.php";  // change this to the correct site path
				$plug_path3 = "Tevolution-LocationManager/location-manager.php";  // change this to the correct site path
				$plug_path1 = "Tevolution/templatic.php";  // change this to the correct site path
				
				/* activate the plugins */
				activate_plugin($plug_path1);
				activate_plugin($plug_path2);
				activate_plugin($plug_path3);
				
				$location_post_type[]='post,category,post_tag';
				$location_post_type[]='listing,listingcategory,listingtags';
				$post_types=update_option('location_post_type',$location_post_type);
			}
		}
	}
}

/*
	To change the comment field title.
*/
add_filter( 'comment_form_defaults', 'tmpl_splendor_comment_form_comment_title',100 );
if(!function_exists('tmpl_splendor_comment_form_comment_title')){
	function tmpl_splendor_comment_form_comment_title( $arg ) {
		
		$form_filed = '';
		
		/* form fields for comments */
		
		$form_filed .= '<p class="comment-form-comment"><label for="comment">'.__('Message','templatic').'</label> <textarea placeholder="'.__('This is the comment area from where you can give reivew and ratings.','templatic').'" aria-required="true" rows="8" cols="45" name="comment" id="comment"></textarea></p>';
		
		if(!is_user_logged_in()){
		
			$form_filed .= '<div class="comment_column2"><p class="form-author req"><label for="author">'.__('Name','templatic').' <span class="required">*</span> </label> <input type="text" class="text-input" name="author" id="author" value="" size="40"></p>';
			
			$form_filed .= '<p class="form-email req"><label for="email">'.__('Email','templatic').' <span class="required">*</span> </label> <input type="text" class="text-input" name="email" id="email" value="" size="40"></p>';

			$form_filed .= '<p class="form-email req"><label for="website">'.__('Website','templatic').'</label> <input type="text" class="text-input" name="website" id="website" value="" size="40"></p></div>';
		
		}
		
		$arg['comment_field'] = $form_filed;
		
		if(get_post_type() != 'post'){
			
			$arg['title_reply'] = __('Write a review','templatic');
		
			$arg['label_submit'] = __('Publish Review','templatic');
		
		}
		
		return $arg;
	}
}

/* remove website filed from comments form */
add_filter('comment_form_default_fields','tmpl_splendor_disable_comment_url');
if(!function_exists('tmpl_splendor_disable_comment_url')){
	function tmpl_splendor_disable_comment_url($fields) { 
		unset($fields['url']);
		return $fields;
	}
}

/* no image for populer post according to theme */
add_filter('popular_post_thumb_image','tmpl_splendor_popular_post_thumb_image',10);
if(!function_exists('tmpl_splendor_popular_post_thumb_image')){
	function tmpl_splendor_popular_post_thumb_image(){
		return get_the_image(array('echo' => false, 'size'=> 'popular_post-thumbnail','default_image'=> "http://placehold.it/90x60"));	
	}
}

/* no image for nearest post according to theme */
add_filter('nearest_post_thumb_image','tmpl_splendor_nearest_post_thumb_image',10);
if(!function_exists('tmpl_splendor_nearest_post_thumb_image')){
	function tmpl_splendor_nearest_post_thumb_image(){
		return 'http://placehold.it/125x85';	
	}
}


/* add rattings above comments form */
add_action( 'comment_form_logged_in_after', 'tmpl_splendor_ratings_in_comments',100 );
add_action( 'comment_form_after_fields', 'tmpl_splendor_ratings_in_comments',100 );
if(!function_exists('tmpl_splendor_ratings_in_comments')){
	function tmpl_splendor_ratings_in_comments(){
		$tmpdata = get_option('templatic_settings');
		if($tmpdata['templatin_rating']=='yes' && get_post_type() != 'post' && TEMPL_MONETIZE_FOLDER_PATH):?>
		<div class="templatic_rating">
			<p class="commpadd"><span class="comments_rating"> <?php require_once (TEMPL_MONETIZE_FOLDER_PATH . 'templatic-ratings/get_rating.php');?> </span> </p>
		</div>    
		<?php endif;
	}
}

/* no image according to theme */
add_filter('supreme_noimage-url','tmpl_splendor_noimage_url');
if(!function_exists('tmpl_splendor_noimage_url')){
	function tmpl_splendor_noimage_url($noimage){
		$noimage = get_stylesheet_directory_uri().'/images/noimage-325x217.jpg';
		return $noimage;
	}
}

/* slider options */
add_filter('tmpl_detail_slider_options','tmpl_splendor_slider_option');
if(!function_exists('tmpl_splendor_slider_option')){
	function tmpl_splendor_slider_option($arr){
		$arr['itemWidth'] = 125; /* set width to 90 px */
		if(get_post_type() != 'events'){
			$arr['controlNav'] = 'true';
			$arr['directionNav'] = 'true';
		}
		return $arr;
	}
}

/* apply header colors and header background which choosed in city settings in manage location */
remove_action('before_desk_menu_primary','tmpl_locations_color_settings',100);
add_action('before_desk_menu_primary','tmpl_splendor_header_color_settings');
if(!function_exists('tmpl_splendor_header_color_settings')){
	function tmpl_splendor_header_color_settings(){
		global $current_cityinfo,$wpdb,$multicity_table;
		if( ($current_cityinfo['header_color'] && $current_cityinfo['header_color'] !='#') || $current_cityinfo['header_image']):?>
			<style type="text/css">
				div#header, header#header{ <?php if($current_cityinfo['header_color']):?> background-color:<?php echo $current_cityinfo['header_color'];?>; <?php endif;?>}
			</style>
		<?php endif;
	}
}

/* show hotel info in sidebar on detail page */
add_action('tmpl_inside_sidebar','tmpl_splendor_responsive_hotelinfo');
/* show hotel info in mobile devices */
add_action('tmpl_splendor_after_title_section','tmpl_splendor_responsive_hotelinfo');
if(!function_exists('tmpl_splendor_responsive_hotelinfo')){
	function tmpl_splendor_responsive_hotelinfo(){?>
		<!-- hotel-info -->
			<div  class="hotel-info"><?php
			
				global $htmlvar_name,$tmpl_flds_varname,$post;

				$is_edit='';
				if(isset($_REQUEST['action']) && $_REQUEST['action']=='edit'){
					$is_edit=1;
				}
				/* set value for preview page */
				if (isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'preview') {
					$address = sanitize_text_field($_REQUEST['address']);
					$website = sanitize_text_field($_REQUEST['website']);
					$phone = sanitize_text_field($_REQUEST['phone']);
					$listing_timing = sanitize_text_field($_REQUEST['listing_timing']);
					$email = sanitize_email($_REQUEST['email']);
					$facebook = sanitize_text_field($_REQUEST['facebook']);
					$google_plus = sanitize_text_field($_REQUEST['google_plus']);
					$twitter = sanitize_text_field($_REQUEST['twitter']);
				}else{
					$address = get_post_meta(get_the_ID(), 'address', true);
					$website = get_post_meta(get_the_ID(), 'website', true);
					$phone = get_post_meta(get_the_ID(), 'phone', true);
					$listing_timing = get_post_meta(get_the_ID(), 'listing_timing', true);
					$email = get_post_meta(get_the_ID(), 'email', true);
					$facebook = get_post_meta(get_the_ID(),'facebook',true);
					$google_plus = get_post_meta(get_the_ID(),'google_plus',true);
					$twitter = get_post_meta(get_the_ID(),'twitter',true);
				}
				
				
				$facebook_show = apply_filters('tmpl_fb_share_link',1);
				$google_plus_show = apply_filters('tmpl_google_plus_share_link',1);
				$twitter_show=apply_filters('tmpl_twitter_share_link',1);
				
				do_action('directory_before_custom_fields');
				?>
				<ul>
				<?php
				/* show address */
				if (($address != "" && $tmpl_flds_varname['address']) || $is_edit==1):?>
					<li class="entry_address <?php echo $tmpl_flds_varname['address']['style_class']; ?>">
						<i class="fa fa-map-marker"></i>
						<div class="field-wrap">
							
								<label><?php echo $tmpl_flds_varname['address']['label']; ?>: </label>
								<span id="frontend_address" class="listing_custom frontend_address" <?php if ($is_edit == 1): ?>contenteditable="true"<?php endif; ?>><?php echo $address; ?></span>
							
						</div>	
					</li>
				<?php
				do_action('directory_after_address');
				endif;
				
				/* show website */
				if ($website != "" && $tmpl_flds_varname['website'] || ($is_edit == 1)):
					if (!strstr($website, 'http'))
						$website = 'http://' . $website; ?>
						<li class="website <?php echo $tmpl_flds_varname['website']['style_class']; ?>">
							
							<i class="fa fa-globe"></i>
							<a class="field-wrap" target="_blank" id="website" <?php if ($is_edit == 1): ?>contenteditable="true" <?php endif; ?> class="frontend_website <?php if ($is_edit == 1): ?>frontend_link<?php endif; ?>" href="<?php echo $website; ?>" >
								<label><?php echo $tmpl_flds_varname['website']['label']; ?>: </label>	
								<span><?php echo $website; ?></span>
							</a>
						</li>
					  <?php
				endif;
				
				/* show phone */
				if ($phone != "" && $tmpl_flds_varname['phone'] || ($is_edit == 1 && $tmpl_flds_varname['phone'])): ?>
					<li class="phone <?php echo $tmpl_flds_varname['phone']['style_class']; ?>">
						<i class="fa fa-phone"></i>
						<div class="field-wrap">
							<label><?php echo $tmpl_flds_varname['phone']['label']; ?>: </label>
							<span class="entry-phone frontend_phone listing_custom" <?php if ($is_edit == 1): ?>contenteditable="true" <?php endif; ?>><?php echo $phone; ?></span>
						</div>
					</li>
				<?php
				endif;
				
				/* show email */
				if (@$email != "" && @$tmpl_flds_varname['email'] || ($is_edit == 1 && @$tmpl_flds_varname['email'])): ?>
					<li class="email  <?php echo $tmpl_flds_varname['email']['style_class']; ?>">
						<i class="fa fa-envelope-o"></i>
						<div class="field-wrap">
							<label><?php echo $tmpl_flds_varname['email']['label']; ?>: </label>
							<span class="entry-email frontend_email listing_custom" <?php if ($is_edit == 1): ?>contenteditable="true"<?php endif; ?>><?php echo antispambot($email); ?></span>
						</div>
					</li>
				<?php
				endif;
				
				/* show time */
				if ($listing_timing != "" && $tmpl_flds_varname['listing_timing'] || ($is_edit == 1 && $tmpl_flds_varname['listing_timing'])): ?>
					<li class="time <?php echo $tmpl_flds_varname['listing_timing']['style_class']; ?>">
						<i class="fa fa-clock-o"></i>
						<div class="field-wrap">
							<label><?php echo $tmpl_flds_varname['listing_timing']['label']; ?>: </label>
							<span class="entry-listing_timing frontend_listing_timing listing_custom" <?php if ($is_edit == 1): ?>contenteditable="true" <?php endif; ?>><?php echo $listing_timing; ?></span>
						</div>
					</li>
				<?php
				endif;
				echo '</ul>';
				do_action('directory_display_custom_fields');
				do_action('directory_display_after_custom_fields_default'); 
				if(!empty($facebook) || !empty($google_plus) || !empty($twitter) || $is_edit==1 ){
					echo '<div class="share_link">';
						do_action('tmpl_before_social_share_link');
						echo '<label>Share</label>';
						echo '<ul class="socialbtn">';
						if($facebook!="" && $facebook_show && ((@$htmlvar_name['contact_info']['facebook'] || $tmpl_flds_varname['facebook']) || ($is_edit==1 && (@$htmlvar_name['contact_info']['facebook']) || $tmpl_flds_varname['facebook']))):
							if(!empty($facebook) && !strstr($facebook,'http'))
								$facebook = 'http://'.$facebook;
							?>
								<li><a id="facebook" class="frontend_facebook <?php if($is_edit==1):?>frontend_link <?php endif;?>" href="<?php echo $facebook;?>"><i class="fa fa-facebook"></i></a></li>
						<?php endif;
					 
						if($twitter!="" && (@$htmlvar_name['contact_info']['twitter'] || $tmpl_flds_varname['twitter']) && $twitter_show ==1 || ($is_edit==1 && (@$htmlvar_name['contact_info']['twitter'] || $tmpl_flds_varname['twitter']))):
							if(!empty($twitter) && !strstr($twitter,'http'))
								$twitter = 'http://'.$twitter;
							?>
							<li><a id="twitter" class="frontend_twitter <?php if($is_edit==1):?>frontend_link <?php endif;?>" href="<?php echo $twitter;?>"><i class="fa fa-twitter"></i></a></li>
						<?php endif;
						
						if($google_plus!="" && (@$htmlvar_name['contact_info']['google_plus'] || $tmpl_flds_varname['google_plus']) && $google_plus_show ==1 || ($is_edit==1 && (@$htmlvar_name['contact_info']['google_plus']  || $tmpl_flds_varname['google_plus']))):
							if(!empty($google_plus) && !strstr($google_plus,'http'))
								$google_plus = 'http://'.$google_plus;
							?>
							<li><a id="google_plus" class="frontend_google_plus <?php if($is_edit==1):?>frontend_link <?php endif;?>" href="<?php echo $google_plus;?>"><i class="fa fa-google-plus"></i></a></li>
						<?php endif;
						echo '</ul>';
						do_action('tmpl_after_social_share_link');
						
					echo '</div>';
				} ?>
			</div>
			<!-- hotel-info end -->
		<?php
	}
}
/* show map on detail page in responsive view after content */
add_action('tmpl_splendor_after_content','tmpl_splendor_detail_map',2);
if(!function_exists('tmpl_splendor_detail_map')){
	function tmpl_splendor_detail_map(){
		if ( wp_is_mobile() ) {

			$instance = array(
				'heigh' => 350,
			); 
			
			/* call the instance search widget */
			the_widget( 'widget_googlemap_diection_widget', $instance );
		
		}
	}
}

/* change default map icon on page */
add_filter('tmpl_default_map_icon','tmpl_splendor_default_map_icon',99);
if(!function_exists('tmpl_splendor_default_map_icon')){
	function tmpl_splendor_default_map_icon(){
		$term_icon = get_stylesheet_directory_uri()."/images/pin.png";
		return $term_icon;
	}
}

add_filter('tmpl_location_arrow','tmpl_splendor_location_arrow');
if(!function_exists('tmpl_splendor_location_arrow')){
	function tmpl_splendor_location_arrow(){
		return 'fa fa-caret-down';
	}
}

/* added search icon icon */
add_action('templ_before_submit_btn','tmpl_splendor_search_icon');
if(!function_exists('tmpl_splendor_search_icon')){
	function tmpl_splendor_search_icon(){
		echo '<span class="header-search-icon" id="search_instant"></span>';
	}
}

/* set variable to show labels in advance search fileds label */
add_action('tmpl_show_searchfields_label','tmpl_splendor_show_label');
if(!function_exists('tmpl_splendor_show_label')){
	function tmpl_splendor_show_label($label){
		return 1;
	}
}

/* show label above search box text filed */
add_action('tmpl_advance_search_label','tmpl_splendor_advance_search_label');
if(!function_exists('tmpl_splendor_advance_search_label')){
	function tmpl_splendor_advance_search_label(){
		echo '<label class="r_lbl">';
		_e('Keyword','templatic');
		echo '</label>';
	}
}

/* change label for submit button for advance search */
add_filter('gettext','tmpl_splendor_advance_search_submit_label',10,2);
if(!function_exists('tmpl_splendor_advance_search_submit_label')){
	function tmpl_splendor_advance_search_submit_label( $translation, $text){
		if ( $text == 'Search' && (is_home() || is_front_page()))
			return __('Find Hotels','templatic');

		return $translation;
	}
}


/*  Displays a reply link for the 'comment' comment_type if threaded comments are enabled. */
add_shortcode( 'splendor-comment-reply-link', 'tmpl_splendor_comment_reply_link_shortcode' );
if(!function_exists('tmpl_splendor_comment_reply_link_shortcode')){
	function tmpl_splendor_comment_reply_link_shortcode( $attr ) {

		if ( !get_option( 'thread_comments' ) || 'comment' !== get_comment_type() )
			return '';
		$defaults = array(
			'reply_text' => '<i class="fa fa-reply"></i>',
			'login_text' => __( 'Log in to reply.', 'templatic' ),
			'depth' => intval( $GLOBALS['comment_depth'] ),
			'max_depth' => get_option( 'thread_comments_depth' ),
			'before' => '',
			'after' => ''
		);
		$attr = shortcode_atts( $defaults, $attr );
		return get_comment_reply_link( $attr );
	}
}

/* add class to body on devices only */
add_filter('body_class', 'tpml_splendor_finder_classes');
if(!function_exists('tpml_splendor_finder_classes')){
	function tpml_splendor_finder_classes($classes){
		 global $wp_query, $post;
          wp_reset_query();
          if (is_single()) {
				$post_type = get_post_type();
				if ($post_type == '') {
					$post_type = $post->post_type;
				}

				$exclude_array = apply_filters('spf_taxcategory_posttypes', array('event', 'listing', 'property','page','post'));
				if ((!in_array($post_type, $exclude_array) && $post_type != '') && !file_exists($template)) {
						  $classes[] = 'singular-listing';
				}
          }
         

          return $classes;
	}
}

/* add header image when it is uploaded in perticular city from backend  */
remove_action('before_main','supreme_home_banner_sidebar');	
add_action('before_main','tmpl_splendor_city_header_image');
if(!function_exists('tmpl_splendor_city_header_image')){
	function tmpl_splendor_city_header_image(){
		global $current_cityinfo,$wpdb,$multicity_table;
		if($current_cityinfo['header_image'] && !empty($current_cityinfo['header_image']) && (is_home() || is_front_page())){
			echo '<div class="city_header_image"><img src="'.$current_cityinfo['header_image'].'" width="100%" alt="'.$current_cityinfo['header_image'].'" title="'.$current_cityinfo['cityname'].'"/></div>';
			
		}else{
			add_action('before_main','supreme_home_banner_sidebar',11);
		}
	}
}

/* This filter is in Tevolution plugin ( function : tmpl_tevolution_single_preview_page )
*  Call additional post type preview page 
*  This will call "tevolution-single-listing-preview.php" from the theme's root
*  Otherwise it will call "tevolution-single-post-preview.php" page from Tevolution plugin.
*/
add_filter('get_tevolution_single_preview','tmpl_splendor_custom_preview_page');
if(!function_exists('tmpl_splendor_custom_preview_page')){
	function tmpl_splendor_custom_preview_page($single_preview){
		/* check if file is available */
		if ( file_exists(get_stylesheet_directory() . "/tevolution-single-listing-preview.php")) {
			$single_preview = get_stylesheet_directory() . "/tevolution-single-listing-preview.php";
		}
		
		return $single_preview;
	}
}

/* Show slider navigation arrow if images are more than six */
add_filter('tmpl_slider_image_count','tmpl_splendor_slider_image_count');
if(!function_exists('tmpl_splendor_slider_image_count')){
	function tmpl_splendor_slider_image_count(){
		return 6;
	}
}
/* EOF */
?>