<?php
include("includes/access.php");
include("includes/header.php");


 //$msg="";
if(isset($_POST["CITY"]))
{
	if($_POST['city_id']=="")
	{
           
	        $insert_query = "INSERT INTO " .$prev."city SET 
	       	city_name='". mysql_real_escape_string($_POST['city_name']) ."',
                    tag='". mysql_real_escape_string($_POST['city_name']) ."',
                    city1='". mysql_real_escape_string($_POST['city1']) ."',
			state='".$_POST['state']."',
                            url='".$_POST['url']."',
	        cur_date= now(),
		    status='". mysql_real_escape_string($_POST['status']) ."'";		
			$r=mysql_query($insert_query) or die("Error :". mysql_error());
			$_SESSION['succ_message']='City added successfully';
			pageRedirect('city.list.php?menuid=116&menupid=113');
	}
   	else
	{
   		$upd_query = "UPDATE " .$prev."city SET 
		city_name='" . mysql_real_escape_string($_POST['city_name']) .  "',
                    tag='". mysql_real_escape_string($_POST['city_name']) ."',
                        city1='". mysql_real_escape_string($_POST['city1']) ."',
		state='" . $_POST['state'] .  "',
		status='". mysql_real_escape_string($_POST['status']) ."'
		WHERE city_id='".$_POST['city_id']."'	";
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
		$_SESSION['succ_message']='City updated successfully..';
		pageRedirect('city.list.php?menuid=116&menupid=113');
	   
	}
	
   	  
   
 }	
#if product exists /fetch data
if($_GET['city_id'])
{
	$city_id=$_GET['city_id'];
	$r=mysql_query("SELECT * FROM ".$prev."city WHERE city_id=" . $city_id);
	$d=@mysql_fetch_array($r);
	$status = $d['status'];
}

/*if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;*/

?>
	
<!--Script for validation-->
<script language="javascript">
function addRestaurantOfferValidate() {
	//alert('aaaaaa');
	var txt = '';
	if(document.getElementById('city_name').value == "") {
			$("#resNamePerErr").html("Please enter City Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamePerErr").html("");
	}
	if(document.getElementById('state_id').value == "") {
			$("#resNameValFroErr").html("Please select State Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameValFroErr").html("");
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
<div class="rightContHeading Heading"> Add New City</div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
	  <form name="addNewResOffr" method="post" action="" onsubmit="return addRestaurantOfferValidate(); " >
			<input type="hidden" name="city_id" id="city_id" value="<?=$_GET['city_id']?>">
	    <!--<input type="hidden" name="resid" id="resid" value="">
			<input type="hidden" name="action" value="Add">-->
									
						
			<div class="addPageCont">
					<span class="addPageRightFont">City Name  <span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input name="city_name" type="text" id="city_name" class="textbox" value="<?=$d['city_name']?>" />
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter City Name ">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
		</div>
                        <div class="addPageCont">
					<span class="addPageRightFont">Sate Name  <span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input name="state" type="text" id="city_name" class="textbox" value="<?=$d['state']?>" />
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter Sate Name ">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
		</div>
                        <div class="addPageCont">
					<span class="addPageRightFont">Url  <span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input name="url" type="text" id="city_name" class="textbox" value="<?=$d['url']?>" />
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter Url ">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
		</div>
                        <div class="addPageCont">
					<span class="addPageRightFont">City1</span>
					<span class="colon1">:</span>
					<input name="city1" type="text" id="city_name" class="textbox" value="<?=$d['city1']?>" />					
					<div class="tooltip"><div class="HelpButton" title="Enter City ">?</div></div>				
                  
		</div>
			
			
			
		
			<span class="errClass" id="resNameValToErr"></span>
            <div class="addPageCont">
                <span class="addPageRightFont">Status </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_yes" value="Y"  <?=($status=='Y')?'checked':''?> checked="checked"/><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_no" value="N"<?=($status=='N')?'checked':''?>  /><label class="labelfont" for="no">&nbsp;No</label></span>
              </span>
                <div class="tooltip"><div class="HelpButton" title="Select any one status pickup option">?</div></div>
        </div>
			
			<div class="buttonCont2">
			  <input type="submit" class="button" name="CITY" value="<?=($_GET['city_id']!="")?"Update":"Add"?>" >
				<a class="CanceButton" href="city.entryform.php?menuid=116&menupid=113">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
	  </form>
	</div>
</div>
</div>
<?
include("includes/footer.php");
?>
