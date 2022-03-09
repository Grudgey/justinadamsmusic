jQuery(document).ready( function($) {
	'use strict';		
	jQuery(window).load( function() {
		do_masonry(true);
		setTimeout(function() {
			do_masonry(false);
		}, 500);
		setTimeout(function() {
			do_masonry(false);
		}, 200);		

	});
	
	jQuery( window ).smartresize( function(){
		do_masonry(false);
		setTimeout(function() {
			do_masonry(false);
		}, 500);
		setTimeout(function() {
			do_masonry(false);
		}, 200); 
	});	

});	


function do_masonry(doAnimation)
{
	'use strict';
	var $container = jQuery('#post_content_container').masonry({isAnimated: false});
	var $loader =  jQuery('#content_loader');
	var colNumber = 0, contW = 0, colW = 0;
	var GUTTER_W = 3;
	

	contW = $container.width();

	if (contW <= 480){
		colNumber = 1;
	} else if (contW <= 768) {
		colNumber = 2;
	} else if (contW <= 1199) {
		colNumber = 4;
	} else
	{
		colNumber = 5;
	}
	colW = Math.floor((contW - (colNumber - 1)*GUTTER_W)/colNumber ) ;
	
	if ( jQuery(".post_item").length > 0){
			jQuery('.post_item').css('width', colW);
	}
	
	if ( jQuery(".post_item_gallery").length > 0){
			jQuery('.post_item_gallery').css('width', colW);
	}

	
	// initialize Masonry after all images have loaded 
	$loader.hide();
	$container.imagesLoaded( function() {
		if ( jQuery(".post_item").length > 0){
			jQuery('.post_item').show();
		}
		
		if ( jQuery(".post_item_gallery").length > 0){
			jQuery('.post_item_gallery').show();
		}

		$container.css("min-height", "0");


		$container.masonry({
			itemSelector: ".post_item, .post_item_gallery",
			columnWidth: colW,
			gutterWidth: GUTTER_W,
			isResizable: false,
			isFitWidth: true,
			isAnimated: false,
			isInitLayout: false,
				animationOptions: {
					duration: 100,
					easing: 'linear',
					queue: false
				}  
		});
	});	

}

(function($,sr){
  
  var debounce = function (func, threshold, execAsap) {
      var timeout;
  
      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };
  
          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);
  
          timeout = setTimeout(delayed, threshold || 100); 
      };
  }
    // smartresize 
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
  
})(jQuery,'smartresize');
