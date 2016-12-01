<?php

// START of XSS code
 foreach (array('mkey[]','post_type','s','tevolution_sortby') as $vuln) {
	isset($_REQUEST[$vuln]) and $_REQUEST[$vuln] = html_entity_decode($_REQUEST[$vuln]);
	isset($_GET[$vuln])     and $_GET[$vuln]     = html_entity_decode($_GET[$vuln]);
	isset($_POST[$vuln])    and $_POST[$vuln]    = html_entity_decode($_POST[$vuln]);
	isset($$vuln)           and $$vuln           = html_entity_decode($$vuln);
}
// END of XSS code


function tmpl_searchfilter($query) 
{
     if ($query->query_vars[s])
     {
         $query->query_vars[s]=html_entity_decode($query->query_vars[s]);
     }
     if ($query->query_vars[paged])
     {
         $query->query_vars[paged]=html_entity_decode($query->query_vars[paged]);
     }
     return $query;
}
 
add_filter('pre_get_posts','tmpl_searchfilter');

/*
 Return the collection for category listing page
*/
function listing_fields_collection()
{
	global $wpdb,$post;
	remove_all_actions('posts_where');
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
			'key' => 'show_on_listing',
			'value' =>  '1',
			'compare' => '='
		)
	),
		'meta_key' => 'sort_order',
		'orderby' => 'meta_value',
		'order' => 'ASC'
	);
	$post_query = null;
	add_filter('posts_join', 'custom_field_posts_where_filter');
	$post_query = new WP_Query($args);
	remove_filter('posts_join', 'custom_field_posts_where_filter');
	return $post_query;
}
/* EOF */

/* This function wil return the custom fields of the post detail page */
function details_field_collection()
{
	global $wpdb,$post,$htmlvar_name;
	remove_all_actions('posts_where');
	remove_all_actions('posts_orderby');
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
	$post_meta_info = null;
	add_filter('posts_join', 'custom_field_posts_where_filter');
	$post_meta_info = new WP_Query($args);
	remove_filter('posts_join', 'custom_field_posts_where_filter');
	return $post_meta_info;
}
/* EOF */

/*
	Display the breadcrumb
*/
function the_breadcrumb() {
	if (!is_home()) {
		echo '<div class="breadcrumb"><a href="';
		echo get_option('home');
		echo '">'.__('Home','templatic');
		echo "</a>";
		if (is_category() || is_single() || is_archive()) {
			the_category('title_li=');
			if(is_archive())
			{		
				echo " » ";
				single_cat_title();
			}
			if (is_single()) {
				echo " » ";
				the_title();
			}
		} elseif (is_page()) {
			echo the_title();
		}		
		echo "</div>";
	}	
}

/* filtering for featured listing  start*/
if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/') && (!isset($_REQUEST['slider_search']) && @$_REQUEST['slider_search'] =='')){ 
	add_action('init', 'templ_featured_ordering');
}
function templ_featured_ordering(){
	add_filter('posts_orderby', 'feature_filter_order',99);
	add_filter('posts_where','tmpl_sort_by_character');
	add_filter('pre_get_posts', 'home_page_feature_listing');
	add_filter('posts_orderby', 'home_page_feature_listing_orderby');
}

/*
 * search by alphabetical
 */
function tmpl_sort_by_character($where){
	global $wpdb;	
	if(isset($_REQUEST['sortby']) && $_REQUEST['sortby']!=''){
		$where .= "  AND $wpdb->posts.post_title like '".$_REQUEST['sortby']."%'";
	}
	return $where;
}

/* featured posts filter for listing page */
function feature_filter_order($orderby){
	global $wpdb,$wp_query;
	
	if((is_category() || is_tax() || is_archive() || is_search()) && $wp_query->tax_query->queries[0]['taxonomy'] != 'product_cat'){
	
		if (isset($_REQUEST['tevolution_sortby']) && ($_REQUEST['tevolution_sortby'] == 'title_asc' || $_REQUEST['tevolution_sortby'] == 'alphabetical')){
			$orderby= "$wpdb->posts.post_title ASC,(select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c' AND $wpdb->postmeta.meta_value = 'c') ASC";
		}elseif (isset($_REQUEST['tevolution_sortby']) && $_REQUEST['tevolution_sortby'] == 'title_desc' ){
			$orderby = "$wpdb->posts.post_title DESC,(select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c' AND $wpdb->postmeta.meta_value = 'c') DESC";
		}elseif (isset($_REQUEST['tevolution_sortby']) && $_REQUEST['tevolution_sortby'] == 'date_asc' ){
			$orderby = "$wpdb->posts.post_date ASC,(select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c' AND $wpdb->postmeta.meta_value = 'c') DESC";
		}elseif (isset($_REQUEST['tevolution_sortby']) && $_REQUEST['tevolution_sortby'] == 'date_desc' ){
			$orderby = "$wpdb->posts.post_date DESC,(select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c' AND $wpdb->postmeta.meta_value = 'c') DESC";
		}elseif(isset($_REQUEST['tevolution_sortby']) && $_REQUEST['tevolution_sortby'] == 'random' ){
			$orderby = " (select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c' AND $wpdb->postmeta.meta_value = 'c') DESC,rand()";
		}elseif(isset($_REQUEST['tevolution_sortby']) && $_REQUEST['tevolution_sortby'] == 'reviews' ){
			$orderby = 'DESC';
			$orderby = " comment_count $orderby,(select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c' AND $wpdb->postmeta.meta_value = 'c') DESC";
		}elseif(isset($_REQUEST['tevolution_sortby']) && $_REQUEST['tevolution_sortby'] == 'rating' ){

			$orderby = " (select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = $wpdb->posts.ID and $wpdb->postmeta.meta_key like \"average_rating\") DESC,(select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c' AND $wpdb->postmeta.meta_value = 'c') DESC";
		}else{
			$orderby = " (SELECT DISTINCT $wpdb->postmeta.meta_value from $wpdb->postmeta where ($wpdb->posts.ID = $wpdb->postmeta.post_id) AND $wpdb->postmeta.meta_key = 'featured_c' AND $wpdb->postmeta.meta_value = 'c') DESC,$wpdb->posts.post_date DESC";
		}
	}
	return $orderby;
}

/* sorting option for homepage listings */
add_action('pre_get_posts','homepage_front_page_ordering',12);
function homepage_front_page_ordering(){
	if(is_home() && (get_option('show_on_front') == 'posts')){
		add_filter('posts_orderby', 'homepage_front_page_order',99);
	}
}		
/* featured posts filter for listing page */
function homepage_front_page_order($orderby)
{
	$tmpdata =get_option('templatic_settings');
	$ordervalue = @$tmpdata['tev_front_page_order'];
	if($ordervalue ==''){ $ordervalue ='desc'; }
	global $wpdb;	
	
		if ($ordervalue == 'asc'){
			$orderby = " (select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') ASC, $wpdb->posts.post_title ASC";
		}
		elseif ($ordervalue == 'desc'){
			$orderby = " (select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') DESC, $wpdb->posts.post_title DESC";
		}
		elseif($ordervalue == 'random'){
			$orderby = " (select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') DESC,rand()";
		}
		elseif ($ordervalue == 'dasc' ){
			$orderby = " (select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') DESC, $wpdb->posts.post_date ASC";
		}
		elseif ($ordervalue == 'ddesc'){
			$orderby = " (select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') DESC, $wpdb->posts.post_date DESC";
		}else{
			$orderby = " (select distinct $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') DESC, $wpdb->posts.post_date ASC";
		}

	 return $orderby;
}

/* fetch featured posts filter for home page */
function home_page_feature_listing( &$query){
	if(isset($_REQUEST['post_type']) && $_REQUEST['post_type'] !=''):
		$post_type= @$query->query_vars['post_type'];
	else:
		$post_type='';
	endif;
	if(is_home() || @is_front_page() || (get_option('show_on_front') == 'posts' && (!is_archive() && !is_single() && !is_page() && !is_tax()) )){
		$tmpdata = get_option('templatic_settings');
		$home_listing_type_value = @$tmpdata['home_listing_type_value'];
		if(!empty($home_listing_type_value)){
			$attach = array('attachment');
			if(is_array($home_listing_type_value))
				$merge = array_merge($home_listing_type_value,$attach);
				
			if($post_type=='booking_custom_field'):
				$query->set('post_type',$post_type); /* set custom field post type*/
			else:
				$query->set('post_type', @$merge); /* set post type events */
			endif;
		}
		$query->set('post_status',array('publish')); /* set post type events */
	}else{
		remove_action('pre_get_posts', 'home_page_feature_listing');
	}
}

/* sort featured posts filter for home page */
function home_page_feature_listing_orderby($orderby)
{
	global $wpdb;
	if(is_home() || @is_front_page()){		
		$orderby = " (SELECT DISTINCT($wpdb->postmeta.meta_value) from $wpdb->postmeta where ($wpdb->posts.ID = $wpdb->postmeta.post_id) AND $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') DESC,$wpdb->posts.post_date DESC";
	}
	return $orderby;
}
/* filtering for featured listing end*/

/*
	get the image path 
 */
function get_templ_image($post_id,$size='thumbnail') {

	global $post;
	/*get the thumb image*/	
	$thumbnail = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post_id ), $size ) ;	
	if($thumbnail[0]!='')
	{
		$image_src=$thumbnail[0];		
	}else
	{
		$post_img_thumb = bdw_get_images_plugin($post_id,$size); 
		$image_src = $post_img_thumb[0]['file'];
	}	
	return $image_src;
}


/* return the sorting options and views button*/
function tmpl_archives_sorting_opt(){
	global $wp_query,$sort_post_type;
	
	if(!is_search()){
		$post_type = (get_post_type()!='')? get_post_type() : get_query_var('post_type');
		$sort_post_type = apply_filters('tmpl_tev_sorting_for_'.$post_type,$post_type);
		
	}else{
		/* on search page what happens if user search with multiple post types */
		if(isset($_REQUEST['post_type'])){
			if(is_array($_REQUEST['post_type']) && count($_REQUEST['post_type'])==1){
				$sort_post_type= $_REQUEST['post_type'][0];
			}else{
				$sort_post_type= $_REQUEST['post_type'];
			}
		}
			if(!$sort_post_type){
				$sort_post_type='directory';
			}
		
	}
	
	$templatic_settings=get_option('templatic_settings');
	$googlemap_setting=get_option('city_googlemap_setting');
	
	/*custom post type link */
	$current_posttype = get_post_type();
	
	if(empty($current_posttype)){
		$current_posttype = $wp_query->query['post_type'];
	}
		
	if(!is_tax() && is_archive() && !is_search())
	{
		$current_term = $wp_query->get_queried_object();		
		$permalink = get_post_type_archive_link($current_posttype);
		$permalink=str_replace('&'.$sort_post_type.'_sortby=alphabetical&sortby='.$_REQUEST['sortby'],'',$permalink);
	}elseif(is_search()){
		$search_query_str=str_replace('&'.$sort_post_type.'_sortby=alphabetical&sortby='.@$_REQUEST['sortby'],'',$_SERVER['QUERY_STRING']);
		$permalink= site_url()."?".$search_query_str;
	}else{
		$current_term = $wp_query->get_queried_object();
		$permalink=($current_term->slug) ?  get_term_link($current_term->slug, $current_term->taxonomy):'';
		if(isset($_REQUEST['sortby']) && $_REQUEST['sortby']!='')
			$permalink=str_replace('&'.$sort_post_type.'_sortby=alphabetical&sortby='.$_REQUEST['sortby'],'',$permalink);
		
	}
	
	$post_type= get_post_type_object( get_post_type());
	
	/* get all the request url and con-cat with permalink to get the exact results */
        $req_uri = '';
	foreach($_GET as $key=>$val){
		if($key !='' && !strstr($key,'_sortby')){
			$req_uri .= $key."=".$val."&";
		}
	}
	
	/* permalink */
	if(false===strpos($permalink,'?')){
	    $url_glue = '?'.$req_uri;
	}else{
		$url_glue = '&amp;'.$req_uri;	
	}
	
	/* no grid view list view if no results found */
	
	if($wp_query->found_posts!=0){
	?>
	<div class='directory_manager_tab clearfix'>
	<div class="sort_options">
	<?php if(have_posts()!='' && current_theme_supports('tmpl_show_pageviews')): ?>
		<ul class='view_mode viewsbox'>
			<?php if(function_exists('tmpl_wp_is_mobile') && tmpl_wp_is_mobile()){ 
				if(isset($templatic_settings['category_googlemap_widget']) && $templatic_settings['category_googlemap_widget']=='yes'){
				?>
				<li><a class='switcher last listview  <?php if($templatic_settings['default_page_view']=="listview"){echo 'active';}?>' id='listview' href='#'><?php _e('LIST VIEW','templatic');?></a></li>
				<li><a class='map_icon <?php if($templatic_settings['default_page_view']=="mapview"){echo 'active';}?>' id='locations_map' href='#'><?php _e('MAP','templatic');?></a></li>
			<?php }	
			}else{ ?>
				<li><a class='switcher first gridview <?php if($templatic_settings['default_page_view']=="gridview"){echo 'active';}?>' id='gridview' href='#'><?php _e('GRID VIEW','templatic');?></a></li>
				<li><a class='switcher last listview  <?php if($templatic_settings['default_page_view']=="listview"){echo 'active';}?>' id='listview' href='#'><?php _e('LIST VIEW','templatic');?></a></li>
				<?php if(isset($templatic_settings['category_googlemap_widget']) && $templatic_settings['category_googlemap_widget']=='yes'):?> 
				<li><a class='map_icon <?php if($templatic_settings['default_page_view']=="mapview"){echo 'active';}?>' id='locations_map' href='#'><?php _e('MAP','templatic');?></a></li>
				<?php endif;
			}
			?>
		</ul>	
	<?php endif;

	if(isset($_GET[$sort_post_type.'_sortby']) && $_GET[$sort_post_type.'_sortby']=='alphabetical'){
		$_SESSION['alphabetical']='1';	
	}else{
		unset($_SESSION['alphabetical']);
	}
	
	if(!empty($templatic_settings['sorting_option'])){

		/* take "directory" as a post type if additional post type is detected */
		$exclude_arr = apply_filters('exclude_sorting_posttypes',array('event','property','classified'));
		if(!in_array(get_post_type(),$exclude_arr)){
			$sort_post_type_name = 'tevolution';
		}	
		else{	
			$sort_post_type_name = get_post_type();
		}
		
		$sel_sort_by = isset($_REQUEST[$sort_post_type_name.'_sortby']) ? $_REQUEST[$sort_post_type_name.'_sortby'] : '';
		$sel_class = 'selected=selected';
		
	?>
		<div class="tev_sorting_option">
			<form action="<?php if(function_exists('tmpl_directory_full_url')){ echo tmpl_directory_full_url('directory'); } ?>" method="get" id="<?php echo $sort_post_type.'_sortby_frm'; ?>" name="<?php echo $sort_post_type.'_sortby_frm'; ?>">
               <select name="<?php echo $sort_post_type_name.'_sortby'; ?>" id="<?php echo $sort_post_type_name.'_sortby'; ?>" onchange="sort_as_set(this.value)" class="tev_options_sel">
				<option <?php if(!$sel_sort_by){ echo $sel_class; } ?>><?php _e('Sort By','templatic'); ?></option>
				<?php
					do_action('tmpl_before_sortby_title_alphabetical');
					if(!empty($templatic_settings['sorting_option']) && in_array('title_alphabetical',$templatic_settings['sorting_option'])):?>
						<option value="alphabetical" <?php if($sel_sort_by =='alphabetical'){ echo $sel_class; } ?>><?php _e('Alphabetical','templatic');?></option>
				<?php endif;
					do_action('tmpl_after_sortby_title_alphabetical');
					
					do_action('tmpl_before_sortby_title_asc');
					if(!empty($templatic_settings['sorting_option']) && in_array('title_asc',$templatic_settings['sorting_option'])):?>
						<option value="title_asc" <?php if($sel_sort_by =='title_asc'){ echo $sel_class; } ?>><?php _e('Title Ascending','templatic');?></option>
				<?php endif;
					do_action('tmpl_after_sortby_title_asc');
					
					do_action('tmpl_before_sortby_title_desc');
					if(!empty($templatic_settings['sorting_option']) && in_array('title_desc',$templatic_settings['sorting_option'])):?>
						<option value="title_desc" <?php if($sel_sort_by =='title_desc'){ echo $sel_class; } ?>><?php _e('Title Descending','templatic');?></option>
				<?php endif;
					do_action('tmpl_after_sortby_title_desc');
				
					do_action('tmpl_before_sortby_date_asc');
					if(!empty($templatic_settings['sorting_option']) && in_array('date_asc',$templatic_settings['sorting_option'])):?>
						<option value="date_asc" <?php if($sel_sort_by =='date_asc'){ echo $sel_class; } ?>><?php _e('Publish Date Ascending','templatic');?></option>
				<?php endif;
					do_action('tmpl_after_sortby_date_asc');
					
					do_action('tmpl_before_date_desc');
					if(!empty($templatic_settings['sorting_option']) && in_array('date_desc',$templatic_settings['sorting_option'])):?>
						<option value="date_desc" <?php if($sel_sort_by =='date_desc'){ echo $sel_class; } ?>><?php _e('Publish Date Descending','templatic');?></option>
				<?php endif;
					do_action('tmpl_after_sortby_date_desc');
					
					do_action('tmpl_before_sortby_reviews');
					if(!empty($templatic_settings['sorting_option']) && in_array('reviews',$templatic_settings['sorting_option'])):?>
						<option value="reviews" <?php if($sel_sort_by =='reviews'){ echo $sel_class; } ?>><?php _e('Reviews','templatic');?></option>
				<?php endif;
					do_action('tmpl_after_sortby_reviews');
					
					do_action('tmpl_before_sortby_rating');
					if(!empty($templatic_settings['sorting_option']) && in_array('rating',$templatic_settings['sorting_option'])):?>
						<option value="rating" <?php if($sel_sort_by =='rating'){ echo $sel_class; } ?>><?php _e('Rating','templatic');?></option>
				<?php endif;
					do_action('tmpl_after_sortby_rating');
					
					do_action('tmpl_before_sortby_random');
					if(!empty($templatic_settings['sorting_option']) && in_array('random',$templatic_settings['sorting_option'])):?>
						<option value="random" <?php if($sel_sort_by =='random'){ echo $sel_class; } ?>><?php _e('Random','templatic');?></option>
				<?php endif;
					do_action('tmpl_after_sortby_random');
					?>             
			  </select>
			 </form>
             <?php add_action('wp_footer','sorting_option_of_listing'); ?>
		</div>
    <?php
	}

	?>
     	</div><!--END sort_options div -->
    </div><!-- END directory_manager_tab Div -->
	<?php
	}
	
	
	/* On archive and category pages - alphabets order should display even there is no post type pass in argument  */
	$exclude_arr = array('event','property','classified');
	if(isset($_REQUEST['alpha_sort_post_type']) && $_REQUEST['alpha_sort_post_type'] != '')
		$sort_post_type = $_REQUEST['alpha_sort_post_type'];
	if(!in_array($sort_post_type,$exclude_arr))
		$sort_post_type = 'tevolution';
	else	
		$sort_post_type = $sort_post_type;
	if(!$sort_post_type){ $sort_post_type="tevolution"; }
	if((isset($_REQUEST[$sort_post_type.'_sortby']) && $_REQUEST[$sort_post_type.'_sortby']=='alphabetical') || (isset($_SESSION['alphabetical']) && $_SESSION['alphabetical']==1)):
	
	$alphabets = array(__('A','templatic'),__('B','templatic'),__('C','templatic'),__('D','templatic'),__('E','templatic'),__('F','templatic'),__('G','templatic'),__('H','templatic'),__('I','templatic'),__('J','templatic'),__('K','templatic'),__('L','templatic'),__('M','templatic'),__('N','templatic'),__('O','templatic'),__('P','templatic'),__('Q','templatic'),__('R','templatic'),__('S','templatic'),__('T','templatic'),__('U','templatic'),__('V','templatic'),__('W','templatic'),__('X','templatic'),__('Y','templatic'),__('Z','templatic'));
	/*show all result when we click on all in alphabetical sort order*/
	$all = str_replace('?sortby='.$_REQUEST['sortby'].'&','/?',$url_glue);
	?>
    <div id="directory_sort_order_alphabetical" class="sort_order_alphabetical">
		<input type="hidden" name="alpha_sort" id="alpha_sort" /> <!-- for listfilter  -->
	    <ul>
			<li class="<?php echo (!isset($_REQUEST['sortby']))?'active':''?>"><a href="<?php echo remove_query_arg('sortby',$permalink.$all.$sort_post_type.'_sortby=alphabetical');?>"><?php _e('All','templatic');?></a></li>
			<?php
			foreach($alphabets as &$value){ 
				$key = $value;
				$val = strtolower($key);
				?>
				<li class="<?php echo (isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == $val)? 'active':''?>"><a href="<?php echo $permalink.$url_glue .$sort_post_type.'_sortby=alphabetical&sortby='.$val.'&alpha_sort_post_type='.$sort_post_type;?>"><?php echo $key; ?></a></li>
				<?php 
			} ?>
	    </ul>
    </div>
    <?php endif;
}
function sorting_option_of_listing()
{
	?>
    <script type="text/javascript" async >
		function sort_as_set(val)
		{
			<?php 
			global $sort_post_type;
			$current_post_type = get_post_type();
			$addons_posttype = tmpl_addon_name(); /* all tevolution addons' post type as key and folter name as a value */
			$exclude_arr = apply_filters('exclude_sorting_posttypes',array('event','property','classified'));
			if(!in_array($current_post_type, $exclude_arr)){
				$sort_post_type = 'tevolution';
			}else{
				$sort_post_type = $current_post_type;
			}
				
			if(function_exists('tmpl_directory_full_url')){ ?>
			if(document.getElementById('<?php echo $sort_post_type; ?>_sortby').value)
			{
				<?php if(strstr(tmpl_directory_full_url($sort_post_type),'?')): ?>
					window.location = '<?php echo tmpl_directory_full_url($sort_post_type); ?>'+'&'+'<?php echo $sort_post_type; ?>'+'_sortby='+val;
				<?php else: ?>
					window.location = '<?php echo tmpl_directory_full_url($sort_post_type); ?>'+'?'+'<?php echo $sort_post_type; ?>'+'='+val;
				<?php endif; ?>
			}
			<?php } ?>
		}
	</script>
    <?php
}

/* return the related listings query without HTML */

function tmpl_get_related_posts_query(){ 
	
	global $post,$claimpost,$sitepress;
	$claimpost = $post;	
	$tmpdata = get_option('templatic_settings');
	if(@$tmpdata['related_post_numbers']==0 && $tmpdata['related_post_numbers']!=''){
		return '';	
	}
	$related_post =  @$tmpdata['related_post'];
	$related_post_numbers =  ( @$tmpdata['related_post_numbers'] ) ? @$tmpdata['related_post_numbers'] : 3;
	$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post->post_type,'public'   => true, '_builtin' => true ));	
	/* get location wise post type */
	$location_post_type = ',' . implode(',', get_option('location_post_type'));
	remove_all_actions('posts_where');
	
	if($post->ID !=''){
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
			'orderby'      => 'rand',
			'post__not_in' => array($post->ID)
		);
	}
	else
	{		
	        
         $terms = wp_get_post_terms($post->ID, $taxonomies[0], array("fields" => "ids"));	
		 $postQuery = apply_filters('tmpl_related_post_custom', array(
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
			'orderby'      => 'rand',
			'post__not_in' => array($post->ID),
            
		));
}
	}
	if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')){
		remove_action( 'parse_query', array( $sitepress, 'parse_query' ) );
	}
	
	if(is_plugin_active('Tevolution-LocationManager/location-manager.php') && strpos($location_post_type,','.$post->post_type) !== false ){
		add_filter('posts_where', 'location_related_posts_where_filter');
	}
	
	$my_query = new wp_query($postQuery);
	
	
	if(is_plugin_active('Tevolution-LocationManager/location-manager.php')){
		remove_filter('posts_where', 'location_related_posts_where_filter');
	}
	
	return $my_query;
 }
/*hide sort option while map view is selected.*/
add_action('wp_footer','hide_archive_sort_option');
function hide_archive_sort_option()
{
	global $posts;

	if((is_tax() || is_archive()) && !empty($posts))
	{
	?>
    <script type="text/javascript" async>
		jQuery(window).load(function () {
                        
                        /* Code start for map reload and center it on category page after tabs changing */
                        jQuery(function(){
                            jQuery(document).on('click',"ul.view_mode li #locations_map", function(){
                                google.maps.event.trigger(map, 'resize');
                                map.fitBounds(bounds);
                                var center = bounds.getCenter();
                                map.setCenter(center);
                            })
                        });
                        /* Code end */
                        
                        if(jQuery('#locations_map').hasClass('active'))
			{
				jQuery('.tev_sorting_option').css('display','none');
				jQuery('#directory_sort_order_alphabetical').css('display','none');
			}
			else
			{
				jQuery('.tev_sorting_option').css('display','');
				jQuery('#directory_sort_order_alphabetical').css('display','');
			}
			jQuery('.viewsbox a.listview').click(function(e){
				jQuery('.tev_sorting_option').css('display','');
				jQuery('#directory_sort_order_alphabetical').css('display','');
			});
			jQuery('.viewsbox a.gridview').click(function(e){
				jQuery('.tev_sorting_option').css('display','');
				jQuery('#directory_sort_order_alphabetical').css('display','');
			});
			jQuery('.viewsbox a#locations_map').click(function(e){
				jQuery('.tev_sorting_option').css('display','none');
				jQuery('#directory_sort_order_alphabetical').css('display','none');
			});
		});
	</script>
    <?php
	}
}


/* Pass the custom post types for feeds */

if(!function_exists('directory_myfeed_request')){
	function directory_myfeed_request($qv) {
		if (isset($qv['feed']))
			$qv['post_type'] = get_post_types();
		return $qv;
	}
}
add_filter('request', 'directory_myfeed_request');

/* category page and search page excerpt content limit */
if(!function_exists('print_excerpt')){
	function print_excerpt($length) { // Max excerpt length. Length is set in characters
		global $post;
                $length = ($length =='')? '50' : $length;
		/*condition for supreme related theme*/
		if(function_exists('supreme_prefix')){
			$pref = supreme_prefix();
		}else{
			$pref = sanitize_key( apply_filters( 'hybrid_prefix', get_template() ) );
		}
		$tmpdata = get_option($pref.'_theme_settings');	
		$morelink = @$tmpdata['templatic_excerpt_link'];
		
		if(!empty($morelink))
			$morelink =sprintf(__('<a href="%s" class="more moretag">%s</a>','templatic'),get_permalink(),$morelink);
		else
			$morelink ='<a class="moretag" href="'.get_permalink().'" class="more">'.__('Read more').'...</a>';
		
		$text = $post->post_excerpt;
		if ($text =='') {
			$text = $post->post_content;
			$text = apply_filters('the_excerpt', $text);
			$text = str_replace(']]>', ']]>', $text);
		}
		$text = strip_shortcodes($text); // optional, recommended
		$text = strip_tags($text); // use ' $text = strip_tags($text,'<p><a>'); ' if you want to keep some tags

		$text = wp_trim_words($text,$length); /* shows perticular words */
		if(reverse_strrchr($text, '.', 1)){
			$excerpt = reverse_strrchr($text, '.', 1)." ".sprintf(__('%s','templatic'),$morelink);
		}else{
			$excerpt = $text." ".sprintf(__('%s','templatic'),$morelink);
		}
		
		if( $excerpt ) {
			echo apply_filters('the_excerpt',$excerpt);
		} else {
			echo apply_filters('the_excerpt',$text);
		}
	}
}
?>