<?php
include('../include/header.php');
if(!isset($_SESSION['user']))
{
	header("location:".$URL_SITE."front/login.php");
}
if(isset($_REQUEST['del_id']))
{
	 $del_id=$_REQUEST['del_id'];

	 $item_id=$_REQUEST['item_id'];

     $name=$_REQUEST['name'];

	 $result=user::deleteItemImage($del_id, $item_id,$name);

	 header("location:".$URL_SITE."front/editItem.php?item_id=$item_id");
}


if(isset($_REQUEST['item_id']))
{
    $item_id=$_REQUEST['item_id'];

    $_SESSION['itemid']=$item_id;
}
    $item_result=admin::selectItem($item_id);
  

    $allrow=user::selectItemImages($item_id);

    $image_count=mysql_num_rows($allrow);
?>

<script>
 $(document).ready(function(){
    var thumb = $('img#thumb');
    new AjaxUpload('file', {
		action: $('form#updateItem').attr('action'),
		
		name: 'file',
		onSubmit: function(file, extension) {
			jQuery('#previewImage').hide();
			//thumb.attr('src',"");
			$("#loadingDiv").html("<font color='#898989' size='4'>Loading.......</font>");
		},
		onComplete: function(file, response) {
			thumb.load(function(){
				$('div.preview').removeClass('loading');
				thumb.unbind();
			});
			jQuery('#editImage').hide();
			   jQuery('#previewImage').show();
               $('#previewimage').val(response);
			   response= response.replace(/\&amp;/g,'&');
			   $("#loadingDiv").html("");		  
			   //thumb.attr('src', response);
			  $("#previewImage").html(response);

          }
	});
});
</script>



<div style="float:right;"><a class="txtblue" href="javascript:window.history.go(-1)"><?php echo "BACK";?></a></div>
<form id="updateItem" class="" action="editItemUpload.php" method="POST">

	<table width="100%">
		<tr>
			<td>
			<label>Title</label>
			</td>
			<td>
			<input type="text" class="required" value="<?php echo $item_result['item_name'] ;?>" id="" name ="title"/>
			</td>
		</tr>

		<tr>
			<td>
			<label>Subtitle</label>
			</td>
			<td>
			<input type="text" class="required" value="<?php echo $item_result['item_subtitle'] ;?>" id="" name ="subtitle"/>
			</td>
		</tr>

		<tr>
			<td>
			<label>Description</label>
			</td>
			<td>
			<textarea class="required"  id="" name ="description"/><?php echo $item_result['item_description'] ;?></textarea>
			</td>
		</tr>

		<tr>
			<td>
			<label> Price per Day</label>
			</td>
			<td>
			<input type="text" class="required" value="<?php echo $item_result['item_Price'] ;?>" id=""  name ="priceperday"/>
			</td>
		</tr>

		<tr>
			<td>
			<label> Deposit Amount</label>
			</td>
			<td>
			<input type="text" class="required" value="<?php echo $item_result['item_deposit'] ;?>" id="" name ="depositamount"/>
			</td>
		</tr>

		<tr>
			<td>
			<label> Number Availavel</label>
			</td>
			<td>
			<input type="text" class="required" value="<?php echo $item_result['item_numberavailavel'] ;?>" id="" name ="availavel"/>
			</td>
		</tr>

		<tr id="picture">
			<td>
			<label> Picture of Items</label>
			</td>
			
			<td>
				<input type="file" name="file" id="file" class="file_2"><br>
					<div id="loadingDiv"></div> <br>
					<?php
					 if($image_count>0)
					 {?>
					<div  id="editImage">
					<ul id="image_sort">
					 <?php
					 while($item_images=mysql_fetch_assoc($allrow))
					 {?>
						<li><img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_images['item_id']?>/<?php echo $item_images['filename']?>&width=100&height=100"/>&nbsp;&nbsp;&nbsp;<a href='?item_id=<?=$item_images['item_id']?>&del_id=<?=$item_images['id']?>&name=<?php echo $item_images['filename']; ?>' id="" onclick="javascript:; return confirm('Are you sure want to delete this image.')">Delete</a><input type="hidden" value="<?php echo $item_images['id']?>" name="image_list[]"></li>
                     <?php
					 }
					 ?>
                    
                    </ul>
					</div>
					<?php
					 }
					?>
					 <ul style="display:none" id="previewImage"></ul>
				<input type="hidden" name="previewimage" id="previewimage" value="" />
			</td>
			
		</tr>
	</table>
	<table width="100%">

		<tr>
		<td>
		<label> Phone Number</label>
		</td>
		<td>
		<input type="text" class="" value="<?php echo $item_result['phone'] ;?>" id="" name ="phoneno"/>
		</td>
		</tr>

		<tr>
		<td>
		<label>Address 1</label>
		</td>
		<td>
		<textarea class=""  id="" name ="address1"/><?php echo $item_result['address1'] ;?></textarea>
		</td>
		</tr>

		<tr>
		<td>
		<label>Address 2</label>
		</td>
		<td>
		<textarea class=""  id="" name ="address2"/><?php echo $item_result['address2'] ;?></textarea>
		</td>
		</tr>

		<tr>
		<td>
		<label> City</label>
		</td>
		<td>
		<input type="text" class="" value="<?php echo $item_result['city'] ;?>" id="" name ="city"/>
		</td>
		</tr>

		<tr>
		<td>
		<label> State</label>
		</td>
		<td>
		<input type="text" class="" value="<?php echo $item_result['state'] ;?>" id="" name ="state"/>
		</td>
		</tr>

		<tr>
		<td>
		<label>Zip </label>
		</td>
		<td>
		<input type="text" class="" value="<?php echo $item_result['zip'] ;?>" id="" name ="zip"/>
		</td>
		</tr>





	</table>

	<div align ="center" > <input type="submit"  name ="submit" value="submit"/></div>

</form>

<?php 
include("../include/footer.php");
?>

 <script type="text/javascript">
  
      // when the entire document has loaded, run the code inside this function
 
      $(document).ready(function(){
  
      // Wow! .. One line of code to make the unordered list drag/sortable!
  
      $('#image_sort').sortable();
  
      });
  
      </script>