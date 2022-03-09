jQuery(document).ready( function($) {
	'use strict';
	
	
	var pageLoaded = 0;
	setTimeout(function() {
		if ( !pageLoaded) {
			doPageLoad($);
			pageLoaded = 1;
		}
	}, 3000);
	
	$(window).load(function() {
		if (!pageLoaded) {
			doPageLoad($);
			pageLoaded = 1;
		}
	});
	
	/*avoid ios devices to load from cache on back button pressed*/
	$(window).bind("pageshow", function(event) {
		if (event.originalEvent.persisted) {
			window.location.reload();
		}
	});

	$('.mobile_navigation li.menu-item-has-children > a').click(function(e){
		
		var elt_fin = $(this).offset().left + $(this).width() + parseInt($(this).css("padding-right")) + parseInt($(this).css("padding-left"));
		if (e.offsetX > elt_fin) {
			/*click on after*/
	        e.preventDefault();
	        $(this).parent().toggleClass('submenu_opened');
	    }
	});
	
	$( ".menu" ).not('.js_mobile_menu').find("a").click(function(event) {
		if (this.target == "_blank") {
			return;
		}
		
		if( this.href.indexOf("#") == -1) {
			event.preventDefault();
			$(".wraper").css("opacity", "0");
			$(".copy").css("opacity", "0");
			$(location).attr('href', this.href);
		} else {
			var href = $(this).attr('href');
			var elemId = href.substring(href.indexOf("#"));

			if ($(elemId).length) {
				if ( typeof( $(elemId).offset() ) !== "undefined" ) {
				    
					event.preventDefault();				
					var menuPosition =  $("#menu_navigation").css("position");
					
					var paddTop = parseInt($(elemId).css('padding-top'));
					var navigationOffset = 0; 
					var stickyMenuHeight = 95;
					
					if ("75" == $("#menu_navigation").height()) {
						stickyMenuHeight = 60;
					}
					
					if ("fixed" != menuPosition) {
						navigationOffset = $("#menu_navigation").height() + $("#menu_navigation").offset().top;
					} else {
						stickyMenuHeight = 122;
					}
					var scrollPos = $(elemId).offset().top;
					if ( !inMobileView()) {
						scrollPos = scrollPos - navigationOffset - stickyMenuHeight + paddTop;
					}
					$('html, body').animate({
						  scrollTop: scrollPos
					}, 1000 );
				}
			}
		}
	});

	$( ".js_swp_parallax" ).each(function() {
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			$(this).addClass("ai_swp_no_scroll");
		} else {
			$(this).css("background-position", "50% 0");
			var $parallaxObject = $(this);
			
			$(window).scroll(function() {
				var yPos = -($(window).scrollTop() / $parallaxObject.data("pspeed")); 
				
				var newCoord = '50% '+ yPos + 'px';
				
				$parallaxObject.css("background-position", newCoord);
			});
		}
	});

	$( ".js_swp_background_image_cover" ).each(function() {
		var imgSrc = $(this).data("bgimage");
		$(this).css("background-image", "url("+imgSrc+")");
		$(this).css("background-position", "center center");
		$(this).css("background-repeat", "no-repeat");
		$(this).css("background-size","cover");		
	});
	
	$( ".js_swp_background_image" ).each(function() {
		var imgSrc = $(this).data("bgimage");
		$(this).css("background-image", "url("+imgSrc+")");
		$(this).css("background-position", "center center");
		$(this).css("background-repeat", "no-repeat");
		$(this).css("background-attachment", "fixed");
		$(this).css("background-size","cover");
	});

	$( ".image_grid_cell" ).each(function() {
		$(this).css("height", $(this).data("cheight"));
		$(this).css("padding", $(this).data("gap"));
	});


	$( ".js_swp_overlay" ).each(function() {
		var bgColor = $(this).data("color");
		
		$(this).parent().css("position", "relative");
		
		$(this).css({
			"background-color" : bgColor,
			"position" : "absolute"
		});
	});
	
	$(".js_swp_video_bgc").each(function() {
		$(this).parent().css("position", "relative");
		$(this).parent().css("overflow", "hidden");
		var dataSource = $(this).data("source");
		
		var innerHTML = '<video width="100%" height="100%" preload="auto" loop autoplay muted src="'+dataSource+'">';
		innerHTML += '<source src="'+dataSource+'" type="video/webm">';
		innerHTML += '</video>';
		
		$(this).html(innerHTML);
		$(this).css("position", "absolute");
	});
	
	
	$(".js_swp_gallery_container").each(function() {
		var rowHeight = $(this).data("rheight");
		if (!$.isNumeric(rowHeight)) {
			rowHeight = 180;
		}
		$(this).justifiedGallery({
			rowHeight: rowHeight,
			lastRow: 'justify',
			margins: 0,
			captions: false,
			imagesAnimationDuration: 100
		});
		$(this).find("img").fadeTo("400", 1);
	});
	
	$(".img_mask").hover(
	function() {
		$(this).css("opacity", "1");
		$(this).css("border-width", $(this).height()/2 + 1);
		}, function() {
		$(this).css("opacity", "0");
		$(this).css("border-width", "0");
	}
	);
	
	var playPressed = 0;
	if ($(".js_swp_player")) {
		var js_swp_players = [];
		var js_swp_names = [];
		var current_player = 0;
		var player_count = 0;

		$( ".js_swp_player" ).find('.mejs-container').each(function() {
			var playerId = $(this).attr('id');
			var player = mejs.players[playerId];

			/*add events*/
			player.media.addEventListener('ended', function() { 
			   playerShowPlay();
			});
			
			player.media.addEventListener('play', function() { 
			   playerShowPause();
			});				

			js_swp_players.push(player);
			player_count++;
			js_swp_names.push($(this).find('audio').data("title"));
		});
		
		putPlayerTitle(js_swp_names[current_player]);
		showCurrentPlayer(current_player);
		
		/*elements needs some time to render*/
		setTimeout(function(){ 
			for (var i = 1; i < player_count; i++) {
				hideCurrentPlayer(i);
			}
		}, 300);
					
		$(".js_swp_audio_controls").find(".icon-play").click(function(){
			playPressed++;
			playerShowPause();
			showCurrentPlayer(current_player);
			js_swp_players[current_player].play();
			putPlayerTitle(js_swp_names[current_player]);
		});
		
		$(".js_swp_audio_controls").find(".icon-pause").click(function(){
			playerShowPlay();
			js_swp_players[current_player].pause();
		});
		
		$(".js_swp_audio_controls").find(".icon-fast-fw").click(function(){
			playPressed++;
			js_swp_players[current_player].pause();
			hideCurrentPlayer(current_player);
			current_player = incrementCurrentPlayer(current_player, js_swp_players.length);
			showCurrentPlayer(current_player);
			js_swp_players[current_player].play();
			putPlayerTitle(js_swp_names[current_player]);
			playerShowPause();
		});
		$(".js_swp_audio_controls").find(".icon-fast-bw").click(function(){
			playPressed++;
			js_swp_players[current_player].pause();
			hideCurrentPlayer(current_player);
			current_player = decrementCurrentPlayer(current_player, js_swp_players.length);
			showCurrentPlayer(current_player);
			js_swp_players[current_player].play();
			putPlayerTitle(js_swp_names[current_player]);
			playerShowPause();
		});
	}
	
	
	var lastScrollTop = 0;
	var oneTime = putContainerToTop($);
	$(window).scroll(function() {
		if (oneTime == 0) {
			var currentScroll = $(window).scrollTop();
			if (currentScroll < lastScrollTop){
			   oneTime = putContainerToTop($);
			}
			lastScrollTop = currentScroll;
		}
		
	});
	
})

function doPageLoad($) {
	$(".main_spinner").css("display","none");
	$(".wraper").css("opacity", "1");
	$(".copy").css("opacity", "1");
}

function putContainerToTop($) {
	if ( $("#full_page_container").length > 0) {
		var $firstChildRow = $("#full_page_container").children(":first");
		if ($firstChildRow.length > 0) {
			/*child element needs valid margin*/
			if ($firstChildRow.css("margin-top").replace("px", "") > 0) {
				return 1;
			}
		}
		var offset = $("#full_page_container").offset().top;
		if (offset > 0) {
			$("#full_page_container").css("margin-top", 0 - offset);
			return 1;
		}
	} else {
		return 1;
	}
	return 0;
}

function incrementCurrentPlayer(current, len) {
	current++;
	if (current == len) {
		return 0;
	}
	return current;
}

function decrementCurrentPlayer(current, len) {
	current--;
	if (current < 0) {
		return len - 1;
	}
	return current;
}

function showCurrentPlayer(current) {
	jQuery("#"+"mep_"+current).show("slow");
}
	
function hideCurrentPlayer(current)	{
	jQuery("#"+"mep_"+current).hide();
}

function putPlayerTitle(newTitle) {
	jQuery(".album_artist").text(newTitle);
}

function playerShowPause() {
	jQuery(".js_swp_audio_controls").find(".icon-play").hide();
	jQuery(".js_swp_audio_controls").find(".icon-pause").show();
}

function playerShowPlay() {
	jQuery(".js_swp_audio_controls").find(".icon-pause").hide();
	jQuery(".js_swp_audio_controls").find(".icon-play").show();
}

function inMobileView()
{
	return (jQuery(".mobile_menu_hmb").css("display") != "none");
}