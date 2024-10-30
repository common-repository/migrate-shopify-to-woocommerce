jQuery(document).ready(function($){

  $(document).on("click","#swm-query-submit-btn", function(event){
     
  	event.preventDefault();

  	$("#support-form-result #support-form-status").hide();
  	$("#swm-support-form #support-form-loading").hide();
		
	var flag = true;
	
	var name = $("#swm-support-form #name").val();
	var email = $("#swm-support-form #email").val();
	var subject = $("#swm-support-form #subject").val();
	var message = $("#swm-support-form #message").val();
	var plugin_name = $("#swm-support-form #plugin_name").val();
	
	if( name == "" || email == "" || subject == "" || message == ""){
		flag = false;
	}

	var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");

    if ( atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length ) {
        alert("Not a valid e-mail address");
        flag = false;
        return false;
    }
	
	if( flag )
	{
		
		$("#swm-support-form #support-form-loading").show();
		
		var data = {
			'action': 'process_swm_promo_form',
			'post_name': name,
			'post_email': email,
			'post_subject': subject,
			'post_message': message,
			'post_plugin_name': plugin_name,
		};

		jQuery.post(ajaxurl, data, function(response) {
			var json = $.parseJSON(response);
			
			$("#swm-support-form #support-form-loading").hide();

			$("#support-form-result #support-form-status").removeClass('output-success');
			$("#support-form-result #support-form-status").removeClass('output-failed');
			$("#support-form-result #support-form-status").hide();

			if( json.status == 'failed' ){
				$("#support-form-result #support-form-status").show();
				$("#support-form-result #support-form-status").html('');
				$("#support-form-result #support-form-status").addClass('output-failed');
				$("#support-form-result #support-form-status").html('<p>'+json.message+'</p>');
			}

			if( json.status == 'success' ){

				$("#support-form-result #support-form-status").show();
				$("#support-form-result #support-form-status").html('');
				$("#support-form-result #support-form-status").addClass('output-success');
				$("#support-form-result #support-form-status").html('<p>'+json.message+'</p>');

				$("#swm-support-form #name").val('');
				$("#swm-support-form #email").val('');
				$("#swm-support-form #subject").val('');
				$("#swm-support-form #message").val('');
			}

		});
	
	}
	else
	{
		alert("Please fill-up the required fields.");
	}


  });

});