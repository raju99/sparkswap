<?php
include('../include/adminHeader.php');
if(!isset($_SESSION['a_info']['id']))
{
	header("location:".$URL_SITE."admin/index.php");
}
if(isset($_REQUEST['del_id']))
{
	$item_id=$_REQUEST['del_id'];
	$result=admin::deleteItem($item_id);
	$_SESSION['succ_msg']="Item Deleted successfully";
	header("location:".$URL_SITE."admin/itemManagement.php");
}
if(isset($_REQUEST['item_id']))
{
  $item_id=$_REQUEST['item_id'];
}
 $item_result=admin::selectItem($item_id);
?>
<table width="100%" border='1'>
 <tr>
   <td>
     Item Name:<?php echo $item_result['item_name'];?><br>
	 Added On:<?php 
	           $added_date=strtotime($item_result['created_on']);
			   echo date('Y-M-D H:i:s',$added_date);
	             ?>
   </td>
 </tr>
 <tr>
   <td>
  
   <img src="<?=$URL_SITE?>classes/show_image.php?filename=../images/itemimages/1/4f1cfa0fba0e5.jpg&height=400"><br>
	Item Price(Per Day):<?php echo $item_result['item_Price']."$";  ?>
   </td>
 </tr>
 <tr>
   <td>
   Description:<br>
   <?php echo $item_result['item_description'];?>
   </td>
 </tr>
 <tr>
  <td>
   <a href="?del_id=<?php echo $item_result['$item_id']  ?>">Delete</a>
   </td>
 </tr>

 </table>
 <?php include("../include/adminFooter.php"); ?>