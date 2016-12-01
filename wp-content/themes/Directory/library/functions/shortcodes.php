<?php
/**
 * Shortcodes bundled for use with themes. 
 */

/**
 * Cleaner Caption - Cleans up the WP [caption] shortcode.
 **/
add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 ); /* Filter the caption shortcode output. */
/*
Name :cleaner_caption
Description : * WordPress adds an inline style to its [caption] shortcode which specifically adds 10px of extra width to  captions, making theme authors jump through hoops to design captioned elements to their liking.  This extra width makes the assumption that all captions should have 10px of extra padding to account for a box that wraps the element.  This script changes the width to match that of the 'width' attribute passed in through the shortcode, allowing themes to better handle how their captions are designed.
*/
function cleaner_caption( $output, $attr, $content ) {
	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;
	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);
	/* Allow developers to override the default arguments. */
	$defaults = apply_filters( 'cleaner_caption_defaults', $defaults );
	/* Apply filters to the arguments. */
	$attr = apply_filters( 'cleaner_caption_args', $attr );
	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );
	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;
	/* Set up the attributes for the caption <div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';
	/* Open the caption <div>. */
	$output = '<div' . $attributes .'>';
	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );
	/* Append the caption text. */
	$output .= '<p class="wp-caption-text">' . $attr['caption'] . '</p>';
	/* Close the caption </div>. */
	$output .= '</div>';
	/* Return the formatted, clean caption. */
	return apply_filters( 'cleaner_caption', $output );
}
/*
Name : supreme_add_shortcodes
Description : to add shortcodes
*/
	/* Add theme-specific shortcodes. */
	add_shortcode( 'the-year', 'supreme_the_year_shortcode' );
	add_shortcode( 'site-link', 'supreme_site_link_shortcode' );
	add_shortcode( 'wp-link', 'supreme_wp_link_shortcode' );
	add_shortcode( 'theme-link', 'supreme_theme_link_shortcode' );
	add_shortcode( 'child-link', 'supreme_child_link_shortcode' );
	add_shortcode( 'loginout-link', 'supreme_loginout_link_shortcode' );
	add_shortcode( 'query-counter', 'supreme_query_counter_shortcode' );
	add_shortcode( 'post-format-link', 'supreme_post_format_link_shortcode' );
	add_shortcode( 'entry-terms', 'supreme_entry_terms_shortcode' );
	/* Add comment-specific shortcodes. */
	add_shortcode( 'comment-published', 'supreme_comment_published_shortcode' );
	add_shortcode( 'comment-author', 'supreme_comment_author_shortcode' );
	add_shortcode( 'comment-edit-link', 'supreme_comment_edit_link_shortcode' );
	add_shortcode( 'comment-reply-link', 'supreme_comment_reply_link_shortcode' );
	add_shortcode( 'comment-permalink', 'supreme_comment_permalink_shortcode' );
	
	add_shortcode('clear', 'st_break');
	add_shortcode('one_third', 'st_one_third');
	add_shortcode('one_third_last', 'st_one_third_last');
	add_shortcode('two_thirds', 'st_two_thirds');
	add_shortcode('two_thirds_last', 'st_two_thirds_last');
	add_shortcode( 'Download', 'message_download' );
	add_shortcode( 'Alert', 'message_alert' );
	add_shortcode( 'Note', 'message_note' );
	add_shortcode( 'Info', 'message_info' );
	add_shortcode( 'Author_Info', 'about_author' );
	add_shortcode( 'Icon_List', 'icon_list_view' );
	add_shortcode( 'Normal_Box', 'normal_box' );
	add_shortcode( 'Warning_Box', 'warning_box' );
	add_shortcode( 'About_Box', 'about_box' );
	add_shortcode( 'Download_Box', 'download_box' );
	add_shortcode( 'Info_Box', 'info_box' );
	add_shortcode( 'Alert_Box', 'alert_box' );
	add_shortcode( 'Small_Button', 'small_button' );
	add_shortcode('one_half', 'st_one_half');
	add_shortcode('one_half_last', 'st_one_half_last');
	add_shortcode('one_fourth', 'st_one_fourth');
	add_shortcode('one_fourth_last', 'st_one_fourth_last');
	add_shortcode('three_fourths', 'st_three_fourths');
	add_shortcode('three_fourths_last', 'st_three_fourths_last');
	add_shortcode('one_fifth', 'st_one_fifth');
	add_shortcode('two_fifth', 'st_two_fifth');
	add_shortcode('three_fifth', 'st_three_fifth');
	add_shortcode('four_fifth', 'st_four_fifth');
	add_shortcode('one_fifth_last', 'st_one_fifth_last');
	add_shortcode('two_fifth_last', 'st_two_fifth_last');
	add_shortcode('three_fifth_last', 'st_three_fifth_last');
	add_shortcode('four_fifth_last', 'st_four_fifth_last');
	add_shortcode('one_sixth', 'st_one_sixth');
	add_shortcode('one_sixth_last', 'st_one_sixth_last');
	add_shortcode('five_sixth', 'st_five_sixth');

	add_shortcode('five_sixth_last', 'st_five_sixth_last');
	add_shortcode( 'Normal_Box_Equal', 'normal_box_equal' );
	add_shortcode( 'Warning_Box_Equal', 'warning_box_equal' );
	add_shortcode( 'About_Box_Equal', 'about_box' );
	add_shortcode( 'Download_Box_Equal', 'download_box_equal' );
	add_shortcode( 'Info_Box_Equal', 'info_box_equal' );
	add_shortcode( 'Alert_Box_Equal', 'alert_box_equal' );
	add_shortcode( 'One_Half', 'one_half_column' );
	add_shortcode( 'One_Half_Last', 'one_half_last' );
	add_shortcode( 'One_Third', 'one_third_column' );
	add_shortcode( 'One_Third_Last', 'one_third_column_last' );
	add_shortcode( 'One_Fourth', 'one_fourth_column' );
	add_shortcode( 'One_Fourth_Last', 'one_fourth_column_last' );
	add_shortcode( 'Two_Third', 'two_thirds' );
	add_shortcode( 'Two_Third_Last', 'two_thirds_last' );
	add_shortcode( 'Dropcaps', 'dropcaps' );
/**
 * Shortcode to display the current year.
 */
function supreme_the_year_shortcode() {
	return date( __( 'Y', 'templatic' ) );
}
/**
 * Shortcode to display a link back to the site.
 */
function supreme_site_link_shortcode() {
	return '<a class="site-link" href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home"><span>' . get_bloginfo( 'name' ) . '</span></a>';
}
/**
 * Shortcode to display a link to WordPress.org.
 */
function supreme_wp_link_shortcode() {
	return '<a class="wp-link" href="http://wordpress.org" title="' . esc_attr__( 'State-of-the-art semantic personal publishing platform', 'templatic' ) . '"><span>' . __( 'WordPress', 'templatic' ) . '</span></a>';
}
/**
 * Shortcode to display a link to the parent theme page.
 */
function supreme_theme_link_shortcode() {
	$theme = wp_get_theme( get_template(), get_theme_root( get_template_directory() ) );
	return '<a class="theme-link" href="' . esc_url( $theme->get( 'ThemeURI' ) ) . '" title="' . sprintf( esc_attr__( '%s WordPress Theme', 'templatic' ), $theme->get( 'Name' ) ) . '"><span>' . esc_attr( $theme->get( 'Name' ) ) . '</span></a>';
}
/**
 * Shortcode to display a link to the child theme's page.
 */
function supreme_child_link_shortcode() {
	$theme = wp_get_theme( get_stylesheet(), get_theme_root( get_stylesheet_directory() ) );
	return '<a class="child-link" href="' . esc_url( $theme->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $theme->get( 'Name' ) ) . '"><span>' . esc_html( $theme->get( 'Name' ) ) . '</span></a>';
}
/**
 * Shortcode to display a login link or logout link.
 *
 */
function supreme_loginout_link_shortcode() {
	if ( is_user_logged_in() )
		$out = '<a class="logout-link" href="' . esc_url( wp_logout_url( site_url( $_SERVER['REQUEST_URI'] ) ) ) . '" title="' . esc_attr__( 'Log out', 'templatic' ) . '">' . __( 'Log out', 'templatic' ) . '</a>';
	else
		$out = '<a class="login-link" href="' . esc_url( wp_login_url( site_url( $_SERVER['REQUEST_URI'] ) ) ) . '" title="' . esc_attr__( 'Log in', 'templatic' ) . '">' . __( 'Log in', 'templatic' ) . '</a>';
	return $out;
}
/**
 * Displays query count and load time if the current user can edit themes.
 */
function supreme_query_counter_shortcode() {
	if ( current_user_can( 'edit_theme_options' ) )
		return sprintf( __( 'This page loaded in %1$s seconds with %2$s database queries.', 'templatic' ), timer_stop( 0, 3 ), get_num_queries() );
	return '';
}
/**
 * Displays a list of terms for a specific taxonomy.
 */
function supreme_entry_terms_shortcode( $attr ) {
	$attr = shortcode_atts( array( 'id' => get_the_ID(), 'taxonomy' => 'post_tag', 'separator' => '<span class="i_tags">,</span> ', 'before' => '', 'after' => '' ), $attr );
	$attr['before'] = ( empty( $attr['before'] ) ? '<span class="' . $attr['taxonomy'] . '">' : '<span class="' . $attr['taxonomy'] . '"><span class="before">' . $attr['before'] . '</span>' );
	$attr['after'] = ( empty( $attr['after'] ) ? '</span>' : '<span class="after">' . $attr['after'] . '</span></span>' );
	return get_the_term_list( $attr['id'], $attr['taxonomy'], $attr['before'], $attr['separator'], $attr['after'] );
}
/**
 * Displays the published date and time of an individual comment.
 *
 */
function supreme_comment_published_shortcode() {
	$link = '<span class="published">' . sprintf( __( '%1$s at %2$s', 'templatic' ), '<abbr class="comment-date" title="' . get_comment_date( esc_attr__( 'l, F jS, Y, g:i a', 'templatic' ) ) . '">' . get_comment_date() . '</abbr>', '<abbr class="comment-time" title="' . get_comment_date( esc_attr__( 'l, F jS, Y, g:i a', 'templatic' ) ) . '">' . get_comment_time() . '</abbr>' ) . '</span>';
	return $link;
}
/**
 * Displays the comment author of an individual comment.
 */
function supreme_comment_author_shortcode( $attr ) {
	global $comment,$post;
	$attr = shortcode_atts(
		array(
			'before' => '',
			'after' => '',
			'tag' => 'span' // @deprecated 1.2.0 Back-compatibility. Please don't use this argument.
		),
		$attr
	);
	$author = esc_html( get_comment_author( $comment->comment_ID ) );
	$url = esc_url( get_comment_author_url( $comment->comment_ID ) );
	if($url==''){
		$url=get_author_posts_url($comment->user_id);	
	}
	/* Display link and cite if URL is set. Also, properly cites trackbacks/pingbacks. */
	
	if($comment->user_id == $post->post_author){
		$owner = __(' (Listing owner) ','templatic');
	}
	if ( $rl )
		$output = '<cite class="fn" title="' . $url . '"><a href="' . $url . '" title="' . esc_attr( $author ) . '" class="url" rel="external nofollow">' . $author.$owner . '</a></cite>';
	else
		$output = '<cite class="fn">' . $author.$owner . '</cite>';
	$output = '<' . tag_escape( $attr['tag'] ) . ' class="comment-author vcard">' . $attr['before'] . apply_filters( 'get_comment_author_link', $output ) . $attr['after'] . '</' . tag_escape( $attr['tag'] ) . '><!-- .comment-author .vcard -->';
	return $output;
}
/**
 * Displays the permalink to an individual comment.
 */
function supreme_comment_permalink_shortcode( $attr ) {
	global $comment;
	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );
	$link = '<a class="permalink" href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '" title="' . sprintf( esc_attr__( 'Permalink to comment %1$s', 'templatic' ), $comment->comment_ID ) . '">' . __( 'Permalink', 'templatic' ) . '</a>';
	return $attr['before'] . $link . $attr['after'];
}
/**
 * Displays a comment's edit link to users that have the capability to edit the comment.
 */
function supreme_comment_edit_link_shortcode( $attr ) {
	global $comment;
	$edit_link = get_edit_comment_link( $comment->comment_ID );
	if ( !$edit_link )
		return '';
	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );
	$link = '<a class="comment-edit-link" href="' . esc_url( $edit_link ) . '" title="' . sprintf( esc_attr__( 'Edit %1$s', 'templatic' ), $comment->comment_type ) . '"><span class="edit">' . __( 'Edit', 'templatic' ) . '</span></a>';
	$link = apply_filters( 'edit_comment_link', $link, $comment->comment_ID );
	return $attr['before'] . $link . $attr['after'];
}
/**
 * Displays a reply link for the 'comment' comment_type if threaded comments are enabled.
 */
function supreme_comment_reply_link_shortcode( $attr ) {
	if ( !get_option( 'thread_comments' ) || 'comment' !== get_comment_type() )
		return '';
	$defaults = array(
		'reply_text' => __( 'Reply', 'templatic' ),
		'login_text' => __( 'Log in to reply.', 'templatic' ),
		'depth' => intval( $GLOBALS['comment_depth'] ),
		'max_depth' => get_option( 'thread_comments_depth' ),
		'before' => '',
		'after' => ''
	);
	$attr = shortcode_atts( $defaults, $attr );
	return get_comment_reply_link( $attr );
}
/**
 * set a reply link for the 'comment' comment_type if threaded comments are enabled.
 */
if ( ! function_exists( 'directory_comment_log_in' ) )
{
    add_filter( 'comment_reply_link', 'directory_comment_log_in' );

    /**
     * Replaces the log-in link with an empty string.
     *
     * @param  string $link
     * @return string
     */
    function directory_comment_log_in( $link )
    {
        if ( empty ( $GLOBALS['user_ID'] ) && get_option( 'comment_registration' ) )
        {
			$login_url = '';
			if(function_exists( 'get_tevolution_login_permalink' ) )
			{
				$login_url = get_tevolution_login_permalink();	
			}
			$comment_login_url = "<a href='".$login_url."'>".__( 'Log in to reply.', 'templatic' )."</a>";
            return $comment_login_url;
        }

        return $link;
    }
}
// Break
function st_break( $atts, $content = null ) {
	return '<div class="clear"></div>';
}

// Line Break
function st_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}

function st_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function st_two_thirds( $atts, $content = null ) {
   return '<div class="two_thirds">' . do_shortcode($content) . '</div>';
}

function st_two_thirds_last( $atts, $content = null ) {
   return '<div class="two_thirds last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

// Shortcodes - Messages -------------------------------------------------------- //
function message_download( $atts, $content = null ) {
   return '<p class="download">' . $content . '</p>';
}

function message_alert( $atts, $content = null ) {
   return '<p class="alert">' . $content . '</p>';
}

function message_note( $atts, $content = null ) {
   return '<p class="note">' . $content . '</p>';
}

function message_info( $atts, $content = null ) {
   return '<p class="info">' . $content . '</p>';
}

// Shortcodes - About Author -------------------------------------------------------- //
function about_author( $atts, $content = null ) {
   return '<div class="about_author">' . $content . '</div>';
}

function icon_list_view( $atts, $content = null ) {
   return '<div class="check_list">' . $content . '</div>';
}

// Shortcodes - Boxes -------------------------------------------------------- //
function normal_box( $atts, $content = null ) {
   return '<div class="boxes normal_box">' . $content . '</div>';
}

function warning_box( $atts, $content = null ) {
   return '<div class="boxes warning_box">' . $content . '</div>';
}

function about_box( $atts, $content = null ) {
   return '<div class="boxes about_box">' . $content . '</div>';
}

function download_box( $atts, $content = null ) {
   return '<div class="boxes download_box">' . $content . '</div>';
}

function info_box( $atts, $content = null ) {
   return '<div class="boxes info_box">' . $content . '</div>';
}

function alert_box( $atts, $content = null ) {
   return '<div class="boxes alert_box">' . $content . '</div>';
}

// Shortcodes - Small Buttons -------------------------------------------------------- //
function small_button( $atts, $content ) {
 return '<div class="small_button '.$atts['class'].'">' . $content . '</div>';
}

//FUNCTION NAME : Related post as per tags
//RETURNS : a search box wrapped in a div
// 1-4 col 
function st_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}

function st_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function st_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}

function st_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function st_three_fourths( $atts, $content = null ) {
   return '<div class="three_fourths">' . do_shortcode($content) . '</div>';
}

function st_three_fourths_last( $atts, $content = null ) {
   return '<div class="three_fourths last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function st_one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}

function st_two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}

function st_three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}

function st_four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}

//
function st_one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function st_two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function st_three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function st_four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

// 1-6 col 
// one_sixth
function st_one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}

function st_one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

// five_sixth
function st_five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}

function st_five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
function st_linebreak( $atts, $content = null ) {
	return '<hr /><div class="clear"></div>';
}
add_shortcode('clearline', 'st_linebreak');

// Shortcodes - Boxes - Equal -------------------------------------------------------- //
function normal_box_equal( $atts, $content = null ) {
   return '<div class="boxes normal_box small">' . $content . '</div>';
}

function warning_box_equal( $atts, $content = null ) {
   return '<div class="boxes warning_box small">' . $content . '</div>';
}

function about_box_equal( $atts, $content = null ) {
   return '<div class="boxes about_box small">' . $content . '</div>';
}

function download_box_equal( $atts, $content = null ) {
   return '<div class="boxes download_box small">' . $content . '</div>';
}

function info_box_equal( $atts, $content = null ) {
   return '<div class="boxes info_box small">' . $content . '</div>';
}

function alert_box_equal( $atts, $content = null ) {
   return '<div class="boxes alert_box small">' . $content . '</p></div>';
}

// Shortcodes - Content Columns -------------------------------------------------------- //
function one_half_column( $atts, $content = null ) {
   return '<div class="one_half_column left">' . $content . '</div>';
}

function one_half_last( $atts, $content = null ) {
   return '<div class="one_half_column right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}

function one_third_column( $atts, $content = null ) {
   return '<div class="one_third_column left">' . $content . '</p></div>';
}

function one_third_column_last( $atts, $content = null ) {
   return '<div class="one_third_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}

function one_fourth_column( $atts, $content = null ) {
   return '<div class="one_fourth_column left">' . $content . '</p></div>';
}

function one_fourth_column_last( $atts, $content = null ) {
   return '<div class="one_fourth_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}

function two_thirds( $atts, $content = null ) {
   return '<div class="two_thirds left">' . $content . '</p></div>';
}

function two_thirds_last( $atts, $content = null ) {
   return '<div class="two_thirds_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}

function dropcaps( $atts, $content = null ) {
   return '<p class="dropcaps">' . $content . '</p>';
}

/**
 * Returns the output of the [post-format-link] shortcode.  This shortcode is for use when a theme uses the 
 * post formats feature.
 */
function supreme_post_format_link_shortcode( $attr ) {
	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );
	$format = get_post_format();
	$url = ( empty( $format ) ? get_permalink() : get_post_format_link( $format ) );
	return $attr['before'] . '<a href="' . esc_url( $url ) . '" class="post-format-link">' . get_post_format_string( $format ) . '</a>' . $attr['after'];
}
?>