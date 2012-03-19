<?php
include('../include/header.php');
if(isset($_SESSION['user']))
{
	header('location:'.$URL_SITE.'front');
}
if(isset($_POST['login']))	//Form post
{
	if($_POST['Username']=='Username')
	{
          $_SESSION['msg_Username']="";
		 
	}else{
         $_SESSION['login_Username']=$_POST['Username'];
	}

	if($_POST['Password']=='Password')
	{
          $_SESSION['msg']="13";
		  
	}
	 
if($_POST['Username']=='Username' || $_POST['Password']=='Password')
	{
	  header("location:".$URL_SITE."front/userRegistration.php");
		      exit;
	}

	if(isset($_POST['Password']))
	{
		$password = md5($_POST['Password']);
	}
	if(isset($_POST['Username']))
	{
	 $name=($_POST['Username']);
	}

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
$userDir="$DOC_ROOT/images/profile/";
if(isset($_POST['signup']))
 {   
	
	 $fname=$_POST['fname'];
    $lname=$_POST['lname'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$username=$_POST['username'];
	if($_POST['fname']!="First Name")
	 {
		$_SESSION['fname']=$_POST['fname'];
	 }
     if($_POST['lname']!="Last Name")
	 {
		$_SESSION['lname']=$_POST['lname'];
	 }
     

	if($username=='Select Username')
	 {
          $_SESSION['msg_11']="";
		  //header("location:".$URL_SITE."front/userRegistration.php");
		  //exit;
	 }else{
		 $_SESSION['user_name']=$_POST['username'];
	 }
	 if($email=='E-mail Address')
	 {
          $_SESSION['msg_12']="";
		  //header("location:".$URL_SITE."front/userRegistration.php");
		 // exit;
	 }else{
		 $_SESSION['E-mail']=$_POST['email'];
	 }
	  if($password=='Select Password')
	 {
          $_SESSION['msg_13']="";
		 // header("location:".$URL_SITE."front/userRegistration.php");
		 // exit;
	 }else{
        $_SESSION['Password']=$_POST['password'];
	 }
	 if($email=='E-mail Address' || $username=='Select Username' || $password=='Select Password' )
	 {
             header("location:".$URL_SITE."front/userRegistration.php");
		      exit;
	 }
   //$repassword=$_POST['repassword'];
    //$address=$_POST['address'];
	//$city=$_POST['city'];
    //$state=$_POST['state'];
    //$zip=$_POST['zip'];
    //$contact=$_POST['contact'];

//print_r($_POST);die;
	
/*
			chmod($userDir, 0777);
			if (!is_dir($userDir))
			{
				mkdir($userDir, 0777);
				die ("Error: The directory <b>($userDir)</b> doesn't exist");
			}

			if (!is_writeable("$userDir"))
			{
				//die ("Error: The directory <b>($userDir)</b> is NOT writable, Please CHMOD (777)");
			}	

			if(isset($_FILES["image"]))
			{
				$file_name =$_FILES["image"]["name"];
				$randomDigit=rand(0000,99999);
				 $file_name=$randomDigit.$file_name; //RENAMING THE UPLOADED FILE 		
				
				$file_tmp = $_FILES["image"]["tmp_name"];	
				if(@move_uploaded_file($file_tmp,$userDir.$file_name))	
				{
					
				}
				
			}
			*/
           if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
                   $email=$_POST['email'];
		   }else{
			     $_SESSION['msg']="10";
			     header("location:".$URL_SITE."front/userRegistration.php");
				  exit;
		   }

			$obj=new user();
			$result=$obj->userRegistration($fname,$lname,$email,$password,$username);

			
			if($result)
			{
				$_SESSION['msg']=4;
				$password = md5($password);
				$result=user::userLogin($username,$password);
				if(!empty($result))
					{

						$_SESSION['user']=$result;		
						header('location:home.php');
					}
			}
}

?>
<?php include($DOC_ROOT.'front/facebookLogin.php');?>
<div class="wdth400 mg">
<!---------------- user registration form  starts----------------------->
<form action="" method="post" name="frmuserregistration" id="" enctype="multipart/form-data"> 




<div class="booking font18"> To continue booking sign up or log in... </div>

<div class="facebook">
<a  href="<?php echo $loginUrl;?>" > <img class="pB15" src="<?php echo $URL_SITE?>images/facebook.png" />
<!--<img class="pB15" src="images/facebook.png"  />--> </a>

<img class="pB10" src="<?php echo $URL_SITE;?>images/line_or.png" />

 <!--First name-->
<!--First name-->
 <input class="singup required" onblur="if(this.value==''){this.value='First Name'}"  onfocus="if(this.value=='First Name'){this.value=''}" type="text" name="fname" value="<?php if(isset($_SESSION['fname'])){
echo ($_SESSION['fname']);
unset($_SESSION['fname']);
}else{
	echo"First Name";
}
?>"/>


 <!--Last name-->
 <input class="singup" type="text"  onblur="if(this.value==''){this.value='Last Name'}"  onfocus="if(this.value=='Last Name'){this.value=''}" name="lname" value="<?php if(isset($_SESSION['lname'])){
echo ($_SESSION['lname']);
unset($_SESSION['lname']);
}else{
	echo"Last Name";
}
?>"/>
 <!--E-mail Address-->
<input class="<?php 
if(isset($_SESSION['email_check']) || isset($_SESSION['msg_12']))
{
	echo "singup1"; 
	unset($_SESSION['msg_12']);
	} 
	else
	{ 
	?>
	singup 
	<?php
	}
	?>"
type="text" onblur="if(this.value==''){this.value='E-mail Address'}"  onfocus="if(this.value=='E-mail Address' || this.value=='Already in use'){this.value=''}" name="email" value="<?php	if(isset($_SESSION['email_check']))
	 { 
		 echo $_SESSION['email_check'];
		 unset($_SESSION['email_check']);
		  
	}elseif(isset($_SESSION['E-mail'])){
		echo $_SESSION['E-mail'];
		unset($_SESSION['E-mail']);
	}
   else
	{
	echo "E-mail Address"; 
	}
	?>"/>

<!--Select Username-->
<input class="<?php 
if(isset($_SESSION['username_check']) || isset($_SESSION['msg_11']))
{
	echo "singup1"; 
	unset($_SESSION['msg_11']);
	} 
	else
	{ 
	?>
	singup 
	<?php
	}
	?>" type="text" onblur="if(this.value==''){this.value='Select Username'}"  onfocus="if(this.value=='Select Username' || this.value=='Already in use'){this.value=''}" name="username" value="<?php		if(isset($_SESSION['username_check']))
	 { 
		 echo $_SESSION['username_check'];
		 unset($_SESSION['username_check']);
		 
	}elseif(isset($_SESSION['user_name'])){
		echo $_SESSION['user_name'];
		unset($_SESSION['user_name']);
	}
   else
	{
	echo "Select Username"; 
	}
	?>"/>

<!--Select Password-->
<input class="<?php 
if(isset($_SESSION['msg_13']))
{
	echo "singup1"; 
	unset($_SESSION['msg_13']);
	} 
	else
	{ 
	?>
	singup 
	<?php
	}
	?>"  type="password" onblur="if(this.value==''){this.value='Select Password'}"  onfocus="if(this.value=='Select Password'){this.value=''}" name="password"   value="Select Password">
<br />
<input class="singupbtn" type="submit" name="signup" value="Sign up!" />

</div>
</form>
<!--Already Member-->
<form action="" method="post" id="frmlogin">
   <div class="already">
	 <h4> Already Member? </h4>
	</div>
   <div class="member"> 
   
	  <!--Select Username-->
		<input class="<?php 
     if(isset($_SESSION['msg_Username']))
     {
	echo "singup1"; 
	unset($_SESSION['msg_Username']);
	} 
	else
	{ 
	?>
	singup 
	<?php
	}
	?>" 
	type="text" onblur="if(this.value==''){this.value='Username'}"  onfocus="if(this.value=='Username'){this.value=''}" name="Username"  value="<?php 
     if(isset($_SESSION['login_Username']))
     {
	echo $_SESSION['login_Username'] ; 
	unset($_SESSION['login_Username']);
	} 
	else
	{ 
	 echo "Username";
	}
	?>" />

		<!--Select Password-->
		<input class="singup required" type="password" onblur="if(this.value==''){this.value='Password'}"  onfocus="if(this.value=='Password'){this.value=''}" name="Password" value="Password" />
		
		<br />
		<input class="singupbtn" type="submit" name="login" value="LOg in!" />
 </div>
 </form>
</div>
<?php 
include('../include/footer.php');
?>

	