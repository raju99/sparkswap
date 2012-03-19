<?php
include("../include/application.php");
if(isset($_REQUEST['type']) && ($_REQUEST['type']==0))
{
	if(isset($_REQUEST['user_id']))
	{
		$user_id=$_REQUEST['user_id'];
	}
	  $user_status=$_REQUEST['type'];
	  $exsql=admin::updateUserStatus($user_id, $user_status); 
	  ?>
   <a href="#" id="unblock_<?php echo $user_id?>" title="Make it blocked">Block</a> 
     
     <script>
	$(document).ready(function(){
	$("#unblock_<?php echo $user_id?>").click(function(){	
	var type='1';
	var user_id='<?php echo $user_id?>';
	$.ajax({
	type: "GET",
	url: "changeUserStatus.php?type="+type+"&user_id="+user_id,
	success: function(msg){
	$("#showresult_<?php echo $user_id?>").html(msg);
	}
	});
	});
      });
     
	</script>
<?php
}
elseif(isset($_REQUEST['type']) && ($_REQUEST['type']==1))
{
	if(isset($_REQUEST['user_id']))
	{
		$user_id=$_REQUEST['user_id'];
	}
	 $user_status=$_REQUEST['type'];
	 $exsql=admin::updateUserStatus($user_id, $user_status);
	 ?>
	 
    <a href="#" id="block_<?php echo $user_id?>" title="Make it blocked">Unblock</a>
     
     <script>
    
	$(document).ready(function(){
	$("#block_<?php echo $user_id?>").click(function(){	
	var type='0';
	var user_id='<?php echo $user_id?>';
	$.ajax({
	type: "GET",
	url: "changeUserStatus.php?type="+type+"&user_id="+user_id,
	success: function(msg){
	$("#showresult_<?php echo $user_id?>").html(msg);
	}
	});
	});
      });
     
	</script>
<?php
}
?>

 
    
    
 