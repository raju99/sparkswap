<?php
// FIle is used as header part to include files in different Congratulation and action part of sites
ob_start();
session_start();
include ('../include/conn.php');
include($DOC_ROOT.'/classes/userClass.php');
include($DOC_ROOT.'/classes/inboxClass.php');
include($DOC_ROOT.'/classes/itemClass.php');
include($DOC_ROOT.'/include/functions.php');
include_once('functions.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link type="text/css" href="<?php echo $URL_SITE;?>/css/style.css" rel="stylesheet"/> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Spark Swap</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/ui.datepicker.js" language="javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/action.js" language="javascript" charset="utf-8"></script>

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
</head>
<body>
   <!--Wrapper-->
    <div id="wrapper">
	
	  <!--Header-->
	  <div id="header">
	   <!--Logo-->
	   <a href="<?php echo $URL_SITE?>"><div class="logo"> SparkSwap </div></a>
	   
	   <div class="navigation">
	    <?php
	if(isset($_SESSION['user']))			// session on work
	{
		$user_id=$_SESSION['user']['id'];
	?>
<div class="signinnav">
	     <ul>
		   <li><a href="#" class="username show">Hi, <?php echo $_SESSION['user']['user_fname'];?>.</a> </li>            
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
		   <li><a href="<?php echo $URL_SITE?>front/inbox.php" class="email">Email</a> </li> 
		   <li class="last"><a href="<?php echo $URL_SITE?>/front/favourite.php" class="fav">Favorites</a> </li> 
		  </ul>
</div>
<?php
	
}
else							// session is sleeping
{
?>


<div class="navigation">
<!--Logo-->

<ul>
<li> <a href="<?php echo $URL_SITE?>/front/userRegistration.php">Sign up </a> </li> 
<li> <a href="<?php echo $URL_SITE?>/front/login.php">Log in </a> </li> 
<li class="last"> <a href="<?php echo $URL_SITE;?>front/howItWorks.php"> How it works </a> </li> 
</ul>
</div>

<?php
	}
?>
</div>
<div class="listbtn">
	<input class="list" type="button" name="list an item" value=" List an Item "  />
</div>
</div>	
  <div id="container">
			
			 