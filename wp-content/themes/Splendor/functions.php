<?php
/*
* Main functions file
*/

ob_start();
if (defined('WP_DEBUG') and WP_DEBUG == true){
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    error_reporting(0);
}


global $pagenow;
$page= (isset($_REQUEST['page']))? intval($_REQUEST['page']): '';

/* check for auto update */
if(is_admin() && ($pagenow =='themes.php' || strstr($_SERVER['REQUEST_URI'],'update.php') || strstr($_SERVER['REQUEST_URI'],'update-core.php') || $pagenow =='update-core.php' || $pagenow =='post.php' || $pagenow =='edit.php'|| $pagenow =='admin-ajax.php' || trim($page) == trim('tmpl_theme_update')) && file_exists(get_stylesheet_directory().'/wp_theme_update.php') && !DOING_AJAX){
	$is_update_page=0;
	if(strstr($_SERVER['REQUEST_URI'],'update.php') || strstr($_SERVER['REQUEST_URI'],'update-core.php') || $pagenow =='update-core.php')
	{
		$is_update_page=1;
	}
	$dateTimestamp1=get_option('tmpl_update_check_date');
	if(trim($dateTimestamp1!=""))
	{
		$dateTimestamp1=strtotime($dateTimestamp1);
	}
	else{
		update_option('tmpl_update_check_date',date('Y-m-d H:i:s'));
	}
	$dateTimestamp1=strtotime(get_option('tmpl_update_check_date'));
	$dateTimestamp2=strtotime(date('Y-m-d H:i:s'));
	$interval = abs($dateTimestamp2 - $dateTimestamp1);
	$hour_diff = intval(round($interval / 60)/60);
	if ($hour_diff > 3 || $is_update_page==1)
	{
		require_once(get_stylesheet_directory().'/wp_theme_update.php');	
		new WPUpdates_Splendor_Updater( 'https://templatic.com/_data/updates/api/', basename(get_stylesheet_directory_uri()) );
		if($is_update_page==0)
		{
			update_option('tmpl_update_check_date',date('Y-m-d H:i:s'));
		}
	}else{
		require_once(get_stylesheet_directory().'/wp_theme_update.php');
		new WPUpdates_Splendor_Updater('',basename(get_stylesheet_directory_uri()));
	}
}

/* set current theme as child and add Directory theme as parent - it will run only first time when the theme will activated */
if (get_option('is_first_time_install') != 1) {
        
		$filename = get_template_directory() . '/style.css';
		$arr = file($filename);
		if ($arr === false) {
		  die('Failed to read ' . $filename);
		}
		array_pop($arr); // remove last line of */ string 

		/* add template name into the file */
		$add_string[] = "* Template : Directory";
		$add_string[] =  "\n*/";
		$arr = array_merge($arr,$add_string);

		// write the new data to the file
		$fp = fopen($filename, 'w+');
		fwrite($fp, implode('', $arr));
		fclose($fp); 

		/* Add templatic directory theme to theme folder */
		$tev_directory = get_stylesheet_directory(). "/Directory.zip";
		$directory_theme = get_theme_root() . '/Directory';
		if (!is_dir($directory_theme) && file_exists($tev_directory)) {
				  
			  $zip = new ZipArchive();
			  $x = $zip->open($tev_directory);

			  if ($x === true && file_exists($tev_directory)) {
					/* change this to the correct site path */
					$zip->extractTo( get_theme_root());  
					$zip->close();
			  }
		}
		update_option('is_first_time_install', 1);
}
if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {
	update_option('template','Directory');
}

/*
 * Start easy install 
 * Return the plug-in directory path
 */
 include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (!function_exists('tmpl_splendor_plugin_directory')) {

          function tmpl_splendor_plugin_directory() {
                    return WP_CONTENT_DIR . "/plugins/";
          }

}

/* settings according to theme while theme is activate */
add_action( 'after_setup_theme', 'tmpl_splendor_theme_setup',99 );
function tmpl_splendor_theme_setup() {
	
	/* File for custom functions. Add all custom functions to this file */
	require_once(get_stylesheet_directory() . '/functions/tmpl-functions.php');
	
	/* included theme's custom widget file	 */
	require_once(get_stylesheet_directory().'/functions/tmpl_widgets.php'); 
	
	/* get language code */
	$locale = get_locale();
	
	/* po mo for language translation */
	if(is_admin()){
		
		/* 
		* Include admin side string translation file.
		* If file is available in child theme then include it,Otherwise include from parent theme
		*/
		if(file_exists(get_stylesheet_directory().'/languages/'.$locale.'.mo'))
		{ 
			load_textdomain( 'templatic-admin', get_stylesheet_directory().'/languages/admin-'.$locale.'.mo');
		}else{
			load_textdomain( 'templatic-admin', get_template_directory().'/languages/admin-'.$locale.'.mo');
		}
	}else{
		
		/* 
		* Include front side string translation file.
		* If file is available in child theme then include it,Otherwise include from parent theme
		*/
		if(file_exists(get_stylesheet_directory().'/languages/'.$locale.'.mo'))
		{
			load_textdomain('templatic', get_stylesheet_directory().'/languages/'.$locale.'.mo');
		}else{
			load_textdomain('templatic', get_template_directory().'/languages/'.$locale.'.mo');
		}
	}
	/* End localization */
	
	/* Add framework menus. */
	add_theme_support( 'supreme-core-menus', array(
		'primary',
		'secondary',
		'subsidiary'
		) );
	/* Register additional menus */
	
	/* carousal slider compatibility */
	add_theme_support( 'show_carousel_slider' );
	
	/* Add framework sidebars */
	/* add sidebar support in theme , want to remove from child theme as remove theme support from child theme's functions file */
	add_theme_support( 'supreme-core-sidebars', array(
				'header',
				'mega_menu',
				'menu-right',
				'secondary_navigation_right',
				'home-page-banner',
				'home-page-above-content',
				'homepage-content-one',
				'homepage-content-two',
				'homepage-above-main-left',
				'homepage-above-main-right',
				'home-page-content',
				'homepage-below-main',
				'above-homepage-footer',
				'below-main-homepage-content',
				'before-content',
				'entry',
				'after-content',
				'front-page-sidebar',
				'author-page-sidebar',
				'post-listing-sidebar',
				'post-detail-sidebar',
				'primary-sidebar',
				'after-singular',
				'contact_page_widget',
				'advance_search_sidebar',
				'contact_page_sidebar',
				'supreme_woocommerce',
				'home-page-above-footer',
				'footer'
				) );
	/* add theme support for menu */
	
	/* Add framework menus. */
	add_theme_support( 'supreme-core-menus', array(
				'primary',
				'secondary',
				'footer',		
	) );
	add_theme_support( 'post-formats', array(
		'aside',
		'audio',
		'gallery',
		'image',
		'link',
		'quote',
		'video'
		) );
	/* support post format */	
	add_post_type_support( 'post', 'post-formats' ); 
	
	/*  for portfolio slides option in slider */
	add_post_type_support( 'portfolio', 'post-formats' ); 
	
	/*  work with home page banner slider */
	add_theme_support( 'supreme_banner_slider' ); 
	
	/*  to show comments counting on listing */
	add_theme_support( 'supreme-show-commentsonlist' );
	
	/*  to support widgets  */
	add_theme_support( 'tmpldir-core-widgets' ); 
	
	/* to support short codes */
	add_theme_support( 'supreme-core-shortcodes' ); 
	add_theme_support("home_listing_type_value");
	add_theme_support("taxonomy_sorting");
	
	/*  Show gogole map if location manager active */
	add_theme_support("google_map"); 
	
	/*  Show my favourites & add to favourites with tevolution */
	add_theme_support("tevolution_my_favourites"); 
	
	/* show author listing widget with tevolution */
	add_theme_support("tevolution_author_listing"); 
	add_theme_support("map_fullwidth_support");
	add_theme_support("slider-post-inslider");
	add_theme_support("slider-post-content");
	
	/* theme support for default page views */
	add_theme_support("tmpl_show_pageviews");
	/* Home page settings to show the different post types listings on home page */
	add_theme_support("theme_home_page");

	add_action('init','remove_home_page_feature_listing_filter');
	/* Add theme support for framework layout extension. */
	add_theme_support( 'theme-layouts', array( /* Add theme layout options. */
		'1c',
		'2c-l',
		'2c-r',
		) );
	/* Add theme support for other framework extensions */
	
	add_theme_support( 'post-stylesheets' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'supreme-core-theme-settings', array( 'footer' ) );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'add-listing-to-favourite' );
	add_theme_support("tev_taxonomy_sorting_opt");
	
	/* Add theme support for WordPress background feature */
	add_theme_support( 'custom-background', array (
		'default-color' => '',
		'default-image' => '',
		'wp-head-callback' => 'supreme_custom_background_callback',
		'admin-head-callback' => '',
		'admin-preview-callback' => ''
	));
	
		
	/* to provide a option of posts per slide */
	add_theme_support('postperslide');	
	
	/* Set default widths to use when inserting media files */
	add_filter( 'embed_defaults', 'supreme_embed_defaults' ); 
	
	/* Load resources into the theme. */
	add_action( 'wp_enqueue_scripts', 'tmpl_theme_css_scripts' ,20);

	/*  Add Action for Customizer Controls Settings Start */
    add_action('customize_register', 'tmpl_splendor_register_customizer_settings', 100);
	
	/* Set theme specific options */
	add_action( 'admin_init', 'tmpl_set_themesettings' );
	/* Assign specific layouts to pages based on set conditions and disable certain sidebars based on layout choices. */
	add_action( 'template_redirect', 'supreme_layouts' );
	/* WooCommerce Functions. */
	if ( function_exists( 'is_woocommerce' ) ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	}

	if ( get_header_textcolor()=='blank') { ?>
	<style type="text/css">
	#site-title, #site-description {
		text-indent: -99999px;
	}
	</style>
	<?php }
	remove_action("wp_head", "supreme2_view_counter");
	add_filter('tev_gravtar_size','tev_gravtar_size_hook');
	global $pagenow;
	
	if(is_admin() && isset($_GET['activated']) && is_writable(WP_CONTENT_DIR."/plugins") && is_readable(get_stylesheet_directory()) && ($pagenow=='themes.php' || $pagenow=='theme-install.php')){
		
		$tev_zip = get_stylesheet_directory()."/Tevolution.zip";
		$tev_zip_path = get_stylesheet_directory()."/Tevolution.zip";
		
		$dir_zip = get_stylesheet_directory()."/Tevolution-Directory.zip";
		$dir_zip_path = get_stylesheet_directory()."/Tevolution-Directory.zip";
		
		$loc_zip = get_stylesheet_directory()."/Tevolution-LocationManager.zip";
		$loc_zip_path = get_stylesheet_directory()."/Tevolution-LocationManager.zip";
		
		$target_path1 = tmpl_splendor_plugin_directory()."Tevolution.zip";
		$target_path2 = tmpl_splendor_plugin_directory()."Tevolution-Directory.zip";
		$target_path3 = tmpl_splendor_plugin_directory()."Tevolution-LocationManager.zip";
		
		$plug_path1 = "Tevolution/templatic.php";
		$plug_path2 = "Tevolution-Directory/directory.php";
		$plug_path3 = "Tevolution-LocationManager/location-manager.php";
	
		$on_go = get_option('tev_on_go');
		if(!$on_go){ $on_go =0; }
		/* get current theme name */
		$theme_name = wp_get_theme();

		if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php') {
		/*hide listing install sample listing tab when directroy theme is activated*/
		update_option( 'hide_listing_ajax_notification', true );
		if(file_exists($tev_zip_path)){
			tmpl_splendor_zip_copy( $tev_zip, $target_path1, $plug_path1 );
		}	
		if(file_exists($dir_zip_path))
			tmpl_splendor_zip_copy( $dir_zip, $target_path2, $plug_path2 );
		if(file_exists($loc_zip_path))
			tmpl_splendor_zip_copy( $loc_zip, $target_path3, $plug_path3, $add_msg =1 );
		}
	}
	
	/* removed default slider image size */
	remove_filter('slider_image_thumb','slider_thumbnail'); 
	
	/* removed testimonials cycle effect script */
	remove_action('testimonial_script','widget_testimonial_script',20,3);
	
	/* removed testimonials add more script */
	remove_action('admin_head','supreme_add_script_addnew_'); 
	
	/* remove add more link from testimonial widget */
	remove_action('add_testimonial_submit','add_testimonial_submit_button',10); 
	
	/* removed structure for testimonials */
	remove_action('tmpl_testimonial_quote_text','add_testimonial_quote_text',10); 
	
	/* removed populer post thumbnail size 60x60 */
	remove_filter('popular_post_thumb_image','crop_popular_post_thumb_image',10);
	
	/* removed text above ratings on comments form */
	remove_action('tmpl_before_comments','single_post_comment_ratings',99);
	
	/* remove breadcrumb from event */
	remove_action('event_before_container_breadcrumb','event_breadcrumb');
	
	/* remove breadcrumb from jobboard */
	remove_action('jobs_before_container_breadcrumb','tmpl_job_board_breadcrumb');
	
	/* remove breadcrumb from deals plugin */
	remove_action('deals_before_container_breadcrumb','tmpl_deals_breadcrumb');
	
	/* remove bread crumb coming from plugins. */
	remove_action('directory_before_container_breadcrumb','directory_breadcrumb');
	remove_action('templ_before_container_breadcrumb','breadcrumb_trail');
	remove_action('classified_before_container_breadcrumb', 'tmpl_classified_breadcrumb');
	/* remove bread crumb coming from success page. */
	remove_action("templ_before_success_container_breadcrumb",'tevolution_success_container_breadcrumb');
	
	/* add breadcrumb. For success page, show different breadcrumb */
	if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'success'){
		add_action('tmpl_splendor_breadcrumb','tevolution_success_container_breadcrumb');
	}else{
		add_action('tmpl_splendor_breadcrumb','directory_breadcrumb');
	}
}


function wp_user_query_random_enable($query) {
	if($query->query_vars["orderby"] == 'rand') {
		$query->query_orderby = 'ORDER by RAND()';
	}
}
add_filter('pre_user_query', 'wp_user_query_random_enable');

/* RESTRICTING CHARACTER LIMIT OF STRING CONTENT*/
function myCharacterLimit($content)
{
	// Take the existing content and return a subset of it
	return substr($content, 0, 200);
}

/* Shortcodes */

function loadOffers(  ) {

	$args = array(
			'post_type'  => 'listing',
			'posts_per_page' => '3',
			'orderby' => 'rand',
			'meta_query' => array(
					'relation'  => 'AND',
					array(
							'key'    => 'offer',
							'value'    => 'Yes',
							'compare'  => 'LIKE',
					),
			),
	);

	// query
	$html = '';
	$the_query = new WP_Query( $args );
	while( $the_query->have_posts() ) : $the_query->the_post();


		global $wpdb;
		$hotel_address = $wpdb->get_var("SELECT address from wp_postcodes where post_id = " . get_the_ID());
		$offerContent = myCharacterLimit(get_the_content());
		$postImage = get_the_post_thumbnail_url();
		$pricepernight = get_post_meta(get_the_ID(),'price_per_night');

		$html .= '


		<div class="row" style="margin: 39px 0px;">
            <div class="col s12 m4">
                <div class="offers-img" style="background-image:url('.$postImage.')">
					<div class="offer-price">
						<span>$'.$pricepernight[0].'</span><span class="offer-price-currency">usd / night</span>
					</div>
                </div>
            </div>
            <div class="col s12 m8">
                <div class="row">
                    <div class="col s12">
                        <h3 style=" color:#9f9f9f !important;"> ' .  get_the_title() . ' </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <span style=" color:#9f9f9f !important; font-size:15px;    margin-bottom: 15px;" class="fa fa-map-marker" >' .  $hotel_address . '</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p style=" color:#9f9f9f !important; ">
                            ' . $offerContent  . '
                            <a href="'.get_permalink().'" style=" color:#9f9f9f !important;">Read more &#8608;</a>
                        </p>
                    </div>
                </div>
                 <div class="row">

						<div class="offer-button">
						  <a href="'.get_permalink().'">  <button>BOOK NOW</button></a>
						</div>

				 </div>
            </div>
        </div>



		';
		endwhile;


return $html;


}
add_shortcode( 'offers', 'loadOffers' );
























/* new widget areas */
global $theme_sidebars;

$theme_sidebars = array(
		
		/* for right side of primary navigation */
        'menu-right' => array(
                
				'name' => apply_filters('tmpl_above_homepage_content_title', __('Navigation Right', 'templatic')),
                'description' => __("Widgets placed inside this area will appear on the right side of your secondary navigation bar.", 'templatic'),
          ),
		
		/* for above homepage footer - full width */	
		'above-homepage-footer' => array(
                
				'name' => apply_filters('tmpl_above_homepage_content_title', __('Homepage - Above footer', 'templatic')),
                'description' => __("Widgets placed inside this area will appear right above on footer.", 'templatic'),
        ), 
		
		/* for below homepage main content - full width */	
		'homepage-below-main' => array(
                
				'name' => apply_filters('tmpl_above_homepage_content_title', __('Homepage - Below Main Content', 'templatic')),
                'description' => __("Widgets placed inside this area will appear below the main content in full width.", 'templatic'),
        ), 
		
		/* for left side part of above main content */
		'homepage-above-main-left' => array(
                
				'name' => apply_filters('tmpl_above_homepage_content_title', __('Homepage - Above Main Content Left', 'templatic')),
                'description' => __("Widgets placed inside this area will appear left side of main conent.", 'templatic'),
        ), 
		
		/* for right side part of above main content */
		'homepage-above-main-right' => array(
                
				'name' => apply_filters('tmpl_above_homepage_content_title', __('Homepage - Above Main Content Right', 'templatic')),
                'description' => __("Widgets placed inside this area will appear right side of main conent.", 'templatic'),
        ), 
		
		/* for below homepage banner - full width */
		'homepage-content-one' => array(
                
				'name' => apply_filters('tmpl_above_homepage_content_title', __('Homepage - Main Content 1', 'templatic')),
                'description' => __("Widgets placed inside this area will appear below the homepage benner widget area.", 'templatic'),
        ), 
		
		/* for below homepage main content one widget area - full width */
		'homepage-content-two' => array(
                
				'name' => apply_filters('tmpl_above_homepage_content_title', __('Homepage - Main Content 2', 'templatic')),
                'description' => __("Widgets placed inside this area will appear below homepage content 1.", 'templatic'),
        ), 		
 
);


/* Register new image sizes. */
add_action( 'init', 'tmpl_splendor_register_image_sizes',10 );
/* define some image sizes */
function tmpl_splendor_register_image_sizes(){
	
	/* define sizes of images */
	add_image_size( 'thumbnail', 125, 85, true );
	if(get_option('tmpl_splendor_default_image_sizes') == 1){
		if(get_option('thumbnail_size_w')!=125)
			update_option('thumbnail_size_w',125);
		if(get_option('thumbnail_size_h')!=85)
			update_option('thumbnail_size_h',85);
			
			
		if(get_option('medium_size_w')!=0)
			update_option('medium_size_w',0);
		if(get_option('medium_size_h')!=0)
			update_option('medium_size_h',0);
			
		if(get_option('large_size_w')!=0)
			update_option('large_size_w',0);
		if(get_option('large_size_h')!=0)
			update_option('large_size_h',0);
			
		update_option('tmpl_splendor_default_image_sizes',1);	
	}

	/* removed 60x60 image from slider thumbs */
	remove_image_size('tevolution_thumbnail');
	
	remove_image_size('slider_thumbnail');
	
	/* removed 250x180 image size from category page */
	remove_image_size('directory-listing-image');
	remove_image_size('directory_listing-image');
	
	/* removed 300x200 image from listing detailpage*/
	remove_image_size('directory-single-image'); 
	
	/* removed mobile device image size 60x60 */
	remove_image_size('mobile-thumbnail');

	

	/* used as a thumbnail */
	add_image_size('tevolution_thumbnail',125,85,true); 
	add_image_size('mobile-thumbnail',125,85,true);
	
	add_image_size('directory-listing-image',380,250,true);
	add_image_size('directory_listing-image',380,250,true);
	
	/* for slider image on homepage */
	add_image_size( 'splendor-slider_post_image', 1920, 670 , true );
	
	/* for listing detail page */
	add_image_size('directory-single-image',855,570,true);
	
	if(is_plugin_active('Tevolution-Events/events.php')){
		add_image_size('event-listing-image',380,250,true);
	}
	
}

/* add slider image size according to theme */
remove_filter('slider_image_thumb','slider_thumbnail');
add_filter('slider_image_thumb','tmpl_splendor_slider_image_thumb');

function tmpl_splendor_slider_image_thumb(){
	return 'splendor-slider_post_image';
}

/* width for slider */
add_filter('supreme_slider_width','tmpl_splendor_supreme_slider_width',13);
function tmpl_splendor_supreme_slider_width(){
	return 1920;
}

/* height for slider */
add_filter('supreme_slider_height','tmpl_splendor_ssupreme_slider_height',13);
function tmpl_splendor_ssupreme_slider_height(){
	return 670;
}

/* change thumbnail height and width according to theme */
add_filter('supreme_thumbnail_height','tmpl_splendor_thumbnail_height');
function tmpl_splendor_thumbnail_height(){
	return 125;
}
add_filter('supreme_thumbnail_width','tmpl_splendor_thumbnail_width');
function tmpl_splendor_thumbnail_width(){
	return 85;
}

/* change mobile height and width according to theme */
add_filter('mobile_thumbnail_height','tmpl_splendor_mobile_thumbnail_height');
function tmpl_splendor_mobile_thumbnail_height(){
	return 85;
}
add_filter('mobile_thumbnail_width','tmpl_splendor_mobile_thumbnail_width');
function tmpl_splendor_mobile_thumbnail_width(){
	return 125;
}

/* templates for addition post type */
add_filter('template_include', 'tmpl_theme_default_templates');

function tmpl_theme_default_templates($template) {

          if (function_exists('tmpl_addon_name'))
                    $addons_posttype = tmpl_addon_name(); /* all tevolution addons' post type as key and folter name as a value */
          $current_post_type = get_post_type(); /* get current post type */

          $taxonomies = get_object_taxonomies((object) array('post_type' => $current_post_type, 'public' => true, '_builtin' => true));

          /* called a default template for additional post type */
          if (function_exists('tmpl_wp_is_mobile') && !tmpl_wp_is_mobile() && !empty($current_post_type) && !array_key_exists($current_post_type, $addons_posttype) && (!in_array($current_post_type, array('post', 'product', 'attachment')))){
                    
					/* template for detail page */
                    if (is_single() && get_post_type() != 'post' && !file_exists(dirname(__FILE__) . '/single-' . $current_post_type . '.php')) {
                              if (file_exists(dirname(__FILE__) . '/single-listing.php'))
                                        $template = dirname(__FILE__) . '/single-listing.php';
                    }
					
                    /* template for category/archive/tags page */
                    if ((is_category() || is_tax()) && !file_exists(dirname(__FILE__) . '/taxonomy-' . $taxonomies[0] . '.php') && !empty($current_post_type) && $current_post_type != 'post') {
                              if (file_exists(dirname(__FILE__) . '/taxonomy-listingcategory.php'))
                                        $template = dirname(__FILE__) . '/taxonomy-listingcategory.php';
                    }elseif ((is_post_type_archive() && !file_exists(dirname(__FILE__) . '/archive-' . $taxonomies[0] . '.php')) && !empty($current_post_type) && $current_post_type != 'post') {
                              if (file_exists(dirname(__FILE__) . '/archive-listing.php'))
                                        $template = dirname(__FILE__) . '/archive-listing.php';
                    }

                    return $template;
          }else {

                return $template;
          }
}

/* add custom filed related to the theme */
add_action( 'admin_init', 'tmpl_splendor_theme_setup_data', 20 );
function tmpl_splendor_theme_setup_data(){
	global $pagenow,$wpdb;
	
	/* some settings which needs to be saved by theme activation */
	if((is_admin() && $pagenow=='themes.php' && (isset($_REQUEST['activated']) && $_REQUEST['activated']=='true')) || get_option('splendor_custom_fields_update')!='inserted'){
		/* Insert type */	
		update_option('splendor_custom_fields_update','inserted');
		
		/* map customized for the theme */
		update_option('google_map_customizer','{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]},');
		
		/* set default logo image */
		$listing_logo = $wpdb->get_row("SELECT post_title,ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'listing_logo' and $wpdb->posts.post_type = 'custom_fields'");
		if(count($listing_logo) > 0)
		{
			update_post_meta($listing_logo->ID, 'default_value', get_stylesheet_directory_uri().'/images/default-listing-logo.jpg');
		}
		
		/* add locations info only for listings */
		$location_map_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_name like 'locations_info' and post_type='custom_fields' and post_status='publish' limit 0,1");
		if(count($location_map_id) > 0)
			update_post_meta($location_map_id,'post_type','listing');
		
		/* add multicity only for listings */
		$multycity_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_name like 'post_city_id' and post_type='custom_fields' and post_status='publish' limit 0,1");
		if(count($multycity_id) > 0)
			update_post_meta($multycity_id,'post_type','listing');	
		
		/* insert the Amenitie field on theme activcation */
		$amenitie = $wpdb->get_row("SELECT post_title,ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'amenitie' and $wpdb->posts.post_type = 'custom_fields'");
		if(count($amenitie) == 0)
		{
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
				
				/* insert post in language */
				wpml_insert_templ_post($post_id,'custom_fields'); 
			}
			
			foreach($post_meta as $key=> $_post_meta)
			{
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
	}	
}

/* add color customizer settings */
function tmpl_splendor_register_customizer_settings($wp_customize){
	$wp_customize->remove_control('color_picker_color4'); /* removed unnecessary color picker */
	$wp_customize->get_control('color_picker_color2')->label = __('Primary Color - Black (2)','templatic'); /* changed label for color 2 */
	$wp_customize->get_control('color_picker_color3')->label = __('Body font Color (3)','templatic'); /* changed label for color 2 */
	$wp_customize->get_control('color_picker_color3')->priority = 6;
	
	$wp_customize->get_control('color_picker_color5')->label = __('Heading text color - 1 (5)','templatic');  /* changed label for color 5 */
	$wp_customize->get_control('color_picker_color5')->priority = 7;
	
	$wp_customize->get_control('color_picker_color6')->label = __('Heading text color - 2 (6)','templatic');  /* changed label for color 6 */
	$wp_customize->get_control('color_picker_color6')->priority = 8;
	if(function_exists('supreme_prefix')){
		/* add color controller for theme specific color */
		$wp_customize->add_setting(supreme_prefix().'_theme_settings[color_picker_color9]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_supreme_color9",
			'sanitize_js_callback' => 	"templatic_customize_supreme_color9",
		));
		
		
		$wp_customize->add_control( new wp_customize_color_control( $wp_customize, 'color_picker_color9', array(
			'label'   => __( 'Primary Box color (9)', 'templatic-admin' ),
			'section' => 'colors',
			'settings'   => supreme_prefix().'_theme_settings[color_picker_color9]',
			'priority' => 2,
		)));
		
		/* add new color for secondary colors for example green buttons */
		
		$wp_customize->add_setting(supreme_prefix().'_theme_settings[color_picker_color7]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_supreme_color7",
			'sanitize_js_callback' => 	"templatic_customize_supreme_color7",
		));
		
		$wp_customize->add_control( new wp_customize_color_control( $wp_customize, 'color_picker_color7', array(
			'label'   => __( 'Secondary color - Cream (7)', 'templatic-admin' ),
			'section' => 'colors',
			'settings'   => supreme_prefix().'_theme_settings[color_picker_color7]',
			'priority' => 3,
		) ) );
		
			
		/* add color controller for theme specific color */
		$wp_customize->add_setting(supreme_prefix().'_theme_settings[color_picker_color10]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_supreme_color10",
			'sanitize_js_callback' => 	"templatic_customize_supreme_color10",
		));
		
		
		$wp_customize->add_control( new wp_customize_color_control( $wp_customize, 'color_picker_color10', array(
			'label'   => __( 'Secondary Box color (10)', 'templatic-admin' ),
			'section' => 'colors',
			'settings'   => supreme_prefix().'_theme_settings[color_picker_color10]',
			'priority' => 4,
		)));
		
		/* add color controller for theme specific color */
		$wp_customize->add_setting(supreme_prefix().'_theme_settings[color_picker_color8]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_supreme_color8",
			'sanitize_js_callback' => 	"templatic_customize_supreme_color8",
		));
		
		
		$wp_customize->add_control( new wp_customize_color_control( $wp_customize, 'color_picker_color8', array(
			'label'   => __( 'Meta color (8)', 'templatic-admin' ),
			'section' => 'colors',
			'settings'   => supreme_prefix().'_theme_settings[color_picker_color8]',
			'priority' => 8,
		)));
	
	}	
	
}


/* for secondary bolor */
function templatic_customize_supreme_color7( $setting, $object ) {
		
		/* make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( supreme_prefix()."_theme_settings[color_picker_color7]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_supreme_color7", $setting, $object );
	}

/* for theme specific color */	
function templatic_customize_supreme_color8( $setting, $object ) {
		/* make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( supreme_prefix()."_theme_settings[color_picker_color8]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_supreme_color8", $setting, $object );
	}	

/* for primary box color */	
function templatic_customize_supreme_color9( $setting, $object ) {
	/* make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
	if ( supreme_prefix()."_theme_settings[color_picker_color9]" == $object->id && !current_user_can( 'unfiltered_html' )  )
		$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
	/* return the sanitized setting and apply filters. */
	return apply_filters( "templatic_customize_supreme_color9", $setting, $object );
}		

/* for Secondary box color */	
function templatic_customize_supreme_color10( $setting, $object ) {
	/* make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
	if ( supreme_prefix()."_theme_settings[color_picker_color10]" == $object->id && !current_user_can( 'unfiltered_html' )  )
		$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
	/* return the sanitized setting and apply filters. */
	return apply_filters( "templatic_customize_supreme_color10", $setting, $object );
}		
		
/* add css for color customizer */	
add_action( 'wp_footer', 'tmpl_splendor_footer_script' );
function tmpl_splendor_footer_script() {
	
	/*include admin_style.css for color customizer for backend.*/
	
		wp_enqueue_style( 'admin_style', trailingslashit ( get_template_directory_uri())."css/admin_style.css" );
	
}

/* get the all image sizes */
if(!function_exists('tmpl_splendor_get_image_sizes')){
	function tmpl_splendor_get_image_sizes( $size = '' ) {

			global $_wp_additional_image_sizes;

			$sizes = array();
			$get_intermediate_image_sizes = get_intermediate_image_sizes();

			/* Create the full array with sizes and crop info */
			foreach( $get_intermediate_image_sizes as $_size ) {

					if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

							$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
							$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
							$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

					} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

							$sizes[ $_size ] = array( 
									'width' => $_wp_additional_image_sizes[ $_size ]['width'],
									'height' => $_wp_additional_image_sizes[ $_size ]['height'],
									'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
							);

					}

			}

			/* Get only 1 size if found */
			if ( $size ) {

					if( isset( $sizes[ $size ] ) ) {
							return $sizes[ $size ];
					} else {
							return false;
					}

			}

			return $sizes;
	}
}


/*
 * add submenu for auto update theme
 */
add_action('admin_menu', 'splendor_templatic_menu', 20);
if (!function_exists('splendor_templatic_menu')) {

          function splendor_templatic_menu() {
                    if(is_plugin_active('Tevolution/templatic.php')){

                              add_submenu_page('templatic_system_menu', __('Child Theme Update', 'templatic'), __('Child Theme Update', 'templatic'), 'administrator', 'child_tmpl_theme_update', 'child_tmpl_theme_update', 27);
                    } else {

                              add_submenu_page('templatic_menu', __('Child Theme Update', 'templatic'), __('Child Theme Update', 'templatic'), 'administrator', 'child_tmpl_theme_update', 'child_tmpl_theme_update', 27);
                    }
          }

}
/*
 * include the auto update login file.
 */
if (!function_exists('child_tmpl_theme_update')) {

          function child_tmpl_theme_update() {
                    require_once(get_stylesheet_directory() . "/templatic_login.php");
          }

}
/* EOF */
?>