<?php
include('../include/header.php');
$userDir="$DOC_ROOT/images/itemimages/";
if(!isset($_SESSION['user']))
{
	header("location:".$URL_SITE."front/login.php");
}

if(isset($_POST['submit']))
{
	
$id=user::insertItem($user_id);
if(isset($id))
	{
	 $userDir=$userDir.$id.'/';
	mkdir($userDir,0777);
	

		$_SESSION['MSG']="new Item has successfully ADDED";
if(isset($_FILES["image"]))
	    { 
	
		foreach($_FILES['image']['name'] as $key=>$value)
				{
			
					  $file_name =$_FILES['image']['name'][$key];
					$randomDigit=rand(0000,99999);
					 $file_name=$randomDigit.$file_name;
					 

					
					  $file_tmp = $_FILES["image"]["tmp_name"][$key];	
					
					if(move_uploaded_file($file_tmp,$userDir.$file_name))	
					{
						
					$result=user::insertItemImage($file_name,$id);
					$_SESSION['MSG']="new Item and corresponding photo are successfully updated";
					
				
					}
					else
					{
					

					}
				}

		}
	header("Location:itemUserManagement.php");
	}
	header("Location:itemUserManagement.php");

}






?>
<script>
$(document).ready(function(){
    var thumb = $('img#thumb');
    new AjaxUpload('file', {
		action: $('form#addItem').attr('action'),
		name: 'image',
		onSubmit: function(file, extension) {
			jQuery('#previewImage').hide();
			thumb.attr('src',"");
			$("#loadingDiv").html("<font color='#898989' size='4'>Loading.......</font>");
		},
		onComplete: function(file, response) {
			thumb.load(function(){
				$('div.preview').removeClass('loading');
				thumb.unbind();
			});
			   jQuery('#previewImage').show();
               $('#previewimage').val(response);
			   response= response.replace(/\&amp;/g,'&');
			   $("#loadingDiv").html("<font color='red' size='4'>File Successfully Uploaded</font>");		  
			   thumb.attr('src', response);

          }
	});
});
</script>
<div style="float:right;"><a class="txtblue" href="javascript:window.history.go(-1)"><?php echo "BACK";?></a></div>
<form id="addItem" class="" action="" method="POST" enctype="multipart/form-data" >

	<table width="100%">
		<tr>
			<td>
			<label> title</label>
			</td>
			<td>
			<input type="text" class="required" value="" id="" name ="title"/>
			</td>
		</tr>

		<tr>
			<td>
			<label>Sub title</label>
			</td>
			<td>
			<input type="text" class="required" value="" id="" name ="subtitle"/>
			</td>
		</tr>

		<tr>
			<td>
			<label>Description</label>
			</td>
			<td>
			<input type="text" class="required" value="" id="" name ="description"/>
			</td>
		</tr>

		<tr>
			<td>
			<label> Price per Day</label>
			</td>
			<td>
			<input type="text" class="required" value="" id=""  name ="priceperday"/>
			</td>
		</tr>

		<tr>
			<td>
			<label> Deposit Amount</label>
			</td>
			<td>
			<input type="text" class="required" value="" id="" name ="depositamount"/>
			</td>
		</tr>

		<tr>
			<td>
			<label> Number Availavel</label>
			</td>
			<td>
			<input type="text" class="required" value="" id="" name ="availavel"/>
			</td>
		</tr>

		<tr id="picture">
			<td>
			<label> Picture of Items</label>
			</td>
			
			<td>
				<input type="file" class="required" value="" id="" name ="image"/>
				<div id="loadingDiv"></div>
			</td>
			<!-- <td>
				<input type="checkbox" class="" value="" id="primary" name ="primary" checked/>make primary
				
			</td> -->
			<!-- <td class="none"  id="removeClone">
				remove
					
			</td> -->
		</tr>
		<tr style="display:none" id="previewImage">
		  <img id="thumb" src=""/>
		  <input type="hidden" name="previewimage" id="previewimage" value="" />
		</tr>
		<input type="hidden" value='0' id="hidden"/>
		<!-- <tr id="addanotther">
			<td>
			</td>
			<td id="check">addanotther</td>
		</tr> -->


		


		

	</table>

	<div align= "center" >
	</div>

	<table width="100%">

		<tr>
		<td>
		<label> phone no</label>
		</td>
		<td>
		<input type="text" class="" value="" id="" name ="phoneno"/>
		</td>
		</tr>

		<tr>
		<td>
		<label>address1</label>
		</td>
		<td>
		<input type="text" class="" value="" id="" name ="address1"/>
		</td>
		</tr>

		<tr>
		<td>
		<label>address2</label>
		</td>
		<td>
		<input type="text" class="" value="" id="" name ="address2"/>
		</td>
		</tr>

		<tr>
		<td>
		<label> city</label>
		</td>
		<td>
		<input type="text" class="" value="" id="" name ="city"/>
		</td>
		</tr>

		<tr>
		<td>
		<label> state</label>
		</td>
		<td>
		<input type="text" class="" value="" id="" name ="state"/>
		</td>
		</tr>

		<tr>
		<td>
		<label>Zip </label>
		</td>
		<td>
		<input type="text" class="" value="" id="" name ="zip"/>
		</td>
		</tr>





	</table>

	<div align ="center" > <input type="submit"  name ="submit" value="submit"/></div>

</form>


<!-- <script>
$(document).ready(function(){
	    
           
			jQuery('#counterAllergy').val(counterAllergy);
		     $("#check").click(function(){
			j=Number(jQuery("#hidden").val());
			var hidden = jQuery('#hidden').val();
             alert(hidden);
			hidden = parseInt(hidden)+1;
			if(j<4)
			{
			container =jQuery('#addItem');

			var  template=jQuery("#picture").clone(true).insertBefore(jQuery("#addanotther"));
			template.find("#removeClone").removeClass("none");
			
			
			j++;
			jQuery("#hidden").val(j);
		

		template.find("input:file").each(function(){
		
					   jQuery(this).val("");
					  
					   
				  });
		template.find("input[name^=primary]").each(function(){
				jQuery(this).removeAttr('checked');
				jQuery(this).attr('name','primary['+hidden+']');
			});

			}
			else
			{
				alert("only four image are include for item");
			}

		
				  });
					  jQuery("#removeClone").click(function(){
						j=jQuery("#hidden").val();
						j--;
						jQuery("#hidden").val(j);

					   jQuery(this).parent().remove();
				  });



});

</script>
 -->