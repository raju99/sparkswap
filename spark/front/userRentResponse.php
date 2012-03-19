	<?php
	include('../include/header.php');

	if(!isset($_SESSION['user']))
	{
	header("location:".$URL_SITE."front/login.php");
	}
		if(isset($_GET['item_id']))
		{
			 $item_id=$_GET['item_id'];

			 $id=$_GET['id'];
		}
	
		$rentitemdetail=user::mainDetailOfItem($item_id);


		$featurimage=itemClass::select_featured_image($item_id);	

		$check=itemClass::checkDetail($id);
		if($check['item_status']==1)
		{
			?>
			<table>

	<tr>
	<td>
	<?php echo '' ?>
	</td>
	<td>
	<img class="itemdetailsL" src="<?php echo $URL_SITE ?>/classes/show_image.php?filename=../images/itemimages/<?php echo $item_id ;?>/<?php echo $featurimage['filename'] ;?>&width=163&height=97"/>
	
	</td>


	</tr>
	<tr>
<td>
name
</td>

<td>
<?php echo $rentitemdetail['item_name'] ?>
</td>
<td>
<?php echo $rentitemdetail['item_subtitle'] ?>
</td>


	</tr>
	<tr>
	<td>
	rental detail
	</td>
<td>
<?php echo $rentitemdetail['item_Price'] ?>
</td>
<td>
<?php echo $rentitemdetail['item_deposit'] ?>
</td>

	
	</tr>
	<input type="hidden" value="<?php echo $id ;?>" id="reserveitem_<?php echo $id ;?>"/>

<script>

			function action(sortname)
			{
				var action=sortname;
					var id=$("#reserveitem_<?php echo $id ;?>").val();
					alert(id);
				jQuery.ajax({
				type: "GET",
				url: "checkEmail.php?type="+action+"&reserve_id="+id,

				success: function(msg){

				jQuery("#allitem").html(msg);
				}
				});

			}


		</script>
<tr>
<td>
	<a href="postRental.php?action=booked&item_id=<?php echo $item_id; ?>&id=<?php echo $id ?>"> <input type ="button" onclick="" value="accept" /></a>
</td>

<td>
	<a href="postRental.php?action=deny&item_id=<?php echo $item_id; ?>&id=<?php echo $id ?>"> <input type ="button" onclick="" value="deny" /></a>
</td>
</tr>

	</table>
		
	<?php

		}

		else
		{
		?>
		this item is no longer for rent

		<?php
		}




	?>



