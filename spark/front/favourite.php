<?php
$basedir=dirname(__FILE__)."../../";	
include($basedir.'/include/header.php');
if(!isset($_SESSION['user']['id']))
{
	header("location:".$URL_SITE."front/login.php");	// session is not set
}

	
	 $sql=user::selectFavourite($user_id);
	$objPagination=new Ps_Pagination($conn, $sql, 5, 5);
	$exsql=$objPagination->paginate();
	$total_item=mysql_num_rows($exsql);

?>
	

<?php
if($total_item)
{
	?><table width="100%">
<?php
	while($list_data=mysql_fetch_assoc($exsql))
	{
	//print_r($list_data);
	$res=itemClass::select_featured_image($list_data['id']);
	$item_reserve_res=itemClass::to_get_details_of_reserved_item($list_data['id']);
?>		<tr class="mT5">
			<td>


			<img src="<?php echo $URL_SITE;?>/classes/show_image.php?filename=../images/itemimages/<?php echo $list_data['id'].'/'.$res['filename']?>&height=60px&width=100px"?>
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
			<?php ?>
			</td>

			<td>
			<?php ?>
			</td>


			

		<tr>
<?php
	}// while ends............
		?>

		<th colspan="7"><?php echo $objPagination->renderfullnav(); ?></th>

		
</table>
<?php
}

else
{
	echo "There is no item ";
}

?>

