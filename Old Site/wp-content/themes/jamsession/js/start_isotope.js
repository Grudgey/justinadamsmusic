jQuery(document).ready( function($) {
	'use strict';
	
	/*get the container*/
	var $container = $('#post_content_container');
	if ($container.length ) {
		run_isotope($, $container);
	}	

	$('.post_content_container_woo').each(function(){
		run_isotope($, $(this));
	});
})

function run_isotope($, $container) {
	$(window).load( function() {
		$container.imagesLoaded( function() {
			do_isotope($, $container);
			setTimeout(function() {
				do_isotope($, $container);
			}, 500);
			setTimeout(function() {
				do_isotope($, $container);
			}, 200);
		});
	});

	$(window).on("debouncedresize", function( event ) {
		$container.imagesLoaded( function() {
			do_isotope($, $container);
			do_isotope($, $container);
		});
	});	
}

function do_isotope($, $container)
{
	'use strict';
	var		$loader =  $('.main_spinner');
	var 	itemSelector;	
	var 	GUTTER_W = 3;	
	var 	contW = $container.width(), colNumber, colW;
	var 	galleryContainer = 0, blogContainer = 0;
	var 	minHeight = 0;
	var 	inVCWooIsotope = 0;
	var 	COLS_ON_ROW = 5;
	
	if (contW <= 480){
		colNumber = 1;
	} else if (contW <= 768) {
		colNumber = 2;
	} else if (contW <= 1199) {
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
		$('.post_item_woo, .product-category').css('width', colW);
		$('.post_item_woo, .product-category').show();
		itemSelector = '.post_item_woo, .product-category';
		minHeight = $(".post_item_woo, .product-category").height();
	}

	$loader.hide();
	$container.css("min-height", minHeight);	
	

	$container.isotope({
		itemSelector: itemSelector,
		layoutMode : 'masonry',
		resizesContainer : false,
		isInitLayout: false,
		isResizeBound: false,
		animationEngine: 'best-available',
		animationOptions: {
			duration: 300,
			easing: 'linear',
			queue: false
		},
		sortBy : 'original-order',
		masonry: {
			columnWidth: colW,
			gutter: GUTTER_W,
			horizontalOrder: true
		}
	});

}

function getWooColumns($, $container) {
	var $containerParent = $container.parent();
	if ($containerParent.hasClass('columns-1')) {
		return 1;
	}
	if ($containerParent.hasClass('columns-2')) {
		return 2;
	}
	if ($containerParent.hasClass('columns-3')) {
		return 3;
	}
	if ($containerParent.hasClass('columns-4')) {
		return 4;
	}
	if ($containerParent.hasClass('columns-5')) {
		return 5;
	}
	if ($containerParent.hasClass('columns-6')) {
		return 6;
	}
	
	return 5;
}

function doesItFitinContainer(colNumber, colWidth, gutterWidth, containerWidth) {
	if ( colNumber*colWidth + (colNumber - 1)*gutterWidth > containerWidth)
	{
		return 0;
	}
	
	return 1;
}