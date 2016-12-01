<?php
/* insert the sample data */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
global $upload_folder_path,$wpdb,$blog_id;

/* theme options */
$a = get_option(supreme_prefix().'_theme_settings');
$b = array(
			'supreme_logo_url' 					=> get_stylesheet_directory_uri()."/images/logo.png",
			'supreme_site_description'			=> '',
			'display_publish_date'				=> 1,
			'display_post_terms'				=> 1,
			'supreme_display_noimage'			=> 1,
			'supreme_archive_display_excerpt'	=> 1,
			'templatic_excerpt_length'			=> 50,
			'display_header_text'				=> 1,
			'supreme_show_breadcrumb'			=> 1,
			'supreme_show_breadcrumb'			=> 1,
			'tmpl_mobile_view'					=> 1,
			'enable_inquiry_form'				=> 1,
			'footer_insert' 					=> '<div class="footer-bottom-wrap">
														<div class="footer-copyright">
															<p>Copyright '.date('Y').'. All rights reserved.  <a href="https://templatic.com/wordpress-directory-themes/" alt="wordpress themes" title="wordpress themes">Directory theme</a> by Templatic </p> 
														</div>
													</div>'
			);
update_option(supreme_prefix().'_theme_settings',$b);
update_option('posts_per_page',5);
update_option('date_format','F j, Y'); /* set date format to Jul 1, 2015 */
update_option('show_on_front','page');


if(is_plugin_active('Tevolution-LocationManager/location-manager.php')){

	/* get column name if exists or not */
	$city_default_image = $wpdb->get_var("SHOW COLUMNS FROM {$wpdb->prefix}multicity LIKE 'city_default_image'");
	if('city_default_image' != $city_default_image){
		$wpdb->query("ALTER TABLE {$wpdb->prefix}multicity ADD `city_default_image` TEXT NOT NULL AFTER `is_zoom_cat`");
	}
	
	$multicity_table = $wpdb->prefix . "multicity";
	
	 

	$athens = $wpdb->get_row("SELECT city_slug FROM $multicity_table WHERE city_slug = 'athens'");
	if(count($athens) == 0){
		$citydata1 = array(
			'country_id' => 84,
			'zones_id' => 1254,
			'cityname' => 'Athens',
			'city_slug' => 'athens' ,
			'lat' => '37.98617181240089',
			'lng' => '23.728785900000048',
			'scall_factor' => 13,
			'is_zoom_home' => '0',
			'map_type' => 'ROADMAP',
			'post_type' => 'listing',
			'categories' => 'all',
			'message' => 'To set city message, go to Tevolution - Manage Location - Cities - Edit cities - City Message',
			'color' => '',
			'images' => '',
			'header_color' => '',
			'header_image' => '',
			'cat_scall_factor' => '13' ,
			'is_zoom_cat' => '',
			'city_default_image' => get_stylesheet_directory_uri().'/images/athens.jpg',
		);
		
		$wpdb->insert( $multicity_table , $citydata1);
	}else{
		$wpdb->update( $multicity_table , array('city_default_image' => get_stylesheet_directory_uri().'/images/athens.jpg'), array('city_slug'=>'athens')  );
	}
	
	$paris = $wpdb->get_row("SELECT city_slug FROM $multicity_table WHERE city_slug = 'paris'");
	if(count($paris) == 0){
		$citydata2 = array(
			'country_id' => 73,
			'zones_id' => 1079,
			'cityname' => 'Paris',
			'city_slug' => 'paris' ,
			'lat' => '48.85887766623369',
			'lng' => '2.3470598999999766',
			'scall_factor' => 13,
			'is_zoom_home' => '0',
			'map_type' => 'ROADMAP',
			'post_type' => 'listing',
			'categories' => 'all',
			'message' => 'To set city message, go to Tevolution - Manage Location - Cities - Edit cities - City Message',
			'color' => '',
			'images' => '',
			'header_color' => '',
			'header_image' => '',
			'cat_scall_factor' => '13' ,
			'is_zoom_cat' => '',
			'city_default_image' => get_stylesheet_directory_uri().'/images/paris.jpg',
		);
		
		$wpdb->insert( $multicity_table , $citydata2);
	}else{
		$wpdb->update( $multicity_table , array('city_default_image' => get_stylesheet_directory_uri().'/images/paris.jpg'), array('city_slug'=>'paris')  );
	}
	
	
	$rome = $wpdb->get_row("SELECT city_slug FROM $multicity_table WHERE city_slug = 'rome'");
	if(count($rome) == 0){
		$citydata3 = array(
			'country_id' => 105,
			'zones_id' => 1640,
			'cityname' => 'Rome',
			'city_slug' => 'rome' ,
			'lat' => '41.88639571424178',
			'lng' => '12.515466249999918',
			'scall_factor' => 13,
			'is_zoom_home' => '0',
			'map_type' => 'ROADMAP',
			'post_type' => 'listing',
			'categories' => 'all',
			'message' => 'To set city message, go to Tevolution - Manage Location - Cities - Edit cities - City Message',
			'color' => '',
			'images' => '',
			'header_color' => '',
			'header_image' => '',
			'cat_scall_factor' => '13' ,
			'is_zoom_cat' => '',
			'city_default_image' => get_stylesheet_directory_uri().'/images/rome.jpg',
		);
		
		$wpdb->insert( $multicity_table , $citydata3);
	}else{
		$wpdb->update( $multicity_table , array('city_default_image' => get_stylesheet_directory_uri().'/images/rome.jpg'), array('city_slug'=>'rome')  );
	}
	
	$dubai = $wpdb->get_row("SELECT city_slug FROM $multicity_table WHERE city_slug = 'dubai'");
	if(count($dubai) == 0){
		$citydata4 = array(
			'country_id' => 224,
			'zones_id' => 3568,
			'cityname' => 'Dubai',
			'city_slug' => 'dubai' ,
			'lat' => '25.074183683256393',
			'lng' => '55.22984435000001',
			'scall_factor' => 13,
			'is_zoom_home' => '0',
			'map_type' => 'ROADMAP',
			'post_type' => 'listing',
			'categories' => 'all',
			'message' => 'To set city message, go to Tevolution - Manage Location - Cities - Edit cities - City Message',
			'color' => '',
			'images' => '',
			'header_color' => '',
			'header_image' => '',
			'cat_scall_factor' => '13' ,
			'is_zoom_cat' => '',
			'city_default_image' => get_stylesheet_directory_uri().'/images/dubai.jpg',
		);
		
		$wpdb->insert( $multicity_table , $citydata4);
	}else{
		$wpdb->update( $multicity_table , array('city_default_image' => get_stylesheet_directory_uri().'/images/dubai.jpg'), array('city_slug'=>'dubai')  );
	}
	
	$london = $wpdb->get_row("SELECT city_slug FROM $multicity_table WHERE city_slug = 'london'");
	if(count($london) == 0){
		$citydata5 = array(
			'country_id' => 225,
			'zones_id' => 3611,
			'cityname' => 'London',
			'city_slug' => 'london' ,
			'lat' => '51.528868434293244',
			'lng' => '-0.10159864999991441',
			'scall_factor' => 13,
			'is_zoom_home' => '0',
			'map_type' => 'ROADMAP',
			'post_type' => 'listing',
			'categories' => 'all',
			'message' => 'To set city message, go to Tevolution - Manage Location - Cities - Edit cities - City Message',
			'color' => '',
			'images' => '',
			'header_color' => '',
			'header_image' => '',
			'cat_scall_factor' => '13' ,
			'is_zoom_cat' => '',
			'city_default_image' => get_stylesheet_directory_uri().'/images/london.jpg',
		);
		
		$wpdb->insert( $multicity_table , $citydata5);
	}else{
		$wpdb->update( $multicity_table , array('city_default_image' => get_stylesheet_directory_uri().'/images/london.jpg'), array('city_slug'=>'london')  );
	}
	
	
	$madrid = $wpdb->get_row("SELECT city_slug FROM $multicity_table WHERE city_slug = 'madrid'");
	if(count($madrid) == 0){
		$citydata6 = array(
			'country_id' => 198,
			'zones_id' => 3059,
			'cityname' => 'Madrid',
			'city_slug' => 'madrid' ,
			'lat' => '40.438072163753745',
			'lng' => '-3.6795366500000455',
			'scall_factor' => 13,
			'is_zoom_home' => '0',
			'map_type' => 'ROADMAP',
			'post_type' => 'listing',
			'categories' => 'all',
			'message' => 'To set city message, go to Tevolution - Manage Location - Cities - Edit cities - City Message',
			'color' => '',
			'images' => '',
			'header_color' => '',
			'header_image' => '',
			'cat_scall_factor' => '13' ,
			'is_zoom_cat' => '',
			'city_default_image' => get_stylesheet_directory_uri().'/images/madrid.jpg',
		);
		
		$wpdb->insert( $multicity_table , $citydata6);
	}else{
		$wpdb->update( $multicity_table , array('city_default_image' => get_stylesheet_directory_uri().'/images/madrid.jpg'), array('city_slug'=>'madrid')  );
	}
	
	$new_york = $wpdb->get_row("SELECT * FROM $multicity_table WHERE city_slug = 'new-york'");
	if(count($new_york) > 0){
		$wpdb->update( $multicity_table , array('city_default_image' => get_stylesheet_directory_uri().'/images/newyork.jpg','message' => 'To set city message, go to Tevolution - Manage Location - Cities - Edit cities - City Message'), array('city_slug'=>'new-york')  );
	}
	
	$san_fransisco = $wpdb->get_row("SELECT * FROM $multicity_table WHERE city_slug = 'san-francisco'");
	if(count($san_fransisco) > 0){
		$wpdb->update( $multicity_table , array('city_default_image' => get_stylesheet_directory_uri().'/images/sanfrancisco.jpg','message' => 'To set city message, go to Tevolution - Manage Location - Cities - Edit cities - City Message'), array('city_slug'=>'san-francisco')  );
	}
	
	$philadelfia = $wpdb->get_row("SELECT * FROM $multicity_table WHERE city_slug = 'philadelphia'");
	if(count($philadelfia) > 0){
		$wpdb->update( $multicity_table , array('city_default_image' => get_stylesheet_directory_uri().'/images/philadelphia.jpg','message' => 'To set city message, go to Tevolution - Manage Location - Cities - Edit cities - City Message'), array('city_slug'=>'philadelphia')  );
	}
	
	
	
}

/* change some labe as "hotel" for "listing" post type */
if(post_type_exists('listing')){
	
	$customposts = get_option("templatic_custom_post");
	$customtaxonomycat = get_option("templatic_custom_taxonomy");
	$customtaxonomytag = get_option("templatic_custom_tags");

	/* change taxonomy label */
	$customposts['listing']['label'] = 'Hotels'; 
	$customposts['listing']['labels'] = array(
											'name' => 'Hotel',
											'singular_name' => 'Hotel',
											'menu_name' => 'Hotels',
											'all_items' => 'Hotels',
											'add_new' => 'Add Hotel',
											'add_new_item' => 'Add new hotel',
											'edit' => 'Edit',
											'edit_item' => 'Edit hotel',
											'new_item' => 'New hotel',
											'view_item' => 'View hotel',
											'search_items' => 'Search hotel',
											'not_found' => 'No hotel found',
											'not_found_in_trash' => 'No hotel found in trash',
										);

	/* change texonomy category label */									
	$customtaxonomycat['listingcategory']['label'] = 'Hotel Categories';
	$customtaxonomycat['listingcategory']['labels'] = array(
											'name' => 'Hotel Category',
											'singular_name' => 'listingcategory',
											'search_items' => 'Search category',
											'popular_items' => 'Search category',
											'all_items' => 'All categories',
											'parent_item' => 'Parent category',
											'parent_item_colon' => 'Parent category:',
											'edit_item' => 'Edit category',
											'update_item' => 'Update category',
											'add_new_item' => 'Add new category',
											'new_item_name' => 'New category name',
										);
	/* change texonomy tags label */									
	$customtaxonomytag['listingtags']['label'] = 'Hotel Tags';
	$customtaxonomytag['listingtags']['labels'] = array(
											'name' => 'Hotel Tags',
											'singular_name' => 'listingtags',
											'search_items' => 'Tags',
											'popular_items' => 'Popular tags',
											'all_items' => 'All tags',
											'parent_item' => 'Parent tags',
											'parent_item_colon' => 'Parent tags:',
											'edit_item' => 'Edit tags',
											'update_item' => 'Update tags',
											'add_new_item' => 'Add new tags',
											'new_item_name' => 'New tag name',
										);	
										
	update_option('templatic_custom_post',$customposts);
	update_option("templatic_custom_taxonomy",$customtaxonomycat);
	update_option("templatic_custom_tags",$customtaxonomytag);

}


/* add a price package */
$post_info = array(
				"post_title"	=>	'Gold Package',
				"post_content"	=>	'',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'monetization_package',
				'menu_order'    => 1,
			);
$results = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='monetization_package' AND post_title='Gold Package'");
if(count($results) == '')
{
	$last_package = wp_insert_post( $post_info );
	wp_set_post_terms($last_package,'1','category',true);
	if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')){
		if(function_exists('wpml_insert_templ_post'))
			wpml_insert_templ_post($last_package,'monetization_package'); /* insert post in language */
	}
	if (function_exists('icl_register_string')) {									
		icl_register_string('tevolution-price', 'package-name'.$last_package,'Gold Package');
		icl_register_string('tevolution-price', 'package-desc'.$last_package,'Gold Package');			
	}
}

$post_meta = array(
				"package_type"			=> '1',
				"package_post_type"		=> 'all,post,category,listing,listingcategory',	
				"category"               => 'all',
				"show_package"			=> '1',
				"package_amount"		=> '100',
				"days_for_no_post"      => '30',
				"validity" 			=> '12',
				"validity_per" 		=> 'M',
				"package_status"		=> '1',
				"recurring"			=> '0',
				"billing_num"			=> '',
				"billing_per"			=> '',
				"billing_cycle"		=> '',
				"is_featured"			=> '',
				"feature_amount"		=> '',
				"feature_cat_amount"	=> ''
			);
foreach($post_meta as $key=>$val)
{
	add_post_meta(@$last_package, $key, $val);
}


/* get all package list */
$tevolution_post_type = tevolution_get_post_type();
$submiturl = array();
foreach ($tevolution_post_type as $post_type){
	if ($post_type == 'listing'){
		$args_package = array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'post_status' => array('publish'),
			'meta_query' => array(
					  'relation' => 'AND',
					  array(
							'key' => 'submit_post_type',
							'value' => 'listing',
							'compare' => '='
					  ),
					  array(
							'key' => 'is_tevolution_submit_form',
							'value' => 1,
							'compare' => '='
					  )
			)
		);

		$post_query = null;
		$post_query = new WP_Query($args_package);
		$post_meta_info = $post_query;
		if ($post_meta_info->have_posts()) {
		  while ($post_meta_info->have_posts()) : $post_meta_info->the_post();
					$submiturl[] = get_permalink($post->ID);
		  endwhile;
		  wp_reset_query();
		  wp_reset_postData();
		}
	}
}

/* get submit page url */
$submiturl = array_values(array_unique($submiturl));
$submiturl = $submiturl[0];

$package_data = array();

$pkgargs = array(
		'post_type' => 'monetization_package',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC'
);

$pkgarg_array = get_posts( $pkgargs );

foreach($pkgarg_array as $packages){
	$package_data[] = $packages->ID;
}


/* all available packages list */
$packages = array_values($package_data);

/* map customizer */
update_option('google_map_customizer','{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]},');

/* made locations info applicable to listing post type only  */
$location_map_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_name like 'locations_info' and post_type='custom_fields' and post_status='publish' limit 0,1");
if(count($location_map_id) > 0)
	update_post_meta($location_map_id,'post_type','listing');

/* add multicity only for listings */
$multycity_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_name like 'post_city_id' and post_type='custom_fields' and post_status='publish' limit 0,1");
if(count($multycity_id) > 0)
	update_post_meta($multycity_id,'post_type','listing');		

/* add custom field of user misses in theme activation */
$amenitie = $wpdb->get_row("SELECT post_title,ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'amenitie' and $wpdb->posts.post_type = 'custom_fields'");
if(count($amenitie) == 0){
	$my_post = array(
		'post_title' => 'Amenity',
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
		'post_name' => 'amenitie',
		'post_type' => "custom_fields",
	);
	$post_meta = array(
		'heading_type' => '[#taxonomy_name#]',
		'listing_heading_type' => '[#taxonomy_name#]',
		'default_value' => '',
		'post_type'=> 'listing',
		'post_type_listing'=> 'listing',
		'ctype'=>'text',
		'htmlvar_name'=>'amenitie',
		'field_category' =>'all',
		'sort_order' => '56',
		'listing_sort_order' => '56',
		'is_active' => '1',
		'show_on_success'=>'0',
		'is_require' => '0',
		'show_on_page' => 'both_side',
		'show_in_column' => '0',
		'show_on_listing' => '1',
		'is_edit' => 'true',
		'show_on_detail' => '1',
		'is_search'=>'0',
		'is_submit_field'=>'1',
		'show_in_email'  =>'0',
		'is_delete' => '0',
		'admin_desc' => '',
	);
	
	$post_id = wp_insert_post( $my_post );
		wp_set_post_terms($post_id,'1','category',true);
	if(is_plugin_active('wpml-translation-management/plugin.php')){
		global $sitepress;
		$current_lang_code= ICL_LANGUAGE_CODE;
		$default_language = $sitepress->get_default_language();	
		/* Insert wpml  icl_translations table*/
		$sitepress->set_element_language_details($post_id, $el_type='post_custom_fields',$post_id, $current_lang_code, $default_language );
		if(function_exists('wpml_insert_templ_post'))
		wpml_insert_templ_post($post_id,'custom_fields'); /* insert post in language */
	}
	foreach($post_meta as $key=> $_post_meta){
		add_post_meta($post_id, $key, $_post_meta);
	}
}else{
	$post_type=get_post_meta($post_content->ID, 'post_type',true );
	if(!strstr($post_type,'listing'))
		update_post_meta($post_content->ID, 'post_type',$post_type.',listing' );
			
	update_post_meta($post_content->ID, 'is_submit_field',1);
	update_post_meta($post_content->ID, 'post_type_listing','listing' );
	update_post_meta($post_content->ID, 'taxonomy_type_listingcategory','listingcategory' );
	update_post_meta($post_content->ID, 'is_submit_field','1' );
	if(get_post_meta($post_content->ID,'listing_sort_order',true)){
		update_post_meta($post_content->ID, 'listing_sort_order',get_post_meta($post_content->ID,'listing_sort_order',true) );
	}else{
		update_post_meta($post_content->ID, 'listing_sort_order',10);
	}
	if(!get_post_meta($post_content->ID,'listing_heading_type',true) || get_post_meta($post_content->ID,'heading_type',true) =='[#taxonomy_name#]'){
		update_post_meta($post_content->ID, 'listing_heading_type','[#taxonomy_name#]' );
	}else{
		update_post_meta($post_content->ID, 'listing_heading_type',get_post_meta($post_content->ID,'heading_type',true) );
	}
}


/* set default logo image */
$listing_logo = $wpdb->get_row("SELECT post_title,ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'listing_logo' and $wpdb->posts.post_type = 'custom_fields'");
if(count($listing_logo) > 0)
{
	update_post_meta($listing_logo->ID, 'default_value', get_stylesheet_directory_uri().'/images/default-listing-logo.jpg');
}


/* set some default values for templatic settings according to theme */
$templatic_settings = get_option('templatic_settings');
$templatic_map_settings['direction_map'] = 'No';
$templatic_map_settings['php_mail'] = 'wp_smtp';
$templatic_map_settings['send_inquiry'] = 'send_inquiry';
$templatic_map_settings['send_to_frnd'] = 'send_to_frnd';
$templatic_map_settings['facebook_share_detail_page'] = 'yes';
$templatic_map_settings['google_share_detail_page'] = 'yes';
$templatic_map_settings['pintrest_detail_page'] = 'yes';
$templatic_map_settings['twitter_share_detail_page'] = 'yes';
$templatic_map_settings['templatin_rating'] = 'yes';
$templatic_map_settings['validate_rating'] = 'yes';
$templatic_map_settings['default_page_view'] = 'listview';
$templatic_map_settings['claim_post_type_value'] = array('listing');

if(!empty($templatic_settings)){
	$templatic_map_settings = array_merge($templatic_settings,$templatic_map_settings);
}	

update_option('templatic_settings',$templatic_map_settings);

$args = array(
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'page-templates/front-page.php'
			);
$page_query = new WP_Query($args);
$front_page_id = $page_query->post->ID;
update_option('page_on_front',$front_page_id);

$dummy_image_path = get_template_directory_uri().'/images/dummy/';
$post_info = array();
$category_array = array('News','Directory');
$cat_slug = 'category';
tmpl_splendor_insert_taxonomy_category($category_array,$cat_slug);

/* added some categories */
$category_array = array('Airport Hotels','Bed and Breakfast  Homestays','Business Hotels','Casino Hotels','Conference and Convention Centres','Extended Stay Hotels','Resort Hotels','Suite Hotels');
$cat_slug = 'listingcategory';
tmpl_splendor_insert_taxonomy_category($category_array,$cat_slug);
function tmpl_splendor_insert_taxonomy_category($category_array,$cat_slug){
	global $wpdb;
	for($i=0;$i<count($category_array);$i++)	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)			{
				$catname = $cat_name_arr[$j];
				if($j>1){
					$catid = $wpdb->get_var($wpdb->prepare("select term_id from $wpdb->terms where name=\"%s\"",$catname));
					if(!$catid){
					$last_catid = wp_insert_term( $catname, $cat_slug );
					}					
				}else{
					$catid = $wpdb->get_var($wpdb->prepare("select term_id from $wpdb->terms where name=\"%s\"",$catname));
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, $cat_slug,$args = array('description'=>'You can disable/enable this sorting option from wp-admin – Tevolution – Settings – Category Page – Sorting option. Also, you can set the default list view or grid view from here. To enable the map view enable the Map view option from the same page. To change this text go to wp-admin - Hotels - Hotel Category - and change the description of individual category.'));
					}
				}
			}
		}else		{
			$catname = $category_array[$i];
			$catid = $wpdb->get_var($wpdb->prepare("select term_id from $wpdb->terms where name=\"%s\"",$catname));
			if(!$catid)
			{
				wp_insert_term( $catname, $cat_slug,$args = array('description'=>'This is description of your blog category page. It can be changed from Posts -> Post Categories in your WordPress backend. This is an excellent way to attract your users and explain what this category is all about and also explain what they can do in this category and how does it matter to them. It also serves SEO at some instant. Use the Blog description the way that it helps in SEO.'));
			}
		}
	}
	for($i=0;$i<count($category_array);$i++)	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++){
				$catname = $cat_name_arr[$j];
				if($j>0)				{
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var($wpdb->prepare("select term_id from $wpdb->terms where name=\"%s\"",$parentcatname));
					$last_catid = $wpdb->get_var($wpdb->prepare("select term_id from $wpdb->terms where name=\"%s\"",$catname));
					wp_update_term( $last_catid, $cat_slug, $args = array('description'=>'This is description of your blog category page. It can be changed from Posts -> Post Categories in your WordPress backend. This is an excellent way to attract your users and explain what this category is all about and also explain what they can do in this category and how does it matter to them. It also serves SEO at some instant. Use the Blog description the way that it helps in SEO.','parent'=>$parent_catid) );
				}
			}
			
		}
	}
}



/* attach categories to posts */
$listings_args = array(
	'post_type'        => 'listing',	
	'posts_per_page'   => -1,
	'orderby'          => 'date',
	'order'            => 'DESC',
 );

$listings_array = get_posts( $listings_args );

/* get all categories for listing post type */
$cargs = array(
			'type'                     => 'listing',
			'taxonomy'                 => 'listingcategory',
			'hide_empty'               => 0,
		);
$categories = get_categories( $cargs );


$term_table=$wpdb->prefix."terms";

$c = 1;

/* get the empty categories */
foreach($categories as $empty_cats){

	if($empty_cats->count==0)
		$emptycats[] = $empty_cats->term_id;

	$c++;
}

/* devide array of category into sub-arrays */
$random_cat_keys = array_chunk($emptycats,3);

$post_author  = $wpdb->get_row("select * from $wpdb->posts where ID = '126'") ;
$post_date = $post_author->post_date;
$post_author  = ($post_author->post_author)? $post_author->post_author : $current_user->ID  ;
$uinfo = get_userdata($post_author);
$user_fname = $uinfo->display_name;
$user_email = $uinfo->user_email;
$user_billing_name = $uinfo->display_name;
$payable_amount = '0';
$pdate = date('Y-m-d');
$status = 1;
$package_select = 0;
$is_package = 0;
$is_featured_h = 0;
$is_featured_c = 0;
$is_category = 0;

$aminity_arr = array('24-Hour Room Service','Concierge lounge','Internet Service','Club','Pool','Baggage Storage');

$rand = 0;
$amnty  = 0;
foreach($listings_array as $listings){
	
	/* set special offers content */
	update_post_meta($listings->ID,'proprty_feature','<p>This is a listing description section where you can write about your listing. We have provided an editor for entering this information on Submit listing page so your visitors will be able to format their description easily. They can highlight their content with <strong>Bold</strong>, <em>Italic</em>, <span style="text-decoration: underline;">Underline</span> options, they can also use ordered and un-ordered lists.</p>');
	
	if($amnty > 5)
		$amnty = 0;
		
	update_post_meta($listings->ID,'amenitie',$aminity_arr[$amnty]);
	$amnty++;
	

	/* insert data in transation table for edit upgrade button */
	$transection_db_table_name=$wpdb->prefix.'transactions';
	$transaction_insert = 'INSERT INTO '.$transection_db_table_name.' set 
		post_id="'.$listings->ID.'",
		user_id = "'.$post_author.'",
		post_title ="'.$listings->post_title.'",
		payment_method="-",
		payable_amt="'.str_replace(',', '', $payable_amount).'",
		payment_date="'.$pdate.'",
		status="'.$status.'",
		user_name="'.$user_fname.'",
		pay_email="'.$user_email.'",
		billing_name="'.$user_billing_name.'",
		package_id="'.$package_select.'",
		payforpackage="'.$is_package.'",
		payforfeatured_h="'.$is_featured_h.'",
		payforfeatured_c="'.$is_featured_c.'",
		payforcategory="'.$is_category.'"';
	
	$wpdb->query($transaction_insert);
	
	if(!array_key_exists($rand,$random_cat_keys))
		$rand = 0;
		
	$attachcat = $random_cat_keys[$rand];
	wp_set_post_terms( $listings->ID, $attachcat, 'listingcategory', true );
	$rand++;
}

$sauce = $wpdb->get_row("SELECT post_title,ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'sauce' and $wpdb->posts.post_type = 'listing'");
if(count($sauce) > 0)
{
	wp_set_post_terms( $sauce->ID, $emptycats, 'listingcategory', true );
}



////post end///

//====================================================================================//
////post start 20///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/Directory/img20.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Make money with Directory',
				   "templ_seo_page_kw" => '',
				   "tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				   "country_id" => 226,
				   "zones_id" => 3721,
				   "post_city_id"=>"1"
				);
$post_info[] = array(
					"post_title" =>	'Make money with Directory',
					"post_content" =>	'<strong>Directory </strong>is our brand new platform that encompasses a parent theme, various plugins and a wide selection of child themes. It is the most advanced theme we’ve ever created with literally hundreds of custom features. Read this page to learn more about the ways in which Directory can earn you some extra cash.

<h2>Make money by</h2>

<ul>
	<li><strong>Charging for submissions</strong></li>

Create price packages and insert them into your submission forms. Price packages can be created for every post type and they are category specific. Scroll down for more info. 

	<li><strong>Selling event tickets?</strong></li>

Create ticket products using WooCommerce? and connect them with events. Event detail page will show the buy button as well as the remaining ticket count. 

	<li><strong>Creating a webshop</strong></li>

Along with selling tickets, you can use WooCommerce to sell other stuff as well. Create your product categories, setup shipping, tax and you’re ready to go! 

	<li><strong>Selling ad space with <a href="http://templatic.com/directory-add-ons/templatic-admanager-wordpress-plugin">Ad Manager add-on</a></strong></li>

Use the back-end to control exactly where each banner shows. Set category specific banners or assign them to each post manually. Multiple locations available.

</ul>
<!--more-->



<h2>Price packages, explained</h2>
Content is key for any directory, and the one you create using this WP Directory theme won’t be any different. Price packages are designed to offer as many possibilities as possible both to you (the admin) and the visitors submitting a post. Here are three things you should know about price packages.

<ul>
	<li><strong>Two package types</strong></li>

Pay-per-post packages require the visitors to pay during each post submission. Pay-per-subscription packages allow you to set the timeframe in which posts can be submitted as well as a maximum number of listings. Subscription price packages work great in conjunction with recurring PayPal payments.

	<li><strong>Featured posts</strong></li>

One of the ways you can charge extra for a particular post submission is to set a featured price. Featured prices can be set for both the homepage and category page (different price for each). Featured posts show with a specific label and are stacked at the top of listing pages. Another way to charge extra is to set category prices.

	<li><strong>Custom field monetization?</strong></li>

This feature allows you to define exactly which custom fields show for each price package. You can also control the number of allowed images and stuff like character count for text fields. In practice, this will allow you to provide additional options (input fields) within the more expensive price packages.</ul>

<h2>More monetization features</h2>

<ul>
	<li><strong>Included coupon module</strong></li>

Create amount based or percentage based coupons and offer discounts on price packages. Set a start/end date for coupons and don’t worry about expiry dates. 

	<li><strong>Change the currency</strong></li>

Set the currency ISO code, the symbol and even the position (before/after amount). There are virtually no limitations here. 

	<li><strong>Payment gateways</strong></li>

Directory comes preinstalled with PayPal and PreBank transfer methods. There are dozens more available optional payment processors. 

	<li><strong>Manage transactions</strong></li>

All payments can be reviewed and approved/denied in the back-end. There are also several dashboard widgets? you can use to keep track of transactions. 

	<li><strong>Post upgrade option</strong></li>

Allow visitors to upgrade their submitted listing to a more expensive price package. They can do so from their front-end user dashboard.  

	<li><strong>Generate reports</strong></li>

Search through submitted transactions using multiple filtering fields such as date, package type, post type, etc. Export results to a .CSV file.
</ul>
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('News','Directory'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 21///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/Directory/img21.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Manage a global website with Directory',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				   "country_id" => 226,
				   "zones_id" => 3721,
				   "post_city_id"=>"1"
				);
$post_info[] = array(
					"post_title" =>	'Manage a global website with Directory',
					"post_content" =>	'Directory is our brand new platform that encompasses a parent theme, various plugins and a wide selection of child themes. It is the most advanced theme we’ve ever created with literally hundreds of custom features. Read this page to learn more about how you can turn your website into a global directory.

<h2>How do cities work in Directory?</h2>

Cities in this WordPress listing directory theme essentially provide another layer of filtering content. With regular themes you’re limited to organizing posts into categories; in Directory everything you create is also filtered by cities. In practice, it means that a person who “lands” in New York won’t see anything posted for London. Customize cities by adding a city message or setting a custom header and body background. Choose between using an image or a simple color for both the header and the body.

Use city logs to check out how many people visited each of your cities. The theme also logs each visitors IP address.

<h2>A map for everything</h2>

In Directory we’ve made it so that geo-location information can be associated with virtually any piece of content. This will allow you to showcase pretty much anything on a map. Maps themselves are plentiful. They are featured on the homepage, along with search, category and detail pages. There are 6 different map widgets you can use thought the site. With category pages you can choose between using an AJAX based map or a listing map widget. The map widget also enables pinpointing functionality for quickly focusing on a specific map marker.
<!--more-->


<h2>Go global with these location related features</h2>

<ul>
	<li><strong>City management</strong></li>

Add unlimited cities to your site and organize them into countries and states. We’ve pre-loaded hundreds of them to make the process faster. 

	<li><strong>Geo-tracker</strong></li>

A built-in IP tracking script will ensure every visitor is shown the correct city upon arrival. Of course, you can turn this off and show a default city instead.

	<li><strong>Homepage map</strong></li>

Directory is filled with maps, but this one is special. Integrated search and content-rich popups are just some of the features you’ll find in it.
 
	<li><strong>City selectors</strong></li>

While browsing the site visitors can use one of 4 selectors to change the city. Two work above the header, one is appended on the side and the last one is a widget.
</ul>


<h2>Google Map features</h2>

<ul>
	<li><strong>Marker clustering</strong></li>

Reduce map clutter with marker clustering, a feature available for all listing maps. An option for disabling it is also provided.

 
	<li><strong>Custom markers</strong></li>

The icon you add while creating a category will be used to represent that category within every map on the site.

 
	<li><strong>Auto width</strong></li>

Automatic map width will allow you insert map widgets in any widgetized area and not worry whether it will fit or not.

	<li><strong>Street View</strong></li>

Turn on street view by dragging the orange man at any time. Set street view as default view for the detail page map.

 
	<li><strong>Map shortcode</strong></li>

Use a map shortcode to generate a fully functional listing map. Works with all created post types.

 
	<li><strong>Change zoom behavior</strong></li>

The zoom factor on listing maps can be automatic (by fitting all available posts) or static (by setting it beforehand).

	<li><strong>Four types</strong></li>

For most of the maps you can choose the map type. These include road, terrain, satellite, hybrid.

 
	<li><strong>Detail map directions</strong></li>

Enter your address on the detail page and the map will generate directions to the location of the post you were viewing.

 
	<li><strong>Full page map</strong></li>

The homepage map has a button for loading it across the whole page. Use it when searching for something specific.
</ul>
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('News','Directory'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 22///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/Directory/img22.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Create & manage content with Listings',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				   "country_id" => 226,
				   "zones_id" => 3721,
				   "post_city_id"=>"1"
				);
$post_info[] = array(
					"post_title" =>	'Create & manage content with Listings',
					"post_content" =>	'The Listings theme is a very adaptable and powerful CMS system for building profitable online directories.  With many great tools under the hood, Listings is the ideal solution for almost any type of online business directory you can think of.

Take a look below at just some of the features and options which make this WordPress listings theme the perfect software for business directories.

&nbsp;

<b>Claim listing ownership options</b>
Allow people to claim listings which have been submitted by admin (you). Use this feature to let business owners for example be able to claim and manage the claimed listing.

Once a listing claim has been approved by admin, the listing is automatically assigned to a new username so it can be managed.

&nbsp;

<b>AdSense or image banner</b>
Paste your banner code in the \'Text\' widget to display AdSense banners on your directory. The widget can be used more than once in many locations.

You can also consider using the Ad Manager add-on plugin to have banner rotation, city or category-specific banners.

&nbsp;

<b>Frontend Listing submissions</b>
Allow users to submit listings on your directory with the very powerful built-in price package options. The Listings theme can also have submissions disallowed in case you require it to be an only admin submission type of directory.

&nbsp;

<b>Create custom price packages to suite your directory</b>
Create single submission packages at a certain price and duration with options to be made featured for an extra amount.

You can also create subscription/membership packages which let you to set a price and number of submissions which can be made using a package.  The theme also gives admin the option to offer trial periods packages.

&nbsp;

<b>Listings require Admin approval</b>
To give you more control over the submitted content, you can set the default status of submitted listings to draft. Activating this option, makes all submitted listings require admin approval before making it live on your directory.

Admin approval can also be switched off so submitted listings go online. The theme also offers admin independent listing default status options for free or paid listing packages.

&nbsp;

<b>Unlimited custom fields</b>
Adapt the amazing Listings theme to match whatever directory you wish to launch. Create unlimited custom fields of various types and you can even make new fields searchable in advanced search.

Decide the field sorting order and its display locations with options for displaying a field on the frontpage and listing categories, detail pages and the submission form.

&nbsp;

<b>Create custom listing categories</b>
We understand that no two directories are the same. For this reason, we have designed an easy system to let you create unlimited listing categories and sub-categories to match any type of directory you are planning to build.

You can also assign a particular fields to one or more listing category or a price packages if you like. This option gives you freedom to customize the submission form as it makes it show different fields for different selected categories.

&nbsp;

<b>SEO features</b>
Optimize your directory for Google and other search engines with the powerful WordPress SEO by Yoast plugin. This is a plugin which is compatible with our theme and works well with it. Use the Yoast plugin to populate all the Meta tag fields like title, description and keywords on your site.

&nbsp;

<b>Permalinks customizer</b>
Use the theme\'s powerful tool to customize your directory\'s urls. The options include removing or changing of default words in the urls such as \'listing\', \'listingcategory\' or renaming or removing the word \'city\'. You can also include the city name in the listing category urls if you like.

&nbsp;

<b>CSV bulk import/export tool</b>
Use .CSV files to import listings or cities to your directory from your previous directory website for example. The .CSV imports/export also works with newly created post types. You can also import/export cities to and from your website.

&nbsp;

<b>Custom submission form</b>
The theme’s submission form can be easily configured to be exactly how you want it. Choose which fields are to appear on the listing submission form.  You can also choose a field’s sorting order on the form and also decide if fields appear for all categories or just particular ones, the choice is yours.

&nbsp;

<b>Translatable and RTL support</b>
The Listings theme is very easy to translate into any language. Use the included .PO files to translate this theme and build a directory in any language.

Not only can you translate Listings, it also supports RTL (right-to-left) languages such as Arabic, Hebrew, Persian or Urdu. Switching the language direction is simply done with a click of a button from theme settings.

&nbsp;

<b>The ideal theme for city directories</b>
A very powerful business listings directory theme for 1 city or for thousands of cities, the choice is yours. Once you\'ve configured the locations, your users can select from the menu to see only  listings from there chosen location.

<b>Different location selectors</b>
The theme\'s location manager lets you choose the method users can choose locations from the top of the site. Choose between showing country -&gt; state -&gt; city where you are using it for more than one country. You can also choose to show it as state -&gt; city or only allowing cities to be selected.

<b>Listings rating and reviews </b>
Allow people to leave reviews under listings on your directory. As well as this, visitors can also rate each listing with a star rating of between 1-5. The rating option can also b switched off if you prefer not to display the rating system.

See the full list of features here (Link \'here\' to below url)

<a title="http://templatic.com/app-themes/wordpress-responsive-listings-directory-theme" href="http://templatic.com/app-themes/wordpress-responsive-listings-directory-theme" target="_blank" data-behavior="truncate">http://templatic.com/app-themes/wordpress-responsive-listings-directory-theme</a>',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('News','Directory'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
////post start 22///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/Directory/img20.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'How to speed up your Directory website?',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				   "country_id" => 226,
				   "zones_id" => 3721,
				   "post_city_id"=>"1"
				);
$post_info[] = array(
					"post_title" =>	'How to speed up your Directory website?',
					"post_content" =>	'<em>Note: You must take backup of your site and database before following this step. Better be safe then sorry.</em>

Here are some tips on how to speed up your WordPress website:
<ul>
	<li><strong>Shared hosting v/s Dedicated hosting:</strong> If you are having more data or higher traffic on your Directory website then instead of shared hosting, we recommend using a  dedicated server. Directory is an application like theme and as soon as your site gets traction both content and traffic on your website will increase simultaneously so your website will need more server resources for better performance. If you are on a shared hosting your server resources will be shared with other websites on the same server so you will get limited resources for your website which will ultimately result in an under performing website. On the other hand if you go with a dedicated server all server resources will be available for your website and it will perform much better. </li>
	<li><strong>Remove plugins</strong>: Please visit plugins page in your WordPress admin and remove any and all unnecessary plugins which is not really contributing to your site.</li>
	<li><strong>Optimize DB:</strong> If your site is more than few months old, you should optimize your site database with plugins like <a href="http://wordpress.org/extend/plugins/rvg-optimize-database/">RGV optimize</a> and <a href="http://wordpress.org/extend/plugins/simple-optimizer/">Simple optimizer</a> or likes that will remove unnecessary junk from your site such as spam comments, post revisions etc. which will make your site database perform better</li>
	<li><strong>Limit post revisions: </strong>Most users dont need each version of post revisions. Here is a good article on <a href="http://bacsoftwareconsulting.com/blog/index.php/web-programming/how-to-delete-and-limit-revisions-in-wordpress/">how to disable or limit it</a>.</li>
	<li><strong>Spam Comments</strong><span class="Apple-converted-space"> </span>– If your spam comment receipts are in high numbers then all the spam comments should be deleted at the regular interval by just going to<span class="Apple-converted-space"> </span><strong>wp-admin</strong><span class="Apple-converted-space"> </span>&gt;<span class="Apple-converted-space"> </span><strong>Comments</strong><span class="Apple-converted-space"> </span>&gt;<strong>Spam</strong><span class="Apple-converted-space"> </span>&gt;<strong>Empty Spam (button)</strong><span class="Apple-converted-space"> </span>otherwise you may end up with a compromise in the site speed!</li>
	<li><strong>Lack of Image optimization</strong><span class="Apple-converted-space"> </span>– It is very important to upload the just perfect sized image &amp; that too with the specific formats like “jpg,png etc”.</li>
	<li><strong>W3 Cache plugin:</strong> This will really make your site faster. We highly recommend using <a href="http://wordpress.org/extend/plugins/w3-total-cache/">this plugin</a> which will cache your site and serve pages really faster.</li>
	<li><strong>Cloud flare:</strong> Use <a href="http://www.cloudflare.com/">cloud flare</a> and it will improvise your site performance further. Its free!</li>
	<li><strong>CDN:</strong> Most of the popular sites nowadays use CDN services such as <a href="http://www.maxcdn.com/">MaxCDN</a> or likes to deliver content from their site (we at templatic use it too)</li>
	<li><strong>Memory Limit</strong>: Many times increase in memory limit variable of the php.ini file also helps the user in loading the site faster.</li>
	<li><strong>Better WordPress Minify:</strong> It compress and combines CSS and JS scripts on site to improve the page load time. It can be downloaded from <a href="https://wordpress.org/plugins/bwp-minify/" target="_blank">here</a>. When this plugin is active, go to its settings &gt; Manage enqueued Files. Select three files mentioned below:
- google-clustering
- location_script
- google-maps-apiscript Select them and choose action "Say at position". Save the Changes.</li>
	<li><strong>Google page speed:</strong> If you really wish to go in detail, <a href="https://developers.google.com/speed/pagespeed/insights">Google Page Speed</a> is a very good site analysis tool that will tell you exactly how you can improve your site speed.</li>
	<li>For the error: <strong>The following cacheable resources have a short freshness lifetime. Specify an expiration at least one week in the future for the following resources </strong>(80997)<strong>
</strong>This is the code you need to add in your .htaccess file:&nbsp;
<div>## EXPIRES CACHING ##</div>
<div>&lt;IfModule mod_expires.c&gt;</div>
<div>ExpiresActive On</div>
<div>ExpiresByType image/jpg "access plus 1 year"</div>
<div>ExpiresByType image/jpeg "access plus 1 year"</div>
<div>ExpiresByType image/gif "access plus 1 year"</div>
<div>ExpiresByType image/png "access plus 1 year"</div>
<div>ExpiresByType text/css "access plus 1 month"</div>
<div>ExpiresByType application/pdf "access plus 1 month"</div>
<div>ExpiresByType text/x-javascript "access plus 1 month"</div>
<div>ExpiresByType application/x-shockwave-flash "access plus 1 month"</div>
<div>ExpiresByType image/x-icon "access plus 1 year"</div>
<div>ExpiresDefault "access plus 2 days"</div>
<div>&lt;/IfModule&gt;</div>
## EXPIRES CACHING ##</li>
</ul>
The above mentioned reasons are quite in brief just to make you aware with the actual problems, so to have a detailed description &amp; guideline on each of them, please have a look at the below given articles.
<ol>
	<li><a href="http://www.wpexplorer.com/how-to-speed-up-wordpress/" target="_blank">http://www.eugenoprea.com/increase-wordpress-site-speed/</a></li>
	<li><a href="http://www.socialmediaexaminer.com/improve-the-speed-of-your-wordpress-site/" target="_blank">www.socialmediaexaminer.com/improve-the-speed-of-your-wordpress-site/</a></li>
	<li><a href="http://www.wpexplorer.com/how-to-speed-up-wordpress/" target="_blank">http://www.wpexplorer.com/how-to-speed-up-wordpress/</a></li>
</ol>
Hope this helps.',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('News','Directory'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//"


function tmpl_splendor_insert_rating($post_id,$comment_id ){
	global $wpdb;
	
	$wpdb->query("INSERT INTO `listingschild`.`wp_ratings` (`rating_id`, `rating_postid`, `rating_posttitle`, `rating_rating`, `rating_timestamp`, `rating_ip`, `rating_host`, `rating_username`, `rating_userid`, `comment_id`) VALUES (NULL, '".$post_id."', 'Awesome', '3', '".date('Y-m-d')."', '127.0.0.1', 'localhost', 'admin', '1', '".$comment_id."')");
}

tmpl_splendor_insert_posts($post_info);
function tmpl_splendor_insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_id = $post_info[$i]['ID'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			$post_meta = $post_info_arr['post_meta'];
			$data = array(
				'comment_post_ID' => $last_postid,
				'comment_author' => 'admin',
				'comment_author_email' => get_option('admin_email'),
				'comment_author_url' => 'http://',
				'comment_content' => $post_info_arr['post_title'].'its amazing.',
				'comment_type' => '',
				'comment_parent' => 0,
				'user_id' => $current_user->ID,
				'comment_author_IP' => '127.0.0.1',
				'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
				'comment_date' => $time,
				'comment_approved' => 1,
			);

			wp_insert_comment($data);
			$insert_id = $wpdb->insert_id;
			tmpl_splendor_insert_rating($post_id,$comment_id );
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			tmpl_listings_upload_image($last_postid,$post_image);
			
		}
	}
}

//=============================PAGES ENTRY START=======================================================//
$post_info = array();
$pages_array = array(array('Archives','Contact','Home','Blog','About'));
$page_info_arr = array();
$page_meta = array('_wp_page_template'=>'page-templates/archives.php', 'tl_dummy_content' => 1);
$page_info_arr[] = array('post_title'=>'Archives',
						'post_content'=>'This is Archives page template. Just select it from page templates section and you&rsquo;re good to go.',
						'post_meta'=>$page_meta);
						
$page_meta = array( 'tl_dummy_content' => 1,'_wp_page_template'=>'page-templates/contact-us.php');
$page_info_arr[] = array('post_title'=>'Contact',
						'post_content'=>'<p>Contact Us page is listed at Page section in to backend. Different widgets areas for this page are: Contact Page – Main Content and Contact Page Sidebar<p><p>Address on Google map can be changed from the Contact Page – Main Content -> T – Google Map Location widet. Similarly, T – Contact Us widget is used to show the form. Captcha can be enabled.</p><p>Mail on the Contact Us page is sent to the mail ID provided into WordPress General Settings -> Email field.</p>',
						'post_meta'=>$page_meta);
$page_meta = array( 'tl_dummy_content' => 1);
$page_meta = array('_wp_page_template'=>'page-templates/front-page.php','Layout'=>'default'); 
$page_info_arr[] = array('post_title'=>'Home',
						'post_content'=>'',
						'comment_status'=>'closed',
						'post_meta'=> $page_meta);

$page_meta = array('_wp_page_template'=>'page-templates/full-page-map.php','Layout'=>'default'); 
$page_info_arr[] = array('post_title'=>'All In One Map',
						'post_content'=>"[tevolution_listings_map post_type='listing'   zoom_level='5'  latitude='40.46800769694572'  longitude='-101.42762075195316' clustering=1][/tevolution_listings_map]",
						'comment_status'=>'closed',
						'post_meta'=> $page_meta);
						

$page_meta = array('tl_dummy_content'=>'1','Layout'=>'default'); 
$page_info_arr[] = array('post_title'=>'About',
						'post_content'=>'<p>This is the \'About\' page which you can use to write some description about your website. This would be a good place to advertise your hotels directory and talk about the available services, packages and user and listing owner features.</p> 

<p>This is usually a popular page on websites so it\'s also a good idea to pay attention to its SEO. After writing your content for this page, don\'t forget to also fill in all the Meta fields for the page.</p>',
						'comment_status'=>'closed',
						'post_meta'=> $page_meta);
						
$page_meta = array('tl_dummy_content'=>'1','Layout'=>'default'); 
$page_info_arr[] = array('post_title'=>'People',
						'post_content'=>"[tevolution_author_list role='subscriber' users_per_page='8'][/tevolution_author_list]",
						'comment_status'=>'closed',
						'post_meta'=> $page_meta);
						
$page_meta = array('tl_dummy_content'=>'1','Layout'=>'default','page_for_posts'=>1); 
$page_info_arr[] = array('post_title'=>'Blog',
						'post_content'=>"",
						'comment_status'=>'closed',
						'post_meta'=> $page_meta);
						
$page_meta = array('tl_dummy_content'=>'1','Layout'=>'default'); 
$page_info_arr[] = array('post_title'=>'How to setup your site',
						 'post_name' => 'how-to-setup-your-site',
						'post_content'=> 'We highly recommend that you go through this <a href="http://templatic.com/docs/directory-theme-guide/">documentation guide</a> for the Directory theme. Please also refer to the links on this <a href="http://templatic.com/docs/directory-guides/">page </a>for the detailed documentation of the whole Directory platform.
<h3><a href="http://templatic.com/docs/directory-theme-guide/#basic-setup">Basic setup of your Directory website</a></h3>
Please visit <a href="http://templatic.com/docs/directory-theme-guide/#basic-setup">this section</a> of the guide for more information on how to do some basic settings like configuring permalinks, changing your site logo, etc.
<h3><a href="http://templatic.com/docs/directory-theme-guide/#translating">How to translate Directory?</a></h3>
Directory can be translated using Poedit software. The files you should be using for translating are located inside the /wp-content/themes/Directory/languages folder. Use the en_US.po file to translate the front-end strings and admin-en_US.po to translate the back-end strings.

Those are “global” PO files and contain strings from each of the 4 Directory components. If you want, you can also translate each individual component by opening the “languages” folder inside each plugin (and the theme). For detailed instructions on translating the PO file open the following article.

Quick tip: For displaying Directory in multiple languages you will need to purchase and install the WPML plugin.
<h3><a href="http://templatic.com/docs/how-to-speed-up-your-directory-website/">How to speed up your Directory website</a></h3>
Directory is a massive application like theme so it will need more resources compared to some other simple portfolio or business WordPress themes. You may find it working a little slow if you have a lot of content and you are on a shared server. However, we have listed down some methods using which you can improvise performance of your Directory website. Please go through <a href="http://templatic.com/docs/how-to-speed-up-your-directory-website/"><strong>this article</strong></a> for more details on this.
<h3><a href="http://templatic.com/docs/customizing-directory/">How to customize Directory?</a></h3>
If you are a developer and want to customize Directory we recommend to read <a href="http://templatic.com/docs/customizing-directory/"><strong>this article</strong></a> once, we are sure it will help
<h2>Frequently Asked Questions</h2>
<h3><a href="http://templatic.com/docs/directory-theme-guide/#megamenu">How to create a demo site like megamenu?</a></h3>
<h3><a href="http://templatic.com/docs/directory-theme-guide/#social-login">How to enable social login through Facebook, Twitter, etc?</a></h3>
<h3><a href="http://templatic.com/docs/directory-theme-guide/#seo-settings">How to configure SEO settings?</a></h3>
<h3><a href="http://templatic.com/docs/directory-theme-guide/#clear-cache">Why aren\'t changes to my custom fields showing?</a></h3>
<strong>Note</strong>: If you run into any problems while using the theme do not hesitate to ask for help on our <a href="http://templatic.com/forums/viewforum.php?f=140">support forum</a>.',
						'comment_status'=>'closed',
						'post_meta'=> $page_meta);
						
$page_meta = array('tl_dummy_content'=>'1','Layout'=>'default'); 
$page_info_arr[] = array('post_title'=>'Extend',
						 'post_name' => 'extend',
						'post_content'=> 'You can extend your Directory website by using a wide range of add-ons that we offer, see the list of add-ons:
<h3><a href="http://templatic.com/directory-add-ons/wp-events-directory">Events</a></h3>
Turn your Directory into an events portal where event organizers can submit event listings. Just like the regular listings, you will be able to charge for event submissions and monetize your site even further.

<h3><a href="http://templatic.com/directory-add-ons/tevolution-fields-monetization">Fields Monetization</a></h3>
Control which listing packages get what fields with this amazing add-on. As admin, you setup packages that can have exactly the fields you wish to offer on each of them. As well as being able to limit the number of categories a listing can be submitted to, you can also limit the number of images that can be uploaded per listing. A great tool which can encourage people to go for a higher package that has more fields so they can add more content and details on their listings.

<h3><a href="http://templatic.com/directory-add-ons/star-rating-plugin-multirating">Multi Rating</a></h3>
Allow visitors to leave category-specific multiple ratings with their reviews on listings. As admin, you can specify more than one rating option on listings. This means a person can for example rate a listing based on quality, friendliness of staff, hygiene and service. Customize it to add whatever ratings you wish to let users rate listing by.

<h3><a href="http://templatic.com/directory-add-ons/tevolution-plugin-admin-dashboard">Admin Dashboard</a></h3>
Makes your life as admin more easier with extremely useful dashboard widgets. Get more information on your site\'s performance.

<h3><a href="http://templatic.com/directory-add-ons/templatic-admanager-wordpress-plugin">Ad Manager</a></h3>
A powerful banner management system which lets you display ads on your pages, posts and listings. Banners can be city, category or listing-specific with many banner location available. Ad Manager also offers banner rotation so you can basically offer the same ad space more than once and make an even bigger profit.

<h3><a href="http://templatic.com/directory-add-ons/duplicatepostalert-listings-theme-plugin">Duplicate Post Alert</a></h3>
Provides a verification on submitted listing titles and refuses new listing titles if the same title already exists. A useful tool if you wish to keep each listing on your directory unique with no repeated titles.

<h3><a href="http://templatic.com/directory-add-ons/real-estate">Directory Real Estate</a></h3>
Turn your Directory theme into a fully fledged real estate classifieds portal. Allow agents and property owners to submit property listings on free or paid listing plans. As well as search by price, number of bedrooms and bathrooms, the add-on offers many amazing functions.

<h3><a href="http://templatic.com/directory-add-ons/listing-vouchers">Listing Vouchers</a></h3>
Allow listing owners to upload a voucher or coupon to their listings. This offers your users an extra option to benefit more from their listing on your directory.

<h3><a href="http://templatic.com/directory-add-ons/tabs-manager">Tabs Manager</a></h3>
Create new custom fields and have them appear as extra tabs above listing descriptions. This offers you as admin more control over how you wish to organize the submission form and listing detail pages.

<h3><a href="http://templatic.com/directory-add-ons/header-fields">Header Fields</a></h3>
As well as the default header fields such as Phone, Website and Time, create and assign new custom fields to appear in the same area. This is a great tool if you wish to provide your visitors a clearer format so they can quickly spot each listing\'s short details.

<h3><a href="http://templatic.com/directory-add-ons/listing-badges">Listing Badges</a></h3>
You as admin can place custom color labels with a unique text on listings to highlight them.

<h3><a href="http://templatic.com/directory-add-ons/proximity-search">Proximity Search</a></h3>
Allow users on your site to quickly find listings by ZIP/Post codes. The add-on works in any country so it\'s an ideal tool which gives your listings directory that extra edge over the competition.

<h3><a href="http://templatic.com/directory-add-ons/wysiwyg-submission">WYSIWYG Submission</a></h3>
Use this add-on to enable a totally unique way of submitting listings and speed up the submission process and earning power of your site. This add-on will let listing submitters see an almost live preview of their content as they submit it.

<h3><a href="http://templatic.com/directory-add-ons/category-icons">Category Icons</a></h3>
Show custom icons next to each category on your listings directory to give your site its unique identity. This add-on offers a great way to give each of your categories their own styling and helps users visually navigate around your site.


<h3><a href="http://templatic.com/directory-add-ons/global-location">Global Location</a></h3>
Show all listings on your homepage without your users having to first select a city. This add-on lets you as admin create a new location which will become the first one your visitors will land on when they visit your site.


<h3><a href="http://templatic.com/directory-add-ons/map-customizer">Map Customizer</a></h3>
Customize your directory\'s Google map color scheme to match your site\'s design. A useful tool to give your listings directory its own unique identity and make it stand out from the rest.',
						'comment_status'=>'closed',
						'post_meta'=> $page_meta);


tmpl_splendor_set_page_info_autorun($pages_array,$page_info_arr);


//Sidebar widget settings: start
$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
$sidebars_widgets = array();
//==============================HEADER WIDGET AREA SETTINGS START=========================//
//Search widget settings start

$flag=0;
if ( is_plugin_active( 'Tevolution-LocationManager/location-manager.php' ) ) {
	$flag=1;
	$myarray['search_in_city']=array('search_in_city');
}
$search_criteria_values=array('cats','tags','category','post_excerpt','address');

$directory_search_location = array();
$directory_search_location[1] = array(
					"title"				=>	'',
					"post_type"			=>	array('listing'),
					"search_criteria"	=> 	$search_criteria_values,
					"miles_search"		=>	0,
					"radius_measure"	=>	'kilometer',
					);
					
if($flag==1):
$directory_search_location[1]=array_merge($directory_search_location[1],$myarray);
endif;					
	
$directory_search_location['_multiwidget'] = '1';
update_option('widget_directory_search_location', $directory_search_location);
$directory_search_location = get_option('widget_directory_search_location');
krsort($directory_search_location);
foreach($directory_search_location as $key1=>$val1)
{
	$directory_search_location_key1 = $key1;
	if(is_int($directory_search_location_key1))
	{
		break;
	}
}
//Search widget settings end
$sidebars_widgets["secondary_navigation_right"] = array("directory_search_location-{$directory_search_location_key1}");

//==============================HEADER WIDGET AREA SETTINGS END=========================//


/* Navigation right Widget area */
	$templatic_text = array();
	$templatic_text[1] = array(
					"title"			=>	'',
					"text"		=>	'<a class="submit-small-button button" href="'.site_url().'/submit-listing">Add Hotel</a>',
					);						
	$templatic_text['_multiwidget'] = '1';
	update_option('widget_templatic_text',$templatic_text);
	$templatic_text = get_option('widget_templatic_text');
	krsort($templatic_text);
	foreach($templatic_text as $key=>$val)
	{
		$templatic_text_key1 = $key;
		if(is_int($templatic_text_key1))
		{
			break;
		}
	}

$sidebars_widgets["menu-right"] = array("templatic_text-{$templatic_text_key1}");
/* Navigation right Widget area end */


/* Home page banner widget area - search widget */

	$supreme_banner_slider = array();
	$supreme_banner_slider[1] = array(
						"title"	=>	'',
						"sdesc"	=>	'',
						"animation"	=>	'fade',
						"autoplay"	=>	'true',
						"sliding_direction"	=>	'horizontal',
						"reverse"	=>	'true',
						"slideshowSpeed"	=>	4700,
						"animation_speed"	=>	800,
						"post_type"	=>	'',
						"number"	=>	'',
						"content_len"	=>	'',
						"content"	=>	'',
						"custom_banner_temp"	=>	1,
						"s1_title"	=>	array("","",""),
						"s1_title_link"	=>	array('#','#','#'),
						"s1"	=>	array(get_stylesheet_directory_uri().'/images/banner/main-banner-1.jpg',get_stylesheet_directory_uri().'/images/banner/main-banner-2.jpg',get_stylesheet_directory_uri().'/images/banner/main-banner-3.jpg')
						);
	$supreme_banner_slider['_multiwidget'] = '1';
	update_option('widget_supreme_banner_slider',$supreme_banner_slider);
	$supreme_banner_slider = get_option('widget_supreme_banner_slider');
	krsort($supreme_banner_slider);
	foreach($supreme_banner_slider as $key=>$val1)
	{
		$supreme_banner_slider_key = $key;
		if(is_int($supreme_banner_slider_key))
		{
			break;
		}
	}


	$directory_search_location[2] = array(
						"title"				=>	__('Where do you want to go today?','templatic-admin'),
						"post_type"			=>	array('listing'),
						"search_criteria"	=> 	$search_criteria_values,
						"miles_search"		=>	0,
						"radius_measure"	=>	'kilometer',
						);

	if($flag==1):
		$directory_search_location[2]=array_merge($directory_search_location[2],$myarray);
	endif;
						
	$directory_search_location['_multiwidget'] = '1';
	update_option('widget_directory_search_location', $directory_search_location);
	$directory_search_location = get_option('widget_directory_search_location');
	krsort($directory_search_location);
	foreach($directory_search_location as $key1=>$val1)
	{
		$directory_search_location_key1 = $key1;
		if(is_int($directory_search_location_key1))
		{
			break;
		}
	}

$sidebars_widgets["home-page-banner"] = array("supreme_banner_slider-{$supreme_banner_slider_key}","directory_search_location-{$directory_search_location_key1}");

/* Home page banner widget area - search widget end */

/* Homepage - Main Content 1  start */

$topcities = array();
$topcities[1] = array(
				'title'		=>	__('Top Cities','templatic'),
				'cities'			=> array('7','8','9','1','5','6'),
				);						
$topcities['_multiwidget'] = '1';
update_option('widget_tmpl_splendor_cities_list',$topcities);
$topcities = get_option('widget_tmpl_splendor_cities_list');
krsort($topcities);
foreach($topcities as $key=>$val)
{
	$widget_tmpl_splendor_cities_list_key = $key;
	if(is_int($widget_tmpl_splendor_cities_list_key))
	{
		break;
	}
}


$sidebars_widgets["homepage-content-one"] = array("tmpl_splendor_cities_list-{$widget_tmpl_splendor_cities_list_key}");
	
/* Homepage - Main Content 1  end */

/* Homepage - Main Content 2  start */
$cat_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_name like 'category' and post_type='custom_fields' and post_status='publish' limit 0,1");
$multycity_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_name like 'post_city_id' and post_type='custom_fields' and post_status='publish' limit 0,1");
$address_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_name like 'address' and post_type='custom_fields' and post_status='publish' limit 0,1");
$amenitie_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_name like 'amenitie' and post_type='custom_fields' and post_status='publish' limit 0,1");

$advancesearch = array();
$advancesearch[1] = array(
				"title"						=>	'Search Your Hotels',
				"post_type"					=>	'listing',
				"orderby_customfields"		=>	array($cat_id, $multycity_id, $address_id, $amenitie_id ),
				);						
$advancesearch['_multiwidget'] = '1';
update_option('widget_templatic_advanced_search',$advancesearch);
$advancesearch = get_option('widget_templatic_advanced_search');
krsort($advancesearch);
foreach($advancesearch as $key=>$val)
{
	$widget_templatic_advanced_search_key = $key;
	if(is_int($widget_templatic_advanced_search_key))
	{
		break;
	}
}
//Advanced search end


$sidebars_widgets["homepage-content-two"] = array("templatic_advanced_search-{$widget_templatic_advanced_search_key}");
	
/* Homepage - Main Content 2  end */


/* Homepage - Above Main Content Left   start */

/* hompage display post */
$directory_featured_homepage_listing = array();
$directory_featured_homepage_listing[1] = array(
				"title"					=>	'How to set Featured Listings?',
				"text"					=>	'Check this link',
				"link"					=>	'https://templatic.com/docs/directory-theme-guide/?q=Directory#feature-a-listing',
				"number"				=>	6,
				"view"					=>	'grid',
				"post_type"				=>	'listing',
				"category"				=>	'',
				"sorting_options"		=>  'featured_first'
				);						
$directory_featured_homepage_listing['_multiwidget'] = '1';
update_option('widget_directory_featured_homepage_listing',$directory_featured_homepage_listing);
$directory_featured_homepage_listing = get_option('widget_directory_featured_homepage_listing');
krsort($directory_featured_homepage_listing);
foreach($directory_featured_homepage_listing as $key=>$val)
{
	$directory_featured_homepage_listing_key1 = $key;
	if(is_int($directory_featured_homepage_listing_key1))
	{
		break;
	}
}

$sidebars_widgets["homepage-above-main-left"] = array("directory_featured_homepage_listing-{$directory_featured_homepage_listing_key1}");

/* Homepage - Above Main Content Left  end */

/* Homepage - Above Main Content  right  start */

/* Advertisement widget settings */
$templatic_text[2] = array(
				"title"	=>	'',
				"text"	=>	'<div class="border_ad_banner">
								<a href="http://templatic.com/products/wordpress-responsive-listings-directory-theme/" target="blank">
									<img align="middle" src="http://demo.templatic.com/splendor/images/splendor.jpg">
								</a>
							</div>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key4 = $key;
	if(is_int($templatic_text_key4))
	{
		break;
	}
}

/* Advertisement widget settings start */
$templatic_text[3] = array(
				"title"	=>	'',
				"text"	=>	'<ul class="squere_ads">
								<li><a href="http://templatic.com/docs/directory-theme-guide/">
									<img align="middle" src="'.get_stylesheet_directory_uri().'/images/ad-squar.jpg"></a></li>
								<li><a href="http://templatic.com/docs/directory-theme-guide/">
									<img align="middle" src="'.get_stylesheet_directory_uri().'/images/ad-squar.jpg"></a></li>
							 </ul>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key5 = $key;
	if(is_int($templatic_text_key5))
	{
		break;
	}
}

$sidebars_widgets["homepage-above-main-right"] = array("templatic_text-{$templatic_text_key4}","templatic_text-{$templatic_text_key5}");
	
/* Homepage - Above Main Content Left  end */

/* homepage main content start */

/* T → Featured Listings For Home Page widget settings start */
$directory_featured_homepage_listing[2] = array(
				"title"					=>	'Popular Listings',
				"text"					=>	'View All Listings',
				"link"					=>	site_url().'/listing/',
				"number"				=>	3,
				"view"					=>	'list',
				"post_type"				=>	'listing',
				"category"				=>	'',
				"sorting_options"		=>  'featured_first',
				"content_limit"			=>  50,
				);						
$directory_featured_homepage_listing['_multiwidget'] = '1';
update_option('widget_directory_featured_homepage_listing',$directory_featured_homepage_listing);
$directory_featured_homepage_listing = get_option('widget_directory_featured_homepage_listing');
krsort($directory_featured_homepage_listing);
foreach($directory_featured_homepage_listing as $key=>$val)
{
	$directory_featured_homepage_listing_key1 = $key;
	if(is_int($directory_featured_homepage_listing_key1))
	{
		break;
	}
}

/* ad widget */
$templatic_text[4] = array(
					"title"		=>	'',
					"text"		=>	'<div class="advertising-section"><a href="#"><img src="'.get_stylesheet_directory_uri().'/images/ad-banner.jpg" alt="Your Advertising Banner Here" /></a></div>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key3=>$val3)
{
	$templatic_text_key3 = $key3;
	if(is_int($templatic_text_key3))
	{
		break;
	}
}

$sidebars_widgets["home-page-content"] = array("directory_featured_homepage_listing-{$directory_featured_homepage_listing_key1}","templatic_text-{$templatic_text_key3}");

/* Homepage - Below Main Content start */

$templatic_text[5] = array(
					"title"		=>	'Submit your hotels under the best offers',
					"text"		=>	'<div class="pricing-block-wrap">
	<div class="pricing-wrap">
		<div class="pricing-inner-wrap">
			<h2>Platinum</h2>
			<div class="price-block">
				<span>$29/</span>
				<b>month</b>
			</div>
			<div class="pricing-list">
				<ul>
					<li><b>Check out this Usefull links</b></li>
					<li><a href="https://templatic.com/docs/directory-theme-guide/?q=Directory#monetization">Monetization & Price Packages</a></li>
					<li><a href="https://templatic.com/docs/tevolution-guide/?q=tevolution#new-price-packages">How to create different pricing table?</a></li>
					<li><a href="https://templatic.com/docs/directory-theme-guide/?q=Directory#feature-a-listing">How to make a specific listing featured?</a></li>
				</ul>	
			</div>
			<a class="button" href="'.$submiturl.'/?pkg_id='.$packages[0].'">Get Started Now</a>
		</div>
	</div>
	<div class="pricing-wrap">
		<div class="pricing-inner-wrap">
			<h2>Silver Package</h2>
			<div class="price-block">
				<span>$10/</span>
				<b>month</b>
			</div>
			<div class="pricing-list">
				<ul>
					<li><b>Display Map & Street View</b></li>
					<li>Post Video & Image Gallery</li>
					<li>Display Hours Of Business</li>
					<li>Post Video & Image Gallery</li>
				</ul>
			</div>
			<a class="button" href="'.$submiturl.'/?pkg_id='.$packages[1].'">Get Started Now</a>
		</div>
	</div>
	<div class="pricing-wrap">
		<div class="pricing-inner-wrap">
			<h2>Gold Package</h2>
			<div class="price-block">
				<span>$16/</span>
				<b>month</b>
			</div>
			<div class="pricing-list">
				<ul>
					<li>Display Map & Street View</li>
					<li>Post Video & Image Gallery</li>
					<li>Display Hours Of Business</li>
					<li>Add Custom Field</li>
					<li>Post Video & Image Gallery</li>
				</ul>
			</div>
			<a class="button" href="'.$submiturl.'/?pkg_id='.$packages[2].'">Get Started Now</a>
		</div>
	</div>
</div>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key3=>$val3)
{
	$templatic_text_key3 = $key3;
	if(is_int($templatic_text_key3))
	{
		break;
	}
}

$sidebars_widgets["homepage-below-main"] = array("templatic_text-{$templatic_text_key3}");
/* Homepage - Below Main Content end */

/* Homepage - Above footer start */

/* ad widget */
$testimonials = array();
$testimonials[6] = array(
					'title'		=> 'Testimonials',
					'quotetext' => array('Templatic offers world class WordPress theme support and unique, highly innovative and professionally useful WordPress themes. So glad to have found you! All the best and many more years of creativity, productivity and success.','Templatic has the best WordPress Themes and an exceptional and out-of-this-world customer service. I always receive a response in less than 24 hours, sometimes in less than one hour, this is amazing. I will recommend it to all my friends. Keep up the good work!','Templatic is reliable, it has a good support, and very accurate. Beside that, it has a big community of members who contribute.'),
					'author' => array('Catherine','Jack','Samantha'),
					'auth_email' => array('Drat5512@dayrep.com','QWithated6474@dayrep.com','TFlonight55@gustr.com'),
				);						
$testimonials['_multiwidget'] = '1';
update_option('widget_tmpl_splendor_testimonials_widget',$testimonials);
$testimonials = get_option('widget_tmpl_splendor_testimonials_widget');
krsort($testimonials);
foreach($testimonials as $key3=>$val3)
{
	$tmpl_splendor_testimonials_widget_key3 = $key3;
	if(is_int($tmpl_splendor_testimonials_widget_key3))
	{
		break;
	}
}

$sidebars_widgets["above-homepage-footer"] = array("tmpl_splendor_testimonials_widget-{$tmpl_splendor_testimonials_widget_key3}");


/* Homepage - Above footer end */

/* FOOTER WIDGET AREA SETTING START */

/* Pages start */
$hybrid_pages = array();
$hybrid_pages[1] = array(
				"title"				=>	'Discover',
				"post_type"			=>	'page',
				"sort_order"		=>	'DESC',
				"sort_column"		=>	'post_title',
				"depth"				=>	0,
				"number"			=>	4,
				"offset"			=>	'',
				"child_of"			=>	'',
				"include"			=>	'',
				"exclude"			=>	'',
				"exclude_tree"		=>	'',
				"meta_key"			=>	'',
				"meta_value"		=>	'',
				"authors"			=>	'',
				"link_before"		=>	'',
				"link_after"		=>	'',
				"show_date"			=>	'',
				"date_format"		=>	'F j, Y',
				"hierarchical"		=>	1,
				);						
$hybrid_pages['_multiwidget'] = '1';
update_option('widget_hybrid-pages',$hybrid_pages);
$hybrid_pages = get_option('widget_hybrid-pages');
krsort($hybrid_pages);
foreach($hybrid_pages as $key1=>$val1)
{
	$hybrid_pages_key1 = $key1;
	if(is_int($hybrid_pages_key1))
	{
		break;
	}
}

$hybrid_pages[2] = array(
				"title"				=>	'About',
				"post_type"			=>	'page',
				"sort_order"		=>	'ASC',
				"sort_column"		=>	'post_title',
				"depth"				=>	0,
				"number"			=>	4,
				"offset"			=>	'',
				"child_of"			=>	'',
				"include"			=>	'',
				"exclude"			=>	'',
				"exclude_tree"		=>	'',
				"meta_key"			=>	'',
				"meta_value"		=>	'',
				"authors"			=>	'',
				"link_before"		=>	'',
				"link_after"		=>	'',
				"show_date"			=>	'',
				"date_format"		=>	'F j, Y',
				"hierarchical"		=>	1,
				);						
$hybrid_pages['_multiwidget'] = '1';
update_option('widget_hybrid-pages',$hybrid_pages);
$hybrid_pages = get_option('widget_hybrid-pages');
krsort($hybrid_pages);
foreach($hybrid_pages as $key2=>$val2)
{
	$hybrid_pages_key2 = $key2;
	if(is_int($hybrid_pages_key2))
	{
		break;
	}
}

/* Newsletter subscribe widget settings start */
	$supreme_subscriber_widget = array();
	$supreme_subscriber_widget[1] = array(
					"title"					=>	__('Subscribe to our newsletter','templatic'),
					"text"					=>	__('Join today to receive the latest offers from the world\'s finest hotels.','templatic'),
					"newsletter_provider"	=>	'feedburner',
					"feedburner_id"			=>	'',
					"mailchimp_api_key"		=>	'',
					"mailchimp_list_id"		=>	'',
					"feedblitz_list_id"		=>	'',
					"aweber_list_name"		=>	'',
					);						
	$supreme_subscriber_widget['_multiwidget'] = '1';
	update_option('widget_supreme_subscriber_widget',$supreme_subscriber_widget);
	$supreme_subscriber_widget = get_option('widget_supreme_subscriber_widget');
	krsort($supreme_subscriber_widget);
	foreach($supreme_subscriber_widget as $key=>$val)
	{
		$supreme_subscriber_widget_key = $key;
		if(is_int($supreme_subscriber_widget_key))
		{
			break;
		}
	}
/* Newsletter subscribe widget settings start */

/* text widget settings start */
$templatic_text[6] = array(
					"title"		=>	'Contact us',
					"text"		=>	'<div class="contact-info">
	<ul>
		<li>
			<i class="fa fa-map-marker"></i>
			<p>8871 Spruce Street, <br>Elizabeth City, NC 27909</p>
		</li>
		<li>
			<i class="fa fa-phone"></i>
			<p>+123 456789</p>
		</li>
		<li>
			<i class="fa fa-envelope-o"></i>
			<p>contact@yoursite.com</p>
		</li>
	</ul>
</div>

<div class="footer-social-icon">
	<ul>
		<li>
			<a href="#">
				<i class="fa fa-facebook"></i>
			</a>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-twitter"></i>
			</a>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-google-plus"></i>
			</a>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-pinterest-p"></i>
			</a>
		</li>
	</ul>
</div>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key1 = $key;
	if(is_int($templatic_text_key1))
	{
		break;
	}
}
/* text widget settings end */

$sidebars_widgets["footer"] = array("templatic_text-{$templatic_text_key1}","hybrid-pages-{$hybrid_pages_key1}","hybrid-pages-{$hybrid_pages_key2}","supreme_subscriber_widget-{$supreme_subscriber_widget_key}");
/* FOOTER WIDGET AREA SETTING END */

/* FRONT PAGE SIDEBAR WIDGET AREA SETTING START */

//Browse by category widget settings start
$categories = array();
$categories[1] = array(
					"title"			=> __('Categories','templatic'),
					"taxonomy"		=> 'listingcategory',
					"post_type"		=> 'listing',
					"number"		=> 6,
					"show_count"	=> 1,
					"hide_empty"	=> 1,
					"style"			=> 'list'
				);						
$categories['_multiwidget'] = '1';
update_option('widget_hybrid-categories',$categories);
$categories = get_option('widget_hybrid-categories');
krsort($categories);
foreach($categories as $key=>$val)
{
	$widget_hybrid_categories_key = $key;
	if(is_int($widget_hybrid_categories_key))
	{
		break;
	}
}

//T → Popular Posts Widget settings start
$templatic_popular_post_technews = array();
$templatic_popular_post_technews[1] = array(
					"title"					=>	__('Popular Listings','templatic'),
					"post_type"				=>	'listing',
					"number"				=>	5,
					"slide"					=>	5,
					"popular_per"			=>	'comments',
					"pagination_position"	=>	0,
					);
$templatic_popular_post_technews['_multiwidget'] = '1';
update_option('widget_templatic_popular_post_technews',$templatic_popular_post_technews);
$templatic_popular_post_technews = get_option('widget_templatic_popular_post_technews');
krsort($templatic_popular_post_technews);
foreach($templatic_popular_post_technews as $key1=>$val1)
{
	$templatic_popular_post_technews_key1 = $key1;
	if(is_int($templatic_popular_post_technews_key1))
	{
		break;
	}
}

//advertisement widget settings end
$sidebars_widgets["front-page-sidebar"] = array("hybrid-categories-{$widget_hybrid_categories_key}","templatic_popular_post_technews-{$templatic_popular_post_technews_key1}");
/* FRONT PAGE SIDEBAR WIDGET AREA SETTING END */

/* LISTING DETAIL SIDEBAR WIDGET AREA SETTING END */
//T → In the neighborhood widget settings start

// detail page map widget start
$googlemap_diection = array();
$googlemap_diection[1] = array(
					"title" => __('View location on map','templatic'),
					"heigh"	=>	'380',
					);						
$googlemap_diection['_multiwidget'] = '1';
update_option('widget_widget_googlemap_diection_widget',$googlemap_diection);
$googlemap_diection = get_option('widget_widget_googlemap_diection_widget');
krsort($googlemap_diection);
foreach($googlemap_diection as $key1=>$val1)
{
	$googlemap_diection_widget_key1 = $key1;
	if(is_int($googlemap_diection_widget_key1))
	{
		break;
	}
}
// detail page map widget end

// author widget start
$tevolution_author_listing = array();
$tevolution_author_listing[1] = array(
					"title"		=>	__('Listing Owner','templatic'),
					"role"  	=>  'administrator',
					"no_user" 	=> 0,
					);						
$tevolution_author_listing['_multiwidget'] = '1';
update_option('widget_tmpllistingowner',$tevolution_author_listing);
$tevolution_author_listing = get_option('widget_tmpllistingowner');
krsort($tevolution_author_listing);
foreach($tevolution_author_listing as $key1=>$val1)
{
	$tevolution_author_listing_key1 = $key1;
	if(is_int($tevolution_author_listing_key1))
	{
		break;
	}
}
// author end

$directory_neighborhood = array();
$directory_neighborhood[1] = array(
					"title"					=>	__('Nearby Listings','templatic'),
					"post_type"				=>	'listing',
					"post_number"			=>	4,
					"content_limit"			=>	34,
					"show_list"				=>	0,
					"closer_factor"			=>	0,
					"radius"				=>	5000,
					"radius_measure"		=>	'miles',
					);						
$directory_neighborhood['_multiwidget'] = '1';
update_option('widget_directory_neighborhood',$directory_neighborhood);
$directory_neighborhood = get_option('widget_directory_neighborhood');
krsort($directory_neighborhood);
foreach($directory_neighborhood as $key1=>$val1)
{
	$directory_neighborhood_key1 = $key1;
	if(is_int($directory_neighborhood_key1))
	{
		break;
	}
}
//T → In the neighborhood widget settings end


//Advertisement widget settings start
$templatic_text[10] = array(
				"title"	=>	'',
				"text"	=>	'<div class="border_ad_banner"><a href="http://templatic.com"><img align="middle" src="http://demo.templatic.com/splendor/images/splendor.jpg"></a></div>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key4 = $key;
	if(is_int($templatic_text_key4))
	{
		break;
	}
}
//advertisement widget settings end
//Advertisement widget settings start
$templatic_text[11] = array(
				"title"	=>	'',
				"text"	=>	'<ul class="squere_ads">
								<li><a href="http://templatic.com/docs/directory-theme-guide/"><img align="middle" src="'.get_stylesheet_directory_uri().'/images/ad-squar.jpg"></a></li>
								<li><a href="http://templatic.com/docs/directory-theme-guide/"><img align="middle" src="'.get_stylesheet_directory_uri().'/images/ad-squar.jpg"></a></li>
								<li><a href="http://templatic.com/docs/directory-theme-guide/"><img align="middle" src="'.get_stylesheet_directory_uri().'/images/ad-squar.jpg"></a></li>
								<li><a href="http://templatic.com/docs/directory-theme-guide/"><img align="middle" src="'.get_stylesheet_directory_uri().'/images/ad-squar.jpg"></a></li>
							</ul>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key5 = $key;
	if(is_int($templatic_text_key5))
	{
		break;
	}
}
//advertisement widget settings end
$sidebars_widgets["listing_detail_sidebar"] = array("widget_googlemap_diection_widget-{$googlemap_diection_widget_key1}","tmpllistingowner-{$tevolution_author_listing_key1}","directory_neighborhood-{$directory_neighborhood_key1}","templatic_text-{$templatic_text_key4}","templatic_text-{$templatic_text_key5}");
/* LISTING DETAIL SIDEBAR WIDGET AREA SETTING END */

/* PRIMARY SIDEBAR WIDGET START */

//About Us widget settings start
$templatic_text[12] = array(
					"title"				=>	__('Submit your listing','templatic'),
					"text"			=>	__('Get maximum online exposure for your business by submitting a listing on our directory. Submit a listing and benefit from <b>thousands of visitors</b> our directory receives daily. Our directory can help you reach out to more people which means more interest in whatever you are promoting.','templatic'),
					);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key1=>$val1)
{
	$templatic_text_key3 = $key1;
	if(is_int($templatic_text_key3))
	{
		break;
	}
}
//About Us widget settings end

//Login widget settings start
$widget_login = array();
$widget_login[1] = array(
					"title"				=>	__('Dashboard','templatic'),
					"hierarchical"		=>	1,
					);						
$widget_login['_multiwidget'] = '1';
update_option('widget_widget_login',$widget_login);
$widget_login = get_option('widget_widget_login');
krsort($widget_login);
foreach($widget_login as $key1=>$val1)
{
	$widget_login_key1 = $key1;
	if(is_int($widget_login_key1))
	{
		break;
	}
}
//Login widget settings end
//Advertisement widget settings start
$templatic_text[13] = array(
				"title"	=>	'',
				"text"	=>	'<a href="http://templatic.com"><img align="middle" src="'.get_stylesheet_directory_uri().'/images/sidebar-ad-banner.jpg"></a>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key5 = $key;
	if(is_int($templatic_text_key5))
	{
		break;
	}
}
//advertisement widget settings end
$sidebars_widgets["primary-sidebar"] = array("templatic_text-{$templatic_text_key5}", "widget_login-{$widget_login_key1}","templatic_text-{$templatic_text_key3}");

/* LISTING SIDEBAR WIDGET AREA SETTING START */

//T → Search Near By Miles Range widget settings start
$directory_mile_range_widget = array();
$directory_mile_range_widget[1] = array(
					"title"				=>	__("Filter Listings By Miles",'templatic'),
					"max_range"			=>	500,
					"post_type"			=>	'listing',
					);						
$directory_mile_range_widget['_multiwidget'] = '1';
update_option('widget_directory_mile_range_widget',$directory_mile_range_widget);
$directory_mile_range_widget = get_option('widget_directory_mile_range_widget');
krsort($directory_mile_range_widget);
foreach($directory_mile_range_widget as $key1=>$val1)
{
	$directory_mile_range_widget_key = $key1;
	if(is_int($directory_mile_range_widget_key))
	{
		break;
	}
}
//T → Search Near By Miles Range widget settings end 

//Browse by category widget settings start
$categories[2] = array(
					"title"			=> __('Categories','templatic'),
					"taxonomy"		=> 'listingcategory',
					"post_type"		=> 'listing',
					"number"		=> 6,
					"show_count"	=> 1,
					"hide_empty"	=> 1,
					"style"			=> 'list'
				);						
$categories['_multiwidget'] = '1';
update_option('widget_hybrid-categories',$categories);
$categories = get_option('widget_hybrid-categories');
krsort($categories);
foreach($categories as $key=>$val)
{
	$widget_hybrid_categories_key = $key;
	if(is_int($widget_hybrid_categories_key))
	{
		break;
	}
}

//Browse by category widget settings end
//Advertisement widget settings start
$templatic_text[14] = array(
				"title"	=>	'',
				"text"	=>	'<a href="http://templatic.com/docs/directory-theme-guide/"><img align="middle" src="http://demo.templatic.com/splendor/images/splendor.jpg"></a>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key4 = $key;
	if(is_int($templatic_text_key4))
	{
		break;
	}
}

//Advanced search start

$advancesearch[3] = array(
				"title"						=>	'Search Listing',
				"post_type"					=>	'listing',
				"orderby_customfields"		=>	array($cat_id, $multycity_id, $address_id, $amenitie_id ),
				);						
$advancesearch['_multiwidget'] = '1';
update_option('widget_templatic_advanced_search',$advancesearch);
$advancesearch = get_option('widget_templatic_advanced_search');
krsort($advancesearch);
foreach($advancesearch as $key=>$val)
{
	$widget_templatic_advanced_search_key = $key;
	if(is_int($widget_templatic_advanced_search_key))
	{
		break;
	}
}
/* Advanced search end */

/* Dosplay authors */
$templatic_author = array();
$templatic_author[1] = array(
					"title"	  => __('Popular Author','templatic-admin'),
					"role"    => 'subscriber',
					"no_user" => 0,
				);						
$templatic_author['_multiwidget'] = '1';
update_option('widget_tevolution_author_listing',$templatic_author);
$templatic_author = get_option('widget_tevolution_author_listing');
krsort($templatic_author);
foreach($templatic_author as $key=>$val)
{
	$templatic_author_key = $key;
	if(is_int($templatic_author_key))
	{
		break;
	}
}

/* Dosplay authors end */

/* popular post  */
$popular_post = array();
$popular_post[1] = array(
					"title"	  	 	=> __('Popular Posts','templatic-admin'),
					"post_type"  	=> 'listing',
					"number" 	 	=> 10,
					"slide" 	 	=> 3,
					"popular_per"	=> 'views',
				);						
$popular_post['_multiwidget'] = '1';
update_option('widget_templatic_popular_post_technews',$popular_post);
$popular_post = get_option('widget_templatic_popular_post_technews');
krsort($popular_post);
foreach($popular_post as $key=>$val)
{
	$popular_post_key = $key;
	if(is_int($popular_post_key))
	{
		break;
	}
}

/*  popular post  end */


$sidebars_widgets["listingcategory_listing_sidebar"] = array("templatic_advanced_search-{$widget_templatic_advanced_search_key}", "directory_mile_range_widget-{$directory_mile_range_widget_key}","hybrid-categories-{$widget_hybrid_categories_key}","tevolution_author_listing-{$templatic_author_key}","templatic_popular_post_technews-{$popular_post_key}","templatic_text-{$templatic_text_key4}");
/* LISTING SIDEBAR WIDGET AREA SETTING END */

/*BEING Below header Listing category widget*/
/*Catgeory map widget. Place single city map if location manager is not activate */

if(is_plugin_active('Tevolution-LocationManager/location-manager.php')){
	$category_map = array();
	$category_map[1] = array("height"=>	585);						
	$category_map['_multiwidget'] = '1';
	update_option('widget_category_googlemap',$category_map);
	$category_map = get_option('widget_category_googlemap');
	krsort($category_map);
	foreach($category_map as $key1=>$val1)
	{
		$category_map_key1 = $key1;
		if(is_int($category_map_key1)){
			break;
		}
	}
$sidebars_widgets["after_directory_header"] = array("category_googlemap-{$category_map_key1}");	
}else{
	$category_map = array();
	$category_map[1] = array("height"=>	'585');						
	$category_map['_multiwidget'] = '1';
	update_option('widget_listingpagemap',$category_map);
	$category_map = get_option('widget_listingpagemap');
	krsort($category_map);
	foreach($category_map as $key1=>$val1)
	{
		$category_map_key1 = $key1;
		if(is_int($category_map_key1)){
			break;
		}
	}
$sidebars_widgets["after_directory_header"] = array("listingpagemap-{$category_map_key1}");	
}


/*END Below header Listing category widget*/

/* CONTACT PAGE WIDGET AREA START */

//Google map widget settings start
$templatic_google_map = array();
$templatic_google_map[1] = array(
					"title"			=>	'Find us on map',
					"address"		=>	'230 Vine Street And locations throughout Old City, Philadelphia, PA 19106',
					"map_height"	=>	400,
					);						
$templatic_google_map['_multiwidget'] = '1';
update_option('widget_templatic_google_map',$templatic_google_map);
$templatic_google_map = get_option('widget_templatic_google_map');
krsort($templatic_google_map);
foreach($templatic_google_map as $key1=>$val1)
{
	$templatic_google_map_key = $key1;
	if(is_int($templatic_google_map_key))
	{
		break;
	}
}

$supreme_contact_widget = array();
$supreme_contact_widget[1] = array(
					"title"			=>	'Contact Us',
					"address"		=>	'230 Vine Street And locations throughout Old City, Philadelphia, PA 19106',
					"map_height"	=>	400,
					);						
$supreme_contact_widget['_multiwidget'] = '1';
update_option('widget_supreme_contact_widget',$supreme_contact_widget);
$supreme_contact_widget = get_option('widget_supreme_contact_widget');
krsort($supreme_contact_widget);
foreach($supreme_contact_widget as $key1=>$val1)
{
	$supreme_contact_widget_key = $key1;
	if(is_int($supreme_contact_widget_key))
	{
		break;
	}
}
//Google map widget settings end

$sidebars_widgets["contact_page_widget"] = array("templatic_google_map-{$templatic_google_map_key}","supreme_contact_widget-{$supreme_contact_widget_key}");

/* CONTACT PAGE WIDGET AREA END */

/* CONTACT PAGE SIDEBAR WIDGET AREA */

//Facebook fan widget settings start
$supreme_facebook = array();
$supreme_facebook[1] = array(
					"facebook_page_url"		=>	'https://www.facebook.com/templatic',
					"width"					=>	270,
					"show_faces"			=>	1,
					"show_stream"			=>	1,
					"show_header"			=>	1,
					);						
$supreme_facebook['_multiwidget'] = '1';
update_option('widget_supreme_facebook',$supreme_facebook);
$supreme_facebook = get_option('widget_supreme_facebook');
krsort($supreme_facebook);
foreach($supreme_facebook as $key1=>$val1)
{
	$supreme_facebook_key1 = $key1;
	if(is_int($supreme_facebook_key1))
	{
		break;
	}
}
//Facebook fan widget settings end
//Advertisement widget settings start
$templatic_text[15] = array(
				"title"	=>	'',
				"text"	=>	'<a href="http://templatic.com"><img align="middle" src="'.get_stylesheet_directory_uri().'/images/sidebar-ad-banner.jpg"></a>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key5 = $key;
	if(is_int($templatic_text_key5))
	{
		break;
	}
}
//advertisement widget settings end
$sidebars_widgets["contact_page_sidebar"] = array("templatic_text-{$templatic_text_key5}","supreme_facebook-{$supreme_facebook_key1}");
/* CONTACT PAGE SIDEBAR WIDGET AREA END */

/* add listing sidebar widget start */

$templatic_text[16] = array(
				"title"	=>	'Submit your listing',
				"text"	=>	'Get maximum online exposure today by submitting a listing on our directory. Submit your listing and benefit from the <strong>thousands of daily visitors</strong> our directory receives. A listing on our directory will help you reach out to more people and that means more interest in whatever you are promoting.',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key5 = $key;
	if(is_int($templatic_text_key5))
	{
		break;
	}
}

$templatic_text[17] = array(
				"title"	=>	'100% Satisfaction Guaranteed',
				"text"	=>	'<p> If you´re not 100% satisfied with the results from your listing, request a full refund within 30 days after your listing expires. No questions asked. Promise.</p><p>See also our <a href="#">frequently asked questions. </a></p>',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key6 = $key;
	if(is_int($templatic_text_key6))
	{
		break;
	}
}

$templatic_text[18] = array(
				"title"	=>	'Payment Info',
				"text"	=>	'<p> $250 Premium Plus (60 days) </p><p> $75 Premium listing (30 days) </p><p> <img src="http://templatic.net/directory/wp-content/uploads/2013/07/vcards.gif" alt=""> </p><p> Visa, Mastercard, American Express, and Discover cards accepted </p>All major credit cards accepted. Payments are processed by PayPal but you do not need an account with PayPal to complete your transaction. (Contact us for any questions.)',
				);						
$templatic_text['_multiwidget'] = '1';
update_option('widget_templatic_text',$templatic_text);
$templatic_text = get_option('widget_templatic_text');
krsort($templatic_text);
foreach($templatic_text as $key=>$val)
{
	$templatic_text_key7 = $key;
	if(is_int($templatic_text_key7))
	{
		break;
	}
}

$sidebars_widgets["add_listing_submit_sidebar"] = array("templatic_text-{$templatic_text_key5}","templatic_text-{$templatic_text_key6}","templatic_text-{$templatic_text_key7}");
/* add listing sidebar widget end */

update_option('sidebars_widgets',$sidebars_widgets);  //save widget informations 

/*
 * upload property image from outside server
 */
function tmpl_listings_upload_image($post_id,$post_image){
	if($post_image)
	{
		for($m=0;$m<count($post_image);$m++){
			
	        $title = basename($post_image[$m]);
			
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	        // next, download the URL of the image
	        $upload = media_sideload_image($post_image[$m], $post_id, $title);
		}
	}

}

/* add user data */
global $current_user;

update_user_meta($current_user->ID,'description','The user profile description goes here. Each user can enter a unique profile from their user dashboard.'); /* add description of author */
update_user_meta($current_user->ID,'facebook','http://www.facebook.com');  /* add facebook url of author */
update_user_meta($current_user->ID,'twitter','http://www.twitter.com'); /* add twitter url of author */
update_user_meta($current_user->ID,'linkedin','http://www.linkedin.com'); /* add linkedin url of author */
update_user_meta($current_user->ID,'user_phone','91234567810'); /* add phone number of author */
/* EOF */
?>