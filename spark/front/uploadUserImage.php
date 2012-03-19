<?php
include('../include/actionHeader.php');
if(!isset($_SESSION['user']['id']))
{
	header("location:".$URL_SITE."front/login.php");
}

$user_id=$_SESSION['user']['id'];
if(isset($_POST['upload']))
{
	if(!empty($_FILES['file']['name']))
		{



				$filename=basename($_FILES['file']['name']);
				$strpos=strpos($filename,'.');
				$ext=substr($filename,$strpos); 
				$imagename=uniqid().$ext;
				$uploaddir=$DOC_ROOT.'/images/profile/';
				$uploaddir3=$uploaddir.'/'.$imagename;	
				
				if(move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir3))
				{
						
					 $result=user::updateUserImage($user_id,$imagename);
					 
					$_SESSION['msg']="8";
				}
				else
				{
					$_SESSION['msg']="9";
				}
		}
		
		 //header("location:".$URL_SITE."front/profile.php");
}
?>