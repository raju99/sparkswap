jQuery(document).ready(function(){  
// jQuery("#frmuserregistration").validate();
jQuery("#adminform").validate();
jQuery("#addItem").validate();
jQuery("#edituser").validate();

jQuery("#rentReaquest").validate();
jQuery("#updateItem").validate();

jQuery("#frmlogin").validate();
jQuery("#booking_form").validate();
jQuery("#userimagefrm").validate({
	rules: {
		"file": {
			required:true,
			accept: "jpeg|png|gif|jpg|bmp"
		}
	},
	messages: {
		"file": {
			accept: "<font color='red'>Invalid Extension for image.</font>"
		}
	}
	});

 jQuery("#pickup").datepicker();

 jQuery("#dropoff").datepicker();
  jQuery("#pickup").datepicker();

 jQuery("#dropoff").datepicker();

		



	  
});