<?php
if(isset($_GET['rest_id']))
		{
			$rest_id=$_GET['rest_id'];
			$_SESSION['rest_id']=$rest_id;
			$sql="SELECT * FROM ".$prev."resturant_delivery_info WHERE rest_id='".$rest_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$restaurant_del=$row->rest_del;
			$restaurant_time=$row->rest_time;
			$restaurant_delcharge=$row->rest_del_charge;
			$restaurant_deldist=$row->rest_del_dist;
		} 
if(isset($_POST['DEL_INFO']) && $_POST['DEL_INFO']!='')
{
if($_GET['rest_id']=="")
				{
$rest_id=$_SESSION['rest_id'];		
$sql_insert="INSERT INTO ".$prev."resturant_delivery_info SET rest_del='".mysql_real_escape_string($_POST['rest_del'])."',
rest_time='".mysql_real_escape_string($_POST['rest_time'])."',rest_del_charge='".mysql_real_escape_string($_POST['rest_del_charge'])."',rest_del_dist='".mysql_real_escape_string($_POST['rest_del_dist'])."',rest_id=".$rest_id;
$result=mysql_query($sql_insert);
if($result)
				   {
						    ?>
                        <script>
						$(function() {
						//$( "#tabs" ).tabs();
						$("#tabs").tabs({disabled: [0,1,2,4,5]});
						$("#tabs").tabs( "enable" , 3 ); 
						$('#tabs').tabs({ active: 3 });
						});
						</script>
                         <?php 
					 }
				}
if($_GET['rest_id']<>"")
        {
$count_rows=mysql_num_rows(mysql_query("SELECT * FROM ".$prev."resturant_delivery_info WHERE rest_id=".$_SESSION['rest_id']));
if($count_rows==0)
{
	$sql_insert="INSERT INTO ".$prev."resturant_delivery_info SET rest_del='".mysql_real_escape_string($_POST['rest_del'])."',
rest_time='".mysql_real_escape_string($_POST['rest_time'])."',rest_del_charge='".mysql_real_escape_string($_POST['rest_del_charge'])."',rest_del_dist='".mysql_real_escape_string($_POST['rest_del_dist'])."',rest_id=".$_GET['rest_id'];
$result=mysql_query($sql_insert);
}
else
{
$rest_id=$_SESSION['rest_id'];		
$sql_update="UPDATE ".$prev."resturant_delivery_info SET rest_del='".mysql_real_escape_string($_POST['rest_del'])."',
rest_time='".mysql_real_escape_string($_POST['rest_time'])."',rest_del_charge='".mysql_real_escape_string($_POST['rest_del_charge'])."',rest_del_dist='".mysql_real_escape_string($_POST['rest_del_dist'])."',rest_id=".$rest_id." WHERE rest_id=".$_GET['rest_id'];
$result=mysql_query($sql_update);
}
if($result)
				   {
						    ?>
                        <script>
						$(function() {
						//$( "#tabs" ).tabs();
						//$("#tabs").tabs({disabled: [0,1,2,4,5]});
						$("#tabs").tabs( "enable" , 3 ); 
						$('#tabs').tabs({ active: 3 });
						});
						</script>
                         <?php 
					 }
				
		}
}

?>
<script>
function addRestaurantDelInfoValidate() {
	var txt = '';
	if(document.getElementById('rest_del_dist').value == "") {
			$("#restdelDistanceErr").html("Please enter Delivery Distance");
			txt ='err';
		}else{
			$("#restdelDistanceErr").html("");
	}
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}
</script>
<form name="addNewRestaurantDelInfo" method="post" action="" onsubmit="return addRestaurantDelInfoValidate();" >

<div class="restInnerTab">
	<!--Restaurant Delivery-->
	<!--<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>-->
	<div class="addPageCont">
		<span class="addPageRightFont">Delivery </span>
		<span class="colon1">:</span>
		<span class="radioBtn">
		<span class="labelcont"><input class="radiobotton" type="radio" name="rest_del" id="restaurant_delivery_yes" value="Yes"  <?=($restaurant_del=='Yes')?'checked':''?>/><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
		<span class="labelcont"><input class="radiobotton" type="radio" name="rest_del" id="restaurant_delivery_no" value="No" <?=($restaurant_del=='No')?'checked':''?> /><label class="labelfont" for="no">&nbsp;No</label></span>
		</span>
		<div class="tooltip"><div class="HelpButton" title="Select any one restaurant delivery option">?</div></div>
	</div>
	
	<!--Restaurant Delivery estimated time-->
	<div class="addPageCont">
		<span class="addPageRightFont">Restaurant delivery estimated time </span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="rest_time" id="rest_time" value="<?=$restaurant_time?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant delivery estimated time">?</div></div>
		<span class="errClass" id="resEstTimeErr"></span>
	</div>
	
	<!--Restaurant Delivery charge-->
	<div class="addPageCont">
		<span class="addPageRightFont">Delivery Charge </span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="rest_del_charge" id="rest_del_charge" value="<?=$restaurant_delcharge?>"  onfocus="this.value=''"   />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant delivery charge">?</div></div>
		<span class="errClass" id="resDeliChgErr"></span>
	</div>
	
	<!--Restaurant Delivery Distance-->
	<div class="addPageCont">
		<span class="addPageRightFont">Delivery Distance (miles) <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="rest_del_dist" id="rest_del_dist" value="<?=$restaurant_deldist?>"  onfocus="this.value=''"   />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant delivery distance">?</div></div>
		<a href="javascript:void(0);" onclick="viewMap();" id="view_map">click to view map</a>
        <span class="errClass" id="restdelDistanceErr"></span>
		
	</div>
	
		
	<!--Restaurant Delivery Areas-->
		
</div>
 <div class="buttonCont_restaurant">
			<input type="submit" class="button" value="<?=($rest_id!=0)?'Update':'Add'?>" name="DEL_INFO"> 
			<a class="CanceButton" href="restaurantManage.php">Cancel</a>
		</div>
		</form>