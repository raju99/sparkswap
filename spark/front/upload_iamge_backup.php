<?php
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);
include("../include/actionHeader.php");
?>
<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery-1.4.2.js"></script>

<?php
//unset($_SESSION['image']);
$user_id=$_SESSION['user']['id'];
if(isset($_POST['submit']))
{

$item_id=user::insertItem($user_id);
$item_id=21;
//print_r($_SESSION);
$arr_image=$_SESSION['image'];
$count=0;
foreach($arr_image as $key=>$value)
	{ 
		echo $email_image=$arr_image[0];
	   $file_name=$arr_image[$key];
	
	   $uploaddir=$DOC_ROOT.'/images/itemimages/'.$item_id.'/';

	   @mkdir($uploaddir,0777);

	   $dir1=$uploaddir.'/'.$file_name;

	   $dir2=$DOC_ROOT.'/images/temp/'.$user_id.'/'.$file_name;
	   if($count=='0')
		{
			$pramary='1';
		}
		else
		{
			$pramary='0';
		}

	   if(copy($dir2,$dir1))
		{
		   

		 $result=user::insertItemImage($file_name,$item_id,$pramary);
		 unset($_SESSION['image']);
		 $count++;

		}
	}
	if($item_id>0)
	{
		$receivename=$_SESSION['user']['user_fname'];
		$receivermail=$_SESSION['user']['user_email'];
		$fromname=$from_name;
		$fromemail=$from_email;
		$mailbody='<div class="listingemail"> <div class="popup"><h4 class="fontbld font12">Spark Swap sent this message to ' .$_SESSION['user']['user_fname'].'('.$_SESSION['user']['username'].').</h4>
               <h4 class="font14 fontnormal">Your registered name is included to show this message originated from Spark Swap. <a href="'.$URL_SITE.'"> Learn more. </a> </h4></div><div id="header"><div class="logo"> SparkSwap </div><div class="pL20 left"><h3>Your item has been listed. List another item now!</h3></div></div><div id="container"><div class="pT10 left"><h4 class="font14 fontnormal"> Hi '.$_SESSION['user']['username'].', <br />Your item has been successfully listed on Spark Swap. It may take some time for the item to appear on Spark Swap search results. Here are the listing details: </h4><div class="clear"> </div><div class="listingconfirmpic left"><img src="'.$URL_SITE.'classes/show_image.php?filename=../images/itemimages/'.$item_id.'/'.$email_image.'&height="50"&width="65"" /></div><div class="left mT10 pL10"><h4 class="font14 fontnormal" ><a href="#">'.$_POST['title'].'</a>  <br />Item ID:'.$item_id.'  <br /> Daily Price: $'.$_POST['priceperday'].' <br /><a href="'.$URL_SITE.'/front/viewItem.php?item_id='.$item_id.'"> Revise Item </a> | <a href="'.$URL_SITE.'"> Go to my Spark Swap </a> </h4><div class="mT10"><input class="listingemailbtn" type="button" name="List More" value="List More" /><h5 class="font12 fontitalic fontnormal"> Click to list another item </h5></div></div></div></div></div>';
		$subject='A new item has been added in Spark Swap';
		mail_to_all_user($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject);// sends mail to user who did checked for new items mail function
		// mail to all users who want news of every  item added
			$all_list=user::select_user_for_recent_item_mail();
			while($all_list as $list)
			{   
				if($list['user_id']!=$_SESSION['user']['id'])// we already send
				{
				$receivename=$list['user_fname'];
				$receivermail=$list['user_email'];
				$fromname=$from_name;
				$fromemail=$from_email;
				$mailbody='<div class="listingemail"> <div class="popup"><h4 class="fontbld font12">Spark Swap sent this message to ' .$_SESSION['user']['user_fname'].'('.$list['username'].').</h4>
					   <h4 class="font14 fontnormal">Your registered name is included to show this message originated from Spark Swap. <a href="'.$URL_SITE.'"> Learn more. </a> </h4></div><div id="header"><div class="logo"> SparkSwap </div><div class="pL20 left"><h3>Your item has been listed. List another item now!</h3></div></div><div id="container"><div class="pT10 left"><h4 class="font14 fontnormal"> Hi '.$list['username'].', <br />A New item has been successfully listed on Spark Swap. It may take some time for the item to appear on Spark Swap search results. Here are the listing details: </h4><div class="clear"> </div><div class="listingconfirmpic left"><img src="'.$URL_SITE.'classes/show_image.php?filename=../images/itemimages/'.$item_id.'/'.$email_image.'&height="50"&width="65"" /></div><div class="left mT10 pL10"><h4 class="font14 fontnormal" ><a href="#">'.$_POST['title'].'</a>  <br />Item ID:'.$item_id.'  <br /> Daily Price: $'.$_POST['priceperday'].' <br /><a href="'.$URL_SITE.'/front/viewItem.php?item_id='.$item_id.'"> Revise Item </a> | <a href="'.$URL_SITE.'"> Go to my Spark Swap </a> </h4><div class="mT10"><input class="listingemailbtn" type="button" name="List More" value="List More" /><h5 class="font12 fontitalic fontnormal"> Click to list another item </h5></div></div></div></div></div>';
						$subject='A new item has been added in Spark Swap';
				mail_to_all_user($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject);
			}
			}

	}
   //$_SESSION['MSG']="item is successfully added");
header("Location:".$URL_SITE."front/itemListed.php?item=".$item_id);
}


$msg="";
if(!empty($_FILES['file']['name'])) {

	       $type=$_FILES['file']['type'];
		 
		    $size=$_FILES['file']['size'];
       if($type=="image/jpeg" || $type=="image/png" || $type=="image/gif")
	{
		  
	        $count=count(@$_SESSION['image']);
	
	        
			$filename=basename($_FILES['file']['name']);
			$strpos=strpos($filename,'.');
			$ext=substr($filename,$strpos); 
		    $imagename=uniqid().$ext;
	
			$_SESSION['image'][]=$imagename;
			$arr=$_SESSION['image'];
	if($count<=3)
	{
		    $uploaddir=$DOC_ROOT.'/images/temp/'.$user_id.'/';
			@mkdir($uploaddir,0777);
			$uploaddir3=$uploaddir.'/'.$imagename;	
			move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir3);
	}else{
		$msg="you can not upload more than four images";
	}?>
	
	<?php
			foreach($arr as $key=>$value)
	       {

			
			echo "<li><img src=$URL_SITE/classes/show_image.php?filename=../images/temp/$user_id/$arr[$key]&width=100&height=100/>&nbsp;&nbsp;&nbsp;<a href='#' id=delt_$key>Delete</a></li>";?>
			 <script>
				jQuery(document).ready(function(){
				jQuery("#delt_<?php echo $key;?>").click(function(){	
				var type="<?php echo $key;?>";
			
				jQuery.ajax({
				type: "GET",
				url: "deleteImageItem.php?type="+type,
                
				success: function(msg){
				jQuery("#previewImage").show();
				jQuery("#previewImage").html(msg);
				}
				});
				});
			});
     
	</script>
	
			<?php
	        }

			echo"<br>".$msg;
	//}else{
       //echo "you upload images with maximmum size of 1024.";
	//}
	}else{
		echo "you can only upload jpeg,png,gif images.";
	}
}

?>


<!-- <script>
	$(function() {
		$( "#sortable" ).sortable();
		$( "#sortable" ).disableSelection();
	});
	</script -->

