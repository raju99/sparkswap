<?php
/******************************************
* @created on march 14,2012
* @Package: Maduhaa
* @Developer: Praveen Singh
* @URL : http://www.maduhaa.com
********************************************/

$user_id=$_SESSION['user']['id'];
$user_res=user::selectAllUser($user_id);
$user=mysql_fetch_assoc($user_res);

if(isset($_POST['block_account']))
{
	$user_id=$_SESSION['user']['id'];
	$block=user::blockAccountStatus($user_id);	
	header("location:".$URL_SITE."front/logout.php?msg");	
	exit;	
}

if(isset($_POST['change_password']))
{
	$user_id=$_SESSION['user']['id'];
	$current_pwd=md5($_POST['cur_pass']);
	$new_pwd=md5($_POST['new_pass']);

	$update=user::updateUserPassword($user_id,$new_pwd);
	$_SESSION['msg']=22;
	header("location:".$URL_SITE."front/home.php");	
	exit;		
}
?>
<div class="Dashboarddiv fontbld">
	 <div class="pB15 dashwhitebg"><h4>Settings</h4></div>
		<div class="dashwhitebg mB10 mR30">
			<form method="post" action="">
				<div class="dasbmessages">
					<h3>Cancel account</h3>
					
					<div class="dasbmessagesbdr">
						<div class="dasbmessagespicdiv">
							<a href="javascript:;"><img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/profile/<?php echo $user['user_picture'];?>&height=67px&width=47px">
							</a>					
						</div>

						<div class="dasbmessagesdatediv"><?=ucwords($user['user_fname'].'&nbsp;'.$user['user_lname']);?></div>
						<div class="dasbmessagescontdiv">
							<p class="colororange"><a href="javascript:;"><?php echo $user['user_email'];?></a></p>						
						</div>
					</div>
					<div class="wdthpercent100 pT10">
						<a href="javascript:;" onclick="javascript: return del();"><input class="listitempostit right" type="submit" name="block_account" value="Cancel account"/></a>						
					</div>
				</div>
			</form>
		</div>
		<div class="clear pT20">	</div>

		<div class="dashwhitebg mB10 mR30">
			<div class="dasbmessages">
				<h3>Change password </h3>

						<form method="post" action="" id="change_password_cp" enctype="multipart/form-data">
							<div class="dasbmessagesbdr">

									<div class="wthper100 pB10">
										<div class="wthper30 left"><h5> Current Password: </h5></div>

										<div class="wthper70 left">	
											<input type="password" name="cur_pass" class="required wthper95">					
										</div>	
									<div class="clear">	</div>
									</div>

									<div class="wthper100 pT10">
										<div class="wthper30 left"><h5> New Password: </h5></div>

										<div class="wthper70 left">	
											<input type="password" name="new_pass"  class="required wthper95">					
										</div>
									<div class="clear">	</div>
									</div>	
									
							</div>
						
							<div class="wdthpercent100 pT10">
								<input class="listitempostit right" type="submit" name="change_password" value="Save password"/>				
							</div>
					</form>
			</div>
		</div>
</div>

<script language="javascript">
$(document).ready(function(){	 
	$("#change_password_cp").validate({			   
             rules: 
			 { 				
					 "cur_pass":
					 {
						remote: URL_SITE+"/front/userAvailibility.php",
					 }
			},
			messages: 
			{				
					"cur_pass": 
					{
						remote: jQuery.format("<font color='red'>current password doesnot match</font>")
					}
									
			}
       });
 });
</script>