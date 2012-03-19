<?php
include('../include/header.php');
if(isset($_REQUEST['item_id']))
{
  $item_id=$_REQUEST['item_id'];
}
 $allItemdetail=user::mainDetailOfItem($item_id);

 $countreview=itemClass::countReview($item_id);

 $reviewResult=itemClass::averageReview($item_id);

 $featurimage=itemClass:: select_featured_image($item_id);
 $allrow=user::selectItemImages($item_id);

 $sql=itemClass::allReviewOfItem($item_id);
 
	$objPagination=new Ps_Pagination($conn, $sql, 5, 5);
	$exsql =$objPagination->paginate();
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
			     <div class="back pL20 left">  
				 <a href='<?php echo $URL_SITE?>front/searchListing.php'>  Back to search </a>  
				 </div>
				   <div class="right">
				   <?php
				   if(isset($_SESSION['user']))
				   {
					   if($allItemdetail['id']!=$_SESSION['user']['id'])
					   {
				   ?>
				   <!-- <a href="sendMessage.php?item_id=<?php echo $allItemdetail['item_id'] ;?>&user_id=<?php echo $allItemdetail['id']; ?>"> --> <img src="../images/msg.png"  /> <!-- </a> --> 
				   <a href="feedback.php?item_id=<?php echo $allItemdetail['item_id'] ;?>&user_id=<?php echo $allItemdetail['id']; ?>">feedback and review</a>

				   <a href="#" onclick="javascript:addToFavourite()">add to favourite</a>

				   <?php
					   }
				   }
				   else
				   {
					   ?>
							<a href="login.php"> <img src="../images/msg.png"  /> </a> 
							<a href="login.php">feedback and review</a>
					   <?php

				   }

				   ?>
				   
				  </div>
			  </div>
			  
			  <!--rightdiv-->
			  <div class="wdth154 right">
			        <div class="bluebtn"> <?php echo $countreview; ?>
					   <h5> Reviews </h5> 
					  </div>
					  <div class="orangebtn"> S 
						 <h5> Super Renter </h5>
					  </div>
					 

			    </div>
				 <!--/rightdiv-->
				
				
			  <div class="itemL">
			   <div class="pL5 ">
			    <h3> <?php echo   $allItemdetail['item_name']; ?></h3>
				<h4> <?php echo   $allItemdetail['item_subtitle']; ?> </h4>
			   </div>

			    <div>

					<?php
					if(isset($_SESSION['user']))
					{
						if($allItemdetail['id']!=$_SESSION['user']['id'])
						{
						?>
						<a href="itemForRent.php?item_id=<?php echo $allItemdetail['item_id'] ;?>&user_id=<?php echo $allItemdetail['owner_id']; ?>">rent this item</a>

						<?php
						}
					}
					else
					{
						?>

						<a href="login.php">rent this item</a>
						<?php

					}



				?>
				</div>
			   
		
				<!--thumbnail-->
				<div class="itemthumbnail">
				  <div class="itemnav">
				    <ul>
					  <li> <a href="javascript:;" id="photo"> Photo  </a> </li>
					  <li> <a href="javascript:;" id="Map"> Map  </a> </li>
					  <li> <a href="javascript:;" id="calender"> Calender  </a> </li>
					</ul>
					 <a class="right" href="#"> <img src="../images/flag.gif" /> </a>
				  </div>
				  <div id="images"> 
				  <div class="thumbnailimg">
				   <img src="<?php echo $URL_SITE ;?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_id ;?>/<?php echo $featurimage['filename'] ;?>&width=200&height=200" />
				  </div>
				  <div class="thumnail">
				    <ul>
					  <a class="pre" href="javascript:;"> preview  </a>
					<?php  while($item_images=mysql_fetch_assoc($allrow))
					 {?>
						<li>
						<img src="<?php echo $URL_SITE ;?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_id ?>/<?php echo $item_images['filename']?>&width=100&height=100"/>&nbsp;&nbsp;&nbsp;
						</li>
                     <?php
					 }
					  ?>
					  </ul>	
						 <a class="next" href="#"> next </a>
				</div>
				</div>

				<div id="mapping" class="map">

				</div>

				<div id="calendering">
				</div>
			</div>
			<!--/thumbnail-->
				  
				<!--description-->
				<div class="description"> 
				<div class="itemnav">
				    <ul>
					  <li> <a href="javascript:; "id="dec"> Description  </a> </li>
					  <li> <a href="javascript:;" id="pickup">Pickup Details  </a> </li>
					 </ul>
				 </div>
				 <div class="mL10 mR10 left">
				   <div class="txtb" id="description">  

				   <?php echo   $allItemdetail['item_description']; ?>
							   </div>

				 <div class="none" id="pickupdetial" >
				  <?php echo   $allItemdetail['description']; ?>
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
					    <li> <img src="../images/star.png" /> </li>
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
					    Accuracy
					 
					    <div class="starsmall">
					      <ul>
							<?php for($i=1;$i<=$reviewResult['accuracy'];$i++)
					  {
						  ?>
					    <li> <img src="../images/star.png" /> </li>
						<?php
					  }
						  ?>
						  </ul>
					  </div>
					</div>
					  
					  <!--Communication-->
                    <div class="Accuracy">
					    Communication
					 
					    <div class="starsmall">
					      <ul>
							<?php for($i=1;$i<=$reviewResult['communication'];$i++)
					  {
						  ?>
					    <li> <img src="../images/star.png" /> </li>
						<?php
					  }
						  ?>
					   </ul>
					  </div>
				 </div>
					  
					  <!--Value-->
					 <div class="Accuracy">
					    Value
					 
					    <div class="starsmall">
					      <ul>
					     <?php for($i=1;$i<=$reviewResult['rating'];$i++)
					  {
						  ?>
					    <li> <img src="../images/star.png" /> </li>
						<?php
					  }
						  ?>
					   </ul>
					  </div>
				</div>
				   </div>
					
					   <!--Reviews container-->

					   <div class="review" id="review">
					   <?php
					   if($countreview)
					   {
					   while($row=mysql_fetch_assoc($exsql))
					   {
						   ?>
					     <div class="itemprofile">
						   <div class="itemprofileL">
						    <img src="..images/profile/<?php echo $row['user_picture'] ;?>" />
						      <h5> <?php echo $row['user_fname'] ;?> </h5>
							</div>
							 
							 <div class="itemprofileR">
							   <div class="txtb"><?php echo $row['reviews'] ;?> </div>
                                </div>
							</div>
						<?php
							}
						?>

							<div class="itembottom">
							<input class="bottombtn " type="button" name="button" value="1" />
							<input class="bottombtn " type="button" name="button" value="2" />
							<input class="bottombtn " type="button" name="button" value="next" />
							</div>
							<?php
					   }
							else
							{
								?>
								 <div class="itemprofile"> No review
								</div>
								<?php

							}
							?>

							</div>

							<div id="friends">

							this is friend div
							</div>


						
							 <!--/Reviews container-->
							
							<!--Reviews container-->
					
							<!--/Reviews container-->
							
							<!--Go to other page-->
				
						<!--/Go to other page-->
					</div>
				</div>
			</div>
		

	<script type="text/javascript">
		$(document).ready(function(){
			$("#description").show();
			$("#pickupdetial").hide();

			$("#images").show();
			$("#mapping").hide();
			$("#calendering").hide();

			$("#review").show();
			$("#friends").hide();


			$("#photo").click(function(){
				$("#images").show();
				$("#mapping").hide();
				$("#calendering").hide();

			});

			$("#Map").click(function(){
				$("#images").hide();
				$("#mapping").show();
				$("#calendering").hide();

			});

			$("#calender").click(function(){
				$("#images").hide();
				$("#mapping").hide();
				$("#calendering").show();

			});

			$("#dec").click(function(){
					$("#description").show();
					$("#pickupdetial").hide();

			});
			$("#pickup").click(function(){
					$("#description").hide();
					$("#pickupdetial").show();

			});
			

			$("#reviewdetail").click(function(){
				$("#review").show();
				$("#friends").hide();

			});

			$("#friend").click(function(){
				$("#review").hide();
				$("#friends").show();

			});
			
			
		

	});

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
