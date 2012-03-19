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
$sql=admin::displayItems();
$objPagination=new Ps_Pagination($conn, $sql, 5, 5);
$exsql =$objPagination->paginate();
$total_item=mysql_num_rows($exsql);


?>
	<?php
	 if($total_item>0)
	 {
	?>
	<table width="100%" border='1'>
	  <tr>
	    <th colspan="7">Item Listings</th>
	  </tr>
	  <tr>
	   <th>Item Image</th>
		<th>Owner Name</th>
		<th>Item Name</th>
		<th>Price per Day</th>
		<th>Number of items</th>
		<th>Actions</th>
		<th>Added On</th>
	  </tr>
	  <?php
        while($all_item=mysql_fetch_assoc($exsql))
		 {?>
		 <tr>
		  <td>
		   <img src="<?=$URL_SITE?>classes/show_image.php?filename=../images/itemimages/<?php echo$all_item['item_id']?>/<?php echo $all_item['filename']?>&height=100">
		  </td>
		  <td>
		    <?php
               $owner=admin::displayOwnername($all_item['owner_id']);
	           echo"<a href='viewUser.php?user_id=".$all_item['owner_id']."'>".$owner."</a>"; 
		    ?>
		  </td>
		  <td>
		    <a href="viewItem.php?item_id=<?php echo $all_item['id'] ?>"><?php echo $all_item['item_name'];  ?></a>
		  </td>
		   <td>
		    <?php echo $all_item['item_Price']."$";  ?>
		  </td>
		  <td>
		    <?php echo $all_item['item_numberavailavel'];  ?>
		  </td>
		  <td>
		    <a href="viewItem.php?item_id=<?php echo $all_item['id'] ?>">View</a>&nbsp;&nbsp;<a href="?del_id=<?php echo $all_item['id'] ?>"  onclick="javascript: return confirm('Are yousure you want to delete this Item?'); "> Delete</a>
		  </td>
		  <td>
		    <?php echo $all_item['created_on'];  ?>
		  </td>
		 </tr>
	<?php
		 }?>
		  <th colspan="7"><?php echo $objPagination->renderfullnav(); ?></th>
 </table>
		 <?php
	 }else{
		echo "There is no item ";
	}
	?>

	<?php include("../include/adminFooter.php"); ?>