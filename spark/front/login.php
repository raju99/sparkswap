<?php
include('../include/header.php');

if(isset($_SESSION['user']))
{	
	header('location:'.$URL_SITE.'front/home.php');
}

if(isset($_POST['login']))	//Form post
{
	$password = md5($_POST['user_password']);
	$name=($_POST['username']);
	//print_r($_POST);die;
	$result=user::userLogin($name,$password);
	if(!empty($result))
	{

	$_SESSION['user']=$result;		
	header('location:home.php');
	}
	else
	{ 
	echo "<font color='brown'>Invalid user name or password</font>";
	//header('location: '.$URL_SITE.'front/login.php');
	}

}
?>

<div class="member"> 
	<form action="" method="post" name="frmlogin" id="frmlogin"> 	
   
	  <!--Select Username-->
		<input type="text" value="Username" name="username" onfocus="if(this.value=='Username'){this.value=''}" onblur="if(this.value==''){this.value='Username'}" class="singup required">

		<!--Select Password-->
		<input type="password" value="Password" name="user_password" onfocus="if(this.value=='Password'){this.value=''}" onblur="if(this.value==''){this.value='Password'}" class="singup required">
		
		<br>
		<input type="submit" value="LOg in!" name="login" class="singupbtn">
	</form> 	
</div>
	
<!--/Fieldset One-->
<?php 
include("../include/footer.php"); 
?>
	