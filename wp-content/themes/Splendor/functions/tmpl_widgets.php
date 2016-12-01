<?php
/*
* Custom widgets Settings
*/

/* add or remove widgets */
add_action('widgets_init','tmpl_splendor_custom_widgets',11); 
function tmpl_splendor_custom_widgets(){
	 /* remove default testomonials widget */
	unregister_widget('supreme_testimonials_widget');
	/* added theme specific widget */
	register_widget('tmpl_splendor_testimonials_widget'); 
	
	if(is_plugin_active('Tevolution-LocationManager/location-manager.php')){
		/* added theme specific widget for cities listing */
		register_widget('tmpl_splendor_cities_list');
	}else{
		/* remove top cities if location manager is not activate widget */
		unregister_widget('tmpl_splendor_cities_list'); 
	}	
}

/*  Testimonial widget START */
define('TITLE_TEXT',__('Title','templatic-admin'));
define('SET_TIME_OUT_TEXT',__('Set Time Out','templatic-admin'));
define('SET_THE_SPEED_TEXT',__('Set the speed','templatic-admin'));
define('QUOTE_TEXT',__('Quote text','templatic-admin'));
define('AUTHOR_NAME_TEXT',__('Author name','templatic-admin'));
if(!class_exists('tmpl_splendor_testimonials_widget'))
{
	class tmpl_splendor_testimonials_widget extends WP_Widget
	{
		function tmpl_splendor_testimonials_widget()
		{
			/* Constructor */
			$widget_ops = array('classname'  => 'testimonials','description'=> __('Display a set of sliding testimonials. Works best in sidebar areas.','templatic-admin'));
			parent::__construct('tmpl_splendor_testimonials_widget',apply_filters('tmpl_splendor_testimonials_widget_title_filter',__('T &rarr; Testimonials','templatic-admin')), $widget_ops);
		}
		function widget($args, $instance){
			/* prints the widget */
			extract($args, EXTR_SKIP);
			echo $args['before_widget'];
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$link_text = empty($instance['link_text']) ? '' : apply_filters('widget_title', $instance['link_text']);
			$link_url = empty($instance['link_url']) ? '' : apply_filters('widget_title', $instance['link_url']);
			
			$item_width = empty($instance['item_width']) ? 925 : $instance['item_width'];
			$min_item = 1;
			$max_items = 3;
			$item_move = 1;
			
			$width = apply_filters('carousel_slider_width',$item_width,12);
			$height= apply_filters('carousel_slider_height',350);
			
			$author_text = empty($instance['author']) ? '' : apply_filters('widget_author', $instance['author']);
			$quote_text = empty($instance['quotetext']) ? '' : apply_filters('widget_quotetext', $instance['quotetext']);
			$auth_email = empty($instance['auth_email']) ? '' : apply_filters('widget_auth_email', $instance['auth_email']);
			
			if($quote_text )
			{
				do_action('testimonial_script',$transition,$fadin,$fadout);
			}?>
			
			
			<div class="flexslider clearfix testimonials slider_carousel" >
				<?php
				if($title)
				{
					if(function_exists('icl_register_string'))
					{
						icl_register_string('templatic','testimonial_title',$title);
						$title = icl_t('templatic','testimonial_title',$title);
					}
					echo $args['before_title'].$title.$args['after_title'];
				}?>
				<div class="slides_container clearfix">
					<div class="flex-viewport">
						<ul class="slides">
							<?php
							for($c = 0; $c < count($author_text); $c++)
							{
								if( @$author_text[$c] != '')
								{
									?>
								<li class="testi">
								  <?php
									if(function_exists('icl_register_string'))
									{
										icl_register_string('templatic','quote_text'.$c,$quote_text[$c]);
										$quote_text[$c] = icl_t('templatic','quote_text'.$c,$quote_text[$c]);
										icl_register_string('templatic','author_text'.$c,$author_text[$c]);
										$author_text[$c] = icl_t('templatic','author_text'.$c,$author_text[$c]);
									}
									do_action('tmpl_testimonial_add_extra_field',$c,$instance);
									do_action('tmpl_testimonial_quote_text',$c,$instance);
									?>
								</li>
							<?php }
							} ?>
						</ul>
					</div>
				</div>
				<?php do_action('show_bullet'); ?>
			</div>
			<?php echo $args['after_widget'];
		}
		
		function update($new_instance, $old_instance)
		{
			/* save the widget */
			return $new_instance;
		}
		function form($instance)
		{
			/* widgetform in backend */
			$instance = wp_parse_args( (array) $instance, array('title' => 'People Talking About Templatic','link_text' => '','link_url'  => '','author' => array("Emma","Samantha","Catherine"),'quotetext' => array('Templatic offers world class WordPress theme support and unique, highly innovative and professionally useful WordPress themes. So glad to have found you! All the best and many more years of creativity, productivity and success.','Templatic has the best WordPress Themes and an exceptional and out-of-this-world customer service. I always receive a response in less than 24 hours, sometimes in less than one hour, this is amazing. I will recommend it to all my friends. Keep up the good work!','Templatic is reliable, it has a good support, and very accurate. Beside that, it has a big community of members who contribute.'),'auth_email' => array( 'Imas237@teleworm.us', 'TFlonight55@gustr.com', 'Drat5512@dayrep.com'), 'fadin'     => '2700','fadout'    => '1500','transition'=> 'fade' ) );
			$title     = strip_tags($instance['title']);
			$link_text = strip_tags($instance['link_text']);
			$link_url  = strip_tags($instance['link_url']);
			$auth_email  = strip_tags($instance['auth_email']);
			$autoplay = empty($instance['autoplay'])? '' : strip_tags($instance['autoplay']);
			$animation         = strip_tags($instance['animation']);
			$slideshowSpeed    = strip_tags($instance['slideshowSpeed']);
			$sliding_direction = strip_tags($instance['sliding_direction']);
			$reverse           = strip_tags($instance['reverse']);
			$animation_speed   = strip_tags($instance['animation_speed']);

			$author1   = ($instance['author']);
			$quotetext1= ($instance['quotetext']);
			$auth_email1 = $instance['auth_email'];
			global $author,$quotetext,$auth_email;
			$text_author    = $this->get_field_name('author');
			$text_quotetext = $this->get_field_name('quotetext');
			$auth_email =  $this->get_field_name('auth_email');
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"> <?php echo TITLE_TEXT;?>:
					<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
				</label>
			</p>

		
			<p>
				<label for="<?php echo $this->get_field_id('quotetext'); ?>"><?php echo __('Quote text','templatic-admin');?> :
					<textarea class="widefat" id="<?php echo $this->get_field_id('quotetext'); ?>" name="<?php echo $text_quotetext; ?>[]" type="text" ><?php echo esc_attr( @$quotetext1[0]); ?></textarea>
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('author'); ?>">
					<?php echo __('Author name','templatic-admin');?> :
					<input class="widefat" id="<?php echo $this->get_field_id('author'); ?>" name="<?php echo $text_author; ?>[]" type="text" value="<?php echo esc_attr( @$author1[0]); ?>" />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('auth_email'); ?>">
					<?php echo __("Author Email",'templatic-admin');?> :
					<input class="widefat" id="<?php echo $this->get_field_id('auth_email'); ?>" name="<?php echo $auth_email; ?>[]" type="text" value="<?php echo esc_attr($auth_email1[0]); ?>" />
				</label>
			</p>
			<?php do_action('tmpl_after_testimonial_title',$instance,$this); ?>
			
			<div id="tGroup" class="tGroup">
			<?php
				for($i = 1;$i < count($author1);$i++){
					if($author1[$i] != ""){
						$j = $i + 1;
						echo '<div  class="TextDiv'.$j.'">';
						echo '<p>';
						echo '<label>'.QUOTE_TEXT.$j;
						echo ': <textarea class="widefat"  name="'.$text_quotetext.'[]" >'.esc_attr($quotetext1[$i]).'</textarea>';
						echo '</label>';
						echo '</p>';
						echo '<p>';
						echo '<label>'.AUTHOR_NAME_TEXT.$j;
						echo ': <input type="text" class="widefat"  name="'.$text_author.'[]" value="'.esc_attr($author1[$i]).'"></label>';
						echo '</label>';
						echo '</p>';
						echo '<p>';
						echo '<label>'.__('Author Email','templatic-admin').$j;
						echo ': <input type="text" class="widefat"  name="'.$auth_email.'[]" value="'.esc_attr($auth_email1[$i]).'"></label>';
						echo '</label>';
						echo '</p>';
						do_action('tmpl_testimonial_field',$j,$instance,$this);
						echo '</div>';
					}
				}
				?>
			</div>
			<p>
				<?php do_action('add_testimonial_submit',$instance,$text_quotetext,$text_author,$auth_email); /* action for add more button */ ?>
				<a	href="javascript:void(0);" id="removetButton" class="removeButton" type="button" onclick="remove_tfields();">- Remove </a> 
			</p>	
		<?php
		}
	}
}

/* Top cities widget */

if(!class_exists('tmpl_splendor_cities_list'))
{
	class tmpl_splendor_cities_list extends WP_Widget
	{
		function tmpl_splendor_cities_list()
		{
			/* Constructor */
			$widget_ops = array('classname'  => 'topcities','description'=> __('Display a list of cities, selected in widget.','templatic-admin'));
			parent::__construct('tmpl_splendor_cities_list',apply_filters('tmpl_splendor_testimonials_widget_title_filter',__('T &rarr; Top Cities','templatic-admin')), $widget_ops);
		}
		
		function widget($args, $instance)
		{
			if(is_plugin_active('Tevolution-LocationManager/location-manager.php')){
				global $wpdb;
				extract($args, EXTR_SKIP);
				$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
				$cities = empty($instance['cities']) ? array('') : apply_filters('widget_cities', $instance['cities']);
				
				
				echo $args['before_widget'];
				
				/* get the image size dimension for city  default image */
				$allimage_sizes = tmpl_splendor_get_image_sizes('directory_listing-image');
				$size = $allimage_sizes['width'].'x'.$allimage_sizes['height'];
				$tevolution_taxonomies_data=get_option('tevolution_taxonomies_rules_data');
				$city_slug=get_option('location_multicity_slug');
				$multi_city=($city_slug)? $city_slug : 'city';
				if(count(array_filter($cities)) > 0){
					echo $args['before_title'].$title.$args['after_title'];
				?>
					<div class="cities_list">
						<?php
							foreach($cities as $cityinfo){
								$cityinfo1 = $wpdb->get_row("SELECT city_slug,cityname,message,city_default_image FROM {$wpdb->prefix}multicity where city_id=".$cityinfo);
								
								$city_slug = $cityinfo1->city_slug;
								$cityname = $cityinfo1->cityname;
								
								if($tevolution_taxonomies_data['tevolution_location_city_remove']==1){
									$city_url= rtrim(get_bloginfo('url'), '/').'/'.$city_slug;
								}else{
									$city_url= rtrim(get_bloginfo('url'), '/').'/'.$multi_city.'/'.$city_slug;
								}
								if (function_exists('icl_register_string')){
									icl_register_string('location-manager', 'location_city_'.$city_slug,$cityname);
									$cityname = icl_t('location-manager', 'location_city_'.$city_slug,$cityname);
									if($tevolution_taxonomies_data['tevolution_location_city_remove']==1){
										$city_url= rtrim(icl_get_home_url(), '/').'/'.$city_slug;
									}else{
										$city_url= rtrim(icl_get_home_url(), '/').'/'.$multi_city.'/'.$city_slug;
									}
								}
								
								echo '<div class="city_img">';
									echo '<a href="'.$city_url.'"><div class="city-detail">';
										echo '<span class="cityname">'.$cityinfo1->cityname.'</span>';
										if($cityinfo1->message)
											echo '<p>';
											echo substr($cityinfo1->message,0,100); 
											echo '</p>';
									echo '</div>';
									if($cityinfo1->city_default_image){
										/* get image extension */
										$ext = pathinfo($cityinfo1->city_default_image, PATHINFO_EXTENSION);
										//echo '<img src="'.preg_replace('/.[^.]*$/', '', $cityinfo1->city_default_image).'-'.$size.'.'.$ext.'" alt="'.$cityinfo1->cityname.'" />';
										echo '<img height="250" width="380" src="'.$cityinfo1->city_default_image.'" alt="'.$cityinfo1->cityname.'" />';
									}else{
										echo '<img height="250" width="380" src="//placehold.it/380x250" alt="'.$cityinfo1->cityname.'" />';
									}									
								echo '</a></div>';
							}
						?>
					</div>
				<?php
				}else{
					echo '<h6>';
					_e('No cities were selected in this widget','templatic');
					echo '</h6>';
				}
				echo $args['after_widget'];
			}
		}
		
		function update($new_instance, $old_instance)
		{
			/* save the widget data */
			return $new_instance;
		}
		function form($instance)
		{
			global $wpdb;
			$title = strip_tags($instance['title']);
			$cities = $instance['cities'];
			?>
			<p>
			  <label for="<?php echo $this->get_field_id('title'); ?>">
				<?php echo __('Title:','templatic-admin');?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			  </label>
			</p>
			<?php
			
			/* get cities in which listings are available */
			$city_ids=$wpdb->get_results("SELECT GROUP_CONCAT(distinct meta_value) as city_ids from {$wpdb->prefix}postmeta as pm,{$wpdb->prefix}posts as p where pm.post_id=p.ID AND p.post_status='publish' AND pm.meta_key = 'post_city_id' GROUP BY pm.post_id");
		
			foreach($city_ids as $cids){
				$cityids .= $cids->city_ids.",";
			}

			if(!empty($cityids)){
				foreach($city_ids as $ids){
					$cityids.=$ids->city_ids.",";
				}
				$cityids=str_replace(",","','",substr($cityids,0,-1));
				$countryinfo = $wpdb->get_results("SELECT  distinct  c.country_id,c.country_name,GROUP_CONCAT(mc.cityname) as cityname, GROUP_CONCAT(mc.city_slug) as city_slug   FROM {$wpdb->prefix}countries c,{$wpdb->prefix}multicity mc where mc.city_id in('$cityids') AND c.`country_id`=mc.`country_id`  AND c.is_enable=1 group by country_name order by country_name ASC");
			}
			/* get all the cities */
			$cityinfo = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multicity mc where mc.city_id in('$cityids') order by cityname ASC");
			
			?>
			<p>
				<label for="<?php echo $this->get_field_id('cities'); ?>">
					<select class="widget_post_type widefat" id="<?php echo $this->get_field_id('cities'); ?>" name="<?php echo $this->get_field_name('cities'); ?>[]" multiple>
						<option value=""><?php echo __('Select Cities','templatic-admin');?></option>
						<?php foreach($cityinfo as $allcities): ?>
							<option <?php if(in_array($allcities->city_id,$cities)){ echo 'selected'; }?> value="<?php echo $allcities->city_id; ?>"><?php echo $allcities->cityname; ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			</p>	
		<?php
		}
	}
}

/* EOF */
?>