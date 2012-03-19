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

	$result=user::updateContact($contact,$user_id);
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

	header('location:home.php');
	exit;
}	   
?>

<!--Dashboard Content-->
<div class="wdthpercent100">
		
		<!--Dashboard Left-->
		<div class="DashboarddivL">
			<!--Dashboard profile-->
			<div class="dashwhitebg mB15">
				<div class="dashboardprofile">
						<p class="pB10">
							<img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/profile/<?php echo $row['user_picture'];?>&width=180&height=180">
						</p>
						<p>
							<a href="javascript:;" id="upload_picture">Edit Picture</a>
				
						</p>
						
						<div style="display:none;" id='userImage'>
							<?php include('userImage.php');?>
						</div>
				</div>
			</div>
			<!--/Dashboard profile-->
		</div>
		<!--/Dashboard Left-->

		<!--Dashboard Right-->
		<div class="DashboarddivR">
			<div class="dashwhitebg">
			<div class="dasheditprofile">
				<h4>Required</h4>
				  <form action = "" method="post" id="edituser">
					 <table width="100%" cellspacing="0" cellpadding="0" border="0">
					   <tbody>

					    <tr>
						 <td class="bdrbtmgrey">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
							  <tbody><tr>
								<td width="18%" height="30" class="fontbld">First Name</td>
								<td><input name="fname" class="required inputprofile" type="text" value="<?php  echo $row['user_fname'];?>"></td>
							  </tr>
							  <tr>
								<td height="30" class="fontbld">Last Name</td>
								<td><input name="lname" class="required inputprofile" type="text" value="<?php echo $row['user_lname'];?>"></td>
							  </tr>
							  <tr>
								<td>&nbsp;</td>
								<td class="msgtxt">This is only shared once you have confirmed a rental with another SparkSwap user</td>
							  </tr>
							</tbody></table>

						</td>
					  </tr>

					  <tr>
						<td class="bdrbtmgrey">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
							  <tbody><tr>
								<td width="18%" height="30" class="fontbld">Gender</td>
								<td>
									<select name="gender" class="required selectprofile">
									   <option value="" selected>select</option>

									   <option value="M" <?php if($row['gender']=='M'){ echo "selected";}  ?>>Male</option>

										<option value="F" <?php if($row['gender']=='F'){ echo "selected";}  ?>>Female</option>

									 </select>
								</td>
							  </tr>
							  <tr>
								<td>&nbsp;</td>
								<td class="msgtxt"><span class="colorblue">Private</span>. We never share this data with anyone else.</td>
							  </tr>
							</tbody></table>
						</td>
					  </tr>

					  <tr>
						<td class="bdrbtmgrey">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
							  <tbody><tr>
								<td width="18%" height="30" class="fontbld">Email</td>
								<td><input class="inputprofile" readonly="readonly" name="email" type="text"  value="<?php  echo $row['user_email'];?>"></td>
							  </tr>
							  <tr>
								<td>&nbsp;</td>
								<td class="msgtxt">This is only shared once you have confirmed a rental with another SparkSwap user</td>
							  </tr>
							</tbody></table>
						</td>
					  </tr>

					  <tr>
						<td class="">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
							  
								  <tbody>
										  <?php
										  if(!empty($contact_arr))
										  {
												foreach($contact_arr as $key=>$value)
												{
													if($value!="")
													{
													?>										  
													   <tr id="clonefrm">
															<td width="18%" height="30"></td>
															<td>
																<div class="roundedprofilediv">

																	<div class="wdth118 left">
																		<input name="contact[]" id="contact" class="inputboxprofile digits required" type="text" value="<?php  echo $value;?>">
																	</div>

																	<div class="left pR5">
																		<input name="save_sms" type="submit" value="VERIFY VIA SMS" class="grybtnprofile wdth75">
																	</div>

																	<div class="left">
																		<input name="save_call" type="submit" value="VERIFY VIA CALL" class="grybtnprofile wdth75">	
																	</div>
																</div>
																	
																<div class="roundedprofilediv">
																	<a href="?contact_delete=<?php echo $key ?>&user_id=<?php  echo   $id;?>" onclick="javascript: return confirm('Are You sure want to delete this contact')"><input class="grybtnprofile" type="button" value="Remove" id="removeClone_edit"></a>
																	<input class="grybtnprofile" type="button" name="remove" id="removeClone" value="Remove" style="display:none"/>
																</div>								
															</td>										
													  </tr>
												  <?php
												  }
											   }
											   ?>

											  <tr width="40%" valign="top">&nbsp;</tr>
											  <tr id="cloneing" class="" style="display:none"></tr>

											   <tr>
												   <td>&nbsp;</td>
												   <td>
														<div class="wdthpercent100 pT5">
															<input type="button" name="addnewno" id="addnewno" class="grybtnprofile" value="ADD NEW NUMBER" class=""/>											
															<p class="msgtxt">This is only shared once you have confirmed a rental with another SparkSwap user</p>
													   </div>
												   </td>
											   </tr>
											<?
											}
											else
											{
											?>

											<tr id="clonefrm">
													<td width="18%" height="30"></td>
													<td>
														<div class="roundedprofilediv">

															<div class="wdth118 left">
																<input name="contact[]" id="contact" class="inputboxprofile digits required" type="text" value="">
															</div>

															<div class="left pR5">
																<input name="save_sms" type="submit" value="VERIFY VIA SMS" class="grybtnprofile wdth75">
															</div>

															<div class="left">
																<input name="save_call" type="submit" value="VERIFY VIA CALL" class="grybtnprofile wdth75">	
															</div>

															<div class="left">
																<input class="grybtnprofile" type="button" name="remove" id="removeClone" value="Remove" style="display:none"/>	
															</div>

														</div>

														<tr width="40%" valign="top">&nbsp;</tr>
														<tr id="cloneing" class="" style="display:none"></tr>

													    <tr>
														   <td>&nbsp;</td>
														   <td>
																<div class="wdthpercent100 pT5">
																	<input type="button" name="addnewno" id="addnewno" class="grybtnprofile" value="ADD NEW NUMBER" class=""/>											
																	<p class="msgtxt">This is only shared once you have confirmed a rental with another SparkSwap user</p>
															   </div>
														   </td>
													    </tr>
												   </td>
											  </tr>
										  <?php
										  }
										  ?>							 
										  
										  <tr>
											<td>&nbsp;</td>
										  </tr>

										 <tr>
											<td height="30" class="fontbld">City</td>
											<td><input class="inputprofile required" name="city" type="text" value="<?php echo $row['user_city'];?>">
											</td>
									     </tr>

										 <tr>
                                             <td height="30" class="fontbld pT10">About Me</td>
                                             <td>
												<textarea class="inputeditprofile" name="about_me" value=""><?php echo $row['about_me'];?></textarea> 
											 </td>
                                         </tr>

									     <tr>
											<td height="30">&nbsp;</td>
											<td align="right"><input name="save" class="profilehbutton" type="submit" value="Save">
											</td>
									    </tr>
								  </tbody>
							  </table>
						   </td>
					  </tr>
					  
					  <tr>
						<td>&nbsp;</td>
					  </tr>
					</tbody>
				</table>
			  </form>
			</div>
		</div>                            
	</div>
	<!--/Dashboard Right-->
</div>
<!--/Dashboard Content-->


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