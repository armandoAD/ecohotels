<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 */

 if(!is_home() && !is_front_page() && get_query_var('page_id')!=get_option('page_on_front')){
	do_action( 'close_main' ); ?>
	</div>
	<!-- .wrap -->
	<?php
}

if(is_front_page() && (function_exists('tmpl_wp_is_mobile') && !tmpl_wp_is_mobile()))
{
	do_action( 'after_wrapper' );
}	
?>
</section>
<!-- #main -->
<?php do_action( 'after_main' );?>
</div>
<!-- #container -->

<a class="exit-off-canvas"></a> <!-- exit-off-canvas - overlay to exit offcanvas --> 
<a class="exit-selection"></a>
<div class="exit-sorting"></div>
</div>
<!-- inner-wrap start -->
</div>
<!-- off-canvas-wrap end -->

<?php do_action( 'close_body' );
	/* auto detect mobile devices */
	if ( function_exists('tmpl_wp_is_mobile') && tmpl_wp_is_mobile()) {
		include_once(get_template_directory().'/mobile-templates/mobile-footer.php');
	}else{
		if(function_exists('supreme_subsidiary_sidebar'))
			apply_filters('tmpl-subsidiary',supreme_subsidiary_sidebar() ); /* Loads the sidebar-subsidiary  */
		if(function_exists('supreme_subsidiary_2c_sidebar'))
			apply_filters('tmpl-subsidiary-2c',supreme_subsidiary_2c_sidebar() ); /*  Loads the sidebar-subsidiary  */
		if(function_exists('supreme_subsidiary_3c_sidebar')	)
			apply_filters('tmpl-subsidiary-3c',supreme_subsidiary_3c_sidebar() ); /* Loads the sidebar-subsidiary */
		if(function_exists('supreme_subsidiary_4c_sidebar'))
			apply_filters('tmpl-subsidiary-4c',supreme_subsidiary_4c_sidebar() ); /*  Loads the sidebar-subsidiary  */
		if(function_exists('supreme_subsidiary_navigation'))
			apply_filters('tmpl_subsidiary_nav',supreme_subsidiary_navigation()); /*  Loads the menu-subsidiary.php template. */
		do_action( 'before_footer' );  ?>
	<footer id="footer" class="clearfix">
	  <?php do_action( 'open_footer' );
			if(is_active_sidebar('footer')):
			?>
	  <section class="footer_top clearfix">
		<?php do_action('open_footer_widget'); ?>
		<div class="footer-wrap clearfix row">
		  <div class="columns">
			<div class="footer_widget_wrap">
			  <?php 
			  if(function_exists('supreme_footer_widgets'))
					apply_filters('tmpl_supreme_footer_widgets' ,supreme_footer_widgets()); /* load footer widgets */ ?>
			</div>
		  </div>
		</div>
		<?php do_action('close_footer_widget'); ?>
	  </section>
	  <?php endif; ?>
	  <section class="footer_bottom clearfix">
		<div class="footer-wrap clearfix row">
		  <div class="columns">
			<?php 
				/* before footer menu */
				do_action( 'before-footer-nav' ); 
				if(function_exists('supreme_footer_navigation'))	
					apply_filters('tmpl_supreme_footer_nav',supreme_footer_navigation()); /* Loads the menu-footer.  */
				 /* before footer content */
					do_action( 'before-footer-content' );
				
					if(function_exists('supreme_get_settings') && supreme_get_settings('footer_insert')){
						$footer_insert=supreme_get_settings( 'footer_insert' ) ;
					    if (function_exists('icl_register_string')){
							icl_register_string('supreme-footer_insert', 'footer_insert',$footer_insert);
							$footer_insert = icl_t('supreme-footer_insert', 'footer_insert',$footer_insert);
					    } ?>
						<div class="footer-content ">
							<?php 
							/* show footer content saved in customizer's footer field */
							echo apply_atomic_shortcode( 'footer_content', $footer_insert); ?>
						</div>
					<!-- .footer-content -->
					<?php   
					}else{ 
						if(!is_active_sidebar('footer')): ?>
							<div class="footer-content"> <?php echo '<p class="copyright">&copy; '.date('Y').' <a href="http://templatic.com/demos/directory">'.__('Directory 2','templatic').'</a>. &nbsp;'.__('Designed by','templatic').' <a href="http://templatic.com" class="footer-logo"><img src="'.get_template_directory_uri().'/library/images/templatic-wordpress-themes.png" alt="'.__('WordPress Directory Theme','templatic').'" /></a></p>'; ?> </div>
					<!-- .footer-content -->
						<?php
						endif; 
					}	 
				 do_action( 'footer' ); ?>
		  </div>
		</div>
		<!-- .wrap --> 
	  </section>
	  <?php do_action( 'close_footer' );  ?>
	</footer>
	<!-- #footer -->
	<?php } ?>
</div>
<?php do_action( 'after_footer' );
	wp_footer(); 
	do_action('before_body_end',10); 
?>
<style>
	.extra-s select {
		background-color: rgba(255,255,255,0.9);
		width: 100%;
		padding: 12px 5px;
		font-size: 17px;
		height: 100%;
		border: none !important;
		background: url(http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png) no-repeat right;
		-webkit-appearance: none;

	}
</style>
<script>
	jQuery(document).ready(function(){

		var dirImg = jQuery('#directorytab img');
		jQuery('#directorytab').html('');
		jQuery('#directorytab').append(dirImg);
		$( function() {
			$( "#arriving" ).datepicker();
			$( "#departing" ).datepicker();
		} );


		var hostn = window.location.hostname;
		$('#supreme_subscriber_widget-2').prepend('<div class="socialMedia1"><ul id="" class="cnss-social-icon " style="text-align:right;"><li class="Facebook" style=" "><a target="_blank" title="Facebook" href="#"><img src="http://'+ hostn +'/wp-content/uploads/2016/11/facebook-logo.png" border="0" width="32" alt="Facebook" style="margin: 2px; opacity: 1;"></a></li><li class="Twitter" style=" "><a target="_blank" title="Twitter" href="#"><img src="http://'+ hostn +'/wp-content/uploads/2016/11/twitter-logo-silhouette.png" border="0" width="32" alt="Twitter" style="margin: 2px; opacity: 1;"></a></li><li class="Google" style=" "><a target="_blank" title="Google" href="#"><img src="http://'+ hostn +'/wp-content/uploads/2016/11/google-plus.png" border="0" width="32" alt="Google" style="margin: 2px; opacity: 1;"></a></li><li class="Pinterest" style=" "><a target="_blank" title="Pinterest" href="#"><img src="http://'+ hostn +'/wp-content/uploads/2016/11/pinterest.png" border="0" width="32" alt="Pinterest" style="margin: 2px; opacity: 1;"></a></li></ul></div>');
		$('.socialMedia1').next().addClass('newsLetter1');
		$('.tmpl-login').remove();


		$('.slides_container').prepend('    <div class="book-searching">				<div class="book-searching-form">				<div class="row">				<div class="col s12 col m2 extra-s">			<input type="text" placeholder="Hotel or City..." class="hotel_text">				</div>				<div class="col s12 col m2 extra-s">				<label id="calen-label">				<input type="text" id="arriving" placeholder="Arriving" />				</label>				</div>				<div class="col s12 col m2 extra-s">				<label id="calen-label">				<input type="text" id="departing" placeholder="Departing" />				</label>				</div>				<div class="col s12 col m2 extra-s" style="padding:0px 15px !important;">				<select style="display:block;" name="" id="">				<option value="">1 Adult</option>		<option value="">2 Adult</option>		<option value="">3 Adult</option>		<option value="">4 Adult</option>		<option value="">5 Adult</option>		<option value="">6 Adult</option>		<option value="">7 Adult</option>		<option value="">8 Adult</option>		</select>		</div>		<div class="col s12 col m2 extra-s" style="padding:0px 15px !important;">				<select style="display:block;" name="" id="">				<option value="">0 Children</option>		<option value="">1 Children</option>		<option value="">2 Children</option>		<option value="">3 Children</option>		<option value="">4 Children</option>		<option value="">5 Children</option>		<option value="">6 Children</option>		<option value="">7 Children</option>		</select>		<img class="arrow-search" src="http://www.free-icons-download.net/images/left-triangular-arrow-icon-64438.png" alt="">				</div>				<div class="col s12 col m2 extra-s" style="padding:0px !important;">				<a style="color: #fff; height: 100%;   font-size:14px;  padding: 5px 9px; width: 100%;" class="waves-effect waves-light btn black text-white"><i style="margin-right:5px" class="material-icons left">search</i>FIND HOTELS</a>		</div>		</div>		</div>		</div>');


		$( function() {
			$( "#arriving" ).datepicker();
			$( "#departing" ).datepicker();
		} );

	});
</script>
</body></html>