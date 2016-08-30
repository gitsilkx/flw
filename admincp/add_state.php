<?php
session_start();
include("includes/access.php");
include("includes/header.php");
if(isset($_GET['state_id']))
		{
			$state_id=$_GET['state_id'];
			$sql="SELECT * FROM ".$prev."state WHERE state_id='".$state_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$state_id=$row->state_id;
			$state_code=$row->state_code;
			$state_name=$row->state_name;
			$cur_date = $row->cur_date;
			//$cur_date=date("m/d/Y",strtotime($row->cur_date));
			//state_valid_to=date("m/d/Y",strtotime($row->state_valid_to));
			$status=$row->status;
		}
if(isset($_POST['state_id']))
{
	//$cur_date= date("Y-m-d",strtotime(mysql_real_escape_string($_POST['state_valid_from'])));
	//$state_valid_to= date("Y-m-d",strtotime(mysql_real_escape_string($_POST['state_valid_to'])));
	$status=mysql_real_escape_string($_POST['status']);
	if($_POST['state_id']=="")
	{	
		$sql_state_insert=mysql_query("INSERT INTO ".$prev."state SET 
		state_id='".mysql_real_escape_string($_POST['state_id'])."',
		state_code='".mysql_real_escape_string($_POST['state_code'])."',
		state_name='".mysql_real_escape_string($_POST['state_name'])."',
		cur_date='".$cur_date."',
		status='".$status."'");
		if($sql_state_insert)
		{
		$_SESSION['succ_message']="New State Inserted Successfully !!";
		pageRedirect('manage_state.php?menuid=107&menupid=103');
		}
	}
	if($_POST['state_id']!="")
	{
		
		$sql_state_update=mysql_query("UPDATE ".$prev."state SET 
		state_id='".mysql_real_escape_string($_POST['state_id'])."',
		state_code='".mysql_real_escape_string($_POST['state_code'])."',
		state_name='".mysql_real_escape_string($_POST['state_name'])."',
		cur_date='".$cur_date."',
		status='".$status."' WHERE state_id=".$_POST['state_id']);
		if($sql_state_update)
		{
		$_SESSION['succ_message']="State Updated Successfully !!";
		pageRedirect('manage_state.php?menuid=107&menupid=103');
		}
	}
}

?>
 <script>
$(function() {
$( "#state_valid_from" ).datepicker();
$( "#state_valid_to" ).datepicker();
});
function addstateaurantstateValidate() {
	//alert('aaaaaa');
	var txt = '';
	if(document.getElementById('state_').value == "") {
			$("#resNamestateErr").html("Please select State  Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamestateErr").html("");
	}
	if(document.getElementById('state_percentage').value == "") {
			$("#resNamePerErr").html("Please enter state Percentage");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamePerErr").html("");
	}
	if(document.getElementById('state_price').value == "") {
			$("#resNamePriErr").html("Please enter state Price");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamePriErr").html("");
	}
	if(document.getElementById('state_valid_from').value == "") {
			$("#resNameValFroErr").html("Please enter Valid From");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameValFroErr").html("");
	}
	if(document.getElementById('state_valid_to').value == "") {
			$("#resNameValToErr").html("Please enter Valid To");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameValToErr").html("");
	}
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}
</script>

  <div class="adminRight">
<div class="rightContHeading Heading"> Add New State</div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
		<form name="addNewState" method="post" action="" onsubmit=" return addRestaurantOfferValidate(); " >
			<input type="hidden" name="state_id" id="state_id" value="<?=$_GET['state_id']?>">
			<!--<input type="hidden" name="resid" id="resid" value="">
			<input type="hidden" name="action" value="Add">-->
									<div class="addPageCont">
				<span class="addPageRightFont">State Name <span class="color1">*</span></span>
				<span class="colon1">:</span>
                <input class="textbox" type="text" name="state_code" id="state_code" value="<?=$state_name?>" />		<div class="tooltip"><div class="HelpButton">?</div><span>Enter State Name</span></div>
				
				<span class="errClass" id="resNameOfferErr"></span>
			</div>
						
			<div class="addPageCont">
					<span class="addPageRightFont">State Code<span class="color1">*</span></span>
					<span class="colon1">:</span>
			        <input class="textbox" type="text" name="state_code" id="state_code" value="<?=$state_code?>" />
					<script type="text/javascript">document.addNewState.state_code.focus();</script>
					<div class="tooltip"><div class="HelpButton">?</div><span>Enter State Code</span></div>
					<!--<input type="hidden" name="state_id" id="state_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
			</div>
			        
            <div class="addPageCont">
                <span class="addPageRightFont">Status </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_yes" value="Y"  <?=($status=='Y')?'checked':''?> checked="checked"/><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_no" value="N"<?=($status=='N')?'checked':''?>  /><label class="labelfont" for="no">&nbsp;No</label></span>
                </span>
                <div class="tooltip"><div class="HelpButton">?</div><span>Select Any One pickup option</span></div>
            </div>
			
			<div class="buttonCont2">
				<input type="submit" class="button" name="OFFER" value="<?=($_GET['state_id']!="")?"Update":"Add"?>" >
				<a class="CanceButton" href="add_state.php">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
		</form>
	</div>
</div>
</div>

<?
include("includes/footer.php");
?>
