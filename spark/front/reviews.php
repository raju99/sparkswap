<?php
include('../include/header.php');
$userDir="$DOC_ROOT/images/itemimages/";

if(!isset($_SESSION['user']))
{
	header("location:".$URL_SITE."front/login.php");
}
// $review_count=mysql_num_rows($exsql);
// $reviews=mysql_fetch_assoc( $exsql);
?>
<div class="wdthpercent100">
	 <div class="dashwhitebg">				
			<!--Reviews Navigation-->
			<div class="dashprofilereviewsnav">
				<ul>
					<li><a href="?type=reviewabout" class="active" id="reviewaboutyou">Reviews About You</a></li>
					<li><a href="?type=reviewby" id="reviewbyyou">Reviews By You</a></li>
				</ul>
			</div>
			<!--/Reviews Navigation-->

			<?php
			if($_GET['type']=='reviewabout')
			{
				$user_id=$_SESSION['user']['id'];
				$sql=user::reviewaboutYou($user_id);
				$objPagination=new Ps_Pagination($conn, $sql, 5, 5,"type=reviewabout");
				$exsql =$objPagination->paginate();

				if(mysql_num_rows($exsql)>0)
				{?>					
					<div id="reviewabout">
				    <?php 
				    while($row=mysql_fetch_assoc($exsql))
				    {
						$reviewResult=itemClass::averageReview($row['item_id']);
						$user=user:: user_profile($row['user_id'])
						?>
						<div class="wdthpercent100">
						<div class="reviewoverall">
						<h3>Overall</h3>
						<ul class="reviewstarover">
						<?php for($i=1;$i<=$reviewResult['overall'];$i++)
						{
						?>
						<li> <img src="../images/star_2.png" /> </li>
						<?php
						}
						for($j=$i;$j<=5;$j++)
						{
						?>
						<li> <img src="../images/star_gry_2.png" /> </li>
						<?php
						}
						?>

						</ul>
						</div>
						<div class="wdth260 right">
						<div class="right">
						<ul class="reviewstar">
						<li><h3>Accuracy</h3></li>
						<?php for($i=1;$i<=$row['accuracy'];$i++)
						{
						?>
						<li> <img src="../images/star_2.png" /> </li>
						<?php
						}
						for($j=$i;$j<=5;$j++)
						{
						?>
						<li> <img src="../images/star_gry_2.png" /> </li>
						<?php
						}
						?>

						</ul>
						</div>
						<div class="right">
						<ul class="reviewstar">
						<li><h3>Communication</h3></li>
						<?php for($i=1;$i<=$reviewResult['communication'];$i++)
						{
						?>
						<li> <img src="../images/star_2.png" /> </li>
						<?php
						}
						for($j=$i;$j<=5;$j++)
						{
						?>
						<li> <img src="../images/star_gry_2.png" /> </li>
						<?php
						}
						?>

						</ul>
						</div>
						<div class="right">
						<ul class="reviewstar">
						<li><h3>Value</h3></li>
						<?php for($i=1;$i<=$row['rating'];$i++)
						{
						?>
						<li> <img src="../images/star_2.png" /> </li>
						<?php
						}
						for($j=$i;$j<=5;$j++)
						{
						?>
						<li> <img src="../images/star_gry_2.png" /> </li>
						<?php
						}
						?>
						</ul>
						</div>
						</div>
						<br class="clear" />
						</div>
						<div class="wdthpercent100 pT15">
						<!--Left-->
						<div class="profilereviewsL">
						<div class="reviewimgdiv">
						<img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/profile/<?php echo $user['user_picture'];?>&width=95&height=80" />
						<p class="namedis"><?php echo $user['user_fname'] ?></p>
						</div>
						</div>
						<!--/Left-->
						<!--Right-->
						<div class="profilereviewsR">
						<div class="reviewcontentdiv">
						<?php echo 	$row['reviews'] ?>
						</div>
						</div>
						<!--/Right-->
						<br class="clear" />				
			
				<?php
				}
				?>
				<!--/Pagination----------->                      
				<div class="pT20 reviewlisting">
					<ul><li><?php   echo $objPagination->renderFullNav();?></li></ul>
				</div>
				<!--/Pagination----------->
				</div>
			</div>
			<?
			}
			else
			{
				echo "<h3>No Review</h3>";
			}
		}
		?>

		<?php
		if($_GET['type']=='reviewby')
		{
				$user_id=$_SESSION['user']['id'];
				$byyouexsql=user::reviewsByYoupagi($user_id);
				$objPagination=new Ps_Pagination($conn, $byyouexsql, 5, 5,"type=reviewby");
				$newexsql =$objPagination->paginate();
				
				if(mysql_num_rows($newexsql)>0)
				{?>				
				    <div id="reviewby">
					  <?php 
					  while($row=mysql_fetch_assoc($newexsql))
					  {
						$reviewResult=itemClass::averageReview($row['item_id']);
						$user=user:: user_profile($row['user_id'])
						?>
						<div class="wdthpercent100">
						<div class="reviewoverall">
						<h3>Overall</h3>
						<ul class="reviewstarover">
						<?php for($i=1;$i<=$reviewResult['overall'];$i++)
						{
						?>
						<li> <img src="../images/star_2.png" /> </li>
						<?php
						}
						for($j=$i;$j<=5;$j++)
						{
						?>
						<li> <img src="../images/star_gry_2.png" /> </li>
						<?php
						}
						?>

						</ul>
						</div>
						<div class="wdth240 right">
						<div class="right">
						<ul class="reviewstar">
						<li><h3>Accuracy</h3></li>
						<?php for($i=1;$i<=$row['accuracy'];$i++)
						{
						?>
						<li> <img src="../images/star_2.png" /> </li>
						<?php
						}
						for($j=$i;$j<=5;$j++)
						{
						?>
						<li> <img src="../images/star_gry_2.png" /> </li>
						<?php
						}
						?>

						</ul>
						</div>
						<div class="right">
						<ul class="reviewstar">
						<li><h3>Communication</h3></li>
						<?php for($i=1;$i<=$reviewResult['communication'];$i++)
						{
						?>
						<li> <img src="../images/star_2.png" /> </li>
						<?php
						}
						for($j=$i;$j<=5;$j++)
						{
						?>
						<li> <img src="../images/star_gry_2.png" /> </li>
						<?php
						}
						?>

						</ul>
						</div>
						<div class="right">
						<ul class="reviewstar">
						<li><h3>Value</h3></li>
						<?php for($i=1;$i<=$row['rating'];$i++)
						{
						?>
						<li> <img src="../images/star_2.png" /> </li>
						<?php
						}
						for($j=$i;$j<=5;$j++)
						{
						?>
						<li> <img src="../images/star_gry_2.png" /> </li>
						<?php
						}
						?>
						</ul>
						</div>
						</div>
						<br class="clear" />
						</div>
						<div class="wdthpercent100 pT15">
						<!--Left-->
						<div class="profilereviewsL">
						<div class="reviewimgdiv">
						<img src="<?=$URL_SITE?>/classes/show_image.php?filename=../images/profile/<?php echo $user['user_picture'] ;?>&width=95&height=80" />
						<p class="namedis"><?php echo $user['user_fname'] ?></p>
						</div>
						</div>
						<!--/Left-->
						<!--Right-->
						<div class="profilereviewsR">
						<div class="reviewcontentdiv">
						<?php echo 	$row['reviews'] ?>
						</div>
						</div>
						<!--/Right-->
						<br class="clear" />
						</div>			
					<?php
					}
					?>
					<!--/Pagination----------->                      
					<div class="pT20 reviewlisting">
						<ul><li><?php   echo $objPagination->renderFullNav();?></li></ul>
					</div>
					<!--/Pagination----------->
			</div>
			<?
			}
			else
			{
				echo "<h3>No Review</h3>";
			}
		}
		?>				
	</div>                            
</div>	                   
<?php 
include("../include/footer.php");
?>
<script>
	$(document).ready(function(){

$("#reviewabout").show();
$("#reviewby").hide();
$("#reviewaboutyou").click(function(){
$("#reviewabout").show();
$("#reviewby").hide();
$("#reviewaboutyou").addClass("active");
$("#reviewbyyou").removeClass("active");


});

$("#reviewbyyou").click(function(){

$("#reviewabout").hide();
$("#reviewby").show();

$("#reviewaboutyou").addClass("active");
$("#reviewbyyou").removeClass("active");	
				

			});
});
			</script>
