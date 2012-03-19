<?php
// FIle to rent an item
$base_dir=dirname(__FILE__);
include($base_dir.'../../include/header.php');
include($base_dir.'../../classes/lib/Stripe.php');		//class for stripe payment gateway

if(!isset($_SESSION['user']))
{
	$item_id=$_GET['item_id'];
	$_SESSION['item_for_search']=$item_id;
	header('location:'.$URL_SITE.'front/login.php');
}
if(isset($_GET['user_id']))
{
	$renter_id=$_GET['user_id'];//this is the id of owner id of item
	$item_id=$_GET['item_id'];
}
if(isset($_POST['book_it']))
{	
	@$droop_date=$_POST['drop_up']; 
	@$pick_up=$_POST['pick_up'];
	
	$pickup_date=substr($pick_up,0,10);
	$drop_date=substr($droop_date,0,10);

	$owner=$_POST['owner'];
	@$item_id=$_POST['item_id'];	

	@$insert=user::payment_dtatils($item_id,$owner);
	
	if($insert)
	{
		$differentce=get_number_of_days($pickup_date,$drop_date);
		$owner_detail=user::user_profile($owner);
		$item_image=itemClass::select_featured_image($item_id);

		$item_detail_res=itemClass::selectUsersItems($item_id);
		$item_detail=itemClass::fetch($item_detail_res);
		
		$server='http://electricitynoida.com/spark';
		$receivename=$_SESSION['user']['user_fname'];
		//$receivermail='bishtsaket@gmail.com';
		//$receivermail='praveensingh2500@gmail.com';
		$receivermail=@$_SESSION['user']['user_email'];
		$fromname=$from_name;
		$fromemail=$from_email;

		$mailbody='<body style="margin:0px; padding:0px; font-family: Coolvetica, Arial, Helvetica, sans-serif;font-size:16px;color:#333333; background: #fbfafa url('.$server.'/images/bg.png) repeat-x left 30px;">  
			<div style="  width:738px; height:auto; overflow:hidden; margin:auto;">
		
			<div style=" width:auto; height:auto; overflow:hidden;  padding:0px; background:none;">  
			<div style="width:100%; height:80px; background:none; margin-top:30px;">
		   
			 <div style="background: url('.$server.'/images/logo.png) no-repeat top left; padding-right:10px; text-indent:-999em; width:61px; height:79px; float:left; "> SparkSwap  </div>   
		   
			 <div style="padding-left:20px; float:left; width:605px">
			 
				 <h3 style="font-size:20px; color:#f38630; line-height:50px; text-decoration:none; text-align:left; font-weight:normal; padding-top:10px;"> Please respond to your rental request, you have 24 hours remaining!   </h3>
			 </div>
			 </div> 
			  
				<div style="width:100%;height:auto; overflow:hidden; padding-bottom:20px; ">
				 <div style="padding-top:10px; float:left">
				  <p style="font-size:14px; font-weight:normal"> Hi '.$owner_detail['username'].', <br />
								  Please respond to this request within the next 24 hours to confirm the details of the transaction. You may accept the proposed rental dates, message the other party to propose different dates or deny the request with an explanation of why you can\'t complete the transaction.   </p>  
								  
								  </div>
				  
					   <div style="clear:both;"> </div>
					   
					   
						  <div style="padding-top:10px; float:left">

					   
							 <div style="height:50px; width:65px; border:2px solid #f91200; overflow:hidden; margin:10px 10px 8px 0px; float:left">
							   <img src="'.$server.'/images/itemimages/'.$item_id.'/'.$item_image['filename'].'" height="50" width="65" />
							 </div>
						 
							  
							  <div style="float:left; margin-top:10px; padding-left:10px">
							  
							   

								 <h4 style="font-size:14px; font-weight:normal" > 
								 <a style="color: #0000FF; text-decoration: none;" href="#"> '.$item_detail['item_name'].'</a>  <br />
											  Daily Rental Price: $'.$item_detail['item_Price'].' <br />
											  Renter: '.$_SESSION['user']['username'].' <br />
											  Proposed Rental Dates: <span style="font-weight:bold"> 
											  
											  '.date('M d,Y',strtotime($pick_up)).' to '.date('M d,Y',strtotime($droop_date)).' </span> <br />
											  Number of Days:'.$differentce.' <br />
											  Gross Rental Income: $'.@$_POST['total_price'].'  <br />       
								</h4>
							
							</div>
						</div>
							<div style="clear:both;"> </div>
							<!--Bottom Button-->
							<div style="width:555px; margin: 100px auto 0; height:auto; overflow:hidden;">
							
								 
								   <input type="button" name="Accept" value=" " style=" background: url('.$server.'/images/accept.png) no-repeat left top; border: none; cursor: pointer; font-size: 20px;  padding: 5px 10px 5px 10px; text-align: center; width:129px; height:53px; text-indent:-999em; float:left;"/>
								   
								   <div style="padding-left:84px; float:left">
								  <input type="button" name="Propose New Date" value=" " style="background: url('.$server.'/images/proposenewdate.png) no-repeat left top; border: none; cursor: pointer; font-size: 20px;  padding: 5px 10px 5px 10px; text-align: center; width:129px; height:53px; text-indent:-999em; float:left;"/>
								  </div>
								  
								 <div style="padding-left:84px; float:left">
								 <input type="button" name="Propose New Date" value=" " style="background: url('.$server.'/images/Deny.png) no-repeat left top; border: none; cursor: pointer; font-size: 20px;  padding: 5px 10px 5px 10px; text-align: center; width:129px; height:53px; text-indent:-999em; float:left;"/>
								  </div>
								 
							 </div>						 
					  </div>
				</div>
				
		  </div>    
		</body>';
		$subject='A renter wants to rent your item in Spark Swap';
		mail_to_all_user($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject);// sends mail to user who did checked for new items mail function
		$_SESSION['msg']='19';
		header('location:'.$URL_SITE.'front/home.php');
	}
}

$allItemdetail=user::mainDetailOfItem($item_id);	// details of item
$feature_image=itemClass::select_featured_image($item_id);//feture image of item
$res=user::select_settings_for_user($allItemdetail['owner_id']);//settigs of item owner
$owner_settings=mysql_fetch_assoc($res);
//print_r($owner_settings);
$user_detail=user::user_profile($_SESSION['user']['id']);
$phoneRequired=0; // check wherter to show phone nbr varification

if($owner_settings['persona_desc']==0)
{
	$descriptionClass='';
}
else
{
	$descriptionClass='required';
}

if($owner_settings['phone']==1 or $owner_settings['profile']==1)
{
	
		if($user_detail['varified_phone']==$owner_settings['phone'])
		{?>
			<script>
				var phone=0;
			</script>
		<?
		}
		else
		{
			$phoneRequired=1;
			?>

			<script>
				var phone=1;
			</script>
		<?
		}
	
		if($user_detail['user_picture']==$owner_settings['profile'])
		{?>
			<script>
				var profile=1;
			</script>
		<?
		}
		else
		{
		?>
			<script>
				var profile=0;
			</script>
		<?
		}
	?>

	<script>
		requirements(profile, phone);
	</script>

<?php
}
?>

<!-- BOOKING PAGE -------------------------->
<div id="bookingpage">
	<div class="bookingtop">
		<h4> How to Rent </h4>
		<div class="txtb">Provide your details below. You will only be charged if the owner accepts your request. <br />

		If the owner declines or does not respond, no charge is made. Then you can try to book the same dates with another item.
		</div>
	</div>

	<div class="bookingcontainer">
		<div class="bookingdetails">
			<h4> 1. Item details </h4>
		<div class="itemdetails">
		<!--item details left-->
		<img class="itemdetailsL" src="<?php echo $URL_SITE?>classes/show_image.php?filename=../images/itemimages/<?php echo $allItemdetail['item_id']?>/<?php echo $feature_image['filename']?>&width=163px&heigth=97px"/>
		<!--item details right-->
		<div class="itemdetailsR">
			<h4><?php echo $allItemdetail['item_name'];?> </h4>	
			<span class="font9"> "<?php echo $allItemdetail['item_subtitle']?>" <?php echo $allItemdetail['item_description']?> </span>
			<span class="itemdetailsaddresh font7">
			<?php echo $allItemdetail['address1'];?> <br />
			
			<?php echo $allItemdetail['city'].','.' '.$allItemdetail['state']. ' '.$allItemdetail['zip'];?>
			</span>
			<div class="clear"> </div>
			     <p class="font9 left">
					  <?php 
					  if($allItemdetail['pickup'])
					  {
						echo'<br>Renter Must pick up / ';
					  }
					  
					  if($allItemdetail['dropoff'])
					  {
						echo'<br>Renter Must drop off';
					  }
					  ?> 
			   </p>
		</div>
	</div>
	</div>

	<!--Rental Details-->
	<div class="bookingdetails">
		<h4> 2. Rental Details </h4>
		<div class="itemdetails">
			<!--Pick up-->
			<div class="amount">

				<div class="wthper30 left"> <h5>Pick up </h5></div>
					<div class="wthper70 left">
						<input class="paymentsubmit" onchange="javascript: price_calculation();" type="text" id="rent_pick" name="rent_pick"> 
					</div>
					<div class="clear"> </div>

					<div class="wthper30 left"> <h5>Drop off </h5></div>
					<div class="wthper70 left">
						<input class="paymentsubmit" onchange="javascript: price_calculation();" type="text" id="rent_drop" name="rent_drop">
					</div>

			<div class="clear"> </div>
			</div>
		</div>
	</div>
	
	<script>
		$('#rent_drop, #rent_pick').datetimepicker({minDate:-0,ampm:true});
	</script>

	<!--Amount Details-->
	<div class="bookingdetails">
		<div class="itemdetails">
			<div class="amount" >

			<div class="wthper30 left"> <h5>Rate (per day) </h5> </div>
			<div class="wthper70 left"> <h5 >$<label id="item_price"><?php echo $allItemdetail['item_Price'];?></label> </h5> </div>
			<div class="clear"> </div>

			<script type="text/javascript">
			function price_calculation()
			{
				var item_price=$('#item_price').text();
				var pick_up=$('#rent_pick').val();
				var rent_drop=$('#rent_drop').val();
				if(pick_up!='' && rent_drop!='')
				{
					document.booking_form.elements["drop_up"].value = rent_drop;
					document.booking_form.elements["pick_up"].value = pick_up;
					rent_drop=rent_drop.substr(0,10);
					pick_up=pick_up.substr(0,10);
					var dif=GetDateDiff(pick_up,rent_drop);
					var i=dif*item_price;
					document.getElementById('subtotal_price').innerHTML ='$'+i;
					to_get_total(i);		// to get total price
					
				}
			}

			function GetDateDiff(startDate, endDate)
			{
				t1=startDate ;
				t2=endDate;
				var one_day=1000*60*60*24; 
				var x=t1.split("-");     
				var y=t2.split("-");
				var date1=new Date(x[2],(x[1]-1),x[0]);  
				var date2=new Date(y[2],(y[1]-1),y[0]);
				var month1=x[1]-1;
				var month2=y[1]-1;

				_Diff=Math.ceil((date2.getTime()-date1.getTime())/(one_day)); 

				if(_Diff>0)
				{
					 return _Diff;
				}
				else
				{
					 
					 return 1;
				}

			}

			function to_get_total(i)
			{				
				var service_Fee=$('#service_Fee').text(); 
				total=parseInt(service_Fee)+parseInt(i);					
				document.getElementById('total_Fee').innerHTML=total;				
				document.booking_form.elements["total_price"].value = total; 				
			}
			</script>


			<div class="wthper30 left"> <h5>Subtotal </h5> </div>
			<div class="wthper70 left"> <h5 ><label id="subtotal_price"><label></h5> </div>
			<div class="clear"> </div>


			<div class="wthper30 left"> <h5>Service Fee </h5> </div>
			<div class="wthper70 left"> <h5>$<label id="service_Fee">11</label> </h5> </div>
			<div class="clear"> </div>


			<div class="borderT wthper30 left" > <h5>Total </h5> </div>
			<div class="borderT wthper70 left" > <h5>$<label id="total_Fee"></label> </h5> </div>
			<div class="clear"> </div>

			</div>
		</div>
	</div>

	<!--/Amount Details-->
	<form action="" name="booking_form" method="post" id="booking_form">
				
				<!--Booking Details-->
				<div class="bookingdetails">

					<h4> 3. Additional Information Required </h4>

					<div class="itemdetails">
						<h5>  The owner requires additional information about you. </h5> 

						<!-- STEP 1-->
						<div class="step">
						<div class="font12">  Step 1 </div>
						<div class="font9 pB5 "> Please provide a brief desciption of yourself: where youre from, what you like to do,
						what your job is - anything that will give us a sense of who you are. </div>
						<textarea name="desciption_renter" id="desciption_renter" class="<?php echo $descriptionClass;?> stepdescription pB15"></textarea>
						</div>

						<!--/ STEP 1-->
						<?php
						if($phoneRequired==0)
						{ ?>
							<!--STEP 2-->
							<div class="step">
								<div class="font12">  Step 2 </div>
								<div class="font9 left pB5"> Please verify your phone number. </div>

								<div class="clear"> </div>
								<div class="verify">
								<!--verify phone number-->
								<input class="phonenum paymentsubmit  required digits" type="text" name="phonenumber" value="" />

								<!--sms button-->
								<input class="smsbtn" type="button" name="verify sms" value=" verify via sms"  />

								<!--call button-->
								<input class="smsbtn" type="button" name="verify sms" value=" verify via call"  />
								</div>

								<!--Add new number-->
								<input class="smsbtn left" type="button" name="verify sms" value=" ADD NEW NUMBER"  />
							</div>
						<?php
						}
						?>
					</div>
					<!--/STEP 2-->

				</div>
				<!--Booking Details-->

				<!--Payment Options-->
				<div class="bookingdetails">
						<h4> 4. Payment Options </h4>
						<?php
						$user_id=$_SESSION['user']['id'];
						$check_payout_mode_res=user::selectPayoutMode($user_id);
						$check_payout_mode=user::fetch($check_payout_mode_res);
						//echo "<pre>";print_r($check_payout_mode); 

						if($check_payout_mode['payout_type']=='paypal')
						{
							if(!empty($check_payout_mode['payout_email']))
							{?>
								<!--paypal information------------>
								<div class="payoutgrybgMode fontbld" id="PayPal_Information_show">
										<p class="font12"> PayPal Method </p>							
											<!--Payment-->
											<div class="wdthpercent100 pT10">
												<div class="wthper50 left"> 
												<p class="font11 pL5 pT5"> What e-mail should we send payment to? </p>
												</div>
												<div class="wthper50 left">

												<input readonly="readonly" type="text" value="<?php echo $check_payout_mode['payout_email'];?>" name="payout_email" class="payoutsubmit required">			
												<input type="hidden" value="paypal" name="payout_type">
												</div>
											</div>
											<!--/Payment-->
											
											<div class="clear"> </div>

											<p class="font12 pT20 txtright bluelink"> To change Payout&nbsp;&nbsp;<a href="<?php echo $URL_SITE;?>front/acounts.php?type=payout">Click here..</a> </p>
											
								</div>
								<!--/paypal information-------------->
							<?
							}
							else
							{?>
								<div class="payoutgrybgMode fontbld" id="Check_Information_show" style="">
										<p class="font12"> please select your payout mode</p>				
										<div class="clear"> </div>									
										<div class="wdthpercent100 pT10">
											<div class="wdthpercent30 left"> 
												<p class="font11 pL5 pT5">To Select Mode</p>
											</div>
											<div class="wdthpercent70 pL20 bluelink"><a href="<?php echo $URL_SITE;?>front/acounts.php?type=payout">Click here..</a></div>
										</div>											
										
								</div>	

							<?
							}
							
						}
						elseif($check_payout_mode['payout_type']=='direct')
						{		
								//echo "<pre>";print_r($check_payout_mode); 
								if(!empty($check_payout_mode['name_on_account']) && !empty($check_payout_mode['account_type']) && !empty($check_payout_mode['routing_number']) && !empty($check_payout_mode['account_number']))
								{//echo "<pre>";print_r($check_payout_mode); 						
								?>
									<!--Direct Deposit--------------->
									<div class="payoutgrybgMode fontbld" id="Direct_Information_show" style="">				
										<p class="font12"> Direct Deposit (ACH) Method </p>			   
																	
											<!--Name-->
											<div class="wdthpercent100 pT10">

												<div class="wdthpercent30 left"> 
													<p class="font11 pL5 pT5"> Name on account</p>
												</div>
												
												<div class="wdthpercent70 left">
													<input readonly="readonly" type="text" value="<?php echo $check_payout_mode['name_on_account'];?>" name="name_on_account" class="payoutsubmit required">
												</div>

											</div>
											<div class="clear"> </div>
											<!--/Name-->

											<!--Account-->
											<div class="wdthpercent100 pT10">
												<div class="wdthpercent30 left"> 
													<p class="font11 pL5 pT5"> Account Type </p>
												</div>
												
												<div class="wdthpercent70 left">
													<select readonly="readonly" class="required" name="account_type">
														<option value="<?php echo $check_payout_mode['account_type'];?>">
														<?php echo $check_payout_mode['account_type'];?>
														</option>
													</select>
												</div>
											</div>
											<!--/Account-->
											<div class="clear"> </div>

											<!--Routing-->
											<div class="wdthpercent100 pT10">
												<div class="wdthpercent30 left"> 
													<p class="font11 pL5 pT5"> Routing Number </p>
												</div>
												<div class="wdthpercent70 left">
													<input readonly="readonly" type="text" value="<?php echo $check_payout_mode['routing_number'];?>" name="routing_number" maxlength="9" class="payoutsubmit required number">
												</div>
											</div>
											<div class="clear"></div>
											<!--/Routing-->

											
											<!--Account number-->
											<div class="wdthpercent100 pT10">
												<div class="wdthpercent30 left"> 
													<p class="font11 pL5 pT5"> Account Number </p>
												</div>
												<div class="wdthpercent70 left">
													<input type="text" readonly="readonly" value="<?php echo $check_payout_mode['account_number'];?>" name="account_number" class="payoutsubmit required number">

													<input type="hidden" value="direct" name="payout_type">
												</div>
											</div>
											<div class="clear"> </div>
											<!--/Account number-->	
											
											<p class="font12 pT20 txtright bluelink"> To change Payout&nbsp;&nbsp;<a href="<?php echo $URL_SITE;?>front/acounts.php?type=payout">Click here..</a> </p>
											
								  
								  </div>
								  <!--/Direct Deposit---------------> 
							  <?
							  }
							  else
							  {?>
								   <div class="payoutgrybgMode fontbld" id="Check_Information_show" style="">
										<p class="font12"> please select your payout mode</p>				
										<div class="clear"> </div>									
										<div class="wdthpercent100 pT10">
											<div class="wdthpercent30 left"> 
												<p class="font11 pL5 pT5">To Select Mode</p>
											</div>
											<div class="wdthpercent70 pL20 bluelink"><a href="<?php echo $URL_SITE;?>front/acounts.php?type=payout">Click here..</a></div>
										</div>
										<div class="clear"> </div>									
									</div>	
							  <?
							  }
						}
						elseif($check_payout_mode['payout_type']=='check')
						{
							if(!empty($check_payout_mode['name_on_check']) && !empty($check_payout_mode['country']) && !empty($check_payout_mode['state']) && !empty($check_payout_mode['city']) && !empty($check_payout_mode['address_1']) && !empty($check_payout_mode['address_2']) && !empty($check_payout_mode['zip_code']))
							{?>
									<!--Check Information---------------->
									<div class="payoutgrybgMode fontbld" id="Check_Information_show" style="">
											<p class="font12"> Check Information </p>
											<div class="clear"> </div>

													<!--Name-->
													<div class="wdthpercent100 pT10">
														<div class="wdthpercent30 left"> 
															<p class="font11 pL5 pT5"> Name on Check </p>
														</div>
														<div class="wdthpercent70 left">
															<input type="text" readonly="readonly" value="<?php echo $check_payout_mode['name_on_check'];?>" name="name_on_check" class="payoutsubmit required">
														</div>
													</div>
													<div class="clear"> </div>
													<!--/Name-->

													
													<!--Country-->
													<div class="wdthpercent100 pT10">
														<div class="wdthpercent30 left"> 
															<p class="font11 pL5 pT5"> Country </p>
														</div>
														<div class="wdthpercent70 left">
															<select readonly="readonly" name="country" class="required">
																<option value="<?php echo $check_payout_mode['country'];?>">
																<?php echo $check_payout_mode['country'];?>
																</option>
															</select>
														</div>
													</div>
													<div class="clear"> </div>
													<!--/Country-->
													

													<!--State-->
													<div class="wdthpercent100 pT10">
														<div class="wdthpercent30 left"> 
															<p class="font11 pL5 pT5"> State </p>
														</div>
														<div class="wdthpercent70 left">
															<select readonly="readonly" name="state" class="required">			
																<option value="<?php echo $check_payout_mode['state'];?>">
																<?php echo $check_payout_mode['state'];?>
																</option>
															</select>
														</div>
													</div>
													<div class="clear"> </div>
													<!--/State-->

													<!--City-->
													<div class="wdthpercent100 pT10">
														<div class="wdthpercent30 left"> 
															<p class="font11 pL5 pT5"> City </p>
														</div>
														<div class="wdthpercent70 left">
															<input readonly="readonly" type="text" value="<?php echo $check_payout_mode['city'];?>" name="city" class="payoutsubmit required">
														</div>
													</div>
													<div class="clear"> </div>
													<!--/City-->

													<!--Address 1-->
													<div class="wdthpercent100 pT10">
														<div class="wdthpercent30 left"> 
															<p class="font11 pL5 pT5"> Address 1 </p>
														</div>
														<div class="wdthpercent70 left">
															<input readonly="readonly" type="text" value="<?php echo $check_payout_mode['address_1'];?>" name="address_1" class="payoutsubmit required">
														</div>
													</div>
													<div class="clear"> </div>
													<!--/Address 1-->
													

													<!--Address 2-->
													<div class="wdthpercent100 pT10">
														<div class="wdthpercent30 left"> 
															<p class="font11 pL5 pT5"> Address 2</p>
														</div>
														<div class="wdthpercent70 left">
															<input readonly="readonly" type="text" value="<?php echo $check_payout_mode['address_2'];?>" name="address_2" class="payoutsubmit">
														</div>
													</div>
													<div class="clear"> </div>
													<!--/Address 2-->								
																							
													<!--Zip Code-->
													<div class="wdthpercent100 pT10">
														<div class="wdthpercent30 left"> 
															<p class="font11 pL5 pT5"> Zip Code </p>
														</div>
														<div class="wdthpercent70 left">
															<input readonly="readonly" type="text" value="<?php echo $check_payout_mode['zip_code'];?>" name="zip_code" class="payoutsubmit required number">

															<input type="hidden" value="check" name="payout_type">
														</div>
													</div>
													<div class="clear"> </div>
													<!--/Zip Code-->

													<p class="font12 pT20 txtright bluelink"> To change Payout&nbsp;&nbsp;<a href="<?php echo $URL_SITE;?>front/acounts.php?type=payout">Click here..</a> </p>
									</div>
									<!--/Check Information------------->
								<?
								}
								else
								{?>
									<div class="payoutgrybgMode fontbld" id="Check_Information_show" style="">
										<p class="font12"> please select your payout mode</p>
										<div class="clear"> </div>									
										<div class="wdthpercent100 pT10">
											<div class="wdthpercent30 left"> 
												<p class="font11 pL5 pT5">To Select Mode</p>
											</div>
											<div class="wdthpercent70 pL20 bluelink"><a href="<?php echo $URL_SITE;?>front/acounts.php?type=payout">Click here..</a></div>
										</div>
										<div class="clear"> </div>									
									</div>				
								<?
								}
						}
						else
						{?>
							<div class="payoutgrybgMode fontbld" id="Check_Information_show" style="">
								<p class="font12"> please select your payout mode</p>				
								<div class="clear"> </div>							
								<div class="wdthpercent100 pT10">
									<div class="wdthpercent30 left"> 
										<p class="font11 pL5 pT5">To Select Mode</p>
									</div>
									<div class="wdthpercent70 pL20 bluelink"><a href="<?php echo $URL_SITE;?>front/acounts.php?type=payout">Click here..</a></div>
								</div>
								<div class="clear"> </div>						
							</div>				
						<?
						}
						?>		
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
				<div class="wthper70 read left" > <a href="<?php echo $URL_SITE?>front/mySwaps.php?type=policy">  Read Policy </a> </div>
				<!-- /Item Rules-->
				</div>
				</div>
				</div>
				<!--/Policies-->

				<!-- terms-->
				<div class="terms">
				<input type='hidden' id="total_price" name="total_price" value="">
				<input type='hidden' id="drop_up" name="drop_up" value="">
				<input type='hidden' id="pick_up" name="pick_up" value="">
				<input type='hidden' id="" name="item_id" value="<?php echo $item_id;?>">
				<input type='hidden' id="" name="owner" value="<?php echo $allItemdetail['owner_id']
			?>">
				<input class="mR5 required" type="checkbox" name="checkbox" width="15" height="15" />
				I agree to the cancellation policy, house rules, and <a href="#"> terms of use </a> 

				</div>
				<!-- /terms-->

				<!--Booking button-->
				<input class="bookit submit-button" type="submit" name="book_it" value="Book It" />
				<script>
				
				</script>
			</form>
	</div>
</div>
 <!-- /BOOKING PAGE  ------------------------>

<?php
include($base_dir.'../../include/footer.php');
?>