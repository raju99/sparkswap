<?php 
ob_start();
session_start();
ini_set("display_errors","1");
ERROR_REPORTING(E_ALL);
include('../include/conn.php');

include($DOC_ROOT.'/classes/userClass.php');

include($DOC_ROOT.'/classes/adminClass.php');
include($DOC_ROOT.'/classes/paginationClass.php');
if(isset($_GET['type']))
{

	
$type=$_GET['type'];
switch($type)
	{
		case "reviews":
			 $_SESSION['SORTING']=" order by newtable.count desc";
			
		break;
		case "Price":
		 $_SESSION['SORTING']=" order by newtable.item_price asc";
					break;
		case 'distance':
			$_SESSION['SORTING']=" order by newtable.distance";
			
		break;
	}
}



		if(isset($_SESSION['search']))
		{
		  $sql=user::searchAll($_SESSION['SORTING']);

		}
		else
		{
		  $sql=admin::displayItems($_SESSION['SORTING']);

		}	
		$objPagination=new Ps_Pagination($conn, $sql, 10, 5);
		$exsql =$objPagination->paginate();

		$total_item=@mysql_num_rows(@$exsql);

 if($total_item>0)
				{
					?>
				<!--Map-->
				<div class="map">  map  </div>
				
				<!--left_1-->
				<?php
				if(!empty($_SESSION['search']['pickup_date']) and !empty($_SESSION['search']['dropip_date']))
					{
						$pick=$_SESSION['search']['pickup_date'];
						$drop=$_SESSION['search']['dropip_date'];
					}
			while($all_item=mysql_fetch_assoc($exsql))
				{
					
					$mainimage=user::selectImage($all_item['id']);
					if(isset($pick) and isset($drop))
					{
						
						$sql="select * from user_reservations where item_id='".$all_item['id']."'";
						$res=mysql_query($sql);
						if(mysql_num_rows($res)>0)
						{
							while($item_resrve_data=mysql_fetch_assoc($res))
							{
								if(($item_resrve_data['issue_date']>$pick and $item_resrve_data['end_date']<$drop) or ($item_resrve_data['issue_date']<$drop and $item_resrve_data['issue_date']>$pick))
								{
									continue;
									$continue=1;
								}
							}

							if(isset($continue) and $continue==1)
							{
								continue;
							}
						}
					}
					?>
				<div class="srcpfl">
				 <div class="cycle">		  
				  <!-- <img src="images/cycle_2.png" /> -->

				 <a href="viewItem?item_id=<?php echo $all_item['id'] ?>"><img src="<?php echo $URL_SITE ;?>classes/show_image.php?filename=../images/itemimages/<?php echo $all_item['id'] ;?>/<?php echo $mainimage['filename'] ; ?>&height=100&width=100">
				 </a>
				  </div>
				  
				    <div class="srcpflpic">
					   <img class="left mR5" src="<?php echo $URL_SITE ;?>classes/show_image.php?filename=../profile/<?php echo $all_item['id'] ;?>/<?php echo $mainimage['filename'] ; ?>&height=33&width=36" />
					 </div>
					<div class="srcaddresh">
					 <h3> <a href="viewItem.php?item_id=<?php echo $all_item['id'] ?>"><?php echo $all_item['item_name']; ?></a> </h3> 
					 <h4>  <?php echo $all_item['item_subtitle']; ?>  </h4>
					   <div class="bluebtn"><?php  echo $all_item['count']; ?>
					   <h5>Reviews</h5> 
					   </div>
					    <div class="orangebtn"> S 
						 <h5> Super Renter  </h5>
						</div>
				  </div>
				  <div class="price">
				  <h3>$<?php echo $all_item['item_Price']; ?></h3>
				  <h5> Per day </h5>
				</div>
			 </div>
			 <?php
				}
					
					}
					?>
				
				<!--left_2-->
				
				  <!--left_3-->
				</div>



		