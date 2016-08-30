<?php
session_start();
include("includes/access.php");
include("includes/header.php");

//================================For Resturant Select=================================================	
  $sql = "SELECT rest_id,rest_name FROM ".$prev."restaurant where status='Y'";
  $result = mysql_query($sql);
//================================For Resturant Select End==============================================
//================================For Cuisine Select====================================================	
  $sqlCuisine = "SELECT cuisine_id,cuisine_name FROM ".$prev."cuisine where cuisine_status='Y'";
  $resultCuisine = mysql_query($sqlCuisine);
//================================For Cuisine Select End================================================
    $menu_id = 0;
	$ur="../menu_photo/";
  	if(isset($_GET['menu_id']))
		{
			$menu_id = $_GET['menu_id'];
			//echo $menu_id;exit; 
			$eid = $_GET['eid'];
			$Menusql = "SELECT * FROM ".$prev."menu WHERE menu_id='".$menu_id."'";
			$Menuresult = mysql_query($Menusql);
			$row = mysql_fetch_object($Menuresult);
			//print_r($row);exit;
			$resturant_id = $row->rest_id;
			$menu_name = $row->memu_name;
			$menu_type = $row->menu_type;
			$cuisine_id = $row->cuisine_id;
			$sizeoption = $row->sizeoption;
			$menu_price = $row->menu_price;
			$small = $row->small;
			$smallval = $row->smallval;
			$medium = $row->medium;
			$mediumval = $row->mediumval;
			$large = $row->large;
			$largeval = $row->largeval;
			$cat_id = $row->cat_id;
			$menu_addons = $row->menu_addons;
			$menu_spl_ins = $row->menu_spl_ins;
			$menu_description = $row->menu_description;
			$menu_photo = $row->menu_photo;
			$menu_popular_dish = $row->menu_popular_dish;
			$menu_spicy = $row->menu_spicy;
			$sizename = $row->sizename;
			$sizeval = $row->sizeval;
		}

  if(isset($_POST['addEdit']))
		{
			$menu_id = $_POST['menu_id'];
			
			$restaurant_name = mysql_real_escape_string(trim($_REQUEST['restaurant_name']));
			$menu_name = mysql_real_escape_string(trim($_REQUEST['menu_name']));
			$menu_type = mysql_real_escape_string(trim($_REQUEST['menu_type']));
			$menu_cuisine = mysql_real_escape_string(trim($_REQUEST['menu_cuisine']));
			$menu_price = mysql_real_escape_string(trim($_REQUEST['menu_price']));
			$menu_category = mysql_real_escape_string(trim($_REQUEST['menu_category']));
			if($menu_category == 'other')
			 {
			   $menu_catothers = mysql_real_escape_string(trim($_REQUEST['menu_catothers']));
			 }
			$menu_addons = mysql_real_escape_string(trim($_REQUEST['menu_addons']));
			$menu_spl_ins = mysql_real_escape_string(trim($_REQUEST['menu_spl_ins']));
			$menu_description = mysql_real_escape_string(trim($_REQUEST['menu_description']));
			$menu_popular_dish = mysql_real_escape_string(trim($_REQUEST['menu_popular_dish']));
			$menu_spicy = mysql_real_escape_string(trim($_REQUEST['menu_spicy']));
			$sizeoption = mysql_real_escape_string(trim($_REQUEST['sizeoption']));
            $cur_date=date('Y-m-d');			
			if($sizeoption == 'fixed')
			 {
			   $menu_price = mysql_real_escape_string(trim($_REQUEST['menu_price']));
			 }
			 else if($sizeoption == 'default')
			 {
			   $small = mysql_real_escape_string(trim($_REQUEST['small']));
			   $medium = mysql_real_escape_string(trim($_REQUEST['medium']));
			   $large = mysql_real_escape_string(trim($_REQUEST['large']));
				   if($small == 'small' ||$medium == 'medium' || $large == 'large')
					{
					  $smallval = mysql_real_escape_string(trim($_REQUEST['smallval']));
					  $mediumval = mysql_real_escape_string(trim($_REQUEST['mediumval']));
					  $largeval = mysql_real_escape_string(trim($_REQUEST['largeval']));
					}
                    					
				
			 }
             else
              {
                 $morepizzasize = $_REQUEST['morepizzasize'];
				 for($i=0;$i<count($morepizzasize);$i++)
                	{
					  $sizename[] = $morepizzasize[$i]['sizename'];
					  $sizevalue[] = $morepizzasize[$i]['sizevalue'];
					}
                  $sizeNameString = implode(",", $sizename);	
                  $sizeValString = implode(",", $sizevalue);			  
				
			  }			 
		     $flag=0;
			 $flagother=0;
				if($restaurant_name=='')
				{
					$err_restaurant_name="Please Select Restaurant Name";
					$flag=1;
				}
				if($menu_name=='')
				{
					$err_menu_name="Please enter Menu Name";
					$flag=1;
				}
				
				if($menu_type=='')
				{
					$err_menu_type="Please Select Menu Type";
					$flag=1;
				}
				/*if($menu_cuisine=='')
				{
					$err_cuisine="Please Select Cuisine";
					$flag=1;
				}
				if($menu_price=='')
				{
					$error_menu_price="Please enter Price";
					$flag=1;
				}*/
				if($menu_category == '')
				{
					$err_menu_category="Please Select Menu Category";
					$flag=1;
				}
				if($menu_category == 'other' && $menu_catothers == '')
				{
					$err_menu_category_other="Please Enter other Category";
					$flagother=1;
				}
				if($menu_addons=='')
				{
					$err_menu_addons="Please Choose Addons";
					$flag=1;
				}
				if($menu_spl_ins=='')
				{
					$err_menu_spl_ins="Please Choose Special Instruction";
					$flag=1;
				}
				if($menu_description=='')
				{
					$err_menu_description="Please enter Menu Description";
					$flag=1;
				}
			/*	if(!is_uploaded_file($_FILES['menu_photo']['tmp_name']))
				{
				  	$menu_photo_errormsg = "Please Choose photo";
					$flag=1;
				}*/
				if($menu_popular_dish=='')
				{
					$err_menu_popular_dish="Please Choose popular Dish";
					$flag=1;
				}
				if($menu_spicy=='')
				{
					$err_menu_spicy="Please Choose Spicy Dish";
					$flag=1;
				}
			//==========================Populate new category===============================
			    if($flagother == 0 && $menu_id == 0 && $menu_category=='')
				 {
				    $cat_option = 1;
					$cat_status = 'Y';
				  	$sql_other = "INSERT INTO ".$prev."category (`rest_id`,`cat_name`,`cat_option`,`cur_date`,`status`)
					 VALUES('".$restaurant_name."','".$menu_catothers."','".$cat_option."','".$cur_date."','".$cat_status."')";
					//exit;
					$result = mysql_query($sql_other);
					$menu_category = mysql_insert_id();
				 }
			//==========================Populate new category End=============================
		    //==========================Add new Menu==========================================
			//echo $flag;
				if($flag == 0 && $menu_id == 0)
				{ 
					$sql_menu_add = "INSERT INTO ".$prev."menu (`rest_id`,`memu_name`,`menu_type`,`cuisine_id`,`sizeoption`,`menu_price`,`small`,`smallval`,`medium`,`mediumval`,`large`,`largeval`,`cat_id`,`menu_addons`,`menu_spl_ins`,`menu_description`,`menu_popular_dish`,`menu_spicy`,`sizename`,`sizeval`,`cur_date`)
					 VALUES('".$restaurant_name."','".$menu_name."','".$menu_type."','".$menu_cuisine."','".$sizeoption."','".$menu_price."','".$small."','".$smallval."','".$medium."','".$mediumval."','".$large."','".$largeval."','".$menu_category."','".$menu_addons."','".$menu_spl_ins."','".$menu_description."','".$menu_popular_dish."','".$menu_spicy."','".$sizeNameString."','".$sizeValString."','".$cur_date."')";
					//die();
					$result_add = mysql_query($sql_menu_add);
					$menu_category = mysql_insert_id();
					if($result_add)
					 {
						//$_SESSION["succ_message"]='Menu added successful';
						//pageRedirect('manage_menu.php');
				     }		
				}
			//==========================Add new Menu End==========================================
				if($flag == 0 && $menu_id <> 0)
			//==========================Edit Menu ================================================
				{
					
				
					 $sql_menu_up = "UPDATE ".$prev."menu SET 
					 rest_id='".$restaurant_name."',
					 memu_name='".$menu_name."',
					 menu_type='".$menu_type."',
					 cuisine_id='".$menu_cuisine."',
					 sizeoption='".$sizeoption."',
					 menu_price='".$menu_price."',
					 small='".$small."',
					 smallval='".$smallval."',
					 medium='".$medium."',
					 mediumval='".$mediumval."',
					 large='".$large."',
					 largeval='".$largeval."',
					 cat_id='".$menu_category."',
					 menu_addons='".$menu_addons."',
					 menu_spl_ins='".$menu_spl_ins."',
					 menu_description='".$menu_description."',
					 menu_popular_dish='".$menu_popular_dish."',
					 menu_spicy='".$menu_spicy."',
					 sizename='".$sizeNameString."',
                     sizeval='".$sizeValString."',
					 cur_date='".$cur_date."'
					  WHERE menu_id=".$menu_id;
					$result_up = mysql_query($sql_menu_up);
					$menu_category=$menu_id;
					if($result_up)
					 {
						//$_SESSION["succ_message"] = 'Menu updated successful';
						//pageRedirect('manage_menu.php');
				     }
	            }
			//==========================Edit Menu End================================================
			//==========================Upload Photo ================================================
			if($menu_category){
					if(is_uploaded_file($_FILES['menu_photo']['tmp_name']))
				   {
						$image=explode('.',$_FILES["menu_photo"]["name"]);
						$s=$ur.$menu_category.".".end($image);
						//$pathToThumbs=$ur_thumb.$menu_category.".".end($image);
						if(move_uploaded_file($_FILES['menu_photo']['tmp_name'] , $s ))
						{
							// createThumbnail( $s, $pathToThumbs, 72 , 71 );
							 $image=$menu_category.".".end($image);
							// echo "update " . $prev . "menu set menu_photo='".$image."' where menu_id=".$menu_category;exit;
							 @mysql_query("update " . $prev . "menu set menu_photo='menu_photo/".$image."' where menu_id=".$menu_category);
							 //unlink($s);
						}
				   }
				    $_SESSION["succ_message"]='Menu added successful';
					pageRedirect('manage_menu.php?menuid=106&menupid=103&menu_id=14');
			}
		  //==========================Upload Photo End ================================================			
		}		
		
		
if($_REQUEST['menu_id'])
{
	$menu_id=$_REQUEST['menu_id'];
	$r=mysql_query("select * from ".$prev."menu where menu_id=" . $menu_id);
	$d=@mysql_fetch_array($r);
	
	$rest_id=$d['rest_id'];//by 10.09.13
	
}
  // start By 10.09.13
if($_REQUEST['rest_id']){
	$rest_id=$_REQUEST['rest_id'];
}
// end
		

?>
<script>
    function changeRestaurant()
	  {
	    //alert('asim');
		var rest_id = $('#restaurant_name').val();
		var dataString='rest_id='+rest_id;
				 $.ajax({
					type:"POST",
					data:dataString,
					url:"<?=$vpath?>ajax/get_menu_category.php",
					success:function(return_data)
					{
					    //$('#addCatMenu').hide();
						$('#addCatMenuViaAjax').html(return_data);
					}
				});
	  }
	 function fixedOption()
      {
	    $('#fixedOption').show();
		$('#pizzaOtherOption').hide();
		$('#pizzaDefaultOption').hide();
	  }	 
	 function defaultOption()
      {
	    $('#pizzaDefaultOption').show();
		$('#pizzaOtherOption').hide();
		$('#fixedOption').hide();
	  }	
	 function otherOption()
      {
	    $('#pizzaOtherOption').show();
		$('#pizzaDefaultOption').hide();
		$('#fixedOption').hide();
	  }
	  var specialsize = 0;
     function addMorePizzaSize(obj)
	 {
		if(obj!=0)
		{
		  specialsize = parseInt(obj);
		}	
	    html  = '<tbody id="specialsize' + specialsize + '">';
		html += '<tr>'; 
		html += '<td class="left" height="30" width="50%"><input type="text" name="morepizzasize['+specialsize+'][sizename]" id="sizename['+specialsize+']" class="mar4"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="morepizzasize['+specialsize+'][sizevalue]" value="" /></span></td>';	
		html += '<td class="left1"  height="30" width="20%" align="left"><a onclick="removeSlice('+specialsize+');" style="color:#f34571;cursor:pointer;margin-left:0px;"><span>Remove</span></a></td>';
		html += '</tr>';
		html += '</tbody>';
	    $('#specialPizzaSize tfoot').before(html);
		specialsize++;
     }

	function removeSlice(slice_id)
	 {	
         $('#specialsize'+ slice_id).remove();
	 }	
     function showSmallPrice()
      {
			if(document.getElementById("small").checked == true){
				$("#smallpriceshow").show();
			}else{
				$("#smallval").val('');
				$("#smallpriceshow").hide();
			}
	  }
     function showMediumPrice()
      {
		  	if(document.getElementById("medium").checked == true){
				$("#mediumpriceshow").show();
			}else{
				$("#mediumval").val('');
				$("#mediumpriceshow").hide();
			}
	  }
     function showLargePrice()
      {
		  if(document.getElementById("large").checked == true){
				$("#largepriceshow").show();
			}else{
				$("#largeval").val('');
				$("#largepriceshow").hide();
			}
	  }
	function otherSpecify(option){
		
		if(option=="category")
		{
			if(document.getElementById("categoryOther").selected){
				document.getElementById("catoters").style.display = "block";
			}else {
				document.getElementById("catoters").style.display = "none";
				$("#menu_catothers").val('');
			}
			return false;
		}
	} 
	  
	function menuValidateNew()
     {
	   var txt = '';
		if(document.getElementById('restaurant_name').value == "") {
				$("#resNameErr").html("Please Select Restaurant Name");
				txt ='err';
			}else{
				$("#resNameErr").html("");
		}
		if(document.getElementById('menu_name').value == "") {
				$("#menuNameErr").html("Please enter Menu Name");
				txt ='err';
			}else{
				$("#menuNameErr").html("");
		}
		if(document.getElementById("menu_type").checked == false && document.getElementById("menu_type1").checked == false){
		       $("#menuTypeErr").html("Please check one Menu Type");
			   txt ='err';
		}else 
		{
		  $("#menuTypeErr").html("");	
		}
		if(document.getElementById("addonsval_yes").checked == false && document.getElementById("addonsval_no").checked == false){
		       $("#menu_addons_errormsg").html("Please check one Addons");
			   txt ='err';
		}else 
		 {
		  $("#menu_addons_errormsg").html("");	
		 } 
		 if(document.getElementById("menu_spl_ins1").checked == false && document.getElementById("menu_spl_ins2").checked == false){
		       $("#menu_special_errormsg").html("Please check one Menu Special Instruction");
			   txt ='err';
		}else 
		 {
		  $("#menu_special_errormsg").html("");	
		 } 
		 if(document.getElementById("menu_popular_yes").checked == false && document.getElementById("menu_popular_no").checked == false){
		       $("#menu_populardish_errormsg").html("Please check one Popular Dish ");
			   txt ='err';
		}else 
		 {
		  $("#menu_populardish_errormsg").html("");	
		 } 
		if(document.getElementById("menu_spicy_yes").checked == false && document.getElementById("menu_spicy_no").checked == false){
		       $("#spicy_errormsg").html("Please check one Spicy Dish");
			   txt ='err';
		}else 
		 {
		  $("#spicy_errormsg").html("");	
		 } 
		/*if(document.getElementById('menu_cuisine').value == "") {
				$("#menuCuisineErr").html("Please enter Menu Cuisine ");
				txt ='err';
			}else{
				$("#menuCuisineErr").html("");
		}*/
		
		if(document.getElementById('menu_category').value == "") {
				$("#caterrormsg").html("Please enter Menu Category");
				txt ='err';
			}else{
				$("#caterrormsg").html("");
		}
		if((document.getElementById('menu_category').value == "other") && (document.getElementById('menu_catothers').value == "")) {
				$("#menu_catothers_errormsg").html("Please enter other Category");
				txt ='err';
			}else{
				$("#menu_catothers_errormsg").html("");
		}
		if(document.getElementById('menu_description').value == "") {
				$("#menu_desc_errormsg").html("Please enter Menu Description");
				txt ='err';
			}else{
				$("#menu_desc_errormsg").html("");
		}
		/*if(document.getElementById('menu_photo').value == "") {
				$("#menu_photo_errormsg").html("Please upload photo");
				txt ='err';
			}else{
				$("#menu_photo_errormsg").html("");
		}*/
		if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		 return false;
	     }
	 } 
	 
<!-------------------- Tooltip---------->
		$(function() {
$( document ).tooltip();
});
</script>
 <div class="contain">
				<!--Menu start-->
								<div class="adminLeft">
	
	<div class="adminLeftInner">
		
		
		<div class="adminLeftBox indexRightTabContent"  id="index_restaurant_content" style="display:none;">
			<ul class="dashLeftBottomUl">
				<li>
					<label class="name">Total Restaurants</label>
					<label class="count">193</label>
				</li>
				<li>
					<label class="name">Active Restaurants</label>
					<label class="count">57</label>
				</li>
				<li>
					<label class="name">Inactive Restaurants</label>
					<label class="count">114</label>
				</li>
				<li>
					<label class="name">Pending Activation Restaurants</label>
					<label class="count">22</label>
				</li>
				<li>
					<label class="name">Restaurants joined this week</label>
					<label class="count">2</label>
				</li>
				<li>
					<label class="name">Restaurants joined this month</label>
					<label class="count">4</label>
				</li>
				<li>
					<label class="name">Restaurants joined this year</label>
					<label class="count">110</label>
				</li>
			</ul>
		</div>
	</div>
</div>								<!--Menu End-->
				<div class="adminRight">
<div class="rightContHeading Heading">Add Menu</div>
<div class="rightContBody">

	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
		<form name="addNewMenu" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return menuValidateNew();" enctype="multipart/form-data">
			<input type="hidden" name="menu_id" id="menu_id" value="<?php echo $menu_id;?>">
			<input type="hidden" name="action" value="Add">
			<!--Restaurant Name-->
						<div class="addPageCont">
				<span class="addPageRightFont">Restaurant Name<span class="color1">&nbsp;*</span></span>
				<span class="colon1">:</span>
				<select class="selectbx" name="restaurant_name" id="restaurant_name" onchange="changeRestaurant();" <?php if($_REQUEST['rest_id']){?> disabled="disabled" <?php }?>>
		     <option value="">Select</option>
					   <?php  while($restInfo = mysql_fetch_object( $result )){ ?>
			           <option value="<?php echo $restInfo->rest_id;?>" <?php if($resturant_id == $restInfo->rest_id){?> selected='selected' <?php }?> ><?php echo $restInfo->rest_name;?></option>
					   <?php }?>
			    </select>
				<div class="tooltip"><div class="HelpButton" title="Select restaurant name">?</div></div>
				<span class="errClass" id="resNameErr"><?= $err_restaurant_name ?></span>
			</div>
			
						<!--Menu Name1-->
			<div class="addPageCont">
				<span class="addPageRightFont">Menu Name <span class="color1">*</span></span>
				<span class="colon1">:</span>
				<input class="textbox" type="text" name="menu_name" id="menu_name" value="<?php echo $menu_name;?>" />
				<script>document.addNewMenu.menu_name.focus();</script>
				<div class="tooltip"><div class="HelpButton" title="Enter menu name">?</div></div>
				<span class="errClass" id="menuNameErr"><?= $err_menu_name ?></span>
			</div>
			
			<!--Menu Type-->
			<div class="addPageCont">
				<span class="addPageRightFont">Menu Type <span class="color1">*</span></span>
				<span class="colon1">:</span>
				<span class="radioBtn">	
					<input type="radio" name="menu_type" id="menu_type"	value="veg" <?php  echo ($menu_type == 'veg') ?  "checked" : "" ; ?> />&nbsp; Veg &nbsp;
					<input type="radio" name="menu_type" id="menu_type1" value="nonveg" <?php if($menu_type!= '' ){ echo ($menu_type == 'nonveg') ?  "checked" : "" ;}else{ echo "checked" ;}?> />&nbsp; Non-Veg
				</span>
				<div class="tooltip"><div class="HelpButton" title="Select any one menu type">?</div></div>
				<span class="errClass" id="menuTypeErr"><?= $err_menu_type ?></span>
			</div>
			<!--Menu Cuisine-->
			<div class="addPageCont">
				<span class="addPageRightFont">Menu Cuisine (Not mandatory Field)</span>
				<span class="colon1">:</span>
				<select class="selectbx" name="menu_cuisine" id="menu_cuisine" >
					<option value="">Select</option>
					<?php  while($rowCuisine = mysql_fetch_object( $resultCuisine )){ ?>
					<option value="<?php echo $rowCuisine->cuisine_id;?>" <?php if($cuisine_id == $rowCuisine->cuisine_id){?> selected='selected' <?php }?> ><?php echo $rowCuisine->cuisine_name;?></option>
					<?php }?>
				</select>
				<div class="tooltip"><div class="HelpButton" title="Select menu cusine name">?</div></div>
				<span class="errClass" id="menuCuisineErr"><?= $err_cuisine ?></span>
			</div>
			
						
			<div class="addPageCont">
					<span class="addPageRightFont">Menu Price</span>
					<span class="colon1">:</span>
					<span>
						<input type="radio" name="sizeoption" id="sizeoption_fixedprice" value="fixed" <?php if($sizeoption != '') { echo ($sizeoption == 'fixed') ?  "checked" : "" ;}else {echo "checked";}?> onclick="return fixedOption();"/>&nbsp;Fixed Price
						&nbsp;
						<!--<input type="radio" name="sizeoption" id="sizeoption_default" value="default" <?php echo ($sizeoption == 'default') ?  "checked" : "" ;?> onclick="return defaultOption();"/>&nbsp;Size-->
						&nbsp;
						<!--<input type="radio" name="sizeoption" id="sizeoption_other" value="other" <?php echo ($sizeoption == 'other') ?  "checked" : "" ;?> onclick="return otherOption();"/>&nbsp;Slice-->
					</span>
					
					<span id="fixedOption" <?php if($sizeoption == 'fixed'){ echo 'style="display:inline;"';}else { echo 'style="display:inline;"';}?>>
						<table width="70%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td align="left" width="16%" height="30">
									<input class="textbox" type="text" name="menu_price" id="menu_price" value="<?php echo $menu_price;?>" />
								</td>
							</tr>
						</table>
					</span>
					
					<span id="pizzaDefaultOption" <?php if($sizeoption == 'default'){ echo 'style="display:inline;"';}else { echo 'style="display:none;"';}?>>
						<table width="70%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td align="left" width="16%" height="30">
									<input type="checkbox" name="small" id="small" value="small" <?php echo ($small == 'small') ?  "checked" : "" ;?> onclick="showSmallPrice();" >&nbsp;Small &nbsp;
								</td>
								<td>	
									<span id="smallpriceshow"  <?php if($small == 'small'){ echo 'style="display:inline;"';}else { echo 'style="display:none;"';}?> >
									<input type="text" name="smallval" id="smallval" value="<?php echo $smallval; ?>" />&nbsp;</span><br />
								</td>
							</tr>
							
							<tr>
								<td align="left" width="16%" height="30">
									<input type="checkbox" name="medium" id="medium" value="medium" <?php echo ($medium == 'medium') ?  "checked" : "" ;?> onclick="showMediumPrice();" >&nbsp;Medium &nbsp;
								</td>
								<td>
									<span id="mediumpriceshow"  <?php if($medium == 'medium'){ echo 'style="display:inline;"';}else { echo 'style="display:none;"';}?> >
									<input type="text" name="mediumval" id="mediumval" value="<?php echo $mediumval; ?>" />&nbsp;</span><br />
								</td>
							</tr>
							
							<tr>
								<td align="left" width="16%" height="30">
									<input type="checkbox" name="large" id="large" value="large" <?php echo ($large == 'large') ?  "checked" : "" ;?> onclick="showLargePrice();" >&nbsp;Large &nbsp;
								</td>
								<td>
									<span id="largepriceshow"  <?php if($large == 'large'){ echo 'style="display:inline;"';}else { echo 'style="display:none;"';}?> >
									<input type="text" name="largeval" id="largeval" value="<?php echo $largeval; ?>" />&nbsp;</span>
								</td>
							</tr>
						</table>				
					</span>
					
					<span id="pizzaOtherOption" <?php if($sizeoption == 'other'){ echo 'style="display:inline;"';}else { echo 'style="display:none;"';}?>>
						<table width="70%" cellpadding="0" cellspacing="0" border="0">
						   <?php
							 if($sizename != '' && $sizeval != '')
                              {
                                 $sizeName = explode(',',$sizename);
								 $sizeVal = explode(',',$sizeval);
								 for($i=0;$i<count($sizeName);$i++)
                                  {								 
                            ?>	
							<tbody id="specialsize<?php echo $i;?>">
							  <tr>
							    <td class="left" height="30" width="50%"><input type="text" name="morepizzasize[<?php echo $i?>][sizename]" id="sizename[<?php echo $i?>]" value="<?php echo $sizeName[$i]; ?>" class="mar4"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="morepizzasize[<?php echo $i?>][sizevalue]" value="<?php echo $sizeVal[$i]; ?>" /></td>	
								<td class="left1"  height="30" width="20%" align="left"><a onclick="removeSlice('<?php echo $i;?>');" style="color:#f34571;cursor:pointer;margin-left:0px;"><span>Remove</span></a></td>
							  </tr>
							</tbody>
							<?php
							      }
							  } 
							?>
							  <tr <?php if($sizename != '' && $sizeval != ''){ echo 'style="display:none;"';}else { echo 'style="display:inline;"';} ?>>
									<td align="left" width="16%" height="30">
										<input type="text" name="sizename" id="sizename" value="" /> &nbsp;&nbsp;
										<input type="txt" name="sizevalue" id="sizevalue" value="" /> 
									</td>
							  </tr>
							  
						</table>						
						<label style="float:left; width:250px;">&nbsp;</label>
						<table id="specialPizzaSize" border="0" width="70%">
														<tfoot><tr>
							<td class="left" height="20">
								<a onclick="addMorePizzaSize('<?php if($sizename != ''){ echo count($sizeName);}else{ echo 0;}?>');" style="color:#f34571;cursor:pointer;margin-left:100px;"><span>Add More Slice</span></a>
							</td>
							</tr></tfoot>
						</table>
					</span>
					<span class="errClass" id="menuPriceErr"><?= $error_menu_price ?></span>
				</div>
			
						
			
			<!--Menu Price
			<div id="pizzaprice_menu">
				<div class="addPageCont">
					<span class="addPageRightFont">Menu Price <span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input class="textbox" type="text" name="menu_price" id="menu_price" value="" />
					<div class="tooltip"><div class="HelpButton">?</div><span>Enter menu price</span></div>
				</div>
			</div>-->
			
			<!--Menu Category-->
			<div class="addPageCont">
				<span class="addPageRightFont">Menu Category <span class="color1">*</span></span>
				<span class="colon1">:</span>
				  <?php
				   if($menu_id > 0)
					{
					 //echo 'asim';exit;
					 $_REQUEST['cat_id'] =$cat_id;
					// echo $_REQUEST['cat_id'];
				?>
					<select class="selectbx" name="menu_category" id="menu_category"  >
					    <?php
						$sqlCat = mysql_query("SELECT `cat_id`,`cat_name` FROM ".$prev."category WHERE status='Y' and rest_id='".$resturant_id."'");
						if(mysql_num_rows($sqlCat))
						{
						  while($rowCat = mysql_fetch_object($sqlCat))
						  {
						?>
						<option value="<?php echo $rowCat->cat_id;?>" <?php if($cat_id == $rowCat->cat_id){?> selected='selected' <?php }?> ><?php echo $rowCat->cat_name;?></option>
						  <?
						  }
						}else
                        {						
						  ?>
						<option value="" id="addCatMenu">Select</option>
						<option value="other" id="categoryOther" onclick="otherSpecify('category');">Others</option>
						<?php
						}
						?>
					</select>
				<?php
				    }else
					{
				?>
				<div id="addCatMenuViaAjax">
				<div id="addCatMenu">
				<select class="selectbx" name="menu_category" id="menu_category"  >
					<option value="" id="addCatMenu">Select</option>
					<option value="other" id="categoryOther" onclick="otherSpecify('category');">Others</option>
				</select>
				</div></div>
				<?php
				    }
				?>
				<div class="tooltip"><div class="HelpButton" title="Select menu category name">?</div></div>
				<span id="caterrormsg" class="errClass"><?= $err_menu_category_other ?></span>
			</div>
			<!--Other Category-->
			<div class="addPageCont" id="catoters" style="display:none;">
				<span class="addPageRightFont">&nbsp;</span>
				<span class="colon1">&nbsp;</span>
			    <input class="textbox" type="text" name="menu_catothers" id="menu_catothers" value="" />
			    <span id="menu_catothers_errormsg" class="errClass"><?= $menu_catothers ?></span>
	        </div>
			
			<!--Menu Addons-->
			<div class="addPageCont">
				<span class="addPageRightFont">Addons <span class="color1">*</span></span>
				<span class="colon1">:</span>
				<span class="radioBtn">
					<input type="radio" name="menu_addons" id="addonsval_yes" value="Yes" <?php echo ($menu_addons == 'Yes') ?  "checked" : "" ;?> onclick=" showAddons();"/>&nbsp;Yes&nbsp;
					<input type="radio" name="menu_addons" id="addonsval_no" value="No" <?php if($menu_addons != '') { echo ($menu_addons == 'No') ?  "checked" : "" ;}else{ echo "checked";}?> onclick="showAddons1();"/>&nbsp;No 
				</span>
				<div class="tooltip"><div class="HelpButton" title="Select Any one addons">?</div></div>
				<span id="menu_addons_errormsg" class="errClass"><?= $err_menu_addons ?></span>
			</div> 
			
			<div class="addPageCont">
				<div id="showcataddonsList" style="display:none;" >
					<span class="addPageRightFont">&nbsp;</span><span class="colon1">&nbsp;</span>
					<table width="70%" cellpadding="0" cellspacing="0" border="0">
										<input type="hidden" id="total" value="">
					</table>
					<div id="createbuttondiv" class="addtoCartInnerNew1"></div>
					<a onclick="addCreateMoreAddons();" style="color:#7DB82B;cursor:pointer;font-weight:bold;text-decoration:underline;" class="madAddons">Create Addons</a>
				</div>
			</div>
			
			<!--<div id="showcatPizzaAddonsList"  style="display:none;" >
			
				
			</div>-->
			
			<!--Menu Special Instruction-->
			<div class="addPageCont">
				<span class="addPageRightFont">Menu Special Instruction <span class="color1">*</span></span>
				<span class="colon1">:</span>
				<span class="radioBtn">
					<input type="radio" name="menu_spl_ins" id="menu_spl_ins1" value="Yes" <?php echo ($menu_spl_ins == 'Yes') ?  "checked" : "" ;?> />&nbsp; Yes &nbsp;
					<input type="radio" name="menu_spl_ins" id="menu_spl_ins2" value="No" <?php if($menu_addons != '') { echo ($menu_spl_ins == 'No') ?  "checked" : "" ;}else{ echo "checked";}?> />&nbsp; No  &nbsp;
				</span>
				<div class="tooltip"><div class="HelpButton" title="Select any one menu special instruction">?</div></div>
				<span id="menu_special_errormsg" class="errClass"><?= $err_menu_spl_ins?></span>
			</div>
			<!--Menu Description-->
			<div class="addPageCont">
				<span class="addPageRightFont">Menu Description <span class="color1">*</span></span>
				<span class="colon1">:</span>
				<textarea class="addPageTxtArea" name="menu_description" id="menu_description" /><?php echo $menu_description; ?></textarea>
				<div class="tooltip"><div class="HelpButton" title="Enter menu description">?</div></div>
				<span id="menu_desc_errormsg" class="errClass"><?= $err_menu_description?></span>
			</div>
			<!--Meno Photo -->
			<div class="addPageCont">
				<label class="addPageRightFont">Menu Photo <span class="color1">&nbsp;</span></label>
				<span class="colon1">:</span>
				<div class="logoUpload">
					<!--<div class="logo">-->
					<input class="fileUpload" type="file" name="menu_photo" id="menu_photo" size="31" />
											<!--</div>-->
				</div>
				<div class="tooltip"><div class="HelpButton" title="Upload menu photo">?</div><img src="<?php echo $vpath.$menu_photo?>" height="40" width="55" /></div>
				<span id="menu_photo_errormsg" class="errClass"><?= $menu_photo_errormsg?></span>
			</div>
			<!--Menu Popular dish-->
			<div class="addPageCont">
				<span class="addPageRightFont">Popular Dish <span class="color1">*</span></span>
				<span class="colon1">:</span>
				<span class="radioBtn">	
					<input type="radio" name="menu_popular_dish" id="menu_popular_yes"	value="Yes" <?php echo ($menu_popular_dish == 'Yes') ?  "checked" : "" ;?> />&nbsp; Yes &nbsp;
					<input type="radio" name="menu_popular_dish" id="menu_popular_no" value="No" <?php if($menu_popular_dish != '') { echo ($menu_popular_dish == 'No') ?  "checked" : "" ;}else{ echo "checked";}?> />&nbsp; No
				</span>
				<div class="tooltip"><div class="HelpButton" title="Select any one menu type">?</div></div>
				<span id="menu_populardish_errormsg" class="errClass"><?= $err_menu_popular_dish?></span>
			</div>
			<!--Menu Spicy-->
			<div class="addPageCont">
				<span class="addPageRightFont">Spicy Dish <span class="color1">*</span></span>
				<span class="colon1">:</span>
				<span class="radioBtn">	
					<input type="radio" name="menu_spicy" id="menu_spicy_yes"	value="Yes" <?php echo ($menu_spicy == 'Yes') ?  "checked" : "" ;?> />&nbsp; Yes &nbsp;
					<input type="radio" name="menu_spicy" id="menu_spicy_no" value="No" <?php if($menu_popular_dish != '') { echo ($menu_spicy == 'No') ?  "checked" : "" ;}else{ echo "checked";}?> />&nbsp; No
				</span>
				<div class="tooltip"><div class="HelpButton" title="Select any one menu type">?</div></div>
				<span id="spicy_errormsg" class="errClass"><?= $err_menu_spicy?></span>
			</div>
			
			<div class="buttonCont2">
				<input type="submit" class="button" name="addEdit" value="<?=($menu_id!=0)?'Update':'Add'?>"> 
				<a class="CanceButton" href="menuManage.php">Cancel</a>
			</div>
		</form>
	</div>
</div>
</div>
		</div>

<?
include("includes/footer.php");
?>
