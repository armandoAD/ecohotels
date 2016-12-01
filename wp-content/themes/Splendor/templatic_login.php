<?php
/* login form for user's while taking updates */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php esc_html_e( 'Listings Updates' ); ?></title>
		<?php
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_style( 'jquery-tools', get_template_directory_uri( '/css/tabs.css', __FILE__ ) );
			wp_admin_css( 'global' );
			wp_admin_css( 'admin' );
			wp_admin_css();
			wp_admin_css( 'colors' );
			do_action('admin_print_styles');
			do_action('admin_print_scripts');
			do_action('admin_head');
			?>
	</head>
     <?php
	 session_start();
	 error_reporting(0);
	/*
	 * Get Theme Version
	 */
	function tmpl_get_theme_version () {		
		$theme_name = basename(get_stylesheet_directory());
		$theme_data = templatic_get_theme_data(get_stylesheet_directory().'/style.css');			
		return $theme_version = $theme_data['Version'];	
	}

	/* GET REMOTE VERSION */

	function tmpl_get_remote_verison(){		
		global $theme_response,$wp_version;			
		$theme_name = basename(get_stylesheet_directory());
		$remote_version = get_option($theme_name."_theme_version");
		return $remote_version = $remote_version[$theme_name]['new_version'];	
	}

	global $current_user;
	global $current_user;
	$theme_name = basename(get_stylesheet_directory());
	$self_url =  esc_url( add_query_arg( array( 'slug' => $theme_name, 'action' => $theme_name , '_ajax_nonce' => wp_create_nonce( $theme_name ), 'TB_iframe' => true ), admin_url( 'admin-ajax.php' ) ));
	
	/* validate login details and update theme */
	if(isset($_POST['templatic_login']) && isset($_POST['templatic_username']) && $_POST['templatic_username']!=''  && isset($_POST['templatic_password']) && $_POST['templatic_password']!='')
	{ 
		$arg=array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'body' => array( 'username' => $_POST['templatic_username'], 'password' => $_POST['templatic_password']),
			'cookies' => array()
		    );
		$warnning_message='';
		$response = wp_remote_post('http://templatic.com/members/login_api.php',$arg );	
		
		/* if anything goes wrong then show error messages */
		if( is_wp_error( $response ) ) {
		  	$warnning_message=__("Invalid UserName or password. Please enter templatic member's username and password.",'templatic-admin'); 
		} else { 
		  	$data = json_decode($response['body']);
		}
	
		/*Return error message */
		if(isset($data->error_message) && $data->error_message!='')
		{
			$warnning_message=$data->error_message;			
		}

		/*Finish error message */
		$data_product = (array)$data->product;
		if(isset($data_product) && is_array($data_product))
		{		
			foreach($data_product as $key=>$val)
			{
				$product[]=$key;
			}			
			if(in_array('Listings - developer license',$product) || in_array('Listings - standard license',$product))
			{
				$successfull_login=1;				
				$_SESSION['success_user_login'] = 'yes';
				$download_link=$data_product['Listings - developer license'];
			}else
			{
				$warnning_message=__("Update was unable to continue because",'templatic-admin')." ".$th_name." ".__("theme doesn't seem to be associated with your Templatic account.",'templatic-admin')." ".__("Please",'templatic-admin')." <a href='http://templatic.com/contact/' target='_blank'>".__("contact us",'templatic-admin')."</a> ".__("if this message is showing in error.",'templatic-admin');
			}			
		}
	}else{
		if(isset($_POST['templatic_login']) && ($_POST['templatic_username'] =='' || $_POST['templatic_password']=='')){
			$warnning_message=__("Invalid UserName or password. Please enter templatic member's username and password.",'templatic-admin'); 
		}
	}
			$theme_version = tmpl_get_theme_version();
			$remote_version = tmpl_get_remote_verison();
			/* set flag on updates */
			if (version_compare($theme_version, $remote_version, '<') && $theme_version!='')
			{	
				$flag =1;
			}else{
				$flag=0;
			}
			$the_name = wp_get_theme();
			$session = $_SESSION['success_user_login'];

	?>
          <div class='wrap templatic_login'>
           <?php 
		   /* check if updates are available or not. */
		   if($flag ==1){ ?>
			  <div id="update-nag">
			  <p style=" clear:both;"> <?php echo __('The new version of ','templatic-admin').$the_name.' '.__('is available.','templatic-admin'); ?></p>
			  
			  <p><?php echo __('You can update to the latest version automatically , or download the latest version of the theme.','templatic-admin'); ?></p>
			  <p><span style="color:red; font-weight:bold;"><?php echo __('Warning','templatic-admin'); ?>: </span><?php echo __('Updating will undo all your file customizations so make sure to keep backup of all files before updating.','templatic-admin'); ?></p>
			  <a class="button-secondary" href="http://templatic.com/members/mydownloads/Splendor/theme/Splendor.zip" target="blank"><?php echo __('Download latest Version','templatic-admin'); ?></a> 
			  
			  </div>
		  <?php } ?>
           <div id='pblogo'>
               <img src="<?php echo esc_url( get_template_directory_uri()."/images/templatic-wordpress-themes.jpg"); ?>" style="margin-right: 50px;" /><?php echo '<h3>'. @$theme_name.' Updates</h3>'; ?>
		   </div> 

           <?php
		if(isset($warnning_message) && $warnning_message!='')
		{?>
			<div class='error'><p><strong><?php echo sprintf(__('%s','templatic-admin'), $warnning_message);?></strong></p></div>	
		<?php
          }
		?>
            <?php if($flag ==1){
             if(!isset($successfull_login) && $successfull_login!=1 && !$session):?>
			   
               <p class="info">
			   
			   <?php 
			   /* show login form */
			   echo __('Enter your templatic login credentials to update your Listings theme to the latest version.','templatic-admin');?></p>
               <form action="<?php echo site_url()."/wp-admin/admin.php?page=child_tmpl_theme_update";?>" name="" method="post">
                   <table>
					<tr>
					<td><label><?php echo __('User Name', 'templatic-admin')?></label></td>
					<td><input type="text" name="templatic_username"  /></td>
					</tr>
					<tr>
                    <td><label><?php echo __('Password', 'templatic-admin')?></label></td>
					<td><input type="password" name="templatic_password"  /></td>
					</tr>
					<tr>
					<td><input type="submit" name="templatic_login" value="Sign In" class="button-secondary"/></td>
					<td><a title="Close" id="TB_closeWindowButton" href="#" class="button-secondary"><?php echo __('Cancel','templatic-admin'); ?></a></td>
					</tr>
				</table>
				
               </form>
          <?php else:
		  		/* show update now button */								
				 $file=$theme_name;
				 $download= wp_nonce_url(admin_url('update.php?action=upgrade-theme&theme=').$file, 'upgrade-theme_' . $file);				
				 echo ' Splendor - Directory Child theme <a id="TB_closeWindowButton" href="'.$download.'" target="_parent" class="button-secondary">'.__('Update Now','templatic-admin').'</a>';
			 endif;
			}?>
          </div>
<?php
	if($flag == 0){
		echo '<h3>'.__('You have the latest version of ','templatic-admin').$theme_name.' '.__('theme.','templatic-admin').'</h3>';
        echo '<p>&rarr;'.sprintf(__('<strong>Your version:</strong> %s','templatic-admin'),$theme_version).'</p>';	
	}

do_action('admin_footer', '');
do_action('admin_print_footer_scripts');
?>
</html>