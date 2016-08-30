<?php
ob_start();
session_start();
require_once("../configs/path.php");

 if(isset($_REQUEST['rest_id']))
 	{
		$idVal=$_REQUEST['chk'];
		foreach ($idVal as $value)
		{
			$sql="SELECT count(`rest_info_id`) cnt FROM ".$prev."resturant_info where `rest_id`='$value'";
			$result=mysql_query($sql);
			$inUse=mysql_fetch_object($result);
			if($inUse==0)
			{
				$sql="delete from ".$prev."restaurant where rest_id=$value";
				$result=mysql_query($sql);
				
			}
			
			else
			{
				$_SESSION["err_message"]="Record already in used.";
				pageRedirect('manage_restaurant.php?menuid=105&menupid=103');
			}
		}
		if($result){
				  $_SESSION["succ_message"]="Records delete successfully.";
				  pageRedirect('manage_restaurant.php?menuid=105&menupid=103');
				}
	}
   if(isset($_REQUEST['cat_id']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		foreach ($idVal as $value)
		{
			//$inUse=$wpdb->get_var("SELECT count(`state_id`) FROM es_ad_post where `state_id`='$value'");
			if($inUse==0)
			{	
				$sql="delete from ".$prev."category where cat_id=$value";
				$result=mysql_query($sql);
				
			}
			else
			{
				//wp_redirect('admin.php?page=states&del_msg=2'); 
			}
		}
		if($result){
				  $_SESSION["succ_message"]="Records delete successfully.";
				  pageRedirect('category.type.list.php?menuid=122&menupid=120');
		}
	}	
	
	if(isset($_REQUEST['offer_id']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		//print_r($idVal);
		//die();
		foreach ($idVal as $value)
		{
			//$inUse=$wpdb->get_var("SELECT count(`state_id`) FROM es_ad_post where `state_id`='$value'");
			if($inUse==0)
			{	
				$sql="delete from ".$prev."offer where offer_id=$value";
				$result=mysql_query($sql);
				
			}
			else
			{
				//wp_redirect('admin.php?page=states&del_msg=2'); 
			}
		}
		if($result){
			$_SESSION["succ_message"]="Records delete successfully.";
			pageRedirect('manage_offer.php?menuid=107&menupid=103');
		}
		
	}
	
	if(isset($_REQUEST['addons_id']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		//print_r($idVal);
		//die();
		foreach ($idVal as $value)
		{
			//$inUse=$wpdb->get_var("SELECT count(`state_id`) FROM es_ad_post where `state_id`='$value'");
			if($inUse==0)
			{	
				$sql_addon="delete from ".$prev."addons where addons_id=$value";
				$result_addon=mysql_query($sql_addon);
				$sql_sub_addon="delete from ".$prev."sub_addons where addons_id=$value";
				$result_sub_addon=mysql_query($sql_sub_addon);
				
			}
			else
			{
				//wp_redirect('admin.php?page=states&del_msg=2'); 
			}
		}
		if($result_addon && $result_sub_addon){
			$_SESSION["succ_message"]="Addons and Subddons delete successfully.";
			pageRedirect('addons.list.php?menuid=127&menupid=125');
		}
		
	}
	
	if(isset($_REQUEST['cuisine_id']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		foreach ($idVal as $value)
		{
			//$inUse=$wpdb->get_var("SELECT count(`state_id`) FROM es_ad_post where `state_id`='$value'");
			if($inUse==0)
			{	
				$sql_cuisine="delete from ".$prev."cuisine where cuisine_id=$value";
				$result_cuisine=mysql_query($sql_cuisine);
			}
			else
			{
				//wp_redirect('admin.php?page=states&del_msg=2'); 
			}
		}
		if($result_cuisine){
			$_SESSION["succ_message"]="Addons and Subddons delete successfully.";
			pageRedirect('couisine.list.php?menuid=119&menupid=117');
		}
		
	}
	
	if(isset($_REQUEST['zip_id']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		//print_r($idVal);
		//exit;
		foreach ($idVal as $value)
		{
			//$inUse=$wpdb->get_var("SELECT count(`state_id`) FROM es_ad_post where `state_id`='$value'");
			if($inUse==0)
			{	
				$sql_cuisine="delete from ".$prev."zip where zip_id=$value";
				$result_cuisine=mysql_query($sql_cuisine);
			}
			else
			{
				//wp_redirect('admin.php?page=states&del_msg=2'); 
			}
		}
		if($result_cuisine){
			$_SESSION["succ_message"]="All zipcodes delete successfully.";
			pageRedirect('zip.list.php?menuid=116&menupid=113');
		}
		
	}
	
	if(isset($_REQUEST['menu_id']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		//print_r($idVal);
		//exit;
		foreach ($idVal as $value)
		{
			//$inUse=$wpdb->get_var("SELECT count(`state_id`) FROM es_ad_post where `state_id`='$value'");
			if($inUse==0)
			{	
				$sql_cuisine="delete from ".$prev."menu where menu_id=$value";
				$result_cuisine=mysql_query($sql_cuisine);
			}
			else
			{
				//wp_redirect('admin.php?page=states&del_msg=2'); 
			}
		}
		if($result_cuisine){
			$_SESSION["succ_message"]="Menu delete successfully.";
			pageRedirect('manage_menu.php?menuid=106&menupid=103');
		}
		
	}
	
	if(isset($_REQUEST['state_id']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		//print_r($idVal);
		//exit;
		foreach ($idVal as $value)
		{
			//$inUse=$wpdb->get_var("SELECT count(`state_id`) FROM es_ad_post where `state_id`='$value'");
			if($inUse==0)
			{	
				$sql_cuisine="delete from ".$prev."state where state_id=$value";
				$result_cuisine=mysql_query($sql_cuisine);
			}
			else
			{
				//wp_redirect('admin.php?page=states&del_msg=2'); 
			}
		}
		if($result_cuisine){
			$_SESSION["succ_message"]="All states deleted successfully.";
			pageRedirect('state.list.php?menuid=114&menupid=113');
		}
		
	}
	if(isset($_REQUEST['city_id']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		//print_r($idVal);
		//exit;
		foreach ($idVal as $value)
		{
			//$inUse=$wpdb->get_var("SELECT count(`state_id`) FROM es_ad_post where `state_id`='$value'");
			if($inUse==0)
			{	
				$sql_cuisine="delete from ".$prev."city where city_id=$value";
				$result_cuisine=mysql_query($sql_cuisine);
			}
			else
			{
				//wp_redirect('admin.php?page=states&del_msg=2'); 
			}
		}
		if($result_cuisine){
			$_SESSION["succ_message"]="All cities deleted successfully.";
			pageRedirect('city.list.php?menuid=116&menupid=113');
		}
		
	}
	
	if(isset($_REQUEST['OrderID']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		//print_r($idVal);
		//exit;
		foreach ($idVal as $value)
		{
				
			    $sql_order="delete from ".$prev."orders where OrderID=$value";
				$result_order=mysql_query($sql_order);
				if($result_order){
					$sql_cart=mysql_query("delete from ".$prev."cart where OrderID=$value")	;
				}
				
			
		}
		if($result_order){
			$_SESSION["succ_message"]="All selected order deleted successfully.";
			pageRedirect('manage_order.php?menuid=108&menupid=103');
		}
		
	}
	
	if(isset($_REQUEST['delivery_id']))
 	{
		$idVal=$_REQUEST['chk'];
		$inUse=0;
		//print_r($idVal);
		//exit;
		foreach ($idVal as $value)
		{
				
			    $sql_delivery="delete from ".$prev."delivery_code where id=$value";
				$result_delivery=mysql_query($sql_delivery);
		}
		if($result_delivery){
			$_SESSION["succ_message"]="All selected order deleted successfully.";
			pageRedirect('delivery_code_list.php?menuid=135&menupid=113');
		}
		
	}
	
?>