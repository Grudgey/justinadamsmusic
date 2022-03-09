jQuery(document).ready( function($) {
			'use strict';
			
			var slideShow 		 = $.parseJSON(jamsession_slideshow_images.images);
			var imageProtect 	 = $.parseJSON(jamsession_slideshow_images.image_protect);
			var sliderInterval	 = $.parseJSON(jamsession_slideshow_images.slider_interval);
			var sliderTransition = $.parseJSON(jamsession_slideshow_images.slider_transition);
			
			$.supersized({
				// Functionality
				slide_interval          :   sliderInterval,			// Length between transitions
				transition              :   sliderTransition, 						// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right[default], 7-Carousel Left
				transition_speed		:	300,					// Speed of transition
				image_protect			:   imageProtect,			// Default: 0
				// Components	
				progress_bar			:	0,			// Timer for each slide											
				slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')	
				slides 					:  	slideShow	// Slideshow Images
			});
});