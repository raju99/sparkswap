<?php
$basedir=dirname(__FILE__)."../../";	
include($basedir.'/include/actionHeader.php');

if($_GET['type']=='stared')
{
	$msg_id=$_GET['msg'];
	
	if($_GET['action']=='not_a_stared')
	{
			$affected=inbox::update_msg_status('starred',$msg_id,1);
	}
	
	if($_GET['action']=='all_ready_stared')
	{
			$affected=inbox::update_msg_status('starred',$msg_id,0);
	}

	$res_inbox=inbox::select_msg_by_id($msg_id);
	
	while($mesg=mysql_fetch_assoc($res_inbox))
	{
		$on_which_reply_did=inbox::select_msg_by_id($mesg['replied_on_id']);
		$checkacepteddeniedPost_res=user::checkRentStatus($mesg['reservation_id']);
		$checkRentStatusOfUSer=mysql_fetch_assoc($checkacepteddeniedPost_res);

		$frnd_user=user::user_profile($mesg['sender_id']);		
		//print_r($frnd_user);
		?>

		<div class="picdiv">
			<?php
			if(!empty($frnd_user['user_picture']))
			{
			?>	
			<img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/profile/<?php echo $frnd_user['user_picture'];?>&width=46px&heigth=45px">
			<?php

			}					
			?>
		</div>

		<div class="datediv">
			<?php echo $frnd_user['user_fname'].'<br/>'. date('m/d/Y',strtotime($mesg['date']));?>
		</div>

		<div class="inboxcnt">
			<p class="colororange"><?php echo '<a class="colororange" href="'.$URL_SITE.'/front/inbox.php?msg_id='.$mesg['msg_id'].'" class="">'.substr($mesg['content'],0,150).'....</a><br/></p>';
			if(!empty($on_which_reply_did['content']))
			{
				echo '<p>Re'.substr($on_which_reply_did['content'],0,150).'...</p>';
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
						{?>
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
					<!-- <li><a href="#"><p class="pT10">Delete</p></a></li> -->
				</ul>
		</div>	
	<?php
	}//while ends here
}
?>