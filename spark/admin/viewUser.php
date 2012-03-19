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
if(isset($_REQUEST['user_id']))
{
  $user_id=$_REQUEST['user_id'];
}
 $user_result=admin::selectUser($user_id);
?>
<table width="100%" border='1'>
 <tr>
   <td>
   <img src="<?=$URL_SITE?>classes/show_image.php?filename=../images/itemimages/1/4f1cfa0fba0e5.jpg&height=100">
   </td>
 </tr>
 <tr>
   <td>
    Name:<?php echo $user_result['user_fname'];?>&nbsp;<?php echo $user_result['user_lname'];?>
   </td>
 </tr>
 <tr>
   <td>
   Email: <?php echo $user_result['user_email'];?>
   </td>
 </tr>
 <tr>
   <td>
  City: <?php echo $user_result['user_city'];?>
   </td>
 </tr>
 <tr>
   <td>
    State: <?php echo $user_result['user_state'];?>
   </td>
 </tr>
 <tr>
   <td>
    Zip: <?php echo $user_result['user_zip'];?>
   </td>
 </tr>
 <tr>
   <td>
  Contact No: <?php echo $user_result['contact'];?>
   </td>
 </tr>
 <tr>
  <td>
   <a href="?del_id=<?php echo $item_result['$item_id'] ; ?>">Delete</a>&nbsp;
   <div id="showresult_<?php echo $user_result['id'];?>">
			<?php 
				if($user_result['user_status']=='1')
			 {?>
			 <a href="#" id="block_<?php echo $user_result['id'];?>" alt="Block this user">Blocked</a>
			<script>
            $(document).ready(function(){
			$("#block_<?php echo $user_result['id'];?>").click(function(){	
			var type="<?php echo $user_result['user_status'];?>";
			var user_id="<?php echo $user_result['id'];?>";
			$.ajax({
			type: "GET",
			url: "changeUserStatus.php?type="+type+"&user_id="+user_id,
			success: function(msg){
			$("#showresult_<?php echo $user_result['id'];?>").html(msg);
			}
			});
			});
		});
     
	</script>
			 <?php
			 }elseif($user_result['user_status']=='0')
			 {?>
              <a href="#" id="unblock_<?php echo $user_result['id'];?>" alt="Unblock this user">Unblocked</a>
			  <script>
            $(document).ready(function(){
			$("#unblock_<?php echo $user_result['id'];?>").click(function(){	
			var type="<?php echo $user_result['user_status'];?>";
			var user_id="<?php echo $user_result['id'];?>";
			$.ajax({
			type: "GET",
			url: "changeUserStatus.php?type="+type+"&user_id="+user_id,
			success: function(msg){
			$("#showresult_<?php echo $user_result['id'];?>").html(msg);
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

 </table>
 <?php include("../include/adminFooter.php"); ?>