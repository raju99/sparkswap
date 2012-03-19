<?php
class inbox 
{
	function select_messages_for_dashboard($user_id)	// fetch only 4 record to show in dashboard
	{
		 $sql="select * from inbox where receiver_id='".$user_id."' order by msg_id DESC limit 4";
		return mysql_query($sql);
	}

	// fetch  record to show all not read messages

	function select_unread_messages_for_user($user_id)	
	{
		 $sql="select * from inbox where receiver_id='".$user_id."' and read_status=0 order by msg_id DESC";
		return mysql_query($sql);
	}

	// function to select a message from its id
	function select_msg_by_id($id)
	{
		$sql="select * from inbox where msg_id='".$id."'";
		return $res=mysql_query($sql);
		
	}

	function select_msg_by_id_senser_rec($sender,$receiver,$itemcode)
	{
		$sql="select * from inbox where sender_id='".$sender."' and receiver_id='".$receiver."' and item_id=".$itemcode."";
		return $res=mysql_query($sql);
		
	}

	function update_msg_status($name_of_field,$msg_id,$status)
	{
	    $sql='update inbox SET '.$name_of_field.'='.$status.' where msg_id='.$msg_id.'';
		$update=mysql_query($sql);
		

	}

	function select_msg_according_filter($user_id,$filter_string)	// to fetch data according to filter
	{
		$sql='select * from inbox where receiver_id='.$user_id.' '.$filter_string.' order by msg_id Desc';
		return $sql;
	}

	function select_all_messages($user)
	{
		 $sql='select * from inbox  where receiver_id='.$user;
		return mysql_query($sql);
	}

	function insert_notification($renter,$msg,$startdate,$enddate,$msg_id)
	{
		
		if($startdate=='')
		{
			$startdate=0000-00-00;
			$enddate=0000-00-00;
		}
		  $sql="insert into notifications set message_id='".$msg_id."', sender_id='".$_SESSION['user']['id']."' ,receiver_id='".$renter."' ,message='".$msg."' , startdate='".$startdate."', enddate='".$enddate."', created=now()";
		$res=mysql_query($sql);
		return mysql_insert_id();
	}

	function select_notification($msg_id)
	{
		$sql="select * from notifications where message_id='".$msg_id."'";
		$res=mysql_query($sql);
		return mysql_fetch_assoc($res);
	}

}


?>