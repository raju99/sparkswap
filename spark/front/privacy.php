<?php
include('../include/header.php');
if(!isset($_SESSION['user']['id']))
{
	header("location:".$URL_SITE."front/login.php");
}
     $user_id=$_SESSION['user']['id'];

     $exsql=user::select_settings_for_user($user_id);
	 $allrow=mysql_fetch_assoc($exsql);

	 
    if(isset($_POST['submit']))
	{
          $result=user::update_user_privacy($user_id);
		  $_SESSION['msg']='6';
		   header("location:".$URL_SITE."front/privacy.php");
	}
 ?>
  
  <div class="dashboardinbox">
  <form action="" method="post">
                        <div class="dashrequirement">
                        	<h4>Social Features</h4>
                            <div class="dashrequrementbdr">
                            	<p>Social Connections allow you to see if you or friend of yours knowns a member of sparkswap community. These connections enhance trust and relaibility with all sparkswap transactions</p><br><br>
								
                                <div class="subtext">
                                	<p>If you Turn this feature off, none of your connection visible to others.</p><br>
                                    <p><input name="social" type="checkbox" value="1" <?php if($allrow['social_status']==1){echo "checked";} ?> /> <span class="color1">Show My Social Connections to others(Recommended)</span></p>
                                </div>
                            </div>
                            
                            <div class="dashrequrementbdr">
                            	<h4>Automatic Facebook Publishing</h4>
                                <div class="subtext">
                                	<p>Share Your rentals,listings,and rentals with your facebook friends and boost your SparkSwap cred!</p><br><br>
                                    <p><input name="facebook" type="checkbox" value="1" <?php if($allrow['facebook_status']==1){echo "checked";} ?> /> <span class="color1">Share my favorites,listings and rentals with facebook</p><br>
                                </div>
                            </div>
                            
                            <div class="wdthpercent100 pT10">
                            	<h4>Your Listings and Profile in Search Engines</h4><br>
                                <div class="subtext">
                                	<p>Search engines all people to find your listing easily. But allow search engine to find your page , you may reduce amount of visitors to your items.</p><br>
									<p>Note:deactivating search engine capabilities may take a few days to fully take effect</p><br>
                                    <p><input name="search" type="checkbox" value="1" <?php if($allrow['search_engine_status']==1){echo "checked";} ?>/> <span class="color1">Allow search engines to find my profile and listings(recommended). </span></p>
                                </div>
                            </div>
							<div class="wdthpercent100 pT10"> 
                            	<input type="submit" value="submit" name="submit">
                            </div>
                        </div>
						</form>
                    </div>
<?php 
include('../include/footer.php');
?>