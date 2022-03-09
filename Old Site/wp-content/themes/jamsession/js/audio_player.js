jQuery(document).ready( function($) {
	'use strict'; 
	/*
		Overriding Core jQuery width() 
		Method to Fix mejs-time-rail class object Width
	*/	
	var orig_width = $.fn.width;

	$.fn.width = function(){
		var objClass = $(this).attr("class");
		
		if (objClass == 'mejs-time-rail')
		{
			if (arguments.length)
			{
				arguments[0] = arguments[0] - 1;
 			}
		}
		
		var ret = orig_width.apply(this, arguments);
				
		return ret;
	}
});	

