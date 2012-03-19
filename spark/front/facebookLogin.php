<?php

//echo'<pre>';
//print_r($latest_news);
require 'facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId' => $app_id,
  'secret' => $secret_id,
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
   $logoutUrl = $facebook->getLogoutUrl();
	$loginUrl=$logoutUrl;
} else {
  $loginUrl = $facebook->getLoginUrl(array(
    "scope" => "email,user_checkins,user_hometown"
));
}

// This call will always work since we are fetching public data.

?>

	<!---wrapper--->
	<?php if ($user): ?>
	
	<?php endif ?>
	<?php if ($user):
		//facebook information used to login or registration
		//echo'<pre>';
		//print_r($user_profile);

		$_SESSION['facebook_user']=$user_profile;
		if($_SESSION['facebook_user'])
		{
			
			$u=$_SESSION['facebook_user'];
			//print_r($_SESSION['facebook_user']);die;
			$user_registration=user::registration_facebook($u['id'],$u['first_name'],$u['last_name'],$u['gender'],$u['email']);
			if($user_registration)
			{
				$_SESSION['user']=$user_registration;
				header('location:'.$URL_SITE.'front/home.php');
			}
			else
			{
				unset($_SESSION['facebook_user']);
				unset($u);
				header('location:'.$URL_SITE.'front/userRegistration.php');
			}
			
		}
		

		?>
		
		
	<?php else: ?>
	
	<?php endif;	
		
		
	

	?>
 <!---//wrapper--->
 
