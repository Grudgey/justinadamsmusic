jQuery(document).ready( function($) {
	'use strict';

	clickOnMobileHmb($);

	setDesktopMobileMenuHeight($);
	setDeskMobileMenuProperties($);
	clickOnDeskMobileHmb($);

	$(window).scroll(function() {
		mobileMenuAdminBar($);
    });	
});	

function toggleMobileMenu($, $container) {
	$container.find('.menu_1').toggleClass("rotate45");
	$container.find('.menu_2').toggleClass("rotate45Counter");
	$container.find('.menu_3').toggle();
	$('.mobile_menu_container').toggle();	
}

function clickOnMobileHmb($) {
	$('.mobile_hmb.in_mobile_menu_bar').click(function(){
		if ($(window).scrollTop() > 0) {
			$("html").animate({ scrollTop: 0 }, 400, function(){
				toggleMobileMenu($, $(this));
			});
		} else {
			toggleMobileMenu($, $(this));
		} 
	});
}

function setDesktopMobileMenuHeight($) {
	var logoHeight = $("#logo").css("line-height");
	$('.mobile_menu_hmb.on_desktop').find('.mobile_permanent').css("height", logoHeight);
	$(".mobile_menu_hmb.on_desktop").css("line-height", logoHeight);
}

function setDeskMobileMenuProperties($) {
	$(".use_mobile").find("#main_menu").find("ul").find("ul").css({
		"opacity" : "1",
		"height"  : "auto",
		"transition-property" : "none"
	});
	
	$(".use_mobile").find("#main_menu").find("ul").children("li").children("a").click(function(event) {
		if ( $(this).parent().has("ul").length) {
			$(this).parent().children("ul").slideToggle({
				duration: "100", 
				easing: "swing"
			});
			event.preventDefault(); 
		}
	});
	
	if($('.use_mobile').length) {
		$("#search_blog").hide();	
	}
	
}

function clickOnDeskMobileHmb($) {
	var oldBgc, oldStyle;
	$(".mobile_menu_hmb.on_desktop").find(".mobile_permanent").on("click", function() {
		if ( $(".use_mobile").is(':hidden')) {
			oldStyle = $("#menu_navigation").attr("style");
			$("#menu_navigation").removeAttr("style");
			oldBgc = $("#menu_navigation").css("background-color");
			$("#menu_navigation").attr("style", oldStyle);
			
			$("#main_menu").css("display", "table");
			$("#menu_navigation").css("background-color", "transparent");
			$("body").css("overflow-y", "hidden");

			setTimeout(function() {  
				$("#menu_navigation").css("background-color", "transparent");
			}, 500);				
			
			addDeskHmbMenuRotation($);
		}
		else {
			$("#main_menu").css("display", "table");
			$("#menu_navigation").css("background-color", oldBgc);
			$("body").css("overflow-y", "auto");
			removeDeskHmbMenuRotation($);
		}

		$(".use_mobile").fadeToggle(400);
		toogleContentUnderOverlay($);
	}); 		
}

function addDeskHmbMenuRotation($) {
	$(".menu_1.for_desk").addClass("rotate45");
	$(".menu_2.for_desk").addClass("rotate45Counter");
	$(".menu_3.for_desk").hide();	

}

function removeDeskHmbMenuRotation($) {
	$(".menu_1.for_desk").removeClass("rotate45");
	$(".menu_2.for_desk").removeClass("rotate45Counter");
	$(".menu_3.for_desk").show();
}

function toogleContentUnderOverlay($) {
	if ($("#main_content").length > 0) {
		$("#main_content").fadeToggle(100);
	}
	
	if ($("#title_all").length > 0){
		$("#title_all").fadeToggle(100);
	}	
}

function mobileMenuAdminBar($) {
	if ($('#wpadminbar').length) {
		if ($(window).scrollTop() > $('#wpadminbar').height()) {
			$('.mobile_menu_bar').addClass('under_adminbar');
		} else {
			$('.mobile_menu_bar').removeClass('under_adminbar');
		}
	}
}