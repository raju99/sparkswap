<?php
function mail_to_all_user($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject){	
	echo'asdas';
 $mail=new PHPmailer;//object of mailer function
 $mail->isHTML(true);
 $name= $receivename;
 $emails_to= $receivermail;				
 $mail->FromName = $fromname;
 $mail->From= $fromemail;
 $mail->AddAddress($emails_to,$receivename);
 $mail->Subject  = $subject;
 $mail->Body     = $mailbody;
$mail->WordWrap = 50;
if(!$mail->Send()) 
{
	echo 'Message was not sent.';
	echo 'Mailer error: ' . $mail->ErrorInfo;
	return true;
} else{
	return false;
}
			
}

function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
    {
		$pi80 = M_PI / 180;
		$lat1 *= $pi80;
		$lng1 *= $pi80;
		$lat2 *= $pi80;
		$lng2 *= $pi80;
		 
		$r = 6372.797; // mean radius of Earth in km
		$dlat = $lat2 - $lat1;
		$dlng = $lng2 - $lng1;
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = $r * $c;
		 
		return ($miles ? ($km * 0.621371192) : $km);
    }

function get_current_location($ip)
{
	$host = 'http://www.geoplugin.net/php.gp?ip={'.$ip.'}&base_currency={USD}';
	$location=unserialize(file_get_contents($host));
	$current_location['longitude']=$location['geoplugin_longitude'];
	$current_location['latitude']=$location['geoplugin_latitude'];
	return $current_location;
}

function daysBetweenDate($from, $till) {
/*
 *This function will calculate the difference between two given dates.
 *
 *Please input time by ISO 8601 standards (yyyy-mm-dd).
 *i.e: daysBetweenDate('2009-01-01', '2010-01-01');
 *This will return 365.
 *
 *Author: brian [at] slaapkop [dot] net
 *May 5th 2010
*/
    if($till < $from) {
        trigger_error("The date till is before the date from", E_USER_NOTICE);
        }
       
    //Explode date since gregoriantojd() requires mm, dd, yyyy input;
        $from = explode('-', $from);
        $till = explode('-', $till);

    //Calculate date to Julian Day Count with freshly created array $from.
        $from = gregoriantojd($from[1], $from[2], $from[0])."<br />";
       
    //Calculate date to Julian Day Count with freshly created array $till.
        $till = gregoriantojd($till[1], $till[2], $till[0])."<br />";

    //Substract the days $till (largest number) from $from (smallest number) to get the amount of days
        $days = ($till - $from);
   
    //Return the number of days.
        return $days;

    //Isn't it sad how my comments use more lines than the actual code? 
}

function getDatesBetween2Dates($startTime, $endTime) 
{
    $day = 86400;
    $format = 'Y-m-d';
    $startTime = strtotime($startTime);
    $endTime = strtotime($endTime);
    $numDays = round(($endTime - $startTime) / $day) + 1;
    $days = array();
        
    for ($i = 0; $i < $numDays; $i++) 
	{
        $days[] = date($format, ($startTime + ($i * $day)));
    }
        
    return $days;
}


function get_number_of_days($startTime, $endTime) 
{
    $day = 86400;
    $format = 'Y-m-d';
    $startTime = strtotime($startTime);
    $endTime = strtotime($endTime);
    $numDays = round(($endTime - $startTime) / $day) + 1;           
    return $numDays;
}
?>