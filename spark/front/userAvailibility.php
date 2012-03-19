<?php
include_once("../include/conn.php");
ob_start();
session_start();

//value got from the get method

if(isset($_GET['cur_pass']))
{
	$cur_passwd=md5($_GET['cur_pass']);
	$user_id=$_SESSION['user']['id'];

	$sql = "Select * from user where id='".$user_id."'";
	$select=mysql_query($sql)or die('Error'.mysql_error());
	$record=mysql_fetch_array($select) ;

	if($record['user_password']==$cur_passwd)
	{
		//current pass matches entered pass
		 echo  'true';
	} 
	else
	{
		//current pass doenot matches entered pass
		 
		 echo  'false';
	}
}


if(isset($_GET['payout_email']))
{
	$payout_email=$_GET['payout_email'];

	$sql = "Select * from payout_preferences where payout_email='".$payout_email."'";
	$select=mysql_query($sql)or die('Error'.mysql_error());
	$record=mysql_num_rows($select) ;

	if($record > 0)
	{
		//current pass matches entered pass
		 echo  'false';
	} 
	else
	{
		//current pass doenot matches entered pass
		 
		 echo  'true';
	}
}
?>