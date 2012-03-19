<?php
$basedir=dirname(__FILE__)."../../";	
include $basedir.'include/header.php';
$item_id=$_GET['item_id'];
if(isset($_POST['submit']))
{

$comment=$_POST['comment'];
$service=$_POST['ratng'];
$rating=$_POST['ratng1'];
$delivery=$_POST['ratng2'];
$result=user::insertfeedback($user_id,$item_id);
if($result)
	{
		$_SESSION['msg']=20;
		header('location:'.$URL_SITE.'front/viewItem.php?item_id='.$item_id);
	}
}

?>

<form action="" method="post" id="feedbackform">
					
						<table width="100%" cellpadding="0" cellspacing="0" border="0" class="pT10">
						<tbody>
						<tr><td class="pB10" width="70">Service</td><td class="pB10" width="440">
						<center>
						<select name="ratng">
						<?php
						for($i=1;$i<=5;$i++)
						{
							?>
							<option value=<?php echo $i ;?>><?php echo $i ;?></option>
							<?php
						}
						?>
						</select>
						</center>
						<!-- <div class="left ">

							<div class="Clear" id="srvrating">
							
							<input class="star required" type="radio" name="ratng" value="1.0" />
							
							<input class="star" type="radio" name="ratng" value="2.0"/>
							
							<input class="star" type="radio" name="ratng" value="3.0"/>
							
							<input class="star" type="radio" name="ratng" value="4.0"/>
						
							<input class="star" type="radio" name="ratng" value="5.0"/>
							</div>
						</div> -->
						</td></tr>
						<tr><td class="pB10" width="70">Rating</td>
						<td class="pB10" width="440">
					
<center>
						<select name="ratng1">
						<?php
						for($i=1;$i<=5;$i++)
						{
							?>
							<option value=<?php echo $i ;?>><?php echo $i ;?></option>
							<?php
						}
						?>
						</select>
						</center>

							
						</td></tr>
						<tr><td class="pB10" width="70">Delivery</td><td class="pB10" width="440">
<center>
						<select name="ratng2">
						<?php
						for($i=1;$i<=5;$i++)
						{
							?>
							<option value=<?php echo $i ;?>><?php echo $i ;?></option>
							<?php
						}
						?>
						</select>
						</center>

							
							</td></tr>
						<tr>
						
						<td class="pB10">Comment</td>
						<td class="pB10"><textarea class="wdth439 txtinput" rows="6" name="comment"></textarea></td>
						</tr>
						<tr>
						<input name="item" value="<?php echo $item_id?>" type="hidden">
							<td><input type="submit" value="submit" name="submit" class="submit"/></td>
						</tr>
						</tbody>
				</table>

			</form>

			<?php
include $basedir.'include/footer.php';
?>