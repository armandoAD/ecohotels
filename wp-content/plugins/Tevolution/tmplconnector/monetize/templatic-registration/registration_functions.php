<?php
/*
 * login and register function.
 */
add_action('login_form','sfc_register_add_login_button');	

/*
	Function to insert file for add/edit/delete options for custom fields EOF
*/
function sfc_register_add_login_button() {
	if(isset($_REQUEST['ptype']) && $_REQUEST['ptype']!=''){		
		echo '<p><fb:login-button v="2" registration-url="'.site_url('wp-login.php?action=register', 'login').'" scope="email,user_website" onlogin="window.location.reload();" /></p>';
	}
}
/*	function to check auto login after register or not */
function allow_autologin_after_reg()
{
  if (get_option('allow_autologin_after_reg') || get_option('allow_autologin_after_reg') == '')
  { 
	return true; 
  }else{
    return false;
  }
}

/* this function will fetch the current user */

add_action('admin_init','user_role_assign');
function user_role_assign()
{
	global $current_user;
	$current_user = wp_get_current_user();
}
/* fetch the user */

/* Social media links for current author */

function tmpl_curentauth_social_links($curauth){ 
	global $form_fields_usermeta,$current_user;
	?>
	<div class="author_social_networks social_media">
	<ul class="social_media_list">
	   <?php 
		$facebook=get_user_meta($curauth->ID,'facebook',true);
		$twitter=get_user_meta($curauth->ID,'twitter',true);
		$linkedin=get_user_meta($curauth->ID,'linkedin',true);
		$email=get_user_meta($curauth->ID,'user_email',true);
		$google=get_user_meta($curauth->ID,'user_google',true);
		/* give the author's social media contacts link */
		do_action('tmpl_social_media_list_start');
		if($facebook!=''):  ?>
		<li><a href="<?php echo (strstr($facebook,'http'))?$facebook:'http://'.$facebook; ?>" target="_blank"><i class="fa fa-facebook" title="<?php _e("Facebook",'templatic');?>"></i></a></li>
		<?php endif;
		
		if($twitter):
		if (!strstr($twitter, 'http'))
            $twitter = 'http://' . $twitter;
		?>
		<li><a href="<?php echo $twitter; ?>" target="_blank"><i class="fa fa-twitter" title="<?php _e("Twitter",'templatic');?>"></i></a></li>
		<?php endif;
		
		if($google):
		if (!strstr($google, 'http'))
            $google = 'http://' . $google;
		?>
		<li><a href="<?php echo $google; ?>" target="_blank"><i class="fa fa-google-plus" title="<?php _e("Google Plus",'templatic');?>"></i></a></li>
		<?php endif;
		
		if($linkedin):
		if (!strstr($linkedin, 'http'))
            $linkedin = 'http://' . $linkedin;
		?>
		<li><a href="<?php echo $linkedin; ?>" target="_blank"><i class="fa fa-linkedin" title="<?php _e("LinkedIn",'templatic');?>"></i></a></li>
		<?php endif;
		if($curauth->user_email && $form_fields_usermeta['user_email']['on_author_page'] == 1 && $curauth->ID != $current_user->ID) { ?>
		<li><a href="mailto:<?php echo antispambot($curauth->user_email); ?>" ><i class="fa fa-envelope-o" title="<?php _e("Contact Me",'templatic');?>"></i></a></li>
		<?php } 
		do_action('tmpl_social_media_list_end');
		/* give the author's social media contacts link end */
		?>
	   </ul>
	</div>
<?php
}

/* to get the post types link on author page */
add_action('tmpl_get_authorpage_posttypes_tabs','tmpl_get_authorpage_posttypes_tabs');
function tmpl_get_authorpage_posttypes_tabs($curauth){
		
		global $current_user,$wpdb;
				
		$dirinfo = wp_upload_dir();
		$path = $dirinfo['path'];
		$url = $dirinfo['url'];
		$subdir = $dirinfo['subdir'];
		$basedir = $dirinfo['basedir'];
		$baseurl = $dirinfo['baseurl'];
		
		$i=0;  
		$author_link=apply_filters('templ_login_widget_dashboardlink_filter',get_author_posts_url($curauth->ID));
		if(strpos($author_link, "?"))
			$author_link=apply_filters('templ_login_widget_dashboardlink_filter',get_author_posts_url($curauth->ID))."&";
		else
			$author_link=apply_filters('templ_login_widget_dashboardlink_filter',get_author_posts_url($curauth->ID))."?";


		$obj = get_post_type_object( 'post' );			
		$cur_obj = get_post_type_object(CUSTOM_POST_TYPE_LISTING);
		$activetab=(isset($_REQUEST['custom_post']) && 'post'== $_REQUEST['custom_post']) ?'nav-author-post-tab-active active':'';
		?>
		<ul class="tabs">  
		<?php
		$posttaxonomy = apply_filters('tevolution_custom_post_type',get_option("templatic_custom_post"));
		
		do_action('tmpl_before_author_page_posttype_tab');
		foreach($posttaxonomy as $key=>$_posttaxonomy):					
			
			do_action('tmpl_before_author_page_'.$key.'_tab');
			
			$active_tab=(isset($_REQUEST['custom_post']) && $key==$_REQUEST['custom_post']) ?'active':'';
			if($active_tab=="" && !isset($_REQUEST['custom_post']))
			{
			// && $cur_obj->labels->singular_name !=''
				if($i==0 && !function_exists('tmpl_before_author_page_posttype_tab_return'))
				{
					$active_tab ='active';
					/* When no pot type tab is selected on author page - the first post type should be pass to get the default post type of tab*/
					if(!isset($_REQUEST['custom_post']) && !function_exists('tmpl_before_author_page_posttype_tab_return')){
						$_REQUEST['custom_post'] = $key;
					}
					$custom_post_type=$key;
					$i++;
				}else{
					$key = get_post_type();
					$_REQUEST['custom_post'] = get_post_type();
				}
			}
		
			if(function_exists('icl_register_string')){
				icl_register_string('templatic',$_posttaxonomy['label'].'author',$_posttaxonomy['label']);
				$_posttaxonomy['label'] = icl_t('templatic',$_posttaxonomy['label'].'author',$_posttaxonomy['label']);
			}
			
			/* return true if user submitted the posts in post type */
	
			$active_tab=(isset($_REQUEST['custom_post']) && $_REQUEST['custom_post']==$key) ?'active':'';
		
	
			?>
			
			<li class="tab-title <?php echo $active_tab;?>" role="presentational"><a href="<?php echo $author_link;?>custom_post=<?php  echo $key;?>" ><?php echo $_posttaxonomy['labels']['menu_name']; ?></a>
			</li>           
		
		<?php 
			do_action('tmpl_after_author_page_'.$key.'_tab');
		
		endforeach; 
		do_action('tmpl_after_author_page_posttype_tab');
		
		
		global $current_user,$curauth;
		
		$active_tab=(isset($_REQUEST['custom_post']) && $_REQUEST['custom_post']=='post') ?'active':'';
		?>
			<li class="tab-title <?php echo $active_tab;?>" ><a href="<?php echo $author_link;?>custom_post=post" role="tab" tabindex="0"><?php echo $obj->labels->singular_name;?></a></li>				
		<?php do_action('tevolution_author_tab');?>
		</ul>  
		<?php
		global $wp_query;
		if(isset($_REQUEST['custom_post']) && $_REQUEST['custom_post']!="")
			$post_type=$_REQUEST['custom_post'];
		else
			$post_type=$custom_post_type;
		
		$posts_per_page=get_option('posts_per_page');
		/*echo $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;*/
		$args=array(
				'post_type'  =>$post_type,
				'author'=>$curauth->ID,
				'post_status' => array('publish','draft'),
				'posts_per_page' =>$posts_per_page,
				'paged'=>$paged,
				'order_by'=>'date',
				'order' => 'DESC'
			);						
		query_posts( $args );					
		do_action('tevolution_author_query');	

}
/* get the photo of user/author if we call this on author page it will also display the edit profile link */

function tmpl_get_author_photo($curauth,$is_author=0){
	global $form_fields_usermeta,$current_user;
	
	do_action('tmpl_before_author_photo');
	if($form_fields_usermeta['profile_photo']['on_author_page']){
		if(get_user_meta($curauth->ID,'profile_photo',true) != ""){
			echo '<img src="'.get_user_meta($curauth->ID,'profile_photo',true).'" alt="'.$curauth->display_name.'" title="'.$curauth->display_name.'" />';
		}else{
			echo get_avatar($curauth->ID, apply_filters('tev_gravtar_size',32) ); 
		}
		
	}
	
	/* Display edit profile link on only author page */
	
	if($is_author == 1){ 
	if($current_user->ID == $curauth->ID)
	{
		$profile_page_id	=	get_option('tevolution_profile');
		if(function_exists('icl_object_id')){
			$profile_page_id = icl_object_id($profile_page_id, 'page', false);
		}
		$profile_url=get_permalink($profile_page_id);
		?>
			<div class="editProfile"><a href="<?php echo $profile_url; ?>" ><?php _e('Edit Profile','templatic');?> </a> </div>
		<?php } 
		do_action('tmpl_after_author_photo');
	}
}
/*
	Author box on author.php file for desktop view 
*/

function tmpl_author_dashboard($content)
{	
	global $current_user,$wp_query,$wpdb;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$qvar = $wp_query->query_vars;
	$author = $qvar['author'];
	if(isset($_POST['author_custom_post']))
	{	
		update_user_meta( $_POST['author_id'], 'author_custom_post', $_POST['author_custom_post'] ); 
	}
	if(isset($author) && $author !='') :
		$curauth = get_userdata($qvar['author']);
	else :
		$curauth = get_userdata(intval($_REQUEST['author']));
	endif;	
	
		global $form_fields_usermeta;
		/* Fetch the user custom fields */
		$form_fields_usermeta=fetch_user_custom_fields();

		
		?>
		
		<div class="author_cont">
			<?php
			if(@$_SESSION['twitter_login'] == 'twitter_login')
			{
				echo '<div class="alert-box info radius">';_e('Please edit your','templatic'); echo ' <a href="'.get_tevolution_profile_permalink().'">';_e('profile','templatic'); echo '</a> '; _e('and mention your email address to get notifications','templatic'); echo '</div>';
				unset($_SESSION['twitter_login']);
			}
		?>
		<!-- Author photo on left side start -->
		<div class="author_photo">
		<?php 
		
			echo tmpl_get_author_photo($curauth,1);
			  
		?>
		</div>
		<!-- Author photo on left side end -->
		
		
		<!-- Author photo on right side start -->
		<div class="right_box">
			<?php 
			echo "<h2>".$curauth->display_name."</h2>";
				/* to get the user custom fidls and other details */
				echo tmpl_authorbox_right_content($curauth,$form_fields_usermeta); 
			?>
			<div class="clearfix"></div>
			<?php do_action('author_box_content');
			
			/* author page social medias link */
			if(function_exists('tmpl_curentauth_social_links'))
			echo tmpl_curentauth_social_links($curauth);
			?>

		</div>
		<!-- Author photo on right side end -->
		
<?php	do_action('tmpl_get_authorpage_posttypes_tabs',$curauth);		
}

/*
	Author box on author.php file for Mobile view 
*/

function tmpl_author_mobiledashboard($content)
{	
	global $current_user,$wp_query,$wpdb;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$qvar = $wp_query->query_vars;
	$author = $qvar['author'];
	if(isset($_POST['author_custom_post']))
	{	
		update_user_meta( $_POST['author_id'], 'author_custom_post', $_POST['author_custom_post'] ); 
	}
	if(isset($author) && $author !='') :
		$curauth = get_userdata($qvar['author']);
	else :
		$curauth = get_userdata(intval($_REQUEST['author']));
	endif;	
	
		global $form_fields_usermeta;
		/* Fetch the user custom fields */
		$form_fields_usermeta=fetch_user_custom_fields();

		
		?>
		
		<div class="author_cont">
		
		<!-- Author photo on left side start -->
		<div class="author_photo">
		<?php 
			
			echo tmpl_get_author_photo($curauth,1);
			
			/* author page social medias link */
			echo "<h2>".$curauth->display_name."</h2>";
			if(function_exists('tmpl_curentauth_social_links'))
			echo tmpl_curentauth_social_links($curauth);  
		?>
		</div>
		<!-- Author photo on left side end -->
		
		
		<!-- Author photo on right side start -->
		<div class="right_box">
			<?php 
				/* to get the user custom fidls and other details */
				echo tmpl_authorbox_right_content($curauth,$form_fields_usermeta); 
			?>
			<div class="clearfix"></div>
			<?php do_action('author_box_content');	?>

		</div>
		<!-- Author photo on right side end -->
		
<?php	do_action('tmpl_get_authorpage_posttypes_tabs',$curauth);		
}

/* 
	Filter to get the posts on author page
	trough this function author page query will be generated, so if we display on tab , related post type's listings will be display.
*/
add_action('pre_get_posts','tevolution_author_post');
function tevolution_author_post($query){
	$obj = get_post_type_object('listing');
	if(!is_admin()){
		if((is_author() || (isset($_REQUEST['custom_post']) && $_REQUEST['custom_post']!=''))){
			global $current_user;
			$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
			$i=0;

            /* added for getting current post type on initialy page load author page */
			$posttaxonomy = apply_filters('tevolution_custom_post_type',get_option("templatic_custom_post"));

			foreach($posttaxonomy as $key=>$_posttaxonomy){	
				if(!isset($_REQUEST['custom_post']) && !function_exists('tmpl_before_author_page_posttype_tab_return') && $obj->labels->singular_name !=''){
						$_REQUEST['custom_post'] = $key;
					}
					$custom_post_type=$key;
					break;
			}

			if(function_exists('tevolution_custom_post_type_return') && !isset($_REQUEST['custom_post']) && $_REQUEST['custom_post']=="" && $obj->labels->singular_name !=''){
				$_REQUEST['custom_post'] = apply_filters('tmpl_default_posttype','listing');
			}
			if(isset($_REQUEST['custom_post']) && $_REQUEST['custom_post']!=""){
				$post_type=$_REQUEST['custom_post'];
			}else{
				if(get_post_type() !=''){
					$post_type=get_post_type();
				}else{
					$post_type=$custom_post_type;
				}
			}
			
			/* Don't pass $post_type as in array() */
			$query->set('post_type',$post_type);
			if($author->ID == $current_user->ID)
			{
				$query->set('post_status', array('publish','draft','private'));
			}
			else
			{
				$query->set('post_status', array('publish'));
			}
			
		}
	}	
}

/*  Here I made an array of user custom fields */
if(!function_exists('user_fields_array')){
function user_fields_array()
{
	global $post;
	remove_all_actions('posts_where');
	$user_args=
	array( 'post_type' => 'custom_user_field',
	'posts_per_page' => -1	,
	'post_status' => array('publish'),
	'meta_query' => array(
	   'relation' => 'AND',
		array(
			'key' => 'on_registration',
			'value' =>  '1',
			'compare' => '='
		)
	),
	'meta_key' => 'sort_order',
	'orderby' => 'meta_value',
	'order' => 'ASC'
	);
	$user_meta_sql = null;
	$user_meta_sql = new WP_Query($user_args);
	if($user_meta_sql)
 	{
	while ($user_meta_sql->have_posts()) : $user_meta_sql->the_post();
	$name = $post->post_name;
	$site_title = $post->post_title;
	$type = get_post_meta($post->ID,'ctype',true);
	$is_require = get_post_meta($post->ID,'is_require',true);
	$admin_desc = $post->post_content;
	$option_values = get_post_meta($post->ID,'option_values',true);
	$on_registration = get_post_meta($post->ID,'on_registration',true);
	$on_profile = get_post_meta($post->ID,'on_profile',true);
	$on_author_page =  get_post_meta($post->ID,'on_author_page',true);
	if($type=='text'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'text',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="textfield"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix">',
		"outer_end"	=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		"on_author_page" => $on_author_page,
		);
	}elseif($type=='checkbox'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'checkbox',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="checkbox"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix checkbox_field">',
		"outer_end"	=>	'',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span></div>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		"on_author_page" => $on_author_page,
		);
	}elseif($type=='textarea'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'textarea',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="textarea"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix">',
		"outer_end"	=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		"on_author_page" => $on_author_page,
		);
		
	}elseif($type=='texteditor'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'texteditor',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="mce"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clear">',
		"outer_end"	=>	'</div>',
		"tag_before"=>	'<div class="clear">',
		"tag_after"=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		"on_author_page" => $on_author_page,
		);
	}elseif($type=='select'){
		/*$option_values=explode(",",$option_values );*/
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'select',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'"',
		"options"	=> 	$option_values,
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clear">',
		"outer_end"	=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		"on_author_page" => $on_author_page,
		);
	}elseif($type=='radio'){
		/*$option_values=explode(",",$option_values );*/
		$form_fields_usermeta[$name] = array(
			"label"		=> $site_title,
			"type"		=>	'radio',
			"default"	=>	$default_value,
			"extra"		=>	'',
			"options"	=> 	$option_values,
			"is_require"	=>	$is_require,
			"outer_st"	=>	'<div class="form_row clear">',
			"outer_end"	=>	'</div>',
			"tag_before"=>	'<div class="form_cat">',
			"tag_after"=>	'</div>',
			"tag_st"	=>	'',
			"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
			"on_registration"	=>	$on_registration,
			"on_profile"	=>	$on_profile,
			"on_author_page" => $on_author_page,
			);
	}elseif($type=='multicheckbox'){
		/*$option_values=explode(",",$option_values );*/
		$form_fields_usermeta[$name] = array(
			"label"		=> $site_title,
			"type"		=>	'multicheckbox',
			"default"	=>	$default_value,
			"extra"		=>	'',
			"options"	=> 	$option_values,
			"is_require"	=>	$is_require,
			"outer_st"	=>	'<div class="form_row clear">',
			"outer_end"	=>	'</div>',
			"tag_before"=>	'<div class="form_cat">',
			"tag_after"=>	'</div>',
			"tag_st"	=>	'',
			"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
			"on_registration"	=>	$on_registration,
			"on_profile"	=>	$on_profile,
			"on_author_page" => $on_author_page,
			);
	
	}elseif($type=='date'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'date',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="textfield_date"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix">',
		"outer_end"	=>	'</div>',		
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		"on_author_page" => $on_author_page,
		);
		
	}elseif($type=='upload'){
	$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'upload',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" class="textfield"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix upload_img">',
		"outer_end"	=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		"on_author_page" => $on_author_page,
		);
	}elseif($type=='head'){
	$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'head',
		"outer_st"	=>	'<h5 class="form_title">',
		"outer_end"	=>	'</h5>',
		);
	}elseif($type=='geo_map'){
	$form_fields_usermeta[$name] = array(
		"label"		=> '',
		"type"		=>	'geo_map',
		"default"	=>	$default_value,
		"extra"		=>	'',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'',

		"outer_end"	=>	'',
		"tag_st"	=>	'',
		"tag_end"	=>	'',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		"on_author_page" => $on_author_page,
		);		
	}elseif($type=='image_uploader'){
	$form_fields_usermeta[$name] = array(
		"label"		=> '',
		"type"		=>	'image_uploader',
		"default"	=>	$default_value,
		"extra"		=>	'',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'',
		"outer_end"	=>	'',
		"tag_st"	=>	'',
		"tag_end"	=>	'',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		"on_author_page" => $on_author_page,
		);
	}
  endwhile;
  return $form_fields_usermeta;
}
}
}

/* With the help of User custom fields array, To fetch out the user custom fields */

function display_usermeta_fields($user_meta_array)
{
	$form_fields_usermeta	= $user_meta_array;
	global $user_validation_info;
	$user_validation_info = array();
  foreach($form_fields_usermeta as $key=>$val)
	{
		
		if($key!='user_email' && $key!='user_fname')
			continue;
	$str = ''; $fval = '';
	$field_val = $key.'_val';
	if(isset($_REQUEST['user_fname']) || (!isset($_REQUEST['backandedit'])  && $_REQUEST['backandedit'] == '')){ $field_val = $_REQUEST[$key]; } elseif(isset($_REQUEST['backandedit']) && $_REQUEST['backandedit'] == '1' ) {$field_val = $_SESSION['custom_fields'][$key]; }
	if(@$field_val){ $fval = $field_val; }else{ $fval = $val['default']; }
   
	if($val['is_require'])
	{
		$user_validation_info[] = array(
								   'name'	=> $key,
								   'espan'	=> $key.'_error',
								   'type'	=> $val['type'],
								   'text'	=> $val['label'],
								   );
	}
	if($val['type']=='text')
	{
		$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';
		}
	}elseif($val['type']=='hidden')
	{
		$str = '<input name="'.$key.'" type="hidden" '.$val['extra'].' value="'.$fval.'">';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='textarea')
	{
		$str = '<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='file')
	{
		$str = '<input name="'.$key.'" type="file" '.$val['extra'].' value="'.$fval.'">';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='include')
	{
		$str = @include_once($val['default']);
	}else
	if($val['type']=='head')
	{
		$str = '';
	}else
	if($val['type']=='date')
	{
		?>
         <script type="text/javascript" async >	
				jQuery(function(){
				var pickerOpts = {
						showOn: "both",
						dateFormat: 'yy-mm-dd',
						monthNames: objectL11tmpl.monthNames,
						monthNamesShort: objectL11tmpl.monthNamesShort,
						dayNames: objectL11tmpl.dayNames,
						dayNamesShort: objectL11tmpl.dayNamesShort,
						dayNamesMin: objectL11tmpl.dayNamesMin,
						isRTL: objectL11tmpl.isRTL,
						buttonText: '<i class="fa fa-calendar"></i>',
					};	
					jQuery("#<?php echo $key;?>").datepicker(pickerOpts);					
				});
			</script>
        <?php
		$str = '<input name="'.$key.'" id="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';			
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catselect')
	{
		$term = get_term( (int)$fval, CUSTOM_CATEGORY_TYPE1);
		$str = '<select name="'.$key.'" '.$val['extra'].'>';
		$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
		$all_categories = get_categories($args);
		foreach($all_categories as $key => $cat) 
		{
		
			$seled='';
			if($term->name==$cat->name){ $seled='selected="selected"';}
			$str .= '<option value="'.$cat->name.'" '.$seled.'>'.$cat->name.'</option>';	
		}
		$str .= '</select>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catdropdown')
	{
		$cat_args = array('name' => 'post_category', 'id' => 'post_category_0', 'selected' => $fval, 'class' => 'textfield', 'orderby' => 'name', 'echo' => '0', 'hierarchical' => 1, 'taxonomy'=>CUSTOM_CATEGORY_TYPE1);
		$cat_args['show_option_none'] = __('Select Category','templatic');
		$str .=wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='select')
	{
		$str = '<select name="'.$key.'" '.$val['extra'].'>';
		 $str .= '<option value="" >'.PLEASE_SELECT.' '.$val['label'].'</option>';	
		$option_values_arr = explode(',', $val['options']);
		for($i=0;$i<count($option_values_arr);$i++)
		{
			$seled='';
			
			if($fval==$option_values_arr[$i]){ $seled='selected="selected"';}
			$str .= '<option value="'.$option_values_arr[$i].'" '.$seled.'>'.$option_values_arr[$i].'</option>';	
		}
		$str .= '</select>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catcheckbox')
	{
		$fval_arr = explode(',',$fval);
		$str .= $val['tag_before'].get_categories_checkboxes_form(CUSTOM_CATEGORY_TYPE1,$fval_arr).$oval.$val['tag_after'];
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catradio')
	{
		$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
		$all_categories = get_categories($args);
		foreach($all_categories as $key1 => $cat) 
		{
			
			
				$seled='';
				if($fval==$cat->term_id){ $seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$cat->name.'" '.$seled.'> '.$cat->name.$val['tag_after'];	
			
		}
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='checkbox')
	{
		if($fval){ $seled='checked="checked"';}
		$str = '<input name="'.$key.'" type="checkbox" '.$val['extra'].' value="1" '.$seled.'>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='upload')
	{
		
		$str = '<input name="'.$key.'" type="file" '.$val['extra'].' '.$uclass.' value="'.$fval.'" > ';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}
	else
	if($val['type']=='radio')
	{
		$options = $val['options'];
		if($options)
		{
			$option_values_arr = explode(',',$options);
			for($i=0;$i<count($option_values_arr);$i++)
			{
				$seled='';
				if($fval==$option_values_arr[$i]){$seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].'  value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
			}
			if($val['is_require'])
			{
				$str .= '<span id="'.$key.'_error"></span>';	
			}
		}
	}else
	if($val['type']=='multicheckbox')
	{
		$options = $val['options'];
		if($options)
		{  $chkcounter = 0;
			
			$option_values_arr = explode(',',$options);
			for($i=0;$i<count($option_values_arr);$i++)
			{
				$chkcounter++;
				$seled='';
				$fval_arr = explode(',',$fval);
				if(in_array($option_values_arr[$i],$fval_arr)){ $seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
			}
			if($val['is_require'])
			{
				$str .= '<span id="'.$key.'_error"></span>';	
			}
		}
	}
	else
	if($val['type']=='packageradio')
	{
		$options = $val['options'];
		foreach($options as $okey=>$oval)
		{
			$seled='';
			if($fval==$okey){$seled='checked="checked"';}
			$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$okey.'" '.$seled.'> '.$oval.$val['tag_after'];	
		}
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='geo_map')
	{
		do_action('templ_submit_form_googlemap');	
	}else
	if($val['type']=='image_uploader')
	{
		do_action('templ_submit_form_image_uploader');	
	}
	
	if (function_exists('icl_register_string')) {		
			icl_register_string('templatic', $val['type'].'_'.$key,$val['label']);	
			$val['label'] = icl_t('templatic', $val['type'].'_'.$key,$val['label']);
	   }
	if($val['is_require'])
	{
		$label = '<label>'.$val['label'].' <span class="indicates">*</span> </label>';
	}else
	{
		$label = '<label>'.$val['label'].'</label>';
	}
	if($val['type']=='texteditor')
			{
				echo $val['outer_st'].$label.$val['tag_st'];
				 echo $val['tag_before'].$val['tag_after'];
            /* default settings  */
					$settings =   array(
						'wpautop' => false,
						'media_buttons' => $media_pro,
						'textarea_name' => $key,
						'textarea_rows' => apply_filters('tmpl_wp_editor_rows',get_option('default_post_edit_rows',6)), /* rows="..."*/
						'tabindex' => '',
						'editor_css' => '<style>.wp-editor-wrap{width:640px;margin-left:0px;}</style>',
						'editor_class' => '',
						'toolbar1'=> 'bold,italic,underline,bullist,numlist,link,unlink,forecolor,undo,redo',
						'editor_height' => '150',
						'teeny' => false,
						'dfw' => false,
						'tinymce' => true,
						'quicktags' => false
					);					
					if(isset($fval) && $fval != '') 
					{  $content=$fval; }
					else{$content= $fval; } 				
					wp_editor( $content, $key, $settings);				
			
					if($val['is_require'])
					{
						$str .= '<span id="'.$key.'_error"></span>';	
					}
				echo $str.$val['tag_end'].$val['outer_end'];
			}else{	
				echo $val['outer_st'].$label.$val['tag_st'].$str.$val['tag_end'].$val['outer_end'];
			}
 }
}
/*
 fetch login and registration form in submit page template
*/

add_action('templ_fetch_registration_onsubmit','templ_fetch_registration_onsubmit');
function templ_fetch_registration_onsubmit(){
	if($_SESSION['custom_fields']['login_type'])
	{
		$user_login_or_not = $_SESSION['custom_fields']['login_type'];
	}
	if((isset($_SESSION['user_email']) && $_SESSION['user_email']!='') || (isset($_REQUEST['backandedit']) && $_REQUEST['backandedit'] == 1))
	{
		$user_login_or_not = 'new_user';
	}
	?>
	<div id="login_user_meta" <?php if($user_login_or_not=='new_user'){ echo 'style="display:block;"';}else{ echo 'style="display:none;"'; }?> >
		<input type="hidden" name="user_email_already_exist" id="user_email_already_exist" value="<?php if($_SESSION['custom_fields']['user_email_already_exist']) { echo "1"; } ?>" />
		<input type="hidden" name="user_fname_already_exist" id="user_fname_already_exist" value="<?php if($_SESSION['custom_fields']['user_fname_already_exist']) { echo "1"; } ?>" />
		<input type="hidden" name="login_type" id="login_type" value="<?php echo $_SESSION['custom_fields']['login_type']; ?>" />
		<input type="hidden" name="reg_redirect_link" value="<?php echo apply_filters('tevolution_register_redirect_to',@$_SERVER['HTTP_REFERER']);?>" />
	    <?php
			$user_meta_array = user_fields_array();
			display_usermeta_fields($user_meta_array);/* fetch registration form */
		?>
        <div class="form_row clearfix">
        	<input name="register" type="button" id="register_form" value="<?php echo __('Sign Up','templatic'); ?>" class="submit">
        </div>
        <?php
			include_once(TT_REGISTRATION_FOLDER_PATH . 'registration_validation.php');
		?>
	</div>
<?php
}
/*
	fetch login form in submit page template
*/

add_action('templ_fecth_login_onsubmit','templ_fecth_login_onsubmit');
function templ_fecth_login_onsubmit(){ 
	global $post;
?>
<p style="display:none;" class="status"></p>
	<div class="login_submit clearfix" id="loginform">
		<div class="sec_title">
			<h3 class="form_title spacer_none"><?php _e('Login or register','templatic');?></h3>
		</div>
		<?php 
		
		if($_SESSION['custom_fields']['login_type'])
		{
			$user_login_or_not = $_SESSION['custom_fields']['login_type'];
		}
		if(isset($_REQUEST['usererror'])==1)
		{
			if(isset($_SESSION['userinset_error']))
			{
				for($i=0;$i<count($_SESSION['userinset_error']);$i++)
				{
					echo '<div class="error_msg"><p>'.$_SESSION['userinset_error'][$i].'</p></div>';
				}
				
			}
		}
		
		if(isset($_REQUEST['emsg'])==1): ?>
			<div class="error_msg"><?php _e('Incorrect Username/Password.','templatic');?></div>
		<?php endif; ?>
		
		<div class="user_type clearfix">
			
			<label class="lab1"><?php _e('I am a','templatic');?> </label>
			<label class="radio_lbl"><input name="user_login_or_not" type="radio" value="existing_user" <?php if($user_login_or_not=='existing_user'){ echo 'checked="checked"';}else{ echo 'checked="checked"'; }?> onclick="set_login_registration_frm('existing_user');" /> <?php _e('Existing User','templatic');?> </label>
			<?php 
				$users_can_register = get_option('users_can_register');
				if($users_can_register):
			?><label class="radio_lbl"><input name="user_login_or_not" type="radio" value="new_user" <?php if($user_login_or_not=='new_user'){ echo 'checked="checked"';}?> onclick="set_login_registration_frm('new_user');" /> <?php _e('New User? Register Now','templatic');?> </label>
			<?php endif;
		do_action('tmpl_login_options');
		?>
		
		</div>
		
		<?php echo do_action('show_meida_login_button',$post->ID); ?>
		
		<!-- Login Form -->
		<div name="loginform" class="sublog_login" <?php if($user_login_or_not=='existing_user' || $user_login_or_not == '' ){ ?> style="display:block;" <?php } else {  ?> style="display:none;" <?php }?>  id="login_user_frm_id"  >
      
			<div class="form_row clearfix lab2_cont">
				<label class="lab2"><?php _e('Username','templatic');?><span class="required">*</span></label>
				<input type="text" class="textfield slog_prop " id="user_login" name="log" />
			</div>

			<div class="form_row learfix lab2_cont">
				<label class="lab2"><?php _e('Password','templatic');?><span class="required">*</span> </label>
				<input type="password" class="textfield slog_prop" id="user_pass" name="pwd" />
			</div>
		  
			<div class="form_row clearfix">
				<input name="submit_form_login" type="button" id="submit_form_login" value="<?php _e('Login','templatic');?>" class="button_green submit" />
			</div>
			<?php do_action('login_form');
			$login_redirect_link = get_permalink();?>
		  <input type="hidden" name="redirect_to" value="<?php echo $login_redirect_link; ?>" />
		  <input type="hidden" name="testcookie" value="1" />
		  <input type="hidden" name="pagetype" value="<?php echo $login_redirect_link; ?>" />
		  <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
          
		</div>
		<!-- Login Form End -->
    </div>
	<?php
	add_action('wp_footer','submit_form_ajax_login',20); /* call a function for ajax login.*/
} 

/*
* script for registration validation while submit form.
*/
function submit_form_ajax_login()
{
	?>
	<script type="text/javascript" async>
		jQuery(document).ready(function($) {
			var redirecturl = '<?php echo $_SESSION['redirect_to']; ?>';
			jQuery('form#submit_form #user_email').bind('keyup',function(){
				if(jQuery.trim(jQuery("form#submit_form #user_email").val()) != "")
				{
					var a = jQuery("form#submit_form #user_email").val();
					var emailReg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
					if(jQuery("form#submit_form #user_email").val() == "") { 
					<?php
					$msg = html_entity_decode(__("Please provide your email address",'templatic'),ENT_COMPAT, 'utf-8');
					?>
						jQuery("form#submit_form #user_email").addClass("error");
						jQuery("form#submit_form #user_email_error").text("<?php echo $msg; ?>");
						jQuery("form#submit_form #user_email_error").addClass("message_error2");
					return false;
						
					} else if(!emailReg.test(jQuery("form#submit_form #user_email").val().replace(/\s+$/,""))) { <?php
						$msg = html_entity_decode(__("Please enter a valid email address",'templatic'),ENT_COMPAT, 'utf-8');
						?>
						jQuery("form#submit_form #user_email").addClass("error");
						jQuery("form#submit_form #user_email_error").text("<?php echo $msg; ?>");
						jQuery("form#submit_form #user_email_error").addClass("message_error2");
						return false;
					} else {
					chkemail(jQuery("form#submit_form #user_email").val());
					var chk_email = document.getElementById("user_email_already_exist").value;

						if(chk_email > 0)
						{
							
							jQuery("form#submit_form #user_email_already_exist").val(1);
							jQuery("form#submit_form #user_email_error").removeClass('message_error2');
							jQuery("form#submit_form #user_email_error").addClass('available_tick');
							jQuery("form#submit_form #user_email_error").html("<?php _e('The email address is correctly entered.','templatic');?>");
							jQuery("form#submit_form #user_email").removeClass("error");
							jQuery("form#submit_form #user_email_error").removeClass("message_error2");
							return true;
						}
						else{
							jQuery("form#submit_form #user_email_error").html("<?php _e('Email address already exists, Please enter another email','templatic');?>");
							jQuery("form#submit_form #user_email_already_exist").val(0);
							jQuery("form#submit_form #user_email_error").removeClass('available_tick');
							jQuery("form#submit_form #user_email_error").addClass('message_error2');
							return false;
						}
					}
				}
			});
			jQuery(document).on('keyup','form#submit_form #user_fname', function(){
				if(jQuery.trim(jQuery("form#submit_form #user_fname").val()) != "")
				{
					var a = jQuery("form#submit_form #user_fname").val();
					var userLength = jQuery("form#submit_form #user_fname").val().length;
					if(jQuery("form#submit_form #user_fname").val() == "") {
							jQuery("form#submit_form #user_fname").addClass("error");
							jQuery("form#submit_form #user_fname_error").text("<?php echo $msg; ?>");
							jQuery("form#submit_form #user_fname_error").addClass("message_error2");
							
					}else if(jQuery("form#submit_form #user_fname").val().match(/\ /)){
						jQuery("form#submit_form #user_fname").addClass("error");
						jQuery("form#submit_form #user_fname_error").text("<?php _e("Usernames should not contain space.",'templatic'); ?>");
						jQuery("form#submit_form #user_fname_error").addClass("message_error2");
						return false;
					}else if(userLength < 4 ){
						jQuery("form#submit_form #user_fname").addClass("error");
						jQuery("form#submit_form #user_fname_error").text("<?php _e("The username must be at least 4 characters long",'templatic'); ?>");
						jQuery("form#submit_form #user_fname_error").addClass("message_error2");
						return false;
					}else
					{
						chkname(jQuery("form#submit_form #user_fname").val());
						var chk_fname = document.getElementById("user_fname_already_exist").value;
						if(chk_fname > 0)
						{
							jQuery("form#submit_form #user_fname_error").html("<?php _e('This username is available.','templatic');?>");
							jQuery("form#submit_form #user_fname_already_exist").val(1);
							jQuery("form#submit_form #user_fname_error").removeClass('message_error2');
							jQuery("form#submit_form #user_fname_error").addClass('available_tick');
							jQuery("form#submit_form #user_fname").removeClass("error");
							jQuery("form#submit_form #user_fname_error").removeClass("message_error2");
							return true;
						}
						else{
							jQuery("form#submit_form #user_fname_error").html("<?php _e('The username you entered already exists, please try a different one','templatic');?>");
							jQuery("form#submit_form #user_fname_already_exist").val(0);
							jQuery("form#submit_form #user_fname_error").addClass('message_error2');
							jQuery("form#submit_form #user_fname_error").removeClass('available_tick');
							return false;
						}
					}
				}
			});
		});
	</script>
	<?php
}


/*Convert special character as normal character */
function Unaccent($string)
{
    if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false)
    {
        $string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
    }
    return $string;
}

/*
	function is return the html for social login button on registration and login page
*/

add_action('show_meida_login_button','show_meida_login_button');
function show_meida_login_button($page_id='')
{
	$redirect_id=($page_id!='')? '&redirect_id='.$page_id : '';
	$tmpdata = get_option('templatic_settings');
	
	if((isset($tmpdata['allow_facebook_login']) && $tmpdata['allow_facebook_login']==1) || (isset($tmpdata['allow_google_login']) && $tmpdata['allow_google_login']==1) || isset($tmpdata['allow_twitter_login']) && $tmpdata['allow_twitter_login']==1){
	?>
    <ul class="social_login social_media_login">
		<li><?php _e('Sign in with','templatic'); ?></li>
		 <?php
         if(isset($tmpdata['allow_facebook_login']) && $tmpdata['allow_facebook_login']==1){?>
            <li><a rel="nofollow" class="facebook" href="?route=authentications/authenticatewith/facebook<?php echo $redirect_id;?>"><?php _e('Facebook','templatic'); ?></a></li>
        <?php }
        if(isset($tmpdata['allow_google_login']) && $tmpdata['allow_google_login']==1){ ?>
            <li><a rel="nofollow" class="google" href="?route=authentications/authenticatewith/google<?php echo $redirect_id;?>"><?php _e('Google','templatic'); ?></a></li>
        <?php }
        if(isset($tmpdata['allow_twitter_login']) && $tmpdata['allow_twitter_login']==1){ ?>
            <li><a rel="nofollow" class="twitter" href="?route=authentications/authenticatewith/twitter<?php echo $redirect_id;?>"><?php _e('Twitter','templatic'); ?></a></li>
        <?php } ?>
    </ul>
    <?php
	}
}

/* For got password */
add_shortcode('frm_forgot_password','tmpl_frm_forgot_password');
function tmpl_frm_forgot_password($atts){ ?>
	<?php

	extract($atts); /* extract the parameters in array from shortcode */
	
	if ( @$_REQUEST['emsg']=='fw' && @$_REQUEST['action'] != 'register'){
		echo "<p class=\"error_msg\"> ".INVALID_USER_FPW_MSG." </p>";
		$display_style = 'style="display:block;"';
	} else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'register'){
		$display_style = 'style="display:none;"';
	}
	else{
		$display_style = 'style="display:none;"';
	}

	?>

	<div  class='forgotpassword' id="lostpassword_form" <?php if($display_style != '') { echo $display_style; } else { echo 'style="display:none;"';} ?> >
	<h3><?php  _e('Forgot password','templatic');?></h3>
	<form name="<?php echo $submit_form; ?>" id="<?php echo $submit_form; ?>" action="<?php echo get_permalink(); ?>" method="post" >
			<input type="hidden" name="action" value="lostpassword" />
		<div class="form_row clearfix">
		<label> <?php  _e('Email','templatic'); ?>: </label>
		<input type="text" name="user_login" id="user_login_email"  value="<?php if(isset($user_login))echo esc_attr($user_login); ?>" size="20" class="textfield" />
			 <span id="forget_user_email_error" class="message_error2"></span>
		<?php do_action('lostpassword_form'); ?>
		</div>
		<input type="hidden" name="pwdredirect_to" value="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; ?>" />
		<input type="submit" name="get_new_password" onclick="return forget_email_validate('<?php echo $submit_form; ?>');" value="<?php _e('Get New Password','templatic');?>" class="b_signin_n " />
	</form>
	</div>
<?php
}
/*
*function to show message after successful registration
*/
add_action('wp_head','show_user_register_message');
function show_user_register_message()
{
	global $post;
	$login_page_id=get_option('tevolution_login');
	$register_page_id=get_option('tevolution_register');
	if(isset($_SESSION['successfull_register']) && $_SESSION['successfull_register']!='')
	{
	?>
    <script type="text/javascript" async>
		jQuery( document ).ready(function(){
			jQuery('#header').append('<p class=\"success_msg\"></p>')
			jQuery('.success_msg').html("<?php echo __('Thank you for registration! Please check your mail to get your login information.','templatic');?>");
			jQuery('.success_msg').css('display','inline-block');
			jQuery('.success_msg').delay(5000).fadeOut('slow');
		});
	</script>
    <?php
		unset($_SESSION['successfull_register']);
	}
}

/* this function contain the right side of author box */
function tmpl_authorbox_right_content($curauth,$form_fields_usermeta){
	global $wpdb;
	?>
	<div class="user_dsb_cf">
	<?php 
		if(get_user_meta($curauth->ID,'Country',true) && $form_fields_usermeta['Country']['on_author_page'] == 1){  ?>
		<p><label><?php _e('Country','templatic'); ?>: </label><span><?php echo get_user_meta($curauth->ID,'Country',true); ?></span></p>
	<?php } 
		/* get custom fields */
		if(is_array($form_fields_usermeta) && !empty($form_fields_usermeta)){
			foreach($form_fields_usermeta as $key=> $_form_fields_usermeta)
			{
				/* Localize string with WPML */
				if(function_exists('icl_register_string')){
					icl_register_string('templatic',$_form_fields_usermeta['label'],$_form_fields_usermeta['label']);
					$_form_fields_usermeta['label'] = icl_t('templatic',$_form_fields_usermeta['label'],$_form_fields_usermeta['label']);
				}
				if($_form_fields_usermeta['type']=='head' && $_form_fields_usermeta['on_author_page']==1){
					echo '<h2>'. $_form_fields_usermeta['label'].'</h2>';
				}

				if(get_user_meta($curauth->ID,$key,true) != "" && $key !='facebook' && $key !='display_name' && $key !='user_google' && $key !='twitter' && $key !='twitter' && $key!= 'linkedin'  && $key!= 'profile_photo' && $key!= 'Country'): 
				if($_form_fields_usermeta['on_author_page']): 
					if($curauth->ID != $current_user->ID && $key == 'user_fname')
					{
						continue;
					}
				/* If field type is radio.select or multi check box*/

				if($_form_fields_usermeta['type']=='multicheckbox' || $_form_fields_usermeta['type']=='radio' || $_form_fields_usermeta['type']=='select'){ ?>
					<?php
						$checkbox = '';
						$option_values=explode(",",$_form_fields_usermeta['options']);
						$option_titles=explode(",",$_form_fields_usermeta['option_titles']);
						for($i=0;$i<count($option_titles);$i++){
							if(in_array($option_values[$i],get_user_meta($curauth->ID,$key,true)) || get_user_meta($curauth->ID,$key,true) == $option_values[$i]){
								if($option_titles[$i]!=""){
									$checkbox .= $option_titles[$i].',';
								}else{
									$checkbox .= $option_values[$i].',';
								}
							}
						}								
						?>
						<p><label><?php echo $_form_fields_usermeta['label']; ?>:</label><span><?php echo substr($checkbox,0,-1); ?></span></p>
						<?php 
						}elseif($_form_fields_usermeta['type']=='upload'){ ?>
							<p><label  style="vertical-align:top;"><?php echo $_form_fields_usermeta['label'].": "; ?></label> <img src="<?php echo get_user_meta($curauth->ID,$key,true);?>" /></p>
						<?php 
						}else{
						?>
						<div>
						<label><?php echo $_form_fields_usermeta['label']; ?>:</label>
						<span><?php 
								if( $key == 'url' ){
								
									$userwebsite = get_user_meta($curauth->ID,$key,true);
									if (!strstr($userwebsite, 'http'))
											$userwebsite = 'http://' . $userwebsite;
									
									echo '<a target="_blank" href="'.$userwebsite.'" title="'.$userwebsite.'">'.get_user_meta($curauth->ID,$key,true).'</a>';
								}else{
									echo (get_user_meta($curauth->ID,$key,true)); 
								}
							?>
						</span>
						</div>
					<?php }
				endif;
				/* finish the on author page condition	*/
				endif;
				/* finish key is not blank */
			} /* End for each */
		}
	  
		/* get the total post counting */
		if($curauth->ID): 
			$posttaxonomy = get_option("templatic_custom_post");
			$posttaxonomy = implode(',',array_keys($posttaxonomy));
			$posttaxonomy = str_replace(",","','",$posttaxonomy);

			global $wpdb, $pagenow, $wp_taxonomies,$ljoin;
			$language_where='';
			if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')){
				$a = array_keys(get_option("templatic_custom_post"));
				for($i=0;$i<count($a);$i++)
				{
					$posttaxonomy1 .= 'post_'.$a[$i].",";
				}
				$posttaxonomy1 = str_replace(",","','",$posttaxonomy1);
				$language = ICL_LANGUAGE_CODE;
				$join .= " {$ljoin} JOIN {$wpdb->prefix}icl_translations t ON {$wpdb->posts}.ID = t.element_id			
					AND t.element_type IN ('$posttaxonomy1') JOIN {$wpdb->prefix}icl_languages l ON t.language_code=l.code AND l.active=1 AND t.language_code='".$language."'";
			}
			
			@$post_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts  $join WHERE post_author = '" . $curauth->ID . "' AND post_type IN('$posttaxonomy') AND post_status = 'publish'");?>
			<p>
			<label><?php echo _e('Total Submissions','templatic');?>: </label><span class="i_agent_others"> <b><?php echo $post_count;?></b></span>
			</p>
			<?php
		endif;
	 
		/* payment type details */
		$posttaxonomy = get_option("templatic_custom_post");

		$price_pkg = get_user_meta($curauth->ID,'package_selected',true);
		$pagd_data = get_post($price_pkg);
		$package_name = $pagd_data->post_title;
		$types = get_post_types();

		$ptypes = implode(',',$types);
		$ptypes = explode(',',$ptypes);
		$pkg_post_type = get_post_meta($price_pkg,'package_post_type',true);
		$pkg_post_types = explode(',',$pkg_post_type);
		$pkg_post_type1='';
			for($c=0; $c < count($pkg_post_types); $c++){
				if(in_array($pkg_post_types[$c],$ptypes)){
					$pkg_post_type1 .=ucfirst($pkg_post_types[$c]).",";
				}
			}
		$pkg_type = get_post_meta($price_pkg,'package_type',true);
		$limit_no_post = get_post_meta($price_pkg,'limit_no_post',true);
		
		$submited =get_user_meta($curauth->ID,'total_list_of_post',true);
		if(!$submited)
			$submited =0;
		$remaining = intval($limit_no_post) - intval($submited);
		if($pkg_type == 2 && $current_user->ID != '' && $curauth->ID == $current_user->ID){
			echo "<div class='pkg_info'>";
			
				_e('You have subscribed to','templatic');
				echo " <b>".$package_name."</b> ";
				_e('price package for','templatic');
				echo "<b> ".rtrim($pkg_post_type1,',')." </b>"; 
				_e('Total number of posts:','templatic');
				echo "<b> ".$limit_no_post."</b>, "; 
				_e('Submited:','templatic');
				echo '<b> '.$submited.', </b>';
				_e('Remaining:','templatic');
				echo '<b> '.$remaining.' </b>';
			
			echo ".</div>";
		
		}

	 ?>
	</div>
<?php	} ?>