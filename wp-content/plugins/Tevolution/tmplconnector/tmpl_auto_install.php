<?php
/* Hook to insert pages user pages will be inserted into next process tmpl_insert_user_field */
add_action( 'wp_ajax_tmpl_insert_pages', 'tevolution_post_upgrade_insert' );
add_action( 'wp_ajax_tmpl_insert_pages', 'tmpl_create_success_page_if_not_exist' );

/* Hook to insert user custorm field and user pages */
add_action( 'wp_ajax_tmpl_insert_user_field', 'create_default_registration_customfields' );


/* Hook to insert monetization table/data and settings */
add_action( 'wp_ajax_tmpl_insert_monetize', 'transactions_table_create' );
add_action( 'wp_ajax_tmpl_insert_monetize', 'tmpl_create_auto_install_monetize' );

if(!function_exists('tmpl_create_auto_install_monetize')) {
function tmpl_create_auto_install_monetize() {
	  update_option('monetization', 'Active');
	  if (!get_option('currency_symbol'))
				update_option('currency_symbol', '$');
	  if (!get_option('currency_code'))
				update_option('currency_code', 'USD');
	  if (!get_option('currency_pos'))
				update_option('currency_pos', '1');
	  if (!get_option('tmpl_price_decimal_sep'))
				update_option('tmpl_price_decimal_sep', '.');
	  if (!get_option('tmpl_price_num_decimals'))
				update_option('tmpl_price_num_decimals', 2);
	  if (!get_option('tmpl_price_thousand_sep'))
				update_option('tmpl_price_thousand_sep', ',');

	  require_once(TEMPL_MONETIZATION_PATH . 'add_dummy_packages.php');
	  
	  
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
	if(!get_option('payment_method_prebanktransfer')){
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
	}
	/*	Updated default payment gateway option on plugin activation END	*/
	exit;
}
}

/* General settins hook */
add_action( 'wp_ajax_tmpl_insert_default_settings', 'tmpl_create_auto_install_default_settings' );
add_action( 'wp_ajax_tmpl_insert_default_settings', 'post_expire_session_table_create' );
add_action( 'wp_ajax_tmpl_insert_default_settings', 'tmpl_chk_rating_table' );

if(!function_exists('tmpl_create_auto_install_default_settings')) {
function tmpl_create_auto_install_default_settings() {
	global $wpdb,$pagenow,$table_name,$wp_rewrite;
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
	
	update_option('myplugin_redirect_on_first_activation', 'true');
	$default_pointers = "wp330_toolbar,wp330_media_uploader,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link";
	update_user_meta(get_current_user_id(),'dismissed_wp_pointers',$default_pointers);	
	
	/*Set Default permalink on theme activation: start*/
	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	$wp_rewrite->flush_rules();
	if(function_exists('flush_rewrite_rules')){
		flush_rewrite_rules(true);  
	}
	/*Set Default permalink on theme activation: end*/
	
	/*Tevolution login page */
	$templatic_settings=get_option('templatic_settings');
	if(!$templatic_settings)
	{
		$templatic_settings = array();
	}
	
	update_option('tevolution_cache_disable',1);
	    
	/* Set On anyone can register at the time of plugin activate */
	update_option('users_can_register',1);
	
	exit;
}
}

/* Complete auto install after activation of tevolution */

add_action( 'wp_ajax_tmpl_finish_default_install', 'tmpl_finish_default_auto_install' );

if(!function_exists('tmpl_finish_default_auto_install')) {
function tmpl_finish_default_auto_install() {
	global $wpdb;
	update_option('tmpl_is_tev_auto_insall','true');
	update_option('myplugin_redirect_on_first_activation', 'false');
	exit;
}
}
?>