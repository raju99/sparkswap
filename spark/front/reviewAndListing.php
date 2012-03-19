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
			  
			 
			  
			 
			  <div class="itemL">
			  
			     
		
				<!--thumbnail-->
				
			<!--/thumbnail-->
				  
				
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
					
					   <!--Reviews container-->
					   <?php
					   if($countreview)
					   {
					   while($row=mysql_fetch_assoc($exsql))
					   {
						   ?>
					     <div class="itemprofile">
						   <div class="itemprofileL">
						   <?php
							   
							 if($row['user_picture'])
						   {
							  ?>
						    <img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/profile/<?php echo $row['user_picture'] ;?>" />
							<?php
						   }else{
								  echo "No Picture";
							  }
							  ?>
						      <h5> <?php echo $row['user_fname'] ;?> </h5>
							</div>
							 
							 <div class="itemprofileR">
							   <div class="txtb"><?php echo $row['reviews'] ;?> </div>
                                </div>
							</div>
							<?php
					        }
	                      ?>
							 <!--/Reviews container-->
							
							<!--Reviews container-->
					
							<!--/Reviews container-->
							
							<!--Go to other page
							<div class="itembottom">
							   <input class="bottombtn " type="button" name="button" value="1" />
							   <input class="bottombtn " type="button" name="button" value="2" />
							   <input class="bottombtn " type="button" name="button" value="next" />
							</div>
						<!--/Go to other page-->
						<div class="itembottom">
							<input class="bottombtn " type="button" name="button" value="1" />
							<input class="bottombtn " type="button" name="button" value="2" />
							<input class="bottombtn " type="button" name="button" value="next" />
							</div>
							<?php
					   }else{?>
					   <div class="itemprofile"> No review
								</div>
					   <?php
						}
						?>
				</div>
			</div>
		</div>

<?php 
include("../include/footer.php");
?>						