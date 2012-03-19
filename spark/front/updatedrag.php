<?php session_start();
	$user_id = $_SESSION['user']['id'];
	include("../include/application.php");
	//$action 				= $_POST['action'];
	$updateRecordsArray 	= $_POST['recordsArray'];
	?>