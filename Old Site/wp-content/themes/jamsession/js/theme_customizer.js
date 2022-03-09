/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {
	'use strict';
	//Update logo text color in real time...
	wp.customize( 'jamsession_options[logo_textcolor]', function( value ) {
		value.bind( function( newval ) {
			$('#logo a').css('color', newval );
		} );
	} );
	
	//Update logo bg color in real time...
	wp.customize( 'jamsession_options[logo_bgcolor]', function( value ) {
		'use strict';
		value.bind( function( newval ) {
			if ( false == wp.customize.instance('jamsession_options[logo_transparent_bgc]').get())
			{
				$('#logo').css('background-color', hexToRGBA(newval, '0.9') );
			}
		} );
	} );

	//Update transparent bgc for logo in real time...
	wp.customize( 'jamsession_options[logo_transparent_bgc]', function( value ) {
		'use strict';
		value.bind( function( newval ) {

			if (true == newval)
			{
				$('#logo').css('background-color', 'transparent' );
				$('#logo').css('outline', '0' );
			}
			else
			{
				$('#logo').css('background-color', wp.customize.instance('jamsession_options[logo_bgcolor]').get());
			}
		} );
	});
	

	/********************************  MENU BAR ***********************************/
	//Update transparent menu bar in real time...
	wp.customize( 'jamsession_options[transparent_menu]', function( value ) {
		'use strict';
		value.bind( function( newval ) {

			if (true == newval)
			{
				$('#menu_navigation').css('background-color', 'transparent' );
				$('#main_menu').css('background-color', 'transparent' );
				if ( $( ".menu" ).length > 0 )
				{
					$('.menu').css('background-color', 'transparent' );
				}
				$('#search_blog').css('background-color', 'transparent' );
				$('#search_blog').find('span').css('background-color', 'transparent' );
			}
			else
			{
				/* full width menu */
				if ( 'full' == wp.customize.instance('jamsession_options[menu_width]').get())
				{
					$('#menu_navigation').css('background-color', hexToRGBA(wp.customize.instance('jamsession_options[menu_color]').get(), '0.9'));
					$('#main_menu').css('background-color', 'transparent');
					if ( $( ".menu" ).length > 0 )
					{
						$('.menu').css('background-color', 'transparent');
					}
					$('#search_blog').css('background-color', 'transparent');
				}
				else
				{
					/* boxed width menu*/
					$('#main_menu').css('background-color', hexToRGBA(wp.customize.instance('jamsession_options[menu_color]').get(), '0.9') );
					if ( !($( "#main_menu" ).length) )
					{
						$('.menu').css('background-color', wp.customize.instance('jamsession_options[menu_color]').get() );
					}
					$('#search_blog').css('background-color', hexToRGBA(wp.customize.instance('jamsession_options[menu_color]').get(), '0.9') );
					$('#search_blog').find('span').css('background-color', '#252A2F' );
				}
			}
		} );
	} );		
	
	//Update menu bar color in real time...
	wp.customize( 'jamsession_options[menu_color]', function( value ) {
		'use strict';
		value.bind( function( newval ) {

			if ( false == wp.customize.instance('jamsession_options[transparent_menu]').get())
			{
				if ( 'full' == wp.customize.instance('jamsession_options[menu_width]').get())
				{
					$('#menu_navigation').css('background-color', hexToRGBA(newval, '0.9'));
					$('#main_menu').css('background-color', 'transparent');
					if ( !($( "#main_menu" ).length) )
					{
						$('.menu').css('background-color', 'transparent');
					}
					$('#search_blog').css('background-color', 'transparent');
				}
				else
				{
					$('#menu_navigation').css('background-color', 'transparent');
					$('#main_menu').css('background-color', hexToRGBA(newval, '0.9'));
					if ( !($( "#main_menu" ).length) )
					{
						$('.menu').css('background-color', hexToRGBA(newval, '0.9'));
					}
					
					$('#search_blog').css('background-color', hexToRGBA(newval, '0.9'));
				}
			}
			
			$('#news_badge').css('background-color', hexToRGBA(newval, '0.9'));
			$('#front_page_news_bar').css('background-color', hexToRGBA(newval, '0.9'));
			
			$('#main_menu ul ul ').css('background-color', hexToRGBA(newval, '0.9'));
			if ( !($( "#main_menu" ).length) )
			{
				$('.menu ul ul ').css('background-color', hexToRGBA(newval, '0.9'));
			}
			
			$('#main_menu').find('ul').find('li').hover( function()
				{
					/*hover in*/
					$(this).css('background-color', hexToRGBA(newval, '0.9'));
				},
				function ()
				{
					/*hover out*/
					$(this).css('background-color', 'transparent');
				}
			);
			
			if ( !($( "#main_menu" ).length) )
			{
				$('.menu').find('ul').find('li').hover( function()
					{
						/*hover in*/
						$(this).css('background-color', hexToRGBA(newval, '0.9'));
					},
					function ()
					{
						/*hover out*/
						$(this).css('background-color', 'transparent');
					}
				);
			}
			
			$('#main_menu').find('ul').find('ul').find('li').hover( function()
					{$(this).css('background-color', 'transparent');},
					function ()
					{$(this).css('background-color', 'transparent');}
			);
			
			if ( !($( "#main_menu" ).length) )
			{
				$('.menu').find('ul').find('ul').find('li').hover( function()
						{$(this).css('background-color', 'transparent');},
						function ()
						{$(this).css('background-color', 'transparent');}
				);
			}				
			
			$('#commentform input[type="submit"] ').css('background-color', newval);
			$('.copy').css('color', newval);
			
			$('#commentform input[type="submit"]').hover(function()
			{$(this).css('background-color', wp.customize.instance('jamsession_options[second_color]').get());},
			function(){$(this).css('background-color', newval)}
			);
			
			$(".use_mobile").css('background-color', hexToRGBA(newval, '0.9'));
			
		} );
	} );
	
	//Update menu bar width in real time...
	wp.customize( 'jamsession_options[menu_width]', function( value ) {
		'use strict';
		value.bind( function( newval ) {
		
			if ( false == wp.customize.instance('jamsession_options[transparent_menu]').get())
			{
				if ('boxed' == newval)
				{
					$('#menu_navigation').css('background-color', 'transparent');
					$('#main_menu').css('background-color', hexToRGBA(wp.customize.instance('jamsession_options[menu_color]').get(), '0.9'));
					if ( !($( "#main_menu" ).length) )
					{
						$('.menu').css('background-color', hexToRGBA(wp.customize.instance('jamsession_options[menu_color]').get(), '0.9'));
					}
					
					$('#search_blog').css('background-color', hexToRGBA(wp.customize.instance('jamsession_options[menu_color]').get(), '0.9'));
				}
				else
				{
					/*full width*/
					$('#menu_navigation').css('background-color', hexToRGBA(wp.customize.instance('jamsession_options[menu_color]').get(), '0.9'));
					$('#main_menu').css('background-color', 'transparent');
					$('.menu').css('background-color', 'transparent');

					$('#search_blog').css('background-color', 'transparent');
				}
			}
		} );
	} );

	//Update menu bar text color in real time...
	wp.customize( 'jamsession_options[menu_text_color]', function( value ) {
		'use strict';
		value.bind( function( newval ) {
			$('#main_menu ul li a ').css('color', newval);
			$('.copy').css('background-color', newval);
			$('#news_badge').css('color', newval);
			$('#front_page_news_bar a').css('color', newval);
			if ( !($( "#main_menu" ).length) )
			{
				$('.menu ul li a ').css('color', newval);
			}
			$('.mobile_menu_hmb').find('span').css('background-color', newval);
		} );
	} );
	
	//active menu item color
	wp.customize( 'jamsession_options[menu_active_text_color]', function( value ) {
		'use strict';
		value.bind( function( newval ) {
			$('#main_menu ul li.current-menu-item > a ').css('color', newval);
			$('#main_menu ul li.current-menu-ancestor > a ').css('color', newval);
			if ( !($( "#main_menu" ).length) )
			{
				$('.menu ul li.current-menu-item > a ').css('color', newval);
				$('.menu ul li.current-menu-ancestor > a ').css('color', newval);
			}
		} );
	} );	
	
	//secondary color
	wp.customize( 'jamsession_options[second_color]', function( value ) {
		'use strict';
		value.bind( function( newval ) {
		
			$('#postmeta a').css('color', newval);
			$('a').css('color', newval);
		
			$('#commentform input[type="submit"]').hover(function(){
				$(this).css('background-color', newval);
			},
				function(){
					$(this).css('background-color', wp.customize.instance('jamsession_options[menu_color]').get());
				}
			);

			$('#sidebar input[type="submit"]').hover(function(){
				$(this).css('background-color', newval);
			},
				function(){
					$(this).css('background-color', wp.customize.instance('jamsession_options[menu_color]').get());
				}
			);
			
			$('#inline_search input[type="submit"]').hover(function(){
				$(this).css('background-color', newval);
			},
				function(){
					$(this).css('background-color', wp.customize.instance('jamsession_options[menu_color]').get());
				}
			);

			$('#contactform input[type="submit"]').hover(function(){
				$(this).css('background-color', newval);
			},
				function(){
					$(this).css('background-color', wp.customize.instance('jamsession_options[menu_color]').get());
				}
			);

			$('.reply').hover(function(){
				$(this).css('background-color', newval);
			},
				function(){
					$(this).css('background-color', wp.customize.instance('jamsession_options[menu_color]').get());
				}
			);

			$('.post_tag').find('a').hover(function(){
				$(this).css('background-color', newval);
			},
				function(){
					$(this).css('background-color', wp.customize.instance('jamsession_options[menu_color]').get());
				}
			);	

			$('.event_actions').find('a').hover(function(){
				$(this).css('background-color', newval);
			},
				function(){
					$(this).css('background-color', wp.customize.instance('jamsession_options[menu_color]').get());
				}
			);
			
			$('.fb_actions').hover(function(){
				$(this).css('background-color', newval);
			},
				function(){
					$(this).css('background-color', wp.customize.instance('jamsession_options[menu_color]').get());
				}
			);			

			$('.post_cat').find('a').css('background-color', newval);
			$('.post_cat').find('a').hover(function(){
				$(this).css('background-color', wp.customize.instance('jamsession_options[menu_color]').get());
			},
				function(){
					$(this).css('background-color', newval);
				}
			);			

			$('.footer_share').find('a').css('color', '#787878');
			$('.footer_share').find('a').hover(function(){
				$(this).css('color', newval);
			},
				function(){
					$(this).css('color', '#787878');
				}
			);					
			
			$('.social_share').find('a').css('color', '#fff');
			$('.social_share').find('a').hover(function(){
				$(this).css('color', newval);
			},
				function(){
					$(this).css('color', '#fff');
				}
			);

			$('#sidebar').find('a').css('color', '#fff');
			$('#sidebar').find('a').hover(function(){
				$(this).css('color', newval);
			},
				function(){
					$(this).css('color', '#fff');
				}
			);
			
			$('.custom_actions').css('background-color', newval);
			$('.pagination_links').find('a').css('background-color', newval);
			$('#wp-calendar').find('thead').css('background-color', newval);
			$('.mejs-time-current').css('color', newval);
			
			$('.slideTitle').css('background-color', newval);
			
			
			//exceptions
			$('.slideTitle').find('a').css('color', '#fff');
			$('.slideMessage').find('a').css('color', '#fff');
			$('#front_page_footer').find('a').css('color', '#fff');
			$('#front_page_news_bar').find('a').css('color', '#fff');
			$('.post_tag').find('a').css('color',  wp.customize.instance('jamsession_options[menu_text_color]').get());
			$('.post_cat').find('a').css('color', '#fff');
			$('.tagcloud').find('a').css('color', wp.customize.instance('jamsession_options[menu_text_color]').get());
			$('.reply').find('a').css('color', '#fff');
			$('#main_menu').find('a').css('color', wp.customize.instance('jamsession_options[menu_text_color]').get());
			if ( !($( "#main_menu" ).length) )
			{
				$('.menu').find('a').css('color', wp.customize.instance('jamsession_options[menu_text_color]').get());
			}
			$('#search_blog').find('a').css('color', '#fff');
			$('#logo').find('a').css('color', wp.customize.instance('jamsession_options[logo_textcolor]').get());
			$('.pagination_links').find('a').css('color', '#fff');
			
		} );
		
	} );	
	
	/*=================  HEADER LAYOUT =============================*/
	wp.customize( 'jamsession_options[header_layout]', function( value ) {
		'use strict';
		value.bind( function( newval ) {
			/* layout 1 - stuck on top - */
			if ('layout1' == newval)
			{
				$('#logo').css('top', '0');
				$('#logo').css('line-height', '90px');
				$('.menu_social_links i').css('line-height', '90px');
				$('#logo').css('font-size', '35px');
				
				$('#menu_navigation').css('top', '0');
				$('#main_menu').find('ul').find('li').find('a').css('line-height','90px');
				$('#main_menu').find('ul').find('ul').find('li').find('a').css('line-height','40px');
				
				if ( !($( "#main_menu" ).length) )
				{
					$('.menu').find('ul').find('li').find('a').css('line-height','90px');
					$('.menu').find('ul').find('ul').find('li').find('a').css('line-height','40px');				
				}
				
				/*========================================*/
				$('#main_menu').css('display','block');
				$('#main_menu').css('margin','0');
				$('#main_menu').css('float','right');
				$('#main_menu').css('right','0');
				
				if ( !($( "#main_menu" ).length) )
				{
					$('.menu').css('display','block');
					$('.menu').css('margin','0');
					$('.menu').css('float','right');
					$('.menu').css('right','0');				
				}
				
				$('#logo').css('letter-spacing','0');
				$('#logo').css('display','block');
				$('#logo').css('margin','0');
				$('#logo').css('left','0');
				$('#logo').css('position','absolute');
				
				$('#menu_navigation').css('position', 'relative');	

				$('#search_blog').find('span').css('margin', '29px 25px 0px 0px');	
				$('#search_blog').css('height', '90px');		
				
			}	
			/*layout 2 - distanced from the top*/			
			if (('layout2' == newval) || ('layout11' == newval))
			{
				var distanced = false;
				if ('layout2' == newval) {
					distanced = true;
				}
				
				if (distanced) {
					$('#logo').css('top', '20px');
					$('#menu_navigation').css('top', '20px');
				}
				
				$('#logo').css('line-height', '75px');
				$('#logo').css('font-size', '30px');
				$('.menu_social_links i').css('line-height', '75px');
				
				
				$('#main_menu').find('ul').find('li').find('a').css('line-height','75px');
				$('#main_menu').find('ul').find('ul').find('li').find('a').css('line-height','35px');
				
				if ( !($( "#main_menu" ).length)) {
					$('.menu').find('ul').find('li').find('a').css('line-height','75px');
					$('.menu').find('ul').find('ul').find('li').find('a').css('line-height','35px');
				}
				
				
				/*========================================*/
				$('#main_menu').css('display','block');
				$('#main_menu').css('margin','0');
				$('#main_menu').css('float','right');
				$('#main_menu').css('right','0');

				if ( !($( "#main_menu" ).length) )
				{
					$('.menu').css('display','block');
					$('.menu').css('margin','0');
					$('.menu').css('float','right');
					$('.menu').css('right','0');				
				}
				
				$('#logo').css('letter-spacing','0');
				$('#logo').css('display','block');
				$('#logo').css('margin','0');
				$('#logo').css('left','0');
				$('#logo').css('position','absolute');
				
				$('#menu_navigation').css('position', 'relative');
				$('#search_blog').css('height', '75px');
				
				$('#search_blog').find('span').css('margin', '20px 25px 0px 0px');
			}
			
			if ('layout3' == newval)
			{
				$('#main_menu').find('ul').find('li').find('a').css('line-height','60px');
				$('.menu_social_links i').css('line-height', '60px');
				$('#main_menu').find('ul').find('ul').find('li').find('a').css('line-height','30px');
				$('#main_menu').css('display','table');
				$('#main_menu').css('margin','auto');
				$('#main_menu').css('float','none');
				$('#main_menu').css('right','0');
				
				if ( !($( "#main_menu" ).length) )
				{
					$('.menu').find('ul').find('li').find('a').css('line-height','60px');
					$('.menu').find('ul').find('ul').find('li').find('a').css('line-height','30px');
					$('.menu').css('display','table');
					$('.menu').css('margin','auto');
					$('.menu').css('float','none');
					$('.menu').css('right','0');
				}
				
				$('#logo').css('font-size','32px');
				$('#logo').css('line-height','65px');
				$('#logo').css('letter-spacing','8px');
				$('#logo').css('display','table');
				$('#logo').css('margin','auto');
				$('#logo').css('top','0');
				$('#logo').css('left','0');
				$('#logo').css('position','relative');
				
				$('#menu_navigation').css('position', 'relative');
				$('#menu_navigation').css('top', '0');
				
				$('#search_blog').find('span').css('margin', '13px 25px 0px 0px');
				$('#search_blog').css('height', '60px');	
				
			}			

		} );
	} );
	
	//Update logo bg color in real time...
	wp.customize( 'jamsession_options[content_container_opacity]', function( value ) {
		'use strict';
		
		value.bind( function( newval ) {
			var bgHexColor = wp.customize.instance('jamsession_options[content_container_bgc]').get();
			var opacity = getOpacityFromValue( newval);
			var bgcolor = hexToRGBA(bgHexColor, opacity);
			
			if ( $('#post_content').length > 0) {
				$('#post_content').css('background-color', bgcolor);
			}
			
			if ( $('#post_content_full').length > 0) {
				$('#post_content_full').css('background-color', bgcolor);
			}

			$('.js_full_container_inner').css('background-color', bgcolor);
			
			if ( $('#sidebar').length > 0) {
				$('#sidebar').css('background-color', bgcolor);
			}
			
			if ( $('.event_meta').length > 0) {
				$('.event_meta').css('background-color', bgcolor);
			}
			
			if ( $('.album_meta').length > 0) {
				$('.album_meta').css('background-color', bgcolor);
			}
			
			if ( $('#album_listing').length > 0) {
				$('#album_listing').css('background-color', bgcolor);
			}
			
			if ( $('#event_listing').length > 0) {
				$('#event_listing').css('background-color', bgcolor);
			}
			
			if ( $('#js_swp_container').length > 0) {
				$('#js_swp_container').css('background-color', bgcolor);
			}			
		} );
	});
	
	wp.customize( 'jamsession_options[masonry_container_opacity]', function( value ) {
		'use strict';
		
		value.bind( function( newval ) {
			var bgHexColor = wp.customize.instance('jamsession_options[content_container_bgc]').get();
			var opacity = getOpacityFromValue(newval);
			var bgcolor = hexToRGBA(bgHexColor, opacity);

			if ( $('.post_item').length > 0) {
				$('.post_item').css('background-color', bgcolor);
			}
			if ( $('.event_item_list').length > 0) {
				$('.event_item_list').css('background-color', bgcolor);
			}
		});
	});
	
	wp.customize( 'jamsession_options[content_container_bgc]', function( value ) {
		'use strict';
		
		value.bind( function( newval ) {
			var masonryOpacity = wp.customize.instance('jamsession_options[masonry_container_opacity]').get();
			var contentContainerOpacity = wp.customize.instance('jamsession_options[content_container_opacity]').get();
			masonryOpacity = getOpacityFromValue(masonryOpacity);
			contentContainerOpacity = getOpacityFromValue(contentContainerOpacity);
			var bgColorMason = hexToRGBA(newval, masonryOpacity);
			var bgColorCont = hexToRGBA(newval, contentContainerOpacity);

			if ( $('.post_item').length > 0) {
				$('.post_item').css('background-color', bgColorMason);
			}
			if ( $('.event_item_list').length > 0) {
				$('.event_item_list').css('background-color', bgColorMason);
			}
			/*content container opacity*/
			if ( $('#post_content').length > 0) {
				$('#post_content').css('background-color', bgColorCont);
			}
			
			if ( $('#post_content_full').length > 0) {
				$('#post_content_full').css('background-color', bgColorCont);
			}
			$('.js_full_container_inner').css('background-color', bgColorCont);
			
			if ( $('#sidebar').length > 0) {
				$('#sidebar').css('background-color', bgColorCont);
			}
			
			if ( $('.event_meta').length > 0) {
				$('.event_meta').css('background-color', bgColorCont);
			}
			
			if ( $('.album_meta').length > 0) {
				$('.album_meta').css('background-color', bgColorCont);
			}
			
			if ( $('#album_listing').length > 0) {
				$('#album_listing').css('background-color', bgColorCont);
			}
			
			if ( $('#event_listing').length > 0) {
				$('#event_listing').css('background-color', bgColorCont);
			}
			
			if ( $('#js_swp_container').length > 0) {
				$('#js_swp_container').css('background-color', bgColorCont);
			}			
		});
	});	
	
	wp.customize('jamsession_options[remove_content_container_border]', function(value) {
		'use strict';
		value.bind(function(newval) {
			if (true == newval) {
				$('#post_content, #post_content_full, .album_meta, .event_meta, #album_listing, #event_listing, #sidebar, .post_item, .post_item_woo, .js_full_container_inner').css('border-width', '0' );
			} else {
				$('#post_content, #post_content_full, .album_meta, .event_meta, #album_listing, #event_listing, #sidebar, .post_item, .post_item_woo, .js_full_container_inner').css('border-width', '1px' );
			}
		} );
	});	
	
	
} )( jQuery );

function hexToRGBA(hex, opacity) {
	'use strict';
	var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	return result ?  
		'rgba(' + parseInt(result[1], 16) + ", " + parseInt(result[2], 16) + ", " + parseInt(result[3], 16) + ',' + opacity +')'
		: null;
}

function getOpacityFromValue(value) {
	var arrVal = value.split("_");
	var floatVal = parseFloat(arrVal[1]);

	return floatVal/10;
}
