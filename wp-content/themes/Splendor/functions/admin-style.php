<?php 

/* get the color settings from customizer and write in theme_options.css file located in functions */
function directory_hex2rgb($hex='') {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   /*  returns an array with the rgb values */
   return $rgb; 
}


/*
    File contain the code for color options in customizer 
*/

ob_start();
	$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	global $wpdb;
	if(function_exists('supreme_get_setting')){
	
		/* body background color */
		$color1 = supreme_get_setting( 'color_picker_color1' );
		
		/* Primary Color - Black */
		$color2 = supreme_get_setting( 'color_picker_color2' );
		
		/* Body font Color */
		$color3 = supreme_get_setting( 'color_picker_color3' );
		
		/* Heading text color - 1 */
		$color5 = supreme_get_setting( 'color_picker_color5' );
		
		/* Heading text color - 2 */
		$color6 = supreme_get_setting( 'color_picker_color6' );
		
		/* Secondary color - Cream */
		$color7 = supreme_get_setting( 'color_picker_color7' );
		
		/* Meta color  */
		$color8 = supreme_get_setting( 'color_picker_color8' );
		
		/* Primary Box color */
		$color9 = supreme_get_setting( 'color_picker_color9' );
		
		/* Secondary Box color */
		$color10 = supreme_get_setting( 'color_picker_color10' );
		
	}else{
		$supreme_theme_settings = get_option(supreme_prefix().'_theme_settings');
		if(isset($supreme_theme_settings[ 'color_picker_color1' ]) && $supreme_theme_settings[ 'color_picker_color1' ] !=''):
			$color1 = $supreme_theme_settings[ 'color_picker_color1' ];
		else:
			$color1 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color2' ]) && $supreme_theme_settings[ 'color_picker_color2' ] !=''):
			$color2 = $supreme_theme_settings[ 'color_picker_color2' ];
		else:
			$color2 = '';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color3' ]) && $supreme_theme_settings[ 'color_picker_color3' ] !=''):
			$color3 = $supreme_theme_settings[ 'color_picker_color3' ];
		else:
			$color3 ='';
		endif;
			
		if(isset($supreme_theme_settings[ 'color_picker_color5' ]) && $supreme_theme_settings[ 'color_picker_color5' ] !=''):
			$color5 = $supreme_theme_settings[ 'color_picker_color5' ];
		else:
			$color5 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color6' ]) && $supreme_theme_settings[ 'color_picker_color6' ] !=''):
			$color6 = $supreme_theme_settings[ 'color_picker_color6' ];
		else:
			$color6 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color7' ]) && $supreme_theme_settings[ 'color_picker_color7' ] !=''):
			$color7 = $supreme_theme_settings[ 'color_picker_color7' ];
		else:
			$color7 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color8' ]) && $supreme_theme_settings[ 'color_picker_color8' ] !=''):
			$color8 = $supreme_theme_settings[ 'color_picker_color8' ];
		else:
			$color8 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color9' ]) && $supreme_theme_settings[ 'color_picker_color9' ] !=''):
			$color9 = $supreme_theme_settings[ 'color_picker_color9' ];
		else:
			$color9 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color10' ]) && $supreme_theme_settings[ 'color_picker_color10' ] !=''):
			$color10 = $supreme_theme_settings[ 'color_picker_color10' ];
		else:
			$color10 ='';
		endif;
	}

/* Change color of body background */
if($color1 != "#" || $color1 != ""){?>
	
	body,
	.supreme_wrapper,
	#main > .wrap.row,
	#main,
	.wordpress .tabs dd.active a, 
	.wordpress .tabs .tab-title.active a
	{ <?php if(!empty($color1)):?>background-color:<?php echo $color1; ?> !important<?php endif;?> }
	
<?php }













/* Change Primary Background Color */
if($color2 != "#" || $color2 != ""){ ?>


	header, 
	#header,
	.homepage_above_content.fullwidth,
	#footer .footer_top, 
	.footer_top .footer-wrap.row,
	.tevolution-directory .home_page_banner .search_nearby_widget #searchform input[type="submit"],
	.directory_manager_tab .sort_options,
	body .mega-menu ul.mega li ul.sub-menu, 
	.nav_bg .widget-nav-menu ul ul, 
	div#menu-secondary .menu ul ul, 
	div#menu-secondary1 .menu ul ul, 
	div#menu-subsidiary .menu ul ul,
	.hotel-info,
	form#commentform,
	form#commentform textarea,
	body.full-width-map .header_strip,
	.sidebar .templatic-advanced-search,
	#classified-price-range.ui-widget-content, 
	#radius-range.ui-widget-content, 
	#classified-price-range .ui-widget-header, 
	#radius-range .ui-widget-header, 
	#propery-price-range .ui-slider-range,
	#searchform .ui-slider .ui-slider-handle, 
	#propery-price-range .ui-slider-handle, 
	#classified-price-range .ui-slider-handle, 
	#radius-range .ui-slider-handle,
	form#commentform .comment_column2 p input,
	body .ui-datepicker-trigger:hover,
	.submit-progress-steps ul,
	#preview_submit_from_listing .hotel-info,
	#preview_submit_from_listing header, 
	#preview_submit_from_listing #header,
	.middle.tab-bar-section a,
	body .button, body .uploadfilebutton, body a.button, body button, body input[type="button"],
	body input[type="reset"], body input[type="submit"],
	.tab-bar-section.middle{

		<?php if(!empty($color2)):?> background-color:<?php echo $color2;  endif;?>
	}


	.hotel-info .share_link .socialbtn li a:hover,
	#slidersection .rightside .bottom_right ul li a:hover{
		<?php if(!empty($color2)):?>background-color:<?php echo $color2; ?> !important<?php endif;?>
			
	}


	.directory_manager_tab ul.view_mode li a:before,
	.singular-deals .deal_price_link .countdowncontainer span.hurry_text ~ span,
	.post .entry .deals-wrapper .itemsold strong,
	.post .entry .deals-wrapper .deal-price,
	.post .entry .entry-title-wrapper .deal-price,
	.widget_loop_taxonomy.widget_loop_property .type-property .deal-price,
	.list .entry .bottom_line{
		<?php if(!empty($color2)):?> color:<?php echo $color2;  endif;?>	
	}



	.home_page_banner .header-search-icon:after{
		<?php if(!empty($color2)):?>border-right-color:<?php echo $color2; ?> <?php endif;?>
	}

<?php }




/* Body font color */
if($color3 != "#" || $color3 != ""){ ?>




	body,
	a:hover,
	ol li a,
	ul li a,
	.tmpl_classified_seller .tmpl-seller-details p.phone,
	.singular-classified .contact-no,
	.directory-single-page .hentry .entry-header-title .entry-header-custom-wrap p label,
	p.custom_header_field label,
	.listing_custom_field p label,
	.user_dsb_cf span,
	.grid .post .entry .date,
	.grid [class*="post"] .entry .date,
	.post-summery a:hover,
	.entry-meta .category a,
	.entry-meta .post_tag a,
	.tevolution-directory .post-meta a,
	.entry-meta .category,
	.entry-meta .post_tag,
	.post_info_meta,
	h1 a:hover,
	h2 a:hover,
	h3 a:hover,
	h4 a:hover,
	h5 a:hover,
	h6 a:hover,
	.all_category_list_widget .category_list h3 a:hover,
	.listing_post .hentry h2 a:hover,
	.moretag,
	.listing_post_wrapper .post-summery a,
	.rember a:hover,
	.logreg-link:hover,
	#footer .footer_bottom a:hover,
	.entry-meta .category a:hover,
	.entry-meta .post_tag a:hover,
	#tmpl_sign_up .widgets-link:hover,
	.log-in-out a:hover,
	#recentcomments a:hover,
	.tevolution-directory .post-meta a:hover,
	.post_info_meta a:hover,
	.editProfile a:hover,
	#listing_description a:hover,
	.archive-meta a:hover,
	.arclist ul li .arclist_date a:hover,
	h1 a:hover,
	h2 a:hover,
	h3 a:hover,
	h4 a:hover,
	h5 a:hover,
	h6 a:hover,
	body,
	input.input-text,
	input[type="date"],
	input[type="datetime-local"],
	input[type="datetime"],
	input[type="email"],
	input[type="month"],
	input[type="number"],
	input[type="password"],
	input[type="search"],
	input[type="tel"],
	input[type="text"],
	input[type="time"],
	input[type="url"],
	input[type="week"],
	select,
	textarea,
	.button,
	.uploadfilebutton,
	a.button,
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	body #content .claim-post-wraper ul li a,
	#ui-datepicker-div .ui-widget-header,
	body .ui-widget,
	body .ui-widget-content,
	body.tevolution-directory .get_direction #from-input,
	body.tevolution-directory .ui-widget-header li a,
	.event_type li a,
	body .author_custom_post_wrapper ul li a,
	.gm-style,
	a:hover,
	ol li a,
	ul li a,
	.singular-classified .contact-no,
	.directory-single-page .hentry .entry-header-title .entry-header-custom-wrap p label,
	p.custom_header_field label,
	.listing_custom_field p label,
	body #loop_listing_archive .post .entry p, 
	body #loop_listing_taxonomy .post .entry p, 
	body #tmpl-search-results.list .hentry p, 
	.entry-details p,
	.widget-title .more:hover,
	.widget-title .more:hover:before,
	.sidebar a:hover,
	.sidebar .widget .categories li a:hover:before,
	#footer .subscribe .subscriber_container input[type="email"],
	#footer .subscribe .subscriber_container input[type="month"],
	#footer .subscribe .subscriber_container input[type="number"],
	#footer .subscribe .subscriber_container input[type="password"],
	#footer .subscribe .subscriber_container input[type="text"],
	#footer .subscribe .subscriber_container input[type="search"],
	#footer .subscribe .subscriber_container input[type="tel"],
	#footer .subscribe .subscriber_container input[type="time"],
	#footer .subscribe .subscriber_container input[type="url"],
	#footer .subscribe .subscriber_container input[type="week"],
	#footer .subscribe .subscriber_container input[type="datetime"],
	#footer .subscribe .subscriber_container input[type="date"],
	#footer .subscribe .subscriber_container input[type="datetime-local"],
	#sub_listing_categories ul li a,
	.comment-pagination .page-numbers strong,
	.pagination .page-numbers strong,
	strong.prev,
	strong.next,
	.expand.page-numbers,
	a.page-numbers.first,
	a.page-numbers.last,
	span.page-numbers.dots,
	.loop-nav span.next,
	.loop-nav span.previous,
	body .pos_navigation .post_left a,
	body .pos_navigation .post_right a,
	.hotel-info p a,
	.hotel-info .send_btns li a,
	#content .pos_navigation a,
	form#commentform textarea,
	
	form#commentform .templatic_rating .rate-comment,
	form#commentform .comment_column2 p input,
	.comment-meta a:hover,
	.list [class*="post"] p.phone, 
	.grid [class*="post"] p.phone,
	.post .entry p, 
	.list .hentry p, 
	.entry-details p,
	.arclist ul li .arclist_date, 
   	.arclist ul li .arclist_date a,
   	.ui-widget-content.ui-widget-content,
   	.submit-progress-steps ul li span,
   	.map_rating span a,
   	#preview_submit_from_listing .rate_visit .view_counter,
   	.favourite a::before,
   	.singular-jobs .entry-header .entry-header-title .entry-header-custom-wrap .website .frontend_website:hover span:before,
   	.singular-jobs .entry-header .entry-header-title .entry-header-custom-wrap .website .frontend_website:hover,
   	.singular-jobs .entry-header-title .entry-header-custom-wrap p.website:hover,
   	.singular-jobs .entry-header-title .entry-header-custom-wrap p.website span:hover,
   	.singular-jobs .entry-header .entry-header-title .entry-header-custom-wrap .entry_address .frontend_address::before,
   	.singular-jobs .entry-header .entry-header-title .entry-header-custom-wrap .entry_job_type .frontend_job_type::before,
   	.post .rev_pin ul li.review a:before{
		<?php if(!empty($color3)):?> color:<?php echo $color3;  endif;?>
	}







<?php }


/* Heading text color - 1 */
if($color5 != "#" || $color5 != ""){?>
	


	.inner-wrap h3.widget-title,
	.tevolution-directory .search_nearby_widget #searchform .search_range label,
	h2.custom_field_headding,
	#content .bottom_line .i_category a,
	#comments-number, 
	#reply-title,
	.realated_post h3,
	.comment-author cite,
	.post .entry .property-title .property-price, 
	.post .entry .entry-title-wrapper .property-price, 
	.widget_loop_taxonomy.widget_loop_property .type-property .property-price,
	.arclist ul li a,
	#map_canvas .google-map-info .map-inner-wrapper .map-item-info h6,
	#map_canvas .google-map-info .map-inner-wrapper .map-item-info h6 a{
		<?php if(!empty($color5)):?> color:<?php echo $color5;  endif;?>
	}


	body .button:hover, body .uploadfilebutton:hover,
	body a.button:hover, body button:hover, body input[type="button"]:hover,
	body input[type="reset"]:hover, body input[type="submit"]:hover{
		<?php if(!empty($color5)):?> background-color:<?php echo $color5;  endif;?>
	}



<?php }


/* Heading text color - 2  */
if($color6 != "#" || $color6 != ""){?>



	.button,
	.uploadfilebutton,
	a.button,
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.widget-title .more,
	.tmpl_classified_seller .seller-top_wrapper .tmpl-seller-detail-rt .button,
	.singular-classified #contact_seller_id,
	#searchform input[type="submit"],
	.upload,
	body.woocommerce #content input.button,
	body.woocommerce #content input.button.alt,
	body.woocommerce #respond input#submit,
	body.woocommerce #respond input#submit.alt,
	body.woocommerce .widget_layered_nav_filters ul li a,
	body.woocommerce a.button,
	body.woocommerce a.button.alt,
	body.woocommerce button.button,
	body.woocommerce button.button.alt,
	body.woocommerce input.button,
	body.woocommerce input.button.alt,
	body.woocommerce-page #content input.button,
	body.woocommerce-page #content input.button.alt,
	body.woocommerce-page #respond input#submit,
	body.woocommerce-page #respond input#submit.alt,
	body.woocommerce-page .widget_layered_nav_filters ul li a,
	body.woocommerce-page a.button,
	body.woocommerce-page a.button.alt,
	body.woocommerce-page button.button,
	body.woocommerce-page button.button.alt,
	body.woocommerce-page input.button,
	body.woocommerce-page input.button.alt,
	div.woocommerce form.track_order input.button,
	.heading-inner .more,
	#loop_jobs_taxonomy .post a,
	.cancel-btn,
	a.cancel-btn,
	input.cancel-btn,
	.secondray-button,
	.uploadfilebutton.secondray-button,
	a.button.secondray-button,
	button.secondray-button,
	input.secondray-button[type="button"],
	input.secondray-button[type="reset"],
	input.secondray-button[type="submit"],
	.inner-wrap .templatic-advanced-search h3.widget-title,
	.inner-wrap .homepage_above_content.fullwidth h3.widget-title,
	.inner-wrap .homepage_content_five.fullwidth h3.widget-title,
	.inner-wrap .above_homepage_footer.fullwidth h3.widget-title,
	.mega-menu ul.mega li .sub li.mega-hdr a.mega-hdr-a:hover,
	body .mega-menu ul.mega li ul.sub-menu ul li a:hover,
	body .mega-menu ul.mega li a:hover,
	body .mega-menu ul.mega li.current-menu-item a,
	body .mega-menu ul.mega li.current-page-item a,
	body .mega-menu ul.mega li:hover > a,
	body .nav_bg .widget-nav-menu li a:hover,
	body div#menu-secondary .menu li a:hover,
	body div#menu-secondary1 .menu li a:hover,
	body div#menu-subsidiary .menu li a:hover,
	.nav_bg .widget-nav-menu li a:hover,
	div#menu-secondary .menu li a:hover,
	div#menu-secondary1 .menu li a:hover,
	div#menu-subsidiary .menu li a:hover,
	div#menu-secondary .menu li a:hover,
	div#menu-secondary .menu li.current-menu-item > a,
	div#menu-secondary .menu li:hover > a,
	div#menu-secondary1 .menu li a:hover,
	div#menu-secondary1 .menu li.current-menu-item > a,
	div#menu-secondary1 .menu li:hover > a,
	div#menu-subsidiary .menu li.current-menu-item > a,
	body .mega-menu ul.mega li:hover > a,
	body .mega-menu ul.mega li.current-menu-item > a,
	body #menu-secondary .menu li[class*="current-menu"] > a,
	body #menu_secondary_mega_menu .mega li[class*="current-menu"] > a,
	body .menu li[class*="current-menu"] > a,
	.sub-menu li[class*="current-menu"] > a,
	.primary_menu li[class*="current-menu"] > a,
	.home_page_banner h3.widget-title,
	body .ui-widget-content.ui-autocomplete.ui-front li.instant_search:hover,
	body .ui-widget-content.ui-autocomplete.ui-front li.instant_search:hover span.type,
	.home_page_banner .header-search-icon:before,
	.topcities .cities_list .city_img .city-detail span.cityname,
	.homepage_content_two.fullwidth .templatic-advanced-search #searchform .form_row input,
	.homepage_content_two.fullwidth .templatic-advanced-search #searchform .form_row .select-wrap span.select,
	.sidebar .templatic-advanced-search .form_row input[type="date"],
	.sidebar .templatic-advanced-search .form_row input[type="datetime-local"],
	.sidebar .templatic-advanced-search .form_row input[type="datetime"],
	.sidebar .templatic-advanced-search .form_row input[type="email"],
	.sidebar .templatic-advanced-search .form_row input[type="file"],
	.sidebar .templatic-advanced-search .form_row input[type="month"],
	.sidebar .templatic-advanced-search .form_row input[type="number"],
	.sidebar .templatic-advanced-search .form_row input[type="password"],
	.sidebar .templatic-advanced-search .form_row input[type="search"],
	.sidebar .templatic-advanced-search .form_row input[type="tel"],
	.sidebar .templatic-advanced-search .form_row input[type="text"],
	.sidebar .templatic-advanced-search .form_row input[type="url"],
	.sidebar .templatic-advanced-search .form_row select,
	.sidebar .templatic-advanced-search .form_row textarea,
	.sidebar .templatic-advanced-search input[type="time"],
	.sidebar .templatic-advanced-search input[type="week"],
	.sidebar .templatic-advanced-search .select-wrap span.select,
	.sidebar .templatic-advanced-search .form_row label,
	.homepage_content_two.fullwidth .templatic-advanced-search #searchform .form_row label,
	.list .featured_tag, 
	.grid .featured_tag,
	.postpagination a.active, 
	.postpagination a:hover,
	.homepage_content_five.fullwidth .pricing-block-wrap .pricing-wrap .pricing-inner-wrap h2,
	#sub_listing_categories ul li a:hover,
	div.event_manager_tab ul.view_mode li a.active:before,
   	div.directory_manager_tab ul.view_mode li a.active:before,
   	div.directory_manager_tab ul.view_mode li a:hover:before,
   	div.event_manager_tab ul.view_mode li a.hover:before,
   	.hotel-info ul li label,
	.hotel-info p.custom_header_field label,
	.hotel-info .claim_ownership a,
	.hotel-info .share_link .socialbtn li a i,
	.hotel-info .share_link label,
	.sidebar .direction .google-map-directory a.large_map:hover,
	.hide_map_direction i,
	.sidebar .agent-social-networks a:hover,
	.tmpl-agent-details .enquiry-list .small_btn,
	body .social-media-share li .facebook_share a .share,
	body .social-media-share li .twitter_share a .share,
	body .social-media-share li .googleplus_share a .share,
	body .social-media-share li .pinit_share a .share,
	.btn-primary,
	.modal-footer .btn,
	.toggle_handler #directorytab .fa-caret-down:before,
	.primary_menu_wrapper .submit-small-button.button,
    body .mega-menu ul.mega li a, .nav_bg .widget-nav-menu li a, div#menu-secondary .menu li a, div#menu-secondary1 .menu li a, div#menu-subsidiary .menu li a,
    .toggle_handler #directorytab,
    div#menu-primary .menu li a{
		<?php if(!empty($color6)):?> color:<?php echo $color6;  endif;?>
	}




	#listing_coupons ul li .cpn_optopn a,
	body .social-media-share li a .count,
	#preview_submit_from_listing h1.entry-title{
		<?php if(!empty($color6)):?> color:<?php echo $color6; ?> !important<?php endif;?>
	}


	.sidebar .templatic-advanced-search .form_row .select-wrap select,
	.tev_sorting_option .tev_options_sel,
	.directory_manager_tab ul.view_mode li a:before
	{
		<?php if(!empty($color6)):?> background-color:<?php echo $color6;  endif;?>
	}




	.list .featured_tag, 
	.grid .featured_tag,
	.list .featured_tag:before, 
	.grid .featured_tag:before,
	{
		<?php if(!empty($color6)):?> border-color:<?php echo $color6;  endif;?>
	}



	.tab-bar .menu-icon span{
		<?php if(!empty($color6)):?> box-shadow: 0 0 0 1px <?php echo $color6;  ?>, 0 7px 0 1px <?php echo $color6; ?>, 0 14px 0 1px <?php echo $color6;  endif;?>
	}





<?php }


/* Secondary color - Cream */
if($color7 != "#" || $color7 != ""){?>



	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	h1 a,
	h2 a,
	h3 a,
	h4 a,
	h5 a,
	h6 a,
	.all_category_list_widget .category_list h3 a,
	.supreme_wrapper .fav a.addtofav:hover,
	.supreme_wrapper .fav a.removefromfav:hover,
	#content .people_info h3 a,
	.error_404 h4,
	.ui-widget-content a,
	.entry-meta .category a:hover,
	a,
	#tev_sub_categories ul li a,
	#sub_event_categories ul li a,
	#sub_listing_categories ul li a,
	.comment-meta a:hover,
	ol li a:hover,
	ul li a:hover,
	.widget h3, 
	.widget-search .widget-title, 
	.widget-title, 
	.widget.title,
	#site-description,
	div#menu-primary .menu li:hover a,
	.topcities .cities_list .city_img .city-detail span.cityname a:hover,
	.sidebar .templatic-advanced-search h3.widget-title,
	.widget-title .more,
	.widget-title .more:before,
	.single_rating i.rating-on, 
	.comments_rating i.rating-on, 
	.rating i.rating-on,
	.amenitie label,
	.post .rev_pin ul li a:hover::before,
	.sidebar a,
	.sidebar .widget.categories li a:before,
	#footer .pages ul li a:before,
	.homepage_content_five.fullwidth .pricing-block-wrap .pricing-wrap .pricing-inner-wrap .price-block,
	.above_homepage_footer.fullwidth .testimonials .flex-direction-nav li a:hover,
	.above_homepage_footer.fullwidth .testimonials .flex-viewport .slides li .testi_info cite,
	#footer .pages ul li a:hover:before,
	#footer .pages ul li a:hover,
	#footer .footer_bottom a:hover,
	#breadcrumb .trail-end,
	.breadcrumb .trail-end,
	#breadcrumb a:hover,
	.breadcrumb a:hover,
	.author-page .social_media ul li a:hover i, 
	.user .social_media ul li a:hover i,
	.singular-listing #main .wrap .title-section .entry-header .entry-header-title .fa-stack .fa-stack-2x,
	.hotel-info .send_btns li a:hover,
	.hotel-info .claim_ownership a:hover,
	.hotel-info .claim_ownership .fa-stack .fa-certificate,
	.sidebar .direction .google-map-directory a.large_map,
	.tmpl-agent-details .enquiry-list .small_btn:hover,
	.wordpress .tabs dd.active a, 
	.wordpress .tabs .tab-title.active a,
	#content .bottom_line .i_category a:hover,
	.comment-meta a,
	#respond #cancel-comment-reply-link,
	.singular-property .supreme_wrapper .property .entry-header-right .property-price,
	body.full-width-map div#menu-primary .menu li a:hover,
	.byline a:hover, 
	.entry-meta a:hover,
	#post-listing .complete .step-heading,
	.accordion .accordion-navigation > a, 
   	.accordion dd > a,
   	.arclist h2,
   	.arclist ul li a:hover,
   	.arclist ul li .arclist_date a:hover,
   	.btn-primary:hover,
   	#map_canvas .google-map-info .map-inner-wrapper .map-item-info h6:hover,
	#map_canvas .google-map-info .map-inner-wrapper .map-item-info h6 a:hover,
	.map_rating span a:hover,
	.rating-on,
	.singular-jobs .entry-header .entry-header-title .entry-header-custom-wrap .website .frontend_website span:before,
   	.singular-jobs .entry-header .entry-header-title .entry-header-custom-wrap .website .frontend_website,
   	.singular-jobs .entry-header-title .entry-header-custom-wrap p.website,
   	.singular-jobs .entry-header-title .entry-header-custom-wrap p.website span,
	#loop_jobs_taxonomy .post a:hover,
	#loop_jobs_taxonomy .post:hover .entry-title a{
		<?php if(!empty($color7)):?> color:<?php echo $color7;  endif;?>
	}


	.hotel-info .share_link .socialbtn li a:hover,
	#content .pos_navigation a:hover,
	.footer-social-icon ul li a:hover,
	.mobile-view a, .mobile-view ol li a, .mobile-view ul li a, .mobile-view .byline a, .mobile-view #tev_sub_categories ul li a,
	.mobile-view #sub_event_categories ul li a, .mobile-view #sub_listing_categories ul li a,
	.mobile-view .templatic_twitter_widget .twit_time, .mobile-view .mobile-view .list .entry h2.entry-title,
	.mobile-view .mobile-view .grid .entry h2.entry-title, .mobile-view .mobile-view .entry h2.entry-title,
	.mobile-view .mobile-view .list .entry h2.entry-title a, .mobile-view .grid .entry h2.entry-title a,
	.mobile-view .entry h2.entry-title a, .mobile-view .mobile-view #content .peopleinfo-wrap h3 .fl a,
	.mobile-view .all_category_list_widget .category_list h3 a:hover, .mobile-view .all_category_list_widget .category_list ul li a{
		<?php if(!empty($color7)):?> color:<?php echo $color7; ?> !important<?php endif;?>
	}





	.button,
	.uploadfilebutton,
	a.button,
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	
	.tmpl_classified_seller .seller-top_wrapper .tmpl-seller-detail-rt .button,
	.singular-classified #contact_seller_id,
	#searchform input[type="submit"],
	.upload,
	body.woocommerce #content input.button,
	body.woocommerce #content input.button.alt,
	body.woocommerce #respond input#submit,
	body.woocommerce #respond input#submit.alt,
	body.woocommerce .widget_layered_nav_filters ul li a,
	body.woocommerce a.button,
	body.woocommerce a.button.alt,
	body.woocommerce button.button,
	body.woocommerce button.button.alt,
	body.woocommerce input.button,
	body.woocommerce input.button.alt,
	body.woocommerce-page #content input.button,
	body.woocommerce-page #content input.button.alt,
	body.woocommerce-page #respond input#submit,
	body.woocommerce-page #respond input#submit.alt,
	body.woocommerce-page .widget_layered_nav_filters ul li a,
	body.woocommerce-page a.button,
	body.woocommerce-page a.button.alt,
	body.woocommerce-page button.button,
	body.woocommerce-page button.button.alt,
	body.woocommerce-page input.button,
	body.woocommerce-page input.button.alt,
	div.woocommerce form.track_order input.button,
	.heading-inner .more,
	.button:hover,
	.uploadfilebutton:hover,
	a.button:hover,
	button:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	input[type="submit"]:hover,
	
	.singular-classified #contact_seller_id:hover,
	.tmpl_classified_seller .seller-top_wrapper .tmpl-seller-detail-rt .button:hover,
	.heading-inner a.more:hover,
	.homepage_content_two.fullwidth .templatic-advanced-search #searchform input[type="submit"]:hover,
	.cancel-btn,
	a.cancel-btn,
	input.cancel-btn,
	.secondray-button,
	.uploadfilebutton.secondray-button,
	a.button.secondray-button,
	button.secondray-button,
	input.secondray-button[type="button"],
	input.secondray-button[type="reset"],
	input.secondray-button[type="submit"],
	.cancel-btn:hover,
	a.cancel-btn:hover,
	input.cancel-btn:hover,
	.secondray-button:hover,
	.uploadfilebutton.secondray-button:hover,
	a.button.secondray-button:hover,
	button.secondray-button:hover,
	input.secondray-button[type="button"]:hover,
	input.secondray-button[type="reset"]:hover,
	input.secondray-button[type="submit"]:hover,
	a.current.page-numbers, 
	span.current.page-numbers strong, 
	.page-numbers:hover strong,
	body .secondary_btn:hover, 
	.comment-pagination .page-numbers:hover strong, 
	strong.prev:hover, 
	strong.next:hover, 
	.loop-nav span.next:hover, 
	.loop-nav span.previous:hover, 
	.pagination .page-numbers:hover strong, 
	body .pos_navigation .post_left a:hover, 
	body .pos_navigation .post_right a:hover, 
	a.current.page-numbers, 
	a.page-numbers[title~="Last"]:hover, 
	a.page-numbers[title~="First"]:hover,
	#content input.button:hover,
	#searchform input[type="submit"]:hover,
	.upload:hover,
	body.woocommerce #content input.button.alt:hover,
	body.woocommerce #content input.button:hover,
	body.woocommerce #respond input#submit.alt:hover,
	body.woocommerce #respond input#submit:hover,
	body.woocommerce .widget_layered_nav_filters ul li a:hover,
	body.woocommerce a.button.alt:hover,
	body.woocommerce a.button:hover,
	body.woocommerce button.button.alt:hover,
	body.woocommerce button.button:hover,
	body.woocommerce input.button.alt:hover,
	body.woocommerce input.button:hover,
	body.woocommerce-page #content input.button.alt:hover,
	body.woocommerce-page #content input.button:hover,
	body.woocommerce-page #respond input#submit.alt:hover,
	body.woocommerce-page #respond input#submit:hover,
	body.woocommerce-page .widget_layered_nav_filters ul li a:hover,
	body.woocommerce-page a.button.alt:hover,
	body.woocommerce-page a.button:hover,
	body.woocommerce-page button.button.alt:hover,
	body.woocommerce-page button.button:hover,
	body.woocommerce-page input.button.alt:hover,
	body.woocommerce-page input.button:hover,
	div.woocommerce form.track_order input.button:hover,
	.left-off-canvas-menu,
	.tevolution-directory .home_page_banner .search_nearby_widget #searchform input[type="submit"]:hover,
	.list .featured_tag, 
	.grid .featured_tag,
	.list .featured_tag:before, 
	.grid .featured_tag:before,
	.postpagination a.active, 
	.postpagination a:hover,
	.above_homepage_footer.fullwidth .testimonials .flex-direction-nav li a,
	#sub_listing_categories ul li a:hover,
	div.event_manager_tab ul.view_mode li a.active:before,
   	div.directory_manager_tab ul.view_mode li a.active:before,
   	div.directory_manager_tab ul.view_mode li a:hover:before,
   	div.event_manager_tab ul.view_mode li a.hover:before,
   	.sort_order_alphabetical ul li a:hover, 
   	.sort_order_alphabetical ul li.active a, 
   	.sort_order_alphabetical ul li.nav-author-post-tab-active a,
   	body .ui-widget-content.ui-autocomplete.ui-front li.instant_search:hover, 
	body .ui-widget-content.ui-autocomplete.ui-front li.instant_search:hover span.type,
	.hotel-info .share_link,
	.sidebar .direction .google-map-directory a.large_map:hover,
	.hide_map_direction i,
	.sidebar .agent-social-networks a:hover,
	.tmpl-agent-details .enquiry-list .small_btn,
	#silde_gallery .flex-direction-nav li a,
	#listing_coupons ul li .cpn_optopn a,
	.widget #wp-calendar caption,
	.list .post .entry .date, 
   	.list [class*="post"] .entry .date,
   	#content .claim-post-wraper ul li a:hover,
   	.post .entry .property-title .property-price .prop-price,
	.post .entry .entry-title-wrapper .property-price .prop-price,
	.widget_loop_taxonomy.widget_loop_property .type-property .property-price .prop-price,
	.singular-property .supreme_wrapper .entry-header-custom-wrap ul li i,
	.format-aside::before,
	.format-audio::before,
	.format-chat::before,
	.format-gallery::before,
	.format-image::before,
	.format-link::before,
	.format-quote::before,
	.format-status::before,
	.format-video::before,
	body .ui-datepicker-trigger,
	.btn-primary,
	.modal-footer .btn,
	.btn-info,
	.submit-progress-steps ul li span.active,
	.tab-bar .menu-icon,
	.left-off-canvas-menu,
	body.mobile-view .right-medium > .templatic_text a.submit-small-button{
		<?php if(!empty($color7)):?> background-color:<?php echo $color7;  endif;?>
	}

	.secondray-button:hover,
	input.secondray-button[type="button"]:hover,
	.ui-widget-content.ui-slider-horizontal{
		<?php if(!empty($color7)):?>background-color:<?php echo $color7; ?> !important<?php endif;?>
	}



	input.input-text:focus,
	input[type="date"]:focus,
	input[type="datetime-local"]:focus,
	input[type="datetime"]:focus,
	input[type="email"]:focus,
	input[type="month"]:focus,
	input[type="number"]:focus,
	input[type="password"]:focus,
	input[type="search"]:focus,
	input[type="tel"]:focus,
	input[type="text"]:focus,
	input[type="time"]:focus,
	input[type="url"]:focus,
	input[type="week"]:focus,
	select:focus,
	textarea:focus,
	.postpagination a.active, 
	.postpagination a:hover,
	#sub_listing_categories ul li a:hover,
	.author-page .social_media ul li a:hover i, 
	.user .social_media ul li a:hover i,
	a.page-numbers[title~="Last"]:hover,
	.pagination .next.page-numbers:hover,
	.hotel-info .share_link .socialbtn li a:hover,
	.sidebar .direction .google-map-directory a.large_map,
	.sidebar .direction .google-map-directory a.large_map:hover,
	.sidebar .agent-social-networks a:hover,
	table.calendar_widget td.date_n div span.calendar_tooltip{
		<?php if(!empty($color7)):?> border-color:<?php echo $color7;  endif;?>
	}



	.submit-progress-steps ul li span.active::after{
		<?php if(!empty($color7)):?> border-left-color:<?php echo $color7;  endif;?>
	}







	body .mega-menu ul.mega > li a:hover, 
	body .mega-menu ul.mega > li.current-menu-item a, 
	body .mega-menu ul.mega > li.current-page-item a, 
	body .mega-menu ul.mega > li:hover a, 
	body .nav_bg .widget-nav-menu > li a:hover, 
	body div#menu-secondary .menu > li a:hover, 
	body div#menu-secondary1 .menu > li a:hover, 
	body div#menu-subsidiary .menu > li a:hover,
	.sub-menu > li a:hover,
	body .mega-menu ul.mega li a:hover, 
	body .mega-menu ul.mega li.current-menu-item a, 
	body .mega-menu ul.mega li.current-page-item a, 
	body .mega-menu ul.mega li:hover a, 
	body .nav_bg .widget-nav-menu li a:hover, 
	body div#menu-secondary .menu li a:hover, 
	body div#menu-secondary1 .menu li a:hover, 
	body div#menu-subsidiary .menu li a:hover,
	body .mega-menu ul.mega li a:hover,
	body .mega-menu ul.mega li.current-menu-item a,
	body .mega-menu ul.mega li.current-page-item a,
	body .mega-menu ul.mega li:hover > a,
	body .nav_bg .widget-nav-menu li a:hover,
	body div#menu-secondary .menu li a:hover,
	body div#menu-secondary1 .menu li a:hover,
	body div#menu-subsidiary .menu li a:hover,
	.nav_bg .widget-nav-menu li a:hover,
	div#menu-secondary .menu li a:hover,
	div#menu-secondary1 .menu li a:hover,
	div#menu-subsidiary .menu li a:hover,
	div#menu-secondary .menu li a:hover,
	div#menu-secondary .menu li.current-menu-item > a,
	div#menu-secondary .menu li:hover > a,
	div#menu-secondary1 .menu li a:hover,
	div#menu-secondary1 .menu li.current-menu-item > a,
	div#menu-secondary1 .menu li:hover > a,
	div#menu-subsidiary .menu li.current-menu-item > a,
	body .mega-menu ul.mega li:hover > a,
	body .mega-menu ul.mega li.current-menu-item > a,
	body #menu-secondary .menu li[class*="current-menu"] > a,
	body #menu_secondary_mega_menu .mega li[class*="current-menu"] > a,
	body .menu li[class*="current-menu"] > a{
		<?php if(!empty($color7)):?> border-bottom-color:<?php echo $color7;  endif;?>
	}



	.home_page_banner .header-search-icon.sub-hover:after{
		<?php if(!empty($color7)):?> border-right-color:<?php echo $color7;  endif;?>	
	}
















<?php }



/* Meta color */
if($color8 != "#" || $color8 != ""){?>
	


	.author_image_date .published .comment-date,
	.post .entry .deals-wrapper .deal-price > div .forlabel,
	.singular-deals .deal_price_link .countdowncontainer span.hurry_text,
	.singular-deals .deal_price_link ul.deal-price,
	#slidersection .rightside .bottom_right ul li a,
	.post .entry .deals-wrapper .itemsold{
		<?php if(!empty($color8)):?> color:<?php echo $color8;  endif;?>
	}



<?php }

/* Primary Box color */
if($color9 != "#" || $color9 != ""){?>



	.homepage_content_two.fullwidth,
	.above_homepage_footer.fullwidth,
	#footer .footer_bottom,

	.button:hover,
	.uploadfilebutton:hover,
	a.button:hover,
	button:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	input[type="submit"]:hover,
	
	.singular-classified #contact_seller_id:hover,
	.tmpl_classified_seller .seller-top_wrapper .tmpl-seller-detail-rt .button:hover,
	.heading-inner a.more:hover,
	.homepage_content_two.fullwidth .templatic-advanced-search #searchform input[type="submit"]:hover{
		<?php if(!empty($color9)):?> background-color:<?php echo $color9;  endif;?>
	}


	.above_homepage_footer.fullwidth .testimonials .flex-viewport .slides li .testi_info img{
		<?php if(!empty($color9)):?> border-color:<?php echo $color9;  endif;?>
	}

	.button:hover,
	.uploadfilebutton:hover,
	a.button:hover,
	button:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	input[type="submit"]:hover,
	.widget-title .more:hover,
	.singular-classified #contact_seller_id:hover,
	.tmpl_classified_seller .seller-top_wrapper .tmpl-seller-detail-rt .button:hover,
	.heading-inner a.more:hover,
	.homepage_content_two.fullwidth .templatic-advanced-search #searchform input[type="submit"]:hover {
		box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1);
	}



<?php }


/* Secondary Box color */
if($color10 != "#" || $color10 != ""){?>
	

	.homepage_content_five.fullwidth{
		<?php if(!empty($color10)):?> background-color:<?php echo $color10;  endif;?>
	}



<?php }

$color_data = ob_get_contents();
ob_clean();
if(isset($color_data) && $color_data !=''){
	/* put data to css file */
    file_put_contents(trailingslashit(get_template_directory())."css/admin_style.css" , $color_data); 
}
?>