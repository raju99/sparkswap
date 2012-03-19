<?php
$settings=user::select_settings_for_user($user_id);
$settings_count=mysql_num_rows($settings);
$result=mysql_fetch_assoc($settings);
if($settings_count>0)
{
	$user_setting['phone']=$result['phone'];
	$user_setting['profile']=$result['profile'];
	$user_setting['persona_desc']=$result['persona_desc'];

}
if(isset($_POST['sumbit']))
{
	print_r($_POST);
	$phone=0;
	$profile=0;
	$description=0;
	$user_id=$_SESSION['user']['id'];
	if(isset($_POST['phone']))
	$phone=1;
	if(isset($_POST['profile']))
	$profile=1;
	if(isset($_POST['description']))
	$description=1;
	if(!isset($user_setting))
	$affected=user::user_settings($user_id,$phone,$profile,$description);
	else
	$affected=user::update_user_settings($user_id,$phone,$profile,$description);
	if($affected>0)
	{
		$_SESSION['msg']=0;
		
	}
	

	header('Location:'.$URL_SITE.'front/mySwaps.php?type=requirements');
}
?>

<div class="wdthpercent100">
<form action="<?php echo $URL_SITE;?>front/mySwaps.php?type=requirements" method="post">
<label>Phone</label><br/>
<input class="mL10 mT5" <?php if(isset($user_setting) and $user_setting['phone']==1){echo 'checked="checked"'; }?> type="checkbox" name="phone">&nbsp;Require Renters to verify their phone number.
<hr class="mT20">

<label class="mT5">Profile Picture</label><br/>
<input class="mL10 mT5" type="checkbox" <?php if(isset($user_setting) and $user_setting['profile']==1){echo 'checked="checked"'; }?> name="profile">&nbsp;Require Renters have a profile picture.
<hr class="mT20">

<label >Personal Description</label><br/>
<input class="mL10 mT5" type="checkbox" <?php if(isset($user_setting) and $user_setting['persona_desc']==1){echo 'checked="checked"'; }?> name="description">&nbsp;Require Renters to provide a  personal desciption.
<hr class="mT20">

<input type="submit" name="sumbit" value="Save">
</form>
</div>