<?php
//used for pagination in item page
// contains all reviews by user for an item
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);

include('../include/actionHeader.php');

if(isset($_REQUEST['item_id']))
{
  $item_id=$_REQUEST['item_id'];
}
 $allItemdetail=user::mainDetailOfItem($item_id);

 $countreview=itemClass::countReview($item_id);
$res_review=itemClass::select_reviews($item_id);
 $reviewResult=itemClass::averageReview($item_id);

 $featurimage=itemClass::select_featured_image($item_id);
 $allrow=user::selectItemImages($item_id);

 $sql=itemClass::allReviewOfItem($item_id);
 $exsql=mysql_query($sql);
 $longitude=$allItemdetail['longitude'];// for google map
$latitude=$allItemdetail['latitude'];// for google map
 $limit=3; // limit to show number of reviews in a page
if(isset($_GET['page']))
{
	$page=$_GET['page'];
}
else
{
	$page=1;
}
if($countreview)
{
	while($row=mysql_fetch_assoc($res_review))
	{
		$review_array[]=$row;  // array of all reviews did by some one on this item
	}
	//print_r($review_array);
	$start_record=$limit*($page-1);
	$end_record=$limit*$page;
	$output_array = array_slice($review_array, $start_record, $end_record);
	$count_output_array=count($output_array);
	$divide=$countreview/$limit;
}


?>
<?php
if($countreview)
{
foreach($output_array as $row)
{
   $user_profile=user::user_profile($row['user_id'])
   ?>
 <div class="itemprofile">
   <div class="itemprofileL">
   
	   
	
	<img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/profile/<?php echo $user_profile['user_picture'] ;?>&height=67px&width=47px" alt="no picture"/>
	

	  <h5> <?php echo $user_profile['user_fname'] ;?> </h5>
	</div>
	 
	 <div class="itemprofileR">
	   <div class="txtb"><?php echo $row['reviews'] ;?> </div>
		</div>
	</div>
	<?php
	}
  ?>
	 
 <div class="itembottom reviewlisting">
<ul>
 <?php if($page!=1){?>
 <li> <a class="" href="javascript:;" onclick="pagination_item_page(<?php echo ($page-1);?>,<?php echo $item_id;?>)">Previous</a> </li>
 <?php }?>
	<li> <a class="" href="javascript:;" onclick="pagination_item_page(<?php echo ($page);?>,<?php echo $item_id;?>)" name="button"><?php echo $page;?></a></li>
<?php if($divide>$page){?>
	<li><a class="" href="javascript:;" onclick="pagination_item_page(<?php echo ($page+1);?>,<?php echo $item_id;?>)"><?php echo $page+1;?></a></li>
	<li> <a class=" " href="javascript:;" onclick="pagination_item_page(<?php echo ($page+1);?>,<?php echo $item_id;?>)">next</a></li>

	<?php }

?>
<span style="display:none" id="loding">Loding.....</span>
</ul>
</div> 
<?php
}else{?>
<div class="itemprofile"> No review
</div>
<?php
}

?>