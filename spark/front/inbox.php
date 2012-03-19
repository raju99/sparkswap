<?php
$basedir=dirname(__FILE__)."../../";	
include($basedir.'/include/header.php');
if(!isset($_SESSION['user']['id']))
{
	header("location:".$URL_SITE."front/login.php");
}

if(isset($_POST['listing_inbox']))
{
	$filter=$_POST['listing_inbox'];
	if($filter=='al')
	{	
		$filter_query=' ';
		$query=inbox::select_msg_according_filter($user_id,$filter_query);		
		$res_inbox_object = new PS_Pagination($conn,$query,10,5); 
		$res_inbox = $res_inbox_object->paginate();// if All messages seleted
	}
	if($filter=='s')		// if Starred
	{	
		$filter_query='and starred=1';
		$query=inbox::select_msg_according_filter($user_id,$filter_query);		
		$res_inbox_object = new PS_Pagination($conn,$query,10,5); 
		$res_inbox = $res_inbox_object->paginate();		
	}
	if($filter=='ur')			// if Unread
	{	
		$filter_query='and read_status=0';
		$query=inbox::select_msg_according_filter($user_id,$filter_query);		
		$res_inbox_object = new PS_Pagination($conn,$query,10,5); 
		$res_inbox = $res_inbox_object->paginate();		 
	}
	if($filter=='nr')		// if Never Respond
	{	
		$filter_query='and replied_on_id=0';
		$query=inbox::select_msg_according_filter($user_id,$filter_query);		
		$res_inbox_object = new PS_Pagination($conn,$query,10,5); 
		$res_inbox = $res_inbox_object->paginate();
	}
	if($filter=='d')		// if delete
	{	
		$filter_query='and trash_status=1';
		$query=inbox::select_msg_according_filter($user_id,$filter_query);		
		$res_inbox_object = new PS_Pagination($conn,$query,10,5); 
		$res_inbox = $res_inbox_object->paginate();
	}
}
else
{
	$filter_query=' ';
	$query=inbox::select_msg_according_filter($user_id,$filter_query);		
	$res_inbox_object = new PS_Pagination($conn,$query,10,5); 
	$res_inbox = $res_inbox_object->paginate();		// if All messages seleted
}

$count_of_msgs=array('al'=>0,'nr'=>0,'s'=>0,'ur'=>0,'d'=>0);
$count_of_msg=inbox::select_all_messages($user_id);
while($msg_data=mysql_fetch_assoc($count_of_msg))
{
	
	if($msg_data['read_status']==0)
	{
		$count_of_msgs['ur']=++$count_of_msgs['ur'];	// never read
	}
	if($msg_data['replied_on_id']==0)
	{
		$count_of_msgs['nr']=++$count_of_msgs['nr'];	//never respond
	}
	if($msg_data['starred']==1)
	{
		$count_of_msgs['s']=++$count_of_msgs['s'];		// number of stared
	}
	if($msg_data['trash_status']==1)
	{
		$count_of_msgs['d']=++$count_of_msgs['d'];		// deleted
	}	
	$count_of_msgs['al']=++$count_of_msgs['al'];		// all
}
//print_r($count_of_msgs);
?>
<!--Dashboard conntent-->
<div class="dashboardinbox">
	<div class="dasbmessagesbdr">
		<span class="font12">Show:</span> &nbsp;
		<form id="inboxForm" action="" method="post">
			<select onchange="this.form.submit();" name="listing_inbox" id="listing_inbox">
			<option value="">Select to filter</option>
			<option value="al">All Messages(<?php echo $count_of_msgs['al'];?>)</option>
			<option value="s">Starred(<?php echo $count_of_msgs['s'];?>)</option>
			<option value="ur">Unread(<?php echo $count_of_msgs['ur'];?>)</option>
			<option value="nr">Never Respond(<?php echo $count_of_msgs['nr'];?>)</option>
			<option value="d">Deleted(<?php echo $count_of_msgs['d'];?>)</option>
			</select>
		</form>
	</div>

<?php 
if(mysql_num_rows($res_inbox)=='0')
{
	echo '<h3 class="pT10">No New Message</h3>';
}
else
{
	while($mesg=mysql_fetch_assoc($res_inbox))
	{		
		//echo "<pre>";print_r($mesg);echo "</pre>";
		$on_which_reply_did_res=inbox::select_msg_by_id($mesg['replied_on_id']);
		$on_which_reply_did=mysql_fetch_assoc($on_which_reply_did_res);

		$frnd_user=user::user_profile($mesg['sender_id']);
		$checkacepteddeniedPost_res=user::checkRentStatus($mesg['reservation_id']);
		$checkRentStatusOfUSer=mysql_fetch_assoc($checkacepteddeniedPost_res);
		//echo "<pre>";print_r($checkRentStatusOfUSer);echo "</pre>";
		?>
		<div class="dasbmessagesbdr" id='ajaxReplace_<?php echo $mesg['msg_id']?>'>
				<div class="picdiv">
				    <?php
					if(!empty($frnd_user['user_picture']))
					{
					?>	
						<img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/profile/<?php echo $frnd_user['user_picture'];?>&width=46px&heigth=45px">					
					<?							
					}					
				    ?>
				</div>
				<div class="datediv">
					<?php echo $frnd_user['user_fname'].'<br/>'. date('m/d/Y',strtotime($mesg['date']));?>
				</div>
				<div class="inboxcnt">						
					<?php
					if($checkRentStatusOfUSer['item_status']=='1')//proposed date
					{?>
						<p class="colororange">
							<a class="colororange" href="postRental.php?action=posponddate&msg_id=<?php echo $mesg['msg_id'];?>&item_id=<?php echo $mesg['item_id'];?>&owner_id=<?php echo $mesg['sender_id'];?>&user_id=<?php echo $mesg['receiver_id'];?>&id=<?php echo $mesg['reservation_id'];?>"><?php echo $mesg['subject'];?><br><?php echo $mesg['content'];?>
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
					elseif($checkRentStatusOfUSer['item_status']=='0')//rent Request free commodity
					{?>
						<p class="colororange">
							<a class="colororange" href="userRentListing.php?msg_id=<?php echo $mesg['msg_id'];?>&item_id=<?php echo $mesg['item_id'];?>&id=<?php echo $mesg['reservation_id'];?>"><?php echo $mesg['subject'];?><br><?php echo $mesg['content'];?>
							</a>
						</p>
						
					<?
					}

					?>
					<br/>
					
					<?php
					if(!empty($on_which_reply_did['content']))
					{
						echo '<p>Re'.substr($on_which_reply_did['content'],0,80).'...</p>';
					}?>
				</div>
				<div class="linksbut">
					<ul>
						<?php
						if($checkRentStatusOfUSer['item_status']=='3')//accept date
						{?>
							<li>
								<a href="javascript:;"><img src="<?php echo $URL_SITE;?>images/acceptedbtn.gif" alt="" /></a>
							</li>
						<?
						}
						if($checkRentStatusOfUSer['item_status']=='2')//deny Request
						{?>
							<li>
								<a href="javascript:;"><img src="<?php echo $URL_SITE;?>images/declinebtn.gif" alt="" /></a>
							</li>
						
						
						<?
						}
						?>


						<li>
							<?php
							if($mesg['starred']==0)
							{ ?>
								<a href="javascript:;" onclick="make_me_stared('not_a_stared','<?php echo $mesg['msg_id']?>')">
								<img src="<?php echo $URL_SITE?>images/whitestar.gif"></a>
							<?php
							}
							else
							{
							?>
								<a href="javascript:;" onclick="make_me_stared('all_ready_stared','<?php echo $mesg['msg_id']?>')"><img src="<?php echo $URL_SITE?>images/star.png"></a>
							<?php
							}
							?>	
						</li>
						<!-- <li><a href="javascript:;"><p class="pT10">Delete</p></a></li> -->
					</ul>
				  </div>
		       </div>
			<?php
			}//while ends here
		?>

			<!--/Pagination----------->                      
			<div class="pT20 reviewlisting">
				<ul><li><?php   echo $res_inbox_object->renderFullNav();?></li></ul>
			</div>
			<!--/Pagination----------->	
	 </div>
	 <!--/Dashboard conntent-->
<?
}
?>

<?php
include("../include/footer.php");
?>