<?php
ob_start();
session_start();
include ('../include/alertHeader.php');

if(!isset($_SESSION['user']))
{
	header("location:".$URL_SITE."front/login.php");
}

if(isset($_GET['item_id']))
{
	$item_id=$_GET['item_id'];
	$reservationid=$_GET['id'];
	$msg_id=$_GET['msg_id'];	
}

$update=user::update_message($msg_id);
$check=itemClass::checkDetail($_GET['id']);

$msg_detail_res=inbox::select_msg_by_id($_GET['msg_id']);
$msg_detail=mysql_fetch_assoc($msg_detail_res);
$renter_detail=user::user_profile($msg_detail['sender_id']);// renter profile
//echo "<pre>";print_r($msg_detail);echo "</pre>";
$rentitemdetail=user::mainDetailOfItem($item_id);// Details of item
$featurimage=itemClass::select_featured_image($item_id);// select image of item
$dates=itemClass::renter_praposal_date($item_id,$renter_detail['id']);// to check date by renter

if($dates['newissuedate']!='0000-00-00')
{
	$start = strtotime($dates['newissuedate']);	// if  dates were changed by owner
	$end = strtotime($dates['newienddate']);
		
}
else
{	
	$start = strtotime($dates['issue_date']);	// if no dates were changed by owner
	$end = strtotime($dates['end_date']);
}
?>


<!--Content-->
<div id="container pB10">

	<?php if($check['item_status']!=0) { echo "<font color='green'><center><h2>Action Already Performed</h2></center></font>"; }?>
	    
		<!--/Logo-->
	    <div class="left pT20">		  		 
	      <h3>Please respond to your rental request, you have 24 hours remaining!  </h3>
		</div>

		 <div class="pT10 left">
			  <h4 class="font14 fontnormal">Hi&nbsp;<?php echo $_SESSION['user']['user_fname'];?>, <br />Please respond to this request within the next 24 hours to confirm the details of the transaction. You may accept the proposed rental dates, message the other party to propose different dates or deny the request with an explanation of why you can't complete the transaction.</h4>							  
		</div>
			  
	    <div class="clear"></div>			   
				   
	    <div class="pT10 left">
			<!--image-->
			<div class="listingconfirmpic left">			
					<img src="<?php echo $URL_SITE;?>classes/show_image.php?filename=../images/itemimages/<?php echo $item_id;?>/<?php echo $featurimage['filename']?>&heigth=50px&width=65px" />
			</div>
			<!--/image-->
			  
			<div class="left mT10 pL10">						  
				 <!--Addresh-->
				 <h4 class="font14 fontnormal" > 
					<a href="<?php echo $URL_SITE;?>/front/viewItem.php?item_id=<?php echo $item_id;?>"> <?php echo $rentitemdetail['item_name']?> </a> <br />
					Daily Rental Price: $<?php echo $rentitemdetail['item_Price'];?><br />
					Renter: <?php echo $renter_detail['username'];?> <br />	
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

		<?php
		if($check['item_status']==0)
		{?>
				<!--Bottom Button-->
				<div class="Erentedbtn pT30">						
					  <!--Green-->
					  <div class="left">
						<input class="EsellerGreenbtn left" onclick="javascript: sendRequest('accept','&msg_id=<?php echo $msg_detail['msg_id'];?>&item_id=<?php echo $item_id;?>&id=<?php echo $msg_detail['reservation_id'];?>&user_id=<?=$msg_detail['sender_id']?>');" type="button" name="Accept" value=" " />
					  </div>
					  <!--/Green-->
				 
					  <!--Yellow-->
					  <div class="pL84 left">
						<input onclick="javascript: sendRequest('post','&msg_id=<?php echo $msg_detail['msg_id'];?>&item_id=<?php echo $item_id; ?>&id=<?php echo $msg_detail['reservation_id'];?>&user_id=<?=$msg_detail['sender_id']?>');" class="yellowbtn EsellerGreenbtn  left" type="button" name="Propose New Date" value=" " />
					  </div>
					  <!--/Yellow-->
				  
					  <!--Red-->
					 <div class="pL84 left">
						<input onclick="javascript: sendRequest('deny','&msg_id=<?php echo $msg_id;?>&item_id=<?php echo $item_id; ?>&id=<?php echo $msg_detail['reservation_id'];?>&user_id=<?=$msg_detail['sender_id']?>');" class="EsellerGreenbtn redbtn left" type="button" name="Deny" value=" " />
					 </div>
					 <!--/Red-->
				 </div>
				 <!--/Bottom Button-->
		 <?
		 }						
		 ?> 

		 <script>
			function sendRequest(action,query)
			{
				document.location.href='postRental.php?action='+action+query;
			}
		 </script>
</div>


