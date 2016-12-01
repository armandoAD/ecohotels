<?php
/**
 * Shortcodes init
 */
/*Submit form page shortcode*/
include_once('shortcode_submit_form_page.php');
/* People listing shortcode */
include_once('shortcode_people.php');
/* People listing shortcode */
include_once('shortcode_post_upgrade.php');
	
include_once('shortcode_taxonomies_map.php');

function tevolution_map_page($atts)
{
	
	extract( shortcode_atts( array (
				'post_type'   =>'post',
				'image'       => 'thumbnail',
				'latitude'    => '21.167086220869788',
				'longitude'   => '72.82231945000001',
				'map_type'    => 'ROADMAP',
				'map_display' => '1',
				'zoom_level'  => '13',
				'height'      => '450'
				), $atts ) 
			);
	ob_start();
	remove_filter( 'the_content', 'wpautop' , 12);
	/*fetch the category by post type*/
		$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));	
	$cat_args = array(
				'taxonomy'=>$taxonomies[0],
				'orderby' => 'name', 				
				'hierarchical' => 'true',
				'title_li'=>''
			);	
	$r = wp_parse_args( $cat_args);	
	$catname_arr=get_categories( $r );
	
	$catinfo_arr = get_categories_postinfo($catname_arr,$post_type,$image);
	display_google_map($catinfo_arr,$atts,$catname_arr);
	
	return ob_get_clean();
}
/*
 * Function Name: display_google_map
 * Return: display the google map
 */
function display_google_map($catinfo_arr,$atts,$catname_arr)
{
	
	extract( shortcode_atts( array (
  		'post_type'   =>'post',
		'image'       => 'thumbnail',
		'latitude'    => '21.167086220869788',
		'longitude'   => '72.82231945000001',
		'map_type'    => 'ROADMAP',
		'map_display' => '1',
		'zoom_level'  => '13',
		'height'      => '450'
		), $atts ) );	
	
	
	wp_print_scripts( 'google-maps-apiscript');
	wp_print_scripts( 'google-clusterig');
	
	$google_map_customizer=get_option('google_map_customizer');/* store google map customizer required formate.*/
	?>
     <script type="text/javascript">
		var CITY_MAP_CENTER_LAT= '<?php echo $latitude?>';
		var CITY_MAP_CENTER_LNG= '<?php echo $longitude?>';
		var CITY_MAP_ZOOMING_FACT= <?php echo $zoom_level;?>;
		var infowindow;
		<?php if($map_display == 1) { ?>
		var multimarkerdata = new Array();
		<?php }?>
		var zoom_option = '<?php echo $map_display; ?>';
		var markers = {<?php echo $catinfo_arr;?>};
		
		/*var markers = '';*/
		var map = null;
		var mgr = null;
		var mc = null;
		var markerClusterer = null;
		var showMarketManager = false;
		var PIN_POINT_ICON_HEIGHT = 50;
		var PIN_POINT_ICON_WIDTH = 50;
		var infobox;
		if(MAP_DISABLE_SCROLL_WHEEL_FLAG)
		{
			var MAP_DISABLE_SCROLL_WHEEL_FLAG = 'No';	
		}
		
		function setCategoryVisiblity( category, visible ) {		
		   var i;
		   if ( mgr && category in markers ) {
			  for( i = 0; i < markers[category].length; i += 1 ) {
				 if ( visible ) {
					mgr.addMarker( markers[category][i], 0 );
				 } else {
					mgr.removeMarker( markers[category][i], 0 );
				 }
			  }
			  mgr.refresh();
		   }
		}
		function initialize() {
		  var isDraggable = jQuery(document).width() > 480 ? true : false;
		  var myOptions = {
			zoom: CITY_MAP_ZOOMING_FACT,
			draggable: isDraggable,
			center: new google.maps.LatLng(CITY_MAP_CENTER_LAT, CITY_MAP_CENTER_LNG),
			mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>
		  }
		   map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
		   mgr = new MarkerManager( map );
		   var styles = [<?php echo substr($google_map_customizer,0,-1);?>];			
		   map.setOptions({styles: styles});
		   google.maps.event.addListener(mgr, 'loaded', function() {
		  
			  if (markers) {				  
				 for (var level in markers) {					 	
					google.maps.event.addDomListener( document.getElementById( level ), 'click', function() {
					   setCategoryVisiblity( this.id, this.checked );
					});	
					
					for (var i = 0; i < markers[level].length; i++) {						
					   var details = markers[level][i];					  
					   var image = new google.maps.MarkerImage(details.icons,new google.maps.Size(PIN_POINT_ICON_WIDTH, PIN_POINT_ICON_HEIGHT));
					   var myLatLng = new google.maps.LatLng(details.location[0], details.location[1]);
					   <?php if($map_display == 1) { ?>
						 multimarkerdata[i]  = new google.maps.LatLng(details.location[0], details.location[1]);
					   <?php } ?>
					   markers[level][i] = new google.maps.Marker({
						  title: details.name,
						  position: myLatLng,
						  icon: image,
						  clickable: true,
						  draggable: false,
						  flat: true
					   });					   
					   
					attachMessage(markers[level][i], details.message);
					}
					mgr.addMarkers( markers[level], 0 );
					
					/*New infobundle			*/
					 infoBubble = new InfoBubble({
						maxWidth:210,minWidth:210,minHeight:"auto",padding:0,content:details.message,borderRadius:0,borderWidth:0,borderColor:"none",overflow:"visible",backgroundColor:"#fff"
					  });			
					/*finish new infobundle*/
			
			/*Start			*/
                google.maps.event.addListener(markers, "click", function (e) {														    
					infoBubble.open(map, details.message);					
                });
			
					
				 }
				  <?php if($map_display == 1) { ?>
					 var latlngbounds = new google.maps.LatLngBounds();
					for ( var j = 0; j < multimarkerdata.length; j++ )
						{
						 latlngbounds.extend( multimarkerdata[ j ] );
						}
					   map.fitBounds( latlngbounds );
				  <?php } ?>
				 mgr.refresh();
			  }
		   });
		   
			/* but that message is not within the marker's instance data */
			function attachMessage(marker, msg) {
			  	var myEventListener = google.maps.event.addListener(marker, 'click', function() {
					infoBubble.setContent( msg );
					infoBubble.open(map, marker);															
				});
			}
			
		}
		
		google.maps.event.addDomListener(window, 'load', initialize);
		
		
	</script>
	<div class="map_sidebar">
     <div class="top_banner_section_in clearfix "> 
		 <div class="TopLeft"><span id="triggermap"></span></div>
		   <div class="TopRight"></div>
		   <div class="iprelative">
          <div id="map_canvas" style="width: 100%; height:<?php echo $height;?>px" class="map_canvas"></div>  
		 </div>
          <?php if($catname_arr):?>
               <div class="map_category" id="toggleID">
				<?php foreach($catname_arr as $catname):
				
				if($catname->term_icon != '')
						$term_icon=$catname->term_icon;
					else	
						$term_icon=apply_filters('tmpl_default_map_icon',TEMPL_PLUGIN_URL."images/pin.png");
				
				 ?>
                         <label>
                         <input type="checkbox" value="<?php echo $catname->name;?>" checked="checked" id="<?php echo $catname->slug;?>" name="<?php echo $catname->slug;?>">
                         <img height="14" width="8" alt="" src="<?php echo $term_icon;?>"> <?php echo esc_attr(urldecode($catname->name));?>
                         </label> 
                    <?php endforeach;?>
               </div>
               <div id="toggle_category" class="toggleon" onclick="toggle_category();"></div>
          <?php endif;?>	          
     </div>
     </div>
     <script type="text/javascript">
	 
	 var maxMap = document.getElementById( 'triggermap' );		
		google.maps.event.addDomListener(maxMap, 'click', showFullscreen);
		function showFullscreen() {
			  /* window.alert('DIV clicked');*/
				jQuery('#map_canvas').toggleClass('map-fullscreen');
				jQuery('.map_category').toggleClass('map_category_fullscreen');
				jQuery('.map_post_type').toggleClass('map_category_fullscreen');
				jQuery('#toggle_post_type').toggleClass('map_category_fullscreen');
				jQuery('#trigger').toggleClass('map_category_fullscreen');
				jQuery('body').toggleClass('body_fullscreen');
				jQuery('#loading_div').toggleClass('loading_div_fullscreen');
				jQuery('#advmap_nofound').toggleClass('nofound_fullscreen');
				jQuery('#triggermap').toggleClass('triggermap_fullscreen');
				
				jQuery('.TopLeft').toggleClass('TopLeft_fullscreen');		
					 /*map.setCenter(darwin);*/
					 window.setTimeout(function() { 
					var center = map.getCenter(); 
					google.maps.event.trigger(map, 'resize'); 
					map.setCenter(center); 
			   		}, 100);			 }
	function toggle_category(){
			var div1 = document.getElementById('toggleID');
			if (div1.style.display == 'none') {
				div1.style.display = 'block';
			} else {
				div1.style.display = 'none';
			}
			
			if(document.getElementById('toggle_category').getAttribute('class') == 'paf_row toggleoff'){		
				jQuery("#toggle_category").removeClass("paf_row toggleoff").addClass("paf_row toggleon");
			} else {		
				jQuery("#toggle_category").removeClass("paf_row toggleon").addClass("paf_row toggleoff");
			}
			
			if(document.getElementById('toggle_category').getAttribute('class').search('toggleoff')!=-1 && document.getElementById('toggle_category').getAttribute('class').search('map_category_fullscreen') !=-1){		
				jQuery("#toggle_category").removeClass("paf_row toggleoff map_category_fullscreen").addClass("paf_row toggleon map_category_fullscreen");
			} 
			if(document.getElementById('toggle_category').getAttribute('class').search('toggleon') !=-1 && document.getElementById('toggle_category').getAttribute('class').search('map_category_fullscreen') !=-1){
				jQuery("#toggle_category").removeClass("paf_row toggleon map_category_fullscreen").addClass("paf_row toggleoff map_category_fullscreen");
			}
		}
	</script>
     
     <?php
}
/*
 * Function name: get_categories_post_info
 * Return: post info array for display on google map
 */
function get_categories_postinfo($catname_arr,$post_type,$map_image_size='thumbnail')
{
global $sitepress;
	remove_all_actions('posts_where');
	foreach($catname_arr as $cat)
	{	
		$catname=$cat->slug;
		$cat_ID=$cat->term_id;		
		$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));					
		
		$args=apply_filters('map_shortcode',array( 
				   'post_type'      => trim($post_type),
				   'posts_per_page' => -1    ,
				   'post_status'    => 'publish',             
				   'tax_query'      => array(                
									  array(
										 'taxonomy' =>$taxonomies[0],
										 'field'    => 'id',
										 'terms'    => $cat_ID,
										 'operator' => 'IN'
									  )            
				    				   ),        
				   'order_by'       =>'date',
				   'order'          => 'ASC'
			   ),$taxonomies[0],$cat_ID);
		
		if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')){
			remove_action( 'parse_query', array( $sitepress, 'parse_query' ) );
			add_filter('posts_where', array($sitepress,'posts_where_filter'),10,2);	
		}
						   
		$post_details= new WP_Query($args);
		
		if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')){
			remove_filter('posts_where', array($sitepress,'posts_where_filter'),10,2);	
		}
		
		$content_data='';
		global $post;
		if ($post_details->have_posts()) :
			$srcharr = array("'");
			$replarr = array("\'");
			while ( $post_details->have_posts() ) : $post_details->the_post();									
					$ID =get_the_ID();	
					if($post->post_parent){
						$ID =$post->post_parent;	
					}
					$title = sanitize_text_field(get_the_title($ID));
					$plink = get_permalink($ID);
					$lat = get_post_meta($ID,'geo_latitude',true);
					$lng = get_post_meta($ID,'geo_longitude',true);					
					$address = sanitize_text_field(str_replace($srcharr,$replarr,(get_post_meta($ID,'address',true))));
					/*$contact = str_replace($srcharr,$replarr,(get_post_meta($ID,'contact',true)));*/
					/*$timing = str_replace($srcharr,$replarr,(get_post_meta($ID,'timing',true)));		*/
					/*Fetch the image for display in map */
					if ( has_post_thumbnail()){
						$post_img = wp_get_attachment_image_src( get_post_thumbnail_id(), $map_image_size);						
						$post_images = @$post_img[0];
					}else{
						$post_img = bdw_get_images_plugin($ID,$map_image_size);					
						$post_images = @$post_img[0]['file'];
					}
					
					$imageclass='';
					if($post_images)
						$post_image='<div class=map-item-img><a href="'.$plink.'"><img src="'.$post_images.'"  width=120 height=160/></a></div>';
					else{
						$post_image='';
						$imageclass='no_map_image';
					}
					
					$image_class=($post_image)?'map-image' :'';
					if($cat->term_icon != '')
						$term_icon=$cat->term_icon;
					else	
						$term_icon=apply_filters('tmpl_default_map_icon',TEMPL_PLUGIN_URL."images/pin.png");
						
					$name_title=html_entity_decode($title);
					if(!isset($more)){ $more='...'; } 
					if($lat && $lng)
					{ 
						$retstr ="{";
						$retstr .= "'name':'$name_title',";
						$retstr .= "'location': [$lat,$lng],";						
						$retstr .= "'message':'<div class=\"google-map-info $image_class forrent\"><div class=map-inner-wrapper><div class=\"map-item-info ".$imageclass."\">$post_image";
						$retstr .= "<h6><a href=\"$plink\" class=\"ptitle\" style=\"color:#444444;font-size:14px;\"><span>$title</span></a></h6>";
						if($address){$retstr .= "<span style=\"font-size:10px;\">$address</span>";}
						$retstr .= "<p class=\"link-style1\"><a href=\"$plink\" class=\"$title\">$more</a></div></div></div>";
						$retstr .= "',";
						$retstr .= "'icons':'$term_icon',";
						$retstr .= "'pid':'$ID'";
						$retstr .= "}";						
						$content_data[] = $retstr;
					}				
			endwhile;	
			wp_reset_query();
		endif;
		if($content_data)	
			$cat_content_info[]= "'$catname':[".implode(',',$content_data)."]";			
	}	
	if($cat_content_info!="")	
		return implode(',',$cat_content_info);
	else
		return '';		
}
/* display email protect from spam boat*/
function tev_email_encode( $atts, $email ){
	$atts = extract( shortcode_atts( array('email'=>$email),$atts ));
	
	if(function_exists('antispambot')){
		return '<a href="'.antispambot("mailto:".$email).'">'.antispambot($email).'</a>';
		}
}
add_shortcode( 'email', 'tev_email_encode' ); /* protect from spambot*/

/* Shortcode for listing success page */
function tev_listing_success_page()
{
	
	$order_id = $_REQUEST['pid'];
	global $page_title,$wpdb;
	
	/* add background color and image set in customizer */
	add_action('wp_head','show_background_color');
	if(!function_exists('show_background_color'))
	{
		function show_background_color()
		{
		/* Get the background image. */
			$image = get_background_image();
			/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
			if ( !empty( $image ) ) {
				_custom_background_cb();
				return;
			}
			/* Get the background color. */
			$color = get_background_color();
			/* If no background color, return. */
			if ( empty( $color ) )
				return;
			/* Use 'background' instead of 'background-color'. */
			$style = "background: #{$color};";
		?>
			<style type="text/css">
				body.custom-background {
					<?php echo trim( $style );?>
				}
			</style>
		<?php
		}
	}
	global $wpdb;
	if($_REQUEST['pid']){
		$post_type = get_post_type($_REQUEST['pid']);
		$post_type_object = get_post_type_object($post_type);
		$post_type_label = ( @$post_type_object->labels->post_name ) ? @$post_type_object->labels->post_name  :  $post_type_object->labels->singular_name ;
	}
	if(isset($_REQUEST['renew']) && $_REQUEST['renew']!="")
	{
		$page_title = __('Renew Successfully Information','templatic');
	}elseif($_REQUEST['action']=='edit'){
		
		$page_title = $post_type_label.' '.__('Updated Successfully','templatic');
		if(function_exists('icl_register_string')){
			$context = get_option('blogname');
			icl_register_string($context,$post_type_label." Updated",$post_type_label." Updated");
			$page_tile = icl_t($context,$post_type_label." Updated",$post_type_label." Updated");
		}
	}elseif(isset($_REQUEST['upgrade']) && $_REQUEST['upgrade']!=""){
			if(function_exists('icl_register_string')){
				icl_register_string('templatic',$post_type_label."success",$post_type_label);
				$post_type_label = icl_t('templatic',$post_type_label."success",$post_type_label);
			}
			$page_title = $post_type_label.' '.__('Upgraded Successfully','templatic');
	
	}else{
		if(function_exists('icl_register_string')){
			icl_register_string('templatic',$post_type_label."success",$post_type_label);
			 $post_type_label = icl_t('templatic',$post_type_label."success",$post_type_label);
			}
		if($_REQUEST['pid'] && !isset($_REQUEST['action_edit']))
			$page_title = $post_type_label.' '.__('Submitted Successfully','templatic');
		elseif(isset($_REQUEST['action_edit']))
			$page_title = $post_type_label.' '.__('Updated Successfully','templatic');
		else
			$page_title = $post_type_label.' '.__('Thank you for purchasing a subscription plan','templatic');
	}
	//get_header(); 
	//do_action('templ_before_success_container_breadcrumb');
	
	/* Success Form Security Code */
	global $wpdb,$current_user;
	
	$post_sql = $wpdb->get_row($wpdb->prepare("select post_author,ID from $wpdb->posts where post_author = '".$current_user->ID."' and ID = %d",$_REQUEST['pid']));
	if((count($post_sql) <= 0) && (isset($_REQUEST['pid']) && $_REQUEST['pid']!='') && !$current_user)
	{ 
		?><div class="large-9 small-12 columns "><?php _e('ERROR: Sorry, you are not allowed to view this post.','templatic');?></div><?php
	}
	else{
	if(isset($_REQUEST['paydeltype']) && $_REQUEST['paydeltype']=='prebanktransfer' && @$_REQUEST['upgrade'] =='')
	{
		/*MAIL SENDING TO CLIENT AND ADMIN START*/
		global $payable_amount,$last_postid,$stripe_options,$wpdb,$monetization,$sql_post_id;
		$transaction_tabel = $wpdb->prefix."transactions";
		$user_id = $wpdb->get_var("select user_id from $transaction_tabel order by trans_id DESC limit 1");
		$user_id = $user_id;
		$sql_transaction = "select max(trans_id) as trans_id from $transaction_tabel where user_id = $user_id and status=0 ";
		$sql_data = $wpdb->get_var($sql_transaction);
		$sql_status_update = $wpdb->query("update $transaction_tabel set status=0 where trans_id=$sql_data");
		$get_post_id = $wpdb->get_var("select post_id from $transaction_tabel where trans_id=$sql_data");
		$tmpdata = get_option('templatic_settings');
		/*$post_default_status = $tmpdata['post_default_status_paid'];*/
		$post_default_status = 'draft'; /* if payment method = prebank transfer no option affected - listing shold be ib draft*/
	
		$wpdb->query("UPDATE $wpdb->posts SET post_status='".$post_default_status."' where ID = '".$get_post_id."'");
		
		/*$trans_status = $wpdb->query("update $transaction_tabel SET status = 1 where post_id = '".$get_post_id."'");*/
		$pmethod = 'payment_method_'.$_REQUEST['paydeltype'];
		$payment_detail = get_option($pmethod,true);
		$bankname = $payment_detail['payOpts'][0]['value'];
		$account_id = $payment_detail['payOpts'][1]['value'];
		$sql_post_id = $wpdb->get_var("select post_id from $transaction_tabel where user_id = $user_id and trans_id=$sql_data");
		if($sql_post_id != '' && $sql_post_id > 0)
		{
			$suc_post = get_post($sql_post_id);
		}
		else
		{
			$sql_post_id = $wpdb->get_var("select package_id from $transaction_tabel where user_id = $user_id and trans_id=$sql_data");
			$suc_post = get_post($sql_post_id);
		}
		$payment_date = $wpdb->get_var("select payment_date from $transaction_tabel where user_id = $user_id and trans_id=$sql_data");
		$sql_payable_amt = $wpdb->get_var("select payable_amt from $transaction_tabel where user_id = $user_id and trans_id=$sql_data");
		$payforfeatured_h = $wpdb->get_var("select payforfeatured_h from $transaction_tabel where user_id = $user_id and trans_id=$sql_data");
		$payforfeatured_c = $wpdb->get_var("select payforfeatured_c from $transaction_tabel where user_id = $user_id and trans_id=$sql_data");
		$sql_payable_amt = display_amount_with_currency_plugin(number_format($sql_payable_amt,2));
		$post_title = $suc_post->post_title;
		$post_content = $suc_post->post_content;
		$paid_amount = display_amount_with_currency_plugin(get_post_meta($sql_post_id,'paid_amount',true));
		$user_details = get_userdata( $user_id );
		$first_name = $user_details->user_login;
		$last_name = $user_details->last_name;
		$fromEmail = get_site_emailId_plugin();
		$fromEmailName = get_site_emailName_plugin(); 	
		$toEmail = apply_filters('client_booking_success_email',$user_details->user_email,$_REQUEST['pid']);
		$toEmailName = apply_filters('client_booking_success_name',$first_name,$_REQUEST['pid']);
		$theme_settings = get_option('templatic_settings');
		$store_name = '<a href="'.home_url().'">'.get_option('blogname').'</a>';
		
		$submiited_id  = $sql_post_id;
		$submitted_link = '<a href="'.get_permalink($sql_post_id).'">'.$suc_post->post_title.'</a>';
		/*	Payment success Mail to client END		*/
		
		if(isset($_REQUEST['paydeltype']) && $_REQUEST['paydeltype'] == 'prebanktransfer'){
			$client_mail_subject =  apply_filters('prebanktransfer_client_subject',$theme_settings['pre_payment_success_email_subject_to_user']);
			$client_mail_content = stripslashes($theme_settings['pre_payment_success_email_content_to_user']);
		}else{
			$client_mail_subject =  apply_filters('prebanktransfer_client_subject',$theme_settings['payment_success_email_subject_to_client']);
			$client_mail_content = stripslashes($theme_settings['user_post_submited_success_email_content']);
		}
		
		if(@$client_mail_subject == '')
		{
			$client_mail_subject = __('Thank you for your submission!','templatic');
		}
		if(@$client_mail_content == '')
		{
			$client_mail_content = __("<p>Howdy [#to_name#],</p><p>You have submitted a new listing. Here are some details about it</p><p>[#information_details#]</p><p>Thank You,<br/>[#site_name#]</p>",'templatic');
		}
		$pay_method = "payment_method_".$_REQUEST['paydeltype'];
		$paymentupdsql = "select option_value from $wpdb->options where option_name=%s";
		$paymentupdinfo = $wpdb->get_results($wpdb->prepare($paymentupdsql,$pay_method));
		$paymentInfo = unserialize($paymentupdinfo[0]->option_value);
		$payment_method_name = $paymentInfo['name'];
		$payOpts = $paymentInfo['payOpts'];
		$bankInfo = $payOpts[0]['value'];
		$accountinfo = $payOpts[1]['value'];
		/*if($tmpdata['post_default_status_paid'] == 'publish')
		{
			$payment_status = __("Approved",'templatic');
		}
		else
		{
			$payment_status = __("Pending",'templatic');
		}*/
		$payment_status = __("Pending",'templatic'); /* Pre bank trasfer no option should be affected payment should be pending */
		$payment_type = $payment_detail['name'];
		$orderId = $sql_post_id?$sql_post_id:mt_rand(100000, 999999);
		$payment_date =  date_i18n(get_option('date_format'),strtotime($payment_date));
		$transaction_details="";
		$transaction_details .= "<br/>\r\n-------------------------------------------------- <br/>\r\n";
		$transaction_details .= __('Payment Details for','templatic').": $post_title <br/>\r\n";
		$transaction_details .= "-------------------------------------------------- <br/>\r\n";
		$transaction_details .= 	__('Status','templatic').": $payment_status <br/>\r\n";
		$transaction_details .=     __('Type','templatic').": $payment_type <br/>\r\n";
		$transaction_details .= 	__('Date','templatic').": $payment_date <br/>\r\n";
		$transaction_details .=     __('Total Price','templatic').": $sql_payable_amt <br/>\r\n";
		$transaction_details .= 	__('Bank Name','templatic').": $bankInfo <br/>\r\n";
		$transaction_details .= 	__('Account Number','templatic').": $accountinfo <br/>\r\n";
		$transaction_details .= 	__('Reference Number','templatic').": $sql_data <br/>\r\n";
		$transaction_details .= "-------------------------------------------------- <br/>\r\n";
		$transaction_details = $transaction_details;
		$client_transaction_mail_content = '<p>'.__('Thank you for your cooperation with us.','templatic').'</p>';
		/*$client_transaction_mail_content .= '<p>You successfully completed your payment by Pre Bank Transfer.</p>';*/
		$client_transaction_mail_content .= "<p>".__('Your submitted id is','templatic')." : ".$sql_post_id."</p>";
		$client_transaction_mail_content .= '<p>'.__('View more detail from','templatic').' <a href="'.get_permalink($sql_post_id).'">'.$suc_post->post_title.'</a></p>';

		$current_user_id = $current_user->ID;
		
		$uinfo = get_userdata($current_user_id);
		$user_fname = $uinfo->display_name;
		
		$store_login='';
		$store_login_link='';
		if(function_exists('get_tevolution_login_permalink')){
			$store_login = '<a href="'.get_tevolution_login_permalink().'">'.__('Click Login','templatic').'</a>';
			$store_login_link = get_tevolution_login_permalink();
		}
	
		$search_array = array('[#to_name#]','[#payable_amt#]','[#transaction_details#]','[#site_name#]','[#admin_email#]','[#user_login#]','[#site_login_url#]','[#site_login_url_link#]');
		$replace_array = array($user_fname,$sql_payable_amt,$transaction_details,$store_name,get_option('admin_email'),$toEmailName,$store_login,$store_login_link);
		

		$client_message = apply_filters('prebanktransfer_client_message',str_replace($search_array,$replace_array,$client_mail_content),$toEmailName,$fromEmailName);
		
		if(isset($_REQUEST['upgrade']) && $_REQUEST['upgrade']!=''){
		
		}else{
			templ_send_email($fromEmail,$fromEmailName,$toEmail,$toEmailName,$client_mail_subject,$client_message,$extra='');/*/To client email*/
		}
	
		$transaction_details="";
		$transaction_details .= "<br/>\r\n-------------------------------------------------- <br/>\r\n";
		$transaction_details .= __('Payment Details for','templatic').": $post_title <br/>\r\n";
		$transaction_details .= "-------------------------------------------------- <br/>\r\n";
		$transaction_details .= 	__('Status','templatic').": $payment_status <br/>\r\n";
		$transaction_details .=     __('Type','templatic').": $payment_type <br/>\r\n";
		$transaction_details .= 	__('Date','templatic').": $payment_date <br/>\r\n";
		$transaction_details .=    __('Total Price','templatic').":.$sql_payable_amt <br/>\r\n";	
		$transaction_details .= 	__('Bank Name','templatic').": $bankInfo <br/>\r\n";
		$transaction_details .= 	__('Account Number','templatic').": $accountinfo <br/>\r\n";
		$transaction_details .= 	__('Reference Number','templatic').": $sql_data <br/>\r\n";
		$transaction_details .= "-------------------------------------------------- <br/>\r\n";
		/* Check psot dedault status for paid listing is publish then listing and transction will be publish and approve */
		if($tmpdata['post_default_status_paid']=='publish'){
			
			if($payforfeatured_h == 1  && $payforfeatured_c == 1){
				update_post_meta($_REQUEST['pid'], 'featured_c', 'c');
				update_post_meta($_REQUEST['pid'], 'featured_h', 'h');
				update_post_meta($_REQUEST['pid'], 'featured_type', 'both');			
			}elseif($payforfeatured_c == 1){
				update_post_meta($_REQUEST['pid'], 'featured_c', 'c');
				update_post_meta($_REQUEST['pid'], 'featured_type', 'c');
			}elseif($payforfeatured_h == 1){
				update_post_meta($_REQUEST['pid'], 'featured_h', 'h');
				update_post_meta($_REQUEST['pid'], 'featured_type', 'h');
			}else{
				update_post_meta($_REQUEST['pid'], 'featured_type', 'none');	
			}
			
			/* $wpdb->query("UPDATE $wpdb->posts SET post_status='".$tmpdata['post_default_status_paid']."' where ID = '".$_REQUEST['pid']."'");
			 $trans_status = $wpdb->query("update $transaction_tabel SET status = 1 where post_id = ".$_REQUEST['pid']); this should not be here as this is prebank transfer. We need to approve manually from backend */
			
		}
		/*Payment success Mail to admin START*/
		$admin_mail_subject =  apply_filters('prebanktransfer_admin_subject',__('Submission pending payment','templatic'));
		$admin_mail_content = $theme_settings['pre_payment_success_email_content_to_admin'];
		if(@$admin_mail_subject == '')
		{
			$admin_mail_subject = __('Submission pending payment','templatic');
		}
		if(@$admin_mail_content == '')
		{
			$admin_mail_content = "<p>Dear [#to_name#],</p><p>A payment from username [#user_login#] is now pending on a submission or subscription to one of your plans.</p><p>[#transaction_details#]</p><p>Thanks!<br/>[#site_name#]</p>";
		}
		
		$store_login='';
		$store_login_link='';
		if(function_exists('get_tevolution_login_permalink')){
			$store_login = '<a href="'.get_tevolution_login_permalink().'">'.__('Click Login','templatic').'</a>';
			$store_login_link = get_tevolution_login_permalink();
		}
		
		$search_array = array('[#to_name#]','[#payable_amt#]','[#transaction_details#]','[#site_name#]','[#admin_email#]','[#user_login#]','[#site_login_url#]','[#site_login_url_link#]');
		$replace_array = array($fromEmailName,$sql_payable_amt,$transaction_details,$store_name,get_option('admin_email'),$toEmailName,$store_login,$store_login_link);
		$admin_message = apply_filters('prebanktransfer_admin_message',str_replace($search_array,$replace_array,$admin_mail_content),$fromEmailName,$toEmailName);

		if(isset($_REQUEST['upgrade']) && $_REQUEST['upgrade']!=''){
		
		}else{
			templ_send_email($fromEmail,$fromEmailName,$fromEmail,$fromEmailName,$admin_mail_subject,$admin_message,$extra='');/* To admin email*/
		}
		
		/*Payment success Mail to admin FINISH*/
	}
	
	$amout= intval(get_post_meta($_REQUEST['pid'],'total_price',true));
	if($amout=='0' || $amout==''){
		
		global $wpdb;
		$transaction_tabel = $wpdb->prefix."transactions";
		$tmpdata = get_option('templatic_settings');
		
		if($_SESSION['custom_fields']['last_selected_pkg'])
		{
			$get_last_trans_status = $wpdb->get_var("select status from $transaction_tabel t where post_id='".$_SESSION['custom_fields']['user_last_postid']."' AND (t.package_type is NULL OR t.package_type=0) order by t.trans_id desc");
			if($get_last_trans_status==2){
				$get_last_trans_status=0;
			}
			if(@$get_last_trans_status !='')
				$trans_status = $wpdb->query($wpdb->prepare("update $transaction_tabel SET status = ".$get_last_trans_status." where post_id = %d",wp_kses_post($_REQUEST['pid'])));
	
		}
		else
		{
			$post_default_status = $tmpdata['post_default_status'];
			
			/* make status for subscription packages' listings status as per "Default status for paid submissions" from tevolution setting */
			$post_default_status_paid = $tmpdata['post_default_status_paid'];
			
			$transaction_tabel = $wpdb->prefix . "transactions";
			
			if(isset($_REQUEST['pid']) && $_REQUEST['pid'] != '')
			
			{
			
				$transaction_details = $wpdb->get_results("SELECT * FROM $transaction_tabel where post_id = ".$_REQUEST['pid']." AND user_id=".$current_user->ID." order by trans_id DESC LIMIT 1");

				$selected_package_id = $transaction_details[0]->package_id;
				$package_amount = get_post_meta($selected_package_id,'package_amount',true);
				$package_type = get_post_meta($selected_package_id,'package_type',true);
				
				
				if($package_type == 2 && $package_amount > 0){
					$wpdb->query("UPDATE $wpdb->posts SET post_status='".$post_default_status_paid."' where ID = '".wp_kses_post($_REQUEST['pid'])."'");
				}
			}
			
			/* subscription packages' listings status end  */
			
			if($tmpdata['post_default_status']=='publish' && !isset($_SESSION['custom_fields']['last_selected_pkg']) && $_SESSION['custom_fields']['last_selected_pkg'] == '' && (!isset($_REQUEST['upgrade']) && $_REQUEST['upgrade'] != 1) && (isset($_REQUEST['pid']) && $_REQUEST['pid'] != '')){
				if($amout == 0 && isset($_REQUEST['renew']) && $_REQUEST['renew'] ==1){
					$post_status = $tmpdata['post_default_status'];
					$post_default_status= ($post_status)? $post_status :  'draft';
				}elseif($amout > 0 && isset($_REQUEST['renew']) && $_REQUEST['renew'] ==1){
					$post_status = $tmpdata['post_default_status_paid'];
					$post_default_status= ($post_status)? $post_status :  'draft';
				}else{
					if($post_default_status != 'publish'){
						$trans_status = $wpdb->query($wpdb->prepare("update $transaction_tabel SET status = 0 where post_id = %d",wp_kses_post($_REQUEST['pid'])));
						$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_status='".$post_default_status."' where ID = %d",wp_kses_post($_REQUEST['pid'])));
					}else{
						$trans_status = $wpdb->query($wpdb->prepare("update $transaction_tabel SET status = 1 where post_id = %d",wp_kses_post($_REQUEST['pid'])));
						$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_status='".$post_default_status."' where ID = %d",wp_kses_post($_REQUEST['pid'])));
					}
				}
				$trans_status = $wpdb->query($wpdb->prepare("update $transaction_tabel SET status = 1 where post_id = %d",wp_kses_post($_REQUEST['pid'])));
				$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_status='".$post_default_status."' where ID = %d",wp_kses_post($_REQUEST['pid'])));
			}elseif(isset($_REQUEST['pid']) && $_REQUEST['pid'] != ''){
				/* If the transaction status of the listing is "Approved"  at backed and if you edit the listing from the front end, after editing the listing if you check the transaction status of that listing it is showing "-" if should be "Approved" */
				$status = 0;
				if(get_post_status( $_REQUEST['pid'] ) == 'publish' || $package_type == 2){
					$status = 1;
				}
				$trans_status = $wpdb->query("update $transaction_tabel SET status = $status where post_id = ".wp_kses_post($_REQUEST['pid']));
			}
		}
		
	}
	
	global $wpdb;
	?>		
	<style type="text/css">
	.hentry .entry-title {
	  display: none;
	}
	</style>
			<div class="large-9 small-12 columns <?php echo stripslashes(get_option('ptthemes_sidebar_left')); ?>">
			 <h1 class="page-title"><?php echo $page_title; ?></h1>
			 <div class="posted_successful">
			 <?php
				do_action('tevolution_before_submition_success_msg');
				do_action('tevolution_submition_success_msg');
				do_action('tevolution_after_submition_success_msg');
			 ?> 
			</div>
			 <?php if(!isset($_REQUEST['upgrade']) && $_REQUEST['upgrade'] =='' && (isset($_REQUEST['pid']) && $_REQUEST['pid'] != ''))
				{
					do_action('tevolution_submition_success_post_content'); 
				}?>
			</div> <!-- content #end -->
	<?php 
	}
		if(isset($_REQUEST['pid']) && $_REQUEST['pid']!=""){
			$ptype = $wpdb->get_var($wpdb->prepare("select post_type from $wpdb->posts where $wpdb->posts.ID = %d",$_REQUEST['pid']));
			$cus_post_type = apply_filters('success_page_sidebar_post_type',$ptype);
		}
	
	}
add_shortcode( 'listing_success_page', 'tev_listing_success_page' ); /* protect from spambot*/

/**
 * Shortcode creation
 **/
 
add_shortcode('post_upgrade', 'tevolution_post_upgrade_template');
add_shortcode('submit_form', 'tevolution_form_page_template');
add_shortcode('advance_search_page', 'tevolution_advance_search_page');
add_shortcode('map_page', 'tevolution_map_page');
add_shortcode('tevolution_author_list', 'tevolution_author_list_fun');
add_shortcode('tevolution_listings_map', 'tevolution_all_list_map');
add_shortcode('tevolution_listings_map', 'tevolution_all_list_map');
?>
