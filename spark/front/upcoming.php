<?php
$res=itemClass::to_get_detail_upcoming_items_for_user($user_id);
if(mysql_num_rows($res)>0)
{
	while($list_data=mysql_fetch_assoc($res))
	{
?>
<tr class="mT5">
	<td>

	<img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/itemimages/<?php echo $list_data['id'].'/'.$res['filename'];?>&height=60px&width=100px"?>
	</td>


	<td>
	<?php echo 'Posted: '.date('d/m/Y',strtotime($list_data['created_on']));
	?>
	</td>


	<td>
	<?php	 echo $list_data['item_name'].'<br/>" '.$list_data['item_subtitle'].' "'.$list_data['item_description'];
	?>
	</td>

	<td>
	<a href="<?php echo $URL_SITE;?>/front/editItem.php?item_id=<?php echo $list_data['id']?>">Edit</a>
	</td>

<tr>

<?php
	}//while ends
}
else
{
	echo 'No upcoming rentals';
}

?>

<form action="searchListing.php" method="POST" id="">
	
	
		<input type="text" value="What do you need?" onblur="if(this.value==''){this.value='What do you need?'}" onclick="if(this.value=='What do you need?'){this.value=''}" name="word" class="need">
		<div class="">
			<input type="text" value="Zip code" onblur="if(this.value==''){this.value='Zip code'}" onclick="if(this.value=='Zip code'){this.value=''}" name="zip" class="zip mR20 ">
			<input type="submit" value="search " name="search" class="search">
		

		<b class="left">  Pick up </b>
		<input type="text" id="pickup" value="mm/dd/yyyy" onblur="if(this.value==''){this.value='mm/dd/yyyy'}" onclick="if(this.value=='mm/dd/yyyy'){this.value=''}" name="Pickup" class="date hasDatepicker">
	
		<b class="left">  Drop off </b>
		<input type="text" id="dropoff" value="mm/dd/yyyy" onblur="if(this.value==''){this.value='mm/dd/yyyy'}" onclick="if(this.value=='mm/dd/yyyy'){this.value=''}" name="Dropoff" class="date hasDatepicker">

</form>