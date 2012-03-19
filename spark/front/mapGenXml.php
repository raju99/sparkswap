<?php
session_start();
include("../include/conn.php");
//----------------------------------------------------//

include($DOC_ROOT.'/classes/userClass.php');

//-------------function to parse strings to xml-----------// 
function parseToXML($htmlStr) 
{ 
  $xmlStr=str_replace('<','&lt;',$htmlStr); 
  $xmlStr=str_replace('>','&gt;',$xmlStr); 
  $xmlStr=str_replace('"','&quot;',$xmlStr); 
  $xmlStr=str_replace("'",'&#39;',$xmlStr); 
  $xmlStr=str_replace("&",'&amp;',$xmlStr); 
  return $xmlStr; 
}

//Start XML file, echo parent node
header("Content-type: text/xml");
echo "<?xml version='1.0' encoding='ISO-8859-1'?>";
echo "<markers>\n";
$sql=user::searchAll();
$resource1 = mysql_query($sql);
while(@$row=mysql_fetch_assoc($resource1))
{	//-------------------selects users friends address--------------//

	$address = $row['address1']. " ".$row['address2']. ", ". $row['city']. ", ".$row['state'];
	echo '<marker ';
	echo 'address="' .parseToXML($address).'" ';
	echo 'name="' .parseToXML($row['item_name']).'" ';
	echo 'lat="' .parseToXML($row['latitude']).'" ';
	echo 'lng="' .parseToXML($row['longitude']).'"';
	echo "/>";
}



	 //--------------select user address ends---------------------//
 // End XML file*/
echo "</markers>\n";
?>