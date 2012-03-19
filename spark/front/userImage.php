<div align='right'><a href="#"  id='closerppop' ><img src="<?php echo $URL_SITE;?>images/cancel.png"></a></div>
<center><font size='4' color='green'>Upload Image</font></center>
<form action="uploadUserImage.php" method="post" id="userimagefrm" enctype="multipart/form-data">
  <table width="70%">
    <tr>
	  <td>
	    Upload Image:
	  </td>
	  <td> 
	    <input type="file" name="file" id="file">
	  </td>
    <tr>
	  <td>
	    <input type="submit" value="Upload" name="upload" align="center">
	  </td>
	</tr>
	</tr>
  </table>
</form>
<script>
         jQuery('#closerppop').click(function() { 
         jQuery.unblockUI(); 
           return false; 
               }); 
</script>