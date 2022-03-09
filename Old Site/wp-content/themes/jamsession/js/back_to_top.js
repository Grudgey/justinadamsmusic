jQuery(document).ready( function($) {
	'use strict'; 
	
	/*back to top button*/
	if ($('.back_to_top_btn').length > 0) {
		$('.back_to_top_btn').click(function(){
			$("html, body").animate({ scrollTop: 0 }, "slow");
		});

		$(window).scroll(function() {
			if ($(window).scrollTop() < 500) {
				$('.back_to_top_btn').hide();
			} else {
				$('.back_to_top_btn').show();
			}
		});		
	}	
});