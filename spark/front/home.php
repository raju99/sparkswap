<?php
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);

$basedir=dirname(__FILE__)."../../";	
include($basedir.'/include/header.php');

if(!isset($_SESSION['user']))
{

	header("location:".$URL_SITE."front/login.php");
}

if(isset($_SESSION['item_for_search']))
{
	$item_id=$_SESSION['item_for_search'];
	unset($_SESSION['item_for_search']);
	header('location:'.$URL_SITE.'front/viewItem.php?item_id='.$item_id);
}

$user_id=$_SESSION['user']['id'];
$res_inbox=inbox::select_messages_for_dashboard($user_id);
$nmber_of_msg=mysql_num_rows($res_inbox);
$nmber_of_unread=inbox::select_unread_messages_for_user($user_id);
$nmber_of_unread=mysql_num_rows($nmber_of_unread);
$user=user::user_profile($user_id);
?>

<div class="wdthpercent100">
<!--Dashboard Left-->
<div class="DashboarddivL">
<!--Dashboard profile-->
<div class="dashwhitebg mB15">
	<div class="dashboardprofile">
		<p class="pB10">
		<?php if(!empty($user['user_picture'])) {?>
			<img src="<?php echo $URL_SITE ;?>classes/show_image.php?filename=../images/profile/<?php echo $user['user_picture'];?>&width=140px&heigth=135px" alt="" />

			<?php
			}
			else
			{
			?>
				<img src="<?=$URL_SITE?>classes/show_image.php?filename=../images/noimage.jpg&width=140px&heigth=135px">
			<?php
			}
			?>
	
		
		</p>
		<p><?php echo $_SESSION['user']['user_fname'];?><br />
		<a href="<?php echo $URL_SITE;?>/front/profile.php">Edit Profile</a>
		</p>
	</div>
</div>
<!--/Dashboard profile-->
<!--Dashboard Varification-->
<div class="dashwhitebg">
<?php $socialWeb_status_res=user::socialWebstatusofUser($_SESSION['user']['id']);
$socialWeb_status=mysql_fetch_array($socialWeb_status_res);
//print_r($socialWeb_status);
?>
	<div class="dashvarification">
		<h3>Verification</h3>
		<ul>
		<?php if($socialWeb_status['facebook_status']=='1') {?>
			<li><a href="#" class="facebook">Facebook Connected</a></li>
		<?php } 
		if($socialWeb_status['twitter_status']=='1')
		{
		?>
			<li><a href="#" class="twitter">Twiiter Connected</a></li>
		<?php } 
		if($socialWeb_status['linkedin_status']=='1')
		{
		?>
			<li><a href="#" class="linkedin">LinkedIn Connected</a></li>
		<?php } 
		if(($socialWeb_status['linkedin_status']!='1') || ($socialWeb_status['twitter_status']!='1') ||
		($socialWeb_status['facebook_status']!='1'))
		{

			echo '<li class="colororange"><a  href="'.$URL_SITE.'front/verification.php">Varified more</a></li>';
			
		}
		?>
		</ul>
	</div>
</div>
<!--/Dashboard Varification-->
</div>
<!--/Dashboard Left-->
<!--Dashboard Right-->
<div class="DashboarddivR">
<div class="dashwhitebg mB10">
	<div class="dasbmessages">
		<h3>Messages (<?php echo $nmber_of_unread;?> New)</h3>
			<?php
			if($nmber_of_msg > 0)
			{	
				$i=0;
				while($mesg=mysql_fetch_assoc($res_inbox))
				{
					//echo "<pre>";print_r($mesg);echo "</pre>";					
					if($i>5)
					break;
					$on_which_reply_did_res=inbox::select_msg_by_id($mesg['replied_on_id']);
					$on_which_reply_did=mysql_fetch_assoc($on_which_reply_did_res);

					$frnd_user=user::user_profile($mesg['sender_id']);

					$checkacepteddeniedPost_res=user::checkRentStatus($mesg['reservation_id']);
					$checkRentStatusOfUSer=mysql_fetch_assoc($checkacepteddeniedPost_res);
					//echo "<pre>";print_r($checkRentStatusOfUSer);echo "</pre>";
				    ?>
					<div class="dasbmessagesbdr">
						<div class="dasbmessagespicdiv">
							<?php
							if(!empty($frnd_user['user_picture']))
							{
							?>
								<img src="<?=$URL_SITE?>classes/show_image.php?filename=../images/profile/<?php echo $frnd_user['user_picture'];?>&height=67px&width=47px">
							<?php
							}
							?>
						</div>
						<div class="dasbmessagesdatediv">
							<?php echo $frnd_user['user_fname'];?><br /><?php echo date('m/d/Y',strtotime($mesg['date']));?>
						</div>
						
						<div class="dasbmessagescontdiv">
							<?php
								if($checkRentStatusOfUSer['item_status']=='1')//proposed date
								{?>
									<p class="colororange">
										<a class="colororange" href="postRental.php?action=posponddate&msg_id=<?php echo $mesg['msg_id'];?>&item_id=<?php echo $mesg['item_id'];?>&id=<?php echo $mesg['reservation_id'];?>"><?php echo $mesg['subject'];?><br><?php echo $mesg['content'];?>
										</a>
									</p>	
									
									
								<?
								}
								elseif($checkRentStatusOfUSer['item_status']=='2')//deny Request
								{?>
									<p class="colororange">
										<a class="colororange" href="postRental.php?action=denySuccus&msg_id=<?php echo $mesg['msg_id'];?>&item_id=<?php echo $mesg['item_id'];?>&id=<?php echo $mesg['reservation_id'];?>"><?php echo $mesg['subject'];?><br><?php echo $mesg['content'];?>
										</a>
									</p>	

									
								<?
								}
								elseif($checkRentStatusOfUSer['item_status']=='3')//accept Request
								{?>
									<p class="colororange">
										<a class="colororange" href="postRental.php?action=acceptSuccus&msg_id=<?php echo $mesg['msg_id'];?>&item_id=<?php echo $mesg['item_id'];?>&id=<?php echo $mesg['reservation_id'];?>"><?php echo $mesg['subject'];?><br><?php echo $mesg['content'];?>
										</a>
									</p>	
									
								<?
								}
								elseif($checkRentStatusOfUSer['item_status']=='0')//rent Request
								{?>
									
									<p class="colororange">
										<a class="colororange" href="userRentListing.php?msg_id=<?php echo $mesg['msg_id'];?>&item_id=<?php echo $mesg['item_id'];?>&id=<?php echo $mesg['reservation_id'];?>"><?php echo $mesg['subject'];?><br><?php echo $mesg['content'];?>
										</a>
									</p>								
									
								<?
								}

								?>
								<br/>
								<p>					
								<?php
								if(!empty($on_which_reply_did['content']))
								{
								echo 'Re'.$on_which_reply_did['content'];
								}
								?>
								</p>
							
						</div>
					</div>
				<?php
				}
			}
			?>
			
				<div class="wdthpercent100 pT10">
					<a href="<?php echo $URL_SITE?>front/inbox.php" class="dashbutton">Go to all Messages</a>
				</div>
			
	</div>
</div>
<?php $res=payment::all_payments_for_user($_SESSION['user']['id']) ;
$res=mysql_query($res);
$count_of_transcation=mysql_num_rows($res);
$transaction_array=array();
while($row=mysql_fetch_assoc($res))
{
	$transaction_array[]=$row;
}
$transaction_array=array_slice($transaction_array,0,4);

?>
<div class="dashwhitebg mB10">
	<div class="dasbmessages">
		<h3>Transactions (<?php echo $count_of_transcation;?> New)</h3>
		<?php if($count_of_transcation>0){ foreach($transaction_array as $row){
			
			$payer_details=user::user_profile($row['payer_id'])
			?>
		 <div class="dasbmessagesbdr">
			<div class="dasbmessagespicdiv"><img src="<?php echo $URL_SITE?>classes/show_image.php?filename=../images/profile/<?php echo $payer_details['user_picture']?>&width=45px&heigth=50px" alt="No image" /></div>
			<div class="dasbmessagesdatediv"> <br /><?php echo date('Y/m/d',strtotime($row['payment_date']))?></div>
			<div class="dasbmessagescontdiv txtright">
				<span class="dashpriceshow">$<?php echo $row['pay'];?></span>
				<p class="colororange">
				<?php if($row['owner_id']==$_SESSION['user']['id'])
				{
					echo 'Status: Transferring to bank account';
				}else
				{
					echo 'Staus: Debited From bank account';
				} ?>
				</p>
			</div>
		</div> 
		<?php } }
		else
		{
			echo 'No New Transactions';
		}
		?>
		<div class="wdthpercent100 pT10">
			<a href="<?php echo $URL_SITE?>front/acounts.php?type=transaction&t=ownerTransaction" class="dashbutton">Go to all Transactions</a>
		</div>
	</div>
</div>

</div>
<!--/Dashboard Right-->
</div>
<!--/Dashboard Content-->


<?php 
include("../include/footer.php");
?>
