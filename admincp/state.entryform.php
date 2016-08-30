<?php
include("includes/access.php");
include("includes/header.php");

$msg="";
if(isset($_POST['STATE']))
{
//$state_desc=$_POST['state_id'];
	if($_POST['state_id']=="")
	{
		
	        $insert_query = "INSERT INTO " .$prev."state SET 
	        state_code='" . mysql_escape_string($_POST['state_code']) .  "',
			state_name= '" . mysql_escape_string($_POST['state_name']) . "',
		    cur_date= now(),
			status='" . mysql_escape_string($_POST['status']) . "'";		
			$r=mysql_query($insert_query) or die("Error :". mysql_error());
			//$state_id=mysql_insert_id();
			$_SESSION['succ_message']='State added successfully';
			pageRedirect('state.list.php?menuid=116&menupid=113');
	}
   	else
	{
   		$upd_query = "UPDATE " .$prev."state SET 
		state_code='" . mysql_escape_string($_POST['state_code']) .  "',
		state_name='" . mysql_escape_string($_POST['state_name']) .  "',
		cur_date= now(),
		status='".mysql_escape_string($_POST['status']) ."'
		where state_id='".$_POST['state_id']."'	";
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
		$_SESSION['succ_message']='State updated successfully';
		pageRedirect('state.list.php?menuid=116&menupid=113');
	   
	}
	
   	  
   
 }	
#if product exists /fetch data
if($_GET['state_id']!='')
{
	$state_id=$_GET['state_id'];
	$r=mysql_query("SELECT * FROM ".$prev."state WHERE state_id=" . $state_id);
	$d=@mysql_fetch_array($r);
	$status = $d['status'];
}

/*if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;*/



?>
 
<!--Script for validation-->
<script language="javascript">
function addRestaurantStateValidate() {
	//alert('aaaaaa');
	var txt = '';
	if(document.getElementById('state_name').value == "") {
			$("#resNamePerErr").html("Please select State Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamePerErr").html("");
	}
	if(document.getElementById('state_code').value == "") {
			$("#resNamePriErr").html("Please select State Code");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamePriErr").html("");
	}
	
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}

	
</script>
<script>
$(function() {
$( document ).tooltip();
});
</script>
	<div class="adminRight">
<div class="rightContHeading Heading"> Add New State </div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
	  <form name="addNewResOffr" method="post" action="" onsubmit="return addRestaurantStateValidate(); " >
			<input type="hidden" name="state_id" id="state_id" value="<?=$_GET['state_id']?>">
	    <!--<input type="hidden" name="resid" id="resid" value="">
			<input type="hidden" name="action" value="Add">-->
									
						
			<div class="addPageCont">
					<span class="addPageRightFont">State Name  <span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input name="state_name" type="text" id="state_name" class="textbox" value="<?=$d['state_name']?>" />
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip" ><div class="HelpButton" title="Enter State Name">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
		</div>
			
			<div class="addPageCont">
					<span class="addPageRightFont">State Code<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input name="state_code" type="text" id="state_code" class="textbox" value="<?=$d['state_code']?>" />
			  <div class="tooltip"><div class="HelpButton" title="Enter State Code">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
		</div>
			
			
			<div class="addPageCont">
                <span class="addPageRightFont">Status </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_yes" value="Y"  <?=($status=='Y')?'checked':''?> checked="checked"/><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_no" value="N"<?=($status=='N')?'checked':''?>  /><label class="labelfont" for="no">&nbsp;No</label></span>
                </span>
                <div class="tooltip"><div class="HelpButton" title="Select any one  pickup option">?</div></div>
            </div>
			
			<div class="buttonCont2">
			  <input type="submit" class="button" name="STATE" value="<?=($_GET['state_id']!="")?"Update":"Add"?>" >
				<a class="CanceButton" href="state.list.php?menuid=116&menupid=113">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
	  </form>
	</div>
</div>
</div>
<?
include("includes/footer.php");
?>
