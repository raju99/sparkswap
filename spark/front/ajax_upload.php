<?php
include('../include/header.php');
?>
<script>
 $(document).ready(function(){
    var thumb = $('img#thumb');
    new AjaxUpload('file', {
		action: $('form#editArtWorkform').attr('action'),
		name: 'file',
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

 <!-- <form action="uploadImage.php" method="POST" id="editArtWorkform" name="editArtWorkform" enctype="multipart/form-data">
            <input type="file" name="file" id="file" class="file_2">
					<div id="loadingDiv"></div>
 
			   <p style="display:none" id="previewImage"><img id="thumb" src=""/>
				<input type="hidden" name="previewimage" id="previewimage" value="" /></p>
				
			</form> -->
			 <form action="uploadImage.php" method="POST" id="editArtWorkform" name="editArtWorkform" enctype="multipart/form-data">
     

			 <!-- this div is to add art work -->
			
			 
				<input type="file" name="file" id="file" class="file_2">
					<div id="loadingDiv"></div> 
			<div class="upload_artwork_image_area">
	
			   <p style="display:none" id="previewImage"><img id="thumb" src=""/>
				<input type="hidden" name="previewimage" id="previewimage" value="" /></p>
				
            </div>
         
		
		 </form>