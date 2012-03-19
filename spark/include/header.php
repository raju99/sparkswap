<?php 
ob_start();
session_start();

ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);

include_once('conn.php');
include_once($DOC_ROOT.'/classes/userClass.php');
include_once($DOC_ROOT.'/classes/inboxClass.php');
include_once($DOC_ROOT.'/classes/adminClass.php');
include_once($DOC_ROOT.'/classes/paginationClass.php');
include_once($DOC_ROOT.'/classes/paginationArray.php');
include_once($DOC_ROOT.'/classes/itemClass.php');
include_once($DOC_ROOT.'/classes/mailerClass.php');
include_once($DOC_ROOT.'/classes/geopluginClass.php');
include_once('functions.php');
$ip=$_SERVER['REMOTE_ADDR'];
?>

<?php
if(isset($_SESSION['previous']))
{
   if(basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) 
   {
	    //session_destroy();
        //### or alternatively, you can use this for specific variables:
        unset($_SESSION['search']);
   }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<script>
URL_SITE='<?php echo $URL_SITE;?>';
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- For Fb share -->
<?php
if($folder[0]=='itemListed.php')
{
	$item_detail=user::mainDetailOfItem($item_id);
	$fetaure_image=itemClass::select_featured_image($item_id);
	?>
		<meta property="og:title" content="<?php  echo $item_detail['item_name'];?>" />
		<meta property="og:description" content="<?php  echo $item_detail['item_description'];?>" />
		<meta property="og:image" content="<?php echo $URL_SITE?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_id?>/<?php echo $fetaure_image['filename'];?>&height=130px&width=200px" />
<?php
} 
?>
<!-- /For Fb share -->
<title>sparx</title>

<link type="text/css" href="<?php echo $URL_SITE;?>/css/style.css" rel="stylesheet"/> 

<link type="text/css" href="<?php echo $URL_SITE;?>/css/themes/base/ui.all.css" rel="stylesheet" />

<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery-1.4.2.js"></script>

<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery.validate.js" language="javascript" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery-validation.js" language="javascript" charset="utf-8"></script>

<script type="text/javascript" language="javascript" charset="utf-8" src="<?=$URL_SITE?>/js/rating.js" type="text/javascript"></script> 

<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery_cycle.js" language="javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/ajax_upload.js" language="javascript" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/ui.core.js" language="javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/ui.datepicker.js" language="javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/datepickertime.js"> </script>
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/action.js" language="javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery.blockUI.js" language="javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery.form.js" language="javascript" charset="utf-8"></script>
<!-- For stripe payment gateway -->
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<!-- For stripe payment gateway -->
<script type="text/javascript">
    // this identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_BfCXxKuFR3D5VfEFnLzUi3jW92HNm');
</script>
<script type="text/javascript">
$(document).ready(function(){

    $(".slidingDiv").hide();
	
	$('.signinnav li a.show').click(function(){
	$(".slidingDiv").slideToggle();
	});

});

$(document).ready(function(){

    $(".dashboardslidingDiv").hide();
	$(".dashboardslidingDiv1").hide();
	$(".dashboardslidingDiv2").hide();
	
	$('.dashboardnav li a.show').click(function(){
		$(".dashboardslidingDiv").slideToggle();
	});
	$('.dashboardnav li a.show1').click(function(){
		$(".dashboardslidingDiv1").slideToggle();
	});
	$('.dashboardnav li a.show2').click(function(){
		$(".dashboardslidingDiv2").slideToggle();
	});
	/*$('.dashboardnav li a.show').click(function(){
		$("#changeheight").addClass("changeheight1");		
		$("#changeheight").removeClass("changeheight");
	});
	$('.dashboardnav li a.show').blur(function(){
		$("#changeheight").addClass("changeheight");		
		$("#changeheight").removeClass("changeheight1");
	});*/

});

</script>
<style>
.msg_style{
border:solid 1px #DEDEDE;
background:#CEE6C3;
color:#222222;
padding:4px;
text-align:center;
}
</style>
</head>
<body onload="initialize()">
<div id="wrapper">
<!--Header-->
<div id="header">		
	<a href="<?php echo $URL_SITE;?>front/index.php"><div class="logo">SparkSwap</div></a>
	
	<?php
	if(isset($_SESSION['user']))			// session on work
	{
	$user_id=$_SESSION['user']['id'];
	?>
			 
			 <div class="signinnav">
				<ul>
				   <li>
						<a href="javascript:;" class="username show fontbld">Hi,&nbsp;<?php echo $_SESSION['user']['user_fname'];?>.</a>
				   </li>            
					   <div class="slidingDiv">
							<ul>
								<li><a href="<?php echo$URL_SITE?>front/home.php">Dashboard</a></li>
								<li><a href="<?php echo $URL_SITE?>front/mySwaps.php?type=listing">Your Swaps</a></li>
								<li><a href="<?php echo $URL_SITE?>front/profile.php">Profile</a></li>
								<li><a href="#">Account</a></li>
								<li><a href="<?php echo $URL_SITE?>front/logout.php">Logout</a></li>
							</ul>
					   </div>
					
					<!--/Sliding Div-->
					<li>
						<a href="<?php echo $URL_SITE?>front/inbox.php" class="email">Email</a>
					</li>
					
					<li id="show_favarites" class="last"> 
						<?php
						if(isset($_GET['item_id']))
						{
								$viewItem ='viewItem.php';
								$item_id=$_GET['item_id'];
								$user_id=$_SESSION['user']['id'];

								if(isset($viewItem))
								{				
								   if(basename($_SERVER['PHP_SELF']) == $viewItem) 
								   {
									   $res_review=user::displayItems($item_id);
									   $row=mysql_fetch_assoc($res_review);
									   //echo $row['owner_id'];
									   //echo $user_id;

									   if($row['owner_id']!=$user_id)
									   {							   
										   $checkfav_res=user::CheckFavourite($item_id,$user_id);
										   $iff_fav=mysql_num_rows($checkfav_res);
										   
										   if($iff_fav > 0)
										   {
										   ?>													
												<a href="javascript:;" class="fav">Favorite</a>					
										   <?
										   }
										   else
										   {?>													
												<a href="javascript:;" class="unfav" onclick="javascript: funMakeFavunFav(1,<?=$item_id?>,<?=$user_id?>);">Favorites</a>											   
										   <?
										   }
									   }
								   }
								}
							}
							?>
							<script language="javascript">
							function funMakeFavunFav(status,itemid,userid)
							{
								var dataAjax = "statusfav="+status+"&itemid="+itemid+"&userid="+userid;

								if(confirm("This Action cannot be undone. Are you sure you want to Perform this action!"))
								{
									$.ajax({
									type: "POST",
									data: dataAjax,
									url: URL_SITE+"/front/actionAjax.php",																											
									success: function(msg)
									{	
										$("#show_favarites").html(msg);
										//$("#show_favarites_hide").hide();
									}
									});	
								}
								else
								{
									return false;
								}
							}
							</script>
					</li>	
			  </ul>
		</div>
		<?php
			
		}
		else// session is sleeping
		{
		?>
			<div class="navigation">
					<!--Logo-->
					<ul>
						 <li>
							<a href="<?php echo $URL_SITE?>/front/userRegistration.php">Sign up </a>
						 </li> 
						 <li> 
							<a href="<?php echo $URL_SITE?>/front/login.php">Log in </a>
						 </li> 
						 <li class="last"> 
							<a href="<?php echo $URL_SITE;?>front/howItWorks.php"> How it works </a>
						 </li> 
					</ul>
					<!--Logo-->
			</div>

		<?php
		}
		?>

		<div class="listbtn">
			<input onclick="javascript:rediretc();" class="list" type="button" name="list an item" value=" List an Item "  />
			<script>
			function rediretc()
			{
				location.href='<?php echo $URL_SITE?>/front/addItem.php';
			}
			</script>
		</div>

</div>
<!-----/header----->

<!--Content-------->
<div id="container">
<?php
if(isset($_SESSION['msg']))
{?>
<?php $msg_main=$message[$_SESSION['msg']];?>
	<script>
		msg_show('<?php echo $msg_main;?>');
	</script>
<?php	unset($_SESSION['msg']);
} ?>
<?php
if(isset($_SESSION['MSG']))
{?>
	<?php $msg_main=$message[$_SESSION['MSG']];?>
	<script>
		msg_show('<?php echo $msg_main;?>');
	</script>
<?php unset($_SESSION['MSG']); } ?>

<?php
if(isset($_SESSION['user']) and $folder[0]!='itemListed.php' and $folder[0]!='index.php' and $folder[0]!='searchListing.php' and $folder[0]!='viewItem.php' and $folder[0]!='itemForRent.php' and $folder[0]!='addItem.php') // session on work and this is not required for some pages
{
?>
<div class="Dashboarddiv">
 <!--Dashboard Navigation-->
 
		<div class="dashboardnav">
		<!--<div id="changeheight" class="changeheight">-->
		<ul>
				<li class="<?php if($folder[0]=='home.php'){?>current<?php } ?>"><a href="<?php echo$URL_SITE?>front/home.php">Dashboard</a></li>
				<li class="<?php if($folder[0]=='inbox.php'){?>current<?php } ?>"><a href="<?php echo $URL_SITE;?>front/inbox.php">Inbox</a></li>
				<li class="<?php if($folder[0]=='mySwaps.php'){?>current<?php } ?>"><a href="#" class="show">Your Swaps</a></li>
				<div class="dashboardslidingDiv">
					<div class="wdthpercent100"><ul>
						<li><a href="<?php echo $URL_SITE?>front/mySwaps.php?type=listing&listing_items=all">My Listings | Manage Listings</a></li>
						
						<li><a href="<?php echo $URL_SITE?>front/mySwaps.php?type=reservation">My Reservations</a></li>
						<li><a href="<?php echo $URL_SITE?>front/mySwaps.php?type=policy">Policies</a></li>
						<li><a href="<?php echo $URL_SITE?>front/mySwaps.php?type=requirements">Requirements</a></li>                                    
					</ul>
					<br class="clear" />
					</div>
					<div class="wdthpercent100">
					<ul>
						<li ><a href="<?php echo $URL_SITE?>front/mySwaps.php?type=myRents">My Rentals | Current</a></li>
						
						<li><a href="<?php echo $URL_SITE?>front/mySwaps.php?type=upcoming">Upcoming</a></li>  
						<li><a href="<?php echo $URL_SITE?>front/mySwaps.php?type=previous">Previous</a></li>  
						<li><a href="<?php echo $URL_SITE?>front/mySwaps.php?type=starlisting&listing_items=all" class="staritem">Starred Items</a></li>
					</ul>
					<br class="clear" />
					</div>
				</div>

				<li class="<?php if($folder[0]=='profile.php'){?>current<?php } ?>"><a href="javascript:;" class="show1">Profile</a></li>                            
				<div class="dashboardslidingDiv1">
					<ul>
						<li><a href="<?php echo $URL_SITE?>front/profile.php">Edit Profile</a></li>
						<li><a href="<?php echo $URL_SITE?>front/verification.php">Trust and Verification</a></li>
						<li><a href="<?php echo $URL_SITE?>front/reviews.php?type=reviewabout">Reviews</a></li>
						<li><a href="<?php echo $URL_SITE?>front/privacy.php">Privacy</a></li>                                    
					</ul>
				</div>

				<li class="<?php if($folder[0]=='acounts.php'){?>current<?php } ?>"><a href="javascript:;" class="show2">Accounts</a></li>
				<div class="dashboardslidingDiv2">
					<ul>
						<li><a href="<?php echo $URL_SITE;?>front/acounts.php?type=noti">Notifications</a></li>
						<li><a href="<?php echo $URL_SITE;?>front/acounts.php?type=payout">Payout Preferences</a></li>
						<li><a href="<?php echo $URL_SITE;?>front/acounts.php?type=transaction&t=renterTransaction">Transaction History</a></li>
						<li><a href="<?php echo $URL_SITE;?>front/acounts.php?type=settings">Settings</a></li>                                   
					</ul>
				</div>
			</ul>   
			<!--</div>-->                     
		<br class="clear" />
		</div>

<!--Dashboard Navigation-->

<?php
}
?>
