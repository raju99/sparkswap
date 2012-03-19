<?php
include('../include/alertHeader.php');
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);
if(isset($_POST['changeproposedDate']))
{	

	$startdate=itemClass::ChangeDate($_POST['pickup']);
	$enddate=itemClass::ChangeDate($_POST['dropoff']);
	$reserveitem=$_POST['reserveid'];	// reservation id
	$item_id=$_POST['item_id'];			// item id
	$renter=$_POST['renter'];// user who is renting	
	$status=user::changeitemStatus($reserveitem,'post');	// change status of an item		
	$subject="Unmatched date";
	$msg="Please choose from given date.click here...";
	$result=user::insertMessage($item_id,$renter,$reserveitem,$subject,$msg);// inserting 
	$changeproposedDate=user::newProposaldate($startdate,$enddate,$reserveitem);
	//to send mails
	$receivename=$_SESSION['user']['user_fname'];
	$receivermail=$_SESSION['user']['user_email'];
	$fromname=$from_name;
	$fromemail=$from_email;
	$server_address='http://electricitynoida.com/spark';
	$mailbody='<div style="  width:738px; height:auto; overflow:hidden; margin:auto;">
	 <!--Listing Email-->
	  <div style=" width:auto; height:auto; overflow:hidden;  padding:0px; background:none;">
	
	   <!--POP UP-->
	   <!--<div class="popup">
	      <h4 class="fontbld font12">
		     Spark Swap sent this message to Amy Baker (Amy415).

		    </h4>
               <h4 class="font12 fontnormal">   Your registered name is included to show this message originated from Spark Swap.
			    <a href="#"> Learn more. </a> </h4>
			 </div>-->
			<!--/POP UP-->

	       <!--Header-->
	        <div style=" width:100%; height:80px; background:none; margin-top:30px;">
	        <!--Logo-->
	         <div style=" background: url('.$server_address.'/images/logo.png) no-repeat top left; padding-right:10px; text-indent:-999em; width:61px; height:79px; float:left; "> SparkSwap </div>
	         <!--/Logo-->
	        <div style="padding-left:20px; float:left; width:605px">
	          <h3 style="font-size:20px; color:#f38630; line-height:25px; text-decoration:none; text-align:left; font-weight:normal; padding-top:10px;"> mmiller123 has proposed new dates for rental of "Wyatt Road Bike" Respond now!  </h3>
		    
			</div>
	     </div>
		 <!--/Header-->
		 
		    <div style="clear:both;"> </div>
			
			
		    <!--Content-->
		    <div style="width:100%;height:auto; overflow:hidden; padding-bottom:20px; ">
			 <div style="padding-top:10px; float:left">
			   <p style="font-size:14px; font-weight:normal">
                              Hi Amy415,  <br />
                              mmiller123 has proposed alternate dates for the rental of "Wyatt Road Bike." Please see details below and respond.

 
				</p>  
							  
				 </div>
				 
				  <div style="clear:both;"> </div>
				   
				     <!--padding 10--> 
				      <div style="padding-top:10px">

				      <!--image-->
						 <div style="height:50px; width:65px; border:2px solid #f91200; overflow:hidden; margin:10px 10px 8px 0px; float:left">
						   <img src="'.$server_address.'/images/cycle_2.png" height="50" width="65" />
						 </div>
					  <!--/image-->
						  
						 <div style="margin-top:10px; padding-left:10px; float:left">
						  
						     <!--Addresh-->

						     <p style="font-size:14px; font-weight:normal" >
						     <a style="color: #0000FF; text-decoration: none;" href="#"> Wyatt Road Bike </a>  <br />
                                          Daily Rental Price: $20.00<br />
										  Owner: mmiller123<br />
										  Proposed Rental Dates: <span style="font-weight:bold"> March 7, 2012 to March 14, 2012 </span> <br />
										  Number of Days: 7<br />
										  Total Cost: $140.00
                             
						    </p>
							<!--/Addresh-->                  
						</div>
					
						<div style="clear:both;"> </div>
						<!--Bottom Button-->
						<div style="width:331px; margin: 100px auto 0; height:auto; overflow:hidden;">
						
						      <!--Green-->
						      <input type="button" name="Accept" value="Accept" style=" background: url('.$server_address.'/images/accept.png) no-repeat left top; border: none; cursor: pointer; font-size: 20px;  padding: 5px 10px 5px 10px; text-align: center; width:129px; height:53px; text-indent:-999em; float:left;"/>
						      <!--/Green-->
						 
						  
						      <!--Red-->
						       <input type="button" name="Propose New Date" value="Deny" style="background: url('.$server_address.'/images/Deny.png) no-repeat left top; border: none; cursor: pointer; font-size: 20px;  padding: 5px 10px 5px 10px; text-align: center; width:129px; height:53px; text-indent:-999em; float:right;"/>
						     <!--/Red-->
						 </div>
						 <!--/Bottom Button-->
					</div>	
					<!--/padding 10--> 
				  </div>
				<!--/Content-->
				
			</div>
			<!--/Listing Email-->
	  </div>';
	$subject='New Date Has been praposed by Owner in Spark Swap';
	mail_to_all_user($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject);

	header("location:".$URL_SITE."front/inbox.php");
}
if(isset($_POST['submit_reason']))	// posting data for reason why owner didnot complete request
{
	if($_POST['reason'])
	{
		$msg_id=$_POST['msg_id'];
		$startdate=$_POST['startRent'];
		$enddate=$_POST['finish_rent'];
		$renter=$_GET['user_id'];
		$item_id=$_GET['item_id'];
		
		$msg=$_POST['reason'];
		
		if($_POST['reason']=='Other')
		{
			$msg=$_POST['deny_other'];
		}
		$latest=inbox::insert_notification($renter,$msg,$startdate,$enddate,$msg_id);
	}
	$_SESSION['msg']=21;
	header('location:inbox.php');
}


if($_GET['action']=='accept')
{
	$action=$_GET['action'];
	$msg_id=$_GET['msg_id'];
	$reserve_id=$_GET['id'];
	$item_id=$_GET['item_id'];
	$user_id=$_GET['user_id'];

	$rentitemdetail=user::mainDetailOfItem($item_id);
	$featurimage=itemClass::select_featured_image($item_id);
	$renter=$user_id;
	$msg_detail=inbox::select_msg_by_id($msg_id);
	$msg_detail=mysql_fetch_assoc($msg_detail);
	
	$renter_detail=user::user_profile($msg_detail['sender_id']);// renter profile

	$pospond_date_res=user::checkRentStatus($reserve_id);
	$pospond_date=mysql_fetch_assoc($pospond_date_res);
	
	if($action=='accept')
	{
		$update=user::update_message($msg_id);
		$status=user::changeitemStatus($reserve_id,$action);
		$subject="Rent Request Accepted";
		$msg="your rent detail is accepted";
		$result=user::insertMessage($item_id,$renter,$reserve_id,$subject,$msg);
	}

	if(isset($_GET['bothendConfirm']))
	{
		$sender_id=$_GET['user_id'];
		$receiver_id=$_SESSION['user']['id'];		
		$subject="Rent Request Accepted";
		$msg="Renter accepted New Dates";
		$result=user::insertMessageOwnerMsg($item_id,$sender_id,$receiver_id,$reserve_id,$subject,$msg);
	}
	if($pospond_date['newissuedate']!='0000-00-00')
	{
		$start = strtotime($pospond_date['newissuedate']);	// if  dates were changed by owner
		$end = strtotime($pospond_date['newienddate']);
		
	}
	else
	{	$start = strtotime($pospond_date['issue_date']);	// if no dates were changed by owner
		$end = strtotime($pospond_date['end_date']);
	}
?>			  
	<div id="container">	
	   <div class="containersearch">  
		<!--Listing Confirm-->
		<div class="listingconfirmtop">
		<h2 class="font22 black">  Congratulations </h2>
		</div>
		<!--/Listing Confirm-->

		<!--Listing Confirm container-->

		<div class="listingconfirmcontainer">
		 <h4 class="font14 fontbld">
				Congratulations! You have confirmed the rental details!
		 </h4>
			
			<div class="clear"> </div>
			<?php if(!isset($_GET['bothendConfirm'])) {?>
			 <h4 class="font14 fontnormal"> You will receive payment once the rental period is complete. </h4>
			<?php } ?>
			 <div class="pT10 left">
			 
		<div class="clear"> </div>

		  <!--image-->
			 <div class="listingconfirmpic left">
			   <img src="<?php echo $URL_SITE?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_id;?>/<?php echo $featurimage['filename'];?>&heigth=50px&width=65px" />
			 </div>
		  <!--/image-->
			  
			  <div class="left mT10 pL10">			  
						<!--Listing Email-->
						<div class="left mT10 pL10">
							<!--Addresh-->
							<h4 class="font14 fontnormal"> 
								<a href="#"> <?=ucwords($renter_detail['username']);?></a>  <br>
								Daily Rental Price:&nbsp;<b>$<?php echo $rentitemdetail['item_Price'];?></b><br />
								
								Renter:<b><?=ucwords($renter_detail['user_fname']);?></b><br />
								
								Proposed Rental Dates:&nbsp;<span class="fontbld"><?php echo date('d F, Y',$start);?>&nbsp;to&nbsp;<?php echo date('d F, Y',$end);?></span> <br />
								<?php								
								$days_between = ceil(abs($end - $start) / 86400);

								$first_number = $rentitemdetail['item_Price'];;
								$second_number = $days_between;
								$Gross_total = $second_number * $first_number;
								?>
								Number of Days:&nbsp;<b><?=$days_between?></b><br />
								Gross Rental Income:&nbsp;<b>$<?=$Gross_total?></b>
							</h4>
							<!--/Addresh-->                  
						</div>
		  </div>
				
				 <div class="clear"> </div>
				 
				  <div class="mT30"> 
					 <h4 class="font14 fontnormal"> Tell your friends:  
					&nbsp; <a href="javascript:;"> <img src="<?php echo $URL_SITE?>images/f_share.png"  /> </a> 
					</h4><br>

					<a class="changedatesubmit mT15" href="<?php echo $URL_SITE;?>/front/inbox.php">OK</a>
				  </div>
				
			  
			      <div class="clear"> </div>
			   
			   
			   </div>
			   <!--/Listing Email-->
			 </div>
			 <!--/Listing Confirm container-->
	   </div>
	</div>
<?
}
?>

<?php
if($_GET['action']=='deny')
{
	
	$action=$_GET['action'];
	$reserve_id=$_GET['id'];
	$msg_id=$_GET['msg_id'];
	$item_id=$_GET['item_id'];
	$user_id=$_GET['user_id'];
	$rentitemdetail=user::mainDetailOfItem($item_id);
	$featurimage=itemClass::select_featured_image($item_id);
	$renter=$user_id;
	$msg_detail=inbox::select_msg_by_id($msg_id);
	$msg_detail=mysql_fetch_assoc($msg_detail);
	$renter_detail=user::user_profile($msg_detail['sender_id']);// renter profile
	
	if($action=='deny')
	{		
		$update=user::update_message($msg_id);
		$status=user::changeitemStatus($reserve_id,$action);
		$subject="Rent Request Deny";
		$msg="Sorry! Your rent Request is denied.";
		$result=user::insertMessage($item_id,$renter,$reserve_id,$subject,$msg);
	}
	if(isset($_GET['bothendConfirm']))
	{
		$sender_id=$_GET['user_id'];
		$receiver_id=$_SESSION['user']['id'];		
		$subject="Rent Request Deny";
		$msg="Sorry! Your rent Request is denied.";
		$result=user::insertMessageOwnerMsg($item_id,$sender_id,$receiver_id,$reserve_id,$subject,$msg);
	}
?>

		<div id="container">			  
			  <!--container search-->
			  <div class="containersearch">
			    <!--Listing Confirm-->
				 <div class="listingconfirmtop">
				   <h2 class="font22 black">  Why can't you complete the transaction?   </h2>
				 </div>
				  <!--/Listing Confirm-->
				  	<form  action="" method="post"> 
				  <div class="denyrental">
				  
				  <div class="wdthpercent100">
				    <div class="txtleft wdthpercent36 left">
					    <input type="radio" checked='checked' name="reason">    <span class="radiotxt"> Propose alternate dates: </span>   
				   </div>
				   
				   
				   <!--Start Rental-->
				   
				   <div class="wdthpercent32 left"> 
				      
				        <div class="left pR5">
				        <span class="radiotxt"> Start Rental  </span>
						</div>

						   <input type="text" name="startRent" id="startRent"value="" class="rentaldate left">
						  
						</div>
					<!--/Start Rental-->
			
						  
						  <!--Finish Rental-->
						  <div class="wdthpercent32 left"> 
				        
				           <div class="left pR5">
				             <span class="radiotxt"> Finish Rental  </span>
						   </div>
						   <input type="text" name="finish_rent" id="finish_rent" value="" class="rentaldate left">
						 </div>
						  <!--/Finish Rental-->
						  </div>
						  <div class="clear"> </div>
						  
						  
						  <!-- damaged-->
						  <div class="left">
						    <input type="radio" value="Item has been damaged" name="reason">    
						    <span class="radiotxt"> Item has been damaged  </span>
						  </div>
						  <!-- /damaged-->
						  <div class="clear"> </div> 
						  
						  <!--my possession-->
						  <div class="pT10 left">
						    <input type="radio" value="Item is no longer in my possession" name="reason">    
						     <span class="radiotxt"> Item is no longer in my possession </span>
						  </div>
						  
						   <!--/my possession-->
						  <div class="clear"> </div>
						  
						  <!--Other -->
						   <div class="pT10 left">
						      <input type="radio" value="Other" name="reason">    
						      <span class="radiotxt">Other </span>
						  
						     <!--Input -->
						     <input type="text" value="" name="deny_other" class="denyinput">  
						     <!--/Input -->
						  
						  </div>
						  <!--/Other -->
						  <div class="clear"> </div>
						  
						  
						  <!--Submit-->
						  <input type="hidden" name="item_id" value="<?php echo $item_id?>">
						   <input type="hidden" name="user_id" value="<?php echo $user_id?>">
						   <input type="hidden" name="msg_id" value="<?php echo $_GET['msg_id'];?>">
						  <a href="<?php echo $URL_SITE;?>/front/inbox.php"><input type="submit" value="Submit" name="submit_reason" class="changedatesubmit mT15"></a>
						 <!--/Submit-->
					
						  <div class="clear"> </div>
						
				</div>
				</form>
				<!--container search-->
			</div>
		  <!--/Content-->
	 </div>
<?
}
?>

<?php
if($_GET['action']=='post')
{
	$action=$_GET['action'];
	$reserve_id=$_GET['id'];
	$item_id=$_GET['item_id'];
	$msg_id=$_GET['msg_id'];
	$user_id=$_GET['user_id'];
	$rentitemdetail=user::mainDetailOfItem($item_id);
	$featurimage=itemClass::select_featured_image($item_id);
	$renter=$user_id;
	$msg_detail=inbox::select_msg_by_id($msg_id);
	$msg_detail=mysql_fetch_assoc($msg_detail);
	$renter_detail=user::user_profile($msg_detail['sender_id']);// renter profile
?>
    <div id="container">	
		  <form method="post" action="">
				<div class="containersearch">
						<!--Listing Confirm-->
						<div class="listingconfirmtop">
							<h2 class="font22 black">  Propose Alternate Dates </h2>
						</div>
						<!--/Listing Confirm-->

						<!--main container-->
						<div class="changedate">				  
							<!--Start Rental-->
							<div class="left pR10 pT5">
								<h4> Start Rental </h4>
							</div>
							<input type="text" value="<?php if(isset($_SESSION['search']['pickup_date'])) {	echo $_SESSION['search']['pickup_date']; } ?>" name ="pickup" id="pickupother" class="required rentaldate left"/>
							<!--/Start Rental-->

							<!--Finish Rental-->
							<div class="right">
								<div class="left pR10 pT5">
									<h4> Finish Rental </h4>
								</div>
								<input type="text" value="<?php if(isset($_SESSION['search']['pickup_date'])) {	echo $_SESSION['search']['pickup_date']; } ?>" name ="dropoff" id="dropoffother" class="required rentaldate left"/>
							</div>
							<!--/Finish Rental-->

							<div class="clear"> </div>
							<!--Submit-->
							<input type="hidden" value="<?=$_GET['id']?>" name="reserveid">
							<input type="hidden" value="<?=$_GET['item_id']?>" name="item_id">
							<input type="hidden" value="<?=$renter?>" name="renter">
							<input type="submit" value="Submit" name="changeproposedDate" class="changedatesubmit mT15">
							<!--/Submit-->
					 </div>
					<!--/main container-->
				</div>

			 </form>
		</div>
<?
}
?>

<?php
if($_GET['action']=='posponddate')
{
	$action=$_GET['action'];
	$reserve_id=$_GET['id'];
	$msg_id=$_GET['msg_id'];
	$item_id=$_GET['item_id'];
	$user_id=$_SESSION['user']['id'];
	$rentitemdetail=user::mainDetailOfItem($item_id);
	$owner_id=$rentitemdetail['owner_id'];
	$feature_image=itemClass::select_featured_image($item_id);
	$pospond_date_res=user::checkRentStatus($reserve_id);
	$pospond_date=mysql_fetch_assoc($pospond_date_res);	
	$msg_detail=inbox::select_msg_by_id($msg_id);
	$msg_detail=mysql_fetch_assoc($msg_detail);
	$ownerDetail=user::user_profile($owner_id);// owner profile
	//print_r($ownerDetail);
	$renterDetail=user::user_profile($user_id);// renter profile
	$update=user::update_message_confirm($msg_id);
?>

   <div class="listingemail">
	
	   <!--Content-->
	   <div id="container">
			 <div class="pT10 left">
			  <p class="font14 fontnormal">
                 Hi!&nbsp;<?=ucwords($renterDetail['user_fname']);?>&nbsp;,<br><?=ucwords($ownerDetail['user_fname']);?>&nbsp;has proposed alternate dates for the rental of "&nbsp;<?=ucwords($rentitemdetail['item_name']);?>"&nbsp;.Please see details below and respond.

 
				</p>  
							  
				 </div>
				 
				  <div class="clear"> </div>
				   
				   
				      <div class="pT10">

				      <!--image-->
						 <div class="listingconfirmpic left">
						   <img width="65" height="50" src="<?php echo $URL_SITE?>classes/show_image.php?filename=../images/itemimages/<?php echo $item_id;?>/<?php echo $feature_image['filename'];?>&width=65px&heigth=50px">
						 </div>
					  <!--/image-->
						  
						  <div class="left mT10 pL10">
						  
						     <!--Addresh-->

						     <h4 class="font14 fontnormal"> 
						     <a href="#"> <?=ucwords($rentitemdetail['item_name']);?></a>  <br>
                                          Daily Rental Price:&nbsp;<b>$<?php echo $rentitemdetail['item_Price'];?></b><br />
										  Renter:<b><?=ucwords($renterDetail['user_fname']);?></b><br />
										  Proposed Rental Dates:&nbsp;<span class="fontbld"><?php echo date('d F, Y',strtotime($pospond_date['newissuedate']));?>&nbsp;to&nbsp;<?php echo date('d F, Y',strtotime($pospond_date['newienddate']));?></span> <br />
										  <?php
											$start = strtotime($pospond_date['newissuedate']);
											$end = strtotime($pospond_date['newienddate']);
											$days_between = ceil(abs($end - $start) / 86400);

											$first_number = $rentitemdetail['item_Price'];;
											$second_number = $days_between;
											$Gross_total = $second_number * $first_number;
										  ?>
										  Number of Days:&nbsp;<b><?=$days_between?></b><br />
										  Gross Rental Income:&nbsp;<b>$<?=$Gross_total?></b>
                             
						    </h4>
							<!--/Addresh-->                  
						</div>
					
						<div class="clear"> </div>
						<!--Bottom Button-->
						<div class="Esellerbtn">
						
						      <!--Green-->
							  <div class="left">
								<input class="EsellerGreenbtn left" onclick="javascript: sendRequestConfirm('accept','&bothendConfirm&msg_id=<?=$msg_id?>&item_id=<?php echo $item_id;?>&id=<?php echo $reserve_id;?>&user_id=<?=$owner_id?>');" type="button" name="Accept" value=" " />
							  </div>
						      <!--/Green-->					      
						  
						      <!--Red-->
						      <div class="pL20 left">
								<input onclick="javascript: sendRequestConfirm('deny','&bothendConfirm&&msg_id=<?=$msg_id?>item_id=<?php echo $item_id; ?>&id=<?php echo $reserve_id;?>&user_id=<?=$owner_id?>');" class="EsellerGreenbtn redbtn left" type="button" name="Deny" value=" " />
						      </div>
						      <!--/Red-->
						 </div>
						 <!--/Bottom Button-->
						 
				  </div>
				<!--/Content-->
				
			</div>
			<!--/Listing Email-->
	  </div>
	  <script>
	  function sendRequestConfirm(action,query)
	  {
			document.location.href='postRental.php?action='+action+query;
	  }
	  </script>
</div>
<?
}
?>



<?php
if($_GET['action']=='acceptSuccus')
{
	$action=$_GET['action'];
	$reserve_id=$_GET['id'];
	$item_id=$_GET['item_id'];
	$msg_id=$_GET['msg_id'];
	//$owner_id=$_GET['owner_id'];

	$rentitemdetail=user::mainDetailOfItem($item_id);
	$featurimage=itemClass::select_featured_image($item_id);

	$pospond_date_res=user::checkRentStatus($reserve_id);
	$pospond_date=mysql_fetch_assoc($pospond_date_res);
	$pospond_date['user_id'];
	$msg_detail=inbox::select_msg_by_id($msg_id);
	$msg_detail=mysql_fetch_assoc($msg_detail);
	if($pospond_date['user_id']==$_SESSION['user']['id'])
	{
		$renter_detail=user::user_profile($pospond_date['owner_id']);// renter profile
	}
	else
	{
		$owner_detail=user::user_profile($pospond_date['user_id']);// owner profile
	}
	
	
	$update=user::update_message_confirm($msg_id);
?>			  
	<div id="container">	
	   <div class="containersearch"> 
	   <div id="" class="pT10 pB10">
			
	   </div>
		<!--Listing Confirm-->
		<div class="listingconfirmtop">
		<h2 class="font22 black">  Congratulations </h2>
		</div>
		<!--/Listing Confirm-->

		<!--Listing Confirm container-->

		<div class="listingconfirmcontainer">
		 <h4 class="font14 fontbld">
				Congratulations! You have confirmed the rental details!
		 </h4>
			
			<div class="clear"> </div>
			
			 <h4 class="font14 fontnormal"> You will receive payment once the rental period is complete. </h4>	
			 <div class="pT10 left">
			 
		<div class="clear"> </div>

		  <!--image-->
			 <div class="listingconfirmpic left">
			   <img src="<?php echo $URL_SITE?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_id;?>/<?php echo $featurimage['filename'];?>&heigth=50px&width=65px" />
			 </div>
		  <!--/image-->
			  
			  <div class="left mT10 pL10">			  
						<!--Listing Email-->
						<div class="left mT10 pL10">
							<!--Addresh-->
							<h4 class="font14 fontnormal"> 
								<a href="javascript:;"> <?=ucwords($rentitemdetail['item_name']);?></a>  <br>
								Daily Rental Price:&nbsp;<b>$<?php echo $rentitemdetail['item_Price'];?></b><br />
								<?php if(isset($renter_detail))
								{?>
								Owner:<b><?=ucwords($renter_detail['username']);
								}
								else
	{
									echo 'Renter:<b>'.ucwords($owner_detail['username']);
	}
								?></b><br />
								Proposed Rental Dates:&nbsp;<span class="fontbld"><?php echo date('d F, Y',strtotime($pospond_date['issue_date']));?>&nbsp;to&nbsp;<?php echo date('d F, Y',strtotime($pospond_date['end_date']));?></span> <br />
								<?php
								$start = strtotime($pospond_date['issue_date']);
								$end = strtotime($pospond_date['end_date']);
								$days_between = ceil(abs($end - $start) / 86400);

								$first_number = $rentitemdetail['item_Price'];;
								$second_number = $days_between;
								$Gross_total = $second_number * $first_number;
								?>
								Number of Days:&nbsp;<b><?=$days_between?></b><br />
								Gross Rental Income:&nbsp;<b>$<?=$Gross_total?></b>
							</h4>
							<!--/Addresh-->                  
						</div>
		      </div>
				
				 <div class="clear"> </div>
				 
				  <div class="mT30"> 
					 <h4 class="font14 fontnormal"> Tell your friends:  
					&nbsp; <a href="#"> <img src="<?php echo $URL_SITE;	?>images/f_share.png"  /> </a> 
					</h4><br>

					<a class="changedatesubmit mT15" href="<?php echo $URL_SITE;?>/front/inbox.php">OK</a>
				  </div>
				
			  
			      <div class="clear"> </div>
			   
			   
			   </div>
			   <!--/Listing Email-->
			 </div>
			 <!--/Listing Confirm container-->
	   </div>
	</div>
<?
}
?>

<?php
if($_GET['action']=='denySuccus')
{
	$action=$_GET['action'];
	$reserve_id=$_GET['id'];
	 $item_id=$_GET['item_id'];
	$msg_id=$_GET['msg_id'];
	//$user_id=$_GET['user_id'];
	//$owner_id=$_GET['owner_id'];
	$rentitemdetail=user::mainDetailOfItem($item_id);
	$featurimage=itemClass::select_featured_image($item_id);	
	$renter=$user_id;
	$msg_detail=inbox::select_msg_by_id($msg_id);
	$msg_detail=mysql_fetch_assoc($msg_detail);
	$renter_detail=user::user_profile($msg_detail['sender_id']);// renter profile
	$message_detail=inbox::select_notification($msg_id);	
	
?>

		<div id="container">			  
			  <!--container search-->
			  <div class="containersearch">
				<div id="" class="pT10 pB10">
					<?php if(isset($_SESSION['msg'])) { echo $_SESSION['msg']="18";}?>
				</div>
			    <!--Listing Confirm-->
				 <div class="listingconfirmtop">
				   <h2 class="font22 black"> OWner can't be Accept Your Request Due to   </h2>
				 </div>
				  <!--/Listing Confirm-->
				  
				  <div class="denyrental">		  
				  
				   <div class="pT10">

				      <!--image-->
						 <div class="listingconfirmpic left">
						   <img src="<?php echo $URL_SITE?>classes/show_image.php?filename=../images/itemimages/<?php echo $item_id;?>/<?php echo $featurimage['filename'];?>&width=65px&;heigth=50px">
						 </div>
					  <!--/image-->
						  
						  <div class="left mT10 pL10">
						  
						     <!--Addresh-->

						     <h4 class="font14 fontnormal"> 
						     <a href="#"> 
							 <?php echo $rentitemdetail['item_name']?></a>  <br>
                              Daily Rental Price:&nbsp;<b>$<?php echo $rentitemdetail['item_Price']?></b><br>						 
							  <?php if($message_detail['startdate']!='0000-00-00')
							{
								echo 'Proposed Rental dates:'.date('d M,Y',$message_detail['startdate']).' to '. date('d M,Y',$message_detail['enddate']);
							}
							else
							{
								echo $message_detail['message'];
							}
													 
							 ?>
						    </h4>
							<!--/Addresh-->                  
						</div>
					
						<div class="clear"> </div>
						<!--Bottom Button-->
						<div class="Esellerbtn">
						
						      
						      <!--/Red-->
						 </div>
						 <!--/Bottom Button-->
						 
				  </div>
				   
				  
						
				</div>
				<!--container search-->
			</div>
		  <!--/Content-->
	 </div>
<?
}

include('../include/alertFooter.php');
?>

