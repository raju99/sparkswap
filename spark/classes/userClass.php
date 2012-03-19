<?php
class user
{		
		//function to fetch array
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

		function userLogin($name,$password)
		{
			$sql="select * from user where  username='".$name."' and user_password='".$password."' and block_status='0'";
			$result=mysql_query($sql)or die(mysql_error());
			$return =mysql_fetch_array($result);
			return $return;
		}

		function blockAccountStatus($user_id)
		{
			$sql="update user set block_status='1' where  id='".$user_id."' and block_status='0'";
			$result=mysql_query($sql)or die(mysql_error());
			return $result;
		}

		function updateUserPassword($user_id,$password)
		{
			$sql="update user set user_password='".$password."' where id='".$user_id."' ";
			$result=mysql_query($sql)or die(mysql_error());
			return $result;
		}

		function userRegistration($fname,$lname,$email,$password,$username)
		{
		      global $URL_SITE;
		     $sql="select * from user where user_email='".$email."'";
			 $query=mysql_query($sql);
			 $checkcount=mysql_num_rows($query);
			 if($checkcount>0)
			{
				 $_SESSION['email']=$email;
				 $_SESSION['email_check']="Already in use";
			}
             
             $sql="select * from user where username='".$username."'";
             $query=mysql_query($sql);
			 $checkcount=mysql_num_rows($query);
			 if($checkcount>0)
			{
				 $_SESSION['username']=$username;
				 $_SESSION['username_check']="Already in use";
			}
              if((isset($_SESSION['username_check'])) || (isset($_SESSION['email_check'])))
			{
			
				  header("location:".$URL_SITE."front/userRegistration.php");
				  exit;
			}
			 $sql="insert into user  set user_fname='".$fname."',user_lname='".$lname."',user_email='".$email."',user_password='".md5($password)."', username='".$username."'";
			
			
			$result=mysql_query($sql);
			$id=mysql_insert_id();
			if($id>0)
			{
				mysql_query("insert into setting set user_id='".$id."', phone=0, persona_desc=0, profile=0, email=0, upcoming_rental=0,rental_request=0, new_review=0, facebook_connect=0");
					
			}
			return $result;
		
	}
	function featureImage()
	{
		$i=1;
	foreach ($_POST['image_list'] as $image_list)
		{
			$sql="UPDATE itemimages  SET feature='". $i ."' WHERE id='". mysql_real_escape_string($image_list)."'";
			$query=mysql_query($sql);
			$i++;
		}
		return $query;
	}

	function user_profile($id)	// use this function to fetch user all details
	{
		$sql="select * from user where id='".$id."'";
		$user_rid=mysql_query($sql);
		return mysql_fetch_assoc($user_rid);
	}
	

//This function is for fetching the user info
	function selectAllUser($id)
	{
			$sql="select * from user where id='".$id."'";
			$result=mysql_query($sql)or die(mysql_error());
			return $result;
	}
////This function is used for update user profile
	function updateUserProfile($fname,$lname,$email,$contact,$city,$userid,$gender)
	{
		$sql="update user set user_fname='".$fname."',user_lname='".$lname."',gender='".$gender."',user_email='".$email."',contact='".$contact."',User_city='".$city."',about_me='".$_POST['about_me']."' where id='".$userid."'";
		$result=mysql_query($sql)or die(mysql_error());
		return $result;
	}
	//function to update user contact if any contact(clone) deleted by user
	function updateContact( $contact,$user_id)
	{
		$sql="update user set contact='".$contact."' where id='".$user_id."'";
		$query=mysql_query($sql);
		return $query;

	}
	//function to display reviews given by user
	function reviewsByYou($user_id)
	{
		$sql="select * from reviews where user_id='".$user_id."'";
		$query=mysql_query($sql);
		return $query; 
	}

	function reviewsByYoupagi($user_id)
	{
		$sql="select * from reviews where user_id='".$user_id."'";
		
		return $sql; 
	}

	function reviewaboutYou($user_id)
	{
		 $sql="SELECT item.id item_id, item.item_name, item_description, item.owner_id, item.item_subtitle, reviews.communication, reviews.accuracy, reviews.rating, reviews.reviews, reviews.user_id, reviews.item_id
		 FROM reviews, user_items item
		 WHERE item_id = reviews.item_id
		 AND item.owner_id ='".$user_id."'";
		
		 return $sql; 
	}
	function pickupDetails($item_id)
	{
	  $sql="select * from user_reservations where item_id='".$item_id."'";
	  $query=mysql_query($sql);
	  return $query;
	}
	//FUNCTION TO UPDATE USER IMAGE 
    function updateUserImage($user_id,$imagename)
	{
		global $DOC_ROOT;
        $result=user::selectAllUser($user_id);

		$user_image=mysql_fetch_assoc($result);
        $image=$user_image['user_picture'];
		if($image!="")
		{
			unlink($DOC_ROOT.'images/profile/'.$image);
		}
        $sql="update user set user_picture='".$imagename."' where id='".$user_id."'";
		$query=mysql_query($sql);
		return $query;
	}
	function checkEmail($email_id)
	{
		$sql="select * from user where user_email='".$email_id."'";
		$query=mysql_query($sql);
		$count=mysql_num_rows($query);
		return $count;
	}
	function checkusername($username)
	{
		$sql="select * from user where username='".$username."'";
		$query=mysql_query($sql);
		$count=mysql_num_rows($query);
		return $count;
	}



	function searchAll($orderby='')
	{
		  $sql="SELECT newtable.item_id AS item_id,newtable.delete_status,newtable.item_description, newtable.item_name, newtable.item_subtitle, newtable.owner_id, newtable.item_Price, newtable.item_name, newtable.item_deposit, newtable.item_numberavailavel, newtable.phone, newtable.address2, newtable.address1, newtable.zip, newtable.state, newtable.created_on, newtable.city, newtable.count, user.id, user.user_fname, user.user_email, user.user_city, user.user_zip,newtable.latitude, newtable.longitude, user.user_state,user.user_picture
		  FROM user
		  INNER JOIN 
		  (

			SELECT item.id AS item_id, item.latitude, item.longitude, item_description, item.item_subtitle, item.owner_id, item.item_Price, item.item_name,item.delete_status, item.item_deposit, item.item_numberavailavel, item.phone, item.address2, item.address1, item.zip, item.state, item.created_on, item.city, count( reviews.item_id ) AS count
			FROM user_items AS item
			LEFT JOIN reviews ON reviews.item_id = item.id
			GROUP BY item.id
		  ) AS newtable ON (newtable.owner_id = user.id ";

			if((!empty($_POST['word']) && $_POST['word']!="What do you need?") || isset($_SESSION['search']['word']))
			{
				if(!empty($_POST['word']) && $_POST['word']!="What do you need?")
				{
					$_SESSION['search']['word']=$_POST['word'];
					$sql.="and newtable.item_name like '%".$_POST['word']."%'";
					
				}
				else
				{
					$sql.="and newtable.item_name like '%".$_SESSION['search']['word']."%'";
				}				
			}

						
			if((!empty($_POST['zip']) && $_POST['zip']!="Zip code") or isset($_SESSION['search']['zip']))
			{

				if(!empty($_POST['zip']))
				{
					$_SESSION['search']['word']=$_POST['zip'];
					$sql.="and newtable.zip='".$_POST['zip']."'";					
				}
				else
				{
					$sql.="and newtable.item_name like '%".$_SESSION['search']['zip']."%'";
				}			
				
			}
			

			if(!empty($_POST['pickup_date']) && $_POST['pickup_date']!='mm/dd/yyyy')
			{
				$_SESSION['search']['pickup_date']=$_POST['pickup_date'];
				$_SESSION['search']['dropip_date']=$_POST['dropip_date'];
			}

			if(!empty($_GET['pickup_date']) && $_GET['pickup_date']!='mm/dd/yyyy')
			{
				$_SESSION['search']['pickup_date']=$_GET['pickup_date'];
				$_SESSION['search']['dropip_date']=$_GET['dropip_date'];
			}

			$sql.=") ";
			if($orderby)
			{
			$sql.=$orderby;
			}

			return $sql;
	}

	
	function displayItemsAllItem($user_id)
	{

	     $sql="select * from user_items where  owner_id ='".$user_id."' and delete_status='0' order by id desc";	
		 return  $sql;
	}

	function displayItemsAllDelItem($user_id)
	{

	     $sql="select * from user_items where  owner_id ='".$user_id."' and delete_status='1' order by id desc";	
		 return  $sql;
	}

	function displayItems($itemid)
	{
	     $sql="select * from user_items where  id ='".$itemid."' ";	
		 $res=mysql_query($sql);		 
		 return  $res;
	}

	function getStarItemsId($user_id)
	{
		 $info=array();
	     $sql="select * from favourite where  user_id='".$user_id."' and status='1' order by id desc";	
		 $query=mysql_query($sql);
		 $count=mysql_num_rows($query);
		 if($count > 0)
		 {
			 while($data=mysql_fetch_assoc($query))
			 {
				 $info[]=$data['item_id'];
			 }
		 }
		 return $info;
	}

	function displaystarItemsAllItem($item_idArray)
	{
		 	
		$arraylist='';
		foreach($item_idArray as $ids)
		{
			$arraylist.=$ids.',';

		}
		$finalitemids=substr($arraylist,0,-1);

	    $sql="select * from user_items where id IN (".$finalitemids.") order by id desc";	
		return $sql;
	}


	function selectImage($item_id)
	{
		$sql="select * from itemimages where item_id='".$item_id."'";
		$query=mysql_query($sql);
		$row=mysql_fetch_assoc($query);
		return  $row;

	}
//function to dispaly all item images
    function selectItemImages($item_id)
	{
		$sql="select * from itemimages where item_id='".$item_id."' order by feature";
		$query=mysql_query($sql);
		return $query;
	}

	function selectAllImage($item_id)
	{
				$sql="select * from itemimages where item_id='".$item_id."'";
				$query=mysql_query($sql);
				return  $query;

	}


	function insertItem($userid,$latitude,$longitude)
	{
				$title=$_POST['title'];
				$subtitle=$_POST['subtitle'];

				$description=$_POST['description'];

				$priceperday=$_POST['priceperday'];

				$depositamount=$_POST['depositamount'];
				$availavel=$_POST['availavel'];


				$phoneno=$_POST['phoneno'];

				$address1=$_POST['address1'];
				$address2=$_POST['address2'];
				$city=$_POST['city'];
				$state=$_POST['state'];

				$zip=$_POST['zip'];

				$pickup=$_POST['pickup'];
				$dropoff=$_POST['dropoff'];

				$delivery_fee=$_POST['delivery_fee'];
				$delivery_radius=$_POST['delivery_radius'];


				$sql="insert into user_items  set item_name='".$title."',
				item_description='".$description."',
				item_subtitle='".$subtitle."',
				item_Price='".$priceperday."',
				item_deposit='".$depositamount."',
				item_numberavailavel='".$availavel."',
				phone='".$phoneno."',
				address2='".$address2."',
				address1='".$address1."',
				zip='".$zip."',
				state='".$state."',
				city='".$city."',
				owner_id='".$userid."',
				latitude='".$latitude."',
				longitude='".$longitude."',
				pickup='".$pickup."',
				dropoff='".$dropoff."',
				delivery_fee='".$delivery_fee."',
				delivery_radius='".$delivery_radius."',
				created_on=now()";

			 mysql_query($sql);
			 return mysql_insert_id();
	}

	function selectPayoutMode($userid)
	{
			$sql="select * from payout_preferences where user_id=".$userid." and active_type='1' ";
			$res=mysql_query($sql);
			return $res;		
	}


	function payoutPreferencesPaypal($userid)
	{
			$payout_email=$_POST['payout_email'];
			$payout_type=$_POST['payout_type'];

			$sql1="select * from payout_preferences where user_id=".$userid." and active_type='1' ";
			$res1=mysql_query($sql1);
			$count1=mysql_num_rows($res1); 
			$row1=mysql_fetch_assoc($res1);
			
			if($count1 > 0)
			{
				$sql="update payout_preferences set active_type='0' where id='".$row1['id']."' ";
				$res=mysql_query($sql);						
			}
						
			$sql="insert into payout_preferences set user_id='".$userid."',payout_type='".$payout_type."',payout_email='".$payout_email."',active_type='1',date=NOW()";						
			mysql_query($sql);
			return mysql_insert_id();			
	}

	function DirectInformationDeposit($userid)
	{
			$name_on_account=$_POST['name_on_account'];			
			$account_type=$_POST['account_type'];
			$routing_number=$_POST['routing_number'];
			$account_number=$_POST['account_number'];
			$payout_type=$_POST['payout_type'];

			$sql="select * from payout_preferences where user_id=".$userid." and name_on_account='".$name_on_account."' and account_type='".$account_type."' and routing_number='".$routing_number."' and account_number='".$account_number."' and payout_type='".$payout_type."' and payout_email='".$payout_email."' ";
			$res=mysql_query($sql);
			$count=mysql_num_rows($res); 
			$rowM=mysql_fetch_assoc($res);

			if($count > 0)
			{
					if($rowM['active_type']=='1')
					{
							$sql="update payout_preferences set date=NOW() where where id='".$rowM['id']."' ";
							$res=mysql_query($sql);
							return $res;
					}
					else
					{
						$sql1="select * from payout_preferences where user_id=".$userid." and active_type='1' ";
						$res1=mysql_query($sql1);
						$count1=mysql_num_rows($res1); 
						$rowI=mysql_fetch_assoc($res1);
						
						if($count1 > 0)
	  					{
							$sql="update payout_preferences set active_type='0' where id='".$rowI['id']."' ";
							$res=mysql_query($sql);

							$sql="update payout_preferences set date=NOW(),active_type='1' where id='".$rowM['id']."' ";
							$res=mysql_query($sql);
							return $res;
						}
					}

			}
			else
			{
				$sql1="select * from payout_preferences where user_id=".$userid." and active_type='1' ";
				$res1=mysql_query($sql1);
				$count1=mysql_num_rows($res1); 
				$rowB=mysql_fetch_assoc($res1);
				
				if($count1 > 0)
				{
					$sql="update payout_preferences set active_type='0' where id='".$rowB['id']."' ";
					$res=mysql_query($sql);						
				}
				
				$sql="insert into payout_preferences set user_id=".$userid.",name_on_account='".$name_on_account."',account_type='".$account_type."',routing_number='".$routing_number."',account_number='".$account_number."',payout_type='".$payout_type."',active_type='1',date=NOW()";						
				mysql_query($sql);
				return mysql_insert_id();
			}
						
	}

	function checkInformationDeposit($userid)
	{
			$name_on_check=$_POST['name_on_check'];			
			$address_1=$_POST['address_1'];
			$address_2=$_POST['address_2'];
			$city=$_POST['city'];
			$state=$_POST['state'];
			$zip_code=$_POST['zip_code'];
			$country=$_POST['country'];
			$payout_type=$_POST['payout_type'];

			$sql="select * from payout_preferences where user_id=".$userid." and name_on_check='".$name_on_check."' and address_1='".$address_1."' and address_2='".$address_2."' and city='".$city."' and state='".$state."' and payout_type='".$payout_type."' and zip_code='".$zip_code."' and country='".$country."' ";
			$res=mysql_query($sql);
			$count=mysql_num_rows($res); 
			$rowM=mysql_fetch_assoc($res);

			if($count > 0)
			{
					if($rowM['active_type']=='1')
					{
							$sql="update payout_preferences set date=NOW() where where id='".$rowM['id']."' ";
							$res=mysql_query($sql);
							return $res;
					}
					else
					{
						$sql1="select * from payout_preferences where user_id=".$userid." and active_type='1' ";
						$res1=mysql_query($sql1);
						$count1=mysql_num_rows($res1); 
						$rowI=mysql_fetch_assoc($res1);
						
						if($count1 > 0)
	  					{
							$sql="update payout_preferences set active_type='0' where id='".$rowI['id']."' ";
							$res=mysql_query($sql);

							$sql="update payout_preferences set date=NOW(),active_type='1' where id='".$rowM['id']."' ";
							$res=mysql_query($sql);
							return $res;
						}
					}

			}
			else
			{
				$sql1="select * from payout_preferences where user_id=".$userid." and active_type='1' ";
				$res1=mysql_query($sql1);
				$count1=mysql_num_rows($res1); 
				$rowB=mysql_fetch_assoc($res1);
				
				if($count1 > 0)
				{
					$sql="update payout_preferences set active_type='0' where id='".$rowB['id']."' ";
					$res=mysql_query($sql);						
				}
				
				$sql="insert into payout_preferences set user_id=".$userid.",name_on_check='".$name_on_check."',address_1='".$address_1."',address_2='".$address_2."',city='".$city."',state='".$state."',payout_type='".$payout_type."',zip_code='".$zip_code."',country='".$country."',active_type='1',date=NOW()";	
				mysql_query($sql);
				return mysql_insert_id();
			}
						
	}
	

	function updateItem($item_id)
	{
			$title=$_POST['title'];
			$subtitle=$_POST['subtitle'];

			$description=$_POST['description'];

			$priceperday=$_POST['priceperday'];

			$depositamount=$_POST['depositamount'];
			$availavel=$_POST['availavel'];


			$phoneno=$_POST['phoneno'];

			$address1=$_POST['address1'];
			$address2=$_POST['address2'];
			$city=$_POST['city'];
			$state=$_POST['state'];

			$zip=$_POST['zip'];

			   $sql="update  user_items  set item_name='".$title."',
			 item_description='".$description."',
			 item_subtitle='".$subtitle."',
			 item_Price='".$priceperday."',
			 item_deposit='".$depositamount."',
			 item_numberavailavel='".$availavel."',
			 phone='".$phoneno."',
			 address2='".$address2."',
			 address1='".$address1."',
			 zip='".$zip."',
			 state='".$state."',
			 city='".$city."'
			 where
			id='".$item_id."'
			 ";
			 

			 mysql_query($sql);

	}

	function insertItemImage($file,$item_id,$primary='1')
	{
		    $sql="insert into itemimages  set 
			 	filename='".$file."',
			item_id='".$item_id."', feature='".$primary."'
			 ";
				
			 mysql_query($sql)or die(mysql_error());
	}


	function mainDetailOfItem($item_id)
	{
			 $sql="select item.id item_id, item.item_name,item_description,
			item.item_subtitle,
			item.owner_id,
			item. item_Price,
			item. dropoff,
			item. pickup,
			item.item_deposit,
			item.item_numberavailavel,
			item.phone,
			item.latitude,
			item.longitude,
			item. address2,
			item. address1,
			item. zip,
			item.state,
			item.created_on,
			item.city,user.id,user.user_fname,user.user_email,user.user_city,user.	user_zip,user.user_state from user_items as item,user where item.owner_id=user.id and item.id='".$item_id."'";

			 $result=mysql_query($sql)or die(mysql_error());

			  $row=mysql_fetch_assoc($result);
			  return $row;
	}

	function sendMessage($item_id,$user_id)
	{
		
		$to=@$_POST['email'];
		$subject=@$_POST['subject'];
		$message=@$_POST['message'];
		
		$sql="insert into inbox  set receiver_id='".$user_id."',subject='".$subject."',content='".$message."',item_id='".$item_id."',sender_id='".@$_SESSION['user']['id']."',date=now()";
		$result=mysql_query($sql);
		return $result;

	}
	
	//function to delete item image
	function deleteItemImage($del_id,$item_id,$name)
	{
		global $DOC_ROOT;
		$sql="delete from itemimages where id='".$del_id."' ";
		$query=mysql_query($sql);
		unlink($DOC_ROOT."images/$item_id/$name");
		return $query;
	}



	function forgotPassword($email)
	{
		$sql = "select * from users where user_email = '".$email."'";
		$result = mysql_query($sql);
		return mysql_fetch_assoc($result);


	}

	function selectitemRequested($reserve_id)
	{
		$sql="select * from  user_reservations  where id='".$reserve_id."' ";

		$result=mysql_query($sql);

		$user=mysql_fetch_assoc($result);
		return $user['user_id'];



	}

	function generatePassword(){
		$characters = array(
		"A","B","C","D","E","F","G","H","J","K","L","M",
		"N","P","Q","R","S","T","U","V","W","X","Y","Z",
		"1","2","3","4","5","6","7","8","9");

		//make an "empty container" or array for our keys
		$keys = array();

		//first count of $keys is empty so "1", remaining count is 1-6 = total 7 times
		while(count($keys) < 6) {
			//"0" because we use this to FIND ARRAY KEYS which has a 0 value
			//"-1" because were only concerned of number of keys which is 32 not 33
			//count($characters) = 33
			$x = mt_rand(0, count($characters)-1);
			if(!in_array($x, $keys)) {
			   $keys[] = $x;
			}
		}

		foreach($keys as $key){
		   $random_chars .= $characters[$key];
		}
		 return $random_chars;

		
	 }

	 function addToFavourite($item_id,$user_id)
	 {
		$sql="select * from favourite where item_id='".$item_id."' and user_id='".$user_id."'";
		$result=mysql_query($sql);
		if(mysql_num_rows($result)>0)
		{
			 return 0;
		}
		else
		{
			 $sql="insert into favourite set item_id='".$item_id."' , user_id='".$user_id."' , date=now()";
			 $result=mysql_query($sql);
			 return mysql_insert_id();

		}
	 }


	 function FavaratesMakeItem($item_id,$user_id,$status)
	 {
		$sql="select * from favourite where item_id='".$item_id."' and user_id='".$user_id."'";
		$result=mysql_query($sql);
		
		if(mysql_num_rows($result)>0)
		{
			 $sql="update favourite set status=".$status.",date=now() where item_id='".$item_id."' and user_id='".$user_id."'";
			 $result=mysql_query($sql);
			 return mysql_insert_id();
		}
		else
		{
			 $sql="insert into favourite set item_id='".$item_id."' , user_id='".$user_id."' ,status=".$status.",date=now()";
			 $result=mysql_query($sql);
			 return mysql_insert_id();

		}
	 }

	 function CheckFavourite($item_id,$user_id)
	 {
		$sql="select * from favourite where item_id='".$item_id."' and user_id='".$user_id."' and status='1'";
		$result=mysql_query($sql);
		return $result;
		
	 }

	function selectFavourite($user_id)
	{

		$sql=	"SELECT user_items . *
		FROM user_items, favourite
		WHERE user_items.id = favourite.item_id
		AND favourite.user_id = '".$user_id."'";		
		return $sql;
	}

	function deletFavouriteItem($item_id,$user_id)
	 {
		$sql="delete from favourite where item_id='".$item_id."' and user_id='".$user_id."' ";
		$result=mysql_query($sql);
		return $result;
		
	 }

	function user_settings($user_id,$phone,$profile,$description)
	{
		 $sql="insert into setting set user_id='".$user_id."', phone='".$phone."', persona_desc='".$description."', profile='".$profile."'";
		$res=mysql_query($sql);
		return mysql_affected_rows();
	}

	function select_settings_for_user($user)
	{
		 $sql="select * from setting where user_id='".$user."'";
		return mysql_query($sql);
	}

	function update_user_settings($user_id,$phone,$profile,$description)
	{
		$sql="update  setting set phone='".$phone."', persona_desc='".$description."', profile='".$profile."' where user_id='".$user_id."'";
		$res=mysql_query($sql);
		return mysql_affected_rows();
	}
	function update_user_privacy($user_id)
	{
		$condition="";
		$sql="select * from  setting where user_id='".$user_id."'";
		$query=mysql_query($sql);
		$count=mysql_num_rows($query);
		if($count>0)
		{
			$sql="update ";
			$condition="where user_id='".$user_id."'";
		}else{
			$sql="insert into ";
		}
		$sql.= " setting set social_status='".$_POST['social']."',search_engine_status='".$_POST['search']."',facebook_status='".$_POST['facebook']."' ".$condition;
		$query=mysql_query($sql);
		return $query;


	}


	function insertfeedback($user_id,$item_id)
	{
		
			  $sql="insert into reviews set user_id='".$user_id."', item_id='".$item_id."',
		 	reviews='".mysql_real_escape_string ($_POST['comment'])."',rating='".$_POST['ratng2']."', accuracy='".$_POST['ratng1']."', communication='".$_POST['ratng']."',date=now()";
			$res=mysql_query($sql)OR DIE(MYSQL_ERROR());
			return mysql_affected_rows();
	}

	function insertMessage($item_id,$renter,$reserve_id,$subject,$msg)
	{			
		$sql1="select * from inbox where sender_id='".@$_SESSION['user']['id']."' and receiver_id='".$renter."' and read_status='0' and item_id=".$item_id." ";
			$res=mysql_query($sql1);
			$count=@mysql_num_rows($res);

			if($count > 0)
			{
				$sql="UPDATE inbox  set subject='".$subject."',content='".$msg."',date=now() where sender_id='".@$_SESSION['user']['id']."' and receiver_id='".$renter."' and item_id=".$item_id."";
				$result=mysql_query($sql) or die(mysql_error());
				return $result;

			}
			else
			{
				$sql="insert into inbox  set receiver_id='".$renter."',subject='".$subject."',content='".$msg."',item_id='".$item_id."',sender_id='".@$_SESSION['user']['id']."',date=now(),reservation_id='".$reserve_id."' ";
				$result=mysql_query($sql) or die(mysql_error());
				return $result;
			}
					
	}

	function update_message($msg_id)
	{
			$sql="UPDATE inbox set date=now(),read_status='1',replied_on_id='".@$_SESSION['user']['id']."' where msg_id='".$msg_id."'";
			$result=mysql_query($sql) or die(mysql_error());
			return $result;	
	}

	function update_message_confirm($msg_id)
	{
			$sql="UPDATE inbox set date=now(),read_status='1',replied_on_id='".@$_SESSION['user']['id']."' where msg_id='".$msg_id."'";
			$result=mysql_query($sql) or die(mysql_error());
			return $result;
	}


	function insertMessageOwnerMsg($item_id,$sender_id,$receiver_id,$reserve_id,$subject,$msg)
	{			
			$sql1="select * from inbox where sender_id='".$sender_id."' and receiver_id='".$receiver_id."' and read_status='0' and item_id=".$item_id." ";
			$res=mysql_query($sql1);
			$count=@mysql_num_rows($res);

			if($count > 0)
			{
				$sql="UPDATE inbox  set subject='".$subject."',content='".$msg."',date=now() where sender_id='".$sender_id."' and receiver_id='".$receiver_id."' and item_id=".$item_id." ";
				$result=mysql_query($sql) or die(mysql_error());
				return $result;

			}
			else
			{
				$sql="insert into inbox  set receiver_id='".$receiver_id."',subject='".$subject."',content='".$msg."',item_id='".$item_id."',sender_id='".$sender_id."',date=now(),reservation_id='".$reserve_id."' ";
				$result=mysql_query($sql) or die(mysql_error());
				return $result;
			}			
					
	}


	function changeitemStatus($item_id,$action)
	{
			switch($action)
			{
				case 'post':$status=1;
							break;

				case 'deny':$status=2;
							break;

				case 'accept':$status=3;
							  break;

				case 'booked':$status=4;
							  break;
			}

			$sql="update user_reservations set item_status='".$status."' where id='".$item_id."' ";
			$result=mysql_query($sql);
	}

	function newProposaldate($startdate,$enddate,$reserveitem)
	{
		$sql="update user_reservations set newissuedate='".$startdate."',newienddate='".$enddate."' where id='".$reserveitem."'";
		$result=mysql_query($sql);

	}
// function to register through facebook.
	function registration_facebook($user_id,$fname,$lname,$gender,$email)
	{
		$sql="select * from user where  user_email='".$email."'";//checks whether email already present or not
		$result=mysql_query($sql)or die(mysql_error());
		$already=mysql_num_rows($result);
		if($already>0)
		{
			$user=user::user_profile($result['id']);
			return $user;
		}
		else
		{
			$sql="insert into user  set user_fname='".$fname."',user_lname='".$lname."',user_email='".$email."',gender='".$gender."',created=now()";
			$result=mysql_query($sql);
			$latest_id=mysql_insert_id();
			if($latest_id>0)
			{
			mysql_query('update setting set user_id='.$latest_id.',facebook_connect=1');
			$sql="select * from user where  id='".$latest_id."'";
			$result=mysql_query($sql)or die(mysql_error());
			$return =mysql_fetch_array($result);
			return $return;
			}
		}
	}

	function select_notification($user)
	{
		 $sql="select email, upcoming_rental,rental_request, new_review from setting where user_id='".$user."'";
		$sql=mysql_query($sql);
		return mysql_fetch_assoc($sql);
	}

	function update_settings($user,$string_with_fileds_value)
	{
		 $sql="update setting set ".$string_with_fileds_value." where user_id='".$user."'";
		mysql_query($sql);
		return mysql_affected_rows();
	}

	function select_user_for_recent_item_mail()
	{
		echo $sql="select u.id as user_id,u.username,u.user_fname, u.user_email from user u, setting s where u.id=s.user_id and email=1";
		return mysql_query($sql);
	}

	function checkRentStatus($reserve_id)
	{
		$sql="select * from  user_reservations  where id='".$reserve_id."' ";
		$result=mysql_query($sql);		
		return $result;
	}


	function payment_dtatils($item_id,$owner)
	{		
		@$payout_email=$_POST['payout_email'];
		@$payout_type=$_POST['payout_type'];

		@$name_on_account=$_POST['name_on_account'];			
		@$account_type=$_POST['account_type'];
		@$routing_number=$_POST['routing_number'];
		@$account_number=$_POST['account_number'];
		
		@$name_on_check=$_POST['name_on_check'];			
		@$address_1=$_POST['address_1'];
		@$address_2=$_POST['address_2'];
		@$city=$_POST['city'];
		@$state=$_POST['state'];
		@$zip_code=$_POST['zip_code'];
		@$country=$_POST['country'];

		@$desciption_renter=$_POST['desciption_renter'];
		@$phonenumber=$_POST['phonenumber'];
		
		@$pay=$_POST['total_price'];	
		
		@$droop_date=$_POST['drop_up']; 
		@$pick_up=$_POST['pick_up'];
		@$pickup_date=substr($pick_up,0,10);
		@$drop_date=substr($droop_date,0,10);
		
		$sql="insert into user_transactions	set	owner_id='".$owner."',payer_id='".$_SESSION['user']['id']."',phonenumber='".$phonenumber."',	item_id='".$item_id."',desciption_renter='".$desciption_renter."',name_on_check='".$name_on_check."',address_1='".$address_1."',address_2='".$address_2."',city='".$city."',state='".$state."',zip_code='".$zip_code."',country='".$country."',payout_email='".$payout_email."',payout_type='".$payout_type."',name_on_account='".$name_on_account."',	account_type='".$account_type."',routing_number='".$routing_number."',account_number='".$account_number."',pay='".$pay."',payment_date=now()";

		itemClass::setRentRequest($item_id,$owner,$pickup_date,$drop_date);
		$res=mysql_query($sql);
		return mysql_insert_id();
	}

	function socialWebstatusofUser($user_id)
	{
		$sql="select * from  setting  where user_id='".$user_id."' ";
		$result=mysql_query($sql);		
		return $result;
	}


	function updateItemStatus($itemid,$status)
	{
		$sql="update user_items set delete_status=".$status." where id='".$itemid."' ";
		$result=mysql_query($sql);		
		return $result;
	}
	
}//user class ends

class payment
{
	function payment_by_owner($usr)	// select payment done by renter
	{
		 $sql="select * from user_transactions where payer_id='".$usr."'";		
		 return $sql;
	}

	function payment_by_user($usr)	// select payment done by owner
	{
		  $sql="select * from user_transactions where owner_id='".$usr."'";		
		  return $sql;
	}

	function all_payments_for_user($user)
	{
		 $sql="Select * from user_transactions where payer_id='".$user."' or owner_id='".$user."' order by id DESC";
		 return $sql;
		 
	}
}
	

?>
