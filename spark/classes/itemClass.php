<?php
 
class itemClass
{
	function fetch($res)
	{
		$data=mysql_fetch_assoc($res);
		return $data;
	}

	//function to count array
	function fetch_count($res)
	{
		$count=mysql_num_rows($res);
		return $count;
	}	
		
	function select_featured_image($item_id)	// to get fetured image for an item
	{
		$sql='select * from itemimages where item_id='.$item_id.' and feature=1';
		$res=mysql_query($sql);
		return mysql_fetch_assoc($res);
	}

	function selectUsersItems($item)
	{
		 $sql="select * from user_items where id='".$item."'";
		 $res=mysql_query($sql);
		 return $res;
	}


	function countReview($item_id)
	{
		$sql="select * from reviews where item_id='".$item_id."'";
		$res=mysql_query($sql);
		if(mysql_num_rows($res) >0)
		{
			return mysql_num_rows($res);
		}
		else
		{return 0;
		}

	}

	function select_reviews($item_id)
	{
		$sql="select * from reviews where item_id='".$item_id."'";
		$res=mysql_query($sql);
		return $res;
	}

	function averageReview($item_id)
	{
		$sql= "SELECT count( reviews.item_id ) , round( avg( accuracy ) ) AS accuracy,
		round( avg( rating ) ) AS rating,round( avg( communication ) ) AS communication,
		round(avg((communication+rating+ accuracy)/3)) as overall
		FROM reviews
		WHERE item_id ='".$item_id."'";
		$result=mysql_query($sql);
		$row=mysql_fetch_assoc($result);
		return $row;

	}


	function viewReview($item_id)
	{

		$sql="select * from reviews where item_id='".$item_id."'";
		return $sql;
	}
	
	function allReviewOfItem($item_id)
	{
		 $sql="SELECT u.user_fname, u.user_email, u.user_picture, u.id, u.user_city, u.user_state, u.user_zip, rev.reviews, rev.accuracy, rev.communication, rev.rating, rev.user_id
		FROM reviews AS rev, user u
		WHERE rev.user_id = u.id
		AND rev.item_id ='".$item_id."'";
		return $sql;

	}

	function to_get_details_of_reserved_item($item)	// detail of one item from user_reservations table
	{
		$sql="select * from user_reservations where item_status=1 and item_id='".$item."'";
		return mysql_query($sql);
	}

	function to_get_details_of_upcoming_reserved_item($item)//detail of upcoming item from user_reservations table
	{
		  $sql="select * from user_reservations where item_id='".$item."' and item_status=1 and issue_date>now()";
		$res=mysql_query($sql);
		return $res;
	}
	function setRentRequest($item_id,$owner,$picdate,$dropdate)
	{
		
		$date1=itemClass::ChangeDate($picdate);
		$date2=itemClass::ChangeDate($dropdate);
		$message=$_POST['comment'];
		
		 $sql= "insert into user_reservations set issue_date='".$date1."',end_date='".$date2."',item_id='".$item_id."', user_id='".$_SESSION['user']['id']."',item_status='0',owner_id='".$owner."' ";
		$result=mysql_query($sql) or die(mysql_error());
		$requestid=mysql_insert_id();

		$sql="insert into inbox  set receiver_id='".$owner."',subject='rent request',content='".$message."',item_id='".$item_id."',sender_id='".@$_SESSION['user']['id']."',date=now(),reservation_id='".$requestid."',read_status='0'";
		$result=mysql_query($sql) or die(mysql_error());
		return $result;
	}

	function ChangeDate($date)
	{
		$date_array=explode('-',$date);
		@$new_date=$date_array['2']."-".$date_array['1']."-".$date_array['0'];
		return $new_date;
	}

	function to_get_detail_upcoming_items_for_user($user)	// to get details of upcoming resrved items 
	{
		$date=date('Y-d-m');
		$sql="select * from user_reservations where user_id='".$user."' and item_status=1 and issue_date>'".$date."'";
		return mysql_query($sql);
	}

	function to_get_all_rent_items_for_user($user)	// to get all rental i have 
	{
		
		 $sql="select * from user_reservations where user_id='".$user."' and item_status=1";
		return mysql_query($sql);
	}


	function listingOfRentItem($user_id)
	{
		$sql="select * from user_reservations where owner_id='".$_SESSION['user']['id']."' and item_status='0'";
		return $sql;

	}

	function checkDetail($id)
	{
		$sql="select  * from  user_reservations where id='".$id."'";
		$result=mysql_query($sql);
		$status=mysql_fetch_assoc($result);
		return $status;

	}

	function rentitemDeatail($item_id)
	{
			 $sql="SELECT newtable.item_id AS item_id, newtable.item_description, newtable.item_name, newtable.item_subtitle, newtable.owner_id, newtable.item_Price, newtable.item_name, newtable.item_deposit, newtable.item_numberavailavel, newtable.phone, newtable.address2, newtable.address1, newtable.zip, newtable.state, newtable.created_on, newtable.city, user.id, user.user_fname, user.user_email, user.user_city, user.user_zip, user.user_state,user.user_picture FROM user INNER JOIN 

			( SELECT item.id  AS     item_id,    item_description ,   item_subtitle,   item.owner_id, item.item_Price,     item.item_name,       item.item_deposit ,    item.item_numberavailavel, item.phone, item.address2, item.address1, item.zip, item.state, item.created_on, item.city, itemimages.filename FROM user_items as item, itemimages where itemimages.item_id=item.id and itemimages.feature='1' and item.id='".$item_id."' ) AS newtable on (newtable.owner_id = user.id and newtable.item_id='".$item_id."' )
			) ";

			$result=mysql_query($sql);
			return $result;
	}

	function userRentresponse()
	{
		$sql="select * from user_reservations where user_id='".$_SESSION['user']['id']."' and item_status='1'";
		return $sql;

	}

	function to_get_detail_previous_items_for_user($user)	// to get details of upcoming resrved items 
	{
		$date=date('Y-m-d');
		 $sql="select * from user_reservations where user_id='".$user."' and item_status!=2 and end_date<'".$date."'";
		return mysql_query($sql);
	}

	function users_who_rest_item($item)
	{
		 $sql="select * from user_reservations where item_id='".$item." and item_status=1'";
		return mysql_query($sql);
	}

	function select_latest_item()    //select latest item to show in front
	{
		 $sql="select ut.*,u.username, u.user_fname from user_items ut, user u where u.id=ut.owner_id order by id desc limit 1";
		$res=mysql_query($sql);
		return mysql_fetch_assoc($res);
	}

	function renter_praposal_date($item,$renter_id)
	{
		$date=date('Y-m-d');
		 $sql="select * from user_reservations where item_id='".$item."' and user_id='".$renter_id."' and issue_date>'".$date."' and item_status=0 ";
		$res=mysql_query($sql);
		return mysql_fetch_assoc($res);
	}

	function collect_booking_dates($item_id)	// to find booking dates for an item
	{
		$sql="select * from user_reservations where item_id='".$item_id."' and item_status=1";
		return mysql_query($sql);

	}
}



?>