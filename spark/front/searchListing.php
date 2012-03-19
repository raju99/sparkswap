<?php
include('../include/header.php');

//echo "<pre>";print_r($_SESSION);
//echo "<pre>";print_r($_POST);die;

$_SESSION['previous'] = basename($_SERVER['PHP_SELF']);

$str='';
if(isset($_POST['zip']) and is_numeric($_POST['zip']))
{
	$zip=$_POST['zip'];
	$str.='zip=$zip&';
}


if(isset($_POST['word']))
{
	$word=$_POST['word'];
	$str.='word=$word';
}


if(isset($_POST['search']))
{
	if(empty($_POST['zip']) && empty($_POST['word']) && ($_POST['word']=="What do you need?" || $_POST['zip']=="Zip code"))
	{
	  $sql=admin::displayItems(@$_SESSION['SORTING']);
	}
	else
	{
		 $sql=user::searchAll(@$_SESSION['SORTING']);  
	}
	
}
elseif(isset($_SESSION['search']['word']) || isset($_SESSION['search']['zip']))
{
	   $sql=user::searchAll(@$_SESSION['SORTING']);
	   //$file=$URL_SITE."front/searchListing.php";	  
}
else
{
	  $sql=admin::displayItems(@$_SESSION['SORTING']);
}

$objPagination=new Ps_Pagination($conn, $sql, 10, 5);
$exsql =$objPagination->paginate();
$total_item=@mysql_num_rows(@$exsql);
$location=get_current_location($ip);
?>	
<div class="containersearch">
	<!--containertop-->
	
	<div class="searchslide">
		<img src="<?php echo $URL_SITE;?>images/img_1.png"/>
	</div>

	<div class="srch">
		<form id='' method="POST" action ="searchListing.php" >			
			<div class="containersrchtop">
					<input class="bycycle" type="text" name="word" onclick="if(this.value=='What do you need?'){this.value=''}" onblur="if(this.value==''){this.value='What do you need?'}"value="What do you need?" value="<?php if(isset($_SESSION['search']['word'])) { echo $_SESSION['search']['word']; } else
					{
						echo 'Zip code';
					}
					?> " />

					<input class="numbr" type="text" name="zip" onclick="if(this.value=='Zip code'){this.value=''}" onblur="if(this.value==''){this.value='Zip code'}"value="<?php if(isset($_SESSION['search']['zip'])) { echo $_SESSION['search']['zip']; } else
					{
					echo 'Zip code';
					} ?>"  />
					
					<div class="searchsubmit">
						Pick up
						<input id='from_searchlist' class="searchdate" type="text" name="pickup_date" value="mm/dd/yyyy"onclick="if(this.value=='mm/dd/yyyy'){this.value=''}" onblur="if(this.value==''){this.value='mm/dd/yyyy'}"/>
					</div>
					<div class="searchsubmit">
						Drop off 
						<input class="searchdate" type="text" name="dropip_date" value="mm/dd/yyyy" onclick="if(this.value=='mm/dd/yyyy'){this.value=''}" onblur="if(this.value==''){this.value='mm/dd/yyyy'}" id='to_searchlist'/>
					</div>

					<input class="searchbtn" type="submit"  name ="search" value="search" />

			</div>
			<div class="searchadv"> <a href="javascript:;">Advanced Search</a></div> 	  
							
		</form>	
	</div>
	<!--sort-->
	<div class="sort pB20">
		<div class="left"> Sort by </div>
			<div class="srchnav">
				<ul>
				<li> 
					<a href="javascript:;" id='reviews' onclick="javascript:sort('reviews')"> Reviews </a> 
				</li>
				<li> 
					<a href="javascript:;" id='Price' onclick="javascript:sort('Price')"> Price </a> 
				</li>
				<li> 
					<a href="javascript:;" id='Distance' onclick="javascript:sort('Distance')"> Distance </a> 
				</li>
				</ul>
			</div>
	</div>
	<br class="clear" />
	<!--Map-->
	<div id="allitem pT20 pB20">
		<?php
		if($total_item>0)
		{
		?>
			<!-- User to  -->
			<div class="map" id='map_canvas'>map</div>
			<?php
			if(!empty($_SESSION['search']['pickup_date']) and !empty($_SESSION['search']['dropip_date']))
			{
				$pick=itemClass::changeDate($_SESSION['search']['pickup_date']);
				$drop=itemClass::changeDate($_SESSION['search']['dropip_date']);
			}
			
			while($all_item=mysql_fetch_assoc($exsql))
			{
				if(isset($_SESSION['user']['id']) and $all_item['owner_id']==$_SESSION['user']['id'] and $all_item['delete_status']=='0')
				{
				continue;
				}
				
				//$mainimage=user::selectImage($all_item['id']);
				if(isset($pick) and isset($drop))
				{
					$sql="select * from user_reservations where item_id='".$all_item['id']."'";
					$res=mysql_query($sql);
					if(mysql_num_rows($res)>0)
					{
					while($item_resrve_data=mysql_fetch_assoc($res))
					{
					if(($item_resrve_data['issue_date']>$pick and $item_resrve_data['end_date']<$drop) or ($item_resrve_data['issue_date']<$drop and $item_resrve_data['issue_date']>$pick))
					{
					continue;
					$continue=1;
					}
					}

					if(isset($continue) and $continue==1)
					{
					continue;
					}
					}
				}
				$image_item=itemClass::select_featured_image($all_item['item_id']);
				$user=user::user_profile($all_item['owner_id']);
				$reiwe=itemClass::countReview($all_item['item_id']);

				$lat1=$location['latitude'];//surfer latitude
				$lng1=$location['longitude'];//surfer longitude
				@$lat2=$all_item['latitude'];
				@$lng2=$all_item['longitude'];
				$distances[$all_item['id']]['distance']=distance($lat1, $lng1, $lat2, $lng2, $miles = false);
				?>

				<!--left_1-->
				<div class="srcpfl">
						<div class="cycle">		  
							<img src="<?php echo $URL_SITE;?>classes/show_image.php?filename=../images/<?php echo 'itemimages/'.$all_item['item_id'].'/'.$image_item['filename'];?>&width=125px&heigth=80px" />
						</div>

						<div class="srcpflpic">
							<img class="left mR5" src="<?php echo $URL_SITE;?>classes/show_image.php?filename=../images/<?php echo 'profile/'.$user['user_picture'];?>&width=36px&heigth=33px" />
						</div>

						<div class="srcaddresh">
							<h3> 
								<a class="colororange" href="<?php echo $URL_SITE;?>front/viewItem.php?item_id=<?php echo $all_item['item_id'];?>"><?php $item_name=ucwords($all_item['item_name']);
								echo $item_name;?></a>
							</h3> 
							
							<h4>"<?php $item_subtitle=ucwords($all_item['item_subtitle']); 
										echo $item_subtitle;?>"</h4>
							
							<div class="bluebtn"> <?php echo $reiwe;?>
								<h5> Reviews </h5> 
							</div>
							<div class="orangebtn"> S 
								<h5> Super Renter </h5>
							</div>
						</div>
						<div class="price">
							<h3>$<?php echo $all_item['item_Price']?> </h3>
							<h5> Per day </h5>
						</div>
				</div>
			<?php 
			} 
		}
		else
		{?>
			<div id="" class="pT20 pL10">
				<h3>No Result Found</h3>
			</div>
		
		<?
		}
		?>
      </div>
</div>

<!-- <div id="map_canvas" style="width: 100%; height: 100%"></div> -->



<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $google_api_key;?>" type="text/javascript"></script>
<script src="<?php echo $URL_SITE;?>js/gmaps.CircleOverlay.js" type="text/javascript"></script>

<script type="text/javascript">

		var map;
		var address;
		var lat=new Array();
		var lng=new Array();
		var name;
		var marker;
		var sidebarEntry;

		function createSidebarEntry(marker, name, address,d) 
		{
				
			  var div = document.createElement('div');
			  var html = "<b>" + name + "</b>  " + address+"("+d+")";
			  div.innerHTML = html;
			  div.style.cursor = 'pointer';
			  div.style.marginBottom = '5px'; 
			  GEvent.addDomListener(div, 'click', function() {
			 //GEvent.trigger(marker, 'click'); 
				 marker.openInfoWindowHtml("<font color='#C11010'>Name :"+name+"<br/><br/>Address: "+address+"</font>"); 
			 });

			  GEvent.addDomListener(div, 'mouseover', function() {
				div.style.backgroundColor = '#FFE9CE ';
			  });
			  GEvent.addDomListener(div, 'mouseout', function() {
				div.style.backgroundColor = '#fff';
			  });
			  return div;
		}
		   
		function distance(lat1,lat2,lon1,lon2) 
		{
					var R = 6371; // km (change this constant to get miles)
					var dLat = (lat2-lat1) * Math.PI / 180;
					var dLon = (lon2-lon1) * Math.PI / 180;
					var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
					Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) *
				Math.sin(dLon/2) * Math.sin(dLon/2);
				 var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
				var d = R * c;
				if (d>1) return d;
				 else if (d<=1) return Math.round(d*1000)+"m";
				return d;
		}
		function createMarker(point,name,friendaddress) 
		{
				var marker = new GMarker(point);
				GEvent.addListener(marker, "mouseover", function() {
				var myHtml = "<font color='#C11010'>Name:   "+name+"<br/><br/>Address:  "+friendaddress+"</font>";
				  marker.openInfoWindowHtml(myHtml);
				});
				GEvent.addListener(marker, "mouseout", function() {
				marker.closeInfoWindow();
				});
				return marker; 
		}

		//----------------------Draw A circle-------------------------//
		function drawCircle(center, radius, nodes, liColor, liWidth, liOpa, fillColor, fillOpa)
		{
				//calculating km/degree
				var latConv = center.distanceFrom(new GLatLng(center.lat()+0.1, center.lng()))/100;
				var lngConv = center.distanceFrom(new GLatLng(center.lat(), center.lng()+0.1))/100;
				var bounds = new GLatLngBounds();
				//Loop 
				var points = [];
				var step = parseInt(360/nodes)||10;
				for(var i=0; i<=360; i+=step)
				{
				var pint = new GLatLng(center.lat() + (radius/latConv * Math.cos(i * Math.PI/180)), center.lng() + 
				(radius/lngConv * Math.sin(i * Math.PI/180)));
				points.push(pint);
				bounds.extend(pint); //this is for fit function
				}
				points.push(points[0]); // Closes the circle, thanks Martin
				fillColor = fillColor||"#C11010";
				liWidth = liWidth||2;
				var poly = new GPolygon(points,liColor,liWidth,liOpa,fillColor,fillOpa);
				//map.clearOverlay();
				map.addOverlay(poly);
				map.setCenter(poly.getBounds().getCenter(),map.getBoundsZoomLevel(poly.getBounds()));
		}
		//--------------------///draw circle ends  here------------//

		function draw(pnt)
		{
			 
			  if(document.getElementById('km').checked)
			   {
					var givenRad = document.getElementById('radiusSelect').value;
			   }
				if(document.getElementById('mile').checked)
			   {
					var km=document.getElementById('km').value;
					var givenRad = (1.61)*(document.getElementById('radiusSelect').value);
				}
			  var givenQuality =80;
			  var centre = pnt || map.getCenter()
			  drawCircle(centre, givenRad, givenQuality,'grey');
		}

		function initialize() 
		{
				map = new google.maps.Map2(document.getElementById("map_canvas"));
				map.addControl(new GLargeMapControl3D());
				map.addControl(new GMapTypeControl());

				GDownloadUrl("mapGenXml.php?<?php echo $str;?>", function(data){
				var xml = GXml.parse(data);
				var markers = xml.documentElement.getElementsByTagName("marker");
				var usermarker=xml.documentElement.getElementsByTagName("user");
				if (usermarker.length != 0){
					var useraddress=usermarker[0].getAttribute("useraddress");
					var username=usermarker[0].getAttribute("name");
					var userlat=usermarker[0].getAttribute("lat");
					var userlng=usermarker[0].getAttribute("lng");
					point = new GLatLng(userlat,userlng);
					marker = createMarker(point,username,useraddress);
					map.addOverlay(marker);
					draw(point);
				}
				var sidebar = document.getElementById('sidebar');
				sidebar.innerHTML = '';
				if (markers.length == 0) {
				 sidebar.innerHTML =" No results found Or user's address is not locatable";
				 return;}
				 if(usermarker.length!=0){
				sidebarEntry = createSidebarEntry(marker, username,useraddress,0);
				sidebar.appendChild(sidebarEntry);}
				
				for(var i = 0; i < markers.length;i++)
				{
					address= markers[i].getAttribute("address");
					name= markers[i].getAttribute("name");
					lat[i]=markers[i].getAttribute("lat");
					lng[i]=markers[i].getAttribute("lng");
					point = new GLatLng(lat[i],lng[i]);
					if(userlat==0 || userlng==0 || usermarker.length ==0)
					{
						map.setCenter(point,8);
					}
					marker = createMarker(point,name,address);
					map.addOverlay(marker);
					var d=distance(lat[i],userlat,lng[i],userlng);
					//if(document.getElementById('km').checked)
					//{
						//d=Math.round(d)+"km";
					 //}
					//if(document.getElementById('mile').checked)
					 //{
						d=Math.round(0.6213711*d)+"miles";
					 //}
					sidebarEntry = createSidebarEntry(marker,name,address,d);
					sidebar.appendChild(sidebarEntry);
				}
			});
		}
</script>

<div id="sidebar" style="display:none;overflow: auto; height: 400px;margin-top:10px; font-size: 11px; color: #000" ></div>