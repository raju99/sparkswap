<?php
if(isset($_POST['paypal_deposit']))	//PayPal Information
{
	//echo"<pre>";print_r($_POST);die;
	$user_id=$_SESSION['user']['id'];
	$insert=user::payoutPreferencesPaypal($user_id);
	
	if($insert)
	{
		$_SESSION['msg']=24;
		header("location:".$URL_SITE."front/acounts.php?type=payout");
		exit;
	}
	 
}
if(isset($_POST['Direct_Information_deposit']))	//Direct Information deposit
{
	//echo"<pre>";print_r($_POST);die;
	$user_id=$_SESSION['user']['id'];
	$insert=user::DirectInformationDeposit($user_id);
	
	if($insert)
	{
		$_SESSION['msg']=24;
		header("location:".$URL_SITE."front/acounts.php?type=payout");
		exit;
	}
	 
}

if(isset($_POST['check_information_deposit']))	//check information deposit
{
	//echo"<pre>";print_r($_POST);die;
	$user_id=$_SESSION['user']['id'];
	$insert=user::checkInformationDeposit($user_id);
	
	if($insert)
	{
		$_SESSION['msg']=24;
		header("location:".$URL_SITE."front/acounts.php?type=payout");
		exit;
	}
	 
}
?>
<!--PAYOUT PREFERENCES------------------------------------------->
<div class="wdthpercent100">
	<div class="payoutwhitebg">
		<div class="dashprivacyprofile">	
		 
			<div class="wdthpercent100">
			   <h4 class="verified">Payout Method</h4>
			    
							<!--payout top------------------------>
							<div class="payouttop pT10">
									 
									 <p class="txtleft fontbld">Payments are only allowed to US residents</p>
									 <br class="clear">
									 <p class="font10"> You have not set up any methods for receiving payments</p>
									 
									 <br class="clear">

									 <p class="font10 pL30"> We can send you money in the following ways: </p>
									 
									 <div class="clear pB10"></div>
									  
									 <div class="payoutoption fontbld">
									   
											<div class="pL25 wdthpercent100">
												<div class="wdthpercent20 left">
												<p class="font12"> Method </p>
												</div>

												<div class="wdthpercent20 left">
												<p class="font12"> Arrives on </p>
												</div>

												<div class="wdthpercent20 left">
												<p class="font12"> Fees </p>
												</div>

												<div class="wdthpercent34 left">
												<p class="font12"> Notes </p> 
												</div>
											</div>
											<br class="clear">
									  
											<div class="wdthpercent100 pT10" id="paypal_click">
												<div class="wdth25 left">
													<input type="radio" value="p" name="deposit"> 
												</div>
												<div class="wdthpercent20 left">
													<p class="font12"> Paypal </p> 
												</div>
												<div class="wdthpercent20 left">
													<p class="font10 "> Instant </p>
												</div>
												<div class="wdthpercent20 left">
													<p class="font10 "> None</p> 
												</div>
												<div class="wdthpercent34 left"> 
													<p class="font10 ">Withdray money from your PayPayl to your local bank account  </p>
												</div>
											</div>
											<br class="clear">
									  
											<div class="wdthpercent100 pT10" id="Direct_Deposit_click">
												<div class="wdth25 left">
													<input type="radio" value="d" name="deposit"> 
												</div>
												<div class="wdthpercent20 left"> 
													<p class="font12 txtbold"> Direct Deposit </p>
												</div>
												<div class="wdthpercent20 left">  
													<p class="font10 "> Next business day </p> 
												</div>
												<div class="wdthpercent20 left"> 
													<p class="font10 "> None</p> 
												</div>
												<div class="wdthpercent34 left"> 
													<p class="font10 ">Initial setup takes 5 days; not released on weekends  </p>
												</div>
											</div>
											<br class="clear">


											<div class="wdthpercent100 pT10" id="Check_Deposit_click">
												<div class="wdth25 left">
													<input type="radio" value="c" name="deposit"> 
												</div>
												<div class="wdthpercent20 left"> 
													<p class="font12 txtbold"> Check </p> 
												</div>
												<div class="wdthpercent20 left"> 
													<p class="font10 "> 7-10 Days </p> 
												</div>
												<div class="wdthpercent20 left">  
													<p class="font10 "> None</p> 
												</div>

												<div class="wdthpercent34 left">&nbsp;</div>
											</div>
									  
									  </div>

							</div>
							<!--/payout top------------------>
							<br class="clear">

							<!--paypal information------------>
							<div class="payoutgrybg fontbld" id="PayPal_Information_show" style="display:none;">
									<p class="font12 pB10"> PayPal Information </p>

										<form method="post" action="" id="PayPal_Information_form" enctype="multipart/form-data">
												<!--Payment-->
												<div class="wdthpercent100 pT10">
													<div class="wthper50 left"> 
													<p class="font11 pL5 pT5"> What e-mail should we send payment to? </p>
													</div>
													<div class="wthper50 left">
													<input type="text" value="" name="payout_email" class="payoutsubmit required">
													</div>
												</div>
												<!--/Payment-->

												<div class="clear"> </div>

												<div class="wdthpercent100 pT10">
													<div class="right">
														<input type="submit" value="Save" name="paypal_deposit" class="payoutbutton">
														<input type="hidden" value="paypal" name="payout_type">
													</div>
												</div>
										</form>
							</div>
							<!--/paypal information-------------->
						 
							<!--Direct Deposit--------------->
							<div class="payoutgrybg fontbld" id="Direct_Information_show" style="display:none;">				
								<p class="font12 pB10"> Direct Deposit (ACH) Information </p>
						   
										<form method="post" action="" id="Direct_Deposit_Information_form" enctype="multipart/form-data">
												
												<!--Name-->
												<div class="wdthpercent100 pT10">

													<div class="wdthpercent30 left"> 
														<p class="font11 pL5 pT5"> Name on account</p>
													</div>
													
													<div class="wdthpercent70 left">
														<input type="text" value="" name="name_on_account" class="payoutsubmit required">
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
														<select class="required" name="account_type">
															<option selected="selected" value="Cheking"> checking </option>
															<option value="saving"> saving </option>
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
														<input type="text" value="" name="routing_number" maxlength="9" class="payoutsubmit required number">
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
														<input type="text" value="" name="account_number" class="payoutsubmit required number">
													</div>
												</div>
												<div class="clear"> </div>
												<!--/Account number-->
												
												<div class="wdthpercent100 pT10">
													<div class="right">
														<input type="submit" value="Save" name="Direct_Information_deposit" class="payoutbutton">
														<input type="hidden" value="direct" name="payout_type">
													</div>
												</div>
										</form>
						  
						  </div>
						  <!--/Direct Deposit--------------->  
						  
						  <div class="clear"> </div>						 
						  					
						  <!--Check Information---------------->
						  <div class="payoutgrybg fontbld" id="Check_Information_show" style="display:none;">
								<p class="font12 pB10"> Check Information </p>
								<div class="clear"> </div>

								<form method="post" action="" id="Check_Information_show_form" enctype="multipart/form-data">
										<!--Name-->
										<div class="wdthpercent100 pT10">
											<div class="wdthpercent30 left"> 
												<p class="font11 pL5 pT5"> Name on Check </p>
											</div>
											<div class="wdthpercent70 left">
												<input type="text" value="" name="name_on_check" class="payoutsubmit required">
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
												<select name="country" class="required">
													<option value="NY" selected="selected"> New York </option>
													<option value="USA"> USA </option>
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
												<select name="state" class="required">
													<option selected="selected" value="Alabama"> Alabama </option>
													<option value="Elabama"> Elabama </option>
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
												<input type="text" value="" name="city" class="payoutsubmit required">
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
												<input type="text" value=" " name="address_1" class="payoutsubmit required">
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
												<input type="text" value=" " name="address_2" class="payoutsubmit">
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
												<input type="text" value="" name="zip_code" class="payoutsubmit required number">
											</div>
										</div>
										<div class="clear"> </div>
										<!--/Zip Code-->									
										
										<div class="wdthpercent100 pT10">
											<div class="right">
												<input type="submit" value="Save" name="check_information_deposit" class="payoutbutton">
												<input type="hidden" value="check" name="payout_type">
											</div>
										</div>
								</form>
						  
						</div>
						<!--/Check Information------------->
			</div>										 
		</div>
	</div>
</div>
<!--/PAYOUT PREFERENCES------------------------------------->

<script type="text/javascript">
	jQuery(document).ready(function(){  
	jQuery("#Direct_Deposit_Information_form").validate();
	jQuery("#Check_Information_show_form").validate();
});
</script>

<script language="javascript">
$(document).ready(function(){	 
	$("#PayPal_Information_form").validate({			   
             rules: 
			 { 				
					 "payout_email":
					 {
						remote: URL_SITE+"/front/userAvailibility.php",
					 }
			},
			messages: 
			{				
					"payout_email": 
					{
						remote: jQuery.format("<font color='red'>Email Exist</font>")
					}
									
			}
       });
 });
</script>