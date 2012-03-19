<?php
ob_start();
session_start();

include('../include/conn.php');
include('../classes/userClass.php');
if(isset($_REQUEST['email']))
{
 $email_id=$_REQUEST['email'];
 $count=user::checkEmail($email_id);
if($count!=0)
{
 echo 'false';
}
else
{
 echo 'true';
}
}



if(isset($_GET['item_id']))
{
$item_id=$_GET['item_id'];
$user_id=$_GET['user_id'];

$result=user::addToFavourite($item_id,$user_id);
if($result)
	{
	echo "you have already add this item to your favourite";
	}
	else
	{
	echo "this item is added to your favourite";
	}


}

if(isset($_GET['reserve_id']))
{
$item_id=$_GET['reserveitem_id'];

$action=$_GET['action'];
			$result=user::changeitemStatus($item_id,$action);
		

if($result)
	{
	echo "you have already add this item to your favourite";
	}
	else
	{
	echo "this item is added to your favourite";
	}


}
if(isset($_REQUEST['username']))
{
	 $u=$_REQUEST['username'];
	 $yes=user::checkusername($u);

	if($yes!=0)
	{
		echo 'false';
	}
	else
	{
		echo 'true';
	}
}


?>
