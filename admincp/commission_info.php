<?php 
if(isset($_GET['rest_id']))
		{
			$rest_id=$_GET['rest_id'];
			//$_SESSION['rest_id']=$rest_id;
			$sql="SELECT * FROM ".$prev."resturant_comm_info WHERE rest_id='".$rest_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$rest_comm_per=$row->rest_comm_per;
			$rest_comm_time=$row->rest_comm_time;
		}
if(isset($_POST['COMM_INFO']) && $_POST['COMM_INFO']!='')
{
	if($_GET['rest_id']=="")
				{
$rest_id=$_SESSION['rest_id'];		
$sql_insert="INSERT INTO ".$prev."resturant_comm_info SET rest_comm_per='".mysql_real_escape_string($_POST['rest_comm_per'])."',rest_comm_time='".mysql_real_escape_string($_POST['rest_comm_time'])."',rest_id=".$rest_id;
$result=mysql_query($sql_insert);
if($result)
				   {
						    ?>
                        <script>
						$(function() {
						//$( "#tabs" ).tabs();
						$("#tabs").tabs({disabled: [0,1,2,3,4]});
						$("#tabs").tabs( "enable" , 5 ); 
						$('#tabs').tabs({ active: 5 });
						});
						</script>
                         <?php 
					 }
				}
		if($_GET['rest_id']<>"")
				{
$count_rows=mysql_num_rows(mysql_query("SELECT * FROM ".$prev."resturant_comm_info WHERE rest_id=".$_SESSION['rest_id']));
if($count_rows==0)
{
$sql_insert="INSERT INTO ".$prev."resturant_comm_info SET rest_comm_per='".mysql_real_escape_string($_POST['rest_comm_per'])."',rest_comm_time='".mysql_real_escape_string($_POST['rest_comm_time'])."',rest_id=".$_GET['rest_id'];
$result=mysql_query($sql_insert);
}
else
{
$sql_update="UPDATE ".$prev."resturant_comm_info SET rest_comm_per='".mysql_real_escape_string($_POST['rest_comm_per'])."',rest_comm_time='".mysql_real_escape_string($_POST['rest_comm_time'])."',rest_id=".$rest_id." WHERE rest_id=".$_GET['rest_id'];
$result=mysql_query($sql_update);
}
if($result)
				   {
						    ?>
                        <script>
						$(function() {
						//$( "#tabs" ).tabs();
						//$("#tabs").tabs({disabled: [0,1,2,3,4]});
						$("#tabs").tabs( "enable" , 5 ); 
						$('#tabs').tabs({ active: 5 });
						});
						</script>
                         <?php 
					 }
				}
}

?>
<script>
function addRestaurantCommValidate() {
	var txt = '';
	if(document.getElementById('rest_comm_time').value == "") {
			$("#resCommTimeErr").html("Please select Invoice Time Period");
			txt ='err';
		}else{
			$("#resCommTimeErr").html("");
	}
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}
</script>
<form name="addNewRestaurantComm" method="post" action="" onsubmit="return addRestaurantCommValidate();">

<div class="restInnerTab">
	<!--Restaurant Commission-->
	
	<div class="addPageCont">
		<span class="addPageRightFont">Restaurant Commission <!--<span class="color1">*</span>--></span>
		<span class="colon2">: (%) </span>
		<input class="textbox" type="text" name="rest_comm_per" id="rest_comm_per" value="<?=$rest_comm_per?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant commission (%)">?</div></div>
		<span class="errClass" id="resCommErr"></span>
	</div>
	
	<div class="addPageCont">
		<span class="addPageRightFont">Invoice Time Period <span class="color1">*</span></span>
		<span class="colon2">: (%) </span>
		
		<select class="selectbx" name="rest_comm_time" id="rest_comm_time">
            <option value="">--Select--</option>
			<option value="Monthly" <?php if($rest_comm_time=="Monthly"){?> selected="selected" <?php }?>>Monthly</option>
			<option value="Monthly Twice" <?php if($rest_comm_time=="Monthly Twice"){?> selected="selected" <?php }?>>Monthly Twice</option>
			<option value="Monthly 4 Times" <?php if($rest_comm_time=="Monthly 4 Times"){?> selected="selected" <?php }?>>Monthly 4 Times</option>
		</select>
		
		<span class="errClass" id="resCommTimeErr"></span>
	</div>
	
</div>
 <div class="buttonCont_restaurant">
			<input type="submit" class="button" value="<?=($rest_id!=0)?'Update':'Add'?>" name="COMM_INFO"> 
			<a class="CanceButton" href="restaurantManage.php">Cancel</a>
		</div>
		</form>