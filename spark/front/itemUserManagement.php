<?php
include('../include/header.php');
if(!isset($_SESSION['user']))
{
	header("location:".$URL_SITE."front/login.php");
}
if(isset($_REQUEST['del_id']))
{
	$item_id=$_REQUEST['del_id'];
	$result=admin::deleteItem($item_id);
	$_SESSION['MSG']="Item Deleted successfully";
	header("location:".$URL_SITE."front/itemUserManagement.php");

}
	$sql=user::displayItems($user_id);
	$objPagination=new Ps_Pagination($conn, $sql, 5, 5);
	$exsql =$objPagination->paginate();
	$total_item=mysql_num_rows($exsql);



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
		$mainimage=$mainimage=itemClass::select_featured_image($all_item['id']);
		 
		 ?>
		 <tr>
		  <td>
		   <img src="<?php echo $URL_SITE ;?>classes/show_image.php?filename=../images/itemimages/<?php echo $all_item['id'] ;?>/<?php echo $mainimage['filename'] ; ?>&height=100">
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

			 <a href="editItem.php?item_id=<?php echo $all_item['id'] ?>">Edit</a>
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

<?php 
include('../include/footer.php');
?>