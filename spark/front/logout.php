<?php
ob_start();
session_start();
include("../include/config.php");

	session_destroy();
	session_start();
	$_SESSION['succ_msg'] = 'You are successfully logged out';

	if(isset($_GET['msg'])) 
	{ 		
		$_SESSION['msg']=23;
		header("location:login.php"); 
		exit;
	} 
	else
	{
		header('location:login.php');
		exit;
	}	
?>