<?php
/*
* includes the extended plugin main file of tevolution.
*/
class Templatic{
	var $file;
	var $version;
}

/* This class will fetch the all add-ons main file */
class Templatic_connector { 
	
	public function templ_dashboard_extends(){
	
		/* This is the correct way to loop over the directory. */
			
		do_action('templconnector_bundle_box');
			
		
		/* to get plugins */	
	
	}	
	/* -- Function contains bundles of file which creates the bunch of templatic other plugins list EOF - */
	function templ_extend(){
		$modules_array = array();
		$modules_array = array('templatic-custom_taxonomy','templatic-custom_fields','templatic-registration','templatic-monetization','templatic-claim_ownership');
		require_once(TEMPL_MONETIZE_FOLDER_PATH.'templ_header_section.php' );
		?>
        <p class="tevolution_desc"><?php echo __('Here are the most popular directory extensions to extend the functionality of your Business Directory site and make it more powerful. Please click the "Details & Purchase" button next to any of them to find out more about the functions they each offer.','templatic-admin');?></p>
          <?php
		echo '
		<div id="tevolution_bundled" class="metabox-holder wrapper widgets-holder-wrap"><table cellspacing="0" class="wp-list-tev-table postbox fixed pages ">
			<tbody style="background:white; padding:40px;">
			<tr><td>
			';
		/* This is the correct way to loop over the directory. */			
		do_action('tevolution_extend_box');
		/* to get t plugins */			
		echo '</td></tr>
		</tbody></table>
		</div>
		';
	
		require_once(TEMPL_MONETIZE_FOLDER_PATH.'templ_footer_section.php' );
	}
	
	
	/* -- Function contains bundles of file which creates the bunch of paymentgateway plugin lists backend EOF - */
	function templ_payment_gateway(){
		$modules_array = array();
		$modules_array = array('templatic-custom_taxonomy','templatic-custom_fields','templatic-registration','templatic-monetization','templatic-claim_ownership');
		require_once(TEMPL_MONETIZE_FOLDER_PATH.'templ_header_section.php' );
		?>
          <p class="tevolution_desc"><?php echo __('The payment gateways below will help you maximize the earning potential of your site. Offering more payment options to your users will help encourage more people, who perhaps might not find the built-in PayPal suitable, to submit a listing on your directory.','templatic-admin');?></p>
          <?php
		
		echo '
		<div id="tevolution_bundled" class="metabox-holder wrapper widgets-holder-wrap"><table cellspacing="0" class="wp-list-tev-table postbox fixed pages ">
			<tbody style="background:white; padding:40px;">
			<tr><td>
			';
		/* This is the correct way to loop over the directory. */
		do_action('tevolution_payment_gateway');
		echo '</td><td ><a style="width:150px;text-align:center;" href="https://templatic.com/wordpress-plugins/" class="button-primary">'.__('View All','templatic-admin').'</a>';
		/* to get t plugins */			
		echo '</td></tr>
		</tbody></table>
		</div>
		';
	
		require_once(TEMPL_MONETIZE_FOLDER_PATH.'templ_footer_section.php' );
	}
	
	/**
	 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
	 */
	function tmpl_let_to_num( $size ) {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}

	
	/* method to show system status */
	
	function templ_system_status()
	{
		require_once(TEMPL_MONETIZE_FOLDER_PATH.'templ_header_section.php' );
		?>
			<table class="tmpl-general-settings form-table" cellspacing="0" id="status">
				<thead>
					<tr>
						<th colspan="3" data-export-label="WordPress Environment"><h2><?php _e( 'WordPress Environment', 'templatic-admin' ); ?></h2></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th data-export-label="Home URL"><?php _e( 'Home URL', 'templatic-admin' ); ?>:</th>
						<td><?php echo get_option( 'home' ); ?></td>
					</tr>
					<tr>
						<th data-export-label="Site URL"><?php _e( 'Site URL', 'templatic-admin' ); ?>:</th>
						<td><?php echo get_option( 'siteurl' ); ?></td>
					</tr>
					<tr>
						<th data-export-label="WP Version"><?php _e( 'WP Version', 'templatic-admin' ); ?>:</th>
						<td><?php bloginfo('version'); ?></td>
					</tr>
					<tr>
						<th data-export-label="WP Multisite"><?php _e( 'WP Multisite', 'templatic-admin' ); ?>:</th>
						<td><?php if ( is_multisite() ) echo '&#10004;'; else echo '&ndash;'; ?></td>
					</tr>
					<tr>
						<th data-export-label="WP Memory Limit"><?php _e( 'WP Memory Limit', 'templatic-admin' ); ?>:</th>
						<td><?php
							$memory = $this->tmpl_let_to_num( WP_MEMORY_LIMIT );

							if ( function_exists( 'memory_get_usage' ) ) {
								$system_memory = $this->tmpl_let_to_num( @ini_get( 'memory_limit' ) );
								$memory        = max( $memory, $system_memory );
							}

							if ( $memory < 67108864 ) {
								echo '<mark class="error">' . sprintf( __( '%s - We recommend setting memory to at least 64MB. See: %s', 'templatic-admin' ), size_format( $memory ), '<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . __( 'Increasing memory allocated to PHP', 'templatic-admin' ) . '</a>' ) . '</mark>';
							} else {
								echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
							}
						?></td>
					</tr>
					<tr>
						<th data-export-label="WP Debug Mode"><?php _e( 'WP Debug Mode', 'templatic-admin' ); ?>:</th>
						<td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">&#10004;</mark>'; else echo '<mark class="no">&ndash;</mark>'; ?></td>
					</tr>
					<tr>
						<th data-export-label="Language"><?php _e( 'Language', 'templatic-admin' ); ?>:</th>
						<td><?php echo get_locale(); ?></td>
					</tr>
				</tbody>
			</table>
			
			<table class="tmpl-general-settings form-table" cellspacing="0">
				<thead>
					<tr>
						<th colspan="3" data-export-label="Server Environment"><h2><?php _e( 'Server Environment', 'templatic-admin' ); ?></h2></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th data-export-label="Server Info"><?php _e( 'Server Info', 'templatic-admin' ); ?>:</th>
						<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
					</tr>
					<tr>
						<th data-export-label="PHP Version"><?php _e( 'PHP Version', 'templatic-admin' ); ?>:</th>
						<td><?php
							// Check if phpversion function exists.
							if ( function_exists( 'phpversion' ) ) {
								$php_version = phpversion();

								if ( version_compare( $php_version, '5.4', '<' ) ) {
									echo '<mark class="error">' . sprintf( __( '%s - We recommend a minimum PHP version of 5.4. See: %s', 'templatic-admin' ), esc_html( $php_version ), '<a href="http://docs.woothemes.com/document/how-to-update-your-php-version/" target="_blank">' . __( 'How to update your PHP version', 'templatic-admin' ) . '</a>' ) . '</mark>';
								} else {
									echo '<mark class="yes">' . esc_html( $php_version ) . '</mark>';
								}
							} else {
								_e( "Couldn't determine PHP version because phpversion() doesn't exist.", 'templatic-admin' );
							}
							?></td>
					</tr>
					<?php if ( function_exists( 'ini_get' ) ) : ?>
						<tr>
							<th data-export-label="PHP Post Max Size"><?php _e( 'PHP Post Max Size', 'templatic-admin' ); ?>:</th>
							<td><?php echo size_format( $this->tmpl_let_to_num( ini_get( 'post_max_size' ) ) ); ?></td>
						</tr>
						<tr>
							<th data-export-label="PHP Time Limit"><?php _e( 'PHP Time Limit', 'templatic-admin' ); ?>:</th>
							<td><?php echo ini_get( 'max_execution_time' ); ?></td>
						</tr>
						<tr>
							<th data-export-label="PHP Max Input Vars"><?php _e( 'PHP Max Input Vars', 'templatic-admin' ); ?>:</th>
							<td><?php echo ini_get( 'max_input_vars' ); ?></td>
						</tr>
					<?php endif; ?>
					<tr>
						<th data-export-label="MySQL Version"><?php _e( 'MySQL Version', 'templatic-admin' ); ?>:</th>
						<td>
							<?php
							/** @global wpdb $wpdb */
							global $wpdb;
							echo $wpdb->db_version();
							?>
						</td>
					</tr>
					<tr>
						<th data-export-label="Max Upload Size"><?php _e( 'Max Upload Size', 'templatic-admin' ); ?>:</th>
						<td><?php echo size_format( wp_max_upload_size() ); ?></td>
					</tr>
					<tr>
						<th data-export-label="Default Timezone is UTC"><?php _e( 'PHP Allow URL fopen', 'templatic-admin' ); ?>:</th>
						<td><?php
							if ( ini_get( 'allow_url_fopen' ) ) {
								$allow_url_fopen = __( 'On', 'templatic-admin' );
							} else {
								$allow_url_fopen = __( 'Off', 'templatic-admin' );
							}
							$default_timezone = date_default_timezone_get();
							if ( 'On' !== $allow_url_fopen ) {
								echo '-';
							} else {
								echo '<mark class="yes">&#10004;</mark>';
							}?>
						</td>
					</tr>
					<tr>
						<th data-export-label="Default Timezone is UTC"><?php _e( 'fsockopen/cURL', 'templatic-admin' ); ?>:</th>
						<td><?php
							if ( function_exists('curl_version') ) {
								$allow_url_fopen = __( 'On', 'templatic-admin' );
							} else {
								$allow_url_fopen = __( 'Off', 'templatic-admin' );
							}
							$default_timezone = date_default_timezone_get();
							if ( !function_exists('curl_version') ) {
								echo '-';
							} else {
								echo '<mark class="yes">&#10004;</mark>';
							} ?>
						</td>
					</tr>
				</tbody>
			</table>

		<?php
	}
	
	/* -- Function display the overview box on templatic dashboard - */
	function templ_overview(){
	
		require_once(TEMPL_MONETIZE_FOLDER_PATH.'templ_header_section.php' );
		
		if((isset($_REQUEST['tab']) && $_REQUEST['tab'] =='overview') || !isset($_REQUEST['tab'])){ ?>
		<?php /* do_action('tevolution_details'); action to get server date time and other details */ ?>
		<script type="text/javascript">
			jQuery( document ).ready(function() {
				jQuery('.templatic-dismiss').remove();
			});
		</script>
		<div id="tevolution_dashboard_fullwidth">
		<div id="poststuff">
			<div class="postbox " id="formatdiv">
				<div class="handlediv" title="Click to toggle">
				<br>
				</div>
				<h3 class="hndle">
					<span><?php echo __('Verify your product license','templatic-admin'); ?></span>
				</h3>
				<div id="licence_fields">
					<form action="<?php echo site_url()."/wp-admin/admin.php?page=templatic_system_menu";?>" name="" method="post">
					<div class="inside">
                                            <p><?php echo __("Find your activation key by pressing the 'Download' button next to your product in the member area. click ",'templatic-admin') . '<a href="https://templatic.com/members/member">'. __('here','templatic-admin').'</a>. ' . __(" for details.",'templatic-admin'); ?></p>
					<div id="licence_fields">
				
						<div>
						<input type="password" name="licencekey" id="licencekey" value="<?php echo get_option('templatic_licence_key_'); ?>" size="30" max-length="36" PLACEHOLDER="templatic.com licence key"/>
						</div>

                                            <?php
						$templatic_licence_key = get_option('templatic_licence_key');
						if(strstr($templatic_licence_key,'is_supreme') && get_option('templatic_licence_key_') !='' && !$_POST){
							$verify= __('Verified','templatic-admin');
						}else{
							if(!$templatic_licence_key)
								$verify=__('Verify','templatic-admin');
							else	
								$verify=__('Verified','templatic-admin');
						}
						?>
						<input type="submit" accesskey="p" value="<?php echo $verify;?>" class="button button-primary button-large" id="Verify" name="Verify">

                                                <?php do_action('tevolution_activation_success_message'); ?>
                                                <?php do_action('tevolution_error_message'); ?>
						<?php
						$templatic_licence_key = get_option('templatic_licence_key');
						/*if(get_option('templatic_licence_key_') =='' && !$_POST){
						?>
							<p><?php echo __('Enter the license key in order to unlock the plugin and enable automatic updates.','templatic-admin'); ?></p>
						<?php
						}*/ ?>
					</div>
					
					</div>
					</form>
				<div class="licence_fields">
				</div>	
				</div>
			</div>
		</div>
		</div>
		<?php } 
		
		tmpl_overview_box();
		require_once(TEMPL_MONETIZE_FOLDER_PATH.'templ_footer_section.php' );
	}
}
?>