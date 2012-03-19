<?php
include('../include/header.php');
if(!isset($_SESSION['user']))
{
	header("location:".$URL_SITE."front/login.php");
}
if(isset($_REQUEST['user_id']))
{
	$user_id=$_REQUEST['user_id'];
}
$unread_message=user::unreadMessage($user_id);
$count=mysql_num_rows($unread_message);

?>
<?php
if($count>0)
{
?>
<table align="center" border="1" cellspacing="5">
  <th>Subject</th>
  <th>sender Name</th>
  <th>Date</th>
  <?php
  while($result=(mysql_fetch_assoc($unread_message)))
  {
  ?>
  <tr>
   <td>
    <a href="userRentListing.php?item_id=<?php echo $result['item_id'] ?>&id="<?php echo $result['id']?>><?php echo $result['subject'] ;?></a>
   </td>
  
   <td>
    <?php 
	   $sender_name=user::senderName($result['sender_id']) ;
       echo $sender_name;
      ?>
   </td>
   <td>
    <?php echo $result['date'] ;?>
   </td>
  </tr>
  <?php
  }
  ?>
  </table>
  <?php
}else
{
	  echo "There is No Unread Message";
}
 ?>
 <?php include("../include/footer.php") ?>