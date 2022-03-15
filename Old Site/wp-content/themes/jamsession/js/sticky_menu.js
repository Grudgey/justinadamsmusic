jQuery(document).ready( function($) {
	'use strict'; 

	 // initial top offset of the navigation 
	if ( $("#menu_navigation").length <= 0) {
		return;
	}

	$('.desk_menu_spacer').css("height", $("#menu_navigation").height());

	stickyMenu($);
	$(window).scroll(function() {
		stickyMenu($);
    });

});

function stickyMenu($) {
	if ( $("#header").length <= 0) {
		return;
	}

	var triggerStickyOnPx = $('#menu_navigation').offset().top + $('#menu_navigation').height();
	if ($(window).scrollTop() > triggerStickyOnPx) {
		enableSticky($);
	} 

	if (0 == $(window).scrollTop())	{
		disableSticky($);
	}
}

function enableSticky($) {
	if ($('#header').hasClass('sticky_enabled')) {
		return;
	}

	$('#header').addClass('sticky_enabled');
}

function disableSticky($) {
	var element = $('#header');
	if ($(element).hasClass('sticky_enabled')) {
			$(element).removeClass('sticky_enabled');

			if(0 == $(element).attr("class").length) {
				$(element).removeAttr("class");
			}
	}
}

