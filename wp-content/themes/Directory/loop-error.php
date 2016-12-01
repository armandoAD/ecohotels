<?php
/**
 * Loop Error Template
 *
 * Displays an error message when no posts are found.
 */
?>
<ul class="looperror clearfix">
  
    <div class="entry-summary">
      <p class="looperror_msg">
        <?php 
		
			if(isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'favourites')
				_e( 'Whoops. Looks like there are no favourites available here.', 'templatic' ); 
			else
				_e( 'Whoops. Looks like there are no entries available here.', 'templatic' ); 
			/* return the submit form link on author page */
			if(function_exists('tmpl_get_submitfrm_link')){
				if(isset($_REQUEST['custom_post']) && $_REQUEST['custom_post'] !=''){
					
					echo tmpl_get_submitfrm_link($_REQUEST['custom_post']);
				
				}
			}
		?>
      </p>
    </div>
    <!-- .entry-summary --> 
  <!-- .hentry .error -->
</ul>