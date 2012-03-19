<?php
if(isset($_POST['statusfav']))
{
		$basedir=dirname(__FILE__)."../../";	
		include_once($basedir.'/include/actionHeader.php');
	
		$user_id=$_POST['userid'];
		$item_id=$_POST['itemid'];

		if($_POST['statusfav']=='0')
		{
			$status=$_POST['statusfav'];

		}
		else
		{
			$status=$_POST['statusfav'];
		}
		$insertFav=user::FavaratesMakeItem($item_id,$user_id,$status);
									   
	    $checkfav_res=user::CheckFavourite($item_id,$user_id);
	    $iff_fav=mysql_num_rows($checkfav_res);
	   
	    if($iff_fav > 0)
	    {?>			
				<a href="javascript:;" class="fav">favorites</a>		
	    <?
	    }
	    else
	    {?>			
				<a href="javascript:;" class="unfav" onclick="javascript: funMakeFavunFav(1,<?=$item_id?>,<?=$user_id?>);">Favorites</a>			
	    <?
	    }    
}
?>	