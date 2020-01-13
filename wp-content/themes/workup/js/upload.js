jQuery(document).ready(function($){
	"use strict";
	var workup_upload;
	var workup_selector;

	function workup_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		workup_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( workup_upload ) {
			workup_upload.open();
			return;
		} else {
			// Create the media frame.
			workup_upload = wp.media.frames.workup_upload =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			workup_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = workup_upload.state().get('selection').first();

				workup_upload.close();
				workup_selector.find('.upload_image').val(attachment.attributes.url).change();
				if ( attachment.attributes.type == 'image' ) {
					workup_selector.find('.workup_screenshot').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}
		// Finally, open the modal.
		workup_upload.open();
	}

	function workup_remove_file(selector) {
		selector.find('.workup_screenshot').slideUp('fast').next().val('').trigger('change');
	}
	
	$('body').on('click', '.workup_upload_image_action .remove-image', function(event) {
		workup_remove_file( $(this).parent().parent() );
	});

	$('body').on('click', '.workup_upload_image_action .add-image', function(event) {
		workup_add_file(event, $(this).parent().parent());
	});

});