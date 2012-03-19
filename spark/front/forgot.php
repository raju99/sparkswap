<?php
include("../include/header.php");
if(isset($_SESSION['user'])){
	$_SESSION['error_msg'] = "You are already logged-in";
	header('location: '.$URL_SITE.'front/home.php');
	exit;
}

if(isset($_POST['submit']))	//Form post
{
	$email = $_POST['email'];
	$objStu = new user();		// Object of student class

	$rowUser = $objStu->forgotPassword($email);
	if(!empty($rowUser)){
		
		$email = $rowUser['user_email'];
		$name = $rowUser['user_lname']." ".$rowUser['user_fname'];

		$newPassword = $objStu->generatePassword();

		$subject = "Forgot Password Email";

		$body = "<p>Hello ".$name."</p><br/><p>As per your forgot password request we are sending you new password please see below</p><br/><p>New Password: ".$newPassword."</p><br/><p>Login <a href='".$URL_SITE."login.php'>here</a><br/></p><br/><p>Regards,</p><p>Yavneh Administration</p>";

		$ret = $objStu->sendMail($email,$name,$subject,$body);
		if($ret){

			$objStu->updatePassword($rowUser['id'], $newPassword);
			$_SESSION['succ_msg'] = "A mail has been sent on your email address with new password.";
			header('location: '.$URL_SITE.'front/login.php');
			exit;
		} else {
			$_SESSION['error_msg'] = "Error with mail server please try later.";
			header('location: '.$URL_SITE.'front/forgot.php');
		}

	}else{
		$_SESSION['error_msg'] = "Email address is incorrect.";
		header('location: '.$URL_SITE.'front/forgot.php');
	}
	exit;

	
	
}
?>


<!---------------- Student Infromation form  starts----------------------->

<div>
<?php if(isset($_SESSION['error_msg']))
{
	echo $_SESSION['error_msg'];
	unset($_SESSION['error_msg']);
}
?>
</div>
<form action="" method="post" name="frmForgot" id="frmForgot"> 
	<!--Fieldset One-->
	
	<fieldset class="sampleform">
		<legend>Forgot Password</legend>
		<div class="wdthpercent100">
			<label><span class="colorred">*</span>Email: <br />
				<input type="text" class="required inputbox" name="email" />
			</label>
		<br class="clear" />
		</div>
	
		<div class="wdthpercent100">
			<label>Enter the email address with which this user registered</label>
		<br class="clear" />
		</div>

		<div class="wdthpercent100 pT10">
			<input type="submit" value="Submit" class="submitbtn" name="submit"/>
		<br class="clear" />
		</div>
		
	</fieldset>
	<!--/Fieldset One-->
</form>
<?php 
include("../include/footer.php");
?>
