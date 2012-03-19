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
	//echo "<pre>";print_r($_POST);die;
	$address = urlencode($_POST['city'].'+'.$_POST['state'].'+'.$_POST['zip']);
	$url = 'http://maps.google.com/maps/geo?q='.$address.'&output=csv&sensor=false';
	$data = @file_get_contents($url);
	$result = explode(",", $data);

	if($result[0] == '200')
	{
		//echo $result[0]; // status code
		//echo $result[1]; // accuracy
		$latitude = $result[2]; // latitude
		$longitude = $result[3]; // longitude
	}
	else
	{
		$latitude = 0;
		$longitude = 0;
	}

	$item_id=user::insertItem($user_id,$latitude,$longitude);
	//print_r($_SESSION);
	$arr_image=$_SESSION['image'];
	$count=1;
	
	foreach($arr_image as $key=>$value)
	{
		$file_name=$arr_image[$key];
		$uploaddir=$DOC_ROOT.'/images/itemimages/'.$item_id.'/';
		@mkdir($uploaddir,0777);
		$dir1=$uploaddir.'/'.$file_name;
		$dir2=$DOC_ROOT.'/images/temp/'.$user_id.'/'.$file_name;

		if(copy($dir2,$dir1))
		{
			$result=user::insertItemImage($file_name,$item_id,$count);
			unset($_SESSION['image']);
			$count++;

		}

		if($item_id)
		{
		$receivename=$_SESSION['user']['user_fname'];
		$receivermail=$_SESSION['user']['user_email'];
		$fromname=$from_name;
		$fromemail=$from_email;
		$server_address='http://electricitynoida.com/spark';
		//$header=include('../include/emailHeader.php');
		
		$mailbody=' <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>SparkSwap_E_new-Dates_Email_to_Renter</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		</head>

		<body style="margin:0px; padding:0px; font-family: Coolvetica, Arial, Helvetica, sans-serif;font-size:16px;color:#333333; background: #fbfafa url('.$server_address.'/images/bg.png) repeat-x left 30px;">
		   <!--Wrapper-->
			<div style="  width:738px; height:auto; overflow:hidden; margin:auto;">
			 <!--Listing Email-->
			  <div style=" width:auto; height:auto; overflow:hidden;  padding:0px; background:none;">
			
			   <!--POP UP-->
				<!--Header-->
					<div style=" width:100%; height:80px; background:none; margin-top:30px;">
					<!--Logo-->
					 <div style=" background: url('.$server_address.'/images/logo.png) no-repeat top left; padding-right:10px; text-indent:-999em; width:61px; height:79px; float:left; "> SparkSwap </div>
					 <!--/Logo--><div style="padding-left:20px; float:left;">
					 <h3 style="font-size:20px; color:#f38630; line-height:50px; text-decoration:none; text-align:left; font-weight:normal; padding-top:10px;">Your item has been listed. List another item now!</h3>
				 </div>
			  </div>	  
		    <div style="width:100%;height:auto; overflow:hidden; padding-bottom:20px; ">
			 <div style="padding-top:10px; float:left">
			  <p style="font-size:14px; font-weight:normal">'.$_SESSION['user']['username'].', <br />
                       Your item has been successfully listed on Spark Swap. It may take some time for the item to appear on Spark Swap 
                         search results. Here are the listing details: </p>		  
			   <div style="clear:both;"> </div>			  
			            
						  <div style="height:50px; width:65px; border:2px solid #f91200; overflow:hidden; margin:10px 10px 8px 0px; float:left">
						   <img src="'.$server_address.'/images/itemimages/'.$item_id.'/'.$email_image.' height="50" width="65" />
						 </div>
											  
						  <div style="margin-top:10px; padding-left:10px; float:left">			  
						     <!--Addresh-->
						     <p style="font-size:14px; font-weight:normal" >
						     <a style="color: #0000FF; text-decoration: none;" href="'.$server_address.'/front/viewItem.php?item_id='.$item_id.'"> '.$_POST['title'].' </a>  <br />
                                          Item ID:'.$item_id.'  <br />
                                          Daily Price: $'.$_POST['priceperday'].' <br />
                              <a style="color: #0000FF; text-decoration: none;" href="http://electricitynoida.com/spark/front/viewItem.php?item_id='.$item_id.'"> Revise Item </a> | <a style="color: #0000FF; text-decoration: none;" href="'.$server_address.'"> Go to my Spark Swap </a> 
						    </p>
							<div style="margin-top:10px">
							  <input type="button" name="List More" value="List More" style=" background:#a7dbd8; border: 1px solid #cccccc; border-radius: 5px; -moz-border-radius:5px; -webkit-border-radius:5px; color: #666666; cursor: pointer; font-size: 20px;  padding: 5px 20px 5px 20px; text-align: center;"/>							  
							  <p style="font-size:12px; font-style:italic; font-weight:normal"> <a href="'.$server_address.'/front/addItem.php">Click to list another item</a></p>
							</div>				 
					 </div>				 
				 </div>				
			</div>';

			$subject='A new item has been added in Spark Swap';
			mail_to_all_user($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject);// sends mail to user who did checked for new items mail function
		}
	}

	header("location:itemListed.php?item=".$item_id);
}



$msg="";
if(!empty($_FILES['file']['name']))
{
	$type=$_FILES['file']['type'];
	$size=$_FILES['file']['size'];

	if($type=="image/jpeg" || $type=="image/png" || $type=="image/gif" || $type=="image/pjpeg")
	{
		if(isset($_SESSION['image']))
		{
			$count=count(@$_SESSION['image']);
		}
		else
		{
			$count=0;
		}

		$filename=basename($_FILES['file']['name']);
		$strpos=strpos($filename,'.');
		$ext=substr($filename,$strpos); 
		$imagename=uniqid().$ext;
		
		if($count<=3)
		{
			$_SESSION['image'][]=$imagename;
			$uploaddir=$DOC_ROOT.'/images/temp/'.$user_id.'/';
			@mkdir($uploaddir,0777);
			$uploaddir3=$uploaddir.'/'.$imagename;	
			move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir3);
		}
		else
		{
			$msg="you can not upload more than four images";
		}

		$arr=$_SESSION['image'];
		foreach($arr as $key=>$value)
		{			
			echo "<li class='last'><img src=$URL_SITE/classes/show_image.php?filename=../images/temp/$user_id/$arr[$key]&width=53&height=39/><br><a href='javascript:;' id='delt_$key' onclick='javascript:return confirm('Are you sure want ot delete this Image.')'><font size='1' color='blue'>Delete</font></a><input type='hidden' name='image_list[]'></li>";?>
			
			<script>
				jQuery(document).ready(function(){
				jQuery("#delt_<?php echo $key;?>").click(function(){	
				var type="<?php echo $key;?>";
			
				jQuery.ajax({
				type: "GET",
				url: "deleteImageItem.php?type="+type,
				
				success: function(msg)
				{
				jQuery("#previewImage").html(msg);
				}
				});
				});
			});	 
			</script>

		<?php
		}
		echo"<br><br><br><br><br>".$msg;		
	}
	else
	{
		/*if(isset($_SESSION['image']))
		{
			$arr=$_SESSION['image'];
			foreach($arr as $key=>$value)
			{
				echo "<li class='last'><img src=$URL_SITE/classes/show_image.php?filename=../images/temp/$user_id/$arr[$key]&width=53&height=39/><br><br><a href='javascript:;' id=delt_$key>Delete</a><input type='hidden' name='image_list[]'></li>";?>
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
		}*/

		echo "<p class='font10 pL10'>Up to 4  JPEG, GIF or PNG files under 1024 kb.</p>";
	}
}
?>