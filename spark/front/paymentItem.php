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
			
			  <div id="bookingpage">
			    <div class="bookingtop">
				  <h4> How to Rent </h4>
				    <div class="txtb">Provide your details below. You will only be charged if the owner accepts your request. <br />

                   If the owner declines or does not respond, no charge is made. Then you can try to book the same dates with another item.                  </div>
				   </div>
				   
				 <div class="bookingcontainer">
					<div class="bookingdetails">
					<div id="itemdetail">
					   <h4> 1. Item details </h4>
					     <div class="itemdetails">
						 
						  <!--item details left-->
						  <img class="itemdetailsL" src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_id ;?>/<?php echo $featurimage['filename'] ;?>&width=163&height=97"/>
						  
						   <!--item details right-->
						    <div class="itemdetailsR">
						      <h4><?php echo ''; ?> </h4>	
							   <span class="font9"> <?php echo  $allItemdetail['item_name']; ?> </span>
							    <span class="itemdetailsaddresh font7">
							     <?php echo  $allItemdetail['address1']?>  <br />
							    <?php echo  $allItemdetail['address2']?>   <br />
							    <?php echo  $allItemdetail['city'].$allItemdetail['zip']?>  
							   </span>
							   <br />
							    <span class="font9 left"> Renter must pick up / drop off </span>
						 </div>
						 </div>
						 
						 
						 
				  
				   
				   <!--Rental Details-->
				   <div class="bookingdetails">
				     <h4> 2. Rental Details </h4>
				      <div class="itemdetails">
					    <!--Pick up-->
						<div class="amount">
                                 
                                  <div class="wthper30 left"> <h5>Pick up </h5></div>
								  <div class="wthper70 left"> <h5> <?php echo  $allItemdetail['address1']?> Fri, Feb 10, 2010 <span class="font9"> <?php echo  $allItemdetail['address1']?>  (between 2-4pm) </span>  </h5> </div>
								  
								  <div class="clear"> </div>
                                 
								 
								  
                                  <div class="wthper30 left"> <h5>Drop off </h5></div>
								  <div class="wthper70 left"> <h5> <?php echo  $allItemdetail['address1']?> Sunday, Feb 10, 2010 <span class="font9">  <?php echo  $allItemdetail['address1']?> (between 2-4pm) </span> </h5> 
                                 </div>
								  <div class="clear"> </div>
						</div>
				</div>
			</div>
				   
				    <!--Amount Details-->
					 <div class="bookingdetails">
					    <div class="itemdetails">
						  <div class="amount" >
                                 
                                  <div class="wthper30 left"> <h5>Rate (per day) </h5> </div>
								  <div class="wthper70 left"> <h5> <?php echo  $allItemdetail['price']?> $25 </h5> </div>
                                 <div class="clear"> </div>
								 
								 
                                  <div class="wthper30 left"> <h5>Subtotal </h5> </div>
								  <div class="wthper70 left"> <h5><?php echo $allItemdetail['price']*3  ?>$75 </h5> </div>
                                   <div class="clear"> </div>
								 
								
                                  <div class="wthper30 left"> <h5>Service Free </h5> </div>
								  <div class="wthper70 left"> <h5>$11 </h5> </div>
                                 <div class="clear"> </div>
								 
								  
                                  <div class="borderT wthper30 left" > <h5>Total </h5> </div>
								  <div class="borderT wthper70 left" > <h5>$86 </h5> </div>
								 <div class="clear"> </div>
								 
							</div>
						</div>
				   </div>
				   
				    <!--/Amount Details-->
					
					 <!--Booking Details-->
					 <div class="bookingdetails">
					  <h4> 3. Additional Information Required </h4>
					    <div class="itemdetails">
						 <h5>  The owner requires additional information about you. </h5> 
						 
						<!-- STEP 1-->
						<div class="step">
						  <div class="font12">  Step 1 </div>
						    <div class="font9 pB5 "> Please provide a brief desciption of yourself: where you’re from, what you like to do,
what your job is - anything that will give us a sense of who you are. </div>
                           <textarea class="stepdescription pB15"> 
						      
							  </textarea>
							  </div>
						   
						   <!--/ STEP 1-->
						   
						   <!--STEP 2-->
						   <div class="step">
						  <div class="font12">  Step 2 </div>
						     <div class="font9 left pB5"> Please verify your phone number. </div>
							       <div class="verify">
								     <!--verify phone number-->
								     <input class="phonenum" type="text" name="phone number" value="+1 210 555 1234" />
									 
									 <!--sms button-->
									 <input class="smsbtn" type="button" name="verify sms" value=" verify via sms"  />
									 
									 <!--call button-->
									 <input class="smsbtn" type="button" name="verify sms" value=" verify via call"  />
								  </div>
								  
								  <!--Add new number-->
									 <input class="smsbtn left" type="button" name="verify sms" value=" ADD NEW NUMBER"  />
								</div>
							</div>
								<!--/STEP 2-->
								
							</div>
						 <!--Booking Details-->
						 
						  <!--Payment Options-->
				            <div class="bookingdetails">
				                   <h4> 4. Payment Options </h4>
				                       <div class="payment">
									     <nav class="left">
				                              <ul>
											     <li> <a href="credit"> Credit Card </a> </li>
												  <li> <a href="paypal"> PayPal </a> </li>
												</ul>
											</nav>
												
											<div class="wthper96 left mL13">
	
											 <div class="font9 pL10"> Your total charge is $86 </div>
											
											<!--firstname / payment-->
											  <div class="wdth180 left ">
										      <input class="paymentsubmit mT5" type="text" name="firstname" value="First Name" />
											   </div>
											   <div class="wdth145 left"> <img src="images/payment.png" /> </div>
											   <div class="clear"> </div>
											  <!--/ firstname / payment-->
											  
											  <!--Last name / Card-->
											  <div class="wdth180 left ">
											   <input class="paymentsubmit mT5" type="text" name="firstname" value="Last Name" />
											   </div>
											   <div class="wdth145 left font10">
											    card type <select>
												           <option selected="selected">visa</option>
														   <option selected="selected">visa</option>
														  
														 </select>
												</div>
												<!--/ Last name / Card-->
												
											    <div class="clear"> </div>
												 
												<!--Street Address / Credit number-->
												<div class="wdth180 left ">
												
											    <input class="paymentsubmit wthper70 mT5" type="text" name="firstname" value="Street Address" />                                     
												</div>
												
												<div class="wdth145 left font10">
												<input class="paymentsubmit mT5" type="text" name="firstname" value="credit card number " />     
												 </div>
												 <!--/ Street Address / Credit number-->
												 <div class="clear"> </div>
							                     
												 
												 <!-- Address / exp. on-->
												 <div class="wdth180 left ">
                                                  <input class="paymentsubmit wthper70 mT5" type="text" name="firstname" value="Apt, Suite, Building (optional)" />
												  </div>
												  
												  <div class="wdth145 left font10 mT5">
												    Expire on
												 </div>
												 <!--/ Address / exp. on-->
												  
												  
												   <div class="clear"> </div>
												   
												  <!--city / date-->  
												  
												   <div class="wdth180 left ">
						                            <input class="paymentsubmit mT5" type="text" name="firstname" value="City" />
												   </div>
												   <!--Date-->
												    <div class="wdth145 left font10">
											         <select >
												           <option selected="selected">1</option>
														   <option selected="selected">2</option>
														   
														 </select>
														 <!--/Date-->
														 
														 <!--year-->
														 <select >
												           <option selected="selected">2012</option>
														   <option selected="selected">2012</option>
														   
														 </select>
														 <!--/Date-->
												  </div>
												  
												    <!--/ city / date-->  
										
												  <div class="clear"> </div>
												  
												   <!--zip/code-->
												   <div class="wdth180 left "> 
												 
												  <input class="paymentsubmit  wthper30 mT5 left" type="text" name="firstname" value="Zip" />
												  </div>
												  
												   <div class="wdth145 left font10">
												   <input class="paymentsubmit mT5 left" type="text" name="firstname" value="Security Code" />
												    </div>	
												   <!--/ zip/code-->
												   <div class="clear"> </div>
						            
								</div>
						      </div>
							 </div>
							   
							   <!--Policies-->
				            <div class="bookingdetails">
				                   <h4> 5. Policies </h4>
				                       <div class="itemdetails">
									   <div class="wthper96">
                                           <div class="wthper30 left"> <h5> Cancellation </h5> </div>
								           <div class="wthper70 font10 left" > Strict: 50% refund up until 1 week prior to arrival  </div>
                                           <div class="clear"> </div>
										   
										  <!-- Item Rules-->
                                           <div class="wthper30 left"> <h5> Item Rules </h5> </div>
								           <div class="wthper70 read left" > <a href="#">  Read Policy </a> </div>
                                         <!-- /Item Rules-->
									</div>
								</div>
							</div>
							<!--/Policies-->
								
								<!-- terms-->
								<div class="terms">
								  <input class="mR5" type="checkbox" name="checkbox" width="15" height="15" />
								  
								     I agree to the cancellation policy, house rules, and <a href="#"> terms of use </a> 
									 
									 </div>
									<!-- /terms-->
								
								<!--Booking button-->
								<input class="bookit" type="button" name="book it" value="Book It" />
						   </div>
						</div>
					 </div>
			</div>
						 
							  	
							 				  
					  
					
					   
					  
			   
</body>
</html>
