jQuery(document).ready( function($) {
	'use strict';
	
	var $container = $('#post_content_container');
	var COLS_ON_ROW = 5;
	if ($container.hasClass("salvatore_six_cols")) {
		COLS_ON_ROW = 6;
	}

	prepareColumns($, $container, COLS_ON_ROW);


	$(window).on("debouncedresize", function( event ) {
		$container.imagesLoaded( function() {
			setTimeout(function() {
				prepareColumns($, $container, COLS_ON_ROW);
				prepareColumns($, $container, COLS_ON_ROW);
			}, 500);			
		});
	});		
})

function prepareColumns($, $container, COLS_ON_ROW) {
	if ($container.length ) {
		var		$loader =  $('.main_spinner');
		var 	itemSelector;	
		var 	GUTTER_W = 3;	
		var 	contW = $container.width(), colNumber, colW;
		var 	galleryContainer = 0, blogContainer = 0;
		var 	minHeight = 0;
		var 	inVCWooIsotope = 0;
		var 	winWidth = $(window).width();
		
		if (winWidth <= 479){
			colNumber = 1;
		} else if (winWidth <= 768) {
			colNumber = 2;
		} else if (winWidth <= 1199) {
			colNumber = 4;
		} else	{
			if ($container.parent().hasClass('woocommerce')) {
				inVCWooIsotope = 1;
				colNumber = getWooColumns($, $container);
			} else {
				colNumber = COLS_ON_ROW;
			}
		}
		
		if ( $(".post_item_gallery").length > 0){
			galleryContainer = 1;
		}
		if ( $(".post_item").length > 0) {
			blogContainer = 1;
		}

		if (galleryContainer) {
			if ( colNumber > 2) {
				colNumber = colNumber - 1;
			}
		}
		
		colW = Math.floor( (contW - (colNumber - 1)*GUTTER_W) / colNumber - 0.5) ;
		
		if ( !doesItFitinContainer(colNumber, colW, GUTTER_W, contW)) {
			colW = colW - 1;
		}
		
		if ( blogContainer && !inVCWooIsotope){
			$('.post_item').css('width', colW);
			$('.post_item').show();
			itemSelector = '.post_item';
			minHeight = $(".post_item").height();
		}
		
		if ( galleryContainer){
			$('.post_item_gallery').css('width', colW);
			$('.post_item_gallery').show();
			itemSelector = '.post_item_gallery';
			minHeight = $(".post_item_gallery").height();		
		}
		
		if (inVCWooIsotope || $container.hasClass('products')) {
			$('.post_item_woo').css('width', colW);
			$('.post_item_woo').show();
			itemSelector = '.post_item_woo';
			minHeight = $(".post_item_woo").height();
		}

		$loader.hide();
		$container.css("min-height", minHeight);
		
		salvattore.rescanMediaQueries();
	}
}


function doesItFitinContainer(colNumber, colWidth, gutterWidth, containerWidth) {
	if ( colNumber*colWidth + (colNumber - 1)*gutterWidth > containerWidth)
	{
		return 0;
	}
	
	return 1;
}