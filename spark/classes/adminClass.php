<?php
class admin
{
function adminLogin($user_name,$password)
	{
	 $sql="select * from user where user_email='".$user_name."' and user_password='".$password."' and user_type='A'";
	 $query=mysql_query($sql);
	 $id=mysql_fetch_assoc($query);
	 $user_id=$id['id'];
	 return $user_id;
	}
//function to display total items for rent flow
	function displayItems($orderby='')
	{
	  
		 $sql="SELECT newtable.item_id AS item_id, newtable.item_description,newtable.delete_status,newtable.item_subtitle, newtable.owner_id, newtable.item_Price, newtable.item_name, newtable.item_deposit, newtable.item_numberavailavel, newtable.phone, newtable.address2, newtable.address1, newtable.zip, newtable.state, newtable.created_on, newtable.city, newtable.count, user.id, user.user_fname, user.user_email, user.user_city, user.user_zip, user.user_state,user.user_picture, newtable.latitude, newtable.longitude
		 FROM user
		 INNER JOIN (

			SELECT item.id AS item_id, item.latitude, item.longitude, item_description, item.item_subtitle,item.owner_id,item.item_Price,item.item_name,item.delete_status,item.item_deposit, item.item_numberavailavel, item.phone, item.address2, item.address1, item.zip, item.state, item.created_on, item.city, count( reviews.item_id ) AS count
			FROM user_items AS item
			LEFT JOIN reviews ON reviews.item_id = item.id
			GROUP BY item.id
		) AS newtable ON newtable.owner_id = user.id " ;

		if($orderby)
		{
			$sql.=$orderby;
		}

		return  $sql;
	}

	function displayOwnername($user_id)
	{
		$sql="select * from user where id='".$user_id."'";
		$query=mysql_query($sql);
		$name=mysql_fetch_assoc($query);
		return $name['user_fname'];
	}
	function selectItem($item_id)
	{
		$sql="select * from user_items where id='".$item_id."'";
		$query=mysql_query($sql);
        $allrow=mysql_fetch_assoc($query);
		return $allrow;
	}
	function deleteItem($item_id)
	{
		$sql="delete from user_items where id='".$item_id."'" ;
		$query=mysql_query($sql);
		return $query;
	}
	function displayUsers()
	{
		$sql="SELECT * FROM user WHERE user_type != 'A' order by id desc";
		return $sql;
	}
	function deleteUser($user_id)
	{
       $sql="delete from user where id='".$user_id."'" ;
	   $query=mysql_query($sql);
		return $query;
	}
	function updateUserStatus($user_id, $user_status)
	{
       if($user_status==0)
		{
		   $sql="update user set user_status='1' where id='".$user_id."'";
		   $query=mysql_query($sql);
		}
		elseif($user_status==1)
		{
           $sql="update user set user_status='0' where id='".$user_id."'";
		   $query=mysql_query($sql);
		}
	}
	function selectUser($user_id)
	{
		$sql="select * from user where id='".$user_id."'";
		$query=mysql_query($sql);
		$user=mysql_fetch_assoc($query);
		return $user;

	}
		

}



?>


