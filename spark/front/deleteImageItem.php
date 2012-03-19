<?php
include("../include/application.php");

$user_id=$_SESSION['user']['id'];

if(isset($_REQUEST['type']) )
{
	$del_id=$_REQUEST['type'];

}
	
$image_name=$_SESSION['image'][$del_id];
unset($_SESSION['image'][$del_id]);
unlink($DOC_ROOT.'/images/temp/' . $user_id . '/' . $image_name);
$arr=$_SESSION['image'];

foreach($arr as $key=>$value)
{ 
	echo "<li class='last'><img src=$URL_SITE/classes/show_image.php?filename=../images/temp/$user_id/$arr[$key]&width=53&height=39/><br><a href='javascript:;' id='delt_$key' onclick='javascript:return confirm('Are you sure want ot delete this Image.')'><font size='1' color='blue'>Delete</font></a><input type='hidden' name='image_list[]'></li>";?>
	 
	<script>
		$(document).ready(function(){
		$("#delt_<?php echo $key?>").click(function(){	
		var type='<?php echo $key?>';
	
		$.ajax({
		type: "GET",
		url: "deleteImageItem.php?type="+type,
		//$("#previewImage").show();
		success: function(msg){
		$("#previewImage").html(msg);
		}
		});
		});
	});
	</script>
<?php
}
?>