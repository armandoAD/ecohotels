<?php
/*
name : register custom place post type 
description : Register place taxonomy.
*/
if(!defined('CUSTOM_POST_TYPE_LISTING'))
	@define('CUSTOM_POST_TYPE_LISTING','listing');
define('CUSTOM_CATEGORY_TYPE_LISTING','listingcategory');
define('CUSTOM_TAG_TYPE_LISTING','listingtags');
define('CUSTOM_MENU_TITLE_LISTING',__('Listings','templatic-admin'));
define('CUSTOM_MENU_NAME_LISTING',__('Listings','templatic-admin'));
define('CUSTOM_MENU_SIGULAR_NAME_LISTING',__('Listing','templatic-admin'));
define('CUSTOM_MENU_ADD_NEW_LISTING',__('Add Listing','templatic-admin'));
define('CUSTOM_MENU_ADD_NEW_ITEM_LISTING',__('Add new listing','templatic-admin'));
define('CUSTOM_MENU_EDIT_LISTING',__('Edit','templatic-admin'));
define('CUSTOM_MENU_EDIT_ITEM_LISTING',__('Edit listing','templatic-admin'));
define('CUSTOM_MENU_NEW_LISTING',__('New listing','templatic-admin'));
define('CUSTOM_MENU_VIEW_LISTING',__('View listing','templatic-admin'));
define('CUSTOM_MENU_SEARCH_LISTING',__('Search listing','templatic-admin'));
define('CUSTOM_MENU_NOT_FOUND_LISTING',__('No listing found','templatic-admin'));
define('CUSTOM_MENU_NOT_FOUND_TRASH_LISTING',__('No listing found in trash','templatic-admin'));
define('CUSTOM_MENU_CAT_LABEL_LISTING',__('Listing Categories','templatic-admin'));
define('CUSTOM_MENU_CAT_TITLE_LISTING',__('Listing Categories','templatic-admin'));
define('CUSTOM_MENU_SIGULAR_CAT_LISTING',__('Category','templatic-admin'));
define('CUSTOM_MENU_CAT_SEARCH_LISTING',__('Search category','templatic-admin'));
define('CUSTOM_MENU_CAT_POPULAR_LISTING',__('Popular categories','templatic-admin'));
define('CUSTOM_MENU_CAT_ALL_LISTING',__('All categories','templatic-admin'));
define('CUSTOM_MENU_CAT_PARENT_LISTING',__('Parent category','templatic-admin'));
define('CUSTOM_MENU_CAT_PARENT_COL_LISTING',__('Parent category:','templatic-admin'));
define('CUSTOM_MENU_CAT_EDIT_LISTING',__('Edit category','templatic-admin'));
define('CUSTOM_MENU_CAT_UPDATE_LISTING',__('Update category','templatic-admin'));
define('CUSTOM_MENU_CAT_ADDNEW_LISTING',__('Add new category','templatic-admin'));
define('CUSTOM_MENU_CAT_NEW_NAME_LISTING',__('New category name','templatic-admin'));
define('CUSTOM_MENU_TAG_LABEL_LISTING',__('Listing Tags','templatic-admin'));
define('CUSTOM_MENU_TAG_TITLE_LISTING',__('Listing Tags','templatic-admin'));
define('CUSTOM_MENU_TAG_NAME_LISTING',__('Listing Tags','templatic-admin'));
define('CUSTOM_MENU_TAG_SEARCH_LISTING',__('Listing Tags','templatic-admin'));
define('CUSTOM_MENU_TAG_POPULAR_LISTING',__('Popular listing tags','templatic-admin'));
define('CUSTOM_MENU_TAG_ALL_LISTING',__('All listing tags','templatic-admin'));
define('CUSTOM_MENU_TAG_PARENT_LISTING',__('Parent listing tags','templatic-admin'));
define('CUSTOM_MENU_TAG_PARENT_COL_LISTING',__('Parent listing tags:','templatic-admin'));
define('CUSTOM_MENU_TAG_EDIT_LISTING',__('Edit listing tags','templatic-admin'));
define('CUSTOM_MENU_TAG_UPDATE_LISTING',__('Update listing tags','templatic-admin'));
define('CUSTOM_MENU_TAG_ADD_NEW_LISTING',__('Add new listing tags','templatic-admin'));
define('CUSTOM_MENU_TAG_NEW_ADD_LISTING',__('New listing tag name','templatic-admin'));

add_action('init','register_place_post_type',0);
function register_place_post_type()
{
	if(get_option('directory_auto_install') == 'true' || (is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX )):
	
	if(is_admin()){
		/* Check weather auto intall is completed or not */
		if(get_option('directory_auto_install') == 'true')
		{
			include(TEVOLUTION_DIRECTORY_DIR.'listing/install.php');	
		}
	}
	endif;
	
}

/* Hook to perform auto install */
add_action('admin_head','tmpl_directory_auto_install');

if(!function_exists('tmpl_directory_auto_install')) {
function tmpl_directory_auto_install() {
	global $pagenow;
	if(get_option('tmpl_is_tev_auto_insall') == 'true' && get_option('directory_auto_install') != 'true' && get_option('directory_auto_install') != ''):
	
	/* If plugin page display auto install process */
	if($pagenow=='plugins.php'):
		echo '<div id="auto_install_html" class="notice notice-info is-dismissible">
			<p>
				<strong id="custom_message"></strong>
				<img id="install_loader" src="'.TEVOLUTION_DIRECTORY_URL.'images/install_loader.gif">
			</p>
		</div>';
	endif;
	
	/* Action array to define auto intall process steps */
	$process_array[]=array('action'=>'tmpl_insert_listing_data','message'=>__('Setting up default options...','templatic-admin'));
	
	/* ajax url for auto install process */
	$ajax_url=esc_js( get_bloginfo( 'wpurl' ) . '/wp-admin/admin-ajax.php' );
	$counter=1;
	$total_step=count($process_array);
	echo '<script async type="text/javascript">window.onload = function () {
			jQuery("#auto_install_html .notice-dismiss").remove();';
			
	/* Call first step function on load */
	echo 'action_'.$process_array[0]['action'].'();';
	
	/* Loop through all process */
	foreach($process_array as $process)
	{
		$script_code='function action_'.$process['action'].'(){ 
				jQuery("#custom_message").html("'.$process['message'].'");
				jQuery.ajax({
				url:"'.$ajax_url.'",
				type:"POST",
				data:"action='.$process['action'].'&auto_install=yes",
				success:function(results) {
					setTimeout(
					  function() 
					  {  
					';
					if($total_step!=$counter)
					{
						$script_code.='action_'.$process_array[$counter]['action'].'();';
					}
					else{
						$script_code.='action_tmpl_directory_finish_install();';
						$script_code.='jQuery("#install_loader").remove();';
					}
					$script_code.='}, 1000);
				}
			});
		}';
		echo $script_code;
		$counter++;
	}
	echo 'function action_tmpl_directory_finish_install(){
		jQuery("#auto_install_html").remove();
		jQuery.ajax({
			url:"'.$ajax_url.'",
			type:"POST",
			data:"action=tmpl_directory_finish_default_install",
			success:function(results) {';
				if($pagenow=='plugins.php'):
					echo 'location.reload();';
				endif;
			echo '}
	}); }';
	echo '}</script>';
	else:
		update_option('directory_auto_install','true');
	endif;
}
}

/* Install listings auto install data */
add_action( 'wp_ajax_tmpl_insert_listing_data', 'tmpl_create_listing_auto_install_data' );
add_action( 'wp_ajax_tmpl_insert_listing_data', 'tables_creatation' );
add_action( 'wp_ajax_tmpl_insert_listing_data', 'register_place_post_type' );


if(!function_exists('tmpl_create_listing_auto_install_data')) {
function tmpl_create_listing_auto_install_data() {
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
	exit;
}
}

/* Complete listing auto install */
add_action( 'wp_ajax_tmpl_directory_finish_default_install', 'tmpl_finish_listing_auto_install_data' );
if(!function_exists('tmpl_finish_listing_auto_install_data')) {
function tmpl_finish_listing_auto_install_data() {
	global $wpdb;
	update_option('directory_auto_install','true');
	exit;
}
}

/*auto install listing sample data*/
function insert_listing_data()
{
	global $pagenow,$wpdb;
	$theme_name = wp_get_theme();
	if($pagenow == 'plugins.php' && !get_option('hide_listing_ajax_notification') && $theme_name != 'Directory 2')
	{
		$classified_auto_install = get_option('listing_auto_install');
		$param = 'insert';
		$submit_text = __('Install sample data','templatic-admin');
		$class = 'button button-primary';
		$msg =  __('Wish to insert listing sample data?','templatic-admin');
		?>
        <strong><?php echo $msg; ?> </strong><span><a href="<?php echo admin_url('plugins.php?listing_dummy='.$param); ?>" ><?php echo $submit_text; ?></a></span>
        <?php  echo ' <a href="http://templatic.com/docs/directory-plugin-guide/">'.__('Installation Guide','templatic-admin').'</a>';
	}
}
add_filter('post_type_key','listing_type_key');
function listing_type_key($post_type_key)
{
	if($post_type_key === 0)
	{
		$post_type_key = 'listing';
	}
	else
	{
		$post_type_key .= ',listing';
	}
	return $post_type_key;
}
?>