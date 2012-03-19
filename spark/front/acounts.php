<?php 
/******************************************
* @modified on march 14,2012
* @Package: Maduhaa
* @Developer: Praveen Singh
* @URL : http://www.maduhaa.com
********************************************/

$basedir=dirname(__FILE__)."../../";	
include_once($basedir.'/include/header.php');

if(!isset($_SESSION['user']['id']))
{
	header("location:".$URL_SITE."front/login.php");	// session is not set
}
?>

<!-- NOTIFICATION START----------->
<?php
if($_GET['type']=='noti')
{
	$noti=user::select_notification($user_id);
	
	if(isset($_POST['save']))
	{
		$string='';
		
		if(isset($_POST['email']))
		{
			$string.="email=1,";

		}
		else
		{
			$string.="email=0,";
		}
		if(isset($_POST['upcoming_rental']))
		{
			$string.="upcoming_rental=1,";
		}
		else
		{
			$string.="upcoming_rental=0,";
		}
		if(isset($_POST['rental_request']))
		{
			$string.="rental_request=1,";
		}
		else
		{
			$string.="rental_request=0,";
		}
		if(isset($_POST['review']))
		{
			$string.="new_review=1";
		}
		else
		{
			$string.="new_review=0";
		}
		if($string!='')
		{
			$affected=user::update_settings($user_id,$string);
		}
		
		$_SESSION['msg']='2';
		header('location:'.$URL_SITE.'front/acounts.php?type=noti');
	}
	?>
		<!--Dashboard Content-->
		<div class="wdthpercent100">
			<div class="dashwhitebg">
					<div class="dashprivacyprofile">
							<form name="" action="?type=noti" method="post">
							
								<div class="bdrbtmgrey pB15">
									<h4 class="verified">E-Mail Notifcations</h4>
											 <p>Send me e-mails when:</p> 
											 <p class="pL15 pT10"><input <?php if($noti['email']==1){echo 'checked="checked"';}?> name="email" type="checkbox" /> &nbsp;SparkSwap has new deals, listings, or news to share with me</p> 
											 <p class="pL15 font12 color2">No spam! We promise.</p>
									<br class="clear" />
								 </div>
								 
								 <div class="wdthpercent100 pT15">
									 <p>Send me reminders when:</p>
									 
									 <p class="pL15 pT10">
										 <input <?php if($noti['upcoming_rental']==1){echo 'checked="checked"';}?> name="upcoming_rental" type="checkbox"/> &nbsp;I have an upcoming rental
										 
										 <br />                                 
										 
										 <input name="rental_request" <?php if($noti['rental_request']==1){echo 'checked="checked"';}?> type="checkbox" /> &nbsp;I have received a new rental request<br />
										 
										 <input name="review" <?php if($noti['new_review']==1){echo 'checked="checked"';}?>  type="checkbox" /> &nbsp;I have received a new review
									 </p>
									 
									 <p class="pL15 font12 color2">Reminders help ensure the rental process run more smoothly. It is highly recommended you leave these reminders turned on.</p>
									 
									 <p class="pT10 right"><input type="submit" name="save" value="Save" class="profilehbutton" /></p>
									 
									 <br class="clear" />

								 </div>	 

								
							<form>
					</div>
			</div>
		</div>
		<!--/Dashboard Content-->
<?php
}
?>
<!-- /NOTIFICATION ENDS ----------->



<!-- PAYOUT START ----------------->
<?php
if($_GET['type']=='payout')
{
	include($DOC_ROOT.'front/PayoutPreferences.php');
}
?>
<!-- /PAYOUT ENDS ----------------->



<!-- TRANSACTION HISTORY START ----------->
<?php
if($_GET['type']=='transaction')
{
	include($DOC_ROOT.'front/transaction.php');
}
?>
<!-- /TRANSACTION HISTORY ENDS ----------->


<!-- SETTINGS START ----------->
<?php
if($_GET['type']=='settings')
{
	include($DOC_ROOT.'/front/settings.php');	
}
/*
else
{
	$_SESSION['msg']='3';	
}*/
?>
<!-- /SETTINGS ENDS ----------->
