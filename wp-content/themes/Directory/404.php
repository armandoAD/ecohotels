<?php
/**
 * 404 Template
 *
 * The 404 template is used when a reader visits an invalid URL on your site. By default, the template will 
 */
@header( 'HTTP/1.1 404 Not found', true, 404 );
add_filter('body_class','directory_404_page_class');
function directory_404_page_class($class){
	$class[]='layout-1c';
	return $class;
}
get_header(); /* Loads the header.php template. */
global $post;
$single_post = $post;
do_action('directory_before_container_breadcrumb'); ?>
<section id="content" class="error_404 large-9 small-12 columns">
	<?php do_action( 'open_content' ); ?>
	<div class="hfeed">
		<div id="post-0" >
			<div class="wrap404 clearfix">
				<div class="desc404">
					<h4><?php _e("Sorry, The page you're looking for cannot be found!",'templatic'); ?></h4>
		          <p><?php _e("I can help you find the page you want to see, just help me with a few clicks please.",'templatic'); ?></p>
				<p><?php  _e('I recommend you ','templatic');echo '<a href="'.home_url().'" title="Home">';_e('go to home','templatic'); echo'</a>';_e(' page or simply search what you want to see below','templatic'); ?></p>
				</div>
				<div class="search404"><?php get_search_form(); // Loads the searchform.php template. ?></div>
		     </div>
			<section class="entry-content">
				
			</section>
				<?php 
                    $Supreme_Theme_Settings_Options =get_option(supreme_prefix().'_theme_settings');;
                    $Get_All_Post_Types = explode(',',@$Supreme_Theme_Settings_Options['post_type_label']);
                    foreach($Get_All_Post_Types as $post_type):
					if($post_type!='page' && $post_type!="attachment" && $post_type!="revision" && $post_type!="nav_menu_item"):
						$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));	
						$archive_query = new WP_Query('showposts=60&post_type='.$post_type);
						if( count(@$archive_query->posts) > 0 ){
							$PostTypeObject = get_post_type_object($post_type);
							$PostTypeName = @$PostTypeObject->labels->name;
						}							
						$WPListCustomCategories = wp_list_categories('title_li=&hierarchical=0&show_count=0&echo=0&taxonomy='.$taxonomies[0]);
						if(($WPListCustomCategories) && $WPListCustomCategories!="No categories" && $WPListCustomCategories!="<li>No categories</li>"){
						?>
						<div class="arclist">
                                   <div class="title-container">
                                        <h2 class="title_green"><span><?php echo ucfirst($PostTypeName); _e(' Categories','templatic');?></span></h2>                                       
                                   </div>
                                   <ul>
                                   <?php echo $WPListCustomCategories;?>
                                   </ul>
						</div>
						<?php } 
					endif;
				endforeach;?>  
		</div>
     <!-- .hentry -->
	</div>
	<!-- .hfeed -->
	<?php $post = $single_post;?>
</section>
<!-- #content -->
<?php get_footer(); /* Loads the footer.php template.*/ ?>