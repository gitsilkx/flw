<?php
session_start();
include("includes/access.php");
include("includes/header.php");
$msg="";
if($_POST["DEVCODE"])
{
	if($_POST['id']=="")
	{
		
	        $insert_query = "INSERT INTO " .$prev."delivery_code SET 
	       	delivery_code='" . mysql_real_escape_string($_POST['delivery_code']) .  "',
			city_id='".$_POST['city_id']."',
			state_id='".$_POST['state_id']."',
			zip_id='".$_POST['zip_id']."',
		    cur_date= now(),
		    status='".$_POST['status']."'";		
			$r=mysql_query($insert_query) or die("Error :". mysql_error());
			$_SESSION['succ_message']='Delivery code added successfully';
			pageRedirect('delivery_code_list.php?menuid=135&menupid=113');
	}
   	else
	{
   		$upd_query = "UPDATE " .$prev."delivery_code SET 
		delivery_code='" . mysql_real_escape_string($_POST['delivery_code']) .  "',
		city_id='" . $_POST['city_id'] .  "',
		state_id='" . $_POST['state_id'] .  "',
		zip_id='".$_POST['zip_id']."',
		status='".$_POST['status']."',
		cur_date= now() WHERE id=".$_POST['id'];
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
		$_SESSION['succ_message']='Delivery code updated successfully';
		pageRedirect('delivery_code_list.php?menuid=135&menupid=113');
	   
	}
	
   	  
   
 }	
#if product exists /fetch data
if($_GET['id'])
{
	$id=$_GET['id'];
	$r=mysql_query("SELECT * FROM ".$prev."delivery_code WHERE id=" . $id);
	$d=@mysql_fetch_array($r);
	$status = $d['status'];
}

/*if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;*/

?>
 <script>
	$(document).ready(function(){
	$('#state_id').change(function(){
		var state_id=$(this).val(); 
	  	var dataString='state_id='+state_id;
				 $.ajax({
					type:"POST",
					data:dataString,
					url:"<?=$vpath?>ajax/get_city.php",
					success:function(return_data)
					{
						//alert(return_data);
						$('#ajax_city').html(return_data);
					}
				});
			
		});
		
	});		
		
function addRestaurantZipValidate() {
	//alert('aaaaaa');
	var txt = '';
	if(document.getElementById('delivery_code').value == "") {
			$("#resNamePerErr").html("Please enter Delivery Code");
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
	if(document.getElementById('city_id').value == "") {
			$("#resNameValToErr").html("Please enter City Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameValToErr").html("");
	}
		if(document.getElementById('zip_id').value == "") {
			$("#zipCodeValToErr").html("Please select Zip Code");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#zipCodeValToErr").html("");
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
<div class="rightContHeading Heading"> Add New Delivery Code</div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
	  <form name="addNewResOffr" method="post" action="" onsubmit=" return addRestaurantZipValidate(); " >
			<input type="hidden" name="id" id="id" value="<?=$_GET['id']?>">
	    <!--<input type="hidden" name="resid" id="resid" value="">
			<input type="hidden" name="action" value="Add">-->
									
						
			<div class="addPageCont">
					<span class="addPageRightFont">Delivery Code  <span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input name="delivery_code" type="text" id="delivery_code" class="textbox" value="<?=$d['delivery_code']?>" />
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter Delivery Code">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
		</div>
			
			<div class="addPageCont">
					<span class="addPageRightFont">State Name <span class="color1">*</span></span>
					<span class="colon1">:</span>
					       <?
    $sql_state="SELECT * FROM ".$prev."state WHERE status='Y'";
	$res=mysql_query($sql_state);
	?>
    <select name="state_id" id="state_id" class="selectbx">
    <option value="">--Select State--</option>
    <?
    while($row=mysql_fetch_array($res))
	{
	?>
    <option value="<?=$row['state_id']?>" <?=($row['state_id']==$d['state_id'])?"selected":""?>> <?=$row['state_name']?> </option>
    <?
	}
	?>
    </select>
					<div class="realtive">
						<div class="absolute1">
							<div class="tooltip"><div class="HelpButton" title="Select State Name">?</div></div>
						</div>
					</div>
                    <span class="errClass" id="resNameValFroErr"></span>
			</div>

			
			<div class="addPageCont">
					<span class="addPageRightFont">City Name<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<div id="ajax_city">
				   <?
                $sql_city="SELECT * FROM ".$prev."city WHERE status='Y'";
                $res11=mysql_query($sql_city);
                ?>
                <select name="city_id" id="city_id" class="selectbx">
                <option value="">--Select City--</option>
                <?
                while($row11=mysql_fetch_array($res11))
                {
                ?>
                <option value="<?=$row11['city_id']?>" <?=($row11['city_id']==$d['city_id'])?"selected":""?>> <?=$row11['city_name']?> </option>
                <?
                }
                ?>
                </select>	
    			</div>
					<div class="realtive">
						<div class="absolute1">
							<div class="tooltip"><div class="HelpButton" title="Select City Name">?</div></div>
						</div>
					</div>
                    <span class="errClass" id="resNameValToErr"></span>
			</div>
            
            <div class="addPageCont">
					<span class="addPageRightFont">Zip Code<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<div id="ajax_zip">
				   <?
              $sql=mysql_query("SELECT `zip_id`,`area_name`,`zip_code` FROM ".$prev."zip WHERE status='Y'");
						if(mysql_num_rows($sql)){
                
                ?>
                <select name="zip_id" id="zip_id" class="selectbx">
                <option value="">--Select Zip--</option>
                <?
              while($row=mysql_fetch_object($sql)){?>
              
                	<option value="<?= $row->zip_id?>" <?=($row->zip_id==$d['zip_id'])?"selected":""?> ><?= $row->zip_code.' - '.$row->area_name;?></option>  
                
                <?
				}
                }
                ?>
                </select>	
    			</div>
					<div class="realtive">
						<div class="absolute1">
							<div class="tooltip"><div class="HelpButton" title="Select Zip Code">?</div></div>
						</div>
					</div>
                    <span class="errClass" id="zipCodeValToErr"></span>
			</div>
            
            <div class="addPageCont">
                <span class="addPageRightFont">Status </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_yes" value="Y"  <?=($status=='Y')?'checked':''?> checked="checked"/><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_no" value="N"<?=($status=='N')?'checked':''?>  /><label class="labelfont" for="no">&nbsp;No</label></span>
                </span>
                <div class="tooltip"><div class="HelpButton" title="Select any one status option">?</div></div>
            </div>
			
			<div class="buttonCont2">
			  <input type="submit" class="button" name="DEVCODE" value="<?=($_GET['id']!="")?"Update":"Add"?>" >
				<a class="CanceButton" href="delivery_code_list.php?menuid=135&menupid=113">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
	  </form>
	</div>
</div>
</div>

<?
include("includes/footer.php");
?>
