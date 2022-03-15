jQuery(document).ready(function($) {
	'use strict';
	var value = "";
	
	value = $( "#logo_select option:selected" ).val();
	if ( value == "blog_title"){
		$('#logo_upload_value').attr('disabled','disabled');
		$('#upload_logo_button').attr('disabled','disabled');
	}
	else{
		$('#logo_upload_value').removeAttr('disabled');
		$('#upload_logo_button').removeAttr('disabled');
	}
	
	$('#logo_select').change(function(){
		value = "";
		
		$( "#logo_select option:selected" ).each(function() {
			value = $( this ).val();
		});
		
		if ( value == "blog_title"){
			$('#logo_upload_value').attr('disabled','disabled');
			$('#upload_logo_button').attr('disabled','disabled');
		}
		else{
			$('#logo_upload_value').removeAttr('disabled');
			$('#upload_logo_button').removeAttr('disabled');
		}
	})
	
	// Runs when the logo image button is clicked.
    $('#upload_logo_button').click(function(e) {
		e.preventDefault();
 
		// Instantiates the variable that holds the media library frame.
		var meta_image_frame;	
		
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: "Choose Custom Logo Image",
            button: { text:  "Use this image as logo" },
            library: { type: 'image' }
        });
		
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
 
            // Sends the attachment URL to our custom image input field.
            $('#logo_upload_value').val(media_attachment.url);
			$('#logo_upload_preview img').attr('src', media_attachment.url);
        });
 
        // Opens the media library frame.
        meta_image_frame.open();		
    });	

	
    $('#upload_favicon_button').click(function(e) {  

		e.preventDefault();
 
		// Instantiates the variable that holds the media library frame.
		var meta_image_frame;	
		
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: "Choose Custom Favicon Image",
            button: { text:  "Use this image as favicon" },
            library: { type: 'image' }
        });
		
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
 
            // Sends the attachment URL to our custom image input field.
            $('#favicon_upload_value').val(media_attachment.url);
			$('#favicon_upload_preview img').attr('src', media_attachment.url);
        });
 
        // Opens the media library frame.
        meta_image_frame.open();		 
    });
	
    $('#upload_bgimage_button').click(function(e) {  
		e.preventDefault();
 
		// Instantiates the variable that holds the media library frame.
		var meta_image_frame;	
		
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: "Choose Custom Background Image",
            button: { text:  "Use this image as background" },
            library: { type: 'image' }
        });
		
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
 
            // Sends the attachment URL to our custom image input field.
            $('#bgimage_upload_value').val(media_attachment.url);
			$('#bgimage_upload_preview img').attr('src', media_attachment.url);
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });	
	
});  