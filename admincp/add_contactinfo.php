 <?php
 $rest_id='';
 //print_r($_SESSION);
 	if(isset($_GET['rest_id']))
		{
			$rest_id=$_GET['rest_id'];
			$_SESSION['rest_id']=$rest_id;
			$sql="SELECT * FROM ".$prev."restaurant where rest_id='".$rest_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$restaurant_name=$row->rest_name;
			$restaurant_phone=$row->rest_phone;
			$restaurant_website=$row->rest_website;
			$restaurant_fax=$row->rest_fax;
			$restaurant_streetaddress=$row->rest_address;
			$state_id=$row->state_id;
			$city_id=$row->city_id;
			$zip_id=$row->zip_id;
			$delivery_code=$row->delivery_code;
			$delivery_code=explode(',',$delivery_code);
			//print_r($delivery_code);
			
			$restaurant_contact_name=$row->rest_contact_name;
			$restaurant_contact_phone=$row->rest_contact_phone;
			$restaurant_contact_email=$row->rest_contact_email;
			$restaurant_cloud_printer_email=$row->rest_printer_email;
		}
 	
	if(isset($_POST['CONTACT_INFO']))
		{
			$rest_id=$_POST['rest_id'];
			
			$restaurant_name=mysql_real_escape_string(trim($_REQUEST['restaurant_name']));
			$restaurant_phone=mysql_real_escape_string(trim($_REQUEST['restaurant_phone']));
			$restaurant_website=mysql_real_escape_string(trim($_REQUEST['restaurant_website']));
			$restaurant_fax=mysql_real_escape_string(trim($_REQUEST['restaurant_fax']));
			$restaurant_streetaddress=mysql_real_escape_string(trim($_REQUEST['restaurant_streetaddress']));
			$restaurant_contact_name=mysql_real_escape_string(trim($_REQUEST['restaurant_contact_name']));
			$restaurant_contact_phone=mysql_real_escape_string(trim($_REQUEST['restaurant_contact_phone']));
			$restaurant_contact_email=mysql_real_escape_string(trim($_REQUEST['restaurant_contact_email']));
			$restaurant_password=mysql_real_escape_string(trim($_REQUEST['restaurant_password']));
			$restaurant_cloud_printer_email=mysql_real_escape_string(trim($_REQUEST['restaurant_cloud_printer_email']));
			$restaurant_cloud_printer_password=mysql_real_escape_string(trim($_REQUEST['restaurant_cloud_printer_password']));
			$state_id=$_POST['state_id'];
			$city_id=$_POST['city_id'];
			$zip_id=$_POST['zip_id'];
			$delivery_code=$_POST['delivery_code'];
			$delivery_code=implode(',',$delivery_code);
			//echo $delivery_code;
			$cur_date=date('Y-m-d');
			
			$flag=0;
				if($restaurant_name=='')
					{
					$err_restaurant_name="Please enter Restaurant Name";
					$flag=1;
					}
				if($restaurant_phone=='')
				{
					$err_restaurant_phone="Please enter Restaurant Phone";
					$flag=1;
				}
				
				if($restaurant_streetaddress=='')
				{
					$err_restaurant_streetaddress="Please enter Restaurant Street Address";
					$flag=1;
				}
				if($state_id=='')
				{
					$err_state_id="Please enter Restaurant State";
					$flag=1;
				}
				if($city_id=='')
				{
					$err_city_id="Please enter Restaurant City";
					$flag=1;
				}
				if($zip_id=='')
				{
					$err_city_id="Please enter Restaurant Zipcode";
					$flag=1;
				}
				if($restaurant_contact_name=='')
				{
					$err_restaurant_contact_name="Please enter Restaurant Contact Name";
					$flag=1;
				}
				if($restaurant_contact_phone=='')
				{
					$err_restaurant_contact_phone="Please enter Restaurant Contact Phone";
					$flag=1;
				}
				if($restaurant_password=='')
				{
					$err_restaurant_passworde="Please enter Restaurant Password";
					$flag=1;
				}

	//=========================================For Save Query=======================================
				if($flag==0 && $rest_id=="")
				{
					
					$sql_rest="INSERT INTO ".$prev."restaurant (`rest_name`,`rest_phone`,`rest_website`,`rest_fax`,`rest_address`,`rest_contact_name`,`rest_contact_phone`,`rest_password`,`rest_contact_email`,`rest_printer_email`,`rest_printer_pass`,`cur_date`,`state_id`,`city_id`,`zip_id`,`delivery_code`)
					 VALUES('".$restaurant_name."','".$restaurant_phone."','".$restaurant_website."','".$restaurant_fax."','".$restaurant_streetaddress."','".$restaurant_contact_name."','".$restaurant_contact_phone."','".$restaurant_password."','".$restaurant_contact_email."','".$restaurant_cloud_printer_email."','".$restaurant_cloud_printer_password."','".$cur_date."','".$state_id."','".$city_id."','".$zip_id."','".$delivery_code."')";
					$result=mysql_query($sql_rest);
					$_SESSION['rest_id']=mysql_insert_id();
					$_SESSION['page_name']='restaurant_info.php';
					if($result)
					   {
						 
						 ?>
                        <script>
						$(function() {
						//$( "#tabs" ).tabs();
						$("#tabs").tabs({disabled: [0,2,3,4,5]});
						$("#tabs").tabs( "enable" , 1 ); 
						$('#tabs').tabs({ active: 1 });
						
						});
						</script>
                         <?php  
						//$msg='Value added successfully';
						//pageRedirect('add_restaurant.php');
					   }
				}
				
					
	//================================End Save=====================================================		
	//=========================================Update Query=======================================
				/*if($flag==0 && $rest_id<>"")
				{
					$sql_update="UPDATE `customer` SET `customer_name`='$customer_name',`customer_address`='$customer_address',`vat_no`='$vat_no',`cst_no`='$cst_no' WHERE `id`='$cust_id'";
					$result_update=mysql_query($sql_update);*/
					//if($result_update)
						/*echo '<script>top.location.reload()</script>'; */
				/*}*/
				if($flag==0 && $rest_id<>"")
				{
					
					/*$sql_rest="UPDATE ".$prev."restaurant (`rest_name`,`rest_phone`,`rest_website`,`rest_fax`,`rest_address`,`rest_contact_name`,`rest_contact_phone`,`rest_password`,`rest_contact_email`,`rest_printer_email`,`rest_printer_pass`,`cur_date`,`state_id`,`city_id`,`zip_id`)
					 VALUES('".$restaurant_name."','".$restaurant_phone."','".$restaurant_website."','".$restaurant_fax."','".$restaurant_streetaddress."','".$restaurant_contact_name."','".$restaurant_contact_phone."','".$restaurant_password."','".$restaurant_contact_email."','".$restaurant_cloud_printer_email."','".$restaurant_cloud_printer_password."','".$cur_date."','".$state_id."','".$city_id."','".$zip_id."')";*/
					 $sql_rest="UPDATE ".$prev."restaurant SET 
					 rest_name='".$restaurant_name."',
					 rest_phone='".$restaurant_phone."',
					 rest_website='".$restaurant_website."',
					 rest_fax='".$restaurant_fax."',
					 rest_address='".$restaurant_streetaddress."',
					 rest_contact_name='".$restaurant_contact_name."',
					 rest_contact_phone='".$restaurant_contact_phone."',
					 rest_password='".$restaurant_password."',
					 rest_contact_email='".$restaurant_contact_email."',
					 rest_printer_email='".$restaurant_cloud_printer_email."',
					 rest_printer_pass='".$restaurant_cloud_printer_password."',
					 cur_date='".$cur_date."',
					 state_id='".$state_id."',
					 city_id='".$city_id."',
					 zip_id='".$zip_id."' WHERE rest_id=".$rest_id;
					$result=mysql_query($sql_rest);
					$_SESSION['rest_id']=$rest_id;
					$_SESSION['page_name']='restaurant_info.php';
					if($result)
					   {
						 
						 ?>
                        <script>
						$(function() {
						//$( "#tabs" ).tabs();
						/*$("#tabs").tabs({disabled: [0,2,3,4,5]});*/
						$("#tabs").tabs( "enable" , 1 ); 
						$('#tabs').tabs({ active: 1 });
						});
						</script>
                         <?php  
						//$msg='Value added successfully';
						//pageRedirect('add_restaurant.php');
					   }
				}
	//=========================================End Update Query=======================================
		}
?>
<script>
function addRestaurantValidate() {
	var txt = '';
	
	if(document.getElementById('restaurant_name').value == "") {
			$("#resNameErr").html("Please enter Restaurant Name");
			txt ='err';
		}else{
			$("#resNameErr").html("");
	}
	if(document.getElementById('restaurant_phone').value == "") {
			$("#resPhoneErr").html("Please enter Restaurant Phone");
			txt ='err';
		}else{
			$("#resPhoneErr").html("");
	}
	if(document.getElementById('restaurant_streetaddress').value == "") {
			$("#resStrErr").html("Please enter Restaurant Street Address");
			txt ='err';
		}else{
			$("#resStrErr").html("");
	}
	if(document.getElementById('state_id').value == "") {
			$("#resStaErr").html("Please enter Restaurant State");
			txt ='err';
		}else{
			$("#resStaErr").html("");
	}
	if(document.getElementById('city_id').value == "") {
			$("#resCitErr").html("Please enter Restaurant City");
			txt ='err';
		}else{
			$("#resCitErr").html("");
	}
	if(document.getElementById('zip_id').value == "") {
			$("#resZipErr").html("Please enter Restaurant Zipcode");
			txt ='err';
		}else{
			$("#resZipErr").html("");
	}
	if(document.getElementById('restaurant_contact_name').value == "") {
			$("#resCntNameErr").html("Please enter Restaurant Contact Name");
			txt ='err';
		}else{
			$("#resCntNameErr").html("");
	}
	if(document.getElementById('restaurant_contact_phone').value == "") {
			$("#resCntPhoneErr").html("Please enter Restaurant Contact Phone");
			txt ='err';
		}else{
			$("#resCntPhoneErr").html("");
	}
		

	
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(!regex.test(document.getElementById('restaurant_contact_email').value) && document.getElementById('restaurant_contact_email').value!=""){
		$("#resEmailErr").html("Please insert a valid email.");
		txt ='err';
	}else{
		$("#resEmailErr").html("");
	}
	if(document.getElementById('restaurant_password').value == "") {
			$("#resPswdErr").html("Please enter Restaurant Password");
			txt ='err';
		}else{
			$("#resPswdErr").html("");
	}
	
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}

$(document).ready(function(){
	$('#state_id').change(function(){
		var state_id=$(this).val(); 
		//alert(state_id);
		
	  	var dataString='state_id='+state_id;
				 $.ajax({
					type:"POST",
					data:dataString,
					url:"<?=$vpath?>ajax/get_city.php",
					success:function(return_data)
					{
						$('#ajax_city').html(return_data);
					}
				});
			
		});
		
	});
</script>

 <script>
$(function() {
$( document ).tooltip();
});
</script>


<form name="addNewRestaurant" method="post" action="" onsubmit="return addRestaurantValidate();" enctype="multipart/form-data">
    <input type="hidden" name="rest_id" id="rest_id" value="<?= $rest_id?>">
    
<div class="restInnerTab">
	<!--Restaurant Name-->
	<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
	<div class="addPageCont">
		<span class="addPageRightFont">Restaurant Name <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_name" id="restaurant_name" value="<?= $restaurant_name?>"  />
		<script>document.addNewRestaurant.restaurant_name.focus();</script>
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant name">?</div></div>
		<span class="errClass" id="resNameErr"><?= $err_restaurant_name ?></span>
	</div>
	
	<!--Restaurant Phone-->
	<div class="addPageCont">
		<span class="addPageRightFont">Restaurant Phone <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_phone" id="restaurant_phone" value="<?= $restaurant_phone?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant phone number">?</div></div>
		<span class="errClass" id="resPhoneErr"><?= $err_restaurant_phone ?></span>
	</div>
	
	<!--Restaurant Website-->
	<div class="addPageCont">
		<span class="addPageRightFont">Restaurant Website </span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_website" id="restaurant_website" value="<?= $restaurant_website?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant website">?</div></div>
		<span class="errClass" id="resWebErr"></span>
	</div>
	
	<!--Restaurant Fax-->
	<div class="addPageCont">
		<span class="addPageRightFont">Restaurant Fax </span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_fax" id="restaurant_fax" value="<?= $restaurant_fax?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant fax">?</div></div>
		<span class="errClass" id="resFaxErr"></span>
	</div>
	
	<!--Restaurant Street Address-->
	<div class="addPageCont">
		<span class="addPageRightFont">Restaurant Street Address <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_streetaddress" id="restaurant_streetaddress" value="<?= $restaurant_streetaddress?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant street address">?</div></div>
		<span class="errClass" id="resStrErr"><?= $err_restaurant_streetaddress ?></span>
	</div>
	
	<!--Restaurant State-->
	<div class="addPageCont">
		<span class="addPageRightFont">State <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<select class="selectbx" name="state_id" id="state_id">
			<option value="">-Select-</option>
						<?php
						$sql_state=mysql_query("SELECT `state_id`,`state_name` FROM ".$prev."state WHERE status='Y'");
						if(mysql_num_rows($sql_state)){
						  while($row=mysql_fetch_object($sql_state)){?>
								<option value="<?= $row->state_id?>" <?php if($state_id==$row->state_id){?> selected='selected' <?php }?>><?= $row->state_name?></option>  
						  <?php }
						  mysql_free_result($sql_state);
						}
						?>
					</select>
		<div class="tooltip"><div class="HelpButton" title="Select restaurant state">?</div></div>
		<span class="errClass" id="resStaErr"><?= $err_state_id ?></span>
	</div>
	
	<!--Restaurant City-->
	<div class="addPageCont">
	<span id="showResCityList">
		<span class="addPageRightFont">City <span class="color1">*</span></span>
		<span class="colon1">:</span>
        <div id="ajax_city">
		<select class="selectbx" name="city_id" id="city_id">
		<option value="">-Select-</option>
        <?php if($city_id){
        
						$sql=mysql_query("SELECT `city_id`,`city_name` FROM ".$prev."city WHERE status='Y'");
						if(mysql_num_rows($sql)){
						  while($row=mysql_fetch_object($sql)){?>
								<option value="<?= $row->city_id?>" <?php if($city_id==$row->city_id){?> selected="selected" <?php }?>><?= $row->city_name?></option>  
						  <?php }
						  mysql_free_result($sql);
						}
				}?>
        
		</select>
        </div>
		<div class="tooltip"><div class="HelpButton" title="Select restaurant city">?</div></div>
		<span class="errClass" id="resCitErr"><?= $err_city_id ?></span>
	</span>
		<!--<input class="textbox" type="text" name="restaurant_city" id="restaurant_city" value="" />-->
		
	</div>
	
	<!--Restaurant Zip-->
	<div class="addPageCont">
	<span id="showResZipList">
		<span class="addPageRightFont">Zip <span class="color1">*</span></span>
		<span class="colon1">:</span>
        <div id="ajax_zip">
		<select class="selectbx" name="zip_id" id="zip_id" >
			<option value="">--Select--</option>
            <?php if($zip_id){
        
						$sql=mysql_query("SELECT `zip_id`,`area_name`,`zip_code` FROM ".$prev."zip WHERE status='Y'");
						if(mysql_num_rows($sql)){
						  while($row=mysql_fetch_object($sql)){?>
								<option value="<?= $row->zip_id?>" <?php if($zip_id==$row->zip_id){?> selected="selected" <?php }?>><?= $row->zip_code.' - '.$row->area_name;?></option>  
						  <?php }
						  mysql_free_result($sql);
						}
			}?>
					</select>
        </div>
		<div class="tooltip"><div class="HelpButton" title="Select restaurant zipcode">?</div></div>
		<span class="errClass" id="resZipErr"><?= $err_city_id ?></span>
	</span>
		
	</div>
    
    <!--Restaurant Delivery Code-->
    
      <?php if(count($delivery_code)>0){
		  
		  ?>
     <div class="addPageCont">
	<span id="showResZipList">
		<span class="addPageRightFont">Delivery Code <span class="color1">*</span></span>
		<span class="colon1">:</span>
        <div id="ajax_zip">
        <div id="ajax_deliver_code">
	
            <?php //if($delivery_code){
        
						$sql=mysql_query("SELECT `id`,`delivery_code` FROM ".$prev."delivery_code WHERE status='Y' AND state_id=".$state_id." AND city_id=".$city_id." AND zip_id=".$zip_id."");
						if(mysql_num_rows($sql)){
						  while($row=mysql_fetch_object($sql)){?>
                          <input type="checkbox" value="<?= $row->delivery_code?>" name="delivery_code[]" <?php if (in_array($row->delivery_code, $delivery_code)){?> checked="checked" <?php }?> /><?= $row->delivery_code?>
								
						  <?php }
						  mysql_free_result($sql);
						}
		//	}?>
			</div>		
        </div>
		<div class="tooltip"><div class="HelpButton" title="Select delivery code">?</div></div>
		<span class="errClass" id="resZipErr"><?= $err_city_id ?></span>
	</span>
		
	</div>
    <?php }
	else{
	?>
         <div class="addPageCont">
	<span id="showResZipList">
		<span class="addPageRightFont">Delivery Code <span class="color1">*</span></span>
		<span class="colon1">:</span>
        <div id="ajax_zip">
        <div id="ajax_deliver_code">
	
       
			</div>		
        </div>
		<div class="tooltip"><div class="HelpButton" title="Select delivery code">?</div></div>
		<span class="errClass" id="resZipErr"><?= $err_city_id ?></span>
	</span>
		
	</div>
    <?php }?>
	
	
	<!--Restaurant Contact Name-->
	<div class="addPageCont">
		<span class="addPageRightFont">Contact Name <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_contact_name" id="restaurant_contact_name" value="<?= $restaurant_contact_name?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant contact name">?</div></div>
		<span class="errClass" id="resCntNameErr"></span>
	</div>
	
	<!--Restaurant Contact Phone-->
	<div class="addPageCont">
		<span class="addPageRightFont">Contact Phone <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_contact_phone" id="restaurant_contact_phone" value="<?= $restaurant_contact_phone?>" maxlength="15"/>
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant contact phone">?</div></div>
		<span class="errClass" id="resCntPhoneErr"><?= $err_restaurant_contact_phone ?></span>
	</div>
	
	<!--Restaurant Contact Email-->
	<div class="addPageCont">
		<span class="addPageRightFont">Contact Email <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_contact_email" id="restaurant_contact_email" value="<?= $restaurant_contact_email?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant contact email id">?</div></div>
		<span class="errClass" id="resEmailErr"><?= $err_restaurant_contact_email ?></span>
	</div>
	
	<!--Restaurant Password-->
	<div class="addPageCont">
		<span class="addPageRightFont">Password <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="password" name="restaurant_password" id="restaurant_password" value="" placeholder="Update Password"/>
		<div class="tooltip"><div class="HelpButton" title="Enter password">?</div></div>
		<span class="errClass" id="resPswdErr"><?= $err_restaurant_password ?></span>
	</div>
	
	<!-- Cloud printer Email -->

	<div class="addPageCont">
		<span class="addPageRightFont">Cloud Printer Email </span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_cloud_printer_email" id="restaurant_cloud_printer_email" value="<?= $restaurant_cloud_printer_email?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter Cloud printer email">?</div></div>
		<span class="errClass" id="resPswdErr"></span>
	</div>
	
	<!-- Cloud printer password -->
	<div class="addPageCont">
		<span class="addPageRightFont">Cloud Printer Password </span>
		<span class="colon1">:</span>
		<input class="textbox" type="password" name="restaurant_cloud_printer_password" id="restaurant_cloud_printer_password" value="" placeholder="Update Password"/>
		<div class="tooltip"><div class="HelpButton" title="Enter cloud printer password">?</div></div>
		<span class="errClass" id="resPswdErr"></span>
	</div>
	
</div>
<div class="buttonCont_restaurant">
			<input type="submit" name="CONTACT_INFO" class="button" value="<?=($rest_id!=0)?'Update':'Add'?>"> 
			<a class="CanceButton" href="restaurantManage.php">Cancel</a>
		</div>
		</form>