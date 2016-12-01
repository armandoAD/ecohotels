<?php
/*
Name : listing_fields_collection
Desc : Return the collection for category listing page
*/
function tevolution_listing_fields_collection()
{
	global $wpdb,$post,$htmlvar_name,$pos_title;
	
	$cus_post_type = get_post_type();
	$args = 
 apply_filters('tmpl_custom_fileds_query',array( 'post_type' => 'custom_fields',
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
			'key' => 'show_on_listing',
			'value' =>  '1',
			'compare' => '='
		)
	),
		'meta_key' => 'sort_order',
		'orderby' => 'meta_value',
		'order' => 'ASC'
	),$cus_post_type);
	
	remove_all_actions('posts_where');
	$post_query = null;
	add_filter('posts_join', 'custom_field_posts_where_filter');
	$post_query = new WP_Query($args);
	remove_filter('posts_join', 'custom_field_posts_where_filter');
	
	$htmlvar_name='';
	if($post_query->have_posts())
	{
		while ($post_query->have_posts()) : $post_query->the_post();
			$ctype = get_post_meta($post->ID,'ctype',true);
			$post_name=get_post_meta($post->ID,'htmlvar_name',true);
			$style_class=get_post_meta($post->ID,'style_class',true);
			$label=get_post_meta($post->ID,'admin_title',true);
			$option_title=get_post_meta($post->ID,'option_title',true);
			$option_values=get_post_meta($post->ID,'option_values',true);
			$htmlvar_name[$post_name] = array( 'type'=>$ctype,
												'htmlvar_name'=> $post_name,
												'style_class'=> $style_class,
												'option_title'=> $option_title,
												'option_values'=> $option_values,
												'label'=> $post->post_title
											  );
			$pos_title[] = $post->post_title;
		endwhile;
		wp_reset_query();
	}
}
add_action('templ_before_categories_title','tevolution_listing_fields_collection');
add_action('templ_before_archive_title','tevolution_listing_fields_collection');

/*
	Return the label of taxonomy for archive page title.
 */
add_filter('tevolution_archive_page_title','tevolution_archive_page_title');
function tevolution_archive_page_title()
{
	global $wp_query;
	$PostTypeObject = get_post_type_object($wp_query->query_vars['post_type']);
	$_PostTypeName = $PostTypeObject->labels->name;
	return $_PostTypeName;
}

/* Add action for display the image in taxonomy page */
add_action('tmpl_category_page_image','tmpl_category_page_image');
add_action('tmpl_archive_page_image','tmpl_category_page_image'); 
/*
 * Function Name: tmpl_category_page_image
 */
function tmpl_category_page_image()
{
	global $post;		
	if ( has_post_thumbnail()):
		echo '<a href="'.get_permalink().'" class="event_img">';
		if($featured){echo '<span class="featured_tag">'.__('Featured111',EDOMAIN).'</span>';}
		the_post_thumbnail('event-listing-image'); 
		echo '</a>';
	else:
	$post_img = bdw_get_images_plugin($post->ID,'thumbnail');
	$thumb_img = $post_img[0]['file'];
	$attachment_id = $post_img[0]['id'];
	$attach_data = get_post($attachment_id);
	$img_title = $attach_data->post_title;
	$img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
	if($thumb_img):?>
		<a href="<?php the_permalink();?>" class="post_img">
			<?php do_action('inside_listing_image'); ?>
			<img src="<?php echo $thumb_img; ?>"  alt="<?php echo $img_alt; ?>" title="<?php echo $img_title; ?>" />
		</a>
    <?php else:?>
			<a href="<?php the_permalink();?>" class="post_img no_image_avail">
				<?php do_action('inside_listing_image'); ?>
				<img src="<?php echo CUSTOM_FIELDS_URLPATH; ?>/images/img_not_available.png" alt="" height="156" width="180"  />
			</a>	
    <?php endif;
	endif;
}

add_action('templ_taxonomy_content','templ_taxonomy_category_content');
function templ_taxonomy_category_content()
{ 
	global $htmlvar_name;
	$post_type = get_post_type();
	
	if(isset($_REQUEST['custom_post']) && $_REQUEST['custom_post'] !=''){
		$post_type = $_REQUEST['custom_post'];
	}
	/* get all the custom fields which select as " Show field on listing page" from back end */	
	$tmpdata = get_option('templatic_settings');	
	if(@$tmpdata['listing_hide_excerpt']=='' || !in_array($post_type,@$tmpdata['listing_hide_excerpt'])){
		if(function_exists('supreme_prefix')){
			$theme_settings = get_option(supreme_prefix()."_theme_settings");
		}else{
			$theme_settings = get_option("supreme_theme_settings");
		}
		if($theme_settings['supreme_archive_display_excerpt'] && (!empty($htmlvar_name['post_excerpt']) || !empty($htmlvar_name['post_excerpt']) || !empty($htmlvar_name['basic_inf']['post_excerpt'])) ){
			echo '<div itemprop="description" class="entry-summary">';
			if(!function_exists('tevolution_excerpt_length')){	
				if($theme_settings['templatic_excerpt_length']){
					$length = $theme_settings['templatic_excerpt_length'];
				}
				if(function_exists('print_excerpt')){
					echo print_excerpt($length);
				}else{
					the_excerpt();
				}
			}else{
				the_excerpt();
			}
			echo '</div>';
		}elseif(!empty($htmlvar_name['post_content']) || !empty($htmlvar_name['basic_inf']['post_content'])){ 
			echo '<div itemprop="description" class="entry-content">';
			the_content(); 
			echo '</div>';
		}
	}
}

add_action('templ_listing_custom_field','templ_custom_field_display',10,2);
function templ_custom_field_display($custom_field,$pos_title)
{
	global $post;		
	?>
     <div class="postmetadata">
        <ul>
		<?php $i=0; 
		
		if(!empty($custom_field)){
			foreach($custom_field as $key=> $_htmlvar_name):
				if($key!='category' && $key!='post_title' && $key!='post_content' && $key!='post_excerpt' && $key!='post_images' ):
					if($_htmlvar_name['type'] == 'multicheckbox' && get_post_meta($post->ID,$key,true) !=''):
						?>
                              <li class="<?php echo $custom_field[$key]['style_class']; ?>"><label><?php echo $_htmlvar_name['label']; ?></label> : <span><?php echo implode(",",get_post_meta($post->ID,$key,true)); ?></span></li>
                              <?php
					endif;
					if($_htmlvar_name['type'] != 'multicheckbox' && get_post_meta($post->ID,$key,true) !=''):
					?>
						<li class="<?php echo $custom_field[$key]['style_class']; ?>"><label><?php echo $_htmlvar_name['label']; ?></label> : <span><?php echo get_post_meta($post->ID,$key,true); ?></span></li>
					<?php
					endif;
				endif;				
			endforeach;			
		}
		?>
        </ul>
     </div>
     <?php	
}

/*
 * Add action display post categories and tag before the post comments
 */
add_action('templ_the_taxonomies','category_post_categories_tags'); 
function category_post_categories_tags()
{
	if(get_post_type() != 'post'){	
		/* global $post;		
		the_taxonomies(array('before'=>'<p class="bottom_line"><span class="i_category">','sep'=>'</span>&nbsp;&nbsp;<span class="i_tag">','after'=>'</span></p>')); */
		global $wp_query, $post,$htmlvar_name;
		/* get all the custom fields which select as " Show field on listing page" from back end */	
		
		$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post->post_type,'public'   => true, '_builtin' => true ));	
		$terms = get_the_terms($post->ID, $taxonomies[0]);
		$sep = ",";
		$i = 0;
		$taxonomy_category='';
		if(!empty($terms)){
			foreach($terms as $term)
			{
				
				if($i == ( count($terms) - 1))
				{
					$sep = '';
				}
				elseif($i == ( count($terms) - 2))
				{
					$sep = __(' and ','templatic');
				}
				$term_link = get_term_link( $term, $taxonomies[0] );
				if( is_wp_error( $term_link ) )
					continue;
				$taxonomy_category .= '&nbsp;<a href="' . $term_link . '">' . $term->name . '</a>'.$sep; 
				$i++;
			}
		}
		if(!empty($terms) && (!empty($htmlvar_name['basic_inf']['category']) || !empty($htmlvar_name['category'])))
		{
			echo '<p class="bottom_line"><span class="i_category">';
			echo apply_filters('tmpl_taxonomy_title'.get_post_type(),"<span>".__('Posted In','templatic'))."</span>"; echo " ".$taxonomy_category;
			echo '</span></p>';
		}
		global $post;
		$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post->post_type,'public'   => true, '_builtin' => true ));	
		
		$tag_terms = get_the_terms($post->ID, $taxonomies[1]);
		$sep = ",";
		$i = 0;
		$taxonomy_tag ='';
		if($tag_terms){
		foreach($tag_terms as $term)
		{
			
			if($i == ( count($tag_terms) - 1))
			{
				$sep = '';
			}
			elseif($i == ( count($tag_terms) - 2))
			{
				$sep = __(' and ','templatic');
			}
			$term_link = get_term_link( $term, $taxonomies[1] );
			if( is_wp_error( $term_link ) )
				continue;
			$taxonomy_tag .= '<a href="' . $term_link . '">' . $term->name . '</a>'.$sep; 
			$i++;
		}
		}
		if(!empty($tag_terms) && (!empty($htmlvar_name['basic_inf']['post_tags']) || !empty($htmlvar_name['post_tags'])))
		{
			echo '<p class="bottom_line"><span class="i_category">';
			_e(apply_filters('tmpl_tags_title_'.get_post_type(),'Tagged In'),'templatic'); echo " ".$taxonomy_tag;
			echo '</span></p>';
		}
	}
}
?>