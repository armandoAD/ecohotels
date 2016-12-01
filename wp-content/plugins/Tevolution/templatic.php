<?php
/*
Plugin Name: Tevolution
Plugin URI: http://templatic.com/docs/tevolution-guide/
Description: Tevolution is a collection of Templatic features to enhance your website.
Version: 2.3.6
Author: Templatic
Author URI: http://templatic.com/
*/
ob_start();
if (defined('WP_DEBUG') and WP_DEBUG == true){
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}
define('PLUGIN_FOLDER_NAME','Tevolution');
define('TEVOLUTION_VERSION','2.3.6');
@define('PLUGIN_NAME','Tevolution Plugin');
define('TEVOLUTION_SLUG','Tevolution/templatic.php');

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once(plugin_dir_path( __FILE__ ).'classes/templconnector.class.php' );

/* Plugin Folder URL*/
define( 'TEVOLUTION_PAGE_TEMPLATES_URL', plugin_dir_url( __FILE__ ) );
/* Plugin Folder Path*/
define( 'TEVOLUTION_PAGE_TEMPLATES_DIR', plugin_dir_path( __FILE__ ) );

/*included the class-wp-list-table.php wordpress file*/
include_once(plugin_dir_path( __FILE__ ).'class-wp-list-table.php');

define('TEMPL_MONETIZE_FOLDER_PATH', plugin_dir_path( __FILE__ ).'tmplconnector/monetize/');
define('TEMPL_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('TT_CUSTOM_USERMETA_FOLDER_PATH',TEMPL_MONETIZE_FOLDER_PATH.'templatic-registration/custom_usermeta/');
define('TEMPL_PAYMENT_FOLDER_PATH',TEMPL_MONETIZE_FOLDER_PATH.'templatic-monetization/templatic-payment_options/payment/');
define('MY_PLUGIN_SETTINGS_URL',site_url().'/wp-admin/admin.php?page=templatic_system_menu&activated=true');

/* add localization for plugins */
add_action('init','tmpl_localization');
function tmpl_localization(){
	$locale = get_locale();
	if(is_admin()){
		load_textdomain( 'templatic-admin', plugin_dir_path( __FILE__ ).'languages/templatic-admin-'.$locale.'.mo' );
		load_textdomain( 'templatic', plugin_dir_path( __FILE__ ).'languages/templatic-'.$locale.'.mo' );
	}else{
		load_textdomain( 'templatic' , plugin_dir_path( __FILE__ ).'languages/templatic-'.$locale.'.mo' );
	}
}
global $templatic,$wpdb,$tevolutions_icon;
$tevolutions_icon = array('event,listing');
$wpdb->query("set sql_big_selects=1");
if(class_exists('templatic')){
	$templatic = new Templatic( __FILE__ );
	global $templatic;
}
if ( ! class_exists( 'Templatic_connector' ) ) {
	require_once( plugin_dir_path( __FILE__ ).'classes/templconnector.class.php' );
	$templconnector = new Templatic_connector( __FILE__ );
	global $templconnector;
}

if ( apply_filters( 'tmplconnector_enable', true ) == true ) {
	if(!function_exists('wp_get_current_user')) {
		include(ABSPATH . "wp-includes/pluggable.php"); 
	}
	$file = dirname(__FILE__);
	$content_dir = explode("/",WP_CONTENT_DIR);
	$file = substr($file,0,stripos($file, $content_dir[1]));

   require_once( plugin_dir_path( __FILE__ ).'tmplconnector/templatic-connector.php' );
   require_once( plugin_dir_path( __FILE__ ).'tmplconnector/tmpl_auto_install.php' );
   require_once( plugin_dir_path( __FILE__ ).'tmplconnector/tevolution_page_templates.php' );
   require_once( plugin_dir_path( __FILE__ ).'tmplconnector/tevolution_ajax_results.php' );
   require_once( plugin_dir_path( __FILE__ ).'tmplconnector/shortcodes/shortcode-init.php' );
   if(!strstr($_SERVER['REQUEST_URI'],'plugin-install.php')  ){
   		require_once( plugin_dir_path( __FILE__ ).'tmplconnector/taxonomies_permalink/taxonomies_permalink.php' );
   }
	
	global $tmplconnector;
	/* remove custom user meta box*/
	function remove_custom_metaboxes() {
		$custom_post_types_args = array();
		$custom_post_types = get_post_types($custom_post_types_args,'objects');
		foreach ($custom_post_types as $content_type){
			remove_meta_box( 'postcustom' , $content_type->name , 'normal' ); /*removes custom fields for page*/
		}
	}
	add_action( 'admin_menu' , 'remove_custom_metaboxes' );
}

/*Change apache AllowOverride in overview page*/
if(function_exists("is_admin") && is_admin() && @$_REQUEST['page'] == "templatic_system_menu"){
	ini_set("AllowOverride","All");
}

/* set tevolution settings while plugin activation */
if ( ! function_exists('tmpl_tev_plugin_activate') ) :
	function tmpl_tev_plugin_activate() {
		global $pagenow,$wpdb;
		/* If easy installer then follow normal process */
		if($pagenow=='themes.php' || $pagenow=='theme-install.php') {
			
			update_option('tmpl_is_tev_auto_insall','true');
			update_option('templatic-login','Active');
			/*set templatic settings option */
			$templatic_settings=get_option('templatic_settings');
			$settings=array(
							 'templatic_view_counter' 			=> 'Yes',
							 'default_page_view'                => 'listview',
							 'templatic_image_size'            	=> '50000',
							 'facebook_share_detail_page'      	=> 'yes',
							 'google_share_detail_page'        	=> 'yes',
							 'twitter_share_detail_page'       	=> 'yes',
							 'pintrest_detail_page'            	=> 'yes',
							 'related_post' 					=> 'categories',
							 'php_mail'							=> 'php_mail',
							 'templatic-category_custom_fields'	=> 'No',
							 'templatic-category_type'         	=> 'checkbox',
							 'tev_accept_term_condition'       	=> 1,						 
							 'listing_email_notification' 		=> 5,
							 'templatin_rating' 				=> 'yes',
							 'post_default_status'				=> 'draft',
							 'post_default_status_paid' 		=> 'publish',
							 'send_to_frnd'   					=> 'send_to_frnd',
							 'send_inquiry'   					=> 'send_inquiry',
							 'allow_autologin_after_reg' 		=> '1',
							 'show_dashboard_bar'				=> '1',
							 'templatic-current_tab'			=> 'current',
							 'templatic-sort_order'				=> 'published',
							 'pippoint_effects'               	 => 'click',
							 'sorting_type'                    	=> 'select',
							 'sorting_option'                  	=> array('title_alphabetical','title_asc','title_desc','date_asc','date_desc','reviews','rating','random','stdate_low_high','stdate_high_low'),    
							 'templatic_widgets' 				=> array( 'templatic_browse_by_categories','templatic_browse_by_tag','templatic_aboust_us')
							);
				
				if(empty($templatic_settings))
				{
					update_option('templatic_settings',$settings);	
				}else{
					update_option('templatic_settings',array_merge($templatic_settings,$settings));
				}
				/* finish the templatic settings option */
			
			/*	Updated default payment gateway option on plugin activation START	*/
			if(!get_option('payment_method_paypal')){
				$paypal_update = array(
					'name' => 'PayPal',
					'key' => 'paypal',
					'isactive' => 1,
					'display_order' => 1,
					'payOpts' => array
						(
							array
								(
									'title' =>  __('Your PayPal Email','templatic-admin'),
									'fieldname' => 'merchantid',
									'value' => 'email@example.com',
									'description' =>  __('Example: email@example.com','templatic-admin')
								),
						),			
				);
				update_option('payment_method_paypal',$paypal_update);
			}
			/*	Updated default payment gateway option on plugin activation END	*/
			
			update_option('myplugin_redirect_on_first_activation', 'true');
			$default_pointers = "wp330_toolbar,wp330_media_uploader,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link";
			update_user_meta(get_current_user_id(),'dismissed_wp_pointers',$default_pointers);	
			
			/*Set Default permalink on theme activation: start*/
			global $wp_rewrite;
			$wp_rewrite->set_permalink_structure( '/%postname%/' );
			$wp_rewrite->flush_rules();
			if(function_exists('flush_rewrite_rules')) {
				flush_rewrite_rules(true);  
			}
			/*Set Default permalink on theme activation: end*/
			/*Tevolution login page */
			$templatic_settings=get_option('templatic_settings');
			if(!$templatic_settings) {
				$templatic_settings = array();
			}
			$login_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_name = 'login'" );
			if($login_id=='') {	
				$login_data = array(
				'post_status' 		=> 'publish',
				'post_type' 		=> 'page',
				'post_author' 		=> 1,
				'post_name' 		=> 'login',
				'post_title' 		=> 'Login',
				'post_content' 		=> '[tevolution_login][tevolution_register]',
				'post_parent' 		=> 0,
				'comment_status' 	=> 'closed'
				);
				$login_id = wp_insert_post( $login_data );
				update_post_meta($login_id,'_wp_page_template','default');
				
				$tmpdata['tevolution_login'] = $login_id;
				$templatic_settings=array_merge($templatic_settings,$tmpdata);			
				update_option('templatic_settings',$templatic_settings);
				update_option('tevolution_login',$login_id);
			
			}
			/*Tevolution Register Page */
			$register_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_name = 'register'" );
			if($register_id=='') {	
				$register_data = array(
				'post_status' 		=> 'publish',
				'post_type' 		=> 'page',
				'post_author' 		=> 1,
				'post_name' 		=> 'register',
				'post_title' 		=> 'Register',
				'post_content' 		=> '[tevolution_register]',
				'post_parent' 		=> 0,
				'comment_status' 	=> 'closed'
				);
				$register_id = wp_insert_post( $register_data );
				update_post_meta($register_id,'_wp_page_template','default');
				$tmpdata['tevolution_register'] = $register_id;
				$templatic_settings=array_merge($templatic_settings,$tmpdata);			   
				update_option('templatic_settings',$templatic_settings);
				update_option('tevolution_register',$register_id);
			}
			/*Tevolution Register Page */
			$profile_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_name = 'profile'" );
			if($profile_id=='') {	
				$profile_data = array(
				'post_status' 		=> 'publish',
				'post_type' 		=> 'page',
				'post_author' 		=> 1,
				'post_name' 		=> 'profile',
				'post_title' 		=> 'Edit Profile',
				'post_content' 		=> '[tevolution_profile]',
				'post_parent' 		=> 0,
				'comment_status' 	=> 'closed'
				);
				$profile_id = wp_insert_post( $profile_data );
				update_post_meta($profile_id,'_wp_page_template','default');
				$tmpdata['tevolution_profile'] = $profile_id;
				$templatic_settings=array_merge($templatic_settings,$tmpdata);
				update_option('templatic_settings',$templatic_settings);
				update_option('tevolution_profile',$profile_id);
			}
			
			update_option('tevolution_cache_disable',1);
				
			/* Set On anyone can register at the time of plugin activate */
			update_option('users_can_register',1);
		} else {
			update_option('tmpl_is_tev_auto_insall','false');
		}
		
		if(!get_option('payment_method_prebanktransfer')) {
			$prebanktransfer_update = array(
				'name' => 'Pre Bank Transfer',
				'key' => 'prebanktransfer',
				'isactive' => 1,
				'display_order' => 6,
				'payOpts' => array
					(
						array
							(
								'title' => __('Bank Information','templatic-admin'),
								'fieldname' => 'bankinfo',
								'value' => 'ICICI Bank',
								'description' => __('Enter the bank name to which you want to transfer payment','templatic-admin')
							),
						array
							(
								'title' =>  __('Account ID','templatic-admin'),
								'fieldname' => 'bank_accountid',
								'value' => 'AB1234567890',
								'description' =>  __('Enter your bank Account ID','templatic-admin')
							),
					),
			);
			update_option('payment_method_prebanktransfer',$prebanktransfer_update);
			
			/* sechudle daily for license key */
			if (!wp_next_scheduled ( 'tmpl_schedule_license_key' )) {
				wp_schedule_event(time(), 'daily', 'tmpl_schedule_license_key');
			}
		}
		wp_schedule_event( time(), 'daily', 'daily_schedule_expire_session');
		
		
		$field_check = $wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_price'");
		if('term_price' != $field_check){
			$wpdb->query("ALTER TABLE $wpdb->terms ADD term_price varchar(100) NOT NULL DEFAULT '0'");
		}
	}
endif;

/* function called while plugin deactivation */
if ( ! function_exists('tmpl_tev_plugin_deactivate') ) :
	function tmpl_tev_plugin_deactivate() {
		update_option('tmpl_is_tev_auto_insall','false');
		delete_option('myplugin_redirect_on_first_activation');	
		/*Clear scheduled event on plugin deactivate hook */
		wp_clear_scheduled_hook( 'daily_schedule_expire_session' );
		wp_clear_scheduled_hook( 'tmpl_schedule_license_key' );
	}
endif;

/* set tevolution settings while plugin activation */
register_activation_hook(__FILE__, 'tmpl_tev_plugin_activate');

/* delete the option while plugin deactivation*/
register_deactivation_hook(__FILE__, 'tmpl_tev_plugin_deactivate');

/**
* To delete current author post
*/
add_action( 'wp_ajax_delete_auth_post', 'delete_auth_post_function' );
add_action( 'wp_ajax_nopriv_delete_auth_post', 'delete_auth_post_function' );
if( !function_exists( 'delete_auth_post_function' ) ) :
	function delete_auth_post_function() {
		check_ajax_referer( 'auth-delete-post', 'security' );
		global $current_user;
		$post_authr = get_post( @$_POST['postId'] );
		if( $post_authr->post_author == $current_user->ID ){
			wp_delete_post( intval($_POST['postId']), true );
			echo $_REQUEST['currUrl'];
		}
		die;
	}
	
endif;

/*
 * Update tevolution plugin version after templatic member login
 */
add_action('wp_ajax_tevolution','tevolution_update_login');

if ( ! function_exists('tevolution_update_login') ) :
	function tevolution_update_login() {
		check_ajax_referer( 'tevolution', '_ajax_nonce' );
		$plugin_dir = rtrim( plugin_dir_path(__FILE__), '/' );
		require_once( $plugin_dir .  '/templatic_login.php' );
		exit;
	}
endif;

/* remove wp autoupdates */
add_action('admin_init','templatic_wpup_changes',20);

if ( ! function_exists('templatic_wpup_changes') ) :
	function templatic_wpup_changes(){
		remove_action( 'after_plugin_row_Tevolution/templatic.php', 'wp_plugin_update_row' ,10, 2 );
	}
endif;

/* plug-in activation - settings link*/
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ),'tevolution_action_links'  );

if ( ! function_exists('tevolution_action_links') ) :
	function tevolution_action_links($links) {
		$plugin_links = array('<a href="' . admin_url( 'admin.php?page=templatic_settings' ) . '">' . __( 'Settings', 'templatic' ) . '</a>');
		return array_merge( $plugin_links, $links );
	}
endif;

/*
	Return the plugin directory path
*/
if(!function_exists('get_tmpl_plugin_directory')) :
	function get_tmpl_plugin_directory() {
		 return trailingslashit(WP_PLUGIN_DIR);
	}
endif;

/* Provide REST api compatibility with tevolution and directory */
if( is_plugin_active( 'rest-api/plugin.php' ) ) {
	/* Include main api file for tevolution	 */
	include_once( dirname( __FILE__ ) . '/api/tevolution-wp-json-api-v2.php' );
}


/*  */
if( is_plugin_active( 'json-rest-api/plugin.php' ) ) {
	/* Include main api file for tevolution	 */
	include_once( dirname( __FILE__ ) . '/api/tevolution-wp-json-api.php' );
		
	$wp_json_city = new Tevolution_wp_json_api( $server );
	add_filter( 'json_endpoints', array( $wp_json_city, 'register_routes' ), 0 );
	add_filter( 'json_prepare_city', array( $wp_json_city, 'add_post_type_data' ), 10, 3 );
}

/* user useages curl responce */
$site_info_tracking_allow = get_option("tmpl_site_info_tracking");
$get_usages_date = get_option('tmpl_usages_last_date');
if($site_info_tracking_allow == 1 && empty($get_usages_date) || (time() > $get_usages_date)) {
    
    /* set time to schedule usage report */
    $next_schedule_date = strtotime("+15 days");
    update_option('tmpl_usages_last_date',$next_schedule_date);
    include_once( dirname( __FILE__ ) . '/api/usages-report.php' );
}
?>