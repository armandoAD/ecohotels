<?php
/*
Plugin Name: Tevolution - Directory
Plugin URI: http://templatic.com/docs/directory-plugin-guide/
Description: Tevolution - Directory plugin is specially built to turn your site into a powerful listings directory for any niche. To be used with Tevolution, this plugin is loaded with a bundle of features like listing submissions, power search, unlimited categories, custom fields and subscription or per listing payment packages.
Version: 2.1.3
Author: Templatic
Author URI: http://templatic.com/
*/
ob_start();
define( 'TEVOLUTION_DIRECTORY_VERSION', '2.1.3' );

/* Plugin version*/
define( 'DIR_DOMAIN', 'templatic2');  /*tevolution* deprecated*/
if(!defined('ADMINDOMAIN'))
	define( 'ADMINDOMAIN', 'templatic-admin' ); /*tevolution* deprecated*/

define('TEVOLUTION_DIRECTORY_SLUG','Tevolution-Directory/directory.php');
/* Plugin Folder URL*/
define( 'TEVOLUTION_DIRECTORY_URL', plugin_dir_url( __FILE__ ) );
/*Plugin Folder Path*/
define( 'TEVOLUTION_DIRECTORY_DIR', plugin_dir_path( __FILE__ ) );
/* Plugin Root File*/
define( 'TEVOLUTION_DIRECTORY_FILE', __FILE__ );
/*Define domain name*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
ob_start();
/* get the tevolution general setting option from templatic_settings */
global $templatic_settings;
$templatic_settings=get_option('templatic_settings');
if(strstr($_SERVER['REQUEST_URI'],'plugins.php') || strstr($_SERVER['REQUEST_URI'],'update.php') ){
	/*Plugin auto update file include */
	$is_update_page=0;
	$dateTimestamp1=get_option('tmpl_tev_dir_update_check_date');
	if(trim($dateTimestamp1!=""))
	{
		$dateTimestamp1=strtotime($dateTimestamp1);
	}
	else{
		update_option('tmpl_tev_dir_update_check_date',date('Y-m-d H:i:s'));
	}
	$dateTimestamp1=strtotime(get_option('tmpl_tev_dir_update_check_date'));
	$dateTimestamp2=strtotime(date('Y-m-d H:i:s'));
	$interval = abs($dateTimestamp2 - $dateTimestamp1);
	$hour_diff = intval(round($interval / 60)/60);
	if ($hour_diff > 3 || $is_update_page==1)
	{
		require_once('wp-updates-plugin.php');
		new WPDirectoryUpdates( 'http://templatic.com/_data/updates/api/index.php', plugin_basename(__FILE__) );
		if($is_update_page==0)
		{
			update_option('tmpl_tev_dir_update_check_date',date('Y-m-d H:i:s'));
		}
	}
}
/*
	check is it codestyling localization or not
	
*/
if(!function_exists('is_cdlocalization')){
	function is_cdlocalization(){
		if(is_plugin_active('codestyling-localization/codestyling-localization.php')){
			return true;
		}else{
			return false;
		}
	}
}
if(is_plugin_active('Tevolution/templatic.php'))
{
	/* include plugin main files.*/
	$locale = get_locale();
	if(is_cdlocalization()){
		   if(is_admin()){
				load_textdomain( 'dirtemplatic',TEVOLUTION_DIRECTORY_DIR.'languages/templatic-admin-'.$locale.'.mo' );
				load_textdomain( 'templatic-admin',TEVOLUTION_DIRECTORY_DIR.'languages/templatic-admin-'.$locale.'.mo' );
		   }else{
				load_textdomain( 'templatic',TEVOLUTION_DIRECTORY_DIR.'languages/dirtemplatic-'.$locale.'.mo' );
		   }
	}else{
		if(is_admin()){
			load_textdomain( 'templatic-admin', TEVOLUTION_DIRECTORY_DIR.'languages/templatic-admin-'.$locale.'.mo' );
		}else{
			load_textdomain( 'templatic', TEVOLUTION_DIRECTORY_DIR.'languages/dirtemplatic-'.$locale.'.mo' );
		}
	}
	/*Include the tevolution plugins main file to use the core functionalities of plugin.*/
	if(is_plugin_active('Tevolution/templatic.php') && file_exists(WP_PLUGIN_DIR . '/Tevolution/templatic.php')){
		include_once( WP_PLUGIN_DIR . '/Tevolution/templatic.php');
	}else{
		add_action('admin_notices','directory_admin_notices');
	}
	
	if(is_admin()){
		require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
	}	
	/* Bundle Box*/
	if(is_admin() && (isset($_REQUEST['page']) && $_REQUEST['page']=='templatic_system_menu')){
		include(TEVOLUTION_DIRECTORY_DIR."bundle_box.php");
		include(TEVOLUTION_DIRECTORY_DIR."install.php");
	}
	include(TEVOLUTION_DIRECTORY_DIR.'listing/listing.php');	
	
	include(TEVOLUTION_DIRECTORY_DIR.'functions/manage_function.php');
	
	/* renew product code starts here */
	if(is_admin()){
		$tmpl_renew_product = get_option('tmpl_renew_product');
			
		$tmpl_renew_product_array = explode(",",$tmpl_renew_product);
		foreach($tmpl_renew_product_array as $key=>$val)
		{
			$tmpl_renew_product_array = explode("=",$val);
			$tmpl_item_id[] = (isset($tmpl_renew_product_array[1]))?$tmpl_renew_product_array[1]:'';
			$tmpl_slug[(isset($tmpl_renew_product_array[1]))?$tmpl_renew_product_array[1]:''] = (isset($tmpl_renew_product_array[0]))?$tmpl_renew_product_array[0]:'';
			$tmpl_invoice_id[(isset($tmpl_renew_product_array[1]))?$tmpl_renew_product_array[1]:''] = (isset($tmpl_renew_product_array[2]))?$tmpl_renew_product_array[2]:'';
			$tmpl_invoice_item_id[(isset($tmpl_renew_product_array[1]))?$tmpl_renew_product_array[1]:''] = (isset($tmpl_renew_product_array[3]))?$tmpl_renew_product_array[3]:'';
		}
		if ( (is_network_admin() || !is_multisite() ) && in_array(TEVOLUTION_DIRECTORY_SLUG,$tmpl_slug)) {	
			$key = array_search(TEVOLUTION_DIRECTORY_SLUG, $tmpl_slug);
			add_action('after_plugin_row_'.TEVOLUTION_DIRECTORY_SLUG, 'tmpl_notify_tev_dir_renew_product',11);
		}
		if(!function_exists('tmpl_notify_tev_dir_renew_product'))
		{
			function tmpl_notify_tev_dir_renew_product($plugin_file, $plugin_data,$status)
			{
				$current = get_site_transient( 'update_plugins' );
				$tmpl_renew_product = get_option('tmpl_renew_product');
				$tmpl_renew_product_array = explode(",",$tmpl_renew_product);
				
				foreach($tmpl_renew_product_array as $key=>$val)
				{
					$tmpl_renew_product_array = explode("=",$val);
					$tmpl_item_id[] = $tmpl_renew_product_array[1];
					$tmpl_slug[$tmpl_renew_product_array[1]] = $tmpl_renew_product_array[0];
					$tmpl_invoice_id[$tmpl_renew_product_array[1]] = $tmpl_renew_product_array[2];
					$tmpl_invoice_item_id[$tmpl_renew_product_array[1]] = $tmpl_renew_product_array[3];
				}
				if ( (is_network_admin() || !is_multisite() ) && in_array(TEVOLUTION_DIRECTORY_SLUG,$tmpl_slug))
				{	
					$key = array_search(TEVOLUTION_DIRECTORY_SLUG, $tmpl_slug);
					echo '<tr class="plugin-update-tr tev-plugin-renew"><td colspan="3" class="plugin-update"><div class="update-message"> '.__('Your Membership has been expired. You can Renew it from ','templatic-admin') .'<span style="color: #0073aa; cursor: pointer;" id="tmpl_redirect" target="_blank" data-key="'.$key.'" data-invoice-id="'.$tmpl_invoice_id[$key].'" data-invoice-item-id="'.$tmpl_invoice_item_id[$key].'" class="thickbox" title="Templatic renew">'.__('Here','templatic-admin').'</span></div></td></tr>';
				
				 }
				 add_action('admin_footer','tmpl_redirect_temp');
			}
		}
	}
	/* renew product code ends here */
	
}else{
	add_action('admin_notices','directory_admin_notices');
}

/* This function display admin notice to activate Tevolution plugin, if they first activated Tevolution-Directory plugin */
function directory_admin_notices(){
	echo '<div class="error"><p>' . sprintf(__('You have not activated the base plugin %s. Please activate it to use Tevolution-Directory plugin.','templatic-admin'),'<b>Tevolution</b>'). '</p></div>';
}

/* action to include plugins sample data file */
add_action('admin_init','insert_directory_sample_data',20);
function insert_directory_sample_data()
{
	/* file to insert classified listing and set up widget in its sidebar */
	if(is_admin() && (isset($_REQUEST['listing_dummy']) && $_REQUEST['listing_dummy']!='')){
		include(TEVOLUTION_DIRECTORY_DIR."listing/listing_auto_install_xml.php");	
	}
}
/* Plugin action link filter call for display settings link in plugins page before deactivate plugin link */
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ),'directory_action_links'  );
function directory_action_links($links){
	if(!is_plugin_active('Tevolution/templatic.php')){
		return $links;
	}
	if (function_exists('is_active_addons') && is_active_addons('tevolution_directory')){
		$plugin_links = array('<a href="' . admin_url( 'admin.php?page=templatic_settings' ) . '">' . __( 'Settings', 'templatic-admin' ) . '</a>',);
	}else{
		$plugin_links = array('<a href="' . admin_url( 'admin.php?page=templatic_system_menu' ) . '">' . __( 'Settings', 'templatic-admin' ) . '</a>',);
	}
	return array_merge( $plugin_links, $links );
}
/*
 * Plugin Deactivation hook
 */
register_deactivation_hook(__FILE__,'unregister_directory_taxonomy');
function unregister_directory_taxonomy(){
	 update_option('directory_auto_install','false');
	 $post_type = get_option("templatic_custom_post");
	 $taxonomy = get_option("templatic_custom_taxonomy");
	 $tag = get_option("templatic_custom_tags");
	 $taxonomy_slug = $post_type['listing']['slugs'][0];
	 $tag_slug = $post_type['listing']['slugs'][1];

	 unset($post_type['listing']);
	 unset($taxonomy[$taxonomy_slug]);
	 unset($tag[$tag_slug]);
	 update_option("templatic_custom_post",$post_type);
	 update_option("templatic_custom_taxonomy",$taxonomy);
	 update_option("templatic_custom_tags",$tag);
	 update_option("tevolution_directory",'');
	 
	 //delete_option('hide_listing_ajax_notification');
	 unlink(get_template_directory()."/taxonomy-".$taxonomy_slug.".php");
	 unlink(get_template_directory()."/taxonomy-".$tag_slug.".php");
	 unlink(get_template_directory()."/single-listing.php");
}

/*Plugin activation hook for for set default value */
register_activation_hook(__FILE__,'directory_plugin_activate');
if(!function_exists('directory_plugin_activate')){
	function directory_plugin_activate(){
		/* If easy installer then perform simple process to intall data */ 
		global $pagenow;
		if($pagenow=='themes.php' || $pagenow=='theme-install.php') {
			update_option('directory_auto_install','true');
			global $wpdb;
			/* Alter term_icon field in terms table if not exists */
			$field_check = $wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_icon'");
			if('term_icon' != $field_check)	{
				$wpdb->query("ALTER TABLE $wpdb->terms ADD term_icon varchar(255) NOT NULL DEFAULT ''");
			}
			
			/* add rule for urls */
			$tevolution_taxonomies_data1 = get_option('tevolution_taxonomies_rules_data');
			$tevolution_taxonomies_data1['tevolution_single_post_add']['listing'] = 'listing';
			update_option('tevolution_taxonomies_rules_data',$tevolution_taxonomies_data1);
			if(function_exists('tevolution_taxonimies_flush_event'))
				tevolution_taxonimies_flush_event();
			/* Delete Tevolution query catch on permalink update  changes */
			$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name like '%s'",'%_tevolution_quer_%' ));
		}
		else {
			update_option('directory_auto_install','false');
		}
	}
}

/*
 *update directory_update_login plugin version after templatic member login
 */
add_action('wp_ajax_directory','directory_update_login');
function directory_update_login()
{
	/* Check auto update login form nonce */
	check_ajax_referer( 'directory', '_ajax_nonce' );
	$plugin_dir = rtrim( plugin_dir_path(__FILE__), '/' );
	require_once( $plugin_dir .  '/templatic_login.php' );	
	exit;
}
/* remove wp autoupdates */
add_action('admin_init','directory_wpup_changes',20);
function directory_wpup_changes(){
	/* remove wordpress update notification strip for directory plugin update */
	remove_action( 'after_plugin_row_Tevolution-Directory/directory.php', 'wp_plugin_update_row' ,10, 2 );
	$tmplsettings = get_option('templatic_settings');
	$map_settings = get_option('maps_setting');
	if(@$tmplsettings['category_googlemap_widget'] !='no' && @$map_settings['category_googlemap_widget'] =='yes'){
		$tmpldata['category_googlemap_widget']='yes';
		update_option('templatic_settings',array_merge($tmplsettings,$tmpldata));
	}
}
if(!defined('INCLUDE_ERROR'))
	define('INCLUDE_ERROR',__('System might facing the problem in include ','templatic'));
	
add_action('admin_init','tmpl_directory_show_items_inmenu');
/* make category and tags checked by default in menu section under screen options */
function tmpl_directory_show_items_inmenu(){

	if(get_option('select_cat_listing_option')!='Active')
	{
		$hidden_nav_boxes='';
		$hidden_nav_boxes = get_user_option( 'metaboxhidden_nav-menus' );
		
		$post_type = 'listing'; //Can also be a taxonomy slug
	    $post_type_nav_box = 'add-post-type-'.$post_type;
	   
	    if(@in_array($post_type_nav_box, $hidden_nav_boxes)):
	        foreach ($hidden_nav_boxes as $i => $nav_box):
	            if($nav_box == $post_type_nav_box)
	                unset($hidden_nav_boxes[$i]);
	        endforeach;
	       update_user_option(get_current_user_id(), 'metaboxhidden_nav-menus', $hidden_nav_boxes);
	    endif;

	    $listing_cat = 'listingcategory'; //Can also be a taxonomy slug
	    $post_type_nav_box = 'add-'.$listing_cat;

	    if(@in_array($post_type_nav_box, $hidden_nav_boxes)):
	        foreach ($hidden_nav_boxes as $i => $nav_box):
	            if($nav_box == $post_type_nav_box)
	                unset($hidden_nav_boxes[$i]);
	        endforeach;
	       update_user_option(get_current_user_id(), 'metaboxhidden_nav-menus', $hidden_nav_boxes);
	    endif;

	     $listing_tag = 'listingtags'; //Can also be a taxonomy slug
	    $post_type_nav_box = 'add-'.$listing_tag;

	    if(@in_array($post_type_nav_box, $hidden_nav_boxes)):
	        foreach ($hidden_nav_boxes as $i => $nav_box):
	            if($nav_box == $post_type_nav_box)
	                unset($hidden_nav_boxes[$i]);
	        endforeach;
	       update_user_option(get_current_user_id(), 'metaboxhidden_nav-menus', $hidden_nav_boxes);
	    endif;

	    update_option('select_cat_listing_option','Active');
	}
}	
?>