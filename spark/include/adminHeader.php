<?php 
	ob_start();
	session_start();
	include ('conn.php');
	include($DOC_ROOT.'/classes/adminClass.php');
	include($DOC_ROOT.'/classes/paginationClass.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sparx</title>

<!-- <link type="text/css" href="<?php echo $URL_SITE;?>/css/style.css" rel="stylesheet"/> -->

<link type="text/css" href="<?php echo $URL_SITE;?>/css/themes/base/ui.all.css" rel="stylesheet" />

<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery-1.4.2.js"></script>

<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery.validate.js" language="javascript" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/jquery-validation.js" language="javascript" charset="utf-8"></script>



<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/ui.core.js" language="javascript" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $URL_SITE;?>/js/ui.datepicker.js" language="javascript" charset="utf-8"></script>

<style>

	.succ_msg{
		color: #4F8A10;
		background-color: #DFF2BF;
		padding: 5px;
	}
	.error_msg{
		color: #D8000C;
		background-color: #FFBABA;
		padding: 5px;
	}
	</style>
</head>
<body>
<?php
if(isset($_SESSION['error_msg'])){
	echo "<div class='error_msg'>".$_SESSION['error_msg']."</div>";
	unset($_SESSION['error_msg']);
}

if(isset($_SESSION['succ_msg'])){
	echo "<div class='succ_msg'>".$_SESSION['succ_msg']."</div>";
	unset($_SESSION['succ_msg']);
}



	if(isset($_SESSION['a_info']['id']))
	{
		
	?>

		<h2>Spark</h2>
      <div style="float:right">
     <a  href="<?php echo $URL_SITE; ?>admin/logout.php">logout</a>|<a  href="javascript:(history.go(-1));">Back</a></div>
		<a class="left"  href="home.php">Home</a>|<a class="left" href="itemManagement.php">Manage Item</a><br>



	<?php
	
	}
?>