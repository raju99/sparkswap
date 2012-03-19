<?php
include('../include/header.php');
if(!isset($_SESSION['user']['id']))
{
	header("location:".$URL_SITE."front/login.php");
}

/*-------------------code to remove  user Contact(clone)  starts----------------------------------*/

if(isset($_REQUEST['contact_delete']))
{ 
	$key=$_REQUEST['contact_delete'];
	$user_id=$_REQUEST['user_id'];
	$result =user::selectAllUser($user_id);
	$row=mysql_fetch_assoc($result);
	$contact_info=$row['contact'];
	$contact_arr=explode(",",$contact_info);
	unset($contact_arr[$key]);
	$contact="";

	foreach($contact_arr as $key=>$value)
	{
		if(!empty($value))
		{
		$contact.=$value.",";
		}
	}

	$result=user::updateContact( $contact,$user_id);

	header("location:profile.php");
	exit;
}

$id=$_SESSION['user']['id'];
$result =user::selectAllUser($id);
$row=mysql_fetch_assoc($result);
$contact_info=$row['contact'];

if($contact_info!="" && $contact_info!=",")
{
	$contact_arr=explode(",",$contact_info);
}
else
{
	$contact_arr=array();
}			 
/*-------------------code to remove  user Contact(clone)  ends---------------------------------*/	
?>

<br/>

<!-- <div id="" class="pB20">
	<a href="profile.php">Edit Profile</a> | <a href="reviews.php">Reviews</a> | <a href="privacy.php">Privacy</a>
</div> -->

<?php
//EDIT USER PROFILE-------------
if(isset($_POST['save']))
{		 
	$fname=mysql_real_escape_string($_POST['fname']);
	$lname=mysql_real_escape_string($_POST['lname']);
	$email=mysql_real_escape_string($_POST['email']);
	$gender=mysql_real_escape_string($_POST['gender']);
	//echo $contact=mysql_real_escape_string($_POST['contact']);
	$city=mysql_real_escape_string($_POST['city']);
	$contact="";

	foreach($_POST['contact'] as $key=>$value)
	{
		$contact.=mysql_real_escape_string($_POST['contact'][$key]).",";
	}

	$result=user::updateUserProfile($fname,$lname,$email,$contact,$city,$id,$gender);
	$_SESSION['msg']='7';

	header('location:profile.php');
	exit;
}	   
?>

	<div class="wthper100">	
			<img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/profile/<?php echo $row['user_picture'];?>&width=100&height=100">
            
			<a class="fontbld" href="javascript:;" id="upload_picture">Edit Picture</a>
			
			<div style="display:none;" id='userImage'>
				 <?php include('userImage.php');?>
		    </div>
					
	</div>

	<form action = "" method="post" id="edituser">

		<table border="0" width="100%" >

			<tr>
				<td  colspan=""></td>
			</tr>

			<tr>
				<td width="40%" valign="top">
				First Name
				</td>
				<td >
					<input name="fname" class="required" type="text" value="<?php  echo $row['user_fname'];?>">
				</td>
				
			</tr>
			<br/>
			
			<tr>
				<td width="40%" valign="top" >
					Last name
				</td>
				<td>
					<input name="lname" class="required" type="text" value="<?php echo $row['user_lname'];?>"><br/><span class="">This is only shared once you have confirmed a rental with another SparkSwap user</span>
				</td>
			</tr>
			<tr>
				<td width="40%" valign="top">
					Gender
				</td>
				<td width="40%" >
				 <select name="gender" class="required">
				   <option value="" selected>select</option>

				   <option value="M" <?php if($row['gender']=='M'){ echo "selected";}  ?>>Male</option>

				    <option value="F" <?php if($row['gender']=='F'){ echo "selected";}  ?>>Female</option>

				 </select>

				</td>
			</tr>
			
			
			<tr>
				<td width="40%" valign="top">
					Email
				</td>
				<td>
					<input class="email required" readonly="readonly" name="email" type="text"  value="<?php  echo $row['user_email'];?>"><br/>This is only shared once you have confirmed a rental with another SparkSwap user
				</td>
			</tr> 
			 <?php
			 if(!empty($contact_arr))
			 {
				foreach($contact_arr as $key=>$value)
				{
					if($value!="")
					{
					?>
						<tr id="clonefrm" >
							<td width="40%" valign="top"></td>
							<td >
								<input name="contact[]" id="contact" class="digits required" type="text" value="<?php  echo $value;?>">
								</td>
								<td><input name="save" type="submit" value="VERIFY VIA SMS"></td >
								<td><input name="save" type="submit" value="VERIFY VIA CALL">
								
							</td>
							<td >
								<a href="?contact_delete=<?php echo $key ?>&user_id=<?php  echo   $id;?>" onclick="javascript: return confirm('Are You sure want to delete this contact')"><input type="button" value="Remove" id="removeClone_edit"></a>
								<input type="button" name="remove" id="removeClone" value="Remove" style="display:none"/>					
							</td>
						</tr> 
					<?php
					}

				 }
			}
			else
			{
			?>
					<tr id="clonefrm" >
						<td width="40%" valign="top"></td>
						<td ><input name="contact[]" id="contact" type="text" value="" class="digits required"></td>
						<td ><input name="save" type="submit" value="VERIFY VIA SMS"></td >
						<td ><input name="save" type="submit" value="VERIFY VIA CALL"></td>
						<td ><input type="button" name="remove" id="removeClone" value="Remove" style="display:none"/></td>
					</tr> 
			<?php
			}
			?>
					
					<tr width="40%" valign="top">&nbsp;</tr>
					<tr id="cloneing" class="">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="button" name="addnewno" id="addnewno" value="Add New Number" class=""/></td>			  
					</tr> 
					<tr>
						<td width="40%" valign="top">City</td>
						<td><input class="required" name="city" type="text" value="<?php echo $row['user_city'];?>"></td>
					</tr>

					<tr>
						<td><input name="save" type="submit" value="Save"></td>
					</tr>
		</table>
	</form>

<?php 
include('../include/footer.php');
?>


<script>
     jQuery(document).ready(function(){ 
	 jQuery("#addnewno").click(function(){
		
		//var container =jQuery('#contact');
		var  template=jQuery("#clonefrm").clone(true).insertBefore(jQuery("#cloneing"));
		    template.find("#removeClone_edit").hide();
			template.find("#removeClone").removeAttr("style");
			template.find("input:text").each(function(){
			   jQuery(this).val("");
			});
	});

	jQuery("#removeClone").click(function(){
		jQuery(this).parent().parent().remove();
		});
});
</script>





      

		






	

		
		