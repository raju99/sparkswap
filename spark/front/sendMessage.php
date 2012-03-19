
<?php
$basedir=dirname(__FILE__)."../../";	
include $basedir.'include/header.php';
if(isset($_GET['item_id']))
{	$item_id=$_GET['item_id'];
	$user_id =$_GET['user_id'];
	$result =user::selectAllUser($user_id);
	$row=mysql_fetch_assoc($result);
	

}

if(isset($_POST['Submit']))
{

	$result=user::sendMessage($item_id,$user_id);
	$_SESSION['MSG']="MESSAGE IS SUCCESSFULLY SEND TO ".$row['user_email'];
	header("location:viewItem.php?item_id=$item_id");

}

?>

<form name="form1" method="post" id="mailform" action="">
      <table border="0" cellspacing="0" cellpadding="2" width ="100%">
         <tr>
            <td>To:</td>
            <td><input type="text" name="email" value="<?php echo $row['user_email'];?>"></td>
         </tr>
         <tr>
            <td>Subject</td>
            <td><input type="text" class="required" name="subject"></td>
         </tr>
         <tr>
            <td valign="top">Message:</td>
            <td><textarea name="message" class="required " ROWS="6" cols="80"></textarea></td>
         </tr>
         <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit"
               value="Send"></td>
         </tr>
      </table>
   </form>

   <?php 
include("../include/footer.php");
?>
