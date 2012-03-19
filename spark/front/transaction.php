<!-- TRANSACTION MADE BY OWNER AND RENTER -->
<div id="display_all_transaction" class="dashwhitebg fontbld">
	
	<div class="pT5 pB15"><h4>Transaction History</h4></div>

	<div class="dashprofilereviewsnav">
			<ul>
				<li><a id="reviewaboutyou" <?php if($_REQUEST['t']=='renterTransaction') { ?> class="active" <? } ?> href="?type=transaction&t=renterTransaction">Paid By You</a></li>
				<li><a <?php if($_REQUEST['t']=='ownerTransaction') { ?> class="active" <? } ?> id="reviewbyyou" href="?type=transaction&t=ownerTransaction">Received By You</a></li>
			</ul>
	</div>	

	<?php
	if($_GET['t']=='renterTransaction')
	{	
		$owner_id=$_SESSION['user']['id'];
		$query=payment::payment_by_owner($owner_id);
		$res_trans_object = new PS_Pagination($conn,$query,10,5,"type=transaction&t=renterTransaction"); 
		$res_trans = $res_trans_object->paginate();// if All messages seleted
				
		if(mysql_num_rows($res_trans)>0)
		{?>

			<div class="dashboardinbox">

				<div class="dasbmessagesbdr fontbld font18">	
						<div class="datediv">S.No</div>
						<div class="inboxcnt">Item</div>
						<div class="datediv">Owner</div>
						<div class="datediv pL20">Amount</div>
						<div class="datediv">Date</div>	
				</div>
				<?php
				$i=1;
				while($owner=mysql_fetch_array($res_trans))
				{
					//echo "<pre>";print_r($owner);echo "</pre>";
					$ownerDetail=user::user_profile($owner['owner_id']);// owner profile
					$rentitemdetail=user::mainDetailOfItem($owner['item_id']);
				?>
					<div class="dasbmessagesbdr">	
							<div class="datediv"><?=$i?></div>
							<div class="inboxcnt"><p class="nametitle"><?=ucwords($rentitemdetail['item_name']);?></p></div>
							<div class="datediv"><p class="nametitle"><?=ucwords($ownerDetail['user_fname']);?></p></div>
							<div class="datediv pL20">$<?=$owner['pay']?></div>	
							<div class="datediv">
							<?php echo date('d M,Y',strtotime($owner['payment_date']));?>
							</div>
					</div>
				<?
				$i++;
				}
				?>

				<!--/Pagination----------->                      
				<div class="pT20 reviewlisting">
				<ul><li><?php   echo $res_trans_object->renderFullNav();?></li></ul>
				</div>
				<!--/Pagination----------->
			</div>
		<?
		}
		else
		{
			echo '<h3>No transaction</h3>';
		}
	}
	?>

<?php
	if($_GET['t']=='ownerTransaction')
	{	
		$owner_id=$_SESSION['user']['id'];

		$query=payment::payment_by_user($owner_id);
		$res_trans_object = new PS_Pagination($conn,$query,10,5,"type=transaction&t=ownerTransaction"); 
		$res_trans = $res_trans_object->paginate();// if All messages seleted
				
		if(mysql_num_rows($res_trans)>0)
		{?>

			<div class="dashboardinbox">

				<div class="dasbmessagesbdr fontbld font18">	
						<div class="datediv">S.No</div>
						<div class="inboxcnt">Item</div>
						<div class="datediv">Renter</div>
						<div class="datediv pL20">Amount</div>
						<div class="datediv">Date</div>	
				</div>
				<?php
				$i=1;
				while($renter=mysql_fetch_array($res_trans))
				{
					//echo "<pre>";print_r($owner);echo "</pre>";
					$payerDetail=user::user_profile($renter['payer_id']);// renter profile
					$rentitemdetail=user::mainDetailOfItem($renter['item_id']);
				?>
					<div class="dasbmessagesbdr">	
							<div class="datediv"><?=$i?></div>
							<div class="inboxcnt"><p class="nametitle"><?=ucwords($rentitemdetail['item_name']);?></p></div>
							<div class="datediv"><p class="nametitle"><?=ucwords($payerDetail['user_fname']);?></p></div>
							<div class="datediv pL20">$<?=$renter['pay']?></div>	
							<div class="datediv">
							<?php echo date('d M,Y',strtotime($renter['payment_date']));?>
							</div>
					</div>
				<?
				$i++;
				}
				?>

				<!--/Pagination----------->                      
				<div class="pT20 reviewlisting">
				<ul><li><?php   echo $res_trans_object->renderFullNav();?></li></ul>
				</div>
				<!--/Pagination----------->
			</div>
		<?
		}
		else
		{
			echo '<h3>No transaction</h3>';
		}
	}
	?>
</div>
<!-- /TRANSACTIOM MADE BY OWNER AND RENTER -->