<?php
/**
 * Archive Template
 *
 * The archive template is the default template used for archives pages without a more specific template. 
 */
remove_action('pre_get_posts','tevolution_author_post');
get_header(); /* Loads the header.php template. */
	do_action( 'before_content' ); /* supreme_before_content */
	$user_id = get_query_var('author');?>
<section id="content" class="large-9 small-12 columns">
   <?php do_action( 'open_content' );
   do_action('author_box'); 
   do_action( 'templ_inside_container_breadcrumb' );
       
   $cus_post_type = get_post_type();
	if(!$cus_post_type){ $cus_post_type = sanitize_text_field($_REQUEST['custom_post']); }
	if(!$cus_post_type){ $cus_post_type = 'post'; }
	
	if(isset($_REQUEST['custom_post']) && $_REQUEST['custom_post']=='all'){
		$did = 'tmpl-search-results';
	}else{
		$did = 'loop_'.$cus_post_type.'_taxonomy';
	}	
   ?>

  <div id="<?php echo $did; ?>" class="hfeed list author-feeds">
    <?php 
		global $wp_query,$htmlvar_name;
		$wp_query->set('is_related',1);
		if(function_exists('tmpl_get_category_list_customfields')){
			$htmlvar_name = tmpl_get_category_list_customfields($cus_post_type);
		}else{
			global $htmlvar_name;
		}

		do_action( 'before_loop_archive' ); 
		if(!isset($_REQUEST['fb_event']))
		{
			if ( have_posts() ) : 
			 while ( have_posts() ) : the_post();
				do_action( 'before_entry' );
				
				$featured=get_post_meta(get_the_ID(),'featured_c',true);
				
				$featured=($featured=='c')?'featured_c':'';
				
				if(isset($_REQUEST['sort']) && $_REQUEST['sort'] =='favourites'){
					$post_type_tag = $post->post_type;
					$class="featured_list";
				}else{
					$post_type_tag = '';
					$class='';
				}
				
				/* on author page while click on add  to fav it didn't find any post type in URL , so set the post type from loop  */
				if(empty($htmlvar_name)){
					$htmlvar_name = tmpl_get_category_list_customfields($post->post_type);
				}
				?>
				<div id="post-<?php the_ID(); ?>" class="<?php if(function_exists('templ_post_class')){ templ_post_class(); }else{  post_class(); } ?>">
				  <?php if($post->post_type =='post'){
					get_template_part( 'content', 'blog'); 
				}else{ 
					$addons_posttype = tmpl_addon_name();
					$template = '/entry-mobile-'.get_post_type().'.php';
					if(file_exists( WP_PLUGIN_DIR.'/Tevolution-'.$addons_posttype[get_post_type()].'/templates'.$template)){
						$mob_template = WP_PLUGIN_DIR.'/Tevolution-'.$addons_posttype[get_post_type()].'/templates'.$template;
					}
					include($mob_template );
				} #post 
				
				/* edit/update button */
				do_action('tmpl_before_entry_end');    
				?>
				</div>
				<?php
				do_action( 'after_entry' );
				endwhile; 
					
				else:
					apply_filters('supreme-loop-error',get_template_part( 'loop-error' )); // Loads the loop-error.php template. 
				endif;
			}
			do_action( 'after_loop_archive' );
	
	 ?>
	</div>
	<!-- .hfeed -->
	<?php 
	
	do_action( 'close_content' ); 
	if(!isset($_REQUEST['fb_event']))
	{
		if(function_exists('directory_pagenavi_plugin')) {
			echo '<div class="pagination loop-pagination">';
			directory_pagenavi_plugin(); 
			echo '</div>';
		}
	}
	?>

</section>
<!-- #content -->
<?php do_action( 'after_content' ); /* supreme_after_content */
	
get_footer(); /* Loads the footer.php template. */ ?>