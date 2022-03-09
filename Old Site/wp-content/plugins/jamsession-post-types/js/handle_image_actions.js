jQuery(document).ready(function($){
	"use strict";
	
	var meta_image_frame;
	
	makeElementsSortable($);
	handleDeleteImage($);
	
    $('#js_swp_add_image_gallery_cpt').click(function(e){
        e.preventDefault();
 
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: "Add Image To Gallery",
            button: { text:  "Add Image" },
            library: { type: 'image' },
			multiple: true
        });
 
        meta_image_frame.on('select', function(){
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
			
			var all_attachments = meta_image_frame.state().get('selection').toJSON();
			var attach_number = meta_image_frame.state().get('selection').length;
			var attachment_ids = "";
			for(var attach_counter = 0; attach_counter < attach_number; attach_counter++) {
				if ("" != attachment_ids) {
					attachment_ids += ",";
				}
				attachment_ids += all_attachments[attach_counter].id;
			}
			
			var oldInputVal = $('#js_swp_gallery_images_id').val();
			$.trim(oldInputVal);
			alert(oldInputVal);
			if (oldInputVal != "") {
				oldInputVal += ",";
			}
			oldInputVal += attachment_ids;
			alert(oldInputVal);
			$('#js_swp_gallery_images_id').val(oldInputVal);
			
			/*trigger preview repaint*/
			repaintGalleryPreview($);
         });
 
        meta_image_frame.open();
    });
});

function makeElementsSortable($) {
	if ($( ".js_swp_gallery_cpt_preview" ).length) {
		$(".js_swp_gallery_cpt_preview").sortable({
			update: function(event, ui){
				var photoOrder = $(this).sortable('toArray').toString();
				handleSortableDropImage($, photoOrder);
			}
		});
	}
}

function handleSortableDropImage($, newOrder) {
	$('#js_swp_gallery_images_id').val(newOrder);
}

function handleDeleteImage($) {
	$(".remove_gallery_cpt_image").click(function(e){
		e.preventDefault();
		var deleteIndex = $(this).data("imid");
		var idContent = $('#js_swp_gallery_images_id').val();
		var toDeleteString = deleteIndex+",";
		if (idContent.search(deleteIndex+",") == -1) {
			/*id is on the latest pos*/
			toDeleteString = ","+deleteIndex;
		}
		idContent = idContent.replace(toDeleteString, "" );	

		$('#js_swp_gallery_images_id').val(idContent);
		deleteImageFromPreview($, deleteIndex);
	});	
}

function deleteImageFromPreview($, imgId) {
	$("#js_swp_gallery_content").find("li#"+imgId).remove();
}

function repaintGalleryPreview($) {
	var imageattachment_ids = $('#js_swp_gallery_images_id').val();
	var data = {
				action: 'JAMSESSION_SWP_call_update_gallery_preview',
				image_attachment_ids: imageattachment_ids
		};
	
	$.post(ajaxurl, data, function(response) {
		var obj;
		
		try {
			obj = $.parseJSON(response);
		}
		catch(e) { 
			/*catch some error*/
		}

		if(obj.success === true) { 
			$('#js_swp_gallery_content').replaceWith(obj.gallery);
			makeElementsSortable($);
		} else {}
	});
}
