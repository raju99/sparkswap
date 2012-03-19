<?php
// FIle is used to set setting for social connected or not.... :-D
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);
$base=dirname(__FILE__).'../../';
include($base.'include/actionHeader.php');
if(isset($_GET['type']))
{
	if($_GET['type']=='twitter')
	{
		if($_GET['connected']=true)	// user is connected with twitter
		{
			user::conncetivity('twitter_status',1);// parameters fieldname, value
		}
		
	}
	elseif($_GET['type']=='linkedin')
	{
		if($_GET['connected']=true)	// user is connected with twitter
		{
			$return=user::conncetivity('linkedin_status',1);// parameters fieldname, value
			if($return)
			{
				echo '<tr>
							<td class="bdrbtmgrey" height="40">
								<p class="verifiedtxt">Linkedln Connected</p>
							</td>
							<td class="bdrbtmgrey" height="40"><a href="javascript:;">Connected</a></td>
					  </tr>   ';
			}
		}
		
	}

	elseif($_GET['type']=='facebook')
	{
		if($_GET['connected']=true)	// user is connected with twitter
		{
			$return=user::conncetivity('facebook_status',1);// parameters fieldname, value
			if($return)
			{
				echo '
					
						<td width="75%" height="40" class="bdrbtmgrey">
							<p class="verifiedtxt">Facebook Connected</p>
						</td>
						<td height="40" class="bdrbtmgrey"><a href="javascript:;">Connected</a></td>
					';
			}
		}
		
	}
	
}

?>