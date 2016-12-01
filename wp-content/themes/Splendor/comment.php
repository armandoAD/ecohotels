<?php
/**
 * Comment Template
 *
 * The comment template displays an individual comment. This can be overwritten by templates specific
 * to the comment type (comment.php, comment-{$comment_type}.php, comment-pingback.php, 
 * comment-trackback.php) in a child theme.
 */
	global $post, $comment;
	
	remove_action( 'comment_text', 'display_rating_star' );
	$tmpdata = get_option('templatic_settings');
	
	/* show ratings on comment form if enabled from bacjend */
	if($tmpdata['templatin_rating']=='yes'){
		add_action( 'comment_rate', 'display_rating_star' );
	}
?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
  <?php
    do_action( 'before_comment' );
    $author = get_comment_author( $comment->comment_ID );
    $url = get_comment_author_url( $comment->comment_ID );
	if($url==''){
		$url=get_author_posts_url($comment->user_id);	
	}
    $author_id = $comment->user_id;	
	/* get avatar of author */
	echo '<div class="author_image_date">';	
		if(get_user_meta($author_id,'profile_photo',true)){
			$size = ( ( $comment_list_args['avatar_size'] ) ? $comment_list_args['avatar_size'] : 60 );			
			echo '<a href="' . esc_url( $url ) . '" rel="external nofollow" title="' . esc_attr( $author ) . '" class="avatar-img"><img class="avatar avatar-'.absint( $size ).' photo" width="'.absint( $size ).'" height="'.absint( $size ).'" src="'.get_user_meta($author_id,'profile_photo',true).'" /></a>';
		}else{
			echo '<a href="' . esc_url( $url ) . '" rel="external nofollow" title="' . esc_attr( $author ) . '" class="avatar-img">';
			echo supreme_avatar();
			echo '</a>';
		}
		echo '<span class="published">' . sprintf( __( '%1$s', 'templatic' ), '<abbr class="comment-date" title="' . get_comment_date( esc_attr__( 'd M', 'templatic' ) ) . '">' . get_comment_date(esc_attr__( 'd M', 'templatic' )) . '</abbr>', '<abbr class="comment-time" title="' . get_comment_date( esc_attr__( 'd M', 'templatic' ) ) . '"></abbr>' ) . '</span>';
	echo '</div>';	
    ?>
  <div id="comment-<?php comment_ID(); ?>" class="comment-wrap">
    <?php do_action( 'open_comment' );  ?>
    <div class="comment-header comment-author vcard">
      <?php
			/* get author name on reviews */
			do_action('comment_rate');
			echo ' -'.apply_atomic_shortcode( 'comment_meta', '<div class="comment-author">[comment-author]</div>' ); 			
			
    /* Show reply link only when comments are enable other wise its generate blank "<span>" */
		if ( pings_open() && comments_open() )
		{
			$comment_reply_link = '<span class="comment-reply">[splendor-comment-reply-link]</span>';
		}
		echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta">'.$comment_reply_link.'</div>' ); 
		?>
    </div>

    <!-- .comment-meta -->
    <div class="comment-content comment">
      <?php 
		  if ( '0' == $comment->comment_approved && 1==apply_filters('comment_approved_filter',1)) : 
			echo apply_atomic_shortcode( 'comment_moderation', '<p class="alert moderation">' . __( 'Your comment is awaiting moderation.', 'templatic' ) . '</p>' );
		  
			else: comment_text( $comment->comment_ID );
				
				endif; ?>
    </div>
    <!-- .comment-content -->
    <?php 
		
		do_action( 'close_comment' );  ?>
  </div>
  <!-- #comment-## -->
  <?php do_action( 'after_comment' ); ?>
