<?php
/*
 * save and other rating related fnctions
 */
define('POSTRATINGS_MAX',5);
/*rating language file*/
define('RATING_MODULE_URLPATH',__(plugin_dir_url( __FILE__ ),'templatic'));
global $post,$rating_image_on,$rating_image_off,$rating_table_name,$wpdb;
$rating_table_name = $wpdb->prefix.'ratings';
add_action('init','tevolution_fetch_rating_image');
function tevolution_fetch_rating_image()
{
	global $post,$rating_image_on,$rating_image_off,$rating_table_name;
	$rating_image_on = plugin_dir_url( __FILE__ ).'images/rating_on.png';
	$rating_image_off = plugin_dir_url( __FILE__ ).'images/rating_off.png';
}



add_action('admin_init','tmpl_chk_rating_table');

/* check rating table is exists or not - if not then create the table */
function tmpl_chk_rating_table(){
	/* Check if auto install completed then perform below step incase user deteleted default settings */
	if(get_option('tmpl_is_tev_auto_insall') == 'true' || (is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX )):
	global $wpdb;
	$rating_table_name = $wpdb->prefix.'ratings';
	if(get_option('tev_rating_table') !='inserted'){
		if($wpdb->get_var("SHOW TABLES LIKE '".$rating_table_name."'") != $rating_table_name) {
			$wpdb->query("CREATE TABLE IF NOT EXISTS ".$rating_table_name." (
			  rating_id int(11) NOT NULL AUTO_INCREMENT,
			  rating_postid int(11) NOT NULL,
			  rating_posttitle text NOT NULL,
			  rating_rating int(2) NOT NULL,
			  rating_timestamp varchar(15) NOT NULL,
			  rating_ip varchar(40) NOT NULL,
			  rating_host varchar(200) NOT NULL,
			  rating_username varchar(50) NOT NULL,
			  rating_userid int(10) NOT NULL DEFAULT '0',
			  comment_id int(11) NOT NULL,
			  PRIMARY KEY (rating_id)
			) DEFAULT CHARSET=utf8");
		}
		update_option('tev_rating_table','inserted');
	}
	endif;
	
}
for($i=1;$i<=POSTRATINGS_MAX;$i++)
{
	$postratings_ratingsvalue[] = $i;
}
/* save rating in rating table*/
function save_comment_rating( $comment_id = 0,$comment_data) {
	global $wpdb,$rating_table_name, $post, $user_ID, $current_user;
	$rating_table_name = $wpdb->prefix.'ratings';
	$rate_user = $user_ID;
	$rate_userid = $user_ID;
	$post_id = (isset($_REQUEST['post_id']))? $_REQUEST['post_id'] : $comment_data->comment_post_ID ;
	$rating_post_id = $_REQUEST['comment_post_ID'];
	$post_title = $post->post_title;
	$rating_var = "post_".$post_id."_rating";
	$rating_val = (!isset($_REQUEST['dummy_insert']))?$_REQUEST["$rating_var"]:'5';
	if(!$rating_val){$rating_val=0;}
	$rating_ip = getenv("REMOTE_ADDR");
	if(!$rate_userid){
		$rate_userid = $current_user->ID;
	}	
	$wpdb->query("INSERT INTO $rating_table_name (rating_postid,rating_rating,comment_id,rating_ip,rating_userid) VALUES ( \"$post_id\", \"$rating_val\",\"$comment_id\",\"$rating_ip\",\"$rate_userid \")");

	$average_rating = get_post_average_rating($rating_post_id);
	update_post_meta($rating_post_id,'average_rating',$average_rating);
}
/*delete rating for particular comment while we delete comment */
add_action( 'wp_insert_comment', 'save_comment_rating',10,2 );
function delete_comment_rating($comment_id = 0)
{
	global $wpdb, $post, $user_ID;
	$rating_table_name = $wpdb->prefix.'ratings';
	if($comment_id)
	{
		$wpdb->query("delete from $rating_table_name where comment_id=\"$comment_id\"");
	}
	
}
add_action( 'wp_delete_comment', 'delete_comment_rating' );
/* fetch average rating */
function get_post_average_rating($pid)
{
	global $wpdb,$post;
	$rating_table_name = $wpdb->prefix.'ratings';
	$avg_rating = 0;
	if($pid)
	{		
		$comments = $wpdb->get_var("select group_concat(comment_ID) from $wpdb->comments where comment_post_ID=\"$pid\" and comment_approved=1 and comment_parent=0");
		if($comments){
			$avg_rating = $wpdb->get_var("select avg(rating_rating) from $rating_table_name where comment_id in ($comments) and rating_rating > 0 and rating_postid = ".$pid."");
		}
		$avg_rating = ceil($avg_rating);
		
	}
	return $avg_rating;
}
/* display rating */
function draw_rating_star_plugin($avg_rating)
{
	
	global $rating_image_on,$rating_image_off;
	$rtn_str = "";
	if($avg_rating > 0 )
	{
		for($i=0;$i<$avg_rating;$i++)
		{
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) 
				$rtn_str .= "<i class='rating-on'></i>";	
			else
				$rtn_str .= "<i class=\"rating-on\"></i>";
		}
		for($i=$avg_rating;$i<POSTRATINGS_MAX;$i++)
		{
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) 
				$rtn_str .= "<i class='rating-off'></i>";
			else
				$rtn_str .= "<i class=\"rating-off\"></i>";
		}
	}
	return $rtn_str;
}
/*
*show rating on recent review widget of directory theme
*/
add_filter('tmpl_show_tevolution_rating','tmpl_show_tevolution_rating',10,2);
function tmpl_show_tevolution_rating($rating_star,$post_rating='')
{
	return draw_rating_star_plugin($post_rating);
}
/*REVIEW RATING SHORTING -- filters are from library/functions/listing_filters.php file.*/
function ratings_in_comments () {
	$tmpdata = get_option('templatic_settings');
	if($tmpdata['templatin_rating']=='yes'):?>
    <div class="templatic_rating">
        <span class="rating_text"><?php _e('Rate this by clicking a star below','templatic');?>: </span>
        <p class="commpadd"><span class="comments_rating"> <?php require_once (TEMPL_MONETIZE_FOLDER_PATH . 'templatic-ratings/get_rating.php');?> </span> </p>
    </div>    
	<?php endif;
}
/************************************
 Comment listing format
***************************************/
function ratings_list($comment) {
	global $wpdb,$post,$rating_table_name;
	$comment_details = get_comment( $comment ); 
	if($comment_details->comment_parent!=0)
		return;
	?>
   <div id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?> >
    <div class="comment-text">
        <span class="single_rating"> 
			<?php			
                 $post_rating = $wpdb->get_var("select rating_rating  from $rating_table_name where comment_id=\"$comment\" and rating_postid = ".$post->ID."");
                echo draw_rating_star_plugin($post_rating);
            ?>
      	</span> 
      	 <?php if (isset($comment->comment_approved) && $comment->comment_approved == '0') : ?>
        	 <div>
	        	<?php _e('Your comment is awaiting moderation.','templatic') ?>
         	</div>   
    	 <?php endif; ?>
    </div>
  </div>
<?php
}
/*  display raing call funtion */
function display_rating_star($text) {
	global $post;	
	if($post->post_type!='post'){
		$comment_id = get_comment_ID();
		get_comment($comment_id );
		ratings_list($comment_id);
	}
	return $text;
}
/* count total rating for particular post */
function get_post_total_rating($pid)
{
	global $wpdb,$rating_table_name;
	$avg_rating = 0;
	if($pid)
	{		
		$total_rating = $wpdb->get_var("select count(comment_ID) from $wpdb->comments where comment_post_ID=\"$pid\" and comment_approved=1");
	}
	return $total_rating;
}

/* Display Rarting */
add_action('templ_post_title','tevolution_listing_after_title',12);
function tevolution_listing_after_title()
{
	global $post,$htmlvar_name,$posttitle,$wp_query;	
	
	$is_archive = get_query_var('is_ajax_archive');	
	if((is_archive() || $is_archive == 1) || is_tax() || is_search() || is_single() || DOING_AJAX){
		$post_id=get_the_ID();
		$tmpdata = get_option('templatic_settings');
		$total_rating_average=(function_exists('get_post_average_rating')) ? get_post_average_rating($post_id): '';
		if($tmpdata['templatin_rating']=='yes' &&  $total_rating_average!='' ){
		   if($post->post_type != 'post')
			 { 
		
		?>

		   <div class="listing_rating">
				<div class="directory_rating_row"><span class="single_rating"> <?php echo draw_rating_star_plugin($total_rating_average);?> </span></div>
		   </div>
	  <?php  }
	  }else{
	  
		     if($post->post_type != 'post')
			 { 
				do_action('show_multi_rating');
			 }
	  		}
	}
}
/*
 * Function Name: single_post_comment_ratings
 * Return: display the rating start on comment box
 */
add_action('tmpl_before_comments','single_post_comment_ratings',99);
function single_post_comment_ratings()
{
	/* Add ratings after default fields above the comment box, always visible */
     $tmpdata = get_option('templatic_settings');
     if($tmpdata['templatin_rating']=='yes'):
		add_action( 'comment_form_logged_in_after', 'ratings_in_comments' );
		add_action( 'comment_form_after_fields', 'ratings_in_comments' );
		add_action( 'comment_text', 'display_rating_star' );
     endif;	
}

/*
	Display rating on detail page 
*/
add_action('tevolution_display_rating','tevolution_display_rating');
function tevolution_display_rating($post_id){
	/*action to show rating*/
	do_action('show_multi_rating');
	$tmpdata = get_option('templatic_settings');
	if($tmpdata['templatin_rating']=='yes'):
		$total=get_post_total_rating(get_the_ID());
		$total=($total=='')? 0: $total; ?>
			<div class="tevolution_rating">
			<?php if(($total==1)){ ?>
				<div class="tevolution_rating_row"><span class="single_rating"> <?php echo draw_rating_star_plugin(get_post_average_rating(get_the_ID()));?> <span><?php echo $total.' '; echo '<a href="#comments">'; _e('Review','templatic'); echo '</a>'; ?></span></span></div>
			<?php }else{ ?>
				<div class="tevolution_rating_row"><span class="single_rating"> <?php echo draw_rating_star_plugin(get_post_average_rating(get_the_ID()));?> <span><?php echo $total.' '; echo '<a href="#comments">'; _e('Reviews','templatic'); echo '</a>';  ?></span></span></div>
			<?php } ?>
			  </div>
	<?php endif;

}

/* Display Ratings on detail page */
add_action('tevolution_display_rating','tmpl_display_rating');
function tmpl_display_rating($post_id){	
	/*action to show rating*/
	do_action('show_single_multi_rating');
}
?>