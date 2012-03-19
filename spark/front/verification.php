<?php
include('../include/header.php');
if(!isset($_SESSION['user']['id']))
{
	header("location:".$URL_SITE."front/login.php");	// session is not set
}
/*
if(isset($_GET['type']) and $_GET['type']='twitter')	// user is connected with twitter
{
$res=user::conncetivity('twitter_status',0);// parameters fieldname, value

if(mysql_affected_rows()>0)
{
	$_SESSION['msg']='21';
	header('location:'.$URL_SITE.'front/verification.php');
}
}*/
$socialWeb_status_res=user::socialWebstatusofUser($_SESSION['user']['id']);
$socialWeb_status=mysql_fetch_array($socialWeb_status_res);
?>
<!-- Twitter connect -->
<script src="http://platform.twitter.com/anywhere.js?id=<?php echo $twitter_api_key;?>&v=1" type="text/javascript"></script>
<!--/Twitter connect -->

<!-- LinkedIn connect -->
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
   api_key:v02rjnw4phm2
$(function(){
$('#linkedin')
.css({display:'none'});
});
   onLoad: onLinkedInLoad
   authorize: true
</script>
<span id="profiles">
</span>
<!--/LinkedIn connect -->

<!-- Facebook connect -->
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
  FB.init({
	appId      : <?php echo $app_id;?>,
	status     : true, 
	cookie     : true,
	xfbml      : true,
	oauth      : true,
  });


// this event will catches when a user session has been modified...
FB.Event.subscribe('auth.authResponseChange', function(response) {
if(response.status=='connected')
	{
		jQuery.ajax({
		type: "GET",
		url: "socialSettings.php?type=facebook&connected=true",
		success: function(msg)
		{	
		$("#fb_dis").html(msg);								
		}
		});
	}
});
};
(function(d){
   var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   d.getElementsByTagName('head')[0].appendChild(js);
 }(document));
</script>
     
<!--/Facebook connect-->


<!--Dashboard Content------------>
<div class="wdthpercent100">
	<div class="dashwhitebg">
		
		<!-- FACEBOOK,TWITTER,LINKEDIN,PHONE NUMBER STATUS CHECK -->
		<div class="dashverifiedprofile">
			<p class="pB10">
				SparkSwap depends on a community of trustworthy participants. Validating your identity allows you to participate more actively in the system!
			</p>
			<div class="wdthpercent100">
				<?php
				if(($socialWeb_status['facebook_status']=='1') || ($socialWeb_status['twitter_status']=='1') || ($socialWeb_status['linkedin_status']=='1')) { ?>
				<h4 class="verified">Verified</h4> <? } else {?>
				<h4 class="notverified">Unverified</h4> <? } ?>
				<center>
					<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
							<?php
							if($socialWeb_status['facebook_status']=='1')
							{
							?>
								  <tr>
									<td width="75%" height="40" class="bdrbtmgrey">
										<p class="verifiedtxt">Facebook Connected</p>
									</td>
									<td class="bdrbtmgrey"><a href="javascript:;">Connected</a></td>
								  </tr>
							<?
							}
							else
							{?>
								<tr id="fb_dis">
									<td width="75%" height="40" class="bdrbtmgrey">
										<p class="notverifiedtxt">Facebook Disconnected</p>
									</td>
									<td class="bdrbtmgrey">
									<div class="fb-login-button" data-scope="email,user_checkins">
									connect
									</div>
									</td>
								</tr>
					<script>
							
					</script>

							<?
							}
							?>
						

							<?php
							//print_r($_SESSION);
							//echo $socialWeb_status['twitter_status'];
							if($socialWeb_status['twitter_status']=='1')
							{
							?> 
								<tr id=''>
									<td height="40" class="bdrbtmgrey">
										<p  class="verifiedtxt">Twitter Connected</p>
									</td>
									<td id='' height="40" class="bdrbtmgrey"><a href='javascript:;' id='twitter_disconnect'>Connected</a><td>
									<!-- <td class="bdrbtmgrey"><a href="?type=twitter&connected=false">Disconnect</a></td> -->
								</tr>
							<?
							}
							else
							{							
								?>
								<!-- Checking whether a user is loged in or not -->
								<script type="text/javascript">

								twttr.anywhere(function (T) {

								T("#twitter_id").connectButton({
								authComplete: function(user) {
								jQuery.ajax({
								type: "GET",
								url: "socialSettings.php?type=twitter&connected=true",
								});
								},

								signOut: function() {
								// triggered when user logs out
								}
								});

								});

 
								</script>
							
								
								<!-- /Checking whether a user is loged in or not -->

								<tr>
									<td height="40" class="bdrbtmgrey">
										<p class="notverifiedtxt">Twitter Disconnected</p>
									</td>
									<td class="bdrbtmgrey" id="twitter_id"></td>
								</tr>
							
							
							<?
							}
							?>


							<?php
							if($socialWeb_status['linkedin_status']=='1')
							{
							?>
						<!-- //call this function just for simplicity cause on load have it will throw an exeption if this function is not found -->
							<script>
								function onLinkedInLoad() {			// calls when page is loaded
									//IN.Event.on(IN, "auth", onLinkedInAuth);
								}
							</script>
								<tr>
									<td height="40">
										<p class="verifiedtxt">Linkedln Connected</p>
									</td>
									<td><a href="javascript:;">Connected</a></td>
								</tr>    
							<?
							}
							else
							{?>
							<script>
								function onLinkedInLoad() {			// calls when page is loaded
									IN.Event.on(IN, "auth", onLinkedInAuth);
								}

								function onLinkedInAuth() {			// calls linkedin api to fetch	current users profile
									IN.API.Profile("me").result(displayProfiles);
								}

								function displayProfiles(profiles) {		// function we call to enter values if user connected
									jQuery.ajax({
									type: "GET",
									url: "socialSettings.php?type=linkedin&connected=true",
									success: function(msg)
									{	
									$("#Linkedln_dis").html(msg);								
									}
									});
								}
							</script>
								<tr id="Linkedln_dis">
									<td height="40">
										<p class="notverifiedtxt">Linkedln Disconnected</p>
									</td>
									<td>
										<script type="in/Login"></script>
									</td>
								</tr>    
							
							
							<?
							}
							?>					                                        
					</table>
				</center>
			</div>
			
			<div class="wdthpercent100">
				<h4 class="notverified">not Verified</h4>
				<center>
					<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td class="bdrbtmgrey">
							<p class="notverifiedtxt">Phone Number Not Verified</p>
							<p class="pT10">
							Make it easier to communicate with SparkSwap members by confirming your phone number. We will send you a code by SMS or read it to 
							you over the phone. Enter the code below to confirm your identity.
							</p>
							<p class="pT10 pB10">
							Your phone number is only shared with SparkSwap members after a rental is confirmed.
							</p>
							<div class="roundedprofilediv">
									<div class="wdth118 left"><input type="text" name="" value="+1 210 555 1234" class="inputboxprofile"  /></div>
									<div class="wdth75 left pR5"><input type="submit" name="" value="VERIFY VIA SMS" class="grybtnprofile" /></div>
									<div class="wdth75 left"><input type="submit" name="" value="VERIFY VIA CALL" class="grybtnprofile" /></div>
							</div>
							<div class="wdthpercent100 pT5">
								<input type="submit" name="" value="ADD NEW NUMBER" class="grybtnprofile" />
							</div>
						</td>
					  </tr>
					  <tr>
						<td>
							<p class="notverifiedtxt">No Positive Reviews</p>
							<p class="pT10">
							Reviews help communicate your personality and transaction history. If you get good reviews, you can rent and list more easily!
							</p>
							<p class="pT10">
							Tip: To be reviewed, leave a review for another person first.
							</p>
						</td>
					  </tr>                                         
					</table>
				</center>
			</div>
				
			</div>
			<!-- /FACEBOOK,TWITTER,LINKEDIN,PHONE NUMBER STATUS CHECK -->

	</div>
</div>
<!--/Dashboard Content-------->

<?php 
include('../include/footer.php');
?>