<?php
include("../include/application.php");


if(isset($_POST['submit']))
{
	
   
      // use $i to increment the weight
	  $item_id=$_SESSION['itemid'];
	  $result=user::updateItem($item_id);
      // loop through post array in the order it was submitted
      // update the row
       $result = user::featureImage();
	   $_SESSION['msg']=5;
      unset($_SESSION['itemid']);
      header("location:mySwaps.php?type=listing");
}

$msg="";

if(!empty($_FILES['file']['name'])) {
           $item_id=$_SESSION['itemid'];
	       $type=$_FILES['file']['type'];
		 $allrow=user::selectItemImages($item_id);
		 $count=mysql_num_rows( $allrow);
		    $size=$_FILES['file']['size'];
       if($type=="image/jpeg" || $type=="image/png" || $type=="image/gif" || $type=="image/pjpeg")
	{
		  // if($size<='1024')
		//{
			
	
	        
			$filename=basename($_FILES['file']['name']);
			$strpos=strpos($filename,'.');
			$ext=substr($filename,$strpos); 
		    $imagename=uniqid().$ext;
	
			//$_SESSION['image'][]=$imagename;
			//$arr=$_SESSION['image'];
	if($count<4)
	{
		    $uploaddir=$DOC_ROOT.'/images/itemimages/'.$item_id.'/';
			@mkdir($uploaddir,0777);
			$uploaddir3=$uploaddir.'/'.$imagename;	
		if(move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir3))
		{
			 $result=user::insertItemImage($imagename,$item_id);
		}
	}else{
		$msg="you can not upload more than four images";
	}
		$allrow=user::selectItemImages($item_id);
	        

		while($item_images=mysql_fetch_assoc($allrow))
	       {?>

			
			<li><img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_images['item_id']?>/<?php echo $item_images['filename']?>&width=100&height=100"/>&nbsp;&nbsp;&nbsp;<a href='?item_id=<?=$item_images['item_id']?>&del_id=<?=$item_images['id']?>' id="" onclick="javascript:; return confirm('Are you sure want to delete this image.')">Delete</a><input type="hidden" value="<?php echo $item_images['id']?>"name="image_list[]"></li>
	<?php
			
	        }

			echo"<br>".$msg;
	//}else{
       //echo "you upload images with maximmum size of 1024.";
	//}
	}else{
		$allrow=user::selectItemImages($item_id);
	        
         $image_count=mysql_num_rows($allrow);
		 if($image_count>0)
		{

		while($item_images=mysql_fetch_assoc($allrow))
	       {?>

			
			<li><img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_images['item_id']?>/<?php echo $item_images['filename']?>&width=100&height=100"/>&nbsp;&nbsp;&nbsp;<a href='?item_id=<?=$item_images['item_id']?>&del_id=<?=$item_images['id']?>' id="">Delete</a><input type="hidden" value="<?php echo $item_images['id']?>"name="image_list[]"></li>
			<?php
		   }
		}
		echo "you can only upload jpeg,png,gif images.";
	}
}

?>
<script type="text/javascript">
  
      // when the entire document has loaded, run the code inside this function
 
      $(document).ready(function(){
  
      // Wow! .. One line of code to make the unordered list drag/sortable!
  
      $('#previewImage').sortable();
  
      });
  
      </script>
<!-- <script>
	$(function() {
		$( "#sortable" ).sortable();
		$( "#sortable" ).disableSelection();
	});
	</script -->
