<?php
include('../include/adminHeader.php');
if(!isset($_SESSION['a_info']['id']))
{
	header("location:".$URL_SITE."admin/index.php");
}

if(isset($_REQUEST['del_id']))
{
	$user_id=$_REQUEST['del_id'];
	$result=admin::deleteUser($user_id);
	$_SESSION['succ_msg']="User Deleted successfully";
	header("location:".$URL_SITE."admin/home.php");
}
 $sql=admin::displayUsers();
 $objPagination=new Ps_Pagination($conn, $sql, 5, 5);
 $exsql =$objPagination->paginate();
// $item_query=mysql_query($result);
 $total_item=mysql_num_rows($exsql);


?>
	<?php
	 if($total_item>0)
	 {
	?>
	<table width="100%" border='1'>
	<tr>
	  <th colspan="6">User Listings</th>
	</tr>
	  <tr>
	   <th></th>
	   <th>Name</th>
		<th>Email</th>
		<th>City</th>
		<th>State</th>
		<th>Actions</th>
		
	  </tr>
	  <?php
        while($all_item=mysql_fetch_assoc($exsql))
		 {?>
		 <tr>
		  <td>
		   <img src="<?=$URL_SITE?>classes/show_image.php?filename=../images/itemimages/1/4f1cfa0fba0e5.jpg&height=100">
		  </td>
		  <td>
		   <a href="<?=$URL_SITE?>admin/viewUser.php?user_id=<?php echo $all_item['id']?>"><?php echo $all_item['user_fname']." ".$all_item['user_lname'] ;?>
		  </td>
		   <td>
		    <?php echo $all_item['user_email'];  ?>
		  </td>
		  <td>
		    <?php echo $all_item['user_city'];  ?>
		  </td>
		  <td>
		    <?php echo $all_item['user_state'];  ?>
		  </td>
		  <td>
		    <a href="viewUser.php?user_id=<?php echo $all_item['id'] ?>">View</a>&nbsp;&nbsp;<a href="?del_id=<?php echo $all_item['id'] ?>"  onclick="javascript: return confirm('Are yousure you want to delete this User?'); "> Delete</a>&nbsp;&nbsp;
			<div id="showresult_<?php echo $all_item['id'];?>">
			<?php 
				if($all_item['user_status']=='1')
			 {?>
			 <a href="#" id="block_<?php echo $all_item['id'];?>" alt="Block this user">Block</a>
			<script>
            $(document).ready(function(){
			$("#block_<?php echo $all_item['id'];?>").click(function(){	
			var type="<?php echo $all_item['user_status'];?>";
			var user_id="<?php echo $all_item['id'];?>";
			$.ajax({
			type: "GET",
			url: "changeUserStatus.php?type="+type+"&user_id="+user_id,
			success: function(msg){
			$("#showresult_<?php echo $all_item['id'];?>").html(msg);
			}
			});
			});
		});
     
	</script>
			 <?php
			 }elseif($all_item['user_status']=='0')
			 {?>
              <a href="#" id="unblock_<?php echo $all_item['id'];?>" alt="Unblock this user">Unblock</a>
			  <script>
            $(document).ready(function(){
			$("#unblock_<?php echo $all_item['id'];?>").click(function(){	
			var type="<?php echo $all_item['user_status'];?>";
			var user_id="<?php echo $all_item['id'];?>";
			$.ajax({
			type: "GET",
			url: "changeUserStatus.php?type="+type+"&user_id="+user_id,
			success: function(msg){
			$("#showresult_<?php echo $all_item['id'];?>").html(msg);
			}
			});
			});
		});
     
	</script>
			  <?php
			 }
			?>
			</div>
		  </td>
		 </tr>
		
	<?php
		 }?>
		  <th colspan="6"><?php echo $objPagination->renderfullnav(); ?></th>
 </table>
		 <?php
	 }else{
		echo "There is no User ";
	}
	?>

	<?php include("../include/adminFooter.php"); ?>