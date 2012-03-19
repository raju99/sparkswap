<?php
ob_start();
session_start();
if(!isset($_SESSION['a_info']['id']))
{
	$_SESSION['error_msg'] = 'You are not logged in';
	header("location:index.php");
	exit;
}
if(isset($_SESSION['a_info']['id']))
{
	session_destroy();
	
	session_start();
	$_SESSION['succ_msg'] = 'You are successfully logged out';
	header("location:index.php");
	exit;
}
?>