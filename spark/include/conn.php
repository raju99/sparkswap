<?php
$conn=mysql_connect("localhost","root","idea99")or die('could not connect'.mysql_error());

$selectdb=mysql_select_db("sparx",$conn)or die('database dont exist'.mysql_error());

$DOC_ROOT=$_SERVER['DOCUMENT_ROOT'].'/spark/';

$URL_SITE='http://192.168.0.18/spark/';

$google_api_key='AIzaSyC9B94PKFCBtfDjddMWMdpbUnj9GXa6TC8';

$stipe_key='CauEXzEEkL3JVB8pw4hUPE98Np6C9SO1';

//$URL_SITE="http://localhost//"; 

$message=array
( // all messages to be shown
'0'=>'Settings Has Been Saved',
'1'=>'Email Already Present',
'2'=>'Settings Saved',
'3'=>'Might be in wrong location',
'4'=>'You are successfully Registered',
'5'=>"item is successfully updated",
'6'=>'Privacy settings has been saved',
'7'=>'Your profile has been successfully updated',
'8'=>'Your picture has been successfully updated',
'9'=>'Your picture not updated',
'10'=>'Invalid email address',
'11'=>'Please enter Your Username',
'12'=>'Please enter Your E-mail Address',
'13'=>'Please enter Your password',
'14'=>"your request for this item has been sent to owner he will contact you early",
'15'=>'You have already take action for this item',
'16'=>'You have already take action for this item',
'17'=>'Your Rent Request is Confirmed.',
'18'=>'Your Rent Request is Denied.',
'19'=>'Payment has been done',
'20'=>'Reviews has been saved',
'21'=>'Request has been denied',
'22'=>'Password has been changed',
'23'=>'You have canceled your Account',
'24'=>'Payout Information succussfully Inserted'
);

$app_id='336523539720022';
$secret_id='74415ac3352c854144518c58fc7d677b';

$folder=$_SERVER['PHP_SELF'];
$folder=explode('/',$folder);
$folder=array_reverse($folder);

$from_name='Admin Spark Swap';
$from_email='admin@admin.com';
?>