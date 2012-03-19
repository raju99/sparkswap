<?php
include('../include/adminHeader.php');
if(isset($_SESSION['a_info']['id']))
{
	header("location:".$URL_SITE."admin/home.php");
}
if(isset($_POST['login']))
{
	
	$user_name=$_POST['user_name'];
	$password=md5($_POST['pass']);
	$result=admin::adminLOgin($user_name,$password);
	if($result>0)
	{
		$_SESSION['succ_msg']="You are logged-in";
		$_SESSION['a_info']['id']=$result;
		header("location:".$URL_SITE."admin/home.php");
	}
	else{
		$_SESSION['error_msg']="Invalid Username or Password";
		header("location:".$URL_SITE."admin/index.php");
	}
	exit;
}
?>

<form action="" method="post" id="adminform">
	<fieldset class="sampleform">
		<legend>Admin Login</legend>
		<div class="wdthpercent100">
			<label>User Name<br />
				<input type="text" class="required inputbox" name="user_name" />
			</label>
			<br class="clear" />
		</div>
		<div class="wdthpercent100">
			<label>Password<br />
				<input type="password" class="required inputbox" name="pass" />
			</label>
			<br class="clear" />
		</div>
		<div class="wdthpercent100 pT10">
			<input type="submit" value="Login" name="login" class="submitbtn" />
		<br class="clear" />
	</fieldset>
</form>
<?php  include("../include/adminFooter.php") ;?>