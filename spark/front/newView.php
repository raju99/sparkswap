<?php
include('../include/header.php');


if(isset($_REQUEST['item_id']))
{
  $item_id=$_REQUEST['item_id'];
}
 $allItemdetail=user::mainDetailOfItem($item_id);



 $allItemimage=user::selectImage($item_id);


echo '<h2>'.$allItemdetail['item_name'].'</h2>';
?>
<div class="wdthpercent33 left">
	<!-- 	<p>
		Owner : <a href=""><?php echo $allItemdetail['user_fname'] ; ?></a> posted on <?php echo $allItemdetail['created_on'] ; ?></p> -->
		<p>
		<a href=""><?php echo $allItemdetail['item_subtitle'] ; ?></a> posted on <?php echo $allItemdetail['address1'] ; ?></p>
		

</div>
<div style="float:right;"><a href="sendMessage.php?item_id=<?php echo $allItemdetail['item_id'] ;?>&user_id=<?php echo $allItemdetail['owner_id']; ?>">contact owner</a>|<a href="feedback.php?item_id=<?php echo $allItemdetail['item_id'] ;?>&user_id=<?php echo $allItemdetail['owner_id']; ?>">feedback and review</a>




<div class="clear pT10"></div>
	
	
		<div>


		
		</div>
		
		
	