jQuery(document).ready(function($){
	"use strict";
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
 
    // Runs when the image button is clicked.
    $('#js_swp_meta_bg_image-button').click(function(e){
 
        e.preventDefault();
 
        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
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
            $('#js_swp_meta_bg_image').val(media_attachment.url);
			$('#custom_bg_meta_preview img').attr('src', media_attachment.url);
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
	
	$('#js_swp_meta_bg_image-buttondelete').click(function(){
		$('#custom_bg_meta_preview img').attr('src', '');
		$('#js_swp_meta_bg_image').val('');
	});
});