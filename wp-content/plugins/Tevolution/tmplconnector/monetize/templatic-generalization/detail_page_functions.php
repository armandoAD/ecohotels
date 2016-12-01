<?php
/* 
 * this function wil return the custom fields of the post detail page <br />
 */
function tevolution_details_field_collection()
{
	global $wpdb,$post,$single_htmlvar_name;
	if(is_single()){
	
		$cus_post_type = get_post_type();
		$args = 
		array( 'post_type' => 'custom_fields',
		'posts_per_page' => -1	,
		'post_status' => array('publish'),
		'meta_query' => array(
		   'relation' => 'AND',
			array(
				'key' => 'post_type_'.$cus_post_type.'',
				'value' => $cus_post_type,
				'compare' => '=',
				'type'=> 'text'
			),
			array(
				'key' => 'show_on_page',
				'value' =>  array('user_side','both_side'),
				'compare' => 'IN'
			),
			array(
				'key' => 'is_active',
				'value' =>  '1',
				'compare' => '='
			),
			array(
				'key' => 'show_on_detail',
				'value' =>  '1',
				'compare' => '='
			)
		),
			'meta_key' => 'sort_order',
			'orderby' => 'meta_value_num',
			'meta_value_num'=>'sort_order',
			'order' => 'ASC'
		);
		remove_all_actions('posts_where');
		$post_meta_info = null;
		add_filter('posts_join', 'custom_field_posts_where_filter');
		$post_meta_info = new WP_Query($args);
		remove_filter('posts_join', 'custom_field_posts_where_filter');
				
		$single_htmlvar_name='';
		if($post_meta_info->have_posts())
		{
			while ($post_meta_info->have_posts()) : $post_meta_info->the_post();
				$ctype = get_post_meta($post->ID,'ctype',true);
				$post_name = get_post_meta($post->ID,'htmlvar_name',true);
				$single_htmlvar_name[$post_name] = $ctype;
				$single_pos_title[] = $post->post_title;
			endwhile;
			wp_reset_query();
		}
	}	
}
add_action('templ_before_post_title','tevolution_details_field_collection');

/*
 * display post title
 */
function tevolution_post_title()
{
	$title = get_the_title();
	$is_related = get_query_var('is_related');
	if ( strlen( $title ) == 0 )
		return;
	if (( is_singular() || is_single()) && !is_front_page() && !is_home() && !$is_related)
		$title = sprintf( '<h1 class="entry-title">%s</h1>', $title );
	else
		$title = sprintf( '<h2 class="entry-title"><a itemprop="url" href="%s" title="%s" rel="bookmark">%s</a></h2>', get_permalink(), the_title_attribute( 'echo=0' ), $title);
	echo $title;
}
add_action('templ_post_title','tevolution_post_title');

/*
 * add action for display the post info
 */
add_action('templ_post_info','post_info');
function post_info(){
	$num_comments = get_comments_number();
	$write_comments='';
	if ( comments_open() ) {
		if ( $num_comments == 0 ) {
			$comments = __('No Comments','templatic');
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments .' '. __('Comments','templatic');
		} else {
			$comments = __('1 Comment','templatic');
		}
		$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
	}
	?>
    <div class="byline">
		<?php
		$post_type = get_post_type_object( get_post_type() );
		if ( !current_user_can( $post_type->cap->edit_post, get_the_ID() ) ){
			$edit = '';
		}else{
			$edit = '<span class="post_edit"><a class="post-edit-link" href="' . esc_url( get_edit_post_link( get_the_ID() ) ) . '" title="' . sprintf( esc_attr__( 'Edit %1$s', 'templatic' ), $post_type->labels->singular_name ) . '">' . __( 'Edit', 'templatic' ) . '</a></span>';
		}	
		$author = __('Published by','templatic').' <span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a></span>';
		$published = __('On','templatic').' <abbr class="published" title="' . sprintf( get_the_time( esc_attr__( get_option('date_format')) ) ) . '">' . sprintf( get_the_time( esc_attr__( get_option('date_format')) ) ) . '</abbr>';
	    echo sprintf(__('%s %s %s %s','templatic'),$author,$published,$write_comments,$edit);
        ?>
    </div>
    <?php		
}

/*
 *  add action for display single post image gallery
 */
add_action('templ_post_single_image','single_post_image_gallery');
/*
 Display the single post image gallery in detail page.
*/
function single_post_image_gallery()
{
	global $post;
	$post_type = get_post_type($post->ID);
	$post_type_object = get_post_type_object($post_type);
	$single_gallery_post_type = $post_type_object->labels->name;
	$post_img = bdw_get_images_plugin($post->ID,'large');
	$post_images = $post_img[0]['file'];
	$attachment_id = $post_img[0]['id'];
	$attach_data = get_post($attachment_id);
	$img_title = $attach_data->post_title;
	$img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
	
	$post_img_thumb = bdw_get_images_plugin($post->ID,'thumbnail'); 
	$post_images_thumb = $post_img_thumb[0]['file'];
	$attachment_id1 = $post_img_thumb[0]['id'];
	$attach_idata = get_post($attachment_id1);
	$post_img_title = $attach_idata->post_title;
	$post_img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
	?>
    <div class="row">
		 <?php if(count($post_images)>0): ?>
             <div class="content_details">
                 <div class="graybox">
                        <img id="replaceimg" src="<?php echo $post_images;?>" alt="<?php echo $img_alt; ?>" title="<?php echo $img_title; ?>" />
                 </div>
             </div>            
         <?php endif; ?>
        <div class="row title_space">
            <?php if(count($post_images)>0): ?>
                <div class="title-container">
                    <h2>
						<?php 
							/*_e(MORE_PHOTOS.' '.$single_gallery_post_type,'templatic') */
							$msg = __("More Photos of",'templatic').' '.$single_gallery_post_type;
							if(function_exists('icl_register_string')){
								icl_register_string('templatic',$msg,$msg);
							}
							if(function_exists('icl_t')){
								$message1 = icl_t('templatic',$msg,$msg);
							}else{
								$message1 = __($msg,'templatic'); 
							}
							echo __($message1,'templatic');
						?>
					</h2>
                 </div>
                <div id="gallery">
                    <ul class="more_photos">
                        <?php for($im=0;$im<count($post_img_thumb);$im++):
							$attachment_id = $post_img_thumb[$im]['id'];
							$attach_data = get_post($attachment_id);
							$img_title = $attach_data->post_title;
						?>
                        <li>
                            <a href="<?php echo $post_img[$im]['file'];?>" title="<?php echo $img_title; ?>">
                                <img src="<?php echo $post_img_thumb[$im]["file"];?>" height="70" width="70"  title="<?php echo $img_title; ?>" alt="<?php echo $img_alt; ?>" />
                           </a>
                        </li>
                        <?php endfor; ?>
                    </ul>
               </div>     
			<?php endif;?>
		 </div>
     </div>    
    <?php
}
/* EOF - display gallery */

/*
 * display the single post content
 */
function tevolution_post_single_content()
{
	global $post;
	$is_edit='';
	if(isset($_REQUEST['action']) && $_REQUEST['action']=='edit'){
		$is_edit=1;
	}	
	$post_type_object = get_post_type_object(get_post_type());
    $post_type_label = $post_type_object->labels->name;
	$post_description=str_replace('Post',$post_type_label, __('Post Description','templatic'));
	$post_description = apply_filters('custom_post_type_desscription_title',$post_description,$post_type_label);
	
	if($post->post_content!='')  {
	if(function_exists('tmpl_wp_is_mobile') && !tmpl_wp_is_mobile()){
	if(function_exists('icl_t')){
		icl_register_string('templatic',$post_type_label,$post_type_label);
		$post_type_label = icl_t('templatic',$post_type_label,$post_type_label);
	}else{
		$post_type_label = @$post_type_label;
	}
	if($is_edit==1)
		$notice = __('(Click on content to edit.)','templatic');
	?>
		<h2><?php echo $post_type_label.' ';_e('Description','templatic'); echo ' <small>'.$notice.'</small>'; ?></h2>
	<?php }?>
	<div class="entry-content frontend-entry-content <?php if($is_edit==1):?>editblock<?php endif;?>">
    	<?php the_content();?>
    </div>
	<?php }
}
add_action('templ_post_single_content','tevolution_post_single_content');

add_action('tmpl_detail_page_custom_fields_collection','detail_fields_colletion',10);
/*
	Return the collection for detail/single page
*/
function detail_fields_colletion()
{
	global $wpdb,$post,$detail_post_type,$sitepress;
	$detail_post_type = $post->post_type;
	if(isset($_REQUEST['pid']) && $_REQUEST['pid'])
	{
		$cus_post_type = get_post_type($_REQUEST['pid']);
		$PostTypeObject = get_post_type_object($cus_post_type);
		$PostTypeLabelName = $PostTypeObject->labels->name;
		$single_pos_id = $_REQUEST['pid'];
	}
	else
	{	
		$cus_post_type = get_post_type($post->ID);
		$PostTypeObject = get_post_type_object($cus_post_type);
		$PostTypeLabelName = $PostTypeObject->labels->name;
		$single_pos_id = $post->ID;
	}
	$heading_type = fetch_heading_per_post_type($cus_post_type);
	remove_all_actions('posts_where');
	$post_query = null;
	if(count($heading_type) > 0)
	  { 
		foreach($heading_type as $_heading_type)
		 {
			$args = 
			array( 'post_type' => 'custom_fields',
			'posts_per_page' => -1	,
			'post_status' => array('publish'),
			'meta_query' => array(
			   'relation' => 'AND',
				array(
					'key' => 'post_type_'.$cus_post_type.'',
					'value' => $cus_post_type,
					'compare' => '=',
					'type'=> 'text'
				),
				array(
					'key' => 'show_on_page',
					'value' =>  array('admin_side','user_side','both_side'),
					'compare' => 'IN'
				),
				array(
					'key' => 'is_active',
					'value' =>  '1',
					'compare' => '='
				),
				array(
					'key' => $detail_post_type.'_heading_type',
					'value' =>  $_heading_type,
					'compare' => '='
				),
				array(
					'key' => 'show_on_detail',
					'value' =>  '1',
					'compare' => '='
				)
			),
				'meta_key' => 'sort_order',
				'orderby' => 'meta_value_num',
				'meta_value_num'=>'sort_order',
				'order' => 'ASC'				
			);
			add_filter('posts_join', 'custom_field_posts_where_filter');
		$post_query = new WP_Query($args);
		$post_meta_info = $post_query;
		remove_filter('posts_join', 'custom_field_posts_where_filter');
		$suc_post = get_post($single_pos_id);
		
				if($post_meta_info->have_posts())
				  {
					echo "<div class='grid02 rc_rightcol clearfix'>";
					echo "<ul class='list'>";					
					$i=0;
					while ($post_meta_info->have_posts()) : $post_meta_info->the_post();
						$field_type = get_post_meta($post->ID,"ctype",true);
						$style_class = get_post_meta($post->ID,"style_class",true);
						if($i==0)
						{
							if($post->post_name!='post_excerpt' && $post->post_name!='post_content' && $post->post_name!='post_title' && $post->post_name!='post_images' && $post->post_name!='post_category')
							{
								if($_heading_type == "[#taxonomy_name#]"){
									echo "<li><h2 class='custom_field_title'>";_e(ucfirst($PostTypeLabelName),'templatic');echo ' '; _e("Information",'templatic');echo "</h2></li>";
								}else{
									echo "<li><h2 class='custom_field_title'>".$_heading_type."</h2></li>";  
								}	
							}
							$i++;
						}
						
						$html_var_name = get_post_meta($post->ID,'htmlvar_name',true);
						
						if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')){
							$wpml_options = get_option( 'icl_sitepress_settings' );
							$default_lang = $wpml_options['default_language'];
							$orig_post_id = icl_object_id($single_pos_id, get_post_type($single_pos_id) , false, $default_lang );
							$single_pos_id = $orig_post_id;
						}
						
						if(get_post_meta($single_pos_id,$html_var_name,true)){
						
								if( get_post_meta($post->ID,"ctype",true) == 'multicheckbox' ) {
									$_value="";
									foreach(get_post_meta($single_pos_id,$html_var_name,true) as $value ) {
										$_value .= $value.",";
									}
									echo "<li class='".$style_class."'><p class='tevolution_field_title label'>".$post->post_title." : </p> <p class='tevolution_field_title'> ".substr($_value,0,-1)."</p></li>";
								} else if ( $field_type =='radio' || $field_type =='select' ) {
									
										$options = explode(',',get_post_meta($post->ID,"option_values",true));
										$options_title = explode(',',get_post_meta($post->ID,"option_title",true));
							
										for($i=0; $i<= count($options); $i++){
											$val = $options[$i];
											if(trim($val) == trim(get_post_meta($single_pos_id,$html_var_name,true))) { 
												$val_label = $options_title[$i];
												
											}
										}
										
										if($val_label ==''){ $val_label = get_post_meta($single_pos_id,$html_var_name,true); } /* if title not set then display the value*/
											
										echo "<li class='".$style_class."'><p class='tevolution_field_title label'>".$post->post_title." : </p> <p class='tevolution_field_title'> ".$val_label."</p></li>";

								  
								  }
								else
								 {
									 if(get_post_meta($post->ID,'ctype',true) == 'upload')
									 {
									 	echo "<li class='".$style_class."'><p class='tevolution_field_title label'>".$post->post_title." : </p> <p class='tevolution_field_title'> ".__('Click here to download File','templatic-admin')." <a href=".get_post_meta($single_pos_id,$html_var_name,true).">".__('Download','templatic-admin')."</a></p></li>";
									 }
									 else
									 {
										 echo "<li class='".$style_class."'><p class='tevolution_field_title label'>".$post->post_title." : </p> <p class='tevolution_field_title'> ".get_post_meta($single_pos_id,$html_var_name,true)."</p></li>";
									 }
								 }
							  }							
							if($post->post_name == 'post_excerpt' && $suc_post->post_excerpt!='')
							 {
								$suc_post_excerpt = $suc_post->post_excerpt;
								?>
                                     <li>
                                     <div class="row">
                                        <div class="twelve columns">
                                             <div class="title_space">
                                                 <div class="title-container">
                                                     <h1><?php _e('Post Excerpt','templatic');?></h1>
                                                     <div class="clearfix"></div>
                                                 </div>
                                                 <?php echo $suc_post_excerpt;?>
                                             </div>
                                         </div>
                                     </div>
                                     </li>
                                <?php
							 }
		
							if(get_post_meta($post->ID,"ctype",true) == 'geo_map')
							 {
								$add_str = get_post_meta($single_pos_id,'address',true);
								$geo_latitude = get_post_meta($single_pos_id,'geo_latitude',true);
								$geo_longitude = get_post_meta($single_pos_id,'geo_longitude',true);
								$map_view = get_post_meta($single_pos_id,'map_view',true);								
							 }		 
					endwhile;wp_reset_query();
					echo "</ul>";
					echo "</div>";
				  }		
		   }
	  }
	 else
	  {		
		$args = 
		array( 'post_type' => 'custom_fields',
		'posts_per_page' => -1	,
		'post_status' => array('publish'),
		'meta_query' => array(
		   'relation' => 'AND',
			array(
				'key' => 'post_type_'.$cus_post_type.'',
				'value' => $cus_post_type,
				'compare' => '=',
				'type'=> 'text'
			),
			array(
				'key' => 'is_active',
				'value' =>  '1',
				'compare' => '='
			),
			array(
				'key' => 'show_on_detail',
				'value' =>  '1',
				'compare' => '='
			)
		),
			'meta_key' => 'sort_order',
			'orderby' => 'meta_value',
			'order' => 'ASC'
		);				
		$post_query = new WP_Query($args);
		$post_meta_info = $post_query;
		$suc_post = get_post($single_pos_id);				
		if($post_meta_info->have_posts())
		{	
			$i=0;
			/*Display the post_detail heading only one time also with if any custom field create. */
			while ($post_meta_info->have_posts()) : $post_meta_info->the_post();	
				if($i==0)
				if($post->post_name != 'post_excerpt' && $post->post_name != 'post_content' && $post->post_name != 'post_title' && $post->post_name != 'post_images' && $post->post_name != 'post_category')
				{
					echo '<div class="title-container clearfix">';	
					/*echo '<h1>'.POST_DETAIL.'</h1>';*/
					$CustomFieldHeading = apply_filters('CustomFieldsHeadingTitle',POST_DETAIL);
					
					if(function_exists('icl_register_string')){
						icl_register_string('templatic',$CustomFieldHeading,$CustomFieldHeading);
					}
					
					if(function_exists('icl_t')){
						$CustomFieldHeading1 = icl_t('templatic',$CustomFieldHeading,$CustomFieldHeading);
					}else{
						$CustomFieldHeading1 = __($CustomFieldHeading,'templatic'); 
					}
					echo '<h3>'.$CustomFieldHeading1.'</h3>';
				
					echo '</div>';
					$i++;
				}			
			endwhile;wp_reset_query();	/*Finish this while loop for display POST_DETAIL	  		*/
			  ?>              
		<?php echo "<div class='grid02 rc_rightcol clearfix'>";
                echo "<ul class='list'>";
                if($_heading_type!="")			
                    echo "<h3>".$_heading_type."</h3>";
			
			while ($post_meta_info->have_posts()) : $post_meta_info->the_post();				
					if(get_post_meta($single_pos_id,$post->post_name,true))
					  {
						$style_class = get_post_meta($post->ID,"style_class",true);
						if(get_post_meta($post->ID,"ctype",true) == 'multicheckbox')
						  {
							$_value="";
							foreach(get_post_meta($single_pos_id,$post->post_name,true) as $value)
							 {
								$_value .= $value.",";
							 }
							 echo "<li class='".$style_class."'><p class='tevolution_field_title'>".$post->post_title.": </p> <p class='tevolution_field_value'> ".substr($_value,0,-1)."</p></li>";
						  }
						else
						 {
							 echo "<li  class='".$style_class."'><p class='tevolution_field_title'>".$post->post_title.": </p> <p class='tevolution_field_value'> ".get_post_meta($single_pos_id,$post->post_name,true)."</p></li>";
						 }
					  }							
					if($post->post_name == 'post_excerpt' && $suc_post->post_excerpt!="")
					 {
						$suc_post_excerpt = $suc_post->post_excerpt;
						?>
                           <li>
                           <div class="row">
                              <div class="twelve columns">
                                   <div class="title_space">
                                       <div class="title-container">
                                           <h1><?php _e('Post Excerpt');?></h1>
                                           <div class="clearfix"></div>
                                       </div>
                                       <?php echo $suc_post_excerpt;?>
                                   </div>
                               </div>
                           </div>
                           </li>
				  <?php
					 }

					if(get_post_meta($post->ID,"ctype",true) == 'geo_map')
					 {
						$add_str = get_post_meta($single_pos_id,'address',true);
						$geo_latitude = get_post_meta($single_pos_id,'geo_latitude',true);
						$geo_longitude = get_post_meta($single_pos_id,'geo_longitude',true);								
					 }
  
			endwhile;wp_reset_query();
			echo "</ul>";
			echo "</div>";
		  }
	  }
		if(isset($suc_post_con)):
		do_action('templ_before_post_content');/*Add action for before the post content. */?> 
             <div class="row">
                <div class="twelve columns">
                     <div class="title_space">
                         <div class="title-container">
                             <h1><?php _e('Post Description', 'templatic');?></h1>
                          </div>
                         <?php echo $suc_post_con;?>
                     </div>
                 </div>
             </div>
   		<?php do_action('templ_after_post_content'); /*Add Action for after the post content. */
		endif;		
			$tmpdata = get_option('templatic_settings');	
			$show_map='';
			if(isset($tmpdata['map_detail_page']) && $tmpdata['map_detail_page']=='yes')
				$show_map=$tmpdata['map_detail_page'];
			if(isset($add_str) && $add_str != '')
			{
			?>
				<div class="row">
					<div class="title_space">
						<div class="title-container">
							<h1><?php _e('Map','templatic'); ?></h1>
						</div>
						<p><strong><?php _e('Location','templatic'); echo ": ".$add_str;?></strong></p>
					</div>
					<div id="gmap" class="graybox img-pad">
						<?php 						
						if($geo_longitude &&  $geo_latitude ):
								$pimgarr = bdw_get_images_plugin($single_pos_id,'thumb',1);
								$pimg = $pimgarr[0]['file'];
								if(!$pimg):
									$pimg = CUSTOM_FIELDS_URLPATH."images/img_not_available.png";
								endif;	
								$title = $suc_post->post_title;
								$link = get_permalink($suc_post->ID);
								$address = $add_str;
								$srcharr = array("'");
								$replarr = array("\'");
								$title = sanitize_text_field(str_replace($srcharr,$replarr,$title));
								$address = sanitize_text_field(str_replace($srcharr,$replarr,$address));
								require_once (TEMPL_MONETIZE_FOLDER_PATH . 'templatic-custom_fields/preview_map.php');
								$retstr ="";								
								$retstr .= "<div class=\"google-map-info map-image forrent\"><div class=map-inner-wrapper><div class=map-item-info><div class=map-item-img><a href=\"$link\"><img src=\"$pimg\" width=\"192\" height=\"134\" alt=\"\" /></a></div>";
								$retstr .= "<h6><a href=\"\" class=\"ptitle\" style=\"color:#444444;font-size:14px;\"><span>$title</span></a></h6>";
								if($address){$retstr .= "<span style=\"font-size:10px;\">$address</span>";}
								$retstr .= "<p class=\"link-style1\"><a href=\"$plink\" class=\"$title\">$more</a></div></div></div>";
								
								
								
								
								$content_data[] = $retstr;
								preview_address_google_map_plugin($geo_latitude,$geo_longitude,$retstr,$map_view);
							  else:
								if(is_ssl()){
									$url = '//maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='.$add_str.'&amp;ie=UTF8&amp;z=14&amp;iwloc=A&amp;output=embed';
								}else{
									$url = '//maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='.$add_str.'&amp;ie=UTF8&amp;z=14&amp;iwloc=A&amp;output=embed';
								}
						?>
								<iframe src="<?php echo $url; ?>" height="358" width="100%" scrolling="no" frameborder="0" ></iframe>
						<?php endif; ?>
					</div>
				</div>
			<?php }

}

/*Remove the  the_content filter to add view counter everywhere in single page and add action tmpl_detail_page_custom_fields_collection before the custom field display*/

add_action('tmpl_detail_page_custom_fields_collection','teamplatic_view_counter',5);
function view_sharing_buttons($content)
{
	global $post;	
	if (is_single() && ($post->post_type!='post' && $post->post_type!='page'  && $post->post_type!='product'   && $post->post_type!='product_variation' )) 
	{
		$post_img = bdw_get_images_plugin($post->ID,'thumb');
		$post_images = $post_img[0];
		$title=urlencode($post->post_title);
		$url=urlencode(get_permalink($post->ID));
		$summary=urlencode(htmlspecialchars($post->post_content));
		$image=$post_images;
		$settings = get_option( "templatic_settings" );
		
		if($settings['facebook_share_detail_page'] =='yes' || $settings['google_share_detail_page'] == 'yes' || $settings['twitter_share_detail_page'] == 'yes' || $settings['pintrest_detail_page']=='yes'){
		echo '<div class="share_linkssss">ddddddd...';
			if($settings['facebook_share_detail_page'] == 'yes')
			  {
				?>
				<a rel="nofollow" onClick="window.open('//www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;&amp;p[images][0]=<?php echo $image;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)" id="facebook_share_button"><?php _e('Facebook Share.',T_DOMAIN); ?></a>
				<?php
			  }
			if($settings['google_share_detail_page'] == 'yes'): ?>
				<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
				<div class="g-plus" data-action="share" data-annotation="bubble"></div> 
			<?php endif;
			
			if($settings['twitter_share_detail_page'] == 'yes'): ?>
					<a rel="nofollow" href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-text='<?php echo htmlentities($post->post_content);?>' data-url="<?php echo get_permalink($post->ID); ?>" data-counturl="<?php echo get_permalink($post->ID); ?>"><?php _e('Tweet',T_DOMAIN); ?></a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<?php endif;
			
			if(@$settings['pintrest_detail_page']=='yes'):?>
               <!-- Pinterest -->
               <div class="pinterest"> 
                    <a rel="nofollow" href="//pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;media=<?php echo $image; ?>&amp;description=<?php the_title(); ?>" ><?php _e('Pin It','templatic');?></a>
                    <script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>                    
               </div>
               <?php endif; 
		echo '</div>';
		}
	}
	return $content;
}

/* 
* add action for send to friend and send inquiry email - specially in tevolution templates 
*/
add_action('templ_after_post_content','tevolution_dir_popupfrms');
if(!function_exists('tevolution_dir_popupfrms')){
	function tevolution_dir_popupfrms($post){
		global $current_user,$post;
		$tmpdata = get_option('templatic_settings');	
		$link='';	
		
		/* Claim ownership link */
		if(is_single())
		{
			if(!empty($tmpdata['claim_post_type_value'])&& @in_array($post->post_type,$tmpdata['claim_post_type_value']) && function_exists('tmpl_claim_ownership') && @$post->post_author!=@$current_user->ID)
			{
				/*
					We add filter here so if you are creating a child theme and don't want to show here, then just remove from child theme.
					e.g. add_filter('tmpl_allow_claimlink_inlist',0);
				*/
				$allow_claim = apply_filters('tmpl_allow_claimlink_inlist',1);
				do_action('tmpl_before_claim');
				if($allow_claim && get_post_meta($post->ID,'is_verified',true) !=1){
					echo '<li class="claim_ownership">';
					echo	do_shortcode('[claim_ownership]');
					echo '</li>';
				}
			}
			
			if(isset($tmpdata['send_to_frnd'])&& $tmpdata['send_to_frnd']=='send_to_frnd' && function_exists('send_email_to_friend'))
			{
				/*
					We add filter here so if you are creating a child theme and don't want to show here, then just remove from child theme.
					e.g. add_filter('tmpl_sent_to_frd_link','');
				*/
				do_action('tmpl_before_send_tofrd');
				$send_to_frnd=	apply_filters('tmpl_sent_to_frd_link','<a class="small_btn tmpl_mail_friend" data-reveal-id="tmpl_send_to_frd" href="javascript:void(0);" id="send_friend_id"  title="'.__('Mail to a friend','templatic').'" >'. __('Send to friend','templatic').'</a>');				
				
				add_action('wp_footer','send_email_to_friend',10);
				echo "<li>".$send_to_frnd.'</li>';
			}
				
			/* sent inquiry link*/
			
			if(isset($tmpdata['send_inquiry'])&& $tmpdata['send_inquiry']=='send_inquiry' && function_exists('send_inquiry'))
			{		
				/*
					We add filter here so if you are creating a child theme and don't want to show here, then just remove from child theme.
					e.g. add_filter('tmpl_send_inquiry_link','');
				*/
				do_action('tmpl_before_send_inquiry');
				$send_inquiry=	apply_filters('tmpl_send_inquiry_link','<a class="small_btn tmpl_mail_friend" data-reveal-id="tmpl_send_inquiry"  href="javascript:void(0)" title="'.__('Send Inquiry','templatic').'" id="send_inquiry_id" >'.__('Send Inquiry','templatic').'</a>');
				add_action('wp_footer','send_inquiry');		
				echo '<li>'.$send_inquiry.'</li>';
			} 
		
			/* Add to favourites */
			if(current_theme_supports('tevolution_my_favourites') && ($post->post_status == 'publish' )){
				global $current_user;
				$user_id = $current_user->ID;
				do_action('tmpl_before_addtofav');
				$link.= apply_filters('tmpl_add_to_favlink',tmpl_detailpage_favourite_html($user_id,@$post));
				echo $link;
				
			}
			
			echo '<li class="print"><a id="print_id" title="Print this post" href="#print" rel="leanModal_print" class="small_btn print" onclick="tmpl_printpage()"><i class="fa fa-print" aria-hidden="true"></i>'. __('Print','templatic').'</a></li>';
		}
	}
}

/*
 * Add Action display for single post page next previous pagination before comment
 */
if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/') && (!isset($_REQUEST['slider_search']) && @$_REQUEST['slider_search'] ==''))
{ 
	add_action('tmpl_single_post_pagination','single_post_pagination');
}
/*
	Display the next and previous  pagination in single post page
*/
function single_post_pagination()
{
	?>
		<div class="pos_navigation clearfix">
			<div class="post_left fl"><?php previous_post_link('%link','<i class="fa fa-angle-left"></i>  %title') ?></div>
			<div class="post_right fr"><?php next_post_link('%link','%title <i class="fa fa-angle-right"></i>' ) ?></div>
		</div>
	<?php
}

/*
 * Add action for display related post
 */
add_action('tmpl_related_post','related_post_by_categories');
/*
 * Display the related post from single post
 */
function related_post_by_categories()
{
	global $post,$claimpost,$sitepress;
	$claimpost = $post;	
	$tmpdata = get_option('templatic_settings');
	if(@$tmpdata['related_post_numbers']==0){
		return '';	
	}
	$related_post =  @$tmpdata['related_post'];
	$related_post_numbers =  ( @$tmpdata['related_post_numbers'] ) ? @$tmpdata['related_post_numbers'] : 3;
	$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post->post_type,'public'   => true, '_builtin' => true ));	
	remove_all_actions('posts_where');	
	if($related_post=='tags')
	{		
		 $terms = wp_get_post_terms($post->ID, $taxonomies[1], array("fields" => "ids"));	
		 $postQuery = array(
			'post_type'    => $post->post_type,
			'post_status'  => 'publish',
			'tax_query' => array(                
						array(
							'taxonomy' =>$taxonomies[1],
							'field' => 'ID',
							'terms' => $terms,
							'operator'  => 'IN'
						)            
					 ),
			'posts_per_page'=> apply_filters('tmpl_related_post_per_page',$related_post_numbers),			
			'ignore_sticky_posts'=>1,
			'orderby'      => 'RAND',
			'post__not_in' => array($post->ID)
		);
	}
	else
	{		
		 $terms = wp_get_post_terms($post->ID, $taxonomies[0], array("fields" => "ids"));	
		 $postQuery = array(
			'post_type'    => $post->post_type,
			'post_status'  => 'publish',
			'tax_query' => array(                
						array(
							'taxonomy' =>$taxonomies[0],
							'field' => 'ID',
							'terms' => $terms,
							'operator'  => 'IN'
						)            
					 ),
			'posts_per_page'=> apply_filters('tmpl_related_post_per_page',$related_post_numbers),			
			'ignore_sticky_posts'=>1,
			'orderby'      => 'RAND',
			'post__not_in' => array($post->ID)
		);
	}

	if(is_plugin_active('sitepress-multilingual-cms/sitepress.php') && (!empty($tmpdata['related_post_type']) && in_array($post->post_type,$tmpdata['related_post_type']))){
		remove_action( 'parse_query', array( $sitepress, 'parse_query' ) );
		add_filter('posts_where', array($sitepress,'posts_where_filter'),10,2);	
	}
	
	if(is_plugin_active('Tevolution-LocationManager/location-manager.php') && (!empty($tmpdata['related_post_type']) && in_array($post->post_type,$tmpdata['related_post_type']))){
		add_filter('posts_where', 'location_related_posts_where_filter');
	}
	
	$my_query = new wp_query($postQuery);

	if(is_plugin_active('Tevolution-LocationManager/location-manager.php') && (!empty($tmpdata['related_post_type']) && in_array($post->post_type,$tmpdata['related_post_type']))){
		remove_filter('posts_where', 'location_related_posts_where_filter');
	}
	$postcount = count($my_query->posts);
	$posttype_obj = get_post_type_object($post->post_type);
	$type_post = "";
	if($postcount > 1 ){
		$type_post = __("Entries",'templatic');
	}else{
		$type_post = __("Entry",'templatic');
	}
	$post_lable = ($posttype_obj->labels->menu_name) ? $posttype_obj->labels->menu_name : $type_post;
	if( $my_query->have_posts() ) :
	 ?>
     <div class="realated_post clearfix"> 
    	 <h3><span><?php _e("Related",'templatic'); echo "&nbsp;".$post_lable;?></span></h3>
		 <ul class="related_post_grid_view clearfix">
         <?php	   
		  while ( $my_query->have_posts() ) : $my_query->the_post();		
			if ( has_post_thumbnail()){
				$post_rel_img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), apply_filters('tevolution_replated_image_size','thumb') );
			}else{
				$post_rel_img =  bdw_get_images_plugin(get_the_ID(),apply_filters('tevolution_replated_image_size','thumb')); 			
			}
			$title = @$post->post_title;
			$alt = $post->post_title;

			$is_parent = $post->post_parent;	
			if($is_parent != 0){
				$featured = get_post_meta($is_parent,'featured_c',true);
				$calss_featured=$featured=='c'?'featured_c':'';
			}else{
				$featured = get_post_meta($post->ID,'featured_c',true);
					if($featured =='n'){  $featured = get_post_meta(get_the_ID(),'featured_h',true); }
				if($featured =='n'){  $featured = get_post_meta(get_the_ID(),'featured_type',true); }
				$calss_featured=$featured=='c'?'featured_c':'';
			}
             
		 ?>
         <li>
			<?php if($featured !='n' && $featured !=''){ echo '<span class="featured"></span>'; } ?>
			<?php if( @$post_rel_img[0] ){ 
				if ( has_post_thumbnail())
				{?>
					<a class="post_img" href="<?php echo get_permalink(get_the_ID());?>"><img  src="<?php echo $post_rel_img[0];?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>"  /> </a>
			<?php }
				else { ?>
					<a class="post_img" href="<?php echo get_permalink(get_the_ID());?>"><img  src="<?php echo $post_rel_img[0]['file'];?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>"  /> </a>
            <?php }
				}else{ ?>
            	<a class="post_img" href="<?php echo get_permalink(get_the_ID());  ?>"><img src="<?php echo TEMPL_PLUGIN_URL."/tmplconnector/monetize/images/no-image.png"; ?>"   alt="<?php echo $post_img[0]['alt']; ?>" /></a>
            <?php } ?>
         	<h3><a href="<?php echo get_permalink(get_the_ID());?>" > <?php the_title();?> </a></h3>
            <?php 	
			do_action('related_post_before_content');
			if(function_exists('theme_get_settings')){
				if(theme_get_settings('supreme_archive_display_excerpt')){
					the_excerpt();
				}else{
					the_content(); 
				}
			}	
			?>
         </li>
         <?php endwhile;?>
         
         </ul>     
     </div>     
     <?php
	wp_reset_query();
	else:
   		/*echo apply_filters('related_post_not_found',sprintf(__('No Related %s found.','templatic'),$post->post_type));   //uncomment if you want to show this message.*/
	endif;
}
/* EOF - related posts */

?>