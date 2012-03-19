<?php
if($_REQUEST['transaction']=='1')
{	
	include_once('../include/actionHeader.php');

	$owner_id=$_REQUEST['userid'];
	$query=payment::payment_by_owner($owner_id);
	$res=mysql_query($query);

	$infoid=array();
	while($row=mysql_fetch_assoc($res))
	{
		$infoid[]=$row;
	}
	
	if(isset($_GET['page']))
	{
		$page=$_GET['page'];
	}
	else
	{
		$_GET['page']=1;
	}

	if(isset($_GET['page']))
	{
		$start=($_GET['page']-1)*5;
		$output_info = array_slice($infoid, $start,5);
	}
	else
	{
		$output_info = array_slice($infoid, 0, 5);
	}

	$nm_array = count($infoid);
	$pages=ceil($nm_array/1);
	//echo "<pre>";print_r($output_info);echo "</pre>";
	
	
	if($nm_array>0)
	{?>

			<div class="dashprofilereviewsnav">
				<ul>
					<li><a id="reviewaboutyou" <?php if($_REQUEST['transaction']=='1') { ?> class="active" <? } ?> href="javascript:;" onclick="javascript: TransactionHistry(1,<?=$_SESSION['user']['id']?>,<?=$_GET['page']?>);">Paid By You</a></li>
					<li><a id="reviewbyyou" href="javascript:;" onclick="javascript: TransactionHistry(0,<?=$_SESSION['user']['id']?>,<?=$_GET['page']?>);">Received By You</a></li>
				</ul>
			</div>

			<div class="dashboardinbox">
				<div class="dasbmessagesbdr fontbld font18">	
						<div class="datediv">S.No</div>
						<div class="inboxcnt">Item</div>
						<div class="datediv">Renter</div>
						<div class="datediv">Amount</div>
						<div class="datediv">Date</div>	
				</div>
				<?php
				$i=1;			
				foreach($output_info as $key=>$owner)
				{					
					$ownerDetail=user::user_profile($owner['owner_id']);// renter profile
					$rentitemdetail=user::mainDetailOfItem($owner['item_id']);
				?>
					<div class="dasbmessagesbdr">	
							<div class="datediv"><?=$i?></div>
							<div class="inboxcnt"><p class="nametitle"><?=ucwords($rentitemdetail['item_name']);?></p></div>
							<div class="datediv"><p class="nametitle"><?=ucwords($owner['payfirstname']);?></p></div>
							<div class="datediv">$<?=$owner['pay']?></div>	
							<div class="datediv">
							<?php echo date('d M,Y',strtotime($owner['payment_date']));?>
							</div>
					</div>
				<?				
				$i++;
				}
				?>
				<!-- </div> --> 
				<div class="right pagination pT10 pB10">
				<?php
				if($nm_array >5) 
				{ ?>
					<ul>
						<?php
						if(isset($_GET['page']) && $_GET['page']!= 1) 
						{ ?>
							<li class="arrowL">
								<a class="txtred" href="javascript:;" onclick="javascript: return TransactionHistry('1','<?=$_REQUEST['userid']?>','<?=$_GET['page']-1?>');">Previous</a>
							</li>
						<?
						}
						if(!isset($_GET['page']) || $_GET['page']!= $pages) 
						{ ?>
							<li class="arrowR">
								<a class="txtred" href="javascript:;" onclick="javascript: return TransactionHistry('1','<?=$_REQUEST['userid']?>','<?=$_GET['page']+1?>');">Next</a>
							</li>
						<?
						}
						?>
					</ul>
				<?
				}			
				?>				
				</div>
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
if($_REQUEST['transaction']=='0')
{	
	include_once('../include/actionHeader.php');

	$owner_id=$_REQUEST['userid'];
	$query=payment::payment_by_user($owner_id);
	$res=mysql_query($query);

	$infoid=array();
	while($row=mysql_fetch_assoc($res))
	{
		$infoid[]=$row;
	}
	
	if(isset($_GET['page']))
	{
		$page=$_GET['page'];
	}
	else
	{
		$_GET['page']=1;
	}

	if(isset($_GET['page']))
	{
		$start=($_GET['page']-1)*5;
		$output_info = array_slice($infoid, $start,5);
	}
	else
	{
		$output_info = array_slice($infoid, 0, 5);
	}

	$nm_array = count($infoid);
	$pages=ceil($nm_array/1);
	//echo "<pre>";print_r($output_info);echo "</pre>";
	
	if($nm_array>0)
	{?>

			<div class="dashprofilereviewsnav">
				<ul>
					<li><a id="reviewaboutyou"  href="javascript:;" onclick="javascript: TransactionHistry(1,<?=$_SESSION['user']['id']?>,<?=$_GET['page']?>);">Paid By You</a></li>
					<li><a <?php if($_REQUEST['transaction']=='0') { ?> class="active" <? } ?> id="reviewbyyou" href="javascript:;" onclick="javascript: TransactionHistry(0,<?=$_SESSION['user']['id']?>,<?=$_GET['page']?>);">Received By You</a></li>
				</ul>
			</div>

			<div class="dashboardinbox">
				<div class="dasbmessagesbdr fontbld font18">	
						<div class="datediv">S.No</div>
						<div class="inboxcnt">Item</div>
						<div class="datediv">Renter</div>
						<div class="datediv">Amount</div>
						<div class="datediv">Date</div>	
				</div>
				<?php
				$i=1;			
				foreach($output_info as $key=>$owner)
				{					
					$ownerDetail=user::user_profile($owner['owner_id']);// renter profile
					$rentitemdetail=user::mainDetailOfItem($owner['item_id']);
				?>
					<div class="dasbmessagesbdr">	
							<div class="datediv"><?=$i?></div>
							<div class="inboxcnt"><p class="nametitle"><?=ucwords($rentitemdetail['item_name']);?></p></div>
							<div class="datediv"><p class="nametitle"><?=ucwords($owner['payfirstname']);?></p></div>
							<div class="datediv">$<?=$owner['pay']?></div>	
							<div class="datediv">
							<?php echo date('d M,Y',strtotime($owner['payment_date']));?>
							</div>
					</div>
				<?
				$i++;
				}				
				?>
				<!-- </div> --> 
				<div class="right pagination pT10 pB10">
				<?php
				if($nm_array >5) 
				{ ?>
					<ul>
						<?php
						if(isset($_GET['page']) && $_GET['page']!= 1) 
						{ ?>
							<li class="arrowL">
								<a class="txtred" href="javascript:;" onclick="javascript: return TransactionHistry('0','<?=$_REQUEST['userid']?>','<?=$_GET['page']-1?>');">Previous</a>
							</li>
						<?
						}
						if(!isset($_GET['page']) || $_GET['page']!= $pages) 
						{ ?>
							<li class="arrowR">
								<a class="txtred" href="javascript:;" onclick="javascript: return TransactionHistry('0','<?=$_REQUEST['userid']?>','<?=$_GET['page']+1?>');">Next</a>
							</li>
						<?
						}
						?>
					</ul>
				<?
				}			
				?>				
				</div>
		</div>
	<?
	}
	else
	{
		echo '<h3>No transaction</h3>';
	}
}
?>