<?php
include('../include/header.php');
$userDir="$DOC_ROOT/images/itemimages/";

if(!isset($_SESSION['user']))
{
	header("location:".$URL_SITE."front/login.php");
}
unset($_SESSION['image']);
?>

<script>
 $(document).ready(function(){
    var thumb = $('img#thumb');
    new AjaxUpload('file', {
		action: $('form#addItem').attr('action'),
		name: 'file',
		onSubmit: function(file, extension) {
			jQuery('#previewImage').hide();
			//thumb.attr('src',"");
			$("#loadingDiv").html("<font color='red' size='4'>Loading.......</font>");
		},
		onComplete: function(file, response) {
			thumb.load(function(){
				$('div.preview').removeClass('loading');
				thumb.unbind();
			});
			
			   jQuery('#previewImage').show();
               $('#previewimage').val(response);
			   response= response.replace(/\&amp;/g,'&');
			   $("#loadingDiv").html("");		  
			   //thumb.attr('src', response);
			  $("#previewImage").html(response);

          }
	});
});
</script>

<div class="listitem">

	   <!--List Item Top-->
	   <div class="pT20 left wthper50 fontbld">
			<h2 class="font26 colororange">LIST YOUR ITEM </h2> 
			<p class="font14"> Spark Swap lets you make money renting <br /> out your stuff. Your stuff will pay for itself! </p>
	  </div>

	  <div class="wthper50 left">
		<img src="../images/watch.png"  />
	  </div>

	  <!--/ List Item Top-->
	 
	 <div class="clear"> </div>
     <form action="uploadImage.php" method="POST" id="addItem" name="addItem" enctype="multipart/form-data">
		<!--Item Content 1-->			       	
		<div class="listitemcontent mT25">
						   
				<!--left div-->
				<div class="wth520 left">
					<!--Title-->
					<div class="wthper100">
						<div class="wthper30 left"><h4> Title </h4></div>

						<div class="wthper70 left">	
							<input type="text" class="required listitemsubmit wthper95" value="" id="" name ="title"/>					
						</div>	
					</div>
					<div class="clear"> </div>
					<!--/Titel-->




					<!--Subtitle-->
					<div class="wthper100 mT10">
						<div class="wthper30 left"><h4>Subtitle</h4></div>

						<div class="wthper70 left">
							<input type="text" class="listitemsubmit wthper95 required" value="" id="" name ="subtitle"/>					
						</div>
					</div>
					<div class="clear"> </div>
					<!-- /Subtitle-->
					



					<!--Description-->
					<div class="wthper100 mT10">
						<div class="wthper30 left"><h4> Description </h4></div>

						<div class="wthper70 left">	
							<textarea class="listitemsubmit wthper95 required" id="" name ="description"/></textarea>					
						</div>
					</div>
					<div class="clear"> </div>
					<!--/Description-->

					

					<!--Price per day-->
					<div class="wthper100 mT10">
						<div class="wthper30 left"><h4> Price per Day </h4></div>

						<div class="wthper30 left">
							<input type="text" class="listitemsubmit wthper30 required number" value="" id=""  name ="priceperday"/>					
							&nbsp;<a class="pT10 fontbld" href="#"> USD </a> 
						</div>
					</div>
					<div class="clear"> </div> 
					<!--/Price per day-->


					

					<!--Deposit Amount-->
					<div class="wthper100 mT10">
						<div class="wthper30 left"><h4> Deposit Amount </h4></div>

						<div class="wthper30 left">	
							<input type="text" class="listitemsubmit wthper30 required number" value="" id="" name ="depositamount" />						
							&nbsp;<a class="pT10 fontbld" href="#"> USD </a> 
						</div>
					</div>
					<div class="clear"> </div>
					<!--/Deposit Amount-->
					


					<!--Number Available-->
					<div class="wthper100 mT10">
						<div class="wthper30 left"><h4> Number Available </h4></div>

						<div class="wthper30 left">	
							<input type="text" class="listitemsubmit wthper30 required" value="" id="" name ="availavel"/>					
						</div>
					</div>
					<div class="clear"> </div>
					<!--/Number Available-->

								
								
					<!--Browse-->						
					<div class="wthper100 mT10">
						 <div class="wthper30 left"><h4> Picture of Number </h4></div>
						 <div class="wthper50 left">
								<input class="listitembutton wthper30 file_2" type="button" color="red" name="file" id="file" value="Browse"><br>

								<div id="loadingDiv"></div> <br>

								<div id="" class="listitempic left">
									<ul style="display:none" id="previewImage"></ul>
								</div>

								<input type="hidden" name="previewimage" id="previewimage" value="" /> 
								
								<div class="clear"> </div>										
								<div id="previewImage"></div>
						 </div>
					</div> 
					<!--/Browse-->

					<div class="clear"> </div>

					<!--Delivery Options-->
					 <div class="wthper100 mT10">
					   <div class="wthper30 left"><h4> Delivery Options  </h4></div>
			
						 <div class="wthper70 left">
							  
							  <input id="pickup_click" class="mR10 left" type="checkbox"  value="1" name="pickup" />
							  <h5>Renter can pick up & drop off item from your location </h5> 
							   
							  <div class="clear"> </div>
							  
							  <input id="dropoff_click" class="mR10 left" type="checkbox"  value="1" name="dropoff" />
							  <h5>You can drop off & pick up item from renter's location </h5> 
							 							 
							 <div class="clear pB10"> </div>
							 
							 <div id="delivery_fee_radius_show" style="display:none;">
									
									<!--Delivery Radius -->
									 <div class="listyourdelivery mT5">
										<div class=" wthper50 left">
										   <h5>Delivery Radius:</h5> 
										</div>
										  <div class="wthper50 left">
												<input class="listitemsubmit wthper40" type="text" name="delivery_radius" value="" />
												&nbsp;
												<a class="pT10 fontbld" href="javascript:;"> miles </a>  
										  </div>
								   </div>
								   <div class="clear mT5"> </div>
								   <!--/Delivery Radius-->
								   
								   <!--Delivery Fee -->
									 <div class="listyourdelivery">
										<div class=" wthper50 left">
										   <h5>Delivery Fee: </h5> 
										</div>
										  <div class="wthper50 left fontbld"> 
												<input class="listitemsubmit wthper40" type="text" name="delivery_fee" value="" />
												&nbsp; 
												<a class="pT10" href="javascript:;"> USD </a>  
										  </div>
									</div>
									<!--/Delivery Fee-->				   
									
								   
									 
								   
						   </div>

						   <script type="text/javascript">     
							$(document).ready(function()
							{
								$("#dropoff_click").click(function(){
									if($("#dropoff_click").attr('checked'))
									{
										$('#delivery_fee_radius_show').show();
									}
									else
									{
										$('#delivery_fee_radius_show').hide();
									}														 
									  
								});
							});							  
							</script>
							   
						</div>
				    </div> 						
				    <!--Delivery Options-->
					
			   </div>			  
			   <!--/Left Div-->
							
							
				<!--Right Div-->
				<div class="listitemR"> 
					<h4 class="font14 txtcenter">SparkSwap Protects You! </h4>
					<div class="clear"> </div>
					<div class="listitemRpic">
						<img src="<?=$URL_SITE?>images/protection_logo.gif" width="93" height="122" />
					</div>

					<h4 class="font14 txtcenter">Click
					&nbsp;
					<a href="javascript:;">Here&nbsp;</a>to Learn More !</h4>

				</div>
				<!--/Right Div-->
		</div>
		<div class="clear"> </div>

		<!--Confirmed Rental-->
		<div class="listitemcontent mT25">
				<div class="showrental"> Show to Confirmed Rental Only </div> 				   
				<div class="wth520 left pT30 pL15">

						<!--Phone Number-->
						<div class="wthper100">
							<div class="wthper30 left"><h4> Phone Number </h4></div>

							<div class="wthper70 left">	
								<input type="text" class="listitemsubmit wthper95 required number" value="" id="" name ="phoneno"/>			
							</div>	
						</div>
						<div class="clear"> </div>
						<!--/Phone Number-->
										
										
										
						<!--Addresh 1-->
						<div class="wthper100 mT10">
							<div class="wthper30 left"><h4> Address 1 </h4></div>
							<div class="wthper70 left">
								<textarea class="listitemsubmit wthper95 required" id="" name="address1"/></textarea>			
							</div>	
						</div>
						<div class="clear"> </div>
						<!--/Address 1-->

						
										   
						<!--Address 2-->
						<div class="wthper100 mT10">
							<div class="wthper30 left"><h4> Address 2 </h4></div>

							<div class="wthper70 left">	
								<textarea class="listitemsubmit wthper95" id="" name ="address2"/></textarea>			
							</div>	
						</div>
						<div class="clear"> </div>
						<!--/Address 2-->

						
										
						<!--City-->
						<div class="wthper100 mT10">
							<div class="wthper30 left"><h4> City </h4></div>

							<div class="wthper50 left">	
								<input type="text" class="listitemsubmit wthper95 required" value="" id="" name="city"/>				
							</div>	
						</div>
						<div class="clear"> </div>
						<!--/City-->

						
										  
						<!--State-->
						<div class="wthper100 mT10">
							<div class="wthper30 left"><h4> State </h4></div>

							<div class="wthper30 left">	
								<input type="text" class="listitemsubmit wthper30 required" value="" id="" name ="state"/>				
							</div>
						</div> 
						<div class="clear"> </div>
						<!--/State-->
						
										
										   
						<!--Zip-->
						<div class="wthper100 mT10">
							<div class="wthper30 left"><h4> Zip </h4></div>

							<div class="wthper40 left">	
								<input type="text" class="listitemsubmit wthper30 required number" value="" id="" name ="zip"/>				
							</div>
						</div>
						<div class="clear"> </div>
						<!--/Zip-->

						<!--Manage-->
						<!-- <div class="wthper100 mT10">
							<div class="wthper30 left"><h4> manage Product </h4></div>

							<div class="wthper70 left fontbld">
								<input type="checkbox" class="listitemsubmit" value="1" id="" name ="pickup"/>&nbsp;&nbsp;Pickup&nbsp;&nbsp;&nbsp;<span class="font11">Done by Renter</span><br>

								<input type="checkbox" class="listitemsubmit" value="1" id="" name ="dropoff"/>&nbsp;&nbsp;Dropoff&nbsp;&nbsp;&nbsp;<span class="font11">Done by Renter</span>								
							</div>
						</div>
						<div class="clear"> </div> -->
						<!--/Manage---->
				
			   </div>
		
			   <!--/Confirmed Rental-->	  

			   <!--bottom button-->
			   <div class="listitembottom">
					<div class="left"> 
						<a  href="javascript:;"><input class="listyoursubmit" type="submit" name ="submit" value="Post It"/></a> 
					</div>

					<div class="right"> 				
						<a href="javascript:window.history.go(-1)"><input class="listyoursubmit" type="button" value="Back"/></a>
					</div>
			   </div>
		  </form>
	  </div>

</div>
<!--/bottom button-->



<script type="text/javascript">  
      // when the entire document has loaded, run the code inside this function 
      $(document).ready(function(){  
      // Wow! .. One line of code to make the unordered list drag/sortable!  
      $('#previewImage').sortable();  
      });
  
</script>

<?php 
include("../include/footer.php");
?>