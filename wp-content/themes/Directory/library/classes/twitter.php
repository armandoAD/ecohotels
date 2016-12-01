<?php
if(!function_exists('is_curl_installed')){
	function is_curl_installed() {
		if  (in_array  ('curl', get_loaded_extensions())) {
			return true;
		}
		else {
			return false;
		}
	}
}
if(!class_exists('templatic_twiter')){
	if (!class_exists('span'))
	{
		require_once('Oauth/twitteroauth.php');
	}
	class templatic_twiter extends WP_Widget{
		function templatic_twiter(){
			$this->options = array(
				array(
					'name'	=> 'title',
					'label'	=> __( 'Title:', 'templatic-admin' ),
					'type'	=> 'text'
				),			
				array(
					'name'	=> 'twitter_username',
					'label'	=> __( 'Twitter Username:', 'templatic-admin' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'consumer_key',
					'label'	=> __( 'Consumer Key:', 'templatic-admin' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'consumer_secret',
					'label'	=> __( 'Consumer Secret:', 'templatic-admin' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'access_token',
					'label'	=> __( 'Access Token:', 'templatic-admin' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'access_token_secret',
					'label'	=> __( 'Access Token Secret:', 'templatic-admin' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'twitter_number',
					'label'	=> __( 'Number Of Tweets:', 'templatic-admin' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'follow_text',
					'label'	=> __( 'Twitter button text <small>(for eg. Follow us, Join me on Twitter, etc.)</small>:', 'templatic-admin' ),
					'type'	=> 'text'
				),			
			);
			$widget_options = array(
				'classname'		=>	'twitter',
				'description'	=>	__('Display latest tweets from your Twitter account. Works best in sidebar areas.','templatic-admin')
			);
			parent::__construct(false, __('T &rarr; Twitter Feed','templatic-admin'), $widget_options);
		}
		
		function widget($args, $instance){
			extract($args, EXTR_SKIP );
			$title = ($instance['title']) ? $instance['title'] : 'Latest Tweets';
			$twitter_username = ($instance['twitter_username']) ? $instance['twitter_username'] : 'templatic';
			$consumer_key = ($instance['consumer_key']) ? $instance['consumer_key'] : '2OKhVHTMKJEdF018VBC4g';
			$consumer_secret = ($instance['consumer_secret']) ? $instance['consumer_secret'] : 'tnn0vWD1NSxra4D3HnXnCIg8iqTJ9QiwDEYCTg0UP4';
			$access_token = ($instance['access_token']) ? $instance['access_token'] : '147532710-UYn0B9Xg1lcxDpM40622HKA8dTXgeF8DcnJW5vQe';
			$access_token_secret = ($instance['access_token_secret']) ? $instance['access_token_secret'] : 'FkGYg0ZtJTLAva4Lw9FHBe6o18DPnj0xmtVKMlnTIM';
			$twitter_number = ($instance['twitter_number']) ? $instance['twitter_number'] : '5';
			$follow_text = ($instance['follow_text']) ? apply_filters('widget_title', $instance['follow_text']) : __("Follow Us",'templatic');
			
			echo $before_widget;
			echo '<div id="twitter" style="margin: auto;" >';
			if ( $title ) {
				echo '<h3 class="widget-title">' . $title . '</h3>';
			}
			if ($twitter_username != '') {
				if (!is_curl_installed()) {
				  _e("cURL is NOT installed on this server",'templatic');
				}else{
					if ($twitter_username != '') {
						templatic_twitter_messages($instance);
					}
				}
			}
			echo '</div>';
			echo $after_widget;
		}
		
		/** @see WP_Widget::update */
		function update($new_instance, $old_instance) {				
			$instance = $old_instance;
			foreach ($this->options as $val) {
				if ($val['type']=='text') {
					$instance[$val['name']] = strip_tags($new_instance[$val['name']]);
				} else if ($val['type']=='checkbox') {
					$instance[$val['name']] = ($new_instance[$val['name']]=='on') ? true : false;
				}
			}
			return $instance;
		}
		function form($instance){
			if (empty($instance)) {
				$instance['title']					= __( 'Latest Tweets', 'templatic' );			
				$instance['twitter_username']		= '';
				$instance['consumer_key']			= '';
				$instance['consumer_secret']		= '';
				$instance['access_token']			= '';
				$instance['access_token_secret']	= '';
				$instance['twitter_number']			= 5;
				$instance['follow_text']			= __('Follow Us','templatic');
			}
			echo __('<p><span style="font-size:11px">To use this widget, <a href="https://dev.twitter.com/apps/new" style="text-decoration:none;" target="_blank">create</a> an application or <a href="https://dev.twitter.com/apps" target="_blank" style="text-decoration:none;" >click here</a> if you already have it, and fill required fields below. Need help? Read <a href="http://templatic.com/docs/latest-changes-in-twitter-widget-for-all-templatic-themes/" title="Tweeter Widget Guide" target="_blank" style="text-decoration:none;" >Twitter Guide</a>.</small></p>','templatic-admin');
			foreach ($this->options as $val) {
				$label = '<label for="'.$this->get_field_id($val['name']).'">'.$val['label'].'</label>';
				if ($val['type']=='separator') {
					echo '<hr />';
				} else if ($val['type']=='text') {
					echo '<p>'.$label.'<br />';
					echo '<input class="widefat" id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="text" value="'.esc_attr($instance[$val['name']]).'" /></p>';
				} else if ($val['type']=='checkbox') {
					$checked = ($instance[$val['name']]) ? 'checked="checked"' : '';
					echo '<input id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="checkbox" '.$checked.' /> '.$label.'<br />';
				}
			}
		}
	}
	// Register Widget
	add_action('widgets_init', create_function('', 'return register_widget("templatic_twiter");'));
}
//Function to convert date to time ago format
//eg.1 day ago, 1 year ago, etc...
function time_elapsed_string($ptime) {
    $etime = time() - $ptime;
    
    if ($etime < 1) {
        return __('0 seconds','templatic');
    }
    
    $a = array( 12 * 30 * 24 * 60 * 60  =>  __('year','templatic'),
                30 * 24 * 60 * 60       =>  __('month','templatic'),
                24 * 60 * 60            =>  __('day','templatic'),
                60 * 60                 =>  __('hour','templatic'),
                60                      =>  __('minute','templatic'),
                1                       =>  __('second','templatic')
                );
    
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? __('s','templatic') : '').' '.__('ago','templatic');
        }
    }
}
/* Function to convert date to time ago format */
function templatic_twitter_messages($options){
	$twitter_username	 = $options['twitter_username'];
	$consumer_key		 = $options['consumer_key'];
	$consumer_secret	 = $options['consumer_secret'];
	$access_token		 = $options['access_token'];
	$access_token_secret = $options['access_token_secret'];
	$twitter_number		 = $options['twitter_number'];
	$follow_text		 = $options['follow_text'];
	
	if(!function_exists('getConnectionWithAccessToken')){
		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
			$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
			return $connection;
		}
	}
	
	
	$connection = getConnectionWithAccessToken($consumer_key, $consumer_secret, $access_token, $access_token_secret);
	$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitter_username."&count=".$twitter_number);		
	$tweet_errors = (array) @$tweets->errors;
	
	if (empty($tweets)) {
	    _e('No public tweets','templatic');
	}elseif(!empty($tweet_errors)){
		$twitter_error = $tweet_errors;
		$debug = '<br />Error:('.$twitter_error[0]->code.')<br/> '.$twitter_error[0]->message;
		_e('Unable to get tweets','templatic')." ".$debug;
	}else{
		echo '<ul id="twitter_update_list" class="templatic_twitter_widget">';
		foreach ($tweets  as $tweet) {
			$twitter_timestamp = strtotime($tweet->created_at);
			$tweet_date = time_elapsed_string( $twitter_timestamp );
			echo '<li>';
				echo parseTweet($tweet->text);
				echo '<span class="twit_time" style="display: block;">'.$tweet_date.'</span>';
			echo '</li>';
		}
		echo '</ul>';
		if($follow_text){				
			echo "<a href='http://www.twitter.com/$twitter_username/' title='$follow_text' class='twitter_title_link follow_us_twitter' target='_blank'>$follow_text</a>";				
		}
	}
}
if(!function_exists('parseTweet')){
function parseTweet($text) {
    $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Link
    $text = preg_replace('#@([a-z0-9_]+)#i', '@<a  target="_blank" href="http://twitter.com/$1">$1</a>', $text); //usernames
    $text = preg_replace('# \#([a-z0-9_-]+)#i', ' #<a target="_blank" href="http://search.twitter.com/search?q=%23$1">$1</a>', $text); //Hashtags
    $text = preg_replace('#https://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Links
    return $text;
}
}
?>
