<?php
$basedir=dirname(__FILE__)."../../";	
include $basedir.'include/header.php';

$latest_item=itemClass::select_latest_item();
$feture_image=itemClass::select_featured_image($latest_item['id']);

$user=user::user_profile($latest_item['owner_id']);
$riew=itemClass::viewReview($latest_item['id']);
$riew=mysql_num_rows(mysql_query($riew));
?>

<!--Content Left-->
<div class="contentL">
		<form id='' method="POST" action ="searchListing.php" >
			
			<h2> Rent Anything! </h2>
			
			<h4 class="pT15 pB15"> Rent with ease. We'll take care of the details! </h4>
							
			<div class="submit">

				<input class="need" type="text" name="word" onclick="if(this.value=='What do you need?'){this.value=''}" onblur="if(this.value==''){this.value='What do you need?'}"value="What do you need?" />

				<div class="wdth278">
					<input class="zip mR20 " type="text" name="zip" 
					onclick="if(this.value=='Zip code'){this.value=''}" onblur="if(this.value==''){this.value='Zip code'}" value="Zip code" />
					<input class="search" type="submit" name="search" value="search " />
				</div>

			</div>

			<div class="submit wdth117">
			 <b>  Pick up </b>
			  <input class="date" type="text" name="Pickup"onclick="if(this.value=='mm/dd/yyyy'){this.value=''}" onblur="if(this.value==''){this.value='mm/dd/yyyy'}"value="mm/dd/yyyy" id="from_searchlist"/>
			</div>
			  
			<div class="submit wdth117 mL20">
			  <b>  Drop off </b>
			  <input class="date" type="text" name="Dropoff" onclick="if(this.value=='mm/dd/yyyy'){this.value=''}" onblur="if(this.value==''){this.value='Zip code'}"value="mm/dd/yyyy" id="to_searchlist"
			  />
			</div>
	  </form> 
</div>
<!--/Content Left-->

<!--Content Right-->
<div class="contentR">
 <div class="profile">
   <div class="pic">
	<img src="<?php echo $URL_SITE ;?>classes/show_image.php?filename=../images/itemimages/<?php echo $latest_item['id'].'/'.$feture_image['filename'];?>&width=350px&heigth=220px" alt="" />
   </div>
   
	<div class="profilepic mT5">
	   <img src="<?php echo $URL_SITE ;?>classes/show_image.php?filename=../images/profile/<?php echo $user['user_picture'];?>&width=73px&heigth=72px" alt="no image"/>
	</div>
	
	<div class="addresh mT5">
	 <h3> <a class="colororange" href="<?php echo $URL_SITE;?>/front/viewItem.php?item_id=<?php echo $latest_item['id'];?>"><?php echo $latest_item['item_name'] ?></a> <span class="black"> - <?php echo $latest_item['city'].' '.$latest_item['state'];?> </span> </h3> 
	 <h4>  $<?php echo $latest_item['item_Price'];?> / Day  <br /> <?php echo $riew;?> Reviews </h4>
  </div>
</div>
</div>
<!--/Content Right-->
<!--Container Bottom-->
<div id="cotainerbottom">
 <div class="adds">
 <input class="addsbtn" type="button" name="Find Out" value="Find Out " />
   <h4>  How much is my item worth?? </h4>
   
 </div>
</div>
<!--/Container Bottom-->
<?php
include $basedir.'include/footer.php';
?>