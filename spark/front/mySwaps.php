<?php
/******************************************
* @created on march 14,2012
* @Package: Maduhaa
* @Developer: Praveen Singh
* @URL : http://www.maduhaa.com
********************************************/
if(isset($_POST['status']))
{
	$basedir=dirname(__FILE__)."../../";	
	include_once($basedir.'/include/actionHeader.php');

	$user_id=$_SESSION['user']['id'];
	$itemid=$_POST['itemid'];

	if($_POST['status']=='0')
	{
		$status=$_POST['status'];
	}
	else
	{
		$status=$_POST['status'];
	}

	$update=user::updateItemStatus($itemid,$status);

}
elseif(isset($_POST['statusStarItem']))
{
	$basedir=dirname(__FILE__)."../../";	
	include_once($basedir.'/include/actionHeader.php');

	$user_id=$_SESSION['user']['id'];
	$itemid=$_POST['itemid'];

	$update=user::deletFavouriteItem($itemid,$user_id);
}
else
{
	$basedir=dirname(__FILE__)."../../";	
	include_once($basedir.'/include/header.php');

	$user_id=$_SESSION['user']['id'];

}

if(!isset($_SESSION['user']['id']))
{
	header("location:".$URL_SITE."front/login.php");	// session is not set
}
?>
<div id="display_item">
   
   <div class="dashboardinbox fontbld">
	  
	  <!----- ALL LISTING ITEM -------------------------------->
	  <?php
	  if((isset($_GET['type']) && $_GET['type']=='listing') || (isset($_POST['type']) &&  $_POST['type']=='listing'))	// all listing
	  {	
			if(isset($_POST['listing_items']) && $_POST['listing_items']=='all')
			{				
				$query=user::displayItemsAllItem($user_id);
				$list_of_items_object = new PS_Pagination($conn,$query,10,5,"type=listing&listing_items=all"); 
				$list_of_items = $list_of_items_object->paginate();			
				$countAllListItem=mysql_num_rows($list_of_items);
			}
			elseif(isset($_GET['listing_items']) && $_GET['listing_items']=='all')
			{
				$query=user::displayItemsAllItem($user_id);
				$list_of_items_object = new PS_Pagination($conn,$query,10,5,"type=listing&listing_items=all"); 
				$list_of_items = $list_of_items_object->paginate();				
				$countAllListItem=mysql_num_rows($list_of_items);
			}			
			else
			{
				$query=user::displayItemsAllItem($user_id);
				$list_of_items_object = new PS_Pagination($conn,$query,10,5,"type=listing&listing_items=all"); 
				$list_of_items = $list_of_items_object->paginate();				
				$countAllListItem=mysql_num_rows($list_of_items);
			}	
			

			if(isset($_POST['listing_items']) && $_POST['listing_items']=='d')
			{				
				$query=user::displayItemsAllDelItem($user_id);
				$list_of_items_object = new PS_Pagination($conn,$query,10,5,"type=listing&listing_items=d"); 
				$list_of_items = $list_of_items_object->paginate();			
				$countAllDelListItem=mysql_num_rows($list_of_items);
			}
			elseif(isset($_GET['listing_items']) && $_GET['listing_items']=='d')
			{
				$query=user::displayItemsAllDelItem($user_id);
				$list_of_items_object = new PS_Pagination($conn,$query,10,5,"type=listing&listing_items=d"); 
				$list_of_items = $list_of_items_object->paginate();				
				$countAllDelListItem=mysql_num_rows($list_of_items);
			}					
			?>
			<div class="dasbmessagesbdr">
				<form name="" action="?type=listing" method="post">
					<span class="font12">show:</span>
						<select name="listing_items" onchange="this.form.submit();">
							
							<option <?php if(isset($_REQUEST['listing_items']) and $_REQUEST['listing_items']=='all') { echo 'selected="selected"'; }?> value="all">All Listings (							
							<?php
								$query=user::displayItemsAllItem($user_id);
								$res=mysql_query($query);								
								echo $countAllListItem=@mysql_num_rows($res);
							?> 
							
							
							)</option>
							
							<option <?php if(isset($_REQUEST['listing_items']) and $_REQUEST['listing_items']=='d') { echo 'selected="selected"';}?> value="d">Deleted ( 
							<?php							
								$query=user::displayItemsAllDelItem($user_id);
								$res=mysql_query($query);								
								echo $countAllDelListItem=@mysql_num_rows($res);				
							?>  )</option>

					</select>
				</form>
			</div>

			<?php
			if(mysql_num_rows($list_of_items)=='0')
			{
				echo '<br/><em>NO</em> Listing So Far';
			}
			else
			{
				while($list_data=mysql_fetch_assoc($list_of_items))
				{
					//print_r($list_data);
					$item_id=$list_data['id'];
					$image=itemClass::select_featured_image($list_data['id']);
					$item_reserve_res=itemClass::to_get_details_of_reserved_item($list_data['id']);		
					$num_of_rents_so_far=mysql_num_rows($item_reserve_res);
					$res=itemClass::to_get_details_of_upcoming_reserved_item($list_data['id']);
					$num_of_upcoming=mysql_num_rows($res);
					?>		
						<div class="dasbmessagesbdr">
							<div class="swappicdiv"><a href="<?php echo $URL_SITE?>/front/viewItem.php?item_id=<?php echo $list_data['id'];?>"><img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/itemimages/<?php echo $list_data['id'].'/'.$image['filename'];?>&height=67px&width=47px"></a></div>

							<div class="datediv"><?php echo 'Posted: '.date('d/m/Y',strtotime($list_data['created_on']));?>
							</div>
							<div class="inboxcnt">
								<a href="<?php echo $URL_SITE?>/front/viewItem.php?item_id=<?php echo $list_data['id'];?>"><p class="nametitle"><?=ucwords($list_data['item_name']);?></p></a>
								<p>"<?=ucfirst($list_data['item_subtitle'].'&nbsp;'.$list_data['item_description']);?>"</p>
							</div>
							<div class="swaplinksbut">
								<ul>
									<li><p class="digit"><?php echo $num_of_rents_so_far;?></p>Rentals so far</li>
									<li><p class="digit"><?php echo $num_of_upcoming;?></p>Upcoming Rentals</li>
									<?php
									if((isset($_GET['listing_items']) && $_GET['listing_items']=='all') || (isset($_POST['listing_items']) && $_POST['listing_items']=='all'))
									{?>
										<li>
											<a href="<?php echo $URL_SITE;?>/front/editItem.php?item_id=<?php echo $list_data['id']?>"><p class="pT10 font11">Edit</p></a>
										</li>
								    <? } ?>

									<?php
									if($list_data['delete_status']=='0')
									{?>
										<li><a href="javascript:;" onclick="javascript: FundeleteItem(1,<?php echo $item_id;?>,'all');"><p class="pT10 font11">Delete</p></a></li>
									<? 
									}
									else
									{?>
										<li><a href="javascript:;" onclick="javascript: FundeleteItem(0,<?php echo $item_id;?>,'d');"><p class="pT10 font11">Repost</p></a></li>

									<? } ?>
									<script language="javascript">
									function FundeleteItem(status,itemid,selected)
									{
										var dataAjax = "status="+status+"&itemid="+itemid;

										if(status=='1')
										{

											if(confirm("This Action will unlist your items"))
											{
												$.ajax({
												type: "POST",
												data: dataAjax,
												url: URL_SITE+"/front/mySwaps.php?type=listing&listing_items="+selected,	
																							
												success: function(msg)
												{	
												$("#display_item").html(msg);
												}
												});	
											}
											else
											{
												return false;
											}
										}
										if(status=='0')
										{
											$.ajax({
												type: "POST",
												data: dataAjax,
												url: URL_SITE+"/front/mySwaps.php?type=listing&listing_items="+selected,	
																							
												success: function(msg)
												{	
												$("#display_item").html(msg);
												confirm("Your items is reposted succussfully");
												}
											});

										}
									}
									</script>		
								</ul>
							</div>
						</div>
				<?php
				}// while ends............					
				?>
				
				<div class="wdthpercent100 pT10">
					<a href="<?php echo $URL_SITE?>/front/addItem.php" class="dashbutton">Post a new listing</a>
				</div>

				<!--/Pagination----------->                      
				<div class="pT20 reviewlisting">
					<ul><li><?php   echo $list_of_items_object->renderPrev();?>&nbsp;&nbsp;<?php  echo $list_of_items_object->renderNext();?></li></ul>
				</div>
				<!--/Pagination----------->
		<?php
			}
		}
		?>
		<!-- /ALL LISTING ITEM -------------------------------->



		<!-- ALL STARLISTING ITEM ----------------------------->
		<?php
	    if((isset($_GET['type']) && $_GET['type']=='starlisting') || (isset($_POST['type']) &&  $_POST['type']=='starlisting'))	// all listing
	    {		
			if(isset($_GET['listing_items']) && $_GET['listing_items']=='all')
			{				
				$ItemArray=user::getStarItemsId($user_id);
				
				if(!empty($ItemArray))
				{
					foreach($ItemArray as $itemids)
					{
						$infoid[]=$itemids;
					}				
				
					$query=user::displaystarItemsAllItem($infoid);
					$list_of_items_object = new PS_Pagination($conn,$query,10,5,"type=starlisting&listing_items=all"); 
					$list_of_items = $list_of_items_object->paginate();				
					$countAllListItem=mysql_num_rows($list_of_items);
				}
			}						
			
			if(empty($ItemArray))
			{
				echo '<br/><em>NO</em> Listing So Far';
			}
			else
			{?>
				<h3 class="dasbmessagesbdr">Starred Items</h3>
				<?php
				while($list_data=mysql_fetch_assoc($list_of_items))
				{
					//print_r($list_data);
					$item_id=$list_data['id'];
					$image=itemClass::select_featured_image($list_data['id']);
					$item_reserve_res=itemClass::to_get_details_of_reserved_item($list_data['id']);		
					$num_of_rents_so_far=mysql_num_rows($item_reserve_res);
					$res=itemClass::to_get_details_of_upcoming_reserved_item($list_data['id']);
					$num_of_upcoming=mysql_num_rows($res);
					?>		
						<div class="dasbmessagesbdr">
							<div class="swappicdiv"><a href="<?php echo $URL_SITE?>/front/viewItem.php?item_id=<?php echo $list_data['id'];?>"><img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/itemimages/<?php echo $list_data['id'].'/'.$image['filename'];?>&height=67px&width=47px"></a></div>

							<div class="datediv"><?php echo 'Posted: '.date('d/m/Y',strtotime($list_data['created_on']));?>
							</div>
							<div class="inboxcnt">
								<a href="<?php echo $URL_SITE?>/front/viewItem.php?item_id=<?php echo $list_data['id'];?>"><p class="nametitle"><?=ucwords($list_data['item_name']);?></p></a>
								<p>"<?=ucfirst($list_data['item_subtitle'].'&nbsp;'.$list_data['item_description']);?>"</p>
							</div>
							<div class="swaplinksbut">
								<ul>
									<li><p class="digit"><?php echo $num_of_rents_so_far;?></p>Rentals so far</li>
									<li><p class="digit"><?php echo $num_of_upcoming;?></p>Upcoming Rentals</li>
									<!-- <li><a href="<?php echo $URL_SITE;?>/front/editItem.php?item_id=<?php echo $list_data['id']?>"><p class="pT10">Edit</p></a></li>--->
									<li>
										<a href="javascript:;" onclick="javascript: FundeleteItem(1,<?php echo $item_id;?>,'all');"><p class="pT10 font11">unfavorite</p></a>
									</li>
									
									<script language="javascript">
									function FundeleteItem(status,itemid,selected)
									{
										var dataAjax = "statusStarItem="+status+"&itemid="+itemid;

										if(confirm("This Action cannot be undone. Are you sure you want to Perform this action!"))
										{
											$.ajax({
											type: "POST",
											data: dataAjax,
											url: URL_SITE+"/front/mySwaps.php?type=starlisting&listing_items="+selected,	
																						
											success: function(msg)
											{	
											$("#display_item").html(msg);
											}
											});	
										}
										else
										{
											return false;
										}
									}
									</script>	
								</ul>
							</div>
						</div>
				<?php
				}// while ends............					
				?>
				<div class="wdthpercent100 pT10">
					<a href="<?php echo $URL_SITE?>/front/addItem.php" class="dashbutton">Post a new listing</a>
				</div>

				<!--/Pagination----------->                      
				<div class="pT20 reviewlisting">
					<ul><li><?php   echo $list_of_items_object->renderPrev();?>&nbsp;&nbsp;<?php   echo $list_of_items_object->renderNext();?></li></ul>
				</div>
				<!--/Pagination----------->
		<?php
			}
		}
		?>
		<!-- ALL STARLISTING ITEM ----------------------------->

		<?php
		if($_GET['type']=='reservation')
		{
			include($DOC_ROOT.'/front/myReservation.php');
		}
		if($_GET['type']=='policy')		// ploicies
		{
			echo '<div class="dashpolicy">
			<h4>SparkSwap Policies</h4>
			<ol class="droppolicy">
				<li>1. If a renter has to wait for a pick up or delivery, a refund will be issued.</li>
				<li>2. If the item is different, in any way, than tha described in the item page, a refund will be issued 
				and the item will be taken down upon further review.</li>
				<li>3. If the renter reports that a different payment method is being encouraged, the owner will be 
				suspended as the matter is investigated</li>
				<li>4. Thank you for your cooperation and participation in the SparkSwap community</li>
			</ol>
			</div>';    
		}

		if($_GET['type']=='requirements')		// requirement settings
		{
			include($DOC_ROOT.'/front/requirements.php');
		}


		if($_GET['type']=='myRents' or $_GET['type']=='previous' or ($_GET['type']=='upcoming')	)	// My Rents or previous
		{
			if($_GET['type']=='myRents')
			{
				$list_of_items=itemClass::to_get_all_rent_items_for_user($user_id);// my rent
			}
			if($_GET['type']=='previous')		// my previous rent
			{
				$list_of_items=itemClass::to_get_detail_previous_items_for_user($user_id);
			}
			if($_GET['type']=='upcoming')					// my upcoming rent
			{
				$list_of_items=itemClass::to_get_detail_upcoming_items_for_user($user_id);
			}
			
			if(mysql_num_rows($list_of_items)>0)
			{?>

				<div class="dashrentalsdiv">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<th width="15%" height="27" align="left" class="bdrbtmgrey">Status</th>
				<th width="50%" align="left" class="bdrbtmgrey">Item</th>
				<th width="20%" align="left" class="bdrbtmgrey">Owner</th>
				<th width="20%" align="left" class="bdrbtmgrey">Dates</th>
				<th class="bdrbtmgrey">Options</th>
				</tr>
				<?php
					while($list_data=mysql_fetch_assoc($list_of_items))
					{
					//print_r($list_data);
					$details=user::mainDetailOfItem($list_data['item_id']);
					$res_image=itemClass::select_featured_image($list_data['item_id']);
					//print_r($res_image);
					?>
					
				<tr>
				<td class="bdrbtmgrey"><a href="javascript:;"><?php if($list_data['item_status']==1) { $status='<img alt="" src="'.$URL_SITE.'/images/declinebtn.gif">'; }
					if($list_data['item_status']==3) { $status='<img alt="" src="'.$URL_SITE.'/images/acceptedbtn.gif">'; }
					 if($list_data['item_status']==0) { $status='<img alt="" src="'.$URL_SITE.'/images/notrespond.gif">'; } ?></a></td>
				<td class="bdrbtmgrey">
					 <div class="wdthpercent25 left"><img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/itemimages/<?php echo $list_data['item_id'].'/'.$res_image['filename'];?>&height=46px&width=45px"></div>
					 <div class="wdthpercent70 left">
					<p class="font14 colororange"><?php echo $details['item_name']?></p>
					<p>"<?php echo $details['item_subtitle'].'"'.' '.$details['item_description'];?></p>
					 </div>
				</td>
				<td class="font14 colororange bdrbtmgrey"><?php echo $details['user_fname'];?></td>
				<td class="font10 bdrbtmgrey">
				<?php	
						$issue=$list_data['issue_date'];
						$end=$list_data['end_date'];
						$issue=date('M-d-Y',strtotime($issue));
						$end=date('M-d-Y',strtotime($end));
						$issue=explode('-',$issue);
						$end=explode('-',$end);
						if($issue[0]==$end[0])		// if rent up to same month
						{
							echo $issue[0].' '.$issue[1].'-'.$end[1].' ,'.$issue['2'];
						}
						else					// if rent not up to same month
						{
							echo $issue[0].' '.$issue[1].'-'.$end[0].$end[1].' ,'.$issue['2'];
						}?>
				</td>
				<td class="bdrbtmgrey"><a href="#">
				<?php if($_GET['type']!='previous') {?>
					<img src="<?php echo $URL_SITE;?>/images/msgownerbtn.gif" alt="" />
					<?php } 
					else
						{
						echo '<img src="'.$URL_SITE.'images/msghistorybtn.gif" alt="">';
						}
						
					?>
				</a></td>
				</tr>

				<?php
					}
				?>

				</table>
			</div>

			<?php
			}
			else
			{
				echo 'No Rents So Far';
			}
		}
		?>	

      </div>
</div>
<!-- main div ends -->



<?php
include($basedir.'/include/footer.php');
?>