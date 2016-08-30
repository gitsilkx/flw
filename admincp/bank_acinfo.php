<?php 
if(isset($_GET['rest_id']))
		{
			$rest_id=$_GET['rest_id'];
			//$_SESSION['rest_id']=$rest_id;
			$sql="SELECT * FROM ".$prev."resturant_bank_acct WHERE rest_id='".$rest_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$rest_bank_name=$row->rest_bank_name;
			$rest_bank_acno=$row->rest_bank_acno;
			$rest_routine_no=$row->rest_routine_no;
			$rest_swift_code=$row->rest_swift_code;
		}
if(isset($_POST['BANK_AC']) && $_POST['BANK_AC']!='')
{
		if($_GET['rest_id']=="")
				{
$rest_id=$_SESSION['rest_id'];	
$sql_insert="INSERT INTO ".$prev."resturant_bank_acct SET rest_bank_name='".mysql_real_escape_string($_POST['res_bank_name'])."',rest_bank_acno='".mysql_real_escape_string($_POST['res_ac_no'])."',rest_routine_no='".mysql_real_escape_string($_POST['res_routine_no'])."',rest_swift_code='".mysql_real_escape_string($_POST['res_swift_code'])."',rest_id=".$rest_id;
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
						$("#resBankNameErr").html("All Restaurant Data Entered Successfully !!");
						});
						</script>
                         <?php 
					 }
				}
		if($_GET['rest_id']<>"")
				{
$count_rows=mysql_num_rows(mysql_query("SELECT * FROM ".$prev."resturant_bank_acct WHERE rest_id=".$_SESSION['rest_id']));
if($count_rows==0)
{
	$sql_insert="INSERT INTO ".$prev."resturant_bank_acct SET rest_bank_name='".mysql_real_escape_string($_POST['res_bank_name'])."',rest_bank_acno='".mysql_real_escape_string($_POST['res_ac_no'])."',rest_routine_no='".mysql_real_escape_string($_POST['res_routine_no'])."',rest_swift_code='".mysql_real_escape_string($_POST['res_swift_code'])."',rest_id=".$_GET['rest_id'];
$result=mysql_query($sql_insert);
}
else
{
					$sql_update="UPDATE  ".$prev."resturant_bank_acct SET rest_bank_name='".mysql_real_escape_string($_POST['res_bank_name'])."',rest_bank_acno='".mysql_real_escape_string($_POST['res_ac_no'])."',rest_routine_no='".mysql_real_escape_string($_POST['res_routine_no'])."',rest_swift_code='".mysql_real_escape_string($_POST['res_swift_code'])."',rest_id=".$rest_id." WHERE rest_id=".$_GET['rest_id'];
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
						$("#resBankNameErr").html("All Restaurant Data Updated Successfully !!");
						});
						</script>
                         <?php 
					 }
				}
}

?>
<script>
function addRestaurantBankValidate() {
	var txt = '';
	if(document.getElementById('res_bank_name').value == "") {
			$("#resBankNameErr").html("Please enter Bank Name");
			txt ='err';
		}else{
			$("#resBankNameErr").html("");
	}
	if(document.getElementById('res_ac_no').value == "") {
			$("#resAcErr").html("Please enter Bank A/C No");
			txt ='err';
		}else{
			$("#resAcErr").html("");
	}
	if(document.getElementById('res_routine_no').value == "") {
			$("#resRoutErr").html("Please enter Bank Routine No");
			txt ='err';
		}else{
			$("#resRoutErr").html("");
	}
	if(document.getElementById('res_swift_code').value == "") {
			$("#resSwiftErr").html("Please enter Swift Code");
			txt ='err';
		}else{
			$("#resSwiftErr").html("");
	}
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}
</script>
<form name="addNewBankRestaurant" method="post" action="" onsubmit="return addRestaurantBankValidate();" >

<div class="restInnerTab">
	<!--Restaurant Commission-->
	
	<div class="addPageCont">
		<span class="addPageRightFont">Bank Name <span class="color1">*</span></span>
		<span class="colon2">:</span>
		<input class="textbox" type="text" name="res_bank_name" id="res_bank_name" value="<?=$rest_bank_name?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter Bank Name">?</div></div>
		<span class="errClass" id="resBankNameErr"></span>
	</div>
	
	<div class="addPageCont">
		<span class="addPageRightFont">Bank A/C No <span class="color1">*</span></span>
		<span class="colon2">:</span>
		<input class="textbox" type="text" name="res_ac_no" id="res_ac_no" value="<?=$rest_bank_acno?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter Bank Name">?</div></div>
		<span class="errClass" id="resAcErr"></span>
	</div>
	
	<div class="addPageCont">
		<span class="addPageRightFont">Routine No <span class="color1">*</span></span>
		<span class="colon2">:</span>
		<input class="textbox" type="text" name="res_routine_no" id="res_routine_no" value="<?=$rest_routine_no?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter Routine No">?</div></div>
		<span class="errClass" id="resRoutErr"></span>
	</div>
	
	<div class="addPageCont">
		<span class="addPageRightFont">Swift Code <span class="color1">*</span></span>
		<span class="colon2">:</span>
		<input class="textbox" type="text" name="res_swift_code" id="res_swift_code" value="<?=$rest_swift_code?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter Swift Code">?</div></div>
		<span class="errClass" id="resSwiftErr"></span>
	</div>
	
</div>
 <div class="buttonCont_restaurant">
			<input type="submit" class="button" value="<?=($rest_id!=0)?'Update':'Add'?>" name="BANK_AC"> 
			<a class="CanceButton" href="restaurantManage.php">Cancel</a>
		</div>
		</form>