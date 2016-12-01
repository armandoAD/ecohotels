<?php
/*
 * fetch price package in backend post add/edit 
 */
global $wp_query,$wpdb,$wp_rewrite;
define('TEMPL_MONETIZATION_PATH',TEMPL_MONETIZE_FOLDER_PATH . "templatic-monetization/"); 

/* including a language file */
if(file_exists(TEMPL_MONETIZE_FOLDER_PATH.'templatic-monetization/language.php'))
{
	include (TEMPL_MONETIZE_FOLDER_PATH . "templatic-monetization/language.php");
}
/* Function which call in wp-admin section */
if(is_admin() && strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){
	include (TEMPL_MONETIZE_FOLDER_PATH . "templatic-monetization/admin_monetization_functions.php");
}

/* including a functions file */
if(file_exists(TEMPL_MONETIZE_FOLDER_PATH.'templatic-monetization/price_package_functions.php'))
{
	include (TEMPL_MONETIZE_FOLDER_PATH . "templatic-monetization/price_package_functions.php");
}


if(file_exists(TEMPL_MONETIZATION_PATH."templatic-payment_options/admin_payment_functions.php") && is_admin() && strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){
	include(TEMPL_MONETIZATION_PATH."templatic-payment_options/admin_payment_functions.php");
}elseif(file_exists(TEMPL_MONETIZATION_PATH."templatic-payment_options/payment_functions.php")){
	include(TEMPL_MONETIZATION_PATH."templatic-payment_options/payment_functions.php");
}
	
add_action('admin_head','templ_add_pkg_js');
add_action('wp_head','templ_add_pkg_js');

/*
	Function to insert file for add/edit/delete options for payment options/gateway settings BOF 
*/
function payment_option_plugin_function(){
	if((isset($_GET['tab']) && $_REQUEST['tab'] == 'payment_options') && (!isset($_GET['payact']) && @$_GET['payact']=='')){
		templ_payment_methods();
	}else if((isset($_GET['tab']) && $_REQUEST['tab'] == 'currency_settings') && (!isset($_GET['payact']) && @$_GET['payact']=='')){
		tmpl_currency_settings();
	}else if((isset($_GET['payact']) && $_GET['payact']=='setting') && (isset($_GET['id']) && $_GET['id'] != '')){
		include (TEMPL_MONETIZATION_PATH."templatic-payment_options/admin_paymethods_add.php");
	}
}

/*
	return the script for fetching price packages
*/
function templ_add_pkg_js(){
	global $wp_query,$pagenow,$post;
	/* If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object	*/
	if($post)
		$is_tevolution_submit_form = get_post_meta( @$post->ID, 'is_tevolution_submit_form', true );
		$is_tevolution_upgrade_form = get_post_meta(@$post->ID, 'is_tevolution_upgrade_form', true );
		$is_frontend_submit_form = get_post_meta(@$post->ID, 'is_frontend_submit_form', true );
	if((is_page() &&  ($is_tevolution_upgrade_form==1 || $is_tevolution_submit_form==1 || $is_frontend_submit_form==1)) ||(is_admin() && ($pagenow=='post.php' || $pagenow== 'post-new.php'))){
		include(TEMPL_MONETIZE_FOLDER_PATH.'templatic-monetization/price_package_js.php'); 
	}
	
}
?>