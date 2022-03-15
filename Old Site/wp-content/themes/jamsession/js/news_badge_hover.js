jQuery(document).ready( function($) {
	'use strict';	

	var hoverOnBar = false;
	var hoverOnBadge = false;
	
	jQuery( "#front_page_news_bar" ).hover(
		function() {
			hoverOnBar = true;
			
			jQuery("#news_badge").css("bottom", "40px");
			jQuery("#front_page_news_bar").css("bottom", "0px");
		}, function() {
			hoverOnBar = false;
			if ( hoverOnBadge == false) {
				jQuery("#news_badge").css("bottom", "5px");
				jQuery("#front_page_news_bar").css("bottom", "-35px");
			}

		}
	);
	
	jQuery( "#news_badge" ).hover(
		function() {
			hoverOnBadge = true;
			
			jQuery("#news_badge").css("bottom", "40px");
			jQuery("#front_page_news_bar").css("bottom", "0px");
		}, function() {
			hoverOnBadge = false;
			
			/* mouse is not over the news bar - slide down badge */
			if ( hoverOnBar == false) {
				jQuery("#news_badge").css("bottom", "5px");
				jQuery("#front_page_news_bar").css("bottom", "-35px");
			}
			else {
				/* still over the news bar - keep badge up*/
				jQuery("#news_badge").css("bottom", "40px");
				jQuery("#front_page_news_bar").css("bottom", "0px");
			}
			
		}
	);	
	
});	