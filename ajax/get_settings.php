<?php
require_once('../myconfig/config.php');

/**************** PASSWORD UPDATE START **********************/	

if(isset($_POST['action']) && $_POST['action']=='PASS_UPDATE')
	{
		
		$sqlupdatepass = "UPDATE ".$prev."restaurant SET rest_password='".mysql_real_escape_string($_POST['newpassword'])."' WHERE rest_id='".$_SESSION['rest_id']."'";
		if(mysql_query($sqlupdatepass))
		{
			echo "<strong style='color:#006600;'>Password updated successfully</strong>";
		}
	}

/**************** PASSWORD UPDATE END **********************/	

/**************** RESTAURANT CONTACT INFO UPDATE START **********************/	

if(isset($_POST['action']) && $_POST['action']=='REST_CONTACT_INFO_UPDATE')
	{
		$delivery_code=$_POST['delivery_code'];
		//print_r($delivery_code);
			//$delivery_code=implode(',',$delivery_code);
		 $sql_rest_contact="UPDATE ".$prev."restaurant SET 
					 rest_address='".mysql_real_escape_string($_POST['restaurant_streetaddress_con'])."',
					 rest_contact_name='".mysql_real_escape_string($_POST['restaurant_contact_name_con'])."',
					 rest_contact_phone='".mysql_real_escape_string($_POST['restaurant_contact_phone_con'])."',
					 rest_contact_email='".mysql_real_escape_string($_POST['restaurant_contact_email_con'])."',
					 cur_date=CURDATE(),
					 state_id='".mysql_real_escape_string($_POST['state_id'])."',
					 city_id='".mysql_real_escape_string($_POST['city_id'])."',
					  delivery_code='".$delivery_code."',
					 zip_id='".mysql_real_escape_string($_POST['zip_id'])."' WHERE rest_id=".$_SESSION['rest_id'];
					 
		if(mysql_query($sql_rest_contact))
		{
			echo "<strong style='color:#006600;'>Restaurant Contact Info updated successfully</strong>";
		}
	}

/**************** RESTAURANT CONTACT INFO UPDATE END **********************/	

/**************** RESTAURANT INFO UPDATE START **********************/	

if(isset($_POST['action']) && $_POST['action']=='REST_INFO_UPDATE')
	{
		$sql_rest_contact="UPDATE ".$prev."restaurant SET 
					 rest_name='".mysql_real_escape_string($_POST['restaurant_name_res'])."',
					 rest_phone='".mysql_real_escape_string($_POST['restaurant_phone_res'])."',
					 rest_website='".mysql_real_escape_string($_POST['restaurant_website_res'])."',
					 rest_fax='".mysql_real_escape_string($_POST['restaurant_fax_res'])."' WHERE rest_id=".$_SESSION['rest_id'];
					 
		$sql_rest_info = "UPDATE ".$prev."resturant_info SET 
		rest_info='".mysql_real_escape_string($_POST['restaurant_description_res'])."',
		rest_pickup='".mysql_real_escape_string($_POST['restaurant_pickup'])."',
		rest_booktable='".mysql_real_escape_string($_POST['restaurant_booktable'])."',
		rest_order=".mysql_real_escape_string($_POST['restaurant_minorder_price_res']).",
		rest_tax=".mysql_real_escape_string($_POST['restaurant_salestax_res']).",
		rest_cuisine='".mysql_real_escape_string($_POST['restaurant_serving_cuisines_res'])."' WHERE rest_id=".$_SESSION['rest_id'];
		if(mysql_query($sql_rest_contact) && mysql_query($sql_rest_info))
		{
			echo "<strong style='color:#006600;'>Restaurant Info updated successfully</strong>";
		}
	}

/**************** RESTAURANT INFO UPDATE END **********************/	

/**************** RESTAURANT DELIVERY INFO START **********************/	

if(isset($_POST['action']) && $_POST['action']=='REST_DEL_UPDATE')
	{
		$sql_rest_del="UPDATE ".$prev."resturant_delivery_info SET 
		rest_del='".mysql_real_escape_string($_POST['restaurant_delivery'])."',
		rest_time='".mysql_real_escape_string($_POST['restaurant_estimated_time_res'])."',
		rest_del_charge='".mysql_real_escape_string($_POST['restaurant_delivery_charge_res'])."',
		rest_zip_code='".mysql_real_escape_string($_POST['restaurant_delivery_areas_res'])."' 
		WHERE rest_id=".$_SESSION['rest_id'];
					 
		
		if(mysql_query($sql_rest_del))
		{
			echo "<strong style='color:#006600;'>Restaurant Delivery Info updated successfully</strong>";
		}
	}

/**************** RESTAURANT DELIVERY INFO END **********************/

/**************** MAP URL START **********************/	

if(isset($_POST['action']) && $_POST['action']=='REST_MAP_UPDATE')
	{
		$map_url=$_POST['map_url'];
		$sql_rest_map="UPDATE ".$prev."restaurant SET 
		map_url='$map_url' WHERE rest_id=".$_SESSION['rest_id'];
					 
		if(mysql_query($sql_rest_map))
		{
			echo "<strong style='color:#006600;'>Map Url updated successfully</strong>";
		}
	}

/**************** MAP URL END **********************/

/**************** RESTAURANT TIME START **********************/	

if(isset($_POST['action']) && $_POST['action']=='REST_UPDATE_OPEN_CLOSE')
	{
	if($_POST['rest_time_open']=='Open')
	{
			$del=mysql_query("DELETE FROM ".$prev."resturant_days WHERE rest_id='".$_SESSION['rest_id']."' AND action='Open'");
				if($del){
					$day=$_POST['day'];
			$restaurant_delivery_open_hr=$_POST['restaurant_delivery_open_hr'];
			$restaurant_delivery_open_min=$_POST['restaurant_delivery_open_min'];
			$restaurant_delivery_open_sess=$_POST['restaurant_delivery_open_sess'];
			for($i=0;$i<count($restaurant_delivery_open_hr);$i++)
		 {
			$time[$i] = $restaurant_delivery_open_hr[$i]." : ".$restaurant_delivery_open_min[$i]." : ".$restaurant_delivery_open_sess[$i];
			if($restaurant_delivery_open_hr[$i]!='')
			{
				$sql_insert_date=mysql_query("INSERT INTO ".$prev."resturant_days SET rest_id='".$_SESSION['rest_id']."',action='".$_REQUEST['rest_time_open']."',day='".$day[$i]."',time='".$time[$i]."'");
			}
		 }
				}
				
	}
	if($_POST['rest_time_close']=='Close')
	{
		
	$del=mysql_query("DELETE FROM ".$prev."resturant_days WHERE rest_id='".$_SESSION['rest_id']."' AND action='Close'");
			if($del){
				$day=$_POST['day'];
	 $restaurant_delivery_close_hr=$_POST['restaurant_delivery_close_hr'];
	 $restaurant_delivery_close_min=$_POST['restaurant_delivery_close_min'];
	 $restaurant_delivery_close_sess=$_POST['restaurant_delivery_close_sess'];
	 
	 for($i=0;$i<count($restaurant_delivery_close_hr);$i++)
	 {
		$time[$i] = $restaurant_delivery_close_hr[$i]." : ".$restaurant_delivery_close_min[$i]." : ".$restaurant_delivery_close_sess[$i];
		if($restaurant_delivery_close_hr[$i]!='')
		{
			$sql_insert_date=mysql_query("INSERT INTO ".$prev."resturant_days SET rest_id='".$_SESSION['rest_id']."',action='".$_REQUEST['rest_time_close']."',day='".$day[$i]."',time='".$time[$i]."'");
		}
	 }
			}
			
	}

  }


/**************** RESTAURANT TIME END **********************/

/**************** RESTAURANT PHOTO START **********************/	

if(isset($_POST['action']) && $_POST['action']=='REST_DEL_PHOTO_UPDATE')
	{
		$sql_rest_photo="UPDATE ".$prev."resturant_photo SET 
		rest_disp_photo='".mysql_real_escape_string($_POST['restaurant_display_photo'])."',
		rest_disp_video='".mysql_real_escape_string($_POST['restaurant_display_video'])."',
		rest_disp_banner='".mysql_real_escape_string($_POST['restaurant_display_banner'])."'
		WHERE rest_id=".$_SESSION['rest_id'];
		
		if(mysql_query($sql_rest_photo))
		{
			echo "<strong style='color:#006600;'>Restaurant Photo updated successfully</strong>";
		}
	}

/**************** RESTAURANT PHOTO ENd **********************/	
?>