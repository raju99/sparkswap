 jQuery("#frmuserregistration").validate(
	{
	 rules: { 
		 "email": {
					required: true,
					email:true,
					remote: "checkEmail.php"
					},
		"username": {
					required: true,
					
					remote: "checkEmail.php"
					},
"pass": {
equalTo: "#pass"
}
},
messages: {
"pass": {
equalTo: "Password & confirm password doesn't match"
},
	"email": {
						required: "Please enter email" ,
						email: "Please enter valid email" ,
						remote: jQuery.format("Email Name already exists.Please try another.") 
											},
	"username": {
						required: "Please enter username" ,
						
						remote: jQuery.format("User Name already exists.Please try another.") 
											}

}


});
