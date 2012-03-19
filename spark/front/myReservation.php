<?php
$query=user::displayItems($user_id);
$list_of_items_object = new PS_Pagination($conn,$query,10,5,"type=reservation"); 
$list_of_items_res = $list_of_items_object->paginate();

//$sql=user::displayItems($user_id);
//$all_items=mysql_query($sql);

if(mysql_num_rows($list_of_items_res)=='0')
{
	echo '<em>NO</em> listings so far';
}
else
{
	while($all_user_item=mysql_fetch_assoc($list_of_items_res))
	{
		$res=itemClass::select_featured_image($all_user_item['id']);//feaure image
		//get details for reservation
		$item_res=itemClass::to_get_details_of_reserved_item($all_user_item['id']);
		$item_reserved=itemClass::users_who_rest_item($all_user_item['id']);
		$item_res_num=mysql_num_rows($item_reserved);
		?>
			<div class="dasbmessagesbdr">
					<div class="swappicdiv">
						<img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/itemimages/<?php echo $all_user_item['id'].'/'.$res['filename'];?>&height=60px&width=100px">
					</div>

					<div class="swaprighttxt">
							<div class="swaprighttxtL">
								<p class="nametitle"><?php echo $all_user_item['item_name'];?></p>
								<p>"<?php echo $all_user_item['item_subtitle'].' '.$all_user_item['item_description'];?>"</p>  
							</div>
							<div class="swaprighttxtR">
								<div class="swaplinksbut">
									<ul>
										<li><p class="digit"> <?php echo $item_res_num;?></p>Upcoming Rentals</li>
									</ul>
								</div>
							</div> 		
							<!-- -->
							<?php 
							$deliver='';
							$drop='';	
							while($row=mysql_fetch_assoc($item_reserved))
							{
									$renter_detail=user::user_profile($row['user_id']); // renter detail
									//print_r($renter_detail);
									if($row['end_date']<date('Y-m-d'))
									{
										$deliver='<div class="wdthpercent20 left pR10"><p class="font11 color1">Deliver:</p>
										<p class="font9 color2">'.date('m/d/y',strtotime($row['issue_date'])).'</p></div>';
										$drop='<div class="wdthpercent20 left pR10"><p class="font11 color1">Drop Off:</p>
										<p class="font9 color2">'.date('m/d/y',strtotime($row['end_date'])).'</p></div>';
									}
									if($row['end_date']>date('Y-m-d'))
									{
										$deliver='<div class="wdthpercent20 left pR10"><p class="font11 color1">They will pick up:</p>
										<p class="font9 color2">'.date('m/d/y',strtotime($row['issue_date'])).'</p></div>';
										$drop='<div class="wdthpercent20 left pR10"><p class="font11 color1">They will drop off:</p>
										<p class="font9 color2">'.date('m/d/y',strtotime($row['end_date'])).'</p></div>';
									}
									?>
									<div class="dasbmessagesbdr clear">
										<div class="wdthpercent12 left">
											<img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/profile/<?php echo $renter_detail['user_picture'];?>&height=46px&width=45px">
										</div>
										<?php echo $deliver; ?><?php	echo $drop; ?>	
										<div class="wdthpercent20 left pR10">
											<p class="font11 color1">East Earnings:</p>
											<p class="priceshow txtcenter">$75</p>
										</div>
										<div class="wdthpercent20 left">
											<a class="bluelinks" href="#">Contact Renter</a><br>
											<a class="bluelinks" href="#">Change Reservation</a>
										</div>                                    
									</div>
							<?php
							} 
							?>
					<!-- -->									
					</div>
			</div>
			<!--/Dashboard Content-->
	<?php
	}
	?>
	
	<!--/Pagination----------->                      
	<div class="pT20 reviewlisting">
		<ul><li><?php   echo $list_of_items_object->renderFullNav();?></li></ul>
	</div>
	<!--/Pagination----------->
<?
}
?>