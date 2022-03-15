jQuery(document).ready( function($) {
	'use strict';
	
	$(".for_ajax_contact").find("#contactForm").submit(function(event) {
		event.preventDefault();
		var inputError = 0;
		
		if ( $.trim($(".for_ajax_contact").find(".contactNameInput").val()) === '') {
			$(".for_ajax_contact").find(".comment-form-author").find(".error").show("slow");
			inputError=1;
		}else {
			$(".for_ajax_contact").find(".comment-form-author").find(".error").hide();
		}
		if ( $.trim($(".for_ajax_contact").find(".email").val()) === '') {
			$(".for_ajax_contact").find(".comment-form-email").find(".error").show("slow");
			inputError=1;
		} else {
			var emailValue = $.trim($(".for_ajax_contact").find(".email").val());
			var admitted = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
			var is_email=admitted.test(emailValue);
			if (is_email) {
				$(".for_ajax_contact").find(".comment-form-email").find(".error").hide();	
			} else {
				$(".for_ajax_contact").find(".comment-form-email").find(".error").show("slow");
				inputError=1;
			}
		}
		if ( $.trim($("textarea#commentsText").val()) === '') {
			$(".for_ajax_contact").find(".comment-form-comment").find(".error").show("slow");
			inputError=1;
		} else {
			$(".for_ajax_contact").find(".comment-form-comment").find(".error").hide();
		}
		
		$(".for_ajax_contact").find(".captcha_error").find(".error").hide();
		$(".for_ajax_contact").find(".formResultOK").find(".error").hide();
		
		if (inputError) {
			return;
		}
		
		var data = {
			action: 'contactformajax_action',
			data: $("#contactForm :input").serialize()
		};

		$(".for_ajax_contact").find('.progressAction').css("visibility","visible");
		$.post(DATAVALUES.ajaxurl, data, function(response) 
		{	
			var obj;
			try {
				obj = $.parseJSON(response);
			}
			catch(e) { 
				/*catch some error*/
				alert("some exception");
			}

			if(obj.success === true) { 
				$(".for_ajax_contact").find(".formResultOK").find(".error").show("slow");
				$(".for_ajax_contact").find(".contactNameInput").val('');
				$(".for_ajax_contact").find(".email").val('');
				$("textarea#commentsText").val('');
				$(".for_ajax_contact").find("#phone").val('');
			}
			else {
				if (obj.error === 'reCaptcha') {
					$(".for_ajax_contact").find(".captcha_error").find(".error").show("slow");
				}
				if (obj.error === 'wp_mail_failed') {
					$(".for_ajax_contact").find(".wp_mail_error").find(".error").show("slow");
				}
			}
			$(".for_ajax_contact").find('.progressAction').css("visibility","hidden");
		});				 
	});
});