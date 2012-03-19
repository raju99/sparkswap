<?php
$basedir=dirname(__FILE__)."../../";
$item_id=$_GET['item'];
include($basedir.'/include/header.php');
if(!isset($_SESSION['user']))
{
	header("location:".$URL_SITE."front/login.php");
}

$share= urlencode($URL_SITE.'front/viewItem.php?item_id='.$item_id);
//echo '<pre>';
//print_r($item_detail);
//echo '</pre>';
?>
<!-- Facbook share code -->
<a ></a> 
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>

<!--/Facbook share code -->
<div class="containersearch pB20">
	   <!--Confirm top -->
<div class="confirmtop">
 <h2> Congratulations </h2>
</div>
  <!--/Confirm top -->
 
<div class="confirmcontainer">
	<h4 class="font14 fontbld txtleft pB10"> 	Congratulations! You are all set to rent! </h4>
		<div class="clear"> </div>
		<div class="confirmcontainerpic">
			<img src="<?php echo $URL_SITE?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_id?>/<?php echo $fetaure_image['filename'];?>&height=130px&width=200px"/>
		</div>
	<h4 class="font14 txtleft fontnormal"> 
	You can track your rental in <a href="<?php echo $URL_SITE;?>front/mySwaps.php?type=listing"> My Swaps </a> . </h4>

</div>
	
 <div class="confirmcontainerR">
	   <h2 class="font14 fontnormal"> Share your swap with friends: </h2>	   
	   <div class="clear"> </div>	   
	   <a method=feed name="fb_share" href="javascript:;" type="button" share_url="<?php echo $share;?>"> Share </a>
 </div>
	 
	
</div>	
<?php
include($basedir.'/include/footer.php'); ?>