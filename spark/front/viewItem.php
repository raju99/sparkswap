<?php
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);

include('../include/header.php');

if(isset($_REQUEST['item_id']))
{
  $item_id=$_REQUEST['item_id'];
}
 $allItemdetail=user::mainDetailOfItem($item_id);

 $countreview=itemClass::countReview($item_id);
$res_review=itemClass::select_reviews($item_id);
 $reviewResult=itemClass::averageReview($item_id);

 $featurimage=itemClass::select_featured_image($item_id);
 $allrow=user::selectItemImages($item_id);

 $sql=itemClass::allReviewOfItem($item_id);
 $exsql=mysql_query($sql);
 $longitude=$allItemdetail['longitude'];// for google map
$latitude=$allItemdetail['latitude'];// for google map
 $limit=3; // limit to show number of reviews in a page
if(isset($_GET['page']))
{
	$page=$_GET['page'];
}
else
{
	$page=1;
}
if($countreview)
{
	while($row=mysql_fetch_assoc($res_review))
	{
		$review_array[]=$row;  // array of all reviews did by some one on this item
	}
	//print_r($review_array);
	$start_record=$limit*($page-1);
	$end_record=$limit*$page;
	$output_array = array_slice($review_array, $start_record, $end_record);
	$count_output_array=count($output_array);
	
	$divide=$countreview/$limit;
}


?>
	<div id="message">
	<?php
if(isset($_SESSION['MSG']))
{

echo $_SESSION['MSG'];
unset($_SESSION['MSG']);
}
?>
</div>

 <div class="containersearch">
			  
			  <!--containertop-->
			   <div class="itemtop">
			     <div class="back pL20 left fontbld font12">  
				<a href='<?php echo $URL_SITE?>front/searchListing.php'>  Back to search </a>  
				 </div>
				   <div class="right">
					<a href="<?php echo $URL_SITE;?>front/inbox.php"><img src="<?php echo $URL_SITE?>images/msg.png" /></a>
				   </div>
			  </div>
			  
			  <!--rightdiv-->
			  <div class="wdth154 right">
			        <div class="bluebtn"> <a href="feedback.php?item_id=<?php echo $item_id; ?>" ><?php echo $countreview; ?></a>
					   <h5> Reviews </h5> 
					  </div>
					  <div class="orangebtn"> S 
						 <h5> Super Renter </h5>
					  </div>
					 
			    </div>
				 <!--/rightdiv-->
				
				
			  <div class="itemL">
			     <div class="pL5 ">
			        <h3><?=ucwords($allItemdetail['item_name']);?></h3>
				    <h4><?=ucwords($allItemdetail['item_subtitle']);?></h4>
			     </div>
				 <div class="clear pB10"></div>

			     <div class="pL5 bluelink">
					<?php
					if(isset($_SESSION['user']))
					{
						if($allItemdetail['id']!=$_SESSION['user']['id'])
						{
						?>
							<a class="fontbld" href="itemForRent.php?item_id=<?php echo $allItemdetail['item_id'] ;?>&user_id=<?php echo $allItemdetail['owner_id']; ?>">Rent this item</a>
						<?
						}
					}
					else
					{?>				
						<a class="fontbld" href="itemForRent.php?item_id=<?php echo $allItemdetail['item_id'];?>">Rent this item</a>
				    <?
					}
					?>
				</div>
		
				<!--thumbnail-->
				<div class="itemthumbnail">
				  <div class="itemnav">
				    <ul>
					  <ul>
					  <li> <a href="javascript:;" onclick="view_item_tab('photo','map','calender')"> Photo  </a> </li>
					  <li> <a href="javascript:;" onclick="view_item_tab('map','calender','photo')"> Map  </a> </li>
					  <li > <a href="javascript:;" onclick="view_item_tab('calender','photo','map')"> Calender  </a> </li>
					</ul>
					</ul>
					  <a class="right" href="#"> <img src="<?php echo $URL_SITE;?>/images/flag.gif" /> </a>
				  </div>
				  <div class="clear"></div>
				  
				  <div id="photo">
				  <div class="thumbnailimg" id="slideshow">
				  <?php  while($item_images=mysql_fetch_assoc($allrow))
				  //print_r($item_images);
					 {?>
						
						<img src="<?php echo $URL_SITE ;?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_id ?>/<?php echo $item_images['filename']?>&width=378px&height=180px"/>
						
                     <?php
					 }
					  ?>
				  
				   </div>
				   <div class="thumnail" id="view_thumnail">	              
				   
				</div>

				<script>
					$('#slideshow').after('<ul id="nav">').cycle({ 
					fx:     'turnDown', 
					speed:  'fast', 
					timeout: 0, 
					pager:  '#nav', 

					// callback fn that creates a thumbnail to use as pager anchor 
					pagerAnchorBuilder: function(idx, slide) { 
					return '<li><a href="#"><img src="' + slide.src + '" width="50" height="50" /></a></li>'; 
					} 
					});
				</script>
			</div>
	<!-- to show map -->
		<div style="display:none" id="map" >

		<div id="map_canvas" style="height:180px;width:378px"></div>
		<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=<?php echo $google_api_key;?>&sensor=true" type="text/javascript"></script>
		<script type="text/javascript">

		function initialize() {
		if (GBrowserIsCompatible()) {
		var map = new GMap2(document.getElementById("map_canvas"));
		map.setCenter(new GLatLng(<?php echo $latitude?>, <?php echo $longitude?>), 13);
		map.setUIToDefault();
		var bounds = map.getBounds();
		var southWest = bounds.getSouthWest();
		var northEast = bounds.getNorthEast();
		var lngSpan = northEast.lng() - southWest.lng();
		var latSpan = northEast.lat() - southWest.lat();

		var point = new GLatLng(southWest.lat() + latSpan * Math.random(),
		southWest.lng() + lngSpan * Math.random());
		map.addOverlay(new GMarker(point));
		map.setCenter(point, 15);


		}
		}

		</script>

		</div>
	<!--/ to show map -->
	<!-- to show calender -->
	<div style="display:none" id="calender">
		<?php $item_detail=itemClass::collect_booking_dates($item_id);
		
			$disable_dates_all='';
			  while($row=mysql_fetch_assoc($item_detail))
			  {
				  //print_r($row);
				  if($row['newissuedate']!=='0000-00-00')
				  {
					$startDate=$row['newissuedate'];
					$endDate=$row['newienddate'];
				  }
				  else{
					$startDate=$row['issue_date'];
					$endDate=$row['end_date'];
				  }
				  $date=getDatesBetween2Dates($startDate,$endDate);
				  foreach($date as $allDate)
				  {
					 //print_r($allDate);die;
					    $disable_dates_all .= '[';
						$disable_dates_all .= $allDate;						
						$disable_dates_all .= '],';
				  }
					
			  }
			   
		$disable_dates_all = substr($disable_dates_all,0,-1) ;	
		 //print_r($disable_dates_all);
			
		?>
		<script>
			var unavailableDates  = [<?php echo $disable_dates_all;?>];

	/* utility functions */
	function unavailable(date) {
    dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
    if ($.inArray(dmy, unavailableDates) == -1) {
        return [true, ""];
    } else {
        return [false,"","Unavailable"];
    }
}


	/* create datepicker */
	jQuery(document).ready(function() {
	  jQuery('#calender').datepicker({
		minDate:0,
		dateFormat: 'DD, MM, d, yy',
		constrainInput: true,
		beforeShowDay: unavailable,
	  });
	});
		
	</script>
	</div>
<!--// to show calender -->
 </div>
			<!--/thumbnail-->
				  
				<!--description-->
				<div class="description"> 
				<div class="itemnav">
				    <ul>
					  <ul>
					  <li> <a href="javascript:; "id="dec"> Description  </a> </li>
					  <li> <a href="javascript:;" id="pickup">Pickup Details  </a> </li>
					 </ul>
					 </ul>
				 </div>
				 <div class="mL10 mR10 left">
				   <div class="txtb"  id="description">  
                              <?php echo   $allItemdetail['item_description']; ?>
					</div>
				<div style="display:none" id="pickupdetial" >
					  <?php 
					  $result=user::pickupDetails($allItemdetail['item_id']);
					  $pickup_count=mysql_num_rows($result);
					  if($pickup_count>0)
					  {
						  $pikup_row=mysql_fetch_assoc( $result);
					 
					  }
					  
					  $exsql=user::select_settings_for_user($allItemdetail['id']);
					  $setting_count=mysql_num_rows($exsql);
					  if($setting_count>0)
					  {
						$check=mysql_fetch_assoc($exsql);
						if($check['phone']=='1')
						  {
							echo "Renters Must verify their phone number.";
						  }
						  if($check['profile']=='1')
						  {
							  echo "<br>Renters Must have a profile picture.";
						  }
						  if($check['persona_desc']=='1')
						  {
							  echo "<br>Renters must provide a personal desciption.";
						  }
						  if($allItemdetail['pickup'])
						  {
							echo'<br>Renter Must pick up this item';
						  }
						   if($allItemdetail['dropoff'])
						  {
							echo'<br>Renter Must drop off this item';
						  }
						  
						 
					  }
					  ?>
					</div>
				 </div>
			  </div>
				 <!--description-->
				 <div class="description">
				   <div class="itemnav">
				    <ul>
					 <li> <a href="javascript:;" id="reviewdetail"> Reviews (<?php echo $countreview; ?>)  </a> </li>
					  <li> <a href="javascript:;"id="friend">Friends (1) </a> </li>
					 </ul>
				 </div>
				 
				 
				  <div class="overall">
				    <h3> Over All </h3>
					<div class="star">
					  <ul>
					   <?php for($i=1;$i<=$reviewResult['overall'];$i++)
					  {
						  ?>
					    <li> <img src="<?php echo $URL_SITE?>/images/star_2.png" /> </li>
						<?php
					  }
                        for($j=$i;$j<=5;$j++)
						{
						  ?>
						 <li> <img src="<?php echo $URL_SITE?>/images/star_gry_2.png" /> </li>
						 <?php
						}
						 ?>
					  </ul>
					</div>
				</div>
				<!--/description-->
				    <!--overall Right-->
					<div class="overallR">
					<!--Accuracy-->
					  <div class="Accuracy">
					   
					 
					    <div class="starsmall right">
					        <ul>
					<?php
					
					for($i=1;$i<=$reviewResult['accuracy'];$i++)
					  {
						  ?>
					    <li> <img src="../images/star_2.png" /> </li>
						<?php
					  }
						 for($j=$i;$j<=5;$j++)
						{
						  ?>
						 <li> <img src="../images/star_gry_2.png" /> </li>
						 <?php
						}
						 ?>
						  </ul>
					  </div>
					   <p class="font14 fontbld right">Accuracy </p>
					</div>
					  
					  <!--Communication-->
                    <div class="Accuracy">
					    
					 
					    <div class="starsmall right">
					       <ul>
							<?php for($i=1;$i<=$reviewResult['communication'];$i++)
					  {
						  ?>
					    <li> <img src="../images/star_2.png" /> </li>
						<?php
					  }
						for($j=$i;$j<=5;$j++)
						{
						  ?>
						 <li> <img src="../images/star_gry_2.png" /> </li>
						 <?php
						}
						 ?>
					   </ul>
					  </div>
					  <p class="font14 fontbld right">Communication </p>
				 </div>
					  
					  <!--Value-->
					 <div class="Accuracy">
					   
					 
					    <div class="starsmall right">
					      <ul>
					     <?php for($i=1;$i<=$reviewResult['rating'];$i++)
					  {
						  ?>
					    <li> <img src="../images/star_2.png" /> </li>
						<?php
					  }
						 for($j=$i;$j<=5;$j++)
						{
						  ?>
						 <li> <img src="../images/star_gry_2.png" /> </li>
						 <?php
						}
						 ?>
					   </ul>
					  </div>
					    <p class="font14 fontbld right"> Value </p>
				</div>
				<div class="clear"> </div>
				
				   </div>
					<div id="ajaxReview">
					   <!--Reviews container-->
					   <?php
					   if(isset($count_output_array) and $count_output_array>0 )
					   {
					  foreach($output_array as $row)
					   {
						   $user_profile=user::user_profile($row['user_id'])
						   ?>
					     <div class="itemprofile">
						   <div class="itemprofileL">
						   
							   
							
						    <img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/profile/<?php echo $user_profile['user_picture'] ;?>&height=67px&width=47px" alt="no picture"/>
							
						
						      <h5> <?php echo $user_profile['user_fname'] ;?> </h5>
							</div>
							 
							 <div class="itemprofileR">
							   <div class="txtb"><?php echo $row['reviews'] ;?> </div>
                                </div>
							</div>
							<?php
					        }
	                      ?>
							 
<div class="itembottom reviewlisting">
<ul>
 <?php if($page!=1){?>
 <li> <a class="" href="javascript:;" onclick="pagination_item_page(<?php echo ($page-1);?>,<?php echo $item_id;?>)">Previous</a> </li>
 <?php }?>
	<li> <a class="" href="javascript:;" onclick="pagination_item_page(<?php echo ($page);?>,<?php echo $item_id;?>)" name="button"><?php echo $page;?></a></li>
<?php if($divide>$page){?>
	<li><a class="" href="javascript:;" onclick="pagination_item_page(<?php echo ($page+1);?>,<?php echo $item_id;?>)"><?php echo $page+1;?></a></li>
	<li> <a class=" " href="javascript:;" onclick="pagination_item_page(<?php echo ($page+1);?>,<?php echo $item_id;?>)">next</a></li>

	<?php }

?>
<span style="display:none" id="loding">Loding.....</span>
</ul>
</div> 
<?php
}else{?>
<div class="itemprofile"> No review
</div>
<?php
}

?>
						</div><!--/ajaxReview -->
				</div>
			</div>
		</div>
<script>
		function addToFavourite()
		{
			var item_id="<?php echo $item_id; ?>";
			var query="<?php echo $_SESSION['user']['id'] ; ?>";

			jQuery.ajax({
				type: "GET",
				url: "checkEmail.php?item_id="+item_id+"&user_id="+query,
                
				success: function(msg){
				
				jQuery("#message").html(msg);
				}
				});
			
		}
</script>
<?php 
include("../include/footer.php");
?>						