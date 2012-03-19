<?php
include('../include/header.php');

	if(isset($_POST['search']))
	{
			 $sql=user::searchAll();
			$objPagination=new Ps_Pagination($conn, $sql, 5, 5);
			$exsql =$objPagination->paginate();
			$total_item=mysql_num_rows($exsql);
	}
	else
	{
			echo $sql=admin::displayItems();
			$objPagination=new Ps_Pagination($conn, $sql, 5, 5);
			echo $exsql =$objPagination->paginate();
			$total_item=mysql_num_rows($exsql);
	}


if(isset($_REQUEST['del_id']))
{
	$item_id=$_REQUEST['del_id'];
	$result=admin::deleteItem($item_id);
	$_SESSION['succ_msg']="Item Deleted successfully";
	header("location:".$URL_SITE."admin/itemManagement.php");
}



if(isset($_SESSION['MSG']))
{
	echo $_SESSION['MSG'];
	 unset($_SESSION['MSG']);
}

?>
<h2>item listing</h2><br/>
<a href="addItem.php" >ADD Item</a>
	
	<?php
	 if($total_item>0)
	 {
	?>
<table width="100%" border='1'>
	  <tr>
	   <th>Item Image</th>
		
		<th>Item Name</th>
		<th>Price per Day</th>
		<th>Number of items</th>
		<th>Actions</th>
		<th>Added On</th>
	  </tr>
	  <?php
        while($all_item=mysql_fetch_assoc($exsql))
		 {
		 $mainimage=user::selectImage($all_item['id']);
		// $true=$selectallFreeITem($all_item['id']);
		 ?>
		 <tr>
		  <td>
		    <img src="<?php echo $URL_SITE ;?>classes/show_image.php?filename=../images/itemimages/<?php echo $all_item['id'] ;?>/<?php echo $mainimage['filename'] ; ?>&height=100">
		  </td>
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
		    <a href="newView.php?item_id=<?php echo $all_item['id'] ?>&user_id=<?php echo $all_item['owner_id']; ;?>">View</a>&nbsp;&nbsp;
			
			<?php 
				if(isset($_SESSION['']))
			 {
				?>
			<a href="?del_id=<?php echo $all_item['id'] ?>"  onclick="javascript: return confirm('Are yousure you want to delete this Item?'); "> Delete</a>

			 <a href="editItem.php?item_id=<?php echo $all_item['id'] ?>">Edit</a>
			 <?PHP
			 }
			 ?>
		  </td>
		  <td>
		    <?php echo date("d-M-Y",strtotime($all_item['created_on']));  ?>
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