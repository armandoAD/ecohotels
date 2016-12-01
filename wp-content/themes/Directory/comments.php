<?php
/**
 * Comments Template
 *
 * Lists comments and calls the comment form.  Individual comments have their own templates.  The 
 * hierarchy for these templates is $comment_type.php, comment.php.
 */
/* Kill the page if trying to access this template directly. */
if ( 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
	die( __( 'Please do not load this page directly. Thanks!', 'templatic' ) );
/* If a post password is required or no comments are given and comments/pings are closed, return. */
if ( post_password_required() || ( !have_comments() && !comments_open() && !pings_open() ) )
	return;
?>
<section id="comments-template">
	<div class="comments-wrap <?php if(!get_option('show_avatars')) { echo "no-gravatar"; } ?>">
    <article id="comments">
      <?php if ( have_comments() ) : 
			
			do_action("show_comment");	?>
			<h3 id="comments-number" class="comments-header">
			<?php 
			global $post;
			if($post->post_type == 'post')
			{
				templatic_comments_number( __( 'No Comment', 'templatic' ), __( 'One Comment', 'templatic' ), __( 'Comments', 'templatic' )); 
			}
			else
			{
				templatic_comments_number( __( 'No Review', 'templatic' ), __( 'One Review', 'templatic' ), __( 'Reviews', 'templatic' ) ); 
			}?>
			</h3>
			<?php 
			do_action( 'before_comment_list' );
	  
			if ( get_option( 'page_comments' ) ) : ?>
				<div class="comment-navigation comment-pagination"> <span class="page-numbers"><?php printf( __( 'Page %1$s of %2$s', 'templatic' ), ( get_query_var( 'cpage' ) ? absint( get_query_var( 'cpage' ) ) : 1 ), get_comment_pages_count() ); ?></span>
				<?php paginate_comments_links(); ?>
				</div>
			<!-- .comment-navigation -->
			<?php endif; ?>
				<ol class="comment-list">
				<?php wp_list_comments( supreme_list_comments_args() ); ?>
				</ol>
		<!-- .comment-list -->
		<?php 
		do_action( 'after_comment_list' );
		 endif; 

		if ( pings_open() && !comments_open() ) : ?>
			<p class="comments-closed pings-open"> <?php 
			_e( 'Reviews are disabled, but ','templatic');
			echo '<a href='.get_trackback_url().' title="Track back URL for this post">';
				_e('trackbacks','templatic');
			echo '</a> '; 
			_e('and pingbacks are open.', 'templatic'  ); ?>
			</p>
		  <!-- .comments-closed .pings-open -->
		  <?php 
			elseif ( !comments_open() ) : ?>
			  <p class="comments-closed">
				<?php _e( 'Reviews are disabled.', 'templatic' ); ?>
			  </p>
		  <!-- .comments-closed -->
		  <?php 
		endif; ?>
    </article>
    <!-- #comments -->
	
    <?php	
	if(get_option('default_comment_status') =='open'){
			comment_form((isset($arg)) ? $arg : array()); } // Loads the comment form.  ?>
	</div>
  <!-- .comments-wrap -->
</section>
<!-- #comments-template -->