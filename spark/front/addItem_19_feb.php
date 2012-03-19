<?php
include('../include/header.php');
$userDir="$DOC_ROOT/images/itemimages/";

if(!isset($_SESSION['user']))
{
	header("location:".$URL_SITE."front/login.php");
}
unset($_SESSION['image']);
?>
<script>
 $(document).ready(function(){
    var thumb = $('img#thumb');
    new AjaxUpload('file', {
		action: $('form#addItem').attr('action'),
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

<div style="float:right;">
	<a class="txtblue" href="javascript:window.history.go(-1)"><?php echo "BACK";?></a>
</div>

<div class="">
   <form action="uploadImage.php" method="POST" id="addItem" name="addItem" enctype="multipart/form-data">
	 <table width="100%">
		<tr>
			<td>
			<label>Title</label>
			</td>
			<td>
			<input type="text" class="required" value="" id="" name ="title"/>
			</td>
		</tr>

		<tr>
			<td>
			<label>Subtitle</label>
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
			<textarea class="required" id="" name ="description"/></textarea>
			</td>
		</tr>

		<tr>
			<td>
			<label>Price per Day</label>
			</td>
			<td>
			<input type="text" class="required number" value="" id=""  name ="priceperday"/>
			</td>
			<td>
			  USD
			</td>
		</tr>

		<tr>
			<td>
			<label>Deposit Amount</label>
			</td>
			<td>
			<input type="text" class="required number" value="" id="" name ="depositamount"/>
			</td>
			<td>
			  USD
			</td>
		</tr>

		<tr>
			<td>
			<label>Number Availabel</label>
			</td>
			<td>
			<input type="text" class="required" value="" id="" name ="availavel"/>
			</td>
		</tr>

		<tr id="picture">
			<td>
			<label>Picture of Items</label>
			</td>
			
			<td>
				
				<input type="file" name="file" id="file" class="file_2"><br>
				   
					<div id="loadingDiv"></div> <br>
					 <ul style="display:none" id="previewImage"></ul>
				<input type="hidden" name="previewimage" id="previewimage" value="" />
				
			</td>
			
		</tr>
		
		<input type="hidden" value='0' id="hidden"/>
	
		<tr>
			<td>
			<label>Phone Number</label>
			</td>
			<td>
			<input type="text" class="required number" value="" id="" name ="phoneno"/>
			</td>
		</tr>

		<tr>
			<td>
			<label>Address 1</label>
			</td>
			<td>
			<textarea class="required" id="" name ="address1"/></textarea>
			</td>
		</tr>

		<tr>
			<td>
			<label>Address 2</label>
			</td>
			<td>
			<textarea class="required" id="" name ="address2"/></textarea>
			</td>
		</tr>

		<tr>
			<td>
			<label>City</label>
			</td>
			<td>
			<input type="text" class="required" value="" id="" name ="city"/>
			</td>
		</tr>

		<tr>
			<td>
			<label>State</label>
			</td>
			<td>
			<input type="text" class="required" value="" id="" name ="state"/>
			</td>
		</tr>

		<tr>
			<td><label>Zip </label></td>
			<td><input type="text" class="required number" value="" id="" name ="zip"/></td>
		</tr>

		<tr>
			<td><label>manage Product</td>
			<td><input type="checkbox" class="" value="1" id="" name ="pickup"/>&nbsp;Pickup&nbsp;&nbsp;&nbsp;<span class="font11">Done by Renter</span> <br>
			<input type="checkbox" class="" value="1" id="" name ="dropoff"/>&nbsp;Dropoff&nbsp;&nbsp;&nbsp;<span class="font11">Done by Renter</span></td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name ="submit" value="submit"/></td>
		</tr>
	</table>
</form>
</div>

<script type="text/javascript">
  
      // when the entire document has loaded, run the code inside this function
 
      $(document).ready(function(){
  
      // Wow! .. One line of code to make the unordered list drag/sortable!
  
      $('#previewImage').sortable();
  
      });
  
</script>

<?php 
include("../include/footer.php");
?>