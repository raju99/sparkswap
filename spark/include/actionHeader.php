<?php 
ob_start();
session_start();
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);
include_once('conn.php');
include_once($DOC_ROOT.'/classes/userClass.php');
include_once($DOC_ROOT.'/classes/inboxClass.php');
include_once($DOC_ROOT.'/classes/adminClass.php');
include_once($DOC_ROOT.'/classes/mailerClass.php');
include_once($DOC_ROOT.'/classes/itemClass.php');
include_once($DOC_ROOT.'/classes/paginationClass.php');
include_once($DOC_ROOT.'/classes/paginationArray.php');
include_once('functions.php');
?>